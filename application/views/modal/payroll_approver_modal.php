<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <h2 class="m-t-none m-b">Add Payroll Approver</h2>
                    <form role="form" id="form_payroll_approver" name="form_payroll_approver">
                        <div class="row">
                            <h3>Type : Payroll Approver</h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name<span class="text-danger">*</span></label>
                                    <input placeholder="First Name" id="payroll_approver_first_name" class="form-control" required="" type="text" name="payroll_first_name" title="First Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Last Name<span class="text-danger">*</span></label>
                                    <input placeholder="Last Name" id="payroll_approver_last_name" class="form-control" required="" type="text" name="payroll_last_name" title="Last Name">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input placeholder="Title" id="payroll_approver_title" class="form-control" required="" type="text" name="payroll_title" title="Title">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Social Security #<span class="text-danger">*</span></label>
                                    <input placeholder="Social Security" id="payroll_approver_social_security" required="" class="form-control" type="text" name="payroll_social_security" title="Social Security">
                                    <div class="errorMessage text-danger"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number<span class="text-danger">*</span></label>
                                    <input placeholder="Phone Number" phoneval="" id="payroll_approver_phone" class="form-control" required="" type="text" name="payroll_phone" title="Phone Number">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Ext</label>
                                    <input placeholder="Ext" id="payroll_approver_ext" class="form-control" type="text" name="payroll_ext" title="Ext">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group" id="payroll_fax_div">
                                    <label>Fax</label>
                                    <input placeholder="Fax" id="payroll_approver_fax" class="form-control" type="text" name="payroll_fax" title="Fax">
                                    <div class="errorMessage text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input placeholder="Email" id="payroll_approver_email" class="form-control" type="email" required="" name="payroll_email" title="Email">
                                    <div class="errorMessage text-danger"></div>
                                </div> 
                            </div> 
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="id" value="0">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="save_payroll_approver()">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>