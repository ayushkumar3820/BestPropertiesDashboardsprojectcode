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
                        <label>Facing</label>
                        <input name="facing" class="form-control"
                        <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Apartment / Flat'): ?>
                                value="<?= htmlspecialchars($properties_meta[0]->facing ?? '') ?>"
                            <?php endif; ?>
                        >
                    </div>
                </div>
            <!--BHK option end-->

            <!--kothi option start-->
            <div id="kothi-options" class="row" style="display:none;">
                <div class="col-md-3 form-group">
                    <label>Number of Floors</label>
                    <input type="text" name="total_floors" class="form-control"
                    <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi'): ?>
                        value="<?= htmlspecialchars($properties_meta[0]->total_floors ?? '') ?>"
                    <?php endif; ?>
                    >
                </div>


                <div class="col-md-3 form-group">
                    <label>Facing</label>
                    <input type="text" name="facing" class="form-control"
                    <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi'): ?>
                            value="<?= htmlspecialchars($properties_meta[0]->facing ?? '') ?>"
                        <?php endif; ?>
                    >
                </div>

                <!-- Plot Area -->
                <?php
                    $plot_area = '';
                    $plot_unit = '';

                    if (isset($properties[0]->land)) {
                        $landParts = explode(' ', trim($properties[0]->land));
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
                            <option value="marla" <?= ($plot_unit == 'marla') ? 'selected' : '' ?>>marla</option>
                            <option value="kanal" <?= ($plot_unit == 'kanal') ? 'selected' : '' ?>>kanal</option>
                        </select>
                    </div>
                </div>

                <!-- Covered Area -->
               <?php
                $covered_area = '';
                $covered_unit = '';

                if (isset($properties[0]->built)) {
                    $parts = explode(' ', trim($properties[0]->built));
                    $covered_area = $parts[0] ?? '';
                    $covered_unit = strtolower($parts[1] ?? '');
                }
                ?>

                <div class="col-md-3 form-group">
                    <label>Covered Area</label>
                    <div class="input-group">
                        <input type="text" name="kothi_covered_area" class="form-control" placeholder="Covered Area"
                               value="<?php echo htmlspecialchars($covered_area); ?>">
                        <select id="covered_area_unit" name="kothi_covered_area_unit" class="form-select">
                            <option value="sq.yard" <?php echo ($covered_unit == 'sq.yard') ? 'selected' : ''; ?>>sq.yard</option>
                            <option value="marla" <?php echo ($covered_unit == 'marla') ? 'selected' : ''; ?>>marla</option>
                            <option value="kanal" <?php echo ($covered_unit == 'kanal') ? 'selected' : ''; ?>>kanal</option>
                        </select>
                    </div>
                </div>

                 <!-- Kothi Type -->
               <div class="col-md-4 form-group">
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
                    <select name="construction_status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Ready To Move"
                            <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Independent House / Kothi' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                            Ready To Move
                        </option>
                        <option value="For Sale"
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
                <div class="col-md-3 form-group">
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
            <!--kothi option end-->


            <!--plot option start-->

                <div id=plot-options class=row style=display:none>
                    <div class="col-md-3 form-group">
                            <label>Plot Area</label>
                            <div class="input-group">
                                <input name="plot_area" class="form-control" placeholder="e.g., 1500"
                                value="<?php echo $properties[0]->land; ?>"
                                >
                                <select name="plot_area_unit" class="form-control">
                                      <option value="">Select</option>
                                    <option value="sq.ft">sq.ft</option>
                                    <option value="marla">marla</option>
                                    <option value="kanal">kanal</option>
                                </select>
                            </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Width x Length</label>
                        <input name="width_length" class="form-control" placeholder="e.g., 30x40"
                        value="<?php echo $properties_meta[0]->width_length; ?>"
                        >
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Direction</label>
                        <select name="direction" class="form-control">
                            <option value="">Select Direction</option>
                            <option value="East" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'East') ? 'selected' : '' ?>>East</option>
                            <option value="West" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'West') ? 'selected' : '' ?>>West</option>
                            <option value="North" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'North') ? 'selected' : '' ?>>North</option>
                            <option value="South" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'South') ? 'selected' : '' ?>>South</option>
                            <option value="North-East" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'North-East') ? 'selected' : '' ?>>North-East</option>
                            <option value="North-West" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'North-West') ? 'selected' : '' ?>>North-West</option>
                            <option value="South-East" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'South-East') ? 'selected' : '' ?>>South-East</option>
                            <option value="South-West" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'South-West') ? 'selected' : '' ?>>South-West</option>
                            <option value="Other" <?= (isset($properties_meta[0]->direction) && $properties_meta[0]->direction == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>

                    </div>

                </div>

            <!--plot option end-->

            <!--farmhouse option start-->
            <div id="farmhouse-options" class="row" style="display:none;">
                  <!-- Plot Area -->
                  <div class="col-md-3 form-group">
                    <label>Plot Area</label>
                    <div class="input-group">
                      <input name="farm_plot_area" class="form-control" placeholder="Plot Area"
                      value="<?php echo $properties[0]->land; ?>"
                      >
                      <select name="farm_plot_area_unit" class="form-control">
                            <option value="">Select</option>
                        <option value="sq.ft">sq.ft</option>
                        <option value="marla">marla</option>
                        <option value="kanal">kanal</option>
                      </select>
                    </div>
                  </div>

                  <!-- Farm Area -->
                  <div class="col-md-3 form-group">
                    <label>Farm Area (Optional)</label>
                    <div class="input-group">
                      <input name="farm_area" class="form-control" placeholder="Farm Area"
       value="<?php echo isset($properties_meta[0]->carpet) ? htmlspecialchars($properties_meta[0]->carpet) : ''; ?>">
                      <select name="farm_area_unit" class="form-control">
                            <option value="">Select</option>
                        <option value="acres">acres</option>
                        <option value="sq.ft">sq.ft</option>
                        <option value="marla">marla</option>
                        <option value="kanal">kanal</option>
                      </select>
                    </div>
                  </div>

            </div>

            <!--farmhouse option end-->

            <!--floor option start-->
             <div id="floor-options" class="row" style="display:none;">
                    <!-- Floor Type -->
                   <div class="col-md-3 form-group">
                    <label>Independent/Builder Floor Type</label>
                    <input name="floor_no" class="form-control"
                        <?php if (isset($properties[0]->property_type) && $properties[0]->property_type == 'Builder Floor'): ?>
                            value="<?php echo $properties_meta[0]->floor_no; ?>"
                        <?php endif; ?>
                        >
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
                            <option value="3BHK" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == '3BHK') ? 'selected' : ''; ?>>3BHK</option>
                            <option value="Penthouse" <?php echo (isset($properties[0]->bhk) && $properties[0]->bhk == 'Penthouse') ? 'selected' : ''; ?>>Penthouse</option>
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
                    <input type="text" name="property_type" class="form-control"
                        value="<?php echo (isset($properties[0]->property_type) && $properties[0]->property_type == 'Other') ? $properties[0]->property_type : ''; ?>">
                </div>
            </div>
            <!--other option end-->

            </div>

            <!-- Commercial Fields -->
            <div style="display:none;margin-left:16px;width:100%" id="commercial-fields">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Property Type (Commercial)</label>
                           <select class="form-control" name="property_type" id="comPropertyType">
                            <option value="">Select Property Type</option>
                            <option value="Office" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Office') ? 'selected' : '' ?>>Office</option>
                            <option value="Retail" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Retail') ? 'selected' : '' ?>>Retail</option>
                            <option value="Plot" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Plot') ? 'selected' : '' ?>>Plot</option>
                            <option value="Storage" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Storage') ? 'selected' : '' ?>>Storage/Warehouse</option>
                            <option value="Industry/Factory" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Industry/Factory') ? 'selected' : '' ?>>Industry/Factory</option>
                            <option value="Hospital" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Hospital') ? 'selected' : '' ?>>Hospital</option>
                            <option value="Other" <?= (isset($properties[0]->category) && $properties[0]->category == 'Commercial' && $properties[0]->property_type == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                        </div>
                    </div>

                     <!--COM OFFICE FEILD OPTIONS START-->
                    <div id="com-office-fields" style="display:none;" class="row">
                          <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                  <input name="com_office_carpet_area" class="form-control" placeholder="Carpet Area"
                                  value="<?php echo $properties[0]->carpet; ?>"
                                  >
                                  <select name="com_office_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                    <option value="sq.ft">sq.ft</option>
                                    <option value="marla">marla</option>
                                    <option value="kanal">kanal</option>
                                  </select>
                                </div>
                          </div>

                          <div class="col-md-3 form-group">
                                <label>Area (sq.ft)</label>
                                <div class="input-group">
                                  <input name="com_office_area" class="form-control" placeholder="Area"
                                  value="<?php echo $properties[0]->built; ?>"
                                  >
                                  <select name="com_office_area_unit" class="form-control">
                                    <option value="">Select</option>
                                    <option value="sq.ft">sq.ft</option>
                                    <option value="marla">marla</option>
                                    <option value="kanal">kanal</option>
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
                                <select name="has_lift" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes" <?= (isset($properties_meta[0]->has_lift) && $properties_meta[0]->has_lift == 'Yes') ? 'selected' : '' ?>>Yes</option>
                                    <option value="No" <?= (isset($properties_meta[0]->has_lift) && $properties_meta[0]->has_lift == 'No') ? 'selected' : '' ?>>No</option>
                                </select>

                          </div>

                          <div class="col-md-3 form-group">
                                <label>Parking Available?</label>
                                <select name="parking_available" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes" <?= (isset($properties_meta[0]->parking_available) && $properties_meta[0]->parking_available == 'Yes') ? 'selected' : '' ?>>Yes</option>
                                    <option value="No" <?= (isset($properties_meta[0]->parking_available) && $properties_meta[0]->parking_available == 'No') ? 'selected' : '' ?>>No</option>
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
                                <input type="text" name="retail_area_in_sqft" class="form-control" placeholder="Area in sq.ft"
                                    value="<?php echo isset($properties_meta[0]->carpet) ? $properties_meta[0]->carpet : ''; ?>">

                            </div>
                        </div>

                        <!-- Floor No -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Floor No</label>
                            <input type="text" name="floor_no" class="form-control" placeholder="Floor Number"
                            value="<?php echo isset($properties_meta[0]->floor_no) ? $properties_meta[0]->floor_no : ''; ?>">
                             </div>
                        </div>

                        <!-- Lift -->
                        <?php
                        $has_lift = isset($properties_meta[0]->has_lift) ? strtolower($properties_meta[0]->has_lift) : '';
                        ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Is there a lift?</label><br>
                                <label>
                                    <input type="radio" name="has_lift" value="yes" <?php echo ($has_lift == 'yes') ? 'checked' : ''; ?>> Yes
                                </label>
                                <label>
                                    <input type="radio" name="has_lift" value="no" <?php echo ($has_lift == 'no') ? 'checked' : ''; ?>> No
                                </label>
                            </div>
                        </div>

                        <!-- Parking -->
                       <?php
                        $parking_available = isset($properties_meta[0]->parking_available) ? strtolower($properties_meta[0]->parking_available) : '';
                        ?>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Parking Available?</label><br>
                                <label>
                                    <input type="radio" name="parking_available" value="yes" <?php echo ($parking_available == 'yes') ? 'checked' : ''; ?>> Yes
                                </label>
                                <label>
                                    <input type="radio" name="parking_available" value="no" <?php echo ($parking_available == 'no') ? 'checked' : ''; ?>> No
                                </label>
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


                  <!--COM PLOT FEILD OPTIONS START -->
                  <div id="com-plot-fields" class="row" style="display: none;">

                        <!-- Plot Area with Unit -->
                        <div class="form-group col-md-3">
                            <label for="com_plot_area">Plot Area</label>
                            <div class="input-group">
                                <input type="text" id="com_plot_area" name="com_plot_area" class="form-control" placeholder="Plot Area">
                                <select name="com_plot_area_unit" class="form-control" style="max-width: 100px;">
                                    <option value="">Select</option>
                                    <option value="sq.ft">sq.ft</option>
                                    <option value="marla">marla</option>
                                    <option value="kanal">kanal</option>
                                </select>
                            </div>
                        </div>

                        <!-- Width x Length -->
                        <div class="form-group col-md-6">
                            <label for="com_width_length">Width x Length</label>
                            <input type="text" id="com_width_length" name="width_length" class="form-control" placeholder="e.g., 30x40"
                                   value="<?php echo isset($properties_meta[0]->width_length) ? $properties_meta[0]->width_length : ''; ?>">
                        </div>

                        <!-- Road Width -->
                        <div class="form-group col-md-6">
                            <label for="com_road_width">Road Width</label>
                            <?php $road_width = isset($properties_meta[0]->road_width) ? $properties_meta[0]->road_width : ''; ?>
                            <select id="com_road_width" name="road_width" class="form-control">
                                <option value="">Select</option>
                                <option value="20ft" <?php echo ($road_width == '20ft') ? 'selected' : ''; ?>>20ft</option>
                                <option value="30ft" <?php echo ($road_width == '30ft') ? 'selected' : ''; ?>>30ft</option>
                                <option value="40ft" <?php echo ($road_width == '40ft') ? 'selected' : ''; ?>>40ft</option>
                                <option value="50ft+" <?php echo ($road_width == '50ft+') ? 'selected' : ''; ?>>50ft+</option>
                            </select>
                        </div>

                        <!-- Use Type -->
                        <div class="form-group col-md-6">
                           <?php $use_type = isset($properties_meta[0]->use_type) ? $properties_meta[0]->use_type : ''; ?>
                            <label for="com_use_type">Use Type</label>
                            <select id="com_use_type" name="use_type" class="form-control">
                                <option value="">Select</option>
                                <option value="Industrial" <?php echo ($use_type == 'Industrial') ? 'selected' : ''; ?>>Industrial</option>
                                <option value="ShowRoom" <?php echo ($use_type == 'ShowRoom') ? 'selected' : ''; ?>>ShowRoom</option>
                                <option value="Shop" <?php echo ($use_type == 'Shop') ? 'selected' : ''; ?>>Shop</option>
                                <option value="Office" <?php echo ($use_type == 'Office') ? 'selected' : ''; ?>>Office</option>
                                <option value="Warehouse" <?php echo ($use_type == 'Warehouse') ? 'selected' : ''; ?>>Warehouse</option>
                                <option value="Retail" <?php echo ($use_type == 'Retail') ? 'selected' : ''; ?>>Retail</option>
                                <option value="Other" <?php echo ($use_type == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>

                        </div>

                  </div>

                  <!--COM PLOT FEILD OPTIONS END -->


                  <!--COM STORAGE FEILD OPTIONS START -->
                  <div id="com-storage-fields" style="display:none;">
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label for="builtArea">Built Area</label>
                              <div class="input-group">
                                <input type="text" name="com_built_area" class="form-control" placeholder="Built Area">
                                <select name="com_built_area_unit" class="form-control">
                                      <option value="">Select</option>
                                  <option value="sq.ft">sq.ft</option>
                                  <option value="marla">marla</option>
                                  <option value="kanal">kanal</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="landArea">Land Area</label>
                              <div class="input-group">
                                <input type="text" name="com_land_area" class="form-control" placeholder="Land Area"
                                value="<?php echo isset($properties[0]->land) ? $properties[0]->land : ''; ?>">
                                <select name="com_land_area_unit" class="form-control">
                                      <option value="">Select</option>
                                  <option value="sq.ft">sq.ft</option>
                                  <option value="marla">marla</option>
                                  <option value="kanal">kanal</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="shutters">No. of Shutters</label>
                              <input type="text" name="shutters_count" class="form-control" placeholder="Number of Shutters"
                              value="<?php echo isset($properties_meta[0]->shutters_count) ? $properties_meta[0]->shutters_count : ''; ?>">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="roofHeight">Height of Roof</label>
                              <input type="text" name="roof_height" class="form-control" placeholder="Height (ft)"
                              value="<?php echo isset($properties_meta[0]->roof_height) ? $properties_meta[0]->roof_height : ''; ?>">
                            </div>

                            <?php
                            $loading_bay = isset($properties_meta[0]->loading_bay) ? strtolower($properties_meta[0]->loading_bay) : '';
                            $construction_status = isset($properties_meta[0]->construction_status) ? $properties_meta[0]->construction_status : '';
                            $property_age = isset($properties_meta[0]->property_age) ? $properties_meta[0]->property_age : '';
                            ?>

                            <!-- Loading/Unloading Bay -->
                            <div class="form-group col-md-6">
                              <label for="loadingBay">Loading/Unloading Bay</label><br>
                              <label><input type="radio" name="loading_bay" value="yes" <?= ($loading_bay == 'yes') ? 'checked' : '' ?>> Yes</label>
                              <label><input type="radio" name="loading_bay" value="no" <?= ($loading_bay == 'no') ? 'checked' : '' ?>> No</label>
                            </div>

                            <!-- Construction Status -->
                            <div class="col-md-3 form-group">
                                <label>Construction Status</label>
                                <select name="construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                                        Ready To Move
                                    </option>
                                    <option value="For Sale"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'For Sale') ? 'selected' : '' ?>>
                                        For Sale
                                    </option>
                                    <option value="Under Construction"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : '' ?>>
                                        Under Construction
                                    </option>
                                </select>
                            </div>

                           <!-- Property Age -->
                          <div class="form-group col-md-6">
                              <label for="propertyAge">Property Age</label>
                              <select name="property_age" class="form-control">
                                <option value="">Select Age</option>
                                <option value="0-1 year"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '0-1 year') ? 'selected' : '' ?>>
                                    0-1 year
                                </option>
                                <option value="1-5 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '1-5 years') ? 'selected' : '' ?>>
                                    1-5 years
                                </option>
                                <option value="5-10 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '5-10 years') ? 'selected' : '' ?>>
                                    5-10 years
                                </option>
                                <option value="10+ years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Storage' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '10+ years') ? 'selected' : '' ?>>
                                    10+ years
                                </option>
                            </select>
                        </div>

                 </div>
                  <!--COM STORAGE FEILD OPTIONS END -->

                  <!--COM FACTORY FEILD OPTIONS START -->
                   <div id="com-factory-fields" style="display:none;" class="row">
                        <div class="col-md-3 form-group">
                            <label>Built Area</label>
                            <input type="text" name="built" class="form-control"
                            value="<?php echo isset($properties[0]->built) ? $properties[0]->built : ''; ?>">

                        </div>

                        <div class="col-md-3 form-group">
                            <label>Property Age</label>
                            <?php $property_age = isset($properties_meta[0]->property_age) ? $properties_meta[0]->property_age : ''; ?>

                            <select name="property_age" class="form-control">
                                <option value="">Select Age</option>
                                <option value="0-1 year"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '0-1 year') ? 'selected' : '' ?>>
                                    0-1 year
                                </option>
                                <option value="1-5 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '1-5 years') ? 'selected' : '' ?>>
                                    1-5 years
                                </option>
                                <option value="5-10 years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '5-10 years') ? 'selected' : '' ?>>
                                    5-10 years
                                </option>
                                <option value="10+ years"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties_meta[0]->property_age) && $properties_meta[0]->property_age == '10+ years') ? 'selected' : '' ?>>
                                    10+ years
                                </option>
                            </select>
                      </div>

                         <!-- Step 2 -->
                        <!-- Construction Status -->
                        <div class="col-md-3 form-group">
                            <label>Construction Status</label>
                            <select name="construction_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Ready To Move"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Ready To Move') ? 'selected' : '' ?>>
                                    Ready To Move
                                </option>
                                <option value="For Sale"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'For Sale') ? 'selected' : '' ?>>
                                    For Sale
                                </option>
                                <option value="Under Construction"
                                    <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Industry/Factory' && isset($properties[0]->construction_status) && $properties[0]->construction_status == 'Under Construction') ? 'selected' : '' ?>>
                                    Under Construction
                                </option>
                            </select>
                        </div>


                    </div>
                  <!--COM FACTORY FEILD OPTIONS END -->


                  <!--COM HOSPITAL FEILD OPTIONS START -->
                   <div id="com-hospital-fields" style="display:none;" class="row">

                          <?php
                            $hospital_type = isset($properties_meta[0]->hospital_type) ? $properties_meta[0]->hospital_type : '';
                            $additional_value = isset($properties[0]->additional_value) ? $properties[0]->additional_value : '';
                            $floor_available = isset($properties_meta[0]->floor_available) ? $properties_meta[0]->floor_available : '';
                            $furnishing_status = isset($properties_meta[0]->furnishing_status) ? $properties_meta[0]->furnishing_status : '';
                            ?>

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

                            <div class="col-md-3 form-group">
                                <label for="furnishing_status">Furnishing Type</label>
                                <select name="furnishing_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Unfurnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Hospital' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Unfurnished') ? 'selected' : '' ?>>
                                        Unfurnished
                                    </option>
                                    <option value="Semi-Furnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Hospital' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Semi-Furnished') ? 'selected' : '' ?>>
                                        Semi-Furnished
                                    </option>
                                    <option value="Furnished"
                                        <?= (isset($properties[0]->property_type) && $properties[0]->property_type == 'Hospital' && isset($properties_meta[0]->furnishing_status) && $properties_meta[0]->furnishing_status == 'Furnished') ? 'selected' : '' ?>>
                                        Furnished
                                    </option>
                                </select>
                            </div>

                   </div>

                  <!--COM HOSPITAL FEILD OPTIONS END -->



            </div>
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

            <div class="row" style="width:100%;margin-left:16px">
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
                        <label>Amenities*</label><br>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                $amenitiesList1 = [
                                    "Car parking", "Security services", "Water supply",
                                    "Elevators", "Power backup", "Gym", "Play area"
                                ];
                                foreach ($amenitiesList1 as $amenity) {
                                    $checked = in_array($amenity, $selectedAmenities) ? 'checked' : '';
                                    echo '<label><input name="amenities[]" value="' . htmlspecialchars($amenity) . '" type="checkbox" ' . $checked . '> ' . htmlspecialchars($amenity) . '</label><br>';
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $amenitiesList2 = [
                                    "Swimming pool", "Restaurants", "Party hall",
                                    "Temple and religious activity place", "Cinema hall", "Walking/Jogging track"
                                ];
                                foreach ($amenitiesList2 as $amenity) {
                                    $checked = in_array($amenity, $selectedAmenities) ? 'checked' : '';
                                    echo '<label><input name="amenities[]" value="' . htmlspecialchars($amenity) . '" type="checkbox" ' . $checked . '> ' . htmlspecialchars($amenity) . '</label><br>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City*</label>
                                <input name="city" class="form-control" placeholder="Mohali"
                                 value="<?php echo isset($properties[0]->city) ? $properties[0]->city : ''; ?>">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>State*</label>
                                <input name="state" class="form-control" placeholder="Punjab"
                                value="<?php echo isset($properties[0]->state) ? $properties[0]->state : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <input name="zip_code" class="form-control" placeholder="160055"
                                value="<?php echo isset($properties[0]->zip_code) ? $properties[0]->zip_code : ''; ?>">
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
            $('#com-factory-fields, #com-hospital-fields, #com-office-fields, #com-retail-fields, #com-plot-fields, #com-storage-fields').hide();
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
       const category = "<?= isset($properties[0]->category) ? $properties[0]->category : '' ?>";

        if (category === 'Residential') {
            showResidentialSubFields();
        } else if (category === 'Commercial') {
            toggleCommercialSubFields(jQuery('#comPropertyType').val());
        }

        // ========== Event Bindings ==========
        jQuery('#categorySelector').change(toggleCategoryFields);
        jQuery('#resPropertyType').change(function () {
            const sections = [
                '#studio-options',
                '#other-options',
                '#bhk-options',
                '#kothi-options',
                '#plot-options',
                '#farmhouse-options',
                '#floor-options'
            ];

            // Hide and clear all
            sections.forEach(section => {
                jQuery(section).hide();
                clearFields(section);
            });

            // Then show the relevant section
            showResidentialSubFields();
        });

        jQuery('#comPropertyType').change(function () {

            const sections = [
                '#com-factory-fields',
                '#com-hospital-fields',
                '#com-office-fields',
                '#com-retail-fields',
                '#com-plot-fields',
                '#com-storage-fields'
            ];

            sections.forEach(section => {
                jQuery(section).hide();
                clearFields(section);
            });

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

            // Handle amenities[] separately: combine into a string with ~-~
            const selectedAmenities = [];
            $("input[name='amenities[]']:checked").each(function () {
                selectedAmenities.push($(this).val());
            });
            formData.set('amenities', selectedAmenities.join("~-~"));

            // Merge value + unit for selected fields
            const unitFields = {
                "floor_carpet_area": "floor_carpet_area_unit",
                "com_built_area": "com_built_area_unit",
                "com_land_area": "com_land_area_unit",
                "com_office_carpet_area": "com_office_carpet_area_unit",
                "com_office_area": "com_office_area_unit",
                "com_plot_area": "com_plot_area_unit",
                "plot_area": "plot_area_unit",
                "kothi_covered_area": "kothi_covered_area_unit",
                "kothi_plot_area": "kothi_plot_area_unit",
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

            // Add 'budget' from 'budget_in_words'
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

            // Rename keys before submission
            const renameKeys = {
                "floor_carpet_area": "carpet",
                "com_built_area": "built",
                "com_land_area": "land",
                "com_plot_area": "carpet",
                "com_width_length": "width_length",
                "expected_price": "budget",
                "com_office_area": "built",
                "com_office_carpet_area": "carpet",
                "plot_area": "carpet",
                "farm_plot_area": "land",
                "kothi_plot_area": "land",
                "kothi_covered_area": "built"

            };

            for (const oldKey in renameKeys) {
                if (formData.has(oldKey)) {
                    formData.set(renameKeys[oldKey], formData.get(oldKey));
                    formData.delete(oldKey);
                }
            }


            // ✅ Rebuild FormData to exclude empty values except File objects
            const cleanedFormData = new FormData();
            for (let [key, value] of formData.entries()) {
                if (value instanceof File && value.name !== "") {
                    cleanedFormData.append(key, value); // Keep files with names
                } else if (typeof value === 'string' && value.trim() !== "") {
                    cleanedFormData.append(key, value);
                }
            }




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
                            alert("Property submitted successfully!");
                        } else {
                            alert("Status: " + (res.message || "Unknown error"));
                        }
                    } catch (e) {
                        console.error("Parse error:", e);
                        alert("Unexpected server response.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("AJAX Error: " + error);
                }
            });
        });
    });

</script>

</body>
</html>