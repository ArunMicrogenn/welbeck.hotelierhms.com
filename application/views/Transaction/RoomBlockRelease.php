<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Room Block Release');
$this->pfrm->FrmHead2('Transaction / Room Block Release',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

  $date=date("Y-m-d");
  $time= date("H:i:s");
  $previousdate=date('Y-m-d', strtotime("-1 days"));
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  foreach ($res->result_array() as $row)
	{ $auditdate=$row['DateofAudit']; }
	 $creditdate=date('Y-m-d',strtotime($auditdate.'+1 days'));
?>


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
        <table class="FrmTable T-8" >
        <tr>
          <td align="right" class="F_val">Room Number</td>
          <td align="left">
		   <select  onchange="fetchdepdate(this.value);" id="roomid" name="roomid" class="scs-ctrl">
		    <option value="">---Select Room---</option>
            <?php $sql="select * from Room_Status rs
					Inner Join Mas_Room rm on rm.Room_Id=rs.Roomid
					 where Status<>'Y' and isnull(blocked,0)=1";
				  $res=$this->db->query($sql);
				  foreach ($res->result_array() as $row)
				  {
                   echo '<option value="'.$row['Room_Id'].'">'.$row['RoomNo'].'</option>';
  			      } ?>
			 </select>
			 	<div class="roomid"></div>
            </td>
			<td ></td>
			<td></td>
        </tr>
		<tr>
		<td align="right" class="F_val">From Date</td>
			<td align="left">
                    <input readonly name="fromDate" id="fromDate" type="text"  class="scs-ctrl  rmm" />
			<div class="fromDate"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>
		 <tr>
		<td align="right" class="F_val">To Date</td>
			<td align="left">
				<input readonly name="toDate" id="toDate" type="text"  class="scs-ctrl  rmm" />
			    <div class="toDate"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>
		 <tr>
		<td align="right" class="F_val">From Time</td>
			<td align="left">
				<input readonly name="fromtime" id="fromtime" type="text"  class="scs-ctrl  rmm" />
			    <div class="fromtime"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>	
		 <tr>
		<td align="right" class="F_val">To Time</td>
			<td align="left">
				<input readonly name="totime" id="totime" type="text"  class="scs-ctrl  rmm" />
			    <div class="totime"></div>
			</td>
		 <td></td>
		 <td></td>
		 </tr>			
		 <tr>
		  <td  align="right">Block Type</td>
		  <td  align="Left"><input type="text" readonly Name="BlockType" id="BlockType" class="scs-ctrl" /> </td>
          <td align="right">&nbsp;</td>
        </tr>
		<input type="hidden" id="blockid" name="blockid"/>
		<tr>
		  <td  align="right">Reason</td>
		  <td  align="Left"><input type="text" Name="reason" id="reason" class="scs-ctrl" /> <div class="reason"></div></td>
          <td align="right">&nbsp;</td>
        </tr>
		<tr>
		 <td align="right">&nbsp;</td>         
		 <td align="left"><input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="Update"   />
		           		  </td>
		  <td></td>
		  <td></td>
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
 function fetchdepdate(Roomid)
 {
	$.ajax({
		     url:"<?php echo scs_index ?>Transaction/getBlock?Roomid="+Roomid,
         	 type: "POST",
			 dataType: "json",
			 success:function(response){
				console.log(response);
				// $('#depdate').val(result.depdate);
				 var len = response.length;
				   $('#depdate').text('');
				   
					 // Read values
					 var fromDate = response[0].fromdate;
					 var toDate = response[0].todate;
					 var mblock = response[0].mblock;
					 var foblock = response[0].foblock;	
					 var blockid = response[0].blockid;										 
					 var fromtime = response[0].fromtime;										 
					 var totime = response[0].totime;										 
					 
					 $('#blockid').val(blockid);
					 $('#fromDate').val(fromDate);
					 $('#toDate').val(toDate);
					 $('#fromtime').val(fromtime);
					 $('#totime').val(totime);
					 if(mblock==1)
					 {$('#BlockType').val("M-Blobk");}
					 else
					 {$('#BlockType').val("Fo-Block");}
					// $('#grcid').val(grcid);
					
			 }
			});
 } 
</script>

