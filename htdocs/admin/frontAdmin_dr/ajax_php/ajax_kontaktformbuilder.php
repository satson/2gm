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

require_once('../../inc/klassen/kontaktFormBuilder.inc.php');



if (isset($_POST['_art']) && !empty($_POST['_art'])) {

  switch ($_POST['_art']) {
    
    // Zeigt das Kontaktformular Builder Admin Window an
    // *************************************************************************
    case 'showKontaktFormBuilderAdminWindow':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->showKontaktFormBuilderAdminWindow();
      
      break;
    
    
    
    // Zeigt das Kontaktformular Builder Admin Window Neu an
    // *************************************************************************
    case 'showKontaktFormBuilderAdminWindowNewForm':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->showKontaktFormBuilderAdminWindowNewForm();
      
      break;
    
    
    
    // Speichert ein neues Kontaktformular
    // *************************************************************************
    case 'saveNewKontaktformularFromBuilderNow':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->saveNewKontaktformularFromBuilderNow($_POST['_curName'], $_POST['_curFormJson']);
      
      break;
    
    
    
    // Zeigt das Kontaktformular Builder Admin Window Bearbeiten an
    // *************************************************************************
    case 'showKontaktFormBuilderAdminWindowBearForm':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->showKontaktFormBuilderAdminWindowBearForm($_POST['_curFormId']);
      
      break;
    
    
    
    // Speichert ein bearbeitetes Kontaktformular
    // *************************************************************************
    case 'saveBearKontaktformularFromBuilderNow':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->saveBearKontaktformularFromBuilderNow($_POST['_curBearFormId'], $_POST['_curName'], $_POST['_curFormJson']);
      
      break;
    
    
    
    // Löscht ein Kontaktformular
    // *************************************************************************
    case 'delThisKontaktformularOnAdminNow':
      $curKontaktFormBuilderClassObj = new cmsKontaktFormBuilderAdmin();
      
      echo $curKontaktFormBuilderClassObj->delThisKontaktformularOnAdminNow($_POST['_curDelFormId']);
      
      break;
    
  }

}

?>