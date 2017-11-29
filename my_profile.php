<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";

    //Buat object user
    $user = new User($db);

    // Ambil data user saat ini
    $currentUser = $user->getUser();

    //Jika sudah login
    if(!$user->isLoggedIn()){
        header("location: index.php"); //redirect ke index
    }

    //jika ada data yg dikirim
    if(isset($_POST['update'])){

        try {
          $user->ubahProfil(array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'kota' => $_POST['kota'],
            'provinsi' => $_POST['provinsi'],
            'kodepos' => $_POST['kodepos'],
            'no_kontak' => $_POST['no_kontak'],
            'alamat_1' => $_POST['alamat']
          ), $currentUser['id_user']);
          header("location: my_profile.php?success");
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
      <li class="active">Profile</li>
     </ol>
     <div class="row">
        <div class="col-md-12">
          <?php

            if(isset($_POST['ubah'])) {
  
              try {
                  $user->ubahPassword($currentUser['id_user'], $_POST['old_pass'], $_POST['new_pass']);
                  //header("location: kasir_ubah_password.php?changed");
                } catch (Exception $e) {
                  //die($e->getMessage());

                }
            }

            if(isset($_GET['success']))
            {
              ?>
                <div class="alert alert-success">
                  <strong>Update Berhasil!</strong> 
                </div>
              <?php
            }

          ?>
        </div>
     </div>

     <div class="row">
        <div class="col-md-6 log login-right">
          <h3>PROFILE SAYA</h3>      
             <form method="post">
               <h5>Username:</h5>  
               <input type="text" value="<?php echo $currentUser['username'] ?>" disabled>

               <h5>Nama Depan:</h5>  
               <input type="text" name="first_name" placeholder="Nama Depan" value="<?php echo $currentUser['first_name'] ?>" required>

               <h5>Nama Belakang:</h5>
               <input type="text" name="last_name" placeholder="Nama Belakang" value="<?php echo $currentUser['last_name'] ?>" required>

               <h5>Kota:</h5>
               <input type="text" name="kota" placeholder="Kota" value="<?php echo $currentUser['kota'] ?>" required>

               <h5>Provinsi:</h5>
               <input type="text" name="provinsi" placeholder="Provinsi" value="<?php echo $currentUser['provinsi'] ?>" required>

               <h5>KodePos:</h5>
               <input type="text" name="kodepos" placeholder="Kodepos" value="<?php echo $currentUser['kodepos'] ?>" required>

               <h5>No Kontak:</h5>
               <input type="text" name="no_kontak" placeholder="No Kontak" value="<?php echo $currentUser['no_kontak'] ?>" required>

               <h5>Alamat:</h5>
               <textarea name="alamat" style="min-width: 70%" rows="5" class="form-control"><?php echo $currentUser['alamat_1']; ?></textarea>

               <input type="submit" value="Update" name="update">
                
             </form>         
         </div>
       
          <div class="col-md-6 log login-right">
            <h3>UBAH PASSWORD</h3>
              <form method="post">
              <h5>Password Lama:</h5>  
               <input type="password" name="old_pass" placeholder="Password Lama" required>

               <h5>Password Baru:</h5>
               <input type="password" name="new_pass" placeholder="Password Baru"required>

               <input type="submit" value="Ubah" name="ubah">
             </form>
         </div>
         <div class="clearfix"></div> 
     </div>
     
        
     
   </div>
</div>
<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
<?php
    include "footer.php";
?>