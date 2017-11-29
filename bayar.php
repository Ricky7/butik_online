<?php  
    // Lampirkan db dan User
    error_reporting(0);
    require_once "db.php";
    require_once "class/User.php";
    require_once "class/Product.php";
    require_once "class/Order.php";

    //Buat object user
    $user = new User($db);

    $produk = new Product($db);

    $order = new Order($db);

    // Ambil data user saat ini
    $currentUser = $user->getUser();

    //Jika sudah login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }

    $getOrderID = $_GET['order_id'];

    if(isset($_POST['submit'])) {

        $imgFile = $_FILES['bukti']['name'];
        $tmp_dir = $_FILES['bukti']['tmp_name'];
        $imgSize = $_FILES['bukti']['size'];


        if(empty($imgFile)) {
            $errMsg = "Please select image File..";
        } else {
            $upload_dir = 'assets/img_bukti/'; // upload directory
 
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
        }

        if(!isset($errMsg)) {

            try {
              $order->insertBayar(array(
                'nama_bank' => $_POST['nama_bank'],
                'nama_rek' => $_POST['atas_nama'],
                'no_rek' => $_POST['no_rek'],
                'nominal_transfer' => $_POST['nominal'],
                'detail_transfer' => $_POST['detail'],
                'bukti_transfer' => $userpic,
                'status_order' => 'Pending'
              ), $currentUser['id_user'], $getOrderID);
              header("location: my_order.php");
            } catch (Exception $e) {
            die($e->getMessage());
            }
        }

        
    }

 ?>

<?php
    include "header.php";
?>

<br><br>
<!-- content -->
<div class="features" id="features">
     <div class="container">
        <div class="row">                            
            <div class="col-md-8">
                <?php

                    // format mata uang
                    $jumlah_desimal = "0";
                    $pemisah_desimal = ",";
                    $pemisah_ribuan = ".";

                    $getOrderID = $_GET['order_id'];

                    $tb = "SELECT * FROM tbl_order WHERE id_user={$currentUser['id_user']} AND id_order={$getOrderID}";
                    $tbl = $db->prepare($tb);
                    $tbl->execute();
                    $torder=$tbl->fetch(PDO::FETCH_ASSOC);

                  ?>
                  <div class="price-details">
                    <div class="content table-responsive table-full-width">
                        <h4>Order Information</h4><br>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><span>Alamat</span></td>
                                    <td><span class="total"><?php echo $torder['alamat'],' ', $torder['kabupaten'],', ', $torder['provinsi'],', ', $torder['kodepos'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>No Kontak</span></td>
                                    <td><span class="total"><?php echo $torder['no_kontak'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>No Penerima</span></td>
                                    <td><span class="total"><?php echo $torder['no_penerima'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Waktu Order</span></td>
                                    <td><span class="total"><?php echo $torder['tgl_order'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Deskripsi Order</span></td>
                                    <td><span class="total"><?php if($torder['desk_order'] == ''){ echo "tidak ada deskripsi"; } else { echo $torder['desk_order']; } ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Metode Pengiriman</span></td>
                                    <td><span class="total"><?php echo $torder['jenis_kurir'],', ', $torder['jenis_paket'] ?></span></td>
                                </tr>
                                <tr>
                                    <td><span>Ongkir/Berat Pesanan</span></td>
                                    <td><span class="total"><?php echo "Rp. ".number_format($torder['ongkir'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan),'/', $torder['berat_order'].'gr' ?></span></td>
                                </tr>  
                            </tbody>
                        </table>

                         <div class="clearfix"></div>
                    </div> 

                   </div> 

                   <div class="price-details">
                        <div class="content table-responsive table-full-width">
                            <br><h4>Produk yang dibeli</h4><br>
                          <table class="table table-striped">
                              <thead>
                                <th>Nama Produk</th>
                                <th>Satuan</th>
                                <th>Jumlah Produk</th>
                                <th>Total</th>
                                <th>Ukuran</th>
                              </thead>
                              <tbody>
                                <?php

                                        $getProduk = $db->prepare("SELECT produk.nama_brg,order_detail.harga,order_detail.jumlah_produk, order_detail.ukuran FROM order_detail RIGHT JOIN produk ON (order_detail.id_produk=produk.id_produk) WHERE order_detail.id_order=:id");
                                        $getProduk->execute(array(":id"=>$getOrderID));
                                      
                                        // format mata uang
                                        $jumlah_desimal = "0";
                                        $pemisah_desimal = ",";
                                        $pemisah_ribuan = ".";

                                        if($getProduk->rowCount()>0)
                                        {
                                            while($infoProduk=$getProduk->fetch(PDO::FETCH_ASSOC))
                                            {
                                            ?>
                                                <tr>
                                                    <td><?php echo $infoProduk['nama_brg'] ?></td>
                                                    <td><?php echo "Rp. ".number_format($infoProduk['harga']/$infoProduk['jumlah_produk'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>
                                                    <td><?php echo $infoProduk['jumlah_produk'] ?></td>
                                                    <td><?php echo "Rp. ".number_format($infoProduk['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>  
                                                    <td><?php echo $infoProduk['ukuran'] ?></td>
                                                </tr>
                                            <?php
                                            }
                                        }

                                ?>
                                
                              </tbody>
                          </table>
                        </div>
                   </div>
                   <?php

                        $getHarga = $db->prepare("SELECT SUM(harga) as xtotal FROM order_detail  WHERE id_order=:id");
                        $getHarga->execute(array(":id"=>$getOrderID));
                        $xharga = $getHarga->fetch(PDO::FETCH_ASSOC);

                   ?>
                    <div class="price-details">
                        <br>
                        <span>Total Yang Harus DiBayar</span>
                        <span class="total"><?php echo "Rp. ".number_format($xharga['xtotal']+$torder['ongkir'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></span>
                        <br>
                        <div class="clearfix"></div> 
                    </div>

                    <div class="price-details">
                        <br><h4>Formulir Pembayaran</h4><br>
                        <form method="post" enctype="multipart/form-data">

                            <h5>Nama Bank :</h5>
                            <select name="nama_bank" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" required>
                                <option></option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BRI">BRI</option>
                            </select>

                            <h5>Atas Nama :</h5>
                            <Input type="text" name="atas_nama" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" required>

                            <h5>No Rek :</h5>
                            <Input type="text" name="no_rek" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" required>

                            <!-- <h5>Nominal Transfer :</h5> -->
                            <Input type="hidden" name="nominal" value="<?php echo $xharga['xtotal']+$torder['ongkir']; ?>" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" required>

                            <h5>Bukti Pembayaran :</h5>
                            <input type="file" name="bukti" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" accept="image/*" required>
                            <?php echo $errMsg; ?>
                            
                            
                            <h5>Detail Transfer :</h5>
                            <textarea name="detail" Placeholder="Isi bila ada catatan tambahan" class="form-control" style="min-width: 50%; margin-top: 10px; margin-bottom: 10px;" rows="7"></textarea>

                            <h5></h5>
                            <input type="submit" value="Order" name="submit" class="form-control">
                        </form>
                    </div>

            </div>
            <div class="col-md-4">
                <div class="content table-responsive table-full-width">
                    <h4>Alamat Pembayaran</h4><br>
                  <table class="table table-striped">
                      <thead>
                        <th>Nama Bank</th>
                        <th>Atas Nama</th>
                        <th>No Rek</th>
                      </thead>
                      <tbody>
                        <tr>
                            <td>BCA</td>
                            <td>Mariani Sinaga</td>
                            <td>84746593</td>
                        </tr>
                        <tr>
                            <td>BNI</td>
                            <td>Mariani Sinaga</td>
                            <td>46355292</td>
                        </tr>
                        <tr>
                            <td>BRI</td>
                            <td>Mariani Sinaga</td>
                            <td>945900476</td>
                        </tr>
                        <tr>
                            <td>Mandiri</td>
                            <td>Mariani Sinaga</td>
                            <td>746295886</td>
                        </tr>
                      </tbody>
                  </table>
                </div>
            </div>
        </div>             
    </div>
</div>             
<br><br><br>
<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
<?php

    include "footer.php";

?>