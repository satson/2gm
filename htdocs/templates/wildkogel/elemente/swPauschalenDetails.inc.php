<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
  $img = $matches[1];
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
?>

<div class="textBoxWithSmallInfoPanel">
		<div class="panelColumnSmall">
			<div class="panel panelLarge panelPhoto giveMeBackground" style="background-image: url(<?php echo SITE_URL.$img ?>);">
				<img class="hereIsYourBackgroud hidden" src="<?php echo $img ?>">
				<div class="panelTitle">
					<?php echo $thisElemArr['text1']; ?>
				</div>
			</div>
			<div class="infoPanel">
				<h2><?php echo $thisElemArr['text2']; ?></h2>
				<?php echo $thisElemArr['text3']; ?>
				<a href=""><?php echo  lang('mehr'); ?> </a>
				<?php echo  $mmFunctionsObj->cartButton($thisElemArr['elemData']['seitID']);  ?>
			</div>
		</div>
		<?php echo $thisElemArr['text4']; ?>
	</div>