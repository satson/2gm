<?php
$curTextBtnM = GASSNER_WENIGER;
$curAuHolderStyle = '';
$curAuBtnClass = '';
if (isset($thisElemArr['elemSettings']['FieldOpenClose']) && $thisElemArr['elemSettings']['FieldOpenClose'] == 'close') {
  $curTextBtnM = GASSNER_MEHR;
  $curAuHolderStyle = ' style="display:none;"';
  $curAuBtnClass = ' isBtnAuszeichnungClose';
}
?>


<div style="height:1px;"></div>
<div class="mmAuszeichnungenHolderElement">
  <div class="container">
    <div class="siteRightPos">
      <div class="mmAuszeichnungenHolderElementHideMoreTextMM" style="display:none;"><?php echo GASSNER_MEHR; ?></div>
      <div class="mmAuszeichnungenHolderElementHideWenigerTextMM" style="display:none;"><?php echo GASSNER_WENIGER; ?></div>
      <div class="mmAuszeichnungenHolderShowHideBtn<?php echo $curAuBtnClass; ?>"><div class="mmAuszeichnungenHolderShowHideBtnText"><?php echo $curTextBtnM; ?></div></div>
      <div class="mmAuszeichnungenHolderElementUe"><?php echo $thisElemArr['text1']; ?></div>
      <div class="mmAuszeichnungenHolderElementHolder"<?php echo $curAuHolderStyle; ?>>
        <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
      </div>
    </div>
  </div>
</div>