	<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1];

 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();

 
 ?>




<div class="textBoxWithLargeInfoPanel">
		<?php echo $thisElemArr['text1']; ?>
		<div class="panel panelLarge panelPhoto giveMeBackground" >
			<img class="hereIsYourBackgroud hidden" src="<?php echo $img; ?>"/>
			<div class="panelTitle">
				<?php echo $thisElemArr['text2']; ?>
			</div>
		</div>
		<div class="bigInfoPanel">
			<div class="bigInfoPanelInner hide-panel-right">
				<div class="infoPanelLeft">
					<div class="infoPanelCategories gastro">
                                            
                                            <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
						
						<div class="infoPanelCategory">
							<div class="infoIcon">
								<img src="templates/wildkogel/img/galerie_weiss.png" />
							</div>
							<div class="infoTitle">
								<?php echo  lang('mehr-bilder'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="infoPanelRight">
					<h2><?php echo $thisElemArr['text3']; ?></h2>
					<?php echo $thisElemArr['text4']; ?>
					<?php echo  $mmFunctionsObj->cartButton($thisElemArr['elemData']['seitID'],$thisElemArr['elemSettings']['carTab']);  ?>
				</div>
			</div>
		</div>
   

	</div>

