<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("order", "ozon_score", array("type" => "varchar"));
$installer->addAttribute("order", "ozon_response", array("type" => "text"));

$installer->endSetup();
