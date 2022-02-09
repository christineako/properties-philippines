<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
if(isset($_GET['id']) && isset($_GET['val'])){
	$id = $_GET['id'];
	$val = $_GET['val'];
	$update = updateDT("a_accounts","password = '$val'","usercode",$id);
	if($update == 1){
		header('Location: login.php?password_updated');
	}else{
		header('Location: login.php?password_failed');
	}
}else{
	header('Location: index.php');
}



?>