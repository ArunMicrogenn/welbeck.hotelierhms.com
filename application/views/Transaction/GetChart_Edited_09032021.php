<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
  
<style>
.May,.July {  
background-color:#FDEAEB !important;
}
.SelClo
{
	background-color:#FBEC8D !important;
}
.RoomType_Id
{
	background-color:#E5E5E5 !important;
}
</style>

<div class="the-box D_ISS"  >
  <table class="intable">
    <thead>
    
    <tr  >
        <td style="background-color:#0b6900 !important;color:#ffffff !important;float:left"><div align="left">&nbsp;<strong>Occpancy %</strong></div></td>
        <?php
		$query="select * from Mas_Room";
		$res=$this->db->query($query);
		$norow= $res->num_rows();
		$query1=" select * from Room_Status where isnull(Status,'')='Y'";
		$res1=$this->db->query($query1);
		$norow1= $res1->num_rows();
		$occper=($norow1/$norow)*100;
		for($i=1;$i<=20;$i++)
		{
             echo '<td style="background-color:#0b6900 !important;color:#ffffff !important;height:25px;width:55px" >0</td>';
		}
		?>
      </tr>
      
      <tr>
        <td style="background-color:#95FF9A !important;float:left" ><div align="left">&nbsp;<strong>Position</strong></div></td>
        <?php
		for($i=1;$i<=20;$i++)
		{
             echo '<td style="height:25px;width:55px;background-color:#95FF9A !important" >0</td>';
		}
		?>
      </tr>
    
     <tr>
        <td style="background-color:#FF9595 !important;float:left"><div align="left">&nbsp;<strong>Blocked</strong></div></td>
        <?php
		for($i=1;$i<=20;$i++)
		{
             echo '<td style="height:25px;width:55px;background-color:#FF9595 !important" >0</td>';
		}
		?>
      </tr>
      
      <tr>
        <td> </td>
        <?php
		$name='';$Year='';
		for($i=0;$i<20;$i++)
		{
			if(date('F', strtotime($_POST['RDAT']. ' + '.$i.' days'))!=$name)
			{
				$name=date('F', strtotime($_POST['RDAT']. ' + '.$i.' days'));
				$Year=date('Y', strtotime($_POST['RDAT']. ' + '.$i.' days'));
				//$Year='';
				echo '<td colspan="4" class="'.$name.'"   ><strong style="font-size:15px" >'.$name.'-'.$Year.'</strong>
			  </td>';
			  $i=$i+3;
			}
			else
			{
				echo '<td  class="'.$name.'"   > 
			  </td>';
			}
             
		}
		?>
      </tr>
      
      <tr>
        <td><div align="left">&nbsp;<strong>RoomNo</strong></div></td>
        <?php
		$Fday=date('d', strtotime($_POST['RDAT']. ' + 0 days'));
		
		for($i=0;$i<20;$i++)
		{
             echo '<td style="height:55px;width:55px" class="A'.date('F', strtotime($_POST['RDAT']. ' + '.$i.' days')).'" >'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).'<br>
			 '.date('D', strtotime($_POST['RDAT']. ' + '.$i.' days')).'</td>';
			 
			 $Tday=date('d', strtotime($_POST['RDAT']. ' + '.$i.' days'));
		}
		?>
      </tr>
    </thead>
    <tbody>
      
        <?php 
		
    $RoomType=$this->Myclass->RoomType($_POST['RoomType']);		
	foreach($RoomType as $Type)
			{ 
		if($Type['InActive'] !=1) {
					
	$Res=$this->Myclass->Room_Type($Type['RoomType_Id']);
		
		echo '<tr>
        <td class="RoomType_Id" align="left" ><div align="left" >&nbsp; <strong>'.$Type['RoomType'].'</strong></div> </td>';
								 
									echo '<td colspan="20" class="RoomType_Id" align="left" ></td>';
							 
      echo '<tr>';
		 foreach($Res as $row)
			{
				
				echo ' <tr>
    						<td style="height:35px;width:155px" align="left" >
							<div align="left" >&nbsp; <i class="fa fa-bed" aria-hidden="true"></i>
						'.$row['RoomNo'].'</div></td>'; $merg=true; $merg1 = true;
						$Fday=date('Y/m/d', strtotime($_POST['RDAT']. ' + 0 days')); 
							for($i=0;$i<20;$i++)
								{  
									 $emptyroom=true;
 							        $dates=date('Y/m/d', strtotime($_POST['RDAT']. ' + '.$i.' days'));
									$sql="Select * from Room_Status rs
									Inner join Trans_Roomdet_Det_rent rd on rs.grcid=rd.grcid
									INNER JOIN Trans_Roomcustomer_det rdet on rdet.grcid=rd.grcid
									INNER JOIN Mas_Customer cus on cus.Customer_Id=rdet.Customerid
									where rs.Status='Y' and isnull(billsettle,0)=0 and Rentdate='".$dates."' and  rs.Roomid='".$row['Room_Id']."'";									
									$res=$this->db->query($sql);
									$noofrow=$res->num_rows();
									if($noofrow !=0)
									{  $emptyroom=false;								     
									  if($merg == true)	/// Room Status Color Change and  Marge the Row 
									  {
									   $color='#0b6900';
								       foreach ($res->result_array() as $rows)
								        {   $get="select * from Trans_Roomdet_Det_rent where grcid='".$rows['grcid']."' and Rentdate >='".$dates."'";
                                           $execget=$this->db->query($get);	
										  $no=$execget->num_rows();	   }
									   
									   echo '<td colspan="'.$no.'" class="SC'.$row['Room_Id'].$i.' roomtd td'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).$row['Room_Id'].'" style="height:35px;width:35px;color:#ffffff !important;background:'.$color.'" >';
									   echo	'<div class="dropdown3">';
									   echo   $rows['Firstname'];
									   echo '<div class="dropdown3-content"> 
									         <a href="#" onclick="amendment('.$row['Room_Id'].')">Guest Amendment</a>
											 <a href="#" onclick="checkout('.$row['Room_Id'].')">Checkout</a>
											 <a href="#" onclick="postadvance('.$row['Room_Id'].')">Advance Posting</a>
											 <a href="#" onclick="postbill('.$row['Room_Id'].')">Bill Posting</a>
											 <a href="#" onclick="roomtransfer('.$row['Room_Id'].')">Room Trasfer</a>
											 </div>
											 </div> ';
										
									   echo	'</td>';
									     $merg = false;
									  }
									}
									$sql1="Select *from Room_Status rs
									Inner join Trans_Roomdet_Det_rent rd on rs.grcid=rd.grcid
									INNER JOIN Trans_Roomcustomer_det rdet on rdet.grcid=rd.grcid
									INNER JOIN Mas_Customer cus on cus.Customer_Id=rdet.Customerid
									INNER JOIN Trans_checkout_mas cmas on cmas.Roomgrcid=rs.roomgrcid
									where rs.Status='Y' and isnull(billsettle,0)='1' and Rentdate='".$dates."' and  rs.Roomid='".$row['Room_Id']."'";									
									$res1=$this->db->query($sql1);
									$noofrow1=$res1->num_rows();
									if($noofrow1 !=0)
									{ 
									  $emptyroom=false;
									  if($merg == true)	/// Room Status Color Change and  Marge the Row 
									  {
									   $color='#f0991f';
								       foreach ($res1->result_array() as $rows)
								        {  $get="select * from Trans_Roomdet_Det_rent where grcid='".$rows['grcid']."' and Rentdate >='".$dates."'";
                                           $execget=$this->db->query($get);	
										   $no=$execget->num_rows();	   }
									   
									   echo '<td colspan="'.$no.'" class="SC'.$row['Room_Id'].$i.' roomtd td'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).$row['Room_Id'].'" style="height:35px;width:35px;color:#ffffff !important;background:'.$color.'" >';
									   echo	'<div class="dropdown3">';
									   echo   $rows['Firstname'];
									   echo '<div class="dropdown3-content"> 
									         <a href="#" onclick="settlement('.$rows['Checkoutid'].')">Settlement</a>
											 </div>
											 </div> ';
										
									   echo	'</td>';
									     $merg = false;
									  }
									}
									$sql2="	select * from trans_reserve_mas res
									inner join Trans_reserve_det det on res.Resid=det.resid
									Inner join Mas_Room rm on rm.Room_Id=res.Roomid
									inner join Trans_reserve_det1 det1 on det1.refresdetid=det.resdetid
									Inner join Mas_Customer ms on ms.Customer_Id=res.cusid
									where det1.resdate='".$dates."' and  rm.Room_Id='".$row['Room_Id']."' and isnull(res.stat,'')!='C'";
									$res2=$this->db->query($sql2);
									$noofrow2=$res2->num_rows();  
									if($noofrow2 !=0)
									{  $emptyroom=false;
								       foreach ($res2->result_array() as $rows2)
								        {
								       $sql3="select * from Trans_reserve_det1 where refresdetid='".$rows2['resdetid']."'";
									   $res3=$this->db->query($sql3);
									   $noofrow3=$res3->num_rows();  
									     if($merg1 == true)
										 {$color='#5bc0de';
										echo '<td colspan="'.$noofrow3.'" class="SC'.$rows2['Room_Id'].$i.' roomtd td'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).$rows2['Room_Id'].'" style="height:35px;width:35px;color:#ffffff !important;background:'.$color.'" >';
									    echo	'<div class="dropdown3">';
									    echo   $rows2['Firstname'];
									    echo '<div class="dropdown3-content"> 
									         <a href="#" onclick="amendment('.$rows2['Room_Id'].')">Reservation Amendment</a>
											 <a href="#" onclick="rescancel('.$rows2['Resid'].')">Reservation Cancel</a>
											 <a href="#" onclick="resadvance('.$rows2['Resid'].')">Advance Posting</a>
											 </div>
											 </div> ';
										
									    echo	'</td>';
										 }
										}
										$merg1 = false;
									}
									if($emptyroom==true)
									{
										$sql="Select * from Room_Status where isnull(notready,0)=1 and Status='N' and Roomid=".$row['Room_Id'];
										$res2=$this->db->query($sql);
										$noofrow2=$res2->num_rows();
										if($i==0 && $noofrow2 !=0)
										{										
										 $color='#e00e07';
										 echo '<td  style="height:35px;width:35px;color:#ffffff !important;background:'.$color.'">';
										 echo	'<div class="dropdown3">';
										 echo 'Not Ready';
										 echo '<div class="dropdown3-content"> 
									         <a href="#" onclick="cleardirty('.$row['Room_Id'].')">Clear Dirty</a>
											 </div>
											 </div> ';
										 echo '</td>';
											
										}
										else
										{
										$color='White';
											echo '<td  
										 onDblClick="Cell_Click(&#39;'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).'&#39;,'.$row['Room_Id'].',&#39;'.date('d/m/Y', strtotime($_POST['RDAT']. ' + '.$i.' days')).'&#39;)"
										
										onClick="CellSing_Click(&#39;'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).'&#39;,'.$row['Room_Id'].',&#39;'.date('d/m/Y', strtotime($_POST['RDAT']. ' + '.$i.' days')).'&#39;,'.$i.')"  
										 
										  class="SC'.$row['Room_Id'].$i.' roomtd td'.date('d', strtotime($_POST['RDAT']. ' + '.$i.' days')).$row['Room_Id'].'" style="height:35px;width:35px;background:'.$color.'" ></td>';
										}
									}
								    $Tday=date('d', strtotime($_POST['RDAT']. ' + '.$i.' days'));
								}
   				echo '</tr>';
			  }
			}
			}
	?>
    </tbody>
  </table>
</div>
<div id="settlement" class="settlement" style="display:none;width:450px" title="Settlement">
</div>
<div id="guestamenddialog" class="amendment" style="display:none;width:450px" title="Guest Amendment">
</div>
<div id="checkoutdialog" class="Checkout" style="display:none;width:450px" title="Checkout">
</div>
<div id="rescancel" class="rescancel" style="display:none;width:450px" title="Reservation Cancel">
</div>
<div id="roomtransferdialog" class="roomtransfer" style="display:none;width:450px" title="Room Transfer">
</div>
<div id="advancedialog" class="postadvance" style="display:none;width:450px;" title="Post Advance">
</div>
<div id="resadvance" class="resadvance" style="display:none;width:450px;" title="Post Reservation Advance">
</div>
<div id="postbilldialog" class="postbill" style="display:none;width:450px" title="Bill Posting">
</div>
<div id="cleardirtydialog" class="cleardirty" style="display:none;width:450px" title="Clear Dirty">
</div>
<div id="dialog" class="Checkin"   style="display:none;width:450px" title="Walkin/Reservation">

</div>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
var clk=0;
var FD='';var TD=''; ifrstid=0;
var sRmid=0;
function Cell_Click(ee,roomid,dat)
{
	 
	$('.roomtd').removeClass('SelClo');
	$('.td'+ee+roomid).addClass('SelClo');
	
	chkin(roomid,dat,dat);
	 
}
function CellSing_Click(ee,roomid,dat,cou)
{
	clk++;
	
	if(clk==1){    
	$('.roomtd').removeClass('SelClo');
	ifrstid=cou;
	$('.td'+ee+roomid).addClass('SelClo');
	FD=dat;
	sRmid=roomid;
	}
	if(clk==2){
		
		if(sRmid!=roomid){clk=1; alert('Please Select Room !!! '); return; }
		
		var date = FD.substring(0, 2);
        var month = FD.substring(3, 5);
        var year = FD.substring(6, 10); 
        var datefrom = new Date(year, month - 1, date);
		var date1 = dat.substring(0, 2);
        var month1 = dat.substring(3, 5);
        var year1 = dat.substring(6, 10); 
        var dateTo = new Date(year1, month1 - 1, date1);
		if(dateTo < datefrom){clk=1; alert('From date Not Allowed to Less then Todate'); return; }
		
		clk=0;
		ifrstid=ifrstid*1;
		toid=ee*1;
		
		for(f=ifrstid;f<toid;f++)
		{
			$('.SC'+roomid+f).addClass('SelClo');
		}
		
		chkin(roomid,FD,dat);
	}
	
	 
}


function chkin(roomid,Fdat,Tdat)
{
	$.ajax({
		
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/Checkin/",
		data:$('#scsfrm').serialize()+"&Fdat="+Fdat+"&Tdat="+Tdat+"&roomid="+roomid,
		success: function(html)
		{
			 $(".Checkin").html(html);
		}
		 
	 })
	
	$( "#dialog" ).dialog({
		      height: "auto",
      width: 800,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}

function checkout(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/Checkout/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".Checkout").html(html);
		}		 
	 })	
	//alert("Varuthu");
	$( "#checkoutdialog" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function rescancel(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/rescancel/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".rescancel").html(html);
		}		 
	 })	
	//alert("Varuthu");
	$( "#rescancel" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function amendment(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/amendment/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".amendment").html(html);
		}		 
	 })	
	//alert("Varuthu");
	$( "#guestamenddialog" ).dialog({
		      height: "auto",
      width: 800,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function settlement(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/settlement/",
		data:$('#scsfrm').serialize()+"&Billid="+a,
		success: function(html)
		{
			 $(".settlement").html(html);
		}		 
	 })	
	//alert("Varuthu");
	$( "#settlement" ).dialog({
		      height: "auto",
      width: 740,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function roomtransfer(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/roomtransfer/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".roomtransfer").html(html);
		}		 
	 })	
	//alert("Varuthu");
	$( "#roomtransferdialog" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function resadvance(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/resadvanceposting/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".resadvance").html(html);
		}		 
	 })		
	//alert("Varuthu");
	$( "#resadvance" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function postadvance(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/advanceposting/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".postadvance").html(html);
		}		 
	 })		
	//alert("Varuthu");
	$( "#advancedialog" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function postbill(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/billposting/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".postbill").html(html);
		}		 
	 })		
	//alert("Varuthu");
	$( "#postbilldialog" ).dialog({
		      height: "auto",
      width: 600,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
function cleardirty(a)
{
	$.ajax({
		type:"POST",
		url:"<?php echo scs_index;?>Transaction/cleardirty/",
		data:$('#scsfrm').serialize()+"&Room_id="+a,
		success: function(html)
		{
			 $(".cleardirty").html(html);
		}		 
	 })		
	//alert("Varuthu");
	$( "#cleardirtydialog" ).dialog({
		      height: "auto",
      width: 300,
      modal: true
		});
	$('.ui-dialog-titlebar-close').html('X');
	$('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
}
$(function () {
  $('table tr').each(function () {
    let $firstRow
       ,colspan = 0
    $(this).find('td').each(function() {
      if ($(this).hasClass('May')) {
        // Save the first cell with class in $firstRow, remove the rest
        colspan === 0 ? $firstRow = $(this) : $(this).remove()
        // Count the number of cells
        colspan++
      } else if (colspan > 0) {
        // Assign the colspan and reset the counter
        $firstRow.attr('colspan', colspan)
        colspan = 0
      }
    })
    if (colspan > 0) {
      $firstRow.attr('colspan', colspan)
      colspan = 0
    }
  })
  
  $('table tr').each(function () {
    let $firstRow
       ,colspan = 0
    $(this).find('td').each(function() {
      if ($(this).hasClass('June')) {
        // Save the first cell with class in $firstRow, remove the rest
        colspan === 0 ? $firstRow = $(this) : $(this).remove()
        // Count the number of cells
        colspan++
      } else if (colspan > 0) {
        // Assign the colspan and reset the counter
        $firstRow.attr('colspan', colspan)
        colspan = 0
      }
    })
    if (colspan > 0) {
      $firstRow.attr('colspan', colspan)
      colspan = 0
    }
  })
  
  $('table tr').each(function () {
    let $firstRow
       ,colspan = 0
    $(this).find('td').each(function() {
      if ($(this).hasClass('July')) {
        // Save the first cell with class in $firstRow, remove the rest
        colspan === 0 ? $firstRow = $(this) : $(this).remove()
        // Count the number of cells
        colspan++
      } else if (colspan > 0) {
        // Assign the colspan and reset the counter
        $firstRow.attr('colspan', colspan)
        colspan = 0
      }
    })
    if (colspan > 0) {
      $firstRow.attr('colspan', colspan)
      colspan = 0
    }
	
  })
  
})

</script>