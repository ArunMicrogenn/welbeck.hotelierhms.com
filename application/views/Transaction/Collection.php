<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->nightaudit();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Settlement','Collection');
$this->pfrm->FrmHead3('Settlement / Collection',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
   <fieldset>
		
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div>
		
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 
			 $i=1;
			 $qry="SELECT mc.Company_id, mc.Company,SUM(ISNULL(pd.Amount, 0)) - SUM(ISNULL(pd.Paidamount, 0)) AS totalamount
FROM 
    mas_company mc
    INNER JOIN Mas_CompanyType mct ON mct.CompanyType_Id = mc.CompanyType_Id
    INNER JOIN trans_pay_det pd ON pd.Bankid = mc.Company_Id
    INNER JOIN Trans_checkout_mas cmas ON cmas.Checkoutid = pd.Checkoutid
    INNER JOIN (
        SELECT paymode_id 
        FROM mas_paymode 
        WHERE paymode = 'COMPANY' 
    ) AS pm ON pd.paymodeid = pm.paymode_id
WHERE 
    mct.CompanyType <> 'travelagent'
GROUP BY 
    mc.Company, mc.Company_Id
HAVING 
    SUM(ISNULL(pd.Amount, 0)) - SUM(ISNULL(pd.Paidamount, 0)) > 0
ORDER BY 
    mc.Company; ";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="6" class="text-bold" style="text-align: center;">Collection</td>';			
				echo '</tr>';

				echo '<tr>';		 
				echo '<td  style="text-align: center;">S.no</td>';
				echo '<td  style="text-align: center;">Company</td>';
				echo '<td style="text-align: center;">Amount</td>';
                echo '<td style="text-align: center;">Edit</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$i.'</td>';
				echo '<td style="text-align: left;">'.$rows['Company'].'</td>';
				echo '<td style="text-align: left;">'.$rows['totalamount'].'</td>';
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/Collection_Edit/'.$rows['Company_id'].'"><i class="fa fa-pencil"></i></a></td>';
				echo '</tr>';	
                $i++;				
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

<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>
 