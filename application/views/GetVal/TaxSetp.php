<?php
  $qry=" exec Inv_TaxSetup '".$_REQUEST['Revenue']."','".Hotel_Id."','".User_id."' ";
$res=$this->db->query($qry);

?>

<table class="mytable" style="margin-top:20px">
  <thead>
    <tr>
      <th >#</th>
      <th>Frome Amount</th>
      <th>To Amount</th>
      <th>Per %</th>
    </tr>
  </thead>
  <tbody>
    <?php 
		$cout=1;
		foreach($res->result() as $row)
		{
		
			 echo ' <tr><td align="right" ><strong>'.$cout.'</strong></td>
				<td><input name="FAMT[]"  value="'.$row->FromAmt.'"  num=1 class="f-ctrl rmm"  /> </td>
				<td><input name="To[]"  value="'.$row->ToAmt.'"  num=1 class="f-ctrl rmm"  /> </td>
				<td><input name="Per[]"  value="'.$row->Per.'"  num=1 class="f-ctrl rmm"  /> </td>
				<input type="hidden" name="IDD[]" value="'.$row->TaxSetup_Det_Id.'" >
			  </tr>';
			  
          $cout++;
		  
		}
		  ?>
  </tbody>
    </tbody>
  

</table>
