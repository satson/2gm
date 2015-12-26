<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class seitenEigenschaften extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiteneigenschaften - Allgemein
  // ***************************************************************************
  
  public function getSiteSettingsNow($siteID) {
    $return = $this->getSiteSettingsMenu($siteID);
    $return .= $this->getSiteSettingInhalt($siteID);
    
    return $return;
  }
  
  
  
  public function getSiteSettingsMenu($siteID) {
    $return = '<div class="vFrontSiteSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontSiteSettingMenuPoint vFrontActiveSiteS" id="vFrontSiteSeBilder" data-id="' . $siteID . '">Bilder</div>';
    $return .= '<div class="vFrontSiteSettingMenuPoint" id="vFrontSiteSeFelder" data-id="' . $siteID . '">Felder</div>';
    if ($this->checkIsShopModulActiv()) {
      $return .= '<div class="vFrontSiteSettingMenuPoint" id="vFrontSiteSeProdukte" data-id="' . $siteID . '">Produkte</div>';
    }
    $return .= '<div class="vFrontSiteSettingMenuPoint" id="vFrontSiteSeBilderGalerien" data-id="' . $siteID . '">Bilder Galerien</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getSiteSettingInhalt($siteID, $curInhaltName = '', $reload = false) {
    $return = '';
    if (isset($reload) && $reload == false) {
      $return .= '<div class="vFrontSiteSettingInhaltHolder">';
    }
    
    if (isset($curInhaltName) && !empty($curInhaltName)) {
      $return .= $this->getTheCureSiteSettingInhalt($siteID, $curInhaltName);
    }
    else {
      $return .= $this->getTheCureSiteSettingInhalt($siteID, 'vFrontSiteSeBilder');
    }
    
    if (isset($reload) && $reload == false) {
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getTheCureSiteSettingInhalt($siteID, $curInhaltName) {
    $return = '';
    
    switch($curInhaltName) {
      
      case 'vFrontSiteSeBilder':
        $return .= $this->getSiteSettingsBilder($siteID);
        break;
      
      
      
      case 'vFrontSiteSeFelder':
        $return .= $this->getSiteSettingsFelder($siteID);
        break;
      
      
      
      case 'vFrontSiteSeProdukte':
        $return .= $this->getSiteSettingsProdukte($siteID);
        break;
      
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seiteneigenschaften - Allgemein
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiteneigenschaften - Bilder
  // ***************************************************************************
  
  private function getSiteSettingsBilder($siteID) {
    $siteDataArr = $this->getCurSiteDataArr($siteID);
    $return = '<div class="vFrontFrmHolder">';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="vFrontFrmSiteBackImgs">
           <input type="hidden" name="vFrontFrmSiteBackImgs" id="vFrontFrmSiteBackImgs" value="' . $siteDataArr['seitBackImages'] . '" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Hintergrundbilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">' . $this->getListPicElemHtml($siteDataArr['seitBackImages']) . '</div>
         </div>
         
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmListHolder" data-field="vFrontFrmSiteListImg">
           <input type="hidden" name="vFrontFrmSiteListImg" id="vFrontFrmSiteListImg" value="' . $siteDataArr['seitListImage'] . '" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Listenbild</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">' . $this->getListPicElemHtml($siteDataArr['seitListImage']) . '</div>
         </div>
         
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmListHolder" data-field="vFrontFrmSiteSlideImgs">
           <input type="hidden" name="vFrontFrmSiteSlideImgs" id="vFrontFrmSiteSlideImgs" value="' . $siteDataArr['seitSlideImages'] . '" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Slide Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">' . $this->getListPicElemHtml($siteDataArr['seitSlideImages']) . '</div>
         </div>
         
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input type="submit" value="Speichern" id="vFrontSiteSeBilderButton" data-id="' . $siteID . '" />
         ';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getCurSiteDataArr($siteID) {
    $sqlDataText = 'SELECT * FROM vseiten WHERE seitID = ' . $this->dbDecode($siteID) . ' LIMIT 1';
    $sqlDataErg = $this->dbAbfragen($sqlDataText);
    $return = array();
    while($rowData = mysql_fetch_array($sqlDataErg, MYSQL_ASSOC)) {
      $return = $rowData;
    }
    return $return;
  }
  
  
  
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
  
  
  
  public function saveSeitenEigenschaftenBilder($siteID, $siteBackImgs, $siteListImg, $siteSlideImgs) {
    $sqlPicText = 'UPDATE vseiten SET seitBackImages = "' . $this->dbDecode($siteBackImgs) . '", seitListImage = "' . $this->dbDecode($siteListImg) . '", seitSlideImages = "' . $this->dbDecode($siteSlideImgs) . '" WHERE seitID = ' . $this->dbDecode($siteID);
    return $this->dbAbfragen($sqlPicText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seiteneigenschaften - Bilder
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiteneigenschaften - Felder
  // ***************************************************************************
  
  private function getSiteSettingsFelder($siteID) {
    $curLayoutID = $this->getSiteSettingsFelderLayouId($siteID);
    if (isset($curLayoutID) && !empty($curLayoutID)) {
      return $this->buildSiteSettingsFelderNow($curLayoutID, $siteID);
    }
    return '<div style="margin:50px; font-weight:bold;">Es ist ein Fehler aufgetreten.</div>';
  }
  
  
  
  private function getSiteSettingsFelderLayouId($siteID) {
    $sqlText = 'SELECT layID FROM vseiten WHERE seitID = "'.$this->dbDecode($siteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['layID'];
    }
  }
  
  
  
  private function buildSiteSettingsFelderNow($curLayoutID, $siteID) {
    $return = '<div class="vFrontFrmHolder" id="vFrontSiSeOwnFelderFormsHolder"><form>';
    $sqlText = 'SELECT * FROM vfelder WHERE layID = "'.$this->dbDecode($curLayoutID).'" ORDER BY feldPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $inhaltArr = $this->getSiteSettingsFeldInhaltArr($row, $siteID);
      $return .= $this->buildSiteSettingsCurentFeldNow($row, $inhaltArr);
    }
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      return '<div style="margin:50px; font-weight:bold;">Es sind keine Seitenfelder vorhanden.</div>';
    }
    
    $return .= '<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    $return .= '<input type="submit" data-id="'.$siteID.'" id="vFrontSaveSiSeOwnFieldsNow" value="Speichern" style="width:150px;">';
    $return .= '</form></div>';
    
    return $return;
  }
  
  
  
  private function getSiteSettingsFeldInhaltArr($feldArr, $siteID) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenfelder WHERE feldID = "'.$this->dbDecode($feldArr['feldID']).'" AND seitID = "'.$this->dbDecode($siteID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsCurentFeldNow($feldArr, $inhaltArr) {
    $return = '';
    
    if (isset($feldArr) && is_array($feldArr)) {
      switch ($feldArr['feldArt']) {
        case 1: $return .= $this->buildSiteSettingsFeldSeparator($feldArr, $inhaltArr);
          break;
        
        case 2: $return .= $this->buildSiteSettingsFeldTextfeld($feldArr, $inhaltArr);
          break;
        
        case 3: $return .= $this->buildSiteSettingsFeldTextarea($feldArr, $inhaltArr);
          break;
        
        case 4: $return .= $this->buildSiteSettingsFeldTextareaWysiwyg($feldArr, $inhaltArr);
          break;
        
        case 5: $return .= $this->buildSiteSettingsFeldCheckbox($feldArr, $inhaltArr);
          break;
        
        case 6: $return .= $this->buildSiteSettingsFeldDropDown($feldArr, $inhaltArr);
          break;
        
        case 12: $return .= $this->buildSiteSettingsFeldDatumfeld($feldArr, $inhaltArr);
          break;
        
        case 7: $return .= $this->buildSiteSettingsFeldBildOnce($feldArr, $inhaltArr);
          break;
        
        case 8: $return .= $this->buildSiteSettingsFeldBildMulti($feldArr, $inhaltArr);
          break;
        
        case 9: $return .= $this->buildSiteSettingsFeldDateiOnce($feldArr, $inhaltArr);
          break;
        
        case 10: $return .= $this->buildSiteSettingsFeldDateiMulti($feldArr, $inhaltArr);
          break;
        
        case 11: $return .= $this->buildSiteSettingsFeldSiteRelation($feldArr, $inhaltArr);
          break;
      }
    }
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldSeparator($feldArr, $inhaltArr) {
    $return = '<div style="font-weight:bold; font-size:15px; border-bottom:1px solid #555; color:#555; width:580px; padding-bottom:6px;">'.$feldArr['feldLabel'].'</div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldTextfeld($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    $return = '<label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].':</label>
                <div class="vFrontLblAbstand"></div>
                <input type="text" id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldTextarea($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    $return = '<label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].':</label>
                <div class="vFrontLblAbstand"></div>
                <textarea id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'">'.$curFieldVal.'</textarea>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldTextareaWysiwyg($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    $return = '<label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].':</label>
                <div class="vFrontLblAbstand"></div>
                <div style="width:560px;">
                  <textarea style="height:200px;" class="vFrontSiSeOwnFelderWysiwygField" id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'">'.$curFieldVal.'</textarea>
                </div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldCheckbox($feldArr, $inhaltArr) {
    $checkBoxChecked = '';
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    if (isset($curFieldVal) && $curFieldVal == 'on') {
      $checkBoxChecked = ' checked="checked"';
    }
    $return = '<div class="vFrontFrmAbstand"></div>';
    $return .= '<input'.$checkBoxChecked.' type="checkbox" id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'" value="on" />
                <label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].'</label>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldDropDown($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    $optionArrZw = explode(';', $feldArr['feldConfig']);
    $return = '<label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].':</label>
                <div class="vFrontLblAbstand"></div>
                <select class="vFrontSiSeOwnFelderSelectField" id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'">';
    foreach ($optionArrZw as $value) {
      $curOption = explode('=', $value);
      if (isset($curFieldVal) && $curFieldVal == $curOption[0]) {
        $return .= '<option selected="selected" value="'.$curOption[0].'">'.$curOption[1].'</option>';
      }
      else {
        $return .= '<option value="'.$curOption[0].'">'.$curOption[1].'</option>';
      }
    } 
    $return .= '</select>
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldDatumfeld($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    $return = '<label for="'.$feldArr['feldName'].'">'.$feldArr['feldLabel'].':</label>
                <div class="vFrontLblAbstand"></div>
                <input style="width:160px;" readonly="readonly" class="vFrontSiSeOwnFelderDateField" type="text" id="'.$feldArr['feldName'].'" name="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
                <div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldBildOnce($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    
    $return = '<label>'.$feldArr['feldLabel'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$feldArr['feldName'].'">
           <input type="hidden" name="'.$feldArr['feldName'].'" id="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bild</div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnFieldOnce"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnFieldOnce"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnFieldOnce">' . $this->getListPicElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldBildMulti($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    
    $return = '<label>'.$feldArr['feldLabel'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$feldArr['feldName'].'">
           <input type="hidden" name="'.$feldArr['feldName'].'" id="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnFieldMulti">' . $this->getListPicElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldDateiOnce($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    
    $return = '<label>'.$feldArr['feldLabel'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$feldArr['feldName'].'">
           <input type="hidden" name="'.$feldArr['feldName'].'" id="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Datei</div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnDateiFieldOnce"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnDateiFieldOnce"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnDateiFieldOnce">' . $this->getListDateiElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldDateiMulti($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    
    $return = '<label>'.$feldArr['feldLabel'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$feldArr['feldName'].'">
           <input type="hidden" name="'.$feldArr['feldName'].'" id="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Dateien</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnDateiFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnDateiFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnDateiFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnDateiFieldMulti">' . $this->getListDateiElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  private function buildSiteSettingsFeldSiteRelation($feldArr, $inhaltArr) {
    $curFieldVal = $this->buildTheOwnFeldInhaltVar($feldArr, $inhaltArr);
    
    $return = '<label>'.$feldArr['feldLabel'].':</label><div class="vFrontLblAbstand"></div>';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="'.$feldArr['feldName'].'">
           <input type="hidden" name="'.$feldArr['feldName'].'" id="'.$feldArr['feldName'].'" value="'.$curFieldVal.'" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Seiten</div>
             <div class="vFrontFrmListHolderHeaderSort vFrontFrmListHolderHeaderSortOwnSiteFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderAdd vFrontFrmListHolderHeaderAddOwnSiteFieldMulti"></div>
             <div class="vFrontFrmListHolderHeaderDel vFrontFrmListHolderHeaderDelOwnSiteFieldMulti"></div>
           </div>
           <div class="vFrontFrmListHolderLists vFrontFrmListHolderListsOwnSiteFieldMulti">' . $this->getListSiteRelElemHtml($curFieldVal) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';
    
    return $return;
  }
  
  
  
  
  
  private function buildTheOwnFeldInhaltVar($feldArr, $inhaltArr) {
    if (isset($inhaltArr) && is_array($inhaltArr)) {
      return $inhaltArr['sfeldInhalt'];
    }
  }
  
  
  
  
  
  public function saveSeitEigOwnFelderNowMM($siteId, $dataArr) {
    //echo '<pre>'.print_r($dataArr, 1).'</pre>';
    $curSiteLayID = $this->getSeitEigSiteLayIdForFileds($siteId);
    $this->setSeitEigOwnFeldCheckboxToOff($curSiteLayID, $siteId);
    foreach ($dataArr as $value) {
      $curFieldId = $this->getSeitEigFieldIdForSeitenFileds($curSiteLayID, $value['name']);
      if ($this->checkSeitEigOwnFieldOnSiteExist($siteId, $curFieldId)) {
        $this->saveSeitEigOwnFelderNowMMOnUpdate($siteId, $curFieldId, $value['value']);
      }
      else {
        $this->saveSeitEigOwnFelderNowMMOnInsert($siteId, $curFieldId, $value['value']);
      }
    }
  }
  
  
  
  private function checkSeitEigOwnFieldOnSiteExist($siteId, $curFieldId) {
    $sqlText = 'SELECT sfeldID FROM vseitenfelder WHERE seitID = "'.$this->dbDecode($siteId).'" AND feldID = "'.$this->dbDecode($curFieldId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgNum = mysql_num_rows($sqlErg);
    if (isset($sqlErgNum) && $sqlErgNum > 0) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function saveSeitEigOwnFelderNowMMOnInsert($siteId, $curFieldId, $value) {
    $sqlText = 'INSERT INTO vseitenfelder (sfeldInhalt, seitID, feldID) VALUES ("'.$this->dbDecode($value).'", "'.$this->dbDecode($siteId).'", "'.$this->dbDecode($curFieldId).'")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function saveSeitEigOwnFelderNowMMOnUpdate($siteId, $curFieldId, $value) {
    $sqlText = 'UPDATE vseitenfelder SET sfeldInhalt = "'.$this->dbDecode($value).'" WHERE seitID = "'.$this->dbDecode($siteId).'" AND feldID = "'.$this->dbDecode($curFieldId).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  
  
  private function getSeitEigSiteLayIdForFileds($siteId) {
    $sqlText = 'SELECT layID FROM vseiten WHERE seitID = "'.$this->dbDecode($siteId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['layID'];
    }
  }
  
  
  
  private function getSeitEigFieldIdForSeitenFileds($curSiteLayID, $fieldName) {
    $sqlText = 'SELECT feldID FROM vfelder WHERE layID = "'.$this->dbDecode($curSiteLayID).'" AND feldName = "'.$this->dbDecode($fieldName).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['feldID'];
    }
  }
  
  
  
  private function setSeitEigOwnFeldCheckboxToOff($curSiteLayID, $siteId) {
    $sqlText = 'SELECT feldID FROM vfelder WHERE layID = "'.$this->dbDecode($curSiteLayID).'" AND feldArt = "5"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlTextU = 'UPDATE vseitenfelder SET sfeldInhalt = "" WHERE seitID = "'.$this->dbDecode($siteId).'" AND feldID = "'.$this->dbDecode($row['feldID']).'"';
      $this->dbAbfragen($sqlTextU);
    }
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seiteneigenschaften - Felder
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiteneigenschaften - Produkte
  // ***************************************************************************
  
  private function getSiteSettingsProdukte($siteID) {
    $siteDataArr = $this->getCurSiteDataArr($siteID);
    $return = '<div class="vFrontFrmHolder">';
    
    $return .= '<div class="vFrontFrmListHolder" data-field="vFrontFrmSiteProducts">
           <input type="hidden" name="vFrontFrmSiteProducts" id="vFrontFrmSiteProducts" value="' . $siteDataArr['seitProdukte'] . '" />
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Produkte</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">' . $this->getListProductsElemHtml($siteDataArr['seitProdukte']) . '</div>
         </div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input type="submit" value="Speichern" id="vFrontSiteSeProdukteButton" data-id="' . $siteID . '" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getListProductsElemHtml($listProducts) {
    $return = '';
    if (isset($listProducts) && !empty($listProducts)) {
      $listArr = explode(';', $listProducts);
      
      foreach ($listArr as $prId) {
        $sqlTextList = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $bildArr = $this->getProductListBildDataById($rowList['prBild']);
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['prID'] . '">
              <div class="vFrontFrmListsElemBild">';
          if (isset($bildArr['bildFile']) && !empty($bildArr['bildFile'])) {
            $return .= '<img src="user_upload/' . $bildArr['bildFile'] . '" alt="" title="" />';
          }
          else {
            $return .= '<img src="admin/img/noImg.png" alt="" title="" />';
          }
          $return .= '</div>
              <div class="vFrontFrmListsElemText">' . $rowList['prName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
  
  
  public function saveSeitenEigenschaftenProdukte($siteID, $siteProdukte) {
    $sqlPrText = 'UPDATE vseiten SET seitProdukte = "' . $this->dbDecode($siteProdukte) . '" WHERE seitID = ' . $this->dbDecode($siteID);
    return $this->dbAbfragen($sqlPrText);
  }
  
  
  
  public function showProductsListInWindowForSeEig() {
    $return = '<div class="vFrontModulShopList">'; 
    $return .= '<div class="vFrontModulShopListHolder">
                ' . $this->showHpProductsListsForSeitEigAll() . '
                </div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function showHpProductsListsForSeitEigAll() {
    $return = '';
    $sqlText = 'SELECT * FROM vprodukte';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curPicArr = $this->getProductListBildDataById($rowPr['prBild']);
      $curPicFile = '';
      if (isset($curPicArr['bildFile']) && !empty($curPicArr['bildFile'])) {
        $curPicFile = $curPicArr['bildFile'];
      }
      $return .= '<div class="vFrontModulShopListElem" data-id="' . $rowPr['prID'] . '" data-file="' . $curPicFile . '" data-name="' . $rowPr['prName'] . '">';
      $return .= $rowPr['prName'];
      $return .= '</div>';
    }
    
    return $return;
  }

  // ***************************************************************************
  // ENDE - Funktionen für Seiteneigenschaften - Produkte
  // ***************************************************************************
  
  
  
  
  
  
  
  private function getProductListBildDataById($curPicId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPic = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seiteneigenschaften - Bilder Galerien
  // ***************************************************************************
  
  public function showSeiteneigenschaftenBilderGalerienReload($curMenuId) {
    $return = '<div style="margin-bottom:0px;" class="vFrontHpSeAuflistungUnUeAllg">Bilder Galerien verwalten</div>';
    $return .= '<div id="vFrontNeuePicGalSeBtn">Neue Bilder Galerie</div><div class="clearer"></div>';
    
    $return .= $this->getThePicGalListNowSe();
    
    return $return;
  }
  
  
  
  private function getThePicGalListNowSe() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $sqlText = 'SELECT * FROM vbildergalerien ORDER BY galPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontSiSeAuflistungPicGalVerwalt">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">' . $row['galName'] . '</div>';
      $return .= ' <div class="vFrontHpSeAuflistungLiElChange vFrontSiSeAuflistungPicGalChange" data-id="' . $row['galID'] . '" title="Bearbeiten"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElDel vFrontSiSeAuflistungPicGalDel" data-id="' . $row['galID'] . '" title="Löschen"></div>';
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showNewPicGalWindowSiSe() {
    $return = '';
    
    $return .= '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vFrontFrmSiSePicGalName" style="display:block; margin-bottom:5px; width:auto;">Bilder Galerie Name:</label>';
    $return .= '<input style="width:352px;" maxlength="150" type="text" name="vFrontFrmSiSePicGalName" id="vFrontFrmSiSePicGalName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<div data-field="vFrontFrmPicGalSiSeImgs" class="vFrontFrmListHolder">
           <input type="hidden" value="" id="vFrontFrmPicGalSiSeImgs" name="vFrontFrmPicGalSiSeImgs">
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists"></div>
         </div>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input style="margin-left:0px;" type="submit" value="Speichern" id="vSavePicGalSiSeNewBtn" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showChangePicGalWindowSiSe($curPicGalId) {
    $return = '';
    $curPicData = $this->getSiSePicGaleriePicData($curPicGalId);
    $curPicGalName = $this->getSiSePicGalerieCurName($curPicGalId);
    
    $return .= '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vFrontFrmSiSePicGalName" style="display:block; margin-bottom:5px; width:auto;">Bilder Galerie Name:</label>';
    $return .= '<input style="width:352px;" maxlength="150" type="text" name="vFrontFrmSiSePicGalName" id="vFrontFrmSiSePicGalName" value="'.$curPicGalName.'" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<div data-field="vFrontFrmPicGalSiSeImgs" class="vFrontFrmListHolder">
           <input type="hidden" value="'.$curPicData.'" id="vFrontFrmPicGalSiSeImgs" name="vFrontFrmPicGalSiSeImgs">
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->buildSiSePicGaleriePicLists($curPicData).'</div>
         </div>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input style="margin-left:0px;" type="submit" value="Speichern" id="vSavePicGalSiSeChangeBtn" data-id="' . $curPicGalId . '" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function vSavePicGalSiSeNewBtn($picGalName, $picGalPics) {
    $sqlText = 'INSERT INTO vbildergalerien (galName, galBilder) VALUES ("'.$this->dbDecode($picGalName).'", "'.$this->dbDecode($picGalPics).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
    if ($sqlErg == true) {
      $curID = mysql_insert_id();
      $sqlTextA = 'UPDATE vbildergalerien SET galPosition = "'.$this->dbDecode($curID).'" WHERE galID = '.$this->dbDecode($curID);
      return $this->dbAbfragen($sqlTextA);
    }
  }
  
  
  
  public function vSavePicGalSiSeChangeBtn($picGalId, $picGalName, $picGalPics) {
    $sqlText = 'UPDATE vbildergalerien SET galName = "'.$this->dbDecode($picGalName).'", galBilder = "'.$this->dbDecode($picGalPics).'" WHERE galID = ' . $this->dbDecode($picGalId);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  private function getSiSePicGalerieCurName($curPicGalId) {
    $sqlText = 'SELECT galName FROM vbildergalerien WHERE galID = ' . $this->dbDecode($curPicGalId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $row['galName'];
    }
  }
  
  
  
  private function getSiSePicGaleriePicData($curPicGalId) {
    $sqlText = 'SELECT galBilder FROM vbildergalerien WHERE galID = ' . $this->dbDecode($curPicGalId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['galBilder']) && !empty($row['galBilder'])) {
        return $row['galBilder'];
      }
    }
    
    return '';
  }
  
  
  
  private function buildSiSePicGaleriePicLists($list) {
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
  
  
  
  public function delThisSiSePicGalNow($curPicGalId) {
    $sqlText = 'DELETE FROM vbildergalerien WHERE galID = ' . $this->dbDecode($curPicGalId);
    return $this->dbAbfragen($sqlText);
  }
          
  // ***************************************************************************
  // ENDE - Funktionen für Seiteneigenschaften - Bilder Galerien
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  private function getListDateiElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $dateiId) {
        $sqlTextList = 'SELECT * FROM vdateien WHERE dateiID = ' . $this->dbDecode($dateiId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['dateiID'] . '">
              <div class="vFrontFrmListsElemBild" style="text-align:center;">
                <img style="width:40px;" src="' . $this->getDateiElemCurPicPath($rowList['dateiName']) . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['dateiName'] . '</div>
              <div class="clearer"></div>
            </div>';
        }
      }
    }
    return $return;
  }
  
  
  
  private function getDateiElemCurPicPath($dateiName) {
    $curImg = 'no.png';
    $curDateiEndungZw = explode('.', $dateiName);
    $curDateiEndung = $curDateiEndungZw[count($curDateiEndungZw) - 1];
    
    if (isset($curDateiEndung) && ($curDateiEndung == 'jpg' || $curDateiEndung == 'jpeg')) {
      $curImg = 'jpg.png';
    }
    else if (isset($curDateiEndung) && $curDateiEndung == 'png') {
      $curImg = 'png.png';
    }
    else if (isset($curDateiEndung) && $curDateiEndung == 'gif') {
      $curImg = 'gif.png';
    }
    else if (isset($curDateiEndung) && $curDateiEndung == 'pdf') {
      $curImg = 'pdf.png';
    }
    else if (isset($curDateiEndung) && $curDateiEndung == 'txt') {
      $curImg = 'txt.png';
    }
    else if (isset($curDateiEndung) && $curDateiEndung == 'zip') {
      $curImg = 'zip.png';
    }
    
    return 'admin/frontAdmin/img/dateiendungen/'.$curImg;
  }
  
  
  
  private function getListSiteRelElemHtml($list) {
    $return = '';
    if (isset($list) && !empty($list)) {
      $listArr = explode(';', $list);
      
      foreach ($listArr as $siteId) {
        $sqlTextList = 'SELECT seitName, seitID FROM vseiten WHERE seitID = ' . $this->dbDecode($siteId) . ' LIMIT 1';
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontListElemIUser" data-id="' . $rowList['seitID'] . '">' . $rowList['seitName'] . '</div>';
        }
      }
    }
    return $return;
  }
  
}

?>