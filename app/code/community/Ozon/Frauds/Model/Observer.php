<?php
class Ozon_Frauds_Model_Observer
{
	public function orderCheck($observer)
	{
		if (Mage::getStoreConfig('frauds/services/enabled')) {
			$_event = $observer->getEvent();
			$_order = $_event->getOrder();
			
	    	$result = Mage::helper('ozon_frauds')->orderCheck($_order);
	    	
	    	$cssClass = 'ozon_'.$result->result->order_risk;
	    	$toolTip = implode(',', $result->result->tags);
	    	
	    	$_order->setOzonScore('<span class="'.$cssClass.'" '.(!empty($toolTip) ? 'title="'.$toolTip.'"' : '').'>'.$result->result->score.'</span>');
	    	$_order->setOzonResponse(Zend_Json::encode($result));
	    	
	    	$_order->save();
		}
	}
}