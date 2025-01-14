<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function storeUser(Request $request)
    {
        // $request->validate ([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required',
        //     'number'   => 'required',
        // ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->number = $request->number;
        $user->save();
        return response()->json(['success'=> ' user register successfully'],200);

    }
    public function index()
    {

        $users = User::all();
        return response()->json(['users' => $users]);
        // return response()->json(['message' => 'This is a test API route']);
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        if($user){
            return response()->json(['user'=> $user]);
        }
    }
    // public function update(Request $request, $id)
    // {
    //     $post = Post::findOrFail($id);

    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $post->update($validated);
    //     return response()->json($post);
    // }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if($user)
        {
            $user->delete();
            return response()->json(['success' => 'user remove successfully']);
        }
    }
}