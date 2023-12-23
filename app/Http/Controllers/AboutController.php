<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Author;
use Illuminate\Http\Request;

class AboutController extends Controller
{
 public function index(){

        $abouts = About::with('author')->latest()->paginate(5);
        $authors = Author::latest()->select('id','name')->get();
        return view('admin.about.about_list',compact('authors','abouts'));

      }


      public function store(Request $request){
        $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|exists:categories,id',
            "description" => "required|string",
            ]);

            $about_slug = str($request->title)->slug();
    $slug_count = About::where('slug','LIKE','%' .$about_slug.'%')->count();

    if ($slug_count > 0){
        $about_slug.= "-" . $slug_count + 1;
    }

    $about = new About();
    $about->title = $request->title;
    $about->slug = $about_slug ;


    $about->author_id = $request->author;

    $about->description = $request->description;
    $about->save();
    return back();



      }
      public function update(Request $request,$id){
        $request->validate([
            'title'=>'required|string|max:255',
            'author'=>'required|exists:categories,id',
            "description" => "required|string",
            ]);

            $about_slug = str($request->title)->slug();
    $slug_count = About::where('slug','LIKE','%' .$about_slug.'%')->count();

    if ($slug_count > 0){
        $about_slug.= "-" . $slug_count + 1;
    }


    $about = About::find($id);


    $about->title = $request->title;
    $about->slug = $about_slug ;


    $about->author_id = $request->author;

    $about->description = $request->description;
    $about->save();
    return back();

      }
        public function edit($id){


    $abouts = About::with(['author:id,name'])->latest()->paginate(5);

    $authors = Author::latest()->select(['id','name'])->get();
    $Data = About::findOrFail($id,['id','title','author_id','description']);
    return view('admin.about.about_list',compact( 'abouts','Data','authors'));

  }
  public function delete($id)
  {
   $about_count = About::count();
   if( $about_count > 1 ){
    $about = About::find($id);
    $about->delete();

   }
   return back();
  }
  public function getSubcategory(Request $request){


$abouts = About::where('author_id ',$request->author)->latest()->get(['id','name']);
return $abouts;


}
public function change_status(Request $request){
    $about = About::find($request->post_id);
    if ($about->status ){
        $about->status =false;

}else{
    $about->status = true;

}

$about->save();
  }
}
