<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    error_reporting(0);
    //Buat object user
    $pengurus = new Pengurus($db);    

    $pengurus->cekLogin();

    $produk = new Product($db);
    $jumlah_produk = $produk->getJumlahProduk();
    $kasir = $produk->getKasir();


?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Owner Dasboard</title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	    <meta name="viewport" content="width=device-width" />
	</head>
	<body>

		<div class="wrapper">
			<div class="sidebar" data-background-color="white" data-active-color="danger">
		        <?php
		            include "owner_sidebar.php";
		        ?>
		    </div>
		    

		    <div class="main-panel">
				<?php
		            include "owner_navbar.php";
		        ?>


		        <div class="content">
		            <div class="container-fluid">
		                <div class="row">
		                	<div class="col-md-12 card">
	                			<div class="header">
	                                <h4 class="title">Cetak Laporan</h4>
	                                <p class="category"><br></p>
	                            </div>
	                		</div>
	                	</div>

	                	<div class="row card">
	                		<form method="post" action="laporan_online_pdf.php">
	                		<div class="col-md-4">
	                			<div class="header">
			                		<h5>Laporan Penjualan Online</h5>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_awal" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_akhir" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<center><input type="submit" value="Cetak" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
		                		</div>
	                		</div>
	                		</form>
	                	</div>	

	                	<div class="row card">
	                		<form method="post" action="laporan_offline_pdf.php">
	                		<div class="col-md-4">
	                			<div class="header">
			                		<h5>Laporan Penjualan Offline</h5>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_awal" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_akhir" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<center><input type="submit" value="Cetak" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
		                		</div>
	                		</div>
	                		</form>
	                	</div>

	                	<div class="row card">
	                		<form method="post" action="laporan_produk_kembali.php">
	                		<div class="col-md-4">
	                			<div class="header">
			                		<h5>Laporan Produk Kembali</h5>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_awal" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-3">
	                			<div class="header">
			                			<input type="date" name="tgl_akhir" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<center><input type="submit" value="Cetak" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
		                		</div>
	                		</div>
	                		</form>
	                	</div>

	                	<div class="row card">
	                		<form method="post" action="laporan_per_kasir.php">
	                		<div class="col-md-4">
	                			<div class="header">
			                		<h5>Laporan Penjualan /kasir</h5>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
		                			<select class="form-control border-input" name="id_kasir" required>
		                				<option></option>
						                <?php foreach ($kasir as $value): ?>
						                <option value="<?php echo $value['id']; ?>"><?php echo $value['nama']; ?></option>
						                <?php endforeach; ?>
		                			</select>
		                			<br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<input type="date" name="tgl_awal" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<input type="date" name="tgl_akhir" class="form-control border-input" required><br>
		                		</div>
	                		</div>

	                		<div class="col-md-2">
	                			<div class="header">
			                			<center><input type="submit" value="Cetak" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
		                		</div>
	                		</div>
	                		</form>
	                	</div>

	                	<div class="row card">
	                		<form method="post" action="laporan_stok_produk.php">
	                		<div class="col-md-4">
	                			<div class="header">
			                		<h5>Laporan Stok Produk</h5>
		                		</div>
	                		</div>

	                		<div class="col-md-2 col-md-offset-6">
	                			<div class="header">
			                			<center><input type="submit" value="Cetak" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
		                		</div>
	                		</div>
	                		</form>
	                	</div>
	                		
		            </div>
		        </div>

		    </div>
		</div>

	</body>
</html>
