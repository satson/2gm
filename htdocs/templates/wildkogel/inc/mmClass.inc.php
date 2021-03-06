<?php  


// Funktions Sammlung
// ************************************************
// Version:  2.0.0
// 
// Entwickler: Michael Marth
// ************************************************


class mmFunctionsLibrary extends funktionsSammlung {
    
    
    
  
  // ***************************************************************************
  // Detail Seiten Listenansicht
  // ***************************************************************************
  
  public function mmGetSiteListDataArray($siteParent, $detailElemId) {
    $return = array();
    
    $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$row['seitID']] = array();
      $return[$row['seitID']]['seitTextUrl'] = $row['seitTextUrl'];
      $return[$row['seitID']]['detailElemData'] = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
        unset($return[$row['seitID']]);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return[$row['seitID']]['detailElemData']['selemID']) == false) {
        unset($return[$row['seitID']]);
      }
    }
    
    return $return;
  }
  
  
  
  
  
  public function mmGetSiteListDataArrayOnce($siteId, $detailElemId) {
    $return = array();
    
    $sqlText = 'SELECT seitID, seitTextUrl,seitBackImages FROM vseiten WHERE seitID = '.$this->dbDecode($siteId).' AND seitOnline = 1 ORDER BY seitPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return['seitID'] = $row['seitID'];
      $return['seitTextUrl'] = $row['seitTextUrl'];
      $return['seitBackImages'] = $row['seitBackImages'];
      $return['detailElemData'] = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
        unset($return);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return['detailElemData']['selemID']) == false) {
        unset($return);
      }
    }
    
    return $return;
  }
  
  
  public function getSitesByParent($idParent){
      
    $return = array();
    
    $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($idParent).' ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$row['seitID']] = array();
      $return[$row['seitID']]['seitTextUrl'] = $row['seitTextUrl'];
      $return[$row['seitID']]['detailElemData'] = $this->mmGetSiteDetailElementDataArr($row['seitID'], $detailElemId);
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
      //  unset($return[$row['seitID']]);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return[$row['seitID']]['detailElemData']['selemID']) == false) {
      //  unset($return[$row['seitID']]);
      }
    }
    return $return; 
  }
  
  public function getChildsSitesAndElements($siteId,$elementsArr,$parent =null){
      
   $return = array();
    if($parent == 1){
       $sqlText = 'SELECT seitID, seitTextUrl,seitBackImages,seitName,seitTextUrl	 FROM vseiten WHERE seitID IN ('.$this->dbDecode($siteId).')  ORDER BY seitParent DESC,seitPosition ASC '; 
    }else{
       $sqlText = 'SELECT seitID, seitTextUrl,seitBackImages,seitName,seitTextUrl	 FROM vseiten WHERE seitParent IN ('.$this->dbDecode($siteId).') ORDER BY seitParent DESC,  seitPosition ASC   ';   
    }
    
     
    
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$row['seitID']]['seitID'] = $row['seitID'];
      $return[$row['seitID']]['seitBackImages'] = $row['seitBackImages'];
      $return[$row['seitID']]['seitName'] = $row['seitName'];
       $return[$row['seitID']]['seitTextUrl'] = $row['seitTextUrl'];
      
      if(!empty($elementsArr)){
        
      $elementsIn = implode(',',$elementsArr);
          
         $return[$row['seitID']]['detailElemData'] = $this->mmGetSiteDetailMultiElementDataArr($row['seitID'],  $elementsIn); 
      }
      
      if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($row['seitID']) == false) {
        //unset($return);
      }
      else if ($this->checkIsThisElementOnlineByCheckAndDateTimeMM($return['detailElemData']['selemID']) == false) {
       // unset($return);
      }
    }
    
    return $return;
      
      
  }
  
 
  
  public function mmGetSiteDetailMultiElementDataArr($siteId, $elemIn,$elemNotIn=null) {
      
      
    $return = array();
    $langInhaltJson = '';

    $notIn = " AND selemDataName != 'curInElementHolder$elemNotIn'";
    
      $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteId).' AND elemID IN ('.$elemIn.') '.$notIn.' ORDER BY selemPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
     
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[$row['elemID']] = $row;
      
      $images =  $this->getAllPicOnceIdsFromPicGalery($row['selemPicGal']);
      
      
      $imagesArr = explode(',',$images);
      
      foreach($imagesArr as $key => $value){
          $return[$row['elemID']]['gallery'][] =   $this->getPicOnceDataByIdMM($value);
      }
      
       if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
           
        $curLangID = $this->getCurentLangIdBySiteTextUri($_POST['VCMS_POST_LANG']);
        $langInhaltJson = $this->mmGetSiteDetailElementDataInhaltJsonOnLang($curLangID, $siteId, $row['elemID']);
       }
       
      if (isset($langInhaltJson) && !empty($langInhaltJson)) {  
        $return[$row['elemID']]['selemInhalt']= $this->buildNewCurentLangJsonSelemInhalt($return[$row['elemID']]['selemInhalt'], $langInhaltJson);
      }
    }
    return $return;
  }
  
  public function mmGetSiteDetailElementDataArr($siteId, $detailElemId) {
    $return = array();
    $langInhaltJson = '';
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLangID = $this->getCurentLangIdBySiteTextUri($_POST['VCMS_POST_LANG']);
      $langInhaltJson = $this->mmGetSiteDetailElementDataInhaltJsonOnLang($curLangID, $siteId, $detailElemId);
    }
    
      $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteId).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
      if (isset($langInhaltJson) && !empty($langInhaltJson)) {
        $return['selemInhalt'] = $this->buildNewCurentLangJsonSelemInhalt($return['selemInhalt'], $langInhaltJson);
      }
    }
    
    /*if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($siteId) == false) {
      unset($return);
    }*/
    
    return $return;
  }
  
  
  //1.09.2015
  
  public function mmGetSiteDetailElementMultiDataArr($siteId, $detailElemId) {
    $return = array();
    $langInhaltJson = '';
    
    if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
      $curLangID = $this->getCurentLangIdBySiteTextUri($_POST['VCMS_POST_LANG']);
      $langInhaltJson = $this->mmGetSiteDetailElementDataInhaltJsonOnLang($curLangID, $siteId, $detailElemId);
    }
    
     $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteId).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC ';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return[] = $row;
      if (isset($langInhaltJson) && !empty($langInhaltJson)) {
        $return['selemInhalt'][] = $this->buildNewCurentLangJsonSelemInhaltTest($return['selemInhalt'], $langInhaltJson);
      }
    }
    
 
    
    /*if ($this->checkIsThisSiteOnlineByCheckAndDateTimeMM($siteId) == false) {
      unset($return);
    }*/
    
    
    return $return;
  }
  
  
  
  
  public function getAllSiteIDsArrUnderThisParent($siteParent) {
    $return = array();
    
    $sqlText = 'SELECT seitID FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return['s'.$row['seitID']] = $row['seitID'];
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Detail Seiten Listenansicht - Sprachfelder
  // ***************************************************************************
  
  public function getCurentLangIdBySiteTextUri($langUri) {
    $return = 0;
    
    $sqlLangText = 'SELECT langID FROM vsprachen WHERE langKurzName = "' . $this->dbDecode($langUri) . '" LIMIT 1';
    $sqlLangErg = $this->dbAbfragen($sqlLangText);
    
    while ($rowLang = mysql_fetch_array($sqlLangErg, MYSQL_ASSOC)) {
      $return = $rowLang['langID'];
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteDetailElementDataInhaltJsonOnLang($langID, $siteID, $detailElemId) {
    $return = '';
    
    $sElemId = $this->mmGetSiteDetailElementIdForLang($siteID, $detailElemId);
    
    $sqlText = 'SELECT selangInhalt FROM vselemlang WHERE langID = "' . $this->dbDecode($langID) . '" AND selemID = "'.$this->dbDecode($sElemId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['selangInhalt'];
    }
    
    return $return;
  }
  
  
  
  public function mmGetSiteDetailElementIdForLang($siteID, $detailElemId) {
    $return = '';
    
    $sqlText = 'SELECT selemID FROM vseitenelemente WHERE seitID = '.$this->dbDecode($siteID).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['selemID'];
    }
    
    return $return;
  }
  
  
   public function getDefaultMainData($selemID, $detailElemId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = '.$this->dbDecode($selemID).' AND elemID = '.$this->dbDecode($detailElemId).' ORDER BY selemPosition ASC LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
   $row = mysql_fetch_array($sqlErg, MYSQL_ASSOC);
  
    
    return  $row;
  }
  
  
  
    
  public function buildNewCurentLangJsonSelemInhaltTest($selemInhalt, $selemInhaltLang) {
    $selemInhaltArrNew = array();
    $selemInhaltArr = json_decode($selemInhalt, true);
    $selemInhaltLangArr = json_decode($selemInhaltLang, true);
    
   
    
    foreach ($selemInhaltArr as $key => $value) {
      if (isset($selemInhaltLangArr[$key]) && !empty($selemInhaltLangArr[$key]) && $selemInhaltLangArr[$key] != '[vcms-empty-lang]') {
        $selemInhaltArrNew[$key] = $selemInhaltLangArr[$key];
      }
      else {
        $selemInhaltArrNew[$key] = $value;
      }
    }
    
    return json_encode($selemInhaltArrNew);
  }
  
  
  
  
  public function buildNewCurentLangJsonSelemInhalt($selemInhalt, $selemInhaltLang) {
   
   
    $selemInhaltArrNew = array();
    $selemInhaltArr = json_decode($selemInhalt, true);
    $selemInhaltLangArr = json_decode($selemInhaltLang, true);
    
    foreach ($selemInhaltArr as $key => $value) {
      if (isset($selemInhaltLangArr[$key]) && !empty($selemInhaltLangArr[$key]) && $selemInhaltLangArr[$key] != '[vcms-empty-lang]') {
        $selemInhaltArrNew[$key] = $selemInhaltLangArr[$key];
      }
      else {
        $selemInhaltArrNew[$key] = $value;
      }
    }
    
    return json_encode($selemInhaltArrNew);
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Bilder
  // ***************************************************************************
  
  public function getAllPicOnceIdsFromPicGalery($picGalId) {
    $return = '';
    
    $sqlText = 'SELECT galBilder FROM vbildergalerien WHERE galID = "'.$this->dbDecode($picGalId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['galBilder'];
    }
    
    return $return;
  }
  
  
  
  public function getAllPicOnceIdsFromElementPicGalery($selemConfig) {
    $return = '';
    
    if (isset($selemConfig) && !empty($selemConfig)) {
      $curSelemConfArr = json_decode($selemConfig, true);
      if (isset($curSelemConfArr['picGal']) && !empty($curSelemConfArr['picGal'])) {
        $return = $curSelemConfArr['picGal'];
      }
    }
    
    return $return;
  }
  
  
  
  public function getPicOnceDataByIdMM($picId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = "'.$this->dbDecode($picId).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Filtersystem Kategorien
  // ***************************************************************************
  
  public function mmGetAllFilterkategoriesListArray($siteParent, $detailElemId, $assocArr = false) {
    $return = array();
    
   $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
   
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $detailElemArr = $this->mmGetSiteDetailElementMultiDataArr($row['seitID'], $detailElemId);
		
	
		
      if (isset($detailElemArr['selemOwnConfig']) && !empty($detailElemArr['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($detailElemArr['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $explodeArr = explode(';', $detailElemSettingArr['vOwnUserSettings']['filterKat']);
	
          foreach ($explodeArr as $value) {
            $curDataNameFilKat = $this->mmGetOneFiltersystemKatDataName($value);
            if (isset($curDataNameFilKat) && !empty($curDataNameFilKat)) {
              
              $curDataNameFilKat = str_replace('p_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('az_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('tt_', '', $curDataNameFilKat);
              
              if (isset($assocArr) && $assocArr == true) {
                $return['i'.$value] = $curDataNameFilKat;
              }
              else {
                $return[$value] = $curDataNameFilKat;
              }
            }
          }
        }
      }
      
      
      
    }
    
    return $return;
  }
  
  
  
    public function mmGetAllMultiFilterkategoriesListArray($siteParent, $detailElemId, $assocArr = false) {
    $return = array();
    
   $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitParent = '.$this->dbDecode($siteParent).' AND seitOnline = 1 ORDER BY seitPosition ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
   
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $detailElemArr1 = $this->mmGetSiteDetailElementMultiDataArr($row['seitID'], $detailElemId);
		
	
	foreach($detailElemArr1 as $key => $detailElemArr){
		   
     
         if (isset($detailElemArr['selemOwnConfig']) && !empty($detailElemArr['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($detailElemArr['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $explodeArr = explode(';', $detailElemSettingArr['vOwnUserSettings']['filterKat']);
	
          foreach ($explodeArr as $value) {
            $curDataNameFilKat = $this->mmGetOneFiltersystemKatDataName($value);
            if (isset($curDataNameFilKat) && !empty($curDataNameFilKat)) {
              
              $curDataNameFilKat = str_replace('p_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('az_', '', $curDataNameFilKat);
              $curDataNameFilKat = str_replace('tt_', '', $curDataNameFilKat);
              
              if (isset($assocArr) && $assocArr == true) {
                $return['i'.$value] = $curDataNameFilKat;
              }
              else {
                $return[$value] = $curDataNameFilKat;
                
              }
            }
            
            
          }
        }
      }
      
     
     
		  }
    
  
      
      
    }
    
    return $return;
  }
  
  
  
  public function mmGetAllFilterkategoriesListFromOneDetailElementArray($detailElemId) {
    $return = '';
    
      $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "'.$detailElemId.'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemOwnConfig']) && !empty($row['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($row['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $return = $detailElemSettingArr['vOwnUserSettings']['filterKat'];
        }
      }
    }
    
    return $return;
  }
  
  //01.09.2015/////////////////
  
  public function mmGetAllFilterkategoriesListBySiteID($seitID) {
    $return = '';
    
      $sqlText = 'SELECT * FROM vseitenelemente WHERE seitID = "'.$seitID.'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      if (isset($row['selemOwnConfig']) && !empty($row['selemOwnConfig'])) {
        $detailElemSettingArr = json_decode($row['selemOwnConfig'], true);
        if (isset($detailElemSettingArr['vOwnUserSettings']['filterKat']) && !empty($detailElemSettingArr['vOwnUserSettings']['filterKat'])) {
          $return[] = $detailElemSettingArr['vOwnUserSettings']['filterKat'];
        }
      }
    }
    
    return $return;
  }
  
  
  
  
  private function mmGetOneFiltersystemKatDataName($filterKatId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 AND filkatID = "'.$filterKatId.'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['filkatName'];
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        if (isset($row['filtkatLangJson']) && !empty($row['filtkatLangJson'])) {
          $curLangJsonArr = json_decode($row['filtkatLangJson'], true);
          $curLangK = $_POST['VCMS_POST_LANG'];
          if (isset($curLangJsonArr['vFilterKatNameLang_'.$curLangK]) && !empty($curLangJsonArr['vFilterKatNameLang_'.$curLangK])) {
            $return= $curLangJsonArr['vFilterKatNameLang_'.$curLangK];
          }
        }
      }
      $data= array('name'=>$return,'parent'=>$row['filkatParent']) ;
      
    }
    
    return  $data;
  }
  
  
 public function getFilterTree($parent=0,$deep=''){
     $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 AND filkatParent="'.$parent.'"  ORDER BY filkatName ASC';
     $sqlErg = $this->dbAbfragen($sqlText);
     $html.= '<ul class="v_siteUnterMenu'.$deep.'">';
     $deep++;
     while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
       if($deep >1 ){
      //  $checkbox = '<span class=""><input type="checkbox" name="filtr" value="" data-id="'.$row['filkatID'].'" ></span>';
       }else{
        $checkbox = '';
       }
       $html.='<li class="menuPoint filterItem" data-id="'.$row['filkatID'].'" >'.$checkbox.$row['filkatName'];
       $html.= $this->getFilterTree($row['filkatID'],$deep);
       $html.='</li>';
     }
     return  $html.= '</ul>';
 }
   
  
  public function getCurSiteNameBySiteIdOnlyMM($curSiteId) {
    $return = '';
    
    $sqlText = 'SELECT seitID, seitName FROM vseiten WHERE seitID = '.$this->dbDecode($curSiteId).' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row['seitName'];
    }
    
    return $return;
  }
  
  public function getFiltrByUrl($url){
      $url = mysql_escape_string($url);
      $query = mysql_query("SELECT * FROM vfilterkategorien WHERE filtrUrl ='$url'");
      if(mysql_num_rows($query)>0){
        $row = mysql_fetch_array($query);
        return $row['filkatID'];
      }
     
  }
  
  
  public function getElem($id){
        $sqlText = 'SELECT * FROM vseitenelemente WHERE selemID = "'.$id.'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
  return  $row = mysql_fetch_array($sqlErg, MYSQL_ASSOC);
      
  }
  
  
  ///////////////////wildkogel//////////////////
  
  public function getParentSites($idSite){ 
    $parentArr = $this->getSitesByParent($idSite);

    foreach ($parentArr as $key => $value){
        $parentArr[$key]['children'] = $this->getSitesByParent($key); 
    }

    foreach($parentArr as $key => $value){
        if(!empty($value['children'])){
            foreach($value['children'] as $key1 => $value1){
               $siteArr[] =  $key1; 
            }
        }else{
            $siteArr[] =  $key; 
        } 
    }
    return $siteArr;  
  }
  
  public function getFilters($idSite,$notIn=''){
      $query  = mysql_query("SELECT id_filtr,filkatParent,filtkatLangJson,id_site FROM vseitenFilter JOIN vfilterkategorien ON id_filtr=filkatID WHERE id_site='$idSite' AND filkatParent!=0");
      while($row = mysql_fetch_array($query)){
      
         // if(in_array($row['id_filtr'],$notIn)){
             
              $names = json_decode($row['filtkatLangJson']);
              $name = $names->vFilterKatNameLang_de;
              $filtrArr[$row['id_filtr']] = array('name'=>$name,'id'=>$row['id_filtr'],'id_site'=>$row['id_site']);
               if(key_exists($row['filkatParent'],$filtrArr)){
                 $filtrArr[$row['filkatParent']]['children'][] = array('name'=>$name,'id'=>$row['id_filtr'],'id_site'=>$row['id_site']);
                 unset($filtrArr[$row['id_filtr']]);
               }
         // }
          
      }
    return $filtrArr;
  }
  
  
  public function getFiltersIds($idSite){
      
      $query  = mysql_query("SELECT id_filtr,filkatParent,filtkatLangJson FROM vseitenFilter JOIN vfilterkategorien ON id_filtr=filkatID WHERE id_site='$idSite'");
      while($row = mysql_fetch_array($query)){
        
          $filtrArr[] = $row['id_filtr'];
         
      }
    return $filtrArr; 
      
  } 
  
  
  public function cartButton($siteId,$tab='10'){
      
      if($tab == ''){
          $tab = 21;
      }
      $return = '<div class="dropdownHeart basketButton addItem"  data-siteid="'.$siteId.'" data-dropid="" data-type="site" data-target="'.$tab.'">
		 <img src="templates/wildkogel/img/heart-inaktiv.png"  title="'.lang('traum-heart').'" class="tooltipster-top">
		 </div>';
      return $return;
  }
  
  
  public function translate($key){
      
      
      print_r($this->langSite);
      
     return $this->langSite[$key];
      
  }
  
   
  
}


?>