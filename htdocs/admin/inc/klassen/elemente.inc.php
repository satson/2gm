<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsElemente extends funktionsSammlung {
  
  public function setNewDragElemAndSave($siteDropName, $siteID, $elemID, $dropPosition, $elemPosInherit) {
    if (isset($_POST['_copySelemID']) && !empty($_POST['_copySelemID'])) {
      $this->saveCopyDragElemNow($siteDropName, $siteID, $_POST['_copySelemID'], $dropPosition);
    }
    else {
      $this->saveNewDragElem($siteDropName, $siteID, $elemID, $dropPosition);
    }
    return $this->setElemHolderInhaltReload($siteDropName, $siteID, $elemPosInherit);
  }
  
  
  
  private function saveNewDragElem($siteDropName, $siteID, $elemID, $dropPosition) {
    $elemArrF = $this->getCurElementArrayLoadNow($elemID);
    $dummyText = '';
    if ($elemID == 1) {
      $dummyText .= 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.';
    }
    else if (isset($elemArrF['elemEigen']) && $elemArrF['elemEigen'] == 2) {
      $dummyText .= '{"elemBild1":"", "elemBild2":"", "elemBild3":"", "elemBild4":"", "elemBild5":"", "elemBild6":"", "elemBild7":"", "elemBild8":"", "elemBildLink1":"", "elemBildLink2":"", "elemBildLink3":"", "elemBildLink4":"", "elemBildLink5":"", "elemBildLink6":"", "elemBildLink7":"", "elemBildLink8":"", "elemText1":"<p>Lorem ipsum</p>", "elemText2":"<p>Lorem ipsum</p>", "elemText3":"<p>Lorem ipsum</p>", "elemText4":"<p>Lorem ipsum</p>", "elemText5":"<p>Lorem ipsum</p>", "elemText6":"<p>Lorem ipsum</p>", "elemText7":"<p>Lorem ipsum</p>", "elemText8":"<p>Lorem ipsum</p>"}';
    }
    
    $sqlSaveText = 'INSERT INTO vseitenelemente (selemHidden, selemDataName, selemInhalt, selemPosition, seitID, elemID) VALUES (2, "' . $this->dbDecode($siteDropName) . '", "' . $this->dbDecode($dummyText) . '", ' . $this->dbDecode($dropPosition) . ', ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($elemID) . ')';
    $sqlSaveErg = $this->dbAbfragen($sqlSaveText);
    return $sqlSaveErg;
  }
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Elemente hinzufügen Spalten
  // ***************************************************************************
  
  public function setNewDragSpaltenElemAndSave($siteDropName, $siteID, $elemID, $dropPosition, $elemPosInherit, $selemCurID, $selemRowID) {
    if (isset($elemID) && $elemID == 4) {
      return;
    }
    if (isset($_POST['_copySelemID']) && !empty($_POST['_copySelemID'])) {
      if (!$this->checkIsCopyElementARowElem($_POST['_copySelemID'])) {
        $this->saveSpaltenCopyDragElemNow($siteDropName, $siteID, $elemID, $dropPosition, $selemCurID, $selemRowID, $_POST['_copySelemID']);
      }
    }
    else {
      $this->saveNewDragSpaltenElem($siteDropName, $siteID, $elemID, $dropPosition, $selemCurID, $selemRowID);
    }
    return $this->setElemHolderInhaltReload($siteDropName, $siteID, $elemPosInherit);
  }
  
  
  
  private function saveNewDragSpaltenElem($siteDropName, $siteID, $elemID, $dropPosition, $selemCurID, $selemRowID) {
    $elemArrF = $this->getCurElementArrayLoadNow($elemID);
    $dummyText = '';
    if ($elemID == 1) {
      $dummyText .= 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.';
    }
    else if (isset($elemArrF['elemEigen']) && $elemArrF['elemEigen'] == 2) {
      $dummyText .= '{"elemBild1":"", "elemBild2":"", "elemBild3":"", "elemBild4":"", "elemBild5":"", "elemBild6":"", "elemBild7":"", "elemBild8":"", "elemBildLink1":"", "elemBildLink2":"", "elemBildLink3":"", "elemBildLink4":"", "elemBildLink5":"", "elemBildLink6":"", "elemBildLink7":"", "elemBildLink8":"", "elemText1":"<p>Lorem ipsum</p>", "elemText2":"<p>Lorem ipsum</p>", "elemText3":"<p>Lorem ipsum</p>", "elemText4":"<p>Lorem ipsum</p>", "elemText5":"<p>Lorem ipsum</p>", "elemText6":"<p>Lorem ipsum</p>", "elemText7":"<p>Lorem ipsum</p>", "elemText8":"<p>Lorem ipsum</p>"}';
    }
    
    $sqlSaveText = 'INSERT INTO vseitenelemente (selemInElement, selemHidden, selemInhalt, seitID, elemID) VALUES (' . $selemCurID . ', 2, "' . $this->dbDecode($dummyText) . '", ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($elemID) . ')';
    $sqlSaveErgA = $this->dbAbfragen($sqlSaveText);
    
    if ($sqlSaveErgA) {
      $this->setNewSpaltenElemIn(mysql_insert_id(), $dropPosition, $selemCurID, $selemRowID);
    }
  }
  
  
  
  private function setNewSpaltenElemIn($newID, $dropPosition, $selemCurID, $selemRowID) {
    $sqlAbText = 'SELECT selemInhalt FROM vseitenelemente WHERE selemID = ' .  $this->dbDecode($selemCurID) . ' LIMIT 1';
    $sqlAbErg = $this->dbAbfragen($sqlAbText);
    while ($rowAb = mysql_fetch_array($sqlAbErg, MYSQL_ASSOC)) {
      $curNewInhalt = $this->buildNewSpaltenInhaltJSON($rowAb['selemInhalt'], $selemRowID, $newID, $dropPosition);
      $sqlSaveText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($curNewInhalt) . '" WHERE selemID = ' . $this->dbDecode($selemCurID);
      $sqlSaveErg = $this->dbAbfragen($sqlSaveText);
    }
  }
  
  
  
  private function buildNewSpaltenInhaltJSON($oldInhalt, $selemRowID, $newID, $dropPosition) {
    $oldInhaltJson = json_decode($oldInhalt, true);
    $buildNewInhalt = '';
    
    if (isset($oldInhaltJson[$selemRowID])) {
      $count = 0;
      $curIdsArr = explode(';', $oldInhaltJson[$selemRowID]);
      $newInhaltIds = '';
      foreach ($curIdsArr as $curIdOwn) {
        $count++;
        if ($count == 1) {
          if ($count == $dropPosition) {
            $newInhaltIds .= $newID.';'.$curIdOwn;
          }
          else {
            $newInhaltIds .= ''.$curIdOwn;
          }
        }
        else {
          if ($count == $dropPosition) {
            $newInhaltIds .= ';'.$newID.';'.$curIdOwn;
          }
          else {
            $newInhaltIds .= ';'.$curIdOwn;
          }
        }
      }
      if ((count($curIdsArr)+1) == $dropPosition) {
        $newInhaltIds .= ';'.$newID;
      }
      $oldInhaltJson[$selemRowID] = $newInhaltIds;
    }
    else {
      $oldInhaltJson[$selemRowID] = $newID;
    }
    
    $buildNewInhalt .= json_encode($oldInhaltJson);
    //$buildNewInhalt = '{"' . $selemRowID . '":"' . $newID . '"}';
    
    return $buildNewInhalt;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Elemente hinzufügen Spalten
  // ***************************************************************************
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Element Löschen
  // ***************************************************************************
  
  public function delThisSiteElemNow($selemID, $siteDropName, $siteID, $elemPosInherit) {
    $sqlDelLangText = 'DELETE FROM vselemlang WHERE selemID = ' . $this->dbDecode($selemID);
    $this->dbAbfragen($sqlDelLangText);
    
    $sqlDelText = 'DELETE FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemID);
    $this->dbAbfragen($sqlDelText);
    
    return $this->setElemHolderInhaltReload($siteDropName, $siteID, $elemPosInherit);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Element Löschen
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Elemente Sortieren
  // ***************************************************************************
  
  public function sortTheCurentElements($allElemsIDs) {
    $elemIdArr = explode(';', $allElemsIDs);
    $elemPos = 0;
    
    foreach ($elemIdArr as $elemId) {
      $elemPos = $elemPos + 2;
      $sqlTextPos = 'UPDATE vseitenelemente SET selemPosition = ' . $this->dbDecode($elemPos) . ' WHERE selemID = ' . $this->dbDecode($elemId);
      $sqlErgPos = $this->dbAbfragen($sqlTextPos);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Elemente Sortieren
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Spalten Elemente Sortieren
  // ***************************************************************************
  
  public function sortTheCurentSpaltenElementsNow($sortString, $rowNumber, $curElemId) {
    $sqlText = 'SELECT selemInhalt FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($curElemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $oldString = '';
    
    while($rowSp = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $oldString = $rowSp['selemInhalt'];
    }
    
    if (isset($oldString) && !empty($oldString)) {
      $oldStringArr = json_decode($oldString, true);
      $oldStringArr[$rowNumber] = $sortString;
      $newString = json_encode($oldStringArr);

      $sqlUpText = 'UPDATE vseitenelemente SET selemInhalt = "' . $this->dbDecode($newString) . '" WHERE selemID = ' . $this->dbDecode($curElemId);
      $sqlUpErg = $this->dbAbfragen($sqlUpText);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Spalten Elemente Sortieren
  // ***************************************************************************








  // ***************************************************************************
  // ANFANG - Funktionen für Element Reload nach Drag & Drop
  // ***************************************************************************
  
  public function setElemHolderInhaltReload($siteDropName, $siteID, $elHolderInherit = 'noinherit') {
    $elemSelfObj = new cmsElementeSelf();
    return $elemSelfObj->setElemHolderInhaltLoad($siteDropName, $siteID, $elHolderInherit, true);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Element Reload nach Drag & Drop
  // ***************************************************************************
  
  
  
  
  
  
  
  private function getCurElementArrayLoadNow($elemID) {
    $return = array();
    
    $sqlElText = 'SELECT * FROM velement WHERE elemID = ' . $this->dbDecode($elemID) . ' LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while($rowEl = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $return = $rowEl;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Element Kopieren
  // ***************************************************************************
  
  public function saveCopyDragElemNow($siteDropName, $siteID, $copySelemID, $dropPosition, $isInElementReload = false) {
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($copySelemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNum = mysql_num_rows($sqlErg);
    $curArrSelem = array();
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curArrSelem = $row;
    }
    
    if (isset($sqlNum) && $sqlNum > 0) {
      $curSelemInhaltC = $curArrSelem['selemInhalt'];
      if (isset($curArrSelem['elemID']) && $curArrSelem['elemID'] == 4) {
        $curSelemInhaltC = '';
      }
      
      $sqlSaveText = 'INSERT INTO vseitenelemente (selemHidden, selemDataName, selemInhalt, selemPosition, seitID, elemID, selemConfig, selemLink, selemPicGal, selemPicOnce, selemOwnConfig) VALUES (2, "' . $this->dbDecode($siteDropName) . '", "' . $this->dbDecode($curSelemInhaltC) . '", ' . $this->dbDecode($dropPosition) . ', ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($curArrSelem['elemID']) . ', "' . $this->dbDecode($curArrSelem['selemConfig']) . '", "' . $this->dbDecode($curArrSelem['selemLink']) . '", "' . $this->dbDecode($curArrSelem['selemPicGal']) . '", "' . $this->dbDecode($curArrSelem['selemPicOnce']) . '", "' . $this->dbDecode($curArrSelem['selemOwnConfig']) . '")';
      $sqlSaveErg = $this->dbAbfragen($sqlSaveText);
      if ($sqlSaveErg == true) {
        $newElemId = mysql_insert_id();
        $this->buildCopyElementsLang($copySelemID, $newElemId);
        if (isset($curArrSelem['elemID']) && $curArrSelem['elemID'] == 4) {
          $this->buildCopySpaltenInElements($curArrSelem, $newElemId, $siteID);
        }
        // In Elemente mit Kopieren
        // *********************************************************************
        //if (isset($isInElementReload) && $isInElementReload == false) {
          $this->saveCopyInElementsFromElement($curArrSelem, $newElemId, $siteID);
        //}
        // *********************************************************************
      }
    }
  }
  
  
  
  private function buildCopySpaltenInElements($inhaltArrOld, $newElemId, $siteID) {
    $jsonObjRowElems = json_decode($inhaltArrOld['selemInhalt'], true);
    $newArray = array();
    
    foreach ($jsonObjRowElems as $key => $value) {
      $curSpaltenElems = explode(';', $value);
      $newArray[$key] = '';
      $hans = 0;
      foreach ($curSpaltenElems as $curSelemID) {
        $newInElemId = $this->buildCopyInElementsInSpalten($curSelemID, $newElemId, $siteID);
        if (isset($newInElemId) && !empty($newInElemId)) {
          $this->buildCopyElementsLang($curSelemID, $newInElemId);
          $hans++;
          if ($hans < 2) {
            $newArray[$key] .= $newInElemId;
          }
          else {
            $newArray[$key] .= ';'.$newInElemId;
          }
        }
      }
    }
    
    $sqlText = 'UPDATE vseitenelemente SET selemInhalt = "'. $this->dbDecode(json_encode($newArray)) .'" WHERE selemID = ' . $this->dbDecode($newElemId);
    $sqlErg = $this->dbAbfragen($sqlText);
  }
  
  
  
  private function buildCopyInElementsInSpalten($curSelemID, $newElemId, $siteID) {
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "' . $this->dbDecode($curSelemID) . '" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlSaveText = 'INSERT INTO vseitenelemente (selemHidden, selemInhalt, selemConfig, selemInElement, selemLink, seitID, elemID, selemPicGal, selemPicOnce, selemOwnConfig) VALUES (2, "' . $this->dbDecode($row['selemInhalt']) . '", "' . $this->dbDecode($row['selemConfig']) . '", "' . $this->dbDecode($newElemId) . '", "' . $this->dbDecode($row['selemLink']) . '", ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($row['elemID']) . ', "' . $this->dbDecode($row['selemPicGal']) . '", "' . $this->dbDecode($row['selemPicOnce']) . '", "' . $this->dbDecode($row['selemOwnConfig']) . '")';
      $this->dbAbfragen($sqlSaveText);
      return mysql_insert_id();
    }
  }
  
  
  
  private function buildCopyElementsLang($copySelemID, $newElemId) {
    /*$sqlText = 'SELECT * FROM vselemlang WHERE selemID = ' . $this->dbDecode($copySelemID);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlSaveText = 'INSERT INTO vselemlang (selangConfig, selangInhalt, selangLink, langID, selemID) VALUES ("' . $this->dbDecode($row['selangConfig']) . '", "' . $this->dbDecode($row['selangInhalt']) . '", "' . $this->dbDecode($row['selangLink']) . '", ' . $this->dbDecode($row['langID']) . ', ' . $this->dbDecode($newElemId) . ')';
      $this->dbAbfragen($sqlSaveText);
    }*/
  }
  
  
  
  // Funktionen für in Spalten Drag and Drops
  // *****************************************************
  private function saveSpaltenCopyDragElemNow($siteDropName, $siteID, $elemID, $dropPosition, $selemCurID, $selemRowID, $copySelemID) {
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($copySelemID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNum = mysql_num_rows($sqlErg);
    $curArrSelem = array();
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curArrSelem = $row;
    }
    
    if (isset($sqlNum) && $sqlNum > 0) {
      $curSelemInhaltC = $curArrSelem['selemInhalt'];
      
      $sqlSaveText = 'INSERT INTO vseitenelemente (selemInElement, selemHidden, selemInhalt, seitID, elemID, selemConfig, selemLink, selemPicGal, selemPicOnce, selemOwnConfig) VALUES (' . $selemCurID . ',2, "' . $this->dbDecode($curSelemInhaltC) . '", ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($curArrSelem['elemID']) . ', "' . $this->dbDecode($curArrSelem['selemConfig']) . '", "' . $this->dbDecode($curArrSelem['selemLink']) . '", "' . $this->dbDecode($curArrSelem['selemPicGal']) . '", "' . $this->dbDecode($curArrSelem['selemPicOnce']) . '", "' . $this->dbDecode($curArrSelem['selemOwnConfig']) . '")';
      $sqlSaveErg = $this->dbAbfragen($sqlSaveText);
      if ($sqlSaveErg == true) {
        $newElemId = mysql_insert_id();
        $this->setNewSpaltenElemIn($newElemId, $dropPosition, $selemCurID, $selemRowID);
        $this->buildCopyElementsLang($copySelemID, $newElemId);
      }
    }
  }
  
  
  
  
  private function checkIsCopyElementARowElem($selemId) {
    $sqlText = 'SELECT elemID FROM vseitenelemente WHERE selemID = ' . $this->dbDecode($selemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['elemID']) && $row['elemID'] != 4) {
        return false;
      }
    }
    
    return true;
  }
  // *****************************************************
  
  
  
  
  private function saveCopyInElementsFromElement($curArrSelem, $newElemId, $siteID) {
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemDataName = "curInElementHolder' . $this->dbDecode($curArrSelem['selemID']) . '" ORDER BY selemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $this->saveCopyDragElemNow('curInElementHolder'.$newElemId, $siteID, $row['selemID'], $row['selemPosition'], true);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Element Kopieren
  // ***************************************************************************
  
}

?>