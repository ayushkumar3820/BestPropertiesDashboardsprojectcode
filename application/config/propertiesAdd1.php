<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <div class="col main pt-5 mt-3">
        <a href="<?php echo base_url('admin/properties/');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>

        <!--<h1 class="d-sm-block heading"><?php echo $title; ?></h1>-->
        <h5 class="d-sm-block heading"><?php echo "Test Template"; ?></h5>


            <div class="clearfix"></div>

            <form class="form" method="post"  enctype="multipart/form-data" id="propertyForm" style="margin-left: 24px;">

                <div class="row" id="">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Property Name*</label>
                            <input type="text" name="name"
                            value="<?php echo $this->input->post('rName')?>"
                            class="form-control" placeholder="Property Name">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Address*</label>
                            <input type="text" name="address" value="<?php echo $this->input->post('address')?>"  class="form-control" placeholder="Property Address">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Property Description</label>
                            <textarea name="description" value="<?php echo $this->input->post('note')?>" class="form-control" placeholder="Property Description"></textarea>
                        </div>
                    </div>



                    <!-- OWNER INFO STARTS -->

                    <div class="row" style="margin-left: 6px;">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Name</label>
                                <input type="text" name="person" value="<?php echo $this->input->post('pName')?>" class="form-control" placeholder="Person Name">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Phone</label>
                                <input type="number" name="phone" value="<?php echo $this->input->post('pPhone')?>" class="form-control" placeholder="Person Phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Person Address</label>
                                <input type="text" name="person_address" value="<?php echo $this->input->post('pAddress')?>" class="form-control" placeholder="Person Address">
                            </div>
                        </div>

                    </div>
                    <!-- OWNER INFO ENDS -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Property For*</label>
                            <select name="property_for" class="form-control" required>
                                <option value="">Select Type</option>
                                <!--<option value="Buy">Buy</option>-->
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


                    <div id="residential-fields" style="display:none; margin-left:16px; width:100%;">
                        <!-- #1. Property Type -->
                        <div class="row">
                            <div class="col-md-3 form-group">
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


                        <div id="studio-options" class="row" style="display:none">
                             <div class="col-md-3 form-group">
                            <label>Serviced Apartment Type</label>
                            <select id="bhk" name="bhk" class="form-control">
                                <option value="">Select Serviced Apartment Type</option>
                                <option value="1RK/Studio">1RK/Studio</option>
                                <option value="1BHK">1BHK</option>
                                <option value="2BHK">2BHK</option>
                                <option value="3BHK">3BHK</option>
                                <option value="Penthouse">Penthouse</option>
                            </select>
                        </div>


                          <div class="col-md-3 form-group">
                            <label>Property Age</label>
                            <select name="property_age" class="form-control">
                              <option value="">Select</option>
                              <option value="0-1 year">0-1 year</option>
                              <option value="1-5 years">1-5 years</option>
                              <option value="5-10 years">5-10 years</option>
                              <option value="10+ years">10+ years</option>
                            </select>
                          </div>

                        </div>



                        <div id="floor-options" class="row" style="display:none;">
                            <!-- Floor Type -->
                            <div class="col-md-3 form-group">
                                <label>Independent/Builder Floor Type</label>
                                <select id="floor_no" name="floor_no" class="form-control">
                                    <option value="">Select Independent/Builder Floor Type</option>
                                    <option value="Ground Floor">Ground Floor</option>
                                    <option value="1st Floor">1st Floor</option>
                                    <option value="2nd Floor">2nd Floor</option>
                                    <option value="3rd Floor">3rd Floor</option>
                                    <option value="Top Floor">Top Floor</option>
                                </select>
                            </div>

                        </div>

                        <!-- #2. Sub-Type Sections -->
                        <div id="bhk-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Select BHK Type</label>
                                <select name="bhk" class="form-control">
                                    <option value="">Select BHK</option>
                                    <option value="1RK / Studio">1RK / Studio</option>
                                    <option value="1 BHK">1 BHK</option>
                                    <option value="2 BHK">2 BHK</option>
                                    <option value="3 BHK">3 BHK</option>
                                    <option value="4 BHK">4 BHK</option>
                                    <option value="5 BHK +">5 BHK +</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Number of Floors</label>
                                <input type="text" name="floors" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Facing</label>
                                <input type="text" name="facing" class="form-control">
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



                            <!-- Property Floor Number -->
                            <div class="col-md-3 form-group">
                                <label>Property Floor Number</label>
                                <input type="text" name="property_floor" class="form-control" placeholder="Floor Number">
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

                            <div class="col-md-3 form-group">
                                <label>Floor No</label>
                                <input type="text" name="floor_no" class="form-control" value="">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Furnishing</label>
                                <select name="furnishing_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Semi-furnished">Semi-furnished</option>
                                    <option value="Furnished">Furnished</option>
                                    <option value="Unfurnished">Unfurnished</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Lift Available?</label>
                                <select name="has_lift" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div id="other-options" class="row" style="display:none;">
                            <div class="col-md-3 form-group">
                                <label>Describe Property Type</label>
                                <input type="text" name="property_type" class="form-control">
                            </div>
                        </div>
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

                        <div id=plot-options class=row style=display:none>
                            <div class="col-md-3 form-group">
                                <label>Plot Area</label>
                                <div class="input-group">
                                    <input name="plot_area" class="form-control" placeholder="e.g., 1500">
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

                        <div id="farmhouse-options" class="row" style="display:none;">
                                      <!-- Plot Area -->
                                      <div class="col-md-3 form-group">
                                        <label>Plot Area</label>
                                        <div class="input-group">
                                          <input name="farm_plot_area" class="form-control" placeholder="Plot Area">
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

                        </div>


                        <!-- #3. Common Residential Fields -->

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>Carpet Area</label>
                                <div class="input-group">
                                    <input type="text" name="carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="carpet_area_unit" class="form-control">
                                          <option value="">Select</option>
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="commercial-fields" style="display:none; margin-left:16px;  width:100%;">
                        <!-- #1. Property Type -->
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>Property Type (Commercial)</label>
                                <select name="property_type" id="comPropertyType" class="form-control">
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
                              <label for="loadingBay">Loading/Unloading Bay</label><br>
                              <label><input type="radio" name="loading_bay" value="yes"> Yes</label>
                              <label><input type="radio" name="loading_bay" value="no"> No</label>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="constructionStatus">Construction Status</label>
                              <select name="construction_status" class="form-control">
                                <option value="">Select</option>
                                <option value="Ready To Move">Ready To Move</option>
                                <option value="For Sale">For Sale</option>
                                <option value="Under Construction">Under Construction</option>
                              </select>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="propertyAge">Property Age</label>
                              <select name="property_age" class="form-control">
                                <option value="">Select</option>
                                <option value="0-1 year">0-1 year</option>
                                <option value="1-5 years">1-5 years</option>
                                <option value="5-10 years">5-10 years</option>
                                <option value="10+ years">10+ years</option>
                              </select>
                            </div>
                          </div>
                        </div>


                        <!-- Sub-Type: Office / Retail / Booth -->
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
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                </select>
                              </div>

                              <div class="col-md-3 form-group">
                                <label>Parking Available?</label>
                                <select name="parking_available" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                </select>
                              </div>

                              <div class="col-md-3 form-group">
                                  <label>Construction Status</label>
                                  <select name="construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                  </select>
                            </div>



                        </div>

                       <!-- Retail Fields -->
<div id="com-retail-fields" style="display:none;">
    <div class="row">
        <!-- Furnishing -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Furnishing</label>
                <select name="furnishing_status" class="form-control">
                    <option value="">Select</option>
                    <option value="Bare Shell">Bare Shell</option>
                    <option value="Semi-Furnished">Semi-Furnished</option>
                    <option value="Furnished">Furnished</option>
                </select>
            </div>
        </div>

        <!-- Area in sq.ft -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Area in sq.ft</label>
                <input type="text" name="retail_area_in_sqft" class="form-control" placeholder="Area in sq.ft">
            </div>
        </div>

        <!-- Floor No -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Floor No</label>
                <input type="text" name="floor_no" class="form-control" placeholder="Floor Number">
            </div>
        </div>

        <!-- Lift -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Is there a lift?</label><br>
                <label><input type="radio" name="has_lift" value="yes"> Yes</label>
                <label><input type="radio" name="has_lift" value="no"> No</label>
            </div>
        </div>

        <!-- Parking -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Parking Available?</label><br>
                <label><input type="radio" name="parking_available" value="yes"> Yes</label>
                <label><input type="radio" name="parking_available" value="no"> No</label>
            </div>
        </div>

        <!-- Construction Status -->
        <div class="col-md-4">
            <div class="form-group">
                <label>Construction Status</label>
                <select name="construction_status" class="form-control">
                    <option value="">Select</option>
                    <option value="Ready To Move">Ready To Move</option>
                    <option value="For Sale">For Sale</option>
                    <option value="Under Construction">Under Construction</option>
                </select>
            </div>
        </div>


    </div> <!-- .row -->
</div> <!-- #com-retail-fields -->


                        <!-- Sub-Type: Commercial/Industrial Plot -->
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
                                <select id="furnishing_status" name="furnishing_status" class="form-control">
                                    <option value="">Select Furnishing Type</option>
                                    <option value="Fully Furnished (Operational)">Fully Furnished (Operational)</option>
                                    <option value="Semi-Furnished">Semi-Furnished</option>
                                    <option value="Bare Shell">Bare Shell</option>
                                </select>
                            </div>

                        </div>

                        <!-- Sub-Type: Commercial/Industrial Plot -->
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
                            <input type="text" id="com_width_length" name="width_length" class="form-control" placeholder="e.g., 30x40">
                        </div>

                        <!-- Road Width -->
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

                        <!-- Use Type -->
                        <div class="form-group col-md-6">
                            <label for="com_use_type">Use Type</label>
                            <select id="com_use_type" name="use_type" class="form-control">
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

                    </div>


                        <!-- Sub-Type: Warehouse/Factory -->
                        <div id="com-factory-fields" style="display:none;" class="row">
                            <div class="col-md-3 form-group">
                                <label>Built Area</label>
                                <input type="text" name="built_area" class="form-control">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="property_age" class="form-control">
                                  <option value="">Select</option>
                                  <option value="0-1 year">0-1 year</option>
                                  <option value="1-5 years">1-5 years</option>
                                  <option value="5-10 years">5-10 years</option>
                                  <option value="10+ years">10+ years</option>
                                </select>
                          </div>

                             <!-- Step 2 -->
                            <!-- Construction Status -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Construction Status</label>
                                <select name="construction_status" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Ready To Move">Ready To Move</option>
                                  <option value="For Sale">For Sale</option>
                                  <option value="Under Construction">Under Construction</option>
                                </select>
                              </div>
                            </div>


                        </div>

                    </div>

                    <!-- 💰 Price -->
                  <div class="row" style="width: 100%; margin-left: 16px;">
                    <div class="col-md-6 form-group">
                        <label>Demanded Price</label>
                        <div class="input-group">
                            <input type="text" name="budget_in_words" class="form-control" placeholder="Enter price">
                            <select name="price_unit" class="form-control" style="max-width: 120px;">
                                <option value="lakhs">Lakhs</option>
                                <option value="crore">Crore</option>
                            </select>
                        </div>
                    </div>
                </div>




                    <div class="col-sm-6"></div>
                </div>

                <!-- Add this checkbox above the city/state/zip etc. fields -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="toggleExtraFields"> Show Extra Fields</label>
                </div>

                <div id="extra-fields" style="display: none;">
                    <!-- Project/Builder -->
                   <!-- <div class="col-sm-3">
                        <div class="form-group">
                            <label>Project/Builder</label>
                            <input type="text" name="property_builder" value="<?php echo $this->input->post('property_builder')?>" class="form-control" placeholder="Property Name">
                        </div>
                    </div>-->


                    <!-- Amenities -->
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Amenities*</label>
                            </br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Car parking"> Car parking</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Security services"> Security services</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Water supply"> Water supply</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Elevators"> Elevators</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Power backup"> Power backup</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Gym"> Gym</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Play area"> Play area</label>
                                    </br>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Swimming pool"> Swimming pool</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Restaurants"> Restaurants</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Party hall"> Party hall</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Temple and religious activity place"> Temple and religious activity place</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Cinema hall"> Cinema hall</label>
                                    </br>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="Walking/Jogging track"> Walking/Jogging track</label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <!-- City -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>City*</label>
                                    <input type="text" name="city" value="<?php echo $this->input->post('city')?>"  class="form-control" placeholder="Mohali">
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label>State*</label>
                                        <input type="text" name="state" value="<?php echo $this->input->post('state')?>"  class="form-control" placeholder="Punjab">
                                    </div>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input type="text" name="zip_code" value="<?php echo $this->input->post('zip_code')?>" class="form-control" placeholder="160055">
                                </div>
                            </div>

                    </div>


                      <div class="row">

                            <!-- Pictures -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image_one" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image_two" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image_three" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image_four" class="form-control">
                                </div>
                            </div>

                        </div>

                    <!-- EXTRA FIELDS ENDs HERE-->

                </div>

                <div id="dynamic_field">
                        <label id="label" style="display:none;">Additional Details</label>
                 </div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <input type="submit" value="Submit" name="save" class="property-submit-btn btn btn-primary">
                    </div>
                </div>
            </form>

    </div>
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

<script>
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
            "budget_in_words": "price_unit"
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
                } catch (e) {
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
                console.error("Status Code:", xhr.status);
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