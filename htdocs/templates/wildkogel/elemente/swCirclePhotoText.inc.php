<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; ?>
	<div class="testimonialBanner giveMeBackground">
		<div class="testimonialInner">
			<img class="hereIsYourBackgroud hidden" src="templates/wildkogel/img/steckbrief.png"/>
			<img src="<?php echo $img; ?>" />
			<?php echo $thisElemArr['text1']; ?>
		</div>
	</div>
