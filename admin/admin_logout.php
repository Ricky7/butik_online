<?php  
    // Lampirkan db dan User
    require_once "../db.php";
    require_once "../class/Pengurus.php";

    // Buat object user
    $pengurus = new Pengurus($db);

    // Logout! hapus session user
    $pengurus->logout();

    // Redirect ke login
    header('location: admin_login.php');
 ?>