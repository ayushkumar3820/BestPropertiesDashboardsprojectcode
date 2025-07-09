<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Form - Fixed CSS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main {
            padding: 20px;
        }

        .heading {
            color: #333;
            margin-bottom: 20px;
        }

        .back-btn {
            float: right;
            margin: 14px 2px;
        }

        .form {
            margin-left: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group input {
            flex: 1;
            margin-right: 10px;
        }

        .input-group select {
            max-width: 120px;
        }

        .property-submit-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .property-submit-btn:hover {
            background-color: #0056b3;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-remove:hover {
            background-color: #c82333;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        label input[type="radio"],
        label input[type="checkbox"] {
            margin-right: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .text-center {
            text-align: center;
        }

        .col-md-3, .col-md-4, .col-md-6, .col-sm-6, .col-sm-12 {
            padding: 0 10px;
        }

        .row {
            margin: 0 -10px;
        }

        #extra-fields {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
            background-color: #f9f9f9;
        }

        #dynamic_field {
            margin-top: 20px;
        }

        #label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form {
                margin-left: 10px;
            }

            .back-btn {
                float: none;
                margin: 10px 0;
            }

            .input-group {
                flex-direction: column;
            }

            .input-group input {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .input-group select {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="col main mt-3 pt-5">
        <a class="btn back-btn btn-info btn-sm" href="#" style="float:right;margin:14px 2px">Back</a>
        <h1 class="d-sm-block heading">Property Form Test</h1>
        <div class="clearfix"></div>

        <form class="form" enctype="multipart/form-data" id="propertyForm" method="post" style="margin-left:24px">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Property Name</label>
                        <input name="name" class="form-control"  placeholder="Property Name"
                        value="<?php echo $properties[0]->name; ?>"
                        required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Address*</label>
                        <input name="address" class="form-control"
                        value="<?php echo $properties[0]->address; ?>"
                        placeholder="Property Address">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Property Description</label>
                        <textarea class="form-control" name="description"
                        value="<?php echo $properties[0]->description; ?>"
                        placeholder="Property Description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-left:6px">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Person Name</label>
                        <input name="person" class="form-control"
                        value="<?php echo $properties[0]->person; ?>"
                        placeholder="Person Name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Person Phone</label>
                        <input name="phone" class="form-control"
                        value="<?php echo $properties[0]->phone; ?>"
                        placeholder="Person Phone" type="number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Person Address</label>
                        <input name="person_address" class="form-control" placeholder="Person Address"
                        value="<?php echo $properties[0]->person_address; ?>"
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Property For*</label>
                         <select name="property_for" class="form-control" required>
                                <option value="">Select Type</option>
                                <!--<option value="Buy" <?php echo (isset($properties[0]->property_for) && $properties[0]->property_for == 'Buy') ? 'selected' : ''; ?>>Buy</option>-->
                                <option value="Rent" <?php echo (isset($properties[0]->property_for) && $properties[0]->property_for == 'Rent') ? 'selected' : ''; ?>>Rent</option>
                                <option value="Sale" <?php echo (isset($properties[0]->property_for) && $properties[0]->property_for == 'Sale') ? 'selected' : ''; ?>>Sale</option>
                            </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Category*</label>
                        <select id="categorySelector" name="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="Residential" <?php echo (isset($properties[0]->category) && $properties[0]->category == 'Residential') ? 'selected' : ''; ?>>Residential</option>
                                <option value="Commercial" <?php echo (isset($properties[0]->category) && $properties[0]->category == 'Commercial') ? 'selected' : ''; ?>>Commercial</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Residential Fields -->
            <div style="display:none;margin-left:16px;width:100%" id="residential-fields">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Property Type (Residential)</label>
                        <select name="property_type" id="resPropertyType" class="form-control">
                                    <option value="">Select Property Type</option>
                                    <option value="Apartment / Flat" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Apartment / Flat') ? 'selected' : ''; ?>>Apartment / Flat</option>
                                    <option value="Independent House / Kothi" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi') ? 'selected' : ''; ?>>Independent House / Kothi</option>
                                    <option value="Residential Plot" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Residential Plot') ? 'selected' : ''; ?>>Residential Plot</option>
                                    <option value="Farm House" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House') ? 'selected' : ''; ?>>Farm House</option>
                                    <option value="Builder Floor" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor') ? 'selected' : ''; ?>>Builder Floor</option>
                                    <option value="Studio Apartment" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Studio Apartment') ? 'selected' : ''; ?>>Studio Apartment</option>
                                    <option value="Other" <?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <!-- BHK Options -->
                <div class="row" style="display:none" id="bhk-options">
                    <div class="form-group col-md-3">
                        <label>Select BHK Type</label>
                        <select id="bhk" name="bhk" class="form-control">
                                    <option value="">Select Serviced Apartment Type</option>
                                    <option value="1RK/Studio" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '1RK/Studio') ? 'selected' : ''; ?>>1RK/Studio</option>
                                    <option value="1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '1BHK') ? 'selected' : ''; ?>>1BHK</option>
                                    <option value="2BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '2BHK') ? 'selected' : ''; ?>>2BHK</option>
                                    <option value="3BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '3BHK') ? 'selected' : ''; ?>>3BHK</option>
                                    <option value="Penthouse" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == 'Penthouse') ? 'selected' : ''; ?>>Penthouse</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Number of Floors</label>
                        <input name="total_floors" class="form-control"
                        value="<?php echo $properties_meta[0]->total_floors; ?>"
                        >
                    </div>
                    <div class="form-group col-md-3">
                        <label>Floor No</label>
                        <input name="floor_no" class="form-control">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Facing</label>
                        <input name="facing" class="form-control">
                    </div>
                </div>
            <!--BHK option end-->

            <!--kothi option start-->
            <div id="kothi-options" class="row" style="display:none;">
                <div class="col-md-3 form-group">
                    <label>Number of Floors</label>
                    <input type="text" name="total_floors" class="form-control">
                </div>


                <div class="col-md-3 form-group">
                    <label>Facing</label>
                    <input type="text" name="facing" class="form-control">
                </div>

                <!-- Plot Area -->
                <div class="col-md-3 form-group">
                    <label>Plot Area</label>
                    <div class="input-group">
                        <input type="text" name="kothi_plot_area" class="form-control" placeholder="Plot Area">
                        <select id="area_unit" name="plot_area_unit" class="form-select">
                            <option value="sq.yard">sq.yard</option>
                            <option value="marla">marla</option>
                            <option value="kanal">kanal</option>
                        </select>
                    </div>
                </div>

                <!-- Covered Area -->
                <div class="col-md-3 form-group">
                    <label>Covered Area</label>
                    <div class="input-group">
                        <input type="text" name="kothi_covered_area" class="form-control" placeholder="Covered Area">
                        <select id="covered_area_unit" name="covered_area_unit" class="form-select">
                            <option value="sq.yard">sq.yard</option>
                            <option value="marla">marla</option>
                            <option value="kanal">kanal</option>
                        </select>
                    </div>
                </div>

                 <!-- Kothi Type -->
               <div class="col-md-4 form-group">
                    <label>Independent House / Kothi Type</label>
                    <select id="kothi_story_type" name="kothi_story_type" class="form-control">
                        <option value="">Select</option>
                        <option value="Single Story">Single Story</option>
                        <option value="Double Story">Double Story</option>
                        <option value="Duplex Story">Duplex Story</option>
                        <option value="Triplex Story">Triplex Story</option>
                        <option value="Villa Style">Villa Style</option>
                    </select>
               </div>

                <!-- Construction Status -->
                <div class="col-md-3 form-group">
                    <label>Construction Status</label>
                    <select name="construction_status" class="form-control" >
                        <option value="">Select Status</option>
                        <option value="Ready To Move">Ready To Move</option>
                        <option value="For Sale">For Sale</option>
                        <option value="Under Construction">Under Construction</option>
                    </select>
                </div>



                <!-- Property Age -->
                <div class="col-md-3 form-group">
                    <label>Property Age</label>
                    <select name="property_age" class="form-control">
                        <option value="">Select Age</option>
                        <option value="0-1 year">0-1 year</option>
                        <option value="1-5 years">1-5 years</option>
                        <option value="5-10 years">5-10 years</option>
                        <option value="10+ years">10+ years</option>
                    </select>
                </div>

                <!-- Gated Community -->
                <div class="col-md-3 form-group">
                    <label>Gated Community?</label><br>
                    <label><input type="radio" name="gated_community" value="yes"> Yes</label>
                    <label><input type="radio" name="gated_community" value="no"> No</label>
                </div>
            </div>
            <!--kothi option end-->


            <!--plot option end-->
            <!--plot option end-->







            </div>

            <!-- Commercial Fields -->
            <div style="display:none;margin-left:16px;width:100%" id="commercial-fields">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Property Type (Commercial)</label>
                        <select class="form-control" name="property_type" id="comPropertyType">
                            <option value="">Select Property Type</option>
                            <option value="Office">Office</option>
                            <option value="Retail">Retail</option>
                            <option value="Plot">Plot</option>
                            <option value="Storage">Storage/Warehouse</option>
                            <option value="Industry/Factory">Industry/Factory</option>
                            <option value="Hospital">Hospital</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Price Section -->
            <div class="row" style="width:100%;margin-left:16px">
                <div class="form-group col-md-6">
                    <label>Demanded Price</label>
                    <div class="input-group">
                        <input name="budget_in_words" class="form-control" placeholder="Enter price">
                        <select class="form-control" name="price_unit" style="max-width:120px">
                            <option value="lakhs">Lakhs</option>
                            <option value="crore">Crore</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Extra Fields Toggle -->
            <div class="form-group">
                <label>
                    <input type="checkbox" id="toggleExtraFields"> Show Extra Fields
                </label>
            </div>

            <!-- Extra Fields -->
            <div style="display:none" id="extra-fields">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Amenities*</label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label><input name="amenities[]" value="Car parking" type="checkbox"> Car parking</label><br>
                                <label><input name="amenities[]" value="Security services" type="checkbox"> Security services</label><br>
                                <label><input name="amenities[]" value="Water supply" type="checkbox"> Water supply</label><br>
                                <label><input name="amenities[]" value="Elevators" type="checkbox"> Elevators</label><br>
                                <label><input name="amenities[]" value="Power backup" type="checkbox"> Power backup</label><br>
                                <label><input name="amenities[]" value="Gym" type="checkbox"> Gym</label><br>
                                <label><input name="amenities[]" value="Play area" type="checkbox"> Play area</label><br>
                            </div>
                            <div class="col-md-6">
                                <label><input name="amenities[]" value="Swimming pool" type="checkbox"> Swimming pool</label><br>
                                <label><input name="amenities[]" value="Restaurants" type="checkbox"> Restaurants</label><br>
                                <label><input name="amenities[]" value="Party hall" type="checkbox"> Party hall</label><br>
                                <label><input name="amenities[]" value="Temple and religious activity place" type="checkbox"> Temple and religious activity place</label><br>
                                <label><input name="amenities[]" value="Cinema hall" type="checkbox"> Cinema hall</label><br>
                                <label><input name="amenities[]" value="Walking/Jogging track" type="checkbox"> Walking/Jogging track</label><br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>City*</label>
                            <input name="city" class="form-control" placeholder="Mohali">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>State*</label>
                            <input name="state" class="form-control" placeholder="Punjab">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input name="zip_code" class="form-control" placeholder="160055">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Picture</label>
                            <input name="image_one" class="form-control" type="file">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Picture</label>
                            <input name="image_two" class="form-control" type="file">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Picture</label>
                            <input name="image_three" class="form-control" type="file">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Picture</label>
                            <input name="image_four" class="form-control" type="file">
                        </div>
                    </div>
                </div>
            </div>

            <div id="dynamic_field">
                <label id="label" style="display:none">Additional Details</label>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <input name="save" class="btn btn-primary property-submit-btn" value="Submit" type="submit">
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    jQuery(document).ready(function () {
        var i = 1;

        // ========== Toggle Residential/Commercial Fields ==========
        function toggleCategoryFields() {
            const category = jQuery('#categorySelector').val();
            if (category === 'Residential') {
                jQuery('#residential-fields').slideDown();
                jQuery('#commercial-fields').slideUp();
            } else if (category === 'Commercial') {
                jQuery('#commercial-fields').slideDown();
                jQuery('#residential-fields').slideUp();
            } else {
                jQuery('#residential-fields, #commercial-fields').slideUp();
            }
        }

        // ========== Show Residential Sub-Type Fields ==========
        function showResidentialSubFields() {
            const type = jQuery('#resPropertyType').val();
            jQuery('#studio-options,#other-options,#bhk-options, #kothi-options, #plot-options, #farmhouse-options, #floor-options').hide();

            if (type === 'Apartment / Flat') {
                jQuery('#bhk-options').show();
            } else if (type === 'Independent House / Kothi') {
                jQuery('#kothi-options').show();
            } else if (type === 'Residential Plot') {
                jQuery('#plot-options').show();
            } else if (type === 'Farm House') {
                jQuery('#farmhouse-options').show();
            } else if (type === 'Builder Floor') {
                jQuery('#floor-options').show();
            }else if (type === 'Studio Apartment') {
                jQuery('#studio-options').show();
            }else if (type === 'Other') {
                jQuery('#other-options').show();
            }
        }

        // ========== Show Commercial Sub-Type Fields ==========
       function toggleCommercialSubFields(type) {
                // hide all first
                $('#com-factory-fields, #com-hospital-fields, #com-office-fields, #com-retail-fields, #com-plot-fields, #com-warehouse-fields, #com-storage-fields').hide();

                switch (type) {
                    case "Office":
                        $("#com-office-fields").show();
                        break;
                    case "Retail":
                        $("#com-retail-fields").show();
                        break;
                    case "Plot":
                        $("#com-plot-fields").show();
                        break;
                    case "Warehouse":
                    case "Factory":
                        $("#com-warehouse-fields").show();
                        break;
                    case "Storage":
                        $("#com-storage-fields").show();
                        break;
                    case "Industry/Factory":
                        $("#com-factory-fields").show();
                        break;
                    case "Hospital":
                        $("#com-hospital-fields").show();
                        break;
                }

                console.log('Selected type:', type);
            }

        // ========== Under Construction Toggle for All Sections ==========


        // ========== Toggle Extra Fields ==========
        jQuery('#toggleExtraFields').change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('#extra-fields').slideDown();
            } else {
                jQuery('#extra-fields').slideUp();
            }
        });

        // ========== Add Custom Fields Dynamically ==========
        jQuery('#add').click(function () {
            i++;
            jQuery('#label').show();
            jQuery('#dynamic_field').append(
                '<div id="custom' + i + '" class="row">' +
                    '<div class="col-md-3"><div class="form-group">' +
                        '<input type="text" class="form-control" name="additional[]" placeholder="label">' +
                    '</div></div>' +
                    '<div class="col-sm-6"><div class="form-group">' +
                        '<input type="text" class="form-control" name="custom_value[]" placeholder="value">' +
                    '</div></div>' +
                    '<div class="col-sm-2">' +
                        '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button>' +
                    '</div>' +
                '</div>'
            );
        });

        jQuery(document).on('click', '.btn_remove', function () {
            const button_id = jQuery(this).attr("id");
            jQuery('#custom' + button_id).remove();
        });


        // ========== Triggered on Load ==========
        toggleCategoryFields();
        showResidentialSubFields();

        // ========== Event Bindings ==========
        jQuery('#categorySelector').change(toggleCategoryFields);
        jQuery('#resPropertyType').change(showResidentialSubFields);
        jQuery('#comPropertyType').change(function () {
            toggleCommercialSubFields(jQuery(this).val());
        });



    });
</script>

e) {
                    console.error("Response parse error:", e);
                    console.error("Raw response:", response);

                    let errorMessage = "Unexpected server response.\n";
                    errorMessage += "Error: " + e.message + "\n";
                    errorMessage += "Raw Response: " + response;

                    alert(errorMessage);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                console.<script>
$(document).ready(function () {
    $('#propertyForm').on('submit', function (e) {
        e.preventDefault();

        var formArray = $(this).serializeArray();
        var rawData = {};
        var unitMap = {};
        var amenities = [];

        // Define which fields have corresponding unit fields
        const unitFields = {
            "floor_carpet_area": "floor_carpet_area_unit",
            "com_built_area": "com_built_area_unit",
            "com_land_area": "com_land_area_unit",
            "com_office_carpet_area": "com_office_carpet_area_unit",
            "com_office_area": "com_office_area_unit",
            "com_plot_area": "com_plot_area_unit",
            "plot_area_value": "plot_area_unit",
            "kothi_covered_area": "covered_area_unit",
            "kothi_plot_area": "plot_area_unit",
            "farm_plot_area": "farm_plot_area_unit",
            "farm_area": "farm_area_unit",
            "budget_in_words": "price_unit",
            "carpet_area": "carpet_area_unit",  // ✅ Corrected
            "carpet":"carpet_area_unit"
        };

        // First pass: collect values and units
        formArray.forEach(function (item) {
            const name = item.name;
            const value = item.value.trim();

            if (!value) return;

            if (name === 'amenities[]') {
                amenities.push(value);
            } else if (Object.values(unitFields).includes(name)) {
                unitMap[name] = value;
            } else {
                rawData[name] = value;
            }
        });

        // Second pass: merge value with unit
        var finalData = {};
        for (const key in rawData) {
            if (unitFields[key] && unitMap[unitFields[key]]) {
                finalData[key] = rawData[key] + ' ' + unitMap[unitFields[key]];
            } else {
                finalData[key] = rawData[key];
            }
        }

        // Amenities (implode with ~-~)
        if (amenities.length > 0) {
            finalData["amenities"] = amenities.join("~-~");
        }




        // Add budget field if budget_in_words is present
        if (finalData['budget_in_words']) {
            const budgetParts = finalData['budget_in_words'].split(' ');
            if (budgetParts.length === 2) {
                const amount = parseFloat(budgetParts[0]);
                const unit = budgetParts[1].toLowerCase();

                let budgetValue = 0;
                if (!isNaN(amount)) {
                    if (unit === 'lakhs' || unit === 'lakh') {
                        budgetValue = amount * 100000;
                    } else if (unit === 'crore' || unit === 'crores') {
                        budgetValue = amount * 10000000;
                    }

                    // Format in Indian number system
                    finalData['budget'] = budgetValue.toLocaleString('en-IN');
                }
            }
        }


        const renameKeys = {
            "floor_carpet_area": "carpet",
            "carpet_area": "carpet",
            "com_built_area": "built",
            "com_land_area": "land",
            "com_plot_area": "carpet",
            "plot_area_value": "carpet",
            "com_width_length": "width_length",
            "expected_price": "budget",
            "budget_in_words": "budget_in_words",
            "com_office_area": "built",
            "com_office_carpet_area": "carpet",
            "com_property_type": "property_type",
            "kothi_plot_area": "land",
            "kothi_covered_area": "built"
            // Add more if needed
        };

        for (const oldKey in renameKeys) {
            if (finalData.hasOwnProperty(oldKey)) {
                finalData[renameKeys[oldKey]] = finalData[oldKey];
                delete finalData[oldKey];
            }
        }

        $.ajax({
            url: '<?php echo base_url("/api/Properties/addProperty/"); ?>',
            type: 'POST',
            data: JSON.stringify(finalData),
            contentType: 'application/json',
             headers: {
                'Authorization': 'Bearer 9j1h8hgjO0KUin2bhj58d97jiOh67f5h48hj78hg8vg5j63fo0h930'  // <-- Set your token here
            },
            processData: false,
            success: function (response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.status === "success") {
                        alert("Property submitted successfully!");
                    } else {
                        alert("Status : " + (res.message || "Unknown error"));
                    }
                } catch (error("Status Code:", xhr.status);
                console.error("Response Text:", xhr.responseText);

                let errorMessage = "AJAX Error: " + error;

                try {
                    const json = JSON.parse(xhr.responseText);
                    if (json.message) {
                        errorMessage += "\nServer Message: " + json.message;
                    }
                } catch (e) {
                    errorMessage += "\nRaw Response: " + xhr.responseText;
                }

                alert(errorMessage);
            }

        });
    });
});


</script>
</body>
</html>