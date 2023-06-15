<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use function PHPUnit\Framework\fileExists;

class BlogsController extends Controller
{
    public function allBlogs()
    {
        $allBlogs = Blogs::with('bloger')->where([['status', '=', 'Active'], ['user_id', '!=', Auth::user()->id]])->get();
        foreach ($allBlogs as $ab) {
            $ab->image = asset("$ab->image");
            $ab->liked = ($ab->MyLike != null)?$ab->MyLike->like:0;
            $ab->AllLikes = ($ab->AllLikes != null)?count($ab->AllLikes):0;
            $lastUpdated = $ab->created_at;
            $carbonLastUpdated = Carbon::parse($lastUpdated);
            $ab->formattedLastUpdated = 'Last updated ' . $carbonLastUpdated->diffForHumans();
            // die($ab);
            unset($ab->MyLike);

        }
        return response()->json(['data' => $allBlogs], 200);
    }

    public function myBlogs()
    {
        $myBlogs = Blogs::with('bloger')->where([['status', '=', 'Active'], ['user_id', '=', Auth::user()->id]])->get();
        foreach ($myBlogs as $ab) {
            $ab['image'] = asset('') . $ab['image'];
            $ab['liked'] = ($ab['MyLike'] != null)?$ab['MyLike']['like']:0;
            $ab['AllLikes'] = ($ab['AllLikes'] != null)?count($ab['AllLikes']):0;
            $lastUpdated = $ab->created_at;
            $carbonLastUpdated = Carbon::parse($lastUpdated);
            $ab->formattedLastUpdated = 'Last updated ' . $carbonLastUpdated->diffForHumans();
        }
        return response()->json(['data' => $myBlogs], 200);
    }

    public function blogDetails(Request $request)
    {
        $blogDetails = Blogs::with('bloger')->where([['status', '=', 'Active'], ['id', '=', $request->id]])->get();
        foreach ($blogDetails as $ab) {
            $ab->image = asset("$ab->image");
            $lastUpdated = $ab->created_at;
            $carbonLastUpdated = Carbon::parse($lastUpdated);
            $ab->formattedLastUpdated = 'Last updated ' . $carbonLastUpdated->diffForHumans();
        }
        return response()->json(['data' => $blogDetails], 200);
    }

    public function addBlog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:4048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();

        $imageName = time() . '.' . $request->image->extension();

        $path = $request->image->move(public_path('images/blogs'), $imageName);
        $data['image'] = 'images/blogs/' . $imageName;
        $data['user_id'] = Auth::user()->id;
        $blogDetails = Blogs::create($data);
        return response()->json(['data' => $blogDetails], 200);
    }

    public function blogEdit(Request $request)
    {

        $blogEdit = Blogs::with('bloger')->where([['status', '=', 'Active'], ['id', '=', $request->id]])->get();
        foreach ($blogEdit as $ab) {
            $ab->image = asset("$ab->image");
            $lastUpdated = $ab->created_at;
            $carbonLastUpdated = Carbon::parse($lastUpdated);
            $ab->formattedLastUpdated = 'Last updated ' . $carbonLastUpdated->diffForHumans();
        }
        return response()->json(['data' => $blogEdit], 200);
    }

    public function updateBlog(Request $request)
    {
        $validatorRules = [
            'title' => 'required',
            'description' => 'required',
        ];

        if ($request->file('image')) {
            $validatorRules['image'] = 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:4048';
        }

        $validator = Validator::make($request->all(), $validatorRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();
        $checkBlog = Blogs::find($request->id);

        if ($request->file('image')) {
            if ($checkBlog && $checkBlog->image != null && file_exists(public_path($checkBlog->image))) {
                unlink(public_path($checkBlog->image)); // Unlink the file
            }
            $imageName = time() . '.' . $request->image->extension();
            $path = $request->image->move(public_path('images/blogs'), $imageName);
            $data['image'] = 'images/blogs/' . $imageName;
        }
        else{
            $data['image'] = $checkBlog->image;
        }


        $data['user_id'] = Auth::user()->id;
        $blogDetails = $checkBlog->update($data);

        return response()->json(['data' => $blogDetails], 200);
    }


    public function blogDelete(Request $request)
    {
        $checkBlog = Blogs::find($request->id);

            if ($checkBlog && $checkBlog->image != null && file_exists(public_path($checkBlog->image))) {
                unlink(public_path($checkBlog->image)); // Unlink the file
            }

            $checkBlog->delete();
            return response()->json(['data' => 'Blog deleted'], 200);
    }

    public function likeMe(Request $request)
    {
        $checkLike = Like::where([['blog_id','=',$request->id],['user_id','=',Auth()->user()->id]])->first();

        if(empty($checkLike))
        {
            $checkBlogLike = new Like;
            $checkBlogLike->blog_id = $request->id;
            $checkBlogLike->user_id = Auth()->user()->id;
            $checkBlogLike->status = 1;
            $checkBlogLike->save();
            $msg = "Blog is added to your likes";
        }
        else
        {
         $status =  ($checkLike->like === 1)?0:1;

               // Like::where('id',$checkBlogLike->id)->update(['status'=> $status]);
         $msg = ($status==1)?"Blog is added to your likes":"Blog is removed from your likes";
         Like::where('id',$checkLike->id)->delete();
     }
        return response()->json(['data' => $msg], 200);
    }

}
