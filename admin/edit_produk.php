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

        $imgFile = $_FILES['gambar']['name'];
        $tmp_dir = $_FILES['gambar']['tmp_name'];
        $imgSize = $_FILES['gambar']['size'];


        
        $upload_dir = '../assets/img_produk/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
      
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
      
        // rename uploading image
        $userpic = rand(1000,1000000).".".$imgExt;

        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions)){   
            // Check file size '5MB'
            if($imgSize < 5000000)    {
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
            } else {
                $errMSG = "Sorry, your file is too large.";
            }
        } else {
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
        }
        

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d H:i:s');

        try {
            $produk->update($id,array(
                'id_kategori' => $_POST['kategori'],
                'kode_SKU' => $_POST['kode_sku'],
                'nama_brg' => $_POST['nama_brg'],
                'harga' => $_POST['harga'],
                'deskripsi' => $_POST['deskripsi'],
                'merk' => $_POST['merk'],
                'gambar' => $userpic,
                'berat' => $_POST['berat'],
                'tgl_update' => $tanggal,
                'ukuran_s' => $_POST['stok_s'],
                'ukuran_m' => $_POST['stok_m'],
                'ukuran_l' => $_POST['stok_l'],
                'ukuran_xl' => $_POST['stok_xl']
            ));
            header("location: product_list.php");
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
		                	<div class="col-lg-10 col-md-10">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Produk</h4>
                            </div>
                            <div class="content">
                                <form method="post" action="" enctype="multipart/form-data" >
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Kode SKU</label>
                                                <input type="text" name="kode_sku" class="form-control border-input" placeholder="Kode SKU" value="<?php echo $kode_SKU; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input type="text" name="nama_brg" class="form-control border-input" placeholder="Nama Produk" value="<?php echo $nama_brg; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Harga</label>
                                                <input type="text" name="harga" class="form-control border-input" placeholder="Harga" value="<?php echo $harga; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control border-input" id="sel1" name="kategori">
                                                    <option></option>
                                                	<?php foreach ($datas as $value): ?>
												    <option value="<?php echo $value['id_kategori']; ?>"><?php echo $value['nama_kategori'].' ('.$value['gender'].')'; ?></option>
												    <?php endforeach; ?>
												</select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Berat</label>
                                                <input type="number" value="<?php echo $berat; ?>" name="berat" class="form-control border-input" placeholder="Berat" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="gambar" class="form-control border-input" placeholder="Gambar" accept="image/*">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Merk</label>
                                                <input type="text" name="merk" class="form-control border-input" placeholder="Merk" value="<?php echo $merk; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ukuran S</label>
                                                <input type="text" name="stok_s" class="form-control border-input" placeholder="Stok" value="<?php echo $ukuran_s; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ukuran M</label>
                                                <input type="text" name="stok_m" class="form-control border-input" placeholder="Stok" value="<?php echo $ukuran_m; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ukuran L</label>
                                                <input type="text" name="stok_l" class="form-control border-input" placeholder="Stok" value="<?php echo $ukuran_l; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ukuran XL</label>
                                                <input type="text" name="stok_xl" class="form-control border-input" placeholder="Stok" value="<?php echo $ukuran_xl; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea rows="5" name="deskripsi" class="form-control border-input" placeholder="Here can be your description" required><?php echo $deskripsi; ?></textarea>
                                            </div>
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