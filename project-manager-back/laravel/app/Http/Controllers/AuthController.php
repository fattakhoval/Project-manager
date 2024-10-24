<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Response;

class AuthController extends Controller
{

    public function createUser(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:8',
            'role'=>'required',
        ]);

        $plainPassword = $request->password;

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($plainPassword),
            'role'=>$request->role,
        ]);

        return response()->json([
            'user'=> $user,
            'password' => $plainPassword,
            'status'=> 'ok'
        ]);
    }

    public function signin(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            return response()->json([
                'user'=>Auth::user(),
                'status' => 'ok'
            ]);
        } else{
            return response()->json([
                'status'=> 'false'
            ]);
        }
    }

    public function editUser(Request $request, $userId){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'role'=>'string|required'
        ]);

        $user = User::findOrFail($userId);

        $user->fill([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role
        ]);

        $user->save();
        return response()->json($user, 200);

    }

    public function deleteUser($userId){
        $user = User::destroy($userId);
        return response()->json([
            'message'=> 'ok'
        ]);
    }
    
} 
