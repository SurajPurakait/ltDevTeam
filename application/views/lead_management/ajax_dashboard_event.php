<?php if (count($event_list) != 0): ?>
    <h2 class="text-primary"><?= count($event_list); ?> Results found</h2>
<?php endif; ?>
<?php if (!empty($event_list)): ?>
    <?php
    foreach ($event_list as $event):
        ?>
        <div class="panel panel-default service-panel type2 filter-active">
            <div class="panel-heading">
                <a href="<?= base_url("/lead_management/event/edit_event/{$event["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                <a href="<?= base_url("/lead_management/event/view/{$event["id"]}"); ?>" class="btn btn-primary btn-xs btn-service-view"><i class="fa fa-eye" aria-hidden="true"></i>View</a>
                <a href="<?= base_url() ;?>lead_management/new_prospect?id=<?= $event['id'] ; ?>" class="btn btn-primary btn-xs btn-service-add"><i class="fa fa-plus" aria-hidden="true"></i> Add Prospect</a>

                <!-- <a href="javascript:void(0);" onclick="delete_lead_management('<?//= $lead["id"] ?>');" class="btn btn-danger btn-xs btn-service-delete manage-delete-btn"><i class="fa fa-remove" aria-hidden="true"></i>Delete</a> -->

                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $event['id'] ;?>" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th class="text-center" width="20%">Event Type</th>
                                    <th class="text-center" width="15%">Date</th>
                                    <th class="text-center" width="15%">Description</th>
                                    <th class="text-center" width="15%">Event Name</th>
                                    <th class="text-center" width="15%">Location</th>
                                    <th class="text-center" width="20%">Office Id</th>
                                </tr>
                                <tr>
                                    <td title="Event Type" class="text-center" width="20%"    style="word-break:break-all"><?= $event["event_type"]; ?>
                                    </td>
                                    <td title="Date" class="text-center" width="15%"><?= $event["event_date"] ; ?>
                                    </td>
                                    <td title="Event Description" class="text-center"
                                        width="15%"><?= $event["description"] ; ?>
                                    </td>
                                    <td title="Event Name" class="text-center"
                                        width="15%"><?= $event["event_name"] ; ?>
                                    </td>
                                    <td title="Event Location" class="text-center"
                                        width="15%"><?= $event["location"] ; ?>
                                    </td>
                                    <?php
                                        $CI =& get_instance();
                                        $CI->load->model('lead_management');
                                        $result= $CI->lead_management->get_office_by_id($event["office_id"])->result_array();        
                                    foreach($result as $row){
                                    ?>
                                    <td title="Office Id" class="text-center"
                                        width="20%"><?= $row['office_id'] ; ?>
                                    </td>
                                    <?php                      
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            <div id="collapse<?= $event['id'] ;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th style='width:25%;  text-align: center;'>Name</th>
                                <th style='width:25%;  text-align: center;'>Email</th>
                                <th style='width:25%;  text-align: center;'>Phone</th>
                                <th style='width:25%;  text-align: center;'>Company</th>
                            </tr>
                            <?php
                                $CI =& get_instance();
                                        $CI->load->model('lead_management');
                                        $prospects_list= $CI->lead_management->get_prospect_by_event_id($event["id"])->result_array();
                                foreach ($prospects_list as $value) {
                                    if($value['event_id'] == $event['id']){

                            ?>
                            <tr>
                                <td style='width:25%;  text-align: center;'><?= print_r($value['first_name']);?></td>
                                <td style='width:25%;  text-align: center;'><?= print_r($value['email']);?></td>
                                <td style='width:25%;  text-align: center;'><?= print_r($value['phone1']);?></td>
                                <td style='width:25%;  text-align: center;'><?= print_r($value['company_name']);?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>

                        </table>
                    </div>
                </div>
            </div>            
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center m-t-30">
        <div class="alert alert-danger">
            <i class="fa fa-times-circle-o fa-4x"></i> 
            <h3><strong>Sorry !</strong> no data found</h3>
        </div>
    </div>
<?php endif; ?>