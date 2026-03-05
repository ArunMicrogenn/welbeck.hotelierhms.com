<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Room');
$this->pfrm->FrmHead1('Master / Room',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>

<div class="the-box F_ram">
 
  <div class="col-sm-6">
    <fieldset><legend >Room</legend>
      <input type="hidden" name="idv" value="<?php echo @$Room_Id; ?>" >
      <table class="FrmTable T-12" >
        <tr>
          <td align="right" class="F_val">Room No</td>
          <td align="left"><input type="text" placeholder="Room No" id="RoomNo" name="RoomNo" value="<?php echo @$RoomNo; ?>" class="scs-ctrl" />
            <div class="RoomNo" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Room Type</td>
          <td align="left"><select type="text"    id="RoomType_Id" name="RoomType_Id"   class="scs-ctrl" >
              <option value="" > -- Select Room Type -- </option>
              <?php
          $Res=$this->Myclass->RoomType();
			$count=1;
			 
		 foreach($Res as $row)
			{
				if($row['InActive']!=1)
				{
			    echo '<option value="'.$row['RoomType_Id'].'"   	 >'.$row['RoomType'].'</option>';
				}
			}
		  ?>
            </select>
            <div class="RoomType_Id" ></div></td>
        </tr>
		<tr>
          <td align="right" class="F_val">Floor</td>
          <td align="left"><select type="text"    id="Floor_Id" name="Floor_Id"   class="scs-ctrl" >
              <option value="" > -- Select Floor -- </option>
              <?php
          $Res=$this->Myclass->Floor();
			$count=1;
			 
		 foreach($Res as $row)
			{ 
			if($row['Active']!=1)
				{
			    echo '<option value="'.$row['Floor_Id'].'"   	 >'.$row['Floor'].'</option>';
			
				}
			}
		  ?>
            </select>
            <div class="Floor_Id" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">Block</td>
          <td align="left"><select type="text"    id="Block_Id" name="Block_Id"   class="scs-ctrl" >
              <option value="" > -- Select Block -- </option>
              <?php
          $Res=$this->Myclass->Block();
			$count=1;
			 
		 foreach($Res as $row)
			{ if($row['Active']!=1)
				{
			    echo '<option value="'.$row['Block_Id'].'"   	 >'.$row['Block'].'</option>';
				}
			}
		  ?>
            </select>
            <div class="Block_Id" ></div></td>
        </tr>
        <tr>
          <td align="right" class="F_val">BedType</td>
          <td align="left"><select type="text"    id="BedType_Id" name="BedType_Id"   class="scs-ctrl" >
              <option value="" > -- Select BedType -- </option>
              <?php
          $Res=$this->Myclass->BedType();
			$count=1;
			 
		 foreach($Res as $row)
			{
				if($row['InActive']!=1)
				{
			    echo '<option value="'.$row['BedType_Id'].'"   	 >'.$row['BedType'].'</option>';
				}
			}
		  ?>
            </select>
            <div class="BedType_Id" ></div></td>
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
          <td align="right">&nbsp;</td>
          <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT;?>"   /></td>
        </tr>
      </table>
    </fieldset>
  </div>
   <div class="col-sm-6">
     <fieldset><legend >Facility</legend>
   <?php 
   
      if(@$RoomNo=='')
	  {
   
			$Res=$this->Myclass->Facility();
		    foreach($Res as $row)
			{
				 
               echo  '<input type="checkbox" name="FAC[]" value="'.$row['Facility_Id'].'"   > '.$row['Facility'].'<br>';
					  
			}
	  }
	  else
	  {
		    $qry="EditHotelFacilit '".$RoomNo."',".Hotel_Id;
			$Res=$this->db->query($qry);
			
		    foreach($Res->result_array() as $row)
			{
				
				$chk='';
				if($row['Chk']==1)
				{
					$chk='checked';
				}
				 
               echo  '<input '.$chk.' type="checkbox" name="FAC[]" value="'.$row['Facility_Id'].'" > '.$row['Facility'].'<br>';
					  
			}
	  }
			?>
   </fieldset>
   <div class="Facility" ></div>
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
    $('#Floor_Id').val(<?php echo @$Floor_Id; ?>);
	$('#RoomType_Id').val(<?php echo @$RoomType_Id; ?>);
	$('#Block_Id').val(<?php echo @$Block_Id; ?>);
	$('#BedType_Id').val(<?php echo @$BedType_Id; ?>);
	$('#Active').val(<?php echo @$InActive; ?>);

});
</script>