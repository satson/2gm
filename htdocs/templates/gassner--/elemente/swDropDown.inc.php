
<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();

	
  $classBuild = '';
        $allFilterKats = $mmFunctionsObj->mmGetAllFilterkategoriesListFromOneDetailElementArray($thisElemArr['elemData']['selemID']);
        if (isset($allFilterKats) && !empty($allFilterKats)) {
          $allFilterKatsArr = explode(';', $allFilterKats);
          foreach ($allFilterKatsArr as $valueFilKatI) {
          $classBuild .= ' mmPauschalenUebersichtElementSpalteId-'.$valueFilKatI;
          }
        }

?>
<div  id="s-<?php echo $thisElemArr['elemData']['selemID'] ?>" class="drop-holder  <?php echo $classBuild ?>">
<div class="container">
	<div class="dropdown-button">
		<?php echo $thisElemArr['text1']; ?>
	</div>
</div>
<div class="dropdown-content work-description">
	<div class="container">
		<div class="col-md-5">
			<div class="work-des1"><?php echo $thisElemArr['text2']; ?></div>
			<div class="work-des2"><?php echo $thisElemArr['text3']; ?></div>
			<div class="work-des3"><?php echo $thisElemArr['text4']; ?></div>
		</div>
		<div class="col-md-7 text-right">
			<?php echo $thisElemArr['bild1']; ?>
		</div>
	</div>
	<div class="work-rest" style="clear: both;">
		<?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
	</div>
</div>
</div>