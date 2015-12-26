<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsDateiVerwaltung extends funktionsSammlung {
  
  public function getTheDateiVerwaltung() {
    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI'] = 0;
    
    $return = '';
    
    $return .= '<div class="vFrontImgKatHolder">';
    $return .= $this->getDateiVerwaltKategorien();
    $return .= '</div>';
    
    $return .= '<div class="vFrontImgVerwaltHolder">';
    $return .= $this->getDateiElements();
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function reloadOnlyDateiverwaltungKatNow() {
    return $this->getDateiVerwaltKategorien();
  }
  
  
  
  public function showCurentDateiKatDateienNow($curKatId) {
     $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = $curKatId;
     
     
    return $this->getDateiElements($curKatId);
  }
  
  
  
  public function getDateiVerwaltKategorien() {
    $return = '
      <div style="height:10px;"></div>
      <div style="font-weight:bold; font-size:12px;" class="vFrontKatElem vFrontKatElemAll vFrontKatElemActive" data-id="0" id="vKatPicVerwId0">Dateien</div>';
    
    $sqlKatText = 'SELECT * FROM vdateikategorie WHERE dkatParent = 0 ORDER BY dkatName ASC';
    $sqlKatErg = $this->dbAbfragen($sqlKatText);
    
    while($rowKat = mysql_fetch_array($sqlKatErg, MYSQL_ASSOC)) {
      $return .= '<div style="font-weight:bold; font-size:12px;" class="vFrontKatElem" data-id="' . $rowKat['dkatID'] . '" id="vKatPicVerwId' . $rowKat['dkatID'] . '">' . $rowKat['dkatName'];
      $return .= '<div class="vFrontKatElemDelBtn" data-id="' . $rowKat['dkatID'] . '" title="Löschen"></div><div class="vFrontKatElemChangeBtn" data-id="' . $rowKat['dkatID'] . '" title="Bearbeiten"></div>';
      
      $return .= '</div>';
      
      // Unter Kategorie anzeigen
      // *****************************************************
      $sqlKatUText = 'SELECT * FROM vdateikategorie WHERE dkatParent = ' . $this->dbDecode($rowKat['dkatID']) . ' ORDER BY dkatName ASC';
      $sqlKatUErg = $this->dbAbfragen($sqlKatUText);
      $sqlKatUCount = mysql_num_rows($sqlKatUErg);

      if ($sqlKatUCount > 0) {
        $return .= '<div class="vFrontUnterKatElemAllHolderToogleBtn" data-id="'.$rowKat['dkatID'].'"></div>';
        $return .= '<div id="vFrontUnterKatElemAllHolderToogle'.$rowKat['dkatID'].'" class="vFrontUnterKatElemAllHolderToogleDateien" style="display:none;">';
      }

      while($rowKatU = mysql_fetch_array($sqlKatUErg, MYSQL_ASSOC)) {
        $return .= '<div style="margin-left:36px; font-size:12px;" class="vFrontKatElem" data-id="' . $rowKatU['dkatID'] . '" id="vKatPicVerwId' . $rowKatU['dkatID'] . '">' . $rowKatU['dkatName'] . '<div class="vFrontKatElemDelBtn" data-id="' . $rowKatU['dkatID'] . '" title="Löschen"></div><div class="vFrontKatElemChangeBtn" data-id="' . $rowKatU['dkatID'] . '" title="Bearbeiten"></div></div>';
      }

      if ($sqlKatUCount > 0) {
        $return .= '</div>';
      }
      // *****************************************************
    }
    
    return $return;
  }
  
  
  
  public function getDateiElements($curDateiKatId = 0) {
    $basePath = $_SERVER['HTTP_HOST'];
    if (stripos($basePath, 'http://') !== false) {
      $setBaseHTTP = '';
    }
    else {
      $setBaseHTTP = 'http://';
    }
    
    $return = '';

  $sqlImgText = 'SELECT * FROM vdateien WHERE dateiKat = ' . $curDateiKatId;
    $sqlImgErg = $this->dbAbfragen($sqlImgText);

    while ($rowImg = mysql_fetch_array($sqlImgErg)) {
     
      
     
      $dateiBild = $this->getDateiElemCurPic($rowImg['dateiName']);
      $return .= '<div class="vFrontImgElement" data-id="'.$rowImg['dateiID'].'">
          <div class="vFrontImgElementPic" style="background-color:#FFF; text-align:center;">'.$dateiBild.'</div>
          <div class="vFrontImgElementName">' . $rowImg['dateiName'] . '</div>
          <div class="vFrontImgElementMenu">
            <div class="vFrontVerwPicElemDel" id="picDel' . $rowImg['dateiID'] . '" title="Löschen"></div>
            <div class="vFrontVerwPicElemChange" id="picChange' . $rowImg['dateiID'] . '" title="Bearbeiten"></div>
            <div class="vFrontVerwDateiElemUriShow" data-file="' . $setBaseHTTP . $basePath . '/user_upload_files/' . $rowImg['dateiFile'] . '" title="Datei Url anzeigen"></div>
            <div class="clearer"></div>
          </div>
        </div>';
    }
    
     $return .= '<div class="clearer" style="height:20px;"></div>';
    
    return $return;
  }
  
  
  
  private function getDateiElemCurPic($dateiName) {
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
    
    return '<img src="admin/frontAdmin/img/dateiendungen/'.$curImg.'" alt="file" title="" style="width:43px; margin-top:18px;" width="43">';
  }
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Upload überprüfungen
  // ***************************************************************************
  
  public function checkIsDateiFileAllow($fileArr) {
    // Dateien die nicht erlaubt sind
    //$allowed = array('png', 'jpg', 'gif','zip', 'pdf', 'tar', 'docx');
    $notallowed = array('php', 'html', 'exe', 'cmd', 'php5');
    // Dateiendung erhalten
    $extension = pathinfo($fileArr['upl']['name'], PATHINFO_EXTENSION);
    
    if(in_array(strtolower($extension), $notallowed)){
      return false;
    }
    
    return true;
  }
  
  
  
  public function checkIsDateiFilenameExists($filePath, $fileName) {
    if (file_exists($filePath.$fileName)) {
      return true;
    }
    return false;
  }

  // ***************************************************************************
  // ANFANG - Funktionen für Upload überprüfungen
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Upload Datei in Datenbank speichern
  // ***************************************************************************
  
  public function saveNewUploadDateiInDatabase($filename) {
   
     
   
     // $sqlDateiText = 'INSERT INTO vdateien (dateiName, dateiFile, dateiKat) VALUES ("' . $this->dbDecode($filename) . '", "' . $this->dbDecode($filename) . '", ' . $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI'] . ')';
     
     ///02.09.2015
    $sqlDateiText = 'INSERT INTO vdateien (dateiName, dateiFile, dateiKat) VALUES ("' . $this->dbDecode($filename) . '", "' . $this->dbDecode($filename) . '", ' . $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] . ')';
     
     
    return $this->dbAbfragen($sqlDateiText);
  }

  // ***************************************************************************
  // ENDE - Funktionen für Upload Datei in Datenbank speichern
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Dateien Bearbeiten
  // ***************************************************************************
  
  public function showMediaDateiOnceChangeWindow($curPicId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vdateien WHERE dateiID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPic = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontSmallSeFrmHolder">';
      
      $zwFileNameArr = explode('.', $rowPic['dateiFile']);
      $curFileType = '.' . $zwFileNameArr[(count($zwFileNameArr) - 1)];
      $curFileName = str_replace($curFileType, '', $rowPic['dateiFile']);
      
      $return .= '<input type="hidden" name="vMediaPicFileNameType" id="vMediaPicFileNameType" value="' . $curFileType . '" />';

      $return .= '<label for="vMediaPicFileName">Dateiname:</label>
                  <input maxlength="200" type="text" name="vMediaPicFileName" id="vMediaPicFileName" value="' . $curFileName . '" /> ' . $curFileType;

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vFrontSaveMediaDateiBearOnce" data-id="' . $rowPic['dateiID'] . '" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function saveMediaDateiOnceChangeFileNow($curPicId, $curFileName) {
    $sqlTextCheck = 'SELECT dateiFile FROM vdateien WHERE dateiID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErgCheck = $this->dbAbfragen($sqlTextCheck);
    $countCheck = 0;
    $bildOrigFile = '';
    
    $curFileName = strtolower($curFileName);
    
    while ($rowCheck = mysql_fetch_array($sqlErgCheck, MYSQL_ASSOC)) {
      $countCheck++;
      $bildOrigFile = $rowCheck['dateiFile'];
    }
    
    if ($countCheck < 1 || empty($bildOrigFile)) {
      return 'fehler';
    }
    
    if ($bildOrigFile == $curFileName) {
      return 'ok';
    }
    
    if (file_exists('../../../user_upload_files/'.$curFileName)) {
      return 'exist';
    }
    else {
      return $this->saveMediaDateiOnceChangeAllNow($curPicId, $bildOrigFile, $curFileName);
    }
  }
  
  
  
  private function saveMediaDateiOnceChangeAllNow($curPicId, $bildOrigFile, $curFileName) {
    $isRmH = rename('../../../user_upload_files/'.$bildOrigFile, '../../../user_upload_files/'.$curFileName);
    if ($isRmH == true) {
      return $this->saveMediaDateiOnceChangeAllInDbNow($curPicId, $bildOrigFile, $curFileName);
    }
  }
  
  
  
  private function saveMediaDateiOnceChangeAllInDbNow($curPicId, $bildOrigFile, $curFileName) {
    $sqlText = 'UPDATE vdateien SET dateiFile = "' . $this->dbDecode($curFileName) . '", dateiName = "' . $this->dbDecode($curFileName) . '" WHERE dateiID = ' . $this->dbDecode($curPicId);
    $sqlErg = $this->dbAbfragen($sqlText);
    if ($sqlErg == true) {
      return 'ok';
    }
    else {
      return 'fehler';
    }
  }

  // ***************************************************************************
  // ENDE - Funktionen für Dateien Bearbeiten
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Dateien in Datenbank löschen
  // ***************************************************************************
  
  public function delThisDateiNow($dateiID) {
    $sqlText = 'SELECT dateiFile FROM vdateien WHERE dateiID = ' . $this->dbDecode($dateiID) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    $bildFile = '';
    $bildPath = '../../../user_upload_files/';
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $bildFile = $row['dateiFile'];
    }
    
    if (isset($bildFile) && !empty($bildFile) && file_exists($bildPath.$bildFile)) {
      unlink($bildPath.$bildFile);
    }
    
    $sqlDelText = 'DELETE FROM vdateien WHERE dateiID = ' . $this->dbDecode($dateiID);
    return $sqlDelErg = $this->dbAbfragen($sqlDelText);
  }
  
  
  
  public function delMediaAllSelectedDateienNow($dateiElems) {
    $dateiElemsArr = explode(';', $dateiElems);
    foreach ($dateiElemsArr as $value) {
      $this->delThisDateiNow($value);
    }
    return 'ok';
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Dateien in Datenbank löschen
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Datei Kategorien
  // ***************************************************************************
  
  public function showDateiVerwaltungNewKategorieWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vPicKatFrmOberKat">in Kategorie:</label>
                <select name="vPicKatFrmOberKat" id="vPicKatFrmOberKat">';
    
    $return .= '<option value="0">Dateien</option>';
    
    $sqlText = 'SELECT * FROM vdateikategorie WHERE dkatParent = 0 ORDER BY dkatName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<option value="'.$rowK['dkatID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['dkatName'].'</option>';
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
  
  
  
  public function showDateiVerwaltungBerabeitenKategorieWindow($curKatId) {
    $return = '';
    $sqlText = 'SELECT * FROM vdateikategorie WHERE dkatID = '.$this->dbDecode($curKatId).' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowKat = mysql_fetch_array($sqlErg)) {
      // Prüfen ob Kategorie Unterkategorien hat
      // *****************************************************
      $sqlTextUCheck = 'SELECT dkatID FROM vdateikategorie WHERE dkatParent = ' . $this->dbDecode($rowKat['dkatID']);
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

      if ($rowKat['dkatParent'] == 0) {
        $return .= '<option selected="selected" value="0">Dateien</option>';
      }
      else {
        $return .= '<option value="0">Dateien</option>';
      }
      
      if (isset($hasUnterKats) && $hasUnterKats == false) {
        $sqlText = 'SELECT * FROM vdateikategorie WHERE dkatParent = 0 ORDER BY dkatName ASC';
        $sqlErg = $this->dbAbfragen($sqlText);

        while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
          if ($rowKat['dkatID'] == $rowK['dkatID']) {

          }
          else if ($rowKat['dkatParent'] == $rowK['dkatID']) {
          $return .= '<option selected="selected" value="'.$rowK['dkatID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['dkatName'].'</option>';
          }
          else {
            $return .= '<option value="'.$rowK['dkatID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['dkatName'].'</option>';
          }
        }
      }

      $return .= '</select>';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<label for="vPicKatFrmName">Name:</label>
                  <input type="text" name="vPicKatFrmName" id="vPicKatFrmName" value="' . $rowKat['dkatName'] . '" />';

      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';

      $return .= '<input type="submit" value="Speichern" id="vFrontSaveBearbeitDateiKat" data-id="' . $rowKat['dkatID'] . '" />';

      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  public function saveDateiVerwaltungNewKatNow($curKatName, $curKatParent) {
    $sqlText = 'INSERT INTO vdateikategorie (dkatName, dkatParent) VALUES ("' . $this->dbDecode($curKatName) . '", ' . $curKatParent . ')';
    $sqlErg = $this->dbAbfragen($sqlText);
    return mysql_insert_id();
  }
  
  
  
  public function saveDateiVerwaltungBearbeiteteKatNow($curKatId, $curKatName, $curKatParent) {
    $sqlText = 'UPDATE vdateikategorie SET dkatName = "' . $this->dbDecode($curKatName) . '", dkatParent = ' . $curKatParent . ' WHERE dkatID = ' . $this->dbDecode($curKatId);
    $sqlErg = $this->dbAbfragen($sqlText);
  }
  
  
  
  public function delThisDateiVerwaltungKategorie($curKatId) {
    // Prüfen ob Bilder in dieser Kategorie sind
    $sqlCheckText = 'SELECT dateiID FROM vdateien WHERE dateiKat = ' . $this->dbDecode($curKatId);
    $sqlCheckErg = $this->dbAbfragen($sqlCheckText);
    $sqlCheckCount = mysql_num_rows($sqlCheckErg);
    
    // Prüfen ob Unter Kategorien vorhanden sind
    $sqlCheckTextU = 'SELECT dkatID FROM vdateikategorie WHERE dkatParent = ' . $this->dbDecode($curKatId);
    $sqlCheckErgU = $this->dbAbfragen($sqlCheckTextU);
    $sqlCheckCountU = mysql_num_rows($sqlCheckErgU);
    
    if ($sqlCheckCount < 1 && $sqlCheckCountU < 1) {
      $sqlText = 'DELETE FROM vdateikategorie WHERE dkatID = ' . $this->dbDecode($curKatId);
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
  // ENDE - Funktionen für Datei Kategorien
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Kategorien verschieben
  // ***************************************************************************
  
  public function showDateiVerwaltungFilesTransportWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="vPicKatTransportKat">Kategorie:</label>
                <select name="vPicKatTransportKat" id="vPicKatTransportKat">';
    
    $return .= '<option value="">auswählen...</option>';
    
    if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI'] == 0) {
      $return .= '<option disabled="disabled" value="0">Dateien</option>';
    }
    else {
      $return .= '<option value="0">Dateien</option>';
    }
    
    $sqlText = 'SELECT * FROM vdateikategorie WHERE dkatParent = 0 ORDER BY dkatName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI'] == $rowK['dkatID']) {
        $return .= '<option disabled="disabled" value="'.$rowK['dkatID'].'">&nbsp;&nbsp;&nbsp;- '.$rowK['dkatName'].'</option>';
      }
      else {
        $return .= '<option value="'.$rowK['dkatID'].'">&nbsp;&nbsp;&nbsp;- '.$rowK['dkatName'].'</option>';
      }
      
      // Unter Kategorie anzeigen
      // *****************************************************
      $sqlKatUText = 'SELECT * FROM vdateikategorie WHERE dkatParent = ' . $this->dbDecode($rowK['dkatID']) . ' ORDER BY dkatName ASC';
      $sqlKatUErg = $this->dbAbfragen($sqlKatUText);
      
      while($rowKatU = mysql_fetch_array($sqlKatUErg, MYSQL_ASSOC)) {
        if ($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI'] == $rowKatU['dkatID']) {
          $return .= '<option disabled="disabled" value="'.$rowKatU['dkatID'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$rowKatU['dkatName'].'</option>';
        }
        else {
          $return .= '<option value="'.$rowKatU['dkatID'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$rowKatU['dkatName'].'</option>';
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
  
  
  
  public function saveNewKatTransportDatasNow($curKatId, $dateiElems,$newCategory=null,$inCategory=null) {
    
    if($newCategory != null && $inCategory != null){
      $query = mysql_query("INSERT INTO vbildkategorie SET katName='$newCategory',katParent='$inCategory'");
      $curKatId = mysql_insert_id();
    }
    
    $dateiIdsArr = explode(';', $dateiElems);
    foreach ($dateiIdsArr as $dateiId) {
      $sqlText = 'UPDATE vdateien SET dateiKat = ' . $this->dbDecode($curKatId) . ' WHERE dateiID = ' . $this->dbDecode($dateiId);
      $sqlErg = $this->dbAbfragen($sqlText);
    }
    return 'ok';
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Kategorien verschieben
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Dateien auswahl
  // ***************************************************************************
  
  public function getDateienAuswahlFiles($curDateiKat = 0, $reload = false) {
    $return = '';
    
    if (isset($reload) && $reload == false) {
      if (isset($_POST['_isDateiAuswahlMultiSelectElemsNow']) && $_POST['_isDateiAuswahlMultiSelectElemsNow'] == 'yes') {
        $return .= '<div class="vFrontMultiPicAuswahlBtnMM">auswählen</div>';
      }
      $return .= $this->getDateienAuswahlFilesKategorienSelect();
      
      $return .= '<div class="vFrontAuswahlImgVerwaltHolder">';
    }
    
    $sqlImgText = 'SELECT * FROM vdateien WHERE dateiKat = ' . $this->dbDecode($curDateiKat);
    $sqlImgErg = $this->dbAbfragen($sqlImgText);
    
    while ($rowImg = mysql_fetch_array($sqlImgErg)) {
      $dateiBild = $this->getDateiElemCurPic($rowImg['dateiName']);
      $return .= '<div class="vFrontAuswahlImgElement" data-id="' . $rowImg['dateiID'] . '" data-file="' . $rowImg['dateiFile'] . '" data-name="' . $rowImg['dateiName'] . '">
          <div class="vFrontAuswahlImgElementPic" style="background-color:#FFF; text-align:center;">'.$dateiBild.'</div>
          <div class="vFrontAuswahlImgElementName">' . $rowImg['dateiName'] . '</div>
        </div>';
    }
    
    $return .= '<div class="clearer" style="height:20px;"></div>';
    
    if (isset($reload) && $reload == false) {
      $return .= '</div>';
    }
    
    return $return;
  }
  
  
  
  private function getDateienAuswahlFilesKategorienSelect() {
      
    $categoryList =  $this->categoryParentChildTree(0,'','','',2);
    
    
    
    $return = '<div class="vFrontAuswahlImgVerwaltHolderKatSelect">';
    
    $return .= '<label>Kategorie:</label>';
    $return .= '<select name="vFrontBildAuswahlKatSelect" id="vFrontBildAuswahlKatSelect">';
    $return .= '<option value="0">Dateien</option>';

    foreach($categoryList as $key => $value){
         $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
     }

     $return .= '</select>';

     $return .= '</div>';

     return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen für Dateien auswahl
  // ***************************************************************************
  
  
   public function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '',$in='',$typeFiles=1) {
    global $dbConnection;
  
    if (!is_array($category_tree_array))
        $category_tree_array = array();
   
            if($in!=''){

              $sqlCategory = "SELECT * FROM vbildkategorie WHERE  katID IN ($in) AND typeFiles='$typeFiles' ORDER BY katName ASC";

            }else{
             $sqlCategory = "SELECT * FROM vbildkategorie WHERE katParent = $parent AND typeFiles='$typeFiles' ORDER BY katName ASC";
            }
            
          
   $sqlErg =  $this->dbAbfragen($sqlCategory);
    
;
    if (mysql_num_rows($sqlErg) > 0) {
        while($rowCategories =   mysql_fetch_array($sqlErg)) {
            $category_tree_array[] = array("id" => $rowCategories['katID'], "name" => $spacing . $rowCategories['katName'],'parent'=>$rowCategories['katParent']);
            $category_tree_array = $this->categoryParentChildTree($rowCategories['katID'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array,'',$typeFiles);
        }
    }
    
    
    
    return $category_tree_array;
}
  

 private function getBilderAuswahlPicsKategorienSelect() {
  	
	$categoryList =  $this->categoryParentChildTree();
 
    $return = '<div class="vFrontAuswahlImgVerwaltHolderKatSelect">';
    
    $return .= '<label>Kategorie:</label>';
    $return .= '<select name="vFrontBildAuswahlKatSelect" id="vFrontBildAuswahlKatSelect">';
    $return .= '<option value="0">Bilder</option>';
    foreach($categoryList as $key => $value){
        $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    
    
    $return .= '</select>';
    
    $return .= '</div>';
    
    return $return;
  }

  
}

?>