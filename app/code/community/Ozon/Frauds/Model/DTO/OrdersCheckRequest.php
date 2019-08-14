<?php
class Ozon_Frauds_Model_DTO_OrdersCheckRequest
{
	public $webapp_id = null;
	public $order_id = null;
	public $order_amount = null;
	public $order_currency = null;
	public $txn_type = null;
	public $list_sku = null;
	public $ip = null;
	public $ozon_uuid = null;
	public $email = null;
	public $billing_address = null;
	public $billing_city = null;
	public $billing_region = null;
	public $billing_postal = null;
	public $billing_country = null;
	public $shipping_address = null;
	public $shipping_city = null;
	public $shipping_region = null;
	public $shipping_postal = null;
	public $shipping_country = null;
	public $api_token = null;
	public $api_token_secret = null;
}