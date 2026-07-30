<?php

session_start();

include __DIR__ . '/../../config/koneksi.php';
include __DIR__ . '/../Models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct($koneksi)
    {
        $this->userModel = new UserModel($koneksi);
    }

    public function login()
    {
        if(isset($_POST['login']))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login(
                $username,
                $password
            );

            if($user)
            {
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                switch($user['role'])
                {
                    case 'admin':
                        header("Location: ../admin/index.php");
                        break;

                    case 'guru':
                        header("Location: ../Guru/index.php");
                        break;

                    case 'siswa':
                        header("Location: ../Siswa/index.php");
                        break;
                }

                exit;
            }

            return "Username atau Password salah!";
        }

        return null;
    }
}