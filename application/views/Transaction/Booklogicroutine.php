<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Report', 'Ota Bookings Report');
$this->pfrm->FrmHead6('Report /Ota Bookings Report', $F_Class . "/" . $F_Ctrl, $F_Class . "/" . $F_Ctrl . "_View");
date_default_timezone_set('Asia/Kolkata');
?>


<div class="col-sm-12">
    <div class="the-box F_ram">
        <fieldset>
            <form action="" method="POST">
                <table style="width: 100%; border-collapse: separate; border-spacing: 10px;">
                    <tr>
                        <!-- Radio Buttons Column -->
                        <td style="vertical-align: top; white-space: nowrap;">
                            <label style="display: block;">
                                <input type="radio" name="routine_type" value="room"
                                    <?php if (!isset($_POST['routine_type']) || $_POST['routine_type'] == 'room') echo 'checked'; ?>>
                                Room Inventory
                            </label>
                            <label style="display: block; margin-top: 5px;">
                                <input type="radio" name="routine_type" value="rate"
                                    <?php if (isset($_POST['routine_type']) && $_POST['routine_type'] == 'rate') echo 'checked'; ?>>
                                Rate Distribution
                            </label>
                        </td>

                        <!-- Submit Button -->
                        <td style="white-space: nowrap;">
                            <br>
                            <input type="submit" name="submit" class="btn btn-success" value="Show Details">
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>

<!-- Conditional Form Area -->
<div class="col-sm-12">
    <?php if (@$_POST['submit']): ?>
        <?php $routine_type = isset($_POST['routine_type']) ? $_POST['routine_type'] : 'room'; ?>
        <div class="the-box" style="margin-top: 20px; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; border-radius: 5px;">
            <h4 class="text-center"><?= $routine_type === 'room' ? 'Room Inventory' : 'Rate Distribution' ?></h4>
            <form method="post" action="">
                <div class="row">
                    <!-- From Date -->
                    <div class="col-md-3">
                        <label for="frmdate">From Date</label>
                        <input type="date" id="frmdate" name="frmdate" class="form-control" required>
                    </div>

                    <!-- To Date -->
                    <div class="col-md-3">
                        <label for="todate">To Date</label>
                        <input type="date" id="todate" name="todate" class="form-control" required>
                    </div>

                    <!-- Save Button -->
                    <div class="col-md-3 d-flex align-items-end" style="margin-top: 25px;">
                        <button type="submit" id="submitBtn"  class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#submitBtn').click(function(e) {
        e.preventDefault();

        var frmdate = document.getElementById('frmdate').value;
        var todate = document.getElementById('todate').value;

        if (!frmdate || !todate) {
            $('#response-message').html('<div class="alert alert-danger">Both From Date and To Date are required.</div>');
            return;
        }


    
        $.ajax({
            url:"<?php echo scs_index ?>Transaction/booklogicroutinefunction",
            type: 'POST',
            dataType:'json',
            data: {
                frmdate: frmdate,
                todate: todate,
                routine_type: 'room' 
            },
            success: function(response) {
       
                if (response.status === 'success') {
                    swal("Success...!", "Booklogic routine Success...!", "success")
                    .then(()=>{
                        location.reload();
                    });
                    
                }else if(response.status === 'warning'){
                    swal("Warning...!",response.message, "warning")
                    .then(()=>{
                        location.reload();
                    });

                } else {
                    swal("Failed...!", "Booklogic routine Failed...!", "error");
                }
            },
            error: function() {
        
                $('#response-message').html('<div class="alert alert-danger">An error occurred while processing your request. Please try again.</div>');
            }
        });
    });
});
</script>



<script>
    document.getElementById("frmdate").addEventListener("focus", function() {
        this.showPicker();
    });

    document.getElementById("todate").addEventListener("focus", function() {
        this.showPicker();
    });
</script>


