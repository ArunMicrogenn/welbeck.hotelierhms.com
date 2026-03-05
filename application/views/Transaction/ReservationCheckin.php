<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
 $this->pweb->timezone(); 
$this->pweb->nightaudit();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Transaction','Reservation');
$this->pfrm->FrmHead2('Transaction/ Reservation',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

 
?>



    
<div class="col-sm-12">
  <div class="the-box F_ram">
	<form id="resform" method="POST">
    <fieldset>
        <table class="FrmTable T-3">
			<tr>
			<td style="text-align: right;" class="F_val">Reservation No</td>
			<td align="left">
			<select  name="resno" id="resno" class="f-ctrl rmm" required>
				<option value="0">Select ResNo</option>
				<?php  
				   $Res="SELECT ResNo,mas.Resid 
				 FROM Trans_Reserve_Mas mas 
				 INNER JOIN Trans_Reserve_det det ON mas.Resid = det.resid
				 WHERE ISNULL(det.stat, '') not in ('C','Y')
				   AND ((ISNULL(det.noofrooms, 0) - ISNULL(det.checkinrooms, 0)) + ISNULL(det.cancelrooms, 0)) > 0
				   AND det.fromdate = '".date('Y-m-d')."'
				 GROUP BY ResNo,mas.Resid";
				$xe = $this->db->query($Res); ?>
				<?php foreach($xe-> result_array() as $row)
				{
				echo "<option value=".$row['Resid'].">".$row['ResNo']."</option>";
				}	?>
			</select>   
			<td align="right"><input type="button" name="submit" id="btn" value="Submit" class="btn btn-success btn-sm"    /></td>
			<div class="ResNo" ></div></td>
			</tr>
	    </table>
		<div id="edit"></div>

    </fieldset>

	</form>
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
<script>
	var btn = document.getElementById("btn")
	btn.addEventListener("click", () => {
		var resno = document.getElementById("resno").value
		if(resno !='0'){
		$.ajax({
			type:"POST",
			url:"<?php echo scs_index ?>Transaction/ReserveCheckin",
			data:"resno="+resno,
			success:function(html){
				$("#edit").html(html)

				// 				$("#btn").click();
// 				var d = new Date(); // for now
// var h =d.getHours(); // => 9
// var s =d.getMinutes(); // =>  30
// const RowCount= $('#mytable .tb').length
// for(let i=1; i<=RowCount; i++){
// 	$('#FHr'+i).val(h);
// 	$('#FMi'+i).val(s);
// 	$('#THr'+i).val(h);
// 	$('#TMi'+i).val(s);
// }
// // document.getElementById("FHr1").disabled = true;
// // document.getElementById("FMi1").disabled = true;
// $('#FHr1').val(h);
// $('#FMi1').val(s);
// $('#THr1').val(h);
// $('#TMi1').val(s);
			}
		})
		}
	});
</script>
<SCRIPT language="javascript">

 function Roomvalidate(a)
 {
	    $.ajax({
            url: "<?php echo scs_index ?>Transaction/roomtypegetroomnumber?type="+a,
            type: 'POST',
            success: function (data) {
                $('#RoomNo'+x).empty();
                $('#RoomNo'+x).append(data);
		    }
			
        });   
 }
	</SCRIPT>

<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>
	
	