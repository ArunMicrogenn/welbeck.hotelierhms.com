<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
// $this->pweb->wtop();
$this->pweb->Dashboard();
$this->pweb->sidebar_style();
// $this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);

?>  



<body>



<?php 
date_default_timezone_set('Asia/Kolkata');

$currdate =  date('Y-m-d'); ?>


<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="overallModal" tabindex="-1" role="dialog" aria-labelledby="overallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="overallModalLabel">
          Today's Arrival Report 
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table table-bordered table-hover">
          <tbody>
            <?php 
              $i = 1;  
             
               $qry = "exec TodaysArrival '" . $currdate . "','" . $currdate . "'";
              $exec = $this->db->query($qry);
              $pax = 0;
              $advance = $exec->num_rows();

              if ($advance != 0) {
                echo '<tr style="background-color:#c9c6c6;">';     
                echo '<td style=" text-align:center;" >S.No</td>';
                echo '<td style="text-align: center;">Checkin Date</td>';
                echo '<td style="text-align: center;">In Time</td>';
                echo '<td style="text-align: center;">Guest Name</td>'; 
                echo '<td style="text-align: center;">Room Type</td>';
                echo '<td style="text-align: center;">Room No</td>';
                echo '<td style="text-align: center;">Pax</td>';
                echo '<td style="text-align: center;">Company</td>';
                echo '<td style="text-align: center;">City</td>'; 
                echo '<td style="text-align: center;">Room Rent</td>';     
                echo '</tr>'; 
              }

              foreach ($exec->result_array() as $rows) {
                echo '<tr>';    
                echo '<td style="text-align: center;">' . $i++ . '</td>';
                echo '<td style="text-align: center;">' . date('d-m-Y', strtotime($rows['Checkindate'])) . '</td>';
                echo '<td style="text-align: center;">' . date('H:i', strtotime($rows['checkintime'])) . '</td>';                
                echo '<td style="text-align: left;">' . $rows['Guestname'] . '</td>';
                echo '<td style="text-align: left;">' . $rows['Roomtype'] . '</td>';
                echo '<td style="text-align: left;">' . $rows['Roomno'] . '</td>';
                echo '<td style="text-align: right;">' . $rows['Noofpersons'] . '</td>';
                echo '<td style="text-align: center;">' . $rows['company'] . '</td>';
                echo '<td style="text-align: left;">' . $rows['City'] . '</td>';
                echo '<td style="text-align: right;">' . $rows['roomrent'] . '</td>';
                $pax += $rows['Noofpersons'];
              }

              if ($advance != 0) {
                echo '<tr><td class="text-bold" colspan="15" style="text-align: center;">&nbsp;</td></tr>'; 
                echo '<tr>';
                echo '<td colspan="3" class="text-bold" style="text-align: left;">Total Checkin</td>';
                echo '<td style="text-align: right;" colspan="2">' . ($i - 1) . '</td>';
                echo '<td colspan="10" style="text-align: right;"></td>'; 
                echo '</tr>'; 
                echo '<tr>';
                echo '<td colspan="3" style="text-align: left;" class="text-bold">Total Pax</td>';
                echo '<td style="text-align: right;" colspan="2">' . $pax . '</td>';
                echo '<td colspan="10"></td>';
                echo '</tr>'; 
              }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>



  <!-- MAIN -->
  <main class="main">
  

    <!-- GRID -->
    <section class="grid">

      <!-- Over-All Revenue -->
<section class="card area-revenue">
  <h3 class="card__title">Over-All Revenue</h3>
  <div class="chart-placeholder">
    <canvas id="revenueChart"></canvas>
  </div>
  <div style="margin-top:18px;">
    <div class="space">
      <button class="btn btn--outline" onclick="loadChart('15', this)">Last-15 Days</button>
      <button class="btn btn--filled" onclick="loadChart('4', this)">Last 4-Months</button>
      <button class="btn btn--outline" onclick="loadChart('12', this)">Last Year</button>
    </div>
  </div>
</section>

      <!-- Room-Revenue -->
<section class="card area-room-revenue">
  <h3 class="card__title">Room-Revenue <span class="card__sub">(Last 2 Months)</span></h3>
  <div class="chart-placeholder">
    <canvas id="roomRevenueChart"></canvas>
  </div>
  <div style="margin-top:12px;font-size:var(--fs-12);color:#888;">June - July</div>
</section>

      <!-- Reservation Type -->
   <section class="card area-reservation">
  <h3 class="card__title">Reservation Type <span class="card__sub">(Last-15 Days)</span></h3>
  <div class="chart-placeholder" style="height:180px;">
    <canvas id="reservationTypeChart"></canvas>
  </div>
  <ul class="horizontal-list">
    <li><span style="color: #4e73df;">●</span> Online</li>
    <li><span style="color: #e74a3b;">●</span> Call</li>
    <li><span style="color: #36b9cc;">●</span> Others</li>
  </ul>
</section>


      <!-- Strip -->
      <section class=" card area-strip strip">
          <table class="table">
             <thead>
               <tr>
                 <th>OTA Guest</th>
                 <th>Guest In-House</th>
                 <th>Total Guest</th>
                 <th>Check-in Cancel</th>
                 <th>Check-out Cancel</th>
               </tr>
             </thead>
             <tbody>
                <tr>
                  <td>12</td>
                  <td>36</td>
                  <td>50</td>
                  <td>05</td>
                  <td>10</td>
                </tr>
             </tbody>
     </table>
      </section>

      <!-- Checkin -->
      <section class="card area-checkin card--center">
              <?php  $tcin = "exec TodaysCheckin_Dashboard '".$currdate."' ";
        $texec = $this->db->query($tcin)->row_array(); 
         $tcin_count = $texec['tcnt'];
          ?>
        <div class="card__title">Today's Check-In <br><span class="card__sub">Higher than last-10days</span></div>
        <div class="value"><?php echo $tcin_count ?> <small style="color:rgb(0, 172, 26);">(42%)↑</small></div>
        <button class="btn btn--outline"  id="tcheckin" style="margin-top:18px;">View Over-All</button>
      </section>

      <!-- Checkout -->
       
      <section class="card area-checkout card--center">
        <?php  $tcout = "exec Todaycheckout_Dashboard '".$currdate."' ";
        $texeout = $this->db->query($tcout)->row_array(); 
         $tcout_count = $texeout['chkoutcnt'];
          ?>
        <div class="card__title">Today's Check-Out <br><span class="card__sub">Higher than last-10days</span></div>
        <div class="value"><?php echo $tcout_count ?> <small style="color:rgb(236, 15, 15);">(14%)↑</small></div>
        <button class="btn btn--outline" id="tcheckout"  style="margin-top:18px;">View Over-All</button>
      </section>

      <!-- Room's Available -->
       <?php $room = "select count(*) as roomcount from mas_room ";
               $exeroom = $this->db->query($room)->row_array(); 
         $roomcount = $exeroom['roomcount']; 



         $avail = "select isnull(sum(Availablerooms),0) as Availroom from trans_roomavailability_chart where avdate = '".$currdate."'";
         $availexec = $this->db->query($avail)->row_array();
         $avail_count = $availexec['Availroom'];
         
         
         ?>

      <section class="card area-available card--dark card--center">
        <div class="value"><?php echo $avail_count ?><small>/<?php echo $roomcount ?></small></div>
        <div style="margin-top:8px;">Room's Available</div>
      </section>

    <?php   $res = "exec reservation_Dashboard '".$currdate."' ";
  $resqry =  $this->db->query($res)->row_array();
  $inhouse = $resqry['count']; ?>

      <section class="card area-booked card--dark card--center">
        <div class="value"><?php echo $inhouse ?><small>/<?php echo $roomcount ?></small></div>
        <div style="margin-top:8px;">Room's Booked</div>
      </section>

  <?php $inuse = "exec inhouse_Dashboard ";
  $inqry =  $this->db->query($inuse)->row_array();
  $inhouse = $inqry['incnt']; ?>
      <section class="card area-inuse card--dark card--center">
        <div class="value"><?php echo $inhouse ?><small>/<?php echo $roomcount ?></small></div>
        <div style="margin-top:8px;">Room-In Use</div>
      </section>

      <!-- Connection -->
      <section class="card area-connection">
        <h3 class="card__title">Connection</h3>
        <div class="chart-placeholder" style="height:160px;">
        </div>
      </section>

      <!-- Table -->
     <section class="card area-table">

  <div class="table-container">
    <table class="table scrollable-table">
      <thead>
        <tr>
          <th>Room No</th>
          <th>Room Type</th>
          <th>Guest Name</th>
          <th>Exp. Time</th>
          <th>Contact Number</th>
          <th>Pax</th>
          <th>Invoice</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>103</td>
          <td>Non-ac</td>
          <td>Mr.Arun</td>
          <td>10:33:38</td>
          <td>82220 41118</td>
          <td>02</td>
          <td><button class="btn btn--tonal" style="padding:8px 14px;">Send</button></td>
        </tr>
        <tr>
          <td>104</td>
          <td>Non-ac</td>
          <td>Mr.Padmanaban</td>
          <td>12:42:14</td>
          <td>82220 41119</td>
          <td>02</td>
          <td><button class="btn btn--tonal" style="padding:8px 14px;">Send</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</section>


    </section>
  </main>
</body>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<script>
  document.getElementById("tcheckin").addEventListener("click", function () {
    $('#overallModal').modal('show');
  });
</script>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  let chart;

  const chartData = {
    '15': {
      labels: ['60K', '80K', '1L', '1.5L', '2L'],
      datasets: [
        { label: 'June', data: [20, 25, 30, 45, 55], backgroundColor: '#FDB45C' },
        { label: 'July', data: [30, 35, 40, 55, 65], backgroundColor: '#46BFBD' },
      ]
    },
    '4': {
      labels: ['60K', '80K', '1L', '1.5L', '2L'],
      datasets: [
        { label: 'March', data: [35, 40, 45, 50, 55], backgroundColor: '#949FB1' },
        { label: 'April', data: [30, 25, 20, 15, 10], backgroundColor: '#F7464A' },
        { label: 'May', data: [25, 20, 30, 40, 50], backgroundColor: '#46BFBD' },
        { label: 'June', data: [20, 30, 40, 60, 90], backgroundColor: '#FDB45C' },
      ]
    },
    '12': {
      labels: ['Q1', 'Q2', 'Q3', 'Q4'],
      datasets: [
        { label: '2024', data: [120, 150, 180, 200], backgroundColor: '#4D5360' }
      ]
    }
  };

  function loadChart(range, button) {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    if (chart) chart.destroy();

    // Update button styles
    document.querySelectorAll('.area-revenue .btn').forEach(btn => {
      btn.classList.remove('btn--filled');
      btn.classList.add('btn--outline');
    });

    button.classList.add('btn--filled');
    button.classList.remove('btn--outline');

    chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartData[range].labels,
        datasets: chartData[range].datasets
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 20
            }
          }
        },
        plugins: {
          legend: { position: 'top' },
          tooltip: { enabled: true }
        }
      }
    });
  }

  // Load default chart (4 months) on page load
  window.addEventListener('DOMContentLoaded', () => {
    const defaultBtn = document.querySelector('.area-revenue .btn--filled');
    loadChart('4', defaultBtn);
  });
</script>
<script>
  const roomRevenueCtx = document.getElementById('roomRevenueChart').getContext('2d');

  // Gradient fills
  const gradientBlue = roomRevenueCtx.createLinearGradient(0, 0, 0, 200);
  gradientBlue.addColorStop(0, 'rgba(78, 115, 223, 0.3)');
  gradientBlue.addColorStop(1, 'rgba(78, 115, 223, 0)');

  const gradientRed = roomRevenueCtx.createLinearGradient(0, 0, 0, 200);
  gradientRed.addColorStop(0, 'rgba(231, 74, 59, 0.3)');
  gradientRed.addColorStop(1, 'rgba(231, 74, 59, 0)');

  new Chart(roomRevenueCtx, {
    type: 'line',
    data: {
      labels: ['60K', '80K', '1L', '1.5L', '2L'],
      datasets: [
        {
          label: 'June',
          data: [40, 60, 35, 70, 50],
          backgroundColor: gradientBlue,
          borderColor: 'rgba(78, 115, 223, 1)',
          fill: true,
          tension: 0, // <-- THIS makes it straight lines
          pointRadius: 0,
        },
        {
          label: 'July',
          data: [60, 80, 65, 90, 75],
          backgroundColor: gradientRed,
          borderColor: 'rgba(231, 74, 59, 1)',
          fill: true,
          tension: 0, // <-- THIS makes it straight lines
          pointRadius: 0,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: (context) => `${context.dataset.label}: ₹${context.raw}K`
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: {
            font: { size: 10 },
          }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#eee' },
          ticks: {
            callback: (value) => `${value}K`,
            font: { size: 10 }
          }
        }
      }
    }
  });
</script>

<script>
  const reservationCtx = document.getElementById('reservationTypeChart').getContext('2d');

  new Chart(reservationCtx, {
    type: 'doughnut',
    data: {
      labels: ['Online', 'Call', 'Others'],
      datasets: [{
        data: [45, 40, 15],
        backgroundColor: [
          '#4e73df', // Online
          '#e74a3b', // Call
          '#36b9cc'  // Others
        ],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '65%', // Thickness of donut
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.label}: ${context.parsed}%`;
            }
          }
        }
      },
      responsive: true,
      maintainAspectRatio: false
    }
  });
</script>




</html>
