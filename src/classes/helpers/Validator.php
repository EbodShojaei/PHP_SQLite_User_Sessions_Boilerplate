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
}