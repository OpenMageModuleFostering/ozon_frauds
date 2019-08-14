<?php
class Ozon_Frauds_TestController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		if (!Mage::getStoreConfig('frauds/services/testpage')) {
			$this->norouteAction();
			return;
		}
		
		if (!function_exists('curl_version')) {
			$msg = "L'extension PHP cURL n'est pas installée sur votre serveur Web";
		}

		else {
			//$order = Mage::getModel('sales/order')->load(43);
			
			$collection = Mage::getModel('sales/order')->getCollection();
			$collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
			$collection->setPage(1, 1)->load();
		
			if (sizeof($collection)) {
				$order = $collection->getFirstItem();
				$result = Mage::helper('ozon_frauds')->orderCheck($order);
				$msg = "<pre>".var_export($result, true)."</pre>";
			}

			else {
				$msg = "Pas de commandes pour appeler le service Ozon";
			}
		}
		
		$this->getResponse()->setBody($msg);
	}
}
