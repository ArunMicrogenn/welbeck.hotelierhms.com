<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->nightaudit();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Reservation','Reservation Cancel');
$this->pfrm->FrmHead3('Reservation / Reservation Cancel',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

  <div class="col-sm-12">
    <div class="the-box F_ram">
      <fieldset>
    <form action="" method="POST">
          <table class="FrmTable T-6" >
          <tr>
            <td align="right" class="F_val">Arrival Date From </td>
            <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="frmdate" name="frmdate"   class="scs-ctrl Dat" />
              <div class="Type" ></div></td>
              <td align="right" class="F_val">To Date</td>
            <td align="left"><input type="text" value="<?php echo date('d-m-Y'); ?>" id="todate" name="todate"   class="scs-ctrl Dat" />
              <div class="Type" ></div></td> 
              <!-- <input type="text" value="" name="reason" id="reason">        -->
            <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
          </tr>
          </table>
      </form>
      </fieldset>
    </div>
    <div class="the-box D_IS" ></div>
  </div>
  <?php

  if(@$_POST['submit'])
  {
    ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="example1">
          <thead  >
            <tr>
              <th>Sno</th>
              <th>Res.Date</th>
              <th>Arr.Date</th>
              <th>Res.No</th>            
              <th>Guest Name</th>            
              <th>Room Type</th>            
              <th style="width:100px !important" align="center" >Action</th>
            </tr>
          </thead>
        <tbody>
      <?php 
      $Res=$this->Myclass->Get_Reservations(date('Y-m-d',strtotime($_POST['frmdate'])),date('Y-m-d',strtotime($_POST['todate'])),0);
      $count=1;			 
      foreach($Res as $row)
        {
          
          echo '<tr class="odd gradeX">
                    <td>'.$count.'</td>
                    <td>'.date('d-m-Y',strtotime($row['Resdate'])).'</td>
                    <td>'.date('d-m-Y',strtotime($row['fromdate'])).'</td>
                     <td>'.$row['yearprefix'].'/'.$row['ResNo'].'</td>
                    <td>'.$row['Name'].'</td>
                    <td>'.$row['RoomType'].'</td>';  	   		 
            echo '<td>
              <a class="btn btn-warning btn-xs" Onclick="CancelSave('.$row['Resid'].')"    >
              <i class="fa fa-trash"></i> Cancel</a>  					   					  
              </td>                     
                  </tr>';                 
                  /*<a class="btn btn-danger btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."/".$row['Floor_Id'].'/DELETE"   >
              <i class="fa fa-trash"></i> Delete</a>*/              
          $count++;              
        } 
        ?>
          </tbody>
        </table>
    
  </div>
  <?php
  }
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script>
  	function CancelSave (a) {
      swal({
			text: 'Reason for Reservation Cancel',    
			content: "input",
			button: {
				text: "Save",
				closeModal: false,
			},
		})
			.then(name => {
				if (!name) throw null;       
          $.ajax({
            type: 'post',
            url: "<?php echo scs_index ?>Transaction/reservecancelsave?Roomid="+a,
            data: $('#reservecancelsave').serialize() + "&Reason="+name,
            success: function (result) {			
              // console.log(result);	 
				swal("Success...!", "Reservation cancel is successfully...!", "success")
					.then(function() {
    					window.location.href ="<?php echo scs_index ?>Transaction/ReservationCancels";
					});
			    }			
          });
          		  
      });
    }
  </script>

<script>
window.onload = function() {
    
  <?php $this->pweb->nightaudit(); ?>

    
};
</script>