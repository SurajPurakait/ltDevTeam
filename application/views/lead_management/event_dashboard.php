
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">                  
                  <!-- <div class="ajaxdiv"></div>  -->
                    <div class="row">
                        <div class="col-md-7">
                            <a href="<?= base_url() ;?>lead_management/new_event" class="btn btn-primary"><i class="fa fa-plus"></i> New Event</a>

                            <div class="filter-outer">
                                <form name="filter_form" id="filter-form"  method="post" onsubmit="eventFilter()">
                                    <div class="form-group filter-inner">
                                        <div class="filter-div m-b-10 row" id="original-filter">                                           
                                            <div class="col-md-3 m-t-5">
                                                <select class="form-control variable-dropdown" name="variable_dropdown[]" onchange="changeVariable(this)">
                                                    <option value="">All Variable</option>
                                                    <?php
                                                    asort($filter_element_list);
                                                    foreach ($filter_element_list as $key => $fel):
                                                        ?>
                                                        <option value="<?= $key ?>"><?= $fel ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5">
                                                <select class="form-control condition-dropdown" name="condition_dropdown[]" onchange="changeCondition(this)">
                                                    <option value="">All Condition</option>
                                                    <option value="1">Is</option>
                                                    <option value="2">Is in the list</option>
                                                    <option value="3">Is not</option>
                                                    <option value="4">Is not in the list</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 m-t-5 criteria-div">
                                                <select class="form-control criteria-dropdown chosen-select" placeholder="All Criteria" name="criteria_dropdown[][]">
                                                    <option value="">All Criteria</option>
                                                </select>
                                            </div>
                                            <div class="col-md-1 m-t-5">
                                                <div class="add_filter_div text-right">
                                                    <a href="javascript:void(0);" onclick="addFilterRow()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Filter">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> 
                                                    </a>
                                                </div>  
                                            </div>                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-success" type="button" onclick="eventFilter()">Apply Filter</button>&nbsp;
                                             <a href="javascript:void(0);" onclick="loadEventDashboard();" class="btn btn-ghost" id="btn_clear_filter" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i> Clear filter</a>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>   
                    <div id="event_dashboard_div"></div>
                    
                    <div id="event_dashboard_div2">
                        <?php if (count($event_details) != 0): ?>
                    <h2 class="text-primary"><?= count($event_details); ?> Results found</h2>
                <?php endif; ?>

                <?php if (!empty($event_details)): ?>

                <?php foreach ($event_details as $eventVal) 
                {
                    ?>
                  
               
                    <div class="panel panel-default service-panel">
                   
                        <div class="panel-heading p-r-0">

                            <a href="<?= base_url('lead_management/event/view/' . $eventVal['id']); ?>" class="btn btn-primary btn-xs btn-service-lead" target="_blank" ><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                            
                            <a href="<?= base_url('lead_management/event/show_event_edit_details/' . $eventVal['id']); ?>" class="btn btn-primary btn-xs btn-service-lead" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            

                            <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $eventVal['id']; ?>" aria-expanded="false" class="collapsed" style="cursor:default;">

                                <div class="table-responsive p-t-15">
                                    <table class="table table-borderless text-center" style="margin-bottom:0px;">
                                        <tr>
                                            <th class="text-center" width="20%">Office</th>
                                            <th class="text-center" width="15%">Event Type</th>
                                            <th class="text-center" width="15%">Event Name</th>
                                            <th class="text-center" width="20%">Description</th>
                                            <th class="text-center" width="15%">Date</th>
                                            <th class="text-center" width="15%">Location</th>
                                              
                                        </tr>

                                        <tr>
                                            <td title="Office"> <?= get_office_name_by_office_id($eventVal['office_id']);  ?></td>
                                                                    
                                            <td title="Event Type"><?= ($eventVal['event_type'] != "") ? $eventVal['event_type'] : "N/A" ;  ?></td>
                                            <td title="Event Name"><?= ($eventVal['event_name'] != "") ? $eventVal['event_name'] : "N/A";  ?></td>
                                            <td title="Description"><?= ($eventVal['description'] != "") ? $eventVal['description'] : "N/A";  ?></td>
                                            <td title="Date"><?php $newDate = date("m/d/Y", strtotime($eventVal['event_date']));
                                            echo $newDate; ?></td>
                                            <td title="Location"><?= ($eventVal['location'] != "") ? $eventVal['location'] : "N/A";  ?></td>
                                                                     
                                        </tr>
                                    </table>
                                </div>
                           </a>
                        </div>

                           <div id="collapse<?= $eventVal['id'] ;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <?php $data =  get_event_lead_by_id($eventVal['id']); 
                                        if($data != ''){
                                    ?>
                                    <table class="table table-borderless text-center">
                                        <tr>                                            
                                            <th class="text-center" width="20%">Name</th>
                                            <th class="text-center" width="20%">Company</th>
                                            <th class="text-center" width="20%">Email</th>
                                            <th class="text-center" width="20%">Phone</th>
                                           
                                            <!-- <th class="text-center" width="15%">Language</th> -->
                                            <th class="text-center" width="20%">Notes</th>                       
                                        </tr>  

                                    <?php $res = get_event_lead_details($eventVal['id']);
                                     
                                      foreach ($res as $leadvalue) 
                                         {
                                        ?>               
                                        <tr>
                                               
                                            <td title="Name"><?= $leadvalue['last_name'].'<br>'.$leadvalue['first_name'] ?></td>
                                            <td title="Company">
                                                <?= ($leadvalue['company_name'] != "") ? $leadvalue['company_name'] : "N/A";  ?>
                                            </td>
                                            <td title="Email"><?= $leadvalue['email']; ?></td>
                                            <td title="Phone">
                                                <?= ($leadvalue['phone1'] != "") ? $leadvalue['phone1'] : "N/A";  ?>
                                            </td>
                                            
                                            <!-- <td title="Language"><?//= $leadvalue['language_name']; ?></td> -->
                                            <td title="Notes">
                                                <?php $note_count = get_lead_note_count($leadvalue['id']);
                                                echo "<span class='label label-secondary'>".count($note_count)."</span>";
                                                 ?>
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                                                 
                                    </table>
                                <?php }else{
                                    ?>
                                    <!-- echo "<b>No data found</b>"; -->
                                    <div class="text-center">
                                        <b>No leads found</b>
                                    </div>
                                <?php
                                } ?>
                                </div>
                            </div>
                        </div>


                    </div>

                    <?php  }   ?>
                    
                    <?php endif; ?>
                  

                    </div>

                </div>
              
            </div>
        </div>
    </div>
</div>


<!-- Edit Event modal div -->
<!-- <div id="event-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div> -->

<script type="text/javascript">

    var content = $(".filter-div").html();
    var variableArray = [];
    var elementArray = [];
    function addFilterRow() {
        var random = Math.floor((Math.random() * 999) + 1);
        var clone = '<div class="filter-div row m-b-10" id="clone-' + random + '">' + content + '<div class="col-md-1"><a href="javascript:void(0);" onclick="removeFilterRow(' + random + ')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>';
        $('.filter-inner').append(clone);
        $.each(variableArray, function (key, value) {
            $("#clone-" + random + " .variable-dropdown option[value='" + value + "']").remove();
        });
        $("div.add_filter_div:not(:first)").remove();
    }


    function removeFilterRow(random) {
        var divID = 'clone-' + random;
        var variableDropdownValue = $("#clone-" + random + " .variable-dropdown option:selected").val();
        var index = variableArray.indexOf(variableDropdownValue);
        variableArray.splice(index, 1);
        $("#" + divID).remove();
    }


    function changeVariable(element) {
        var divID = $(element).parent().parent().attr('id');
        var variableValue = $(element).children("option:selected").val();
        var checkElement = elementArray.includes(element);
        var officeValue = '';
        if (checkElement == true) {
            variableArray.pop();
            variableArray.push(variableValue);
        } else {
            elementArray.push(element);
            variableArray.push(variableValue);
        }

        $.ajax({
            type: "POST",
            data: {
                variable: variableValue
                // office: officeValue
            },
            url: '<?= base_url(); ?>' + 'lead_management/event/filter_dropdown_option_event_dashboard',
            dataType: "html",
            success: function (result) {
                // alert(result);return false;
                $("#" + divID).find('.criteria-div').html(result);
                $(".chosen-select").chosen();
                $("#" + divID).find('.condition-dropdown').removeAttr('disabled').val('');
                $("#" + divID).nextAll(".filter-div").each(function () {
                    $(this).find('.remove-filter-button').trigger('click');
                });
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
    }

    function changeCondition(element) {
        var divID = $(element).parent().parent().attr('id');
        //alert(divID);
        var conditionValue = $(element).children("option:selected").val();
        var variableValue = $(element).parent().parent().find(".variable-dropdown option:selected").val();
        if (variableValue == 3) {
            if (conditionValue == 2 || conditionValue == 4) {
                $.ajax({
                    type: "POST",
                    data: {
                        condition: conditionValue,
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'lead_management/event/filter_dropdown_option_event_dashboard',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    data: {
                        variable: variableValue
                    },
                    url: '<?= base_url(); ?>' + 'lead_management/event/filter_dropdown_option_event_dashboard',
                    dataType: "html",
                    success: function (result) {
                        $("#" + divID).find('.criteria-div').html(result);
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
            }
        } else {
            if (conditionValue == 2 || conditionValue == 4) {
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").attr("multiple", "");
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            } else {
                $("#" + divID).find(".criteria-dropdown").removeAttr('multiple');
                $("#" + divID).find(".criteria-dropdown").chosen("destroy");
                $("#" + divID).find(".criteria-dropdown").val('');
                $("#" + divID).find(".criteria-dropdown").chosen();
                $("#" + divID).find(".search-choice-close").trigger('click');
            }
        }
    }


</script>  


     
