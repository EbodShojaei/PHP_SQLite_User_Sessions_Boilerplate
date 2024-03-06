<?php

// Create the users table and session table if they don't exist

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/tables/users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/tables/sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/tables/transactions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/tables/buckets.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/samples/insertAdmin.php';

$db = Database::getInstance();
$db->execute(USERS_TABLE);
$db->execute(SESSIONS_TABLE);
$db->execute(TRANSACTIONS_TABLE);
$db->execute(BUCKETS_TABLE);
insertAdmin($db); // Insert the default admin user if does not exist
