<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->nightaudit();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reservation','ReinstateNoShows');
$this->pfrm->FrmHead2('Reservation / ReinstateNoShows',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="example1">
        <thead  >
          <tr>
            <th>Sno</th>
            <th>Res.Date</th>
            <th>Arr.Date</th>
			      <th>Res.No</th>            
            <th>Guest Name</th>            
            <th>Room Type</th>            
            <th style="width:100px !important" align="center" >Action</th>
          </tr>
        </thead>
      <tbody>
    <?php 
		$Res=$this->Myclass->ResNoShow();
		$count=1;			 
		foreach($Res as $row)
			{
				echo '<tr class="odd gradeX">
                  <td>'.$count.'</td>
                  <td>'.date('d-m-Y',strtotime($row['Resdate'])).'</td>
                  <td>'.date('d-m-Y',strtotime($row['fromdate'])).'</td>
                  <td>'.$row['ResNo'].'</td>
                  <td>'.$row['Firstname'].'</td>
                  <td>'.$row['RoomType'].'</td>';  	   		 
          echo '<td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."_Update/".$row['Resid'].'/UPDATE"   >
					  <i class="fa fa-edit"></i> Edit</a>  					   					  
					  </td>                     
                </tr>';                 
                 /*<a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Floor_Id'].'/DELETE"   >
					  <i class="fa fa-trash"></i> Delete</a>*/                
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


<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>


