<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','Data Purging');
$this->pfrm->FrmHead2('Setting / Data Purging',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 $date=date("Y-m-d");
 $time= date("H:i:s");
 $bool=false;
  
 ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$TaxSetup_Id; ?>" >
	  <input type="hidden" name="allmaster" value="0" >
	  <input type="hidden" name="customer" value="0" >
	 	<table class="FrmTable T-4" >        
			<tr>
			<td align="right" class="F_val">Clear With All Masters</td>
          	<td align="left"><input type="checkbox"  onchange="checkselectbox(this.id)" value="1" id="allmaster" name="allmaster" /></td>	
          	<td align="right" class="F_val">Clear With Customer Master</td>
          	<td align="left"><input type="checkbox"  onchange="checkselectbox(this.id)" value="1" id="customer" name="customer"  /></td>
        	</tr>
		</table>
		<table  width="100%" class="mytable" style="margin-top:20px">
        <thead>
		<tr>
		<th>S.No</th>
		<th>Tables</th>
		<th>Action</th>
		</tr>
		</thead>
		<tbody id="dataTable">
		 <tr><td>1.</td><td>Trans_Checkin_mas</td><td>Truncate</td></tr>
		 <tr><td>2.</td><td>Trans_Roomdet_det</td><td>Truncate</td></tr>
		 <tr><td>3.</td><td>Trans_Roomdet_det_rent</td><td>Truncate</td></tr>
		 <tr><td>4.</td><td>Trans_Receipt_mas</td><td>Truncate</td></tr>
		 <tr><td>5.</td><td>Trans_advancereceipt_mas</td><td>Truncate</td></tr>
		 <tr><td>6.</td><td>Trans_checkout_mas</td><td>Truncate</td></tr>
		 <tr><td>7.</td><td>Trans_RoomCustomer_det</td><td>Truncate</td></tr>
		 <tr><td>8.</td><td>Trans_Checkout_det</td><td>Truncate</td></tr>
		 <tr><td>9.</td><td>Trans_pay_det</td><td>Truncate</td></tr>
		 <tr><td>10.</td><td>Trans_blockmas</td><td>Truncate</td></tr>
		 <tr><td>11.</td><td>Trans_Credit_Entry</td><td>Truncate</td></tr>
		 <tr><td>12.</td><td>Trans_RoomSwap_Mas</td><td>Truncate</td></tr>
		 <tr><td>13.</td><td>Trans_Reserve_Mas</td><td>Truncate</td></tr>
		 <tr><td>14.</td><td>Trans_Reserve_Det</td><td>Truncate</td></tr>
		 <tr><td>15.</td><td>Trans_Reserve_Det1</td><td>Truncate</td></tr>
		 <tr><td>16.</td><td>Trans_RoomAvailability_Chart</td><td>Truncate</td></tr>
		 <tr><td>17.</td><td>Trans_reserveadd_mas</td><td>Truncate</td></tr>
		 <tr><td>18.</td><td>Trans_reserveadd_det</td><td>Truncate</td></tr>
		 <tr><td>19.</td><td>Trans_reservecancel_mas</td><td>Truncate</td></tr>
		 <tr><td>20.</td><td>Trans_reservecancel_det</td><td>Truncate</td></tr>
		 <tr><td>21.</td><td>Temp_Trans_Credit_Entry</td><td>Truncate</td></tr>
		 <tr><td>22.</td><td>Mas_customer</td><td>Truncate</td></tr>
		 <tr><td>23.</td><td>Mas_Room</td><td>Truncate</td></tr>
		 <tr><td>24.</td><td>Room_status</td><td>Truncate</td></tr>
		 <tr><td>25.</td><td>Mas_Floor</td><td>Truncate</td></tr>
		 <tr><td>26.</td><td>Mas_Room_Facility</td><td>Truncate</td></tr>
		 <tr><td>27.</td><td>Mas_Block</td><td>Truncate</td></tr>
		
		 


		</tbody>
		</table>		
        <table class="FrmTable T-4" >
        <tr>
        <td colspan="4" align="right"> <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="SAVE"   /></td>
        </tr>
        </table> 
 
    </fieldset>
	

	<!--INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable1')" /------>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?><SCRIPT language="javascript">
      function checkselectbox(a)
{  
  checkbox = document.getElementById(a);
  if ( document.getElementById(a).checked ) {    
    if(a=='customer')
    {
      document.getElementById("allmaster").checked = false;
    }
    if(a=='allmaster')
    {
      document.getElementById("customer").checked = false;
    }
  } 
}

	</SCRIPT>