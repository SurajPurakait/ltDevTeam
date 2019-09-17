
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <div class="ibox-content">
             <a href="<?= base_url() ;?>lead_management/new_event" class="btn btn-primary"><i class="fa fa-plus"></i> New Event</a> &nbsp;                  
                  <!-- <div class="ajaxdiv"></div>  -->

                <?php if (count($event_details) != 0): ?>
                    <h2 class="text-primary"><?= count($event_details); ?> Results found</h2>
                <?php endif; ?>

                <?php if (!empty($event_details)): ?>

                <?php foreach ($event_details as $eventVal) 
                {
                    ?>
                  
               
                    <div class="panel panel-default service-panel">
                   
                        <div class="panel-heading">
                            <a href="<?= base_url('lead_management/event/show_event_edit_details/' . $eventVal['id']); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            
                            <a href="javascript:void(0);" class="btn btn-primary btn-xs btn-service-view" ><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                            <!-- <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="" aria-expanded="false" class="collapsed" style="cursor:default;"> -->

                                <div class="table-responsive">
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
                                            <td title="Date"><?= ($eventVal['event_date'] != "") ? $eventVal['event_date'] : "N/A";  ?></td>
                                            <td title="Location"><?= ($eventVal['location'] != "") ? $eventVal['location'] : "N/A";  ?></td>
                                                                     
                                        </tr>
                                    </table>
                                </div>
                           </a>
                        </div>
                    </div>

                    <?php  }   ?>
                    
                    <?php endif; ?>
                  
                </div>
              
            </div>
        </div>
    </div>
</div>


<!-- Edit Event modal div -->
<!-- <div id="event-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div> -->


    


     
