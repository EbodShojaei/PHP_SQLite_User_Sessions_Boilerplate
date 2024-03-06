<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
?>

<?php // Check if admin to disable buttons for the current user
$token = Cookie::exists('auth_token') ? Cookie::get('auth_token') : null;
$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$currentUserId = $tokenManager->getUserIdFromToken($token);
$currentUser = $db->query("SELECT * FROM users WHERE id = $currentUserId")[0];
$isAdmin = $currentUser['role'] === 'admin';
if (!$isAdmin) Alerts::redirect("You do not have permission to access this page.", "danger", "/");
?>

<?php // Get all users and paginate them
$users = $db->query("SELECT * FROM users");
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 10;
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $perPage);
$offset = ($currentPage - 1) * $perPage;
$users = array_slice($users, $offset, $perPage);
?>

<?php // Display the admin page
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
Alerts::display();
require_once '_admin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
?>