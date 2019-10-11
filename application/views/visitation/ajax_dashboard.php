<?php
    // echo "<pre>";
    // print_r($result);exit;
?>
<div class="clearfix">
<?php if (count($result) != 0): ?>
    <h2 class="text-primary pull-left"><?= count($result); ?> Results found</h2>
<?php endif; ?>
</div>


 <?php
    if (!empty($result)): 
        foreach ($result as $value): 
        
        if ($value['status'] == '1') {
            $visitation_status = 'New';
            $visitation_trk = 'label-success';
        }elseif ($value['status'] == '2') {
            $visitation_status = 'Completed';
            $visitation_trk = 'label-primary';
        }elseif ($value['status'] == '3') {
            $visitation_status = 'Cancelled';
            $visitation_trk = 'label-primary';
        }    
?>
<div class="panel panel-default service-panel">
   
        <div class="panel-heading">
            <a href="javascript:void(0);" onclick="show_visitation_modal('edit','<?= $value['id']; ?>');" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
            <a href="<?= base_url('visitation/Visitation_home/visitation_viewdetails/' . $value['id']); ?>" class="btn btn-primary btn-xs btn-service-view" ><i class="fa fa-eye" aria-hidden="true"></i> View</a>
            <a class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id']; ?>" aria-expanded="false" class="collapsed" style="cursor:default;">

                <div class="table-responsive">
                    <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                        <tr>
                            <th class="text-center" width="10%">ID</th>
                            <th class="text-center" width="10%">DATE</th>
                            <th class="text-center" width="20%">OFFICE</th>
                            <th class="text-center" width="20%">SUBJECT</th>
                            <th class="text-center" width="20%">Tracking</th>
                            <th class="text-center" width="20%">Created By</th>
                            <!-- <th class="text-center" width="25%">Office</th> -->
                            <!-- <th class="text-center" width="20%">Manager</th> -->   
                        </tr>

                        <tr>
                            <td title="Visit Id"><?= $value['id']; ?></td>
                            <td title="Date"><?= date("m-d-Y", strtotime($value['date']));?></td>
                            <td title="Office">
                                <?php
                                    $val1 = explode(",",$value['office']);
                                    for ($i=0; $i <count($val1) ; $i++) { 
                                        echo get_office_name_by_office_id($val1[$i])."<br>";      
                                    }
                                ?> 
                            </td>
                            <td title="Subject"><?= $value['subject']; ?></td>
                            <td title="Status"><a href='javascript:void(0);' onclick="change_visitation_status(<?= $value['id']; ?>,<?= $value['status']; ?>);" ><span class="<?= $visitation_trk; ?>" style="width: 80px; display: inline-block; text-align: center;"><?= $visitation_status; ?></span></a></td>
                            <td title="Created By"><?= get_assigned_by_staff_name($value['added_by_user'])."<br>" ?>
                               <?= staff_department_name($value['added_by_user']) ?>
                            </td>
                            <!-- <td title="Office"><?//= $value['office_name']; ?></td> -->
                            <!-- <td title="Manager"> </td> -->
                           
                           
                        </tr>
                    </table>
                </div>
           </a>
        </div>

        <div id="collapse<?= $value['id'] ;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-borderless text-center">
                        <tr>
                            <!-- <th class="text-center">Franchise Id</th> -->
                            <!-- <th class="text-center">Franchise Manager</th> -->
                            <th class="text-center">Time</th>
                            <!-- <th class="text-center">Start Time</th> -->
                            <!-- <th class="text-center">End Time</th> -->
                            <th class="text-center">Participants</th>
                            <th class="text-center">Notes</th>                            
                            <th class="text-center">Attachments</th>
                        </tr>
                       
                                <tr>
                                    <!-- <td title="Franchise Id"></td> -->
                                    <!-- <td title="Franchise Manager"><?//= get_assigned_by_staff_name($value['manager']); ?></td> -->
                                    
                                    <td title="Time">Start: <?= $value['start_time']."<br>" ?>
                                                    Finish: <?= $value['end_time']; ?>
                                    </td>
                                    <!-- <td title="Start Time"><?//= $value['start_time']; ?></td> -->
                                    <!-- <td title="End Time"><?//= $value['end_time']; ?></td> -->
                                    <!-- <td title="Office"><?//= get_office_name_by_office_id(explode(",",$value['office'])); ?></td> -->
                                    
                                   
                                    <td title="Participants">
                                        <?php
                                            $val2 = explode(",",$value['participants']);
                                            for ($i=0; $i <count($val2) ; $i++) { 
                                                echo get_assigned_by_staff_name($val2[$i])."<br>";      
                                            }
                                        ?>   
                                    </td>
                                    <td title="Notes">
                                        <span> 
                                    <?php  

                                        $readstatus_array =  visitnotes_read_status($value["id"]);
                                        // print_r($readstatus_array);exit;
                                        if(get_visitation_note_count($value['id']) > 0 && in_array(0, $readstatus_array)) {
                                    ?> 

                                    <a id="notecount-<?= $value['id'];?>" class="label-danger label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_notes_modal(<?= $value['id'];?>)"><b> <?= get_visitation_note_count($value['id']); ?> </b></a>

                                    <?php 
                                    }else{
                                    ?>

                                    <a id="notecount-<?= $value['id'];?>" class="label-success label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_notes_modal(<?= $value['id'];?>)"><b> <?= get_visitation_note_count($value['id']); ?> </b></a> 


                                     <?php                  
                                    }

                                    ?>    
                                        
 
                                    </span>
                                    </td>

                                   

                                   <td title="Attachments">
                                       <span> 
                                        
                                    <a id="filecount-<?= $value['id'];?>" class="label-success label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_files_modal(<?= $value['id'];?>)"><b> <?= get_visitation_attachment_count($value['id']); ?> </b></a></span>
                                   </td>
                                </tr>
                                                 
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



     
