<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Room Availability');
$this->pfrm->FrmHead3('Report / Room Availability Chart',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 ?>

<?php  	date_default_timezone_set('Asia/Kolkata');  ?>

<div class="col-sm-12">
  <div class="the-box F_ram">

        <form action="" method="POST">
            <table class="FrmTable T-6" >
                <tr>
                    <td align="right" class="F_val">Arrival Date</td>
                    <td align="left"><input type="text" id="Fdate"  name="CurDate"  value="<?php if(isset($_POST['CurDate'])){ echo $_POST['CurDate'];}else{echo date('d-m-Y');} ?>"   class="scs-ctrl Dat" /></td>
                           
                    <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
                </tr>
            </table> 
        </form>

  </div>

</div>



    
	
      <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 			 
             $date=date('Y-m-d');
            if(isset($_POST['CurDate'])){
              $date= date('Y-m-d', strtotime($_POST['CurDate']));              
            }
                $count = 1;
                $totalrooms =0;
                $totalcheckin =0;
                $totalbooking =0;
                $totalExpC =0;
                $totalFb =0;
                $totalMb =0;
                $totalAv =0;
			  
				echo '<tr style="background-color: #A9A9A9;">';
				echo '<th  style="text-align: start;">Room Type</th>';
                echo '<th  style="text-align: center;">No of rooms</th>';
				echo '<th style="text-align: center;">Checkin</th>';
				echo '<th style="text-align: center;">Booking</th>';
				echo '<th style="text-align: center;">Exp.checkout</th>';
				echo '<th style="text-align: center;">Blocked Rooms</th>';
                echo '<th style="text-align: center;">Available Rooms</th>';
				echo '</tr>';			
				
              $type = "select * from mas_roomtype";
              $exe = $this->db->query($type);
              foreach($exe->result_array() as $row){
                $roomtypeid=$row['RoomType_Id'];
               
			     $qry="exec Room_availability '".$date."',  '".$roomtypeid."'";
			   $exec=$this->db->query($qry); 	 
			  foreach ($exec->result_array() as $rows)
			  {		

            
                $totalrooms = $totalrooms+	$rows['Totalrooms'];
                $totalcheckin = $totalcheckin + $rows['Checkins'];
                $totalbooking = $totalbooking + $rows['Booking'];
                $totalExpC = $totalExpC + $rows['Expcheckout'];
                $totalFb = $totalFb + $rows['blockedrooms'];
                $totalAv = $totalAv + $rows['Availablerooms'];
            
				echo '<tr>';		 				
				echo '<td  style="text-align: start;">'.$rows['RoomType'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['Totalrooms'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['Checkins'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['Booking'].'</td>';
                echo '<td  style="text-align: center;">'.$rows['Expcheckout'].'</td>';
                echo '<td  style="text-align: center;">'. $rows['blockedrooms'].'</td>';
                echo '<td  style="text-align: center;">'. $rows['Availablerooms'] .'</td>';
				echo '</tr>';				
			  }	
            }
              
                echo '<tr>';		 
				echo '<td  style="text-align: end;">Total</td>';
                echo '<td  style="text-align: center;">'.$totalrooms.'</td>';
                echo '<td  style="text-align: center;">'.$totalcheckin.'</td>';
                echo '<td  style="text-align: center;">'.$totalbooking.'</td>';
                echo '<td  style="text-align: center;">'.$totalExpC .'</td>';
                echo '<td  style="text-align: center;">'.$totalFb.'</td>';
                echo '<td  style="text-align: center;">'.$totalAv.'</td>';
				echo '</tr>';	

		   ?>		   
		   </tbody>
           
		 </table>	
	</div>

<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>