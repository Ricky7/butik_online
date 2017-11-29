<?php
	$asal = $_POST['asal'];
	$id_kabupaten = $_POST['kab_id'];
	$kurir = $_POST['kurir'];
	$berat = $_POST['berat'];

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
	  CURLOPT_HTTPHEADER => array(
	    "content-type: application/x-www-form-urlencoded",
	    "key: ab60697a32a845a7fea4e3969d3750cb"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  //echo $response;
	}

	$data = json_decode($response, true);

	$jumlah_desimal = "0";
	$pemisah_desimal = ",";
	$pemisah_ribuan = ".";

	$values = Array();
	foreach($data['rajaongkir']['results'][0]['costs'] as $cost) {
	    //echo $values[] = $cost['cost'][0]['value'];
	    echo "<option value='".$cost['service']."|".$cost['cost'][0]['value']."'>".$cost['service']."  Rp. ".number_format($cost['cost'][0]['value'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)."</option>";
	}
	
?>