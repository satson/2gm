<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsElementeSelf extends funktionsSammlung {
  
  private $areElementsInherit = false;
  
  
  private function checkIselementActiveLang($siteDropName, $siteID){
      
      if(isset($_SESSION['VCMS_USER_ID'])){
          return true;
      }
      
     $sqlText = mysql_query('SELECT langConfig FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($siteID) . ' AND selemDataName = "' . $this->dbDecode($siteDropName) . '" ORDER BY selemPosition ASC');
     $row = mysql_fetch_array($sqlText);
     $conf = unserialize($row['langConfig']);
    
     if($conf != ''){
        foreach($conf as $key => $value){
          $langArr[$value['name']] = $value['value'];  
        }

      if($langArr[$_GET['_lang']] == 'yes'){
        return true; 
      }else{
          return false;
      }
         
     }else{
         return true;
     }
  }
  
  
  public function setElemHolderInhaltLoad($siteDropName, $siteID, $elHolderInherit, $isReload = false) {
      
   if($this->checkIselementActiveLang($siteDropName,$siteID)){
      
    if (isset($isReload) && $isReload == true) {
      $return = '';
    }
    else if (checkIsUserLogedIn()) {
      $return = '<div class="vContentElemDD" data-name="' . $siteDropName . '" data-id="' . $siteID . '" data-inherit="' . $elHolderInherit . '">';
    }
    else {
      $return = '<div class="vContentElemDD">';
    }
    
 
    $droppableCount = 1;
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($siteID) . ' AND selemDataName = "' . $this->dbDecode($siteDropName) . '" ORDER BY selemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNum = mysql_num_rows($sqlErg);
    
    // Für die Vererbung gesetzt ist
    // *************************************************************************
    if ($elHolderInherit == 'inherit' && $sqlNum == 0) {
      $this->areElementsInherit = true;
      if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
        $return .= '<div class="vFrontDroppable vFrontDroppableEmpty" data-count="' . $droppableCount . '"></div>';
      }
      $return .= $this->checkSiteParentInheritElements($siteID, $siteDropName, $isReload);
      $this->areElementsInherit = false;
    }
    else {
    // *************************************************************************
     
    
      if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
        $return .= '<div class="vFrontDroppable vFrontDroppableEmpty" data-count="' . $droppableCount . '"></div>';
      }

      if ($sqlNum > 0) {
        while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          $droppableCount = $droppableCount + 2;
          $curElemArr = $this->getCurElementArrayLoad($row['elemID']);
          $return .= $this->buildElementInhaltLoad($row, $curElemArr, $isReload);
          if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
            $return .= '<div class="vFrontDroppable vFrontDroppableEmpty" data-count="' . $droppableCount . '"></div>';
          }
        }
      }
    
    }
      
    
    if (isset($isReload) && $isReload == false) {
      $return .= '</div>';
    }
    
    return $return;
    
  }else{
      
      return;
      
  }
  }
  
  
  
  // Funktionen zum Prüfen ob Element Online
  // ***************************************************
  
  private function checkIsThisSeitElemOnlineAll($rowSiteElem) {
    global $isMobileCheck;
    global $isTabletCheck;
    if (isset($rowSiteElem['selemOwnConfig']) && !empty($rowSiteElem['selemOwnConfig'])) {
      $allSelemSystemConfigArr = json_decode($rowSiteElem['selemOwnConfig'], true);
      if (isset($allSelemSystemConfigArr['vSysSettings']['elemIsOnline']) && $allSelemSystemConfigArr['vSysSettings']['elemIsOnline'] == 'no') {
        return false;
      }
      if ((isset($isMobileCheck) && $isMobileCheck == false) && (isset($isTabletCheck) && $isTabletCheck == false)) {
        if (isset($allSelemSystemConfigArr['vSysSettings']['elemDesktopShow']) && $allSelemSystemConfigArr['vSysSettings']['elemDesktopShow'] == 'no') {
          return false;
        }
      }
      if (isset($isMobileCheck) && $isMobileCheck == true) {
        if (isset($allSelemSystemConfigArr['vSysSettings']['elemMobileShow']) && $allSelemSystemConfigArr['vSysSettings']['elemMobileShow'] == 'no') {
          return false;
        }
      }
      if (isset($isTabletCheck) && $isTabletCheck == true) {
        if (isset($allSelemSystemConfigArr['vSysSettings']['elemTabletShow']) && $allSelemSystemConfigArr['vSysSettings']['elemTabletShow'] == 'no') {
          return false;
        }
      }
      if (!$this->checkIsThisSeitElemOnlineOnTime($allSelemSystemConfigArr)) {
        return false;
      }
      
      return true;
    }
    else {
      return true;
    }
  }
  
  
  
  private function checkIsThisSeitElemOnlineOnTime($allSelemSystemConfigArr) {
    if ((isset($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate']) && !empty($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate'])) || (isset($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']) && !empty($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']))) {
      $curDateAb = $this->buildCurrentDateDatabaseFormat($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate']);
      $curTimeAb = $this->buildCurrentTimeDatabaseFormat($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbTime'], 'ab');
      $curDateBis = $this->buildCurrentDateDatabaseFormat($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']);
      $curTimeBis = $this->buildCurrentTimeDatabaseFormat($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisTime'], 'bis');
      $curDateTimeAktuell = strtotime(date('Y-m-d H:i:s'));
      
      if ((isset($curDateAb) && !empty($curDateAb)) && (isset($curDateBis) && !empty($curDateBis))) {
        if (strtotime($curDateAb.$curTimeAb) >= $curDateTimeAktuell || strtotime($curDateBis.$curTimeBis) <= $curDateTimeAktuell) {
          return false;
        }
      }
      else if (isset($curDateAb) && !empty($curDateAb)) {
        if (strtotime($curDateAb.$curTimeAb) >= $curDateTimeAktuell) {
          return false;
        }
      }
      else if (isset($curDateBis) && !empty($curDateBis)) {
        if (strtotime($curDateBis.$curTimeBis) <= $curDateTimeAktuell) {
          return false;
        }
      }
    }
    
    return true;
  }
  
  
  
  private function buildCurrentDateDatabaseFormat($date) {
    if (isset($date) && !empty($date)) {
      $dateZw = explode('.', $date);
      return $dateZw[2].'-'.$dateZw[1].'-'.$dateZw[0];
    }
    else {
      return '';
    }
  }
  
  
  
  private function buildCurrentTimeDatabaseFormat($time, $art) {
    if (isset($time) && !empty($time)) {
      return ' '.$time.':00';
    }
    else {
      if (isset($art) && $art == 'ab') {
        return ' 00:00:00';
      }
      if (isset($art) && $art == 'bis') {
        return ' 23:59:59';
      }
    }
  }
  
  // ***************************************************
  
  
  
  // Funktionen für Element Vererbungen
  // ***************************************************
  
  private function checkSiteParentInheritElements($siteID, $siteDropName, $isReload) {
    $return = '';
    $siteAktArr = array();
    $sqlText = 'SELECT seitParent FROM vseiten WHERE seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $siteAktArr = $row;
    }
    if (isset($siteAktArr['seitParent']) && $siteAktArr['seitParent'] != 0) {
      $sqlTextEl = 'SELECT seitID, seitParent FROM vseiten WHERE seitID = ' . $this->dbDecode($siteAktArr['seitParent']) . ' LIMIT 1';
      $sqlErgEl = $this->dbAbfragen($sqlTextEl);
      while ($rowEl = mysql_fetch_array($sqlErgEl, MYSQL_ASSOC)) {
        $return .= $this->buildInerhitElementsNow($rowEl['seitID'], $siteDropName, $isReload);
        if (isset($return) && empty($return)) {
          $return .= $this->checkSiteParentInheritElements($rowEl['seitID'], $siteDropName, $isReload);
        }
      }
    }
    else {
      $curStartSiteID = $this->getTheCurCMSStartSiteId();
      $sqlTextEl = 'SELECT seitID, seitParent FROM vseiten WHERE seitID = ' . $this->dbDecode($curStartSiteID) . ' LIMIT 1';
      $sqlErgEl = $this->dbAbfragen($sqlTextEl);
      while ($rowEl = mysql_fetch_array($sqlErgEl, MYSQL_ASSOC)) {
        $return .= $this->buildInerhitElementsNow($rowEl['seitID'], $siteDropName, $isReload);
      }
    }
    
    return $return;
  }
  
  
  
  private function buildInerhitElementsNow($siteID, $siteDropName, $isReload) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($siteID) . ' AND selemDataName = "' . $this->dbDecode($siteDropName) . '" ORDER BY selemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNum = mysql_num_rows($sqlErg);
    
    if ($sqlNum > 0) {
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $curElemArr = $this->getCurElementArrayLoad($row['elemID']);
        $return .= $this->buildElementInhaltLoad($row, $curElemArr, $isReload);
      }
    }
    
    return $return;
  }
  
  // ***************************************************



  private function buildElementInhaltLoad($siteElementArr, $elementArr, $isReload = false, $isAliasElemPicArrays = '') {
    // Für Elem Offline Check
    // *************************************************************************
    $elemIsOnline = true;
    $elemIsOfflineClass = '';
    if (!$this->checkIsThisSeitElemOnlineAll($siteElementArr)) {
      $elemIsOnline = false;
      $elemIsOfflineClass = ' vFrontElemIsOfflineClassMM';
    }
    
    if (!checkIsUserLogedIn() && $elemIsOnline == false) {
      return '';
    }
    // *************************************************************************
    
    if (checkIsUserLogedIn()) {
      $sortableByInheritClass = ' vCmsCanElemSortableImportant';
      if (isset($this->areElementsInherit) && $this->areElementsInherit == true) {
        $sortableByInheritClass = ' vCmsNoElemSortableImportant';
      }
      
      // Für Farbänderung wenn Element Verknüpft ist
      // ***********************************************************************
      $isAliasCurColor = '';
      if ((isset($elementArr['elemEigen']) && $elementArr['elemEigen'] == 1) && $elementArr['elemArt'] == 5) {
        $isAliasCurColor = ' vFrontCurAliasElemColor';
      }
      else if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $isAliasCurColor = ' vFrontCurAliasElemColor';
      }
      // ***********************************************************************
      
      $return = '<div class="vSiteElemBox'.$sortableByInheritClass.$isAliasCurColor.$elemIsOfflineClass.'" data-elem="' . $siteElementArr['selemID'] . '">';
    }
    else {
      $return = '<div class="vSiteElemBox">';
    }
    
    if (isset($elementArr['elemEigen']) && $elementArr['elemEigen'] == 1) {
      if ($elementArr['elemArt'] == 1) {
        $return .= $this->buildElementTextfeld($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 2) {
        $return .= $this->buildElementBild($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 3) {
        $return .= $this->buildElementBildSlider($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 4) {
        $return .= $this->buildElementSpalten($siteElementArr, $elementArr, $isReload);
      }
      else if ($elementArr['elemArt'] == 5) {
        $return .= $this->buildElementAlias($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 6) {
        $return .= $this->buildElementKontaktFormular($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 7) {
        $return .= $this->buildElementEmpfehlungsManagerEmpfehler($siteElementArr, $elementArr);
      }
      else if ($elementArr['elemArt'] == 8) {
        $return .= $this->buildElementEmpfehlungsManagerGeschenkeTextInfo($siteElementArr, $elementArr);
      }
    }
    else if (isset($elementArr['elemEigen']) && $elementArr['elemEigen'] == 2) {
      $curAbsPathTemp = '';
      if (defined('VCMS_ABS_PATH_TEMPLATE')) {
        $curAbsPathTemp = VCMS_ABS_PATH_TEMPLATE;
      }
      else if (isset($_SESSION['VCMS_CUR_ABS_PATH_TEMPLATE'])) {
        $curAbsPathTemp = $_SESSION['VCMS_CUR_ABS_PATH_TEMPLATE'];
      }
      
      $return .= $this->getEigenElementAusgabe($siteElementArr, $elementArr, $curAbsPathTemp, $isReload, $isAliasElemPicArrays);
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getCurElementArrayLoad($elemID) {
    $return = array();
    
    $sqlElText = 'SELECT * FROM velement WHERE elemID = ' . $this->dbDecode($elemID) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while($rowEl = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $return = $rowEl;
    }
    
    return $return;
  }
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für einzelne Elemente Ausgaben
  // ***************************************************************************
  
  private function buildElementTextfeld($siteElementArr, $elementArr) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      $return .= '<div class="vSiteElemBoxBearLeisteChange" title="Bearbeiten" id="elemBeID-' . $siteElementArr['selemID'] . '"></div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="vSiteElemBoxBearLeisteSave" title="Speichern" id="elemSaveID-' . $siteElementArr['selemID'] . '"></div>
                <div class="vSiteElemBoxBearLeisteCancel" title="Abbrechen"></div>';
      $return .= '<div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    // MM - 25.04.2014
    // Richtigen Inhalt für Sprache ausgeben ***********************************
    $curTextFromElem = $siteElementArr['selemInhalt'];
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curTextFromElem = $this->buildElementTextfeldOnLang($siteElementArr);
    }
    
    $return .= '<div class="vSiteElemBoxInhalt basicText">' . $curTextFromElem . '</div>';
    // *************************************************************************
    
    return $return;
  }
  
  
  
  private function buildElementBild($siteElementArr, $elementArr) {
    $return = '';
    $bildWidth = '100%';
    
    // MM - 27.04.2014
    // Richtigen Config Inhalt für Sprache ausgeben ****************************
    $curBildConfigFromElem = $siteElementArr['selemConfig'];
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curBildConfigFromElem = $this->buildElementBildConfigOnLang($siteElementArr);
    }
    
    if (isset($curBildConfigFromElem) && !empty($curBildConfigFromElem)) {
      $configJSON = json_decode($curBildConfigFromElem, true);
      if (isset($configJSON['width']) && !empty($configJSON['width'])) {
        $bildWidth = $configJSON['width'];
      }
    }
    // *************************************************************************
    
    // MM - 10.04.2014
    // Link anzeigen wenn vorhanden **************************************
    $linkTagAnfang = '';
    $linkTagEnde = '';
    $linkFarbAusgabeClass = '';
    
    $curElemLinkJson = $siteElementArr['selemLink'];
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curElemLinkJson = $this->getElementLangLinkOwnMM($siteElementArr);
    }
    
    if (isset($curElemLinkJson) && !empty($curElemLinkJson)) {
      $linkCurArr = json_decode($curElemLinkJson, true);
      $linkCurArr = $this->getTheCurentLinkArtFromElementNow($linkCurArr);
      if (isset($linkCurArr['link']) && !empty($linkCurArr['link'])) {
        $curDataAttrWidthLB = '';
        $curDataAttrHeightLB = '';
        $curLinkClass = ' class="';
        if (isset($linkCurArr['linkClass']) && !empty($linkCurArr['linkClass'])) {
          $curLinkClass .= $linkCurArr['linkClass'];
        }
        if (isset($linkCurArr['linkIsInLightbox']) && $linkCurArr['linkIsInLightbox'] == 'on') {
          $curLinkClass .= ' vcmsLinkingLightboxElemShowMMa';
          $curDataAttrWidthLB = ' data-width="'.$linkCurArr['linkInLightboxWidth'].'"';
          $curDataAttrHeightLB = ' data-height="'.$linkCurArr['linkInLightboxHeight'].'"';
        }
        $curLinkClass .= '"';
        $linkTagAnfang = '<a href="' . $linkCurArr['link'] . '" target="' . $linkCurArr['linkTarget'] . '"' . $curLinkClass . $curDataAttrWidthLB . $curDataAttrHeightLB .'>';
        $linkTagEnde = '</a>';
        $linkFarbAusgabeClass = ' vLinkStateAktiv';
      }
    }
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
      $linkTagAnfang = '';
      $linkTagEnde = '';
    }
    // *******************************************************************
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      $return .= '<div class="vSiteElemBoxBearLeisteBildChange" title="Bearbeiten" id="elemBeID-' . $siteElementArr['selemID'] . '"></div>';
      $return .= '<div class="vSiteElemBoxBearLeisteBildLink' . $linkFarbAusgabeClass . '" title="Link" id="elemLinkID-' . $siteElementArr['selemID'] . '"></div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        //$return .= '<div class="vSiteElemBoxBearLeisteBildLink' . $linkFarbAusgabeClass . '" title="Link" id="elemLinkID-' . $siteElementArr['selemID'] . '"></div>';
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="vSiteElemBoxBearLeisteBildSave" title="Speichern" id="elemSaveID-' . $siteElementArr['selemID'] . '"></div>
                <div class="vSiteElemBoxBearLeisteBildCancel" title="Abbrechen"></div>
                <div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">';
    $return .= '<div class="vSiteBildElementHolder" style="width:' . $bildWidth . ';">';
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
      $return .= '<input type="hidden" name="vFrontElemPicVal-' . $siteElementArr['selemID'] . '" id="vFrontElemPicVal-' . $siteElementArr['selemID'] . '" value="' . $siteElementArr['selemInhalt'] . '" />';
      $return .= '<div class="vFrontSiteBildElementButtonNew" data-id="' . $siteElementArr['selemID'] . '">Bild ändern</div>';
    }
    
    // MM - 27.04.2014
    // Richtigen Inhalt für Sprache ausgeben ***********************************
    $curBildFromElem = $siteElementArr['selemInhalt'];
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curBildFromElem = $this->buildElementBildOnLang($siteElementArr);
    }
    
    if (isset($curBildFromElem) && !empty($curBildFromElem)) {
      $picOnceArr = $this->getPicArrById($curBildFromElem);
      if (isset($picOnceArr['bildFile']) && !empty($picOnceArr['bildFile'])) {
        $thumbVar = '';
        if (file_exists('user_upload/thumb_800/'.$picOnceArr['bildFile'])) {
          $thumbVar = 'thumb_800/';
        }
        $return .= $linkTagAnfang.'<img src="user_upload/' . $thumbVar . $picOnceArr['bildFile'] . '" alt="' . $picOnceArr['bildAlt'] . '" title="' . $picOnceArr['bildTitel'] . '" />'.$linkTagEnde;
      }
      else {
        $return .= $linkTagAnfang.'<img src="admin/img/noImg.png" alt="NoImg" title="" />'.$linkTagEnde;
      }
    }
    else {
      $return .= $linkTagAnfang.'<img src="admin/img/noImg.png" alt="NoImg" title="" />'.$linkTagEnde;
    }
    // *************************************************************************
    $return .= '</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildElementBildSlider($siteElementArr, $elementArr) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
        $return .= '<div class="vSiteElemBoxBearLeisteElemPicGal" title="Bilder auswahl" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">
              <div class="vSiteBildSlideElementHolder">
                <div class="vSiteBildSlideElementSliderPrev" id="vSiteBildSlideElementSliderPrev-'.$siteElementArr['selemID'].'"></div>
                <div class="vSiteBildSlideElementSliderNext" id="vSiteBildSlideElementSliderNext-'.$siteElementArr['selemID'].'"></div>
                <div class="vSiteBildSlideElementHolderSlider" data-id="'.$siteElementArr['selemID'].'">'.$this->buildBildSliderElementAusgabe($siteElementArr).'</div>
              </div>
            </div>';
    
    return $return;
  }
  
  
  
  private function buildElementSpalten($siteElementArr, $elementArr, $isReload) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteSetting" title="Einstellungen" id="elemSettingID-' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div></div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">';
    
    $rowCount = 2;
    if (isset($siteElementArr['selemConfig']) && !empty($siteElementArr['selemConfig'])) {
      $jsonObjSpalten = json_decode($siteElementArr['selemConfig']);
      $rowCount = $jsonObjSpalten->{'rowCount'};
    }
    for($ii = 1; $ii <= $rowCount; $ii++) {
      $return .= '<div class="vSiteElemSpalteRow vSiteElemSpalteRow' . $rowCount . '" data-row="' . $ii . '">';
      $return .= $this->getSpaltenAusgabe($siteElementArr, $elementArr, $ii, $isReload);
      $return .= '</div>';
    }
    
    $return .= '<div class="clearer"></div>
            </div>';
    
    return $return;
  }
  
  
  
  private function buildElementAlias($siteElementArr, $elementArr) {
    $return = '';
    
    // Element Ausgabe wenn User nicht eingelogt ist oder keine Rechte hat
    // *************************************************************************
    if (!checkIsUserLogedIn() || !checkIndividualUserRechtChange()) {
      if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
        $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($siteElementArr['selemInhalt']) . ' LIMIT 1';
        $sqlErg = $this->dbAbfragen($sqlText);

        while($rowEE = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          $curElemArr = $this->getCurElementArrayLoad($rowEE['elemID']);
          // ************************************************************************************
          $return .= $this->buildElementInhaltLoad($rowEE, $curElemArr, false, $siteElementArr); // letzter Parameter ist nur für Verknüpfungselement
          // ************************************************************************************
        }
      }
      
      return $return;
    }
    // *************************************************************************
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
        
        $return .= '<div class="vSiteElemBoxBearLeisteElemPicGal" data-id="' . $siteElementArr['selemID'] . '" title="Bilder Galerie"></div>';
        
        if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
          $return .= '<a class="vElemAliasElemLinkButtonArrow" title="Zur Element Seite" href="'.$this->buildElementAliasLinkToSite($siteElementArr['selemInhalt']).'"></a>';
        }
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div></div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">
              <div class="vSiteAliasElementHolder" style="min-height:40px; background-color:#CCC;">';
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<input class="vcmsCurAliasInputField" type="hidden" name="vFrontElemAliasVal-' . $siteElementArr['selemID'] . '" id="vFrontElemAliasVal-' . $siteElementArr['selemID'] . '" value="' . $siteElementArr['selemInhalt'] . '" />';
        $return .= '<div class="vFrontSiteAliasElementButtonNew" data-id="' . $siteElementArr['selemID'] . '">Verknüpfung ändern</div>';
        $noPicc = 'no';
        if (isset($siteElementArr['selemPicOnce']) && !empty($siteElementArr['selemPicOnce'])) {
          $picAliasOnceArr = $this->getPicArrById($siteElementArr['selemPicOnce']);
          if (isset($picAliasOnceArr) && is_array($picAliasOnceArr)) {
            $noPicc = 'yes';
            $thumbAliasVar = '';
            if (file_exists('user_upload/thumb_200/'.$picAliasOnceArr['bildFile'])) {
              $thumbAliasVar = 'thumb_200/';
            }
            $return .= '<div class="vFrontSiteAliasElementButtonNewBild1" data-id="' . $siteElementArr['selemID'] . '">Bild 1 ändern</div>';
            $return .= '<div class="vFrontSiteAliasElementBildHolderMM" data-id="'.$siteElementArr['selemPicOnce'].'"><img src="user_upload/'.$thumbAliasVar.$picAliasOnceArr['bildFile'].'" alt="" title="" /><div class="vFrontSiteAliasElementBildDelMM">Bild löschen</div></div>';
          }
        }
        if (isset($noPicc) && $noPicc == 'no') {
          $return .= '<div class="vFrontSiteAliasElementButtonNewBild1" data-id="' . $siteElementArr['selemID'] . '">Bild 1 hinzufügen</div>';
          $return .= '<div class="vFrontSiteAliasElementBildHolderMM" data-id=""></div>';
        }
      }
    }
    $return .= '<div style="height:1px;"></div>';
    
    $aliasCount = 0;
    
    // *************************************************************************
    if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
      $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($siteElementArr['selemInhalt']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);

      while($rowEE = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $aliasCount++;
        $curElemArr = $this->getCurElementArrayLoad($rowEE['elemID']);
        //$return .= $this->buildElementInhaltLoad($rowEE, $curElemArr, false);
        $return .= '<div class="vFrontCurAliasElementInfoA">Verknüpft (Seiten Element ID: '.$rowEE['selemID'].')<br />Element Name: '.$curElemArr['elemName'].'</div><div style="height:10px;"></div>';
      }
    }
    // *************************************************************************
    
    if (isset($aliasCount) && $aliasCount == 0) {
      $return .= '<div class="vFrontCurAliasElementInfoA">Kein Element verknüpft</div><div style="height:10px;"></div>';
    }
    
    $return .= '</div>
            </div>';
    
    return $return;
  }
  
  
  
  private function buildElementAliasLinkToSite($selemID) {
    $return = '#';
    
    $sqlText = 'SELECT seitID FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);

    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlText2 = 'SELECT seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($row['seitID']) . ' LIMIT 1';
      $sqlErg2 = $this->dbAbfragen($sqlText2);
      while($row2 = mysql_fetch_array($sqlErg2, MYSQL_ASSOC)) {
        return $row2['seitTextUrl'];
      }
    }
    
    return $return;
  }
  
  
  
  
  private function buildElementKontaktFormular($siteElementArr, $elementArr) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">';
    
    if ($this->checkIsThisModuleActive('kontaktFormularBuilderModul')) {
    
      if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
        $return .= '<div class="vSiteKontaktFormChangeElementHolder" style="min-height:40px; background-color:#CCC;">';
        $return .= '<div style="height:1px;"></div>';

        $return .= '<div class="vFrontSiteKontaktFormElementButtonNewMM" data-id="' . $siteElementArr['selemID'] . '">Kontaktformular auswählen</div>';
          $contactFormCount = 0;

          // *************************************************************************
          if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
            $sqlText = 'SELECT * FROM vkontaktformulare WHERE koID = "' . $this->dbDecode($siteElementArr['selemInhalt']) . '" LIMIT 1';
            $sqlErg = $this->dbAbfragen($sqlText);

            while($rowKK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
              $contactFormCount++;
              $return .= '<div class="vFrontCurAliasElementInfoA">Kontaktformular Name: &nbsp;'.$rowKK['koName'].'</div><div style="height:10px;"></div>';
            }
          }
          // *************************************************************************

          if (isset($contactFormCount) && $contactFormCount == 0) {
            $return .= '<div class="vFrontCurAliasElementInfoA">Es ist kein Kontaktformular ausgewählt</div><div style="height:10px;"></div>';
          }
        $return .= '</div>';
      }
      else {
        $contactFormCount = 0;
        $allKonatktDataArr = '';

        if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
          $sqlText = 'SELECT * FROM vkontaktformulare WHERE koID = "' . $this->dbDecode($siteElementArr['selemInhalt']) . '" LIMIT 1';
          $sqlErg = $this->dbAbfragen($sqlText);

          while($rowKK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
            $contactFormCount++;
            $allKonatktDataArr = $rowKK;
          }
        }

        if (isset($contactFormCount) && $contactFormCount > 0) {
          $return .= $this->buildKonatktFormularAusgabeNowMM($allKonatktDataArr);
        }
      }
      
    }
    else {
      $return .= '<div style="background-color:#990000; color:#FFFFFF; padding:6px;">Fehler:&nbsp;&nbsp;&nbsp;Das Kontaktformular Modul ist nicht installiert.</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildElementEmpfehlungsManagerEmpfehler($siteElementArr, $elementArr) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">';
    
    if ($this->checkIsThisModuleActive('empfehlungManagerModul')) {
      $return .= $this->buildEmpfehlungsManagerEmpfehlerFormsNow();
    }
    else {
      $return .= '<div style="background-color:#990000; color:#FFFFFF; padding:6px;">Fehler:&nbsp;&nbsp;&nbsp;Das Empfehlungs Manager Modul ist nicht installiert.</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildElementEmpfehlungsManagerGeschenkeTextInfo($siteElementArr, $elementArr) {
    $return = '';
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div>
              </div>';
    }
    
    
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    $return .= '<div class="vSiteElemBoxInhalt">';
    
    if ($this->checkIsThisModuleActive('empfehlungManagerModul')) {
      $return .= $this->buildEmpfehlungsManagerGeschenkeInfoTextNow();
    }
    else {
      $return .= '<div style="background-color:#990000; color:#FFFFFF; padding:6px;">Fehler:&nbsp;&nbsp;&nbsp;Das Empfehlungs Manager Modul ist nicht installiert.</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }

    // ***************************************************************************
  // ENDE - Funktionen für einzelne Elemente Ausgaben
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Spalten Element Ausgabe
  // ***************************************************************************
  
  private function getSpaltenAusgabe($siteElementArr, $elementArr, $curRowID, $isReload) {
    $return = '';
    $droppableSpaltenCount = 1;
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vFrontSpaltenElementDroppable vFrontDroppableEmpty" data-count="' . $droppableSpaltenCount . '"></div>';
    }
    
    if (isset($siteElementArr['selemInhalt']) && !empty($siteElementArr['selemInhalt'])) {
      $jsonObjRowElems = json_decode($siteElementArr['selemInhalt']);
      
      if (isset($jsonObjRowElems->$curRowID)) {
        $curSpaltenElems = explode(';', $jsonObjRowElems->$curRowID);
        foreach ($curSpaltenElems as $curSelemID) {
          $droppableSpaltenCount++;
          $returnElem = $this->getCurSpaltenElemNow($curSelemID, $isReload);
          $return .= $returnElem;
          
          if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && !empty($returnElem) && $this->areElementsInherit == false) {
            $return .= '<div class="vFrontSpaltenElementDroppable vFrontDroppableEmpty" data-count="' . $droppableSpaltenCount . '"></div>';
          }
          if (empty($returnElem)) {
            $droppableSpaltenCount--;
          }
        }
      }
    }
    
    return $return;
  }
  
  
  
  private function getCurSpaltenElemNow($curSelemID, $isReload) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "' . $this->dbDecode($curSelemID) . '" ORDER BY selemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowEl = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curElemArr = $this->getCurElementArrayLoad($rowEl['elemID']);
      $return .= $this->buildElementInhaltLoad($rowEl, $curElemArr, $isReload);
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Spalten Element Ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Spalten Einstellungen
  // ***************************************************************************
  
  public function showSpaltenSettingsNow($curSelemID) {
    $return = '';
    $settingArrJSON = $this->getSpaltenSettingJSON($curSelemID);
    
    $return .= '<div class="vSpaltenSettingFrmHolder">
              <label for="vSpaltenAnzahlDropDown">Spalten:</label>
              <select name="vSpaltenAnzahlDropDown" id="vSpaltenAnzahlDropDown">';
    for ($ii = 2; $ii <= 6; $ii++) {
      if (isset($settingArrJSON['rowCount']) && $settingArrJSON['rowCount'] == $ii) {
        $return .= '<option selected="selected" value="' . $ii . '">' . $ii . '</option>';
      }
      else {
        $return .= '<option value="' . $ii . '">' . $ii . '</option>';
      }
    }
    $return .= '</select>';
    $return .= '<div class="vFrmSettingAbstand"></div>';
    $return .= '<input type="submit" value="Speichern" id="vSaveSpaltenSettings" data-id="' . $curSelemID . '" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getSpaltenSettingJSON($curSelemID) {
    $sqlSettText = 'SELECT selemConfig FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($curSelemID) . ' LIMIT 1';
    $sqlSettErg = $this->dbAbfragen($sqlSettText);
    $return = array();
    
    while ($rowSett = mysql_fetch_array($sqlSettErg, MYSQL_ASSOC)) {
      if (isset($rowSett['selemConfig']) && !empty($rowSett['selemConfig'])) {
        $return = json_decode($rowSett['selemConfig'], true);
      }
    }
    
    return $return;
  }
  
  
  
  public function saveSpaltenSettingsNow($curSelemID, $curSpalten) {
    $sqlSaveText = 'UPDATE vseitenelemente SET selemConfig = "{\"rowCount\":\"' . $this->dbDecode($curSpalten) . '\"}" WHERE selemID = ' . $this->dbDecode($curSelemID);
    $sqlSaveErg = $this->dbAbfragen($sqlSaveText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Spalten Einstellungen
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Bild Element speichern
  // ***************************************************************************
  
  public function saveNewBildInElement($selemID, $bildID) {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      return $this->saveBildInBildElementOnLang($selemID, $langId, $bildID);
    }
    else {
      $sqlSaveText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($bildID) . '" WHERE selemID = ' . $this->dbDecode($selemID);
      return $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  private function saveBildInBildElementOnLang($selemID, $langId, $bildID) {
    if ($this->checkElementHasDataLang($selemID, $langId)) {
      return $this->saveBildInBildElementOnLangUpdate($selemID, $langId, $bildID);
    }
    else {
      return $this->saveBildInBildElementOnLangNew($selemID, $langId, $bildID);
    }
  }
  
  
  private function saveBildInBildElementOnLangUpdate($selemID, $langId, $bildID) {
    $sqlUpText = 'UPDATE vselemlang SET selangInhalt = "' . $this->dbDecode($bildID) . '" WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlUpText);
  }
  
  
  private function saveBildInBildElementOnLangNew($selemID, $langId, $bildID) {
    $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangInhalt) VALUES (' . $this->dbDecode($selemID) . ', ' . $this->dbDecode($langId) . ', "' . $this->dbDecode($bildID) . '")';
    return $this->dbAbfragen($sqlNewText);
  }
  
  
  
  
  
  public function saveBildElemResizeNow($selemID, $selemBildWidth) {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      return $this->saveBildConfigInBildElementOnLang($selemID, $langId, $selemBildWidth);
    }
    else {
      $sqlSaveText = 'UPDATE vseitenelemente SET selemConfig = "{\"width\":\"' . $this->dbDecode($selemBildWidth) . '\"}" WHERE selemID = ' . $this->dbDecode($selemID);
      return $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  private function saveBildConfigInBildElementOnLang($selemID, $langId, $selemBildWidth) {
    if ($this->checkElementHasDataLang($selemID, $langId)) {
      return $this->saveBildConfigInBildElementOnLangUpdate($selemID, $langId, $selemBildWidth);
    }
    else {
      return $this->saveBildConfigInBildElementOnLangNew($selemID, $langId, $selemBildWidth);
    }
  }
  
  
  private function saveBildConfigInBildElementOnLangUpdate($selemID, $langId, $selemBildWidth) {
    $sqlUpText = 'UPDATE vselemlang SET selangConfig = "{\"width\":\"' . $this->dbDecode($selemBildWidth) . '\"}" WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlUpText);
  }
  
  
  private function saveBildConfigInBildElementOnLangNew($selemID, $langId, $selemBildWidth) {
    $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangConfig) VALUES (' . $this->dbDecode($selemID) . ', ' . $this->dbDecode($langId) . ', "{\"width\":\"' . $this->dbDecode($selemBildWidth) . '\"}")';
    return $this->dbAbfragen($sqlNewText);
  }

    // ***************************************************************************
  // ENDE - Funktionen Bild Element speichern
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Text Element speichern
  // ***************************************************************************
  
  public function saveTextInTextElement($selemID, $curText) {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      return $this->saveTextInTextElementOnLang($selemID, $langId, $curText);
    }
    else {
        
       $this->saveSearchContent(null, $this->dbDecode($selemID), $this->dbDecode($curText));   
      $sqlSaveText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($curText) . '" WHERE selemID = ' . $this->dbDecode($selemID);
      return $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  private function saveTextInTextElementOnLang($selemID, $langId, $curText) {
       $this->saveSearchContent(null, $selemID, $this->dbDecode($curText),$langId); 
 
      if ($this->checkElementHasDataLang($selemID, $langId)) {
      return $this->saveTextInTextElementOnLangUpdate($selemID, $langId, $curText);
    }
    else {
      return $this->saveTextInTextElementOnLangNew($selemID, $langId, $curText);
    }
  }
  
  
  private function saveTextInTextElementOnLangUpdate($selemID, $langId, $curText) {
    $sqlUpText = 'UPDATE vselemlang SET selangInhalt = "' . $this->dbDecode($curText) . '" WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlUpText);
  }
  
  
  private function saveTextInTextElementOnLangNew($selemID, $langId, $curText) {
    $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangInhalt) VALUES (' . $this->dbDecode($selemID) . ', ' . $this->dbDecode($langId) . ', "' . $this->dbDecode($curText) . '")';
    return $this->dbAbfragen($sqlNewText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Text Element speichern
  // ***************************************************************************
  
  
  
  
  
  
  private function getPicArrById($picId) {
    $return = array();
    $sqlPicText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($picId) . ' LIMIT 1';
    $sqlPicErg = $this->dbAbfragen($sqlPicText);
    while ($rowPic = mysql_fetch_array($sqlPicErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für eigene Elemente Ausgaben
  // ***************************************************************************
  
  private function getEigenElementAusgabe($siteElementArr, $elementArr, $curAbsPathTemp, $isReload, $isAliasElemPicArrays = '') {
    $return = '';
    
    // MM - 10.04.2014
    // Link anzeigen wenn vorhanden **************************************
    $linkTagAnfang = '';
    $linkTagEnde = '';
    $linkFarbAusgabeClass = '';
    
    $curElemLinkJson = $siteElementArr['selemLink'];
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curElemLinkJson = $this->getElementLangLinkOwnMM($siteElementArr);
    }
   
    if (isset($curElemLinkJson) && !empty($curElemLinkJson)) {
      $linkCurArr = json_decode($curElemLinkJson, true);
      $linkCurArr = $this->getTheCurentLinkArtFromElementNow($linkCurArr);
      if (isset($linkCurArr['link']) && !empty($linkCurArr['link'])) {
        $curDataAttrWidthLB = '';
        $curDataAttrHeightLB = '';
        $curLinkClass = ' class="';
        if (isset($linkCurArr['linkClass']) && !empty($linkCurArr['linkClass'])) {
          $curLinkClass .= $linkCurArr['linkClass'];
        }
        if (isset($linkCurArr['linkIsInLightbox']) && $linkCurArr['linkIsInLightbox'] == 'on') {
          $curLinkClass .= ' vcmsLinkingLightboxElemShowMMa';
          $curDataAttrWidthLB = ' data-width="'.$linkCurArr['linkInLightboxWidth'].'"';
          $curDataAttrHeightLB = ' data-height="'.$linkCurArr['linkInLightboxHeight'].'"';
        }
        $curLinkClass .= '"';
        
        /*$curLinkClass = '';
        if (isset($linkCurArr['linkClass']) && !empty($linkCurArr['linkClass'])) {
          $curLinkClass = ' class="'.$linkCurArr['linkClass'].'"';
        }*/
        $linkTagAnfang = '<a href="' . $linkCurArr['link'] . '" target="' . $linkCurArr['linkTarget'] . '"' . $curLinkClass . $curDataAttrWidthLB . $curDataAttrHeightLB .'>';
        $linkTagEnde = '</a>';
        $linkFarbAusgabeClass = ' vLinkStateAktiv';
      }
    }
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange()) {
      $linkTagAnfang = '';
      $linkTagEnde = '';
    }
    // *******************************************************************
    
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemBoxBearLeiste" title="Element ID: '.$siteElementArr['selemID'].'">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        if (isset($siteElementArr['selemInElement']) && !empty($siteElementArr['selemInElement'])) {
          $return .= '<div class="vSiteElemBoxBearLeisteInSpalteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
        else {
          $return .= '<div class="vSiteElemBoxBearLeisteDel" title="Löschen" id="elemDelID-' . $siteElementArr['selemID'] . '"></div>';
        }
      }
      $return .= '<div class="vSiteElemBoxBearLeisteEigenElemLink ' . $linkFarbAusgabeClass . '" title="Link" id="elemLinkID-' . $siteElementArr['selemID'] . '"></div>';
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        //$return .= '<div class="vSiteElemBoxBearLeisteEigenElemLink ' . $linkFarbAusgabeClass . '" title="Link" id="elemLinkID-' . $siteElementArr['selemID'] . '"></div>';
        $return .= '<div class="vSiteElemBoxBearLeisteElemCopy" title="Kopieren" data-id="' . $siteElementArr['selemID'] . '"></div>';
        $return .= '<div class="vSiteElemBoxBearLeisteElemPicGal" title="Bilder Galerie" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if ($this->checkIsElementOnAliasElement($siteElementArr)) {
        $return .= '<div class="vSiteElemBoxBearLeisteElemAliasMoreInfo" title="Verknüpfungs Seiten anzeigen" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<div class="vSiteElemBoxBearLeisteOwnSettingElem" title="Einstellungen" data-sart="own" data-id="' . $siteElementArr['selemID'] . '"></div>';
      }
      $return .= '<div class="clearer"></div></div>';
    }
    
  
    // Wenn Element vererbert wird
    // *************************************************************************
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == true) {
      $curLangParam = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangParam = $_POST['VCMS_POST_LANG'].'/';
      }
      $return .= '<div class="vSiteElemBoxBearLeiste">
                <div class="vSiteElemBoxBearLeisteUe">' . $elementArr['elemName'] . '</div>
                <a class="vElemInheritButtonArrow" href="'.$curLangParam.$this->getTheTextUrlFromSiteByID($siteElementArr['seitID']).'" title="Zur Seite Navigieren"></a>
                <div class="vElemInheritButtonInfo">(vererbt)</div>
              </div>';
    }
    // *************************************************************************
    
    
    if (isset($curAbsPathTemp) && !empty($curAbsPathTemp)) {
      
      // --------------------------------------------------------------------
      // Pfad muss in folgenden Dateien geändert werden:
      // --------------------------------------------------------------------
      // admin/inc/klassen/hp_settings.inc.php  ($curentElementsPath)
      // admin/inc/klassen/elemente_self.inc.php  ($curCentralElementsPath)
      // index.php  ($curCentralElementsPathIndex)
      // --------------------------------------------------------------------
      //$curCentralElementsPath = '/var/www/vhosts/default/htdocs/cmsCentralElems/';
      $curCentralElementsPath = '/home/xyganvvx/cmsCentralElems/';
      
      $reloadPath = '';
      if (isset($isReload) && $isReload == true) {
        $reloadPath = '../../../';
      }
      $reloadPath = $_SERVER['DOCUMENT_ROOT'].'/';
      
      if (isset($elementArr['elemFile']) && 
          file_exists($reloadPath.$curAbsPathTemp . 'elemente/' . $elementArr['elemFile']) && 
          empty($elementArr['elemCentralFolder'])) {
        
        // Eigenes Element Drag & Drop
        // *********************************************************************
        include_once($reloadPath.'admin/inc/klassen/ownElement.inc.php');
        $thisElemObj = new ownElementsClass($siteElementArr);
        // *********************************************************************
         
        $thisElemArr = $this->buildEigenElementArr($siteElementArr, $elementArr, $isAliasElemPicArrays);
       
        $return .= $linkTagAnfang.'<div>';
        ob_start();
        include($reloadPath.$curAbsPathTemp . 'elemente/' . $elementArr['elemFile']);
        $return .= ob_get_contents();
        ob_end_clean();
        $return .= '</div>'.$linkTagEnde;
      }
      // Zentrale Elemente setzen
      // ***********************************************************************
      else if ((isset($elementArr['elemCentralFolder']) && !empty($elementArr['elemCentralFolder'])) && 
              file_exists($curCentralElementsPath . $elementArr['elemCentralFolder'] . '/' . $elementArr['elemFile'])) {
         
        // Eigenes Element Drag & Drop
        // *********************************************************************
        include_once($reloadPath.'admin/inc/klassen/ownElement.inc.php');
        $thisElemObj = new ownElementsClass($siteElementArr);
        // *********************************************************************
        
        $thisElemArr = $this->buildEigenElementArr($siteElementArr, $elementArr, $isAliasElemPicArrays);
        $return .= $linkTagAnfang.'<div>';
        ob_start();
        include($curCentralElementsPath . $elementArr['elemCentralFolder'] . '/' . $elementArr['elemFile']);
        $return .= ob_get_contents();
        ob_end_clean();
        $return .= '</div>'.$linkTagEnde;
      }
      // ***********************************************************************
      else {
        $return .= '<div style="background-color:#990000; color:#FFFFFF; padding:6px;">Error:&nbsp;&nbsp;&nbsp;Element Datei nicht gefunden.</div>';
      }
    }
    
    return $return;
  }
  
  
  
  private function buildEigenElementArr($siteElementArr, $elementArr, $isAliasElemPicArrays = '') {
    $return = array();
    
    // MM - 28.04.2014
    // Richtigen Inhalt für Sprache ausgeben ***********************************
    $curArr = json_decode($siteElementArr['selemInhalt'], true);
    $curArrOrigLang = $curArr;
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLangBack = $this->buildEigenElementOnLang($siteElementArr);
      $curArr = json_decode($curLangBack, true);
    }
    // *************************************************************************
    
    $return['bild1'] = $this->buildEigenElementPic(1, $curArr['elemBild1'], $curArr['elemBildLink1'], $siteElementArr, $curArrOrigLang, $isAliasElemPicArrays);
    $return['bild2'] = $this->buildEigenElementPic(2, $curArr['elemBild2'], $curArr['elemBildLink2'], $siteElementArr, $curArrOrigLang);
    $return['bild3'] = $this->buildEigenElementPic(3, $curArr['elemBild3'], $curArr['elemBildLink3'], $siteElementArr, $curArrOrigLang);
    $return['bild4'] = $this->buildEigenElementPic(4, $curArr['elemBild4'], $curArr['elemBildLink4'], $siteElementArr, $curArrOrigLang);
    $return['bild5'] = $this->buildEigenElementPic(5, $curArr['elemBild5'], $curArr['elemBildLink5'], $siteElementArr, $curArrOrigLang);
    $return['bild6'] = $this->buildEigenElementPic(6, $curArr['elemBild6'], $curArr['elemBildLink6'], $siteElementArr, $curArrOrigLang);
    $return['bild7'] = $this->buildEigenElementPic(7, $curArr['elemBild7'], $curArr['elemBildLink7'], $siteElementArr, $curArrOrigLang);
    $return['bild8'] = $this->buildEigenElementPic(8, $curArr['elemBild8'], $curArr['elemBildLink8'], $siteElementArr, $curArrOrigLang);
    
    $return['text1'] = $this->buildEigenElementText(1, $curArr['elemText1'], $siteElementArr, $curArrOrigLang);
    $return['text2'] = $this->buildEigenElementText(2, $curArr['elemText2'], $siteElementArr, $curArrOrigLang);
    $return['text3'] = $this->buildEigenElementText(3, $curArr['elemText3'], $siteElementArr, $curArrOrigLang);
    $return['text4'] = $this->buildEigenElementText(4, $curArr['elemText4'], $siteElementArr, $curArrOrigLang);
    $return['text5'] = $this->buildEigenElementText(5, $curArr['elemText5'], $siteElementArr, $curArrOrigLang);
    $return['text6'] = $this->buildEigenElementText(6, $curArr['elemText6'], $siteElementArr, $curArrOrigLang);
    $return['text7'] = $this->buildEigenElementText(7, $curArr['elemText7'], $siteElementArr, $curArrOrigLang);
    $return['text8'] = $this->buildEigenElementText(8, $curArr['elemText8'], $siteElementArr, $curArrOrigLang);
    
    $return['picGal'] = $this->buildEigenElementPicGalArr($siteElementArr, false, $isAliasElemPicArrays);
    $return['picGalFullHD'] = $this->buildEigenElementPicGalArr($siteElementArr, true, $isAliasElemPicArrays);
    
    $return['elemData'] = array();
    $return['elemData']['selemID'] = $siteElementArr['selemID'];
    $return['elemData']['seitID'] = $siteElementArr['seitID'];
    $return['elemData']['elemID'] = $siteElementArr['elemID'];
    $return['elemData']['selemDataName'] = $siteElementArr['selemDataName'];
    
    $return['elemSettings'] = $this->buildOwnElemSettingsArrayUser($siteElementArr, $elementArr);
    
    return $return;
  }
  
  
  
  private function buildOwnElemSettingsArrayUser($siteElementArr, $elementArr) {
    $return = array();
    
    if (isset($elementArr['elemOwnConfig']) && !empty($elementArr['elemOwnConfig'])) {
      $elemConfArr = json_decode($elementArr['elemOwnConfig'], true);
      $sElemConfArr = '';
      if (isset($siteElementArr['selemOwnConfig']) && !empty($siteElementArr['selemOwnConfig'])) {
        $sElemConfArr = json_decode($siteElementArr['selemOwnConfig'], true);
      }
      foreach ($elemConfArr as $key => $value) {
        $curVal = '';
        if (isset($sElemConfArr['vOwnUserSettings'][$key]) && !empty($sElemConfArr['vOwnUserSettings'][$key])) {
          $curVal = $sElemConfArr['vOwnUserSettings'][$key];
        }
        $return[$key] = $curVal;
      }
    }
    
    return $return;
  }
  
  
  
  private function buildEigenElementPic($bildNum, $bild, $bildLink, $siteElementArr, $curArrOrigLang, $isAliasElemPicArrays = '') {
    $noOutlineClass = '';
    if (isset($this->areElementsInherit) && $this->areElementsInherit == true) {
      $noOutlineClass = ' vCmsShowNoOutlineImportant';
    }
    
    if (isset($bild) && $bild == '[vcms-empty-lang]') {
      $bild = $curArrOrigLang['elemBild'.$bildNum];
    }
    if (isset($bildLink) && $bildLink == '[vcms-empty-lang]') {
      $bildLink = $curArrOrigLang['elemBildLink'.$bildNum];
    }
    $return = '<div class="vFrontOwnElemPicHolder'.$noOutlineClass.'" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $bildNum . '">';
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemPicOwnBearLeiste">
                <div class="vSiteElemPicOwnBearLeisteUe">Bild</div>';
      $return .= '<div class="vSiteElemPicOwnBearLeisteDel" title="Bild Löschen" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $bildNum . '"></div>';
      //$return .= '<div class="vSiteElemPicOwnBearLeisteLink" title="Link" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $bildNum . '"></div>';
      $return .= '</div>';
      
      $return .= '<div class="vFrontOwnElemPicButtonNew">Bild ändern</div>';
    }
    
    // Bild von Verknüpfungselement verwenden wenn vorhanden
    // *************************************************************************
    if (isset($isAliasElemPicArrays['selemPicOnce']) && !empty($isAliasElemPicArrays['selemPicOnce'])) {
      $bild = $isAliasElemPicArrays['selemPicOnce'];
    }
    // *************************************************************************
    
    if (isset($bild) && !empty($bild)) {
      $picArr = $this->getPicArrById($bild);
      $thumbVar = '';
      if (file_exists('user_upload/thumb_800/'.$picArr['bildFile'])) {
        $thumbVar = 'thumb_800/';
      }
      $return .= '<div class="vSiteElemPicOwnInner"><img src="user_upload/' . $thumbVar . $picArr['bildFile'] . '" alt="' . $picArr['bildAlt'] . '" title="' . $picArr['bildTitel'] . '" /></div>';
    }
    else {
      $return .= '<div class="vSiteElemPicOwnInner"><img src="admin/img/noImg.png" alt="NoImg" title="" /></div>';
    }
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildEigenElementText($textNum, $text, $siteElementArr, $curArrOrigLang) {
    $noOutlineClass = '';
    if (isset($this->areElementsInherit) && $this->areElementsInherit == true) {
      $noOutlineClass = ' vCmsShowNoOutlineImportant';
    }
    
    if (isset($text) && $text == '[vcms-empty-lang]') {
      $text = $curArrOrigLang['elemText'.$textNum];
    }
    $return = '<div class="vFrontOwnElemTextHolder'.$noOutlineClass.'" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $textNum . '">';
    if (checkIsUserLogedIn() && checkIndividualUserRechtChange() && $this->areElementsInherit == false) {
      $return .= '<div class="vSiteElemTextOwnBearLeiste">
                <div class="vSiteElemTextOwnBearLeisteUe">Textfeld</div>
                <div class="vSiteElemTextOwnBearLeisteChange" title="Bearbeiten" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $textNum . '"></div>
                <div class="vSiteElemTextOwnBearLeisteSave" title="Speichern" data-id="' . $siteElementArr['selemID'] . '" data-num="' . $textNum . '"></div>
                <div class="vSiteElemTextOwnBearLeisteCancel" title="Abbrechen"></div>
              </div>';
    }
    $return .= '<div class="vFrontOwnElemTextInner">' . $this->parseTextByHaswh($text) . '</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  private function parseTextByHaswh($text) {
      
      if (checkIsUserLogedIn()){
          return $text;
      }
      
       preg_match_all("/(#\w+)/", $text, $texts);
       $langId = $this->getCurentLangIdFromUrlName($_GET['_lang']);
       
   
       if(!empty($texts[0])){
           foreach($texts[0] as $key => $value){
      
               $hash = $value;
               $query = mysql_query("SELECT * FROM time_hash WHERE name ='$hash'");
               $row   = mysql_fetch_array($query);
               $idHash = $row['id_hash'];
               $currentDate = date('Y-m-d H:i:s');
               $currenTime  = date('H:i a');
               $query = mysql_query("SELECT * FROM `times` WHERE id_th='$idHash' AND from_date<='$currentDate' AND to_date >='$currentDate' AND option_time=2 LIMIT 1");
               
               if(mysql_num_rows($query)){
                   $row   = mysql_fetch_array($query);
                   $idTime = $row['id_t'];
               
                   $query = mysql_query("SELECT * FROM `time_hash_texts` WHERE id_time_ht='$idTime' AND id_lang='$langId' LIMIT 1");
                   $row   = mysql_fetch_array($query);
               
                   $replaceText = $row['title']; 
                   $text = str_replace($value,$replaceText, $text);
               }else{
                 
                  
                  if(date('G') > 21 && date('G') <24){
                      $query = mysql_query("SELECT * FROM `times` WHERE id_th='$idHash' AND DATE_FORMAT(time_only,'%H:%i%p')<='$currenTime' AND DATE_FORMAT(time_to,'%H:%i%p') <'$currenTime' AND option_time=1 order BY time_only desc LIMIT 1");  
                      
                  }elseif(date('G') >=0 && date('G') <=6){
                  
                      // $query = mysql_query("SELECT * FROM `times` WHERE id_th='$idHash'  AND DATE_FORMAT(time_to,'%H:%i%p') >='0:00' AND DATE_FORMAT(time_to,'%H:%i%p') <='6:00' AND option_time=1 order BY time_only desc LIMIT 1"); 
                       
                        $query = mysql_query("SELECT * FROM `times` WHERE id_t='60' "); 
                       
                       
                       
                    if($_GET['test'] == 1){
                        
                      
                         while($row7   = mysql_fetch_assoc($query)){
                             print_r($row7);
                          
                             
                         }
                 
                  echo "SELECT * FROM `times` WHERE id_th='$idHash'  AND DATE_FORMAT(time_to,'%H:%i%p') >='0:00' AND DATE_FORMAT(time_to,'%H:%i%p') <='6:00' AND option_time=1 order BY time_only desc LIMIT 1";  
                  die();
                     
                 }    
                       
                       
                       
                  }else{
                      $query = mysql_query("SELECT * FROM `times` WHERE id_th='$idHash' AND DATE_FORMAT(time_only,'%H:%i%p')<='$currenTime' AND DATE_FORMAT(time_to,'%H:%i%p') >='$currenTime' AND option_time=1 LIMIT 1");  
                      
                  }
                  
               
                   $row   = mysql_fetch_array($query);
                   
                     $idTime = $row['id_t'];
                  
                 if($_GET['test'] == 1){
                     
                     
                     print_r($row);
                  echo $idTime;
                 
                     
                 }
                 
                   
                  $query = mysql_query("SELECT * FROM `time_hash_texts` WHERE id_time_ht='$idTime' AND id_lang='$langId' LIMIT 1");
                   $row   = mysql_fetch_array($query);
                   
                   
               
                   $replaceText = $row['title']; 
                   $text = str_replace($value,$replaceText, $text);
               }
      
               
               

           }
           
      
      }
      
      return $text;
  }
  
  
  
  private function buildEigenElementPicGalArr($curArrOrigLang, $isFullHD = false, $isAliasElemPicArrays = '') {
    $return = array();
    $return['picGalFirstImg'] = '<img src="admin/img/noImg.png" alt="" title="" />';
    $return['picGalAllImgHidden'] = '<div style="display:none;">';
    $return['picGalAllImgHiddenArray'] = array();
    $return['picGalAllImgAusgabeArray'] = array();
    $return['picGalAllImgAusgabeArray_200'] = array();
    $picCount = 0;
    
    // Bilder Galerie von Verknüpfungselement setzen wenn vorhanden
    // *************************************************************************
    if (isset($isAliasElemPicArrays['selemPicGal']) && !empty($isAliasElemPicArrays['selemPicGal'])) {
      $curArrOrigLang['selemPicGal'] = $isAliasElemPicArrays['selemPicGal'];
    }
    // *************************************************************************
    
    // Bilder Galerie Element setzen wenn vorhanden
    // *************************************************************************
    $isPicGalFromElem = 'no';
    $picGalListFromElement = '';
    if (isset($curArrOrigLang['selemPicGal']) && !empty($curArrOrigLang['selemPicGal'])) {
      $picGalListFromElement = $this->getThePicListFromBilderGalerieElement($curArrOrigLang['selemPicGal']);
      if (isset($picGalListFromElement) && !empty($picGalListFromElement)) {
        $isPicGalFromElem = 'ok';
      }
    }
    // *************************************************************************
    
    if ((isset($curArrOrigLang['selemConfig']) && !empty($curArrOrigLang['selemConfig'])) || (isset($isPicGalFromElem) && $isPicGalFromElem == 'ok')) {
      $isFullHDClassNow = '';
      if (isset($isFullHD) && $isFullHD == true) {
        $isFullHDClassNow = 'IsFullHD';
      }
      
      if (isset($isPicGalFromElem) && $isPicGalFromElem == 'ok') {
        $curConfigArr['picGal'] = $picGalListFromElement;
      }
      else {
        $curConfigArr = json_decode($curArrOrigLang['selemConfig'], true);
      }
      if (isset($curConfigArr['picGal']) && !empty($curConfigArr['picGal'])) {
        
        // Prüfen ob Link auf dem Element gesetzt ist
        // *********************************************************************
        $isLinkElem = false;
        if (isset($curArrOrigLang['selemLink']) && !empty($curArrOrigLang['selemLink'])) {
          $curLinkArrCheck = json_decode($curArrOrigLang['selemLink'], true);
          if (isset($curLinkArrCheck['link']) && !empty($curLinkArrCheck['link'])) {
            $isLinkElem = true;
          }
        }
        // *********************************************************************
        
        $listArr = explode(';', $curConfigArr['picGal']);
        foreach ($listArr as $imgId) {
          $sqlTextList = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($imgId) . ' LIMIT 1';
          $sqlErgList = $this->dbAbfragen($sqlTextList);
          while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
            $picThumbCur = '';
            $picThumbCur_200 = '';
            $picCount++;
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$rowList['bildFile'])) {
              $picThumbCur = 'thumb_800/';
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_200/'.$rowList['bildFile'])) {
              $picThumbCur_200 = 'thumb_200/';
            }
            
            if (isset($isLinkElem) && $isLinkElem == true) {
              if (isset($picCount) && $picCount == 1) {
                $return['picGalFirstImg'] = '<img src="user_upload/'.$picThumbCur.$rowList['bildFile'].'" alt="" title="" />';
              }
              else {
                $return['picGalAllImgHidden'] .= '';
              }
              $return['picGalAllImgHiddenArray'][$picCount-1] = '';
              $return['picGalAllImgAusgabeArray'][$picCount-1] = '<img src="user_upload/'.$picThumbCur.$rowList['bildFile'].'" alt="" title="" />';
              $return['picGalAllImgAusgabeArray_200'][$picCount-1] = '<img src="user_upload/'.$picThumbCur_200.$rowList['bildFile'].'" alt="" title="" />';
            }
            else {
              if (isset($picCount) && $picCount == 1) {
                $return['picGalFirstImg'] = '<a class="ownElemPicGalerieLinkClass'.$isFullHDClassNow.' ownElemPicGalerieLinkClassFirstImgNow'.$curArrOrigLang['selemID'].'" rel="galElem'.$curArrOrigLang['selemID'].'" href="user_upload/'.$rowList['bildFile'].'" title="'.$rowList['bildTitel'].'"><img src="user_upload/'.$picThumbCur.$rowList['bildFile'].'" alt="" title="" /></a>';
              }
              else {
                $return['picGalAllImgHidden'] .= '<a class="ownElemPicGalerieLinkClass'.$isFullHDClassNow.'" rel="galElem'.$curArrOrigLang['selemID'].'" href="user_upload/'.$rowList['bildFile'].'" title="'.$rowList['bildTitel'].'">pic</a>';
              }
              $return['picGalAllImgHiddenArray'][$picCount-1] = '<a class="ownElemPicGalerieLinkClass'.$isFullHDClassNow.'" rel="galElem'.$curArrOrigLang['selemID'].'" href="user_upload/'.$rowList['bildFile'].'" title="'.$rowList['bildTitel'].'">pic</a>';
              $return['picGalAllImgAusgabeArray'][$picCount-1] = '<a class="ownElemPicGalerieLinkClass'.$isFullHDClassNow.'" rel="galElem'.$curArrOrigLang['selemID'].'" href="user_upload/'.$rowList['bildFile'].'" title="'.$rowList['bildTitel'].'"><img src="user_upload/'.$picThumbCur.$rowList['bildFile'].'" alt="" title="" /></a>';
              $return['picGalAllImgAusgabeArray_200'][$picCount-1] = '<a class="ownElemPicGalerieLinkClass'.$isFullHDClassNow.'" rel="galElem'.$curArrOrigLang['selemID'].'" href="user_upload/'.$rowList['bildFile'].'" title="'.$rowList['bildTitel'].'"><img src="user_upload/'.$picThumbCur_200.$rowList['bildFile'].'" alt="" title="" /></a>';
            }
          }
        }
      }
    }
    
    $return['picGalAllImgHidden'] .= '</div>';
    
    return $return;
  }
  
  
  
  private function getThePicListFromBilderGalerieElement($picGalId) {
    $return = '';
    
    $sqlText = 'SELECT galBilder FROM vbildergalerien WHERE galID = ' . $this->dbDecode($picGalId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= $row['galBilder'];
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für eigene Elemente Ausgaben
  // ***************************************************************************
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für eigene Elemente Speichern
  // ***************************************************************************
  
  public function saveElemOwnElemTextNow($elemID, $elemNum, $elemInhalt) {
    $elemInhaltArr = array();
    $elemInhaltOrig = '';
    
    $sqlElText = 'SELECT selemInhalt,seitID FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($elemID) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while ($rowEl = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $elemInhaltOrig = $rowEl['selemInhalt'];
      $idSite         = $rowEl['seitID'];  
    }
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      return $this->saveTextInOwnTextElementOnLang($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig);
    }
    else {
      $elemInhaltArr = json_decode($elemInhaltOrig, true);
      $this->saveSearchContent($this->dbDecode($idSite), $this->dbDecode($elemID), $elemInhaltArr);

      $elemInhaltArr['elemText'.$elemNum] = $elemInhalt;

      $elemInhaltJson = json_encode($elemInhaltArr);

      $sqlSaveText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($elemInhaltJson) . '" WHERE selemID = ' . $this->dbDecode($elemID);
      return $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  private function saveTextInOwnTextElementOnLang($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig) {
    if ($this->checkElementHasDataLang($elemID, $langId)) {
      return $this->saveTextInOwnTextElementOnLangUpdate($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig);
    }
    else {
      return $this->saveTextInOwnTextElementOnLangNew($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig);
    }
  }
  
  
  private function saveTextInOwnTextElementOnLangUpdate($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig) {
    $sqlElText = 'SELECT selangInhalt FROM vselemlang WHERE selemID = ' . $this->dbDecode($elemID) . ' AND langID = ' . $this->dbDecode($langId) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while ($rowElE = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $elemInhaltSArr = json_decode($rowElE['selangInhalt'], true);
    }
    $this->saveSearchContent(null, $this->dbDecode($elemID), $elemInhaltSArr,$langId);
    $elemInhaltSArr['elemText'.$elemNum] = $elemInhalt;

    $elemInhaltJson = json_encode($elemInhaltSArr);
    
    $sqlUpText = 'UPDATE vselemlang SET selangInhalt = "' . $this->dbDecode($elemInhaltJson) . '" WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($elemID);
    return $this->dbAbfragen($sqlUpText);
  }
  
  
  private function saveTextInOwnTextElementOnLangNew($elemID, $langId, $elemInhalt, $elemNum, $elemInhaltOrig) {
    $dummyText = '{"elemBild1":"[vcms-empty-lang]", "elemBild2":"[vcms-empty-lang]", "elemBild3":"[vcms-empty-lang]", "elemBild4":"[vcms-empty-lang]", "elemBild5":"[vcms-empty-lang]", "elemBild6":"[vcms-empty-lang]", "elemBild7":"[vcms-empty-lang]", "elemBild8":"[vcms-empty-lang]", "elemBildLink1":"[vcms-empty-lang]", "elemBildLink2":"[vcms-empty-lang]", "elemBildLink3":"[vcms-empty-lang]", "elemBildLink4":"[vcms-empty-lang]", "elemBildLink5":"[vcms-empty-lang]", "elemBildLink6":"[vcms-empty-lang]", "elemBildLink7":"[vcms-empty-lang]", "elemBildLink8":"[vcms-empty-lang]", "elemText1":"[vcms-empty-lang]", "elemText2":"[vcms-empty-lang]", "elemText3":"[vcms-empty-lang]", "elemText4":"[vcms-empty-lang]", "elemText5":"[vcms-empty-lang]", "elemText6":"[vcms-empty-lang]", "elemText7":"[vcms-empty-lang]", "elemText8":"[vcms-empty-lang]"}';
    
    $elemInhaltSArr = json_decode($dummyText, true);
    
    $elemInhaltSArr['elemText'.$elemNum] = $elemInhalt;
    
    $elemInhaltJson = json_encode($elemInhaltSArr);
    
    $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangInhalt) VALUES (' . $this->dbDecode($elemID) . ', ' . $this->dbDecode($langId) . ', "' . $this->dbDecode($elemInhaltJson) . '")';
    return $this->dbAbfragen($sqlNewText);
  }
  
  
  
  public function saveElemOwnElemBildNow($elemID, $elemNum, $bildId) {
    $elemInhaltArr = array();
    $elemInhaltOrig = '';
    $sqlElText = 'SELECT selemInhalt FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($elemID) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while ($rowEl = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $elemInhaltOrig = $rowEl['selemInhalt'];
    }
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      return $this->saveBildInOwnBildElementOnLang($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig);
    }
    else {
      $elemInhaltArr = json_decode($elemInhaltOrig, true);
      
      $elemInhaltArr['elemBild'.$elemNum] = $bildId;

      $elemInhaltJson = json_encode($elemInhaltArr);

      $sqlSaveText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($elemInhaltJson) . '" WHERE selemID = ' . $this->dbDecode($elemID);
      return $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  private function saveBildInOwnBildElementOnLang($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig) {
    if ($this->checkElementHasDataLang($elemID, $langId)) {
      return $this->saveBildInOwnBildElementOnLangUpdate($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig);
    }
    else {
      return $this->saveBildInOwnBildElementOnLangNew($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig);
    }
  }
  
  
  private function saveBildInOwnBildElementOnLangUpdate($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig) {
    $sqlElText = 'SELECT selangInhalt FROM vselemlang WHERE selemID = ' . $this->dbDecode($elemID) . ' AND langID = ' . $this->dbDecode($langId) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while ($rowElE = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $elemInhaltSArr = json_decode($rowElE['selangInhalt'], true);
    }
    
    $elemInhaltSArr['elemBild'.$elemNum] = $bildId;

    $elemInhaltJson = json_encode($elemInhaltSArr);
    
    $sqlUpText = 'UPDATE vselemlang SET selangInhalt = "' . $this->dbDecode($elemInhaltJson) . '" WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($elemID);
    return $this->dbAbfragen($sqlUpText);
  }
  
  
  private function saveBildInOwnBildElementOnLangNew($elemID, $langId, $bildId, $elemNum, $elemInhaltOrig) {
    $dummyText = '{"elemBild1":"[vcms-empty-lang]", "elemBild2":"[vcms-empty-lang]", "elemBild3":"[vcms-empty-lang]", "elemBild4":"[vcms-empty-lang]", "elemBild5":"[vcms-empty-lang]", "elemBild6":"[vcms-empty-lang]", "elemBild7":"[vcms-empty-lang]", "elemBild8":"[vcms-empty-lang]", "elemBildLink1":"[vcms-empty-lang]", "elemBildLink2":"[vcms-empty-lang]", "elemBildLink3":"[vcms-empty-lang]", "elemBildLink4":"[vcms-empty-lang]", "elemBildLink5":"[vcms-empty-lang]", "elemBildLink6":"[vcms-empty-lang]", "elemBildLink7":"[vcms-empty-lang]", "elemBildLink8":"[vcms-empty-lang]", "elemText1":"[vcms-empty-lang]", "elemText2":"[vcms-empty-lang]", "elemText3":"[vcms-empty-lang]", "elemText4":"[vcms-empty-lang]", "elemText5":"[vcms-empty-lang]", "elemText6":"[vcms-empty-lang]", "elemText7":"[vcms-empty-lang]", "elemText8":"[vcms-empty-lang]"}';
    
    $elemInhaltSArr = json_decode($dummyText, true);
    
    $elemInhaltSArr['elemBild'.$elemNum] = $bildId;
    
    $elemInhaltJson = json_encode($elemInhaltSArr);
    
    $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangInhalt) VALUES (' . $this->dbDecode($elemID) . ', ' . $this->dbDecode($langId) . ', "' . $this->dbDecode($elemInhaltJson) . '")';
    return $this->dbAbfragen($sqlNewText);
  }
  
  
  
  public function delImageOnOwnElemPic($selemID, $selemNum) {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE selemID = ' . $this->dbDecode($selemID) . ' AND langID = ' . $this->dbDecode($langId) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $curJSONArr = json_decode($row['selangInhalt'], true);
        $curJSONArr['elemBild'.$selemNum] = '[vcms-empty-lang]';
        
        $curJSONArrNew = json_encode($curJSONArr);
        $sqlTextUpdate = 'UPDATE vselemlang SET selangInhalt = "'.$this->dbDecode($curJSONArrNew).'" WHERE selemID = ' . $this->dbDecode($selemID) . ' AND langID = ' . $this->dbDecode($langId);
        return $this->dbAbfragen($sqlTextUpdate);
      }
    }
    else {
      $sqlText = 'SELECT selemInhalt FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $curJSONArr = json_decode($row['selemInhalt'], true);
        $curJSONArr['elemBild'.$selemNum] = '';
        
        $curJSONArrNew = json_encode($curJSONArr);
        $sqlTextUpdate = 'UPDATE vseitenelemente SET selemInhalt = "'.$this->dbDecode($curJSONArrNew).'" WHERE selemID = ' . $this->dbDecode($selemID);
        return $this->dbAbfragen($sqlTextUpdate);
      }
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für eigene Elemente Speichern
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Elemente Sprachen Ausgaben
  // ***************************************************************************
  
  // Funktionen für Sprachen ID und Prüfen
  // *******************************************************************
  private function getCurentLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  private function checkElementHasDataLang($siteElemId, $langId) {
    $sqlCheckText = 'SELECT selangID FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckNum = mysql_num_rows($sqlCheckErg);
    if (isset($sqlCheckNum) && $sqlCheckNum > 0) {
      return true;
    }
    return false;
  }
  // *******************************************************************
  
  
  
  
  // Funktionen für Sprache Textfeld Ausgabe
  // *******************************************************************
  private function buildElementTextfeldOnLang($siteElementArr) {
    $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    if ($this->checkElementHasDataLang($siteElementArr['selemID'], $curLangId)) {
      return $this->getElementTextfeldTextOnLang($siteElementArr['selemID'], $curLangId);
    }
    else {
      return $siteElementArr['selemInhalt'];
    }
  }
  
  
  private function getElementTextfeldTextOnLang($siteElemId, $langId) {
    $return = '';
    
    $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowTextfeld = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowTextfeld['selangInhalt'];
    }
    
    return $return;
  }
  // *******************************************************************
  
  
  
  
  // Funktionen für Sprache Bild Ausgabe
  // *******************************************************************
  private function buildElementBildOnLang($siteElementArr) {
    $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    if ($this->checkElementHasDataLang($siteElementArr['selemID'], $curLangId)) {
      return $this->getElementBildfeldBildOnLang($siteElementArr['selemID'], $curLangId, $siteElementArr);
    }
    else {
      return $siteElementArr['selemInhalt'];
    }
  }
  
  
  private function getElementBildfeldBildOnLang($siteElemId, $langId, $siteElementArr) {
    $return = '';
    
    $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowBild = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($rowBild['selangInhalt']) && !empty($rowBild['selangInhalt'])) {
        $return = $rowBild['selangInhalt'];
      }
      else {
        $return = $siteElementArr['selemInhalt'];
      }
    }
    
    return $return;
  }
  //*******************************************************************
  
  
  
  
  // Funktionen für Sprache Bild Einstellungen Ausgabe
  // *******************************************************************
  private function buildElementBildConfigOnLang($siteElementArr) {
    $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    if ($this->checkElementHasDataLang($siteElementArr['selemID'], $curLangId)) {
      return $this->getElementBildfeldBildConfigOnLang($siteElementArr['selemID'], $curLangId, $siteElementArr);
    }
    else {
      return $siteElementArr['selemConfig'];
    }
  }
  
  
  private function getElementBildfeldBildConfigOnLang($siteElemId, $langId, $siteElementArr) {
    $return = '';
    
    $sqlText = 'SELECT selangConfig FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowBildC = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($rowBildC['selangConfig']) && !empty($rowBildC['selangConfig'])) {
        $return = $rowBildC['selangConfig'];
      }
      else {
        $return = $siteElementArr['selemConfig'];
      }
    }
    
    return $return;
  }
  // *******************************************************************
  
  
  
  // Funktionen für Sprache Eigene Elemente Ausgabe
  // *******************************************************************
  private function buildEigenElementOnLang($siteElementArr) {
    $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    if ($this->checkElementHasDataLang($siteElementArr['selemID'], $curLangId)) {
      return $this->getElementEigenInhaltOnLang($siteElementArr['selemID'], $curLangId, $siteElementArr);
    }
    else {
      return $siteElementArr['selemInhalt'];
    }
  }
  
  
  private function getElementEigenInhaltOnLang($siteElemId, $langId, $siteElementArr) {
    $return = '';
    
    $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowOwn = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($rowOwn['selangInhalt']) && !empty($rowOwn['selangInhalt'])) {
        $return = $rowOwn['selangInhalt'];
      }
      else {
        $return = $siteElementArr['selemInhalt'];
      }
    }
    
    return $return;
  }
  // *******************************************************************
  
  // ***************************************************************************
  // ENDE - Funktionen für Elemente Sprachen Ausgaben
  // ***************************************************************************
  
  
  
  
  
  private function getElementLangLinkOwnMM($siteElementArr) {
    $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    if ($this->checkElementHasDataLang($siteElementArr['selemID'], $curLangId)) {
      $sqlText = 'SELECT selangLink FROM vselemlang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND selemID = ' . $this->dbDecode($siteElementArr['selemID']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($row['selangLink']) && !empty($row['selangLink'])) {
          return $row['selangLink'];
        }
        else {
          return $siteElementArr['selemLink'];
        }
      }
    }
    else {
      return $siteElementArr['selemLink'];
    }
  }
  
  
  
  
  
  private function getTheTextUrlFromSiteByID($siteID) {
    $textUri = '';
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $textUri = $row['seitTextUrl'];
    }
    return $textUri;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Linking Arten Ausgaben
  // ***************************************************************************
  
  private function getTheCurentLinkArtFromElementNow($linkCurArr) {
    if (isset($linkCurArr['linkArt']) && $linkCurArr['linkArt'] == 'seite') {
      return $this->getTheCurentSeitenLinkArrayFromElementNow($linkCurArr);
    }
    else if (isset($linkCurArr['linkArt']) && $linkCurArr['linkArt'] == 'bild') {
      return $this->getTheCurentBildLinkArrayFromElementNow($linkCurArr);
    }
    else if (isset($linkCurArr['linkArt']) && $linkCurArr['linkArt'] == 'datei') {
      return $this->getTheCurentDateiLinkArrayFromElementNow($linkCurArr);
    }
    
    return $linkCurArr;
  }
  
  
  
  private function getTheCurentSeitenLinkArrayFromElementNow($linkCurArr) {
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($linkCurArr['link']) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $linkCurArr['link'] = '/';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $langLink = '';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $langLink = $_POST['VCMS_POST_LANG'].'/';
      }
      $linkCurArr['link'] = $langLink.$row['seitTextUrl'];
    }
    
    return $linkCurArr;
  }
  
  
  
  private function getTheCurentBildLinkArrayFromElementNow($linkCurArr) {
    $sqlText = 'SELECT bildFile FROM vbilder WHERE bildID = ' . $this->dbDecode($linkCurArr['link']) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $linkCurArr['link'] = '#';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $linkCurArr['link'] = 'user_upload/'.$row['bildFile'];
      $linkCurArr['linkClass'] .= ' vCmsLinkingPicLightboxShow';
    }
    
    return $linkCurArr;
  }
  
  
  
  private function getTheCurentDateiLinkArrayFromElementNow($linkCurArr) {
    $sqlText = 'SELECT dateiFile FROM vdateien WHERE dateiID = ' . $this->dbDecode($linkCurArr['link']) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $linkCurArr['link'] = '#';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $linkCurArr['link'] = 'user_upload_files/'.$row['dateiFile'];
    }
    
    return $linkCurArr;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Linking Arten Ausgaben
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Alias (Verknüpfungs) Elemente
  // ***************************************************************************
  
  public function showNewWindowAliasElementSet($selemID) {
    $return = '';
    $curInhaltID = $this->getNewAliasElementWindowInhaltData($selemID);
    
    $return .= '<div class="vFrontSmallSeFrmHolder">
              <div style="height:1px;"></div>
              <label style="width:95px;" for="frmAliasElementElementIdFrm">Element ID:</label>';
    $return .= '<input style="width:200px;" type="text" name="frmAliasElementElementIdFrm" id="frmAliasElementElementIdFrm" value="'.$curInhaltID.'" />';
    $return .= '<div class="vFrontSmallAliasElemShowAuswahlWindow" title="Element auswählen"></div><div class="clearer"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input style="margin-left:95px;" type="submit" value="Speichern" id="vSaveAliasElementChange" data-id="' . $selemID . '" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getNewAliasElementWindowInhaltData($selemID) {
    $sqlText = 'SELECT selemInhalt FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['selemInhalt'];
    }
    
    return '';
  }
  
  
  
  public function saveNewElementSetOnAliasElement($selemID, $setElemID) {
    $checkerVar = $this->checkIsElemetExistsOrAllowed($selemID, $setElemID);
    if ($checkerVar == 'ok') {
      $sqlText = 'UPDATE vseitenelemente SET selemInhalt = "'.$this->dbDecode($setElemID).'" WHERE selemID = ' . $this->dbDecode($selemID);
      $sqlErg = $this->dbAbfragen($sqlText);
      if ($sqlErg == true) {
        $setArr = '';
        $sqlTextSet = 'SELECT selemID, elemID FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($setElemID) . ' LIMIT 1';
        $sqlErgSet = $this->dbAbfragen($sqlTextSet);

        while ($rowSet = mysql_fetch_array($sqlErgSet, MYSQL_ASSOC)) {
          $setArr = $rowSet;
        }
        $curElemArr = $this->getCurElementArrayLoad($setArr['elemID']);
        return 'Verknüpft (Seiten Element ID: '.$setElemID.')<br>Element Name: '.$curElemArr['elemName'];
      }
      else {
        return 'error';
      }
    }
    else {
      return $checkerVar;
    }
  }
  
  
  
  private function checkIsElemetExistsOrAllowed($selemID, $setElemID) {
    $origArr = '';
    $sqlTextOrig = 'SELECT selemID, selemInElement FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErgOrig = $this->dbAbfragen($sqlTextOrig);
    
    while ($rowOrig = mysql_fetch_array($sqlErgOrig, MYSQL_ASSOC)) {
      $origArr = $rowOrig;
    }
    
    $sqlText = 'SELECT selemID, elemID, selemInElement FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($setElemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curElemArr = $this->getCurElementArrayLoad($row['elemID']);
      if (isset($curElemArr['elemArt']) && $curElemArr['elemArt'] == 5) {
        return 'isAlias';
      }
      else if ((isset($curElemArr['elemArt']) && $curElemArr['elemArt'] == 4) && (isset($origArr['selemInElement']) && !empty($origArr['selemInElement']))) {
        return 'isSpalten';
      }
      else {
        return 'ok';
      }
    }
    
    return 'elemNotFound';
  }
  
  
  
  public function showAliasWindowElementAuswahl($depp = 0, $parentID = 0, $nartID = 1) {
    $return = '';
    if ($depp < 1) {
      $return .= '<div class="vFrontSeitenAuflistungAuswahl">';
    }
    
    if ($depp < 5) {
      $sqlTextSeitBaum = 'SELECT seitID, seitArt, seitNaviName, seitName, seitOnline, seitNoNavi, seitTextUrl FROM vseiten WHERE seitParent = ' . $this->dbDecode($parentID) . ' AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ' AND nartID = ' . $this->dbDecode($nartID) . ' ORDER BY seitPosition ASC';
      $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);
      
      $return .= '<div class="vFrontSeitenBaumHolder">';

      while ($rowSeitBaum = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
        $curImgClass = 'vFrontIsSiteCur';
        if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 2) {
          $curImgClass = 'vFrontIsBlogCur';
        }
        else if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 3) {
          $curImgClass = 'vFrontIsNaviCur';
        }
        
        $curSiteIsOnline = ' vFrontBaumOnline';
        if (isset($rowSeitBaum['seitOnline']) && $rowSeitBaum['seitOnline'] == 2) {
          $curSiteIsOnline = ' vFrontBaumOffline';
        }
        
        $curSiteIsOnNavi = ' vFrontBaumOnNavi';
        if (isset($rowSeitBaum['seitNoNavi']) && $rowSeitBaum['seitNoNavi'] == 2) {
          $curSiteIsOnNavi = ' vFrontBaumNoNavi';
        }
        
        $return .= '<div class="soElems vFrontSeitBaumElem' . $depp . '" id="s' . $rowSeitBaum['seitID'] . '">';
        
        $curSiteBaumName = $rowSeitBaum['seitName'];
        
        $return .= '<div class="vFrontAliasSiteDropKlick vFrontBaumElem ' . $curImgClass . $curSiteIsOnline . $curSiteIsOnNavi . '" data-id="' . $rowSeitBaum['seitID'] . '" data-name="' . $rowSeitBaum['seitName'] . '">' . $curSiteBaumName;
        $return .= '</div>';
        
        $return .= $this->buildAliasElementAuswahlSeitenElemente($rowSeitBaum['seitID']);
        
        $return .= $this->showAliasWindowElementAuswahl($depp + 1, $rowSeitBaum['seitID'], $nartID);
        $return .= '</div>';
      }

      $return .= '</div>';
      
      if ($depp < 1) {
        $return .= '</div>';
      }
      
      return $return;
    }
  }
  
  
  
  private function buildAliasElementAuswahlSeitenElemente($siteID) {
    $return = '<div id="vFrontCurAliasElementsAuswahl'.$siteID.'" style="display:none;">';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($siteID);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontBaumElem vFrontCurSelemToChange" data-id="'.$row['selemID'].'">';
      
      $curElemArr = $this->getCurElementArrayLoad($row['elemID']);
      $return .= $curElemArr['elemName'] . ' (Id: '.$row['selemID'].')';
      
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveNewBildOnceInAliasElementMM($selemID, $picID) {
    $sqlText = 'UPDATE vseitenelemente SET selemPicOnce = "'.$this->dbDecode($picID).'" WHERE selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delTheBildOnceInAliasElementMM($selemID) {
    $sqlText = 'UPDATE vseitenelemente SET selemPicOnce = "" WHERE selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Alias (Verknüpfungs) Elemente
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für eigene Elemente Bilder Galerie Auswahl
  // ***************************************************************************
  
  public function showEigenElemPicGalImagesWindowAuswahl($selemID) {
    $return = '';
    $curPicData = $this->getOwnElemPicGaleriePicData($selemID);
    $curPicGalData = $this->getOwnElemPicGalerieIdData($selemID);
    
    $return .= '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<div data-field="vFrontFrmOwnElemPicGalsElem" class="vFrontFrmListHolder">
           <input type="hidden" value="'.$curPicGalData.'" id="vFrontFrmOwnElemPicGalsElem" name="vFrontFrmOwnElemPicGalsElem">
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder Galerie</div>
             <div class="vFrontFrmListHolderHeaderPicGalElemAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->buildOwnElemPicGalerieElemLists($curPicGalData).'</div>
         </div>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<div data-field="vFrontFrmOwnElemPicGalImgs" class="vFrontFrmListHolder">
           <input type="hidden" value="'.$curPicData.'" id="vFrontFrmOwnElemPicGalImgs" name="vFrontFrmOwnElemPicGalImgs">
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->buildOwnElemPicGaleriePicLists($curPicData).'</div>
         </div>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input style="margin-left:0px;" type="submit" value="Speichern" id="vSaveOwnElemPicGalChange" data-id="' . $selemID . '" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getOwnElemPicGalerieIdData($selemID) {
    $sqlText = 'SELECT selemPicGal FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemPicGal']) && !empty($row['selemPicGal'])) {
        return $row['selemPicGal'];
      }
    }
    
    return '';
  }
  
  
  
  private function buildOwnElemPicGalerieElemLists($picGalId) {
    $return = '';
    if (isset($picGalId) && !empty($picGalId)) {
      $sqlTextList = 'SELECT * FROM vbildergalerien WHERE galID = ' . $this->dbDecode($picGalId) . ' LIMIT 1';
      $sqlErgList = $this->dbAbfragen($sqlTextList);
      while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
        $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['galID'] . '">
            <div class="vFrontFrmListsElemBild">
              &nbsp;
            </div>
            <div class="vFrontFrmListsElemText">' . $rowList['galName'] . '</div>
            <div class="clearer"></div>
          </div>';
      }
    }
    return $return;
  }
  
  
  
  private function getOwnElemPicGaleriePicData($selemID) {
    $sqlText = 'SELECT selemConfig FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemConfig']) && !empty($row['selemConfig'])) {
        $curConfigArr = json_decode($row['selemConfig'], true);
        if (isset($curConfigArr['picGal'])) {
          return $curConfigArr['picGal'];
        }
      }
    }
    
    return '';
  }
  
  
  
  private function buildOwnElemPicGaleriePicLists($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $imgId) {
        $sqlTextList = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($imgId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['bildID'] . '">
              <div class="vFrontFrmListsElemBild">
                <img src="user_upload/' . $rowList['bildFile'] . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['bildName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
  
  
  public function vSaveOwnElemPicGalChange($selemID, $picGalImgs, $picGalElemID) {
    $sqlText = 'SELECT selemConfig FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $zwArr = '';
    $newArr = '';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemConfig']) && !empty($row['selemConfig'])) {
        $zwArr = json_decode($row['selemConfig'], true);
      }
    }
    if (isset($zwArr) && is_array($zwArr)) {
      $newArr = $zwArr;
    }
    else {
      $newArr = array();
    }
    $newArr['picGal'] = $picGalImgs;
    $sqlText = 'UPDATE vseitenelemente SET selemConfig = "'.$this->dbDecode(json_encode($newArr)).'", selemPicGal = "'.$this->dbDecode($picGalElemID).'" WHERE selemID = ' . $this->dbDecode($selemID);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showWindowBilderGalerieElemsAuswahl() {
    $return = '';
    
    $return .= '<div class="vFrontSeitenAuflistungAuswahl vFrontKategorienAuflistungAuswahl">';
    
    $sqlTextSeitBaum = 'SELECT * FROM vbildergalerien ORDER BY galPosition ASC';
    $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);

    $return .= '<div class="vFrontSeitenBaumHolder">';

    while ($row = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
      $curImgClass = 'vFrontIsPicGalElemCur';

      $return .= '<div class="soElems vFrontSeitBaumElem0">';

      $return .= '<div class="vFrontBaumElemPicGalElemZ vFrontBaumElem ' . $curImgClass . '" data-id="' . $row['galID'] . '" data-name="' . $row['galName'] . '">' . $row['galName'];

      $return .= '</div>';
      $return .= '</div>';
    }

    $return .= '</div>';
    
    $return .= '</div>';

    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für eigene Elemente Bilder Galerie Auswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Prüfen ob Element Verknüpft ist
  // ***************************************************************************
  
  private function checkIsElementOnAliasElement($selemArr) {
    $sqlElemText = 'SELECT elemID FROM velement WHERE elemEigen = 1 AND elemArt = 5 LIMIT 1';
    $sqlElemErg = $this->dbAbfragen($sqlElemText);
    
    while ($rowElem = mysql_fetch_array($sqlElemErg, MYSQL_ASSOC)) {
      $sqlText = 'SELECT selemID FROM vseitenelemente WHERE elemID = '.$this->dbDecode($rowElem['elemID']).' AND selemInhalt = "' . $this->dbDecode($selemArr['selemID']) . '" LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      $sqlCount = mysql_num_rows($sqlErg);

      if (isset($sqlCount) && $sqlCount > 0) {
        return true;
      }
    }
    
    return false;
  }
  
  // ***************************************************************************
  // ENDE - Prüfen ob Element Verknüpft ist
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Seiten Listen Window wo Element verknüpft ist
  // ***************************************************************************
  
  public function showElemAliasMoreInfoWindow($curSelemID) {
    $return = '';
    $allSiteArr = array();
    
    $sqlElemText = 'SELECT elemID FROM velement WHERE elemEigen = 1 AND elemArt = 5 LIMIT 1';
    $sqlElemErg = $this->dbAbfragen($sqlElemText);
    
    while ($rowElem = mysql_fetch_array($sqlElemErg, MYSQL_ASSOC)) {
      $sqlText = 'SELECT seitID FROM vseitenelemente WHERE elemID = '.$this->dbDecode($rowElem['elemID']).' AND selemInhalt = "' . $this->dbDecode($curSelemID) . '"';
      $sqlErg = $this->dbAbfragen($sqlText);
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $allSiteArr[$row['seitID']] = 'ok';
      }
    }
    
    $return .= $this->buildElemAliasMoreInfoSites($allSiteArr);
    
    return $return;
  }
  
  
  
  private function buildElemAliasMoreInfoSites($allSiteArr) {
    $return = '<div class="vFrontSeitenAuflistungAuswahl">';
    
    $return .= '<div class="vFrontSeitenBaumHolder">';
    
    foreach ($allSiteArr as $key => $value) {
      $sqlTextSeitBaum = 'SELECT seitID, seitName, seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($key) . ' LIMIT 1';
      $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);
      
      while ($rowSeit = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
        $curLangVar = '';
        if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
          $curLangVar = $_POST['VCMS_POST_LANG'].'/';
        }
        $return .= '<a href="'.$curLangVar.$rowSeit['seitTextUrl'].'" style="text-decoration:none;">';
        $return .= '<div class="soElems vFrontSeitBaumElem0" style="margin-bottom:8px;">';
        $return .= '<div class="vFrontAliasSiteDropKlick vFrontBaumElem vFrontIsSiteCur">' . $rowSeit['seitName'] . '</div>';
        $return .= '</div>';
        $return .= '</a>';
      }
    }
    
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Seiten Listen Window wo Element verknüpft ist
  // ***************************************************************************
  
  
  
  
  
  
  
  private function buildBildSliderElementAusgabe($siteElementArr) {
    $return = '';
    
    if (isset($siteElementArr['selemConfig']) && !empty($siteElementArr['selemConfig'])) {
      $curSiteElemConfigArr = json_decode($siteElementArr['selemConfig'], true);
      if (isset($curSiteElemConfigArr['picGal']) && !empty($curSiteElemConfigArr['picGal'])) {
        $return .= $this->buildBildSliderElementPics($curSiteElemConfigArr['picGal']);
      }
    }
    
    return $return;
  }
  
  
  
  private function buildBildSliderElementPics($picList) {
    $return = '';
    
    $picListArr = explode(';', $picList);
    
    foreach ($picListArr as $picId) {
      $curPicArr = $this->getBilderSliderPicDataID($picId);
      if (isset($curPicArr) && is_array($curPicArr)) {
        $return .= '<img src="user_upload/'.$curPicArr['bildFile'].'" alt="" title="" />';
      }
    }
    
    return $return;
  }
  
  
  
  private function getBilderSliderPicDataID($picId) {
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($picId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row;
    }
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kontaktformular ausgabe
  // ***************************************************************************
  
  private function buildKonatktFormularAusgabeNowMM($allKonatktDataArr) {
    $return = '';
    $classNoResponsiv = ' vCmsKontaktformLiveHolderNoResponsiv';
    if ($this->checkIsThisModuleActive('responsivWebModul')) {
      $classNoResponsiv = '';
    }
    
    
    
    // Empfehlungs Manager Auto Text
    // *************************************************************************
    if (isset($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT']) && !empty($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT'])) {
      $empfManagerAllDataArr = $this->getEmpfehlungsmanagerAllAllgemeinData();
      $empfehlerAllDataArr = $this->getEmpfehlerDataByEmpfehlerUrlMM($_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT']);
      if (isset($empfehlerAllDataArr) && is_array($empfehlerAllDataArr)) {
        $return .= '<div class="vCmsKontaktformLiveHolderEmpfehlerInfoAusgabeText">';
        $return .= $empfehlerAllDataArr['empfVorname'].' '.$empfehlerAllDataArr['empfNachname'].', '.$empfManagerAllDataArr['emTextZwNameFirma'].' „'.$empfManagerAllDataArr['emFirmaName'].'“.';
        if (isset($empfManagerAllDataArr['emRabattText']) && !empty($empfManagerAllDataArr['emRabattText'])) {
          $return .= ' '.$empfManagerAllDataArr['emRabattText'];
        }
        $return .= '</div>';
      }
    }
    // *************************************************************************
    
    $containerCount = 0;
    $curDataArr = json_decode($allKonatktDataArr['koJson'], true);
    
    $containerLabels =  json_decode($allKonatktDataArr['containerLabels'],true);
    $curDankeSeitenText = $curDataArr['DankeSeiteText'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($curDataArr['DankeSeiteText-'.$_POST['VCMS_POST_LANG']]) && !empty($curDataArr['DankeSeiteText-'.$_POST['VCMS_POST_LANG']])) {
        $curDankeSeitenText = $curDataArr['DankeSeiteText-'.$_POST['VCMS_POST_LANG']];
      }
    }
    $return .= '<div class="vCmsKontaktformLiveHolderOkAusgabeText" style="display:none;">'.$curDankeSeitenText.'</div>';
    
    $return .= '<div class="vCmsKontaktformLiveHolder'.$classNoResponsiv.'">';
    
    $return .= '<form>';
    
    $return .= '<div class="vCmsKontaktformLiveHolderErrorTextAusgabe"></div>';
    
    $return .= '<input type="hidden" name="vCmsKontaktformLiveHolderSysIdHFrm" id="vCmsKontaktformLiveHolderSysIdHFrm" value="'.$allKonatktDataArr['koID'].'" />';
    $return .= '<input type="hidden" name="vCmsKontaktformLiveHolderSysEHFrm" id="vCmsKontaktformLiveHolderSysEHFrm" value="" />';
    
    foreach ($curDataArr['FormData'] as $value) {
      $containerCount++;
       if(empty($_POST['VCMS_POST_LANG'])){
        $cLabel = 'de';  
      }else{
        $cLabel = $_POST['VCMS_POST_LANG'];
      }
      
     
      $return .= '<div class="vCmsKontaktformLiveContainer vCmsKontaktformLiveContainerCount'.$containerCount.'">';
       $return .= '<h3>'.$containerLabels['container'.$containerCount][$cLabel].'</h3>';
      foreach ($value['Container'] as $valueElem) {
        $return .= $this->buildKonatktFormularAusgabeCurentFieldNowMM($valueElem, $curDataArr);
      }
      $return .= '<div style="clear: both;"></div></div>';
    }
    
    $curBtnText = 'Senden';
    if (isset($curDataArr['SendButtonText']) && !empty($curDataArr['SendButtonText'])) {
      $curBtnText = $curDataArr['SendButtonText'];
    }
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($curDataArr['SendButtonText-'.$_POST['VCMS_POST_LANG']]) && !empty($curDataArr['SendButtonText-'.$_POST['VCMS_POST_LANG']])) {
        $curBtnText = $curDataArr['SendButtonText-'.$_POST['VCMS_POST_LANG']];
      }
    }
    
    $return .= '<script>var res="1";</script>';
    if($curDataArr['CaptchaOn'] == 'on'){

        $return .= '<script>
    res="";          
  var onloadCallback = function() {
        grecaptcha.render("html_element", {
          "sitekey" : "6Lel4xITAAAAALASDNcNPLjNEIDAajHC4h7rkev4",
           "callback" : function(response) {
      res=response;
    }
    });};</script><input type="hidden" name="captcha" value="1"><span class="vCmsKontaktformLiveFrmsAbstand"></span>';
     
        $return.='<div id="html_element"></div>';
       
    }
    
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<input class="btn btn-default" type="submit" id="vCmsKontaktformLiveHolderBtnSubmitSend" value="'.$curBtnText.'" />';
    $return .= '<span id="vCmsKontaktformLiveSendLoaderShow" style="display:none;"></span>';
    
    
    
    $return .= '</form>';
    
    $return .= '</div>';
    
    if($curDataArr['GoogleCode'] != ''){
        
        $return.= $curDataArr['GoogleCode'];
    }
    //$return .= '<pre>'.print_r($curDataArr, 1).'</pre>';
    
    return $return;
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
  
  
  
  private function buildKonatktFormularAusgabeCurentFieldNowMM($elemArr, $curDataArr) {
    $return = '';
    if ($elemArr['Art'] == 1) {
      $return .= $this->buildKonatktFormularAusgabeCurentFieldTextfeldMM($elemArr, $curDataArr);
    }
    else if ($elemArr['Art'] == 2) {
      $return .= $this->buildKonatktFormularAusgabeCurentFieldTextareaMM($elemArr, $curDataArr);
    }
    else if ($elemArr['Art'] == 3) {
      $return .= $this->buildKonatktFormularAusgabeCurentFieldCheckboxMM($elemArr, $curDataArr);
    }
    else if ($elemArr['Art'] == 4) {
      $return .= $this->buildKonatktFormularAusgabeCurentFieldDropDownMM($elemArr, $curDataArr);
    } else if ($elemArr['Art'] == 5) {
      $return .= $this->buildKonatktFormularAusgabeCurentFieldDateMM($elemArr, $curDataArr);
    }
    return $return;
  }
  
  
  
  private function buildKonatktFormularAusgabeCurentFieldTextfeldMM($elemArr, $curDataArr) {
    $curLabelText = $elemArr['Label'];
    $curErrorText = $elemArr['Error'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] != 'de') {
        
      
        
      if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']])) {
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'])) {
          $curLabelText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'])) {
          $curErrorText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'];
        }
      }
    } 
    
    $curClassSet = '';
    if (isset($elemArr['Required']) && $elemArr['Required'] == 'yes') {
      $curClassSet = 'vcmsKontaktDataIsRequired';
    }
    $curDataMailSet = 'no';
    if (isset($curDataArr['FieldMail']) && $curDataArr['FieldMail'] == $elemArr['Name']) {
      $curDataMailSet = 'yes';
    }
    
    $curValue = '';
    if (isset($_GET[$elemArr['Name']]) && !empty($_GET[$elemArr['Name']])) {
      $curValue = $_GET[$elemArr['Name']];
    }
    if (isset($_POST[$elemArr['Name']]) && !empty($_POST[$elemArr['Name']])) {
      $curValue = $_POST[$elemArr['Name']];
    }
    
    $return = '<span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<label for="'.$elemArr['Name'].'">'.$curLabelText.':</label>';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabel"></span>';
    $return .= '<input type="text" name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'" class="form-control '.$curClassSet.'" data-error="'.$curErrorText.'" data-mail="'.$curDataMailSet.'" value="'.$curValue.'" />';
    return $return;
  }
  
  
  
  private function buildKonatktFormularAusgabeCurentFieldTextareaMM($elemArr, $curDataArr) {
    $curLabelText = $elemArr['Label'];
    $curErrorText = $elemArr['Error'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] != 'de') {
      if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']])) {
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'])) {
          $curLabelText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'])) {
          $curErrorText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'];
        }
      }
    }
    
    $curClassSet = '';
    if (isset($elemArr['Required']) && $elemArr['Required'] == 'yes') {
      $curClassSet = 'vcmsKontaktDataIsRequired';
    }
    
    $curValue = '';
    if (isset($_GET[$elemArr['Name']]) && !empty($_GET[$elemArr['Name']])) {
      $curValue = $_GET[$elemArr['Name']];
    }
    if (isset($_POST[$elemArr['Name']]) && !empty($_POST[$elemArr['Name']])) {
      $curValue = $_POST[$elemArr['Name']];
    }
    
    $return = '<span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<label for="'.$elemArr['Name'].'">'.$curLabelText.':</label>';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabel"></span>';
    $return .= '<textarea name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'" class="form-control '.$curClassSet.'" data-error="'.$curErrorText.'" data-mail="no">'.$curValue.'</textarea>';
    return $return;
  }
  
  
  
  private function buildKonatktFormularAusgabeCurentFieldCheckboxMM($elemArr, $curDataArr) {
    $curLabelText = $elemArr['Label'];
    $curErrorText = $elemArr['Error'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] != 'de') {
      if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']])) {
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'])) {
          $curLabelText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'])) {
          $curErrorText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'];
        }
      }
    }
    
    $curClassSet = '';
    if (isset($elemArr['Required']) && $elemArr['Required'] == 'yes') {
      $curClassSet = 'vcmsKontaktDataIsRequired';
    }
    
    $curChecked = '';
    if (isset($_GET[$elemArr['Name']]) && !empty($_GET[$elemArr['Name']])) {
      $curChecked = ' checked="checked"';
    }
    if (isset($_POST[$elemArr['Name']]) && !empty($_POST[$elemArr['Name']])) {
      $curChecked = ' checked="checked"';
    }
    
    $return = '<span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<input'.$curChecked.' type="checkbox" name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'" value="on" class="'.$curClassSet.'" data-error="'.$curErrorText.'" data-mail="no" />';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabelCheckbox"></span>';
    $return .= '<label class="vCmsKontaktformLiveCheckBoxLabel" for="'.$elemArr['Name'].'">'.$curLabelText.'</label>';
    return $return;
  }
  
  
  
  private function buildKonatktFormularAusgabeCurentFieldDropDownMM($elemArr, $curDataArr) {
    $curLabelText = $elemArr['Label'];
    $curErrorText = $elemArr['Error'];
    $curSelectOptions = $elemArr['Options'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG']) && $_POST['VCMS_POST_LANG'] != 'de') {
      if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']])) {
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'])) {
          $curLabelText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'])) {
          $curErrorText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Options']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Options'])) {
          $curSelectOptions = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Options'];
        }
      }
    }
    
    $curClassSet = '';
    if (isset($elemArr['Required']) && $elemArr['Required'] == 'yes') {
      $curClassSet = 'vcmsKontaktDataIsRequired';
    }
    
    $return = '<span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<label for="'.$elemArr['Name'].'">'.$curLabelText.'</label>';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabel"></span>';
    $return .= '<select name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'" class="form-control '.$curClassSet.'" data-error="'.$curErrorText.'" data-mail="no">';
    try {
      if (isset($curSelectOptions) && !empty($curSelectOptions)) {
        $curOptionsArr = explode(';', $curSelectOptions);
        if (isset($curOptionsArr[0]) && $curOptionsArr[0] == 'ownUserFunction') {
          if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.VCMS_ABS_PATH_TEMPLATE.'inc/ownUserClass.inc.php')) {
            require_once($_SERVER['DOCUMENT_ROOT'].'/'.VCMS_ABS_PATH_TEMPLATE.'inc/ownUserClass.inc.php');
            $curOwnUserClassObj = new ownUserClassKontaktform();
            $return .= $curOwnUserClassObj->getCurentKontaktformDropDownOptions($curOptionsArr[1]);
          }
        }
        else {
          foreach ($curOptionsArr as $value) {
            $curOptionsArrOnce = explode('=', $value);
            if ($curOptionsArrOnce[0] == 'empty') {
              $curOptionsArrOnce[0] = '';
            }
            
            $curSelected = '';
            if (isset($_GET[$elemArr['Name']]) && !empty($_GET[$elemArr['Name']])) {
              if (isset($curOptionsArrOnce[0]) && $curOptionsArrOnce[0] == $_GET[$elemArr['Name']]) {
                $curSelected = ' selected="selected"';
              }
            }
            if (isset($_POST[$elemArr['Name']]) && !empty($_POST[$elemArr['Name']])) {
              if (isset($curOptionsArrOnce[0]) && $curOptionsArrOnce[0] == $_POST[$elemArr['Name']]) {
                $curSelected = ' selected="selected"';
              }
            }
            
            $return .= '<option'.$curSelected.' value="'.$curOptionsArrOnce[0].'">'.$curOptionsArrOnce[1].'</option>';
          }
        }
      }
    } catch (Exception $ex) {
      
    }
    $return .= '</select>';
    return $return;
  }
  
  
  
 private function buildKonatktFormularAusgabeCurentFieldDateMM($elemArr, $curDataArr) {
      
    $curLabelText = $elemArr['Label'];
    $curErrorText = $elemArr['Error'];
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']])) {
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'])) {
          $curLabelText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Label'];
        }
        if (isset($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error']) && !empty($elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'])) {
          $curErrorText = $elemArr['lang_'.$_POST['VCMS_POST_LANG']]['Error'];
        }
      }
    } 
    
    $curClassSet = '';
    if (isset($elemArr['Required']) && $elemArr['Required'] == 'yes') {
      $curClassSet = 'vcmsKontaktDataIsRequired';
    }
    $curDataMailSet = 'no';
    if (isset($curDataArr['FieldMail']) && $curDataArr['FieldMail'] == $elemArr['Name']) {
      $curDataMailSet = 'yes';
    }
    
    $curValue = '';
    if (isset($_GET[$elemArr['Name']]) && !empty($_GET[$elemArr['Name']])) {
      $curValue = $_GET[$elemArr['Name']];
    }
    if (isset($_POST[$elemArr['Name']]) && !empty($_POST[$elemArr['Name']])) {
      $curValue = $_POST[$elemArr['Name']];
    }  
     
    $explode = explode(';',$curLabelText);
    $optionsArr =  explode(',',$elemArr['Options']);
    
    
    if($optionsArr['0'] == 1){
        $date1 =$optionsArr['2'];
    }elseif($optionsArr['0'] == 3){
      $date1 =  date('m/d/y',strtotime('tomorrow'));
    }else{
      
       $date1 = date();
    }
    
    
    if($optionsArr['1'] == 1){
        $date2 =$optionsArr['4'];
    }elseif($optionsArr['1'] == 3){
      $date2 =  date('Y-m-d',strtotime('tomorrow'));
    }else{
       $date2 = date();
    }
  
    
    $return = '<div class="dateForm"><span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<label for="'.$elemArr['Name'].'">'.$explode[0].':</label>';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabel"></span>';
    $return .= '<input type="text" name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'from" class="form-control '.$curClassSet.' datepickerContact" data-error="'.$curErrorText.'" data-mail="'.$curDataMailSet.'" value="'.$curValue.'" data-option="'.$optionsArr['0'].'" data-start="'.$date1.'" /></div>';
    $return .= '<div class="dateForm"><span class="vCmsKontaktformLiveFrmsAbstand"></span>';
    $return .= '<label for="'.$elemArr['Name'].'">'.$explode[1].':</label>';
    $return .= '<span class="vCmsKontaktformLiveFrmsAbstandLabel"></span>';
    $return .= '<input type="text" name="'.$elemArr['Name'].'" id="'.$elemArr['Name'].'to" class="form-control '.$curClassSet.' datepickerContact" data-error="'.$curErrorText.'" data-mail="'.$curDataMailSet.'" value="'.$curValue.'"  data-option="'.$optionsArr['1'].'" data-start="'.$date2.'" /></div>';
      
    return $return;
      
  }
  
  
  
  
  
  public function showNewWindowKontaktFormElementSet($seitElemId) {
    $curImgClass = 'vFrontKontaktFormImgClassOnChange';
    
    $return = '<div class="vFrontSeitenAuflistungAuswahl vFrontKontaktFormAuflistungAuswahl">';
    $return .= '<div class="vFrontSeitenBaumHolder">';
    
    $sqlText = 'SELECT * FROM vkontaktformulare';
    $sqlErg = $this->dbAbfragen($sqlText);

    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontBaumElem ' . $curImgClass . '" data-id="' . $row['koID'] . '" data-name="' . $row['koName'] . '">' . $row['koName'] . '</div>';
    }
    
    $return .= '</div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getNewWindowKontaktFormElementSetElemNow($seitElemId, $kontaktId) {
    $sqlText = 'UPDATE vseitenelemente SET selemInhalt = "'.$this->dbDecode($kontaktId).'" WHERE selemID = "'.$this->dbDecode($seitElemId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kontaktformular ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager Empfehler Forms Ausgabe
  // ***************************************************************************
  
  private function buildEmpfehlungsManagerEmpfehlerFormsNow() {
    $classNoResponsiv = ' vFrontEmpfehlerFormsHolderSysNoResponsiv';
    if ($this->checkIsThisModuleActive('responsivWebModul')) {
      $classNoResponsiv = '';
    }
    
    $return = '<div class="vFrontEmpfehlerFormsHolderSys'.$classNoResponsiv.'">';
    
    $return .= '<div class="vFrontEmpfehlerFormsSysErrorText"></div>';
    
    $return .= '<input class="form-control" type="hidden" name="vFrontEmpfehlerFormsFbId" id="vFrontEmpfehlerFormsFbId" value="" />';
    
    $return .= '<label for="vFrontEmpfehlerFormsVorname">Vorname:</label>';
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstandLabel"></div>';
    $return .= '<input class="form-control" type="text" name="vFrontEmpfehlerFormsVorname" id="vFrontEmpfehlerFormsVorname" />';
    
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmpfehlerFormsNachname">Nachname:</label>';
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstandLabel"></div>';
    $return .= '<input class="form-control" type="text" name="vFrontEmpfehlerFormsNachname" id="vFrontEmpfehlerFormsNachname" />';
    
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstand"></div>';
    
    //$return .= '<label for="vFrontEmpfehlerFormsStrasse">Straße:</label>';
    //$return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstandLabel"></div>';
    //$return .= '<input class="form-control" type="text" name="vFrontEmpfehlerFormsStrasse" id="vFrontEmpfehlerFormsStrasse" />';
    $return .= '<input type="hidden" name="vFrontEmpfehlerFormsStrasse" id="vFrontEmpfehlerFormsStrasse" value="no" />';
    
    //$return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstand"></div>';
    
    //$return .= '<label for="vFrontEmpfehlerFormsPlz">PLZ / Ort:</label>';
    //$return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstandLabel"></div>';
    //$return .= '<input class="vFrontEmpfehlerFormIsPlz form-control" type="text" name="vFrontEmpfehlerFormsPlz" id="vFrontEmpfehlerFormsPlz" />';
    //$return .= '<input class="vFrontEmpfehlerFormIsOrt form-control" type="text" name="vFrontEmpfehlerFormsOrt" id="vFrontEmpfehlerFormsOrt" />';
    $return .= '<input type="hidden" name="vFrontEmpfehlerFormsPlz" id="vFrontEmpfehlerFormsPlz" value="no" />';
    $return .= '<input type="hidden" name="vFrontEmpfehlerFormsOrt" id="vFrontEmpfehlerFormsOrt" value="no" />';
    
    //$return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstand"></div>';
    
    $return .= '<label for="vFrontEmpfehlerFormsMail">E-Mail:</label>';
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstandLabel"></div>';
    $return .= '<input class="form-control" type="text" name="vFrontEmpfehlerFormsMail" id="vFrontEmpfehlerFormsMail" />';
    
    $return .= '<div class="vFrontEmpfehlerFormsHolderSysFrmAbstand"></div>';
    
    $return .= '<input class="btn btn-default" type="submit" id="vFrontEmpfehlerFormsLiveHolderBtnSubmitSend" value="Jetzt persönlichen Link generieren" />';
    $return .= '<span id="vFrontEmpfehlerFormsLiveSendLoaderShow" style="display:none;"></span>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildEmpfehlungsManagerGeschenkeInfoTextNow() {
    $return = '<div class="vFrontEmpfehlungsManagerGeschenkeInfoHolderSys">';
    
    $return .= '<div class="vFrontEmpfehlungsManagerGeschenkeInfoHolderSysUe">Ihr Vorteil*</div>';
    
    $sqlText = 'SELECT * FROM vempfehlergeschenke ORDER BY gesBuchAnzahl ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontEmpfehlungsManagerGeschenkInfoElemSys">';
      $return .= '<span class="vFrontEmpfehlungsManagerGeschenkeRulesInfoElemSysAnzahl">ab '.$row['gesBuchAnzahl'].'</span>';
      $return .= '<div class="vFrontEmpfehlungsManagerGeschenkeRulesInfoElemSysText">'.$row['gesText'].'</div>';
      $return .= '<div class="clearer"></div>';
      $return .= '</div>';
    }
    
    $allEmpfMaDataArr = $this->getEmpfehlungsmanagerAllAllgemeinData();
    if (isset($allEmpfMaDataArr) && is_array($allEmpfMaDataArr)) {
      $return .= '<div class="vFrontEmpfehlungsManagerGeschenkeRulesInfoElemSys">'.nl2br($allEmpfMaDataArr['emGeschenkeRules']).'</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getEmpfehlungsmanagerAllAllgemeinData() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager Empfehler Forms Ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Elements
  // ***************************************************************************
  
  public function showElemOwnSettingUsersWindow($curSeitElemId, $isOwnElem) {
    $sysDataOnlineAbDate = '';
    $sysDataOnlineAbTime = '';
    $sysDataOnlineBisDate = '';
    $sysDataOnlineBisTime = '';
    $sysDataElemOnline = 'yes';
    $sysDataElemDesktopShow = 'yes';
    $sysDataElemTabletShow = 'yes';
    $sysDataElemMobileShow = 'yes';
    
    $allSettingDataArr = $this->getElemOwnSettingUsersWindowDataArr($curSeitElemId);
    
     
    
    if (isset($allSettingDataArr['vSysSettings']['elemOnlineAbDate']) && !empty($allSettingDataArr['vSysSettings']['elemOnlineAbDate'])) {
      $sysDataOnlineAbDate = $allSettingDataArr['vSysSettings']['elemOnlineAbDate'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemOnlineAbTime']) && !empty($allSettingDataArr['vSysSettings']['elemOnlineAbTime'])) {
      $sysDataOnlineAbTime = $allSettingDataArr['vSysSettings']['elemOnlineAbTime'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemOnlineBisDate']) && !empty($allSettingDataArr['vSysSettings']['elemOnlineBisDate'])) {
      $sysDataOnlineBisDate = $allSettingDataArr['vSysSettings']['elemOnlineBisDate'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemOnlineBisTime']) && !empty($allSettingDataArr['vSysSettings']['elemOnlineBisTime'])) {
      $sysDataOnlineBisTime = $allSettingDataArr['vSysSettings']['elemOnlineBisTime'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemIsOnline']) && !empty($allSettingDataArr['vSysSettings']['elemIsOnline'])) {
      $sysDataElemOnline = $allSettingDataArr['vSysSettings']['elemIsOnline'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemDesktopShow']) && !empty($allSettingDataArr['vSysSettings']['elemDesktopShow'])) {
      $sysDataElemDesktopShow = $allSettingDataArr['vSysSettings']['elemDesktopShow'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemTabletShow']) && !empty($allSettingDataArr['vSysSettings']['elemTabletShow'])) {
      $sysDataElemTabletShow = $allSettingDataArr['vSysSettings']['elemTabletShow'];
    }
    if (isset($allSettingDataArr['vSysSettings']['elemMobileShow']) && !empty($allSettingDataArr['vSysSettings']['elemMobileShow'])) {
      $sysDataElemMobileShow = $allSettingDataArr['vSysSettings']['elemMobileShow'];
    }
    
    $return = '<div class="vFrontOwnElemSettingsWindowInInhalt">';
    
      $return .= '<div class="vFrontOwnElemSettingsWindowInInhaltSystem">';
    
        $return .= '<div class="vFrontSmallSeFrmHolder" style="margin-bottom:30px;">';
          $return .= '<label>Online Ab:</label>';
          $return .= '<input type="text" id="vFrontOwnElemSettingDateAb" name="vFrontOwnElemSettingDateAb" class="vFrontOwnElemSettingsWindowInInhaltSystemCalendar" placeholder="Datum" value="'.$sysDataOnlineAbDate.'" />';
          $return .= '<input type="text" id="vFrontOwnElemSettingTimeAb" name="vFrontOwnElemSettingTimeAb" class="vFrontOwnElemSettingsWindowInInhaltSystemTime" placeholder="Uhrzeit" value="'.$sysDataOnlineAbTime.'" />';

          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>Online Bis:</label>';
          $return .= '<input type="text" id="vFrontOwnElemSettingDateBis" name="vFrontOwnElemSettingDateBis" class="vFrontOwnElemSettingsWindowInInhaltSystemCalendar" placeholder="Datum" value="'.$sysDataOnlineBisDate.'" />';
          $return .= '<input type="text" id="vFrontOwnElemSettingTimeBis" name="vFrontOwnElemSettingTimeBis" class="vFrontOwnElemSettingsWindowInInhaltSystemTime" placeholder="Uhrzeit" value="'.$sysDataOnlineBisTime.'" />';

          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>Element Online:</label>';
          $return .= '<select id="vFrontOwnElemSettingElemOnline" name="vFrontOwnElemSettingElemOnline">';
          $return .= $this->getElemOwnSettingUsersWindowSelectsYesNo($sysDataElemOnline);
          $return .= '</select>';

          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>Desktop anzeigen:</label>';
          $return .= '<select id="vFrontOwnElemSettingDesktopShow" name="vFrontOwnElemSettingDesktopShow">';
          $return .= $this->getElemOwnSettingUsersWindowSelectsYesNo($sysDataElemDesktopShow);
          $return .= '</select>';

          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>Tablet anzeigen:</label>';
          $return .= '<select id="vFrontOwnElemSettingTabletShow" name="vFrontOwnElemSettingTabletShow">';
          $return .= $this->getElemOwnSettingUsersWindowSelectsYesNo($sysDataElemTabletShow);
          $return .= '</select>';

          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>Mobile anzeigen:</label>';
          $return .= '<select id="vFrontOwnElemSettingMobileShow" name="vFrontOwnElemSettingMobileShow">';
          $return .= $this->getElemOwnSettingUsersWindowSelectsYesNo($sysDataElemMobileShow);
          $return .= '</select>';
         $return .= $this->getLangSettings($curSeitElemId);
        $return .= '</div>';
        
      $return .= '</div>';
      
      
      $return .= '<div class="vFrontOwnElemSettingsWindowInInhaltEigen vFrontFrmHolder" style="margin-left:40px; border-top:1px solid #999; padding-left:10px; padding-top:20px; width:485px;">';
        $return .= '<form>';
          $return .= $this->getElemOwnSettingUsersWindowOwnSettingString($curSeitElemId, $allSettingDataArr);
        $return .= '</form>';
      $return .= '</div>';
    
    
    $return .= '</div>';
    
    
    
    
    $return .= '<div class="vFrontOwnElemSettingsWindowInHeader">';
    $return .= '<div class="vFrontOwnElemSettingsWindowInHeaderBtnSave" data-id="'.$curSeitElemId.'" data-art="'.$isOwnElem.'">Speichern</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  private function  getLangSettings($selemID){
  
      $query = mysql_query("SELECT langConfig FROM `vseitenelemente` WHERE selemID='$selemID'");
      $row = mysql_fetch_array($query);
      
      $langConfig = unserialize($row['langConfig']);

      foreach($langConfig as $key =>  $value){
          $langArr[$value['name']] = $value['value'];
      }
      $query  = mysql_query("SELECT * FROM vsprachen ");
      
      while($row = mysql_fetch_array($query)){
          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label>'.$row['langName'].':</label>';
          $return .= '<select   class="elementLangConfig" name="'.$row['langKurzName'].'" style="width:136px">';
          $return .= $this->getElemOwnSettingUsersWindowSelectsYesNo($langArr[$row['langKurzName']]);
          $return .= '</select>';
         
      }
      return $return;

  }	
  
  
  
  private function getElemOwnSettingUsersWindowOwnSettingString($curSeitElemId, $allSettingDataArr) {
    $sqlText = 'SELECT elemID FROM vseitenelemente WHERE selemID = "'.$this->dbDecode($curSeitElemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlText2 = 'SELECT elemOwnConfig FROM velement WHERE elemID = "'.$this->dbDecode($row['elemID']).'" LIMIT 1';
      $sqlErg2 = $this->dbAbfragen($sqlText2);
      
      while ($row2 = mysql_fetch_array($sqlErg2, MYSQL_ASSOC)) {
        if (isset($row2['elemOwnConfig']) && !empty($row2['elemOwnConfig'])) {
          $return = '';
          $allElemSettingDataArr = json_decode($row2['elemOwnConfig'], true);
          $return .= $this->buildCurrentSettingsByOwnElemUserString($allElemSettingDataArr, $allSettingDataArr);
          return $return;
        }
      }
    }
  }
  
  
  
  private function getElemOwnSettingUsersWindowSelectsYesNo($isCheck = '') {
    $artArr = array(
      'yes' => 'Ja',
      'no' => 'nein',
    );

    $return = '';
    
    foreach ($artArr as $key => $art) {
      if ($key == $isCheck) {
        $return .= '<option selected="selected" value="' . $key . '">' . $art . '</option>';
      }
      else {
        $return .= '<option value="' . $key . '">' . $art . '</option>';
      }
    }
    
    return $return;
  }
  
  
  
  private function getElemOwnSettingUsersWindowDataArr($curSeitElemId) {
    $return = '';
    
    $sqlText = 'SELECT selemOwnConfig FROM vseitenelemente WHERE selemID = "'.$this->dbDecode($curSeitElemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemOwnConfig']) && !empty($row['selemOwnConfig'])) {
        $return = json_decode($row['selemOwnConfig'], true);
      }
    }
    
    return $return;
  }
  
  
  
  public function saveElemOwnSettingUsersWindowNow($curSiteElemId, $isElemOwnElem) {
    $curSettingDataArr = $this->getElemOwnSettingUsersWindowDataArr($curSiteElemId);
    if (isset($curSettingDataArr) && is_array($curSettingDataArr)) {
      
    }
    else {
      $curSettingDataArr = array();
      $curSettingDataArr['vSysSettings'] = array();
      $curSettingDataArr['vOwnUserSettings'] = array();
    }
    
    $curSettingDataArr['vSysSettings']['elemOnlineAbDate'] = $_POST['_elemSettingDateAb'];
    $curSettingDataArr['vSysSettings']['elemOnlineAbTime'] = $_POST['_elemSettingTimeAb'];
    $curSettingDataArr['vSysSettings']['elemOnlineBisDate'] = $_POST['_elemSettingDateBis'];
    $curSettingDataArr['vSysSettings']['elemOnlineBisTime'] = $_POST['_elemSettingTimeBis'];
    $curSettingDataArr['vSysSettings']['elemIsOnline'] = $_POST['_elemSettingElemOnline'];
    $curSettingDataArr['vSysSettings']['elemDesktopShow'] = $_POST['_elemSettingDesktopShow'];
    $curSettingDataArr['vSysSettings']['elemTabletShow'] = $_POST['_elemSettingTabletShow'];
    $curSettingDataArr['vSysSettings']['elemMobileShow'] = $_POST['_elemSettingMobileShow'];
    
    if (isset($_POST['_userOwnDataArr']) && is_array($_POST['_userOwnDataArr'])) {
      $curOwnDataArr = $this->setElemOwnSettingUsersAllCheckboxesToNo($curSiteElemId);
      foreach ($_POST['_userOwnDataArr'] as $value) {
        $curOwnDataArr[$value['name']] = $value['value'];
      }
      $curSettingDataArr['vOwnUserSettings'] = $curOwnDataArr;
    }else{
      $curSettingDataArr['vOwnUserSettings'] = '';
    }
    
    $curSettingDataJson = json_encode($curSettingDataArr);
    
    $query = mysql_query('SELECT seitID FROM vseitenelemente WHERE selemID = '.$this->dbDecode($curSiteElemId));
    $row = mysql_fetch_array($query);
    $idSite = $row['seitID'];
    
    $filtersArr = explode(';',$curSettingDataArr['vOwnUserSettings']['filterKat']);
    $query = mysql_query("DELETE FROM vseitenFilter WHERE id_site='$idSite'");
 
    if($query){
        foreach($filtersArr as $key => $value){
            $query = mysql_query("INSERT INTO vseitenFilter SET id_filtr='$value', id_site='$idSite'");
         }
    }
    
    $langConfig = serialize ($_POST['_langConfig']);
      
     $sqlText = 'UPDATE vseitenelemente SET selemOwnConfig = "'.$this->dbDecode($curSettingDataJson).'",langConfig="'.$this->dbDecode($langConfig).'" WHERE selemID = "'.$this->dbDecode($curSiteElemId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function setElemOwnSettingUsersAllCheckboxesToNo($curSiteElemId) {
    $return = array();
    
    $sqlText = 'SELECT elemID FROM vseitenelemente WHERE selemID = "'.$this->dbDecode($curSiteElemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlText2 = 'SELECT elemOwnConfig FROM velement WHERE elemID = "'.$this->dbDecode($row['elemID']).'" LIMIT 1';
      $sqlErg2 = $this->dbAbfragen($sqlText2);
      
      while ($row2 = mysql_fetch_array($sqlErg2, MYSQL_ASSOC)) {
        $allElemSettingDataArr = json_decode($row2['elemOwnConfig'], true);
        foreach ($allElemSettingDataArr as $key => $value) {
          if (isset($value['art']) && $value['art'] == '4') {
            $return[$key] = 'off';
          }
        }
      }
    }
    
    return $return;
  }


  
  
  // Funktionen für eigene Element Einstellungen Felder
  // ******************************************************
  private function buildCurrentSettingsByOwnElemUserString($allElemSettingDataArr, $allElemSelfSettingDataArr) {
    $return = '';
    foreach ($allElemSettingDataArr as $key => $value) {
      if (isset($value['art']) && !empty($value['art'])) {
        $return .= $this->getCurrentSettingsByOwnElemUserField($key, $value, $allElemSelfSettingDataArr);
      }
    }
    return $return;
  }
  
  
  
  private function getCurrentSettingsByOwnElemUserField($key, $value, $allElemSelfSettingDataArr) {
    switch ($value['art']) {
      case '1': return $this->buildCurrentSettingsByOwnElemUserFieldTextfeld($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '2': return $this->buildCurrentSettingsByOwnElemUserFieldTextarea($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '3': return $this->buildCurrentSettingsByOwnElemUserFieldTextareaWysiwyg($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '4': return $this->buildCurrentSettingsByOwnElemUserFieldCheckbox($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '5': return $this->buildCurrentSettingsByOwnElemUserFieldDropDown($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '6': return $this->buildCurrentSettingsByOwnElemUserFieldDatumFeld($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '7': return $this->buildCurrentSettingsByOwnElemUserFieldPicOnce($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '8': return $this->buildCurrentSettingsByOwnElemUserFieldPicMulti($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '9': return $this->buildCurrentSettingsByOwnElemUserFieldDateiOnce($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '10': return $this->buildCurrentSettingsByOwnElemUserFieldDateiMulti($key, $value, $allElemSelfSettingDataArr);
        break;
      
      case '11': return $this->buildCurrentSettingsByOwnElemUserFieldSeitenRelation($key, $value, $allElemSelfSettingDataArr);
        break;
      
      
      case '20': return $this->buildCurrentSettingsByOwnElemUserFieldFiltersystemKategorien($key, $value, $allElemSelfSettingDataArr);
        break;
    
     case '21': return $this->buildBasketButtonOptions($key, $value, $allElemSelfSettingDataArr);
        break;
    }
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldTextfeld($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <input type="text" id="'.$key.'" name="'.$key.'" value="'.$curFieldVal.'" />
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldTextarea($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <textarea id="'.$key.'" name="'.$key.'">'.$curFieldVal.'</textarea>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldTextareaWysiwyg($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <div style="width:485px;">
                  <textarea style="height:200px;" class="vFrontSiSeOwnFelderWysiwygField" id="'.$key.'" name="'.$key.'">'.$curFieldVal.'</textarea>
                </div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldCheckbox($key, $value, $allElemSelfSettingDataArr) {
    $checkBoxChecked = '';
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    if (isset($curFieldVal) && $curFieldVal == 'on') {
      $checkBoxChecked = ' checked="checked"';
    }
    $return = '<div class="vFrontFrmAbstand"></div>';
    $return .= '<input'.$checkBoxChecked.' type="checkbox" id="'.$key.'" name="'.$key.'" value="on" />
                <label for="'.$key.'">'.$value['label'].'</label>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldDropDown($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $optionArrZw = explode(';', $value['options']);
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <select class="vFrontSiSeOwnFelderSelectField" id="'.$key.'" name="'.$key.'">';
    foreach ($optionArrZw as $valueOption) {
      $curOption = explode('=', $valueOption);
      if (isset($curFieldVal) && $curFieldVal == $curOption[0]) {
        $return .= '<option selected="selected" value="'.$curOption[0].'">'.$curOption[1].'</option>';
      }
      else {
        $return .= '<option value="'.$curOption[0].'">'.$curOption[1].'</option>';
      }
    } 
    $return .= '</select>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldDatumFeld($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <input style="width:160px;" readonly="readonly" class="vFrontSiSeOwnFelderDateField" type="text" id="'.$key.'" name="'.$key.'" value="'.$curFieldVal.'" />
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldPicOnce($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bild</div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnFieldOnce"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnFieldOnce"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnFieldOnce">' . $this->getListPicElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldPicMulti($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnFieldMulti">' . $this->getListPicElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldDateiOnce($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Datei</div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnDateiFieldOnce"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnDateiFieldOnce"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnDateiFieldOnce">' . $this->getListDateiElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldDateiMulti($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Dateien</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnDateiFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnDateiFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnDateiFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnDateiFieldMulti">' . $this->getListDateiElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldSeitenRelation($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Seiten</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnSiteFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnSiteFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnSiteFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnSiteFieldMulti">' . $this->getListSiteRelElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildCurrentSettingsByOwnElemUserFieldFiltersystemKategorien($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    if (isset($allElemSelfSettingDataArr['vOwnUserSettings'][$key]) && !empty($allElemSelfSettingDataArr['vOwnUserSettings'][$key])) {
      $curFieldVal = $allElemSelfSettingDataArr['vOwnUserSettings'][$key];
    }
    $return = '<label>'.$value['label'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$key.'">
           <input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Filter Kategorien</div>';
    //$return .= '<div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnSiteFieldMulti"></div>';
    $return .= '<div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnFilterSysKatFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnFilterSysKatFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnFilterSysKatFieldMulti">' . $this->getListFilterSysKatElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  // ******************************************************
   private function buildBasketButtonOptions($key, $value, $allElemSelfSettingDataArr) {
    $curFieldVal = '';
    
    $current = $allElemSelfSettingDataArr['vOwnUserSettings']['bergLustPur'];

    $query = mysql_query("SELECT * FROM vtabbasket");
    $return = '<label for="'.$key.'">'.$value['label'].':</label>
                <div class="vFrontLblAbstand"></div>
                <select class="vFrontSiSeOwnFelderSelectField" id="'.$key.'" name="'.$key.'">';
    while($row = mysql_fetch_array($query)){
    
      if ( $row['id'] == $current) {
        $return .= '<option selected="selected" value="'.$row['id'].'">'.$row['name'].'</option>';
      }
      else {
        $return .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      }
    } 
    $return .= '</select>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function getListPicElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $imgId) {
        $sqlTextList = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($imgId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['bildID'] . '">
              <div class="vFrontFrmListsElemBild">
                <img src="user_upload/' . $rowList['bildFile'] . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['bildName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
  
  
  private function getListDateiElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $dateiId) {
        $sqlTextList = 'SELECT * FROM vdateien WHERE dateiID = ' . $this->dbDecode($dateiId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['dateiID'] . '">
              <div class="vFrontFrmListsElemBild" style="text-align:center;">
                <img style="width:40px;" src="' . $this->getDateiElemCurPicPath($rowList['dateiName']) . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['dateiName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
  
  
  private function getListSiteRelElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $siteId) {
        $sqlTextList = 'SELECT seitName, seitID FROM vseiten WHERE seitID = ' . $this->dbDecode($siteId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontListElemIUser" data-id="' . $rowList['seitID'] . '">' . $rowList['seitName'] . '</div>';
        }
      }
    }
    return $return;
  }
  
  
  
  private function getListFilterSysKatElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $filKatId) {
        $sqlTextList = 'SELECT filkatName, filkatID FROM vfilterkategorien WHERE filkatID = ' . $this->dbDecode($filKatId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontListElemIUser" data-id="' . $rowList['filkatID'] . '">' . $rowList['filkatName'] . '</div>';
        }
      }
    }
    return $return;
  }
  
  
  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Elements
  // ***************************************************************************

/////////////////////search functions ///////////////////////////////////
  
  public function saveSearchContent($idSite,$idElem,$data,$idLang=null) {
     
      if($idLang == NULL){
          $query = mysql_query("SELECT langID  FROM vsprachen  ORDER BY langID ASC LIMIT 1");
          $row   = mysql_fetch_array($query);
          $idLang= $row['langID']; 
      }
      
      
     if($idSite == NULL){
        $query = mysql_query("SELECT seitID  FROM vseitenelemente WHERE selemID='$idElem'");
        $row   = mysql_fetch_array($query);
        $idSite= $row['seitID'];
     } 
    
    $query = mysql_query("DELETE FROM vseitensearch WHERE id_elem='$idElem' AND id_lang='$idLang'");
      
    if(is_array($data)){
        foreach($data as $key => $value){
            if($value != '<p>Lorem ipsum</p>' && $value != '' && $value != '[vcms-empty-lang]' &&  stripos($key, 'elemText') !== false){
                $desc = strip_tags($value);
                $query = mysql_query("INSERT INTO vseitensearch SET id_lang='$idLang',id_site='$idSite',id_elem='$idElem',description='$desc'");
            }
        }
        
    }else{
        $data = strip_tags($data);
        $query = mysql_query("INSERT INTO vseitensearch SET id_lang='$idLang',id_site='$idSite',id_elem='$idElem',description='$data'");
    }
    return $query;
  }
  
  
  
}

?>