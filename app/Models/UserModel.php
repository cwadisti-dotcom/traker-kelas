<?php

class UserModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    public function login($username, $password)
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT * FROM users
             WHERE username='$username'
             AND password='$password'"
        );

        return mysqli_fetch_assoc($query);
    }

    public function getAll()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT * FROM users"
        );
    }

    public function countByRole($role)
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM users
             WHERE role='$role'"
        );

        return mysqli_fetch_assoc($query)['total'];
    }
    
    public function getTotalSiswa()
    {
    $query = mysqli_query(
        $this->koneksi,
        "SELECT COUNT(*) as total
         FROM users
         WHERE role='siswa'"
    );

   return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalGuru()
    {
        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
            FROM users
            WHERE role='guru'"
        );

        return mysqli_fetch_assoc($query)['total'];
    }
    public function getGuru()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT * FROM users
            WHERE role='guru'"
        );
    }

    public function getSiswa()
    {
        return mysqli_query(
            $this->koneksi,
            "SELECT * FROM users
            WHERE role='siswa'"
        );
    }
}