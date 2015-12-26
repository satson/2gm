<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsLinking extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen Ausgabe Linking Window
  // ***************************************************************************
  
  public function getCurentLinkingWindowInhalt() {
    if (isset($_POST['_elemArt']) && $_POST['_elemArt'] == 'eigen') {
      return $this->buildElementWindowAusgabeLink($_POST['_elemArt'], $_POST['_selemID']);
    }
    else if (isset($_POST['_elemArt']) && $_POST['_elemArt'] == 'eigenBild') {
      
    }
    else if (isset($_POST['_elemArt']) && $_POST['_elemArt'] == 'bild') {
      return $this->buildElementWindowAusgabeLink($_POST['_elemArt'], $_POST['_selemID']);
    }
  }
  
  
  
  private function buildElementWindowAusgabeLink($elemArt, $selemID) {
    $isLang = 'no';
    $curDataArr = $this->getLinkingBearDataArray($selemID);
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curDataLangArr = $this->getLinkingBearDataArrayOnLang($selemID);
      if (isset($curDataLangArr) && is_array($curDataLangArr)) {
        $curDataArr = $curDataLangArr;
        $isLang = 'yes';
      }
    }
    
    if (isset($curDataArr) && is_array($curDataArr)) {
      $return = $this->buildLinkInhaltFormsBear($elemArt, $selemID, $curDataArr, $isLang);
    }
    else {
      $return = $this->buildLinkInhaltForms($elemArt, $selemID, $isLang);
    }
    
    return $return;
  }
  
  
  
  private function buildLinkInhaltForms($elemArt, $selemID, $isOnLangSet = 'no') {
    $return = '<div class="vFrontFrmHolder">';
    
      $return .= '<div class="vFrontFrmAbstand"></div>

            <label for="linkingTarget">Link anzeigen:*</label>
            <div class="vFrontLblAbstand"></div>
            <select name="linkingTarget" id="linkingTarget">';
      /*if (isset($bearSiteArr['seitNaviTarget'])) {
        $return .= $this->getTheLinkTarget($bearSiteArr['seitNaviTarget']);
      }
      else {*/
        $return .= $this->getTheLinkTarget();
      //}
      $return .= '</select>';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint vFrontActiveArtPoint" data-id="normal">URL</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint" data-id="seite">Seite</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint" data-id="bild">Bild</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint" data-id="datei">Datei</div>';
      $return .= '<div class="clearer"></div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<div class="linkingLinkNormalAnzeige" style="display:block;">';
      $return .= '<label for="linkingLink">Link:*</label>';
      $return .= '<input maxlength="255" type="text" name="linkingLink" id="linkingLink" />';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkSeitenAnzeige">';
      $return .= '<label>Seite:*</label>';
      $return .= '<div id="linkingShowSeitenAuswahlWin"><div id="linkingShowSeitenAuswahlWinText"></div><span id="linkingShowSeitenAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkBildAnzeige">';
      $return .= '<label>Bild:*</label>';
      $return .= '<div id="linkingShowBildAuswahlWin"><div id="linkingShowBildAuswahlWinText"></div><span id="linkingShowBildAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkDateiAnzeige">';
      $return .= '<label>Datei:*</label>';
      $return .= '<div id="linkingShowDateiAuswahlWin"><div id="linkingShowDateiAuswahlWinText"></div><span id="linkingShowDateiAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<label for="linkingClassName">HTML Class Name:</label>';
      $return .= '<input maxlength="100" type="text" name="linkingClassName" id="linkingClassName" />';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<input type="checkbox" name="linkIsInLightbox" id="linkIsInLightbox" value="on" />';
      $return .= '<label for="linkIsInLightbox">In Lightbox anzeigen</label>';
      
      $return .= '<div id="linkIsInLightboxWidthHeightFormsHolder" style="display:none;">';
        $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
        $return .= '<label for="linkInLightboxWidth">Lightbox Breite:</label>';
        $return .= '<input maxlength="100" type="text" name="linkInLightboxWidth" id="linkInLightboxWidth" style="width:125px;" /> (z.B. 150px oder 50%)';
        
        $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
        $return .= '<label for="linkInLightboxHeight">Lightbox Höhe:</label>';
        $return .= '<input maxlength="100" type="text" name="linkInLightboxHeight" id="linkInLightboxHeight" style="width:125px;" /> (z.B. 150px oder 50%)';
      $return .= '</div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';
      
      /*$return .= '<input type="submit" value="Link löschen" id="linkingDelBtn" data-id="' . $selemID . '" />';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';*/
      
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<input type="submit" value="Spracheintrag Link Speichern" id="linkingSaveBtnOnLangMM" data-id="' . $selemID . '" />';
      }
      else {
        $return .= '<input type="submit" value="Speichern" id="linkingSaveBtn" data-id="' . $selemID . '" />';
      }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildLinkInhaltFormsBear($elemArt, $selemID, $curDataArr, $isOnLangSet = 'no') {
    // Variablen setzen
    $normalMenuPoint = '';
    $seiteMenuPoint = '';
    $bildMenuPoint = '';
    $dateiMenuPoint = '';
    $normalShow = '';
    $seiteShow = '';
    $bildShow = '';
    $dateiShow = '';
    if ($curDataArr['linkArt'] == 'normal') {
      $normalMenuPoint = ' vFrontActiveArtPoint';
      $normalShow = ' style="display:block;"';
    }
    if ($curDataArr['linkArt'] == 'seite') {
      $seiteMenuPoint = ' vFrontActiveArtPoint';
      $seiteShow = ' style="display:block;"';
    }
    if ($curDataArr['linkArt'] == 'bild') {
      $bildMenuPoint = ' vFrontActiveArtPoint';
      $bildShow = ' style="display:block;"';
    }
    if ($curDataArr['linkArt'] == 'datei') {
      $dateiMenuPoint = ' vFrontActiveArtPoint';
      $dateiShow = ' style="display:block;"';
    }
    // **********************************************************************
    
    $return = '<div class="vFrontFrmHolder">';
    
      $return .= '<div class="vFrontFrmAbstand"></div>

            <label for="linkingTarget">Link anzeigen:*</label>
            <div class="vFrontLblAbstand"></div>
            <select name="linkingTarget" id="linkingTarget">';
      if (isset($curDataArr['linkTarget'])) {
        $return .= $this->getTheLinkTarget($curDataArr['linkTarget']);
      }
      else {
        $return .= $this->getTheLinkTarget();
      }
      $return .= '</select>';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$normalMenuPoint.'" data-id="normal">URL</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$seiteMenuPoint.'" data-id="seite">Seite</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$bildMenuPoint.'" data-id="bild">Bild</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$dateiMenuPoint.'" data-id="datei">Datei</div>';
      $return .= '<div class="clearer"></div>';
      
      
      
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<div class="linkingLinkNormalAnzeige"'.$normalShow.'>';
      $return .= '<label for="linkingLink">Link:*</label>';
      $return .= '<input maxlength="255" type="text" name="linkingLink" id="linkingLink" value="' . $curDataArr['link'] . '" />';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkSeitenAnzeige"'.$seiteShow.'>';
      $return .= '<label>Seite:*</label>';
      $return .= '<div id="linkingShowSeitenAuswahlWin"><div id="linkingShowSeitenAuswahlWinText">'.$this->getTheLinkingSiteName($curDataArr).'</div><span id="linkingShowSeitenAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkBildAnzeige"'.$bildShow.'>';
      $return .= '<label>Bild:*</label>';
      $return .= '<div id="linkingShowBildAuswahlWin"><div id="linkingShowBildAuswahlWinText">'.$this->getTheLinkingBildName($curDataArr).'</div><span id="linkingShowBildAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkDateiAnzeige"'.$dateiShow.'>';
      $return .= '<label>Datei:*</label>';
      $return .= '<div id="linkingShowDateiAuswahlWin"><div id="linkingShowDateiAuswahlWinText">'.$this->getTheLinkingDateiName($curDataArr).'</div><span id="linkingShowDateiAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      
      
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<label for="linkingClassName">HTML Class Name:</label>';
      $return .= '<input maxlength="100" type="text" name="linkingClassName" id="linkingClassName" value="' . $curDataArr['linkClass'] . '" />';
      
      
      $linkInLightCheckedSet = '';
      $styleStateLightboxLinkingWidthHeightHolder = 'display:none;';
      $linkLightboxWidthVal = '';
      $linkLightboxHeightVal = '';
      if (isset($curDataArr['linkIsInLightbox']) && $curDataArr['linkIsInLightbox'] == 'on') {
        $linkInLightCheckedSet = ' checked="checked"';
        $styleStateLightboxLinkingWidthHeightHolder = 'display:block;';
        
        if (isset($curDataArr['linkInLightboxWidth'])) {
          $linkLightboxWidthVal = $curDataArr['linkInLightboxWidth'];
        }
        if (isset($curDataArr['linkInLightboxHeight'])) {
          $linkLightboxHeightVal = $curDataArr['linkInLightboxHeight'];
        }
      }
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<input'.$linkInLightCheckedSet.' type="checkbox" name="linkIsInLightbox" id="linkIsInLightbox" value="on" />';
      $return .= '<label for="linkIsInLightbox">In Lightbox anzeigen</label>';
      
      $return .= '<div id="linkIsInLightboxWidthHeightFormsHolder" style="'.$styleStateLightboxLinkingWidthHeightHolder.'">';
        $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
        $return .= '<label for="linkInLightboxWidth">Lightbox Breite:</label>';
        $return .= '<input maxlength="100" type="text" name="linkInLightboxWidth" id="linkInLightboxWidth" style="width:125px;" value="'.$linkLightboxWidthVal.'" /> (z.B. 150px oder 50%)';
        
        $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
        $return .= '<label for="linkInLightboxHeight">Lightbox Höhe:</label>';
        $return .= '<input maxlength="100" type="text" name="linkInLightboxHeight" id="linkInLightboxHeight" style="width:125px;" value="'.$linkLightboxHeightVal.'" /> (z.B. 150px oder 50%)';
      $return .= '</div>';
      
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';
      
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        if (isset($isOnLangSet) && $isOnLangSet == 'yes') {
          $return .= '<input type="submit" value="Spracheintrag Link löschen" id="linkingDelBtnOnLangMM" data-id="' . $selemID . '" />';
        }
      }
      else {
        $return .= '<input type="submit" value="Link löschen" id="linkingDelBtn" data-id="' . $selemID . '" />';
      }
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';
      
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $return .= '<input type="submit" value="Spracheintrag Link Speichern" id="linkingSaveBtnOnLangMM" data-id="' . $selemID . '" />';
      }
      else {
        $return .= '<input type="submit" value="Speichern" id="linkingSaveBtn" data-id="' . $selemID . '" />';
      }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getLinkingBearDataArray($selemID) {
    $return = '';
    
    $sqlText = 'SELECT selemLink FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowL = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($rowL['selemLink']) && !empty($rowL['selemLink'])) {
        $return = json_decode($rowL['selemLink'], true);
      }
    }
    
    return $return;
  }
  
  
  
  private function getLinkingBearDataArrayOnLang($selemID) {
    $curLangID = $this->getLinkingCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    $return = '';
    
    $sqlText = 'SELECT selangLink FROM vselemlang WHERE selemID = ' . $this->dbDecode($selemID) . ' AND langID = ' . $this->dbDecode($curLangID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowL = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($rowL['selangLink']) && !empty($rowL['selangLink'])) {
        $return = json_decode($rowL['selangLink'], true);
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Ausgabe Linking Window
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Verlinkungen Speichern (Element Normal)
  // ***************************************************************************
  
  public function saveLinkInElementNormalNow() {
    $linkBuild = array();
    $linkBuild['link'] = $_POST['_linkingLink'];
    $linkBuild['linkTarget'] = $_POST['_linkingTarget'];
    $linkBuild['linkClass'] = $_POST['_linkingClassName'];
    $linkBuild['linkArt'] = $_POST['_linkArt'];
    
    if (isset($_POST['_linkIsInLightbox']) && $_POST['_linkIsInLightbox'] == 'on') {
      $linkBuild['linkIsInLightbox'] = $_POST['_linkIsInLightbox'];
      $linkBuild['linkInLightboxWidth'] = $_POST['_linkInLightboxWidth'];
      $linkBuild['linkInLightboxHeight'] = $_POST['_linkInLightboxHeight'];
    }
    
    $linkBuildJson = json_encode($linkBuild);
    
    $sqlText = 'UPDATE vseitenelemente SET selemLink = "' . $this->dbDecode($linkBuildJson) . '" WHERE selemID = ' . $this->dbDecode($_POST['_elemID']);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function saveLinkInElementNormalNowOnLangMM() {
    $linkBuild = array();
    $linkBuild['link'] = $_POST['_linkingLink'];
    $linkBuild['linkTarget'] = $_POST['_linkingTarget'];
    $linkBuild['linkClass'] = $_POST['_linkingClassName'];
    $linkBuild['linkArt'] = $_POST['_linkArt'];
    
    if (isset($_POST['_linkIsInLightbox']) && $_POST['_linkIsInLightbox'] == 'on') {
      $linkBuild['linkIsInLightbox'] = $_POST['_linkIsInLightbox'];
      $linkBuild['linkInLightboxWidth'] = $_POST['_linkInLightboxWidth'];
      $linkBuild['linkInLightboxHeight'] = $_POST['_linkInLightboxHeight'];
    }
    
    $linkBuildJson = json_encode($linkBuild);
    
    $curLangID = $this->getLinkingCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    
    if ($this->checkLinkingElementHasDataLang($_POST['_elemID'], $curLangID)) {
      $sqlUpText = 'UPDATE vselemlang SET selangLink = "' . $this->dbDecode($linkBuildJson) . '" WHERE langID = ' . $this->dbDecode($curLangID) . ' AND selemID = ' . $this->dbDecode($_POST['_elemID']);
      return $this->dbAbfragen($sqlUpText);
    }
    else {
      $dummyText = '';
      if ($this->checkIsElementOwnElementForInhaltDummy($_POST['_elemID'])) {
        $dummyText = '{"elemBild1":"[vcms-empty-lang]", "elemBild2":"[vcms-empty-lang]", "elemBild3":"[vcms-empty-lang]", "elemBild4":"[vcms-empty-lang]", "elemBild5":"[vcms-empty-lang]", "elemBild6":"[vcms-empty-lang]", "elemBild7":"[vcms-empty-lang]", "elemBild8":"[vcms-empty-lang]", "elemBildLink1":"[vcms-empty-lang]", "elemBildLink2":"[vcms-empty-lang]", "elemBildLink3":"[vcms-empty-lang]", "elemBildLink4":"[vcms-empty-lang]", "elemBildLink5":"[vcms-empty-lang]", "elemBildLink6":"[vcms-empty-lang]", "elemBildLink7":"[vcms-empty-lang]", "elemBildLink8":"[vcms-empty-lang]", "elemText1":"[vcms-empty-lang]", "elemText2":"[vcms-empty-lang]", "elemText3":"[vcms-empty-lang]", "elemText4":"[vcms-empty-lang]", "elemText5":"[vcms-empty-lang]", "elemText6":"[vcms-empty-lang]", "elemText7":"[vcms-empty-lang]", "elemText8":"[vcms-empty-lang]"}';
      }
      
      $sqlNewText = 'INSERT INTO vselemlang (selemID, langID, selangInhalt, selangLink) VALUES (' . $this->dbDecode($_POST['_elemID']) . ', ' . $this->dbDecode($curLangID) . ', "' . $this->dbDecode($dummyText) . '", "'.$this->dbDecode($linkBuildJson).'")';
      return $this->dbAbfragen($sqlNewText);
    }
  }
  
  
  
  private function checkIsElementOwnElementForInhaltDummy($selemId) {
    $sqlText = 'SELECT elemID FROM vseitenelemente WHERE selemID = "'.$this->dbDecode($selemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curElemID = $row['elemID'];
    }
    
    if (isset($curElemID) && !empty($curElemID)) {
      $sqlTextS = 'SELECT elemEigen FROM velement WHERE elemID = "'.$this->dbDecode($curElemID).'" LIMIT 1';
      $sqlErgS = $this->dbAbfragen($sqlTextS);

      while ($rowS = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
        if($rowS['elemEigen'] == 2) {
          return true;
        }
      }
    }
    
    return false;
  }

  // ***************************************************************************
  // ENDE - Funktionen Verlinkungen Speichern (Element Normal)
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Verlinkungen Löschen (Element Normal)
  // ***************************************************************************
  
  public function delLinkInElementNormalNow() {
    $sqlText = 'UPDATE vseitenelemente SET selemLink = "" WHERE selemID = ' . $this->dbDecode($_POST['_elemID']);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delLinkInElementNormalNowOnLangMM() {
    $curLangID = $this->getLinkingCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    $sqlUpText = 'UPDATE vselemlang SET selangLink = "" WHERE langID = ' . $this->dbDecode($curLangID) . ' AND selemID = ' . $this->dbDecode($_POST['_elemID']);
    return $this->dbAbfragen($sqlUpText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Verlinkungen Löschen (Element Normal)
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Hilfs Funktionen
  // ***************************************************************************
  
  /**
  * Funktion gibt die Link Targets für das DropDown Menü zurück
  *
  * @param string $isCheck - Target String
  * @return string
  */
  protected function getTheLinkTarget($isCheck = '') {
    $targetArr = array(
      '_self' => 'in gleichen Fenster',
      '_blank' => 'in neuem Fenster',
    );

    $return = '';

    foreach ($targetArr as $key => $target) {
      if ($key == $isCheck) {
        $return .= '<option selected="selected" value="' . $key . '">' . $target . '</option>';
      }
      else {
        $return .= '<option value="' . $key . '">' . $target . '</option>';
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Hilfs Funktionen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für die Linking Seitenauswahl
  // ***************************************************************************
  
  public function showLinkingSeitenauswahlWin($depp = 0, $parentID = 0, $nartID = 1) {
    $return = '';
    if ($depp < 1) {
      $return .= $this->getLinkingSeitenauswahlWinNaviArtsSelect($nartID);
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
        
        $return .= '<div class="vFrontBaumElem ' . $curImgClass . $curSiteIsOnline . $curSiteIsOnNavi . '" data-id="' . $rowSeitBaum['seitID'] . '" data-name="' . $rowSeitBaum['seitName'] . '">' . $curSiteBaumName;
        
        $return .= '</div>';
        $return .= $this->showLinkingSeitenauswahlWin($depp + 1, $rowSeitBaum['seitID'], $nartID);
        $return .= '</div>';
      }

      $return .= '</div>';
      
      if ($depp < 1) {
        $return .= '</div>';
      }
      
      return $return;
    }
  }
  
  
  
  private function getLinkingSeitenauswahlWinNaviArtsSelect($selectedNartID) {
    $return = '';
    
    $return .= '<div class="vFrontSeitenAuflistungAuswahlNaviArtHolder"><label>Navigationsart:</label>
    <select id="vFrontSeitenAuflistungAuswahlNaviArtSelect" name="vFrontSeitenAuflistungAuswahlNaviArtSelect">';
    
    $sqlNavArtText = 'SELECT * FROM vnaviart';
    $sqlNavArtErg = $this->dbAbfragen($sqlNavArtText);
    
    while ($rowNavArt = mysql_fetch_array($sqlNavArtErg, MYSQL_ASSOC)) {
      if ($rowNavArt['nartID'] == $selectedNartID) {
        $return .= '<option selected="selected" value="' . $rowNavArt['nartID'] . '">' . $rowNavArt['nartName'] . '</option>';
      }
      else {
        $return .= '<option value="' . $rowNavArt['nartID'] . '">' . $rowNavArt['nartName'] . '</option>';
      }
    }
    
    $return .= '</select>
    </div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für die Linking Seitenauswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für die Linking Bildauswahl
  // ***************************************************************************
  
  public function showLinkingBildauswahlWin() {
    $curBilderObj = new cmsBilder();
    return $curBilderObj->getBilderAuswahlPics();
  }
  
  
  
  public function showLinkingBildauswahlWinReload($curKatID) {
    $curBilderObj = new cmsBilder();
    return $curBilderObj->getBilderAuswahlPics($curKatID, true);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für die Linking Bildauswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für die Linking Dateiauswahl
  // ***************************************************************************
  
  public function showLinkingDateiauswahlWin() {
    $curDateienObj = new cmsDateiVerwaltung();
    return $curDateienObj->getDateienAuswahlFiles();
  }
  
  
  
  public function showLinkingDateiauswahlWinReload($curKatID) {
    $curDateienObj = new cmsDateiVerwaltung();
    return $curDateienObj->getDateienAuswahlFiles($curKatID, true);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für die Linking Dateiauswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für die Linking Seite, Bild und Datei Ausgabe
  // ***************************************************************************
  
  function getTheLinkingSiteName($curDataArr) {
    if ($curDataArr['linkArt'] == 'seite') {
      $sqlText = 'SELECT seitName FROM vseiten WHERE seitID = ' . $this->dbDecode($curDataArr['link']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $row['seitName'];
      }
    }
  }
  
  
  
  function getTheLinkingBildName($curDataArr) {
    if ($curDataArr['linkArt'] == 'bild') {
      $sqlText = 'SELECT bildFile FROM vbilder WHERE bildID = ' . $this->dbDecode($curDataArr['link']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $row['bildFile'];
      }
    }
  }
  
  
  
  function getTheLinkingDateiName($curDataArr) {
    if ($curDataArr['linkArt'] == 'datei') {
      $sqlText = 'SELECT dateiFile FROM vdateien WHERE dateiID = ' . $this->dbDecode($curDataArr['link']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $row['dateiFile'];
      }
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für die Linking Seite, Bild und Datei Ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // Funktionen für Sprachen ID und Prüfen
  // *******************************************************************
  private function getLinkingCurentLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  private function checkLinkingElementHasDataLang($siteElemId, $langId) {
    $sqlCheckText = 'SELECT selangID FROM vselemlang WHERE langID = ' . $this->dbDecode($langId) . ' AND selemID = ' . $this->dbDecode($siteElemId) . ' LIMIT 1';
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckNum = mysql_num_rows($sqlCheckErg);
    if (isset($sqlCheckNum) && $sqlCheckNum > 0) {
      return true;
    }
    return false;
  }
  // *******************************************************************
  
}

?>