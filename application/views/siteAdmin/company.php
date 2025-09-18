<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/company/add');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Add New</a>
    <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
    <div class="clearfix"></div>

    <?php
    $message = $this->session->flashdata('message');
    if($message != ''){
        echo '<div class="alert alert-success">'.$message.'</div>';
    } 
    $this->session->set_flashdata('message','');
    echo validation_errors(); 
    ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table id="datatableCompanies" class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Company Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(!empty($company)) { 
                            $i = 1;
							
                            foreach($company as $c){ 
							?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $c->company_name;?></td>
                                    <td>
                                        <a href="<?php echo base_url().'admin/company/edit/'.$c->id;?>" class="btn btn-success btn-sm editIcon"><i class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo base_url().'admin/company/delete/'.$c->id;?>" class="btn btn-danger btn-sm deleteIcon" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                        <?php $i++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function() {
    jQuery('#datatableCompanies').DataTable();
});
</script>
<!-- JS and DataTables -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
jQuery(document).ready(function() {
    // Initialize DataTable for tags
    jQuery('#datatableTags').DataTable({
        "dom": '<"row"<"col-sm-6"f><"col-sm-6"l>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>'
    });
});
</script>

<style>
/* Search & Pagination fixes like user page */
.dataTables_wrapper .dataTables_filter {
    float: left !important;
    text-align: left !important;
    margin-left: 0 !important;
}

.dataTables_wrapper .dataTables_length {
    float: right !important;
    text-align: right !important;
    margin-right: 0 !important;
}

/* Existing slider and button CSS */
.switch { position: relative; display: inline-block; width: 72px; height: 20px; }
.switch input {display:none;}
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #888888; transition: .4s; }
.slider:before { position: absolute; content: ""; height: 20px; width: 20px; background-color: white; transition: .4s; }
input:checked + .slider { background-color: #0ba038; }
input:focus + .slider { box-shadow: 0 0 1px #0ba038; }
input:checked + .slider:before { transform: translateX(52px); background-color: #ffffff; }
.slider.round { border-radius: 68px; }
.slider.round:before { border-radius: 50%; }
.search_btn { background: #2ed8b6; border-color: #2ed8b6; padding: 2px 15px; transition: all 0.5s ease; color: #fff; font-size: 14px; }
</style>
