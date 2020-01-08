<?php
    if ($category == 'projects_by_office') {
?>
	<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Projects</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($projects_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_projects']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
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
	    <div class="col-md-2 m-t-40">
	    	<h4 class="text-center m-t-40">Offices</h4>
	        <?php 
	            foreach ($reports as $key => $value) {
	                $data_id = array_column($projects_list,'id');        
	                $data_total = array_column($projects_list,'total_projects');
	                $data = array_combine($data_id, $data_total);        
	        ?>
	        <div class="byoffice-projects-donut-<?= $key ?> text-center" data-size="100" id="byoffice_projects_donut_<?= $key ?>" data-json="byoffice_projects_data_<?= $key ?>"></div>
	        
	        <script>
	            var byoffice_projects_data_<?= $key ?> = [
	                {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
	                {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
	                {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
	                {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
	                {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
	                {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
	                {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
	                {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
	                {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
	                {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
	                {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
	                {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
	                {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
	                {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
	                {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
	                {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
	                {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
	                {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
	                {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
	                {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
	            ];                    
	        </script>
	        <script>
	             pieChart('byoffice-projects-donut-<?= $key ?>');
	        </script>
	        <?php
	             }
	        ?>

	        <h4 class="m-t-40 text-center">Tracking</h4>
		    <?php 
		        foreach ($reports as $key => $value) {
		            $new = array_sum(array_column($projects_list,'new'));
		            $started = array_sum(array_column($projects_list,'started')); 
		            $completed = array_sum(array_column($projects_list,'completed'));          
		    ?>
		    <div class="byoffice-tracking-donut-<?= $key ?> text-center" data-size="100" id="byoffice_tracking_donut_<?= $key ?>" data-json="byoffice_tracking_data_<?= $key ?>"></div>
		    
		    <script>
		        var byoffice_tracking_data_<?= $key ?> = [
		            {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
		            {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
		            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
		        ];                    
		    </script>
		    <script>
		         pieChart('byoffice-tracking-donut-<?= $key ?>');
		    </script>
		    <?php
		        }
		    ?>
	    </div>
    </div>    

<?php
    } elseif ($category == 'tasks_by_office') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total Tasks</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($projects_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['office_name']; ?></td>
	                    <td><?= $value['total_tasks']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
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
	    <div class="col-md-2 m-t-40">
	    	<h4 class="text-center m-t-40">Offices</h4>
	        <?php 
	            foreach ($reports as $key => $value) {
	                $data_id = array_column($projects_list,'id');        
	                $data_total = array_column($projects_list,'total_tasks');
	                $data = array_combine($data_id, $data_total);        
	        ?>
	        <div class="byoffice-tasks-donut-<?= $key ?> text-center" data-size="100" id="byoffice_tasks_donut_<?= $key ?>" data-json="byoffice_tasks_data_<?= $key ?>"></div>
	        
	        <script>
	            var byoffice_tasks_data_<?= $key ?> = [
	                {'section_label': 'Contador Fort Lauderdale ', 'value': <?= $data[34]; ?>, 'color': '#FFB046'}, 
	                {'section_label': 'Contador Miami ', 'value': <?= $data[1]; ?>, 'color': '#06a0d6'}, 
	                {'section_label': 'Contador Orlando', 'value': <?= $data[44]; ?>, 'color': '#ff8c1a'},
	                {'section_label': 'Contador Sunny Isles', 'value':<?= $data[18];?>, 'color': '#009900'},
	                {'section_label': 'Corporate', 'value':<?= $data[17];?>, 'color': '#663300'},
	                {'section_label': 'LeafNet Office', 'value':<?= $data[41];?>, 'color': '#ff66cc'},
	                {'section_label': 'Nalogi Miami', 'value':<?= $data[32];?>, 'color': '#ffdb4d'},
	                {'section_label': 'TaxLeaf Aventura', 'value':<?= $data[30];?>, 'color': '#00ff99'},
	                {'section_label': 'TaxLeaf Coral Gables', 'value':<?= $data[25];?>, 'color': '#99ff99'},
	                {'section_label': 'TaxLeaf Coral Springs', 'value':<?= $data[29];?>, 'color': '#669900'},
	                {'section_label': 'TaxLeaf Doral', 'value':<?= $data[22];?>, 'color': '#ffcc00'},
	                {'section_label': 'Taxleaf DSM', 'value':<?= $data[39];?>, 'color': '#99ff66'},
	                {'section_label': 'TaxLeaf Fort Lauderdale', 'value':<?= $data[26];?>, 'color': '#66ffff'},
	                {'section_label': 'TaxLeaf Hallandale', 'value':<?= $data[24];?>, 'color': '#ff8c66'},
	                {'section_label': 'TaxLeaf Hialeah', 'value':<?= $data[28];?>, 'color': '#e600ac'},
	                {'section_label': 'TaxLeaf Kendall', 'value':<?= $data[27];?>, 'color': '#aaaa55'},
	                {'section_label': 'TaxLeaf Lake Mary', 'value':<?= $data[31];?>, 'color': '#ff9900'},
	                {'section_label': 'TaxLeaf Miramar', 'value':<?= $data[23];?>, 'color': '#004de6'},
	                {'section_label': 'TaxLeaf North Miami Beach', 'value':<?= $data[19];?>, 'color': '#993333'},
	                {'section_label': 'TaxLeaf Pembroke Pines', 'value':<?= $data[20];?>, 'color': '#003300'}
	            ];                    
	        </script>
	        <script>
	             pieChart('byoffice-tasks-donut-<?= $key ?>');
	        </script>
	        <?php
	             }
	        ?>

	        <h4 class="m-t-40 text-center">Tracking</h4>
		    <?php 
		        foreach ($reports as $key => $value) {
		            $new = array_sum(array_column($projects_list,'new'));
		            $started = array_sum(array_column($projects_list,'started')); 
		            $completed = array_sum(array_column($projects_list,'completed'));          
		    ?>
		    <div class="byoffice-tracking-donut-<?= $key ?> text-center" data-size="100" id="byoffice_tracking_donut_<?= $key ?>" data-json="byoffice_tracking_data_<?= $key ?>"></div>
		    
		    <script>
		        var byoffice_tracking_data_<?= $key ?> = [
		            {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
		            {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
		            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
		        ];                    
		    </script>
		    <script>
		         pieChart('byoffice-tracking-donut-<?= $key ?>');
		    </script>
		    <?php
		        }
		    ?>
	    </div>
    </div>  

<?php
    } elseif ($category == 'projects_by_department') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total projectss</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($projects_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['department_name']; ?></td>
	                    <td><?= $value['total_projects']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
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
	    <div class="col-md-2 m-t-40">
	    	<h4 class="m-t-40 text-center">Department</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($projects_list,'id');        
                $data_total = array_column($projects_list,'total_projects');
                $data = array_combine($data_id,$data_total);        
            ?>
            <div class="bydepartment-projects-donut-<?= $key ?> text-center" data-size="100" id="bydepartment_projects_donut_<?= $key ?>" data-json="bydepartment_projects_data_<?= $key ?>"></div>
            
            <script>
                var bydepartment_projects_data_<?= $key ?> = [
                    {'section_label': 'Billing ', 'value': <?= $data[3]; ?>, 'color': '#cc6600'}, 
                    {'section_label': 'Payroll ', 'value': <?= $data[4]; ?>, 'color': '#06a0d6'}, 
                    {'section_label': 'Bookkeeping', 'value': <?= $data[5]; ?>, 'color': '#ff8c1a'},
                    {'section_label': 'Data', 'value':<?= $data[6];?>, 'color': '#009900'},
                    {'section_label': 'Franchisor', 'value':<?= $data[7];?>, 'color': '#663300'},
                    {'section_label': 'Government', 'value':<?= $data[8];?>, 'color': '#ff66cc'},
                    {'section_label': 'Marketing', 'value':<?= $data[10];?>, 'color': '#ffdb4d'},
                    {'section_label': 'Leafnet', 'value':<?= $data[11];?>, 'color': '#00ff99'},
                    {'section_label': 'Leafcloud', 'value':<?= $data[12];?>, 'color': '#99ff99'},
                    {'section_label': 'CPA ', 'value':<?= $data[13];?>, 'color': '#669900'},
                    {'section_label': 'Admin', 'value':<?= $data[14];?>, 'color': '#ffcc00'},
                ];                    
            </script>
            <script>
                 pieChart('bydepartment-projects-donut-<?= $key ?>');
            </script>
            <h4 class="m-t-40 text-center">Tracking</h4>
            <?php
                 }
            ?>
            <?php 
                foreach ($reports as $key => $value) {
                    $new = array_sum(array_column($projects_list,'new'));
		            $started = array_sum(array_column($projects_list,'started')); 
		            $completed = array_sum(array_column($projects_list,'completed'));          
            ?>
            <div class="bydepartment-tracking-donut-<?= $key ?> text-center" data-size="100" id="bydepartment_tracking_donut_<?= $key ?>" data-json="bydepartment_tracking_data_<?= $key ?>"></div>
            
            <script>
                var bydepartment_tracking_data_<?= $key ?> = [
                    {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
		            {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
		            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
                ];                    
            </script>
            <script>
                 pieChart('bydepartment-tracking-donut-<?= $key ?>');
            </script>
            <?php
                 }
            ?>
	    </div>
    </div>  

<?php
    } elseif ($category == 'projects_to_department') {
?>
		<div class="row">
	    <div class="col-md-10">
	        <table class="table table-bordered report-table table-striped text-center m-b-0">
	            <thead>
	                <tr>
	                    <th class="text-uppercase">Offices</th>
	                    <th class="text-uppercase">Total projectss</th>
	                    <th class="text-uppercase">% New</th>
	                    <th class="text-uppercase">% Started</th>
	                    <th class="text-uppercase">% Completed</th>
	                    <th class="text-uppercase">< 30 Days</th>
	                    <th class="text-uppercase">< 60 Days</th>
	                    <th class="text-uppercase">> 60 Days</th>
	                    <th class="text-uppercase">SOS</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                    foreach ($projects_list as $value) {
	                ?>
	                <tr>   
	                    <td><?= $value['department_name']; ?></td>
	                    <td><?= $value['total_projects']; ?></td>
	                    <td><?= $value['new']; ?></td>
	                    <td><?= $value['started']; ?></td>
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
	    <div class="col-md-2 m-t-40">
	    	<h4 class="m-t-40 text-center">Department</h4>
        <?php 
            foreach ($reports as $key => $value) {
                $data_id = array_column($projects_list,'id');        
                $data_total = array_column($projects_list,'total_projects');
                $data = array_combine($data_id,$data_total);        
            ?>
            <div class="todepartment-projects-donut-<?= $key ?> text-center" data-size="100" id="todepartment_projects_donut_<?= $key ?>" data-json="todepartment_projects_data_<?= $key ?>"></div>
            
            <script>
                var todepartment_projects_data_<?= $key ?> = [
                    {'section_label': 'Billing ', 'value': <?= $data[3]; ?>, 'color': '#cc6600'}, 
                    {'section_label': 'Payroll ', 'value': <?= $data[4]; ?>, 'color': '#06a0d6'}, 
                    {'section_label': 'Bookkeeping', 'value': <?= $data[5]; ?>, 'color': '#ff8c1a'},
                    {'section_label': 'Data', 'value':<?= $data[6];?>, 'color': '#009900'},
                    {'section_label': 'Franchisor', 'value':<?= $data[7];?>, 'color': '#663300'},
                    {'section_label': 'Government', 'value':<?= $data[8];?>, 'color': '#ff66cc'},
                    {'section_label': 'Marketing', 'value':<?= $data[10];?>, 'color': '#ffdb4d'},
                    {'section_label': 'Leafnet', 'value':<?= $data[11];?>, 'color': '#00ff99'},
                    {'section_label': 'Leafcloud', 'value':<?= $data[12];?>, 'color': '#99ff99'},
                    {'section_label': 'CPA ', 'value':<?= $data[13];?>, 'color': '#669900'},
                    {'section_label': 'Admin', 'value':<?= $data[14];?>, 'color': '#ffcc00'},
                ];                    
            </script>
            <script>
                 pieChart('todepartment-projects-donut-<?= $key ?>');
            </script>
            <h4 class="m-t-40 text-center">Tracking</h4>
            <?php
                 }
            ?>
            <?php 
                foreach ($reports as $key => $value) {
					$new = array_sum(array_column($projects_list,'new'));
		            $started = array_sum(array_column($projects_list,'started')); 
		            $completed = array_sum(array_column($projects_list,'completed'));          
            ?>
            <div class="todepartment-tracking-donut-<?= $key ?> text-center" data-size="100" id="todepartment_tracking_donut_<?= $key ?>" data-json="todepartment_tracking_data_<?= $key ?>"></div>
            
            <script>
                var todepartment_tracking_data_<?= $key ?> = [
                    {'section_label': 'New ', 'value': <?= $new; ?>, 'color': '#1c84c6'}, 
		            {'section_label': 'Started ', 'value': <?= $started; ?>, 'color': '#f8ac59'}, 
		            {'section_label': 'Completed', 'value': <?= $completed; ?>, 'color': '#1ab394'},
                ];                    
            </script>
            <script>
                 pieChart('todepartment-tracking-donut-<?= $key ?>');
            </script>
            <?php
                 }
            ?>
	    </div>
    </div>  

<?php
    }
?>