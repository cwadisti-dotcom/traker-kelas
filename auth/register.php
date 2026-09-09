<?php

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth     = new AuthController($koneksi);
$error    = null;
$username = '';

if(isset($_POST['register'])){

    $username = trim($_POST['username']);

    $result = $auth->register(
        $username,
        $_POST['password'],
        $_POST['confirm_password']
    );

    if($result['success']){
        header("Location: login.php");
        exit;
    }

    $error = $result['error'];

}

include __DIR__ . '/../app/Views/auth/register.php';