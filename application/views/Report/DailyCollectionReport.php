<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','Daily Colection Report');
$this->pfrm->FrmHead6('Report / Daily Colection Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Collection Abstraction Report Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fff;
            color: #111;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 0.25rem;
        }
        p {
            text-align: center;
            margin-top: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #111;
        }
        th, td {
            /* border: 1px solid #111; */
            padding: 6px 8px;
            font-size: 0.85rem;
            text-align: center;
            white-space: nowrap;
        }
        th {
            background-color: #ededed;
            font-weight: 700;
        }
        .page-break {
            page-break-after: always;
            margin-bottom: 40px;
        }
        /* Scroll horizontal if needed */
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val">From Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['frmdate']){echo $_POST['frmdate']; }else { echo date('Y-m-d'); } ?>" id="frmdate" name="frmdate" max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val">To Date</td>
          <td align="left"><input type="date" value="<?php if(@$_POST['todate']){echo $_POST['todate']; }else { echo date('Y-m-d'); } ?>" id="todate" name="todate" max="<?php echo date('Y-m-d'); ?>"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
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
               echo $sql = "Select tmas.checkoutid,Tmas.CheckoutNo,Roomas.Roomno,tcmas.grcno,
isnull(SUM(Trans_Advancereceipt_mas.AMOUNT),0) AS 
ADVANCE,tcmas.Checkindate,tcmas.checkintime,tmas.Checkoutdate,tmas.checkouttime,
cust.customer_id,cty.city,isnull(tmas.totalamount,0) totalamount,
 isnull(tmas.discount,0) discount,tmas.roomgrcid ,case when isnull(tmas.cancelflag,0) = 0 then isnull(p.paymode,'') 
 else 'CANCEl' end as Paymode,pdet.amount as pamt,isnull(tmas.cancelflag,0) as cancel,tmas.groupcheckout,tmas.grpcheckoutbillid from Trans_checkout_det tdet 
 inner join Trans_checkout_mas tmas on tdet.Chkoutid = tmas.checkoutid 
 inner join Trans_checkin_mas tcmas on tcmas.grcid=tmas.grcid 
 LEFT OUTER JOIN Trans_Advancereceipt_mas ON TMAS.ROOMGRCID = Trans_Advancereceipt_mas.ROOMGRCID and Trans_Advancereceipt_mas.type='RMS' 
 inner join mas_revenue credithead on tdet.headid=credithead.revenue_id 
 inner join mas_room roomas on roomas.Room_Id=tmas.roomid 
 left outer join trans_pay_det pdet on pdet.checkoutid = tmas.checkoutid 
 left outer join mas_paymode p on p.paymode_id = pdet.paymodeid 
 left outer join mas_customer cust on tmas.customerid = cust.customer_id 
 left outer join mas_city cty on cust.cityid = cty.cityid Where tmas.checkoutdate between '".$_POST['frmdate']."' and '".$_POST['todate']."'
  and isnull(tmas.settle,0) = 1 group by tmas.checkoutid,Tmas.CheckoutNo,Roomas.Roomno,tcmas.grcno,tcmas.Checkindate, tmas.Checkoutdate,tmas.totalamount,tmas.discount,cust.customer_id,cty.city,tcmas.checkintime, tmas.checkouttime,tmas.roomgrcid ,p.paymode,pdet.amount,isnull(tmas.cancelflag,0),tmas.groupcheckout,tmas.grpcheckoutbillid order by tmas.checkoutid";
	
$exec = $this->db->query($sql);
foreach($exec->result_array() as $data) {  
    // print_r($data);
}


$sql2 = "  Select Sum(d.Amount) as Amount, (case when m.headcode = 'SBC' then 'SBC' when m.headcode = 'KKC' then 'KKC'  when m.headcode = 'CGST' then 'CGST' when m.headcode = 'SGST' then 'SGST'when m.headcode = 'ECGST' then 'ECGST'when m.headcode = 'ESGST' then 'ESGST' else M.revenuehead end) as Headname,isnull(M.isallowance,0) as isallow,m.headcode From trans_credit_entry d 
  Inner Join mas_revenue M on d.creditHeadid = M.revenue_id where roomgrcid = 5 group by M.revenuehead,isnull(M.isallowance,0),m.headcode 
";


?>


<h1>Hotel Kasis Inn</h1>
<p>91,25A, THILAGAR 2ND STREET BYE PASS ROAD, THIRUVARUR-610001</p>
<h2>Collection Abstraction Report</h2>
<p>During the period from <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> To <?php echo date('d-m-Y', strtotime($_POST['todate'])); ?></p>






 
 
<div class="table-wrapper">
<table aria-label="Collection Abstraction Report Table">
    <thead>
        <tr>
            <th>No</th>
            <th>ROOM</th>
            <th>ARR.DATE</th>
            <th>DEP.DATE</th>
            <th>TARIFF</th>
            <th>EB</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>SBC</th>
            <th>KKC</th>
            <th>FOOD</th>
            <th>TEL.</th>
            <th>MISC</th>
            <th>AMOUNT</th>
            <th>ADVANCE</th>
            <th>DISC</th>
            <th>ALLOW</th>
            <th>NET PAYMODE</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
     
      
    </tbody>
      <tfoot>
        <tr class="total">
            <td colspan="4">TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>
</div>

<div>

<!-- <h1>Hotel Kasis Inn</h1>
<h2>Check-In Advance Report</h2>
<p>During the period from 31/03/25</p> -->

<table aria-label="Check-In Advance Report Table">
    <thead>
        <tr>
            <th>No</th>
            <th>ROOM</th>
            <th>ARR.DATE</th>
            <th>RECEIPTNO</th>
            <th>ADVANCE</th>
            <th>NET</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    
    </tbody>
    <tfoot>
        <tr class="total">
            <td colspan="4">TOTAL</td>
            <td></td><td></td>
        </tr>
        <tr class="total">
            <td colspan="4">GRAND TOTAL</td>
            <td></td><td></td>
        </tr>
    </tfoot>
</table>
</div>

<div>

<h1>Hotel Kasis Inn</h1>
<h2>Additional Advance Report</h2>
<p>During the period from 31/03/25</p>

<table aria-label="Additional Advance Report Table">
    <thead>
        <tr>
            <th>No</th>
            <th>ROOM</th>
            <th>RECEIPTNO</th>
            <th>ADVANCE</th>
            <th>NET</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <tr class="total">
            <td colspan="3">TOTAL</td>
            <td></td><td></td>
        </tr>
        <tr class="total">
            <td colspan="3">GRAND TOTAL</td>
            <td></td><td></td>
        </tr>
    </tfoot>
</table>
</div>

	<?php
        }
		  ?>	
</body>
</html>



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
<SCRIPT language="javascript">
		function printDiv(a) {
			 var printContents = document.getElementById(a).innerHTML;
			 var originalContents = document.body.innerHTML;
			 document.body.innerHTML = printContents;
			 window.print();
			 document.body.innerHTML = originalContents;
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
              filename: "Cashier Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                    pdfMake.createPdf(docDefinition).download("CashierReport.pdf");
                }
            });
        });

		</script>