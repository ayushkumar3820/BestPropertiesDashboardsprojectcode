
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

        input.form-check-input[type=checkbox]
         {
            border-color: black;
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

    <div class="container">
    <div class="row">
            <div class="col main mt-3 pt-5">
                <a class="btn back-btn btn-info btn-sm" href="/admin/properties/" style="float:right;margin:14px 2px">Back</a>
                <h1 class="d-sm-block heading">Property Form</h1>
                <div class="clearfix"></div>

                <form class="form" enctype="multipart/form-data" id="propertyForm"  style="margin-left:24px">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Property Name</label>
                                <input type="hidden" name="id" value="<?php echo isset($properties[0]->id) ? htmlspecialchars($properties[0]->id) : ''; ?>">
                                <input name="name" class="form-control" placeholder="Property Name" value="<?php echo isset($properties[0]->name) ? htmlspecialchars($properties[0]->name) : ''; ?>" required>
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
                                <textarea class="form-control" name="description" placeholder="Property Description"><?php echo isset($properties[0]->description) ? htmlspecialchars($properties[0]->description) : ''; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                                 <?php
                                    if ($properties[0]->property_for == "Rent/Lease"){
                                                $property_for = "rent";
                                    }else{
                                        $property_for = isset($properties[0]->property_for) ? strtolower($properties[0]->property_for) : '';

                                    }


                                  ?>

                                <select name="property_for" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Rent" <?= ($property_for == 'rent') ? 'selected' : ''; ?>>Rent</option>
                                    <option value="Sale" <?= ($property_for == 'sale' || $property_for == 'sell') ? 'selected' : ''; ?>>Sale</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Category*</label>
                                <?php
                                    $category = isset($properties[0]->category) ? strtolower($properties[0]->category) : '';
                                ?>
                                
                                <div style="display:flex; gap:20px;">
                                    <label>
                                        <input type="radio" name="category_radio" value="Residential"
                                            <?= ($category == 'residential') ? 'checked' : ''; ?>
                                            onclick="jQuery('#categorySelector').val(this.value).trigger('change');">
                                        Residential
                                    </label>
                                    <label>
                                        <input type="radio" name="category_radio" value="Commercial"
                                            <?= ($category == 'commercial') ? 'checked' : ''; ?>
                                            onclick="jQuery('#categorySelector').val(this.value).trigger('change');">
                                        Commercial
                                    </label>
                                </div>
                            
                                <!-- hidden input to work with existing JS -->
                                <input type="hidden" id="categorySelector" name="category"
                                       value="<?= ucfirst($category); ?>">
                            </div>

                        </div>
                    </div>

                    <!-- Residential Fields -->
                    <div style="display:none;width:100%" id="residential-fields">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Property Type (Residential)</label>
                                        <select name="property_type" id="resPropertyType" class="form-control">
                                            <option value="">Select Property Type</option>
                                            <option value="Apartment / Flat" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Apartment / Flat') ? 'selected' : ''; ?>>Apartment / Flat</option>
                                            <option value="Independent House / Kothi" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Independent House / Kothi') ? 'selected' : ''; ?>>Independent House / Kothi</option>
                                            <option value="Residential Plot" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Residential Plot') ? 'selected' : ''; ?>>Residential Plot</option>
                                            <option value="Farm House" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Farm House') ? 'selected' : ''; ?>>Farm House</option>
                                            <option value="Builder Floor" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Builder Floor') ? 'selected' : ''; ?>>Builder Floor</option>
                                            <option value="Studio Apartment" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Studio Apartment') ? 'selected' : ''; ?>>Studio Apartment</option>
                                            <option value="Other" <?= (isset($properties[0]->category) && $properties[0]->category == 'Residential' && $properties[0]->property_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- BHK Options -->
                                <div class="row" style="display:none" id="bhk-options">
                                    <div class="form-group col-md-3">
                                        <label>Select BHK Type</label>
                                         <select id="bhk" name="bhk" class="form-control">
                                            <option value="">Select Serviced Apartment Type</option>
                                            <option value="1RK/Studio" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '1RK/Studio') ? 'selected' : ''; ?>>1RK/Studio</option>
                                            <option value="1BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '1BHK') ? 'selected' : ''; ?>>1BHK</option>
                                            <option value="2BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '2BHK') ? 'selected' : ''; ?>>2BHK</option>
                                            <option value="2+1BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '2+1BHK') ? 'selected' : ''; ?>>2+1BHK</option>
                                            <option value="3BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '3BHK') ? 'selected' : ''; ?>>3BHK</option>
                                            <option value="3+1BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '3+1BHK') ? 'selected' : ''; ?>>3+1BHK</option>
                                            <option value="4BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '4BHK') ? 'selected' : ''; ?>>4BHK</option>
                                            <option value="4+1BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '4+1BHK') ? 'selected' : ''; ?>>4+1BHK</option>
                                            <option value="5BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '5BHK') ? 'selected' : ''; ?>>5BHK</option>
                                            <option value="5+1BHK" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == '5+1BHK') ? 'selected' : ''; ?>>5+1BHK</option>
                                            <option value="Other" <?= (isset($properties[0]->bhk) && $properties[0]->bhk == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                          <label for="construction_status">Construction Status</label>
                                          <select id="bhk_construction_status" name="construction_status" class="form-control">
                                            <option value="">Select Construction Status</option>
                                            <option value="Ready To Move" <?= (isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : ''; ?>>Ready To Move</option>
                                            <option value="Re-Sale" <?= (isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Re-Sale') ? 'selected' : ''; ?>>Re-Sale</option>
                                            <option value="Under Construction" <?= (isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : ''; ?>>Under Construction</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3" id="bhk_property_age" style="display: none;">
                                          <label for="property_age">Property Age</label>
                                          <select id="bhk1_property_age" name="property_age" class="form-control">
                                            <option value="">Select Property Age</option>
                                            <option value="0-1 year" <?= (isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '0-1 year') ? 'selected' : ''; ?>>0-1 year</option>
                                            <option value="1-5 years" <?= (isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '1-5 years') ? 'selected' : ''; ?>>1-5 years</option>
                                            <option value="5-10 years" <?= (isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '5-10 years') ? 'selected' : ''; ?>>5-10 years</option>
                                            <option value="10+ years" <?= (isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '10+ years') ? 'selected' : ''; ?>>10+ years</option>
                                        </select>
                                    </div>

                                    <?php
                                        // Carpet Area
                                        $carpet_parts = explode(' ', $properties[0]->carpet ?? '');
                                        $carpet_value = $carpet_parts[0] ?? '';
                                        $carpet_unit = $carpet_parts[1] ?? '';

                                        // Built Area
                                        $built_parts = explode(' ', $properties[0]->built ?? '');
                                        $built_value = $built_parts[0] ?? '';
                                        $built_unit = $built_parts[1] ?? '';

                                        // Land Area
                                        $land_parts = explode(' ', $properties[0]->land ?? '');
                                        $land_value = $land_parts[0] ?? '';
                                        $land_unit = $land_parts[1] ?? '';
                                    ?>

                                    <!-- Carpet Area -->
                                    <div class="col-md-3 form-group">
                                        <label>Carpet Area</label>
                                        <div class="input-group">
                                            <input name="bhk_carpet_area" class="form-control" placeholder="Carpet Area" value="<?= htmlspecialchars($carpet_value) ?>">
                                            <select name="bhk_carpet_area_unit" class="form-control">
                                                <option value="">Select</option>
                                                <option value="sq.ft" <?= ($carpet_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                                <option value="sq.yard" <?= ($carpet_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                                <option value="marla" <?= ($carpet_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                                <option value="kanal" <?= ($carpet_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Built Area -->
                                    <div class="col-md-3 form-group">
                                        <label>Built Area</label>
                                        <div class="input-group">
                                            <input name="bhk_built_area" class="form-control" placeholder="Built Area" value="<?= htmlspecialchars($built_value) ?>">
                                            <select name="bhk_built_area_unit" class="form-control">
                                                <option value="">Select</option>
                                                <option value="sq.ft" <?= ($built_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                                <option value="sq.yard" <?= ($built_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                                <option value="marla" <?= ($built_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                                <option value="kanal" <?= ($built_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Land Area -->
                                    <div class="col-md-3 form-group">
                                        <label>Land Area</label>
                                        <div class="input-group">
                                            <input name="bhk_land_area" class="form-control" placeholder="Land Area" value="<?= htmlspecialchars($land_value) ?>">
                                            <select name="bhk_land_area_unit" class="form-control">
                                                <option value="">Select</option>
                                                <option value="sq.ft" <?= ($land_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                                <option value="sq.yard" <?= ($land_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                                <option value="marla" <?= ($land_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                                <option value="kanal" <?= ($land_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Number of Floors</label>
                                        <input name="total_floors" class="form-control"
                                        <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Apartment / Flat'): ?>
                                            value="<?php echo $properties_meta[0]->total_floors; ?>"
                                            <?php endif; ?>
                                        >
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Floor No</label>
                                        <input name="floor_no" class="form-control"
                                        <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Apartment / Flat'): ?>
                                            value="<?php echo $properties_meta[0]->floor_no; ?>"
                                        <?php endif; ?>
                                        >
                                    </div>

                                    <div class="form-group col-md-3">
                                      <label for="bedrooms">Bedroom Number</label>
                                      <select id="bedrooms" name="bedrooms" class="form-control">
                                        <option value="">Bedroom Number</option>
                                        <option value="1" <?= (isset($properties[0]->bedrooms) && $properties[0]->bedrooms == '1') ? 'selected' : ''; ?>>1</option>
                                        <option value="2" <?= (isset($properties[0]->bedrooms) && $properties[0]->bedrooms == '2') ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?= (isset($properties[0]->bedrooms) && $properties[0]->bedrooms == '3') ? 'selected' : ''; ?>>3</option>
                                        <option value="4" <?= (isset($properties[0]->bedrooms) && $properties[0]->bedrooms == '4') ? 'selected' : ''; ?>>4</option>
                                        <option value="5" <?= (isset($properties[0]->bedrooms) && $properties[0]->bedrooms == '5') ? 'selected' : ''; ?>>5</option>
                                      </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                      <label for="bathrooms">Bathroom Number</label>
                                      <select id="bathrooms" name="bathrooms" class="form-control">
                                        <option value="">Bathroom Number</option>
                                        <option value="1" <?= (isset($properties[0]->bathrooms) && $properties[0]->bathrooms == '1') ? 'selected' : ''; ?>>1</option>
                                        <option value="2" <?= (isset($properties[0]->bathrooms) && $properties[0]->bathrooms == '2') ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?= (isset($properties[0]->bathrooms) && $properties[0]->bathrooms == '3') ? 'selected' : ''; ?>>3</option>
                                        <option value="4" <?= (isset($properties[0]->bathrooms) && $properties[0]->bathrooms == '4') ? 'selected' : ''; ?>>4</option>
                                        <option value="5" <?= (isset($properties[0]->bathrooms) && $properties[0]->bathrooms == '5') ? 'selected' : ''; ?>>5</option>
                                      </select>
                                    </div>
                                </div>
                            <!--BHK option end-->

                    <!--kothi option start-->
                    <div id="kothi-options" class="row" style="display:none;">
                        <!--<div class="col-md-2 form-group">-->
                        <!--    <label>Number of Floors</label>-->
                        <!--    <input type="text" name="total_floors" class="form-control"-->
                        <!--    <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi'): ?>-->
                        <!--        value="<?= htmlspecialchars($properties_meta[0]->total_floors ?? '') ?>"-->
                        <!--    <?php endif; ?>-->
                        <!--    >-->
                        <!--</div>-->

                       <!-- Plot Area -->
<?php
    $plot_area = '';
    $plot_unit = '';

    if (!empty($properties[0]->land)) {
        $landParts = explode(' ', trim($properties[0]->land), 2); // only 2 parts
        $plot_area = $landParts[0] ?? '';
        $plot_unit = strtolower($landParts[1] ?? '');
    }
?>
                        <div class="col-md-3 form-group">
                            <label>Plot Area</label>
                            <div class="input-group">
                                <input type="text" name="kothi_plot_area" class="form-control" placeholder="Plot Area"
                                       value="<?= htmlspecialchars($plot_area); ?>">
                                <select id="area_unit" name="kothi_plot_area_unit" class="form-select">
                                    <option value="sq.yard" <?= ($plot_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                    <option value="marla"   <?= ($plot_unit == 'marla')   ? 'selected' : '' ?>>marla</option>
                                    <option value="kanal"   <?= ($plot_unit == 'kanal')   ? 'selected' : '' ?>>kanal</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Covered Area -->
                        <?php
                            $covered_area = '';
                            $covered_unit = '';
                        
                            if (!empty($properties[0]->built)) {
                                $parts = explode(' ', trim($properties[0]->built), 2); // only 2 parts
                                $covered_area = $parts[0] ?? '';
                                $covered_unit = strtolower($parts[1] ?? '');
                            }
                        ?>
                        <div class="col-md-3 form-group">
                            <label>Covered Area</label>
                            <div class="input-group">
                                <input type="text" name="kothi_covered_area" class="form-control" placeholder="Covered Area"
                                       value="<?= htmlspecialchars($covered_area); ?>">
                                <select id="covered_area_unit" name="kothi_covered_area_unit" class="form-select">
                                    <option value="sq.yard" <?= ($covered_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                    <option value="marla"   <?= ($covered_unit == 'marla')   ? 'selected' : '' ?>>marla</option>
                                    <option value="kanal"   <?= ($covered_unit == 'kanal')   ? 'selected' : '' ?>>kanal</option>
                                </select>
                            </div>
                        </div>


                         <!-- Kothi Type -->
                       <div class="col-md-3 form-group">
                            <label>Independent House / Kothi Type</label>
                            <select id="kothi_story_type" name="kothi_story_type" class="form-control">
                                <option value="">Select</option>
                                <option value="Single Story" <?= (isset($properties_meta[0]->kothi_story_type) && $properties_meta[0]->kothi_story_type == 'Single Story') ? 'selected' : '' ?>>Single Story</option>
                                <option value="Double Story" <?= (isset($properties_meta[0]->kothi_story_type) && $properties_meta[0]->kothi_story_type == 'Double Story') ? 'selected' : '' ?>>Double Story</option>
                                <option value="Duplex Story" <?= (isset($properties_meta[0]->kothi_story_type) && $properties_meta[0]->kothi_story_type == 'Duplex Story') ? 'selected' : '' ?>>Duplex Story</option>
                                <option value="Triplex Story" <?= (isset($properties_meta[0]->kothi_story_type) && $properties_meta[0]->kothi_story_type == 'Triplex Story') ? 'selected' : '' ?>>Triplex Story</option>
                                <option value="Villa Style" <?= (isset($properties_meta[0]->kothi_story_type) && $properties_meta[0]->kothi_story_type == 'Villa Style') ? 'selected' : '' ?>>Villa Style</option>
                            </select>
                       </div>

                        <!-- Construction Status -->
                        <div class="col-md-3 form-group">
                            <label>Construction Status</label>
                            <select  id="kothi_construction_status" name="construction_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Ready To Move"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                                    Ready To Move
                                </option>
                                <option value="Re-Sale"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'For Sale') ? 'selected' : '' ?>>
                                    For Sale
                                </option>
                                <option value="Under Construction"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : '' ?>>
                                    Under Construction
                                </option>
                            </select>
                        </div>



                        <!-- Property Age -->
                        <div id="kothi_property_age" class="col-md-3 form-group" style="display:none;">
                            <label>Property Age</label>
                            <select name="property_age" class="form-control">
                                <option value="">Select Age</option>
                                <option value="0-1 year"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '0-1 year') ? 'selected' : '' ?>>
                                    0-1 year
                                </option>
                                <option value="1-5 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '1-5 years') ? 'selected' : '' ?>>
                                    1-5 years
                                </option>
                                <option value="5-10 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '5-10 years') ? 'selected' : '' ?>>
                                    5-10 years
                                </option>
                                <option value="10+ years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '10+ years') ? 'selected' : '' ?>>
                                    10+ years
                                </option>
                            </select>
                        </div>

                        <!-- Gated Community -->
                        <div class="col-md-3 form-group">
                            <label>Gated Community?</label>
                            <div style="display:flex; gap:20px;">
                            <label>
                                <input type="radio" name="gated_community" value="1"
                                    <?= (isset($properties_meta[0]->gated_community) && $properties_meta[0]->gated_community == '1') ? 'checked' : '' ?>>
                                Yes
                            </label>
                            <label>
                                <input type="radio" name="gated_community" value="0"
                                    <?= (isset($properties_meta[0]->gated_community) && $properties_meta[0]->gated_community == '0') ? 'checked' : '' ?>>
                                No
                            </label>
                            </div>
                        </div>
                    </div>
                    <!--kothi option end-->


                    <!--plot option start-->

                        <?php
                        $plot_area = "";
                        $plot_unit = "";

                        // Check if property_type is Residential Plot and land value is set
                        if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Residential Plot' && isset($properties[0]->land)) {
                            $land_parts = explode(" ", $properties[0]->land, 2);
                            $plot_area = isset($land_parts[0]) ? $land_parts[0] : "";
                            $plot_unit = isset($land_parts[1]) ? $land_parts[1] : "";
                        }
                        ?>

                        <div id=plot-options class=row style=display:none>
                            <?php
                            $plot_area = '';
                            $plot_unit = '';
                            $width_length = '';
                            $direction = '';

                            if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Residential Plot') {
                                $plot_parts = explode(' ', $properties[0]->land ?? '');
                                $plot_area = $plot_parts[0] ?? '';
                                $plot_unit = $plot_parts[1] ?? '';
                                $width_length = $properties_meta[0]->width_length ?? '';
                                $direction = $properties_meta[0]->direction ?? '';
                            }
                            ?>
                            <div class="col-md-3 form-group">
                                    <label>Plot Area</label>
                                    <div class="input-group">
                                        <input name="p_plot_area" class="form-control" placeholder="e.g., 1500"
                                            <?php if ($plot_area): ?> value="<?= htmlspecialchars($plot_area); ?>" <?php endif; ?>
                                        >
                                        <select name="p_plot_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?= ($plot_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                            <option value="marla" <?= ($plot_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?= ($plot_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Width x Length</label>
                                <input name="width_length" class="form-control" placeholder="e.g., 30x40"
                                    <?php if ($width_length): ?> value="<?= htmlspecialchars($width_length); ?>" <?php endif; ?>
                                >
                            </div>

                        </div>

                    <!--plot option end-->

                    <!--farmhouse option start-->
                    <div id="farmhouse-options" class="row" style="display:none;">

                            <?php
                                $plot_area = "";
                                $plot_unit = "";

                                // Check if property_type is Residential Plot and land value is set
                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House' && isset($properties[0]->land)) {
                                    $land_parts = explode(" ", $properties[0]->land, 2);
                                    $plot_area = isset($land_parts[0]) ? $land_parts[0] : "";
                                    $plot_unit = isset($land_parts[1]) ? $land_parts[1] : "";
                                }
                            ?>
                          <!-- Plot Area -->
                          <div class="col-md-3 form-group">
                            <label>Plot Area</label>
                            <div class="input-group">
                               <input name="farm_plot_area" class="form-control" placeholder="e.g., 1500"
                                            value="<?php echo htmlspecialchars($plot_area); ?>"
                                        >
                              <select name="farm_plot_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?php echo ($plot_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                            <option value="marla" <?php echo ($plot_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?php echo ($plot_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                              </select>
                            </div>
                          </div>

                          <!-- Farm Area -->
                          <div class="col-md-3 form-group">

                              <?php
                                $farm_area = "";
                                $farm_unit = "";

                                // Check if property_type is 'Farm House' and carpet value is set
                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House' && isset($properties[0]->carpet)) {
                                    $farm_parts = explode(" ", $properties[0]->carpet, 2);
                                    $farm_area = isset($farm_parts[0]) ? $farm_parts[0] : "";
                                    $farm_unit = isset($farm_parts[1]) ? $farm_parts[1] : "";
                                }
                                ?>
                            <label>Farm Area (Optional)</label>
                            <div class="input-group">
                              <input name="farm_area" class="form-control" placeholder="Farm Area"
                                 value="<?php echo htmlspecialchars($farm_area); ?>">
                               <select name="farm_area_unit" class="form-control">
                                    <option value="">Select</option>
                                    <option value="acres" <?php echo ($farm_unit == "acres") ? "selected" : ""; ?>>acres</option>
                                    <option value="sq.ft" <?php echo ($farm_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                    <option value="marla" <?php echo ($farm_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                    <option value="kanal" <?php echo ($farm_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                </select>
                            </div>
                          </div>

                          <div class="col-md-3 form-group">
                                <label>Furnishing</label>
                                    <select name="furnishing_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Unfurnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Unfurnished') ? 'selected' : '' ?>>
                                        Unfurnished
                                    </option>
                                    <option value="Semi-Furnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Semi-Furnished') ? 'selected' : '' ?>>
                                        Semi-Furnished
                                    </option>
                                    <option value="Furnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Furnished') ? 'selected' : '' ?>>
                                        Furnished
                                    </option>
                                </select>
                          </div>

                        <?php
                            $gated_community_checked = '';

                            if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House') {
                                // Set direction only if property_type is 'Plot'
                                $gated_community_checked = $properties_meta[0]->gated_community ?? '';

                            }
                        ?>

                          <div class="col-md-3 form-group">
                                <label>Gated Community?</label><br>
                                <label>
                                    <input type="radio" name="gated_community" value="1"
                                        <?= ($gated_community_checked === '1') ? 'checked' : '' ?>>
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" name="gated_community" value="0"
                                        <?= ($gated_community_checked === '0') ? 'checked' : '' ?>>
                                    No
                                </label>
                            </div>

                        <div class="form-group col-md-3">
                            <label for="construction_status">Construction Status</label>
                            <select id="farmhouse_construction_status" name="construction_status" class="form-control">
                                <option value="">Select Construction Status</option>
                                <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Farm House'): ?>
                                    <option value="Ready To Move" <?= ($properties[0]->construction_status == 'Ready To Move') ? 'selected' : ''; ?>>Ready To Move</option>
                                    <option value="Re-Sale" <?= ($properties[0]->construction_status == 'Re-Sale') ? 'selected' : ''; ?>>Re-Sale</option>
                                    <option value="Under Construction" <?= ($properties[0]->construction_status == 'Under Construction') ? 'selected' : ''; ?>>Under Construction</option>
                                <?php else: ?>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="Re-Sale">Re-Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                <?php endif; ?>
                                </select>
                            </div>

                    </div>

                    <!--farmhouse option end-->

                    <!--floor option start-->
                     <div id="floor-options" class="row" style="display:none;">
                            <!-- Floor -->
                           <div class="col-md-3 form-group">
                            <label>Floor No</label>
                            <input name="floor_no" class="form-control"
                                <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor'): ?>
                                    value="<?php echo $properties_meta[0]->floor_no; ?>"
                                <?php endif; ?>
                                >
                            </div>

                             <div class="form-group col-md-3">
                                <label for="construction_status">Construction Status</label>
                                <select id="floor_construction_status" name="construction_status" class="form-control">
                                    <option value="">Select Construction Status</option>
                                    <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor'): ?>
                                        <option value="Ready To Move" <?= ($properties[0]->construction_status == 'Ready To Move') ? 'selected' : ''; ?>>Ready To Move</option>
                                        <option value="Re-Sale" <?= ($properties[0]->construction_status == 'Re-Sale') ? 'selected' : ''; ?>>Re-Sale</option>
                                        <option value="Under Construction" <?= ($properties[0]->construction_status == 'Under Construction') ? 'selected' : ''; ?>>Under Construction</option>
                                    <?php else: ?>
                                        <option value="Ready To Move">Ready To Move</option>
                                        <option value="Re-Sale">Re-Sale</option>
                                        <option value="Under Construction">Under Construction</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <?php
                                $carpet_value = '';
                                $carpet_unit = '';

                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor') {
                                    // Extract carpet area only if property_type is 'Builder Floor'
                                    $carpet_parts = explode(' ', $properties[0]->carpet ?? '');
                                    $carpet_value = $carpet_parts[0] ?? '';
                                    $carpet_unit = $carpet_parts[1] ?? '';
                                }
                            ?>

                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="floor_carpet_area" class="form-control" placeholder="Carpet Area" value="<?= htmlspecialchars($carpet_value) ?>">
                                    <select name="floor_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft" <?= ($carpet_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                        <option value="sq.yard" <?= ($carpet_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                        <option value="marla" <?= ($carpet_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                        <option value="kanal" <?= ($carpet_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                    </select>
                                </div>
                            </div>

                            <?php
                                $direction_selected = '';
                                $gated_community_checked = '';

                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor') {
                                    // Set direction only if property_type is 'Plot'
                                    $direction_selected = $properties_meta[0]->direction ?? '';
                                    $gated_community_checked = $properties_meta[0]->gated_community ?? '';

                                }
                            ?>

                            <div class="col-md-3 form-group">
                                <label>Gated Community?</label><br>
                                <label>
                                    <input type="radio" name="gated_community" value="1"
                                        <?= ($gated_community_checked === '1') ? 'checked' : '' ?>>
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" name="gated_community" value="0"
                                        <?= ($gated_community_checked === '0') ? 'checked' : '' ?>>
                                    No
                                </label>
                            </div>


                     </div>
                    <!--floor option end-->


                    <!--studio option start-->
                     <div id="studio-options" class="row" style="display:none">
                            <div class="col-md-3 form-group">
                                <label>Serviced Apartment Type</label>
                               <select id="bhk" name="bhk" class="form-control">
                                    <option value="">Select Serviced Apartment Type</option>
                                    <option value="1RK/Studio" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '1RK/Studio') ? 'selected' : ''; ?>>1RK/Studio</option>
                                    <option value="1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '1BHK') ? 'selected' : ''; ?>>1BHK</option>
                                    <option value="2BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '2BHK') ? 'selected' : ''; ?>>2BHK</option>
                                    <option value="2+1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '2+1BHK') ? 'selected' : ''; ?>>2+1BHK</option>
                                    <option value="3BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '3BHK') ? 'selected' : ''; ?>>3BHK</option>
                                    <option value="3+1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '3+1BHK') ? 'selected' : ''; ?>>3+1BHK</option>
                                    <option value="4BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '4BHK') ? 'selected' : ''; ?>>4BHK</option>
                                    <option value="4+1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '4+1BHK') ? 'selected' : ''; ?>>4+1BHK</option>
                                    <option value="5BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '5BHK') ? 'selected' : ''; ?>>5BHK</option>
                                    <option value="5+1BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '5+1BHK') ? 'selected' : ''; ?>>5+1BHK</option>
                                    <option value="Other" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="property_age" class="form-control">
                                <option value="">Select Age</option>
                                <option value="0-1 year"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Studio Apartment' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '0-1 year') ? 'selected' : '' ?>>
                                    0-1 year
                                </option>
                                <option value="1-5 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Studio Apartment' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '1-5 years') ? 'selected' : '' ?>>
                                    1-5 years
                                </option>
                                <option value="5-10 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Studio Apartment' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '5-10 years') ? 'selected' : '' ?>>
                                    5-10 years
                                </option>
                                <option value="10+ years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Studio Apartment' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '10+ years') ? 'selected' : '' ?>>
                                    10+ years
                                </option>
                            </select>
                            </div>
                     </div>

                    <!--studio option end-->


                    <!--other option start-->
                    <div id="other-options" class="row" style="display:none;">
                        <div class="col-md-3 form-group">
                            <label>Describe Property Type</label>
                            <?php
                                $other_property_type_val = '';
                                if (isset($properties[0]->category) && strtolower($properties[0]->category) == 'residential') {
                                    $other_property_type_val = !empty($properties_meta[0]->other_property_type) ? $properties_meta[0]->other_property_type : '';
                                }
                            ?>

                            <input name="other_property_type" class="form-control" placeholder="Specify Other Property Type"
                                   value="<?php echo htmlspecialchars($other_property_type_val); ?>">
                        </div>
                    </div>
                    <!--other option end-->

                </div>

                <!-- Commercial Fields -->
                <div style="display:none;width:100%" id="commercial-fields">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label>Property Type (Commercial)</label>
                                   <select class="form-control" name="property_type" id="comPropertyType">
                                    <option value="">Select Property Type</option>
                                    <option value="Office" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Office') ? 'selected' : '' ?>>Office</option>
                                    <option value="Retail" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Retail') ? 'selected' : '' ?>>Retail</option>
                                    <option value="Plot"
                                        <?= (isset($properties[0]->category) && strtolower($properties[0]->category) == 'commercial' &&
                                             isset($properties[0]->property_type) &&
                                             (strtolower($properties[0]->property_type) == 'plot' || strtolower($properties[0]->property_type) == 'plot/land'))
                                            ? 'selected' : '';
                                        ?>>
                                        Plot
                                    </option>                            <option value="Storage" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Storage') ? 'selected' : '' ?>>Storage/Warehouse</option>
                                    <option value="Industry/Factory" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Industry/Factory') ? 'selected' : '' ?>>Industry/Factory</option>
                                    <option value="Hospital" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Hospital') ? 'selected' : '' ?>>Hospital</option>
                                    <option value="Other" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Other') ? 'selected' : '' ?>>Other</option>
                                </select>
                                </div>
                            </div>


                             <!--com other option start-->
                                <div id="com-other-options" class="row" style="display:none;">
                                    <div class="col-md-3 form-group">
                                        <label>Describe Property Type</label>
                                        <?php
                                            $other_property_type_val = '';
                                            if (isset($properties[0]->category) && strtolower($properties[0]->category) == 'commercial') {
                                                $other_property_type_val = !empty($properties_meta[0]->other_property_type) ? $properties_meta[0]->other_property_type : '';
                                            }
                                        ?>

                                        <input name="other_property_type" class="form-control" placeholder="Specify Other Property Type"
                                               value="<?php echo htmlspecialchars($other_property_type_val); ?>">
                                    </div>
                                </div>
                                <!--com other option end-->

                             <!--COM OFFICE FEILD OPTIONS START-->
                            <div id="com-office-fields" style="display:none;" class="row">
                                  <div class="col-md-3 form-group">
                                        <label>Carpet Area</label>
                                        <div class="input-group">
                                            <?php
                                            $com_office_area = "";
                                            $com_office_unit = "";

                                            // Fill only if property_type is 'Office' and carpet is set
                                            if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties[0]->carpet)) {
                                                $carpet_parts = explode(" ", $properties[0]->carpet, 2);
                                                $com_office_area = isset($carpet_parts[0]) ? $carpet_parts[0] : "";
                                                $com_office_unit = isset($carpet_parts[1]) ? $carpet_parts[1] : "";
                                            }
                                            ?>
                                         <input name="com_office_carpet_area" class="form-control" placeholder="Carpet Area"
                                          value="<?php echo htmlspecialchars($com_office_area); ?>">
                                          <select name="com_office_carpet_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?php echo ($com_office_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                             <option value="sq.yard" <?php echo ($com_office_unit == "sq.yard") ? "selected" : ""; ?>>sq.yard</option>
                                            <option value="marla" <?php echo ($com_office_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?php echo ($com_office_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                        </select>
                                        </div>
                                  </div>

                                  <div class="col-md-3 form-group">
                                        <label>Area (sq.ft)</label>
                                        <div class="input-group">
                                            <?php
                                                $com_office_area_val = "";
                                                $com_office_area_unit = "";

                                                // Fill only if property_type is 'Office' and built is set
                                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties[0]->built)) {
                                                    $built_parts = explode(" ", $properties[0]->built, 2);
                                                    $com_office_area_val = isset($built_parts[0]) ? $built_parts[0] : "";
                                                    $com_office_area_unit = isset($built_parts[1]) ? $built_parts[1] : "";
                                                }
                                            ?>
                                           <input name="com_office_area" class="form-control" placeholder="Area"
                                              value="<?php echo htmlspecialchars($com_office_area_val); ?>">

                                          <select name="com_office_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?php echo ($com_office_area_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                            <option value="marla" <?php echo ($com_office_area_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?php echo ($com_office_area_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                        </select>
                                    </div>
                                  </div>

                                  <div class="col-md-3 form-group">
                                        <label>Furnishing</label>
                                            <select name="furnishing_status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Unfurnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Unfurnished') ? 'selected' : '' ?>>
                                                Unfurnished
                                            </option>
                                            <option value="Semi-Furnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Semi-Furnished') ? 'selected' : '' ?>>
                                                Semi-Furnished
                                            </option>
                                            <option value="Furnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Furnished') ? 'selected' : '' ?>>
                                                Furnished
                                            </option>
                                        </select>
                                  </div>

                                  <div class="col-md-3 form-group">
                                        <label>Lift Available?</label>
                                       <?php
                                        $has_lift_val = "";

                                        // Check if property type is Office
                                        if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office') {
                                            if (isset($properties_meta[0]->has_lift)) {
                                                $has_lift_val = $properties_meta[0]->has_lift;
                                            }
                                        }
                                        ?>
                                        <select name="has_lift" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" <?= ($has_lift_val === '1') ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= ($has_lift_val === '0') ? 'selected' : '' ?>>No</option>
                                        </select>

                                  </div>

                                  <div class="col-md-3 form-group">
                                      <?php
                                        $parking_val = "";

                                        // Pre-fill only if property_type is 'Office'
                                        if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office') {
                                            if (isset($properties_meta[0]->parking_available)) {
                                                $parking_val = $properties_meta[0]->parking_available;
                                            }
                                        }
                                        ?>

                                        <label>Parking Available?</label>
                                           <select name="parking_available" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" <?= ($parking_val === '1') ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= ($parking_val === '0') ? 'selected' : '' ?>>No</option>
                                            </select>

                                  </div>

                                  <div class="col-md-3 form-group">
                                    <label>Construction Status</label>
                                    <select name="construction_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Ready To Move"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                                            Ready To Move
                                        </option>
                                        <option value="For Sale"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'For Sale') ? 'selected' : '' ?>>
                                            For Sale
                                        </option>
                                        <option value="Under Construction"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Office' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : '' ?>>
                                            Under Construction
                                        </option>
                                    </select>
                                </div>

                            </div>

                          <!--COM OFFICE FEILD OPTIONS END -->

                          <!--COM RETAIL FEILD OPTIONS START -->
                          <div id="com-retail-fields" style="display:none;">
                            <div class="row">
                                <!-- Furnishing -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Furnishing</label>
                                        <select name="furnishing_status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Unfurnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Unfurnished') ? 'selected' : '' ?>>
                                                Unfurnished
                                            </option>
                                            <option value="Semi-Furnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Semi-Furnished') ? 'selected' : '' ?>>
                                                Semi-Furnished
                                            </option>
                                            <option value="Furnished"
                                                <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Furnished') ? 'selected' : '' ?>>
                                                Furnished
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Area in sq.ft -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Area in sq.ft</label>
                                       <?php
                                        $retail_area_val = "";

                                        // Fill only if property_type is 'Retail' and carpet is set
                                        if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail') {
                                            if (!empty($properties[0]->carpet)) {
                                                $retail_area_val = $properties[0]->carpet;
                                            }
                                        }
                                        ?>

                                        <input type="text" name="retail_area_in_sqft" class="form-control" placeholder="Area in sq.ft"
                                               value="<?php echo htmlspecialchars($retail_area_val); ?>">
                                    </div>
                                </div>

                                <!-- Floor No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Floor No</label>
                                            <?php
                                            $floor_no = '';
                                            if (isset($properties[0]->property_type) && strtolower($properties[0]->property_type) == 'retail') {
                                                $floor_no = isset($properties_meta[0]->floor_no) ? $properties_meta[0]->floor_no : '';
                                            }
                                            ?>

                                            <input type="text" name="floor_no" class="form-control" placeholder="Floor Number"
                                                   value="<?php echo htmlspecialchars($floor_no); ?>">
                                    </div>
                                </div>

                                <!-- Lift -->
                                <?php
                                $has_lift = isset($properties_meta[0]->has_lift) ? strtolower($properties_meta[0]->has_lift) : '';
                                ?>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Is there a lift?</label><br>
                                        <?php
                                            $has_lift_val1 = "";

                                            // Check if property type is Office
                                            if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail') {
                                                if (isset($properties_meta[0]->has_lift)) {
                                                    $has_lift_val1 = $properties_meta[0]->has_lift;
                                                }
                                            }
                                        ?>
                                       <select name="has_lift" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" <?= ($has_lift_val1 === '1') ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= ($has_lift_val1 === '0') ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Parking -->
                               <?php
                                $parking_val1 = "";

                                if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail') {
                                    if (isset($properties_meta[0]->parking_available)) {
                                        $parking_val1 = $properties_meta[0]->parking_available;
                                    }
                                }
                                ?>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Parking Available?</label><br>
                                         <select name="parking_available" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" <?= ($parking_val1 === '1') ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= ($parking_val1 === '0') ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                 <!-- Construction Status -->
                                   <div class="col-md-3 form-group">
                                    <label>Construction Status</label>
                                    <select name="construction_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Ready To Move"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                                            Ready To Move
                                        </option>
                                        <option value="For Sale"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'For Sale') ? 'selected' : '' ?>>
                                            For Sale
                                        </option>
                                        <option value="Under Construction"
                                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Retail' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : '' ?>>
                                            Under Construction
                                        </option>
                                    </select>
                                </div>


                            </div>
                            <!-- .row -->
                          </div>

                          <!--COM RETAIL FEILD OPTIONS END -->


                        <!-- COM PLOT FIELD OPTIONS START -->
                        <div id="com-plot-fields" class="row" style="display: block;">

                            <?php
                            $com_plot_area_val = "";
                            $com_plot_area_unit = "";
                            $width_length = "";
                            $road_width = "";
                            $use_type = "";
                            $com_plot_carpet_area = "";
                            $com_plot_carpet_area_unit = "";

                            if (isset($properties[0]->property_type) && (strtolower($properties[0]->property_type) == 'plot' || strtolower($properties[0]->property_type) == 'plot/land')) {
                                if (!empty($properties[0]->land)) {
                                    $land_parts = explode(" ", $properties[0]->land, 2);
                                    $com_plot_area_val = isset($land_parts[0]) ? $land_parts[0] : "";
                                    $com_plot_area_unit = isset($land_parts[1]) ? $land_parts[1] : "";
                                }
                                $width_length = isset($properties_meta[0]->width_length) ? $properties_meta[0]->width_length : "";
                                $road_width = isset($properties_meta[0]->road_width) ? $properties_meta[0]->road_width : "";
                                $use_type = isset($properties_meta[0]->commercial_useType) ? $properties_meta[0]->commercial_useType : "";
                                $com_plot_carpet_area = isset($properties_meta[0]->com_plot_carpet_area) ? $properties_meta[0]->com_plot_carpet_area : "";
                                $com_plot_carpet_area_unit = isset($properties_meta[0]->com_plot_carpet_area_unit) ? $properties_meta[0]->com_plot_carpet_area_unit : "";
                            }
                            ?>

                            <!-- Plot Area -->
                            <div class="form-group col-md-3">
                                <label for="com_plot_area">Plot Area</label>
                                <div class="input-group">
                                    <input type="text" id="com_plot_area" name="com_plot_area" class="form-control"
                                           placeholder="Plot Area" value="<?= htmlspecialchars($com_plot_area_val); ?>">
                                    <select name="com_plot_area_unit" class="form-control" style="max-width: 100px;">
                                        <option value="">Select</option>
                                        <option value="sq.ft" <?= ($com_plot_area_unit == 'sq.ft') ? 'selected' : ''; ?>>sq.ft</option>
                                        <option value="marla" <?= ($com_plot_area_unit == 'marla') ? 'selected' : ''; ?>>marla</option>
                                        <option value="kanal" <?= ($com_plot_area_unit == 'kanal') ? 'selected' : ''; ?>>kanal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Width x Length -->
                            <div class="form-group col-md-6">
                                <label for="com_width_length">Width x Length</label>
                                <input type="text" id="com_width_length" name="width_length" class="form-control"
                                       placeholder="e.g., 30x40" value="<?= htmlspecialchars($width_length); ?>">
                            </div>

                            <!-- Road Width -->
                            <div class="form-group col-md-6">
                                <label for="com_road_width">Road Width</label>
                                <select id="com_road_width" name="road_width" class="form-control">
                                    <option value="">Select</option>
                                    <option value="20ft" <?= ($road_width == '20ft') ? 'selected' : ''; ?>>20ft</option>
                                    <option value="30ft" <?= ($road_width == '30ft') ? 'selected' : ''; ?>>30ft</option>
                                    <option value="40ft" <?= ($road_width == '40ft') ? 'selected' : ''; ?>>40ft</option>
                                    <option value="50ft+" <?= ($road_width == '50ft+') ? 'selected' : ''; ?>>50ft+</option>
                                </select>
                            </div>

                            <!-- Use Type -->
                            <div class="form-group col-md-6">
                                <label for="com_use_type">Use Type</label>
                                <select id="com_use_type" name="commercial_useType" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Industrial" <?= ($use_type == 'Industrial') ? 'selected' : ''; ?>>Industrial</option>
                                    <option value="ShowRoom" <?= ($use_type == 'ShowRoom') ? 'selected' : ''; ?>>ShowRoom</option>
                                    <option value="Shop" <?= ($use_type == 'Shop') ? 'selected' : ''; ?>>Shop</option>
                                    <option value="Office" <?= ($use_type == 'Office') ? 'selected' : ''; ?>>Office</option>
                                    <option value="Warehouse" <?= ($use_type == 'Warehouse') ? 'selected' : ''; ?>>Warehouse</option>
                                    <option value="Retail" <?= ($use_type == 'Retail') ? 'selected' : ''; ?>>Retail</option>
                                    <option value="Other" <?= ($use_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <!-- Carpet Area -->
                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="com_plot_carpet_area" class="form-control" placeholder="Carpet Area"
                                           value="<?= htmlspecialchars($com_plot_carpet_area); ?>">
                                    <select name="com_plot_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft" <?= ($com_plot_carpet_area_unit == 'sq.ft') ? 'selected' : ''; ?>>sq.ft</option>
                                       <option value="sq.yard" <?= ($com_plot_carpet_area_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                        <option value="marla" <?= ($com_plot_carpet_area_unit == 'marla') ? 'selected' : ''; ?>>marla</option>
                                        <option value="kanal" <?= ($com_plot_carpet_area_unit == 'kanal') ? 'selected' : ''; ?>>kanal</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- COM PLOT FIELD OPTIONS END -->



                          <!--COM STORAGE FEILD OPTIONS START -->
                         <div id="com-storage-fields" style="display:none;">
                            <div class="row">

                                <!-- Built Area -->
                                <div class="form-group col-md-6">
                                    <label for="builtArea">Built Area</label>
                                    <div class="input-group">
                                        <?php
                                            $com_built_area_val = "";
                                            $com_built_area_unit = "";

                                            if (isset($properties[0]->property_type) && strtolower($properties[0]->property_type) == 'storage' && !empty($properties[0]->built)) {
                                                $built_parts = explode(" ", $properties[0]->built, 2);
                                                $com_built_area_val = $built_parts[0] ?? "";
                                                $com_built_area_unit = $built_parts[1] ?? "";
                                            }
                                        ?>
                                        <input type="text" name="com_built_area" class="form-control" placeholder="Built Area"
                                            value="<?php echo htmlspecialchars($com_built_area_val); ?>">
                                        <select name="com_built_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?= ($com_built_area_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                             <option value="sq.yard" <?= ($com_built_area_unit == "sq.yard") ? "selected" : ""; ?>>sq.yard</option>
                                            <option value="marla" <?= ($com_built_area_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?= ($com_built_area_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Land Area -->
                                <div class="form-group col-md-6">
                                    <label for="landArea">Land Area</label>
                                    <div class="input-group">
                                        <?php
                                            $com_land_area = "";
                                            $com_land_unit = "";

                                            if (isset($properties[0]->property_type) && strtolower($properties[0]->property_type) == 'storage' && !empty($properties[0]->land)) {
                                                $land_parts = explode(" ", $properties[0]->land, 2);
                                                $com_land_area = $land_parts[0] ?? "";
                                                $com_land_unit = $land_parts[1] ?? "";
                                            }
                                        ?>
                                        <input type="text" name="com_land_area" class="form-control" placeholder="Land Area"
                                            value="<?php echo htmlspecialchars($com_land_area); ?>">
                                        <select name="com_land_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft" <?= ($com_land_unit == "sq.ft") ? "selected" : ""; ?>>sq.ft</option>
                                            <option value="sq.yard" <?= ($com_land_unit == "sq.yard") ? "selected" : ""; ?>>sq.yard</option>
                                            <option value="marla" <?= ($com_land_unit == "marla") ? "selected" : ""; ?>>marla</option>
                                            <option value="kanal" <?= ($com_land_unit == "kanal") ? "selected" : ""; ?>>kanal</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- No. of Shutters -->
                                <div class="form-group col-md-6">
                                    <label for="shutters">No. of Shutters</label>
                                    <input type="text" name="shutters_count" class="form-control" placeholder="Number of Shutters"
                                        value="<?= isset($properties_meta[0]->shutters_count) ? htmlspecialchars($properties_meta[0]->shutters_count) : ''; ?>">
                                </div>

                                <!-- Roof Height -->
                                <div class="form-group col-md-6">
                                    <label for="roofHeight">Height of Roof</label>
                                    <input type="text" name="roof_height" class="form-control" placeholder="Height (ft)"
                                        value="<?= isset($properties_meta[0]->roof_height) ? htmlspecialchars($properties_meta[0]->roof_height) : ''; ?>">
                                </div>

                                <!-- Loading/Unloading Bay -->
                                <div class="form-group col-md-6">
                                    <?php
                                        $loading_bay = "";
                                        if (isset($properties[0]->property_type) && strtolower($properties[0]->property_type) == 'storage') {
                                            if (isset($properties_meta[0]->loading_bay)) {
                                                $loading_bay = ($properties_meta[0]->loading_bay == '1') ? 'yes' : (($properties_meta[0]->loading_bay == '0') ? 'no' : '');
                                            }
                                        }
                                    ?>
                                    <label for="loading_bay">Loading/Unloading Bay</label><br>
                                    <label><input type="radio" name="loading_bay" value="1" <?= ($loading_bay == 'yes') ? 'checked' : ''; ?>> Yes</label>
                                    <label><input type="radio" name="loading_bay" value="0" <?= ($loading_bay == 'no') ? 'checked' : ''; ?>> No</label>
                                </div>

                                <!-- Construction Status -->
                                <div class="form-group col-md-3">
                                    <?php $construction_status = isset($properties_meta[0]->construction_status) ? $properties_meta[0]->construction_status : ''; ?>
                                    <label>Construction Status</label>
                                    <select name="construction_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Ready To Move" <?= ($construction_status == 'Ready To Move') ? 'selected' : ''; ?>>Ready To Move</option>
                                        <option value="For Sale" <?= ($construction_status == 'For Sale') ? 'selected' : ''; ?>>For Sale</option>
                                        <option value="Under Construction" <?= ($construction_status == 'Under Construction') ? 'selected' : ''; ?>>Under Construction</option>
                                    </select>
                                </div>

                                <!-- Property Age -->
                                <div class="form-group col-md-6">
                                    <?php $property_age = isset($properties_meta[0]->property_age) ? $properties_meta[0]->property_age : ''; ?>
                                    <label for="propertyAge">Property Age</label>
                                    <select name="property_age" class="form-control">
                                        <option value="">Select Age</option>
                                        <option value="0-1 year" <?= ($property_age == '0-1 year') ? 'selected' : ''; ?>>0-1 year</option>
                                        <option value="1-5 years" <?= ($property_age == '1-5 years') ? 'selected' : ''; ?>>1-5 years</option>
                                        <option value="5-10 years" <?= ($property_age == '5-10 years') ? 'selected' : ''; ?>>5-10 years</option>
                                        <option value="10+ years" <?= ($property_age == '10+ years') ? 'selected' : ''; ?>>10+ years</option>
                                    </select>
                                </div>

                            </div> <!-- end .row -->
                        </div> <!-- end #com-storage-fields -->

                          <!--COM STORAGE FEILD OPTIONS END -->

                         <!-- COM FACTORY FIELD OPTIONS START -->
                        <div id="com-factory-fields" class="row" style="display:none;">
                            <?php
                                $isFactory = isset($properties[0]->property_type) && strtolower($properties[0]->property_type) == 'industry/factory';

                                $built_value        = $isFactory && isset($properties[0]->built) ? $properties[0]->built : '';
                                $built_unit         = $isFactory && isset($properties_meta[0]->factory_built_area_unit) ? $properties_meta[0]->factory_built_area_unit : '';
                                $land_value         = $isFactory && isset($properties[0]->land) ? $properties[0]->land : '';
                                $land_unit          = $isFactory && isset($properties_meta[0]->factory_land_area_unit) ? $properties_meta[0]->factory_land_area_unit : '';
                                $shutters_count     = $isFactory && isset($properties_meta[0]->shutters_count) ? $properties_meta[0]->shutters_count : '';
                                $roof_height        = $isFactory && isset($properties_meta[0]->roof_height) ? $properties_meta[0]->roof_height : '';
                                $loading_bay        = $isFactory && isset($properties_meta[0]->loading_bay) ? $properties_meta[0]->loading_bay : '';
                                $property_age       = $isFactory && isset($properties_meta[0]->property_age) ? $properties_meta[0]->property_age : '';
                                $construction_status = $isFactory && isset($properties[0]->construction_status) ? $properties[0]->construction_status : '';
                            ?>

                            <!-- Built Area -->
                            <div class="form-group col-md-6">
                                <label for="builtArea">Built Area</label>
                                <div class="input-group">
                                    <input type="text" name="factory_built_area" class="form-control" placeholder="Built Area"
                                           value="<?= htmlspecialchars($built_value) ?>">
                                    <select name="factory_built_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft" <?= ($built_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                           <option value="sq.yard" <?= ($built_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                        <option value="marla" <?= ($built_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                        <option value="kanal" <?= ($built_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Land Area -->
                            <div class="form-group col-md-6">
                                <label for="landArea">Land Area</label>
                                <div class="input-group">
                                    <input type="text" name="factory_land_area" class="form-control" placeholder="Land Area"
                                           value="<?= htmlspecialchars($land_value) ?>">
                                    <select name="factory_land_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft" <?= ($land_unit == 'sq.ft') ? 'selected' : '' ?>>sq.ft</option>
                                        <option value="sq.yard" <?= ($land_unit == 'sq.yard') ? 'selected' : '' ?>>sq.yard</option>
                                        <option value="marla" <?= ($land_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                                        <option value="kanal" <?= ($land_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Shutters Count -->
                            <div class="form-group col-md-6">
                                <label for="shutters">No. of Shutters</label>
                                <input type="text" name="shutters_count" class="form-control" placeholder="Number of Shutters"
                                       value="<?= htmlspecialchars($shutters_count) ?>">
                            </div>

                            <!-- Roof Height -->
                            <div class="form-group col-md-6">
                                <label for="roofHeight">Height of Roof</label>
                                <input type="text" name="roof_height" class="form-control" placeholder="Height (ft)"
                                       value="<?= htmlspecialchars($roof_height) ?>">
                            </div>

                            <!-- Loading Bay -->
                            <div class="form-group col-md-6">
                                <label for="loading_bay">Loading/Unloading Bay</label><br>
                                <label><input type="radio" name="loading_bay" value="1" <?= ($loading_bay === '1') ? 'checked' : '' ?>> Yes</label>
                                <label><input type="radio" name="loading_bay" value="0" <?= ($loading_bay === '0') ? 'checked' : '' ?>> No</label>
                            </div>

                            <!-- Property Age -->
                            <div class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="property_age" class="form-control">
                                    <option value="">Select Age</option>
                                    <option value="0-1 year" <?= ($property_age == '0-1 year') ? 'selected' : '' ?>>0-1 year</option>
                                    <option value="1-5 years" <?= ($property_age == '1-5 years') ? 'selected' : '' ?>>1-5 years</option>
                                    <option value="5-10 years" <?= ($property_age == '5-10 years') ? 'selected' : '' ?>>5-10 years</option>
                                    <option value="10+ years" <?= ($property_age == '10+ years') ? 'selected' : '' ?>>10+ years</option>
                                </select>
                            </div>

                            <!-- Construction Status -->
                            <div class="col-md-3 form-group">
                                <label>Construction Status</label>
                                <select name="construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move" <?= ($construction_status == 'Ready To Move') ? 'selected' : '' ?>>Ready To Move</option>
                                    <option value="For Sale" <?= ($construction_status == 'For Sale') ? 'selected' : '' ?>>For Sale</option>
                                    <option value="Under Construction" <?= ($construction_status == 'Under Construction') ? 'selected' : '' ?>>Under Construction</option>
                                </select>
                            </div>
                        </div>
                        <!-- COM FACTORY FIELD OPTIONS END -->



                          <!--COM HOSPITAL FEILD OPTIONS START -->
                         <?php
                            $property_type = isset($properties[0]->property_type) ? strtolower($properties[0]->property_type) : '';
                            $prefill = ($property_type === 'hospital');

                            $hospital_type = $prefill && isset($properties_meta[0]->hospital_type) ? $properties_meta[0]->hospital_type : '';
                            $additional_value = $prefill && isset($properties[0]->additional_value) ? $properties[0]->additional_value : '';
                            $floor_available = $prefill && isset($properties_meta[0]->floor_available) ? $properties_meta[0]->floor_available : '';
                            $furnishing_status = $prefill && isset($properties_meta[0]->furnishing_status) ? $properties_meta[0]->furnishing_status : '';
                            $hospital_license = $prefill && isset($properties_meta[0]->hospital_license) ? $properties_meta[0]->hospital_license : '';
                            $possession_status = $prefill && isset($properties_meta[0]->possession_status) ? $properties_meta[0]->possession_status : '';
                            $medical_facilities = $prefill && isset($properties_meta[0]->medical_facilities) ? json_decode($properties_meta[0]->medical_facilities, true) : [];
                            ?>

                            <div id="com-hospital-fields" class="row" style="display:none;">

                              <!-- Hospital Type -->
                              <div class="col-md-3 form-group">
                                <label for="hospital_type">Hospital Type</label>
                                <select id="hospital_type" name="hospital_type" class="form-control">
                                  <option value="">Select Hospital Type</option>
                                  <option value="Multispecialty" <?= ($hospital_type == 'Multispecialty') ? 'selected' : '' ?>>Multispecialty</option>
                                  <option value="Clinic" <?= ($hospital_type == 'Clinic') ? 'selected' : '' ?>>Clinic</option>
                                  <option value="Diagnostic Centre" <?= ($hospital_type == 'Diagnostic Centre') ? 'selected' : '' ?>>Diagnostic Centre</option>
                                  <option value="Dental" <?= ($hospital_type == 'Dental') ? 'selected' : '' ?>>Dental</option>
                                  <option value="Orthopedic" <?= ($hospital_type == 'Orthopedic') ? 'selected' : '' ?>>Orthopedic</option>
                                  <option value="Maternity" <?= ($hospital_type == 'Maternity') ? 'selected' : '' ?>>Maternity</option>
                                  <option value="Eye Hospital" <?= ($hospital_type == 'Eye Hospital') ? 'selected' : '' ?>>Eye Hospital</option>
                                </select>
                              </div>

                              <!-- Total Beds -->
                              <div class="col-md-3 form-group">
                                <label for="additional_value">Total Beds</label>
                                <select id="additional_value" name="additional_value" class="form-control">
                                  <option value="">Enter total beds</option>
                                  <option value="10" <?= ($additional_value == '10') ? 'selected' : '' ?>>10</option>
                                  <option value="20" <?= ($additional_value == '20') ? 'selected' : '' ?>>20</option>
                                  <option value="30" <?= ($additional_value == '30') ? 'selected' : '' ?>>30</option>
                                  <option value="50" <?= ($additional_value == '50') ? 'selected' : '' ?>>50</option>
                                  <option value="100+" <?= ($additional_value == '100+') ? 'selected' : '' ?>>100+</option>
                                </select>
                              </div>

                              <!-- Available Floor -->
                              <div class="col-md-3 form-group">
                                <label for="floor_available">Available Floor</label>
                                <select id="floor_available" name="floor_available" class="form-control">
                                  <option value="">Select Available Floor</option>
                                  <option value="Ground" <?= ($floor_available == 'Ground') ? 'selected' : '' ?>>Ground</option>
                                  <option value="1st" <?= ($floor_available == '1st') ? 'selected' : '' ?>>1st</option>
                                  <option value="2nd" <?= ($floor_available == '2nd') ? 'selected' : '' ?>>2nd</option>
                                  <option value="3rd" <?= ($floor_available == '3rd') ? 'selected' : '' ?>>3rd</option>
                                  <option value="Full Building" <?= ($floor_available == 'Full Building') ? 'selected' : '' ?>>Full Building</option>
                                </select>
                              </div>

                              <!-- Furnishing Type -->
                              <div class="col-md-3 form-group">
                                <label for="furnishing_status">Furnishing Type</label>
                                <select name="furnishing_status" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Unfurnished" <?= ($furnishing_status == 'Unfurnished') ? 'selected' : '' ?>>Unfurnished</option>
                                  <option value="Semi-Furnished" <?= ($furnishing_status == 'Semi-Furnished') ? 'selected' : '' ?>>Semi-Furnished</option>
                                  <option value="Furnished" <?= ($furnishing_status == 'Furnished') ? 'selected' : '' ?>>Furnished</option>
                                </select>
                              </div>

                              <!-- Hospital License -->
                              <div class="col-md-3 form-group">
                                <label for="hospital_license" class="form-label">Hospital License Type</label>
                                <select id="hospital_license" name="hospital_license" class="form-select">
                                  <option value="">Select Hospital License Type</option>
                                  <option value="Registered under Clinical Establishment Act" <?= ($hospital_license == 'Registered under Clinical Establishment Act') ? 'selected' : '' ?>>Registered under Clinical Establishment Act</option>
                                  <option value="Private Limited" <?= ($hospital_license == 'Private Limited') ? 'selected' : '' ?>>Private Limited</option>
                                  <option value="Proprietorship" <?= ($hospital_license == 'Proprietorship') ? 'selected' : '' ?>>Proprietorship</option>
                                  <option value="Other" <?= ($hospital_license == 'Other') ? 'selected' : '' ?>>Other</option>
                                </select>
                              </div>

                              <!-- Possession Status -->
                              <div class="col-md-3 form-group">
                                <label for="possession_status" class="form-label">Possession Status</label>
                                <select id="possession_status" name="possession_status" class="form-select">
                                  <option value="">Select Possession Status</option>
                                  <option value="Operational" <?= ($possession_status == 'Operational') ? 'selected' : '' ?>>Operational</option>
                                  <option value="Vacant" <?= ($possession_status == 'Vacant') ? 'selected' : '' ?>>Vacant</option>
                                  <option value="Under Renovation" <?= ($possession_status == 'Under Renovation') ? 'selected' : '' ?>>Under Renovation</option>
                                  <option value="Under Construction" <?= ($possession_status == 'Under Construction') ? 'selected' : '' ?>>Under Construction</option>
                                </select>
                              </div>

                              <!-- Medical Facilities -->
                              <div class="col-md-6 form-group">
                                <label class="form-label d-block">Medical Facilities Available</label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="ICU Room" <?= in_array('ICU Room', $medical_facilities) ? 'checked' : '' ?>> ICU Room</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Operation Theatre" <?= in_array('Operation Theatre', $medical_facilities) ? 'checked' : '' ?>> Operation Theatre</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Emergency Room" <?= in_array('Emergency Room', $medical_facilities) ? 'checked' : '' ?>> Emergency Room</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="OPD Rooms" <?= in_array('OPD Rooms', $medical_facilities) ? 'checked' : '' ?>> OPD Rooms</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Ambulance Parking" <?= in_array('Ambulance Parking', $medical_facilities) ? 'checked' : '' ?>> Ambulance Parking</div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Pharmacy Setup" <?= in_array('Pharmacy Setup', $medical_facilities) ? 'checked' : '' ?>> Pharmacy Setup</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Doctor's Cabins" <?= in_array("Doctor's Cabins", $medical_facilities) ? 'checked' : '' ?>> Doctor's Cabins</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Pathology Lab" <?= in_array('Pathology Lab', $medical_facilities) ? 'checked' : '' ?>> Pathology Lab</div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Radiology Room" <?= in_array('Radiology Room', $medical_facilities) ? 'checked' : '' ?>> Radiology Room</div>
                                  </div>
                                </div>
                              </div>

                            </div>

                          <!--COM HOSPITAL FEILD OPTIONS END -->
                </div>

                    <!-- Price Section -->
                  <?php
                    $amount = '';
                    $unit = '';
                    if (isset($properties[0]->budget_in_words)) {
                        $budgetParts = explode(' ', trim($properties[0]->budget_in_words));
                        $amount = $budgetParts[0] ?? '';
                        $unit = strtolower($budgetParts[1] ?? '');
                    }
                    ?>

                    <div class="row" style="width:100%;">
                        <div class="form-group col-md-6">
                            <label>Demanded Price</label>
                            <div class="input-group">
                                <input name="budget_in_words" class="form-control" placeholder="Enter price"
                                       value="<?php echo htmlspecialchars($amount); ?>">
                                <select class="form-control" name="price_unit" style="max-width:120px">
                                    <option value="lakhs" <?php echo ($unit == 'lakhs') ? 'selected' : ''; ?>>Lakhs</option>
                                    <option value="crore" <?php echo ($unit == 'crore') ? 'selected' : ''; ?>>Crore</option>
                                </select>
                            </div>
                        </div>
                   
                    
  <?php 
$hot_deals = isset($properties[0]->hot_deals) ? $properties[0]->hot_deals : 'No';
?>
<div class="form-group col-md-6">
<label>Hot Deals</label>

<label>
    <input type="radio" name="hot_deals" value="Yes" <?= ($hot_deals == 'Yes') ? 'checked' : '' ?>> Yes
</label>

<label>
    <input type="radio" name="hot_deals" value="No" <?= ($hot_deals == 'No') ? 'checked' : '' ?>> No
</label>
 </div>
</div>

                    <!-- Extra Fields Toggle -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="toggleExtraFields"> Show Extra Fields
                        </label>
                    </div>

                    <div id="extra-fields" style="display:none;">

                            <!-- Extra Fields -->
                            <?php
                                $selectedAmenities = [];
                                if (isset($properties[0]->amenities)) {
                                    $selectedAmenities = explode('~-~', $properties[0]->amenities);
                                }
                            ?>

                            <div class="form-group">
                                <label>Amenities*</label>
                               <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    $amenitiesList1 = [
                                        "Car parking",
                                        "Security services",
                                        "Water supply",
                                        "Elevators",
                                        "Power backup",
                                        "Gym",
                                        "Play area",
                                    ];
                            
                                    foreach ($amenitiesList1 as $index => $amenity) {
                                        $checked = in_array($amenity, $selectedAmenities) ? 'checked' : '';
                                        $id = 'amenity1-' . $index;
                                        echo '
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="' . $id . '" name="amenities[]" value="' . htmlspecialchars($amenity) . '" ' . $checked . '>
                                            <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($amenity) . '</label>
                                        </div>';
                                    }
                                    ?>
                                </div>
                            
                                <div class="col-md-6">
                                    <?php
                                    $amenitiesList2 = [
                                        "Swimming pool",
                                        "Restaurants",
                                        "Party hall",
                                        "Temple and religious activity place",
                                        "Cinema hall",
                                        "Walking/Jogging track"
                                    ];
                            
                                    foreach ($amenitiesList2 as $index => $amenity) {
                                        $checked = in_array($amenity, $selectedAmenities) ? 'checked' : '';
                                        $id = 'amenity2-' . $index;
                                        echo '
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="' . $id . '" name="amenities[]" value="' . htmlspecialchars($amenity) . '" ' . $checked . '>
                                            <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($amenity) . '</label>
                                        </div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            </div>


      
                            <div class="row">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <div id="tag-container" class="d-flex flex-wrap">
                                        <!-- Tags will be shown here -->
                                        <input type="text" id="tag-input" class="form-control me-2" placeholder="Add tag" style="width:auto;" />
                                        <button type="button" id="add-tag-btn" class="btn btn-success">Add</button>
                                    </div>
                                    <!-- Important: DB value ko default me set karo -->
                                    <input type="hidden" name="property_tags" id="property_tags"
                                           value="<?php echo isset($properties[0]->property_tags) ? $properties[0]->property_tags : ''; ?>">
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City*</label>
                                        <input name="city" class="form-control" placeholder="Mohali"
                                         value="<?php echo isset($properties[0]->city) ? $properties[0]->city : ''; ?>">

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Facing</label>
                                    <input name="facing" class="form-control"
                                        value="<?= htmlspecialchars($properties_meta[0]->facing ?? '') ?>">
                                </div>
                            <div class="col-md-3 form-group">
                                <label>Direction</label>
                                <?php $directionValue = htmlspecialchars($properties_meta[0]->direction ?? ''); ?>
                                <select name="direction" class="form-control">
                                    <option value="">Select Direction</option>
                                    <option value="East" <?= ($directionValue == 'East') ? 'selected' : '' ?>>East</option>
                                    <option value="West" <?= ($directionValue == 'West') ? 'selected' : '' ?>>West</option>
                                    <option value="North" <?= ($directionValue == 'North') ? 'selected' : '' ?>>North</option>
                                    <option value="South" <?= ($directionValue == 'South') ? 'selected' : '' ?>>South</option>
                                    <option value="North-East" <?= ($directionValue == 'North-East') ? 'selected' : '' ?>>North-East</option>
                                    <option value="North-West" <?= ($directionValue == 'North-West') ? 'selected' : '' ?>>North-West</option>
                                    <option value="South-East" <?= ($directionValue == 'South-East') ? 'selected' : '' ?>>South-East</option>
                                    <option value="South-West" <?= ($directionValue == 'South-West') ? 'selected' : '' ?>>South-West</option>
                                    <option value="Other" <?= ($directionValue == 'Other') ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            
                            
                            </div>

                            <div class="row">
                                <?php
                                $imageFields = ['image_one', 'image_two', 'image_three', 'image_four'];

                                foreach ($imageFields as $field):
                                    $existingFile = isset($properties[0]->$field) ? trim($properties[0]->$field) : '';
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture</label>
                                            <input name="<?= $field ?>" class="form-control" type="file">
                                            <?php if (!empty($existingFile)): ?>
                                                <small style="display:block; margin-top:4px; color: #555;  font-weight: bold;">
                                                    Selected: <?= htmlspecialchars(basename($existingFile)) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                    </div>

                    <div id="dynamic_field" class="row">
                        <label id="label" style="display:none">Additional Details</label>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <input name="save" class="btn btn-primary property-submit-btn" value="Submit" type="submit">
                        </div>
                    </div>

                </form>
            </div> <!--main mt-3 pt-5 end -->
        </div> <!--row end -->
    </div> <!--container end -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script>
jQuery(document).ready(function () {

    // ================= Autocomplete =================
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

    var i = 1;

    function clearFields(selector) {
        const container = jQuery(selector);
        container.find('input, select, textarea').each(function () {
            if (this.type === 'checkbox' || this.type === 'radio') {
                this.checked = false;
            } else {
                jQuery(this).val('');
            }
        });
    }

    // ================= Property Tags Code =================
    let tags = [];

    function renderTags() {
        $("#tag-container .tag").remove();
        tags.forEach((tag, index) => {
            $("#tag-input").before(`
                <span class="tag badge bg-primary me-1 mb-1" 
                      style="display: flex;justify-content: center;align-items: center;background: #007485 !important;font-size: 14px;font-weight: normal;text-transform: capitalize;gap: 5px;">
                    ${tag} 
                    <span class="remove-tag" data-index="${index}" 
                          style="cursor:pointer;background: red;border-radius: 100px;display: flex;justify-content: center;align-items: flex-start;padding: 2px;font-size: 15px;height: 20px;width: 20px;">
                        &times;
                    </span>
                </span>
            `);
        });
        $("#property_tags").val(tags.join("~-~"));
    }

    // Load old tags in EDIT MODE
    let existingTags = $("#property_tags").val();
    if (existingTags) {
        tags = existingTags.split("~-~").map(t => t.trim()).filter(t => t !== "");
    }

    // Auto load category, property_type, city as tags
    function loadFieldsAsTags() {
        let autoTags = [];

        let categoryVal = $("#categorySelector").val().trim();
        if (categoryVal && !tags.includes(categoryVal)) autoTags.push(categoryVal);

        let propertyTypeVal = $("#comPropertyType, #resPropertyType").val();
        if (propertyTypeVal && !tags.includes(propertyTypeVal)) autoTags.push(propertyTypeVal);

        let cityVal = $("input[name='city']").val().trim();
        if (cityVal && !tags.includes(cityVal)) autoTags.push(cityVal);

        autoTags.forEach(tag => {
            if (tag && !tags.includes(tag)) tags.push(tag);
        });

        renderTags();
    }

    // Initial render
    loadFieldsAsTags();

    // Add tag button
    $("#add-tag-btn").on("click", function () {
        const tagVal = $("#tag-input").val().trim();
        if (tagVal !== "" && !tags.includes(tagVal)) {
            tags.push(tagVal);
            $("#tag-input").val("");
            renderTags();
        }
    });

    // Add tag on Enter
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

    // Update tags if fields change
    $("#categorySelector, #comPropertyType, #resPropertyType, input[name='city']").on("change", function() {
        loadFieldsAsTags();
    });
    


    // ================= Show/hide property age =================
    jQuery('#bhk_construction_status').on('change', function () {
        const selectedValue = jQuery(this).val();
        const ageGroup = jQuery('#bhk_property_age');
        if (selectedValue === 'Re-Sale') { ageGroup.show(); } else { ageGroup.hide(); }
    });

    jQuery('#kothi_construction_status').on('change', function () {
        const selectedValue = jQuery(this).val();
        const ageGroup = jQuery('#kothi_property_age');
        if (selectedValue === 'Re-Sale') { ageGroup.show(); } else { ageGroup.hide(); }
    });

    // ================= Toggle Residential/Commercial Fields =================
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

    function showResidentialSubFields() {
        const type = jQuery('#resPropertyType').val();
        jQuery('#studio-options,#other-options,#bhk-options, #kothi-options, #plot-options, #farmhouse-options, #floor-options').hide();

        if (type === 'Apartment / Flat') { jQuery('#bhk-options').show(); }
        else if (type === 'Independent House / Kothi') { jQuery('#kothi-options').show(); }
        else if (type === 'Residential Plot') { jQuery('#plot-options').show(); }
        else if (type === 'Farm House') { jQuery('#farmhouse-options').show(); }
        else if (type === 'Builder Floor') { jQuery('#floor-options').show(); }
        else if (type === 'Studio Apartment') { jQuery('#studio-options').show(); }
        else if (type === 'Other') { jQuery('#other-options').show(); }
    }

    function toggleCommercialSubFields(type) {
        $('#com-factory-fields,#com-other-options, #com-hospital-fields, #com-office-fields, #com-retail-fields, #com-plot-fields, #com-storage-fields').hide();
        switch (type) {
            case "Office": $("#com-office-fields").show(); break;
            case "Retail": $("#com-retail-fields").show(); break;
            case "Plot": $("#com-plot-fields").show(); break;
            case "Storage": $("#com-storage-fields").show(); break;
            case "Industry/Factory": $("#com-factory-fields").show(); break;
            case "Hospital": $("#com-hospital-fields").show(); break;
            case "Other": $("#com-other-options").show(); break;
        }
    }

    // ================= Toggle Extra Fields =================
    jQuery('#toggleExtraFields').change(function () {
        if (jQuery(this).is(':checked')) { jQuery('#extra-fields').slideDown(); } 
        else { jQuery('#extra-fields').slideUp(); }
    });

    // ================= Add Custom Fields Dynamically =================
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

    // ================= Trigger on Load =================
    toggleCategoryFields();
    const category = "<?= isset($properties[0]->category) ? $properties[0]->category : '' ?>";
    if (category === 'Residential') { showResidentialSubFields(); } 
    else if (category === 'Commercial') { toggleCommercialSubFields(jQuery('#comPropertyType').val()); }

    // ================= Event Bindings =================
    jQuery('#categorySelector').change(toggleCategoryFields);

    jQuery('#resPropertyType').change(function () {
        const sections = [
            '#studio-options','#other-options','#bhk-options','#kothi-options','#plot-options','#farmhouse-options','#floor-options',
            '#com-factory-fields','#com-hospital-fields','#com-office-fields','#com-retail-fields','#com-plot-fields','#com-storage-fields'
        ];
        sections.forEach(section => { jQuery(section).hide(); clearFields(section); });
        showResidentialSubFields();
    });

    jQuery('#comPropertyType').change(function () {
        const sections = [
            '#studio-options','#other-options','#bhk-options','#kothi-options','#plot-options','#farmhouse-options','#floor-options',
            '#com-factory-fields','#com-hospital-fields','#com-office-fields','#com-retail-fields','#com-plot-fields','#com-storage-fields','#com-other-options'
        ];
        sections.forEach(section => { jQuery(section).hide(); clearFields(section); });
        toggleCommercialSubFields(jQuery(this).val());
    });

});
</script>

<script>
    $(document).ready(function () {
        $('#propertyForm').on('submit', function (e) {
            e.preventDefault();

            const form = $('#propertyForm')[0];
            const formData = new FormData(form);

            // Merge amenities[] into a string
            const selectedAmenities = [];
            $("input[name='amenities[]']:checked").each(function () {
                selectedAmenities.push($(this).val());
            });
            formData.set('amenities', selectedAmenities.join("~-~"));

            // Merge value + unit fields
            const unitFields = {
                "floor_carpet_area": "floor_carpet_area_unit",
                "com_built_area": "com_built_area_unit",
                "com_land_area": "com_land_area_unit",
                "bhk_land_area": "bhk_land_area_unit",
                "bhk_carpet_area": "bhk_carpet_area_unit",
                "bhk_built_area": "bhk_built_area_unit",
                "com_office_carpet_area": "com_office_carpet_area_unit",
                "com_office_area": "com_office_area_unit",
                "com_plot_area": "com_plot_area_unit",
                "plot_area": "plot_area_unit",
                "p_plot_area": "p_plot_area_unit",
                //"kothi_covered_area": "kothi_covered_area_unit",
                //"kothi_plot_area": "kothi_plot_area_unit",
                "farm_plot_area": "farm_plot_area_unit",
                "farm_area": "farm_area_unit",
                "budget_in_words": "price_unit",
                "carpet": "carpet_area_unit"
            };

            for (const key in unitFields) {
                const val = formData.get(key);
                const unit = formData.get(unitFields[key]);
                if (val && unit) {
                    formData.set(key, `${val} ${unit}`);
                }
            }

            // Convert budget_in_words → numeric budget
            const budgetInWords = formData.get("budget_in_words");
            if (budgetInWords) {
                const budgetParts = budgetInWords.split(' ');
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
                        formData.set("budget", budgetValue.toLocaleString('en-IN'));
                    }
                }
            }

            // Rename keys to DB field equivalents
            const renameKeys = {
                "floor_carpet_area": "carpet",
                "com_width_length": "width_length",
                "expected_price": "budget",
                "plot_area": "carpet",
                "p_plot_area": "land",
                "farm_plot_area": "land",
               
                "farm_area": "carpet",
                "com_office_carpet_area": "carpet",
                "com_office_area": "built",
                "retail_area_in_sqft": "carpet",
                "com_plot_area": "land",
                "com_land_area": "land",
                "com_built_area": "built",
                "bhk_land_area": "land",
                "bhk_built_area": "built",
                "bhk_carpet_area": "carpet",
                "factory_built_area": "built"
            };

            for (const oldKey in renameKeys) {
                if (formData.has(oldKey)) {
                    const value = formData.get(oldKey);
                    //console.log(`Before rename: ${oldKey} = ${value}`);
                    //console.log(`Will rename to: ${renameKeys[oldKey]}`);

                    if (value === null || value.trim() === '') {
                        // If value is empty, just delete the old key
                        formData.delete(oldKey);
                       // console.log(`Deleted empty key: ${oldKey}`);
                    } else {
                        // Otherwise, rename it
                        formData.set(renameKeys[oldKey], value);
                        formData.delete(oldKey);
                        //console.log(`Renamed ${oldKey} to ${renameKeys[oldKey]}`);
                    }
                }
            }


            // Clean FormData (remove blanks except valid files)
            const cleanedFormData = new FormData();
            for (let [key, value] of formData.entries()) {
                if (value instanceof File && value.name !== "") {
                    cleanedFormData.append(key, value);
                } else if (typeof value === 'string' && value.trim() !== "") {
                    cleanedFormData.append(key, value);
                }
            }

            // Submit via AJAX
            $.ajax({
                url: '<?php echo base_url("/api/Properties/editProperty/"); ?>',
                type: 'POST',
                data: cleanedFormData,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer 9j1h8hgjO0KUin2bhj58d97jiOh67f5h48hj78hg8vg5j63fo0h930'
                },
                success: function (response) {
                    try {
                        const res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.status === "success" || res.status === "done") {
                            alert("Property updated successfully!");
                            window.location.href = '/admin/properties/';
                        } else {
                            alert("Error: " + (res.message || "Unknown error"));
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                        alert("Unexpected server response.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    let errorMsg = "AJAX Error: ";

                    if (xhr.responseText) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMsg += response.message || error || "Unknown server error.";
                        } catch (e) {
                            errorMsg += xhr.responseText || error || "Unexpected server error.";
                        }
                    } else {
                        errorMsg += error || "No response from server.";
                    }

                    alert(errorMsg);
                }
            });
        });
    });

</script>

