<?php

namespace App\Classes;

use App\Classes\token;
use App\Classes\alg;

class genJWT {

    public $alg = 'HS256';
    public $typ = 'JWT';

    public function generate($username, $name) {
        $data = new token();
        $data->username = $username;
        $data->name = $name;
        $data->iat = round(microtime(true) * 1000);
        $jwtToken = base64_encode(json_encode($this->header())) . '.' . base64_encode(json_encode($data));
        $sign = $this->sign($jwtToken);
        $response = $jwtToken . '.' . $sign;
        return $response;

    }

    private function header() {
        $res = new alg();
        $res->alg = $this->alg;
        $res->typ = $this->typ;
        return $res;
    }

    private function sign($payload) {
        return hash_hmac('sha256', $payload, env('JWT_SECRET'));
    }

    public function authToken($token) {
        if(strlen($token) == 0) {
            return false;
        } else {
            $info = explode('.', $token);
            if (isset($info[1])) {
                $usercred = $info[1];
                if (imap_base64($usercred) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

}