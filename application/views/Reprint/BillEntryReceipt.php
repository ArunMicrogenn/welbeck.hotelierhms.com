<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reprint','Bill Entry Receipt');
$this->pfrm->FrmHead3('Reprint / Bill Entry Receipt',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
  <?php 	date_default_timezone_set('Asia/Kolkata');  ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	  <form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="todate" name="todate"   class="scs-ctrl Dat2" />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	   </form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div>
<?php

		if(@$_POST['submit'])
		{
		?>					
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0;
			 $qry="select * from Mas_Revenue re
			 Inner join Trans_Credit_Entry ce on ce.Creditheadid= re.Revenue_Id
			 inner join UserTable us on us.User_id=ce.UserID
			 inner join Mas_Room room on room.Room_Id=ce.Roomid 
			 inner join Trans_RoomCustomer_det det on det.grcid=ce.Grcid
		 	inner join Mas_Customer cus on cus.Customer_Id=det.Customerid
			 where CreditDate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."'  and isnull(Taxhead,'') not in('ROOM','CGST','SGST','ADVANCE')";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';		 
				echo '<td  style="text-align: center;">Receipt No</td>';
				echo '<td  style="text-align: center;">Receipt Date</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Room No</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['CreditNo'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['CreditDate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Firstname'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';		
				echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/BillEntryReceipt?Receiptid='.$rows['Credid'].'"><i class="fa fa-eye"></i></a></td>';
				echo '</tr>';				
			  }			 
		   ?>		   
		   </tbody>
		</table>
		 <?php
		} ?>	
	</div>
	<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
 