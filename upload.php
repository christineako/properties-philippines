<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";



/////////////////////////////////////////////////////////////////////////////////
//UPLOAD PHOTO ID PICTURE
if(isset($_POST['myDZ3'])){
	//Array ( [name] => IMG_0130.jpg [type] => image/jpeg [tmp_name] => D:\wamp\tmp\phpE467.tmp [error] => 0 [size] => 18128 )
	$foldername = "items/".$_POST['myDZ3']."/";
	$photo = $_FILES["file"];
	$userfolder = $foldername;
	
	if (!file_exists($userfolder)) {
	    mkdir($userfolder, 0777, true);
	}
	
	$tempFile = $_FILES['file']['tmp_name'];
	$orignameFile = $_FILES['file']['name'];
	$nameFile = $userfolder."id.jpg";
	//imgresize($tempFile,600);
	imgresizewh($tempFile,150,150);
	if (!move_uploaded_file($tempFile,$nameFile)) {
		echo msgoutme("danger","Ooops!","File $orignameFile cannot be uploaded...");
	}
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//UPLOAD PHOTO IN EDIT
if(isset($_POST['myDZ2'])){
	//Array ( [name] => IMG_0130.jpg [type] => image/jpeg [tmp_name] => D:\wamp\tmp\phpE467.tmp [error] => 0 [size] => 18128 )
	$foldername = cfg::get('itempath').$_POST['myDZ2'];
	$photo = $_FILES["file"];
	$userfolder = $foldername;
	
	if (!file_exists($userfolder)) {
	    mkdir($userfolder, 0777, true);
	}
	
	$tempFile = $_FILES['file']['tmp_name'];
	$orignameFile = $_FILES['file']['name'];
	$nameFile = $userfolder."/".time()."_".$orignameFile.".jpg";
	//imgresize($tempFile,600);
	imgresizewh($tempFile,800,600);
	if (!move_uploaded_file($tempFile,$nameFile)) {
		echo msgoutme("danger","Ooops!","File $orignameFile cannot be uploaded...");
	}
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//UPLOAD PHOTO AND DATA LISTING 
if(isset($_POST['myDZ1'])){
	//Array ( [name] => IMG_0130.jpg [type] => image/jpeg [tmp_name] => D:\wamp\tmp\phpE467.tmp [error] => 0 [size] => 18128 )
	$foldername = $_POST['myDZ1'];
	$photo = $_FILES["file"];
	$userdata_arr = get_login_data();
	$userfolder = $itemspath.$userdata_arr['usercode']."/".$foldername;
	
	if (!file_exists($userfolder)) {
	    mkdir($userfolder, 0777, true);
	}
	
	$tempFile = $_FILES['file']['tmp_name'];
	$orignameFile = $_FILES['file']['name'];
	$nameFile = $userfolder."/".time()."_".$orignameFile.".jpg";
	//imgresize($tempFile,600);
	imgresizewh($tempFile,800,600);
	if (!move_uploaded_file($tempFile,$nameFile)) {
		echo msgoutme("danger","Ooops!","File $orignameFile cannot be uploaded...");
	}
	exit();
}	

if(isset($_POST['save_listing_data'])){
	$data = $_POST["save_listing_data"];
	$data = json_decode($data, true);
	$a = filterSymbols($data['a']); //prop type code
	$b = filterSymbols($data['b']); //prop class code
	$c = filterSymbols($data['c']);//filter //name
	$d = filterSymbols($data['d']);//filter //description
	$e = filterSymbols($data['e']); //prop loc
	$f = filterSymbols($data['f']); //prop add
	$g = filterSymbols($data['g']); //prop buildingname
	$listingkey = $data['listingkey']; //listing key
	$userdata_arr = get_login_data();

	$fields = "(listingcode,listingdescription,propaddress,proptypecode,propclasscode,loccitycode,usercode,listingkeys,buildingname)";
	$values = "('$c','$d','$f','$a','$b','$e','{$userdata_arr['usercode']}','$listingkey','$g')";
	$insert = insertDT("b_listing",$fields,$values);
	if($insert == 1){

		$S_lname = $userdata_arr['memberlname'];
		$S_fname = $userdata_arr['memberfname'];
		$S_email = $userdata_arr['email'];
		$S_cellno = $userdata_arr['membercellno'];

		$subject2 = "$S_fname $S_lname Created a listing!";
    	$message2 = "Name: $S_fname $S_lname<br>";
    	$message2 .= "Email: $S_email<br>";
    	$message2 .= "CellNo: $S_cellno<br>";

    	$message2 .= "Type: $a<br>";
    	$message2 .= "Class: $b<br>";
    	$message2 .= "Title: $c<br>";
    	$message2 .= "Description: $d<br>";
    	$message2 .= "Location: $e<br>";
    	$message2 .= "Address: $f<br>";
    	$message2 .= "Building: $g<br>";
    	$message2 .= "Listing Key: $h<br>";

    	$header2 = "From: <inquire@eastwoodcitycondo.com> \r\n";
		$header2 .= "Reply-To: ".$S_email." \r\n";
		$header2 .= "Content-type: text/html \r\n";
    	mail($emailserver2,$subject2,$message2,$header2);

		echo msgoutme("info","Good!","Data Added...");
		echo rundisfunction('reset_dis("#A_a,#A_b,#A_c,#A_d,#A_e,#A_f,#A_g");');
	}else{
		echo msgoutme("danger","Ooops!","Something went wrong, $insert...");
	}
	exit();
}

if(isset($_POST['save_admit_ads_data'])){
	$data = $_POST["save_admit_ads_data"];
	$data = json_decode($data, true);
	$id = $data['id'];//id
	$a = filterSymbols($data['a']);//filter //title
	$b = filterSymbols($data['b']);//filter //description
	$c = filterSymbols($data['c']);//seenby
	$d = $data['d'];//ads_url
	$listingkey = $data['listingkey']; //listing key

	if($id == ""){
		$fields = "(filename,title,description,seenby,ads_url)";
		$values = "('$listingkey','$a','$b','$c','$d')";
		$insert = insertDT("c_side_ads",$fields,$values);
		if($insert == 1){
			echo msgoutme("info","Good!","Data Added...");
			echo rundisfunction('reset_dis("#A_a,#A_b,#A_d,#A_id,#A_file");');
			echo rundisfunction('change_select_val("A_c","All");');
			
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong, $insert...");
		}
	}else{
		$fieldsandvalues = "filename = '$listingkey',title = '$a', description = '$b', seenby = '$c', ads_url = '$d'";
		$update = updateDT("c_side_ads",$fieldsandvalues,"recno",$id);
		if($update == 1){
			echo msgoutme("info","Good!","Data updated...");
			echo rundisfunction('reset_dis("#A_a,#A_b,#A_d,#A_id,#A_file");');
			echo rundisfunction('change_select_val("A_c","All");');
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong, $update...");
		}
	}
	exit();
}


if(isset($_POST['myDZ3'])){
	//Array ( [name] => IMG_0130.jpg [type] => image/jpeg [tmp_name] => D:\wamp\tmp\phpE467.tmp [error] => 0 [size] => 18128 )
	$foldername = $_POST['myDZ3'];
	$photo = $_FILES["file"];
	$userdata_arr = get_login_data();
	$filename = $itemspath."0_side_ads/".$foldername.".jpg";
	
	$tempFile = $_FILES['file']['tmp_name'];
	$orignameFile = $_FILES['file']['name'];
	$nameFile = $filename;
	imgresize($tempFile,600);
	//imgresizewh($tempFile,600,600);
	if (!move_uploaded_file($tempFile,$nameFile)) {
		echo msgoutme("danger","Ooops!","File $orignameFile cannot be uploaded...");
	}
	exit();
}	
?>