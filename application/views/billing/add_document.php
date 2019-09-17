<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="form_add_document" onsubmit="saveDocument(); return false;">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" style="font: 24px;">Invoice ID<span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="invoice_id" id="invoice_id" title="Invoice ID" required="">
                                <div class="errorMessage text-danger"></div>
                            </div>
                        </div>
                        <div id="document_container_div">
                            <!-- Add multiple document inside this div using ajax -->
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="hidden" id="section_id" value="">
                                <input type="hidden" name="editval" id="editval" value="">
                                <button class="btn btn-success" type="button" onclick="saveDocument()">Submit</button> &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-default" type="button" onclick="cancelDocument()">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    addDocumentAjax();
</script>