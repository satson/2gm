<?php
session_start();
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Benötigte Files einbinden
// *****************************************************************************
require_once('../../../inc/db_connect.inc.php');
require_once('../../../inc/functionsAll.inc.php');
require_once('../../../inc/check.inc.php');
require_once('../../inc/klassen/dateien.inc.php');

if (!checkIsUserLogedIn()) {
  echo 'fehler';
  exit();
}

$dateiObj = new cmsDateiVerwaltung();


if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
  // Prüfen ob es die erlaubte Dateiendung hat
  if (!$dateiObj->checkIsDateiFileAllow($_FILES)) {
    echo '{"status":"error"}';
    exit();
  }
  
  $curFilenameSave = str_replace(' ', '-', $_FILES['upl']['name']);
  $curFilenameSave = str_replace('_', '-', $curFilenameSave);
  $curFilenameSave = preg_replace('/ä/', 'ae', $curFilenameSave);
  $curFilenameSave = preg_replace('/Ä/', 'ae', $curFilenameSave);
  $curFilenameSave = preg_replace('/ü/', 'ue', $curFilenameSave);
  $curFilenameSave = preg_replace('/Ü/', 'ue', $curFilenameSave);
  $curFilenameSave = preg_replace('/ö/', 'oe', $curFilenameSave);
  $curFilenameSave = preg_replace('/Ö/', 'oe', $curFilenameSave);
  $curFilenameSave = preg_replace('/ß/', 'ss', $curFilenameSave);
  $curFilenameSave = preg_replace('/[^a-zA-Z0-9\-\.]/', '', $curFilenameSave);
  $curFilePath = '../../../user_upload_files/';
  
  $curFilenameSave = strtolower($curFilenameSave);
  
  // Prüfen ob der Dateiname schon existiert sonst Increment hinzufügen
  if ($dateiObj->checkIsDateiFilenameExists($curFilePath, $curFilenameSave)) {
    for ($ii = 1; $ii < 5000; $ii++) {
      $dateiNamArr = explode('.', $curFilenameSave);
      $curFilenameSaveZw = $dateiNamArr[0] . '-' . $ii . '.' . $dateiNamArr[(count($dateiNamArr)-1)];
      if (!$dateiObj->checkIsDateiFilenameExists($curFilePath, $curFilenameSaveZw)) {
        $curFilenameSave = $curFilenameSaveZw;
        break;
      }
    }
  }

  if(move_uploaded_file($_FILES['upl']['tmp_name'], $curFilePath.$curFilenameSave)){
    if ($dateiObj->saveNewUploadDateiInDatabase($curFilenameSave)) {
      echo '{"status":"success"}';
      exit();
    }
  }
}

echo '{"status":"error"}';
exit();