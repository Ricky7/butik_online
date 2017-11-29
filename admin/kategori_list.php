<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);  

    $produk = new Product($db);  

    $pengurus->cekLogin();

    if(isset($_POST['submit'])) {

    	try {
	    	$produk->insertKategori(array(
	    		'nama_kategori' => $_POST['nama_kategori'],
	    		'gender' => $_POST['gender'],
	    		'desk_kategori' => $_POST['desk_kategori']
	    	));
	    	header("Refresh:0");
	    	//header("location: add_produk.php");
	    } catch (Exception $e) {
			die($e->getMessage());
		}
    }

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
		                <div class="row">
		                	<form method="post" action="" enctype="multipart/form-data" >
			                	<div class="col-md-3">
	                                
	                            </div>
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                                    <label>Nama Kategori</label>
	                                    <input type="text" name="nama_kategori" class="form-control border-input" placeholder="Nama Kategori" required>
	                                </div>
	                                <div class="form-group">
	                                    <label>Jenis Kelamin</label>
	                                    <select class="form-control border-input" placeholder="Jenis Kelamin" name="gender" required>
	                                    	<option></option>
	                                    	<option value="PRIA">PRIA</option>
	                                    	<option value="WANITA">WANITA</option>
	                                    </select>
	                                </div>
	                                <div class="form-group">
	                                    <label>Deskripsi</label>
                                        <textarea rows="5" name="desk_kategori" class="form-control border-input" placeholder="Here can be your description"></textarea>
	                                </div>
	                                <div class="text-center">
                                        <input type="submit" name="submit" class="btn btn-info btn-fill btn-wd">
                                    </div>
	                            </div>
	                            <div class="col-md-3">
	                                
	                            </div>
	                        </form>
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
	                                        <th>Nama Kategori</th>
	                                        <th>Gender</th>
	                                    	<th>Deskripsi</th>
	                                    	<th>Opsi</th>
	                                    </thead>
	                                    <tbody>
	                                    	<?php
												$query = "SELECT * FROM kategori";       
												$records_per_page=5;
												$newquery = $produk->paging($query,$records_per_page);
												$produk->viewKategori($newquery);
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
			url: "delete_kategori.php",
			data: dataString,
			cache: false,

			success: function(html)
			{
				var redirect = 'kategori_list.php?deleted';
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
