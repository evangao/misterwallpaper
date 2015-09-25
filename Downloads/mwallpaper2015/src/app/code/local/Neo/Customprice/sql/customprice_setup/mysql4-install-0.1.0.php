<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table neo_custom_price(id int not null auto_increment, min float(7,2), max float(7,2), price float(7,2), primary key(id));
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 