

        <div class="col main pt-5 mt-3">
            

            <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
            <div class="clearfix"></div>
            <?php
        	  $message = $this->session->flashdata('message');
        	  if($message != ''){
        	      echo '<div class="alert alert-success">'.$message.'</div>';
        	  }
        	  
        	  ?>             
            <div class="clearfix"></div>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
		              <!-- <table class="table table-striped"> -->
						<table id="datatable2" class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%">
                         <thead>
						    <tr>
							   <th>Sr. No.</th>
							   <th>Name</th>
							   <th>Email</th>
							   <th>Phone</th>
							   <th>Property ID</th>
							   <th>Type</th>
							   <th>Message</th>
							   <th>Interested In</th>
							</tr>
						 </thead>
						  <tbody>
						      <?php 
						      if(!empty($contacts)) {
						          $i = 1;
						          foreach($contacts as $contact){
						              echo '<tr>
						                <td>'.$i.'</td>
						                <td>'.$contact->fname.'</td>
						                <td>'.$contact->email.'</td>
						                <td>'.$contact->phone.'</td>
						                <td>'.$contact->property.'</td>
						                <td>'.($contact->type == 'contact' ? '' : $contact->type).'</td>
						                <td>'.$contact->message.'</td>
						                <td>'.$contact->subject.'</td>
						              </tr>';
						              $i++;
						          }
						      } ?>
						  </tbody>
					  </table>
					 </div>
                </div>
            </div>
            <!--/row-->

           
          
         </div>
		 <!-- ✅ Scripts add karo -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
jQuery(document).ready(function() {
    jQuery('#datatable2').DataTable({
        "dom": '<"row"<"col-sm-6"f><"col-sm-6"l>>rt<"row"<"col-sm-5"i><"col-sm-7"p>>'
    });
});
</script>

<style>
/* 👇 Search bar left & show entries right (same as users page) */
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
</style>
