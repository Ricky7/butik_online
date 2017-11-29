<?php

    // Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Product.php";

    //Buat object user
    $pengurus = new Pengurus($db);    

    $pengurus->cekLogin();

    $produk = new Product($db);
    $datas = $produk->getKategori();

    if(isset($_GET['edit_id']))
    {
        $id = $_GET['edit_id'];
        extract($produk->getID($id)); 
    }

    if(isset($_POST['submit'])) {

        $stock = $_POST['stok'];
        $ukuran = $_POST['ukuran'];
        try {
            $produk->updateStok('produk', $id, $stock, $ukuran);
            header("Refresh:0");
            //header("location: product_list.php");
        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }

    if(isset($_POST['kirim'])) {

        $diskon = $_POST['diskon'];

        try {
            $produk->updateDiskon('produk', $id, $diskon);
            //header("Refresh:0");
            header("location: product_list.php");
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
                                        <h4 class="title">Informasi Produk</h4>
                                    </div>
                                    <div class="content">
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
                                                    <center>Ukuran S :<?php echo $ukuran_s; ?></center>
                                                    <center>Ukuran M :<?php echo $ukuran_m; ?></center>
                                                    <center>Ukuran L :<?php echo $ukuran_l; ?></center>
                                                    <center>Ukuran XL :<?php echo $ukuran_xl; ?></center>
                                                    <center>Berat :<?php echo $berat; ?></center>
                                                    <center>Deskripsi :<?php echo $deskripsi; ?></center>
                                                    <center><a href="edit_produk.php?edit_id=<?php echo $id_produk; ?>"><i class="ti-pencil-alt"></i></a>
                            <a href="#" id="<?php echo $id_produk; ?>" class="hapus"><i class="ti-trash"></i></a><a href="add_return.php?edit_id=<?php echo $id_produk; ?>"><i class="ti-back-left"></i></a></center>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label>Ukuran</label>
                                                            <select class="form-control border-input" name="ukuran" required>
                                                                <option></option>
                                                                <option value="S">S</option>
                                                                <option value="M">M</option>
                                                                <option value="L">L</option>
                                                                <option value="XL">XL</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tambah Stok</label>
                                                            <input type="number" name="stok" class="form-control border-input" placeholder="Stok" size="10" required>
                                                        </div>
                                                        <div class="text-center">
                                                            <input type="submit" name="submit" class="btn btn-info btn-fill btn-wd">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-3">
                                                    <form method="post" enctype="multipart/form-data" >
                                                        <div class="form-group">
                                                            <label>Input Diskon</label>
                                                            <input type="number" name="diskon" class="form-control border-input" placeholder="Diskon dalam %" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "2" required>
                                                        </div>
                                                        <div class="text-center">
                                                            <input type="submit" name="kirim" class="btn btn-info btn-fill btn-wd">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-3">
                                                    
                                                </div>
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
                var url = 'product_list.php';
                location.href = url; 
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