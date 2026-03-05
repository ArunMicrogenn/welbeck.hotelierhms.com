<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Master', 'Cash Book');
$this->pfrm->FrmHead1('Master / Cash Book', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");

$Res = "select dbo.CashbookNo() as number";
$res = $this->db->query($Res);
foreach ($res->result_array() as $row) {
  $Creditno = $row['number'];
}

$year = "select dbo.YearPrefix() as id";
$res = $this->db->query($year);
foreach ($res->result_array() as $r) {
  $yearPrefix = $r['id'];
}
?>


<div class="form-group">

  <label>
    <input type="radio" name="acc_type" value="D" onclick="loadHeads('D')" checked> Income
  </label>
  <label style="margin-left:20px;">
    <input type="radio" name="acc_type" value="C" onclick="loadHeads('C')"> Expense
  </label>
</div>



<div class="col-sm-12">
  <div class="the-box F_ram">

    <fieldset>
      <input type="hidden" name="idv" value="<?php echo @$Credid; ?>">
      <table class="table table-bordered table-responsive table-hover" style="margin-top:20px">
        <thead>
          <tr style="background-color:#c9c6c6;">
            <th>Receipt No</th>
            <th>Date</th>
            <th>Head</th>
            <th>Payment/Collection</th>
            <th>Remark</th>
          </tr>
        </thead>
        <tbody id="row">
          <tr>

            <td><?php if (@$Credid) {
                  echo $yearprefix . '/' . $CreditNo;
                } else {
                  echo $yearPrefix . '/' . $Creditno;
                } ?>
            </td>
            <td><?php echo date("d-m-Y") ?></td>

            <td>
           <select required class="scs-ctrl scs-ctrl-select" name="Head" id="Head" >
  <option value="">--Head--</option>
  
  <?php
  $sql = "select * from accname";
  $res = $this->db->query($sql);
  foreach ($res->result_array() as $row) {
    $type = $row['creditordebit']; 
    echo '<option value="' . $row['Accid'] . '" data-type="' . $type . '">' . $row['Accname'] . '</option>';
  }
  ?>
</select>

              <div class="Head" ></div>
            </td>
            

            <td>
            <input type="Text" value="<?php echo @$Amount; ?>" class="scs-ctrl rmm" onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))" id="amount"  name="amount"/>
            <div class="amount" ></div>
            </td>

            <td>
              <input required type="text" placeholder="Remark" id="Remark" value="<?php echo @$remarks; ?>" name="Remark" value="" class="scs-ctrl" />
              <div class="Remark" ></div>
            </td>

          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td align="right" colspan="4">&nbsp;</td>
            <td align="left">
              <input type="button"   class="btn btn-success btn-sm" id="EXEC" name="EXEC"  value="<?php echo $BUT; ?>" />
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
  $(document).ready(function(e) {
    $('#roomid').val(<?php echo @$Room_Id; ?>);
    $('#roomid1').val(<?php echo @$Room_Id; ?>);
    $('#RevenueHead').val(<?php echo @$Creditheadid; ?>);
    $('#RevenueHead1').val(<?php echo @$Creditheadid; ?>);
  });
</script>

<<script>
function loadHeads(type) {
  const headSelect = document.getElementById('Head');
  const options = headSelect.options;

  for (let i = 0; i < options.length; i++) {
    const opt = options[i];
    const optType = opt.getAttribute('data-type');


    if (!optType) {
      opt.style.display = '';
      continue;
    }


    opt.style.display = (optType === type) ? '' : 'none';
  }


  headSelect.value = '';
}

document.addEventListener('DOMContentLoaded', function() {
  loadHeads('D'); 
});
</script>