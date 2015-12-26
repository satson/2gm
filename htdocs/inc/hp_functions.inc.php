<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class hpFunctions extends funktionsSammlung {
  
  public function getHpDataArray() {
    $return = array();
    
    $sqlHpText = 'SELECT * FROM vhomepage WHERE hpID = ' . $this->dbDecode(VCMS_HOMEPAGE_ID) . ' LIMIT 1';
    $sqlHpErg = $this->dbAbfragen($sqlHpText);
    
    while ($rowHp = mysql_fetch_array($sqlHpErg, MYSQL_ASSOC)) {
      $return['hp_ID'] = $rowHp['hpID'];
      $return['hp_Name'] = $rowHp['hpName'];
      $return['hp_Template'] = $rowHp['hpTemplate'];
      $return['hp_Online'] = $rowHp['hpOnline'];
      $return['hp_HeaderZusatz'] = $rowHp['hpHeaderZusatz'];
      $return['hp_FooterZusatz'] = $rowHp['hpFooterZusatz'];
      $return['hp_SeitStart'] = $rowHp['hpSeitStart'];
      $return['hp_ModulShopAktiv'] = $rowHp['hpShopAktiv'];
      $return['hp_metaTitle'] = $rowHp['hpMetaTitle'];
      $return['hp_metaKeywords'] = $rowHp['hpMetaKeywords'];
      $return['hp_metaDesc'] = $rowHp['hpMetaDesc'];
    }
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLangId = $this->getCurentLangIdFromUrlName($_POST['VCMS_POST_LANG']);
      $sqlDataLText = 'SELECT * FROM vhomepagelang WHERE langID = ' . $this->dbDecode($curLangId) . ' AND hpID = ' . $this->dbDecode(VCMS_HOMEPAGE_ID) . ' LIMIT 1';
      $sqlDataLErg = $this->dbAbfragen($sqlDataLText);

      while ($rowDataL = mysql_fetch_array($sqlDataLErg, MYSQL_ASSOC)) {
        $return['hp_langArr'] = array();
        $return['hp_langArr']['hp_metaTitle'] = $rowDataL['hplaMetaTitle'];
        $return['hp_langArr']['hp_metaKeywords'] = $rowDataL['hplaMetaKeywords'];
        $return['hp_langArr']['hp_metaDesc'] = $rowDataL['hplaMetaDesc'];
      }
    }
    
    return $return;
  }
  
  
  
  private function getCurentLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
}

?>