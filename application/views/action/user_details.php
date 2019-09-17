<p>Name : <?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></p>
<p>Department : <?php echo staff_department_name($user_details['department']); ?></p>
<p>User Type : <?php echo get_staff_type_by_id($user_details['type'])['name']; ?></p>
