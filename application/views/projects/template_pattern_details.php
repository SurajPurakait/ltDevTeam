<div class="col-md-12">
    <h4 class="m-0 p-b-20">Frequency:</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Pattern:</label>
                <select class="form-control" id="pattern" name="recurrence[pattern]" onchange="change_due_pattern(this.value);" style="pointer-events:none" readonly>
                    <option value="monthly" <?php echo ($pattern_details->pattern == 'monthly') ? 'selected' : ''; ?>>Monthly</option>     
                    <option value="weekly" <?php echo ($pattern_details->pattern == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                    <option value="quarterly" <?php echo ($pattern_details->pattern == 'quarterly') ? 'selected' : ''; ?>>Quarterly</option>
                    <option value="annually" <?php echo ($pattern_details->pattern == 'annually') ? 'selected' : ''; ?>>Annually</option>
                    <option value="periodic" <?php echo ($pattern_details->pattern == 'periodic') ? 'selected' : ''; ?>>Periodic</option>
                    <option value="none" <?php echo ($pattern_details->pattern == 'none') ? 'selected' : ''; ?>>None</option>
                </select>
            </div>
            <?php if ($pattern_details->pattern != 'periodic') { ?>
                <div class="form-group">
                    <label class="control-label"><input type="checkbox" name="recurrence[occur_weekdays]" readonly="" id="occur_weekdays" <?php echo ($pattern_details->occur_weekdays == '0') ? '' : 'checked'; ?>> Must occur on weekdays</label>
                </div>
            <?php } ?>
            <div class="annual-check-div" <?php echo ($pattern_details->pattern == 'annually') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                <div class="form-group">
                    <label class="control-label"><input type="checkbox" <?php echo ($pattern_details->client_fiscal_year_end == '0') ? '' : 'checked'; ?> name="recurrence[client_fiscal_year_end]" id="client_fiscal_year_end" readonly> Based on Client fiscal year ends</label>
                </div>
            </div>
        </div><!-- ./col-md-12 -->
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-inline due-div">
                    <?php
                    if ($pattern_details->pattern == 'annually') {
                        if ($pattern_details->client_fiscal_year_end == '0') {
                            ?>
                            <label class="control-label">
                                <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" readonly=""> Due on every</label>&nbsp;<select class="form-control" id="r_month" name="recurrence[due_month]" disabled="">
                                <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                                <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                                <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                                <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                                <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                                <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                                <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                                <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                                <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                                <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                                <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                                <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                            </select>&nbsp;
                            <input class="form-control" type="number" name="recurrence[due_day]" min="1" value="<?php echo $pattern_details->due_day; ?>" max="31" style="width: 100px" id="r_day">


                        <?php } else { ?>
                            <label class="control-label m-r-5">
                                <input type="radio" name="recurrence[due_fiscal]" <?php echo ($pattern_details->fye_type == '1') ? 'checked' : ''; ?> value="1"> Due on every</label>&nbsp;
                            <select class="form-control" name="recurrence[due_fiscal_month]">
                                <option <?php echo ($pattern_details->fye_month == '1') ? 'selected' : ''; ?> value="1">First</option>
                                <option <?php echo ($pattern_details->fye_month == '2') ? 'selected' : ''; ?> value="2">Second</option>
                                <option <?php echo ($pattern_details->fye_month == '3') ? 'selected' : ''; ?> value="3">Third</option>
                                <option <?php echo ($pattern_details->fye_month == '4') ? 'selected' : ''; ?> value="4">Fourth</option>
                            </select>&nbsp;
                            <label class="control-label m-r-5">month after FYE on day</label>&nbsp;
                            <input class="form-control m-r-5" value="1" type="number" name="recurrence[due_fiscal_day]" min="1" max="30" style="width: 100px">&nbsp;

                            <?php
                        }
                    } elseif ($pattern_details->pattern == 'none') {
                        ?>
                        <label class="control-label">
                            <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due on every</label>&nbsp;<select class="form-control" id="r_month" name="recurrence[due_month]">
                            <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                            <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                            <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                            <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                            <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                            <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                            <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                            <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                            <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                            <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                            <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                            <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                        </select>&nbsp;
                        <input class="form-control" type="number" name="recurrence[due_day]" min="1" value="<?php echo $pattern_details->due_day; ?>" max="31" style="width: 100px" id="r_day">
                        }
                    <?php } elseif ($pattern_details->pattern == 'weekly') { ?>
                        <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day"> Due every</label>&nbsp;
                        <input class="form-control" value="<?php echo $pattern_details->due_day; ?>" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day">&nbsp;week(s) on the following days:&nbsp;
                        <div class="m-t-10">
                            <div class="m-b-10">
                                <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="1" <?php echo ($pattern_details->due_month == '1') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Sunday&nbsp;</span>
                                <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="2" <?php echo ($pattern_details->due_month == '2') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Monday&nbsp;</span>
                                <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="3" <?php echo ($pattern_details->due_month == '3') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Tuesday&nbsp;</span>
                                <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="4" <?php echo ($pattern_details->due_month == '4') ? 'checked' : ''; ?> class="m-r-5">&nbsp;Wednesday&nbsp;</span>
                            </div>
                            <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="5" class="m-r-5">&nbsp;Thursday&nbsp;</span>
                            <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="6" class="m-r-5">&nbsp;Friday&nbsp;</span>
                            <span class="m-r-20"><input type="radio" name="recurrence[due_month]" value="7" class="m-r-5">&nbsp;Saturday</span>
                        </div>
                    <?php } elseif ($pattern_details->pattern == 'quarterly') { ?>
                        <label class="control-label">
                            <input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" class="m-r-5"> Due on day</label>&nbsp;
                        <input class="form-control" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" value="<?php echo $pattern_details->due_day; ?>"><label class="control-label">of</label>&nbsp;
                        <select class="form-control" id="r_month" name="recurrence[due_month]">
                            <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>First</option>
                            <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>Second</option>
                            <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>Third</option>
                        </select>&nbsp;
                        <label class="control-label" id="control-label">month in quarter</label>
                    <?php } elseif ($pattern_details->pattern == 'periodic') { ?>
                        <label class="control-label">Due on day</label>&nbsp;
                        <input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" readonly="" value="<?php echo $pattern_details->due_day; ?>">
                        <label class="control-label m-r-5">of month</label>&nbsp;
                        <!--<input class="form-control" type="number" name="recurrence[due_month]" min="1" max="12" style="width: 100px" id="r_month" value="<?php echo $pattern_details->due_month; ?>">&nbsp;-->
                        <select class="form-control" id="r_month" name="recurrence[due_month]" disabled>
                            <option value="1" <?php echo ($pattern_details->due_month == '1') ? 'selected' : ''; ?>>January</option>
                            <option value="2" <?php echo ($pattern_details->due_month == '2') ? 'selected' : ''; ?>>February</option>
                            <option value="3" <?php echo ($pattern_details->due_month == '3') ? 'selected' : ''; ?>>March</option>
                            <option value="4" <?php echo ($pattern_details->due_month == '4') ? 'selected' : ''; ?>>April</option>
                            <option value="5" <?php echo ($pattern_details->due_month == '5') ? 'selected' : ''; ?>>May</option>
                            <option value="6" <?php echo ($pattern_details->due_month == '6') ? 'selected' : ''; ?>>June</option>
                            <option value="7" <?php echo ($pattern_details->due_month == '7') ? 'selected' : ''; ?>>July</option>
                            <option value="8" <?php echo ($pattern_details->due_month == '8') ? 'selected' : ''; ?>>August</option>
                            <option value="9" <?php echo ($pattern_details->due_month == '9') ? 'selected' : ''; ?>>September</option>
                            <option value="10" <?php echo ($pattern_details->due_month == '10') ? 'selected' : ''; ?>>October</option>
                            <option value="11" <?php echo ($pattern_details->due_month == '11') ? 'selected' : ''; ?>>November</option>
                            <option value="12" <?php echo ($pattern_details->due_month == '12') ? 'selected' : ''; ?>>December</option>
                        </select>&nbsp;<a href="javascript:void(0);" onclick="addPeriodicDate()" class="add-filter-button btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add Periodic Date" style="pointer-events:none" disabled> <i class="fa fa-plus" aria-hidden="true"></i> </a>
                        <?php
                        if (!empty($periodic_pattern)) {
                            foreach ($periodic_pattern as $val) {
                                ?><div class="row" id="clone-<?= $val['id'] ?>">
                                    <div class="col-md-12 m-b-5"><label class="control-label m-b-5"> Due on day</label>&nbsp;<input class="form-control m-r-5 test" type="number" name="due_days[]" min="1" max="31" readonly="" value="<?= $val['due_day'] ?>" style="width: 100px" id="r_day1"><label class="control-label m-r-5">of month</label>
                                        <select class="form-control m-r-2 periodic_mnth" id="r_month1" name="due_months[]" value="1" disabled>
                                            <option value="1" <?= $val['due_month'] == 1 ? 'selected' : '' ?> >January</option>
                                            <option value="2" <?= $val['due_month'] == 2 ? 'selected' : '' ?> >February</option>
                                            <option value="3" <?= $val['due_month'] == 3 ? 'selected' : '' ?> >March</option>
                                            <option value="4" <?= $val['due_month'] == 4 ? 'selected' : '' ?>>April</option>
                                            <option value="5" <?= $val['due_month'] == 5 ? 'selected' : '' ?>>May</option>
                                            <option value="6" <?= $val['due_month'] == 6 ? 'selected' : '' ?>>June</option>
                                            <option value="7" <?= $val['due_month'] == 7 ? 'selected' : '' ?>>July</option>
                                            <option value="8" <?= $val['due_month'] == 8 ? 'selected' : '' ?>>August</option>
                                            <option value="9" <?= $val['due_month'] == 9 ? 'selected' : '' ?>>September</option>
                                            <option value="10" <?= $val['due_month'] == 10 ? 'selected' : '' ?>>October</option>
                                            <option value="11" <?= $val['due_month'] == 11 ? 'selected' : '' ?>>November</option>
                                            <option value="12" <?= $val['due_month'] == 12 ? 'selected' : '' ?>>December</option>
                                        </select>&nbsp;
                                        <a href="javascript:void(0);" onclick="removePeriodicDate('<?= $val['id'] ?>')" class="remove-filter-button text-danger btn btn-white" data-toggle="tooltip" title="Remove filter" data-placement="top"><i class="fa fa-times" aria-hidden="true"></i> </a></div></div>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <label class="control-label"><input type="radio" name="recurrence[due_type]" checked="" value="1" id="due_on_day" readonly=""> Due on day</label>&nbsp;
                        <input class="form-control m-r-5" type="number" name="recurrence[due_day]" min="1" max="31" style="width: 100px" id="r_day" readonly="" value="<?php echo $pattern_details->due_day; ?>">
                        <label class="control-label m-r-5">of every</label>&nbsp;
                        <input class="form-control" type="number" name="recurrence[due_month]" min="1" max="12" style="width: 100px" id="r_month" readonly="" value="<?php echo $pattern_details->due_month; ?>">&nbsp;
                        <label class="control-label" id="control-label">month(s)</label>
                    <?php } ?>
                </div>
            </div> 
        </div>
    </div>
    <hr class="hr-line-dashed"/>
    <h3 class="m-0 p-b-20">Generation:</h3>
    <div class="row">
        <div class="col-md-12">
            <label class="control-label"><input type="radio" name="recurrence[generation_type]" disabled value="0" <?php echo ($pattern_details->generation_type == '0') ? 'checked' : ''; ?> onclick="//check_generation_type(this.value)">&nbsp; When previous project is Complete</label>
        </div>
        <div class="col-md-12">
            <div class="form-inline">
                <label class="control-label"><input type="radio" name="recurrence[generation_type]" <?php echo ($pattern_details->generation_type == '1') ? 'checked' : ''; ?> value="1" readonly="" onclick="//check_generation_type(this.value)"></label>&nbsp;
                <input class="form-control" type="number" id="generation_month" name="recurrence[generation_month]" value="<?php echo $pattern_details->generation_month; ?>" readonly="" min="0" max="12" style="width: 100px">&nbsp;
                <label class="control-label">month(s)</label>&nbsp;
                <input class="form-control" value="<?php echo $pattern_details->generation_day; ?>" type="number" id="generation_day" name="recurrence[generation_day]" min="1" max="31" readonly="" style="width: 100px">&nbsp;
                <label class="control-label">Day(s) before next occurrence due date</label>
            </div>
        </div>
        <div class="col-md-12">
            <label class="control-label"><input type="radio" name="recurrence[generation_type]" value="2" <?php echo ($pattern_details->generation_type == '2') ? 'checked' : ''; ?> disabled="" onclick="//check_generation_type(this.value)">&nbsp; None</label>
        </div>

    </div> <!-- ./row -->

</div><!-- ./modal-body -->
</div>