<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsModuleExtensions extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Allgemeine Funktionen für Modul Installation & Deinstallation
  // ***************************************************************************
  
  public function installCurentCmsModuleNow($curModulName) {
    switch ($curModulName) {
      
      case 'miniShopModul':
        return $this->installTheMiniShopModuleNow();
        break;
      
      
      case 'responsivWebModul':
        return $this->installTheResponsivWebModuleNow($curModulName);
        break;
      
      
      case 'empfehlungManagerModul':
        return $this->installTheEmpfehlungManagerModuleNow($curModulName);
        break;
      
      
      case 'kontaktFormularBuilderModul':
        return $this->installTheKontaktFormularBuilderModulNow($curModulName);
        break;
      
      
      case 'filterSystemModul':
        return $this->installTheFilterSystemModulNow($curModulName);
        break;
    
     
     case 'OrderSystemModul':
      
        return $this->installTheOrderSystemModulNow($curModulName);
        break;
      
    }
  }
  
  
  
  public function deInstallCurentCmsModuleNow($curModulName) {
    switch ($curModulName) {
      
      case 'miniShopModul':
        return $this->deInstallTheMiniShopModuleNow();
        break;
      
      
      case 'responsivWebModul':
        return $this->deInstallTheResponsivWebModuleNow($curModulName);
        break;
      
      
      case 'empfehlungManagerModul':
        return $this->deInstallTheEmpfehlungManagerModuleNow($curModulName);
        break;
      
      
      case 'kontaktFormularBuilderModul':
        return $this->deInstallTheKontaktFormularBuilderModulNow($curModulName);
        break;
      
      
      case 'filterSystemModul':
        return $this->deInstallTheFilterSystemModulNow($curModulName);
        break;
    
      case 'OrderSystemModul':
        return $this->deInstallTheOrderSystemModulNow($curModulName);
        break;
      
    }
  }
  
  // ***************************************************************************
  // ENDE - Allgemeine Funktionen für Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Mini Shop Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheMiniShopModuleNow() {
    $sqlText = 'UPDATE vhomepage SET hpShopAktiv = 1 WHERE hpID = 1';
    $this->sendMailToGetmoreInstallNewModule('Mini Shop Modul');
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function deInstallTheMiniShopModuleNow() {
    $sqlText = 'UPDATE vhomepage SET hpShopAktiv = 2 WHERE hpID = 1';
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Mini Shop Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Responsiv Web Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheResponsivWebModuleNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    $newJson = json_encode($allConfigsArr);
    $this->sendMailToGetmoreInstallNewModule('Responsiv Web Modul');
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  private function deInstallTheResponsivWebModuleNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    $newJson = json_encode($allConfigsArr);
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  // ***************************************************************************
  // ENDE - Responsiv Web Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Empfehlungs Manager Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheEmpfehlungManagerModuleNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    $newJson = json_encode($allConfigsArr);
    $this->installTheEmpfehlungManagerModuleDatabase();
    $this->sendMailToGetmoreInstallNewModule('Empfehlungs Manager Modul');
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  private function installTheEmpfehlungManagerModuleDatabase() {
    $path = $_SERVER['DOCUMENT_ROOT'].'/admin/plugin_sql/';
    $sql_filename = 'empfehlungsmanager.sql';
    $sql_contentsZw = file_get_contents($path.$sql_filename);
    $sql_contents = explode(";", $sql_contentsZw);
    
    foreach($sql_contents as $query){
      $result = mysql_query($query); // or die(mysql_error());
    }
    
    if ($this->systemElementByIdNotExists(7)) {
      $sqlText = 'INSERT INTO velement (elemHidden, elemArt, elemName, elemPosition, elemPic, elemEigen) VALUES (2, 7, "Empfehler Formular", 7, "empfehler.png", 1)';
      $this->dbAbfragen($sqlText);
    }
    if ($this->systemElementByIdNotExists(8)) {
      $sqlText = 'INSERT INTO velement (elemHidden, elemArt, elemName, elemPosition, elemPic, elemEigen) VALUES (2, 8, "Empfehler Geschenke Info Text", 8, "empfehler_geschenke.png", 1)';
      $this->dbAbfragen($sqlText);
    }
    if ($this->checkIsEmpfehlungsManagerDatabaseNotExists()) {
      $sqlText2 = 'INSERT INTO vempfehlungsmanager (emID, emMail) VALUES (1, "")';
      $this->dbAbfragen($sqlText2);
    }
  }
  
  
  
  private function deInstallTheEmpfehlungManagerModuleNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    $newJson = json_encode($allConfigsArr);
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  // ***************************************************************************
  // ENDE - Empfehlungs Manager Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Kontakt Formular Builder Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheKontaktFormularBuilderModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    $newJson = json_encode($allConfigsArr);
    $this->installTheKontaktFormularBuilderModulDatabase();
    $this->sendMailToGetmoreInstallNewModule('Kontaktformular Builder Modul');
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  private function installTheKontaktFormularBuilderModulDatabase() {
    $path = $_SERVER['DOCUMENT_ROOT'].'/admin/plugin_sql/';
    $sql_filename = 'kontaktformularbuilder.sql';
    $sql_contentsZw = file_get_contents($path.$sql_filename);
    $sql_contents = explode(";", $sql_contentsZw);
    
    foreach($sql_contents as $query){
      $result = mysql_query($query); // or die(mysql_error());
    }
    
    if ($this->systemElementByIdNotExists(6)) {
      $sqlText = 'INSERT INTO velement (elemHidden, elemArt, elemName, elemPosition, elemPic, elemEigen) VALUES (2, 6, "Kontaktformular", 6, "kontaktform.png", 1)';
      $this->dbAbfragen($sqlText);
    }
  }
  
  
  
  private function deInstallTheKontaktFormularBuilderModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    $newJson = json_encode($allConfigsArr);
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  // ***************************************************************************
  // ENDE - Kontakt Formular Builder Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Filtersystem Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheFilterSystemModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    $newJson = json_encode($allConfigsArr);
    $this->installTheFilterSystemModulDatabase();
    $this->sendMailToGetmoreInstallNewModule('Filtersystem Modul');
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  private function installTheFilterSystemModulDatabase() {
    $path = $_SERVER['DOCUMENT_ROOT'].'/admin/plugin_sql/';
    $sql_filename = 'filtersystem.sql';
    $sql_contentsZw = file_get_contents($path.$sql_filename);
    $sql_contents = explode(";", $sql_contentsZw);
    
    foreach($sql_contents as $query){
      $result = mysql_query($query);
    }
    
    /*if ($this->systemElementByIdNotExists(6)) {
      $sqlText = 'INSERT INTO velement (elemHidden, elemArt, elemName, elemPosition, elemPic, elemEigen) VALUES (2, 6, "Kontaktformular", 6, "kontaktform.png", 1)';
      $this->dbAbfragen($sqlText);
    }*/
  }
  
  
  
  private function deInstallTheFilterSystemModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    $newJson = json_encode($allConfigsArr);
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  // ***************************************************************************
  // ENDE - Filtersystem Modul Installation & Deinstallation
  // ***************************************************************************
  
  
  
   // ***************************************************************************
  // ANFANG - Filtersystem Modul Installation & Deinstallation
  // ***************************************************************************
  
  private function installTheOrderSystemModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    
 
    
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 1;
    }
    $newJson = json_encode($allConfigsArr);
    //$this->sendMailToGetmoreInstallNewModule('Ordersystem Modul');
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  private function installTheOrderSystemModulDatabase() {
    //$path = $_SERVER['DOCUMENT_ROOT'].'/admin/plugin_sql/';
    //$sql_filename = 'filtersystem.sql';
    //$sql_contentsZw = file_get_contents($path.$sql_filename);
   // $sql_contents = explode(";", $sql_contentsZw);
    
   // foreach($sql_contents as $query){
      //$result = mysql_query($query);
    //}
    
    /*if ($this->systemElementByIdNotExists(6)) {
      $sqlText = 'INSERT INTO velement (elemHidden, elemArt, elemName, elemPosition, elemPic, elemEigen) VALUES (2, 6, "Kontaktformular", 6, "kontaktform.png", 1)';
      $this->dbAbfragen($sqlText);
    }*/
  }
  
  
  
  private function deInstallTheOrderSystemModulNow($curModulName) {
    $allConfigsArr = $this->getAllHomepageModulConfigsArr();
    if (isset($allConfigsArr[$curModulName])) {
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    else {
      $allConfigsArr[$curModulName] = array();
      $allConfigsArr[$curModulName]['install'] = 2;
    }
    $newJson = json_encode($allConfigsArr);
    return $this->updateHomepageModulConfigsArrJson($newJson);
  }
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Hilfsfunktionen
  // ***************************************************************************
  
  private function getAllHomepageModulConfigsArr() {
    $return = array();
    
    $sqlText = 'SELECT hpModulConfig FROM vhomepage WHERE hpID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['hpModulConfig']) && !empty($row['hpModulConfig'])) {
        $return = json_decode($row['hpModulConfig'], true);
      }
    }
    
    return $return;
  }
  
  
  
  private function updateHomepageModulConfigsArrJson($curJsonString) {
    $sqlText = 'UPDATE vhomepage SET hpModulConfig = "'.$this->dbDecode($curJsonString).'" WHERE hpID = 1';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function systemElementByIdNotExists($sysElemId) {
    $sqlText = 'SELECT elemID FROM velement WHERE elemArt = "' . $this->dbDecode($sysElemId) . '" && elemEigen = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    if ($sqlErgCount < 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function checkIsEmpfehlungsManagerDatabaseNotExists() {
    $sqlText = 'SELECT emID FROM vempfehlungsmanager WHERE emID = "1" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    if ($sqlErgCount < 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  // ***************************************************************************
  // ENDE - Hilfsfunktionen
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - E-Mail senden
  // ***************************************************************************
  
  private function sendMailToGetmoreInstallNewModule($modulName) {
    $curWebUrl = $this->getHrefPathOnlyMailGetmoreUriAusgabe();
    
    $mailText = 'Es wurde eine neue Erweiterung installiert:<br />';
    $mailText .= '--------------------------------------------------------------<br /><br />';
    
    $mailText .= '<table width="600" border="0" cellspacing="0" cellpadding="5">';
    $mailText .= '<tr>';
    $mailText .= '<td valign="top" width="140">Erweiterung:</td><td>' . $modulName . '</td>';
    $mailText .= '</tr>';
    $mailText .= '<tr>';
    $mailText .= '<td valign="top" width="140">Homepage:</td><td>' . $curWebUrl . '</td>';
    $mailText .= '</tr>';
    $mailText .= '</table>';
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: 2getmore CMS <noreply@2getmore.at>" . "\n";
    $mailSubject = "Neue Erweiterung wurde installiert";
    $mailTo = "office@2getmore.at";
    
    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
  }
  
  
  
  private function getHrefPathOnlyMailGetmoreUriAusgabe() {
    $basePath = str_replace('index.php', '', $_SERVER['SERVER_NAME']);
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }

    return $setBaseHTTP.$basePath;
  }
  
  // ***************************************************************************
  // ENDE - E-Mail senden
  // ***************************************************************************
  
}

?>