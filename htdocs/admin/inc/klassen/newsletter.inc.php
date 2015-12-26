<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newsletter
 *
 * @author Łukasz
 */
class newsletter {
   
    public function getElemtData($idElement){
        
        $query  = mysql_query("SELECT * FROM vseitenelemente WHERE selemID = '$idElement'");
        $row = mysql_fetch_array($query);
        
        $textData = json_decode($row['selemInhalt'],true);
        $images   = json_decode($row['selemConfig'],true); 
        
        $imagesArr =  explode(';',$images['picGal']);
        
        foreach($imagesArr as $key => $value){
           $query  = mysql_query("SELECT * FROM vbilder WHERE bildID = '$value'"); 
           $row = mysql_fetch_array($query);
           $images[] = $row['bildFile'];
        }
        
        return array('texts'=>$textData,'images'=>$images);
        
    }
    
    
    public function getXmlData(){
       $xml = simplexml_load_file('http://cps.netxml.feratel.com/cpsnet20/internet/?id=FINET,39,100&languageCode=de');
 
       $i=1;
       foreach($xml->INFRASTRUKTUR as $key => $value ){
        
           foreach($value as $key1){
              if($i>11 && $i<=16){
                  
                   if($i==12 || $i==13){ 
                                   
                 $name = $key1->NAME;
                 $str = strlen($name);
                 $newName = str_replace('*','',substr($name,2,$str));
              }else{
                  $newName = $key1->NAME;
              }
                  
                   $status = ($key1->STATUS == 'gesperrt / geschlossen')?'status-2.png':'status-1.png';
                   $rodel[] = array('name'=>$newName,'status'=>$status);
             }else{
                 
                  $name = $key1->NAME;
             $str = strlen($name);
             $newName = str_replace('*','',substr($name,2,$str));
                 
                 $status = ($key1->STATUS == 'gesperrt / geschlossen')?'status-2.png':'status-1.png';
                 $liften[] = array('name'=>$newName,'status'=>$status);
             }

            $i++; 
            }
        }
        
        $i=1;
       foreach($xml->WETTER as $key  ){
       
           foreach($key->WETTERWERT as $key1){
               
              if($i!=2 && $i!=3){
                   $status = ($key1->STATUS == 'gesperrt / geschlossen')?'status-2.png':'status-1.png';
                   $schneeb[] = array('name'=>$key1->NAME,'status'=>$status);
             }

            $i++; 
            }
        }
        
        
        
        
         $i=1;
       foreach($xml->LIFTE as $key ){
           
           foreach($key->LIFT as $key1){
              
              if( $i<5){
                  
                  
                  $name = $key1->NAME;
                  $str = strlen($name);
                  $newName = str_replace('*','',substr($name,2,$str));
                  
                   $status = ($key1->STATUS == 'gesperrt / geschlossen')?'status-2.png':'status-1.png';
                   $lifte[] = array('name'=>$newName ,'status'=>$status);
             }
 
            $i++; 
            }
        }
        
 $i=1;
       foreach($xml->PISTEN as $key ){
           
           foreach($key->PISTE as $key1){
              
              if($key1->ID==36 || $key1->ID==52){
                  
                  
                   
                                   
                 $name = $key1->NAME;
                 $str = strlen($name);
                 if($key1->ID==52){
                   $newName = str_replace('*','',substr($name,3,$str));  
                 }else{
                     
                   $newName = str_replace('*','',substr($name,2,$str));  
                 }
                 
                 
                  
                   $status = ($key1->STATUS == 'gesperrt / geschlossen')?'status-2.png':'status-1.png';
                   $piste[] = array('name'=>str_replace('*','',$newName),'status'=>$status);
             }

            $i++; 
            }
        }
        
        
        
        
        
        
        
        
        
       
       $link = simplexml_load_file('http://www.auf-wind.at/webweather/ginh5741_de.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
             
        $i=1;
        foreach($link->weatherdata->day as $key){  
              if($i<5){
                 $imageArr[] = basename($key->image, '.swf'); 
              }
              
              
               if($i==3 || $i==4){
                 
                  $dateTextArr[] = $key->dateext;
                  
              }
              

              
              
              if($i==1){
                  $dataWather1 .= '<tr><td align="center">'.$key->date.' vormittags</td><td align="center">'.(string)$key->data->attributes()->temp.'</td></tr>';  
              }elseif($i==2){
                 $dataWather1 .= '<tr><td align="center">'.$key->date.' nachmittags</td><td align="center">'.(string)$key->data->attributes()->temp.'</td></tr>';   
                 
              }else{
                  
                  $dataWather1 .= '<tr><td align="center">'.$key->date.'</td><td align="center">'.(string)$key->data->attributes()->temp.'</td></tr>';  
              }
              
                
                $i++;
         } 
         
         foreach($link->weatherdata->day as $key){   
                $dataWather2 .= '<tr><td align="center">'.(string)$key->data->attributes()->fineweather.'</td><td align="center">'.(string)$key->data->attributes()->frostborder.'</td></tr>';   
         } 
        
       $xml = simplexml_load_file('http://cps.netxml.feratel.com/cpsnet20/internet/?id=FINET,39,100&languageCode=de');
  
     //  print_r($xml);
       
          
       foreach($xml->ANZEIGEWERTE as $key){
           
          
          $i=1;
           foreach($key as $key1){
               
          //     print_r($key1);
              
            if($i<3){
                $cm = 'cm';
            }else{
                $cm = '';
            }  
            
            if($i>4 && $i<7){
              // $d = explode('T', $key1->wid[1]->attributes()[1]);
              // $d = $d[0];  
                 $schnee .='<tr><td>'.$key1->TYPNAME.' </td><td>'.$key1->WERT.' cm</td></tr>' ;
            }
            
           // if($i!=3){
               //$schnee .='<tr><td>'.$key1->TYPNAME.' </td><td>'.$key1->WERT.'</td></tr>' ;
           // }
            
            
            
             $i++;
           }
       
           
       }
        $schnee .= '<tr><td>Letzter Schneefall </td><td>'.date('Y-m-d',  strtotime($xml->ZULETZT_AKTUALISIERT)) .'</td></tr>' ;
       
   
       
 
        
         
        
       return array('dayText'=>$dateTextArr,'rodel'=>$rodel,'wather1'=>$dataWather1,'wather2'=>$dataWather2,'wather_image'=>$imageArr,'schnee'=>$schnee,'schneeb'=>$schneeb,'lifte'=>$lifte,'piste'=>$piste,'liften'=>$liften); 
    }
}
