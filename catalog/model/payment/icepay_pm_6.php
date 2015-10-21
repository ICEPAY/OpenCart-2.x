<?php

/**
 * @package       ICEPAY Payment Module for OpenCart
 * @author        Ricardo Jacobs <ricardo.jacobs@icepay.com>
 * @copyright     (c) 2015 ICEPAY. All rights reserved.
 * @version       2.0.6 September 2015
 * @license       BSD 2 License, see https://github.com/icepay/OpenCart/blob/master/LICENSE
 */

require_once(realpath(dirname(__FILE__)) . '/icepay_basic.php');

class ModelPaymentIcepayPm6 extends ModelPaymentIcepayBasic
{
    protected $pmCode = 6;
}
