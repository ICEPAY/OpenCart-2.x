<?php

/**
 * @package       ICEPAY Payment Module for OpenCart
 * @author        Ricardo Jacobs <ricardo.jacobs@icepay.com>
 * @copyright     (c) 2016 ICEPAY. All rights reserved.
 * @license       BSD 2 License, see https://github.com/icepay/OpenCart/blob/master/LICENSE
 */

// Heading
$_['heading_title'] = 'ICEPAY';

// Tabs
$_['tab_general'] = 'Merchant instellingen';
$_['tab_statuscodes'] = 'Status Codes';
$_['tab_paymentmethods'] = 'Betaal Methodes';
$_['tab_about'] = 'Informatie';
$_['tab_sendcloud'] = 'SendCloud';

// Text
$_['text_payment'] = 'Betaling';
$_['text_success'] = 'Voltooid: De ICEPAY module instellingen zijn aangepast!';
$_['text_icepay_basic'] = '<img src="view/image/payment/icepay_basic.png" alt="ICEPAY" title="ICEPAY" />';

//About Tab
$_['text_about_logo'] = '<a onclick="window.open(\'http://www.icepay.com/webshop-modules/ideal-voor-opencart/\');"><img src="view/image/payment/icepay-logo.png" alt="ICEPAY" title="ICEPAY" border="0"/></a>';
$_['text_about_link'] = '<a onclick="window.open(\'http://www.icepay.com/\');">www.icepay.com</a>';
$_['text_about_support'] = 'Offici&euml;le ICEPAY module';
$_['text_about_support_link'] = '<a onclick="window.open(\'http://www.icepay.com/downloads/pdf/manuals/opencart/icepay-manual-opencart-2.pdf\');">Handleiding (Engels)</a>';

// Entry
$_['entry_url'] = 'URL voor Succes/Error/Postback:';
$_['entry_merchantid'] = 'Merchant ID:';
$_['entry_secretcode'] = 'SecretCode:';
$_['entry_geo_zone'] = 'Geo Zone:';
$_['entry_status'] = 'Status:';
$_['entry_sort_order'] = 'Sorteervolgorde:';

// Status
$_['entry_new_status'] = 'New Order Status:<br/><span class="help">Geadviseerd: Pending</span>';
$_['entry_open_status'] = 'In afwachting van betaling status:<br/><span class="help">Geadviseerd: Pending</span>';
$_['entry_ok_status'] = 'Betaling ontvangen status:<br/><span class="help">Geadviseerd: Processing</span>';
$_['entry_err_status'] = 'Fout bij betaling status:<br/><span class="help">Geadviseerd: Failed</span>';
$_['entry_cback_status'] = 'Chargeback status:<br/><span class="help">Geadviseerd: Chargeback</span>';
$_['entry_refund_status'] = 'Refund status:<br/><span class="help">Geadviseerd: Refunded</span>';

// Error
$_['error_merchantid'] = 'ICEPAY Merchant ID is vereist!';
$_['error_merchantid_incorrect'] = 'ICEPAY Merchant ID dient 5 getallen te bevatten!';
$_['error_secretcode'] = 'ICEPAY SecretCode is vereist!';
$_['error_secretcode_incorrect'] = 'ICEPAY Merchant ID dient exact 40 karakters lang te zijn.';

//SendCloud Settings
$_['entry_sendcloud_api_key'] = 'API Public Key:';
$_['entry_sendcloud_api_secret'] = 'API Secret Key:';
$_['entry_sendcloud_default_status'] = 'Zet status van bestelling automatisch op:';
$_['entry_sendcloud_default_status_placeholder']  = '---';
$_['entry_sendcloud_address2_as_housenumber']  = 'Gebruik adres 2 als huisnummer';

$_['error_sendcloud_no_api_settings'] = 'Fout: Geen API public en/of secret key gevonden.';
$_['error_sendcloud_no_orders'] = 'Fout: Je hebt geen orders geselecteerd.';
$_['error_sendcloud_order_no_shipping'] = 'Fout: Geen verzendgegevens voor orders: ';
$_['error_sendcloud_process_orders'] = "Fout: Kan de volgende order id(s) niet verwerken: ";
$_['error_sendcloud_api_error_reason'] = "Om de volgende reden: ";

$_['text_sendcloud_success'] = 'Orders verzonden naar SendCloud. <a href="https://panel.sendcloud.nl" target="_blank">Ga naar SendCloud</a>';
$_['text_sendcloud_log_message'] = 'Overgezet naar SendCloud';