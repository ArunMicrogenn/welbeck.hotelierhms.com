<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Registration Card - Welbeck</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: Arial, sans-serif;
    font-size: 11px;
    background: #bbb;
    display: flex;
    justify-content: center;
    padding: 30px;
  }
  .card {
    background: #fff;
    width: 710px;
    padding: 16px 18px;
    border: 1px solid #777;
    box-shadow: 0 2px 10px rgba(0,0,0,0.22);
  }

  /* HEADER */
  .header {
    text-align: center;
    margin-bottom: 8px;
    line-height: 1.6;
    font-size: 11px;
  }
  .header .reg-title {
    font-size: 13px;
    font-weight: bold;
    letter-spacing: 1.5px;
    margin-top: 3px;
  }

  /* TABLE — single unified */
  .reg-table { width: 100%; border-collapse: collapse; }
  .reg-table td {
    border: 1px solid #444;
    padding: 3px 6px;
    vertical-align: middle;
    font-size: 11px;
    height: 20px;
  }

  /* 4 columns */
  .c1 { width: 118px; }
  .c2 { width: 162px; }
  .c3 { width: 148px; }
  .c4 { }

  .lbl  { font-weight: 600; white-space: nowrap; }
  .val  { background: #fff; }
  .empty { background: #fff; }   /* empty address rows */

  .sec-hdr {
    font-weight: bold;
    text-align: center;
    background: #f0f0f0;
    font-size: 10.5px;
    height: 18px;
  }

  /* Arrival/Departure/RegCard — plain outer border only, like Terms */
  .arr-dep-box {
    border: 1px solid #444;
    border-top: none;
    padding: 5px 10px 5px 8px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    min-height: 46px;
  }
  .arr-dep-left {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding-top: 2px;
  }
  .arr-dep-left span { font-weight: 600; font-size: 11px; }
  .arr-dep-right {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 200px;
    padding-top: 2px;
  }
  .reg-line {
    font-weight: 600;
    font-size: 11px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .reg-line input[type="checkbox"] { width: 13px; height: 13px; }

  /* Terms */
  .terms {
    border: 1px solid #444;
    border-top: none;
    padding: 5px 8px;
    font-size: 10.5px;
    line-height: 1.65;
  }
  .terms strong { display: block; margin-bottom: 2px; font-size: 11px; }

  /* Signature */
  .sig-table { width: 100%; border-collapse: collapse; }
  .sig-table td {
    border: 1px solid #444;
    border-top: none;
    text-align: center;
    font-weight: bold;
    font-size: 11.5px;
    padding: 5px 4px 38px 4px;
    vertical-align: top;
  }
</style>
</head>
<body>
<div class="card">

  <!-- HEADER -->
  <div class="header">
    <strong>Welbeck</strong><br>
    Unit of The Beehives<br>
    GSTIN: 33AALFT4448E1Z5
    <div class="reg-title">REGISTRATION CARD</div>
  </div>

  <!-- SINGLE UNIFIED TABLE -->
  <table class="reg-table">

    <!-- R1: Grcno | SOURCE -->
    <tr>
      <td class="c1 lbl">Grcno</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">SOURCE</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R2: Guest Name | Passport Details header -->
    <tr>
      <td class="c1 lbl">Guest Name</td>
      <td class="c2 val"></td>
      <td colspan="2" class="sec-hdr">Passport Details</td>
    </tr>

    <!-- R3: Company Name | Number -->
    <tr>
      <td class="c1 lbl">Company Name</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Number</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R4: Address label (TOP cell only, no rowspan) | Date of Issue -->
    <!-- "Address" text sits in the first row only — rows below are empty -->
    <!-- Row borders on all 4 address rows create the natural underlines on BOTH sides -->
    <tr>
      <td class="c1 lbl">Address</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Date of Issue</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R5: empty | Validity Till -->
    <tr>
      <td class="c1 empty"></td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Validity Till</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R6: empty | Place of Issue -->
    <tr>
      <td class="c1 empty"></td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Place of Issue</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R7: empty | Visa Details header -->
    <tr>
      <td class="c1 empty"></td>
      <td class="c2 val"></td>
      <td colspan="2" class="sec-hdr">Visa Details</td>
    </tr>

    <!-- R8: Mobile | Number -->
    <tr>
      <td class="c1 lbl">Mobile</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Number</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R9: Email | Date of Issue -->
    <tr>
      <td class="c1 lbl">Email</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Date of Issue</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R10: Room No & Type | Validity Till -->
    <tr>
      <td class="c1 lbl">Room No &amp; Type</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Validity Till</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R11: Rate Type & Tariff | Place of Issue -->
    <tr>
      <td class="c1 lbl">Rate Type &amp; Tariff</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Place of Issue</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R12: Arrival Date | Date of arrival in ind -->
    <tr>
      <td class="c1 lbl">Arrival Date</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Date of arrival in ind</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R13: Departure Date | Duration of stay in Ind -->
    <tr>
      <td class="c1 lbl">Departure Date</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Duration of stay in Ind</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R14: No of Pax | Purpose of visit -->
    <tr>
      <td class="c1 lbl">No of Pax</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Purpose of visit</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R15: Plan | Date Of Birth Date -->
    <tr>
      <td class="c1 lbl">Plan</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Date Of Birth Date</td>
      <td class="c4 val"></td>
    </tr>

    <!-- R16: Advance | Anniversary Date -->
    <tr>
      <td class="c1 lbl">Advance</td>
      <td class="c2 val"></td>
      <td class="c3 lbl">Anniversary Date :</td>
      <td class="c4 val"></td>
    </tr>

  </table>

  <!-- ARRIVAL / DEPARTURE / REG CARD — plain box, NO inner lines like Terms -->
  <div class="arr-dep-box">
    <div class="arr-dep-left">
      <span>Arrival From :</span>
      <span>Departure From :</span>
    </div>
    <div class="arr-dep-right">
      <div class="reg-line">
        Reg Card Update :&nbsp;<input type="checkbox">
      </div>
    </div>
  </div>

  <!-- TERMS AND CONDITIONS -->
  <div class="terms">
    <strong>Terms and Conditions</strong>
    1. Key handover @ reception to completed the checkout procedure.<br>
    2. Missing of keys will effect charges as per the management policy.<br>
    3. Guest are reminded that the hotel official departure time is 24 hours. Late departure can be arranged on request through the management, subject to room availability.
  </div>

  <!-- SIGNATURE ROW — FO | Tax Manager | PM | GUEST SIGNATURE -->
  <table class="sig-table">
    <tr>
      <td style="width:18%;">FO</td>
      <td style="width:25%;">Tax Manager</td>
      <td style="width:22%;">PM</td>
      <td style="width:35%;">GUEST SIGNATURE</td>
    </tr>
  </table>

</div>
</body>
</html>
