<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php';
require_once $isAuthenticated ? '_authenticated.php' : '_unauthenticated.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php';
