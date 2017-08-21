<?php

/**
 * @package       ICEPAY Payment Module for OpenCart
 * @author        Ricardo Jacobs <ricardo.jacobs@icepay.com>
 * @copyright     (c) 2017 ICEPAY. All rights reserved.
 * @license       BSD 2 License, see https://github.com/icepay/OpenCart/blob/master/LICENSE
 */

// Heading
$_['heading_title'] = 'ICEPAY';

// Tabs
$_['tab_general'] = 'Merchant Settings';
$_['tab_statuscodes'] = 'Status Codes';
$_['tab_paymentmethods'] = 'Payment Methods';
$_['tab_about'] = 'About';
$_['tab_sendcloud'] = 'SendCloud';

// Text
$_['text_extension'] = 'Extensions';
$_['text_success'] = 'Success: You have modified the ICEPAY module settings!';
$_['text_icepay_basic'] = '<img src="view/image/payment/icepay_basic.png" alt="ICEPAY" title="ICEPAY" />';

//About Tab
$_['text_about_logo'] = '<a onclick="window.open(\'http://www.icepay.com/webshop-modules/online-payments-for-opencart\');"><img src="view/image/payment/icepay-logo.png" alt="ICEPAY" title="ICEPAY" border="0"/></a>';
$_['text_about_link'] = '<a onclick="window.open(\'http://www.icepay.com/\');">www.icepay.com</a>';
$_['text_about_support'] = 'Official ICEPAY payment module';
$_['text_about_support_link'] = '<a onclick="window.open(\'https://github.com/ICEPAY/OpenCart-2.x/wiki\');">Manual</a>';

// Entry
$_['entry_url'] = 'URL for Succes/Error/Postback:';
$_['entry_merchantid'] = 'Merchant ID:';
$_['entry_secretcode'] = 'SecretCode:';
$_['entry_geo_zone'] = 'Geo Zone:';
$_['entry_status'] = 'Status:';
$_['entry_sort_order'] = 'Sort Order:';
$_['entry_debug'] = 'Debug Logging';

// Status
$_['entry_new_status'] = 'New Order Status:<br/><span class="help">Recommended: Pending</span>';
$_['entry_open_status'] = 'Pending Payment Status:<br/><span class="help">Recommended: Pending</span>';
$_['entry_ok_status'] = 'Payment Accepted Status:<br/><span class="help">Recommended: Processing</span>';
$_['entry_err_status'] = 'Payment Error Status:<br/><span class="help">Recommended: Failed</span>';
$_['entry_cback_status'] = 'Payment Chargeback Status:<br/><span class="help">Recommended: Chargeback</span>';
$_['entry_refund_status'] = 'Payment Refund Status:<br/><span class="help">Recommended: Refunded</span>';

// Error
$_['error_permission'] = 'You do not have permission to access this page.';
$_['error_merchantid'] = 'ICEPAY Merchant ID is required!';
$_['error_merchantid_incorrect'] = 'ICEPAY Merchant ID must contain 5 digits.';
$_['error_secretcode'] = 'ICEPAY SecretCode is required!';
$_['error_secretcode_incorrect'] = 'ICEPAY Merchant ID must contain exactly 40 characters.';
$_['error_no_api_settings'] = 'Error: No merchant ID and/or secret code found.';

// Help
$_['help_debug'] = 'Enabling debug will write sensitive data to a log file. You should always disable unless instructed otherwise';

//SendCloud Settings
$_['entry_sendcloud_api_key'] = 'API Public Key:';
$_['entry_sendcloud_api_secret'] = 'API Secret Key:';
$_['entry_sendcloud_default_status'] = 'Set the order state after transport to';
$_['entry_sendcloud_default_status_placeholder']  = '---';
$_['entry_sendcloud_address2_as_housenumber']  = 'Use address 2 as housenumber';

$_['error_sendcloud_no_api_settings'] = 'Error: No api public and/or secret key found.';
$_['error_sendcloud_no_orders'] = 'Error: No orders selected.';
$_['error_sendcloud_order_no_shipping'] = 'Error: No shipping details for order(s): ';
$_['error_sendcloud_process_orders'] = "Error: Can't process order id(s): ";
$_['error_sendcloud_api_error_reason'] = "Due to the following error: ";

$_['text_sendcloud_success'] = 'Orders successfully sent to SendCloud. <a href="https://panel.sendcloud.nl" target="_blank">Go to SendCloud</a>';
$_['text_sendcloud_log_message'] = 'Transported to SendCloud.';

