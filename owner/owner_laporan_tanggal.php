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
	                                <h4 class="title">Laporan Penjualan Online per Tanggal</h4>
	                                <p class="category"><br></p>
	                            </div>
	                		</div>
	                		<div class="col-md-4 card">
	                			<div class="header">
	                				<form method="post">
			                			<input type="date" name="tgl_awal" class="form-control border-input"><br>
		                		</div>
	                		</div>
	                		<div class="col-md-4 card">
	                			<div class="header">
			                			<input type="date" name="tgl_akhir" class="form-control border-input"><br>
		                		</div>
	                		</div>
	                		<div class="col-md-4 card">
	                			<div class="header">
			                			<center><input type="submit" name="find" class="btn btn-info btn-fill btn-wd"></center><br>
			                		</form>
		                		</div>
	                		</div>
	                		<div class="col-md-12 card">
	                			<div class="header">
	                				<?php
	                					echo $tgl = $_POST['tgl_awal'].' - '.$_POST['tgl_akhir'];
	                				?>
	                			</div>
	                		</div>
	                		<div class="col-md-12 card">
		                        <div class="content table-responsive table-full-width">
		                            <table class="table table-striped">
		                                <thead>
		                                	<th>Kode SKU</th>
		                                	<th>Nama Produk</th>
		                                	<th>Stok</th>
		                                	<th>Total Terjual</th>
		                                	<th>Harga</th>
		                                </thead>
		                                <tbody>
		                                	<?php
		                                		if(!$_POST['tgl_awal'] == NULL && !$_POST['tgl_akhir'] == NULL) {
		                                			$tgl_awal = $_POST['tgl_awal'];
		                                			$tgl_akhir = $_POST['tgl_akhir'];
		                                			$tgl = $tgl_awal.' - '.$tgl_akhir;
		                                			$query = "SELECT produk.kode_SKU, produk.nama_brg, produk.stok, SUM(order_detail.jumlah_produk) as total, 
													SUM(order_detail.harga) as harga FROM order_detail INNER JOIN tbl_order INNER JOIN produk ON (order_detail.id_order = tbl_order.id_order) 
													AND (order_detail.id_produk = produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' GROUP BY produk.id_produk";       
													$records_per_page=15;
													$newquery = $produk->paging($query,$records_per_page);
													$produk->laporanPenjualanTanggal($newquery);

													?>
														<tr>
													        <td colspan="7" align="center">
													 			<div class="pagination-wrap">
													            <?php $produk->paginglink($query,$records_per_page); ?>
													        	</div>
													        </td>
													    </tr>
													<?php
		                                		} else {
		                                			?>
		                                				<div class="col-md-12 card">
								                			<div class="header">
								                                <h4 class="title">Silahkan gunakan form pencarian...</h4>
								                                <br>
								                            </div>
								                		</div>
		                                			<?php
		                                		}
		                                		
											 ?>
											 
		                                </tbody>
		                            </table>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>

		    </div>
		</div>

	</body>
</html>
