<?php  
    // Lampirkan db dan User
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
    $getID = $currentUser['id_user'];

    //Jika sudah login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }

 ?>

<?php
    include "header.php";
?>

<br><br>
<!-- content -->
<div class="features" id="features">
     <div class="container">
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <li class="active">My Order</li>
         </ol>
         <div class="cart-top">
            Unverified
         </div> 
        <div class="row">                            
            <div class="col-md-12">
                <div class="content table-responsive table-full-width">
                  <table class="table table-striped">
                      <thead>
                        <th>ID Order</th>
                        <th>Waktu Order</th>
                        <th>Deskripsi Order</th>
                        <th>Berat Order</th>
                        <th>Status Pembayaran</th>
                        <th>Note</th>
                        <th>Opsi</th>
                      </thead>
                      <tbody>
                        <?php

                            $tb = "SELECT * FROM tbl_order WHERE (id_user, status_order) IN (({$getID}, 'Pending'), ({$getID}, 'Belum Dibayar')) ORDER BY status_order ASC";
                            $tbl = $db->prepare($tb);
                            $tbl->execute();

                            if($tbl->rowCount()>0)
                            {
                                while($torder=$tbl->fetch(PDO::FETCH_ASSOC))
                                {
                                   ?>
                                        <tr>
                                            <td><?php echo $torder['id_order'] ?></td>
                                            <td><?php echo $torder['tgl_order'] ?></td>
                                            <td><?php echo $torder['desk_order'] ?></td>
                                            <td><?php echo $torder['berat_order'] ?></td>
                                            <td><?php echo $torder['status_order'] ?></td>
                                            <td><?php echo $torder['note'] ?></td>
                                            <td><a href="bayar.php?order_id=<?php echo $torder['id_order'] ?>">Open</a></td>
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
        <div class="cart-top">
            Verified
        </div>
        <div class="row">                            
            <div class="col-md-12">
                <div class="content table-responsive table-full-width">
                  <table class="table table-striped">
                      <thead>
                        <th>ID Order</th>
                        <th>Tanggal Kirim</th>
                        <th>No Resi</th>
                        <th>Kurir Antar</th>
                        <th>Tanggal Terkirim</th>
                        <th>Status Pembayaran</th>
                        <th>Opsi</th>
                      </thead>
                      <tbody>
                        <?php

                            $tb = "SELECT * FROM tbl_order INNER JOIN kirim ON (tbl_order.id_kirim=kirim.id_kirim) WHERE (id_user, status_order) IN (({$getID}, 'Dikirim'), ({$getID}, 'Terkirim')) ORDER BY status_order ASC";
                            $tbl = $db->prepare($tb);
                            $tbl->execute();

                            if($tbl->rowCount()>0)
                            {
                                while($dorder=$tbl->fetch(PDO::FETCH_ASSOC))
                                {
                                   ?>
                                        <tr>
                                            <td><?php echo $dorder['id_order'] ?></td>
                                            <td><?php echo $dorder['tgl_kirim'] ?></td>
                                            <td><?php echo $dorder['no_resi'] ?></td>
                                            <td><?php echo $dorder['jenis_kurir'] ?></td>
                                            <td><?php echo $dorder['tgl_terkirim'] ?></td>
                                            <td><?php echo $dorder['status_order'] ?></td>
                                            <?php 
                                              if($dorder['status_order'] == 'Dikirim') {
                                                echo "<td><a href='#' id='".$dorder['id_order']."' class='ganti'>Open</a></td>";
                                              } else {
                                                echo "<td><font color='red'>DONE</font></td>";
                                              }
                                            ?>
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

<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
</script>

<script type="text/javascript">
$(function() {
$(".ganti").click(function() {
  var id = $(this).attr("id");
  var dataString = 'id='+ id ;
  var parent = $(this).parent();
  if (confirm('Apakah kamu yakin ingin mengkonfirmasi kiriman ini?'+dataString)) {
    $.ajax({
      type: "POST",
      url: "konfirmasi_kiriman.php",
      data: dataString,
      cache: false,

      success: function(html)
      {
        // var redirect = 'cart.php';
        // location.href = redirect;
        window.location.reload();
      }
    });
  }
  return false;
  });
});
</script>
<?php

    include "footer.php";

?>