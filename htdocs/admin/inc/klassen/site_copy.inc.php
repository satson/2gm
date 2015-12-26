<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsSiteCopy extends funktionsSammlung {
  
  public function copyThisSiteInSiteBaumNow($curSiteCopyID) {
    $newSiteId = $this->copyTheSiteCompleteNow($curSiteCopyID);
    if (isset($newSiteId) && is_int($newSiteId)) {
      $this->copyTheSiteElementsCompleteNow($curSiteCopyID, $newSiteId);
      $this->copyTheSiteFelderCompleteNow($curSiteCopyID, $newSiteId);
      return 'ok';
    }
    else {
      return 'error';
    }
  }
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seite Kopieren und Spracheintrag
  // ***************************************************************************
  
  private function copyTheSiteCompleteNow($curSiteCopyID) {
    $newSiteId = '';
    $sqlText = 'SELECT * FROM vseiten WHERE seitID = "'.$this->dbDecode($curSiteCopyID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $newSiteId = $this->copyTheSiteCompleteNowInsert($row);
    }
    
    if (isset($newSiteId) && is_int($newSiteId)) {
      $this->copyTheSiteCompleteNowInsertLang($curSiteCopyID, $newSiteId);
    }
    
    return $newSiteId;
  }
  
  
  
  private function copyTheSiteCompleteNowInsert($copySiteArr) {
    if ($copySiteArr['seitArt'] == 3) {
      $curCopyTextUrl = '';
    }
    else {
      $curCopyTextUrl = $this->generateNewCopyTextUrl($copySiteArr['seitTextUrl']);
    }
    $curCopyName = $copySiteArr['seitName'].'-Copy';
    
    if ($copySiteArr['seitArt'] == 3) {
      $sqlText = 'INSERT INTO vseiten (seitArt, seitCreateDate, seitOnline, seitOnlineAb, seitOnlineBis, seitName, seitTextUrl, seitMetaTitle, seitMetaDesc, seitMetaKeywords, seitNoNavi, seitNaviName, seitNaviLink, seitNaviLinkSiteID, seitNaviTarget, seitMobile, seitParent, seitPosition, seitBackImages, seitListImage, seitSlideImages, seitProdukte, seitIsLang, seitCanonical, seitNoIndex, hpID, nartID) 
              VALUES 
              ("'.$this->dbDecode($copySiteArr['seitArt']).'", "'.$this->dbDecode(date('Y-m-d H:i:s')).'", "'.$this->dbDecode($copySiteArr['seitOnline']).'", "'.$this->dbDecode($copySiteArr['seitOnlineAb']).'", "'.$this->dbDecode($copySiteArr['seitOnlineBis']).'", "'.$this->dbDecode($curCopyName).'", "'.$this->dbDecode($curCopyTextUrl).'", "", "", "", "'.$this->dbDecode($copySiteArr['seitNoNavi']).'", "'.$this->dbDecode($copySiteArr['seitNaviName']).'", "'.$this->dbDecode($copySiteArr['seitNaviLink']).'", "'.$this->dbDecode($copySiteArr['seitNaviLinkSiteID']).'", "'.$this->dbDecode($copySiteArr['seitNaviTarget']).'", "'.$this->dbDecode($copySiteArr['seitMobile']).'", 0, 0, "'.$this->dbDecode($copySiteArr['seitBackImages']).'", "'.$this->dbDecode($copySiteArr['seitListImage']).'", "'.$this->dbDecode($copySiteArr['seitSlideImages']).'", "'.$this->dbDecode($copySiteArr['seitProdukte']).'", "'.$this->dbDecode($copySiteArr['seitIsLang']).'", "", "1", "'.$this->dbDecode($copySiteArr['hpID']).'", "'.$this->dbDecode($copySiteArr['nartID']).'")';
    }
    else {
      $sqlText = 'INSERT INTO vseiten (seitArt, seitCreateDate, seitOnline, seitOnlineAb, seitOnlineBis, seitName, seitTextUrl, seitMetaTitle, seitMetaDesc, seitMetaKeywords, seitNoNavi, seitNaviName, seitNaviLink, seitNaviLinkSiteID, seitNaviTarget, seitMobile, seitParent, seitPosition, seitBackImages, seitListImage, seitSlideImages, seitProdukte, seitIsLang, seitCanonical, seitNoIndex, hpID, nartID, layID) 
              VALUES 
              ("'.$this->dbDecode($copySiteArr['seitArt']).'", "'.$this->dbDecode(date('Y-m-d H:i:s')).'", "'.$this->dbDecode($copySiteArr['seitOnline']).'", "'.$this->dbDecode($copySiteArr['seitOnlineAb']).'", "'.$this->dbDecode($copySiteArr['seitOnlineBis']).'", "'.$this->dbDecode($curCopyName).'", "'.$this->dbDecode($curCopyTextUrl).'", "", "", "", "'.$this->dbDecode($copySiteArr['seitNoNavi']).'", "'.$this->dbDecode($copySiteArr['seitNaviName']).'", "'.$this->dbDecode($copySiteArr['seitNaviLink']).'", "'.$this->dbDecode($copySiteArr['seitNaviLinkSiteID']).'", "'.$this->dbDecode($copySiteArr['seitNaviTarget']).'", "'.$this->dbDecode($copySiteArr['seitMobile']).'", 0, 0, "'.$this->dbDecode($copySiteArr['seitBackImages']).'", "'.$this->dbDecode($copySiteArr['seitListImage']).'", "'.$this->dbDecode($copySiteArr['seitSlideImages']).'", "'.$this->dbDecode($copySiteArr['seitProdukte']).'", "'.$this->dbDecode($copySiteArr['seitIsLang']).'", "", "1", "'.$this->dbDecode($copySiteArr['hpID']).'", "'.$this->dbDecode($copySiteArr['nartID']).'", "'.$this->dbDecode($copySiteArr['layID']).'")';
    }
    
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if ($sqlErg == true) {
      return mysql_insert_id();
    }
  }
  
  
  
  private function copyTheSiteCompleteNowInsertLang($curSiteCopyID, $newSiteId) {
    /*$sqlText = 'SELECT * FROM vseitelang WHERE seitID = "'.$this->dbDecode($curSiteCopyID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curCopyLaName = $row['seitlaName'].'-Copy';
      
      $sqlTextI = 'INSERT INTO vseitelang (seitlaName, seitlaTextUrl, seitlaMetaTitle, seitlaMetaDesc, seitlaMetaKeywords, seitlaBackImages, seitlaListImage, seitlaSlideImages, seitID, langID) 
              VALUES 
              ("'.$this->dbDecode($curCopyLaName).'", "'.$this->dbDecode($row['seitlaTextUrl']).'", "'.$this->dbDecode($row['seitlaMetaTitle']).'", "'.$this->dbDecode($row['seitlaMetaDesc']).'", "'.$this->dbDecode($row['seitlaMetaKeywords']).'", "'.$this->dbDecode($row['seitlaBackImages']).'", "'.$this->dbDecode($row['seitlaListImage']).'", "'.$this->dbDecode($row['seitlaSlideImages']).'", "'.$this->dbDecode($newSiteId).'", "'.$this->dbDecode($row['langID']).'")';
      $sqlErgI = $this->dbAbfragen($sqlTextI);
    }*/
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seite Kopieren und Spracheintrag
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Elemente Kopieren und Spracheintrag
  // ***************************************************************************
  
  private function copyTheSiteElementsCompleteNow($curSiteCopyID, $newSiteId) {
    $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($curSiteCopyID) . ' AND (selemInElement = "" OR selemInElement IS NULL) AND selemDataName NOT LIKE "curInElementHolder%"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $cmsElementeCoObj = new cmsElemente();
      $cmsElementeCoObj->saveCopyDragElemNow($row['selemDataName'], $newSiteId, $row['selemID'], $row['selemPosition']);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Elemente Kopieren und Spracheintrag
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seitenfelder Kopieren und Spracheintrag
  // ***************************************************************************
  
  private function copyTheSiteFelderCompleteNow($curSiteCopyID, $newSiteId) {
    $sqlText = 'SELECT * FROM vseitenfelder WHERE seitID = '.$this->dbDecode($curSiteCopyID);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $this->copyTheSiteFelderCompleteNowInsert($row, $newSiteId);
    }
  }
  
  
  
  private function copyTheSiteFelderCompleteNowInsert($copySiteFeldArr, $newSiteId) {
    $sqlText = 'INSERT INTO vseitenfelder (sfeldInhalt, sfeldConfig, seitID, feldID) VALUES ("'.$this->dbDecode($copySiteFeldArr['sfeldInhalt']).'", "'.$this->dbDecode($copySiteFeldArr['sfeldConfig']).'", "'.$this->dbDecode($newSiteId).'", "'.$this->dbDecode($copySiteFeldArr['feldID']).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if ($sqlErg == true) {
      $newFeldId = mysql_insert_id();
      $this->copyTheSiteFelderCompleteNowInsertLang($copySiteFeldArr, $newFeldId);
    }
  }
  
  
  
  private function copyTheSiteFelderCompleteNowInsertLang($copySiteFeldArr, $newFeldId) {
    /*$sqlText = 'SELECT * FROM vseitenfelderlang WHERE sfeldID = '.$this->dbDecode($copySiteFeldArr['sfeldID']);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlTextI = 'INSERT INTO vseitenfelderlang (sfeldlaInhalt, sfeldlaConfig, sfeldID, langID) VALUES ("'.$this->dbDecode($row['sfeldlaInhalt']).'", "'.$this->dbDecode($row['sfeldlaConfig']).'", "'.$this->dbDecode($newFeldId).'", "'.$this->dbDecode($row['langID']).'")';
      $sqlErgI = $this->dbAbfragen($sqlTextI);
    }*/
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seitenfelder Kopieren und Spracheintrag
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Hilfs Funktionen
  // ***************************************************************************
  
  private function generateNewCopyTextUrl($origTextUrl) {
    $return = '';
    
    $isOkUri = false;
    $isCount = 0;
    
    while ($isOkUri != true) {
      if ($isCount == 0) {
        if ($this->checkIsTextUriNotExists($origTextUrl.'-Copy')) {
          $isOkUri = true;
          $return .= $origTextUrl.'-Copy';
        }
      }
      else {
        if ($this->checkIsTextUriNotExists($origTextUrl.'-Copy-'.$isCount)) {
          $isOkUri = true;
          $return .= $origTextUrl.'-Copy-'.$isCount;
        }
      }
      $isCount++;
    }
    
    return $return;
  }
  
  
  
  private function checkIsTextUriNotExists($textUrl) {
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitTextUrl = "'.$this->dbDecode($textUrl).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    if ($sqlCount > 0) {
      return false;
    }
    else {
      return true;
    }
  }

  // ***************************************************************************
  // ENDE - Hilfs Funktionen
  // ***************************************************************************
  
}

?>