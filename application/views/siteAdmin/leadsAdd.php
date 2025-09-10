<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="col main pt-5 mt-3">
    <a href="<?php echo base_url('admin/leads/'); ?>" style="float: right; margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>

    <h1 class="d-sm-block heading"><?php echo $title; ?></h1>
    <?php
    $message = $this->session->flashdata('message1');
    if ($message != '') {
        echo '<div class="alert alert-success">' . $message . '</div>';
    }
    $this->session->set_flashdata('message1', '');
    echo validation_errors(); ?>

    <div class="clearfix"></div>

    <form class="form" method="post" action="<?php echo base_url('admin/leads/add'); ?>" enctype="multipart/form-data">

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" required value="" class="form-control" placeholder="Name">
                </div>
            </div>
           <div class="col-sm-3">
   <div class="form-group">
    <label>Phone*</label>
    <input type="text" id="phone" name="phone" class="form-control" 
           placeholder="Phone" maxlength="10" required 
           oninput="this.value=this.value.replace(/[^0-9]/g, '').slice(0,10)">
    <small id="phone-error" style="color: red; display: none;">Please enter exactly 10 digits.</small>
</div>
</div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label>Preferred Location</label>
                    <input type="text" name="preferred_location" value="" class="form-control" placeholder="Preferred Location">
                </div>
            </div>
          <div class="col-sm-3">
    <div class="form-group">
        <label>Property Type*</label>
       
        <select id="propertyType" name="propertyType" required class="form-control">
            <option value="">Select</option>
            <option value="Residential">Residential</option>
            <option value="Commercial">Commercial</option>
        </select>
    </div>
</div>

<div class="col-sm-3" id="residentialDiv" style="display:none;">
    <div class="form-group">
        <label>Residential</label>
        <select id="residentialOptions" class="form-control">
            <option value="">Select</option>
            <option value="Flat/Apartment">Flat/Apartment</option>
            <option value="Independent House/Villa">Independent House/Villa</option>
            <option value="Independent/Builder Floor">Independent/Builder Floor</option>
            <option value="Plot">Plot</option>
            <option value="1RK/Studio Apartment">1RK/Studio Apartment</option>
            <option value="Serviced Apartment">Serviced Apartment</option>
            <option value="Farmhouse">Farmhouse</option>
            <option value="Other">Other</option>
        </select>
    </div>
</div>

<div class="col-sm-3" id="commercialDiv" style="display:none;">
    <div class="form-group">
        <label>Commercial</label>
        <select id="commercialOptions" class="form-control">
            <option value="">Select</option>
            <option value="Office">Office</option>
            <option value="Retail">Retail</option>
            <option value="Plot/Land">Plot/Land</option>
            <option value="Storage">Storage</option>
            <option value="Industry">Industry</option>
            <option value="Hospitality">Hospitality</option>
            <option value="Other">Other</option>
        </select>
    </div>
</div>
<input type="hidden" name="propertyType_sub" id="propertyType_sub">
        </div>

        <div class="row">
           
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Budget</label>
                    <input type="number" name="budget" value="" class="form-control">
                </div>
            </div>

             <div class="col-sm-3">
                <div class="form-group">
                    <label>Project Builder</label>
                     <input type="Project_Builder" name="Project_Builder" value="" class="form-control">
                    </select>
                </div>
            </div>
             <div class="col-sm-3">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="New">New</option>
                            <option value="Contacted">Contacted</option>
                            <option value="Qualified">Qualified</option>
                            <option value="Site Visit Scheduled">Site Visit Scheduled</option>
                            <option value="Site Visited">Site Visited</option>
                            <option value="Negotiation">Negotiation</option>
                            <option value="Booking Confirmed">Booking Confirmed</option>
                            <option value="Document Collection">Document Collection</option>
                            <option value="Loan Under Process">Loan Under Process</option>
                            <option value="Finalized / Closed">Finalized / Closed</option>
                            <option value="Follow-up Later">Follow-up Later</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Duplicate">Duplicate</option>
                            <option value="Invalid Lead">Invalid Lead</option>
                        </select>
                    </div>
                </div>    <div class="col-sm-3">
                    <div class="form-group">
                        <label for="source">Source</label>
                        <select id="source" name="source" class="form-control">
                             <option value="">Select</option>
                            <option value="Website">Website</option>
                            <option value="Social media">Social media</option>
                            <option value="Third Party">Third Party</option>
                            <option value="Manually">Manually</option>
                           
                        </select>
                    </div></div> </div>
                
                 <div class="row">
            
                     <div class="col-sm-3">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="form-control">
                             <option value="">Select</option>
                            <option value="Hot">Hot***</option>
                            <option value="Cold">Cold</option>
                            <option value="Normal">Normal</option>
                        </select>
                    </div></div>
                    
                     <div class="col-sm-3">
                     <div class="form-group">
                        <label for="timeline">Time line</label>
                       <select id="timeline" name="timeline" class="form-control">
                            <option value="">Select</option>
                            <option value="Immediate">Immediate</option>
                            <option value="Within Week">Within Week</option>
                            <option value="Within Month">Within Month</option>
                            <option value="1-3 Months">1-3 Months</option>
                            <option value="3-6 Months">3-6 Months</option>
                            <option value="6+ Months">6+ Months</option>
                        </select>
                    </div>
                </div>     <div class="col-sm-3">
                    <div class="form-group">
                        <label for="status">Leads Type</label>
                        <select id="leads_type" name="leads_type" class="form-control">
                             <option value="">Select</option>
                            <option value="Seller">Seller</option>
                            <option value="Buyer">Buyer</option>
                             <option value="Both">Both</option>
                            <option value="Investor">Investor</option>
                            
                            
                        </select>
                    </div>
                </div></div>
     
      
        <div class="row">
           
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Requirement</label>
                    <textarea name="requirement" class="form-control" placeholder="Requirement" value= "requirement"></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                </div>
            </div>
            
            <div class="col-12">
                <div class="form-group">
                   <label>Tags</label>
                    <div id="tag-container" class="d-flex flex-wrap">
                     <input type="text" id="tag-input" class="form-control me-2" placeholder="Add tag" style="width:auto; margin-right:5px;" />
                     <button type="button" id="add-tag-btn" class="btn btn-success">Add</button>
                     </div>
                     <input type="hidden" name="leads_tags" id="leads_tags">
              </div>
            </div>
            
                            
        </div>

        <div class="personal-main-div">
        <!-- Toggle Button -->
        <button id="toggleButton" type="button" class="btn btn-secondary mt-3">Show Personal Information</button>

        <!-- Additional Fields Section -->
        <fieldset class="personal-div mt-4">
            <legend>Personal Information</legend>
            <div  id="more-information" class="hide-div">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>User Type</label>
                        <select name="buyer" class="form-control">
                            
                            <option value="individual_customer">Individual Customer</option>
                            <option value="investor">Investor</option>
                            <option value="dealer">Dealer</option>
                        </select>
                    </div>
                </div>
              
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="" class="form-control" placeholder="Address">
                    </div>
                </div>
                 <div class="col-4">
                        <label>Profession</label>
                  <input type="text" name="Profession" value="" class="form-control" placeholder="Profession">
                  
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
             <div class="row">
            <div class="col-sm-12">
                
    <div class="form-group">
        <label>Payment Method</label>
        <div class="d-flex">
            <!-- Cash Payment Checkbox -->
         <div class="form-check mr-12">
    <input type="checkbox" id="cash_payment" name="Payment_Method[]" value="cash" class="form-check-input">
    <label for="cash_payment" class="form-check-label">Cash Payment</label>
</div>

<div class="form-check">
    <input type="checkbox" id="online_payment" name="Payment_Method[]" value="online" class="form-check-input">
    <label for="online_payment" class="form-check-label">Online Payment</label>
</div>

<div class="form-check">
    <input type="checkbox" id="loan_payment" name="Payment_Method[]" value="loan" class="form-check-input">
    <label for="loan_payment" class="form-check-label">Loan Payment</label>
</div>

        </div>
    </div>
</div></div></div>
           
        </fieldset>
        
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <input type="submit" value="Submit" name="save" class="property-submit-btn btn btn-primary mt-4">
            </div>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

     
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toggleButton = document.getElementById('toggleButton');
        const moreInfoSection = document.getElementById('more-information');
        
        toggleButton.addEventListener('click', function() {
            if (moreInfoSection.classList.contains('hide-div')) {
                moreInfoSection.classList.remove('hide-div');
                toggleButton.textContent = 'Hide Personal Information';
            } else {
                moreInfoSection.classList.add('hide-div');
                toggleButton.textContent = 'Show Personal Information';
            }
        });
    });
</script>
<script>
    // Optional: prevent non-digit inputs
    const phoneInput = document.getElementById('phone');
    const phoneError = document.getElementById('phone-error');

    phoneInput.closest('form').addEventListener('submit', function(e) {
        const phoneValue = phoneInput.value.trim();

        if (phoneValue.length !== 10) {
            e.preventDefault(); // Stop form submission
            phoneError.style.display = 'block'; // Show error
            phoneInput.focus();
        } else {
            phoneError.style.display = 'none'; // Hide error
        }
    });
</script>
<script>
    const propertyType = document.getElementById("propertyType");
    const residentialDiv = document.getElementById("residentialDiv");
    const commercialDiv = document.getElementById("commercialDiv");
    const residentialOptions = document.getElementById("residentialOptions");
    const commercialOptions = document.getElementById("commercialOptions");
    const finalInput = document.getElementById("propertyType_sub");

    propertyType.addEventListener("change", function() {
        const selectedType = this.value;
        residentialDiv.style.display = "none";
        commercialDiv.style.display = "none";
        finalInput.value = "";

        if (selectedType === "Residential") {
            residentialDiv.style.display = "block";
        } else if (selectedType === "Commercial") {
            commercialDiv.style.display = "block";
        }
    });

    residentialOptions.addEventListener("change", function() {
        finalInput.value = this.value;
    });

    commercialOptions.addEventListener("change", function() {
        finalInput.value = this.value;
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
    let tags = [];

    // Function to render tag chips
    function renderTags() {
        $("#tag-container .tag").remove();
        tags.forEach((tag, index) => {
            $("#tag-input").before(`
                <span class="tag badge bg-primary me-1 mb-1" style="color:white; margin-right:3px;display: flex;justify-content: center;align-items: center;background: #007485 !important;font-size: 14px;font-weight: normal;text-transform: capitalize;gap: 5px;">
                    ${tag} 
                    <span class="remove-tag" data-index="${index}" style="cursor:pointer;background: red;border-radius: 100px;display: flex;justify-content: center;align-items: flex-start; padding: 2px;font-size: 15px;height: 20px; width: 20px;">&times;</span>
                </span>
            `);
        });
        $("#leads_tags").val(tags.join("~-~")); // separator
    }

    // Add tag function
    function addTag(val) {
        if (val !== "" && !tags.includes(val)) {
            tags.push(val);
            renderTags();
        }
    }

    // Add tag manually
    $("#add-tag-btn").on("click", function () {
        const tagVal = $("#tag-input").val().trim();
        addTag(tagVal);
        $("#tag-input").val("");
    });

    // Enter key support
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

    // --- AUTO TAGGING FROM OTHER FIELDS ---
    $("#propertyType").on("change", function() { addTag($(this).val()); });
    $("#residentialOptions").on("change", function() { addTag($(this).val()); });
    $("#commercialOptions").on("change", function() { addTag($(this).val()); });
    $("#priority").on("change", function() { addTag($(this).val()); });
    $("#leads_type").on("change", function() { addTag($(this).val()); });

    // City field (jab user kuch likh ke bahar nikle)
    $("#cityInput").on("blur", function() { 
        let val = $(this).val().trim();
        if(val !== "") {
            addTag(val);
            // city field clear nahi karenge
        }
    });
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

<style>
.form-check-label {
  padding: 0px 18px 0px 0px;
}
    .hide-div { display: none; }
</style>
