<?php
    // Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Order.php";

    //Buat object user
    $pengurus = new Pengurus($db);

    $getID = $pengurus->getPengurus();

    $order = new Order($db);   

    // format mata uang
    $jumlah_desimal = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan = ".";

    if(isset($_GET['order_id']) && isset($_GET['stat']))
    {
        $id = $_GET['order_id'];
        $stat = $_GET['stat'];
        extract($order->getOrder($id, $stat)); 
    }

    //Jika sudah login
    if(!$pengurus->isLoggedIn()){
        header("location: admin_login.php");
    }

    if(isset($_POST['submit'])) {

        $alamat_kirim = $alamat.' '.$kabupaten.', '.$provinsi.', '.$kodepos;
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_kirim = date('Y-m-d H:i:s');

        try {
            $order->kirimBarang(array(
                'id_order' => $id,
                'alamat_kirim' => $alamat_kirim,
                'tgl_kirim' => $tanggal_kirim,
                'jenis_kurir' => $jenis_kurir,
                'jenis_paket' => $jenis_paket,
                'berat_paket' => $berat_order,
                'no_resi' => $_POST['resi']
            ), $id, $_POST['note']);
            //header("Refresh:0");
            header("location: order_dibayar.php");
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Admin Dashboard</title>

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
                                <h4 class="title">Order</h4>
                                <p class="category">Order Dibayar</p>
                            </div>
                            
                            <div class="content">
                                <form method="post" enctype="multipart/form-data" >

                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <th><b>Judul</b></th>
                                                        <th><b>Isi</b></th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>No HP Pemesan</td>
                                                            <td><?php echo $no_kontak ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alamat</td>
                                                            <td><?php echo $alamat.' '.$kabupaten.', '.$provinsi ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kodepos</td>
                                                            <td><?php echo $kodepos ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No HP Penerima</td>
                                                            <td><?php echo $no_penerima ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Waktu Order</td>
                                                            <td><?php echo $tgl_order ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deskripsi</td>
                                                            <td><?php echo $desk_order ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kurir Antar</td>
                                                            <td><?php echo $jenis_kurir.' '. $jenis_paket ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ongkos Kirim(Rp)/Berat(gr)</td>
                                                            <td><?php echo "Rp. ".number_format($ongkir,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan).' / '. $berat_order.'gr' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Bank/Atas Nama/No Rek</td>
                                                            <td><?php echo $nama_bank.' '. $nama_rek.' '.$no_rek ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nominal Transfer</td>
                                                            <td><?php echo "Rp. ".number_format($nominal_transfer,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Detail Transfer</td>
                                                            <td><?php echo $detail_transfer ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Note</td>
                                                            <td><?php echo $note ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="content table-responsive table-full-width">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <th>Kode SKU</th>
                                                        <th>Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Jumlah Produk</th>
                                                        <th>Harga</th>
                                                        <th>Ukuran</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                            $tb = "SELECT *, order_detail.harga as hargax FROM order_detail INNER JOIN produk ON (order_detail.id_produk=produk.id_produk) WHERE order_detail.id_order = {$id}";
                                                            $tbl = $db->prepare($tb);
                                                            $tbl->execute();

                                                            if($tbl->rowCount()>0)
                                                            {
                                                                while($produk_order=$tbl->fetch(PDO::FETCH_ASSOC))
                                                                {
                                                                   ?>
                                                                        <tr>
                                                                            <td><?php echo $produk_order['kode_SKU'] ?></td>
                                                                            <td><img src="../assets/img_produk/<?php echo $produk_order['gambar'] ?>" width="30px" height="60px"></td>
                                                                            <td><?php echo $produk_order['nama_brg'] ?></td>
                                                                            <td><?php echo $produk_order['jumlah_produk'] ?></td>
                                                                            <td><?php echo $produk_order['hargax'] ?></td>
                                                                            <td><?php echo $produk_order['ukuran'] ?></td>
                                                                        </tr>
                                                                   <?php 
                                                                }
                                                            }

                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <form method="post">
                                                    <textarea name="note" class="form-control border-input"  Placeholder="Isi note bila ada"></textarea>
                                                    <input type="hidden" name="status_order" value="Dikirim">
                                                    <div class="content table-responsive table-full-width">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td>No Resi Pengiriman</td>
                                                                    <td><input type="text" name="resi" class="form-control border-input" required></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="text-center">
                                                        <input type="submit" name="submit" class="btn btn-info btn-fill btn-wd">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
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
