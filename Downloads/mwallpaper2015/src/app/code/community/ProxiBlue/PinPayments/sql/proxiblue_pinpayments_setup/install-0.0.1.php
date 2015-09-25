<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute('customer', 'pinpayments_token', array(
    'label'         => 'Pin Payments Token',
    'visible'       => 1,
    'required'      => 0,
    'position'      => 1,
    'sort_order'    => 80
));

$customerattrubute = Mage::getModel('customer/attribute')->loadByCode('customer', 'pinpayments_token');
$forms=array('adminhtml_customer',);
$customerattrubute->setData('used_in_forms', $forms);
$customerattrubute->save();

$installer->endSetup();


