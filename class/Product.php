<?php

class Product {

	private $db; //Menyimpan Koneksi database
    private $error; //Menyimpan Error Message


    // Contructor untuk class Pengurus, membutuhkan satu parameter yaitu koneksi ke database
    function __construct($db_conn)
    {
        $this->db = $db_conn;

    }

    // public function getItem() {

    // 	try {
    //         // Ambil data Produk dari database
    //         $query = $this->db->prepare("SELECT * FROM produk");
    //         $query->execute();
    //         return $query->fetchAll();
    //     } catch (PDOException $e) {
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }

    public function getKasir() {

        try {
            // Ambil data kategori dari database
            $query = $this->db->prepare("SELECT * FROM pengurus WHERE role='kasir'");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getKategori() {

    	try {
            // Ambil data Produk dari database
            $query = $this->db->prepare("SELECT * FROM kategori");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM produk WHERE id_produk=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function getJumlahProduk() {
		$stmt = $this->db->prepare("SELECT COUNT(id_produk) as total FROM produk");
		$stmt->execute();
		$jlhproduk=$stmt->fetch(PDO::FETCH_ASSOC);
		return $jlhproduk;
	}

	public function getJumlahOrder() {
		$stmt = $this->db->prepare("SELECT COUNT(id_order) as order_pending FROM tbl_order WHERE status_order='Pending'");
		$stmt->execute();
		$orderPending=$stmt->fetch(PDO::FETCH_ASSOC);
		return $orderPending;
	}

	public function updateStok($table, $id, $stok_tambah, $ukuran) {
		
		//extract(self::getID($id));

		//$stk = $stok + $stok_tambah;
		if($ukuran == 'S') {
			$size = 'ukuran_s';
		}
		else if($ukuran == 'M') {
			$size = 'ukuran_m';
		}
		else if($ukuran == 'L') {
			$size = 'ukuran_l';
		}
		else if($ukuran == 'XL') {
			$size = 'ukuran_xl';
		}

		$sql = "UPDATE {$table} SET {$size}={$size}+{$stok_tambah}, tgl_update=NOW() WHERE id_produk = {$id}" ;

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	public function updateDiskon($table, $id, $diskon) {
		
		//extract(self::getID($id));

		if($diskon == 0){
			$diskons = 'NULL';
		} else {
			$diskons = $diskon;
		}

		$sql = "UPDATE {$table} SET diskon={$diskons} WHERE id_produk = {$id}" ;

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	//admin
	public function addReturn($fields = array()) {
		
		$keys = array_keys($fields);

		$values = "'" . implode( "','", $fields ) . "'";

		$sql = "INSERT INTO returns (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		//print_r($sql);

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	//admin
	public function viewReturn($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <tr>
	                <td><?php print($row['id_return']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['nama']); ?></td>
	                <td><?php print($row['tgl_return']); ?></td>
	                <td><?php print($row['note']); ?></td>
	                <td>
	                <a href="#" id="<?php print($row['id_return']); ?>" class="hapus"><i class="ti-trash"></i></a>
	                </td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	//admin
	public function deleteReturn($id) {
		$stmt = $this->db->prepare("DELETE FROM returns WHERE id_return=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

    public function insert($fields = array()) {
		$keys = array_keys($fields);

		$values = "'" . implode( "','", $fields ) . "'";

		$sql = "INSERT INTO produk (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	public function insertKategori($kategories = array()) {

		$keys = array_keys($kategories);

		$values = "'" . implode( "','", $kategories ) . "'";

		$sql = "INSERT INTO kategori (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;

	}

	public function addtoCart($datas = array()) {

		$keys = array_keys($datas);

		$values = "'" . implode( "','", $datas ) . "'";

		$id_user = $datas['id_user'];
		$id_produk = $datas['id_produk'];

		// Cek Jika Produk tersebut sudah ada di table cart dengan id sesi yg sama
		$stmt = $this->db->prepare("SELECT * FROM cart WHERE id_user=:id_user AND id_produk=:id_produk");
		$stmt->execute(array(":id_user"=>$id_user, ":id_produk"=>$id_produk));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
		// jika ada
		if($stmt->rowCount()>0) {

			$harga = $editRow['harga'] + $datas['harga'];
			$jlh_produk = $editRow['jumlah_produk'] + $datas['jumlah_produk'];

			$sql = "UPDATE cart SET harga={$harga}, jumlah_produk={$jlh_produk}  WHERE id_produk = {$id_produk} AND id_user = {$id_user}";


			if ($this->db->prepare($sql)) {
		        if ($this->db->exec($sql)) {
		            return true;
		        }
		    }
			
			return false;


		} else {

			$sql = "INSERT INTO cart (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

			if ($this->db->prepare($sql)) {
		        if ($this->db->exec($sql)) {
		            return true;
		        }
		    }

		    return false;
		}

		return true;

	}

	public function addKasirCart($datas = array()) {

		$keys = array_keys($datas);

		$values = "'" . implode( "','", $datas ) . "'";

		$id_pengurus = $datas['id_pengurus'];
		$id_produk = $datas['id_produk'];
		$ukuran = $datas['ukuran'];

		// Cek Jika Produk tersebut sudah ada di table cart dengan id sesi yg sama
		$stmt = $this->db->prepare("SELECT * FROM cart_kasir WHERE id_pengurus=:id_pengurus AND id_produk=:id_produk AND ukuran=:ukuran");
		$stmt->execute(array(":id_pengurus"=>$id_pengurus, ":id_produk"=>$id_produk, ":ukuran"=>$ukuran));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
		// jika ada
		if($stmt->rowCount()>0) {

			$harga = $editRow['total_harga'] + $datas['total_harga'];
			$jlh_produk = $editRow['jumlah_produk'] + $datas['jumlah_produk'];

			$sql = "UPDATE cart_kasir SET total_harga={$harga}, jumlah_produk={$jlh_produk} WHERE id_produk = {$id_produk} AND id_pengurus = {$id_pengurus}";


			if ($this->db->prepare($sql)) {
		        if ($this->db->exec($sql)) {
		            return true;
		        }
		    }
			
			return false;


		} else {

			$sql = "INSERT INTO cart_kasir (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

			if ($this->db->prepare($sql)) {
		        if ($this->db->exec($sql)) {
		            return true;
		        }
		    }

		    return false;
		}

		return true;
	}

	public function delKasirCart($id)
	{
		$stmt = $this->db->prepare("DELETE FROM cart_kasir WHERE id_produk=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public function deleteKategori($id) {

		$stmt = $this->db->prepare("DELETE FROM kategori WHERE id_kategori=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public function viewKategori($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <tr>
	                <td><?php print($row['nama_kategori']); ?></td>
	                <td><?php print($row['gender']); ?></td>
	                <td><?php print($row['desk_kategori']); ?></td>
	                <td>
	                <a href="#" id="<?php print($row['id_kategori']); ?>" class="hapus"><i class="ti-trash"></i></a>
	                </td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}


	public function update($id, $fields = array()) {

		//$set = "ekor = 'bulu',";
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = '{$value}'";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		//var_dump($set);

		$sql = "UPDATE produk SET {$set} WHERE id_produk = {$id}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;

	}

    public function dataview($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <tr>
	                <td><?php print($row['id_produk']); ?></td>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['harga']); ?></td>
	                <td><?php print($row['tgl_update']); ?></td>
	                <td><?php print($row['diskon']); ?></td>
	                <td><?php print($row['ukuran_s']); ?></td>
	                <td><?php print($row['ukuran_m']); ?></td>
	                <td><?php print($row['ukuran_l']); ?></td>
	                <td><?php print($row['ukuran_xl']); ?></td>
	                <td>
	                <a href="tambah_stok.php?edit_id=<?php print($row['id_produk']); ?>"><i class="ti-plus"></i></a>
	                <a href="edit_produk.php?edit_id=<?php print($row['id_produk']); ?>"><i class="ti-pencil-alt"></i></a>
	                <a href="#" id="<?php print($row['id_produk']); ?>" class="hapus"><i class="ti-trash"></i></a>
	                </td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
		
	}

	public function myCart($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$id_produk_oncart = $row['id_produk'];
				$a = "SELECT produk.id_produk, produk.nama_brg, produk.kode_SKU, produk.harga, produk.gambar FROM produk LEFT JOIN cart ON (produk.id_produk=$id_produk_oncart)";
				$stmt2 = $this->db->prepare($a);
				$stmt2->execute();
				$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

				// format mata uang
			 	$jumlah_desimal = "0";
				$pemisah_desimal = ",";
				$pemisah_ribuan = ".";
				?>

                <div class="cart-header">
                	<a href="#" id="<?php print($row['id_cart']); ?>" class="hapus">
					 <div class="close1"> 
					 	
					 </div>
					</a>
					 <div class="cart-sec">
							<div class="cart-item cyc">
								 <img src="assets/img_produk/<?php print($row2['gambar']); ?>"/>
							</div>
						   <div class="cart-item-info">
								 <h3><?php print($row2['nama_brg']); ?><span><?php print($row2['kode_SKU']); ?></span></h3>
								 <h4><span>Rp. </span><?php print(number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></h4>
								 <p class="qty">Qty ::</p>
								 <input min="1" type="number" id="quantity" name="quantity" value="<?php print($row['jumlah_produk']); ?>" class="form-control input-small" disabled>
								 x <?php print("Rp ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?>
								 <p class="qty">&nbsp;&nbsp;&nbsp;&nbsp;<b>Ukuran : <?php print($row['ukuran']); ?></b></p>
						   </div>
						   <div class="clearfix"></div>
							<div class="delivery">
								 <span>Delivered in 2-3 bussiness days</span>
								 <div class="clearfix"></div>
					        </div>						
					  </div>
				 </div>	

                <?php

			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}

	}

	public function deleteCart($id) {
		$stmt = $this->db->prepare("DELETE FROM cart WHERE id_cart=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public function indexProduk($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				
				?>

                <a href="singleView.php?item_id=<?php print($row['id_produk']); ?>">
                <div class="product-grid" style="width:150px;height:260px;">                     
                    <div class="more-product-info">
                    	<?php
                    		if($row['diskon'] != NULL) {
								$xharga = ($row['harga']*$row['diskon'])/100;
								?>
									<span><?php print($row['diskon'])?> %</span>
								<?php
							} else {
								$xharga = $row['harga'];
							}
                    	?>
                    </div>                       
                    <div class="product-img b-link-stripe b-animate-go  thickbox">                         
                        <img src="assets/img_produk/<?php print($row['gambar']); ?>" class="img-responsive" alt="" />
                        <div class="b-wrapper">
                        <h4 class="b-animate b-from-left  b-delay03">                           
                        <button class="btns">ORDER NOW</button>
                        </h4>
                        </div>
                    </div>
                </a>                      
		            <div class="product-info simpleCart_shelfItem">
		                <div class="product-info-cust">
		                    <h5><?php print($row['nama_brg']); ?></h5>
		                    <span><?php print("Rp. ".number_format($xharga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></span>
		                </div>                                                  
		                <div class="clearfix"> </div>
		            </div>
                </div>

                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	public function populerProduk($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <a href="singleView.php?item_id=<?php print($row['id_produk']); ?>">
                <div class="product-grid" style="width:150px;height:260px;">                     
                    <div class="more-product-info"></div>                       
                    <div class="product-img b-link-stripe b-animate-go  thickbox">                         
                        <img src="assets/img_produk/<?php print($row['gambar']); ?>" class="img-responsive" alt="" />
                        <div class="b-wrapper">
                        <h4 class="b-animate b-from-left  b-delay03">                           
                        <button class="btns">ORDER NOW</button>
                        </h4>
                        </div>
                    </div>
                </a>                      
		            <div class="product-info simpleCart_shelfItem">
		                <div class="product-info-cust">
		                    <h5><?php print($row['nama_brg']); ?></h5>
		                    <span><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></span>
		                </div>                                                  
		                <div class="clearfix"> </div>
		            </div>
                </div>

                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	public function diskonProduk($query) {

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <a href="singleView.php?item_id=<?php print($row['id_produk']); ?>">
                <div class="product-grid" style="width:150px;height:260px;">                     
                    <div class="more-product-info"><span><?php print($row['diskon'])?> %</span></div>                       
                    <div class="product-img b-link-stripe b-animate-go  thickbox">                         
                        <img src="assets/img_produk/<?php print($row['gambar']); ?>" class="img-responsive" alt="" />
                        <div class="b-wrapper">
                        <h4 class="b-animate b-from-left  b-delay03">                           
                        <button class="btns">ORDER NOW</button>
                        </h4>
                        </div>
                    </div>
                </a>                      
		            <div class="product-info simpleCart_shelfItem">
		                <div class="product-info-cust">
		                    <h5><?php print($row['nama_brg']); ?></h5>
		                    <span><?php print("Rp. ".number_format(($row['harga']*$row['diskon'])/100,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></span>
		                </div>                                                  
		                <div class="clearfix"> </div>
		            </div>
                </div>

                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}

	public function paginglink($query,$records_per_page)
	{
		
		$self = $_SERVER['PHP_SELF'];
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		$total_no_of_records = $stmt->rowCount();
		
		if($total_no_of_records > 0)
		{
			?><ul class="pagination"><?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;
			if(isset($_GET["page_no"]))
			{
				$current_page=$_GET["page_no"];
			}
			if($current_page!=1)
			{
				$previous =$current_page-1;
				echo "<li><a href='".$self."?page_no=1'>First</a></li>";
				echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
			}
			for($i=1;$i<=$total_no_of_pages;$i++)
			{
				if($i==$current_page)
				{
					echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
				}
				else
				{
					echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
				echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
			}
			?></ul><?php
		}
	}

	public function delete($id)
	{
		$stmt = $this->db->prepare("DELETE FROM produk WHERE id_produk=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public function ubahStatus($id)
	{
		$sql = "UPDATE tbl_order SET status_order='Terkirim', tgl_terkirim=NOW() WHERE id_order={$id}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	//owner
	public function laporanPenjualanTanggal($query) {

		$total_harga;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total_harga += $row['harga'];
				?>

                <tr>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['ukuran_s']); ?></td>
	                <td><?php print($row['total']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
			}
			?>
				<tr>
					<td colspan='4'>Total Penjualan</td>
					<td><font color="red"><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></font></td>
				</tr>
			<?php
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	//owner
	public function laporanPenjualan($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$total_harga;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total_harga += $row['harga'];
				?>

                <tr>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['ukuran_s']); ?></td>
	                <td><?php print($row['total']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
			}
			?>
				<tr>
					<td colspan='4'>Total Penjualan</td>
					<td><font color="red"><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></font></td>
				</tr>
			<?php
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	//owner
	public function laporanKasir($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$total_harga;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total_harga += $row['harga'];
				?>

                <tr>
	                <td><a href="owner_lap_per_kasir.php?id=<?php print($row['id']); ?>"><?php print($row['nama']); ?></a></td>
	                <td><?php print($row['total']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
			}
			?>
				<tr>
					<td colspan='2'>Total Penjualan</td>
					<td><font color="red"><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></font></td>
				</tr>
			<?php
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	public function laporanPerKasir($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$total_harga;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total_harga += $row['harga'];
				?>

                <tr>
                	<td><?php print($row['id_ok']); ?></td>
                	<td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['total']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
			}
			?>
				<tr>
					<td colspan='3'>Total Penjualan</td>
					<td><font color="red"><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></font></td>
				</tr>
			<?php
		}
		else
		{
			?>
            <tr>
            <td>Belum Ada....</td>
            </tr>
            <?php
		}
	}

	//owner
	public function laporanOffline($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$total_harga;
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$total_harga += $row['harga'];
				?>

                <tr>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['total']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
			}
			?>
				<tr>
					<td colspan='3'>Total Penjualan</td>
					<td><font color="red"><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></font></td>
				</tr>
			<?php
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	//owner
	public function laporanRetur($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <tr>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
	                <td><?php print($row['tgl_return']); ?></td>
	                <td><?php print($row['nama']); ?></td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

	//owner
	public function laporanStok($query) {

		// format mata uang
	 	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>

                <tr>
	                <td><?php print($row['kode_SKU']); ?></td>
	                <td><?php print($row['nama_brg']); ?></td>
	                <td><?php print($row['ukuran_s']); ?></td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
	}

}

?>