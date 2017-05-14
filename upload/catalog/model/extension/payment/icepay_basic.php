<?php

/**
 * @package       ICEPAY Payment Module for OpenCart
 * @author        Ricardo Jacobs <ricardo.jacobs@icepay.com>
 * @copyright     (c) 2016 ICEPAY. All rights reserved.
 * @license       BSD 2 License, see https://github.com/icepay/OpenCart/blob/master/LICENSE
 */

require_once realpath(dirname(__FILE__)) . '/icepay/icepay_api_webservice.php';

class ModelExtensionPaymentIcepayBasic extends Model
{
    private $_order = null;

    public function loadPaymentMethodService()
    {
        $api = Icepay_Api_Webservice::getInstance()->paymentMethodService();

        return $this->setApiSettings($api);
    }

    public function loadPaymentService()
    {
        $api = Icepay_Api_Webservice::getInstance()->paymentService();

        return $this->setApiSettings($api);
    }

    public function loadPostback()
    {
        $api = Icepay_Project_Helper::getInstance()->postback();

        return $this->setApiSettings($api);
    }

    public function loadResult()
    {
        $api = Icepay_Project_Helper::getInstance()->result();

        return $this->setApiSettings($api);
    }

    private function setApiSettings($api)
    {
        try {
            $api->setMerchantID(intval($this->config->get('icepay_merchantid')))->setSecretCode($this->config->get('icepay_secretcode'));
        } catch (Exception $e) {
            echo 'Postback URL installed correctly';
        }

        return $api;
    }

    public function getURL($order, $issuer)
    {
        $api = $this->loadPaymentService();
        $api->addToExtendedCheckoutList(array('AFTERPAY'));

        $this->load->model('checkout/order');

        $total = $this->currency->format($order['total'], $order['currency_code'], $order['currency_value'], false);
        $total = (int)(string)($total * 100);

        $paymentMethodID = str_replace('icepay_pm_', "",  $order['payment_code']);
        $paymentMethodCode = $this->getPaymentMethodCode($paymentMethodID);

        $language = $this->session->data['language'];
        if (version_compare(VERSION, '2.2') >= 0) {
            $language = substr($language, 0, 2);
        }

        $paymentObj = new Icepay_PaymentObject();
        $paymentObj->setOrderID($order["order_id"])
            ->setReference($order["order_id"])
            ->setAmount($total)
            ->setCurrency($this->session->data['currency'])
            ->setCountry($order['payment_iso_code_2'])
            ->setLanguage($language)
            ->setPaymentMethod($paymentMethodCode)
            ->setIssuer($issuer);

        $api->setSuccessURL($this->config->get('config_url') . 'index.php?route=payment/icepay_basic/result')
            ->setErrorURL($this->config->get('config_url') . 'index.php?route=payment/icepay_basic/result');

        $transactionObj = null;

        try {
            if ($api->isExtendedCheckoutRequiredByPaymentMethod($paymentMethodCode)) {
                $customerID = ($order['customer_id']) ? $order['customer_id'] : '-';

                Icepay_Order::getInstance()->setConsumer(
                    Icepay_Order_Consumer::create()
                        ->setConsumerID($customerID)
                        ->setEmail($order['email'])
                        ->setPhone($order['telephone'])
                    );

                $street = $order['payment_address_1'] . ' ' . $order['payment_address_2'];
                Icepay_Order::getInstance()
                    ->setBillingAddress(Icepay_Order_Address::create()
                        ->setInitials($order['payment_firstname'])
                        ->setLastName($order['payment_lastname'])
                        ->setStreet(Icepay_Order_Helper::getStreetFromAddress($street))
                        ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($street))
                        ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($street))
                        ->setZipCode($order['payment_postcode'])
                        ->setCity($order['payment_city'])
                        ->setCountry($order['payment_iso_code_2'])
                    );

                $initials = empty($order['shipping_firstname']) ? $order['payment_firstname'] : $order['shipping_firstname'];
                $lastName = empty($order['shipping_lastname']) ? $order['payment_lastname'] : $order['shipping_lastname'];
                $zipCode = empty($order['shipping_postcode']) ? $order['payment_postcode'] : $order['shipping_postcode'];
                $city = empty($order['shipping_city']) ? $order['payment_city'] : $order['shipping_city'];
                $country = empty($order['shipping_iso_code_2']) ? $order['payment_iso_code_2'] : $order['shipping_iso_code_2'];

                if (!empty($order['shipping_address_1']))
                    $street = $order['shipping_address_1'] . ' ' . $order['shipping_address_2'];

                Icepay_Order::getInstance()
                    ->setShippingAddress(Icepay_Order_Address::create()
                        ->setInitials($initials)
                        ->setLastName($lastName)
                        ->setStreet(Icepay_Order_Helper::getStreetFromAddress($street))
                        ->setHouseNumber(Icepay_Order_Helper::getHouseNumberFromAddress($street))
                        ->setHouseNumberAddition(Icepay_Order_Helper::getHouseNumberAdditionFromAddress($street))
                        ->setZipCode($zipCode)
                        ->setCity($city)
                        ->setCountry($country)
                    );

                // Set Product information
                foreach ($this->cart->getProducts() as $product) {
                    $rates = $this->tax->getRates($product['price'], $product['tax_class_id']);
                    $taxInfo = array_shift($rates);

                    $taxRate = (int)(string)$taxInfo['rate'];
                    $unitPrice = (int)(string)(($product['price'] * 100) + ($taxInfo['amount'] * 100));

                    Icepay_Order::getInstance()
                        ->addProduct(Icepay_Order_Product::create()
                            ->setProductID($product['product_id'])
                            ->setProductName($product["name"])
                            ->setDescription($product["name"])
                            ->setQuantity($product["quantity"])
                            ->setUnitPrice($unitPrice)
                            ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage($taxRate))
                        );
                }

                if (isset($this->session->data['shipping_method'])) {
                    // Shipping costs
                    $rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
                    $taxInfo = array_shift($rates);
                    $shippingCosts = (int)(string)(($this->session->data['shipping_method']['cost'] * 100));

                    if (!empty($taxInfo)) {
                        $vatAmount = (int)(string)($taxInfo['amount'] * 100);
                        $shippingCosts = $shippingCosts + $vatAmount;
                    }

                    Icepay_Order::getInstance()
                        ->addProduct(Icepay_Order_Product::create()
                            ->setProductID(01)
                            ->setProductName($this->session->data['shipping_method']['title'])
                            ->setDescription($this->session->data['shipping_method']['title'])
                            ->setQuantity(1)
                            ->setUnitPrice($shippingCosts)
                            ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage($taxInfo['rate']))
                        );
                }
                // Discounts
                $total_data = array();
                $total1 = 0;
                $total2 = $total;
                $taxes = $this->cart->getTaxes();

                $this->load->model('total/voucher');
                $this->{'model_total_voucher'}->getTotal($total_data, $total2, $taxes);

                $this->load->model('total/coupon');
                $this->{'model_total_coupon'}->getTotal($total_data, $total1, $taxes);

                $this->load->model('total/reward');
                $this->{'model_total_reward'}->getTotal($total_data, $total1, $taxes);

                foreach ($total_data as $discount) {
                    $price = (int)(string)($discount['value'] * 100);
                    $price = -1 * abs($price);

                    if ($discount['code'] != 'voucher') {
                        $price = $price * 1.21;
                    }

                    $price = (int)(string)$price;

                    Icepay_Order::getInstance()
                        ->addProduct(Icepay_Order_Product::create()
                            ->setProductID($discount['code'])
                            ->setProductName($discount['title'])
                            ->setDescription($discount['title'])
                            ->setQuantity(1)
                            ->setUnitPrice($price)
                            ->setVATCategory(Icepay_Order_VAT::getCategoryForPercentage(21))
                        );
                }

                $transactionObj = $api->extendedCheckOut($paymentObj);
            } else {
                $transactionObj = $api->CheckOut($paymentObj);

            }
        } catch (Exception $e) {
            $_SESSION['ICEPAY_ERROR'] = $this->language->get($e->getMessage());
            return false;
        }

        $this->createOrder($order);

        return $transactionObj->getPaymentScreenURL();
    }

    private function createOrder($order)
    {
        $try = $this->db->query("SELECT status FROM `{$this->getTableWithPrefix('icepay_orders')}` WHERE `order_id` = '{$order['order_id']}'");

        if ($try->num_rows == 0) {
            $this->db->query("INSERT INTO `{$this->getTableWithPrefix('icepay_orders')}` 
                (`order_id` ,`status` ,`order_data` ,`created` ,`last_update`)
                    VALUES
                ('{$order['order_id']}', 'NEW', '', NOW(), NOW())");
        }
    }

    public function getOpenCartStatus($IcepayStatusCode)
    {
        return $this->config->get(sprintf("icepay_%s_status_id", strtolower($IcepayStatusCode)));
    }

    public function getOpencartOrder($orderID)
    {
        $this->load->model('checkout/order');

        return $this->model_checkout_order->getOrder($orderID);
    }

    public function getIcepayOrderByID($orderID)
    {
        $query = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_orders')}` WHERE `order_id` = '{$orderID}'");

        $this->_order = $query->rows[0];
        return $this->_order;
    }

    public function updateStatus($orderID, $status, $transactionID)
    {
        $this->db->query("UPDATE `{$this->getTableWithPrefix('icepay_orders')}` SET `status` = '{$status}', `transaction_id` = '{$transactionID}', last_update = NOW() WHERE `order_id` = '{$orderID}' LIMIT 1;");
    }

    public function isFirstOrder($orderID)
    {
        if ($this->_order == null)
            $this->getIcepayOrderByID($orderID);
        if ($this->_order["transaction_id"] == 0)
            return true;
        return false;
    }

    public function getMethod($address, $total)
    {
        $this->load->language('payment/icepay_basic');
        $this->load->model('localisation/currency');

        $method_data = array();

        if (!$this->config->get('icepay_basic_status'))
            return;

        if (isset($this->pmCode)) {
            $storeID = $this->config->get('config_store_id');

            $paymentMethod = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_pminfo')}` WHERE `id` ='{$this->pmCode}' AND `active` = '1' AND (`store_id` = '-1' OR `store_id` = '{$storeID}')");

            if (count($paymentMethod->row) > 0) {

                // Check if payment method has specific geo zone
                if ($paymentMethod->row['geo_zone_id'] != '-1') {
                    // See if geo zones matches
                    $query = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('zone_to_geo_zone')}` WHERE `geo_zone_id` = '{$paymentMethod->rows[0]['geo_zone_id']}' AND country_id = '{$address['country_id']}' AND (zone_id = '{$address['zone_id']}' OR zone_id = '0')");

                    // No match
                    if (!$query->num_rows)
                        return $method_data;
                }

                // Filter paymentmethod based on country, amount and currency from icepay raw data               
                $storedPaymentMethods = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_rawpmdata')}`");

                $filter = Icepay_Api_Webservice::getInstance()->filtering();
                $filter->loadFromArray(unserialize($storedPaymentMethods->row['raw_pm_data']));
                $filter->filterByCurrency($this->session->data['currency'])
                    ->filterByCountry($address['iso_code_2'])
                    ->filterByAmount((int)(string)($total * 100));

                if ($filter->isPaymentMethodAvailable($paymentMethod->row['pm_code'])) {
                    $method_data = array(
                        'code' => "icepay_pm_{$this->pmCode}",
                        'terms' => "",
                        'title' => $paymentMethod->row['displayname'],
                        'sort_order' => $this->config->get('icepay_sort_order')
                    );
                }
            } else {
                return '';
            }
        }

        return $method_data;
    }

    public function getIssuers($pmID)
    {
        if (isset($pmID)) {
            $paymentMethod = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_pminfo')}` WHERE `id` ='{$pmID}'");

            $rawData = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_rawpmdata')}`");

            $method = Icepay_Api_Webservice::getInstance()->singleMethod()->loadFromArray(unserialize($rawData->row['raw_pm_data']));
            $pMethod = $method->selectPaymentMethodByCode($paymentMethod->row['pm_code']);

            $issuers = $pMethod->getIssuers();

            return $issuers;
        }

        return '';
    }


    public function getPaymentMethodName($pmID)
    {
        if (isset($pmID)) {
            $paymentMethod = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_pminfo')}` WHERE `id` ='{$pmID}'");

            return $paymentMethod->row['displayname'];
        }

        return false;
    }

    public function getPaymentMethodCode($pmID)
    {
        if (isset($pmID) && $pmID != 'c') {
            $paymentMethod = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('icepay_pminfo')}` WHERE `id` ='{$pmID}'");

            return $paymentMethod->row['pm_code'];
        }
    }

    public function getTableWithPrefix($tableName)
    {
        return DB_PREFIX . $tableName;
    }
}
