<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Room');
$this->pfrm->FrmHead1('Master / Room',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>Sno</th>
            <th>Room</th>
			<th>Room Type</th>
			<th>Status</th>
            <th style="width:100px !important" align="center" >Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php 
			$Res=$this->Myclass->Room();
			$count=1;
			 
		 foreach($Res as $row)
			{
				 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['RoomNo'].'</td>';
					   $sql="Select * from Mas_RoomType where RoomType_Id='".$row['RoomType_Id']."'";   		 
					   $res=$this->db->query($sql);
					   foreach($res->result() as $rows)
						{  }
			   echo  '<td>'.$rows->RoomType.'</td>'; ?>
                      <td style="color:<?php if($row['InActive']==0){echo "Green";}else{echo "Red";} ?>"><?php if($row['InActive']==0){echo"Is Active";}else{echo "Is Inactive";} ?></td>
			   <?php			   
               echo  '<td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Room_Id'].'/UPDATE"   >
					  <i class="fa fa-edit"></i> Edit</a> | 
					   <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Room_Id'].'/DELETE"   >
					  <i class="fa fa-trash"></i> Delete</a>
					  
					  </td>
                      
                      </tr>';
                 
                 
                
				 $count++;
              
			}
			 ?>
        </tbody>
      </table>
   
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
