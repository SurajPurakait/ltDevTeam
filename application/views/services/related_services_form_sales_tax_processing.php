<?php if(isset($state)){$state_id = $state->id;} ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" id="related_create_sales_tax_processing" onsubmit="related_create_sales_tax_processing(); return false;">
                       <h3>Price</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Retail Price</label>
                            <div class="col-lg-10">
                                <input disabled placeholder="" class="form-control" type="text" title="Retail Price" value="<?php echo $service['retail_price']?>" id="retail-price">
                                <input type="hidden" name="retail_price" id="retail-price-hidd" value="<?php echo $service['retail_price']?>">
                                <input type="hidden" id="retail-price-initialamt" value="0" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Override Price</label>
                            <div class="col-lg-10">
                                <input placeholder="" numeric_valid="" class="form-control" type="text" id="retail_price_override" name="retail_price_override" title="Retail Price" value="<?php echo isset($override_price['price_charged']) ? $override_price['price_charged'] : ''; ?>">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-lg-2 control-label">Frequency Of Salestax<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping"  name="frequeny_of_salestax" id="frequency_of_salestax" title="Frequency Of salestex" required="">
                                    <?php if(isset($processing_data->frequeny_of_salestax)){ ?>
                                    <option value="m" <?= ($processing_data->frequeny_of_salestax == 'm') ? 'Selected' : '' ?>>Monthly</option>
                                    <option value="q" <?= ($processing_data->frequeny_of_salestax == 'q') ? 'Selected' : '' ?>>Quarterly</option>
                                    <option value="y" <?= ($processing_data->frequeny_of_salestax == 'y') ? 'Selected' : '' ?>>Yearly</option>
                                <?php } else { ?>
                                    <option value="m">Monthly</option>
                                    <option value="q">Quarterly</option>
                                    <option value="y">Yearly</option>
                                <?php } ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div id="frequency_of_salestax_month" <?php if(isset($processing_data->frequeny_of_salestax)) {echo ($processing_data->frequeny_of_salestax == 'm') ? 'style="display:block;"' : 'style="display:none;"';} else{ echo 'style="display:none;"'; } ?>>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Months<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping" id="months" name="frequency_of_salestax_month"  title="Frequency Of salestex" <?= ($processing_data->frequeny_of_salestax == 'm') ? 'required=""' : '' ?>>
                                   <?php if(isset($processing_data->frequeny_of_salestax)) { 
                                $i=0;
                                $months=['Select','January','Febuary','March','April','May','June','July','August','September','October','November','December'];
                                for($i=0;$i<=12;$i++){?>
                                   
                                 <option value="<?php echo $months[$i];?>"<?php if($processing_data->frequency_of_salestax_val==$months[$i]) { echo " selected" ; }?>><?php echo $months[$i];?></option>
                                    <?php  } 
                                     } else {  
                                $i=0;
                                $months=['Select','January','Febuary','March','April','May','June','July','August','September','October','November','December'];
                                for($i=0;$i<=12;$i++){?>
                                   
                                 <option value="<?php echo $months[$i];?>"><?php echo $months[$i];?></option>
                                    <?php  } 
                                    } ?>
                                    
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="year1" name="frequency_of_salestax_years1"  title="Year" <?= ($processing_data->frequeny_of_salestax == 'm') ? 'required=""' : '' ?>>
                                    <?php if(isset($processing_data->frequeny_of_salestax)) { 
                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($processing_data->frequency_of_salestax_years==$year[$i]) { echo " selected" ; }?>><?php echo $year[$i];?></option>
                                   <?php  } 
                                    }else{
                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                   <?php  } 
                                    } ?>
                                    
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div id="frequency_of_salestax_querter" <?php if(isset($processing_data->frequeny_of_salestax)) {echo ($processing_data->frequeny_of_salestax == 'q') ? 'style="display:block;"' : 'style="display:none;"';} else{ echo 'style="display:none;"'; } ?>>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Quarter<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping" id="quarter" name="frequency_of_salestax_quarter"  title="Frequency Of salestex" <?= ($processing_data->frequeny_of_salestax == 'q') ? 'required=""' : '' ?>>
                                     <?php if(isset($processing_data->frequeny_of_salestax)) {

                                            $i=0;
                                            $querter=['Select','Querter 1','Querter 2','Querter 3','Querter 4'];
                                            for($i=0;$i<=4;$i++){?>
                                             <option value="<?php echo $querter[$i];?>" <?php if($processing_data->frequency_of_salestax_val==$querter[$i]) { echo " selected" ; }?>><?php echo $querter[$i];?></option>
                                    <?php  } 
                                      }else{
                                        $i=0;
                                        $querter=['Select','Quarter 1','Quarter 2','Quarter 3','Quarter 4'];
                                        for($i=0;$i<=4;$i++){?>
                                         <option value="<?php echo $querter[$i];?>"><?php echo $querter[$i];?></option>
                                    <?php  }
                                      } ?>
                                    
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" id="year2" name="frequency_of_salestax_years2"  title="Year" <?= ($processing_data->frequeny_of_salestax == 'q') ? 'required=""' : '' ?>>
                                    <?php if(isset($processing_data->frequeny_of_salestax)) { 

                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($processing_data->frequency_of_salestax_years==$year[$i]) { echo " selected" ; }?>><?php echo $year[$i];?></option>
                                   <?php  } 
                                    }else{
                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                   <?php  } 
                                    } ?>
                                   
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div id="frequency_of_salestax_years" <?php if(isset($processing_data->frequeny_of_salestax)) {echo ($processing_data->frequeny_of_salestax == 'y') ? 'style="display:block;"' : 'style="display:none;"';} else{ echo 'style="display:none;"'; } ?>>
                          <div class="form-group">
                            <label class="col-lg-2 control-label">Years<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control frequeny_of_bookkeeping" id="year" name="frequency_of_salestax_years"  title="Year" <?= ($processing_data->frequeny_of_salestax == 'y') ? 'required=""' : '' ?>>
                                     <?php if(isset($processing_data->frequeny_of_salestax)) {
                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                   <?php  } 
                                      }else{
                                    $i=0;
                                    $year=['Select',date('Y')-3,date('Y')-2,date('Y')-1,date('Y'),date('Y')+1];
                                    for($i=0;$i<=5;$i++){ ?>
                                    <option value="<?php echo $year[$i];?>" <?php if($year[$i]==date('Y')){ echo "selected"; } ?>><?php echo $year[$i];?></option>
                                   <?php  }

                                     } ?>
                                    
                                </select>
                                <div class="errorMessage text-danger"></div>
                                <input type="hidden" name="frequency_of_salestax_years" value="">
                            </div>
                        </div>
                    </div>
                        
                        <div class="form-group state_div">
                            <label class="col-lg-2 control-label">State<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control" onchange="county_ajax(this.value, '');" name="state" id="salesstate" title="State of Recurring" required="">
                                    <option value="">Select an option</option>
                                     <?php
                                    foreach ($state_list as $st) {
                                           if(isset($state_id)){ ?>
                                            <option value="<?= $st['id']?>" <?php echo ($state_id == $st['id']) ? 'selected' : ''; ?>><?= $st['state_name']; ?></option>
                                     <?php   }else { 
                                     ?>
                                            <option value="<?= $st['id']; ?>"><?= $st['state_name']; ?></option>
                                            <?php } } ?>
                                </select>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group county_div" id="county_div">
                            <label class="col-lg-2 control-label">County<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <div id="county"><select class="form-control" name="county" id="county" title="County of Recurring" required="">

                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    <div class="hr-line-dashed"></div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" name="new_reference_id" id="new_reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference_id" id="reference_id" value="<?= $reference_id; ?>">
                                <input type="hidden" name="reference" id="reference" value="company">
                                <input type="hidden" name="service_id" id="service_id" value="<?= $service_id; ?>">
                                <input type="hidden" name="action" id="action" value="create_sales_tax_processing">
                                <input type="hidden" name="quant_title" id="quant_title" value="">
                                <input type="hidden" name="quant_contact" id="quant_contact" value="">
                                <input type="hidden" name="quant_account" id="quant_account" value="">
                                <input type="hidden" name="quant_documents" id="quant_documents" value="">
                                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>" />
                                <input type="hidden" name="editval" id="editval" value="">
                                <input type="hidden" name="order_id" id="order_id" value="<?= $order_id; ?>">
                                <button class="btn btn-success" type="button" onclick="related_create_sales_tax_processing('related_create_sales_tax_processing')">Save changes</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelRelatedServiceForm('related_create_sales_tax_processing')">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if(isset($state_id)){ ?>
     county_ajax(<?= $state_id;?>, <?= $processing_data->county; ?>); 
 <?php } ?>
      $(document).ready(function(){
            $("#frequency_of_salestax").change(function(){
                
                 var frequency_of_salestax=$("#frequency_of_salestax").val();
                  
            if(frequency_of_salestax=='m'){
                 $("#frequency_of_salestax_month").show();
                 $("#months").attr('required', "required");
                 $("#year1").attr('required', "required");
                 $("#frequency_of_salestax_querter").hide();
                 $("#quarter").removeAttr('required').val("");
                 $("#year2").removeAttr('required').val("");
                 $("#frequency_of_salestax_years").hide();
                 $("#year").removeAttr('required').val("");
                 
             }else if(frequency_of_salestax=='q'){
                 $("#frequency_of_salestax_querter").show();
                 $("#quarter").attr('required', "required");
                 $("#year2").attr('required', "required");
                 $("#frequency_of_salestax_month").hide();
                 $("#month").removeAttr('required').val("");
                 $("#year1").removeAttr('required').val("");
                 $("#frequency_of_salestax_years").hide();
                 $("#year").removeAttr('required').val("");
                 
             }else{
                 $("#frequency_of_salestax_years").show();
                 $("#year").attr('required', "required");
                 $("#frequency_of_salestax_querter").hide();
                 $("#quarter").removeAttr('required').val("");
                 $("#year2").removeAttr('required').val("");
                 $("#frequency_of_salestax_month").hide();
                 $("#months").removeAttr('required').val("");
                 $("#year1").removeAttr('required').val("");
                 
             }
             
                  });
             });

    </script>



