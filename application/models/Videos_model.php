<?php

Class Videos_model extends CI_Model {

    public function get_main_cats() {
        return $this->db->query("select * from videos_main_cat")->result_array();
    }

    public function get_main_cat_by_id($id) {
        return $this->db->query("select * from videos_main_cat where id='" . $id . "'")->row_array();
    }

    public function check_if_name_exists($name, $id = null) {
        $sql = "select * from videos_main_cat where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function insert_training_materials_category($name, $icon) {
        return $this->db->insert('videos_main_cat', ["name" => $name, "icon" => $icon]);
    }

    public function update_training_materials_category($name, $icon, $id) {
        return $this->db->set(["name" => $name, "icon" => $icon])->where("id", $id)->update("videos_main_cat");
    }

    public function delete_training_materials_category($cat_id) {
        return $this->db->where("id", $cat_id)->delete("videos_main_cat");
    }

    public function get_sub_cats() {
        return $this->db->query("select v.*,(select name from videos_main_cat where id=v.main_cat_id) as main_cat_name from videos_sub_cat v")->result_array();
    }

    public function get_sub_cat_by_id($id) {
        return $this->db->query("select v.*,(select name from videos_main_cat where id=v.main_cat_id) as main_cat_name from videos_sub_cat v where v.id='" . $id . "'")->row_array();
    }

    public function check_if_subname_exists($name, $id = null, $main_cat_id = null) {
        $sql = "select * from videos_sub_cat where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        if ($main_cat_id != null) {
            $sql .= ' AND main_cat_id=' . $main_cat_id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function insert_training_materials_subcategory($name, $main_cat_id) {
        return $this->db->insert('videos_sub_cat', ["main_cat_id" => $main_cat_id, "name" => $name]);
    }

    public function update_training_materials_subcategory($name, $main_name, $id) {
        return $this->db->set(["main_cat_id" => $main_name, "name" => $name])->where("id", $id)->update("videos_sub_cat");
    }

    public function delete_training_materials_subcategory($cat_id) {
        return $this->db->where("id", $cat_id)->delete("videos_sub_cat");
    }

    public function get_subcat_by_maincat($main_cat) {
        return $this->db->query("select * from videos_sub_cat where main_cat_id='" . $main_cat . "'")->result_array();
    }
    
    public function insert_operational_manuals($videos_training){
        if (empty($videos_training['visible_by'])) {
            return "-1";
        }
        $this->db->trans_begin();
        if ($_FILES['video_file']['name'] != '') {
            $video_file = common_upload('video_file');
            if ($video_file['success'] == 1) {
                $videos_training['video'] = $video_file['status_msg'];
            } else {
                return "-4";
            }
        } else {
            return "-4";
        }
        $user_type = $videos_training['visible_by'];
        $videos_training['visible_by'] = implode(",", $videos_training['visible_by']);
        $videos_training['sort_order'] = $this->get_last_sort_order()['sort_order'] + 1;
        $this->db->insert('videos_training', $videos_training);
        $id = $this->db->insert_id();
        foreach ($user_type as $type) {
            $user_type_data = [
                'training_id' => $id,
                'user_type' => $type
            ];
            $this->db->insert('training_materials_user_type', $user_type_data);
        }
        $attachments = [];
        $files = $_FILES["upload_file"];
        $filesCount = count($files['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            if ($files['name'][$i] != '') {
                $_FILES['upload_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['upload_file']['type'] = $files['type'][$i];
                $_FILES['upload_file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['upload_file']['error'] = $files['error'][$i];
                $_FILES['upload_file']['size'] = $files['size'][$i];
                $upload_file = common_upload('upload_file');
                if ($upload_file['success'] == 1) {
                    $attachments[$i]['file_name'] = $upload_file['status_msg'];
                    $attachments[$i]['videos_training_id'] = $id;
                } else {
                    return "-5";
                }
            }
        }
        if (!empty($attachments)) {
            $this->db->insert_batch('videos_files', $attachments);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }


    public function insert_training_materials($videos_training) {
        if (empty($videos_training['visible_by'])) {
            return "-1";
        }
        $this->db->trans_begin();
        if ($_FILES['video_file']['name'] != '') {
            $video_file = common_upload('video_file');
            if ($video_file['success'] == 1) {
                $videos_training['video'] = $video_file['status_msg'];
            } else {
                return "-4";
            }
            // //create pdf thumbnail
            // if($_FILES['video_file']['type']=='application/pdf'){
            //     $upload_path = FCPATH . 'uploads/'.$videos_training['video'];
            //     $ex = explode(".",$videos_training['video']);
            //     $thumb_name = $ex[0].'.jpg';
            //     $this->genPdfThumbnail($upload_path,$thumb_name); // generates /uploads/my.jpg
            // }else{
            //     $thumb_name = '';
            // }
            // //end create pdf thumbnail
        } else {
            return "-4";
        }
        $user_type = $videos_training['visible_by'];
        //$videos_training['pdf_thumb'] = $thumb_name;
        $videos_training['visible_by'] = implode(",", $videos_training['visible_by']);
        $videos_training['sort_order'] = $this->get_last_sort_order()['sort_order'] + 1;
        $this->db->insert('videos_training', $videos_training);
        $id = $this->db->insert_id();
        foreach ($user_type as $type) {
            $user_type_data = [
                'training_id' => $id,
                'user_type' => $type
            ];
            $this->db->insert('training_materials_user_type', $user_type_data);
        }
        $attachments = [];
        $files = $_FILES["upload_file"];
        $filesCount = count($files['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            if ($files['name'][$i] != '') {
                $_FILES['upload_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['upload_file']['type'] = $files['type'][$i];
                $_FILES['upload_file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['upload_file']['error'] = $files['error'][$i];
                $_FILES['upload_file']['size'] = $files['size'][$i];
                $upload_file = common_upload('upload_file');
                if ($upload_file['success'] == 1) {
                    $attachments[$i]['file_name'] = $upload_file['status_msg'];
                    $attachments[$i]['videos_training_id'] = $id;
                } else {
                    return "-5";
                }
            }
        }
        if (!empty($attachments)) {
            $this->db->insert_batch('videos_files', $attachments);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    function genPdfThumbnail($source, $target)
    {
        //$source = realpath($source);
        $target = dirname($source).DIRECTORY_SEPARATOR.$target;
        $im     = new Imagick($source."[0]"); // 0-first page, 1-second page
        $im->setImageColorspace(255); // prevent image colors from inverting
        $im->setimageformat("jpeg");
        $im->thumbnailimage(200, 283); // width and height
        $im->writeimage($target);
        $im->clear();
        $im->destroy();
    }

    public function load_videos($title, $keywords, $main_cat, $sub_cat, $visible_by) {
        $this->db->select('vt.*,vt.video as file_name,vmc.name as main_cat_name,vsc.name as sub_cat_name,tmut.user_type');
        $this->db->from('videos_training vt');
//        $this->db->join('videos_files vf', 'vf.videos_training_id = vt.id');
        $this->db->join('videos_main_cat vmc', 'vmc.id = vt.main_cat');
        $this->db->join('videos_sub_cat vsc', 'vsc.id = vt.sub_cat');
        $this->db->join('training_materials_user_type tmut', 'tmut.training_id = vt.id');
        $sql = '';
        if ($title != '') {
            if ($sql == '') {
                $sql .= ' (vt.title like "' . $title . '%" OR vt.keywords like "' . $title . '%")';
            } else {
                $sql .= ' and (vt.title like "' . $title . '%" OR vt.keywords like "' . $title . '%")';
            }
        }
//        if ($keywords != '') {
//            if ($sql == '') {
//                $sql .= ' vt.keywords like "' . $keywords . '%"';
//            } else {
//                $sql .= ' and vt.keywords like "' . $keywords . '%"';
//            }
//        }
        if ($main_cat != '') {
            if ($sql == '') {
                $sql .= ' vt.main_cat="' . $main_cat . '"';
            } else {
                $sql .= ' and vt.main_cat="' . $main_cat . '"';
            }
        }
        if ($sub_cat != '') {
            if ($sql == '') {
                $sql .= ' vt.sub_cat="' . $sub_cat . '"';
            } else {
                $sql .= ' and vt.sub_cat="' . $sub_cat . '"';
            }
        }
        if ($visible_by != '') {
            if ($sql == '') {
                $sql .= ' tmut.user_type="' . $visible_by . '"';
            } else {
                $sql .= ' and tmut.user_type="' . $visible_by . '"';
            }
        }
        if ($sql != '') {
            $this->db->where($sql);
        }
        $this->db->group_by('vt.id');
        $this->db->order_by('vt.sort_order', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function fetch_data($id) {
        return $this->db->query("select * from videos_training where id='" . $id . "'")->row_array();
    }

    public function get_sub_cats_by_main($id) {
        return $this->db->query("select * from videos_sub_cat where main_cat_id='" . $id . "'")->result_array();
    }

    public function fetch_file_data($id) {
        return $this->db->query("select * from videos_files where videos_training_id='" . $id . "'")->result_array();
    }

    public function update_training_materials($videos_id, $videos_training) {
        if (empty($videos_training['visible_by'])) {
            return "-1";
        }
        if ($_FILES['video_file']['name'] != '') {
            $video_file = common_upload('video_file');
            if ($video_file['success'] == 1) {
                $videos_training['video'] = $video_file['status_msg'];
            }else{
                return "-4";
            }
             //create pdf thumbnail
            // if($_FILES['video_file']['type']=='application/pdf'){
            //     $upload_path = FCPATH . 'uploads/'.$videos_training['video'];
            //     $ex = explode(".",$videos_training['video']);
            //     $thumb_name = $ex[0].'.jpg';
            //     $this->genPdfThumbnail($upload_path,$thumb_name); // generates /uploads/my.jpg
            //     $videos_training['pdf_thumb'] = $thumb_name;
            // }
            // //end create pdf thumbnail
        }
        $user_type = $videos_training['visible_by'];
        $videos_training['visible_by'] = implode(",", $videos_training['visible_by']);
        $this->db->trans_begin();
        $this->db->set($videos_training)->where("id", $videos_id)->update('videos_training');

        $this->db->query("delete from training_materials_user_type where training_id='$videos_id'");
        foreach ($user_type as $type) {
            $user_type_data = [
                'training_id' => $videos_id,
                'user_type' => $type
            ];
            $this->db->insert('training_materials_user_type', $user_type_data);
        }
        $attachments = [];
        $files = $_FILES["upload_file"];
        $filesCount = count($files['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            if ($files['name'][$i] != '') {
                $_FILES['upload_file']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['upload_file']['type'] = $files['type'][$i];
                $_FILES['upload_file']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['upload_file']['error'] = $files['error'][$i];
                $_FILES['upload_file']['size'] = $files['size'][$i];
                $upload_file = common_upload('upload_file');
                if ($upload_file['success'] == 1) {
                    $attachments[$i]['file_name'] = $upload_file['status_msg'];
                    $attachments[$i]['videos_training_id'] = $videos_id;
                } else {
                    return "-5";
                }
            }
        }
        if (!empty($attachments)) {
            $this->db->insert_batch('videos_files', $attachments);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function check_if_associated_main($cat_id) {
        return $this->db->query("select * from videos_training where main_cat='" . $cat_id . "'")->num_rows();
    }

    public function check_if_associated_sub($cat_id) {
        return $this->db->query("select * from videos_training where sub_cat='" . $cat_id . "'")->num_rows();
    }

    public function check_if_has_subcat($cat_id) {
        return $this->db->query("select * from videos_sub_cat where main_cat_id='" . $cat_id . "'")->num_rows();
    }

    public function delete_training_materials($id) {
        $this->db->where("id", $id)->delete("videos_training");
        $get_files = $this->db->query("select * from videos_files where videos_training_id='" . $id . "'")->result_array();
        foreach ($get_files as $gf) {
            $path = FCPATH . 'uploads/' . $gf['file_name'];
            unlink($path);
        }
        return $this->db->where("videos_training_id", $id)->delete("videos_files");
    }

    public function add_count_views($training_material_id) {
        $this->db->set('video_views', 'video_views+1', FALSE);
        $this->db->where('id', $training_material_id);
        $this->db->update('videos_training');
        echo $this->training_material_by_id($training_material_id)['video_views'];
    }

    public function training_material_by_id($id) {
        return $this->db->get_where('videos_training', ['id' => $id])->row_array();
    }

    public function fetch_user_type($id) {
        return $this->db->get_where('training_materials_user_type', ['training_id' => $id])->result_array();
    }

    public function get_last_sort_order() {
        return $this->db->query("select * from videos_training ORDER BY id DESC LIMIT 1")->row_array();
    }

    public function sort_training_materials($sort_order, $sort_order_new, $current_item) {
        $so = explode(",", $sort_order);
        $son = explode(",", $sort_order_new);
        $final_items = [];
        foreach ($so as $key => $value) {
            $final_items[$key]['id'] = $value;
            $final_items[$key]['sort_order'] = $this->get_sort_order($value);
        }
        foreach ($son as $key => $value) {
            $new_sort_order = $final_items[$key]['sort_order'];
            $this->db->query("update videos_training set sort_order=" . $new_sort_order . " where id=" . $value . "");
        }
    }

    public function get_sort_order($idval) {
        return $this->db->query("select * from videos_training where id = $idval")->row_array()['sort_order'];
    }

    public function insert_suggestions($suggestions) {
        foreach ($suggestions as $data) {
            $insert_data = array(
                'id' => '',
                'type' => '1',
                'suggestion' => $data,
                'added_by_user' => sess('user_id'),
                'status' => 0
            );
            $this->db->insert('suggestions', $insert_data);
        }
    }

    public function training_materials_suggestions() {
        $query = "select * from suggestions where type='1'";
        return $this->db->query($query)->result_array();
    }

    public function get_training_subcat($main_cat_id) {
        $query = "select * from videos_sub_cat where main_cat_id='" . $main_cat_id . "'";
        return $this->db->query($query)->result_array();
    }

}
