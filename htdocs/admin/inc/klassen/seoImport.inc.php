<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


class cmsSeoImport extends funktionsSammlung {
  
  public function importCurentDescInTextareaSeoSite($siteId, $lang = '') {
    $setLang = '';
    if (isset($lang) && !empty($lang)) {
      $setLang = '/'.$lang;
    }
    
    $basePath = $_SERVER['HTTP_HOST'];
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }
    
    $curSiteUrl = '';
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = "'.$this->dbDecode($siteId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curSiteUrl = $row['seitTextUrl'];
    }
    
    if ($this->getTheCurCMSStartSiteId() == $siteId) {
      $html = file_get_contents($setBaseHTTP.$basePath.$setLang.'?isCmsSeoImportDesc=rQfk14LRTzu');
      $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
      return $html;
    }
    else {
      $html = file_get_contents($setBaseHTTP.$basePath.$setLang.'/'.$curSiteUrl.'?isCmsSeoImportDesc=rQfk14LRTzu');
      $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);
      return $html;
    }
  }
  
  
  
  public function importCurentDescInTextareaSeoSiteTextNow($curContentText) {
    $curTextZw = trim(strip_tags($curContentText));
    $curTextZw = preg_replace("/(\r?\n)/Us", " ", $curTextZw);
    $curTextZw = html_entity_decode($curTextZw);
    $curTextZw = preg_replace('/\s\s+/', ' ', $curTextZw);
    return $curTextZw;
  }
  
  
  
  public function importCurentMetaTitleInTextboxSeoSite($siteId, $lang = '') {
    $setLang = '';
    if (isset($lang) && !empty($lang)) {
      $setLang = '/'.$lang;
    }
    
    $basePath = $_SERVER['HTTP_HOST'];
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }
    
    $curSiteUrl = '';
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = "'.$this->dbDecode($siteId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curSiteUrl = $row['seitTextUrl'];
    }
    
    if ($this->getTheCurCMSStartSiteId() == $siteId) {
      return strip_tags(file_get_contents($setBaseHTTP.$basePath.$setLang.'?isCmsSeoImportTitle=aZgh67FTTja'));
    }
    else {
      return strip_tags(file_get_contents($setBaseHTTP.$basePath.$setLang.'/'.$curSiteUrl.'?isCmsSeoImportTitle=aZgh67FTTja'));
    }
  }
  
}

?>