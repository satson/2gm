<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; ?>
 
	 <img class="bigHeaderBg hidden" src="<?php echo str_replace('thumb_800/', '', $img) ; ?>" />