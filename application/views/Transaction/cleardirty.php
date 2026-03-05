<style>
</style>
<?php
  $sql=" select * from room_status rs
 Inner join Mas_Room mr on mr.Room_Id=rs.Roomid  
 where Status='N' and notready=1 and rs.Roomid='".$_REQUEST['Room_id']."'";
 $res=$this->db->query($sql);
 $Roomid=$_REQUEST['Room_id'];
 foreach ($res->result_array() as $row)
 {
	 $Roomno=$row['RoomNo']; 
	 
 }

  ?>
	<legend style="font-size:13px" ><strong></strong></legend>	
  <form id="Postbillsave">
  <table class="FrmTable" style="width:100%"> 	
   <tr>
	<td>Remark:</td>
	<td><textarea id="remark" required name="remark"></textarea></td>
	<td></td>
	<td></td>
   </tr>
   <tr>
   	<td></td>
	<td><input type="submit" id="chkbtn" value="Save" class="btn btn-warning btn-sm">
	<img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/></td>
    <td></td><td></td>
   </tr>
  </table>
 </form> 
 <script>
	$("#Postbillsave").on('submit', function (e) {
       e.preventDefault();
 document.getElementById("chkbtn").disabled=true;
        document.getElementById("loaderimg").style.display="inline";
          $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/cleardirtysave?Roomid=<?php echo $Roomid; ?>",
            data: $('#Postbillsave').serialize(),
            success: function (result) {
             swal("Success...!", "Cleared Successfully...!", "success");
			       location.reload();
			   }			
          });
          		   
        });
 </script>