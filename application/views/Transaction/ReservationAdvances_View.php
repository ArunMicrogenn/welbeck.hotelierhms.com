<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Advance View');
$this->pfrm->FrmHead1('Transaction / Reservation Advance View',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>S.No</th>
            <th>Receipt.No</th>
            <th>Reservation.No</th>
		      	<th>Customer</th>   
            <th>Amount</th>                     
            <th style="width:100px !important" align="center" >Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
		   $sql="select ti.Title+'.'+cus.Firstname as Name,* from Trans_reserveadd_mas mas
       inner join Trans_reserveadd_det trdet on mas.resaddid = trdet.resaddid
       inner join trans_reserve_det tdet on tdet.resdetid = trdet.resdetid
       inner join Trans_reserve_mas trmas on trmas.Resid = tdet.resid
       inner join Trans_Receipt_mas rmas on rmas.Billid=mas.resaddid 
       inner join Mas_Customer cus on mas.cusid=cus.Customer_Id 
       inner join Mas_Title ti on ti.Titleid=cus.Titelid 
       where mas.resaddate ='2025/10/03' and isnull(rmas.cancel,0)=0 and isnull(ReceiptType,'')='A' and isnull(tdet.stat,'') not in ('Y','C') 
       and isnull(trmas.stat,'') not in ('Y','C')
       ";
      $res=$this->db->query($sql);     
			$count=1;			 
      foreach ($res->result_array() as $row)      
			{
				 
        echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['yearprefix'].'/'.$row['resadno'].'</td> 
                      <td>'.$row['yearprefix'].'/'.$row['resno'].'</td> 
                      <td>'.$row['Name'].'</td> 
                      <td align="end">'.number_format($row['Amount'],2).'</td> 					  
                    <td>
                      <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['resaddid'].'/UPDATE"   >
                      <i class="fa fa-edit"></i> Edit</a>
                      <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['resaddid'].'/DELETE"   >
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
