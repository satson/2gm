<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsBilder extends funktionsSammlung {
  
  public function getThePictureVerwaltung() {
    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = 0;
    
    $return = '';
    
    $return .= '<div class="vFrontImgKatHolder">';
    $return .= $this->getImageKategorien();
    $return .= '</div>';
    
    $return .= '<div class="vFrontImgVerwaltHolder">';
    $return .= $this->getImageElements();
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function reloadOnlyBildverwaltungKatNow() {
    return $this->getImageKategorien();
  }
  
  
  
  public function showCurentPicKatImagesNow($curPicKatId) {
    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = $curPicKatId;
    return $this->getImageElements($curPicKatId);
  }
  
  
  
  public function getImageKategorien() {
    $return = '
      <div style="height:10px;"></div>
      <div style="font-weight:bold; font-size:12px;" class="vFrontKatElem vFrontKatElemAll vFrontKatElemActive" data-id="0" id="vKatPicVerwId0">Bilder</div>';
    
    $sqlKatText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
      $curKatIdsUserRecht = str_replace(';', ',', $_SESSION['VCMS_USER_RECHT_ARRAY']['categories']);
      $sqlKatText = 'SELECT * FROM vbildkategorie WHERE katID IN ('.$this->dbDecode($curKatIdsUserRecht).') ORDER BY katName ASC';
    }
    $sqlKatErg = $this->dbAbfragen($sqlKatText);
    
    while($rowKat = mysql_fetch_array($sqlKatErg, MYSQL_ASSOC)) {
      $return .= '<div style="font-weight:bold; font-size:12px;" class="vFrontKatElem" data-id="' . $rowKat['katID'] . '" id="vKatPicVerwId' . $rowKat['katID'] . '">' . $rowKat['katName'];
      
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
        $return .= '<div class="vFrontKatElemDelBtn" data-id="' . $rowKat['katID'] . '" title="Löschen"></div><div class="vFrontKatElemChangeBtn" data-id="' . $rowKat['katID'] . '" title="Bearbeiten"></div>';
      }
      
      $return .= '</div>';
      
      // Unter Kategorie anzeigen
      // *****************************************************
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
        $sqlKatUText = 'SELECT * FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($rowKat['katID']) . ' ORDER BY katName ASC';
        $sqlKatUErg = $this->dbAbfragen($sqlKatUText);
        $sqlKatUCount = mysql_num_rows($sqlKatUErg);

        if ($sqlKatUCount > 0) {
          $return .= '<div class="vFrontUnterKatElemAllHolderToogleBtn" data-id="'.$rowKat['katID'].'"></div>';
          $return .= '<div id="vFrontUnterKatElemAllHolderToogle'.$rowKat['katID'].'" class="vFrontUnterKatElemAllHolderToogleBilder" style="display:none;">';
        }

        while($rowKatU = mysql_fetch_array($sqlKatUErg, MYSQL_ASSOC)) {
          $return .= '<div style="margin-left:36px; font-size:12px;" class="vFrontKatElem" data-id="' . $rowKatU['katID'] . '" id="vKatPicVerwId' . $rowKatU['katID'] . '">' . $rowKatU['katName'] . '<div class="vFrontKatElemDelBtn" data-id="' . $rowKatU['katID'] . '" title="Löschen"></div><div class="vFrontKatElemChangeBtn" data-id="' . $rowKatU['katID'] . '" title="Bearbeiten"></div></div>';
        }

        if ($sqlKatUCount > 0) {
          $return .= '</div>';
        }
      }
      // *****************************************************
    }
    
    return $return;
  }
  
  
  
  public function getImageElements($curPicKatId = 0) {
    $return = '';
    
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3 && $curPicKatId == 0) {
      
    }
    else {
      $sqlImgText = 'SELECT * FROM vbilder WHERE bildKat = ' . $curPicKatId;
      $sqlImgErg = $this->dbAbfragen($sqlImgText);

      while ($rowImg = mysql_fetch_array($sqlImgErg)) {
        $curPicFile = $rowImg['bildFile'];
        if (isset($rowImg['bildFile']) && file_exists('../../../user_upload/thumb_200/' . $rowImg['bildFile'])) {
          $curPicFile = 'thumb_200/' . $rowImg['bildFile'];
        }
        $curPicFile = $curPicFile.'?noC='.time();

        $return .= '<div class="vFrontImgElement" data-id="'.$rowImg['bildID'].'">
            <div class="vFrontImgElementPic"><img src="user_upload/' . $curPicFile . '" alt="' . $rowImg['bildAlt'] . '" title="' . $rowImg['bildTitel'] . '" /></div>
            <div class="vFrontImgElementName">' . $rowImg['bildName'] . '</div>
            <div class="vFrontImgElementMenu">
              <div class="vFrontVerwPicElemDel" id="picDel' . $rowImg['bildID'] . '" title="Löschen"></div>
              <div class="vFrontVerwPicElemChange" id="picChange' . $rowImg['bildID'] . '" title="Bearbeiten"></div>
              <div class="vFrontVerwPicElemShow" title="Anzeigen" data-img="user_upload/' . $rowImg['bildFile'] . '"></div>
              <div class="clearer"></div>
            </div>
          </div>';
      }
    }
    
    $return .= '<div class="clearer" style="height:20px;"></div>';
    
    return $return;
  }

  











  // ***************************************************************************
  // ANFANG - Funktionen für Upload überprüfungen
  // ***************************************************************************
  
  public function checkIsImageFile($fileArr) {
    // Dateien die erlaubt sind
    //$allowed = array('png', 'jpg', 'gif','zip', 'pdf', 'tar', 'docx');
    $allowed = array('png', 'jpg', 'gif', 'jpeg');
    // Dateiendung erhalten
    $extension = pathinfo($fileArr['upl']['name'], PATHINFO_EXTENSION);
    
    if(!in_array(strtolower($extension), $allowed)){
      return false;
    }
    
    return true;
  }
  
  
  
  public function checkIsImageFilenameExists($filePath, $fileName) {
    if (file_exists($filePath.$fileName)) {
      return true;
    }
    return false;
  }

  // ***************************************************************************
  // ANFANG - Funktionen für Upload überprüfungen
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Upload Bilder in Datenbank speichern
  // ***************************************************************************
  
  public function saveNewUploadPicInDatabase($filename) {
    $sqlPicText = 'INSERT INTO vbilder (bildName, bildFile, bildKat) VALUES ("' . $this->dbDecode($filename) . '", "' . $this->dbDecode($filename) . '", ' . $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] . ')';
    return $this->dbAbfragen($sqlPicText);
  }

  // ***************************************************************************
  // ENDE - Funktionen für Upload Bilder in Datenbank speichern
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Bilder in Datenbank löschen
  // ***************************************************************************
  
  public function delThisPicNow($picID) {
    $sqlText = 'SELECT bildFile FROM vbilder WHERE bildID = ' . $this->dbDecode($picID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $bildFile = '';
    $bildPath = '../../../user_upload/';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $bildFile = $row['bildFile'];
    }
    
    if (isset($bildFile) && !empty($bildFile) && file_exists($bildPath.$bildFile)) {
      unlink($bildPath.$bildFile);
    }
    if (isset($bildFile) && !empty($bildFile) && file_exists($bildPath.'thumb_200/'.$bildFile)) {
      unlink($bildPath.'thumb_200/'.$bildFile);
    }
    if (isset($bildFile) && !empty($bildFile) && file_exists($bildPath.'thumb_400/'.$bildFile)) {
      unlink($bildPath.'thumb_400/'.$bildFile);
    }
    if (isset($bildFile) && !empty($bildFile) && file_exists($bildPath.'thumb_800/'.$bildFile)) {
      unlink($bildPath.'thumb_800/'.$bildFile);
    }
    
    $sqlDelText = 'DELETE FROM vbilder WHERE bildID = ' . $this->dbDecode($picID);
    return $sqlDelErg = $this->dbAbfragen($sqlDelText);
  }
  
  
  
  public function delMediaAllSelectedImagesNow($picElems) {
    $picElemsArr = explode(';', $picElems);
    foreach ($picElemsArr as $value) {
      $this->delThisPicNow($value);
    }
    return 'ok';
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Bilder in Datenbank löschen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Bilder Bearbeiten
  // ***************************************************************************
  
  public function showMediaPicOnceChangeWindow($curPicId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPic = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontSmallSeFrmHolder">';
      
      $zwFileNameArr = explode('.', $rowPic['bildFile']);
      $curFileType = '.' . $zwFileNameArr[(count($zwFileNameArr) - 1)];
      $curFileName = str_replace($curFileType, '', $rowPic['bildFile']);
      
      $return .= '<input type="hidden" name="vMediaPicFileNameType" id="vMediaPicFileNameType" value="' . $curFileType . '" />';

      $return .= '<label for="vMediaPicFileName">Dateiname:</label>
                  <input maxlength="200" type="text" name="vMediaPicFileName" id="vMediaPicFileName" value="' . $curFileName . '" /> ' . $curFileType;

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vMediaPicFileAlt">Alt Text:</label>
                  <input maxlength="150" type="text" name="vMediaPicFileAlt" id="vMediaPicFileAlt" value="' . $rowPic['bildAlt'] . '" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vMediaPicFileTitle">Title:</label>
                  <input maxlength="150" type="text" name="vMediaPicFileTitle" id="vMediaPicFileTitle" value="' . $rowPic['bildTitel'] . '" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vFrontSaveMediaPicBearOnce" data-id="' . $rowPic['bildID'] . '" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function saveMediaPicOnceChangeFileNow($curPicId, $curFileName, $curFileAlt, $curFileTitle) {
    $sqlTextCheck = 'SELECT bildFile FROM vbilder WHERE bildID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErgCheck = $this->dbAbfragen($sqlTextCheck);
    $countCheck = 0;
    $bildOrigFile = '';
    
    $curFileName = strtolower($curFileName);
    
    while ($rowCheck = mysql_fetch_array($sqlErgCheck, MYSQL_ASSOC)) {
      $countCheck++;
      $bildOrigFile = $rowCheck['bildFile'];
    }
    
    if ($countCheck < 1 || empty($bildOrigFile)) {
      return 'fehler';
    }
    
    if ($bildOrigFile == $curFileName) {
      return $this->saveMediaPicOnceChangeOnlyAltTitleNow($curPicId, $curFileAlt, $curFileTitle);
    }
    
    if (file_exists('../../../user_upload/'.$curFileName)) {
      return 'exist';
    }
    else {
      return $this->saveMediaPicOnceChangeAllNow($curPicId, $bildOrigFile, $curFileName, $curFileAlt, $curFileTitle);
    }
  }
  
  
  
  private function saveMediaPicOnceChangeOnlyAltTitleNow($curPicId, $curFileAlt, $curFileTitle) {
    $sqlText = 'UPDATE vbilder SET bildAlt = "' . $this->dbDecode($curFileAlt) . '", bildTitel = "' . $this->dbDecode($curFileTitle) . '" WHERE bildID = ' . $this->dbDecode($curPicId);
    $sqlErg = $this->dbAbfragen($sqlText);
    if ($sqlErg == true) {
      return 'ok';
    }
    else {
      return 'fehler';
    }
  }
  
  
  
  private function saveMediaPicOnceChangeAllNow($curPicId, $bildOrigFile, $curFileName, $curFileAlt, $curFileTitle) {
    $isRmH = rename('../../../user_upload/'.$bildOrigFile, '../../../user_upload/'.$curFileName);
    if ($isRmH == true) {
      $this->mediaPicOnceRenamePicThumbs('200', $bildOrigFile, $curFileName);
      $this->mediaPicOnceRenamePicThumbs('400', $bildOrigFile, $curFileName);
      $this->mediaPicOnceRenamePicThumbs('800', $bildOrigFile, $curFileName);
      
      return $this->saveMediaPicOnceChangeAllInDbNow($curPicId, $bildOrigFile, $curFileName, $curFileAlt, $curFileTitle);
    }
  }
  
  
  
  private function saveMediaPicOnceChangeAllInDbNow($curPicId, $bildOrigFile, $curFileName, $curFileAlt, $curFileTitle) {
    $sqlText = 'UPDATE vbilder SET bildAlt = "' . $this->dbDecode($curFileAlt) . '", bildTitel = "' . $this->dbDecode($curFileTitle) . '", bildFile = "' . $this->dbDecode($curFileName) . '", bildName = "' . $this->dbDecode($curFileName) . '" WHERE bildID = ' . $this->dbDecode($curPicId);
    $sqlErg = $this->dbAbfragen($sqlText);
    if ($sqlErg == true) {
      return 'ok';
    }
    else {
      return 'fehler';
    }
  }
  
  
  
  private function mediaPicOnceRenamePicThumbs($curThumb, $bildOrigFile, $curFileName) {
    if (file_exists('../../../user_upload/thumb_'.$curThumb.'/'.$bildOrigFile)) {
      return rename('../../../user_upload/thumb_'.$curThumb.'/'.$bildOrigFile, '../../../user_upload/thumb_'.$curThumb.'/'.$curFileName);
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für Bilder Bearbeiten
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Bilder auswahl
  // ***************************************************************************
  
  public function getBilderAuswahlPics($curBildKat = 0, $reload = false) {
    $return = '';
    
    if (isset($reload) && $reload == false) {
      if (isset($_POST['_dataMultiPic']) && $_POST['_dataMultiPic'] == 'true') {
        $return .= '<div class="vFrontMultiPicAuswahlBtnMM">auswählen</div>';
      }
      
      $return .= $this->getBilderAuswahlPicsKategorienSelect();
      
      $return .= '<div class="vFrontAuswahlImgVerwaltHolder">';
    }
    
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3 && $curBildKat == 0) {
      
    }
    else {
      $sqlImgText = 'SELECT * FROM vbilder WHERE bildKat = ' . $this->dbDecode($curBildKat);
      $sqlImgErg = $this->dbAbfragen($sqlImgText);

      while ($rowImg = mysql_fetch_array($sqlImgErg)) {
        $curPicFile = $rowImg['bildFile'];
        if (isset($rowImg['bildFile']) && file_exists('../../../user_upload/thumb_200/' . $rowImg['bildFile'])) {
          $curPicFile = 'thumb_200/' . $rowImg['bildFile'];
        }
        $return .= '<div class="vFrontAuswahlImgElement" data-id="' . $rowImg['bildID'] . '" data-file="' . $rowImg['bildFile'] . '" data-name="' . $rowImg['bildName'] . '">
            <div class="vFrontAuswahlImgElementPic"><img src="user_upload/' . $curPicFile . '" alt="' . $rowImg['bildAlt'] . '" title="' . $rowImg['bildTitel'] . '" /></div>
            <div class="vFrontAuswahlImgElementName">' . $rowImg['bildName'] . '</div>
          </div>';
      }
    }
    
    $return .= '<div class="clearer" style="height:20px;"></div>';
    
    if (isset($reload) && $reload == false) {
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getBilderAuswahlPicsKategorienSelect() {
    $return = '<div class="vFrontAuswahlImgVerwaltHolderKatSelect">';
    
    $return .= '<label>Kategorie:</label>';
    $return .= '<select name="vFrontBildAuswahlKatSelect" id="vFrontBildAuswahlKatSelect">';
    $return .= '<option value="0">Bilder</option>';
    
    $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
      $curKatIdsUserRecht = str_replace(';', ',', $_SESSION['VCMS_USER_RECHT_ARRAY']['categories']);
      $sqlText = 'SELECT * FROM vbildkategorie WHERE katID IN ('.$this->dbDecode($curKatIdsUserRecht).') ORDER BY katName ASC';
    }
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<option value="' . $row['katID'] . '">&nbsp;&nbsp;&nbsp;- ' . $row['katName'] . '</option>';
      
      // Unter Kategorie anzeigen
      // *****************************************************
      if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
        $sqlKatUText = 'SELECT * FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($row['katID']) . ' ORDER BY katName ASC';
        $sqlKatUErg = $this->dbAbfragen($sqlKatUText);

        while($rowKatU = mysql_fetch_array($sqlKatUErg, MYSQL_ASSOC)) {
          $return .= '<option value="'.$rowKatU['katID'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$rowKatU['katName'].'</option>';
        }
      }
      // *****************************************************
    }
    
    $return .= '</select>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Bilder auswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Bilder Kategorien
  // ***************************************************************************
  
  public function showBildVerwaltungNewKategorieWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vPicKatFrmOberKat">in Kategorie:</label>
                <select name="vPicKatFrmOberKat" id="vPicKatFrmOberKat">';
    
    $return .= '<option value="0">Bilder</option>';
    
    $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<option value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
    }
    
    $return .= '</select>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vPicKatFrmName">Name:</label>
                <input type="text" name="vPicKatFrmName" id="vPicKatFrmName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveNewPicKat" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showBildVerwaltungBerabeitenKategorieWindow($curKatId) {
    $return = '';
    $sqlText = 'SELECT * FROM vbildkategorie WHERE katID = '.$this->dbDecode($curKatId).' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowKat = mysql_fetch_array($sqlErg)) {
      // Prüfen ob Kategorie Unterkategorien hat
      // *****************************************************
      $sqlTextUCheck = 'SELECT katID FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($rowKat['katID']);
      $sqlErgUCheck = $this->dbAbfragen($sqlTextUCheck);
      $sqlCountUCheck = mysql_num_rows($sqlErgUCheck);

      $hasUnterKats = false;

      if ($sqlCountUCheck > 0) {
        $hasUnterKats = true;
      }
      // *****************************************************
      
      $return .= '<div class="vFrontSmallSeFrmHolder">';
      
      $return .= '<label for="vPicKatFrmOberKat">in Kategorie:</label>
                <select name="vPicKatFrmOberKat" id="vPicKatFrmOberKat">';

      if ($rowKat['katParent'] == 0) {
        $return .= '<option selected="selected" value="0">Bilder</option>';
      }
      else {
        $return .= '<option value="0">Bilder</option>';
      }
      
      if (isset($hasUnterKats) && $hasUnterKats == false) {
        $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
        $sqlErg = $this->dbAbfragen($sqlText);

        while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          if ($rowKat['katID'] == $rowK['katID']) {

          }
          else if ($rowKat['katParent'] == $rowK['katID']) {
          $return .= '<option selected="selected" value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
          }
          else {
            $return .= '<option value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
          }
        }
      }

      $return .= '</select>';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vPicKatFrmName">Name:</label>
                  <input type="text" name="vPicKatFrmName" id="vPicKatFrmName" value="' . $rowKat['katName'] . '" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vFrontSaveBearbeitPicKat" data-id="' . $rowKat['katID'] . '" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function saveBildVerwaltungNewKatNow($curKatName, $curKatParent) {
    $sqlText = 'INSERT INTO vbildkategorie (katName, katParent) VALUES ("' . $this->dbDecode($curKatName) . '", ' . $curKatParent . ')';
    $sqlErg = $this->dbAbfragen($sqlText);
    return mysql_insert_id();
  }
  
  
  
  public function saveBildVerwaltungBearbeiteteKatNow($curKatId, $curKatName, $curKatParent) {
    $sqlText = 'UPDATE vbildkategorie SET katName = "' . $this->dbDecode($curKatName) . '", katParent = ' . $curKatParent . ' WHERE katID = ' . $this->dbDecode($curKatId);
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delThisPicVerwaltungKategorie($curKatId) {
    // Prüfen ob Bilder in dieser Kategorie sind
    $sqlCheckText = 'SELECT bildID FROM vbilder WHERE bildKat = ' . $this->dbDecode($curKatId);
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckCount = mysql_num_rows($sqlCheckErg);
    
    // Prüfen ob Unter Kategorien vorhanden sind
    $sqlCheckTextU = 'SELECT katID FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($curKatId);
    $sqlCheckErgU = $this->dbAbfragen($sqlCheckTextU);
    $sqlCheckCountU = mysql_num_rows($sqlCheckErgU);
    
    if ($sqlCheckCount < 1 && $sqlCheckCountU < 1) {
      $sqlText = 'DELETE FROM vbildkategorie WHERE katID = ' . $this->dbDecode($curKatId);
      $sqlTextErg = $this->dbAbfragen($sqlText);
      if ($sqlTextErg) {
        return 'ok';
      }
      else {
        return 'fehler';
      }
    }
    else {
      return 'not_empty';
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für Bilder Kategorien
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kategorien verschieben
  // ***************************************************************************
  
  public function showBildVerwaltungFilesTransportWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vPicKatTransportKat">Kategorie:</label>
                <select name="vPicKatTransportKat" id="vPicKatTransportKat">';
    
    $return .= '<option value="">auswählen...</option>';
    
    if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] == 0) {
      $return .= '<option disabled="disabled" value="0">Bilder</option>';
    }
    else {
      $return .= '<option value="0">Bilder</option>';
    }
    
    $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] == $rowK['katID']) {
        $return .= '<option disabled="disabled" value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp;- '.$rowK['katName'].'</option>';
      }
      else {
        $return .= '<option value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp;- '.$rowK['katName'].'</option>';
      }
      
      // Unter Kategorie anzeigen
      // *****************************************************
      $sqlKatUText = 'SELECT * FROM vbildkategorie WHERE katParent = ' . $this->dbDecode($rowK['katID']) . ' ORDER BY katName ASC';
      $sqlKatUErg = $this->dbAbfragen($sqlKatUText);
      
      while($rowKatU = mysql_fetch_array($sqlKatUErg, MYSQL_ASSOC)) {
        if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] == $rowKatU['katID']) {
          $return .= '<option disabled="disabled" value="'.$rowKatU['katID'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$rowKatU['katName'].'</option>';
        }
        else {
          $return .= '<option value="'.$rowKatU['katID'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$rowKatU['katName'].'</option>';
        }
      }
      // *****************************************************
    }
    
    $return .= '</select>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input style="width:150px;" type="submit" value="Bilder verschieben" id="vFrontSaveKatTransportPics" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveNewKatTransportPicsNow($curKatId, $picElems) {
    $picIdsArr = explode(';', $picElems);
    foreach ($picIdsArr as $picId) {
      $sqlText = 'UPDATE vbilder SET bildKat = ' . $this->dbDecode($curKatId) . ' WHERE bildID = ' . $this->dbDecode($picId);
      $sqlErg = $this->dbAbfragen($sqlText);
    }
    return 'ok';
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kategorien verschieben
  // ***************************************************************************
  
}

?>