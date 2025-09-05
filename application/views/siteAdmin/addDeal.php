<div class="col main pt-5 mt-3">
    <div class="button-container">
        <a href="<?= base_url('admin/leads/view/' . $this->uri->segment('4')); ?>" id="leadView">Follow Ups</a>
        <a href="<?= base_url('admin/leads/edit/' . $this->uri->segment('4')); ?>">Requirement</a>
        <a href="<?= base_url('admin/leads/personal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Personal Information</a>
        <a href="<?= base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" class="active">Deal</a>
         <a href="<?= base_url('admin/leads/meetings/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Meetings</a>
    </div>
    <a href="<?php echo base_url('admin/leads/'); ?>" style="float: right; margin: 14px 2px;"
       class="btn btn-sm btn-info back-btn">Back</a>

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

    <!-- Existing Properties in Deal -->
    <h3 class="d-sm-block heading">Properties in Deal</h3>
    <div class="table-responsive">
        <table class="table table-striped" id="deal-table">
            <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Property Name</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($propertyDeal)) {
                $deal_page = $this->input->get('deal_page') ? $this->input->get('deal_page') : 1;
                $i = ($deal_page - 1) * 4 + 1; // Adjust Sr. No. based on page
                foreach ($propertyDeal as $property) { ?>
                    <tr data-property-id="<?php echo $property->properties_id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $property->name; ?></td>
                        <td>
                            <select name="interestedDropDown" data-id="<?php echo $property->properties_id; ?>">
                                <option value="Interested" <?php if ($property->status == 'Interested') echo 'selected'; ?>>
                                    Interested
                                </option>
                                <option value="Not Interested" <?php if ($property->status == 'Not Interested') echo 'selected'; ?>>
                                    Not Interested
                                </option>
                            </select>
                        </td>
                    </tr>
                    <?php $i++;
                }
            } ?>
            </tbody>
        </table>
        <!-- Deal Pagination Links -->
        <div class="pagination">
            <?php //echo $deal_pagination; ?>
        </div>
    </div>

    <!-- Add Property Manually -->
    <h3 class="d-sm-block heading">Add Property Manually</h3>
    <form class="form" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Add property by ID</label>
                    <input type="number" name="addProperty" value="" class="form-control"
                           placeholder="Enter Property ID">
                </div>
            </div>
       
        <div class="row">
            <div class="col-sm-3">
                <input type="submit" value="Submit" name="save" class="btn btn-primary mt-4">
            </div>
        </div>
         </div>
    </form>

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
    <button type="submit" class="btn btn-sm btn-success">
        Add to Deal
    </button>
</form>

                            <a href="<?= base_url('admin/properties/edit/' . $property->id); ?>"
                               class="btn btn-sm btn-info" style="color: white;">
                                View
                            </a>
                        </td>
                    </tr>
                    <?php $i++;
                }
            } ?>
            </tbody>
        </table>
        <!-- Matching Properties Pagination Links -->
        <div class="pagination">
            <?php // echo $matching_pagination; ?>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function () {
        $(document).on('click', '.add-property-btn', function () {
    var propertyId = $(this).data('property-id');

    $.post("<?php echo base_url('admin/leads/addPropertyToDeal'); ?>", 
        { addProperty: propertyId, save: 1 }, 
        function(response) {
            alert('Property added to deal successfully!');
        }
    );
});

        // Handle existing property status change
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

        // Handle add property button click
        jQuery(document).on('click', '.add-property-btn', function () {
            var propertyId = jQuery(this).data('property-id');
            var propertyName = jQuery(this).data('property-name');
            var leadId = '<?php echo $this->uri->segment("4"); ?>';

            jQuery.ajax({
                url: '<?php echo base_url("Siteadmin/Leads/addDealProperty"); ?>',
                type: 'POST',
                data: {propertyId: propertyId, leadId: leadId},
                success: function () {
                    // Reload page to update tables and pagination
                    window.location.reload();
                },
                error: function () {
                    alert('Error adding property. Please try again.');
                }
            });
        });
    });
</script>

<style>
    .table-responsive {
        margin-bottom: 30px;
    }

    .add-property-btn,
    .view-property-btn {
        font-size: 12px;
        padding: 5px 10px;
    }

    .alert {
        margin-bottom: 20px;
    }

    .button-container a.active {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        padding: 8px 15px;
    }

    .thead-dark th {
        background-color: #343a40;
        color: white;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination a {
        margin: 0 5px;
        padding: 8px 12px;
        border: 1px solid #007bff;
        border-radius: 4px;
        color: #007bff;
        text-decoration: none;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: white;
    }

    .pagination .active a {
        background-color: #007bff;
        color: white;
    }
</style>