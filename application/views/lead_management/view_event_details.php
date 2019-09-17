<div class="wrapper wrapper-content">
    <div class="m-b-40">
        <form>
            <div class="tabs-container">                   
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-link active"><a href="#lead_general_info" aria-controls="general-info" role="tab" data-toggle="tab">EVENT DETAILS</a></li>               
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="lead_general_info"> 
                        <div class="panel-body">
                            <?php $style = 'style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;"'; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <b style="font-size: 14px;" <?= $style; ?>>Office:</b>
                                            </td>
                                            <td>
                                                <?php  
                                                    $office = get_office_info_by_id($events_list['office_id']);
                                                    echo $office['name'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Event Type:</b>
                                            </td>
                                            <td>
                                                <?= $events_list['event_type'] ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Event Name:</b>
                                            </td>
                                            <td>
                                                <?= $events_list['event_name'] ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Description:</b>
                                            </td>
                                            <td>
                                                <?= $events_list['description'] ;?>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">City:</b>
                                            </td>
                                            <td>
                                                <?= $events_list['location'] ;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" <?= $style; ?>>
                                                <b style="font-size: 14px;">Date Of Event:</b>
                                            </td>
                                            <td>
                                                <?php 
                                                    if($events_list['event_date'] == '0000-00-00'){
                                                        echo "N/A";
                                                    }else{
                                                        echo date('m/d/Y',strtotime($events_list['event_date']));
                                                    }
                                                    ;?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
