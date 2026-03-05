<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
//$this->pweb->menu($this->Menu,$this->session);
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
	{ $auditdate=date('Y/m/d',strtotime($row['DateofAudit'])); 
    $auditdate1=date('d/m/Y',strtotime($row['DateofAudit'])); }
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
               <td align="left">
                <a class="btn btn-danger btn-sm" ><strong>Occupied</strong></a> 
                <a class="btn btn-sm" style="background-color: #5abbff;color:#ffffff !important" >  <strong>Unsettled</strong></a>
                <a class="btn btn-sm" style="background-color: #B101D5;color:#ffffff !important" >  <strong>Management</strong></a>
                <a class="btn btn-sm" style="background-color: #222222;color:#ffffff !important" >  <strong>Maintenance</strong></a>
                <a href=" " class="btn btn-sm" style="background-color: Green;color:#ffffff !important" ><i class="fa fa-refresh" aria-hidden="true"></i> <strong>Reload</strong></a>
                <a>Last Night Audit Date:<?php echo $auditdate1; ?> Current Time:<?php echo date("H:i:s") ?></a>
          </tr>
        </table>
      </fieldset>
    </div>
  </div>
  <div class="col-sm-10" style="padding-right:0px">
    <div class="the-box D_ISSE"  >
      <input type="hidden" name="RDAT" id="RDAT" value="<?php echo $auditdate;?>" >
    </div>
  </div>
  <div class="col-sm-2" style="padding:0px">
    <div id="datepicker" ></div>
  </div>
</div>
<?php
$this->pfrm->wrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
 $( function() {
   $('#datepicker').datepicker().on('changeDate', function(e) {	  
   var today = new Date().getFullYear()+'/'+("0"+(new Date().getMonth()+1)).slice(-2)+'/'+("0"+new Date().getDate()).slice(-2)
    if(today >e.format(0,"yyyy/mm/dd") )
    {
      swal("Warning", "Unable To Select Previous Date", "warning");
    }
    else
    {
      Get_Inv_Avb(0,e.format(0,"yyyy/mm/dd"));
    }
    });
       });
   
 $(document).ready(function(e) {        
	Get_Inv_Avb(0,'<?php echo $auditdate; ?>');	  
});
 
  function Get_Ty_Avb(ee)
 {
	 
 }
 
 function Get_Inv_Avb(ee,RDAT)
 {   RoomType=$('#RoomType').val();
	 $(".D_ISSE").html('<div id="Lodinggif" ><br><br> <img width="128" height="128" src="<?php echo scs_url;?>ring.gif" ></div>');
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/GetChart/"+ee,
		data:$('#scsfrm').serialize()+"&RDAT="+RDAT+"&RoomType="+RoomType,
		success: function(html)
		{
			$(".D_ISSE").html(html);
		}
		 
	 });
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
      radioClass   : 'iradio_flat-green',
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