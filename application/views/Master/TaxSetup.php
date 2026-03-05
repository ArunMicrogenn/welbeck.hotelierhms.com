<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','TaxSetup');
$this->pfrm->FrmHead2('Master / TaxSetup',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$TaxSetup_Id; ?>" >
      <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Revenue</td>
          <td align="left"><select type="text"    id="Revenue" name="Revenue"   class="scs-ctrl" >
              <option value="" > -- Select RevenueGroup -- </option>
              <?php
                    $Res=$this->Myclass->Revenue();
			        $count=1;
			        foreach($Res as $row)
						{
							if($row['Slabbased']==1)
							{
							  echo '<option value="'.$row['Revenue_Id'].'"   >'.$row['RevenueHead'].'</option>';
							}
						}
		      ?>
            </select>
            <div class="Revenue" ></div></td>
          <td><a class="btn-warning btn-sm btn" onClick="GeTasx()" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Get</a></td>
        </tr>
          </tr>
        
      </table>
      <table class="FrmTable T-4" >
        <tr>
          <td class="TaxDet" ></td>
        </tr>
      </table>
      
      
  <table class="FrmTable T-4" >
    <tr>
      <td colspan="4" align="right"> <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="SAVE"   /></td>
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
 
 

function GeTasx()
{
  	$.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>GetVal/TaxSetp/",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			$('.TaxDet').html(html);
		}
		 
	 })
}

</script>