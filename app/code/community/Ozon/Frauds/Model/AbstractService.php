<?php
abstract class Ozon_Frauds_Model_AbstractService
{
	protected function restService($functionCall, $requestObject)
	{
		$postQuery = http_build_query($requestObject);
		
		$ch = curl_init(Mage::getStoreConfig('frauds/services/base_url').$functionCall);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, count($requestObject));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postQuery);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$response = curl_exec($ch);
		
		return $response;
	}
	
	public function call($functionName, $requestObject)
	{
		$resultString = $this->restService($functionName, $requestObject);
		return $this->jsonToObject($resultString, $requestObject);
	}
	
	protected function jsonToObject($result, $request = null)
	{
		$object = new stdClass();
		$resultObj = null;
		$requestObj = null;
		
		try {
			if (!empty($result)) {
				$resultArray = Zend_Json::decode($result);
				
				$resultObj = new Ozon_Frauds_Model_DTO_OrdersCheckResponse();
				if (isset($resultArray['success'])) $resultObj->success = $resultArray['success'];
				if (isset($resultArray['ozon_order_id'])) $resultObj->ozon_order_id = $resultArray['ozon_order_id'];
				if (isset($resultArray['message'])) $resultObj->message = $resultArray['message'];
				if (isset($resultArray['webapp'])) $resultObj->webapp = $resultArray['webapp'];
				if (isset($resultArray['order_risk'])) $resultObj->order_risk = $resultArray['order_risk'];
				if (isset($resultArray['score'])) $resultObj->score = $resultArray['score'];
				if (isset($resultArray['tags'])) $resultObj->tags = $resultArray['tags'];
				if (isset($resultArray['ip_user_type'])) $resultObj->ip_user_type = $resultArray['ip_user_type'];
				if (isset($resultArray['ip_distance'])) $resultObj->ip_distance = $resultArray['ip_distance'];
				if (isset($resultArray['ip_country_code'])) $resultObj->ip_country_code = $resultArray['ip_country_code'];
				if (isset($resultArray['proxy_anonymous'])) $resultObj->proxy_anonymous = $resultArray['proxy_anonymous'];
				if (isset($resultArray['proxy_score'])) $resultObj->proxy_score = $resultArray['proxy_score'];
				if (isset($resultArray['high_risk_email'])) $resultObj->high_risk_email = $resultArray['high_risk_email'];
				if (isset($resultArray['ship_forward'])) $resultObj->ship_forward = $resultArray['ship_forward'];
				if (isset($resultArray['calculation_time_ms'])) $resultObj->calculation_time_ms = $resultArray['calculation_time_ms'];
			}
			if (!empty($request)) {
				$requestObj = $request;
			}
		}
		catch (Exception $e) {
			//
		}
		if (!empty($resultObj) && !empty($requestObj)) {
			$object->request = $requestObj;
			$object->result = $resultObj;
		}
		
		return $object;
	}
}