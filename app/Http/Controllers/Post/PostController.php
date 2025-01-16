<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function postStore(Request $request){
       
        $validator = Validator::make($request->all(), [
            'post' => 'required',
            'description' => 'required',
            
        ]);
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
        $post->save();
         return response()->json([
            'success' => 'Post successfully submitted',
            'status'  => 200,
            'imageUrl' => $imageUrl
         ]);
    }
}
