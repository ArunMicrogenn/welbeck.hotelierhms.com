<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('RI','RatePlan');
$this->pfrm->FrmHead2('RI / RatePlan',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");


?>

<div class="col-sm-12" style="">
  <div class="the-box F_ram" >
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
      <input type="hidden" name="TY" value="Single" id="TY" >
      <table class="FrmTable T-12" style="background-color:FFF !important" >
        <tr>
          <td align="left"><select type="text"   id="RoomType" name="RoomType" onChange="Get_Inv_Avb(0)"   class="scs-ctrl" >
              <option value="0" > -- All RoomType -- </option>
              <?php
          $Res=$this->Myclass->RoomType();
			$count=1;
			 
		 foreach($Res as $row)
			{
			    echo '<option value="'.$row['RoomType_Id'].'"	 >'.$row['RoomType'].'</option>';
			}
		  ?>
            </select>
            <div class="RoomType" ></div></td>
          <td align="left"><input type="radio" name="Rate" value="Single" class="flat-red" checked >
            Single
            
            <input type="radio" name="Rate" class="flat-red" value="Doubles"  onClick="Get_Ty_Avb('Doubles')"  >
            Doubles
            
              <input type="radio" name="Rate" class="flat-red" value="Triple" onClick="Get_Ty_Avb('Triple')"   >
            Triple
            
                 <input type="radio" name="Rate" class="flat-red" value="Quadruple" onClick="Get_Ty_Avb('Quadruple')"  >
            Quadruple
            
           <!-- <input  name="Rate"  type="radio" class="flat-red" value="AdultRate" >
            AdultRate
            <input  name="Rate"  type="radio" class="flat-red" value="ChildRate" >
            ChildRate--> <a class="btn btn-info btn-sm" onClick="Inv_Save()" > <i class="fa fa-floppy-o" aria-hidden="true"></i> <strong>SAVE</strong></a> <a class="btn btn-info btn-sm" > <strong><i class="fa fa-floppy-o" aria-hidden="true"></i> BULK SAVE</strong></a>
            <input type="reset"  class="btn btn-warning btn-sm"   ></td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_ISSE"  >
     <input type="hidden" name="RDAT" id="RDAT" value="<?php echo date('m-d-Y');?>" >
   
    
  </div>
</div>


 
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<script>
 
 $(document).ready(function(e) {
	 
       
	  Get_Inv_Avb(0);
	   
	  
});
 
  function Get_Ty_Avb(ee)
 {
	 
 }
 
 function Get_Inv_Avb(ee)
 {
	 var RDAT=$("#RDAT").val();
	 $(".D_ISSE").html('<div id="Lodinggif" ><br><br> <img width="128" height="128" src="<?php echo scs_url;?>ring.gif" ></div>');
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/GetInv/"+ee,
		data:$('#scsfrm').serialize()+"&RDAT="+RDAT,
		success: function(html)
		{
			 $(".D_ISSE").html(html);
		}
		 
	 })
 }
 
 function Inv_Save()
 {
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/InvUpdate/",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			//$(".D_ISS").html(html);
		}
		 
	 })
 }
 
 function blr_(ee)
 {
    $("#"+ee).addClass('ttxtr') ;
	 
 }
 function Rate_Set()
 {
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/GetRate/"+$('#RoomType').val() ,
		success: function(html)
		{
			$(".D_ISS").html(html);
		}
		 
	 })
 }
 
   $(function () {
 //iCheck for checkbox and radio inputs
    
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
	
   })
   
   
   $(document).ready(function () {
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').on('ifClicked', function (event) {
		
		 
		$('#TY').val(this.value);
	 
	 Get_Inv_Avb(0);
        
    });
    
});
   
   
   $(document).ready(function(e) {
    
	$('.box,.box-body').addClass('myinvbox');
});
 </script> 
