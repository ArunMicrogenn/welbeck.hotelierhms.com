<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->wheader($this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Rates & Inventory','RatePlan');
$this->pfrm->FrmHead1('Rates & Inventory / RatePlan',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$PlanType_Id; ?>" >
       <input type="hidden" name="Keey" id="Keey" value="<?php echo @$Keey; ?>" >
      <table class="FrmTable T-12" >
        <tr>
          <td align="right" class="F_val">RoomType</td>
          <td align="left"><select type="text" onChange="RoomType_();val_();Delete_All()"  id="RoomType_Id" name="RoomType_Id"   class="scs-ctrl" >
              <option value="" > -- Select RoomType -- </option>
              <?php
          $Res=$this->Myclass->RoomType();
			$count=1;
			 
		 foreach($Res as $row)
			{
			    echo '<option value="'.$row['RoomType_Id'].'"  Adults="'.$row['Adults'].'"	 >'.$row['RoomType'].'</option>';
			}
		  ?>
            </select>
            <div class="RoomType_Id" ></div></td>
          <td align="right" class="F_val">Rate Type</td>
          <td align="left"><select type="text"   id="PlanType_Id" name="PlanType_Id" onChange="Delete_All()"  class="scs-ctrl" >
              <option value="" > -- Select Rate Type -- </option>
              <?php
          $Res=$this->Myclass->PlanType();
			$count=1;
			 
		 foreach($Res as $row)
			{
			    echo '<option value="'.$row['PlanType_Id'].'"	 >'.$row['RateCode'].'</option>';
			}
		  ?>
            </select>
            <div class="PlanType_Id" ></div></td>
          <td style="display:none" align="right" class="F_val">Declared Rate Type</td>
          <td style="display:none" align="left"><select type="text"   id="DPlanType_Id" name="DPlanType_Id"  onChange="Delete_All()"  class="scs-ctrl" >
              <option value="1" > -- Select Rate Type -- </option>
              <?php
          $Res=$this->Myclass->PlanType(1);
			$count=1;
			 
		 foreach($Res as $row)
			{
			    echo '<option value="'.$row['PlanType_Id'].'"	 >'.$row['RateCode'].'</option>';
			}
		  ?>
            </select>
            <div class="DPlanType_Id" ></div></td>
        </tr>
        </table>
        <br>
         <table class="FrmTable T-6" >
        <tr>
          <td   ><input type="checkbox"   id="TariffIncOfTaxes" name="TariffIncOfTaxes"   <?php if(@$TariffIncOfTaxes==1) { echo 'checked'; } ?>   /> Tariff Inclusive of Taxes </td>
          
        <td valign="top">
        
          <input onClick="val_()" type="checkbox" class="chk" name="Mon" id="Mon" <?php if(@$Mon==1) { echo 'checked'; } ?> > Mon
          <input  onClick="val_()" type="checkbox" class="chk" name="Tue" id="Tue" <?php if(@$Tue==1) { echo 'checked'; } ?>> Tue
          <input  onClick="val_()" type="checkbox" class="chk" name="Wed" id="Wed" <?php if(@$Wed==1) { echo 'checked'; } ?>> Wed
          
          <input  onClick="val_()" type="checkbox" class="chk" name="Thu" id="Thu" <?php if(@$Thu==1) { echo 'checked'; } ?>> Thu
          <input  onClick="val_()" type="checkbox" class="chk" name="Fri" id="Fri" <?php if(@$Fri==1) { echo 'checked'; } ?>> Fri 
          <input  onClick="val_()" type="checkbox" class="chk"  name="Sat" id="Sat" <?php if(@$Sat==1) { echo 'checked'; } ?>> Sat
          <input  onClick="val_()" type="checkbox" class="chk"  name="Sun" id="Sun" <?php if(@$Sun==1) { echo 'checked'; } ?>> Sun
          
          </td>
        </tr>
        <tr>
          <td > <input type="checkbox"   id="TariffIncOfPlan" name="TariffIncOfPlan"   <?php if(@$TariffIncOfPlan==1) { echo 'checked'; } ?>   /> Tariff Inclusive of Plan </td>
        </tr> <td></td>
        <tr>
          <td ><input type="checkbox"   id="PlanIncTax" name="PlanIncTax"   <?php if(@$PlanIncTax==1) { echo 'checked'; } ?>   /> Plan Inclusive Tax </td> <td></td>
        </tr>
      
      </table>
      
      <table width="100%" class="mytable" style="margin-top:20px">
        <thead>
          <tr>
            <th width="75">FromDate</th>
            <th width="75">ToDate</th>
            <th  ><div align="center">Single</div></th>
            <th  ><div align="center">Double</div></th>
            <th  ><div align="center">Triple</div></th>
            <th  ><div align="center">Quadruple</div></th>
            <th  ><div align="center">AdultRate</div></th>
            <th  ><div align="center">ChildRate</div></th>
            <th width="75" ><div align="center">Plan</div></th>
            <th  ><div align="center">Adult Plan<br> Amt</div></th>
            <th  ><div align="center">Child Plan<br> Amt</div></th>
            
             <th  ><div align="center">WeekEnd <br>Single</div></th>
            <th ><div align="center">WeekEnd <br>Double</div></th>
            <th ><div align="center">WeekEnd <br>Triple</div></th>
            <th ><div align="center">WeekEnd <br>Quadruple</div></th>
            
            
               <th width="50">Add</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text"  readonly value="<?php echo @$FD; ?>"   name="FromDate"   class="f-ctrl Dat" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text"   readonly value="<?php echo @$TD; ?>"  name="ToDate"   class="f-ctrl Dat" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="Single" id="Single" value="<?php echo @$Single; ?>"   class="f-ctrl rmm" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="Double" id="Double" value="<?php echo @$Doubles; ?>"    class="f-ctrl rmm" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="Triple" id="Triple" value="<?php echo @$Triple; ?>"   class="f-ctrl rmm" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="Quadruple" id="Quadruple" value="<?php echo @$Quadruple; ?>"   class="f-ctrl rmm" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="AdultRate" value="<?php echo @$AdultRate; ?>"   class="f-ctrl" style="border:2px solid #E4E4E4" /></td>
            <td><input type="text" num=1 name="ChildRate" value="<?php echo @$ChildRate; ?>"    class="f-ctrl" style="border:2px solid #E4E4E4" /></td>
            <td><select   id="FoodPlan_Id" name="FoodPlan_Id"   class="f-ctrl" style="border:2px solid #E4E4E4" >
                <option value="0" > -- Select -- </option>
                <?php
          $Res=$this->Myclass->FoodPlan();
		  $count=1;
		  foreach($Res as $row)
			{
			    echo '<option value="'.$row['FoodPlan_Id'].'"	 >'.$row['ShortName'].'</option>';
			}
		  ?>
              </select></td>
              
              
              
               <td><input type="text" num=1 name="AdultPlanAmt" id="AdultPlanAmt" value="<?php echo @$AdultPlanAmt; ?>"    class="f-ctrl " style="border:2px solid #E4E4E4" /></td>
               
                <td><input type="text" num=1 name="ChildPlanAmt" id="ChildPlanAmt" value="<?php echo @$ChildPlanAmt; ?>"    class="f-ctrl" style="border:2px solid #E4E4E4" /></td>
                
                 <td><input type="text" num=1 name="WeekSingle" id="WeekSingle" value="<?php echo @$WeekSingle; ?>"    class="f-ctrl rmm rmchk" style="border:2px solid #E4E4E4" /></td>
                 
                  <td><input type="text" num=1 name="WeekDoubles" id="WeekDoubles" value="<?php echo @$WeekDoubles; ?>"    class="f-ctrl rmm rmchk" style="border:2px solid #E4E4E4" /></td>
                  
                   <td><input type="text" num=1 name="WeekTriple" id="WeekTriple" value="<?php echo @$WeekTriple; ?>"    class="f-ctrl rmm rmchk" style="border:2px solid #E4E4E4" /></td>
                   
                    <td><input type="text" num=1 name="WeekQuadruple" id="WeekQuadruple" value="<?php echo @$WeekQuadruple; ?>"    class="f-ctrl rmm rmchk" style="border:2px solid #E4E4E4" /></td>
              
              
              <td> <a class="btn btn-success btn-sm" onClick="Rate_Set()" ><i class="fa fa-plus-circle" aria-hidden="true"></i>
 Add</a> </td>
          </tr>
        </tbody>
         <tbody   >
         <tr><td colspan="16" >&nbsp;</td></tr>
         </tbody>
        <tbody class="det" >
        <?php
        
		 $qry=" exec Update_RatePlan_Det '".@$Keey."' ";
		 $res=$this->db->query($qry);
         $res=$res->result();
		foreach($res as $row)
		 {
			 echo '<tr>';		 
			 echo '<td>'.$row->FD.'</td>';
			 echo '<td>'.$row->TD.'</td>';
			 echo '<td align="right" >'.$row->Single.'</td>';
			 echo '<td align="right" >'.$row->Doubles.'</td>';
			 echo '<td align="right" >'.$row->Triple.'</td>';
			 echo '<td align="right" >'.$row->Quadruple.'</td>';
			 echo '<td align="right" >'.$row->AdultRate.'</td>';
			 echo '<td align="right" >'.$row->ChildRate.'</td>';
			 echo '<td   >'.$row->ShortName.'</td>';
			  echo '<td align="right" >'.$row->AdultPlanAmt.'</td>';
		 echo '<td align="right" >'.$row->ChildPlanAmt.'</td>';
		 echo '<td align="right" >'.$row->WeekSingle.'</td>';
		 echo '<td align="right" >'.$row->WeekDoubles.'</td>';
		 echo '<td align="right" >'.$row->WeekTriple.'</td>';
		 echo '<td align="right" >'.$row->WeekQuadruple.'</td>';
			 echo '<td><a class="btn btn-danger btn-sm " onclick="Delete_('.$row->RatePlanDet_Id.')" >
			       <i class="fa fa-trash" aria-hidden="true"></i>Delete</a></td>';
			 echo '</tr>';
			
		 }
		
		
		
		?>
        
        </tbody>
      </table>
      <div style="margin-top:15px;" align="right" class="DAT" >
        <input type="hidden" name="DAT" id="DAT" >
      </div>
      <div style="margin-top:15px;" align="right">
        <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   />
      </div>
    </fieldset>
  </div>
  <div class="the-box D_ISS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
?>
<script>
 $(document).ready(function(e) {
    $('#RoomType_Id').val(<?php echo @$RoomType_Id; ?>);
	$('#PlanType_Id').val(<?php echo @$PlanType_Id; ?>);
	$('#DPlanType_Id').val(<?php echo @$DPlanType_Id; ?>);
	$('#FoodPlan_Id').val(<?php echo @$FoodPlan_Id; ?>);
	RoomType_();
	
});
 function Rate_Set()
 {
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/valRatePlan/",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			if((html*1)==1) { Rate_SetII(); } else { alert(html);  }
		}
		 
	 })
 }
  function Rate_SetII()
 {
	 $.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/GetRatePlan/",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			$(".det").html(html);
		}
		 
	 })
 }
 function Delete_(ee)
 {
	$.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/GetRatePlandelete/"+ee,
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			$(".det").html(html);
		}
		 
	 }) 
 }
 
 function Delete_All()
 {
	$.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/AllDell/",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			$(".det").html(html);
		}
		 
	 }) 
 }
 
 function val_()
 {
	
	var ii=0;
	$('.chk').each(function(index, element) {
        if($(this).prop('checked'))
		{
		   	
		    ii=1;
		     
			 
		}
    }); 
	 
	if(ii==1)
	{
		$('#rmchk').prop('readonly', false);
		$('.rmchk').css('background-color','#FFF');
		 RoomType_();
	}
	else
	{
		  $('.rmchk').prop('readonly', true);
	     $('.rmchk').css('background-color','#ADADAD');
		
	}
	
	 
	
 }
 
 function RoomType_()
 {
	var Adl=$("#RoomType_Id :selected").attr('Adults'); 	
	$('.rmm').prop('readonly', true);
	$('.rmm').css('background-color','#ADADAD');
	if((Adl*1)==1)
	{
		$('#Single').prop('readonly', false);
		$('#Single').css('background-color','#FFF');
		
		$('#WeekSingle').prop('readonly', false);
		$('#WeekSingle').css('background-color','#FFF');
	}
	if((Adl*1)==2)
	{
		$('#Double').prop('readonly', false);
		$('#Single').prop('readonly', false);
		$('#Double,#Single').css('background-color','#FFF');
		
		$('#WeekDoubles').prop('readonly', false);
		$('#WeekSingle').prop('readonly', false);
		$('#WeekDoubles,#WeekSingle').css('background-color','#FFF');
		
	}
	if((Adl*1)==3)
	{
		$('#Triple').prop('readonly', false);
		$('#Double').prop('readonly', false);
		$('#Single').prop('readonly', false);
		$('#Triple,#Single,#Double').css('background-color','#FFF');
		
		$('#WeekTriple').prop('readonly', false);
		$('#WeekDoubles').prop('readonly', false);
		$('#WeekSingle').prop('readonly', false);
		$('#WeekTriple,#WeekSingle,#WeekDoubles').css('background-color','#FFF');
		
	}
	
	if((Adl*1)>3)
	{
		$('#Quadruple').prop('readonly', false);
		$('#Triple').prop('readonly', false);
		$('#Double').prop('readonly', false);
		$('#Single').prop('readonly', false);
		
		$('#WeekQuadruple').prop('readonly', false);
		$('#WeekTriple').prop('readonly', false);
		$('#WeekDouble').prop('readonly', false);
		$('#WeekSingle').prop('readonly', false);
		
		$('.rmm').css('background-color','#FFF');
	}
	
	 
 }
 </script> 
