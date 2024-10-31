<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Response;

class AuthController extends Controller
{

    public function create(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:8',
            'role'=>'required|string|in:Админ,Руководитель проекта,Исполнитель',
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
            'notHisPassword' => $plainPassword,
            'status'=> 'ok'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required',
        ]);

        if(Auth::attempt([
            'email'=> $request->email,
            'password'=>$request->password,
            ])){
                $user = Auth::user();

                return response()->json([
                    'status'=>'success',
                    'user'=>$user,
                    'role'=>$user->role
                ]);
            }

            return response()->json([
                'status'=>'error',
                'message'=>'Invalid credentials.'
            ], 401);
    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'status'=>'success',
            'message'=>'Logged out successfully.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'sometimes|required|string|in:Админ,Руководитель проекта,Исполнитель'
        ]);

        $user->update($validated);

        if (isset($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getNonAdminUsers()
    {
        $users = User::where('role', '!=', 'Админ')->get();
        return response()->json($users);
    }

    
} 
