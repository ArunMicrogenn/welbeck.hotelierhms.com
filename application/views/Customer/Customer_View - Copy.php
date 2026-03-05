<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Customer','Customer');
$this->pfrm->FrmHead1('Customer / Customer',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

<div class="table-responsive">
  <table class="table table-bordered table-hover"  id="example1">
    <thead  >
      <tr>
        <th>Sno</th>
        <th>FirstName</th>
        <th>Company</th>
        <th>City</th>
        <th>State</th><th>Email</th><th>Mobile</th><th>Phone</th>
        <th style="width:100px !important" align="center" >Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php 
			$Res=$this->Myclass->Customer();
			$count=1;
			 
		 foreach($Res as $row)
			{
				 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['Titel'].' '.$row['FirstName'].'</td>
					  <td>'.$row['Company'].'</td> 
					  <td>'.$row['City'].'</td>	
					  <td>'.$row['State'].'</td>
					  <td>'.$row['Email'].'</td>
					  <td>'.$row['Mobile'].'</td>
					  <td>'.$row['Phone'].'</td>	 
                      <td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Customer_ID'].'/UPDATE"   >
					  <i class="fa fa-edit"></i> Edit</a> | 
					   <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Customer_ID'].'/DELETE"   >
					  <i class="fa fa-trash"></i> Delete</a>
					  
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
