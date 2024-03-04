<?php

function sanitizeString($string)
{
    $string = trim($string); // Remove whitespace
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function sanitizeEmail($email)
{
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}
