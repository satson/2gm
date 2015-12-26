<?php

global $cms;

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$mmAllZimmerListArr = $mmFunctionsObj->mmGetSiteListDataArray($thisElemArr['elemData']['seitID'], 19);



$curLangTourenSlideLink = '';

if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangTourenSlideLink = $_POST['VCMS_POST_LANG'].'/';
}


if (!checkIsUserLogedIn()) {
  
}

?>


<div style="height:1px;"></div>
<div class="mmBildTextHolderSliderElem">
  <div class="container">
    <div class="siteRightPos">
      <?php
      if (!checkIsUserLogedIn()) {
        $curTextOut = $thisElemArr['text1'];
        
        if (isset($cms['cms_siteParent']) && $cms['cms_siteParent'] == '109') {
          $curTextOut = str_replace('weitere ', '', $curTextOut);
          $curTextOut = str_replace('Weitere ', '', $curTextOut);
        }
        
        echo '<div class="mmBildTextHolderSliderElemUe mmBildTextHolderSliderElemUeTourentippMM">'.$curTextOut.'</div>';
      }
      else {
        echo '<div class="mmBildTextHolderSliderElemUe mmBildTextHolderSliderElemUeTourentippMM">'.$thisElemArr['text1'].'</div>';
      }
      ?>
    </div>
  </div>
  <div class="mmBildTextHolderSliderElemSlides">
    <div class="vContentElemDD">
    <?php
    $countGal = 0;
    foreach ($mmAllZimmerListArr as $key => $value) {
      $countGal++;
      
      // Für Bild Ausgabe
      // ***********************************************************************
      $bildM = '';
      $picGalIds = '';
      if (isset($value['detailElemData']['selemPicGal']) && !empty($value['detailElemData']['selemPicGal'])) {
        $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($value['detailElemData']['selemPicGal']);
      }
      if (!isset($picGalIds) || empty($picGalIds)) {
        $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromElementPicGalery($value['detailElemData']['selemConfig']);
      }
      $picGalPicsArr = explode(';', $picGalIds);
      $count = 0;
      foreach ($picGalPicsArr as $picId) {
        $count++;
        $picOnce = $mmFunctionsObj->getPicOnceDataByIdMM($picId);
        if ($count == 1) {
          $curThumb = '';
          if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picOnce['bildFile'])) {
            $curThumb = 'thumb_800/';
          }
          $bildM = '<div class="mmBildTextSliderElemOnceBild"><img src="user_upload/'.$curThumb.$picOnce['bildFile'].'" alt="" title="" /></div>';
          $linkElem = '<a href="'.$curLangTourenSlideLink.$value['seitTextUrl'].'">';
        }
      }
      
      echo $linkElem.'<div class="mmBildTextSliderElemOnce">';
      
      echo $bildM;
      
      echo '<div class="mmBildTextSliderElemOnceCurShowIco mmBildTextSliderElemOnceCurLinkIco"></div>';
      
      
      // Für Text Ausgabe
      // ***********************************************************************
      $curSelemInhaltArr = json_decode($value['detailElemData']['selemInhalt'], true);
      echo '<div class="mmBildTextSliderElemOnceText"><div class="vFrontOwnElemTextInner">'.$curSelemInhaltArr['elemText2'].'</div></div>';
      
      echo '</div></a>';
    }
    ?>
    </div>
    <div class="clearer"></div>
  </div>
</div>