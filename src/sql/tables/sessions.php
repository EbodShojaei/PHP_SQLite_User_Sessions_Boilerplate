<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/sessions.php';

const SESSIONS_TABLE = "
CREATE TABLE IF NOT EXISTS sessions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    session_token TEXT NOT NULL CHECK(LENGTH(session_token) = " . TOKEN_MAX_LENGTH . "),
    expires_at TIMESTAMP NOT NULL DEFAULT (datetime('now', '+" . TOKEN_EXPIRATION . " seconds')),
    FOREIGN KEY(user_id) REFERENCES users(id)
)";
