<?php

$xml = simplexml_load_file('http://wildkogel-arena.at/xml/Wildkogel.xml');




if(!empty($_GET['_lang'])){
   $l = $_GET['_lang'];
}else{
    $l = 'de';
}

?>
<div id="wetherXml">
<div class="table-responsive">
<table>
  <tbody>
  <tr class="subheadline">
      <td><?php echo  lang('messstation'); ?> </td>
      <td><?php echo  lang('seehohe'); ?></td>
       <td><?php echo  lang('temperatur'); ?></td>
      <td><?php echo  lang('luftfeuchtigkeit'); ?></td>
      <td><?php echo  lang('wind'); ?></td>
      <td><?php echo  lang('windrichtung'); ?></td>
  </tr>
  <?php
  foreach($xml as $key => $value){ 

      
      
      $location = (string)$value->location;
      $height   = (string)$value->height;
      $utc[] = (string)$value->datetime->utc;
      $date[] = (string)$value->datetime->date;
      $time[] = (string)$value->datetime->time;
      $temp[]    = (string) $value->temperature->value.$value->temperature->unit;
      $humidity[] = (string)$value->humidity->value.' '. $value->humidity->unit;
      $wind[]    = (string)$value->windspeed->value.$value->windspeed->unit;
      $winddirection[] = (string)$value->winddirection->name.' '.$value->winddirection->value.$value->winddirection->unit;
    
      
  }
      ?>
  <tr>
      
      <td><?php echo $location ?></td>
      <td><?php echo $height ?> </td>
      <td><?php echo $temp[0]; ?></td>
      <td><?php echo $humidity[0]; ?></td>
      <td><?php echo $wind[0]; ?></td>
      <td><?php echo $winddirection[0] ?></td>
  </tr>
  
 
</tbody></table>
     <p style="font-size: 13px">Letzte Aktualisierung: <?php echo $date[0]; ?> <?php echo $time[0]; ?></p>
</div>

    <br> <br>
 <div class="table-responsive">   
    <table>
        <tbody>
            
              <tr> <?php 
             $link = simplexml_load_file('http://www.auf-wind.at/webweather/ginh5741_'.$l.'.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
             


            
   $i=1;         
  foreach($link->weatherdata->day as $key){ 
       
     if($i<5){      ?>
                <td style="width: 25%; text-align: center; padding-left: 0;">
                    <?php echo  $key->dateext; ?>
                  </td>      
     <?php } $i++; }
  ?>
      </tr> 
            
            <tr> <?php 
             
            
   $i=1;         
  foreach($link->weatherdata->day as $key){ 
   $img =   basename($key->image, '.swf');
     // $key->image;
      
       
     if($i<5){      ?>
                <td style="width: 25%; text-align: center; padding-left: 0; padding: 10px;">
                    <img src="https://wildkogel-arena.at/templates/newsletter/xml/images/<?php echo $img ?>.jpg" >
                  
</td>      
     <?php } $i++; }
  ?>
      </tr> 
            
        </tbody>
    </table>    
   </div> 
   <div class="table-responsive"> 
 <table>
      <br>
       <br>
  <tbody>   
 
  
      <tr>
          <td><?php echo  lang('datum'); ?></td>
          <td><?php echo (string) $link->info->description->attributes()->temp ?></td>
          <td><?php echo (string) $link->info->description->attributes()->fineweather ?></td>
          <td><?php echo (string) $link->info->description->attributes()->frostborder ?></td>
          
      </tr>
      
 <?php $i=1;  foreach($link->weatherdata->day as $key){ 
     
         if($i==1){
            $d = 'Vormittag'; 
         }elseif($i==2){
           $d = 'Nachmittag';  
         }else{
             $d='';
         }
     ?>
      <tr><td><?php echo $key->date  ?> <?php echo $d; ?></td><td><?php echo (string)$key->data->attributes()->temp ?></td><td><?php echo (string)$key->data->attributes()->fineweather ?></td><td><?php echo (string)$key->data->attributes()->frostborder ?></td></tr>   
      
 <?php $i++; }  ?>
  </tbody>
 </table>
 </div>
  <br><br>
    <p><b><?php echo  lang('vorschau'); ?></b>
        <br>
        <?php echo (string) $link->forecast; ?>
        
    </p>
      <p>
          <b><?php echo  lang('trend'); ?></b>
        <br>
        <?php echo (string) $link->tendency; ?>
        
    </p>
  
    
    
    

    </div>