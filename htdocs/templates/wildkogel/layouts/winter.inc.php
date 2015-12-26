<div id="siteContent" class="siteContent giveMeBackground vFrontIsCurSeoContentSet">
	<img class="hereIsYourBackgroud hidden" src="templates/wildkogel/img/winter-bg.jpg"/>

	

	<?php if($cms['cms_siteID']  != 1){ ?>
	<div class="breadcrumbs">
            
            <?php echo  $cmsObj->getSiteBreadcrumbsString();  ?>
	   <!--  <span><a href="">Home</a></span>
		<span><a href="">Winter</a></span>
		<span>Aktiv im Winter</span>-->
	</div>
        
        
	<div class="shareIcons">

		<a href="#" class="addthis_button_compact"><img src="templates/wildkogel/img/share-plus.png"/></a>
		<a href=""><img src="templates/wildkogel/img/share-mail.png"/></a>
		<a href=""><img src="templates/wildkogel/img/share-phone.png"/></a>
		<a id="atic_facebook" href="#" onclick="return addthis_sendto('facebook');"><img src="templates/wildkogel/img/share-face.png"/></a>
		<a href="#"  onclick="return addthis_sendto('twitter');"><img src="templates/wildkogel/img/share-tweet.png"/></a>
		<a href="#" onclick="return addthis_sendto('googleplus');"><img src="templates/wildkogel/img/share-gplus.png"/></a>
	</div>
	
	<div class="traumHinzufungen">
			 				<a href=""><img src="templates/wildkogel/img/traum_hinzu.png" /></a>
			 			</div>
	
        <?php } ?>
       <?php 

echo $cmsObj->setElementHolder('contentSite');
?>

	<!-- ELEMENTE -->


	

	<div class="homeUrlaub">
		<?php echo  lang('bereit'); ?>
	</div>
	<div class="homeFinde">
		<div class="homeFindeButton homeFindeToggle">
			<?php echo  lang('circle1'); ?>
		</div>
		<div class="homeFindeButton startHidden">
					<?php echo  lang('circle2'); ?>
				</div>
				<div class="homeFindeButton startHidden">
					<?php echo  lang('circle3'); ?>
				</div>

	</div>
</div>


<!-- Elementy widoku 3-->

<!-- koniec el. wid. 3 -->

<div id="logos">
	<div class="item">
		<a href="http://www.salzburgerland.com/de/" target="_blank"><img src="templates/wildkogel/img/logo-1.png" /></a>
	</div>
	<div class="item">
		<a href="http://www.austria.info/at" target="_blank"><img src="templates/wildkogel/img/logo-2.png" /></a>
	</div>
	<div class="item">
		<a href="http://www.nationalpark.at/" target="_blank"><img src="templates/wildkogel/img/logo-3.png" /></a>
	</div>
	<div class="item">
		<a href="http://www.nationalpark.at/" target="_blank"><img src="templates/wildkogel/img/logo-4.png" /></a>
	</div>
	<div class="item">
		<a href="http://www.alpine-pearls.com/" target="_blank"><img src="templates/wildkogel/img/logo-5.png" /></a>
	</div>
	<div class="item">
		<a href="http://www.klimaaktiv.at/" target="_blank"><img src="templates/wildkogel/img/logo-6.png" /></a>
	</div>
</div>
