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

require_once('../../inc/klassen/empfehlungsManager.inc.php');



if (isset($_POST['_art']) && !empty($_POST['_art'])) {

  switch ($_POST['_art']) {
    
    // Zeigt das Empfehlungs Manager Admin Window an
    // *************************************************************************
    case 'showEmpfehlungsmanagerAdminWindow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->showEmpfehlungsmanagerAdminWindow();
      
      break;
    
    
    
    // Zeigt den Inhalt vom Empfehlungs Manager Admin Window an (Reload)
    // *************************************************************************
    case 'showEmpfehlungsmanagerAdminWindowCurInhaltReload':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->getEmpfehlungsmanagerAdminWindowInhalt($_POST['_curMenuIdName'], true);
      
      break;
    
    
    
    // Speichert ein neues Geschenk
    // *************************************************************************
    case 'saveEmpfehlungsManagerNewGeschenkOnSendNow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->saveEmpfehlungsManagerNewGeschenkOnSendNow($_POST['_anzahlBuchungen'], $_POST['_geschenkText']);
      
      break;
    
    
    
    // Löscht ein Geschenk
    // *************************************************************************
    case 'delEmpfehlungsmanagerAdminThisGeschenkNow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->delEmpfehlungsmanagerAdminThisGeschenkNow($_POST['_curGeschenkId']);
      
      break;
    
    
    
    // Zeigt ein zum bearbeitentes Geschenk an (Forms)
    // *************************************************************************
    case 'showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($_POST['_curGeschenkId']);
      
      break;
    
    
    
    // Speichert ein bearbeitetes Geschenk
    // *************************************************************************
    case 'saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($_POST['_curGeschenkId'], $_POST['_anzahlBuchungen'], $_POST['_geschenkText']);
      
      break;
    
    
    
    // Zeigt die Empfehler Anfragen bei Reload an
    // *************************************************************************
    case 'showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->getEmpfehlungsmanagerAdminInhaltAnfragenList($_POST['_curEmpfId']);
      
      break;
    
    
    
    // Setzt eine Buchung bei einer Anfrage
    // *************************************************************************
    case 'setTheCurentEmpfehlerAnfrageBooking':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->setTheCurentEmpfehlerAnfrageBooking($_POST['_curAnfrageId']);
      
      break;
    
    
    
    // Löscht eine Buchung bei einer Anfrage
    // *************************************************************************
    case 'delTheCurentEmpfehlerAnfrageBooking':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->delTheCurentEmpfehlerAnfrageBooking($_POST['_curAnfrageId']);
      
      break;
    
    
    
    // Anfrage Html E-Mail anzeigen
    // *************************************************************************
    case 'showTheCurentEmpfehlerAnfrageHtmlMailNow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->showTheCurentEmpfehlerAnfrageHtmlMailNow($_POST['_curAnfrageId']);
      
      break;
    
    
    
    // Speichert die Allgemeinen Einstellungen
    // *************************************************************************
    case 'saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen();
      
      break;
    
    
    
    // Erstellt die neue Mail CSV Datei
    // *************************************************************************
    case 'generateNewEmpfehlungsManagerMailCsvFile':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->generateNewEmpfehlungsManagerMailCsvFile();
      
      break;
    
    
    
    // Zeigt die Empfehler Daten an
    // *************************************************************************
    case 'showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow($_POST['_curEmpfId']);
      
      break;
    
    
    
    // Löscht einen Empfehler
    // *************************************************************************
    case 'delEmpfehlungsmanagerAdminThisEmpfehlerNow':
      $curEmpfehlungClassObj = new cmsEmpfehlungsManagerAdmin();
      
      echo $curEmpfehlungClassObj->delEmpfehlungsmanagerAdminThisEmpfehlerNow($_POST['_curEmpfId']);
      
      break;
    
  }

}

?>