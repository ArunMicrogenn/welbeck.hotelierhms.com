<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Settings','User');
$this->pfrm->FrmHead1('Settings / User',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$User_id; ?>"  >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">User Name</td>
          <td align="left"><input type="text" placeholder="User Name" id="EmailId" name="EmailId" value="<?php echo @$EmailId; ?>" class="scs-ctrl" />
          <div class="EmailId" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Password</td>
          <td align="left"><input type="Password" placeholder="Password" id="Password" name="Password" value="<?php echo base64_decode(@$Password); ?>" class="scs-ctrl" />
          <div class="Password" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Confirm Password</td>
          <td align="left"><input type="Password" placeholder="Confirm Password" id="CPassword" name="CPassword" value="<?php echo base64_decode(@$Password); ?>" class="scs-ctrl" />
          <div class="CPassword" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">User Group</td>
          <td align="left"><select type="text"    id="UserGroup_Id" name="UserGroup_Id"   class="scs-ctrl" >
              <option value="" > -- Select User Group -- </option>
              <?php
                $Res=$this->Myclass->UserGroup();
			          $count=1;			 
		            foreach($Res as $row)
			            { 
                    if($row['Active']!=1)
                      {
                        echo '<option value="'.$row['UserGroup_Id'].'"   	 >'.$row['UserGroup'].'</option>';
                      }
                  }		  ?>
            </select>
            <div class="UserGroup_Id" ></div></td>
        </tr>
        <tr>
           <td align="right" class="F_val">In Active</td>
           <td align="left"> 
		     <select name="InActive" id="InActive" class="scs-ctrl" value="<?php echo @$InActive; ?>" >
             <option value="0" >No</option>
             <option value="1" >Yes</option>
              </select>
            <div class="InActive" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Discount Percent</td>
          <td align="left"><input type="text" placeholder="Discount Percent" id="Disper" name="Disper" onChange="disper(this.value);" value="<?php if(@$disper){echo @$disper;} else { echo 0;}; ?>" class="scs-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
          <div class="Disper" ></div></td>
        </tr>

        <tr>
          <td align="right" class="F_val">Discount Amount</td>
          <td align="left"><input type="text" placeholder="Discount Amount" id="DisAmt" name="DisAmt"  value="<?php if(@$disAmount){echo @$disAmount;} else { echo 0;}; ?>" class="scs-ctrl" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
          <div class="DisAmt" ></div></td>
        </tr>
        <tr>
           <td align="right" class="F_val">Grace Hours</td>
           <td align="left"> 
		     <select name="GraceHours" id="GraceHours" class="scs-ctrl" value="<?php echo @$grace_hours; ?>" >
             <option value="0" >No</option>
             <option value="1" >Yes</option>
              </select>
            <div class="GraceHours" ></div></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"/></td>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

 const disper = (a) =>{
  //document.getElementById('DisAmt').value = "0.00";
  if(a > 100 || a ==''){
    let msg = "Percentage should be below 100";
    document.getElementById('Disper').value = "0";
    return Swal.fire(msg);
  }
 }

 $(document).ready(function(e) {
    
	$('#InActive').val(<?php echo @$InActive; ?>);
  $('#UserGroup_Id').val(<?php echo @$UserGroup_Id; ?>);
	
});


 </script>
