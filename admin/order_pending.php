<?php
    // Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";
    require_once "../class/Order.php";

    //Buat object user
    $pengurus = new Pengurus($db); 

    $order = new Order($db);   

    //Jika sudah login
    if(!$pengurus->isLoggedIn()){
        header("location: admin_login.php");
    }
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Paper Dashboard by Creative Tim</title>

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
                                <h4 class="title">Order List</h4>
                                <p class="category">Order Pending</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Waktu Order</th>
                                        <th>Provinsi</th>
                                        <th>Nama Bank</th>
                                        <th>Nominal Transfer</th>
                                        <th>Opsi</th>
                                    </thead>
                                    <tbody>
                                        <?php

                                            $tb = "SELECT * FROM tbl_order WHERE status_order='Pending' ORDER BY tgl_order DESC ";
                                            $tbl = $db->prepare($tb);
                                            $tbl->execute();

                                            if($tbl->rowCount()>0)
                                            {
                                                while($tblpending=$tbl->fetch(PDO::FETCH_ASSOC))
                                                {
                                                   ?>
                                                        <tr>
                                                            <td><?php echo $tblpending['id_order'] ?></td>
                                                            <td><?php echo $tblpending['tgl_order'] ?></td>
                                                            <td><?php echo $tblpending['provinsi'] ?></td>
                                                            <td><?php echo $tblpending['nama_bank'] ?></td>
                                                            <td><?php echo $tblpending['nominal_transfer'] ?></td>
                                                            <td><a href="order_pending_spec.php?order_id=<?php echo $tblpending['id_order'] ?>&stat=Pending">Open</a></td>
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
                </div>
            </div>
        </div>

    </div>
</div>


</body>
</html>
