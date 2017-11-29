<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);    

    $pengurus->cekLogin();

    $produk = new Product($db);
    $jumlah_produk = $produk->getJumlahProduk();
    $order_pending = $produk->getJumlahOrder();
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Dasboard</title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	    <meta name="viewport" content="width=device-width" />
	</head>
	<body>

		<div class="wrapper">
			<div class="sidebar" data-background-color="white" data-active-color="danger">
		        <?php
		            include "template/sidebar.php";
		        ?>
		    </div>
		    

		    <div class="main-panel">
				<?php
		            include "template/navbar.php";
		        ?>


		        <div class="content">
		            <div class="container-fluid">
		                <div class="row">
		                	<div class="col-lg-3 col-sm-6">
		                        <div class="card">
		                            <div class="content">
		                                <div class="row">
		                                    <div class="col-xs-5">
		                                        <div class="icon-big icon-warning text-center">
		                                            <i class="ti-server"></i>
		                                        </div>
		                                    </div>
		                                    <div class="col-xs-7">
		                                        <div class="numbers">
		                                            <p>Produk</p>
		                                            <?php echo $jumlah_produk['total']; ?>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="footer">
		                                    <hr />
		                                    <div class="stats">
		                                        <i class="ti-reload"></i> <a href="../admin/product_list.php">Updated now</a>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-lg-3 col-sm-6">
		                        <div class="card">
		                            <div class="content">
		                                <div class="row">
		                                    <div class="col-xs-5">
		                                        <div class="icon-big icon-warning text-center">
		                                            <i class="ti-shopping-cart"></i>
		                                        </div>
		                                    </div>
		                                    <div class="col-xs-7">
		                                        <div class="numbers">
		                                            <p>Order Masuk</p>
		                                            <?php echo $order_pending['order_pending']; ?>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="footer">
		                                    <hr />
		                                    <div class="stats">
		                                        <i class="ti-reload"></i> <a href="../admin/order_pending.php">Updated now</a>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>

		    </div>
		</div>

	</body>
</html>
