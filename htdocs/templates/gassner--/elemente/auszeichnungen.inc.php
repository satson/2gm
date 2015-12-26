<?php

$curElemAusZeClass = '';
if (isset($thisElemArr['picGal']['picGalAllImgHiddenArray']) && is_array($thisElemArr['picGal']['picGalAllImgHiddenArray'])) {
  if (count($thisElemArr['picGal']['picGalAllImgHiddenArray']) > 0) {
    $curElemAusZeClass = ' mmAuszeichnungenSpaltenElementOwnElemIsLinkPicGalNow';
  }
}

?>


<div style="height:1px;"></div>
<div class="mmAuszeichnungenSpaltenElementOwnElem">
  <div class="mmAuszeichnungenSpaltenElementBild<?php echo $curElemAusZeClass; ?>"><?php echo $thisElemArr['bild1']; ?></div>
  <div class="mmAuszeichnungenSpaltenElementText<?php echo $curElemAusZeClass; ?>"><?php echo $thisElemArr['text1']; ?></div>
  <?php /*<div class="row">
    <div class="col-md-4 mmAuszeichnungenSpaltenElementSpalte mmAuszeichnungenSpaltenElementSpalteFirst">
      <div class="mmAuszeichnungenSpaltenElementBild"><?php echo $thisElemArr['bild1']; ?></div>
      <div class="mmAuszeichnungenSpaltenElementText"><?php echo $thisElemArr['text1']; ?></div>
    </div>
    <div class="col-md-4 mmAuszeichnungenSpaltenElementSpalte">
      <div class="mmAuszeichnungenSpaltenElementBild"><?php echo $thisElemArr['bild2']; ?></div>
      <div class="mmAuszeichnungenSpaltenElementText"><?php echo $thisElemArr['text2']; ?></div>
    </div>
    <div class="col-md-4 mmAuszeichnungenSpaltenElementSpalte mmAuszeichnungenSpaltenElementSpalteLast">
      <div class="mmAuszeichnungenSpaltenElementBild"><?php echo $thisElemArr['bild3']; ?></div>
      <div class="mmAuszeichnungenSpaltenElementText"><?php echo $thisElemArr['text3']; ?></div>
    </div>
  </div>*/ ?>
  
  
  <?php
  echo '<div style="display:none;" class="mmAuszeichnungenSpaltenElementOwnElemPicGalElems">';
  foreach ($thisElemArr['picGal']['picGalAllImgHiddenArray'] as $valuePic) {
    echo $valuePic;
  }
  echo '</div>';
  ?>
</div>