<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Setting','UserRights');
$this->pfrm->FrmHead2('Setting / UserRights',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

    <div class="col-sm-12">
      <div class="the-box F_ram">
        <fieldset>
        <input type="hidden" name="idv" value="<?php echo @$GroupRights_Id; ?>" >
          <table class="FrmTable T-4" >
            <tr>
              <td align="right" class="F_val">User</td>
              <td align="left"> 
              <select class="scs-ctrl" name="UserRights_Id" id="UserRights_Id" >
              <option value="0" >-- Select --</option>
              <?php
              $Res=$this->Myclass->User();
              $count=1;          
              foreach($Res as $row)
              {
                echo '<option value="'.$row['User_id'].'" >'.$row['EmailId'].'</option>';
              }		?>
              <select          
                <div class="GroupRights" ></div></td>        
              <td align="right">&nbsp;</td>
              <td align="left"><a  onClick="Umenu_()"  class="btn btn-success btn-sm"  >Get</a></td>
            </tr>
          </table>
        </fieldset>
      </div>
    </div>
    <div class="row col-sm-12">
      <div class="col-sm-6" >
        <div class="UMenu" style="padding:10px"></div>
      </div>
      <div class="col-sm-6">
        <div class="UMenu1" style="padding:10px"></div> 
      </div> 
    </div> 

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
 function Umenu_()
 {
	 $.ajax({		
		type:"POST",
		url:"<?php echo scs_index;?>Setting/UR_R/"+$('#UserRights_Id').val(),
		success: function(html)
		{
			$('.UMenu').html(html);      
		} 
	 })
 } 


</script>
