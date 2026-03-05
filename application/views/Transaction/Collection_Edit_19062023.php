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
             where Paymodeid='4' and Bankid='".$ID."'
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
                echo '<td style="text-align: center;">Amount</td>';
                echo '<td style="text-align: center;">Pay</td>';
                echo '<td style="text-align: center;">Paid</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {	
          if($rows['amt'] != $rows['Paidamount']){

          
        $totalamount = $totalamount+$rows['totalamount']-$rows['Paidamount'];			
				echo '<tr class="tablerow">';		 
				echo '<td  style="text-align: center;">'.$i.'</td>';
				echo '<td style="text-align: left;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';
        echo '<td style="text-align: left;">'.date('d-m-Y', strtotime($rows['Checkoutdate'])).'</td>';
        echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].' '.$rows['Lastname'].'</td>';
        echo '<td style="text-align: left;">'.$rows['RoomType'].'</td>';
        echo '<td style="text-align: left;">'.$rows['Noofpersons'].'</td>';
				echo '<td style="text-align: left;">
                <input type="text" class="f-ctrl rmm" readonly  num=1 id="Camt_'.$i.'" value="'.$rows['amt']-$rows['Paidamount'].'" required ></td>
                </td>';
        echo '<td style="text-align: left;">
        <input type="text" class="f-ctrl rmm" name="Amt[]" onkeyup="save(this.value,'.$i.');" num=1 id="Amt_'.$i.'"  required ></td>
        </td>';
        echo '<td style="text-align: left;">'.$rows['Paidamount'].'</td>';
        echo' <input type="hidden" name="checkoutid[]" value="'.$rows['Checkoutid'].'" id="checkoutid_1">';
        echo'<input type="hidden" name="Billno[]" value="'.$rows['Checkoutno'].'" id="Billno_1">';
        echo'<input type="hidden" name="checkoutdate[]" value="'.$rows['Checkoutdate'].'" id="checkoutdate_1">';
        echo'<input type="hidden" name="Billamount[]" value="'.$rows['totalamount']-$rows['Paidamount'].'" id="Billamount_1">';
        echo'<input type="hidden" name="Paidamount[]" value="'.$rows['Paidamount'].'" id="Paidamount_1">'; 
        $i++;	}
         		
			  }	      
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
                <td><input type="hidden" name="Companyid" value="<?php echo $rows->Company_id ?>" id="Company_id">
                  <input type="text" class="f-ctrl rmm" onkeyup="savee(this.value,1);" num=1 id="Amtt_1" required  value="" name="Amtt[]"></td>
                <td><select required class="scs-ctrl"
                onchange="paymodevalidate(this.value,1)"  name="paymode[]" id="paymode_1" ><option value="0">--Paymode--</option>
                    <?php 
                      $Res=$this->Myclass->PayMode();
                      foreach($Res as $row) 
                        {
                          if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY ' && $row['PayMode'] !='TO ROOM')
                          { ?>
                            <option  value="<?php echo $row['PayMode_Id'] ?>" ><?php echo $row['PayMode'] ?></option>
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
                <td><input type="text" class="scs-ctrl" value="0"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="cardno[]" id="cardno_1"></td>
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
      <input type="hidden" value="<?php echo $counts; ?>" name='counts' id="counts" >
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
 var payid =0;
 function paymodevalidate(id,i)
 {  
  document.getElementById("EXEC").disabled=false
   payid=id;
   if(id==13){
      document.getElementById("cardno_"+i).disabled = true;
      document.getElementById("cardno_"+i).value=0;
      document.getElementById("validate_"+i).disabled = true
      $.ajax({
        type:"POST",
        url:"<?php echo scs_index ?>Transaction/UpiOptionSettle",
        data:"id"+id,
        success: function (html){
          $("#bank_"+i).html(html)
        }
      })
    }else if(id==2 || id==3 || id==5){
      $.ajax({
        type:"POST",
        url:"<?php echo scs_index ?>Transaction/CompanyModeSettleCredit",
        success: function (html){
          $("#bank_"+i).html(html)
        }
      })
      document.getElementById("cardno_"+i).disabled = false
      document.getElementById("validate_"+i).disabled = false 
	    document.getElementById("bank_"+i).disabled = false  
    }
    else if(id == 1)
    {
      document.getElementById("cardno_"+i).disabled = true
      document.getElementById("validate_"+i).disabled = true
	    document.getElementById("bank_"+i).disabled = true     
      document.getElementById("bank_"+i).value = 0   
   }
    
 }




 function paymodeValid(){
  let count = document.getElementById("counts").value;
  var totalamount = document.getElementById("tempamount").value;
  var amt_total = 0;
    for(let j=1 ; j<=count; j++){
      var amt = document.getElementById("Amtt_"+j).value;
      amt_total= amt_total + Number(amt);
    }
    if(amt_total > totalamount){
      swal("Failed...!", "Amount not matched", "error")
      return
    }
    if(amt_total == 0){
      swal("Failed...!", "Amount is empty", "error")
      return
    }
    if(amt_total < totalamount){
      swal("Failed...!", "Amount not matched", "error")
      return
    }
  for(let i=1; i<=count; i++){
    let paymode = document.getElementById("paymode_"+i).value
    
    if(paymode == 13){
      let bank=document.getElementById("bank_"+i).value;
      
      if(Number(bank == 0) ){
        swal("Failed...!", "please select Bank", "error")
        return
      }
    }else if( paymode ==2 || paymode == 3){
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
    else if(paymode ==5){
      let bank =document.getElementById("bank_"+i).value;
      if(Number(bank) == 0){
        swal("Failed...!", "Please select Bank", "error")
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
        if(result =='success')		
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
            var paymode="<td ><select  class='f-ctrl' onchange='paymodevalidate(this.value,i)' name='paymode[]' id='paymode_"+i+"' ><option value='0'>--Paymode--</option> <?php $Res=$this->Myclass->PayMode(); foreach($Res as $row) { if($row['InActive'] ==0 && $row['PayMode'] !='COMPANY ' && $row['PayMode'] !='TO ROOM') {  echo '<option value='.$row['PayMode_Id'].'>'.$row['PayMode'].'</option>'; }} ?> </select></td>";
			var markup = "<tr><td><input type='text'  num=1 class='f-ctrl rmm' onkeyup='savee(this.value,"+i+");' name='Amtt[]' id='Amtt_"+i+"' ></td>"+paymode+parow+"<td><input type='text' class='f-ctrl' value='0'  name='cardno[]' id='cardno_"+i+"'></td><td><input type='date' id='validate_"+i+"' value='<?php echo date('Y-m-d');?>' class='f-ctrl'  name='validate[]' ></td><td><input type='checkbox' name='record'></td></tr>";
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
  if(paymode == 4){
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