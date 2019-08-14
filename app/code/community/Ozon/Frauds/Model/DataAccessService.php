<?php
class Ozon_Frauds_Model_DataAccessService extends Ozon_Frauds_Model_AbstractService
{
	public function ordersCheck($order)
	{
		$requestObject = new Ozon_Frauds_Model_DTO_OrdersCheckRequest();
		
		$requestObject->webapp_id = Mage::getStoreConfig('frauds/services/webapp_id');
		$requestObject->order_id = $order->getId();
		$requestObject->order_amount = round($order->getGrandTotal(), 3);
		$requestObject->order_currency = Mage::app()->getStore()->getCurrentCurrencyCode();
		$requestObject->txn_type = $this->getTxnType($order->getPayment()->getMethodInstance()->getCode());
		$requestObject->list_sku = $this->getListSku($order);
		$requestObject->ip = $order->getRemoteIp();
		$requestObject->ozon_uuid = Mage::getModel('core/cookie')->get('ozon_uuid');
		$requestObject->email = $order->getCustomerEmail();
		
		$billingAddress = $order->getBillingAddress();
		
		$requestObject->billing_address = $billingAddress->getStreet(1);
		$requestObject->billing_city = $billingAddress->getCity();
		$requestObject->billing_region = $billingAddress->getRegion();
		$requestObject->billing_postal = $billingAddress->getPostcode();
		$requestObject->billing_country = $billingAddress->getCountry();

		$shippingAddress = $order->getShippingAddress();
		
		$requestObject->shipping_address = $shippingAddress->getStreet(1);
		$requestObject->shipping_city = $shippingAddress->getCity();
		$requestObject->shipping_region = $shippingAddress->getRegion();
		$requestObject->shipping_postal = $shippingAddress->getPostcode();
		$requestObject->shipping_country = $shippingAddress->getCountry();
		$requestObject->api_token = Mage::getStoreConfig('frauds/services/api_token');
		$requestObject->api_token_secret = Mage::getStoreConfig('frauds/services/api_token_secret');
		
		$result = $this->call('orders/check', $requestObject);
		return $result;
	}
	
	private function getTxnType($paymentCode)
	{
		//Mage::log(array_keys(Mage::getStoreConfig('payment')), Zend_Log::DEBUG, 'ozon.log');
		
		$txn_type = 'creditcard';
		
		if (preg_match('/paypal/i', $paymentCode)) $tnx_type = 'paypal';
		elseif (preg_match('/ccsave/i', $paymentCode)) $tnx_type = 'creditcard';
		elseif (preg_match('/ogone/i', $paymentCode)) $tnx_type = 'creditcard';
		elseif (preg_match('/paybox/i', $paymentCode)) $tnx_type = 'creditcard';
		elseif (preg_match('/cybermut/i', $paymentCode)) $tnx_type = 'creditcard';
		elseif (preg_match('/googlecheckout/i', $paymentCode)) $tnx_type = 'google';
		
		return $txn_type;
	}
	
	private function getListSku($order)
	{
		$skus = array();
		
		$items = $order->getAllVisibleItems();
		
		foreach($items as $item) {
			$skus[] = $item->getSku();
		}
		
		return implode(',', $skus);
	}
}
