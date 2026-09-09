<?php

session_start();

require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth = new AuthController(null);
$auth->logout();

header("Location: login.php");
exit;