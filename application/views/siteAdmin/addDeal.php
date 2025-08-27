<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="col main pt-5 mt-3">
    
    <div class="button-container">
        <a href="<?= base_url('admin/leads/view/' . $this->uri->segment('4')); ?>" id="leadView">Follow Ups</a>
        <a href="<?= base_url('admin/leads/edit/' . $this->uri->segment('4')); ?>">Requirement</a>
        <a href="<?= base_url('admin/leads/personal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Personal Information</a>
        <a href="<?= base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" class="active">Deal</a>
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
    echo validation_errors(); ?>


    <!-- Existing Properties in Deal -->
    <?php if (!empty($propertyDeal)) { ?>
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
                                <option value="Interested" <?php if ($property->status == 'Interested') echo 'selected'; ?>>Interested</option>
                                <option value="Not Interested" <?php if ($property->status == 'Not Interested') echo 'selected'; ?>>Not Interested</option>
                            </select>
                        </td>
                    </tr>
                <?php $i++; } ?>
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
                    <input type="number" name="addProperty" value="" class="form-control" placeholder="Enter Property ID">
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
    <?php if (!empty($matchingProperties)) { 
        // remove already added properties
        $addedIds = array_column($propertyDeal, 'properties_id');
        $filteredProperties = array_filter($matchingProperties, function($p) use ($addedIds) {
            return !in_array($p->id, $addedIds);
        });
    ?>
    <h2 class="d-sm-block heading">Recommended Properties</h2>

    <!-- Search Box -->
    <form method="get" action="<?php echo base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>">
        <div class="row mb-3">
            <div class="col-sm-4">
                <input type="text" name="search" value="<?php echo $this->input->get('search') ? htmlspecialchars($this->input->get('search')) : ''; ?>" class="form-control" placeholder="Search property by name/type...">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="<?php echo base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <?php if (!empty($filteredProperties)) { ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Sr. No.</th>
                    <th>Property Name</th>
                    <th>Type</th>
                    <th>Budget</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = (isset($page_start) ? $page_start : 0) + 1;
                foreach ($filteredProperties as $property) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($property->name); ?></td>
                    <td><?php echo ucfirst($property->property_type); ?> - <?php echo ucfirst($property->type); ?></td>
                    <td>₹<?php echo number_format($property->budget); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success add-property-btn" 
                                data-property-id="<?php echo $property->id; ?>"
                                data-property-name="<?php echo htmlspecialchars($property->name); ?>">
                            Add to Deal
                        </button>
                    </td>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>
    <?php } else { ?>
        <div class="alert alert-warning">No recommended properties available (all already added).</div>
    <?php } ?>

    <!-- Pagination -->
    <?php if (!empty($pagination_links)) { ?>
        <div class="pagination-wrapper">
            <?php 
                // ensure search query stays in pagination links
                echo preg_replace('/href="([^"]+)"/', 'href="$1'.(!empty($_GET['search'])?'&search='.urlencode($_GET['search']):'').'"', $pagination_links); 
            ?>
        </div>
    <?php } ?>

    <?php } else { ?>
    <div class="alert alert-warning">
        <strong>No matching properties found</strong> 
        <?php if ($this->input->get('search')) { ?>
            for search term "<?php echo htmlspecialchars($this->input->get('search')); ?>"
        <?php } else { ?>
            based on lead criteria 
            (<?php echo isset($leadData->propertyType) ? $leadData->propertyType : 'N/A'; ?>, 
            ₹<?php echo number_format(isset($leadData->max_budget) ? $leadData->max_budget : (isset($leadData->budget) ? $leadData->budget : 0)); ?>)
        <?php } ?>
    </div>
    <?php } ?>

</div>

<!-- Hidden form for adding properties via AJAX -->
<form id="addPropertyForm" style="display: none;" method="post" action="<?php echo current_url(); ?>">
    <input type="hidden" name="addProperty" id="hiddenPropertyId">
    <input type="hidden" name="save" value="1">
    <?php if (isset($_GET['search'])) { ?>
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
    <?php } ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const links = document.querySelectorAll('.button-container a');
    links.forEach(function(link) {
        const linkUrl = link.getAttribute('href');
        if (currentUrl.includes(linkUrl)) {
            link.classList.add('active');
        }
    });
});
</script>

<script>
jQuery(document).ready(function(){
    // Handle existing property status change
    jQuery('select[name="interestedDropDown"]').change(function(){
        var pId = jQuery(this).data('id');
        var status = jQuery(this).val();
        var leadId = '<?php echo $this->uri->segment("4"); ?>';
        jQuery.ajax({
            url: '<?php echo base_url("Siteadmin/Leads/updateDealStatus"); ?>',
            type: 'POST',
            data: {
                propertyId : pId,
                status : status,
                leadId : leadId 
            },
            success: function(response) {
                alert('Status updated successfully');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Error updating status. Please try again.');
                console.log('Error:', error);
            }
        });
    });
    
    // Handle add property button click
    jQuery('.add-property-btn').click(function(){
        var propertyId = jQuery(this).data('property-id');
        var propertyName = jQuery(this).data('property-name');
        
        if(confirm('Add "' + propertyName + '" to deal?')) {
            jQuery('#hiddenPropertyId').val(propertyId);
            jQuery('#addPropertyForm').submit();
        }
    });
});
</script>

<style>
.table-responsive {
    margin-bottom: 30px;
}
.add-property-btn {
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
.pagination-wrapper {
    margin-top: 20px;
    text-align: center;
}
.pagination-wrapper .pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}
.pagination-wrapper .pagination li {
    position: relative;
    display: block;
}
.pagination-wrapper .pagination li a,
.pagination-wrapper .pagination li span {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.pagination-wrapper .pagination li a:hover {
    z-index: 2;
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.pagination-wrapper .pagination li.active span {
    z-index: 1;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.pagination-wrapper .pagination li:first-child a,
.pagination-wrapper .pagination li:first-child span {
    margin-left: 0;
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}
.pagination-wrapper .pagination li:last-child a,
.pagination-wrapper .pagination li:last-child span {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
.mb-3 {
    margin-bottom: 1rem !important;
}
</style>
