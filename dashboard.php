<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data();
checkiflog($userdata_arr);


$htmltbname = "b_ads";
$htmlpage = "dashboard.php";

$usernamecurr = $userdata_arr['usercode'];
$fname = $userdata_arr['memberfname']." ".$userdata_arr['memberlname'];
$email = $userdata_arr['email'];
$phone = $userdata_arr['membercellno'];
$memtype = getOne("membertype","a_accounts","usercode",$usernamecurr);
$stars = getOne("stars","a_accounts","usercode",$usernamecurr);
$listingcount = getnumberof("b_listing","usercode",$usernamecurr);
$adscount = getnumberof("b_ads","adscode",$usernamecurr,"AND status = 'on'");
$adscountoff = getnumberof("b_ads","adscode",$usernamecurr,"AND status = 'off'");
$inquirymsg = getnumberof("b_clients","agentcode",$usernamecurr,"AND showhide = 'show'");
$inquirymsgoff = getnumberof("b_clients","agentcode",$usernamecurr,"AND showhide = 'hide'");
//$feeds = load_row_news(1,"dashboard.php","no");


//picture
$ID_picture = "data/img/defimg.jpg";
$path = "items/$usernamecurr/id.jpg";
if(file_exists($path)){
	$ID_picture = $path;
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('DashboardHTML');?>
	<?php echo head_tag($mainpath);?>
</head>
<body class="backcolor">
	<?php echo loader_tag();?>
	<?php echo topnav_tag();?>
	<div class="offsettop"></div>
	<!-- Main -->
	<main class="maxw1080 m-auto">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-9">
					<!-- Dashboard -->
					<div class="allpost p-0" style="display: ;">
						<!-- Stat -->
						<div class="card mb-4">
							<div id="" class="card-body">
								<div class="row m-2">
									<div class="col-lg-4 mb-3 p-1">
										<!-- Profile -->
										<div onclick="loadMyURL('profile.php')" class="bg-col1 text-white rounded h-100 mypointer">
									  		<div class="row g-0">
											  <div class="col-4 text-center p-4">
											  	<img src="<?php echo $ID_picture;?>" class="img-fluid rounded-circle" alt="id"><br>
											  	<small class=""><b><i class="fa fa-gem"></i> <?php echo $memtype;?></b></small>
											  </div>
											  <div class="col-8">
											  	<div class="py-4">
											  		<span class="text-truncate fs-3 p-0 m-0"><?php echo $fname;?></span><br>
											  		<small class="text-truncate p-0 m-0"><?php echo $email;?></small><br>
											  		<small class="text-truncate p-0 m-0">Phone: <?php echo $phone;?></small>
											  		<small class="text-truncate p-0 m-0">Viber: <?php echo $phone;?></small>
											  	</div>
											  </div>
											</div>
										</div>
									</div>
									<div class="col-lg-2 mb-3 p-1">
										<!-- Star -->
								  		<div onclick="loadMyURL('ads.php')" class="bg-col1 text-white rounded h-100 text-center p-4 mypointer">
											<i class="fa fa-3x fa-star"></i><br>
											<small class="">Star</small><br>
											<span><b><?php echo $stars;?></b></span>
										</div>
									</div>
									<div class="col-lg-2 mb-3 p-1">
										<!-- Listing -->
								  		<div onclick="loadMyURL('listing.php')" class="bg-col1 text-white rounded h-100 text-center p-4 mypointer">
											<i class="fa fa-3x fa-clipboard-list"></i><br>
											<small class="">Listing</small><br>
											<span><b><?php echo $listingcount;?></b></span>
										</div>
									</div>
									<div class="col-lg-2 mb-3 p-1">
										<!-- Ads -->
										<div onclick="loadMyURL('ads.php')" class="bg-col1 text-white rounded h-100 text-center p-4 mypointer">
											<i class="fa fa-3x fa-newspaper"></i><br>
											<small class="">Ads</small><br>
											<span>On: <b><?php echo $adscount;?></b> Off: <b><?php echo $adscountoff;?></b></span>
										</div>
									</div>
									<div class="col-lg-2 mb-3 p-1">
										<!-- Inquiry -->
										<div onclick="loadMyURL('inquiries.php')" class="bg-col1 text-white rounded h-100 text-center p-4 mypointer">
											<i class="fa fa-3x fa-question-circle"></i><br>
											<small class="">Inquiries</small><br>
											<span>New: <b><?php echo $inquirymsg;?></b> Hide: <b><?php echo $inquirymsgoff;?></b></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Feeds -->
						<div class="card mb-4">
							<div class="card-body p-4">
								<h4>Announcements</h4>
								<div id="load_here">
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php echo sideadsfooter_tag();?>
			</div>
		</div>
	</main>

	<?php echo privatemessage_tag();?>

	<?php echo error_tag();?>
	<script type="text/javascript">
		var htmltbname = "<?php echo $htmltbname;?>";
		var htmlpage = "<?php echo $htmlpage;?>";
		loaderon();
		window.addEventListener("load", function(){
			loadnews("","","",1,htmlpage);
			loaderoff();
		});

		function loadnews(htmltbname,searchdata,sort,page,htmlpage){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("router.php",{
				load_news_page: page,
				load_news_htmlpage: htmlpage,
				load_news_what: "no"
		    });
		}
	</script>
</body>
</html>

