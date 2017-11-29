<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Product.php";
    require_once "../class/Pengurus.php";

    //Buat object user
    $produk = new Product($db);
    $pengurus = new Pengurus($db);
    $pengurus->cekLogin();

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon.png">
		<link href="../template/style.css" rel="stylesheet" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Produk List</title>

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
		                	<div class="col-md-12">
		                        <div class="card">
		                            <div class="header">
		                                <h4 class="title">Semua Produk</h4>
		                                <p class="category"></p>
		                            </div>
		                            <div class="col-md-4">
		                            	<a href="add_produk.php" class="btn btn-info btn-fill btn-wd"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
		                            </div>
		                            
		                            <div class="col-lg-offset-5">
										<form>
											<div class="form-group">
												<div class="input-group border-input">
												<input id="txtSearch" class="form-control border-input" type="text" placeholder="Search for PHP, MySQL, Ajax and jQuery" />
												<div class="input-group-addon"><i class="ti-search"></i>
												</div>
												</div>
											</div>
										</form>  
									</div>

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
		                            <div class="content table-responsive table-full-width">
		                                <table class="table table-striped">
		                                    <thead>
		                                        <th>ID</th>
		                                    	<th>Kode SKU</th>
		                                    	<th>Nama Produk</th>
		                                    	<th>Harga</th>
		                                    	<th>Tanggal Update</th>
		                                    	<th>Diskon</th>
		                                    	<th>Stok S</th>
		                                    	<th>Stok M</th>
		                                    	<th>Stok L</th>
		                                    	<th>Stok XL</th>
		                                    	<th>Aksi</th>
		                                    </thead>
		                                    <tbody>
		                                    	<?php
													$query = "SELECT * FROM produk";       
													$records_per_page=5;
													$newquery = $produk->paging($query,$records_per_page);
													$produk->dataview($newquery);
												 ?>
												 <tr>
											        <td colspan="11" align="center">
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
		</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script> -->
<script>
$(document).ready(function(){
	
	$('#txtSearch').autocomplete({
	    source: "produk_autocom.php",
	    minLength: 2,
	    select: function(event, ui) {
	        var url = 'tambah_stok.php?edit_id='+ui.item.id;
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
			url: "delete_produk.php",
			data: dataString,
			cache: false,

			success: function(html)
			{
				var redirect = 'product_list.php?deleted';
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