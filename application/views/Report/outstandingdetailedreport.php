<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Outstanding Detailed Report');
$this->pfrm->FrmHead6('Report / Outstanding Detailed Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>

    


<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST" id="myForm">
      	<table class="FrmTable T-6" >
        <tr>  
          <!-- <td align="right" class="F_val">Date</td> -->
          <td align="left">
          <?php
$selectedOption = isset($_POST['option']) ? $_POST['option'] : '';
$pendingChecked = isset($_POST['pending']) ? true : false;
?>

<div style="display:flex; flex-direction:row;gap:20px;">

<label>
    <input type="radio" name="option" id="opt" value="1" <?php echo ($selectedOption == '1') ? 'checked' : ''; ?> />
    All
</label><br>

<label>
    <input type="radio" id="particular" name="option" value="2" <?php echo ($selectedOption == '2') ? 'checked' : ''; ?> />
    Particular
</label>
</div>

<!-- <label id="pending" style="display:none">
    <input type="checkbox" name="pending" value="1" <php echo ($pendingChecked) ? 'checked' : ''; ?> />
    Pending
</label> -->
<?php $com = "select * from mas_company"; $comqry = $this->db->query($com)->result_array(); ?>
<div id="company-wrapper">
<select name="company" id="company" class="scs-ctrl" style="width:200px;">
    <option value="">--select--</option>
    <?php 
    $selectedCompany = isset($_POST['company']) ? $_POST['company'] : '';
    foreach($comqry as $comp) { 
        $selected = ($selectedCompany == $comp['Company_Id']) ? 'selected' : '';
    ?>
        <option value="<?php echo $comp['Company_Id']; ?>" <?php echo $selected; ?>>
            <?php echo $comp['Company']; ?>
        </option>
    <?php } ?>
</select>
</div>

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



<div id="printing" class="col-sm-12">
  <?php
    if(@$_POST['submit'])
		{
			?>



</div>


       
        <div>
				<h4 class="text-center">Outstanding Detailed Report<h4>
		    </div>        
		<table class="table table-bordered table-hover" id="out">  
    <thead>
       
        <tr style="background-color:#c9c6c6;">		 
            <th style="text-align: center;">S.no</th>
            <th style="text-align: center;">Company</th>
            <th style="text-align: center;">Customer Name</th>
            <th style="text-align: center;">Room No</th>
            <th style="text-align: center;">Checkin Date </th>
            <th style="text-align: center;">Checkout Date </th>
            <th style="text-align: center;">Bill No</th>
            <th style="text-align: center;">Bill Amount</th>
            <th style="text-align: center;">Received  Amount</th>
            <th style="text-align: center;">Balance Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php


         if(isset($_POST['pending']) && isset($_POST['option'])) {
            if($_POST['option'] == 1 && $_POST['pending'] == 1) {
          
                $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
                from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
                 inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
                inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid  
                inner join mas_title mt on cu.Titelid = mt.titleid  
                 inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
                 left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
                  where (isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) >1  and  isnull(tcm.cancelflag,0)=0   
                  /*and tod.balance > 0*/  order by co.company asc";
    
     
            } 
            
         }
         if(isset($_POST['option'])) {
          if($_POST['option'] == 1 && !isset($_POST['pending'])){
                $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
                from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
                 inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
                inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid   
                inner join mas_title mt on cu.Titelid = mt.titleid   
                 inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
                 left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
                  where isnull(tcm.cancelflag,0)=0   
                    order by co.company asc";
            }
        }
   
        if(isset($_POST['pending']) && isset($_POST['option'])) {

         if($_POST['option'] == 2 && $_POST['pending'] == 1){
            $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
            from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
             inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
            inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid   
            inner join mas_title mt on cu.Titelid = mt.titleid   
             inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
             left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
              where (isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) >1  and  isnull(tcm.cancelflag,0)=0   
              /*and tod.balance > 0*/  order by co.company asc";
         } else if($_POST['option'] == 2 && $_POST['pending'] == 1){
            $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
            from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
             inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
            inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid 
            inner join mas_title mt on cu.Titelid = mt.titleid     
             inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
             left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
              where isnull(tcm.cancelflag,0)=0   
                order by co.company asc";
         }

         if ($_POST['option'] == 2 && !isset($_POST['pending'])) {
            echo '<script>alert("Please select any one Checkbox.");</script>';
            exit;
        }
        
        }

        if(isset($_POST['option']) && isset($_POST['company'])){
            if($_POST['option'] == 2)
            $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
            from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
             inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
            inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid   
            inner join mas_title mt on cu.Titelid = mt.titleid   
             inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
             left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
              where isnull(tcm.cancelflag,0)=0  and co.company_id = '".$_POST['company']."' 
                order by co.company asc";
        }


  if(isset($_POST['option']) && isset($_POST['company']) && isset($_POST['pending'])){
    if($_POST['option'] == 2 &&  $_POST['pending'] == 1 && isset($_POST['company'])){
        $qry ="	select tcm.checkoutno,tcm.Checkoutdate,tcm.checkouttime,co.company,mt.Title,cu.Firstname,cu.mobile,tpd.amount,rm.roomno,tpd.paidamount,tcim.checkintime,tcim.checkindate,ota.onlinebookingno ,cu.HomeAddress1 , city.city,(isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) as balance
        from trans_pay_Det tpd   inner join trans_checkout_mas tcm on tcm.checkoutid = tpd.checkoutid  
         inner join mas_paymode pm on pm.paymode_id = tpd.paymodeid   
        inner join mas_company co on co.company_id=tpd.bankid inner join mas_customer cu on cu.customer_id=tcm.customerid
        inner join mas_title mt on cu.Titelid = mt.titleid      
         inner join mas_room rm on rm.room_id = tcm.roomid inner join trans_Checkin_mas tcim on tcim.grcid=tcm.grcid   
         left outer join trans_otadetails ota on ota.roomgrcid = tcm.roomgrcid left outer join mas_city city on city.Cityid = cu.Cityid      
          where (isnull(tpd.amount,0)-isnull(tpd.paidamount,0)) >1  and  isnull(tcm.cancelflag,0)=0  and co.company_id = '".$_POST['company']."' 
          /*and tod.balance > 0*/  order by co.company asc";



    }
   

  }

    
                 $exec=$this->db->query($qry);
        

               
        $i = 1;
        foreach ($exec->result_array() as $rows) {
            echo '<tr>';
            echo '<td style="text-align: center;">'.$i++.'</td>';
        
            echo '<td style="display:none;">'.$rows['company'].'</td>';
        
            echo '<td style="text-align: left;">'.$rows['Title']." ".$rows['Firstname'].'</td>';
            echo '<td style="text-align: center;">'.$rows['roomno'].'</td>';
            echo '<td style="text-align: center;">'.date('d-m-Y', strtotime($rows['checkindate'])).'</td>';
            echo '<td style="text-align: center;">'.date('d-m-Y', strtotime($rows['Checkoutdate'])).'</td>';
            echo '<td style="text-align: center;">'.$rows['checkoutno'].'</td>';
            echo '<td style="text-align: right;">'.number_format($rows['amount'],2).'</td>';
            echo '<td style="text-align: right;">'.number_format($rows['paidamount'],2).'</td>';
            echo '<td style="text-align: right;">'.number_format($rows['balance'],2).'</td>';
            echo '</tr>';
        }
        
        ?>
    </tbody>
</table>
     <?php
    }
     ?>


	</div>
	<?php 
  
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <SCRIPT language="javascript">
		function printDiv(a) {
			 var printContents = document.getElementById(a).innerHTML;
			 var originalContents = document.body.innerHTML;
			 document.body.innerHTML = printContents;
			 window.print();
			 document.body.innerHTML = originalContents;
		}
       function fromdatevalidate()
	   {
		 var a= document.getElementsByName("dateFrom")[0].value;
		 alert(a);
	   }
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
			
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}
		$(function() {
        $("#exporttable").click(function(e)
		{

          var table = $("#printing");
          if(table && table.length)
		  {
            $(table).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "Outstanding Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true,
              preserveColors: false
            });
          } 
		});
      });

        $("body").on("click", "#exportpdf", function () {
            html2canvas($('#printing')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Outstanding Report.pdf");
                }
            });
        });
	</SCRIPT>
<script>
$(document).ready(function() {
    var table = $('#out').DataTable({
        "pageLength": 25,
        "order": [[2, 'asc']], 
        "columnDefs": [
            { "visible": false, "targets": 1 }
        ],
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var lastCompany = null;
            var companyRows = [];

            api.column(1, { page: 'current' }).data().each(function(company, i) {
           
                if (company !== lastCompany && company !== "") {
                    $(rows).eq(i).before(
                        '<tr class="group bg-info" style="font-weight:bold;">' +
                        '<td colspan="10">Company: ' + company + '</td>' +
                        '</tr>'
                    );
                    lastCompany = company;

               
                    companyRows = [];
                }
                companyRows.push(i);

               
                var nextCompany = api.column(1, { page: 'current' }).data()[i+1];
                if (nextCompany !== company || i === api.column(1, { page: 'current' }).data().length - 1) {
                 
                    var totalBalance = 0;
                    companyRows.forEach(function(idx) {
                        var balance = parseFloat(api.row(idx).data()[9].toString().replace(/,/g, '')) || 0;
                        totalBalance += balance;
                    });
                   
                    $(rows).eq(companyRows[companyRows.length - 1]).after(
                        '<tr class="group bg-warning" style="font-weight:bold;">' +
                        '<td colspan="7" style="text-align:left;"></td>' +
                        '<td colspan="1" style="text-align:right;">Total </td>' +
                        '<td style="text-align:right;">' + totalBalance.toFixed(2) + '</td>' +
                        '</tr>'
                    );
                }
            });
        }
    });
});



</script>


<!-- <script>
    $(document).ready(function() {
        $('#out').DataTable();
    });
</script> -->



<script>
$(document).ready(function () {
  
    $('#pending').hide();
    $('#company-wrapper').hide();

  
    const selectedOption = $('input[name="option"]:checked').val();
    if (selectedOption) {
        $('#pending').show(); 
        if (selectedOption === '2') {
            $('#company-wrapper').show(); 
        }
    }


    $('input[name="option"]').on('change', function () {
        $('#pending').show(); 
        if ($(this).val() === '2') {
            $('#company-wrapper').show();
        } else {
            $('#company-wrapper').hide();
        }
    });
});
</script>


<script>
      window.addEventListener("DOMContentLoaded", function() {
    document.getElementById("opt").checked = true;
  });
</script>
