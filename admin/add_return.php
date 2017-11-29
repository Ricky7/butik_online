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
    $datas = $produk->getKategori();

    if(isset($_GET['edit_id']))
    {
        $id = $_GET['edit_id'];
        extract($produk->getID($id)); 
    }

    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');


    if(isset($_POST['submit'])) {

        try {
            $produk->addReturn(array(
                'id_produk' => $id_produk,
                'id_pengurus' => $getID['id'],
                'tgl_return' => $tanggal,
                'note' => $_POST['alasan']
            ));
            //header("Refresh:0");
            header("location: return_list.php");
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
		                	<div class="col-lg-10 col-md-10">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Input Return Produk</h4>
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
                                                    <center>Stok :<?php echo $stok; ?></center>
                                                    <center>Deskripsi :<?php echo $deskripsi; ?></center>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alasan Pengembalian</label>
                                                        <textarea name="alasan" class="form-control border-input" placeholder="Description" rows="8" required></textarea>
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