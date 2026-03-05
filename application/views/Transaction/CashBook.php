<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Master', 'Cash Book');
$this->pfrm->FrmHead11('Master / Cash Book', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");

$Res = "select dbo.CashbookNo() as number";
$res = $this->db->query($Res);
foreach ($res->result_array() as $row) {
  $Creditno = $row['number'];
}

$sql = "select isnull(cashbookentryprint,0) as cashbookentryprint,* from extraoption";
$res1 = $this->db->query($sql);
foreach($res1->result_array() as $row) {
  $cashentryenable = $row['cashbookentryprint'];
}

$year = "select dbo.YearPrefix() as id";
$res = $this->db->query($year);
foreach ($res->result_array() as $r) {
  $yearPrefix = $r['id'];
}
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <table class="FrmTable T-6">
        <tr>
          <td align="right" class="F_val"><b>Receipt No</b></td>
          <td align="left">
            <input readonly type="text"
              value="<?php echo $yearPrefix . '/' . $Creditno; ?>"
              id="receipt_no" name="receipt_no" class="scs-ctrl" />
            <div class="Type"></div>
          </td>
          <td align="right" class="F_val"><b>Date</b></td>
          <td align="left">
            <input readonly type="text"
              value="<?php echo date("d-m-Y"); ?>"
              id="date" name="date" class="scs-ctrl" />
            <div class="Type"></div>
          </td>
        </tr>
      </table>
    </fieldset>
  </div>
  <div class="the-box D_IS"></div>
</div>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Credid; ?>">
      <table class="table table-bordered table-responsive table-hover" style="margin-top:20px">
        <thead>
          <tr style="background-color:#c9c6c6;">
            <th>Head</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Remark</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="row">
          <tr data-index="1">
            <td width="450px;">
              <select required class="scs-ctrl scs-ctrl-select"
                name="Head[]" id="Head_1"
                onchange="headSelectionValidation(this.value, 1)">
                <option value="">--Head--</option>
                <?php
                $sql = "SELECT * FROM accname";
                $res = $this->db->query($sql);
                foreach ($res->result_array() as $row) {
                  echo '<option value="' . $row['Accid'] . '">' . $row['Accname'] . '</option>';
                }
                ?>
              </select>
              <div class="Head"></div>
            </td>
            <td width="150px;">
              <input type="text" id="Type_1" name="Type[]"
                placeholder="Type"  readonly
                class="scs-ctrl" />
              <div class="Type"></div>
            </td>
            <td width="150px;">
              <input type="text" id="Debit_1" name="Debit[]"
                placeholder="Amount"
                onkeypress="return (event.charCode != 8 && event.charCode == 0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                class="scs-ctrl" />
              <div class="Debit"></div>
            </td>
            <td width="350px;">
              <input type="text" id="Remark_1" name="Remark[]"
                placeholder="Remark" class="scs-ctrl" />
              <div class="Remark"></div>
            </td>
            <td>
              <button type="button" class="btn btn-success btn-sm addRow">+</button>
              <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td align="right" colspan="4">&nbsp;</td>
            <td align="left">
              <input type="button" class="btn btn-success btn-sm"
                id="submit" value="<?php echo $BUT; ?>" />
            </td>
          </tr>
        </tfoot>
      </table>
    </fieldset>
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
$(document).ready(function() {
  let rowCount = $('#row tr').length || 1;


  $('#row').on('click', '.addRow', function () {

  const $lastRow = $('#row tr:last');
  const rowIndex = $lastRow.data('index');

  const head = $('#Head_' + rowIndex).val();
  const type = parseFloat($('#Type_' + rowIndex).val()) || 0;
  const debit = parseFloat($('#Debit_' + rowIndex).val()) || 0;
  const remark = $('#Remark_' + rowIndex).val().trim();


  if (!head) {
    swal("Validation Error", "Please select a Head ", "warning");
    return;
  }

  if ((debit == "") || (debit == 0)) {
    swal("Validation Error", "Please enter Amount ", "warning");
    return;
  }

  // if (!remark) {
  //   swal("Validation Error", "Please enter a Remark in row ", "warning");
  //   return;
  // }


  rowCount++;
  const $newRow = $lastRow.clone();

  $newRow.attr('data-index', rowCount);


  $newRow.find('select[name="Head[]"]')
    .attr('id', 'Head_' + rowCount)
    .val('')
    .attr('onchange', 'headSelectionValidation(this.value, ' + rowCount + ')');

  $newRow.find('input[name="Type[]"]')
    .attr('id', 'Type_' + rowCount)
    .val('')
    .prop('disabled', false);

  $newRow.find('input[name="Debit[]"]')
    .attr('id', 'Debit_' + rowCount)
    .val('')
    .prop('disabled', false);

  $newRow.find('input[name="Remark[]"]')
    .attr('id', 'Remark_' + rowCount)
    .val('');


  $newRow.find('.Head, .Debit, .Remark').html('');


  $('#row').append($newRow);

  preventDuplicateHeads();
});


  // Remove row
  $('#row').on('click', '.removeRow', function() {
    if ($('#row tr').length > 1) {
      $(this).closest('tr').remove();
      preventDuplicateHeads();
    } else {
      alert('At least one row is required.');
    }
  });


  $(document).on('change', 'select[name="Head[]"]', function() {
    const val = $(this).val();
    const isDisabled = $(this).find('option[value="' + val + '"]').prop('disabled');

    if (isDisabled) {
      swal("Warning!", "This Head is already selected in another row. Please select a different Head.", "warning");
      $(this).val('');
      preventDuplicateHeads(); 
      return;
    }
  });

  // $(document).on('input', 'input[name="Credit[]"]', function() {
  //   const val = $(this).val();

  //   if (val >  100000) {
  //     swal("Warning!", "Give under 1 lakhs.", "warning");
  //     $(this).val('');
  //     return;
  //   }
  // });

  $(document).on('input', 'input[name="Debit[]"]', function() {
    const val = $(this).val();

    if (val > 100000) {
      swal("Warning!", "Give under 1 lakhs.", "warning");
      $(this).val('');
      return;
    }
  });


  $('#submit').on('click', function () {
  const rows = $('#row tr');
  const formData = {};

  for (let i = 0; i < rows.length; i++) {
    const idx = i + 1;

    const head = document.getElementById('Head_' + idx);
    const type = document.getElementById('Type_' + idx);
    const debit = document.getElementById('Debit_' + idx);
    const remark = document.getElementById('Remark_' + idx);

    if (!head || !debit || !remark) {
      swal("Error", `Missing fields }`, "error");
      return;
    }

    if (head.value === '') {
      swal("Unable to process!", `Please select Head`, "warning");
      return;
    }

    // const credVal = parseFloat(credit.value) || 0;
    const debVal = parseFloat(debit.value) || 0;

    if ((debVal == '') || (debVal == 0)) {
      swal("Unable to process!", `please enter amount`, "warning");
      return;
    }

    // if (remark.value.trim() === '') {
    //   swal("Unable to process!", `Please enter Remark in row ${idx}`, "warning");
    //   return;
    // }

    formData['Head_' + idx] = head.value;
    formData['Type_' + idx] = type.value;
    formData['Debit_' + idx] = debit.value;
    formData['Remark_' + idx] = remark.value;
  }

  formData['count'] = rows.length;



  $.ajax({
    type: 'POST',
    url: '<?php echo scs_index ?>Transaction/CashBook_Val',
    data: formData,
    traditional: true,
    success: function (result) {
   if(result == '0'){
    swal("Success", "CashBook Saved Successfull","success");
    location.reload();
      
   } else{
    swal("Error!", "CashBook Saved Failed", "error");

   }

    },
    error: function () {
      swal("Error!", "Server error while processing", "error");
    }
  });
});


}); 

function headSelectionValidation(headId, rowIndex) {
  $.ajax({
    type: 'POST',
    url: '<?php echo scs_index ?>Transaction/headselect',
    data: { id: headId },
    success: function(result) {
      result = result.trim();

      const typeField = document.getElementById('Type_' + rowIndex);
const debitField = document.getElementById('Debit_' + rowIndex);



if (result === 'C') {
  typeField.value = 'Cr';
} else if(result === 'D') {
  typeField.value = 'Dr';

}
  else {
  typeField.value = '';
}


      preventDuplicateHeads();
    },
    error: function() {
      swal("Error!", "Server error while processing", "error");
    }
  });
}

function preventDuplicateHeads() {
  const selectedHeads = [];

  $('select[name="Head[]"]').each(function () {
    const val = $(this).val();
    if (val) selectedHeads.push(val);
  });

  $('select[name="Head[]"]').each(function () {
    const $currentSelect = $(this);
    const currentVal = $currentSelect.val();

    $currentSelect.find('option').prop('disabled', false);

    selectedHeads.forEach(function (val) {
      if (val !== currentVal) {
        $currentSelect.find('option[value="' + val + '"]').prop('disabled', true);
      }
    });
  });
}
</script>


