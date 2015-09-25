<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table neo_examples(example_id int not null auto_increment, name varchar(100), image varchar(100), categories varchar(100), status int(1),primary key(example_id));
create table neo_example_category(category_id int not null auto_increment, name varchar(100), status int(1), description text, primary key(category_id));



SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 