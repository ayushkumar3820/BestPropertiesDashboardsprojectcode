<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <div class="col main pt-5 mt-3">
        <a href="<?php echo base_url('admin/properties/');?>" style="float: right;margin: 14px 2px;" class="btn btn-sm btn-info back-btn">Back</a>

        <!--<h1 class="d-sm-block heading"><?php echo $title; ?></h1>-->
        <h5 class="d-sm-block heading"><?php echo "Test Template"; ?></h5>
        <?php
	  $message = $this->session->flashdata('message');
	  if($message != ''){
	      echo '<div class="alert alert-success">'.$message.'</div>';
		  // Clear flash data after displaying it once
		$this->session->set_flashdata('message', '');
	  }
	  echo validation_errors(); ?>

            <div class="clearfix"></div>

            <form class="form" method="post"  enctype="multipart/form-data" id="propertyForm" style="margin-left: 24px;">

                <div class="row" id="">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Property Name*</label>
                            <input type="text" name="rName" value="<?php echo $this->input->post('rName')?>"  class="form-control" placeholder="Property Name">
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
                            <textarea name="note" value="<?php echo $this->input->post('note')?>" class="form-control" placeholder="Property Description"></textarea>
                        </div>
                    </div>



                    <!-- OWNER INFO STARTS -->

                    <div class="row" style="margin-left: 6px;">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Name</label>
                                <input type="text" name="pName" value="<?php echo $this->input->post('pName')?>" class="form-control" placeholder="Person Name">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Person Phone</label>
                                <input type="number" name="pPhone" value="<?php echo $this->input->post('pPhone')?>" class="form-control" placeholder="Person Phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Person Address</label>
                                <input type="text" name="pAddress" value="<?php echo $this->input->post('pAddress')?>" class="form-control" placeholder="Person Address">
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
                                <select name="res_property_type" id="resPropertyType" class="form-control">
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
                            <select id="bhk" name="service_apartment_type" class="form-control">
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
                            <select name="studio_property_age" class="form-control">
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
                                <select name="bhk_type" class="form-control">
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

                            <!-- Completion Time -->
                            <div class="col-md-3 form-group">
                                <label>Completion Time</label>
                                <input type="text" name="completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
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
                                <label><input type="radio" name="plot_gated" value="yes"> Yes</label>
                                <label><input type="radio" name="plot_gated" value="no"> No</label>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Floor No</label>
                                <input type="text" name="com_floor_no" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Furnishing</label>
                                <select name="com_furnishing" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Bare shell">Bare shell</option>
                                    <option value="Semi-furnished">Semi-furnished</option>
                                    <option value="Furnished">Furnished</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Lift Available?</label>
                                <select name="com_lift" class="form-control">
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
                                <input type="text" name="kothi_floors" class="form-control">
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
                                <select name="kothi_construction_status" class="form-control" >
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                </select>
                            </div>

                            <!-- Completion Time -->
                            <div class="col-md-3 form-group">
                                <label>Completion Time</label>
                                <input type="text" name="kothi_completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
                            </div>

                            <!-- Property Age -->
                            <div class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="kothi_property_age" class="form-control">
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
                                <label><input type="radio" name="plot_gated" value="yes"> Yes</label>
                                <label><input type="radio" name="plot_gated" value="no"> No</label>
                            </div>
                        </div>

                        <div id=plot-options class=row style=display:none>
                            <div class="col-md-3 form-group">
                                <label>Plot Area</label>
                                <div class="input-group">
                                    <input name="plot_area_value" class="form-control" placeholder="e.g., 1500">
                                    <select name="plot_area_unit" class="form-control">
                                        <option value="sq.ft">sq.ft</option>
                                        <option value="marla">marla</option>
                                        <option value="kanal">kanal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Width x Length</label>
                                <input name="plot_width_length" class="form-control" placeholder="e.g., 30x40">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Direction</label>
                                <select name="plot_direction" class="form-control">
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

                            <div class="col-md-3 form-group">
                                <label>Legal Clearance</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="DTCP"> DTCP</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="RERA"> RERA</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="Patta"> Patta</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="Encumbrance"> Encumbrance</label>
                            </div>
                        </div>

                        <div id="farmhouse-options" class="row" style="display:none;">
                                      <!-- Plot Area -->
                                      <div class="col-md-3 form-group">
                                        <label>Plot Area</label>
                                        <div class="input-group">
                                          <input name="farm_plot_area" class="form-control" placeholder="Plot Area">
                                          <select name="farm_plot_area_unit" class="form-control">
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
                                    <input type="text" name="floor_carpet_area" class="form-control" placeholder="Carpet Area">
                                    <select name="floor_carpet_area_unit" class="form-control">
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
                                <select name="com_property_type" id="comPropertyType" class="form-control">
                                    <option value="">Select Property Type</option>
                                    <option value="Office Space">Office Space</option>
                                    <option value="Retail">Retail</option>
                                    <option value="Booth">Booth</option>
                                    <option value="Showroom">Showroom</option>
                                    <option value="Plot">Plot</option>
                                    <option value="Storage">Storage/Warehouse</option>
                                    <option value="Industry/Factory">Industry/Factory</option>
                                    <option value="Building">Building</option>
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
                                  <option value="sq.ft">sq.ft</option>
                                  <option value="marla">marla</option>
                                  <option value="kanal">kanal</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="shutters">No. of Shutters</label>
                              <input type="text" name="com_shutters" class="form-control" placeholder="Number of Shutters">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="roofHeight">Height of Roof</label>
                              <input type="text" name="com_roof_height" class="form-control" placeholder="Height (ft)">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="loadingBay">Loading/Unloading Bay</label><br>
                              <label><input type="radio" name="com_loading_bay" value="yes"> Yes</label>
                              <label><input type="radio" name="com_loading_bay" value="no"> No</label>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="constructionStatus">Construction Status</label>
                              <select name="com_construction_status" class="form-control">
                                <option value="">Select</option>
                                <option value="Ready To Move">Ready To Move</option>
                                <option value="For Sale">For Sale</option>
                                <option value="Under Construction">Under Construction</option>
                              </select>
                            </div>

                            <div class="form-group col-md-6" id="com-storage-completion-time-group">
                              <label for="completionTime">Completion Time</label>
                              <input type="text" name="com_completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="propertyAge">Property Age</label>
                              <select name="com_property_age" class="form-control">
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
                                    <option value="sq.ft">sq.ft</option>
                                    <option value="marla">marla</option>
                                    <option value="kanal">kanal</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 form-group">
                                <label>Furnishing</label>
                                <select name="com_office_furnishing" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Bare Shell">Bare Shell</option>
                                  <option value="Semi-Furnished">Semi-Furnished</option>
                                  <option value="Furnished">Furnished</option>
                                </select>
                              </div>

                              <div class="col-md-3 form-group">
                                <label>Lift Available?</label>
                                <select name="com_office_lift" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                </select>
                              </div>

                              <div class="col-md-3 form-group">
                                <label>Parking Available?</label>
                                <select name="com_office_parking" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No</option>
                                </select>
                              </div>

                              <div class="col-md-3 form-group">
                                  <label>Construction Status</label>
                                  <select name="com_office_construction_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="For Sale">For Sale</option>
                                    <option value="Under Construction">Under Construction</option>
                                  </select>
                            </div>

                            <div class="col-md-3 form-group" id="com-office-completion-time-group">
                                  <label>Completion Time</label>
                                  <input name="com_office_completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
                            </div>

                              <div class="col-md-3 form-group">
                                <label>Property Age</label>
                                <select name="com_office_property_age" class="form-control">
                                  <option value="">Select Age</option>
                                  <option value="0-1 year">0-1 year</option>
                                  <option value="1-5 years">1-5 years</option>
                                  <option value="5-10 years">5-10 years</option>
                                  <option value="10+ years">10+ years</option>
                                </select>
                              </div>
                        </div>

                        <div id="com-retail-fields" style="display:none;">
                          <div class="row">
                            <!-- Step 1 -->
                            <!-- Furnishing -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Furnishing</label>
                                <select name="retail_furnishing" class="form-control">
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
                                <input type="text" name="retail_floor_no" class="form-control" placeholder="Floor Number">
                              </div>
                            </div>

                            <!-- Lift -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Is there a lift?</label><br>
                                <label><input type="radio" name="retail_has_lift" value="yes"> Yes</label>
                                <label><input type="radio" name="retail_has_lift" value="no"> No</label>
                              </div>
                            </div>

                            <!-- Parking -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Parking Available?</label><br>
                                <label><input type="radio" name="retail_parking_available" value="yes"> Yes</label>
                                <label><input type="radio" name="retail_parking_available" value="no"> No</label>
                              </div>
                            </div>

                            <!-- Property Age -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Property Age</label>
                                <select name="retail_property_age" class="form-control">
                                  <option value="">Select</option>
                                  <option value="0-1 year">0-1 year</option>
                                  <option value="1-5 years">1-5 years</option>
                                  <option value="5-10 years">5-10 years</option>
                                  <option value="10+ years">10+ years</option>
                                </select>
                              </div>
                            </div>
                          </div>

                            <!-- Step 2 -->
                            <!-- Construction Status -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Construction Status</label>
                                <select name="retail_construction_status" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Ready To Move">Ready To Move</option>
                                  <option value="For Sale">For Sale</option>
                                  <option value="Under Construction">Under Construction</option>
                                </select>
                              </div>
                            </div>


                            <!-- Completion Time (conditionally shown via JS) -->
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Completion Time</label>
                                <input type="text" name="retail_completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
                              </div>
                            </div>


                        </div>

                        <!-- Sub-Type: Commercial/Industrial Plot -->
                      <div id="com-plot-fields" style="display:none;" class="row">
                            <div class="form-group col-md-6">
                              <label for="plotArea">Plot Area</label>
                              <div class="input-group">
                                <input type="text" name="com_plot_area" class="form-control" placeholder="Plot Area">
                                <select name="com_plot_area_unit" class="form-control">
                                  <option value="sq.ft">sq.ft</option>
                                  <option value="marla">marla</option>
                                  <option value="kanal">kanal</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="widthLength">Width x Length</label>
                              <input type="text" name="com_width_length" class="form-control" placeholder="e.g., 30x40">
                            </div>

                            <div class="form-group col-md-6">
                              <label for="roadWidth">Road Width</label>
                              <select name="com_road_width" class="form-control">
                                <option value="">Select</option>
                                <option value="20ft">20ft</option>
                                <option value="30ft">30ft</option>
                                <option value="40ft">40ft</option>
                                <option value="50ft+">50ft+</option>
                              </select>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="useType">Use Type</label>
                              <select name="com_use_type" class="form-control" >
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
                                <label>Legal Clearance</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="DTCP"> DTCP</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="RERA"> RERA</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="Patta"> Patta</label><br>
                                <label><input type="checkbox" name="plot_legal_clearance[]" value="Encumbrance"> Encumbrance</label>
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
                                <select name="factory_property_age" class="form-control">
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
                                <select name="factory_construction_status" class="form-control">
                                  <option value="">Select</option>
                                  <option value="Ready To Move">Ready To Move</option>
                                  <option value="For Sale">For Sale</option>
                                  <option value="Under Construction">Under Construction</option>
                                </select>
                              </div>
                            </div>


                            <!-- Completion Time (conditionally shown via JS) -->
                            <div class="col-md-4" id="com-fac-completion-time-group">
                              <div class="form-group">
                                <label>Completion Time</label>
                                <input type="text" name="factory_completion_time" class="form-control" placeholder="e.g., 6 months, 1 year">
                              </div>
                            </div>

                        </div>

                    </div>

                    <!-- 💰 Price -->
                  <div class="row" style="width: 100%; margin-left: 16px;">
                    <div class="col-md-6 form-group">
                        <label>Demanded Price</label>
                        <div class="input-group">
                            <input type="text" name="expected_price" class="form-control" placeholder="Enter price">
                            <select name="price_unit" class="form-control" style="max-width: 120px;">
                                <option value="lakhs">Lakhs</option>
                                <option value="crore">Crore</option>
                            </select>
                        </div>
                    </div>
                </div>

                     <!--     <div class="col-md-3 form-group">
                            <label>Negotiable?</label>
                            <select name="negotiable" class="form-control">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>-->



                    <div class="col-sm-6"></div>
                </div>

                <!-- Add this checkbox above the city/state/zip etc. fields -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="toggleExtraFields"> Show Extra Fields</label>
                </div>

                <div id="extra-fields" style="display: none;">
                    <!-- Project/Builder -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Project/Builder</label>
                            <input type="text" name="property_builder" value="<?php echo $this->input->post('property_builder')?>" class="form-control" placeholder="Property Name">
                        </div>
                    </div>


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
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image2" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image3" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="image4" class="form-control">
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
            var val = type;  // use passed parameter directly
            $('#com-factory-fields, #com-office-fields, #com-retail-fields, #com-plot-fields, #com-warehouse-fields,#com-storage-fields').hide();

            if (val === "Office Space") {
                $("#com-office-fields").show();
            } else if (val === "Retail") {
                $("#com-retail-fields").show();
            } else if (val === "Plot") {
                $("#com-plot-fields").show();
            } else if (val === "Warehouse" || val === "Factory") {
                $('#com-warehouse-fields').show();
            }else if (type === "Storage") {
                $("#com-storage-fields").show();
              }else if (type === "Industry/Factory") {
                $("#com-factory-fields").show();
              }
        }

        // ========== Under Construction Toggle for All Sections ==========
        function toggleCompletionTime(selectorStatus, selectorTime) {
            jQuery(selectorStatus).change(function () {
                if (jQuery(this).val() === 'Under Construction') {
                    jQuery(selectorTime).closest('.form-group').show();
                } else {
                    jQuery(selectorTime).closest('.form-group').hide();
                }
            }).trigger('change'); // trigger initially for edit mode
        }

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

        toggleCompletionTime(
          'select[name="retail_construction_status"]',
          'input[name="retail_completion_time"]'
        );

        // ========== Triggered on Load ==========
        toggleCategoryFields();
        showResidentialSubFields();
        toggleCompletionTime('select[name="floor_construction_status"]', 'input[name="floor_completion_time"]');
        toggleCompletionTime('select[name="kothi_construction_status"]', 'input[name="kothi_completion_time"]');
        toggleCompletionTime('select[name="construction_status"]', 'input[name="completion_time"]');

        // ========== Event Bindings ==========
        jQuery('#categorySelector').change(toggleCategoryFields);
        jQuery('#resPropertyType').change(showResidentialSubFields);
        jQuery('#comPropertyType').change(function () {
            toggleCommercialSubFields(jQuery(this).val());
        });

        // Handle toggle for Storage Completion Time
        function toggleStorageCompletionTime() {
          const status = $('select[name="com_construction_status"]').val();
          if (status === 'Under Construction') {
            $('#com-storage-completion-time-group').show();
          } else {
            $('#com-storage-completion-time-group').hide();
          }
        }

        // Trigger initially and bind change event
        $('select[name="com_construction_status"]').change(toggleStorageCompletionTime);
        toggleStorageCompletionTime();

        function toggleOfficeCompletionTime() {
          const status = $('select[name="com_office_construction_status"]').val();
          if (status === 'Under Construction') {
            $('#com-office-completion-time-group').show();
          } else {
            $('#com-office-completion-time-group').hide();
          }
        }

        // Bind event and run once on page load
        $('select[name="com_office_construction_status"]').change(toggleOfficeCompletionTime);
        toggleOfficeCompletionTime();


        function toggleFactoryCompletionTime() {
          const status = $('select[name="factory_construction_status"]').val();
          if (status === 'Under Construction') {
            $('#com-fac-completion-time-group').show();
          } else {
            $('#com-fac-completion-time-group').hide();
          }
        }

        // Bind event and run once on page load
        $('select[name="factory_construction_status"]').change(toggleFactoryCompletionTime);
        toggleFactoryCompletionTime();
    });
</script>

<script>
$(document).ready(function () {
    $('#propertyForm').on('submit', function (e) {
        e.preventDefault(); // prevent default form submission

        var formData = new FormData(this);

        $.ajax({
            url: '<?php echo base_url("/api/Properties/addProperty/"); ?>', // change this to your actual URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // optional: disable button, show loader, etc.
            },
            success: function (response) {
                try {
                    var res = JSON.parse(response);
                    if (res.status === "success") {
                        alert("Property submitted successfully!");
                        // optional: redirect or reset form
                    } else {
                        alert("Error: " + res.message);
                    }
                } catch (e) {
                    alert("Unexpected response from server.");
                }
            },
            error: function (xhr, status, error) {
                alert("AJAX Error: " + error);
            }
        });
    });
});
</script>