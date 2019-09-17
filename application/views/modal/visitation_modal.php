

 <?php if($modal_type == 'add'){  ?>
  <!-- Add visitation modal -->
 <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add New Visitation</h3>
            </div>
            <form class="form-horizontal" method="post" id="add_visit_form" enctype="multipart/form-data" onsubmit="return false;">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office[]" id="office" title="Office" required="" multiple="">
                                <!-- <option value="">Select an option</option> -->
                                <?php load_ddl_option("staff_office_list"); ?>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">Subject
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <input placeholder="Subject" class="form-control" type="text" name="subject" id="subject"
                               required title="Subject" value="">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2  control-label">Date
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10 ">
                            <input placeholder="mm/dd/yyyy" id="due_date" class="form-control datepicker_mdy_due" type="text" required title="Date" name="due_date">
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Start time
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" value="" id="start_time" clock required title="Start time" name="start_time" >
                             
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                           
                            </div>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">End time
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" value="" id="end_time" clock required title="End time" name="end_time">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                      
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Participants
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="manager[]" id="manager" title="Participants" required="" multiple="">
                                <option value="">Select an option</option>
                            </select>
                            <div class="errorMessage text-danger"></div>
                        </div>
                    </div>

                   
                    <div class="form-group">                    
                        <label class="col-lg-2 control-label">Notes:</label>
                        <div class="col-lg-10">
                            <div class="form-group" id="add_note_div">
                                <div class="note-textarea">
                                    <textarea class="form-control" name="visit_note[]"  title="Visitation Note"></textarea>
                                </div>
                                <a href="javascript:void(0)" class="text-success add-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                            </div>
                        </div>                   
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 control-label">Attachments</label>
                        <div class="col-lg-10  col-md-10">
                            <div class="upload-file-div">
                                <input class="file-upload" id="upload_file" type="file" name="upload_file[]" title="Upload File">
                                <div class="errorMessage text-danger m-t-5"></div>
                            </div>
                            <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                        </div>
                    </div>
                         

                   
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="insert_visit()">Submit</button> &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
 </div>


<?php }  else { ?>
    <!-- Edit visitation modal -->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Edit Visitation</h3>
            </div>
            <form class="form-horizontal" method="post" id="update_visit_form" enctype="multipart/form-data"
                  onsubmit="return false;">
                <div class="modal-body">


                    <div class="form-group">
                        <label class="col-lg-2 control-label">Office</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="office[]" id="office" title="Office" required="" multiple="">
                                <?php load_ddl_option("staff_office_list_multiple_select",explode(",",$visitation_result['office'])); ?>
                            </select>
                           
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">Participants</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="manager[]" id="manager" title="Participants" required multiple="">
                                <option value="">Select an option</option>
                            </select>
                            
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">Subject</label>
                        <div class="col-lg-10">
                            <input placeholder="Subject" class="form-control" type="text" name="subject" id="subject"
                                   required title="Subject" value="<?= $visitation_result['subject']; ?>">
                           
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-lg-2  control-label">Date</label>
                        <div class="col-lg-10 ">
                            <input placeholder="mm/dd/yyyy" id="due_date" class="form-control datepicker_mdy_due" type="text" required title="Date" name="due_date" value="<?= date("m/d/Y", strtotime($visitation_result['date'])); ?>">
                                
                        </div>
                    </div>

                     

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Start time</label>
                        <div class="col-lg-10">
                            <div class="input-group clockpickerstart" data-autoclose="true">
                                <input type="text" class="form-control" value="" id="start_time" clock required title="Start time" name="start_time">
                                                            
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                               
                            </div>
                            
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">End time</label>
                        <div class="col-lg-10">
                            <div class="input-group clockpickerend" data-autoclose="true">
                                <input type="text" class="form-control" value="" id="end_time" clock required title="End time" name="end_time" value="<?= $visitation_result['end_time']; ?>">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                            
                        </div>
                    </div>

                

                <?= note_func('Visit Note', 'n', 10, 'visitation_id', $visitation_result['id']); ?>
                
                   

                <div class="form-group">
                
                <div class="col-lg-10 col-lg-offset-2">            
                <?php 
                    if(!empty($attachments)){
                        foreach ($attachments as $img) : ?>
                            <div id="imagelocation<?php echo $img['id'] ?>">
                                <div class="col-lg-3">
                                    <img src="<?php echo base_url(); ?>uploads/<?= $img['filename']; ?>" width="100px" height="100px"></br></br>
                                    <span style="cursor:pointer;" onclick="deleteimage(<?php echo $img['id'] ?>)">X</span>
                                </div>
                            </div>
                <?php 
                        endforeach; 
                    } 
                ?>
                </div>
                </div>

 
                    <div class="form-group">
                        <label class="col-lg-2  control-label">Attachments</label>
                            <div class="col-lg-10 ">
                                <div class="upload-file-div">
                    
                                    <input class="file-upload" id="upload_file" type="file" name="upload_file[]" title="Upload File">
                                    
                                </div>
                                <a href="javascript:void(0)" class="text-success add-upload-file"><i class="fa fa-plus"></i> Add File</a>
                            </div>
                             
                    </div>
                      

                   
                </div>


                <div class="modal-footer">
                    <button class="btn btn-success" type="button" onclick="update_visit(<?= $visitation_result['id']; ?>)">Submit</button> &nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
    <!--End of Edit visitation modal -->

    <script type="text/javascript">

        $('.clockpickerstart').clockpicker().find('input').val('<?php echo substr($visitation_result['start_time'], 0, -3); ?>');

        $('.clockpickerend').clockpicker().find('input').val('<?php echo substr($visitation_result['end_time'], 0, -3); ?>');

        // $("#office").change(function(){

        //      get_office_list_forstaff('<?php //echo $visitation_result['office']; ?>','<?php //echo $parti['participant']; ?>');

        // });

        get_office_list_forstaff('<?php echo $visitation_result['office']; ?>','<?php echo $visitation_result['participants']; ?>');


    function deleteimage(image_id)
        {
        var answer = confirm ("Are you sure you want to delete this image?");
        if (answer)
            {
                $.ajax({
                        type: "POST",
                        url:base_url + 'visitation/Visitation_home/deleteimage',
                        data: "image_id="+image_id,
                        success: function (res) {

                            //alert(res); return false;
                          if (res.trim() == 1) {
                            $("#imagelocation"+image_id).remove(); 
                            swal("Success!", "Successfully deleted!", "success");
                          }else{
                      swal("ERROR!", "An error ocurred! \n Please, try again.", "error");
                    }

                        }
                    });
            }
        }

    </script>
 <?php } // end edit loop ?> 


    <script type="text/javascript">    
        $(function () {

            $("#office").change(function(){
                var office_id = $(this).val();
                var selected = '';
                get_office_list_forstaff(office_id,selected);
            });
                     
            $('.clockpicker').clockpicker();

            $(".datepicker_mdy_due").datepicker({format: 'mm/dd/yyyy', autoHide: true, startDate: new Date()});

            $('.add-note').click(function () {

            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });



             $('.add-upload-file').on("click", function () {
            var text_file = $(this).prev('.upload-file-div').html();
            var file_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="file_div' + div_count + '"><label class="col-lg-2 control-label">' + file_label + '</label><div class="col-lg-10">' + text_file + '<a href="javascript:void(0)" onclick="removeFile(\'file_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove File</a></div></div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
            });
        });
        function removeFile(divID) {
        $("#" + divID).remove();
    }

       
   
    </script>