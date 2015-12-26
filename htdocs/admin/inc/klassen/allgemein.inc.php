<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


class cmsAllgemein extends funktionsSammlung {
  
  public function getNaviArtOptions() {
    $return = '';
    
    $sqlNavArtText = 'SELECT * FROM vnaviart';
    $sqlNavArtErg = $this->dbAbfragen($sqlNavArtText);
    
    while ($rowNavArt = mysql_fetch_array($sqlNavArtErg, MYSQL_ASSOC)) {
      $return .= '<option value="' . $rowNavArt['nartID'] . '">' . $rowNavArt['nartName'] . '</option>';
    }
    
    return $return;
  }
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Ausgabe der Drag Elemente Links
  // ***************************************************************************
  
  public function getSiteDragElements() {
    $return = '';
    
    $return .= $this->getSiteDragSystemElements();
    $return .= $this->getSiteDragOwnElements();
    
    return $return;
  }
  
  
  
  public function getSiteDragSystemElements() {
    $return = '';
    
    $sqlText = 'SELECT * FROM velement WHERE elemEigen = 1 AND elemHidden = 2 ORDER BY elemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['elemArt']) && $row['elemArt'] == "6") {
        if ($this->checkIsThisModuleActive('kontaktFormularBuilderModul')) {
          $return .= '<div class="vFrontDragElem" id="vCMSElem-' . $row['elemID'] . '" style="background-image:url(\'elemPics/' . $row['elemPic'] . '\')" title="' . $row['elemName'] . '">' . $row['elemName'] . '</div>';
        }
      }
      else if (isset($row['elemArt']) && $row['elemArt'] == "7") {
        if ($this->checkIsThisModuleActive('empfehlungManagerModul')) {
          $return .= '<div class="vFrontDragElem" id="vCMSElem-' . $row['elemID'] . '" style="background-image:url(\'elemPics/' . $row['elemPic'] . '\')" title="' . $row['elemName'] . '">' . $row['elemName'] . '</div>';
        }
      }
      else if (isset($row['elemArt']) && $row['elemArt'] == "8") {
        if ($this->checkIsThisModuleActive('empfehlungManagerModul')) {
          $return .= '<div class="vFrontDragElem" id="vCMSElem-' . $row['elemID'] . '" style="background-image:url(\'elemPics/' . $row['elemPic'] . '\')" title="' . $row['elemName'] . '">' . $row['elemName'] . '</div>';
        }
      }
      else {
        $return .= '<div class="vFrontDragElem" id="vCMSElem-' . $row['elemID'] . '" style="background-image:url(\'elemPics/' . $row['elemPic'] . '\')" title="' . $row['elemName'] . '">' . $row['elemName'] . '</div>';
      }
    }
    
    return $return;
  }
  
  
  
  public function getSiteDragOwnElements() {
    $return = '';
    
    $sqlText = 'SELECT * FROM velement WHERE elemEigen = 2 AND elemHidden = 2 ORDER BY elemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlErgCount = mysql_num_rows($sqlErg);
    
    if ($sqlErgCount > 0) {
      $return .= '<div style="height:30px;"></div>';
    }
    
    while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $elPic = '';
      if (isset($row['elemPic']) && !empty($row['elemPic'])) {
        $elPic = ' style="background-image:url(\'elemPics/' . $row['elemPic'] . '\')"';
      }
      $return .= '<div' . $elPic . ' class="vFrontDragElem" id="vCMSElem-' . $row['elemID'] . '" title="' . $row['elemName'] . '">' . $row['elemName'] . '</div>';
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Ausgabe der Drag Elemente Links
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Ausgabe der Sprachen
  // ***************************************************************************
  
  public function getLangAuswahlHeaderMenu() {
    $return = '';
    
    $sqlLangText = 'SELECT * FROM vsprachen WHERE langAktiv = 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    $i=1;
    while($row = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
     
         if($i==1){
            $curHrefUri = '';
            $defaultLang = $row['langKurzName']; 
            
         }else{
           $curHrefUri = $row['langKurzName'];  
         }   
      
      
      
      if (isset($_GET['page_name']) && !empty($_GET['page_name'])) {
          if($i==1){
             $curHrefUri = '/'.$_GET['page_name']; 
          }else{
             $curHrefUri = $row['langKurzName'].'/'.$_GET['page_name']; 
          }
    
      }
      $chekedClass = '';
      if (isset($_GET['_lang']) && $_GET['_lang'] == $row['langKurzName']) {
        $chekedClass = ' vFrontLangChangeElemChecked';
      } else if (!isset($_GET['_lang']) && $row['langStandard'] == 1) {
        $chekedClass = ' vFrontLangChangeElemChecked';
      }elseif(!isset($_GET['_lang']) && $i ==1 ){
          $chekedClass = ' vFrontLangChangeElemChecked';   
      }
      $return .= '<a style="text-decoration:none;" href="' . $curHrefUri . '"><div id="vLang-' . $row['langID'] . '" class="vFrontLangChangeElem' . $chekedClass . '" data-kname="' . $row['langKurzName'] . '">' . $row['langName'] . '</div></a>';
    $i++;
      
      }
    
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Ausgabe der Sprachen
  // ***************************************************************************
  
}

?>