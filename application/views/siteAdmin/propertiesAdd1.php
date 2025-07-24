<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property Form</title>
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

        input.form-check-input[type=checkbox]
         {
            border-color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col main mt-3 pt-5">
                <a class="btn back-btn btn-info btn-sm" href="/admin/properties/">Back</a>
                <h1 class="d-sm-block heading">Add Property Form</h1>
                <div class="clearfix"></div>

                <form class="form" enctype="multipart/form-data" id="propertyForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Property Name</label>
                                <input name="name" class="form-control" placeholder="Property Name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Address*</label>
                                <input name="address" class="form-control" placeholder="Property Address" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Property Description</label>
                                <textarea class="form-control" name="description" placeholder="Property Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-left:6px">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Name</label>
                                <input name="person" class="form-control" placeholder="Person Name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Phone</label>
                                <input name="phone" class="form-control" type="number" placeholder="Person Phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Person Address</label>
                                <input name="person_address" class="form-control" placeholder="Person Address">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Property For*</label>
                                <select name="property_for" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Rent">Rent</option>
                                    <option value="Sale">Sale</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Category*</label>
                                <select id="categorySelector" name="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
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
                                    <option value="Apartment / Flat">Apartment / Flat</option>
                                    <option value="Independent House / Kothi">Independent House / Kothi</option>
                                    <option value="Residential Plot">Residential Plot</option>
                                    <option value="Farm House">Farm House</option>
                                    <option value="Builder Floor">Builder Floor</option>
                                    <option value="Studio Apartment">Studio Apartment</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- BHK Options -->
                        <div class="row" style="display:none" id="bhk-options">
                            <div class="form-group col-md-3">
                                <label>Select BHK Type</label>
                                <select id="bhk" name="bhk" class="form-control">
                                    <option value="">Select Serviced Apartment Type</option>
                                    <option value="1RK/Studio">1RK/Studio</option>
                                    <option value="1BHK">1BHK</option>
                                    <option value="2BHK">2BHK</option>
                                    <option value="2+1BHK">2+1BHK</option>
                                    <option value="3BHK">3BHK</option>
                                    <option value="3+1BHK">3+1BHK</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                              <label for="construction_status">Construction Status</label>
                              <select id="bhk_construction_status" name="construction_status" class="form-control">
                                <option value="">Select Construction Status</option>
                                <option value="Ready To Move">Ready To Move</option>
                                <option value="Re-Sale">Re-Sale</option>
                                <option value="Under Construction">Under Construction</option>
                              </select>
                            </div>

                            <div class="form-group col-md-3" id="bhk_property_age" style="display: none;">
                              <label for="property_age">Property Age</label>
                              <select id="bhk1_property_age" name="property_age" class="form-control">
                                <option value="">Select Property Age</option>
                                <option value="0-1 year">0-1 year</option>
                                <option value="1-5 years">1-5 years</option>
                                <option value="5-10 years">5-10 years</option>
                                <option value="10+ years">10+ years</option>
                              </select>
                            </div>

                             <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="bhk_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="bhk_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Built Area</label>
                                <div class="input-group">
                                    <input name="bhk_built_area" class="form-control" placeholder="Built Area">
                                    <select name="bhk_built_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Land Area</label>
                                <div class="input-group">
                                    <input name="bhk_land_area" class="form-control" placeholder="Land Area">
                                    <select name="bhk_land_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Number of Floors</label>
                                <input name="total_floors" class="form-control" placeholder="Number of Floors">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Floor No</label>
                                <input name="floor_no" class="form-control" placeholder="Floor Number">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Facing</label>
                                <input name="facing" class="form-control" placeholder="Facing">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="bedrooms">Bedroom Number</label>
                              <select id="bedrooms" name="bedrooms" class="form-control">
                                <option value="">Bedroom Number</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>
                            </div>

                            <div class="form-group col-md-3">
                              <label for="bathrooms">Bathroom Number</label>
                              <select id="bathrooms" name="bathrooms" class="form-control">
                                <option value="">Bathroom Number</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                              </select>
                            </div>
                        </div>

                        <!-- Kothi Options -->
                        <div id="kothi-options" class="row" style="display:none;">

                            <div class="col-md-3 form-group">
                                <label>Plot Area</label>
                                <div class="input-group">
                                    <input type="text" name="kothi_plot_area" class="form-control" placeholder="Plot Area">
                                    <select id="area_unit" name="kothi_plot_area_unit" class="form-select">
                                        <option value="sq.yard">sq.yard</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Covered Area</label>
                                <div class="input-group">
                                    <input type="text" name="kothi_covered_area" class="form-control" placeholder="Covered Area">
                                    <select id="covered_area_unit" name="kothi_covered_area_unit" class="form-select">
                                        <option value="sq.yard">sq.yard</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-3 form-group">
                                <label>Construction Status</label>
                                <select id="kothi_construction_status" name="construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="Re-Sale">For Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                </select>
                            </div>
                            <div id="kothi_property_age" class="col-md-3 form-group" style="display:none;">
                                <label>Property Age</label>
                                <select name="property_age" class="form-control">
                                    <option value="">Select Age</option>
                                    <option value="0-1 year">0-1 year</option>
                                    <option value="1-5 years">1-5 years</option>
                                    <option value="5-10 years">5-10 years</option>
                                    <option value="10+ years">10+ years</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Gated Community?</label>
                                <label><input type="radio" name="gated_community" value="1"> Yes</label>
                                <label><input type="radio" name="gated_community" value="0"> No</label>
                            </div>
                        </div>

                        <!-- Plot Options -->
                        <div id="plot-options" class="row" style="display:none">
                            <div class="col-md-3 form-group">
                                <label>Plot Area</label>
                                <div class="input-group">
                                    <input name="p_plot_area" class="form-control" placeholder="e.g., 1500">
                                    <select name="p_plot_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Facing</label>
                                <input name="facing" class="form-control" placeholder="Facing">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Width x Length</label>
                                <input name="width_length" class="form-control" placeholder="e.g., 30x40">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Direction</label>
                                <select name="direction" class="form-control">
                                    <option value="">Select Direction</option>
                                    <option value="East">East</option>
                                    <option value="West">West</option>
                                    <option value="North">North</option>
                                    <option value="South">South</option>
                                    <option value="North-East">North-East</option>
                                    <option value="North-West">North-West</option>
                                    <option value="South-East">South-East</option>
                                    <option value="South-West">South-West</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Farmhouse Options -->
                        <div id="farmhouse-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Plot Area</label>
                                <div class="input-group">
                                    <input name="farm_plot_area" class="form-control" placeholder="e.g., 1500">
                                    <select name="farm_plot_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Farm Area (Optional)</label>
                                <div class="input-group">
                                    <input name="farm_area" class="form-control" placeholder="Farm Area">
                                    <select name="farm_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="acres">acres</option>
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
                                    <option value="Unfurnished">Unfurnished</option>
                                    <option value="Semi-Furnished">Semi-Furnished</option>
                                    <option value="Furnished">Furnished</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="farm_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="farm_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>

                             <div class="col-md-3 form-group">
                                <label>Gated Community?</label>
                                <label><input type="radio" name="gated_community" value="1"> Yes</label>
                                <label><input type="radio" name="gated_community" value="0"> No</label>
                            </div>
                        </div>

                        <!-- Floor Options -->
                        <div id="floor-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Floor No</label>
                                <input name="floor_no" class="form-control" placeholder="Floor Number">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="floor_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="floor_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>

                             <div class="col-md-3 form-group">
                                <label>Gated Community?</label>
                                <label><input type="radio" name="gated_community" value="1"> Yes</label>
                                <label><input type="radio" name="gated_community" value="0"> No</label>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Facing</label>
                                <input name="facing" class="form-control" placeholder="Facing">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Direction</label>
                                <select name="direction" class="form-control">
                                    <option value="">Select Direction</option>
                                    <option value="East">East</option>
                                    <option value="West">West</option>
                                    <option value="North">North</option>
                                    <option value="South">South</option>
                                    <option value="North-East">North-East</option>
                                    <option value="North-West">North-West</option>
                                    <option value="South-East">South-East</option>
                                    <option value="South-West">South-West</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Studio Options -->
                        <div id="studio-options" class="row" style="display:none">
                            <div class="col-md-3 form-group">
                                <label>Serviced Apartment Type</label>
                                <select id="bhk" name="bhk" class="form-control">
                                    <option value="">Select Serviced Apartment Type</option>
                                    <option value="1RK/Studio">1RK/Studio</option>
                                    <option value="1BHK">1BHK</option>
                                    <option value="2BHK">2BHK</option>
                                    <option value="2+1BHK">2+1BHK</option>
                                    <option value="3BHK">3BHK</option>
                                    <option value="3+1BHK">3+1BHK</option>
                                    <option value="4BHK">4BHK</option>
                                    <option value="4+1BHK">4+1BHK</option>
                                    <option value="5BHK">5BHK</option>
                                    <option value="5+1BHK">5+1BHK</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Floor No</label>
                                <input name="floor_no" class="form-control" placeholder="Floor Number">
                            </div>


                            <div class="col-md-3 form-group">
                                <label>Direction</label>
                                <select name="direction" class="form-control">
                                    <option value="">Select Direction</option>
                                    <option value="East">East</option>
                                    <option value="West">West</option>
                                    <option value="North">North</option>
                                    <option value="South">South</option>
                                    <option value="North-East">North-East</option>
                                    <option value="North-West">North-West</option>
                                    <option value="South-East">South-East</option>
                                    <option value="South-West">South-West</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                             <div class="form-group col-md-3">
                                <label>Facing</label>
                                <input name="facing" class="form-control" placeholder="Facing">
                            </div>

                             <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="studio_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="studio_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Construction Status</label>
                                <select id="studio_construction_status" name="construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                </select>
                            </div>

                            <div id="studio_property_age" class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="property_age" class="form-control">
                                    <option value="">Select Age</option>
                                    <option value="0-1 year">0-1 year</option>
                                    <option value="1-5 years">1-5 years</option>
                                    <option value="5-10 years">5-10 years</option>
                                    <option value="10+ years">10+ years</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Gated Community?</label>
                                <label><input type="radio" name="gated_community" value="1"> Yes</label>
                                <label><input type="radio" name="gated_community" value="0"> No</label>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Is this a society?</label>
                                <label><input type="radio" name="in_society" value="yes"> Yes</label>
                                <label><input type="radio" name="in_society" value="no"> No</label>
                            </div>


                        </div>

                        <!-- Other Options -->
                        <div id="other-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Describe Property Type</label>
                                <input name="other_property_type" class="form-control" placeholder="Specify Other Property Type">
                            </div>
                        </div>
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

                        <!-- Commercial Other Options -->
                        <div id="com-other-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Describe Property Type</label>
                                <input name="other_property_type" class="form-control" placeholder="Specify Other Property Type">
                            </div>
                        </div>

                        <!-- Commercial Office Fields -->
                        <div id="com-office-fields" style="display:none;" class="row">
                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="com_office_carpet_area" class="form-control" placeholder="Carpet Area">
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
                                    <input name="com_office_area" class="form-control" placeholder="Area">
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
                                    <option value="Unfurnished">Unfurnished</option>
                                    <option value="Semi-Furnished">Semi-Furnished</option>
                                    <option value="Furnished">Furnished</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Lift Available?</label>
                                <select name="has_lift" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Parking Available?</label>
                                <select name="parking_available" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                        </div>

                        <!-- Commercial Retail Fields -->
                        <div id="com-retail-fields" style="display:none;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Furnishing</label>
                                        <select name="furnishing_status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Unfurnished">Unfurnished</option>
                                            <option value="Semi-Furnished">Semi-Furnished</option>
                                            <option value="Furnished">Furnished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Area in sq.ft</label>
                                        <input type="text" name="retail_area_in_sqft" class="form-control" placeholder="Area in sq.ft">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Floor No</label>
                                        <input type="text" name="floor_no" class="form-control" placeholder="Floor Number">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Is there a lift?</label>
                                        <select name="has_lift" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Parking Available?</label>
                                        <select name="parking_available" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Commercial Plot Fields -->
                        <div id="com-plot-fields" class="row" style="display:none;">
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
                            <div class="form-group col-md-6">
                                <label for="com_width_length">Width x Length</label>
                                <input type="text" id="com_width_length" name="width_length" class="form-control" placeholder="e.g., 30x40">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="com_road_width">Road Width</label>
                                <select id="com_road_width" name="road_width" class="form-control">
                                    <option value="">Select</option>
                                    <option value="20ft">20ft</option>
                                    <option value="30ft">30ft</option>
                                    <option value="40ft">40ft</option>
                                    <option value="50ft+">50ft+</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="com_use_type">Use Type</label>
                                <select id="com_use_type" name="commercial_useType" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Industrial">Industrial</option>
                                    <option value="ShowRoom">ShowRoom</option>
                                    <option value="Shop">Shop</option>
                                    <option value="Office">Office</option>
                                    <option value="Warehouse">Warehouse</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input name="com_plot_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="com_plot_carpet_area_unit" class="form-control">
                                        <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Commercial Storage Fields -->
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
                                        <input type="text" name="com_land_area" class="form-control" placeholder="Land Area">
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
                                    <input type="text" name="shutters_count" class="form-control" placeholder="Number of Shutters">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="roofHeight">Height of Roof</label>
                                    <input type="text" name="roof_height" class="form-control" placeholder="Height (ft)">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="loading_bay">Loading/Unloading Bay</label><br>
                                    <label><input type="radio" name="loading_bay" value="1"> Yes</label>
                                    <label><input type="radio" name="loading_bay" value="0"> No</label>
                                </div>

                            </div>
                        </div>

                        <!-- Commercial Factory Fields -->
                        <div id="com-factory-fields" style="display:none;" class="row">
                            <div class="form-group col-md-6">
                                    <label for="builtArea">Built Area</label>
                                    <div class="input-group">
                                        <input type="text" name="factory_built_area" class="form-control" placeholder="Built Area">
                                        <select name="factory_built_area_unit" class="form-control">
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
                                        <input type="text" name="factory_land_area" class="form-control" placeholder="Land Area">
                                        <select name="factory_land_area_unit" class="form-control">
                                            <option value="">Select</option>
                                            <option value="sq.ft">sq.ft</option>
                                            <option value="marla">marla</option>
                                            <option value="kanal">kanal</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="form-group col-md-6">
                                    <label for="shutters">No. of Shutters</label>
                                    <input type="text" name="shutters_count" class="form-control" placeholder="Number of Shutters">
                                </div>
                            <div class="form-group col-md-6">
                                <label for="roofHeight">Height of Roof</label>
                                <input type="text" name="roof_height" class="form-control" placeholder="Height (ft)">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="loading_bay">Loading/Unloading Bay</label><br>
                                <label><input type="radio" name="loading_bay" value="1"> Yes</label>
                                <label><input type="radio" name="loading_bay" value="0"> No</label>
                            </div>
                        </div>

                        <!-- Commercial Hospital Fields -->
                        <div id="com-hospital-fields" style="display:none;" class="row">
                            <div class="col-md-3 form-group">
                                <label for="hospital_type">Hospital Type</label>
                                <select id="hospital_type" name="hospital_type" class="form-control">
                                    <option value="">Select Hospital Type</option>
                                    <option value="Multispecialty">Multispecialty</option>
                                    <option value="Clinic">Clinic</option>
                                    <option value="Diagnostic Centre">Diagnostic Centre</option>
                                    <option value="Dental">Dental</option>
                                    <option value="Orthopedic">Orthopedic</option>
                                    <option value="Maternity">Maternity</option>
                                    <option value="Eye Hospital">Eye Hospital</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="additional_value">Total Beds</label>
                                <select id="additional_value" name="additional_value" class="form-control">
                                    <option value="">Enter total beds</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100+">100+</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="floor_available">Available Floor</label>
                                <select id="floor_available" name="floor_available" class="form-control">
                                    <option value="">Select Available Floor</option>
                                    <option value="Ground">Ground</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="Full Building">Full Building</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="furnishing_status">Furnishing Type</label>
                                <select name="furnishing_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Unfurnished">Unfurnished</option>
                                    <option value="Semi-Furnished">Semi-Furnished</option>
                                    <option value="Furnished">Furnished</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                              <label for="hospital_license" class="form-label">Hospital License Type</label>
                              <select id="hospital_license" name="hospital_license" class="form-select">
                                <option value="">Select Hospital License Type</option>
                                <option value="Registered under Clinical Establishment Act">Registered under Clinical Establishment Act</option>
                                <option value="Private Limited">Private Limited</option>
                                <option value="Proprietorship">Proprietorship</option>
                                <option value="Other">Other</option>
                              </select>
                            </div>

                           <div class="col-md-3 form-group">
                              <label for="possession_status" class="form-label">Possession Status</label>
                              <select id="possession_status" name="possession_status" class="form-select">
                                <option value="">Select Possession Status</option>
                                <option value="Operational">Operational</option>
                                <option value="Vacant">Vacant</option>
                                <option value="Under Renovation">Under Renovation</option>
                                <option value="Under Construction">Under Construction</option>
                              </select>
                            </div>


                            <div class="col-md-3 form-group">
                              <label class="form-label d-block">Medical Facilities Available</label>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="ICU Room" id="icuRoom">
                                    <label class="form-check-label" for="icuRoom">ICU Room</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Operation Theatre" id="operationTheatre">
                                    <label class="form-check-label" for="operationTheatre">Operation Theatre</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Emergency Room" id="emergencyRoom">
                                    <label class="form-check-label" for="emergencyRoom">Emergency Room</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="OPD Rooms" id="opdRooms">
                                    <label class="form-check-label" for="opdRooms">OPD Rooms</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Ambulance Parking" id="ambulanceParking">
                                    <label class="form-check-label" for="ambulanceParking">Ambulance Parking</label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Pharmacy Setup" id="pharmacySetup">
                                    <label class="form-check-label" for="pharmacySetup">Pharmacy Setup</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Doctor's Cabins" id="doctorsCabins">
                                    <label class="form-check-label" for="doctorsCabins">Doctor's Cabins</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Pathology Lab" id="pathologyLab">
                                    <label class="form-check-label" for="pathologyLab">Pathology Lab</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="medical_facilities[]" value="Radiology Room" id="radiologyRoom">
                                    <label class="form-check-label" for="radiologyRoom">Radiology Room</label>
                                  </div>
                                </div>
                              </div>
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

                    <div id="extra-fields" style="display:none;">
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City*</label>
                                    <input name="city" class="form-control" placeholder="Mohali">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture 1</label>
                                    <input name="image_one" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture 2</label>
                                    <input name="image_two" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture 3</label>
                                    <input name="image_three" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture 4</label>
                                    <input name="image_four" class="form-control" type="file">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="dynamic_field" class="row">
                        <label id="label" style="display:none">Additional Details</label>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <input name="save" class="btn btn-primary property-submit-btn" value="Add Property" type="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

            // Show/hide property age based on construction status
            jQuery('#bhk_construction_status').on('change', function () {
                const selectedValue = jQuery(this).val();
                const ageGroup = jQuery('#bhk_property_age');

                if (selectedValue === 'Re-Sale') {
                    ageGroup.show();
                } else {
                    ageGroup.hide();
                }
            });


            // Show/hide property age based on construction status
            jQuery('#kothi_construction_status').on('change', function () {
                const selectedValue = jQuery(this).val();
                const ageGroup = jQuery('#kothi_property_age');

                if (selectedValue === 'Re-Sale') {
                    ageGroup.show();
                } else {
                    ageGroup.hide();
                }
            });


            // Toggle Residential/Commercial Fields
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

            // Show Residential Sub-Type Fields
            function showResidentialSubFields() {
                const type = jQuery('#resPropertyType').val();
                jQuery('#studio-options, #other-options, #bhk-options, #kothi-options, #plot-options, #farmhouse-options, #floor-options').hide();

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
                } else if (type === 'Studio Apartment') {
                    jQuery('#studio-options').show();
                } else if (type === 'Other') {
                    jQuery('#other-options').show();
                }
            }

            // Show Commercial Sub-Type Fields
            function toggleCommercialSubFields(type) {
                $('#com-factory-fields, #com-other-options, #com-hospital-fields, #com-office-fields, #com-retail-fields, #com-plot-fields, #com-storage-fields').hide();
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
                    case "Other":
                        $("#com-other-options").show();
                        break;
                }
            }

            // Toggle Extra Fields
            jQuery('#toggleExtraFields').change(function () {
                if (jQuery(this).is(':checked')) {
                    jQuery('#extra-fields').slideDown();
                } else {
                    jQuery('#extra-fields').slideUp();
                }
            });

            // Add Custom Fields Dynamically
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

            // Event Bindings
            jQuery('#categorySelector').change(toggleCategoryFields);
            jQuery('#resPropertyType').change(function () {
                const sections = [
                    '#studio-options',
                    '#other-options',
                    '#bhk-options',
                    '#kothi-options',
                    '#plot-options',
                    '#farmhouse-options',
                    '#floor-options',
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

                showResidentialSubFields();
            });

            jQuery('#comPropertyType').change(function () {
                const sections = [
                    '#studio-options',
                    '#other-options',
                    '#bhk-options',
                    '#kothi-options',
                    '#plot-options',
                    '#farmhouse-options',
                    '#floor-options',
                    '#com-factory-fields',
                    '#com-hospital-fields',
                    '#com-office-fields',
                    '#com-retail-fields',
                    '#com-plot-fields',
                    '#com-storage-fields',
                    '#com-other-options'
                ];

                sections.forEach(section => {
                    jQuery(section).hide();
                    clearFields(section);
                });

                toggleCommercialSubFields(jQuery(this).val());
            });
        });

        $(document).ready(function () {
            $('#propertyForm').on('submit', function (e) {
                e.preventDefault();

                const form = $('#propertyForm')[0];
                const formData = new FormData(form);

                // Handle amenities[]: combine into a string with ~-~
                const selectedAmenities = [];
                $("input[name='amenities[]']:checked").each(function () {
                    selectedAmenities.push($(this).val());
                });
                formData.set('amenities', selectedAmenities.join("~-~"));

                // Merge value + unit for selected fields
                const unitFields = {
                    "floor_carpet_area": "floor_carpet_area_unit",
                    "studio_carpet_area": "studio_carpet_area_unit",
                    "com_plot_carpet_area": "com_plot_carpet_area_unit",
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
                    "kothi_covered_area": "kothi_covered_area_unit",
                    "kothi_plot_area": "kothi_plot_area_unit",
                    "farm_plot_area": "farm_plot_area_unit",
                    "farm_carpet_area": "farm_carpet_area_unit",
                    "farm_area": "farm_area_unit",
                    "budget_in_words": "price_unit",
                    "carpet": "carpet_area_unit",
                    "factory_land_area": "factory_land_area_unit",
                    "factory_built_area": "factory_built_area_unit"
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
                    "studio_carpet_area": "carpet",
                    "com_plot_carpet_area": "carpet",
                    "com_width_length": "width_length",
                    "expected_price": "budget",
                    "plot_area": "carpet",
                    "p_plot_area": "land",
                    "farm_plot_area": "land",
                    "kothi_plot_area": "land",
                    "kothi_covered_area": "built",
                    "farm_area": "built",
                    "farm_carpet_area": "carpet",
                    "com_office_carpet_area": "carpet",
                    "com_office_area": "built",
                    "retail_area_in_sqft": "carpet",
                    "com_plot_area": "land",
                    "com_land_area": "land",
                    "com_built_area": "built",
                    "bhk_land_area": "land",
                    "bhk_built_area": "built",
                    "bhk_carpet_area": "carpet",
                    "factory_built_area": "built",
                    "factory_land_area": "land"
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
                          //  console.log(`Renamed ${oldKey} to ${renameKeys[oldKey]}`);
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

                $.ajax({
                    url: '/api/Properties/addAdminProperty/',
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
                                alert("Property added successfully!");
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
</body>
</html>