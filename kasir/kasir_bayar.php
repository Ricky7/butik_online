<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Order.php";

    //Buat object user
    $pengurus = new Pengurus($db);
    $getData = $pengurus->getPengurus();
    $getID = $getData['id'];

    $order = new Order($db);    

    $pengurus->cekLogin();
    
    if(isset($_GET['id'])) {

    	$id_pengurus = $_GET['id'];

        try {
            $order->kasirBayar($id_pengurus);
            header("location: kasir_dashboard.php?success");
        } catch (Exception $e) {
            die($e->getMessage());
            header("location: kasir_dashboard.php?err");
        }
    }

?>


