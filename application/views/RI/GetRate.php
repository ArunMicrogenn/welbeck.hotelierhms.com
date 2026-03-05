<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 $qry=" exec Set_RatePlan ".$ID;
 $res=$this->db->query($qry);
 $res=$res->result();
 

 
?>
<br><br>
<table width="100%" class="mytable">
  <thead>
    <tr>
      <th width="40" >SNO</th>
      <th>PlanType</th>
      <th width="100">Single</th>
      <th width="100">Double</th>
      <th width="100">Triple</th>
      <th width="100">Quadruple</th>
      <th width="100">AdultRate</th>
      <th width="100">ChildRate</th>
    </tr>
  </thead>
  <tbody>
    <?php
  $cou=1;
   foreach($res as $row)
	 {
		 echo '<tr>';
		 echo '<td>'.$cou.'</td>';
		 echo '<td>'.$row->PlanType.'</td>';
		 echo '<td><input type="text" num=1 name="Single[]" value="'.$row->Single.'" class="f-ctrl" /></td>';
		 echo '<td><input type="text" num=1 name="Doubles[]" value="'.$row->Doubles.'" class="f-ctrl" /></td>';
		 echo '<td><input type="text" num=1 name="Triple[]" value="'.$row->Triple.'" class="f-ctrl" /></td>';
		 echo '<td><input type="text" num=1 name="Quadruple[]" value="'.$row->Quadruple.'" class="f-ctrl" /></td>';
		 echo '<td><input type="text" num=1 name="AdultRate[]"  value="'.$row->AdultRate.'" class="f-ctrl" /> </td>';
		 echo '<td><input type="text" num=1 name="ChildRate[]"  value="'.$row->ChildRate.'" class="f-ctrl" />  </td>';
		 echo '</tr>';
		 echo '<input type="hidden" name="RatePlan_Id[]" value="'.$row->RatePlan_Id.'"  >';
		 $cou++;
	 }
	  
  ?>
  </tbody>
  <tfoot>
  <tr>
  <td  colspan="4" align="center"  ><samp class="succ"></samp> </td>
  <td>
  <a class="btn btn-success btn-sm pull-right" onClick="RateUpdate()" >Update</a>
  
  </td>
  </tr>
  </tfoot>
</table>

<script>
function RateUpdate()
{
	$('.succ').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>').show();
	$.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>RI/RateUpdate",
		data:$('#scsfrm').serialize(),
		success: function(html)
		{
			$('.succ').html(html).hide(3000);
		}
		
	})
}

</script>