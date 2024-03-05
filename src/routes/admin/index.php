<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';

$token = Cookie::exists('auth_token') ? Cookie::get('auth_token') : null;
$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$currentUserId = $tokenManager->getUserIdFromToken($token);
$currentUser = $db->query("SELECT * FROM users WHERE id = $currentUserId")[0];
$isAdmin = $currentUser['role'] === 'admin';
if (!$isAdmin) Alerts::redirect("You do not have permission to access this page.", "danger", "/");

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