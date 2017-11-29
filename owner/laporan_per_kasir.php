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
$id_kasir = $_POST['id_kasir'];

$query = "SELECT produk.kode_SKU, produk.nama_brg, SUM(order_detail_kasir.jumlah_produk) as jumlah, SUM(order_detail_kasir.total_harga) as total FROM order_detail_kasir INNER JOIN order_kasir INNER JOIN produk ON (order_detail_kasir.id_ok = order_kasir.id_ok) AND (order_detail_kasir.id_produk = produk.id_produk) WHERE date(order_kasir.tgl_order) BETWEEN '{$tgl_awal}' AND '{$tgl_akhir}' AND order_kasir.id_pengurus='{$id_kasir}' GROUP BY produk.kode_SKU ASC";
$stmt = $db->prepare($query);
$stmt->execute();

//Inisiasi untuk membuat header kolom
$total_harga = 0;

$column_kodeSKU = "";
$column_namaProduk = "";
$column_jumlah = "";
$column_total = "";

//For each row, add the field to the corresponding column
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{

	$total_harga += $row["total"];

    $kodeSKU = $row["kode_SKU"];
    $namaProduk = $row["nama_brg"];
    $jumlah = $row["jumlah"];
    $total = $row["total"]; 
    

    $column_kodeSKU = $column_kodeSKU.$kodeSKU."\n";
    $column_namaProduk = $column_namaProduk.$namaProduk."\n";
    $column_jumlah = $column_jumlah.$jumlah."\n";
    $column_total = $column_total.number_format($total,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)."\n";
    

//Create a new PDF file
$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
$pdf->AddPage();

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
$pdf->Cell(40,8,'KODE SKU',1,0,'C',1);

$pdf->SetX(45);
$pdf->Cell(65,8,'NAMA PRODUK',1,0,'C',1);

$pdf->SetX(110);
$pdf->Cell(45,8,'TOTAL PENJUALAN',1,0,'C',1);

$pdf->SetX(155);
$pdf->Cell(50,8,'TOTAL PENDAPATAN',1,0,'C',1);

$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 48;

//Now show the columns
$pdf->SetFont('Arial','',10);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(40,6,$column_kodeSKU,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(65,6,$column_namaProduk,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(110);
$pdf->MultiCell(45,6,$column_jumlah,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(155);
$pdf->MultiCell(50,6,$column_total,1,'C');

$pdf->Output();

?>


