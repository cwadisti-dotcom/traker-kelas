<?php

class UserModel
{
    private $koneksi;

    public function __construct($koneksi)
    {
        $this->koneksi = $koneksi;
    }

    /**
     * Cari 1 user berdasarkan username saja.
     * Verifikasi password dilakukan di luar (lewat password_verify),
     * bukan lewat WHERE password='...' — karena password di DB itu hash,
     * bukan plain text, jadi tidak bisa dicocokkan langsung di query.
     */
    public function findByUsername($username)
    {
        $username_esc = mysqli_real_escape_string($this->koneksi, $username);

        $query = mysqli_query(
            $this->koneksi,
            "SELECT * FROM users
             WHERE username='$username_esc'
             LIMIT 1"
        );

        return $query ? mysqli_fetch_assoc($query) : null;
    }

    /**
     * Buat user baru. $hashedPassword WAJIB sudah di-hash (password_hash)
     * sebelum masuk ke sini — model tidak melakukan hashing sendiri.
     */
    public function create($username, $hashedPassword, $role)
    {
        $username_esc = mysqli_real_escape_string($this->koneksi, $username);
        $password_esc = mysqli_real_escape_string($this->koneksi, $hashedPassword);
        $role_esc     = mysqli_real_escape_string($this->koneksi, $role);

        return mysqli_query(
            $this->koneksi,
            "INSERT INTO users(username, password, role)
             VALUES('$username_esc','$password_esc','$role_esc')"
        );
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
        $role_esc = mysqli_real_escape_string($this->koneksi, $role);

        $query = mysqli_query(
            $this->koneksi,
            "SELECT COUNT(*) as total
             FROM users
             WHERE role='$role_esc'"
        );

        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalSiswa()
    {
        return $this->countByRole('siswa');
    }

    public function getTotalGuru()
    {
        return $this->countByRole('guru');
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