<?php
	
?>
<table class="table">
	<?php
        if ($attachments_list) {
        	$all_list = array();
            foreach ($attachments_list as $data) {
        	array_push($all_list, $data['document']);

    ?>
    	<tr>
    		<td><a href="<?= base_url('/uploads/') . $data['document']; ?>"><?= $data['document'] ;?></a>
    		</td>
    	</tr>
    <?php
		}
	?>
	<tr>	
    		<td>
    			<form name="download_form" method="POST" action="<?= base_url('services/home/download_zip'); ?>">
                    <input type="hidden" id="filesarray" name="filesarray" value="<?= implode(',', $all_list); ?>">
                    <button class="btn btn-info m-t-10" type="submit"><i class="fa fa-download"></i> Download All Files</button>
                </form>
            </td>
    	</tr>
	<?php		
		}else{
	?>

		<tr>
			<td>No documents found</td>
		</tr>	
	<?php		
		}	    
    ?>            
</table>