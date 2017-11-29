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

$query = "SELECT kode_SKU, nama_brg, ukuran_s, harga FROM produk";
$stmt = $db->prepare($query);
$stmt->execute();

date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d H:i:s');

//Inisiasi untuk membuat header kolom
$total_harga = 0;

$column_stok = "";
$column_kodeSKU = "";
$column_namaProduk = "";
$column_harga = "";

//For each row, add the field to the corresponding column
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{

    $kodeSKU = $row["kode_SKU"];
    $namaProduk = $row["nama_brg"];
    $stok = $row["ukuran_s"];
    $harga = $row["harga"];
 
    
    $column_kodeSKU = $column_kodeSKU.$kodeSKU."\n";
    $column_namaProduk = $column_namaProduk.$namaProduk."\n";
    $column_stok = $column_stok.$stok."\n";
    $column_harga = $column_harga.number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)."\n";
    

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
$pdf->Cell(80,8,'TANGGAL : '.$tanggal,1,0,'C',1);
// $pdf->SetX(140);
// $pdf->Cell(25,8,'TOTAL',1,0,'C',1);
// $pdf->SetX(165);
// $pdf->Cell(40,8,'Rp. '.number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan),1,0,'C',1);

//Fields Name position
$Y_Fields_Name_position = 40;
//Gray color filling each Field Name box
$pdf->SetFillColor(110,180,230);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',10);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(5);
$pdf->Cell(60,8,'KODE SKU',1,0,'C',1);

$pdf->SetX(65);
$pdf->Cell(50,8,'NAMA PRODUK',1,0,'C',1);

$pdf->SetX(115);
$pdf->Cell(40,8,'STOK',1,0,'C',1);

$pdf->SetX(155);
$pdf->Cell(50,8,'HARGA',1,0,'C',1);

$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 48;

//Now show the columns
$pdf->SetFont('Arial','',10);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(60,6,$column_kodeSKU,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(65);
$pdf->MultiCell(50,6,$column_namaProduk,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(115);
$pdf->MultiCell(40,6,$column_stok,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(155);
$pdf->MultiCell(50,6,$column_harga,1,'C');

$pdf->Output();

?>


