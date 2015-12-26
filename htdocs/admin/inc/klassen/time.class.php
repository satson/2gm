<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2015                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/
 


class cmsTimeModul extends funktionsSammlung {
  
  
  public function getTimeHash($where){
   
     $return = '';
     $sqlText = 'SELECT * FROM time_hash '.$where;
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $orderArr[$rowPr['id_hash']] = array('name'=>$rowPr['name']);                    
    }
   
    return $orderArr;
  }
  
  
  public function saveTimeHash($name,$id=null){
      
   if($name !=''){
       $name = mysql_escape_string($name);
       $id   = mysql_escape_string($id);
       
       if($id){
            $query = mysql_query("UPDATE time_hash SET name='$name' WHERE id_hash='$id'") or die(mysql_error());
        }else{
            $query = mysql_query("INSERT INTO time_hash SET name='$name'") or die(mysql_error());
                            
        }
        if($query){
            echo 'ok';
        }else{
           return; 
        }
        
   }
  
  }
  
  
  public function dellTimeHash($id){
      $id = mysql_escape_string($id);
      $query = mysql_query("DELETE FROM time_hash WHERE id_hash = '$id'") or die(mysql_error());
       if($query){
            echo 'ok';
        }else{
           return; 
        }
  }
  
  
  
  
  public function getHashTexts($where){
   
    $return = '';
    $sqlText = 'SELECT * FROM time_hash_texts '.$where;
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $textsArr[$rowPr['id_ht']][$rowPr['id_lang']] = array('id_hash'=>$row['id_ht'],'title'=>$rowPr['title']);                    
    }
   
    return $textsArr;
  }
  
  
  public function saveHashTexts($data){
   if(!empty($data)){
       if($id){
            $title  = mysql_escape_string($data['title']);                
            $query = mysql_query("UPDATE time_hash_texts SET title='$title' WHERE id_ht='$id'") or die(mysql_error());
        }else{
            $title  = mysql_escape_string($data['title']);
            $idHash = mysql_escape_string($data['id_hash']);
            $idLang = mysql_escape_string($data['id_lang']);
            $query = mysql_query("INSERT INTO time_hash_texts SET id_h = '$idHash', id_lang='$idLang',title='$title'") or die(mysql_error());
            $id = mysql_insert_id();
        }
        return $id;
   }
  }
  
  
  public function dellHashTexts(){
      $id = mysql_escape_string($id);
      $query = mysql_query("DELETE FROM time_hash WHERE id_ht = '$id'") or die(mysql_error());
      return $id;
  }
  
  
  
  public function getTimes($where){
   
    $return = '';
    $sqlText = 'SELECT * FROM times '.$where;
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $textsArr[$row['id_th']][$rowPr['id_t']] = array('id_hash'=>$row['id_th'],'from_data'=>$rowPr['from_data'],'to_data'=>$rowPr['to_data'],'option_time'=>$rowPr['option_time']);                    
    }
   
    return $textsArr;
  }
  
  
  public function saveTimes($data,$id){
   if(!empty($data)){
       
       $from_date = mysql_escape_string($data['from_date']);
       $to_date   = mysql_escape_string($data['to_date']);
       $opt   = mysql_escape_string($data['option']);
       
       if($id){
            $query = mysql_query("UPDATE times SET date_from='$from_date',to_date='$to_date',option_time='$opt' WHERE id_t='$id'") or die(mysql_error());
        }else{
            $query = mysql_query("INSERT INTO time_hash_texts SET date_from='$from_date',to_date='$to_date',option_time='$opt'") or die(mysql_error());
            $id = mysql_insert_id();
        }
        return $id;
   }
  }
  
  
  public function dellTimes(){
      $id = mysql_escape_string($id);
      $query = mysql_query("DELETE FROM times WHERE id_ht = '$id'") or die(mysql_error());
      return $id;
  }
  
  
  public function listHash(){
      
      
          $return = '<div class="vFrontHpSeAuflistung vFrontTimeAuflistung">';
          
          $return .= '<div class="vFrontHpSeAuflistungUnUe">Time hash</div>';
          $return .= '<div id="vFrontNewHash" data-id="">New Hash</div><div class="clearer"></div>';
    
            $sqlTextS = "SELECT * FROM time_hash ";
            $sqlErgS = $this->dbAbfragen($sqlTextS);
    
            while($rowElE = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
              $return .= '<div class="vFrontHpSeAuflistungLiLay">';
              $return .= '<div class="vFrontHpSeAuflistungLiLayName"  >' . $rowElE['name'] .'</div>';
              $return .= '<div class="vFrontEditHash" data-id="' . $rowElE['id_hash'] . '" title="Bearbe"></div>';
                $return .= '<div class="vFrontDelHash" data-id="' . $rowElE['id_hash'] . '" title="Löschen"></div>';

              $return .= '</div>';
            }
          
          $return.='</div>';
              
      
      return $return;
      
  }
  
    public function addHashForm(){
        $name = '';
        $id   = '';
        if(!empty($_POST['id'])){
            $id = mysql_escape_string($_POST['id']);
            $hash = $this->getTimeHash(' WHERE id_hash='.$id);
            $name = $hash[$id]['name']; 
                            
        }
        
          $return = '<div class="vFrontHpSeAuflistungUnUeAllg" style="margin-bottom:0px;">Edit Hash</div>
              <div class="vFrontFrmHolder"><label for="vFrontHpSeSiteLayoutName">Name:</label>
         <div class="vFrontLblAbstand"></div>
         <input type="text" name="hashName" id="nameHash" style="width:275px;" value="'.$name.'" />';
        
            $return .= '<input type="hidden" value="'.$id.'" name="id" id="idHash">'; 
        

         $return .= '
         <div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:135px;" type="submit" value="Speichern" id="vFrontSaveNewHash" />
         <input style="width:135px; background-color:#C0392B; margin-left:15px;" type="submit" value="Abbrechen" id="vFrontCancelNewHash" /></div>';
        
         if($id != ''){
            $return.='<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>
                <input style="width:135px;" type="submit" value="Add Titles and dates" id="vFrontAddTitle" />
               
         <div class="vFrontLblAbstand"></div>'; 
          
         }
         
         
         
              
      
      return $return;
      
  }
  
  
  
  
  public  function getItemsTitleWindow(){
      $titleArr = [];
      if(empty($_POST['id_time']) ){
          $idTime = mysql_escape_string($_POST['id_time']);
          $query = mysql_query("SELECT * FROM times WHERE id_t = '$idTime'");
          $row   = mysql_fetch_array($query);
          
          $optionTime = $row['option_time'];
          $dateFrom = $row['from_date'];
          $dateTo = $row['toDate'];
          $time   = date('H:i',  strtotime($row['time_only'])) ;
          $timeTo   = date('H:i',  strtotime($row['time_to'])) ;

          $query = mysql_query("SELECT * FROM time_hash_texts WHERE id_time_ht = '$idTime'");
          while($row = mysql_fetch_array($query)){
               $titleArr[$row['id_lang']] = $row['title'];
          }
      }
      
      $return.= '<form id="titleForm"><div class="mmModulTimeAdminWindowHolder"><div class="vFrontFrmHolder">';
      $return .= '<div class="vFrontFrmAbstand"></div>';
      $return .= '<input type="hidden" value="'.$_POST['id'].'" name="idTime" id="idTime">';
      $return .= '<input type="hidden" value="'.$_POST['idHash'].'" name="id" id="idHash">';
              
        if(!empty($optionTime)){
            
            if($optionTime == 1){
                $checked1 = 'checked="checked"';
            }else{
                $checked2 = 'checked="checked"';
            }
            
         $return .= ' Time  <input type="radio" value="1" name="timeType"  class="chooseOption" '.$checked1.' >
         Day  <input type="radio" value="2" name="timeType" class="chooseOption" '.$checked2.'>';
        }else{
           $return .= ' Time  <input type="radio" value="1" name="timeType"  class="chooseOption" checked="checked" >
         Day  <input type="radio" value="2" name="timeType" class="chooseOption">'; 
        }    
        

        $return .='<br><label for="vFrontHpSeSiteLayoutName" class="timeC"><br><br>Setup #Time for hours each day <br><br></label>
         <label for="vFrontHpSeSiteLayoutName" class="timeC">Starting hour:</label>
         <div class="vFrontLblAbstand timeC"></div>
         <input type="text" name="time" id="time" class="timeC time" style="width:275px;" value="'.$time.'"  /><div class="" style="clear:both;"></div>
         <div class="vFrontLblAbstand timeC"></div>
         
        <label for="vFrontHpSeSiteLayoutName" class="timeC">Ending hour:</label>
         <div class="vFrontLblAbstand timeC"></div>
         <input type="text" name="time1" id="time1" class="timeC time" style="width:275px;" value="'.$time1.'"  /><div class="" style="clear:both;"></div>
         <div class="vFrontLblAbstand timeC"></div>

<label for="vFrontHpSeSiteLayoutName" class="dateTimeC"><br> <br>Setup #Time for days <br><br></label>
        <label for="vFrontHpSeSiteLayoutName" class="dateTimeC">Date from:</label>
        <div class="vFrontLblAbstand dateTimeC"></div>
        <input type="text" name="dateFrom" id="dateTime" class="dateTime dateTimeC" style="width:275px;" value="'.$dateFrom.'"  /><div class="" style="clear:both;"></div>
        <div class="vFrontLblAbstand dateTimeC"></div>         
        <label for="vFrontHpSeSiteLayoutName" class="dateTimeC">Date to:</label>
        <div class="vFrontLblAbstand dateTimeC"></div>
        <input type="text" name="dateTo" id="dateTime1" class="dateTime dateTimeC" style="width:275px;" value="'.$dateTo.'"  /><div class="" style="clear:both;"></div>';
    
                            
            $return.='<div class="vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div><label for="vFrontHpSeSiteLayoutDatei">Add #Time content for each language:</label><br><br>
                     <div class="vFrontLblAbstand"></div>'; 
            $idHash = mysql_escape_string($_POST['idHash']);
            
            $query = mysql_query('SELECT * FROM vsprachen');
            
            while($row = mysql_fetch_array($query)){
                $title =$row1['title'];
                $return .= '<label for="vFrontHpSeSiteLayoutName">#Time content '.$row['langKurzName'].':</label>
                            <div class="vFrontLblAbstand"></div>
                            <input type="text" class="timeTexts" name="titleHash_'.$row['langKurzName'].'" id="" style="width:275px;" value="'.$title.'" />'
                         . '<div class="" style="clear:both;"></div>';
            }
            
        $return .= '<div class="clearer"></div>';                        
   
        $return .= '<br><br><input style="width: 135px;" type="submit" value="Speichern" id="vFrontSaveTitleHash"/>';
    
        $query = mysql_query("SELECT * FROM time_hash_texts WHERE id_lang = 1 AND id_h='$idHash'");

        $return .= '<div class="vFrontHpSeAuflistung">';
      
        while($row = mysql_fetch_array($query)){
           $return .= '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiTimeKat" data-id="'.$row['id_h'].'" style="margin-right:0px;">';
           $return .= '<div class="vFrontHpSeAuflistungLiElName" id="titlehash'.$row['id_time_ht'].'">'.$row['title'].'</div>';
           $return .= '<div class="changeTimeText" title="Bearbeiten" data-id="'.$row['id_time_ht'].'"></div>';
           $return .= '<div class="deleteTimeText" title="Löschen" data-id="'.$row['id_time_ht'].'"></div>';
           $return .= '</div>'; 
        }
     
        $return .= '</div></form>';
        
        echo  $return;      
  }
  
  public function saveHashTitle($param) {
    
      foreach ($_POST['dateForm'] as $key => $value){
          $data[$value['name']] = $value['value'];
      }

      $dateFrom =date('Y-m-d H:i:s',  strtotime($data['dateFrom']) );
      $dateTo   = date('Y-m-d H:i:s',  strtotime($data['dateTo']) );
      $time  = date('Y-m-d H:i:s',  strtotime($data['time']) );
      $timeTo  = date('Y-m-d H:i:s',  strtotime($data['time1']) );
      $timeType = $data['timeType'];
       $idHash = $data['id'];  
      if(!empty($data['idTime'])){
         $idTime = mysql_escape_string($data['idTime']);
         $query  = mysql_query("UPDATE times SET id_th='$idHash',from_date='$dateFrom',to_date='$dateTo',time_only='$time',time_to='$timeTo',option_time='$timeType' WHERE id_t='$idTime'");                 
      }else{
         $query  = mysql_query("INSERT INTO times SET id_th='$idHash',from_date='$dateFrom',to_date='$dateTo',time_only='$time',time_to='$timeTo',option_time='$timeType'");  
         $idTime = mysql_insert_id();  
      }
     
      $query = mysql_query('SELECT * FROM vsprachen');
      $i=1;
      while($row = mysql_fetch_array($query)){
                            
       $title = $data['titleHash_'.$row['langKurzName']] ;
        $langId = $row['langID'];
        $idHash = $data['id'];
        if($i==1){
            $titleList = $title;
        }
        
        if(!empty($data['idTime'])){
             $query1  = mysql_query("UPDATE time_hash_texts SET id_h='$idHash',id_time_ht='$idTime',id_lang='$langId',title='$title' WHERE id_lang='$langId' AND id_time_ht='$idTime'"); 
        }else{
            $query1  = mysql_query("INSERT INTO time_hash_texts SET id_h='$idHash',id_time_ht='$idTime',id_lang='$langId',title='$title'");
        }  
        $i++;
      }
      
 
      if(empty($data['idTime'])){
          echo '<div class="vFrontHpSeAuflistungLiEl vFrontHpSeAuflistungLiTimeKat"  style="margin-right:0px;background-color: rgba(21, 112, 166, 0.31) !important;">'
          . '<div class="vFrontHpSeAuflistungLiElName" id="titlehash'.$idTime .'">'.$titleList.'</div>'
                  . '<div class="changeTimeText" title="Bearbeiten" data-id="'.$idTime .'"></div>'
                  . '<div class="deleteTimeText vFrontFiltersysAdminWinListDelBtn" title="Löschen" data-id="'.$idTime .'"></div></div>';
          
      }
                            
  }


public function editHashTitle(){
   
    $idTime = mysql_escape_string($_POST['id']);
    
    $query = mysql_query("SELECT * FROM time_hash_texts WHERE id_time_ht = $idTime");
   
    
    while($row = mysql_fetch_array($query)){
        $idLang = $row['id_lang'];
        $query1 = mysql_query("SELECT * FROM vsprachen WHERE langID ='$idLang' ");
        $row1 = mysql_fetch_array($query1);
        $ln = $row1['langKurzName'];
        $titleArr['titleHash_'.$ln] = $row['title']; 
                            
    }
 
    
    
    $query = mysql_query("SELECT * FROM times WHERE id_t = $idTime");
    $row = mysql_fetch_array($query);
    $time = date('H:i',  strtotime($row['time_only']));
    $time1 = date('H:i',  strtotime($row['time_to']));
    $dateFrom = $row['from_date'];
    $dateTo   = $row['to_date'];
    
    $return = array('idTime'=>$idTime,'time'=>$time,'time1'=>$time1,'dateFrom'=>$dateFrom,'dateTo'=>$dateTo,'titles'=>$titleArr);
    
    echo  json_encode($return);
    
}



  }


?>