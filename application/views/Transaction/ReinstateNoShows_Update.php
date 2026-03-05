<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Transaction', 'ReinstateNoShows_Update');
$this->pfrm->FrmHead2('Transaction / ReinstateNoShows_Update', $F_Class . "/ReinstateNoShows", $F_Class . "/" . $F_Ctrl . "_View");
?>

<div class="col-sm-12">
  <div class="the-box F_ram">
    <form id="reinstateForm">
      <fieldset>
        <!-- Hidden Inputs -->
        <input type="hidden" name="idv" id="idv" value="<?php echo @$Resid; ?>">
        <input type="hidden" name="resdetid" id="resdetid" value="<?php echo @$resdetid; ?>">
        <input type="hidden" name="ratetypeid" id="ratetypeid" value="<?php echo @$ratetypeid; ?>">
        <input type="hidden" name="typeid" id="typeid" value="<?php echo @$typeid; ?>">
        <input type="hidden" name="noofrooms" id="noofrooms" value="<?php echo @$noofrooms; ?>">

        <!-- Info Table -->
        <table class="FrmTable T-8">
          <tr>
            <td align="right" class="F_val">Res.No</td>
            <td align="left">
              <input type="text" readonly id="ResNo" name="ResNo" value="<?php echo @$ResNo; ?>" class="scs-ctrl" />
            </td>
            <td align="right" class="F_val">Res.Date</td>
            <td align="left">
              <input type="text" readonly value="<?php echo date('d-m-Y', strtotime($Resdate)); ?>" class="scs-ctrl" />
            </td>
          </tr>
          <tr>
            <td align="right" class="F_val">Guest Name</td>
            <td align="left">
              <input type="text" readonly value="<?php echo $Firstname; ?>" class="scs-ctrl" />
            </td>
            <td align="right" class="F_val">Room Type</td>
            <td align="left">
              <input type="text" readonly value="<?php echo $RoomType; ?>" class="scs-ctrl" />
            </td>
          </tr>
          <tr>
            <td align="right" class="F_val">Arrival Date</td>
            <td align="left">
              <input type="hidden" id="Arrival" name="Arrival" value="<?php echo $fromdate . 'T' . $fromtime; ?>">
              <input type="text" readonly value="<?php echo date('d-m-Y', strtotime($fromdate)) . substr($fromtime, 10, 6); ?>" class="scs-ctrl" />
            </td>
            <td align="right" class="F_val">Departure Date</td>
            <td align="left">
              <input type="hidden" id="Departure" name="Departure" value="<?php echo $todate . 'T' . $totime; ?>">
              <input type="text" readonly value="<?php echo date('d-m-Y', strtotime($todate)) . substr($totime, 10, 6); ?>" class="scs-ctrl" />
            </td>
          </tr>
          <tr>
            <td align="right" class="F_val">New Arrival Date</td>
            <td align="left">
              <input name="NewArrival"  id="NewArrival" type="datetime-local" min="<?php echo date('Y-m-d') ?>T00:00" class="scs-ctrl" required />
            </td>
            <td align="right" class="F_val">New Departure Date</td>
            <td align="left">
              <input name="NewDeparture" id="NewDeparture" type="datetime-local" min="<?php echo date('Y-m-d') ?>T00:00" class="scs-ctrl" required />
            </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <button type="button" class="btn btn-success btn-sm" id="EXECs"><?php echo $BUT; ?></button>
            </td>
          </tr>
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
$(document).ready(function() {
  $('#EXECs').on('click', function() {
    var idv = $('input[name="idv"]').val();
    var resdetid = $('input[name="resdetid"]').val();
    var ratetypeid = $('input[name="ratetypeid"]').val();
    var typeid = $('input[name="typeid"]').val();
    var noofrooms = $('input[name="noofrooms"]').val();
    var ResNo = $('#ResNo').val();
    var Arrival = $('#Arrival').val();
    var Departure = $('#Departure').val();
    var NewArrival = $('#NewArrival').val();
    var NewDeparture = $('#NewDeparture').val();

    var ArrivalDateOnly = NewArrival.split('T')[0];
    var DepartureDateOnly = NewDeparture.split('T')[0];

    if (!NewArrival || !NewDeparture) {
      alert("Please select both new arrival and new departure dates.");
      return;
    }


    $.ajax({
      url: "<?php echo scs_index ?>Transaction/room_validation",
      method: 'POST',
      data: {
        roomtypeid: typeid,
        noofrooms: noofrooms,
        fromdate: ArrivalDateOnly,
        todate: DepartureDateOnly,
      },
      success: function(response) {
        response = "[" + response.replace(/}{/g, "},{") + "]";
        var data;

        try {
          data = JSON.parse(response);
        } catch (err) {
          alert("Invalid response from server.");
          return;
        }

        if (Array.isArray(data) && data.length > 0) {
          for (let i = 0; i < data.length; i++) {
            const availableRooms = Number(data[i].available || 0);
            const roomTypeName = data[i].room_type || 'Unknown';
            const date = data[i].date || 'Unknown Date';

            if (availableRooms < noofrooms) {
              alert("No rooms available on " + date);
              return; 
            }
          }
        }

     
        var dataToSend = {
          idv: idv,
          resdetid: resdetid,
          ratetypeid: ratetypeid,
          typeid: typeid,
          noofrooms: noofrooms,
          ResNo: ResNo,
          NewArrival: NewArrival,
          NewDeparture: NewDeparture,
          Arrival : Arrival,
          Departure : Departure

        };

        $.ajax({
          url: "<?php echo scs_index; ?>Transaction/ReinstateNoShows_Save",
          type: "POST",
          data: dataToSend,
          beforeSend: function() {
            $('#EXECs').prop('disabled', true).text('Processing...');
            $('.D_IS').html('');
          },
          success: function(response) {


            $('#EXECs').prop('disabled', false).text('<?php echo $BUT; ?>');


            if (response.trim() === 'success') {
              swal("Success...!", "Reinstate Update Successful...!", "success")
                .then(() => {
                  window.location.href = '<?php echo scs_index ?>Transaction/ReinstateNoShows';
                });
            } else {
              swal("Error...!", "Reinstate Save Failed...!", "error");
            }
          },
          error: function(xhr, status, error) {
            $('#EXECs').prop('disabled', false).text('<?php echo $BUT; ?>');
            $('.D_IS').html('<div class="alert alert-danger">Error: ' + error + '</div>');
          }
        });

      } 
    }); 
  }); 
}); 

</script>

<script>
$(document).ready(function() {
    $('#NewArrival').on('change', function() {
 
        var fromdate = $(this).val(); 
        var todate = $('#NewDeparture').val();

        var fromDateObj = new Date(fromdate);
        var toDateObj = new Date(todate);


        if (fromDateObj > toDateObj) {
 
    fromDateObj.setDate(fromDateObj.getDate() + 1);

  
    let isoString = fromDateObj.toISOString(); 
    let [datePart, timePart] = isoString.split('T');
    timePart = timePart.split('.')[0]; 

    let formattedDateTime = datePart + ' ' + timePart; 


    $('#NewDeparture').val(formattedDateTime);
}
    });
});

	</script>

<script>

$(document).ready(function () {


$('#NewDeparture').on('change', function () {
    var todate = $(this).val();
    var fromdate = $('#NewArrival').val();

    var fromDateObj = new Date(fromdate);
    var toDateObj = new Date(todate);
    var curr = new Date();


    function formatDateTime(dateObj) {
        let year = dateObj.getFullYear();
        let month = String(dateObj.getMonth() + 1).padStart(2, '0');
        let day = String(dateObj.getDate()).padStart(2, '0');
        let hours = String(dateObj.getHours()).padStart(2, '0');
        let minutes = String(dateObj.getMinutes()).padStart(2, '0');
        let seconds = String(dateObj.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    
    if (fromDateObj > toDateObj) {

       
        if (toDateObj.toDateString() === curr.toDateString()) {
            $('#NewArrival').val(formatDateTime(curr));
        } else {
            
            toDateObj.setDate(toDateObj.getDate() - 1);
            $('#NewArrival').val(formatDateTime(toDateObj));
        }
    }


    else if (toDateObj.toDateString() === curr.toDateString()) {
        $('#NewArrival').val(formatDateTime(curr));
    }
});
});



	</script>
