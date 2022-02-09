<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data();
checkiflog($userdata_arr);
$memberucode = $userdata_arr['usercode'];
$memberinfo = getOne("memberinfo","a_accounts","usercode",$memberucode);
$memberlicense = getOne("memberlicense","a_accounts","usercode",$memberucode);
$memberabout = getOne("memberabout","a_accounts","usercode",$memberucode);
$fname = $userdata_arr['memberfname']." ".$userdata_arr['memberlname'];
$memberviber = getOne("memberviber","a_accounts","usercode",$memberucode);
$memberlink = getOne("memberlink","a_accounts","usercode",$memberucode);


$dislink = cfg::get('server_url')."/".$linkname."?".$memberlink;
if($memberlink == ""){
	$buttonlink = "";
}else{
	$buttonlink = "<button type='button' onclick='copydis(`$dislink`); loadMyURL(`$dislink`,`blank`);' class='btn btn-sm btn-warning'><i class='fa fa-chevron-right'></i> Copy and Goto My WebLink</button>";
}

$display = "none";
if(ifhasemailverificationpending() == 1){
	$display = "";
}




?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('ProfileHTML');?>
	<?php echo head_tag($mainpath);?>
</head>
<body class="backcolor">
	<?php echo loader_tag();?>
	<?php echo topnav_tag();?>
	<div class="offsettop"></div>
	<!-- Main -->
	<main class="maxw1080 m-auto">
		<div class="container-fluid">
			<div class="row ">
				<div class="col-lg-9">
					<div class="card mb-4">
						<div class="card-body p-4">
							<h4>My Account Profile</h4>
							<div class="row">
								<div class="col-md-6">
									<!-- Fullname and contact -->
									<div class="card mb-3">
										<div class="card-header bg-col1 text-white">
									   		<div class="fs-5">Change Name and Contact</div>
										</div>
										<div class="card-body">
									    	<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_fn" placeholder="First Name" value="<?php echo $userdata_arr['memberfname']?>">
												<label for="A_fn">First name</label>
											</div>
											<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_ln" placeholder="Last Name" value="<?php echo $userdata_arr['memberlname']?>">
												<label for="A_ln">Last Name</label>
											</div>
											<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_ph" placeholder="Mobile Number" value="<?php echo $userdata_arr['membercellno']?>">
												<label for="A_ph">Mobile Number</label>
											</div>

											<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_d" placeholder="Viber Number" value="<?php echo $memberviber;?>">
												<label for="A_d">Viber Number</label>
											</div>

											<div class="form-floating mb-3">
											  <select class="form-select" id="A_a" aria-label="Floating label select example">
											    <option selected="" value="" >Select Here</option>
											    <option value="Owner">Owner</option>
											    <option value="Broker">Broker</option>
											  </select>
											  <label for="A_a">Member's Info</label>
											</div>

											<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_b" placeholder="Your License Number" value="<?php echo $memberlicense;?>" readonly="">
												<label for="A_b">Your License Number as a Broker</label>
											</div>

											<div class="form-floating mb-3">
											  <textarea class="form-control" placeholder="Leave a comment here" id="A_c" style="height: 200px"><?php echo $memberabout;?></textarea>
											  <label for="A_c">About Me</label>
											</div>

											<div class="form-floating mb-3">
												<input type="text" class="form-control" id="A_e" placeholder="My Weblink Name" value="<?php echo $memberlink;?>">
												<label for="A_e">My Weblink Name</label>
											</div>
											<div class="form-floating mb-3">
												<?php echo $buttonlink;?>
											</div>
											

											<div class="d-flex flex-row-reverse">
												<button id="A_butt" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="me-2 fa fa-save"></i>Update</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">

									<!-- Picture -->
									<div class="card mb-3">
										<div class="card-header bg-col1 text-white">
									   		<div class="fs-5">Change Profile Picture</div>
										</div>
										<div class="card-body">
									    	<div class="form-floating mb-3">
												<small>Upload Photo</small>
												<form id="dropzone3" action="upload.php" class="dropzone text-center mb-3">
												</form>
											</div>
											<div class="d-flex flex-row-reverse">
										    	<button id="D_butt" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="me-2 fa fa-save"></i>Upload</button>
										    </div>
										</div>
									</div>

									<!-- Change Password -->	
									<div class="card mb-3">
										<div class="card-header bg-col1 text-white">
									   		<div class="fs-5">Change Password</div>
										</div>
										<div class="card-body">
									    	<div class="form-floating mb-3">
												<input type="password" class="form-control" id="B_nps" placeholder="New Password">
												<label for="B_nps">New Password</label>
											</div>
											<div class="form-floating mb-3">
												<input type="password" class="form-control" id="B_rps" placeholder="Re-Enter New Password">
												<label for="B_rps">Re-Enter New Password</label>
											</div>
											<div class="form-floating mb-3">
												<input type="password" class="form-control" id="B_ops" placeholder="Old Password">
												<label for="B_ops">Old Password</label>
											</div>
											<div class="d-flex flex-row-reverse">
										    	<button id="B_butt" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="me-2 fa fa-save"></i>Update</button>
										    	<input type="checkbox" class="btn-check" id="B_showpass" autocomplete="">
										    	<label class="btn btn-info bg-col1 border-0 m-1 text-white" for="B_showpass"><i class="fa fa-eye"></i></label>
										    	<!-- <button id="B_showpass" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="fa fa-eye"></i></button> -->
										    </div>
										</div>
									</div>
								
									<!-- Email -->
									<div class="card mb-3">
										<div class="card-header bg-col1 text-white">
									   		<div class="fs-5">Change Email Address</div>
										</div>
										<div class="card-body">
									    	<div class="form-floating mb-3">
												<input type="text" class="form-control" id="C_em" placeholder="Email">
												<label for="C_em">Email</label>
											</div>
											<div class="form-floating mb-3">
												<input type="password" class="form-control" id="C_ps" placeholder="Password">
												<label for="C_ps">Password</label>
											</div>
											<div class="d-flex flex-row-reverse">
										    	<button id="C_butt" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="me-2 fa fa-save"></i>Update</button>
										    	<input type="checkbox" class="btn-check" id="C_showpass" autocomplete="">
										    	<label class="btn btn-info bg-col1 border-0 m-1 text-white" for="C_showpass"><i class="fa fa-eye"></i></label>
										    	<!-- <button id="C_showpass" class="btn btn-info bg-col1 border-0 m-1 text-white"><i class="fa fa-eye"></i></button> -->
										    </div>
										    <div class="d-flex justify-content-center">
										    	<button onclick="resendverification();" class="btn btn-link text-secondary" style="display: <?php echo $display;?>;">Resend Email verificaion code</button>
										    </div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					<div class="card mb-4">
						<div class="card-body p-4">
							<div class="row">
								<div id="load_history" class="col-md-12">
									
								</div>
							</div>
						</div>
					</div>


				</div>
				<!-- Ads -->
				<?php echo sideadsfooter_tag();?>
			</div>
		</div>
	</main>

	<?php echo privatemessage_tag();?>

	<?php echo error_tag();?>
	<script type="text/javascript">
		Dropzone.autoDiscover = false;
		loaderon();
		var selectedmemberinfo = "<?php echo $memberinfo;?>";
		var usercode = "<?php echo $memberucode;?>";
		var fullname = "<?php echo $fname;?>";
		window.addEventListener("load", function(){
			change_select_val("A_a",selectedmemberinfo);
			load_history(usercode,fullname);
			loaderoff();
		});
		$("#A_a").on("change",function(){
			let dis = $(this).val();
			if(dis == "Broker"){
				$("#A_b").attr("readonly", false); 
			}else{
				$("#A_b").attr("readonly", true); 
				$("#A_b").val(""); 
			}
		});
		//Fullname and contact
		$("#A_butt").on("click",function(){
			let a = $("#A_fn").val();
			let b = $("#A_ln").val();
			let c = $("#A_ph").val();
			//added
			let A_a = $("#A_a").val();
			let A_b = $("#A_b").val();
			let A_c = $("#A_c").val();
			let A_d = $("#A_d").val();
			let A_e = $("#A_e").val();
			const data = [a, b, c,A_a, A_b, A_c, A_d, A_e];
			saveprofiledata("namecontact",data);
		});
		//Change Password
		$("#B_butt").on("click",function(){
			let a = $("#B_nps").val();
			let b = $("#B_rps").val();
			let c = $("#B_ops").val();
			const data = [a, b, c];
			saveprofiledata("pass",data);
		});
		//Email
		$("#C_butt").on("click",function(){
			let a = $("#C_em").val();
			let b = $("#C_ps").val();
			const data = [a, b];
			saveprofiledata("email",data);
		});
		$("#B_showpass").on("click",function(){
			let dis = $(this).is(":checked");
			if(dis === true){
				$("#B_nps").attr("type","text");
				$("#B_rps").attr("type","text");
				$("#B_ops").attr("type","text");
			}else{
				$("#B_nps").attr("type","password");
				$("#B_rps").attr("type","password");
				$("#B_ops").attr("type","password");
			}
		});
		$("#C_showpass").on("click",function(){
			let dis = $(this).is(":checked");
			if(dis === true){
				$("#C_ps").attr("type","text");
			}else{
				$("#C_ps").attr("type","password");
			}
		});
		
			

		function load_history(usercode,fullname){
			$("#load_history").load("router.php",{
				load_history_ucode: usercode,
				load_history_fname: fullname
			});
		}


		$("#D_butt").on("click",function(){
			loaderon();

			myDZ3.on("sending", function(file, xhr, formData) {
				formData.append("myDZ3",usercode);
			});

			myDZ3.on("complete", function(file) {
				
			})
			
			myDZ3.on("success", function (file, response) {
				console.log(response);
				if(response !== ""){
					$("#err").append(errmsg("info","Ooops!",response));
				}
			});

			myDZ3.on("error", function (file, error, xhr) {
			});

			if (myDZ3.files != "") {
		        myDZ3.processQueue();
		        loaderoff();
		    } else {
				$("#err").append(errmsg("info","Attention!","No files need to upload. Pls select one file...")); 
				loaderoff(); 
		    }
		});

		let myDZ3 = new Dropzone("#dropzone3", {
		    autoProcessQueue : false,
		    acceptedFiles: "image/jpeg",
		    maxFiles: 1,
		    maxFilesize: 3, // MB
		    parallelUploads: 2, 
		    createImageThumbnails: true,
		    addRemoveLinks: true,
		    dictFileTooBig: "File is to big ({{filesize}}mb). Max allowed file size is {{maxFilesize}}mb.",
		    dictInvalidFileType: "Invalid File Type.",
		    dictMaxFilesExceeded: "Only {{maxFiles}} files are allowed.",
		    dictDefaultMessage: "Drop 1 Photos with file size limited to 3mb..."
		});
	</script>
</body>
</html>

