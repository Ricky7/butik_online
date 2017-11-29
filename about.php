<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";

    //Buat object user
    $user = new User($db);

    // Ambil data user saat ini
    $currentUser = $user->getUser();

?>

<?php
    include "header.php";
?>

<div class="about">
   <div class="container">
      <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li class="active">About</li>
     </ol>
     <h2>ABOUT US</h2>
     <div class="about-sec">
       <div class="about-pic"><img src="assets_index/images/a1.jpg" class="img-responsive" alt=""/></div>
       <div class="about-info">
         <p>Sed condimytui etorem ipsum dolor sitrol ametyre consectetur adipet tymolotymon wertunio wercinaloisyuing elit. 
         Ted nectro placerat turpis nec rutrumit est. Maecholi enas toro aliquet tristique tellus.Sed condimytui etorem ipsum dolor sitrol ametyre consectetur adipet tymolotymon wertunio wercinaloisyuing elit. 
         Ted nectroTed nectro placerat turpis nec rutrumit est. Maecholi enas toro aliquet tristique tellus. Maecholi enas toro aliquet tristique tellus.Sed condimytui etorem ipsum dolor sitrol ametyre consectetur adipet tymolotymon wertunio wercinaloisyuing elit. 
         Morbi bibendum, lectus sed pretium semper, mauris ipsum laoreet justo, vel efficitur nisi elit sed felis. Aenean vel ipsum odio.</p>
       
       </div>
       <div class="clearfix"></div>
     </div>
     <h3>OUR SPECIALS</h3>
     <div class="about-grids">
       <div class="col-md-3 about-grid">
         <img src="assets_index/images/ab1.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Kurtis & Kurtas</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid">
         <img src="assets_index/images/ab2.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Salwars</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque 
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid pot-2">
         <img src="assets_index/images/ab3.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Desi Look</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid pot-1">
         <img src="assets_index/images/ab4.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Designersaree</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque 
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="clearfix"></div>
       <div class="bottom-grids">
       <div class="col-md-3 about-grid flwr">
         <img src="assets_index/images/ab5.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>NEWLOOK</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid flwr">
         <img src="assets_index/images/ab6.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Meriea</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque 
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid flwr pot-2">
         <img src="assets_index/images/ab7.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Woolen Shurg</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="col-md-3 about-grid flwr pot-1">
         <img src="assets_index/images/ab8.jpg" class="img-responsive" alt=""/>
         <a href="blog-single.html"><h4>Black Shurg</h4></a>
         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, recusandae, minima deserunt pariatur illo eos doloremque 
         Asperiores modi temporibus consequuntur tempore quibusdam!</p>
       </div>
       <div class="clearfix"></div>
       </div>
     </div>
   </div>
</div>

<script>

  $("html, body").animate({ scrollTop: 700 }, 10);

</script>
<?php
    include "footer.php";
?>