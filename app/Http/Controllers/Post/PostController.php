<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Auth;
class PostController extends Controller
{
    public function postStore(Request $request){
   
        $validator = Validator::make($request->all(), [
            'post' => 'required',
            'description' => 'required',
            'image'   => 'required',
            
        ]);
        $userId = auth()->user()->id;
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422); 
        };
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('posts/images'), $imageName);
            $imageUrl =  $imagePath = 'posts/images/' . $imageName;
        }
        $post = new Post;
        $post->post = $request->post;
        $post->description = $request->description;
        $post->image = $imageUrl;
        $post->user_id = $userId;
        $post->save();
         return response()->json([
            'success' => 'Post successfully submitted',
            'status'  => 200,
            'imageUrl' => $imageUrl,
            
         ]);
    }
    public function fetchPosts()
    {
        $posts = Post::all();
        if(!$posts)
        {
            return response()->json(['error','Post is empty'],404);
        }else{
            return response()->json(['success'=> 'Posts get successfully','posts' =>$posts],200);
        }
        
    }
    public function userPosts($id)
    {
        if(!$id)
        {
            return response()->json(['error' => 'User post not found'],404);
        }
       
        $posts = Post::where('user_id', $id)->with('user')->get();
  
        if(!$posts)
        {
            return response()->json(['error' => 'post not found'],404);
        }
        else{
            return response()->json(['posts' => $posts, 'success' => 'fetch posts successfully'],200);
        }                
    }
}
