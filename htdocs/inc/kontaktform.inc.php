<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsKontaktformularSys extends funktionsSammlung {
  
  private $mailTo = '';
  private $mailSender = '';
  private $vornameSender = 'Wildkogel-Arena';
  private $nachnameSender = '';
  private $betreff = 'Neue Kontaktformular Anfrage von Traumliste';
  
  
  
  public function sendKontaktformularSysNow($orderBody=null) {
      
     
    // Für Empfehlungsmanager Empfehler
    // *************************************************************************
    $curEmpfehlerData = '';
    if (isset($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT']) && !empty($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT'])) {
      $curEmpfehlerData = $this->getEmpfehlerDataByEmpfehlerUrlMM($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT']);
    }
    // *************************************************************************
    
    $mailTextKunde = '';
    
    $mailText = 'Neue Kontaktformular Anfrage:<br />';
    $mailText .= '--------------------------------------------------------------<br /><br />';
    
    $curHomepageLangSend = 'Deutsch';
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curHomepageLangSend = $this->getHomepageLangTextByLangKurzUrl($_POST['VCMS_POST_LANG']);
    }
    
    $mailText .= 'Sender Homepage Sprache: '.$curHomepageLangSend.'<br /><br />';
    
    // Für Empfehlungsmanager Empfehler
    // *************************************************************************
    if (isset($curEmpfehlerData) && is_array($curEmpfehlerData)) {
      $mailText .= '***************************************************************<br />';
      $mailText .= 'Diese Anfrage kommt über einen Empfehler:<br />';
      $mailText .= $curEmpfehlerData['empfVorname'].' '.$curEmpfehlerData['empfNachname'].'<br />';
      $mailText .= '***************************************************************<br /><br />';
    }
    // *************************************************************************
    
    $mailTextKunde .= '<table width="600" border="0" cellspacing="0" cellpadding="5">';
    $mailText .= '<table width="600" border="0" cellspacing="0" cellpadding="5">';
     
    $jsonArr = $this->buildKontaktFormArrByJson($_POST['_dataArr'][0]['value']);
    $this->mailTo = $jsonArr['AbsenderMail'];
  
    
   
    unset($_POST['_dataArr'][9],$_POST['_dataArr'][8]);
    $friendEmail = '';
   if($_POST['_dataArr']['0']['value'] == 6){
       $mailTextKunde = '<table width="600" border="0" cellspacing="0" cellpadding="5">';
       $mailText = '<table width="600" border="0" cellspacing="0" cellpadding="5">';
       $this->betreff = 'Dein Freund sendet dir Informationen aus der Wildkogel-Arena';
       $friendEmail  = $_POST['_dataArr'][6]['value'];
       unset($_POST['_dataArr'][1],$_POST['_dataArr'][2],$_POST['_dataArr'][3],$_POST['_dataArr'][5],$_POST['_dataArr'][6]);
   }
    

    
    $n=0;
    foreach ($_POST['_dataArr'] as $value) {
      if ($value['name'] != 'vCmsKontaktformLiveHolderSysIdHFrm' && $value['name'] != 'vCmsKontaktformLiveHolderSysEHFrm') {
        $curData = $this->getKontaktformFieldAllData($jsonArr, $value);
        
        $explode = explode(';',$curData['Label']);
        
        if(count($explode) == 2){
            $label = $explode[$n];
            $n++;
        }else{
            $label = $curData['Label'];
        }
        
        if($value['name'] == 'Newsletter' && $value['value'] == 'on'){
            $value['value'] = 'Ja';
        }elseif($value['name'] == 'Newsletter'){
             $value['value'] = 'Nein';
        }
        
        
        if($label != ''){
            $mailTextKunde .= '<tr>';
            $mailTextKunde .= '<td valign="top" width="140">'.$label.': </td><td>' . nl2br($value['value']) . '</td>';
            $mailTextKunde .= '</tr>';

            $mailText .= '<tr>';
            $mailText .= '<td valign="top" width="140">'.$label.': </td><td>' . nl2br($value['value']) . '</td>';
            $mailText .= '</tr>';
        }
        
       
        
        
        if ($value['name'] == $jsonArr['FieldMail']) {
          $this->mailSender = $value['value'];
        }
        if ($value['name'] == $jsonArr['FieldFirstName']) {
          $this->vornameSender = $value['value'];
        }
        if ($value['name'] == $jsonArr['FieldLastName']) {
          $this->nachnameSender = $value['value'];
        }
      }
    }
    
    $mailTextKunde .= '</table>';
    $mailText .= '</table>';
    
    if($orderBody != null){
 
        require_once '../../admin/inc/klassen/order.inc.php';
        $order = new cmsOrderModul();
        $mailText.=$order->getOrderToEmail(); 
        
       $name = mysql_escape_string($_POST['_dataArr'][2]['value']);
         $order->saveOrderTab($name);
        
    }
    
    
    
    
    $sendOk = $this->sendMailInhaltNowMM($mailText, $curEmpfehlerData);
    
    if($friendEmail != ''){
       
       $sendOk = $this->sendMailInhaltNowMM($mailText, $curEmpfehlerData,$friendEmail); 
    }
    
    
      
       
       
        
    
    
    if (isset($jsonArr['BestaetigungMailAktiv']) && $jsonArr['BestaetigungMailAktiv'] == 'on') {
      $sendOkBest = $this->sendMailInhaltBestaetigungKundeNowMM($mailTextKunde, $jsonArr);
    }
    
    if($jsonArr['Redirect']){
      
       $idSite = $jsonArr['Redirect'];
       $lang   = mysql_escape_string($_POST['VCMS_POST_LANG']) ; 
      
        $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($lang) . '" LIMIT 1';
        $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
        $rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC);
        $idLang = $rowLang['langID'];
     
    
       if($idLang != 1){
          $query = mysql_query("SELECT seitlaTextUrl FROM  vseitelang WHERE seitID = '$idSite' AND langID = '$idLang' ");  
          $row = mysql_fetch_array($query);
       
          if($row['seitlaTextUrl'] != ''){
             $jsonArr['Redirect'] = '/'.$lang.'/'.$row['seitlaTextUrl'];
          }else{
              return $sendOk; 
          }
          
       }else{
           
           
          $query = mysql_query("SELECT seitTextUrl FROM  vseiten WHERE seitID = '$idSite'");
          
          "SELECT seitTextUrl FROM  vseiten WHERE seitID = '$idSite'";
          $row = mysql_fetch_array($query);
          $jsonArr['Redirect'] = '/'.$lang.'/'.$row['seitTextUrl'];
          
       }
       
       unset($_SESSION['basket'],$_SESSION['comment']);
       
       return $jsonArr['Redirect'];
        
    }
    
    return $sendOk;
  }
  
  
  
  private function buildKontaktFormArrByJson($curId) {
    $sqlText = 'SELECT * FROM vkontaktformulare WHERE koID = "' . $this->dbDecode($curId) . '" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);

    while($rowKK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return json_decode($rowKK['koJson'], true);
    }
  }
  
  
  
  private function getKontaktformFieldAllData($jsonArr, $elemOnceArr) {
    $allData = '';
    foreach ($jsonArr['FormData'] as $value) {
      foreach ($value['Container'] as $valueElem) {
        if ($elemOnceArr['name'] == $valueElem['Name']) {
          $allData = $valueElem;
        }
      }
    }
    return $allData;
  }
  
  
  
  private function sendMailInhaltNowMM($mailText, $curEmpfehlerData = '',$email=null) {
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: " . $this->vornameSender . " " . $this->nachnameSender . " <" . $this->mailSender . ">" . "\n";
    $mailSubject = $this->betreff;
   
    if($email != null){
       
       $mailTo = $email;

    }else{
       $mailTo = $this->mailTo;  
    }
    
   


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      if (isset($curEmpfehlerData) && is_array($curEmpfehlerData)) {
        $this->saveEmpfehlerAnfrageToDatabaseMM($curEmpfehlerData['empfID'], $mailText);
        unset($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT']);
      }
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function sendMailInhaltBestaetigungKundeNowMM($mailTextKunde, $jsonArr) {
    $curSendName = 'Kontaktformular';
    if (isset($jsonArr['BestaetigungMailAbsender']) && !empty($jsonArr['BestaetigungMailAbsender'])) {
      $curSendName = $jsonArr['BestaetigungMailAbsender'];
    }
    
    $curSendMail = '';
    if (isset($jsonArr['BestaetigungMailAbsenderMail']) && !empty($jsonArr['BestaetigungMailAbsenderMail'])) {
      $curSendMail = $jsonArr['BestaetigungMailAbsenderMail'];
    }
    
    $curSendBetreff = 'Ihre Kontaktformular Anfrage';
    if (isset($jsonArr['BestaetigungMailBetreff']) && !empty($jsonArr['BestaetigungMailBetreff'])) {
      $curSendBetreff = $jsonArr['BestaetigungMailBetreff'];
    }
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($jsonArr['BestaetigungMailBetreff-'.$_POST['VCMS_POST_LANG']]) && !empty($jsonArr['BestaetigungMailBetreff-'.$_POST['VCMS_POST_LANG']])) {
        $curSendBetreff = $jsonArr['BestaetigungMailBetreff-'.$_POST['VCMS_POST_LANG']];
      }
    }
    
    $curSendText = $jsonArr['BestaetigungMailText'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($jsonArr['BestaetigungMailText-'.$_POST['VCMS_POST_LANG']]) && !empty($jsonArr['BestaetigungMailText-'.$_POST['VCMS_POST_LANG']])) {
        $curSendText = $jsonArr['BestaetigungMailText-'.$_POST['VCMS_POST_LANG']];
      }
    }
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: " . $curSendName . " <" . $curSendMail . ">" . "\n";
    $mailSubject = $curSendBetreff;
    $mailTo = $this->mailSender;
    
    $curSendTextReady = $curSendText.'<br /><br />'.$mailTextKunde;

    if(mail($mailTo, $mailSubject, $curSendTextReady, $header)) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  
  
  
  
  
  
  private function getEmpfehlerDataByEmpfehlerUrlMM($curEmpfUrl) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehler WHERE empfUrl = "'.$this->dbDecode($curEmpfUrl).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function saveEmpfehlerAnfrageToDatabaseMM($curEmpfId, $mailText) {
    $curDate = date('Y-m-d H:i:s');
    
    $sqlText = 'INSERT INTO vempfehleranfragen (emanBuchung, emanDate, emanVorname, emanNachname, emanMail, emanMailHtmlText, empfID) VALUES (1, "'.$this->dbDecode($curDate).'", "'.$this->dbDecode($this->vornameSender).'", "'.$this->dbDecode($this->nachnameSender).'", "'.$this->dbDecode($this->mailSender).'", "'.$this->dbDecode($mailText).'", "'.$this->dbDecode($curEmpfId).'")';
     $isOk = $this->dbAbfragen($sqlText);
    
    $this->sendMailToEmpfehlerIsANewAnfrage($curEmpfId);
    
    return $isOk;
  }
  
  
  
  private function getHomepageLangTextByLangKurzUrl($kurzUrl) {
    $return = '';
    
    $sqlText = 'SELECT langName FROM vsprachen WHERE langKurzName = "'.$this->dbDecode($kurzUrl).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['langName'];
    }
    
    return $return;
  }
  
  
  
  // Für E-Mail Empfehler bei neuer Anfrage
  // ***************************************************************************
  
  private function sendMailToEmpfehlerIsANewAnfrage($curEmpfId) {
    $curEmpfehlerDataArr = $this->getEmpfehlerAllDataForSendMailToEmpfehlerIsANewAnfrage($curEmpfId);
    $curAllDataArr = $this->getAllDataSettingsFromEmpfehlungsManagerNewAnfrageMail();
    
    $allOtherSettings = $curAllDataArr['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    $curMailTextEmpfehlerNeueAnfrage = '';
    
    if (isset($allOtherSettingsArr['ownMailTextAnfrageErhalten']) && !empty($allOtherSettingsArr['ownMailTextAnfrageErhalten'])) {
      $curMailTextEmpfehlerNeueAnfrage = $allOtherSettingsArr['ownMailTextAnfrageErhalten'];
    }
    
    
    $mailText = $curMailTextEmpfehlerNeueAnfrage;
    
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: ".$curAllDataArr['emFirmaName']." <".$curAllDataArr['emMail'].">" . "\n";
    $mailSubject = $curAllDataArr['emFirmaName']." - Neue Anfrage von Ihrer Stammkunden-Domain";
    $mailTo = $curEmpfehlerDataArr['empfMail'];


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function getEmpfehlerAllDataForSendMailToEmpfehlerIsANewAnfrage($curEmpfehlerId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehler WHERE empfID = "'.$this->dbDecode($curEmpfehlerId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function getAllDataSettingsFromEmpfehlungsManagerNewAnfrageMail() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  
}

?>