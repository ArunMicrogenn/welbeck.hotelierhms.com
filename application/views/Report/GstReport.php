
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','GST I Report');
$this->pfrm->FrmHead6('Report / GST I Report',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
<style>

	.not-active{
		display:none;
	}
	.is-active{
		display :block;
	}
	.tab-bar{
		background-color:#0057b7;
		padding:6px;
	}
	.tab-bar > a{
		color:white;
		margin-right:10px;
	}
	.tab-active{
		border-bottom:1px solid white;
		}
	#tab-head{
		background-color:#A9A9A9;
	}
	.textColor{
		color:white;
	}

   
</style>
<?php  	date_default_timezone_set('Asia/Kolkata');  ?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
	<form action="" method="POST">
      	<table class="FrmTable T-6" >
        <tr>
          <td align="right" class="F_val textColor">From Date</td>
          <td align="left" style="color:black;"><input type="date" value="<?php echo date('Y-m-d'); ?>" id="frmdate" name="frmdate"   max="<?php echo date('Y-m-d'); ?>"  class="scs-ctrl " />
            <div class="Type" ></div></td>
            <td align="right" class="F_val textColor">To Date</td>
          <td align="left" style="color:black;"><input type="date" max="<?php echo date('Y-m-d'); ?>" id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>"   class="scs-ctrl " />
            <div class="Type" ></div></td>        
		   <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
        </tr>
      	</table>
	   </form>
    </fieldset>
  </div>

</div>

<div id ="printing" class="col-sm-12 " style="padding-left: 0px !important; padding-right:0px;">
	<div class = "tab-bar">
			<a href = "#tab1-panel" class="tab-active" id="gst" onClick="gst();">All</a>
			<a href = "#tab2-panel"   class="" id="b2b" onClick="b2b();" >B2B Report</a>
			<a href = "#tab3-panel"   class="" id="b2cs" onClick="b2cs();" >B2CS Report</a>

	</div>
	<!-- <button id="exporttable">click</button> -->
    <div id="tab1-panel" class ="is-active table-responsive" style="color:black;">
			
        <table class="table table-bordered table-hover " id="excelexport">  

		   <?php 
			if(@$_POST['submit'])
			{
				$fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
				$todate = date('Y-m-d', strtotime($_POST['todate']));
			}
			else{
				$fromdate = date('Y-m-d');
				$todate = date('Y-m-d');
			}
		 ?>

		    <div>
				<h4 class="text-center">GST I Report  <?php echo date('d-m-Y', strtotime($fromdate)); ?> To <?php echo date('d-m-Y', strtotime($todate)); ?><h4>
		    </div> 

		   <tbody>
		    <?php
			 
	        $qry=" exec Gst_I_report '".$fromdate."', '".$todate."'";
			 $exec=$this->db->query($qry); 
			 $advance= $exec->num_rows();
			 $count = 1;
			 $totalinv=0;
			 $totalTax=0;
			 $totaltaxamt=0;
			  if($advance !=0)
			  {
				echo '<tr id="tab-head" style="background-color:#c9c6c6;">';	
				echo '<td  style="text-align: center;">S.No</td>';	 
				echo '<td  style="text-align: center;">Name of Recipient</td>';	 
				echo '<td  style="text-align: center;">Invoice No</td>';	 
				echo '<td  style="text-align: center;">Inv.Date</td>';
				echo '<td  style="text-align: center;">Inv.Value</td>';
				echo '<td style="text-align: center;">Place of Supply</td>';
				echo '<td style="text-align: center;">Reverse Charge</td>';
				echo '<td style="text-align: center;">Applicable % of Tax Rate </td>';
				echo '<td style="text-align: center;">Invoice Type</td>';
				echo '<td style="text-align: center;">E-commerce GSTIN</td>';
				echo '<td style="text-align: center;">Rate</td>';
				echo '<td style="text-align: center;">Taxable Value</td>';
				echo '<td style="text-align: center;">Tax Amount</td>';
				echo '<td style="text-align: center;">Cess value</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {		
				$totalinv = $totalinv + $rows['CGST'] + $rows['SGST']+$rows['taxableAmount'];
				$totalTax = $totalTax + $rows['taxableAmount'];
				$totaltaxamt = $totaltaxamt + $rows['CGST'] + $rows['SGST'];
				echo '<tr>';	
				echo '<td style="text-align: right;">'.$count++.'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].' '.$rows['Lastname'].'</td>';
				echo '<td style="text-align: center;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';	 
				echo '<td  style="text-align: center;">'.date('d-m-Y',strtotime($rows['inovicedate'])).'</td>';
				echo '<td  style="text-align: right;">'.number_format((float)($rows['CGST'] + $rows['SGST']+$rows['taxableAmount']),2,'.','').'</td>';
				echo '<td style="text-align: center;">Tamil Nadu</td>';
				echo '<td style="text-align: left;">N</td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;">REGULAR</td>';
				echo '<td style="text-align: center;">'.$rows['Gstno'].'</td>';
				echo '<td style="text-align: right;">12</td>';
				echo '<td style="text-align: right;">'.$rows['taxableAmount'].'</td>';
				echo '<td style="text-align: right;">'.number_format((float)($rows['CGST']+$rows['SGST']),2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';				
			  }	

		   ?>		   
		   </tbody>
		   <tfoot>
			<?php 
		   if($advance !=0){

		   

		   echo '<tr>';	
				echo '<td style="text-align: center;"  class="text-bold" colspan="4">Total</td>';
				echo '<td  style="text-align: right;">'.number_format($totalinv,2,'.','').'</td>';
				echo '<td style="text-align: center;" colspan="6"></td>';
				echo '<td style="text-align: right;">'.number_format($totalTax,2,'.','').'</td>';
				echo '<td style="text-align: right;">'.number_format($totaltaxamt,2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';	
		   }
		   ?>
		   </tfoot>
		 </table>	
	</div>
    <div id="tab2-panel"   class = "not-active table-responsive"  style="color:black;"> 
	        <div>
				<h3 class="text-center">GST B2B Report  <?php echo date('d-m-Y', strtotime($fromdate)); ?> To <?php echo date('d-m-Y', strtotime($todate)); ?><h3>
		    </div> 

		<table class="table table-bordered table-hover" id="B2B">         
		   <tbody>
		    <?php 
	         $qry=" exec Gst_B2B '".$fromdate."', '".$todate."'";
			 $exec=$this->db->query($qry); 
			 $advance= $exec->num_rows();
			 $count = 1;
			 $totalinvb=0;
			 $totalTaxb=0;
			 $totaltaxamtb=0;
			  if($advance !=0)
			  {
				echo '<tr id="tab-head" style="background-color:#c9c6c6;">';	
				echo '<td  style="text-align: center;">S.No</td>';	 
				echo '<td  style="text-align: center;">Name of Recipient</td>';	 
				echo '<td  style="text-align: center;">Invoice No</td>';	 
				echo '<td  style="text-align: center;">Inv.Date</td>';
				echo '<td  style="text-align: center;">Inv.Value</td>';
				echo '<td style="text-align: center;">Place of Supply</td>';
				echo '<td style="text-align: center;">Reverse Charge</td>';
				echo '<td style="text-align: center;">Applicable % of Tax Rate </td>';
				echo '<td style="text-align: center;">Invoice Type</td>';
				echo '<td style="text-align: center;">E-commerce GSTIN</td>';
				echo '<td style="text-align: center;">Rate</td>';
				echo '<td style="text-align: center;">Taxable Value</td>';
				echo '<td style="text-align: center;">Tax Amount</td>';
				echo '<td style="text-align: center;">Cess value</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {		
				$totalinvb = $totalinvb + $rows['CGST'] + $rows['SGST']+$rows['taxableAmount'];
				$totalTaxb = $totalTaxb + $rows['taxableAmount'];
				$totaltaxamtb = $totaltaxamtb + $rows['CGST'] + $rows['SGST'];		
				echo '<tr>';	
				echo '<td style="text-align: right;">'.$count++.'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].' '.$rows['Lastname'].'</td>';
				echo '<td style="text-align: center;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';	 
				echo '<td  style="text-align: center;">'.date('d-m-Y',strtotime($rows['inovicedate'])).'</td>';
				echo '<td  style="text-align: right;">'.number_format((float)($rows['CGST'] + $rows['SGST']+$rows['taxableAmount']),2,'.','').'</td>';
				echo '<td style="text-align: center;">Tamil Nadu</td>';
				echo '<td style="text-align: left;">N</td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;">REGULAR</td>';
				echo '<td style="text-align: center;">'.$rows['Gstno'].'</td>';
				echo '<td style="text-align: right;">12</td>';
				echo '<td style="text-align: right;">'.$rows['taxableAmount'].'</td>';
				echo '<td style="text-align: right;">'.number_format((float)($rows['CGST']+$rows['SGST']),2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';				
			  }			 
		   ?>		   
		   </tbody>

		   <tfoot>
			<?php 
		   if($advance !=0){
				echo '<tr>';	
				echo '<td style="text-align: center;"  class="text-bold" colspan="4">Total</td>';
				echo '<td  style="text-align: right;">'.number_format($totalinvb,2,'.','').'</td>';
				echo '<td style="text-align: center;" colspan="6"></td>';
				echo '<td style="text-align: right;">'.number_format($totalTaxb,2,'.','').'</td>';
				echo '<td style="text-align: right;">'.number_format($totaltaxamtb,2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';		
		   }
		   ?>
		   </tfoot>
		</table>	
    </div>

	<div id="tab3-panel"   class = "not-active table-responsive" style="color:black;"> 

		<table class="table table-bordered table-hover" id="B2CS" >  
		   <div>
				<h3 class="text-center">GST B2CS Report  <?php echo date('d-m-Y', strtotime($fromdate)); ?> To <?php echo date('d-m-Y', strtotime($todate)); ?><h3>
		    </div>        
		   <tbody>
		    <?php 
			
	         $qry=" exec Gst_B2CS '".$fromdate."', '".$todate."'";
			 $exec=$this->db->query($qry); 
			 $advance= $exec->num_rows();
			 $count = 1;
			 $totalinvc=0;
			 $totalTaxc=0;
			 $totaltaxamtc=0;
			  if($advance !=0)
			  {
				echo '<tr id="tab-head" style="background-color:#c9c6c6;">';	
				echo '<td  style="text-align: center;">S.No</td>';	 
				echo '<td  style="text-align: center;">Name of Recipient</td>';	 
				echo '<td  style="text-align: center;">Invoice No</td>';	 
				echo '<td  style="text-align: center;">Inv.Date</td>';
				echo '<td  style="text-align: center;">Inv.Value</td>';
				echo '<td style="text-align: center;">Place of Supply</td>';
				echo '<td style="text-align: center;">Reverse Charge</td>';
				echo '<td style="text-align: center;">Applicable % of Tax Rate </td>';
				echo '<td style="text-align: center;">Invoice Type</td>';
				echo '<td style="text-align: center;">E-commerce GSTIN</td>';
				echo '<td style="text-align: center;">Rate</td>';
				echo '<td style="text-align: center;">Taxable Value</td>';
				echo '<td style="text-align: center;">Tax Amount</td>';
				echo '<td style="text-align: center;">Cess value</td>';
				echo '</tr>';			
			  }			 
			  foreach ($exec->result_array() as $rows)
			  {	

				$totalinvc = $totalinvc + $rows['CGST'] + $rows['SGST']+$rows['taxableAmount'];
				$totalTaxc = $totalTaxc + $rows['taxableAmount'];
				$totaltaxamtc = $totaltaxamtc + $rows['CGST'] + $rows['SGST'];				
				echo '<tr>';	
				echo '<td style="text-align: right;">'.$count++.'</td>';
				echo '<td style="text-align: left;">'.$rows['Title'].'.'.$rows['Firstname'].' '.$rows['Lastname'].'</td>';
				echo '<td style="text-align: center;">'.$rows['yearPrefix'].'/'.$rows['Checkoutno'].'</td>';	 
				echo '<td  style="text-align: center;">'.date('d-m-Y',strtotime($rows['inovicedate'])).'</td>';
				echo '<td  style="text-align: right;">'.number_format((float)($rows['CGST'] + $rows['SGST']+$rows['taxableAmount']),2,'.','').'</td>';
				echo '<td style="text-align: center;">Tamil Nadu</td>';
				echo '<td style="text-align: left;">N</td>';
				echo '<td style="text-align: left;"></td>';				
				echo '<td style="text-align: center;">REGULAR</td>';
				echo '<td style="text-align: center;">'.$rows['Gstno'].'</td>';
				echo '<td style="text-align: right;">12</td>';
				echo '<td style="text-align: right;">'.$rows['taxableAmount'].'</td>';
				echo '<td style="text-align: right;">'.number_format((float)($rows['CGST']+$rows['SGST']),2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';				
			  }			 
		   ?>		   
		   </tbody>
		   <tfoot>
			<?php 
		   if($advance !=0){

				echo '<tr>';	
				echo '<td style="text-align: center;"  class="text-bold" colspan="4">Total</td>';
				echo '<td  style="text-align: right;">'.number_format($totalinvc,2,'.','').'</td>';
				echo '<td style="text-align: center;" colspan="6"></td>';
				echo '<td style="text-align: right;">'.number_format($totalTaxc,2,'.','').'</td>';
				echo '<td style="text-align: right;">'.number_format($totaltaxamtc,2,'.','').'</td>';
				echo '<td style="text-align: left;"></td>';
				echo '</tr>';	
		   }
		   ?>
		   </tfoot>
		</table>	
    </div>
</div>


<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<script>
    const gst = () =>{
		document.getElementById('gst').classList.add('tab-active');
		document.getElementById('b2b').classList.remove('tab-active');
		document.getElementById('b2cs').classList.remove('tab-active');
		let ele = document.getElementById("tab1-panel");
		let ele1 = document.getElementById('tab2-panel');
		let el = document.getElementById("tab3-panel");
		ele.classList.remove('not-active');
		ele.classList.add('is-active')
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
		el.classList.remove('is-active');
		el.classList.add('not-active');
	}
    const b2b = () =>{
		document.getElementById('b2b').classList.add('tab-active');
		document.getElementById('gst').classList.remove('tab-active');
		document.getElementById('b2cs').classList.remove('tab-active');
		let ele = document.getElementById("tab2-panel");
		let ele1 = document.getElementById('tab1-panel');
		let el = document.getElementById("tab3-panel");
		ele.classList.remove('not-active');
		ele.classList.add('is-active')
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
		el.classList.remove('is-active');
		el.classList.add('not-active');
		
	}

	const b2cs = () =>{
		document.getElementById('b2cs').classList.add('tab-active');
		document.getElementById('b2b').classList.remove('tab-active');
		document.getElementById('gst').classList.remove('tab-active');
		let el = document.getElementById("tab3-panel");
		let ele = document.getElementById("tab2-panel");
		let ele1 = document.getElementById('tab1-panel');
		el.classList.remove('not-active');
		el.classList.add('is-active');
		ele.classList.remove('is-active');
		ele.classList.add('not-active');
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
	}
</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<script>
    const gst = () =>{
		document.getElementById('gst').classList.add('tab-active');
		document.getElementById('b2b').classList.remove('tab-active');
		document.getElementById('b2cs').classList.remove('tab-active');
		let ele = document.getElementById("tab1-panel");
		let ele1 = document.getElementById('tab2-panel');
		let el = document.getElementById("tab3-panel");
		ele.classList.remove('not-active');
		ele.classList.add('is-active')
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
		el.classList.remove('is-active');
		el.classList.add('not-active');
	}
    const b2b = () =>{
		document.getElementById('b2b').classList.add('tab-active');
		document.getElementById('gst').classList.remove('tab-active');
		document.getElementById('b2cs').classList.remove('tab-active');
		let ele = document.getElementById("tab2-panel");
		let ele1 = document.getElementById('tab1-panel');
		let el = document.getElementById("tab3-panel");
		ele.classList.remove('not-active');
		ele.classList.add('is-active')
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
		el.classList.remove('is-active');
		el.classList.add('not-active');
		
	}

	const b2cs = () =>{
		document.getElementById('b2cs').classList.add('tab-active');
		document.getElementById('b2b').classList.remove('tab-active');
		document.getElementById('gst').classList.remove('tab-active');
		let el = document.getElementById("tab3-panel");
		let ele = document.getElementById("tab2-panel");
		let ele1 = document.getElementById('tab1-panel');
		el.classList.remove('not-active');
		el.classList.add('is-active');
		ele.classList.remove('is-active');
		ele.classList.add('not-active');
		ele1.classList.remove('is-active');
		ele1.classList.add('not-active');
	} 
</script>

<SCRIPT language="javascript">
		$(function() {
        $("#exporttable").click(function(e)
		{
          var table = $("#excelexport");
		  var tableb2b = $("#B2B");
		  var tableb2cs = $("#B2CS");
          if(table && table.length)
		  {
            $(table).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "GST-I-Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true,
              preserveColors: false
            });
          }
		  
          if(tableb2b && tableb2b.length){
            $(tableb2b).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "GST-I-ReportB2B" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
              fileext: ".xls",
              exclude_img: true,
              exclude_links: true,
              exclude_inputs: true,
              preserveColors: false
            });
          }
       
		
          if(tableb2cs && tableb2cs.length){
            $(tableb2cs).table2excel({
              exclude: ".noExl",
              name: "Excel Document Name",
              filename: "GST-I-ReportBCS" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
            html2canvas($('#excelexport')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("GST-I-Report.pdf");
                }
            });
			
			html2canvas($('#B2B')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("GST-I-ReportB2B.pdf");
                }
            });

			html2canvas($('#B2CS')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("GST-I-ReportBCS.pdf");
                }
            });

        });

	  
	</SCRIPT>