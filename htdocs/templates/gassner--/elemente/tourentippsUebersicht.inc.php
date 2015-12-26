<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$mmAllPauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArray($thisElemArr['elemData']['seitID'], 19);

$mmAllFilterkategoriesListArrZw = array();
$countZwTT = 0;
$mmAllSiteTaelerArr = $mmFunctionsObj->getAllSiteIDsArrUnderThisParent(109);
foreach ($mmAllSiteTaelerArr as $key => $value) {
  $mmAllFilterkategoriesListArrZw = array_merge($mmAllFilterkategoriesListArrZw, $mmFunctionsObj->mmGetAllFilterkategoriesListArray($value, 19, true));
  //$mmAllFilterkategoriesListArr = $mmFunctionsObj->mmGetAllFilterkategoriesListArray($value, 19);
  $countZwTT++;
}
$mmAllFilterkategoriesListArr = $mmAllFilterkategoriesListArrZw;
//echo '<pre>'.print_r($mmAllFilterkategoriesListArr, 1).'</pre>';



$curLangTourenLink = '';

if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangTourenLink = $_POST['VCMS_POST_LANG'].'/';
}

?>

<div class="siteFixedFilterButtonForMobile" style="display:none;"><?php echo GASSNER_FILTERN; ?></div>


<div style="height:1px;"></div>
<div class="mmPauschalenUebersichtElement mmPauschalenUebersichtElementAll">
  <div class="mmPauschalenUebersichtElementTopKategorien">
    <div class="mmPauschalenUebersichtElementTopKategorienInner">
      <div class="container">
        <div class="siteLeftPos">
          <?php echo $thisElemArr['text3']; ?>
        </div>
        <div class="siteRightPos">
          <div class="mmPauschalenUebersichtElementTopKategorienUe"><?php echo $thisElemArr['text4']; ?></div>
        </div>
        
        <div class="mmPauschalenUebersichtElementTopKategorienBtnsHolderFilterShowMobile"><?php echo GASSNER_FILTERN; ?></div>
        
        <div class="mmPauschalenUebersichtElementTopKategorienBtnsHolder">
          <div class="mmPauschalenUebersichtElementTopKategorienBtnsHolderCloseMobile"><i class="fa fa-times"></i></div>
          <div class="mmPauschalenUebersichtElementTopKategorienBtnsHolderInnerMob">
            <div class="mmPauschalenUebersichtElementTopKategorienBtn mmTourentippsUebersichtElementTopKategorienBtn mmPauschalenUebersichtElementTopKategorienBtnAlleMM isActiveFilterBtn" data-id="*"><?php echo GASSNER_ALLE; ?></div>
            <?php
            if (isset($mmAllFilterkategoriesListArr) && is_array($mmAllFilterkategoriesListArr) && count($mmAllFilterkategoriesListArr) > 0) {
              foreach ($mmAllFilterkategoriesListArr as $key => $value) {
                echo '<div class="mmPauschalenUebersichtElementTopKategorienBtn mmTourentippsUebersichtElementTopKategorienBtn" data-id="'.str_replace('i', '', $key).'">'.$value.'</div>';
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
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
  
  <div class="mmPauschalenUebersichtElementBottom mmTourentippsUebersichtElementBottom">
    <div class="row">
      
      <?php
      $countMore = 0;
      $countMoreTwo = 0;
      $countMoreFour = 0;
      foreach ($mmAllPauschaleListArr as $key => $value) {
        $countMore++;
        $countMoreTwo++;
        $countMoreFour++;
        
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
        
        
        
        // Für Filter Kategorien Klassen
        // ***********************************************************************
        $classBuild = '';
        $allFilterKats = $mmFunctionsObj->mmGetAllFilterkategoriesListFromOneDetailElementArray($value['detailElemData']['selemID']);
        if (isset($allFilterKats) && !empty($allFilterKats)) {
          $allFilterKatsArr = explode(';', $allFilterKats);
          foreach ($allFilterKatsArr as $valueFilKatI) {
            $classBuild .= ' mmPauschalenUebersichtElementSpalteId-'.$valueFilKatI;
          }
        }
        
        
        
        echo '<div class="col-md-6 col-lg-3 col-sm-6 mmPauschalenUebersichtElementSpalte'.$classBuild.'">';
          echo '<div class="mmPauschalenUebersichtElementPauschale">';
          
            echo '<div class="mmTourentippsUebersichtSchnellInfoWin" style="display:none;">'.strip_tags($curSelemInhaltArr['elemText7']).'</div>';
          
            echo '<div class="mmPauschalenUebersichtElementPauschaleBild"><a href="'.$curLangTourenLink.$value['seitTextUrl'].'"><img src="'.$bildMFile.'" alt="" title="" /></a></div>';
            
            echo '<div class="mmPauschalenUebersichtElementPauschaleTextHolder">';
              echo '<div class="mmPauschalenUebersichtElementPauschaleTextUe">'.strip_tags($curSelemInhaltArr['elemText2']).'</div>';
              echo '<div class="mmPauschalenUebersichtElementPauschaleTextZeitraum">'.strip_tags($curSelemInhaltArr['elemText3']).'</div>';
              
              echo '<a href="JAVASCRIPT:void(0);" class="mmPauschalenUebersichtElementPauschaleTextBtnMehr mmTourenMehrLesenBtn" data-id="'.$key.'" data-count="'.$countMore.'" data-url="'.$value['seitTextUrl'].'">'.GASSNER_MEHR_LESEN.'</a>';
              echo '<a href="JAVASCRIPT:void(0);" class="mmPauschalenUebersichtElementPauschaleTextBtnAnfrage mmTourenSchnellInfoBtn">'.GASSNER_SCHNELL_INFO.'</a>';
            echo '</div>';
        
          echo '</div>';
        echo '</div>';
        
        $countMoreFourAusgabe = '';
        $countMoreTwoAusgabe = '';
        if ($countMoreFour == 4) {
          $countMoreFourAusgabe = ' mmTourentippsUebersichtMoreBoxShowCount4Elem';
          $countMoreFour = 0;
        }
        if ($countMoreTwo == 2) {
          $countMoreTwoAusgabe = ' mmTourentippsUebersichtMoreBoxShowCount2Elem';
          $countMoreTwo = 0;
        }
        
        echo '<div id="mmTourentippsUebersichtMoreCount'.$countMore.'" class="mmTourentippsUebersichtMoreBoxShow'.$countMoreFourAusgabe.$countMoreTwoAusgabe.'" style="display:none;">';
          echo '<div class="mmTourentippsUebersichtMoreBoxShowUe">'.GASSNER_WAEHLEN_SIE_FOLGENDE_TOUREN.':</div>';
          echo '<div class="mmTourentippsUebersichtMoreBoxShowInhalt">';
            /*echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox mmTourentippsUebersichtMoreBoxShowInhaltBoxWissen">';
              echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenUe">Wissenswertes</div>';
              echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenInhalt">Wissenswertes</div>';
              echo '<a class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenMehrLesen" href="'.$value['seitTextUrl'].'">Mehr lesen</a>';
            echo '</div>';
            
            echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox"></div>';
            echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox"></div>';
            echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox"></div>';
            echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox"></div>';*/
          echo '</div>';
        echo '</div>';
      }
      ?>
    </div>
  </div>
  
  
  
  
  <div class="mmPauschalenUebersichtElementBottom mmTourentippsUebersichtElementBottomAjax" style="display:none;">
    <div class="row">
      
    </div>
  </div>
  
</div>