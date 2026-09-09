<?php

session_start();

require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth = new AuthController(null);
$auth->logout();

header("Location: /ta_deadlinehub/auth/login.php");
exit;

?>