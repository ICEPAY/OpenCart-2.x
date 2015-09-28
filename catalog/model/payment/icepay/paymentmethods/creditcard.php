<?php

class Icepay_Paymentmethod_Creditcard extends Icepay_Paymentmethod
{
    public $_version       = "2.5.3";
    public $_method        = "CREDITCARD";
    public $_readable_name = "Creditcards";
    public $_issuer        = array('AMEX', 'MASTER', 'VISA');
    public $_country       = array('00');
    public $_language      = array('EN', 'NL', 'DE', 'FR', 'ES', 'JP', 'IT');
    public $_currency      = array('EUR', 'USD', 'GBP', 'AED', 'ARS', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CLP', 'CNY', 'CZK', 'DKK', 'EEK', 'HKD', 'HRK', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JPY', 'KRW', 'LTL', 'LVL', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'SKK', 'THB', 'TRY', 'TWD', 'UAH', 'VND', 'ZAR');
    public $_amount        = array('minimum' => 30, 'maximum' => 1000000);
}

?>
