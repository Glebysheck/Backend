<?php

namespace App\Http\Controllers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index(Request $request)
    {
        if ($request->hasHeader('Authorization')){
//            try {
//                $jwt = JWT::decode($request->header('Authorization'),
//                    new Key("sixty-nine-secret", 'HS256'));
//                $jwt = response($jwt, 200);
//            }
//            catch (Exception $e) {
//                $jwt = response('', 401);
//            }
            $jwt = response('Good', 200);
        }
        else
        {
            $jwt = response('Incorrect', 401);
        }
        return $jwt;
    }
}
