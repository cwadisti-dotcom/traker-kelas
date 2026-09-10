<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page    = basename($_SERVER['PHP_SELF']);
$siswa_username  = $_SESSION['username'] ?? 'Siswa';
?>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="logo">
            <span class="logo-mark">DH</span>
            <span class="logo-name">DeadlineHub</span>
        </div>
        <div class="nav-label">MENU</div>
        <nav class="nav">
            <a href="index.php" class="nav-item <?= $current_page == 'index.php' ? 'is-active' : '' ?>">
                <i class="fas fa-table-columns"></i>
                Dashboard
            </a>
         <a href="tugas_saya.php"
   class="nav-item <?= in_array(basename($_SERVER['PHP_SELF']), ['tugas_saya.php', 'detail_tugas.php']) ? 'is-active' : ''; ?>">
    <i class="fa-solid fa-clipboard"></i>
    Tugas Saya
</a>
            <a href="nilai.php" class="nav-item <?= $current_page == 'nilai.php' ? 'is-active' : '' ?>">
                <i class="fas fa-chart-column"></i>
                Nilai
            </a>
        </nav>
    </div>

    <div class="sidebar-bottom">
        <div class="profile-wrapper">

            <button type="button" class="sidebar-profile" id="profileTrigger">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <span class="profile-name"><?= htmlspecialchars($siswa_username) ?></span>
                <i class="fas fa-chevron-up profile-caret"></i>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-dropdown-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-dropdown-info">
                        <span class="profile-dropdown-name"><?= htmlspecialchars($siswa_username) ?></span>
                        <span class="profile-dropdown-role">Akun Siswa</span>
                    </div>
                </div>

                <div class="sep"></div>

                <a href="../auth/logout.php" class="dropdown-item is-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Keluar
                </a>
            </div>

        </div>
    </div>
</aside>

<script>
(function () {
    const trigger  = document.getElementById('profileTrigger');
    const dropdown = document.getElementById('profileDropdown');

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        trigger.classList.toggle('is-open');
        dropdown.classList.toggle('is-open');
    });

    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
            trigger.classList.remove('is-open');
            dropdown.classList.remove('is-open');
        }
    });
})();
</script>
