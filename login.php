<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";

$msg2 = error_tag();
if(isset($_GET['admin'])){
	$isadmin = 1;
}else{
	$isadmin = 0;
}

if(isset($_GET['success'])){
	$msg2 = error_tag(msgoutme("success","Hi!","You may now log in..."));
}

if(isset($_GET['failed'])){
	$msg2 = error_tag(msgoutme("danger","Ooops!","Pls try to register again..."));
}


$display = "none";
if(ifhasemailverificationpending() == 1){
	$display = "";
}

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('LoginHTML');?>
	<?php echo head_tag($mainpath);?>
</head>
<body>
	<?php echo loader_tag();?>
	<main class="">
		<div class="container-fluid" style="height: 100vh;">
				<div class="row h-100">
					<div class="col-md-6 p-0 bg-light" style="overflow: hidden;">
						<div class="h-100 w-100">
							<?php echo sideadslogin_tag();?>
							
						</div>
					</div>
					<div class="col-md-6 p-0 bg-transparent">
						<div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
							<div class="maxw400 align-self-center m-auto p-2">
									<br>
									<!-- login welcome -->
									<?php echo cfg::get('loginwelcomeHTML');?>

									<!-- Forgot password -->
									<div class="showhideform" id="form_forgot" style="display: none;">
										<p class="mb-1 pb-0">Forgot your password?</p>
										<div class="form-floating mb-2">
											<input type="email" class="form-control" id="F_email" placeholder="name@example.com">
											<label for="F_email">Email address</label>
										</div>
										<div class="form-floating mb-2">
											<input type="text" class="form-control" id="F_lname" placeholder="Last name">
											<label for="F_lname">Last name</label>
										</div>
										<div class="form-floating mb-2">
											<input type="text" class="form-control" id="F_fname" placeholder="First name">
											<label for="F_fname">First name</label>
										</div>
										<button id="F_butt" type="button" class="btn btn-info bg-col1 border-0 text-white w-100">Reset Password</button>
										
										<br><br>
										<p class="mb-1 pb-0">Already have an account?</p>
										<button type="button" class="formclick btn btn-info bg-col1 border-0 text-white w-100" data="L">Log In</button>
										
										<br><br>
										<p class="mb-1 pb-0">Not yet registered?</p>
										<button type="button" class="formclick btn btn-info bg-col1 border-0 text-white w-100 mb-3" data="S">Create an Account</button>
										<button type="button" onclick="goBack();" class="btn btn-info bg-col1 border-0 text-white w-100" >Go Back</button>
									</div>

									<!-- Log In -->
									<div class="showhideform" id="form_login" style="display: ;">
										<p class="mb-1 pb-0">Login to your account.</p>
										<div class="form-floating mb-2">
											<input type="email" class="form-control" id="L_email" placeholder="name@example.com">
											<label for="L_email">Email address</label>
										</div>
										<div class="form-floating mb-2">
											<input type="password" class="form-control" id="L_pass" placeholder="Password">
											<label for="L_pass">Password</label>
										</div>
										<div class="d-flex justify-content-between mb-0">
											<p class="small"><a href="#" class="formclick link-secondary" data="F" >Forgot Password?</a></p>
										</div>
										<button id="L_butt" type="button" class="btn btn-info bg-col1 border-0 text-white w-100">Log In</button>
										<br><br><br>
										<p class="mb-1 pb-0">Not yet registered?</p>
										<button type="button" class="formclick btn btn-info bg-col1 border-0 text-white w-100 mb-3" data="S">Create an Account</button>
										<button type="button" onclick="goBack();" class="btn btn-info bg-col1 border-0 text-white w-100" >Go Back</button>
										<br>
										<div class="d-flex justify-content-center">
										    <button onclick="resendverification();" class="btn btn-link text-secondary" style="display: <?php echo $display;?>;">Resend Email verificaion code</button>
										</div>
									</div>

									<!-- Sign In -->
									<div class="showhideform" id="form_signin" style="display: none;">
										<p class="mb-1 pb-0">Create an account.</p>
										<div class="form-floating mb-2">
											<input type="email" class="form-control" id="S_email" placeholder="name@example.com">
											<label for="S_email">Email address</label>
										</div>
										<div class="form-floating mb-2">
											<input type="text" class="form-control" id="S_lname" placeholder="Last name">
											<label for="S_lname">Last name</label>
										</div>
										<div class="form-floating mb-2">
											<input type="text" class="form-control" id="S_fname" placeholder="First name">
											<label for="S_fname">First name</label>
										</div>
										<div class="form-floating mb-2">
											<input type="password" class="form-control" id="S_pass" placeholder="Password">
											<label for="S_pass">Password</label>
										</div>
										<div class="form-floating mb-2">
											<input type="password" class="form-control" id="S_repass" placeholder="Re Enter Password">
											<label for="S_repass">Re Enter Password</label>
										</div>
										<button id="S_butt" type="button" class="btn btn-info bg-col1 border-0 text-white w-100">Create an Account</button>

										<br><br>
										<p class="mb-1 pb-0">Already have an account?</p>
										<button type="button" class="formclick btn btn-info bg-col1 border-0 text-white w-100 mb-3" data="L">Log In</button>
										<button type="button" onclick="goBack();" class="btn btn-info bg-col1 border-0 text-white w-100" >Go Back</button>
									</div>

									<!-- Log In Admin -->
									<div class="showhideform" id="form_login_admin" style="display: none;">
										<p class="mb-1 pb-0">Administrators's Login.</p>
										<div class="form-floating mb-2">
											<input type="text" class="form-control" id="A_un" placeholder="Username">
											<label for="A_un">Username</label>
										</div>
										<div class="form-floating mb-2">
											<input type="password" class="form-control" id="A_ps" placeholder="Password">
											<label for="A_ps">Password</label>
										</div>
										<button id="A_butt" type="button" class="btn btn-danger text-white w-100">Admin Log In</button>
									</div>
									<br>
									<br>
									<!-- login copyright -->
									<?php echo cfg::get('logincopyrightHTML');?>
							</div>
						</div>
					</div>
				</div>
			
		</div>
	</main>
	<?php echo $msg2;?>
	<script type="text/javascript">
		//use this function to show loader animation
		loaderon();
		window.addEventListener("load", function(){
			//use this function to hide loader animation
			loaderoff();
		});



			
			//show hide the forms by clicking Log In, Forgot Password? and Sign In
			$(".formclick").on("click",function() {
				let dis = $(this).attr("data");
				$(".showhideform").slideUp("fast");
				switch(dis) {
					case "F":
						$("#form_forgot").slideDown("slow");
					break;
					case "L":
						$("#form_login").slideDown("slow");
					break;
					case "S":
						$("#form_signin").slideDown("slow");
					break;
				}
			});

			$("#L_butt").on("click",function() {
				loaderon();
				let L_email = $("#L_email").val();
				let L_pass = $("#L_pass").val();
				$("#err").load("router.php",{
					user_login_L_email: L_email,
					user_login_L_pass: L_pass
				});
			});

			//button going to admin page
			$("#A_butt").on("click",function() {
				loaderon();
				let A_un = $("#A_un").val();
				let A_ps = $("#A_ps").val();
				$("#err").load("router.php",{
					admin_login_A_un: A_un,
					admin_login_A_ps: A_ps
				});
			});

			let isadmin = <?php echo $isadmin;?>;
			if(isadmin){
				$(".showhideform").slideUp("fast");
				$("#form_login_admin").slideDown("slow");
			}


			$("#S_butt").on("click",function() {
				loaderon();
				let S_email = $("#S_email").val();
				let S_lname = $("#S_lname").val();
				let S_fname = $("#S_fname").val();
				let S_pass = $("#S_pass").val();
				let S_repass = $("#S_repass").val();

				$("#err").load("router.php",{
					user_signin_S_email: S_email,
					user_signin_S_lname: S_lname,
					user_signin_S_fname: S_fname,
					user_signin_S_pass: S_pass,
					user_signin_S_repass: S_repass
				});
			});

			$("#F_butt").on("click",function() {
				loaderon();
				let F_email = $("#F_email").val();
				let F_lname = $("#F_lname").val();
				let F_fname = $("#F_fname").val();

				$("#err").load("router.php",{
					user_forgot_F_email: F_email,
					user_forgot_F_lname: F_lname,
					user_forgot_F_fname: F_fname
				});
			});

		

	</script>
</body>
</html>

