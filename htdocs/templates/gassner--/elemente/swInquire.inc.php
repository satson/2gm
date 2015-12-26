
<?php 
global $cms;


if($cms['cms_ownFields']['_fixAnfrageHide'] != 'on'){

?>
 <div class="inquire">
 <?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; ?>
 
	 <img class="inquireBg hidden" src="<?php echo $img; ?>" />
 
 
            <div class="container">
                 <?php echo $thisElemArr['text1'] ; ?>
             <?php echo $thisElemArr['text2'] ; ?>
             
            </div>
        </div>
 <?php  } ?>       