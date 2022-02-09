<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data();
checkiflog($userdata_arr);

$htmltbname = "b_ads";
$htmlpage = "inquiries.php";
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo cfg::get('InquiriesHTML');?>
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

						<!-- Catalogue -->
						<div class="card">

							<!-- Catalogue Result-->
							<div class="card-body p-4">
								<h4>My Inquiries</h4>
								<div class="row">
									<div class="col-sm-4">
										<ul class="list-group text-left">
											<li onclick="" class="list-group-item list-group-item-info bg-col1 text-white">
												<div class="d-flex">
													<div class="align-middle align-self-center flex-grow-1 fs-5">My Clients</div>
												</div>
											</li>
											<li onclick="" class="list-group-item">
												<br>
												<div class="d-flex">
													<div class="align-middle align-self-center">
														<div class="input-group mb-3">
															<input id="word" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="input-group-button-right">
															<button id="find_names" type="button" class="btn btn-warning" id="input-group-button-right"><i class="fa fa-search"></i></button>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input mychk" type="checkbox" value="" id="par2" checked="">
														  <label class="form-check-label" for="par2">Lead</label>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input mychk" type="checkbox" value="" id="par1">
														  <label class="form-check-label" for="par1">Keep</label>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input mychk" type="checkbox" value="" id="par3">
														  <label class="form-check-label" for="par3">Blacklist</label>
														</div>
														<div class="form-check form-check-inline">
														  <input class="form-check-input mychk" type="checkbox" value="" id="par4">
														  <label class="form-check-label" for="par4">Asnwered</label>
														</div>
													</div>
												</div>
												<br>
											</li>
										</ul>
										<br>
										<ul id="loadclienthere" class="list-group text-left">
												
										</ul>
									</div>
									<div class="col-sm-8">
										<!-- Chat box -->
										<div class="card">
											<div class="card-body">
												<div id="loadclientproperty" class="d-flex mb-3">
													<i class="fa fa-2x fa-user me-2 align-middle align-self-center text-secondary"></i>
													<div class="align-middle align-self-center flex-grow-1">
														<span class="">Client</span>
													</div>

												</div>
												<div id="loadclientmessages" class="border bg-light p-3 mb-3" style="max-height: 500px; overflow: hidden; overflow-y: auto;">
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	

					</div>
				</div>
				<?php echo sideadsfooter_tag();?>
			</div>
		</div>
	</main>

	<!-- Modal add notes -->
	<div id="add_notes" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalBasicLabel">Add Notes</h5>
		        <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button>
		      </div>
		      <div class="modal-body">
		      	<div id="loadagentsnotes" class="form-floating mb-3">
					<!-- <textarea class="form-control messges" data=12 placeholder="Your notes" id="A_details" style="height: 200px"></textarea>
					<label for="A_details">Your notes</label> -->
				</div>
		      </div>
		      <div class="modal-footer">
		        <button onclick="updatenotes();" type="button" class="btn btn-info bg-col1 text-white border-0">Update Notes</button>
		      </div>
		    </div>
		</div>
	</div>



	<?php echo privatemessage_tag();?>

	<?php echo error_tag();?>
	<script type="text/javascript">
		loaderon();
		window.addEventListener("load", function(){
			loadclienthere();
			changeshowhide();
			loaderoff();
		});
		

		function loadclienthere(){
			loaderon();
			let word = $('#word').val();
			let par1 = "";
			let par2 = "";
			let par3 = "";
			let par4 = "show";

			if ($('#par1').prop('checked')) {
				par1 = "Keep";
			}
			if ($('#par2').prop('checked')) {
				par2 = "Lead";
			}
			if ($('#par3').prop('checked')) {
				par3 = "Blacklist";
			}
			if ($('#par4').prop('checked')) {
				par4 = "hide";
			}

			$("#loadclienthere").load("router.php",{
				load_client_here_word: word,
				load_client_here_p1: par1,
				load_client_here_p2: par2,
				load_client_here_p3: par3,
				load_client_here_p4: par4
			});
		}

		function loadclientproperty(email,id=0){
			$("#loadclientproperty").load("router.php",{
				load_client_property: email
			});
			loadclientmessages(email);
			if(id != 0){
				loadagentsnotes(id);
			}
		}

		function loadclientmessages(email){
			$("#loadclientmessages").load("router.php",{
				load_client_messages: email
			});
		}
		function changeshowhidecheck(id,sh){
			$("#err").load("router.php",{
				change_show_hide_check_id: id,
				change_show_hide_check_sh: sh
			});
		}
		
		function changeshowhide(){
			$(".showhidecheck").on("click",function(){
				let dis = $(this).is(":checked");
	            let disdata = $(this).attr("data");
	            if(dis === true){
	            	changeshowhidecheck(disdata,"show");
	            }else{
	            	changeshowhidecheck(disdata,"hide");
	            }
			});
		}
		function updatenotes(){
			let txt = $(".messges").val();
			let id = $(".messges").attr("data");
			txt = filterSymbols(txt);
			$("#err").load("router.php",{
				update_notes_id: id,
				update_notes_txt: txt
			});
		}
		function loadagentsnotes(id){
			loaderon();
			$("#loadagentsnotes").load("router.php",{
				load_agents_notes: id
			});
		}

		$(".mychk").on("click",function(){
			loadclienthere();
			loadclientproperty("");
		});
		$("#find_names").on("click",function(){
			loadclienthere();
			loadclientproperty("");
		});

	</script>
</body>
</html>

