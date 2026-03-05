<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Settlement', 'Checkout Resettlement');
$this->pfrm->FrmHead3('Settlement / Checkout Resettlement', $F_Class . "/" . 'CheckoutResettlement', $F_Class . "/" . $F_Ctrl . "_View");


?>


<?php
// $qry = "select * from trans_checkout_mas cm 
// inner join room_status rs on rs.roomid = cm.roomid
// where isnull(rs.status,'') ='Y' and snull(rs.billsettle,0)<>1 and Checkoutid='" . @$ID . "'";

$qry = "select * from trans_checkout_mas cm 
where  Checkoutid='" . @$ID . "'";

$res = $this->db->query($qry);


foreach ($res->result_array() as $row) {

  $yearPrefix = $row['yearPrefix'];
}


$no = $res->num_rows();

?>


<div class="col-sm-12" style="color:black;">
  <div class="the-box F_ram">
    <form Method="POST" id="CollectionForm">
      <fieldset>
        <input type="hidden" name="idv" value="<?php echo @$ID; ?>">
        <input type="hidden" name="receiptid" value="<?php echo @$receiptid; ?>">
        <table class="FrmTable T-8">

          <tr>
            <td align="right" class="F_val">Bill No</td>
            <td align="left"><input type="text" placeholder="Bill No" id="BillNo" readonly  name="BillNo"
                value="<?php echo @$yearPrefix . '/' . @$Checkoutno; ?>" class="scs-ctrl" />
              <div class="BillNo"></div>
            </td>
            <td align="right" class="F_val">Guest Name</td> 
            <td align="left"><input type="text" placeholder="Guest Name" id="GuestName" readonly name="GuestName"
                value="<?php echo $Title . '.' . $Firstname; ?>" class="scs-ctrl" />
              <div class="Receiptno"></div>
            </td>
          </tr>

          <tr>
            <td align="right" class="F_val">Room No</td>
            <td align="left"><input type="text" placeholder="RoomNo" id="RoomNo" readonly name="RoomNo"
                value="<?php echo @$RoomNo; ?>" class="scs-ctrl" />
              <div class="RoomNo"></div>
            </td>
            <td align="right" class="F_val">Mobile No</td>
            <td align="left"><input type="text" placeholder="Mobile No" id="Mobile" readonly name="Mobile"
                value="<?php echo @$Mobile; ?>" class="scs-ctrl" />
              <div class="Mobile"></div>
            </td>
          </tr>

          <tr>
            <td align="right" class="F_val">C.In Date&Time</td>
            <td align="left"><input type="text" placeholder="Guest Name" id="indate" readonly name="indate"
                value="<?php echo date('d-m-Y', strtotime($CheckinDate)) . ' - ' . substr($CheckinTime, 11, 5); ?>"
                class="scs-ctrl" />
              <div class="indate"></div>
            </td>
            <td align="right" class="F_val">City</td>
            <td align="left"><input type="text" placeholder="date" id="date" name="date" readonly
                value="<?php echo $City ?>" class="scs-ctrl" />
              <div class="date"></div>
            </td>
          </tr>

          <tr>
            <td align="right" class="F_val">C.Out Date&Time</td>
            <td align="left"><input type="text" placeholder="Guest Name" id="indate" readonly name="indate"
                value="<?php echo date('d-m-Y', strtotime($Checkoutdate)) . ' - ' . substr($Checkouttime, 11, 5); ?>"
                class="scs-ctrl" />
              <div class="indate"></div>
            </td>
            <td align="right" class="F_val">Pax</td>
            <td align="left"><input type="text" placeholder="date" id="date" name="date" readonly
                value="<?php echo $Noofpersons ?>" class="scs-ctrl" />
              <div class="date"></div>
            </td>
          </tr>

          <tr>
            <td align="right" class="F_val">Bill Amount</td>
            <td align="left"><input type="text" placeholder="totalamount" id="totalamount" readonly name="totalamount"
                value="<?php echo $totalamount; ?>" class="scs-ctrl" />
              <div class="totalamount"></div>
            </td>
            <td align="right" class="F_val">Days</td>
            <td align="left"><input type="text" placeholder="noofdays" id="noofdays" name="noofdays" readonly
                value="<?php echo $noofdays; ?>" class="scs-ctrl" />
              <div class="noofdays"></div>
            </td>
          </tr>
          <tr>
            <td align="right" class="F_val">Reason</td>
            <td align="left"><input type="text" placeholder="Reason" id="reason" name="reason" required
                value="<?php echo @$resettlereason; ?>" class="scs-ctrl" />
              <div class="reason"></div>
            </td>
            <td align="right">&nbsp;</td>
            <td align="left"><input type="button" class="btn btn-success btn-sm" id="subbtn" name="subbtn"
                value="SAVE" /></td>
          </tr>
        </table>
        <table id="mytable" width="100%" class="mytable" style="margin-top:20px">
          <thead>
            <tr>
              <th>Amount</th>
              <th>Paymode</th>
              <th>Bank / Room</th>
              <th>Card.No</th>
              <th>Validate</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="row">
            <?php
            $qrys = "select * from Trans_checkout_mas ckm
              inner join Trans_Pay_Det pdet on pdet.Checkoutid=ckm.Checkoutid
              inner join Mas_Paymode pm on pm.PayMode_Id=pdet.Paymodeid
              where ckm.Checkoutid='" . $ID . "'  and isnull(pdet.cancelflag,0)<>1";
            $ress = $this->db->query($qrys);
            $counts = $ress->num_rows();
            $j = 1;
            foreach ($ress->result() as $rows) { ?>
         
              <tr>
                <td><input type="text" class="f-ctrl rmm" onchange="save(this.value,<?php echo $j; ?>);" num=1
                    id="Amt_<?php echo $j; ?>" required value="<?php echo $rows->Amount; ?>" name="Amt[]"></td>
                <td>

                    
                  <select required class="scs-ctrl" name="paymode[]" id="paymode_<?php echo $j; ?>"
                    onChange="paymodevalidate(this.value,<?php echo $j; ?>)">
             

                    <option value="">--Paymode--</option>
                    <?php
                    $Res = $this->Myclass->PayMode();
                    foreach ($Res as $row) {
                     
                      if ($row['InActive'] == 0 && $row['PayMode']) { ?>
                        <option <?php if ($rows->Paymodeid == $row['PayMode_Id']) {
                           $PayMode=$row['PayMode'];
                          echo "selected";
                        } ?>
                          value="<?php echo $row['PayMode'] ?>"><?php echo $row['PayMode'] ?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>                

                  <!-- <php print_r($rows) ?> -->
                </td>
                <input type="hidden" id="toroomid" value='<?php echo $rows->toroomid; ?>' />
                <input type="hidden" id="toroomidvalid" value='<?php echo $no; ?>' />
                <?php
                if ($rows->PayMode == "CASH") {

                  ?>
                  <input type="hidden" id="bankk<?php echo $j; ?>" style="display:block" name=bank[] value='' />
                  
                  <?php
                } else {
                  ?>  
                  <input type="hidden" id="bankk<?php echo $j; ?>" style="display:none" value='' />
                <?php }

                ?>

                <td id="bankoption_<?php echo $j ?>"><select name="bank[]" class="form-control form-control-chosen" data-placeholder="Please select..." id="bank_<?php echo $j; ?>">
                    <option value="0">--Bank / Room--</option>
                    <?php

                    if ($rows->PayMode == "COMPANY") {
                      
                      $sql = "select mc.Company as bank,Mc.Company_Id as Bankid from mas_company mc
                              inner join Mas_CompanyType mct on mc.CompanyType_Id=mct.CompanyType_Id
                              where mct.CompanyType <> 'Travel Agent'";
                      $ex = $this->db->query($sql);
                      foreach ($ex->result_array() as $com) {
                        ?>
                        <option <?php if ($rows->Bankid == $com['Bankid']) {
                          echo "selected";
                        } ?>
                          value="<?php echo $com['Bankid'] ?>"><?php echo $com['bank'] ?></option>
                        <?php
                      }
                    } else if ($rows->PayMode == "UPI") {
                        
                      $sql = "select * from mas_bank where isnull(isupi,0)<>0";
                      $ex = $this->db->query($sql);
                      foreach ($ex->result_array() as $com) {
                        ?>
                          <option <?php if ($rows->Bankid == $com['Bankid']) {
                            echo "selected";
                          } ?>
                            value="<?php echo $com['Bankid'] ?>"><?php echo $com['bank'] ?></option>
                        <?php
                      }
                    } else if ($rows->PayMode == "TOROOM") {
                      $sql = "select mr.Room_Id as Bankid, mr.Roomno as bank,* from trans_checkout_mas cm inner join
                      mas_room mr on mr.room_id = cm.toroomid
                      where checkoutid = '" . @$ID . "'";
                      $ex = $this->db->query($sql);
                      foreach ($ex->result_array() as $com) {
                        ?>
                            <option <?php if ($rows->Bankid == $com['Bankid']) {
                              echo "selected";
                            } ?>
                              value="<?php echo $com['Bankid'] ?>"><?php echo $com['bank'] ?></option>
                        <?php
                      }
                    } else {
                       /* $Res = $this->Myclass->Bank();
                      foreach ($Res as $row) { ?>
                            <option <?php if ($rows->Bankid == $row['Bankid']) {
                              echo "selected";
                            } ?>
                              value="<?php echo $row['Bankid'] ?>"><?php echo $row['bank'] ?></option>
                        <?php*/
                       $sql = "select * from mas_bank where isnull(isupi,0)=0";
                      $ex = $this->db->query($sql);
                      foreach ($ex->result_array() as $com) {
                        ?>
                          <option <?php if ($rows->Bankid == $com['Bankid']) {
                            echo "selected";
                          } ?>
                            value="<?php echo $com['Bankid'] ?>"><?php echo $com['bank'] ?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>
                </td>
                
                <td><input type="text" class="scs-ctrl" value="<?php echo $rows->ChqNo; ?>"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="cardno[]"
                    id="cardno_<?php echo $j; ?>"></td>
                <td><input type="text" class="scs-ctrl Dat rmm"
                    value="<?php echo date("d-m-Y", strtotime($rows->Validdate)); ?>" min="<?php echo date('Y-m-d'); ?>" value='<?php echo date('d-m-Y') ?>'
                    name="validate[]" id="validate_<?php echo $j; ?>"></td>
                <?php if ($j == 1) { ?>
                  <td><input type="button" class="add-row" style="display:inline-block" id="add" value="+"> <button
                      type="button" class="delete-row">x</button></td>
                <?php } else { ?>
                  <td><input type="button" class="add-row" style="display:inline-block" id="add" value="+"> <button
                      type="button" class="delete-row">x</button></td>

                <?php } ?>
              </tr>
              <?php $j++;
            } ?>
            <input type="hidden" value="<?php echo $j - 1; ?>" name='counts' id="counts">
          </tbody>
        </table>

      </fieldset>
    </form>
  </div>
  <div class="the-box D_IS"></div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();

?>


<script>
  var bank = 0;
  var card = 0;
  var validate = 0; 
  var payid = 0;

  
  function paymodevalidate(id, i) {


    var totalamount = document.getElementById("totalamount").value;
    if (id == "UPI") {

      $.ajax({
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/UpiOptions",
        data: { id: id },
        success: function (html) {
          $("#bank_" + i).html(html)
        }
      })
      document.getElementById("cardno_" + i).disabled = true;
      document.getElementById("cardno_" + i).value = '';
      document.getElementById("validate_" + i).disabled = true
      document.getElementById("bank_" + i).disabled = false
      document.getElementById("bankk" + i).style.display = "none";
      document.getElementById("bankk" + i).removeAttribute('name');

    } else if (id == "COMPANY") {
      if (Number(totalamount) < 0) {
        swal("Failed...!", "Can't settle in company", "error")
        document.getElementById('paymode_' + i).value = "";
        document.getElementById('bank_' + i).value = "";
        return
      }
      $.ajax({
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/CompanyOptions",
        data: "id" + id,
        success: function (html) {
          $("#bank_" + i).html(html)
        }
      })
      document.getElementById("bank_" + i).disabled = false;
      document.getElementById("cardno_" + i).disabled = true;
      document.getElementById("validate_" + i).disabled = true;
      document.getElementById("bankk" + i).style.display = "none";
      document.getElementById("bankk" + i).removeAttribute('name');
      document.getElementById("cardno_" + i).value = "";
    }
    else if (id == "CREDIT CARD" || id == "CHEQUE" || id == "NET TRANSFER") {

      if (id == 2 && Number(totalamount) < 0) {
        swal("Failed...!", "Can't settle in credit card", "error")
        document.getElementById('paymode_' + i).value = "";
        document.getElementById('bank_' + i).value = "";
        return
      }
      $.ajax({
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/Otheroption",
        success: function (html) {
          $("#bank_" + i).html(html)
        }
      })
      document.getElementById("cardno_" + i).value = '';
      document.getElementById("cardno_" + i).disabled = false
      document.getElementById("validate_" + i).disabled = false
      document.getElementById("bank_" + i).disabled = false
      document.getElementById("bankk" + i).style.display = "none";
      document.getElementById("bankk" + i).removeAttribute('name');
    }
    else if (id == "TOROOM") {
      $.ajax({
        type: "POST",
        url: "<?php echo scs_index ?>Transaction/toroomSettle",
        success: function (html) {
          $("#bank_" + i).html(html)
        }
      })
      document.getElementById("cardno_" + i).value = '';
      document.getElementById("cardno_" + i).disabled = true
      document.getElementById("validate_" + i).disabled = true
      document.getElementById("bankk" + i).style.display = "none";
      document.getElementById("bankk" + i).removeAttribute('name');
      document.getElementById("bank_" + i).disabled = false;


    } else if (id == "CASH") {
      document.getElementById("bank_" + i).disabled = true;
      document.getElementById("cardno_" + i).disabled = true;
      document.getElementById("validate_" + i).disabled = true;
      document.getElementById("bank_" + i).required = false;
      document.getElementById("cardno_" + i).required = false;
      document.getElementById("validate_" + i).required = false;
      document.getElementById("bank_" + i).value = '';
      document.getElementById("cardno_" + i).value = '';
      document.getElementById("bankk" + i).style.display = "block";
      document.getElementById("bankk" + i).setAttribute('name', 'bank[]');

    }

  }


  function save(a, i) {
    var totalamount = document.getElementById("totalamount").value;
    var amt_total = 0;
    for (let j = 1; j <= i; j++) {
      var amt = document.getElementById("Amt_" + j).value;
      amt_total = amt_total + Number(amt);
    }
    if (Number(totalamount) != amt_total) {
      document.getElementById("subbtn").disabled = true
      document.getElementById("add").disabled = false
      if (Number(totalamount) < amt_total) {
        document.getElementById("Amt_" + i).value = 0
      }
    }
    else {
      document.getElementById("subbtn").disabled = false
      document.getElementById("add").disabled = true
    }
  }
  function fromdatevalidate() {


    var a = document.getElementsByName("dateFrom")[0].value;
    alert(a);
  }
  var table = document.getElementById("row");
  var i = table.rows.length;

  $(document).ready(function () {
    var TempAmount = 0;
    var totalamount = document.getElementById("totalamount").value;
    var savebtn = document.getElementById("subbtn");

  $(document).on("click", ".add-row", function () {
      var rowCount = $('#mytable .tr').length;
      i = rowCount - 1
      var totalamount = document.getElementById("totalamount").value;
      var amt_total = 0;
      for (let j = 1; j <= i; j++) {
        var amt = document.getElementById("Amt_" + j).value;
        amt_total = amt_total + Number(amt);
      }
      if (Number(totalamount) == Number(amt_total)) {
        document.getElementById("add").disabled = true
        return
      }
      else {
        document.getElementById("add").disabled = false
      }
      for (let k = 1; k <= i; k++) {
        let paymode = document.getElementById("paymode_" + k).value

        if (Number(paymode) == "COMPANY") {
          let bank = document.getElementById("bank_" + k).value;
          if (Number(bank == 0)) {
            swal("Failed...!", "please select Bank", "error")
            return
          }
        } else if (paymode == "CREDIT CARD" || paymode == "CHEQUE" || paymode == "NET TRANSFER") {
          let card = document.getElementById("cardno_" + k).value
          if (Number(card) == 0) {
            swal("Failed...!", "Please Enter card Number", "error")
            return
          }
        }
        else if (paymode == "UPI") {
          let bank = document.getElementById('bank_' + k).value
          // alert(totalamount)

          if (bank == '') {
            swal("Failed...!", "bank is empty", "error")
            return
          }
        }
        else if (paymode == "TOROOM") {
          let bank = document.getElementById('bank_' + k).value
          if (Number(bank == 0) || bank == '') {
            swal("Failed...!", "Select Room", "error")
            return
          }
        }
        else if (paymode != 0) {
          document.getElementById("subbtn").disabled = false
        }
        else {
          document.getElementById("subbtn").disabled = true
          swal("Failed...!", "paymode is empty", "error")
          return
        }
      }
      i = i + 1;
      var parow = "<td id='bankoption_" + i + "'><select name='bank[]' class='f-ctrl' id='bank_" + i + "'><option value='0'>--Bank--</option><?php $Res = $this->Myclass->Bank();
      foreach ($Res as $row) {
        echo '<option value=' . $row['Bankid'] . ' >' . $row['bank'] . '</option>';
      } ?>  </select><input type='hidden' name=bank[]  value=''  id='bankk" + i + "' style='display:block' /></td>";
      var paymode = "<td ><select  class='f-ctrl' onchange='paymodevalidate(this.value," + i + ")' name='paymode[]' id='paymode_" + i + "' ><option value=''>--Paymode--</option> <?php $Res = $this->Myclass->PayMode();
      foreach ($Res as $row) {
        if ($row['InActive'] == 0) {
          echo '<option value=' . $row['PayMode'] . '>' . $row['PayMode'] . '</option>';
        }
      } ?> </select></td>";
   var markup = "<tr>" +
  "<td><input type='text' num=1 class='f-ctrl rmm' onchange='save(this.value," + i + ");' name='Amt[]' id='Amt_" + i + "' ></td>" +
  paymode +
  parow +
  "<td><input type='text' class='f-ctrl' value='' name='cardno[]' id='cardno_" + i + "'></td>" +
  "<td><input type='date' id='validate_" + i + "' value='<?php echo date('Y-m-d') ?>' class='f-ctrl' name='validate[]'></td>" +
  "<td>" +
    "<input type='button' class='add-row' style='display:inline-block' value='+' />" +
    " <button type='button' class='delete-row'>x</button>" +
  "</td>" +
"</tr>";

      $("#row").append(markup);
      document.getElementById("counts").value = i;
    });

    // Find and remove selected table rows
  $(document).on("click", ".delete-row", function () {
  $(this).closest("tr").remove();
  let rowCount = $('#mytable tr').length - 1; // Adjust as needed
  i = rowCount;
  document.getElementById("counts").value = rowCount;
});
  });

</SCRIPT>


<script>
  const btn = document.getElementById("subbtn");
  let id = 1;
  btn.addEventListener('click', () => {
    var totalamount = document.getElementById("totalamount").value;
    var toroomid = document.getElementById("toroomid").value;
    var toroomidvalid = document.getElementById("toroomidvalid").value;
    var reason = document.getElementById("reason").value;
    if (reason == '') {
      swal("Failed...!", "Reason is Empty", "warning")
      return
    }
    var amt_total = 0;
    for (let j = 1; j <= i; j++) {
      var amt = document.getElementById("Amt_" + j).value;
      amt_total = amt_total + Number(amt);
    }
    if (Number(amt_total) > Number(totalamount)) {
      swal("Failed...!", "Amount not matched", "error")
    }
    if (Number(amt_total) == 0) {
      swal("Failed...!", "Amount is empty", "error")
      return
    }
    if (Number(amt_total) < Number(totalamount)) {
      swal("Failed...!", "Amount not matched", "error")
      return
    }
    for (let k = 1; k <= i; k++) {
      let paymode = document.getElementById("paymode_" + k).value
      if (paymode == "COMAPANY") {
        let bank = document.getElementById("bank_" + k).value;
        if (Number(bank) == 0 || bank == "") {
          swal("Failed...!", "please select Bank", "error")
          return
        }
        if (Number(toroomid) != 0 && Number(toroomidvalid) == 0) {
          swal("Failed...!", "You Can't Resettle, The room was checked out!", "error")
          return;
        }
      } else if (Number(paymode) == 2 || Number(paymode) == 3 || Number(paymode) == 5) {

        let card = document.getElementById("cardno_" + i).value
        let bank = document.getElementById("bank_" + k).value;
        if (card == '') {
          swal("Failed...!", "Please Enter card Number", "error")
          return
        }
        if (Number(bank) == 0 || bank == "") {
          swal("Failed...!", "please select Bank", "error")
          return
        }

        if (Number(toroomid) != 0 && Number(toroomidvalid) == 0) {
          swal("Failed...!", "You Can't Resettle, The room was checked out!", "error")
          return;
        }
      }
      else if (Number(paymode) == 0) {
        swal("Failed...!", "paymode is empty", "error")
        return
      } else if (paymode == "COMPANY") {
        let bank = document.getElementById("bank_" + k).value;
        if (Number(bank) == 0) {
          swal("Failed...!", "please select Bank", "error")
          return
        }

        if (Number(toroomid) != 0 && Number(toroomidvalid) == 0) {
          swal("Failed...!", "You Can't Resettle, The room was checked out!", "error")
          return;
        }
      }
      else if (paymode == "UPI") {
        let bank = document.getElementById('bank_' + k).value
        if (Number(bank == 0) || bank == '') {
          swal("Failed...!", "Select Room", "error")
          return
        }

        if (Number(toroomid) != 0 && Number(toroomidvalid) == 0) {
          swal("Failed...!", "You Can't Resettle, The room was checked out!", "error")
          return;
        }
      }
      else if (Number(toroomid) != 0 && Number(toroomidvalid) == 0) {
        // alert(2)
        swal("Failed...!", "You Can't Resettle, The room was checked out!", "error")
        return;
      }


    }
    $.ajax({
      type: 'post',
      url: '<?php echo scs_index ?>Transaction/CheckoutResettlement_Val',
      data: $('#CollectionForm').serialize(),
      success: function (result) {
        if (result.trim() === 'success') {
          swal("Success...!", "Resettlement Saved Successfully...!", "success")
            .then(function () {
              window.location.href = "<?php echo scs_index ?>Transaction/CheckoutResettlement";
            });
        }
        else {
          swal("Failed...!", "Resettlement Save Faild...!", "error")
            .then(function () {
              window.location.href = "<?php echo scs_index ?>Transaction/CheckoutResettlement";
            });
        }

      }
    });

  });

</script>

<script>
  $(document).ready(function () {
    var rowCount = $('#mytable tr').length;
    for (let j = 1; j <= rowCount - 1; j++) {
      let paymode = document.getElementById("paymode_" + j).value
      // alert(paymode)
      if (paymode == "CASH") {
        document.getElementById("bank_" + i).disabled = true;
        document.getElementById("cardno_" + i).disabled = true;
        document.getElementById("validate_" + i).disabled = true;
        document.getElementById("bank_" + i).required = false;
        document.getElementById("cardno_" + i).required = false;
        document.getElementById("validate_" + i).required = false;
        document.getElementById("bank_" + i).value = ''
        document.getElementById("cardno_" + i).value = 0
      }

    }
  });
       

</script>


<script type="text/javascript">
$('.form-control-chosen').chosen({
  allow_single_deselect: true,
  width: '100%'
});
$('.form-control-chosen-required').chosen({
  allow_single_deselect: false,
  width: '100%'
});
$('.form-control-chosen-search-threshold-100').chosen({
  allow_single_deselect: true,
  disable_search_threshold: 100,
  width: '100%'
});
$('.form-control-chosen-optgroup').chosen({
  width: '100%'
});

$(function() {
  $('[title="clickable_optgroup"]').addClass('chosen-container-optgroup-clickable');
});
$(document).on('click', '[title="clickable_optgroup"] .group-result', function() {
  var unselected = $(this).nextUntil('.group-result').not('.result-selected');
  if(unselected.length) {
    unselected.trigger('mouseup');
  } else {
    $(this).nextUntil('.group-result').each(function() {
      $('a.search-choice-close[data-option-array-index="' + $(this).data('option-array-index') + '"]').trigger('click');
    });
  }
});
$('#is_valid_chosen').addClass('is-valid');
$('#is_invalid_chosen').addClass('is-invalid');
  </script>

