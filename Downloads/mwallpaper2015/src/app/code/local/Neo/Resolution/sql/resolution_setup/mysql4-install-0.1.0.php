<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table neo_resolution(id int not null auto_increment, width_px float(7,2), height_px float(7,2), width_cm float(7,2), height_cm float(7,2), status int(1), primary key(id));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 
