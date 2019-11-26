<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin Panel
$route['admin_panel/manage_staff'] = 'administration/manage_staff';
$route['admin_panel/departments'] = 'administration/departments';
$route['admin_panel/office'] = 'administration/office';
$route['admin_panel/paypal_account_setup'] = 'administration/paypal_account_setup';
$route['admin_panel/manage_log'] = 'administration/manage_log';

// Services
$route['services/service_setup'] = 'administration/service_setup';
$route['services/business_client'] = 'administration/Business_client';

// Projects
$route['projects/template'] = 'administration/template';

// Clients
$route['clients/business_dashboard'] = 'action/home/business_dashboard';
$route['clients/add_business'] = 'action/home/add_business';
$route['clients/individual_dashboard'] = 'action/home/individual_dashboard';
$route['clients/add_individual'] = 'action/home/add_individual';
$route['clients/import_clients'] = 'action/home/import_clients';
$route['clients/company_type'] = 'administration/company_type';
$route['clients/renewal_dates'] = 'administration/Renewal_dates';
$route['clients/referred_source'] = 'administration/referred_source';
$route['clients/lead_mail'] = 'lead_management/lead_mail';

// Corporate
$route['corporate/operational_manuals'] = 'operational_manuals/index';
$route['corporate/operational_manuals/forms'] = 'operational_manuals/forms';

$route['corporate/training_materials/index/2'] = 'training_materials/index/2';
$route['corporate/training_materials/index/3'] = 'training_materials/index/3';
$route['corporate/training_materials/index/4'] = 'training_materials/index/4';
$route['corporate/training_materials/add_training_material'] = 'training_materials/add_training_material';
$route['corporate/training_materials/training_materials_category'] = 'training_materials/training_materials_category';
$route['corporate/training_materials/training_materials_subcategory'] = 'training_materials/training_materials_subcategory';
$route['corporate/training_materials/training_materials_suggestions'] = 'training_materials/training_materials_suggestions';


$route['corporate/marketing_materials/index'] = 'marketing_materials/index';
$route['corporate/marketing_materials/marketing_materials_purchase_list'] = 'marketing_materials/marketing_materials_purchase_list';
$route['corporate/marketing_materials/marketing_materials_category'] = 'marketing_materials/marketing_materials_category';
$route['corporate/marketing_materials/marketing_materials_subcategory'] = 'marketing_materials/marketing_materials_subcategory';
$route['corporate/marketing_materials/marketing_materials_suggestions'] = 'marketing_materials/marketing_materials_suggestions';

$route['corporate/visit_reports'] = 'visitation/visitation_home/index';

// Franchisee
$route['franchisee/office_info'] = 'administration/office';
