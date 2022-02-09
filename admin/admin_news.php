<?php
$mainpath = "../data/";
include_once $mainpath."myphp.php";
$userdata_arr = get_login_data_admin();
checkiflog($userdata_arr,"../");

$showhide = "";
$A_recno = "";
$A_title = "";
$A_desc = "";
if(isset($_GET['id'])){
	$disid = $_GET['id'];
	$showhide = "show";
	$row = getRow("*","c_news","recno",$disid);
	if(is_array($row)){
        $A_recno = $row[0]['recno'];
        $A_title = filterSymbols($row[0]['title'],"output");
        $A_desc = filterSymbols($row[0]['description'],"output");
    }
}else{
	$showhide = "hide";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrator News</title>
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
	  										<h5><i class="me-3 fa fa-clipboard-list"></i>Create News</h5>
										</button>
									</h2>
									<div id="flush-collapseOne" class="accordion-collapse collapse <?php echo $showhide;?>" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlush">
										<div class="accordion-body p-0">
											<p class="p-2">Create your news here...</p>
											<div class="row px-4">
												<div class="col-sm-12">
														<div class="form-floating mb-3" style="display: none;">
															<input type="text" class="form-control" id="A_id" placeholder="News Id" readonly value="<?php echo $A_recno;?>">
															<label for="A_id">News Id</label>
														</div>
														
														<div class="form-floating mb-3">
															<input type="text" class="form-control" id="A_a" placeholder="News Title" value="<?php echo $A_title;?>">
															<label for="A_a">News Title</label>
														</div>
														<div class="form-floating mb-3">
															<textarea class="form-control" placeholder="News" id="A_b" style="height: 200px"><?php echo $A_desc;?></textarea>
															<label for="A_b">News</label>
														</div>
														<div>
															<div class="d-flex flex-row-reverse">
																<button id="A_save" type="button" class="btn btn-info bg-col1 border-0 text-white m-1">
																	<i class="fa fa-star me-2"></i>Save News
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
								load
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php echo error_tag();?>
	<script type="text/javascript">
		loaderon();
		window.addEventListener("load", function(){
			loadnews("","","",pagenumcurrent,"admin_news.php");
			loaderoff();
		});
		function loadnews(htmltbname,searchdata,sort,page,htmlpage){
			loaderon();
			pagenumcurrent = page;
			$("#load_here").load("../router.php",{
			      load_news_page: page,
			      load_news_htmlpage: htmlpage
			});	
		}

		function get_data_val_for_A(){
			let id = $("#A_id").val();
			let a = filterSymbols($("#A_a").val());
			let b = filterSymbols($("#A_b").val());

			if(a == "" || b == ""){
				$("#err").append(errmsg("info","Attention!","Missing entries...")); 
				loaderoff(); 
			}else{
				const data = '{ "id":"'+id+'" , "a":"'+a+'" , "b":"'+b+'" }';
				$("#err").load("../router.php",{
					save_news_data: data
			    });
			}
			
		}

		$("#A_save").on("click",function(){
			get_data_val_for_A();
		});
	</script>
</body>
</html>

