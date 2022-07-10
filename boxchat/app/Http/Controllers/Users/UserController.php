<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function search(Request $request)
    {
        return $this->userService->getUserByKeyWord($request->name);
    }
    public function list()
    {
        return $this->userService->getListUser();
    }
}
