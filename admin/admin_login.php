<?php  
    // Lampirkan db dan Pengurus
    require_once "../db.php";
    require_once "../class/Pengurus.php";

    //Buat object user
    $pengurus = new Pengurus($db);

    $roles = $pengurus->getPengurus();
    $role = $roles['role'];
    

    //Jika sudah login
    if($pengurus->isLoggedIn()){
        
        switch ($role) {
          case 'admin':
            header("location: admin_page.php");
            break;

          case 'operator':
            header("location: admin_page.php");
            break;

          case 'owner':
            header("location: ../owner/owner_dashboard.php");
            break;

          case 'kasir':
            header("location: ../kasir/kasir_dashboard.php");
            break;
          
          default:
            header("location: admin_login.php");
            break;
        }
    }

    //jika ada data yg dikirim
    if(isset($_POST['kirim'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Proses login user
        if($pengurus->login($username, $password)){
            
          switch ($role) {
            case 'admin':
              header("location: admin_page.php");
              break;
              
            case 'pengurus':
              header("location: operator_page.php");
              break;

            case 'owner':
              header("location: owner_page.php");
              break;
            
            default:
              header("location: admin_login.php");
              break;
          }
        }else{
            // Jika login gagal, ambil pesan error
            $error = $pengurus->getLastError();
        }
    }
 ?>


<!DOCTYPE html>  
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
</html>  