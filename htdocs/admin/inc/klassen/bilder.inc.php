<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsBilder extends funktionsSammlung {
  
//  public function getThePictureVerwaltung() {
//    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = 0;
//    
//    $return = '';
//    
//    $return .= '<div class="vFrontImgKatHolder">';
//   // $return .= $this->getImageKategorien();
//    $return .= $this->buildMenu(0,'','','',1);
//    $return .= '</div>';
//    
//    $return .= '<div class="vFrontImgVerwaltHolder">';
//    $return .= $this->getImageElements();
//    $return .= "</div><script>$('#tree1').treed();</script>";
// 
//    
//    return $return;
//  }
//  
  
   public function getThePictureVerwaltung() {
    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = 0;
    
    $return = '';
    
    $return .= '<div class="vFrontImgKatHolder">';
    $return .= '<div class="categoryButton" data-type="images"><a>Images</a></div> ';
   // $return .= '<div id="imageCategory">';
    $return .= $this->buildMenu(0,'','','',1);
    //$return .= '</div>';
   // $return .= '<div style="clear:both;">';
     $return .= '<div class="categoryButton" data-type="files"><a>Files</a></div> ';
    //$return .= '<div id="filesCategory"> ';
    $return .= $this->buildMenu(0,'','','',1,'files');
   // $return .= '</div>';
    $return .= '</div>';
    
    $return .= '<div class="vFrontImgVerwaltHolder">';
    $return .= $this->getImageElements();
    $return .= "</div><script>$('.tree1').treed();</script>";
 
    
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
      
        $return .= '';
    $return .= '<div class="categoryButton"><a>Images</a></div> ';
   // $return .= '<div id="imageCategory">';
    $return .= $this->buildMenu(0,'','','',1);
    //$return .= '</div>';
   // $return .= '<div style="clear:both;">';
     $return .= '<div class="categoryButton"><a>Files</a></div> ';
    //$return .= '<div id="filesCategory"> ';
   // $return .= $this->buildMenu(0,'','','',1,'files');
   // $return .= '</div>';
    $return .= '</div>';
     
    $return .= '<div class="vFrontImgVerwaltHolder">';
    $return .= $this->getImageElements();
    $return .= "<script>$('.tree1').treed();</script>";  
    
    return $return;
      
      
      
      
      
      
      
      
      
      
    $return = '
      <div style="height:10px;"></div>
      <div style="font-weight:bold; font-size:12px;" class="vFrontKatElem vFrontKatElemAll vFrontKatElemActive" data-id="0" id="vKatPicVerwId0">Bilder</div>';
  
    
     $sqlKatText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
     
    if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
      $curKatIdsUserRecht = str_replace(';', ',', $_SESSION['VCMS_USER_RECHT_ARRAY']['categories']);
      //$sqlKatText = 'SELECT * FROM vbildkategorie WHERE katID IN ('.$this->dbDecode($curKatIdsUserRecht).') ORDER BY katName ASC';
      $category = $this->categoryParentChildTree(0,'','',$curKatIdsUserRecht);
    }else{
     
      $category = $this->categoryParentChildTree();
     
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
        
       $imageSizeArr = getimagesize($_SERVER['DOCUMENT_ROOT'].'/user_upload/'.$rowImg['bildFile']);
    
        $return .= '<div class="vFrontImgElement" data-id="'.$rowImg['bildID'].'" data-width="'.$imageSizeArr[0].'" data-height="'.$imageSizeArr[1].'">
            <div class="vFrontImgElementPic"><img src="user_upload/' . $curPicFile . '" alt="' . $rowImg['bildAlt'] . '" title="' . $rowImg['bildTitel'] . '"    /></div>
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
        $query = mysql_query("SELECT * FROM time_hash");
      if(mysql_num_rows($query)){
        $return .= '<label for="vMediaPicFileTitle">Tags:</label>';
        $return .= '<select name="tags" id="tags">'; 
        $return .= '<option value="1">Select</option>';
         while($row = mysql_fetch_array($query)){
            
           $return .= '<optgroup label="'.$row['name'].'">';
           $idhash = $row['id_hash'];
          // echo "SELECT * FROM time_hash_texts WHERE id_h='$idhash' WHERE id_lang=1";
           $query1 = mysql_query("SELECT * FROM time_hash_texts WHERE id_h='$idhash' AND id_lang=1");
            while($row1 = mysql_fetch_array($query1)){
                $selected = ($row1['id_hash'] == $rowPic['tag'])?'selected="selected"':''; 
               $return .= '<option value="'.$row1['id_time_ht'].'" '.$selected.'>'.$row1['title'].'</option>';  
            }
         $return .= '</optgroup>';
            
           
        } 
        $return .= '</select>';   
      }
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
    $tag = $this->dbDecode($_POST['_tag']);   
    $sqlText = 'UPDATE vbilder SET bildAlt = "' . $this->dbDecode($curFileAlt) . '", bildTitel = "' . $this->dbDecode($curFileTitle) . '",tag="'.$tag.'" WHERE bildID = ' . $this->dbDecode($curPicId);
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
  
  // ***************************************************************************
  // ENDE - Funktionen für Bilder auswahl
  // ***************************************************************************
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen für Bilder Kategorien
  // ***************************************************************************
  
  public function showBildVerwaltungNewKategorieWindow() {
    $return = '<div class="vFrontSmallSeFrmHolder">';
    $return .= '<label for="vPicKatFrmOberKat">Type:</label>
                <select name="vPicKatFrmOberKat" id="fileType">
                <option value="1">Images</option>
                <option value="2">Files</option>
                </select>';
    
     $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<label for="vPicKatFrmOberKat" >in Kategorie:</label>
                <div id="categorySelect" style="float:right;margin-right:94px;">
                <select name="vPicKatFrmOberKat iTypeSelect" id="vPicKatFrmOberKat"  data-type="1">';
    
    $return .= '<option value="0">Main category</option>';
    
   $categoryList =  $this->categoryParentChildTree(0,'','','',1);
   
    
    foreach($categoryList as $key => $value){
        $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    
    $return .= '</select>'
            . '</div>';
    
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<label for="vPicKatFrmName">Name:</label>
                <input type="text" name="vPicKatFrmName" id="vPicKatFrmName" />';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input type="submit" value="Speichern" id="vFrontSaveNewPicKat" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  public function getCategoryByTypeFiles($idType){
     
      $return .= '<select name="vPicKatFrmOberKat iTypeSelect" id="vPicKatFrmOberKat"  data-type="1">';
       $return .= '<option value="0">Main category</option>';
       $categoryList =  $this->categoryParentChildTree(0,'','','',$idType);
      

        foreach($categoryList as $key => $value){
            $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
        }
    
            $return .= '</select>';
    
      echo $return;
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

//      if ($rowKat['katParent'] == 0) {
//        $return .= '<option selected="selected" value="0">Bilder</option>';
//      }
//      else {
//        $return .= '<option value="0">Bilder</option>';
//      }
//      
//      if (isset($hasUnterKats) && $hasUnterKats == false) {
//        $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
//        $sqlErg = $this->dbAbfragen($sqlText);
//
//        while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
//          if ($rowKat['katID'] == $rowK['katID']) {
//
//          }
//          else if ($rowKat['katParent'] == $rowK['katID']) {
//          $return .= '<option selected="selected" value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
//          }
//          else {
//            $return .= '<option value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
//          }
//        }
//      }
//

 
       $categoryList =   $this->categoryParentChildTree();
       
       //print_r($categoryList);
       $return .= '<option value="0">Bilder</option>';
         foreach($categoryList as $key => $value){
          
         
          $selected = ($rowKat['katParent'] == $value['id'])?'selected="selected"':'';
          
          $return .= '<option value="'.$value['id'].'"  '.$selected.' >'.$value['name'].'</option>';
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
    $sqlText = 'INSERT INTO vbildkategorie (katName, katParent,typeFiles) VALUES ("' . $this->dbDecode($curKatName) . '", "' . $curKatParent . '", "' . $this->dbDecode($_POST['_fileType']) . '")';
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
    
   // $sqlText = 'SELECT * FROM vbildkategorie WHERE katParent = 0 ORDER BY katName ASC';
    //$sqlErg = $this->dbAbfragen($sqlText);
    
   $categoryList =  $this->categoryParentChildTree();
   // while($rowK = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
     // $return .= '<option value="'.$rowK['katID'].'">&nbsp;&nbsp;&nbsp; - '.$rowK['katName'].'</option>';
   // }
    
    foreach($categoryList as $key => $value){
        $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    
    $return .= '</select>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<input style="width:150px;" type="submit" value="Bilder verschieben" id="vFrontSaveKatTransportPics" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function saveNewKatTransportPicsNow($curKatId, $picElems,$newCategory=null,$inCategory=null) {

    if($newCategory != null && $inCategory != null){
      $query = mysql_query("INSERT INTO vbildkategorie SET katName='$newCategory',katParent='$inCategory'");
      $curKatId = mysql_insert_id();
    }
   
    $picIdsArr = explode(';', $picElems);
    foreach ($picIdsArr as $picId) {
      $sqlText = 'UPDATE vbilder SET bildKat = ' . $this->dbDecode($curKatId) . ' WHERE bildID = ' . $this->dbDecode($picId);
      $sqlErg = $this->dbAbfragen($sqlText);
    }
    return 'ok';
  }
  
  
  public function getSelectCategoryList($type=1){
   
    $categoryList =  $this->categoryParentChildTree(0,'','','',$type);
   $return .= '<option value="">auswählen...</option>';
   $return .= '<option value="0">Main Category</option>';
    foreach($categoryList as $key => $value){
        $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    
    return $return;
   
  }
  
  
   // ***************************************************************************
  // Get category tree
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
            $category_tree_array = $this->categoryParentChildTree($rowCategories['katID'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array,'');
        }
    }
    
     
    
    return $category_tree_array;
}


   // ***************************************************************************
  // Get menu category
  // ***************************************************************************

 public function   buildMenu($parent = 0, $spacing = '', $category_tree_array = '',$in='',$i=1,$type='images') {
    global $dbConnection;
  
    if (!is_array($category_tree_array))
        $category_tree_array = array();
    
      $typeFiles = ($type == 'images')?1:2;
   
      if($in!=''){
        $sqlCategory = "SELECT * FROM vbildkategorie WHERE  katID IN ($in)  AND typeFiles = '$typeFiles' ORDER BY katName ASC";
      }else{
       $sqlCategory = "SELECT * FROM vbildkategorie WHERE katParent = $parent AND typeFiles = '$typeFiles' ORDER BY katName ASC";
      }

     $sqlErg =  mysql_query($sqlCategory);
     
     if (mysql_num_rows($sqlErg) > 0) {
           
         if($type == 'images'){
            
            $uri = 'admin/inc/ajaxUpload/upload.php';
            $id =  'imageCategoryMenu'; 
         }else{
            
            $uri = 'admin/inc/ajaxUpload/upload_datei.php';
            $id =  'fileCategoryMenu';
          
         }  
           
           
         if($i==1){
           $html.='<ul class="tree1" style="display:none;"  data-uri="'.$uri.'" id="'.$id.'"  >';
         }else{
           $html.='<ul>';
         }
         while($rowCategories =   mysql_fetch_array($sqlErg)) {
          $i++; 
             $html.='<li class="vFrontKatElem" data-id="' . $rowCategories['katID'] . '" id="vKatPicVerwId' . $rowCategories['katID'] . '" data-type="'.$type.'">'.$rowCategories['katName'];
            $html.=  $category_tree_array = $this->buildMenu($rowCategories['katID'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '-&nbsp;', $category_tree_array,'',$i,$type);
            
             if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) {
        $html .= '<div class="vFrontKatElemDelBtn" data-id="' . $rowCategories['katID'] . '" title="Löschen"></div><div class="vFrontKatElemChangeBtn" data-id="' . $rowCategories['katID'] . '" title="Bearbeiten"></div>';
      }
            
            $html.= '</li>';   
            
         }
         
       $html.= '</ul>';  
         
     }

    return $html;
}


public function getImagesArray($bildID){
    $return = '';
    $bildArr = explode(';',$bildID);
    $bildStr = implode(',',$bildArr);
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID IN ('.$bildStr.')';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg)) {
       
       $imageArr[$row['bildID']] = $row['bildFile'];
    }
    
    return $imageArr;
 
}


 public function getThePictureCropingWindow() {
    $_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC'] = 0;
    
    
   $imagesArr = $this->getImagesArray($_POST['_dateiElems']);
   $imgPath = '../../../user_upload/';
   $image = $imgPath.current($imagesArr);
   
   $size = getimagesize($image);
   $ids = array_keys($imagesArr);
    
    $return = '  <div class="container">
    <input type="hidden" name="xposition" value="">
    <input type="hidden" name="yposition" value="">
    <input type="hidden" name="x2position" value="">
    <input type="hidden" name="y2position" value="">
    <input type="hidden" name="currentId" value="'.$ids[0].'">
    <input type="hidden" name="newCategoryId" value="">
    <input type="hidden" name="idGallery" value="">
    <input type="hidden" name="widthImage" value="">
    <input type="hidden" name="heightImage" value="">
    <input type="hidden" name="heightImage" value="">
    <input type="hidden" name="imageData" value="">

	
       <link rel="stylesheet" href="/admin/frontAdmin/css/cropper.css" type="text/css" />';
        
         
   $return.=' <div class="row image-cropper-container">
      <div class="col-md-9">
        <!-- <h3 class="page-header">Demo:</h3> -->
        <div class="img-container">
          <img src="'.$image.'" alt="Picture" id="cropedImage" data-width="'.$size[0].'"  data-height="'.$size[1].'">
      </div>
	  
      <div class=" docs-buttons" style="margin-top: 10px;">
  

        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
          </button>
          <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
          </button>
        </div>

     


       


        <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
          </button>
      
        </div>
        
         <div class="btn-group">
          <button type="button" class="btn btn-primary" data-method="" title="Crop" id="saveCropImage1">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>Crop image
            </span>
          </button>
          
        </div>

    

</div>
	  
      </div>
    <div class="col-md-3">
                    <div class="avatar-preview preview-sm">';
					
	foreach($imagesArr as $key => $value){
          $size = getimagesize($imgPath.$value);
          
          $return.='<img src="'.$imgPath.$value.'" class="img img-crop-right" data-width="'.$size[0].'" data-height="'.$size[1].'" data-id="'.$key.'" id="img-'.$key.'">';
         
        }  
                    
                   $return.=' </div>
                    
                  </div>
    </div>
   <!-- /.docs-buttons -->
 
    </div>
  </div>';
    
   // $return .= '<div class="vFrontImgKatHolder">';
//    $return .= '<div class="categoryButton"><a>Images</a></div> ';
//   // $return .= '<div id="imageCategory">';
//    $return .= $this->buildMenu(0,'','','',1);
//    //$return .= '</div>';
//   // $return .= '<div style="clear:both;">';
//     $return .= '<div class="categoryButton"><a>Files</a></div> ';
//    //$return .= '<div id="filesCategory"> ';
//    $return .= $this->buildMenu(0,'','','',1,'files');
//   // $return .= '</div>';
//    $return .= '</div>';
//    
//    $return .= '<div class="vFrontImgVerwaltHolder">';
//    $return .= $this->getImageElements();
//    $return .= "</div><script>$('.tree1').treed();</script>";





 
    
    return $return;
  }


  
  
  // ***************************************************************************
  // ENDE - Funktionen für Kategorien verschieben
  // ***************************************************************************
  
}

?>