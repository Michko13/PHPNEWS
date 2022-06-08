<?php

class AuthService
{
    public static function InitAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(!isset($_SESSION['username'])) {
            header('Location: index.php');
            die();
        }
    }

    public static function StartSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}