<?php
	
	require_once '../db.php';

	$keyword = trim($_REQUEST['term']); // this is user input

	$sugg_json = array();    // this is for displaying json data as a autosearch suggestion
	$json_row = array();     // this is for stroring mysql results in json string
 

	$keyword = preg_replace('/\s+/', ' ', $keyword); // it will replace multiple spaces from the input.

	$query = 'SELECT * FROM produk WHERE kode_SKU OR nama_brg LIKE :term'; // select query
	
	$stmt = $db->prepare($query);
	$stmt->execute(array(':term'=>"%$keyword%"));
	
	if ( $stmt->rowCount()>0 ) {
		
		while($recResult = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    $json_row["id"] = $recResult['id_produk'];
		    $json_row["value"] = $recResult['nama_brg'];
		    //$json_row["value"] = $recResult['nama_brg'];
		    $json_row["label"] = $recResult['kode_SKU']. ' ' .$recResult['nama_brg'];
		    array_push($sugg_json, $json_row);
		}
		
	} else {
	    $json_row["id"] = "#";
	    $json_row["value"] = "";
	    $json_row["label"] = "Nothing Found!";
	    array_push($sugg_json, $json_row);
	}
	
	$jsonOutput = json_encode($sugg_json, JSON_UNESCAPED_SLASHES); 
	print $jsonOutput;