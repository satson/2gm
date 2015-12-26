<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


class cmsCmsInfos extends funktionsSammlung {
  
  public function showCmsInfosWindowNow() {
    $return = '<div class="vFrontCmsInfosInWindowHolder">';
    
    $return .= '<div style="height:70px;"></div>';
    
    $return .= '<div class="vFrontCmsInfosInWindowLabel">Entwickler:</div>';
    $return .= '<div class="vFrontCmsInfosInWindowText">2getmore Onlinemarketing</div>';
    $return .= '<div class="vFrontCmsInfosInWindowAbstand clearer"></div>';
    
    $return .= '<div class="vFrontCmsInfosInWindowLabel">CMS Version:</div>';
    $return .= '<div class="vFrontCmsInfosInWindowText vFrontCmsInfosInWindowTextUpdate">'.CMS_CUR_VERSION.'</div>';
    
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 1) {
      $return .= '<div class="vFrontCmsInfosInWindowTextUpdateBtn" data-version="'.CMS_CUR_VERSION.'">Update prüfen</div>';
    }
    
    $return .= '<div class="vFrontCmsInfosInWindowAbstand clearer" style="height:30px;"></div>';
    
    $return .= '<div class="vFrontCmsInfosInWindowTextUpdateInfoPos"></div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  
  
  
  
  public function checkCmsInfoIsNewUpdateVersionNow() {
    $curVersionStringUsbZw = trim(file_get_contents('http://changelog.usebox24.com?getCurVersionNow=ok'));
    $curVersionStringUsb = str_replace('.', '', $curVersionStringUsbZw);
    $curVersionStringCms = str_replace('.', '', CMS_CUR_VERSION);
    
    if ($curVersionStringUsb > $curVersionStringCms) {
      return '<div class="vFrontCmsInfosInWindowTextUpdateInfoNoUpdate">Neue CMS Version verfügbar: '.$curVersionStringUsbZw.'</div><a id="vFrontCmsInfosInWindowUpdateCenterBtn" href="cmsUpdate/update" target="_blank">Zum Update Center</a>';
    }
    else {
      return '<div class="vFrontCmsInfosInWindowTextUpdateInfoNoUpdate">Ihr CMS ist aktuell.</div>';
    }
  }
  
}

?>