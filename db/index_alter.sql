ALTER TABLE `service_request` DROP INDEX `fk_service_request_3_idx`;
ALTER TABLE `service_request` DROP INDEX `fk_service_request_2_idx`;
ALTER TABLE `service_request` DROP INDEX `fk_service_request_1_idx`;

ALTER TABLE `service_request` ADD INDEX(`order_id`); 
ALTER TABLE `service_request` ADD INDEX(`services_id`); 
ALTER TABLE `service_request` ADD INDEX(`responsible_staff`); 

ALTER TABLE `order` DROP INDEX `fk_order_1_idx`;
ALTER TABLE `order` DROP INDEX `reference`;

ALTER TABLE `order` ADD INDEX(`staff_requested_service`); 
ALTER TABLE `order` ADD INDEX(`reference_id`); 
ALTER TABLE `order` CHANGE `new_existing` `new_existing` TINYINT(2) NOT NULL, CHANGE `status` `status` TINYINT(4) NULL DEFAULT NULL, CHANGE `quantity` `quantity` TINYINT(4) NOT NULL; 

ALTER TABLE `invoice_info` ADD INDEX(`reference_id`); 
ALTER TABLE `invoice_info` ADD INDEX(`created_by`); 


ALTER TABLE `internal_data` ADD INDEX(`reference_id`); 
ALTER TABLE `internal_data` CHANGE `status` `status` TINYINT(4) NULL DEFAULT NULL; 

ALTER TABLE `payment_history` ADD INDEX(`invoice_id`); 
ALTER TABLE `payment_history` CHANGE `is_cancel` `is_cancel` TINYINT(2) NOT NULL; 
ALTER TABLE `payment_history` ADD INDEX(`order_id`); 
ALTER TABLE `payment_history` ADD INDEX(`service_id`); 
ALTER TABLE `payment_history` CHANGE `payment_type` `payment_type` TINYINT(4) NOT NULL; 
ALTER TABLE `payment_history` ADD INDEX(`payment_type`); 

ALTER TABLE `department_staff` ADD INDEX(`department_id`); 
ALTER TABLE `department_staff` ADD INDEX(`staff_id`); 

ALTER TABLE `notes_log` CHANGE `related_table_id` `related_table_id` TINYINT(4) NOT NULL COMMENT '1 for notes, 2 for action_notes, 3 for lead_notes, 4 for payroll_employee_notes. 5 for payroll_rt6_notes, 6 for marketing notes'; 
ALTER TABLE `notes_log` ADD INDEX(`note_id`); 
ALTER TABLE `notes_log` ADD INDEX(`user_id`); 
ALTER TABLE `notes_log` CHANGE `read_status` `read_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0 for not read, 1 for read';

ALTER TABLE `note_notification` ADD INDEX(`note_id`); 
ALTER TABLE `note_notification` ADD INDEX(`reference_id`); 
ALTER TABLE `note_notification` CHANGE `read_status` `read_status` TINYINT(4) NOT NULL COMMENT '0->not read 1->read'; 

ALTER TABLE `new_company` ADD INDEX(`company_id`); 

ALTER TABLE `services` CHANGE `dept` `dept` TINYINT(4) NOT NULL DEFAULT '1'; 
ALTER TABLE `services` ADD INDEX(`dept`); 

ALTER TABLE `invoice_info` ADD `reference` ENUM('company','individual') NOT NULL DEFAULT 'company' AFTER `reference_id`; 
UPDATE `invoice_info` SET `reference`= "company" WHERE `type` = 1;
UPDATE `invoice_info` SET `reference`= "individual" WHERE `type` = 2;
ALTER TABLE `invoice_info` CHANGE `type` `type` TINYINT(1) NOT NULL DEFAULT '1'; 
ALTER TABLE `invoice_info` CHANGE `new_existing` `new_existing` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0 for yes, 1 for no'; 

ALTER TABLE `invoice_info` ADD `internal_data_id` INT(11) NOT NULL AFTER `order_id`, ADD INDEX (`internal_data_id`); 
UPDATE `invoice_info` SET `internal_data_id` = (SELECT `id` FROM `internal_data` WHERE `internal_data`.`reference_id` = `invoice_info`.`client_id` AND `internal_data`.`reference` = `invoice_info`.`reference` LIMIT 1);

ALTER TABLE `invoice_info` ADD `office_id` INT(10) NOT NULL AFTER `internal_data_id`, ADD `partner_id` INT(6) NOT NULL AFTER `office_id`, ADD `manager_id` INT(6) NOT NULL AFTER `partner_id`, ADD INDEX (`office_id`), ADD INDEX (`partner_id`), ADD INDEX (`manager_id`); 
UPDATE `invoice_info` SET `office_id`= (SELECT `office` FROM `internal_data` WHERE `id` = `invoice_info`.`internal_data_id`),`partner_id`= (SELECT `partner` FROM `internal_data` WHERE `id` = `invoice_info`.`internal_data_id`),`manager_id`= (SELECT `manager` FROM `internal_data` WHERE `id` = `invoice_info`.`internal_data_id`);

/*
SELECT `id`, `office`, `partner`, `manager`
INTO @internal_data_id, @office_id, @partner_id, @manager_id
FROM `internal_data` WHERE `reference_id` = NEW.client_id AND `reference` = (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END) LIMIT 1;
UPDATE `invoice_info` SET `internal_data_id` = @internal_data_id, `reference`= (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END), `office_id`= @office_id,`partner_id`= @partner_id,`manager_id` = @manager_id WHERE `id` = NEW.id;
CREATE DEFINER=`root`@`localhost` TRIGGER `update_data_on_invoice_insert` AFTER INSERT ON `invoice_info` FOR EACH ROW UPDATE `invoice_info` SET `internal_data_id` = (SELECT `id` FROM `internal_data` WHERE (CASE WHEN NEW.type = 1 THEN `internal_data`.`reference_id` = NEW.client_id AND `internal_data`.`reference` = "company" ELSE `internal_data`.`reference_id` = NEW.client_id AND `internal_data`.`reference` = "individual" END));
*/

CREATE TRIGGER `update_data_on_invoice_insert` AFTER INSERT ON `invoice_info`
 FOR EACH ROW UPDATE `invoice_info` SET 

`internal_data_id` = (SELECT `id`
FROM `internal_data` WHERE `reference_id` = NEW.client_id AND `reference` = (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END) LIMIT 1), 

`reference`= (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END), 

`office_id`= (SELECT `office` FROM `internal_data` WHERE `reference_id` = NEW.client_id AND `reference` = (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END) LIMIT 1),

`partner_id`= (SELECT `partner` FROM `internal_data` WHERE `reference_id` = NEW.client_id AND `reference` = (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END) LIMIT 1),

`manager_id` = (SELECT `manager`
FROM `internal_data` WHERE `reference_id` = NEW.client_id AND `reference` = (CASE WHEN NEW.type = 1 THEN "company" ELSE "individual" END) LIMIT 1) WHERE `id` = NEW.id;