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

    //Jika sudah login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }

    $stmt = $db->prepare("SELECT produk.berat as berat, cart.jumlah_produk as jumlah FROM produk LEFT JOIN cart ON(produk.id_produk=cart.id_produk) WHERE id_user=:id");
    $stmt->execute(array(":id"=>$currentUser['id_user']));
    //$databerat=$stmt->fetch(PDO::FETCH_ASSOC);
    $total_berat = 0;
    if($stmt->rowCount()>0)
    {
      while($databerat=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        $total_berat += $databerat['berat'] * $databerat['jumlah'];
      }
    }


    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');
    //-----------------------------------------------------------------------------
    if(isset($_POST['submit'])) {

      //multiple select value
      $result = $_POST['ongkir'];
      $result_explode = explode('|', $result);
      //echo "Model: ". $result_explode[0]."<br />";
      //echo "Colour: ". $result_explode[1]."<br />";

      if($_POST['kurir'] == 'pos') {
        $kurir = 'PT POS INDONESIA';
      } else if($_POST['kurir'] == 'jne') {
        $kurir = 'JNE';
       } else {
          $kurir = 'TIKI';
        }

      try {
          $order->insertOrder(array(
            'id_user' => $currentUser['id_user'],
            'no_kontak' => $_POST['no_kontak'],
            'alamat' => $_POST['alamat'],
            'no_penerima' => $_POST['no_penerima'],
            'kabupaten' => $_POST['kabupaten'],
            'provinsi' => $_POST['provinsi'],
            'kodepos' => $_POST['kodepos'],
            'tgl_order' => $tanggal,
            'desk_order' => $_POST['desk_order'],
            'jenis_kurir' => $kurir,
            'jenis_paket' => $result_explode[0],
            'ongkir' => $result_explode[1],
            'berat_order' => $_POST['berat'],
            'status_order' => 'Belum dibayar'
          ), $currentUser['id_user']);
          header("location: my_order.php");
        } catch (Exception $e) {
        die($e->getMessage());
      }
    }
 ?> 

<?php
    include "header.php";
?>

<div class="login">
   <div class="container">
      <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li class="active">Order</li>
     </ol>
     <h2>Order</h2>
     <div class="col-md-6 log">      
         <form method="post">

            <h5>No Hp :</h5>
              <Input type="text" value="<?php echo $currentUser['no_kontak']; ?>" name="no_kontak" required>


              <!-- Kota Asal Toko -->
              <Input type="hidden" value="278" id="asal" required> 

            <h5>Provinsi</h5>
            <?php  

              //Get Data Provinsi
              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                  "key: ab60697a32a845a7fea4e3969d3750cb"
                ),
              ));

              $response = curl_exec($curl);
              $err = curl_error($curl);

              echo "<select id='provinsi' class='form-control' style='min-width: 50%' required>";
              echo "<option>Pilih Provinsi Tujuan</option>";
              //echo "<option value='".$currentUser['provinsi']."'>".$currentUser['provinsi']."</option>";
              $data = json_decode($response, true);
              for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
                echo "<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
              }
              echo "</select><br><br>";
              //Get Data Provinsi

            ?>
            <input type="hidden" name="provinsi" id="provinsix" required>

            <h5>Kabupaten</h5>
              <select class="form-control" style="min-width: 50%" id="kabupaten" required> 
              </select>
              <input type="hidden" name="kabupaten" id="kabupatenx" required>

            <h5>Jenis Kurir</h5>
              <select class="form-control" style="min-width: 50%" id="kurir" name="kurir" required>
                <option>-Pilih Kurir-</option>
                <option value="pos">POS INDONESIA</option>
                <option value="jne">JNE</option>
                <option value="tiki">TIKI</option>                
              </select>

            <h5>Ongkir</h5>
              <select class="form-control" style="min-width: 50%" id="ongkir" name="ongkir" required>
              </select><br><br>

            <h5>Kodepos :</h5>
              <Input type="text" value="<?php echo $currentUser['kodepos']; ?>" name="kodepos" required>

            <h5>No Hp Penerima:</h5>
              <Input type="text" name="no_penerima" required>

            <h5>Alamat :</h5>
              <textarea style="min-width: 70%" rows="5" class="form-control" name="alamat" required><?php echo $currentUser['alamat_1']; ?></textarea>

            <h5>Deskripsi :</h5>
              <textarea style="min-width: 70%;" rows="3" class="form-control" name="desk_order" Placeholder="Tulis Deskripsi disini..."></textarea>

            <!-- Berat (gr) -->
              <Input type="hidden" value="<?php echo $total_berat; ?>" id="berat" name="berat" required>

            <h5></h5>
              <input type="submit" value="Order" name="submit" id="ubah">

         </form>

     </div>
    <div class="col-md-6">

      <?php

        $t = "SELECT SUM(harga) as total FROM cart WHERE id_user={$currentUser['id_user']}";
        $total = $db->prepare($t);
        $total->execute();
        $tharga=$total->fetch(PDO::FETCH_ASSOC);

      ?>
      <div class="price-details">
         <h3>Price Details</h3>
         <span>Total</span>
         <span class="total"><?php echo number_format($tharga['total'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span>
         <div class="clearfix"></div>        
       </div> 


      <div class="clearfix"></div>    
     
     <div class="content table-responsive table-full-width">
          <table class="table table-striped">
              <thead>
                <th>Kode SKU</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
              </thead>
              <tbody>
                <?php

                  $getCart = $db->prepare("SELECT *, cart.harga as cartharga FROM cart INNER JOIN produk ON (cart.id_produk=produk.id_produk) WHERE id_user=:id");
                  $getCart->execute(array(":id"=>$currentUser['id_user']));
                  
                  // format mata uang
                  $jumlah_desimal = "0";
                  $pemisah_desimal = ",";
                  $pemisah_ribuan = ".";

                  if($getCart->rowCount()>0)
                  {
                    while($infoCart=$getCart->fetch(PDO::FETCH_ASSOC))
                    {
                      ?>

                        <tr>
                          <td><?php echo $infoCart['kode_SKU'] ?></td>
                          <td><?php echo $infoCart['nama_brg'] ?></td>
                          <td><?php echo number_format($infoCart['cartharga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></td>
                          <td><?php echo $infoCart['jumlah_produk'] ?></td>
                        </tr>

                      <?php
                    }
                  } else {
                    ?>
                        <tr>
                          <td>Anda Belum Belanja</td>
                        </tr>
                        <script>
                          document.getElementById("ubah").disabled = true;
                        </script>
                    <?php
                  }

                ?>
                  
              </tbody>
          </table>

      </div>
    </div>

</div>
<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
<script type="text/javascript">

  $(document).ready(function(){
    $('#provinsi').change(function(){

      //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax 
      var prov = $('#provinsi').val();

          $.ajax({
              type : 'GET',
              url : 'http://localhost:9000/si_mariani/cek_kabupaten.php',
              data :  'prov_id=' + prov,
          success: function (data) {

          //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
          $("#kabupaten").html(data);
        }
            });
    });

    $("#kurir").on('change', function(){
      //Mengambil value dari option select provinsi asal, kabupaten, kurir, berat kemudian parameternya dikirim menggunakan ajax 
      var asal = $('#asal').val();
      var kab = $('#kabupaten').val();
      var kurir = $('#kurir').val();
      var berat = $('#berat').val();

        $.ajax({
            type : 'POST',
            url : 'http://localhost:9000/si_mariani/cek_ongkir.php',
            data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
            success: function (data) {

              //jika data berhasil didapatkan, tampilkan ke dalam element div ongkir
              $("#ongkir").html(data);
            }
        });
    });
  });
</script>
<script>
    
    (function() {
    
        // get references to select list and display text box
        var p = document.getElementById('provinsi');
        var px = document.getElementById('provinsix');

        var k = document.getElementById('kabupaten');
        var kx = document.getElementById('kabupatenx');


        function getSelectedOption(p) {
            var opt;
            for ( var i = 0, len = p.options.length; i < len; i++ ) {
                opt = p.options[i];
                if ( opt.selected === true ) {
                    break;
                }
            }
            return opt;
        }

        function getSelectedOption(k) {
            var opt;
            for ( var i = 0, len = k.options.length; i < len; i++ ) {
                opt = k.options[i];
                if ( opt.selected === true ) {
                    break;
                }
            }
            return opt;
        }

        document.getElementById('ubah').onclick = function () {
            // access text property of selected option
            px.value = p.options[p.selectedIndex].text;
            kx.value = k.options[k.selectedIndex].text;
        }


        
    }());

</script>
<?php
    include "footer.php";
?>