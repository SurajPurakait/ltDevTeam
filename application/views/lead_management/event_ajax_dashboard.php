<?php if (count($event_details) != 0): ?>
                    <h2 class="text-primary "><?= count($event_details); ?> Results found</h2>
                <?php endif; ?>

                <?php if (!empty($event_details)): ?>

                <?php foreach ($event_details as $eventVal) 
                {
                    ?>
                  
               
                    <div class="panel panel-default service-panel">
                   
                        <div class="panel-heading">
                            <a href="<?= base_url('lead_management/event/show_event_edit_details/' . $eventVal['id']); ?>" class="btn btn-primary btn-xs btn-service-edit" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            
                            <a href="<?= base_url('lead_management/event/view/' . $eventVal['id']); ?>" class="btn btn-primary btn-xs btn-service-view" target="_blank" ><i class="fa fa-eye" aria-hidden="true"></i> View</a>

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
                                            <!-- <td title="Office"> <?//= get_office_name_by_office_id($eventVal['office_id']);  ?></td> -->
                                            <td title="Office"><?= ($eventVal['name'] != "") ? $eventVal['name'] : "N/A" ;  ?></td>
                                                                    
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

                    <?php else: ?>
                        <div class="text-center m-t-30">
                            <div class="alert alert-danger">
                                <i class="fa fa-times-circle-o fa-4x"></i> 
                                <h3><strong>Sorry !</strong> no data found</h3>
                            </div>
                        </div>
                    
                    <?php endif; ?>
                  