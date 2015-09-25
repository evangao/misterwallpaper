<?php

	$bk = imagecreatefromjpeg('http://mwpaper.php-dev.in/media//sample_decor/black.jpg');
	
	$dr = imagecreatefromjpeg('http://mwpaper.php-dev.in/media//sample_decor/dinning_room.jpg');
	
	imagecopymerge($bk, $dr, 0, 0, 0, 0, 25, 25, 50);
	header('Content-type: image/jpeg');
	imagejpeg($bk);


?>