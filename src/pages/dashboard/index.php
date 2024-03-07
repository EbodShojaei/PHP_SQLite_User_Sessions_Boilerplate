<?php   
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/DashboardController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';

$dashboardController = new DashboardController();
$year = date('Y');
$availableYears = $dashboardController->getAvailableYears();

require_once '_dashboard.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
