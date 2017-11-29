<?php
	// Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);

    $getID = $pengurus->getPengurus();   

    $pengurus->cekLogin();

    $produk = new Product($db);
    
    if(isset($_GET['edit_id']))
    {
        $id = $_GET['edit_id'];
        extract($produk->getID($id)); 
    }

    if(isset($_POST['submit'])) {

        if($_POST['size'] == 'S'){
            if($_POST['jumlah'] > $ukuran_s){
                //$error = true;
                header("Location: kasir_add_cart.php?edit_id=$id&error");
            }
            
        } else if($_POST['size'] == 'M'){
            if($_POST['jumlah'] > $ukuran_m){
                //$error = true;
                header("Location: kasir_add_cart.php?edit_id=$id&error");
                exit;
            }
            
        } else if($_POST['size'] == 'L'){
            if($_POST['jumlah'] > $ukuran_l){
                //$rror = true;
                header("Location: kasir_add_cart.php?edit_id=$id&error");
                exit;
            }
            
        } else if($_POST['size'] == 'XL'){
            if($_POST['jumlah'] > $ukuran_xl){
                //error = true;
                header("Location: kasir_add_cart.php?edit_id=$id&error");
                exit;
            }
            
        }

    	$total_harga = $harga * $_POST['jumlah'];
        try {
            $produk->addKasirCart(array(
            	'id_pengurus' => $getID['id'],
            	'id_produk' => $id,
            	'jumlah_produk' => $_POST['jumlah'],
            	'total_harga' => $total_harga,
                'ukuran' => $_POST['size']
            ));
            //header("Refresh:0");
            header("location: kasir_dashboard.php");
        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }

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
		                	<div class="col-lg-10 col-md-10">
                                <?php if (isset($_GET['error'])): ?>
                                    <div class="error">
                                        <?php echo '<font color="red"><h3 align="center">Ukuran Tidak Tersedia/Habis!</h3></font><br>' ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Informasi Produk</h4>
                                    </div>
                                    <div class="content">
                                        <form method="post" action="" enctype="multipart/form-data" >
                                            <div class="row">
                                                <div class="col-md-3">
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <center><img src="../assets/img_produk/<?php echo $gambar; ?>" class="img-rounded" width="250px" height="250px" /></center>
                                                </div>
                                                <div class="col-md-3">

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <center>ID Produk : <?php echo $id_produk; ?></center>
                                                    <center>Nama Produk : <?php echo $nama_brg; ?></center>
                                                    <center>Kode SKU :<?php echo $kode_SKU; ?></center>
                                                    <center>Harga :<?php echo "Rp. ".number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></center>
                                                    <center>Update Terakhir :<?php echo $tgl_update; ?></center>
                                                    <center>Stok S:<?php echo $ukuran_s; ?></center>
                                                    <center>Stok M:<?php echo $ukuran_m; ?></center>
                                                    <center>Stok L:<?php echo $ukuran_l; ?></center>
                                                    <center>Stok XL:<?php echo $ukuran_xl; ?></center>
                                                    <center>Deskripsi :<?php echo $deskripsi; ?></center>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                </div>
                                            </div>

                                            <div class="row">
                                               
                                                <div class="col-md-6 col-md-offset-3">
                                                    <div class="form-group">
                                                        <label>Ukuran</label>
                                                        <select class="form-control border-input" name="size" required>
                                                            <option></option>
                                                            <option value="S">S</option>
                                                            <option value="M">M</option>
                                                            <option value="L">L</option>
                                                            <option value="XL">XL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jumlah Beli</label>
                                                        <input type="number" name="jumlah" class="form-control border-input" size="10" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                </div>
                                            </div>



                                            <div class="text-center">
                                                <input type="submit" name="submit" class="btn btn-info btn-fill btn-wd">
                                            </div>
                                            <div class="clearfix"></div>
                                        </form>
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