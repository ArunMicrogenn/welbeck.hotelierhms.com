<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Master','DayBook');
$this->pfrm->FrmHead1('Master / DayBook',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");

?>

 
    <div class="table-responsive">
      <table class="table table-bordered table-hover"  id="example1">
        <thead  >
          <tr>
            <th>Sno</th>
            <th>Daily No</th>
            <th>Date</th>
			      <th>Amount</th>
            
            <th style="width:100px !important" align="center" >Edit</th>
          </tr>
        </thead>
        <tbody>
          <?php 
			$Res=$this->Myclass->CashBook();
			$count=1;
			 
		 foreach($Res as $row)
			{
				 
              echo  '<tr class="odd gradeX">
                    <td>'.$count.' </td>
                    <td>'.$row['yearprefix'].'/'.$row['DailyNo'].'</td>
                    <td>'.date('d-m-y', strtotime($row['Cashdate'])).'</td>
                    <td>'.$row['TotalAmount'].'</td>'; ?>           
			   <?php		   		 
               echo '<td>
					  <button type="button" class="btn btn-warning btn-xs" onClick="deleteCashBook('.$row['Dailyid'].')" >
					  <i class="fa fa-edit"></i> Cancel</button>  
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

<script>
  const deleteCashBook = (id)=>{
    swal({
      title:"Are You Sure?",
      text:"You won't be able to retrive this",
      buttons:true,
      dangerMode:true,
      icon:'Warning',
    }).then((willDelete) =>{
      if(willDelete){
        $.ajax({
        type: 'post',
        url: '<?php echo scs_index ?>Master/CashBook_EntryDelete',
        data: 'id='+id+'&savebtn=DELETE',
        success: function (result) {
          if(result =='success')		
        {
          swal("Success...!", "CashBook Entry Deleted Successfully...!", "success")
          .then(function() {
            window.location.href="<?php echo scs_index?>Master/CashBook";
            });
        }
      }
    });

      }else{
        window.location.href="<?php echo scs_index?>Master/CashBook_View";
      }
    })

   
    
  }
</script>