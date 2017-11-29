<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);
    $getData = $pengurus->getPengurus();
    $getID = $getData['id'];      

    $pengurus->cekLogin();

    $produk = new Product($db);
    
    // format mata uang
    $jumlah_desimal = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan = ".";
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<title>Kasir Dasboard</title>

		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	    <meta name="viewport" content="width=device-width" />
	</head>
	<body>

		<div class="wrapper">
			<div class="sidebar" data-background-color="white" data-active-color="danger">
		        <?php
		            include "kasir_sidebar.php";
		        ?>
		    </div>
		    

		    <div class="main-panel">
				<?php
		            include "kasir_navbar.php";
		        ?>


		        <div class="content">
		            <div class="container-fluid">
		                <div class="row">
		                	<div class="col-md-8">
		                        <div class="card">
		                            <div class="content">
		                                    <div class="form-group">
												<div class="input-group border-input">
												<input id="txtSearch" class="form-control border-input" type="text" placeholder="Search kode SKU produk disini.." />
												<div class="input-group-addon"><i class="ti-search"></i>
												</div>
												</div>
											</div>		                                
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="row">
		                	<div class="col-md-12">
								<?php

								if(isset($_GET['err']))
								{
									?>
							        <div class="alert alert-success">
							    	<strong>Maaf!</strong> terjadi kesalahan... 
									</div>
							        <?php
								}

								if(isset($_GET['success']))
								{
									?>
							        <div class="alert alert-success">
							    	<strong>Pembelian Berhasil!</strong> 
									</div>
							        <?php
								}

								?>
							</div>

		                	<div class="col-md-8">
		                		<div class="card">
		                			<div class="header">
		                                <h4 class="title">Daftar Belanjaan</h4>
		                                <p class="category"></p>
		                            </div>

		                            <div class="content table-responsive table-full-width">
		                                <table class="table">
		                                    <thead>
		                                    	<th>Kode SKU</th>
		                                    	<th>Nama Produk</th>
		                                    	<th>Total Harga</th>
		                                    	<th>Jumlah</th>
		                                    	<th>Aksi</th>
		                                    </thead>
		                                    <tbody>
		                                    <?php

	                                            $tb = "SELECT * FROM cart_kasir INNER JOIN produk ON (cart_kasir.id_produk=produk.id_produk) WHERE (cart_kasir.id_pengurus=$getID)";
	                                            $tbl = $db->prepare($tb);
	                                            $tbl->execute();

	                                            if($tbl->rowCount()>0)
	                                            {
	                                                while($getKC=$tbl->fetch(PDO::FETCH_ASSOC))
	                                                {
	                                                   ?>
	                                                        <tr>
	                                                            <td><?php echo $getKC['kode_SKU'] ?></td>
	                                                            <td><?php echo $getKC['nama_brg'] ?></td>
	                                                            <td><?php echo "Rp. ".number_format($getKC['total_harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></td>
	                                                            <td><?php echo $getKC['jumlah_produk'] ?></td>
	                                                            <td><a href="#" id="<?php echo $getKC['id_produk'] ?>" class="hapus"><i class="ti-trash"></i></a></td>
	                                                        </tr>
	                                                   <?php 
	                                                }
	                                            }

	                                        ?>	
		                                    </tbody>
		                                </table>
		                            </div>
		                		</div>
		                	</div>
		                	<div class="col-md-4">
		                		<div class="card">
		                			<div class="header">
		                                <h4 class="title">Total</h4>
		                                <p class="category"></p>
		                            </div>

		                			<div class="content table-responsive table-full-width">
		                                <table class="table">
		                                    <tbody>
		                                    	<?php

	                                            $tb = "SELECT SUM(cart_kasir.total_harga) as xharga, SUM(cart_kasir.jumlah_produk) as xtotal FROM cart_kasir INNER JOIN produk ON (cart_kasir.id_produk=produk.id_produk) WHERE (cart_kasir.id_pengurus=$getID)";
	                                            $tbls = $db->prepare($tb);
	                                            $tbls->execute();
	                                            $getKCS=$tbls->fetch(PDO::FETCH_ASSOC);

	                                        ?>	
		                                    	<tr>
		                                    		<td>Total Produk</td>
		                                    		<td><?php echo $getKCS['xtotal']; ?></td>
		                                    	</tr>
		                                    	<tr>
		                                    		<td>Total Pembayaran</td>
		                                    		<td><?php echo "Rp. ".number_format($getKCS['xharga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></td>
		                                    	</tr>
		                                    </tbody>
		                                </table>
		                                <center><a href="kasir_bayar.php?id=<?php echo $getID; ?>" class="bayar btn btn-info btn-fill btn-wd"> &nbsp; Bayar</a></center>
		                            </div>
		                		</div>
		                	</div>
		                </div>
		            </div>
		        </div>

		    </div>
		</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function(){
	
	$('#txtSearch').autocomplete({
	    source: "kasir_produk_autocom.php",
	    minLength: 2,
	    select: function(event, ui) {
	        var url = 'kasir_add_cart.php?edit_id='+ui.item.id;
	        if (url != '#') {
	            location.href = url
	        }
	    },
	    open: function(event, ui) {
	        $(".ui-autocomplete").css("z-index", 1000)
	    }
	})
	
});
</script>

<script type="text/javascript">
$(function() {
$(".hapus").click(function() {
	var id = $(this).attr("id");
	var dataString = 'id='+ id ;
	var parent = $(this).parent();
	if (confirm('Are you sure you want to delete this?'+dataString)) {
		$.ajax({
			type: "POST",
			url: "kasir_delete_cart.php",
			data: dataString,
			cache: false,

			success: function(html)
			{
				var redirect = 'kasir_dashboard.php';
				location.href = redirect;
				//window.location.reload();
			}
		});
	}
	return false;
	});
});
</script>
	</body>
</html>
