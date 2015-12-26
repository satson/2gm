<?php
session_start();

// Österreichische Zeitzone definieren
date_default_timezone_set('Europe/Vienna');



// Datenbank Connection File einbinden
// *******************************************************
require_once('../../../inc/db_connect.inc.php');



// Allgemeine CMS Funktionen Klasse einbinden
// *******************************************************
require_once('../../../inc/functionsAll.inc.php');



if (isset($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] == 'en') {
  require_once('../inc/lang/en.inc.php');
}
else {
  require_once('../inc/lang/de.inc.php');
}



require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$mmAllTourenListArr = $mmFunctionsObj->mmGetSiteListDataArray($_POST['_curSiteId'], 19);



$curLangTourenAjaxLink = '';

if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangTourenAjaxLink = $_POST['VCMS_POST_LANG'].'/';
}





echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox mmTourentippsUebersichtMoreBoxShowInhaltBoxWissen">';
  echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenUe">'.GASSNER_WISSENSWERTES.'</div>';
  echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenInhalt">'.$_POST['_wissensWertes'].'</div>';
  echo '<a class="mmTourentippsUebersichtMoreBoxShowInhaltBoxWissenMehrLesen" href="'.$curLangTourenAjaxLink.$_POST['_textUrl'].'">'.GASSNER_MEHR_LESEN.'</a>';
echo '</div>';


foreach ($mmAllTourenListArr as $key => $value) {
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
        
  
  echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBox">';
    echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxBild"><a href="'.$curLangTourenAjaxLink.$value['seitTextUrl'].'"><img src="'.$bildMFile.'" alt="" title="" /></a></div>';
    echo '<div class="mmTourentippsUebersichtMoreBoxShowInhaltBoxText">'.strip_tags($curSelemInhaltArr['elemText2']).'</div>';
    echo '<a class="mmTourentippsUebersichtMoreBoxShowInhaltBoxMehrLesen" href="'.$curLangTourenAjaxLink.$value['seitTextUrl'].'">'.GASSNER_MEHR_LESEN.'</a>';
  echo '</div>';
}

echo '<div class="clearer"></div>';

?>