<?php

class Icepay_Paymentmethod_Wire extends Icepay_Paymentmethod
{
    public $_version       = "2.5.3";
    public $_method        = "WIRE";
    public $_readable_name = "Wire Transfer";
    public $_issuer        = array('DEFAULT');
    public $_country       = array('00');
    public $_language      = array('NL', 'EN', 'DE', 'FR', 'ES');
    public $_currency      = array('EUR', 'USD', 'GBP');
    public $_amount        = array('minimum' => 30, 'maximum' => 1000000);
}

?>

