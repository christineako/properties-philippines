<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$update = updateDT("a_accounts","memberstatus = 'Verified'","usercode",$id);
	if($update == 1){
		header('Location: login.php?success');
	}else{
		header('Location: login.php?failed');
	}
}else{
	header('Location: index.php');
}



?>