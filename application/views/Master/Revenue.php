<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Revenue');
$this->pfrm->FrmHead1('Master / Revenue',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Revenue_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Revenue Head</td>
          <td align="left"><input type="text" placeholder="Revenue Head" id="RevenueHead" name="RevenueHead" value="<?php echo @$RevenueHead; ?>" class="scs-ctrl" />
            <div class="RevenueHead" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">RevenueShortName</td>
          <td align="left"><input type="text" placeholder="Revenue ShortName" id="RevenueShortName" name="RevenueShortName" value="<?php echo @$RevenueShortName; ?>" class="scs-ctrl" />
            <div class="RevenueShortName" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">RevenueGroup</td>
          <td align="left"><select type="text"    id="RevenueGroup_Id" name="RevenueGroup_Id"   class="scs-ctrl" >
              <option value="" > -- Select RevenueGroup -- </option>
              <?php
                    $Res=$this->Myclass->RevenueGroup();
			        $count=1;
			        foreach($Res as $row)
						{ if($row['Active']!=1){
							echo '<option value="'.$row['RevenueGroup_Id'].'"   >'.$row['RevenueGroup'].'</option>';
						    }
						}
		      ?>
            </select>
            <div class="RevenueGroup_Id" ></div></td>
        </tr>
        
        <tr>
          <td align="right" class="F_val">Taxhead</td>
          <td align="left"><input type="text" placeholder="Taxhead" id="Taxhead" name="Taxhead" value="<?php echo @$Taxhead; ?>" class="scs-ctrl" />
            <div class="Taxhead" ></div></td>
        </tr>
        
           <tr>
          <td align="right" class="F_val">Slabbased</td>
          <td align="left"><select name="Slabbased" id="Slabbased" class="scs-ctrl" >
              <option value="0" >No</option>
              <option value="1" >Yes</option>
            </select>
            <div class="Slabbased" ></div></td>
        </tr>
        
        <!--tr>
          <td align="right" class="F_val">Taxpercentage</td>
          <td align="left"><input type="text" num=1 placeholder="Taxpercentage" id="Taxpercentage" name="Taxpercentage" value="<?php echo @$Taxpercentage; ?>" class="scs-ctrl" />
            <div class="Taxpercentage" ></div></td>
        </tr--->
        
        <tr>
          <td align="right" class="F_val">HSN/SAC Code</td>
          <td align="left"><input type="text" placeholder="HSN SAC_Code" id="HSNSAC_Code" name="HSNSAC_Code" value="<?php echo @$HSNSAC_Code; ?>" class="scs-ctrl" />
            <div class="HSNSAC_Code" ></div></td>
        </tr>
        
        <tr>
          <td align="right" class="F_val">RevenueNature</td>
          <td align="left"><select name="RevenueNature" id="RevenueNature" class="scs-ctrl" >
              <option value="1" >Credit</option>
              <option value="2" >Debit</option>
            </select>
            <div class="RevenueNature" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Is Allowance</td>
          <td align="left"><input type="checkbox"  onchange="checkselectbox(this.id)" id="Allowance" name="Allowance"  <?php if(@$Allowance==1) { echo 'checked'; } ?>    />
            <div class="Allowance" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Applicable for Post Bill</td>
          <td align="left"><input type="checkbox" onchange="checkselectbox(this.id)"  id="ApplicableForPostBill" name="ApplicableForPostBill"  <?php if(@$ApplicableForPostBill==1) { echo 'checked'; } ?>    />
            <div class="ApplicableForPostBill" ></div></td>
        </tr>
         <tr>
          <td align="right" class="F_val">BillGroup</td>
          <td align="left"><select type="text"    id="BillGroup_Id" name="BillGroup_Id"   class="scs-ctrl" >
              <option value="" > -- Select BillGroup -- </option>
              <?php
                    $Res=$this->Myclass->BillGroup();
			        $count=1;
			        foreach($Res as $row)
						{ if($row['Active'] != 1) {
							echo '<option value="'.$row['BillGroup_Id'].'"   >'.$row['BillGroup'].'</option>';
						     }
						}
		      ?>
            </select>
            <div class="BillGroup_Id" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Order By</td>
          <td align="left"><input type="text" placeholder="Order By" id="OrderBy" name="OrderBy" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo @$Ord; ?>" class="scs-ctrl" />
            <div class="OrderBy" ></div></td>
        </tr>
        
        <tr>
          <td align="right" class="F_val">In Active</td>
          <td align="left"><select name="Active" id="Active" class="scs-ctrl" >
              <option value="0" >No</option>
              <option value="1" >Yes</option>
            </select>
            <div class="Active" ></div></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
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
    
	$('#Active').val(<?php echo @$Active; ?>);
	$('#BillGroup_Id').val(<?php echo @$BillGroup_Id; ?>);
	$('#RevenueNature').val(<?php echo @$RevenueNature; ?>);
	$('#RevenueGroup_Id').val(<?php echo @$RevenueGroup_Id; ?>);
	$('#Slabbased').val(<?php echo @$Slabbased; ?>);
	
});

function checkselectbox(a)
{  
  checkbox = document.getElementById(a);
  if ( document.getElementById(a).checked ) {    
    if(a=='Allowance')
    {
      document.getElementById("ApplicableForPostBill").checked = false;
    }
    if(a=='ApplicableForPostBill')
    {
      document.getElementById("Allowance").checked = false;
    }
  } 
}

</script>