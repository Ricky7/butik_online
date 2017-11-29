<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);
    $produk = new Product($db);    

    $pengurus->cekLogin();
    
    if(isset($_POST['id'])) {

    	$id = $_POST['id'];
    	$produk->delKasirCart($id);
    }

?>


