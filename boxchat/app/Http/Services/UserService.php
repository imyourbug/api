<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{
    public function getUserByKeyWord($keyword)
    {
        $users = User::where('name', 'like', '%' . $keyword . '%')->get();
        if (count($users) > 0) {
            $data = array();
            foreach ($users as $user) {
                $data[] = [
                    'name' => $user->name,
                    '_id' => $user->id,
                    'avatar' => $user->avatar
                ];
            }
            return response()->json([
                'success' => true,
                'list_user' => $data
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }
    public function getListUser()
    {
        $users = User::get();
        if (count($users) > 0) {
            $data = array();
            foreach ($users as $user) {
                $data[] = [
                    'name' => $user->name,
                    '_id' => $user->id,
                    'avatar' => $user->avatar
                ];
            }
            return response()->json([
                'success' => true,
                'list_user' => $data
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }
}
