<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------
// Paypal IPN Class
// ------------------------------------------------------------------------

// If (and where) to log ipn to file
$config['paypal_lib_ipn_log_file'] = BASEPATH . 'logs/paypal_ipn.log';
$config['paypal_lib_ipn_log'] = TRUE;

// Where are the buttons located at 
$config['paypal_lib_button_path'] = 'buttons';

// What is the default currency?
$config['paypal_lib_currency_code'] = 'USD';

$config['Sandbox'] = FALSE;

$config['APIUsername'] = $config['Sandbox'] ? 'developer1_api1.client.com' : 'carnerjames_api1.gmail.com';
$config['APIPassword'] = $config['Sandbox'] ? 'C85VJSTMGDKDSLLN' : 'EBMSD56PYZE8CD3N';
$config['APISignature'] = $config['Sandbox'] ? 'AFcWxV21C7fd0v3bYYYRCpSSRl31A-gCfR3a9kPX66JEDDIdyH18bCtW' : 'ABxSD615fLZE6bP75i-ULKnyon1DAUjm6c37QKKBjXnxkX5sXYp-88ZR';

?>
