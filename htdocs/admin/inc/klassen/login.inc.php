<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


class cmsLogin extends funktionsSammlung {
  
  public function checkUserLoginData($logUser, $logPass) {
    if (isset($logUser) && !empty($logUser) 
        && isset($logPass) && !empty($logPass)) {
      $sqlLoginText = 'SELECT * FROM vuser WHERE userName = "' . $this->dbDecode($logUser) . '" AND userOnline = 1 AND userDel = 1 LIMIT 1';
      $sqlLoginErg = $this->dbAbfragen($sqlLoginText);
      
      while($rowLog = mysql_fetch_array($sqlLoginErg, MYSQL_ASSOC)) {
        if ($rowLog['userPass'] == sha1($logPass)) {
          $_SESSION['VCMS_USER_ID'] = $rowLog['userID'];
          $_SESSION['VCMS_USER_NAME'] = $rowLog['userName'];
          $_SESSION['VCMS_HP_ID'] = $rowLog['hpID'];
          $_SESSION['VCMS_USER_RECHT'] = $rowLog['userRechte'];
          
          if (isset($rowLog['userRechte']) && $rowLog['userRechte'] == 3) {
            if (isset($rowLog['userRechtJSON']) && !empty($rowLog['userRechtJSON'])) {
              $_SESSION['VCMS_USER_RECHT_ARRAY'] = array();
              $_SESSION['VCMS_USER_RECHT_ARRAY'] = json_decode($rowLog['userRechtJSON'], true);
            }
          }
          
          return true;
        }
      }
    }
    else {
      return false;
    }
    
    return false;
  }
  
}

?>