<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/users.php';

class Validator
{
    public static function validateEmail($email, $path = "/login")
    {
        empty($email) ?? Alerts::redirect("Email is required.", "danger", $path);
        filter_var($email, FILTER_VALIDATE_EMAIL) ?? Alerts::redirect("Invalid email format.", "danger", $path);
        (strlen($email) > EMAIL_MAX_LENGTH) ?? Alerts::redirect("Email must be at most " . EMAIL_MAX_LENGTH . " characters.", "danger", $path);
        return true;
    }

    public static function validateInput($input, $type = null, $min_len = 2, $max_len = 128, $path = "/login")
    {
        $type = empty($type) ? $type = "Input" : strtoupper($type);
        empty($input) ?? Alerts::redirect($type . " is required.", "danger", $path);
        (strlen($input) < $min_len) ?? Alerts::redirect($type . " must be at least " . $min_len . " characters.", "danger", $path);
        (strlen($input) > $max_len) ?? Alerts::redirect($type . " must be at most " . $max_len . " characters.", "danger", $path);
        return true;
    }

    public static function validateNickname($nickname, $path = "/login")
    {
        empty($nickname) ?? Alerts::redirect("Nickname is required.", "danger", $path);
        (strlen($nickname) < NICKNAME_MIN_LENGTH) ?? Alerts::redirect("Nickname must be at least " . NICKNAME_MIN_LENGTH . " characters.", "danger", $path);
        (strlen($nickname) > NICKNAME_MAX_LENGTH) ?? Alerts::redirect("Nickname must be at most " . NICKNAME_MAX_LENGTH . " characters.", "danger", $path);
        return true;
    }

    public static function validatePassword($password, $path = "/login")
    {
        empty($password) ?? Alerts::redirect("Password is required.", "danger", $path);
        (strlen($password) < PASSWORD_MIN_LENGTH) ?? Alerts::redirect("Password must be at least " . PASSWORD_MIN_LENGTH . " characters.", "danger", $path);
        (strlen($password) < PASSWORD_MAX_LENGTH) ?? Alerts::redirect("Password must be at most " . PASSWORD_MAX_LENGTH . " characters.", "danger", $path);
        return true;
    }

    public static function validateDate($date, $path = "/")
    {
        empty($date) ?? Alerts::redirect("Date is required.", "danger", $path);
        (strtotime($date)) ?? Alerts::redirect("Invalid date format.", "danger", $path);
        return true;
    }

    public static function validateFloat($float, $path = "/")
    {
        empty($float) ?? Alerts::redirect("Value is required.", "danger", $path);
        (is_numeric($float)) ?? Alerts::redirect("Invalid value format.", "danger", $path);
        return true;
    }
}