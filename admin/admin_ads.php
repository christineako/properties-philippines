<?php
$mainpath = "../data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data_admin();
checkiflog($userdata_arr,"../");

$disid = "";
$showhide = "";
$noneshow = "";
$noneshowrev = "";
$A_recno = "";
$A_file = "";
$A_title = "";
$A_desc = "";
$A_adsurl = "";

$rundis = "";
if(isset($_GET['id'])){
	$disid = $_GET['id'];
	$showhide = "show";
	$noneshow = "";
	$noneshowrev = "none";
	$row = getRow("*","c_side_ads","recno",$disid);
    if(is_array($row)){
        $A_recno = $row[0]['recno'];
        $A_file = $row[0]['filename'];
        $A_seenby = $row[0]['seenby'];
        $A_title = filterSymbols($row[0]['title'],"output");
        $A_desc = filterSymbols($row[0]['description'],"output");
        $A_adsurl = $row[0]['ads_url'];
        $rundis = "$('#A_c').val('$A_seenby').change();";
    }
}else{
	$showhide = "hide";
	$noneshow = "none";
	$noneshowrev = "";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrator Ads</title>
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


					<!-- Create Side Ads -->
					<div class="card mb-4">
						<div class="card-body">
							<div class="accordion accordion-flush" id="accordionFlush">
								<div class="accordion-item">
									<h2 class="accordion-header" id="flush-headingOne">
										<button class="accordion-button collapsed py-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
	  										<h5><i class="me-3 fa fa-clipboard-list"></i>Create New Side Ads</h5>
										</button>
									</h2>
									<div id="flush-collapseOne" class="accordion-collapse collapse <?php echo $showhide;?>" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
										<div class="accordion-body p-0">
											<p class="p-2">Create your side ads here...</p>
											<div class="row px-4">
												<div class="col-sm-6">
														<div class="form-floating mb-3" style="display: none;">
															<input type="text" class="form-control" id="A_id" placeholder="Ads Id" readonly value="<?php echo $A_recno;?>">
															<label for="A_id">Ads Id</label>
														</div>
														<div class="form-floating mb-3" style="display: none;">
															<input type="text" class="form-control" id="A_file" placeholder="Ads filename" readonly value="<?php echo $A_file;?>">
															<label for="A_file">Ads filename</label>
														</div>
														<div class="form-floating mb-3">
															<input type="text" class="form-control" id="A_a" placeholder="Ads Title" value="<?php echo $A_title;?>">
															<label for="A_a">Ads Title</label>
														</div>
														<div class="form-floating mb-3">
															<textarea maxlength="200" class="form-control" placeholder="Ads Description" id="A_b" style="height: 200px"><?php echo $A_desc;?></textarea>
															<label for="A_b">Ads Description</label>
														</div>
														<div class="form-floating mb-3">
															<select class="form-select" id="A_c" aria-label="Seen by">
																<option selected>All</option>
																<option>Members</option>
																<option>Non-Members</option>
															</select>
															<label for="A_c">Seen by</label>
														</div>
														<div class="form-floating mb-3">
															<input type="text" class="form-control" id="A_d" placeholder="Ads URL" value="<?php echo $A_adsurl;?>">
															<label for="A_d">Ads URL Ex: <span class="text-danger">https://www.site.com/</span> (optional)</label>
														</div>
														<div style="display: <?php echo $noneshow;?>;">
															<div class="d-flex flex-row-reverse">
																<button id="A_save" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-star me-2"></i>Save Data
																</button>
																<button id="A_reset1" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-times me-2"></i>Cancel
																</button>
															</div>
														</div>
												</div>
												<div class="col-sm-6">
														
														<small>Upload Photo</small>
														<form id="dropzone1" action="../upload.php" class="dropzone text-center mb-3">
        												</form>
        												<div style="display: <?php echo $noneshow;?>;">
															<div class="d-flex flex-row-reverse">
																<button id="A_reup" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-star me-2"></i>Re-Upload Photo
																</button>
																<button id="A_reset2" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-times me-2"></i>Cancel
																</button>
															</div>
														</div>
														<div style="display: <?php echo $noneshowrev;?>;">
															<div class="d-flex flex-row-reverse">
																<button id="A_butt" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-star me-2"></i>Create
																</button>
															</div>
														</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Content -->
					<div class="card mt-4">
						<div id="load_here" class="card-body p-4" style="overflow: auto;">
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php echo error_tag();?>
	<script type="text/javascript">
		Dropzone.autoDiscover = false;
		loaderon();
		window.addEventListener("load", function(){
			loadads(1);
			<?php echo $rundis;?>
			loaderoff();
		});
		function onoff_side_ads(id,what){
			//alert(id);
			$("#err").load("../router.php",{
				onoff_side_ads_id: id,
			    onoff_side_ads_what: what
			});
		}

		function delsideadd(id,photopath){
			loaderon();
			$("#err").load("../router.php",{
			      del_sideads_id: id,
			      del_sideads_path: photopath
			});	
		}
		function loadads(page){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("../router.php",{
			      load_sideads_page: page
			});	
		}

		function get_data_val_for_A(listingkey){
			let id = $("#A_id").val();
			let file = $("#A_file").val();
			let a = filterSymbols($("#A_a").val());
			let b = filterSymbols($("#A_b").val());
			let c = $("#A_c").val();
			let d = $("#A_d").val();

			if(file == ""){
				file = listingkey;
			}
			if(a == "" || b == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				const data = '{ "id":"'+id+'" , "a":"'+a+'" , "b":"'+b+'" , "c":"'+c+'" , "d":"'+d+'" , "listingkey":"'+file+'" }';
				$("#err").load("../upload.php",{
					save_admit_ads_data: data
			    });
			}
			
		}
		
		$("#A_save").on("click",function(){
			get_data_val_for_A("");
		});

		$("#A_butt").on("click",function(){
			listingkey = Date.now();
			loaderon();
			let id = $("#A_id").val();
			let disfile = $("#A_file").val();
			let a = $("#A_a").val();
			let b = $("#A_b").val();
			let c = $("#A_c").val();
			let d = $("#A_d").val();

			if(disfile != ""){
				listingkey = disfile;
			}

			myDZ3.on("sending", function(file, xhr, formData) {
				formData.append("myDZ3",listingkey);
				//formData.append("myDZ1_data", get_data_val_for_A());
			});

			myDZ3.on("complete", function(file) {
				myDZ3.removeAllFiles(true);
			   //$("#err").append(errmsg("info","Good!","File uploaded..."));
			})
			
			myDZ3.on("success", function (file, response) {
				console.log(response);
				if(response !== ""){
					$("#err").append(errmsg("info","Ooops!",response));
				}
			});

			myDZ3.on("error", function (file, error, xhr) {
				//$("#err").append(errmsg("danger","Ooops!","File error..."));
			});



			
			if(a == "" || b == "" ){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				if (myDZ3.files != "") {
					get_data_val_for_A(listingkey);
			        myDZ3.processQueue();
			        loaderoff();
			    } else {
					$("#err").append(errmsg("info","Attention!","No files need to upload. Pls select one file...")); 
					loaderoff(); 
			    }
			}
		});

		$("#A_reup").on("click",function(){
			listingkey = Date.now();
			loaderon();
			
			let disfile = $("#A_file").val();
			
			if(disfile != ""){
				listingkey = disfile;
			}

			myDZ3.on("sending", function(file, xhr, formData) {
				formData.append("myDZ3",listingkey);
				//formData.append("myDZ1_data", get_data_val_for_A());
			});

			myDZ3.on("complete", function(file) {
				myDZ3.removeAllFiles(true);
			   //$("#err").append(errmsg("info","Good!","File uploaded..."));
			})
			
			myDZ3.on("success", function (file, response) {
				console.log(response);
				if(response !== ""){
					$("#err").append(errmsg("info","Ooops!",response));
				}
			});

			myDZ3.on("error", function (file, error, xhr) {
				//$("#err").append(errmsg("danger","Ooops!","File error..."));
			});

			if (myDZ3.files != "") {
		        myDZ3.processQueue();
		        loaderoff();
		    } else {
				$("#err").append(errmsg("info","Attention!","No files need to upload. Pls select one file...")); 
				loaderoff(); 
		    }
			
		});
		
		$("#A_reset1,#A_reset2").on("click",function(){
			loadMyURL("admin_ads.php");
		});

		let myDZ3 = new Dropzone("#dropzone1", {
		    autoProcessQueue : false,
		    acceptedFiles: "image/jpeg",
		    maxFiles: 1,
		    maxFilesize: 3, // MB
		    parallelUploads: 5, 
		    createImageThumbnails: true,
		    addRemoveLinks: true,
		    dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb.",
		    dictInvalidFileType: "Invalid File Type.",
		    dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed.",
		    dictDefaultMessage: "Drop 1 Photo with file size limited to 3mb..."
		});
	</script>
</body>
</html>

