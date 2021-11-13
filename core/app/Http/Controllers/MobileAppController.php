<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Books;
use App\BuyBook;
use App\Doctor;
use App\DrArticles;
use App\DrYotube;
use App\Patient;
use App\Prescription;
use App\PrescriptionImage;
use App\Sector;
use App\PostsModel;
use App\Users;
use App\ScheduledAppointments;
use App\PushNotificationsTokenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\CommonPHP\Agora\RtcTokenBuilder;
use DateTime;
use DateTimeZone;
class MobileAppController extends Controller
{
    public function loginAccount(Request $request)
    {
       $user_type= $request->user_type;

       if( $user_type=='principal'){
        $user = Users::Where('user_type', '=','principal')->where('email', '=', $request->email)->first();

        if ($user) {
           if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'user' => $user,
                'message' =>'success'
            ]);

           }
           else{
            return response()->json([
                'message' =>'password_invalid'
            ]);
           }
       }
       else{
        return response()->json([
            'message' =>'user_not_found'
        ]);

       }


    }
    elseif( $user_type=='coach'){
        $user = Users::Where('user_type', '=','coach')->where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'user' => $user,
                    'message' =>'success'
                ]);

               }
               else{
                return response()->json([
                    'message' =>'password_invalid'
                ]);
               }
       }
       else{
        return response()->json([
            'message' =>'user_not_found'
        ]);

       }
    }
}
public function getCategories(Request $request)
{
    $user = Sector::all();
   return response()->json($user);

}
public function getDoctors(Request $request)
{
    $user = Doctor::select('doctors.*','sectors.name AS category')
    ->join('sectors','doctors.sector_id','sectors.id')
    ->get();
   return response()->json($user);

}
public function getDoctorsByCat(Request $request)
{
    $user = Doctor::select('doctors.*','sectors.name AS category')
    ->join('sectors','doctors.sector_id','sectors.id')
    ->where('sectors.name','=',$request->category)
    ->get();
   return response()->json($user);

}
public function getPrescriptionByPatient(Request $request)
{
    $user = Prescription::select('prescription.*','doctors.name AS doctor_name','doctors.image')
    ->join('doctors','doctors.id','prescription.doctor_id')
    ->join('appointments','appointments.id','prescription.appointment_id')
    ->where('prescription.patient_id','=',$request->patient_id)
    ->get();
   return response()->json($user);

}
public function getPrescriptionImageById(Request $request)
{
    $user = PrescriptionImage::where('prescription_id','=',$request->id)
    ->get();
   return response()->json($user);

}

public function getAppointmentTimeSlots(Request $request)
{
    $user = Doctor::select('doctors.serial_or_slot')
    ->where('doctors.id','=',$request->id)
    ->get();
    $available_slots = array();
    for ($i = 0; $i < sizeof($user[0]['serial_or_slot']); $i++) {// for loop for all selected test
        $appointment = Appointment::Where('booking_date','=',$request->date)
        ->where('time_serial','=',$user[0]['serial_or_slot'][$i])
        ->first();


        if($appointment){

        }
        else{
            $available_slots[]=$user[0]['serial_or_slot'][$i];
        }
        // $available_slots[]=$user[0]['serial_or_slot'][$i];
        }
   return response()->json($available_slots);

}
public function appointmentStore(Request $request)
{

    // $this->validate($request, [
    //     'booking_date' => 'required|date',
    //     'time_serial' => 'required',
    //     'name' => 'required|max:50',
    //     'email' => 'required|email',
    //     'mobile' => 'required|max:50',
    //     'age' => 'required|numeric|gt:0',
    // ],[
    //     'time_serial.required'=>'You did not select any time or serial',
    // ]);

    // $doctor = Doctor::findOrFail($id);
    // $time_serial_check = $doctor->whereJsonContains('serial_or_slot',$request->time_serial)->first();

    // if($time_serial_check){
        // $existed_appointment = Appointment::where('doctor_id',$doctor->id)->where('booking_date',$request->booking_date)->where('time_serial',$request->time_serial)->where('try',1)->where('d_status',0)->first();

        // if($existed_appointment){
        //     $notify[] = ['error', 'This appointment is already booked. Try another date or serial'];
        //     return back()->withNotify($notify);
        // }

        // $general = GeneralSetting::first();

        $appointment = Appointment::create([
            'booking_date' => Carbon::parse($request->booking_date)->format('Y-m-d'),
            'time_serial' => $request->time_serial,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'age' => $request->age,
            'doctor_id' => $request->doctor_id,
            'patient' => $request->patient_id,
            // 'admin' => 1,
            'p_status '=>2,
            'disease' => $request->disease,
            'try' => 1,
        ]);

        $patient = 1;
        // notify($appointment, 'APPOINTMENT_CONFIRM', [
        //     'booking_date' => $appointment->booking_date,
        //     'time_serial' => $appointment->time_serial,
        //     'doctor_name' => $doctor->name,
        //     'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
        // ],$patient);

        // $notify[] = ['success', 'Your appointment has been taken.'];
        return response()->json($appointment);

    // }else{
    //     $notify[] = ['error', 'Do not try to cheat us'];
    //     return back()->withNotify($notify);
    // }

}
public function getAppointmenDetailsByPatientId(Request $request)
{
    $appointments = Appointment::where('patient',$request->patient_id)->where('is_complete',0)->where('d_status',0)
    ->join('doctors','doctors.id','appointments.doctor_id')
    ->select('appointments.*','doctors.name AS doc_name','doctors.image','doctors.mobile AS doc_mobile')
    ->orderBy('appointments.created_at', 'DESC')
    ->get();
   return response()->json($appointments);

}
public function getArticlesByDocId(Request $request)
{
    $education_details = DrArticles::select('doctor_articles.*','doctors.name','sectors.name AS sectorName')
    ->where('doctor_id', $request->doc_id)
    ->join('doctors', 'doctors.id', '=', 'doctor_articles.doctor_id')
    ->join('sectors', 'sectors.id', '=', 'doctor_articles.category')
    ->get();
   return response()->json($education_details);

}
public function getYotubeByDocId(Request $request)
{
    $education_details = DrYotube::select('doctor_videos.*','doctors.name','sectors.name AS sectorName')
    ->where('doctor_id', $request->doc_id)
    ->join('doctors', 'doctors.id', '=', 'doctor_videos.doctor_id')
    ->join('sectors', 'sectors.id', '=', 'doctor_videos.category')
    ->get();
   return response()->json($education_details);

}
public function getAllBooks(Request $request)
{
    $education_details = Books::all();
   return response()->json($education_details);

}
public function prescriptionStore(Request $request)
{

    // $this->validate($request, [
    //     'disease' => 'required',
    //     'note' => 'required',
    // ]);
    $prescription = new Prescription();
    $prescription->appointment_id = $request->appointment_id;
    $prescription->disease =  $request->disease;
    $prescription->patient_id =  $request->patient_id;
    $prescription->doctor_id = $request->doctor_id;
    $prescription->note =  $request->note;
    $prescription->date = Carbon::now();
    $prescription->save();

    $selectedPrescriptionDocument = $request->input('selectedDocument');//array of selected document

    if ($selectedPrescriptionDocument != []) {
        for ($i = 0; $i < sizeof($selectedPrescriptionDocument); $i++) {// for loop for all selected test
            $prescription_document = new PrescriptionImage();
            $prescription_document->prescription_id = $prescription->id;
            $prescription_document->attachment_name  = $selectedPrescriptionDocument[$i];
            $prescription_document->date = Carbon::now();
            $prescription_document->save();

            }
    }
    $appointments = Appointment::where('id', '=', $request->appointment_id)->update([
        'is_complete' => 1]);

        $patient = 1;
        // notify($appointment, 'APPOINTMENT_CONFIRM', [
        //     'booking_date' => $appointment->booking_date,
        //     'time_serial' => $appointment->time_serial,
        //     'doctor_name' => $doctor->name,
        //     'doctor_fees' => ''.$doctor->fees.' '.$general->cur_text.'',
        // ],$patient);

        $notify[] = ['success', 'Your prescription has been taken.'];
        return back()->withNotify($notify);



}
public function getAppointmenDetailsByDoctorId(Request $request)
{
    $appointments = Appointment::where('doctor_id',$request->doctor_id)->where('try',1)->where('is_complete',0)->where('d_status',0)
    ->join('patients','patients.id','appointments.patient')
    ->select('appointments.*','patients.name AS doc_name','patients.image','patients.mobile AS doc_mobile')
    ->get();
   return response()->json($appointments);

}
public function patientPrescriptionReportUpload(Request $request)
{
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $done=$image->move('assets/appointment/prescription', $imageName);
    return response()->json(['successss' => $imageName]);

    // try{

    //     $location = imagePath()['appointment']['path'];
    //     $size = imagePath()['appointment']['size'];
    //     $image->move($path, $filename);
    //   $staff_image = uploadImage($request->file('file'), $location , $size);

    // }catch(\Exception $exp) {
    //     return 'error Could not upload the image.';
    // }
}
public function UploadPrescriptionImage(Request $request)
{
    $image = $request->image;
    $name = $request->name;
    $realImage = base64_decode($image);
    $fileinfo = pathinfo($name);
    $extention = $fileinfo['extension'];
    $new_name = rand() . '.' . $extention;


    file_put_contents('assets/appointment/prescription' . '/' . $new_name, $realImage);
    return response()->json($new_name);

}
public function scheduleManage(Request $request){

    // $this->validate($request, [
    //     'slot_type' => 'required|numeric|gt:0',
    //     'max_serial' => 'sometimes|required|numeric|min:1',
    //     'duration' => 'sometimes|required|numeric|gt:0',
    //     'serial_day' => 'required|numeric|gt:0',
    //     'start_time' => 'sometimes|required',
    //     'end_time' => 'sometimes|required'
    // ]);

    $doctor = Doctor::findOrFail($request->doctor_id);

    if ($request->slot_type == 1 && $request->max_serial > 0) {

        $serial_or_slot = [];

        for ($i=1; $i <= $request->max_serial; $i++) {
            array_push($serial_or_slot,"$i");
        }

        $doctor->serial_or_slot = $serial_or_slot;
        $doctor->max_serial = $request->max_serial;

    }
    elseif ($request->slot_type == 2 && $request->duration > 0) {

        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);
        $total_min = $end_time->diffInMinutes($start_time);
        $total_slot = $total_min / $request->duration;

        $serial_or_slot = [];

        for ($i=1; $i <= $total_slot; $i++) {

            array_push($serial_or_slot,date('h:i:a',strtotime($start_time)));
            $start_time->addMinutes($request->duration);
        }

        $doctor->serial_or_slot = $serial_or_slot;
        $doctor->duration = $request->duration;
        $doctor->start_time = Carbon::parse($request->start_time)->format('h:i a');
        $doctor->end_time = Carbon::parse($request->end_time)->format('h:i a');
    }
    else{
        return response()->json('error');
    }

    $doctor->slot_type = $request->slot_type;
    $doctor->serial_day = $request->serial_day;
    $doctor->save();

    $notify[] = ['success', 'Time schedule has been updated'];
    // return back()->withNotify($notify);
    return response()->json('success');
}
public function UploadPatientImage(Request $request)
{
    $image = $request->image;
    $name = $request->name;
    $realImage = base64_decode($image);
    $fileinfo = pathinfo($name);
    $extention = $fileinfo['extension'];
    $new_name = rand() . '.' . $extention;


    file_put_contents('assets/staff/images/profile' . '/' . $new_name, $realImage);
    return response()->json($new_name);

}
public function UploadDoctorImage(Request $request)
{
    $image = $request->image;
    $name = $request->name;
    $realImage = base64_decode($image);
    $fileinfo = pathinfo($name);
    $extention = $fileinfo['extension'];
    $new_name = rand() . '.' . $extention;


    file_put_contents('assets/doctor/images/profile' . '/' . $new_name, $realImage);
    return response()->json($new_name);

}
public function storePatient(Request $request){

if($request->image==null){
    $image="Noimage.png";
}
else{
    $image=$request->image;
}

    $patient = Patient::create([
        'image' => $image,
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'password' => Hash::make($request->password),
        'username' => $request->email,
        'address' => $request->address,
    ]);

    return response()->json('Success');
}
public function storeDoctor(Request $request){

    if($request->image==null){
        $image="Noimage.png";
    }
    else{
        $image=$request->image;
    }
    $doctor = Doctor::create([
        'image' => $image,
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'password' => Hash::make($request->password),
        'username' => $request->username,
        'sector_id' => $request->sector_id,
        'qualification' => $request->qualification,
        'address' => $request->address,
        'location_id' => 1,
        'fees' => $request->fees,
        'rating' => 5,
        'about' => $request->about,
        'featured' => $request->featured ? 1 : 0,
    ]);

    return response()->json('Success');
}
public function getPatientDetails(Request $request)
{
    $user = Patient::where('id','=',$request->id)
    ->first();
   return response()->json($user);

}
public function getDoctorDetails(Request $request)
{
    $user = Doctor::where('id','=',$request->id)
    ->first();
   return response()->json($user);

}
public function updateDoctorDetails(Request $request)
{
    $patient = Doctor::find($request->id);
    $patient->name = $request->get("name");
    $patient->email = $request->get("email");
    $patient->mobile = $request->get("mobile");
    $patient->mobile = $request->get("mobile");
    $patient->username = $request->get("username");
    $patient->qualification = $request->get("qualification");
    $patient->about = $request->get("about");
    $patient->image = $request->get("image");
    $patient->save();
   return response()->json($patient);

}
public function updatePatientPassword(Request $request)
{
    $patient = Patient::where('email',$request->email)->first();
    $patient->password = Hash::make($request->password);
    $patient->save();
   return response()->json($patient);

}

public function updateDoctorPassword(Request $request)
{
    $patient = Doctor::where('email',$request->email)->first();
    $patient->password = Hash::make($request->password);
    $patient->save();
   return response()->json($request->password);

}

public function drsendPasswordResetOTP(Request $request)
{   $patient = Doctor::Where('email',$request->email)->first();
    if($patient)
    {
        send_general_email($request->email, 'Password Reset', 'As you have requested to reset the password please enter the below reset OTP on your Mobile to reset Password. OTP : '.$request->otp, $patient->name);
        return response()->json('success');
    }
    else{
        return response()->json('email');
    }


}

public function patientsendPasswordResetOTP(Request $request)
{   $patient = Patient::Where('email',$request->email)->first();
    if($patient)
    {
        send_general_email($request->email, 'Password Reset', 'As you have requested to reset the password please enter the below reset OTP on your Mobile to reset Password. OTP : '.$request->otp, $patient->name);
        return response()->json('success');
    }
    else{
        return response()->json('email');
    }


}

public function updatePtientDetails(Request $request)
{
    $patient = Patient::find($request->id);
    $patient->name = $request->get("name");
    $patient->email = $request->get("email");
    $patient->mobile = $request->get("mobile");
    $patient->address = $request->get("address");
    $patient->username = $request->get("username");
    $patient->image = $request->get("image");
    $patient->save();
   return response()->json($patient);

}

public function storeBookPurchase(Request $request)
{
    $book=BuyBook::where('book_payments.buyer_id','=',$request->get("buyer_id"))->where('book_payments.book_id','=',$request->get("book_id"))->where('book_payments.payment_status','=',1)->get();
    // return response()->json($book);
    if($book==[]){
        return response()->json('Already');
    }
    $patient = new BuyBook;
    $patient->book_id = $request->get("book_id");
    $patient->buyer_id = $request->get("buyer_id");
    $patient->payment_status = 0;
    $patient->save();
   return response()->json( $patient);

}
public function purchaseHistory(Request $request)
{
    $book=BuyBook::select('books.*')->where('book_payments.buyer_id','=',$request->get("buyer_id"))->join('books','books.id','book_payments.book_id')->where('book_payments.payment_status','=',1)->get();
    if($book!=[]){
        return response()->json($book);
    }
    else{
        return;
    }



}
public function visa_master_payment_done(Request $request)
{

    $payment = base64_decode($_POST ["payment"]);
    $signature = base64_decode($_POST ["signature"]);
    $custom_fields = base64_decode($_POST ["custom_fields"]);
    //    test
    $publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC/XgbitCulgQI5MNBJVSuyEE0q
9y460Zmu+d46Mkua2jsCSqKwKdEGCE1dH8lTehwAmeUg0aSVlErheZjNeHFnBvyz
wRu7aJz+r2bIlhcqmP3HjWazhmjV6D2yc6X+xzX7lAY16SghNFRx5bTSb9rrHOYS
yxUy7Yf/QqCCqRI+iwIDAQAB
-----END PUBLIC KEY-----";

    //live
//        $publickey = "-----BEGIN PUBLIC KEY-----
//MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDp0nLwTPBR96TPKdygsRmY5ooi
//1cIv9D0uzD9FVtgM4p1UnaQKO/NkvFin8oBDtJMRAjDmhZ+migxskhzxihiwtnIh
//NCejystmndqzwLHFHzk9s77snfbekaqVqbZSn+Vt9ShROkVhI0FbWAfhkL4lsyeu
//FyWLa4t36UdkjPti8wIDAQAB
//-----END PUBLIC KEY-----";
    openssl_public_decrypt($signature, $value, $publickey);
    $custom_fields_varible = explode('|', $custom_fields);
    $signature_status = false;

    if ($value == $payment) {
        $signature_status = true;
    }
    $responseVariables = explode('|', $payment);

    if ($signature_status == true) {
        if($custom_fields_varible[1]=='app'){
            if($custom_fields_varible[2]=='appointment'){
                $order = Appointment::find($custom_fields_varible[0]);
                $order->p_status  = 1;
                $order->try  = 1;
                $order->save();
                   return view('payments.payment_done');
            }
            else if($custom_fields_varible[2]=='book'){
                $order = BuyBook::find($custom_fields_varible[0]);
                $order->payment_status  = 1;
                $order->save();
                   return view('payments.payment_done');
            }
        }
        else if($custom_fields_varible[1]=='web'){
            if($custom_fields_varible[2]=='appointment'){
                $order = Appointment::find($custom_fields_varible[0]);
                $order->p_status  = 1;
                $order->try  = 1;
                $order->save();
                   return view('payments.payment_done');
            }
            else if($custom_fields_varible[2]=='book'){
                $order = BuyBook::find($custom_fields_varible[0]);
                $order->payment_status  = 1;
                $order->save();
                   return view('payments.payment_done');
            }
        }


    } else {
        //unsuccessful
       // return view('payments.payment_done');
    }


//        if($request->status_code == '0'){
//            //successful
//            return redirect()->route('order_confirmed');
//        }else{
//            //unsuccessful
//            return view('frontend.payment.webxpay.response');
//        }

}
public function DeleteAppointment(Request $request)
{
    Appointment::where('id', '=', $request->id)->delete();

    return response()->json('Deleted');
}

////////////////New Development/////////////////////////
public function SaveDeviceToken(Request $request)
{  $firebase_token = $request->token;
    $push_noti = PushNotificationsTokenModel::where('token', '=', $firebase_token)->first();
    if ($push_noti === null) {
        // user doesn't exist
        $deviceToken = new PushNotificationsTokenModel();
        $deviceToken->user_id = $request->user_id;
        $deviceToken->token = $firebase_token;
        $deviceToken->device_type = $request->device_type;
        $deviceToken->save();
    } else {
        $push_noti = PushNotificationsTokenModel::where('token', 'LIKE', $firebase_token)->update([
            'user_id' => $request->user_id,
            'voip_token' =>$request->voip_token,
            'device_type' => $request->device_type]);
    }




    return response()->json($deviceToken);
}
public function getAppointmenDetailsByPrincipal(Request $request)
{

    $appointments = ScheduledAppointments::where('scheduled_appointments.principal_id',$request->principal_id)->where('scheduled_appointments.status',1)
    ->join('users','users.user_code','scheduled_appointments.coach_id')
    ->select('scheduled_appointments.*','users.first_name','users.last_name','users.profile_image','users.mobile_no')
    ->get();
   return response()->json($appointments);

}
//Token gen
public function AgoraTokenGeneration(Request $request)
{
    $appID = "86bd3ecef7cb48388044ecc22d232f3e";
    $appCertificate = "341cb63cfe6d4ee0be780743f06a4010";
    $channelName = $request->channel_name;
    $uid = 0;
    $role = RtcTokenBuilder::RoleAttendee;
    $expireTimeInSeconds = 3600;
    $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    return $token;
}
public function getLibraryPost(Request $request)
{

    $appointments = PostsModel::where('posts.status',1)
    ->join('sectors','sectors.id','posts.category')
    ->select('posts.*','sectors.name','sectors.details','sectors.image')
    ->get();
   return response()->json($appointments);

}


}
