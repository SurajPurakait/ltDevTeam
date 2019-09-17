<?php 

	class Operational_model extends CI_Model{
	    public function get_main_cats() {
	        return $this->db->get("operational_manuals_main_cat")->result_array();
	    }

	    public function get_sub_cats() {
	        return $this->db->query("select m.*,(select name from operational_manuals_main_cat where id=m.main_cat_id) as main_cat_name from operational_manuals_sub_cat m")->result_array();
	    }

	    public function get_operational_subcat($main_cat_id) {
	        // $query = "select * from operational_manuals_sub_cat where main_cat_id='" . $main_cat_id . "'";
	        // return $this->db->query($query)->result_array();
	    }

	    public function insert_operational_manuals_category($name, $icon) {
        	return $this->db->insert('operational_manuals_main_cat', ["name" => $name, "icon" => $icon]);
    	}

    	public function insert_operational_manuals_subcategory($name, $main_cat_id) {
        	return $this->db->insert('operational_manuals_sub_cat', ["main_cat_id" => $main_cat_id, "name" => $name]);
    	}

    	public function get_main_cat_by_id($id) {
    		return $this->db->get_where('operational_manuals_main_cat',['id'=>$id])->row_array();
    	}

    	public function get_sub_cat_by_id($id) {
        	return $this->db->query("select m.*,(select name from operational_manuals_main_cat where id=m.main_cat_id) as main_cat_name from operational_manuals_sub_cat m where m.id='" . $id . "'")->row_array();
    	}

    	public function check_if_name_exists($name, $id = null) {
	        $sql = "select * from operational_manuals_main_cat where name = '$name'";
	        if ($id != null) {
	            $sql .= ' AND id!=' . $id;
	        }
	        $data = $this->db->query($sql)->num_rows();
	        return $data;
    	}

    	public function check_if_subname_exists($name, $id = null, $main_cat_id = null) {
	        $sql = "select * from operational_manuals_sub_cat where name = '$name'";
	        if ($id != null) {
	            $sql .= ' AND id!=' . $id;
	        }
	        if ($main_cat_id != null) {
	            $sql .= ' AND main_cat_id=' . $main_cat_id;
	        }
	        $data = $this->db->query($sql)->num_rows();
	        return $data;
	    }

	    public function update_operational_manuals_category($name, $icon, $id) {
	        return $this->db->set(["name" => $name, "icon" => $icon])->where("id", $id)->update("operational_manuals_main_cat");
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

	    public function update_operational_manuals_subcategory($name, $main_name, $id) {
	        return $this->db->set(["main_cat_id" => $main_name, "name" => $name])->where("id", $id)->update("operational_manuals_sub_cat");
	    }

	    public function check_if_associated_sub($cat_id) {
	        return $this->db->query("select * from operational_manuals where sub_cat_id='" . $cat_id . "'")->num_rows();
	    }

	    public function delete_operational_manuals_subcategory($cat_id) {
	        return $this->db->where("id", $cat_id)->delete("operational_manuals_sub_cat");
	    }
	}

?>