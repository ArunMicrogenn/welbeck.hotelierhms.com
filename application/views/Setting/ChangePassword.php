<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Settings','Change Password');
$this->pfrm->FrmHead9('Settings / Change Password',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<?php 
  $Res=$this->Myclass->User(User_id);
  $count=1;			 
  foreach($Res as $row){
    $username = $row['EmailId'];
    $User_id = $row['User_id'];
  }
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <input type="hidden" name="username" value="<?php echo $User_id; ?>"  >
      <table class="FrmTable T-4" >
       
        <tr>
          <td align="right" class="F_val">username</td>
              <td align="left"><input type="text"  placeholder="name" id="name" name="name" value="<?php echo $username;?>" readonly class="scs-ctrl" />
              <div class="name" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Old Password</td>
          <td align="left"><input type="text"  placeholder="Old Password" id="OldPassword" name="OldPassword" maxlength="12"  class="scs-ctrl" />
          <div class="OldPassword" ></div></td>
        </tr>

        <tr>
          <td align="right" class="F_val">New Password</td>
          <td align="left"><input type="Password" placeholder="New Password" id="Password" maxlength="12" name="Password" value="<?php echo base64_decode(@$Password); ?>" class="scs-ctrl" />
          <div class="Password" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Confirm Password</td>
          <td align="left"><input type="Password" placeholder="Confirm Password" id="CPassword" maxlength="12" name="CPassword" value="<?php echo base64_decode(@$Password); ?>" class="scs-ctrl" />
          <div class="CPassword" ></div></td>
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

// const username = document.getElementById("username");

// username.addEventListener("change", ()=>{
//     let userid = username.value;
//     $.ajax({
//         type: 'post',
//         url: '<?php echo scs_index ?>Setting/getUserPassword',
//         data: 'userid='+userid,
//         success: function (result) {
//           if(result){
//             document.getElementById("OldPassword").value = result;
//           }
//         }
//   });

// });


 </script>
