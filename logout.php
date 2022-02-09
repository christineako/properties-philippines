<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
session_destroy();
header('Location: index.php');

?>