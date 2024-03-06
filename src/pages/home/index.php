<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
require_once $isAuthenticated ? '_authenticated.php' : '_unauthenticated.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
