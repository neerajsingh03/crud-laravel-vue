<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class AuthController extends Controller
{
    public function storeUser(Request $request)
    {
        if($request->id){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
            ]);
            $user = User::findOrFail($request->id);
            return response()->json(['user' => $user]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422); 
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json(['success'=> 'User register successfully'],200);

    }
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users , 'success' => 'Users get successfully']);
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
    
        if($user){
            return response()->json(['user'=> $user]);
        }
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
        ]);

        $user->update($validated);
        return response()->json(['success' => 'Record update successfully']);
    }
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
