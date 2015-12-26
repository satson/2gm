<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsEditorLinking extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen Ausgabe Editor Linking Window
  // ***************************************************************************
  
  public function getCurentEditorLinkingWindowInhalt($curInhaltUri) {
    $curDataArr = $this->getEditorLinkingBearDataArray($curInhaltUri);
    
    if (isset($curDataArr) && is_array($curDataArr)) {
      $return = $this->buildEditorLinkInhaltFormsBear($curDataArr);
    }
    else {
      $return = $this->buildEditorLinkInhaltForms();
    }
    
    return $return;
  }
  
  
  
  private function buildEditorLinkInhaltForms() {
    $return = '<div class="vFrontFrmHolder">';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      //$return .= '<div class="vFrontLinkingArtMenuPoint vFrontActiveArtPoint" data-id="normal">URL</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint vFrontActiveArtPoint" data-id="seite" style="width:114px;">Seite</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint" data-id="bild" style="width:114px;">Bild</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint" data-id="datei" style="width:114px;">Datei</div>';
      $return .= '<div class="clearer"></div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<div class="linkingLinkNormalAnzeige" style="display:none;">';
      $return .= '<label for="linkingLink">Link:*</label>';
      $return .= '<input maxlength="255" type="text" name="linkingLink" id="linkingLink" />';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkSeitenAnzeige" style="display:block;">';
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
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<input type="submit" value="Speichern" id="editorLinkingSaveBtn" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildEditorLinkInhaltFormsBear($curDataArr) {
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
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      //$return .= '<div class="vFrontLinkingArtMenuPoint'.$normalMenuPoint.'" data-id="normal">URL</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$seiteMenuPoint.'" data-id="seite" style="width:114px;">Seite</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$bildMenuPoint.'" data-id="bild" style="width:114px;">Bild</div>';
      $return .= '<div class="vFrontLinkingArtMenuPoint'.$dateiMenuPoint.'" data-id="datei" style="width:114px;">Datei</div>';
      $return .= '<div class="clearer"></div>';
      
      
      
      
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<div class="linkingLinkNormalAnzeige"'.$normalShow.'>';
      $return .= '<label for="linkingLink">Link:*</label>';
      $return .= '<input maxlength="255" type="text" name="linkingLink" id="linkingLink" value="' . $curDataArr['link'] . '" />';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkSeitenAnzeige"'.$seiteShow.'>';
      $return .= '<label>Seite:*</label>';
      $return .= '<div id="linkingShowSeitenAuswahlWin"><div id="linkingShowSeitenAuswahlWinText">'.$this->getTheEditorLinkingSiteName($curDataArr).'</div><span id="linkingShowSeitenAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkBildAnzeige"'.$bildShow.'>';
      $return .= '<label>Bild:*</label>';
      $return .= '<div id="linkingShowBildAuswahlWin"><div id="linkingShowBildAuswahlWinText">'.$this->getTheEditorLinkingBildName($curDataArr).'</div><span id="linkingShowBildAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="linkingLinkDateiAnzeige"'.$dateiShow.'>';
      $return .= '<label>Datei:*</label>';
      $return .= '<div id="linkingShowDateiAuswahlWin"><div id="linkingShowDateiAuswahlWinText">'.$this->getTheEditorLinkingDateiName($curDataArr).'</div><span id="linkingShowDateiAuswahlWinBtn">auswählen</span></div>';
      $return .= '</div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';
      
      $return .= '<input type="submit" value="Link löschen" id="linkingDelBtn" />';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>
      <div class="vFrontFrmAbstand"></div>';
      
      $return .= '<input type="submit" value="Speichern" id="editorLinkingSaveBtn" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Ausgabe Editor Linking Window
  // ***************************************************************************
  
  
  
  
  
  private function getEditorLinkingBearDataArray($curInhaltUri) {
    $return = '';
    $pattern = '/@\[art:([^\]]+)\]\[id:(\d+)\]/';
    $count = preg_match_all($pattern, $curInhaltUri, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
      $return = array();
      $return['linkArt'] = $match[1];
      $return['link'] = $match[2];
    }
    
    return $return;
  }
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für die Linking Seite, Bild und Datei Ausgabe
  // ***************************************************************************
  
  function getTheEditorLinkingSiteName($curDataArr) {
    if ($curDataArr['linkArt'] == 'seite') {
      $sqlText = 'SELECT seitName FROM vseiten WHERE seitID = ' . $this->dbDecode($curDataArr['link']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $row['seitName'];
      }
    }
  }
  
  
  
  function getTheEditorLinkingBildName($curDataArr) {
    if ($curDataArr['linkArt'] == 'bild') {
      $sqlText = 'SELECT bildFile FROM vbilder WHERE bildID = ' . $this->dbDecode($curDataArr['link']) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $row['bildFile'];
      }
    }
  }
  
  
  
  function getTheEditorLinkingDateiName($curDataArr) {
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
  
}