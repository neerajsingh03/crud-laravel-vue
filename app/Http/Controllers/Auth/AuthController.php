<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Auth;
class AuthController extends Controller
{
    public function storeUser(Request $request)
    {
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
        $user->password = Hash::make($request->password);
        $user->role     = "user";
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['success'=> 'User register successfully','token' => $token,'role' => $user->role],200);

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
    public function login(Request $request)
    {
       $validate = Validator::make($request->all(),[
        'email' => 'required',
        'password'  =>  'required',
       ]);
       if($validate->fails()){
            return response()->json([
               'success' => false,
               'message' => 'validation error',
               'error'  =>  $validate->errors(),
            ],422);
       };
       $credential = $request->only('email','password');
       if(!Auth::attempt($credential)){
         return response()->json(['message' => 'Invalid login details'],401);
       }
       $user = Auth::user();
       $token = $user->createToken('login_token')->plainTextToken;
       return response()->json(['message' => 'Login successfully','token' =>$token,'role' => $user->role]);

    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user->tokens()->delete();
        return response()->json(['success' => 'Logout successfully'], 200);
    }
}
