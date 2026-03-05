<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reservation Enquiry','Amendment');
$this->pfrm->FrmHead3('Reservation Enquiry / Amendment',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
  

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="todate" name="todate"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	</form>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<div>
		
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php

			if(@$_POST['frmdate']){
            
				$fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
				$todate = date('Y-m-d', strtotime($_POST['todate']));
			
			 $i=1;
		    $qry="select mas.ResEnqNo, mas.Resenqid, mas.Resenqdate, ti.Title, cus.Firstname,mas.yearprefix from Trans_reserveenquiry_mas mas 
             inner join Trans_Reserveenquiry_Det det on mas.resenqid =det.resenqid
            inner join mas_Customer cus on cus.Customer_Id=mas.cusid
            inner join Mas_Title ti on ti.Titleid=cus.Titelid
			inner join mas_roomtype mr on mr.RoomType_Id= det.typeid
            where det.fromdate between '".@$fromdate."' and '".@$todate."'
			and isnull(det.stat, '')<>'Y'
			group by mas.ResEnqNo,mas.Resenqid, mas.Resenqdate, Ti.Title, cus.Firstname,mas.yearprefix 
            order by mas.ResEnqNo";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $resno ='';
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="6" class="text-bold" style="text-align: center;">Amendment List</td>';			
				echo '</tr>';

				echo '<tr>';		
				 
				echo '<td  style="text-align: center;">Reservation No</td>';
				echo '<td  style="text-align: center;">Reserve Date</td>';
				echo '<td style="text-align: center;">Guest Name</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';	 
				echo '<td  style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['ResEnqNo'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Resenqdate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';	
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/ResEnquiry/'.$rows['Resenqid'].'"><i class="fa fa-pencil"></i></a></td>';
				echo '</tr>';	
				$resno= $rows['ResEnqNo'];			
			  }			 
			}?>		   
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
 