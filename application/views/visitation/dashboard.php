<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins form-inline">
                <div class="ibox-content">
            <a class="btn btn-success" id="add_visit" onclick="show_visitation_modal('add');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add New</a> &nbsp;                  
                  <div class="ajaxdiv"></div> 
                  
              </div>
              <!-- wrapper end   -->
            </div>
        </div>
    </div>
</div>

<div id="visitation-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>


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

<!-- Div of status tracking modal -->
<div id="changeStatusVisitation" class="modal fade" role="dialog" aria-hidden="true" style="display: none;"></div>
<!-- End of status tracking modal -->


 <script type="text/javascript">
     visitation_dashboard();

     $(document).ready(function () {
        $('.add-action-note').click(function () {
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
