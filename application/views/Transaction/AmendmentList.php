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
$this->pweb->Cheader('Reservation','Amendment');
$this->pfrm->FrmHead3('Reservation / Amendment',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 


<style>
/* Toggle Switch Styles - Small Version */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 30px;
  margin: 0;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #2196F3;
  transition: .4s;
  border-radius: 30px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.slider:before {
  position: absolute;
  content: "";
  height: 24px;
  width: 24px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
  box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:checked + .slider:before {
  transform: translateX(30px);
}

/* Label styles */
.toggle-container {
  display: flex;
  align-items: center;
  gap: 10px;
}

.toggle-label {
  font-weight: bold;
  color: #333;
  margin-right: 5px;
  font-size: 14px;
}
</style>


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <form action="" method="POST">
        <table class="FrmTable T-6 ">
          <tr>
            <td align="right" class="F_val">Search Type : </td>
            <td align="left">
              <div class="toggle-container" style="display: flex; align-items: center; white-space: nowrap;">
                <span class="toggle-label">Reservation</span>
                <label class="switch" style="margin: 0 10px;">
                  <input type="checkbox" name="search_type_toggle" id="search_type_toggle" 
                         onchange="toggleDateFields()" 
                         <?php if(isset($_POST['search_type']) && $_POST['search_type'] == '2') echo 'checked'; ?>>
                  <span class="slider"></span>
                </label>
                <span class="toggle-label">Arrival</span>
              </div>
              <input type="hidden" name="search_type" id="search_type" value="<?php echo (isset($_POST['search_type']) && $_POST['search_type'] == '2') ? '2' : '1'; ?>">
            </td>
            
            <td align="right" class="F_val" id="from_label_single" <?php if(isset($_POST['search_type']) && $_POST['search_type'] == '2') echo 'style="display:none;"'; ?>>From Date</td>
            <td align="left" id="from_field_single" <?php if(isset($_POST['search_type']) && $_POST['search_type'] == '2') echo 'style="display:none;"'; ?>>
              <input type="date" value="<?php echo isset($_POST['resdate_from']) ? $_POST['resdate_from'] : date('Y-m-d'); ?>" id="resdate_from" name="resdate_from" class="scs-ctrl" />
            </td>
            
            <td align="right" class="F_val" id="from_label_range" <?php if(!isset($_POST['search_type']) || $_POST['search_type'] != '2') echo 'style="display:none;"'; ?>>From Date</td>
            <td align="left" id="from_field_range" <?php if(!isset($_POST['search_type']) || $_POST['search_type'] != '2') echo 'style="display:none;"'; ?>>
              <input type="date" value="<?php echo isset($_POST['from_arrival']) ? $_POST['from_arrival'] : date('Y-m-d'); ?>" id="from_arrival" name="from_arrival" class="scs-ctrl" />
            </td>
            
            <td align="right" class="F_val" id="to_label_single" <?php if(isset($_POST['search_type']) && $_POST['search_type'] == '2') echo 'style="display:none;"'; ?>>To Date</td>
            <td align="left" id="to_field_single" <?php if(isset($_POST['search_type']) && $_POST['search_type'] == '2') echo 'style="display:none;"'; ?>>
              <input type="date" value="<?php echo isset($_POST['resdate_to']) ? $_POST['resdate_to'] : date('Y-m-d'); ?>" id="resdate_to" name="resdate_to" class="scs-ctrl" />
            </td>
            
            <td align="right" class="F_val" id="to_label_range" <?php if(!isset($_POST['search_type']) || $_POST['search_type'] != '2') echo 'style="display:none;"'; ?>>To Date</td>
            <td align="left" id="to_field_range" <?php if(!isset($_POST['search_type']) || $_POST['search_type'] != '2') echo 'style="display:none;"'; ?>>
              <input type="date" value="<?php echo isset($_POST['to_arrival']) ? $_POST['to_arrival'] : date('Y-m-d'); ?>" id="to_arrival" name="to_arrival" class="scs-ctrl" />
            </td>
            
            <td align="right">
              <input type="submit" name="submit" class="btn btn-success" value="Get">
            </td>
          </tr>
        </table>
      </form>
    </fieldset>
  </div>
  <div class="the-box D_IS"></div>
</div>

<script>
function toggleDateFields() {
    var toggleCheckbox = document.getElementById('search_type_toggle');
    var hiddenInput = document.getElementById('search_type');
    var singleDateRow = document.getElementById('single_date_row');
    var dateRangeRow = document.getElementById('date_range_row');
    
    if (toggleCheckbox.checked) {
        // Arrival Date selected
        hiddenInput.value = '2';
        singleDateRow.style.display = 'none';
        dateRangeRow.style.display = '';
    } else {
        // Reservation Date selected
        hiddenInput.value = '1';
        singleDateRow.style.display = '';
        dateRangeRow.style.display = 'none';
    }
}

// Initialize on page load
window.onload = function() {
    <?php $this->pweb->nightaudit(); ?>
    toggleDateFields();
};
</script>

        <table class="table table-bordered table-hover">         
           <tbody>
            <?php 
             $i=1;
            
             if(isset($_POST['search_type']) && $_POST['search_type'] == '2' && isset($_POST['from_arrival']) && isset($_POST['to_arrival'])) {
             
                 $from_date = $_POST['from_arrival'];
                 $to_date = $_POST['to_arrival'];
                 
                   $qry = "select mas.ResNo, mas.Resdate, ti.Title, cus.Firstname, mas.yearprefix 
                     from Trans_reserve_mas mas 
                     inner join Trans_Reserve_Det det on mas.resid = det.resid
                     inner join mas_Customer cus on cus.Customer_Id = mas.cusid
                     inner join Mas_Title ti on ti.Titleid = cus.Titelid
                     inner join mas_roomtype mr on mr.RoomType_Id = det.typeid
                     where det.fromdate between '".$from_date."' and '".$to_date."'
                     and isnull(det.stat, '') not in ('Y','C')  
                     group by mas.ResNo, mas.Resdate, Ti.Title, cus.Firstname, mas.yearprefix
                     order by mas.ResNo";
             } else {
                 
                 if(isset($_POST['search_type']) && $_POST['search_type'] == '2') {
                   
                     $from_date = date('Y-m-d');
                     $to_date = date('Y-m-d', strtotime('+10 days'));
                    
                       $qry = "select mas.ResNo, mas.Resdate, ti.Title, cus.Firstname, mas.yearprefix 
                         from Trans_reserve_mas mas 
                         inner join Trans_Reserve_Det det on mas.resid = det.resid
                         inner join mas_Customer cus on cus.Customer_Id = mas.cusid
                         inner join Mas_Title ti on ti.Titleid = cus.Titelid
                         inner join mas_roomtype mr on mr.RoomType_Id = det.typeid
                         where det.fromdate between '".$from_date."' and '".$to_date."'
                         and isnull(det.stat, '') not in ('Y','C')  
                         group by mas.ResNo, mas.Resdate, Ti.Title, cus.Firstname, mas.yearprefix
                         order by mas.ResNo";
                 } else {
                    // Check if form is submitted
                    if(isset($_POST['resdate_from']) && isset($_POST['resdate_to'])) {
                        $resdate_from = $_POST['resdate_from'];
                        $resdate_to = $_POST['resdate_to'];
                    } else {
                        // Default values when form not submitted
                        $resdate_from = date('Y-m-d');
                        $resdate_to = date('Y-m-d', strtotime('+10 days'));
                    }

                    $qry = "select mas.ResNo, mas.Resdate, ti.Title, cus.Firstname, mas.yearprefix 
                        from Trans_reserve_mas mas 
                        inner join Trans_Reserve_Det det on mas.resid = det.resid
                        inner join mas_Customer cus on cus.Customer_Id = mas.cusid
                        inner join Mas_Title ti on ti.Titleid = cus.Titelid
                        inner join mas_roomtype mr on mr.RoomType_Id = det.typeid
                        where mas.Resdate between '".$resdate_from."' and '".$resdate_to."'
                        and isnull(det.stat, '') not in ('Y','C')  
                        group by mas.ResNo, mas.Resdate, Ti.Title, cus.Firstname, mas.yearprefix
                        order by mas.ResNo";
                 }
             }
             
             $exec=$this->db->query($qry); 
             $totalAdvance=0;
             $resno ='';
             $advance= $exec->num_rows();
             
             if($advance !=0)
             {
                echo '<tr>';
                echo '<td colspan="6" class="text-bold" style="text-align: center;">Amendment List</td>';            
                echo '</tr>';

                echo '<tr>';        
                echo '<td style="text-align: center;">Reservation No</td>';
                echo '<td style="text-align: center;">Reserve Date</td>';
                echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Action</td>';
                echo '</tr>';            
             }             
             
             foreach ($exec->result_array() as $rows)
             {                
                echo '<tr>';     
                echo '<td style="text-align: center;">'.$rows['yearprefix'].'/'.$rows['ResNo'].'</td>';
                echo '<td style="text-align: center;">'.date('m-d-Y',strtotime($rows['Resdate'])).'</td>';
                echo '<td style="text-align: center;">'.$rows['Title'].'.'.$rows['Firstname'].'</td>';
                echo '<td style="text-align: center;"><a href="'.scs_index.'Transaction/RessAmendment/'.$rows['ResNo'].'"><i class="fa fa-pencil"></i></a></td>';
                echo '</tr>';    
                $resno= $rows['ResNo'];            
             }             
           ?>           
           </tbody>
        </table>    
    </div>

	<script>

    document.getElementById('resdate_from').addEventListener('change', function() {

          document.getElementById('resdate_to').value = this.value;
		 document.getElementById('resdate_to').setAttribute('min',this.value);
		 
    });


	document.getElementById('from_arrival').addEventListener('change',function(){ 
       document.getElementById('to_arrival').value = this.value;
	   document.getElementById('to_arrival').setAttribute('min',this.value);
	});
	
  
</script>

    <?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>