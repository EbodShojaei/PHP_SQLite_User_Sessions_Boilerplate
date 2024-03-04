<?php

class Cookie {
    public static function set($id, $value, $expiry) {
        if (setcookie($id, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($id) {
        self::set($id, '', time() - 1);
    }

    public static function get($id) {
        return $_COOKIE[$id];
    }

    public static function exists($id) {
        return isset($_COOKIE[$id]);
    }
}
