<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Configurations','Sms Configuration');
$this->pfrm->FrmHead2('Configurations / Sms Configuration',$F_Class."/"."SmsConfiguration",$F_Class."/".$F_Ctrl."_View");
 
?>

<style type="text/css">
	.context-menu {
		position: absolute;
		text-align: center;
		background: lightgray;
		border: 1px solid black; 
        
	}

	.context-menu ul {
		padding: 0px;
		margin: 0px;
		min-width: 150px;
		list-style: none;
	}

	.context-menu ul li {
		padding-bottom: 7px;
		padding-top: 7px;
		border: 1px solid black;
	}

	.context-menu ul li a {
		text-decoration: none;
		color: black;
	}

	.context-menu ul li:hover {
		background: darkgray;
	}
  </style>

	<style type="text/css">
		.context-menu {
			position: absolute;
            top:100px !important;
            left:100px !important;
			text-align: center;
			background: lightgray;
			border: 1px solid black;
		}

		.context-menu ul {
			padding: 0px;
			margin: 0px;
			min-width: 150px;
			list-style: none;
		}

		.context-menu ul li {
			padding-bottom: 7px;
			padding-top: 7px;
			border: 1px solid black;
		}

		.context-menu ul li a {
			text-decoration: none;
			color: black;
		}

		.context-menu ul li:hover {
			background: darkgray;
		}
	</style>

<?php 
		$sql="select * from mas_smsmessage where TemplateId='".$TemplateId."'";
		$result = $this->db->query($sql); 
		foreach ($result->result_array() as $row)
			{
				$msg = $row['Template'];
			}
?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$TemplateId; ?>" >
        <div class="row">
            <div class="col-md-12 col-sm-12">          
                <textarea style="height:200px; width:100%"  id="area" name="area" cols="30" rows="10"><?php echo $msg; ?></textarea>							
                 <div class="area"></div>

                 <tr>
                  <td align="right">&nbsp;CampaignName</td>
                  <td align="left"><input type="text" maxlength="30"   id="campaign" name="campaign" placeholder="Whatsapp Business Campaign Name" value="<?php echo @$campaign;?>"   /></td>
                 </tr>
                <tr>
                  <td align="right">&nbsp;</td>
                  <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
                </tr>
            </div>
                <div id="contextMenu" class="context-menu"
                    style="display:none; left:50px !important; top:100px !important;">
                    <?php  
                     if($TemplateId==1){
                    ?>
                    <ul>
                        <a href="#" onclick="paste('*GuestName*')" id="OTP"><li>GuestName</li></a>									
                        <a href="#" onclick="paste('*HotelName*')" id="CName"><li>HotelName</li></a>									
                        <a href="#" onclick="paste('*ContactNo*')" id="OName"><li>ContactNo</li></a>							
                    </ul>
                    <?php
                     }
                     elseif($TemplateId==2){
                        ?>
                        <ul>
            									
                        <a href="#" onclick="paste('*GuestName*')" id="CName"><li>GuestName</li></a>									
                        <a href="#" onclick="paste('*FeedbackURL*')" id="OName"><li>Feedback URL</li></a>		
                       										
                       </ul>
                       <?php 
                     } elseif($TemplateId==3){
                      ?>
                      <ul>
                        																
                        <a href="#" onclick="paste('*CustomerName*')" id="OName"><li>Customer Name</li></a>	
                        <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                        <a href="#" onclick="paste('*fromdate*')" id="OName"><li>fromdate</li></a>		
                        <a href="#" onclick="paste('*todate*')" id="OName"><li>todate</li></a>							
                        <a href="#" onclick="paste('*time*')" id="OName"><li>Time</li></a>	
                        <a href="#" onclick="paste('*noofpersons*')" id="OName"><li>No of Persons</li></a>	
                        <a href="#" onclick="paste('*noofrooms*')" id="OName"><li>No of Rooms</li></a>
                        <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>								
                        <a href="#" onclick="paste('*HotelAddress*')" id="CName"><li>HotelAddress</li></a>	
                        <a href="#" onclick="paste('*ContactNo*')" id="CName"><li>ContactNo</li></a>	
                        <a href="#" onclick="paste('*HotelPinCode*')" id="CName"><li>HotelPinCode</li></a>	
                    
                        											                            							
                     </ul>
                      <?php 
                     }
                     elseif($TemplateId==4){
                      ?>
                      <ul>
                        																
                        <a href="#" onclick="paste('*CustomerName*')" id="OName"><li>Customer Name</li></a>	
                        <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                        <a href="#" onclick="paste('*Reserve Date*')" id="OName"><li>Reserve Date</li></a>	
                        <a href="#" onclick="paste('*Hotelname*')" id="OName"><li>Hotelname</li></a>							
                        <a href="#" onclick="paste('*ContactNo*')" id="OName"><li>ContactNo</li></a>								
                        								                            							
                     </ul>
                     <?php 
                     }
                      elseif($TemplateId==5){
                      ?>
                      <ul>
                        																
                        <a href="#" onclick="paste('*auditdate*')" id="OName"><li>AuditDate</li></a>	
                        <a href="#" onclick="paste('*Actual Rooms for Sale*')" id="OName"><li>Actual Rooms for Sale</li></a>
                        <a href="#" onclick="paste('*Total Sold Rooms*')" id="OName"><li>Total Sold Rooms </li></a>								
                        <a href="#" onclick="paste('*Total Room Revenue*')" id="OName"><li>Total Room Revenue </li></a>		
                        <a href="#" onclick="paste('*ARR*')" id="OName"><li>ARR </li></a>		
                        <a href="#" onclick="paste('*APR*')" id="OName"><li>APR  </li></a>			
                        <a href="#" onclick="paste('*REVPAR*')" id="OName"><li>REVPAR  </li></a>									
                        <a href="#" onclick="paste('*Yesterday Night Position*')" id="OName"><li>Yesterday Night Position </li></a>									
                        <a href="#" onclick="paste('*Todays Arrivals*')" id="OName"><li>Today's Arrivals </li></a>									
                        <a href="#" onclick="paste('*Todays Departures*')" id="OName"><li>Today's Departures </li></a>									
                        <a href="#" onclick="paste('*Current Occupied Rooms*')" id="OName"><li>Current Occupied Rooms </li></a>									
                        <a href="#" onclick="paste('*Vacant Rooms*')" id="OName"><li>Vacant Rooms </li></a>									
                        <a href="#" onclick="paste('*Blocked Rooms*')" id="OName"><li>Blocked Rooms </li></a>									
                        <a href="#" onclick="paste('*Direct Rooms*')" id="OName"><li>Direct Rooms </li></a>									
                        <a href="#" onclick="paste('*Expected Arrivals Tomorrow*')" id="OName"><li>Expected Arrivals Tomorrow </li></a>									
                        <a href="#" onclick="paste('*Expected Departures Tomorrow *')" id="OName"><li>Expected Departures Tomorrow  </li></a>									
                        <a href="#" onclick="paste('*Cash*')" id="OName"><li>Cash </li></a>									
                        <a href="#" onclick="paste('*Credit Card *')" id="OName"><li>Credit Card </li></a>									
                        <a href="#" onclick="paste('*Cheque*')" id="OName"><li>Cheque </li></a>									
                        <a href="#" onclick="paste('*Company*')" id="OName"><li>Company  </li></a>									
                        <a href="#" onclick="paste('*UPI*')" id="OName"><li>UPI </li></a>									
                        <a href="#" onclick="paste('*To Room *')" id="OName"><li>To Room </li></a>									
                        <a href="#" onclick="paste('*Net Transfer*')" id="OName"><li>Net Transfer </li></a>									
                        <a href="#" onclick="paste('*PoweredBy*')" id="OName"><li> Powered By</li></a>									
                        								                            							
                     </ul>
                     <?php 
                     } 
                      ?>
      
                </div>
        </div>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div>

<?php 
  /*      if(isset($_POST['area']))
			{  
			
        $up="update mas_smsmessage set template='".$_POST['area']."' where TemplateId='".$_GET['id']."'";
        $result = $this->db->query($up);
        if($result){

        ?>
        <script>
        Swal.fire({
        title: 'Updated Successfully...!',
        text: 'Redirecting...',
        icon: 'success',
        timer: 2000,
        buttons: false,
        })
        .then(() => {
            window.location.href = "<?php echo scs_index ?>Configurations/SmsConfiguration"; 
        })
        </script>
        <?php 
        }
      } */
?>
<script>
		document.onclick = hideMenu;
		document.oncontextmenu = rightClick;

		function hideMenu() {
			document.getElementById("contextMenu").style.display = "none"
		}

		function rightClick(e) {
			e.preventDefault();

			if (document.getElementById("contextMenu").style.display == "block")
				hideMenu();
			else {
				var menu = document.getElementById("contextMenu")
					
				menu.style.display = 'block';
				menu.style.left = e.pageX + "px";
				menu.style.top = e.pageY + "px";
			}
		}
	</script>
	 <script>
     function paste(boj) {
	       // var pasteText = document.querySelector("#text");
         var curPos = document.getElementById("area").selectionStart;
        //  alert(curPos);
			   var pasteText =document.getElementById("area").value;	
        //  alert(pasteText)	;
			    // pasteText.focus();
          //   document.execCommand("paste");
            document.getElementById("area").value = pasteText.slice(0, curPos) + boj + pasteText.slice(curPos);
        }
   </script>
<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>