<?php

require_once __DIR__ . '/../Models/UserModel.php';

class AuthController
{
    private $userModel;

    public function __construct($koneksi)
    {
        $this->userModel = new UserModel($koneksi);
    }

    /**
     * @return array{success:bool, error?:string, redirect?:string}
     */
    public function login($username, $password)
    {
        $user = $this->userModel->findByUsername($username);

        if(!$user || !password_verify($password, $user['password'])){
            return [
                'success' => false,
                'error'   => 'Username atau password salah!',
            ];
        }

        $_SESSION['id']       = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role'];

        return [
            'success'  => true,
            'redirect' => $this->redirectPathByRole($user['role']),
        ];
    }

    /**
     * @return array{success:bool, error?:string}
     */
    public function register($username, $password, $confirmPassword)
    {
        $username = trim($username);

        if($username === '' || $password === ''){
            return [
                'success' => false,
                'error'   => 'Username dan password wajib diisi!',
            ];
        }

        if($password !== $confirmPassword){
            return [
                'success' => false,
                'error'   => 'Konfirmasi password tidak cocok!',
            ];
        }

        if($this->userModel->findByUsername($username)){
            return [
                'success' => false,
                'error'   => 'Username sudah dipakai, coba yang lain!',
            ];
        }

        // Password di-hash di sini, sebelum masuk ke model / database.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->userModel->create($username, $hashedPassword, 'siswa');

        return ['success' => true];
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    private function redirectPathByRole($role)
    {
        switch($role){
            case 'admin':
                return '../admin/index.php';
            case 'guru':
                return '../Guru/index.php';
            case 'siswa':
                return '../Siswa/index.php';
            default:
                return '../auth/login.php';
        }
    }
}