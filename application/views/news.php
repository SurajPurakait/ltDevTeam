<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-6 text-left p-b-10">
            <h2 class="text-primary">News</h2>
        </div>
        <div class="col-xs-6 text-right p-t-15">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsModal"><i class="fa fa-plus"></i> &nbsp;Add News</button>
        </div>
    </div>
    <div class="bg-white p-20 news-box p-b-0">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox regular-msg-box">
                    <div class="ibox-title">
                        <h5 class="p-r-20">Lorem Ipsum is dummy printing...</h5>
                        <small class="p-r-20">Aerotrading LLC</small>
                        <small class="p-r-20">INVESTMENT LLC</small>
                        <span class="badge"><b>22/04/2018</b></span>                        
                        <div class="ibox-tools">
                            <a class="collapse-link text-white">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="javascript:void(0);" class=" text-white">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="display: none;">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> 
                    </div>
                </div><!-- /.ibox -->
                <div class="ibox important-msg-box">
                    <div class="ibox-title">
                        <h5 class="p-r-20">Lorem Ipsum is dummy printing...</h5>
                        <small class="p-r-20">Aerotrading LLC</small>
                        <small class="p-r-20">Aerotrading LLC</small>
                        <span class="badge"><b>22/04/2018</b></span>
                        <div class="ibox-tools">
                            <a class="collapse-link text-white">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="javascript:void(0);" class="text-white">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="display: none;">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> 
                    </div>
                </div><!-- /.ibox -->
            </div>
        </div><!-- /.col-md-12 -->
    </div>
</div><!-- /.wrapper -->
<!-- News Modal -->
<div id="newsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add News</h3>
            </div><!-- Modal Header-->
            <div class="modal-body">
                <form method="post" id="form_save_news">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <select id="" class="form-control">
                                    <option>Important</option>
                                    <option>Regular</option>
                                </select>
                                <div class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Type</label>
                                <select id="" class="form-control">
                                    <option>Corporate</option>
                                    <option>Franchise</option>
                                </select>
                                <div class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">                                
                                <label class="m-r-20">
                                    <input type="radio" checked="checked" value="" id="" name="optionsRadios" class="m-r-5">News
                                </label>
                                <label> 
                                    <input type="radio" checked="" value="1" id="" name="optionsRadios" class="m-r-5">Update 
                                </label>
                                <div class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Message</label>
                                <textarea class="form-control" placeholder="News" id="body" title="News" name="news[body]" required="" rows="5"></textarea>
                                <div class="errorNews text-danger"></div>
                            </div>
                        </div>
                        <hr class="hr-line-dashed"/>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>  
            </div><!-- Modal Body-->
        </div><!-- Modal content-->
    </div><!-- modal-dialog -->
</div><!-- #newsModal -->

