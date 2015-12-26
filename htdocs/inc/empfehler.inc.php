<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsEmpfehlerFormularSys extends funktionsSammlung {
  
  public function sendSysEmpfehlerFormularAllDataNowMM() {
    
    $allData = $this->getAllDataSettingsFromEmpfehlungsManager();
    $allOtherSettings = $allData['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    $curTextAusgabe1 = 'GRATULIERE, Ihr Link wurde generiert';
    $curTextAusgabe2 = 'Empfehlen Sie uns jetzt weiter';
    $curMailTextEmpfehlerDomainGenriert = '';
    
    if (isset($allOtherSettingsArr['ownGratuliereText']) && !empty($allOtherSettingsArr['ownGratuliereText'])) {
      $curTextAusgabe1 = $allOtherSettingsArr['ownGratuliereText'];
    }
    if (isset($allOtherSettingsArr['ownEmpfehlenWeiterText']) && !empty($allOtherSettingsArr['ownEmpfehlenWeiterText'])) {
      $curTextAusgabe2 = $allOtherSettingsArr['ownEmpfehlenWeiterText'];
    }
    if (isset($allOtherSettingsArr['ownMailTextDomainGeneriert']) && !empty($allOtherSettingsArr['ownMailTextDomainGeneriert'])) {
      $curMailTextEmpfehlerDomainGenriert = $allOtherSettingsArr['ownMailTextDomainGeneriert'];
    }
    
    
    
    $curEmpfehlerUrl = $this->buildTheCurentEmpfehlerUrl($_POST['_dataVorname'], $_POST['_dataNachname']);
    $curDateNow = date('Y-m-d H:i:s');
    
    $sqlText = 'INSERT INTO vempfehler (empfUrl, empfCreateDate, empfVorname, empfNachname, empfStrasse, empfPlz, empfOrt, empfMail, empfFbId, empfLinkClicks) VALUES ("'.$this->dbDecode($curEmpfehlerUrl).'", "'.$this->dbDecode($curDateNow).'", "'.$this->dbDecode($_POST['_dataVorname']).'", "'.$this->dbDecode($_POST['_dataNachname']).'", "'.$this->dbDecode($_POST['_dataStrasse']).'", "'.$this->dbDecode($_POST['_dataPlz']).'", "'.$this->dbDecode($_POST['_dataOrt']).'", "'.$this->dbDecode($_POST['_dataMail']).'", "'.$this->dbDecode($_POST['_dataFbId']).'", 0)';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if ($sqlErg == true) {
      $curCompleteUri = $this->getHrefPathOnlyEmpfehlerUriAusgabe().'/'.$curEmpfehlerUrl;
      $curCompleteUriAusgabe = str_replace('http://', '', $curCompleteUri);
      $curCompleteUriAusgabe = str_replace('https://', '', $curCompleteUriAusgabe);
      
      $this->sendMailToHotelNewEmpfehlerGenerate($_POST['_dataVorname'], $_POST['_dataNachname'], $_POST['_dataMail'], $curCompleteUri);
      $this->sendMailToEmpfehlerNewDomainGenerate($allData, $_POST['_dataMail'], $curCompleteUri, $curMailTextEmpfehlerDomainGenriert);
      
      $return = '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowInfoHolder">';
        $return .= '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowInfoText3">'.$curTextAusgabe2.':</div>';
      $return .= '</div>';
      
      $return .= '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowShareBtnsHolder">';
      $return .= '<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_55 a2a_default_style">
<a class="a2a_button_email"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_dd" href="https://www.addtoany.com/share_save?linkurl='.$curCompleteUri.'&amp;linkname="></a>
</div>
<script type="text/javascript">
var a2a_config = a2a_config || {};
a2a_config.linkurl = "'.$curCompleteUri.'";
a2a_config.locale = "de";
</script>
<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->';
      $return .= '</div>';
      
      $return .= '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowInfoHolder">';
        $return .= '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowInfoText1">'.$curTextAusgabe1.':</div>';
        $return .= '<div class="vCmsEmpfehlerFormLiveOkAusgabeShowInfoText2"><a href="'.$curCompleteUri.'" target="_blank">'.$curCompleteUriAusgabe.'</a></div>';
      $return .= '</div>';
      
      return $return;
    }
  }
  
  
  
  private function buildTheCurentEmpfehlerUrl($vorname, $nachname) {
    $vorname = mb_strtolower($vorname, 'UTF-8');
    $vorname = preg_replace("/ä/", 'ae', $vorname);
    $vorname = preg_replace("/Ä/", 'ae', $vorname);
    $vorname = preg_replace("/ü/", 'ue', $vorname);
    $vorname = preg_replace("/Ü/", 'ue', $vorname);
    $vorname = preg_replace("/ö/", 'oe', $vorname);
    $vorname = preg_replace("/Ö/", 'oe', $vorname);
    $vorname = preg_replace("/ß/", 'ss', $vorname);
    $vorname = preg_replace("/\s/", '', $vorname);
    $vorname = preg_replace("/[^a-zA-Z0-9]/", '', $vorname);
    
    $nachname = mb_strtolower($nachname, 'UTF-8');
    $nachname = preg_replace("/ä/", 'ae', $nachname);
    $nachname = preg_replace("/Ä/", 'ae', $nachname);
    $nachname = preg_replace("/ü/", 'ue', $nachname);
    $nachname = preg_replace("/Ü/", 'ue', $nachname);
    $nachname = preg_replace("/ö/", 'oe', $nachname);
    $nachname = preg_replace("/Ö/", 'oe', $nachname);
    $nachname = preg_replace("/ß/", 'ss', $nachname);
    $nachname = preg_replace("/\s/", '', $nachname);
    $nachname = preg_replace("/[^a-zA-Z0-9]/", '', $nachname);
    
    $curBuildStringZw = $vorname.'.'.$nachname;
    
    $curBuildString = $this->checkIsEmpfehlerTextUrlIsExists($curBuildStringZw);
    
    return $curBuildString;
  }
  
  
  
  private function checkIsEmpfehlerTextUrlIsExists($curBuildStringZw, $count = 1) {
    $sqlText = 'SELECT empfID FROM vempfehler WHERE empfUrl = "'.$this->dbDecode($curBuildStringZw).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if (isset($sqlErgCount) && $sqlErgCount > 0) {
      $curBuildStringZw = $curBuildStringZw.$count;
      $count++;
      return $this->checkIsEmpfehlerTextUrlIsExists($curBuildStringZw, $count);
    }
    else {
      return $curBuildStringZw;
    }
  }
  
  
  
  private function getHrefPathOnlyEmpfehlerUriAusgabe() {
    $basePath = str_replace('index.php', '', $_SERVER['SERVER_NAME']);
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }

    return $setBaseHTTP.$basePath;
  }
  
  
  
  private function sendMailToHotelNewEmpfehlerGenerate($dataVorname, $dataNachname, $dataMail, $curCompleteUri) {
    $empfMangDataArr = $this->getAllDataSettingsFromEmpfehlungsManager();
    
    $mailText = 'Es wurde ein neuer Empfehler erstellt:<br />';
    $mailText .= '--------------------------------------------------------------<br /><br />';
    
    $mailText .= '<table width="600" border="0" cellspacing="0" cellpadding="5">';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="140">Vorname:</td><td>' . $dataVorname . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="140">Nachname:</td><td>' . $dataNachname . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="140">E-Mail Adresse:</td><td>' . $dataMail . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="140">Url:</td><td>' . $curCompleteUri . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '</table>';
    
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: Empfehlungsmanager <noreply@2getmore.com>" . "\n";
    $mailSubject = "Neuer Empfehler erstellt";
    $mailTo = $empfMangDataArr['emMail'];


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function sendMailToEmpfehlerNewDomainGenerate($allData, $empfehlerMail, $curCompleteUri, $curMailTextEmpfehlerDomainGenriert) {
    
    $mailText = $curMailTextEmpfehlerDomainGenriert.'<br /><br /><br />';
    
    $mailText .= 'Ihre Stammkunden-Domain:<br /><br />';
    $mailText .= $curCompleteUri;
    
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: ".$allData['emFirmaName']." <".$allData['emMail'].">" . "\n";
    $mailSubject = $allData['emFirmaName']." - Ihre Stammkunden-Domain";
    $mailTo = $empfehlerMail;


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function getAllDataSettingsFromEmpfehlungsManager() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  public function setCurEmpfManagerClickToDaumenHochMM() {
    $allData = $this->getAllDataSettingsFromEmpfehlungsManager();
    $allOtherSettings = $allData['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    if (isset($allOtherSettingsArr['empfManagerDaumenObenKlicks']) && !empty($allOtherSettingsArr['empfManagerDaumenObenKlicks'])) {
      $allOtherSettingsArr['empfManagerDaumenObenKlicks'] = intval($allOtherSettingsArr['empfManagerDaumenObenKlicks']) + 1;
    }
    else {
      $allOtherSettingsArr['empfManagerDaumenObenKlicks'] = 1;
    }
    
    return $this->saveNewOtherSettingsEmpfManagerNow(json_encode($allOtherSettingsArr));
  }
  
  
  
  public function setCurEmpfManagerClickToDaumenUntenMM() {
    $allData = $this->getAllDataSettingsFromEmpfehlungsManager();
    $allOtherSettings = $allData['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    if (isset($allOtherSettingsArr['empfManagerDaumenUntenKlicks']) && !empty($allOtherSettingsArr['empfManagerDaumenUntenKlicks'])) {
      $allOtherSettingsArr['empfManagerDaumenUntenKlicks'] = intval($allOtherSettingsArr['empfManagerDaumenUntenKlicks']) + 1;
    }
    else {
      $allOtherSettingsArr['empfManagerDaumenUntenKlicks'] = 1;
    }
    
    return $this->saveNewOtherSettingsEmpfManagerNow(json_encode($allOtherSettingsArr));
  }
  
  
  
  private function saveNewOtherSettingsEmpfManagerNow($newJson) {
    $sqlText = 'UPDATE vempfehlungsmanager SET emOtherSettingJson = "'.$this->dbDecode($newJson).'" WHERE emID = 1';
    return $this->dbAbfragen($sqlText);
  }
  
}

?>