<?php //print_r($all_list); exit;           ?>
<div class="">
    <table id="service-tab" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Language</th>
                <th>Transaction Id</th>
                <th>Purchased By</th>
                <th>Office</th>
                <th>Purchased On</th>
                <th>Note</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($all_list) && count($all_list) > 0) {
                foreach ($all_list as $sl) {
                    $staff_info = staff_info_by_id($sl['purchased_by']);
                    if ($sl['status'] == 1) {
                        $status = 'Not Started';
                    } elseif ($sl['status'] == 2) {
                        $status = 'Started';
                    } else {
                        $status = 'Completed';
                    }
                    if($sl['language']==1){
                        $lang = 'English';
                    }elseif($sl['language']==2){
                        $lang = 'Spanish';
                    }else{
                       $lang = 'Portuguese'; 
                    }
                    ?>
                    <tr>
                        <td><?= $sl['title']; ?></td>
                        <td><?= $sl['price']; ?></td>
                        <td><?= $sl['quantity']; ?></td>
                        <th><?= $lang; ?></th>
                        <td><?= $sl['transaction_id']; ?></td>
                        <td><?= $staff_info['last_name'] . ', ' . $staff_info['first_name']; ?></td>
                        <td><?= staff_office_name($sl['purchased_by']); ?></td>
                        <td><?= date('d-m-Y', strtotime($sl['purchased_on'])); ?></td>
                        <td><a href="javascript:void(0);" onclick="add_note_cart('<?= $sl['cart_id']; ?>')" class="text-success"><i class="fa fa-lg fa-file-text-o"></i></a></td>
                        <td>
                            <?php
                            $user_info = staff_info();
                            if ($user_info['type'] == 1 || ($user_info['department'] == 9 && $user_info['role'] == 4)) {
                                ?>
                                <a href='javascript:void(0);' onclick='change_purchase_status(<?= $sl['id']; ?>,<?= $sl['status']; ?>);'>
                                    <span class='label label-primary label-block' style="width: 80px;"><?= $status; ?></span>
                                </a>  
                            <?php } else { ?>
                                <a href='javascript:void(0);'>
                                    <span class='label label-primary label-block' style="width: 80px;"><?= $status; ?></span>
                                </a>  
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><th colspan="8">No Data Found</th></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="showNotes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Notes</h4>
            </div>
            <div id="notes-modal-body" class="modal-body p-b-0"></div>
            <div class="modal-body p-t-0 text-right">
                <!-- <button onclick="document.getElementById('update_modal_form').submit();this.disabled = true;this.innerHTML = 'Processing...';" type="submit" class="btn btn-primary">Update Note</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($all_list) && count($all_list) > 0 && $all_list != 0) { ?>
            if ($('#service-tab').length > 0) {
                $("#service-tab").dataTable();
            }
<?php } ?>
    });
    function add_note_cart(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>' + 'modal/add_note_cart',
            data: {
                id: id
            },
            success: function (result) {
                $('#showNotes #notes-modal-body').html(result);
                $("#showNotes #cartid").val(id);
                openModal('showNotes');
            }
        });
    }
</script>