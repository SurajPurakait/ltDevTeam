<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends CI_Controller
{
    private $filter_element;
    function __construct()
    {
        parent::__construct();
        $this->load->model('lead_management', "lm");
        $this->load->model("system");
        if (!$this->session->userdata('user_id') && $this->session->userdata('user_id') == '') {
            redirect(base_url());
        }
        $this->filter_element = [
            1 => "Type",
            2 => "Tracking",
            4 => "Requested By",
            7 => "Requested To",
            6 => "Submission Date"
        ];
    }
    public function index($status = "",$request = ""){
        $this->load->layout = 'dashboard';
        $title = "Dashboard";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = "referral_partners'_leads";
        $render_data['menu'] = 'partner';
        $render_data['header_title'] = $title;
        $render_data['filter_element_list'] = $this->filter_element;
        
        if (empty($status) && $status != '0') { 
            $render_data['status'] = '';
        }
        if ($request == '0') { 
            $render_data['request'] = '';
        }
        $render_data['status'] = $status;
        $render_data['request'] = $request;
        
        $this->load->template('partners/dashboard', $render_data);    
    }
    public function ajax_dashboard() {
        $status = post("status");
        $request = post("request");
        $lead_agents = $this->lm->get_lead_agents();
        $render_data['leads_list'] = $this->lm->get_leads_referred_by_to_him($status,$request);
        $this->load->view('partners/ajax_dashboard', $render_data);
    }

    public function filter_dropdown_option_ajax() {
        $result['element_key'] = $element_key = post('variable');
        $result['condition'] = '';
        if (post('condition')) {
            $result['condition'] = post('condition');
        }
        $office = '';
        if (post('office')) {
            $office = post('office');
        }
        $result['element_array'] = $this->filter_element;
        $result['element_value_list'] = $this->lm->get_partner_filter_element_value($element_key, $office);
        $this->load->view('action/filter_dropdown_option_ajax', $result);
    }
    public function partner_filter() {
        $render_data['leads_list'] = $this->lm->get_leads_referred_by_to_him('','', post());
        $this->load->view('partners/ajax_dashboard', $render_data);
    }
    public function create_referral_agent()
    {
        $this->load->layout = 'dashboard';
        $title = "Create Referral";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'partner';
        $render_data['header_title'] = $title;
        $render_data["type_of_contact"] = $this->lm->get_lead_referral();
        $render_data["lead_source"] = $this->lm->get_lead_sources();
        $render_data["lead_agents"] = $this->lm->get_lead_agents();
        $render_data["client_list"]=$this->lm->get_clients();
        $render_data["states"] = $this->system->get_all_state();
        $render_data["languages"] = $this->system->get_languages();
        $this->load->template('partners/create_referral_agent', $render_data);
    }
    public function insert_new_referral()
    {
        $email = $this->input->post("email");
        if ($this->lm->duplicate_email_check($email)) {
            echo 0;
        } else {
            $result = $this->lm->insert_lead_prospect($this->input->post());
            echo base64_encode($result);
            /* mail section */

            // $user_email = $this->input->post("email");
            // $config = Array(
            //     'protocol' => 'smtp',
            //     'smtp_host' => 'ssl://smtp.gmail.com',
            //     'smtp_port' => 465,
            //     'smtp_user' => 'codetestml001@gmail.com', // change it to yours
            //     'smtp_pass' => 'codetest@123', // change it to yours
            //     'mailtype' => 'html',
            //     'charset' => 'utf-8',
            //     'wordwrap' => TRUE
            // );

            // $mail_data = $this->lm->get_campaign_mail_data($this->input->post("type_of_contact"),$this->input->post("language"),1);

            // $email_subject = $mail_data['subject']; 
            // $mail_body = urldecode($mail_data['body']); 

            // $user_details  = staff_info();
            // $from = $user_details['user'];

            // $user_name = $this->input->post("first_name").' '.$this->input->post("last_name");

            //         $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            //         <html xmlns="http://www.w3.org/1999/xhtml">
            //         <head>
            //         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            //         <title>TAXLEAF</title>
            //         <style type="text/css">
            //         body {
            //             background-color: #FFFFFF;
            //             margin-left: 0px;
            //             margin-top: 0px;
            //             margin-right: 0px;
            //             margin-bottom: 0px;
            //         }
            //         .textoblanco {
            //             font-family: Arial, Helvetica, sans-serif;
            //             font-size: 12px;
            //             color: #000;
            //         }
            //         .textoblanco {
            //             font-family: Arial, Helvetica, sans-serif;
            //             font-size: 12px;
            //             color: #FFF;
            //         }
            //         .textonegro {
            //             font-family: Arial, Helvetica, sans-serif;
            //             font-size: 12px;
            //             color: #000;
            //         }
            //         </style>
            //         </head>

            //         <body>
            //         <br />
            //         <table width="600" border="0" bgcolor="#8ab645" align="center" cellpadding="0" cellspacing="10">
            //           <tr>
            //             <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
            //               <tr>
            //                 <td><img src="http://www.taxleaf.com/Email/header.gif" width="600" height="98" /></td>
            //               </tr>
            //             </table>
            //              <table width="100%" border="0" cellspacing="0" cellpadding="0">
            //                 <tr>
            //                   <td><img src="http://www.taxleaf.com/Email/divider2.gif" width="600" height="30" /></td>
            //                 </tr>
            //               </table>
            //               <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
            //                 <tr>
            //                   <td valign="top" class="textoblanco"><p><span class="textonegro"><strong>Dear '.$user_name.',<br />
            //                     <br />
            //                     </strong>'.$mail_body.'</span></p>
            //                     <p><span class="textonegro">Sincerely,</span></p>
            //                     <p><span class="textonegro">Moses Nae<br />
            //                       moses@taxleaf.com<br />
            //                       305-541-3980<br />
            //                       815-550-1294<br />
            //                       </span><br />
            //                   </p></td>
            //                 </tr>
            //               </table>
            //                     <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" height="10px">
            //               <tr>
            //                 <td bgcolor="#608f0f" height="5"><img src="img/pixel.gif" width="1" height="1" /></td></tr>
            //               </table>
            //         <table width="100%" border="0" cellspacing="15" cellpadding="4">
            //                     <tr>
            //                       <td width="51%" height="45" class="textoblanco" align="center"><a href="https://www.websitealive3.com/12709/visitor/window/?code_id=761&dl"><img src="http://www.taxleaf.com/Email/chat-now.gif" width="155" height="60" alt="Chat Now" style="cursor:pointer" border="0" /></a><br />
            //                       <td width="49%" align="left"><p class="textoblanco"><strong>VISIT US:</strong><br />
            //                       <a href="http://www.contadormiami.com" title="HOME" target="_blank" class="textoblanco">HOME</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="http://contadormiami.com/es/productos-y-servicios/" title="SERVICES" target="_blank" class="textoblanco">SERVICES</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a href="http://contadormiami.com/es/contacto.html" class="textoblanco" title="CONTACTO" target="_blank">CONTACT</a></p></td>
            //                     </tr>
            //                   </table>
            //            <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" height="10px">
            //               <tr><td bgcolor="#608f0f" height="5"><img src="img/pixel.gif" width="1" height="1" /></td></tr>
            //               </table>          
            //               <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
            //                 <tr>
            //                   <td bgcolor="#ffffff"><table width="100%" border="0" cellspacing="15" cellpadding="0">
            //                     <tr>
            //                       <td width="97%" class="textonegro"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            //                         <tr>
            //                           <td valign="top">TaxLeaf <font color="#e46e04"><strong>Corporate</strong></font><br />
            //         1549 NE 123 ST<br />
            //         North Miami, FL 33161<br /></td>
            //                           <td valign="top"><p>TaxLeaf <font color="#e46e04"><strong>Coral Springs</strong></font><br />
            //                             3111 N University Ave #105<br />
            //                             Coral Springs, Fl 33065<br />
            //                             Phone: (954) 345-7585
            //                           </p>
            //                             <p>&nbsp;</p></td>
            //                           <td valign="top">TaxLeaf <font color="#e46e04"><strong>Doral</strong></font><br /> 
            //                             8175 NW 12 ST #130
            //         <br />
            //         Doral, Fl 33129<br />
            //         Phone: (305) 433-7945 </td>
            //                         </tr>
            //                         <tr>
            //                           <td valign="top"><br />
            //         Phone: (888) Y-TAXLEAF<br />
            //         Fax: (815) 550-1294<br />
            //         email: <a href="mailto:info@taxleaf.com" target="_blank">info@taxleaf.com</a></td>
            //                           <td valign="top">&nbsp;</td>
            //                           <td valign="top">&nbsp;</td>
            //                         </tr>
            //                       </table></td>
            //                       <td width="3%" valign="top"><table width="100%" border="0" cellspacing="7" cellpadding="0">
            //                         <tr>
            //                           <td width="75%"><img src="http://www.taxleaf.com/Email/1380919403_facebook_square.png" width="24" height="24" /></td>
            //                           <td width="13%"><img src="http://www.taxleaf.com/Email/1380919424_twitter_square.png" width="24" height="24" /></td>
            //                           <td width="12%"><img src="http://www.taxleaf.com/Email/1380919444_skype_square_color.png" width="24" height="24" /></td>
            //                         </tr>
            //                       </table></td>
            //                     </tr>
            //                   </table></td>
            //                 </tr>
            //             </table></td>
            //           </tr>
            //             <tr>
            //             <td height="100" valign="top">&nbsp;</td>
            //           </tr>
            //         </table>
            //         <br />
            //         </body>
            //         </html>';

            // $this->load->library('email', $config);
            // $this->email->set_newline("\r\n");
            // $this->email->from($from); // change it to yours
            // $this->email->reply_to($from);
            // $this->email->to($user_email); // change it to yours
            // $this->email->subject($email_subject);
            // $this->email->message($message);
            // $this->email->send();

            /* mail section */
        }
    }

    public function referral_agent_type()
    {
        $this->load->layout = 'dashboard';
        $title = "Referral Agent Type";
        $render_data['title'] = $title . ' | Tax Leaf';
        $render_data['main_menu'] = 'referral_partners';
        $render_data['menu'] = 'partner';
        $render_data['header_title'] = $title;
        $render_data["lead_agent_list"] = $this->lm->get_lead_referral();
        $this->load->template('partners/referral_agent_type', $render_data);
    }
    public function add_ref()
    {
        $ref_name = $this->input->post("ref_name");
        $check = $this->lm->check_if_ref_exists($ref_name);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lm->add_ref_type($ref_name)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }
    public function edit_ref()
    {
        $ref_name = $this->input->post("ref_name");
        $ref_id = $this->input->post("ref_id");

        $check = $this->lm->check_if_ref_exists($ref_name, $ref_id);
        if ($check != 0) {
            echo "0";
        } else {
            if ($this->lm->update_ref_type($ref_name, $ref_id)) {
                echo "1";
            } else {
                echo "-1";
            }
        }
    }
    public function delete_ref()
    {
        $ref_id = $this->input->post("lead_id");
        if ($this->lm->delete_ref_type($ref_id)) {
            echo "1";
        } else {
            echo "0";
        }
    }
}    