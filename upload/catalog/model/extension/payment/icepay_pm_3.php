<?php

/**
 * @package       ICEPAY Payment Module for OpenCart
 * @author        Ricardo Jacobs <ricardo.jacobs@icepay.com>
 * @copyright     (c) 2017 ICEPAY. All rights reserved.
 * @license       BSD 2 License, see https://github.com/icepay/OpenCart/blob/master/LICENSE
 */

require_once(realpath(dirname(__FILE__)) . '/icepay_basic.php');

class ModelExtensionPaymentIcepayPm3 extends ModelExtensionPaymentIcepayBasic
{
    protected $pmCode = 3;
}
