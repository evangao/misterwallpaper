<?php
class MagePsycho_Xmllinks_Block_Checkout_Links extends Mage_Checkout_Block_Links
{
	public function addCheckoutLink()
    {
		/*$helper = Mage::helper('xmllinks');
		if($helper->isActive() && $helper->getConfig('checkout', 'top_links') == 1){
			return null;
		}*/

        if (!$this->helper('checkout')->canOnepageCheckout()) {
            return $this;
        }

        $parentBlock = $this->getParentBlock();
        if ($parentBlock && Mage::helper('core')->isModuleOutputEnabled('Mage_Checkout')) {
            $text = $this->__('Checkout');
            $parentBlock->addLink($text, 'checkout', $text, true, array(), 60, null, 'class="top-link-checkout"');
        }
        return $this;
    }
}