
<?php
    require_once 'fotolia/fotolia-api.php';

    class Neo_Gallery_FotoliaController extends Mage_Core_Controller_Front_Action
    {
        public function indexAction()
        {
            $id = $this->getRequest()->getParam('id');
            $api = new Fotolia_Api('b55etmZ7eCuWnpkiTaT1cpFeGUfImwMD');
            $comp_dl_data = $api->getMediaComp($id);
            $imageName = time().'.jpg';
            $api->downloadMediaComp($comp_dl_data['url'], Mage::getBaseDir().'/media/fotolia/images/'.$imageName);
            chmod(Mage::getBaseDir().'/media/fotolia/images/'.$imageName,0777);
            echo $imageName;   
        }
    }
    