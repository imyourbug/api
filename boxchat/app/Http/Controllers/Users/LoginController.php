<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view(
            'users.login',
            [
                'title' => 'ĐĂNG NHẬP'
            ]
        );
    }

    public function store(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if ($this->checkExistsEmail($request->email) != true)
            return response()->json([
                'success' => false,
                'message' => 'Email không tồn tại'
            ]);
        if (Auth::attempt($data)) {
            $user = User::where('email', $request->email)->first();
            $token = $user['_token'] = $user->createToken('boxchat')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'user_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id
                ],
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Email hoặc mật khẩu không chính xác'
        ]);
    }

    public function checkExistsEmail($email)
    {
        $user = User::where('email', $email)->first();
        if ($user)
            return true;
        return false;
    }
}
