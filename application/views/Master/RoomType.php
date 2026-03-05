<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','RoomType');
$this->pfrm->FrmHead1('Master / RoomType',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

setcookie("IMG",@$IMGKEY, time()+3600, "/","", 0);
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$RoomType_Id; ?>" >
     <input type="hidden" name="IMGKEY" value="<?php echo @$IMGKEY; ?>" >
      <table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">Room Type</td>
          <td align="left"><input type="text" placeholder="RoomType" id="RoomType" name="RoomType" value="<?php echo @$RoomType; ?>" class="scs-ctrl" />
            <div class="RoomType" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">OTA RoomType Code</td>
          <td align="left"><input type="text" placeholder="OTA RoomType Code" id="otaroomtypecode" name="otaroomtypecode" value="<?php echo @$otaroomtypecode; ?>" class="scs-ctrl" />
            <div class="otaroomtypecode" ></div></td>
        </tr>
         <tr>
          <td align="right" class="F_val">Printing Name</td>
          <td align="left"><input type="text" placeholder="Printing Name" id="PrintingName" name="PrintingName" value="<?php echo @$PrintingName; ?>" class="scs-ctrl" />
            <div class="PrintingName" ></div></td>
        </tr>
		  <tr>
          <td align="right" class="F_val">Number of Occupency</td>
          <td align="left"><input type="Number" placeholder="Number of Occupency" id="occupency" name="occupency" value="<?php echo @$Adults; ?>" class="scs-ctrl" />
            <div class="occupency" ></div></td>
          </tr>
		  <tr>
          <td align="right" class="F_val">Extra Bed Count</td>
          <td align="left"><input type="Number" placeholder="Extra Bed Count" id="bedcount" name="bedcount" value="<?php echo @$Extrabedcount; ?>" class="scs-ctrl" />
            <div class="bedcount" ></div></td>
          </tr>
		  <tr>
          <td align="right" class="F_val">Extra Bed Amount</td>
          <td align="left"><input type="Number" placeholder="Extra Bed Amount" id="bedamt" name="bedamt" value="<?php echo @$Extrabedamount; ?>" class="scs-ctrl" />
            <div class="bedamt" ></div></td>
          </tr>
         <tr>
          <td align="right" class="F_val">Order By</td>
          <td align="left"><input type="Number" placeholder="Order By" id="OrderBy" name="OrderBy" value="<?php echo @$orderby; ?>" class="scs-ctrl" />
            <div class="OrderBy" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">In Active</td>
          <td align="left"> <select name="Active" id="Active" class="scs-ctrl" >
          <option value="0" >No</option>
          <option value="1" >Yes</option>
          
          </select>
            <div class="Active" ></div></td>
        </tr>
        
        <tr>
          <td align="right" class="F_val">Upload Photo</td>
          <td align="left"><input name="file" id="file" type="file"   class="scs-ctrl" />
            <div class="Amount" ></div>
            <div id="uploads">
<img src="http://localhost:8021/ho/<?php echo @$IMGKEY; ?>.jpg" width="200">
		</div>
            
            </td>
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
 
 <script type="text/javascript">

		$(document).ready(function() {
			$("#file").AjaxFileUpload({
				onComplete: function(filename, response) {
					 
					$("#uploads").append(
						$("<img />").attr("src", '<?php echo scs_url; ?>ho/'+response.name).attr("width", 200)
					);
				}
			});
				$('#Active').val(<?php echo @$InActive; ?>);
		});

	</script>
