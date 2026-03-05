<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Settlement','Collection');
$this->pfrm->FrmHead3('Settlement / Collection',$F_Class."/".'Collection',$F_Class."/".$F_Ctrl."_View");
?>

<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
    <form method="POST" id="CollectionForm" >
    <fieldset>
    <input type="hidden" name="idv" value="<?php echo @$ID; ?>" >
    <div style="margin-bottom: 10px; display: flex; justify-content: flex-end; gap: 20px;">
    <div>
        <label for="total_outstanding" style="font-weight: bold;">Total Outstanding:</label>
        <input type="text" id="total_outstanding" class="f-ctrl" readonly style="width: 150px; text-align: right; font-weight: bold;" value="0.00">
    </div>
    <div>
        <label for="total_paid" style="font-weight: bold;">Total Paid:</label>
        <input type="text" id="total_paid" class="f-ctrl" readonly style="width: 150px; text-align: right; font-weight: bold;" value="0.00">
    </div>
</div>
    <table class="table table-bordered table-hover" id="mytable" >         
		   <tbody>
		    <?php 
			 $i=1;
		      $qry="select pd.Amount as amt ,* from Trans_Checkout_mas cmas
             inner join Trans_Pay_Det pd on cmas.checkoutid = pd.Checkoutid
             inner join Mas_Room mr on mr.Room_Id= cmas.Roomid
             inner join mas_roomType mrt on mrt.RoomType_Id=mr.RoomType_Id
             inner join mas_customer cus on cus.Customer_Id = cmas.Customerid
             inner join mas_title mt on mt.Titleid=cus.Titelid
             where Paymodeid='4' and Bankid='".$ID."'  and isnull(pd.cancelflag,0)<>1
             order by cmas.Checkoutid ";
			      $exec=$this->db->query($qry); $totalAdvance=0;
             $totalamount = 0;
			 $advance= $exec->num_rows();
			  if($advance !=0)
			  {
				echo '<tr>';
				echo '<td colspan="10" class="text-bold" style="text-align: center;">Collection</td>';			
				echo '</tr>';

        echo '<tr style="background-color:#c9c6c6;">';			 
				echo '<td  style="text-align: center;">S.no</td>';
				echo '<td  style="text-align: center;">Checkout No</td>';
                echo '<td  style="text-align: center;">Checkout Date</td>';
				echo '<td style="text-align: center;">Guest Name</td>';
                echo '<td style="text-align: center;">Room Type</td>';
                echo '<td style="text-align: center;">Pax</td>';
                echo '<td style="text-align: center;">Bill Amt</td>';
                echo '<td style="text-align: center;">Paid Amt</td>';
                echo '<td style="text-align: center;">Balance Amt</td>';
                echo '<td style="text-align: center;">Pay</td>';
               
				echo '</tr>';	
        		
			  }		
     

        $total_totalamount = 0;
        $total_paidamount = 0;
        $total_balance = 0;
        
        foreach ($exec->result_array() as $rows) {
          if ($rows['amt'] != $rows['Paidamount']) {
        
            $balance = $rows['amt'] - $rows['Paidamount'];
            $total_totalamount += $rows['totalamount'];
            $total_paidamount += $rows['Paidamount'];
            $total_balance += $balance;
        
            echo '<tr class="tablerow">';
            echo '<td style="text-align: center;">'.$i.'</td>';
            echo '<td style="text-align: left;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';
            echo '<td style="text-align: left;">'.date('d-m-Y', strtotime($rows['Checkoutdate'])).'</td>';
            echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].' '.$rows['Lastname'].'</td>';
            echo '<td style="text-align: left;">'.$rows['RoomType'].'</td>';
            echo '<td style="text-align: left;">'.$rows['Noofpersons'].'</td>';
        
        
            echo '<td style="text-align: left;">
                    <input type="text" class="f-ctrl rmm" readonly num=1 id="tamt_'.$i.'" value="'.$rows['totalamount'].'" required >
                  </td>';
        
    
            echo '<td style="text-align: left;">
                    <input type="text" class="f-ctrl rmm" readonly num=1 id="pamt_'.$i.'" value="'.$rows['Paidamount'].'" required >
                  </td>';
        
        
            echo '<td style="text-align: left;">
                    <input type="text" class="f-ctrl rmm" readonly num=1 id="Camt_'.$i.'" value="'.$balance.'" required >
                  </td>';
        
            echo '<td style="text-align: left;">
                    <input type="text" class="f-ctrl rmm payingamt" name="Amt[]" num=1 id="Amt_'.$i.'" required >
                  </td>';
        
                  echo '<input type="hidden" name="bval" value="'.$i.'" id="bval_'.$i.'">';
            echo '<input type="hidden" name="checkoutid[]" value="'.$rows['Checkoutid'].'" id="checkoutid_'.$i.'">';
            echo '<input type="hidden" name="Billno[]" value="'.$rows['Checkoutno'].'" id="Billno_'.$i.'">';
            echo '<input type="hidden" name="checkoutdate[]" value="'.$rows['Checkoutdate'].'" id="checkoutdate_'.$i.'">';
            echo '<input type="hidden" name="Billamount[]" value="'.$balance.'" id="Billamount_'.$i.'">';
            echo '<input type="hidden" name="Paidamount[]" value="'.$rows['Paidamount'].'" id="Paidamount_'.$i.'">';
        
            $i++;
          }
        }
        
        
        echo '<tr style="background-color:#f0f0f0; font-weight:bold;">';
        echo '<td colspan="6" style="text-align: right;">Total</td>';
        echo '<td><input type="text" style="text-align: right;" class="f-ctrl" readonly value="'.$total_totalamount.'"></td>';
        echo '<td><input type="text" style="text-align: right;" class="f-ctrl" readonly value="'.$total_paidamount.'"></td>';
        echo '<td><input type="text" style="text-align: right;" class="f-ctrl" readonly value="'.$total_balance.'"></td>';
        echo '<td><input type="text" style="text-align: right;" class="f-ctrl" readonly id="totalPayingAmt" value="0.00"></td>';
        echo '</tr>';
              
		   ?>		   
		   </tbody>
           <input type="hidden" name="totalamount" value="<?php echo $totalamount?>" id="totalamount">
           <input type="hidden" name="tempamount" value="0" id="tempamount">
           
           <tfoot>
              <tr>
                <td colspan="8"align="right">&nbsp;</td>
                <td align="left"><input type="button"  onclick="paymodeValid();" class="btn btn-success btn-sm" id="EXEC" name="EXEC" value="SAVE"   /></td>
              </tr>
           </tfoot>

           <input type="hidden" value="<?php echo $i-1; ?>" name='countrow' id="countrow" >
		</table>
      <table  width="100%" class="mytable" style="margin-top:20px">
        <thead>          
          <tr>
            <th>Amount</th>
            <th>Paymode</th>
            <th>Bank</th>
            <th>Card.No</th>
            <th>Validate</th>
            <th>Action</th>
          </tr>
        </thead>
          <tbody id="row"> 
            <?php 
             $qrys="select mc.Company_id ,mc.Company,Sum(isnull(pd.Amount,0)) - Sum(isnull(pd.Paidamount,0)) as totalamount from mas_company mc
              inner join Mas_CompanyType mct on mct.CompanyType_Id= mc.CompanyType_Id
              left join trans_pay_det pd on pd.Bankid=mc.Company_Id
              left join Trans_checkout_mas cmas on cmas.Checkoutid = pd.Checkoutid
              where mct.CompanyType<>'travelagent'
              group by mc.company ,mc.Company_Id having mc.Company_Id='".$ID."'";
            	$ress=$this->db->query($qrys);
              $counts= $ress->num_rows(); $j=1;
              foreach($ress->result() as $rows)
              {  ?>
              <tr>

                <td>
                  <input type="hidden" name="Companyid" value="<?php echo $rows->Company_id ?>" id="Company_id">
                  <input type="text" class="f-ctrl rmm"  num=1 id="Amtt_1" required  value="" name="Amtt[]"></td>
                <td><select required class="scs-ctrl"
                onchange="paymodevalidate(this.value,1)"  name="paymode[]" id="paymode_1" ><option value="0">--Paymode--</option>
                    <?php 
                      $Res=$this->Myclass->PayMode();
                      foreach($Res as $row) 
                        {
                          if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY' && $row['PayMode'] !='TOROOM' && $row['PayMode'] !='CASH ON DELIVERY')
                          { ?>
                            <option  value="<?php echo $row['PayMode'] ?>" ><?php echo $row['PayMode'] ?></option>
                          <?php
                          }
                        }      
                      ?>
                    </select>
                </td>
                <td id="bankoption_1"><select name="bank[]" class="scs-ctrl" id="bank_1"><option value="0">--Bank--</option>
                    <?php 
                    $Res=$this->Myclass->Bank();
                    foreach($Res as $row) 
                    { ?>
                      <option  value="<?php echo $row['Bankid'] ?>" ><?php echo $row['bank'] ?></option>                      
                    <?php
                    }
                    ?>
                    </select>
                </td>
                <td><input type="text" class="scs-ctrl" value="0"    oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="cardno[]" id="cardno_1"></td>
                <td><input type="date" class="scs-ctrl  rmm"   value="<?php echo date('Y-m-d')?>" name="validate[]" id="validate_1"></td>
                <?php if($j==1){ ?>
                <td><input type="button" class="add-row" style="display:inline-block" id="add" value="+"> <button type="button" class="delete-row">x</button></td>
                <?php } else { ?>
                <td><input type='checkbox' name='record'></td>
                <?php } ?>
              </tr>             
           <?php $j++; } ?>
          </tbody>
      </table>
      <input type="hidden" value="<?php echo $counts; ?>" name="counts" id="counts" >
    </fieldset>
    </form>
  </div>
  <div class="the-box D_IS" ></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<script>
  var bank=0;
 var card=0;
 var validate=0;
 var payid ='';
 function paymodevalidate(id, i) {
    if (id === "0" || id === "") return;  

    
    var duplicates = false;
    $("select[name='paymode[]']").each(function(index, element) {
        var val = $(element).val();
        var currentId = $(element).attr('id'); 
        if (val === id && currentId !== "paymode_" + i  ) {
            duplicates = true;
            return false; 
        }
    });

    if (duplicates) {
      swal("Warning...!", "Please Select Other Paymode Its Already Selected", "warning");
        $("#paymode_" + i).val('0');
    
        return; 
    }

    document.getElementById("EXEC").disabled = false;
    payid = id;

    if (id == "UPI") {
        document.getElementById("cardno_" + i).disabled = true;
        document.getElementById("cardno_" + i).value = 0;
        document.getElementById("validate_" + i).disabled = true;
        document.getElementById("validate_" + i).value = '';
        $.ajax({
            type: "POST",
            url: "<?php echo scs_index ?>Transaction/UpiOptions",
            data: "id=" + id,
            success: function(html) {
                $("#bank_" + i).html(html);
            }
        });
    } else if (id == "CREDIT CARD" || id == "CHEQUE" || id == "NET TRANSFER" || id == "CREDIT" || id == "NET" ) {
   
      $("#bank_" + i).html('');
        $.ajax({
            type: "POST",
            url: "<?php echo scs_index ?>Transaction/Otheroption",
            success: function(html) {
                $("#bank_" + i).html(html);

         
                
            }
        });
        document.getElementById("cardno_" + i).disabled = false;
        document.getElementById("validate_" + i).disabled = false;
        document.getElementById("bank_" + i).disabled = false;
    } else if (id == "CASH") {
        document.getElementById("cardno_" + i).disabled = true;
        document.getElementById("validate_" + i).disabled = true;
        document.getElementById("validate_" + i).value = '';
        document.getElementById("bank_" + i).disabled = true;
        document.getElementById("bank_" + i).value = 0;
    }
}




 function paymodeValid(){

  let count = document.getElementById("counts").value;
  var totalamount = document.getElementById("tempamount").value;
  var paying = document.getElementsByClassName("payingamt").value;
  var amt_total = 0;
    for(let j=1 ; j<=count; j++){
      var amt = document.getElementById("Amtt_"+j).value;
      amt_total= amt_total + Number(amt);
    }
 
    if(amt_total > paying){
      swal("Failed...!", "Amount not matched", "error")
      return
    }
    if(amt_total == 0){
      swal("Failed...!", "Amount is empty", "error")
      return
    }
    if(amt_total < paying){
      swal("Failed...!", "Amount not matched", "error")
      return
    }
  for(let i=1; i<=count; i++){
    let paymode = document.getElementById("paymode_"+i).value
    
    if(paymode == "UPI"){
      let bank=document.getElementById("bank_"+i).value;
      
      if(Number(bank == 0) ){
        swal("Failed...!", "please select Bank", "error")
        return
      }
    }else if( paymode == "CREDIT CARD"  || paymode == "CHEQUE" || paymode == "NET TRANSFER"  ){
      let card = document.getElementById("cardno_"+i).value
      let bank=document.getElementById("bank_"+i).value;
      if(Number(bank == 0) ){
        swal("Failed...!", "please select Bank", "error")
        return
      }
      if(card == 0){
        swal("Failed...!", "Please Enter card Number", "error")
      return
      }
    }
    
    else if(paymode != 0){
      document.getElementById("EXEC").disabled= false
    }
    else{
      document.getElementById("EXEC").disabled= true
      swal("Failed...!", "paymode is empty", "error")
      return
    }
  }

  $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Transaction/Collection_val',
      data: $('#CollectionForm').serialize(),
      success: function (result) {
      
        if(result.trim() =='success')		
      {
        swal("Success...!", "Collection Saved Successfully...!", "success")
        .then(function() {
          window.location.href="<?php echo scs_index?>Transaction/Collection";

          });
      }
      else
      {
        swal("Failed...!", "Collection Save Faild...!", "error")
        .then(function() {
          window.location.href="<?php echo scs_index?>Transaction/Collection";
          });
      }
    
    }
  });

  
 }
 
 function savee(a,i){
    var totalamount = document.getElementById("tempamount").value;
    var amt_total = 0;
    for(let j=1 ; j<=i; j++){
      var amt = document.getElementById("Amtt_"+j).value;
      amt_total= amt_total + Number(amt);
    }
    if(Number(totalamount) != amt_total){
      document.getElementById("EXEC").disabled= true
      document.getElementById("add").disabled= false
      if(Number(totalamount) < amt_total){
        document.getElementById("Amtt_"+i).value=0
      }
    }
    else{
      document.getElementById("EXEC").disabled=false
      document.getElementById("add").disabled= true
    }
   

  
  }
  function save(a,i){
    var totalamount = document.getElementById("totalamount").value;
    // alert(totalamount)
    var Camt = 0;
    var amt_total = 0;
    var rowCount = $('#mytable .tablerow').length;
   
    for( let k=1; k<=rowCount; k++){
      if(Number(document.getElementById("Amt_"+i).value) <= Number(document.getElementById("Camt_"+i).value) ){
        Camt += Number(document.getElementById("Camt_"+i).value);
      }else{
         document.getElementById("Amt_"+i).value = 0
      }
      
    }
    
    for(let j=1 ; j<=rowCount; j++){
      var amt = document.getElementById("Amt_"+j).value;
      amt_total= amt_total + Number(amt);
      
    }
  
    document.getElementById("Amtt_1").value = amt_total
    document.getElementById("add").disabled= true
    document.getElementById("tempamount").value = amt_total
    
    if(Number(totalamount) != amt_total){
      document.getElementById("add").disabled= false
      if(Number(totalamount) >= amt_total){
        if(Number(Camt) >= amt_total){
            document.getElementById("EXEC").disabled= false
        }
        else{
           var t = document.getElementById("Amt_"+i).value
            amt_total= amt_total-Number(t);
            document.getElementById("EXEC").disabled= false
        }
      }
      else{
        var t = document.getElementById("Amt_"+i).value
        amt_total= amt_total-Number(t);
        document.getElementById("Amt_"+i).value=0
        document.getElementById("EXEC").disabled= false
      }
    }
    else{
      document.getElementById("EXEC").disabled=false
    }
   
    // alert(amt_total)
    

  }
    function fromdatevalidate()
	   {
		 var a= document.getElementsByName("dateFrom")[0].value;
		 alert(a);
	   }
      var table = document.getElementById("row");
      var i = table.rows.length;   
      

     $(document).ready(function(){
      var TempAmount = 0;
      var totalamount = document.getElementById("totalamount").value;
      var savebtn = document.getElementById("EXEC");  
        $(".add-row").click(function(){  
          var pay = document.getElementById('paymode_'+i).value;
          if(pay==0){
            swal("Error...!", "Select Paymode!", "error");
            return
          }
          i=i+1;
			var parow="<td id='bankoption_"+i+"'><select name='bank[]' class='f-ctrl' id='bank_"+i+"'><option value='0'>--Bank--</option><?php $Res=$this->Myclass->Bank(); foreach($Res as $row) {   echo '<option value='.$row['Bankid'].' >'.$row['bank'].'</option>'; }	?>	</select></td>";
      var paymode = "<td><select class='f-ctrl' onchange='paymodevalidate(this.value,i)' name='paymode[]' id='paymode_" + i + "' >" +
              "<option value='0'>--Paymode--</option> " +
              "<?php 
                $Res = $this->Myclass->PayMode(); 
                foreach($Res as $row) { 
                  if($row['InActive'] == 0 && $row['PayMode'] != 'COMPANY' && $row['PayMode'] != 'TOROOM' && $row['PayMode'] != 'CASH ON DELIVERY') {  
                    echo '<option value=\"'.htmlspecialchars($row['PayMode'], ENT_QUOTES).'\">'.htmlspecialchars($row['PayMode']).'</option>'; 
                  } 
                } 
              ?>" +
              "</select></td>";
			var markup = "<tr>" +
  "<td><input type='text' num='1' class='f-ctrl rmm' name='Amtt[]' id='Amtt_" + i + "'></td>" +
  paymode + parow +
  "<td><input type='text' class='f-ctrl' value='0' name='cardno[]' id='cardno_" + i + "'   oninput='this.value.replace(/[^0-9]/g, '')'></td>" +
  "<td><input type='date' id='validate_" + i + "' value='<?php echo date('Y-m-d'); ?>' class='f-ctrl' name='validate[]'></td>" +
  "<td>" +
    "<button type='button' class='add-row' onclick='addrows()' style='display:inline-block;' id='add'>+</button> " +
    "<button type='button' class='delete-row'  onclick='deleterows(this)'>x</button>" +
  "</td>" +
"</tr>";
            $("#row").append(markup);
            document.getElementById("counts").value= i;
        });

      



  
        
        // Find and remove selected table rows
        $(".delete-row").click(function(){
			//i=i-1;
			//alert("veruthu");
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    i=i-1;
                }
            });
        });
    });   

	</SCRIPT>


<script>
  


    function addrows(){
       var pay = document.getElementById('paymode_'+i).value;
          if(pay==0){
            swal("Error...!", "Select Paymode!", "error");
            return
          }
          i=i+1;
			var parow="<td id='bankoption_"+i+"'><select name='bank[]' class='f-ctrl' id='bank_"+i+"'><option value='0'>--Bank--</option><?php $Res=$this->Myclass->Bank(); foreach($Res as $row) {   echo '<option value='.$row['Bankid'].' >'.$row['bank'].'</option>'; }	?>	</select></td>";
      var paymode = "<td><select class='f-ctrl' onchange='paymodevalidate(this.value,i)' name='paymode[]' id='paymode_" + i + "' >" +
              "<option value='0'>--Paymode--</option> " +
              "<?php 
                $Res = $this->Myclass->PayMode(); 
                foreach($Res as $row) { 
                  if($row['InActive'] == 0 && $row['PayMode'] != 'COMPANY' && $row['PayMode'] != 'TOROOM' && $row['PayMode'] != 'CASH ON DELIVERY') {  
                    echo '<option value=\"'.htmlspecialchars($row['PayMode'], ENT_QUOTES).'\">'.htmlspecialchars($row['PayMode']).'</option>'; 
                  } 
                } 
              ?>" +
              "</select></td>";
			var markup = "<tr>" +
  "<td><input type='text' num='1' class='f-ctrl rmm' name='Amtt[]' id='Amtt_" + i + "'></td>" +
  paymode + parow +
  "<td><input type='text' class='f-ctrl' value='0' name='cardno[]' id='cardno_" + i + "' oninput='this.value = this.value.replace(/[^0-9]/g, '')'></td>" +
  "<td><input type='date' id='validate_" + i + "' value='<?php echo date('Y-m-d'); ?>' class='f-ctrl' name='validate[]'   ></td>" +
  "<td>" +
    "<button type='button' class='add-row' onclick='addrows()' style='display:inline-block;' id='add'>+</button> " +
    "<button type='button' class='delete-row' onclick='deleterows(this)'>x</button>" +
  "</td>" +
"</tr>";
            $("#row").append(markup);
            document.getElementById("counts").value= i;
        
        }







$(document).ready(function(){
  var paymode = document.getElementById("paymode_1").value
  var company = document.getElementById("bank_1").value
  var payamount = document.getElementById("Amt_1").value
  var amount = document.getElementById("Amtt_1").value

  if(Number(payamount) != Number(amount) ){
    document.getElementById("EXEC").disabled= false
  }else{
    document.getElementById("EXEC").disabled= true
  }
  if(paymode == "COMPANY"){
    $.ajax({
      type:"POST",
      url:"<?php echo scs_index ?>Transaction/CompanyModeSettle",
      data:"&id="+company,
      success: function (html){

        $("#bankoption_1").html(html)
        
      }
    })
  }

})

</script>

<script>
          function deleterows(btn) {
  // Remove the row containing this button
  btn.closest('tr').remove();
}

</script>

<!-- <script>
  $(document).on('input', 'input[name="Amtt[]"]', function () {
    let totalAmount = parseFloat($('#totalamount').val()) || 0;
    let currentSum = 0;

    $('input[name="Amtt[]"]').each(function () {
        let val = parseFloat($(this).val()) || 0;
        currentSum += val;
    });

    if (currentSum > totalAmount) {
        swal("Warning", "Entered amount exceeds total amount!", "warning");
        $(this).val('');
        currentSum -= parseFloat($(this).val()) || 0; // rollback the last entry
    }

    $('#tempamount').val(currentSum);

    if (currentSum === totalAmount) {
        $('#EXEC').prop('disabled', false);
    } else {
        $('#EXEC').prop('disabled', true);
    }
});

</script> -->


<script>
$(document).on('input', 'input[name="Amtt[]"]', function () {
    let totalOutstanding = parseFloat($('#totalPayingAmt').val()) || 0;
    let currentSum = 0;

    $('input[name="Amtt[]"]').each(function () {
        let val = parseFloat($(this).val()) || 0;
        currentSum += val;
    });

  



    if (currentSum > totalOutstanding) {
        swal("Warning", "Entered amount exceeds total outstanding amount!", "warning");
        $(this).val(''); 
        
        return; 
    }


    if (currentSum === totalOutstanding) {
        $('#EXEC').prop('disabled', false);
    } else {
        $('#EXEC').prop('disabled', true);
    }


    $('#tempamount').val(currentSum.toFixed(2));
});
</script>



<script>
function calculateTotals() {
    let totalOutstanding = 0;
    let totalPaid = 0;
    const count = parseInt(document.getElementById("countrow").value);

    for (let i = 1; i <= count; i++) {
        const camtEl = document.getElementById("Camt_" + i);
        const paidEl = document.getElementById("Paid_" + i);

        if (camtEl) {
            totalOutstanding += parseFloat(camtEl.value) || 0;
        }

        if (paidEl) {
            totalPaid += parseFloat(paidEl.innerText) || 0;
        }
    }

    document.getElementById("total_outstanding").value = totalOutstanding.toFixed(2);
    document.getElementById("total_paid").value = totalPaid.toFixed(2);
}


$(document).ready(function () {
    calculateTotals();
});
</script>


<script>
$(document).on('input', 'input[name="Amt[]"]', function () {
    let totalSum = 0;
    let isValid = true;

    $('input[name="Amt[]"]').each(function (index) {
        let amtInput = $(this);
        let rowIndex = index + 1;

        let enteredAmount = parseFloat(amtInput.val()) || 0;
        let balanceAmount = parseFloat($('#Billamount_' + rowIndex).val()) || 0;

   
        if (enteredAmount > balanceAmount) {
          swal("Warning", "Entered amount exceeds balance amount!", "warning");
            amtInput.val('');
            isValid = false;
        } else {
            totalSum += enteredAmount;
        }
    });

  
    $('#totalPayingAmt').val(totalSum.toFixed(2));
    $('#tempamount').val(totalSum.toFixed(2));


    if (isValid) {
        $('#EXEC').prop('disabled', false);
    } else {
        $('#EXEC').prop('disabled', true);
    }
});

</script>
