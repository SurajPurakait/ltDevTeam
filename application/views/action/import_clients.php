<?php
$user_info = staff_info();
$user_department = $user_info['department'];
$user_type = $user_info['type'];
$role = $user_info['role'];
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#business" aria-controls="business" role="tab" data-toggle="tab">Business</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#individual" aria-controls="individual" role="tab" data-toggle="tab">Individual</a> 
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    
                                    <div role="tabpanel" class="tab-pane active p-t-20"  id="business">
                                        <form method="post" class="form-horizontal" onsubmit="return false;"  id="excel-form">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Choose File</label>
                                                <div class="col-lg-10">
                                                    <div class="upload-file-div">
                                                        <input class="m-t-5" id="excel_file" type="file" name="excel_file" title="Excel File" allowed_types="xlsx|xls|csv" required="">
                                                        <div class="errorMessage text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                  <button type="submit" class="btn btn-primary save_btn" onclick="insert_excel_form('b');">Import Business</button>
                                                </div>
                                            </div>                                            
                                       </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane p-t-20"  id="individual">
                                        <form method="post" class="form-horizontal" onsubmit="return false;"  id="excel-form-individual">
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Choose File</label>
                                                <div class="col-lg-10">
                                                    <div class="upload-file-div">
                                                        <input class="m-t-5" id="excel_file" type="file" name="excel_file" title="Excel File" allowed_types="xlsx|xls|csv" required="">
                                                        <div class="errorMessage text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="hr-line-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                  <button type="submit" class="btn btn-primary save_btn" onclick="insert_excel_form('i');">Import Individual</button>
                                                </div>
                                            </div>
                                        </form>      
                                    </div>
                                       
                                </div>
                                
                            </div>
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
