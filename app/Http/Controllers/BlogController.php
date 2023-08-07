<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogImage;
use App\Models\BlogKeyword;
use App\Models\KeyWord;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function get_blogs(Request $request){
        $url = "http://dashboard.arabicreators.com/api/get_all_blogs_dashbaord";
            if ($request->page !== null) {
                $url .= "?page=$request->page";
            }
            $response = Http::get($url);
            $responses = json_decode($response->body());
            $data = $response['data'];
            // dd($data);
            return view('dashboard.blogs.index')->with('blogs',$data);
    }
    public function show_blog($slug){
        $response = Http::get('http://dashboard.arabicreators.com/api/single_blog_new/'.$slug);
        $res = json_decode($response->body())->data;            
        $data = $response['data'];
        dd($data);  
            // dd($data);
        return view('dashboard.blogs.show')->with('blog',$data);
    }
    public function index(){
        return view('dashboard.blogs.index')->with('blogs',Blog::orderby('id','desc')->get());
    }
    public function create(){
        return view('dashboard.blogs.create')->with('images',BlogImage::orderby('id','desc')->get());
    }
    public function get_image($id){
        $pic= BlogImage::find($id);
     
        return $pic;
    }
    public function update_data_image(Request $request){
        $pic = BlogImage::find($request->image_id);
        $pic->title = $request->title_image;
        $pic->alt = $request->alt_image;
        $pic->description = $request->description_image;
        $pic->save();
        return true;
    }
    public function upload(Request $request)
    {
        $image = $request->image ;

        $name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $pic = new BlogImage();
        $pic->image    = $request->image->store('blog');
        $pic->title = $name;
        $pic->user_id = auth('admin')->id();
        $pic->save();
     
        return $pic;
    }
    public function store(Request $request){
        
        // dd($request->all());
      
                $service = new Blog();
                $service->title =$request->title_ar;
                $service->meta_title = $request->title_ar;
                $service->description =  $request->description_ar;
                $service->small_description = $request->small_description;

                // $name = preg_replace('/\..+$/', '', $request->file->getClientOriginalName());
                // $pic = new BlogImage();
                // $pic->image    = $request->file->store('blog');
                // $pic->title = $name;
                // $pic->user_id = $request->user_id;
                // $pic->save();

                $service->user_id = $request->user_id;
                $service->image_id =  $request->image_id;
                $service->slug = str_replace(' ', '_', $request->title_ar . '_' . Blog::count() + 1);
                if($request->publish_time != null){
                    $service->publish_time = $request->$request->publish_time;
                }else{
                    $service->publish_time = now(); 
                }

                $service->save();



                // foreach ($request->type as $category) {
                //     $cat = new BlogCategory();
                //     $cat->blog_id = $service->id;
                //     $cat->category_id = $category;
                //     $cat->save();
                // }



                $tags = explode(',',$request->tags);
                foreach ($tags as $s) {
                    $tag = new Tag();
                    $tag->title =  $s;
                    $tag->blog_id = $service->id;
                    $tag->save();
                }
                $keywords = explode(',',$request->tags);
                foreach ($keywords as $s) {
                    $keyword = KeyWord::where('title',$s)->first();
                    if ($keyword) {
                        $key = new BlogKeyword();
                        $key->blog_id = $service->id;
                        $key->keyword_id = $keyword->id;
                        $key->save();
                    } else {

                        $keyword = new KeyWord();
                        $keyword->title = $s;
                        $keyword->save();

                        $key = new BlogKeyword();
                        $key->blog_id = $service->id;
                        $key->keyword_id = $keyword->id;
                        $key->save();
                    }
                }



                return redirect()->route('blogs.index')->with(['success'=>'تم اضافة المقال بنجاح']);
           
        
    }
}
