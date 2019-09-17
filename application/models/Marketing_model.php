<?php

Class Marketing_model extends CI_Model {

    public function get_main_cats() {
        return $this->db->query("select * from marketing_main_cat")->result_array();
    }

    public function get_main_cat_by_id($id) {
        return $this->db->query("select * from marketing_main_cat where id='" . $id . "'")->row_array();
    }

    public function check_if_name_exists($name, $id = null) {
        $sql = "select * from marketing_main_cat where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function insert_marketing_materials_category($name, $icon) {
        return $this->db->insert('marketing_main_cat', ["name" => $name, "icon" => $icon]);
    }

    public function update_marketing_materials_category($name, $icon, $id) {
        return $this->db->set(["name" => $name, "icon" => $icon])->where("id", $id)->update("marketing_main_cat");
    }

    public function check_if_associated_main($cat_id) {
        return $this->db->query("select * from marketing_materials where main_cat='" . $cat_id . "'")->num_rows();
    }

    public function check_if_associated_sub($cat_id) {
        return $this->db->query("select * from marketing_materials where sub_cat='" . $cat_id . "'")->num_rows();
    }

    public function check_if_has_subcat($cat_id) {
        return $this->db->query("select * from marketing_sub_cat where main_cat_id='" . $cat_id . "'")->num_rows();
    }

    public function delete_marketing_materials_category($cat_id) {
        return $this->db->where("id", $cat_id)->delete("marketing_main_cat");
    }

    public function get_sub_cats() {
        return $this->db->query("select m.*,(select name from marketing_main_cat where id=m.main_cat_id) as main_cat_name from marketing_sub_cat m")->result_array();
    }

    public function get_sub_cat_by_id($id) {
        return $this->db->query("select m.*,(select name from marketing_main_cat where id=m.main_cat_id) as main_cat_name from marketing_sub_cat m where m.id='" . $id . "'")->row_array();
    }

    public function check_if_subname_exists($name, $id = null, $main_cat_id = null) {
        $sql = "select * from marketing_sub_cat where name = '$name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        if ($main_cat_id != null) {
            $sql .= ' AND main_cat_id=' . $main_cat_id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function insert_marketing_materials_subcategory($name, $main_cat_id) {
        return $this->db->insert('marketing_sub_cat', ["main_cat_id" => $main_cat_id, "name" => $name]);
    }

    public function update_marketing_materials_subcategory($name, $main_name, $id) {
        return $this->db->set(["main_cat_id" => $main_name, "name" => $name])->where("id", $id)->update("marketing_sub_cat");
    }

    public function delete_marketing_materials_subcategory($cat_id) {
        return $this->db->where("id", $cat_id)->delete("marketing_sub_cat");
    }

    public function get_from_type_ofc($ofc_id){
        $sql = 'select * from office where id in('.$ofc_id.')';
        return $this->db->query($sql)->result_array();
    }

    public function load_marketing_materials($main_cat, $sub_cat) {
        $staff_info = staff_info();
        $ofc_id = $staff_info['office'];
        $get_from_type_ofc = $this->get_from_type_ofc($ofc_id);
        $get_from_type_ofc = array_column($get_from_type_ofc, 'from_type');
        //print_r($get_from_type_ofc);
        $target = array('1', '2');

        if(count(array_intersect($get_from_type_ofc, $target)) == count($target)){
            $sub_query = '';
        }elseif(in_array('1',$get_from_type_ofc)){
             $sub_query = '1';
        }elseif(in_array('2',$get_from_type_ofc)){
            $sub_query = '2';
        }
        $this->db->select('mt.*,mt.featured_img as file_name,mmc.name as main_cat_name,msc.name as sub_cat_name');
        $this->db->from('marketing_materials mt');
//        $this->db->join('videos_files vf', 'vf.videos_training_id = vt.id');
        $this->db->join('marketing_main_cat mmc', 'mmc.id = mt.main_cat');
        $this->db->join('marketing_sub_cat msc', 'msc.id = mt.sub_cat');
        $sql = '';
        if ($main_cat != '') {
            if ($sql == '') {
                $sql .= ' mt.main_cat="' . $main_cat . '"';
            } else {
                $sql .= ' and mt.main_cat="' . $main_cat . '"';
            }
        }
        if ($sub_cat != '') {
            if ($sql == '') {
                $sql .= ' mt.sub_cat="' . $sub_cat . '"';
            } else {
                $sql .= ' and mt.sub_cat="' . $sub_cat . '"';
            }
        }

        if($staff_info['type']!=1){
        if($sub_query!=''){
            $this->db->join('marketing_materials_for_which mmfw', 'mmfw.marketing_id = mt.id');
            if ($sql == '') {
                $sql .= ' mmfw.for_which="' . $sub_query . '"';
            } else {
                $sql .= ' and mmfw.for_which="' . $sub_query . '"';
            }
        }
        }
        if ($sql != '') {
            $this->db->where($sql);
        }
        $this->db->group_by('mt.id');
        $this->db->order_by('mt.sort_order', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_last_sort_order() {
        return $this->db->query("select * from marketing_materials ORDER BY id DESC LIMIT 1")->row_array();
    }

    public function insert_marketing_materials($data) {
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
        $sort_order = $this->get_last_sort_order()['sort_order'] + 1;
        if($data['price_type']==2){
            $price = 0;
        }else{
            $price = $data['price'];
        }
        $insert_data = array(
            'id' => '',
            'title' => $data['title'],
            'material_desc' => $data['description'],
            'type' => $data['price_type'],
            'price' => $price,
            'main_cat' => $data['main_cat'],
            'sub_cat' => $data['sub_cat'],
            'featured_img' => $imgurl,
            'sort_order' => $sort_order
        );
        $this->db->insert('marketing_materials', $insert_data);
        $id = $this->db->insert_id();

        $for_which = $data['for_which'];
        foreach($for_which as $fw){
            $insert_for_which = array(
                'id' => '',
                'marketing_id' => $id,
                'for_which' => $fw
            );
            $this->db->insert('marketing_materials_for_which', $insert_for_which);  
        }
         $language = $data['language'];
        foreach($language as $l){
            $insert_language = array(
                'id' => '',
                'marketing_id' => $id,
                'language' => $l
            );
            $this->db->insert('marketing_materials_language', $insert_language);  
        }

        if($data['price_type']==2){

        $dynamic_price = $data['dynamic_price'];
        $dynamic_quantity = $data['dynamic_quantity'];

        if(!empty($dynamic_price) && !empty($dynamic_quantity)){
          foreach($dynamic_price as $key=>$dp){
            $dq = $dynamic_quantity[$key];
            if($dp!=0 && $dq!=0){
            $insert_dynamic_price_quantity = array(
                'id' => '',
                'marketing_id' => $id,
                'price' => $dp,
                'quantity' => $dq
            );
             $this->db->insert('marketing_materials_dynamic_price_quantity', $insert_dynamic_price_quantity); 
            } 
            }
        }
       }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_subcat_by_maincat($main_cat) {
        return $this->db->query("select * from marketing_sub_cat where main_cat_id='" . $main_cat . "'")->result_array();
    }

    public function delete_marketing_materials($id) {
        $get_files = $this->db->query("select * from marketing_materials where id='" . $id . "'")->row_array();
        $path = FCPATH . 'uploads/' . $get_files['featured_img'];
        unlink($path);
        return $this->db->where("id", $id)->delete("marketing_materials");
    }

    public function get_sub_cats_by_main($id) {
        return $this->db->query("select * from marketing_sub_cat where main_cat_id='" . $id . "'")->result_array();
    }

    public function fetch_data($id) {
        return $this->db->query("select * from marketing_materials where id='" . $id . "'")->row_array();
    }

    public function fetch_for_which($id) {
        return $this->db->query("select * from marketing_materials_for_which where marketing_id='" . $id . "'")->result_array();
    }

    public function fetch_language($id) {
        return $this->db->query("select * from marketing_materials_language where marketing_id='" . $id . "'")->result_array();
    }

    public function fetch_dynamic_price_quantity($id) {
        return $this->db->query("select * from marketing_materials_dynamic_price_quantity where marketing_id='" . $id . "'")->result_array();
    }

    public function update_marketing_materials($mkt_id, $data) {
        if ($_FILES['image_file']['name'] != '') {
            $image_file = common_upload('image_file');
            if ($image_file['success'] == 1) {
                $imgurl = $image_file['status_msg'];
            }
        } else {
            $get_files = $this->db->query("select * from marketing_materials where id='" . $mkt_id . "'")->row_array();
            $imgurl = $get_files['featured_img'];
        }

        $sort_order = $this->get_last_sort_order()['sort_order'] + 1;
        if($data['price_type']==2){
            $price = 0;
        }else{
            $price = $data['price'];
        }
        $update_data = array(
            'title' => $data['title'],
            'material_desc' => $data['description'],
            'type' => $data['price_type'],
            'price' => $price,
            'main_cat' => $data['main_cat'],
            'sub_cat' => $data['sub_cat'],
            'featured_img' => $imgurl,
            'sort_order' => $sort_order
        );

        $this->db->trans_begin();
        $this->db->set($update_data)->where("id", $mkt_id)->update('marketing_materials');

        $for_which = $data['for_which'];
        $this->db->delete('marketing_materials_for_which', array('marketing_id' => $mkt_id));
        foreach($for_which as $fw){
            $insert_for_which = array(
                'id' => '',
                'marketing_id' => $mkt_id,
                'for_which' => $fw
            );
            $this->db->insert('marketing_materials_for_which', $insert_for_which);  
        }
         $language = $data['language'];
         $this->db->delete('marketing_materials_language', array('marketing_id' => $mkt_id));
        foreach($language as $l){
            $insert_language = array(
                'id' => '',
                'marketing_id' => $mkt_id,
                'language' => $l
            );
            $this->db->insert('marketing_materials_language', $insert_language);  
        }

        if($data['price_type']==2){
        $dynamic_price = $data['dynamic_price'];
        $dynamic_quantity = $data['dynamic_quantity'];

        if(!empty($dynamic_price) && !empty($dynamic_quantity)){
            $this->db->delete('marketing_materials_dynamic_price_quantity', array('marketing_id' => $mkt_id));
          foreach($dynamic_price as $key=>$dp){
            $dq = $dynamic_quantity[$key];
            if($dp!=0 && $dq!=0){
            $insert_dynamic_price_quantity = array(
                'id' => '',
                'marketing_id' => $mkt_id,
                'price' => $dp,
                'quantity' => $dq
            );
             $this->db->insert('marketing_materials_dynamic_price_quantity', $insert_dynamic_price_quantity);  
             }
            }
        }
      }else{
        $this->db->delete('marketing_materials_dynamic_price_quantity', array('marketing_id' => $mkt_id));
      }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function add_to_cart($mkt_id, $quantity, $lang) {
        if(!empty($lang)){
         foreach($lang as $l){
            $check_if_mkt_exists = $this->db->query("select * from cart where material_id='" . $mkt_id . "' and language='".$l."' and added_by_user='" . sess('user_id') . "'")->num_rows();
            if ($check_if_mkt_exists == 0) {
                $insert_data = array(
                    'id' => '',
                    'material_id' => $mkt_id,
                    'added_by_user' => sess('user_id'),
                    'quantity' => $quantity,
                    'language' => $l
                );
                $this->db->insert('cart', $insert_data);
            } else {
                $update_query = "update cart set quantity = quantity + " . $quantity . " where material_id='" . $mkt_id . "' and language='".$l."' and added_by_user='" . sess('user_id') . "'";
                $this->db->query($update_query);
            }
          }  
        }
    }

    public function cart_count() {
        $query = "select * from cart where added_by_user='" . sess('user_id') . "'";
        return $this->db->query($query)->num_rows();
    }

    public function fetch_cart_data() {
        $query = "select mt.*,c.* from cart c inner join marketing_materials mt on mt.id = c.material_id where c.added_by_user='" . sess('user_id') . "'";
        return $this->db->query($query)->result_array();
    }

    public function change_quantity($cart_id, $quantity) {
        $update_query = "update cart set quantity = " . $quantity . " where id='" . $cart_id . "'";
        $this->db->query($update_query);
    }

    public function updated_itemval($cart_id) {
        $query = "select SUM(mt.price*c.quantity) AS total_item_price,c.* from cart c inner join marketing_materials mt on mt.id=c.material_id where c.id='" . $cart_id . "'";
        $result = $this->db->query($query)->row_array();
        return $result;
    }

    public function removecartItem($cart_data) {
        foreach ($cart_data as $cd) {
            $this->db->query("delete from cart where id='" . $cd['id'] . "'");
        }
    }

    public function insertpurchaseList($cart_data, $TransactionID) {
        foreach ($cart_data as $cd) {
            $insert_data = array(
                'id' => '',
                'material_id' => $cd['material_id'],
                'cart_id' => $cd['id'],
                'amount' => $cd['price'],
                'quantity' => $cd['quantity'],
                'language' => $cd['language'],
                'transaction_id' => $TransactionID,
                'purchased_by' => sess('user_id')
            );
            $this->db->insert('marketing_materials_purchase_list', $insert_data);
        }
    }

    public function load_marketing_materials_purchase_list($type, $main_cat, $sub_cat, $ofc, $staff) {
        $this->db->select('mt.*,pl.*,os.office_id');
        $this->db->from('marketing_materials_purchase_list pl');
        $this->db->join('marketing_materials mt', 'mt.id = pl.material_id');
        $this->db->join('office_staff os', 'os.staff_id = pl.purchased_by');
        $sql = '';
        if ($type != 1) {
            if ($sql == '') {
                $sql .= " pl.purchased_by='" . sess('user_id') . "'";
            } else {
                $sql .= " and pl.purchased_by='" . sess('user_id') . "'";
            }
        }
        if ($main_cat != '') {
            if ($sql == '') {
                $sql .= ' mt.main_cat="' . $main_cat . '"';
            } else {
                $sql .= ' and mt.main_cat="' . $main_cat . '"';
            }
        }
        if ($sub_cat != '') {
            if ($sql == '') {
                $sql .= ' mt.sub_cat="' . $sub_cat . '"';
            } else {
                $sql .= ' and mt.sub_cat="' . $sub_cat . '"';
            }
        }
        if ($ofc != '') {
            if ($sql == '') {
                $sql .= " os.office_id='" . $ofc . "'";
            } else {
                $sql .= " and os.office_id='" . $ofc . "'";
            }
        }
        if ($staff != '') {
            if ($sql == '') {
                $sql .= " pl.purchased_by='" . $staff . "'";
            } else {
                $sql .= " and pl.purchased_by='" . $staff . "'";
            }
        }
        if ($sql != '') {
            $this->db->where($sql);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function remove_from_cart($mkt_id) {
        $this->db->query("delete from cart where id='" . $mkt_id . "'");
    }

    public function total_cart_price() {
        $query = "select SUM(mt.price*c.quantity) AS total_cart_price,c.* from cart c inner join marketing_materials mt on mt.id=c.material_id where c.added_by_user='" . sess('user_id') . "'";
        $result = $this->db->query($query)->row_array();
        return $result['total_cart_price'];
    }

    public function updatePurchaseStatus($status, $id) {
        return $this->db->set(["status" => $status])->where("id", $id)->update("marketing_materials_purchase_list");
    }

    public function updateSuggestionStatus($status, $id) {
        return $this->db->set(["status" => $status])->where("id", $id)->update("suggestions");
    }

    public function insert_suggestions($suggestions) {
        foreach ($suggestions as $data) {
            $insert_data = array(
                'id' => '',
                'type' => '2',
                'suggestion' => $data,
                'added_by_user' => sess('user_id'),
                'status' => 0
            );
            $this->db->insert('suggestions', $insert_data);
        }
    }

    public function marketing_materials_suggestions() {
        $query = "select * from suggestions where type='2'";
        return $this->db->query($query)->result_array();
    }

    public function get_marketing_subcat($main_cat_id) {
        $query = "select * from marketing_sub_cat where main_cat_id='" . $main_cat_id . "'";
        return $this->db->query($query)->result_array();
    }

    public function get_marketing_languages($id){
        $query = "select * from marketing_materials_language where marketing_id='" . $id . "'";
        return $this->db->query($query)->result_array();
    }

    public function check_if_discount($quan,$marketing_id){
        $query = "select * from marketing_materials_dynamic_price_quantity where marketing_id='" . $marketing_id . "' and quantity<='".$quan."' order by quantity desc";
        return $this->db->query($query)->row_array();
    }

    public function marketing_q_p($marketing_id){
        $query = "select * from marketing_materials_dynamic_price_quantity where marketing_id='" . $marketing_id . "'";
        return $this->db->query($query)->result_array();
    }

    public function get_dynamic_price($marketing_id,$quantity){
         $query = "select * from marketing_materials_dynamic_price_quantity where marketing_id='" . $marketing_id . "' and quantity='".$quantity."'";
        return $this->db->query($query)->row_array()['price'];
    }

}
