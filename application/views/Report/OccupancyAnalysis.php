<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Report', 'Occupancy Analysis');
$this->pfrm->FrmHead6('Report /Occupancy Analysis', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");


$qryy = "select count(*) as roomcount from mas_room where inactive<>1";
$exee = $this->db->query($qryy);
foreach ($exee->result_array() as $Rom) {
    $roomcount = $Rom['roomcount'];
}

$sql1 = "select * from financial_year_new where currentyear=1";
$res1 = $this->db->query($sql1);
foreach($res1->result_array() as $row1){
    $year = date('Y-m-d', strtotime($row1['Fromdate']));
}
?>
 <?php 	date_default_timezone_set('Asia/Kolkata');  ?>

<div class="col-sm-12">
    <div class="the-box F_ram">
        <fieldset>
            <form action="" method="POST">
                <table class="FrmTable T-6">
                    <tr>
                        <td align="right" class="F_val">From Date</td>
                        <td align="left"><input type="date" value="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" id="frmdate"
                                name="frmdate" class="scs-ctrl " max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" />
                            <div class="Type"></div>
                        </td>
                        <!-- <td align="right" class="F_val">To Date</td>
                        <td align="left"><input type="date" value="<?php echo date('Y-m-d', strtotime('-1 day')); ?>" id="todate"
                                name="todate" class="scs-ctrl "  max="<?php echo date('Y-m-d', strtotime('-1 day')); ?>"/>
                            <div class="Type"></div>
                        </td> -->
                        <td align="left"><input type="submit" name="submit" class="btn btn-success btn-block"
                                value="Get"></td>
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
        $totalamount = 0;
        $totalpax = 0;
        $totalbedamount = 0;
        $totalcount = 0;
        $perocc = 0;
        ?>

        <table class="table table-bordered table-hover">
            <div>
                <h4 class="text-center">Occupancy Analysis
                    <?php echo date('d-m-Y', strtotime($_POST['frmdate'])); ?> 
                    <h4>
            </div>
            <tbody>
                <?php
                $fromdate = date('Y-m-d', strtotime($_POST['frmdate']));
                $monthsatrtdate = date('Y-m-01', strtotime($fromdate));
                $aa_date = date_create($fromdate); // convert the date to string
                $l_date = date_create($monthsatrtdate);
                $diff = date_diff($l_date, $aa_date);
                $difference = $diff->format("%a");
                $ll_date = date_create($year);
                $diff = date_diff($ll_date, $aa_date);
                $difference1 = $diff->format("%a");
                $monthlyroomcount = $roomcount * $difference;
                $yearlyroomcount = $roomcount * $difference1;
                $qry = "select RoomType_id,RoomType from Mas_RoomType  where Inactive<>1 order by Roomtype_id";
                $exec = $this->db->query($qry);
                $advance = $exec->num_rows();

                echo '<tr style="background-color:#c9c6c6">';
                echo '<td colspan="2"></td>';
                echo '<td>Room Rent</td>';
                echo '<td>OCC</td>';
                echo '<td>OCC %</td>';
                echo "<td>No's of ExtraBed </td>";
                echo '<td>ExtraBed Amount</td>';
                echo '</tr>';


                $a_date = $fromdate;
                $totalrooment = 0;
                $totalocc = 0;

                    foreach ($exec->result_array() as $row) {
                        echo '<tr>';
                        echo '<td colspan="2">' . $row['RoomType'] . '</td>';

                         $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
                    inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
                    where ce.CreditDate between '" . $a_date . "' and '" . $a_date . "' and det.typeid='" . $row['RoomType_id'] . "' and
                     ce.Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead='ROOM RENT') ";

                        $exe = $this->db->query($qry1);

                        foreach ($exe->result_array() as $rows) {
                            $totalrooment +=  $rows['Amount'];
                            echo '<td style="text-align: right;">' . $rows['Amount'] . '</td>';
                        }
                        $socc  =0;
                        $qry3 = " select Count(*) as occ from trans_credit_entry where 
                       Creditheadid=(select Revenue_id from Mas_Revenue 
                       where RevenueHead='ROOM RENT') and 
                       roomid in (select room_id from mas_room where RoomType_Id='" . $row['RoomType_id'] . "')
                       and CreditDate between '" . $a_date . "'  and '" . $a_date . "' ";
                        $exe = $this->db->query($qry3);
                        foreach ($exe->result_array() as $rows) {
                            $totalocc +=  $rows['occ'];
                            $socc =  $rows['occ'];
                            echo '<td style="text-align: right;">' . $rows['occ'] . '</td>';
                        }

                        
                        $sql = "select count(*) as count from mas_room where RoomType_Id = '" . $row['RoomType_id'] . "'";
                        $res = $this->db->query($sql);
                        foreach($res->result_array() as $row){
                            if($socc != 0){
                            $occper = ($socc / $row['count'])*100;
                            }else{
                                $occper = 0.00;
                            }
                        }
                        echo '<td style="text-align:right">'.number_format($occper,2).'%'.'</td>';

                        $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
                        left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                        and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                        where tce.CreditDate between '" . $a_date . "' and '" . $a_date . "' ";
                          $exc = $this->db->query($qry7);
                          foreach ($exc->result_array() as $excc) {
                              $totalcount += $excc['extracount'];
                              echo '<td style="text-align: right;">' . $excc['extracount'] . '</td>';
                          }

                          $qry6 = "select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                          left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                          and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                          where tce.CreditDate between '" . $a_date . "' and '" . $a_date . "'";
                          $exc = $this->db->query($qry6);
                          foreach ($exc->result_array() as $excc) {
                        $totalbedamount += $excc['extrabedAmount'];
                        echo '<td style="text-align: right;">' .number_format($excc['extrabedAmount'],2)  . '</td>';
                    }
                        echo '</tr>';
                    }
                    
                    echo '<tr>';

                        echo '<td colspan="2" style="font-weight:bold;">Total</td>';
                        echo '<td style="text-align: right;">' . number_format($totalrooment,2) . '</td>';
                   
                        echo '<td style="text-align: right;">' .$totalocc. '</td>';
                        if ($totalocc != 0) {
                            $perocc = number_format(($totalocc/ $roomcount)*100,2);
                            echo '<td style="text-align: right;">'. $perocc. '%' . '</td>';
                        } else{
                            echo '<td style="text-align: right;">' . '0%' . '</td>';
                        }

                        echo '<td style="text-align: right;">' .$totalcount . '</td>';

                        echo '<td style="text-align: right;">' .number_format($totalbedamount,2)  . '</td>';
                    echo '</tr>';

                    // echo '<tr><td colspan="7"></td></tr>';



                    echo '<tr><td colspan="7">&nbsp;</td></tr>';
                    echo '<tr style="background-color:#c9c6c6"><td colspan="7" style="text-align:left;" class="text-bold">For the Month (M.T.D)</td></tr>';

                    foreach ($exec->result_array() as $row) {
                        echo '<tr>';
                        echo '<td colspan="2">' . $row['RoomType'] . '</td>';

                        $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
                    inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
                    where ce.CreditDate between '" . $monthsatrtdate. "' and '" . $a_date . "' and det.typeid='" . $row['RoomType_id'] . "' and
                     ce.Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead='ROOM RENT') ";

                        $exe = $this->db->query($qry1);

                        foreach ($exe->result_array() as $rows) {
                            $totalrooment +=  $rows['Amount'];
                            echo '<td style="text-align: right;">' . $rows['Amount'] . '</td>';
                        }
                        $mocc  =0;
                        $qry3 = " select Count(*) as occ from trans_credit_entry where 
                       Creditheadid=(select Revenue_id from Mas_Revenue 
                       where RevenueHead='ROOM RENT') and 
                       roomid in (select room_id from mas_room where RoomType_Id='" . $row['RoomType_id'] . "')
                       and CreditDate between '" .  $monthsatrtdate. "'  and '" . $a_date . "' ";
                        $exe = $this->db->query($qry3);
                        foreach ($exe->result_array() as $rows) {
                            $mocc =  $rows['occ'];
                            echo '<td style="text-align: right;">' . $rows['occ'] . '</td>';
                        }

                        
                        $sql = "select count(*) as count from mas_room where RoomType_Id = '" . $row['RoomType_id'] . "'";
                        $res = $this->db->query($sql);
                        foreach($res->result_array() as $row){
                            $occperm = ($mocc / $monthlyroomcount)*100;
                        }
                        echo '<td style="text-align:right">'.number_format($occperm,2).'%'.'</td>';

                        $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
                        left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                        and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                        where tce.CreditDate between '" .  $monthsatrtdate . "' and '" . $a_date . "' ";
                          $exc = $this->db->query($qry7);
                          foreach ($exc->result_array() as $excc) {
                              echo '<td style="text-align: right;">' . $excc['extracount'] . '</td>';
                          }

                          $qry6 = "select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                          left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                          and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                          where tce.CreditDate between '" .  $monthsatrtdate. "' and '" . $a_date . "'";
                          $exc = $this->db->query($qry6);
                          foreach ($exc->result_array() as $excc) {
                        echo '<td style="text-align: right;">' .number_format($excc['extrabedAmount'],2)  . '</td>';
                    }
                        echo '</tr>';
                    }
                    echo '<tr>';
                  


                    echo '<td colspan="2" style="font-weight:bold;">Month Total</td>';

                    $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
                    where ce.CreditDate between '" . $monthsatrtdate. "' and '" . $fromdate. "'  and
                     ce.Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead='ROOM RENT') ";

                        $exe = $this->db->query($qry1);

                        foreach ($exe->result_array() as $rows) {
                            echo '<td style="text-align: right;">' .$rows['Amount'] . '</td>';
                        }
               

                    
                   
                    
                    $qry3 = " select Count(*) as occ from trans_credit_entry where 
                    Creditheadid=(select Revenue_id from Mas_Revenue 
                    where RevenueHead='ROOM RENT')
                    and CreditDate between '" . $monthsatrtdate. "'  and '" . $fromdate . "' ";
                     $exe = $this->db->query($qry3);
                     foreach ($exe->result_array() as $rows) {
                        echo '<td style="text-align: right;">' .$rows['occ']. '</td>';
                         echo '<td style="text-align: right;">' .number_format(($rows['occ'] / $monthlyroomcount)*100 ,2).'%'.'</td>';
                     }



                     $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
                     left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                     and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                     where tce.CreditDate between '" . $monthsatrtdate . "' and '" . $fromdate . "' ";
                       $exc = $this->db->query($qry7);
                       foreach ($exc->result_array() as $excc) {
                           echo '<td style="text-align: right;">' . $excc['extracount'] . '</td>';
                       }

                       $qry6 = "select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                       left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                       and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                       where tce.CreditDate between '" . $monthsatrtdate . "' and '" .$fromdate . "'";
                       $exc = $this->db->query($qry6);
                       foreach ($exc->result_array() as $excc) {
                     echo '<td style="text-align: right;">' .number_format($excc['extrabedAmount'],2)  . '</td>';
                 }
                echo '</tr>';


                echo '<tr><td colspan="7">&nbsp;</td></tr>';
                echo '<tr><td colspan="7" style="text-align:Left;background-color:#c9c6c6;" class="text-bold">For the Year (Y.T.D)</td></tr>';
                foreach ($exec->result_array() as $row) {
                    echo '<tr>';
                    echo '<td colspan="2">' . $row['RoomType'] . '</td>';

                    $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
                inner join trans_roomdet_det det on ce.roomid=det.roomid and ce.roomgrcid=det.roomgrcid and ce.grcid=det.grcid
                where ce.CreditDate between '" . $year. "' and '" . $a_date . "' and det.typeid='" . $row['RoomType_id'] . "' and
                 ce.Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead='ROOM RENT') ";

                    $exe = $this->db->query($qry1);

                    foreach ($exe->result_array() as $rows) {
                        $totalrooment +=  $rows['Amount'];
                        echo '<td style="text-align: right;">' . $rows['Amount'] . '</td>';
                    }
                    $mocc  =0;
                    $qry3 = " select Count(*) as occ from trans_credit_entry where 
                   Creditheadid=(select Revenue_id from Mas_Revenue 
                   where RevenueHead='ROOM RENT') and 
                   roomid in (select room_id from mas_room where RoomType_Id='" . $row['RoomType_id'] . "')
                   and CreditDate between '" .  $year. "'  and '" . $a_date . "' ";
                    $exe = $this->db->query($qry3);
                    foreach ($exe->result_array() as $rows) {
                        $mocc =  $rows['occ'];
                        echo '<td style="text-align: right;">' . $rows['occ'] . '</td>';
                    }

                    
                    $sql = "select count(*) as count from mas_room where RoomType_Id = '" . $row['RoomType_id'] . "'";
                    $res = $this->db->query($sql);
                    foreach($res->result_array() as $row){
                        $occperm = ($mocc / $yearlyroomcount)*100;
                    }
                    echo '<td style="text-align:right">'.number_format($occperm,2).'%'.'</td>';

                    $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
                    left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                    and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                    where tce.CreditDate between '" .  $year . "' and '" . $a_date . "' ";
                      $exc = $this->db->query($qry7);
                      foreach ($exc->result_array() as $excc) {
                          echo '<td style="text-align: right;">' . $excc['extracount'] . '</td>';
                      }

                      $qry6 = "select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                      left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                      and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                      where tce.CreditDate between '" .  $year. "' and '" . $a_date . "'";
                      $exc = $this->db->query($qry6);
                      foreach ($exc->result_array() as $excc) {
                    echo '<td style="text-align: right;">' .number_format($excc['extrabedAmount'],2)  . '</td>';
                }
                    echo '</tr>';
                }

                echo '<tr>';
               
                echo '<td colspan="2" style="font-weight:bold;">Year Total</td>';

                $qry1 = "select isnull(sum(Amount),0) as Amount from Trans_Credit_Entry ce
                where ce.CreditDate between '" .$year. "' and '" . $fromdate. "'  and
                 ce.Creditheadid=(select Revenue_id from Mas_Revenue where RevenueHead='ROOM RENT') ";

                    $exe = $this->db->query($qry1);

                    foreach ($exe->result_array() as $rows) {
                        echo '<td style="text-align: right;">' .$rows['Amount'] . '</td>';
                    }
           

                
               
                
                $qry3 = " select Count(*) as occ from trans_credit_entry where 
                Creditheadid=(select Revenue_id from Mas_Revenue 
                where RevenueHead='ROOM RENT')
                and CreditDate between '" . $year. "'  and '" . $fromdate . "' ";
                 $exe = $this->db->query($qry3);
                 foreach ($exe->result_array() as $rows) {
                    echo '<td style="text-align: right;">' .$rows['occ']. '</td>';
                     echo '<td style="text-align: right;">' .number_format(($rows['occ'] / $yearlyroomcount)*100,2) .'%'.'</td>';
                 }



                 $qry7 = "select isnull(sum(detr.extrabed),0) as extracount from trans_roomdet_det detr 
                 left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                 and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                 where tce.CreditDate between '" . $year . "' and '" . $fromdate . "' ";
                   $exc = $this->db->query($qry7);
                   foreach ($exc->result_array() as $excc) {
                       echo '<td style="text-align: right;">' . $excc['extracount'] . '</td>';
                   }

                   $qry6 = "select isnull(sum(Amount),0) as extrabedAmount from trans_roomdet_det detr 
                   left join Trans_Credit_Entry tce on tce.Roomid = detr.roomid and tce.roomgrcid=detr.roomgrcid and tce.grcid=detr.grcid
                   and tce.creditheadid=(select Revenue_Id from mas_revenue where RevenueHead='Extra Bed')
                   where tce.CreditDate between '" . $year. "' and '" .$fromdate . "'";
                   $exc = $this->db->query($qry6);
                   foreach ($exc->result_array() as $excc) {
                 echo '<td style="text-align: right;">' .number_format($excc['extrabedAmount'],2)  . '</td>';
             }
            echo '</tr>';
                
                    

                

                ?>

            </tbody>


        </table>

    <?php } ?>
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
                    filename: "Occupancy Analysis Report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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
                pdfMake.createPdf(docDefinition).download("Occupancy Analysis Report.pdf");
            }
        });
    });
</SCRIPT>