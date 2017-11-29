<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";

    // Buat object user
    $user = new User($db);

    // Jika sudah login
    if($user->isLoggedIn()){
        header("location: index.php"); //Redirect ke index
    }

    //Jika ada data dikirim
    if(isset($_POST['kirim'])){
        $nama_depan = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Registrasi user baru
        if($user->register($nama_depan, $nama_belakang, $username, $password)){
            // Jika berhasil set variable success ke true
            $success = true;
            header ("location: login.php");
        }else{
            // Jika gagal, ambil pesan error
            $error = $user->getLastError();
        }
    }
 ?>


<!-- <!DOCTYPE html>  
<html>  
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <div class="login-page">
          <div class="form">
              <form class="register-form" method="post">
              <?php if (isset($error)): ?>
                  <div class="error">
                      <?php echo $error ?>
                  </div>
              <?php endif; ?>
              <?php if (isset($success)): ?>
                  <div class="success">
                      Berhasil mendaftar. Silakan <a href="login.php">masuk</a>
                  </div>
              <?php endif; ?>

               <input type="text" name="nama_depan" placeholder="Nama Depan" required/>
               <input type="text" name="nama_belakang" placeholder="Nama Belakang" required/>
               <input type="text" name="username" placeholder="Username" required/>
               <input type="password" name="password" placeholder="Password" required/>
               <button type="submit" name="kirim">create</button>
               <p class="message">Already registered? <a href="login.php">Sign In</a></p>
             </form>
          </div>
        </div>
    </body>
</html> -->

<?php
    include "header.php";
?>

<div class="registration-form">
   <div class="container">
     <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li class="active">Registration</li>
     </ol>
     <h2>Registration</h2>
     <div class="col-md-6 reg-form">
       <div class="reg">
         <p>Welcome, please enter the folling to continue.</p>
         <p>If you have previously registered with us, <a href="login.php">click here</a></p>
         <form method="post">
          <?php if (isset($error)): ?>
              <div class="error">
                  <?php echo $error ?>
              </div>
          <?php endif; ?>
          <?php if (isset($success)): ?>
              <div class="success">
                  Berhasil mendaftar. Silakan <a href="login.php">masuk</a>
              </div>
          <?php endif; ?>
           <ul>
             <li class="text-info">First Name: </li>
             <li><input type="text" name="nama_depan" placeholder="Nama Depan" required></li>
           </ul>
           <ul>
             <li class="text-info">Last Name: </li>
             <li><input type="text" name="nama_belakang" placeholder="Nama Belakang" required></li>
           </ul>         
          <ul>
             <li class="text-info">Username: </li>
             <li><input type="text" name="username" placeholder="Username" required></li>
           </ul>
           <ul>
             <li class="text-info">Password: </li>
             <li><input type="password" name="password" placeholder="Password" required></li>
           </ul>          
           <input type="submit" name="kirim" value="Register Now">
           <p class="click">By clicking this button, you agree to my modern style <a href="#">Pollicy Terms and Conditions</a> to Use</p> 
         </form>
       </div>
     </div>

     <div class="clearfix"></div>    
   </div>
</div>

<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
<?php
    include "footer.php";
?>