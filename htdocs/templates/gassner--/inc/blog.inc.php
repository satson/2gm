<?php

// Blog Klasse
// ************************************************
// Version:  1.0.0
// 
// Entwickler: Michael Marth
// ************************************************



class mmBlogFunctions extends funktionsSammlung {
  
  
  // Funktionen gibt die Blog Listen Elemente als Array zurück
  // ***************************************************************************
  public function mmBlogStartsiteListsAll($siteLimit = 10) {
    $return = '';
    $count = 0;
    $beginn = 0;
    
    if (isset($_GET['listPage']) && !empty($_GET['listPage']) && $_GET['listPage'] > 1) {
      $beginn = (intval($_GET['listPage']) * $siteLimit) - $siteLimit;
    }
    
    $sqlText = 'SELECT seitID, seitTextUrl, seitParent, seitCreateDate, seitBackImages FROM vseiten WHERE seitArt = 2 AND seitOnline = 1 ORDER BY seitCreateDate DESC LIMIT '.$this->dbDecode($beginn).', '.$this->dbDecode($siteLimit);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$count] = array();
      $return[$count]['seitID'] = $row['seitID'];
      $return[$count]['seitTextUrl'] = $row['seitTextUrl'];
      $return[$count]['seitParent'] = $row['seitParent'];
      $return[$count]['seitCreateDate'] = $row['seitCreateDate'];
      
      $return[$count]['listImage'] = $this->getBlogListImage($row['seitBackImages']);      
      $return[$count]['listKategorieName'] = $this->getBlogSiteKatName($row['seitParent']);
      $return[$count]['listText'] = $this->getBlogListText($row['seitID']);
      
      $count++;
    }
    
    return $return;
  }
  
  
  
  public function mmBlogMenuListsAll($siteID) {
    $return = '';
    $count = 0;
    
    $sqlText = 'SELECT seitID, seitTextUrl, seitParent, seitCreateDate, seitBackImages FROM vseiten WHERE seitArt = 2 AND seitOnline = 1 AND seitParent = "'.$this->dbDecode($siteID).'" ORDER BY seitCreateDate DESC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$count] = array();
      $return[$count]['seitID'] = $row['seitID'];
      $return[$count]['seitTextUrl'] = $row['seitTextUrl'];
      $return[$count]['seitParent'] = $row['seitParent'];
      $return[$count]['seitCreateDate'] = $row['seitCreateDate'];
      
      $return[$count]['listImage'] = $this->getBlogListImage($row['seitBackImages']);      
      $return[$count]['listKategorieName'] = $this->getBlogSiteKatName($row['seitParent']);
      $return[$count]['listText'] = $this->getBlogListText($row['seitID']);
      
      $count++;
    }
    
    return $return;
  }
  
  
  
  public function mmGetBlogStartListCountAll() {
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitArt = 2 AND seitOnline = 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    return mysql_num_rows($sqlErg);
  }
  
  
  
  private function getBlogSiteKatName($siteParentID) {
    $return = '';
    
    $sqlText = 'SELECT seitID, seitName FROM vseiten WHERE seitID = "'.$this->dbDecode($siteParentID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['seitName'];
    }
    
    return $return;
  }
  
  
  
  private function getBlogListText($siteID) {
    $return = '';
    
    $sqlText = 'SELECT selemInhalt FROM vseitenelemente WHERE seitID = "'.$this->dbDecode($siteID).'" AND elemID = 6 AND selemDataName = "headerText" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curInhaltArr = json_decode($row['selemInhalt'], true);
      $return = strip_tags($curInhaltArr['elemText1']);
    }
    
    return $return;
  }
  
  
  
  private function getBlogListImage($backImagesIds) {
    $return = '';
    
    if (isset($backImagesIds) && !empty($backImagesIds)) {
      $backImageArr = explode(';', $backImagesIds);
      $picArr = $this->getImageDbArrayByID($backImageArr[0]);
      if (isset($picArr) && is_array($picArr)) {
        $curThumbPath = '';
        if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picArr['bildFile'])) {
          $curThumbPath = 'thumb_800/';
        }
        $return = '<img src="user_upload/'.$curThumbPath.$picArr['bildFile'].'" alt="'.$picArr['bildAlt'].'" title="'.$picArr['bildTitel'].'" />';
      }
    }
    
    return $return;
  }
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // Funktionen für Nächster und Vorheriger Beitrag Link
  // ***************************************************************************
  public function getBlogDetailPrevLink($curSiteID) {
    $return = '';
    
    $sqlText = 'SELECT seitCreateDate FROM vseiten WHERE seitID = "'.$this->dbDecode($curSiteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlTextP = 'SELECT seitTextUrl FROM vseiten WHERE seitCreateDate < "'.$row['seitCreateDate'].'" AND seitArt = 2 ORDER BY seitCreateDate DESC LIMIT 1';
      $sqlErgP = $this->dbAbfragen($sqlTextP);
      
      while ($rowP = mysql_fetch_array($sqlErgP, MYSQL_ASSOC)) {
        $return = $rowP['seitTextUrl'];
      }
    }
    
    return $return;
  }
  
  
  
  public function getBlogDetailNextLink($curSiteID) {
    $return = '';
    
    $sqlText = 'SELECT seitCreateDate FROM vseiten WHERE seitID = "'.$this->dbDecode($curSiteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlTextP = 'SELECT seitTextUrl FROM vseiten WHERE seitCreateDate > "'.$row['seitCreateDate'].'" AND seitArt = 2 ORDER BY seitCreateDate ASC LIMIT 1';
      $sqlErgP = $this->dbAbfragen($sqlTextP);
      
      while ($rowP = mysql_fetch_array($sqlErgP, MYSQL_ASSOC)) {
        $return = $rowP['seitTextUrl'];
      }
    }
    
    return $return;
  }
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // Funktionen für Blog Kommentar speichern
  // ***************************************************************************
  public function saveNewBlogCommentNow() {
    $sqlText = 'INSERT INTO vkommentare (komName, komMail, komText, komWebseite, komDate, komAktiv, seitID) VALUES ("'.$this->dbDecode($_POST['_frmBlogSysName']).'", "'.$this->dbDecode($_POST['_frmBlogSysMail']).'", "'.$this->dbDecode($_POST['_frmBlogSysComment']).'", "'.$this->dbDecode($_POST['_frmBlogSysNewsletter']).'", "'.$this->dbDecode(date('Y-m-d H:i:s')).'", 2, "'.$this->dbDecode($_POST['_frmBlogSysSiId']).'")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function sendNewBlogCommentMailNow($sendToMail, $fromName = 'Blog System', $fromMail = 'no-reply@2getmore.at') {
    $mailText = '
    Neuer Blog Beitrag Kommentar:<br />
    ----------------------------------------------------<br />
    <br />
    <table width="600" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="120">Name:</td><td>' . $_POST['_frmBlogSysName'] . '</td>
      </tr>
      <tr>
        <td width="120">E-Mail:</td><td>' . $_POST['_frmBlogSysMail'] . '</td>
      </tr>
      <tr>
        <td width="120">Datum:</td><td>' . date('d.m.Y H:i:s') . '</td>
      </tr>
      <tr>
        <td width="120">Newsletter:</td><td>' . $_POST['_frmBlogSysNewsletter'] . '</td>
      </tr>
      <tr>
        <td width="120">Kommentar:</td><td>' . nl2br($_POST['_frmBlogSysComment']) . '</td>
      </tr>
      
      <tr>
        <td width="120">&nbsp;</td><td>&nbsp;</td>
      </tr>
      
      <tr>
        <td width="120">Blog Beitrag Url:</td><td>' . $_POST['_curHttpUri'] . '</td>
      </tr>
    </table>';
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: " . $fromName . " <" . $fromMail . ">" . "\n";
    $mailSubject = 'Neuer Blog Beitrag Kommentar';
    $mailTo = $sendToMail;


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      //echo 'ok';
    }
  }
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // Funktionen für Blog Kommentare Ausgabe von Seite
  // ***************************************************************************
  public function getAllBlogCommentsFromSite($siteID) {
    $return = '';
    $sqlText = 'SELECT * FROM vkommentare WHERE seitID = "'.$this->dbDecode($siteID).'" AND komAktiv = 2 ORDER BY komDate DESC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curZwArr = explode(' ', $row['komDate']);
      $curDateZwArr = explode('-', $curZwArr[0]);
      $curTimeZwArr = explode(':', $curZwArr[1]);
      $curDate = $curDateZwArr[2].'.'.$curDateZwArr[1].'.'.$curDateZwArr[0];
      $curTime = $curTimeZwArr[0].':'.$curTimeZwArr[1];
      
      $return .= '<div class="blogSysCommentElement">
          <div class="blogSysCommentElementHead">
            <div class="blogSysCommentElementHeadName">'.$row['komName'].' schrieb am '.$curDate.' um '.$curTime.' Uhr</div>';
      if (checkIsUserLogedIn()) {
        $return .= '<div class="blogSysCommentElementHeadDel" title="Kommentar Löschen" data-id="'.$row['komID'].'"></div>';
      }
      $return .= '<div class="clearer"></div>
          </div>
          <div class="blogSysCommentElementText">'.nl2br($row['komText']).'</div>
        </div>';
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  // Funktionen für Neuste Blog Kommentare Ausgabe
  // ***************************************************************************
  public function getNewBlogCommentsLimit($limit = 4) {
    $return = '';
    $sqlText = 'SELECT * FROM vkommentare WHERE komAktiv = 2 ORDER BY komDate DESC LIMIT '.$this->dbDecode($limit);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curZwArr = explode(' ', $row['komDate']);
      $curDateZwArr = explode('-', $curZwArr[0]);
      //$curTimeZwArr = explode(':', $curZwArr[1]);
      $curDate = $curDateZwArr[2].'.'.$curDateZwArr[1].'.'.$curDateZwArr[0];
      //$curTime = $curTimeZwArr[0].':'.$curTimeZwArr[1];
      
      $return .= '<div class="blogSysNewCommentRightElement">
          <div class="blogSysNewCommentRightElementText">'.$row['komText'].' ('.$curDate.')</div>
        </div>';
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  // Funktionen für Blog Links Zufall
  // ***************************************************************************
  public function getBlogLinkAusgabeZufall() {
    $return = '';
    $beitraegeIdArr = $this->getAllBlogBeitraegeIdsArr();
    shuffle($beitraegeIdArr);
    $count = 0;
    foreach ($beitraegeIdArr as $value) {
      $count++;
      if ($count < 3) {
        $curBeitragDataArr = $this->getBeitragDataForZufall($value);
        $return .= $this->buildAusgabeBeitraegeZufall($curBeitragDataArr);
      }
    }
    return $return;
  }
  
  
  
  private function getAllBlogBeitraegeIdsArr() {
    $return = array();
    $count = 0;
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitArt = 2 AND seitOnline = 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$count] = $row['seitID'];
      $count++;
    }
    
    return $return;
  }
  
  
  
  private function getBeitragDataForZufall($siteID) {
    $return = array();
    $sqlText = 'SELECT seitID, seitTextUrl, seitParent, seitCreateDate, seitBackImages FROM vseiten WHERE seitID = "'.$this->dbDecode($siteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return['seitID'] = $row['seitID'];
      $return['seitTextUrl'] = $row['seitTextUrl'];
      $return['seitParent'] = $row['seitParent'];
      $return['seitCreateDate'] = $row['seitCreateDate'];
      
      $return['listImage'] = $this->getBlogListImage($row['seitBackImages']);      
      $return['listKategorieName'] = $this->getBlogSiteKatName($row['seitParent']);
      $return['listText'] = $this->getBlogListText($row['seitID']);
    }
    
    return $return;
  }
  
  
  
  private function buildAusgabeBeitraegeZufall($dataArr) {
    $curZwArr = explode(' ', $dataArr['seitCreateDate']);
    $curDateZwArr = explode('-', $curZwArr[0]);
    //$curTimeZwArr = explode(':', $curZwArr[1]);
    $curDate = $curDateZwArr[2].'.'.$curDateZwArr[1].'.'.$curDateZwArr[0];
    //$curTime = $curTimeZwArr[0].':'.$curTimeZwArr[1];
    
    $return = '<a href="'.$dataArr['seitTextUrl'].'"><div class="siteRandomBlogBeitragElement">';
    $return .= '<div class="siteRandomBlogBeitragElementBild">'.$dataArr['listImage'].'</div>';
    $return .= '<div class="siteRandomBlogBeitragElementText">'.$dataArr['listText'].'</div>';
    $return .= '<div class="siteRandomBlogBeitragElementDate">('.$curDate.')</div>';
    $return .= '</div></a>';
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktion für Bild Daten Array Rückgabe
  // ***************************************************************************
  
  public function getImageDbArrayByID($curPicId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($curPicId) . '" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktion für Bild Daten Array Rückgabe
  // ***************************************************************************
  
  
}

?>