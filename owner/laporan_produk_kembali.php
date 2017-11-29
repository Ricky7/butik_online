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

$query = "SELECT produk.kode_SKU, produk.nama_brg, produk.harga, returns.tgl_return, pengurus.nama FROM returns INNER JOIN produk INNER JOIN pengurus ON (returns.id_produk = produk.id_produk) AND (returns.id_pengurus = pengurus.id) GROUP BY returns.tgl_return ASC";
$stmt = $db->prepare($query);
$stmt->execute();

//Inisiasi untuk membuat header kolom
$total_harga = 0;

$column_kodeSKU = "";
$column_namaProduk = "";
$column_harga = "";
$column_tanggal = "";
$column_pengurus = "";

//For each row, add the field to the corresponding column
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{

	$total_harga += $row["harga"];

    $kodeSKU = $row["kode_SKU"];
    $namaProduk = $row["nama_brg"];
    $tanggal = $row["tgl_return"];
    $harga = $row["harga"];
    $pengurus = $row["nama"];
 
    

    $column_kodeSKU = $column_kodeSKU.$kodeSKU."\n";
    $column_namaProduk = $column_namaProduk.$namaProduk."\n";
    $column_tanggal = $column_tanggal.$tanggal."\n";
    $column_harga = $column_harga.number_format($harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)."\n";
    $column_pengurus = $column_pengurus.$pengurus."\n";
    

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
$pdf->Cell(50,8,'TANGGAL',1,0,'C',1);

$pdf->SetX(55);
$pdf->Cell(35,8,'KODE SKU',1,0,'C',1);

$pdf->SetX(90);
$pdf->Cell(50,8,'NAMA PRODUK',1,0,'C',1);

$pdf->SetX(140);
$pdf->Cell(30,8,'HARGA',1,0,'C',1);

$pdf->SetX(170);
$pdf->Cell(35,8,'HARGA',1,0,'C',1);

$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 48;

//Now show the columns
$pdf->SetFont('Arial','',10);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(5);
$pdf->MultiCell(50,6,$column_tanggal,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(55);
$pdf->MultiCell(35,6,$column_kodeSKU,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(90);
$pdf->MultiCell(50,6,$column_namaProduk,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(140);
$pdf->MultiCell(30,6,$column_harga,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(170);
$pdf->MultiCell(35,6,$column_pengurus,1,'C');

$pdf->Output();

?>


