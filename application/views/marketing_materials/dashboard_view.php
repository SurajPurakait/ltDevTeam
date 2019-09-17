<?php
$staff_info = staff_info();
if (!isset($selected_cat)) {
    $selected_cat = '';
}
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="filters">                       
                        <div class="row">
                            <div class="col-lg-10 col-md-9">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group">
                                            <select name="search_main_cat" id="search_main_cat" class="form-control" onchange="get_marketing_subcat(this.value);">
                                                <option value="">Select Main Category</option>
                                                <?php
                                                if (!empty($main_cat)) {
                                                    foreach ($main_cat as $c) {
                                                        ?>
                                                        <option <?= ($c['id'] == $selected_cat) ? 'selected' : ''; ?> value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group" id="marketing_sub_cat">
                                            <select name="search_sub_cat" id="search_sub_cat" class="form-control" onchange="subcat_filter(this.value)">
                                                <option value="">Select Sub Category</option>
                                                <?php
                                                if (!empty($sub_cat)) {
                                                    foreach ($sub_cat as $c) {
                                                        ?>
                                                        <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <?php if ($staff_info['department'] == '1'): ?>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="form-group">
                                                <a href="<?= base_url("/marketing_materials/add_marketing_material/") ?>" class="btn btn-primary" title="Create Marketing Material" style="width:100%">
                                                    <i class="fa fa-plus"></i> Marketing Material
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#showSuggestions" class="btn btn-primary" title="Add Suggestion" style="width:100%">
                                                <i class="fa fa-plus"></i> Add Suggestion
                                            </a>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <a class="cart btn btn-danger notification-btn pull-right" href="<?= base_url("/marketing_materials/view_cart/") ?>"><i class="fa fa-shopping-cart"></i> Check-out<span class="span-cart label label-success"><b><?= marketing_cart_count(); ?></b></span></a> 
                            </div>
                        </div>
                    </div>                    
                    <div id="load_data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="enlargeImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
            </div>
            <div class="modal-body" id="image_preview"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <form method="post" id="update_modal_form" action="<?= base_url(); ?>marketing_materials/updateNotes">
                <div id="notes-modal-body" class="modal-body p-b-0"></div>
                <div class="modal-body p-t-0 text-right">
                    <button onclick="document.getElementById('update_modal_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" type="submit" class="btn btn-primary">Update Note</button>
                </div>
            </form>
            <hr class="m-0"/>
            <form method="post" id="modal_note_form" action="<?= base_url(); ?>marketing_materials/addNotesmodal">
                <div class="modal-body">
                    <h4>Add New Note</h4>
                    <!-- <div class="col-lg-10">
                        <label class="checkbox-inline">
                            <input type="checkbox"  name="pending_request" id="pending_request" value="1"><b>Add to SOS Notification</b>
                        </label>
                    </div> -->
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="marketing_note[]"  title="Marketing Note"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-marketing-note block m-t-10"><i class="fa fa-plus"></i> Add Notes</a>
                    </div>
                    <input type="hidden" name="marketingid" id="marketingid">
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_note" onclick="document.getElementById('modal_note_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" class="btn btn-primary">Save Note</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showSuggestions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Suggestions</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0"></div>
            <form method="post" id="modal_suggestion_form" action="<?= base_url(); ?>marketing_materials/addSuggestionsmodal">
                <div class="modal-body">
                    <h4>Add New Suggestion</h4>
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="marketing_suggestion[]"  title="Marketing Suggestion"></textarea>
                        </div>
                        <a href="javascript:void(0)" class="text-success add-marketing-note block m-t-10"><i class="fa fa-plus"></i> Add Suggestion</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="save_suggestion" onclick="document.getElementById('modal_suggestion_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" class="btn btn-primary">Save Suggestion</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    load_marketing_materials('<?= $selected_cat; ?>', '');
    $(function () {
        $("#search_main_cat").change(function () {
            var mc = $("#search_main_cat option:selected").val();
            var sc = $("#search_sub_cat option:selected").val();
            load_marketing_materials(mc, sc);
        });
        $('.add-marketing-note').click(function () {
            var textnote = $(this).prev('.note-textarea').html();
            var note_label = $(this).parent().parent().find("label").html();
            var div_count = Math.floor((Math.random() * 999) + 1);
            var newHtml = '<div class="form-group" id="note_div' + div_count + '"> ' +
                    textnote +
                    '<a href="javascript:void(0)" onclick="removeNote(\'note_div' + div_count + '\')" class="text-danger"><i class="fa fa-times"></i> Remove Note</a>' +
                    '</div>';
            $(newHtml).insertAfter($(this).closest('.form-group'));
        });
    });

    function subcat_filter(sc) {
        var mc = $("#search_main_cat option:selected").val();
        load_marketing_materials(mc, sc);
    }

    function enlargeImage(imgval) {
        //alert(imgval);
        var imgtag = '<img style="max-width:100%;" src="<?= base_url(); ?>uploads/' + imgval + '">';
        $("#enlargeImage #image_preview").html(imgtag);
        $('#enlargeImage').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>