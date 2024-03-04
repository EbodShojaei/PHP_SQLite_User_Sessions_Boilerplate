<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/users.php';

const USERS_TABLE = "
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE CHECK(LENGTH(email) >= " . EMAIL_MIN_LENGTH . " AND LENGTH(email) <= " . EMAIL_MAX_LENGTH . "),
    nickname TEXT NOT NULL CHECK(LENGTH(nickname) >= " . NICKNAME_MIN_LENGTH . " AND LENGTH(nickname) <= " . NICKNAME_MAX_LENGTH . "),
    password TEXT NOT NULL CHECK(LENGTH(password) >= " . PASSWORD_MIN_LENGTH . " AND LENGTH(password) <= " . PASSWORD_MAX_LENGTH . "),
    role TEXT CHECK(role IN ('user', 'admin')) NOT NULL DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
