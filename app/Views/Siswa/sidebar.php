<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">

    <div class="sidebar-top">

        <div class="logo">
            <h2>DeadlineHub</h2>
        </div>

        <div class="menu-title">SISWA</div>

        <ul class="menu">

            <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="fa-solid fa-table-columns"></i>
                    Dashboard
                </a>
            </li>

            <li class="<?= $current_page == 'tugas_saya.php' || $current_page == 'upload_tugas.php' ? 'active' : '' ?>">
                <a href="tugas_saya.php">
                    <i class="fa-regular fa-clipboard"></i>
                    Tugas Saya
                </a>
            </li>

            <li class="<?= $current_page == 'nilai.php' ? 'active' : '' ?>">
                <a href="nilai.php">
                    <i class="fa-solid fa-chart-column"></i>
                    Nilai
                </a>
            </li>

        </ul>

    </div>

    <ul class="menu">
        <li class="logout">
            <a href="../auth/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </li>
    </ul>

</aside>
