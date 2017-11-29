<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);
    $roles = $pengurus->getPengurus();
    $role = $roles['role'];
    

    //Jika sudah login
    if($pengurus->isLoggedIn()){
        
        switch ($role) {
          case 'operator':
            header("location: error404.php");
            break;

        }
    }

    $pengurus->cekLogin();  

    $produk = new Product($db);  

    if(isset($_POST['submit'])) {

        try {
          $pengurus->tambahPengurus(array(
            'nama' => $_POST['name'],
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role']
          ));
          //header("location: my_order.php");
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
		                <div class="row card">
		                	<form method="post" action="" enctype="multipart/form-data" >
		                		<div class="col-md-12">
		                			<div class="header">
		                                <h4 class="title">Daftar Akun Kepengurusan</h4>
		                                <p class="category"></p>
		                            </div>
		                		</div>
			                	<div class="col-md-3">
	                                
	                            </div>
	                            <div class="col-md-6">
	                            	<div class="form-group">
	                                    <label>Name</label>
	                                    <input type="text" name="name" class="form-control border-input" placeholder="Nama Pengurus" required>
	                                </div>
	                            	<div class="form-group">
	                                    <label>Username</label>
	                                    <input type="text" name="username" class="form-control border-input" placeholder="Username" required>
	                                </div>
	                                <div class="form-group">
	                                    <label>Password</label>
                                        <input type="password" name="password" class="form-control border-input" placeholder="Password" required>
	                                </div>
	                                <div class="form-group">
	                                    <label>Role</label>
	                                    <select name="role" class="form-control border-input" required>
	                                    	<option></option>
	                                    	<option value="admin">Admin</option>
	                                    	<option value="operator">Operator</option>
	                                    	<option value="owner">Owner</option>
	                                    	<option value="kasir">Kasir</option>
	                                    </select>
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
	                                        <th>Nama</th>
	                                    	<th>Username</th>
	                                    	<th>Role</th>
	                                    	<th>Opsi</th>
	                                    </thead>
	                                    <tbody>
	                                    	<?php
												$query = "SELECT * FROM pengurus ORDER BY role asc";       
												$records_per_page=5;
												$newquery = $pengurus->paging($query,$records_per_page);
												$pengurus->viewPengurus($newquery);
											 ?>
											 <tr>
										        <td colspan="7" align="center">
										 			<div class="pagination-wrap">
										            <?php $pengurus->paginglink($query,$records_per_page); ?>
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
			url: "delete_pengurus.php",
			data: dataString,
			cache: false,

			success: function(html)
			{
				var redirect = 'pengurus_list.php?deleted';
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
