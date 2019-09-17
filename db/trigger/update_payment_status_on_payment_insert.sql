/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Sumanta
 * Created: Jul 29, 2019
 */

CREATE TRIGGER `update_payment_status_on_payment_insert` AFTER INSERT ON `payment_history`
 FOR EACH ROW UPDATE `invoice_info` SET `invoice_info`.`payment_status` = (CASE WHEN (SELECT SUM(`payment_history`.`pay_amount`) FROM `payment_history` WHERE `payment_history`.`type` = 'payment' AND `payment_history`.`invoice_id` = NEW.invoice_id AND `payment_history`.`is_cancel` = 0) IS NULL AND (SELECT SUM(`order`.`total_of_order` * `order`.`quantity`) FROM `order` WHERE `order`.`invoice_id` = NEW.invoice_id AND `order`.`reference` = 'invoice') != 0 THEN '1' WHEN (SELECT SUM(`order`.`total_of_order` * `order`.`quantity`) FROM `order` WHERE `order`.`invoice_id` = NEW.invoice_id AND `order`.`reference` = 'invoice') > (SELECT SUM(`payment_history`.`pay_amount`) FROM `payment_history` WHERE `payment_history`.`type` = 'payment' AND `payment_history`.`invoice_id` = NEW.invoice_id AND `payment_history`.`is_cancel` = 0) THEN '2' ELSE '3' END) WHERE `invoice_info`.`id` = NEW.invoice_id

