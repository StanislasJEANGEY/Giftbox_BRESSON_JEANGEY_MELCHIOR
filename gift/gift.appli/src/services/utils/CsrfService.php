<?php

namespace gift\app\services\utils;

class CsrfService
{
    public static function generate():string{
        $token = base64_encode(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }
}