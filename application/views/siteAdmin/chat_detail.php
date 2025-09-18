<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <div class="col main pt-5 mt-3">
        <a href="<?php echo base_url('admin/properties/');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>
        
      <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
      <?php
	  $message = $this->session->flashdata('message');
	  if($message != ''){
	      echo '<div class="alert alert-success">'.$message.'</div>';
		  // Clear flash data after displaying it once
		$this->session->set_flashdata('message', '');
	  }
	  echo validation_errors(); ?>
	  
	  <div class="clearfix"></div>
	  
	  <div class="card mt-3">
    <div class="card-body">
        <form method="post" action="<?php echo base_url('admin/projects/send-reply'); ?>">
            <input type="hidden" name="property_id" value="<?php echo $property_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            
            <div class="form-group">
                <textarea name="message" class="form-control" placeholder="Type your reply here..." required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</div>

	   
    </div>
<script>
jQuery(document).ready(function() {
       var i=1; 
       jQuery('#add').click(function(){  
         i++;  
         jQuery('#label').show();
         jQuery('#dynamic_field').append('<div id="custom'+i+'" class="row"><div class="col-sm-4" id="row'+i+'" class="dynamic-added"><div class="form-group"><input type="text" class="form-control" name="additional[]" value="" placeholder="label"></div></div><div class="col-sm-6" id="row'+i+'" class="dynamic-added"><div class="form-group"><input type="text" class="form-control" placeholder="value" name="custom_value[]" value="" id="custom_value"></div></div><div class="col-sm-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>');  
      });
       jQuery(document).on('click', '.btn_remove', function(){  
           var button_id = jQuery(this).attr("id");   
           jQuery('#custom'+button_id+'').remove();  

      });
});      
 </script>      