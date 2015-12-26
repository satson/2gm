<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class hpEinstellungen extends funktionsSammlung {
  
  public function getHpSettingsNow() {
    $return = $this->getHpSettingsMenu();
    
    $return .= '<div class="vFrontHpSettingInhaltHolder">';
    $return .= $this->getHpSettingInhalt();
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getHpSettingsMenu() {
    $return = '<div class="vFrontHpSettingMenuHolder"><div style="height:20px;"></div>';
    
    $return .= '<div class="vFrontHpSettingMenuPoint vFrontActiveHpS" id="vFrontHpSeAllgemein">Allgemein</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeElemente">Elemente</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeLayouts">Seitenlayouts</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeNaviArt">Navigationsarten</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeUser">User</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeSprachen">Sprachen</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeModule">Erweiterungen</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpOrderModule">Order settings</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpBasketModule">Basket settings</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpFilterModule">Filter settings</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpTimeModule">Time</div>';
    $return .= '<div class="vFrontHpSettingMenuPoint" id="vFrontHpSeSitemap">Sitemap XML</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getHpSettingInhalt($curInhaltName = '') {
    $return = '';
    
    
    if (isset($curInhaltName) && !empty($curInhaltName)) {
      $return .= $this->getTheCureHpSettingInhalt($curInhaltName);
    }
    else {
      $return .= $this->getTheCureHpSettingInhalt('vFrontHpSeAllgemein');
    }
    
    return $return;
  }
  
  
  
  private function getTheCureHpSettingInhalt($curInhaltName) {
    $return = '';
    
    switch($curInhaltName) {
      
      case 'vFrontHpSeAllgemein':
        $return .= $this->getHpSettingsAllgemein();
        break;
      
      case 'vFrontHpSeElemente':
        $return .= $this->getHpSettingsElemente();
        break;
      
      case 'vFrontHpSeLayouts':
        $return .= $this->getHpSettingsSeitenlayouts();
        break;
      
      case 'vFrontHpSeNaviArt':
        $return .= $this->getHpSettingsNaviArts();
        break;
      
      case 'vFrontHpSeUser':
        $return .= $this->getHpSettingsUserVerwaltung();
        break;
      
      case 'vFrontHpSeSprachen':
        $return .= $this->getHpSettingsSprachen();
        break;
      
      case 'vFrontHpSeModule':
          
        $return .= $this->getHpSettingsModuleVerwaltung();
        break;
      
      case 'vFrontHpSeSitemap':
        $return .= $this->getHpSettingsSitemapGenerator();
        break;
      
    }
    
    return $return;
  }
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Allgemein
  // ***************************************************************************
  
  private function getHpSettingsAllgemein() {
    $sqlText = 'SELECT * FROM vhomepage WHERE hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Allgemeine Einstellungen</div>';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontFrmHolder">';
      $return .= '<label for="vFrontHpSeAllName">Homepage Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontHpSeAllName" id="vFrontHpSeAllName" value="' . $row['hpName'] . '" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label>Homepage Template:</label>
                  <div class="vFrontLblAbstand"></div>';
      $return .= '<select name="vFrontHpSeAllTemplate" id="vFrontHpSeAllTemplate">';
      $return .= $this->getHpSettingAllgemeinTemplateOptions($row['hpTemplate']);
      $return .= '</select>';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>';
      
      if (isset($row['hpOnline']) && $row['hpOnline'] == 2) {
        $return .= '<input checked="checked" type="checkbox" name="vFrontHpSeAllOffline" id="vFrontHpSeAllOffline" /><label for="vFrontHpSeAllOffline">Homepage Offline</label>';
      }
      else {
        $return .= '<input type="checkbox" name="vFrontHpSeAllOffline" id="vFrontHpSeAllOffline" /><label for="vFrontHpSeAllOffline">Homepage Offline</label>';
      }
      
      /*$return .= '<div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>';
      
      if (isset($row['hpShopAktiv']) && $row['hpShopAktiv'] == 1) {
        $return .= '<input checked="checked" type="checkbox" name="vFrontHpSeAllShopAktiv" id="vFrontHpSeAllShopAktiv" /><label for="vFrontHpSeAllShopAktiv">Shop Modul Aktiv</label>';
      }
      else {
        $return .= '<input type="checkbox" name="vFrontHpSeAllShopAktiv" id="vFrontHpSeAllShopAktiv" /><label for="vFrontHpSeAllShopAktiv">Shop Modul Aktiv</label>';
      }*/
      
      $return .= '<div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label for="vFrontHpSeAllMetaTitle">Meta Title (Deutsch):</label>';
      $return .= '<div class="vFrontLblAbstand"></div>';
      $return .= '<input type="text" name="vFrontHpSeAllMetaTitle" id="vFrontHpSeAllMetaTitle" value="' . $row['hpMetaTitle'] . '" />';
      
      $return .= '<div class="vFrontAllHpSeAllMetasLangHolder">';
      $return .= $this->getHpAllgemeinMetaLangTitle();
      $return .= '</div>';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label for="vFrontHpSeAllHeaderCode">Header Code:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontHpSeAllHeaderCode" id="vFrontHpSeAllHeaderCode">' . $row['hpHeaderZusatz'] . '</textarea>';
      
      $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:150px;" type="submit" value="Speichern" id="vFrontSaveHpSeAllgemein" data-id="' . $_SESSION['VCMS_HP_ID'] . '" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getHpSettingAllgemeinTemplateOptions($curTemplate) {
    $templates = scandir('../../../templates');
    $return = '';

    foreach ($templates as $_template) {
      if (is_dir('../../../templates/'.$_template) && $_template != '.' && $_template != '..') {
        if (isset($curTemplate) && !empty($curTemplate) && $curTemplate == $_template) {
          $return .= '<option selected="selected" value="' . $_template . '">' . $_template . '</option>';
        }
        else {
          $return .= '<option value="' . $_template . '">' . $_template . '</option>';
        }
      }
    }

    return $return;
  }
  
  
  
  public function saveHpSeAllgemeinNow($curHpId, $curHpName, $curHpTemplate, $hpOffline, $hpHeaderCode) {
    $curMetaTitleDe = '';
    if (isset($_POST['_hpSeMetaLangJSON']['meta_de']) && !empty($_POST['_hpSeMetaLangJSON']['meta_de'])) {
      $curMetaTitleDe = $_POST['_hpSeMetaLangJSON']['meta_de'];
    }
    $sqlText = 'UPDATE vhomepage SET 
                hpName = "' . $this->dbDecode($curHpName) . '", 
                hpTemplate = "' . $this->dbDecode($curHpTemplate) . '", 
                hpOnline = ' . $this->dbDecode($hpOffline) . ', 
                hpHeaderZusatz = "' . $this->dbDecode($hpHeaderCode) . '", 
                hpMetaTitle = "' . $this->dbDecode($curMetaTitleDe) . '" 
                WHERE hpID = ' . $this->dbDecode($curHpId);
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if ($sqlErg == true) {
      $this->saveHpSeAllgemeinMetasLangNow($_POST['_hpSeMetaLangJSON'], $curHpId);
    }
    
    return $sqlErg;
  }
  
  
  
  private function getHpAllgemeinMetaLangTitle() {
    $return = '';
    
    $sqlText = 'SELECT langKurzName, langName, langID FROM vsprachen WHERE langAktiv = 1 AND langStandard = 2';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curValue = $this->getHpAllgemeinMetaLangTitleValue($_SESSION['VCMS_HP_ID'], $row['langID']);
      
      $return .= '<div class="vFrontFrmAbstand"></div>
                  <div class="vFrontFrmAbstand"></div>';
      
      $return .= '<label for="vFrontHpSeAllMetaTitle'.$row['langKurzName'].'">Meta Title ('.$row['langName'].'):</label>';
      $return .= '<div class="vFrontLblAbstand"></div>';
      $return .= '<input type="text" name="vFrontHpSeAllMetaTitle'.$row['langKurzName'].'" id="vFrontHpSeAllMetaTitle'.$row['langKurzName'].'" value="'.$curValue.'" />';
    }
    
    return $return;
  }
  
  
  
  private function getHpAllgemeinMetaLangTitleValue($hpID, $langID) {
    $return = '';
    
    $sqlText = 'SELECT hplaMetaTitle FROM vhomepagelang WHERE langID = "'.$this->dbDecode($langID).'" AND hpID = "'.$this->dbDecode($hpID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= $row['hplaMetaTitle'];
    }
    
    return $return;
  }
  
  
  
  private function saveHpSeAllgemeinMetasLangNow($langMetaArr, $curHpId) {
    foreach ($langMetaArr as $key => $value) {
      if ($key != 'meta_de') {
        $curLangUri = str_replace('meta_', '', $key);
        $curLangId = $this->getCurentMetaLangIdFromUrlName($curLangUri);
        if ($this->checkHpSeAllHasDataLang($curHpId, $curLangId)) {
          $this->saveHpSeAllgemeinMetasLangNowOnUpdate($curHpId, $curLangId, $value);
        }
        else {
          $this->saveHpSeAllgemeinMetasLangNowOnInsert($curHpId, $curLangId, $value);
        }
      }
    }
  }
  
  
  
  private function saveHpSeAllgemeinMetasLangNowOnUpdate($curHpId, $curLangId, $value) {
    $sqlText = 'UPDATE vhomepagelang SET hplaMetaTitle = "'.$this->dbDecode($value).'" WHERE langID = "'.$this->dbDecode($curLangId).'" AND hpID = "'.$this->dbDecode($curHpId).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
  }
  
  
  
  private function saveHpSeAllgemeinMetasLangNowOnInsert($curHpId, $curLangId, $value) {
    $sqlText = 'INSERT INTO vhomepagelang (hplaMetaTitle, langID, hpID) VALUES ("'.$this->dbDecode($value).'", "'.$this->dbDecode($curLangId).'", "'.$this->dbDecode($curHpId).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
  }
  
  
  
  // Funktionen für Sprachen ID und Prüfen
  // *******************************************************************
  private function getCurentMetaLangIdFromUrlName($langUrlName) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  private function checkHpSeAllHasDataLang($hpId, $langId) {
    $sqlCheckText = 'SELECT hplaID FROM vhomepagelang WHERE langID = ' . $this->dbDecode($langId) . ' AND hpID = ' . $this->dbDecode($hpId) . ' LIMIT 1';
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckNum = mysql_num_rows($sqlCheckErg);
    if (isset($sqlCheckNum) && $sqlCheckNum > 0) {
      return true;
    }
    return false;
  }
  // *******************************************************************
  
  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Allgemein
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Elemente
  // ***************************************************************************
  
  private function getHpSettingsElemente() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= $this->getHpSeElementsListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeElementsListNow() {
    $return = '<div class="vFrontHpSeAuflistungUnUe">System Elemente</div>';
    
    $sqlText = 'SELECT * FROM velement WHERE elemEigen = 1 ORDER BY elemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowEl = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curBack = '';
      if (isset($rowEl['elemHidden']) && $rowEl['elemHidden'] == 1) {
        $curBack = ' vFrontHpSeListHidden';
      }
      $return .= '<div class="vFrontHpSeAuflistungLiElSys vFrontHpSeAuflistungLiEl' . $curBack . '">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">' . $rowEl['elemName'] . '</div>';
      $return .= ' <div class="vFrontHpSeAuflistungLiElChange" data-id="' . $rowEl['elemID'] . '" title="Bearbeiten"></div>';
      $return .= '</div>';
    }
    
    $return .= '<div style="height:15px"></div>';
    $return .= '<div class="vFrontHpSeAuflistungUnUe vFrontHpSeAuflistungUnUeOwnElems">Eigene Elemente</div>';
    $return .= '<div id="vFrontNeuesElementBtn">Neues Element</div>';
    $return .= '<div id="vFrontOwnElementeSortierenBtn">Elemente Sortieren</div>';
    $return .= '<div class="clearer"></div>';
    
    $return .= '<div class="vFrontOwnElementeHolderToSortMM">';
    
    $sqlTextE = 'SELECT * FROM velement WHERE elemEigen = 2 ORDER BY elemPosition ASC';
    $sqlErgE = $this->dbAbfragen($sqlTextE);
    
    while($rowElE = mysql_fetch_array($sqlErgE, MYSQL_ASSOC)) {
      $curBack = '';
      $curCentralClass = '';
      if (isset($rowElE['elemHidden']) && $rowElE['elemHidden'] == 1) {
        $curBack = ' vFrontHpSeListHidden';
      }
      if (isset($rowElE['elemCentralFolder']) && !empty($rowElE['elemCentralFolder'])) {
        $curCentralClass = ' vFrontHpSeAuflistungLiElIsCentral';
      }
      $return .= '<div class="vFrontHpSeAuflistungLiEl' . $curBack . $curCentralClass . '" data-id="'.$rowElE['elemID'].'">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">' . $rowElE['elemName'] . '</div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElChangeSettings" data-id="' . $rowElE['elemID'] . '" title="Einstellungen Code"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElChange" data-id="' . $rowElE['elemID'] . '" title="Bearbeiten"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElDel" data-id="' . $rowElE['elemID'] . '" title="Löschen"></div>';
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    $return .= '<div style="height:15px"></div>';
    $return .= '<div class="vFrontHpSeAuflistungUnUe">Zentrale Elemente <span style="font-size:12px;">(nicht installiert)</span></div>';
    
    $return .= $this->buildCentralElementsLists();
    
    return $return;
  }
  
  
  
  private function buildCentralElementsLists() {
    $return = '';
    
    // --------------------------------------------------------------------
    // Pfad muss in folgenden Dateien geändert werden:
    // --------------------------------------------------------------------
    // admin/inc/klassen/hp_settings.inc.php  ($curentElementsPath)
    // admin/inc/klassen/elemente_self.inc.php  ($curCentralElementsPath)
    // index.php  ($curCentralElementsPathIndex)
    // --------------------------------------------------------------------
    //$curentElementsPath = '/var/www/vhosts/default/htdocs/cmsCentralElems/';
    $curentElementsPath = '/home/xyganvvx/cmsCentralElems/';
    
    if (is_dir($curentElementsPath)) {
      $folderHandle = opendir($curentElementsPath);
      
      while ($folder = readdir($folderHandle)) {
        if (isset($folder) && $folder != "." && $folder != ".." && $folder != ".htaccess") {
          if ($this->checkIsCentralElemNotInstalled($folder) == true) {
            $elementFolderHandle = opendir($curentElementsPath.$folder);

            while ($file = readdir($elementFolderHandle)) {
              if (isset($file) && $file != "." && $file != ".." && $file != ".htaccess") {
                if (stripos($file, '.txt') !== false) {
                  $curElemName = str_replace('.txt', '', $file); // utf8_encode(str_replace('.txt', '', $file));
                  $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiElIsCentral">';
                  $return .= '<div class="vFrontHpSeAuflistungLiElName">'.$curElemName.'</div>';
                  $return .= '<div class="vFrontHpSeAuflistungLiElInstall" data-folder="'.$folder.'" data-name="'.$curElemName.'" title="Installieren"></div>';
                  $return .= '</div>';
                }
              }
            }

            closedir($elementFolderHandle);
          }
        }
      }

      closedir($folderHandle);
    }
    
    return $return;
  }
  
  
  
  private function checkIsCentralElemNotInstalled($folder) {
    $sqlText = 'SELECT elemID FROM velement WHERE elemCentralFolder = "'.$this->dbDecode($folder).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public function delHpSeThisCurentElement($curDelId) {
    $sqlText = 'DELETE FROM velement WHERE elemID = ' . $this->dbDecode($curDelId) . ' AND elemEigen = 2';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showHpSeNewElementForms() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vElementsFrmName">Name:</label>
                <input type="text" name="vElementsFrmName" id="vElementsFrmName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vElementsFrmFile">Datei:</label>
                <input type="text" name="vElementsFrmFile" id="vElementsFrmFile" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vElementsFrmOffline">Verbergen:</label>
                <input type="checkbox" name="vElementsFrmOffline" id="vElementsFrmOffline" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveNewElementForms" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showHpSeChangeElementForms($curSelemId) {
    $return = '<div class="vFrontSmallSeFrmHolder" data-id="' . $curSelemId . '">';
    
    $sqlText = 'SELECT * FROM velement WHERE elemID = ' . $this->dbDecode($curSelemId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgNum = mysql_num_rows($sqlErg);
    
    if ($sqlErgNum == 1) {
      while ($rowE = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        if (isset($rowE['elemEigen']) && $rowE['elemEigen'] == 2) {
          if (isset($rowE['elemCentralFolder']) && !empty($rowE['elemCentralFolder'])) {
            $return .= '<label>Name:</label>
                <input disabled="disabled" type="text" name="vElementsFrmNameDummyData" id="vElementsFrmNameDummyData" value="' . $rowE['elemName'] . '" />';
            $return .= '<div style="display:none;">';
          }
          $return .= '<label for="vElementsFrmName">Name:</label>
                <input type="text" name="vElementsFrmName" id="vElementsFrmName" value="' . $rowE['elemName'] . '" />';
    
          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

          $return .= '<label for="vElementsFrmFile">Datei:</label>
                      <input type="text" name="vElementsFrmFile" id="vElementsFrmFile" value="' . $rowE['elemFile'] . '" />';
          if (isset($rowE['elemCentralFolder']) && !empty($rowE['elemCentralFolder'])) {
            $return .= '</div>';
          }
          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
        }
        else {
          $return .= '<label for="vElementsFrmName">Name:</label>
                  <input disabled="disabled" type="text" name="vElementsFrmName" id="vElementsFrmName" value="' . $rowE['elemName'] . '" />';
    
          $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
        }
        
        $isHidden = '';
        if (isset($rowE['elemHidden']) && $rowE['elemHidden'] == 1) {
          $isHidden = ' checked="checked"';
        }
        $return .= '<label for="vElementsFrmOffline">Verbergen:</label>
                    <input type="checkbox" name="vElementsFrmOffline" id="vElementsFrmOffline"' . $isHidden . ' />';

        $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
        
        $dataArt = 'sys';
        if (isset($rowE['elemEigen']) && $rowE['elemEigen'] == 2) {
          $dataArt = 'own';
        }
        
        $return .= '<input type="submit" value="Speichern" id="vFrontSaveChangeElementForms" data-id="' . $curSelemId . '" data-art="' . $dataArt . '" />';
      }
    }
    else {
      $return .= 'Fehler';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeElementsNewElement($elemName, $elemFile, $elemHidden) {
    $sqlText = 'INSERT INTO velement (elemName, elemHidden, elemEigen, elemFile) VALUES ("' . $this->dbDecode($elemName) . '", ' . $this->dbDecode($elemHidden) . ', 2, "' . $this->dbDecode($elemFile) . '")';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $curNewId = mysql_insert_id();
    
    $sqlTextB = 'UPDATE velement SET elemPosition = ' . $this->dbDecode($curNewId) . ' WHERE elemID = ' . $this->dbDecode($curNewId);
    return $this->dbAbfragen($sqlTextB);
  }
  
  
  
  public function saveHpSeElementsNewElementCentral($elemName, $elemFile, $elemHidden, $elemCentralFolder) {
    $sqlText = 'INSERT INTO velement (elemName, elemHidden, elemEigen, elemFile, elemCentralFolder) VALUES ("' . $this->dbDecode($elemName) . '", ' . $this->dbDecode($elemHidden) . ', 2, "' . $this->dbDecode($elemFile) . '", "'.$this->dbDecode($elemCentralFolder).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $curNewId = mysql_insert_id();
    
    $sqlTextB = 'UPDATE velement SET elemPosition = ' . $this->dbDecode($curNewId) . ' WHERE elemID = ' . $this->dbDecode($curNewId);
    return $this->dbAbfragen($sqlTextB);
  }
  
  
  
  public function saveHpSeElementsChangeElementSys($elemId, $elemHidden) {
    $sqlTextB = 'UPDATE velement SET elemHidden = ' . $this->dbDecode($elemHidden) . ' WHERE elemID = ' . $this->dbDecode($elemId);
    return $this->dbAbfragen($sqlTextB);
  }
  
  
  
  public function saveHpSeElementsChangeElementOwn($elemId, $elemName, $elemFile, $elemHidden) {
    $sqlTextB = 'UPDATE velement SET elemHidden = ' . $this->dbDecode($elemHidden) . ', elemName = "' . $this->dbDecode($elemName) . '", elemFile = "' . $this->dbDecode($elemFile) . '" WHERE elemID = ' . $this->dbDecode($elemId);
    return $this->dbAbfragen($sqlTextB);
  }
  
  
  
  public function setSortOwnElementsNewNowMM($allOwnElemsList) {
    $allListOwnArr = explode(';', $allOwnElemsList);
    $setPos = 0;
    foreach ($allListOwnArr as $value) {
      $setPos++;
      $sqlText = 'UPDATE velement SET elemPosition = "' . $this->dbDecode($setPos) . '" WHERE elemID = ' . $this->dbDecode($value);
      $this->dbAbfragen($sqlText);
    }
  }
  
  
  
  public function showHpSeElementsOwnSettingChangeElementWindow($elemID) {
    $return = '';
    
    $curSettingString = $this->getHpSeElementsOwnSettingChangeElementString($elemID);
    
    $return .= '<div class="vFrontSmallSeFrmHolder" style="margin-top:25px;">';
    
    $return .= '<textarea id="vFrontOwnElemSettingStringTextarea" name="vFrontOwnElemSettingStringTextarea" style="width:400px; height:180px;">'.$curSettingString.'</textarea>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input style="margin-left:0px;" id="vFrontSaveOwnElemSettingString" type="submit" value="Speichern" data-id="'.$elemID.'" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeElementsOwnSettingChangeElementString($elemID) {
    $return = '';
    
    $sqlText = 'SELECT elemOwnConfig FROM velement WHERE elemID = "'.$this->dbDecode($elemID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['elemOwnConfig']) && !empty($row['elemOwnConfig'])) {
        //$curArrAll = json_decode($row['elemOwnConfig'], true);
        //echo '<pre>'.print_r($curArrAll, 1).'</pre>';
        $return = $row['elemOwnConfig'];
      }
    }
    
    /************************************************************
    {

    "FieldA":{"art":"1", "label":"Feld 1", "options":""},
    "FieldC":{"art":"1", "label":"Feld 1", "options":""}

    }
    *************************************************************/
    
    return $return;
  }
  
  
  
  public function saveHpSeElementsOwnSettingChangeElementString($elemID, $curElemString) {
    $checkVar = 'ok';
    
    $curElemString = trim($curElemString);
    
    if (isset($curElemString) && !empty($curElemString)) {
      $curZwStringTest = json_decode($curElemString, true);

      switch(json_last_error()) {
          case JSON_ERROR_NONE:
          break;

          case JSON_ERROR_DEPTH: $checkVar = 'Maximale Stacktiefe überschritten';
          break;

          case JSON_ERROR_STATE_MISMATCH: $checkVar = 'Unterlauf oder Nichtübereinstimmung der Modi';
          break;

          case JSON_ERROR_CTRL_CHAR: $checkVar = 'Unerwartetes Steuerzeichen gefunden';
          break;

          case JSON_ERROR_SYNTAX: $checkVar = 'Syntaxfehler';
          break;

          case JSON_ERROR_UTF8: $checkVar = 'Missgestaltete UTF-8 Zeichen, möglicherweise fehlerhaft kodiert';
          break;

          default: $checkVar = 'Unbekannter Fehler';
          break;
      }
    }
    
    if (isset($checkVar) && $checkVar == 'ok') {
      $sqlText = 'UPDATE velement SET elemOwnConfig = "'.$this->dbDecode($curElemString).'" WHERE elemID = "'.$this->dbDecode($elemID).'"';
      return $this->dbAbfragen($sqlText);
    }
    else {
      return $checkVar;
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Elemente
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Seitenlayouts
  // ***************************************************************************
  
  private function getHpSettingsSeitenlayouts() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= $this->getHpSeSeitenlayoutsListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeSeitenlayoutsListNow() {
    $return = '<div class="vFrontHpSeAuflistungUnUe">Seitenlayouts</div>';
    $return .= '<div id="vFrontNeuesSeitenlayoutBtn">Neues Seitenlayout</div><div class="clearer"></div>';
    
    $sqlTextS = 'SELECT * FROM vseitenlayout WHERE hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']);
    $sqlErgS = $this->dbAbfragen($sqlTextS);
    
    while($rowElE = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungLiLay">';
      $return .= '<div class="vFrontHpSeAuflistungLiLayName">' . $rowElE['layName'] . '</div>';
      $return .= '<div class="vFrontHpSeAuflistungLiLayChange" data-id="' . $rowElE['layID'] . '" title="Bearbeiten"></div>';
      if ($rowElE['layID'] != 1) {
        $return .= '<div class="vFrontHpSeAuflistungLiLayDel" data-id="' . $rowElE['layID'] . '" title="Löschen"></div>';
      }
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function showHpSeNewSeitenlayoutsFormsWindow() {
    $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Neues Seitenlayout erstellen</div>';
    
    $return .= '<div class="vFrontFrmHolder">';
    
    $return .= '<label for="vFrontHpSeSiteLayoutName">Layout Name:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="text" name="vFrontHpSeSiteLayoutName" id="vFrontHpSeSiteLayoutName" style="width:275px;" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontHpSeSiteLayoutDatei">Layout Datei:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="text" name="vFrontHpSeSiteLayoutDatei" id="vFrontHpSeSiteLayoutDatei" style="width:275px;" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:135px;" type="submit" value="Speichern" id="vFrontSaveHpSeNewSeitenlayout" />
         <input style="width:135px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCancelHpSeNewSeitenlayout" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeNewSeitenlayout($layName, $layFile) {
    $sqlText = 'INSERT INTO vseitenlayout (layName, layFile, hpID) VALUES ("'.$this->dbDecode($layName).'", "'.$this->dbDecode($layFile).'", '.$this->dbDecode($_SESSION['VCMS_HP_ID']).')';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delHpSeThisSeitenlayout($layID) {
    $sqlText = 'DELETE FROM vseitenlayout WHERE layID = ' . $this->dbDecode($layID);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showHpSeBearSeitenlayoutsFormsWindow($layID) {
    $return = '';
    $sqlText = 'SELECT * FROM vseitenlayout WHERE layID = ' . $this->dbDecode($layID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Seitenlayout bearbeiten</div>';

      $return .= '<div class="vFrontFrmHolder" style="margin-left:20px;">';
      
      $return .= '<div class="vFrontFrmHolderHpSeRowForms">';
      
      $return .= '<label for="vFrontHpSeSiteLayoutName">Layout Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontHpSeSiteLayoutName" id="vFrontHpSeSiteLayoutName" style="width:275px;" value="'.$row['layName'].'" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

      $return .= '<label for="vFrontHpSeSiteLayoutDatei">Layout Datei:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontHpSeSiteLayoutDatei" id="vFrontHpSeSiteLayoutDatei" style="width:275px;" value="'.$row['layFile'].'" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

      $return .= '<div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <input style="width:135px;" type="submit" value="Speichern" id="vFrontSaveHpSeBearSeitenlayout" data-id="'.$layID.'" />
           <input style="width:135px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCancelHpSeBearSeitenlayout" />';
      
      $return .= '</div>';
      
      // Für Seitenlayouts Felder
      // ***********************************************************************
      $return .= '<div class="vFrontFrmHolderHpSeRowFields">';
      
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsNewBtn" data-id="'.$layID.'">Neues Feld</div>';
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsListIn" data-id="'.$layID.'">';
      $return .= $this->buildSeitenlayoutFelderList($layID);
      $return .= '</div>';
      
      $return .= '</div>';
      // ***********************************************************************

      $return .= '<div class="clearer"></div></div>';
    }
    
    return $return;
  }
  
  
  
  public function saveHpSeBearSeitenlayout($layID, $layName, $layFile) {
    $sqlText = 'UPDATE vseitenlayout SET layName = "'.$this->dbDecode($layName).'", layFile = "'.$this->dbDecode($layFile).'" WHERE layID = ' . $this->dbDecode($layID);
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Seitenlayouts
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Userverwaltung
  // ***************************************************************************
  
  private function getHpSettingsUserVerwaltung() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= $this->getHpSeUserVerwaltListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeUserVerwaltListNow() {
    $return = '<div class="vFrontHpSeAuflistungUnUe">User Verwaltung</div>';
    $return .= '<div id="vFrontNeuerUserInCmsBtn">Neuer User</div><div class="clearer"></div>';
    
    $sqlTextS = 'SELECT * FROM vuser WHERE userDel = 1 AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']);
    $sqlErgS = $this->dbAbfragen($sqlTextS);
    
    while($rowElE = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
      $curBack = '';
      if (isset($rowElE['userOnline']) && $rowElE['userOnline'] == 2) {
        $curBack = ' vFrontHpSeListHidden';
      }
      
      $userArtAusgabe = 'Super User';
      
      if ($rowElE['userRechte'] == 2) {
        $userArtAusgabe = 'Standard User';
      }
      if ($rowElE['userRechte'] == 3) {
        $userArtAusgabe = 'Individual User';
      }
      
      $return .= '<div class="vFrontHpSeAuflistungLiUser'.$curBack.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiUserName">' . $rowElE['userName'] . ' <span style="font-size:10px; color:#777;">('.$userArtAusgabe.')</span></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiUserChange" data-id="' . $rowElE['userID'] . '" title="Bearbeiten"></div>';
      if ($rowElE['userID'] != 1) {
        $return .= '<div class="vFrontHpSeAuflistungLiUserDel" data-id="' . $rowElE['userID'] . '" title="Löschen"></div>';
      }
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function showHpSeNewUserForms() {
    $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Neuen User erstellen</div>';
    
    $return .= '<div class="vFrontFrmHolder">';
    
    $return .= '<label for="vFrontHpSeUserArt">User Art:</label>
         <div class="vFrontLblAbstand"></div>
         <select name="vFrontHpSeUserArt" id="vFrontHpSeUserArt">
          '.$this->getUserArtOptionsNow().'
         </select>

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<input type="checkbox" name="vFrontHpSeUserOffline" id="vFrontHpSeUserOffline" /><label for="vFrontHpSeUserOffline">User Offline</label>';
    
    // Für individual User ausgaben
    // *********************************************************************
    $isShowCSS = ' style="display:none;"';

    $return .= '<div id="vFrontShowOnlyByIndividual"'.$isShowCSS.'>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

    $return .= '<input type="hidden" name="vFrontHpSeUserRechtSeiten" id="vFrontHpSeUserRechtSeiten" />';
    $return .= '<input type="hidden" name="vFrontHpSeUserRechtBildKategorien" id="vFrontHpSeUserRechtBildKategorien" />';

    $return .= '<div class="vFrontFrmListHolder" data-field="vFrontHpSeUserRechtSeiten" style="width:342px;">
       <div class="vFrontFrmListHolderHeader" style="background-color:#555;">
         <div class="vFrontFrmListHolderHeaderUe">Erlaubte CMS Seiten</div>
         <div class="vFrontFrmListHolderHeaderAdd"></div>
         <div class="vFrontFrmListHolderHeaderDel"></div>
       </div>
       <div class="vFrontFrmListHolderLists"></div>
     </div>';

    $return .= '<div class="vFrontFrmAbstand"></div>
                <div class="vFrontFrmAbstand"></div>';

    $return .= '<div class="vFrontFrmListHolder" data-field="vFrontHpSeUserRechtBildKategorien" style="width:342px;">
       <div class="vFrontFrmListHolderHeader" style="background-color:#555;">
         <div class="vFrontFrmListHolderHeaderUe">Erlaubte Bilder Kategorien</div>
         <div class="vFrontFrmListHolderHeaderAdd"></div>
         <div class="vFrontFrmListHolderHeaderDel"></div>
       </div>
       <div class="vFrontFrmListHolderLists"></div>
     </div>';

    $return .= '</div>';
    // *********************************************************************
    
    $return .= '<div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontHpSeUserName">User Name:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="text" name="vFrontHpSeUserName" id="vFrontHpSeUserName" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontHpSeUserPass">User Passwort:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="password" name="vFrontHpSeUserPass" id="vFrontHpSeUserPass" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontHpSeUserPassSecond">User Passwort wiederholen:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="password" name="vFrontHpSeUserPassSecond" id="vFrontHpSeUserPassSecond" />

         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:150px;" type="submit" value="Speichern" id="vFrontSaveHpSeNewUser" />
         <input style="width:150px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCancelHpSeNewUser" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showHpSeBearUserForms($userID) {
    $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">User bearbeiten</div>';
    
    $sqlText = 'SELECT * FROM vuser WHERE userID = ' . $this->dbDecode($userID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowUser = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      // Für Rechte Json Decode
      // ***********************************
      $seitenRechtVar = '';
      $kategorienRechteVar = '';
      if (isset($rowUser['userRechte']) && $rowUser['userRechte'] == 3) {
        if (isset($rowUser['userRechtJSON']) && !empty($rowUser['userRechtJSON'])) {
          $arrJsonRechte = json_decode($rowUser['userRechtJSON'], true);
          $seitenRechtVar = $arrJsonRechte['sites'];
          $kategorienRechteVar = $arrJsonRechte['categories'];
        }
      }
      // ***********************************
      
      $return .= '<div class="vFrontFrmHolder">';
      
      if ($rowUser['userID'] != 1) {
        $return .= '<label for="vFrontHpSeUserArt">User Art:</label>
             <div class="vFrontLblAbstand"></div>
             <select name="vFrontHpSeUserArt" id="vFrontHpSeUserArt">
              '.$this->getUserArtOptionsNow($rowUser['userRechte']).'
             </select>';
      
        $return .= '<div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>';

        if (isset($rowUser['userOnline']) && $rowUser['userOnline'] == 2) {
          $return .= '<input checked="checked" type="checkbox" name="vFrontHpSeUserOffline" id="vFrontHpSeUserOffline" /><label for="vFrontHpSeUserOffline">User Offline</label>';
        }
        else {
          $return .= '<input type="checkbox" name="vFrontHpSeUserOffline" id="vFrontHpSeUserOffline" /><label for="vFrontHpSeUserOffline">User Offline</label>';
        }
        
        // Für individual User ausgaben
        // *********************************************************************
        $isShowCSS = ' style="display:none;"';
        if (isset($rowUser['userRechte']) && $rowUser['userRechte'] == 3) {
          $isShowCSS = ' style="display:block;"';
        }
        
        $return .= '<div id="vFrontShowOnlyByIndividual"'.$isShowCSS.'>';
        
        $return .= '<div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
        
        $return .= '<input type="hidden" name="vFrontHpSeUserRechtSeiten" id="vFrontHpSeUserRechtSeiten" value="'.$seitenRechtVar.'" />';
        $return .= '<input type="hidden" name="vFrontHpSeUserRechtBildKategorien" id="vFrontHpSeUserRechtBildKategorien" value="'.$kategorienRechteVar.'" />';
        
        $return .= '<div class="vFrontFrmListHolder" data-field="vFrontHpSeUserRechtSeiten" style="width:342px;">
           <div class="vFrontFrmListHolderHeader" style="background-color:#555;">
             <div class="vFrontFrmListHolderHeaderUe">Erlaubte CMS Seiten</div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->getUserRechtListsSeiten($seitenRechtVar).'</div>
         </div>';
        
        $return .= '<div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>';
        
        $return .= '<div class="vFrontFrmListHolder" data-field="vFrontHpSeUserRechtBildKategorien" style="width:342px;">
           <div class="vFrontFrmListHolderHeader" style="background-color:#555;">
             <div class="vFrontFrmListHolderHeaderUe">Erlaubte Bilder Kategorien</div>
             <div class="vFrontFrmListHolderHeaderAdd"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->getUserRechtListsKategorien($kategorienRechteVar).'</div>
         </div>';
        
        $return .= '</div>';
        // *********************************************************************
        
        $return .= '<div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>
                    <div class="vFrontFrmAbstand"></div>';
      }
      else {
        $return .= '<input type="hidden" name="vFrontHpSeUserArt" id="vFrontHpSeUserArt" value="1" />';
        $return .= '<input style="display:none;" type="checkbox" name="vFrontHpSeUserOffline" id="vFrontHpSeUserOffline" />';
        $return .= '<input type="hidden" name="vFrontHpSeUserRechtSeiten" id="vFrontHpSeUserRechtSeiten" value="'.$seitenRechtVar.'" />';
        $return .= '<input type="hidden" name="vFrontHpSeUserRechtBildKategorien" id="vFrontHpSeUserRechtBildKategorien" value="'.$kategorienRechteVar.'" />';
      }

      $return .= '<label for="vFrontHpSeUserName">User Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontHpSeUserName" id="vFrontHpSeUserName" value="' . $rowUser['userName'] . '" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

      $return .= '<label for="vFrontHpSeUserPass">User Passwort ändern:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="password" name="vFrontHpSeUserPass" id="vFrontHpSeUserPass" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

      $return .= '<label for="vFrontHpSeUserPassSecond">User Passwort wiederholen:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="password" name="vFrontHpSeUserPassSecond" id="vFrontHpSeUserPassSecond" />

           <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';

      $return .= '<div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <div class="vFrontFrmAbstand"></div>
           <input style="width:150px;" type="submit" value="Speichern" id="vFrontSaveHpSeChangeUser" data-id="'.$userID.'" />
           <input style="width:150px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCancelHpSeChangeUser" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getUserArtOptionsNow($isCheck = '') {
    $artArr = array(
      '2' => 'Standard User',
      '1' => 'Super User',
      '3' => 'Individual User',
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
  
  
  
  private function getUserRechtListsSeiten($siteLists) {
    $return = '';
    if (isset($siteLists) && !empty($siteLists)) {
      $allListArr = explode(';', $siteLists);
      foreach ($allListArr as $list) {
        $sqlText = 'SELECT seitName FROM vseiten WHERE seitID = '.$this->dbDecode($list).' LIMIT 1';
        $sqlErg = $this->dbAbfragen($sqlText);
        while ($rowU = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontListElemIUser" data-id="'.$list.'">'.$rowU['seitName'].'</div>';
        }
      }
    }
    
    return $return;
  }
  
  
  
  private function getUserRechtListsKategorien($katLists) {
    $return = '';
    if (isset($katLists) && !empty($katLists)) {
      $allListArr = explode(';', $katLists);
      foreach ($allListArr as $list) {
        $sqlText = 'SELECT katName FROM vbildkategorie WHERE katID = '.$this->dbDecode($list).' LIMIT 1';
        $sqlErg = $this->dbAbfragen($sqlText);
        while ($rowU = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontListElemIUser" data-id="'.$list.'">'.$rowU['katName'].'</div>';
        }
      }
    }
    
    return $return;
  }
  
  
  
  public function saveNewUserDataNow() {
    $rechtJSON = '';
    if (isset($_POST['_userArt']) && $_POST['_userArt'] == 3) {
      $zwJson = array();
      $zwJson['sites'] = $_POST['_userSeitenRechte'];
      $zwJson['categories'] = $_POST['_userKategorienRechte'];
      $rechtJSON = json_encode($zwJson);
    }
    
    $sqlText = 'INSERT INTO vuser (userOnline, userName, userPass, userRechte, userRechtJSON, userDel, hpID) VALUES (' . $this->dbDecode($_POST['_userOffline']) . ', "' . $this->dbDecode($_POST['_userName']) . '", "' . sha1($_POST['_userPass']) . '", "' . $this->dbDecode($_POST['_userArt']) . '", "' . $this->dbDecode($rechtJSON) . '", 1, "' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . '")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function saveBearUserDataNow() {
    $rechtJSON = '';
    if (isset($_POST['_userArt']) && $_POST['_userArt'] == 3) {
      $zwJson = array();
      $zwJson['sites'] = $_POST['_userSeitenRechte'];
      $zwJson['categories'] = $_POST['_userKategorienRechte'];
      $rechtJSON = json_encode($zwJson);
    }
    
    $sqlText = 'UPDATE vuser SET 
          userOnline = ' . $this->dbDecode($_POST['_userOffline']) . ', 
          userName = "' . $this->dbDecode($_POST['_userName']) . '", ';
    if (isset($_POST['_userPass']) && !empty($_POST['_userPass'])) {
      $sqlText .= 'userPass = "' . sha1($_POST['_userPass']) . '", ';
    }
    $sqlText .= 'userRechtJSON = "' . $this->dbDecode($rechtJSON) . '", ';
    $sqlText .= 'userRechte = "' . $this->dbDecode($_POST['_userArt']) . '" ';
    $sqlText .= 'WHERE userID = ' . $this->dbDecode($_POST['_curUserID']);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showHpSeUserIndividualSiteList($depp = 0, $parentID = 0, $nartID = 1) {
    $return = '';
    if ($depp < 1) {
      $return .= $this->getHpSeUserIndividualSiteListNaviArtsSelect($nartID);
      $return .= '<div class="vFrontSeitenAuflistungAuswahl" style="margin-top:-34px;">';
      $return .= '<div id="vFrontListButtonSelectedNow">auswählen</div>';
    }
    
    if ($depp < 5) {
      $sqlTextSeitBaum = 'SELECT seitID, seitArt, seitNaviName, seitName, seitOnline, seitNoNavi, seitTextUrl FROM vseiten WHERE seitParent = ' . $this->dbDecode($parentID) . ' AND hpID = ' . $this->dbDecode($_SESSION['VCMS_HP_ID']) . ' AND nartID = ' . $this->dbDecode($nartID) . ' ORDER BY seitPosition ASC';
      $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);
      
      $return .= '<div class="vFrontSeitenBaumHolder">';

      while ($rowSeitBaum = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
        $curImgClass = 'vFrontIsSiteCur';
        if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 2) {
          $curImgClass = 'vFrontIsBlogCur';
        }
        else if (isset($rowSeitBaum['seitArt']) && $rowSeitBaum['seitArt'] == 3) {
          $curImgClass = 'vFrontIsNaviCur';
        }
        
        $curSiteIsOnline = ' vFrontBaumOnline';
        if (isset($rowSeitBaum['seitOnline']) && $rowSeitBaum['seitOnline'] == 2) {
          $curSiteIsOnline = ' vFrontBaumOffline';
        }
        
        $curSiteIsOnNavi = ' vFrontBaumOnNavi';
        if (isset($rowSeitBaum['seitNoNavi']) && $rowSeitBaum['seitNoNavi'] == 2) {
          $curSiteIsOnNavi = ' vFrontBaumNoNavi';
        }
        
        $return .= '<div class="soElems vFrontSeitBaumElem' . $depp . '" id="s' . $rowSeitBaum['seitID'] . '">';
        
        $curSiteBaumName = $rowSeitBaum['seitName'];
        
        $return .= '<div class="vFrontBaumElem ' . $curImgClass . $curSiteIsOnline . $curSiteIsOnNavi . '" data-id="' . $rowSeitBaum['seitID'] . '" data-name="' . $rowSeitBaum['seitName'] . '">' . $curSiteBaumName;
        
        $return .= '</div>';
        $return .= $this->showHpSeUserIndividualSiteList($depp + 1, $rowSeitBaum['seitID'], $nartID);
        $return .= '</div>';
      }

      $return .= '</div>';
      
      if ($depp < 1) {
        $return .= '</div>';
      }
      
      return $return;
    }
  }
  
  
  
  private function getHpSeUserIndividualSiteListNaviArtsSelect($selectedNartID) {
    $return = '';
    
    $return .= '<div class="vFrontSeitenAuflistungAuswahlNaviArtHolder"><label>Navigationsart:</label>
    <select id="vFrontSeitenAuflistungAuswahlNaviArtSelect" name="vFrontSeitenAuflistungAuswahlNaviArtSelect">';
    
    $sqlNavArtText = 'SELECT * FROM vnaviart';
    $sqlNavArtErg = $this->dbAbfragen($sqlNavArtText);
    
    while ($rowNavArt = mysql_fetch_array($sqlNavArtErg, MYSQL_ASSOC)) {
      if ($rowNavArt['nartID'] == $selectedNartID) {
        $return .= '<option selected="selected" value="' . $rowNavArt['nartID'] . '">' . $rowNavArt['nartName'] . '</option>';
      }
      else {
        $return .= '<option value="' . $rowNavArt['nartID'] . '">' . $rowNavArt['nartName'] . '</option>';
      }
    }
    
    $return .= '</select>
    </div>';
    
    return $return;
  }
  
  
  
  public function showHpSeUserIndividualKategorieList($depp = 0, $parentKat = 0) {
    $return = '';
    if ($depp < 1) {
      $return .= '<div class="vFrontSeitenAuflistungAuswahl vFrontKategorienAuflistungAuswahl">';
      $return .= '<div id="vFrontListButtonSelectedNow">auswählen</div>';
    }
    
    if ($depp < 2) {
      $sqlTextSeitBaum = 'SELECT * FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($parentKat) . ' ORDER BY katName ASC';
      $sqlErgSeitBaum = $this->dbAbfragen($sqlTextSeitBaum);
      
      $return .= '<div class="vFrontSeitenBaumHolder">';

      while ($rowKatBaum = mysql_fetch_array($sqlErgSeitBaum, MYSQL_ASSOC)) {
        $curImgClass = 'vFrontIsSiteCur';
        
        $return .= '<div class="soElems vFrontSeitBaumElem' . $depp . '">';
        
        $curKatBaumName = $rowKatBaum['katName'];
        
        $return .= '<div class="vFrontBaumElem ' . $curImgClass . '" data-id="' . $rowKatBaum['katID'] . '" data-name="' . $rowKatBaum['katName'] . '">' . $curKatBaumName;
        
        $return .= '</div>';
        $return .= $this->showHpSeUserIndividualKategorieList($depp + 1, $rowKatBaum['katID']);
        $return .= '</div>';
      }
      
      $return .= '</div>';
    }
    
    if ($depp < 1) {
        $return .= '</div>';
      }
      
      return $return;
  }
  
  
  
  public function delHpSeThisUserNow($curUserId) {
    $sqlText = 'UPDATE vuser SET 
          userDel = 2 ';
    $sqlText .= 'WHERE userID = ' . $this->dbDecode($curUserId);
    return $this->dbAbfragen($sqlText);
  }

  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Userverwaltung
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Navigationsarten
  // ***************************************************************************
  
  private function getHpSettingsNaviArts() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= $this->getHpSeNavigationsartListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeNavigationsartListNow() {
    $return = '<div class="vFrontHpSeAuflistungUnUe">Navigationsarten</div>';
    $return .= '<div id="vFrontNeueNaviArtInCmsBtn">Neue Navigationsart</div><div class="clearer"></div>';
    
    $sqlTextS = 'SELECT * FROM vnaviart';
    $sqlErgS = $this->dbAbfragen($sqlTextS);
    
    while($rowElE = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontHpSeAuflistungLiNaviArt">';
      $return .= '<div class="vFrontHpSeAuflistungLiNaviArtName">' . $rowElE['nartName'] . '</div>';
      $return .= '<div class="vFrontHpSeAuflistungLiNaviArtChange" data-id="' . $rowElE['nartID'] . '" title="Bearbeiten"></div>';
      if ($rowElE['nartID'] != 1) {
        $return .= '<div class="vFrontHpSeAuflistungLiNaviArtDel" data-id="' . $rowElE['nartID'] . '" title="Löschen"></div>';
      }
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function showHpSeNewNaviArtFormsWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vNaviArtFrmName">Name:</label>
                <input maxlength="100" type="text" name="vNaviArtFrmName" id="vNaviArtFrmName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveNewNaviArtForms" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeNewNaviArt($naviArtName) {
    $sqlText = 'INSERT INTO vnaviart (nartName) VALUES ("' . $this->dbDecode($naviArtName) . '")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delHpSeThisNaviArt($nartID) {
    $sqlText = 'DELETE FROM vnaviart WHERE nartID = ' . $this->dbDecode($nartID);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function showHpSeBearNaviArtFormsWindow($nartID) {
    $return = '';
    $sqlText = 'SELECT * FROM vnaviart WHERE nartID = ' . $this->dbDecode($nartID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
    
      $return .= '<div class="vFrontSmallSeFrmHolder">';

      $return .= '<label for="vNaviArtFrmName">Name:</label>
                  <input maxlength="100" type="text" name="vNaviArtFrmName" id="vNaviArtFrmName" value="'.$row['nartName'].'" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vFrontSaveBearNaviArtForms" data-id="'.$nartID.'" />';

      $return .= '</div>';
    
    }
    
    return $return;
  }
  
  
  
  public function saveHpSeBearNaviArt($nartID, $nartName) {
    $sqlText = 'UPDATE vnaviart SET nartName = "'.$this->dbDecode($nartName).'" WHERE nartID = ' . $this->dbDecode($nartID);
    return $this->dbAbfragen($sqlText);
  }

  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Navigationsarten
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Sprachen
  // ***************************************************************************
  
  private function getHpSettingsSprachen() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= $this->getHpSeSprachenListNow();
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getHpSeSprachenListNow() {
    $return = '<div class="vFrontHpSeAuflistungUnUe">Sprachen</div>';
    $return .= '<div id="vFrontNeueSpracheBtn">Neue Sprache</div><div class="clearer"></div>';
    
    $sqlTextL = 'SELECT * FROM vsprachen';
    $sqlErgL = $this->dbAbfragen($sqlTextL);
    
    while($rowElE = mysql_fetch_array($sqlErgL, MYSQL_ASSOC)) {
      $curBack = '';
      if (isset($rowElE['langAktiv']) && $rowElE['langAktiv'] == 2) {
        $curBack = ' vFrontHpSeListHidden';
      }
      $return .= '<div class="vFrontHpSeAuflistungLiSprach' . $curBack . '">';
      $return .= '<div class="vFrontHpSeAuflistungLiSprachName">' . $rowElE['langName'] . ' (' . $rowElE['langKurzName'] . ')</div>';
      if (isset($rowElE['langStandard']) && $rowElE['langStandard'] == 2) {
        $return .= '<div class="vFrontHpSeAuflistungLiSprachChange" data-id="' . $rowElE['langID'] . '" title="Bearbeiten"></div>';
        $return .= '<div class="vFrontHpSeAuflistungLiSprachDel" data-id="' . $rowElE['langID'] . '" title="Löschen"></div>';
      }
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function showHpSeNewSpracheForms() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vSpracheFrmName">Name:</label>
                <input maxlength="100" type="text" name="vSpracheFrmName" id="vSpracheFrmName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vSpracheFrmKurzName">Url Name:</label>
                <input maxlength="2" type="text" name="vSpracheFrmKurzName" id="vSpracheFrmKurzName" style="width:60px;" /> (z.B. en)';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vSpracheFrmOffline">Offline:</label>
                <input type="checkbox" name="vSpracheFrmOffline" id="vSpracheFrmOffline" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveNewSpracheForms" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeNewNewSpracheNow($langName, $langUrlName, $langOnline) {
    if (!$this->checkHpSeLangUrlNameExists($langUrlName)) {
      $sqlLangText = 'INSERT INTO vsprachen (langName, langKurzName, langAktiv, langStandard) VALUES ("' . $this->dbDecode($langName) . '", "' . $this->dbDecode($langUrlName) . '", ' . $this->dbDecode($langOnline) . ', 2)';
      $sqlLangErg = $this->dbAbfragen($sqlLangText);
      if ($sqlLangErg) {
        return 'ok';
      }
      else {
        return 'fehler';
      }
    }
    else {
      return 'noUrl';
    }
  }
  
  
  
  private function checkHpSeLangUrlNameExists($langUrlName, $curLangId = '') {
    if (isset($curLangId) && !empty($curLangId)) {
      $sqlCheckText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" AND langID <> ' . $this->dbDecode($curLangId) . ' LIMIT 1';
    }
    else {
      $sqlCheckText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUrlName) . '" LIMIT 1';
    }
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckNum = mysql_num_rows($sqlCheckErg);
    if ($sqlCheckNum > 0) {
      return true;
    }
    return false;
  }
  
  
  
  public function delHpSeThisSpracheNow($langID) {
    $sqlDelText = 'DELETE FROM vsprachen WHERE langID = ' . $this->dbDecode($langID);
    return $this->dbAbfragen($sqlDelText);
  }
  
  
  
  public function showHpSeChangeLanguageForms($curLangId) {
    $return = '<div class="vFrontSmallSeFrmHolder" data-id="' . $curLangId . '">';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langID = ' . $this->dbDecode($curLangId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgNum = mysql_num_rows($sqlErg);
    
    if ($sqlErgNum == 1) {
      while ($rowL = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        $return .= '<label for="vSpracheFrmName">Name:</label>
                    <input maxlength="100" type="text" name="vSpracheFrmName" id="vSpracheFrmName" value="' . $rowL['langName'] . '" />';

        $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

        $return .= '<label for="vSpracheFrmKurzName">Url Name:</label>
                    <input maxlength="2" type="text" name="vSpracheFrmKurzName" id="vSpracheFrmKurzName" style="width:60px;" value="' . $rowL['langKurzName'] . '" /> (z.B. en)';

        $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

        $return .= '<label for="vSpracheFrmOffline">Offline:</label>';
        if (isset($rowL['langAktiv']) && $rowL['langAktiv'] == 2) {
          $return .= '<input checked="checked" type="checkbox" name="vSpracheFrmOffline" id="vSpracheFrmOffline" />';
        }
        else {
          $return .= '<input type="checkbox" name="vSpracheFrmOffline" id="vSpracheFrmOffline" />';
        }

        $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

        $return .= '<input type="submit" value="Speichern" id="vFrontSaveChangeSpracheForms" data-id="' . $rowL['langID'] . '" />';
      }
    }
    else {
      $return .= 'Fehler';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeChangeSpracheNow($curLangId, $langName, $langUrlName, $langOnline) {
    if (!$this->checkHpSeLangUrlNameExists($langUrlName, $curLangId)) {
      $sqlLangText = 'UPDATE vsprachen SET 
              langName = "' . $this->dbDecode($langName) . '", 
              langKurzName = "' . $this->dbDecode($langUrlName) . '", 
              langAktiv = ' . $this->dbDecode($langOnline) . ' 
              WHERE langID = ' . $this->dbDecode($curLangId);
      $sqlLangErg = $this->dbAbfragen($sqlLangText);
      if ($sqlLangErg) {
        return 'ok';
      }
      else {
        return 'fehler';
      }
    }
    else {
      return 'noUrl';
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Sprachen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Module
  // ***************************************************************************
  
  private function getHpSettingsModuleVerwaltung() {
    $miniShopModulClass = '';
    $responsivWebModulClass = '';
    $empfehlungManagerModulClass = '';
    $kontaktFormularBuilderModulClass = '';
    $filterSystemModulClass = '';
    
    if ($this->checkIsShopModulActiv()) {
      $miniShopModulClass = ' vFrontIsInstallModuleOk';
    }
    if ($this->checkIsThisModuleActive('responsivWebModul')) {
      $responsivWebModulClass = ' vFrontIsInstallModuleOk';
    }
    if ($this->checkIsThisModuleActive('empfehlungManagerModul')) {
      $empfehlungManagerModulClass = ' vFrontIsInstallModuleOk';
    }
    if ($this->checkIsThisModuleActive('kontaktFormularBuilderModul')) {
      $kontaktFormularBuilderModulClass = ' vFrontIsInstallModuleOk';
    }
    if ($this->checkIsThisModuleActive('filterSystemModul')) {
      $filterSystemModulClass = ' vFrontIsInstallModuleOk';
    }
    
    if ($this->checkIsThisModuleActive('OrderModul')) {
      $OrderModulClass = ' vFrontIsInstallModuleOk';
    }
    
    
    $return = '<div class="vFrontHpSeAuflistung">';
    
      $return .= '<div class="vFrontHpSeAuflistungUnUe">Erweiterungen</div>';

      $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$miniShopModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Mini Shop Modul</div>';
      if (isset($miniShopModulClass) && !empty($miniShopModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Mini Shop Modul" data-name="miniShopModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Mini Shop Modul" data-name="miniShopModul" title="Installieren"></div>';
      }
      $return .= '</div>';

      $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$responsivWebModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Responsiv Webseite</div>';
      if (isset($responsivWebModulClass) && !empty($responsivWebModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Responsiv Webseite" data-name="responsivWebModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Responsiv Webseite" data-name="responsivWebModul" title="Installieren"></div>';
      }
      $return .= '</div>';

      $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$empfehlungManagerModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Empfehlungs Manager</div>';
      if (isset($empfehlungManagerModulClass) && !empty($empfehlungManagerModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Empfehlungs Manager" data-name="empfehlungManagerModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Empfehlungs Manager" data-name="empfehlungManagerModul" title="Installieren"></div>';
      }
      $return .= '</div>';

      $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$kontaktFormularBuilderModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Kontaktformular Builder</div>';
      if (isset($kontaktFormularBuilderModulClass) && !empty($kontaktFormularBuilderModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Kontaktformular Builder" data-name="kontaktFormularBuilderModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Kontaktformular Builder" data-name="kontaktFormularBuilderModul" title="Installieren"></div>';
      }
      $return .= '</div>';

      $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$filterSystemModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Filtersystem</div>';
      if (isset($filterSystemModulClass) && !empty($filterSystemModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Filtersystem" data-name="filterSystemModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Filtersystem" data-name="filterSystemModul" title="Installieren"></div>';
      }
      $return .= '</div>';
      
         $return .= '<div class="vFrontHpSeAuflistungLiModule vFrontHpSeAuflistungModuleMM'.$OrderModulClass.'">';
      $return .= '<div class="vFrontHpSeAuflistungLiModuleName">Orders system</div>';
      if (isset($OrderModulClass) && !empty($OrderModulClass)) {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleDeInstall" data-curname="Ordersystem" data-name="OrderSystemModul" title="Deinstallieren"></div>';
      }
      else {
        $return .= '<div class="vFrontHpSeAuflistungLiModuleInstall" data-curname="Ordersystem" data-name="OrderSystemModul" title="Installieren"></div>';
      }
      $return .= '</div>';
    
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Module
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Einstellungen Sitemap Generator
  // ***************************************************************************
  
  private function getHpSettingsSitemapGenerator() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $return .= '<div class="vFrontHpSeAuflistungUnUe">Sitemap Generator (XML File)</div>';
    
    $return .= '<div class="vFrontSitemapGeneratorHolder">';
    $return .= '<div id="vFrontSitemapGeneratorSendBtn">Neue Sitemap generieren</div>';
    $return .= '<span id="vFrontSitemapGeneratorLoader"><img style="vertical-align:middle;" src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" />&nbsp;&nbsp;&nbsp;Die Sitemap Datei wird generiert...</span>';
    $return .= '<span id="vFrontSitemapGeneratorOkGenerate"><img width="36" style="vertical-align:middle;" src="admin/frontAdmin/img/cmsOk.png" alt="ok" title="" />&nbsp;&nbsp;&nbsp;Die Sitemap Datei wurde erfolgreich erstellt.</span>';
    $return .= '<div id="vFrontSitemapGeneratorShowUri"></div>';
    $return .= '<div></div>';
    $return .= '<input type="hidden" id="vFrontAusgabeSitemapCurPath" value="'.str_replace('admin/frontAdmin/ajax_php/ajax.php', '', getHrefPath()).'" />';
    $return .= '<textarea id="vFrontAusgabeSitemapFile" readonly="readonly"></textarea>';
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }

  // ***************************************************************************
  // ENDE - Funktionen für Einstellungen Sitemap Generator
  // ***************************************************************************
  
  
  
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Seitenlayouts Seitenfelder
  // ***************************************************************************
  
  public function buildSeitenlayoutFelderList($layId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfelder WHERE layID = ' . $this->dbDecode($layId) . ' ORDER BY feldPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curListElemClass = ' vFrontFrmHolderHpSeRowFieldsListInElem'.$row['feldArt'];
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsListInElem'.$curListElemClass.'" data-id="'.$row['feldID'].'">';
      $return .= $row['feldLabel'].' <span style="font-size:10px;">('.$row['feldName'].')</span>';
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsListInElemBtnHolder">';
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsListInElemChangeBtn" data-id="'.$row['feldID'].'" data-layid="'.$layId.'" title="Bearbeiten"></div>';
      $return .= '<div class="vFrontFrmHolderHpSeRowFieldsListInElemDelBtn" data-id="'.$row['feldID'].'" data-layid="'.$layId.'" title="Löschen"></div>';
      $return .= '<div class="clearer"></div></div>';
      $return .= '</div>';
    }
    
    if ($sqlErgCount < 1) {
      $return .= 'Es sind keine Felder vorhanden.';
    }
    
    return $return;
  }
  
  
  
  public function showHpSeSeitenlayoutsNewFeldWindow($curLayId) {
    $return = '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahl">';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlUe">Feld Art auswählen</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="1">Separator</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="2">Textfeld</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="3">Textarea</div>';
    $return .= '<div class="clearer vFrontHpSeSeitenlayoutFelderArtAuswahlAbstand"></div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="4">Textarea <span style="font-size:11px;">(Editor)</span></div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="5">Checkbox</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="6">Drop Down</div>';
    $return .= '<div class="clearer vFrontHpSeSeitenlayoutFelderArtAuswahlAbstand"></div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="12">Datumfeld </div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="7">Bild einzeln</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="8">Bild multi</div>';
    $return .= '<div class="clearer vFrontHpSeSeitenlayoutFelderArtAuswahlAbstand"></div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="9">Datei einzeln</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="10">Datei multi</div>';
    $return .= '<div class="vFrontHpSeSeitenlayoutFelderArtAuswahlBtn" data-layid="'.$curLayId.'" data-art="11">Seiten Relation</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showHpSeSeitenlayoutsNewFeldWindowCurForms($curLayId, $curFeldArtId) {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vSeitLayFeldFrmDataName">Dataname:</label>
                <input maxlength="100" type="text" name="vSeitLayFeldFrmDataName" id="vSeitLayFeldFrmDataName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vSeitLayFeldFrmLabel">Label:</label>
                <input maxlength="100" type="text" name="vSeitLayFeldFrmLabel" id="vSeitLayFeldFrmLabel" />';
    
    if ($curFeldArtId == 6) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vSeitLayFeldFrmConfig">Options:</label>
                  <input type="text" name="vSeitLayFeldFrmConfig" id="vSeitLayFeldFrmConfig" />';
    }
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vSeitLayFeldFrmSaveBtn" data-art="'.$curFeldArtId.'" data-layid="'.$curLayId.'" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveHpSeSeitenlayoutsNewFeldWindowNow($curLayId, $curFeldArtId) {
    if ($this->checkHpSeSeitenlayoutsNewFeldSaveDataName($curLayId, $_POST['_dataName'])) {
      $curFeldPosition = $this->buildNewSeitenlayoutFeldPositionNow($curLayId);
      $curFeldConfig = '';
      if (isset($curFeldArtId) && $curFeldArtId == 6) {
        $curFeldConfig = $_POST['_feldOptions'];
      }

      $sqlText = 'INSERT INTO vfelder (feldArt, feldName, feldLabel, feldConfig, feldPosition, layID) VALUES ("'.$this->dbDecode($curFeldArtId).'", "'.$this->dbDecode($_POST['_dataName']).'", "'.$this->dbDecode($_POST['_labelName']).'", "'.$this->dbDecode($curFeldConfig).'", "'.$this->dbDecode($curFeldPosition).'", "'.$this->dbDecode($curLayId).'")';
      return $this->dbAbfragen($sqlText);
    }
    else {
      return 'dataname';
    }
  }
  
  
  
  public function saveHpSeSeitenlayoutsBearFeldWindowNow($curFeldId, $curFeldArtId, $curLayId) {
    if ($this->checkHpSeSeitenlayoutsNewFeldSaveDataName($curLayId, $_POST['_dataName']) || $_POST['_dataName'] == $_POST['_dataNameOld']) {
      $curFeldConfig = '';
      if (isset($curFeldArtId) && $curFeldArtId == 6) {
        $curFeldConfig = $_POST['_feldOptions'];
      }
      
      $sqlText = 'UPDATE vfelder SET feldName = "'.$this->dbDecode($_POST['_dataName']).'", feldLabel = "'.$this->dbDecode($_POST['_labelName']).'", feldConfig = "'.$this->dbDecode($curFeldConfig).'" WHERE feldID = "'.$this->dbDecode($curFeldId).'" AND layID = "'.$this->dbDecode($curLayId).'"';
      return $this->dbAbfragen($sqlText);
    }
    else {
      return 'dataname';
    }
  }
  
  
  
  private function checkHpSeSeitenlayoutsNewFeldSaveDataName($curLayId, $dataName) {
    $sqlText = 'SELECT feldID FROM vfelder WHERE feldName = "'.$this->dbDecode($dataName).'" AND layID = "'.$this->dbDecode($curLayId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if (isset($sqlErgCount) && $sqlErgCount < 1) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  private function buildNewSeitenlayoutFeldPositionNow($curLayId) {
    $sqlText = 'SELECT layID FROM vfelder WHERE layID = ' . $this->dbDecode($curLayId);
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlCount = mysql_num_rows($sqlErg);
    
    return $sqlCount + 1;
  }
  
  
  
  public function setSortSeitenlayoutsFieldsNew($curLayId, $allElemsList) {
    if (isset($allElemsList) && !empty($allElemsList)) {
      $allElemsListArr = explode(';', $allElemsList);
      $allElemsListCount = 0;
      foreach ($allElemsListArr as $elem) {
        $allElemsListCount++;
        $sqlText = 'UPDATE vfelder SET feldPosition = "'.$this->dbDecode($allElemsListCount).'" WHERE feldID = "'.$this->dbDecode($elem).'"';
        $sqlErg = $this->dbAbfragen($sqlText);
      }
    }
  }
  
  
  
  public function delHpSeSeitenlayoutsFieldNow($curLayId, $curFieldID) {
    if ($this->delHpSeSeitenlayoutsFieldSeitenfelderNow($curFieldID)) {
      $sqlText = 'DELETE FROM vfelder WHERE feldID = "'.$this->dbDecode($curFieldID).'"';
      $sqlErg = $this->dbAbfragen($sqlText);
      return $sqlErg;
    }
  }
  
  
  
  private function delHpSeSeitenlayoutsFieldSeitenfelderNow($curFieldID) {
    $sqlText = 'SELECT sfeldID FROM vseitenfelder WHERE feldID = "'.$this->dbDecode($curFieldID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $sqlDelText = 'DELETE FROM vseitenfelderlang WHERE sfeldID = "'.$this->dbDecode($row['sfeldID']).'"';
      $sqlDelErg = $this->dbAbfragen($sqlDelText);
    }
    
    $sqlDelFText = 'DELETE FROM vseitenfelder WHERE feldID = "'.$this->dbDecode($curFieldID).'"';
    $sqlDelFErg = $this->dbAbfragen($sqlDelFText);
    
    return true;
  }
  
  
  
  public function showHpSeSeitenlayoutsBearFeldWindow($curLayId, $curFieldID) {
    $return = '';
    $curFieldDataArr = $this->getHpSeSeitenlayoutsBearFeldDataNow($curLayId, $curFieldID);
    
    if (isset($curFieldDataArr) && is_array($curFieldDataArr)) {
      $return .= '<div class="vFrontSmallSeFrmHolder">';
      
      $return .= '<input type="hidden" name="vSeitLayFeldFrmDataNameOldBear" id="vSeitLayFeldFrmDataNameOldBear" value="'.$curFieldDataArr['feldName'].'" />';
    
      $return .= '<label for="vSeitLayFeldFrmDataName">Dataname:</label>
                  <input maxlength="100" type="text" name="vSeitLayFeldFrmDataName" id="vSeitLayFeldFrmDataName" value="'.$curFieldDataArr['feldName'].'" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vSeitLayFeldFrmLabel">Label:</label>
                  <input maxlength="100" type="text" name="vSeitLayFeldFrmLabel" id="vSeitLayFeldFrmLabel" value="'.$curFieldDataArr['feldLabel'].'" />';

      if (isset($curFieldDataArr['feldArt']) && $curFieldDataArr['feldArt'] == 6) {
        $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

        $return .= '<label for="vSeitLayFeldFrmConfig">Options:</label>
                    <input type="text" name="vSeitLayFeldFrmConfig" id="vSeitLayFeldFrmConfig" value="'.$curFieldDataArr['feldConfig'].'" />';
      }

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vSeitLayFeldFrmBearSaveBtn" data-layid="'.$curFieldDataArr['layID'].'" data-art="'.$curFieldDataArr['feldArt'].'" data-id="'.$curFieldDataArr['feldID'].'" />';

      $return .= '</div>';
    }
    else {
      return '<div style="margin:30px;">ERROR: No Field Data Found</div>';
    }
    
    return $return;
  }
  
  
  
  private function getHpSeSeitenlayoutsBearFeldDataNow($curLayId, $curFieldID) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfelder WHERE feldID = '.$this->dbDecode($curFieldID).' AND layID = ' . $this->dbDecode($curLayId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Seitenlayouts Seitenfelder
  // ***************************************************************************
  
}

?>