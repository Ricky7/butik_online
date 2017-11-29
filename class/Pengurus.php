<?php

class Pengurus {

	private $db; //Menyimpan Koneksi database
    private $error; //Menyimpan Error Message

    // Contructor untuk class Pengurus, membutuhkan satu parameter yaitu koneksi ke databse
    function __construct($db_conn)
    {
        $this->db = $db_conn;

        // Mulai session
        session_start();
    }

    //Login admin
    public function login($username, $password)
    {
        try
        {
            // Ambil data dari database
            $query = $this->db->prepare("SELECT * FROM pengurus WHERE username = :username");
            $query->bindParam(":username", $username);
            $query->execute();
            $data = $query->fetch();

            // Jika jumlah baris > 0
            if($query->rowCount() > 0){
                // jika password yang dimasukkan sesuai dengan yg ada di database
                if(password_verify($password, $data['password'])){
                    $_SESSION['user_session'] = $data['id'];
                    return true;
                }else{
                    $this->error = "Username atau Password Salah";
                    return false;
                }
            }else{
                $this->error = "Akun tidak ada";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function viewPengurus($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <tr>
                    <td><?php print($row['nama']); ?></td>
                    <td><?php print($row['username']); ?></td>
                    <td><?php print($row['role']); ?></td>
                    <td>
                    <a href="#" id="<?php print($row['id']); ?>" class="hapus"><i class="ti-trash"></i></a>
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

    // Registrasi Pngurus baru
    public function tambahPengurus($fields = array())
    {

        $keys = array_keys($fields);

        $values = "'" . implode( "','", $fields ) . "'";

        $sql = "INSERT INTO pengurus (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {
                return true;
            }
        }

        return false;

    }

    public function deletePengurus($id) {

        $stmt = $this->db->prepare("DELETE FROM pengurus WHERE id=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
        return true;
    }

    public function ubahPassword($id, $old, $new) {

        // cek old password

        $cek = "SELECT password FROM pengurus WHERE id=:id";
        $stmt = $this->db->prepare($cek);
        $stmt->execute(array(":id"=>$id));
        $pass=$stmt->fetch(PDO::FETCH_ASSOC);

        $newPass = password_hash($new, PASSWORD_DEFAULT);

        if($stmt->rowCount()>0) {

            if(password_verify($old, $pass['password'])) {

                // update new password
                $new = "UPDATE pengurus SET password='{$newPass}' WHERE id={$id}";

                $stmtC = $this->db->prepare($new);
                $stmtC->execute();

                ?>
                    <div class="alert alert-success">
                        <strong>Success!</strong>
                    </div>
                <?php
                
                return true;
            } else {

                ?>
                    <div class="alert alert-danger">
                        <strong>Gagal!</strong> Coba Lagi..
                    </div>
                <?php
            }
        }
        
    }

    // Cek apakah Pengurus sudah login
    public function isLoggedIn(){
        // Apakah user_session sudah ada di session
        if(isset($_SESSION['user_session']))
        {
            return true;
        }
    }

    public function cekLogin() {

	    if(!self::isLoggedIn()){
	        header("location: admin_login.php");
	    }
    }

    public function getPengurusID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM pengurus WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    // Ambil data admin yang sudah login
    public function getPengurus(){
        // Cek apakah sudah login
        if(!$this->isLoggedIn()){
            return false;
        }

        try {
            // Ambil data Pengurus dari database
            $query = $this->db->prepare("SELECT * FROM pengurus WHERE id = :id");
            $query->bindParam(":id", $_SESSION['user_session']);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // Logout Pengurus
    public function logout(){
        // Hapus session
        session_destroy();
        // Hapus user_session
        unset($_SESSION['user_session']);
        return true;
    }

    // Ambil error terakhir yg disimpan di variable error
    public function getLastError(){
        return $this->error;
    }
}

?>