<?php

$servername = "localhost";
$username = "leafnet_db_user";
$password = "leafnet@123";
$db = 'leafnet_staging';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo "Connected successfully"; 
$sql = 'SELECT * from lead_management where type="1" OR type="3"';
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($ld = mysqli_fetch_array($result)) {
            if ($ld['status'] == 3) {
                $ofc_deatils_sql = 'SELECT * from office where id="' . $ld['office'] . '"';
                $office_details = mysqli_query($conn,$ofc_deatils_sql);
                $office_info = mysqli_fetch_assoc($office_details);

                $current_datetime = strtotime(date('Y-m-d'));
                $submisstion_datetime = strtotime($ld['submission_date']);
                $datediff = $current_datetime - $submisstion_datetime;
                $days = round($datediff / (60 * 60 * 24));
                $staff_by = $ld['staff_requested_by'];
                $staff_sql = 'SELECT * from staff where id="' . $staff_by . '"';
                $staff_sql_result = mysqli_query($conn, $staff_sql);
                if (mysqli_num_rows($staff_sql_result) > 0) {
                    while ($row = mysqli_fetch_array($staff_sql_result)) {
                        $from = $row['user'];
                        $from_name = $row['last_name'] . ', ' . $row['first_name'];
                    }
                }
                if ($days == 3) {
                    /* mail section */
                    $lead_type = $ld['type'];
                    $language = $ld['language'];
                    if ($lead_type == '1') {
                        $email_content_sql = 'SELECT * from lead_mail_chain where lead_type="1" and language="' . $language . '" and type=2';
                    } elseif ($lead_type == '3') {
                        $email_content_sql = 'SELECT * from lead_mail_chain where lead_type="2" and language="' . $language . '" and type=2';
                    }

                    $email_content_sql_result = mysqli_query($conn, $email_content_sql);
                    if (mysqli_num_rows($email_content_sql_result) > 0) {
                        while ($rowval = mysqli_fetch_array($email_content_sql_result)) {
                            $email_subject = $rowval['subject'];
                            $email_body = urldecode($rowval['body']);
                            // Set veriables --- #name, #type, #lead_type, #company, #phone, #email, #requested_by, #staff_office, #staff_phone, #staff_email, #first_contact_date, #lead_source, #source_detail, #office_name, #office_address, #office_phone_number
                            $contact_type = 'Unknown';
                            $contact_type_query = mysqli_query($conn, 'SELECT * FROM ' . (($ld['type'] == 1) ? '`type_of_contact_prospect`' : '`type_of_contact_referral`') . ' WHERE `id` = ' . $ld['type_of_contact']);
                            if (mysqli_num_rows($contact_type_query) > 0) {
                                $contact_type_result = mysqli_fetch_array($contact_type_query);
                                $contact_type = $contact_type_result['name'];
                            }
                            if ($ld['type'] == '1') {
                                $lead_type_query = mysqli_query($conn, 'SELECT * FROM lead_type WHERE `id` = "1"');    
                            } elseif ($ld['type'] == '3') {
                                $lead_type_query = mysqli_query($conn, 'SELECT * FROM lead_type WHERE `id` = "2"');
                            }
                            if (mysqli_num_rows($lead_type_query) > 0) {
                                $lead_type_result = mysqli_fetch_array($lead_type_query);
                                $lead_type = $lead_type_result['type'];
                            }
                            if ($ld['type'] == '1') {  
                                $lead_type_name = 'Client Lead';
                            } elseif ($ld['type'] == '3') {
                                $lead_type_name = 'Partner Lead';
                            }

                            $lead_source = '';
                            if ($ld['lead_source'] != '') {
                                $lead_source_query = mysqli_query($conn, 'SELECT * FROM `lead_prospect` WHERE `id` = ' . $ld['lead_source']);
                                if (mysqli_num_rows($lead_source_query) > 0) {
                                    $lead_source_result = mysqli_fetch_array($lead_source_query);
                                    $lead_source = $lead_source_result['name'];
                                }
                            }
                            $staff_query = mysqli_query($conn, 'SELECT staff.*, (SELECT GROUP_CONCAT(`office`.`name`) FROM `office` WHERE `office`.`id` IN (SELECT `office_staff`.`office_id` FROM `office_staff` WHERE `office_staff`.`staff_id` = `staff`.`id`)) AS staff_office FROM `staff` WHERE `id` = ' . $ld['staff_requested_by']);
                            $staff_result = mysqli_fetch_array($staff_query);
                            $veriable_array = [
                                'name' => $ld['first_name'],
                                'type' => $lead_type,
                                'company' => $ld['company_name'],
                                'phone' => $ld['phone1'],
                                'email' => $ld['email'],
                                'staff_name' => $staff_result['last_name'] . ', ' . $staff_result['first_name'] . ' ' . $staff_result['middle_name'],
                                'staff_office' => $staff_result['staff_office'],
                                'staff_phone' => $staff_result['phone'],
                                'staff_email' => $staff_result['user'],
                                'first_contact_date' => ($ld['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($ld['date_of_first_contact'])) : '',
                                'lead_source' => $lead_source,
                                'source_detail' => $ld['lead_source_detail'],
                                'lead_type' => $lead_type_name,
                                'office_phone_number' => $office_info['phone'],
                                'office_address' => $office_info['address'],
                                'office_name' => $office_info['name'],
                                'requested_by' => $staff_result['last_name'] . ', ' . $staff_result['first_name']
                            ];
                            foreach ($veriable_array as $index => $value) {
                                if ($value != '') {
                                    $email_body = str_replace('#' . $index, $value, $email_body);
                                    $email_subject = str_replace('#' . $index, $value, $email_subject);
                                }
                            }

                            $user_logo = "";
                            if ($ld['office'] != 0) {
                                $ofc_sql = 'SELECT * from office where id="' . $ld['office'] . '"';
                                $ofc_sql_result = mysqli_query($conn, $ofc_sql);
                                if (mysqli_num_rows($ofc_sql_result) > 0) {
                                    while ($rowofc = mysqli_fetch_array($ofc_sql_result)) {
                                        $user_logo = $rowofc['photo'];
                                    }
                                }
                            }

                            if ($user_logo != "" && !file_exists('https://leafnet.us/uploads/' . $user_logo)) {
                                $user_logo_fullpath = 'https://leafnet.us/uploads/' . $user_logo;
                            } else {
                                $user_logo_fullpath = 'https://leafnet.us/assets/img/logo_mail.png';
                            }

                            if ($ld['office'] == 1 || $ld['office'] == 18 || $ld['office'] == 34) {
                                $bgcolor = '#00aec8';
                                $divider_img = 'https://leafnet.us/assets/img/divider-blue.jpg';
                            } else {
                                $bgcolor = '#8ab645';
                                $divider_img = 'http://www.taxleaf.com/Email/divider2.gif';
                            }
                        }
                    }
                    $user_email = $ld['email'];
                    $user_name = $ld["first_name"] . ' ' . $ld["last_name"];
                    $message = '
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>TAXLEAF</title>
                                <style type="text/css">
                                    body {
                                        background-color: #FFFFFF;
                                        margin-left: 0px;
                                        margin-top: 0px;
                                        margin-right: 0px;
                                        margin-bottom: 0px;
                                    }
                                    .textoblanco {
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size: 12px;
                                        color: #000;
                                    }
                                    .textoblanco {
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size: 12px;
                                        color: #FFF;
                                    }
                                    .textonegro {
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size: 12px;
                                        color: #000;
                                    }
                                </style>
                            </head>
                            <body>
                                <br />
                                <table width="600" border="0" bgcolor="' . $bgcolor . '" align="center" cellpadding="0" cellspacing="10">
                                    <tr>
                                        <td>
                                            <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><img src="' . $user_logo_fullpath . '" width="300" height="98" /></td>
                                                </tr>
                                            </table>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td><img src="' . $divider_img . '" width="600" height="30" /></td>
                                                </tr>
                                            </table>
                                            <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
                                                <tr>
                                                    <td valign="top" style="color:#000;" class="textoblanco">
                                                        <p>
                                                            <span class="textonegro"><strong>Dear ' . $user_name . ',<br /><br /></strong>' . $email_body . '</span>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="100" valign="top">&nbsp;</td>
                                    </tr>
                                </table>
                                <br />
                            </body>
                        </html>';
// Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
// More headers
                    $headers .= 'From: "' . $from_name . '" <' . $from . '>' . "\r\n";
                    $headers .= 'Reply-To: "' . $from_name . '" <' . $from . '>' . "\r\n";
                    if (mail($user_email, $email_subject, $message, $headers)) {
                        //mysqli_query($conn, "UPDATE `lead_mail_chain` SET `submission_date` = '" . date('Y-m-d') . "' WHERE `lead_mail_chain`.`id` = '{$rowval['id']}'");
                        mysqli_query($conn, "UPDATE `lead_management` SET `day_3_mail_date` = '" . date('Y-m-d') . "' WHERE `lead_management`.`id` = '{$ld['id']}'");
                    }
                    /* mail section */
                } elseif ($days == 6) {
                    /* mail section */

                    $lead_type = $ld['type'];
                    $language = $ld['language'];
                    if ($lead_type == '1') {
                        $email_content_sql = 'SELECT * from lead_mail_chain where lead_type="1" and language="' . $language . '" and type=3';
                    } elseif ($lead_type == '3') {
                        $email_content_sql = 'SELECT * from lead_mail_chain where lead_type="2" and language="' . $language . '" and type=3';
                    }

                    $email_content_sql_result = mysqli_query($conn, $email_content_sql);
                    if (mysqli_num_rows($email_content_sql_result) > 0) {
                        while ($rowval = mysqli_fetch_array($email_content_sql_result)) {
                            $email_subject = $rowval['subject'];
                            $email_body = urldecode($rowval['body']);
                            // Set veriables --- #name, #type,, #lead_type, #company, #phone, #email, #requested_by, #staff_office, #staff_phone, #staff_email, #first_contact_date, #lead_source, #source_detail,, #office_name, #office_address, #office_phone_number
                            $contact_type = 'Unknown';
                            $contact_type_query = mysqli_query($conn, 'SELECT * FROM ' . ($ld['type'] == 1 ? '`type_of_contact_prospect`' : '`type_of_contact_referral`') . ' WHERE `id` = ' . $ld['type_of_contact']);
                            if (mysqli_num_rows($contact_type_query) > 0) {
                                $contact_type_result = mysqli_fetch_array($contact_type_query);
                                $contact_type = $contact_type_result['name'];
                            }

                            if ($ld['type'] == '1') {
                                $lead_type_query = mysqli_query($conn, 'SELECT * FROM lead_type WHERE `id` = "1"');    
                            } elseif ($ld['type'] == '3') {
                                $lead_type_query = mysqli_query($conn, 'SELECT * FROM lead_type WHERE `id` = "2"');
                            }
                            if (mysqli_num_rows($lead_type_query) > 0) {
                                $lead_type_result = mysqli_fetch_array($lead_type_query);
                                $lead_type = $lead_type_result['type'];
                            }
                            if ($ld['type'] == '1') {  
                                $lead_type_name = 'Client Lead';
                            } elseif ($ld['type'] == '3') {
                                $lead_type_name = 'Partner Lead';
                            }

                            $lead_source = '';
                            if ($ld['lead_source'] != '') {
                                $lead_source_query = mysqli_query($conn, 'SELECT * FROM `lead_prospect` WHERE `id` = ' . $ld['lead_source']);
                                if (mysqli_num_rows($lead_source_query) > 0) {
                                    $lead_source_result = mysqli_fetch_array($lead_source_query);
                                    $lead_source = $lead_source_result['name'];
                                }
                            }
                            $staff_query = mysqli_query($conn, 'SELECT staff.*, (SELECT GROUP_CONCAT(`office`.`name`) FROM `office` WHERE `office`.`id` IN (SELECT `office_staff`.`office_id` FROM `office_staff` WHERE `office_staff`.`staff_id` = `staff`.`id`)) AS staff_office FROM `staff` WHERE `id` = ' . $ld['staff_requested_by']);
                            $staff_result = mysqli_fetch_array($staff_query);
                            $veriable_array = [
                                'name' => $ld['first_name'],
                                'type' => $lead_type,
                                'company' => $ld['company_name'],
                                'phone' => $ld['phone1'],
                                'email' => $ld['email'],
                                'staff_name' => $staff_result['last_name'] . ', ' . $staff_result['first_name'] . ' ' . $staff_result['middle_name'],
                                'staff_office' => $staff_result['staff_office'],
                                'staff_phone' => $staff_result['phone'],
                                'staff_email' => $staff_result['user'],
                                'first_contact_date' => ($ld['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($ld['date_of_first_contact'])) : '',
                                'lead_source' => $lead_source,
                                'source_detail' => $ld['lead_source_detail'],
                                'lead_type' => $lead_type_name,
                                'office_phone_number' => $office_info['phone'],
                                'office_address' => $office_info['address'],
                                'office_name' => $office_info['name'],
                                'requested_by' => $staff_result['last_name'] . ', ' . $staff_result['first_name']
                            ];
                            foreach ($veriable_array as $index => $value) {
                                if ($value != '') {
                                    $email_body = str_replace('#' . $index, $value, $email_body);
                                    $email_subject = str_replace('#' . $index, $value, $email_subject);
                                }
                            }
                            $user_logo = "";
                            if ($ld['office'] != 0) {
                                $ofc_sql = 'SELECT * from office where id="' . $ld['office'] . '"';
                                $ofc_sql_result = mysqli_query($conn, $ofc_sql);
                                if (mysqli_num_rows($ofc_sql_result) > 0) {
                                    while ($rowofc = mysqli_fetch_array($ofc_sql_result)) {
                                        $user_logo = $rowofc['photo'];
                                    }
                                }
                            }

                            if ($user_logo != "" && !file_exists('https://leafnet.us/uploads/' . $user_logo)) {
                                $user_logo_fullpath = 'https://leafnet.us/uploads/' . $user_logo;
                            } else {
                                $user_logo_fullpath = 'https://leafnet.us/assets/img/logo_mail.png';
                            }
                            if ($ld['office'] == 1 || $ld['office'] == 18 || $ld['office'] == 34) {
                                $bgcolor = '#00aec8';
                                $divider_img = 'https://leafnet.us/assets/img/divider-blue.jpg';
                            } else {
                                $bgcolor = '#8ab645';
                                $divider_img = 'http://www.taxleaf.com/Email/divider2.gif';
                            }
                        }
                    }
                    $user_email = $ld['email'];
                    $user_name = $ld["first_name"] . ' ' . $ld["last_name"];
                    $message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>TAXLEAF</title>
        <style type="text/css">
            body {
                background-color: #FFFFFF;
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
            }
            .textoblanco {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #000;
            }
            .textoblanco {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #FFF;
            }
            .textonegro {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #000;
            }
        </style>
    </head>
    <body>
        <br />
        <table width="600" border="0" bgcolor="' . $bgcolor . '" align="center" cellpadding="0" cellspacing="10">
            <tr>
                <td>
                    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><img src="' . $user_logo_fullpath . '" width="300" height="98" /></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><img src="' . $divider_img . '" width="600" height="30" /></td>
                        </tr>
                    </table>
                    <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
                        <tr>
                            <td valign="top" style="color:#000;" class="textoblanco">
                                <p><span class="textonegro"><strong>Dear ' . $user_name . ',<br /><br /></strong>' . $email_body . '</span></p>
                            </td>
                        </tr>
                    </table>     
                </td>
            </tr>
            <tr>
                <td height="100" valign="top">&nbsp;</td>
            </tr>
        </table>
        <br />
    </body>
</html>';
// Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
// More headers
                    $headers .= 'From: "' . $from_name . '" <' . $from . '>' . "\r\n";
                    $headers .= 'Reply-To: "' . $from_name . '" <' . $from . '>' . "\r\n";
                    if (mail($user_email, $email_subject, $message, $headers)) {
                        //mysqli_query($conn, "UPDATE `lead_mail_chain` SET `submission_date` = '" . date('Y-m-d') . "' WHERE `lead_mail_chain`.`id` = '{$rowval['id']}'");
                        mysqli_query($conn, "UPDATE `lead_management` SET `day_6_mail_date` = '" . date('Y-m-d') . "' WHERE `lead_management`.`id` = '{$ld['id']}'");
                    }
                    /* mail section */
                    $updatesql = "update `lead_management` SET `status` = '2', `mail_campaign_status` = '0', `inactive_date` = '" . date('Y-m-d') . "' WHERE `lead_management`.`id` = " . $ld['id'] . "";
                    mysqli_query($conn, $updatesql);
                    $insertlogsql = "INSERT INTO `tracking_logs` (`id`, `stuff_id`, `status_value`, `section_id`, `related_table_name`) VALUES ('', '4', '2', '" . $ld['id'] . "', 'lead_management')";
                    mysqli_query($conn, $insertlogsql);
                }
            }
        }
    }
}
mysqli_close($conn);
?>