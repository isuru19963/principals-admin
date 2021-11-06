<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Books;
use App\BuyBook;
use App\Doctor;
use App\DrArticles;
use App\DrYotube;
use App\Frontend;
use App\GeneralSetting;
use App\Language;
use App\Location;
use App\Page;
use App\Sector;
use App\Subscriber;
use App\SupportAttachment;
use App\SupportMessage;
use App\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\Controller;
use App\Patient;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Response;
class SiteController extends Controller
{    private $sector;
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();

        if($count == 0){
            $in['tempname'] = $this->activeTemplate;
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;

        return view($this->activeTemplate . 'pages', $data);
    }

    public function login()
    {
        $page_title = 'Login';
        return view($this->activeTemplate . 'login',compact('page_title'));
    }
    public function blog()
    {
        $data['page_title'] = 'Blog';
        $data['blog_element'] = Frontend::where('data_keys','blog.element')->latest()->paginate(9);
        return view($this->activeTemplate . 'blog', $data);
    }

    public function booking($id){

        $doctor = Doctor::findOrFail($id);
        if(Auth::guard('patient')->user()==null){
            $notify[] = ['error', 'Please Login to Book Doctor'];
            return redirect()->route('doctors.all')->withNotify($notify);
        }
        if ($doctor->status == 0) {
            $notify[] = ['error', 'This doctor is banned'];
            return redirect()->route('doctors.all')->withNotify($notify);
        }

        $page_title = ''.$doctor->name.' - Booking';

        $available_date = [];
        $date = Carbon::now();

        for ($i=0; $i <$doctor->serial_day; $i++) {
            array_push($available_date, date('Y-m-d',strtotime($date)));
            $date->addDays(1);
        }
        return view($this->activeTemplate . 'booking',  compact('available_date','doctor','page_title'));

    }

    public function doctorDetails($id){

        $doctor = Doctor::findOrFail($id);
        // if(Auth::guard('patient')->user()==null){
        //     $notify[] = ['error', 'Please Login to Book Doctor'];
        //     return redirect()->route('doctors.all')->withNotify($notify);
        // }
        if ($doctor->status == 0) {
            $notify[] = ['error', 'This doctor is banned'];
            return redirect()->route('doctors.all')->withNotify($notify);
        }

        $page_title = ''.$doctor->name.' - Doctor Details';

        $available_date = [];
        $date = Carbon::now();

        for ($i=0; $i <$doctor->serial_day; $i++) {
            array_push($available_date, date('Y-m-d',strtotime($date)));
            $date->addDays(1);
        }
        return view($this->activeTemplate . 'doctor-details',  compact('available_date','doctor','page_title'));

    }

    public function bookedDate(Request $request){
        $data = Appointment::where('doctor_id',$request->doctor_id)->where('try',1)->where('d_status',0)->whereDate('booking_date',Carbon::parse($request->date))->get()->map(function($item){
            return str_slug($item->time_serial);
        });
        return response()->json(@$data);
    }

    public function appointmentStore(Request $request,$id)
    {
        $this->validate($request, [
            'booking_date' => 'required|date',
            'time_serial' => 'required',
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'mobile' => 'required|max:191',
            'age' => 'required|numeric|gt:0',
            // 'payment_system' => 'required|numeric|gt:0|max:2',
        ],[
            'time_serial.required'=>'You did not select any time or serial',
            // 'payment_system.required'=>'Do not try to cheat us',
        ]);

        $general = GeneralSetting::first();
        $doctor = Doctor::findOrFail($id);

        if ($doctor->serial_or_slot == null || empty($doctor->serial_or_slot)) {
            $notify[] = ['error', 'No available schedule for this doctor'];
            return back()->withNotify($notify);
        }

        $time_serial_check = $doctor->whereJsonContains('serial_or_slot',$request->time_serial)->first();
        if(!$time_serial_check){
            $notify[] = ['error', 'Do not try to cheat us'];
            return back()->withNotify($notify);
        }

        $existed_appointment = Appointment::where('doctor_id',$doctor->id)->where('booking_date',$request->booking_date)->where('time_serial',$request->time_serial)->where('try',1)->where('d_status',0)->first();

        if($existed_appointment){
            $notify[] = ['error', 'This appointment is already booked. Try another date or serial'];
            return back()->withNotify($notify);
        }

        $trx = null;
        $try = 1;
        $site = 1;
        $redirect = 0;

        if ($request->payment_system == 1) {
            $trx = getTrx();
            $try = 0;
            $site = 0;
            $redirect = 1;
        }

        $appointment = Appointment::create([
            'booking_date' => Carbon::parse($request->booking_date),
            'time_serial' => $request->time_serial,
            'name' => $request->name,
            'email' => $request->email,
            'patient' => $request->patient_id,
            'mobile' => $request->mobile,
            'age' => $request->age,
            'doctor_id' => $doctor->id,
            'site' => $site,
            'disease' => $request->disease,
            'try' => $try,
            'trx' => $trx,
        ]);

        if($redirect == 1){
            $data = [
                'id'=>$doctor->id,
                'trx'=>$trx,
                'order_id'=>$appointment->id,
                'email'=>$request->email,
                'amount'=>$appointment->doctor->fees,
                'first_name'=>$request->name,
                'contact_no'=>$request->mobile,
                'address'=>'colombo'

            ];

            session()->put('appoinment_data',$data);
            return redirect()->route('paymentWeb.appointment');
        }

        $patient = 1;
        notify($appointment, 'APPOINTMENT_CONFIRM', [
            'booking_date' => $appointment->booking_date,
            'time_serial' => $appointment->time_serial,
            'doctor_name' => $appointment->doctor->name,
            'doctor_fees' => ''.$appointment->doctor->fees.' '.$general->cur_text.'',
        ],$patient);

        $notify[] = ['success', 'Your appointment has been taken. Check your E-mail.'];
        return back()->withNotify($notify);


    }

    public function doctorSearch(Request $request){

        $page_title = "Search Result";

        $location = $request->location;
        $sector = $request->sector;
        $doctor_id = $request->doctor;

        if(!$location && !$sector && !$doctor_id){
            $doctors = Doctor::where('status',1)->paginate(getPaginate());
            return view($this->activeTemplate . 'search', compact('page_title','doctors'));
        }

        $doctor = Doctor::where('status',1);

        if(isset($location)){
            $doctor->where('location_id',$location);
        }
        if(isset($sector)){
            $doctor->where('sector_id',$sector);
        }
        if(isset($doctor_id)){
            $doctor->where('id',$doctor_id);
        }
        $doctors = $doctor->paginate(getPaginate());

        return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }
    public function getsectorDoctors($id) {
        $this->sector =$id;
        $sector = Sector::findOrFail($id);
        $page_title = $sector->name;
        $doctors = Doctor::where('status',1)->whereHas('sector', function($q) use($id){
            $q->where('sector_id',$id);
        })->get();
return $doctors;
       // return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }

    public function getsectorArticles($id) {

        $sector = Sector::findOrFail($id);

        $page_title = $sector->name;
        $articles = DrArticles::where('category',$id)->get();
        return $articles;

    }

    public function getsectorYoutubes($id) {

        $sector = Sector::findOrFail($id);
        $page_title = $sector->name;
        $videos= DrYotube::where('category',$id)->get();
        return response()->json($videos);
        return $videos;

    }
    public function getsectorAll($id) {
        $all = array();;
        $doctor = array();;
        $articless = array();;
        $youtube = array();;
        // $sector = Sector::findOrFail($id);
        // $page_title = $sector->name;
        if($id==0){
            $doctors = Doctor::where('status',1)->get();
        }
        else{
            $doctors = Doctor::where('status',1)->whereHas('sector', function($q) use($id){
                $q->where('sector_id',$id);
            })->get();
        }
        $videos= DrYotube::where('category',$id)->join('doctors','doctors.id','doctor_videos.doctor_id')->select('doctor_videos.*','doctors.name')->get();
        $articles = DrArticles::where('category',$id)->join('doctors','doctors.id','doctor_articles.doctor_id')->select('doctor_articles.*','doctors.name')->get();
        // $sector = Sector::findOrFail($id);
        // $page_title = $sector->name;

        $doctor[]=$doctors;
        $articless[]=$articles;
        $youtube[]=$videos;
        $new['doctors'] = $doctor;
        $new['articles'] = $articless;
        $new['youtube'] = $youtube;
        // return response()->json($videos);
        return $new;

    }

    public function getsectorallDoctors($id) {

        $sector = Sector::findOrFail($id);
        $page_title = $sector->name;
        $doctors = Doctor::where('status',1)->where('sector_id',$id)->get();

        return $doctors;
    }

    public function buyBook($id) {
        if(Auth::guard('patient')->user()==null  ){
            $notify[] = ['error', 'Please Login to Buy Book '];
            return back()->withNotify($notify);
        }
        else{
            $user=Patient::find(Auth::guard('patient')->user()->id);
        }

        $book=Books::find($id);
        // return $book;
        // $appointment = BuyBook::create([
        //     'book_id' => 8,
        //     'buyer_id' => Auth::guard('patient')->user()->id,
        //     'payment_status' => 0,
        // ]);
        $post = new BuyBook;
        $post->book_id = $book->id;
        $post->buyer_id =  Auth::guard('patient')->user()->id;
        $post->payment_status = 0;
        $post->save();
        $data = [
            'order_id'=>$post->id,
            'email'=>$user->email,
            'amount'=>$book->price,
            'first_name'=>$user->name,
            'contact_no'=>$user->mobile,
            'address'=>'colombo'

        ];
        session()->put('bookbuy_data',$data);
        return redirect()->route('paymentWeb');
       return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }

    public function sectorDoctors($id) {

        $sector = Sector::findOrFail($id);
        $page_title = $sector->name;
        $doctors = Doctor::where('status',1)->whereHas('sector', function($q) use($id){
            $q->where('sector_id',$id);
        })->paginate(getPaginate());

        return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }
    public function getDownload($id){
        $book=Books::find($id);
        // return $book;
        $file = "./assets/books/". $book->book_link;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file);
    }

    public function locationDoctors($id) {

        $location = Location::findOrFail($id);
        $page_title = $location->name;
        $doctors = Doctor::where('status',1)->whereHas('location', function($q) use($id){
            $q->where('location_id',$id);
        })->paginate(getPaginate());

        return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }

    public function doctorsAll() {
        $page_title = 'Our Doctors';
        $doctors = Doctor::where('status',1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }

    public function articlesAll() {
        $page_title = 'Articles';
        $articles = DrArticles::latest()->paginate(9);
        return view($this->activeTemplate . 'articles', compact('page_title','articles'));
    }

    public function lecturesAll() {
        $page_title = 'Lectures';
        $lectures = DrYotube::latest()->paginate(9);
        return view($this->activeTemplate . 'lectures', compact('page_title','lectures'));
    }

    public function featuredDoctorsAll() {
        $page_title = 'Our Featured Doctors';
        $doctors = Doctor::where('status',1)->where('featured',1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'search', compact('page_title','doctors'));
    }

    public function subscriberStore(Request $request) {


        $validate = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors());
        }

        Subscriber::create([
            'email' => $request->email
        ]);

        $notify = ['success' => 'Subscribe Successfully!'];
     return response()->json($notify);
    }

    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }

    public function getapp()
    {
        $data['page_title'] = "Downlaod";
        return view($this->activeTemplate . 'getapp', $data);
    }

    public function diseases(){
        $data['page_title'] = "Diseases";
        return view($this->activeTemplate . 'diseases', $data);
    }

    public function purchseHistory()
    {
        $data['page_title'] = "Purchse History";
        return view($this->activeTemplate . 'purchase-history', $data);
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    SupportAttachment::create([
                        'support_message_id' => $message->id,
                        'image' => uploadImage($image, $path),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }
    public function storePatient(Request $request){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'name' => 'required|string|max:190',
            'email' => 'required|string|email|max:190|unique:patients',
            'mobile' => 'required|string|max:190|unique:patients',
            'password' => 'required|string|min:6|confirmed',
           // 'username' => 'required|alpha_num|unique:patient|min:6',
            'address' => 'required|string|max:190',
        ]);

        $staff_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['staff']['path'];
                $size = imagePath()['staff']['size'];

                $staff_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }


        $patient = Patient::create([
            'image' => $staff_image,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'username' => $request->email,
            'address' => $request->address,
        ]);

        notify($patient, 'STAFF_CREDENTIALS', [
            'username' => $patient->username,
            'password' => $request->password,
        ]);

        $notify[] = ['success', 'Patient details has been added'];
        return back()->withNotify($notify);
    }

    public function patientRegister() {
        $page_title = 'Patient Register';
        // $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        // $blog->view_count +=1;
        // $blog->save();
        // $latest_blogs = Frontend::where('data_keys','blog.element')->get()->take(9);
        return view($this->activeTemplate.'patient-register',compact('page_title'));
    }
    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogDetails($id,$title) {
        $page_title = 'Article Details';
        $article = \App\DrArticles::Select('doctor_articles.*','doctors.name AS doctor')->where('doctor_articles.id','=',$id)->join('doctors','doctors.id','doctor_articles.doctor_id')->firstOrFail();
        // $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        // $article->view_count +=1;
        // $blog->save();
        // return $article;
        $latest_blogs = Frontend::where('data_keys','blog.element')->get()->take(9);
        return view($this->activeTemplate.'blog-details',compact('article','page_title','latest_blogs'));
    }

    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function terms()
    {
        $data['page_title'] = "Terms and Conditions";
        return view($this->activeTemplate . 'terms', $data);
    }

    public function refundpolicy()
    {
        $data['page_title'] = "Refund Policy";
        return view($this->activeTemplate . 'refundpolicy', $data);
    }

    public function privacy_policy()
    {
        $data['page_title'] = "Privacy Policy";
        return view($this->activeTemplate . 'privacy-policy', $data);
    }

}
