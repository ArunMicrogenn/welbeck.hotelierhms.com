<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Configurations','Sms Configuration');
$this->pfrm->FrmHead3('Configurations / Sms Configuration',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
?>

<style>

.sms-wrapper {
    width: 100%;
    padding: 30px 50px;
    background: #f5f7fa;
    font-family: "Segoe UI", sans-serif;
    min-height: calc(100vh - 150px);
}


.sms-wrapper h2 {
    font-weight: 600;
    font-size: 24px;
    margin-bottom: 25px;
    color: #222;
    padding-bottom: 10px;
    border-bottom: 2px solid #007bff;
}

.form-container {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.form-row {
    display: flex;
    gap: 25px;
    width: 100%;
    margin-bottom: 20px;
    align-items: center;
}

.form-col {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-col label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 0;
    display: block;
    min-width: 160px;
    text-align: right;
}

input, select, textarea {
    flex: 1;
    padding: 10px 14px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 14px;
    background: #fff;
    transition: border 0.3s;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.2);
}


textarea {
    min-height: 120px;
    resize: vertical;
}

/* TABLE STYLES */
.table-container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-top: 20px;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th {
    background: #f8f9fa;
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    padding: 12px 15px;
    border-bottom: 1px solid #dee2e6;
    vertical-align: middle;
}

.table tr:hover {
    background: #f8f9fa;
}


.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn-primary, .btn-secondary {
    padding: 12px 32px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: 0.3s;
    min-width: 120px;
}

.btn-primary {
    background: #007bff;
    color: #fff;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6c757d;
    color: #fff;
}

.btn-secondary:hover {
    background: #545b62;
    transform: translateY(-1px);
}


.table button {
    padding: 6px 12px;
    margin: 0 5px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    transition: 0.2s;
}

.table button:first-child {
    background: #28a745;
    color: white;
}

.table button:first-child:hover {
    background: #218838;
}

.table button:last-child {
    background: #dc3545;
    color: white;
}

.table button:last-child:hover {
    background: #c82333;
}


@media (max-width: 768px) {
    .sms-wrapper {
        padding: 20px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 15px;
    }
    
    .form-col {
        width: auto;
    }
    
    .form-col label {
        text-align: left;
        min-width: auto;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
    }
}

.smallDropdown .select2-results__options {
    max-height: 150px !important;
    overflow-y: auto !important; 
    border-radius: 5px; 
}


.select2-selection {
    height: 40px !important;
    padding: 3px 10px !important;
    border: 1px solid grey;  
    border-radius: 5px !important; 
    font-size: 14px !important;
    display: flex !important;
    align-items: center !important; 
}


.select2-results__option {
    padding: 3px 8px !important; 
    font-size: 13px !important;
}


.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px !important;
    border-radius: 5px !important;
}


#templateType.select2-hidden-accessible + .select2-container--default .select2-selection--single {
    border: 1px solid #007bff !important;
    background: #fff !important;
    height: 36px !important;
    padding: 4px 10px !important;
    border-radius: 5px !important; 
    display: flex !important;
    align-items: center !important;
}


#templateType.select2-hidden-accessible + .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px !important;
    text-align: left;
}


</style>

<body>

<div class="sms-wrapper">
    <h2>SMS Template Configuration</h2>
    <form action="<?php ?>">
    <div class="form-container">
        <div class="form-row">
            <div class="form-col">
                <label for="templateName">Template Name</label>
                <input type="text" id="templateName" name="templateName" placeholder="Enter Template Name" required>
            </div>
        
               <div class="form-col" id="cntbox">
                <label for="smsCount">SMS Template Count</label>
                <input type="number"  id="smsCount" name="smsCount" placeholder="Number of SMS parts" min="1" max="10" value="1"  style="width:20px !important;" disabled>
            </div>
        </div>
        
        <div class="form-row">
        
        <?php  $selqry = "select * from Mas_smstemplatetype";
            $sel = $this->db->query($selqry)->result_array();
            ?>
            <div class="form-col">
                <label for="templateType">Template Type</label>
                <select id="templateType" name="templateType" required>
                    <option value="">Select Type</option>
                    <?php foreach($sel as $sel) {?>
                    <option value="<?php echo $sel['stmpid'] ?>"><?php echo $sel['Templatetype'] ?></option>
                    <?php } ?>

                </select>
            </div>
            
            <div class="form-col" >
             
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <!-- <label for="smsMessage">SMS Message</label>
                <textarea id="smsMessage" name="smsMessage" placeholder="Enter your SMS template here. Use {variable} for dynamic content."></textarea> -->
            </div>
        </div>
    </div>
    
    <div class="table-container" style="overflow-y:scroll;height:300px;">
        <h3 style="margin-bottom: 15px; color: #495057;">Variable Mapping</h3>
        <div class="table-responsive">
            <table class="table table-bordered" id="variableTable">
                <thead>
                    <tr>
                        <th width="40%">Variable Name</th>
                        <th width="40%">Variable Position</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody id="variableBody">
                    <tr>
                        <td  style="display:none"><input type="text" id="count" name="count" value="1"></td>
                        <td>
                        <select class="form-control" name="varField[]" id="varpos_1">
                                <option value="">Select Field</option>
                                <?php if(isset($sel) && !empty($sel)): ?>
                                    <?php 
                                  
                                    // $result = $this->db->query($sel)->result();
                                    // foreach($result as $row): 
                                    ?>
                                    <!-- <option value="<?php echo $row->field_name; ?>"><?php echo $row->display_name; ?></option> -->
                                    <?php //endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td>
                        <input type="text" class="form-control" placeholder="e.g., {customer_name}" name="varName[]" id="varname_1">
                         
                        </td>
                        <td>
                            <button type="button" class="btn-add" onclick="addRow()">+</button>
                            <button type="button" class="btn-remove" onclick="removeRow(this)" disabled>-</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="action-buttons">
        <button type="button" class="btn-primary" onclick="saveTemplate()">Update</button>
        <button type="button" class="btn-secondary" onclick="resetForm()">Reset</button>
    </div>
    </form>
</div>

</body>

<script>
let rowcount = 1;


function addRow() {
    rowcount++;
    document.getElementById("count").value = rowcount;
        document.getElementById("smsCount").value = rowcount;
    const tbody = document.getElementById('variableBody');
    const newRow = tbody.insertRow();
    
    newRow.innerHTML = `
        <td>
            <select class="form-control" name="varField[]" id="varpos_${rowcount}">
                <option value="">Select Field</option>
            </select>
        </td>
        <td>
            <input type="text" class="form-control" placeholder="e.g., {customer_name}" name="varName[]" id="varname_${rowcount}">
        </td>
        <td>
            <button type="button" class="btn-add" onclick="addRow()">+</button>
            <button type="button" class="btn-remove" onclick="removeRow(this)">-</button>
        </td>
    `;

    enableRemoveButtons();


    const templateTypeId = $('#templateType').val();
    if (templateTypeId) {
        $.ajax({
            type: "POST",
            url: "<?php echo scs_index ?>Configurations/get_template_headers",
            data: { id: templateTypeId },
            dataType: "json",
            success: function(headers) {
                const select = $(`#varpos_${rowcount}`);
                select.empty().append('<option value="">Select Field</option>');
                headers.forEach(function(val) {
                    select.append(`<option value="${val}">${val}</option>`);
                });
            }
        });
    }
}


function removeRow(button) {
    const row = button.closest('tr');
    if (rowcount > 1) {
        row.remove();
        rowcount--;

      
        document.getElementById("count").value = rowcount;
        document.getElementById("smsCount").value = rowcount;

        enableRemoveButtons();
    }
}


function enableRemoveButtons() {
    const removeButtons = document.querySelectorAll('.btn-remove');
    removeButtons.forEach((btn, index) => {
        btn.disabled = (index === 0 && rowcount === 1);
    });
}

function saveTemplate() {
  
    const templateName = document.getElementById('templateName').value;
    const templateType = document.getElementById('templateType').value;
    const smsMessage = document.getElementById('smsMessage').value;
    
    if (!templateName || !templateType) {
        alert('Please fill in all required fields');
        return;
    }
    
   
    const variables = [];
    document.querySelectorAll('#variableBody tr').forEach(row => {
        const varName = row.querySelector('input[name="varName[]"]').value;
        const varField = row.querySelector('select[name="varField[]"]').value;
        if (varName && varField) {
            variables.push({ name: varName, field: varField });
        }
    });
  
    const formData = {
        templateName: templateName,
        templateType: templateType,
        smsCount: document.getElementById('smsCount').value,
        status: document.getElementById('status').value,
        smsMessage: smsMessage,
        variables: variables
    };
    

    console.log('Saving template:', formData);
    

    alert('Template saved successfully!');
    

    // resetForm();
}

function resetForm() {
    document.getElementById('templateName').value = '';
    document.getElementById('templateType').selectedIndex = 0;
    document.getElementById('smsCount').value = '1';
    document.getElementById('status').selectedIndex = 0;
    document.getElementById('smsMessage').value = '';
    

    const tbody = document.getElementById('variableBody');
    while (tbody.rows.length > 1) {
        tbody.deleteRow(1);
    }

    const firstRow = tbody.rows[0];
    firstRow.querySelector('input').value = '';
    firstRow.querySelector('select').selectedIndex = 0;
    
    rowCount = 1;
    enableRemoveButtons();
}


document.addEventListener('DOMContentLoaded', function() {
    enableRemoveButtons();
});
</script>


<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#templateType').select2({
        width: '100%',
        dropdownCssClass: 'smallDropdown'
    });
});

$("#templateType").on('change', function () {
    var id = this.value;

    if (!id) return;

    $.ajax({
        type: "POST",
        url: "<?php echo scs_index ?>Configurations/get_template_headers",
        data: { id: id },
        dataType: "json",
        success: function (headers) {
            console.log(headers);
            $('#variableBody select[name="varField[]"]').each(function() {
                const select = $(this);
                select.empty();
                select.append('<option value="">Select Field</option>');

                headers.forEach(function(val) {
                    select.append(`<option value="${val}">${val}</option>`);
                });
            });
        }
    });
});




</script>



