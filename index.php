<?php  
    // Lampirkan db dan User
    require_once "db.php";
    require_once "class/User.php";
    require_once "class/Product.php";

    // Buat object user
    $user = new User($db);

    // Ambil data user saat ini
    $currentUser = $user->getUser();

    $produk = new Product($db);

 ?>

<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<?php
    include "header.php";
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<br><br>
<!-- content -->
<div class="features" id="features">
     <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form>
                    <div class="form-group">
                        <div class="input-group border-input">
                        <input id="txtSearch" class="form-control border-input" type="text" placeholder="Search Product..." />
                        <div class="input-group-addon"><i class="ti-search">Search</i>
                        </div>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">                       
             <table class="table table-striped">
                <thead></thead>
                <tbody>
                    <?php

                        if(isset($_GET['kategori']) && !empty($_GET['kategori'])) {

                            $kategori = $_GET['kategori'];

                            $query = "SELECT * FROM produk LEFT JOIN kategori ON (produk.id_kategori=kategori.id_kategori) WHERE kategori.nama_kategori='$kategori'";

                            $records_per_page=18;
                            $newquery = $produk->paging($query,$records_per_page);
                            $produk->indexProduk($newquery);

                        } else {
                            $query = "SELECT * FROM produk WHERE diskon IS NULL ORDER BY tgl_update DESC";       
                            $records_per_page=18;
                            $newquery = $produk->paging($query,$records_per_page);
                            $produk->indexProduk($newquery);
                        }
                        
                     ?>
                     <tr>
                        <td colspan="7" align="center">
                            <div class="pagination-wrap">
                            <?php $produk->paginglink($query,$records_per_page); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
         </div>                 
    </div>             
</div>

<!-- content 2-->
<div class="features" id="features">
     <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align:center;padding-top:30px;padding-bottom:30px">Produk Populer</h3>  
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">                       
             <table class="table table-striped">
                <thead></thead>
                <tbody>
                    <?php

                        $query = "SELECT * FROM order_detail INNER JOIN produk 
                        ON (order_detail.id_produk=produk.id_produk) GROUP BY order_detail.id_produk
                        ORDER BY COUNT(order_detail.id_produk) DESC";       
                        $records_per_page=6;
                        $newquery = $produk->paging($query,$records_per_page);
                        $produk->populerProduk($newquery);
                        
                     ?>
                     
                </tbody>
            </table>
            </div>
         </div>                 
    </div>             
</div>

<!-- content 3-->
<div class="features" id="features">
     <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align:center;padding-top:30px;padding-bottom:30px">Produk Diskon</h3>  
            </div>
        </div>
         <div class="row">
            <div class="col-md-12">                       
             <table class="table table-striped">
                <thead></thead>
                <tbody>
                    <?php

                        $query = "SELECT * FROM produk WHERE diskon IS NOT NULL";
                        $newquery = $produk->paging($query,$records_per_page);
                        $produk->diskonProduk($newquery);
                        
                     ?>
                     
                </tbody>
            </table>
            </div>
         </div>                 
    </div>             
</div>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    
    $('#txtSearch').autocomplete({
        source: "admin/produk_autocom.php",
        minLength: 2,
        select: function(event, ui) {
            var url = 'singleView.php?item_id='+ui.item.id;
            if (url != '#') {
                location.href = url
            }
        },
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000)
        }
    })
    
});
</script>
<script>

$("html, body").animate({ scrollTop: 700 }, 10);

</script>
<?php

    include "footer.php";

?>