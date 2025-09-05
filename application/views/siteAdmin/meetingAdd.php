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
	  
	  <form class="form" method="post" action="<?php echo base_url('admin/meeting/add/').$this->uri->segment('4');?>" enctype="multipart/form-data">
	      <div class="row" id="">
             
	      <div class="col-sm-4">
                <div class="form-group">
					<label>Meeting Time*</label>
                    <input type="datetime-local" name="meeting_date" value="" required class="form-control">				
				</div>
            </div>
	      
         
             <div class="col-sm-4">
                <div class="form-group">
					<label>Purpose</label>
                    <input type="text"  name="purpose" value=""  class="form-control" placeholder="Purpose" required></textarea>
				</div>
            </div>
             <div class="col-sm-4">
                <div class="form-group">
					<label>Meeting Location</label>
                    <input type="text"  name="location" value=""  class="form-control" placeholder="Location" required></textarea>
				</div>
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
					<label>Comment*</label>
                    <textarea  name="comment" value=""  class="form-control" placeholder="Comment" required></textarea>
				</div>
            </div>
            
             <div class="col-sm-6">
    <div class="form-group">
        <label>Properties</label>
        <div id="propertyFields">
            <div class="propertyRow">
                <input type="text" name="property_id[0][id]" class="form-control d-inline-block" style="width:40%;" placeholder="Property ID" required>
                
                <label class="ml-2">Key:</label>
                <label><input type="radio" name="property_id[0][key]" value="yes" required> Yes</label>
                <label><input type="radio" name="property_id[0][key]" value="no"> No</label>
                
                <button type="button" class="btn btn-sm btn-danger removeRow">X</button>
            </div>
        </div>
        <button type="button" id="addPropertyRow" class="btn btn-sm btn-success mt-2">+ Add New</button>
    </div>
</div>
            
            
             
    <!--         <div class="col-sm-6">-->
    <!--            <div class="form-group">-->
				<!--	<label>Outcome</label>-->
    <!--                 <textarea  name="outcome" value=""  class="form-control" placeholder="Outcome" required></textarea>-->
				<!--</div>-->
    <!--        </div>-->
          
    <!--         <div class="col-sm-6">-->
    <!--            <div class="form-group">-->
				<!--	<label>Offer</label>-->
    <!--                <textarea  name="offer" value=""  class="form-control" placeholder="Offer" required></textarea>-->
				<!--</div>-->
    <!--        </div>-->
    <!--        <div class="col-sm-6">-->
    <!--            <div class="form-group">-->
				<!--	<label>Next Step</label>-->
    <!--                <input type="text"  name="next_step" value=""  class="form-control" placeholder="Next Step" required></textarea>-->
				<!--</div>-->
    <!--        </div>-->
            
            <div class="row">
                <div class="col-sm-12 text-center">
				    <input type="submit" value="Submit" name="save" class="btn btn-primary">
			    </div>
		    </div>
		    
	  </form>
	   
    </div>
    
    <script>
let rowIndex = 1;
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
</script>