<?php
$mainpath = "../data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data_admin();
checkiflog($userdata_arr,"../");
//echo showDB(); //check DB connection

//////////////////////////////////////////////////////X
//A Part
$loadform = "";
$fieldnum = 0;
$htmltbname = "";
$htmlpage = "";
$text1 = "";
$text2 = "";
$showhide = "";
$arrused = "";
$disablingbutton = "style = 'display: ;'";

//////////////////////////////////////////////////////
//B Part
$searchformnum = 0;
$searchform = "";
$loadtable = "";

//////////////////////////////////////////////////////
//C Part
$showmemandstars = "style = 'display: none;'";





if(isset($_GET['accounts'])){
	//A Part
	$g = $_GET['accounts'];
	$fieldnum = 10;
	$htmltbname = "a_accounts";
	$htmlpage = "admin.php?accounts";
	$arrused = $arr_a_accounts;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Members Entry";
		$text2 = "Create new Members entry and save in the database...";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"usercode",$g,"","","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"email",$g,"","","forced_enable");
		$loadform .= create_element("A3","mb-2",$arrused,"password",$g,"","","forced_enable");
		$loadform .= create_element("A4","mb-2",$arrused,"membertype",$g);
		$loadform .= create_element("A5","mb-2",$arrused,"memberlname",$g,"","","forced_enable");
		$loadform .= create_element("A6","mb-2",$arrused,"memberfname",$g,"","","forced_enable");
		$loadform .= create_element("A7","mb-2",$arrused,"membercellno",$g,"","","forced_enable");
		$loadform .= create_element("A8","mb-2",$arrused,"memberstatus",$g);
		$loadform .= create_element("A9","mb-2",$arrused,"membertag",$g);
	}else{
		$text1 = "Update Members Entry";
		$text2 = "Update Members entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"usercode",$g);
		$loadform .= create_element("A2","mb-2",$arrused,"email",$g);
		$loadform .= create_element("A3","mb-2",$arrused,"password",$g);
		$loadform .= create_element("A4","mb-2",$arrused,"membertype",$g);
		$loadform .= create_element("A5","mb-2",$arrused,"memberlname",$g);
		$loadform .= create_element("A6","mb-2",$arrused,"memberfname",$g);
		$loadform .= create_element("A7","mb-2",$arrused,"membercellno",$g);
		$loadform .= create_element("A8","mb-2",$arrused,"memberstatus",$g);
		$loadform .= create_element("A9","mb-2",$arrused,"membertag",$g);
	}
	
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);

	//C Part
	$showmemandstars = "style = 'display: ;'";
}

if(isset($_GET['membertype'])){
	//A Part
	$g = $_GET['membertype'];
	$fieldnum = 4;
	$htmltbname = "a_membertype";
	$htmlpage = "admin.php?membertype";
	$arrused = $arr_a_membertype;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Member Type Entry";
		$text2 = "Create New Member Type entry and save in the database.";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Member type are pre-created Blue Silver and Gold this names are already hardcoded in the system you are not allowed to add another type...</span>";

		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"membertypecode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"membertypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"membertypetag",$g);

		$disablingbutton = "style = 'display: none;'";
	}else{
		$text1 = "Update Member Type Entry";
		$text2 = "Update Member Type entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"membertypecode",$g,"","forced-text");
		$loadform .= create_element("A2","mb-2",$arrused,"membertypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"membertypetag",$g);

		$disablingbutton = "style = 'display: ;'";
	}
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

if(isset($_GET['propertytype'])){
	//A Part
	$g = $_GET['propertytype'];
	$fieldnum = 4;
	$htmltbname = "a_propertytype";
	$htmlpage = "admin.php?propertytype";
	$arrused = $arr_a_propertytype;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Property Type Entry";
		$text2 = "Create new Property Type entry and save in the database.";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Assign only a <b>unique</b> code for each items, codes will be not be editable.</span>";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"proptypecode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"proptypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"proptypetag",$g);
	}else{
		$text1 = "Update Property Type Entry";
		$text2 = "Update Property Type entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"proptypecode",$g,"","forced-text");
		$loadform .= create_element("A2","mb-2",$arrused,"proptypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"proptypetag",$g);
	}
	
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

if(isset($_GET['propertyclass'])){
	//A Part
	$g = $_GET['propertyclass'];
	$fieldnum = 5;
	$htmltbname = "a_propertyclass";
	$htmlpage = "admin.php?propertyclass";
	$arrused = $arr_a_propertyclass;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Property Class Entry";
		$text2 = "Create new Property Class entry and save in the database...";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Assign only a <b>unique</b> code for each items, codes will be not be editable.</span>";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"proptypecode",$g);
		$loadform .= create_element("A2","mb-2",$arrused,"propclasscode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A3","mb-2",$arrused,"propclassdesc",$g,"100px");
		$loadform .= create_element("A4","mb-2",$arrused,"propclasstag",$g);
	}else{
		$text1 = "Update Property Class Entry";
		$text2 = "Update Property Class entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"proptypecode",$g);
		$loadform .= create_element("A2","mb-2",$arrused,"propclasscode",$g,"","forced-text");
		$loadform .= create_element("A3","mb-2",$arrused,"propclassdesc",$g,"100px");
		$loadform .= create_element("A4","mb-2",$arrused,"propclasstag",$g);
	}
	
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

if(isset($_GET['locationcity'])){
	//A Part
	$g = $_GET['locationcity'];
	$fieldnum = 4;
	$htmltbname = "a_locationcity";
	$htmlpage = "admin.php?locationcity";
	$arrused = $arr_a_locationcity;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Loaction City Entry";
		$text2 = "Create new Loaction City entry and save in the database...";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Assign only a <b>unique</b> code for each items, codes will be not be editable.</span>";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"loccitycode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"loccitydesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"loccitytag",$g);
	}else{
		$text1 = "Update Loaction City Entry";
		$text2 = "Update Loaction City entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"loccitycode",$g,"","forced-text");
		$loadform .= create_element("A2","mb-2",$arrused,"loccitydesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"loccitytag",$g);
	}
		
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

if(isset($_GET['listingtype'])){
	//A Part
	$g = $_GET['listingtype'];
	$fieldnum = 4;
	$htmltbname = "a_listingtype";
	$htmlpage = "admin.php?listingtype";
	$arrused = $arr_a_listingtype;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Listing Type Entry";
		$text2 = "Create new Listing Type entry and save in the database...";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Assign only a <b>unique</b> code for each items, codes will be not be editable.</span>";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"listtypecode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"listtypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"listtypetag",$g);
	}else{
		$text1 = "Update Listing Type Entry";
		$text2 = "Update Listing Type entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"listtypecode",$g,"","forced-text");
		$loadform .= create_element("A2","mb-2",$arrused,"listtypedesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"listtypetag",$g);
	}
		
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

if(isset($_GET['mincontract'])){
	//A Part
	$g = $_GET['mincontract'];
	$fieldnum = 4;
	$htmltbname = "a_mincontract";
	$htmlpage = "admin.php?mincontract";
	$arrused = $arr_a_mincontract;
	if($g == "" || $g == 0 || $g == null){
		$text1 = "Create New Min Contract Entry";
		$text2 = "Create new Min Contract entry and save in the database...";
		$text2 .= "<br><span class='text-danger'>IMPORTANT! Assign only a <b>unique</b> code for each items, codes will be not be editable.</span>";
		$showhide = "hide";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"mincontractcode",$g,"","forced-text","forced_enable");
		$loadform .= create_element("A2","mb-2",$arrused,"mincontractdesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"mincontracttag",$g);
	}else{
		$text1 = "Update Min Contract Entry";
		$text2 = "Update Min Contract entry and save in the database...";
		$showhide = "show";

		$loadform .= create_element("A0","mb-2",$arrused,"recno",$g);
		$loadform .= create_element("A1","mb-2",$arrused,"mincontractcode",$g,"","forced-text");
		$loadform .= create_element("A2","mb-2",$arrused,"mincontractdesc",$g,"100px");
		$loadform .= create_element("A3","mb-2",$arrused,"mincontracttag",$g);
	}
		
	//B Part
	$searchformnum = load_row('fieldnum',$htmltbname,"","",1,$htmlpage);
	$searchform = load_row('searchform',$htmltbname,"","",1,$htmlpage);
	$loadtable = load_row(0,$htmltbname,"","",1,$htmlpage);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrator</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="copyright" content="" />
	<?php echo head_tag($mainpath);?>
</head>
<body class="backcolor">
	<?php echo loader_tag();?>
	<?php echo topnav_admin_tag();?>
	<br><br><br>
	<!-- Main -->
	<main class="maxw1080 m-auto">
		<div class="container-fluid">
			<div class="row">
				<!-- Profile -->
				<div class="col-lg-2">
					<?php echo sidenav_admin_tag();?>
				</div>
				<!-- Content -->
				<div class="col-lg-10">

					<!-- Create -->
					<div class="card mb-4">
						<div class="card-body p-2">
							<div class="accordion accordion-flush" id="accordionFlush">
								<div class="accordion-item">
									<h2 class="accordion-header" id="flush-headingOne">
										<button class="accordion-button collapsed py-1 pt-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
	  										<h5><i class="me-3 fa fa-star"></i><?php echo $text1;?></h5>
										</button>
									</h2>
									<div id="flush-collapseOne" class="accordion-collapse collapse <?php echo $showhide;?>" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
										<div class="accordion-body p-0">
											<p class="mt-2 p-2"><?php echo $text2;?></p>
											<div class="p-2">
												<?php echo $loadform;?>
											</div>
											<div class="d-flex flex-row-reverse p-2">
												<button id="A_save" type="button" class="btn btn-info bg-col1 border-0 text-white m-1" <?php echo $disablingbutton;?>>
													<i class="fa fa-save me-2"></i>Save
												</button>
												<button id="A_reset" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
													<i class="fa fa-times me-2"></i>Cancel
												</button>
											</div>
										</div>
										<br>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Set member type and stars -->
					<div class="card mb-4" <?php echo $showmemandstars;?> >
						<div class="card-body p-2">
							<div class="accordion accordion-flush" id="accordionFlush2">
								<div class="accordion-item">
									<h2 class="accordion-header" id="flush-headingOne2">
										<button class="accordion-button collapsed py-1 pt-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne">
	  										<h5><i class="me-3 fa fa-star"></i>Set Member Type or add Stars</h5>
										</button>
									</h2>
									<div id="flush-collapseOne2" class="accordion-collapse collapse" aria-labelledby="flush-headingOne2" data-bs-parent="#accordionFlush2">
										<div class="accordion-body p-0">
											<div class="row">
												<div class="col-md-12">
													<div class="py-3 p-2">
														<div class="alert alert-danger" role="alert">
															This action is irreversible, you are about to set or extend expiration to a member's membertype as Gold or Silver... 
														</div>
														<div class="input-group mb-2">
															<input id="D_find" type="text" class="form-control" placeholder="Find Member" aria-label="Find" aria-describedby="D_find">
															<button type="button" class="btn btn-warning" id="D_find_but"><i class="fa fa-search"></i></button>
														</div>
														<ul id="D_loadmembers" class="list-group list-group-flush border limitheight">
															
														</ul>
														<div class="d-flex mt-2">
															<div class="form-floating w-100">
															  <input type="text" class="form-control" id="D_ucode" placeholder="User Code" readonly="">
															  <label id="D_ucode_label" for="D_ucode">User Code</label>
															</div>

															<div class="form-floating ms-2" style="width: 200px;">
															  <select class="form-select" id="D_priority" aria-label="Floating label select example">
															  	<option value="" >N/A</option>
															  	<option value="1">1st priority</option>
															    <option value="2">2nd priority</option>
															  </select>
															  <label for="D_priority">Ads Priority</label>
															</div>

															<div class="form-floating ms-2" style="width: 200px;">
															  <select class="form-select" id="D_type" aria-label="Floating label select example">
															  	<option value="" >N/A</option>
															    <option value="Silver" >Silver</option>
															    <option value="Gold" >Gold</option>
															  </select>
															  <label for="D_type">Type</label>
															</div>

															<div class="form-floating ms-2" style="width: 200px;">
															  <select class="form-select" id="D_stars" aria-label="Floating label select example">
															  	<option value="" >N/A</option>
															  	<option value=1 >1 Star</option>
															  	<option value=3 >3 Stars</option>
															  	<option value=5 >5 Stars</option>
															  	<option value=10 >10 Stars</option>
															  </select>
															  <label for="D_stars">Stars</label>
															</div>
															
															<button id="D_save" type="button" class="btn btn-info bg-col1 border-0 text-white ms-2" style="height: 58px; width: 70px;">
																<i class="fa fa-save"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<br>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Content -->
					<div class="card mb-4">
						<div class="card-body p-2">


							<!-- search -->
							<div class="mt-2">
								<div class="d-flex flex-md-row flex-column justify-content-center">
									<?php echo $searchform;?>
										
									<div class="m-1">
										<button id="B_find" type="button" class="btn btn-warning text-dark" style="height: 58px; width: 58px;" ><i class="fa fa-search"></i></button>
									</div>
								</div>
							</div>
							<br>

							<!-- Result -->
							<div class="p-md-3">
								<!-- Table -->
								<div id="load_table_here" class="mt-2" style="overflow: auto;">
									  <?php echo $loadtable;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Modal show history -->
	<div id="history" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="historytitle">Purchase History</h5>
		        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
		      </div>
		      <div id="load_item_del">
		      	<div id="load_history" class="modal-body">
		      		<h4>Aring, Jason</h4>
		      		<small><i class='fa fa-gem'></i> Gold 31 days <i class='fa fa-star'></i> 5</small>
		      		<br><br>
		      		<table class="table table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Date Purchased</th>
					      <th scope="col">Expiration</th>
					      <th scope="col">Purchased Items</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>2021-12-01</td>
					      <td>2022-01-01</td>
					      <td>Gold 31 days</td>
					    </tr>
					  </tbody>
					</table>
		      	</div>
		      </div>
		    </div>
		</div>
	</div>


	<!-- Modal show email form -->
	<div id="emailform" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="emailformtitle">Send an Email</h5>
		        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
		      </div>
		      <div id="load_item_emailform">
		      	<div id="load_emailform" class="modal-body">
		      		<div class="form-floating mb-3">
					  <input type="text" class="form-control" id="E_a" placeholder="Email Address">
					  <label for="E_a">Email address</label>
					</div>
					<div class="form-floating mb-3">
					  <input type="text" class="form-control" id="E_b" placeholder="Subject">
					  <label for="E_b">Subject</label>
					</div>
					<div class="form-floating mb-3">
					  <textarea class="form-control" placeholder="Message" id="E_c" style="height: 200px"></textarea>
					  <label for="E_c">Message</label>
					</div>
					<button id="E_butt" type="button" class="btn btn-secondary">Send</button>
		      	</div>
		      </div>
		    </div>
		</div>
	</div>




	<?php echo error_tag();?>
	<script type="text/javascript">
		loaderon();
		window.addEventListener("load", function(){
			let fieldnum = <?php echo $fieldnum;?>;
			let htmltbname = "<?php echo $htmltbname;?>";
			let htmlpage = "<?php echo $htmlpage;?>";
			save_add_reset(fieldnum,htmltbname,htmlpage);

			let searchformnum = <?php echo $searchformnum;?>;
			findbutton(searchformnum,htmltbname,htmlpage);
			getfindval();
			ifselectedlist();
			loaderoff();
		});
		function selected_name(usercode,username,priority){
			$("#D_ucode_label").html(username);
			$("#D_ucode").val(usercode);
			$("#D_priority").val(priority);
			
		}
		function selected_history(usercode,fullname){
			$("#load_history").load("../router.php",{
				load_history_ucode: usercode,
				load_history_fname: fullname
			});
		}
		function ifselectedlist(){
			$(".ifselected").on("click",function(){
				$(".ifselected").css("background-color","white");
				$(this).css("background-color","red");
			});
		}
		function getfindval(){
			let find = $("#D_find").val();
			$("#D_loadmembers").load("../router.php",{
				load_memberslist: find
			});
		}

		function getdataval(){
			let D_ucode = $("#D_ucode").val();
			let D_priority = $("#D_priority").val();
			let D_type = $("#D_type").val();
			let D_stars = $("#D_stars").val();
			$("#err").load("../router.php",{
				load_D_ucode: D_ucode,
				load_D_priority: D_priority,
				load_D_type: D_type,
				load_D_stars: D_stars
			});
		}

		function emaildis(disemail){
			$('#emailform').modal('show');
			$('#E_a').val(disemail);
		}

		$("#E_butt").on("click",function(){
			let a = filterSymbols($("#E_a").val());
			let b = filterSymbols($("#E_b").val());
			let c = filterSymbols($("#E_c").val());

			if(a == "" || b == "" || c == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				const data = '{ "a":"'+a+'" , "b":"'+b+'" , "c":"'+c+'" }';
				$("#err").load("../router.php",{
					emaildis_data: data
			    });
			}
		});

		
		$("#D_find_but").on("click",function(){
			loaderon();
			getfindval();
		});

		$("#D_save").on("click",function(){
			loaderon();
			getdataval();
		});
		$("#D_type").on("change",function(){
			let dis = $(this).val();	
			if(dis != ""){
				$("#D_stars").val('');
				$("#D_priority").val('');
			}
		});
		$("#D_stars").on("change",function(){
			let dis = $(this).val();
			if(dis != ""){
				$("#D_type").val('');
				$("#D_priority").val('');
			}
		});
		$("#D_priority").on("change",function(){
			let dis = $(this).val();
			if(dis != ""){
				$("#D_stars").val('');
				$("#D_type").val('');
			}
		});
	</script>
</body>
</html>






