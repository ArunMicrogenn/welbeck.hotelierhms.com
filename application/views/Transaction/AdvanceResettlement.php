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
$this->pweb->Cheader('Settlement','Advance Resettlement');
$this->pfrm->FrmHead3('Settlement / Advance Resettlement',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
   <fieldset>
		
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div>
		
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 
			 $i=1;
			    $qry="select * from Trans_Receipt_mas 	rec
			 left outer join trans_checkout_mas tcmas on tcmas.roomgrcid = rec.roomgrcid
					inner join mas_Customer cus on cus.Customer_Id=rec.customerid
					left outer join Mas_Title ti on ti.Titleid=cus.Titelid
					inner join Mas_Room rom on rom.Room_Id=rec.roomid
					where ReceiptType='C' and rptdate between '".date('Y-m-d')."' and '".date('Y-m-d')."' and isnull(rec.cancel,0) = 0 order by Receiptno desc";
			 $exec=$this->db->query($qry); $totalAdvance=0;



//   foreach ($exec->result_array() as $rows){
// 	echo "<pre>";
// 	print_r($exec);
// 	echo "<pre>";
//   }
       
		
	

 
			 
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="6" class="text-bold" style="text-align: center;">Advance Resettlement</td>';			
				echo '</tr>';
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
				 $sqry = "select * from trans_checkout_mas tmas inner join trans_receipt_mas
				amas on amas.roomgrcid = tmas.roomgrcid where tmas.roomgrcid ='".$rows['roomgrcid']."' and amas.receiptid ='".$rows['Receiptid']."' " ;	
                     $qrycount = $this->db->query($sqry)->result_array();
				 $count  = count($qrycount);

				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['Receiptno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['rptdate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';		
				echo '<td style="text-align: right;">'.$rows['Amount'].'</td>';
		 if($count == 0) {
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/AdvanceResettlement_Edit/'.$rows['Receiptid'].'"><i class="fa fa-pencil"></i></a></td>';
				 }  else{
					echo '<td style="text-align: center;"><a onclick = checkouting() ><i class="fa fa-pencil"></i></a></td>';
				 }
			 
				echo '</tr>';				
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
	function checkouting(){

          $.ajax({
				contentType: false,
				cache: false,
				processData: false,
            success: function (result) {
				swal("warning...!", "Sorry After Checkout Cannot Edit Advance...!", "warning");
			
			
			   }			  
			 });
          		   
				};
          		   
</script>
 
<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>