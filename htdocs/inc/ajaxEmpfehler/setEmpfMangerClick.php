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



if (isset($_POST['_art']) && $_POST['_art'] == 'setCurEmpfManagerClickToDaumenHochMM') {
  
  $curEmpfehlerformObj = new cmsEmpfehlerFormularSys();
  echo $curEmpfehlerformObj->setCurEmpfManagerClickToDaumenHochMM();
  
}
else if (isset($_POST['_art']) && $_POST['_art'] == 'setCurEmpfManagerClickToDaumenUntenMM') {
  
  $curEmpfehlerformObj = new cmsEmpfehlerFormularSys();
  echo $curEmpfehlerformObj->setCurEmpfManagerClickToDaumenUntenMM();
  
}
else {
  echo false;
}

?>