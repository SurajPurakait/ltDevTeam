<?php if(isset($record_details) && !empty($record_details)){?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Recoded Time List</h5>
        </button>
      </div>
      <div class="modal-body">
          <?php 
        foreach($record_details as $key=>$record){?>
        <h4 id="records_time" name='records_time'>Entry <?= $key+1 .": " ?><?= $record['record_time'] ?><a href="javascript:void(0)" onclick="delete_recoded_time(<?= $record['id'] ?>,<?= $record['bank_id'] ?>)"><span class="fa fa-times text-danger m-l-4"></span></a></h4>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="close_recoded_modal(<?= $record['bank_id'];?>,'<?= $section ?>')">Close</button>
      </div>
    </div>
  </div>
<?php } ?>
