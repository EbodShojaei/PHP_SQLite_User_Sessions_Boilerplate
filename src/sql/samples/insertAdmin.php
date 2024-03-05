<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/defaultAdmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

function insertAdmin($db) {
    $sql = "SELECT * FROM users WHERE email = :email";
    $params = ['email' => DEFAULT_EMAIL];
    $result = $db->query($sql, $params);
    if (!empty($result)) return false;
    $sql = "INSERT INTO users (email, nickname, password, role, status) VALUES (:email, :nickname, :password, :role, :status)";
    $params = [
        'email' => DEFAULT_EMAIL,
        'nickname' => DEFAULT_NICKNAME,
        'password' => password_hash(DEFAULT_PASSWORD, PASSWORD_DEFAULT),
        'role' => DEFAULT_ROLE,
        'status' => DEFAULT_STATUS
    ];
    $db->execute($sql, $params);
    return true;
}
