<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2015                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsOwnFiltersystem extends funktionsSammlung {
  
  public function showFilterSystemAdminWindow() {
    $return = '<div class="mmModulFiltersysAdminWindowHolder">';
    
    $return .= '<div class="mmModulFiltersysAdminWindowHead">';
    //$return .= '<div class="mmModulFiltersysAdminWindowHeadAuswahlFiltKatBtn">Auswählen</div>';
    $return .= '<div class="mmModulFiltersysAdminWindowHeadNewFiltKatBtn">Neue Filterkategorie</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    $return .= '<div class="mmModulFiltersysAdminWindowKatAuswahlHolder">';
    $return .= $this->getFilterSystemAdminWindowKategorienShow();
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getFilterSystemAdminWindowKategorienShow() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 ORDER BY filkatName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiFiltersysKat" data-id="'.$row['filkatID'].'" style="margin-right:0px;">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">'.$row['filkatName'].'</div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElChange vFrontFiltersysAdminWinListChangeBtn" title="Bearbeiten" data-id="'.$row['filkatID'].'"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElDel vFrontFiltersysAdminWinListDelBtn" title="Löschen" data-id="'.$row['filkatID'].'"></div>';
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  
  
  // ***************************************************************************
  // Neue Filtersystem Kategorie
  // ***************************************************************************
  
  public function showNewFiltersystemAdminKatgorieWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vFiltersystemFrmFiltKatName">Name:</label>';
    $return .= '<input id="vFiltersystemFrmFiltKatName" type="text" name="vFiltersystemFrmFiltKatName" />';
    $return .= '<form id="vFiltersystemFrmFiltKatNameLangs">';
    $return .= $this->getForFiltersystemActiveCMSLangsFields();
    $return .= '</form>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input id="vFrontSaveNewNewFiltersystemKatForms" type="submit" value="Speichern" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getForFiltersystemActiveCMSLangsFields() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 AND langStandard = 2 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNumErg = mysql_num_rows($sqlErg);
    
    if (isset($sqlNumErg) && $sqlNumErg > 0) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div style="border-bottom:1px solid #999; width:348px; padding-bottom:5px;">Spracheinträge:</div>';
    }
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      
      $return .= '<label for="vFilterKatNameLang_'.$row['langKurzName'].'">Name: ('.$row['langKurzName'].')</label>';
      $return .= '<input id="vFilterKatNameLang_'.$row['langKurzName'].'" type="text" name="vFilterKatNameLang_'.$row['langKurzName'].'" />';
    }
    
    return $return;
  }
  
  
  
  public function saveNewFiltersystemAdminKatgorieWindow($filterKatName) {
    $curLangJson = '';
    if (isset($_POST['_langFilterKat']) && is_array($_POST['_langFilterKat'])) {
      $counter = 0;
      foreach ($_POST['_langFilterKat'] as $key => $value) {
        $counter++;
        
        if (isset($counter) && $counter == 1) {
          $curLangJson .= '{';
          $curLangJson .= '"'.$value['name'].'":"'.$value['value'].'"';
        }
        else {
          $curLangJson .= ', "'.$value['name'].'":"'.$value['value'].'"';
        }
      }
      
      if (isset($counter) && $counter > 0) {
        $curLangJson .= '}';
      }
    }
    
    $sqlText = 'INSERT INTO vfilterkategorien (filkatName, filkatParent, filkatAktiv, filtkatLangJson) VALUES ("'.$this->dbDecode($filterKatName).'", "0", "1", "'.$this->dbDecode($curLangJson).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if (isset($sqlErg) && $sqlErg == true) {
      $curNewId = mysql_insert_id();
      
      $sqlTextU = 'UPDATE vfilterkategorien SET filtkatPosition = "'.$this->dbDecode($curNewId).'" WHERE filkatID = "'.$this->dbDecode($curNewId).'"';
      $sqlErgU = $this->dbAbfragen($sqlTextU);
    }
  }
  
  
  
  
  
  
  // ***************************************************************************
  // Filtersystem Kategorie Bearbeiten
  // ***************************************************************************
  
  public function showBearFiltersystemAdminKatgorieWindow($filterKatID) {
    $curDataArr = $this->getForBearFiltersystemAdminKatgorieWindowData($filterKatID);
    
    if (!isset($curDataArr) || !is_array($curDataArr)) {
      return 'No Data';
    }
    
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vFiltersystemFrmFiltKatName">Name:</label>';
    $return .= '<input id="vFiltersystemFrmFiltKatName" type="text" name="vFiltersystemFrmFiltKatName" value="'.$curDataArr['filkatName'].'" />';
    $return .= '<form id="vFiltersystemFrmFiltKatNameLangs">';
    $return .= $this->getForFiltersystemActiveCMSLangsFieldsBear($curDataArr);
    $return .= '</form>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input id="vFrontSaveBearFiltersystemKatForms" type="submit" value="Speichern" data-id="'.$curDataArr['filkatID'].'" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getForFiltersystemActiveCMSLangsFieldsBear($curDataArr) {
    $return = '';
    
    $curJsonLangArr = '';
    if (isset($curDataArr['filtkatLangJson']) && !empty($curDataArr['filtkatLangJson'])) {
      $curJsonLangArr = json_decode($curDataArr['filtkatLangJson'], true);
    }
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 AND langStandard = 2 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNumErg = mysql_num_rows($sqlErg);
    
    if (isset($sqlNumErg) && $sqlNumErg > 0) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div style="border-bottom:1px solid #999; width:348px; padding-bottom:5px;">Spracheinträge:</div>';
    }
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curLangVal = '';
      if (isset($curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']]) && !empty($curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']])) {
        $curLangVal = $curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']];
      }
      
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      
      $return .= '<label for="vFilterKatNameLang_'.$row['langKurzName'].'">Name: ('.$row['langKurzName'].')</label>';
      $return .= '<input id="vFilterKatNameLang_'.$row['langKurzName'].'" type="text" name="vFilterKatNameLang_'.$row['langKurzName'].'" value="'.$curLangVal.'" />';
    }
    
    return $return;
  }
  
  
  
  private function getForBearFiltersystemAdminKatgorieWindowData($filterKatID) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatID = "'.$this->dbDecode($filterKatID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  public function saveBearFiltersystemAdminKatgorieWindow($filterKatName, $curFilterKatID) {
    $curLangJson = '';
    if (isset($_POST['_langFilterKat']) && is_array($_POST['_langFilterKat'])) {
      $counter = 0;
      foreach ($_POST['_langFilterKat'] as $key => $value) {
        $counter++;
        
        if (isset($counter) && $counter == 1) {
          $curLangJson .= '{';
          $curLangJson .= '"'.$value['name'].'":"'.$value['value'].'"';
        }
        else {
          $curLangJson .= ', "'.$value['name'].'":"'.$value['value'].'"';
        }
      }
      
      if (isset($counter) && $counter > 0) {
        $curLangJson .= '}';
      }
    }
    
    $sqlText = 'UPDATE vfilterkategorien SET filkatName = "'.$this->dbDecode($filterKatName).'", filtkatLangJson = "'.$this->dbDecode($curLangJson).'" WHERE filkatID = "'.$this->dbDecode($curFilterKatID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Löscht eine Filtersystem Kategorie
  // ***************************************************************************
  
  public function delFiltersystemAdminKatgorieNow($filterKatID) {
    $sqlText = 'DELETE FROM vfilterkategorien WHERE filkatID = "'.$this->dbDecode($filterKatID).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Zeigt die Filtersystem Kategorien für Listen zuweisung an
  // ***************************************************************************
  
  public function showFiltersystemAuswahlListBySettingsAuswahlWinMulti() {
    $return = '<div class="mmModulFiltersysAdminWindowHolder">';
    
    $return .= '<div class="mmModulFiltersysAdminWindowHead">';
    $return .= '<div class="mmModulFiltersysAdminWindowHeadAuswahlFiltKatBtn">Auswählen</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    $return .= '<div class="mmModulFiltersysAdminWindowKatAuswahlHolder">';
    $return .= $this->getFilterSystemAdminWindowKategorienShowAuswahlList();
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getFilterSystemAdminWindowKategorienShowAuswahlList() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 ORDER BY filkatName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiFiltersysKat" data-id="'.$row['filkatID'].'" data-name="'.$row['filkatName'].'" style="margin-right:0px;">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">'.$row['filkatName'].'</div>';
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
}

?>