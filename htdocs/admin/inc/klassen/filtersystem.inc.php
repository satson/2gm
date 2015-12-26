<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2015                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsOwnFiltersystem extends funktionsSammlung {
  
  public function showFilterSystemAdminWindow() {
    $return = '<div class="mmModulFiltersysAdminWindowHolder">';
    
    $return .= '<div class="mmModulFiltersysAdminWindowHead">';
    //$return .= '<div class="mmModulFiltersysAdminWindowHeadAuswahlFiltKatBtn">Auswählen</div>';
    $return .= '<div class="mmModulFiltersysAdminWindowHeadNewFiltKatBtn">Neue Filterkategorie</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    $return .= '<div class="mmModulFiltersysAdminWindowKatAuswahlHolder">';
    $return .= $this->getFilterSystemAdminWindowKategorienShow();
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getFilterSystemAdminWindowKategorienShow() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatAktiv = 1 ORDER BY filkatName ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    $tree =   $this->filterParentChildTree();
    
   // print_r($tree);
    
    
    
   foreach($tree as $key => $row){
      $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiFiltersysKat" data-id="'.$row['id'].'" style="margin-right:0px;">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">'.$row['name'].'</div>';
       $return .= '<div class="vFrontVerwPicElemShow vFrontEmpfAuflistungLiEmpfehlerShowData filterGalleryWindow" title="Anzeigen"  data-id="'.$row['id'].'"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElChange vFrontFiltersysAdminWinListChangeBtn" title="Bearbeiten" data-id="'.$row['id'].'"></div>';
      $return .= '<div class="vFrontHpSeAuflistungLiElDel vFrontFiltersysAdminWinListDelBtn" title="Löschen" data-id="'.$row['id'].'"></div>';
      $return .= '</div>';
    }
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  
  
  // ***************************************************************************
  // Neue Filtersystem Kategorie
  // ***************************************************************************
  
  public function showNewFiltersystemAdminKatgorieWindow() {
     
     $select = $this->getSelectfilterList();
   
     
      $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="parent_filter">In filter:</label>';
    $return .= '<select name="parent_filter" style="margin-bottom:10px;" id="filterParentId">'.$select.'</select>';
      
    $return .= '<label for="vFiltersystemFrmFiltKatName">Name:</label>';
    $return .= '<input id="vFiltersystemFrmFiltKatName" type="text" name="vFiltersystemFrmFiltKatName" style="margin-bottom:10px;" />';
     //$return.='<div style="clear:both;margin-top:20px;"></div> <input type="checkbox" name="filterData[header]" '.$header.' id="vFrontHpSeAllName" class="filterS" value="1"> Disable header
          // <input type="checkbox" name="filterData[footer]" '.$footer.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable footer
          // <input type="checkbox" name="filterData[column]" '.$column.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable left column';
    $return .= '<label for="vFiltersystemFrmFiltPosition">Position:</label>';
    $return .= '<input id="vFiltersystemFrmFiltPosition" type="text" name="vFiltersystemFrmFiltPosition" value="'.$curDataArr['filtkatPosition'].'" />';
    
    $return .= '<form id="vFiltersystemFrmFiltKatNameLangs">';
    $return .= $this->getForFiltersystemActiveCMSLangsFields();
    $return .= '</form>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input id="vFrontSaveNewNewFiltersystemKatForms" type="submit" value="Speichern" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function getForFiltersystemActiveCMSLangsFields() {
    $return = '';
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 AND langStandard = 2 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNumErg = mysql_num_rows($sqlErg);
    
    if (isset($sqlNumErg) && $sqlNumErg > 0) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div style="border-bottom:1px solid #999; width:348px; padding-bottom:5px;">Spracheinträge:</div>';
    }
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      
      $return .= '<label for="vFilterKatNameLang_'.$row['langKurzName'].'">Name: ('.$row['langKurzName'].')</label>';
      $return .= '<input id="vFilterKatNameLang_'.$row['langKurzName'].'" type="text" name="vFilterKatNameLang_'.$row['langKurzName'].'" />';
    }
    
    return $return;
  }
  
  
  
  public function saveNewFiltersystemAdminKatgorieWindow($filterKatName) {
    $curLangJson = '';
    if (isset($_POST['_langFilterKat']) && is_array($_POST['_langFilterKat'])) {
      $counter = 0;
      $i=1;
      foreach ($_POST['_langFilterKat'] as $key => $value) {
        $counter++;
        
        if (isset($counter) && $counter == 1) {
          $curLangJson .= '{';
          $curLangJson .= '"'.$value['name'].'":"'.$value['value'].'"';
        }
        else {
          $curLangJson .= ', "'.$value['name'].'":"'.$value['value'].'"';
        }
        
       
        
        $i++;
      }
      
      if (isset($counter) && $counter > 0) {
        $curLangJson .= '}';
      }
     
    }
    
     parse_str($_POST['filterData'],$out);
     
    $s = json_encode($out);
    
    $parent= $this->dbDecode($_POST['_filterParentId']);
    $url = $this->url_title($filterKatName);
  $sqlText = 'INSERT INTO vfilterkategorien (filkatName, filkatParent, filkatAktiv, filtkatLangJson,filtrUrl,filterSetting) VALUES ("'.$this->dbDecode($filterKatName).'", "'.$parent.'", "1", "'.$this->dbDecode($curLangJson).'","'.$url.'", "'.$this->dbDecode($s).'")';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    if (isset($sqlErg) && $sqlErg == true) {
      $curNewId = mysql_insert_id();
      
      $sqlTextU = 'UPDATE vfilterkategorien SET filtkatPosition = "'.$this->dbDecode($_POST['_position']).'" WHERE filkatID = "'.$this->dbDecode($curNewId).'"';
      $sqlErgU = $this->dbAbfragen($sqlTextU);
      
      $i=1;
      foreach ($_POST['_langFilterKat'] as $key => $value) {
        $url = $this->url_title($value['value']);
           $sqlText = 'INSERT INTO vfilterUrlLang (id_lang,id_filter, url_lang) VALUES ("'.$i.'", "'.$curNewId.'","'.$url.'")';
        $sqlErg = $this->dbAbfragen($sqlText);
        $i++;
    
    }
      
    }
  }
  
  
    public function getSelectfilterList(){
   
    $categoryList =  $this->filterParentChildTree();
   $return .= '<option value="">auswählen...</option>';
   $return .= '<option value="0">Filter</option>';
    foreach($categoryList as $key => $value){
        $return .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    
    return $return;
   
  }
  
  public function filterParentChildTree($parent = 0, $spacing = '', $category_tree_array = '',$in='') {
      
     
    global $dbConnection;
  
    if (!is_array($category_tree_array))
        $category_tree_array = array();
   
   if($in!=''){
     
     $sqlCategory = "SELECT * FROM vfilterkategorien WHERE  filkatParent IN ($in) ORDER BY filtkatPosition ASC";
   
   }else{
    $sqlCategory = "SELECT * FROM vfilterkategorien WHERE filkatParent = $parent ORDER BY filtkatPosition ASC";
   }
    
   
    $sqlErg =  $this->dbAbfragen($sqlCategory);
    
;
    if (mysql_num_rows($sqlErg) > 0) {
        while($rowCategories =   mysql_fetch_array($sqlErg)) {
            $category_tree_array[] = array("id" => $rowCategories['filkatID'], "name" => $spacing . $rowCategories['filkatName'],'parent'=>$rowCategories['filkatParent']);
            $category_tree_array = $this->filterParentChildTree($rowCategories['filkatID'], '&nbsp;&nbsp;&nbsp;&nbsp;'.$spacing . '', $category_tree_array,'');
        }
    }
    
    return $category_tree_array;
}

  
  
  
  // ***************************************************************************
  // Filtersystem Kategorie Bearbeiten
  // ***************************************************************************
  
  public function showBearFiltersystemAdminKatgorieWindow($filterKatID) {
    $curDataArr = $this->getForBearFiltersystemAdminKatgorieWindowData($filterKatID);
  
    
      $data = json_decode($curDataArr['filterSetting']);
      $header = ($data->filterData->header == 1)?'checked="checked"':"";
      $footer = ($data->filterData->footer== 1)?'checked="checked"':"";
      $column = ($data->filterData->column== 1)?'checked="checked"':"";
    
    if (!isset($curDataArr) || !is_array($curDataArr)) {
      return 'No Data';
    }
    
       $categoryList =   $this->filterParentChildTree();
     
      
       //print_r($categoryList);
       $select .= '<option value="0">Bilder</option>';
         foreach($categoryList as $key => $value){
          
         
          $selected = ($curDataArr['filkatParent'] == $value['id'])?'selected="selected"':'';
          
          $select .= '<option value="'.$value['id'].'"  '.$selected.' >'.$value['name'].'</option>';
      }
    
      $return = '<div class="vFrontSmallSeFrmHolder">';
    
    $return .= '<label for="parent_filter">In filter:</label>';
    $return .= '<select name="parent_filter" style="margin-bottom:10px;" id="filterParentId">'.$select.'</select>';
    
    $return .= '<label for="vFiltersystemFrmFiltKatName">Name:</label>';
    $return .= '<input id="vFiltersystemFrmFiltKatName" type="text"  style="margin-bottom:10px;" name="vFiltersystemFrmFiltKatName" value="'.$curDataArr['filkatName'].'" />';
    $return .= '<label for="vFiltersystemFrmFiltPosition">Position:</label>';
    $return .= '<input id="vFiltersystemFrmFiltPosition" type="text" name="vFiltersystemFrmFiltPosition" value="'.$curDataArr['filtkatPosition'].'" />';
    

// $return.='<div style="clear:both;margin-top:20px;"></div> <input type="checkbox" name="filterData[header]" '.$header.' id="vFrontHpSeAllName" class="filterS" value="1"> Disable header
          // <input type="checkbox" name="filterData[footer]" '.$footer.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable footer
          // <input type="checkbox" name="filterData[column]" '.$column.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable left column';
    $return .= '<form id="vFiltersystemFrmFiltKatNameLangs">';
    $return .= $this->getForFiltersystemActiveCMSLangsFieldsBear($curDataArr);
    $return .= '</form>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input id="vFrontSaveBearFiltersystemKatForms" type="submit" value="Speichern" data-id="'.$curDataArr['filkatID'].'" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getForFiltersystemActiveCMSLangsFieldsBear($curDataArr) {
    $return = '';
    
    $curJsonLangArr = '';
    if (isset($curDataArr['filtkatLangJson']) && !empty($curDataArr['filtkatLangJson'])) {
      $curJsonLangArr = json_decode($curDataArr['filtkatLangJson'], true);
    }
    
    $sqlText = 'SELECT * FROM vsprachen WHERE langAktiv = 1 AND langStandard = 2 ORDER BY langID ASC';
    $sqlErg = $this->dbAbfragen($sqlText);
    $sqlNumErg = mysql_num_rows($sqlErg);
    
    if (isset($sqlNumErg) && $sqlNumErg > 0) {
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      $return .= '<div style="border-bottom:1px solid #999; width:348px; padding-bottom:5px;">Spracheinträge:</div>';
    }
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $curLangVal = '';
      if (isset($curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']]) && !empty($curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']])) {
        $curLangVal = $curJsonLangArr['vFilterKatNameLang_'.$row['langKurzName']];
      }
      
      $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
      
      $return .= '<label for="vFilterKatNameLang_'.$row['langKurzName'].'">Name: ('.$row['langKurzName'].')</label>';
      $return .= '<input id="vFilterKatNameLang_'.$row['langKurzName'].'" type="text" name="vFilterKatNameLang_'.$row['langKurzName'].'" value="'.$curLangVal.'" />';
    }
    
    return $return;
  }
  
  
  
  private function getForBearFiltersystemAdminKatgorieWindowData($filterKatID) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vfilterkategorien WHERE filkatID = "'.$this->dbDecode($filterKatID).'" LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $row;
    }
    
    return $return;
  }
  
  
  
  public function saveBearFiltersystemAdminKatgorieWindow($filterKatName, $curFilterKatID) {
    $curLangJson = '';
    if (isset($_POST['_langFilterKat']) && is_array($_POST['_langFilterKat'])) {
      $counter = 0;
      foreach ($_POST['_langFilterKat'] as $key => $value) {
        $counter++;
        
        if (isset($counter) && $counter == 1) {
          $curLangJson .= '{';
          $curLangJson .= '"'.$value['name'].'":"'.$value['value'].'"';
        }
        else {
          $curLangJson .= ', "'.$value['name'].'":"'.$value['value'].'"';
        }
      }
      
      if (isset($counter) && $counter > 0) {
        $curLangJson .= '}';
      }
    }
    
    parse_str($_POST['filterData'],$out);
     
    $s = json_encode($out);
    $parent=$this->dbDecode($_POST['_filterParentId']);
    $position=$this->dbDecode($_POST['_position']);
    
     $sqlText = 'UPDATE vfilterkategorien SET filkatName = "'.$this->dbDecode($filterKatName).'",filkatParent='.$parent.', filtkatLangJson = "'.$this->dbDecode($curLangJson).'",filterSetting="'.$this->dbDecode($s).'",filtkatPosition="'.$position.'" WHERE filkatID = "'.$this->dbDecode($curFilterKatID).'"';
    $sqlErg = $this->dbAbfragen($sqlText);
    
     $query  = mysql_query("DELETE FROM vfilterUrlLang WHERE id_filter=".$this->dbDecode($curFilterKatID)."");
     $i=1;
     foreach ($_POST['_langFilterKat'] as $key => $value) {
        $url = $this->url_title($value['value']);
           $sqlText = 'INSERT INTO vfilterUrlLang (id_lang,id_filter, url_lang) VALUES ("'.$i.'", "'.$this->dbDecode($curFilterKatID).'","'.$url.'")';
        $sqlErg = $this->dbAbfragen($sqlText);
        $i++;
    }
    
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Löscht eine Filtersystem Kategorie
  // ***************************************************************************
  
  public function delFiltersystemAdminKatgorieNow($filterKatID) {
    $sqlText = 'DELETE FROM vfilterkategorien WHERE filkatID = "'.$this->dbDecode($filterKatID).'"';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  
  
  
  
  // ***************************************************************************
  // Zeigt die Filtersystem Kategorien für Listen zuweisung an
  // ***************************************************************************
  
  public function showFiltersystemAuswahlListBySettingsAuswahlWinMulti() {
    $return = '<div class="mmModulFiltersysAdminWindowHolder">';
    
    $return .= '<div class="mmModulFiltersysAdminWindowHead">';
    $return .= '<div class="mmModulFiltersysAdminWindowHeadAuswahlFiltKatBtn">Auswählen</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '</div>';
    
    $return .= '<div class="mmModulFiltersysAdminWindowKatAuswahlHolder">';
    $return .= $this->getFilterSystemAdminWindowKategorienShowAuswahlList();
    $return .= '</div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
 private function getFilterSystemAdminWindowKategorienShowAuswahlList() {
    $return = '<div class="vFrontHpSeAuflistung">';
    
    
     $tree =   $this->filterParentChildTree();

     foreach($tree as $key => $row){
      $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiFiltersysKat" data-id="'.$row['id'].'" data-name="'.$row['name'].'" style="margin-right:0px;">';
      $return .= '<div class="vFrontHpSeAuflistungLiElName">'.$row['name'].'</div>';
      $return .= '</div>';
    }
    
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  public function showShowFilterImageWindow($selemID) {
    $return = '';
   // $curPicData = $this->getOwnElemPicGaleriePicData($selemID);
   // $curPicGalData = $this->getOwnElemPicGalerieIdData($selemID);
    $idFiltr = $_POST['_idFilter'];
    $imageQuery = mysql_query("SELECT * FROM vfilterBilder WHERE id_filtr = '$idFiltr '");
    while($row = mysql_fetch_array($imageQuery )){
        $imagesArr[] = $row['id_bild'];
    }
    
     $imagesStr = implode(';',$imagesArr);
    
    
    $return .= '<div class="vFrontSmallSeFrmHolder" style="z-index:1000000">';
    

    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    
    $return .= '<div data-field="vFrontFrmOwnElemPicGalImgs" class="vFrontFrmListHolder">
           <input type="hidden" value="'.$imagesStr.'" id="vFrontFrmOwnElemPicGalImgs" name="vFrontFrmOwnElemPicGalImgs">
           <div class="vFrontFrmListHolderHeader">
             <div class="vFrontFrmListHolderHeaderUe">Bilder</div>
             <div class="vFrontFrmListHolderHeaderSort"></div>
             <div class="vFrontFrmListHolderHeaderAdd" id="addImageToFilter" data-type="filter"></div>
             <div class="vFrontFrmListHolderHeaderDel"></div>
           </div>
           <div class="vFrontFrmListHolderLists">'.$this->buildFilterPicGaleriePicLists($curPicData).'</div>
         </div>';
    
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    $return .= '<input style="margin-left:0px;" type="submit" value="Speichern" id="vSaveOwnFilterPicGalChange" data-id="' . $selemID . '" />';
    $return .= '</div>';
    
    return $return;
  }
  
  
   private function buildFilterPicGaleriePicLists() {
    $return = '';
    
;
    $id_filtr = mysql_escape_string($_POST['_idFilter']);
    $imageQuery = mysql_query("SELECT * FROM vfilterBilder WHERE id_filtr = '$id_filtr'");

    
   
    if (mysql_num_rows($imageQuery)>0) {
    
      
    while($images = mysql_fetch_array($imageQuery)){
        
        $description = json_decode($images['description']);
        
     $sqlTextList = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($images['id_bild']) . ' LIMIT 1';
        
        $sqlErgList = $this->dbAbfragen($sqlTextList);
        while ($rowList = mysql_fetch_array($sqlErgList, MYSQL_ASSOC)) {
          $return .= '<div class="vFrontFrmListsElem" data-elem="' . $rowList['bildID'] . '">
              <div class="vFrontFrmListsElemBild">
                <img src="user_upload/' . $rowList['bildFile'] . '" alt="" title="" />
              </div>
              <div class="vFrontFrmListsElemText">' . $rowList['bildName'] . '..</div>
              ';
          
              $return.= '<div class="clearer"></div>';
              
             $query1 = mysql_query('SELECT * FROM `vsprachen` WHERE langAktiv= 1');
             $description = json_decode($images['description']);
             
             while($row = mysql_fetch_array($query1)){
                  $return.='<input type="text" value="'.$description->$row['langKurzName'].'" class="filterDescription" data-lang="'.$row['langKurzName'].'" name="filter[' . $rowList['bildID'] . ']['.$row['langKurzName'].']">';
              }
              

            $return .='</div>';
        }
        
        
        
      }
    }
    
     $query1 = mysql_query('SELECT * FROM `vsprachen` WHERE langAktiv= 1');
     while($row = mysql_fetch_array($query1)){
       $langArr[$row['langKurzName']] = $row['langKurzName'];
     }
     $langJson= json_encode($langArr);
     $return.= '<input type="hidden" value='.$langJson.' id="filterLanguage">';
    
    return $return;
  }
  
  
  public function saveImagesToFiltr(){
   //   echo "DELETE FROM vfilterBilder WHERE id_filter='$id_filter'";
       $idFiltr  = mysql_escape_string($_POST['_selemID']);
       
       parse_str($_POST['_description'], $descArr);
       
    
       $query = mysql_query("DELETE FROM vfilterBilder WHERE id_filtr='$idFiltr'");
       $images = $_POST['_picGalImages'];
       $imagesArr = explode(';',$images);
      
       if($query && !empty($imagesArr)){
          foreach($imagesArr as $key => $value){
            if($value != ''){
                
             $description = json_encode($descArr['filter'][$value]) ;   
             $query =  mysql_query("INSERT INTO vfilterBilder SET id_filtr='$idFiltr',id_bild='$value',description='$description '");     
            }
             
          }
        
       } 
      
     return true;
      
  }
  
  public function getSiteByFilter($filters){
    
    $fArr = explode(';',$filters);
    $in = implode(',',  array_filter($fArr));
    $where = 'id_filtr IN('.$in.')';
     
    $query = mysql_query("SELECT * FROM vseitenFilter WHERE ".$where. ' GROUP BY id_site');
    while ($row=mysql_fetch_array($query)){
         $siteArr[] = $row['id_site']; 
    }
      
    return $in = implode(',',$siteArr);
  
  }
  
  
  function getSettingsForm(){
      
      $query = mysql_query("SELECT * FROM vhomepage  WHERE hpID=1");
      $row = mysql_fetch_array($query);
      $data = json_decode($row['hpFilter']) ;
 
      
      $header = ($data->filterData->header == 1)?'checked="checked"':"";
      $footer = ($data->filterData->footer== 1)?'checked="checked"':"";
      $column = ($data->filterData->column== 1)?'checked="checked"':"";
      
      $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Filters settings</div>';
       $return .='<div class="vFrontFrmHolder">
           <div class="vFrontLblAbstand"></div>
           <input type="checkbox" name="filterData[header]" '.$header.' id="vFrontHpSeAllName" class="filterS" value="1"> Disable header
           <input type="checkbox" name="filterData[footer]" '.$footer.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable footer
           <input type="checkbox" name="filterData[column]" '.$column.'  id="vFrontHpSeAllName" class="filterS" value="1"> Disable left column

           
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         
         <input style="width:150px;" type="submit" value="Speichern" class="saveSettingFilter" data-id="1"></div>';
      
      return $return;
      
  }
  
  
   public function saveSettings($data){

      $query = mysql_query("UPDATE vhomepage SET hpfilter='$data' WHERE hpID=1");
      
      if($query){
          return true;
      }else{
          
          return false;
      }
      
      
  }
  
  public function getSettings($type='global',$url = ''){
      
      if($type == 'global'){
          
      
        $query = mysql_query("SELECT hpFilter FROM vhomepage WHERE hpID = 1");
        $row = mysql_fetch_array($query);
        $filterSetting = json_decode($row['hpFilter'],true);
        
      }else{
         
        $id_filtr = $this->getFiltrByUrl($url);
      
    
         $query = mysql_query("SELECT filterSetting FROM vfilterkategorien WHERE filkatID= '$id_filtr'");
        $row = mysql_fetch_array($query);
        
        
     $filterSetting = json_decode($row['filterSetting'],true);  
    
          
      }
      
      return $filterSetting;
      
  }
  private function getFiltrByUrl($url){
      $url = mysql_escape_string($url);
      
     
      $query = mysql_query("SELECT * FROM vfilterUrlLang WHERE url_lang ='$url'")or die(mysql_error());
      if(mysql_num_rows($query)>0){
        $row = mysql_fetch_array($query);
        return $row['id_filter'];
      }
  
  
}

}