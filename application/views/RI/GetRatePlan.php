<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 $qry=" exec Exe_RatePlan_Det '".$this->Myclass->DateSplit($_REQUEST['FromDate'])."',
		'".$this->Myclass->DateSplit($_REQUEST['ToDate'])."',
		0,
		'".$_REQUEST['RoomType_Id']."',
		'".$_REQUEST['Single']."',
		'".$_REQUEST['Double']."',
		'".$_REQUEST['Triple']."',
		'".$_REQUEST['Quadruple']."',
		'".$_REQUEST['AdultRate']."',
		'".$_REQUEST['ChildRate']."',
		'".$_REQUEST['FoodPlan_Id']."',
		'".$_REQUEST['AdultPlanAmt']."',
		'".$_REQUEST['ChildPlanAmt']."',
		'".$_REQUEST['WeekSingle']."',
		'".$_REQUEST['WeekDoubles']."',
		'".$_REQUEST['WeekTriple']."',
		'".$_REQUEST['WeekQuadruple']."',
		'".$_REQUEST['Keey']."' ";
		
 $res=$this->db->query($qry);
 $res=$res->result();
 

 
?>

 
    <?php
   
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
		// echo '<td align="right" >'.$row->WeekSingle.'</td>';
		// echo '<td align="right" >'.$row->WeekDoubles.'</td>';
		// echo '<td align="right" >'.$row->WeekTriple.'</td>';
		// echo '<td align="right" >'.$row->WeekQuadruple.'</td>';
		 
		 
		 
		 echo '<td><a class="btn btn-danger btn-sm " onclick="Delete_('.$row->RatePlanDet_Id.')" ><i class="fa fa-trash" aria-hidden="true"></i>
 Delete</a></td>';
		 echo '</tr>';
		 
	 }
	  
  ?>
   
  