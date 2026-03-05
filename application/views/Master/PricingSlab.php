<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
$this->pweb->Cheader('Master', 'PricingSlab');
// $this->pfrm->FrmHead1('Master / PricingSlab', $F_Class."/".$F_Ctrl, $F_Class."/".$F_Ctrl);
?>

<div style="margin-bottom: 15px; text-align: right;">
    <a href="<?php echo scs_index?>Master/pricingslab_view" class="btn btn-info">View</a>
    <a  class="btn btn-primary">Add</a>
</div>

<style>
.form-container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 30px;
    background: #f9f9f9;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 25px;
    gap: 20px;
}

.form-group {
    flex: 1;
    min-width: 250px;
}

.form-group label {
    display: block;
    margin-bottom: 4px;
    font-weight: 500;
    color: #333;
}

.form-group select,
.form-group input {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #ccc;
    background: #fff;
    border-radius: 2px;
    font-size: 13px;
}

.form-group select:focus,
.form-group input:focus {
    border-color: #007bff;
    outline: none;
}

.rent-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 30px 0;
    padding: 20px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
}

.rent-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.rent-group label {
    min-width: 120px;
    font-weight: 500;
    color: #333;
}

.rent-group input {
    flex: 1;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 2px;
    background: #fff;
    font-size: 13px;
}

/* Table Styling */
.pricing-table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    background-color: #fff;
    border: 1px solid #dee2e6;
    font-size: 13px;
}

.pricing-table th {
    background-color: #f1f3f5;
    color: #495057;
    padding: 10px;
    text-align: left;
    font-weight: 600;
    border-bottom: 1px solid #dee2e6;
}

.pricing-table td {
    padding: 8px;
    border: 1px solid #e9ecef;
}

.pricing-table input {
    width: 100%;
    padding: 6px 8px;
    border: 1px solid #ccc;
    border-radius: 2px;
    font-size: 13px;
    background: #fff;
}

/* Buttons */
.action-btn {
    display: flex;
    justify-content: center;
    gap: 6px;
}

.action-btn button.addRow {
    background-color: #28a745; /* Green */
    color: white;
    border: none;
    border-radius: 3px;
    font-size: 16px;
}

.action-btn button.addRow:hover {
    background-color: #218838;
}

.action-btn button.removeRow {
    background-color: #dc3545; /* Red */
    color: white;
    border: none;
    border-radius: 3px;
    font-size: 16px;
}

.action-btn button.removeRow:hover {
    background-color: #c82333;
}


.save-btn {
    padding: 10px 18px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 3px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
}

.save-btn:hover {
    background: #0069d9;
}

@media (max-width: 768px) {
    .form-group {
        flex: 1 100%;
    }

    .rent-grid {
        grid-template-columns: 1fr;
    }

    .pricing-table {
        display: block;
        overflow-x: auto;
    }
}
</style>



<div class="form-container">
    <form id="pricingSlabForm" method="post" action="<?php echo scs_index ?>Transaction/savepricingslab">
        <div class="form-row">

        <div class="form-group">
                <label for="slabName">Slab Name:</label>
                 <input type="text" name="slabName" id="slabName">
            </div>

            <div class="form-group">
                <label for="roomtype">Room Type:</label>
                <select id="roomtype" name="roomtype" required onchange="slabfunc()">
                    <option value="">---Select RoomType---</option>
                 <?php   $Res=$this->Myclass->RoomType(); ?>

                 
                 <?php foreach($Res as $room){ ?>
                    <option value="<?php echo $room['RoomType_Id'] ?>"><?php echo $room['RoomType']?></option>

                    <?php } ?>
                
                </select>
            </div>

          
        </div>

        <div class="rent-grid">
            <div class="rent-group">
                <label>Single Rent:</label>
                <input type="text" readonly name="singleRent" id="singleRent" required />
            </div>
            <div class="rent-group">
                <label>Double Rent:</label>
                <input type="text" readonly name="doubleRent" id="doubleRent" required />
            </div>
            <div class="rent-group">
                <label>Triple Rent:</label>
                <input type="text" readonly name="tripleRent" id="tripleRent" required />
            </div>
            <div class="rent-group">
                <label>Quarter Triple Rent:</label>
                <input type="text" readonly name="quarterTripleRent" id="quarterTripleRent" required />
            </div>
        </div>

        <table class="pricing-table">
            <thead>
                <tr>
                    <th>From %</th>
                    <th>To %</th>
                    <th>Increase</th>
                    <th>Decrease</th>
                    <th>Discount %</th>
                    <th>Bottom Value</th>
                    <th>Top Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="pricingTableBody">
                <tr>
                    <td><input type="text" name="from[]" required /></td>
                    <td><input type="text" name="to[]" required /></td>
                    <td>
    <input type="checkbox" class="increase-checkbox" name="increase[]" value="1" />
</td>
<td>
    <input type="checkbox" class="decrease-checkbox" name="decrease[]" value="1" />
</td>
                    <td><input type="text" name="discount[]" required /></td>
                    <td><input type="text" name="bottomValue[]" required /></td>
                    <td><input type="text" name="topValue[]" required /></td>
                    <td class="action-btn">
                        <button type="button" class="addRow">+</button>
                        <button type="button" class="removeRow" disabled>-</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px;">
        <!-- <input type="button"  onclick="Reserve()" class="btn btn-success btn-sm" id="btn" name="btn" value="save"  /> -->
        
            <button type="button" class="save-btn"  onclick="slabform()" id ="save-btn">Save</button>
        </div>
    </form>
</div>

<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const pricingTable = document.querySelector('#pricingTableBody');

    function updateRemoveButtons() {
        const rows = pricingTable.querySelectorAll('tr');
        rows.forEach(row => {
            const removeBtn = row.querySelector('.removeRow');
            if (removeBtn) {
                removeBtn.disabled = (rows.length === 1);
            }
        });
    }

    function addNewRow() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="from[]" required /></td>
            <td><input type="text" name="to[]" required /></td>
            <td><input type="checkbox" class="increase-checkbox" name="increase[]" value="1" /></td>
            <td><input type="checkbox" class="decrease-checkbox" name="decrease[]" value="1" /></td>
            <td><input type="text" name="discount[]" required /></td>
            <td><input type="text" name="bottomValue[]" required /></td>
            <td><input type="text" name="topValue[]" required /></td>
            <td class="action-btn">
                <button type="button" class="addRow">+</button>
                <button type="button" class="removeRow">-</button>
            </td>
        `;
        pricingTable.appendChild(newRow);
        attachEvents(newRow);
        updateRemoveButtons();
    }

    function attachEvents(row) {
        row.querySelector('.addRow').addEventListener('click', addNewRow);
        row.querySelector('.removeRow').addEventListener('click', function () {
            if (pricingTable.rows.length > 1) {
                this.closest('tr').remove();
                updateRemoveButtons();
            }
        });

        const increaseCheckbox = row.querySelector('.increase-checkbox');
        const decreaseCheckbox = row.querySelector('.decrease-checkbox');

        if (increaseCheckbox && decreaseCheckbox) {
            increaseCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    decreaseCheckbox.checked = false;
                }
            });

            decreaseCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    increaseCheckbox.checked = false;
                }
            });
        }

        const fromInput = row.querySelector('input[name="from[]"]');
        const toInput = row.querySelector('input[name="to[]"]');
    



function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}


fromInput.addEventListener('keyup', debounce(() => validateAllRows(), 500)); 
toInput.addEventListener('keyup', debounce(() => validateAllRows(), 500));   


       
        // fromInput.addEventListener('keyup', () => validateAllRows());
        // toInput.addEventListener('keyup', () => validateAllRows());
    }

    function validateAllRows() {
        const rows = pricingTable.querySelectorAll('tr');

        rows.forEach((row, i) => {
            const fromInput = row.querySelector('input[name="from[]"]');
            const toInput = row.querySelector('input[name="to[]"]');
            const fromVal = parseFloat(fromInput.value);
            const toVal = parseFloat(toInput.value);

            fromInput.classList.remove('invalid');
            toInput.classList.remove('invalid');

           
            if (!isNaN(fromVal) && !isNaN(toVal) && toVal <= fromVal) {
                alert(`Row ${i + 1}: "To" must be greater than "From"`);
                toInput.value = '';
                toInput.focus();
                return;
            }

            
            if (i > 0) {
                const prevTo = parseFloat(rows[i - 1].querySelector('input[name="to[]"]').value);
                if (!isNaN(prevTo) && !isNaN(fromVal) && fromVal <= prevTo) {
                    alert(`Row ${i + 1}: "From" must be greater than previous row's "To" (${prevTo})`);
                    fromInput.value = '';
                    fromInput.focus();
                    return;
                }
            }
        });
    }

    
    attachEvents(pricingTable.querySelector('tr'));
    updateRemoveButtons();
});
</script>


<script>
    

function slabfunc(){

var roomid  = document.getElementById('roomtype').value;
// const roomtype = document.getElementById('roomtype');
const singleRent = document.getElementById('singleRent');
const doubleRent = document.getElementById('doubleRent');
const tripleRent = document.getElementById('tripleRent');
const quarterTripleRent = document.getElementById('quarterTripleRent');

                      singleRent.value= '';
                        doubleRent.value= '';
                        tripleRent.value= '';
                        quarterTripleRent.value= '';
                        // roomtype.value = '';


                 $.ajax({
                    type: 'POST',
                    url: '<?php echo scs_index ?>Transaction/getroomrent',
                    data: {
                        roomid : roomid
                    },
                    dateType:'json',
                    success: function (result) {
						// alert(result);
                        // roomtype.value = result.Roomtype;
                        singleRent.value= result.single;
                        doubleRent.value= result.double;
                        tripleRent.value= result.triple;
                        quarterTripleRent.value= result.quartertriple;

                   
                    }
                });
}
    
    
</script>


<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<script>
function slabform() {
    const slabName = $('#slabName').val().trim();
    const roomtype = $('#roomtype').val().trim();

    if (!slabName || !roomtype) {
        swal("Validation Error", "Please fill in all required fields.", "warning");
        return;
    }

    const data = {
        slabName,
        roomtype,
        singleRent: $('#singleRent').val(),
        doubleRent: $('#doubleRent').val(),
        tripleRent: $('#tripleRent').val(),
        quarterTripleRent: $('#quarterTripleRent').val(),
        from: [],
        to: [],
        increase: [],
        decrease: [],
        discount: [],
        bottomValue: [],
        topValue: []
    };

    let isValid = true;
    let errorMsg = "";

    $('#pricingTableBody tr').each(function (index) {
        const from = $(this).find('input[name="from[]"]').val().trim();
        const to = $(this).find('input[name="to[]"]').val().trim();
        const discount = $(this).find('input[name="discount[]"]').val().trim();
        const bottomValue = $(this).find('input[name="bottomValue[]"]').val().trim();
        const topValue = $(this).find('input[name="topValue[]"]').val().trim();

        // Check for empty fields in the row
        if (!from || !to || discount === "" || bottomValue === "" || topValue === "") {
            isValid = false;
            errorMsg = `Please fill in all fields for row ${index + 1}.`;
            return false; // Break out of .each
        }

        data.from.push(from);
        data.to.push(to);
        data.increase.push($(this).find('.increase-checkbox').prop('checked') ? 1 : 0);
        data.decrease.push($(this).find('.decrease-checkbox').prop('checked') ? 1 : 0);
        data.discount.push(discount);
        data.bottomValue.push(bottomValue);
        data.topValue.push(topValue);
    });

    if (!isValid) {
        swal("Validation Error", errorMsg, "warning");
        return;
    }

    $.ajax({
        url: "<?php echo scs_index ?>Transaction/savepricingslab",
        type: 'POST',
        data: data,
        success: function (response) {
            const trimmed = response.trim();
            if (trimmed === "success") {
                swal("Success!", "Pricing Slab saved successfully!", "success");

                // Reset form
                $('#slabName, #roomtype, #singleRent, #doubleRent, #tripleRent, #quarterTripleRent').val('');
                $('#pricingTableBody tr').each(function () {
                    $(this).find('input[type="text"]').val('');
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                });

            } else if (trimmed === "sorry") {
                swal("Duplicate Slab", "A slab with this name already exists.", "warning");
            } else {
                swal("Error", "Failed to save pricing slab.", "error");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            swal("Server Error", "Submission failed. Please try again.", "error");
        }
    });
}
</script>





       






