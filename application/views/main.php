<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0 "></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);

?>

<style>
  table thead th {
    position: sticky !important;
    top: 0;
    background-color: white; /* Or use your table header's background color */
    z-index: 10;
  }

  .today_dep{
    background-color:#4CAF50;
    color: white;
  }
</style>
<?php
$sql4 = "exec room__revenue__chart";
$res4 = $this->db->query($sql4);
foreach ($res4->result_array() as $row4) {
  $yearRevenue = $row4['yearRevenue'];
  $dayRevenue = $row4['dayRevenue'];
  $curMonthRevenue = $row4['curMonthRevenue'];
  $dayGST = $row4['dayCGST'] + $row4['daySGST'];
  $yearGST = $row4['yearCGST'] +$row4['yearSGST'];
  $curMonthGST = $row4['curMonthSGST'] + $row4['curMonthCGST'];

}
?>
<div class="col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
  <div class="row row-bottom-margin">
    <div class="col-md-4 col-sm-12 col-12">
      <div class="text-white py-3 px-4">
        <div ><canvas id="myChart" class="card card-box" style="width:100%;background-color:#00bcd4;border-radius:10px;margin-bottom:6px;"></canvas></div>
      </div>
      <div class="text-white py-3 px-4">
        <div ><canvas id="ReserveCount" class="card card-box" style="width:100%;background-color:#32CD32;border-radius:10px;margin-bottom:6px;"></canvas></div>
      </div>
      
    </div>

    <div class="col-md-4 col-sm-12 col-12 grid-margin stretch-card" style="padding-right:0px;padding-left:0px;">
      <div class="card  card-box" style="border: 1px solid #D0D0D0;box-shadow: 0 0 8px #D0D0D0;">
        <div class="card-head">
          <header style="color:black">High Balance</header>
        </div>
        <div class="card-body no-padding height-9 ">
          <div class="noti-information notification-menu">
            <div class="notification-list mail-list not-list small-slimscroll-style">
              <div class="" style="overflow-x: auto;">
                <table class=" table table-bordered " style="width:100% !important;font-size: 12px;">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Check In</th>
                      <th>Bill.Amt</th>
                      <th>Advance</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "exec High__balance";
                    $res = $this->db->query($sql);
                    $count = 1;
                    foreach ($res->result_array() as $row) {
                      ?>
                      <tr>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;">
                          <?php echo $row['customer'] ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;">
                          <?php echo date('d-m-Y', strtotime($row['CheckinDate'])) ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:right;">
                          <?php echo number_format($row['billamount'],2); ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:right;">
                          <?php echo number_format($row['advance'],2); ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:right;">
                          <?php echo number_format($row['billamount'],2); ?>
                        </td>
                      </tr>
                      <?php $count++;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-sm-12 col-12 ">
      
     <div class="row-flex  no-padding ">
      <div class="text-white py-3 px-4 ">
        <div>
          <canvas id="Totalrevenue" class="card card-box" style="width:100%;background-color:#DAF7A6 ;border-radius:10px;margin-bottom:6px;"></canvas>
        </div>
      </div>
      <div class="text-white py-3 px-4">
        <div class="card card-box" style="width:100%;background-color:#F7DC6F ; margin-top: 2px;border-radius:10px;height:166px">
          <table class="table table-bordered" style="width:100%;font-size: 12px;margin-bottom:0px;">
            <thead>
              <tr>
                <th style="padding:14px !important;"></th>
                <th style="padding:14px !important;">Day</th>
                <th style="padding:14px !important;">M.T.D</th>
                <th style="padding:14px !important;">Y.T.D</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th style="padding:14px !important;">RoomRent</th>
                <td style="padding:14px !important;text-align:right;"><?php echo number_format($dayRevenue,2); ?>
                </td>
                <td style="padding:14px !important;text-align:right"><?php echo number_format($curMonthRevenue,2); ?></td>
                <td style="padding:14px !important;text-align:right;"><?php echo number_format($yearRevenue,2); ?>
                </td>
              </tr>
              <tr>
                <th style="padding:14px !important;"> GST</th>
                <td style="padding:14px !important;text-align:right;"><?php echo number_format($dayGST,2) ?></td>
                <td style="padding:14px !important; text-align:right;"><?php echo number_format($curMonthGST,2) ?>
                </td>
                <td style="padding:14px !important;text-align:right;"><?php echo number_format($yearGST,2) ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="row row-flex" style="margin-bottom:-10px;">
      <div class="col-md-4 col-sm-12 col-12 " style="">
        <canvas id="companyrevenue" class="card card-box" style="width:100%;background-color:#EECC75;HEIGHT:220PX;border-radius:10px;margin-bottom:0px;"></canvas>
      </div>
      <!-- <div class="col-md-4 col-sm-12 col-12 " style="padding-right:0px;padding-left:0px">
        <canvas id="verticalbar" class="card card-box" style="width:100%;background-color:#FAD9D9;HEIGHT:220PX;border-radius:10px;margin-bottom:0px"></canvas>
      </div> -->
      <div class="col-md-8 col-sm-12 col-12 grid-margin stretch-card" style="padding:5px;">
      <div class="card  card-box" style="border: 1px solid #D0D0D0;box-shadow: 0 0 8px #D0D0D0;HEIGHT:220PX;border-radius:10px;margin-bottom:0px">
        <div class="card-head">
          <header style="color:black">Today's Exp Depature</header>
        </div>
        <div class="card-body no-padding height-9 ">
          <div class="noti-information notification-menu">
            <div class="notificationn-list mail-list not-list small-slimscroll-style">
              <div class="">     
                <table class=" table table-bordered" style="width:100% !important;font-size: 12px;">
                  <thead>
                    <tr>
                      <th class=" today_dep text-center bg-warning">Room No</th>
                      <th  class=" today_dep text-center">Room Type</th>
                      <th  class=" today_dep text-center">Guest name</th>
                      <th  class=" today_dep text-center">Exp.Time</th>
                      <th  class=" today_dep text-center">Contact Number</th>
                      <th  class=" today_dep text-center">Pax</th>
                  
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $fromdate = date('Y-m-d');
                    $todate = date('Y-m-d');

                    $qry = "SELECT DISTINCT 
                    t.title + '.' + mc.Firstname + ' ' + mc.Lastname AS Guestname,
                    mc.mobile,
                    mrt.Roomtype,
                    mr.Roomno,
                    mas.Checkindate,
                    det.Noofpersons,
                    det.roomrent,
                    mas.checkintime,
                    ISNULL(mcom.company, '-') AS company,
                    mas.CheckinTime,
                    CONVERT(VARCHAR(8), Exptime, 108) AS FormattedExptime
                FROM trans_roomdet_Det det
                INNER JOIN trans_checkin_mas mas ON mas.Grcid = det.grcid
                INNER JOIN mas_room mr ON mr.Room_id = det.Roomid
                INNER JOIN room_status rs ON rs.roomid = mr.room_id and det.roomgrcid = rs.roomgrcid AND ISNULL(rs.status, 'N') = 'Y' and isnull(rs.billsettle,0)=0
                INNER JOIN mas_roomtype mrt ON mrt.RoomType_Id = mr.RoomType_Id
                INNER JOIN trans_roomcustomer_det cdet ON cdet.grcroomdetid = det.grcroomdetid
                INNER JOIN mas_customer mc ON mc.Customer_id = cdet.Customerid
                INNER JOIN mas_title t ON t.titleid = mc.Titelid
                LEFT JOIN mas_company mcom ON mcom.Company_Id = det.companyid
                LEFT JOIN Mas_CompanyType mct ON mct.companytype_id = mcom.companytype_id AND mct.CompanyType <> 'travelagent'
                where det.depdate = '".$fromdate."' 
                ORDER BY mr.roomno";

                    
                    // $qry="exec  TodaysDepature '".$fromdate."', '".$todate."'";

                    // echo $qry;
                   
                    $res = $this->db->query($qry);
                    $count = 1;
                    //print_r($res['Roomno']);
                    //echo '<pre>',print_r($res,1),'</pre>';
                    foreach ($res->result_array() as $row) {
                      
                      ?>
                      <tr>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:center">
                          <?php echo $row['Roomno'] ?>
                        </td>
                           <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:center">
                          <?php echo $row['Roomtype'] ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;">
                          <?php echo $row['Guestname'] ?>
                        </td>
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:center">
                          <?php echo $row['FormattedExptime'] ?>
                        </td>
                       
                        <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;">
                          <?php echo $row['mobile'] ?>
                        </td>
                              <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;">
                          <?php echo $row['Noofpersons'] ?>
                        </td>
                        <!-- <td style="width:20% !important; overflow-wrap: anywhere;padding:4px !important;text-align:right">
                          <?php //echo number_format($row['amount'],2); ?>
                        </td> -->
                        
                        
                      </tr>

                      <?php $count++;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>


  <?php
  $amountArray = [];
  $dateArray = [];
  $fordates = [];
  $countArray = [];
  $datesArray = [];
  $companyArray = [];
  $travelArray = [];
  $creditdateArray = [];
  $company= 0;
  $travel = 0;
  $companyname = [];
  $companyAmount=[];
  $sql2 = "exec roomrevenue '" . date('Y-m-d') . "' , '" . date('Y-m-d', strtotime('- 15days')) . "'";
  $res2 = $this->db->query($sql2);
  foreach ($res2->result_array() as $row2) {
    array_push($amountArray, $row2['roomrevenue']);
    array_push($dateArray, date('d', strtotime($row2['CreditDate'])));
    array_push($fordates, date('d-m-Y', strtotime($row2['CreditDate'])));
  }

  $values = array_values($amountArray);
  $dates = array_values($dateArray);
  $fordates = array_values($fordates);

  $sql2 = "exec reservetion__count'" . date('Y-m-d') . "' , '" . date('Y-m-d', strtotime('- 15days')) . "'";
  $res2 = $this->db->query($sql2);
  foreach ($res2->result_array() as $row2) {
    array_push($countArray, $row2['count']);
    array_push($datesArray, date('d-m-Y', strtotime($row2['ResDate'])));
  }

  $countArray = array_values($countArray);
  $datesArray = array_values($datesArray);

  $first_date = date('Y-m-d', strtotime('first day of this month'));
  $last_date = date('Y-m-d', strtotime('last day of this month'));
  $yearFirstDate = date('Y-m-01', strtotime("April"));
  $yearlastDate = date('Y-m-t', strtotime("March +1year"));

  $sql3 = "exec Total__Reenue'" . date('Y-m-d') . "' , '" . $first_date . "', '" . $last_date . "','" . $yearFirstDate . "', '" . $yearlastDate . "'";
  $res3 = $this->db->query($sql3);
  foreach ($res3->result_array() as $row3) {
    $dayAmount = $row3['dayRevenue'];
    $monthAmount = $row3['monthRevenue'];
    $yearAmount = $row3['yearRevenue'];
  }

     $sql5 = "exec company__travelagent__roomrevenue";
        $res5 = $this->db->query($sql5);
        foreach($res5->result_array() as $row5){
            $company = $row5['company'];
            $travel = $row5['travelagentAmount'];
            $date = date('d-m-Y',strtotime($row5['CreditDate']));

          array_push($companyArray, $company);
          array_push($travelArray, $travel);
          array_push($creditdateArray, $date);

        }

        $companyArray= array_values($companyArray);
        $travelArray = array_values($travelArray);
        $companyArray=implode(",", $companyArray);
        $travelArray=implode(",", $travelArray);
        $creditdateArray = array_values($creditdateArray);

    $sql5 = "exec company__revenue__chart";
    $res5 = $this->db->query($sql5);
    foreach($res5->result_array() as $row5){
      array_push($companyname, $row5['Company']);
      array_push($companyAmount, $row5['amount']);
    }

    $companyAmount = array_values($companyAmount);
    $companyAmount = implode(",", $companyAmount);
    $companyname = array_values($companyname);
  ?>

  <script>
    const xValues = [<?php echo '"' . implode('","', $fordates) . '"'; ?>];
    const yValues = [<?php echo implode(",", $values); ?>];
    new Chart("myChart", {
      type: "line",
      lineThickness: 1,
      data: {
        labels: xValues,
        datasets: [{
          fill: false,
          lineTension: 0,
          borderColor: "white",
          backgroundColor: "#00bcd4",
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Room Revenue - Last 15 Days',
          fontColor: "#FFF",
        },
        legend: { display: false },
        scales: {
          xAxes: [{
            ticks: { display: false }, gridLines: {
              display: false
            }, scaleLabel: {
              display: true,
              labelString: 'Date',
              fontColor: "white",
            }
          }],
          yAxes: [{
            ticks: { min: 500, max: 100000, display: false }, gridLines: {
              display: false
            }, scaleLabel: {
              display: true,
              labelString: 'Amount',
              fontColor: "white",
            }
          }],
        },

      }
    });

    const xValue = [<?php echo '"' . implode('","', $datesArray) . '"'; ?>];
    const yValue = [<?php echo implode(",", $countArray); ?>];
    new Chart("ReserveCount", {
      type: "line",
      lineThickness: 1,
      animationEnabled: true,
      data: {
        labels: xValue,
        datasets: [{
          fill: false,
          lineTension: 0,
          borderColor: "white",
          backgroundColor: "rgb(0,206,209)",
          data: yValue
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Reservation - Last 15 Days',
          fontColor: "#FFF",
        },
        legend: { display: false },
        scales: {
          xAxes: [{
            ticks: { display: false }, gridLines: {
              display: false
            }, scaleLabel: {
              display: true,
              labelString: 'Date',
              fontColor: "white",
            }
          }],
          yAxes: [{
            ticks: { min: 1, max: 5, display: false }, gridLines: {
              display: false
            }, scaleLabel: {
              display: true,
              labelString: 'Count',
              fontColor: "white",
            }
          }],
        }
      }
    });


    var ctx = document.getElementById("Totalrevenue");
    var chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [
          {
            data: [<?php echo $dayAmount; ?>, <?php echo $monthAmount; ?>, <?php echo $yearAmount; ?>],
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              '#279AF1',
            ],

          },
        ],
        labels: ['Day', 'Month', 'Year'],
      },
      options: {
        legend: {
          position: 'bottom'
        },
        title: {
          display: true,
          text: 'Room Revenue',
          font: {
            color: 'black',
            weight: 'bold',
            size: 50,
          }
        },
      },
      plugins: {
        datalabels: {
          color: '#36A2EB'
        }
      },
    });


var barChartData = {
  labels: [
   <?php echo '"' . implode('","', $creditdateArray) . '"'?>
  ],
  datasets: [
    {
      label: "company",
      backgroundColor: "pink",
      borderColor: "red",
      borderWidth: 1,

      data: [<?php echo $companyArray;?>]
    },
    {
      label: "TravelAgent",
      backgroundColor: "lightblue",
      borderColor: "blue",
      borderWidth: 1,
      data: [<?php echo $travelArray;?>]
    }
  ]
};

// var chartOptions = {
//   responsive: true,
//   legend: {
//     position: "top"
//   },
//   title: {
//     display: true,
//     text: "Company Vs TravelAgent"
//   },
//   scales: {
//     yAxes: [{
//       ticks: {
//         beginAtZero: true,
//         display:false
//       },
//       gridLines: {
//       display: true,
      
//     },
//      scaleLabel: {
//       display: true,
//       labelString: 'Amount',
//       fontColor: "black",
//     }
//     }],
//     xAxes: [{
//       ticks: {
//         beginAtZero: true,
//         display:false
//       },
//       gridLines: {
//       display: false
//     },
//      scaleLabel: {
//       display: true,
//       labelString: 'Date',
//       fontColor: "black",
//     }
//     }]
//   }
// }

window.onload = function() {
  var ctx = document.getElementById("verticalbar").getContext("2d");
  window.myBar = new Chart(ctx, {
    type: "bar",
    data: barChartData,
    options: chartOptions
  });
};


var ctx = document.getElementById("companyrevenue");
    var chart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [
          {
            data: [<?php echo $companyAmount;?>],
            backgroundColor: [
              '#0E5551',
              '#E71F3C',
              '#F7653E',
              '#2C2A52',
              '#FFD402'
            ],

          },
        ],
        labels: [<?php echo '"' . implode('","', $companyname) . '"'; ?>],
      },
      options: {
        legend: {
          position: 'bottom'
        },
        title: {
          display: true,
          text: 'Company Revenue',
          font: {
            color: 'White',
            weight: 'bold',
            size: 50,
          }
        },
      },
      plugins: {
        datalabels: {
          color: '#36A2EB'
        }
      },
    });


  </script>

  <?php
  $this->pfrm->FrmFoot();
  $this->pweb->wfoot();
  $this->pcss->wjs($F_Ctrl);
  $this->licscript->LicenPopUp($this->Myclass);
  $this->licscript->LicFooter();
   $this->pweb->sms_footer($this->Menu);
  ?>