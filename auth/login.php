<?php

session_start();

require_once __DIR__ . '/../config/koneksi.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$auth  = new AuthController($koneksi);
$error = null;

if(isset($_POST['login'])){

    $result = $auth->login($_POST['username'], $_POST['password']);

    if($result['success']){
        header("Location: " . $result['redirect']);
        exit;
    }

    $error = $result['error'];

}

include __DIR__ . '/../app/Views/auth/login.php';