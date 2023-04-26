<?php

namespace App\Models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public static function generated_jwt_token($login, $password): string
    {
        $secret_key = "sixty-nine-secret";

        $user_data = array(
            "login" => $login,
            "password" => $password
        );

        $token_lifetime = 3000;

        $issued_at = time();

        $expiration_time = $issued_at + $token_lifetime;

        return JWT::encode(
            array(
                "iss" => "http://192.168.0.117:8080",
                "aud" => "http://localhost:4200",
                "iat" => $issued_at,
                "exp" => $expiration_time,
                "data" => $user_data
            ),
            $secret_key,
            'HS256'
        );
    }
}
