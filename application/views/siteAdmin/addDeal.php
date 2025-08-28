<div class="col main pt-5 mt-3">
    <div class="button-container">
        <a href="<?= base_url('admin/leads/view/' . $this->uri->segment('4')); ?>" id="leadView">Follow Ups</a>
        <a href="<?= base_url('admin/leads/edit/' . $this->uri->segment('4')); ?>">Requirement</a>
        <a href="<?= base_url('admin/leads/personal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Personal
            Information</a>
        <a href="<?= base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" class="active">Deal</a>
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
    <?php
    if (!empty($propertyDeal)) {
        $propertyDeal = array_reverse($propertyDeal);
        $propertyDeal = array_slice($propertyDeal, 0, 4);
        ?>
        <h2 class="d-sm-block heading">Properties in Deal</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Property Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($propertyDeal as $property) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $property->name; ?></td>
                            <td>
                                <select name="interestedDropDown" data-id="<?php echo $property->properties_id; ?>">
                                    <option value="Interested" <?php if ($property->status == 'Interested')
                                        echo 'selected'; ?>>
                                        Interested</option>
                                    <option value="Not Interested" <?php if ($property->status == 'Not Interested')
                                        echo 'selected'; ?>>Not Interested</option>
                                </select>
                            </td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <!-- Add Property Manually -->
    <h2 class="d-sm-block heading">Add Property Manually</h2>
    <form class="form" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Add property by ID</label>
                    <input type="number" name="addProperty" value="" class="form-control"
                        placeholder="Enter Property ID">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <input type="submit" value="Submit" name="save" class="btn btn-primary mt-4">
            </div>
        </div>
    </form>

    <!-- Matching Properties Section -->
    <?php
    $addedIds = !empty($propertyDeal) ? array_column($propertyDeal, 'properties_id') : [];
    $filteredProperties = !empty($matchingProperties) ? array_filter($matchingProperties, function ($p) use ($addedIds) {
        return !in_array($p->id, $addedIds);
    }) : [];
    $filteredProperties = array_slice($filteredProperties, 0, 4); // Show only 4 latest
    ?>
    <h2 class="d-sm-block heading">Recommended Properties</h2>
    <?php if (!empty($filteredProperties)) { ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Sr. No.</th>
                        <th>Property Name</th>
                        <th>Budget</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($filteredProperties as $property) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($property->name); ?></td>
                            <td>₹<?php echo number_format($property->budget); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success add-property-btn"
                                    data-property-id="<?php echo $property->id; ?>"
                                    data-property-name="<?php echo htmlspecialchars($property->name); ?>">
                                    Add to Deal
                                </button>
                                <a href="<?= base_url('admin/properties/edit/' . $property->id); ?>"
                                    class="btn btn-sm btn-info ">
                                    View
                                </a>

                            </td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning">
            <?php if ($this->input->get('search')) { ?>
                No properties found for search term "<?php echo htmlspecialchars($this->input->get('search')); ?>"
            <?php } else { ?>
                No matching properties found based on lead criteria
                (Type: <?php echo isset($leadData->propertyType_sub) ? $leadData->propertyType_sub : 'N/A'; ?>,
                Budget: ₹<?php echo number_format(isset($leadData->max_budget) ? $leadData->max_budget : 0); ?>)
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentUrl = window.location.href;
        const links = document.querySelectorAll('.button-container a');
        links.forEach(function (link) {
            const linkUrl = link.getAttribute('href');
            if (currentUrl.includes(linkUrl)) {
                link.classList.add('active');
            }
        });
    });
</script>

<script>
    jQuery(document).ready(function () {
        // Handle existing property status change
        jQuery('select[name="interestedDropDown"]').change(function () {
            var pId = jQuery(this).data('id');
            var status = jQuery(this).val();
            var leadId = '<?php echo $this->uri->segment("4"); ?>';
            jQuery.ajax({
                url: '<?php echo base_url("Siteadmin/Leads/updateDealStatus"); ?>',
                type: 'POST',
                data: {
                    propertyId: pId,
                    status: status,
                    leadId: leadId
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Error updating status. Please try again.');
                    console.log('Error:', error);
                }
            });
        });

        // Handle add property button click
        jQuery('.add-property-btn').click(function () {
            var propertyId = jQuery(this).data('property-id');
            var propertyName = jQuery(this).data('property-name');
            jQuery.ajax({
                url: '<?php echo current_url(); ?>',
                type: 'POST',
                data: {
                    addProperty: propertyId,
                    save: 1,
                    search: '<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>'
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Error adding property. Please try again.');
                    console.log('Error:', error);
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
</style>