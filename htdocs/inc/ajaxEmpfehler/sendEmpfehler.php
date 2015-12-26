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


require_once('../db_connect.inc.php');
require_once('../functionsAll.inc.php');

require_once('../empfehler.inc.php');



if (isset($_POST['_art']) && $_POST['_art'] == 'sendSysEmpfehlerFormularAllDataNowMM') {
  
  if ((isset($_POST['_dataVorname']) && !empty($_POST['_dataVorname'])) && (isset($_POST['_dataNachname']) && !empty($_POST['_dataNachname'])) && (isset($_POST['_dataMail']) && !empty($_POST['_dataMail']))) {
    
    $curEmpfehlerformObj = new cmsEmpfehlerFormularSys();
    echo $curEmpfehlerformObj->sendSysEmpfehlerFormularAllDataNowMM();
    
  }
  else {
    echo false;
  }
  
}
else {
  echo false;
}

?>