<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Donate','Decline');
$this->pfrm->FrmHead2('Donate / Decline',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>Sno</th>
            <th>Title</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>City</th>
            <th>Date</th>
            <th>DonateNo</th>
            <th>Amount</th>
             <th>Error</th>
        
           
          </tr>
        </thead>
        <tbody>
          <?php 
			$Res=$this->Myclass->Donate(0,1);
			$count=1;
			 
		 foreach($Res as $row)
			{
				 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['Title'].'</td>
					  <td>'.$row['Name'].'</td>					  						 
					  <td>'.$row['Mobile'].'</td>
					  <td>'.$row['City'].'</td>					   
					  <td>'.$row['Date'].'</td>
					  <td>'.$row['DonateNo'].'</td>	
					  <td>'.$row['Amount'].'</td>					   	 
                      <td> </td>	
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
<script>
$(document).ready(function(e) {
    $("#SECURITY").val('<?php echo @$SECURITY; ?>');
	 
});
</script>
