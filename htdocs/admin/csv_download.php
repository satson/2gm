<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *********************************************************************/



// Benötigte Files einbinden
// *****************************************************************************
require_once('../inc/db_connect.inc.php');
require_once('../inc/functionsAll.inc.php');
require_once('../inc/check.inc.php');

if (!checkIsUserLogedIn()) {
  exit();
}



if (isset($_GET['file']) && !empty($_GET['file'])) {
  $dateiname = $_GET['file'];
  
  header("Content-type: text/csv"); 
  header("Content-Disposition: attachment; filename=\"$dateiname\"");
  header("Content-Length: ".filesize('csv/'.$dateiname)); 
  readfile('csv/'.$dateiname);
}

?>