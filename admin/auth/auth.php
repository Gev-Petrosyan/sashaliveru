<?php

session_start();

// Admin authentication data
class Auth {

    public static function user(): null|array { // Authenticated admin data
        return (isset($_SESSION["user"])) ? $_SESSION["user"] : null;
    }

    public static function check(): bool { // Cheking authentication
        return (!is_null(Auth::user())) ? true : false;
    }

    public static function logout(): void { // Logout 
        $_SESSION["user"] = null;
        header("location: ../../index.php");
        exit();
    }

}
