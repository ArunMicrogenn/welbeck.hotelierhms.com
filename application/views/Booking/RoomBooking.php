<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Booking','RoomBooking');
$this->pfrm->FrmHead1('Booking / RoomBooking',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

<div class="table-responsive">
  <table class="table table-bordered table-hover"  id="example1">
    <thead  >
      <tr>
        <th>Sno</th>
        <th>FirstName</th>
        <th>Bok.No</th>
        <th>Bok.Date</th>
        <th>Checkin</th><th>Checkout</th><th>RoomType</th><th>BookingAmount</th>
        <th style="width:130px !important" align="center" > Action</th>
      </tr>
    </thead>
    <tbody>
      <?php 
			$Res=$this->Myclass->Booking();
			$count=1;
			 
		 foreach($Res as $row)
			{
				 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['Titel'].' '.$row['FirstName'].'</td>
					  <td>'.$row['BookingNo'].'</td> 
					  <td>'.$row['Bdate'].'</td>	
					  <td>'.$row['Cdate'].'</td>
					  <td>'.$row['Codate'].'</td>
					  <td>'.$row['RoomType'].'</td>
					  <td>'.$row['BookingAmount'].'</td>	 
                      <td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Booking_Id'].'/VIEW"   >
					  <i class="fa fa-eye"></i> VIEW</a> | 
					   <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Booking_Id'].'/CANCEL"   >
					  <i class="fa fa-trash"></i> CANCEL</a>
					  
					  </td>
                      
                      </tr>';
                 
                 
                
				 $count++;
              
			}
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
