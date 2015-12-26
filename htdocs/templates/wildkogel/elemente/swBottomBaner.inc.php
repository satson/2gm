<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; ?>
<div class="bottomBanner giveMeBackground">
		<div class="bottomBannerInner">
			<img class="hereIsYourBackgroud hidden" src="<?php echo $img; ?>"/>
			<h1><?php echo $thisElemArr['text1']; ?></h1>
						<h2><?php echo $thisElemArr['text1']; ?></h2>
			<div class="homeFinde">
				<div class="homeFindeButton homeFindeToggle">
					<img src="templates/wildkogel/img/finde_deinen_wintertraum.png" />
				</div>
				<div class="homeFindeButton startHidden">
					<a target="_blank" href="http://urlaub.wildkogel-arena.at/neukirchen/de/accommodation/list?customHeader=test"><img src="templates/wildkogel/img/unterkunft_suchen_button.png" /></a>
				</div>
				<div class="homeFindeButton startHidden">
					<a href="packages"><img src="templates/wildkogel/img/aktuelle_packages_button.png" /></a>
				</div>

			</div>
		</div>
	</div>