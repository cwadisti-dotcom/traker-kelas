<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">

    <div class="sidebar-top">

        <div class="logo">
            <h2>DeadlineHub</h2>
        </div>

        <div class="menu-title">ADMIN</div>

        <ul class="menu">

            <li class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li class="<?= $current_page == 'data_guru.php' ? 'active' : '' ?>">
                <a href="data_guru.php">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Kelola Guru
                </a>
            </li>

            <li class="<?= $current_page == 'data_siswa.php' ? 'active' : '' ?>">
                <a href="data_siswa.php">
                    <i class="fas fa-user-graduate"></i>
                    Kelola Siswa
                </a>
            </li>

            <li class="<?= $current_page == 'monitoring.php' ? 'active' : '' ?>">
                <a href="monitoring.php">
                    <i class="fas fa-chart-line"></i>
                    Monitoring
                </a>
            </li>

        </ul>

    </div>

 <ul class="menu">
    <li class="logout">
        <a href="/ta_deadlinehub/app/Views/auth/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </a>
    </li>
</ul>

</aside>