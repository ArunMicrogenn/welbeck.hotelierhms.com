<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
//$this->pweb->Cheader('RI','RatePlan');
//$this->pfrm->wrmHead1('RI / RatePlan',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>
<br>
<div  >
<ul class="nav nav-tabs">
  <li class="active"><a href="#"><i class="fa fa-desktop" aria-hidden="true"></i>
 Front Desk</a></li>
  <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>
 Guest Details</a></li>
</ul>
<div >
<?php 
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=date('Y-m-d',strtotime($row['DateofAudit'])); }
?>
  <div class="col-sm-12" >
    <div   >
      <fieldset  >
        <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
        <input type="hidden" name="TY" value="Single" id="TY" >
        <table class="FrmTable T-12" style="background-color:FFF !important" >
          <tr>
            <td style="width:16%" align="left"><select type="text"   id="RoomType" name="RoomType" onChange="Get_Inv_Avb(0,'<?php echo $auditdate; ?>')"   class="scs-ctrl" >
                <option value="0" > -- All RoomType -- </option>
                <?php
          $Res=$this->Myclass->RoomType();
			$count=1;
			 
		 foreach($Res as $row)
			{  if($row['InActive'] !=1)
				{
			    echo '<option value="'.$row['RoomType_Id'].'"	 >'.$row['RoomType'].'</option>';
			    }
			}
		  ?>
              </select>
              <div class="RoomType" ></div></td>
            <td align="left"><a class="btn btn-info btn-sm" onClick="Inv_Save()" > <i class="fa fa-floppy-o" aria-hidden="true"></i> <strong>Current</strong></a> <a class="btn btn-info btn-sm" onClick="Inv_Save()" > <i class="fa fa-floppy-o" aria-hidden="true"></i> <strong>One Day</strong></a>
              <input type="reset"  class="btn btn-warning btn-sm"   ></td>
          </tr>
        </table>
      </fieldset>
    </div>
  </div>
  <div class="col-sm-10" style="">
    <div class="the-box D_ISSE"  >
      <input type="hidden" name="RDAT" id="RDAT" value="<?php echo $auditdate;?>" >
    </div>
  </div>
  <div class="col-sm-2" style="">
    <div id="datepicker"  style="margin-left:-15px"  ></div>
  </div>
</div>
<?php
$this->pfrm->wrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<script>
  $( function() {
   
$('#datepicker').datepicker().on('changeDate', function(e) {
	
   Get_Inv_Avb(0,e.format(0,"yyyy/mm/dd")); 

});
   
     });
  </script> 
<script>
 
 $(document).ready(function(e) {
	 
       
	  Get_Inv_Avb(0,'<?php echo $auditdate; ?>');
	   
	  
});
 
  function Get_Ty_Avb(ee)
 {
	 
 }
 
 function Get_Inv_Avb(ee,RDAT)
 {
	 RoomType=$('#RoomType').val();
	 $(".D_ISSE").html('<div id="Lodinggif" ><br><br> <img width="128" height="128" src="<?php echo scs_url;?>ring.gif" ></div>');
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/GetChart/"+ee,
		data:$('#scsfrm').serialize()+"&RDAT="+RDAT+"&RoomType="+RoomType,
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