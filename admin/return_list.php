<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);  

    $produk = new Product($db);  

    $pengurus->cekLogin();


?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Admin Dasboard</title>

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
		                <div class="row card">
		                	<div class="col-md-12">
	                			<div class="header">
	                                <h4 class="title">Daftar Return Barang</h4>
	                                <p class="category"></p><br>
	                            </div>
	                		</div>
		                </div>
		                <div class="row">
		                	<br><br>
		                	<div class="col-md-12">
								<?php

								if(isset($_GET['deleted']))
								{
									?>
							        <div class="alert alert-success">
							    	<strong>Success!</strong> record was deleted... 
									</div>
							        <?php
								}

								?>
							</div>
		                </div>
		                <div class="row">
		                	
		                	<div class="col-md-12">
		                		<div class="content table-responsive table-full-width">
	                                <table class="table table-striped">
	                                    <thead>
	                                        <th>ID</th>
	                                    	<th>Produk</th>
	                                    	<th>Pengurus</th>
	                                    	<th>Waktu Return</th>
	                                    	<th>Catatan</th>
	                                    	<th>Opsi</th>
	                                    </thead>
	                                    <tbody>
	                                    	<?php
												$query = "SELECT returns.id_return, returns.tgl_return, returns.note, produk.nama_brg, pengurus.nama FROM returns INNER JOIN produk INNER JOIN pengurus ON returns.id_produk=produk.id_produk AND returns.id_pengurus=pengurus.id";       
												$records_per_page=5;
												$newquery = $produk->paging($query,$records_per_page);
												$produk->viewReturn($newquery);
											 ?>
											 <tr>
										        <td colspan="7" align="center">
										 			<div class="pagination-wrap">
										            <?php $produk->paginglink($query,$records_per_page); ?>
										        	</div>
										        </td>
										    </tr>
	                                    </tbody>
	                                </table>
	                            </div>
		                	</div>
		                	
		                </div>
		            </div>
		        </div>

		    </div>
		</div>
<script type="text/javascript">
$(function() {
$(".hapus").click(function() {
	var id = $(this).attr("id");
	var dataString = 'id='+ id ;
	var parent = $(this).parent();
	if (confirm('Are you sure you want to delete this?'+dataString)) {
		$.ajax({
			type: "POST",
			url: "delete_return.php",
			data: dataString,
			cache: false,

			success: function(html)
			{
				var redirect = 'return_list.php?deleted';
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
