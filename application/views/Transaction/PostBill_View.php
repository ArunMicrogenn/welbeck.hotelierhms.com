<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','PostBill_View');
$this->pfrm->FrmHead1('Transaction / PostBill_View',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>S.No</th>
            <th>Receipt.No</th>
            <th>Room No</th>            
		      	<th>Customer</th>   
            <th>Amount</th>                     
            <th style="width:100px !important" align="center" >Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
			$Res=$this->Myclass->Get_PostBills();
			$count=1;			 
		  foreach($Res as $row)
			{				 
        echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['yearprefix'].'/'.$row['CreditNo'].'</td> 
                      <td>'.$row['RoomNo'].'</td>                       
                      <td>'.$row['Name'].'</td> 
                      <td align="end">'.$row['Amount'].'</td> 					  
                    <td>
                      <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Credid'].'/UPDATE"   >
                      <i class="fa fa-edit"></i> Edit</a>
                      <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Credid'].'/DELETE"   >
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
