<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <a class="btn btn-success btn-xs" id="add_staff" onclick="show_partner_service_modal('add', '');"
                   href="javascript:void(0);"><i class="fa fa-plus"></i> Add New Partner Service</a>
                <div class="ibox-content m-t-10">
                    <div class="" id="service-tab-setup-wrap">
                        <table id="partner-service-tab" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap;">Service Category</th>
                            <th style="white-space: nowrap;">Service Name</th>
                            <th style="white-space: nowrap;">Responsible</th>
                            <th style="white-space: nowrap;">Input Form</th>
                            <th style="white-space: nowrap;">Days To Start</th>
                            <th style="white-space: nowrap;">Days To Complete</th>
                            <th style="white-space: nowrap;">Fixed Cost</th>
                            <th style="white-space: nowrap;">Retail Price</th>
                            <th style="white-space: nowrap;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="partner-service-form-modal" class="modal fade" aria-hidden="true" style="display: none;"></div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php //if (isset($service_list) && count($service_list) > 0) { ?>
        if ($('#partner-service-tab').length > 0) {
            $("#partner-service-tab").dataTable({
                "scrollX": true
            });
            //$('.col-md-6').addClass('pull-left');
            // $('.dataTables_length').parent('.col-md-6').addClass('length-short-box');
            // $('.dataTables_filter').parent('.col-md-6').addClass('filter-search-box');
        }
        <?php 
    // } 
    ?>
    });
</script>