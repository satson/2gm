<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsSeiten extends funktionsSammlung {
  
  public function getSeitenBaumNow($depp = 0, $parentID = 0, $nartID = 1) {
    $return = '';
    
    if ($depp < 5) {
      
      $curThisCmsHpId = $this->getTheCurCMSStartSiteId();
      
      $sqlTextSeitBaum = 'SELECT seitID, seitArt, seitNaviName, seitName, seitOnline, seitNoNavi, seitTextUrl FROM vseiten WHERE seitParent = ' . $this->dbDecode($parentID) . ' AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ' AND nartID = ' . $this->dbDecode($nartID) . ' ORDER BY seitPosition ASC';
      $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);
      
      $return .= '<div class="connectedSortable vFrontSeitenBaumHolder' . $depp . '" id="p' . $parentID . '">';

      while ($rowSeitBaum = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
        $curImgClass = 'vFrontIsSiteCur';
        if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 2) {
          $curImgClass = 'vFrontIsBlogCur';
        }
        else if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 3) {
          $curImgClass = 'vFrontIsNaviCur';
        }
        
        // Prüfen ob ein Verknüpfungselement auf der Seite ist
        // *********************************************************************
        if ($this->checkIsAliasElementOnSite($rowSeitBaum['seitID'])) {
          $curImgClass .= ' vFrontIsAliasElemOnSiteNow';
        }
        // *********************************************************************
        
        $curSiteIsOnlineHtml = '';
        $curSiteIsOnline = ' vFrontBaumOnline';
        //if (isset($rowSeitBaum['seitOnline']) && $rowSeitBaum['seitOnline'] == 2) {
        if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($rowSeitBaum['seitID']) == false) {
          //$curSiteIsOnline = ' vFrontBaumOffline';
          $curSiteIsOnlineHtml = '<div class="vFrontBaumOfflineHtmlElem vFrontBaumShowCurStateHtmlElem"><i class="fa fa-circle"></i></div>';
        }
        
        $curSiteIsOnNaviHtml = '';
        $curSiteIsOnNavi = ' vFrontBaumOnNavi';
        if (isset($rowSeitBaum['seitNoNavi']) && $rowSeitBaum['seitNoNavi'] == 2) {
          //$curSiteIsOnNavi = ' vFrontBaumNoNavi';
          if (isset($curSiteIsOnlineHtml) && !empty($curSiteIsOnlineHtml)) {
            $curSiteIsOnNaviHtml = '<div class="vFrontBaumNoNaviHtmlElem vFrontBaumNoNaviHtmlElemNotAlone vFrontBaumShowCurStateHtmlElem"><i class="fa fa-circle"></i></div>';
          }
          else {
            $curSiteIsOnNaviHtml = '<div class="vFrontBaumNoNaviHtmlElem vFrontBaumShowCurStateHtmlElem"><i class="fa fa-circle"></i></div>';
          }
        }
        
        $isSiteBaumElemeActivClass = '';
        if (isset($_POST['VCMS_CUR_CMS_SITE_ID']) && $_POST['VCMS_CUR_CMS_SITE_ID'] == $rowSeitBaum['seitID']) {
          $isSiteBaumElemeActivClass = 'vFrontBaumElemIsActiveMM ';
        }
        
        $return .= '<div class="soElems vFrontSeitBaumElem' . $depp . '" id="s' . $rowSeitBaum['seitID'] . '">';
        // MM 31.03.2014
        // Für Sprach Ausgabe (Name)
        // ***********************************************************
        $curSiteBaumName = $rowSeitBaum['seitName'];
        if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
          $curSiteBaumName = $this->getCurentLangSiteBaumName($rowSeitBaum['seitID'], $_POST['VCMS_POST_LANG'], $rowSeitBaum['seitName']);
        }
        // ***********************************************************
        $return .= '<div title="Id: ' . $rowSeitBaum['seitID'] . '" class="'.$isSiteBaumElemeActivClass.'vFrontBaumElem ' . $curImgClass . $curSiteIsOnline . $curSiteIsOnNavi . '">
                '.$curSiteIsOnlineHtml.$curSiteIsOnNaviHtml.'
                <div class="isDragToStartDivMM">' . $curSiteBaumName . '</div><div class="vFrontNaviSeitElemBaum">';
        if ($rowSeitBaum['seitID'] != $curThisCmsHpId) {
          if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
            if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
              $return .= '<div title="Löschen" id="del' . $rowSeitBaum['seitID'] . '" class="vFrontSeitBaumTrash"></div>';
            }
          }
        }
        if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
          if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
            $return .= '<div title="Bearbeiten" id="change' . $rowSeitBaum['seitID'] . '" class="vFrontSeitBaumChangeOnLang"></div>';
          }
          else {
            $return .= '<div title="Bearbeiten" id="change' . $rowSeitBaum['seitID'] . '" class="vFrontSeitBaumChange"></div>';
          }
        }
        
        if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) {
          if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
            $return .= '<div title="Seite Kopieren" id="copy' . $rowSeitBaum['seitID'] . '" class="vFrontSeitBaumSiteCopy"></div>';
          }
        }
        
        if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] != 3) {
          $langCurSh = '';
          if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
            $langCurSh = $_POST['VCMS_POST_LANG'].'/';
          }
          //$return .= '<div title="Seite anzeigen" id="vCMSshow-' . $rowSeitBaum['seitTextUrl'] . '" class="vFrontSeitBaumSeitShow"></div>';
          $return .= '<a href="' . $langCurSh . $rowSeitBaum['seitTextUrl'] . '"><div title="Seite anzeigen" class="vFrontSeitBaumSeitShow"></div></a>';
        }
        $return .= '<div class="clearer"></div></div></div>';
        $return .= $this->getSeitenBaumNow($depp + 1, $rowSeitBaum['seitID'], $nartID);
        $return .= '</div>';
      }

      $return .= '</div>';
      
      return $return;
    }
  }
  
  
  
  
  public function saveTheSortSeitenbaum($sortsData, $curParentID) {
    $sortsDataArr = explode(';', $sortsData);
    $hansSort = 0;
    
    foreach ($sortsDataArr as $sortID) {
      $hansSort = $hansSort + 1;
      
      $sqlSortText = 'UPDATE vseiten SET seitPosition = ' . $this->dbDecode($hansSort) . ', seitParent = ' . $this->dbDecode($curParentID) . ' WHERE seitID = ' . $this->dbDecode($sortID) . ' LIMIT 1';
      $sqlSortErg = $this->dbAbfragen($sqlSortText);
    }
  }
  
  
  
  
  public function delCurSiteNow($delSiteID) {
    $sqlCheckTxt = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($delSiteID);
    $sqlCheckErg = $this->dbAbfragen($sqlCheckTxt);
    $sqlNumSites = mysql_num_rows($sqlCheckErg);
    
    if ($sqlNumSites > 0) {
      return 'uFehler';
    }
    
    // Blog Kommentare Löschen
    $sqlDelKommentText = 'DELETE FROM vkommentare WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlDelKommentErg = $this->dbAbfragen($sqlDelKommentText);
    
    // Drag Elemente Sprach Inhalte Löschen
    $sqlGetText = 'SELECT selemID FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlGetErg = $this->dbAbfragen($sqlGetText);
    while ($rowGet = mysql_fetch_array($sqlGetErg, MYSQL_ASSOC)) {
      $sqlLangDelElText = 'DELETE FROM vselemlang WHERE selemID = ' . $this->dbDecode($rowGet['selemID']);
      $sqlLangDelElErg = $this->dbAbfragen($sqlLangDelElText);
    }
    
    // Drag Elemente Löschen
    $sqlDelElementText = 'DELETE FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlDelElementErg = $this->dbAbfragen($sqlDelElementText);
    
    // Seitenfelder Sprach Inhalte Löschen
    $sqlFieldLangText = 'SELECT sfeldID FROM vseitenfelder WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlFieldLangErg = $this->dbAbfragen($sqlFieldLangText);
    while ($rowFieldLangGet = mysql_fetch_array($sqlFieldLangErg, MYSQL_ASSOC)) {
      $sqlLangDelFieldText = 'DELETE FROM vseitenfelderlang WHERE sfeldID = ' . $this->dbDecode($rowFieldLangGet['sfeldID']);
      $sqlLangDelFieldErg = $this->dbAbfragen($sqlLangDelFieldText);
    }
    
    // Seitenfelder Löschen
    $sqlDelFieldsText = 'DELETE FROM vseitenfelder WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlDelFieldsErg = $this->dbAbfragen($sqlDelFieldsText);
    
    // Seiten Lang Löschen
    $sqlDelSiteLangText = 'DELETE FROM vseitelang WHERE seitID = ' . $this->dbDecode($delSiteID);
    $sqlDelSiteLangErg = $this->dbAbfragen($sqlDelSiteLangText);
    
    if (isset($sqlDelSiteLangErg) && $sqlDelSiteLangErg) {
      $sqlDelSiteText = 'DELETE FROM vseiten WHERE seitID = ' . $this->dbDecode($delSiteID) . ' LIMIT 1';
      $sqlDelSiteErg = $this->dbAbfragen($sqlDelSiteText);

      if ($sqlDelSiteErg) {
        return 'ok';
      }
      else {
        return 'fehler';
      }
    }
    else {
      return 'fehler';
    }
  }
  
  
  
  
  /**
  * Funktion gibt die Seiten Form Felder zurück
  *
  * @param int $curBearID - Seiten ID zum Bearbeiten
  * @return string
  */
  public function getNewSiteForms($curBearID = 0) {
    if (isset($curBearID) && $curBearID > 0) {
      $sqlBearSiteText = 'SELECT * FROM vseiten WHERE seitID = ' . $this->dbDecode($curBearID) . ' LIMIT 1';
      $sqlBearSiteErg = $this->dbAbfragen($sqlBearSiteText);
      
      if (mysql_num_rows($sqlBearSiteErg) < 1) {
        return 'Fehler';
      }
      
      while ($rowBearSite = mysql_fetch_array($sqlBearSiteErg, MYSQL_ASSOC)) {
        $bearSiteArr = $rowBearSite;
      }
    }
    $return = '';
    if (isset($bearSiteArr['seitID'])) {
      $return .= '<input type="hidden" name="siteCurBearID" id="siteCurBearID" value="' . $bearSiteArr['seitID'] . '" />';
    }
    
    $return .= '<div class="vFrontFrmHolder">';
    
    // MM Navigationsarten
    // ***************************************************************
    if ((isset($bearSiteArr['seitParent']) && $bearSiteArr['seitParent'] == 0) || !isset($bearSiteArr['seitParent'])) {
      $return .= '<label for="siteNavArt">Navigations Art:*</label>
          <div class="vFrontLblAbstand"></div>
          <select name="siteNavArt" id="siteNavArt" class="siteNavArtSelecter">';
      if (isset($bearSiteArr['nartID'])) {
        $return .= $this->getTheNavigationArts($bearSiteArr['nartID']);
      }
      else {
        $return .= $this->getTheNavigationArts();
      }
      $return .= '</select>'
              . '<div class="vFrontFrmAbstand"></div>';
    }
    else {
      $return .= '<input type="hidden" name="siteNavArt" id="siteNavArt" value="' . $bearSiteArr['nartID'] . '" />';
    }
    // MM Navigationsarten
    // ***************************************************************
    
    $return .= '<label for="siteArt">Seiten Art:*</label>
        <div class="vFrontLblAbstand"></div>
        <select name="siteArt" id="siteArt">';
    if (isset($bearSiteArr['seitArt'])) {
      $return .= $this->getTheSeitenArt($bearSiteArr['seitArt']);
    }
    else {
      $return .= $this->getTheSeitenArt();
    }
    $return .= '</select>
        
        <div class="vFrontFrmAbstandLine"></div>';
    if (isset($bearSiteArr['seitArt']) && $bearSiteArr['seitArt'] == 3) {
      $return .= '<div id="vFrontFieldsForNaviOnline">';
    }
    else {
      $return .= '<div id="vFrontFieldsForNaviOnline" style="display:none;">';
    }
    if (isset($bearSiteArr['seitOnline']) && $bearSiteArr['seitOnline'] == 2 && $bearSiteArr['seitArt'] == 3) {
      $return .= '<input type="checkbox" name="navCheckOffline" id="navCheckOffline" value="no" checked="checked" />';
    }
    else {
      $return .= '<input type="checkbox" name="navCheckOffline" id="navCheckOffline" value="no" />';
    }
    $return .= '<label class="vFrontLblCheckbox" for="navCheckOffline">Navigation Offline</label>
          
          <div class="vFrontFrmAbstandLine"></div>
        </div>

        <label for="siteName">Name:* (Navigation)</label>
        <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitName']) && !empty($bearSiteArr['seitName'])) {
      $return .= '<input maxlength="100" type="text" name="siteName" id="siteName" value="' . $bearSiteArr['seitName'] . '" />';
    }
    else {
      $return .= '<input maxlength="100" type="text" name="siteName" id="siteName" />';
    }
    
    if (isset($curBearID) && $curBearID > 0) {
      $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      $return .= '<input type="checkbox" name="siteBearCheckAutoTextUrl" id="siteBearCheckAutoTextUrl" value="ok" />';
      $return .= '<label class="vFrontLblCheckbox" for="siteBearCheckAutoTextUrl" style="width:auto; display:inline-block;">Automatische Text Url</label>';
      $return .= '<div class="vFrontFrmAbstand"></div>';
    }
    
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    if (isset($bearSiteArr['seitArt']) && $bearSiteArr['seitArt'] == 3) {
      $return .= '<div id="vFrontFieldsForSite" style="display:none;">';
    }
    else {
      $return .= '<div id="vFrontFieldsForSite">';
    }
    $return .= '<label for="siteTextUrl">Text Url:*</label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitTextUrl']) && !empty($bearSiteArr['seitTextUrl'])) {
      $return .= '<input maxlength="100" type="text" name="siteTextUrl" id="siteTextUrl" value="' . $bearSiteArr['seitTextUrl'] . '" />';
    }
    else {
      $return .= '<input maxlength="100" type="text" name="siteTextUrl" id="siteTextUrl" />';
    }

    $return .= '<div class="vFrontFrmAbstand"></div>

          <label for="siteLayout">Layout:*</label>
          <div class="vFrontLblAbstand"></div>
          <select name="siteLayout" id="siteLayout">';
    if (isset($bearSiteArr['layID'])) {
      $return .= $this->getTheSeitenLayout($bearSiteArr['layID']);
    }
    else {
      $return .= $this->getTheSeitenLayout();
    }
    $return .= '</select>

          <div class="vFrontFrmAbstandLine"></div>';
    
    if (isset($bearSiteArr['seitOnline']) && $bearSiteArr['seitOnline'] == 2 && $bearSiteArr['seitArt'] != 3) {
      $return .= '<input type="checkbox" name="siteCheckOffline" id="siteCheckOffline" value="no" checked="checked" />';
    }
    else {
      $return .= '<input type="checkbox" name="siteCheckOffline" id="siteCheckOffline" value="no" />';
    }
    $return .= '<label class="vFrontLblCheckbox" for="siteCheckOffline">Seite Offline</label>

          <div class="vFrontFrmAbstand"></div>';

    if (isset($bearSiteArr['seitNoNavi']) && $bearSiteArr['seitNoNavi'] == 2 && $bearSiteArr['seitArt'] != 3) {
      $return .= '<input type="checkbox" name="siteCheckNoNavi" id="siteCheckNoNavi" value="no" checked="checked" />';
    }
    else {
      $return .= '<input type="checkbox" name="siteCheckNoNavi" id="siteCheckNoNavi" value="no" />';
    }
    $return .= '<label class="vFrontLblCheckbox" for="siteCheckNoNavi">In der Navigation verbergen</label>

          <div class="vFrontFrmAbstandLine"></div>';
    
    // Für Seite Online ab und bis
    // *************************************************************************
    $return .= '<label for="siteOnlineAbDateMMN">Seite Online Ab:</label>';
    $return .= '<div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitOnlineAb']) && !empty($bearSiteArr['seitOnlineAb']) && $bearSiteArr['seitOnlineAb'] != '0000-00-00 00:00:00') {
      $curOnlineAbBearZw = explode(' ', $bearSiteArr['seitOnlineAb']);
      $curOnlineAbBearZwDate = explode('-', $curOnlineAbBearZw[0]);
      $curOnlineAbBearZwTime = explode(':', $curOnlineAbBearZw[1]);
      $curOnlineAbBearDate = $curOnlineAbBearZwDate[2].'.'.$curOnlineAbBearZwDate[1].'.'.$curOnlineAbBearZwDate[0];
      $curOnlineAbBearTime = $curOnlineAbBearZwTime[0].':'.$curOnlineAbBearZwTime[1];
      
      $return .= '<input type="text" name="siteOnlineAbDateMMN" id="siteOnlineAbDateMMN" value="' . $curOnlineAbBearDate . '" placeholder="Datum" />';
      $return .= '<input type="text" name="siteOnlineAbTimeMMN" id="siteOnlineAbTimeMMN" value="' . $curOnlineAbBearTime . '" placeholder="Uhrzeit" />';
    }
    else {
      $return .= '<input type="text" name="siteOnlineAbDateMMN" id="siteOnlineAbDateMMN" placeholder="Datum" />';
      $return .= '<input type="text" name="siteOnlineAbTimeMMN" id="siteOnlineAbTimeMMN" placeholder="Uhrzeit" />';
    }
    
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="siteOnlineBisDateMMN">Seite Online Bis:</label>';
    $return .= '<div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitOnlineBis']) && !empty($bearSiteArr['seitOnlineBis']) && $bearSiteArr['seitOnlineBis'] != '0000-00-00 00:00:00') {
      $curOnlineBisBearZw = explode(' ', $bearSiteArr['seitOnlineBis']);
      $curOnlineBisBearZwDate = explode('-', $curOnlineBisBearZw[0]);
      $curOnlineBisBearZwTime = explode(':', $curOnlineBisBearZw[1]);
      $curOnlineBisBearDate = $curOnlineBisBearZwDate[2].'.'.$curOnlineBisBearZwDate[1].'.'.$curOnlineBisBearZwDate[0];
      $curOnlineBisBearTime = $curOnlineBisBearZwTime[0].':'.$curOnlineBisBearZwTime[1];
      
      $return .= '<input type="text" name="siteOnlineBisDateMMN" id="siteOnlineBisDateMMN" value="' . $curOnlineBisBearDate . '" placeholder="Datum" />';
      $return .= '<input type="text" name="siteOnlineBisTimeMMN" id="siteOnlineBisTimeMMN" value="' . $curOnlineBisBearTime . '" placeholder="Uhrzeit" />';
    }
    else {
      $return .= '<input type="text" name="siteOnlineBisDateMMN" id="siteOnlineBisDateMMN" placeholder="Datum" />';
      $return .= '<input type="text" name="siteOnlineBisTimeMMN" id="siteOnlineBisTimeMMN" placeholder="Uhrzeit" />';
    }
    
    $return .= '<div class="vFrontFrmAbstandLine"></div>';
    // *************************************************************************
    
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 1) {
      $return .= '<div class="googleData" style="display:none;">';
    }
    else {
      $return .= '<div class="googleData">';
    }
          
    $return .= '<div id="vFrontGoogleSearchOrigShow"></div>

          <label for="siteMetaTitle">Meta Titel: (Google) <span class="siteMetaTitleCount">0 Zeichen</span><div class="clearer"></div></label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitMetaTitle']) && !empty($bearSiteArr['seitMetaTitle'])) {
      $return .= '<input type="text" name="siteMetaTitle" id="siteMetaTitle" value="' . $bearSiteArr['seitMetaTitle'] . '" />';
    }
    else {
      $return .= '<input type="text" name="siteMetaTitle" id="siteMetaTitle" />';
    }
    if (isset($curBearID) && $curBearID > 0) {
      $return .= '<span id="vFrontImportMetaTitleInTextboxSeo" data-id="' . $bearSiteArr['seitID'] . '"></span>';
    }

    $return .= '<div class="vFrontFrmAbstand"></div>

          <label for="siteMetaKeywords">Meta Keywords: (Google) <span class="siteMetaKeywordsCount">0 Zeichen</span><div class="clearer"></div></label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitMetaKeywords']) && !empty($bearSiteArr['seitMetaKeywords'])) {
      $return .= '<textarea name="siteMetaKeywords" id="siteMetaKeywords">' . $bearSiteArr['seitMetaKeywords'] . '</textarea>';
    }
    else {
      $return .= '<textarea name="siteMetaKeywords" id="siteMetaKeywords"></textarea>';
    }

    $return .= '<div class="vFrontFrmAbstand"></div>

          <label for="siteMetaDesc">Meta Beschreibung: (Google) <span class="siteMetaDescCount">0 Zeichen</span><div class="clearer"></div></label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitMetaDesc']) && !empty($bearSiteArr['seitMetaDesc'])) {
      $return .= '<textarea name="siteMetaDesc" id="siteMetaDesc">' . $bearSiteArr['seitMetaDesc'] . '</textarea>';
    }
    else {
      $return .= '<textarea name="siteMetaDesc" id="siteMetaDesc"></textarea>';
    }
    if (isset($curBearID) && $curBearID > 0) {
      $return .= '<span id="vFrontImportMetaDescInTextareaSeo" data-id="' . $bearSiteArr['seitID'] . '"></span>';
    }
    
    // Für No Index und Canonical Url
    // *****************************************************
    $return .= '<div class="vFrontFrmAbstandLine"></div>';
    
    $return .= '<label for="siteGoogleCanonical">Canonical Url: (Google)</label>';
    $return .= '<div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitCanonical']) && !empty($bearSiteArr['seitCanonical'])) {
      $return .= '<input type="text" name="siteGoogleCanonical" id="siteGoogleCanonical" value="' . $bearSiteArr['seitCanonical'] . '" />';
    }
    else {
      $return .= '<input type="text" name="siteGoogleCanonical" id="siteGoogleCanonical" />';
    }
    
    $return .= '<div class="vFrontFrmAbstand"></div>';
    $return .= '<div class="vFrontFrmAbstand"></div>';
    
    if (isset($bearSiteArr['seitNoIndex']) && $bearSiteArr['seitNoIndex'] == 2) {
      $return .= '<input type="checkbox" name="siteGoogleNoIndex" id="siteGoogleNoIndex" value="no" checked="checked" />';
    }
    else {
      $return .= '<input type="checkbox" name="siteGoogleNoIndex" id="siteGoogleNoIndex" value="no" />';
    }
    $return .= '<label class="vFrontLblCheckbox" for="siteGoogleNoIndex">No Index (Google)</label>';
    // *****************************************************
    
    $return .= '</div></div>';
    
    if (isset($bearSiteArr['seitArt']) && $bearSiteArr['seitArt'] == 3) {
      $return .= '<div id="vFrontFieldsForSiteOnlyNavi">';
    }
    else {
      $return .= '<div id="vFrontFieldsForSiteOnlyNavi" style="display:none">';
    }
    $return .= '<label for="siteNavLink">Link Url:</label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitNaviLink']) && !empty($bearSiteArr['seitNaviLink'])) {
      $return .= '<input maxlength="255" type="text" name="siteNavLink" id="siteNavLink" value="' . $bearSiteArr['seitNaviLink'] . '" />';
    }
    else {
      $return .= '<input maxlength="255" type="text" name="siteNavLink" id="siteNavLink" />';
    }

    $return .= '<div class="vFrontFrmAbstand"></div>
          
          <label for="siteNavCmsSiteLink">Link zu Seite:</label>
          <div class="vFrontLblAbstand"></div>';
    if (isset($bearSiteArr['seitNaviLinkSiteID']) && !empty($bearSiteArr['seitNaviLinkSiteID'])) {
      $return .= '<input style="width:210px;" maxlength="255" type="text" name="siteNavCmsSiteLink" id="siteNavCmsSiteLink" value="' . $bearSiteArr['seitNaviLinkSiteID'] . '" />';
    }
    else {
      $return .= '<input style="width:175px;" maxlength="255" type="text" name="siteNavCmsSiteLink" id="siteNavCmsSiteLink" />';
    }
    $return .= '<div class="vFrontSmallSiteNoSiteOnlyNaviShowAuswahlWindow" title="Seite auswählen"></div>';
          
    $return .= '<div class="vFrontFrmAbstand"></div>
          
          <label for="siteNavTarget">Seite anzeigen:*</label>
          <div class="vFrontLblAbstand"></div>
          <select name="siteNavTarget" id="siteNavTarget">';
    if (isset($bearSiteArr['seitNaviTarget'])) {
      $return .= $this->getTheLinkTarget($bearSiteArr['seitNaviTarget']);
    }
    else {
      $return .= $this->getTheLinkTarget();
    }
    $return .= '</select>';
    // Hintergrund Bilder
    // *************************************************************************
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder vFrontFrmListHolderNaviOhneSeite" data-field="vFrontFrmSiteNaviOhneSeiteBackImgs">';
    if (isset($bearSiteArr['seitBackImages']) && !empty($bearSiteArr['seitBackImages'])) {
      $return .= '  <input type="hidden" name="vFrontFrmSiteNaviOhneSeiteBackImgs" id="vFrontFrmSiteNaviOhneSeiteBackImgs" value="'.$bearSiteArr['seitBackImages'].'" />';
    }
    else {
      $return .= '  <input type="hidden" name="vFrontFrmSiteNaviOhneSeiteBackImgs" id="vFrontFrmSiteNaviOhneSeiteBackImgs" value="" />';
    }
    $return .= '  <div class="vFrontFrmListHolderHeader">
                    <div class="vFrontFrmListHolderHeaderUe">Hintergrundbilder</div>
                    <div class="vFrontFrmListHolderHeaderSort"></div>
                    <div class="vFrontFrmListHolderHeaderAdd"></div>
                    <div class="vFrontFrmListHolderHeaderDel"></div>
                  </div>';
    if (isset($bearSiteArr['seitBackImages']) && !empty($bearSiteArr['seitBackImages'])) {
      $return .= '  <div class="vFrontFrmListHolderLists">'.$this->getListPicElemHtml($bearSiteArr['seitBackImages']).'</div>';
    }
    else {
      $return .= '  <div class="vFrontFrmListHolderLists"></div>';
    }
    $return .= '</div>';
    // *************************************************************************
    $return .= '</div><div class="clearer"></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
    <div class="vFrontFrmAbstand"></div>
    <div class="vFrontFrmAbstand"></div>
    <div class="vFrontFrmAbstand"></div>';
        
    if (isset($bearSiteArr['seitID'])) {
      $return .= '<input type="submit" value="Speichern" id="siteSaveBearBtn" />';
    }
    else {
      $return .= '<input type="submit" value="Speichern" id="siteSaveBtn" />';
    }
    $return .= '</div>';
    
    $return .= '<div style="display:none;" id="vFrontIsOnlyZwMetaDescContentHtml"></div>';
    
    return $return;
  }
  
  
  
  public function saveNewSiteNow() {
    // Prüfen ob es die Text URL schon gibt
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] != 3) {
      $sqlCheckUriText = 'SELECT seitID FROM vseiten WHERE seitTextUrl = "' . $this->dbDecode($_POST['_siteTextUrl']) . '" AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']);
      $sqlCheckUriErg = $this->dbAbfragen($sqlCheckUriText);

      if (mysql_num_rows($sqlCheckUriErg) > 0) {
        return 'Uri_Error';
      }
    }
    
    $curDateNow = date('Y-m-d H:i:s');
    
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] == 3) {
      $sqlSaveSiteText = 'INSERT INTO vseiten 
        (seitArt, seitCreateDate, seitOnline, seitName, seitNaviLink, seitNaviLinkSiteID, seitNaviTarget, seitParent, seitPosition, hpID, nartID, seitNoNavi, seitBackImages) 
        VALUES 
        (' . $this->dbDecode($_POST['_siteArt']) . ', "' . $curDateNow . '", ' . $this->dbDecode($_POST['_siteOffline']) . ', "' . $this->dbDecode($_POST['_siteName']) . '", "' . $this->dbDecode($_POST['_siteNaviLinkUrl']) . '", "' . $this->dbDecode($_POST['_siteNaviCmsSiteID']) . '", "' . $this->dbDecode($_POST['_siteNaviTarget']) . '", 0, 0, ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ', ' . $this->dbDecode($_POST['_siteNaviArt']) . ', 1, "'.$this->dbDecode($_POST['_curBackImagesNavi']).'")';
    }
    else {
      
      $curDateOnlineAb = '';
      $curDateOnlineBis = '';
      
      if (isset($_POST['_siteOnlineAbDateMMN']) && !empty($_POST['_siteOnlineAbDateMMN'])) {
        $curDateArr = explode('.', $_POST['_siteOnlineAbDateMMN']);
        if (isset($curDateArr[2]) && isset($curDateArr[1]) && isset($curDateArr[0])) {
          $curDateOnlineAb = $curDateArr[2].'-'.$curDateArr[1].'-'.$curDateArr[0];
          
          if (isset($_POST['_siteOnlineAbTimeMMN']) && !empty($_POST['_siteOnlineAbTimeMMN'])) {
            $curTimeArr = explode(':', $_POST['_siteOnlineAbTimeMMN']);
            if (isset($curTimeArr[1]) && isset($curTimeArr[0])) {
              $curDateOnlineAb .= ' '.$curTimeArr[0].':'.$curTimeArr[1].':00';
            }
          }
        }
      }
      
      if (isset($_POST['_siteOnlineBisDateMMN']) && !empty($_POST['_siteOnlineBisDateMMN'])) {
        $curDateArrBis = explode('.', $_POST['_siteOnlineBisDateMMN']);
        if (isset($curDateArrBis[2]) && isset($curDateArrBis[1]) && isset($curDateArrBis[0])) {
          $curDateOnlineBis = $curDateArrBis[2].'-'.$curDateArrBis[1].'-'.$curDateArrBis[0];
          
          if (isset($_POST['_siteOnlineBisTimeMMN']) && !empty($_POST['_siteOnlineBisTimeMMN'])) {
            $curTimeArrBis = explode(':', $_POST['_siteOnlineBisTimeMMN']);
            if (isset($curTimeArrBis[1]) && isset($curTimeArrBis[0])) {
              $curDateOnlineBis .= ' '.$curTimeArrBis[0].':'.$curTimeArrBis[1].':00';
            }
          }
        }
      }
      
      $sqlSaveSiteText = 'INSERT INTO vseiten 
        (seitArt, seitCreateDate, seitOnline, seitName, seitTextUrl, seitMetaTitle, seitMetaKeywords, seitMetaDesc, seitNoNavi, seitParent, seitPosition, hpID, nartID, layID, seitCanonical, seitNoIndex, seitOnlineAb, seitOnlineBis) 
        VALUES 
        (' . $this->dbDecode($_POST['_siteArt']) . ', "' . $curDateNow . '", ' . $this->dbDecode($_POST['_siteOffline']) . ', "' . $this->dbDecode($_POST['_siteName']) . '", "' . $this->dbDecode($_POST['_siteTextUrl']) . '", "' . $this->dbDecode($_POST['_siteMetaTitle']) . '", "' . $this->dbDecode($_POST['_siteMetaKeywords']) . '", "' . $this->dbDecode($_POST['_siteMetaDesc']) . '", ' . $this->dbDecode($_POST['_siteNoNavi']) . ', 0, 0, ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ', ' . $this->dbDecode($_POST['_siteNaviArt']) . ', ' . $this->dbDecode($_POST['_siteLayout']) . ', "' . $this->dbDecode($_POST['_siteGoogleCanonical']) . '", "' . $this->dbDecode($_POST['_siteGoogleNoIndex']) . '", "'.$this->dbDecode($curDateOnlineAb).'", "'.$this->dbDecode($curDateOnlineBis).'")';
    }
    return $this->dbAbfragen($sqlSaveSiteText);
  }
  
  
  
  
  public function saveBearbeitSiteNow() {
    // Prüfen ob es die Text URL schon gibt
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] != 3) {
      $sqlCheckUriText = 'SELECT seitID FROM vseiten WHERE seitTextUrl = "' . $this->dbDecode($_POST['_siteTextUrl']) . '" AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ' AND seitID <> ' . $this->dbDecode($_POST['_bearSeitenID']);
      $sqlCheckUriErg = $this->dbAbfragen($sqlCheckUriText);

      if (mysql_num_rows($sqlCheckUriErg) > 0) {
        return 'Uri_Error';
      }
    }
    
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] == 3) {
      $sqlSaveBearSiteText = 'UPDATE vseiten SET 
        seitArt = ' . $this->dbDecode($_POST['_siteArt']) . ', 
        seitOnline = ' . $this->dbDecode($_POST['_siteOffline']) . ', 
        seitName = "' . $this->dbDecode($_POST['_siteName']) . '", 
        seitNaviLink = "' . $this->dbDecode($_POST['_siteNaviLinkUrl']) . '", 
        seitNaviLinkSiteID = "' . $this->dbDecode($_POST['_siteNaviCmsSiteID']) . '", 
        seitNaviTarget = "' . $this->dbDecode($_POST['_siteNaviTarget']) . '", 
        nartID = "' . $this->dbDecode($_POST['_siteNaviArt']) . '", 
        seitBackImages = "'.$this->dbDecode($_POST['_curBackImagesNavi']).'" 
      WHERE seitID = ' . $this->dbDecode($_POST['_bearSeitenID']);
    }
    else {
      
      $curDateOnlineAb = '';
      $curDateOnlineBis = '';
      
      if (isset($_POST['_siteOnlineAbDateMMN']) && !empty($_POST['_siteOnlineAbDateMMN'])) {
        $curDateArr = explode('.', $_POST['_siteOnlineAbDateMMN']);
        if (isset($curDateArr[2]) && isset($curDateArr[1]) && isset($curDateArr[0])) {
          $curDateOnlineAb = $curDateArr[2].'-'.$curDateArr[1].'-'.$curDateArr[0];
          
          if (isset($_POST['_siteOnlineAbTimeMMN']) && !empty($_POST['_siteOnlineAbTimeMMN'])) {
            $curTimeArr = explode(':', $_POST['_siteOnlineAbTimeMMN']);
            if (isset($curTimeArr[1]) && isset($curTimeArr[0])) {
              $curDateOnlineAb .= ' '.$curTimeArr[0].':'.$curTimeArr[1].':00';
            }
          }
        }
      }
      
      if (isset($_POST['_siteOnlineBisDateMMN']) && !empty($_POST['_siteOnlineBisDateMMN'])) {
        $curDateArrBis = explode('.', $_POST['_siteOnlineBisDateMMN']);
        if (isset($curDateArrBis[2]) && isset($curDateArrBis[1]) && isset($curDateArrBis[0])) {
          $curDateOnlineBis = $curDateArrBis[2].'-'.$curDateArrBis[1].'-'.$curDateArrBis[0];
          
          if (isset($_POST['_siteOnlineBisTimeMMN']) && !empty($_POST['_siteOnlineBisTimeMMN'])) {
            $curTimeArrBis = explode(':', $_POST['_siteOnlineBisTimeMMN']);
            if (isset($curTimeArrBis[1]) && isset($curTimeArrBis[0])) {
              $curDateOnlineBis .= ' '.$curTimeArrBis[0].':'.$curTimeArrBis[1].':00';
            }
          }
        }
      }
      
      $sqlSaveBearSiteText = 'UPDATE vseiten SET 
        seitArt = ' . $this->dbDecode($_POST['_siteArt']) . ', 
        seitOnline = ' . $this->dbDecode($_POST['_siteOffline']) . ', 
        seitName = "' . $this->dbDecode($_POST['_siteName']) . '", 
        seitTextUrl = "' . $this->dbDecode($_POST['_siteTextUrl']) . '", 
        seitMetaTitle = "' . $this->dbDecode($_POST['_siteMetaTitle']) . '", 
        seitMetaKeywords = "' . $this->dbDecode($_POST['_siteMetaKeywords']) . '", 
        seitMetaDesc = "' . $this->dbDecode($_POST['_siteMetaDesc']) . '", 
        seitNoNavi = ' . $this->dbDecode($_POST['_siteNoNavi']) . ', 
        layID = ' . $this->dbDecode($_POST['_siteLayout']) . ', 
        nartID = "' . $this->dbDecode($_POST['_siteNaviArt']) . '", 
        seitCanonical = "' . $this->dbDecode($_POST['_siteGoogleCanonical']) . '", 
        seitNoIndex = "' . $this->dbDecode($_POST['_siteGoogleNoIndex']) . '", 
        seitOnlineAb = "'.$this->dbDecode($curDateOnlineAb).'", 
        seitOnlineBis = "'.$this->dbDecode($curDateOnlineBis).'" 
      WHERE seitID = ' . $this->dbDecode($_POST['_bearSeitenID']);
    }
    $this->dbAbfragen($sqlSaveBearSiteText);
    
    // Unter Seiten bei änderung der Navigationsart auch ändern
    // *************************************************************************
    $this->setNaviArtByChangeUnderMenu($_POST['_bearSeitenID'], $_POST['_siteNaviArt']);
    // *************************************************************************
    
    return true;
  }
  
  
  
  private function setNaviArtByChangeUnderMenu($parentId, $siteNaviArt) {
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($parentId);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlTextUp = 'UPDATE vseiten SET nartID = ' . $this->dbDecode($siteNaviArt) . ' WHERE seitID = ' . $this->dbDecode($row['seitID']);
      $sqlErgUp = $this->dbAbfragen($sqlTextUp);
      
      $this->setNaviArtByChangeUnderMenu($row['seitID'], $siteNaviArt);
    }
  }











  // ***************************************************************************
  // ANFANG - Funktionen für Combo Boxen
  // ***************************************************************************
  
  /**
  * Funktion gibt die Seiten Art für das DropDown Menü zurück
  *
  * @param int $isCheck - Seitenart ID
  * @return string
  */
  protected function getTheSeitenArt($isCheck = '') {
    $artArr = array(
      '1' => 'Seite',
      '2' => 'Blog Beitrag',
      '3' => 'Navigation (ohne Seite)',
    );

    $return = '';
    
    foreach ($artArr as $key => $art) {
      if ($key == $isCheck) {
        $return .= '<option selected="selected" value="' . $key . '">' . $art . '</option>';
      }
      else {
        $return .= '<option value="' . $key . '">' . $art . '</option>';
      }
    }
    
    return $return;
  }
  
  
  
  /**
  * Funktion gibt die Seiten Layouts für das DropDown Menü zurück
  *
  * @param int $isCheck - Seitenlayout ID
  * @return string
  */
  protected function getTheSeitenLayout($isCheck = '') {
    $return = '';
    
    $sqlLayoutText = 'SELECT * FROM vseitenlayout WHERE hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']);
    $sqlLayoutErg = $this->dbAbfragen($sqlLayoutText);
    
    while($rowLay = mysql_fetch_array($sqlLayoutErg, MYSQL_ASSOC)) {
      if ($rowLay['layID'] == $isCheck) {
        $return .= '<option selected="selected" value="' . $rowLay['layID'] . '">' . $rowLay['layName'] . '</option>';
      }
      else {
        $return .= '<option value="' . $rowLay['layID'] . '">' . $rowLay['layName'] . '</option>';
      }
    }
    
    return $return;
  }
  
  
  
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
  
  
  
  /**
  * Funktion gibt die Navigationsarten für das DropDown Menü zurück
  *
  * @param int $isCheck - Navigationsart ID
  * @return string
  */
  protected function getTheNavigationArts($isCheck = '') {
    $return = '';
    
    $sqlNavText = 'SELECT * FROM vnaviart';
    $sqlNavErg = $this->dbAbfragen($sqlNavText);
    
    while($rowNav = mysql_fetch_array($sqlNavErg, MYSQL_ASSOC)) {
      if ($rowNav['nartID'] == $isCheck) {
        $return .= '<option selected="selected" value="' . $rowNav['nartID'] . '">' . $rowNav['nartName'] . '</option>';
      }
      else {
        $return .= '<option value="' . $rowNav['nartID'] . '">' . $rowNav['nartName'] . '</option>';
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Combo Boxen
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiten Sprachen Ausgaben und Speicherungen
  // ***************************************************************************
  
  // Funktionen für Sprachen ID und Prüfen
  // *******************************************************************
  private function getCurentLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  private function checkSiteHasDataLang($siteID, $langId) {
    $sqlCheckText = 'SELECT seitlaID FROM vseitelang WHERE langID = ' . $this->dbDecode($langId) . ' AND seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckNum = mysql_num_rows($sqlCheckErg);
    if (isset($sqlCheckNum) && $sqlCheckNum > 0) {
      return true;
    }
    return false;
  }
  // *******************************************************************
  
  
  
  
  
  
  // Funktion für Sprachen Name Ausgabe im Seitenbaum
  // *******************************************************************
  private function getCurentLangSiteBaumName($seitID, $langUrlName, $origSiteName) {
    $curLangId = $this->getCurentLangIdFromUrlName($langUrlName);
    $sqlNameText = 'SELECT seitlaName FROM vseitelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND seitID = ' . $this->dbDecode($seitID) . ' LIMIT 1';
    $sqlNameErg = $this->dbAbfragen($sqlNameText);
    $curLangName = '';
    while ($rowName = mysql_fetch_array($sqlNameErg, MYSQL_ASSOC)) {
      $curLangName = $rowName['seitlaName'];
    }
    if (isset($curLangName) && !empty($curLangName)) {
      return $curLangName;
    }
    return $origSiteName;
  }
  // *******************************************************************







  // Funktionen für Sprache Lang Bearbeiten Forms Ausgabe
  // *******************************************************************
  public function getBearSiteFormsOnLang($langUrlName, $curBearID) {
    $return = '';
    
    $sqlBearSiteText = 'SELECT * FROM vseiten WHERE seitID = ' . $this->dbDecode($curBearID) . ' LIMIT 1';
    $sqlBearSiteErg = $this->dbAbfragen($sqlBearSiteText);

    if (mysql_num_rows($sqlBearSiteErg) < 1) {
      return 'Fehler';
    }

    while ($rowBearSite = mysql_fetch_array($sqlBearSiteErg, MYSQL_ASSOC)) {
      $bearSiteArr = $rowBearSite;
    }
    
    $curLangId = $this->getCurentLangIdFromUrlName($langUrlName);
    
    $sqlBearSiteTextOL = 'SELECT * FROM vseitelang WHERE seitID = ' . $this->dbDecode($curBearID) . ' AND langID = ' . $this->dbDecode($curLangId) . ' LIMIT 1';
    $sqlBearSiteErgOL = $this->dbAbfragen($sqlBearSiteTextOL);
    
    $hansII = 0;
    
    while ($rowBearSiteOL = mysql_fetch_array($sqlBearSiteErgOL, MYSQL_ASSOC)) {
      $hansII++;
      $bearSiteArrCurOL = $rowBearSiteOL;
    }
    
    if (isset($hansII) && $hansII == 0) {
      $bearSiteArrCurOL = $this->buildCurentLangSiteInhaltEmptyArray();
    }
    
    $return .= '<input type="hidden" name="siteCurBearID" id="siteCurBearID" value="' . $bearSiteArr['seitID'] . '" />';
    $return .= '<input type="hidden" name="siteCurArtNum" id="siteCurArtNum" value="' . $bearSiteArr['seitArt'] . '" />';
    
    $return .= '<div class="vFrontFrmHolder">';
    
    $return .= '<label for="siteName">Name:* (Navigation)</label>
        <div class="vFrontLblAbstand"></div>';
    $return .= '<input maxlength="100" type="text" name="siteName" id="siteName" value="' . $bearSiteArrCurOL['seitlaName'] . '" />';
    
    if (isset($bearSiteArr['seitArt']) && $bearSiteArr['seitArt'] != 3) {
      
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 1) {
        $return .= '<div class="googleData" style="display:none;">';
      }
      else {
        $return .= '<div class="googleData">';
      }
      
      $return .= '<div class="vFrontFrmAbstandLine"></div>';
      
      $return .= '<div id="vFrontGoogleSearchOrigShow"></div>';
      
      $return .= '<label for="siteMetaTitle">Meta Titel: (Google) <span class="siteMetaTitleCount">0 Zeichen</span><div class="clearer"></div></label>
            <div class="vFrontLblAbstand"></div>';
      $return .= '<input maxlength="100" type="text" name="siteMetaTitle" id="siteMetaTitle" value="' . $bearSiteArrCurOL['seitlaMetaTitle'] . '" />';
      $return .= '<span id="vFrontImportMetaTitleInTextboxSeoLang" data-lang="'.$langUrlName.'" data-id="' . $curBearID . '"></span>';

      $return .= '<div class="vFrontFrmAbstand"></div>';


      $return .= '<label for="siteMetaKeywords">Meta Keywords: (Google) <span class="siteMetaKeywordsCount">0 Zeichen</span><div class="clearer"></div></label>
            <div class="vFrontLblAbstand"></div>';
      $return .= '<textarea maxlength="255" name="siteMetaKeywords" id="siteMetaKeywords">' . $bearSiteArrCurOL['seitlaMetaKeywords'] . '</textarea>';

      $return .= '<div class="vFrontFrmAbstand"></div>';

      $return .= '<label for="siteMetaDesc">Meta Beschreibung: (Google) <span class="siteMetaDescCount">0 Zeichen</span><div class="clearer"></div></label>
            <div class="vFrontLblAbstand"></div>';
      $return .= '<textarea name="siteMetaDesc" id="siteMetaDesc">' . $bearSiteArrCurOL['seitlaMetaDesc'] . '</textarea>';
      $return .= '<span id="vFrontImportMetaDescInTextareaSeoLang" data-lang="'.$langUrlName.'" data-id="' . $curBearID . '"></span>';
      
      
      
      // Für No Index und Canonical Url
      // *****************************************************
      $return .= '<div class="vFrontFrmAbstandLine"></div>';

      $return .= '<label for="siteGoogleCanonical">Canonical Url: (Google)</label>';
      $return .= '<div class="vFrontLblAbstand"></div>';
      if (isset($bearSiteArrCurOL['seitlaCanonical']) && !empty($bearSiteArrCurOL['seitlaCanonical'])) {
        $return .= '<input type="text" name="siteGoogleCanonical" id="siteGoogleCanonical" value="' . $bearSiteArrCurOL['seitlaCanonical'] . '" />';
      }
      else {
        $return .= '<input type="text" name="siteGoogleCanonical" id="siteGoogleCanonical" />';
      }

      $return .= '<div class="vFrontFrmAbstand"></div>';
      $return .= '<div class="vFrontFrmAbstand"></div>';

      if (isset($bearSiteArrCurOL['seitlaNoIndex']) && $bearSiteArrCurOL['seitlaNoIndex'] == 2) {
        $return .= '<input type="checkbox" name="siteGoogleNoIndex" id="siteGoogleNoIndex" value="no" checked="checked" />';
      }
      else {
        $return .= '<input type="checkbox" name="siteGoogleNoIndex" id="siteGoogleNoIndex" value="no" />';
      }
      $return .= '<label class="vFrontLblCheckbox" for="siteGoogleNoIndex">No Index (Google)</label>';
      // *****************************************************
      
      
      
      $return .= '</div>';
    }
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>
    <div class="vFrontFrmAbstand"></div>
    <div class="vFrontFrmAbstand"></div>';
        
    $return .= '<input type="submit" value="Speichern" id="siteSaveBearBtnOnLang" />';
    
    $return .= '</div>';
    
    $return .= '<div style="display:none;" id="vFrontIsOnlyZwMetaDescContentHtml"></div>';
    
    return $return;
  }
  
  
  private function buildCurentLangSiteInhaltEmptyArray() {
    $return = array();
    
    $return['seitlaName'] = '';
    $return['seitlaTextUrl'] = '';
    $return['seitlaMetaTitle'] = '';
    $return['seitlaMetaKeywords'] = '';
    $return['seitlaMetaDesc'] = '';
    $return['seitlaCanonical'] = '';
    $return['seitlaNoIndex'] = '';
    
    return $return;
  }
  // *******************************************************************
  
  
  
  
  // Funktionen für Sprache Lang Speichern
  // *******************************************************************
  public function saveBearbeitSiteNowOnLang() {
    $langId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
    $siteID = $_POST['_curSiteBearID'];
    if ($this->checkSiteHasDataLang($siteID, $langId)) {
      return $this->saveBearbeitSiteNowOnLangUpdate($siteID, $langId);
    }
    else {
      return $this->saveBearbeitSiteNowOnLangNew($siteID, $langId);
    }
  }
  
  
  private function saveBearbeitSiteNowOnLangUpdate($siteID, $langId) {
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] == 3) {
      $sqlSaveBearSiteText = 'UPDATE vseitelang SET 
        seitlaName = "' . $this->dbDecode($_POST['_siteName']) . '" 
      WHERE seitID = ' . $this->dbDecode($siteID) . ' AND langID = ' . $this->dbDecode($langId);
    }
    else {
      $sqlSaveBearSiteText = 'UPDATE vseitelang SET  
        seitlaName = "' . $this->dbDecode($_POST['_siteName']) . '", 
        seitlaMetaTitle = "' . $this->dbDecode($_POST['_siteMetaTitle']) . '", 
        seitlaMetaKeywords = "' . $this->dbDecode($_POST['_siteMetaKeywords']) . '", 
        seitlaMetaDesc = "' . $this->dbDecode($_POST['_siteMetaDesc']) . '", 
        seitlaCanonical = "'.$this->dbDecode($_POST['_siteGoogleCanonical']).'", 
        seitlaNoIndex = "'.$this->dbDecode($_POST['_siteGoogleNoIndex']).'" 
      WHERE seitID = ' . $this->dbDecode($siteID) . ' AND langID = ' . $this->dbDecode($langId);
    }
    return $this->dbAbfragen($sqlSaveBearSiteText);
  }
  
  
  private function saveBearbeitSiteNowOnLangNew($siteID, $langId) {
    if (isset($_POST['_siteArt']) && $_POST['_siteArt'] == 3) {
      $sqlSaveBearSiteText = 'INSERT INTO vseitelang 
        (seitlaName, seitID, langID) 
        VALUES 
        ("' . $this->dbDecode($_POST['_siteName']) . '", ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($langId) . ')';
    }
    else {
      $sqlSaveBearSiteText = 'INSERT INTO vseitelang 
        (seitlaName, seitlaMetaTitle, seitlaMetaKeywords, seitlaMetaDesc, seitID, langID, seitlaCanonical, seitlaNoIndex) 
        VALUES 
        ("' . $this->dbDecode($_POST['_siteName']) . '", "' . $this->dbDecode($_POST['_siteMetaTitle']) . '", "' . $this->dbDecode($_POST['_siteMetaKeywords']) . '", "' . $this->dbDecode($_POST['_siteMetaDesc']) . '", ' . $this->dbDecode($siteID) . ', ' . $this->dbDecode($langId) . ', "'.$this->dbDecode($_POST['_siteGoogleCanonical']).'", "'.$this->dbDecode($_POST['_siteGoogleNoIndex']).'")';
    }
    return $this->dbAbfragen($sqlSaveBearSiteText);
  }
  // *******************************************************************
  
  // ***************************************************************************
  // ENDE - Funktionen für Seiten Sprachen Ausgaben und Speicherungen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Prüfen ob auf einer Seite ein Verknüpfungselement ist
  // ***************************************************************************
  
  private function checkIsAliasElementOnSite($siteID) {
    $sqlElemText = 'SELECT elemID FROM velement WHERE elemEigen = 1 AND elemArt = 5 LIMIT 1';
    $sqlElemErg = $this->dbAbfragen($sqlElemText);
    
    while ($rowElem = mysql_fetch_array($sqlElemErg, MYSQL_ASSOC)) {
      $sqlText = 'SELECT selemID FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteID).' AND elemID = '.$this->dbDecode($rowElem['elemID']).' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        return true;
      }
    }
    
    return false;
  }
  
  // ***************************************************************************
  // ENDE - Prüfen ob auf einer Seite ein Verknüpfungselement ist
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  private function getListPicElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $imgId) {
        $sqlTextList = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($imgId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['bildID'] . '">
              <div class="vFrontFrmListsElemBild">
                <img src="user_upload/' . $rowList['bildFile'] . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['bildName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
}

?>