<?php
class Ozon_Frauds_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function orderCheck($order)
	{
		$result = Mage::getModel('ozon_frauds/dataAccessService')->ordersCheck($order);
		
		Mage::log($result, Zend_Log::DEBUG, 'ozon.log');
		
		return $result;
	}
}
