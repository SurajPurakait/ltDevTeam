<?php 
//foreach($record_details as $key=>$record){?>
<!--<h4 id="records_time" name='records_time'>Entry <= $key+1 .": " ?><= $record['record_time'] ?><a href="javascript:void(0)" onclick="delete_recoded_time(<= $record['id'] ?>,<= $record['bank_id'] ?>)"><span class="fa fa-times text-danger m-l-4"></span></a></h4>-->
<?php // } 
if(isset($bank_id) && $bank_id!=''){
 $record_detail = get_bookkeeping_records_details($bank_id); ?>
<a href="javascript:void(0)" id="time_modal" onclick="show_record_modal(<?= $bank_id ?>,'')" class="label label-success"><?= count($record_detail) ?></a>
<?php } ?>
