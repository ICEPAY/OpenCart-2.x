<?php

class Icepay_Paymentmethod_Paypal extends Icepay_Paymentmethod
{
    public $_version       = "2.5.3";
    public $_method        = "PAYPAL";
    public $_readable_name = "PayPal";
    public $_issuer        = array('DEFAULT');
    public $_country       = array('00');
    public $_language      = array('00');
    public $_currency      = array('EUR', 'USD', 'GBP', 'AUD', 'CAD', 'CZK', 'DKK', 'HUF', 'JPY', 'NOK', 'NZD', 'PLN', 'SGD', 'SEK', 'CHF', 'BRL', 'HKD', 'ILS', 'MYRP', 'MXN', 'PHP', 'TWD', 'THB', 'TRY');
    public $_amount        = array('minimum' => 1, 'maximum' => 100000000);
}

?>
