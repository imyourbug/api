<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request){

        if($this->checkExistsEmail($request->email) == true){
            return response()->json([
                'success' => false,
                'message' => 'Email đã tồn tại',
            ]); 
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'success' => true
        ]);
        
    }
    public function checkExistsEmail($email){
        $user = User::where('email', $email)->first();
        if($user)
            return true;
        return false;
    }
}
