<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";
    require_once "class/Product.php";

    // Buat object user
    $user = new User($db);

    if(!$user->isLoggedIn()){
        header("location: login.php"); //redirect ke login
    }

    // Ambil data user saat ini
    $currentUser = $user->getUser();

    $produk = new Product($db);

 ?>

<?php
    include "header.php";
?>

<!--Single Page starts Here-->
<div class="product-main">
	 <div class="container">
		 <ol class="breadcrumb">
		  <li><a href="index.php">Home</a></li>
		  <li class="active">Single</li>
		 </ol>
		 <div class="ctnt-bar cntnt">
			 <div class="content-bar">
				 <div class="single-page">					 
					 <!--Include the Etalage files-->
						<link rel="stylesheet" href="assets_index/css/etalage.css">
						<script src="assets_index/js/jquery.etalage.min.js"></script>
					 <!-- Include the Etalage files -->
					 <script>
							jQuery(document).ready(function($){
					
								$('#etalage').etalage({
									thumb_image_width: 300,
									thumb_image_height: 400,
									source_image_width: 700,
									source_image_height: 800,
									show_hint: true,
									click_callback: function(image_anchor, instance_id){
										alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
									}
								});
								// This is for the dropdown list example:
								$('.dropdownlist').change(function(){
									etalage_show( $(this).find('option:selected').attr('class') );
								});
					
							});
						</script>
					 <!--//details-product-slider-->
					 <?php

					 	// format mata uang
					 	$jumlah_desimal = "0";
						$pemisah_desimal = ",";
						$pemisah_ribuan = ".";

					 	if(isset($_GET['item_id'])) {

					 		$id = $_GET['item_id'];


					 		extract($produk->getID($id));

					 		if(($diskon) != NULL) {
					 			$xharga = ($harga*$diskon)/100;
					 		} else {
					 			$xharga = $harga;
					 		}

					 		$query2 = "SELECT kategori.nama_kategori FROM produk INNER JOIN kategori ON (produk.id_kategori=kategori.id_kategori)
					 		WHERE produk.id_produk={$id}";

					 		$stmt2 = $db->prepare($query2);
							$stmt2->execute();
							$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
					 	}

					 	if(isset($_POST['add_cart'])) {

					 		if($_POST['ukuran'] == 'S'){
					 			if($_POST['quantity'] > $ukuran_s){
					 				//$error = true;
						 			header("Location: singleView.php?item_id=$id&error");
					 			}
					 			
					 		} else if($_POST['ukuran'] == 'M'){
					 			if($_POST['quantity'] > $ukuran_m){
					 				//$error = true;
						 			header("Location: singleView.php?item_id=$id&error");
						 			exit;
					 			}
					 			
					 		} else if($_POST['ukuran'] == 'L'){
					 			if($_POST['quantity'] > $ukuran_l){
					 				//$rror = true;
						 			header("Location: singleView.php?item_id=$id&error");
						 			exit;
					 			}
					 			
					 		} else if($_POST['ukuran'] == 'XL'){
					 			if($_POST['quantity'] > $ukuran_xl){
					 				//error = true;
						 			header("Location: singleView.php?item_id=$id&error");
						 			exit;
					 			}
					 			
					 		}

					 		$total_harga = $_POST['harga'] * $_POST['quantity'];
					 		try {
						    	$produk->addtoCart(array(
						    		'id_produk' => $_POST['id_produk'],
						    		'id_user' => $_POST['id_user'],
						    		'harga' => $total_harga,
						    		'jumlah_produk' => $_POST['quantity'],
						    		'ukuran' => $_POST['ukuran']
						    	));
						    	//header("refresh:0");
						    	header("location: cart.php");
						    } catch (Exception $e) {
								die($e->getMessage());
							}
					 	}

					 ?>
					 <div class="details-left-slider">
						  <ul id="etalage">
							 <li>
								<a href="optionallink.html">
								<img class="etalage_thumb_image" src="assets/img_produk/<?php echo $gambar; ?>" />
								<img class="etalage_source_image" src="assets/img_produk/<?php echo $gambar; ?>" />
								</a>
							 </li>
							 <div class="clearfix"></div>
						 </ul>
					 </div>
					 <div class="details-left-info">
					 		<?php if (isset($_GET['error'])): ?>
				                <div class="error">
				                    <?php echo '<font color="red"><h2>Ukuran Tidak Tersedia/Habis!</h2></font><br>' ?>
				                </div>
				            <?php endif; ?>
							<h3><?php echo $nama_brg; ?></h3>
							
							<p><?php echo "Rp ".number_format($xharga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></p>
							<form method="post">
								<input type="hidden" value="<?php echo $id_produk ?>" name="id_produk">
								<input type="hidden" value="<?php echo $currentUser['id_user'] ?>" name="id_user">
								<input type="hidden" value="<?php echo $xharga; ?>" name="harga">
								<p class="qty">Qty ::</p><input min="1" type="number" id="quantity" name="quantity" value="1" class="form-control input-small">
								<select name="ukuran" class="form-control" required>
									<option></option>
									<option value="S">S</option>
									<option value="M">M</option>
									<option value="L">L</option>
									<option value="XL">XL</option>
								</select>
								<?php  
									if($ukuran_s > 0) {
										?>
											<div class="btn_form">
												<input type="submit" value="Add to Cart" class="btn btn_form" name="add_cart">
											</div>
										<?php
									} else {
										?>
											<p>Habis!!!</p>
										<?php
									}
								?>
								
							</form>
							<div class="flower-type">
							<p>Model  ::<a href="#"><?php echo $row2['nama_kategori']; ?></a></p>
							<p>Brand  ::<a href="#"><?php echo $merk; ?></a></p>
							<p>Berat  ::<a href="#"><?php echo $berat; ?>gr</a></p>
							<p>Stok S  ::<a href="#"><?php echo $ukuran_s; ?></a></p>
							<p>Stok M  ::<a href="#"><?php echo $ukuran_m; ?></a></p>
							<p>Stok L  ::<a href="#"><?php echo $ukuran_l; ?></a></p>
							<p>Stok XL  ::<a href="#"><?php echo $ukuran_xl; ?></a></p>
							</div>
							<h5>Description  ::</h5>
							<p class="desc"><?php echo $deskripsi; ?></p>
					 </div>
					 <div class="clearfix"></div>				 	
				 </div>
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