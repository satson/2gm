<?php
global $isMobileCheck;

$showAll = true;
if (isset($thisElemArr['elemSettings']['FieldWithContainer'])) {
  if ($thisElemArr['elemSettings']['FieldWithContainer'] == 'ohneContainer') {
    $showAll = false;
  }
}


$curTextBtnM = GASSNER_WENIGER;
$curAuHolderStyle = '';
$curAuBtnClass = '';
if (isset($thisElemArr['elemSettings']['FieldOpenClose']) && $thisElemArr['elemSettings']['FieldOpenClose'] == 'close') {
  $curTextBtnM = GASSNER_MEHR;
  $curAuHolderStyle = ' style="display:none;"';
  $curAuBtnClass = ' isBtnInfosMMClose';
}
if (isset($thisElemArr['elemSettings']['FieldOpenCloseMobile']) && $thisElemArr['elemSettings']['FieldOpenCloseMobile'] == 'close' && $isMobileCheck == true) {
  $curTextBtnM = GASSNER_MEHR;
  $curAuHolderStyle = ' style="display:none;"';
  $curAuBtnClass = ' isBtnInfosMMClose';
}
?>


<div style="height:1px;"></div>
<div class="mmSchnellAnfrageElement mmInfoBoxHolderElement mmInfoBoxHolderElementRed">
  <div class="mmSchnellAnfrageElementInner mmInfoBoxHolderElementInner">
    <?php if (isset($showAll) && $showAll == true) { ?>
    <div class="container">
      <div class="siteLeftPos">
        <?php echo $thisElemArr['text1']; ?>
      </div>
    <?php } ?>
      <div class="siteRightPos">
        <div class="mmInfoBoxHolderElementHideMoreTextMM" style="display:none;"><?php echo GASSNER_MEHR; ?></div>
        <div class="mmInfoBoxHolderElementHideWenigerTextMM" style="display:none;"><?php echo GASSNER_WENIGER; ?></div>
        <div class="mmSchnellAnfrageElementIco mmInfoBoxHolderElementIco"><?php echo $thisElemArr['bild1']; ?></div>
        <div class="mmSchnellAnfrageElementUe mmInfoBoxHolderElementUe"><?php echo $thisElemArr['text2']; ?></div>
      </div>
      <div class="mmSchnellAnfrageElementForms mmInfoBoxHolderElementPlaceHolderElems"<?php echo $curAuHolderStyle; ?>>
        <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
      </div>
      
      <div class="mmInfoBoxHolderElementRedTextBottom"><?php echo $thisElemArr['text3']; ?></div>
      
    <?php if (isset($showAll) && $showAll == true) { ?>
    </div>
    <?php } ?>
  </div>
</div>