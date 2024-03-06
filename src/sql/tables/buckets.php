<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/transactions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/buckets.php';

const BUCKETS_TABLE = "
CREATE TABLE IF NOT EXISTS buckets (
    bucket_id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_name TEXT NOT NULL CHECK(LENGTH(transaction_name) <= " . TRANS_NAME_MAX_LEN . "),
    category TEXT CHECK(LENGTH(category) <= " . BUCKET_CATEGORY_MAX_LEN . ")
)";
