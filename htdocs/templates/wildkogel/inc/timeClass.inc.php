<?php
 

/**
 * Description of timeClass
 *
 * @author Łukasz
 */
class timeClass {
    public function checkTimeBanner($bannerId) {
            $query = mysql_query("SELECT * FROm vbilder WHERE bildID = '$bannerId'");
            $row = mysql_fetch_array($query);
            if($row['tag'] != ''){
                return  $this->checkBannerAvalible($row['tag']);  
            }else{
                return $bannerId;
                /// return false;
            }
    }
  
  
  private function checkBannerAvalible($idHash){
    $currentDate = date('Y-m-d H:i:s');
    $currenTime  = date('H:i a');
    $query = mysql_query("SELECT * FROM `times` WHERE id_t='$idHash' AND from_date<='$currentDate' AND to_date >='$currentDate' AND option_time=2 LIMIT 1");
               
    if(mysql_num_rows($query)){
        return true;
    }else{
               
        if(date('G') >= 21 && date('G') <24){
            $query = mysql_query("SELECT * FROM `times` WHERE id_t='$idHash' AND DATE_FORMAT(time_only,'%H:%i%p')<='$currenTime' AND DATE_FORMAT(time_to,'%H:%i%p') <'$currenTime' AND option_time=1 order BY time_only desc LIMIT 1"); 
        }elseif(date('G') >=0 && date('G') <=6){
            $query = mysql_query("SELECT * FROM `times` WHERE id_th='$idHash'  AND DATE_FORMAT(time_to,'%H:%i%p') >='0:00' AND DATE_FORMAT(time_to,'%H:%i%p') <='6:00' AND option_time=1 order BY time_only desc LIMIT 1"); 
            
             if($_GET['test'] == 1){
              //  echo "SELECT * FROM `times` WHERE id_th='$idHash'  AND DATE_FORMAT(time_to,'%H:%i%p') >='0:00' AND DATE_FORMAT(time_to,'%H:%i%p') <='6:00' AND option_time=1 order BY time_only desc LIMIT 1";  
                 // die();
                     
                 }
            
        }else{
            $query = mysql_query("SELECT * FROM `times` WHERE id_t='$idHash' AND DATE_FORMAT(time_only,'%H:%i%p')<='$currenTime' AND DATE_FORMAT(time_to,'%H:%i%p') >='$currenTime' AND option_time=1 LIMIT 1"); 
        }
        
        
        if(mysql_num_rows($query)){
          
            return true;
        } 
    }
  }
  
}
