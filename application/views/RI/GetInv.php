<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$dats=date('m/d/Y');
$cdate=date('d-m-Y');
$TY=$_POST['TY'];
if (@$_POST['RDAT'])
{
	$qry=" GETDATE ".$DT.",'".$_POST['RDAT']."'";
	$D=$this->db->query($qry);
	$D=$D->row();
	$dats=$D->DAT;
	$cdate=$D->DATT;
}
 
  $qry="Create_Inventory '".$dats."',".HotelId.",".$_POST['RoomType'].",'".$_POST['TY']."'";
$ress=$this->db->query($qry);

$col = $ress->list_fields();
$this->db->close();
$this->db->initialize();
?>
 <div class="the-box D_ISS"  >
    <table class="intable">
      <tbody>
        <tr>
          <td>
          <a class="sbtn pull-left" onClick="Get_Inv_Avb(-14)" ><i class="fa fa-angle-double-left" aria-hidden="true"></i> </a>
          
           <a class="sbtn  " onClick="Get_Inv_Avb(-1)" ><i class="fa fa-angle-left" aria-hidden="true"></i> </a>
           <a class="sbtn   " onClick="Get_Inv_Avb(1)" ><i class="fa fa-angle-right" aria-hidden="true"></i> </a>
           
           
            <a class="sbtn  pull-right" onClick="Get_Inv_Avb(14)" ><i class="fa fa-angle-double-right" aria-hidden="true"></i> </a>
          <input style="text-align:center;color:#096DA6;font-weight:bold" type="text"   class="Dat fh-ctrl" value="<?php echo $cdate;?>" >
          <input type="hidden" name="RDAT" id="RDAT" value="<?php echo $dats;?>" >
         </td>
          <?php
$cou=0;
 foreach ($col as $field ) {
	if($cou >= 7   ) {
		
		$ary=explode('#',$field);
	
		
		$dat=explode('*',$ary[0]);
		
			
	?>
          <td><label class="tlight" ><?php echo $dat[0];?></label>
            <br>
            <label class="tstrong"><strong><?php echo @$dat[1];?></strong></label>
            <br>
            <label class="tlight"><?php echo @$dat[2];?></label></td>
          <?php } 
			   $cou++;
} ?>
        </tr>
      </tbody>
    </table>
    
    <div style="width:101.5%;height:300px;overflow:scroll" >
      
      <?php
	  $RoomType=$this->Myclass->RoomType($_POST['RoomType']);
	  
	  foreach($RoomType as $row)
	  {
		  echo '<table class="intable"><tbody  >';
		 
		  
		  
		  /*################################################*/
		  
		  $cou=0;
			  echo '<tr><td style="text-align:left !important;color:#116bd9 !important" >&nbsp;&nbsp;<i class="fa fa-bed" aria-hidden="true"></i>&nbsp;&nbsp;
'.$row['RoomType'].'</td>';

       $qrys="exec Get_Room_Avb ".$row['RoomType_Id'].",".Hotel_Id.",'".$dats."'";
	    $this->db->close();
		$this->db->reconnect();	   
	   $Roms=$this->db->query($qrys);
			  foreach ($Roms->result() as $Rress )
			   {
					   
						echo '<td><input name="RINV[]" type="text" num=1 class="fh-ctrl" value="'.$Rress->INV.'" ></td>';
						echo '<input type="hidden" name="Inv_Id[]" value="'.$Rress->Inv_Id.'" >';
			  			 
			   } 
			   echo '</tr>';
	  
	      /*###############################################*/
		  
		   $this->db->close();
		 $this->db->reconnect();	 
		  $qry="exec Create_Inventory '".$dats."',".Hotel_Id.",".$row['RoomType_Id'].",'".$TY."'";
		  $ress=$this->db->query($qry);
		  
		  foreach ($ress->result() as $Ho)
		  {
			  $cou=0;
			  echo '<tr><td style="text-align:left !important" >&nbsp;&nbsp;'.$Ho->PlanType.'</td>';
			  foreach ($col as $field )
			   {
				   
					   if($cou >= 7   ) {
						   
						   $ary=explode('#',$field);
						   $dat=explode('*',$ary[0]);
						    
						   
						echo '<td><input name="IAMT[]"  type="text" id="R'.rand().rand().'" num=1 class="fh-ctrl ttxtg " onBlur="blr_(this.id)" value="'.@$Ho->$field.'" ></td>';
						echo '<input type="hidden" name="RoomType_Id[]" value="'.$Ho->RoomType_Id.'" >';
						echo '<input type="hidden" name="PlanType_Id[]" value="'.$Ho->PlanType_Id.'" >';
						echo '<input type="hidden" name="IDATE[]" value="'.$ary[1].'" >';
						
			  			 }
						 $cou++;
			   } 
			   echo '</tr>';
		   
		  }
		  
		  echo ' </tbody></table>  ';
	 }
	 
	  ?> 
        
     </div>
  </div>