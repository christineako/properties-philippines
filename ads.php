<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data();
checkiflog($userdata_arr);
$htmltbname = "b_ads";
$htmlpage = "ads.php";

$showcreate = "hide";
$keyvalue = "";
$button2 = "";
$ucode = "";
$lkey = "";
$currucode = $userdata_arr['usercode'];

if(isset($_GET['key'])){
	$diskey = $_GET['key'];
	$showcreate = "show";
	$keyvalue = $diskey;
	$button2 = "
		<button id='A_butt2' type='button' class='btn btn-info bg-col1 border-0 text-white m-1'>
			<i class='fa fa-star me-2'></i>Create and go back
		</button>
	";
}

if(isset($_GET['ucode']) && isset($_GET['lkey'])){
	$ucode = $_GET['ucode'];
	$lkey = $_GET['lkey'];

	$diskey = $lkey;
	$showcreate = "hide";
	$keyvalue = $diskey;
	$button2 = "
		<button id='A_butt2' type='button' class='btn btn-info bg-col1 border-0 text-white m-1'>
			<i class='fa fa-star me-2'></i>Create and go back
		</button>
	";
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('AdsHTML');?>
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
					<div class="allpost p-0">

						<!-- Create Ads -->
						<div class="card">
							<div class="card-body">
								<div class="accordion accordion-flush" id="accordionFlush">
									<div class="accordion-item">
										<h2 class="accordion-header" id="flush-headingOne">
											<button class="accordion-button collapsed py-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
		  										<h5><i class="me-3 fa fa-clipboard-list"></i>Create New Ads</h5>
											</button>
										</h2>
										<div id="flush-collapseOne" class="accordion-collapse collapse <?php echo $showcreate;?>" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
											<div class="accordion-body p-0">
												<p class="mt-2">Create Ads for your property list here...</p>
												<div class="row px-4">
													<div class="col-sm-6">
															<div class="form-floating mb-3">
																<select class="form-select" id="A_a" aria-label="Floating label select example">
																	<?php echo opt_listingtype("","Choose");?>
																</select>
																<label for="A_a">Listing Type Code</label>
															</div>
															<div class="form-floating mb-3">
																<select class="form-select" id="A_b" aria-label="Floating label select example">
																	<?php echo opt_listingname_listingkey("","Choose",$userdata_arr['usercode']);?>
																</select>
																<label for="A_b">Listing Code</label>
															</div>
															<div class="form-floating mb-3">
																<input type="text" class="form-control" id="A_c" placeholder="Ads Title">
																<label for="A_c">Ads Title</label>
															</div>
															<div class="form-floating mb-3">
																<textarea class="form-control" placeholder="Ads Description" id="A_d" style="height: 200px"></textarea>
																<label for="A_d">Ads Description (optional)</label>
															</div>
															<div class="form-floating mb-3">
																<input type="text" class="form-control" id="A_j" placeholder="Tags">
																<label for="A_j">Tags</label>
															</div>
													</div>
													<div class="col-sm-6">
															<div class="form-floating mb-3">
																<input type="number" class="form-control" id="A_e" placeholder="Price">
																<label for="A_e">Price</label>
															</div>
															<div class="form-floating mb-3">
																<input type="number" class="form-control" id="A_f" placeholder="Security Deposit">
																<label for="A_f">Security Deposit (If for rent)</label>
															</div>

															<div class="form-floating mb-3">
																<select class="form-select" id="A_g" aria-label="Floating label select example">
																	<?php echo opt_mincontract("","Choose");?>
																</select>
																<label for="A_g">Minimum Contract</label>
															</div>

															<div class="form-floating mb-3">
																<input type="number" class="form-control" id="A_h" placeholder="Down Payment">
																<label for="A_h">Down Payment (If for sale)</label>
															</div>
															
															<div class="form-floating mb-3">
																<textarea class="form-control" placeholder="Payment Terms" id="A_i" style="height: 100px"></textarea>
																<label for="A_i">Payment Terms</label>
															</div>

															<div class="d-flex flex-row-reverse">
																<button id="A_butt" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-star me-2"></i>Create
																</button>
																<?php echo $button2;?>
															</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Stars -->
						<div class="card mt-4">
							<div class="card-body">
								<div id="load_stars_here" class="d-flex m-1">
									<!-- <i class="align-self-center text-warning fa fa-2x fa-star mx-2"></i>
									<i class="align-self-center text-warning fa fa-2x fa-star mx-2"></i>
									<i class="align-self-center text-muted fa fa-2x fa-star mx-2"></i> -->
								</div>
							</div>
						</div>

						<!-- Catalogue -->
						<div class="card mt-4">
							<!-- Search Nav -->
							<div class="card-body">
								<div class="d-flex flex-lg-row flex-column justify-content-center">
										<div class="">
											<div class="form-floating m-1">
												<select class="form-select" id="B_a" aria-label="Listing Type">
													<?php echo opt_listingtype();?>
												</select>
												<label for="B_a">Listing Type</label>
											</div>
										</div>
										<div class="">
											<div class="form-floating m-1">
												<select class="form-select" id="B_b" aria-label="Property Code">
													<?php echo opt_propertytype();?>
												</select>
												<label for="B_b">Property Code</label>
											</div>
										</div>
										<div class="">
											<div class="form-floating m-1">
												<select class="form-select" id="B_c" aria-label="Property Class">
													<?php echo opt_propertyclass();?>
												</select>
												<label for="B_c">Property Class</label>
											</div>
										</div>
										<div class="">
											<div class="form-floating m-1">
												<select class="form-select" id="B_d" aria-label="Location">
													<?php echo opt_locationcity();?>
												</select>
												<label for="B_d">Location</label>
											</div>
										</div>
										<div class="" style="display: none;">
											<?php 
												//this elements id is B_sort
												$tablefieldtoshow_arr = [
													array('field' => 'listtypecode', 'name' => 'Listing Type'),
									                array('field' => 'proptypecode', 'name' => 'Property Type'),
									                array('field' => 'propclasscode', 'name' => 'Property Class'),
									                array('field' => 'loccitycode', 'name' => 'Location')
									                
									            ];
												echo create_sortselect($tablefieldtoshow_arr);
											?>
										</div>
										<div class="m-1">
											<button id="B_find" type="button" class="btn btn-warning px-3" style="height: 58px;" ><i class="fa fa-search"></i></button>
										</div>
								</div>
							</div>


							<!-- Catalogue Result-->
							<div id="load_here" class="card-body p-4">

							</div>
						</div>	

					</div>
				</div>
				<?php echo sideadsfooter_tag();?>
			</div>
		</div>
	</main>

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

	<!-- Modal edit listing -->
	<div id="edit_ads" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalBasicLabel">Edit Ads</h5>
		        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
		      </div>
		      <div class="modal-body">
		      		<div id="">
						<p class="mt-2">Edit your property ads here...</p>
						<div class="row px-4">
							<div class="col-sm-6">
									<div class="form-floating mb-3" style="display: none;">
										<input type="number" class="form-control" id="C_id" readonly>
										<label for="C_id">ID</label>
									</div>
									<div class="form-floating mb-3">
										<select class="form-select" id="C_a" aria-label="Floating label select example">
											<?php echo opt_listingtype("","Choose");?>
										</select>
										<label for="C_a">Listing Type Code</label>
									</div>
									<div class="form-floating mb-3">
										<select class="form-select" id="C_b" aria-label="Floating label select example">
											<?php echo opt_listingname_listingkey("","Choose",$userdata_arr['usercode']);?>
										</select>
										<label for="C_b">Listing Code</label>
									</div>
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="C_c" placeholder="Ads Title">
										<label for="C_c">Ads Title</label>
									</div>
									<div class="form-floating mb-3">
										<textarea class="form-control" placeholder="Ads Description" id="C_d" style="height: 200px"></textarea>
										<label for="C_d">Ads Description (optional)</label>
									</div>
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="C_j" placeholder="Tags">
										<label for="C_j">Tags</label>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-floating mb-3">
										<input type="number" class="form-control" id="C_e" placeholder="Price">
										<label for="C_e">Price</label>
									</div>
									<div class="form-floating mb-3">
										<input type="number" class="form-control" id="C_f" placeholder="Security Deposit">
										<label for="C_f">Security Deposit (If for rent)</label>
									</div>

									<div class="form-floating mb-3">
										<select class="form-select" id="C_g" aria-label="Floating label select example">
											<?php echo opt_mincontract("","Choose");?>
										</select>
										<label for="C_g">Minimum Contract (If for rent)</label>
									</div>

									<div class="form-floating mb-3">
										<input type="number" class="form-control" id="C_h" placeholder="Down Payment">
										<label for="C_h">Down Payment (If for sale)</label>
									</div>
									
									<div class="form-floating mb-3">
										<textarea class="form-control" placeholder="Payment Terms" id="C_i" style="height: 100px"></textarea>
										<label for="C_i">Payment Terms</label>
									</div>

									<div class="d-flex flex-row-reverse">
										<button id="C_butt" type="button" class="btn btn-info bg-col1 border-0 text-white">
											<i class="fa fa-star me-2"></i>Update
										</button>
									</div>
							</div>
						</div>
					</div>
		      </div>
		    </div>
		</div>
	</div>


	<?php echo error_tag();?>
	<script type="text/javascript">
		var htmltbname = "<?php echo $htmltbname;?>";
		var htmlpage = "<?php echo $htmlpage;?>";
		var keyvalue = "<?php echo $keyvalue;?>";
		var ucode = "<?php echo $ucode;?>";
		var lkey = "<?php echo $lkey;?>";
		var currucode = "<?php echo $currucode;?>";
		
		loaderon();
		window.addEventListener("load", function(){
			check_value_and_disable("B_b","B_c");
			check_value_and_disable_onchange("B_b","B_c");
			loadboxesbykey();
			getcurrentusersstarswithid(currucode);
			loadkeyvalue(keyvalue);
			loaderoff();
		});


		function loadboxesbykey(){
			if(ucode == "" && lkey == ""){
				getserchval3(htmltbname,"","",pagenumcurrent,htmlpage);
			}else{
				getserchval7(htmltbname,"","",pagenumcurrent,htmlpage,ucode,lkey);
			}
		}

		function loadkeyvalue(value){
			if(value != ""){
				$("#A_b").val(value).change();
			}
		}

		function onoff_ads(id,what){
			//alert(id);
			$("#err").load("router.php",{
				onoff_ads_id: id,
			    onoff_ads_what: what
			});
		}

		

		

		function getserchval3(htmltbname,searchdata,sort,page,htmlpage){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("router.php",{
			      load_table3_htmltbname: htmltbname,
			      load_table3_searchdata: searchdata,
			      load_table3_sort: sort,
			      load_table3_page: page,
			      load_table3_htmlpage: htmlpage
			});
		}

		function getserchval7(htmltbname,searchdata,sort,page,htmlpage,ucode,lkey){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("router.php",{
			      load_table7_htmltbname: htmltbname,
			      load_table7_searchdata: searchdata,
			      load_table7_sort: sort,
			      load_table7_page: page,
			      load_table7_htmlpage: htmlpage,
			      load_table7_ucode: ucode,
			      load_table7_lkey: lkey
			});
		}

		function getfind(){
			let a = $("#B_a").val();
			let b = $("#B_b").val();
			let c = $("#B_c").val();
			let d = $("#B_d").val();

			let tx_a = "";
			let tx_b = "";
			let tx_c = "";
			let tx_d = "";

			if(a != ""){
				tx_a = $("#B_a option:selected").text();
			}
			if(b != ""){
				tx_b = $("#B_b option:selected").text();
			}
			if(c != ""){
				tx_c = $("#B_c option:selected").text();
			}
			if(d != ""){
				tx_d = $("#B_d option:selected").text();
			}
			
			let data = '{"test":[{"nm_0":"'+a+'", "nm_1":"'+b+'","nm_2":"'+c+'","nm_3":"'+d+'"},{"tx_0":"'+tx_a+'", "tx_1":"'+tx_b+'","tx_2":"'+tx_c+'","tx_3":"'+tx_d+'"}]}';
			let sort = $("#B_sort").val();
			getserchval3(htmltbname,data,sort,pagenumcurrent,htmlpage);
		}

		function editme_loadval(id,a,b,c,d,e,f,g,h,i,j){
			$("#C_id").val(id); //
			$("#C_a").val(a).change(); // listing typecode
			$("#C_b").val(b).change(); // listing code
			$("#C_c").val(filterSymbols(c,"yes")); // ads title
			$("#C_d").val(filterSymbols(d,"yes")); // ads desc
			$("#C_e").val(e); // price
			$("#C_f").val(f); // secdep
			$("#C_g").val(g); // mincon
			$("#C_h").val(h); // down
			$("#C_i").val(filterSymbols(i,"yes")); // paymentterms
			$("#C_j").val(filterSymbols(j,"yes")); // tags
		}

		$("#A_butt").on("click",function(){
			create_new_record();
		});

		$("#A_butt2").on("click",function(){
			create_new_record("back");
			//window.history.back();
		});

		function create_new_record(what=1){
			loaderon();
			let usercode = "<?php echo $userdata_arr['usercode'];?>";
			let id = "";
			let a = $("#A_a").val();
			let b = $("#A_b").val();
			let c = filterSymbols($("#A_c").val());
			let d = filterSymbols($("#A_d").val());
			let e = $("#A_e").val();
			let f = $("#A_f").val();
			let g = $("#A_g").val();
			let h = $("#A_h").val();
			let i = filterSymbols($("#A_i").val());
			let j = filterSymbols($("#A_j").val());
			
			if(a == "" || b == "" || c == "" || e == "" || g == "" || j == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				const data = '{ "id":"'+id+'" , "a":"'+a+'" , "b":"'+b+'" , "c":"'+c+'" , "d":"'+d+'" , "e":"'+e+'" , "f":"'+f+'" , "g":"'+g+'" , "h":"'+h+'" , "i":"'+i+'" , "j":"'+j+'" , "usercode":"'+usercode+'" }';
				$("#err").load("router.php",{
					save_ads_data: data,
					save_ads_what: what
			    });
			}	
		}




		$("#B_find").on("click",function(){
			pagenumcurrent = 1;
			getfind();
		});

		$("#C_butt").on("click",function(){
			loaderon();
			let usercode = "<?php echo $userdata_arr['usercode'];?>";
			let id = $("#C_id").val();
			let a = $("#C_a").val();
			let b = $("#C_b").val();
			let c = filterSymbols($("#C_c").val());
			let d = filterSymbols($("#C_d").val());
			let e = $("#C_e").val();
			let f = $("#C_f").val();
			let g = $("#C_g").val();
			let h = $("#C_h").val();
			let i = filterSymbols($("#C_i").val());
			let j = filterSymbols($("#C_j").val());
			let what = 1;
			if(a == "" || b == "" || c == "" || e == "" || g == "" || j == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				const data = '{ "id":"'+id+'" , "a":"'+a+'" , "b":"'+b+'" , "c":"'+c+'" , "d":"'+d+'" , "e":"'+e+'" , "f":"'+f+'" , "g":"'+g+'" , "h":"'+h+'" , "i":"'+i+'" , "j":"'+j+'" , "usercode":"'+usercode+'" }';
				$("#err").load("router.php",{
					save_ads_data: data,
					save_ads_what: what
			    });
			}
			
		});

		function getcurrentusersstarswithid(usercode){
			$("#load_stars_here").load("router.php",{
				load_stars_usercode: usercode
			});
		}
		function onoff_stars(starid,adsid){
			getcurrentusersstarswithid(currucode);
			if(starid == 0){
				if(lateststraridavailable == "none"){
					$("#err").append(errmsg("info","Ooops!","No available stars to assign...")); 
				}else{
					bindstrarandads(currucode,lateststraridavailable,adsid);
				}
			}else{
				unbindstrarandads(currucode,adsid);
			}
		}

		function lateststrarid(id){
			if(id == 0 || id == null){
				lateststraridavailable = "none";
			}else{
				lateststraridavailable = id;
			}
		}
		function bindstrarandads(usercode,starid,adsid){
			$("#err").load("router.php",{
				bindstrarandads_ucode: usercode,
				bindstrarandads_strid: starid,
				bindstrarandads_adsid: adsid
			});
		}
		function unbindstrarandads(usercode,adsid){
			$("#err").load("router.php",{
				unbindstrarandads_ucode: usercode,
				unbindstrarandads_adsid: adsid
			});
		}
	</script>
</body>
</html>