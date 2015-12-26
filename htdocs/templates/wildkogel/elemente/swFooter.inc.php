<?php  global $cmsObj; ?>
<div class="siteFooter">
	<div class="siteFooterInner">
		<div class="siteFooterTopRow">
			<div class="footerWidget">
				<?php echo $thisElemArr['text1']; ?>
			</div>
			<div class="footerWidget">
				<?php echo $thisElemArr['text2']; ?>
			</div>
			<div class="footerWidget">
				<?php echo $thisElemArr['text3']; ?>
				
				<div class="footerSocial">
               <h4>Follow us</h4>
               <a href="https://www.facebook.com/Wildkogel" target="_blank" ><i class="fa fa-facebook-square"></i></a>
               <a href="https://www.youtube.com/user/UAWildkogel5741" target="_blank"><i class="fa fa-youtube"></i></a>
            </div>
				
			</div>
			<div class="footerWidget">
                        <?php echo $cmsObj->setElementHolder('newsletter', 'inherit'); ?>
			</div>
		</div>
	</div>
</div>

 <div class="belowFooter">
	 	<div class="belowFooterInner">
	
	 		<div class="col-md-4 col-sm-12 copyright"><?php echo $thisElemArr['text4']; ?></div>
	 		<div class="bottomMenu col-md-5 col-sm-12">
                            <?php echo $thisElemArr['text5']; ?>
	 			
	 		</div>
			<div class="col-md-3 col-sm-12 logo-bottom-2gm"><a href="http://www.2getmore.at/werbeagentur-tirol" target="_blank"><img src="https://wildkogel-arena.at/templates/wildkogel/img/logo-2getmore.png"></div>
	 	</div>
	 </div>
