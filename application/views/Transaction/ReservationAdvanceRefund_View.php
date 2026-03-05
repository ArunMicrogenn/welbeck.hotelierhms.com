<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Advance Refund View');
$this->pfrm->FrmHead1('Transaction / Reservation Advance Refund View',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>S.No</th>          
            <th>Reservation.No</th>
            <th>Receipt.No</th>
		      	<th>Customer</th>   
            <th>Advance Amount</th>                     
            <th>Refund</th>                     
            <th style="width:100px !important" align="center" >Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
      $sql="select mt.Title+'.'+cus.Firstname as Name, * from trans_reservecancel_mas mas   
          Inner join Trans_Reserve_Mas rmas on rmas.resid=mas.reserveid
          Inner join Mas_Customer cus on cus.Customer_Id=rmas.cusid
          Inner join Mas_Title mt on mt.Titleid=cus.Titelid
          where isnull(mas.refund,0)<>0 and isnull(advamount,0)<>0 and mas.resdate='".date('Y/m/d')."'";
      $res=$this->db->query($sql);     
			$count=1;			 
      foreach ($res->result_array() as $row)      
			{
				 
        echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>                     
                      <td>'.$row['yearprefix'].'/'.$row['ResNo'].'</td> 
                      <td>'.$row['yearprefix'].$row['resno'].'</td> 
                      <td>'.$row['Name'].'</td> 
                      <td align="end">'.number_format($row['advamount'],2).'</td> 					  
                      <td align="end">'.number_format($row['refund'],2).'</td> 					  
                    <td>
                      <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['resid'].'/UPDATE"   >
                      <i class="fa fa-edit"></i> Edit</a>
                      <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['resid'].'/DELETE"   >
                      <i class="fa fa-trash"></i> Delete</a>
                      </td>
                      
                      </tr>';
                 
                 /* | 
					   <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Facility_Id'].'/DELETE"   >
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
