<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
if(isset($_GET['id']) && isset($_GET['email'])){
	$id = $_GET['id'];
	$email = $_GET['email'];
	$update = updateDT("a_accounts","email = '$email', memberstatus = 'Verified'","usercode",$id);
	if($update == 1){
		header('Location: login.php?success');
	}else{
		header('Location: login.php?failed');
	}
}else{
	header('Location: index.php');
}



?>