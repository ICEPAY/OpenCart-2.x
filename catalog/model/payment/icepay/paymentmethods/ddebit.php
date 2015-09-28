<?php

class Icepay_Paymentmethod_Ddebit extends Icepay_Paymentmethod
{
    public $_version       = "2.5.3";
    public $_method        = "DDEBIT";
    public $_readable_name = "Direct Debit";
    public $_issuer        = array('INCASSO');
    public $_country       = array('NL');
    public $_language      = array('NL', 'EN');
    public $_currency      = array('EUR');
    public $_amount        = array('minimum' => 1, 'maximum' => 200000);
}

?>
