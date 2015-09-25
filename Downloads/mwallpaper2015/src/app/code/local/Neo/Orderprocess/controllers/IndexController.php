<?php
class Neo_Orderprocess_IndexController extends Mage_Core_Controller_Front_Action{
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
    public function cropAction()
    {
	try
	{
			
	    Mage::register('image', $this->getRequest()->getParam('galleryImage'));
	    $size = getimagesize($this->getRequest()->getParam('galleryImage'));
	    $cropSize = $this->getRequest()->getParam('size');
	    if($cropSize =="custom"):
	    
		$height = (int)trim($this->getRequest()->getParam('height'));
		$width  = (int)trim($this->getRequest()->getParam('width'));
	    
	    else:
		
		$sizeArray = explode("x",$cropSize);
		$width  = (int)trim($sizeArray[0]); 
		$height = (int)trim($sizeArray[1]);
	    
	    endif;
	    
	    //var_dump($height*38);
	    //var_dump($size[1]);
		//var_dump($width*38); 
		//var_dump($size[0]);
		//die;
		//echo $size[0]/($width*38);
		//echo $size[1]/($height*38);
		//exit;
		//new condition added by Huzefa on 6th November 2013
          if($size[0] >= 200 && $size[1] >= 200) {
            if($size[0]/($width) >= 12  && $size[1]/($height) >= 12) {
	           Mage::getSingleton('core/session')->addNotice('Image resolution is very good for  the wallpaper size.');
	           Mage::register('quality','Excellent');
           }
           elseif($size[0]/($width) >= 10  && $size[1]/($height) >= 10){
	           Mage::getSingleton('core/session')->addNotice('Image resolution is good for the wallpaper size.');
		   Mage::register('quality','Good');
           }
           else {
	           Mage::getSingleton('core/session')->addNotice('Image resolution is poor for the wallpaper size.');
		   Mage::register('quality','Poor');
           }
          }
	     elseif($size[0]/($width*25) > 1.2  && $size[1]/($height*25) > 1.2){
		    Mage::getSingleton('core/session')->addNotice('Image resolution is very good for the wallpaper size.');
		    Mage::register('quality','Poor');
		    
	     }elseif($size[0]/($width*25) >= 1 && $size[1]/($height*25) >= 1){
		    Mage::getSingleton('core/session')->addNotice('Image resolution is good for the wallpaper size.');
		    Mage::register('quality','Good');
		   
	     }else{

		    Mage::getSingleton('core/session')->addNotice('Image resolution is too poor. Please Select an image with a higher resolution (megapixels)');
		    Mage::register('quality','Poor');
	    }
	    Mage::register('image-size',$size[0]." x ".$size[1]);
			
		
	}catch(Exception $e){
		Mage::getSingleton('core/session')->addError($e->getMessage());
				$this->_redirectUrl(Mage::getBaseUrl());
				return;
	}
	
	$this->loadLayout();
	$this->getLayout()->getBlock("head")->setTitle($this->__("Crop Image"));
	$this->renderLayout();
	
    }
    public function previewAction()
    {
	  $this->loadLayout()->renderLayout();

	
    }
	public function downloadAction()
	{

		$croped_image = base64_decode($this->getRequest()->getParam('croped_image'));
		$orginal_file = base64_decode($this->getRequest()->getParam('orginal_file'));
		$order_id     = $this->getRequest()->getParam('order_id');
		$_order = Mage::getModel('sales/order')->load($order_id);
		
		$shipping_address = $_order->getShippingAddress();
		
		
		$my_file = Mage::getBaseDir('media')."/wallpaperImages/order-info.txt";
		$orderData = "Order Id : ".$_order->getRealOrderId()."\n";
		$orderData .= "Customer Name : ".$shipping_address->getFirstname()." ".$shipping_address->getLastname()."\n";
		$orderData .="Shipping Address : \n";
		$streetArray = $shipping_address->getStreet();
		$steetStr = $streetArray[0];
		if(array_key_exists(1, $streetArray) && $streetArray[1]!=NUll){
		    $steetStr.=", ".$streetArray[1];
		}
		
		$orderData .=$steetStr."\n";
		if($shipping_address->getCompany()!=""){
		    $orderData .=$shipping_address->getCompany()."\n";
		}
		$orderData .=$shipping_address->getCity().", ".$shipping_address->getRegion()."\n";
		$orderData .=Mage::getModel('directory/country')->loadByCode($shipping_address->getCountryId())->getName().", ".$shipping_address->getPostcode().".";
		$handle = fopen($my_file, 'w');
		fwrite($handle, $orderData);
		fclose($handle);
		
		# create new zip opbject
		$zip = new ZipArchive();

		# create a temp file & open it
		$tmp_file = tempnam('.','');
		$zip->open($tmp_file, ZipArchive::CREATE);

		# loop through each file
		//foreach($files as $file){

		    # download file
		    $croped_file1 = file_get_contents($croped_image);

		    #add it to the zip
		    $zip->addFromString("croped-image-".basename($croped_image),$croped_file1);
		    
		     # download file
		    $orginal_file1 = file_get_contents($orginal_file);

		    #add it to the zip
		    $zip->addFromString("orginal-image-".basename($orginal_file),$orginal_file1);
		    
		    $orderDtlFile = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)."media/wallpaperImages/order-info.txt";
		    $orderDtlFile1 = file_get_contents($orderDtlFile);
		   
		    #add it to the zip
		    $zip->addFromString(basename($orderDtlFile),$orderDtlFile1);

		//}

		# close zip
		$zip->close();
		unlink($orderDtlFile);
		# send the file to the browser as a download
		header('Content-disposition: attachment; filename=MW-'.$_order->getRealOrderId().'.zip');
		header('Content-type: application/zip');
		readfile($tmp_file);

	}	    
		
	public function createAction()
	{
		$crop_w 		= $this->getRequest()->getParam('imageWidth');
		$crop_h 		= $this->getRequest()->getParam('imageHeight');
		$jpeg_quality 	= 100;
		$image 			= $this->getRequest()->getParam('image');
		$infoHeight 	= $this->getRequest()->getParam('infoHeight');
		$infoWidth  	= $this->getRequest()->getParam('infoWidth');

		$ImageInformation = getimagesize($image);
		$targ_w  = $ImageInformation[0];
		$targ_h  = $ImageInformation[1];
		
		$cropWidth  = (int)$_POST['w'];
		$cropHeight = (int)$_POST['h'];
		$cropX      = (int)$_POST['x'];
		$cropY      = (int)$_POST['y'];
		    
		$widthRatio  = $this->getRequest()->getParam('widthRatio');     		    
		$heightRatio = $this->getRequest()->getParam('heightRatio'); 
		$cropWActual = ($cropWidth*$targ_w)/$widthRatio;
		$cropHActual = ($cropHeight*$targ_h)/$heightRatio;
		$cropXActual = ($cropX*$targ_w)/$widthRatio;
		$cropYActual = ($cropY*$targ_h)/$heightRatio;
		$targ_w  = $cropWActual;
		$targ_h  = $cropHActual;
		$pos = strrpos($image,'/');
		$image_name = substr($image,$pos+1);
	
		//$src   = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'dinning_room.jpg';
		$src   = $image;
		$cropImage = time()."-".$image_name;
		$path_parts = pathinfo($image);

		//var_dump($path_parts['extension']);die;
		if ($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' || $path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' ) {

		    	$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$cropXActual,$cropYActual,$targ_w,$targ_h,$cropWActual,$cropHActual);
			//take image to be super imposed on
			$bg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'black.jpg';
			imagecopymerge($dst_r, $bg,10, 10, 10, 10, 20, 20, 50);
			$bg_r = imagecreatefromjpeg($bg);
			imagejpeg($dst_r,Mage::getBaseDir('media').DS."wallpaperImages".DS."images".DS.$cropImage,$jpeg_quality);
	

		} elseif ($path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF') {
			$img_r = imagecreatefromgif($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$cropXActual,$cropYActual,$targ_w,$targ_h,$cropWActual,$cropHActual);
			//take image to be super imposed on
			$bg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'black.jpg';
			imagecopymerge($dst_r, $bg,10, 10, 10, 10, 20, 20, 50);
			$bg_r = imagecreatefromjpeg($bg);
			imagegif($dst_r,Mage::getBaseDir('media').DS."wallpaperImages".DS."images".DS.$cropImage);
	
		    
		} elseif ($path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG') {

			$img_r = imagecreatefrompng($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$cropXActual,$cropYActual,$targ_w,$targ_h,$cropWActual,$cropHActual);
			//take image to be super imposed on
			$bg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'black.jpg';
			imagecopymerge($dst_r, $bg,10, 10, 10, 10, 20, 20, 50);
			$bg_r = imagecreatefromjpeg($bg);
			imagepng($dst_r,Mage::getBaseDir('media').DS."wallpaperImages".DS."images".DS.$cropImage,9);
		    
		}
		/*elseif ($path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF') {

			$image = new Imagick($src);
			$image->setImageFormat('png');
			//$img_r = imagecreatefromtiff($src);
			$img_r = $image;
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
			imagecopyresampled($dst_r,$img_r,0,0,$cropXActual,$cropYActual,$targ_w,$targ_h,$cropWActual,$cropHActual);
			//take image to be super imposed on
			$bg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'black.jpg';
			imagecopymerge($dst_r, $bg,10, 10, 10, 10, 20, 20, 50);
			$bg_r = imagecreatefromjpeg($bg);
			imagepng($dst_r,Mage::getBaseDir('media').DS."wallpaperImages".DS."images".DS.$cropImage);
		    
		}*/
     

		Mage::register('cropImage',Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wallpaperImages".DS."images".DS.$cropImage);
		Mage::register('orginalImage',$image);

		Mage::getSingleton('core/session')->setCropImage(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wallpaperImages".DS."images".DS.$cropImage);
		Mage::getSingleton('core/session')->setOrginalImage($image);
		
		

		$size = getimagesize(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."wallpaperImages".DS."images".DS.$cropImage);
		 
                $widthI  = $this->getRequest()->getParam('infoWidth');
                $heightI = $this->getRequest()->getParam('infoHeight');
		
		$infoW 		= ($this->getRequest()->getParam('infoWidth')-2)*25;
		$infoH 		= ($this->getRequest()->getParam('infoHeight')-2)*25;
		//var_dump($size[0]);
		//var_dump($infoW);
		
		//var_dump($size[1]);
		
		//var_dump($infoH); die;
		//var_dump($size[0]); var_dump($size[1]);


           if($size[0] >= 200 && $size[1] >= 200) {
              if($size[0]/($widthI) >= 12  && $size[1]/($heightI) >= 12) {
	           Mage::getSingleton('core/session')->addNotice('Image resolution is very good for the wallpaper size.');
	           Mage::register('quality','Excellent');
           }
           elseif($size[0]/($widthI) >= 9.9  && $size[1]/($heightI) >= 9.9){
	           Mage::getSingleton('core/session')->addNotice('Image resolution is good for the wallpaper size.');
		   Mage::register('quality','Excellent');
           }
           else {
	           Mage::getSingleton('core/session')->addNotice('Image resolution is poor for the wallpaper size.');
		   Mage::register('quality','Good');
            }
          }
	  elseif($size[0]/$infoW > 1.2 && $size[1]/$infoH > 1.2){
			Mage::getSingleton('core/session')->addNotice('Image resolution is very good for or the wallpaper size.');
			
		} elseif($size[0]/$infoW >= 1 && $size[1]/$infoH >= 1){
			Mage::getSingleton('core/session')->addNotice('Image resolution is good for or the wallpaper size.');
			
		}else{

			Mage::getSingleton('core/session')->addNotice('Image resolution is too poor. Please Select an image with a higher resolution (megapixels)');
		}

		$this->_redirect('orderprocess/index/preview', array(
		    	'size'=>$this->getRequest()->getParam('size'),
			'imageWidth'=>$this->getRequest()->getParam('CropOrignalWidth'),
			'imageHeight'=>$this->getRequest()->getParam('CropOrignalHeight')));

		/*$img_r = imagecreatefromjpeg($src);
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
		$targ_w,$targ_h,$_POST['w'],$_POST['h']);
		//take image to be super imposed on
		$bg = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). DS . 'sample_decor' . DS .'black.jpg';
		imagecopymerge($dst_r, $bg,10, 10, 10, 10, 20, 20, 50);
		$bg_r = imagecreatefromjpeg($bg);
		imagejpeg($dst_r,Mage::getBaseDir('media').DS."wallpaperImages".DS."images".DS.time()."-".$image_name );*/

	}
	
	public function calcPriceAction()
	{
	    $sqm = $this->getRequest()->getParam('sqmval');
	    if($sqm<=1){
		echo Mage::helper('core')->currency(65,true,false);
		return;
	    }
	    
	    $price =0.0;
	    $_customPrices = Mage::getModel('customprice/customprice')->getCollection()->setOrder('min','asc');
	    foreach($_customPrices as $customPrice):
		$minSqm = (float)$customPrice->getMin();
		$maxSqm = (float)$customPrice->getMax();
		if($sqm > $minSqm && $sqm <= $maxSqm):		    
		    $price = $sqm*(float)$customPrice->getPrice();
		    echo Mage::helper('core')->currency($price,true,false);
		    break;
		endif;
	    endforeach;
	}
    
}
