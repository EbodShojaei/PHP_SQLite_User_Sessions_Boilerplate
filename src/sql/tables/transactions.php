<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/transactions.php';

const TRANSACTIONS_TABLE = "
CREATE TABLE IF NOT EXISTS transactions (
    trans_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    bucket_id INTEGER,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(" . TRANS_NAME_MAX_LEN . ") NOT NULL,
    expense " . TRANS_DOLLAR_FORMAT . ",
    deposit " . TRANS_DOLLAR_FORMAT . ",
    balance " . TRANS_DOLLAR_FORMAT . ",
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(bucket_id) REFERENCES buckets(bucket_id)
)";
