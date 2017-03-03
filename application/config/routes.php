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

number_lookup

*/

$route['default_controller'] = 'User_controller';

//$route['site'] = 'Public_controller';

$route['404_override'] = '';


$route['login'] = 'Login';
/* Super Admin Url routing start. */
//$route['super_admin'] = 'Login/super_admin';
$route['logout'] = 'Login/user_logout';
//$route['admin/logout'] = 'Login/admin_logout';
$route['dashboard'] = 'User_controller';
$route['user_login'] = 'Login/do_login_user';
$route['user_login_first/(:any)/(:any)'] = 'Login/do_login_user_after_signup/$1/$2';
//$route['admin_login'] = 'Login/do_login_sa';
/*
$route['admin'] = 'Admin_controller';
$route['create_user'] = 'Admin_controller/create_user';
$route['create_pack'] = 'Admin_controller/create_pack';
$route['create_user_insert'] = 'Admin_controller/create_user_insert';
$route['create_pack_insert'] = 'Admin_controller/create_pack_insert';
$route['view_pack'] = 'Admin_controller/view_pack';
$route['update_pack'] = 'Admin_controller/update_pack';
$route['delete_pack/(:any)'] = 'Admin_controller/delete_pack/$1';
$route['view_user'] = 'Admin_controller/view_user';
$route['update_user'] = 'Admin_controller/update_user';
$route['delete_user/(:any)'] = 'Admin_controller/delete_user/$1';
$route['block_user'] = 'Admin_controller/block_user';
$route['filter'] = 'Admin_controller/filter_template';
$route['create_filter'] = 'Admin_controller/create_filter';
$route['update_filter'] = 'Admin_controller/update_filter';
$route['delete_filter/(:any)'] = 'Admin_controller/delete_filter/$1';
$route['shortcode'] = 'Admin_controller/shortcode';
$route['create_shortcode'] = 'Admin_controller/create_shortcode';
$route['update_shortcode'] = 'Admin_controller/update_shortcode';
$route['delete_shortcode/(:any)'] = 'Admin_controller/delete_shortcode/$1';
$route['campaign_type'] = 'Admin_controller/campaign_type';
$route['create_campaign_type'] = 'Admin_controller/create_campaign_type';
$route['update_campaign_type'] = 'Admin_controller/update_campaign_type';
$route['delete_campaign_type/(:any)'] = 'Admin_controller/delete_campaign_type/$1';
$route['keyword'] = 'Admin_controller/keyword';
$route['create_keyword'] = 'Admin_controller/create_keyword';
$route['update_keyword'] = 'Admin_controller/update_keyword';
$route['delete_keyword/(:any)'] = 'Admin_controller/delete_keyword/$1';
$route['campaign_list'] = 'Admin_controller/campaign_list';
$route['campaign_list/(:any)'] = 'Admin_controller/campaign_list/$1';

//////////////Transaction////////////////////////
$route['list_transaction'] = 'Admin_controller/list_transaction';

$route['report/credit_sell'] = 'Admin_controller/credit_sell';
$route['report/credit_sell/(:any)'] = 'Admin_controller/credit_sell/$1';
$route['report/credit_sell_by_date/(:any)/(:any)'] = 'Admin_controller/credit_sell_by_date/$1/$2';
$route['report/credit_sell_by_date/(:any)/(:any)/(:any)'] = 'Admin_controller/credit_sell_by_date/$1/$2/$3';


$route['report/earning'] = 'Admin_controller/report_earning';
$route['report/earning/(:any)'] = 'Admin_controller/report_earning/$1';
$route['report/earning_by_date/(:any)/(:any)'] = 'Admin_controller/report_earning_by_date/$1/$2';
$route['report/earning_by_date/(:any)/(:any)/(:any)'] = 'Admin_controller/report_earning_by_date/$1/$2/$3';

////////////////////////////////////////////////

//////////////User ACcess////////////////////////
$route['user_access'] = 'Admin_controller/user_access';
$route['user_access_login/(:any)'] = 'Admin_controller/user_access_login/$1';
////////////////////////////////////////////////

*/

/* User Url routing start. */
$route['msg_template'] = 'User_controller_msg/messageTemplate';
$route['msg_template_edit'] = 'User_controller_msg/messageTemplateEdit';
$route['msg_template_delete/(:any)'] = 'User_controller_msg/messageTemplateDelete/$1';
$route['msg_template_upload'] = 'User_controller_msg/messageTemplateUpload';
$route['msg_analyser'] = 'User_controller_msg/spain_analyser';
$route['msg_campaign'] = 'User_controller_msg/message_campaign';
$route['msg_bulk_delete'] = 'User_controller_msg/messageTemplateBulkDelete';
$route['paypal_buy/(:any)'] = 'User_controller_msg/paypal_buy/$1';

$route['contact_upload'] = 'User_controller/contact_upload_section';
$route['email_verification'] = 'User_controller/email_verification_section';
$route['phone_upload'] = 'User_controller/phone_upload_section';
$route['data_append'] = 'User_controller/data_append_section';

/*$route['contact_upload'] = 'User_controller/contact_upload';*/
$route['upload_file'] = 'User_controller/upload_file';
$route['instant_lookup'] = 'User_controller/instant_lookup';
$route['profile'] = 'User_controller/profile';
$route['profile_update'] = 'User_controller/profile_update';
$route['profile_picture_update'] = 'User_controller/profile_picture_update';
$route['packages'] = 'User_controller/packages';
$route['groups'] = 'User_controller/groups';
$route['groups/(:any)'] = 'User_controller/groups/$1';
$route['groups_ajax'] = 'User_controller/groups_ajax';
$route['groups_ajax/(:any)'] = 'User_controller/groups_ajax/$1';
$route['group_details'] = 'User_controller/group_details';
$route['group_details/(:any)'] = 'User_controller/group_details/$1';
$route['group_details_ajax/(:any)'] = 'User_controller/group_details_ajax/$1';
$route['group_details/(:any)/(:any)'] = 'User_controller/group_details/$1/$2';
$route['group_details_ajax/(:any)/(:any)'] = 'User_controller/group_details_ajax/$1/$2';
$route['group_delete/(:any)'] = 'User_controller/group_delete/$1';

$route['report/file_status'] = 'User_controller/file_status';    //edited
$route['report/file_status/(:any)'] = 'User_controller/file_status/$1';    //edited
$route['clean_file_download/(:any)'] = 'User_controller/clean_file_download/$1';    //edited
$route['report_file_download/(:any)'] = 'User_controller/report_file_download/$1';    //edited
$route['smtp_clean_file_download/(:any)'] = 'User_controller/smtp_clean_file_download/$1';    //edited


/*************************************************/
/* BEGIN : Route for Number file report download */
/*************************************************/
$route['clean_numberfile_report/(:any)'] = 'User_controller/smtp_clean_numberfile_report/$1';    //edited
/**************************************************/
/* // END : Route for Number file report download */
/**************************************************/


$route['report/file_upload_status'] = 'User_controller/file_upload_status';    //edited
$route['report/file_upload_status_ajax'] = 'User_controller/file_upload_status_ajax';	//edited
$route['report/file_upload_status/(:any)'] = 'User_controller/file_upload_status/$1';	//edited
$route['report/file_upload_status_ajax/(:any)'] = 'User_controller/file_upload_status_ajax/$1';	//edited
$route['report/file_upload_status_chart/(:any)'] = 'User_controller/file_upload_status_chart/$1';	//edited

$route['file_download/(:any)'] = 'User_controller/file_download/$1';	//new
$route['file_download_as_criteria'] = 'User_controller/file_download_as_criteria';	//new
$route['sendInstantCheckupRequest'] = 'User_controller/sendInstantCheckupRequest';	//new

$route['deploy_campaign'] = 'User_controller/deploy_campaign';
$route['deploy_campaign_process'] = 'User_controller/deploy_campaign_process';
$route['deploy_campaign_group_ajax'] = 'User_controller/deploy_campaign_group_ajax';
$route['deploy_campaign_group_ajax/(:any)'] = 'User_controller/deploy_campaign_group_ajax/$1';
$route['deploy_campaign_template_ajax'] = 'User_controller/deploy_campaign_template_ajax';
$route['deploy_campaign_template_ajax/(:any)'] = 'User_controller/deploy_campaign_template_ajax/$1';
$route['groups_search_ajax/(:any)'] = 'User_controller/groups_search_ajax/$1';
$route['groups_search_ajax/(:any)/(:any)'] = 'User_controller/groups_search_ajax/$1/$2';
$route['group_search_for_deploy_campaign'] = 'User_controller/group_search_for_deploy_campaign';
$route['group_search_for_deploy_campaign/(:any)'] = 'User_controller/group_search_for_deploy_campaign/$1';
$route['group_search_for_deploy_campaign/(:any)/(:any)'] = 'User_controller/group_search_for_deploy_campaign/$1/$2';
$route['template_search_for_deploy_campaign'] = 'User_controller/template_search_for_deploy_campaign';
$route['template_search_for_deploy_campaign/(:any)'] = 'User_controller/template_search_for_deploy_campaign/$1';
$route['template_search_for_deploy_campaign/(:any)/(:any)'] = 'User_controller/template_search_for_deploy_campaign/$1/$2';
$route['report/campaign'] = 'User_controller/campaign_report';
$route['report/campaign/(:any)'] = 'User_controller/campaign_report/$1';
$route['report/campaign_details/(:any)'] = 'User_controller/campaign_report_details/$1';
$route['report/campaign_details/(:any)/(:any)'] = 'User_controller/campaign_report_details/$1/$2';

$route['report/buy_credit'] = 'User_controller/buy_credit';
$route['report/buy_credit/(:any)'] = 'User_controller/buy_credit/$1';
$route['report/buy_credit/(:any)/(:any)'] = 'User_controller/buy_credit/$1/$2';
$route['report/buy_credit/(:any)/(:any)/(:any)'] = 'User_controller/buy_credit/$1/$2/$3';

$route['report/credit/expense'] = 'User_controller/report_credit_expense';
$route['report/credit/expense/(:any)'] = 'User_controller/report_credit_expense/$1';
$route['report/credit/expense_by_date/(:any)/(:any)'] = 'User_controller/report_credit_expense_by_date/$1/$2';
$route['report/credit/expense_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_credit_expense_by_date/$1/$2/$3';


$route['report/credit/buy'] = 'User_controller/report_credit_buy';
$route['report/credit/buy/(:any)'] = 'User_controller/report_credit_buy/$1';
$route['report/credit/buy_by_date/(:any)/(:any)'] = 'User_controller/report_credit_buy_by_date/$1/$2';
$route['report/credit/buy_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_credit_buy_by_date/$1/$2/$3';


$route['report/package/buy'] = 'User_controller/report_package_buy';
$route['report/package/buy/(:any)'] = 'User_controller/report_package_buy/$1';
$route['report/package/buy_by_date/(:any)/(:any)'] = 'User_controller/report_package_buy_by_date/$1/$2';
$route['report/package/buy_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_package_buy_by_date/$1/$2/$3';

$route['report/daily_limit/expense'] = 'User_controller/report_daily_limit_expense';
$route['report/daily_limit/expense/(:any)'] = 'User_controller/report_daily_limit_expense/$1';
$route['report/daily_limit/expense_by_date/(:any)/(:any)'] = 'User_controller/report_daily_limit_expense_by_date/$1/$2';
$route['report/daily_limit/expense_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_daily_limit_expense_by_date/$1/$2/$3';


$route['report/instant_lookup'] = 'User_controller/report_instant_lookup';
$route['report/instant_lookup/(:any)'] = 'User_controller/report_instant_lookup/$1';
$route['report/instant_lookup_by_date/(:any)/(:any)'] = 'User_controller/report_instant_lookup_by_date/$1/$2';
$route['report/instant_lookup_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_instant_lookup_by_date/$1/$2/$3';

$route['report/invoice'] = 'User_controller/report_invoice';
$route['report/invoice/(:any)'] = 'User_controller/report_invoice/$1';
$route['report/invoice_by_date/(:any)/(:any)'] = 'User_controller/report_invoice_by_date/$1/$2';
$route['report/invoice_by_date/(:any)/(:any)/(:any)'] = 'User_controller/report_invoice_by_date/$1/$2/$3';

$route['report/failed_upload'] = 'User_controller/failed_upload';

$route['old_pass_check'] = 'User_controller/old_pass_check';
$route['old_pass_check/(:any)'] = 'User_controller/old_pass_check/$1';
$route['password_update/(:any)/(:any)/(:any)'] = 'User_controller/password_update/$1/$2/$3';
$route['dashboard/:any()'] = 'User_controller/index/$1';



$route['buy_credit'] = 'User_controller/buy_credit';
$route['global_balance'] = 'User_controller/global_balance';
$route['buy_package/(:any)'] = 'User_controller/package_stripe_form/$1';
$route['activate/(:any)'] = 'Activation_controller/activate_account/$1';



$route['api/lookup_file'] = 'User_controller/api_lookup_file';
$route['api/download_lookup_file'] = 'User_controller/api_download_lookup_file';
$route['api/email_lookup'] = 'User_controller/api_numbers_lookup';
$route['api/lookup_file_status'] = 'User_controller/api_lookup_file_status';

$route['file_delete/(:any)'] = 'User_controller/file_delete/$1';
$route['failed_file_delete'] = 'User_controller/failed_file_delete';

$route['buy_package_confirm'] = 'User_controller/buy_package_confirm';
$route['buy_credit_confirm/(:any)'] = 'User_controller/buy_credit_confirm/$1';


$route['download_invoice/(:any)'] = 'User_controller/download_invoice/$1';

$route['pricing_contact_us'] = 'User_controller/pricing_contact_us';

$route['check_file_status'] = 'User_controller/check_file_status';       //1,oct,2016

/*
$route['public/test'] = 'Landing_controller/index';
$route['public/checkup_request'] = 'Landing_controller/checkupRequest';
$route['public/contact'] = 'Public_controller/public_contact';
$route['public/subscribe'] = 'Public_controller/public_subscribe';
$route['public/registration'] = 'Public_controller/public_registration';
$route['public/set_cookie'] = 'Public_controller/public_set_cookie';
*/




$route['translate_uri_dashes'] = FALSE;
