<?php  
    // Lampirkan db dan User
    require_once "db.php";
    ob_start();

 ?>

<!DOCTYPE html>
<html>
<head>
<title>New Fashions a Flat Ecommerce Bootstarp Responsive Website Template | Home :: w3layouts</title>
<link href="assets_index/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" /> -->
<link href="assets_index/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="https://sistemabsensiunk.000webhostapp.com/assets/stylex.css" rel="stylesheet" type="text/css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Raleway:400,200,600,800,700,500,300,100,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Arimo:400,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="assets_index/css/component.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="New Fashions Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" 
        />
<script src="assets_index/js/jquery.min.js"></script>
<script src="assets_index/js/simpleCart.min.js"> </script>
<!-- start menu -->
<link href="assets_index/css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="assets_index/js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- start menu -->
</head>
<body>
<!--header-->
<div class="header2">
     <div class="container">
         <div class="main-header">
              <div class="carting">
                <?php
                    if(!$user->isLoggedIn()){

                        ?>
                            <ul><li><a href="login.php"> LOGIN</a></li></ul>
                        <?php
                    } else {

                        ?>
                            <ul><li><a href="logout.php"> LOGOUT</a></li></ul>
                        <?php
                    }
                ?>
                 
                 </div>
             <div class="logo">
                 <h3><a href="index.php">NEW FASHIONS</a></h3>
              </div>              
             <div class="box_1">
                <?php 

                    if(!$user->isLoggedIn()){

                        ?>
                            <a href="#"><h3>Cart: <span class="simpleCart_total"></span> (<span id="simpleCart_quantity" class="simpleCart_quantity"></span> items)<img src="assets_index/images/cart.png" alt=""/></h3></a>
                        <?php
                    } else {

                        $x = "SELECT SUM(harga) as total FROM cart WHERE id_user={$currentUser['id_user']}";
                        $stmtx = $db->prepare($x);
                        $stmtx->execute();
                        $rowx=$stmtx->fetch(PDO::FETCH_ASSOC);

                        $y = "SELECT SUM(jumlah_produk) as totalbrg FROM cart WHERE id_user={$currentUser['id_user']}";
                        $stmty = $db->prepare($y);
                        $stmty->execute();
                        $rowy=$stmty->fetch(PDO::FETCH_ASSOC);

                        
                        // format mata uang
                        $jumlah_desimal = "0";
                        $pemisah_desimal = ",";
                        $pemisah_ribuan = ".";

                        ?>
                            <a href="cart.php"><h3>Cart: <?php echo "Rp ".number_format($rowx['total'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?> (<?php echo $rowy['totalbrg']; ?> items)<img src="assets_index/images/cart.png" alt=""/></h3></a>
                        <?php
                    }

                ?>     
             
             </div>
             
             <div class="clearfix"></div>
         </div>
                
                <!-- start header menu -->
        <ul class="megamenu skyblue">
            <li class="grid"><a class="color1" href="index.php">BERANDA</a></li>
            <li class="grid"><a href="#">WANITA</a>
                <div class="megapanel">
                    <div class="row">
                        <div class="col1">
                            <div class="h_nav">
                                <h4>shop</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Dress">Dress</a></li>
                                    <li><a href="index.php?kategori=Atasan">Atasan</a></li>
                                    <li><a href="index.php?kategori=Rok">Rok</a></li>
                                    <li><a href="index.php?kategori=Batik & Kebaya">Batik & Kebaya</a></li>
                                    <li><a href="index.php?kategori=Pakaian dalam">Pakaian dalam</a></li>
                                </ul>   
                            </div>                          
                        </div>
                        <div class="col1">
                            <div class="h_nav">
                                <h4>shop</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Baju Tidur">Baju Tidur</a></li>
                                    <li><a href="index.php?kategori=Outerwear">Outerwear</a></li>
                                    <li><a href="index.php?kategori=Celana">Celana</a></li>
                                    <li><a href="index.php?kategori=Jeans">Jeans</a></li>
                                    <li><a href="index.php?kategori=Lainnya Perempuan">Lain-lain</a></li>
                                </ul>   
                            </div>                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col2"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                    </div>
                    </div>
                </li>
                <li><a href="#">PRIA</a><div class="megapanel">
                    <div class="row">
                        <div class="col1">
                            <div class="h_nav">
                                <h4>shop</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Jaket & Blazer">Jaket & Blazer</a></li>
                                    <li><a href="index.php?kategori=Kemeja">Kemeja</a></li>
                                    <li><a href="index.php?kategori=Sweater">Sweater</a></li>
                                    <li><a href="index.php?kategori=Polo Shirt">Polo Shirt</a></li>
                                    <li><a href="index.php?kategori=Formal">Formal</a></li>
                                </ul>   
                            </div>                          
                        </div>
                        <div class="col1">
                            <div class="h_nav">
                                <h4>shop</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Kaos">Kaos</a></li>
                                    <li><a href="index.php?kategori=Celana Panjang">Celana Panjang</a></li>
                                    <li><a href="index.php?kategori=Celana Pendek">Celana Pendek</a></li>
                                    <li><a href="Pakaian Dalam">Pakaian Dalam</a></li>
                                    <li><a href="Lainnya Lelaki">Lain-lain</a></li>
                                </ul>   
                            </div>                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col2"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                    </div>
                    </div>
                </li>                         
                <li><a href="#">BELANJA</a>
                <div class="megapanel">
                    <div class="row">
                        <div class="col1">
                            <div class="h_nav">
                                <h4>Women</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Dress">Dress</a></li>
                                    <li><a href="index.php?kategori=Atasan">Atasan</a></li>
                                    <li><a href="index.php?kategori=Rok">Rok</a></li>
                                    <li><a href="index.php?kategori=Batik & Kebaya">Batik & Kebaya</a></li>
                                    <li><a href="index.php?kategori=Pakaian dalam">Pakaian dalam</a></li>
                                </ul>   
                            </div>                          
                        </div>
                        <div class="col1">
                            <div class="h_nav">
                                <h4>Women</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Baju Tidur">Baju Tidur</a></li>
                                    <li><a href="index.php?kategori=Outerwear">Outerwear</a></li>
                                    <li><a href="index.php?kategori=Celana">Celana</a></li>
                                    <li><a href="index.php?kategori=Jeans">Jeans</a></li>
                                    <li><a href="index.php?kategori=Lainnya Perempuan">Lain-lain</a></li>
                                </ul>   
                            </div>                          
                        </div>
                        <div class="col1">
                            <div class="h_nav">
                                <h4>Men</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Jaket & Blazer">Jaket & Blazer</a></li>
                                    <li><a href="index.php?kategori=Kemeja">Kemeja</a></li>
                                    <li><a href="index.php?kategori=Sweater">Sweater</a></li>
                                    <li><a href="index.php?kategori=Polo Shirt">Polo Shirt</a></li>
                                    <li><a href="index.php?kategori=Formal">Formal</a></li>
                                </ul>   
                            </div>                          
                        </div>
                        <div class="col1">
                            <div class="h_nav">
                                <h4>Men</h4>
                                <ul>
                                    <li><a href="index.php?kategori=Kaos">Kaos</a></li>
                                    <li><a href="index.php?kategori=Celana Panjang">Celana Panjang</a></li>
                                    <li><a href="index.php?kategori=Celana Pendek">Celana Pendek</a></li>
                                    <li><a href="Pakaian Dalam">Pakaian Dalam</a></li>
                                    <li><a href="Lainnya Lelaki">Lain-lain</a></li>
                                </ul>   
                            </div>                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col2"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                    </div>
                    </div>
                </li>
                <li class="grid"><a href="about.php"> INFORMASI </a></li>       
                <li><a href="#">AKUN</a><div class="megapanel">
                    <div class="row">
                        <div class="col1">
                            <div class="h_nav">
                                <h4>Menu</h4>
                                <ul>
                                    <li><a href="my_order.php">My Order</a></li>
                                    <li><a href="my_profile.php">My Profile</a></li>
                                    <li><a href="cart.php">My Cart</a></li>
                                    <li><a href="#"></a></li>
                                    <li><a href="#"></a></li>
                                </ul>   
                            </div>                          
                        </div>
                    </div>
                    <div class="row">
                        <div class="col2"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                        <div class="col1"></div>
                    </div>
                    </div>
                </li>
                </ul>            
              <div class="clearfix"></div>              
     </div>
</div>