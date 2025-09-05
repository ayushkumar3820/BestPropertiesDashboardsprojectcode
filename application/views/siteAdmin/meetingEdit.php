<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/leads/meetings/').$this->uri->segment('4');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>
    
  <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
  <?php
  $message = $this->session->flashdata('message');
  if($message != ''){
      echo '<div class="alert alert-success">'.$message.'</div>';
  }
  echo validation_errors(); ?>
  
  <div class="clearfix"></div>
  
  <form class="form" method="post" action="<?php echo base_url('admin/meeting/edit/').$this->uri->segment('4').'/'.$this->uri->segment('5');?>" enctype="multipart/form-data">
      <div class="row">
         
      <div class="col-sm-3">
            <div class="form-group">
                <label>Meeting Time*</label>
                <input type="datetime-local" name="meeting_date" value="<?php echo date('Y-m-d\TH:i', strtotime($meeting->meeting_date)); ?>" required class="form-control">				
            </div>
        </div>
      
       <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="Schedule" <?php echo ($meeting->status == 'Schedule') ? 'selected' : ''; ?>>Schedule</option>
                    <option value="Complete" <?php echo ($meeting->status == 'Complete') ? 'selected' : ''; ?>>Complete</option>
                    <option value="Reschedule" <?php echo ($meeting->status == 'Reschedule') ? 'selected' : ''; ?>>Reschedule</option>
                </select>			
            </div>
        </div> 
        
         <div class="col-sm-6">
            <div class="form-group">
                <label>Purpose</label>
                <input type="text"  name="purpose" value="<?php echo $meeting->purpose; ?>"  class="form-control" placeholder="Purpose" required>
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <label>Comment*</label>
                <textarea  name="comment" class="form-control" placeholder="Comment" required><?php echo $meeting->comment; ?></textarea>
            </div>
        </div>
        
          <div class="col-sm-6">
            <div class="form-group">
                <label>Meeting Location</label>
                <input type="text"  name="location" value="<?php echo $meeting->location; ?>"  class="form-control" placeholder="Location" required>
            </div>
        </div>
        
         
         <div class="col-sm-6">
            <div class="form-group">
                <label>Outcome</label>
                <textarea  name="outcome" class="form-control" placeholder="Outcome" required><?php echo $meeting->outcome; ?></textarea>
            </div>
        </div>
      
         <div class="col-sm-6">
            <div class="form-group">
                <label>Offer</label>
                <textarea  name="offer" class="form-control" placeholder="Offer" required><?php echo $meeting->offer; ?></textarea>
            </div>
        </div>
         <div class="col-sm-6">
            <div class="form-group">
                <label>Next Step</label>
                <input type="text"  name="next_step" value="<?php echo $meeting->next_step; ?>"  class="form-control" placeholder="Next Step" required>
            </div>
        </div>
<div class="col-sm-12">
    <div class="form-group">
        <div class="properties_dtl">
            <label>Linked Properties</label>
            <div class="row" id="propertyFields">
                <?php if(!empty($meeting->property_data)){ 
                    foreach($meeting->property_data as $i => $row){ ?>
                     
                    <div class="col-sm-3 property-box" style="position:relative; border:1px solid #ddd; padding:10px; margin:5px; border-radius:5px;">
                        
                        <!-- Remove button -->
                        <button type="button" class="removeProperty btn btn-danger btn-sm" 
                                style="position:absolute; top:5px; right:5px; padding:2px 6px;">
                            ×
                        </button>

                        <p><strong><?php echo $row['name']; ?></strong></p>
                        <p><?php echo $row['person']; ?></p>
                        <p><?php echo $row['phone']; ?></p>
                        <p>
                            <?php if(!empty($row['person_address'])) { ?>
                                <?php echo $row['person_address']; ?>
                            <?php } else { ?>
                                <span class="text-muted">No address</span>
                                <a href="javascript:void(0);" 
                                   class="editAddress" 
                                   data-id="<?php echo $row['id']; ?>">
                                   <i class="fa fa-edit"></i> Edit
                                </a>
                            <?php } ?>
                        </p>

                        <label class="ml-2">Key:</label>
                        <label><input type="radio" name="property_id[<?php echo $i; ?>][key]" value="yes" 
                            <?php echo ($row['key']=="yes" ? "checked" : ""); ?>> Yes</label>
                        <label><input type="radio" name="property_id[<?php echo $i; ?>][key]" value="no" 
                            <?php echo ($row['key']=="no" ? "checked" : ""); ?>> No</label>
                        
                        <!-- Hidden field -->
                        <input type="hidden" name="property_id[<?php echo $i; ?>][id]" value="<?php echo $row['id']; ?>">

                    </div>
                <?php } } else { ?>
                    <p class="text-muted">No properties linked yet.</p>
                <?php } ?>
            </div>
        </div>
    </div>  

    <button type="button" id="addPropertyRow" class="btn btn-sm btn-success">+ Add New</button>
</div>


        
        
        <div class="row">
            <div class="col-sm-12 text-center">
                <input type="submit" value="Update" name="save" class="btn btn-primary">
            </div>
        </div>
  </form>

<!-- Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="propertyId">
        <input type="text" id="newAddress" class="form-control" placeholder="Enter new address">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveAddress">Save</button>
      </div>
    </div>
  </div>
</div>


</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).on("click", ".editAddress", function(){
    let propertyId = $(this).data("id");
    $("#propertyId").val(propertyId);
    $("#newAddress").val("");
    $("#addressModal").modal("show");
});

$("#saveAddress").click(function(){
    let propertyId = $("#propertyId").val();
    let address = $("#newAddress").val();

    if(address.trim() === ""){
        alert("Please enter address");
        return;
    }

    $.ajax({
        url: "<?php echo base_url('Siteadmin/Meetings/updateAddress'); ?>",
        type: "POST",
        data: {id: propertyId, person_address: address},
        success: function(res){
            res = res.trim();
            if(res === "success"){
                $("#addressModal").modal("hide");
                $(`.editAddress[data-id='${propertyId}']`).parent().html(address);
            } else if(res === "fail"){
                alert("Update failed. Please try again.");
            } else if(res === "invalid"){
                alert("Invalid data sent.");
            } else {
                alert("Error updating: " + res); // debug ke liye
            }
        },
        error: function(xhr){
            alert("Server error: " + xhr.status);
        }
    });
});
</script>


<script>
let rowIndex = <?php echo !empty($meeting->property_data) ? count($meeting->property_data) : 1; ?>;
document.getElementById('addPropertyRow').addEventListener('click', function(){
    let container = document.getElementById('propertyFields');
    let div = document.createElement('div');
    div.classList.add('propertyRow');
    div.innerHTML = `
        <input type="text" name="property_id[${rowIndex}][id]" class="form-control d-inline-block" style="width:40%;" placeholder="Property ID" required>
        
        <label class="ml-2">Key:</label>
        <label><input type="radio" name="property_id[${rowIndex}][key]" value="yes" required> Yes</label>
        <label><input type="radio" name="property_id[${rowIndex}][key]" value="no"> No</label>
        
        <button type="button" class="btn btn-sm btn-danger removeRow">X</button>
    `;
    container.appendChild(div);
    rowIndex++;
});

// remove row
document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeRow')){
        e.target.parentElement.remove();
    }
});
$(document).on("click", ".removeProperty", function(){
    $(this).closest(".property-box").remove();
});

</script>

<style>

#propertyFields {
    display: flex;
    flex-wrap: wrap;
    gap: 25px; /* yaha gap control karega dbbo ke beech ki spacing */
}

.properties_dtl .col-sm-3 {
    flex: 1 1 calc(25% - 25px); /* 4 box ek row me (responsive rahega) */
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.properties_dtl .col-sm-3:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}



</style>