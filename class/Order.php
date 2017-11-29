<?php

class Order {

	private $db; //Menyimpan Koneksi database

    // Contructor untuk class Pengurus, membutuhkan satu parameter yaitu koneksi ke database
    function __construct($db_conn)
    {
        $this->db = $db_conn;

    }

    public function insertOrder($fields = array(), $id_user) {

    	$keys = array_keys($fields);

		$values = "'" . implode( "','", $fields ) . "'";

		//var_dump($fields);

		$sql = "INSERT INTO tbl_order (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if ($this->db->prepare($sql)) {

	        if ($this->db->exec($sql)) {

	        	$lastId = $this->db->lastInsertId();

	        	$move_data = "INSERT INTO order_detail (id_order, id_produk, jumlah_produk, harga, ukuran)
SELECT {$lastId}, id_produk, jumlah_produk, harga, ukuran FROM cart WHERE id_user={$id_user}";

				if($this->db->exec($move_data)) {
					$delCart = $this->db->prepare("DELETE FROM cart WHERE id_user=:id");
					$delCart->bindparam(":id",$id_user);
					$delCart->execute();
					return true;
				}
				
	            return true;
	        }
	    }

		return false;
    }

    public function kasirBayar($id_pengurus)
	{
		$sql = "INSERT INTO order_kasir(id_pengurus, tgl_order) VALUES({$id_pengurus}, NOW())";

		if($this->db->prepare($sql)) {

			if($this->db->exec($sql)) {

				$lastId = $this->db->lastInsertId();

				$move_data = "INSERT INTO order_detail_kasir(id_ok, id_produk, jumlah_produk, total_harga, ukuran) SELECT {$lastId}, id_produk, jumlah_produk, total_harga, ukuran FROM cart_kasir WHERE id_pengurus={$id_pengurus}";
				
				if($this->db->exec($move_data)) {

					$delKCart = "DELETE FROM cart_kasir WHERE id_pengurus={$id_pengurus}";
					
					if($this->db->exec($delKCart)) {

						// ambil nilai id_produk & jumlah_produk pada tabel order_detail
			        	$ambil = "SELECT id_produk, jumlah_produk, ukuran FROM order_detail_kasir WHERE id_ok={$lastId}";

			        	$stmt = $this->db->prepare($ambil);
			        	$stmt->execute();

						if($stmt->rowCount()>0)
						{
							while($ambil_row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
								$ambil_stok = $ambil_row['jumlah_produk'];
								$ukuran = $ambil_row['ukuran'];
								$ambil_id_produk = $ambil_row['id_produk'];

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

								$updateStok = "UPDATE produk SET {$size}={$size}-{$ambil_stok} WHERE id_produk={$ambil_id_produk}";

								$this->db->prepare($updateStok);
								$this->db->exec($updateStok);
							}
						}
						else
						{
							echo "Error";
						}


			            return true;

					}

					return true;
				}
			}

			return true;
		}

		return false;
	}

    public function insertBayar($fields = array(), $id_user, $id_order) {

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
		$sql = "UPDATE tbl_order SET {$set} WHERE id_user={$id_user} AND id_order={$id_order}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
    }

    public function getOrder($id, $status)
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_order WHERE id_order=:id AND status_order=:status");
		$stmt->execute(array(":id"=>$id, ":status"=>$status));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	//admin function
	public function cekBayar($fields = array(), $id_order) {

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
		$sql = "UPDATE tbl_order SET {$set} WHERE id_order={$id_order}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	//admin function
	public function kirimBarang($fields = array(), $id_order, $note) {

		$keys = array_keys($fields);

		$values = "'" . implode( "','", $fields ) . "'";

		//var_dump($fields);

		$sql = "INSERT INTO kirim (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {

	        	$lastId = $this->db->lastInsertId();
	        	$notes = $note;

	        	$updatekirim = "UPDATE tbl_order SET id_kirim={$lastId}, status_order='Dikirim', note='$notes' WHERE id_order={$id_order}";

	        	//var_dump($updatekirim);
	        	if ($this->db->prepare($updatekirim)) {
			        if ($this->db->exec($updatekirim)) {

			        	// ambil nilai id_produk & jumlah_produk pada tabel order_detail
			        	$ambil = "SELECT id_produk, jumlah_produk, ukuran FROM order_detail WHERE id_order={$id_order}";

			        	$stmt = $this->db->prepare($ambil);
			        	$stmt->execute();

						if($stmt->rowCount()>0)
						{
							while($ambil_row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
								$ambil_stok = $ambil_row['jumlah_produk'];
								$ambil_id_produk = $ambil_row['id_produk'];
								$ukuran = $ambil_row['ukuran'];

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

								$updateStok = "UPDATE produk SET {$size}={$size}-{$ambil_stok} WHERE id_produk={$ambil_id_produk}";

								$this->db->prepare($updateStok);
								$this->db->exec($updateStok);
							}
						}
						else
						{
							echo "Error";
						}


			            return true;
			        }
			    }
	            return true;
	        }
	    }

		return false;
	}

	//admin
	public function setTerkirim($fields = array(), $id) {

		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = '{$value}'";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}


		$sql = "UPDATE tbl_order SET {$set} WHERE id_order={$id}";
		

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }
        return true;

	}
}

?>