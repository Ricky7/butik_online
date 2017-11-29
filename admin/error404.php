<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);
    $roles = $pengurus->getPengurus();
    $role = $roles['role'];
    

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
		                	error, Oops Hanya admin yang dapat mengakses Halaman ini !!!
		                </div>
		                
		            </div>
		        </div>

		    </div>
		</div>
	</body>
</html>
