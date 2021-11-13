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
use Illuminate\Http\Request;

class PostController extends Controller
{
   ///////Articles///////////////
   public function newPost(){
    $page_title = 'Add New Article';
    $sector = Sector::all();
    return view('admin.Posts.new_post', compact('page_title','sector'));
}
public function postsAll(){
    $page_title = 'Manage Articles';
        $empty_message = 'No post found';
        $articles = PostsModel::latest()->paginate(getPaginate());
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


public function postsUpdate(Request $request, $id){

    // $article = new DrArticles();
    // $article->doctor_id = $request->doctor_id;
    // $article->article_title =  $request->title;
    // $article->article_description =  $request->description;
    // $article->article_image = $request->selectedDocument[0];
    // $article->category =  $request->category;
    // $article->save();
// return $request->title;
    $article = DrArticles::findOrFail($id);
    $subject_image = $article->article_image;
    if($request->hasFile('image')) {
        try{

            $location = imagePath()['articles']['path'];
            $size = imagePath()['articles']['size'];
            $old = $article->article_image;
            $subject_image = uploadImage($request->image, $location , $size, $old);

        }catch(\Exception $exp) {
            return back()->withNotify(['error', 'Could not upload the image.']);
        }
    }
    // $article->update([
    //     // 'doctor_id' => $request->title,
    //     'article_title' => $request->title,
    //     'article_description' => $request->details,
    //     'article_image' => $subject_image,
    //     // 'category' => $request->category,
    // ]);

    $article->article_title = $request->title;
    $article->article_description =   $request->details;
    $article->doctor_id =$request->doctor_id;
    $article->category  =$request->category;
    $article->article_image = $subject_image;
    $article->save();

    $notify[] = ['success', 'Article details has been updated'];
    return back()->withNotify($notify);

}

public function postsRemove($id){

    $education_details = DrArticles::findOrFail($id);
    $education_details->delete();

    $notify[] = ['success', 'Article successfuly deleted'];
    return back()->withNotify($notify);

}
public function postsStore(Request $request){

    // $this->validate($request, [
    //     'title' => 'required|max:190',
    //     'discipline' => 'required|max:190',
    //     'period' => 'required|max:190',
    // ]);

    // DrArticles::create([
    //     'doctor_id' => 1,
    //     'article_title' => $request->title,
    //     'article_description' => $request->description,
    //     'article_image' => $request->selectedDocument,
    //     'category' => $request->category,
    // ]);
    $article = new DrArticles();
    $article->doctor_id = $request->doctor_id;
    $article->article_title =  $request->title;
    $article->article_description =  $request->description;
    $article->article_image = $request->selectedDocument[0];
    $article->category =  $request->category;
    $article->save();
    $notify[] = ['success', 'Article has been added'];
    return back()->withNotify($notify);

}
/////End Articles

}
