<!-- <?php
// defined('BASEPATH') OR exit('No direct script access allowed');
// $this->pweb->phead();
// $this->pcss->wcss();
// $this->pweb->wtop();
// $this->pweb->wheader($this->menu,$this->session);
// $this->pweb->menu($this->Menu,$this->session);
// $this->pweb->Cheader('Reprint','Reservation Advance Receipt');
// $this->pfrm->FrmHead3('Reprint / Reservation Advance Receipt',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?> -->
 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reprint','Reservation Advance Receipt');
$this->pfrm->FrmHead3('Reprint / Reservation Advance Receipt',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 <div class="col-sm-12">
	<?php 
	date_default_timezone_set('Asia/Kolkata'); 
$currentDate = date('Y-m-d');
 $currentDate; ?>
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['frmdate']){echo $_POST['frmdate']; }else { echo date('Y-m-d'); } ?>" id="frmdate" name="frmdate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['todate']){echo $_POST['todate']; }else { echo date('Y-m-d'); } ?>" id="todate" name="todate" max="<?php echo date('Y-m-d'); ?>"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	</form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php  if(@$_POST['submit']) {
	 $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
	 $todate = date('Y-m-d', strtotime($_POST['todate']));
		?>
        <table class="table table-bordered table-hover"  >    
		<div class="mt-4">
		<h4 class="text-center">Reservation Advance Receipt  <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?><h4>
		    </div>       
		   <tbody>
		    <?php 
			 $i=1;
			 $norow=0; $CASH=0; $CARD=0; $NEFT=0; $ROOM=0;

        	  $qry="select ti.Title+'.'+cus.Firstname as Name,* from Trans_reserveadd_mas mas
             inner join Trans_Receipt_mas rmas on rmas.Billid=mas.resaddid
             inner join Mas_Customer cus on mas.cusid=cus.Customer_Id
             inner join Mas_Title ti on ti.Titleid=cus.Titelid
             where mas.resaddate ='".date('Y/m/d')."' and 
			 isnull(rmas.cancel,0)=0 and  isnull(ReceiptType,'')='A' and rmas.rptdate between '".$fromdate."' and '".$todate."' ";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr style="background-color:#c9c6c6;">';		 
				echo '<td  style="text-align: center;">Receipt No</td>';
				echo '<td  style="text-align: center;">Receipt Date</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: center;">'.$rows['Firstname'].'</td>';	
				echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/ReservationAdvanceReceipt?Receiptid='.$rows['Receiptid'].'"><i class="fa fa-eye"></i></a></td>';
				echo '</tr>';				
			  }			 
		   ?>		   
		   </tbody>
		 </table>	
		 <?php } else { ?>
		 <div>
			<h4 class="text-center">No Result Found</h4>
		 </div>
		 <?php }  ?>

	</div>
	<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
 