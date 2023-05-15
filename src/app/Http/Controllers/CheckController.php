<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index(Request $request)
    {
        if ($request->hasHeader('Authorization')){
            try {
                $jwt = JWT::decode($request->bearerToken(),
                    new Key("sixty-nine-secret", 'HS256'));
                $res = json_decode(json_encode($jwt), true);
            }
            catch (Exception $e) {
                $res = response($e, 401);
            }
        }
        else
        {
            $res = response('Unauthorized', 403);
        }
        return $res;
    }
}
