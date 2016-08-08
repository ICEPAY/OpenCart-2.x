<?php
require_once(dirname(__FILE__).'/../../model/sendcloud/sendcloud_api.php');

class ControllerModuleSendcloud extends Controller {

	public function bulk()
	{
		$this->load->model('setting/setting');
		$icepay_sendcloud_settings = $this->model_setting_setting->getSetting('icepay');
		$this->load->language('payment/icepay_basic');

		$json = array();

		if (empty($icepay_sendcloud_settings['icepay_sendcloud_api_key']) || empty($icepay_sendcloud_settings['icepay_sendcloud_api_secret'])) {
			$json['error'] = $this->language->get('error_sendcloud_no_api_settings');
		} else if (!isset($_POST['selected'])) {
			$json['error'] = $this->language->get('error_sendcloud_no_orders');
		}

		if (!isset($json['error'])) {
			$api = new SendcloudApi('live', $icepay_sendcloud_settings['icepay_sendcloud_api_key'], $icepay_sendcloud_settings['icepay_sendcloud_api_secret']);
			$selected = $_POST['selected'];

			$this->load->model('sale/order');
			$order_model = $this->model_sale_order;

			$shipping_methods = $api->shipping_methods->get();

			$orders = Array();
			$errors = Array();
			$errors['no_shipping_details'] = Array();
			$errors['no_shipping_method'] = Array();

			foreach ($selected as $key => $s) {
				$order = $order_model->getOrder($s);
				if ($order['shipping_iso_code_2'] == "") {
					$errors['no_shipping_details'][] = $order['order_id'];
				}
			}

			if (!empty($errors['no_shipping_details'])) {

				$order_error_ids = implode(', ', $errors['no_shipping_details']);
				$message = $this->language->get('error_sendcloud_order_no_shipping') . " " . $order_error_ids;

				$json['error'] = $message;
			} else {

				foreach ($selected as $key => $s) {
					$order = $order_model->getOrder($s);
					$shipment_id = $this->getSuitableCountry($shipping_methods, $order);

					if ($shipment_id) {
						$order['sendcloud_shipment_id'] = $shipment_id;
						$orders[] = $order;
					} else {
						$errors['no_shipping_method'][] = $order['order_id'];
					}
				}

				if (!empty($errors['no_shipping_method'])) {

					$order_error_ids = implode(', ', $errors['no_shipping_method']);
					$message = $this->language->get('error_sendcloud_process_orders') . " " . $order_error_ids;

					$json['error'] = $message;
				} else {

					foreach ($orders as $order) {

						try {
							$api->parcels->create(array(
									'name' => $order['shipping_firstname'] . ' ' . $order['shipping_lastname'],
									'company_name' => $order['shipping_company'],
									'address' => ($icepay_sendcloud_settings['icepay_sendcloud_address2_as_housenumber'] ? $order['shipping_address_1'] . ' ' . $order['shipping_address_2'] : $order['shipping_address_1']),
									'address_2' => ($icepay_sendcloud_settings['icepay_sendcloud_address2_as_housenumber'] ? '' : $order['shipping_address_2']),
									'city' => $order['shipping_city'],
									'postal_code' => $order['shipping_postcode'],
									'requestShipment' => false,
									'email' => $order['email'],
									'telephone' => $order['telephone'],
									'country' => $order['shipping_iso_code_2'],
									'shipment' => array(
										'id' => $order['sendcloud_shipment_id']
									),
									'order_number' => $order['order_id']
								)
							);
						} catch (SendCloudApiException $exception) {
							// TODO: Validate before transporting instead of catching the API errors.
							$order_error_ids = implode(', ', $errors['no_shipping_method']);
							$message = $this->language->get('error_sendcloud_process_orders') . " " . $order_error_ids . $this->language->get('error_sendcloud_api_error_reason') . $exception->message . '.';
							$json['error'] = $message;
						}

						if ($icepay_sendcloud_settings['icepay_sendcloud_default_status'] !== 0) {
							$this->updateOrderStatus($order);
						}

						if(!isset($json['error']))
						{
							$json['success'] = $this->language->get('text_sendcloud_success');
						}

					}
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function updateOrderStatus($order){
		$order_id = $order['order_id'];
		$icepay_sendcloud_settings = $this->model_setting_setting->getSetting('icepay');
		$order_status_id = $icepay_sendcloud_settings['icepay_sendcloud_default_status'];
		$notify = false;
		$comment = nl2br($this->language->get('text_sendcloud_log_message'));
		$date_added = date($this->language->get('date_format_short'));

		// Queries Borrowed from /catalog/model/checkout/order.php
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	}

	private function getSuitableCountry ($shipping_methods, $order){

		foreach ($shipping_methods as $sm) {
			if($sm['id'] == 8){
				// Workaround: Brievenpost is not suitable for transport scenarios. 
				// It does not allow you to change to a correct parcel shipping method in the SendCloud panel. 
				continue;
			}
			foreach ($sm['countries'] as $country) {
				if ($country['iso_2'] == $order['shipping_iso_code_2']){
					return $sm['id'];
				} 
			}
		}
		return false;
	}	
}
?>