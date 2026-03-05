<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reservation ','Room Cancel');
$this->pfrm->FrmHead3('Reservation / ResRoomCancel',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
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
		    $qry="select mas.ResNo, mas.Resdate, ti.Title, cus.Firstname from Trans_reserve_mas mas 
            inner join Trans_Reserve_Det det on mas.resid =det.resid
            inner join mas_Customer cus on cus.Customer_Id=mas.cusid
            inner join Mas_Title ti on ti.Titleid=cus.Titelid
			inner join mas_roomtype mr on mr.RoomType_Id= det.typeid
            where det.fromdate between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime('+10 Day'))."'
			and isnull(det.stat, '')<>'Y'
			group by mas.ResNo, mas.Resdate, Ti.Title, cus.Firstname
            order by mas.ResNo";
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
				
				// echo '<td style="text-align: center;">Room Type</td>';

				
				// echo '<td style="text-align: center;">Room No</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';	 
				echo '<td  style="text-align: center;">'.$rows['ResNo'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Resdate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';		
				echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/ResRoomCancelList/'.$rows['ResNo'].'"><i class="fa fa-pencil"></i></a></td>';
				echo '</tr>';	
				$resno= $rows['ResNo'];			
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
 