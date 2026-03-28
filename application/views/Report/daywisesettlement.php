<?php
/**
 * DAY SETTLEMENT REPORT — THE BEE HIVES | WELBECK BY THE BEE HIVES
 * SQL Server : 164.52.195.176\sqlexpress  |  DB: welbeck
 *
 * FURTHER ADVANCE  join path:
 *   trans_receipt_mas.roomgrcid → trans_roomdet_det.roomgrcid
 *   → trans_roomdet_det.roomid → roommas.roomid → roommas.roomno
 *
 * CHKOUT SETTLEMENT join path (confirmed):
 *   trans_checkout_mas.roomid → Mas_Room.room_id → Mas_Room.roomno
 *
 * CHKOUT key columns (confirmed):
 *   checkoutno, checkoutdate, Noofpersons, roomid
 */

/* ══════════════════════════════════════════════
   1. DATABASE CONNECTION
══════════════════════════════════════════════ */
$db_server   = '164.52.195.176\sqlexpress';
$db_user     = 'sa';
$db_pass     = 'Mgenn@123';
$db_name     = 'welbeck';

$connectionInfo = [
    "Database"               => $db_name,
    "UID"                    => $db_user,
    "PWD"                    => $db_pass,
    "CharacterSet"           => "UTF-8",
    "TrustServerCertificate" => true,
];

$conn = sqlsrv_connect($db_server, $connectionInfo);

if (!$conn) {
    echo "<pre style='color:red;font-size:13px;'><b>SQL Connection Failed:</b>\n";
    print_r(sqlsrv_errors());
    echo "</pre>";
    exit;
}

/* ══════════════════════════════════════════════
   2. DATE FILTER
══════════════════════════════════════════════ */
$report_date      = isset($_GET['report_date'])      ? $_GET['report_date']      : date('Y-m-d');
$report_date_from = isset($_GET['report_date_from']) ? $_GET['report_date_from'] : date('Y-m-d', strtotime($report_date . ' -1 day'));
$report_date_to   = isset($_GET['report_date_to'])   ? $_GET['report_date_to']   : $report_date;
$display_date     = date('d/m/Y', strtotime($report_date_from)) . ' - ' . date('d/m/Y', strtotime($report_date_to));

/* ══════════════════════════════════════════════
   3. HELPERS
══════════════════════════════════════════════ */
function fetchAll($conn, $sql, $params = []) {
    $stmt = sqlsrv_query($conn, $sql, $params);
    if (!$stmt) {
        echo "<pre style='color:red;padding:6px;border:1px solid red;'>
<b>Query Error:</b>\n";
        print_r(sqlsrv_errors());
        echo "\n<b>SQL:</b>\n$sql\n</pre>";
        return [];
    }
    $rows = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $rows[] = $row;
    }
    sqlsrv_free_stmt($stmt);
    return $rows;
}

function n($v)  { return is_null($v) ? '' : (is_numeric($v) && $v == 0 ? '0' : $v); }
function nz($v) { return (is_null($v) || $v === '') ? 0 : floatval($v); }

/* ══════════════════════════════════════════════════════════════
   4A. FURTHER ADVANCE
   RNo/Pax — CONFIRMED path:
   trans_receipt_mas.roomgrcid
     → trans_roomdet_det.roomgrcid  (group link)
       → trans_roomdet_det.roomid
         → Mas_Room.room_id → Mas_Room.roomno
   Date filter: BETWEEN date_from AND date_to (range)
══════════════════════════════════════════════════════════════ */
$sql_advance = "
    SELECT
        trm.receipt_no                              AS bill_no,
        CONVERT(varchar(5),trm.receipt_time,108)    AS rec_time,
        rm.roomno                                   AS room_no,
        ISNULL(trd.no_of_pax, 0)                   AS pax,
        ISNULL(trm.guest_name,  '')                 AS guest_name,
        ISNULL(trm.total_amt,   0)                  AS amount,
        ISNULL(trm.total_amt,   0)                  AS t_amount,
        ISNULL(trm.cash_amt,    0)                  AS cash,
        ISNULL(trm.cheque_amt,  0)                  AS cheque,
        ISNULL(trm.card_amt,    0)                  AS cr_card,
        ISNULL(trm.net_amt,     0)                  AS net,
        ISNULL(trm.room_amt,    0)                  AS to_room,
        ISNULL(trm.company_amt, 0)                  AS company,
        ISNULL(trm.upi_amt,     0)                  AS upi,
        ISNULL(trm.adj_amt,     0)                  AS adj_amt,
        ISNULL(trm.refund_amt,  0)                  AS refund,
        ISNULL(trm.user_name,   '')                 AS [user],
        CONVERT(varchar(5),trm.receipt_time,108)    AS [time],
        ISNULL(trm.remarks,     '')                 AS remarks
    FROM  trans_receipt_mas trm
    INNER JOIN trans_roomdet_det trd ON trd.roomgrcid = trm.roomgrcid
    INNER JOIN Mas_Room rm            ON rm.room_id   = trd.roomid
    WHERE CAST(trm.receipt_date AS DATE) BETWEEN ? AND ?
    ORDER BY trm.receipt_time ASC
";
$advance_rows = fetchAll($conn, $sql_advance, [$report_date_from, $report_date_to]);

/* ══════════════════════════════════════════════════════════════
   4B. CHKOUT SETTLEMENT
   RNo/Pax — CONFIRMED path:
   trans_checkout_mas.roomid → Mas_Room.room_id → Mas_Room.roomno
   Key columns: checkoutno, checkoutdate, Noofpersons
   Date filter: BETWEEN date_from AND date_to (range, not single date)
══════════════════════════════════════════════════════════════ */
$sql_checkout = "
    SELECT
        tcm.checkoutno                              AS bill_no,
        CONVERT(varchar(5),tcm.checkouttime,108)    AS rec_time,
        rm.roomno                                   AS room_no,
        ISNULL(tcm.Noofpersons, 0)                  AS pax,
        ISNULL(tcm.guest_name,  '')                 AS guest_name,
        ISNULL(tcm.total_amt,   0)                  AS amount,
        ISNULL(tcm.total_amt,   0)                  AS t_amount,
        ISNULL(tcm.cash_amt,    0)                  AS cash,
        ISNULL(tcm.cheque_amt,  0)                  AS cheque,
        ISNULL(tcm.card_amt,    0)                  AS cr_card,
        ISNULL(tcm.net_amt,     0)                  AS net,
        ISNULL(tcm.room_amt,    0)                  AS to_room,
        ISNULL(tcm.company_amt, 0)                  AS company,
        ISNULL(tcm.upi_amt,     0)                  AS upi,
        ISNULL(tcm.adj_amt,     0)                  AS adj_amt,
        ISNULL(tcm.refund_amt,  0)                  AS refund,
        ISNULL(tcm.user_name,   '')                 AS [user],
        CONVERT(varchar(5),tcm.checkouttime,108)    AS [time],
        ISNULL(tcm.remarks,     '')                 AS remarks
    FROM  trans_checkout_mas tcm
    INNER JOIN Mas_Room rm ON rm.room_id = tcm.roomid
    WHERE CAST(tcm.checkoutdate AS DATE) BETWEEN ? AND ?
    ORDER BY tcm.checkoutno ASC
";
$checkout_rows = fetchAll($conn, $sql_checkout, [$report_date_from, $report_date_to]);

/* ══════════════════════════════════════════════
   4C. DAY BOOK QUERY
══════════════════════════════════════════════ */
$sql_daybook = "
    SELECT
        ISNULL(db.voucher_no,   '')                         AS bill_no,
        ISNULL(db.voucher_type, '')                         AS rno_pax,
        ISNULL(db.particulars,  ISNULL(db.narration,''))    AS guest_name,
        ISNULL(db.amount, 0)                                AS amount,
        ISNULL(db.amount, 0)                                AS t_amount,
        ISNULL(db.cash_amt,   0)                            AS cash,
        ISNULL(db.cheque_amt, 0)                            AS cheque,
        ISNULL(db.card_amt,   0)                            AS cr_card,
        0 AS net, 0 AS to_room, 0 AS company,
        ISNULL(db.upi_amt, 0)                               AS upi,
        0 AS adj_amt, 0 AS refund,
        ISNULL(db.created_by, ISNULL(db.user_name,''))      AS [user],
        CONVERT(varchar(5), db.entry_time, 108)             AS [time],
        ISNULL(db.remarks, '')                              AS remarks
    FROM  trans_daybook db
    WHERE CAST(db.entry_date AS DATE) = ?
    ORDER BY db.entry_time ASC
";

$daybook_rows = fetchAll($conn, $sql_daybook, [$report_date]);

/* ══════════════════════════════════════════════
   5. COMPUTE TOTALS
══════════════════════════════════════════════ */
function sectionTotals($rows) {
    $t = ['amount'=>0,'t_amount'=>0,'cash'=>0,'cheque'=>0,'cr_card'=>0,
          'net'=>0,'to_room'=>0,'company'=>0,'upi'=>0,'adj_amt'=>0,'refund'=>0];
    foreach ($rows as $r) {
        foreach ($t as $k => &$v) { $v += nz($r[$k] ?? 0); }
    }
    return $t;
}

$fa_tot  = sectionTotals($advance_rows);
$chk_tot = sectionTotals($checkout_rows);
$db_tot  = sectionTotals($daybook_rows);

$pm_keys = ['cash','cheque','cr_card','net','to_room','company','upi','adj_amt','refund'];
$pm_tot  = [];
foreach ($pm_keys as $k) { $pm_tot[$k] = $fa_tot[$k] + $chk_tot[$k]; }

$day_tot = [];
foreach (array_keys($fa_tot) as $k) {
    $day_tot[$k] = $fa_tot[$k] + $chk_tot[$k] + $db_tot[$k];
}

sqlsrv_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Day Settlement Report – The Bee Hives</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; font-size: 11px; background: #f0f0f0; padding: 10px; }
  .page { background: #fff; width: 1200px; margin: 0 auto; padding: 18px; box-shadow: 0 2px 12px rgba(0,0,0,0.15); }

  /* HEADER */
  .report-title    { text-align:center; font-size:16px; font-weight:bold; letter-spacing:1px; margin-bottom:2px; }
  .report-subtitle { text-align:center; font-size:13px; font-weight:bold; margin-bottom:2px; }
  .report-date     { text-align:center; font-size:11px; margin-bottom:6px; }

  /* DATE FILTER BAR */
  .filter-bar { display:flex; gap:10px; align-items:center; margin-bottom:10px; }
  .filter-bar input[type=date] { padding:4px 8px; font-size:12px; border:1px solid #aaa; border-radius:4px; }
  .btn { padding:6px 14px; border:none; border-radius:4px; cursor:pointer; font-size:12px; font-weight:bold; }
  .btn-go    { background:#3a7bd5; color:#fff; }
  .btn-print { background:#27ae60; color:#fff; }

  /* TABLE */
  table { width:100%; border-collapse:collapse; }
  th, td { border:1px solid #555; padding:2px 4px; text-align:center; white-space:nowrap; font-size:10px; }
  th { background:#d6e4f0; font-weight:bold; font-size:10px; }
  td.left { text-align:left; }

  .section-header td { background:#c8daf5; font-weight:bold; font-size:11px; text-align:center; letter-spacing:.5px; padding:4px; }
  .total-row  td { background:#eaf3fb; font-weight:bold; }
  .paymode-row td { background:#fff9e6; font-weight:bold; }
  .grand-row  td { background:#b8d4ee; font-weight:bold; font-size:11px; }
  .super-row  td { background:#9bbee0; font-weight:bold; font-size:11px; }
  .daybook-row td { background:#f0fff0; }
  .billdate-row td { background:#f9f9f9; font-weight:bold; }

  .zero { color:#bbb; }

  /* SIGNATURE */
  .sig-area { display:flex; justify-content:space-between; margin-top:18px; padding:0 20px; }
  .sig-box  { text-align:center; width:120px; }
  .sig-line { border-top:1px solid #333; margin-top:40px; padding-top:4px; font-size:10px; font-weight:bold; }

  @media print {
    body { background:#fff; padding:0; }
    .page { box-shadow:none; width:100%; }
    .filter-bar, .no-print { display:none !important; }
    th, .section-header td, .total-row td, .paymode-row td, .grand-row td, .super-row td, .daybook-row td {
      -webkit-print-color-adjust:exact; print-color-adjust:exact;
    }
  }
</style>
</head>
<body>
<div class="page">

  <!-- FILTER BAR -->
  <div class="filter-bar no-print">
    <form method="GET" style="display:flex;gap:8px;align-items:center;">
      <label style="font-weight:bold;">Report Date:</label>
      <input type="date" name="report_date" value="<?= htmlspecialchars($report_date) ?>">
      <button type="submit" class="btn btn-go">🔍 Load Report</button>
      <button type="button" class="btn btn-print" onclick="window.print()">🖨 Print</button>
    </form>
  </div>

  <!-- HEADER -->
  <div class="report-title">THE BEE HIVES &nbsp;|&nbsp; WELBECK BY THE BEE HIVES</div>
  <div class="report-subtitle">Day Settlement Report</div>
  <div class="report-date">As on Date : <?= $display_date ?></div>

  <table>
    <!-- ── COLUMN HEADERS ── -->
    <thead>
      <tr>
        <th style="width:145px;">Bill No / Recpt Time</th>
        <th style="width:70px;">RNo/Pax</th>
        <th style="width:160px;">GuestNm/Details</th>
        <th style="width:52px;">Amount</th>
        <th style="width:52px;">T.Amount</th>
        <th style="width:42px;">Cash</th>
        <th style="width:42px;">Cheque</th>
        <th style="width:42px;">CR Card</th>
        <th style="width:42px;">Net</th>
        <th style="width:42px;">ToRoom</th>
        <th style="width:52px;">Company</th>
        <th style="width:42px;">UPI</th>
        <th style="width:42px;">Adj.Amt</th>
        <th style="width:42px;">Refund</th>
        <th style="width:65px;">User</th>
        <th style="width:38px;">Time</th>
        <th>Remarks</th>
      </tr>
    </thead>
    <tbody>

      <!-- BILL DATE -->
      <tr class="billdate-row">
        <td colspan="17"><b>BILLDATE :</b> <?= $display_date ?></td>
      </tr>

      <!-- ════════ FURTHER ADVANCE ════════ -->
      <tr class="section-header"><td colspan="17">FURTHER ADVANCE</td></tr>

      <?php if (empty($advance_rows)): ?>
      <tr><td colspan="17" style="text-align:center;color:#888;padding:6px;">No Advance records found for <?= $display_date ?></td></tr>
      <?php else: ?>
      <?php foreach ($advance_rows as $r): ?>
      <tr>
        <td class="left"><?= htmlspecialchars($r['bill_no']) ?></td>
        <td><?= $r['room_no'] ? htmlspecialchars($r['room_no']).' - '.htmlspecialchars($r['pax'] ?? '00') : '<span style="color:#bbb">—</span>' ?></td>
        <td class="left"><?= htmlspecialchars($r['guest_name']) ?></td>
        <td class="<?= $r['amount']==0?'zero':'' ?>"><?= n($r['amount']) ?></td>
        <td class="<?= $r['t_amount']==0?'zero':'' ?>"><?= n($r['t_amount']) ?></td>
        <td class="<?= $r['cash']==0?'zero':'' ?>"><?= n($r['cash']) ?></td>
        <td class="<?= $r['cheque']==0?'zero':'' ?>"><?= n($r['cheque']) ?></td>
        <td class="<?= $r['cr_card']==0?'zero':'' ?>"><?= n($r['cr_card']) ?></td>
        <td class="<?= $r['net']==0?'zero':'' ?>"><?= n($r['net']) ?></td>
        <td class="<?= $r['to_room']==0?'zero':'' ?>"><?= n($r['to_room']) ?></td>
        <td class="<?= $r['company']==0?'zero':'' ?>"><?= n($r['company']) ?></td>
        <td class="<?= $r['upi']==0?'zero':'' ?>"><?= n($r['upi']) ?></td>
        <td class="<?= $r['adj_amt']==0?'zero':'' ?>"><?= n($r['adj_amt']) ?></td>
        <td class="<?= $r['refund']==0?'zero':'' ?>"><?= n($r['refund']) ?></td>
        <td><?= htmlspecialchars($r['user']) ?></td>
        <td><?= htmlspecialchars($r['time']) ?></td>
        <td class="left"><?= htmlspecialchars($r['remarks']) ?></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>

      <!-- FA TOTAL -->
      <tr class="total-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">TOTAL</td>
        <td><?= $fa_tot['amount'] ?></td>
        <td><?= $fa_tot['t_amount'] ?></td>
        <td><?= $fa_tot['cash'] ?></td>
        <td><?= $fa_tot['cheque'] ?></td>
        <td><?= $fa_tot['cr_card'] ?></td>
        <td><?= $fa_tot['net'] ?></td>
        <td><?= $fa_tot['to_room'] ?></td>
        <td><?= $fa_tot['company'] ?></td>
        <td><?= $fa_tot['upi'] ?></td>
        <td><?= $fa_tot['adj_amt'] ?></td>
        <td><?= $fa_tot['refund'] ?></td>
        <td colspan="3"></td>
      </tr>

      <!-- ════════ CHKOUT SETTLEMENT ════════ -->
      <tr class="section-header"><td colspan="17">CHKOUT SETTLEMENT</td></tr>

      <?php if (empty($checkout_rows)): ?>
      <tr><td colspan="17" style="text-align:center;color:#888;padding:6px;">No Checkout records found for <?= $display_date ?></td></tr>
      <?php else: ?>
      <?php foreach ($checkout_rows as $r): ?>
      <tr>
        <td class="left"><?= htmlspecialchars($r['bill_no']) ?></td>
        <td><?= $r['room_no'] ? htmlspecialchars($r['room_no']).' - '.htmlspecialchars($r['pax'] ?? '00') : '<span style="color:#bbb">—</span>' ?></td>
        <td class="left"><?= htmlspecialchars($r['guest_name']) ?></td>
        <td class="<?= $r['amount']==0?'zero':'' ?>"><?= n($r['amount']) ?></td>
        <td class="<?= $r['t_amount']==0?'zero':'' ?>"><?= n($r['t_amount']) ?></td>
        <td class="<?= $r['cash']==0?'zero':'' ?>"><?= n($r['cash']) ?></td>
        <td class="<?= $r['cheque']==0?'zero':'' ?>"><?= n($r['cheque']) ?></td>
        <td class="<?= $r['cr_card']==0?'zero':'' ?>"><?= n($r['cr_card']) ?></td>
        <td class="<?= $r['net']==0?'zero':'' ?>"><?= n($r['net']) ?></td>
        <td class="<?= $r['to_room']==0?'zero':'' ?>"><?= n($r['to_room']) ?></td>
        <td class="<?= $r['company']==0?'zero':'' ?>"><?= n($r['company']) ?></td>
        <td class="<?= $r['upi']==0?'zero':'' ?>"><?= n($r['upi']) ?></td>
        <td class="<?= $r['adj_amt']==0?'zero':'' ?>"><?= n($r['adj_amt']) ?></td>
        <td class="<?= $r['refund']==0?'zero':'' ?>"><?= n($r['refund']) ?></td>
        <td><?= htmlspecialchars($r['user']) ?></td>
        <td><?= htmlspecialchars($r['time']) ?></td>
        <td class="left"><?= htmlspecialchars($r['remarks']) ?></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>

      <!-- CHK TOTAL -->
      <tr class="total-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">TOTAL</td>
        <td><?= $chk_tot['amount'] ?></td>
        <td><?= $chk_tot['t_amount'] ?></td>
        <td><?= $chk_tot['cash'] ?></td>
        <td><?= $chk_tot['cheque'] ?></td>
        <td><?= $chk_tot['cr_card'] ?></td>
        <td><?= $chk_tot['net'] ?></td>
        <td><?= $chk_tot['to_room'] ?></td>
        <td><?= $chk_tot['company'] ?></td>
        <td><?= $chk_tot['upi'] ?></td>
        <td><?= $chk_tot['adj_amt'] ?></td>
        <td><?= $chk_tot['refund'] ?></td>
        <td colspan="3"></td>
      </tr>

      <!-- PAYMODE WISE TOTAL -->
      <tr class="paymode-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">PAYMODE WISE TOTAL</td>
        <td></td>
        <td></td>
        <td><?= $pm_tot['cash'] ?></td>
        <td><?= $pm_tot['cheque'] ?></td>
        <td><?= $pm_tot['cr_card'] ?></td>
        <td><?= $pm_tot['net'] ?></td>
        <td><?= $pm_tot['to_room'] ?></td>
        <td><?= $pm_tot['company'] ?></td>
        <td><?= $pm_tot['upi'] ?></td>
        <td><?= $pm_tot['adj_amt'] ?></td>
        <td><?= $pm_tot['refund'] ?></td>
        <td colspan="3"></td>
      </tr>

      <!-- ════════ DAY BOOK ════════ -->
      <tr class="section-header"><td colspan="17">DAY BOOK</td></tr>

      <?php if (empty($daybook_rows)): ?>
      <tr><td colspan="17" style="text-align:center;color:#888;padding:6px;">No Day Book records found for <?= $display_date ?></td></tr>
      <?php else: ?>
      <?php foreach ($daybook_rows as $r): ?>
      <tr class="daybook-row">
        <td class="left"><?= htmlspecialchars($r['bill_no']) ?></td>
        <td><?= htmlspecialchars($r['rno_pax']) ?></td>
        <td class="left"><?= htmlspecialchars($r['guest_name']) ?></td>
        <td><?= n($r['amount']) ?></td>
        <td><?= n($r['t_amount']) ?></td>
        <td><?= n($r['cash']) ?></td>
        <td><?= n($r['cheque']) ?></td>
        <td><?= n($r['cr_card']) ?></td>
        <td></td><td></td><td></td>
        <td><?= n($r['upi']) ?></td>
        <td></td><td></td>
        <td><?= htmlspecialchars($r['user']) ?></td>
        <td><?= htmlspecialchars($r['time']) ?></td>
        <td class="left"><?= htmlspecialchars($r['remarks']) ?></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>

      <!-- DB TOTAL -->
      <tr class="total-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">TOTAL</td>
        <td><?= $db_tot['amount'] ?></td>
        <td><?= $db_tot['t_amount'] ?></td>
        <td><?= $db_tot['cash'] ?: '' ?></td>
        <td><?= $db_tot['cheque'] ?: '' ?></td>
        <td><?= $db_tot['cr_card'] ?: '' ?></td>
        <td colspan="9"></td>
      </tr>

      <!-- DAY TOTAL -->
      <tr class="grand-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">DAY TOTAL</td>
        <td><?= $day_tot['amount'] ?></td>
        <td><?= $day_tot['t_amount'] ?></td>
        <td><?= $day_tot['cash'] ?></td>
        <td><?= $day_tot['cheque'] ?></td>
        <td><?= $day_tot['cr_card'] ?></td>
        <td><?= $day_tot['net'] ?></td>
        <td><?= $day_tot['to_room'] ?></td>
        <td><?= $day_tot['company'] ?></td>
        <td><?= $day_tot['upi'] ?></td>
        <td><?= $day_tot['adj_amt'] ?></td>
        <td><?= $day_tot['refund'] ?></td>
        <td colspan="3"></td>
      </tr>

      <!-- GRAND TOTAL -->
      <tr class="super-row">
        <td colspan="3" style="text-align:right;font-weight:bold;">GRAND TOTAL</td>
        <td><?= $day_tot['amount'] ?></td>
        <td><?= $day_tot['t_amount'] ?></td>
        <td><?= $day_tot['cash'] ?></td>
        <td><?= $day_tot['cheque'] ?></td>
        <td><?= $day_tot['cr_card'] ?></td>
        <td><?= $day_tot['net'] ?></td>
        <td><?= $day_tot['to_room'] ?></td>
        <td><?= $day_tot['company'] ?></td>
        <td><?= $day_tot['upi'] ?></td>
        <td><?= $day_tot['adj_amt'] ?></td>
        <td><?= $day_tot['refund'] ?></td>
        <td colspan="3"></td>
      </tr>

    </tbody>
  </table>

  <!-- SIGNATURE AREA -->
  <div class="sig-area">
    <div class="sig-box"><div class="sig-line">FO</div></div>
    <div class="sig-box" style="text-align:center;">
      <div style="font-size:10px;color:#555;margin-top:30px;font-style:italic;">C/F to Next Day</div>
      <div class="sig-line">ACCOUNTS</div>
    </div>
    <div class="sig-box"><div class="sig-line">CGM</div></div>
  </div>

</div><!-- end .page -->

<!--
════════════════════════════════════════════════════════
  SQL REFERENCE — CONFIRMED JOIN PATHS & COLUMN NAMES
════════════════════════════════════════════════════════

  ── FURTHER ADVANCE (CONFIRMED) ─────────────────────
  Table : trans_receipt_mas  (alias trm)
  Link  : trm.roomgrcid → trans_roomdet_det.roomgrcid
  Room  : trans_roomdet_det.roomid → Mas_Room.room_id → Mas_Room.roomno
  Pax   : trans_roomdet_det.no_of_pax
  Date  : CAST(trm.receipt_date AS DATE) BETWEEN ? AND ?  (date range)

  ── CHKOUT SETTLEMENT (CONFIRMED) ───────────────────
  Table : trans_checkout_mas  (alias tcm)
  Room  : tcm.roomid → Mas_Room.room_id → Mas_Room.roomno
  Pax   : tcm.Noofpersons
  Date  : CAST(tcm.checkoutdate AS DATE) BETWEEN ? AND ?  (date range)
  Key columns confirmed:
    checkoutno    → checkout bill number
    checkoutdate  → checkout date
    checkouttime  → checkout time
    Noofpersons   → number of guests (pax)
    roomid        → FK to Mas_Room.room_id

  ── URL parameters ───────────────────────────────────
  ?report_date=2026-03-26              (single date, sets to_date)
  ?report_date_from=2026-03-25&report_date_to=2026-03-26  (explicit range)
════════════════════════════════════════════════════════
-->
</body>
</html>
