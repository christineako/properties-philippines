<?php
//glory to God...
//by kangkong 
//sept 25 2021
/////////////////////////////////////////////////////////////////////////////////////////////////////
//START
session_start();
date_default_timezone_set('Asia/Singapore');


/////////////////////////////////////////////////////////////////////////////////////////////////////
//DATABASE CLASS
class cfg {
  public static function get($param) {
    //connection string link
    if(file_exists('../../../../philippinerealestatemarket.ini')){
      $condata = parse_ini_file('../../../../philippinerealestatemarket.ini');
      //$getconffile = parse_ini_file('../../../../conf.ini');
    }
    if(file_exists('../../../philippinerealestatemarket.ini')){
      $condata = parse_ini_file('../../../philippinerealestatemarket.ini');
      //$getconffile = parse_ini_file('../../../conf.ini');
    }
    if(file_exists('../../philippinerealestatemarket.ini')){
      $condata = parse_ini_file('../../philippinerealestatemarket.ini');
      //$getconffile = parse_ini_file('../../conf.ini');
    }
    if(file_exists('../philippinerealestatemarket.ini')){
      $condata = parse_ini_file('../philippinerealestatemarket.ini');
      //$getconffile = parse_ini_file('../conf.ini');
    }
    if(file_exists('philippinerealestatemarket.ini')){
      $condata = parse_ini_file('philippinerealestatemarket.ini');
      //$getconffile = parse_ini_file('conf.ini');
    }
    
//    $getconffile = parse_ini_file('conf.ini');
//CINDY
    if(file_exists('conf.ini')){
      $getconffile = parse_ini_file('conf.ini');
    }
    if(file_exists('../conf.ini')){
      $getconffile = parse_ini_file('../conf.ini');
     }
    if(file_exists('../../conf.ini')){
      $getconffile = parse_ini_file('../../conf.ini');
     }
    if(file_exists('../../../conf.ini')){
      $getconffile = parse_ini_file('../../../conf.ini');
    }
//END    
    
    $config = array(

    //links
    'NAME' => "NONE",
    'SUBNAME' => "",
    'VER' => "Version 1.0",
    'FOOTER' => "",

    //paths
    'server_url' => 'http://'.$_SERVER['HTTP_HOST'],
    'base_url' => 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']),
    'base_path' => getcwd().'/',
    'router' => 'router.php',
    'mainpath' => 'data/',
    'itempath' => 'items/',
    'linkname' => 'link.php',

    
    'numrectoshow' => $getconffile['numrectoshow'],

    'linksHTML' => $getconffile['linksHTML'],
    'portalownerHTML' => $getconffile['portalownerHTML'],
    'contactHTML' => $getconffile['contactHTML'],
    'copyrightHTML' => $getconffile['copyrightHTML'],

    'logoIMG' => $getconffile['logoIMG'],
    'companynameHTML' => $getconffile['companynameHTML'],
    'linknameHTML' => $getconffile['linknameHTML'],

    'indexfooterHTML' => $getconffile['indexfooterHTML'],
    'indexfooterdetailsHTML' => $getconffile['indexfooterdetailsHTML'],
    'indexcopyrightHTML' => $getconffile['indexcopyrightHTML'],

    'loginwelcomeHTML' => $getconffile['loginwelcomeHTML'],
    'logincopyrightHTML' => $getconffile['logincopyrightHTML'],

    'AdsHTML' => $getconffile['AdsHTML'],
    'DashboardHTML' => $getconffile['DashboardHTML'],
    'DetailsHTML' => $getconffile['DetailsHTML'],
    'IndexHTML' => $getconffile['IndexHTML'],
    'InquiriesHTML' => $getconffile['InquiriesHTML'],
    'ListingHTML' => $getconffile['ListingHTML'],
    'LoginHTML' => $getconffile['LoginHTML'],
    'ProfileHTML' => $getconffile['ProfileHTML'],

    'DB1' => $condata['database'],
    'LH' => $condata['host'],
    'RT' => $condata['username'],
    'PW' => $condata['password']
    ); 
    $config['base_path'] = str_replace('\\', '/', $config['base_path']);
    return $config[$param];
  }
}


/////////////////////////////////////////////
//VARIABLES
$emailserver1 = "jason_kangkong@hotmail.ph";
$emailserver2 = "christine_ako@yahoo.com";
$itemspath = cfg::get('itempath');
//name of the page publiclink 
$linkname = cfg::get('linkname');



class Db {
  protected static $connection;

  public function connect(){
    if(!isset(self::$connection)){
      self::$connection = new mysqli(cfg::get('LH'),cfg::get('RT'),cfg::get('PW'),cfg::get('DB1'));
    }
    if(self::$connection === false){
      return false;
    }
    return self::$connection;
  }
  public function query($query){
    $connection = $this->connect();
    $result = $connection->query($query);
    return $result;
  }
  public function select($query){
    $rows = array();
    $result = $this->query($query);
    if($result === false){
      return false;
    }
    while ($row = $result -> fetch_assoc()) {
      $rows[] = $row;
    }
    return $rows;
  }
  public function error(){
    $connection = $this->connect();
    return $connection->error;
  }
}

function sendQ($sql){
  if($sql!=""){
    $db = new Db;
    $db->query($sql);
    $e = $db->error();
    if($e==""){
      return 1;
    }else{
      return $e;
    }
  }
}

function selectQ($sql){
  if($sql!=""){
    $db = new Db;
    $res = $db->select($sql);
    $e = $db->error();
    if($e!=""){
      return $e;
    }else{
      if(!$res) {
        return 0;
      }else{
        return $res;
      }
    }
  }
}

function insertDT($tbname,$fields,$values){
  return sendQ("INSERT INTO $tbname $fields VALUES $values ;");
  //return "INSERT INTO $tbname $fields VALUES $values ;";
}

function updateDT($tbname,$fieldsandvalues,$fieldtofind,$findwhat){
  return sendQ("UPDATE $tbname SET $fieldsandvalues WHERE $fieldtofind = '$findwhat' ;");
}

function getLastRec($tbname){
  return selectQ("SELECT RecNo FROM $tbname ORDER BY RecNo DESC LIMIT 1 ;");
}

function getRowsWithSQL($SELECTstring,$FROMstring,$WHEREstring){
  return selectQ("SELECT $SELECTstring FROM $FROMstring WHERE $WHEREstring ;");
}

function getRows($selectwhat,$tbname,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    return selectQ("SELECT $selectwhat FROM $tbname ;");
  }else{
    return selectQ("SELECT $selectwhat FROM $tbname ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
}

function getRow($selectwhat,$tbname,$fieldtofind,$findwhat,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    return selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind = '$findwhat' ;");
  }else{
    return selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind = '$findwhat' ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
}

function getCol($selectwhat,$tbname,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    return selectQ("SELECT $selectwhat FROM $tbname ;");
  }else{
    return selectQ("SELECT $selectwhat FROM $tbname ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
}

function getOne($selectwhat,$tbname,$fieldtofind,$findwhat,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    $aa = selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind = '$findwhat' ;");
  }else{
    $aa = selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind = '$findwhat' ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
  if(is_array($aa)){
      return $aa[0][$selectwhat];
  }else{
      return $aa;
  }
}

function likeOne($selectwhat,$tbname,$fieldtofind,$findwhat,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    $aa = selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind LIKE '%$findwhat%' ;");
  }else{
    $aa = selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind LIKE '%$findwhat%' ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
  if(is_array($aa)){
      return $aa[0][$selectwhat];
  }else{
      return $aa;
  }
}

function likeRow($selectwhat,$tbname,$fieldtofind,$findwhat,$ASCorDESC="",$ADfield=""){
  if($ASCorDESC == ""){
    return selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind LIKE '%$findwhat%' ;");
  }else{
    return selectQ("SELECT $selectwhat FROM $tbname WHERE $fieldtofind LIKE '%$findwhat%' ORDER BY ".$ADfield." ".$ASCorDESC.";");
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
//DATABASE CLASS




/////////////////////////////////////////////////////////////////////////////////////////////////////
//USEFUL FUNCTIONS
function showDB(){
  $out = "";
  $row = selectQ("SHOW DATABASES");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= $r['Database']."<br>";
    }
  }
  return $out;
}

function ep($word){
  return md5($word);
}

function arrayToString($arr){
  return implode(",", $arr);
}

function enCap($string){
  return "'".$string."'";
}

function isselected($val,$dis){
  if($val == $dis){
    return "selected";
  }else{
  	return "";
  }
}

//FOUL WORDS FILTERING
function filter_disallowed_words($text){
  $row = getRows("disallowed,substitute","z_disallowed_words");
  $arr_a = [];
  $arr_b = [];
  if(is_array($row)){
    foreach ($row as $r) {
        $a = $r['disallowed'];
        $b = $r['substitute'];
        array_push($arr_a, $a);
        array_push($arr_b, $b);
    }
    return str_replace($arr_a,$arr_b,$text);
  }else{
    return $text;
  }
}

//SYMBOLS FILTERING
function filterSymbols($text,$how="input"){
  if($text != ""){
		$a = array("\r\n","$","%","'","\t",";","{","}","[","]",'"');
		$b = array("<br>","&#36;","&#37;","&#39;","&nbsp;","&#59;","&#123;","&#125;","&#91;","&#93;","&#34;");

		if($how == "input"){
      $distext = filter_disallowed_words($text);
			return str_replace($a,$b,$distext); 
		}
    if($how == "output"){
			return str_replace($b,$a,$text); 
		}
  }
}

function createRandomPassword(){ 
    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 
    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 
    return $pass; 
}

function formatPeso($value){
  if(!is_numeric($value)){
    return "P 0.00";
  }else{
    if($value){
      return "P ".number_format($value, 2, '.',',');
    }else{
      return "P 0.00";
    }
  }
}

function formatPeso_nopeso($value){
  if(!is_numeric($value)){
    return "0.00";
  }else{
    if($value){
      return "P ".number_format($value, 2, '.',',');
    }else{
      return "0.00";
    }
  }
}

function formatMyDate($mydate,$myformat="Y-m-d"){
  if($mydate != "0000-00-00" || $mydate != "" || $mydate != "0000-00-00 00:00:00" || $mydate != NULL){
  	$date = date_create($mydate);
  	return date_format($date,$myformat);
  }
}


function timeAgo($date) {
  $timestamp = strtotime($date); 
  $strTime = array("second", "minute", "hour", "day", "month", "year");
  $length = array("60","60","24","30","12","10");
  $currentTime = time();
  if($currentTime >= $timestamp) {
    $diff = $currentTime - $timestamp;
    for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
      $diff = $diff / $length[$i];
    }
    $diff = round($diff);
    return $diff . " " . $strTime[$i] . "s ago";
  }else{
    return "Just now";
  }
}

function timeAgo2($date) {
  $timestamp = strtotime($date); 
  $strTime = array("second", "minute", "hour", "day", "month", "year");
  $length = array("60","60","24","30","12","10");
  $currentTime = time();
  if($currentTime >= $timestamp) {
    $diff = $currentTime - $timestamp;
    for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
      $diff = $diff / $length[$i];
    }
    $diff = round($diff);
    //return $diff . " " . $strTime[$i] . "s ago";
    if($strTime[$i] == "day"){
      return formatMyDate($date);
    }else{
      return $diff . " " . $strTime[$i] . "s ago";
    }
  }else{
    return "Just now";
  }
}

function imgresize($img,$max_res){
  if(file_exists($img)){
    $orig_img = imagecreatefromjpeg($img);
    $orig_w = imagesx($orig_img);
    $orig_h = imagesy($orig_img);
    
    if($orig_h > $orig_w){
      $ratio = $max_res / $orig_w;
      $new_w = $max_res;
      $new_h = $orig_h * $ratio;
    }else{
      $ratio = $max_res / $orig_h;
      $new_h = $max_res;
      $new_w = $orig_w * $ratio;
      $center = 100;
    }

    if($orig_img){
      $ww = $max_res / 2;
      $center = ($new_w / 2) - $ww;
      $new_img = imagecreatetruecolor($new_w, $new_h);
      imagecopyresampled($new_img, $orig_img, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
      
      $new_crop_img = imagecreatetruecolor($max_res, $max_res);
      imagecopyresampled($new_crop_img, $new_img, 0, 0, $center, 0, $max_res, $max_res, $max_res, $max_res);

      imagejpeg($new_crop_img,$img,90);
    }
  }
}

function imgresizewh($img,$w,$h){
  if(file_exists($img)){
    $orig_img = imagecreatefromjpeg($img);
    $orig_w = imagesx($orig_img);
    $orig_h = imagesy($orig_img);

    if($orig_img){
      $new_img = imagecreatetruecolor($w, $h);
      imagecopyresampled($new_img, $orig_img, 0, 0, 0, 0, $w, $h, $orig_w, $orig_h);
      imagejpeg($new_img,$img,90);
    }
  }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
//USEFUL FUNCTIONS








/////////////////////////////////////////////////////////////////////////////////////////////////////
//HTML OUT FUNCTIONS
function rundisfunction($functioname){
    return '<script type="text/javascript">'.$functioname.'</script>';
}

function loaderoff(){
    return '<script type="text/javascript">loaderoff();</script>';
}

function jsredirect($url){
return <<< EOFILE
  <script type="text/javascript">
    window.location.href = "$url";
  </script>
EOFILE;
}

//change this to what bootstrap version
function msgoutme($messagetype,$strong,$msg){
return <<< EOFILE
    <div class="alert alert-$messagetype alert-dismissible fade show" role="alert">
      <strong>$strong</strong> $msg
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
EOFILE;
}

function head_tag($mainpath){
$curr = time();
$out = <<< EOFILE
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
	<link rel="shortcut icon" type="image/png" href="{$mainpath}img/logo30x30.png">
	
	<link rel="stylesheet" href="{$mainpath}css/bootstrap.min.css">

	<link rel="stylesheet" href="{$mainpath}css/all.min.css">
	<link rel="stylesheet" href="{$mainpath}css/animations.css">
	<link rel="stylesheet" href="{$mainpath}dropzone/dropzone.min.css">
	<link rel="stylesheet" href="{$mainpath}mycss.css?ver=$curr">

	<script src="{$mainpath}js/jquery-3.6.0.min.js"></script>
	<script src="{$mainpath}js/bootstrap.bundle.min.js"></script>
	<script src="{$mainpath}js/popper.min.js"></script>
	<script src="{$mainpath}js/all.min.js"></script>
	<script src="{$mainpath}dropzone/dropzone.min.js"></script>
	<script src="{$mainpath}myjs.js?ver=$curr"></script>
EOFILE;
return $out;
}




/////////////////////////////////////////////////////////////////////////////////////////////////////
// ADS HTML OUTPUT
function sideadsfooter_tag(){
  $data = "";
  $data1 = "";
  $sql = "
    SELECT *
    FROM c_side_ads
    WHERE NOT seenby = 'Non-Members'
    AND status = 'on'
    ORDER BY RAND()
    LIMIT 5;
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    for ($i=0; $i < count($row); $i++) { 

      $active = "";
      if($i == 0){
        $active = "active";
      }
      $a = $row[$i]['recno'];
      $b = $row[$i]['filename'];
      $c = $row[$i]['title'];
      $d = $row[$i]['description'];
      $e = timeAgo($row[$i]['dateinserted']);
      $f = $row[$i]['ads_url'];

      $path = cfg::get('itempath')."0_side_ads/$b.jpg";
      
      $data1 .= "<li data-bs-target='#car3' data-bs-slide-to='$i' class='bg-secondary $active'></li>";
      
      $url = "class='card border-0'";
      if($f != ""){
        $url = "onclick='loadMyURL(`$f`,`blank`)' class='card border-0 mypointer'";
      }

      $data .= "
        <div class='carousel-item $active'>
            <div $url>
              <img src='$path' class='card-img-top' alt='card-img-top'>
              <div class='card-body'>
                <h5 class='card-title'>$c</h5>
                <p class='card-text'>
                  $d
                </p>
                <small class='text-muted'>
                  <i class='fa fa-comment me-2'></i>Posted $e
                </small>
              </div>
            </div>
            <br><br>
          </div>
      ";
    }
  }

$weblinks = cfg::get('linksHTML');
$portalowner = cfg::get('portalownerHTML');
$conatctus = cfg::get('contactHTML');
$copyright = cfg::get('copyrightHTML');

$out = <<< EOFILE
	<!-- Ads -->
	<div class="col-lg-3">
		<div class="border bg-white p-2">
			<!-- Ads side carousel -->
        <div id="car3" class="carousel slide border mb-2" data-bs-ride="carousel">
          <ol class="carousel-indicators">
            $data1
          </ol>
          <div class="carousel-inner">
            $data
          </div>
        </div>

        
			<!-- Web Links -->
      $weblinks

			<!-- Portal Owner -->
			$portalowner

			<!-- Contact Us -->
			$conatctus

		</div>
    <!-- Copyright -->
		$copyright


		<br><br><br>
	</div>
EOFILE;
return $out;
}

function sideadslogin_tag(){
$data = "";
$data1 = "";
  $sql = "
    SELECT *
    FROM c_side_ads
    WHERE NOT seenby = 'Members'
    AND status = 'on'
    ORDER BY RAND()
    LIMIT 5;
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    for ($i=0; $i < count($row); $i++) { 

      $active = "";
      if($i == 0){
        $active = "active";
      }
      $a = $row[$i]['recno'];
      $b = $row[$i]['filename'];
      $c = $row[$i]['title'];
      $d = $row[$i]['description'];
      $e = timeAgo($row[$i]['dateinserted']);
      $path = cfg::get('itempath')."0_side_ads/$b.jpg";
      
      $data1 .= "<li data-bs-target='#car2' data-bs-slide-to='$i' class='$active'></li>";

      $data .= "
        <div class='carousel-item $active h-100 w-100'>
          <img src='$path' class='d-block h-100 w-100 mygrad' alt='Slide $i'>
          <div class='carousel-caption d-none d-sm-block'>
            <h5>$c</h5>
            <p>$d</p>
          </div>
        </div>
      ";
    }
  }

$out = <<< EOFILE
  <div id="car2" class="carousel slide h-100 w-100" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      $data1
    </ol>
    <div class="carousel-inner h-100 w-100">
      $data
    </div>
  </div>
EOFILE;
return $out;
}


function sideadsindex_tag($divid){
$data = "";
$data1 = "";
  $sql = "
    SELECT *
    FROM c_side_ads
    WHERE NOT seenby = 'Members'
    AND status = 'on'
    ORDER BY RAND()
    LIMIT 5;
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    for ($i=0; $i < count($row); $i++) { 

      $active = "";
      if($i == 0){
        $active = "active";
      }
      $a = $row[$i]['recno'];
      $b = $row[$i]['filename'];
      $c = $row[$i]['title'];
      $d = $row[$i]['description'];
      $e = timeAgo($row[$i]['dateinserted']);
      $path = cfg::get('itempath')."0_side_ads/$b.jpg";
      
      $data1 .= "<li data-bs-target='#$divid' data-bs-slide-to='$i' class='bg-secondary $active'></li>";

      $data .= "
        <div class='carousel-item $active'>
          <div class='card'>
            <div class='row g-0'>
              <div class='col-6'>
                  <img src='$path' class='img-fluid w-100' alt='card-horizontal-image' alt='Slide $i' style=''>
              </div>
              <div class='col-6'>
                <div class='card-body p-md-5'>
                  <h5 class='card-title'>$c</h5>
                  <p class='card-text'>$d</p>
                  <p class='card-text'><small class='text-muted'>Last updated $e</small></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      ";
    }
  }

$out = <<< EOFILE
      <div id="$divid" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
          $data1
        </ol>
        <div class="carousel-inner">
          $data
        </div>
      </div>
EOFILE;
return $out;
}


function sideadsindex_tag2($divid){
$data = "";
  $sql = "
    SELECT *
    FROM c_side_ads
    WHERE NOT seenby = 'Members'
    AND status = 'on'
    ORDER BY RAND()
    LIMIT 1;
  ";
  $row = selectQ($sql);
  if(is_array($row)){

      $a = $row[0]['recno'];
      $b = $row[0]['filename'];
      $c = $row[0]['title'];
      $d = $row[0]['description'];
      $e = timeAgo($row[0]['dateinserted']);
      $f = $row[0]['ads_url'];
      $path = cfg::get('itempath')."0_side_ads/$b.jpg";

      $url = "class='card my-2'";
      if($f != ""){
        $url = "onclick='loadMyURL(`$f`,`blank`)' class='card my-2 mypointer'";
      }

      $data .= "
          <div $url>
            <div class='row g-0'>
              <div class='col-sm-4'>
                  <img src='$path' class='img-fluid w-100' alt='card-horizontal-image' alt='Slide' style=''>
              </div>
              <div class='col-sm-8'>
                <div class='card-body'>
                  <h5 class='card-title'>$c</h5>
                  <p class='card-text'>$d</p>
                  <p class='card-text'><small class='text-muted'>Last updated $e</small></p>
                </div>
              </div>
            </div>
          </div>
        
      ";
    
  }

$out = <<< EOFILE
      <div id="$divid" class="">
          $data
      </div>
EOFILE;
return $out;
}







function topnav_tag(){
$userdata_arr = get_login_data();
$data = "";
if($userdata_arr){
  $usercode = $userdata_arr['usercode'];
  $a = $userdata_arr['membertype'];
  $b = $userdata_arr['memberlname'];
  $c = $userdata_arr['memberfname'];
  $d = $userdata_arr['memberstatus'];
  $e = $userdata_arr['membercellno'];
  $f = $userdata_arr['email'];

  $memberlink = getOne("memberlink","a_accounts","usercode",$usercode);
  $dislink = cfg::get('server_url')."/".cfg::get('linkname')."?".$memberlink;
  if($memberlink == ""){
    $buttonlink = "";
  }else{
    $buttonlink = " <button type='button' onclick='loadMyURL(`$dislink`,`blank`);' class='btn btn-outline-info border-0 mx-1 text-white'>
                      <i class='fa fa-globe'></i><span class='ms-2 d-none d-md-inline'>My WebLink</span>
                    </button>";
  }

$data = <<< EOFILE
        <div class="p-0 align-self-center">
          <button onclick="location.href=`dashboard.php`;" type="button" class="btn btn-outline-info border-0 mx-1 text-white">
            <i class="fa fa-home"></i><span class="ms-2 d-none d-md-inline">Dashboard</span>
          </button>
        </div>
        <div class="p-0 align-self-center">
          $buttonlink
        </div>
        <div class="p-0 align-self-center">
            <div class="dropdown">
              
              <button class="btn btn-outline-info border-0 mx-1 dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user"></i><span class="ms-2 d-none d-md-inline">$c $b</span>
              </button>
              
              <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                
                
                <li><a class="dropdown-item" href="profile.php"><i class="miniiconsize me-2 fa fa-user"></i>Profile</a></li>
                <li><a class="dropdown-item" href="listing.php"><i class="miniiconsize me-2 fa fa-clipboard-list"></i>Listing</a></li>
                <li><a class="dropdown-item" href="ads.php"><i class="miniiconsize me-2 fa fa-newspaper"></i>Ads</a></li>
                <li><a class="dropdown-item" href="inquiries.php"><i class="miniiconsize me-2 fa fa-question-circle"></i>Inquiries</a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="miniiconsize me-2 fa fa-times"></i>Log Out</a></li>
              </ul>
            </div>
        </div>
EOFILE;
}else{
$data = <<< EOFILE
        <div class="p-1 align-self-center">
          <button onclick="location.href=`login.php`;" type="button" class="btn btn-info bg-col1 border-0 text-white" style="height: 44px;">
            <i class="fa fa-sign-in-alt"></i><span class="ms-2 d-none d-md-inline">List your property</span>
          </button>
        </div>
EOFILE;
}

$companynameHTML = cfg::get('companynameHTML');
$linknameHTML = cfg::get('linknameHTML');
$logoIMG = cfg::get('logoIMG');
//data/img/logo100x100.png

$out = <<< EOFILE
	<!-- Top Nav -->
	<nav class="fixed-top navbar-light bg-col1">
		<div class="container-fluid py-2">
			<div class="d-flex">
				<div class="p-0 align-self-center">
          <a class="" href="index.php" style="text-decoration:none">
					 <img src="$logoIMG" class="img-fluid rounded-circle bg-white" alt="img-fluid" width="50" height="50">
          </a>
				</div>
				<div class="p-0 align-self-center flex-grow-1">
          <a class="" href="index.php" style="text-decoration:none">
					 <span class="ms-2 fs-5 text-truncate text-white">$companynameHTML</span>
          </a>
				</div>
        $data
			</div>
		</div>
	</nav>
EOFILE;
return $out;
}

function topnav_admin_tag(){
$out = <<< EOFILE
	<!-- Top Nav -->
	<nav class="fixed-top navbar-light bg-danger">
		<div class="container-fluid maxw1080">
			<div class="d-flex">
				<div class="p-1 align-self-center">
					<img src="../data/img/logo100x100.png" class="img-fluid" alt="img-fluid" width="50" height="50">
				</div>
				<div class="p-1 align-self-center flex-grow-1">
					<span class="fs-5 text-truncate text-white d-none d-md-inline">Philippine Real Estate Market</span>
				</div>
        <div class="p-1 align-self-center">
          <div class="dropdown">
            <button class="btn btn-outline-danger dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              Utility
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
              <li><button class="dropdown-item" onclick="expirationcheck()" ><i class="miniiconsize me-2 fa fa-check"></i>Expiration Checker</button>
              <li><button class="dropdown-item" onclick="cretedummy()" ><i class="miniiconsize me-2 fa fa-folder"></i>Create Dummy Folders</button>
            </ul>
          </div>
        </div>
				<div class="p-1 align-self-center">
					<div class="dropdown">
						<button class="btn btn-outline-danger dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
							Admin
						</button>
						<ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
							<li><a class="dropdown-item" href="admin.php?accounts"><i class="miniiconsize me-2 fa fa-angle-right"></i>Members</a></li>
							<li><a class="dropdown-item" href="admin.php?membertype"><i class="miniiconsize me-2 fa fa-angle-right"></i>Member Type</a></li>
							<li><a class="dropdown-item" href="admin.php?propertytype"><i class="miniiconsize me-2 fa fa-angle-right"></i>Property Type</a></li>
							<li><a class="dropdown-item" href="admin.php?propertyclass"><i class="miniiconsize me-2 fa fa-angle-right"></i>Property Class</a></li>
							<li><a class="dropdown-item" href="admin.php?locationcity"><i class="miniiconsize me-2 fa fa-angle-right"></i>Location City</a></li>
							<li><a class="dropdown-item" href="admin.php?listingtype"><i class="miniiconsize me-2 fa fa-angle-right"></i>Listing Type</a></li>
							<li><a class="dropdown-item" href="admin.php?mincontract"><i class="miniiconsize me-2 fa fa-angle-right"></i>Min Contract</a></li>
							<li><a class="dropdown-item" href="admin_ads.php"><i class="miniiconsize me-2 fa fa-angle-right"></i>Ads Management</a></li>
              <li><a class="dropdown-item" href="admin_news.php"><i class="miniiconsize me-2 fa fa-angle-right"></i>News Management</a></li>
							<li><hr class="dropdown-divider"></li>
              <br>
							<li><a class="dropdown-item" href="../logout.php"><i class="miniiconsize me-2 fa fa-times"></i>Log Out</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
EOFILE;
return $out;
}

function sidenav_admin_tag(){
$out = <<< EOFILE
  <!-- Side Nav -->
  <div class="border bg-white p-2 pt-5 d-none d-lg-block">
    <div class="text-center mb-3">
      <p class="h5">Admin</p>
    </div>
    <div class="mb-5">
      <ul class="list-group list-group-flush text-left">
        <li onclick="location.href=`admin.php?accounts`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Members</a></li>
        <li onclick="location.href=`admin.php?membertype`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Member Type</a></li>
        <li onclick="location.href=`admin.php?propertytype`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Property Type</a></li>
        <li onclick="location.href=`admin.php?propertyclass`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Property Class</a></li>
        <li onclick="location.href=`admin.php?locationcity`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Location City</a></li>
        <li onclick="location.href=`admin.php?listingtype`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Listing Type</a></li>
        <li onclick="location.href=`admin.php?mincontract`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Min Contract</a></li>
        <li onclick="location.href=`admin_ads.php`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>Ads Management</a></li>
        <li onclick="location.href=`admin_news.php`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-angle-right"></i>News Management</a></li>
        <br>
        <li onclick="location.href=`../logout.php`;" class="list-group-item text-secondary list-group-item-action"><i class="miniiconsize me-2 fa fa-times"></i>Log Out</a></li>
      </ul>
    </div>
  </div>
EOFILE;
return $out;
}



function banner_tag($pic){
$out = <<< EOFILE
	<!-- Banner -->
	<div>
		<img src="$pic" class="img-fluid banner" alt="img-fluid">
	</div>
EOFILE;
return $out;
}


function privatemessage_tag(){
$out = <<< EOFILE
	<!-- Modal Privatemessage -->
	<div class="modal fade" id="privatemsg" tabindex="-1" aria-labelledby="privatemsglbl" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="privatemsglbl">Private Message</h5>
				</div>
				<div class="modal-body">
					<div class="form-floating">
						<textarea class="form-control" placeholder="Message" id="floatingTextarea" style="height: 200px"></textarea>
						<label for="floatingTextarea">Message</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info text-white" data-bs-dismiss="modal">
						<i class="fa fa-times me-2"></i>Cancel
					</button>
					<button type="button" class="btn btn-info text-white">
						<i class="fa fa-comment-alt me-2"></i>Send
					</button>
				</div>
			</div>
		</div>
	</div>
EOFILE;
return $out;
}

function loader_tag(){
$out = <<< EOFILE
	<!-- Loader -->
	<div id="loader" class="full_out">
	  <div class="full_in">
	    <div id="spin" class="spinner-border" role="status">
	      <span class="sr-only">Loading...</span>
	    </div>
	  </div>
	</div>
	<div id="cover" class="full_out"></div>
EOFILE;
return $out;
}

function error_tag($msg=""){

$out = <<< EOFILE
	<!-- Error Messages-->
	<div id="err" class="errormsg p-2" style="z-index: 9999;">
		$msg
    <!--
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Good!</strong> Your messages goes here...
			 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		  </div>
    -->
	</div>
EOFILE;
return $out;
}


function sec404(){
return <<< EOFILE
<!DOCTYPE html>
<html>
<head>
  <title>Ooops!</title>
</head>
<body style="color: white; text-align: center; font-family: calibri; background-color: black; padding: auto; margin-top: 100px; line-height: 30px;">
  <h1 style="font-size: 115pt; padding: 13px; margin: 0px; color: gray; line-height: 70px;" >404<h1>
  <h4 style="font-size: 27pt; padding: 0px; margin: 0px;">Security check!</h4> 
  <p style="font-size: 13pt; padding: 0px; margin: 0px;">You are not allowed to do this...</p>
</body>
</html>
EOFILE;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
//HTML OUT FUNCTIONS










///////////////////////////////////////////////////////////////////////
//AUTO CREATE ELEMENT
function create_element($htmlID,$htmlclass,$arr,$field,$recno="",$height="",$forced="",$forced2=""){
  $input = "";
  $tbname = $arr['tbname'][0];
  $description = $arr[$field][0];
  $datatype = $arr[$field][1];
  $numchr = $arr[$field][2];
  $disena = $arr[$field][3];
  $showhide = $arr[$field][4];
  

  if($forced2 != ""){
    $disena = "";
  }



  $word = "";
  $len = "";
  if($recno != ""){
    $word = filterSymbols(getOne($field,$tbname,"recno",$recno),"output");
  }
  
  //text
  if($datatype == "text"){
    $len = "maxlength='$numchr'";
    $input = "
      <input type='$datatype' class='form-control' id='$htmlID' placeholder='$description' value='$word' $len $disena>
      <label for='$htmlID'>$description</label>
    ";
  }

  //number/date
  if($datatype == "number" || $datatype == "date"){
    $input = "
      <input type='$datatype' class='form-control' id='$htmlID' placeholder='$description' value='$word' $len $disena>
      <label for='$htmlID'>$description</label>
    ";
  }

  //password
  if($datatype == "password"){
    $input = "
      <input type='$datatype' class='form-control' id='$htmlID' placeholder='$description' value='' $len $disena>
      <label for='$htmlID'>$description</label>
    ";
  }

  //textarea
  if($datatype == "textarea"){
    $len = "maxlength='$numchr'";
    $input = "
      <textarea class='form-control' placeholder='$description' id='$htmlID' style='height: $height' $len $disena>$word</textarea>
      <label for='$htmlID'>$description</label>
    ";
  }

  // select
  if($datatype == "select" && $forced == ""){
    if($arr[$field][5] != null){
      $phpoptions = $arr[$field][5];
    }
    $input = "
      <select class='form-select' id='$htmlID' aria-label='$description' style='min-width: 130px;' $disena>
        $phpoptions
      </select>
      <label for='$htmlID'>$description</label>
      <script type='text/javascript'>
        change_select_val('$htmlID','$word');
        </script>
    ";
  }else{
    $len = "maxlength='$numchr'";
    $input = "
      <input type='$datatype' class='form-control' id='$htmlID' placeholder='$description' value='$word' $len $disena>
      <label for='$htmlID'>$description</label>
    ";
  }

  // <div class="form-floating mb-3">
  //  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
  //  <label for="floatingInput">Email address</label>
  // </div>


  // <div class="form-floating">
  //  <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px"></textarea>
  //  <label for="floatingTextarea">Comments</label>
  // </div>


  // <div class="form-floating">
  //  <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
  //    <option selected="">Open this select menu</option>
  //    <option value="1">One</option>
  //    <option value="2">Two</option>
  //    <option value="3">Three</option>
  //  </select>
  //  <label for="floatingSelect">Works with selects</label>
  // </div>
  $out = "
  <div class='form-floating $htmlclass' style='display: $showhide'>
    $input
  </div>
  ";
  return $out;
}

//'fieldname' => ['label','text/number/date/textarea/select','num of char','disable/enable','show/hide','options'],
$arr_tbname = array(
  'tbname' => ['tbname'],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'field' => ['label','what',0,'',''],
  'END' => ['','','']
);



function opt_membertype($defval='',$defname='All'){
  //$out = "<option value='$defval' selected>$defname</option>";
  $out = "";
  $row = getCol("membertypecode,membertypedesc","a_membertype","ASC","membertypecode");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['membertypecode']}'>{$r['membertypedesc']}</option>";
    }
  }
  $out .= "<option value=''>All</option>";
  return $out;
}

function opt_propertytype($defval='',$defname='All'){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getCol("proptypecode,proptypedesc","a_propertytype","ASC","proptypetag");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['proptypecode']}'>{$r['proptypedesc']}</option>";
    }
  }
  return $out;
}

function opt_propertyclass($defval='',$defname='All'){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getCol("propclasscode,propclassdesc","a_propertyclass","ASC","propclasscode");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['propclasscode']}'>{$r['propclassdesc']}</option>";
    }
  }
  return $out;
}

function opt_propertyclass2($defval='',$defname='All',$load=""){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getRow("propclasscode,propclassdesc","a_propertyclass","proptypecode",$load,"ASC","propclasscode");
  //$row = getCol("propclasscode,propclassdesc","a_propertyclass","ASC","propclassdesc");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['propclasscode']}'>{$r['propclassdesc']}</option>";
    }
  }
  return $out;
}

function opt_locationcity($defval='',$defname='All'){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getCol("loccitycode,loccitydesc","a_locationcity","ASC","loccitycode");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['loccitycode']}'>{$r['loccitydesc']}</option>";
    }
  }
  return $out;
}

function opt_listingtype($defval='',$defname='All'){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getCol("listtypecode,listtypedesc","a_listingtype","ASC","listtypedesc");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['listtypecode']}'>{$r['listtypedesc']}</option>";
    }
  }
  return $out;
}

function opt_mincontract($defval='',$defname='All'){
  $out = "<option value='$defval' selected>$defname</option>";
  $row = getCol("mincontractcode,mincontractdesc","a_mincontract","ASC","mincontractcode");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['mincontractcode']}'>{$r['mincontractdesc']}</option>";
    }
  }
  return $out;
}

//getRow($selectwhat,$tbname,$fieldtofind,$findwhat,$ASCorDESC="",$ADfield="")
function opt_listingname_listingkey($defval='',$defname='All',$where=''){
  $out = "<option value='$defval' selected>$defname</option>";
  //$row = getCol("listingcode,listingkeys","b_listing","ASC","listingcode");
  $row = getRow("listingcode,listingkeys","b_listing","usercode",$where,"ASC","listingcode");
  if(is_array($row)){
    foreach ($row as $r) {
      $out .= "<option value='{$r['listingkeys']}'>{$r['listingcode']}</option>";
    }
  }
  return $out;
}


function opt_staus(){
  $out = "<option selected>Unverified</option>";
  $out .= "<option>Verified</option>";
  $out .= "<option>Keep</option>";
  $out .= "<option>Lead</option>";
  $out .= "<option>BlackList</option>";
  return $out;
}


$arr_a_accounts = array(
  'tbname' => ['a_accounts'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'usercode' => ['User Code','text',25,'disabled',''],
  'email' => ['Email','text',50,'disabled',''],
  'password' => ['Password','password',25,'disabled',''],
  'membertype' => ['Member Type','select',25,'disabled','',opt_membertype()],
  'memberlname' => ['Last Name','text',25,'disabled',''],
  'memberfname' => ['First Name','text',25,'disabled',''],
  'membercellno' => ['Phone','text',25,'disabled',''],
  'memberstatus' => ['Status','select',25,'','',opt_staus()],
  'membertag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_listingtype = array(
  'tbname' => ['a_listingtype'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'listtypecode' => ['List Type Code','select',25,'disabled','',opt_listingtype()],
  'listtypedesc' => ['Description','textarea',200,'',''],
  'listtypetag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_locationcity = array(
  'tbname' => ['a_locationcity'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'loccitycode' => ['Local Code','select',25,'disabled','',opt_locationcity()],
  'loccitydesc' => ['Description','textarea',200,'',''],
  'loccitytag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_membertype = array(
  'tbname' => ['a_membertype'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'membertypecode' => ['Member Code','select',25,'disabled','',opt_membertype()],
  'membertypedesc' => ['Description','textarea',200,'',''],
  'membertypetag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_mincontract = array(
  'tbname' => ['a_mincontract'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'mincontractcode' => ['Min Contract','select',25,'disabled','',opt_mincontract()],
  'mincontractdesc' => ['Description','textarea',200,'',''],
  'mincontracttag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_propertytype = array(
  'tbname' => ['a_propertytype'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'proptypecode' => ['Property Code','select',25,'disabled','',opt_propertytype()],
  'proptypedesc' => ['Description','textarea',200,'',''],
  'proptypetag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);

$arr_a_propertyclass = array(
  'tbname' => ['a_propertyclass'],
  'recno' => ['RecNo','number',0,'disabled',''],
  'proptypecode' => ['Property Type','select',25,'','',opt_propertytype()],
  'propclasscode' => ['Property Class Code','select',25,'disabled','',opt_propertyclass()],
  'propclassdesc' => ['Description','textarea',200,'',''],
  'propclasstag' => ['Tag','text',25,'',''],
  'END' => ['','','','','']
);



///////////////////////////////////////////////////////////////////////
//AUTO CREATE ELEMENT





function create_sortselect($tablefieldtoshow_arr){
  $option = "<option value='' selected>Any</option>";
  $count = count($tablefieldtoshow_arr);
  for ($i=0; $i < $count; $i++) { 
      $option .= "<option value='{$tablefieldtoshow_arr[$i]['field']}'>{$tablefieldtoshow_arr[$i]['name']}</option>";
  }
  $out = "
    <div class='form-floating m-1'>
          <select class='form-select' id='B_sort' aria-label='Sort'>
            $option
          </select>
          <label for='B_sort'>Sort</label>
     </div>
  ";
  return $out;
}

function youvesearch($searchdata){
  $data = "";
  $sd = explode(",", $searchdata);
  $count = count($sd);
  for ($i=0; $i < $count; $i++) {
    $a = $sd[$i];
    if($a != ""){
      if($i != 0){
        $data .= "
          <span class='mx-0 px-0'>|</span>
        ";
      }
      $data .= "
        <span class='mx-1 px-0 fw-bold'>$a</span>
      ";
    } 
  }
  $out = "
    <div class='d-flex justify-content-between flex-wrap'>
      <div class='text-muted'>
        <span>You searched for:</span>
        $data
      </div>
    </div>
  ";
  return $out;
}

function search_map($searchdata,$trigger,$htmltbname,$sort,$page,$htmlpage,$hasusercode="yes",$publicusercode=""){
  $data = "<span class='fw-bold'>All</span>";
  $data1 = "";
  $dataarr = [];
  $dataarr2 = [];
  $lineuser = "";

  $sd = json_decode($searchdata, true);
  
  $count = count($sd['test'][1]);

  for ($i=0; $i < $count; $i++) {
    $a = $sd['test'][1]['tx_'.$i];
    
    if($a != ""){
      array_push($dataarr,"<span class='fw-bold'>$a</span>");
    }
  }
  if (!empty($dataarr)) {
    $data = implode("<span class='mx-2 px-0'>|</span>",$dataarr);
  }

  if($publicusercode != ""){
    $lineuser = "AND adscode = '$publicusercode'";
  }

  if($hasusercode == "yes"){
    $userdata_arr = get_login_data();
    $sql = "
      SELECT
        b_listing.recno,
        b_listing.loccitycode,
        b_listing.usercode,

        a_locationcity.loccitycode,
        a_locationcity.loccitydesc

      FROM (b_listing
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
      WHERE usercode = '{$userdata_arr['usercode']}'
      GROUP BY a_locationcity.loccitycode
    ";
    $row = selectQ($sql);
    //$row = getCol("loccitycode,loccitydesc","a_locationcity","ASC","loccitydesc");
    if(is_array($row)){
      foreach ($row as $r) {
        $a = $r['loccitycode'];
        $b = $r['loccitydesc'];
        $json = '{"test":[{"nm_0":"'.$sd['test'][0]['nm_0'].'", "nm_1":"'.$sd['test'][0]['nm_1'].'","nm_2":"'.$a.'"},{"tx_0":"'.$sd['test'][1]['tx_0'].'", "tx_1":"'.$sd['test'][1]['tx_1'].'","tx_2":"'.$b.'"}]}';
        $putdis = "
              <span class=''>
                <button onclick='$trigger(`$htmltbname`,`$json`,`$sort`,$page,`$htmlpage`,``,`$publicusercode`)' type='button' class='btn btn-link text-col1 p-0 m-0 mx-1 px-0 fw-bold'>
                    $b
                </button>
              </span>
        ";
        array_push($dataarr2,$putdis);
      }
    }
  }else{

    $sql = "
      SELECT
        b_ads.recno,
        b_ads.listingcode,
        b_ads.status,

        b_listing.listingkeys,
        b_listing.loccitycode,
        
        a_locationcity.loccitycode,
        a_locationcity.loccitydesc

      FROM ((b_ads
        INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)

      WHERE b_ads.status = 'on'
      $lineuser
      GROUP BY a_locationcity.loccitydesc
    ";




    $row = selectQ($sql);
    //$row = getCol("loccitycode,loccitydesc","a_locationcity","ASC","loccitydesc");
    if(is_array($row)){
      foreach ($row as $r) {
        $a = $r['loccitycode'];
        $b = $r['loccitydesc'];

        //data = '{"test":[{"nm_0":"'+a+'","nm_1":"'+b+'","nm_2":"'+c+'","nm_3":"'+d+'","nm_4":"'+e+'"},{"tx_0":"'+tx_a+'","tx_1":"'+tx_b+'","tx_2":"'+tx_c+'","tx_3":"'+tx_d+'","tx_4":"'+tx_e+'"}]}';

        $json = ' {"test":[{"nm_0":"'.$sd['test'][0]['nm_0'].'", "nm_1":"'.$sd['test'][0]['nm_1'].'","nm_2":"'.$sd['test'][0]['nm_2'].'","nm_3":"'.$a.'","nm_4":"'.$sd['test'][0]['nm_4'].'"},
                  {"tx_0":"'.$sd['test'][1]['tx_0'].'", "tx_1":"'.$sd['test'][1]['tx_1'].'","tx_2":"'.$sd['test'][1]['tx_2'].'","tx_3":"'.$b.'","tx_4":"'.$sd['test'][1]['tx_4'].'"}]}';
        $putdis = "
              <span class=''>
                <button onclick='$trigger(`$htmltbname`,`$json`,`$sort`,1,`$htmlpage`,``,`$publicusercode`)' type='button' class='btn btn-link text-col1 p-0 m-0 mx-1 px-0 fw-bold'>
                    $b
                </button>
              </span>
        ";
        array_push($dataarr2,$putdis);
      }
    }
  }

  

  
  

  if (!empty($dataarr2)) {
    $data1 = implode("<span class='mx-2 px-0'>|</span>",$dataarr2);
  }

  $out = "
    <div class='d-flex justify-content-between flex-wrap'>
      <div class='text-muted'>
        <span>You searched for:</span><br>
        $data
      </div>
      <div class='text-muted'>
        <span class=''>Explore other locations:</span><br>
        $data1
      </div>
    </div>
    <br><br>
  ";
  return $out;
}

function search_map_ads($searchdata,$trigger,$htmltbname,$sort,$page,$htmlpage,$hasusercode="yes"){
  $data = "<span class='fw-bold'>All</span>";
  $data1 = "";
  $dataarr = [];
  $dataarr2 = [];

  $sd = json_decode($searchdata, true);
  
  $count = count($sd['test'][1]);

  for ($i=0; $i < $count; $i++) {
    $a = $sd['test'][1]['tx_'.$i];
    
    if($a != ""){
      array_push($dataarr,"<span class='fw-bold'>$a</span>");
    }
  }
  if (!empty($dataarr)) {
    $data = implode("<span class='mx-2 px-0'>|</span>",$dataarr);
  }


  if($hasusercode == "yes"){
    $userdata_arr = get_login_data();
    $sql = "
      SELECT
        b_listing.recno,
        b_listing.loccitycode,
        b_listing.usercode,

        a_locationcity.loccitycode,
        a_locationcity.loccitydesc

      FROM (b_listing
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)

      WHERE usercode = '{$userdata_arr['usercode']}'
      
      GROUP BY a_locationcity.loccitycode
    ";
    $row = selectQ($sql);
    //$row = getCol("loccitycode,loccitydesc","a_locationcity","ASC","loccitydesc");
    if(is_array($row)){
      foreach ($row as $r) {
        $a = $r['loccitycode'];
        $b = $r['loccitydesc'];
        $json = '{"test":[{"nm_0":"'.$sd['test'][0]['nm_0'].'", "nm_1":"'.$sd['test'][0]['nm_1'].'","nm_2":"'.$sd['test'][0]['nm_2'].'", "nm_3":"'.$a.'"},{"tx_0":"'.$sd['test'][1]['tx_0'].'", "tx_1":"'.$sd['test'][1]['tx_1'].'","tx_2":"'.$sd['test'][1]['tx_2'].'", "tx_3":"'.$b.'"}]}';
        $putdis = "
              <span class=''>
                <button onclick='$trigger(`$htmltbname`,`$json`,`$sort`,$page,`$htmlpage`)' type='button' class='btn btn-link text-col1 p-0 m-0 mx-1 px-0 fw-bold'>
                    $b
                </button>
              </span>
        ";
        array_push($dataarr2,$putdis);
      }
    }
  }else{

    $sql = "
      SELECT
        b_ads.recno,
        b_ads.listingcode,
        b_ads.status,

        b_listing.listingkeys,
        b_listing.loccitycode,
        
        a_locationcity.loccitycode,
        a_locationcity.loccitydesc

      FROM ((b_ads
        INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)

      WHERE b_ads.status = 'on'
      GROUP BY a_locationcity.loccitydesc
    ";

    $row = selectQ($sql);
    //$row = getCol("loccitycode,loccitydesc","a_locationcity","ASC","loccitydesc");
    if(is_array($row)){
      foreach ($row as $r) {
        $a = $r['loccitycode'];
        $b = $r['loccitydesc'];

        //data = '{"test":[{"nm_0":"'+a+'","nm_1":"'+b+'","nm_2":"'+c+'","nm_3":"'+d+'","nm_4":"'+e+'"},{"tx_0":"'+tx_a+'","tx_1":"'+tx_b+'","tx_2":"'+tx_c+'","tx_3":"'+tx_d+'","tx_4":"'+tx_e+'"}]}';

        $json = ' {"test":[{"nm_0":"'.$sd['test'][0]['nm_0'].'", "nm_1":"'.$sd['test'][0]['nm_1'].'","nm_2":"'.$sd['test'][0]['nm_2'].'","nm_3":"'.$a.'","nm_4":"'.$sd['test'][0]['nm_4'].'"},
                  {"tx_0":"'.$sd['test'][1]['tx_0'].'", "tx_1":"'.$sd['test'][1]['tx_1'].'","tx_2":"'.$sd['test'][1]['tx_2'].'","tx_3":"'.$b.'","tx_4":"'.$sd['test'][1]['tx_4'].'"}]}';
        $putdis = "
              <span class=''>
                <button onclick='$trigger(`$htmltbname`,`$json`,`$sort`,1,`$htmlpage`)' type='button' class='btn btn-link text-col1 p-0 m-0 mx-1 px-0 fw-bold'>
                    $b
                </button>
              </span>
        ";
        array_push($dataarr2,$putdis);
      }
    }
  }

  

  
  

  if (!empty($dataarr2)) {
    $data1 = implode("<span class='mx-2 px-0'>|</span>",$dataarr2);
  }

  $out = "
    <div class='d-flex justify-content-between flex-wrap'>
      <div class='text-muted'>
        <span>You searched for:</span><br>
        $data
      </div>
      <div class='text-muted'>
        <span class=''>Explore other location:</span><br>
        $data1
      </div>
    </div>
    <br><br>
  ";
  return $out;
}

              




function load_row($outputsearch_box,$htmltbname,$searchdata,$sort,$page,$htmlpage){
  global
  $arrused;
  switch ($htmltbname) {
    case 'a_accounts':
      $searchformnum_dis = 4;
      $searchfields = "membertype,memberlname,memberfname,memberstatus";

      $tablefieldtoshow_arr = [
                array('field' => 'memberlname', 'name' => 'Last Name', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'memberfname', 'name' => 'First Name', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'email', 'name' => 'Email', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'membercellno', 'name' => 'Contact', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'memberstatus', 'name' => 'Status', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'membertype', 'name' => 'Member Type', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"membertype","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"memberlname","","","","forced_enable");
        $searchform .= create_element("B2","m-1",$arrused,"memberfname","","","","forced_enable");
        $searchform .= create_element("B3","m-1",$arrused,"memberstatus");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_membertype':
      $searchformnum_dis = 3;
      $searchfields = "membertypecode,membertypedesc,membertypetag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'membertypecode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'membertypedesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'membertypetag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"membertypecode","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"membertypedesc");
        $searchform .= create_element("B2","m-1",$arrused,"membertypetag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_propertytype':
      $searchformnum_dis = 3;
      $searchfields = "proptypecode,proptypedesc,proptypetag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'proptypecode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'proptypedesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'proptypetag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"proptypecode","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"proptypedesc");
        $searchform .= create_element("B2","m-1",$arrused,"proptypetag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_propertyclass':
      $searchformnum_dis = 4;
      $searchfields = "proptypecode,propclasscode,propclassdesc,propclasstag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'proptypecode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'propclasscode', 'name' => 'Class', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'propclassdesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'propclasstag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"proptypecode");
        $searchform .= create_element("B1","m-1",$arrused,"propclasscode","","","","forced_enable");
        $searchform .= create_element("B2","m-1",$arrused,"propclassdesc");
        $searchform .= create_element("B3","m-1",$arrused,"propclasstag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_locationcity':
      $searchformnum_dis = 3;
      $searchfields = "loccitycode,loccitydesc,loccitytag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'loccitycode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'loccitydesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'loccitytag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"loccitycode","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"loccitydesc");
        $searchform .= create_element("B2","m-1",$arrused,"loccitytag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_listingtype':
      $searchformnum_dis = 3;
      $searchfields = "listtypecode,listtypedesc,listtypetag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'listtypecode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'listtypedesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'listtypetag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"listtypecode","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"listtypedesc");
        $searchform .= create_element("B2","m-1",$arrused,"listtypetag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
    case 'a_mincontract':
      $searchformnum_dis = 3;
      $searchfields = "mincontractcode,mincontractdesc,mincontracttag";

      $tablefieldtoshow_arr = [
                array('field' => 'recno', 'name' => 'RecNo', 'size' => 'width: 10px;', 'css' => 'text-center', 'datacss' => 'text-center'),
                array('field' => 'mincontractcode', 'name' => 'Code', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'mincontractdesc', 'name' => 'Description', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left'),
                array('field' => 'mincontracttag', 'name' => 'Tag', 'size' => '', 'css' => 'text-center', 'datacss' => 'text-left')
              ];
      if($outputsearch_box === 'searchform'){
        $searchform = "";
        $searchform .= create_element("B0","m-1",$arrused,"mincontractcode","","","","forced_enable");
        $searchform .= create_element("B1","m-1",$arrused,"mincontractdesc");
        $searchform .= create_element("B2","m-1",$arrused,"mincontracttag");
        $searchform .= create_sortselect($tablefieldtoshow_arr);
        return $searchform;
        exit();
      }
      if($outputsearch_box === "fieldnum"){
        return $searchformnum_dis;
        exit();
      }
    break;
  }











  //Part 1
  $no_of_records_per_page = cfg::get('numrectoshow');
  $offset = ($page-1) * $no_of_records_per_page;
  $out = "";
  $line = "";
  $line1 = "";
  $data = "";
  $pagenationhtml = "";
  $head = "<th class='text-center' style='width: 120px;'>Action</th>";
  $sf = explode(",", $searchfields);
  $sd = explode(",", $searchdata);
  $count = count($sf);
  $countf = count($tablefieldtoshow_arr);

  $youvesearchhtml = youvesearch($searchdata);

  for ($i=0; $i < $count; $i++) {
      if(isset($sd[$i])){
        $line .= "AND {$sf[$i]} LIKE '%{$sd[$i]}%' ";
      }else{
        $line .= "AND {$sf[$i]} LIKE '%%' ";
      }
  }

  for ($ii=0; $ii < $countf; $ii++) { 
    $head .= "<th onclick='sortTable_one({$ii},`tbsort`)' class='mypointer {$tablefieldtoshow_arr[$ii]['css']}' style='{$tablefieldtoshow_arr[$ii]['size']}'>{$tablefieldtoshow_arr[$ii]['name']}</th>";
  }

  if($sort != ""){
    $line1 = "ORDER BY $sort ASC";
  }
  //SQL
  $sql_count = "
    SELECT COUNT(*) AS rowcount 
    FROM $htmltbname
    WHERE recno LIKE '%%'
    $line
  ";
  $row_count = selectQ($sql_count);
  $pagenationhtml = create_pagination($no_of_records_per_page,$page,$row_count,$htmltbname,$searchdata,$sort,$htmlpage);
  $sql = "
    SELECT *
    FROM $htmltbname
    WHERE recno LIKE '%%'
    $line
    $line1
    LIMIT $offset, $no_of_records_per_page
  ";

  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      

      $data .= "<tr>";
      //edit button
      if($htmltbname == "a_accounts"){
        $disemail = $r['email'];
        $dislink = $r['memberlink'];
        if($dislink == ""){
          $publiclink = "
              <button type='button' class='btn btn-sm btn-outline-secondary border-0' disabled>
                <i class='fa fa-globe'></i>
              </button>
          ";
        }else{
          $publiclink = "
              <button onclick='loadMyURL(`".cfg::get('server_url')."/".cfg::get('linkname')."?".$dislink."`,`blank`)' type='button' class='btn btn-sm btn-outline-secondary border-0'>
                <i class='fa fa-globe'></i>
              </button>
          ";
        }
        $data .= "
          <td class='text-center'>
            $publiclink
            <button onclick='loadMyURL(`$htmlpage={$r['recno']}`)' type='button' class='btn btn-sm btn-outline-secondary border-0'>
              <i class='fa fa-edit'></i>
            </button>
            <button onclick='emaildis(`$disemail`)' type='button' class='btn btn-sm btn-outline-secondary border-0'>
              <i class='fa fa-envelope'></i>
            </button>
          </td>
        ";
      }else{
        $data .= "
          <td class='text-center'>
            <button onclick='loadMyURL(`$htmlpage={$r['recno']}`)' type='button' class='btn btn-sm btn-outline-secondary border-0'>
              <i class='fa fa-edit'></i>
            </button>
          </td>
        ";
      }

      for ($iii=0; $iii < $countf; $iii++) { 
        $td = $r[$tablefieldtoshow_arr[$iii]['field']];
        $data .= "<td class='{$tablefieldtoshow_arr[$iii]['datacss']}' style='{$tablefieldtoshow_arr[$iii]['size']}'>$td</td>";
      }
      $data .= "</tr>";
    }

    $out = "
    $youvesearchhtml
    <table id='tbsort' class='table table-hover'>
      <thead>
        <tr>
          $head
        </tr>
      </thead>
      <tbody>
        $data
      </tbody>
    </table>
    <div class='mt-3 d-flex justify-content-center'>
      $pagenationhtml
    </div>
    ";
  }else{  
    $out = msgoutme("info","Ooops!","Nothing to show...");    
  }
  return $out;
}


function create_pagination($no_of_records_per_page,$page,$row_count,$htmltbname,$searchdata,$sort,$htmlpage,$trigger='getserchval',$publicusercode=""){
  $pagination = "";
    $total_rows = $row_count[0]['rowcount'];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $firstpage = 1;
    $lastpage = $total_pages;
    $pagetoshow = 3;
    $createli = "";

    $first = "";
    if($page == 1){
      $first = "disabled";
    }
    $prev = 1;
    if($page >= 4){
      $prev = $page - 5;
    }
    if($prev <= 0){
      $prev = 1;
    }
    $next = $lastpage;
    if($page <= ($lastpage - 4)){
      $next = $page + 5;
    }
    if($next > $lastpage){
      $next = $lastpage;
    }
    $last = "";
    if($page == $lastpage){
      $last = "disabled";
    }
    for ($i=-2; $i < 3; $i++) {
      $pageno = $page + $i;
      $active = "text-secondary";
      if($pageno == $page){
        $active = "bg-dark text-white";
      }
      if($pageno > 0 && $pageno <= $total_pages){
        $createli .= "<li class='page-item'><button class='page-link $active' onclick='$trigger(`$htmltbname`,`$searchdata`,`$sort`,$pageno,`$htmlpage`,``,`$publicusercode`)'>$pageno</button></li>";
      }
    }
    $pagination .= "
      
      <ul class='pagination'>
        <li class='page-item $first'>
          <button class='page-link text-secondary' onclick='$trigger(`$htmltbname`,`$searchdata`,`$sort`,1,`$htmlpage`,``,`$publicusercode`)'>First</button>
        </li>
        <li class='page-item'>
          <button class='page-link text-secondary' onclick='$trigger(`$htmltbname`,`$searchdata`,`$sort`,$prev,`$htmlpage`,``,`$publicusercode`)'>Prev</button>
        </li>
        
        $createli
        
        <li class='page-item'>
          <button class='page-link text-secondary' onclick='$trigger(`$htmltbname`,`$searchdata`,`$sort`,$next,`$htmlpage`,``,`$publicusercode`)'>Next</button>
        </li>
        <li class='page-item $last'>
          <button class='page-link text-secondary' onclick='$trigger(`$htmltbname`,`$searchdata`,`$sort`,$total_pages,`$htmlpage`,``,`$publicusercode`)'>Last</button>
        </li>
      </ul>
    ";

    if($total_pages == 1){
      $pagination = "";
    }
    return $pagination;
}

function create_pagination2($no_of_records_per_page,$page,$row_count,$publicusercode=""){
  $pagination = "";
    $total_rows = $row_count[0]['rowcount'];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $firstpage = 1;
    $lastpage = $total_pages;
    $pagetoshow = 3;
    $createli = "";

    $first = "";
    if($page == 1){
      $first = "disabled";
    }
    $prev = 1;
    if($page >= 4){
      $prev = $page - 5;
    }
    if($prev <= 0){
      $prev = 1;
    }
    $next = $lastpage;
    if($page <= ($lastpage - 4)){
      $next = $page + 5;
    }
    if($next > $lastpage){
      $next = $lastpage;
    }
    $last = "";
    if($page == $lastpage){
      $last = "disabled";
    }
    for ($i=-2; $i < 3; $i++) {
      $pageno = $page + $i;
      $active = "text-secondary";
      if($pageno == $page){
        $active = "bg-dark text-white";
      }
      if($pageno > 0 && $pageno <= $total_pages){
        $createli .= "<li class='page-item'><button class='page-link $active' onclick='get_userlisting(`$publicusercode`,$pageno)'>$pageno</button></li>";
      }
    }
    $pagination .= "
      
      <ul class='pagination'>
        <li class='page-item $first'>
          <button class='page-link text-secondary' onclick='get_userlisting(`$publicusercode`,1)'>First</button>
        </li>
        <li class='page-item'>
          <button class='page-link text-secondary' onclick='get_userlisting(`$publicusercode`,$prev)'>Prev</button>
        </li>
        
        $createli
        
        <li class='page-item'>
          <button class='page-link text-secondary' onclick='get_userlisting(`$publicusercode`,$next)'>Next</button>
        </li>
        <li class='page-item $last'>
          <button class='page-link text-secondary' onclick='get_userlisting(`$publicusercode`,$total_pages)'>Last</button>
        </li>
      </ul>
    ";

    if($total_pages == 1){
      $pagination = "";
    }
    return $pagination;
}

function load_row_ads($htmltbname,$searchdata,$sort,$page,$htmlpage,$ucode="",$lkey=""){
  $usercode = get_login_data()['usercode'];
  $no_of_records_per_page = cfg::get('numrectoshow');
  $offset = ($page-1) * $no_of_records_per_page;
  $pagenationhtml = "";
  //return $searchdata;
  //Part 1
  $out = "";
  $data = "";
  $line0 = "";
  $line1 = "";
  $line2 = "";
  $line3 = "";
  $line4 = "";
  $special_line = "";
  $search_map_html = "";
  $sd = json_decode($searchdata, true);
  if($searchdata != ""){
    $disval = $sd['test'][0]['nm_0'];
    if($disval != ""){
      $line4 = "AND b_ads.listtypecode = '{$disval}' ";
    }
    $line0 = "AND b_listing.proptypecode LIKE '%{$sd['test'][0]['nm_1']}%' ";
    $line1 = "AND b_listing.propclasscode LIKE '%{$sd['test'][0]['nm_2']}%' ";
    $line2 = "AND b_listing.loccitycode LIKE '%{$sd['test'][0]['nm_3']}%' ";
  }

  if($ucode != "" && $lkey != ""){
    $special_line .= "AND b_listing.usercode = '$ucode' ";
    $special_line .= "AND b_listing.listingkeys = '$lkey' ";
  }
  

  $search_map_html = search_map_ads($searchdata,"getserchval3",$htmltbname,$sort,$page,$htmlpage);

  //sort
  if($sort != ""){
    $line3 = "ORDER BY $sort ASC";
  }

  //count SQL
  $sql_count = "
    SELECT COUNT(*) AS rowcount,
    b_ads.recno,
    b_ads.adscode,
    b_ads.adstitle,
    b_ads.adsdesc,
    b_ads.listingcode,
    b_ads.listtypecode,
    b_ads.price,
    b_ads.securitydeposit, 
    b_ads.mincontract,
    b_ads.downpayment,
    b_ads.paymentterm,
    b_ads.status,
    b_ads.xy,
    b_ads.star_id,
    b_ads.word_tags,

    a_listingtype.listtypecode,
    a_listingtype.listtypedesc,
    
    b_listing.listingcode AS b_listinglistcode,
    b_listing.listingdescription,
    b_listing.buildingname,
    b_listing.propaddress,
    b_listing.proptypecode,
    b_listing.propclasscode,
    b_listing.loccitycode,
    b_listing.usercode,
    b_listing.listingkeys,
    b_listing.listingtag

    FROM (($htmltbname
      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

    WHERE b_ads.adscode = '$usercode'
    $line4
    $line0
    $line1
    $line2
    $special_line
  ";
  $row_count = selectQ($sql_count);
  $pagenationhtml = create_pagination($no_of_records_per_page,$page,$row_count,$htmltbname,$searchdata,$sort,$htmlpage,"getserchval3");


  //Main SQL
  $sql = "
    SELECT 
    b_ads.recno,
    b_ads.adscode,
    b_ads.adstitle,
    b_ads.adsdesc,
    b_ads.listingcode,
    b_ads.listtypecode,
    b_ads.price,
    b_ads.securitydeposit, 
    b_ads.mincontract,
    b_ads.downpayment,
    b_ads.paymentterm,
    b_ads.status,
    b_ads.xy,
    b_ads.star_id,
    b_ads.word_tags,

    a_listingtype.listtypecode,
    a_listingtype.listtypedesc,
    
    b_listing.listingcode AS b_listinglistcode,
    b_listing.listingdescription,
    b_listing.buildingname,
    b_listing.propaddress,
    b_listing.proptypecode,
    b_listing.propclasscode,
    b_listing.loccitycode,
    b_listing.usercode,
    b_listing.listingkeys,
    b_listing.listingtag

    FROM (($htmltbname
      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

    WHERE b_ads.adscode = '$usercode'
    $line4
    $line0
    $line1
    $line2
    $line3
    $special_line
    LIMIT $offset, $no_of_records_per_page
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $Aa = $r['recno'];
      $Ab = $r['adscode'];
      $Ac = $r['adstitle'];
      $Ad = $r['adsdesc'];
      $Ae = $r['listingcode'];
      $Af = $r['listtypecode'];
      $Ag = $r['price'];
      $Ag1 = $r['securitydeposit'];
      $Ag2 = $r['mincontract'];
      $Ag3 = $r['downpayment'];
      $Ah = $r['paymentterm'];
      $Ai = $r['status'];
      $Aj = $r['listtypedesc'];
      $Ajj = $r['xy'];
      $Ajjj = $r['star_id'];
      $Ajjjj = $r['word_tags'];
    
      $Ak = $r['b_listinglistcode'];

      //$b = $r['listingcode'];
      $c = $r['listingdescription'];
      $d = $r['buildingname'];
      $e = $r['propaddress'];
      $f = $r['proptypecode'];
      $g = $r['propclasscode'];
      $h = $r['loccitycode'];
      $i = $r['usercode'];
      $j = $r['listingkeys'];
      $k = $r['listingtag'];

      //image
      $itemspath = cfg::get('itempath')."$i/$j/";
      if (!file_exists($itemspath)) {
          mkdir($itemspath, 0777, true);
      }
      $firstFile = scandir($itemspath);
      if(isset($firstFile[2])){
        if(file_exists($itemspath.$firstFile[2])){
          $imgpath = $itemspath.$firstFile[2];
        }else{
          $imgpath = cfg::get('mainpath')."img/def.png";
        }
      }else{
        $imgpath = cfg::get('mainpath')."img/def.png";
      }

      $active = "<button onclick='onoff_ads($Aa,`off`);' type='button' class='btn btn-sm btn-success rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Show or hide this item to Catalogue'><i class='fa fa-toggle-on'></i></button>";
      if($Ai != "on"){
        $active = "<button onclick='onoff_ads($Aa,`on`);' type='button' class='btn btn-sm btn-danger rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Show or hide this item to Catalogue'><i class='fa fa-toggle-off'></i></button>";
      }

      $active2 = "outline-secondary";
      $enadisena = "";
      if($Ajj != "x"){
        $active2 = "warning text-white";
        $enadisena = "disabled";
      }

      $data .= "
                  <div class='card max300W'>
                    <div>
                      <img src='$imgpath' class='card-img-top rounded imgbox' alt='$Ac' style='filter:brightness(50%);'>
                      <div class='position-absolute bottom-0 start-50 translate-middle-x text-white text-center w-100'>
                        <div class='p-4' style='border: ;'>
                          <button onclick='onoff_stars($Ajjj,`$Aa`);' type='button' class='btn btn-sm btn-$active2 rounded-circle mb-3' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Assign stars to this ads'><i class='fa fa-star'></i></button>

                          <p class='mb-2 text-truncate'>$Ak<br>
                          <small class='text-truncate'>$Aj</small>
                          </p>
                          <div class='mt-0'>
                            <button onclick='viewdetails($Aa)' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='View Details'><i class='fa fa-eye'></i></button>
                            <button onclick='editme_loadval($Aa,`$Af`,`$Ae`,`$Ac`,`$Ad`,`$Ag`,`$Ag1`,`$Ag2`,`$Ag3`,`$Ah`,`$Ajjjj`);' type='button' data-bs-toggle='modal' data-bs-target='#edit_ads' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Edit Item'><i class='fa fa-edit'></i></button>
                            <button onclick='loaditemdel($Aa,`$imgpath`,`$Aj`,`".formatPeso($Ag)."`);' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='modal' data-bs-target='#del_ads' $enadisena><i class='fa fa-trash'></i></button>
                            $active
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
      ";
    }
    $out = "
      <h4>My Ads</h4>
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        $data
      </div>
      <div class='mt-3 d-flex justify-content-center'>
        $pagenationhtml
      </div>
      <br>
      <script type='text/javascript'>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(`[data-bs-toggle='tooltip']`))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
      </script>
    ";
  }else{
    $out = "
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        ".msgoutme("info","Ooops!","Nothing to show...")."
      </div>
      <br>
    ";
  }
  return $out;
}


function load_row_listing($htmltbname,$searchdata,$sort,$page,$htmlpage){
  $usercode = get_login_data()['usercode'];
  $no_of_records_per_page = cfg::get('numrectoshow');
  $offset = ($page-1) * $no_of_records_per_page;
  $pagenationhtml = "";
  //Part 1
  $out = "";
  $data = "";
  $line0 = "";
  $line1 = "";
  $line2 = "";
  $line3 = "";
  $search_map_html = "";
  $sd = json_decode($searchdata, true);
  if($searchdata != ""){
    $line0 = "AND proptypecode LIKE '%{$sd['test'][0]['nm_0']}%' ";
    $line1 = "AND propclasscode LIKE '%{$sd['test'][0]['nm_1']}%' ";
    $line2 = "AND loccitycode LIKE '%{$sd['test'][0]['nm_2']}%' ";
  }
  
  $search_map_html = search_map($searchdata,"getserchval2",$htmltbname,$sort,$page,$htmlpage);

  //sort
  if($sort != ""){
    $line3 = "ORDER BY $sort ASC";
  }


  //count SQL
  $sql_count = "
    SELECT COUNT(*) AS rowcount 
    FROM $htmltbname
    WHERE usercode = '$usercode'
    $line0
    $line1
    $line2
  ";
  $row_count = selectQ($sql_count);
  $pagenationhtml = create_pagination($no_of_records_per_page,$page,$row_count,$htmltbname,$searchdata,$sort,$htmlpage,"getserchval2");


  //Main SQL
  $sql = "
    SELECT *
    FROM $htmltbname
    WHERE usercode = '$usercode'
    $line0
    $line1
    $line2
    $line3
    LIMIT $offset, $no_of_records_per_page
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $a = $r['recno'];
      $b = $r['listingcode'];
      $c = $r['listingdescription'];
      $d = $r['buildingname'];
      $e = $r['propaddress'];
      $f = $r['proptypecode'];
      $g = $r['propclasscode'];
      $h = $r['loccitycode'];
      $i = $r['usercode'];
      $j = $r['listingkeys'];
      $k = $r['listingtag'];

      //image
      $itemspath = cfg::get('itempath')."$i/$j/";
      if (!file_exists($itemspath)) {
          mkdir($itemspath, 0777, true);
      }
      $firstFile = scandir($itemspath);
      if(isset($firstFile[2])){
        if(file_exists($itemspath.$firstFile[2])){
          $imgpath = $itemspath.$firstFile[2];
        }else{
          $imgpath = cfg::get('mainpath')."img/def.png";
        }
      }else{
        $imgpath = cfg::get('mainpath')."img/def.png";
      }
      

      //get how many ads
      $adsno = "";
      $disena = "";
      $disena2 = "";
      $trig = "";
      $disfirstid = 0;
      $getrownum = getRow("recno","b_ads","listingcode",$j);
      if(is_array($getrownum)){
        $adsno = "<span class='badge bg-light text-dark'>Ads ".count($getrownum)."</span>";
        $disfirstid = $getrownum[0]['recno'];
      }else{
        $disena = "";
        $disena2 = "disabled";
        $trig = "loaditemdel($a)";
      }

      $data .= "
            <div class='card max300W'>
              <div>
                <img src='$imgpath' class='card-img-top rounded imgbox' alt='$f'>
                <div class='position-absolute top-0 start-50 translate-middle-x text-white text-end w-100 p-2'>
                  $adsno
                </div>
                <div class='position-absolute bottom-0 start-50 translate-middle-x text-white text-center w-100'>
                  <div class='p-4' style='border: ;'>
                    <p class='mb-2 text-truncate'>$b</p>
                    <div class='mt-0'>
                      <button onclick='viewlistingdetails(`$i`,`$j`)' type='button' class='btn btn-sm btn-outline-light rounded-circle' $disena2 data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='View Details'><i class='fa fa-eye'></i></button>
                      <button onclick='editme_loadval(`$i/$j/`,$a,`$f`,`$g`,`$b`,`$c`,`$h`,`$e`,`$d`);' type='button' data-bs-toggle='modal' data-bs-target='#edit_listing' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Edit Item'><i class='fa fa-edit'></i></button>
                      <button onclick='$trig' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='modal' data-bs-target='#del_listing'><i class='fa fa-trash'></i></button>
                      <button onclick='addads($a,`$j`)' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Add Ads for this Item'><i class='fa fa-plus'></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      ";
    }
    $out = "
      <h4>My Listings</h4>
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        $data
      </div>
      <div class='mt-3 d-flex justify-content-center'>
        $pagenationhtml
      </div>
      <br>
      <script type='text/javascript'>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll(`[data-bs-toggle='tooltip']`))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
      </script>
    ";
  }else{
    $out = "
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        ".msgoutme("info","Ooops!","Nothing to show...")."
      </div>
      <br>
    ";
  }
  return $out;
}

//dashboard and index and publiclink
function load_row_dashboard($htmltbname,$searchdata,$sort,$page,$htmlpage,$sort2="",$publicusercode=""){
  $usercode = get_login_data()['usercode'];
  $no_of_records_per_page = cfg::get('numrectoshow');
  $offset = ($page-1) * $no_of_records_per_page;
  $pagenationhtml = "";
  //Part 1
  $out = "";
  $data = "";
  $lineuser = "";
  $line0 = "";
  $line1 = "";
  $line2 = "";
  $line3 = "";
  $line4 = "";
  $sorting = "";
  $search_map_html = "";
  $sd = json_decode($searchdata, true);
  if($searchdata != ""){
    $line0 = "AND a_listingtype.listtypecode LIKE '%{$sd['test'][0]['nm_0']}%' ";
    $line1 = "AND b_listing.proptypecode LIKE '%{$sd['test'][0]['nm_1']}%' ";
    $line2 = "AND b_listing.propclasscode LIKE '%{$sd['test'][0]['nm_2']}%' ";
    $line3 = "AND b_listing.loccitycode LIKE '%{$sd['test'][0]['nm_3']}%' ";
    $line4 = "AND ( b_ads.adstitle LIKE '%{$sd['test'][0]['nm_4']}%' OR b_ads.adsdesc LIKE '%{$sd['test'][0]['nm_4']}%' )";
  }
  
  if($publicusercode != ""){
    $lineuser = "AND a_accounts.usercode = '$publicusercode'";
  }

  $search_map_html = search_map($searchdata,"getserchval4",$htmltbname,$sort,$page,$htmlpage,"no",$publicusercode);
  $sorting = "ORDER BY a_accounts.priority ASC, b_ads.xy DESC, b_ads.dateinserted DESC";
  

  //count SQL
  $sql_count = "
    SELECT COUNT(*) AS rowcount,
    b_ads.recno,
    b_ads.adscode,
    b_ads.adstitle,
    b_ads.adsdesc,
    b_ads.listingcode,
    b_ads.listtypecode,
    b_ads.price,
    b_ads.securitydeposit, 
    b_ads.mincontract,
    b_ads.downpayment,
    b_ads.paymentterm,
    b_ads.status,
    b_ads.dateinserted,
    b_ads.xy,
   
    
    b_listing.listingdescription,
    b_listing.buildingname,
    b_listing.propaddress,
    b_listing.proptypecode,
    b_listing.propclasscode,
    b_listing.loccitycode,
    b_listing.usercode,
    b_listing.listingkeys,
    b_listing.listingtag,

    a_locationcity.loccitycode,
    a_locationcity.loccitydesc,

    a_listingtype.listtypecode,
    a_listingtype.listtypedesc,

    a_accounts.usercode,
    a_accounts.priority,
    a_accounts.membertype,
    a_accounts.memberlname

    FROM (((($htmltbname
      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
      INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
      INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

    WHERE b_ads.status = 'on'
    $lineuser
    $line0
    $line1
    $line2
    $line3
    $line4
  ";
  $row_count = selectQ($sql_count);
  $pagenationhtml = create_pagination($no_of_records_per_page,$page,$row_count,$htmltbname,$searchdata,$sort,$htmlpage,"getserchval4",$publicusercode);


  //Main SQL
  $sql = "
    SELECT 
    b_ads.recno,
    b_ads.adscode,
    b_ads.adstitle,
    b_ads.adsdesc,
    b_ads.listingcode,
    b_ads.listtypecode,
    b_ads.price,
    b_ads.securitydeposit, 
    b_ads.mincontract,
    b_ads.downpayment,
    b_ads.paymentterm,
    b_ads.status,
    b_ads.dateinserted,
    b_ads.xy,
   
    
    b_listing.listingdescription,
    b_listing.buildingname,
    b_listing.propaddress,
    b_listing.proptypecode,
    b_listing.propclasscode,
    b_listing.loccitycode,
    b_listing.usercode,
    b_listing.listingkeys,
    b_listing.listingtag,

    a_locationcity.loccitycode,
    a_locationcity.loccitydesc,

    a_listingtype.listtypecode,
    a_listingtype.listtypedesc,

    a_accounts.usercode,
    a_accounts.priority,
    a_accounts.membertype,
    a_accounts.memberlname


    FROM (((($htmltbname
      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
      INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
      INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

    WHERE b_ads.status = 'on'
    $lineuser
    $line0
    $line1
    $line2
    $line3
    $line4
    $sorting
    LIMIT $offset, $no_of_records_per_page
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $Aa = $r['recno'];
      $Ab = $r['adscode'];
      $Ac = $r['adstitle'];
      $Ad = $r['adsdesc'];
      $Ae = $r['listingcode'];
      $Af = $r['listtypecode'];
      $Ag = $r['price'];
      $Ag1 = $r['securitydeposit'];
      $Ag2 = $r['mincontract'];
      $Ag3 = $r['downpayment'];
      $Ah = $r['paymentterm'];
      $Ai = $r['status'];
      $PP1 = $r['priority'];
      $PP2 = $r['dateinserted'];
      $PP3 = $r['memberlname'];
      $xy = $r['xy'];

      
    
      //$b = $r['listingcode'];
      $c = $r['listingdescription'];
      $d = $r['buildingname'];
      $e = $r['propaddress'];
      $f = $r['proptypecode'];
      $g = $r['propclasscode'];
      $h = $r['loccitycode'];
      $i = $r['usercode'];
      $j = $r['listingkeys'];
      $k = $r['listingtag'];

      $loc = $r['loccitydesc'];
      $listype = $r['listtypedesc'];

      //image
      $itemspath = cfg::get('itempath')."$i/$j/";
      if (!file_exists($itemspath)) {
          mkdir($itemspath, 0777, true);
      }
      $firstFile = scandir($itemspath);
      if(isset($firstFile[2])){
        if(file_exists($itemspath.$firstFile[2])){
          $imgpath = $itemspath.$firstFile[2];
        }else{
          $imgpath = cfg::get('mainpath')."img/def.png";
        }
      }else{
        $imgpath = cfg::get('mainpath')."img/def.png";
      }
      $data .= create_cataloguebox($Aa,$imgpath,$loc,formatPeso($Ag),$listype,$f);
    }
    $out = "
      <h4>Catalogue Result</h4>
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        $data
      </div>
      <div class='mt-3 d-flex justify-content-center'>
        $pagenationhtml
      </div>
      <br>
    ";
  }else{
    $out = "
      $search_map_html
      <div class='d-flex justify-content-evenly flex-wrap'>
        ".msgoutme("info","Ooops!","Nothing to show...")."
      </div>
      <br>
    ";
  }
  return $out;
}



function load_row_sideads($page){
    $out = "";
    $data = "";
    $pagenationhtml = "";
    $row = getRows("*","c_side_ads","ASC","seenby");
    if(is_array($row)){
      foreach ($row as $r) {
        $a = $r['recno'];
        $b = $r['filename'];
        $c = $r['title'];
        $d = $r['description'];
        $e = $r['seenby'];
        $f = $r['status'];
        $g = $r['ads_url'];
        $path = "../".cfg::get('itempath')."0_side_ads/$b.jpg";
        $data .= create_cataloguebox2($a,$path,$c,$e,$f,$g);
      }
    }
    $out = "
      <h4>List of Side Ads</h4>
      <div class='d-flex justify-content-evenly flex-wrap'>
        $data
      </div>
      <div class='mt-3 d-flex justify-content-center'>
        $pagenationhtml
      </div>
      <br>
    ";
    return $out;
}

function create_cataloguebox3($id,$imgpath,$Altimg,$staractive2,$enadisena,$title,$subtitle){
  return "
    <div class='card max150W mx-1'>
        <div>
          <img src='$imgpath' class='card-img-top rounded max150W' alt='$Altimg' style='filter:brightness(50%);'>
          <div class='position-absolute bottom-0 start-50 translate-middle-x text-white text-center w-100'>
            <div class='p-1' style='border: ;'>
              <p class='mb-2 text-truncate'>$title<br>
              <small class='text-truncate'>$subtitle</small>
              </p>
              <div class='mt-0'>
                <button type='button' class='btn btn-sm btn-$staractive2 rounded-circle'><i class='fa fa-star'></i></button>
                <button onclick='viewdetails($id)' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='View Details'><i class='fa fa-eye'></i></button>
                <button onclick='loaditemdel($id,`$imgpath`,`$title`,`$subtitle`);' type='button' class='btn btn-sm btn-outline-light rounded-circle' data-bs-toggle='modal' data-bs-target='#del_ads' $enadisena><i class='fa fa-trash'></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
  ";
}

function create_cataloguebox2($id,$photo,$title,$seenby,$stat,$adsurl){
  $active = "<button onclick='onoff_side_ads($id,`off`);' type='button' class='btn btn-sm btn-success rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Show or hide this item to Catalogue'><i class='fa fa-toggle-on'></i></button>";
  if($stat != "on"){
    $active = "<button onclick='onoff_side_ads($id,`on`);' type='button' class='btn btn-sm btn-danger rounded-circle' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Show or hide this item to Catalogue'><i class='fa fa-toggle-off'></i></button>";
  }
  $now = time();
  $url = "";
  if($adsurl != ""){
    $url = "loadMyURL(`$adsurl`,`blank`)";
  }
  return "
    <div class='card max300W dispoint'>
      <div>
        <img src='$photo?$now' class='card-img-top rounded imgbox' alt='$title'>
        <div class='position-absolute bottom-0 start-50 translate-middle-x text-white text-center w-100'>
          <div class='p-4' style='border: ;'>
            <p class='mb-0 text-truncate h6'>$title</p>
            <small class='mt-0 text-truncate'>$seenby</small>
            <div class='mt-2'>
              <button onclick='loadMyURL(`admin_ads.php?id=$id`)' type='button' class='btn btn-sm btn-outline-light rounded-circle'><i class='fa fa-edit'></i></button>
              <button onclick='delsideadd($id,`$photo`)' type='button' class='btn btn-sm btn-outline-light rounded-circle'><i class='fa fa-trash'></i></button>
              <button onclick='$url' type='button' class='btn btn-sm btn-outline-light rounded-circle'><i class='fa fa-external-link-alt'></i></button>
              $active
            </div>
          </div>
        </div>
      </div>
    </div>
  ";
}

function create_cataloguebox($id,$photo,$loc,$price,$listype,$propcode="",$test="",$clickable="yes"){
  $now = time();
  $clickme = "loadMyURL(`details.php?id=$id`,`blank`)";
  if($clickable != "yes"){
    $clickme = "";
  }
  return "
  <span>
    <div onclick='$clickme' class='card max300W dispoint'>
      <img src='$photo?$now' class='card-img-top rounded imgbox2' alt='$loc'>
      <div class='position-absolute bottom-0 start-50 translate-middle-x text-white w-100 bg-dark bg-opacity-50 rounded-bottom p-2'>
        <div class='text-end'>$test</div>
        <div class='text-end'>$propcode $listype</div>
        <div class='text-end h4 m-0 p-0 text-truncate'>$price</div>
        <div class='text-end text-truncate my-0 py-0'><i class='fa fa-map-marker-alt me-2'></i>$loc</div>
      </div>
    </div>
  </span>
  ";
}

function create_cataloguebox_small($id,$photo,$loc,$price,$listype,$propcode="",$test="",$clickable="yes"){
  $now = time();
  $clickme = "loadMyURL(`details.php?id=$id`,`blank`)";
  if($clickable != "yes"){
    $clickme = "";
  }
  return "
  <span>
    <div onclick='$clickme' class='card max150W dispoint'>
      <img src='$photo?$now' class='card-img-top rounded max150W' alt='$loc'>
      <div class='position-absolute bottom-0 start-50 translate-middle-x text-white w-100 bg-dark bg-opacity-50 rounded-bottom p-2'>
        <div class='text-end'>$test</div>
        <div class='text-end'>$propcode $listype</div>
        <div class='text-end h4 m-0 p-0 text-truncate'>$price</div>
        <div class='text-end text-truncate my-0 py-0'><i class='fa fa-map-marker-alt me-2'></i>$loc</div>
      </div>
    </div>
  </span>
  ";
}


function load_liasting_and_ads_foradmin($usercode,$page){
    $no_of_records_per_page = cfg::get('numrectoshow');
    $offset = ($page-1) * $no_of_records_per_page;
    $pagenationhtml = "";
    $out = "";
    $data = "";


    $sql_count = "
      SELECT COUNT(*) AS rowcount,
      b_listing.recno,
      b_listing.listingcode,
      b_listing.listingdescription,
      b_listing.buildingname,
      b_listing.propaddress,
      b_listing.proptypecode,
      b_listing.propclasscode,
      b_listing.loccitycode,
      b_listing.usercode,
      b_listing.listingkeys,
      b_listing.listingtag,

      a_locationcity.loccitycode,
      a_locationcity.loccitydesc,

      a_accounts.usercode,
      a_accounts.priority,
      a_accounts.membertype,
      a_accounts.memberlname

      FROM ((b_listing
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
        INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
      WHERE a_accounts.usercode = '$usercode'
    ";
    $sql = "
      SELECT 
      b_listing.recno,
      b_listing.listingcode,
      b_listing.listingdescription,
      b_listing.buildingname,
      b_listing.propaddress,
      b_listing.proptypecode,
      b_listing.propclasscode,
      b_listing.loccitycode,
      b_listing.usercode,
      b_listing.listingkeys,
      b_listing.listingtag,

      a_locationcity.loccitycode,
      a_locationcity.loccitydesc,

      a_accounts.usercode,
      a_accounts.priority,
      a_accounts.membertype,
      a_accounts.memberlname

      FROM ((b_listing
        INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
        INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
      WHERE a_accounts.usercode = '$usercode'
      LIMIT $offset, $no_of_records_per_page
    ";

    $row_count = selectQ($sql_count);
    $pagenationhtml = create_pagination2($no_of_records_per_page,$page,$row_count,$usercode);
    //create_pagination2($no_of_records_per_page,$page,$row_count);
    $row = selectQ($sql);
    if(is_array($row)){
      foreach ($row as $r) {

        $a = $r['recno'];
        $b = $r['listingcode'];
        $c = $r['listingdescription'];
        $d = $r['buildingname'];
        $e = $r['propaddress'];
        $f = $r['proptypecode'];
        $g = $r['propclasscode'];
        $h = $r['loccitycode'];
        $i = $r['usercode'];
        $j = $r['listingkeys'];
        $k = $r['listingtag'];

        $loc = $r['loccitydesc'];

        //image
        $itemspath = cfg::get('itempath')."$i/$j/";
        if (!file_exists($itemspath)) {
            mkdir($itemspath, 0777, true);
        }
        $firstFile = scandir($itemspath);
        if(isset($firstFile[2])){
          if(file_exists($itemspath.$firstFile[2])){
            $imgpath = $itemspath.$firstFile[2];
          }else{
            $imgpath = cfg::get('mainpath')."img/def.png";
          }
        }else{
          $imgpath = cfg::get('mainpath')."img/def.png";
        }

        

        $data .= "
              <tr>
                <td>
                    <div class='w-100 d-flex justify-content-center' style='overflow: hidden; overflow-x: auto;'>
                      ".create_cataloguebox_small($a,$imgpath,$loc,"",$d,$b,$f,"no")."
                    </div>
                </td>
                <td>
                    <div class='w-100 d-flex' style='overflow: hidden; overflow-x: auto;'>
                      ".get_all_ads_bylisting($i,$j)."
                    </div>
                </td>
              </tr>
        ";
      }
      $out = "
              <table class='table table-striped'>
                <thead>
                  <tr>
                    <th style='width: 250px;'>Listing</th>
                    <th>Ads Created</th>
                  </tr>
                </thead>
                <tbody>
                  $data
                </tbody>
              </table>
              <div class='mt-3 d-flex justify-content-center'>
                $pagenationhtml
              </div>
      ";
    }else{
      $out = msgoutme("info","Ooops!","No Listing created...");
    }
    return $out;
}


function get_all_ads_bylisting($usercode,$listingkey){
  $out = "";
  $data = "";
  //Main SQL
  $sql = "
    SELECT 
    b_ads.recno,
    b_ads.adscode,
    b_ads.adstitle,
    b_ads.adsdesc,
    b_ads.listingcode,
    b_ads.listtypecode,
    b_ads.price,
    b_ads.securitydeposit, 
    b_ads.mincontract,
    b_ads.downpayment,
    b_ads.paymentterm,
    b_ads.status,
    b_ads.dateinserted,
    b_ads.xy,
   
    
    b_listing.listingdescription,
    b_listing.buildingname,
    b_listing.propaddress,
    b_listing.proptypecode,
    b_listing.propclasscode,
    b_listing.loccitycode,
    b_listing.usercode,
    b_listing.listingkeys,
    b_listing.listingtag,

    a_locationcity.loccitycode,
    a_locationcity.loccitydesc,

    a_listingtype.listtypecode,
    a_listingtype.listtypedesc,

    a_accounts.usercode,
    a_accounts.priority,
    a_accounts.membertype,
    a_accounts.memberlname


    FROM ((((b_ads
      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
      INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
      INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

    WHERE b_ads.status = 'on'
    AND b_ads.adscode = '$usercode'
    AND b_ads.listingcode = '$listingkey'
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $Aa = $r['recno'];
      $Ab = $r['adscode'];
      $Ac = $r['adstitle'];
      $Ad = $r['adsdesc'];
      $Ae = $r['listingcode'];
      $Af = $r['listtypecode'];
      $Ag = $r['price'];
      $Ag1 = $r['securitydeposit'];
      $Ag2 = $r['mincontract'];
      $Ag3 = $r['downpayment'];
      $Ah = $r['paymentterm'];
      $Ai = $r['status'];
      $PP1 = $r['priority'];
      $PP2 = $r['dateinserted'];
      $PP3 = $r['memberlname'];
      $xy = $r['xy'];

      
    
      //$b = $r['listingcode'];
      $c = $r['listingdescription'];
      $d = $r['buildingname'];
      $e = $r['propaddress'];
      $f = $r['proptypecode'];
      $g = $r['propclasscode'];
      $h = $r['loccitycode'];
      $i = $r['usercode'];
      $j = $r['listingkeys'];
      $k = $r['listingtag'];

      $loc = $r['loccitydesc'];
      $listype = $r['listtypedesc'];

      //image
      $itemspath = cfg::get('itempath')."$i/$j/";
      if (!file_exists($itemspath)) {
          mkdir($itemspath, 0777, true);
      }
      $firstFile = scandir($itemspath);
      if(isset($firstFile[2])){
        if(file_exists($itemspath.$firstFile[2])){
          $imgpath = $itemspath.$firstFile[2];
        }else{
          $imgpath = cfg::get('mainpath')."img/def.png";
        }
      }else{
        $imgpath = cfg::get('mainpath')."img/def.png";
      }
      
      $active2 = "outline-secondary";
      $enadisena = "";
      if($xy != "x"){
        $active2 = "warning text-white";
        $enadisena = "disabled";
      }
      $data .= create_cataloguebox3($Aa,$imgpath,$Ac,$active2,$enadisena,$Af,formatPeso($Ag));
      //create_cataloguebox($Aa,$imgpath,$loc,formatPeso($Ag),$listype,$f);
    }
    $out = $data;
  }else{
    $out = "";
  }
  return $out;
}

function checkiflog($data,$path=''){
  if(!$data) {
    header('Location: '.$path.'logout.php');
  }
}

function get_login_data(){
  $arr = 0;
  if( isset($_SESSION["usercode"]) && 
    isset($_SESSION["email"]) && 
    isset($_SESSION["membertype"]) && 
    isset($_SESSION["memberlname"]) && 
    isset($_SESSION["memberfname"]) && 
    isset($_SESSION["membercellno"]) && 
    isset($_SESSION["memberstatus"]) && 
    isset($_SESSION["membertag"]) ){

    $arr = array('usercode' => $_SESSION["usercode"], 
           'email' => $_SESSION["email"], 
           'membertype' => $_SESSION["membertype"], 
           'memberlname' => $_SESSION["memberlname"], 
           'memberfname' => $_SESSION["memberfname"], 
           'membercellno' => $_SESSION["membercellno"], 
           'memberstatus' => $_SESSION["memberstatus"],
           'membertag' => $_SESSION["membertag"]
         );
  }
  return $arr;
}

function get_login_data_admin(){
  $arr = 0;
  if( isset($_SESSION["username"]) && 
    isset($_SESSION["usertype"]) ){

    $arr = array('username' => $_SESSION["username"], 
           'usertype' => $_SESSION["usertype"]
         );
  }
  return $arr;
}

function reget_ses_data(){
  $userdata_arr = get_login_data();
  $row = getRow("*","a_accounts","usercode",$userdata_arr['usercode']);
  if(is_array($row)){
    $db_usercode = $row[0]['usercode'];
    $db_email = $row[0]['email'];
    $db_password = $row[0]['password'];
    $db_membertype = $row[0]['membertype'];
    $db_memberlname = $row[0]['memberlname'];
    $db_memberfname = $row[0]['memberfname'];
    $db_membercellno = $row[0]['membercellno'];
    $db_memberstatus = $row[0]['memberstatus'];
    $db_membertag = $row[0]['membertag'];

    $_SESSION["usercode"] = $db_usercode;
    $_SESSION["email"] = $db_email;
    $_SESSION["membertype"] = $db_membertype;
    $_SESSION["memberlname"] = $db_memberlname;
    $_SESSION["memberfname"] = $db_memberfname;
    $_SESSION["membercellno"] = $db_membercellno;
    $_SESSION["memberstatus"] = $db_memberstatus;
    $_SESSION["membertag"] = $db_membertag;
  }
}


function ifhasemailverificationpending(){
  if( isset($_SESSION["email_data"]) && 
    isset($_SESSION["email_subj"]) &&
    isset($_SESSION["email_msgs"]) &&
    isset($_SESSION["email_head"])){
    return 1;
  }else{
    return 0;
  }
}

function getallmemberslist($findwaht){
  $out = "";
  $sql = "
    SELECT *
    FROM a_accounts
    WHERE memberstatus = 'Verified'
    AND ( memberlname LIKE '%$findwaht%'
    OR memberfname LIKE '%$findwaht%'
    OR usercode LIKE '%$findwaht%' )
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $a = $r['recno'];
      $b = $r['usercode'];
      $c = $r['priority'];
      $d = $r['stars'];//to be change
      $e = $r['membertype'];
      $f = $r['memberlname'].", ".$r['memberfname'];
      if($e == "Gold"){
        $color = "warning";
      }else if($e == "Silver"){
        $color = "secondary";
      }else{
        $color = "primary";
      }
      $days = recalculate_daysbetweenexpiration($a,$b);
      $out .= "
        <li class='list-group-item list-group-item-action ifselected'>
          <div class='d-flex'>
            <div onclick='selected_name(`$b`,`$f`,`$c`)' class='align-self-center flex-grow-1 mypointer'><i class='fa fa-chevron-right'></i> $f</div>
            <div class='align-self-center text-$color'><i class='fa fa-gem'></i> $e $days days left</div>
            <div class='align-self-center ms-3 text-secondary'><i class='fa fa-star'></i> $d</div>
            <div class='align-self-center ms-3 text-secondary'><i class='fa fa-ad'></i> $c</div>
            <button onclick='selected_history(`$b`,`$f`)' data-bs-toggle='modal' data-bs-target='#history' type='button' class='align-self-center ms-3 btn btn-sm border-0 btn-outline-secondary'><i class='fa fa-history'></i></button>
          </div>
        </li>
      ";
    }
  }
  return $out;
}

function loadhistory($ucode,$fname){
  $out = "";
  $data = "";
  $sql = "
    SELECT *
    FROM c_purchase_history
    WHERE usercode = '$ucode'
    ORDER BY dateinserted DESC
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    foreach ($row as $r) {
      $a = $r['recno'];
      $b = $r['usercode'];
      $c = $r['datepurchase'];
      $d = $r['memtype_or_star'];
      $e = $r['effective_date_start'];
      $f = $r['effective_date_end'];
      $g = $r['dateinserted'];
      $memtype = getOne("membertype","a_accounts","usercode",$b);
      $stars = getOne("stars","a_accounts","usercode",$b);
      $daysleft = recalculate_daysbetweenexpiration("none",$b);
      $today = date_create()->format('Y-m-d');
      $days = calculateexpiration($today,$f);
      $data .= "
        <tr>
          <td>$d</td>
          <td>$e</td>
          <td>$f</td>
          <td>$days</td>
        </tr>
      "; 
    }
    $out .= "
        <h4>$fname</h4>
        <small><i class='fa fa-gem'></i> $memtype $daysleft days <i class='fa fa-star'></i> $stars</small>
        <br><br>
        <table class='table table-sm'>
          <thead>
            <tr>
              <th scope='col'>Purchased Items</th>
              <th scope='col'>Date Purchased</th>
              <th scope='col'>Date End</th>
              <th scope='col'>Days left</th>
            </tr>
          </thead>
          <tbody>
            $data
          </tbody>
        </table>
    ";
  }
  return $out;
}

function record_expiration($usercode,$priority,$memtype,$star){
  //one month duration for membership and 1 star
  $memtype_duration = 31;//days
  $star_duration = 31;//days

  


  $out = "";

  if($priority != ""){
      updateDT("a_accounts","priority = '{$priority}'","usercode",$usercode);
      $out .= msgoutme("info","Good!","Ads priority updated for this user $usercode account...");
  }

  if($memtype != ""){
    //check if has ongoing membership
    $sql = "
      SELECT *
      FROM c_expiration_checker
      WHERE usercode = '$usercode'
      AND status = 'ongoing'
      AND membertype_or_star = 'memtype'
    ";
    $row = selectQ($sql);
    if(is_array($row)){
      //if yes update its endate
      $a = $row[0]['recno'];
      $b = $row[0]['B_ending'];
      $c = $row[0]['thisvalue'];
      if($c == $memtype){
        $enddate_memtype = date('Y-m-d', strtotime($b. " + $memtype_duration days"));
        updateDT("c_expiration_checker","B_ending = '{$enddate_memtype}'","recno",$a);
        $out .= msgoutme("info","Good!","Expiring date has been extended...");
      }else{
        $out .= msgoutme("danger","Ooops!","Ongoing membership has been detected...");
      }
    }else{
      //if no insert
      $startingdate = date_create()->format('Y-m-d');
      $enddate_memtype = date('Y-m-d', strtotime($startingdate. " + $memtype_duration days"));

      $fields = "(usercode,A_starting,B_ending,membertype_or_star,thisvalue)";
      $values = "('$usercode','$startingdate','$enddate_memtype','memtype','$memtype')";

      insertDT("c_expiration_checker",$fields,$values);
      updateDT("a_accounts","membertype = '{$memtype}'","usercode",$usercode);
      $out .= msgoutme("info","Good!","Membership change to $memtype...");
    }
    //record history
    $sdate = date_create()->format('Y-m-d');
    $edate = date('Y-m-d', strtotime($sdate. " + $memtype_duration days"));
    $fields = "(usercode,datepurchase,memtype_or_star,effective_date_start,effective_date_end)";
    $values = "('$usercode','$sdate','$memtype $memtype_duration days','$sdate','$edate')";
    insertDT("c_purchase_history",$fields,$values);
  }

  if($star != ""){
    for ($i=0; $i < $star; $i++) { 
      $startingdate2 = date_create()->format('Y-m-d');
      $enddate_star2 = date('Y-m-d', strtotime($startingdate2. " + $star_duration days"));

      $fields2 = "(usercode,A_starting,B_ending,membertype_or_star,thisvalue)";
      $values2 = "('$usercode','$startingdate2','$enddate_star2','star',1)";
      insertDT("c_expiration_checker",$fields2,$values2);
    }

      //record history
      $fields = "(usercode,datepurchase,memtype_or_star,effective_date_start,effective_date_end)";
      $values = "('$usercode','$startingdate2','$star Star/s $star_duration days','$startingdate2','$enddate_star2')";
      insertDT("c_purchase_history",$fields,$values);

      recalculate_stars($usercode);
      $out .= msgoutme("info","Good!","$star added to this $usercode account...");
  }

 

  return $out;
}

function recalculate_stars($usercode){
  $sql = "
    SELECT SUM(thisvalue) AS totalstars
    FROM c_expiration_checker
    WHERE usercode = '$usercode'
    AND status = 'ongoing'
    AND membertype_or_star = 'star'
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    $a = $row[0]['totalstars'];
    updateDT("a_accounts","stars = {$a}","usercode",$usercode);
  }
}

function recalculate_daysbetweenexpiration($recno,$usercode){
  //$recno // not in use
  $today = date_create()->format('Y-m-d');
  $sql = "
    SELECT *
    FROM c_expiration_checker
    WHERE usercode = '$usercode'
    AND status = 'ongoing'
    AND membertype_or_star = 'memtype'
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    $a = $row[0]['recno'];
    $b = $today;
    $c = $row[0]['B_ending'];
    return calculateexpiration($b,$c);
  }else{
    return 0;
  }
}

function calculateexpiration($s,$e){
    $start = strtotime($s);
    $end = strtotime($e);
    return ceil(($end - $start) / 86400);
}

function load_row_news($page,$htmlpage,$foradmin='yes'){
  if($foradmin == "yes"){
    $no_of_records_per_page = cfg::get('numrectoshow');
  }else{
    $no_of_records_per_page = 5;
  }
  
  $offset = ($page-1) * $no_of_records_per_page;
  $pagenationhtml = "";
  $data = "";
  $out = "";
  $sql_count = "
    SELECT COUNT(*) AS rowcount
    FROM c_news
  ";
  $sql = "
    SELECT *
    FROM c_news
    ORDER BY dateinserted DESC
    LIMIT $offset, $no_of_records_per_page
  ";
  $row_count = selectQ($sql_count);
  $pagenationhtml = create_pagination($no_of_records_per_page,$page,$row_count,"c_news","","",$htmlpage,"loadnews");



  if($foradmin == "yes"){

    //admin
    $row = selectQ($sql);
    if(is_array($row)){
      foreach ($row as $r) {
        $Aa = $r['recno'];
        $Ab = $r['title'];
        $Ac = $r['description'];
        $data .= "
            <tr>
              <td class='text-center'>
                <button onclick='loadMyURL(`$htmlpage?id={$r['recno']}`)' type='button' class='btn btn-sm btn-outline-secondary border-0'>
                  <i class='fa fa-edit'></i>
                </button>
              </td>
              <td class=''>
                $Ab
              </td>
              <td class=''>
                $Ac
              </td>
            </tr>
        ";
        
      }
      $out = "
            <h4>News</h4>
            <table id='tbsort' class='table table-hover p-3'>
              <thead>
                <tr>
                  <th class='text-center' style='width: 50px;'>Action</th>
                  <th class='' style='width: ;'>Title</th>
                  <th class='' style='width: ;'>Description</th>
                </tr>
              </thead>
              <tbody>
                $data
              </tbody>
            </table>
            <div class='mt-3 d-flex justify-content-center'>
              $pagenationhtml
            </div>
      ";
    }else{
      $out = "
        <h4>Announcements</h4>
        <div class='d-flex justify-content-evenly flex-wrap'>
          ".msgoutme("info","Ooops!","Nothing to show...")."
        </div>
        <br>
      ";
    }

  }else{

    //user
    $row = selectQ($sql);
    if(is_array($row)){
      foreach ($row as $r) {
        $Aa = $r['recno'];
        $Ab = $r['title'];
        $Ac = $r['description'];
        $Ad = timeAgo($r['dateinserted']);
        $out .= "
            <div class='alert alert-light border' role='alert'>
              <b class='fs-5'>$Ab</b>
              <br>
              $Ac
              <br><br>
              <small>Administrator posted $Ad</small>
            </div>
        ";
      }
      $out .= "<div class='mt-3 d-flex justify-content-center'>
                $pagenationhtml
              </div>";
    }else{
      $out = msgoutme("info","Ooops!","Nothing to show...");
    }

  }
  return $out;
}



function getnumberof($tbname,$field,$username,$andstament=""){
  $total = 0;
  $sql = "
    SELECT COUNT(*) AS countme
    FROM $tbname
    WHERE $field = '$username'
    $andstament
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    $total = $row[0]['countme'];
  }
  return $total;
}


function loadcurrentstars($usercode){
  $out = "";
  $availablestar = 0;
  $counter = 0;
  $count = 0;
  $sql = "
    SELECT *
    FROM c_expiration_checker
    WHERE usercode = '$usercode'
    AND status = 'ongoing'
    AND membertype_or_star = 'star'
    ORDER BY target_ads_id ASC
  ";
  $row = selectQ($sql);
  if(is_array($row)){
    $count = count($row);
    $counter = 0;
    foreach ($row as $r) {
      $a = $r['recno'];
      $b = $r['target_ads_id'];
      if($b == 0){
        $out .= "<i class='align-self-center text-warning fa fa-2x fa-star mx-2'></i>";
        $availablestar = $a;
        $counter += 1;
      }else{
        $out .= "<i class='align-self-center text-muted fa fa-2x fa-star mx-2'></i>";
      }
    }
  }
  $out = "<div class='align-self-center'>$counter/$count</div>".$out;
  $out .= rundisfunction("lateststrarid($availablestar);");
  return $out;
}

function bindstrarandadsid($usercode,$strid,$adsid){
  //star c_expiration_checker tb
  updateDT("c_expiration_checker","target_ads_id = {$adsid}","recno",$strid);
  //ads b_ads tb
  updateDT("b_ads","star_id = {$strid}, xy = 'y'","recno",$adsid);
}


function unbindstrarandadsid($usercode,$adsid){
  $starid = getOne("star_id","b_ads","recno",$adsid);
  updateDT("b_ads","star_id = 0, xy = 'x'","recno",$adsid);
  updateDT("c_expiration_checker","target_ads_id = 0","recno",$starid);
}


function expirationcehcker($usercode=''){
  $error = 0;
  $numberofedited = 0;
  $today = date_create()->format('Y-m-d');
  $line = "";
  $line2 = "";
  if($usercode != ""){
    $line = "AND usercode = '$usercode'";
    $line2 = "WHERE usercode = '$usercode'";
  }


  //check if stars are expired if expired change to defalt
  $sqlstars = "
    SELECT *
    FROM c_expiration_checker
    WHERE status = 'ongoing'
    $line
    AND membertype_or_star = 'star'
  ";
  $row = selectQ($sqlstars);
  if(is_array($row)){
    foreach ($row as $r) {
      $starid = $r['recno'];
      $adsid = $r['target_ads_id'];
      $usercode = $r['usercode'];
      $s = $today;
      $e = $r['B_ending'];
      $expire = calculateexpiration($s,$e);
      if($expire <= 0){
        updateDT("b_ads","star_id = 0, xy = 'x'","recno",$adsid);
        $numberofedited += 1;
        updateDT("c_expiration_checker","status = 'expired', target_ads_id = 0","recno",$starid);
        $numberofedited += 1;
      }
    }
  }

  //update accounts star apply new calculation
  $sqlstarsrecalculate = "
    SELECT *
    FROM a_accounts
    $line2
  ";
  $row = selectQ($sqlstarsrecalculate);
  if(is_array($row)){
    foreach ($row as $r) {
      $a = $r['recno'];
      $usercode = $r['usercode'];
      recalculate_stars($usercode);
    }
  }


  //chek if membership expired if expired change to Blue
  $sqlmemtype = "
    SELECT *
    FROM c_expiration_checker
    WHERE status = 'ongoing'
    $line
    AND membertype_or_star = 'memtype'
  ";

  $row = selectQ($sqlmemtype);
  if(is_array($row)){
    foreach ($row as $r) {
      $id = $r['recno'];
      $ucode = $r['usercode'];
      $s = $today;
      $e = $r['B_ending'];
      $expire = calculateexpiration($s,$e);
      if($expire <= 0){
        updateDT("c_expiration_checker","status = 'expired', thisvalue = 'Blue'","recno",$id);
        $numberofedited += 1;
        updateDT("a_accounts","membertype = 'Blue'","usercode",$ucode);
        $numberofedited += 1;
      }
    }
  }
  return msgoutme("info","Good!","Expiration checked $numberofedited updated records...");
}



function get_dummy_list(){
  $out = "";

  $str0 = "";
  $str1 = "";
  $str2 = "";
  $str3 = "";

  $val0 = "";
  $val1 = "";
  $val2 = "";
  $val3 = "";

  $arr_a = [ " - "," ","'","&","<" ];
  $arr_b = [ "-","-","","and","greater-than" ];

  $sql0 = "
    SELECT *
    FROM a_listingtype
  ";
  $row0 = selectQ($sql0);
  if(is_array($row0)){
    foreach ($row0 as $r0) {
      //0level
      $val0 = $r0['listtypecode'];
      $str0 = str_replace($arr_a,$arr_b,$r0['listtypecode']);
      if (!file_exists($str0)) { mkdir($str0); }

      $sql1 = "
        SELECT *
        FROM a_propertytype
      ";
      $row1 = selectQ($sql1);
      if(is_array($row1)){
        foreach ($row1 as $r1) {

          //1level
          $val1 = $r1['proptypecode'];
          $str1 = str_replace($arr_a,$arr_b,$r1['proptypecode']);
          if (!file_exists("$str0/$str1")) { mkdir("$str0/$str1"); }

          $sql2 = "
            SELECT *
            FROM a_propertyclass
            WHERE proptypecode = '{$r1['proptypecode']}'
          ";
          $row2 = selectQ($sql2);
          if(is_array($row2)){
            foreach ($row2 as $r2) {

              //2level
              $val2 = $r2['propclasscode'];
              $str2 = str_replace($arr_a,$arr_b,$r2['propclassdesc']);
              if (!file_exists("$str0/$str1/$str2")) { mkdir("$str0/$str1/$str2"); }

              $sql3 = "
                SELECT *
                FROM a_locationcity
              ";
              $row3 = selectQ($sql3);
              if(is_array($row3)){
                foreach ($row3 as $r3) {
                  //3level
                  $val3 = $r3['loccitycode'];
                  $str3 = str_replace($arr_a,$arr_b,$r3['loccitycode']);
                  if (!file_exists("$str0/$str1/$str2/$str3")) { mkdir("$str0/$str1/$str2/$str3"); }

                  //folder link
                  $finlink = "$str0/$str1/$str2/$str3/";
                  creatlinkfile($finlink,$val0,$val1,$val2,$val3);
                }
              }
            }
          }
        }
      }
    }
  }
  return msgoutme("info","Good!","Dummy folders created..");
}




function creatlinkfile($fulllink,$str0,$str1,$str2,$str3){
$url = cfg::get('base_url');
$file = fopen($fulllink."index.html","w");
$writ=<<<EOD
<!DOCTYPE html>
<html>
<head>
  
</head>
<body>
</body>
  <script type="text/javascript">
    window.addEventListener("load", function(){
      sessionStorage.setItem('search_a', '$str0');
      sessionStorage.setItem('search_b', '$str1');
      sessionStorage.setItem('search_c', '$str2');
      sessionStorage.setItem('search_d', '$str3');
      sessionStorage.setItem('search_e', '');
      window.location.href = '$url/index.php';
    });
  </script>
</html>
EOD;
fwrite($file,$writ);
fclose($file);
}


?>