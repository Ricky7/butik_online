<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);

    $datas = $pengurus->getPengurus();
    $role = $datas['role'];
    $id_pengurus = $datas['id'];
    

    $pengurus->cekLogin();

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
		            		<div class="col-md-12 card">
	                			<div class="header">
	                                <h4 class="title">Ubah Password</h4>
	                                <p class="category"><br></p>
	                            </div>
	                		</div>
		            	</div>
		            	<div class="row">
		                	<br><br>
		                	<div class="col-md-12">
								<?php

									if(isset($_POST['submit'])) {
	    	
								    	try {
								          $pengurus->ubahPassword($id_pengurus, $_POST['old_password'], $_POST['new_password']);
								          //header("location: kasir_ubah_password.php?changed");
								        } catch (Exception $e) {
								        	//die($e->getMessage());

								        }
								    }

								?>
							</div>
		                </div>
		                <div class="row card">
		                	<div class="col-md-4">
		                		<form method="post">
		                			<div class="form-group">
	                                    <label>Password Lama</label>
	                                    <input type="password" name="old_password" class="form-control border-input" placeholder="Nama Pengurus" required>
	                                </div>
	                                <div class="form-group">
	                                    <label>Password Baru</label>
	                                    <input type="password" name="new_password" class="form-control border-input" placeholder="Nama Pengurus" required>
	                                </div>
	                                <div class="text-center">
                                        <input type="submit" name="submit" class="btn btn-info btn-fill btn-wd">
                                    </div>
		                		</form>
		                	</div>
		                </div>
		                
		            </div>
		        </div>

		    </div>
		</div>
	</body>
</html>
