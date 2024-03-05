<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

$users = $db->query("SELECT * FROM users");
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 10;
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $perPage);
$offset = ($currentPage - 1) * $perPage;
$users = array_slice($users, $offset, $perPage);

require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php';
?>