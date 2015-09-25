<?php
class Neo_Blocks_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); 
	  
    }
    public function uploadAction()
    {
            
            
        if (isset($_FILES)){
            
            if($_FILES['image']['size'] > 52428800)
            {
                //throw new Exception('Disallowed File size it should be less than 50 MB .');
                Mage::getSingleton('core/session')->addError('Disallowed File size it should be less than 50 MB .');
                echo "sizeerror";
                return;

            }
            $fileTypeArray = explode(".",$_FILES['image']['name']);
            $fileType = end($fileTypeArray);
            if(!in_array(strtolower($fileType),array('jpg','JPG','JPEG','jpeg','png','PNG','tiff','tif'))){
                Mage::getSingleton('core/session')->addError('Disallowed File Type');
                echo "fileerror";
                return;
            }
            $path = Mage::getBaseDir('media') . DS . 'userUploads' . DS .'image'.DS;
            //$path = Mage::getBaseDir()."/plupload/examples/uploads";
            $uploader = new Varien_File_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg','jpeg','png','gif','tiff','tif'));
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $str = str_replace(' ','',$_FILES['image']['name']);

            $destFile = $path.time().$str;
            $filename = $uploader->getNewFileName($destFile);
            $uploader->save($path, $filename);
            $image=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'userUploads/image/'.$filename;
            $path_parts = pathinfo($image);
            if($path_parts['extension']=="tif" || $path_parts['extension']=="TIF" || $path_parts['extension']=="tiff" || $path_parts['extension']=="TIFF")
            {
                
                $changetype = new Imagick($image);
                $changetype->setImageFormat('jpg');
                $typeChangeImageName = time();
                
                
               $changetype->writeImage(Mage::getBaseDir('media').DS."userUploads".DS."image".DS.$typeChangeImageName.".jpg");
               $image = Mage::getBaseUrl('media').DS."userUploads".DS."image".DS.$typeChangeImageName.".jpg";
                
            }
            echo $image;return;

        }		    
    }
    
    /***
     * Purpose Function to download Pdf file 
     *
     * Author  shankar ingale
    ***/
    public function instructionsPdfAction()
    {
	
	echo $fullPath = Mage::getBaseDir('media').DS.basename("MW_installation-instructions.pdf");
	if (is_readable ($fullPath)) {
	    $fsize = filesize($fullPath);
	    $path_parts = pathinfo($fullPath);
	    header("Content-type: application/pdf"); // add here more headers for diff.     extensions
	    header("Content-Disposition: attachment; filename='".$path_parts["basename"]."'");     // use 'attachment' to force a download
	    
	    readfile($fullPath);
	    exit;	
	}
    }	
    
    
}