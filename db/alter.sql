*
 * Created: 13 Mar, 2018
 */

/* import office_type.sql */

ALTER TABLE `office` CHANGE `status` `status` INT(11) NOT NULL DEFAULT '1' COMMENT '1 for default, 2 for delete'; 

/**
 * Created: 15 Mar, 2018
 */

/*  department_staff.sql  */
/*  staff_type.sql  */

/* 06.04.2018 */

ALTER TABLE `action_files` CHANGE `action_table_id` `action_id` INT(11) UNSIGNED NOT NULL;
ALTER TABLE `action_files` CHANGE `file_name` `file_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `action_files` CHANGE `file_name` `file_name` VARCHAR(255) NOT NULL;
CREATE TABLE `action_notes` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `action_id` INT UNSIGNED NOT NULL , `note` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `action_staffs` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `action_id` INT UNSIGNED NOT NULL , `staff_id` INT UNSIGNED NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `actions` CHANGE `id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, CHANGE `department` `department` INT UNSIGNED NOT NULL, CHANGE `client_id` `client_id` VARCHAR(255) NOT NULL, CHANGE `message` `message` TEXT NOT NULL;
ALTER TABLE `actions` ADD `added_by_user` INT UNSIGNED NOT NULL AFTER `status`;

/* 07.04.2018 */

ALTER TABLE `action_notes` ADD `added_by_user` INT UNSIGNED NOT NULL AFTER `note`;
ALTER TABLE `action_notes` ADD `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `added_by_user`;

ALTER TABLE `lead_notes` ADD `added_by_user` INT UNSIGNED NOT NULL AFTER `note`;
ALTER TABLE `lead_notes` ADD `added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `added_by_user`;


/* 10.04.2018 */
/* import reference_id_generator.sql */

/* 12.04.2018 */

	CREATE TABLE `notes_log` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `note_id` int(11) NOT NULL,
 `user_id` int(11) NOT NULL,
 `related_table_id` int(11) NOT NULL COMMENT '1 for notes, 2 for action_notes, 3 for lead_notes, 4 for payroll_employee_notes. 5 for payroll_rt6_notes',
 `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

ALTER TABLE `action_notes`
  DROP `added_by_user`,
  DROP `added_at`;

ALTER TABLE `lead_notes`
  DROP `added_by_user`,
  DROP `added_at`;

ALTER TABLE `contact_info` CHANGE `middle_name` `middle_name` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `first_name`, CHANGE `last_name` `last_name` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `contact_info` CHANGE `last_name` `last_name` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `middle_name`;


/* 13.04.2018 */

ALTER TABLE `contact_info` ADD `user_id` INT UNSIGNED NOT NULL AFTER `status`;
ALTER TABLE `documents` ADD `user_id` INT UNSIGNED NOT NULL AFTER `status`;

ALTER TABLE `payroll_employee_notes` CHANGE `notes` `note` LONGTEXT NOT NULL;

ALTER TABLE `documents` CHANGE `document` `document` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL; 

CREATE TABLE `tracking_logs` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `stuff_id` INT UNSIGNED NOT NULL , `status_value` INT UNSIGNED NOT NULL , `section_id` INT UNSIGNED NOT NULL , `related_table_id` INT UNSIGNED NOT NULL , `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), INDEX `user_id` (`stuff_id`), INDEX `section_id` (`section_id`)) ENGINE = InnoDB;

ALTER TABLE `tracking_logs` CHANGE `related_table_id` `related_table_name` VARCHAR(255) NOT NULL;

/* 09.05.2018 */

/* import table lead_mail */

ALTER TABLE `lead_mail
` ADD `schedule_date` DATE NOT NULL AFTER `subject`;

/* import table lead_mail_chain */

/* 11.05.2018 */

ALTER TABLE lead_mail_chain CONVERT TO CHARSET utf8;

ALTER TABLE `lead_mail_chain` ADD `service` INT(10) NOT NULL AFTER `id`;

ALTER TABLE `lead_mail_chain` ADD `language` INT(10) NOT NULL AFTER `service` 

/* 12.05.2018 */

ALTER TABLE `staff` ADD `phone` VARCHAR(255) NOT NULL AFTER `department`;

ALTER TABLE `staff` ADD `cell` VARCHAR(255) NOT NULL AFTER `phone`;

ALTER TABLE `staff` ADD `extension` VARCHAR(255) NOT NULL AFTER `cell`;

/* 16.05.2018 */

ALTER TABLE `staff` ADD `is_delete` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `photo`;

/* 18.05.2018 */

ALTER TABLE `staff` ADD `role` INT NOT NULL DEFAULT '0' COMMENT 'for franchise 1 for standard,2 for manager.for other 0' AFTER `is_delete`; 

/* 20.05.2018 */

/* import videos_main_cat.sql */

/* import videos_sub_cat.sql */

/* import videos_training.sql */

/* import videos_files.sql */

/* 21.05.2018 */

ALTER TABLE `actions` ADD `office` INT(11) NOT NULL AFTER `department`;

/* 28.05.2018 */

ALTER TABLE `videos_training` ADD `visible_by` VARCHAR(255) NOT NULL AFTER `sub_cat`;

/* 29.05.2018 */
ALTER TABLE `order` ADD `target_start_date` DATETIME NULL DEFAULT NULL AFTER `complete_date`, ADD `target_complete_date` DATETIME NULL DEFAULT NULL AFTER `target_start_date`;

/* 06.06.2018 */

ALTER TABLE `lead_mail` ADD `status` INT(10) NOT NULL COMMENT '0 for pending, 1 for sent' AFTER `body`;

/* 11.06.2018 */

ALTER TABLE `staff` ADD `office_manager` VARCHAR(255) NOT NULL AFTER `role`;


/* 17.07.2018 */

ALTER TABLE `order` CHANGE `status` `status` INT(11) NOT NULL COMMENT '10 for billing'; 

ALTER TABLE `order` ADD `billing_status` INT(11) NOT NULL AFTER `service_id`; 


/* 18.07.2018 */
ALTER TABLE `contact_info` ADD `manager` VARCHAR(255) NOT NULL AFTER `user_id`, ADD `company` VARCHAR(255) NOT NULL AFTER `manager`; 
INSERT INTO `contact_info_type` (`id`, `type`, `status`) VALUES (NULL, 'Manager', '1'); 
ALTER TABLE `contact_info` DROP `manager`;


/* 27.07.2018 */
/* import invoice_info.sql */

/* 09.08.2018 */
ALTER TABLE `actions` ADD `priority` INT(11) NOT NULL AFTER `complete_date`; 

/* 13.08.2018 */
ALTER TABLE `individual` ADD `added_by_user` INT(10) NOT NULL AFTER `status`;
ALTER TABLE `title` ADD `existing_reference_id` INT(10) NOT NULL AFTER `status`; 

/* run the patch --- controllers/home/patch_individual ------(for----a.php)  */
/* run the patch --- controllers/home/patch_individual2   */

ALTER TABLE `countries` ADD `sort_order` INT(11) NOT NULL AFTER `country_name`; 
/* run the patch --- controllers/home/patch_country   */


----------------------- 18/08/2018 --------------------------------
CREATE TABLE `action_assign_to_department_rel` (
  `id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_type` int(11) NOT NULL,
  `is_all` int(11) NOT NULL COMMENT 'Is assigned for all staff'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

ALTER TABLE `action_assign_to_department_rel`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `action_assign_to_department_rel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

/* run the patch at root --- insert_action_dept_rel.php   */

-- Created 20.08.2018

/* import payment_history.sql */
ALTER TABLE `payment_history` ADD `service_id` INT(11) NOT NULL AFTER `reference_id`; 

-- Created 21.08.2018
ALTER TABLE `order` ADD `quantity` INT(11) NOT NULL AFTER `service_id`; 

-- Created 27.08.2018

ALTER TABLE `actions` ADD `due_date` DATE NOT NULL AFTER `added_by_user`; 

ALTER TABLE `payment_history` ADD `is_cancel` INT(11) NOT NULL AFTER `attachment`; 

-- Created 28.08.2018
ALTER TABLE `lead_mail_chain` ADD `status` INT NOT NULL DEFAULT '1' AFTER `body`;


----Created 29.08.2018
ALTER TABLE `office` ADD `photo` VARCHAR( 200 ) NOT NULL AFTER `fax` ;

----Created 30.08.2018
/* import sales_driver_license_data.sql */
/* sales_tax_application */

ALTER TABLE `company` ADD `start_month_year` VARCHAR(100) NOT NULL AFTER `website`;

-- Created 03.09.2018
UPDATE `payment_type` SET `name` = 'Check' WHERE `payment_type`.`id` = 2; 

----Created 05.09.2018
/* import rt6_driver_license_data.sql */
/* rt6_unemployment_app */

----Created 10.09.2018
ALTER TABLE `order` ADD `invoice_id` INT(11) NOT NULL AFTER `quantity`; 

UPDATE `order` SET `order`.`invoice_id` = `order`.`reference_id`, `order`.`reference_id`= (SELECT `invoice_info`.`reference_id` FROM `invoice_info` WHERE `invoice_info`.`id` = `order`.`reference_id`) WHERE `order`.`reference` = 'invoice'

-- Created 12.09.18
-- import sales_tax_rate.sql
-- sales_tax_process.sql

----Created 14.09.2018
ALTER TABLE `bookkeeping` ADD `order_id` INT(11) NOT NULL AFTER `company_id`; 
UPDATE `bookkeeping` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `bookkeeping`.`company_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
UPDATE `bookkeeping` SET `company_id` = `existing_ref_id` WHERE `new_existing` = 0;

----Created 17.09.2018
ALTER TABLE `financial_accounts` ADD `order_id` INT(10) NOT NULL AFTER `company_id`; 
UPDATE `financial_accounts` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `financial_accounts`.`company_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
----Created 19.09.2018
ALTER TABLE `payment_history` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`;


---created 20.09.2017
ALTER TABLE `payroll_approver` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
UPDATE `payroll_approver` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `payroll_approver`.`reference_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;

ALTER TABLE `payroll_company_data` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
UPDATE `payroll_company_data` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `payroll_company_data`.`reference_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
ALTER TABLE `payroll_account_numbers` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
UPDATE `payroll_account_numbers` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `payroll_account_numbers`.`reference_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
ALTER TABLE `payroll_driver_license_data` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
UPDATE `payroll_driver_license_data` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `payroll_driver_license_data`.`reference_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
ALTER TABLE `payroll_data` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
UPDATE `payroll_data` SET `order_id` = ( SELECT `order`.`id`
FROM `order`
WHERE `order`.`reference_id` = `payroll_data`.`reference_id`
AND `order`.`reference` = 'company'
LIMIT 0 , 1 ) ;
---import sales_tax_recurring(1).sql

---created 21.09.2017
ALTER TABLE `payment_history` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 
ALTER TABLE `invoice_info` ADD `order_id` INT(11) NOT NULL AFTER `reference_id`; 

ALTER TABLE `sales_tax_recurring` CHANGE `sales_tax_id` `sales_tax_id` VARCHAR( 200 ) NOT NULL ;

/* Created 26.09.2017 */
ALTER TABLE `payment_history` ADD `type` ENUM('payment','refund') NOT NULL DEFAULT 'payment' AFTER `id`;

---import referral_partner.sql

/* Created 28.09.2017 */
ALTER TABLE `invoice_info` ADD `is_refund` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `created_time`; 

/* Created 01.10.2017 */
ALTER TABLE `invoice_info` ADD `payment_status` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '0 for default, 1 for complete' AFTER `is_refund`; 


/* Created 05.10.2018 */
ALTER TABLE `lead_management` ADD `mail_campaign_status` ENUM( '0', '1' ) NOT NULL DEFAULT '0' COMMENT '0 for no(default), 1 for yes';


/* Created 09.10.2018 */
-----import  payment_deposit.sql
-----import payment_document.sql

/* Created 10.10.2018 */
ALTER TABLE `order` ADD `order_serial_id` INT(11) NOT NULL AFTER `id`;
/* run the patch --- "patch/update_order_serial_id" */
ALTER TABLE `sales_tax_process` ADD `period_of_time_val` VARCHAR(100) NOT NULL AFTER `period_of_time`; 
/*created 11.10.2018 */
----import sales_tax_processing.sql 

----import sales_tax_process_files.sql

ALTER TABLE `sales_tax_process` ADD `period_of_time_yearval` VARCHAR(100) NOT NULL AFTER `period_of_time_val`; 

ALTER TABLE `sales_tax_application` ADD `need_rt6` VARCHAR(100) NOT NULL AFTER `void_cheque`; 

ALTER TABLE `sales_tax_processing` CHANGE `frequency_of_salestax_month` `frequency_of_salestax_val` INT(11) NOT NULL;

ALTER TABLE `sales_tax_processing` CHANGE `frequency_of_salestax_val` `frequency_of_salestax_val` VARCHAR(100) NOT NULL; 

/*created 29.10.2018 */

INSERT INTO `referred_by_source` (`id`, `source`, `status`) VALUES (NULL, 'Client', '1');

ALTER TABLE `lead_management` ADD `lead_networking` LONGTEXT NOT NULL AFTER `lead_agent` ;

----import referral_partner_note.sql

/*created 01.11.2018 */
ALTER TABLE `videos_training` ADD `video` VARCHAR(255) NOT NULL AFTER `visible_by`; 
ALTER TABLE `videos_training` ADD `video_views` INT(11) NOT NULL AFTER `video`; 



/*created 02.11.2018 */
----import renewal_dates.sql
ALTER TABLE `renewal_dates` CHANGE `date` `date` VARCHAR( 255 ) NOT NULL ;

/*created 08
.11.2018 */

ALTER TABLE `target_days` ADD `input_form` VARCHAR(10) NOT NULL AFTER `category_id`;

/*created 12.11.2018 */
--------import annual_report_price.sql

/*created 13.11.2018 */
ALTER TABLE `annual_report_price` ADD `registered_agent` INT( 11 ) NOT NULL AFTER `annual_delaware` ;

/*created 14.11.2018 */
ALTER TABLE `sales_tax_application` ADD `state_recurring` INT(100) NOT NULL AFTER `lease`;
ALTER TABLE `sales_tax_application` ADD `country_recurring` INT(100) NOT NULL AFTER `state_recurring`;

/*created 15.11.2018 */
ALTER TABLE `company` ADD `file_name` LONGTEXT NOT NULL AFTER `start_month_year` ;
ALTER TABLE `title` ADD `file_name` LONGTEXT NOT NULL AFTER `existing_reference_id` ;

/*created 19.11.2018 */
ALTER TABLE `internal_data` ADD `practice_id` VARCHAR(200) NOT NULL AFTER `client_association`;
/* run the patch --- "patch/service_shortcode" */
ALTER TABLE `actions` CHANGE `creation_date` `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 
UPDATE target_days set input_form="y" WHERE service_id in (1,41,47,44,10,47,11,13,41,3,12,14);

/*created 23.11.2018 */
ALTER TABLE `rt6_unemployment_app` ADD `need_rt6` VARCHAR(100) NOT NULL AFTER `salestax_availability`;

/*created 26.11.2018 */
ALTER TABLE `staff` CHANGE `role` `role` INT(11) NOT NULL DEFAULT '0' COMMENT 'for franchise 1 for standard,2 for manager,for corporate 3 for standard,4 for manager,for other 0';

/*created 27.11.2018 */
----import department_manager.sql
ALTER TABLE `actions` ADD `my_task` INT(11) NOT NULL AFTER `due_date`; 

/*created 28.11.2018 */
/* run the patch --- "patch/patch_update_delaware" */

/*created 06.12.2018 */
ALTER TABLE `sales_tax_processing` DROP `frequency_of_salestax_querter`;
ALTER TABLE `services` ADD `note` VARCHAR( 250 ) NOT NULL AFTER `status` ;
ALTER TABLE `services` CHANGE `note` `note` LONGTEXT NOT NULL; 

/*created 14.12.2018 */
--------import fein_application.sql

/*created 18.12.2018 */
ALTER TABLE `order` ADD `new_existing` VARCHAR(2) NOT NULL AFTER `staff_requested_service`; 

/*created 20.12.2018*/
ALTER TABLE `staff`  ADD `date` DATE NOT NULL  AFTER `password`;

/*created 26.12.2018*/
ALTER TABLE `videos_training` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
----import training_materials_user_type.sql
----import note_notification.sql

/*created 29.12.2018*/
----import order_extra_data.sql
---- add service Corporate Bylaws,20 Blank Certificates of Shares,10 extra Certificates

/*created 8.01.2018*
---import referred_lead.sql

/*created 9.01.2018*/
ALTER TABLE `videos_training` ADD `sort_order` INT(10) NOT NULL AFTER `video_views`;
SET @x = 0;
UPDATE videos_training SET sort_order = (@x:=@x+1)
ALTER TABLE `order` ADD `assign_user` INT(11) NOT NULL COMMENT 'assign user id, 0 for unassign' AFTER `invoice_id`; 

/*created 18.01.2018*/
---import sos_notification.sql
ALTER TABLE `sales_tax_process` ADD `confirmation_number` VARCHAR(100) NOT NULL AFTER `complete_date`; 
ALTER TABLE `sales_tax_process` ADD `main_salse_tax_id` INT(10) NOT NULL DEFAULT '0' COMMENT 'main sales tax id, 0 for original sales tax' AFTER `confirmation_number`; 

/*created 21.01.2018*/
ALTER TABLE `sales_tax_rate` ADD `due_date` DATE NOT NULL AFTER `rate`; 
---import marketing_main_cat.sql

/*created 28.01.2018*/
ALTER TABLE `sos_notification` ADD `post_or_reply` INT(10) NOT NULL COMMENT '1 for post 2 for reply' AFTER `added_on`; 

/*created 29.01.2018*/
---import marketing_materials.sql
---import marketing_sub_cat.sql

/*created 30.01.2018*/
---import cart.sql
---import marketing_materials_purchase_list.sql

/*created 05.02.2018*/
ALTER TABLE `marketing_materials_purchase_list` ADD `status` INT(10) NOT NULL DEFAULT '1' COMMENT '1 for not started,2 for started,3 for completed' AFTER `purchased_on`; 

/*created 08.02.2018*/
ALTER TABLE `notes_log` CHANGE `related_table_id` `related_table_id` INT(11) NOT NULL COMMENT '1 for notes, 2 for action_notes, 3 for lead_notes, 4 for payroll_employee_notes. 5 for payroll_rt6_notes, 6 for marketing notes';
---import marketing_notes.sql
---import paypal_account_details.sql


/*created 13.02.2018*/
add new lead_type `Unknown`

/*created 19.02.2018*/
---import cart_notes.sql
ALTER TABLE `marketing_materials_purchase_list` ADD `cart_id` INT(10) NOT NULL AFTER `material_id`; 

/*created 20.02.2018*/
---import suggestions.sql

/*created 25.02.2018*/
ALTER TABLE `sos_notification` DROP `staff_id`;
---import sos_notification_staff.sql
---import general_notifications.sql
ALTER TABLE `general_notifications` ADD `action` VARCHAR(50) NOT NULL AFTER `reference_id`; 

/*created 27.02.2018*/
ALTER TABLE `general_notifications` ADD `read_status` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `date`;
ALTER TABLE `general_notifications` CHANGE `date` `added_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `general_notifications` ADD `action` VARCHAR(50) NOT NULL AFTER `reference_id`; 
---import dashboard_count.sql

/*created 28.02.2018*/
ALTER TABLE `videos_main_cat` ADD `icon` VARCHAR(50) NOT NULL DEFAULT 'fa-list-alt' AFTER `name`; 
ALTER TABLE `marketing_main_cat` ADD `icon` VARCHAR(50) NOT NULL DEFAULT 'fa-list-alt' AFTER `name`; 

/*created 01.03.2018*/
ALTER TABLE `sos_notification` DROP `read_status`;
ALTER TABLE `sos_notification_staff` ADD `read_status` INT(10) NOT NULL COMMENT ' o for unread,1 for read ' AFTER `staff_id`;

/*created 04.03.2018*/
ALTER TABLE `marketing_materials` DROP `for_which`;
ALTER TABLE `marketing_materials` DROP `language`;
ALTER TABLE `cart` ADD `language` INT(10) NOT NULL AFTER `quantity`;
ALTER TABLE `marketing_materials_purchase_list` ADD `language` INT(10) NOT NULL AFTER `quantity`;

/*created 05.03.2018*/
---import marketing_materials_dynamic_price_quantity.sql
---import marketing_materials_for_which.sql
---import marketing_materials_language.sql

/*created 07.03.2018*/
ALTER TABLE `general_notifications` ADD `added_by` INT(11) NOT NULL AFTER `user_id`, ADD `assign_to_user` INT(11) NOT NULL AFTER `added_by`; 
ALTER TABLE `order_extra_data` ADD `activity` LONGTEXT NOT NULL AFTER `document_date`; 
ALTER TABLE `order_extra_data` ADD `social_activity` LONGTEXT NOT NULL AFTER `activity`, ADD `professional_license_number` VARCHAR(255) NOT NULL AFTER `social_activity`;
ALTER TABLE `dashboard_count` ADD `my_task` INT(10) NOT NULL DEFAULT '0' AFTER `all_staffs`;

/*created 11.03.2018*/
ALTER TABLE `marketing_materials` ADD `type` INT(10) NOT NULL AFTER `material_desc`;

/*created 12.03.2019 16.25 PM*/
ALTER TABLE `office` ADD `office_id` VARCHAR(255) NOT NULL AFTER `name`;
---import action_add_by_user_office.sql

/*created 15.03.2019 */
ALTER TABLE `company` CHANGE `name` `name` VARCHAR(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

/*created 25.03.2019 */
ALTER TABLE `lead_management` ADD `office` INT(11) NOT NULL AFTER `lead_source`, ADD `lead_staff` INT(11) NOT NULL AFTER `office`; 


/*created 26.03.2019 */
/* import table operational_manuals*/
/* import table operational_manuals_files*/
/* import table operational_manuals_user_type*/

/*created 27.03.2019 */
ALTER TABLE `dashboard_count` ADD `department_id` INT(10) NOT NULL COMMENT 'for action else 0' AFTER `my_task`; 
ALTER TABLE `operational_manuals` CHANGE `created_time` `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; 

/*created 28.03.2019 */
/* import messages.sql*/
/* import message_staffs.sql*/
ALTER TABLE `lead_mail_chain` ADD `submission_date` DATETIME NULL DEFAULT NULL AFTER `body`; 
ALTER TABLE `lead_mail_chain` CHANGE `submission_date` `submission_date` DATE NULL DEFAULT NULL; 
ALTER TABLE `lead_management` CHANGE `lead_networking` `lead_source_detail` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL; 

/*created 02.04.2019 */
/* import table operational_manuals*/
/* import table operational_manuals_main_cat*/
/* import table operational_manuals_sub_cat*/

/*created 03.04.2019 */
ALTER TABLE `operational_manuals` CHANGE `sub_cat_id` `sub_cat_id` INT(11) NULL DEFAULT NULL;
ALTER TABLE `operational_manuals` CHANGE `description` `description` LONGTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

/*created 05.04.2019 */
ALTER TABLE `operational_manuals_main_cat` DROP `icon`;
RENAME TABLE `operational_manuals_main_cat` TO `operational_manuals_main_title`; 
ALTER TABLE `operational_manuals` DROP `title`;
ALTER TABLE `operational_manuals` CHANGE `main_cat_id` `main_title_id` INT(11) NOT NULL; 
ALTER TABLE `operational_manuals` CHANGE `sub_cat_id` `sub_title_id` INT(11) NULL DEFAULT NULL; 
ALTER TABLE `operational_manuals_sub_cat` CHANGE `main_cat_id` `main_title_id` INT(11) NOT NULL; 
RENAME TABLE `operational_manuals_sub_cat` TO `operational_manuals_sub_title`; 
ALTER TABLE `operational_manuals` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP; 

/*created 09.04.2019 */

/* import table operational_forms */

/*created 15.04.2019 */

/* import import_failed_data.sql */

/* 16.04.2019 */ 
ALTER TABLE `documents` ADD `upload_date` TIMESTAMP NOT NULL AFTER `document`;
ALTER TABLE `payroll_wage_files` ADD `upload_date` TIMESTAMP NOT NULL AFTER `file_name`;
ALTER TABLE `sales_driver_license_data` ADD `upload_date` TIMESTAMP NOT NULL AFTER `file_name`;
ALTER TABLE `payroll_company_data` ADD `upload_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `phone_number`;

/* 17.04.2019 */ 

ALTER TABLE `lead_management` ADD `import_status` INT(10) NOT NULL DEFAULT '1' AFTER `mail_campaign_status`; 

-- 18.04.2019

-- import news_and_updates.sql
-- import news_and_update_assignto_user.sql

ALTER TABLE `news_and_updates` CHANGE `office` `office` INT(11) NULL;
ALTER TABLE `news_and_update_assignto_user` CHANGE `office_id` `office_id` INT(11) NULL;

/* 22/04/2019 */

ALTER TABLE `news_and_updates` CHANGE `office_type` `office_type` INT(11) NOT NULL;

-- import news_and_update_management_for_user.sql


/* 24/04/2019 */

ALTER TABLE `news_and_updates` ADD `subject` LONGTEXT NOT NULL AFTER `news_type`; 

ALTER TABLE `news_and_updates` ADD `is_admin_deleted` INT(1) NOT NULL DEFAULT '0' AFTER `created_by`;

/* 25/04/2019 */
-- import event.sql


/* 26/04/2019 */

ALTER TABLE `news_and_updates` ADD `is_notification_deleted` INT(1) NOT NULL DEFAULT '0' AFTER `is_admin_deleted`;

ALTER TABLE `news_and_update_management_for_user` ADD `is_notification_deleted` INT(1) NOT NULL DEFAULT '0' AFTER `is_delete`;

-- import news_and_update_department.sql
-- import news_and_update_office.sql

/* 29/04/2019 */

ALTER TABLE `order` ADD `staff_office` INT(10) NOT NULL DEFAULT '0' AFTER `assign_user`; 

/*created 30.04.2019 */
ALTER TABLE `service_request` ADD `assign_user` INT(11) NOT NULL COMMENT 'assign user id, 0 for unassign' AFTER `status`;

/*created 05.03.2019 */

ALTER TABLE `office` ADD `from_type` INT(10) NOT NULL DEFAULT '1' AFTER `type`; 

/*created 15.05.2019 */

ALTER TABLE `videos_training` ADD `pdf_thumb` VARCHAR(255) NOT NULL AFTER `video`; 

/*17.05.2019 */

-- import table project_template_main
-- import table project_template_recurrence_main
-- import table project_template_staff_main

/* 21.05.2019 */
ALTER TABLE `actions` ADD `subject` VARCHAR(255) NOT NULL AFTER `client_id`;

-- 23.05.2019
-- import project_template_task.sql
-- import template_task_note.sql

ALTER TABLE `project_template_task` ADD `department_id` INT(11) NOT NULL AFTER `tracking_description`, ADD `office_id` INT(11) NOT NULL AFTER `department_id`; 


-- 24.05.2019
ALTER TABLE `action_notes` ADD `read_status` INT(100) NOT NULL DEFAULT '0' COMMENT 'unread=0;read=1;' AFTER `added_at`;
ALTER TABLE `project_template_main` ADD `added_by_user` INT(11) NOT NULL AFTER `id`; 
ALTER TABLE `project_template_task` ADD `added_by_user` INT(11) NOT NULL AFTER `template_main_id`; 


ALTER TABLE `actions` ADD `created_office` INT(10) NOT NULL AFTER `id`; 

-- 27.05.2019

ALTER TABLE `tracking_logs` ADD `comment` LONGTEXT NOT NULL DEFAULT '' AFTER `related_table_name`; 

-- 28.05.19
ALTER TABLE `project_template_recurrence_main` ADD `due_year_1` INT(11) NULL DEFAULT NULL AFTER `due_month_1`; 

-- 30.5.19

ALTER TABLE `project_template_main` CHANGE `is_all` `ofc_is_all` INT(11) NOT NULL DEFAULT '1'; 
ALTER TABLE `project_template_main` ADD `dept_is_all` INT(11) NOT NULL DEFAULT '1' COMMENT '1 for all department staff, 0 for individual staff' AFTER `ofc_is_all`; 
ALTER TABLE `project_template_main` CHANGE `office_id` `office_id` INT(11) NOT NULL; 
ALTER TABLE `project_template_staff_main` ADD `type` INT(11) NOT NULL AFTER `staff_id`; 
-- 03.06.19
ALTER TABLE `project_template_task` ADD `is_all` INT(11) NOT NULL DEFAULT '1' COMMENT '1 for all staff, 0 for individual staff' AFTER `tracking_description`;

-- 04.06.19
ALTER TABLE `project_template_task` DROP `staff_id`;

ALTER TABLE `project_template_recurrence_main` ADD `occur_weekdays` INT(10) NOT NULL AFTER `pattern`; 
ALTER TABLE `project_template_recurrence_main` ADD `client_fiscal_year_end` INT(10) NOT NULL AFTER `occur_weekdays`; 

ALTER TABLE `project_template_recurrence_main`
  DROP `due_type`;

ALTER TABLE `project_template_recurrence_main` CHANGE `due_month_1` `due_month` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 

ALTER TABLE `project_template_recurrence_main`
  DROP `due_day_position`,
  DROP `due_day_type`,
  DROP `due_month_2`;

ALTER TABLE `project_template_recurrence_main` ADD `due_type` INT(10) NOT NULL AFTER `client_fiscal_year_end`; 

-- 05.06.19
ALTER TABLE `project_template_task` CHANGE `office_id` `office_id` INT(11) NULL DEFAULT NULL;

-- import project_template_task_staff.sql
-- import projects.sql
-- import project_note.sql
ALTER TABLE `projects` CHANGE `status` `status` INT(11) NOT NULL DEFAULT '0' COMMENT '0 for not started, 1 for started 2 for complete'; 
-- 06.06.19
ALTER TABLE `projects` DROP `project_title`;

-- 07.06.19

ALTER TABLE `project_template_recurrence_main` ADD `actual_due_day` INT(10) NOT NULL AFTER `generation_month`; 

ALTER TABLE `project_template_recurrence_main` ADD `actual_due_mwqa` INT(10) NOT NULL AFTER `actual_due_day`; 

-- 10.06.19

ALTER TABLE `sales_tax_application` ADD `contact_phone_no` VARCHAR(20) NOT NULL AFTER `country_recurring`; 

ALTER TABLE `rt6_unemployment_app` ADD `contact_phone_no` VARCHAR(200) NOT NULL AFTER `lease`; 

ALTER TABLE `sales_tax_recurring` ADD `contact_phone_no` VARCHAR(200) NOT NULL AFTER `county`; 

ALTER TABLE `sales_tax_processing` ADD `contact_phone_no` VARCHAR(200) NOT NULL AFTER `existing_practice_id`; 

-- 12.06.2019 --
ALTER TABLE `actions` ADD `created_department` INT(10) NOT NULL AFTER `created_office`;

-- 13.06.2019 --

ALTER TABLE `project_template_recurrence_main` ADD `target_start_days` INT(10) NOT NULL COMMENT 'how many days before or after' AFTER `due_year_1`; 

ALTER TABLE `project_template_recurrence_main` ADD `target_end_days` INT(10) NOT NULL COMMENT 'how many days before or after' AFTER `target_start_day`; 

ALTER TABLE `project_template_main` ADD `responsible_staff` INT(11) NULL DEFAULT NULL AFTER `office_id`; 

ALTER TABLE `project_template_main` ADD `responsible_department` INT(11) NULL DEFAULT NULL AFTER `office_id`;
ALTER TABLE `project_template_main` CHANGE `ofc_is_all` `ofc_is_all` INT(11) NULL DEFAULT NULL;

-- 14.06.19
ALTER TABLE `project_template_task` ADD `responsible_task_staff` INT(11) NULL DEFAULT NULL AFTER `office_id`; 

ALTER TABLE `project_template_task` CHANGE `is_all` `is_all` INT(11) NULL DEFAULT NULL COMMENT '1 for all staff, 0 for individual staff'; 

CREATE TABLE `project_main` LIKE `project_template_main` 

CREATE TABLE `project_recurrence_main` LIKE `project_template_recurrence_main`

CREATE TABLE `project_staff_main` LIKE `project_template_staff_main`

CREATE TABLE `project_task` LIKE `project_template_task`

CREATE TABLE `project_task_staff` LIKE `project_template_task_staff`

ALTER TABLE `project_main` ADD `project_id` INT(10) NOT NULL AFTER `template_id`; 

ALTER TABLE `project_recurrence_main` ADD `project_id` INT(10) NOT NULL AFTER `template_id`; 

ALTER TABLE `project_task` ADD `project_id` INT(10) NOT NULL AFTER `template_main_id`; 

ALTER TABLE `project_staff_main` ADD `project_id` INT(10) NOT NULL AFTER `template_id`; 

-- 18.06.19

ALTER TABLE `project_template_task` ADD `target_start_day` INT(10) NOT NULL COMMENT '1 for before due date,2 for after creation date' AFTER `target_start_date`;

ALTER TABLE `project_template_task` ADD `target_complete_day` INT(10) NOT NULL COMMENT '1 for before due date,2 for after creation date' AFTER `target_complete_date`;  

ALTER TABLE `project_task` ADD `target_start_day` INT(10) NOT NULL COMMENT '1 for before due date,2 for after creation date' AFTER `target_start_date`;

ALTER TABLE `project_task` ADD `target_complete_day` INT(10) NOT NULL COMMENT '1 for before due date,2 for after creation date' AFTER `target_complete_date`;

ALTER TABLE `notes` ADD `read_status` INT(100) NOT NULL DEFAULT '0' COMMENT 'unread=0 , read=1' AFTER `note`;

-- 19.06.19

ALTER TABLE `project_template_recurrence_main` CHANGE `actual_due_mwqa` `actual_due_month` INT(10) NOT NULL; 

ALTER TABLE `project_recurrence_main` CHANGE `actual_due_mwqa` `actual_due_month` INT(10) NOT NULL;

ALTER TABLE `project_template_recurrence_main` ADD `actual_due_year` INT(10) NOT NULL AFTER `actual_due_month`; 

ALTER TABLE `project_recurrence_main` ADD `actual_due_year` INT(10) NOT NULL AFTER `actual_due_month`; 

ALTER TABLE `project_task` ADD `date_completed` DATETIME NULL AFTER `created_at`; 
ALTER TABLE `project_recurrence_main` ADD `actual_due_year` INT(10) NOT NULL AFTER `actual_due_month`; 

ALTER TABLE `project_recurrence_main` ADD `fye_day` INT(10) NOT NULL DEFAULT '0' AFTER `client_fiscal_year_end`; 

ALTER TABLE `project_recurrence_main` ADD `fye_is_weekday` INT(10) NOT NULL DEFAULT '0' AFTER `fye_day`; 

ALTER TABLE `project_recurrence_main` ADD `fye_month` INT(10) NOT NULL DEFAULT '0' AFTER `fye_is_weekday`; 

ALTER TABLE `project_template_recurrence_main` ADD `fye_day` INT(10) NOT NULL DEFAULT '0' AFTER `client_fiscal_year_end`;

ALTER TABLE `project_template_recurrence_main` ADD `fye_is_weekday` INT(10) NOT NULL DEFAULT '0' AFTER `fye_day`;

ALTER TABLE `project_template_recurrence_main` ADD `fye_month` INT(10) NOT NULL DEFAULT '0' AFTER `fye_is_weekday`;

ALTER TABLE `project_template_recurrence_main` ADD `fye_type` INT(10) NOT NULL DEFAULT '0' AFTER `client_fiscal_year_end`; 

ALTER TABLE `project_recurrence_main` ADD `fye_type` INT(10) NOT NULL DEFAULT '0' AFTER `client_fiscal_year_end`;

-- 20.06.19

ALTER TABLE `projects` ADD `client_type` INT(11) NOT NULL AFTER `template_id`; 

ALTER TABLE `projects` CHANGE `office_id` `office_id` INT(11) NULL DEFAULT NULL; 


/***** 25/06/2019 *****/
ALTER TABLE `general_notifications` ADD `tracking_status` VARCHAR(100) NOT NULL AFTER `action`; 

-- 26.06.19

ALTER TABLE `documents` ADD `order_id` INT(11) NULL DEFAULT NULL AFTER `user_id`; 

-- 05.07.19

ALTER TABLE `service_request` ADD `date_start_actual` DATETIME NULL DEFAULT NULL AFTER `date_started`; 

ALTER TABLE `service_request` ADD `date_complete_actual` DATETIME NULL DEFAULT NULL AFTER `date_completed`; 

-- 11.07.19

ALTER TABLE `project_task` ADD `date_started` DATETIME NULL DEFAULT NULL AFTER `created_at`; 

-- 15.07.19

ALTER TABLE `action_files` ADD `added_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `file_name`; 

UPDATE `action_files` SET `added_on` = '0000-00-00 00:00:00'; 

ALTER TABLE `action_files` ADD `added_by_user` INT(10) NOT NULL DEFAULT '0' AFTER `file_name`; 

/****16/07/2019****/
ALTER TABLE `payment_history` ADD `check_number` VARCHAR(200) NOT NULL AFTER `pay_amount`, ADD `authorization_id` VARCHAR(200) NOT NULL AFTER `check_number`; 

-- 17.07.2019 -- 
ALTER TABLE `actions` CHANGE `status` `status` INT(11) NOT NULL COMMENT '0 new, 1 started, 2 completed, 6 resolved, 7 cancelled';

-- 18.07.2019 -- 



-- 19.07.2019 -- 
INSERT INTO `states` (`id`, `state_code`, `state_name`) VALUES (NULL, 'BVI', 'British Virgin Islands');
ALTER TABLE `company` ADD `state_others` VARCHAR(255) NOT NULL AFTER `file_name`;
INSERT INTO `states` (`id`, `state_code`, `state_name`) VALUES (NULL, 'OTHER', 'other');

-- 24.07.2019 -- 

UPDATE `states` SET `state_code` = 'OTH' WHERE `states`.`id` = 53; 

UPDATE `states` SET `state_name` = 'Other' WHERE `states`.`id` = 53; 


/* 29.07.2019 */
INSERT INTO `payment_type` (`id`, `name`) VALUES (NULL, 'WRITE OFF'); 

/* 30.07.2019 */
ALTER TABLE `invoice_info` CHANGE `payment_status` `payment_status` ENUM('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '1 for Unpaid, 2 for Partial, 3 for Paid, 4 for Completed'; 
ALTER TABLE `invoice_info` ADD `total_amount` VARCHAR(50) NOT NULL DEFAULT '0' AFTER `is_refund`; 

/* import triggers */
/* run the patch update_payment_status() */

/* 02.08.2019 */

ALTER TABLE `company` ADD UNIQUE(`id`);

ALTER TABLE `invoice_info` ADD `is_order` ENUM('n','y') NOT NULL DEFAULT 'n' COMMENT 'n for created invoice from order or created only invoice, y for created order from invoice' AFTER `order_id`;


/* 06.08.2019 */

-- import visitation.sql
-- import visitation_attachments.sql
-- import visitation_notes.sql

/* 07.08.2019 */

-- import buyer_information.sql
-- import seller_information.sql
ALTER TABLE `order_extra_data` ADD `property_address` LONGTEXT NOT NULL AFTER `professional_license_number`, ADD `property_city` VARCHAR(255) NOT NULL AFTER `property_address`, ADD `property_state` VARCHAR(255) NOT NULL AFTER `property_city`, ADD `property_zip` VARCHAR(255) NOT NULL AFTER `property_state`, ADD `closing_date` DATE NOT NULL AFTER `property_zip`;


/* 14.08.2019 */
/*     import related_service_files.sql
-- import visitation_office.sql
-- import visitation_participants.sql */


-- 20.08.2019
ALTER TABLE `lead_management` ADD `country` VARCHAR(255) NOT NULL AFTER `state`;
-- 21.08.2019
ALTER TABLE `services` ADD `fixed_cost` DECIMAL(10,2) NOT NULL AFTER `tutorials`;

/* import office_service_fees.sql */

ALTER TABLE `projects` ADD `is_deleted` INT(11) NOT NULL DEFAULT '0' COMMENT '1 for delete, 0 for not delete' AFTER `status`; 

/* 22.08.2019 */
ALTER TABLE `service_request` ADD `input_form_status` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `status`; 

/* 23.08.2019 */
ALTER TABLE `lead_management` ADD `assigned_status` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `import_status`;
/* 27.08.2019 */
ALTER TABLE `lead_management` ADD `referred_status` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '1:Partner to Staff, 0: Staff to Partner' AFTER `assigned_status`;

ALTER TABLE `lead_management` ADD `referred_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `referred_status`;

/* 28.08.2019 */
ALTER TABLE `lead_management` ADD `day_0_mail_date` DATE NOT NULL AFTER `referred_date`;

ALTER TABLE `lead_management` ADD `day_3_mail_date` DATE NOT NULL AFTER `day_0_mail_date`;

ALTER TABLE `lead_management` ADD `day_6_mail_date` DATE NOT NULL AFTER `day_3_mail_date`;

ALTER TABLE `lead_management` CHANGE `referred_status` `referred_status` ENUM('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0:Partner to Staff, 1: Staff to Partner';

/*30.08.19*/
/*import project_task_note.sql*/

/*03.09.19*/
ALTER TABLE `referred_lead` ADD `referred_to` INT(10) NOT NULL COMMENT 'id from staff table(referral partner id from staff or normal staff id from staff)' AFTER `lead_id`; 

ALTER TABLE `referred_lead` CHANGE `ref_partner_id` `referred_by` INT(10) NOT NULL COMMENT 'id from staff table(referral partner id from staff or normal staff id from staff)'; 
/* 04.09.19 */

ALTER TABLE `sos_notification_staff` ADD `notification_read` INT(11) NOT NULL DEFAULT '0' COMMENT '0 for unread, 1 for read' AFTER `read_status`; 
ALTER TABLE `lead_management` ADD `event_id` INT(100) NOT NULL AFTER `email`;

/* 11.09.19 */
ALTER TABLE `invoice_info` CHANGE `payment_status` `payment_status` ENUM('1','2','3','4') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1' COMMENT '1 for Unpaid, 2 for Partial, 3 for Paid, 4 for Late';


/* 13.09.19 */
ALTER TABLE `office` ADD `merchant_token` VARCHAR(255) NOT NULL AFTER `office_id`;

/* 13.09.19 */
ALTER TABLE `invoice_info` ADD `client_id` INT(11) NOT NULL COMMENT 'company_id for business client, individual_id for individual client' AFTER `type`; 

INSERT INTO `payment_type` (`id`, `name`) VALUES (NULL, 'Pay NOW');

/* 20.09.19 */
/*import file_read_status_staff.sql*/
/* 23.09.2019 */

ALTER TABLE `lead_management` CHANGE `referred_status` `referred_status` ENUM('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0:Partner to Staff, 1: Staff to Partner, 2:Others';

/* 27.09.2019 */
ALTER TABLE `actions` ADD `is_all` INT(11) NOT NULL DEFAULT '1' COMMENT '1 for all staff, 0 for individual staff' AFTER `my_task`; 


/* 2.10.19 */
ALTER TABLE `project_recurrence_main` ADD `due_date` DATE NULL DEFAULT NULL AFTER `created_at`; 
ALTER TABLE `project_recurrence_main` ADD `generation_date` DATE NULL DEFAULT NULL AFTER `due_date`; 

/* run the patch project_due_date_generation_date_fix() */

/* 3.10.19 */

ALTER TABLE `project_recurrence_main` ADD `next_due_date` DATE NOT NULL AFTER `due_date`; 

ALTER TABLE `project_recurrence_main` ADD `generated_by_cron` INT(10) NOT NULL DEFAULT '0' AFTER `generation_date`; 

/* live end */
/* 15.10.2019 */
ALTER TABLE `lead_management` CHANGE `type` `type` INT(10) NOT NULL COMMENT '1 for Client Lead or Lead, 2 for Partner,  3 for Partner Lead';

/* 16.10.2019 */
ALTER TABLE `lead_mail_chain` ADD `lead_type` INT(100) NOT NULL COMMENT '1 for client, 2 for partner' AFTER `id`;
-- import lead_type.sql
INSERT INTO `lead_type` (`id`, `type`) VALUES (NULL, 'Client'), (NULL, 'Partner');

/*17.10.2019*/
/* inport task_files.sql */
ALTER TABLE `project_task` ADD `input_form_status` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `status`; 


/*22.10.2019*/

ALTER TABLE `notes_log` ADD `read_status` INT(11) NOT NULL DEFAULT '0' COMMENT '0 for not read, 1 for read' AFTER `date_time`; 

ALTER TABLE `project_template_main` ADD `template_cat_id` INT(11) NOT NULL AFTER `id`; 

/*import template_category.sql*/

ALTER TABLE `project_main` ADD `template_cat_id` INT(11) NOT NULL AFTER `id`; 

/*25.10.2019*/


ALTER TABLE `project_main` ADD `template_cat_id` INT(11) NOT NULL AFTER `id`; 

/*30.10.2019*/
/* run patch remove_old_mail_campaign */


/* 05.11.2019 */
ALTER TABLE `lead_management` ADD `website` VARCHAR(255) NOT NULL AFTER `company_name`;

/*06.11.2019*/

ALTER TABLE `project_template_task` ADD `is_input_form` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `status`; 

ALTER TABLE `project_task` ADD `is_input_form` ENUM('n','y') NOT NULL DEFAULT 'n' AFTER `status`; 

/*08.11.2019*/

ALTER TABLE `project_task` ADD `input_form_type` INT(2) NOT NULL DEFAULT '0' AFTER `is_input_form`; 

ALTER TABLE `project_template_task` ADD `input_form_type` INT(2) NOT NULL DEFAULT '0' AFTER `is_input_form`; 

CREATE TABLE project_task_sales_tax_process LIKE sales_tax_process;

ALTER TABLE `project_task_sales_tax_process` ADD `task_id` INT(11) NOT NULL AFTER `id`;

/* 12.11.19 */

ALTER TABLE `project_template_task` CHANGE `tracking_description` `tracking_description` INT(4) NOT NULL COMMENT '0 for new, 1 for start, 2 for resolve,3 for ready';  

ALTER TABLE `project_task` CHANGE `tracking_description` `tracking_description` INT(4) NOT NULL COMMENT '0 for new, 1 for started, 2 for resolved, 3 for ready'; 

ALTER TABLE `order_extra_data` ADD `translation_to` VARCHAR(255) NOT NULL AFTER `document_date`, ADD `amount_of_pages` INT(100) NOT NULL AFTER `translation_to`, ADD `attach_files` VARCHAR(255) NOT NULL AFTER `amount_of_pages`;


/*15.11.19*/

ALTER TABLE `financial_accounts` ADD `reference` VARCHAR(50) NOT NULL DEFAULT 'order' AFTER `grand_total`; 

ALTER TABLE `bookkeeping` ADD `reference` VARCHAR(50) NOT NULL DEFAULT 'order' AFTER `sub_category`; 

/* 18.11.19 */
/* import royalty_report.sql */
/* run patch import_royalty_reports_data */
/*19.11.19*/

/*import project_task_bookkeeper_department.sql*/

ALTER TABLE `project_task_bookkeeper_department` ADD `adjustment` ENUM('n','y') NOT NULL COMMENT 'n for no, y for yes' AFTER `reconciled`; 

/*20.11.19*/

ALTER TABLE `project_template_task` ADD `bookkeeping_input_type` INT(4) NOT NULL DEFAULT '0' COMMENT '0 for default input, 1 for bank statement, 2 for bookkeeping bookkeeper, 3 for client manage' AFTER `input_form_type`; 

ALTER TABLE `project_task` ADD `bookkeeping_input_type` INT(4) NOT NULL DEFAULT '0' COMMENT '0 for default input, 1 for bank statement, 2 for bookkeeping bookkeeper, 3 for client manage' AFTER `input_form_type` 

/*21.11.19*/

ALTER TABLE `project_task_bookkeeper_department` ADD `total_time` VARCHAR(100) NOT NULL AFTER `adjustment`; 

/* 24.11.2019 */
/* import weekly_sales_report.sql */


/*28.11.2019*/
/* import invoice_recurence.sql*/
ALTER TABLE `invoice_recurence` ADD `actual_due_day` INT(4) NOT NULL AFTER `due_month`, ADD `actual_due_month` INT(4) NOT NULL AFTER `actual_due_day`, ADD `actual_due_year` INT(4) NOT NULL AFTER `actual_due_month`; 

ALTER TABLE `invoice_recurence` CHANGE `until_date` `until_date` DATE NULL DEFAULT NULL; 
ALTER TABLE `invoice_recurence` CHANGE `duration_type` `duration_type` VARCHAR(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
ALTER TABLE `invoice_recurence` CHANGE `status` `status` INT(2) NOT NULL DEFAULT '0';
ALTER TABLE `invoice_recurence` CHANGE `due_type` `due_type` INT(4) NULL DEFAULT NULL; 

ALTER TABLE `invoice_info` ADD `is_recurrence` ENUM('n','y') NOT NULL AFTER `status`; 

/*02.12.2019*/

ALTER TABLE `invoice_recurence` CHANGE `duration_time` `duration_time` INT(4) NULL DEFAULT NULL; 
 /*04.12.2019*/

/*import report_dashboard_service.sql*/



/*05.12.2019*/

ALTER TABLE `invoice_recurence` ADD `total_generation_time` INT(4) NOT NULL DEFAULT '0' AFTER `until_date`; 

ALTER TABLE `invoice_recurence` ADD `next_occurance_date` DATE NULL DEFAULT NULL AFTER `total_generation_time`; 

/*11.12.2019*/
ALTER TABLE `project_main` CHANGE `status` `status` INT(11) NOT NULL COMMENT '0-not started,1-started,2-completed,4-canceled'; 

ALTER TABLE `project_task` CHANGE `tracking_description` `tracking_description` INT(4) NOT NULL COMMENT '0 for new, 1 for started, 2 for resolved, 3 for ready, 4 for canceled'; 

/*12.12.2019*/
ALTER TABLE `project_template_task` ADD `task_title` VARCHAR(255) NOT NULL AFTER `task_order`; 
ALTER TABLE `project_task` ADD `task_title` VARCHAR(255) NOT NULL AFTER `task_order`; 
ALTER TABLE `royalty_report` ADD `office_id_name` VARCHAR(255) NOT NULL AFTER `office_id`;

/*13.12.2019*/
ALTER TABLE `services` ADD `client_type_assign` ENUM('0','1','2') NOT NULL DEFAULT '2' COMMENT '0=Business client,1=Individual client,2=both business and individual clients' AFTER `status`;
ALTER TABLE `services` ADD `is_active` ENUM('n','y') NOT NULL DEFAULT 'y' COMMENT 'y for active,n for inactive' AFTER `note`;

/*16.12.2019*/
ALTER TABLE `services` ADD `responsible_assign` INT(100) NULL DEFAULT NULL COMMENT '1 for Franchisee,2 for Corporate' AFTER `status`;
ALTER TABLE `services` CHANGE `dept` `dept` INT(10) NULL DEFAULT NULL;
ALTER TABLE `services` CHANGE `dept` `dept` VARCHAR(10) NULL DEFAULT NULL;



/*19.12.2019*/
/*import template_periodic_pattern */
/*import project_periodic_pattern */

ALTER TABLE `project_periodic_pattern` ADD `project_id` INT(4) NOT NULL AFTER `template_id`;

/*20.12.2019*/
ALTER TABLE `service_request` ADD `quantity` INT(4) NOT NULL DEFAULT '1' AFTER `services_id`;

ALTER TABLE `projects` CHANGE `created_at` `created_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL; 
ALTER TABLE `projects` CHANGE `created_at` `created_at` DATETIME NOT NULL; 

/* 26.12.2019 */
ALTER TABLE `payroll_employee_info` ADD `ssn_name` VARCHAR(30) NOT NULL AFTER `i9_file`, ADD `salary_rate` VARCHAR(30) NOT NULL AFTER `ssn_name`; 

/*03.01.2020*/
ALTER TABLE `project_periodic_pattern` ADD `is_created` ENUM('n','y') NOT NULL AFTER `actual_due_year`; 
/*import report_client */

ALTER TABLE `order` ADD `client_id` INT(100) NOT NULL COMMENT 'individual_id for individual client' AFTER `reference_id`;

/*07.01.2020*/
ALTER TABLE `invoice_recurence` ADD `due_date` VARCHAR(20) NOT NULL AFTER `status`; 

/* 08.01.2020 */
-- import report_dashboard_action
ALTER TABLE `report_dashboard_action` CHANGE `due_date` `due_date` DATE NULL DEFAULT NULL;

ALTER TABLE `financial_accounts` ADD `client_id` INT(5) NULL DEFAULT NULL AFTER `order_id`; 

ALTER TABLE `payroll_account_numbers` ADD `client_id` INT(5) NULL DEFAULT NULL AFTER `order_id`; 

/* 10.01.2020 */
-- import report_dashboard_project
ALTER TABLE `report_dashboard_project` ADD `sos` LONGTEXT NULL DEFAULT NULL AFTER `project_creation_date`;
ALTER TABLE `report_dashboard_project` ADD `project_due_date` DATE NOT NULL AFTER `project_creation_date`;

/* 15.01.2020 */
UPDATE `services` SET `retail_price` = '450.00', `responsible_assign` = '' WHERE `services`.`id` = 48;

INSERT INTO `renewal_dates` (`id`, `state`, `type`, `date`) VALUES (NULL, '3', '6', '2020/01/01');

INSERT INTO `renewal_dates` (`id`, `state`, `type`, `date`) VALUES (NULL, '51', '6', '2020/10/06');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'Arizona Annual Report', 'inc_a_a_r', 'NULL', '0.00', '150.00', '6', '1', '2', '2', '', 'y');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'Wyoming Annual Report', 'inc_w_a_r', 'NULL', '0.00', '250.00', '6', '1', '2', '0', '', 'y');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'Michigan Annual Report Corporation', 'inc_m_a_r_c', 'NULL', '0.00', '250.00', '6', '1', '2', '0', '', 'y');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'Texas Annual Report', 'inc_t_a_r', 'NULL', '0.00', '250.00', '6', '1', '2', '2', '', 'y');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'New Jersey Annual Report', 'inc_n_j_a_r', 'NULL', '0.00', '250.00', '6', '1', '2', '2', '', 'y');

INSERT INTO `services` (`id`, `category_id`, `description`, `ideas`, `tutorials`, `fixed_cost`, `retail_price`, `dept`, `status`, `responsible_assign`, `client_type_assign`, `note`, `is_active`) VALUES (NULL, '1', 'New York Annual Report', 'inc_n_y_a_r', 'NULL', '0.00', '250.00', '6', '1', '2', '0', '', 'y');

ALTER TABLE `report_dashboard_service` ADD `order_date` DATE NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `report_dashboard_service` CHANGE `department` `department` VARCHAR(10) NOT NULL;


/* 21.01.2020 */
ALTER TABLE `report_dashboard_action` ADD `creation_date` DATE NOT NULL AFTER `sos`;

/* 22.01.2020 */

ALTER TABLE `projects` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL;

-- import payer_recipient_information
ALTER TABLE `order_extra_data` ADD `compensation` VARCHAR(100) NOT NULL AFTER `closing_date`; 

/*  24.01.2020 */
-- import report_dashboard_billing
-- import payer_information 
-- import recipient_information 
DROP TABLE `payer_recipient_information`;

/*  27.01.2020 */
ALTER TABLE `order_extra_data` DROP `compensation`;
ALTER TABLE `project_template_recurrence_main` ADD `target_start_date` VARCHAR(30) NULL DEFAULT NULL AFTER `created_at`, ADD `target_end_date` VARCHAR(30) NULL DEFAULT NULL AFTER `target_start_date`;

/*28.01.2020*/

ALTER TABLE `project_template_recurrence_main` ADD `target_start_months` INT(2) NOT NULL AFTER `target_start_days`; 
ALTER TABLE `project_template_recurrence_main` ADD `target_end_months` INT(2) NULL DEFAULT NULL AFTER `target_end_days`; 

ALTER TABLE `project_recurrence_main` ADD `target_start_months` INT(2) NULL DEFAULT NULL AFTER `target_start_days`; 
ALTER TABLE `project_recurrence_main` ADD `target_end_months` INT(2) NULL DEFAULT NULL AFTER `target_end_days`; 

ALTER TABLE `project_recurrence_main` ADD `target_start_date` DATE NULL DEFAULT NULL AFTER `generated_by_cron`, ADD `target_end_date` DATE NULL DEFAULT NULL AFTER `target_start_date`; 
ALTER TABLE `project_recurrence_main` ADD `start_date` DATE NULL DEFAULT NULL COMMENT 'when project started' AFTER `generation_date`; 

/*live end*/

/*31.01.2020*/

ALTER TABLE `project_recurrence_main` DROP `start_date`
ALTER TABLE `project_recurrence_main` ADD `start_month` VARCHAR(50) NULL DEFAULT NULL AFTER `generation_date`; 