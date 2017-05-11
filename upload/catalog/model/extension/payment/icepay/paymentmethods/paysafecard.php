<?php

class Icepay_Paymentmethod_Paysafecard extends Icepay_Paymentmethod
{
    public $_version       = "2.5.3";
    public $_method        = "PAYSAFECARD";
    public $_readable_name = "PaySafeCard";
    public $_issuer        = array('DEFAULT');
    public $_country       = array('00');
    public $_language      = array('00');
    public $_currency      = array('EUR', 'USD', 'GBP');
    public $_amount        = array( 'minimum' => 30, 'maximum' => 1000000);
}

?>
