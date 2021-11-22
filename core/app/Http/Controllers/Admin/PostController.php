<?php

namespace App\Http\Controllers\Admin;
use App\Appointment;
use App\Assistant;
use App\Deposit;
use App\Disease;
use App\Doctor;
use App\DoctorLogin;
use App\Http\Controllers\Controller;
use App\Location;
use App\Rules\FileTypeValidate;
use App\Sector;
use App\DoctorAssistantTrack;
use App\DrArticles;
use App\DrYotube;
use App\Gallery;
use App\PostsModel;
use Illuminate\Support\Facades\Hash;
use Uuid;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;

class PostController extends Controller
{
   ///////Articles///////////////
   public function newPost(){
    $page_title = 'Add New Article';
    $sector = Sector::all();
    $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
    $vimeoData =$vimeo['body']['data'];
    // return $vimeoData;
    return view('admin.Posts.new_post', compact('page_title','sector','vimeoData'));
}
public function postsAll(){
    
    $page_title = 'Manage Articles';
        $empty_message = 'No post found';
        $articles = PostsModel::Select('posts.*','sectors.name')->join('sectors','sectors.id','posts.category')->latest()->paginate(getPaginate());

        return view('admin.Posts.all_posts', compact('page_title', 'empty_message', 'articles'));
}
public function uploadPostsImage(Request $request)
{
    $image = $request->file('file');
    $imageName = $image->getClientOriginalName();
    $done=$image->move('assets/articles', $imageName);
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




public function postsRemove($id){

    $education_details = DrArticles::findOrFail($id);
    $education_details->delete();

    $notify[] = ['success', 'Article successfuly deleted'];
    return back()->withNotify($notify);

}
public function postsStore(Request $request){
    $this->validate($request, [
        'title' => 'required|max:190',
    ]);

    $subject_image='default.jpg';
    if($request->hasFile('image')) {
        try{

            $location = imagePath()['posts']['path'];
            $size = imagePath()['posts']['size'];

            $subject_image = uploadImage($request->image, $location , $size);

        }catch(\Exception $exp) {
            return back()->withNotify(['error', 'Could not upload the image.']);
        }
    }

    // DrArticles::create([
    //     'doctor_id' => 1,
    //     'article_title' => $request->title,
    //     'article_description' => $request->description,
    //     'article_image' => $request->selectedDocument,
    //     'category' => $request->category,
    // ]);
    $post = new PostsModel();
    $post->post_code = Uuid::generate(4);
    $post->title =  $request->title;
    $post->description =  $request->description;
    $post->category = $request->category;
    $post->post_image =  $subject_image;
    $post->document_name =  $request->document;
    $post->video_url =  $request->vimeo_url;
    $post->author_name =  $request->author_name;
    $post->author_description  =  $request->author_description;
    $post->additional_data =  '{}';
    $post->added_by_user =  1;
    $post->status =  $request->status=='on'?1:0;
    $post->save();
    $notify[] = ['success', 'Post has been added'];
    return back()->withNotify($notify);

}
public function detail($id)
{
    $page_title = 'Article Detail';
    $article = PostsModel::findOrFail($id);
    $sector = Sector::latest()->get();
    $vimeo= Vimeo::request('/me/videos', ['per_page' => 10], 'GET');
    $vimeoData =$vimeo['body']['data'];

    return view('admin.posts.detail', compact('page_title', 'article','sector','vimeoData'));
}
public function postsUpdate(Request $request, $id)
{
    $subject_image='';

    if($request->hasFile('image')) {
        try{

            $location = imagePath()['posts']['path'];
            $size = imagePath()['posts']['size'];

            $subject_image = uploadImage($request->image, $location , $size);

        }catch(\Exception $exp) {
            return back()->withNotify(['error', 'Could not upload the image.']);
        }
    }

    // DrArticles::create([
    //     'doctor_id' => 1,
    //     'article_title' => $request->title,
    //     'article_description' => $request->description,
    //     'article_image' => $request->selectedDocument,
    //     'category' => $request->category,
    // ]);
 
    $post = PostsModel::findOrFail($id);
    $post->title =  $request->title;
    $post->description =  $request->description;
    $post->category = $request->category;
    if($subject_image!=''){
        $post->post_image =  $subject_image;
    }
   
    $post->document_name =  $request->document;
    $post->video_url =  $request->vimeo_url;
    $post->author_name =  $request->author_name;
    $post->author_description  =  $request->author_description;
    $post->status =  $request->status=='on'?1:0;
    $post->save();
    $notify[] = ['success', 'Post has been Updated'];
    return back()->withNotify($notify);
}
/////End Articles

}
