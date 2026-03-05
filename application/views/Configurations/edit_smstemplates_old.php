<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Configurations','Sms Configuration');
$this->pfrm->FrmHead3('Configurations / Sms Configuration',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
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
		$sql="select * from mas_smsmessage where TemplateId='".$_GET['id']."'";
		$result = $this->db->query($sql); 
		foreach ($result->result_array() as $row)
			{
				$msg = $row['Template'];
			}
?>
<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
        <div class="row">
            <div class="col-md-12 col-sm-12">
            <form action="" method="POST">        
                <textarea style="height:200px; width:100%"  id="area" name="area" cols="30" rows="10"><?php echo $msg; ?></textarea>							
                <button type="submit" name="btn-clear"  class="btn btn-primary">Update</button>
            </form>	
            </div>
                <div id="contextMenu" class="context-menu"
                    style="display:none; left:50px !important; top:100px !important;">
                    <?php  
                     if($_GET['id']==2){
                    ?>
                    <ul>
                        <a href="#" onclick="paste('*GuestName*')" id="OTP"><li>GuestName</li></a>									
                        <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                        <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                        <a href="#" onclick="paste('*RoomRent*')" id="OName"><li>Room Rent</li></a>								
                    </ul>
                    <?php
                     }
                     elseif($_GET['id']==4){
                        ?>
                        <ul>
                            <a href="#" onclick="paste('*CompanyName*')" id="CName"><li>Company Name</li></a>
                            <a href="#" onclick="paste('*GuestName*')" id="OTP"><li>GuestName</li></a>									
                            <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                            <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                            <a href="#" onclick="paste('*RoomRent*')" id="OName"><li>Room Rent</li></a>										
                       </ul>
                       <?php 
                     } elseif($_GET['id']==5){
                        ?>
                        <ul>
                            <a href="#" onclick="paste('*CheckiIntime*')" id="OTP"><li>Checkin Time</li></a>																		
                            <a href="#" onclick="paste('*CutomerName*')" id="OName"><li>Customer Name</li></a>	
                            <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                            <a href="#" onclick="paste('*Reserve Date*')" id="OName"><li>Reserve Date</li></a>	
                            <a href="#" onclick="paste('*Checkout Date*')" id="OName"><li>Checkout Date</li></a>
                            <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                            <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                            <a href="#" onclick="paste('*Bill Amount*')" id="OName"><li>Bill Amount</li></a>	
                            <a href="#" onclick="paste('*SettlementAmount*')" id="OName"><li>Settlement Amount</li></a>								
                       </ul>
                       <?php
                     } elseif($_GET['id']==6){
                        ?>
                        <ul>
                          <a href="#" onclick="paste('*CheckiIntime*')" id="OTP"><li>Checkin Time</li></a>																		
                          <a href="#" onclick="paste('*CutomerName*')" id="OName"><li>Customer Name</li></a>	
                          <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                          <a href="#" onclick="paste('*Reserve Date*')" id="OName"><li>Reserve Date</li></a>	
                          <a href="#" onclick="paste('*Checkout Date*')" id="OName"><li>Checkout Date</li></a>
                          <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                          <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                          <a href="#" onclick="paste('*Bill Amount*')" id="OName"><li>Bill Amount</li></a>	
                          <a href="#" onclick="paste('*SettlementAmount*')" id="OName"><li>Settlement Amount</li></a>									
                          <a href="#" onclick="paste('*CompanyName*')" id="CName"><li>Company Name</li></a>									                            							
                       </ul>
                       <?php
                     }  elseif($_GET['id']==7){
                      ?>
                      <ul>
                        																
                        <a href="#" onclick="paste('*CutomerName*')" id="OName"><li>Customer Name</li></a>	
                        <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                        <a href="#" onclick="paste('*Reserve Date*')" id="OName"><li>Reserve Date</li></a>	
                        <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                        <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                        <a href="#" onclick="paste('*RoomRent*')" id="OName"><li>Room Rent</li></a>								
                        <a href="#" onclick="paste('*CompanyName*')" id="CName"><li>Company Name</li></a>									                            							
                     </ul>
                      <?php 
                     }
                     elseif($_GET['id']==8){
                      ?>
                      <ul>
                        																
                        <a href="#" onclick="paste('*CutomerName*')" id="OName"><li>Customer Name</li></a>	
                        <a href="#" onclick="paste('*ResNo*')" id="OName"><li>Reservation Number</li></a>
                        <a href="#" onclick="paste('*Reserve Date*')" id="OName"><li>Reserve Date</li></a>	
                        <a href="#" onclick="paste('*RoomNo*')" id="CName"><li>Room No</li></a>									
                        <a href="#" onclick="paste('*RoomType*')" id="OName"><li>Room Type</li></a>		
                        <a href="#" onclick="paste('*RoomRent*')" id="OName"><li>Room Rent</li></a>								
                        								                            							
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
        if(isset($_POST['area']))
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
      }
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