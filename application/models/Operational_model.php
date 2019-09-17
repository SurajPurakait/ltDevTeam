<?php

class Operational_model extends CI_Model {

    public function get_main_title() {
        return $this->db->get("operational_manuals_main_title")->result_array();
    }

    public function get_sub_title() {
        return $this->db->query("select m.*,(select name from operational_manuals_main_title where id=m.main_title_id) as main_title_name from operational_manuals_sub_title m")->result_array();
    }

    public function get_operational_sub_titles_by_id($main_title_id) {
        $query = "select * from operational_manuals_sub_title where main_title_id='" . $main_title_id . "'";
        return $this->db->query($query)->result_array();
    }

    public function insert_operational_manuals_title($name,$desc) {
        $this->db->insert('operational_manuals_main_title', ["name" => $name]);
        $insert_id = $this->db->insert_id();
        return $this->db->insert('operational_manuals', ["main_title_id" => $insert_id, "sub_title_id" => '0', "description" => $desc]);
    }

    public function insert_operational_manuals_sub_title($name, $desc, $main_cat_id) {
        $this->db->insert('operational_manuals_sub_title', ["main_title_id" => $main_cat_id, "name" => $name]);
        $insert_id = $this->db->insert_id();
        return $this->db->insert('operational_manuals', ["main_title_id" => $main_cat_id, "sub_title_id" => $insert_id, "description" => $desc]);
    }

    public function get_main_cat_by_id($id) {
        return $this->db->get_where('operational_manuals_main_cat', ['id' => $id])->row_array();
    }

    public function get_sub_cat_by_id($id) {
        return $this->db->query("select m.*,(select name from operational_manuals_main_cat where id=m.main_cat_id) as main_cat_name from operational_manuals_sub_cat m where m.id='" . $id . "'")->row_array();
    }

    public function check_if_name_exists($name, $id = null) {
        $sql = "select * from operational_manuals_main_title where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function check_if_subname_exists($name, $id = null, $main_cat_id = null) {
        $sql = "select * from operational_manuals_sub_title where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        if ($main_cat_id != null) {
            $sql .= ' AND main_title_id=' . $main_cat_id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function update_operational_manuals_title($name, $desc, $id) {
        $this->db->set(["name" => $name])->where("id", $id)->update("operational_manuals_main_title");
        return $this->db->set(["description" => $desc])->where(["main_title_id" => $id, "sub_title_id" => '0'])->update("operational_manuals");
    }
    
    public function update_operational_manuals($title, $descp, $id) {
        return $this->db->set(["title" => $title, "description" => $descp])->where("id", $id)->update("operational_manuals");
    }

    public function check_if_associated_main($cat_id) {
        // return $this->db->get_where('operational_manuals',['main_cat_id'=>$cat_id])->num_rows();
        return $this->db->query("select * from operational_manuals where main_cat_id='" . $cat_id . "'")->num_rows();
    }

    public function check_if_has_subcat($cat_id) {
        // return $this->db->get_where('operational_manuals_sub_cat',['main_cat_id'=>$cat_id])->num_rows();

        return $this->db->query("select * from operational_manuals_sub_cat where main_cat_id='" . $cat_id . "'")->num_rows();
    }

    public function delete_operational_manuals_category($cat_id) {
        return $this->db->where("id", $cat_id)->delete("operational_manuals_main_cat");
    }

    public function update_operational_manuals_sub_title($name, $desc, $id) {
        $this->db->set(["name" => $name])->where("id", $id)->update("operational_manuals_sub_title");
        return $this->db->set(["description" => $desc])->where(["sub_title_id" => $id])->update("operational_manuals");
    }

    public function check_if_associated_sub($cat_id) {
        return $this->db->query("select * from operational_manuals where sub_cat_id='" . $cat_id . "'")->num_rows();
    }

    public function delete_operational_manuals_subcategory($cat_id) {
        return $this->db->where("id", $cat_id)->delete("operational_manuals_sub_cat");
    }

    public function insert_operational_manuals($data) {
//        print_r($data);exit;
        $this->db->trans_begin();        
        $insert_data = array(
            'id' => '',
            'title' => $data['title'],
            'description' => $data['description'],
            'main_cat_id' => $data['main_cat'],
            'sub_cat_id' => $data['sub_cat'],
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('operational_manuals', $insert_data);
        $id = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }
    
    public function get_operational_manual_data($cat_id,$sub_cat_id = null) {
        
        if($sub_cat_id == null)
            return $this->db->query("select * from operational_manuals where main_title_id=$cat_id and sub_title_id=0")->result_array();
        else
            return $this->db->query("select * from operational_manuals where main_title_id=$cat_id and sub_title_id=$sub_cat_id")->result_array();
    }
    
    public function get_operational_manual_data_by_id($manual_id) {       
        
        return $this->db->query("select * from operational_manuals where id=$manual_id")->result_array();
       
    }

    public function delete_operational_manuals($operational_manuals_id){
        return $this->db->where("id", $operational_manuals_id)->delete("operational_manuals");    
    }

    public function get_title_data($id){
        return $this->db->query("select omt.*,(select description from operational_manuals where main_title_id=omt.id and sub_title_id = 0) as main_title_desc from operational_manuals_main_title omt where omt.id='" . $id . "'")->row_array();
    }

    public function get_sub_title_data($id){
        return $this->db->query("select omst.*,(select description from operational_manuals where sub_title_id=omst.id) as sub_title_desc from operational_manuals_sub_title omst where omst.id='" . $id . "'")->row_array();
    }

    public function get_content($type,$id){
        if($type=='main'){
             return $this->db->query("select * from operational_manuals where main_title_id='".$id."' and sub_title_id='0'")->row_array();
        }else{
             return $this->db->query("select * from operational_manuals where sub_title_id='".$id."'")->row_array();
        }
    }

    public function check_if_subtitle_exists($id){
         return $this->db->where(['main_title_id' => $id])->from("operational_manuals_sub_title")->count_all_results();
    }

    public function delete_title($id){
        $this->db->trans_begin();
        $this->db->where("id", $id)->delete("operational_manuals_main_title");
        $this->db->where(["main_title_id" => $id, "sub_title_id" => '0'])->delete("operational_manuals");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function delete_subtitle($id){
        $this->db->trans_begin();
        $this->db->where("id", $id)->delete("operational_manuals_sub_title");
        $this->db->where("sub_title_id", $id)->delete("operational_manuals");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_forms(){
         return $this->db->query("select * from operational_forms")->result_array();
    }

     public function insert_operational_forms($data) {
        $this->db->trans_begin();
        if ($_FILES['image_file']['name'] != '') {
            $image_file = common_upload('image_file');
            if ($image_file['success'] == 1) {
                $imgurl = $image_file['status_msg'];
            } else {
                return "-4";
            }
        } else {
            return "-4";
        }

            if(isset($imgurl)){
               $insert_data = array(
                'id' => '',
                'title' => $data['title'],
                'upload_file' => $imgurl
                );
                 $this->db->insert('operational_forms', $insert_data);  
            }
            
            
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

}

?>