<?php
// Replace the properties in deal section in your view file with this:
?>

<div class="col main pt-5 mt-3">
    <div class="button-container">
        <a href="<?= base_url('admin/leads/view/' . $this->uri->segment('4')); ?>" id="leadView">Follow Ups</a>
        <a href="<?= base_url('admin/leads/edit/' . $this->uri->segment('4')); ?>">Requirement</a>
        <a href="<?= base_url('admin/leads/personal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Personal Information</a>
        <a href="<?= base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" class="active">Deal</a>
        <a href="<?= base_url('admin/leads/meetings/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Meetings</a>
    </div>
    <a href="<?php echo base_url('admin/leads/'); ?>" style="float: right; margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>

    <?php
    $message = $this->session->flashdata('message1');
    if ($message != '') {
        echo '<div class="alert alert-success">' . $message . '</div>';
    }
    $this->session->set_flashdata('message1', '');
    $error = $this->session->flashdata('error');
    if ($error != '') {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    $this->session->set_flashdata('error', '');
    echo validation_errors();
    ?>

    <div class="page-wrapper">
        <!-- WhatsApp Status Alert -->
        <div id="whatsapp-status" class="alert" style="display: none;"></div>

        <!-- Existing Properties in Deal -->
        <h3 class="d-sm-block heading">Properties in Deal</h3>
        <div class="table-responsive">
            <table class="table table-striped" id="deal-table">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Property Name</th>
                        <th>Status</th>
                        <!-- <th>WhatsApp Status</th> -->
                        <!-- <th>WhatsApp</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($propertyDeal)) {
                        $deal_page = $this->input->get('deal_page') ? $this->input->get('deal_page') : 1;
                        $i = ($deal_page - 1) * 4 + 1;
                        foreach ($propertyDeal as $property) { 
                            // Check if WhatsApp contact exists for this lead - with error handling
                            $whatsapp_exists = false;
                            if (method_exists($this->AdminModel, 'checkWhatsappContact') && isset($leadData->mobile)) {
                                try {
                                    $whatsapp_exists = $this->AdminModel->checkWhatsappContact($leadData->mobile);
                                } catch (Exception $e) {
                                    log_message('error', 'Error checking WhatsApp contact: ' . $e->getMessage());
                                }
                            }
                            ?>
                            <tr data-property-id="<?php echo $property->properties_id; ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $property->name; ?></td>
                                <td>
                                    <select name="interestedDropDown" data-id="<?php echo $property->properties_id; ?>" style="width:35% !important;">
                                        <option value="Interested" <?php if ($property->status == 'Interested') echo 'selected'; ?>>Interested</option>
                                        <option value="Not Interested" <?php if ($property->status == 'Not Interested') echo 'selected'; ?>>Not Interested</option>
                                    </select>
                                </td>
                                
                                <!-- <td>
                                    <?php if ($whatsapp_exists): ?>
                                        <button class="btn btn-sm btn-success send-whatsapp-btn" 
                                                data-property-id="<?php echo $property->properties_id; ?>" 
                                                data-property-name="<?php echo htmlspecialchars($property->name); ?>"
                                                data-lead-phone="<?php echo isset($leadData->mobile) ? $leadData->mobile : ''; ?>"
                                                data-lead-name="<?php echo isset($leadData->uName) ? htmlspecialchars($leadData->uName) : 'Lead'; ?>">
                                            Send Message
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled title="WhatsApp not connected">
                                            Not Available
                                        </button>
                                        <a href="<?= base_url('admin/whatsapp/firstMessage'); ?>" class="btn btn-sm btn-info" target="_blank">
                                            Add Contact
                                        </a>
                                    <?php endif; ?>
                                </td> -->
                            </tr>
                        <?php $i++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-center">No properties in deal</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Add Property Manually -->
        <h3 class="d-sm-block heading">Add Property Manually</h3>
        <form class="form" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Add property by ID</label>
                        <input type="number" name="addProperty" value="" class="form-control" placeholder="Enter Property ID">
                    </div>
                </div>
                <div class="col-sm-3">
                    <input type="submit" value="Submit" name="save" class="btn btn-primary mt-5">
                </div>
            </div>
        </form>

        <!-- Recommended Properties -->
        <h3 class="d-sm-block heading">Recommended Properties</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="recommended-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Sr. No.</th>
                        <th>Property Name</th>
                        <th>Budget</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($matchingProperties)) {
                        $matching_page = $this->input->get('matching_page') ? $this->input->get('matching_page') : 1;
                        $i = ($matching_page - 1) * 4 + 1;
                        foreach ($matchingProperties as $property) { ?>
                            <tr data-property-id="<?php echo $property->id; ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php echo htmlspecialchars($property->name); ?></td>
                                <td>₹<?php echo number_format($property->budget); ?></td>
                                <td>
                                    <form method="post" action="<?php echo current_url(); ?>">
                                        <input type="hidden" name="addProperty" value="<?php echo $property->id; ?>">
                                        <input type="hidden" name="save" value="1">
                                        <button type="submit" class="btn btn-sm btn-success">Add to Deal</button>
                                    </form>
                                    <a href="<?= base_url('admin/properties/edit/' . $property->id); ?>" class="btn btn-sm btn-info" style="color: white;">View</a>
                                </td>
                            </tr>
                        <?php $i++;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No recommended properties</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        // WhatsApp send functionality with better error handling
        jQuery(document).on('click', '.send-whatsapp-btn', function() {
            var button = jQuery(this);
            var propertyId = button.data('property-id');
            var propertyName = button.data('property-name');
            var leadPhone = button.data('lead-phone');
            var leadName = button.data('lead-name');

            console.log('Sending WhatsApp message:', {
                propertyId: propertyId,
                propertyName: propertyName,
                leadPhone: leadPhone,
                leadName: leadName
            });

            // Validate data
            if (!propertyId || !leadPhone || !leadName) {
                showAlert('error', 'Missing required information. Please refresh the page and try again.');
                return;
            }

            var message = 'Hi ' + leadName + ',\n\nI wanted to share details about: ' + propertyName + '\n\nPlease let me know if you have any questions.';

            var postData = {
                propertyId: propertyId,
                leadPhone: leadPhone,
                leadId: '<?php echo $this->uri->segment("4"); ?>',
                message: message
            };

            jQuery.ajax({
                url: '<?php echo base_url("admin/leads/sendWhatsappFromDeal"); ?>',
                type: 'POST',
                data: postData,
                dataType: 'json',
                beforeSend: function() {
                    button.html('Sending...').prop('disabled', true);
                },
                success: function(response) {
                    console.log('Success response:', response);
                    
                    if (response && response.status === 'success') {
                        showAlert('success', response.msg);
                        button.removeClass('btn-success').addClass('btn-info').html('Message Sent');
                        setTimeout(function() {
                            button.html('Send Message').removeClass('btn-info').addClass('btn-success').prop('disabled', false);
                        }, 5000);
                    } else {
                        showAlert('error', response.msg || 'Unknown error occurred');
                        button.html('Send Message').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error Details:', {
                        xhr: xhr,
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });
                    
                    var errorMsg = 'Network error occurred.';
                    if (xhr.responseText) {
                        errorMsg = 'Server error: ' + xhr.status + ' - Please try again.';
                    }
                    
                    showAlert('error', errorMsg);
                    button.html('Send Message').prop('disabled', false);
                }
            });
        });

        // Function to show alerts
        function showAlert(type, message) {
            var alertClass = (type === 'success') ? 'alert-success' : 'alert-danger';
            var alertDiv = jQuery('#whatsapp-status');
            
            if (alertDiv.length === 0) {
                jQuery('.page-wrapper').prepend('<div id="whatsapp-status" class="alert" style="display: none;"></div>');
                alertDiv = jQuery('#whatsapp-status');
            }
            
            alertDiv.removeClass('alert-success alert-danger')
                   .addClass(alertClass)
                   .html(message)
                   .show();
            
            setTimeout(function() {
                alertDiv.fadeOut();
            }, 8000);
            
            jQuery('html, body').animate({
                scrollTop: alertDiv.offset().top - 100
            }, 500);
        }

        // Existing functionality
        jQuery('select[name="interestedDropDown"]').change(function () {
            var pId = jQuery(this).data('id');
            var status = jQuery(this).val();
            var leadId = '<?php echo $this->uri->segment("4"); ?>';
            jQuery.ajax({
                url: '<?php echo base_url("Siteadmin/Leads/updateDealStatus"); ?>',
                type: 'POST',
                data: {propertyId: pId, status: status, leadId: leadId}
            });
        });
    });
</script>

<style>
    .page-wrapper {
        margin-left: 10px;
    }
    .form .form-group input {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .form .btn-primary {
        margin-top: 31px !important;
        padding: 6px 20px;
        font-size: 14px;
        border-radius: 4px;
    }
    #recommended-table td form,
    #recommended-table td a {
        display: inline-block;
        margin-right: 5px;
    }
    #recommended-table td form button,
    #recommended-table td a.btn {
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 4px;
        text-align: center;
    }
    #recommended-table td {
        vertical-align: middle;
    }
    .table-responsive {
        margin-top: 20px;
    }
    #recommended-table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>