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

require_once('../kontaktform.inc.php');



if (isset($_POST['_art']) && $_POST['_art'] == 'sendSysKontaktformularAllDataNowMM') {
  
  if (isset($_POST['_dataArr'][0]['name']) && $_POST['_dataArr'][0]['name'] == 'vCmsKontaktformLiveHolderSysIdHFrm') {
    
    $curKontaktformObj = new cmsKontaktformularSys();
     
    if($_POST['_dataArr'][2]['name'] == 'Vorname' ){
         echo $curKontaktformObj->sendKontaktformularSysNow(1); 
    }else{
        echo $curKontaktformObj->sendKontaktformularSysNow(); 
    }
    
   
    
  }
  else {
    echo false;
  }
  
}
else {
  echo false;
}

?>