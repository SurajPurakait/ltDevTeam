<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author rafael
 */
class Dashboard extends CI_Model{
    
    public function listOrders(){

      $user_id = $this->session->userdata('user_id');
      $ci = &get_instance();
      $ci->load->model('Staff');
      $user_info = $ci->Staff->StaffInfo($user_id);
      $user_dept = $user_info[0]['department']; 
      $usertype = $user_info[0]['type']; 
        
        $this->load->model('System');
        $this->load->model('Notes');

         if($usertype=='Admin'){
           $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
                concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept
                from `order` o
                inner join company c on c.id = o.reference_id
                inner join staff st on st.id = o.staff_requested_service
                order by o.order_date desc";
          }elseif($usertype=='Corporate'){

                if (strpos($user_dept, ',') !== false) {
                       $ex = explode(',',$user_dept);
                       $newcatarr=[];
                       foreach($ex as $x){
                           $inner_sql = 'select * from services where description like "'.$x.'%"'; 
                            $inner_result = $this->db->query($inner_sql)->result_array();
                            if(!empty($inner_result)){
                                foreach($inner_result as $ir){
                                  $newcatarr[] = $ir['id'];  
                                }                                
                            } 
                       }

                       $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
                            concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept
                            from `order` o
                            inner join company c on c.id = o.reference_id
                            inner join staff st on st.id = o.staff_requested_service";

                        if(!empty($newcatarr)){
                            foreach ($newcatarr as $value) {
                               $where[]="o.service_id = '$value'"; 
                            }
                        }

                        $condition = (count($where)>0)?implode(' or ',$where):'';

                        $sql .= ($condition!='')?" where ".$condition:'';

                       $sql .= " order by o.order_date desc";
                    }else{
                       $inner_sql = 'select * from services where description like "'.$user_dept.'%"'; 
                       $inner_result = $this->db->query($inner_sql)->result_array();
                       if(!empty($inner_result)){
                            $inner_val = $inner_result[0]['id'];
                               $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
                                    concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept
                                    from `order` o
                                    inner join company c on c.id = o.reference_id
                                    inner join staff st on st.id = o.staff_requested_service where o.service_id='$inner_val'
                                    order by o.order_date desc";
                       }
                //        else{
                //         $sql="select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,
                // concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept
                // from `order` o
                // inner join company c on c.id = o.reference_id
                // inner join staff st on st.id = o.staff_requested_service
                // order by o.order_date desc";
                //        }
                       
                    } 
          }else{
            $staff_id = $user_info[0]['id']; 
            $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
                concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept
                from `order` o
                inner join company c on c.id = o.reference_id
                inner join staff st on st.id = o.staff_requested_service where o.staff_requested_service='$staff_id'
                order by o.order_date desc";         
          }
       
        $conn = $this->db;
        $data = $conn->query($sql)->result();
       // echo "<pre>";
       // print_r($data);exit;

        $cat = $this->db->query("select * from category")->result_array();
        echo '<select class="category-dropdown"><option value="">Select</option>';
        foreach($cat as $c){
          echo '<option value="'.$c["id"].'">'.$c["name"].'</option>';
        }
        echo '</select>';
        echo ' <label class="filter-text"></label>';
        echo '<input id="hiddenflag" value="" type="hidden">';
        echo '<div class="ajaxdiv">';
        if ($data){
            foreach ($data as $row){
                $note_count = $this->Notes->getNoteCount('company',$row->reference_id);
                $status = $row->status;
                if($status==0){
                    $tracking = 'Completed';
                }elseif($status==1){
                    $tracking = 'Started';
                }elseif ($status==2) {
                    $tracking = 'Not Started';  
                }
                 $sql_query = "select idata.*,(select name from office where id=idata.office) as office_name from internal_data idata where idata.reference='".$row->reference."' and idata.reference_id='".$row->reference_id."'";
        
                $conn = $this->db;
                $sql_query_result = $conn->query($sql_query)->row();
                if(!empty($sql_query_result)){
                    $office_name = $sql_query_result->office_name;
                }
                else{
                    $office_name = '-';
                }
                //print_r($sql_query_result);
                /*
                $get_service_ids = $this->db->query("select * from service_request where order_id='".$row->id."'")->result_array();
                $target_start_vals = '';
                $target_end_vals = '';
                $i = 0;
                $len = count($get_service_ids);
                $order_date = $row->order_date;
                foreach ($get_service_ids as $value) {
                    $target_query = $this->db->query("select * from target_days where service_id='".$value['services_id']."'")->result_array(); 
                    if ($i == $len - 1) {
                        $target_start = $target_query[0]['start_days'];
                        $target_end = $target_query[0]['end_days'];
                        $start_date =  date('Y-m-d', strtotime($order_date. ' + '.$target_start.' days'));
                        $end_date =  date('Y-m-d', strtotime($start_date. ' + '.$target_end.' days'));
                        $target_start_vals .= $start_date; 
                        $target_end_vals .= $end_date;
                    }else{
                        $target_start = $target_query[0]['start_days'];
                        $target_end = $target_query[0]['end_days'];
                        $start_date =  date('Y-m-d', strtotime($order_date. ' + '.$target_start.' days'));
                        $end_date =  date('Y-m-d', strtotime($start_date. ' + '.$target_end.' days'));
                        $target_start_vals .= $start_date.', '; 
                        $target_end_vals .= $end_date.', ';
                    }
                   $i++;
                }
                $target_start_vals_arr = explode(",",$target_start_vals);
                $target_end_vals_arr = explode(",",$target_end_vals);
                                
                // foreach($target_start_vals_arr as $date){
                //     $interval1[] = abs(strtotime($order_date) - strtotime($date));
                // }
                // asort($interval1);
                // $closest = key($interval1);

                usort($target_start_vals_arr, function($a, $b) {
                    $dateTimestamp1 = strtotime($a);
                    $dateTimestamp2 = strtotime($b);

                    return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
                });

                usort($target_end_vals_arr, function($a, $b) {
                    $dateTimestamp1 = strtotime($a);
                    $dateTimestamp2 = strtotime($b);

                    return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
                });  */

                $late_status = $row->late_status;
                if($late_status=='1' && $status==1){
                    $late_class = $row->dept.'-late';
                }else{
                    $late_class = '';
                }               

                echo '<div class="panel panel-default service-panel category'.$row->category_id.' filter-'.$row->dept.'-'.$status.' '.$late_class.'">
                <div class="panel-heading">';
                 if($usertype=='Franchise'){
                    if($status==2){
                    if($row->category_id==1){
                        echo '<a href="'.base_url().'Services/incorporation/editorder/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                    }else{
                        if($row->service_id==10 || $row->service_id=='41'){
                          $res = $this->db->get_where("bookkeeping",["company_id" => $row->reference_id])->row_array();
                            if(!empty($res)){
                                if($res['sub_category'] == 2){
                                    echo '<a href="'.base_url().'Services/AccountingServices/editbookkeepingbydate/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                                }else{
                                    echo '<a href="'.base_url().'Services/AccountingServices/editbookkeeping/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                                }
                            }else{
                                echo '<a href="'.base_url().'Services/AccountingServices/editbookkeeping/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                            }  
                        }elseif($row->service_id=='11'){
                            echo '<a href="'.base_url().'Services/AccountingServices/editpayroll/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                        }
                        
                     }
                   } //status checking
                 }else{
                    if($row->category_id==1){
                        echo '<a href="'.base_url().'Services/incorporation/editorder/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                    }else{
                        if($row->service_id==10 || $row->service_id=='41'){
                          $res = $this->db->get_where("bookkeeping",["company_id" => $row->reference_id])->row_array();
                            if(!empty($res)){
                                if($res['sub_category'] == 2){
                                    echo '<a href="'.base_url().'Services/AccountingServices/editbookkeepingbydate/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                                }else{
                                    echo '<a href="'.base_url().'Services/AccountingServices/editbookkeeping/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                                }
                            }else{
                                echo '<a href="'.base_url().'Services/AccountingServices/editbookkeeping/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                            }  
                        }elseif($row->service_id=='11'){
                            echo '<a href="'.base_url().'Services/AccountingServices/editpayroll/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                        }
                        
                    }
                 }
                  echo '<a href="'.base_url().'Dashboard/download_pdf/'.$row->id.'/'.$row->category_id.'/'.$row->reference_id.'/'.$row->service_id.'" class="btn btn-primary btn-xs btn-service-pdf bookkeepingbydate"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Pdf</a>';
                 // echo '<a href="#" class="btn btn-primary btn-xs btn-service-pdf bookkeepingbydate"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Pdf</a>';
                echo '<h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row->id.'" aria-expanded="false" class="collapsed">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                <tr>
                                    <th>Order#</th>
                                    <th style="width:120px;">Client Name</th>
                                    <th>Tracking</th>
                                    <th>Requested</th>
                                    <th>Office</th>
                                    <th>'.(($row->status=="2" || $row->status=="3")  ? "Target Start" : "Start Date").'</th>
                                    <th>'.(($row->status=="2" || $row->status=="3")  ? "Target Complete" : "Complete Date").'</th>
                                    <th>Amount$$$</th>
                                    <th>Requested by</th>
                                    <th>Notes</th>
                                    <th>Services</th>
                                </tr>
                                <tr>
                                    <td title="ID">#'.$row->id.'</td>
                                    <td title="Client Name">'.$row->client_name.'</td>
                                    <td title="Tracking"><span class="label label-primary">'.$tracking.'</span></td>
                                    <td title="Order Date">'.$this->System->normalizeDate($row->order_date).'</td>
                                    <td title="Office">'.$office_name.'</td>';
                                    if($row->start_date!=''){
                                        echo '<td align="left" title="Start Date">'.date("Y-m-d", strtotime($row->start_date)).'</td>';
                                    }else{
                                      echo '<td align="left" title="Start Date">-</td>';
                                    }
                                    if($row->complete_date!=''){
                                        echo '<td align="left" title="Complete Date">'.date("Y-m-d", strtotime($row->complete_date)).'</td>';
                                    }else{
                                      echo '<td align="left" title="Complete Date">-</td>';
                                    }
                                    if($row->total_of_order!='' && isset($row->total_of_order)){
                                        $total = '$'.$row->total_of_order;
                                    }else{
                                        $total = '-';
                                    }
                                
                                 echo '<td title="Amount">'.$total.'</td>
                                    <td title="Requested by">'.$row->requested_staff.'</td>
                                    <td title="Notes"><span>'.(($note_count > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_notes(\''.$row->reference.'\',\''.$row->reference_id.'\')"><b>'.$note_count.'</b></a>' : '<b class="label label-warning">'.$note_count.'</b>').'</span></td>
                                    <td title="Services"><span class="label label-warning">'.$this->get_services_count($row->id).'</span></td>
                                </tr>
                            </table>
                        </div>
                    </h5>
                </div>';
                //if($row->service_id!='11'){
                echo '<div id="collapse'.$row->id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                <table class="table table-borderless">';
                
                $this->listServicesOrder($row->id,$status,$row->reference_id);
                
                echo '</table></div></div></div>';
                //}
                echo '</div>';
                //echo '<td><a href="javascript:void(0);" class="start_process" id="'.$row->id.'">Start Process</a></td>';
            }
        }else{
            return false;
        }
        
    }

    public function get_services_count($order_id){
        $this->db->where(['order_id' => $order_id]);
        return $this->db->get('service_request')->num_rows();
    }
    
    private function listServicesOrder($order_id,$status,$ref_id){

      $user_id = $this->session->userdata('user_id');
      $ci = &get_instance();
      $ci->load->model('Staff');
      $user_info = $ci->Staff->StaffInfo($user_id);
      $user_type = $user_info[0]['department'];
      $usertype = $user_info[0]['type'];  
        
        $this->load->model('System');
        $sql = "select 
                sr.id as rowid,sr.services_id as id,sr.id as service_req_id,sr.order_id, sr.price_charged, sr.tracking, sr.date_started, sr.date_completed, sr.beginning_month, sr.frequency,sr.status,
                s.description as service_name, s.retail_price,
                sr.responsible_staff as responsible_staff_id, concat(st.last_name, ', ', st.first_name) as responsible_staff,
                sr.responsible_department as responsible_department_id, of.name as responsible_department,
                (select name from department where id = s.dept) as service_department_name,
                (select department from staff where id = '". $this->session->userdata('user_id') ."') as staff_dept
                from service_request sr
                inner join services s on s.id = sr.services_id
                inner join staff st on st.id = sr.responsible_staff
                inner join office of on of.id = sr.responsible_department
                where sr.order_id = $order_id";
        
        $conn = $this->db;
        $data = $conn->query($sql)->result();
        echo "<tr><th style='width:11%;'>Name</th><th style='width:11%;'>Retail Price</th><th style='width:11%;'>Override Price</th><th style='width:11%;'>Responsible Dept</th><th style='width:11%;'>Tracking Description</th><th style='width:11%;'>Target Start</th><th>Target Complete</th><th style='width:11%;'>Actual Complete</th><th style='width:11%;'>Notes</th></tr>";
        //print_r($data);
        if ($data){
            foreach ($data as $row){
                $note_count = 0;
                $note_count = $this->Notes->getNoteCount('service',$row->service_req_id);
                if($row->service_name == 'Create New Company')
                    $row->service_name = "New Corporation";
                $start_date =  date('Y-m-d', strtotime($row->date_started));
                $end_date =  date('Y-m-d', strtotime($row->date_completed));
                $status = $row->status;
                if($row->status==0){
                    $tracking = 'Completed';
                    $actual_complete = $end_date;
                }elseif($row->status==1){
                    $tracking = 'Started';
                    $actual_complete = '-';
                }elseif ($row->status==2) {
                    $tracking = 'Not Started'; 
                    $actual_complete = '-'; 
                }

                if($row->id=='10' || $row->id=='41'){
                    $query = 'select sum(grand_total) as total from financial_accounts where company_id="'.$ref_id.'"';
                    $query_result = $this->db->query($query)->result_array();
                      if($query_result[0]['total']!='0'){
                           $sub_tot = $query_result[0]['total']; 
                           $query_corp = 'select * from bookkeeping where company_id="'.$ref_id.'"';
                            $query_corp_result = $this->db->query($query_corp)->result_array();
                            $corp_tax = $query_corp_result[0]['corporate_tax_return'];
                            if($corp_tax=='y'){
                                $tot = $sub_tot + 35;
                            }else{
                                $tot = $sub_tot;
                            }
                       }else{
                            $query_sub = 'select sum(total_amount) as total from financial_accounts where company_id="'.$ref_id.'"';
                            $query_sub_result = $this->db->query($query_sub)->result_array();
                            $tot = $query_sub_result[0]['total']; 
                       }
                }    
                $staff_dept = $row->staff_dept;
                if($staff_dept!='Admin'){
                     if (strpos($staff_dept, ',') !== false) {
                        $staff_dept_arr = explode(",",$staff_dept);
                         if(in_array($row->service_department_name,$staff_dept_arr)){
                            $resp_dept = "<span class='label label-primary label-danger'>".$row->service_department_name."</span>";
                        }else{
                            $resp_dept = $row->service_department_name;
                        }
                    }else{
                        if($staff_dept == $row->service_department_name){
                            $resp_dept = "<span class='label label-primary label-danger'>".$row->service_department_name."</span>";
                        }else{
                            $resp_dept = $row->service_department_name;
                        }
                    }   
                }else{
                   $resp_dept = $row->service_department_name; 
                }                
                
                echo "<tr>
                    <td title=\"Service Name\">{$row->service_name}</td>";
                    if($row->id=='10' || $row->id=='41'){
                        echo "<td title=\"Retail Price\">\${$tot}</td>";
                    }else{
                        echo "<td title=\"Retail Price\">\${$row->retail_price}</td>";
                    }  

                echo "<td title=\"Override Price\">\${$row->price_charged}</td>    
                    <td title=\"Responsible Dept\">{$resp_dept}</td>";
                    if($user_type=="Franchise")
                    {
                        echo"<td align='left' title=\"Tracking Description\"><span class='label label-primary label-block'>".$tracking."</span></td> ";   
                    }
                    else
                    echo"<td align='left' title=\"Tracking Description\"><a href='javascript:void(0);' id='".$row->rowid."' status='".$row->status."' class='".($user_type=="Franchise" ? '' : 'change-status-inner')."'><span class='label label-primary label-block'>".$tracking."</span></a></td> ";   
                   echo" <td align='left' title=\"Start Date\">{$start_date}</td>
                    <td align='left' title=\"Complete Date\">{$end_date}</td>
                    <td align='left' title=\"Actual Complete\">{$actual_complete}</td>
                    <td title=\"Notes\"><span>".(($note_count > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_notes(\'service\',\''.$row->service_req_id.'\')"><b>'.$note_count.'</b></a>' : '<b class="label label-warning">'.$note_count.'</b>')."</span></td>
                </tr>";
            }
        }else{
            return false;
        }
        echo '</div>';
    }
    
    public function getQuantRequestedByMe($status){
        
        /* Status
         * 0 = deleted
         * 1 = completed
         * 2 = opened
         */
        
        $conn = new Connection();
        $sql = "select count(*) as total from `order` where staff_requested_service = 1 and status = $status";
        $result = $conn->query($sql);
        if ($result){
            return $result->fetch_object()->total;
        }else{
            return 0;
        }
    }

    public function ajax_dashboard_category($hidval='',$catval=''){
         $user_id = $this->session->userdata('user_id');
          $ci = &get_instance();
          $ci->load->model('Staff');
          $user_info = $ci->Staff->StaffInfo($user_id);
          $user_type = $user_info[0]['department']; 
          $staff_id = $user_info[0]['id'];
        
        $this->load->model('System');
        $this->load->model('Notes');
        $ex = explode('-', $hidval);
        $whom = $ex[0];
        $dept = $ex[1];
        $status = $ex[2];
        if($catval==''){
               if($whom=='byme'){
                    if($status==3){
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.staff_requested_service='$staff_id' and o.status='1' and o.late_status='1' order by o.order_date desc";
                    }else{
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.staff_requested_service='$staff_id' and o.status='$status' order by o.order_date desc";
                    }
               
               }else{
                    if($status==3){
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.status='1' and o.late_status='1' order by o.order_date desc";
                    }else{
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.status='$status' order by o.order_date desc";
                    }
               }
                
        }else{  //catval not blank
            if($whom=='byme'){
                    if($status==3){
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.staff_requested_service='$staff_id' and o.status='1' and o.late_status='1' and o.category_id='$catval' order by o.order_date desc";

                    }else{
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.staff_requested_service='$staff_id' and o.status='$status' and o.category_id='$catval' order by o.order_date desc";
                    }
               
               }else{
                    if($status==3){
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.status='1' and o.late_status='1' and o.category_id='$catval' order by o.order_date desc";
                    }else{
                        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id, concat(st.last_name, ', ', st.first_name) as requested_staff, st.department as dept from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service where o.status='$status' and o.category_id='$catval' order by o.order_date desc";
                    }
               }
        }
        $conn = $this->db;
        $data = $conn->query($sql)->result(); 
        if ($data){
            foreach ($data as $row){
                $note_count = $this->Notes->getNoteCount('company',$row->reference_id);
                $status = $row->status;
                if($status==0){
                    $tracking = 'Completed';
                }elseif($status==1){
                    $tracking = 'Started';
                }elseif ($status==2) {
                    $tracking = 'Not Started';  
                }

                $late_status = $row->late_status;
                if($late_status=='1' && $status==1){
                    $late_class = $row->dept.'-late';
                }else{
                    $late_class = '';
                }               

                echo '<div class="panel panel-default service-panel category'.$row->category_id.' filter-'.$row->dept.'-'.$status.' '.$late_class.'">
                <div class="panel-heading">';
                 if($user_type=='Admin'){
                    echo '<a href="'.base_url().'Services/incorporation/editorder/'.$row->id.'" class="btn btn-primary btn-xs btn-service-edit"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                 }
                echo '<h5 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$row->id.'" aria-expanded="false" class="collapsed">
                        <div class="table-responsive">
                            <table class="table table-borderless" style="margin-bottom: 0px;">
                                <tr>
                                    <th>Order#</th>
                                    <th style="width:120px;">Client Name</th>
                                    <th>Tracking</th>
                                    <th>Requested</th>
                                    <th>'.(($row->status=="2" || $row->status=="3")  ? "Target Start" : "Start Date").'</th>
                                    <th>'.(($row->status=="2" || $row->status=="3")  ? "Target Complete" : "Complete Date").'</th>
                                    <th>Amount$$$</th>
                                    <th>Requested by</th>
                                    <th>Notes</th>
                                    <th>Services</th>
                                </tr>
                                <tr>
                                    <td title="ID">#'.$row->id.'</td>
                                    <td title="Client Name">'.$row->client_name.'</td>
                                    <td title="Tracking"><span class="label label-primary">'.$tracking.'</span></td>
                                    <td title="Order Date">'.$this->System->normalizeDate($row->order_date).'</td>';
                                    if($row->start_date!=''){
                                        echo '<td align="left" title="Start Date">'.date("Y-m-d", strtotime($row->start_date)).'</td>';
                                    }else{
                                      echo '<td align="left" title="Start Date">'.($target_start_vals_arr[0] ? $target_start_vals_arr[0] : '-').'</td>';
                                    }
                                    if($row->complete_date!=''){
                                        echo '<td align="left" title="Complete Date">'.date("Y-m-d", strtotime($row->complete_date)).'</td>';
                                    }else{
                                      echo '<td align="left" title="Complete Date">'.($target_end_vals_arr[count($target_end_vals_arr) - 1] ? $target_end_vals_arr[count($target_end_vals_arr) - 1] : '-').'</td>';
                                    }
                                 echo '<td title="Amount">$'.$row->total_of_order.'</td>
                                    <td title="Requested by">'.$row->requested_staff.'</td>
                                    <td title="Notes"><span>'.(($note_count > 0) ? '<a class="label label-warning" href="javascript:void(0)" onclick="show_notes(\''.$row->reference.'\',\''.$row->reference_id.'\')"><b>'.$note_count.'</b></a>' : '<b class="label label-warning">'.$note_count.'</b>').'</span></td>
                                    <td title="Services"><span class="label label-warning">'.$this->get_services_count($row->id).'</span></td>
                                </tr>
                            </table>
                        </div>
                    </h5>
                </div>
                <div id="collapse'.$row->id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <div class="table-responsive">
                <table class="table table-borderless">';
                
                $this->listServicesOrder($row->id,$status);
                
                echo '</table></div></div></div></div>';
                //echo '<td><a href="javascript:void(0);" class="start_process" id="'.$row->id.'">Start Process</a></td>';
                echo '<script type="text/javascript">';
                echo '$(document).ready(function(){
                   $(".change-status-inner").click(function(){
                    openModal("changeStatusinner");
                    var id = $(this).attr("id");
                    var status = $(this).attr("status");
                    var txt = "Change Status of SubOrder id #"+id;
                    $("#changeStatusinner .modal-title").html(txt);
                    if(status==0){
                       $("#changeStatusinner #rad1").attr("checked","checked");
                    }else if(status==1){
                        $("#changeStatusinner #rad2").attr("checked","checked");
                    }else if(status==2){
                       $("#changeStatusinner #rad3").attr("checked","checked");
                     }
                    $("#changeStatusinner #suborderid").val(id);
                });});';
                echo '</script>';
            }
        }else{
            return false;
        }
    }
    
}
