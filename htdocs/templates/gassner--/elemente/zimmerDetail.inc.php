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
      <div class="mmPauschaleDetailElementTopUe"><?php echo GASSNER_ZIMMER_DETAIL; ?></div>
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
  
  
  <div class="container mmPauschaleDetailElementTextHolder">
    <div class="siteLeftPos">
      <?php echo $thisElemArr['text1']; ?>
    </div>
    <div class="siteRightPos">
      <?php
      if (checkIsUserLogedIn()) {
        echo '<div style="background-color:#333; color:#FFF; padding:10px; width:330px;">';
          echo '<div style="font-weight:bold;">Textfeld für Listenansicht:</div>';
          
          echo '<div style="height:20px;"></div>';
          
          echo '<div>'.$thisElemArr['text5'].'</div>';
        echo '</div>';
      }
      ?>
      
      <h1><?php echo $thisElemArr['text2']; ?></h1>
      <h2><?php echo $thisElemArr['text3']; ?></h2>
      <div class="mmPauschaleDetailElementTextContent"><?php echo $thisElemArr['text4']; ?></div>
      <div class="mmPauschaleDetailElementDropPlace"><?php echo $thisElemObj->setOwnElementDragDropHolder(); ?></div>
    </div>
  </div>
</div>



<?php echo $thisElemArr['picGal']['picGalAllImgHidden']; ?>