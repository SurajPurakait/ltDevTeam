<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-b-40">
                <form>
                    <div class="tabs-container">                   
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-link active"><a href="#lead_general_info" aria-controls="general-info" role="tab" data-toggle="tab">LEAD GENERAL INFO</a></li>
                            <li class="nav-link"><a href="#email_campaign" aria-controls="contact" role="tab" data-toggle="tab">EMAIL CAMPAIGN</a></li>
                            <li class="nav-link"><a href="#other_info" aria-controls="other" role="tab" data-toggle="tab">OTHER INFO</a></li>                                          
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="lead_general_info"> 
                                <div class="panel-body">
                                    <h3>Lead General Info</h3> 

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <input type="hidden" name="type" id="type" value="1">
                                            <input type="hidden" name="partner_section" value="">
                                            <button class="btn btn-success" type="button" onclick="add_lead_prospect('notrefagent')">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-default" type="button" onclick="cancel_lead_prospect('notrefagent')">Cancel</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane" role="tabpanel" id="email_campaign">
                                <div class="panel-body">
                                    <h3>Email Campaign</h3> 

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <input type="hidden" name="type" id="type" value="1">
                                            <input type="hidden" name="partner_section" value="">
                                            <button class="btn btn-success" type="button" onclick="add_lead_prospect('notrefagent')">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-default" type="button" onclick="cancel_lead_prospect('notrefagent')">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="other_info">
                                <div class="panel-body">
                                    <h3>Other Info</h3>                                    
                                                           
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <input type="hidden" name="type" id="type" value="1">
                                            <input type="hidden" name="partner_section" value="">
                                            <button class="btn btn-success" type="button" onclick="add_lead_prospect('notrefagent')">Save Changes</button> &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-default" type="button" onclick="cancel_lead_prospect('notrefagent')">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" href="javascript:void(0);"
                   onclick="show_lead_ref_modal('add', '');"><i class="fa fa-plus"></i> Add Type Of Contact Referral</a>
                <div class="ibox-content m-t-10">
                    <table id="lead-agent-tab" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            if (isset($lead_agent_list) && count($lead_agent_list) > 0) {
                                foreach ($lead_agent_list as $value) {
                                    ?>
                                    <tr>
                                        <td><?php echo $value['name']; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="editmodal edit_service m-r-15"
                                               onclick="show_lead_ref_modal('edit', '<?php echo $value['id']; ?>');"
                                               title="EDIT"><i
                                                    class="fa fa-edit"></i></a>&nbsp;
                                            <a href="javascript:void(0);" title="DELETE"
                                               onclick="delete_lead_ref('<?php echo $value['id'] ?>');"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                <?php
                                }
                            } else {
                                echo '<tr><th colspan="3">No Data Found</th></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="lead-ref-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($lead_agent_list) && count($lead_agent_list) > 0) { ?>
            if ($('#lead-agent-tab').length > 0) {
                $("#lead-agent-tab").dataTable();
            }
<?php } ?>
    });
</script>