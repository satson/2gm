<?php

global $cmsObj;

$curLinkToAnfrage = '#';
if (isset($cmsObj)) {
  $curLinkToAnfrage = $cmsObj->getCurentLinkBySiteIdUser(212);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$mmAllPauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArray($thisElemArr['elemData']['seitID'], 17);



$curLangZimmerLink = '';

if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangZimmerLink = $_POST['VCMS_POST_LANG'].'/';
}

?>



<div style="height:1px;"></div>
<div class="mmPauschalenUebersichtElement mmPauschalenUebersichtElementAll">
  <div class="mmPauschalenUebersichtElementTop">
    <div class="container">
      <div class="siteLeftPos">
        <?php echo $thisElemArr['text2']; ?>
      </div>
      <div class="siteRightPos">
        <div class="mmPauschalenUebersichtElementTopUe"><?php echo $thisElemArr['text1']; ?></div>
        <div style="height:50px;"></div>
      </div>
    </div>
  </div>
  
  <div class="mmPauschalenUebersichtElementBottom">
    <div class="row">
      
      <?php
      foreach ($mmAllPauschaleListArr as $key => $value) {
        // Für Bild Ausgabe
        // ***********************************************************************
        $bildMFile = '';
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
            $bildMFile = 'user_upload/'.$curThumb.$picOnce['bildFile'];
          }
        }
        
        
        // Für Text Ausgabe
        // ***********************************************************************
        $curSelemInhaltArr = json_decode($value['detailElemData']['selemInhalt'], true);
        
        
        
        echo '<div class="col-md-6 col-lg-3 col-sm-6 mmPauschalenUebersichtElementSpalte">';
          echo '<div class="mmPauschalenUebersichtElementPauschale">';
          
            echo '<div class="mmPauschalenUebersichtElementPauschaleBild"><a href="'.$curLangZimmerLink.$value['seitTextUrl'].'"><img src="'.$bildMFile.'" alt="" title="" /></a></div>';
            
            echo '<div class="mmPauschalenUebersichtElementPauschaleTextHolder">';
              echo '<div class="mmPauschalenUebersichtElementPauschaleTextUe">'.strip_tags($curSelemInhaltArr['elemText2']).'</div>';
              echo '<div class="mmPauschalenUebersichtElementPauschaleTextZeitraum">'.strip_tags($curSelemInhaltArr['elemText5']).'</div>';
              //echo '<div class="mmPauschalenUebersichtElementPauschaleTextPreis">'.strip_tags($curSelemInhaltArr['elemText6']).'</div>';
              echo '<div class="mmPauschalenUebersichtElementPauschaleLinkBtnsHolder">';
                echo '<a href="'.$curLinkToAnfrage.'?_curSiteId='.$key.'" class="mmPauschalenUebersichtElementPauschaleTextBtnAnfrage">'.GASSNER_UNVERBINDLICH_ANFRAGEN.'</a>';
                echo '<div></div>';
                echo '<a href="'.$curLangZimmerLink.$value['seitTextUrl'].'" class="mmPauschalenUebersichtElementPauschaleTextBtnMehr">'.GASSNER_MEHR_LESEN.'</a>';
              echo '</div>';
            echo '</div>';
        
          echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
  </div>
</div>