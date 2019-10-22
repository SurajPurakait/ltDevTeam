<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class New_prospect extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lead_management', "lm");
        $this->load->model("system");
        $this->load->model("administration");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
    }

    public function index($type = "") {
        $this->load->layout = 'dashboard';
        // $title = "Create New Prospect";
        $title = "Leads Dashboard / Add New";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'leads';
        // $render_data['main_menu'] = 'lead_management';
        $render_data['menu'] = 'new_lead';
        $render_data['header_title'] = $title;
        if ($type != '') {
            $render_data['lead_type'] = $type;
        }
        $render_data["type_of_contact"] = $this->lm->get_lead_types();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["countries"] = $this->system->get_all_countries();
        $render_data["languages"] = $this->system->get_languages();

        $this->load->template('lead_management/create_prospect', $render_data);
    }

    public function insert_new_prospect() {
        // print_r(post());exit;
        $email = post("email");
        if ($this->lm->duplicate_email_check($email)) {
            echo 0;
        } else {
            $result = $this->lm->insert_lead_prospect(post());
            $id = $result;
            $event_id = post("event_id");
            if (isset($event_id)) {
                $event_lead_data = [
                    'event_id' => $event_id,
                    'lead_id' => $result
                ];
                $data = $this->lm->insert_event_lead($event_lead_data);
            }

            if (post('mail_campaign_status') == 1) {
                /* mail section */
                $user_email = post("email");
//                $config = Array(
//                    'protocol' => 'smtp',
//                    'smtp_host' => 'ssl://smtp.gmail.com',
//                    'smtp_port' => 465,
//                    'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
//                    'smtp_pass' => 'codetestml0016@123', // change it to yours
//                    'mailtype' => 'html',
//                    'charset' => 'utf-8',
//                    'wordwrap' => TRUE
//                );

                $config = Array(
                    //'protocol' => 'smtp',
                    'smtp_host' => 'mail.leafnet.us',
                    'smtp_port' => 465,
                    'smtp_user' => 'developer@leafnet.us', // change it to yours
                    'smtp_pass' => 'developer@123', // change it to yours
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
                $lead_result = $this->lm->view_leads_record($id);
                $mail_data = $this->lm->get_campaign_mail_data(post("type_of_contact"), post("language"), 1);
                $email_subject = $mail_data['subject'];
                $mail_body = urldecode($mail_data['body']);
                $user_details = staff_info();
                if ($this->input->post('sender_email')) {
                    $from = $this->input->post('sender_email');
                    $from_name = $this->input->post('sender_email');
                } else {
                    $from = $user_details['user'];
                    $from_name = $user_details['first_name'] . ', ' . $user_details['last_name'];
                }
                // $from = $user_details['user'];
                // $from_name = $user_details['first_name'] . ', ' . $user_details['last_name'];
                $user_name = post("first_name") . ', ' . post("last_name");
                $contact_type = $this->lm->get_type_of_contact_by_id(post("type_of_contact"));
                $lead_source = $this->lm->get_lead_source_by_id(post("lead_source"));
                $office_info = $this->administration->get_office_by_id(post('office'));
                // Set veriables --- #name, #type, #lead_type, #company, #phone, #email, #requested_by, #staff_office, #staff_phone, #staff_email, #first_contact_date, #lead_source, #source_detail, #office_name, #office_address, #office_phone_number
                $veriable_array = [
                    'name' => $lead_result['first_name'],
                    'type_of_contact' => $contact_type['name'],
                    'company_name' => $lead_result['company_name'],
                    'phone' => $lead_result['phone1'],
                    'email' => $lead_result['email'],
                    'staff_name' => $user_details['full_name'],
                    'staff_office' => staff_office_name(sess('user_id')),
                    'staff_phone' => $user_details['phone'],
                    'staff_email' => $user_details['user'],
                    'date_first_contact' => ($lead_result['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($lead_result['date_of_first_contact'])) : '',
                    'lead_source' => $lead_source['name'],
                    'source_detail' => $lead_result['lead_source_detail'],
                    'lead_type' => $lead_result['type'],
                    'office_phone_number' => $office_info['phone'],
                    'office_address' => $office_info['address'],
                    'office_name' => $office_info['name']
                ];

                foreach ($veriable_array as $index => $value) {
                    if ($value != '') {
                        $mail_body = str_replace('#' . $index, $value, $mail_body);
                        $email_subject = str_replace('#' . $index, $value, $email_subject);
                    }
                }

                $user_logo = "";
                if ($lead_result['office'] != 0) {
                    $user_logo = get_user_logo($lead_result['office']);
                }

                if ($user_logo != "" && !file_exists('https://leafnet.us/uploads/' . $user_logo)) {
                    $user_logo_fullpath = 'https://leafnet.us/uploads/' . $user_logo;
                } else {
                    $user_logo_fullpath = 'https://leafnet.us/assets/img/logo.png';
                }

                if ($lead_result['office'] == 1 || $lead_result['office'] == 18 || $lead_result['office'] == 34) {
                    $bgcolor = '#00aec8';
                    $divider_img = 'https://leafnet.us/assets/img/divider-blue.jpg';
                } else {
                    $bgcolor = '#8ab645';
                    $divider_img = 'http://www.taxleaf.com/Email/divider2.gif';
                }

                //echo $mail_body; exit;
                $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                        <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td style="background: #fff"><img src="' . $user_logo_fullpath . '" width="300" height="98" /></td>
                          </tr>
                        </table>
                         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><img src="' . $divider_img . '" width="600" height="30" /></td>
                            </tr>
                          </table>
                          <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
                            <tr>
                              <td valign="top" style="color:#000;" class="textoblanco"><p><span class="textonegro"><strong><br />
                                <br />
                                </strong>' . $mail_body . '</span></p>
                                <p><span class="textonegro">Sincerely,</span></p>
                                <p><span class="textonegro">Moses Nae<br />
                                  moses@taxleaf.com<br />
                                  305-541-3980<br />
                                  815-550-1294<br />
                                  </span><br />
                              </p></td>
                            </tr>
                          </table>          
                          <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                        </table></td>
                      </tr>
                        <tr>
                        <td height="100" valign="top">&nbsp;</td>
                      </tr>
                    </table>
                    <br />
                    </body>
                    </html>';

                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($from, $from_name); // change it to yours
                $this->email->reply_to($from, $from_name);
                $this->email->to($user_email); // change it to yours
                $this->email->subject($email_subject);
                $this->email->message($message);
                if ($this->email->send()) {
                    //$this->lm->update_mail_campaign($mail_data['id'], ['submission_date' => date('Y-m-d')]);
                    $this->lm->update_lead_day(0, $id);
                }
                /* mail section */
            }
            echo base64_encode($result);
        }
    }

}
