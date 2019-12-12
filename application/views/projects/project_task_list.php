<?php
if (!empty($data)) {
    foreach ($data as $value) {
        if (strlen($value['description']) > 20) {
            $description = substr($value['description'], 0, 20) . '...';
        } else {
            $description = $value['description'];
        }
        ?>
        <div class="panel panel-default service-panel type2 filter-active" id="action<?= $value['id'] ?>">
            <div class="panel-heading">
                <a href="javascript:void(0);" onclick="project_task_edit_modal(<?= $value['id']?>,<?= $value['project_id'] ?>);" class="btn btn-primary btn-xs btn-service-edit btn-prj-template-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>                                
                <h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $value['id'] ?>" aria-expanded="false">
                    <div class="table-responsive">
                        <table class="table table-borderless text-center" style="margin-bottom: 0px;">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">Task Id</th>
                                    <th style="width:8%; text-align: center">Title</th>
                                    <th style="width:8%; text-align: center">Description</th>
                                    <th style="width:8%; text-align: center">Assigned To</th>
                                    <th style="width:8%; text-align: center">Notes</th>
                                </tr>
                                <tr>
                                    <td title="Task Order"><?= $value['task_order'] ?></td>
                                    <td title="Task Order"><?= $value['task_title'] ?></td>
                                    <td title="Description">
                                        <a href="javascript:void(0);" data-toggle="popover" data-placement="top" data-content="<?= $description ?>" data-trigger="hover" title="" data-original-title=""><?= $description ?></a>
                                    </td>
                                    <!--<td title="Assign To"><span></span></td>-->
                                    <td title="Assign To"><span class="text-success"><?php echo get_assigned_project_task_staff($value['id']); ?></span><br><?php echo get_assigned_project_task_department($value['id']); ?></td>                                                    

                                            <!--<td title="Notes"><? get_task_note_count($value['id']) ?></td>-->
                                    <td title='Note'><a id="notecount-<?= $value['id'] ?>" class="label label-danger" href="javascript:void(0)" onclick="show_task_notes(<?= $value["id"]; ?>)"><b> <?= get_task_note_count($value['id']) ?></b></a></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </h5>
            </div>
            <div id="collapse<?= $value['id'] ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width:8%; text-align: center">Description</th>
                                </tr>
                                <tr>
                                    <td title="Description" align="center"><span><?= $value['description'] ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class = "text-center m-t-30">
        <div class = "alert alert-danger">
            <i class = "fa fa-times-circle-o fa-4x"></i>
            <h3><strong>Sorry!</strong> no data found</h3>
        </div>
    </div>
<?php } ?>

<div class="modal fade" id="showTaskNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="modal_note_form_update" onsubmit="update_task_notes();">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button type="button" id="update_note" onclick="update_task_notes();" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
           <!--  <form method="post" id="modal_note_form" action="<?//= base_url(); ?>action/home/addNotesmodal"> -->
            <form method="post" id="modal_note_form" onsubmit="add_task_notes();">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                        </label>
                    </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="task_note[]"  title="Task Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-task-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="taskid" id="taskid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="add_task_notes();" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.add-task-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger removenoteselector"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });
</script>