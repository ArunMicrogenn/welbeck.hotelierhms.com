<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Customer','Customer');
$this->pfrm->FrmHead1('Customer / Customer',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

<div class="table-responsive">
  <table class="table table-bordered table-hover"  id="example1">
    <thead  >
      <tr>
        <th>Sno</th>
        <th>FirstName</th>
		<th>Mobile</th>	
        <th>City</th>
        <th>State</th>
		<th>Email</th>
		<th>Status</th>
        <th style="width:100px !important" align="center" >Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php 
			$Res=$this->Myclass->Customer();
			$count=1;
			 
		 foreach($Res as $row)
			{
				$query1 = $this->db->query("select * from Mas_Title Where Titleid='".$row['Titelid']."'");
				foreach($query1->result() as $row1)
				{	 }
				$query2 = $this->db->query("exec Get_City '".$row['Cityid']."'");
				foreach($query2->result() as $row2)
				{	 }
				$query3 = $this->db->query("exec Get_StateCountry '".$row['Cityid']."'");
				foreach($query3->result() as $row3)
				{	 }
				
	 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>  
		              <td>'.$row1->Title.'.'.$row['Firstname'].'</td>
					  <td>'.$row['Mobile'].'</td> 
					  <td>'.$row2->City.'</td>	
					  <td>'.$row3->State.'</td>
					  <td>'.$row['Email_ID'].'</td>';	?>
					  <td style="color:<?php if($row['Inactive']==0){echo "Green";}else{echo "Red";} ?>"><?php if($row['Inactive']==0){echo "Is Acive";}else{echo "Is Inactive";} ?></td>
          <?php echo  '<td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Customer_Id'].'/UPDATE"   >
					  <i class="fa fa-edit"></i> Edit</a> 					   
					  
					  </td>
                      
                      </tr>';
                 /*<a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Customer_Id'].'/DELETE"   >
					  <i class="fa fa-trash"></i> Delete</a> */
                 
                
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
