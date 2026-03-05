<?php 

$sql = "select isnull(comcheckoutoption, 0) as comcheckoutoption ,
isnull(comcheckoutoptioncashierreport,0) as comcheckoutoptioncashierreport ,
isnull(comreprintbill, 0) as comreprintbill,isnull(registrationcard, 0) as registrationcard
from  usertable where User_id='".$UGID."'";
$exe = $this->db->query($sql);
foreach($exe->result_array() as $row){
    $walkoutOption = $row['comcheckoutoption'];
    $walkoutReport = $row['comcheckoutoptioncashierreport'];
    $walkoutReprint = $row['comreprintbill'];
    $registrationcard = $row['registrationcard'];
}
?>


<style>

	.not-active{
		display:none;
	}
	.is-active{
		display :block;
	}
	.tab-bar{
		/* background-color:#0057b7; */
		padding:6px;
	}
	.tab-bar > a{
		color:black;
		margin-right:10px;
	}
	.tab-active{
		border-bottom:1px solid black;
		}
	#tab-head{
		background-color:#A9A9A9;
	}
	.textColor{
		color:white;
	}

</style>

</div>

<div id ="printing" class="col-sm-12 " style="padding-left: 0px !important; padding-right:0px;">
	<div class = "tab-bar">
			<!-- <a href = "#tab1-panel" class="tab-active" id="gst" onClick="Report();">User Settings</a> -->
	</div>
	<!-- <button id="exporttable">click</button> -->
    <input type="hidden" id="ugid" value="<?php echo $UGID; ?>" />
    <div id="tab1-panel" class ="is-active table-responsive" style="color:black;">
	    <div>
        	<input  type="checkbox" id="walkoutOption" value="1" <?php if($walkoutOption == 1){ echo "checked";} ?> onclick=()> Complementary Checkout Option
        </div>
		<div>
			<input  type="checkbox" id="walkoutReport" value="1" <?php if($walkoutReport == 1){ echo "checked";} ?>> Complementary Checkout Bill In Cashier Report
        </div>

        <div>
			<input  type="checkbox" id="walkoutReprint" value="1" <?php if($walkoutReprint == 1){ echo "checked";} ?>> Complementary Checkout Bill Reprint
        </div>

        <div>
			<input  type="checkbox" id="registrationcard" value="1" <?php if($registrationcard == 1){ echo "checked";} ?>> Registration Card print & Reprint
        </div>

	</div>
    
</div>


<script>
    let a = document.getElementById("walkoutOption")
    let b = document.getElementById("walkoutReport")
    let c = document.getElementById("walkoutReprint")
    let d = document.getElementById("registrationcard")

a.addEventListener("click", () =>{
    if(a.checked == true){
        // alert("yes")
        $.ajax({		
              type:"POST",
              url:"<?php echo scs_index;?>Setting/UserwalkoutOption_save?id="+$('#ugid').val(),
              success: function(html)
              {            } 
            });
    } else{
        $.ajax({		
              type:"POST",
              url:"<?php echo scs_index;?>Setting/UserwalkoutOptionE_save?id="+$('#ugid').val(),
              success: function(html)
              {            } 
            });
    }

})

b.addEventListener("click", () =>{

	if(b.checked == true){
        // alert("yes")
        $.ajax({		
              type:"POST",
              url:"<?php echo scs_index;?>Setting/UserwalkoutReport_save?id="+$('#ugid').val(),
              success: function(html)
              {            } 
            });
    } else{
        $.ajax({		
              type:"POST",
              url:"<?php echo scs_index;?>Setting/UserwalkoutReportE_save?id="+$('#ugid').val(),
              success: function(html)
              {            } 
            });
    }
})

c.addEventListener("click", () =>{

if(c.checked == true){
    // alert("yes")
    $.ajax({		
          type:"POST",
          url:"<?php echo scs_index;?>Setting/UserwalkoutReprint_save?id="+$('#ugid').val(),
          success: function(html)
          {            } 
        });
} else{
    $.ajax({		
          type:"POST",
          url:"<?php echo scs_index;?>Setting/UserwalkoutReprintE_save?id="+$('#ugid').val(),
          success: function(html)
          {            } 
        });
}
})

d.addEventListener("click", () =>{
if(d.checked == true){
    // alert("yes")
    $.ajax({		
          type:"POST",
          url:"<?php echo scs_index;?>Setting/registrationcard_save?id="+$('#ugid').val(),
          success: function(html)
          {            } 
        });
} else{
    $.ajax({		
          type:"POST",
          url:"<?php echo scs_index;?>Setting/registrationcardE_save?id="+$('#ugid').val(),
          success: function(html)
          {            } 
        });
}
})
</script>