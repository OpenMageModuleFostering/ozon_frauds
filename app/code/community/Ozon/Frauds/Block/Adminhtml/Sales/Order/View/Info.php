<?php
class Ozon_Frauds_Block_Adminhtml_Sales_Order_View_Info extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
	public function getListHtmlFromJson($jsonResponse)
	{
		$arrayResponse = Zend_Json::decode($jsonResponse);
		$html = "<ul>\n";
		foreach($arrayResponse['result'] as $label=>$value) {
			$html .= "\t".'<li>';
			$html .= $label.' : ';
			
			if (is_string($value))
				$html .= $value;
			elseif (is_bool($value))
				$html .= var_export($value, true);
			elseif (is_array($value)) {
				$html .= "<ul>\n";
				foreach ($value as $k=>$v) {
					$html .= "\t<li>$k : $v</li>\n";
				}
				$html .= "</ul>\n";
			}
			elseif (is_numeric($value))
				$html .= $value;
			elseif (is_null($value))
				$html .= "-";
			
			$html .= '</li>'."\n";
		}
		$html .= "</ul>\n";
		
		return $html;
	}
}
