<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Report', 'Room History');
$this->pfrm->FrmHead6('Report / Room History', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");

?>

<div class="col-sm-12">
    <div class="the-box F_ram">
        <fieldset>
            <form action="" method="POST">
                <table class="FrmTable T-6">
                    <tr>
                        <td align="right" class="F_val">From Date</td>
                        <td align="left"><input type="date" value="<?php if(@$_POST['Fdate']){echo date('Y-m-d', strtotime($_POST['Fdate']));}else{echo date('Y-m-d');} ?>" max = "<?php echo date('Y-m-d')?>" id="frmdate"
                                name="Fdate" class="scs-ctrl Dat2" />
                            <div class="Type"></div>
                        </td>
                        <td align="right" class="F_val">To Date</td>
                        <td align="left"><input type="date" value="<?php if(@$_POST['Tdate']){echo date('Y-m-d', strtotime($_POST['Tdate']));}else{echo date('Y-m-d');} ?>"  max = "<?php echo date('Y-m-d')?>" id="todate"
                                name="Tdate" class="scs-ctrl Dat2" />
                            <div class="Type"></div>
                        </td>
                        <td align="left"><input type="submit" name="submit" class="btn btn-success btn-block"
                                value="Get"></td>
                        <td align="right" class="F_val">Selection</td>
                        <td align="left">



                            <select name="Room" id="Room" class="scs-ctrl">
                                <option value="0">Select Plan</option>
                                <?php
                                $qry = "exec Get_Roomm ";
                                $res = $this->db->query($qry);
                                foreach ($res->result_array() as $row) {
                                   ?>
                                   <option <?php if(@$_POST['Room']==$row['Room_Id']){echo "selected"; } ?> value="<?php echo $row['Room_Id'] ?>"  ><?php echo $row['RoomNo'] ?></option>;
                               <?php }
                                ?>
                                <select>



                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div class="the-box D_IS"></div>
</div>
<div id="printing" class="col-sm-12">
    <?php
    if (@$_POST['submit']) {
        ?>
        <table class="table table-bordered table-hover">
            <div>
                <h4 class="text-center">Room History Report
                    <?php echo date('d-m-Y', strtotime($_POST['Fdate'])); ?> To
                    <?php echo date('d-m-Y', strtotime($_POST['Tdate'])); ?>
                    <h4>
            </div>
            <tbody>
                <?php

                $i = 1;
                $Fromdate = date('Y-m-d', strtotime($_POST['Fdate']));
                $Todate = date('Y-m-d', strtotime($_POST['Tdate']));
                $room = '';$pax=0;$cgst=0;$sgst=0;$tariff=0;

                if (@$_POST['Room'] != 0) {
                    $qry = " exec Room__History__Particular '" . $Fromdate . "' , '" . $Todate . "', '".$_POST['Room']."' ";
                } else {
                    $qry = " exec Room__History '" . $Fromdate . "' , '" . $Todate . "' ";
                }
                $ipax = 0; $icgst=0 ;$isgst = 0;$itariff =0;
                $exec = $this->db->query($qry);
                $advance = $exec->num_rows();
                if ($advance != 0) {
                    echo '<tr style="background-color:#c9c6c6;">';
                    echo '<td  style="text-align: center;">S.no</td>';
                    // echo '<td  style="text-align: center;">RoomNo</td>';
                    echo '<td  style="text-align: center;">CheckoutNo</td>';
                    echo '<td style="text-align: center;">Guest Name</td>';
                    echo '<td style="text-align: center;">Arr.dateTime</td>';
                    echo '<td style="text-align: center;">Dep.DateTime</td>';
                    echo '<td style="text-align: center;">NoofDays</td>';
                    echo '<td style="text-align: center;">Pax</td>';
                    echo '<td style="text-align: center;">Tariff</td>';
                    echo '<td style="text-align: center;">CGST</td>';
                    echo '<td style="text-align: center;">SGST</td>';
                    echo '</tr>';

                }
                foreach ($exec->result_array() as $rows) {
                    if($room != $rows['roomno']){
                     
                        if($i !=1){
                            echo '<tr>';
                            echo '<td  style="text-align: center;"colspan="6" class="text-bold">Total</td>';
                            echo '<td  style="text-align: center;">' . $ipax. '</td>';
                            echo '<td  style="text-align: center;">' . number_format($itariff,2) . '</td>';
                            echo '<td  style="text-align: center;">' . number_format($icgst,2) . '</td>';
                            echo '<td  style="text-align: center;">' . number_format($isgst,2). '</td>';
                            echo '</tr>';
                        }
                     
                        if($i != 1){
                            echo '<tr><td colspan="10">&nbsp;</td></tr>';
                        }
                
                        echo '<tr style="background-color:#c9c6c6;">';
                        echo '<td  style="text-align: center;"class="text-bold" colspan="10"> Room No :' . $rows['roomno'] . '</td>';
                        echo '</tr>';
                        
                    }
                    
                    
                    echo '<tr>';
                    echo '<td  style="text-align: center;">' . $i++ . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['yearprefix'] . '/' . $rows['checkoutno'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['guestname'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['checkindateandtime'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['checkoutdateandtime'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['noofdays'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['noofpersons'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['Tariff'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['CGST'] . '</td>';
                    echo '<td  style="text-align: center;">' . $rows['SGST'] . '</td>';
                    echo '</tr>';
                    $pax +=$rows['noofpersons']; $cgst +=$rows['CGST'];$sgst += $rows['SGST'];$tariff +=$rows['Tariff'];

                    if($room != $rows['roomno'] ){
                        $ipax = 0; $icgst=0 ;$isgst = 0;$itariff =0;
                        $ipax += $rows['noofpersons'];
                        $icgst +=$rows['CGST'];$isgst += $rows['SGST'];$itariff +=$rows['Tariff'];
                    }else{
                       
                        $ipax += $rows['noofpersons'];
                        $icgst +=$rows['CGST'];$isgst += $rows['SGST'];$itariff +=$rows['Tariff'];

                    }

                    $room = $rows['roomno'];

                }



                if($advance != 0){
                    echo '<tr>';
                    echo '<td  style="text-align: center;"colspan="6" class="text-bold">Total</td>';
                    echo '<td  style="text-align: center;">' . $ipax. '</td>';
                    echo '<td  style="text-align: center;">' . number_format($itariff,2) . '</td>';
                    echo '<td  style="text-align: center;">' . number_format($icgst,2) . '</td>';
                    echo '<td  style="text-align: center;">' . number_format($isgst,2). '</td>';
                    echo '</tr>';
                    echo '<tr><td colspan="10">&nbsp;</td></tr>';
                    echo '<tr>';
                    echo '<td  style="text-align: center;"colspan="6" class="text-bold"> Grand Total</td>';
                    echo '<td  style="text-align: center;">' . $pax. '</td>';
                    echo '<td  style="text-align: center;">' . number_format($tariff,2) . '</td>';
                    echo '<td  style="text-align: center;">' . number_format($cgst,2) . '</td>';
                    echo '<td  style="text-align: center;">' . number_format($sgst,2). '</td>';
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
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
<SCRIPT language="javascript">
    function printDiv(a) {
        var printContents = document.getElementById(a).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    function fromdatevalidate() {
        var a = document.getElementsByName("dateFrom")[0].value;
        alert(a);
    }
    function addRow(tableID) {

        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var colCount = table.rows[0].cells.length;

        for (var i = 0; i < colCount; i++) {

            var newcell = row.insertCell(i);

            newcell.innerHTML = table.rows[0].cells[i].innerHTML;
            //alert(newcell.childNodes);
            switch (newcell.childNodes[0].type) {
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

            for (var i = 0; i < rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if (null != chkbox && true == chkbox.checked) {
                    if (rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
        } catch (e) {
            alert(e);
        }
    }
    $(function () {
        $("#exporttable").click(function (e) {

            var table = $("#printing");
            if (table && table.length) {
                $(table).table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "RoomHistory__Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                pdfMake.createPdf(docDefinition).download("RoomHistory__Report.pdf");
            }
        });
    });
</SCRIPT>