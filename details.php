<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data();
$display3 = "";
$display4 = "";
if($userdata_arr){
	checkiflog($userdata_arr);
	$display3 = "none";
}else{
	$display4 = "none";
}


$display1 = "";
$display2 = "";

$htmltbname = "";
$htmlpage = "details.php";

$disid = "";
$disusercode = "";
$loccode = "";
$fullname = "";
$contactno = "";
$dateposted = "";
$adstitle = "";
$adsdesc = "";
$listingdesc = "";
$price = "";
$loc = "";
$add = "";
$secdepo = "";
$mincon = "";
$payterm = "";
$photocarousel = "";
$listingdescription = "";
$listingcode = "";
$tags = "";
$maintag = "";
$newdesc = "";
$sharebut = "";
$sharelink = "";
if(isset($_GET['id'])){
	$disid = $_GET['id'];
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
			b_ads.word_tags,

			b_listing.listingcode AS b_listinglistingcode,
			b_listing.listingdescription,
			b_listing.buildingname,
			b_listing.propaddress,
			b_listing.proptypecode,
			b_listing.propclasscode,
			b_listing.loccitycode,
			b_listing.usercode,
			b_listing.listingkeys,
			b_listing.listingtag,

			a_listingtype.listtypecode,
			a_listingtype.listtypedesc,
			a_listingtype.listtypetag,

			a_mincontract.mincontractcode,
			a_mincontract.mincontractdesc,
			a_mincontract.mincontracttag,

			a_accounts.usercode,
			a_accounts.email,
			a_accounts.membertype,
			a_accounts.memberlname,
			a_accounts.memberfname,
			a_accounts.membercellno,

			a_locationcity.loccitycode,
			a_locationcity.loccitydesc,
			a_locationcity.loccitytag,

			a_propertytype.proptypecode,
			a_propertytype.proptypetag,

			a_propertyclass.propclasscode,
			a_propertyclass.propclasstag

		FROM (((((((b_ads
			INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
			INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)
			INNER JOIN a_mincontract ON b_ads.mincontract=a_mincontract.mincontractcode)
			INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
			INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
			INNER JOIN a_propertytype ON b_listing.proptypecode=a_propertytype.proptypecode)
			INNER JOIN a_propertyclass ON b_listing.propclasscode=a_propertyclass.propclasscode)

		WHERE b_ads.recno = $disid
		AND b_ads.status = 'on'
	";
	
	$row = selectQ($sql);

  	if(is_array($row)){

  		$a1 = $row[0]['recno'];
  		$a2 = $row[0]['adstitle'];
  		$a3 = $row[0]['adsdesc'];
  		$a4 = $row[0]['price'];
  		$a5 = $row[0]['securitydeposit'];
  		$a6 = $row[0]['mincontract'];
  		$a7 = $row[0]['downpayment'];
  		$a8 = $row[0]['paymentterm'];
		$a9 = $row[0]['dateinserted'];
		$a10 = $row[0]['mincontractdesc'];
		$a11 = $row[0]['adscode'];
		$a12 = $row[0]['listingdescription'];
		$a13 = $row[0]['b_listinglistingcode'];
		$a14 = $row[0]['word_tags'];

		$b1 = $row[0]['listtypedesc'];
  		$b2 = $row[0]['propaddress'];
  		$b3 = $row[0]['loccitydesc'];
  		$b4 = $row[0]['loccitycode'];

  		$c1 = $row[0]['email'];
  		$c2 = $row[0]['memberlname'];
  		$c3 = $row[0]['memberfname'];
  		$c4 = $row[0]['membercellno'];
  		
  		//listtypetag proptypetag in loccitytag propclasstag
  		//tags
  		$tag1 = $row[0]['listtypetag'];
  		$tag2 = $row[0]['proptypetag'];
  		$tag3 = $row[0]['loccitytag'];
  		$tag4 = $row[0]['propclasstag'];
  		$tag5 = $row[0]['mincontracttag'];
  		
  		$maintag = "$tag1 $tag2 in $tag3 $tag4";

  		$dislistingkeys = $row[0]['listingkeys'];
  		$disusercode = $row[0]['usercode'];
  		$loccode = $b4;
  		$contactno = $c4;
  		$fullname = $c3." ".$c2;
  		$dateposted = $a9;
  		$adstitle = $a2;
		$adsdesc = $a3;
		$listingdesc = $b1;
		$price = $a4;
		$loc = $b3;
		$add = $b2;
		$secdepo = $a5;
		$mincon = $a10;
		$payterm = $a8;
		$tags = $a14;
		$listingdescription = $a12;
		$listingcode = $a13;

		//new description
  		//adstitle price propaddress
		$newdesc = "$adstitle ".formatPeso_nopeso($price)." $add $tag5";


		if($mincon == ""){
			$mincon = "N/A";
		}
		if($payterm == ""){
			$payterm = "N/A";
		}

		if($secdepo == "" || $secdepo == 0){
			$secdepo = "N/A";
		}else{
			$secdepo = formatPeso($secdepo);
		}

		$photocarousel = ""; 
		//image
	    $itemspath = cfg::get('itempath')."$disusercode/$dislistingkeys/";
	    $firstFile = scandir($itemspath);
	    $count = count($firstFile);
	    for ($i=2; $i < $count; $i++) { 
	    	$act = "";
	    	if($i == 2){
	    		$act = "active";
	    	}
	    	$photocarousel .= "
	    		<div class='carousel-item $act'>
					<img src='$itemspath{$firstFile[$i]}' class='d-block w-100' alt='$adstitle'>
				</div>
			";
		}

  		$display1 = "none";
  		$display2 = "";
  	
  	$sharelink = cfg::get('base_url')."/details.php?id=$disid";
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
			data-href="'.$sharelink.'" 
			data-layout="button_count">
		</div>
		
	';

  	}else{
  		$display1 = "";
  		$display2 = "none";
  	}
}else{
	$display1 = "";
  	$display2 = "none";
}




?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $maintag;?></title>
	<meta name='description' content='<?php echo $newdesc;?>' />
	<meta name='keywords' content='<?php echo $tags;?>' />
	<?php echo cfg::get('DetailsHTML');?>
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
					
					<div class="card mb-4" style="display: <?php echo $display1;?>">
						<div class="card-body">
							<div class="alert alert-danger" role="alert">
							  <strong>Ooops!</strong> Nothing to show...
							</div>
						</div>
					</div>

					<!-- Details -->
					<div class="card mb-4" style="display: <?php echo $display2;?>">
						<div class="card-body">
							<div class="d-flex justify-content-between">
								<div class="align-self-center">
									<div class="d-flex">
										<!-- <img src="data/img/defavatar.jpg" class="align-self-center rounded-circle" alt="" width="50" height="50"> -->
										<div class="d-flex justify-content-center bg-col2 rounded-circle text-white m-auto" style="width: 50px; height: 50px;">
											<i class="align-self-center fa fa-2x fa-user-tie"></i>
										</div>
										
										<div class="align-self-center p-2 flex-grow-1">
											<span class="fs-5">Posted by <?php echo ucwords($fullname);?></span><br>
											<small class="text-muted lh-1"><?php echo timeAgo($dateposted);?></small>
										</div>
									</div>
								</div>
								<div class="dropdown align-self-start" style="display: ;">
									<div class="m-auto"><?php echo $sharebut;?></div>
								</div>
							</div>
						</div>

						<div class="row px-4">
							<div class="col-sm-6">
								<div class="card-body">
									<div class="">
										<span class="h5"><?php echo ucwords($adstitle);?></span>
									</div>
									<p>
										<?php echo ucwords($adsdesc);?>
									</p>
									<div class="">
										<span class="h5"><?php echo $listingdesc;?></span><br>
										<span class="fs-2 text-muted"><?php echo formatPeso($price);?></span>
									</div>
									<p>
										<?php echo ucwords($listingdescription);?>
									</p>
									<ul class="list-group list-group-flush">
										<!-- <li class="list-group-item"><span class="h5">For Rent</span></li>
										<li class="list-group-item"><span class="fs-2 text-muted">P 8,000.00</span></li> -->
										<li class="list-group-item p-1">Location: <?php echo $loc;?></li>
										<li class="list-group-item p-1">Address: <?php echo $add;?></li>
										<li class="list-group-item p-1">Deposit: <?php echo $secdepo;?></li>
										<li class="list-group-item p-1">Minimun Contract: <?php echo $mincon;?></li>
										<li class="list-group-item p-1">Payment Terms: <?php echo $payterm;?></li>
									</ul>
								</div>
							</div>
							<div class="col-sm-6">
								
									<div id="carouselWithIndicators" class="carousel slide" data-bs-ride="carousel">
										<div class="carousel-inner">
											<?php echo $photocarousel;?>
										</div>
										<a class="carousel-control-prev" href="#carouselWithIndicators" role="button" data-bs-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Previous</span>
										</a>
										<a class="carousel-control-next" href="#carouselWithIndicators" role="button" data-bs-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="visually-hidden">Next</span>
										</a>
									</div>
									<div class="card mt-2" style="display: <?php echo $display3;?>">
										<div class="card-body p-2">
											<div class="accordion accordion-flush" id="accordionFlush">
												<div class="accordion-item">
													<h2 class="accordion-header" id="flush-headingOne">
														<button class="accordion-button collapsed py-1 pt-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
					  										<h5><i class="me-3 fa fa-phone"></i>Contact Agent</h5>
														</button>
													</h2>
													<div id="flush-collapseOne" class="accordion-collapse collapse hide" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
														<div class="accordion-body p-0">
															<div id="agentform" style="display: ;">
																<p class="mt-2">Fill in the form to view agent's contact number...</p>
																<div>
																	<div class="form-floating mb-3">
																		<input type="text" class="form-control" id="A_a" placeholder="First name">
																		<label for="A_a">First name</label>
																	</div>
																	<div class="form-floating mb-3">
																		<input type="text" class="form-control" id="A_b" placeholder="Last name">
																		<label for="A_b">Last name</label>
																	</div>
																	<div class="form-floating mb-3">
																		<input type="text" class="form-control" id="A_c" placeholder="Email Address">
																		<label for="A_c">Email Address</label>
																	</div>
																	<div class="form-floating mb-3">
																		<input type="text" class="form-control" id="A_d" placeholder="Contact Number">
																		<label for="A_d">Contact Number</label>
																	</div>
																	<div class="form-floating mb-3">
																		<select class="form-select" id="A_e" aria-label="Floating label select example">
																			<option >For viewing.</option>
																			<option >Please call back.</option>
																		</select>
																		<label for="A_e">Request</label>
																	</div>
																	<div class="form-floating mb-3">
																		<textarea class="form-control" placeholder="Your message" id="A_f" style="height: 100px"></textarea>
																		<label for="A_f">Your message</label>
																	</div>
																	<div class="d-flex flex-row-reverse">
																		<button id="A_butt" type="button" class="btn btn-info bg-col1 border-0 text-white">
																			<i class="fa fa-comment-alt me-2"></i>Send
																		</button>
																	</div>
																	<br>
																</div>
															</div>
														</div>
														<div id="agencontact" class="alert alert-warning m-2 mt-3" role="alert" style="display: none;">
															Please call the agent for fast transaction...
															<br>
															Agent: <strong><?php echo $fullname;?></strong><br>
															Contact: <span class="lead"><?php echo $contactno;?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>
						<br><br>
						<div class="card-body d-flex justify-content-center">
							<button onclick="location.href=`dashboard.php`;" type="button" class="btn btn-info bg-col1 border-0 text-white">Look for more</button>
						</div>
						<br><br>
					</div>


					

					<!-- NEW Related post -->
					<div id="load_related_here2">
						
					</div>

					<!-- OLD Related post Turn into Related post acording to location-->
					<div id="load_related_here" style="display: <?php echo $display4;?>">
						
					</div>
					


					<!-- Related post acording to location -->
					<div id="load_random_here" style="display: <?php echo $display3;?>">
						
					</div>
					


					<!-- Featured Items -->
					<div id="loadfeaturedunitA">
						
					</div>
					<div class='card-body d-flex justify-content-center'>
						<button onclick='location.href=`dashboard.php`;' type='button' class='btn btn-info bg-col1 border-0 text-white'>Look for more</button>
					</div>
					<br><br>
					<br><br>
					<br><br>
						


				</div>
				<!-- Ads -->
				<?php echo sideadsfooter_tag();?>
			</div>
		</div>
	</main>



	<!-- Index Footer -->
	<div class="bg-col1 mt-5" style="border-top: solid #FFB74A 10pt;">
		<?php echo cfg::get("indexfooterdetailsHTML");?>
	</div>
	
	<!-- Index Copyright -->
	<div class="" style="background-color: #003046;">
		<?php echo cfg::get("indexcopyrightHTML");?>
	</div>


	<?php echo error_tag();?>
	<script type="text/javascript">
		loaderon();

		window.addEventListener("load", function(){
			let id = "<?php echo $disid;?>";
			let uc = "<?php echo $disusercode;?>";
			let loc = "<?php echo $loccode;?>";
			let liscod = "<?php echo $listingcode;?>";
			
			//for loggedin
			loadrelatedhere(id,uc);
			loadrelatedhere2(id,uc,liscod);

			//for unlogged
			loadrandomhere(loc);

			loadfeaturedunitA("Priority","loadfeaturedunitA");
			loaderoff();
		});

		function showsellercontact(){
			$("#agencontact").css("display","");
			$("#agentform").css("display","none");
		}

		function loadfeaturedunitA(what,divid){
			let disloc = "";
			$("#"+divid).load("router.php",{
				load_featured_unitA: what,
				load_featured_unitA_loc: disloc
			});
		}

		function get_data_val_for_A(listingkey){
			let a = filterSymbols($("#A_a").val());
			let b = filterSymbols($("#A_b").val());
			let c = filterSymbols($("#A_c").val());
			let d = filterSymbols($("#A_d").val());
			let e = filterSymbols($("#A_e").val());
			let f = filterSymbols($("#A_f").val());
			let liscod = "<?php echo $listingcode;?>";
			let dislisting = liscod;

			if(a == "" || b == "" || c == "" || d == "" || e == "" || f == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				let ba = "<?php echo $disid; ?>";
				let bb = filterSymbols("<?php echo $adstitle; ?>");
				let bc = "<?php echo $listingdesc;?>";
				let bd = "<?php echo $price; ?>";
				let be = "<?php echo $loc; ?>";
				let bf = "<?php echo $disusercode; ?>";

				const data = '{ "a":"'+a+'" , "b":"'+b+'" , "c":"'+c+'", "d":"'+d+'", "e":"'+e+'", "f":"'+f+'"}';
				const data2 = '{ "a":"'+ba+'" , "b":"'+bb+'" , "c":"'+bc+'", "d":"'+bd+'", "e":"'+be+'", "f":"'+bf+'", "g":"'+dislisting+'"}';
				$("#err").load("router.php",{
					save_inquire_data: data,
					save_inquire_data2: data2
			    });
			}
		}

		function loadrelatedhere(id,usercode){
			$("#load_related_here").load("router.php",{
				load_related_id: id,
				load_related_usercode: usercode
			});
		}
		
		function loadrelatedhere2(id,usercode,listingcode){
			$("#load_related_here2").load("router.php",{
				load_related_id2: id,
				load_related_usercode2: usercode,
				load_related_listingcode2: listingcode
			});
		}



		function loadrandomhere(loc){
			$("#load_random_here").load("router.php",{
				load_random_data: loc
			});
		}

		$("#A_butt").on("click",function(){
			loaderon();
			get_data_val_for_A();
		});
	</script>
</body>
</html>

