<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation Enquiry Cancel');
$this->pfrm->FrmHead3('Transaction/ Reservation  Enquiry Cancel',$F_Class."/".$F_Ctrl."/".$ID,$F_Class."/".$F_Ctrl."_View");


?>
<?php 
$qury = "select * from usertable where User_id='".User_id."' ";
$op = $this->db->query($qury);
foreach($op -> result_array() as $row){
	$percent = $row['disper'];
	$disamount = $row['disAmount'];
}

?>
<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
	
    <fieldset>
    <form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
            <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="todate" name="todate"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
		       <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
           <td align="left">
            <div style="display:flex; justify-content:space-around;">
                <div><label>Booking Date<label></div>
               <div><input type="checkbox" name="bookingdate"  class="btn btn-success btn-block" value="1"></div>
               
            </div>
            </td>
        </tr>
      	</table>
	</form>
    <?php
      if(@$_POST['frmdate']){
            
            $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
            $todate = date('Y-m-d', strtotime($_POST['todate']));
        }else{
            $fromdate = date('Y-m-d');
            $todate =   date('Y-m-d');
        }
        if(@$_POST['bookingdate'] !=0){
            $sql="select mr.RoomType,mt.title+'.'+mc.Firstname+' '+isnull(mc.Lastname,'') as Guestname, mr.Roomtype,rm.ResEnqNo, rm.Resenqdate,
            rm.totrooms,rd.noofpax,* from Trans_Reserveenquiry_Mas rm
           inner join Trans_Reserveenquiry_Det rd on rm.Resenqid=rd.resenqid 
           inner join Mas_Customer mc on mc.Customer_Id= rm.cusid 
           inner join Mas_RoomType mr on mr.RoomType_Id=rd.typeid 
           inner join mas_title mt on mt.Titleid =mc.Titelid where isnull(rd.stat, '')<> 'Y' and 
           isnull(rm.stat,'')<>'Y' and
           rm.Resenqdate between '".$fromdate."' and '".$todate."' order by rm.ResenqNo";
        }else{
            $sql="select mr.RoomType,mt.title+'.'+mc.Firstname+' '+isnull(mc.Lastname,'') as Guestname, mr.Roomtype,rm.ResEnqNo, rm.Resenqdate,
            rm.totrooms,rd.noofpax,* from Trans_Reserveenquiry_Mas rm
           inner join Trans_Reserveenquiry_Det rd on rm.Resenqid=rd.resenqid 
           inner join Mas_Customer mc on mc.Customer_Id= rm.cusid 
           inner join Mas_RoomType mr on mr.RoomType_Id=rd.typeid 
           inner join mas_title mt on mt.Titleid =mc.Titelid where isnull(rd.stat, '')<> 'Y' and isnull(rm.stat,'')<>'Y' and
           rd.fromdate between '".$fromdate."' and '".$todate."' order by rm.ResenqNo";
        }	
			$exe = $this->db->query($sql);
			$count = 1;
			$no = $exe->num_rows(); 
        if($no !=0){
            ?>
		<table id="mytable" width="100%" class="mytable" style="margin-top:20px">
			<thead>
			<tr>
			<th>S.No</th>
            <th>Res.Date</th>
            <th>Res.No</th>
            <th>Guest Name</th>
			<th>Room Type</th>
			<th>No Of Rooms</th>
            <th>Reason</th>
            <th>Action</th>
			</tr>
			</thead>
			<?php 
			foreach($exe->result_array() as $row1){
			?>
			<tbody  class="input_fields_wrap">
            <form id="reserveform<?php echo $count;?>" method="POST">
			  <tr  class="tb">
              <input type="hidden"  num=1 name="resid" id="resid<?php echo $count;?>"  value="<?php echo $row1['resenqid']; ?>" class="f-ctrl rmm" >
                <input type="hidden"  num=1 name="resenqdetid" id="resenqdetid<?php echo $count;?>"  value="<?php echo $row1['resenqdetid']; ?>" class="f-ctrl rmm" >
                <td style="text-align:center"><input type="text"  readonly value="<?php echo $count;?>" class="f-ctrl rmm"  /></td>                                      
                <td><input type="text"  readonly value="<?php echo date('d-m-Y', strtotime($row1['Resenqdate']));?>" class="f-ctrl rmm"  /></td> 
                <td>
                <input type="text"  readonly value="<?php echo $row1['yearprefix'].'/'.$row1['ResEnqNo']?>" class="f-ctrl rmm"  />
                </td>
                <td>
                <input type="text"  readonly value="<?php echo $row1['Guestname']?>" class="f-ctrl rmm"  />
                </td>
                <td>
                <input type="text"  readonly value="<?php echo $row1['Roomtype']?>" class="f-ctrl rmm"  />
                </td>	
                <td>
                <input type="text" name="total" readonly value="<?php echo $row1['noofrooms']?>" class="f-ctrl rmm"  />
                </td> 
                <td>
                <input type="text" name="Reason" id="reason<?php echo $count; ?>"  value="" class="f-ctrl rmm" />
                </td>
                <td >
				<input type="button"   class="btn btn-success btn-sm" id="savebtn<?php echo $count;?>" onclick="Reserve('<?php echo $count;?>')" value="save"  />
				</td>
		    </tr>
            <!-- <input type="hidden"  num=1 name="count" id="count"  value="<?php echo $count?>" class="f-ctrl rmm" > -->
            </form>
		    </tbody>
			<?php  $count++ ;} ?>
          
			</table>  
            <?php }?>
			<br>
			
		<div id="edit"></div>
    </fieldset>
	
  </div>
  <div class="the-box D_ISS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<SCRIPT language="javascript">



	 function Reserve(a)
	{

        var reason=document.getElementById("reason"+a).value;
        
            if(reason=='')
             { swal("Unable to process", "Reason is Empty", "error"); 
               return; }

    $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Transaction/EnquiryCancelSave',
      data: $('#reserveform'+a).serialize(),
      success: function (result) {
        if(result =='Success')		
      {
        swal("Success...!", "Cancel Save SuccessFull", "success")
        .then(function() {
          window.location.href='<?php echo scs_index?>Transaction/EnquiryCancel';	
          });
      }
      else
      {
        swal("Faild...!", "Unable to process", "error")
        .then(function() {
            window.location.href='<?php echo scs_index?>Transaction/EnquiryCancel';		

          });
      }
    
    }
  });
}
	

</script>


	
	


	
	