<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">

    <div class="sidebar-top">

        <div class="logo">
            <h2>DeadlineHub</h2>
        </div>

        <div class="menu-title">GURU</div>

        <ul class="menu">

            <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li class="<?= $current_page == 'tambah_tugas.php' ? 'active' : '' ?>">
                <a href="tambah_tugas.php">
                    <i class="fas fa-plus"></i>
                    Tambah Tugas
                </a>
            </li>

            <li class="<?= $current_page == 'edit_tugas.php' ? 'active' : '' ?>">
                <a href="edit_tugas.php">
                    <i class="fas fa-pen"></i>
                    Edit Tugas
                </a>
            </li>

            <li class="<?= $current_page == 'monitoring.php' ? 'active' : '' ?>">
                <a href="monitoring.php">
                    <i class="fas fa-chart-line"></i>
                    Monitoring
                </a>
            </li>

            <li class="<?= $current_page == 'nilai.php' ? 'active' : '' ?>">
                <a href="nilai.php">
                    <i class="fas fa-star"></i>
                    Input Nilai
                </a>
            </li>

        </ul>

    </div>

    <ul class="menu">
    <li class="logout">
    <a href="../logout.php">
    <i class="fas fa-sign-out-alt"></i>
    Logout
</a>
</li>
</ul>

</aside>