<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reprint','Complementary Checkout Bill');
$this->pfrm->FrmHead4('Reprint / Complementary Checkout Bill',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 <?php
 $sql = "select isnull(comreprintbill,0) as comreprintbill from extraOption";
 $exx = $this->db->query($sql);
 foreach($exx -> result_array() as $row){
    
	 $walkoutReprint = $row['comreprintbill'];
 }
  ?>
   <?php 	date_default_timezone_set('Asia/Kolkata');  ?>
<div class="col-sm-12">
  <div class="the-box F_ram">
   <fieldset>
		<form action="" method="POST">
			<table class="FrmTable T-6" >
			<tr>
			<td align="right" class="F_val">From Date</td>
			<td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl Dat2" />
				<div class="Type" ></div></td>
				<td align="right" class="F_val">To Date</td>
			<td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="todate" name="todate"   class="scs-ctrl Dat2" />
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
		<?php
        if($walkoutReprint != 0){
		if(@$_POST['submit'])
		{
		?>	
        <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 
			 $i=1;
			 $qry="SELECT mt.Title+'.'+m.Firstname as Name,* FROM Trans_Checkout_mas re
			 inner join Mas_Customer m on m.Customer_Id=re.customerid
			 inner join Mas_Room rm on rm.Room_Id=re.Roomid 
			 Inner join Mas_Title mt on mt.Titleid=m.Titelid 
             inner join usertable ut on ut.User_id = '".User_id."'
			 where re.Checkoutdate between '".date('Y-m-d',strtotime($_POST['frmdate']))."' 
             and '".date('Y-m-d',strtotime($_POST['todate']))."'
			 and re.Checkoutno like 'WHK%'
            /* and isnull(comreprintbill,0)<>0*/
			  Order by Checkoutid desc";
			 $exec=$this->db->query($qry); $totalAdvance=0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="6" class="text-bold" style="text-align: center;">Checkout Bill Reprint</td>';			
				echo '</tr>';

				echo '<tr>';		 
				echo '<td  style="text-align: center;">Bill No</td>';
				echo '<td  style="text-align: center;">Receipt Date</td>';
				echo '<td style="text-align: center;">Customer</td>';
				echo '<td style="text-align: center;">Room No</td>';
				echo '<td style="text-align: center;">Amount</td>';
				echo '<td style="text-align: center;">Action</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {				
				echo '<tr>';		 
				echo '<td  style="text-align: center;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';
				echo '<td style="text-align: center;">'.date('d-m-Y',strtotime($rows['Checkoutdate'])).'</td>';
				echo '<td style="text-align: left;">'.$rows['Name'].'</td>';
				echo '<td style="text-align: center;">'.$rows['RoomNo'].'</td>';		
				echo '<td style="text-align: right;">'.$rows['totalamount'].'</td>';
				echo '<td style="text-align: center;"><a href="'.scs_index.'Reprint/CheckoutReprint?Checkoutid='.$rows['Checkoutid'].'"><i class="fa fa-eye"></i></a></td>';
				echo '</tr>';				
			  }			 
		   ?>		   
		   </tbody>
		</table>
		 <?php
		} 
    }?>	
	</div>
	<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
 