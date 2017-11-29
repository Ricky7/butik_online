<?php

    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";
    require_once "class/Product.php";

    //Buat object user

    $produk = new Product($db); 

    $user = new User($db);   

    //Jika tidak login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }
    
    if(isset($_POST['id'])) {

    	$id = $_POST['id'];
    	$produk->deleteCart($id);
    }
    


?>


