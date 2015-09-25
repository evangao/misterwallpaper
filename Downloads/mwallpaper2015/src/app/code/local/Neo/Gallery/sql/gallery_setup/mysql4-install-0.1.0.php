<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table neo_gallery_image(image_id int not null auto_increment, image varchar(100), name varchar(100), category varchar(100), status int(1), primary key(image_id));

create table neo_gallery_category(category_id int not null auto_increment, category_name varchar(100), status int(1), primary key(category_id));

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 