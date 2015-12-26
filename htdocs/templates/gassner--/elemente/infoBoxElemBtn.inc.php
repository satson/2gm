<?php

$curElemInfoZeClass = '';
if (isset($thisElemArr['picGal']['picGalAllImgHiddenArray']) && is_array($thisElemArr['picGal']['picGalAllImgHiddenArray'])) {
  if (count($thisElemArr['picGal']['picGalAllImgHiddenArray']) > 0) {
    $curElemInfoZeClass = ' mmInfoBoxBtnElementOwnElemIsLinkPicGalNow';
  }
}

?>


<div style="height:1px;"></div>
<div class="mmInfoBoxBtnElement">
  <div class="mmInfoBoxBtnElementText<?php echo $curElemInfoZeClass; ?>"><?php echo $thisElemArr['text1']; ?></div>
  
  <?php
  echo '<div style="display:none;" class="mmInfoBoxBtnElementOwnElemPicGalElems">';
  foreach ($thisElemArr['picGal']['picGalAllImgHiddenArray'] as $valuePic) {
    echo $valuePic;
  }
  echo '</div>';
  ?>
</div>