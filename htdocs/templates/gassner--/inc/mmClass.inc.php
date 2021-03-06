<?php

// Funktions Sammlung
// ************************************************
// Version:  2.0.0
// 
// Entwickler: Michael Marth
// ************************************************


class mmFunctionsLibrary extends funktionsSammlung {
  
  // ***************************************************************************
  // Detail Seiten Listenansicht
  // ***************************************************************************
  
  public function mmGetSiteListDataArray($siteParent, $detailElemId) {
    $return = array();
    
    $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$row['seitID']] = array();
      $return[$row['seitID']]['seitTextUrl'] = $row['seitTextUrl'];
      $return[$row['seitID']]['detailElemData'] = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
        unset($return[$row['seitID']]);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return[$row['seitID']]['detailElemData']['selemID']) == false) {
        unset($return[$row['seitID']]);
      }
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteListDataArrayOnce($siteId, $detailElemId) {
    $return = array();
    
    $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($siteId).' AND seitOnline = 1 ORDER BY seitPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return['seitID'] = $row['seitID'];
      $return['seitTextUrl'] = $row['seitTextUrl'];
      $return['detailElemData'] = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
        unset($return);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return['detailElemData']['selemID']) == false) {
        unset($return);
      }
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteDetailElementDataArr($siteId, $detailElemId) {
    $return = array();
    $langInhaltJson = '';
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLangID = $this->getCurentLangIdBySiteTextUri($_POST['VCMS_POST_LANG']);
      $langInhaltJson = $this->mmGetSiteDetailElementDataInhaltJsonOnLang($curLangID, $siteId, $detailElemId);
    }
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteId).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
      if (isset($langInhaltJson) && !empty($langInhaltJson)) {
        $return['selemInhalt'] = $this->buildNewCurentLangJsonSelemInhalt($return['selemInhalt'], $langInhaltJson);
      }
    }
    
    /*if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($siteId) == false) {
      unset($return);
    }*/
    
    return $return;
  }
  
  
  
  public function getAllSiteIDsArrUnderThisParent($siteParent) {
    $return = array();
    
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return['s'.$row['seitID']] = $row['seitID'];
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Detail Seiten Listenansicht - Sprachfelder
  // ***************************************************************************
  
  public function getCurentLangIdBySiteTextUri($langUri) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUri) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteDetailElementDataInhaltJsonOnLang($langID, $siteID, $detailElemId) {
    $return = '';
    
    $sElemId = $this->mmGetSiteDetailElementIdForLang($siteID, $detailElemId);
    
    $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE langID = "' . $this->dbDecode($langID) . '" AND selemID = "'.$this->dbDecode($sElemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['selangInhalt'];
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteDetailElementIdForLang($siteID, $detailElemId) {
    $return = '';
    
    $sqlText = 'SELECT selemID FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteID).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['selemID'];
    }
    
    return $return;
  }
  
  
  
  public function buildNewCurentLangJsonSelemInhalt($selemInhalt, $selemInhaltLang) {
    $selemInhaltArrNew = array();
    $selemInhaltArr = json_decode($selemInhalt, true);
    $selemInhaltLangArr = json_decode($selemInhaltLang, true);
    
    foreach ($selemInhaltArr as $key => $value) {
      if (isset($selemInhaltLangArr[$key]) && !empty($selemInhaltLangArr[$key]) && $selemInhaltLangArr[$key] != '[vcms-empty-lang]') {
        $selemInhaltArrNew[$key] = $selemInhaltLangArr[$key];
      }
      else {
        $selemInhaltArrNew[$key] = $value;
      }
    }
    
    return json_encode($selemInhaltArrNew);
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Bilder
  // ***************************************************************************
  
  public function getAllPicOnceIdsFromPicGalery($picGalId) {
    $return = '';
    
    $sqlText = 'SELECT galBilder FROM vbildergalerien WHERE galID = "'.$this->dbDecode($picGalId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['galBilder'];
    }
    
    return $return;
  }
  
  
  
  public function getAllPicOnceIdsFromElementPicGalery($selemConfig) {
    $return = '';
    
    if (isset($selemConfig) && !empty($selemConfig)) {
      $curSelemConfArr = json_decode($selemConfig, true);
      if (isset($curSelemConfArr['picGal']) && !empty($curSelemConfArr['picGal'])) {
        $return = $curSelemConfArr['picGal'];
      }
    }
    
    return $return;
  }
  
  
  
  public function getPicOnceDataByIdMM($picId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($picId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Filtersystem Kategorien
  // ***************************************************************************
  
  public function mmGetAllFilterkategoriesListArray($siteParent, $detailElemId, $assocArr = false) {
    $return = array();
    
    echo  $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $detailElemArr = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      if (isset($detailElemArr['selemOwnConfig']) && !empty($detailElemArr['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($detailElemArr['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $explodeArr = explode(';', $detailElemSettingArr['vOwnUserSettings']['filterKat']);
          foreach ($explodeArr as $value) {
            $curDataNameFilKat = $this->mmGetOneFiltersystemKatDataName($value);
            if (isset($curDataNameFilKat) && !empty($curDataNameFilKat)) {
              
              $curDataNameFilKat = str_replace('p_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('az_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('tt_', '', $curDataNameFilKat);
              
              if (isset($assocArr) && $assocArr == true) {
                $return['i'.$value] = $curDataNameFilKat;
              }
              else {
                $return[$value] = $curDataNameFilKat;
              }
            }
          }
        }
      }
    }
    
    return $return;
  }
  
  
  
  public function mmGetAllFilterkategoriesListFromOneDetailElementArray($detailElemId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "'.$detailElemId.'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemOwnConfig']) && !empty($row['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($row['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $return = $detailElemSettingArr['vOwnUserSettings']['filterKat'];
        }
      }
    }
    
    return $return;
  }
  
  
  
  private function mmGetOneFiltersystemKatDataName($filterKatId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 AND filkatID = "'.$filterKatId.'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['filkatName'];
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        if (isset($row['filtkatLangJson']) && !empty($row['filtkatLangJson'])) {
          $curLangJsonArr = json_decode($row['filtkatLangJson'], true);
          $curLangK = $_POST['VCMS_POST_LANG'];
          if (isset($curLangJsonArr['vFilterKatNameLang_'.$curLangK]) && !empty($curLangJsonArr['vFilterKatNameLang_'.$curLangK])) {
            $return = $curLangJsonArr['vFilterKatNameLang_'.$curLangK];
          }
        }
      }
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  public function getCurSiteNameBySiteIdOnlyMM($curSiteId) {
    $return = '';
    
    $sqlText = 'SELECT seitID, seitName FROM vseiten WHERE seitID = '.$this->dbDecode($curSiteId).' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['seitName'];
    }
    
    return $return;
  }
  
}


?>