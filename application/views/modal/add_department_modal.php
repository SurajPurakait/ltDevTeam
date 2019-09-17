<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Add Department Information</h3>
        </div>
        <form class="form-horizontal" method="post" id="add_dept_form" onsubmit="return false;">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Name<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Name" class="form-control" type="text"
                               value="" name="name" id="name" required
                               title="Name" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Phone<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Phone" class="form-control" phoneval="" type="text"
                               value="" name="phone" id="phone" required
                               title="Phone" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Extension<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Extension" class="form-control" id="extension" type="text"
                               value="" name="extension" required
                               title="Extension" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Email Address<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input placeholder="Email Address" class="form-control" id="emailaddress" type="email"
                               value="" name="email" required
                               title="Email address" value="">
                        <div class="errorMessage text-danger"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" onclick="insert_departments();">Save changes</button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>