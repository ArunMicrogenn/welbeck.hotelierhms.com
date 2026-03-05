<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$count=count($_POST['RoomType_Id']);

for($i=0;$i<$count;$i++)
{
    $qry=" Update_RecTable ".HotelId.",".$_POST['RoomType_Id'][$i].",".$_POST['PlanType_Id'][$i].",".$_POST['IAMT'][$i].",'".$_POST['IDATE'][$i]."'";
	$this->db->query($qry);
    $this->db->close();
	$this->db->reconnect();	
	
}

$count=count($_POST['Inv_Id']);

for($i=0;$i<$count;$i++)
{
    $qry=" Update_RecTable_Inv  ".$_POST['Inv_Id'][$i].",".$_POST['RINV'][$i]."";
	$this->db->query($qry);
    $this->db->close();
	$this->db->reconnect();	
	
}

?>
 