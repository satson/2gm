<?php
if (isset($_GET['file']) && !empty($_GET['file'])) {
  //echo $_GET['file'];
  $dateiname = '../' . $_GET['file'];
  
  
  // Prüfen ob Datei erlaubt ist zum Downloaden
  // ***************************************************************************
  $allowed = array('png', 'jpg', 'gif', 'jpeg');
  // Dateiendung erhalten
  $extension = pathinfo($dateiname, PATHINFO_EXTENSION);

  if(!in_array(strtolower($extension), $allowed)){
    exit();
  }
  // ***************************************************************************
  
  $dateiArr = explode('/', $dateiname);
  $arrCount = count($dateiArr);
  $dateinameOnly = $dateiArr[$arrCount-1];
  
  $dateiendung = strrchr($dateiname, "."); 
  $dateiendung = substr($dateiendung, 1);
  
  header("Content-type: application/$dateiendung"); 
  header("Content-Disposition: attachment; filename=\"$dateinameOnly\"");
  header("Content-Length: ".filesize($dateiname)); 
  readfile($dateiname);
}
?>