<?php
require('../class/Pdf.php');
include "../db.php";

// format mata uang
$jumlah_desimal = "0";
$pemisah_desimal = ",";
$pemisah_ribuan = ".";

// Instanciation of inherited class
$pdf = new Pdf();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$tgl_awal = $_POST['tgl_awal'];
$tgl_akhir = $_POST['tgl_akhir'];

// $query = "SELECT produk.kode_SKU, produk.nama_brg, produk.stok, SUM(order_detail.jumlah_produk) as total, 
//         SUM(order_detail.harga) as harga FROM order_detail INNER JOIN tbl_order INNER JOIN produk ON (order_detail.id_order = tbl_order.id_order) 
//         AND (order_detail.id_produk = produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' GROUP BY produk.id_produk";
$query = "SELECT produk.kode_SKU, produk.nama_brg, produk.harga, tbl_order.tgl_order FROM order_detail INNER JOIN tbl_order INNER JOIN produk ON (order_detail.id_order = tbl_order.id_order) 
        AND (order_detail.id_produk = produk.id_produk) WHERE date(tbl_order.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' AND tbl_order.status_order = 'Terkirim' ORDER BY tbl_order.tgl_order ASC";
$stmt = $db->prepare($query);
$stmt->execute();

//Inisiasi untuk membuat header kolom
$total_harga = 0;
// $column_kodeSKU = "";
// $column_namaProduk = "";
// $column_stok = "";
// $column_totalTerjual = "";
// $column_harga = "";

$column_tanggal = "";
$column_kodeSKU = "";
$column_namaProduk = "";
$column_harga = "";

//For each row, add the field to the corresponding column
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{

	$total_harga += $row["harga"];

    $kodeSKU = $row["kode_SKU"];
    $namaProduk = $row["nama_brg"];
    $tanggal = $row["tgl_order"];
    //$stok = $row["stok"];
    //$totalTerjual = $row["total"];
    $harga = $row["harga"];
 
    

    $column_kodeSKU = $column_kodeSKU.$kodeSKU."\n";
    $column_namaProduk = $column_namaProduk.$namaProduk."\n";
    $column_tanggal = $column_tanggal.$tanggal."\n";
    //$column_stok = $column_stok.$stok."\n";
    //$column_totalTerjual = $column_totalTerjual.$totalTerjual."\n";
    $column_harga = $column_harga.number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)."\n";
    

//Create a new PDF file
$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
$pdf->AddPage();

//Menambahkan Gambar
//$pdf->Image('../foto/logo.png',10,10,-175);

$pdf->SetFont('Arial','B',13);
$pdf->Cell(80);
$pdf->Cell(30,10,'LAPORAN PENJUALAN ONLINE',0,0,'C');
$pdf->Ln();
$pdf->Cell(80);
$pdf->Cell(30,10,'PT. ',0,0,'C');
$pdf->Ln();

}

//Fields Name position
$Y_Fields_Name_position = 30;
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(80,8,'TANGGAL : '.$tgl_awal.' - '.$tgl_akhir,1,0,'C',1);
$pdf->SetX(140);
$pdf->Cell(25,8,'TOTAL',1,0,'C',1);
$pdf->SetX(165);
$pdf->Cell(40,8,'Rp. '.number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan),1,0,'C',1);

//Fields Name position
$Y_Fields_Name_position = 40;
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(60,8,'TANGGAL',1,0,'C',1);

$pdf->SetX(65);
$pdf->Cell(50,8,'KODE SKU',1,0,'C',1);

$pdf->SetX(115);
$pdf->Cell(60,8,'NAMA PRODUK',1,0,'C',1);

$pdf->SetX(175);
$pdf->Cell(50,8,'HARGA',1,0,'C',1);

$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 48;

//Now show the columns
$pdf->SetFont('Arial','',10);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(60,6,$column_tanggal,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(65);
$pdf->MultiCell(50,6,$column_kodeSKU,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(115);
$pdf->MultiCell(60,6,$column_namaProduk,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(175);
$pdf->MultiCell(50,6,$column_harga,1,'C');

$pdf->Output();
// old
// //Fields Name position
// $Y_Fields_Name_position = 40;
// //Gray color filling each Field Name box
// $pdf->SetFillColor(110,180,230);
// //Bold Font for Field Name
// $pdf->SetFont('Arial','B',10);
// $pdf->SetY($Y_Fields_Name_position);
// $pdf->SetX(5);
// $pdf->Cell(30,8,'KODE SKU',1,0,'C',1);

// $pdf->SetX(35);
// $pdf->Cell(90,8,'NAMA PRODUK',1,0,'C',1);

// $pdf->SetX(125);
// $pdf->Cell(15,8,'STOK',1,0,'C',1);

// $pdf->SetX(140);
// $pdf->Cell(25,8,'TERJUAL',1,0,'C',1);

// $pdf->SetX(165);
// $pdf->Cell(40,8,'HARGA',1,0,'C',1);

// $pdf->Ln();

// //Table position, under Fields Name
// $Y_Table_Position = 48;

// //Now show the columns
// $pdf->SetFont('Arial','',10);

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(5);
// $pdf->MultiCell(30,6,$column_kodeSKU,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(35);
// $pdf->MultiCell(90,6,$column_namaProduk,1,'L');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(125);
// $pdf->MultiCell(15,6,$column_stok,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(140);
// $pdf->MultiCell(25,6,$column_totalTerjual,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(165);
// $pdf->MultiCell(40,6,$column_harga,1,'C');

// $pdf->Output();
?>


