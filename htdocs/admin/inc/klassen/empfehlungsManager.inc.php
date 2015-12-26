<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsEmpfehlungsManagerAdmin extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager Admin - Allgemein
  // ***************************************************************************
  
  public function showEmpfehlungsmanagerAdminWindow() {
    $return = '';
    
    $return .= $this->getEmpfehlungsmanagerAdminWindowNavi();
    $return .= $this->getEmpfehlungsmanagerAdminWindowInhalt();
    
    return $return;
  }
  
  
  
  public function getEmpfehlungsmanagerAdminWindowNavi() {
    $return = '<div class="vFrontSiteSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint vFrontActiveEmpfManagerPoint" id="vFrontEmpfehlungsMangerAdminEmpfehler">Empfehler</div>';
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint" id="vFrontEmpfehlungsMangerAdminAnfragen">Anfragen</div>';
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint" id="vFrontEmpfehlungsMangerAdminDankeSeite">Danke Seiten Klicks</div>';
    $return .= '<div style="height:20px;"></div>';
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint" id="vFrontEmpfehlungsMangerAdminExport">E-Mail CSV Export</div>';
    $return .= '<div style="height:20px;"></div>';
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint" id="vFrontEmpfehlungsMangerAdminGeschenke">Geschenke Verwaltung</div>';
    $return .= '<div class="vFrontEmpfehlungsManagerAdminMenuPoint" id="vFrontEmpfehlungsMangerAdminAllgemein">Allgemeine Einstellungen</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getEmpfehlungsmanagerAdminWindowInhalt($curInhaltName = '', $reload = false) {
    $return = '';
    if (isset($reload) && $reload == false) {
      $return .= '<div class="vFrontSiteSettingInhaltHolder">';
    }
    
    if (isset($curInhaltName) && !empty($curInhaltName)) {
      $return .= $this->getTheCureEmpfehlungsmanagerAdminWindowInhalt($curInhaltName);
    }
    else {
      $return .= $this->getTheCureEmpfehlungsmanagerAdminWindowInhalt('vFrontEmpfehlungsMangerAdminEmpfehler');
    }
    
    if (isset($reload) && $reload == false) {
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getTheCureEmpfehlungsmanagerAdminWindowInhalt($curInhaltName) {
    $return = '';
    
    switch($curInhaltName) {
      
      case 'vFrontEmpfehlungsMangerAdminAllgemein':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltAllgemeineEinstellungen();
        break;
      
      
      
      case 'vFrontEmpfehlungsMangerAdminGeschenke':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltGeschenke();
        break;
      
      
      
      case 'vFrontEmpfehlungsMangerAdminEmpfehler':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltEmpfehler();
        break;
      
      
      
      case 'vFrontEmpfehlungsMangerAdminAnfragen':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltAnfragen();
        break;
      
      
      
      case 'vFrontEmpfehlungsMangerAdminExport':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltExport();
        break;
      
      
      
      case 'vFrontEmpfehlungsMangerAdminDankeSeite':
        $return .= $this->getEmpfehlungsmanagerAdminInhaltDankeSeiteKlicks();
        break;
      
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager Admin - Allgemein
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Allgemeine Einstellungen
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltAllgemeineEinstellungen() {
    $allEmpfSettingDataArr = $this->getEmpfehlungsmanagerAdminAllgemeineEinstellungenDataArr();
    
    $allOtherSettings = $allEmpfSettingDataArr['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    $ownGratuliereText = '';
    $ownEmpfehlenWeiterText = '';
    $ownMailTextDomainGeneriert = '';
    $ownMailTextAnfrageErhalten = '';
    $ownMailTextBuchungErhalten = '';
    
    if (isset($allOtherSettingsArr['ownGratuliereText']) && !empty($allOtherSettingsArr['ownGratuliereText'])) {
      $ownGratuliereText = $allOtherSettingsArr['ownGratuliereText'];
    }
    if (isset($allOtherSettingsArr['ownEmpfehlenWeiterText']) && !empty($allOtherSettingsArr['ownEmpfehlenWeiterText'])) {
      $ownEmpfehlenWeiterText = $allOtherSettingsArr['ownEmpfehlenWeiterText'];
    }
    if (isset($allOtherSettingsArr['ownMailTextDomainGeneriert']) && !empty($allOtherSettingsArr['ownMailTextDomainGeneriert'])) {
      $ownMailTextDomainGeneriert = $allOtherSettingsArr['ownMailTextDomainGeneriert'];
    }
    if (isset($allOtherSettingsArr['ownMailTextAnfrageErhalten']) && !empty($allOtherSettingsArr['ownMailTextAnfrageErhalten'])) {
      $ownMailTextAnfrageErhalten = $allOtherSettingsArr['ownMailTextAnfrageErhalten'];
    }
    if (isset($allOtherSettingsArr['ownMailTextBuchungErhalten']) && !empty($allOtherSettingsArr['ownMailTextBuchungErhalten'])) {
      $ownMailTextBuchungErhalten = $allOtherSettingsArr['ownMailTextBuchungErhalten'];
    }
    
    
    $return = '<div style="margin-bottom:0px; margin-left:20px;" class="vFrontHpSeAuflistungUnUeAllg">Allgemeine Einstellungen</div>';
    
    $return .= '<div class="vFrontFrmHolder">';
    
    $return .= '<label for="vFrontEmaMail">E-Mail Adresse:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaMail" id="vFrontEmaMail" value="'.$allEmpfSettingDataArr['emMail'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaFirmaName">Firmen Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaFirmaName" id="vFrontEmaFirmaName" value="'.$allEmpfSettingDataArr['emFirmaName'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaKontaktSiteId">Kontaktformular Seiten ID:</label>
           <div class="vFrontLblAbstand"></div>
           <input style="width:200px;" type="text" name="vFrontEmaKontaktSiteId" id="vFrontEmaKontaktSiteId" value="'.$allEmpfSettingDataArr['emKontaktSiteId'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaTextZwEmpfNameUndFirma">Text zwischen Empfehler Name und Firma:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaTextZwEmpfNameUndFirma" id="vFrontEmaTextZwEmpfNameUndFirma" value="'.$allEmpfSettingDataArr['emTextZwNameFirma'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaRabattText" style="vertical-align:top">Rabatt Text:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontEmaRabattText" id="vFrontEmaRabattText">'.$allEmpfSettingDataArr['emRabattText'].'</textarea>';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaGeschenkeRules" style="vertical-align:top">Geschenke Bedingungen:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontEmaGeschenkeRules" id="vFrontEmaGeschenkeRules">'.$allEmpfSettingDataArr['emGeschenkeRules'].'</textarea>';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    
    // Neu MM **************************************************************************
    $return .= '<label for="vFrontEmaGratuliereText">Gratuliere Text:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaGratuliereText" id="vFrontEmaGratuliereText" value="'.$ownGratuliereText.'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaEmpfehlenWeiterText">Empfehlen Sie uns weiter Text:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaEmpfehlenWeiterText" id="vFrontEmaEmpfehlenWeiterText" value="'.$ownEmpfehlenWeiterText.'" />';
    // *********************************************************************************
    
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    
    // Neu MM **************************************************************************
    $return .= '<label for="vFrontEmaMailTextDomainGeneriert" style="vertical-align:top">Empfehler Mail Text - Domain generiert:</label>
           <div class="vFrontLblAbstand"></div>
           <div style="width:565px;"><textarea name="vFrontEmaMailTextDomainGeneriert" id="vFrontEmaMailTextDomainGeneriert">'.$ownMailTextDomainGeneriert.'</textarea></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaMailTextAnfrageErhalten" style="vertical-align:top">Empfehler Mail Text - Anfrage erhalten:</label>
           <div class="vFrontLblAbstand"></div>
           <div style="width:565px;"><textarea name="vFrontEmaMailTextAnfrageErhalten" id="vFrontEmaMailTextAnfrageErhalten">'.$ownMailTextAnfrageErhalten.'</textarea></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaMailTextBuchungErhalten" style="vertical-align:top">Empfehler Mail Text - Buchung erhalten:</label>
           <div class="vFrontLblAbstand"></div>
           <div style="width:565px;"><textarea name="vFrontEmaMailTextBuchungErhalten" id="vFrontEmaMailTextBuchungErhalten">'.$ownMailTextBuchungErhalten.'</textarea></div>';
    // *********************************************************************************
    
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    
    /*$return .= '<label for="vFrontEmaFbAppId">Facebook App ID:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaFbAppId" id="vFrontEmaFbAppId" value="" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';*/
    
    $return .= '<label for="vFrontEmaFbAppPostSmallDesc">Facebook Post Titel:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaFbAppPostSmallDesc" id="vFrontEmaFbAppPostSmallDesc" value="'.$allEmpfSettingDataArr['emFbShareSmallDesc'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmaFbAppPostLongDesc">Facebook Post Beschreibung:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontEmaFbAppPostLongDesc" id="vFrontEmaFbAppPostLongDesc" value="'.$allEmpfSettingDataArr['emFbShareDesc'].'" />';
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label>Facebook Post Bild:</label>
           <div class="vFrontLblAbstand"></div>';
    $return .= '<input type="hidden" name="vFrontEmaFbAppPostBild" id="vFrontEmaFbAppPostBild" value="'.$allEmpfSettingDataArr['emFbShareBild'].'" />';
    $return .= '<div id="vFrontEmaFbAppPostBildAusgabeSmallSy" style="display:inline-block;">'.$this->getAllgemeineEinstellungenEmpfManagerPostPicAusgabe($allEmpfSettingDataArr['emFbShareBild']).'</div>';
    $return .= '<div id="vFrontEmaFbAppPostBildChangeBtnSy">Bild ändern</div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:150px;" type="submit" value="Speichern" id="vFrontSaveEmpfehlungsmanagerAllgemeinBtn" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen() {
    // Speichern von Zusatz Einstellungen
    // *************************************************************************
    $curAllDataArr = $this->getEmpfehlungsmanagerAdminAllgemeineEinstellungenDataArr();
    $allOtherSettings = $curAllDataArr['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    $allOtherSettingsArr['ownGratuliereText'] = $_POST['_empfMaGratuliereText'];
    $allOtherSettingsArr['ownEmpfehlenWeiterText'] = $_POST['_empfMaEmpfehlenWeiterText'];
    $allOtherSettingsArr['ownMailTextDomainGeneriert'] = $_POST['_empfMaMailTextDomainGeneriert'];
    $allOtherSettingsArr['ownMailTextAnfrageErhalten'] = $_POST['_empfMaMailTextAnfrageErhalten'];
    $allOtherSettingsArr['ownMailTextBuchungErhalten'] = $_POST['_empfMaMailTextBuchungErhalten'];
    
    $allOtherSettingsArrJson = json_encode($allOtherSettingsArr);
    // *************************************************************************
    
    $sqlText = 'UPDATE vempfehlungsmanager SET emMail = "'.$this->dbDecode($_POST['_empfMaMail']).'", emKontaktSiteId = "'.$this->dbDecode($_POST['_empfMaKontaktSiteId']).'", emFirmaName = "'.$this->dbDecode($_POST['_empfMaFirmaName']).'", emRabattText = "'.$this->dbDecode($_POST['_empfMaRabattText']).'", emGeschenkeRules = "'.$this->dbDecode($_POST['_empfMaGeschenkeRules']).'", emFbShareSmallDesc = "'.$this->dbDecode($_POST['_empfMaFbAppPostSmallDesc']).'", emFbShareDesc = "'.$this->dbDecode($_POST['_empfMaFbAppPostLongDesc']).'", emFbShareBild = "'.$this->dbDecode($_POST['_empfMaFbAppPostBild']).'", emTextZwNameFirma = "'.$this->dbDecode($_POST['_empfMaTextZwEmpfNameUndFirma']).'", emOtherSettingJson = "'.$this->dbDecode($allOtherSettingsArrJson).'" WHERE emID = 1';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function getEmpfehlungsmanagerAdminAllgemeineEinstellungenDataArr() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function getAllgemeineEinstellungenEmpfManagerPostPicAusgabe($curPicId) {
    $return = '<br />Kein Bild ausgewählt';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($curPicId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $thumb = '';
      if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_200/'.$row['bildFile'])) {
        $thumb = 'thumb_200/';
      }
      $return = '<img src="user_upload/'.$thumb.$row['bildFile'].'" alt="" title="" />';
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Allgemeine Einstellungen
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Geschenke
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltGeschenke() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">Geschenke Verwaltung</div>';
    $return .= '<div style="margin-top:-52px;" id="vFrontNeuesEmpfManagerGeschenkBtn">Neues Geschenk</div><div class="clearer"></div>';
    
    $return .= $this->getEmpfehlungsmanagerAdminInhaltGeschenkeList();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getEmpfehlungsmanagerAdminInhaltGeschenkeList() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlergeschenke ORDER BY gesBuchAnzahl ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenke">';
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenkeName">Ab '.$row['gesBuchAnzahl'].' Buchungen</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenkeChange" data-id="' . $row['gesID'] . '" title="Bearbeiten"></div>';
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenkeDel" data-id="' . $row['gesID'] . '" title="Löschen"></div>';
      $return .= '</div>';
    }
    
    if (isset($sqlCount) && $sqlCount < 1) {
      $return .= 'Es sind keine Geschenke vorhanden.';
    }
    
    return $return;
  }
  
  
  
  public function saveEmpfehlungsManagerNewGeschenkOnSendNow($anzahlBuchungen, $geschenkText) {
    $sqlText = 'INSERT INTO vempfehlergeschenke (gesBuchAnzahl, gesText) VALUES ("'.$this->dbDecode($anzahlBuchungen).'", "'.$this->dbDecode($geschenkText).'")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delEmpfehlungsmanagerAdminThisGeschenkNow($curGeschenkId) {
    $sqlText = 'DELETE FROM vempfehlergeschenke WHERE gesID = "'.$this->dbDecode($curGeschenkId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($curGeschenkId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlergeschenke WHERE gesID = "'.$this->dbDecode($curGeschenkId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontSmallSeFrmHolder">';
      $return .= '<label for="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm">Anzahl Buchungen:</label>';
      $return .= '<input style="width:150px;" type="text" id="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm" name="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm" value="'.$row['gesBuchAnzahl'].'" />';
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<label style="vertical-align:top;" for="vEmpfehlungsmanagerGeschenkeTextFrm">Text:</label>';
      $return .= '<textarea style="width:268px; height:80px;" id="vEmpfehlungsmanagerGeschenkeTextFrm" name="vEmpfehlungsmanagerGeschenkeTextFrm">'.$row['gesText'].'</textarea>';
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<input type="submit" id="vEmpfehlungsmanagerGeschenkeBearSaveBtn" value="Speichern" data-id="'.$row['gesID'].'" />';
      $return .= '</div>';
    }
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      $return .= 'Fehler';
    }
    
    return $return;
  }
  
  
  
  public function saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($curGeschenkId, $anzahlBuchungen, $geschenkText) {
    $sqlText = 'UPDATE vempfehlergeschenke SET gesBuchAnzahl = "'.$this->dbDecode($anzahlBuchungen).'", gesText = "'.$this->dbDecode($geschenkText).'" WHERE gesID = "'.$this->dbDecode($curGeschenkId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Geschenke
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Empfehler
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltEmpfehler() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">Empfehler</div>';
    $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerSucheFrmHolderMM"><input type="text" name="vFrontEmpfAuflistungLiEmpfehlerSucheFrmOwnMM" id="vFrontEmpfAuflistungLiEmpfehlerSucheFrmOwnMM" placeholder="Empfehler Suchen" /></div>';
    
    $return .= $this->getEmpfehlungsmanagerAdminInhaltEmpfehlerList();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getEmpfehlungsmanagerAdminInhaltEmpfehlerList() {
    $return = '<div id="vFrontEmpfAuflistungLiEmpfehlerHolderListSyMM">';
    
    $sqlText = 'SELECT * FROM vempfehler ORDER BY empfID DESC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $anfrageCounts = $this->getEmpfehlerAnfrageCounts($row['empfID']);
      $buchungenCounts = $this->getEmpfehlerBuchungenCounts($row['empfID']);
      
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenke vFrontEmpfAuflistungLiEmpfehler">';
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenkeName vFrontEmpfAuflistungLiEmpfehlerName">'.$row['empfVorname'].' '.$row['empfNachname'].'</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerInfoHolderMM">';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerInfoAnfragenMM">'.$anfrageCounts.' Anfragen</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerInfoBuchungenMM">'.$buchungenCounts.' Buchungen</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerInfoLinkClicksMM">'.$row['empfLinkClicks'].' Link Klicks</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerInfoLinkMM"><b>Url</b>:&nbsp;&nbsp;'.$this->getHrefPathOnlyEmpfehlerUri().'/'.$row['empfUrl'].'</div>';
      $return .= '</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerDelButtonMM" data-id="' . $row['empfID'] . '" title="Empfehler löschen"></div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerShowAnfragen" data-id="' . $row['empfID'] . '" title="Anfragen anzeigen"></div>';
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerShowData" data-id="' . $row['empfID'] . '" title="Empfehler Daten anzeigen"></div>';
      $return .= '</div>';
    }
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      $return .= 'Es sind keine Empfehler vorhanden.';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHrefPathOnlyEmpfehlerUri() {
    $basePath = str_replace('index.php', '', $_SERVER['SERVER_NAME']);
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }

    return $setBaseHTTP.$basePath;
  }
  
  
  
  private function getEmpfehlerAnfrageCounts($empfID) {
    $sqlText = 'SELECT emanID FROM vempfehleranfragen WHERE empfID = "'.$this->dbDecode($empfID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    return mysql_num_rows($sqlErg);
  }
  
  
  
  private function getEmpfehlerBuchungenCounts($empfID) {
    $sqlText = 'SELECT emanID FROM vempfehleranfragen WHERE empfID = "'.$this->dbDecode($empfID).'" AND emanBuchung = "2"';
    $sqlErg = $this->dbAbfragen($sqlText);
    return mysql_num_rows($sqlErg);
  }
  
  
  
  public function showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow($curEmpfId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehler WHERE empfID = "'.$this->dbDecode($curEmpfId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontFrmHolder" style="margin:50px 0px 20px 50px;">';

      $return .= '<label style="width:100px;" for="">Vorname:</label>
             <input style="width:300px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfVorname'].'" />';

      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label style="width:100px;" for="">Nachname:</label>
             <input style="width:300px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfNachname'].'" />';

      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label style="width:100px;" for="">Straße:</label>
             <input style="width:300px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfStrasse'].'" />';

      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label style="width:100px;" for="">PLZ / Ort:</label>
             <input style="width:66px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfPlz'].'" />
             <input style="width:211px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfOrt'].'" />';

      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label style="width:100px;" for="">E-Mail:</label>
             <input style="width:300px;" readonly="readonly" type="text" name="" id="" value="'.$row['empfMail'].'" />';
      
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function delEmpfehlungsmanagerAdminThisEmpfehlerNow($curEmpfId) {
    $sqlText = 'DELETE FROM vempfehleranfragen WHERE empfID = "'.$this->dbDecode($curEmpfId).'"';
    $isOk = $this->dbAbfragen($sqlText);
    
    if (isset($isOk) && $isOk == true) {
      $sqlText2 = 'DELETE FROM vempfehler WHERE empfID = "'.$this->dbDecode($curEmpfId).'"';
      return $this->dbAbfragen($sqlText2);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Empfehler
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Anfragen
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltAnfragen() {
    $return = '<div class="vFrontHpSeAuflistung" style="position:relative;">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">Anfragen</div>';
    $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectHolderMM">Empfehler:&nbsp;&nbsp;';
    $return .= '<select name="vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM" id="vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM">';
    $return .= '<option value="">Alle</option>';
    
    $sqlText = 'SELECT * FROM vempfehler ORDER BY empfID DESC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<option value="'.$row['empfID'].'">'.$row['empfVorname'].' '.$row['empfNachname'].'</option>';
    }
    
    $return .= '</select>';
    $return .= '</div>';
    
    $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerAnfrageHolderSysMM">';
    $return .= $this->getEmpfehlungsmanagerAdminInhaltAnfragenList();
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getEmpfehlungsmanagerAdminInhaltAnfragenList($curEmpfId = '') {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehleranfragen ORDER BY emanID DESC';
    if (isset($curEmpfId) && !empty($curEmpfId)) {
      $sqlText = 'SELECT * FROM vempfehleranfragen WHERE empfID = "'.$this->dbDecode($curEmpfId).'" ORDER BY emanID DESC';
    }
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $classBuchung = '';
      if (isset($row['emanBuchung']) && $row['emanBuchung'] == 2) {
        $classBuchung = ' vFrontEmpfAuflistungLiEmpfehlerAnfrageIsBuchungTrue';
      }
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenke vFrontEmpfAuflistungLiEmpfehlerAnfrage'.$classBuchung.'">';
      $return .= '<div class="vFrontEmpfAuflistungLiGeschenkeName vFrontEmpfAuflistungLiEmpfehlerAnfrageName">'.$row['emanVorname'].' '.$row['emanNachname'].'</div>';
      if (isset($row['emanBuchung']) && $row['emanBuchung'] == 2) {
        $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerAnfrageDelBuchung" data-id="' . $row['emanID'] . '" title="Buchung löschen"></div>';
      }
      else {
        $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerAnfrageSetBuchung" data-id="' . $row['emanID'] . '" title="Buchung setzen"></div>';
      }
      $return .= '<div class="vFrontEmpfAuflistungLiEmpfehlerAnfrageShowData" data-id="' . $row['emanID'] . '" title="Anfrage Mail anzeigen"></div>';
      $return .= '</div>';
    }
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      $return .= 'Es sind keine Anfragen vorhanden.';
    }
    
    return $return;
  }
  
  
  
  public function setTheCurentEmpfehlerAnfrageBooking($curAnfrageId) {
    $sqlText = 'UPDATE vempfehleranfragen SET emanBuchung = "2" WHERE emanID = "'.$this->dbDecode($curAnfrageId).'"';
    $isOk = $this->dbAbfragen($sqlText);
    
    $this->sendMailToEmpfehlerIsANewBooking($curAnfrageId);
    $this->checkGeschenkToEmpfehlerIsANewBooking($curAnfrageId);
    
    return $isOk;
  }
  
  
  
  public function delTheCurentEmpfehlerAnfrageBooking($curAnfrageId) {
    $sqlText = 'UPDATE vempfehleranfragen SET emanBuchung = "1" WHERE emanID = "'.$this->dbDecode($curAnfrageId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showTheCurentEmpfehlerAnfrageHtmlMailNow($curAnfrageId) {
    $return = '<div class="vFrontEmpfehlerAnfrageShowHtmlMailHolder">';
    
    $sqlText = 'SELECT * FROM vempfehleranfragen WHERE emanID = "'.$this->dbDecode($curAnfrageId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= $row['emanMailHtmlText'];
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  
  // Für E-Mail Empfehler bei neuer Buchung
  // ***************************************************************************
  
  private function sendMailToEmpfehlerIsANewBooking($curAnfrageId) {
    $curEmpfehlerId = $this->getEmpfehlerIdForSendMailToEmpfehlerIsANewBooking($curAnfrageId);
    $curEmpfehlerDataArr = $this->getEmpfehlerAllDataForSendMailToEmpfehlerIsANewBooking($curEmpfehlerId);
    $curAllDataArr = $this->getAllDataSettingsFromEmpfehlungsManagerNewBookingMail();
    
    $allOtherSettings = $curAllDataArr['emOtherSettingJson'];
    $allOtherSettingsArr = array();
    if (isset($allOtherSettings) && !empty($allOtherSettings)) {
      $allOtherSettingsArr = json_decode($allOtherSettings, true);
    }
    
    $curMailTextEmpfehlerNeueBuchung = '';
    
    if (isset($allOtherSettingsArr['ownMailTextBuchungErhalten']) && !empty($allOtherSettingsArr['ownMailTextBuchungErhalten'])) {
      $curMailTextEmpfehlerNeueBuchung = $allOtherSettingsArr['ownMailTextBuchungErhalten'];
    }
    
    
    $mailText = $curMailTextEmpfehlerNeueBuchung;
    
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: ".$curAllDataArr['emFirmaName']." <".$curAllDataArr['emMail'].">" . "\n";
    $mailSubject = $curAllDataArr['emFirmaName']." - Neue Buchung von Ihrer Stammkunden-Domain";
    $mailTo = $curEmpfehlerDataArr['empfMail'];


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function getEmpfehlerIdForSendMailToEmpfehlerIsANewBooking($curAnfrageId) {
    $sqlText = 'SELECT empfID FROM vempfehleranfragen WHERE emanID = "'.$this->dbDecode($curAnfrageId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['empfID'];
    }
  }
  
  
  
  private function getEmpfehlerAllDataForSendMailToEmpfehlerIsANewBooking($curEmpfehlerId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehler WHERE empfID = "'.$this->dbDecode($curEmpfehlerId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function getAllDataSettingsFromEmpfehlungsManagerNewBookingMail() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  
  
  
  
  
  // Für E-Mail Kunde bei neuer Buchung check ob Geschenk
  // ***************************************************************************
  
  private function checkGeschenkToEmpfehlerIsANewBooking($curAnfrageId) {
    $curEmpfehlerId = $this->getEmpfehlerIdForSendMailToEmpfehlerIsANewBooking($curAnfrageId);
    $buchungenCounts = $this->getEmpfehlerBuchungenCounts($curEmpfehlerId);
    $dataGeschenk = '';
    
    $sqlText = 'SELECT * FROM vempfehlergeschenke WHERE gesBuchAnzahl = "'.  $this->dbDecode($buchungenCounts).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $dataGeschenk = $row;
    }
    
    if (isset($dataGeschenk) && is_array($dataGeschenk)) {
      $this->sendMailKundeGeschenkToEmpfehlerIsANewBooking($dataGeschenk, $curEmpfehlerId);
    }
  }
  
  
  
  private function sendMailKundeGeschenkToEmpfehlerIsANewBooking($dataGeschenk, $curEmpfehlerId) {
    $curEmpfehlerDataArr = $this->getEmpfehlerAllDataForSendMailToEmpfehlerIsANewBooking($curEmpfehlerId);
    $curAllDataArr = $this->getAllDataSettingsFromEmpfehlungsManagerNewBookingMail();
    
    $mailText = 'Empfehler ist auf neuer Geschenkstufe:<br />';
    $mailText .= '--------------------------------------------------------------<br /><br />';
    
    $mailText .= '<table width="600" border="0" cellspacing="0" cellpadding="5">';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="180">Empfehler Vorname:</td><td>' . $curEmpfehlerDataArr['empfVorname'] . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="180">Empfehler Nachname:</td><td>' . $curEmpfehlerDataArr['empfNachname'] . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="180">Empfehler E-Mail Adresse:</td><td>' . $curEmpfehlerDataArr['empfMail'] . '</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="180">&nbsp;</td><td>&nbsp;</td>';
    $mailText .= '</tr>';
    
    $mailText .= '<tr>';
    $mailText .= '<td width="180" valign="top">Geschenk:</td><td valign="top">' . $dataGeschenk['gesBuchAnzahl'] . ' Buchungen:<br /><br />'.nl2br($dataGeschenk['gesText']).'</td>';
    $mailText .= '</tr>';
    
    $mailText .= '</table>';
    
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: Empfehlungsmanager <noreply@2getmore.com>" . "\n";
    $mailSubject = "Empfehler ist auf neuer Geschenkstufe";
    $mailTo = $curAllDataArr['emMail'];


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      return true;
    }
    else {
      return false;
    }
  }

  // ***************************************************************************

  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Anfragen
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Mail Export
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltExport() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">E-Mail CSV Export</div>';
    
    $return .= '<div id="vFrontEmpfManagerMailExportBtnGo">E-Mail Adressen Exportieren</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function generateNewEmpfehlungsManagerMailCsvFile() {
    $filename = $_SERVER['DOCUMENT_ROOT'].'/admin/csv/EmpfehlungsManagerMail.csv';
    if (file_exists($filename)) {
      unlink($filename);
    }
    
    
    $fp = fopen($filename,"w+");
    fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
    
    $csvUeArr = array('E-Mail Liste:   '.date('d.m.Y h:i'), '', '', '');
    $csvUeTitelArr = array('Vorname', 'Nachname', 'Empfehler Name', 'E-Mail');
    $csvAbstandArr = array('', '', '', '');
    
    fputcsv($fp, $csvUeArr, ';');
    fputcsv($fp, $csvAbstandArr, ';');
    
    fputcsv($fp, $csvUeTitelArr, ';');
    fputcsv($fp, $csvAbstandArr, ';');
    
    $sqlText = 'SELECT * FROM vempfehleranfragen';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curEmpfehlerName = $this->getEmpfehlerNameByIdForCsv($row['empfID']);
      if (isset($row['emanMail']) && !empty($row['emanMail'])) {
        $csvRowArr = array($row['emanVorname'], $row['emanNachname'], $curEmpfehlerName, $row['emanMail']);
        fputcsv($fp, $csvRowArr, ';');
      }
    }
    
    fclose($fp);
    
    return true;
  }
  
  
  
  private function getEmpfehlerNameByIdForCsv($curEmpfId) {
    $return = '';
    
    $sqlText = 'SELECT empfVorname, empfNachname FROM vempfehler WHERE empfID = "'.$this->dbDecode($curEmpfId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['empfVorname'].' '.$row['empfNachname'];
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Mail Export
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager - Danke Seite Clicks
  // ***************************************************************************
  
  private function getEmpfehlungsmanagerAdminInhaltDankeSeiteKlicks() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">Danke Seiten Klicks</div>';
    
    $allOtherSettingsEmMa = $this->getAllOtherSettingsArrayEmpfehlungsmanager();
    $curCountDaumenOben = 0;
    $curCountDaumenUnten = 0;
    if (isset($allOtherSettingsEmMa['empfManagerDaumenObenKlicks']) && !empty($allOtherSettingsEmMa['empfManagerDaumenObenKlicks'])) {
      $curCountDaumenOben = $allOtherSettingsEmMa['empfManagerDaumenObenKlicks'];
    }
    if (isset($allOtherSettingsEmMa['empfManagerDaumenUntenKlicks']) && !empty($allOtherSettingsEmMa['empfManagerDaumenUntenKlicks'])) {
      $curCountDaumenUnten = $allOtherSettingsEmMa['empfManagerDaumenUntenKlicks'];
    }
    
    $return .= '<div class="vFrontHpSeEmpfManagerDaumenObenPic">'.$curCountDaumenOben.' Klicks</div>';
    $return .= '<div class="vFrontHpSeEmpfManagerDaumenUntenPic">'.$curCountDaumenUnten.' Klicks</div>';
    $return .= '<div class="clearer"></div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager - Danke Seite Clicks
  // ***************************************************************************
  
  
  
  
  
  
  
  private function getAllOtherSettingsArrayEmpfehlungsmanager() {
    $return = '';
    
    $sqlText = 'SELECT emOtherSettingJson FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['emOtherSettingJson']) && !empty($row['emOtherSettingJson'])) {
        $return = json_decode($row['emOtherSettingJson'], true);
      }
    }
    
    return $return;
  }
  
}

?>