<hr class="hr-line-dashed" />
<h3>Recurring Invoice :</h3>
<div class="row p-3">
    <div class="col-md-12">
        <h4><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#RecurranceModal" title="Add Recurrence"><i class="fa fa-refresh"></i></button> &nbsp;<b id="pattern_show"></b>

        </h4>
        <div class="errorMessage text-danger" id="err_generation"></div>
    </div><!-- ./col-md-12 -->
    <!-- <div id="RecurranceModalContainer" style="display: none;"></div> -->
    <!-- Recurrence Modal -->
    <div id="RecurranceModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Recurrence</h2>
                </div><!-- modal-header -->
                <div class="modal-body" style="padding-left: 30px !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Start Date:</label>
                                <input placeholder="mm/dd/yyyy" id="start_date" class="form-control datepicker_mdy_due" type="text" title="Start Date" name="recurrence[start_date]">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Pattern:</label>
                                <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_invoice_pattern(this.value);">
                                    <option value="">Select Pattern</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="annually">Annually</option>
                                    <!--<option value="none">None</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Generation:</label>
                                <div class="form-inline due-div">
                                    <label class="control-label m-r-5"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> New invoice on day</label>&nbsp;
                                    <input class="form-control m-r-5" type="number" name="recurrence[due_day]" value="1" min="1" max="31" style="width: 100px" id="r_day">
                                    <label class="control-label m-r-5">of every</label>&nbsp;
                                    <input class="form-control m-r-5" type="number" name="recurrence[due_month]" value="1" min="1" max="12" style="width: 100px" id="r_month">&nbsp;
                                    <label class="control-label m-r-5" id="control-label">month(s)</label>
                                </div>
                            </div>
                        </div>
                    </div><!-- ./row -->
                    <div class="row">
                        <label class="control-label p-l-15">Duration:</label>
                        <div class="col-md-12">
                            <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="0">&nbsp; Never</label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-inline">
                                <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="1" checked onclick="//check_generation_type(this.value)"></label>&nbsp;
                                <label class="control-label">After</label>&nbsp;
                                <input class="form-control" type="text" id="duration_time" name="recurrence[duration_time]" style="width: 100px">&nbsp;
                                <label class="control-label">generations</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-inline">
                                <label class="control-label"><input type="radio" name="recurrence[duration_type]" value="2"></label>&nbsp;
                                <label class="control-label">Until date</label>&nbsp;
                                <input placeholder="mm/dd/yyyy" id="until_date" class="form-control datepicker_mdy_due" type="text" title="Start Date" name="recurrence[until_date]" style="width: 100px">
                            </div>
                        </div>
                    </div>
                </div><!-- ./modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeInvoiceRecurrenceModal();">Ok</button>
                </div><!-- modal-footer -->
            </div><!-- Modal content-->

        </div><!-- ./modal-dialog -->
    </div><!-- ./Recurrence Modal -->
    <input type="hidden" name="is_recurring" id="is_recurring" value="<?= $is_recurring; ?>">
</div>
<script type="text/javascript">
    $(function () {
        $(".datepicker_mdy_due").datepicker({format: 'mm/dd/yyyy', autoHide: true, startDate: new Date()});
    });
</script>