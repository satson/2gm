<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsFunctions extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen für Navigation
  // ***************************************************************************
  
  public function getCmsMenu($menuID = 1, $beginn = 1, $max = 'all', $menuClass = 'v_siteMenu') {
    $isBootstrapWebActive = $this->checkIsThisModuleActive('responsivWebModul');
    
    if($_SERVER['HTTPS'] == 'on' && empty($_SESSION['VCMS_USER_ID'])){
      $urlH = 'https://wildkogel-arena.at/';   
    }else{ 
      $urlH = 'http://wildkogel-arena.at/';     
    }
    
    $return = '';
    $zaehlerNav = 0;
    $menuLangVar = '';
    if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
      $menuLangVar = $_GET['_lang'].'/';
    }else{
        if(empty($_SESSION['VCMS_USER_ID'])){
            $menuLangVar = 'de/'; 
        }
        
    }
    
    if (isset($max) && is_int($max)) {
      $sqlNavText = 'SELECT * FROM vseiten WHERE nartID = ' . $this->dbDecode($menuID) . ' AND seitParent = 0 AND seitOnline = 1 AND seitNoNavi = 1 ORDER BY seitPosition ASC LIMIT ' . $this->dbDecode($max);
    }
    else {
      $sqlNavText = 'SELECT * FROM vseiten WHERE nartID = ' . $this->dbDecode($menuID) . ' AND seitParent = 0 AND seitOnline = 1 AND seitNoNavi = 1 ORDER BY seitPosition ASC';
    }
    $sqlNavErg = $this->dbAbfragen($sqlNavText);
    $sqlNumRowsNow = mysql_num_rows($sqlNavErg);
    
    if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
      $return .= '<ul class="' . $menuClass . ' nav navbar-nav">';
    }
    else {
      $return .= '<div class="' . $menuClass . '">';
    }
     $idlang =  $curLangId = $this->getCurentLangIdFromUrlName($_GET['_lang']); 
    while($rowNav = mysql_fetch_array($sqlNavErg, MYSQL_ASSOC)) {
       
      
       if($this->checkIfActiveSiteLang($rowNav['seitID'],$idlang)){
        
      $zaehlerNav++;
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($rowNav['seitID']) == true) {
      
        //$zaehlerNav++;
        $curTarget = '';

        if (isset($rowNav['seitNaviTarget']) && !empty($rowNav['seitNaviTarget'])) {
          $curTarget = ' target="' . $rowNav['seitNaviTarget'] . '"';
        }

        //if ($menuID == 1) {
          $curNavName = $this->replaceNameNavMegaIcon($rowNav['seitName']);
        //}
        //else {
          //$curNavName = $rowNav['seitName'];
        //}

        // MM 31.03.2014
        // Für Sprach Ausgabe (Navigations Name)
        // ***********************************************************
        if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
          $curNavName = $this->getCurentLangNavigationName($rowNav['seitID'], $_POST['VCMS_POST_LANG'], $rowNav['seitName']);
          $curNavUrl = $this->getCurentLangNavigationUrl($rowNav['seitID'], $_POST['VCMS_POST_LANG'], $rowNav['seitName']);
          
        }
        // ***********************************************************

        if ($zaehlerNav >= $beginn) {
          $lastElemNavSt = '';
          if ($sqlNumRowsNow == $zaehlerNav) {
            $lastElemNavSt = 'menuPointLastElem';
          }

          if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
            $return .= '<li class="menuPoint' . $this->checkIsActiveMenu($rowNav['seitID'], $rowNav['seitTextUrl']) . ' vCurMenuPoint' . $zaehlerNav . ' ' . $lastElemNavSt . '">';
          }
          else {
            $return .= '<div class="menuPoint' . $this->checkIsActiveMenu($rowNav['seitID'], $rowNav['seitTextUrl']) . ' vCurMenuPoint' . $zaehlerNav . ' ' . $lastElemNavSt . '">';
          }

          if (isset($rowNav['seitArt']) && $rowNav['seitArt'] == 3) {
            $curLinkUri = '#';
            if (isset($rowNav['seitNaviLinkSiteID']) && !empty($rowNav['seitNaviLinkSiteID'])) {
              $curLinkUri = $menuLangVar.$this->getCurSiteTextUrl($rowNav['seitNaviLinkSiteID']);
            }
            else if (isset($rowNav['seitNaviLink']) && !empty($rowNav['seitNaviLink'])) {
              $curLinkUri = $rowNav['seitNaviLink'];
            }
            $return .= '<a href="'.SITE_URL.$curLinkUri . '"' . $curTarget . '>' . $curNavName . '</a>';
          }
          else {
              
            $url =  ($curNavUrl!='')?$curNavUrl:$rowNav['seitTextUrl'];
            $return .= '<a href="' .$menuLangVar . $url . '"' . $curTarget . '>' . $curNavName . '</a>';
          }

          $return .= $this->getCmsUnterMenu($rowNav['seitID']);

          if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
            $return .= '</li>';
          }
          else {
            $return .= '</div>';
          }
        }
      
      }
      
    }
      
    }
    
    if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
      $return .= '<div class="clearer"></div></ul>';
    }
    else {
      $return .= '<div class="clearer"></div></div>';
    }
    
    return $return;
  }
  
  
  
  
  public function getCmsMenuParentID($menuID) {
    $isBootstrapWebActive = $this->checkIsThisModuleActive('responsivWebModul');
    $return = '';
    
    if (!isset($isBootstrapWebActive) || $isBootstrapWebActive == false) {
      $return .= '<div class="v_siteMenu">';
    }
    
    $return .= $this->getCmsUnterMenu($menuID);
    
    if (!isset($isBootstrapWebActive) || $isBootstrapWebActive == false) {
      $return .= '</div>';
    }
    
    return $return;
  }

  
  

  private function getCmsUnterMenu($menuParentID, $menuClass = 'v_siteUnterMenu', $curDeep = 1) {
    $isBootstrapWebActive = $this->checkIsThisModuleActive('responsivWebModul');
    $return = '';
    $menuLangVar = '';
    
   
    
    if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
      $menuLangVar = $urlH.$_GET['_lang'].'/';
    }else{
        if(empty($_SESSION['VCMS_USER_ID'])){
            $menuLangVar = $urlH.'de/'; 
        }
    }
    
    $sqlNavUText = 'SELECT * FROM vseiten WHERE seitParent = ' . $this->dbDecode($menuParentID) . ' AND seitOnline = 1 AND seitNoNavi = 1 ORDER BY seitPosition ASC';
    $sqlNavUErg = $this->dbAbfragen($sqlNavUText);
    $sqlNavUErgCount = mysql_num_rows($sqlNavUErg);
    
    if ($sqlNavUErgCount > 0) {
      if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
        if (isset($curDeep) && $curDeep > 1) {
          $return .= '<ul class="' . $menuClass . $curDeep . '">';
        }
        else {
          $return .= '<ul class="' . $menuClass . '">';
        }
      }
      else {
        if (isset($curDeep) && $curDeep > 1) {
          $return .= '<div class="' . $menuClass . $curDeep . '">';
        }
        else {
          $return .= '<div class="' . $menuClass . '">';
        }
      }
    }
     $idlang =  $curLangId = $this->getCurentLangIdFromUrlName($_GET['_lang']); 
    while($rowNavU = mysql_fetch_array($sqlNavUErg, MYSQL_ASSOC)) {
        
     if($this->checkIfActiveSiteLang($rowNavU['seitID'],$idlang)){ 
        
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($rowNavU['seitID']) == true) {
      
        $curNavName = $rowNavU['seitName'];
        $curTarget = '';

        if (isset($rowNavU['seitNaviTarget']) && !empty($rowNavU['seitNaviTarget'])) {
          $curTarget = ' target="' . $rowNavU['seitNaviTarget'] . '"';
        }

        // MM 31.03.2014
        // Für Sprach Ausgabe (Navigations Name)
        // ***********************************************************
        if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
          $curNavName = $this->getCurentLangNavigationName($rowNavU['seitID'], $_POST['VCMS_POST_LANG'], $rowNavU['seitName']);
          $curNavUrl = $this->getCurentLangNavigationUrl($rowNavU['seitID'], $_POST['VCMS_POST_LANG'], $rowNavU['seitName']);

        }
        // ***********************************************************

        if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
          $return .= '<li class="menuPoint' . $this->checkIsActiveMenu($rowNavU['seitID'], $rowNavU['seitTextUrl']) . '">';
        }
        else {
          $return .= '<div class="menuPoint' . $this->checkIsActiveMenu($rowNavU['seitID'], $rowNavU['seitTextUrl']) . '">';
        }

        if (isset($rowNavU['seitArt']) && $rowNavU['seitArt'] == 3) {
          $curLinkUri = '#';
          if (isset($rowNavU['seitNaviLinkSiteID']) && !empty($rowNavU['seitNaviLinkSiteID'])) {
              
               if($_SERVER['HTTPS'] == 'on' && empty($_SESSION['VCMS_USER_ID'])){
                $urlH = 'https://wildkogel-arena.at/';   
              }else{ 
                $urlH = 'http://wildkogel-arena.at/';     
              }
              
              
            $curLinkUri = $urlH.$menuLangVar.$this->getCurSiteTextUrl($rowNavU['seitNaviLinkSiteID']);
          }
          else if (isset($rowNavU['seitNaviLink']) && !empty($rowNavU['seitNaviLink'])) {
            $curLinkUri = $rowNavU['seitNaviLink'];
            
          
           
            
          }
          $return .= '<a href="'.$curLinkUri . '"' . $curTarget . '>' . $curNavName . '</a>';
        }
        else {
          $url = ($curNavUrl!='')?$curNavUrl:$rowNavU['seitTextUrl']; 
          $return .= '<a href="'.SITE_URL.$menuLangVar . $url . '"' . $curTarget . '>' . $curNavName . '</a>';
        }

        $return .= $this->getCmsUnterMenu($rowNavU['seitID'], $menuClass, $curDeep + 1);

        if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
          $return .= '</li>';
        }
        else {
          $return .= '</div>';
        }
      
      }
      
    }
      
    }
    
    if ($sqlNavUErgCount > 0) {
      if (isset($isBootstrapWebActive) && $isBootstrapWebActive == true) {
        $return .= '<div class="clearer"></div></ul>';
      }
      else {
        $return .= '<div class="clearer"></div></div>';
      }
    }
    
    return $return;
  }
  
  
  
  
  private function checkIsActiveMenu($menuID, $menuUrl = '') {
    global $cms;
    
    if ($menuID == $cms['cms_siteID']) {
      return ' active';
    }
    else {
      $sqlText = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($menuID);
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if ($row['seitID'] == $cms['cms_siteID']) {
          return ' active';
        }
        else {
          $sqlText2 = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($row['seitID']);
          $sqlErg2 = $this->dbAbfragen($sqlText2);

          while ($row2 = mysql_fetch_array($sqlErg2, MYSQL_ASSOC)) {
            if ($row2['seitID'] == $cms['cms_siteID']) {
              return ' active';
            }
            else {
              $sqlText3 = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($row2['seitID']);
              $sqlErg3 = $this->dbAbfragen($sqlText3);

              while ($row3 = mysql_fetch_array($sqlErg3, MYSQL_ASSOC)) {
                if ($row3['seitID'] == $cms['cms_siteID']) {
                  return ' active';
                }
                else {
                  $sqlText4 = 'SELECT seitID FROM vseiten WHERE seitParent = ' . $this->dbDecode($row3['seitID']);
                  $sqlErg4 = $this->dbAbfragen($sqlText4);

                  while ($row4 = mysql_fetch_array($sqlErg4, MYSQL_ASSOC)) {
                    if ($row4['seitID'] == $cms['cms_siteID']) {
                      return ' active';
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    
    return '';
  }
  
  
  
  
  private function getCurSiteTextUrl($siteID) {
    $return = '';
    
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowS = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= $rowS['seitTextUrl'];
     
      
    }
    
    return $return;
  }
  
  
  
  private function replaceNameNavMegaIcon($name) {    
    return str_replace('mega', '<span class="menuNormalColor">mega</span>', $name);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Navigation
  // ***************************************************************************
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Elemente
  // ***************************************************************************
  
  public function setElementHolder($elHolderName, $elHolderInherit = 'noinherit', $canUserChange = 'change') {
    global $cms; 
    $elemSelfObj = new cmsElementeSelf();
    return $elemSelfObj->setElemHolderInhaltLoad($elHolderName, $cms['cms_siteID'], $elHolderInherit);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Elemente
  // ***************************************************************************
  
   
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiten
  // ***************************************************************************
  
  public function getCmsSiteDataArray() {
    global $hpCms;
    
    $return = array();
    $idlang =  $curLangId = $this->getCurentLangIdFromUrlName($_GET['_lang']); 
    if (isset($_GET['page_name']) && !empty($_GET['page_name'])) {
 
       $query = mysql_query('SELECT seitID FROM vseitelang WHERE seitlaTextUrl = "' . $this->dbDecode($_GET['page_name']) . '" AND langID="'.$idlang.'"  LIMIT 1');
       if(mysql_num_rows($query) > 0){
          $row = mysql_fetch_array($query);
          $idSite = $row['seitID'];
          $sqlDataText = 'SELECT * FROM vseiten WHERE seitID = ' .$idSite . ' LIMIT 1';
   
       }else{
        $sqlDataText = 'SELECT * FROM vseiten WHERE seitTextUrl = "' . $this->dbDecode($_GET['page_name']) . '" LIMIT 1';
       }
      
        
       }else {
       $sqlDataText = 'SELECT * FROM vseiten WHERE seitID = ' . $this->dbDecode($hpCms['hp_SeitStart']) . ' LIMIT 1';
    }
    $sqlDataErg = $this->dbAbfragen($sqlDataText);
    $hans = 0;
    $curSiteIdWeiter = '';
     $idlang =  $curLangId = $this->getCurentLangIdFromUrlName($_GET['_lang']);
    while ($rowData = mysql_fetch_array($sqlDataErg, MYSQL_ASSOC)) {
        
      if($this->checkIfActiveSiteLang($rowData['seitID'],$idlang)){
          
          
       
      // Für Seite Online oder Offline
      // ***********************************************************************
      if (!checkIsUserLogedIn() && !isset($_GET['isCmsSeoImportTitle']) && !isset($_GET['isCmsSeoImportDesc'])) {
        if (isset($rowData['seitID']) && !empty($rowData['seitID'])) {
          if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($rowData['seitID']) == false) {
            if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
              header('Location: /' . $_GET['_lang'] . '');
              exit();
            }
            header('Location: /');
            exit();
          }
        }
      }
      // ***********************************************************************
      
      $_SESSION['VCMS_CUR_CMS_SITE_SESSION'] = $rowData['seitID'];
      
      $return['cms_siteID'] = $rowData['seitID'];
      $return['cms_siteArt'] = $rowData['seitArt'];
      $return['cms_siteCreateDate'] = $rowData['seitCreateDate'];
      $return['cms_siteOnline'] = $rowData['seitOnline'];
      $return['cms_siteName'] = $rowData['seitName'];
      $return['cms_siteTextUrl'] = $rowData['seitTextUrl'];
      $return['cms_siteParent'] = $rowData['seitParent'];
      $return['cms_sitePosition'] = $rowData['seitPosition'];
      $return['cms_siteNartID'] = $rowData['nartID'];
      $return['cms_siteLayID'] = $rowData['layID'];
      $return['cms_siteMetaTitle'] = $rowData['seitMetaTitle'];
      $return['cms_siteMetaKeywords'] = $rowData['seitMetaKeywords'];
      $return['cms_siteMetaDesc'] = $rowData['seitMetaDesc'];
      $return['cms_siteBackImages'] = $rowData['seitBackImages'];
      $return['cms_siteListImage'] = $rowData['seitListImage'];
      $return['cms_siteSlideImages'] = $rowData['seitSlideImages'];
      $return['cms_siteCanonical'] = $rowData['seitCanonical'];
      $return['cms_siteNoIndex'] = $rowData['seitNoIndex'];
      
      // Shop Modul Produkte Ausgaben
      // *******************************************************
      if ($this->checkIsShopModulActiv()) {
        $return['cms_shopProducts'] = array();
        $return['cms_shopProducts'] = $this->buildShopModulPrSiteArray($rowData['seitProdukte']);
      }
      // *******************************************************
      
      // Seitenfelder Ausgaben
      // *******************************************************
      $return['cms_ownFields'] = array();
      $return['cms_ownFields'] = $this->buildTheCurSeitenfelderInArray($rowData);
      // *******************************************************
      
      $curSiteIdWeiter = $rowData['seitID'];
      $hans++;
      
    }
    }
    
   
    
    if ($hans == 0) {
      if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
        header('Location: /' . $_GET['_lang'] . '');
        exit();
      }
      header('Location: /');
      exit();
    }
    else if ($hans == 1) {
      if ((isset($_GET['page_name']) && !empty($_GET['page_name'])) && $return['cms_siteID'] == $hpCms['hp_SeitStart']) {
        if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
          header('Location: /' . $_GET['_lang'] . '');
          exit();
        }
        header('Location: /');
        exit();
      }
    }
    
    if (isset($curSiteIdWeiter) && !empty($curSiteIdWeiter)) {
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
        $sqlDataLText = 'SELECT * FROM vseitelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND seitID = ' . $this->dbDecode($curSiteIdWeiter) . ' LIMIT 1';
        $sqlDataLErg = $this->dbAbfragen($sqlDataLText);

        while ($rowDataL = mysql_fetch_array($sqlDataLErg, MYSQL_ASSOC)) {
          $return['cms_langArr'] = array();
          $return['cms_langArr']['cms_siteName'] = $rowDataL['seitlaName'];
          $return['cms_langArr']['cms_siteMetaTitle'] = $rowDataL['seitlaMetaTitle'];
          $return['cms_langArr']['cms_siteMetaKeywords'] = $rowDataL['seitlaMetaKeywords'];
          $return['cms_langArr']['cms_siteMetaDesc'] = $rowDataL['seitlaMetaDesc'];
          $return['cms_langArr']['cms_siteCanonical'] = $rowDataL['seitlaCanonical'];
          $return['cms_langArr']['cms_siteNoIndex'] = $rowDataL['seitlaNoIndex'];
        }
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seiten
  // ***************************************************************************
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seitenlayouts
  // ***************************************************************************
  
  public function getSiteLayout() {
    global $cmsObj;
    global $cms;
    global $hpCms;
    global $mobileDetect;
    global $isMobileCheck;
    global $isTabletCheck;


    $sqlText = 'SELECT layFile FROM vseitenlayout WHERE layID = ' . $this->dbDecode($cms['cms_siteLayID']) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowLay = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $layFile = VCMS_ABS_PATH_TEMPLATE . 'layouts/' . $rowLay['layFile'];
    }
    
    if (isset($layFile) && !empty($layFile) && file_exists($layFile)) {
      include_once($layFile);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seitenlayouts
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Allgemeine Seitenslider Bilder
  // ***************************************************************************
  
  public function getSiteSliderPics() {
    global $cms;
    $slideImgArr = explode(';', $cms['cms_siteSlideImages']);
    if (isset($slideImgArr) && count($slideImgArr) > 1) {
      $return = '<div id="vSliderPrevSite"></div>
        <div id="vSliderNextSite"></div>';
    }
    $return .= '<div id="vSliderPicsSite">';
    
    foreach ($slideImgArr as $slideImgId) {
      $sqlSlideText = 'SELECT * FROM vbilder WHERE bildID = ' . $slideImgId . ' LIMIT 1';
      $sqlSlideErg = $this->dbAbfragen($sqlSlideText);

      while ($rowSlide = mysql_fetch_array($sqlSlideErg, MYSQL_ASSOC)) {
        $return .= '<img src="user_upload/' . $rowSlide['bildFile'] . '" alt="' . $rowSlide['bildAlt'] . '" title="' . $rowSlide['bildTitle'] . '" />';
      }
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Allgemeine Seitenslider Bilder
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Blog Ausgabe
  // ***************************************************************************
  
  public function siteBlogAusgabe() {
    $checkBlogErrorText = '';
    if (isset($_POST['vBlogFrmName'])) {
      $checkBlogErrorText = $this->checkBlogFrmData();
    }
    
    $return = $this->getBlogSocialPrivate();
    
    $return .= $this->getBlogCommentsSite();
    
    $return .= $this->getBlogCommentsForms($checkBlogErrorText);
    
    $return .= $this->getBlogJsFileIncludes();
    
    return $return;
  }
  
  
  
  private function getBlogCommentsForms($checkBlogErrorText) {
    if (!isset($_POST['vBlogFrmHideSecure']) || empty($_POST['vBlogFrmHideSecure'])) {
      $randZ = rand(1111, 99999);
    }
    else {
      $randZ = $_POST['vBlogFrmHideSecure'];
    }
    
    $return = '<div class="vBlogFrmHolder">
      <div class="blogFrmUeberschrift">Kommentar schreiben</div>';
    if (isset($checkBlogErrorText) && !empty($checkBlogErrorText)) {
      $return .= '<div class="vBlogFrmErrorAusgabe">' . $checkBlogErrorText . '</div>';
    }
    else {
      $return .= '<div class="vBlogFrmErrorAusgabe"></div>';
    }
    $return .= '<form action="" method="post" onsubmit="return vBlogCheckAreFieldsOk();">
        <label for="vBlogFrmName">Name:*</label><input maxlength="100" type="text" name="vBlogFrmName" id="vBlogFrmName" />
        
        <div class="vBlogFrmAbstand"></div>
        
        <label for="vBlogFrmMail">E-Mail:</label><input maxlength="254" type="text" name="vBlogFrmMail" id="vBlogFrmMail" />
        
        <div class="vBlogFrmAbstand"></div>
        
        <label for="vBlogFrmWeb">Webseite:</label><input maxlength="254" type="text" name="vBlogFrmWeb" id="vBlogFrmWeb" />
        
        <div class="vBlogFrmAbstand"></div>
        
        <label for="vBlogFrmText" class="vBlogLblText">Kommentar:*</label><textarea maxlength="500" name="vBlogFrmText" id="vBlogFrmText"></textarea>
        
        <div class="vBlogFrmAbstand"></div>
        
        <label for="vBlogFrmSecure">Sicherheitscode:*</label><input maxlength="10" type="text" name="vBlogFrmSecure" id="vBlogFrmSecure" /><span class="vBlogSecureAusgabe">' . $randZ . '</span>
      
        <input type="hidden" name="vBlogFrmHideSecure" id="vBlogFrmHideSecure" value="' . $randZ . '" />
        
        <div class="vBlogFrmAbstand vBlogFrmAbstandBig"></div>
        
        <input type="submit" id="vBlogSubmitBtn" value="Speichern" data-role="none" />';
    
    $return .= '</form></div>';
    
    return $return;
  }
  
  
  
  private function getBlogCommentsSite() {
    global $cms;
    $return = '<div class="blogCommentsHolder">';
    
    $sqlTextK = 'SELECT * FROM vkommentare WHERE seitID = ' . $this->dbDecode($cms['cms_siteID']) . ' AND komAktiv = 2 ORDER BY komDate DESC';
    $sqlErgK = $this->dbAbfragen($sqlTextK);
    
    if (mysql_num_rows($sqlErgK) > 0) {
      while($rowK = mysql_fetch_array($sqlErgK, MYSQL_ASSOC)) {
        $dateAllK = explode(' ', $rowK['komDate']);
        $dateZwK = explode('-', $dateAllK[0]);
        $timeZwK = explode(':', $dateAllK[1]);
        $curDateAusgabeK = $dateZwK[2] . '.' . $dateZwK[1] . '.' . $dateZwK[0] . ' um ' . $timeZwK[0] . ':' . $timeZwK[1] . ' Uhr';

        $return .= '<div class="vBlogCommentElem">';
        $return .= '<div class="vBlogElemTop"><span class="vBlogElemName">' . htmlentities($rowK['komName'], ENT_QUOTES, 'UTF-8') . '</span><span class="vBlogElemDate">' . $curDateAusgabeK . '</span></div>';
        $return .= '<div class="vBlogElemWrap">' . nl2br(htmlentities($rowK['komText'], ENT_QUOTES, 'UTF-8')) . '</div>';
        $return .= '</div>';
      }
    }
    else {
      $return .= '<div class="vBlogNoComments">Es sind keine Kommentare für diesen Beitrag vorhanden.</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function checkBlogFrmData() {
    $return = '';
    
    if (isset($_POST['vBlogFrmName']) && empty($_POST['vBlogFrmName'])) {
      $return .= 'Bitte geben Sie Ihren Name ein!<br />';
    }
    if (isset($_POST['vBlogFrmText']) && empty($_POST['vBlogFrmText'])) {
      $return .= 'Bitte geben Sie einen Kommentar ein!<br />';
    }
    if (isset($_POST['vBlogFrmSecure']) && empty($_POST['vBlogFrmSecure'])) {
      $return .= 'Bitte geben Sie den Sicherheitscode ein!<br />';
    }
    if (isset($_POST['vBlogFrmSecure']) && !empty($_POST['vBlogFrmSecure']) && $_POST['vBlogFrmSecure'] != $_POST['vBlogFrmHideSecure']) {
      $return .= 'Der eingebene Sicherheitscode ist falsch!<br />';
    }
    
    if (isset($return) && !empty($return)) {
      return $return;
    }
    else {
      if ($this->saveDataBlogForm()) {
        unset($_POST['vBlogFrmHideSecure']);
        return '';
      }
      else {
        return 'Datenbank Fehler';
      }
    }
  }
  
  
  
  private function saveDataBlogForm() {
    global $cms;
    $aktIP = $this->getCurUserIP();
    $aktDate = date('Y-m-d h:i:s');//$dateArr[2].'-'.$dateArr[1].'-'.$dateArr[0].' '.$time.':00'; //YYYY-MM-DD HH:MM:SS

    $sqlTextKoSave = 'INSERT INTO vkommentare 
      (komName, komMail, komWebseite, komText, komIP, komDate, seitID, komAktiv) 
      VALUES 
      ("' . $this->dbDecode($_POST['vBlogFrmName']) . '", "' . $this->dbDecode($_POST['vBlogFrmMail']) . '", "' . $this->dbDecode($_POST['vBlogFrmWeb']) . '", "' . $this->dbDecode($_POST['vBlogFrmText']) . '", "' . $this->dbDecode($aktIP) . '", "' . $this->dbDecode($aktDate) . '", ' . $this->dbDecode($cms['cms_siteID']) . ', 2)';
    $sqlErgKoSave = $this->dbAbfragen($sqlTextKoSave);

    return $sqlErgKoSave;
  }
  
  
  
  private function getBlogSocialPrivate() {
    return '<div class="vBlogSocialHolder"><div id="vBlogSocialPrivate"></div><div class="clearer"></div></div>';
  }
  
  
  
  private function getBlogJsFileIncludes() {
    return '<script type="text/javascript" src="socialshareprivacy/jquery.socialshareprivacy.min.js"></script>';
  }
  
  
  
  private function getCurUserIP() {
    $realip = '';

    if (isset($_SERVER)){
      if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      }
      else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $realip = $_SERVER["HTTP_CLIENT_IP"];
      }
      else {
        $realip = $_SERVER["REMOTE_ADDR"];
      }
    }
    else {
      if (getenv('HTTP_X_FORWARDED_FOR')){
        $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
      }
      else if (getenv('HTTP_CLIENT_IP')) {
        $realip = getenv( 'HTTP_CLIENT_IP' );
      }
      else {
        $realip = getenv( 'REMOTE_ADDR' );
      }
    }

    return $realip;
  }

  // ***************************************************************************
  // ANFANG - Funktionen für Blog Ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Blog Ausgabe Seitenliste
  // ***************************************************************************
  
  public function getBlogSeitenListe($curParent = 'all', $limitAll = 5) {
    $return = '<div class="blogListElemsHolder">';
    
    if (isset($curParent) && $curParent == 'all') {
      $sqlListText = 'SELECT * FROM vseiten WHERE seitArt = 2 AND seitOnline = 1 ORDER BY seitCreateDate DESC LIMIT ' . $this->dbDecode($limitAll);
      $sqlListErg = $this->dbAbfragen($sqlListText);
      
      while ($rowList = mysql_fetch_array($sqlListErg, MYSQL_ASSOC)) {
        $return .= $this->buildSiteListNow($rowList);
      }
    }
    else {
      $sqlListText = 'SELECT * FROM vseiten WHERE seitParent = ' . $this->dbDecode($curParent) . ' AND seitArt = 2 AND seitOnline = 1 ORDER BY seitCreateDate DESC';
      $sqlListErg = $this->dbAbfragen($sqlListText);
      
      while ($rowList = mysql_fetch_array($sqlListErg, MYSQL_ASSOC)) {
        $return .= $this->buildSiteListNow($rowList);
      }
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildSiteListNow($siteArr) {
    $menuLangVar = '';
    if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
      $menuLangVar = $_GET['_lang'].'/';
    }
    $picAusgabe = '';
    $curText = $this->getTextForBlogListElem($siteArr['seitID']);
    if (isset($siteArr['seitListImage']) && !empty($siteArr['seitListImage'])) {
      $picID = explode(';', $siteArr['seitListImage']);
      $picArr = $this->getPicForBlogListElem($picID[0]);
      if (count($picArr) > 0) {
        $picAusgabe = '<a href="' . $menuLangVar . $siteArr['seitTextUrl'] . '"><img src="user_upload/' . $picArr['bildFile'] . '" alt="' . $picArr['bildAlt'] . '" title="' . $picArr['bildTitel'] . '" /></a>';
      }
    }
    
    $return = '<div class="blogListElem">';
    
    $return .= '<div class="blogListElemPic">' . $picAusgabe . '</div>';
    $return .= '<div class="blogListElemText">
        <div class="blogListElemTextInhalt">' . $curText . '</div>
        <a href="' . $menuLangVar . $siteArr['seitTextUrl'] . '">weiterlesen</a>
      </div>';
    
    $return .= '<div class="clearer"></div></div><div class="clearer"></div>';
    
    return $return;
  }
  
  
  
  private function getPicForBlogListElem($picID) {
    $return = array();
    
    $sqlPicText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($picID) . ' LIMIT 1';
    $sqlPicErg = $this->dbAbfragen($sqlPicText);
    
    while ($rowPic = mysql_fetch_array($sqlPicErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    
    return $return;
  }
  
  
  
  private function getTextForBlogListElem($siteID) {
    $return = '';
    
    $sqlElText = 'SELECT selemInhalt FROM vseitenelemente WHERE seitID = ' . $this->dbDecode($siteID) . ' ORDER BY selemPosition ASC LIMIT 1';
    $sqlElErg = $this->dbAbfragen($sqlElText);
    
    while ($rowEl = mysql_fetch_array($sqlElErg, MYSQL_ASSOC)) {
      $return .= $rowEl['selemInhalt'];
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Blog Ausgabe Seitenliste
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Sprach Einträge Ausgaben
  // ***************************************************************************
  
  private function getCurentLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  
  
  private function getCurentLangNavigationName($siteID, $langUrlName, $origSiteName) {
    $curLangId = $this->getCurentLangIdFromUrlName($langUrlName);
    $sqlNameText = 'SELECT seitlaName FROM vseitelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
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
  
  private function getCurentLangNavigationUrl($siteID, $langUrlName, $origSiteName) {
    $curLangId = $this->getCurentLangIdFromUrlName($langUrlName);
    $sqlNameText = 'SELECT seitlaTextUrl FROM vseitelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlNameErg = $this->dbAbfragen($sqlNameText);
    $curLangName = '';
    while ($rowName = mysql_fetch_array($sqlNameErg, MYSQL_ASSOC)) {
      $curLangName = $rowName['seitlaTextUrl'];
    }
    if (isset($curLangName) && !empty($curLangName)) {
      return $curLangName;
    }
    return false;
  }
  
  
  // ***************************************************************************
  // ENDE - Funktionen Sprach Einträge Ausgaben
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Shop Modul Produkte
  // ***************************************************************************
  
  private function buildShopModulPrSiteArray($productIds) {
    $return = array();
    
    if (isset($productIds) && !empty($productIds)) {
      $curPrIds = explode(';', $productIds);
      foreach ($curPrIds as $prId) {
        $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
        $sqlErg = $this->dbAbfragen($sqlText);

        while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          $return[$rowPr['prID']] = $rowPr;
        }
      }
    }
    
    return $return;
  }
  
  
  
  
  public function getShopModulProductList($listFloatCount = 3, $curBetragAusgabe = 'netto') {
    global $cms;
    if ($this->checkIsShopModulActiv()) {
      return $this->buildShopModulProductList($cms, $listFloatCount, $curBetragAusgabe);
    }
    else {
      return '<div class="vCmsShopModulNoActivInfo">Das Shop Modul ist nicht aktiviert!</div>';
    }
  }
  
  
  
  public function getShopModulWarenkorbSmall($siteId = 0, $curBetragAusgabe = 'netto') {
    global $cms;
    if ($this->checkIsShopModulActiv()) {
      return $this->buildShopModulWarenkorbSmall($cms, $siteId, $curBetragAusgabe);
    }
    else {
      return '<div class="vCmsShopModulNoActivInfo">Das Shop Modul ist nicht aktiviert!</div>';
    }
  }
  
  
  
  private function buildShopModulWarenkorbSmall($cms, $siteId, $curBetragAusgabe) {
    setlocale(LC_MONETARY, 'de_AT');
    $curLinkUriW = $this->getWarenkorbLinkUrl($siteId);
    
    $priceGesK = $this->getWarenkorbGesamtPreis($curBetragAusgabe);
    
    $return = '<a class="vCmsShopModWarenkorbInfoLink" href="' . $curLinkUriW . '" data-role="none">';
    $return .= '<div class="vCmsShopModWarenkorbInfo" data-betrag="'.$curBetragAusgabe.'">';
    $return .= '<div class="vCmsShopModWarenkorbInfoPreis">' . money_format('EUR %!n', $priceGesK) . '</div>';
    $return .= '<div class="vCmsShopModWarenkorbInfoText">Warenkorb</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '<div class="vCmsShopModWarenkorbInfoShowNewPrText">Der Artikel wurde erfolgreich zum Warenkorb hinzugefügt</div>';
    $return .= '</div>';
    $return .= '</a>';
    return $return;
  }
  
  
  
  private function buildShopModulProductList($cms, $listFloatCount, $curBetragAusgabe) {
    $return = '<div class="vCmsShopModListHolder">';
    
    if (isset($cms['cms_shopProducts']) && count($cms['cms_shopProducts']) > 0) {
      $hansCount = 0;
      $hansCountGesamt = 0;
      $hansCountDetail = 1;
      foreach ($cms['cms_shopProducts'] as $key => $value) {
        $hansCountGesamt++;
        $hansCount++;
        $firstClass = '';
        if ($hansCount == 1) {
          $firstClass = ' vCmsShopModListElementFirst';
        }
        $return .= $this->buildShopModulProductListElement($key, $value, $firstClass, $hansCountDetail, $curBetragAusgabe);
        if ($hansCount == $listFloatCount) {
          $hansCount = 0;
          $return .= '<div class="clearer" style="height:1px;"></div>';
          $return .= '<div class="vCmsShopModListElementDetailInhaltClass" id="vCmsShopModListElementDetailInhalt' . $hansCountDetail . '"><div style="height:1px;"></div><div class="vCmsShopModListElementDetailClose" data-detail="' . $hansCountDetail . '" title="Schließen"></div><div class="vCmsShopModListElementDetailInhaltClassInhalt"></div></div>';
          $return .= '<div class="clearer vCmsShopModListHolderAbstand"></div>';
          $hansCountDetail++;
        }
        else if ($hansCountGesamt == count($cms['cms_shopProducts']) && $hansCount != $listFloatCount) {
          $return .= '<div class="clearer" style="height:1px;"></div>';
          $return .= '<div class="vCmsShopModListElementDetailInhaltClass" id="vCmsShopModListElementDetailInhalt' . $hansCountDetail . '"><div style="height:1px;"></div><div class="vCmsShopModListElementDetailClose" data-detail="' . $hansCountDetail . '" title="Schließen"></div><div class="vCmsShopModListElementDetailInhaltClassInhalt"></div></div>';
          $return .= '<div class="clearer vCmsShopModListHolderAbstand"></div>';
          $hansCountDetail++;
        }
      }
    }
    
    $return .= '</div>';
   
    return $return;
  }
  
  
  
  private function buildShopModulProductListElement($produktID, $produktArr, $firstClass = '', $hansCountDetail, $curBetragAusgabe) {
    setlocale(LC_MONETARY, 'de_AT');
    
    $return = '<div class="vCmsShopModListElement' . $firstClass . '">';
    if (isset($produktArr['prBild']) && !empty($produktArr['prBild'])) {
      $curPicArr = $this->getPicForModShopListElem($produktArr['prBild']);
      $thumbVar = '';
      if (file_exists('user_upload/thumb_400/'.$curPicArr['bildFile'])) {
        $thumbVar = 'thumb_400/';
      }
      $return .= '<div class="vCmsShopModListElementBild"><img src="user_upload/' . $thumbVar . $curPicArr['bildFile'] . '" alt="' . $curPicArr['bildAlt'] . '" title="' . $curPicArr['bildTitel'] . '" /></div>';
    }
    else {
      $return .= '<div class="vCmsShopModListElementBild"><img src="admin/img/noImg.png" alt="NoImg" title="" /></div>';
    }
    
    $return .= '<div class="vCmsShopModListElementName">' . $produktArr['prName'] . '</div>';
    
    // Rabatt
    // ********************************************
    $einzelPreis = $produktArr['prPreis'];
    $rabattIs = false;
    if (isset($produktArr['prRabattArt']) && $produktArr['prRabattArt'] == 'betrag') {
      $einzelPreis = $einzelPreis - $produktArr['prRabatt'];
      $rabattIs = true;
    }
    else if (isset($produktArr['prRabattArt']) && $produktArr['prRabattArt'] == 'prozent') {
      $zwPreis = $einzelPreis / 100;
      $zwPreis = $zwPreis * $produktArr['prRabatt'];
      $einzelPreis = $einzelPreis - $zwPreis;
      $rabattIs = true;
    }
    // ********************************************
    
    // Wenn Brutto Ausgabe gewählt ist
    // **********************************************************
    if ($curBetragAusgabe == 'brutto') {
      $zwSteuerBetrag = ($einzelPreis / 100) * $produktArr['prSteuersatz'];
      $einzelPreis = $einzelPreis + $zwSteuerBetrag;
    }
    // **********************************************************
    
    if ($rabattIs == true) {
      $return .= '<div class="vCmsShopModListElementPreisNoRabatt">' . money_format('EUR %!n', $produktArr['prPreis']) . '</div>';
    }
    else {
      $return .= '<div class="vCmsShopModListElementPreisNoRabatt" style="text-decoration:none;">&nbsp;</div>';
    }
    $return .= '<div class="vCmsShopModListElementPreis">' . money_format('EUR %!n', $einzelPreis) . '</div>';
    $return .= '<div class="clearer"></div>';
    
    $return .= '<div class="vCmsShopModListElementBtnMehr" data-id="' . $produktID . '" data-detail="' . $hansCountDetail . '">mehr</div>';
    $return .= '<div class="vCmsShopModListElementBtnWarenkorb" data-id="' . $produktID . '">In den Warenkorb</div>';
    $return .= '<div class="clearer"></div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getPicForModShopListElem($picID) {
    $return = array();
    
    $sqlPicText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($picID) . ' LIMIT 1';
    $sqlPicErg = $this->dbAbfragen($sqlPicText);
    
    while ($rowPic = mysql_fetch_array($sqlPicErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    
    return $return;
  }
  
  
  
  private function getWarenkorbGesamtPreis($curBetragAusgabe) {
    $return = 0;
    
    if (isset($_SESSION['cmsShopModulProductsAll']) && count($_SESSION['cmsShopModulProductsAll']) > 0) {
      foreach ($_SESSION['cmsShopModulProductsAll'] as $key => $value) {
        $curBetragEinzel = $this->getWarenkorbPreisProduktEinzel($key, $value, $curBetragAusgabe);
        $return = $return + $curBetragEinzel;
      }
    }
    
    return $return;
  }
  
  
  
  private function getWarenkorbPreisProduktEinzel($prId, $prMenge, $curBetragAusgabe) {
    $return = 0;
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $einzelPreis = $rowPr['prPreis'];
      if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'betrag') {
        $einzelPreis = $einzelPreis - $rowPr['prRabatt'];
      }
      else if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'prozent') {
        $zwPreis = $einzelPreis / 100;
        $zwPreis = $zwPreis * $rowPr['prRabatt'];
        $einzelPreis = $einzelPreis - $zwPreis;
      }
      $return = $einzelPreis * $prMenge;
      
      // Wenn Brutto Ausgabe gewählt ist
      // **********************************************************
      if ($curBetragAusgabe == 'brutto') {
        $zwSteuerBetrag = ($return / 100) * $rowPr['prSteuersatz'];
        $return = $return + $zwSteuerBetrag;
      }
      // **********************************************************
    }
    
    return $return;
  }
  
  
  
  private function getWarenkorbLinkUrl($siteId) {
    $return = '#';
    
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = ' . $this->dbDecode($siteId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['seitTextUrl'];
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Shop Modul Produkte
  // ***************************************************************************
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Shop Modul Warenkorb
  // ***************************************************************************
  
  public function getShopModulWarenkorbSeiteInhalt($curUserMail, $curBetragAusgabe = 'netto', $kundeMailArr = '') {
    if (!isset($kundeMailArr) || !is_array($kundeMailArr)) {
      $kundeMailArr = array();
      $kundeMailArr['textHeader'] = '';
      $kundeMailArr['textFooter'] = '';
      $kundeMailArr['textBetreff'] = 'Online Shop Anfrage';
      $kundeMailArr['sendMail'] = 'nosend@cms.at';
      $kundeMailArr['sendMailName'] = 'Anfrage';
    }
    
    global $cms;
    if ($this->checkIsShopModulActiv()) {
      return $this->buildShopModulWarenkorb($curUserMail, $curBetragAusgabe, $kundeMailArr);
    }
    else {
      return '<div class="vCmsShopModulNoActivInfo">Das Shop Modul ist nicht aktiviert!</div>';
    }
  }
  
  
  
  private function buildShopModulWarenkorb($curUserMail, $curBetragAusgabe, $kundeMailArr) {
    $return = '<div class="vCmsShopModulBigWarenkorbHolder">';
    $return .= '<h1>Warenkorb:</h1>';
    $return .= $this->buildShopModulWarenkorbProductLists($curUserMail, $curBetragAusgabe, $kundeMailArr);
    $return .= $this->buildShopModulWarenkorbForms($curUserMail, $curBetragAusgabe, $kundeMailArr);
    $return .= '<div class="clearer"></div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildShopModulWarenkorbProductLists($curUserMail, $curBetragAusgabe, $kundeMailArr) {
    setlocale(LC_MONETARY, 'de_AT');
    $gesamtBetrag = 0;
    $gesamtBetragSteuer = 0;
    
    $return = '<div class="vCmsShopModulBigWarenkorbListHolder">';
    $return .= $this->buildShopModulWarenkorbProductListsNow($gesamtBetrag, $gesamtBetragSteuer, $curUserMail, $curBetragAusgabe);
    $return .= '<div class="vCmsShopModulBigWarenkorbGesamtNetto"><span class="vCmsShopModulBigWarenkorbUeGesamt">Gesamtpreis Netto</span><span class="vCmsShopModulBigWarenkorbUeInhaltGesamt">'.money_format('EUR %!n', $gesamtBetrag).'</span></div>';
    $return .= '<div class="vCmsShopModulBigWarenkorbMwst"><span class="vCmsShopModulBigWarenkorbUeGesamt">+ MwSt</span><span class="vCmsShopModulBigWarenkorbUeInhaltGesamt">'.money_format('EUR %!n', $gesamtBetragSteuer).'</span></div>';
    $return .= '<div class="vCmsShopModulBigWarenkorbGesamtBrutto"><span class="vCmsShopModulBigWarenkorbUeGesamt">Gesamtpreis Brutto</span><span class="vCmsShopModulBigWarenkorbUeInhaltGesamt">'.money_format('EUR %!n', $gesamtBetrag + $gesamtBetragSteuer).'</span></div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function buildShopModulWarenkorbProductListsNow(&$gesamtBetrag, &$gesamtBetragSteuer, $curUserMail, $curBetragAusgabe) {
    $return = '';
    
    if (isset($_SESSION['cmsShopModulProductsAll']) && count($_SESSION['cmsShopModulProductsAll']) > 0) {
      foreach ($_SESSION['cmsShopModulProductsAll'] as $key => $value) {
        $return .= $this->buildShopModulWarenkorbProductListsEinzel($key, $value, $gesamtBetrag, $gesamtBetragSteuer, $curUserMail, $curBetragAusgabe);
      }
    }
    else {
      $return .= '<div class="vCmsShopModulBigWarenkorbListEmpty">Es sind keine Produkte im Warenkorb.</div>';
    }
    
    return $return;
  }
  
  
  
  private function buildShopModulWarenkorbProductListsEinzel($prId, $prMenge, &$gesamtBetrag, &$gesamtBetragSteuer, $curUserMail, $curBetragAusgabe) {
    setlocale(LC_MONETARY, 'de_AT');
    $return = '';
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vCmsShopModulBigWarenkorbListElem">';
      
      $return .= '<div class="vCmsShopModulBigListElemMenge">';
      $return .= '<div>Menge</div>';
      $return .= '<input type="text" name="vCmsShopModulMengeFrm" id="vCmsShopModulMengeFrm" readonly="readonly" value="' . $prMenge . '" />';
      $return .= '<img class="vCmsShopModulMengePlusBtn" src="admin/img/plusShopMenge.png" alt="" title="" data-id="' . $prId . '" />';
      $return .= '<img class="vCmsShopModulMengeMinusBtn" src="admin/img/minusShopMenge.png" alt="" title="" data-id="' . $prId . '" />';
      $return .= '<span class="vCmsShopModulProductDelW" data-id="' . $prId . '">löschen</span>';
      $return .= '<div class="clearer"></div>';
      $return .= '</div>';
      
      $einzelPreis = $rowPr['prPreis'];
      if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'betrag') {
        $einzelPreis = $einzelPreis - $rowPr['prRabatt'];
      }
      else if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'prozent') {
        $zwPreis = $einzelPreis / 100;
        $zwPreis = $zwPreis * $rowPr['prRabatt'];
        $einzelPreis = $einzelPreis - $zwPreis;
      }
      $einzelPreis = $einzelPreis * $prMenge;
      $zwEinzelSteuer = ($einzelPreis / 100) * $rowPr['prSteuersatz'];
      $einzelSteuer = $zwEinzelSteuer;
      
      $gesamtBetrag = $gesamtBetrag + $einzelPreis;
      $gesamtBetragSteuer = $gesamtBetragSteuer + $einzelSteuer;
      
      // Wenn Brutto Ausgabe gewählt ist
      // **********************************************************
      if ($curBetragAusgabe == 'brutto') {
        $einzelPreis = $einzelPreis + $einzelSteuer;
      }
      // **********************************************************
      
      $return .= '<div class="vCmsShopModulBigListElemInhalt">';
      $return .= '<div class="vCmsShopModulBigListElemInhaltName">' . $rowPr['prName'] . '</div>';
      $return .= '<div class="vCmsShopModulBigListElemInhaltPreis">Summe ' . money_format('EUR %!n', $einzelPreis) . '</div>';
      $return .= '<div class="clearer"></div>';
      $return .= '</div>';
      
      $return .= '<div class="vCmsShopModulBigListElemBild">';
      $return .= $this->buildShopModulWarenkorbProductPic($rowPr['prBild']);
      $return .= '<div class="clearer"></div>';
      $return .= '</div>';
      
      $return .= '<div class="clearer"></div>';
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function buildShopModulWarenkorbProductPic($picId) {
    $return = '';
    if (isset($picId) && !empty($picId) && $picId > 0) {
      $sqlText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($picId) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);

      while ($rowPic = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $return = $rowPic;
      }
    }
    if (isset($return) && is_array($return)) {
      $thumbVar = '';
      if (file_exists('user_upload/thumb_200/'.$return['bildFile'])) {
        $thumbVar = 'thumb_200/';
      }
      return '<img src="user_upload/' . $thumbVar . $return['bildFile'] . '" alt="" title="" />';
    }
    else {
      return '<img src="admin/img/noImg.png" alt="" title="" />';
    }
  }
  
  
  
  private function buildShopModulWarenkorbForms($curUserMail, $curBetragAusgabe, $kundeMailArr) {
    $return = '<div class="vCmsShopModulBigWarenkorbFormsHolder">';
    
    if (isset($_POST['vshopFrmName']) && !empty($_POST['vshopFrmName'])) {
      $this->sendShopModulWarenkorbForms($curUserMail, $curBetragAusgabe, $kundeMailArr);
      $return .= '<div class="vCmsShopModulBigWarenkorbFormsOkAusgabe">Danke, Ihre Anfrage wurde erfolgreich gesendet.</div>';
      unset($_SESSION['cmsShopModulProductsAll']);
    }
    else {
    
      $return .= '<div class="vCmsShopModulBigWarenkorbFormsError"></div>';

      $return .= '<form action="" method="post" onsubmit="return checkDataModShopWarenkorbCheck();">';
      
      $return .= '<label for="vshopFrmTitel">Titel:*</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<select name="vshopFrmTitel" id="vshopFrmTitel">
                  <option value="Herr">Herr</option>
                  <option value="Frau">Frau</option>
              </select>';
      
      $return .= '<div class="vshopFrmAbstand"></div>';
      
      $return .= '<label for="vshopFrmName">Vorname:*</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmName" id="vshopFrmName" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label for="vshopFrmNachName">Nachname:*</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmNachName" id="vshopFrmNachName" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label for="vshopFrmStrasse">Straße:</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmStrasse" id="vshopFrmStrasse" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label for="vshopFrmPlz">PLZ / Ort:</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmPlz" id="vshopFrmPlz" />';
      $return .= '<input type="text" name="vshopFrmOrt" id="vshopFrmOrt" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label for="vshopFrmTelefon">Telefon:</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmTelefon" id="vshopFrmTelefon" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label for="vshopFrmMail">E-Mail:*</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<input type="text" name="vshopFrmMail" id="vshopFrmMail" />';

      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<label style="vertical-align:top;" for="vshopFrmText">Nachricht:</label>';
      $return .= '<div class="vshopFrmLblAbstand"></div>';
      $return .= '<textarea name="vshopFrmText" id="vshopFrmText"></textarea>';

      $return .= '<div class="vshopFrmAbstand"></div>';
      $return .= '<div class="vshopFrmAbstand"></div>';
      $return .= '<div class="vshopFrmAbstand"></div>';

      $return .= '<input type="submit" value="senden" />';

      $return .= '</form>';
    
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function sendShopModulWarenkorbForms($curUserMail, $curBetragAusgabe, $kundeMailArr) {
    
    $this->sendShopModulWarenkorbFormsKundeNow($kundeMailArr, $curBetragAusgabe);
    
    $mailText = 'Neue Online Shop Anfrage:<br />
    ----------------------------------------------------------------<br />
    <br />
    <table width="500" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="100">Titel:</td><td>' . $_POST['vshopFrmTitel'] . '</td>
      </tr>
      <tr>
        <td width="100">Vorname:</td><td>' . $_POST['vshopFrmName'] . '</td>
      </tr>
      <tr>
        <td width="100">Nachname:</td><td>' . $_POST['vshopFrmNachName'] . '</td>
      </tr>
      <tr>
        <td width="100">Strasse:</td><td>' . $_POST['vshopFrmStrasse'] . '</td>
      </tr>
      <tr>
        <td width="100">PLZ:</td><td>' . $_POST['vshopFrmPlz'] . '</td>
      </tr>
      <tr>
        <td width="100">Ort:</td><td>' . $_POST['vshopFrmOrt'] . '</td>
      </tr>
      <tr>
        <td width="100">Telefon:</td><td>' . $_POST['vshopFrmTelefon'] . '</td>
      </tr>
      <tr>
        <td width="100">E-Mail:</td><td>' . $_POST['vshopFrmMail'] . '</td>
      </tr>
      <tr>
        <td width="100" valign="top">Nachricht:</td><td>' . nl2br($_POST['vshopFrmText']) . '</td>
      </tr>
    </table>';
    
    $mailText .= '<br /><br />Produkte:<br />
    ----------------------------------------------------------------<br />
    <br />';
    
    $mailText .= $this->buildMailSendShopModulWarenkorbProdukte($curBetragAusgabe);
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: " . $_POST['vshopFrmName'] . " " . $_POST['vshopFrmNachName'] . " <" . $_POST['vshopFrmMail'] . ">" . "\n";
    $mailSubject = 'Neue Online Shop Anfrage';
    $mailTo = $curUserMail;


    if(mail($mailTo, $mailSubject, $mailText, $header)) {
      $isSendOk = 'ok';
    }
    else {
      $isSendOk = 'no';
    }
  }
  
  
  
  private function sendShopModulWarenkorbFormsKundeNow($kundeMailArr, $curBetragAusgabe) {
    $mailTextKunde = $kundeMailArr['textHeader'];
    
    $mailTextKunde .= $this->buildMailSendShopModulWarenkorbProdukte($curBetragAusgabe);
    
    $mailTextKunde .= $kundeMailArr['textFooter'];
    
    $header  = 'MIME-Version: 1.0' . "\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\n";
    $header .= "From: " . $kundeMailArr['sendMailName'] . " <" . $kundeMailArr['sendMail'] . ">" . "\n";
    $mailSubject = $kundeMailArr['textBetreff'];
    $mailTo = $_POST['vshopFrmMail'];


    mail($mailTo, $mailSubject, $mailTextKunde, $header);
  }
  
  
  
  private function buildMailSendShopModulWarenkorbProdukte($curBetragAusgabe) {
    setlocale(LC_MONETARY, 'de_AT');
    $return = '<table width="500" border="0" cellspacing="0" cellpadding="5">';
    
    $sendGesamtbetragNetto = 0;
    $sendGesamtbetragSteuer = 0;
    
    if (isset($_SESSION['cmsShopModulProductsAll']) && count($_SESSION['cmsShopModulProductsAll']) > 0) {
      foreach ($_SESSION['cmsShopModulProductsAll'] as $key => $value) {
        $prArr = $this->getProductArrayForMailSend($key);
        if (isset($prArr) && is_array($prArr)) {
          $zwEinzelPreis = $prArr['prPreis'];
          if (isset($prArr['prRabattArt']) && $prArr['prRabattArt'] == 'betrag') {
            $zwEinzelPreis = $zwEinzelPreis - $prArr['prRabatt'];
          }
          else if (isset($prArr['prRabattArt']) && $prArr['prRabattArt'] == 'prozent') {
            $zwPreis = $zwEinzelPreis / 100;
            $zwPreis = $zwPreis * $prArr['prRabatt'];
            $zwEinzelPreis = $zwEinzelPreis - $zwPreis;
          }
          
          $zwEinzelPreis = $zwEinzelPreis * $value;
          
          $zwEinzelSteuer = ($zwEinzelPreis / 100) * $prArr['prSteuersatz'];
          $prEinzelSteuer = $zwEinzelSteuer;

          $prEinzelPreis = $zwEinzelPreis;
          
          $sendGesamtbetragNetto = $sendGesamtbetragNetto + $prEinzelPreis;
          $sendGesamtbetragSteuer = $sendGesamtbetragSteuer + $prEinzelSteuer;

          // Wenn Brutto Ausgabe gewählt ist
          // **********************************************************
          if ($curBetragAusgabe == 'brutto') {
            $prEinzelPreis = $prEinzelPreis + $prEinzelSteuer;
          }
          // **********************************************************
        
          $return .= '<tr>';
          $return .= '<td width="40">' . $value . 'x</td><td width="300">' . $prArr['prName'] . '</td><td>' . money_format('EUR %!n', $prEinzelPreis) . '</td>';
          $return .= '</tr>';
        }
      }
    }
    
    $return .= '</table>';
    
    $return .= '<br /><br />';
    
    $return .= '<table width="500" border="0" cellspacing="0" cellpadding="5">';
    $return .= '<tr style="font-size:14px;">';
    $return .= '<td width="40">&nbsp;</td><td width="300">Gesamtpreis Netto:</td><td>' . money_format('EUR %!n', $sendGesamtbetragNetto) . '</td>';
    $return .= '</tr>';
    $return .= '<tr style="font-size:14px;">';
    $return .= '<td width="40">&nbsp;</td><td width="300">+ MwSt:</td><td>' . money_format('EUR %!n', $sendGesamtbetragSteuer) . '</td>';
    $return .= '</tr>';
    $return .= '<tr style="font-size:16px;">';
    $return .= '<td width="40">&nbsp;</td><td width="300">Gesamtpreis Brutto:</td><td>' . money_format('EUR %!n', ($sendGesamtbetragNetto + $sendGesamtbetragSteuer)) . '</td>';
    $return .= '</tr>';
    $return .= '</table>';
    
    return $return;
  }
  
  
  
  private function getProductArrayForMailSend($prId) {
    $return = '';
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowSend = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowSend;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Shop Modul Warenkorb
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Hintergrund Bilder
  // ***************************************************************************
  
  public function getCMSBackgroundImageJsNow($cms, $hpCms) {
    $return = '';
    
    if (isset($cms['cms_siteBackImages']) && !empty($cms['cms_siteBackImages'])) {
      $return .= $this->buildCMSBackgroundImageJsNow($cms['cms_siteBackImages']);
    }
    else if ($cms['cms_siteID'] != $hpCms['hp_SeitStart']) {
      $return .= $this->getCMSBackgroundImageJsNowInherit($cms['cms_siteParent'], $hpCms);
    }
    
    return $return;
  }
  
  
  
  private function getCMSBackgroundImageJsNowInherit($siteId, $hpCms) {
    $return = '';
    
    if (isset($siteId) && $siteId != 0) {
      $curRowArr = '';
      $sqlTextEl = 'SELECT seitParent, seitBackImages FROM vseiten WHERE seitID = ' . $this->dbDecode($siteId) . ' LIMIT 1';
      $sqlErgEl = $this->dbAbfragen($sqlTextEl);
      while($row = mysql_fetch_array($sqlErgEl, MYSQL_ASSOC)) {
        $curRowArr = $row;
      }
      if (isset($curRowArr['seitBackImages']) && !empty($curRowArr['seitBackImages'])) {
        $return .= $this->buildCMSBackgroundImageJsNow($curRowArr['seitBackImages']);
      }
      else {
        $return .= $this->getCMSBackgroundImageJsNowInherit($curRowArr['seitParent'], $hpCms);
      }
    }
    else {
      $curList = '';
      $sqlTextEl = 'SELECT seitBackImages FROM vseiten WHERE seitID = ' . $this->dbDecode($hpCms['hp_SeitStart']) . ' LIMIT 1';
      $sqlErgEl = $this->dbAbfragen($sqlTextEl);
      while($row = mysql_fetch_array($sqlErgEl, MYSQL_ASSOC)) {
        $curList = $row['seitBackImages'];
      }
      if (isset($curList) && !empty($curList)) {
        $return .= $this->buildCMSBackgroundImageJsNow($curList);
      }
    }
    
    return $return;
  }
  
   
  
  private function buildCMSBackgroundImageJsNow($list) {
     global $isMobileCheck;
    $return = '';
    
    if (isset($list) && !empty($list)) {
      $backImgArr = explode(';', $list);
      $hansBG = 0;
      $return .= '<script type="text/javascript">';
      $backImagesJS = 'var backImages = new Array(';
      foreach ($backImgArr as $backImgId) {
        $sqlTextBG = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($backImgId) . ' LIMIT 1';
        $sqlErgBG = $this->dbAbfragen($sqlTextBG);
        while ($rowBG = mysql_fetch_array($sqlErgBG, MYSQL_ASSOC)) {
          $thumbVarMobBack = '';
          if (isset($isMobileCheck) && $isMobileCheck == true && file_exists('user_upload/thumb_800/'.$rowBG['bildFile'])) {
            $thumbVarMobBack = 'thumb_800/';
          }
          $hansBG++;
          if ($hansBG == 1) {
            $return .= 'var backImageOnce = "user_upload/' . $thumbVarMobBack . $rowBG['bildFile'] . '";';
          }
          if (isset($backImgArr) && count($backImgArr) > 1) {
            if ($hansBG == 1) {
              $backImagesJS .= '"user_upload/' . $thumbVarMobBack . $rowBG['bildFile'] . '"';
            }
            else {
              $backImagesJS .= ', "user_upload/' . $thumbVarMobBack . $rowBG['bildFile'] . '"';
            }
          }
        }
      }
      $backImagesJS .= ');';
      $return .= $backImagesJS;
      $return .= '</script>';
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Hintergrund Bilder
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  
  
  
  public function getCmsMenuParentIDUrlHack($menuID, $curHack) {
    $return = '<div class="v_siteMenu">';
    
    $return .= $this->getCmsUnterMenuUrlHack($menuID, 'v_siteUnterMenu', 1, $curHack);
    
    $return .= '</div>';
    
    return $return;
  }

  
  

  private function getCmsUnterMenuUrlHack($menuParentID, $menuClass = 'v_siteUnterMenu', $curDeep = 1, $curHack = '') {
    $return = '';
    $menuLangVar = '';
    if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
      $menuLangVar = $_GET['_lang'].'/';
    }
    
    $sqlNavUText = 'SELECT * FROM vseiten WHERE seitParent = ' . $this->dbDecode($menuParentID) . ' AND seitOnline = 1 AND seitNoNavi = 1 ORDER BY seitPosition ASC';
    $sqlNavUErg = $this->dbAbfragen($sqlNavUText);
    $sqlNavUErgCount = mysql_num_rows($sqlNavUErg);
    
    $setDiv = false;
    if ($sqlNavUErgCount > 0) {
      if (isset($curDeep) && $curDeep > 1) {
        $return .= '<div class="' . $menuClass . $curDeep . '">';
        $setDiv = true;
      }
      else {
        //$return .= '<div class="' . $menuClass . '">';
      }
    }
    
    while($rowNavU = mysql_fetch_array($sqlNavUErg, MYSQL_ASSOC)) {
      $curNavName = $rowNavU['seitName'];
      $curTarget = '';
      
      if (isset($rowNavU['seitNaviTarget']) && !empty($rowNavU['seitNaviTarget'])) {
        $curTarget = ' target="' . $rowNavU['seitNaviTarget'] . '"';
      }
      
      // MM 31.03.2014
      // Für Sprach Ausgabe (Navigations Name)
      // ***********************************************************
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        $curNavName = $this->getCurentLangNavigationName($rowNavU['seitID'], $_POST['VCMS_POST_LANG'], $rowNavU['seitName']);
      }
      // ***********************************************************
      
      $return .= '<div class="menuPoint' . $this->checkIsActiveMenu($rowNavU['seitID'], $rowNavU['seitTextUrl']) . '">';
        
      if (isset($rowNavU['seitArt']) && $rowNavU['seitArt'] == 3) {
        $curLinkUri = '../'.$menuLangVar.$curHack.'/#';
        if (isset($rowNavU['seitNaviLinkSiteID']) && !empty($rowNavU['seitNaviLinkSiteID'])) {
          $curLinkUri = '../'.$menuLangVar.$curHack.'/'.$this->getCurSiteTextUrl($rowNavU['seitNaviLinkSiteID']);
        }
        else if (isset($rowNavU['seitNaviLink']) && !empty($rowNavU['seitNaviLink'])) {
          $curLinkUri = $rowNavU['seitNaviLink'];
        }
        $return .= '<a href="' . $curLinkUri . '"' . $curTarget . '>' . $curNavName . '</a>';
      }
      else {
        $return .= '<a href="../' . $menuLangVar . $curHack .'/'. $rowNavU['seitTextUrl'] . '"' . $curTarget . '>' . $curNavName . '</a>';
      }

      $return .= $this->getCmsUnterMenuUrlHack($rowNavU['seitID'], $menuClass, $curDeep + 1, $curHack);

      $return .= '</div>';
    }
    
    if ($sqlNavUErgCount > 0) {
      $return .= '<div class="clearer"></div>';
      if (isset($setDiv) && $setDiv == true) {
        $return .= '</div>';
      }
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seitenfelder Ausgaben
  // ***************************************************************************
  
  private function buildTheCurSeitenfelderInArray($siteDataArr) {
    $return = array();
    $sqlText = 'SELECT * FROM vfelder WHERE layID = "'.$this->dbDecode($siteDataArr['layID']).'" ORDER BY feldPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['feldArt']) && $row['feldArt'] != 1) {
        $curSiteFeldDataArr = $this->getTheCurSiteFeldDataArrById($row['feldID'], $siteDataArr['seitID']);
        if (isset($curSiteFeldDataArr) && is_array($curSiteFeldDataArr)) {
          $return[$row['feldName']] = $this->getCurentSeitenfeldAusgabeInhalt($row['feldArt'], $curSiteFeldDataArr);
        }
        else {
          $return[$row['feldName']] = '';
        }
      }
    }
    
    return $return;
  }
  
  
  
  private function getTheCurSiteFeldDataArrById($feldId, $siteId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenfelder WHERE feldID = "'.$this->dbDecode($feldId).'" AND seitID = "'.$this->dbDecode($siteId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function getCurentSeitenfeldAusgabeInhalt($curFeldArt, $curSiteFeldDataArr) {
    if (isset($curFeldArt) && $curFeldArt == 7) {
      return $this->buildSeitenfeldBildEinzelAusgabe($curSiteFeldDataArr);
    }
    else if (isset($curFeldArt) && $curFeldArt == 8) {
      return $this->buildSeitenfeldBildMultiAusgabe($curSiteFeldDataArr);
    }
    else if (isset($curFeldArt) && $curFeldArt == 9) {
      return $this->buildSeitenfeldDateiEinzelAusgabe($curSiteFeldDataArr);
    }
    else if (isset($curFeldArt) && $curFeldArt == 10) {
      return $this->buildSeitenfeldDateiMultiAusgabe($curSiteFeldDataArr);
    }
    else {
      return $curSiteFeldDataArr['sfeldInhalt'];
    }
  }
  
  
  
  private function buildSeitenfeldBildEinzelAusgabe($curSiteFeldDataArr) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($curSiteFeldDataArr['sfeldInhalt']).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = array();
      $return['bildFile'] = $row['bildFile'];
      $return['bildTitel'] = $row['bildTitel'];
      $return['bildAlt'] = $row['bildAlt'];
    }
    
    return $return;
  }
  
  
  
  private function buildSeitenfeldBildMultiAusgabe($curSiteFeldDataArr) {
    $return = '';
    $count = 0;
    $curPicIds = str_replace(';', ',', $curSiteFeldDataArr['sfeldInhalt']);
    if (isset($curPicIds) && !empty($curPicIds)) {
      $sqlText = 'SELECT * FROM vbilder WHERE bildID IN ('.$this->dbDecode($curPicIds).')';
      $sqlErg = $this->dbAbfragen($sqlText);

      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($count) && $count < 1) {
          $return = array();
        }
        $return[$count] = array();
        $return[$count]['bildFile'] = $row['bildFile'];
        $return[$count]['bildTitel'] = $row['bildTitel'];
        $return[$count]['bildAlt'] = $row['bildAlt'];
        $count++;
      }
    }
    
    return $return;
  }
  
  
  
  private function buildSeitenfeldDateiEinzelAusgabe($curSiteFeldDataArr) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vdateien WHERE dateiID = "'.$this->dbDecode($curSiteFeldDataArr['sfeldInhalt']).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = array();
      $return['dateiFile'] = $row['dateiFile'];
    }
    
    return $return;
  }
  
  
  
  private function buildSeitenfeldDateiMultiAusgabe($curSiteFeldDataArr) {
    $return = '';
    $count = 0;
    $curDateiIds = str_replace(';', ',', $curSiteFeldDataArr['sfeldInhalt']);
    if (isset($curDateiIds) && !empty($curDateiIds)) {
      $sqlText = 'SELECT * FROM vdateien WHERE dateiID IN ('.$this->dbDecode($curDateiIds).')';
      $sqlErg = $this->dbAbfragen($sqlText);

      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($count) && $count < 1) {
          $return = array();
        }
        $return[$count] = array();
        $return[$count]['dateiFile'] = $row['dateiFile'];
        $count++;
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seitenfelder Ausgaben
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Empfehlungsmanager
  // ***************************************************************************
  
  public function getTheCurrentEmpfehlungsmanagerKontaktForm($empfehlerUrl) {
    if ($this->checkIsEmpfehlerUriExistMM($empfehlerUrl)) {
      $empfehlungsManagerDataArr = $this->getEmpfehlungsmanagerSettingData();
      if (isset($empfehlungsManagerDataArr) && is_array($empfehlungsManagerDataArr)) {
        $siteUrlRe = $this->getSiteTextUrlBySiteIdForEM($empfehlungsManagerDataArr['emKontaktSiteId']);
        if (isset($siteUrlRe) && !empty($siteUrlRe)) {
          $linkClickCount = $this->getEmpfehlerLinkClicksCountByUri($empfehlerUrl);
          if (!isset($linkClickCount) || empty($linkClickCount)) {
            $linkClickCount = 0;
          }
          $linkClickCountDb = $linkClickCount + 1;
          $sqlText = 'UPDATE vempfehler SET empfLinkClicks = "'.$this->dbDecode($linkClickCountDb).'" WHERE empfUrl = "'.$this->dbDecode($empfehlerUrl).'"';
          $this->dbAbfragen($sqlText);
          
          $_SESSION['VCMS_EMPFEHLER_URL_SET_ON_CMS_TO_KONTAKT'] = $empfehlerUrl;
          header('Location: '.$siteUrlRe.'?empfehlerUri='.$empfehlerUrl);
          exit();
          //$_GET['page_name'] = 'service';
        }
        else {
          header('Location: /');
          exit();
        }
      }
      else {
        header('Location: /');
        exit();
      }
    }
    else {
      header('Location: /');
      exit();
    }
  }
  
  
  
  private function checkIsEmpfehlerUriExistMM($empfehlerUrl) {
    $sqlText = 'SELECT empfID FROM vempfehler WHERE empfUrl = "'.$this->dbDecode($empfehlerUrl).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if (isset($sqlErgCount) && $sqlErgCount > 0) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function getEmpfehlungsmanagerSettingData() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function getSiteTextUrlBySiteIdForEM($curSiteID) {
    $return = '';
    
    $sqlText = 'SELECT seitTextUrl FROM vseiten WHERE seitID = "'.$this->dbDecode($curSiteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['seitTextUrl'];
    }
    
    return $return;
  }
  
  
  
  private function getEmpfehlerLinkClicksCountByUri($empfehlerUrl) {
    $return = '';
    
    $sqlText = 'SELECT empfLinkClicks FROM vempfehler WHERE empfUrl = "'.$this->dbDecode($empfehlerUrl).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['empfLinkClicks'];
    }
    
    return $return;
  }

  
  
  
  public function getAllEmpfehlungsmanagerAllgemeinData() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vempfehlungsmanager WHERE emID = 1 LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  public function getTheSocialSharePicUrlByPicId($curPicId) {
    $return = '';
    
    if (isset($curPicId) && !empty($curPicId)) {
      $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($curPicId).'" LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $return = $this->getHrefPathOnlyEmpfehlerPicAusgabe().'/user_upload/'.$row['bildFile'];
      }
    }
    
    return $return;
  }
  
  
  
  private function getHrefPathOnlyEmpfehlerPicAusgabe() {
    $basePath = str_replace('index.php', '', $_SERVER['SERVER_NAME']);
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }

    return $setBaseHTTP.$basePath;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Empfehlungsmanager
  // ***************************************************************************
  
  
  ////////////////og: element////////////////////////////////////////
  
  public function getSiteOgByElements($idSite,$title,$description,$banners=null){
      
      if($banners !=''){
          require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/timeClass.inc.php');
          $time           = new timeClass();
          
          $idImagesArr = explode(';',$banners);
         
              foreach($idImagesArr as $key => $value){
                  if($time->checkTimeBanner($value)){
                      $query = mysql_query("SELECT * FROM vbilder WHERE bildID='$value'");
                      $row   = mysql_fetch_array($query);
                      $image = $row['bildFile']; 
                      break;
                    }
              }
        
          
      }else{
          
            $query = mysql_query("SELECT selemConfig,selemPicGal FROM vseitenelemente  WHERE (selemConfig!='' OR selemPicGal!='') AND seitID='$idSite' LIMIT 1");
            $row   = mysql_fetch_array($query);

            if($row['selemPicGal'] != ''){
               $idGalleryArr = explode(';',$row['selemPicGal']);
               $id = $idGalleryArr['0'];
               if(!empty($id)){
                   $query = mysql_query("SELECT * FROM vbildergalerien WHERE galID = '$id'");
                   $row = mysql_fetch_array($query);

                   $idImageArr = explode(';',$row['galBilder']);
                   $idImage = $idImageArr[0];

                   if(!empty($idImage)){
                       $query = mysql_query("SELECT * FROM vbilder WHERE bildID='$idImage'");
                       $row   = mysql_fetch_array($query);
                       $image = $row['bildFile'];
                   }

               }

            }elseif($row['selemConfig'] != ''){

                $confArr = json_decode($row['selemConfig']);
                $idImagesArr = explode(';',$confArr->picGal);

                 $idImage = $idImageArr[0];

                   if(!empty($idImage)){
                       $query = mysql_query("SELECT * FROM vbilder WHERE bildID='$idImage'");
                       $row   = mysql_fetch_array($query);
                       $image = $row['bildFile'];
                   }
            }
          
          
      }
      
      
      
      
      $og.='<meta property="fb:app_id" content="1637297743197707" />';
      $og.='<meta property="og:url" content="'.SITE_URL.$_SERVER['REQUEST_URI'].'" />';
      if($image != ''){
          $og.='<meta property="og:image" content="'.SITE_URL.'user_upload/'.$image.'" />';
      }
      if($title != ''){
         $og.='<meta property="og:title" content="'.$title.'" />';  
      }
      if($description != ''){
         $og.='<meta property="og:description" content="'.$description.'" />';  
      }
      
      return $og;
       
      
  }
  
  
    ///////////language menu////////////////
  
  
      public function buildLanguageMenu($idSite){
           
            $query = mysql_query("SELECT * FROM vsprachen WHERE langAktiv=1");
            $langString = '';
            while($row = mysql_fetch_array($query)){
               $idLang = $row['langID'];
                $query1 = mysql_query("SELECT * FROM `vseitelang` WHERE seitID='$idSite' AND langID='$idLang'");
                if(mysql_num_rows($query1)>0){
                    
                    $row1 = mysql_fetch_array($query1);
                    $langString.='<li><a href="/'.$row['langKurzName'].'/'.$row1['seitlaTextUrl'].'">'.$row['langName'].'</a></li>';
                }else{
                    $query1 = mysql_query("SELECT * FROM `vseiten` WHERE seitID='$idSite'");
                     $row1 = mysql_fetch_array($query1);
                     $langString.='<li><a href="/'.$row['langKurzName'].'/'.$row1['seitTextUrl'].'">'.$row['langName'].'</a></li>';
                }

            } 
            
            
            return $langString;
            
        } 
  
  
}

?>