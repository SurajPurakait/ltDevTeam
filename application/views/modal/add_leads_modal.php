<?php if($modal_type == 'edit'){  ?>

<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Edit Leads</h4>
            </div>
            <form class="form-horizontal" role="form" id="edit_addleads_form" name="add_leads_form" onsubmit="update_addlead(); return false;">
            <div class="modal-body">  

                <input type="hidden" name="leadid" value="<?= $id; ?>">
                
                <div class="form-group">
                    <label class="col-lg-3 control-label">First Name</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="first_name" id="first_name" title="First Name" value="<?= $leaddetails['first_name'] ?>" required>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Last Name</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="last_name" id="last_name" title="Last Name" value="<?= $leaddetails['last_name'] ?>" required>
                       
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Email</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="email" name="u_email" id="u_email" title="Email" value="<?= $leaddetails['email'] ?>" required>
                        
                    </div>
                </div>  

                <div class="form-group">
                    <label class="col-lg-3 control-label">Phone</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="tel" name="phone" id="phone" title="Phone" value="<?= $leaddetails['phone1'] ?>" required>
                        
                    </div>
                </div> 

                <div class="form-group">
                    <label class="col-lg-3 control-label">Company</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="company" id="company" title="Company" value="<?= $leaddetails['company_name'] ?>" required>
                        
                    </div>
                </div>    

                <div class="form-group">
                    <label class="col-lg-3 control-label">Language</label>
                    <div class="col-lg-9">

                        <select required class="form-control" id="language" name="language">

                            <option><?= $selected_lang['language'] ?></option>
                                <?php foreach ($languages as $value):
                            if($value["id"] != 4 && $value["id"] != 5) { ?>
                                    <option value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
                                     <?php } ?>
                                <?php endforeach; ?>
                                  
                        </select>
                        
                    </div>
                </div>

                <?= note_func('Notes', 'n', 3, 'lead_id', $leaddetails['id']); ?>

                <div class="form-group" style="display: none;">
                    <input type="text" name="type-of-contact" value="13">
                    <input type="text" name="lead-source" value="1">
                    <input type="text" name="date-of-first-contact" value="2019-09-12">
                </div>    

            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="update_addlead_modal(<?= $leaddetails['id']; ?>)">Save changes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
             </form>  
        </div>
    </div> 
    <script type="text/javascript">
        $('.add-note').click(function () {

            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' + '<div class=" col-lg-offset-3 col-lg-9">' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' + '</div>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

    </script>

<?php }  else { ?>

<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Leads</h4>
            </div>
            <form class="form-horizontal" role="form" id="add_leads_form" name="add_leads_form" onsubmit="save_add_leads_modal(); return false;">
            <div class="modal-body">  
                
                <div class="form-group">
                    <label class="col-lg-3 control-label">First Name<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="first_name" id="first_name" title="First Name" value="" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Last Name<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="last_name" id="last_name" title="Last Name" value="" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Email<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="email" name="u_email" id="u_email" title="Email" value="" required>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>  

                <div class="form-group">
                    <label class="col-lg-3 control-label">Phone</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="tel" name="phone" id="phone" title="Phone" value="" >
                        <!-- <div class="errorMessage text-danger"></div> -->
                    </div>
                </div> 

                <div class="form-group">
                    <label class="col-lg-3 control-label">Company</label>
                    <div class="col-lg-9">
                        <input placeholder="" class="form-control" type="text" name="company" id="company" title="Company" value="" >
                        <!-- <div class="errorMessage text-danger"></div> -->
                    </div>
                </div>    

                <div class="form-group">
                    <label class="col-lg-3 control-label">Language<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <!-- <input placeholder="" class="form-control" type="text" name="language" id="language" title="Language" value="" required> -->
                        <select required class="form-control" id="language" name="language">
                                <?php foreach ($languages as $value): 
                                    if($value["id"] != 4 && $value["id"] != 5){ ?>
                                    <option value="<?= $value["id"]; ?>"><?= $value["language"]; ?></option>
                                    <?php } ?>
                                <?php endforeach; ?>
                                   
                            </select>
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

        
                <div class="hr-line-dashed"></div>
                <?= note_func('Notes', 'n', 3); ?> 
                   

                <div class="form-group" style="display: none;">
                    <input type="text" name="type-of-contact" value="13">
                    <input type="text" name="lead-source" value="1">
                    <input type="text" name="date-of-first-contact" value="2019-09-12">
                </div>    

            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_add_leads_modal();">Save changes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
             </form>  
        </div>
    </div> 

    <script type="text/javascript">
        $('.add-note').click(function () {

            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' + '<div class=" col-lg-offset-3 col-lg-9">' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' + '</div>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });

    </script>
    <?php } ?>        
