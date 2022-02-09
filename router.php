<?php
$mainpath = "data/";
include_once $mainpath."myphp.php";

/////////////////////////////////////////////////////////////////////////////////
//ADMIN CREATE DUMMY FOLDERS
if(isset($_POST['cretedummy'])){
	echo get_dummy_list();
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//ADMIN EMAIL DIS SEND EMAIL TO MEMBERS
if(isset($_POST['emaildis_data'])){
	$data = $_POST['emaildis_data'];
	$data = json_decode($data, true);
	$email = $data['a'];
	$subject = filterSymbols($data['b']);
	$message = filterSymbols($data['c']);
	$today = date_create()->format('Y-m-d h:i:s');

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo msgoutme("warning","Ooops!","Please provide a valid email address.");
		echo loaderoff();
		exit();
    }
    $message .= $message." <br>";
    $message .= "Date sent: ".$today." <br>";
	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
	$header .= "Reply-To: ".$emailserver2." \r\n";
	$header .= "Content-type: text/html \r\n";
	mail($email,$subject,$message,$header);
	mail($emailserver2,$subject,$message,$header);

	echo msgoutme("info","Message sent!","");
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//ADMIN GET USER LISTING AND ADS
if(isset($_POST['get_userlisting_usercode']) && isset($_POST['get_userlisting_page'])){
	$ucode = $_POST['get_userlisting_usercode'];
	$page = $_POST['get_userlisting_page'];
	echo load_liasting_and_ads_foradmin($ucode,$page);
	echo loaderoff();
	exit();
}



/////////////////////////////////////////////////////////////////////////////////
//EXPIRATION CHECK
if(isset($_POST['expirationcheck'])){
	$ucode = $_POST['expirationcheck'];
	echo expirationcehcker();
	echo loaderoff();
	exit();
}



/////////////////////////////////////////////////////////////////////////////////
//UNBINDING STAR ID AND ADS ID
if(isset($_POST['unbindstrarandads_ucode']) && isset($_POST['unbindstrarandads_adsid'])){
	$ucode = $_POST['unbindstrarandads_ucode'];
	$adsid = $_POST['unbindstrarandads_adsid'];
	echo unbindstrarandadsid($ucode,$adsid);
	echo rundisfunction("getcurrentusersstarswithid('$ucode');");
	echo rundisfunction("loadboxesbykey();");
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//BINDING STAR ID AND ADS ID
if(isset($_POST['bindstrarandads_ucode']) && isset($_POST['bindstrarandads_strid']) && isset($_POST['bindstrarandads_adsid'])){
	$ucode = $_POST['bindstrarandads_ucode'];
	$strid = $_POST['bindstrarandads_strid'];
	$adsid = $_POST['bindstrarandads_adsid'];
	echo bindstrarandadsid($ucode,$strid,$adsid);
	echo rundisfunction("getcurrentusersstarswithid('$ucode');");
	echo rundisfunction("loadboxesbykey();");
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//LOAD CURRENT STARS
if(isset($_POST['load_stars_usercode'])){
	$ucode = $_POST['load_stars_usercode'];
	echo loadcurrentstars($ucode);
	echo loaderoff();
	exit();
}








/////////////////////////////////////////////////////////////////////////////////
//ADMIN LOAD HISTORY
if(isset($_POST['load_history_ucode']) && isset($_POST['load_history_fname'])){
	$ucode = $_POST['load_history_ucode'];
	$fname = $_POST['load_history_fname'];
	echo loadhistory($ucode,$fname);
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//ADMIN AND USER LOAD NEWS
if(isset($_POST['load_news_page']) && isset($_POST['load_news_htmlpage'])){
	$page = $_POST['load_news_page'];
	$htmlpage = $_POST['load_news_htmlpage'];
	if(isset($_POST['load_news_what'])){
		$what = $_POST['load_news_what'];
		echo load_row_news($page,$htmlpage,$what);
	}else{
		echo load_row_news($page,$htmlpage);
	}
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//ADMIN SAVE NEWS
if(isset($_POST['save_news_data'])){
	$data = $_POST['save_news_data'];
	$data = json_decode($data, true);
	$id = $data['id'];//id
	$a = filterSymbols($data['a']);//filter //title
	$b = $data['b'];//filter //description

	if($id == ""){
		$fields = "(title,description)";
		$values = "('$a','$b')";
		$insert = insertDT("c_news",$fields,$values);
		if($insert == 1){
			echo msgoutme("info","Good!","News successfully posted.");
			echo rundisfunction('reset_dis("#A_a,#A_b,#A_id");');
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong, $insert...");
		}
	}else{
		$fieldsandvalues = "title = '$a', description = '$b'";
		$update = updateDT("c_news",$fieldsandvalues,"recno",$id);
		if($update == 1){
			echo msgoutme("info","Good!","News successfully updated.");
			echo rundisfunction('reset_dis("#A_a,#A_b,#A_id");');
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong, $update...");
		}
	}
	echo loaderoff();
	exit();
}





/////////////////////////////////////////////////////////////////////////////////
//SAVE MEMBERSHIP AND STARS
if(isset($_POST['load_D_ucode']) && isset($_POST['load_D_priority']) && isset($_POST['load_D_type']) && isset($_POST['load_D_stars'])){
	$ucode = $_POST['load_D_ucode'];
	$priority = $_POST['load_D_priority'];
	$type = $_POST['load_D_type'];
	$stars = $_POST['load_D_stars'];

	if($ucode == ""){
		echo msgoutme("info","Ooops!","Please select a user.");
		echo loaderoff();
		exit();
	}
	echo record_expiration($ucode,$priority,$type,$stars);
	echo "
		<script type='text/javascript'>
			getfindval();
			reset_dis(`#D_ucode,#D_priority,#D_type,#D_stars`);
			$(`#D_ucode_label`).html(`User Code`);
		</script>
	";
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//LOAD MEMBERS LIST
if(isset($_POST['load_memberslist'])){
	$find = $_POST['load_memberslist'];
	echo getallmemberslist($find);
	echo loaderoff();
	exit();
}





/////////////////////////////////////////////////////////////////////////////////
//RESEND EMEIL VERIFICATION CODE
if(isset($_POST['load_agents_notes'])){
	$id = $_POST['load_agents_notes'];
	$get_agentnotes = filterSymbols(getOne("agent_notes","b_clients","recno",$id),"output");
	echo "
		<textarea class='form-control messges' data=$id placeholder='Your notes' id='A_details' style='height: 200px'>$get_agentnotes</textarea>
		<label for='A_details'>Your notes</label>
	";
	
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//ADD / UPDATE NOTES
if(isset($_POST['update_notes_id']) && isset($_POST['update_notes_txt'])){
	$id = $_POST['update_notes_id'];
	$text = $_POST['update_notes_txt'];
	$update = updateDT("b_clients","agent_notes = '{$text}'","recno",$id);
	if($update == 1){
		echo msgoutme("info","Good!","Notes successfully recorded.");
	}else{
		echo msgoutme("info","Ooops!","Please try it again...");
	}
	echo loaderoff();
	exit();
}




/////////////////////////////////////////////////////////////////////////////////
//LOAD FEATURED UNITS
if(isset($_POST['load_featured_unitA']) && isset($_POST['load_featured_unitA_loc'])){
	$what = $_POST['load_featured_unitA'];
	$loc = $_POST['load_featured_unitA_loc'];
	$line = "";
	$out = "";
	$title = "";
	switch ($what) {
		case 'Gold':
			$title = "Ads From A Featured Broker";
			$goldusersql = "
				SELECT usercode 
				FROM a_accounts
				WHERE membertype = 'Gold'
				ORDER BY RAND()
				LIMIT 1
			";
			$row_one = selectQ($goldusersql);
			if(is_array($row_one)){
				$one_gold_user = $row_one[0]['usercode'];
				$line = "
						AND b_listing.usercode = '$one_gold_user' 
						ORDER BY RAND()
						LIMIT 20
					";
			}else{
				$line = "
						AND a_accounts.membertype = 'Gold' 
						ORDER BY RAND()
						LIMIT 20
					";
			}
		break;
		case 'Silver':
			$title = "Featured Units";
			$line = "
						AND a_accounts.membertype = 'Silver' 
						AND b_listing.loccitycode LIKE '%$loc%' 
						ORDER BY RAND()
						LIMIT 10
					";
		break;
		case 'Priority':
			$title = "Featured Units";
			$line = "
						AND a_accounts.priority = '1' 
						ORDER BY RAND()
						LIMIT 10
					";
		break;
	}

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

		    b_listing.listingdescription,
		    b_listing.buildingname,
		    b_listing.propaddress,
		    b_listing.proptypecode,
		    b_listing.propclasscode,
		    b_listing.loccitycode,
		    b_listing.usercode,
		    b_listing.listingkeys,
		    b_listing.listingtag,

		    a_locationcity.loccitycode,
		    a_locationcity.loccitydesc,

		    a_listingtype.listtypecode,
		    a_listingtype.listtypedesc,

		    a_accounts.usercode,
		    a_accounts.membertype,
		    a_accounts.priority

		    FROM ((((b_ads
		      INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
		      INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
		      INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)
		      INNER JOIN a_accounts ON b_listing.usercode=a_accounts.usercode)
		      

		    WHERE b_ads.status = 'on'
		    $line
		    
		";
	$row = selectQ($sql);
  	if(is_array($row)){
    	foreach ($row as $r) {
    		  $Aa = $r['recno'];
		      $Ab = $r['adscode'];
		      $Ac = $r['adstitle'];
		      $Ad = $r['adsdesc'];
		      $Ae = $r['listingcode'];
		      $Af = $r['listtypecode'];
		      $Ag = $r['price'];
		      $Ag1 = $r['securitydeposit'];
		      $Ag2 = $r['mincontract'];
		      $Ag3 = $r['downpayment'];
		      $Ah = $r['paymentterm'];
		      $Ai = $r['status'];
		    
		      //$b = $r['listingcode'];
		      $c = $r['listingdescription'];
		      $d = $r['buildingname'];
		      $e = $r['propaddress'];
		      $f = $r['proptypecode'];
		      $g = $r['propclasscode'];
		      $h = $r['loccitycode'];
		      $i = $r['usercode'];
		      $j = $r['listingkeys'];
		      $k = $r['listingtag'];

		      $loc = $r['loccitydesc'];
		      $listype = $r['listtypedesc'];

		      //image
		      $itemspath = cfg::get('itempath')."$i/$j/";
		      $firstFile = scandir($itemspath);
		      if(isset($firstFile[2])){
		        if(file_exists($itemspath.$firstFile[2])){
		          $imgpath = $itemspath.$firstFile[2];
		        }else{
		          $imgpath = cfg::get('mainpath')."img/def.png";
		        }
		      }else{
		        $imgpath = cfg::get('mainpath')."img/def.png";
		      }

    		$out .= create_cataloguebox($Aa,$imgpath,$loc,formatPeso($Ag),$listype,$f);
    	}
    	echo "
				<div class='card mb-4'>
					<div class='card-body'>
						<h5 class='card-title'>$title</h5>
						<div class='d-flex' style='overflow: hidden; overflow-x: auto;'>
							$out
						</div>
					</div>
				</div>
    		";
    }
	echo loaderoff();
	exit();
}	





/////////////////////////////////////////////////////////////////////////////////
//RESEND EMEIL VERIFICATION CODE
if(isset($_POST['trigger_email_ver'])){
	$email = $_SESSION["email_data"];
	$subject = $_SESSION["email_subj"];
	$message = $_SESSION["email_msgs"];
	$header = $_SESSION["email_head"];
	mail($email,$subject,$message,$header);
	echo msgoutme("info","Important!","Please check your email.");
	echo loaderoff();
	exit();
}	


/////////////////////////////////////////////////////////////////////////////////
//DEL SIDE ADS
if(isset($_POST['del_sideads_id']) && isset($_POST['del_sideads_path'])){
	$id = $_POST['del_sideads_id'];
	$path = $_POST['del_sideads_path'];
	$path = substr($path, 3);
	$sql = "
		DELETE
		FROM c_side_ads
		WHERE recno = $id
	";
	$del = sendQ($sql);
	if($del == 1){
		unlink($path);
		echo msgoutme("success","Deleted!","Poster successfully deleted");
		echo rundisfunction('loadads(1);');
	}else{
		echo msgoutme("info","Ooops!","Unable to delete...");
	}
	echo loaderoff();
	exit();
}



/////////////////////////////////////////////////////////////////////////////////
//ADMIN LOAD SIDE ADS
if(isset($_POST['load_sideads_page'])){
	$page = $_POST['load_sideads_page'];
	echo load_row_sideads($page);
	echo loaderoff();
	exit();
}	






/////////////////////////////////////////////////////////////////////////////////
//CHANGE STATUS OF AN EMAIL
if(isset($_POST['change_show_hide_check_id']) && isset($_POST['change_show_hide_check_sh'])){
	$id = $_POST['change_show_hide_check_id'];
	$what = $_POST['change_show_hide_check_sh'];
	$sql = "
		UPDATE b_clients 
		SET showhide = '$what' 
		WHERE recno = '$id'
	";
	$row = sendQ($sql);
	echo loaderoff();
	exit();
}	





/////////////////////////////////////////////////////////////////////////////////
//LOAD CLIENT MESSAGES
if(isset($_POST['load_client_messages'])){
	$email = $_POST['load_client_messages'];

	$userdata_arr = get_login_data();
	$curuser = $userdata_arr['usercode'];

	$out = "";
	$sql = "
		SELECT 
			recno,
			clientcode,
			clientlname,
			clientfname,
			clientemail,
			clientcellno,
			clientremarks,
			clientmsg,
			agentcode,
			agent_notes,
			showhide,
			clientstatus,
			dateinserted
		FROM b_clients
		WHERE agentcode = '$curuser'
		AND clientemail = '$email'
		ORDER BY dateinserted DESC
	";
	$row = selectQ($sql);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$b = $r['clientcode'];
			$c = $r['clientfname']." ".$r['clientlname'];
			$d = $r['clientemail'];
			$e = $r['clientcellno'];
			$f = $r['clientremarks'];
			$g = $r['clientmsg'];
			
			$h = $r['agentcode'];
			$i = $r['agent_notes'];
			$j = $r['showhide'];
			$k = $r['clientstatus'];
			$l = timeAgo2($r['dateinserted']);

			$checkbox = "";
			if($j == "show"){
				$checkbox = "checked";
			}


			$out .= "
				<div class='mb-3 d-flex flex-row'>
					<div class='bg-white border p-3 rounded w-100'>
						<div class='form-check form-check-inline w-100'>
							<input class='form-check-input showhidecheck' type='checkbox' id='ch_$a' data=$a $checkbox>
							<label class='form-check-label' for='ch_$a'>
								<span class='fw-bold'>$f</span>
							</label>
								<br>
								<span>$g</span><br><br>
								<small class='text-muted'>Posted by: $c $e <br>$l</small><br>
							<hr>
							<p class=''>$i</p>
							<button type='button' class='btn btn-sm btn-link float-end text-secondary' data-bs-toggle='modal' data-bs-target='#add_notes'>Add Notes</button>
						</div>
					</div>
				</div>
			";
		}
		$out .= rundisfunction('changeshowhide();');
		echo $out;
	}else{
		echo msgoutme("info","Ooops!","Click on a name on the left to show client inquiries.");
	}
	echo loaderoff();
	exit();
}	

/////////////////////////////////////////////////////////////////////////////////
//CHANGE STATUS OF AN EMAIL
if(isset($_POST['change_status_of_dis_email_email']) && isset($_POST['change_status_of_dis_email_what'])){
	$email = $_POST['change_status_of_dis_email_email'];
	$what = $_POST['change_status_of_dis_email_what'];

	$userdata_arr = get_login_data();
	$curuser = $userdata_arr['usercode'];

	$out = "";
	$sql = "
		UPDATE b_clients 
		SET clientstatus = '$what' 
		WHERE agentcode = '$curuser'
		AND clientemail = '$email'
	";
	$row = sendQ($sql);
	echo loaderoff();
	exit();
}	




/////////////////////////////////////////////////////////////////////////////////
//LOAD CLIENT PROPERTY
if(isset($_POST['load_client_property'])){
	$email = $_POST['load_client_property'];
	//echo $email;

	$userdata_arr = get_login_data();
	$curuser = $userdata_arr['usercode'];

	$out = "";
	$sql = "
		SELECT 
			recno,
			clientcode,
			clientlname,
			clientfname,
			clientemail,
			clientcellno,
			clientremarks,
			clientmsg,
			agentcode,
			agent_notes,
			showhide,
			clientstatus,
			dateinserted,
			COUNT(*) as dis
		FROM b_clients
		WHERE agentcode = '$curuser'
		AND clientemail = '$email'
		GROUP BY clientemail
	";
	$row = selectQ($sql);
	if(is_array($row)){
		$a = $row[0]['recno'];
		$stat = $row[0]['clientstatus'];
		$email = $row[0]['clientemail'];
		$fullname = $row[0]['clientfname']." ".$row[0]['clientlname'];
		$contact = $row[0]['clientcellno'];


		$sel1 = "";
		$sel2 = "";
		$sel3 = "";
		switch ($stat) {
			case 'Keep':
				$color = "success";
				$sel1 = "selected";
			break;
			case 'Lead':
				$color = "secondary";
				$sel2 = "selected";
			break;
			case 'Blacklist':
				$color = "dark";
				$sel3 = "selected";
			break;
		}

		$out = "
			<i class='fa fa-2x fa-user me-2 align-middle align-self-center text-$color'></i>
			<div class='align-middle align-self-center flex-grow-1'>
				<span class=''>$fullname</span>
				<span class='text-muted ms-3'><i class='me-1 fa fa-envelope'></i> $email</span>
				<span class='text-muted ms-3'><i class='me-1 fa fa-phone'></i> $contact</span>
			</div>
			<div class='form-floating'>
			  <select onchange='changestatusofdisemail(`$email`);' class='form-select statval' id='statval' aria-label='Floating label select example'>
			    <option $sel1>Keep</option>
			    <option $sel2>Lead</option>
			    <option $sel3>Blacklist</option>
			  </select>
			  <label for='statval'>Status</label>
			</div>

		";
		echo $out;
	}else{
		echo "
			<i class='fa fa-2x fa-user me-2 align-middle align-self-center text-secondary'></i>
			<div class='align-middle align-self-center flex-grow-1'>
				<span>Client</span>
			</div>
		";
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//LOAD LIST OF CLIENT
if(isset($_POST['load_client_here_word']) && isset($_POST['load_client_here_p1']) && isset($_POST['load_client_here_p2']) && isset($_POST['load_client_here_p3']) && isset($_POST['load_client_here_p4'])){
	$word = $_POST['load_client_here_word'];
	$par1 = $_POST['load_client_here_p1'];
	$par2 = $_POST['load_client_here_p2'];
	$par3 = $_POST['load_client_here_p3'];
	$par4 = $_POST['load_client_here_p4'];

	$userdata_arr = get_login_data();
	$curuser = $userdata_arr['usercode'];

	$line = "";
	if($word != ""){
		$line = "AND ( clientlname LIKE '%$word%' OR clientfname LIKE '%$word%' OR clientemail LIKE '%$word%' OR clientcellno LIKE '%$word%')";
	}

	$out = "";
	$sql = "
		SELECT 
			recno,
			clientcode,
			clientlname,
			clientfname,
			clientemail,
			clientcellno,
			clientremarks,
			clientmsg,
			agentcode,
			agent_notes,
			showhide,
			clientstatus,
			dateinserted,
			COUNT(*) as dis
		FROM b_clients
		WHERE agentcode = '$curuser'
		$line
		AND (clientstatus = '$par1' OR clientstatus = '$par2' OR clientstatus = '$par3')
		AND showhide = '$par4'
		GROUP BY clientemail
		ORDER BY showhide ASC, clientstatus ASC, dateinserted ASC
	";

	$row = selectQ($sql);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$email = $r['clientemail'];
			$fullname = $r['clientfname']." ".$r['clientlname'];
			$stat = $r['clientstatus'];
			$showhide = $r['showhide'];
			$dis = $r['dis'];
			switch ($stat) {
				case 'Keep':
					$color = "success";
				break;
				case 'Lead':
					$color = "secondary";
				break;
				case 'Blacklist':
					$color = "dark";
				break;
			}
			if ($showhide == "hide") {
				$shohidehtml = "";
			}else{
				$shohidehtml = "<span class='badge bg-primary ms-2'>$dis</span>";
			}
			

			$out .= "
				<li onclick='loadclientproperty(`$email`,$a)' class='list-group-item text-secondary list-group-item-action'>
					<div class='d-flex'>
						<i class='fa fa-user me-2 align-middle align-self-center text-$color'></i>
						<span class='align-middle align-self-center flex-grow-1'>{$fullname} {$shohidehtml}</span>
						<span class='align-middle align-self-center'><i class='fa fa-caret-right'></i></span>
					</div>
				</li>
			";
		}
		echo $out;
	}else{
		echo msgoutme("info","Ooops!","No clients to show.");
	}
	echo loaderoff();
	exit();
}





/////////////////////////////////////////////////////////////////////////////////
//LOAD CATALOGUE IN DASHBOARD AND INDEX AND MEMBER PUBLIC PAGE
if(isset($_POST['load_table4_htmltbname']) && isset($_POST['load_table4_searchdata']) && isset($_POST['load_table4_sort']) && isset($_POST['load_table4_page']) && isset($_POST['load_table4_htmlpage']) && isset($_POST['load_table4_sort2']) && isset($_POST['load_table4_user'])){
	$load_table4_htmltbname = $_POST['load_table4_htmltbname'];
	$load_table4_searchdata = $_POST['load_table4_searchdata'];
	$load_table4_sort = $_POST['load_table4_sort'];
	$load_table4_page = $_POST['load_table4_page'];
	$load_table4_htmlpage = $_POST['load_table4_htmlpage'];
	$load_table4_sort2 = $_POST['load_table4_sort2'];
	$load_table4_user = $_POST['load_table4_user'];


	echo load_row_dashboard($load_table4_htmltbname,$load_table4_searchdata,$load_table4_sort,$load_table4_page,$load_table4_htmlpage,$load_table4_sort2,$load_table4_user);
	echo loaderoff();
	exit();
}	









/////////////////////////////////////////////////////////////////////////////////
//LOAD RANDOM POST
if(isset($_POST['load_random_data'])){
	$loc = $_POST['load_random_data'];
	$out = "";
	$sql = "
		SELECT 
			b_ads.recno,
			b_ads.adscode,
			b_ads.listingcode,
			b_ads.listtypecode,
			b_ads.price,
			b_ads.status,

			b_listing.listingkeys,
			b_listing.loccitycode,
			
			a_locationcity.loccitycode,
			a_locationcity.loccitydesc,

			a_listingtype.listtypecode,
			a_listingtype.listtypedesc

		FROM (((b_ads
			INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
			INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
			INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

		WHERE b_ads.status = 'on'
		AND a_locationcity.loccitycode = '$loc'
		ORDER BY RAND()
		LIMIT 10
	";
	$row = selectQ($sql);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$b = $r['adscode'];
			$c = $r['listingcode'];
			$d = formatPeso($r['price']);
			$e = $r['loccitydesc'];
			$f = $r['listtypedesc'];

			//image
		      $itemspath = cfg::get('itempath')."$b/$c/";
		      $firstFile = scandir($itemspath);
		      if(isset($firstFile[2])){
		        if(file_exists($itemspath.$firstFile[2])){
		          $imgpath = $itemspath.$firstFile[2];
		        }else{
		          $imgpath = cfg::get('mainpath')."img/def.png";
		        }
		      }else{
		        $imgpath = cfg::get('mainpath')."img/def.png";
		      }

			$out .= create_cataloguebox($a,$imgpath,$e,$d,$f);
		}
		echo "
			<div class='card mb-4'>
				<div class='card-body'>
					<h5 class='card-title'>Other properties nearby</h5>
					<div id='load_random_here' class='d-flex' style='overflow: hidden; overflow-x: auto;'>
						$out
					</div>
				</div>
			</div>
		";
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//LOAD RELATED POST
if(isset($_POST['load_related_id']) && isset($_POST['load_related_usercode'])){
	$id = $_POST['load_related_id'];
	$usercode = $_POST['load_related_usercode'];
	$out = "";
	$sql = "
		SELECT 
			b_ads.recno,
			b_ads.adscode,
			b_ads.listingcode,
			b_ads.listtypecode,
			b_ads.price,
			b_ads.status,

			b_listing.listingkeys,
			b_listing.loccitycode,
			
			a_locationcity.loccitycode,
			a_locationcity.loccitydesc,

			a_listingtype.listtypecode,
			a_listingtype.listtypedesc

		FROM (((b_ads
			INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
			INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
			INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

		WHERE b_ads.adscode = '$usercode'
		AND b_ads.status = 'on'
		AND b_ads.recno != $id
		ORDER BY b_ads.listtypecode, b_ads.price
	";
	$row = selectQ($sql);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$b = $r['adscode'];
			$c = $r['listingcode'];
			$d = formatPeso($r['price']);
			$e = $r['loccitydesc'];
			$f = $r['listtypedesc'];

			//image
		      $itemspath = cfg::get('itempath')."$b/$c/";
		      $firstFile = scandir($itemspath);
		      if(isset($firstFile[2])){
		        if(file_exists($itemspath.$firstFile[2])){
		          $imgpath = $itemspath.$firstFile[2];
		        }else{
		          $imgpath = cfg::get('mainpath')."img/def.png";
		        }
		      }else{
		        $imgpath = cfg::get('mainpath')."img/def.png";
		      }

			$out .= create_cataloguebox($a,$imgpath,$e,$d,$f);
		}
		echo "
			<div class='card mb-4' >
				<div class='card-body'>
					<h5 class='card-title'>Other properties</h5>
					<div class='d-flex' style='overflow: hidden; overflow-x: auto;'>
						$out
					</div>
				</div>
			</div>
		";
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//LOAD RELATED POST 2
if(isset($_POST['load_related_id2']) && isset($_POST['load_related_usercode2']) && isset($_POST['load_related_listingcode2'])){
	$id = $_POST['load_related_id2'];
	$usercode = $_POST['load_related_usercode2'];
	$listingcod = $_POST['load_related_listingcode2'];

	$out = "";
	$sql = "
		SELECT 
			b_ads.recno,
			b_ads.adscode,
			b_ads.listingcode,
			b_ads.listtypecode,
			b_ads.price,
			b_ads.status,

			b_listing.listingkeys,
			b_listing.loccitycode,
			b_listing.listingcode,

			a_locationcity.loccitycode,
			a_locationcity.loccitydesc,

			a_listingtype.listtypecode,
			a_listingtype.listtypedesc

		FROM (((b_ads
			INNER JOIN b_listing ON b_ads.listingcode=b_listing.listingkeys)
			INNER JOIN a_locationcity ON b_listing.loccitycode=a_locationcity.loccitycode)
			INNER JOIN a_listingtype ON b_ads.listtypecode=a_listingtype.listtypecode)

		WHERE b_ads.adscode = '$usercode'
		AND b_ads.status = 'on'
		AND b_listing.listingcode = '$listingcod'
		AND b_ads.recno != $id
		ORDER BY b_ads.listtypecode, b_ads.price
	";
	$row = selectQ($sql);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$b = $r['adscode'];
			$c = $r['listingkeys'];
			$d = formatPeso($r['price']);
			$e = $r['loccitydesc'];
			$f = $r['listtypedesc'];

			//image
		      $itemspath = cfg::get('itempath')."$b/$c/";
		      $firstFile = scandir($itemspath);
		      if(isset($firstFile[2])){
		        if(file_exists($itemspath.$firstFile[2])){
		          $imgpath = $itemspath.$firstFile[2];
		        }else{
		          $imgpath = cfg::get('mainpath')."img/def.png";
		        }
		      }else{
		        $imgpath = cfg::get('mainpath')."img/def.png";
		      }

			$out .= create_cataloguebox($a,$imgpath,$e,$d,$f);
		}
		echo "
			<div class='card mb-4'>
				<div  class='card-body'>
					<h5 class='card-title'>Other ads related to this property</h5>
					<div  class='d-flex' style='overflow: hidden; overflow-x: auto;'>
						$out
					</div>
				</div>
			</div>
		";
	}
	echo loaderoff();
	exit();
}





/////////////////////////////////////////////////////////////////////////////////
//SAVE CLIENT DATA
if(isset($_POST['save_inquire_data']) && isset($_POST['save_inquire_data2'])){
	$data = $_POST['save_inquire_data'];
	$data2 = $_POST['save_inquire_data2'];
	$data = json_decode($data, true);
	$a = filterSymbols($data['a']); //fname
	$b = filterSymbols($data['b']); //lname
	$c = $data['c']; //email
	$d = filterSymbols($data['d']); //contact
	$e = filterSymbols($data['e']); //remarks
	$f = filterSymbols($data['f']); //msg
	$clientcode = $b."_".time();

	$data2 = json_decode($data2, true);
	$ba = $data2['a']; //disid
	$bb = $data2['b']; //adstitle
	$bc = $data2['c']; //listing type
	$bd = formatPeso($data2['d']); //price
	$be = $data2['e']; //loc
	$bf = $data2['f']; //usercode
	$bg = $data2['g']; //listingcode

	$tagmsg = '
		<br><br>
		Link: <a class="text-secondary" href="details.php?id='.$ba.'">'.$bb.'</a><br>
		Listing Type: '.$bc.'<br>
		Price: '.$bd.'<br>
		Location: '.$be.'
	';

	if (!filter_var($c, FILTER_VALIDATE_EMAIL)) {
		echo msgoutme("warning","Ooops!","Please provide a valid email address.");
		echo loaderoff();
		exit();
    }

    //get agents emailadd
    $agentemail = getOne("email","a_accounts","usercode",$bf);
    $agentname = getOne("memberfname","a_accounts","usercode",$bf)." ".getOne("memberlname","a_accounts","usercode",$bf);

	$fields = "(clientcode,clientlname,clientfname,clientemail,clientcellno,clientremarks,clientmsg,clientstatus,agentcode)";
	$values = "('$clientcode','$b','$a','$c','$d','$e','$f $tagmsg','Lead','$bf')";
	$insert = insertDT("b_clients",$fields,$values);
	if($insert == 1){



		//email back to client
		$link = cfg::get('base_url')."/details.php?id=$ba";
    	$subject = "Listing information from Eastwoodcitycondo";
    	$message = "Good day $a $b,<br>";
    	$message .= "You inquired for the following listing...<br>";
    	$message .= "Link: <a href='$link'>$bb</a><br>";
    	$message .= "Listing Type: $bc<br>";
    	$message .= "Price: $bd<br>";
    	$message .= "Location: $be<br>";
    	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
		$header .= "Reply-To: ".$emailserver2." \r\n";
		$header .= "Content-type: text/html \r\n";
    	mail($c,$subject,$message,$header);

    	//email back to agent
		$link = cfg::get('base_url')."/details.php?id=$ba";
    	$subject = "You received a new inquiry at ".cfg::get('base_url');
    	$message = "<span style='font-size:30px'>Dear $agentname,</span><br>";
    	$message .= "<br>";
    	$message .= "Someone is interested in your property ads at ".cfg::get('base_url')."<br>";
    	$message .= "Please find the details of the inquiry below:<br>";
    	$message .= "<br>";
    	$message .= "Listing Code: $bg<br>";
    	$message .= "Ads Title: <a href='$link'>$bb</a><br>";
    	$message .= "Listing Type: $bc<br>";
    	$message .= "Price: $bd<br>";
    	$message .= "<br>";
    	$message .= "You may get in touch with your client at the provided contact information<br>";
    	$message .= "Name: $a $b<br>";
    	$message .= "Email: $c<br>";
    	$message .= "Contact: $d<br>";
    	$message .= "Remarks: $e<br>";
    	$message .= "Msg: $f<br>";
    	$message .= "<br>";
    	$message .= "<b>This is system generated. Please do not reply to this email</b><br>";
    	$message .= "<br>";
    	$message .= "Have a nice day!<br>";
    	$message .= "From ".cfg::get('companynameHTML')."<br>";
    	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
		$header .= "Reply-To: ".$emailserver2." \r\n";
		$header .= "Content-type: text/html \r\n";
    	mail($agentemail,$subject,$message,$header);


		echo rundisfunction('showsellercontact();');
		echo rundisfunction("reset_dis(`#A_a,#A_b,#A_c,#A_d,#A_e,#A_f`);");
		//echo msgoutme("success","Data Added!","Agent's contact number is now posted, pls call for faster transaction.");
	}else{
		echo msgoutme("info","Ooops!","Unable to save data...");
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//DEL ADS
if(isset($_POST['del_ads'])){
	$id = $_POST['del_ads'];
	$sql = "
		DELETE
		FROM b_ads
		WHERE recno = $id
		AND xy = 'x'
	";
	$del = sendQ($sql);
	if($del == 1){
		echo msgoutme("info","Deleted!","Ads deleted...");
		echo rundisfunction('getfind();');
	}else{
		echo msgoutme("info","Ooops!","Unable to delete, make sure you remove the star before you delete this item...");
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//ON OFF ADS
if(isset($_POST['onoff_ads_id']) && isset($_POST['onoff_ads_what'])){
	$id = $_POST['onoff_ads_id'];
	$what = $_POST['onoff_ads_what'];
	$update = updateDT("b_ads","status = '$what'","recno",$id);
	echo rundisfunction('getfind();');
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//ON OFF SIDE ADS
if(isset($_POST['onoff_side_ads_id']) && isset($_POST['onoff_side_ads_what'])){
	$id = $_POST['onoff_side_ads_id'];
	$what = $_POST['onoff_side_ads_what'];
	$update = updateDT("c_side_ads","status = '$what'","recno",$id);
	echo rundisfunction('loadads(1);');
	echo loaderoff();
	exit();
}




/////////////////////////////////////////////////////////////////////////////////
//SAVE ADS DATA
if(isset($_POST['save_ads_data']) && isset($_POST['save_ads_what'])){
	$data = $_POST['save_ads_data'];
	$what = $_POST['save_ads_what'];
	$data = json_decode($data, true);
	$id = $data['id']; //recno
	$a = filterSymbols($data['a']); //listtypecode
	$b = filterSymbols($data['b']); //listingcode
	$c = filterSymbols($data['c']); //adstitle
	$d = filterSymbols($data['d']); //adsdesc
	$e = filterSymbols($data['e']); //price
	$f = filterSymbols($data['f']); //securitydeposit
	$g = filterSymbols($data['g']); //mincontract
	$h = filterSymbols($data['h']); //downpayment
	$i = filterSymbols($data['i']); //paymentterm
	$j = filterSymbols($data['j']); //tags
	$usercode = $data['usercode']; //usercode
	$disdate = date("Y-m-d h:i:s");
	$userdata_arr = get_login_data();
	$loccitycode = "";
	$proptypecode = "";
	$price = formatPeso($e);

	//get proptype,loccity
	$sql = "
		SELECT *
		FROM b_listing
		WHERE usercode = '$usercode'
		AND listingkeys = '$b'
		LIMIT 1
	";
	$row = selectQ($sql);
  	if(is_array($row)){
  		$loccitycode = $row[0]['loccitycode'];
  		$proptypecode = $row[0]['proptypecode'];
  	}
 
	if($id == ""){
		$fields = "(adscode,adstitle,adsdesc,listingcode,listtypecode,price,securitydeposit,mincontract,downpayment,paymentterm,word_tags)";
		$values = "('$usercode','$c','$d','$b','$a','$e','$f','$g','$h','$i','$j')";
		$insert = insertDT("b_ads",$fields,$values);
		if($insert == 1){

			$S_lname = $userdata_arr['memberlname'];
			$S_fname = $userdata_arr['memberfname'];
			$S_email = $userdata_arr['email'];
			$S_cellno = $userdata_arr['membercellno'];

			$subject2 = "$S_fname $S_lname Created an Ads!";
	    	$message2 = "Name: $S_fname $S_lname<br>";
	    	$message2 .= "Email: $S_email<br>";
	    	$message2 .= "CellNo: $S_cellno<br>";
			$message2 .= "Listing Type: $a<br>";
			$message2 .= "Price: $price<br>";
	    	$message2 .= "Property Type: $proptypecode<br>";
	    	$message2 .= "Location: $loccitycode<br>";

	    	$header2 = "From: <inquire@eastwoodcitycondo.com> \r\n";
			$header2 .= "Reply-To: ".$S_email." \r\n";
			$header2 .= "Content-type: text/html \r\n";
	    	mail($emailserver2,$subject2,$message2,$header2);

			echo msgoutme("success","Good!","Your ads was created on ".$disdate);
			echo rundisfunction("reset_dis(`#A_a,#A_b,#A_c,#A_d,#A_e,#A_f,#A_g,#A_h,#A_i,#A_j`);getfind();");
			if($what == "back"){
				echo rundisfunction("window.history.back();");
			}
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong pls try again...");
		}
	}else{
		$fieldsandvalues = "
			adstitle = '$c',
			adsdesc = '$d',
			listingcode = '$b',
			listtypecode = '$a',
			price = '$e',
			securitydeposit = '$f',
			mincontract = '$g',
			downpayment = '$h',
			paymentterm = '$i',
			word_tags = '$j',
			dateinserted = '$disdate'
		";
		
		$update = updateDT("b_ads",$fieldsandvalues,"recno",$id);
		if($update == 1){
			echo msgoutme("success","Good!","Your Ads was updated on ".$disdate);
		//CINDY	echo msgoutme("success","Good!","Data updated...");
			echo rundisfunction("getfind();");
		}else{
			echo msgoutme("danger","Ooops!","Something went wrong pls try again...");
		}
	}
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//DEL DIS CURR PHOTO
if(isset($_POST['del_dis_photo'])){
	$path = $_POST['del_dis_photo'];
	unlink($path);
	echo msgoutme("info","Deleted!","File deleted...");
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//LOAD LISTING CURR PHOTO
if(isset($_POST['load_curr_photo'])){
	$id = $_POST['load_curr_photo'];
	$out = "";
	$row = getRow("recno,usercode,listingkeys","b_listing","recno",$id);
	$data = "";
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$i = $r['usercode'];
			$j = $r['listingkeys'];

			
			//image
		    $itemspath = cfg::get('itempath')."$i/$j/";
		    
		    if(!is_dir($itemspath)){
		    	mkdir($itemspath, 0777, true);
		    }


		    $firstFile = scandir($itemspath);
		    $count = count($firstFile);
		    for ($i=2; $i < $count; $i++) {
		    	$active = ""; 
		    	if($i == 2){
		    		$active = "active";
		    	}
		    	$data .= "
		    		<div class='carousel-item $active'>
		    			<img src='$itemspath{$firstFile[$i]}' class='d-block w-100' alt='Slide $i'>
		    			<div class='carousel-caption d-none d-sm-block'>
					        <button onclick='del_dis_photo(`$itemspath{$firstFile[$i]}`,$a);' type='button' class='btn btn-danger'><i class='fa fa-trash'></i></button>
					    </div>
		    			<!-- 
						<div class='position-relative mb-2'>
							<img src='$itemspath{$firstFile[$i]}' class='img-fluid' alt='img-fluid'>
							<button onclick='del_dis_photo(`$itemspath{$firstFile[$i]}`,$a);' type='button' class='position-absolute top-0 end-0 m-2 btn btn-outline-danger border-0'><i class='fa fa-trash'></i>
							</button>
						</div>
						-->
					</div>
				";
		    }

		    if(!isset($firstFile[2])){
		    	echo msgoutme("info","Ooops!","No current photo...");
		    }
		}
		echo "
			<div id='car4' class='carousel slide' data-bs-ride='carousel'>
			  <div class='carousel-inner'>
			    $data
			  </div>
			  <a class='carousel-control-prev' href='#car4' role='button' data-bs-slide='prev'>
			    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
			    <span class='visually-hidden'>Previous</span>
			  </a>
			  <a class='carousel-control-next' href='#car4' role='button' data-bs-slide='next'>
			    <span class='carousel-control-next-icon' aria-hidden='true'></span>
			    <span class='visually-hidden'>Next</span>
			  </a>
			</div>
		";



	}else{
		echo msgoutme("info","Ooops!","Nothing to show...");
	}
	echo loaderoff();
	exit();
}



/////////////////////////////////////////////////////////////////////////////////
//SAVE LISTING ITEMS
if(isset($_POST['save_listing_data_C'])){
	$data = $_POST['save_listing_data_C'];
	$data = json_decode($data, true);

	$id = $data['id']; //recno
	$a = filterSymbols($data['a']); //proptypecode
	$b = filterSymbols($data['b']); //propclasscode
	$c = filterSymbols($data['c']); //listingcode
	$d = filterSymbols($data['d']); //listingdescription
	$e = filterSymbols($data['e']); //loccitycode
	$f = filterSymbols($data['f']); //propaddress
	$g = filterSymbols($data['g']); //propaddress

	$fieldsandvalues = "
		proptypecode = '$a',
		propclasscode = '$b',
		listingcode = '$c',
		listingdescription = '$d',
		loccitycode = '$e', 
		propaddress = '$f',
		buildingname = '$g'
	";
	$update = updateDT("b_listing",$fieldsandvalues,"recno",$id);
	if($update == 1){
		echo msgoutme("success","Good!","Listing successfully created.");
		echo rundisfunction("getfind();");
	}else{
		echo msgoutme("danger","Ooops!","Something went wrong pls try again...");
	}
	echo loaderoff();
	exit();
}	



/////////////////////////////////////////////////////////////////////////////////
//DEL LISTING ITEMS
if(isset($_POST['del_id'])){
	$id = $_POST['del_id'];
	$row = getRow("usercode,listingkeys","b_listing","recno",$id);
	$i = $row[0]['usercode'];
	$j = $row[0]['listingkeys'];
    $foldertodelpath = cfg::get('itempath')."$i/$j/";
	$sql = "
		DELETE
		FROM b_listing
		WHERE recno = $id
	";
	$del = sendQ($sql);
	if($del == 1){
		echo msgoutme("success","Deleted!","Listing successfully deleted");
		echo rundisfunction('getfind();');
		array_map( 'unlink', array_filter((array) glob($foldertodelpath."*") ) );
		rmdir($foldertodelpath);
	}else{
		echo msgoutme("info","Ooops!","Unable to delete...");
	}
	echo loaderoff();
	exit();
}	

/////////////////////////////////////////////////////////////////////////////////
//LOAD LISTING ITEMS
if(isset($_POST['load_item_del_id'])){
	$id = $_POST['load_item_del_id'];
	$out = "";
	$row = getRow("*","b_listing","recno",$id);
	if(is_array($row)){
		foreach ($row as $r) {
			$a = $r['recno'];
			$b = $r['listingcode'];
			$c = $r['listingdescription'];
			$d = $r['buildingname'];
			$e = $r['propaddress'];
			$f = $r['proptypecode'];
			$g = $r['propclasscode'];
			$h = $r['loccitycode'];
			$i = $r['usercode'];
			$j = $r['listingkeys'];
			$k = $r['listingtag'];

			//image
		      $itemspath = cfg::get('itempath')."$i/$j/";
		      $firstFile = scandir($itemspath);
		      if(isset($firstFile[2])){
		        if(file_exists($itemspath.$firstFile[2])){
		          $imgpath = $itemspath.$firstFile[2];
		        }else{
		          $imgpath = cfg::get('mainpath')."img/def.png";
		        }
		      }else{
		        $imgpath = cfg::get('mainpath')."img/def.png";
		      }

			$out .= "
				<div class='modal-body'>
			      		<div>
							<ul class='list-group list-group-flush'>
							  <li class='list-group-item'>
							  	<img src='$imgpath' class='img-thumbnail' alt='img-thumbnail'>
							  </li>
							  <li class='list-group-item'>Listing Name: $b</li>
							  <li class='list-group-item'>Description: $c</li>
							</ul>
							<br>
						</div>
						<div class='alert alert-danger' role='alert'>
						  Are you sure you want to delete this item?
						</div>
			      </div>
			      <div class='modal-footer'>
			        <button onclick='delme($a);' type='button' class='btn btn-info bg-col1 text-white border-0' data-bs-dismiss='modal'>Delete</button>
			   </div>
			";
	    }
	    echo $out;
	}else{
		echo msgoutme("info","Ooops!","Nothing to show...");
	}
	echo loaderoff();
	exit();
}	



/////////////////////////////////////////////////////////////////////////////////
//LOAD ADS ITEMS
if(isset($_POST['load_table3_htmltbname']) && isset($_POST['load_table3_searchdata']) && isset($_POST['load_table3_sort']) && isset($_POST['load_table3_page']) && isset($_POST['load_table3_htmlpage'])){
	$load_table3_htmltbname = $_POST['load_table3_htmltbname'];
	$load_table3_searchdata = $_POST['load_table3_searchdata'];
	$load_table3_sort = $_POST['load_table3_sort'];
	$load_table3_page = $_POST['load_table3_page'];
	$load_table3_htmlpage = $_POST['load_table3_htmlpage'];
	echo load_row_ads($load_table3_htmltbname,$load_table3_searchdata,$load_table3_sort,$load_table3_page,$load_table3_htmlpage);
	echo loaderoff();
	exit();
}	

/////////////////////////////////////////////////////////////////////////////////
//LOAD PARTICULAR ADS ITEMS
if(isset($_POST['load_table7_htmltbname']) && isset($_POST['load_table7_searchdata']) && isset($_POST['load_table7_sort']) && isset($_POST['load_table7_page']) && isset($_POST['load_table7_htmlpage']) && isset($_POST['load_table7_ucode']) && isset($_POST['load_table7_lkey'])){
	$load_table7_htmltbname = $_POST['load_table7_htmltbname'];
	$load_table7_searchdata = $_POST['load_table7_searchdata'];
	$load_table7_sort = $_POST['load_table7_sort'];
	$load_table7_page = $_POST['load_table7_page'];
	$load_table7_htmlpage = $_POST['load_table7_htmlpage'];
	$load_table7_ucode = $_POST['load_table7_ucode'];
	$load_table7_lkey = $_POST['load_table7_lkey'];
	echo load_row_ads($load_table7_htmltbname,$load_table7_searchdata,$load_table7_sort,$load_table7_page,$load_table7_htmlpage,$load_table7_ucode,$load_table7_lkey);
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////
//LOAD LISTING ITEMS
if(isset($_POST['load_table2_htmltbname']) && isset($_POST['load_table2_searchdata']) && isset($_POST['load_table2_sort']) && isset($_POST['load_table2_page']) && isset($_POST['load_table2_htmlpage'])){
	$load_table2_htmltbname = $_POST['load_table2_htmltbname'];
	$load_table2_searchdata = $_POST['load_table2_searchdata'];
	$load_table2_sort = $_POST['load_table2_sort'];
	$load_table2_page = $_POST['load_table2_page'];
	$load_table2_htmlpage = $_POST['load_table2_htmlpage'];
	echo load_row_listing($load_table2_htmltbname,$load_table2_searchdata,$load_table2_sort,$load_table2_page,$load_table2_htmlpage);
	echo loaderoff();
	exit();
}	


/////////////////////////////////////////////////////////////////////////////////
//LOAD OPTIONS ITEMS IN SELECT PROPRTY CLASS
if(isset($_POST['load_items_in_select'])){
	$val = $_POST['load_items_in_select'];
	echo opt_propertyclass2('','Choose',$val);
	exit();
}	




/////////////////////////////////////////////////////////////////////////////////
//SAVE PROFILE DATA
if(isset($_POST['save_profile_what']) && isset($_POST['save_profile_data'])){
	$what = $_POST['save_profile_what'];
	$data = $_POST['save_profile_data'];
	$userdata_arr = get_login_data();
		//rundisfunction($functioname)
		//reset_dis("#A_fn,#A_ln,#A_ph");
		//reset_dis("#B_nps,#B_rps,#B_ops");
		//reset_dis("#C_em,#C_ps");

	switch ($what) {
		case 'namecontact':
			if($data[0] == "" || $data[1] == ""){
				echo msgoutme("warning","Ooops!","Missing data...");
				echo loaderoff();
				exit();
			}
			$data0 = filterSymbols($data[0]);
			$data1 = filterSymbols($data[1]);
			$data2 = filterSymbols($data[2]);
			//added
			$data3 = filterSymbols($data[3]);
			$data4 = filterSymbols($data[4]);
			$data5 = filterSymbols($data[5]);
			$data6 = filterSymbols($data[6]);
			$data7 = filterSymbols($data[7]);
			
			$fieldsandvalues = "
				memberfname = '{$data0}',
				memberlname = '{$data1}',
				membercellno = '{$data2}',
				memberinfo = '{$data3}',
				memberlicense = '{$data4}',
				memberabout = '{$data5}',
				memberviber = '{$data6}',
				memberlink = '{$data7}'
			";
			$update = updateDT("a_accounts",$fieldsandvalues,"usercode",$userdata_arr['usercode']);
			if($update == 1){
				reget_ses_data();
				echo msgoutme("info","Good!","Your account profile was successfully updated.");
				//echo rundisfunction('reset_dis("#A_fn,#A_ln,#A_ph")');
			}else{
				echo msgoutme("warning","Ooops!","Unable to update...");
			}
		break;
		case 'pass':
			if($data[0] == "" || $data[1] == "" || $data[2] == ""){
				echo msgoutme("warning","Ooops!","Missing data...");
				echo loaderoff();
				exit();
			}
			if($data[0] !== $data[1]){
				echo msgoutme("warning","Ooops!","Password mismatched.");
				echo loaderoff();
				exit();
			}

			$currpass = getOne("password","a_accounts","usercode",$userdata_arr['usercode']);
			if($currpass != ep($data[2])){
				echo msgoutme("warning","Ooops!","Old password is incorrect.");
				echo loaderoff();
				exit();
			}
			$newpass = ep($data[0]);
			$fieldsandvalues = "
				password = '$newpass'
			";
			$update = updateDT("a_accounts",$fieldsandvalues,"usercode",$userdata_arr['usercode']);
			if($update == 1){
				reget_ses_data();
				echo msgoutme("info","Good!","Password successfully updated.");
				echo rundisfunction('reset_dis("#B_nps,#B_rps,#B_ops")');
			}else{
				echo msgoutme("warning","Ooops!","Unable to update...");
			}

		break;
		case 'email':
			if($data[0] == "" || $data[1] == ""){
				echo msgoutme("warning","Ooops!","Missing data...");
				echo loaderoff();
				exit();
			}
			if (!filter_var($data[0], FILTER_VALIDATE_EMAIL)) {
				echo msgoutme("warning","Ooops!","Please provide a valid email address.");
				echo loaderoff();
				exit();
		    }
			$currpass = getOne("password","a_accounts","usercode",$userdata_arr['usercode']);
			if($currpass != ep($data[1])){
				echo msgoutme("warning","Ooops!","Old password is incorrect.");
				echo loaderoff();
				exit();
			}
			//$fieldsandvalues = "
				//email = '$data[0]'
			//";



			//$update = updateDT("a_accounts",$fieldsandvalues,"usercode",$userdata_arr['usercode']);
			//if($update == 1){

				$S_lname = $userdata_arr['memberlname'];
				$S_fname = $userdata_arr['memberfname'];

				$verifierphp = cfg::get('base_url')."/changeemail.php?id=".$userdata_arr['usercode']."&email=".$data[0];
		    	$subject = "New Email Re-verification from Eastwoodcitycondo";
		    	$message = "Good day $S_fname $S_lname,<br>";
		    	$message .= "Pls follow the link below to complete your Email re-verification...<br>";
		    	$message .= "<a href='$verifierphp'>Verify My New Email Address!</a>";
		    	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
				$header .= "Reply-To: ".$emailserver2." \r\n";
				$header .= "Content-type: text/html \r\n";
		    	mail($data[0],$subject,$message,$header);


		    	$_SESSION["email_data"] = $data[0];
		    	$_SESSION["email_subj"] = $subject;
		    	$_SESSION["email_msgs"] = $message;
		    	$_SESSION["email_head"] = $header;
		    	
				//reget_ses_data();
				echo msgoutme("info","Good!","Verification code was sent. Please check your email.");
				echo rundisfunction('reset_dis("#C_em,#C_ps")');
			//}else{
				//echo msgoutme("warning","Ooops!","Unable to update...");
			//}
		break;
	}
	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////
//LOAD TABLE DATA
if(isset($_POST['load_table_htmltbname']) && isset($_POST['load_table_searchdata']) && isset($_POST['load_table_sort']) && isset($_POST['load_table_page']) && isset($_POST['load_table_htmlpage'])){
	$load_table_htmltbname = $_POST['load_table_htmltbname'];
	$load_table_searchdata = $_POST['load_table_searchdata'];
	$load_table_sort = $_POST['load_table_sort'];
	$load_table_page = $_POST['load_table_page'];
	$load_table_htmlpage = $_POST['load_table_htmlpage'];
	echo load_row(0,$load_table_htmltbname,$load_table_searchdata,$load_table_sort,$load_table_page,$load_table_htmlpage);
	echo loaderoff();
	exit();
}	



/////////////////////////////////////////////////////////////////////////////////X
//SAVE ADD DATA 
if(isset($_POST['save_data']) && isset($_POST['save_tbnm']) && isset($_POST['save_page'])){
	$data = $_POST['save_data'];
	$tbname = $_POST['save_tbnm'];
	$page = $_POST['save_page'];
	$id = $data[0];

	$usercode = "";


	//filter inputs
	if(is_array($data)){
		for ($i=0; $i < count($data); $i++) { 
			$data[$i] = filterSymbols($data[$i],"input");
		}
	}else{
		echo msgoutme("info","Ooops!","Invalid data...");
		exit();
	}

	if($data[1] == ""){
		echo msgoutme("info","Ooops!","Important data is missing...");
		exit();
	}

	
	switch ($tbname) {
		case 'a_accounts': // change
			
			$fieldsandvalues = "
				membertype = '{$data[4]}',
				memberstatus = '{$data[8]}',
				membertag = '{$data[9]}'
			";

			if($id == "" || $id == 0){
				if($data[1] == "" || $data[2] == "" || $data[3] == ""){
					echo msgoutme("info","Ooops!","Important data is missing...");
					exit();
				}
				if (!filter_var($data[2], FILTER_VALIDATE_EMAIL)) {
					echo msgoutme("info","Ooops!","Invalid Email Address...");
					echo loaderoff();
					exit();
			    }
				$pass = ep($data[3]);
				$fields = "(usercode,email,password,membertype,memberlname,memberfname,membercellno,memberstatus,membertag)";
				$values = "('{$data[1]}','{$data[2]}','{$pass}','{$data[4]}','{$data[5]}','{$data[6]}','{$data[7]}','{$data[8]}','{$data[9]}')";
				$usercode = "$data[1]";
			}

			
		break;
		
		case 'a_membertype': // change
			$fieldsandvalues = "
				membertypecode = '{$data[1]}',
				membertypedesc = '{$data[2]}',
				membertypetag = '{$data[3]}'
			";
			$fields = "(membertypecode,membertypedesc,membertypetag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;

		case 'a_propertytype': // change
			$fieldsandvalues = "
				proptypecode = '{$data[1]}',
				proptypedesc = '{$data[2]}',
				proptypetag = '{$data[3]}'
			";
			$fields = "(proptypecode,proptypedesc,proptypetag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;

		case 'a_propertyclass': // change
			$fieldsandvalues = "
				proptypecode = '{$data[1]}',
				propclasscode = '{$data[2]}',
				propclassdesc = '{$data[3]}',
				propclasstag = '{$data[4]}'
			";
			$fields = "(proptypecode,propclasscode,propclassdesc,propclasstag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}')";
		break;


		case 'a_locationcity': // change
			$fieldsandvalues = "
				loccitycode = '{$data[1]}',
				loccitydesc = '{$data[2]}',
				loccitytag = '{$data[3]}'
			";
			$fields = "(loccitycode,loccitydesc,loccitytag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;


		case 'a_listingtype': // change
			$fieldsandvalues = "
				listtypecode = '{$data[1]}',
				listtypedesc = '{$data[2]}',
				listtypetag = '{$data[3]}'
			";
			$fields = "(listtypecode,listtypedesc,listtypetag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;

		case 'a_mincontract': // change
			$fieldsandvalues = "
				mincontractcode = '{$data[1]}',
				mincontractdesc = '{$data[2]}',
				mincontracttag = '{$data[3]}'
			";
			$fields = "(mincontractcode,mincontractdesc,mincontracttag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;


		case 'a_paymentterm': // change
			$fieldsandvalues = "
				paytermcode = '{$data[1]}',
				paytermdesc = '{$data[2]}',
				paytermtag = '{$data[3]}'
			";
			$fields = "(paytermcode,paytermdesc,paytermtag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}')";
		break;

		case 'b_listing': // change
			$fieldsandvalues = "
				listingcode = '{$data[1]}',
				listingdescription = '{$data[2]}',
				buildingname = '{$data[3]}',
				propaddress = '{$data[4]}',
				proptypecode = '{$data[5]}',
				propclasscode = '{$data[6]}',
				loccitycode = '{$data[7]}',
				usercode = '{$data[8]}',
				listingkeys = '{$data[9]}',
				listingtag = '{$data[10]}'
			";
			$fields = "(listingcode,listingdescription,buildingname,propaddress,proptypecode,propclasscode,loccitycode,usercode,listingkeys,listingtag)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}','{$data[7]}','{$data[8]}','{$data[9]}','{$data[10]}')";
		break;


		case 'b_ads': // change
			$fieldsandvalues = "
				adscode = '{$data[1]}',
				adstitle = '{$data[2]}',
				adsdesc = '{$data[3]}',
				listingcode = '{$data[4]}',
				listtypecode = '{$data[5]}',
				price = '{$data[6]}',
				paymentterm = '{$data[7]}'
			";
			$fields = "(adscode,adstitle,adsdesc,listingcode,listtypecode,price,paymentterm)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}','{$data[7]}')";
		break;



		case 'b_clients': // change
			$fieldsandvalues = "
				clientcode = '{$data[1]}',
				clientlname = '{$data[2]}',
				clientfname = '{$data[3]}',
				clientemail = '{$data[4]}',
				clientcellno = '{$data[5]}',
				clientremarks = '{$data[6]}',
				clientstatus = '{$data[7]}'
			";
			$fields = "(clientcode,clientlname,clientfname,clientemail,clientcellno,clientremarks,clientstatus)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}','{$data[7]}')";
		break;

		case 'b_inquiries': // change
			$fieldsandvalues = "
				clientcode = '{$data[1]}',
				adscode = '{$data[2]}',
				message = '{$data[3]}',
				inquirydate = '{$data[4]}',
				inquirytime = '{$data[5]}',
				remarks = '{$data[6]}'
			";
			$fields = "(clientcode,adscode,message,inquirydate,inquirytime,remarks)";
			$values = "('{$data[1]}','{$data[2]}','{$data[3]}','{$data[4]}','{$data[5]}','{$data[6]}')";
		break;
	}

	if($id == "" || $id == 0){
		$insert = insertDT($tbname,$fields,$values);
		if($insert){
			if($tbname == "a_accounts"){
				//dont echo
				record_expiration($usercode,"","",1);
			}
			echo "	<script type='text/javascript'>
						loadMyURL('$page');
					</script>";
		}else{
			echo msgoutme("info","Ooops!","Something went wrong pls try again...".$insert);
		}
	}else{
		$update = updateDT($tbname,$fieldsandvalues,"recno",$id);
		if($update){
			echo "	<script type='text/javascript'>
						loadMyURL('$page');
					</script>";
		}else{
			echo msgoutme("info","Ooops!","Something went wrong pls try again...".$update);
		}
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////X
//USER FORGOT PASSWORD 
if(	isset($_POST['user_forgot_F_email']) && 
	isset($_POST['user_forgot_F_lname']) && 
	isset($_POST['user_forgot_F_fname']) ){

	$F_email = $_POST['user_forgot_F_email'];
	$F_lname = $_POST['user_forgot_F_lname'];
	$F_fname = $_POST['user_forgot_F_fname'];

	

	if($F_email == "" || $F_lname == "" || $F_fname == ""){
		echo msgoutme("info","Ooops!","Missing information...");
		echo loaderoff();
		exit();
	}
	

	if (!filter_var($F_email, FILTER_VALIDATE_EMAIL)) {
		echo msgoutme("info","Ooops!","Invalid Email Address...");
		echo loaderoff();
		exit();
    }


    $row = getRow("*","a_accounts","email",$F_email);
    if(is_array($row)){
    	$usercode = $row[0]['usercode'];
    	$db_ln = $row[0]['memberlname'];
		$db_fn = $row[0]['memberfname'];
		$random_pass = createRandomPassword();
		$random_pass_ep = ep($random_pass);

		if($db_ln == $F_lname && $db_fn == $F_fname){
			$verifierphp = cfg::get('base_url')."/password.php?id=$usercode&val=$random_pass_ep";
	    	$subject = "Password reset request from Eastwoodcitycondo";
	    	$message = "Good day $F_fname $F_lname,<br>";
	    	$message .= "Pls follow the link below to reset your password...<br>";
	    	$message .= "This is your new password: <b>$random_pass</b><br>";
	    	$message .= "<a href='$verifierphp'>Reset My Password!</a>";
	    	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
			$header .= "Reply-To: ".$emailserver2." \r\n";
			$header .= "Content-type: text/html \r\n";
	    	mail($F_email,$subject,$message,$header);
	    	echo msgoutme("success","Important!","Password reset is successful pls. go to your email and check your new password...");
	    	echo rundisfunction("resetF();");
			echo loaderoff();
			exit();
		}else{
			echo msgoutme("info","Ooops!","Your first name and last name did not match in our database...");
			echo loaderoff();
			exit();
		}
    }else{
    	echo msgoutme("info","Ooops!","Unregistered Email Address...");
		echo loaderoff();
		exit();
    }

    echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////X
//USER SIGNIN 
if(	isset($_POST['user_signin_S_email']) && 
	isset($_POST['user_signin_S_lname']) && 
	isset($_POST['user_signin_S_fname']) && 
	isset($_POST['user_signin_S_pass']) && 
	isset($_POST['user_signin_S_repass']) ){

	$S_email = $_POST['user_signin_S_email'];
	$S_lname = $_POST['user_signin_S_lname'];
	$S_fname = $_POST['user_signin_S_fname'];
	$S_pass = $_POST['user_signin_S_pass'];
	$S_repass = $_POST['user_signin_S_repass'];

	
	if($S_email == "" || $S_lname == "" || $S_fname == "" || $S_pass == "" || $S_repass == ""){
		echo msgoutme("info","Ooops!","Missing information...");
		echo loaderoff();
		exit();
	}

	if (!filter_var($S_email, FILTER_VALIDATE_EMAIL)) {
		echo msgoutme("info","Ooops!","Invalid Email Address...");
		echo loaderoff();
		exit();
    }

    if ($S_pass != $S_repass) {
		echo msgoutme("info","Ooops!","Password did not matched...");
		echo loaderoff();
		exit();
    }

    $usercode = $S_lname."_".time();
    $pass = ep($S_pass);
	$fields = "(usercode,email,password,memberlname,memberfname,membertype)";
	$values = "('$usercode','$S_email','$pass','$S_lname','$S_fname','Blue')";

    $insert = insertDT("a_accounts",$fields,$values);

    //insert to expiration add 1 star
    //$insert = insertDT("a_accounts",$fields,$values);

    if($insert === 1){
    	//dont echo
    	record_expiration($usercode,"","",1);

    	$verifierphp = cfg::get('base_url')."/verification.php?id=".$usercode;
    	$subject = "Email verification from Eastwoodcitycondo";
    	$message = "Good day $S_fname $S_lname,<br>";
    	$message .= "Pls follow the link below to complete your registration...<br>";
    	$message .= "<a href='$verifierphp'>Verify My Email Address!</a>";
    	$header = "From: <inquire@eastwoodcitycondo.com> \r\n";
		$header .= "Reply-To: ".$emailserver2." \r\n";
		$header .= "Content-type: text/html \r\n";
    	mail($S_email,$subject,$message,$header);

    	$subject2 = "$S_fname $S_lname Sign Up!";
    	$message2 = "Name: $S_fname $S_lname,<br>";
    	$message2 .= "Email: $S_email<br>";
    	$header2 = "From: <inquire@eastwoodcitycondo.com> \r\n";
		$header2 .= "Reply-To: ".$S_email." \r\n";
		$header2 .= "Content-type: text/html \r\n";
    	mail($emailserver2,$subject2,$message2,$header2);

    	$_SESSION["email_data"] = $S_email;
		$_SESSION["email_subj"] = $subject;
		$_SESSION["email_msgs"] = $message;
		$_SESSION["email_head"] = $header;

    	echo msgoutme("success","Important!","Your registration is submitted successfully pls. go to your email and verified your account...");
    	echo rundisfunction("resetS();");
    	
		echo loaderoff();
		exit();
    }else{
    	echo msgoutme("danger","Ooops!","Something went wrong, ".$insert."...");
		echo loaderoff();
		exit();
    }

	echo loaderoff();
	exit();
}

/////////////////////////////////////////////////////////////////////////////////X
//USER LOGIN 
if(	isset($_POST['user_login_L_email']) &&
	isset($_POST['user_login_L_pass']) ){
	$L_email = $_POST['user_login_L_email'];
	$L_pass = $_POST['user_login_L_pass'];

	if($L_email == "" || $L_pass == ""){
		echo msgoutme("info","Ooops!","Missing information...");
		echo loaderoff();
		exit();
	}

	if (!filter_var($L_email, FILTER_VALIDATE_EMAIL)) {
		echo msgoutme("info","Ooops!","Invalid Email Address...");
		echo loaderoff();
		exit();
    }

    $row = getRow("*","a_accounts","email",$L_email);
    if(is_array($row)){
		$db_usercode = $row[0]['usercode'];
		$db_email = $row[0]['email'];
		$db_password = $row[0]['password'];
		$db_membertype = $row[0]['membertype'];
		$db_memberlname = $row[0]['memberlname'];
		$db_memberfname = $row[0]['memberfname'];
		$db_membercellno = $row[0]['membercellno'];
		$db_memberstatus = $row[0]['memberstatus'];
		$db_membertag = $row[0]['membertag'];



		if($db_memberstatus == "Unverified"){
			echo msgoutme("info","Ooops!","Unverified account pls. check your email to complete the registration...");
			echo loaderoff();
			exit();
		}

		if($db_membertype == null){
			$db_membertype = "";
		}
		if($db_membercellno == null){
			$db_membercellno = "";
		}
		if($db_membertag == null){
			$db_membertag = "";
		}

		if($db_password == ep($L_pass)){
			$_SESSION["usercode"] = $db_usercode;
			$_SESSION["email"] = $db_email;
			$_SESSION["membertype"] = $db_membertype;
			$_SESSION["memberlname"] = $db_memberlname;
			$_SESSION["memberfname"] = $db_memberfname;
			$_SESSION["membercellno"] = $db_membercellno;
			$_SESSION["memberstatus"] = $db_memberstatus;
			$_SESSION["membertag"] = $db_membertag;
			expirationcehcker($db_usercode);
			echo jsredirect("dashboard.php");
		}else{
			echo msgoutme("info","Ooops!","Wrong password...");
			echo loaderoff();
			exit();
		}
	}else{
		echo msgoutme("info","Ooops!","You are not registerd...");
		echo loaderoff();
		exit();
	}
	echo loaderoff();
	exit();
}


/////////////////////////////////////////////////////////////////////////////////X
//ADMIN LOGIN 
if(isset($_POST['admin_login_A_un']) && isset($_POST['admin_login_A_ps'])){
	$un = $_POST['admin_login_A_un'];
	$ps = $_POST['admin_login_A_ps'];
	
	if($un == "" || $ps == ""){
		echo msgoutme("info","Ooops!","Missing information...");
		echo loaderoff();
		exit();
	}
	$row = getRow("*","z_admin","username",$un);
	if(is_array($row)){
		$db_un = $row[0]['username'];
		$db_ps = $row[0]['password'];
		if($db_ps == ep($ps)){
			$_SESSION["username"] = $un;
			$_SESSION["usertype"] = "Administrator";
			echo jsredirect("admin/admin.php?accounts");
			echo loaderoff();
			exit();
		}else{
			echo msgoutme("info","Ooops!","Wrong password...");
			echo loaderoff();
			exit();
		}
	}else{
		echo msgoutme("info","Ooops!","You are not registerd...");
		echo loaderoff();
		exit();
	}
	echo loaderoff();
	exit();
}

?>