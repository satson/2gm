<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/

// Österreichische Zeitzone definieren
date_default_timezone_set('Europe/Vienna'); 

 


//die('-');
if($_SERVER['HTTPS'] == 'on'){
  define('SITE_URL','https://wildkogel-arena.at/');  
}else{
   if(empty($_SESSION['VCMS_USER_ID'])){
     header("HTTP/1.1 301 Moved Permanently");
  header("Location: https://wildkogel-arena.at/");
   exit();  
   } 
    
   
   define('SITE_URL','http://wildkogel-arena.at/'); 
    
}


define ('HTTPS_URL','//wildkogel-arena.at/');

define('SITE_PATH','/home/icdigyfv/htdocs/');

// User Logout
if (isset($_GET['page_name']) && $_GET['page_name'] == 'Logout') {
  unset($_SESSION['VCMS_USER_ID']);
  unset($_SESSION['VCMS_USER_NAME']);
  unset($_SESSION['VCMS_HP_ID']);
  unset($_SESSION['VCMS_USER_RECHT']);
  unset($_SESSION['VCMS_USER_RECHT_ARRAY']);
  unset($_SESSION['VCMS_ELEM_COPY_ID']);
  
  header('Location: /');
  exit();
}


// Datenbank Connection File einbinden
// *******************************************************
require_once('inc/db_connect.inc.php');



// Allgemeine CMS Funktionen Klasse einbinden
// *******************************************************
require_once('inc/functionsAll.inc.php');




// Sprachen überprüfung und Variablen setzen
// *****************************************************************************
$curCmsSetLang = '';

//print_r($_SERVER);

$segments = explode('/',$_SERVER['REDIRECT_URL']);

 $segments = array_filter($segments);
  

 
if($_GET['_lang'] !='' && count($segments)==1){
  unset($_SESSION['basket']);  
}
if(empty($_SESSION['VCMS_USER_ID']) && empty($_GET['_lang']) && count($segments)>1){
    header("HTTP/1.1 301 Moved Permanently");
    header('location:'.SITE_URL.'de');
    exit();     
 }

 
if (isset($_GET['_lang']) && !empty($_GET['_lang'])) {
  $langCheckDbObj = new funktionsSammlung();
  $sqlLangCheckText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $langCheckDbObj->dbDecode($_GET['_lang']) . '" AND langAktiv = 1 AND langStandard = 2 LIMIT 1';
  $sqlLangCheckErg = $langCheckDbObj->dbAbfragen($sqlLangCheckText);
  $sqlLangCheckNum = mysql_num_rows($sqlLangCheckErg);
  if ($sqlLangCheckNum == 0) {
    if (isset($_GET['page_name']) && !empty($_GET['page_name'])) {
      header('Location: /'.$_GET['page_name']);
      exit();
    }
    header('Location: /');
    exit();
  }
  
  $_POST['VCMS_POST_LANG'] = $_GET['_lang'];
  $curCmsSetLang = $_GET['_lang'];
}else{
    
     if(empty($_SESSION['VCMS_USER_ID'])){
           $_GET['_lang'] = 'de';
        }else{
            
        }
  // $_POST['VCMS_POST_LANG'] = 'de';
}




require_once '/home/icdigyfv/htdocs/lang/de.php';
$langObj = new funktionsSammlung();
$langObj->langSite = $langSite ;

$curLangToMetaSet = 'de';
if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
  $curLangToMetaSet = $_POST['VCMS_POST_LANG'];
}
// *****************************************************************************



 
// Homepage ID setzen
// *******************************************************
define('VCMS_HOMEPAGE_ID', 1);


// CMS HP Funktionen Klasse einbinden
// *******************************************************
require_once('inc/hp_functions.inc.php');
$cmsHpObj = new hpFunctions();

// CMS Homepage Daten Array
// *******************************************************
$hpCms = $cmsHpObj->getHpDataArray();


// Temlpate Pfad setzen
// *******************************************************
define('VCMS_ABS_PATH_TEMPLATE', 'templates/' . $hpCms['hp_Template'] . '/');
$_SESSION['VCMS_CUR_ABS_PATH_TEMPLATE'] = VCMS_ABS_PATH_TEMPLATE;



// Check Funktionen einbinden
// *******************************************************
require_once('inc/check.inc.php');



// Mobile Detect Klasse einbinden und Deklarieren
// *******************************************************
require_once('inc/mobile_detect.inc.php');
$mobileDetect = new Mobile_Detect();

// Mobile und Tablet abfragen
// *******************************************************
$isMobileCheck = false;
$isTabletCheck = false;
if ((isset($mobileDetect) && $mobileDetect->isMobile() && !$mobileDetect->isTablet()) || (isset($_GET['showMobileDev']) && $_GET['showMobileDev'] == 'ok')) {
  $isMobileCheck = true;
}
if ((isset($mobileDetect) && $mobileDetect->isTablet()) || (isset($_GET['showTabletDev']) && $_GET['showTabletDev'] == 'ok')) {
  $isTabletCheck = true;
}


// CMS Funktionen Klasse einbinden
// *******************************************************
require_once('admin/inc/klassen/elemente_self.inc.php');
require_once('inc/cms_functions.inc.php');
$cmsObj = new cmsFunctions();

// Für Empfehlungsmanger Url
// *******************************************************
if ($cmsObj->checkIsThisModuleActive('empfehlungManagerModul')) {
  if (isset($_GET['empfehler_url']) && !empty($_GET['empfehler_url']) && $_GET['empfehler_url'] != 'index.php') {
    $cmsObj->getTheCurrentEmpfehlungsmanagerKontaktForm($_GET['empfehler_url']);
  }
}

// CMS Seiten Daten Array
// *******************************************************
$cms = $cmsObj->getCmsSiteDataArray();


//$_SESSION['VCMS_CUR_SITE_ID_MM'] = $cms['cms_siteID'];


// Klasse für Zentrale Elemente JS und CSS Datei
// *****************************************************************************
// --------------------------------------------------------------------
// Pfad muss in folgenden Dateien geändert werden:
// --------------------------------------------------------------------
// admin/inc/klassen/hp_settings.inc.php  ($curentElementsPath)
// admin/inc/klassen/elemente_self.inc.php  ($curCentralElementsPath)
// index.php  ($curCentralElementsPathIndex)
// --------------------------------------------------------------------
//$curCentralElementsPathIndex = '/var/www/vhosts/default/htdocs/cmsCentralElems/';
$curCentralElementsPathIndex = '/home/xyganvvx/cmsCentralElems/';

require_once('admin/inc/klassen/centralElementsCssJs.inc.php');
$cmsCentralElemsJsCssObj = new cmsCentralElementsCssJs();
// *****************************************************************************



// Für Seo Import Ausgaben
// *****************************************************************************
if (isset($_GET['isCmsSeoImportTitle']) && $_GET['isCmsSeoImportTitle'] == 'aZgh67FTTja') {
  echo getTheCurentSiteMetaTitleCMS();
  exit();
}
if (isset($_GET['isCmsSeoImportDesc']) && $_GET['isCmsSeoImportDesc'] == 'rQfk14LRTzu') {
  include_once(VCMS_ABS_PATH_TEMPLATE . 'index.inc.php');
  exit();
}
// *****************************************************************************


?><!DOCTYPE html>
<html>
  <head>
      <?php if($_SERVER['HTTPS'] == 'on'){ ?>
      
    <base href="https://www.wildkogel-arena.at/"> 
      <?php }else{ ?>
          
         <base href="<?php echo getHrefPath(); ?>">  
          
    <?php  } ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="google-site-verification" content="_fe0jdUSu2k2BQTsyIqxXDbHNEJldsrQiEUzwRXVSCo" />
    <meta http-equiv="content-language" content="<?php echo $curLangToMetaSet; ?>" />
    <?php
    // Meta Title, Description und Keywords setzen (mit Sprachabfrage)
    // *************************************************************************
    echo '<title>'.getTheCurentSiteMetaTitleCMS().'</title>';
    
    
    if ((isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) && 
        (isset($cms['cms_langArr']['cms_siteMetaDesc']) && !empty($cms['cms_langArr']['cms_siteMetaDesc']))) {
      echo '<meta name="description" lang="' . $_POST['VCMS_POST_LANG'] . '" content="' . $cms['cms_langArr']['cms_siteMetaDesc'] . '" />';
    }
    else if (isset($cms['cms_siteMetaDesc']) && !empty($cms['cms_siteMetaDesc'])) {
      echo '<meta name="description" lang="de" content="' . $cms['cms_siteMetaDesc'] . '" />';
    }
    
    if ((isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) && 
        (isset($cms['cms_langArr']['cms_siteMetaKeywords']) && !empty($cms['cms_langArr']['cms_siteMetaKeywords']))) {
      echo '
    <meta name="keywords" lang="' . $_POST['VCMS_POST_LANG'] . '" content="' . $cms['cms_langArr']['cms_siteMetaKeywords'] . '" />';
    }
    else if (isset($cms['cms_siteMetaKeywords']) && !empty($cms['cms_siteMetaKeywords'])) {
      echo '
    <meta name="keywords" lang="de" content="' . $cms['cms_siteMetaKeywords'] . '" />';
    }
    // *************************************************************************
    
    
    
    // Index oder NoIndex Google (mit Sprachabfrage)
    // *************************************************************************
    $curMetaSiteNoIndexVar = '<meta name="robots" content="index, follow" />';
    
    if (isset($cms['cms_siteNoIndex']) && $cms['cms_siteNoIndex'] == 2) {
      $curMetaSiteNoIndexVar = '<meta name="robots" content="noindex" />';
    }
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($cms['cms_langArr']['cms_siteNoIndex']) && $cms['cms_langArr']['cms_siteNoIndex'] == 2) {
        $curMetaSiteNoIndexVar = '<meta name="robots" content="noindex" />';
      }
      /*else if (isset($cms['cms_langArr']['cms_siteNoIndex']) && $cms['cms_langArr']['cms_siteNoIndex'] == 1) {
        $curMetaSiteNoIndexVar = '<meta name="robots" content="index, follow" />';
      }*/
    }
    
    echo '
    '.$curMetaSiteNoIndexVar;
    // *************************************************************************
    
    
    
    // Empfehlungsmanager Post Social Metas setzen
    // *************************************************************************
    if ($cmsObj->checkIsThisModuleActive('empfehlungManagerModul')) {
      $allEmpfMaAllgemeinData = $cmsObj->getAllEmpfehlungsmanagerAllgemeinData();
      if ($cms['cms_siteID'] == $allEmpfMaAllgemeinData['emKontaktSiteId']) {
        echo '
        <meta property="og:title" content="'.$allEmpfMaAllgemeinData['emFbShareSmallDesc'].'" />';
        echo '
        <meta property="og:description" content="'.$allEmpfMaAllgemeinData['emFbShareDesc'].'" />';
        $curSocialShPicUrl = $cmsObj->getTheSocialSharePicUrlByPicId($allEmpfMaAllgemeinData['emFbShareBild']);
        echo '
        <meta property="og:image" content="'.$curSocialShPicUrl.'" />';
      }
    }
    // *************************************************************************
   
    
    //print_r($cms);
    
   echo  $cmsObj->getSiteOgByElements($cms['cms_siteID'], $cms['cms_siteMetaTitle'], $cms['cms_siteMetaDesc'],$cms['cms_siteBackImages']);
    
    
    
    
    // Canonical Url Google (mit Sprachabfrage)
    // *************************************************************************
    $curMetaSiteCanonicalVar = '';
    
    if (isset($cms['cms_siteCanonical']) && !empty($cms['cms_siteCanonical'])) {
      $curMetaSiteCanonicalVar = '<link rel="canonical" href="'.$cms['cms_siteCanonical'].'" />';
    }
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($cms['cms_langArr']['cms_siteCanonical']) && !empty($cms['cms_langArr']['cms_siteCanonical'])) {
        $curMetaSiteCanonicalVar = '<link rel="canonical" href="'.$cms['cms_langArr']['cms_siteCanonical'].'" />';
      }
    }
    
    if (isset($curMetaSiteCanonicalVar) && !empty($curMetaSiteCanonicalVar)) {
    echo '
    '.$curMetaSiteCanonicalVar;
    }
    // *************************************************************************
    
    
    ?>
    
    <?php
    // Wenn Mobile, jQuery Mobile CSS File einbinden
    if (isset($isMobileCheck) && $isMobileCheck == true && !$cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<link rel="stylesheet" href="'.SITE_URL.'plugins/jquery_mobile/jquery_mobile.min.css" type="text/css" />';
    }
    // Font Awesome
    if ($cmsObj->checkIsThisModuleActive('responsivWebModul') || checkIsUserLogedIn()) {
      echo '<link rel="stylesheet" href="'.SITE_URL.'plugins/font-awesome/css/font-awesome.min.css" type="text/css" />';
    }
    // Responsiv Webseiten
    if ($cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<link rel="stylesheet" href="'.SITE_URL.'plugins/bootstrap/css/bootstrap.min.css" type="text/css" />';
      echo '<link rel="stylesheet" href="'.SITE_URL.'plugins/bootstrap/css/bootstrap-theme.min.css" type="text/css" />';
    }
    ?>
    
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>socialshareprivacy/socialshareprivacy.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/default.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/defaultShop.css" type="text/css" />
    
    <link rel="alternate" href="https://wildkogel-arena.at/de" hreflang="de" />
    <link rel="alternate" href="https://wildkogel-arena.at/en" hreflang="en" />
   
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>templates/wildkogel/img/favicon.png">
    
    <?php
    
    // Zentrale Elemente Css File Ausgabe
    // *************************************************************************
    echo $cmsCentralElemsJsCssObj->buildOwnCentralElemsCssFile($curCentralElementsPathIndex);
    
    
    if (isset($isMobileCheck) && $isMobileCheck == true && !$cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<link rel="stylesheet" href="'.SITE_URL.'css/default_mobile.css" type="text/css" />';
      echo '<link rel="stylesheet" href="'.SITE_URL.'css/defaultShop_mobile.css" type="text/css" />';
      echo '<link rel="stylesheet" href="'.SITE_URL.'' .VCMS_ABS_PATH_TEMPLATE. 'css/mobile.css" type="text/css" />';
    }
    else {
      if (file_exists(VCMS_ABS_PATH_TEMPLATE.'css/tablet.css') && isset($isTabletCheck) && $isTabletCheck == true) {
        echo '<link rel="stylesheet" href="' .SITE_URL.VCMS_ABS_PATH_TEMPLATE. 'css/tablet.css" type="text/css" />';
      }
      echo '<link rel="stylesheet" href="'.VCMS_ABS_PATH_TEMPLATE. 'css/style.css" type="text/css" />';
    }
    ?>
    
    <?php
    if (checkIsUserLogedIn()) {
      echo '<link rel="stylesheet" href="admin/frontAdmin/css/front.css" type="text/css" />';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        echo '<link rel="stylesheet" href="'.SITE_URL.'admin/frontAdmin/css/frontLang.css" type="text/css" />';
      }
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
        echo '<link rel="stylesheet" href="'.SITE_URL.'admin/frontAdmin/css/frontUser.css" type="text/css" />';
      }
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3 && !checkIndividualUserRechtChange()) {
        echo '<link rel="stylesheet" href="'.SITE_URL.'admin/frontAdmin/css/frontNoChange.css" type="text/css" />';
      }
    }
    if ((!isset($isMobileCheck) || $isMobileCheck == false) || $cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<link rel="stylesheet" href="'.SITE_URL.'plugins/jquery_ui/jquery_ui.css" type="text/css" />';
    }
    ?>
    <link rel="stylesheet" href="<?php echo SITE_URL?>plugins/fancybox/fancybox.css" type="text/css" />
    
    <?php
    // Bei Browser Firefox und Mobile alte jQuery Version 1.8.3 einbinden
    // Bei allen anderen Browsern neuere Version einbinden
    // *************************************************************************
    /*if ((isset($_SERVER["HTTP_USER_AGENT"]) && strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox')) || $isMobileCheck == true || $isTabletCheck == true) {
      echo '<script type="text/javascript" src="plugins/jquery.js"></script>';
    }
    else {*/
      echo '<script type="text/javascript" src="'.SITE_URL.'plugins/jquery.js"></script>';
    //}
    // *************************************************************************
    ?>
    
    <?php
    // Wenn Mobile jQuery Mobile JavaScript File einbinden und AJAX deaktivieren
    if (isset($isMobileCheck) && $isMobileCheck == true && !$cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      if (defined('VCMS_NO_SET_MOBILE_VIEWBOARD_SYS')) {
        
      }
      else {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />';
      }
      echo '<script type="text/javascript">
        $(document).bind("mobileinit", function () {
          $.mobile.ajaxEnabled = false;
          $.mobile.allowCrossDomainPages = true;
          $.support.cors = true;
          $.mobile.hashListeningEnabled = false;
          $.mobile.pushStateEnabled = false;
          $.mobile.changePage.defaults.changeHash = false;
        });
      </script>';
      echo '<script type="text/javascript" src="plugins/jquery_mobile/jquery_mobile.min.js"></script>';
    }
    if ($cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    }
    
    
    if (isset($hpCms['hp_HeaderZusatz']) && !empty($hpCms['hp_HeaderZusatz'])) {
      echo $hpCms['hp_HeaderZusatz'];
    }
    
    
    if (checkIsUserLogedIn()) {
      echo '<script type="text/javascript">';
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        if (isset($hpCms['hp_langArr']['hp_metaTitle']) && !empty($hpCms['hp_langArr']['hp_metaTitle'])) {
          echo 'var vcmsIsAllgemeinSetHpMetaTitleOkMM = "yes";';
        }
        else {
          echo 'var vcmsIsAllgemeinSetHpMetaTitleOkMM = "no"';
        }
      }
      else {
        if (isset($hpCms['hp_metaTitle']) && !empty($hpCms['hp_metaTitle'])) {
          echo 'var vcmsIsAllgemeinSetHpMetaTitleOkMM = "yes";';
        }
        else {
          echo 'var vcmsIsAllgemeinSetHpMetaTitleOkMM = "no";';
        }
      }
      echo '</script>';
    }
    ?>
	
	<script>
var _gaq=[
	['_setAccount', 'UA-36470509-4'],['_trackPageview'],['_trackPageLoadTime'],
	['secondTracker._setAccount', 'UA-36470509-1'],
        ['secondTracker._trackPageview'],
        ['secondTracker._trackPageLoadTime']
];
(function(d, t) {
     var g = d.createElement(t),
         s = d.getElementsByTagName(t)[0];
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
}(document, 'script'));
</script>


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NVKFHS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NVKFHS');</script>
<!-- End Google Tag Manager -->


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KQ6XD5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KQ6XD5');</script>
<!-- End Google Tag Manager -->

<script type="text/javascript">
var $mcGoal = {'settings':{'uuid':'b6414a30e27f891fafc7259b1','dc':'us12'}};
(function() {
var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
})(); 
</script>
    
  </head>
  
  <?php
  if (checkIsUserLogedIn()) {
    echo '<body class="vcmsUserLogedIn" data-lang="' . $curCmsSetLang . '" data-sid="'.$cms['cms_siteID'].'" data-https="'.$_SERVER['HTTPS'].'">';
  }
  else {
    echo '<body data-lang="' . $curCmsSetLang . '" data-sid="'.$cms['cms_siteID'].'" data-https="'.$_SERVER['HTTPS'].'">';
}
  ?>

  

    <?php
    if (checkIsUserLogedIn()) {
      include_once('admin/frontAdmin/front.inc.php');
    }
      
     
    
    if (isset($hpCms['hp_Online']) && $hpCms['hp_Online'] == 1) {
      ob_start();
      if (isset($isMobileCheck) && $isMobileCheck == true && !$cmsObj->checkIsThisModuleActive('responsivWebModul')) {
        include_once(VCMS_ABS_PATH_TEMPLATE . 'mobile.inc.php');
      }
      else {
        include_once(VCMS_ABS_PATH_TEMPLATE . 'index.inc.php');
      }
      $curSiteInhaltVar = ob_get_contents();
      ob_end_clean();
      
      // HTML Link Parse
      // ***********************************************************************
      require_once('admin/inc/klassen/linkParse.inc.php');
      $linkParseObj = new cmsLinkParse();
      echo $linkParseObj->parseInTextLinking($curSiteInhaltVar);
      // ***********************************************************************



      // Hintergrund Bilder JS ausgeben
      // *************************************************************************
      echo $cmsObj->getCMSBackgroundImageJsNow($cms, $hpCms);
      // *************************************************************************
    }
    else {
      // Webseite Offline ausgabe
      // ***********************************************************************
      echo '<div style="margin-top:200px; font-size:30px; text-align:center;">Die Webseite ist Offline!</div>';
    }
    ?>
  
  
    
    <?php
    // Zentrale Elemente Js File Ausgabe
    // *************************************************************************
    echo $cmsCentralElemsJsCssObj->buildOwnCentralElemsJsFile($curCentralElementsPathIndex);
    
    
    if ((!isset($isMobileCheck) || $isMobileCheck == false) || $cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<script type="text/javascript" src="'.SITE_URL.'plugins/jquery_ui/jquery_ui.js"></script>';
       echo   '<link rel="stylesheet" href="'.SITE_URL.'plugins/datetimepicker/datatimepicker.css" type="text/css" />';
     echo   '<script type="text/javascript" src="'.SITE_URL.'plugins/datetimepicker/jquery.datetimepicker.js"></script>';
    }
    if ($cmsObj->checkIsThisModuleActive('responsivWebModul')) {
      echo '<script type="text/javascript" src="'.SITE_URL.'plugins/bootstrap/js/bootstrap.min.js"></script>';
    }
    ?>
 <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    <script type="text/javascript" src="<?php echo SITE_URL ?>plugins/jquery_cycle.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL ?>plugins/fancybox/jquery_fancybox.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL ?>plugins/swipe.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL ?>plugins/back.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL ?>js/default.js"></script>
    
  </body>
</html>