<?php
if(!empty($account_details)){
    foreach ($account_details as $val){ ?>
        <div class="row">
            <div class="col-md-4" style="padding-top:8px">
                <a class='btn btn-success' onclick="set_exist_account_details('<?= $val['bank_name'] ?>','<?= $val['ban_account_number'] ?>','<?= $val['bank_routing_number'] ?>')">
                    <b>Bank Name: </b><?= $val['bank_name'] ?><br>
                    <b>Account Number: </b><?= $val['ban_account_number'] ?><br>
                    <b>Routing Number: </b><?= $val['bank_routing_number'] ?><br>
                </a>
            </div>
        </div>
    <?php }
}