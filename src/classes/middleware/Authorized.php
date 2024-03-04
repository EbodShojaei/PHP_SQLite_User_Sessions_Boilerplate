<?php

class Authorized
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: /login');
            exit();
        }
    }

    public static function isAdmin()
    {
        return $_SESSION['user']['role'] === 'admin';
    }

    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            header('Location: /');
            exit();
        }
    }
}
