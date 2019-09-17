<?php

$servername = "localhost";
$username = "leafnet_db";
$password = "leafnet@123";
$db = 'leafnet_dev2_new';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo "Connected successfully"; 
$sql_mail = 'SELECT * from lead_mail where schedule_date="' . date('Y-m-d') . '"';
if ($result_mail = mysqli_query($conn, $sql_mail)) {
    if (mysqli_num_rows($result_mail) > 0) {
        while ($row = mysqli_fetch_array($result_mail)) {
            $email_subject = $row['subject'];
            $body = urldecode($row['body']);
            $sql = 'SELECT * from lead_management where status = 2';
            if ($result = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    while ($ld = mysqli_fetch_array($result)) { /* mail section */
                        $user_email = $ld['email'];
                        // Set veriables --- #name, #type, #company, #phone, #email, #requested_by, #staff_office, #staff_phone, #staff_email, #first_contact_date, #lead_source, #lead_source_detail
                        $contact_type = 'Unknown';
                        $contact_type_query = mysqli_query($conn, 'SELECT * FROM ' . ($ld['type'] == 1 ? '`type_of_contact_prospect`' : '`type_of_contact_referral`') . ' WHERE `id` = ' . $ld['type_of_contact']);
                        if (mysqli_num_rows($contact_type_query) > 0) {
                            $contact_type_result = mysqli_fetch_array($contact_type_query);
                            $contact_type = $contact_type_result['name'];
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
                            'type_of_contact' => $contact_type,
                            'company_name' => $ld['company_name'],
                            'phone' => $ld['phone1'],
                            'email' => $ld['email'],
                            'staff_name' => $staff_result['last_name'] . ', ' . $staff_result['first_name'] . ' ' . $staff_result['middle_name'],
                            'staff_office' => $staff_result['staff_office'],
                            'staff_phone' => $staff_result['phone'],
                            'staff_email' => $staff_result['user'],
                            'date_first_contact' => ($lb['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($lb['date_of_first_contact'])) : '',
                            'lead_source' => $lead_source,
                            'lead_source_detail' => $lb['lead_source_detail']
                        ];
                        foreach ($veriable_array as $index => $value) {
                            if ($value != '') {
                                $body = str_replace('#' . $index, $value, $body);
                                $email_subject = str_replace('#' . $index, $value, $email_subject);
                            }
                        }
                        $user_name = $ld['last_name'] . ', ' . $ld['first_name'];
                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        // More headers
                        $headers .= 'From: <codetestml0016@gmail.com>' . "\r\n";
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
                                    <table width="600" border="0" bgcolor="#8ab645" align="center" cellpadding="0" cellspacing="10">
                                        <tr>
                                            <td>
                                                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td><img src="http://www.taxleaf.com/Email/header.gif" width="600" height="98" /></td>
                                                    </tr>
                                                </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td><img src="http://www.taxleaf.com/Email/divider2.gif" width="600" height="30" /></td>
                                                    </tr>
                                                </table>
                                                <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
                                                    <tr>
                                                        <td valign="top" class="textoblanco">
                                                            <p><span class="textonegro"><strong>Dear ' . $user_name . ',<br /><br /></strong>' . $body . '</span></p>
                                                            <p><span class="textonegro">Sincerely,</span></p>
                                                            <p>
                                                                <span class="textonegro">Moses Nae<br />
                                                                    moses@taxleaf.com<br />
                                                                    305-541-3980<br />
                                                                    815-550-1294<br />
                                                                </span><br />
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" height="10px">
                                                    <tr>
                                                        <td bgcolor="#608f0f" height="5"><img src="img/pixel.gif" width="1" height="1" /></td>
                                                    </tr>
                                                </table>
                                                <table width="100%" border="0" cellspacing="15" cellpadding="4">
                                                    <tr>
                                                        <td width="51%" height="45" class="textoblanco" align="center">
                                                            <a href="https://www.websitealive3.com/12709/visitor/window/?code_id=761&dl"><img src="http://www.taxleaf.com/Email/chat-now.gif" width="155" height="60" alt="Chat Now" style="cursor:pointer" border="0" /></a><br />
                                                        </td>
                                                        <td width="49%" align="left">
                                                            <p class="textoblanco">
                                                                <strong>VISIT US:</strong><br />
                                                                <a href="http://www.contadormiami.com" title="HOME" target="_blank" class="textoblanco">HOME</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="http://contadormiami.com/es/productos-y-servicios/" title="SERVICES" target="_blank" class="textoblanco">SERVICES</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a href="http://contadormiami.com/es/contacto.html" class="textoblanco" title="CONTACTO" target="_blank">CONTACT</a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" height="10px">
                                                    <tr><td bgcolor="#608f0f" height="5"><img src="img/pixel.gif" width="1" height="1" /></td></tr>
                                                </table>          
                                                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td bgcolor="#ffffff">
                                                            <table width="100%" border="0" cellspacing="15" cellpadding="0">
                                                                <tr>
                                                                    <td width="97%" class="textonegro">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td valign="top">TaxLeaf <font color="#e46e04"><strong>Corporate</strong></font><br />
                                                                                    1549 NE 123 ST<br />
                                                                                    North Miami, FL 33161<br />
                                                                                </td>
                                                                                <td valign="top"><p>TaxLeaf <font color="#e46e04"><strong>Coral Springs</strong></font><br />
                                                                                        3111 N University Ave #105<br />
                                                                                        Coral Springs, Fl 33065<br />
                                                                                        Phone: (954) 345-7585
                                                                                    </p>
                                                                                    <p>&nbsp;</p>
                                                                                </td>
                                                                                <td valign="top">TaxLeaf <font color="#e46e04"><strong>Doral</strong></font><br /> 
                                                                                    8175 NW 12 ST #130
                                                                                    <br />
                                                                                    Doral, Fl 33129<br />
                                                                                    Phone: (305) 433-7945 
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top"><br />
                                                                                    Phone: (888) Y-TAXLEAF<br />
                                                                                    Fax: (815) 550-1294<br />
                                                                                    email: <a href="mailto:info@taxleaf.com" target="_blank">info@taxleaf.com</a>
                                                                                </td>
                                                                                <td valign="top">&nbsp;</td>
                                                                                <td valign="top">&nbsp;</td>
                                                                            </tr>
                                                                        </table></td>
                                                                    <td width="3%" valign="top">
                                                                        <table width="100%" border="0" cellspacing="7" cellpadding="0">
                                                                            <tr>
                                                                                <td width="75%"><img src="http://www.taxleaf.com/Email/1380919403_facebook_square.png" width="24" height="24" /></td>
                                                                                <td width="13%"><img src="http://www.taxleaf.com/Email/1380919424_twitter_square.png" width="24" height="24" /></td>
                                                                                <td width="12%"><img src="http://www.taxleaf.com/Email/1380919444_skype_square_color.png" width="24" height="24" /></td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
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
                        mail($user_email, $email_subject, $message, $headers);
                        /* mail section */
                        $updatesql = "update `lead_mail` SET `status` = '1' WHERE `lead_mail`.`id` = " . $row['id'] . "";
                        mysqli_query($conn, $updatesql);
                    }
                }
            }
        }
    }
}
mysqli_close($conn);
?>