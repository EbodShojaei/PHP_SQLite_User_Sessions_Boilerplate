<?php

function sanitizeString($string, $maxLength = null)
{
    $string = trim($string); // Remove whitespace
    $string = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8'); // Sanitize string
    if ($maxLength !== null) {
        $string = substr($string, 0, $maxLength); // Limit length
    }
    return $string;
}

function sanitizeEmail($email)
{
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}
