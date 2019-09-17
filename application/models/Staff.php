<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Staff extends CI_Model
{

    public function get_staff_info($staff_id)
    {
        $this->db->select('st.*,os.office_id');
        $this->db->from('staff st');
        $this->db->join('office_staff os', 'os.staff_id=st.id');
        $this->db->where(['st.id' => $staff_id]);
        return $this->db->get()->row_array();
    }

    public function get_staff()
    {
        return $this->db->get('staff')->result_array();
    }


    # get_staff_info
    public function StaffInfo($staff_id)
    {
        $query = $this->db->query("select st.*,os.office_id from staff st inner join office_staff os on os.staff_id=st.id where st.id='$staff_id'");
        $result = $query->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    # get_staff_info


    public function AllStaff($user_id)
    {
        $query = $this->db->query('select * from staff where status=1 and id<>\'' . $user_id . '\'');
        return $query->result_array();
    }

    public function DeleteStaff($user_id)
    {
        $query = $this->db->query('update staff set status=2 where id=\'' . $user_id . '\'');
        $query2 = $this->db->query('delete from office_staff where staff_id=\'' . $user_id . '\'');
        return true;
    }

    public function getstaffoffice($staff_id)
    {
        $query = $this->db->query("select * from office_staff where staff_id='$staff_id'");
        return $query->result_array();
    }

    public function get_offices_staffwise($type)
    {
        if ($type == 'Admin' || $type == 'Corporate') {
            $query = $this->db->query("select * from office where type='Corporate'");
        } else {
            $query = $this->db->query("select * from office where type='Franchise'");
        }
        return $query->result_array();
    }

    public function get_dept_staffwise($type)
    {
        if ($type == 'Admin') {
            $query = $this->db->query("select * from department where type='1'");
        } elseif ($type == 'Franchise') {
            $query = $this->db->query("select * from department where type='2'");
        } elseif ($type == 'Corporate') {
            $query = $this->db->query("select * from department where type='3'");
        }
        return $query->result_array();
    }

    public function get_office_staff_by_office_id_staff_id($staff_id, $office_id)
    {
        return $this->db->get_where("office_staff", ["office_id" => $office_id, "staff_id" => $staff_id])->row_array();
    }

    public function get_staff_name($staff_id)
    {
        $query = $this->db->query("select * from staff where id='$staff_id'");
        return $query->result_array();
    }

    public function get_office_ids($user_id)
    {
        return $this->db->query("select group_concat(distinct(office_id) separator ',') as offices from office_staff where staff_id = '$user_id';")->row_array()["offices"];
    }

    public function get_staff_department($user_id)
    {
        return $this->db->query("select d.name as department from department as d inner join department_staff as ds on ds.department_id = d.id where ds.staff_id = '$user_id'; ")->row_array()["department"];
    }

    public function get_select_office($office_id = '')
    {
        if ($office_id == '') {
            $sql = "select id, name from office where status = 1";
        } else {
            if (strpos($office_id, ',') !== false) {
                $sql = "select id, name from office where id in ($office_id) and status = 1";
            } else {
                $sql = "select id, name from office where id='$office_id' and status = 1";
            }
        }
        return $this->db->query($sql)->result_array();
    }

    public function get_staff_office($user_id)
    {
        $query = $this->db->query("select office_id from office_staff where staff_id='$user_id'");
        return $query->row_array()["office_id"];
    }

    public function get_office_function($office_id)
    {
        $sql = "select distinct st.id, concat(st.last_name, ', ',st.first_name,' ',st.middle_name) as name from `staff` st inner join office_staff ost on ost.staff_id = st.id where st.status='1' and ost.office_id='$office_id'";
        return $this->db->query($sql)->result_array();
    }

}
