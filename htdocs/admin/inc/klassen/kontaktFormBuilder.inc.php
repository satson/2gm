<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsKontaktFormBuilderAdmin extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kontaktformular Builder Admin - Allgemein
  // ***************************************************************************
  
  public function showKontaktFormBuilderAdminWindow() {
    $return = '';
    
    $return .= $this->getKontaktFormBuilderAdminWindowNavi();
    $return .= $this->getKontaktFormBuilderAdminWindowInhalt();
    
    return $return;
  }
  
  
  
  public function showKontaktFormBuilderAdminWindowNewForm() {
    $return = '';
    
    $return .= $this->getKontaktFormBuilderAdminWindowNaviNewForm();
    $return .= $this->getKontaktFormBuilderAdminWindowInhalt('vFrontKontaktFormBuilderAdminNewForm');
    
    return $return;
  }
  
  
  
  public function showKontaktFormBuilderAdminWindowBearForm($curFormId) {
    $return = '';
    
    $return .= $this->getKontaktFormBuilderAdminWindowNaviBearForm($curFormId);
    $return .= $this->getKontaktFormBuilderAdminInhaltKontaktBearForm($curFormId);
    
    return $return;
  }
  
  
  
  public function getKontaktFormBuilderAdminWindowNavi() {
    $return = '<div class="vFrontSiteSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM" id="vFrontKontaktFormBuilderMenuBtnNewFormular">Neues Formular</div>';
    //$return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM" id="vFrontKontaktFormBuilderMenuBtnImportFormular">Formular importieren</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getKontaktFormBuilderAdminWindowNaviNewForm() {
    $return = '<div class="vFrontSiteSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM vFrontKontaktFormBuilderMenuBtnIsSaveMM" id="vFrontKontaktFormBuilderMenuBtnNewFormularSave">Formular speichern</div>';
    $return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM vFrontKontaktFormBuilderMenuBtnIsCancelMM" id="vFrontKontaktFormBuilderMenuBtnNewFormularCancel">Formular verwerfen</div>';
    $return .= '<div style="height:20px;"></div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemContainerMM" id="vFrontKontaktFormBuilderDragElemIsContainer"><i class="fa fa-archive"></i>Container</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsTextfeld"><i class="fa fa-square-o"></i>Textfeld</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsTextarea"><i class="fa fa-square"></i>Textarea</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsCheckbox"><i class="fa fa-check-square-o"></i>Checkbox</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsDropDown"><i class="fa fa-caret-square-o-down"></i>DropDown</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsDate"><i class="fa fa-calendar"></i>Date</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getKontaktFormBuilderAdminWindowNaviBearForm($curFormId) {
    $return = '<div class="vFrontSiteSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM vFrontKontaktFormBuilderMenuBtnIsSaveMM" id="vFrontKontaktFormBuilderMenuBtnBearFormularSave" data-id="'.$curFormId.'">Änderungen speichern</div>';
    $return .= '<div class="vFrontKontaktFormBuilderMenuBtnMM vFrontKontaktFormBuilderMenuBtnIsCancelMM" id="vFrontKontaktFormBuilderMenuBtnBearFormularCancel" data-id="'.$curFormId.'">Änderungen verwerfen</div>';
    
    $return .= '<div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemContainerMM" id="vFrontKontaktFormBuilderDragElemIsContainer"><i class="fa fa-archive"></i>Container</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsTextfeld"><i class="fa fa-square-o"></i>Textfeld</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsTextarea"><i class="fa fa-square"></i>Textarea</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsCheckbox"><i class="fa fa-check-square-o"></i>Checkbox</div>';
    $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsDropDown"><i class="fa fa-caret-square-o-down"></i>DropDown</div>';
      $return .= '<div class="vFrontKontaktFormBuilderDragElemMM vFrontKontaktFormBuilderDragElemFormMM" id="vFrontKontaktFormBuilderDragElemIsDate"><i class="fa fa-calendar"></i>Date</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getKontaktFormBuilderAdminWindowInhalt($curInhaltName = '', $reload = false) {
    $return = '';
    if (isset($reload) && $reload == false) {
      $return .= '<div class="vFrontSiteSettingInhaltHolder">';
    }
    
    if (isset($curInhaltName) && !empty($curInhaltName)) {
      $return .= $this->getTheCureKontaktFormBuilderAdminWindowInhalt($curInhaltName);
    }
    else {
      $return .= $this->getTheCureKontaktFormBuilderAdminWindowInhalt('vFrontKontaktFormBuilderAdminList');
    }
    
    if (isset($reload) && $reload == false) {
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getTheCureKontaktFormBuilderAdminWindowInhalt($curInhaltName) {
    $return = '';
    
    switch($curInhaltName) {
      
      case 'vFrontKontaktFormBuilderAdminList':
        $return .= $this->getKontaktFormBuilderAdminInhaltKontaktFormList();
        break;
      
      
      
      case 'vFrontKontaktFormBuilderAdminNewForm':
        $return .= $this->getKontaktFormBuilderAdminInhaltKontaktNewForm();
        break;
      
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kontaktformular Builder Admin - Allgemein
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kontaktformular Builder Admin - Liste
  // ***************************************************************************
  
  private function getKontaktFormBuilderAdminInhaltKontaktFormList() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div style="margin-left:0px; margin-bottom:25px;" class="vFrontHpSeAuflistungUnUeAllg">Kontaktformulare</div>';
    
    $return .= $this->getKontaktFormBuilderAdminInhaltKontaktFormListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getKontaktFormBuilderAdminInhaltKontaktFormListNow() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vkontaktformulare WHERE koAktiv = 1 ORDER BY koID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontEmpfAuflistungLiKontaktformulareB">';
      $return .= '<div class="vFrontEmpfAuflistungLiKontaktformulareBName">'.$row['koName'].'</div>';
      $return .= '<div class="vFrontEmpfAuflistungLiKontaktformulareBChange" data-id="' . $row['koID'] . '" title="Bearbeiten"></div>';
      $return .= '<div class="vFrontEmpfAuflistungLiKontaktformulareBDel" data-id="' . $row['koID'] . '" title="Löschen"></div>';
      $return .= '</div>';
    }
    
    if (isset($sqlCount) && $sqlCount < 1) {
      $return .= 'Es sind keine Kontaktformulare vorhanden.';
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kontaktformular Builder Admin - Liste
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kontaktformular Builder Admin - Neues Formular
  // ***************************************************************************
  
  private function getKontaktFormBuilderAdminInhaltKontaktNewForm() {
    $return = $this->getAllKontaktformBuilderLangDivsNow();
    
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnDropsHideMM">Drop Bereiche verbergen</div>';
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnEinstellungenMM">Einstellungen</div>';
    $return .= '<div style="display:none;" class="vFrontKontaktFormInnerElemsBtnEinstellungenOnLangMM">Einstellungen</div>';
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnLangChangeMM">'.$this->getKontaktformBuilderLangSelectTop().'</div>';
    
    $return .= '<div class="vFrontKontaktFormInnerElemsDragHolderMM">';
    $return .= '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingKontaktformName" name="vFrontKontaktFormBuilderSettingKontaktformName"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldMail" name="vFrontKontaktFormBuilderSettingFieldMail"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldFirstName" name="vFrontKontaktFormBuilderSettingFieldFirstName"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldLastName" name="vFrontKontaktFormBuilderSettingFieldLastName"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldBetreff" name="vFrontKontaktFormBuilderSettingFieldBetreff"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingAbsender" name="vFrontKontaktFormBuilderSettingAbsender"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingAbsenderMail" name="vFrontKontaktFormBuilderSettingAbsenderMail"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingCaptchaOn" name="vFrontKontaktFormBuilderSettingCaptchaOn">Off</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDankeSeiteText" name="vFrontKontaktFormBuilderSettingDankeSeiteText"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingMailTextHeader" name="vFrontKontaktFormBuilderSettingMailTextHeader"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingMailTextFooter" name="vFrontKontaktFormBuilderSettingMailTextFooter"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingLink" name="vFrontKontaktFormBuilderSettingLink"></textarea>';
     $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettinggoogleCode" name="vFrontKontaktFormBuilderSettinggoogleCode"></textarea>';
     
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDeveloper" name="vFrontKontaktFormBuilderSettingDeveloper"></textarea>';
    
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingSendButtonText" name="vFrontKontaktFormBuilderSettingSendButtonText"></textarea>';
    
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMail" name="vFrontKontaktFormBuilderSettingBestaetigungMail">Off</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff" name="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailText" name="vFrontKontaktFormBuilderSettingBestaetigungMailText"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender"></textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail"></textarea>';
     $return .= '<textarea style="display:none;" id="containerLabels" name="containerLabels"></textarea>';
    
    // Für Spracheinträge
    // *************************************************************************
    $allLangKurzUrisArr = $this->getKontaktformBuilderAllLangKurzUrls();
    foreach ($allLangKurzUrisArr as $value) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDankeSeiteText-'.$value.'" name="vFrontKontaktFormBuilderSettingDankeSeiteText-'.$value.'"></textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingSendButtonText-'.$value.'" name="vFrontKontaktFormBuilderSettingSendButtonText-'.$value.'"></textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'.$value.'" name="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'.$value.'"></textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailText-'.$value.'" name="vFrontKontaktFormBuilderSettingBestaetigungMailText-'.$value.'"></textarea>';
    }
    // *************************************************************************
   $return .= "<script>var langArr ='".json_encode($allLangKurzUrisArr)."';"
           . "langArr = $.parseJSON(langArr);"
           . " </script>";
    $return .= '<input type="text" style="display:none;" id="vFrontKontaktFormBuilderContainerCount" name="vFrontKontaktFormBuilderContainerCount" value="0" />';
    $return .= '<input type="text" style="display:none;" id="vFrontKontaktFormBuilderFormCount" name="vFrontKontaktFormBuilderFormCount" value="0" />';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderJsonFormsString" name="vFrontKontaktFormBuilderJsonFormsString"></textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderJsonContainerLabels" name="vFrontKontaktFormBuilderJsonContainerLabels"></textarea>';
    
    $return .= '<div class="vFrontKontaktFormBuilderDragHolder">';
    $return .= '<div class="vFrontKontaktFormBuilderDragPlaceOuter"></div>';
    $return .= '</div>';
    
    $return .= '</div>';
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveNewKontaktformularFromBuilderNow($curName, $curJson) {
      
     $labels = parse_str($_POST['labels'],$labelArr);
     $labelsStr = json_encode($labelArr['containerLabel']);
     
     $sqlText = 'INSERT INTO vkontaktformulare (koAktiv, koName, koJson, containerLabels, koIsImport) VALUES (1, "'.$this->dbDecode($curName).'", "'.$this->dbDecode($curJson).'", "'.$this->dbDecode($labelsStr).'", 2)';
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kontaktformular Builder Admin - Neues Formular
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kontaktformular Builder Admin - Bearbeiten Formular
  // ***************************************************************************
  
  private function getKontaktFormBuilderAdminInhaltKontaktBearForm($curFormId) {
    $curFormData = $this->getKontaktFormBuilderAdminInhaltKontaktBearFormData($curFormId);
    
    $allLangKurzUrisArr = $this->getKontaktformBuilderAllLangKurzUrls();
    
    $curJsonArr = json_decode($curFormData['koJson'], true);
 
    $return = $this->getAllKontaktformBuilderLangDivsNow();
    
    $return .= '<div class="vFrontSiteSettingInhaltHolder">';
    
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnDropsHideMM">Drop Bereiche verbergen</div>';
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnEinstellungenMM">Einstellungen</div>';
    $return .= '<div style="display:none;" class="vFrontKontaktFormInnerElemsBtnEinstellungenOnLangMM">Einstellungen</div>';
    $return .= '<div class="vFrontKontaktFormInnerElemsBtnLangChangeMM">'.$this->getKontaktformBuilderLangSelectTop().'</div>';
    
    $return .= '<div class="vFrontKontaktFormInnerElemsDragHolderMM">';
    
    $return .= '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingKontaktformName" name="vFrontKontaktFormBuilderSettingKontaktformName">'.$curFormData['koName'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldMail" name="vFrontKontaktFormBuilderSettingFieldMail">'.$curJsonArr['FieldMail'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldFirstName" name="vFrontKontaktFormBuilderSettingFieldFirstName">'.$curJsonArr['FieldFirstName'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldLastName" name="vFrontKontaktFormBuilderSettingFieldLastName">'.$curJsonArr['FieldLastName'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingFieldBetreff" name="vFrontKontaktFormBuilderSettingFieldBetreff">'.$curJsonArr['FieldBetreff'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingAbsender" name="vFrontKontaktFormBuilderSettingAbsender">'.$curJsonArr['Absender'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingAbsenderMail" name="vFrontKontaktFormBuilderSettingAbsenderMail">'.$curJsonArr['AbsenderMail'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingCaptchaOn" name="vFrontKontaktFormBuilderSettingCaptchaOn">'.$curJsonArr['CaptchaOn'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDankeSeiteText" name="vFrontKontaktFormBuilderSettingDankeSeiteText">'.$curJsonArr['DankeSeiteText'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingMailTextHeader" name="vFrontKontaktFormBuilderSettingMailTextHeader">'.$curJsonArr['MailTextHeader'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingMailTextFooter" name="vFrontKontaktFormBuilderSettingMailTextFooter">'.$curJsonArr['MailTextFooter'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingLink" name="vFrontKontaktFormBuilderSettingLink">'.$curJsonArr['Redirect'].'</textarea>';
     $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettinggoogleCode" name="vFrontKontaktFormBuilderSettinggoogleCode">'.$curJsonArr['GoogleCode'].'</textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDeveloper" name="vFrontKontaktFormBuilderSettingDeveloper">'.$curJsonArr['Developer'].'</textarea>';
    $return .= '<textarea style="display:none;" id="vKontaktformularBuilderSettinggoogleCode" name="vFrontKontaktFormBuilderSettingLink">'.$curJsonArr['FrontKontaktFormBuilderSettingoogleCode'].'</textarea>';
  $return .= "<script>var langArr ='".json_encode($allLangKurzUrisArr)."';"
           . "langArr = $.parseJSON(langArr);"
           . " </script>";
    
    if (isset($curJsonArr['SendButtonText']) && !empty($curJsonArr['SendButtonText'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingSendButtonText" name="vFrontKontaktFormBuilderSettingSendButtonText">'.$curJsonArr['SendButtonText'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingSendButtonText" name="vFrontKontaktFormBuilderSettingSendButtonText"></textarea>';
    }
    
    if (isset($curJsonArr['BestaetigungMailAktiv']) && !empty($curJsonArr['BestaetigungMailAktiv'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMail" name="vFrontKontaktFormBuilderSettingBestaetigungMail">'.$curJsonArr['BestaetigungMailAktiv'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMail" name="vFrontKontaktFormBuilderSettingBestaetigungMail">off</textarea>';
    }
    if (isset($curJsonArr['BestaetigungMailBetreff']) && !empty($curJsonArr['BestaetigungMailBetreff'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff" name="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff">'.$curJsonArr['BestaetigungMailBetreff'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff" name="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff"></textarea>';
    }
    if (isset($curJsonArr['BestaetigungMailText']) && !empty($curJsonArr['BestaetigungMailText'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailText" name="vFrontKontaktFormBuilderSettingBestaetigungMailText">'.$curJsonArr['BestaetigungMailText'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailText" name="vFrontKontaktFormBuilderSettingBestaetigungMailText"></textarea>';
    }
    if (isset($curJsonArr['BestaetigungMailAbsender']) && !empty($curJsonArr['BestaetigungMailAbsender'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender">'.$curJsonArr['BestaetigungMailAbsender'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsender"></textarea>';
    }
    if (isset($curJsonArr['BestaetigungMailAbsenderMail']) && !empty($curJsonArr['BestaetigungMailAbsenderMail'])) {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail">'.$curJsonArr['BestaetigungMailAbsenderMail'].'</textarea>';
    }
    else {
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail" name="vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail"></textarea>';
    }
    
    // Für Spracheinträge
    // *************************************************************************
    $allLangKurzUrisArr = $this->getKontaktformBuilderAllLangKurzUrls();
    foreach ($allLangKurzUrisArr as $value) {
      $dankeSeiteTextL = '';
      $sendButtonTextL = '';
      $bestaetigungMailTextL = '';
      $bestaetigungMailBetreffL = '';
      if (isset($curJsonArr['DankeSeiteText-'.$value]) && !empty($curJsonArr['DankeSeiteText-'.$value])) {
        $dankeSeiteTextL = $curJsonArr['DankeSeiteText-'.$value];
      }
      if (isset($curJsonArr['SendButtonText-'.$value]) && !empty($curJsonArr['SendButtonText-'.$value])) {
        $sendButtonTextL = $curJsonArr['SendButtonText-'.$value];
      }
      if (isset($curJsonArr['BestaetigungMailBetreff-'.$value]) && !empty($curJsonArr['BestaetigungMailBetreff-'.$value])) {
        $bestaetigungMailBetreffL = $curJsonArr['BestaetigungMailBetreff-'.$value];
      }
      if (isset($curJsonArr['BestaetigungMailText-'.$value]) && !empty($curJsonArr['BestaetigungMailText-'.$value])) {
        $bestaetigungMailTextL = $curJsonArr['BestaetigungMailText-'.$value];
      }
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingDankeSeiteText-'.$value.'" name="vFrontKontaktFormBuilderSettingDankeSeiteText-'.$value.'">'.$dankeSeiteTextL.'</textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingSendButtonText-'.$value.'" name="vFrontKontaktFormBuilderSettingSendButtonText-'.$value.'">'.$sendButtonTextL.'</textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'.$value.'" name="vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'.$value.'">'.$bestaetigungMailBetreffL.'</textarea>';
      $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderSettingBestaetigungMailText-'.$value.'" name="vFrontKontaktFormBuilderSettingBestaetigungMailText-'.$value.'">'.$bestaetigungMailTextL.'</textarea>';
    }
    // *************************************************************************
    
    $return .= '<input type="text" style="display:none;" id="vFrontKontaktFormBuilderContainerCount" name="vFrontKontaktFormBuilderContainerCount" value="'.$curJsonArr['ContainerCount'].'" />';
    $return .= '<input type="text" style="display:none;" id="vFrontKontaktFormBuilderFormCount" name="vFrontKontaktFormBuilderFormCount" value="'.$curJsonArr['FormCount'].'" />';
    $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderJsonFormsString" name="vFrontKontaktFormBuilderJsonFormsString">'.$curFormData['koJson'].'</textarea>';
    
    if($curFormData['containerLabels'] == ''){
        
        $curFormData['containerLabels'] = json_encode(array(1));
    }
     $return .= '<textarea style="display:none;" id="vFrontKontaktFormBuilderJsonContainerLabels" name="vFrontKontaktFormBuilderJsonContainerLabels">'.$curFormData['containerLabels'].'</textarea>';
    
    $return .= '<div class="vFrontKontaktFormBuilderDragHolder">';
    $return .= '<div class="vFrontKontaktFormBuilderDragPlaceOuter"></div>';
    $return .= '</div>';
    
    $return .= '</div>';
    
    $return .= '</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getKontaktFormBuilderAdminInhaltKontaktBearFormData($curFormId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vkontaktformulare WHERE koID = "'.$this->dbDecode($curFormId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  public function saveBearKontaktformularFromBuilderNow($curFormId, $curName, $curJson) {
      
      $labels = parse_str($_POST['labels'],$labelArr);
     $labelsStr = json_encode($labelArr['containerLabel']);
     
    $sqlText = 'UPDATE vkontaktformulare SET koName = "'.$this->dbDecode($curName).'", koJson = "'.$this->dbDecode($curJson).'",containerLabels= "'.$this->dbDecode($labelsStr).'" WHERE koID = "'.$this->dbDecode($curFormId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kontaktformular Builder Admin - Bearbeiten Formular
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Löscht ein Kontaktformular
  // ***************************************************************************
  
  public function delThisKontaktformularOnAdminNow($curDelFormId) {
    $sqlText = 'DELETE FROM vkontaktformulare WHERE koID = ' . $this->dbDecode($curDelFormId);
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Löscht ein Kontaktformular
  // ***************************************************************************
  
  
  
  
  
  
  
  private function getKontaktformBuilderLangSelectTop() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if ($sqlErgCount > 1) {
      $return .= '<select name="vFrontKontaktFormBuilderLangChangeSelectOpt" id="vFrontKontaktFormBuilderLangChangeSelectOpt">';
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($row['langStandard']) && $row['langStandard'] == 2 && $row['langKurzName'] != 'de') {
          $return .= '<option value="'.$row['langKurzName'].'">'.$row['langName'].'</option>';
        }
        else {
          $return .= '<option value="">'.$row['langName'].'</option>';
        }
      }
      $return .= '</select>';
    }
    else {
      $return .= '<select style="display:none;" name="vFrontKontaktFormBuilderLangChangeSelectOpt" id="vFrontKontaktFormBuilderLangChangeSelectOpt">';
      $return .= '<option value="">Deutsch</option>';
      $return .= '</select>';
    }
    
    return $return;
  }
  
  
  
  private function getKontaktformBuilderAllLangKurzUrls() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if ($sqlErgCount > 1) {
      $return = array();
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($row['langStandard']) && $row['langStandard'] == 2) {
          $return[$row['langKurzName']] = $row['langKurzName'];
        }
      }
    }
    
    return $return;
  }
  
  
  
  private function getAllKontaktformBuilderLangDivsNow() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if ($sqlErgCount > 1) {
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($row['langStandard']) && $row['langStandard'] == 2) {
          $return .= '<div style="display:none;" class="vFrontKontaktFormBuilderLangDivIs" data-name="'.$row['langKurzName'].'"></div>';
        }
      }
    }
    
    return $return;
  }
  
  
  
  public function getContainerLabelSettingsWindow(){
      
       $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $query = mysql_query("SELECT * FROM vsprachen");
    while($row = mysql_fetch_array($query)){
        
         $return .= '<label for="vPicKatFrmName">'.$row['langName'].':</label>
                <input type="text" name="labelName" data-lang="'.$row['langKurzName'].'"  data-idContainer="'.$_POST['_idcontainer'].'" class="labelsName"/>';
         $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    }

    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveLabelContainer" />';
    
    $return .= '</div>';
      
     return $return; 
  }
  
}

?>