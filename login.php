<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";

    //Buat object user
    $user = new User($db);

    //Jika sudah login
    if($user->isLoggedIn()){
        header("location: index.php"); //redirect ke index
    }

    //jika ada data yg dikirim
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Proses login user
        if($user->login($username, $password)){
            header("location: index.php");
        }else{
            // Jika login gagal, ambil pesan error
            $error = $user->getLastError();
        }
    }
 ?>


<!-- <!DOCTYPE html>  
<html>  
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="style.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <div class="login-page">
          <div class="form">
            <form class="login-form" method="post">
              <?php if (isset($error)): ?>
                  <div class="error">
                      <?php echo $error ?>
                  </div>
              <?php endif; ?>
              <input type="text" name="username" placeholder="Username" required/>
              <input type="password" name="password" placeholder="Password" required/>
              <button type="submit" name="kirim">login</button>
              <p class="message">Not registered? <a href="register.php">Create an account</a></p>
            </form>
          </div>
        </div>
    </body>
</html> -->  

<?php
    include "header.php";
?>

<div class="login">
   <div class="container">
      <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li class="active">Login</li>
     </ol>
     <h2>Login</h2>
     <div class="col-md-6 log">      
         <p>Welcome, please enter the folling to continue.</p>
         <form method="post">
           <h5>User Name:</h5>  
           <input type="text" name="username" placeholder="Username" required>
           <h5>Password:</h5>
           <input type="password" name="password" placeholder="Password" required>         
           <input type="submit" value="Login" name="submit">
            <a href="#">Forgot Password ?</a>
         </form>         
     </div>
      <div class="col-md-6 login-right">
          <h3>NEW REGISTRATION</h3>
        <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
        <a class="acount-btn" href="register.php">Create an Account</a>
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