<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class funktionsSammlung {
  
    

    
  /**
  * Funktion für die Datenbank Abfrage
  *
  * @return Datenbank Erg oder false
  */
  public function dbAbfragen($sql_text) {
    if (!empty($sql_text)) {
      $result = mysql_query($sql_text); // or die(mysql_error());
      return $result;
    }
    else {
      return false;
    }
  }
  
  
  /**
  * Funktion für Decode mysql_real_escape_string
  *
  * @return string
  */
  public function dbDecode($textDecode) {
    return mysql_real_escape_string($textDecode);
  }
  
  
  
  
  
  
  
  
  
  
  public function checkIsShopModulActiv() {
    $return = false;
    $curHpIdNow = '';
    
    if (defined('VCMS_HOMEPAGE_ID')) {
      $curHpIdNow = VCMS_HOMEPAGE_ID;
    }
    else if (isset($_SESSION['VCMS_HP_ID']) && !empty($_SESSION['VCMS_HP_ID'])) {
      $curHpIdNow = $_SESSION['VCMS_HP_ID'];
    }
    
    if (isset($curHpIdNow) && !empty($curHpIdNow)) {
      $sqlHpText = 'SELECT hpShopAktiv FROM vhomepage WHERE hpID = ' . $this->dbDecode($curHpIdNow) . ' LIMIT 1';
      $sqlHpErg = $this->dbAbfragen($sqlHpText);

      while ($rowHp = mysql_fetch_array($sqlHpErg, MYSQL_ASSOC)) {
        if (isset($rowHp['hpShopAktiv']) && $rowHp['hpShopAktiv'] == 1) {
          return true;
        }
      }
    }
    
    return $return;
  }
  
  
  
  public function checkIsThisModuleActive($curModuleName) {
    $confHpModulArr = array();
    
    $sqlText = 'SELECT hpModulConfig FROM vhomepage WHERE hpID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['hpModulConfig']) && !empty($row['hpModulConfig'])) {
        $confHpModulArr = json_decode($row['hpModulConfig'], true);
      }
    }
    
    if (isset($confHpModulArr[$curModuleName]['install']) && $confHpModulArr[$curModuleName]['install'] == 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  
  
  
  
  public function getTheCurCMSStartSiteId() {
    $checkCurHpID = 0;
    if (isset($_SESSION['VCMS_HP_ID']) && !empty($_SESSION['VCMS_HP_ID'])) {
      $checkCurHpID = $_SESSION['VCMS_HP_ID'];
    }
    else {
      $checkCurHpID = VCMS_HOMEPAGE_ID;
    }
    
    $return = 0;
    $sqlText = 'SELECT hpSeitStart FROM vhomepage WHERE hpID = '.$this->dbDecode($checkCurHpID);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowC = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowC['hpSeitStart'];
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  public function getCurentLinkBySiteIdUser($curSiteID) {
    $curLang = '';
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLang = $_POST['VCMS_POST_LANG'].'/';
    }
    
    $return = $curLang.'#';
    
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = "'.$this->dbDecode($curSiteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $curLang.$row['seitTextUrl'];
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Seite Online / Offline Prüfen
  // ***************************************************************************
  
  public function checkIsThisSiteOnlineByCheckAndDateTimeMM($siteID) {
    
    // Die Startseite kann nicht Offline sein
    // ***********************************************************
    if ($this->getTheCurCMSStartSiteId() == $siteID) {
      return true;
    }
    // ***********************************************************
    
    $return = true;
    
    $sqlText = 'SELECT seitOnline, seitOnlineAb, seitOnlineBis FROM vseiten WHERE seitID = "'.$this->dbDecode($siteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['seitOnline']) && $row['seitOnline'] == 2) {
        $return = false;
      }
      else {
      
        if ((isset($row['seitOnlineAb']) && !empty($row['seitOnlineAb']) && $row['seitOnlineAb'] != '0000-00-00 00:00:00') || (isset($row['seitOnlineBis']) && !empty($row['seitOnlineBis']) && $row['seitOnlineBis'] != '0000-00-00 00:00:00')) {

          $onlineAbArr = $this->buildNormalDateTimeAusgabeFromDbString($row['seitOnlineAb']);
          $onlineBisArr = $this->buildNormalDateTimeAusgabeFromDbString($row['seitOnlineBis']);

          $curDateAb = $this->buildCurrentDateDatabaseFormatForElemsDTMM($onlineAbArr[0]);
          $curTimeAb = $this->buildCurrentTimeDatabaseFormatForElemsDTMM($onlineAbArr[1], 'ab');
          $curDateBis = $this->buildCurrentDateDatabaseFormatForElemsDTMM($onlineBisArr[0]);
          $curTimeBis = $this->buildCurrentTimeDatabaseFormatForElemsDTMM($onlineBisArr[1], 'bis');
          $curDateTimeAktuell = strtotime(date('Y-m-d H:i:s'));

          if ((isset($curDateAb) && !empty($curDateAb)) && (isset($curDateBis) && !empty($curDateBis))) {
            if (strtotime($curDateAb.$curTimeAb) >= $curDateTimeAktuell || strtotime($curDateBis.$curTimeBis) <= $curDateTimeAktuell) {
              $return = false;
            }
          }
          else if (isset($curDateAb) && !empty($curDateAb)) {
            if (strtotime($curDateAb.$curTimeAb) >= $curDateTimeAktuell) {
              $return = false;
            }
          }
          else if (isset($curDateBis) && !empty($curDateBis)) {
            if (strtotime($curDateBis.$curTimeBis) <= $curDateTimeAktuell) {
              $return = false;
            }
          }

        }
      
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // Element Online / Offline Prüfen
  // ***************************************************************************
  
  public function checkIsThisElementOnlineByCheckAndDateTimeMM($selemID) {
    $allSelemSystemConfigArr = '';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "'.$this->dbDecode($selemID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $allSelemSystemConfigArr = json_decode($row['selemOwnConfig'], true);
    }
    
    if ((isset($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate']) && !empty($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate'])) || (isset($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']) && !empty($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']))) {
      $curDateAb = $this->buildCurrentDateDatabaseFormatForElemsDTMM($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbDate']);
      $curTimeAb = $this->buildCurrentTimeDatabaseFormatForElemsDTMM($allSelemSystemConfigArr['vSysSettings']['elemOnlineAbTime'], 'ab');
      $curDateBis = $this->buildCurrentDateDatabaseFormatForElemsDTMM($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisDate']);
      $curTimeBis = $this->buildCurrentTimeDatabaseFormatForElemsDTMM($allSelemSystemConfigArr['vSysSettings']['elemOnlineBisTime'], 'bis');
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
  
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // Element und Seiten Online / Offline - Hilfsfunktionen
  // ***************************************************************************
  
  private function buildCurrentDateDatabaseFormatForElemsDTMM($date) {
    if (isset($date) && !empty($date)) {
      $dateZw = explode('.', $date);
      return $dateZw[2].'-'.$dateZw[1].'-'.$dateZw[0];
    }
    else {
      return '';
    }
  }
  
  
  
  private function buildCurrentTimeDatabaseFormatForElemsDTMM($time, $art) {
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
  
  
  
  private function buildNormalDateTimeAusgabeFromDbString($curDatabaseTimeString) {
    $dateTimeArr = array();
    $dateTimeArr[0] = '';
    $dateTimeArr[1] = '';
    
    if (isset($curDatabaseTimeString) && !empty($curDatabaseTimeString) && $curDatabaseTimeString != '0000-00-00 00:00:00') {
      $curOnlineBearZw = explode(' ', $curDatabaseTimeString);
      $curOnlineBearZwDate = explode('-', $curOnlineBearZw[0]);
      $curOnlineBearZwTime = explode(':', $curOnlineBearZw[1]);
      $dateTimeArr[0] = $curOnlineBearZwDate[2].'.'.$curOnlineBearZwDate[1].'.'.$curOnlineBearZwDate[0];
      $dateTimeArr[1] = $curOnlineBearZwTime[0].':'.$curOnlineBearZwTime[1];
    }
    
    return $dateTimeArr;
  }
  
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // Breadcrumbs
  // ***************************************************************************
  
  public function getSiteBreadcrumbsString($placer = '') {
    global $cms;
    $return = '';
    
    $return .= $this->getSiteBreadcrumbsStringNow($cms['cms_siteID'], 1, $placer);
    
    return $return;
  }
  
  
  
  private function getSiteBreadcrumbsStringNow($siteID, $count = 1, $placer) {
    global $cms;
    $return = '';
    $isStartseite = false;
    
    if ($count == 1 && $siteID == 1) {
      return '';
    }
    
    if ($siteID == 0) {
      $isStartseite = true;
      $siteID = 1;
    }
    
    
    $sqlText = 'SELECT seitParent, seitName, seitTextUrl, seitArt, seitID FROM vseiten WHERE seitID = ' . $this->dbDecode($siteID). ' ORDER BY seitID ASC';
    
    
    $sqlErg = $this->dbAbfragen($sqlText);
   
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curSiteName = $row['seitName'];
      
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curSiteName = $this->getSiteBreadcrumbsStringNameLangNow($curSiteName, $row['seitID'], $_POST['VCMS_POST_LANG']);
      }
      
      if ($count == 1 || $row['seitArt'] == 3) {
        $return .= '<span>'.$placer.$curSiteName.'</span>';
      }
      else {
        $return .= '<span ><a href="'.SITE_URL.$row['seitTextUrl'].'">'.$placer.$curSiteName.'</a></span>';
      }
      
      if ($isStartseite == false) {
        $count = $count + 1;
        $return .= $this->getSiteBreadcrumbsStringNow($row['seitParent'], $count, $placer);
      }
    }
    
    return $return;
  }
  
  
  
  private function getSiteBreadcrumbsStringNameLangNow($curSiteOrigName, $siteID, $curLangUrl) {
    $curLangId = $this->getCurentLangIdFromUrlNameBreadCrumbsMM($curLangUrl);
    
    $sqlNameText = 'SELECT seitlaName FROM vseitelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlNameErg = $this->dbAbfragen($sqlNameText);
    $curLangName = '';
    while ($rowName = mysql_fetch_array($sqlNameErg, MYSQL_ASSOC)) {
      $curLangName = $rowName['seitlaName'];
    }
    if (isset($curLangName) && !empty($curLangName)) {
      return $curLangName;
    }
    return $curSiteOrigName;
  }
  
  
  
  private function getCurentLangIdFromUrlNameBreadCrumbsMM($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  // ***************************************************************************
  
  
  
  public function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator == 'dash') 
		{
		    $separator = '-';
		}
		else if ($separator == 'underscore')
		{
		    $separator = '_';
		}
		
		$q_separator = preg_quote($separator);
		$trans = array(
			'&.+?;'                 => '',
			'[^a-z0-9 _-]'          => '',
			'\s+'                   => $separator,
			'('.$q_separator.')+'   => $separator
		);
		$str = strip_tags($str);
		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}
		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}
		return trim($str, $separator);
	}
        
        
        public function checkIfActiveSiteLang($idSite,$idLang){
            $row = array(); 
           
            $query = mysql_query("SELECT siteActive FROM vseitelang WHERE seitID = '$idSite' AND langID = '$idLang'");
            
            if(mysql_num_rows($query) == 1){
                 $row   = mysql_fetch_array($query);
                 if($row['siteActive'] == 'yes'){
                    return true; 
                 }else{
                    return false; 
                 }
            }else{
                return true;
            }
          
        }  
}

?>