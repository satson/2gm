<?php

global $cmsObj;
global $cms;

$curPic2 = '';
if (isset($thisElemArr['picGal']['picGalAllImgAusgabeArray'][1]) && !empty($thisElemArr['picGal']['picGalAllImgAusgabeArray'][1])) {
  $curPic2 = $thisElemArr['picGal']['picGalAllImgAusgabeArray'][1];
}

?>


<div style="height:1px;"></div>
<div class="mmPauschaleDetailElement">
  <div class="mmPauschaleDetailElementBilderHead">
    <div class="mmPauschaleDetailElementBilderHeadBild1" style="display:none;">
      <?php echo $thisElemArr['picGal']['picGalFirstImg']; ?>
    </div>
    <?php
    if (isset($curPic2) && !empty($curPic2)) {
      echo '<div class="mmPauschaleDetailElementBilderHeadBild2" style="display:none;">'.$curPic2.'</div>';
    }
    ?>
    <div class="container">
      <div class="mmPauschaleDetailElementTopUeOnlyDetailHeader"><?php echo $thisElemArr['text1']; ?></div>
      <div class="mmPauschaleDetailElementPicIco"></div>
      <div class="mmPauschaleDetailElementRightBoxInfo">
        <div class="mmPauschaleDetailElementRightBoxInfoBergLust"><?php echo GASSNER_BERG_LUST_PUR_DETAIL; ?></div><br />
        <div class="mmPauschaleDetailElementRightBoxInfoUri">hotel-gassner.at</div>
      </div>
      <div class="clearer"></div>
    </div>
  </div>
  
  <?php
  if (isset($cmsObj)) {
    echo '<div class="container breadcrumbHolderElemContainer breadcrumbHolderElemContainerDetail">';
    echo '<div class="breadcrumbHolderElem">'.$cmsObj->getSiteBreadcrumbsString('&nbsp;&raquo;&nbsp;').'<div class="clearer"></div></div>';
    echo '</div>';
  }
  ?>
</div>


<?php echo $thisElemArr['picGal']['picGalAllImgHidden']; ?>