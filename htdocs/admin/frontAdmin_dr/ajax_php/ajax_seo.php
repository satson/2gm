<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Prüfen ob User angemeldet ist
// *****************************************************************************
require_once('../../../inc/check.inc.php');
if (!checkIsUserLogedIn()) {
  exit();
}


// Benötigte Files einbinden
// *****************************************************************************
require_once('../../../inc/db_connect.inc.php');
require_once('../../../inc/functionsAll.inc.php');

require_once('../../inc/klassen/seoImport.inc.php');


if (isset($_POST['_art']) && $_POST['_art'] == 'importCurentDescInTextareaSeoSite') {
  
  $seoImpObj = new cmsSeoImport();
  echo $seoImpObj->importCurentDescInTextareaSeoSite($_POST['_curSiteId'], $_POST['VCMS_POST_LANG']);
  
}


if (isset($_POST['_art']) && $_POST['_art'] == 'importCurentMetaTitleInTextboxSeoSite') {
  
  $seoImpObj = new cmsSeoImport();
  echo $seoImpObj->importCurentMetaTitleInTextboxSeoSite($_POST['_curSiteId'], $_POST['VCMS_POST_LANG']);
  
}


if (isset($_POST['_art']) && $_POST['_art'] == 'getCurentMetaDesTextInContentSite') {
  
  $seoImpObj = new cmsSeoImport();
  echo $seoImpObj->importCurentDescInTextareaSeoSiteTextNow($_POST['_curContentText']);
  
}

?>