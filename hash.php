<?php

/**
 * MIGRASI SEKALI JALAN — hash ulang semua password lama yang masih plaintext.
 *
 * Cara pakai:
 *   1. Taruh file ini di root project (sejajar folder config/, auth/, app/).
 *   2. Buka lewat browser: http://localhost/<nama-project>/migrate_hash_passwords.php
 *      (atau jalankan lewat CLI: php migrate_hash_passwords.php)
 *   3. Setelah selesai jalan dan kamu lihat hasilnya OK, HAPUS file ini.
 *      Jangan dibiarkan nangkring di server produksi.
 *
 * Yang dilakukan script ini:
 *   - Ambil semua baris di tabel `users`.
 *   - Kalau kolom `password` SUDAH berformat bcrypt (diawali $2y$, $2a$, atau $2b$),
 *     baris itu dilewati (dianggap sudah aman, misalnya hasil register.php).
 *   - Kalau BELUM (masih plaintext seperti "123", "pojok", dst), di-hash pakai
 *     password_hash() lalu di-UPDATE ke database.
 *
 * CATATAN KHUSUS soal baris "gibran":
 *   Passwordnya "202cb962ac59075b964b07152d234b70" itu BUKAN plaintext biasa —
 *   itu adalah hash MD5 dari string "123" (sisa dari sistem lama yang pakai MD5).
 *   Kalau dibiarkan, script ini akan meng-hash string MD5 itu apa adanya, dan
 *   user "gibran" nanti harus login pakai password aneh "202cb962ac59..." bukan "123".
 *   Supaya dia tetap bisa login pakai "123" seperti sebelumnya, script ini
 *   mendeteksi pola MD5 (32 karakter hex) dan menormalkannya balik ke "123"
 *   dulu sebelum di-hash ulang. Sesuaikan variabel $knownMd5ToPlain di bawah
 *   kalau ada baris MD5 lain dengan password asli yang berbeda.
 */

require_once __DIR__ . '/config/koneksi.php';

// Peta hash MD5 lama -> password asli (plaintext), kalau kamu tahu nilainya.
// Contoh di bawah: MD5("123") -> "123" (kasus user "gibran").
$knownMd5ToPlain = [
    '202cb962ac59075b964b07152d234b70' => '123', // md5("123")
];

$result = mysqli_query($koneksi, "SELECT id, username, password FROM users");

if(!$result){
    die("Query gagal: " . mysqli_error($koneksi));
}

$updated = 0;
$skipped = 0;
$log = [];

while($row = mysqli_fetch_assoc($result)){

    $id       = $row['id'];
    $username = $row['username'];
    $current  = $row['password'];

    // Sudah bcrypt/argon2? lewati.
    if(preg_match('/^\$2[aby]\$/', $current) || preg_match('/^\$argon2/', $current)){
        $skipped++;
        $log[] = "SKIP  #$id ($username) — sudah hash bcrypt/argon2.";
        continue;
    }

    $plainToHash = $current;

    // Kalau ini pola MD5 (32 hex char) dan kita tahu nilai aslinya, normalkan dulu.
    if(preg_match('/^[a-f0-9]{32}$/i', $current) && isset($knownMd5ToPlain[$current])){
        $plainToHash = $knownMd5ToPlain[$current];
        $log[] = "INFO  #$id ($username) — terdeteksi hash MD5 lama, dinormalkan ke plaintext aslinya.";
    }

    $newHash = password_hash($plainToHash, PASSWORD_DEFAULT);

    $newHash_esc = mysqli_real_escape_string($koneksi, $newHash);

    $ok = mysqli_query(
        $koneksi,
        "UPDATE users SET password='$newHash_esc' WHERE id=" . (int)$id
    );

    if($ok){
        $updated++;
        $log[] = "HASH  #$id ($username) — password di-hash ulang.";
    }else{
        $log[] = "ERROR #$id ($username) — gagal update: " . mysqli_error($koneksi);
    }
}

$isCli = (php_sapi_name() === 'cli');

if(!$isCli){
    header('Content-Type: text/plain; charset=utf-8');
}

echo "=== Migrasi hash password selesai ===\n";
echo "Total di-hash : $updated\n";
echo "Total dilewati: $skipped\n\n";
echo implode("\n", $log) . "\n\n";
echo "PENTING: hapus file migrate_hash_passwords.php ini sekarang juga.\n";