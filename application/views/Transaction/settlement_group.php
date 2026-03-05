<?php
	$yearprefix ='';
	$Billno='';
	$totalamount=0;
	$Roomno='';
	$checkindate='';
	$checkintime='';
	$Title='';
	$gname='';
	$Mobile='';
	$City='';
	$Noadults='';
	$noofdays='';

	

 $date=date("Y-m-d");
 $time= date("H:i:s");
   
  $billId = $_REQUEST['Billid'];

  $chid = "select grpcheckoutbillid from trans_checkout_mas where Checkoutid = '".$billId."'";

  $get = $this->db->query($chid)->row_array();
  

  $sql = "
  SELECT distinct
      cmas.Checkoutno AS Billno,
      ISNULL(cmas.totalAmount, 0) AS receipt,
      cmas.Roomid,
      cmas.roomgrcid,
      cmas.totalamount,
      cmas.yearPrefix,
      rm.RoomNo,
      Noadults,
      noofdays,
      cimas.CheckinDate,
      cimas.CheckinTime,
      cus.Firstname,
      cus.HomeAddress1,
      cus.HomeAddress2,
      cus.Mobile,
      mt.Title,
      ct.City
  FROM Trans_Checkout_mas cmas
  INNER JOIN Mas_Room rm ON rm.Room_Id = cmas.Roomid
  INNER JOIN Trans_checkin_mas cimas ON cimas.Grcid = cmas.grcid
  INNER JOIN Trans_Roomdet_det rdd ON rdd.roomgrcid = cmas.roomgrcid
  INNER JOIN Mas_Customer cus ON cus.Customer_Id = cmas.Customerid
   Left outer JOIN Mas_Title mt ON mt.Titleid = cus.Titelid
  left outer  JOIN Mas_City ct ON ct.Cityid = cus.Cityid
  LEFT JOIN Trans_Receipt_mas rmas ON rmas.roomgrcid = cmas.Roomgrcid
  WHERE cmas.Checkoutno LIKE '%CHK%'  and cmas.grpcheckoutbillid = '".$get['grpcheckoutbillid']."'
";


  $grpid = $get['grpcheckoutbillid'];

// AND cmas.Checkoutid = '$billId'
$res = $this->db->query($sql);
$row = $res->result_array();



if ($row) {

    $totalamount = 0;
    $roomIdList  = [];  
    $Noadults = 0;  
    
    foreach($row as $rows) {
    
        $Roomno      = $rows['RoomNo']         ?? '';
        // $Noadults    = $rows['Noadults']       ?? '';
        $noofdays    = $rows['noofdays']       ?? '';
        $gname       = $rows['Firstname']      ?? '';
        $checkindate = $rows['CheckinDate']    ?? '';
        $checkintime = $rows['CheckinTime']    ?? '';
        $Title       = $rows['Title']          ?? '';
        $Roomgrcid   = $rows['roomgrcid']      ?? '';
        $City        = $rows['City']           ?? '';
        $Mobile      = $rows['Mobile']         ?? '';
        $Billno      = $rows['Billno']         ?? '';
        $Add1        = $rows['HomeAddress1']   ?? '';
        $Add2        = $rows['HomeAddress2']   ?? '';
        $receipt     = $rows['receipt']        ?? '';
        $yearprefix  = $rows['yearPrefix']     ?? '';
    
        $Noadults  += $rows['Noadults'];
        $totalamount  += $rows['totalamount'];
        
        $roomIdList[] = $rows['Roomid'];
    }
    
    $roomCSV = implode(",", $roomIdList);
   
    
 
}

    
  ?>
	
  <form id="settlementsave">
  <table class="FrmTable" style="width:100%">
    <tr>
	<td>#Bill No</td>
	<td><input type='text' class="m-ctrl" style="background-color:#FFF59B;" Readonly value="<?php echo $yearprefix.'/'.$Billno; ?>"></td>
	<td>Customer</td>
	<td><input type='text' class="m-ctrl" style="background-color:#FFF59B;" Readonly value="<?php echo $Title.".".$gname; ?>"></td>
    </tr>	
    <tr>
    <td>Room No</td>
	<td><input type='text' class="m-ctrl" style="background-color:#FFF59B;" Readonly value="<?php echo $Roomno; ?>"></td>
    <td>Mobile No</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo $Mobile ?>" readonly ></td>
    </tr>
    <tr>
    <td>C.In Date&Time</td>
	<td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo date("d-m-Y", strtotime($checkindate)); echo "/" ; echo substr($checkintime,11,8);  ?>" readonly ></td>
	<td>City</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo $City; ?>" readonly ></td>
    </tr>
    <td>C.Out Date&Time</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php  echo date("d-m-Y", strtotime($date)); echo "/"; echo $time   ?>" readonly ></td>
	<td>Pax</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo $Noadults ?>" readonly ></td>
    </tr>
    <tr>
	<td>Bill Amount</td><td><input type="text" class="m-ctrl" name="totalbillamout" id="totalbillamout" style="background-color:#FFF59B;" value="<?php echo  $totalamount; ?>" readonly ></td>
	<td>Days</td><td><input type="text" class="m-ctrl" style="background-color:#FFF59B;" value="<?php echo $noofdays ?>" readonly ></td>
	</tr>	
	<tr>
	 <td></td>
	 <td></td>
	<td></td>
	<td><input type="submit" class="btn btn-warning btn-sm" value="settle" id="EXEC" >
	<img id="loaderimg" src="../../assets/formloader.gif" width="20px" style="display:none;"/>
	</td>
	</tr>
	
	</table>
    

</head>
<body>
    
    <table id="mytable" width="100%" class="mytable" style="margin-top:20px">
    <thead>
        
            <tr>
                <th>Amount</th>
                <th>Paymode</th>
                <th>Bank / Room</th>
				<th>Card.No</th>
				<th>Validate</th>
				<th>Action</th> 
            </tr>
        </thead>
        <tbody id="row">
            <tr>
                <td><input type="text" class="m-ctrl" required onchange = 'savee(this.value,1)' value="<?php echo  $totalamount; ?>" id="Amt_1" name="Amt_1"></td>
      <td>
  <select required class="m-ctrl"
    onchange="paymodevalidate(this.value,1)"  name="paymode_1" id="paymode_1" >
    <option value="">--Paymode--</option>
    <?php 
    $Res = $this->Myclass->PayMode();

    foreach ($Res as $row) {
      if ($row['InActive'] == 0 && $row['PayMode'] != 'CASH ON DELIVERY') {
        echo '<option value="'.$row['PayMode'].'">'.$row['PayMode'].'</option>';
      }
    }
    ?>
  </select>
</td>
                <td id="bankoption_1"><select name="bank_1" class="m-ctrl" id="bank_1"><option value="">--Bank--</option>
					<?php 
					$Res=$this->Myclass->Bank();
					foreach($Res as $row) 
					{
	
					   echo '<option value="'.$row['Bankid'].'"	 >'.$row['bank'].'</option>';
						
					}
					?>
					</select>
				</td>
        
				<td><input type="text" pattern="\d*" class="m-ctrl"  name="cardno_1" id="cardno_1"></td>
				<td><input type="date" class="m-ctrl" value='<?php echo date('Y-m-d') ?>'  min="<?php echo date('Y-m-d'); ?>"  name="validate_1" id="validate_1"></td>
				<td><input type="button" id="add" class="add-row"  value="+"> <button type="button" class="delete-row">x</button></td>
				
            </tr>
        </tbody>
    </table>
   
</body> 
	

</form>

<script>
// var i=1;
//      $(document).ready(function(){
//         $(".add-row").click(function(){
// 			// let rowCount = $(":checkbox:checked").length+1;
//             //         alert(rowCount)
// 			var rowCount = $('#mytable tr').length;
//           i = rowCount-1
//           var totalamount = document.getElementById("totalbillamout").value;
//           var amt_total = 0;
//           for(let j=1 ; j<=i; j++){
//             var amt = document.getElementById("Amt_"+j).value;
//             amt_total= amt_total + Number(amt);
//           }
//           if(Number(totalamount) == Number(amt_total)){
//             document.getElementById("add").disabled= true
//             return
//           }
//           else{l
//             document.getElementById("add").disabled= false
//           }
//         for(let k=1; k<=i; k++){
//       	    let paymode = document.getElementById("paymode_"+k).value
    
// 			if(paymode == 13){
// 			let bank=document.getElementById("bank_"+k).value;
// 			if(Number(bank == 0 || bank == '') ){
// 				swal("Failed...!", "please select Bank", "error")
// 				return
// 			}
// 			}else if( paymode ==2 || paymode == 3 || paymode ==5){
// 			let card = document.getElementById("cardno_"+k).value
// 			if(card == 0){
// 				swal("Failed...!", "Please Enter card Number", "error")
// 			return
// 			}
// 		    }
// 			else if(paymode==4){
// 				let bank = document.getElementById('bank_'+k).value
// 				if(bank == '' || Number(bank)== 0){
// 					swal("Failed...!", "bank is empty", "error")
// 					return
// 				}
// 			}
// 			else if(paymode==6){
// 				let bank = document.getElementById('bank_'+k).value
// 				if(bank == '' || Number(bank)== 0){
// 					swal("Failed...!", "Select Room", "error")
// 					return
// 				}
// 			}
// 			else if(paymode != 0){
// 			document.getElementById("EXEC").disabled= false
// 			}
// 			else{
// 			document.getElementById("EXEC").disabled= true
// 			swal("Failed...!", "paymode is empty", "error")
// 			return
// 			}
// 		}

// 			i=i+1;
// 			var parow="<td id='bankoption_"+i+"'><select name='bank_"+i+"' class='m-ctrl' id='bank_"+i+"'><option value=''>--Bank--</option><?php $Res=$this->Myclass->Bank(); foreach($Res as $row) {   echo '<option value='.$row['Bankid'].' >'.$row['bank'].'</option>'; }	?>	</select></td>";
//             var paymode="<td><select  class='m-ctrl' onchange='paymodevalidate(this.value,i)' name='paymode_"+i+"' id='paymode_"+i+"' ><option value=''>--Paymode--</option> <?php $Res=$this->Myclass->PayMode(); foreach($Res as $row) { if($row['InActive'] ==0) {  echo '<option value='.$row['PayMode_Id'].'>'.$row['PayMode'].'</option>'; }} ?> </select></td>";
// 			var markup = "<tr><td><input type='text' class='m-ctrl' onchange = 'savee(this.value,i)' name='Amt_"+i+"' id='Amt_"+i+"' ></td>"+paymode+parow+"<td><input type='text' class='m-ctrl' value='' name='cardno_"+i+"' id='cardno_"+i+"'></td><td><input type='date' id='validate_"+i+"' value='<?php echo date('Y-m-d') ?>' class='m-ctrl'  name='validate_"+i+"' ></td><td><input type='checkbox' name='record'></td></tr>";
//             $("#row").append(markup);
//         });
        
//         // Find and remove selected table rows
//         $(".delete-row").click(function(){
// 			//i=i-1;
// 			//alert("veruthu");
//             $("table tbody").find('input[name="record"]').each(function(){
//                 if($(this).is(":checked")){
//                     $(this).parents("tr").remove();
// 					let rowCount = $(":checkbox:checked").length+1;
//                     i = i - rowCount

//                 }
//             });
//         });
//     });   


var i = 1;
$(document).ready(function () {

 $(".add-row").click(function(){
    $("#row").on("click", ".add-row", function () {
        addNewRow();
    });

    $("#row").on("click", ".delete-row", function () {
        $(this).closest("tr").remove();
        updateRowCount();
    });

    function updateRowCount() {
     
        i = $("#mytable tbody tr").length;
    }

    function addNewRow() {
        i++;

        var bankSelect = `<td id='bankoption_${i}'><select name='bank_${i}' class='m-ctrl' id='bank_${i}'>
                            <option value=''>--Bank--</option>
                            <?php $Res = $this->Myclass->Bank(); foreach($Res as $row) {
                                echo "<option value='{$row['Bankid']}'>{$row['bank']}</option>";
                            } ?>
                          </select></td>`;

        var paymodeSelect = `<td><select class='m-ctrl' onchange='paymodevalidate(this.value,${i})' name='paymode_${i}' id='paymode_${i}'>
                            <option value=''>--Paymode--</option>
                            <?php $Res = $this->Myclass->PayMode(); foreach($Res as $row) {
                          
                                if($row['InActive'] == 0 && $row['PayMode'] != 'CASH ON DELIVERY') {
                                    echo "<option value='{$row['PayMode']}'>{$row['PayMode']}</option>";
                                }
                            } ?>
                          </select></td>`;

                          

        var markup = `<tr>
                        <td><input type='text' class='m-ctrl' onchange='savee(this.value,${i})' name='Amt_${i}' id='Amt_${i}'></td>
                        ${paymodeSelect}
                        ${bankSelect}
                        <td><input type='text' class='m-ctrl' name='cardno_${i}' id='cardno_${i}'></td>
                        <td><input type='date' id='validate_${i}' min="<?php echo date('Y-m-d'); ?>"  value='<?php echo date('Y-m-d') ?>' class='m-ctrl' name='validate_${i}'></td>
                        <td>
                            <input type='button' class='add-row' value='+' />
                            <button type='button' class='delete-row'>x</button>
                        </td>
                      </tr>`;

        $("#row").append(markup);
    }
});
});


  var payid =0;
 function paymodevalidate(id,i)
 {  
	var totalamount = document.getElementById("totalbillamout").value;
    if(id=="UPI"){
 
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index ?>Transaction/UpiOptions",
		data:"id"+id,
		success: function (html){
			// console.log(i)
			$("#bank_"+i).html(html)
		}
	})
	  document.getElementById("cardno_"+i).disabled = true;
      document.getElementById("cardno_"+i).value='';
      document.getElementById("validate_"+i).disabled = true
	  document.getElementById("bank_"+i).disabled = false  
	
   } else if(id=="COMPANY"){
	if(Number(totalamount) < 0){
      swal("Failed...!", "Can't settle in company", "error")
      document.getElementById('paymode_'+i).value ="";
      document.getElementById('bank_'+i).value ="";
      return
    }
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index ?>Transaction/CompanyOptions",
		data:"id"+id,
		success: function (html) {
			$("#bank_"+i).html(html)
		}
	})
	  document.getElementById("bank_"+i).disabled = false 
	  document.getElementById("cardno_"+i).disabled = true;
	document.getElementById("validate_"+i).disabled = true;
   }
   else if(id == "CASH ON DELIVERY"){
    	  document.getElementById("cardno_"+i).disabled = true;
      document.getElementById("cardno_"+i).disabled = true;
      document.getElementById("validate_"+i).disabled = true;
	  document.getElementById("bank_"+i).disabled = true;  

   }
   else if(id=="CREDIT CARD" || id=="CHEQUE" || id=="NET TRANSFER"){
	if( id=="CREDIT CARD" && Number(totalamount) < 0){
      swal("Failed...!", "Can't settle in credit card", "error")
      document.getElementById('paymode_'+i).value ="";
      document.getElementById('bank_'+i).value ="";
      return
    }
      $.ajax({
        type:"POST",
        url:"<?php echo scs_index ?>Transaction/Otheroption",
        success: function (html) {
          $("#bank_"+i).html(html)
        }
      })
      document.getElementById("cardno_"+i).disabled = false;
      document.getElementById("validate_"+i).disabled = false ;
	  document.getElementById("bank_"+i).disabled = false ; 
    }
	else if(id == "TOROOM"){
		$.ajax({
			type:"POST",
			url :"<?php echo scs_index ?>Transaction/toroomSettle",
			success: function (html){
               $("#bank_"+i).html(html)
          }
		})
		document.getElementById("cardno_"+i).value='';
		document.getElementById("cardno_"+i).disabled = true
        document.getElementById("validate_"+i).disabled = true 
		document.getElementById("bank_"+i).disabled = false;	

	}
	else if(id=="CASH"){
	document.getElementById("bank_"+i).disabled = true;	
	document.getElementById("cardno_"+i).disabled = true;
	document.getElementById("validate_"+i).disabled = true;
	document.getElementById("bank_"+i).required = false;
	document.getElementById("cardno_"+i).required = false;
	document.getElementById("validate_"+i).required = false;   
      document.getElementById("bank_"+i).value = ''   
   }
 
 }	


 function savee(a,i){
    var totalamount = document.getElementById("totalbillamout").value;
    var amt_total = 0;
    for(let j=1 ; j<=i; j++){
      var amt = document.getElementById("Amt_"+j).value;
      amt_total= amt_total + Number(amt);
    }
    if(Number(totalamount) != Number(amt_total)){
      document.getElementById("EXEC").disabled= true
      document.getElementById("add").disabled= false
      if(Number(totalamount) < Number(amt_total)){
        document.getElementById("Amt_"+i).value=0
      }
    }
    else{
      document.getElementById("EXEC").disabled=false
      document.getElementById("add").disabled= true
    }
   
  }


  
$("#settlementsave").on('submit', function (e) {
		
       e.preventDefault();
	   var rowCount = $('#mytable tr').length;
	   for(let k=1; k<=rowCount-1; k++){
      	    let paymode = document.getElementById("paymode_"+k).value
    
			if(paymode == "COMPANY"){
			let bank=document.getElementById("bank_"+k).value;
			if(Number(bank == 0) || bank == ''){
				swal("Failed...!", "please select Bank", "error")
				return
			}
			}else if( paymode =="CREDIT CARD" || paymode == "CHEQUE" || paymode =="NET TRANSFER"){
			let card = document.getElementById("cardno_"+k).value
			let bank = document.getElementById('bank_'+k).value
			if(card == 0){
				swal("Failed...!", "Please Enter card Number", "error")
			return
			}

				if(Number(bank == 0) || bank == ''){
					swal("Failed...!", "bank is empty", "error")
					return
				}
		    }
			// else if(paymode=="COMPANY"){
			// 	let bank = document.getElementById('bank_'+k).value
			// 	if(Number(bank == 0) || bank == ''){
			// 		swal("Failed...!", "bank is empty", "error")
			// 		return
			// 	}
			// }
			else if(paymode=="UPI"){
				let bank = document.getElementById('bank_'+k).value
				if(Number(bank == 0) || bank == ''){
					swal("Failed...!", "Select Bank", "error")
					return
				}
			}
      	else if(paymode == "TOROOM"){
	let bank = document.getElementById('bank_'+k).value
				if(Number(bank == 0) || bank == ''){
					swal("Failed...!", "Room No is Empty", "error")
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
		
        
		document.getElementById("EXEC").disabled=true;
		document.getElementById("loaderimg").style.display="inline";
         $.ajax({
            type: 'get',
            url: "<?php echo scs_index ?>Transaction/groupSettlementsave?Roomid=<?php echo $roomCSV; ?>&ros="+i+"&grpid=<?php echo $grpid ?>",
            data: $('#settlementsave').serialize(),
            success: function (result) {

                // console.log(result);
               if(result == 'Amount Incorrect')
			   { 
				Swal.fire({
					icon: 'error',
					title: result,
					showConfirmButton: true,      
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					showConfirmButton: true, 
					cancelButtonText: "Ok"        
					})  
			    }
		       else
			   { 
				swal({
				  title: result,
				  //text: "Did you Need Print..!",
				  icon: "success",
				//  buttons: true,
				//  dangerMode: true,
				})
				.then((willDelete) => {				
					location.reload();				  
				}); 
                 				 
			   }
			  
			   }			
          });
          		   
        });
	
 </script>



<script>

$(document).ready(function(){
  var paymode = document.getElementById("paymode_1").value
  var company = document.getElementById("bank_1").value
  var payamount = document.getElementById("Amt_1").value
  var amount = document.getElementById("totalbillamout").value
  if(payamount == amount ){
    document.getElementById("EXEC").disabled= false
	if(paymode == 0 || company == 0 ){
		document.getElementById("EXEC").disabled= false
	}
  }else{
    document.getElementById("EXEC").disabled= true
  }
})
</script>
<script>
document.getElementById('cardno_1').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
 