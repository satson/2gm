<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsLinkParse extends funktionsSammlung {
  
  public function parseInTextLinking($curSiteInhalt) {
    if (!checkIsUserLogedIn()) {
      // @[art:seite][id:1]
      $pattern = '/@\[art:([^\]]+)\]\[id:(\d+)\]/';
      $count = preg_match_all($pattern, $curSiteInhalt, $matches, PREG_SET_ORDER);

      foreach ($matches as $match) {
        $patternR = '/@\[art:'.$match[1].'\]\[id:'.$match[2].'\]/';
        $replacement = $this->buildNewInTextLink($match);
        $curSiteInhalt = preg_replace($patternR, $replacement, $curSiteInhalt);
      }
    }
    
    return $curSiteInhalt; //.'<pre>'.print_r($matches, 1).'</pre>'.$code;
  }
  
  
  
  private function buildNewInTextLink($matchArr) {
    $curLang = '';
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLang = $_POST['VCMS_POST_LANG'].'/';
    }
    
    if ($matchArr[1] == 'normal') {
      return $matchArr[2];
    }
    else if ($matchArr[1] == 'seite') {
      return $this->buildNewInTextLinkSeite($matchArr, $curLang);
    }
    else if ($matchArr[1] == 'bild') {
      return $this->buildNewInTextLinkBild($matchArr, $curLang);
    }
    else if ($matchArr[1] == 'datei') {
      return $this->buildNewInTextLinkDatei($matchArr, $curLang);
    }
    
    return $curLang.'#'; //$matchArr[1].'-'.$matchArr[2].'-hans';
  }
  
  
  
  private function buildNewInTextLinkSeite($matchArr, $curLang) {        
    if (isset($matchArr[2]) && !empty($matchArr[2])) {
      $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($matchArr[2]).' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return $curLang.$row['seitTextUrl'];
      }
    }
    
    return $curLang.'#';
  }
  
  
  
  private function buildNewInTextLinkBild($matchArr, $curLang) {
    if (isset($matchArr[2]) && !empty($matchArr[2])) {
      $sqlText = 'SELECT bildFile FROM vbilder WHERE bildID = '.$this->dbDecode($matchArr[2]).' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return 'user_upload/'.$row['bildFile'];
      }
    }
    
    return $curLang.'#';
  }
  
  
  
  private function buildNewInTextLinkDatei($matchArr, $curLang) {
    if (isset($matchArr[2]) && !empty($matchArr[2])) {
      $sqlText = 'SELECT dateiFile FROM vdateien WHERE dateiID = '.$this->dbDecode($matchArr[2]).' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return 'user_upload_files/'.$row['dateiFile'];
      }
    }
    
    return $curLang.'#';
  }
  
}

?>