<?php $staff_info = staff_info();
if(!isset($selected_cat)){
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="searchtitle" id="searchtitle" placeholder="Search" class="form-control">
                                </div>
                            </div>
                            <div style="display: none;">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="searchkeywords" id="searchkeywords" placeholder="Keywords">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="search_main_cat" id="search_main_cat" class="form-control" onchange="get_training_subcat(this.value);">
                                        <option value="">Select Main Category</option>
                                        <?php
                                        if (!empty($main_cat)) {
                                            foreach ($main_cat as $c) {
                                                ?>
                                                <option <?php echo ($c['id']==$selected_cat) ? 'selected' : ''; ?> value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" id="training_sub_cat">
                                    <select name="search_sub_cat" id="search_sub_cat" class="form-control" onchange="subcat_filter()">
                                        <option value="">Select Sub Category</option>
                                        <?php
                                        if (!empty($sub_cat)) {
                                            foreach ($sub_cat as $c) {
                                                ?>
                                                <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </div>
                            </div>
                            <?php if ($staff_info['department'] == '1'): ?>
                                <div class="col-md-3 text-right">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false"><i class="caret"></i> Add New</button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url("/training_materials/add_training_material/" . $visible_by) ?>">Training Material</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#showSuggestions">
                                                    Add Suggestion
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-md-3">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#showSuggestions" class="btn btn-primary pull-right" title="Create Training Material">
                                        <i class="fa fa-plus"></i> Add Suggestion
                                    </a>
                                </div>
                        <?php endif; ?>
                        </div>
                    </div>
                    <hr class="hr-line-dashed m-t-0 m-b-10">
                    <div id="load_data"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_area" class="modal fade" aria-hidden="true" style="display: none;"></div>
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
<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div id="notes-modal-body" class="modal-body no-padding">
                <textarea readonly="readonly" style="resize: none;" id="note_textarea" class="form-control" title="Note"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
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
            <form method="post" id="modal_suggestion_form" action="<?= base_url(); ?>training_materials/addSuggestionsmodal">
                <div class="modal-body">
                    <h4>Add New Suggestion</h4>
                    <div class="form-group" id="add_note_div">
                        <div class="note-textarea">
                            <textarea class="form-control" name="training_suggestion[]"  title="Training Suggestion"></textarea>
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
    load_videos('', '', '<?php echo $selected_cat; ?>', '', '<?= $visible_by; ?>');
    $(function () {
        $("#searchtitle").keyup(function () {
            var tit = $("#searchtitle").val();
            var key = $("#searchkeywords").val();
            var mc = $("#search_main_cat option:selected").val();
            var sc = $("#search_sub_cat option:selected").val();
            load_videos(tit, key, mc, sc, '<?= $visible_by; ?>');
        });
        $("#searchkeywords").keyup(function () {
            var tit = $("#searchtitle").val();
            var key = $("#searchkeywords").val();
            var mc = $("#search_main_cat option:selected").val();
            var sc = $("#search_sub_cat option:selected").val();
            load_videos(tit, key, mc, sc, '<?= $visible_by; ?>');
        });
        $("#search_main_cat").change(function () {
            var tit = $("#searchtitle").val();
            var key = $("#searchkeywords").val();
            var mc = $("#search_main_cat option:selected").val();
            var sc = $("#search_sub_cat option:selected").val();
            load_videos(tit, key, mc, sc, '<?= $visible_by; ?>');
        });
    });

          function subcat_filter(){
            var tit = $("#searchtitle").val();
            var key = $("#searchkeywords").val();
            var mc = $("#search_main_cat option:selected").val();
            var sc = $("#search_sub_cat option:selected").val();
            load_videos(tit, key, mc, sc, '<?= $visible_by; ?>');
        }

    function get_training_subcat(main_cat_id){
        $.ajax({
            type: 'POST',
            url: base_url + 'training_materials/get_training_subcat',
            data: {
                main_cat_id: main_cat_id
            },
            success: function (result) {
                $("#training_sub_cat").html(result);
            },
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        });
     }
</script>