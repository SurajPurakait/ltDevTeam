<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Documents
 *
 * @author rafael
 */
class Documents extends CI_Model {

    public $id;
    public $upload_message;
    public $upload_message_acc;
    public $file_uploaded;
    public $file_uploaded_acc;

    public function saveDocument($data, $file) {

        if ($this->uploadDocument($file)) {

            $data = (object) $data; // convert the post array into an object

            $sql = "insert into documents
                    (reference, reference_id, doc_type, document, status)
                    values
                    (
                    '{$data->reference}',
                    '{$data->reference_id}',
                    '{$data->type}',
                    '{$this->file_uploaded}',
                    1
                    )";

            $conn = $this->db;

            if ($conn->query($sql)) {

                $this->db->select('MAX(id) as id');
                $this->db->from('documents');
                $this->db->order_by('id', 'DESC');
                $query = $this->db->get();
                $result = $query->result()[0];

                $this->id = $result->id;
                $this->load->model('System');
                $this->System->log('insert', 'documents', $this->id);

                return $this->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function saveAccountsbydate($data, $file) {
        //print_r($data); exit;

        $data = (object) $data; // convert the post array into an object


        if (!$data->idval) {

            if ($this->uploadcontactDocument($file)) {
                $sql = "insert into financial_accounts
                    (id, company_id, type_of_account, bank_name, account_number, routing_number, user, password, bank_website, number_of_transactions, total_amount, acc_doc, start_date, complete_date, grand_total)
                    values
                    (
                    '',
                    '{$data->reference_id}',
                    '{$data->type}',
                    '{$data->bankname}',
                    '{$data->acc_no}',
                    '{$data->routing_no}',
                    '{$data->user_id}',
                    '{$data->password}',
                    '{$data->website_url}',
                    '{$data->no_of_transactions}',
                    '{$data->total_amount}',
                    '{$this->file_uploaded_acc}',
                    '{$data->start_month}',
                    '{$data->complete_month}',
                    '{$data->grand_total_amount}'
                    )";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $this->db->insert_id();
                    $insert_id = $this->id;

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$insert_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            } else {
                $sql = "insert into financial_accounts
                    (id, company_id, type_of_account, bank_name, account_number, routing_number, user, password, bank_website, number_of_transactions, total_amount, acc_doc, start_date, complete_date, grand_total)
                    values
                    (
                    '',
                    '{$data->reference_id}',
                    '{$data->type}',
                    '{$data->bankname}',
                    '{$data->acc_no}',
                    '{$data->routing_no}',
                    '{$data->user_id}',
                    '{$data->password}',
                    '{$data->website_url}',
                    '{$data->no_of_transactions}',
                    '{$data->total_amount}',
                    '',
                    '{$data->start_month}',
                    '{$data->complete_month}',
                    '{$data->grand_total_amount}'
                    )";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $this->db->insert_id();
                    $insert_id = $this->id;

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$insert_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            }
        } else {
            //print_r($data);
            if ($this->uploadcontactDocument($file)) {
                $sql = "update financial_accounts set
                    type_of_account='{$data->type}',
                    bank_name='{$data->bankname}',
                    account_number='{$data->acc_no}',    
                    routing_number='{$data->routing_no}', 
                    user='{$data->user_id}',
                    password='{$data->password}', 
                    bank_website='{$data->website_url}',
                    number_of_transactions='{$data->no_of_transactions}',
                    total_amount='{$data->total_amount}',
                    acc_doc='{$this->file_uploaded_acc}',
                    start_date='{$data->start_month}',
                    complete_date='{$data->complete_month}',
                    grand_total='{$data->grand_total_amount}'
                    where id = {$data->idval}";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $data->idval;
                    $edit_id = $this->id;

                    $sql = $this->db->query("delete from security_questions where financial_accounts_id = '{$data->idval}'");

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$edit_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            } else {
                $sql = "update financial_accounts set
                    type_of_account='{$data->type}',
                    bank_name='{$data->bankname}',
                    account_number='{$data->acc_no}',    
                    routing_number='{$data->routing_no}', 
                    user='{$data->user_id}',
                    password='{$data->password}', 
                    bank_website='{$data->website_url}',
                    number_of_transactions='{$data->no_of_transactions}',
                    total_amount='{$data->total_amount}',
                    start_date='{$data->start_month}',
                    complete_date='{$data->complete_month}',
                    grand_total='{$data->grand_total_amount}'
                    where id = {$data->idval}";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $data->idval;
                    $edit_id = $this->id;

                    $sql = $this->db->query("delete from security_questions where financial_accounts_id = '{$data->idval}'");

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$edit_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            }
        }
    }

    public function saveAccounts($data, $file) {
        //print_r($data); exit;

        $data = (object) $data; // convert the post array into an object


        if (!$data->idval) {

            if ($this->uploadcontactDocument($file)) {
                $sql = "insert into financial_accounts
                    (id, company_id, type_of_account, bank_name, account_number, routing_number, user, password, bank_website, number_of_transactions, total_amount, acc_doc, start_date, complete_date, grand_total)
                    values
                    (
                    '',
                    '{$data->reference_id}',
                    '{$data->type}',
                    '{$data->bankname}',
                    '{$data->acc_no}',
                    '{$data->routing_no}',
                    '{$data->user_id}',
                    '{$data->password}',
                    '{$data->website_url}',
                    '{$data->no_of_transactions}',
                    '{$data->total_amount}',
                    '{$this->file_uploaded_acc}',
                    '',
                    '',
                    ''
                    )";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $this->db->insert_id();
                    $insert_id = $this->id;

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$insert_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            } else {
                $sql = "insert into financial_accounts
                    (id, company_id, type_of_account, bank_name, account_number, routing_number, user, password, bank_website, number_of_transactions, total_amount, acc_doc, start_date, complete_date, grand_total)
                    values
                    (
                    '',
                    '{$data->reference_id}',
                    '{$data->type}',
                    '{$data->bankname}',
                    '{$data->acc_no}',
                    '{$data->routing_no}',
                    '{$data->user_id}',
                    '{$data->password}',
                    '{$data->website_url}',
                    '{$data->no_of_transactions}',
                    '{$data->total_amount}',
                    '',
                    '',
                    '',
                    ''
                    )";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $this->db->insert_id();
                    $insert_id = $this->id;

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$insert_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            }
        } else {
            //print_r($data);
            if ($this->uploadcontactDocument($file)) {
                $sql = "update financial_accounts set
                    type_of_account='{$data->type}',
                    bank_name='{$data->bankname}',
                    account_number='{$data->acc_no}',    
                    routing_number='{$data->routing_no}', 
                    user='{$data->user_id}',
                    password='{$data->password}', 
                    bank_website='{$data->website_url}',
                    number_of_transactions='{$data->no_of_transactions}',
                    total_amount='{$data->total_amount}',
                    acc_doc='{$this->file_uploaded_acc}'
                    where id = {$data->idval}";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $data->idval;
                    $edit_id = $this->id;

                    $sql = $this->db->query("delete from security_questions where financial_accounts_id = '{$data->idval}'");

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$edit_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            } else {
                $sql = "update financial_accounts set
                    type_of_account='{$data->type}',
                    bank_name='{$data->bankname}',
                    account_number='{$data->acc_no}',    
                    routing_number='{$data->routing_no}', 
                    user='{$data->user_id}',
                    password='{$data->password}', 
                    bank_website='{$data->website_url}',
                    number_of_transactions='{$data->no_of_transactions}',
                    total_amount='{$data->total_amount}'
                    where id = {$data->idval}";

                $conn = $this->db;

                if ($conn->query($sql)) {

                    $this->id = $data->idval;
                    $edit_id = $this->id;

                    $sql = $this->db->query("delete from security_questions where financial_accounts_id = '{$data->idval}'");

                    $secq = $data->security_questions;
                    $secans = $data->security_answer;
                    foreach ($secq as $k => $q) {
                        $sql = "insert into security_questions
                    (id, financial_accounts_id, security_question, security_answer)
                    values
                    (
                    '',
                    '{$edit_id}',
                    '{$q}',
                    '{$secans[$k]}'
                    )";
                        $conn->query($sql);
                    }

                    return $this->id;
                } else {
                    return false;
                }
            }
        }
    }

    public function deleteDocument($id) {
        $sql = "update documents set status = 0 where id = $id";
        $conn = $this->db;
        if ($conn->query($sql)) {
            $this->load->model('System');
            $this->System->log("delete", "documents", $id);
            return true;
        } else {
            return false;
        }
    }

    public function loadDocumentList($reference, $reference_id) {
        $sql = "select id, doc_type, document
                from documents 
                where status=1 and reference='$reference' and reference_id=$reference_id";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $document) {
                echo "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$document->doc_type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <a href=\"#\" onclick=\"openDocument('{$document->document}','" . base_url() . "'); return false;\">{$document->document}</a>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash\" style=\"cursor:pointer\" onclick=\"deleteDocument({$document->id})\" title=\"Remove this document\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }

        //  $quant_documents = $this->getQuantDocumentsByReference($reference, $reference_id);
        // if($quant_documents==0){
        //     echo '<input type="hidden" name="documents" id="documents" required title="Documents">';
        // }else{
        //     echo '<input type="hidden" name="documents" id="documents" title="Documents">';
        // }
    }

    public function getQuantDocumentsByReference($reference, $reference_id) {
        $sql = "select count(*) as total from documents where reference='$reference' and reference_id=$reference_id and status=1";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data->total;
        } else {
            return 0;
        }
    }

    public function get_bookkeeping_data($reference_id) {
        $sql = "select * from bookkeeping where company_id=$reference_id";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function getQuantAccountsByReference($reference_id) {
        $sql = "select count(*) as total from financial_accounts where company_id=$reference_id";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data->total;
        } else {
            return 0;
        }
    }

    private function uploadDocument($file) {

        $upload_dir = '../uploads/';
        $temp = explode('.', $file['file']['name']);
        $extension = strtolower(end($temp));
        $save_as = time() . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('txt', 'jpg', 'png', 'gif', 'doc', 'docx', 'pdf', 'xls', 'xlsx');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['file']['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['file']['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    private function uploadcontactDocument($file) {

        $upload_dir = '../uploads/';
        $temp = explode('.', $file['acc_file']['name']);
        $extension = strtolower(end($temp));
        $save_as = time() . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('doc', 'docx');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message_acc = "File extension not allowed";
            return false;
        } else {
            if ($file['acc_file']['size'] > $max_size) {
                $this->upload_message_acc = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['acc_file']['tmp_name'], $upload_file)) {
                    $this->upload_message_acc = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message_acc = "File uploaded successfully";
                    $this->file_uploaded_acc = $save_as;
                    return true;
                }
            }
        }
    }

    public function loadAccountsList($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $title) {
                $type = $title->type_of_account;
                if (strpos($type, 'Account') !== false) {
                    $short_type = str_replace('Account', '', $type);
                } else {
                    $short_type = $type;
                }

                echo '<div class="row">';
                echo '<div class="col-lg-10" style="padding-top:8px">';
                echo '<p>';
                echo '<input type="hidden" class="total_amounts" title="Total Amount" value="' . $title->total_amount . '"/>';
                echo '<label class=\"col-lg-2 control-label\">' . $short_type . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                echo '<b> ' . $title->bank_name . ' </b><br>';
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Amount: $' . $title->total_amount . ' <br>';
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Of Transactions: ' . $title->number_of_transactions . '';
                echo '</p>';
                echo '<p>';
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-edit" style="cursor:pointer" onclick="editAccount(' . $title->id . ')" title="Edit this owner"></i>';
                echo '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="deleteAccount(' . $title->id . ')" title="Remove this account"></i>';
                echo '</p>';
                echo '</div>';
                echo '</div>';
            }
        }
    }

    public function loadPayrollAccountsList($company_id) {
//        $sql = "select * from financial_accounts where company_id='$company_id'";
//
//        $data = $this->db->query($sql)->result();
//        if ($data) {
//            foreach ($data as $title) {
//                $type = $title->type_of_account;
//                if (strpos($type, 'Account') !== false) {
//                    $short_type = str_replace('Account', '', $type);
//                } else {
//                    $short_type = $type;
//                }
//
//                echo '<div class="row">';
//                echo '<div class="col-lg-10" style="padding-top:8px">';
//                echo '<p>';
//                echo '<input type="hidden" class="total_amounts" title="Total Amount" value="' . $title->total_amount . '"/>';
//                echo '<label class=\"col-lg-2 control-label\">' . $short_type . '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//                echo '<b> ' . $title->bank_name . ' </b><br>';
//                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Amount: $' . $title->total_amount . ' <br>';
//                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;# Of Transactions: ' . $title->number_of_transactions . '';
//                echo '</p>';
//                echo '<p>';
//                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-edit" style="cursor:pointer" onclick="editPayrollAccount(' . $title->id . ')" title="Edit this owner"></i>';
//                echo '&nbsp;&nbsp;<i class="fa fa-trash" style="cursor:pointer" onclick="deletePayrollAccount(' . $title->id . ')" title="Remove this account"></i>';
//                echo '</p>';
//                echo '</div>';
//                echo '</div>';
//            }
//        }

//        echo '<h3>Account Numbers</h3>';
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();

        if ($data) {
            echo '<h4>Select from Accounts</h4>';
            echo '<div class="row">';
            foreach ($data as $financial_data) {
                $type = $financial_data->type_of_account;
                if (strpos($type, 'Account') !== false) {
                    $short_type = str_replace('Account', '', $type);
                } else {
                    $short_type = $type;
                } ?>
                <div class="col-md-4"><div class="alert alert-info text-center">
                    <a href="javascript:void(0);" class="payroll-own" onclick="copy_financial_account(<?php echo $financial_data->id; ?>)">
                        <b><?php echo $short_type; ?></b><br>
                        <b><?php echo $financial_data->bank_name; ?></b>
                    </a>
                </div></div>
            <?php }
            echo '</div>';
        }
    }

    public function loadAccountsListpdf($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function loadAccountsListbydate($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();
        if ($data) {
            foreach ($data as $title) {
                $type = $title->type_of_account;
                if (strpos($type, 'Account') !== false) {
                    $short_type = str_replace('Account', '', $type);
                } else {
                    $short_type = $type;
                }

                echo "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$short_type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <input type=\"hidden\" class=\"total_amounts\" title=\"Total Amount\" value=\"{$title->grand_total}\">
                                    <b> {$title->bank_name} </b><br>
                                    Grand Total Amount: " . "$" . "{$title->grand_total} <br>
                                    # Of Transactions: {$title->number_of_transactions}
                                </p>
                                <p>
                                    <i class=\"fa fa-edit\" style=\"cursor:pointer\" onclick=\"editAccountbydate({$title->id})\" title=\"Edit this owner\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash\" style=\"cursor:pointer\" onclick=\"deleteAccountbydate({$title->id})\" title=\"Remove this account\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }
        //  $quant_title = $this->getQuantAccounts($company_id);
        // if($quant_title==0){
        //     echo '<input type="hidden" name="owners" id="owners" required title="Owners">';
        // }else{
        //     echo '<input type="hidden" name="owners" id="owners" title="Owners">';
        // }
    }

    public function loadAccountsListbydatepdf($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function change_retail_price($reference_id) {
        $sql = "select sum(total_amount) as total from financial_accounts where company_id=$reference_id";
        $conn = $this->db;
        $data = $conn->query($sql)->result()[0];
        if ($data) {
            return $data->total;
        } else {
            return 0;
        }
    }

    public function deleteAccount($id) {
        $sql = "delete from security_questions where financial_accounts_id = $id";
        $conn = $this->db;
        $conn->query($sql);
        $query = "delete from financial_accounts where id = $id";
        $conn->query($query);
        return true;
    }

    // public function getAccountJson($id) {
    //     $account['acc'] = $this->getAccountById($id);
    //     $account['secq'] = $this->getSecqBy($id);
    //     if ($account) {
    //         return $account;
    //     }
    // }

    public function getAccountById($id) {
        $sql = "select fa.* from financial_accounts fa where fa.id=$id";
        $conn = $this->db;
        $data = $conn->query($sql)->row_array();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getSecqBy($id) {
        $sql = "select sq.* from security_questions sq where sq.financial_accounts_id=$id";
        $conn = $this->db;
        $data = $conn->query($sql)->result_array();
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    function getW4Form($reference_id = '') {
        $sql = "SELECT * FROM payroll_forms WHERE reference_id='" . $reference_id . "' AND type=1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function getI9Form($reference_id = '') {
        $sql = "SELECT * FROM payroll_forms WHERE reference_id='" . $reference_id . "' AND type=2";
        $query = $this->db->query($sql);
        return $query->result();
    }

}
