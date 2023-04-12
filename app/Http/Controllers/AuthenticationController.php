<?php

namespace App\Http\Controllers;

use App\Models\Token;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();
        $usersRequest = $request->all();
        foreach ($users as $user) {
            if ($user['login'] == $usersRequest['login'] and
                Hash::check($usersRequest['password'], $user['password'])) {
                $user->update([
                    'remember_token' => Token::generated_jwt_token($usersRequest['login'], $usersRequest['password'])
                ]);
                return $user->toJson();
            }
        }
        return response('Hui', 403);
    }
}
