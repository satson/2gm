<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


function checkIsUserLogedIn() {
  if (isset($_SESSION['VCMS_USER_ID']) && !empty($_SESSION['VCMS_USER_ID']) 
      && isset($_SESSION['VCMS_USER_NAME']) && !empty($_SESSION['VCMS_USER_NAME'])
      && isset($_SESSION['VCMS_HP_ID']) && !empty($_SESSION['VCMS_HP_ID'])) {
    return true;
  }
  return false;
}



function getHrefPath() {
  $basePath = str_replace('index.php', '', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
  if (stripos($basePath, 'http://') !== false) {
    $setBaseHTTP = '';
  }
  else {
    $setBaseHTTP = 'http://';
  }

  return $setBaseHTTP.$basePath;
}



function checkValitMail($adress) {
  if (preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/i', $adress)) {
    return true;
  }
  else {
    return false;
  }
}


// Funktionen zum überprüfen von erlaubten Seiten vom Individual User
// *****************************************************************************

function checkIndividualUserRechtChange() {
  if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
    if (isset($_SESSION['VCMS_USER_RECHT_ARRAY']['sites']) && !empty($_SESSION['VCMS_USER_RECHT_ARRAY']['sites'])) {
      if (isset($_SESSION['VCMS_CUR_CMS_SITE_SESSION']) && !empty($_SESSION['VCMS_CUR_CMS_SITE_SESSION'])) {
        $curUserRechtsArr = explode(';', $_SESSION['VCMS_USER_RECHT_ARRAY']['sites']);
        foreach ($curUserRechtsArr as $value) {
          if ($_SESSION['VCMS_CUR_CMS_SITE_SESSION'] == $value) {
            return true;
          }
        }
        return false;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }
  
  return true;
}

// *****************************************************************************






function getTheCurentSiteMetaTitleCMS() {
  global $cms;
  global $hpCms;

  if (isset($cms['cms_siteNartID']) && $cms['cms_siteNartID'] > 1) {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($cms['cms_langArr']['cms_siteMetaTitle']) && !empty($cms['cms_langArr']['cms_siteMetaTitle'])) {
        return $cms['cms_langArr']['cms_siteMetaTitle'];
      }
      else if (isset($cms['cms_langArr']['cms_siteName']) && !empty($cms['cms_langArr']['cms_siteName'])) {
        return $cms['cms_langArr']['cms_siteName'];
      }
      else {
        return $cms['cms_siteName'];
      }
    }
    else {
      if (isset($cms['cms_siteMetaTitle']) && !empty($cms['cms_siteMetaTitle'])) {
        return $cms['cms_siteMetaTitle'];
      }
      else {
        return $cms['cms_siteName'];
      }
    }
  }
  else {
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      if (isset($cms['cms_langArr']['cms_siteMetaTitle']) && !empty($cms['cms_langArr']['cms_siteMetaTitle'])) {
        return $cms['cms_langArr']['cms_siteMetaTitle'];
      }
      else if (isset($hpCms['hp_langArr']['hp_metaTitle']) && !empty($hpCms['hp_langArr']['hp_metaTitle'])) {
        if (isset($cms['cms_langArr']['cms_siteName']) && !empty($cms['cms_langArr']['cms_siteName'])) {
          return $hpCms['hp_langArr']['hp_metaTitle'] . ' | ' . $cms['cms_langArr']['cms_siteName'];
        }
        else {
          return $hpCms['hp_langArr']['hp_metaTitle'] . ' | ' . $cms['cms_siteName'];
        }
      }
      else {
        return $cms['cms_siteMetaTitle'];
      }
    }
    else if (isset($hpCms['hp_metaTitle']) && !empty($hpCms['hp_metaTitle']) && empty($cms['cms_siteMetaTitle'])) {
      return $hpCms['hp_metaTitle'] . ' | ' . $cms['cms_siteName'];
    }
    else if (isset($cms['cms_siteMetaTitle']) && !empty($cms['cms_siteMetaTitle'])) {
      return $cms['cms_siteMetaTitle'];
    }
    else {
      return $cms['cms_siteName'];
    }
  }
}

?>