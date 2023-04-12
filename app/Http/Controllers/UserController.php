<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $usersRequest = $request->post();
        foreach ($users as $user) {
            if ($user['login'] == $usersRequest['login'] and Hash::check($usersRequest['password'], $user['password'])) {
                return $user->toJson();
            }
        }
        return response('Hui', 403);
    }

    public function get_token()
    {
        $user = User::find(2);
        return response($user['remember_token'], 200);
    }

    public function create(Request $request)
    {
        $user = $request->all();
        User::create([
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'login' => $user['login'],
            'password' => Hash::make($user['password']),
            'role_id' => $user['role_id']
        ]);
    }
}
