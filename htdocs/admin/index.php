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

 
// Datenbank Connect File einbinden
// *******************************************************
require_once('../inc/db_connect.inc.php');


// CMS Allgemeine Konstanten einbinden
// *******************************************************
require_once('inc/cms.inc.php');

if($_SERVER['HTTPS'] == 'on'){
    
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: http://wildkogel-arena.at/admin/");
    
}



// Abfrage ob User eingelogt ist
// *******************************************************
if (!isset($_SESSION['VCMS_USER_ID']) || empty($_SESSION['VCMS_USER_ID']) 
    || !isset($_SESSION['VCMS_USER_NAME']) || empty($_SESSION['VCMS_USER_NAME']) 
    || !isset($_SESSION['VCMS_HP_ID']) || empty($_SESSION['VCMS_HP_ID'])) {
  require_once('inc/curSite/indexLog.inc.php');
  exit();
}
else if (isset($_SESSION['VCMS_USER_ID']) && !empty($_SESSION['VCMS_USER_ID']) 
         && isset($_SESSION['VCMS_USER_NAME']) && !empty($_SESSION['VCMS_USER_NAME'])
         && isset($_SESSION['VCMS_HP_ID']) && !empty($_SESSION['VCMS_HP_ID'])) {
  header('Location: ../');
  exit();
}
 
?>