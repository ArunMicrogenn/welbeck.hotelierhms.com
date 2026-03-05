<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','Tariff Posting');
$this->pfrm->FrmHead2('Master / Tariff Posting',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
date_default_timezone_set('Asia/Kolkata');
  $date=date('Y-m-d');
  $time= date("H:i:s");


  $previousdate=date('Y-m-d', strtotime("-1 days"));
 // $bool=true;
  $sql="select DateofAudit,* from night_audit";
  $res=$this->db->query($sql);
  $row=$res->row();
   $auditdate = $row->DateofAudit;
  //  $curr_date = date('Y-m-d');
  
  
  if(strtotime($date) == strtotime($auditdate) )
  {
    if(strtotime($time)<= strtotime("23:30:00"))	 
    {
      $bool=false;	
    }
    else
    {
      $bool=True;
    }
  }
  else if(strtotime($auditdate) >=  strtotime($date))
  {  
	 $bool=false; 		  
  }
  else 
  { 
	 $bool=True;
  }
?>
<div class="col-sm-12">
  <div class="the-box F_ram">
   <fieldset>
        <table class="FrmTable T-4" >
        <tr>
          <td align="right" class="F_val">Tariff Post Date</td>
          <td align="left"><input type="text" readonly placeholder="auditdate" id="auditdate" name="auditdate" value="<?php echo  date('d/m/Y', strtotime($auditdate)); ?>" class="scs-ctrl" />
            <div class="auditdate" ></div></td>
        </tr>
        <tr>
		<?php 
		$qry=" exec  Get_NightAuditrooms";
	  $res=$this->db->query($qry);
		$norow= $res->num_rows();
		?>
          <td align="right" class="F_val">No.of.In.House</td>
          <td align="left"><input type="text" readonly placeholder="noofrooms" id="noofrooms" name="noofrooms" value="<?php echo $norow; ?>" class="scs-ctrl" />
            <div class="noofrooms" ></div></td>
        </tr>
		<tr>
		 <?php
        $sql2= "select * from Trans_credit_entry tcc
        Inner Join Mas_Revenue ror on ror.Revenue_Id=tcc.Creditheadid 
        Inner join Room_Status Rms on Rms.Roomgrcid=tcc.Roomgrcid and Rms.Roomid = tcc.Roomid
        where CreditDate='".$auditdate."' and ror.RevenueHead='ROOM RENT'
        and Rms.Status='Y' and tcc.roomgrcid not in (select Roomgrcid from Trans_checkout_mas where checkoutdate='".$auditdate."' and isnull(cancelflag,0)=0 and isnull(reinstate,0) = 0) ";
	    $res2=$this->db->query($sql2);	

      
			  $norow1= $res2->num_rows();

       
       
        $night = "select * from night_audit where dateofaudit='".$date."'";
       $nightqry=$this->db->query($night);	
			  $ngrow= $nightqry->num_rows();
      
      // if($norow1 !=0)
			// {
			// 	$BUT="Reposting";
      // }		
			
		  ?>

      

		  <td align="right" class="F_val">No.of.Posted Rooms</td>
          <td align="left"><input type="text" readonly placeholder="noofpostedrooms" id="noofpostedrooms" name="noofpostedrooms" value="<?php echo $norow1; ?>" class="scs-ctrl" />
            <div class="noofpostedrooms" ></div></td>
        </tr>
		<tr>
            <td align="right">
    
         <?php if ($ngrow == 0 ){ ?>
			<?php if ($bool == true) { ?>
    <input type="button" class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="<?php echo $BUT; ?>" onclick="disableButton(this)" />
<?php } ?>
<?php } ?>
  
           
		    <td align="left">
               <?php if ($ngrow != 0 ){ ?>
          <!--<php if ($norow1 !=0){ ?>
			<input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC"  value="Delete Posted Rent"   /><php } ?> ---> <?php 
			 echo '<span style="color: red;">*Tariff post option valibale 23:00 after</span>';?> <?php } ?></td>
		</tr>
      </table>
    </fieldset>
   </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicFooter();
?>
<script type="text/javascript">
    function disableButton(button) {
        button.disabled = true;
      
        button.value = "Clicked";
  
        button.classList.remove('btn-success');
        button.classList.add('btn-secondary'); 
    }
</script>

