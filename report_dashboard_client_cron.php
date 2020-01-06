<?php
    $servername = "localhost";
    $username = "leafnet_db_user";
    $password = "leafnet@123";
    $db = 'leafnet_stagings';
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = 'leafnet';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    mysqli_query($conn,'TRUNCATE `report_client`');

    /* inserting data for individual client*/
    $select = [
        '`ind`.id',
        '`int`.reference',
        '`ind`.country_residence',
        '`ind`.status',
        '`int`.office',
        '`int`.id as internal_data_id',
        '`int`.reference',
        '`int`.practice_id',
        '`ofc`.id as office',
        '`ofc`.office_id',
        '(SELECT country_name FROM countries c WHERE c.id = ind.country_residence) as country_residence_name'
    ];
    
    //condition
    $where['`ind`.first_name'] = '`ind`.`first_name` IS NOT NULL ';
    $where['`ind`.last_name'] = 'AND `ind`.`last_name` IS NOT NULL ';
    $where['`ind`.status'] = 'AND `ind`.`status` NOT IN ("0","3") ';

    //tables
    $table = '`individual` AS `ind` INNER JOIN `internal_data` AS `int` ON `int`.reference_id = `ind`.id and `int`.reference="individual" INNER JOIN `office` AS `ofc` ON `ofc`.id = `int`.office';
    
    $ind_query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' WHERE ' . implode('', $where)  . 'GROUP BY ind.id';
    // echo $ind_query;exit;
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');    
    $report_client_query = mysqli_query($conn,$ind_query);
    $report_client_result = mysqli_fetch_assoc($report_client_query);

    if (!empty($report_client_result)) {
        while ($rcr = mysqli_fetch_assoc($report_client_query)) {
            // Collecting Data for Report Client Table
            $type = $rcr['reference'];
            $client_id = $rcr['practice_id'];
            $status = $rcr['status'];
            if (isset($rcr['country_residence']) && $rcr['country_residence'] != '') {
                $country_residence = $rcr['country_residence'];
            }else {
                $country_residence = NULL;
            }

            if (isset($rcr['country_residence_name']) && $rcr['country_residence_name'] != '') {
                $country_residence_name = $rcr['country_residence_name'];
            }else {
                $country_residence_name = NULL;
            }

             
            $office = $rcr['office'];
            $office_id = $rcr['office_id'];

       
            $ind_insert_sql = "INSERT INTO `report_client`(`type`, `client_id`, `status`, `country_residence`,`country_residence_name`,`office`, `office_id`) VALUES ('$type','$client_id','$status','$country_residence','$country_residence_name','$office','$office_id')";
            echo $ind_insert_sql;
            echo "<hr>";
            mysqli_query($conn,$ind_insert_sql)or die('Error : Insert Error');    
            }
        }
    

    /* inserting data for business client */
    $select_b = [
        '`com`.id',
        '`int`.reference',
        '`com`.status',
        '`int`.office',
        '`int`.id as internal_data_id',
        '`int`.reference',
        '`int`.practice_id',
        '`ofc`.id as office',
        '`ofc`.office_id',
        '(SELECT type FROM company_type ct WHERE ct.id = com.type) as type_of_company'
    ];
    //condition
    $where_b['`com`.status'] = '`com`.`status` NOT IN ("0","3") ';

    //tables
    $table_b = '`company` AS `com` INNER JOIN `internal_data` AS `int` ON `int`.reference_id = `com`.id and `int`.reference="company" INNER JOIN `office` AS `ofc` ON `ofc`.id = `int`.office';
 
    $bus_query = 'SELECT ' . implode(', ', $select_b) . ' FROM ' . $table_b . ' WHERE ' . implode('', $where_b)  . 'GROUP BY com.id';
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $report_client_query_b = mysqli_query($conn,$bus_query);
    $report_client_result_b = mysqli_fetch_assoc($report_client_query_b);
        
    if (!empty($report_client_result_b)) {
        while ($rcrb = mysqli_fetch_assoc($report_client_query_b)) {
            // Collecting Data for Report Client Table
            $type_b = $rcrb['reference'];
            $client_id_b = $rcrb['practice_id'];
            $status_b = $rcrb['status'];
            $type_of_company_b = $rcrb['type_of_company']; 
            $office_id_b = $rcrb['office_id'];
            $office_b = $rcrb['office'];

            $bus_insert_sql_b = "INSERT INTO `report_client`(`type`, `client_id`, `status`, `type_of_company` ,`office` ,`office_id`) VALUES ('$type_b','$client_id_b','$status_b','$type_of_company_b','$office_b','$office_id_b')";
            echo $bus_insert_sql_b;
            echo "<hr>";
            mysqli_query($conn,$bus_insert_sql_b)or die('Error : Insert Error');                
        }
    }

    echo "Success"    
?>