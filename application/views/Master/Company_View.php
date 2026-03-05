<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Company');
$this->pfrm->FrmHead1('Master / Company',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>Sno</th>
            <th>Company</th>
			<th>Company Type</th>
			<th>City</th>
			<th>Status</th>            
            <th style="width:100px !important" align="center" >Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php 
			$Res=$this->Myclass->Company();
			$count=1;			 
		 	foreach($Res as $row)
			{
			    $query1 = $this->db->query("exec Get_CompanyType 1,'".$row['CompanyType_Id']."'");
				foreach($query1->result() as $row1)
				{	 }
				$query2 = $this->db->query("exec Get_City '".$row['Cityid']."'");
				foreach($query2->result() as $row2)
				{	 }
				 
               echo  '<tr class="odd gradeX">
                      <td>'.$count.' </td>
                      <td>'.$row['Company'].'</td>
					  <td>'.$row1->CompanyType.'</td>
					  <td>'.$row2->City.'</td>'; ?>
					  <td style="Color:<?php if($row['Inactive']==0){echo "Green";}else{echo "Red";} ?>"><?php if($row['Inactive']==0){echo "Is Active";}else{echo "Is Inactive";} ?></td>
			  <?php					   		 
               echo  '<td>
					  <a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Company_Id'].'/UPDATE"   >
					  <i class="fa fa-edit"></i> Edit</a> 
					
					  
					  </td>
                      
                      </tr>';
                 
                    // <a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Company_Id'].'/DELETE"   >
					//   <i class="fa fa-trash"></i> Delete</a>
                
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
