<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = 'Guest';
}
?>

<nav class="navbar navbar-expand-lg navbar-color fixed-top">
    <nav class="navbar navbar-expand-lg navbar-color fixed-top">
    <a class="navbar-brand" href="#">
        <img src="../img/Jti.png" alt="Logo" height="30">
        Jurusan Teknologi Informasi
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTopMenu" aria-controls="navbarTopMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTopMenu">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                    <?php echo $username?><img src="../img/user-profile.jpg" alt="Profile" class="rounded-circle" height="30">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item text-danger" href="#">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
