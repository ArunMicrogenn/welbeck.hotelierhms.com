<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 $qry=" exec Delete_RatePlan_Det '".$IDD."','".$_REQUEST['Keey']."' ";
		
 $res=$this->db->query($qry);
 $res=$res->result();
 

 
?>

 
    <?php
  $cou=1;
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
		 echo '<td   >'.$row->FoodPlan.'</td>';
		 echo '<td><a class="btn btn-danger btn-sm " onclick="Delete_('.$row->RatePlanDet_Id.')" ><i class="fa fa-trash" aria-hidden="true"></i>
 Delete</a></td>';
		 echo '</tr>';
		 $cou++;
	 }
	  
  ?>
   
  