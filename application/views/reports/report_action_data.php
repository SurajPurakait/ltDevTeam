<?php
    if ($category == 'action_by_office') {
?>
	<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Actions</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Resolved</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($action_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_actions']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
	                    <td><?= $value['resolved']; ?></td>
	                    <td><?= $value['completed']; ?></td>
	                    <td><?= $value['less_then_30']; ?></td>
	                    <td><?= $value['less_then_60']; ?></td>
	                    <td><?= $value['more_then_60']; ?></td>
	                    <td><?= $value['sos']; ?></td>
	                </tr>
	                <?php 
	                    }
	                ?>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-md-2">
	    	
	    </div>
    </div>    

<?php
    } elseif ($category == 'action_to_office') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Actions</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Resolved</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($action_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_actions']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
	                    <td><?= $value['resolved']; ?></td>
	                    <td><?= $value['completed']; ?></td>
	                    <td><?= $value['less_then_30']; ?></td>
	                    <td><?= $value['less_then_60']; ?></td>
	                    <td><?= $value['more_then_60']; ?></td>
	                    <td><?= $value['sos']; ?></td>
	                </tr>
	                <?php 
	                    }
	                ?>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-md-2">
	    	
	    </div>
    </div>  

<?php
    } elseif ($category == 'action_by_department') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Actions</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Resolved</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($action_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_actions']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
	                    <td><?= $value['resolved']; ?></td>
	                    <td><?= $value['completed']; ?></td>
	                    <td><?= $value['less_then_30']; ?></td>
	                    <td><?= $value['less_then_60']; ?></td>
	                    <td><?= $value['more_then_60']; ?></td>
	                    <td><?= $value['sos']; ?></td>
	                </tr>
	                <?php 
	                    }
	                ?>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-md-2">
	    	
	    </div>
    </div>  

<?php
    } elseif ($category == 'action_to_department') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Actions</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Resolved</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($action_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_actions']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
	                    <td><?= $value['resolved']; ?></td>
	                    <td><?= $value['completed']; ?></td>
	                    <td><?= $value['less_then_30']; ?></td>
	                    <td><?= $value['less_then_60']; ?></td>
	                    <td><?= $value['more_then_60']; ?></td>
	                    <td><?= $value['sos']; ?></td>
	                </tr>
	                <?php 
	                    }
	                ?>
	            </tbody>
	        </table>
	    </div>
	    <div class="col-md-2">
	    	
	    </div>
    </div>  

<?php
    }
?>