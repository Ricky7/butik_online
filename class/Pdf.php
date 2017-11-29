<?php
require('../owner/fpdf/fpdf.php');
include "../db.php";

class Pdf extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        //$this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// // Instanciation of inherited class
// $pdf = new Pdf();
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->SetFont('Times','',12);

// $query = 'SELECT * FROM pengurus';
// $stmt = $db->prepare($query);
// $stmt->execute();

// //Inisiasi untuk membuat header kolom

// $column_nama = "";
// $column_username = "";
// $column_password = "";
// $column_role = "";


// //For each row, add the field to the corresponding column
// while($row = $stmt->fetch(PDO::FETCH_ASSOC))
// {
//     $nama = $row["nama"];
//     $username = $row["username"];
//     $password = $row["password"];
//     $role = $row["role"];
 
    

//     $column_nama = $column_nama.$nama."\n";
//     $column_username = $column_username.$username."\n";
//     $column_password = $column_password.$password."\n";
//     $column_role = $column_role.$role."\n";
    

// //Create a new PDF file
// $pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
// $pdf->AddPage();

// //Menambahkan Gambar
// //$pdf->Image('../foto/logo.png',10,10,-175);

// $pdf->SetFont('Arial','B',13);
// $pdf->Cell(80);
// $pdf->Cell(30,10,'DATA KARYAWAN',0,0,'C');
// $pdf->Ln();
// $pdf->Cell(80);
// $pdf->Cell(30,10,'PT. NiqoWeb Cikarang',0,0,'C');
// $pdf->Ln();

// }
// //Fields Name position
// $Y_Fields_Name_position = 30;
// //Gray color filling each Field Name box
// $pdf->SetFillColor(110,180,230);
// //Bold Font for Field Name
// $pdf->SetFont('Arial','B',10);
// $pdf->SetY($Y_Fields_Name_position);
// $pdf->SetX(5);
// $pdf->Cell(25,8,'NIK',1,0,'C',1);
// $pdf->SetX(30);
// $pdf->Cell(40,8,'Nama',1,0,'C',1);
// $pdf->SetX(70);
// $pdf->Cell(25,8,'Tempat Lahir',1,0,'C',1);
// $pdf->SetX(95);
// $pdf->Cell(25,8,'Tanggal Lahir',1,0,'C',1);
// $pdf->SetX(120);
// $pdf->Cell(50,8,'Alamat',1,0,'C',1);
// $pdf->SetX(170);
// $pdf->Cell(35,8,'No Telepon',1,0,'C',1);
// $pdf->Ln();

// //Table position, under Fields Name
// $Y_Table_Position = 38;

// //Now show the columns
// $pdf->SetFont('Arial','',10);

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(5);
// $pdf->MultiCell(25,6,$column_nama,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(30);
// $pdf->MultiCell(40,6,$column_nama,1,'L');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(70);
// $pdf->MultiCell(25,6,$column_username,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(95);
// $pdf->MultiCell(25,6,$column_password,1,'C');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(120);
// $pdf->MultiCell(50,6,$column_role,1,'L');

// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(170);
// $pdf->MultiCell(35,6,$column_role,1,'C');
// // for($i=1;$i<=100;$i++)
// //     $pdf->Cell(0,10,'Printing line number '.$i,0,1);
// $pdf->Output();
?>