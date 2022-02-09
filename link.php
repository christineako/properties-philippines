<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$companynameHTML = cfg::get('companynameHTML');
$indexfooterHTML = cfg::get("indexfooterHTML");


$htmltbname = "b_ads";
$htmlpage = "$linkname";

$A_usercode = "";
$ID_picture = "data/img/defimg.jpg";
$fullname = "";
$ownerbroker = "";
$disemail = "";
$A_membertype = "";
$dislink = "";
$A_memberabout = "";
$disphone = "";
$disviver = "";


$memberlistingandads = "";
//members data
$uri = explode("/$linkname?", $_SERVER['REQUEST_URI']);
$member_link_name = $uri[1];


//check if admin is logged
$adminlogged = "";
$userdata_arr = get_login_data_admin();
if(is_array($userdata_arr)){
	$adminlogged = $userdata_arr['usertype'];
}


if($member_link_name == "" || $member_link_name == null || !isset($member_link_name)){
	header('Location: index.php');
}else{
	$row = getRow("*","a_accounts","memberlink",$member_link_name);
	if(is_array($row)){
		$A_recno = $row[0]['recno'];
		$A_usercode = $row[0]['usercode'];
		$A_email = $row[0]['email'];
		$A_priority = $row[0]['priority'];
		$A_stars = $row[0]['stars'];
		$A_membertype = $row[0]['membertype'];
		$A_memberlname = $row[0]['memberlname'];
		$A_memberfname = $row[0]['memberfname'];
		$A_membercellno = $row[0]['membercellno'];
		$A_memberstatus = $row[0]['memberstatus'];
		$A_membertag = $row[0]['membertag'];
		$A_memberinfo = $row[0]['memberinfo'];
		$A_memberlicense = $row[0]['memberlicense'];
		$A_memberabout = $row[0]['memberabout'];
		$A_memberviber = $row[0]['memberviber'];
		$A_memberlink = $row[0]['memberlink'];


		//picture
		$path = "items/$A_usercode/id.jpg";
		if(file_exists($path)){
			$ID_picture = $path;
		}
		$fullname = ucfirst($A_memberfname)." ".ucfirst($A_memberlname);
		
		//broker owner
		if($A_memberinfo == "Broker"){
			if($A_memberlicense != ""){
				$ownerbroker = "Broker License No: $A_memberlicense";
			}else{
				$ownerbroker = "Broker License No: Unspecified";
			}
		}else if($A_memberinfo == "Owner"){
			$ownerbroker = "Owner";
		}else{
			$ownerbroker = "";
		}
		//email
		$disemail = $A_email;

		//about
		if($A_memberabout == ""){
			$A_memberabout = "Members About page is not yet ready...";
		}
		
		//phone
		if($A_membercellno == ""){
			$A_membercellno = "Unspecified...";
		}
		//viber
		if($A_memberviber == ""){
			$A_memberviber = "Unspecified...";
		}

		//publiclink
		$dislink = cfg::get('server_url')."/".$linkname."?".$A_memberlink;

		//facebook share button
		$sharebut = '
		    <div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, "script", "facebook-jssdk"));</script>

			<div class="fb-share-button" 
				data-href="'.$dislink.'" 
				data-layout="button_count" 
				data-size="large" >
			</div>
			
		';


		if($adminlogged == "Administrator"){

$memberlistingandads = <<< EOFILE
	<main class="mt-4">
		<div class="maxw1080 m-auto px-sm-5">
			<!-- listing and ads -->
			<div class="card" style="overflow: hidden;">
				<div id="load_foradmin_here" class="card-body p-4">
					
				</div>
			</div>
		</div>
	</main>
	<script type="text/javascript">
		loaderon();
		window.addEventListener("load", function(){
			loaderoff();
			get_userlisting(A_usercode,pagenumcurrent);
		});
		function get_userlisting(usercode,page){
			loaderon();
			pagenumcurrent = page;
			$("#load_foradmin_here").load("router.php",{
			      get_userlisting_usercode: usercode,
			      get_userlisting_page: page
			});
		}

		function getfind(){
			get_userlisting(A_usercode,pagenumcurrent);
		}
	</script>
EOFILE;
		}

	}else{
		header('Location: index.php');
	}
}

















?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('IndexHTML');?>
	<?php echo head_tag($mainpath);?>
</head>
<body class="backcolor">
	<?php echo loader_tag();?>

	<script type="text/javascript">
		var htmltbname = "<?php echo $htmltbname;?>";
		var htmlpage = "<?php echo $htmlpage;?>";
		var A_usercode = "<?php echo $A_usercode;?>";
	</script>

	<!-- Top Nav -->
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white shadow">
		<div class="container-fluid">
			<a class="navbar-brand m-0 w-50" href="index.php">
				<img src="data/img/logo100x100.png" class="img-fluid p-0" alt="img-fluid" width="50" height="50">
				<span class="fonttitle"><?php echo $companynameHTML;?></span>
			</a>
			<button class="navbar-toggler border-0 me-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav1" aria-controls="nav1" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse hide flex-md-row-reverse" id="nav1">
				<div class="navbar-nav">
					<div class="p-1 align-self-center">
			          <button onclick="location.href=`login.php`;" type="button" class="btn btn-info bg-col1 border-0 text-white" style="height: 44px;">
			            <i class="fa fa-sign-in-alt"></i><span class="ms-2 d-none d-md-inline">List your property</span>
			          </button>
			        </div>
			    </div>
			</div>
		</div>
	</nav>



	<br><br><br>
	<!-- Member details -->
	<main class="mt-5">
		<div class="maxw1080 m-auto px-sm-5">
			<!-- Details -->
			<div class="card" style="overflow: hidden;">
				<div id="" class="card-body p-4">
					<div class="row text-white">
					  <div class="col-lg-6 mb-2 mb-lg-0">
					  	<div class="bg-col1 rounded p-3 h-100">
					  		<div class="row">
							  	<div class="col-md-3  mb-md-2 text-center">
									<img src="<?php echo $ID_picture;?>" class="img-fluid rounded-circle" alt="id">
								</div>
								<div class="col-md-9 mb-md-2">
							 		<span class="h2 d-inline-block text-truncate w-100 m-0" style="">
										<?php echo $fullname;?>
									</span>
									<span class="d-inline-block text-truncate w-100 m-0" style="">
										<i class="fa fa-user"></i> <?php echo $ownerbroker;?>
									</span>
									<span class="d-inline-block text-truncate w-100 m-0" style="">
										<i class="fa fa-envelope"></i> <?php echo $disemail;?>
									</span>
									<span class="d-inline-block text-truncate w-100 m-0" style="">
										<i class="fa fa-gem"></i> <?php echo $A_membertype;?> Member
									</span>
								</div>
							</div>
					  	</div>
					  </div>
					  <div class="col-lg-2 mb-2 mb-lg-0">
					  	<div class="bg-col1 rounded p-3 h-100 d-flex justify-content-center">
					  		<div class="align-self-center text-center">
					  			<span class="d-inline-block text-truncate w-100 mb-0" style="">
									<i class="fa fa-3x fa-envelope"></i><br>
									<small class="">Contact Me</small>
								</span>
					  			<span class="d-inline-block w-100 m-0" style="">
									<button type="button" onclick="window.location.href=`mailto:<?php echo $disemail;?>`" class="btn btn-sm btn-warning"><i class="fa fa-chevron-right"></i> By Email</button>
								</span>
								
					  		</div>
					  	</div>
					  </div>
					  <div class="col-lg-2 mb-0 mb-lg-0">
					  	<div class="bg-col1 rounded p-3 h-100 d-flex justify-content-center">
					  		<div class="align-self-center text-center">
					  			<span class="d-inline-block text-truncate w-100 mb-0" style="">
					  				<i class="fa fa-3x fa-share-alt"></i><br>
									<small class="">Share My Link</small>
								</span>
								<span class="d-inline-block w-100 m-0" style="">
									<button type="button" onclick="copydis('<?php echo $dislink;?>'); alert('You have copied to clipboard this link. <?php echo $dislink;?>');" class="btn btn-sm btn-warning"><i class="fa fa-chevron-right"></i> Copy</button>
								</span>
					  		</div>
					  	</div>
					  </div>
					  <div class="col-lg-2 mb-0 mb-lg-0">
					  	<div class="bg-col1 rounded p-3 h-100 d-flex justify-content-center">
					  		<div class="align-self-center text-center">
					  			<span class="d-inline-block text-truncate w-100 mb-0" style="">
					  				<i class="fab fa-3x fa-facebook"></i><br>
									<small class="">Facebook Share</small>
								</span>
								<span class="d-inline-block w-100 m-0" style="">
									<?php echo $sharebut;?>
								</span>
					  		</div>
					  	</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</main>


	<!-- Main -->
	<main class="mt-4">
		<div class="maxw1080 m-auto px-sm-5">
			<!-- Catalogue -->
			<div class="card" style="overflow: hidden;">
				<div id="load_here" class="card-body p-4">
					Loading...
				</div>
			</div>
		</div>
	</main>




	<!-- See only by Admin - Member listing and ads -->
	<?php echo $memberlistingandads;?>
	

	<!-- Side Ads -->
	<main class="mt-4">
		<div class="maxw1080 m-auto px-sm-5" style="overflow: hidden;">
			<div class="row g-0">
			  <div class="col-lg-6"><?php echo sideadsindex_tag2("cat4");?></div>
			  <div class="col-lg-6"><?php echo sideadsindex_tag2("cat5");?></div>
			</div>
		</div>
	</main>

	
	<!-- Index Footer -->
	<div class="bg-col1 mt-5" style="border-top: solid #FFB74A 10pt;">
		<div class='maxw1080 m-auto p-sm-5 text-center text-white my-0 p-3'>
			<div class='row'>
			  <div class='col-lg-4'>
			  	<div class='d-flex h-100 w-100'>
				  	<div class='align-self-center w-100 py-2'>
				  		<div>
				  		<img src='<?php echo $ID_picture;?>' class='img-fluid rounded-circle' alt='img-thumbnail' max-width='200' max-height='200'>
						<br><br>
						<h3><?php echo $fullname;?></h3>
						<small><?php echo $ownerbroker;?></small>
						</div>
				  	</div>
			  	</div>
			  </div>
			  <div class='col-lg-8 text-start d-flex'>
			  	<div class="align-self-center">
					<?php echo $A_memberabout;?>
				</div>
			  </div>
			</div>
			<br><br>
			
			<h3><i class="fa fa-phone"></i> Contact Me</h3>
			<p class='text-white'>
			    <span>Call: <a class='text-warning linknoline mx-1' href='tel:<?php echo $A_membercellno;?>'><?php echo $A_membercellno;?></a></span><br>
			    <span>Viber: <a class='text-warning linknoline' href='tel:<?php echo $A_memberviber;?>'><?php echo $A_memberviber;?></a></span><br>
			    <span>Email: <a class='text-warning linknoline' href='mailto:<?php echo $disemail;?>'><?php echo $disemail;?></a></span><br>
			</p>
			<br><br><br><br>
			<br>
		</div>
	</div>
	
	<!-- Index Copyright -->
	<div class="" style="background-color: #003046;">
		<?php echo cfg::get("indexcopyrightHTML");?>
	</div>

	<!-- Modal delete listing -->
	<div id="del_ads" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalBasicLabel">Delete Ads</h5>
		        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
		      </div>
		      <div id="load_item_del">

		      </div>
		    </div>
		</div>
	</div>

	<?php echo error_tag();?>
	<script type="text/javascript">
		loaderon();
		window.addEventListener("load", function(){
			loaderoff();
			getserchval4(htmltbname,"","",pagenumcurrent,htmlpage,"",A_usercode);
		});

		function getserchval4(htmltbname,searchdata,sort,page,htmlpage,sort2="",usercode=""){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("router.php",{
			      load_table4_htmltbname: htmltbname,
			      load_table4_searchdata: searchdata,
			      load_table4_sort: sort,
			      load_table4_page: page,
			      load_table4_htmlpage: htmlpage,
			      load_table4_sort2: sort2,
			      load_table4_user: usercode
			});
		}
	</script>
</body>
</html>