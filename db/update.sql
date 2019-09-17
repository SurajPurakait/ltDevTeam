/**
 * Created: 16 Mar, 2018
 */

UPDATE `office` SET `type` = 1 WHERE `type` = "";
UPDATE `office` SET `type` = 1 WHERE `type` = "Corporate";
UPDATE `office` SET `type` = 2 WHERE `type` = "Franchise";

UPDATE `staff` SET `type`='1' WHERE `type` = 'Admin';
UPDATE `staff` SET `type`='2' WHERE `type` = 'Corporate';
UPDATE `staff` SET `type`='3' WHERE `type` = 'Franchise';

/**
 * Created: 29 May, 2018
 */
UPDATE `order` SET `target_start_date` = `start_date`, `target_complete_date` = `complete_date`;


/**
 * Created: 14 Aug, 2018
 */
UPDATE `invoice_info` SET `type`= 1 WHERE `type` = 'Business Client';
UPDATE `invoice_info` SET `type`= 2 WHERE `type` = 'Individual';
UPDATE `countries` SET `country_name` = 'Unknown' WHERE `countries`.`id` = 0; 

/**
 * Created: 10 Dec, 2018
 */
INSERT INTO `payment_type` (`id`, `name`) VALUES (NULL, 'Referral Account');
