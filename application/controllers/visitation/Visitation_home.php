<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visitation_home extends CI_Controller {


        function __construct() {
            parent::__construct();
            $this->load->model('Visitation_model');
        
        }    
        public function index() {
            $this->load->layout = 'dashboard';
            $title = "Visitation";
            $render_data['title'] = $title . ' | Tax Leaf';
            // $render_data['main_menu'] = 'visitation';
            $render_data['main_menu'] = 'corporate_menu';
            $render_data['menu'] = 'visitation';
            $render_data['header_title'] = $title;
            $this->load->template('visitation/dashboard', $render_data);

        }


        public function insert_visit(){
            // echo "Hello";exit;
           $result = $this->Visitation_model->insert_visit_data(post());
           echo $result;
           // print_r($result);
       }

        public function visitation_dashboard(){
            $render_data['result'] = $this->Visitation_model->view_visit_data();
            // print_r($render_data['result']);exit;
            $this->load->view('visitation/ajax_dashboard',$render_data);
       }

        public function update_visit($id){
            $result = $this->Visitation_model->update_visit_data($id,post());  
            echo $result;
       }


        public function deleteimage(){
            $deleteid  = $this->input->post('image_id');
            $this->db->delete('visitation_attachments', array('id' => $deleteid)); 
            $verify = $this->db->affected_rows();
            echo $verify;

        }

        public function add_visit_Notesmodal() {
            $notes = $this->input->post('visit_note');
            $id = $this->input->post('visitation_id');
            $this->load->model('notes');
            if (!empty($notes)) {
                $this->notes->insert_note(10, $notes, "visitation_id", $id, '');
                echo count($notes);
            }else{
                echo '0';
            }
       
        }


        public function update_visit_Notes() {
            if (!empty(post('notes'))) {
                $this->load->model('Notes');
                $this->Notes->updateNotes(post(), post('notestable'));
                //redirect(base_url() . 'action/home');
            }
        }

        public function show_visit_files_modal() {
            $render_data['files_data'] = $this->Visitation_model->getvisitFilesContent($this->input->post("id"));
            $render_data['id'] = $this->input->post("id");
            $this->load->view('modal/visitattachment_modal', $render_data);
        }


        public function fileupload_visitation() {
            echo $this->Visitation_model->fileupload_visitation($this->input->post('visit_id'), $_FILES["upload_file"]);
        }


        public function visit_download_zip() {
            $files_array = explode(",", request('filesarray'));
            $this->load->library('zip');
            if (!empty($files_array)) {
                foreach ($files_array as $file) {
                    $filepath = FCPATH . '/uploads/' . trim($file);
                    $this->zip->read_file($filepath);
                }
                //$this->zip->archive(FCPATH.'/uploads/example_backup.zip');
                $this->zip->download('myvisit_zipfile.zip');
            }
        }

        public function visitation_viewdetails($id){
            // echo $id;return false;
            $this->load->layout = 'dashboard';
            $title = "Visitation View";
            $render_data['title'] = $title . ' | Tax Leaf';
            $render_data['main_menu'] = 'visitation';
            $render_data['menu'] = 'visitation';
            $render_data['header_title'] = $title;

            $render_data['data'] = $this->Visitation_model->view_visit_pagedetails($id);
            $this->load->template('visitation/visitation_viewpagedetail', $render_data);

        }


        public function get_office_list_forstaff() {
            $render_data['mngrs'] = $this->Visitation_model->get_stafflist_by_office_id(post('office_id'));
            $selected = post('selected');
            if($selected != ''){
                $render_data['selected'] = explode(",",$selected);
            }else{
                $render_data['selected'] = $selected;
            }    
             
            $this->load->view('action/manager_list',$render_data);
        }


        public function update_visitation_status(){

            // $prev_status = $this->Visitation_model->get_current_visitation_status('visitation', $this->input->post("id"));
            $status = $this->input->post("status");
            $visit_id = $this->input->post("id");
            $result = $this->Visitation_model->update_visitation_status($visit_id,$status);
            if($result){
                echo "1";
            }else{
                echo "0";
            }
            // if($status==1){
            //     $this->action_model->assign_action_by_action_id($action_id, sess('user_id'));
            // }
            
            // echo $this->action_model->update_action_status($action_id, $status, $comment);

            // mod_actions_count($prev_status, $this->input->post("status"));
        }

        
}

?>