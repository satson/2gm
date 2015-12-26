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
    
    
    <div class="bigInfoPanel multiInfoPanel programFullWidth">
		<div class="bigInfoPanelInner ">
                    
				<div class="infoPanelCategories ">
                                    <h2 class="rightPanelTitle">    <?php echo $thisElemArr['text4']; ?></h2>
                                    
                                    <?php echo $thisElemArr['text3']; ?>
                                    
                                    
                                      <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
				
				</div>
			 
			 
		</div>
        
        
        <?php echo  $mmFunctionsObj->cartButton($thisElemArr['elemData']['seitID'],$thisElemArr['elemSettings']['carTab']);  ?>
	</div>
    
  

	</div>
