<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/users.php';

function validateEmail($email, $path="/login")
{
    if (empty($email)) {
        Alerts::redirect("Email is required.", "danger", $path);
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Alerts::redirect("Invalid email format.", "danger", $path);
    } else if (strlen($email) > EMAIL_MAX_LENGTH) {
        Alerts::redirect("Email must be at most " . EMAIL_MAX_LENGTH . " characters.", "danger", $path);
    }
    return true;
}

function validateNickname($nickname, $path="/login")
{
    if (empty($nickname)) {
        Alerts::redirect("Nickname is required.", "danger", $path);
    } else if (strlen($nickname) < NICKNAME_MIN_LENGTH) {
        Alerts::redirect("Nickname must be at least " . NICKNAME_MIN_LENGTH . " characters.", "danger", $path);
    } else if (strlen($nickname) > NICKNAME_MAX_LENGTH) {
        Alerts::redirect("Nickname must be at most " . NICKNAME_MAX_LENGTH . " characters.", "danger", $path);
    }
    return true;
}

function validatePassword($password, $path="/login")
{
    if (empty($password)) {
        Alerts::redirect("Password is required.", "danger", $path);
    } else if (strlen($password) < PASSWORD_MIN_LENGTH) {
        Alerts::redirect("Password must be at least " . PASSWORD_MIN_LENGTH . " characters.", "danger", $path);
    } else if (strlen($password) > PASSWORD_MAX_LENGTH) {
        Alerts::redirect("Password must be at most " . PASSWORD_MAX_LENGTH . " characters.", "danger", $path);
    }
    return true;
}
