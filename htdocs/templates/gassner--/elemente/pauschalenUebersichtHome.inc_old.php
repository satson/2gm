<?php

global $cmsObj;

$curLinkToAnfrage = '#';
if (isset($cmsObj)) {
  $curLinkToAnfrage = $cmsObj->getCurentLinkBySiteIdUser(212);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();


$curLangPausLink = '';

if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangPausLink = $_POST['VCMS_POST_LANG'].'/';
}

?>


<div style="height:1px;"></div>
<div class="mmPauschalenUebersichtElement">

  <div class="mmPauschalenUebersichtElementBottom mmPauschalenUebersichtElementBottomWithOwlCarousel">
    <div class="row">
      
      <?php
      //$siteArrZwArrTest = explode(';', '39;41;42;44');
      $siteArrZwArrTest = explode(';', $thisElemArr['elemSettings']['pauschalenList']);
      
      $countElems = 1;
      
      foreach ($siteArrZwArrTest as $value) {
        if (isset($countElems) && $countElems < 8) {
          $mmOncePauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($value, 16);
          if (isset($mmOncePauschaleListArr['detailElemData']['selemInhalt']) && !empty($mmOncePauschaleListArr['detailElemData']['selemInhalt'])) {
            $countElems++;
            
            // Für Bild Ausgabe
            // ***********************************************************************
            $bildMFile = '';
            $picGalIds = '';
            if (isset($mmOncePauschaleListArr['detailElemData']['selemPicGal']) && !empty($mmOncePauschaleListArr['detailElemData']['selemPicGal'])) {
              $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($mmOncePauschaleListArr['detailElemData']['selemPicGal']);
            }
            if (!isset($picGalIds) || empty($picGalIds)) {
              $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromElementPicGalery($mmOncePauschaleListArr['detailElemData']['selemConfig']);
            }
            $picGalPicsArr = explode(';', $picGalIds);
            $count = 0;
            foreach ($picGalPicsArr as $picId) {
              $count++;
              $picOnce = $mmFunctionsObj->getPicOnceDataByIdMM($picId);
              if ($count == 1) {
                $curThumb = '';
                if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picOnce['bildFile'])) {
                  $curThumb = 'thumb_400/';
                }
                $bildMFile = 'user_upload/'.$curThumb.$picOnce['bildFile'];
              }
            }


            // Für Text Ausgabe
            // ***********************************************************************
            $curSelemInhaltArr = json_decode($mmOncePauschaleListArr['detailElemData']['selemInhalt'], true);
            
            
            
            // Für Element Settings
            // ***********************************************************************
            $isElementBergLustPur = '';
            $isElementBergLustPurStyle = '';
            $isMoreTimesElem = '';
            if (isset($mmOncePauschaleListArr['detailElemData']['selemOwnConfig']) && !empty($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'])) {
              $detailElemSettingArrOnce = json_decode($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'], true);
              if (isset($detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur']) && $detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur'] == 'on') {
                $isElementBergLustPurStyle = ' style="background-color:#c9bd9a;"';
                $isElementBergLustPur = 'on';
              }
              if (isset($detailElemSettingArrOnce['vOwnUserSettings']['moreTimes']) && $detailElemSettingArrOnce['vOwnUserSettings']['moreTimes'] == 'on') {
                $isMoreTimesElem = 'on';
              }
            }


            echo '<div class="col-md-6 col-lg-3 col-sm-6 mmPauschalenUebersichtElementSpalte mmPauschalenUebersichtElementSpalteId-1">';
              echo '<div class="mmPauschalenUebersichtElementPauschale"'.$isElementBergLustPurStyle.'>';
              
              

                echo '<div class="mmPauschalenUebersichtElementPauschaleBild"><a href="'.$curLangPausLink.$mmOncePauschaleListArr['seitTextUrl'].'"><img src="'.$bildMFile.'" alt="" title="" /></a></div>';

                   
                  echo '</div>';
                echo '</div>';

              echo '</div>';
            echo '</div>';
          }
        }
      }
      ?>
      
      <?php /*<div class="col-md-3 col-sm-6 mmPauschalenUebersichtElementSpalte">
        <div class="mmPauschalenUebersichtElementPauschale">
          <div class="mmPauschalenUebersichtElementPauschaleBild"><img src="<?php echo VCMS_ABS_PATH_TEMPLATE; ?>img/footerPic.jpg" alt="" title="" /></div>
          <div class="mmPauschalenUebersichtElementPauschaleTextHolder">
            <div class="mmPauschalenUebersichtElementPauschaleTextUe">Lorem ipsum dore korem ipsum dore limb ma kon</div>
            <div class="mmPauschalenUebersichtElementPauschaleTextZeitraum">vom 30.05.-21.06.2015</div>
            <div class="mmPauschalenUebersichtElementPauschaleTextPreis">1 Woche ab € 581,-</div>
            <a href="#" class="mmPauschalenUebersichtElementPauschaleTextBtnAnfrage">Unverbindlich Anfragen</a>
            <div></div>
            <a href="#" class="mmPauschalenUebersichtElementPauschaleTextBtnMehr">Mehr Lesen</a>
          </div>
        </div>
      </div>*/ ?>
      
    </div>
  </div>
</div>