<?php
$propertyAdvanceSearchVisible = !empty($_POST) ? 'block' : 'none';
?>

<div class="col main pt-5 mt-3">
    <div class="top-div">
        <div>
            <h1 class="d-sm-block heading m-0"><?php echo $title; ?></h1>
        </div>
        <div class="top-btn-div">
            <a href="<?php echo base_url('admin/properties/add'); ?>" class="btn btn-sm btn-info back-btn">Add New</a>
            <?php if ($this->session->userdata('role') == 'Admin'): ?>
                
                <a href="<?php echo base_url('admin/approvel'); ?>" class="btn btn-sm btn-info back-btn">Approval</a>
                <button type="button" onclick="export_properties()" class="btn btn-sm btn-primary back-btn">Export</button>
                <a href="<?php echo base_url('admin/properties/import_page'); ?>" class="btn btn-sm btn-success back-btn">Import</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>

<?php
    // This part handles the initial message after delete/add/update
    $message = $this->session->flashdata('message');
    if (!empty($message)) {
        $alertClass = (strpos(strtolower($message), 'delete') !== false) ? 'alert-danger' : 'alert-success';
        ?>
        <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert" id="flashMessage">
            <?php echo $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <?php
        $this->session->unset_userdata('message'); // Clear flashdata to prevent re-display on refresh
    }
?>
<script>
    // This script makes the initial PHP flash message disappear after 3 seconds
    $(document).ready(function() {
        if ($('#flashMessage').length > 0) {
            setTimeout(function() {
                $('#flashMessage').fadeOut('slow', function () {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>

     <div class="row" style="margin-bottom:20px;">
        <div class="col-md-3">
            <select id="bulk_status" class="form-control">
                <option value="">Change Status</option>
                <option value="active">Active</option>
                <option value="deactivate">Deactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <button id="applyStatus" class="btn btn-primary">Apply to Selected</button>
        </div>
    

    <div class="row" style="margin:10px;">
        <a href="javascript:void(0);" class="advance-search-toggle">Advance Search</a>
    </div></div>

    <form method="post" action="" class="advance-search-form mt-3" style="display: <?php echo $propertyAdvanceSearchVisible; ?>;" id="propertyFilterForm">
        <div class="row">
            <div class="form-group col-sm-2">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Property Name" value="<?php echo set_value('name', isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''); ?>">
            </div>
            <div class="form-group col-sm-2">
                <label>Type:</label>
                <select name="property_type" class="form-control" id="propertyType">
                    <option value="">Select Type</option>
                    <option value="Independent House / Kothi" <?php echo (isset($_POST['property_type']) && $_POST['property_type'] == 'Independent House / Kothi') ? 'selected' : ''; ?>>Independent House / Kothi</option>
                    <option value="Apartment / Flat" <?php echo (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment / Flat') ? 'selected' : ''; ?>>Apartment / Flat</option>
                    <option value="Residential Plot" <?php echo (isset($_POST['property_type']) && $_POST['property_type'] == 'Residential Plot') ? 'selected' : ''; ?>>Residential Plot</option>
                    
                    
                   
                </select>
            </div>
         <div class="form-group col-sm-2" id="bhkGroup" style="display: <?php echo (isset($_POST['property_type']) && $_POST['property_type'] == 'Apartment / Flat') ? 'block' : 'none'; ?>;">
    <label>BHK:</label>
    <select name="bhk" class="form-control">
        <option value="">Select BHK</option>
        <?php 
        $property_typesbhk = rentPropertyType();

        foreach ($property_typesbhk as $option) {
            $selected = (isset($_POST['bhk']) && $_POST['bhk'] == $option) ? 'selected' : '';
            echo "<option value='$option' $selected>$option</option>";
        }
        ?>
    </select>
</div>


            <div class="form-group col-sm-2">
                <label>Property For:</label>
                <select name="property_for" class="form-control">
                    <option value="">Select Property For</option>
                    <option value="Sale" <?php echo (isset($_POST['property_for']) && $_POST['property_for'] == 'Sale') ? 'selected' : ''; ?>>Sale</option>
                    <option value="Buy" <?php echo (isset($_POST['property_for']) && $_POST['property_for'] == 'Buy') ? 'selected' : ''; ?>>Buy</option>
                    <option value="Rent" <?php echo (isset($_POST['property_for']) && $_POST['property_for'] == 'Rent') ? 'selected' : ''; ?>>Rent</option>
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label>Min Budget:</label>
                <input type="number" name="min_budget" class="form-control" placeholder="Enter min budget" value="<?php echo isset($_POST['min_budget']) ? htmlspecialchars($_POST['min_budget']) : ''; ?>">
            </div>
            <div class="form-group col-sm-2">
                <label>Max Budget:</label>
                <input type="number" name="max_budget" class="form-control" placeholder="Enter max budget" value="<?php echo isset($_POST['max_budget']) ? htmlspecialchars($_POST['max_budget']) : ''; ?>">
            </div>
            <div class="form-group col-sm-2">
                <label>Address:</label>
                <input type="text" name="address" class="form-control" placeholder="Enter address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
            </div>
            <div class="form-group col-sm-12 mt-2">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="<?php echo base_url('admin/properties'); ?>" class="btn btn-secondary btn-sm ml-2">Reset</a>
            </div>
        </div>
    </form>


    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-3" id="propertyTabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#allProperties" role="tab">All</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="active-tab" data-toggle="tab" href="#activeProperties" role="tab">Live</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="deactive-tab" data-toggle="tab" href="#deactiveProperties" role="tab">Deactive</a>
      </li>
    </ul>


<div class="tab-content" id="propertyTabsContent">
  <div class="tab-pane fade show active" id="allProperties" role="tabpanel">
    <div class="table-responsive">
                <table id="propertiesTable" class="table table-striped table-bordered table-sm display" nowrap="true">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" /></th>
                            <th>Sr. No.</th>
                            <th>Property Name</th>
                            <th>Property Address</th>
                            <th>Property For/ ID</th>
                            <th>Phone</th>
                            <th>Budget</th>
                            
                            <th>Data Source</th>
                            <th>Status</th>
                            <th class="d-none">Raw Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($properties)): $i = 1; foreach ($properties as $property): ?>
                            <tr>
                                
                                <td><input type="checkbox" class="property_checkbox" value="<?php echo $property->id; ?>"></td>
                                <td><?php echo $i++; ?></td>
                                <td>
                                  <a href="/admin/properties/edit/<?php echo $property->id; ?>">
                                    <?php echo $property->name; ?>
                                  </a>
                                </td>
                                 <td><?php echo $property->address; ?></td>
                                <td>
                                    <?php echo htmlspecialchars($property->property_for); ?><br>
                                    <small>ID: <?php echo htmlspecialchars($property->id); ?></small>
                                </td>
                                <td><?php echo $property->phone; ?></td>
<td>
    <?php
        $value = '-';

        if ($property->id < 1173) {
            // ---- Budget logic ----
            $budget = trim($property->budget);
            $budget_in_words = trim($property->budget_in_words);

            if (!empty($budget)) {
                // Split number aur unit alag karo
                $parts = preg_split('/\s+/', $budget);
                $num = isset($parts[0]) ? trim($parts[0]) : '';
                $unit = isset($parts[1]) ? strtolower(trim($parts[1])) : '';

                if (is_numeric($num)) {
                    $numericVal = (float)$num; // float rakha decimal handle karne ke liye

                    if (!empty($unit)) {
                        // Agar unit diya hua hai (crore/lakh) → wahi dikhado
                        $value = $numericVal . ' ' . ucfirst($unit);
                    } else {
                        // Agar unit nahi hai to apna rule lagao
                        if ($numericVal <= 20) {
                            $value = $numericVal . ' Cr';
                        } else {
                            $value = $numericVal . ' Lakh';
                        }
                    }
                } else {
                    // Non-numeric case me jo likha hai wahi dikhado
                    $value = $budget;
                }
            } elseif (!empty($budget_in_words)) {
                $value = $budget_in_words;
            }
        } else {
            // ---- Sirf budget_in_words show karo ----
            if (!empty($property->budget_in_words)) {
                $value = $property->budget_in_words;
            }
        }

        echo htmlspecialchars($value);
    ?>
</td>



                             <td>
                            <?php if (!empty($property->main_site)): ?>
                                <?php if (strtolower(trim($property->main_site)) == 'frontend'): ?>
                                    <div>Frontend</div>
                                    <div>
                                        <small>By: <?php echo !empty($property->user_name) ? htmlspecialchars($property->user_name) : 'N/A'; ?></small>
                                    </div>
                                <?php else: ?>
                                    <a href="<?php echo $property->property_url; ?>" target="_blank">
                                        <?php echo htmlspecialchars($property->clone_site); ?>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                Manual
                            <?php endif; ?>
                        </td>
                                <td>
    <label class="switch">
        <input type="checkbox" 
               value="<?php echo $property->status == 'active' ? 'active' : 'deactivate'; ?>" 
               <?php echo $property->status == 'active' ? 'checked' : ''; ?> 
               name="status" 
               class="status" 
               data-id="<?php echo $property->id; ?>">
        <span class="slider round"></span>
    </label>
</td>
                                <td class="d-none"><?php echo $property->status; ?></td>

                                <td>
                                    <a href="<?php echo base_url('admin/properties/edit/' . $property->id); ?>" class="btn btn-warning btn-sm" style="color:white;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($this->session->userdata('role') !== 'Agent'): ?>
                                        <a href="<?php echo base_url('admin/properties/delete/' . $property->id); ?>" class="btn btn-danger btn-sm" style="color:white;" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($this->session->userdata('role') === 'Agent'): ?>
                                        <a href="https://bestpropertiesmohali.com/" target="_blank" class="btn btn-success btn-sm">View</a>
                                    <?php endif; ?>
                                </td>
                                
                                
                                
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>

    <!-- Import Modal -->
    <div style="margin-top: 28%;" class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?php echo base_url('admin/properties/import'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Properties (CSV)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="import_file" accept=".csv" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<script>
// Custom sorting for Status column
jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "status-type-pre": function (data) {
        // Agar input checked hai to 'active', warna 'deactivate'
        return $(data).find('input[type="checkbox"]').is(':checked') ? 'active' : 'deactivate';
    },
    "status-type-asc": function (a, b) {
        return a < b ? -1 : (a > b ? 1 : 0);
    },
    "status-type-desc": function (a, b) {
        return a < b ? 1 : (a > b ? -1 : 0);
    }
});


$(document).on('change', '.status', function () {
    let id = $(this).data('id');
    let status = $(this).is(':checked') ? 'active' : 'deactivate';

   $.post('your_controller/update_status', { list_id: id, status: status }, function (resp) {
    console.log(resp);


    });
});

jQuery(document).ready(function() {
    // Initialize DataTables
    var table = $('#propertiesTable').DataTable({
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "pageLength": 25,
        "columnDefs": [
            { "orderable": false, "targets": [0, 10] }, // Disable sorting on checkbox and Raw Status
            { "property_type": "string", "targets": 2 },
            { "type": "status-type", "targets": 9 } // Custom sorting for Status column
        ]
    });

    function filterProperties(status) {
        if (status === 'all') {
            table.column(10).search('').draw(); // Clear filter for "All Properties"
        } else {
            table.column(10).search('^' + status + '$', true, false).draw(); // Exact match for status
        }
    }

  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var target = $(e.target).attr("href");
        if (target === '#allProperties') {
            filterProperties('all');
        } else if (target === '#activeProperties') {
            filterProperties('active');
        } else if (target === '#deactiveProperties') {
            filterProperties('deactivate');
        }
    });

    // Toggle advanced search form
    $(".advance-search-toggle").click(function() {
        $(".advance-search-form").slideToggle("fast");
    });

    // Toggle BHK field
    function toggleBHK() {
        const selectedType = $('#propertyType').val();
        if (selectedType === 'Apartment / Flat') {
            $('#bhkGroup').show();
        } else {
            $('#bhkGroup').hide();
            $('#bhkGroup select').val('');
        }
    }
    toggleBHK();
    $('#propertyType').on('change', function() {
        toggleBHK();
    });

    // Select all checkboxes
    $("#checkAll").click(function() {
        $(".property_checkbox").prop('checked', $(this).prop('checked'));
    });

    // Apply bulk status
    $("#applyStatus").click(function() {
        var status = $("#bulk_status").val();
        if (status == "") {
            alert("Please select a status.");
            return;
        }
        var propertyIds = $(".property_checkbox:checked").map(function() {
            return $(this).val();
        }).get().join(",");
        if (propertyIds == "") {
            alert("Please select at least one property.");
            return;
        }
        $.ajax({
            url: "<?php echo base_url('admin/properties/updateBulkStatus'); ?>",
            method: "POST",
            data: {
                property_ids: propertyIds,
                status: status
            },
            success: function(response) {
                alert("Status updated successfully!");
                location.reload();
            }
        });
    });

   
    $('.status').click(function() {
        var status = $(this).is(':checked') ? 'active' : 'deactivate';
        var dat_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/properties/updateStatus'); ?>",
            data: {
                status: status,
                list_id: dat_id
            },
            success: function(data) {
                // FIX: Do NOT reload the page. Show a dynamic message instead.

                // 1. Create the success message element
                var successMsg = '<div class="alert alert-success alert-dismissible fade show" role="alert" id="dynamic-alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">Status updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';

                // 2. Add it to the body of the page
                $('body').append(successMsg);

                // 3. Set a timer to make it fade out and disappear after 3 seconds
                setTimeout(function() {
                    $('#dynamic-alert').fadeOut('slow', function () {
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function() {
                // If the update fails, flip the switch back to its original state
                element.prop('checked', !element.prop('checked'));
                alert('Failed to update status. Please try again.');
            }
        });
    });
});

function export_properties() {
    window.location.href = 'properties/export_page';
}

// // Export properties
// function export_properties() {
//     $.ajax({
//         url: '<?php echo base_url("admin/properties/export_page"); ?>',
//         method: 'POST',
//         data: $('#propertyFilterForm').serialize(),
//         xhrFields: {
//             responseType: 'blob'
//         },
//         success: function(data, status, xhr) {
//             const filename = xhr.getResponseHeader('Content-Disposition')?.split('filename=')[1]?.replace(/"/g, '') || 'properties_export.csv';
//             const url = window.URL.createObjectURL(data);
//             const a = document.createElement('a');
//             a.href = url;
//             a.download = filename;
//             document.body.appendChild(a);
//             a.click();
//             a.remove();
//             window.URL.revokeObjectURL(url);
//         },
//         error: function(xhr) {
//             alert("Error exporting properties.");
//         }
//     });
//}
</script>

<style>
/* DataTables styling */
div.dataTables_wrapper div.dataTables_length {
    float: right;
    margin-right: 20px;
}
div.dataTables_wrapper div.dataTables_filter {
    float: left;
}

/* Switch styling */
.switch {
    position: relative;
    display: inline-block;
    width: 72px;
    height: 20px;
}
.switch input {
    display: none;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #888888;
    transition: .4s;
}
.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    background-color: white;
    transition: .4s;
}
input:checked + .slider {
    background-color: #0ba038;
}
input:focus + .slider {
    box-shadow: 0 0 1px #0ba038;
}
input:checked + .slider:before {
    transform: translateX(52px);
    background-color: #ffffff;
    background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230ba038' fill-opacity='0.4' fill-rule='evenodd'/%3E%3C/svg%3E");
}
.slider.round {
    border-radius: 68px;
}
.slider.round:before {
    border-radius: 50%;
}
</style>