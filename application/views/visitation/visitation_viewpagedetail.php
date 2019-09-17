<?php
$td_style = "padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;";

?>
<div class="wrapper wrapper-content">
    <div class="ibox-content m-b-md"> 
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%;">
                <tr>
                    <td colspan="2" style="<?= $td_style; ?>">
                        
                        <h3> Visitation #<?=  $data['id'];  ?> </h3>
                    </td>
                </tr>
               
                    <tr>
                        <td style="<?= $td_style; ?>width:180px;">
                            Visit Id:
                        </td>
                        <td title="Visit Id" style="<?= $td_style; ?>">
                          <?=  $data['id'];  ?>
                        </td>
                    </tr>
              
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Created By:
                        </td>
                        <td title="Created By" style="<?= $td_style; ?>">
                            <?= get_assigned_by_staff_name( $data['added_by_user']); ?>             
                        </td>
                    </tr>
                
               
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Date:
                        </td>
                        <td title="Date" style="<?= $td_style; ?>">
                           <?=  $data['date']; ?>
                        </td>
                    </tr>
              
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Subject:
                        </td>
                        <td title="Subject" style="<?= $td_style; ?>">
                           <?=  $data['subject']; ?>
                        </td>
                    </tr>
                
                    <!-- <tr>
                        <td style="<?= $td_style; ?>">
                            Franchise Manager:
                        </td>
                        <td title="Franchise Manager" style="<?= $td_style; ?>">
                           <?//= get_assigned_by_staff_name($data['manager']); ?> 
                        </td>
                    </tr> -->
                
               
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Start Time:
                        </td>
                        <td title="Start Time" style="<?= $td_style; ?>">
                           <?= $data['start_time']; ?>
                        </td>
                    </tr>
                
                    <tr>
                        <td style="<?= $td_style; ?>">
                            End Time:
                        </td>
                        <td title="End Time" style="<?= $td_style; ?>">
                           <?= $data['end_time']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="<?= $td_style; ?>">
                            Office:
                        </td>
                        <td title="Office" style="<?= $td_style; ?>">
                        
                            <?php
                                $val1 = explode(",",$data['office']);
                                for ($i=0; $i <count($val1) ; $i++) { 
                                    echo get_office_name_by_office_id($val1[$i])."<br>";      
                                }
                            ?>                          
                          </td>
                    </tr>
               
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Participants:
                        </td>
                        <td title="Participants" style="<?= $td_style; ?>">
                            <?php
                                $val2 = explode(",",$data['participants']);
                                for ($i=0; $i <count($val2) ; $i++) { 
                                    echo get_assigned_by_staff_name($val2[$i])."<br>";      
                                }
                            ?>   
                        </td>
                    </tr>
                
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Notes:
                        </td>
                        <td title="Notes" style="<?= $td_style; ?>">
                             <!-- <span>  -->
                                    <?php  

                                        $readstatus_array =  visitnotes_read_status($data['id']);
                                        // print_r($readstatus_array);exit;
                                        if(get_visitation_note_count($data['id']) > 0 && in_array(0, $readstatus_array)) {
                                    ?> 

                                    <a id="notecount-<?= $data['id'];?>" class="label-danger label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_notes_modal(<?= $data['id'];?>)"><b> <?= get_visitation_note_count($data['id']); ?> </b></a>

                                    <?php 
                                    }else{
                                    ?>

                                    <a id="notecount-<?= $data['id'];?>" class="label-success label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_notes_modal(<?= $data['id'];?>)"><b> <?= get_visitation_note_count($data['id']); ?> </b></a> 


                                     <?php                  
                                    }

                                    ?>    
                                        
 
                                    <!-- </span> -->
                        </td>
                    </tr>
                
                    <tr>
                        <td style="<?= $td_style; ?>">
                            Attachments:
                        </td>
                        <td title="Attachments" style="<?= $td_style; ?>">
                             <span> 
                                        
                                    <a id="filecount-<?= $data['id'];?>" class="label-success label" href="javascript:void(0);" data-toggle="modal" onclick="show_visit_files_modal(<?= $data['id'];?>)"><b> <?= get_visitation_attachment_count($data['id']); ?> </b></a>
                                </span>
                        </td>
                    </tr>               
         
            </table>
        </div>
        <!-- <div class="text-right">
            
                <form name="download_form" method="POST" action="">
                    <input type="hidden" id="filesarray" name="filesarray" value="">
                    <button class="btn btn-info m-t-10" type="submit"><i class="fa fa-download"></i> Download All Files</button>
                    <button class="btn btn-danger m-t-10" type="button" onclick="">Back to dashboard</button>
                </form>
            
        </div> -->
    </div>
</div>


<!-- Visit Notes Modal -->
 <div class="modal fade" id="visitation-note-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_visitation_notes();">

                <div id="notes-modal-body" class="modal-body p-b-0"></div>

                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_visitation_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
          
            <form method="post" id="modal_note_form" onsubmit="add_visitation_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="visit_note[]"  title="Action Note"></textarea>
                        </div>

                        <a href="javascript:void(0)" class="text-success add-action-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="visitation_id" id="visitation_id">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_visitation_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End of Notes Modal -->

<!-- Attachment Modal -->
<div class="modal fade" id="showvisitFiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Files</h4>
            </div>
            <div id="files-modal-body" class="modal-body"></div>
        </div>
    </div>
</div>
<!-- End of Attachment Modal -->