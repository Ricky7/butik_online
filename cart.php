<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";
    require_once "class/Product.php";

    // Buat object user
    $user = new User($db);

    //Jika tidak login
    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }

    // Ambil data user saat ini
    $currentUser = $user->getUser();

    $produk = new Product($db);

 ?>

<?php
    include_once "header.php";
?>

<!--header//-->
<div class="cart">
	 <div class="container">
			 <ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li class="active">Cart</li>
		 </ol>
		 <div class="cart-top">
			<a href="index.php"><< home</a>
		 </div>	
			
		 <div class="col-md-9 cart-items">
			 <h2>My Shopping Bag</h2>
			 <?php

			 	$sql = "SELECT * FROM cart WHERE id_user={$currentUser['id_user']}";
			 	$produk->myCart($sql);

			 	$x = "SELECT SUM(harga) as total FROM cart WHERE id_user={$currentUser['id_user']}";
			 	$stmtx = $db->prepare($x);
				$stmtx->execute();
				$rowx=$stmtx->fetch(PDO::FETCH_ASSOC);


				// format mata uang
			 	$jumlah_desimal = "0";
				$pemisah_desimal = ",";
				$pemisah_ribuan = ".";

			 ?>
			 
		 </div>
		 
		 <div class="col-md-3 cart-total">
			 <a class="continue" href="index.php">Lanjut Belanja</a>
			 <div class="price-details">
				 <h3>Price Details</h3>
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">TOTAL</h4>
			 <span class="total final"><?php echo "Rp ".number_format($rowx['total'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></span>
			 <div class="clearfix"></div>
			 <?php
			 if(!$rowx['total'] == 0) {
			 	echo "<a class='order' href='order.php'>Place Order</a>";
				} 
			 ?>
			</div>
	 </div>
</div>
<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>

<script type="text/javascript">
$(function() {
$(".hapus").click(function() {
	var id = $(this).attr("id");
	var dataString = 'id='+ id ;
	var parent = $(this).parent();
	if (confirm('Are you sure you want to delete this?'+dataString)) {
		$.ajax({
			type: "POST",
			url: "hapus_cart.php",
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
    include_once "footer.php";
?>