<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reprint','Checkout Bill');
$this->pfrm->FrmHead4('Reprint / Checkouts Bill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
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
			 $qry="SELECT mt.Title+'.'+m.Firstname as Name,* FROM Trans_Checkout_mas re
			 inner join Mas_Customer m on m.Customer_Id=re.customerid
			 inner join Mas_Room rm on rm.Room_Id=re.Roomid 
			 Inner join Mas_Title mt on mt.Titleid=m.Titelid 
			 where re.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' and '".date('Y-m-d',strtotime($_POST['todate']))."'
			 and isnull(re.cancelflag,0)=0  and re.Checkoutno like 'CHK%'
			  Order by Checkoutid desc";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="6" class="text-bold" style="text-align: center;">Checkout Bill Reprint</td>';			
				echo '</tr>';

				echo '<tr>';		 
				echo '<td  style="text-align: center;">Bill No</td>';
				echo '<td  style="text-align: center;">Receipt Date</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Room No</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {			
				// print_r($rows);	
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Checkoutdate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Name'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';		
				echo '<td style="text-align: right;">'.$rows['totalamount'].'</td>';
		
				$checkoutid = $rows['Checkoutid'] ?? 0;
$billid = $rows['grpcheckoutbillid'] ?? 0;
$groupcheckout = $rows['groupcheckout'] ?? 0;

echo '<td style="text-align: center;">
    <a href="#" onclick="showPrintOptions(' 
        . $checkoutid . ',' 
        . $billid . ',' 
        . $groupcheckout . ')">
        <i class="fa fa-eye"></i>
    </a>
</td>';
			
		// 	echo '<td style="text-align: center;">
		// 	<a href="#" onclick="showPrintOptions(' . $rows['Checkoutid'] . ','.$rows['grpcheckoutbillid'].','.$rows['groupcheckout'].')">
		// 		<i class="fa fa-eye"></i>
		// 	</a>
		// </td>';
		// Pass scs_index from PHP to JavaScript
	echo '<script>
	const scs_index = "' . scs_index . '";
	</script>';
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
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showPrintOptions(checkoutId,grpbillid,grpcheckout) {

    Swal.fire({
        title: 'Choose an Option',
        html: `
            <select id="printOption" class="swal2-input">
                <option value="" disabled selected>Select Print Type</option>
                <option value="checkout">Detailed Bill</option>
                <option value="summary">Summary Bill</option>
            </select>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Print',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const selectedOption = document.getElementById('printOption').value;
            if (!selectedOption) {
                Swal.showValidationMessage('Please select a print option');
                return false;
            }
            return selectedOption;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const selectedOption = result.value;
            if (selectedOption === 'summary') {
				if(grpcheckout == 1) {
                window.location.href = `${scs_index}Reprint/GroupcheckoutSummaryReprint?Checkoutid=${grpbillid}`;
			} else{
					window.location.href = `${scs_index}Reprint/CheckoutReprint?Checkoutid=${checkoutId}`;
				}
            } else if (selectedOption === 'checkout') {
				if(grpcheckout == 1) {
					window.location.href = `${scs_index}Reprint/GroupcheckoutReprint?Checkoutid=${grpbillid}`;

				} else{
					window.location.href = `${scs_index}Reprint/CheckoutReprint?Checkoutid=${checkoutId}`;
				}
            }
        }
    });
}
</script>