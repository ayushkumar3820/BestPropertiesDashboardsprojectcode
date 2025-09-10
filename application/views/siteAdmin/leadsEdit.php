<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  
    <div class="col main pt-5 mt-3">
    <div class="button-container">
         <a href="<?= base_url('admin/leads/view/' . $this->uri->segment('4')); ?>" id="leadView">Follow Ups</a>
        <a href="<?= base_url('admin/leads/edit/' . $this->uri->segment('4')); ?>">Requirement</a>
        <!--- <a href='<?= base_url('admin/leadtask/') . $this->uri->segment('4'); ?>'>Meeting and Task </a>-->
        <a href="<?= base_url('admin/leads/personal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Personal Information</a>
        <a href="<?= base_url('admin/leads/deal/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Deal</a>
        <a href="<?= base_url('admin/leads/meetings/' . $this->uri->segment('4')); ?>" id="personalInfoLink">Meetings</a>
        
        
 <?php if (isset($property) && !empty($property) && $property->lead_id > 0): ?>
    <a href="<?php echo base_url().'admin/properties/edit/'.$property->id; ?>" 
       class="btn btn-warning btn-sm" style="color:white;">
        <i class="t"></i> Edit Property
    </a>
<?php endif; ?>

</div>
        <!-- <a href="<?php echo base_url('admin/leadtask/271');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Manage Task</a>-->
        <a href="<?php echo base_url('admin/leads/');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>
       <!--  <a href="<?php echo base_url('admin/meetings/').$this->uri->segment('4');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Meetings</a>-->
      <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
     <?php
$info = $leads[0];
$info->additional_info = !empty($info->additional_info) ? json_decode($info->additional_info, true) : [];

$message = $this->session->flashdata('message1');
if ($message != '') {
    echo '<div class="alert alert-success">' . $message . '</div>';
    $this->session->set_flashdata('message1', '');
}

echo validation_errors();
?>

	  <div class="clearfix"></div>
	  
<form class="form" method="post" action="<?php echo base_url('admin/leads/edit/'.$this->uri->segment('4'));?>">
   
   
   
    <div class="row">
<div class="col-sm-5">
    <div class="min-h">
            <div class="form-group">
                <label>Requirement</label>
                <textarea name="requirement" class="form-control" placeholder="Requirement"><?php echo $info->requirement; ?></textarea>
            </div>
        </div></div>
   <div class="col-sm-7">
    <div class="form-group" style="display:flex; align-items:center;">
        <label style="margin-right:10px;">Additional Requirements</label>
        <button type="button" id="add-requirement" class="btn btn-primary">Add Requirement</button>
    </div>

    <div id="additional-requirements-container">
        <?php 
        $additionalReqs = json_decode($info->new_requirement, true) ?? [''];
        if(empty($additionalReqs)) $additionalReqs = ['']; 
        foreach($additionalReqs as $req): ?>
            <div class="input-group mb-2">
                <input type="text" name="new_requirement[]" class="form-control" value="<?php echo htmlspecialchars($req); ?>" placeholder="Enter requirement">
                <button type="button" class="btn btn-danger remove-btn">X</button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

		   <div class="col-sm-6">
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" placeholder="Description"><?php echo $info->description; ?></textarea>
            </div>

        </div>
        
          
		 <div class="col-sm-3">
            <div class="form-group">
                <label>Preferred Location</label>
                <input type="text" name="preferred_location" value="<?php echo $info->preferred_location; ?>" class="form-control" placeholder="Preferred Location">
            </div>
        </div>
		
		
		
        <!-- 4-column fields -->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="status">Status</label> 
                <select id="status" name="status" class="form-control">
                     <option value="New" <?php if($info->status=='New') { echo 'selected'; }?>>New</option>
                     <option value="Pending" <?php if($info->status=='Pending') { echo 'selected'; }?>>Pending</option>
                     <option value="Contacted" <?php if($info->status=='Contacted') { echo 'selected'; }?>>Contacted</option>
                     <option value="Qualified" <?php if($info->status=='Qualified') { echo 'selected'; }?>>Qualified</option>
                     <option value="Site Visit Scheduled" <?php if($info->status=='Site Visit Scheduled') { echo 'selected'; }?>>Site Visit Scheduled</option>
                     <option value="Site Visited" <?php if($info->status=='Site Visited') { echo 'selected'; }?>>Site Visited</option>
                     <option value="Negotiation" <?php if($info->status=='Negotiation') { echo 'selected'; }?>>Negotiation</option>
                     <option value="Booking Confirmed" <?php if($info->status=='Booking Confirmed') { echo 'selected'; }?>>Booking Confirmed</option>
                     <option value="Document Collection" <?php if($info->status=='Document Collection') { echo 'selected'; }?>>Document Collection</option>
                     <option value="Loan Under Process" <?php if($info->status=='Loan Under Process') { echo 'selected'; }?>>Loan Under Process</option>
                     <option value="Finalized / Closed" <?php if($info->status=='Finalized / Closed') { echo 'selected'; }?>>Finalized / Closed</option>
                     <option value="Follow-up Later" <?php if($info->status=='Follow-up Later') { echo 'selected'; }?>>Follow-up Later</option>
                     <option value="Not Interested" <?php if($info->status=='Not Interested') { echo 'selected'; }?>>Not Interested</option>
                     <option value="Duplicate" <?php if($info->status=='Duplicate') { echo 'selected'; }?>>Duplicate</option>
                     <option value="Invalid Lead" <?php if($info->status=='Invalid Lead') { echo 'selected'; }?>>Invalid Lead</option>
                     
                </select>			
            </div>
        </div>
        
     <div class="col-sm-3">
    <div class="form-group">
        <label>City</label>
        <input type="text" id="cityInput" name="city" 
               value="<?php echo $info->city; ?>" 
               class="form-control" placeholder="City" autocomplete="off">
        <div id="citySuggestions" class="list-group" 
             style="position:absolute; z-index:1000; width:100%; display:none;"></div>
    </div>
</div>

     
            <div class="col-sm-3">
            <div class="form-group">
                <label>Leads Type</label>
                <select name="leads_type" class="form-control">
                    <option value="">Select</option>
                    <option <?php if($info->leads_type=='Seller'){ echo 'selected'; }?> value="Seller">Seller</option>
                    <option <?php if($info->leads_type=='Buyer'){ echo 'selected'; }?> value="Buyer">Buyer</option>
                    <option <?php if($info->leads_type=='Both'){ echo 'selected'; }?> value="Both">Both</option>
                    <option <?php if($info->leads_type=='Investor'){ echo 'selected'; }?> value="Investor">Investor</option>
                  
                    
                </select> 				
            </div>
        </div>
        
        <div class="col-sm-3">
    <div class="form-group">
        <label>Property Type</label>
        <select id="propertyType" name="propertyType" required class="form-control">
            <option value="">Select</option>
            <option value="Residential" <?= isset($info->propertyType) && $info->propertyType=='Residential'?'selected':''; ?>>Residential</option>
            <option value="Commercial"  <?= isset($info->propertyType) && $info->propertyType=='Commercial'?'selected':''; ?>>Commercial</option>
        </select>
    </div>
</div>

<div class="col-sm-3" id="residentialDiv" style="display:none;">
    <div class="form-group">
        <label>Residential</label>
        <select id="residentialOptions" class="form-control">
            <option value="">Select</option>
            <option value="Flat/Apartment"            <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Flat/Apartment'?'selected':''; ?>>Flat/Apartment</option>
            <option value="Independent House/Villa"   <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Independent House/Villa'?'selected':''; ?>>Independent House/Villa</option>
            <option value="Independent/Builder Floor" <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Independent/Builder Floor'?'selected':''; ?>>Independent/Builder Floor</option>
            <option value="Plot"                      <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Plot'?'selected':''; ?>>Plot</option>
            <option value="1RK/Studio Apartment"      <?= isset($info->propertyType_sub) && $info->propertyType_sub=='1RK/Studio Apartment'?'selected':''; ?>>1RK/Studio Apartment</option>
            <option value="Serviced Apartment"        <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Serviced Apartment'?'selected':''; ?>>Serviced Apartment</option>
            <option value="Farmhouse"                 <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Farmhouse'?'selected':''; ?>>Farmhouse</option>
            <option value="Other"                     <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Other'?'selected':''; ?>>Other</option>
        </select>
    </div>
</div>

<div class="col-sm-3" id="commercialDiv" style="display:none;">
    <div class="form-group">
        <label>Commercial</label>
        <select id="commercialOptions" class="form-control">
            <option value="">Select</option>
            <option value="Office"      <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Office'?'selected':''; ?>>Office</option>
            <option value="Retail"      <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Retail'?'selected':''; ?>>Retail</option>
            <option value="Plot/Land"   <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Plot/Land'?'selected':''; ?>>Plot/Land</option>
            <option value="Storage"     <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Storage'?'selected':''; ?>>Storage</option>
            <option value="Industry"    <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Industry'?'selected':''; ?>>Industry</option>
            <option value="Hospitality" <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Hospitality'?'selected':''; ?>>Hospitality</option>
            <option value="Other"       <?= isset($info->propertyType_sub) && $info->propertyType_sub=='Other'?'selected':''; ?>>Other</option>
        </select>
    </div>
</div>

<input type="hidden" name="propertyType_sub" id="propertyType_sub" value="<?= isset($info->propertyType_sub)?$info->propertyType_sub:''; ?>">

<div class="col-sm-3">
            <div class="form-group">
                <label>Project / Builder</label>
                <input type="text" name="Project_Builder" value="<?php echo $info->Project_Builder; ?>" class="form-control" placeholder="Project Builder">
            </div>
        </div>


        <div class="col-sm-3">
            <div class="form-group">
                <label>Budget</label>
                <input type="text" name="budget" value="<?php echo $info->budget;?>" class="form-control" placeholder="Budget"> 				
            </div>
        </div>

   
      
        
        
        
         <div class="col-sm-3">
            <div class="form-group">
                <label>Source</label>
                <select name="source" class="form-control">
                    <option value="">Select</option>
                    <option <?php if($info->source=='Website'){ echo 'selected'; }?> value="Website">Website</option>
                    <option <?php if($info->source=='Social media'){ echo 'selected'; }?> value="Social media">Social media</option>
                    <option <?php if($info->source=='Third Party'){ echo 'selected'; }?> value="Third Party">Third Party</option>
                    <option <?php if($info->source=='Manually'){ echo 'selected'; }?> value="Manually">Manually</option>
                  
                    
                </select> 				
            </div>
        </div>
            <div class="col-sm-3">
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" class="form-control">
                    <option value="">Select</option>
                    <option <?php if($info->priority=='Hot'){ echo 'selected'; }?> value="Hot">Hot***</option>
                    <option <?php if($info->priority=='Cold'){ echo 'selected'; }?> value="Cold">Cold</option>
                     <option <?php if($info->priority=='Normal'){ echo 'selected'; }?> value="Normal">Normal</option>
 
                </select> 				
            </div>
        </div>
            <div class="col-sm-3">
                <?php
                    function match_timeline($optionValue, $input) {
                        $map = [
                            'Urgent' => 'Immediate',
                            'Within week' => 'Within Week',
                            'Within weeks' => 'Within Week',
                            'Within month' => 'Within Month',
                            'Within months' => '1-3 Months',
                            'Up to 6 months' => '3-6 Months',
                            'Later' => '6+ Months'
                        ];

                        $normalizedInput = $map[$input] ?? $input;

                        return strtolower($optionValue) === strtolower($normalizedInput) ? 'selected' : '';
                    }
                ?>
            <div class="form-group">
                <label>Time line</label>
               <select name="timeline" class="form-control">
                    <option value="">Select</option>
                    <option <?= match_timeline('Immediate', $info->timeline); ?> value="Immediate">Immediate</option>
                    <option <?= match_timeline('Within Week', $info->timeline); ?> value="Within Week">Within Week</option>
                    <option <?= match_timeline('Within Month', $info->timeline); ?> value="Within Month">Within Month</option>
                    <option <?= match_timeline('1-3 Months', $info->timeline); ?> value="1-3 Months">1-3 Months</option>
                    <option <?= match_timeline('3-6 Months', $info->timeline); ?> value="3-6 Months">3-6 Months</option>
                    <option <?= match_timeline('6+ Months', $info->timeline); ?> value="6+ Months">6+ Months</option>
                </select>
            </div>
        </div>
        
<?php
$tags = '';
if (!empty($info)) {
    if (is_array($info) && isset($info[0]->leads_tags)) {
        $tags = $info[0]->leads_tags;
    } elseif (is_object($info) && isset($info->leads_tags)) {
        $tags = $info->leads_tags;
    }
}
?>

<div class="form-group">
    <label>Tags</label>
    <div id="tag-container" class="d-flex flex-wrap">
        <input type="text" id="tag-input" class="form-control me-2" placeholder="Add tag" style="width:auto;" />
        <button type="button" id="add-tag-btn" class="btn btn-success">Add</button>
    </div>
   
    <input type="hidden" name="leads_tags" id="leads_tags" value="<?php echo htmlspecialchars($tags); ?>">
</div>

            <?php if (!empty($info->additional_info)): ?>
                <div class="col-sm-12">
                    <h4 class="mt-4">Additional Info</h4>
                    <div class="row">
                        <?php foreach ($info->additional_info as $key => $value): ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label><?= ucwords(str_replace('_', ' ', $key)) ?></label>
                                    <input type="text" name="additional_info[<?= htmlspecialchars($key) ?>]" value="<?= htmlspecialchars($value) ?>" class="form-control" placeholder="<?= ucwords(str_replace('_', ' ', $key)) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>


        
        
        
       
	
		 	
            <div class="col-sm-3 text-center mt-4">
				<input type="submit" value="Submit" name="save" class="btn btn-primary">
			</div>
		</div>	
	
	</form>

<?php if ($logs): ?>
    <h2 class="d-sm-block mb-5">Logs</h2>

    <table class="log-table">
        <thead>
            <tr>
                <th>User</th> <!-- New Column for Username -->
                <th>IP Address</th> <!-- IP Address Column -->
                <th>Date</th> <!-- Date Column -->
                <th>Changes</th> <!-- Consolidated Changes Column -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <?php 
                $contentArray = json_decode($log->content, true);
                $changes = ''; // Initialize an empty string to store changes

                foreach ($contentArray as $field => $change): 
                    // Check if the old and new values are null
                    $oldValue = ($change['old'] === null) ? 'N/A' : "<strong>" . htmlspecialchars($change['old']) . "</strong>";
                    $newValue = ($change['new'] === null) ? 'N/A' : "<strong>" . htmlspecialchars($change['new']) . "</strong>";

                    // Append each change to the $changes string
                    $changes .= "Changed the " . htmlspecialchars($field) . " from '" . $oldValue . "' to '" . $newValue . "'<br>";
                endforeach;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($log->username); ?></td> <!-- Display Username -->
                    <td><?php echo htmlspecialchars($log->ip); ?></td> <!-- IP Address -->
                    <td>
                    <?php echo  date('d M Y h:iA',strtotime($log->rdate)); ?></td> <!-- Date -->
                    <td><?php echo $changes; ?></td> <!-- Consolidated Changes -->
                </tr>
               
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


<style>
.hide-div > div{
    display:none;
}
</style>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    


<script>
document.addEventListener("DOMContentLoaded", function() {
    const propertyType = document.getElementById("propertyType");
    const residentialDiv = document.getElementById("residentialDiv");
    const commercialDiv = document.getElementById("commercialDiv");
    const residentialOptions = document.getElementById("residentialOptions");
    const commercialOptions = document.getElementById("commercialOptions");
    const finalInput = document.getElementById("propertyType_sub");

    function toggleDivs(selectedType) {
        residentialDiv.style.display = "none";
        commercialDiv.style.display = "none";

        if (selectedType === "Residential") {
            residentialDiv.style.display = "block";
        } else if (selectedType === "Commercial") {
            commercialDiv.style.display = "block";
        }
    }

    // Page load ke time jo DB se selected hai wahi dikhana
    toggleDivs(propertyType.value);

    // Type change hone par toggle
    propertyType.addEventListener("change", function() {
        toggleDivs(this.value);
        finalInput.value = "";
    });

    // Subtype select hone par hidden input update karna
    residentialOptions.addEventListener("change", function() {
        finalInput.value = this.value;
    });
    commercialOptions.addEventListener("change", function() {
        finalInput.value = this.value;
    });
});
</script>




<script>
      jQuery(document).ready(function () {
          
          
            jQuery("#tag-input").autocomplete({
        source: function(request, response) {
            jQuery.ajax({
                url: "/Siteadmin/Properties/getTags",  
                type: "POST",
                data: { term: request.term },
                success: function(data) {
                    var parsedData = typeof data === "string" ? JSON.parse(data) : data;
                    response(parsedData);
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            jQuery("#tag-input").val(ui.item.value);
            return false;
        }
    });
    // Store selected tags
          // Store selected tags (load from hidden input)
let tags = [];
if ($("#leads_tags").val() !== "") {
    tags = $("#leads_tags").val().split("~-~");
}
renderTags();
// Function same rahega
function autoAddFieldValue(selector) {
    const val = $(selector).val();
    if (val && !tags.includes(val)) {
        tags.push(val);
        renderTags();
    }
}

// Initial run (edit form ke liye)
autoAddFieldValue("#propertyType");
autoAddFieldValue("#residentialOptions");
autoAddFieldValue("#commercialOptions");
autoAddFieldValue("#priority");
autoAddFieldValue("#leads_type");
autoAddFieldValue("#cityInput");

// Change event bind kar do taaki select karte hi add ho jaye
$("#propertyType, #residentialOptions, #commercialOptions, #priority, #leads_type, #cityInput")
    .on("change", function () {
        autoAddFieldValue(this);
    });
 
// Function to render tag chips
function renderTags() {
    $("#tag-container .tag").remove(); // remove old tags
    tags.forEach((tag, index) => {
        $("#tag-input").before(`
            <span class="tag badge bg-primary me-1 mb-1" style="color:white; margin-right:3px;display: flex;justify-content: center;align-items: center;background: #007485 !important;font-size: 14px;font-weight: normal;text-transform: capitalize;gap: 5px;">
                ${tag} 
                <span class="remove-tag" data-index="${index}" style="cursor:pointer;background: red;border-radius: 100px;display: flex;justify-content: center;align-items: flex-start; padding: 2px;font-size: 15px;height: 20px; width: 20px;">&times;</span>
            </span>
        `);
    });
    $("#leads_tags").val(tags.join("~-~")); // hidden input store
}

            
            // Add tag manually on button click
            $("#add-tag-btn").on("click", function () {
                const tagVal = $("#tag-input").val().trim();
                if (tagVal !== "" && !tags.includes(tagVal)) {
                    tags.push(tagVal);
                    $("#tag-input").val("");
                    renderTags();
                }
            });
            
            // Enter key add support
            $("#tag-input").on("keypress", function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $("#add-tag-btn").click();
                }
            });
            
            // Remove tag
            $(document).on("click", ".remove-tag", function () {
                const index = $(this).data("index");
                tags.splice(index, 1);
                renderTags();
            });
})
            // End Property Tag Code

    // Function to set the active link based on the current URL
    function setActiveLink() {
        const currentUrl = window.location.href;
        
        // Get all links inside the button-container
        const links = document.querySelectorAll('.button-container a');
        
        links.forEach(link => {
            // Get the href value of each link
            const linkUrl = link.getAttribute('href');
            
            // If the link URL matches the current URL, add the active class
            if (currentUrl.includes(linkUrl)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
    
    // Call the function on page load
    window.onload = setActiveLink;
</script>

<script>
jQuery(document).ready(function(){
    
    jQuery('#add-requirement').click(function(){
    let html = `<div class="input-group mb-2">
                    <input type="text" name="new_requirement[]" class="form-control" placeholder="Enter requirement">
                    <button type="button" class="btn btn-danger remove-btn">Remove</button>
                </div>`;
    jQuery('#additional-requirements-container').append(html);
});

jQuery(document).on('click', '.remove-btn', function(){
    jQuery(this).closest('.input-group').remove();
});

    jQuery(document).on('click', '.remove-btn', function(){
        jQuery(this).closest('.input-group').remove();
    });
    
    jQuery('select[name="FollowUpStatus"]').change(function(){
        var followUpId = jQuery(this).data('id');
        var status = jQuery(this).val();
        jQuery.ajax({
            url: '<?php echo base_url("Siteadmin/Leads/updateFollowUpStatus"); ?>',
            type: 'POST',
            data: {
                followUpId: followUpId,
                status: status
            },
            success: function(response) {
                alert('Status updated successfully');

                location.reload();
            }
    });
});
});
</script>

<script>
    const propertyType = document.getElementById("propertyType");
    const residentialDiv = document.getElementById("residentialDiv");
    const commercialDiv = document.getElementById("commercialDiv");
    const residentialOptions = document.getElementById("residentialOptions");
    const commercialOptions = document.getElementById("commercialOptions");
    const finalInput = document.getElementById("propertyType_sub");

    propertyType.addEventListener("change", function () {
        const selectedType = this.value;
        residentialDiv.style.display = "none";
        commercialDiv.style.display = "none";
        finalInput.value = "";

        if (selectedType === "Residential") {
            residentialDiv.style.display = "block";
            finalInput.value = residentialOptions.value;
        } else if (selectedType === "Commercial") {
            commercialDiv.style.display = "block";
            finalInput.value = commercialOptions.value;
        }
    });

    residentialOptions.addEventListener("change", function () {
        finalInput.value = this.value;
    });

    commercialOptions.addEventListener("change", function () {
        finalInput.value = this.value;
    });

    // Auto select on page load (edit mode)
    window.addEventListener("DOMContentLoaded", function () {
        const selectedType = propertyType.value;

        if (selectedType === "residential") {
            residentialDiv.style.display = "block";
            finalInput.value = residentialOptions.value;
        } else if (selectedType === "commercial") {
            commercialDiv.style.display = "block";
            finalInput.value = commercialOptions.value;
        }
    });
</script>
<script>
    // PHP array ko JS me bhej diya
    var cities = <?php echo json_encode(propertyCityAutosuggest()); ?>;

    const input = document.getElementById("cityInput");
    const suggestionBox = document.getElementById("citySuggestions");

    input.addEventListener("keyup", function() {
        const query = this.value.toLowerCase();
        suggestionBox.innerHTML = "";
        
        if (query.length === 0) {
            suggestionBox.style.display = "none";
            return;
        }

        let matches = cities.filter(c => c.toLowerCase().startsWith(query));

        if (matches.length > 0) {
            matches.forEach(city => {
                let div = document.createElement("div");
                div.classList.add("list-group-item");
                div.style.cursor = "pointer";
                div.textContent = city;
                div.onclick = function() {
                    input.value = city;
                    suggestionBox.style.display = "none";
                };
                suggestionBox.appendChild(div);
            });
            suggestionBox.style.display = "block";
        } else {
            suggestionBox.style.display = "none";
        }
    });

    // Input se bahar click hote hi suggestion hide ho jaye
    document.addEventListener("click", function(e) {
        if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.style.display = "none";
        }
    });
</script>




 