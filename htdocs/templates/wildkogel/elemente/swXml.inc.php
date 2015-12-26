<?php

$xml = simplexml_load_file('http://cps.netxml.feratel.com/cpsnet20/internet/?id=FINET,39,100&languageCode=de');



//print_r($xml);

?>

<style>
    .contentTab{
        display: none;
    }   
</style>
<div id="tabXml">
<?php
 

if($thisElemArr['elemSettings']['tab1']=='' || $thisElemArr['elemSettings']['tab1']=='off'){ ?>

<a href="javascript:void(0)" data-target="#lifte" class="buttonTab"><div>	<?php echo  lang('lifte'); ?> </div></a>
<?php } ?>
<?php if($thisElemArr['elemSettings']['tab2']=='' || $thisElemArr['elemSettings']['tab2']=='off'){ ?>
  <a href="javascript:void(0)" data-target="#pisten"  class="buttonTab">   <div>	<?php echo  lang('pisten'); ?> </div></a>
<?php } ?>
  
  <?php if($thisElemArr['elemSettings']['tab3']=='' || $thisElemArr['elemSettings']['tab3']=='off'){ ?>
    <a href="javascript:void(0)" data-target="#loipen"  class="buttonTab"> <div><?php echo  lang('loipen'); ?></div></a>
  <?php } ?>
    
    <?php if($thisElemArr['elemSettings']['tab4']=='' || $thisElemArr['elemSettings']['tab4']=='off'){ ?>
   <a href="javascript:void(0)" data-target="#rodelbahnen"  class="buttonTab">  <div><?php echo  lang('rodelbahnen'); ?></div></a>
    <?php } ?>
  
  <div style="clear: both;"></div>
  
  
   <div id="lifte" class="contentTab" >
       <div class="table-responsive">
           <table>
               <tr>
                   <td>Status</td>
                   <td>Nr.</td>
                   <td>Typ</td>
                   <td>Name</td>
               </tr> 
       <?php  
       $i=0;
       foreach($xml->LIFTE as $key => $value ){
    
         foreach($value as $key1){
          $ico = ($key1->STATUS == 'gesperrt / geschlossen')?'dot-red.png':'dot-green.png'; 
          $w = ($key1->STATUS == 'gesperrt / geschlossen')?'geschlossen':'geöffnet'; 
             if($key1->STATUS != ''){
                 
                  if($i>=1 && $i<=4){
              $ico1 = 'lift_gondel.png'; 
             }elseif($i>4 && $i<=9){
              $ico1 = 'lift_6sessel.png';   
             }else{
               $ico1 = 'lift_schlepp.png';  
             }
             
             $name = $key1->NAME;
             $str = strlen($name);
             $newName = str_replace('*','',substr($name,2,$str));
             
             ?>

               <tr>
                   <td><img src="/templates/wildkogel/img/<?php echo $ico; ?>"><?php echo $w ?></td>
                   <td><?php echo $key1->ID  ?></td>
                   <td><img src="/templates/wildkogel/img/<?php echo $ico1; ?>"></td>
                   <td><?php echo $newName ?></td>
               </tr>     
       
      <?php
             }
       $i++;  }
    
}
       
       ?>
           </table>    
       </div>   
   </div>
   
 
   <div id="pisten" class="contentTab">
       
       <div class="table-responsive">
           <table>
               
               <tr>
                   <td>Status</td>
                   <td>Nr.</td>
                   <td>Typ</td>
                   <td>Name</td>
               </tr>
       <?php  
       foreach($xml->PISTEN as $key => $value ){
         $i=0;
         foreach($value as $key1){
             $ico = ($key1->STATUS == 'gesperrt / geschlossen')?'dot-red.png':'dot-green.png';
             $w = ($key1->STATUS == 'gesperrt / geschlossen')?'geschlossen':'geöffnet'; 
             if($i>=1 && $i<=4){
              $ico1 = 'lift_gondel.png'; 
             }elseif($i>4 && $i<=9){
              $ico1 = 'lift_6sessel.png';   
             }else{
               $ico1 = 'lift_schlepp.png';  
             }
             if($key1->ID != ''){
                 
                 if($key1->TYP == 19){
                   $class = 'type-red';  
                 }elseif($key1->TYP == 20){
                     $class = 'type-black'; 
                 }else{
                    $class = 'type-blue';  
                 }
                 
                 $name = $key1->NAME;
                 $str = strlen($name);
                 $newName = str_replace('*','',substr($name,2,$str));
                 
                 
                 
                 
             ?>

               <tr>
                   <td><img src="/templates/wildkogel/img/<?php echo $ico; ?>"><?php echo $w; ?></td>
                   <td><?php echo $key1->ID  ?></td>
                   <td class="<?php echo $class ?>"><?php echo $key1->TYP; ?></td>
                   <td><?php echo $newName ?></td>
               </tr>     
       
             <?php }
        $i++;
         }
    
}
       
       ?>
           </table>    
       </div>    
       
   </div>
   
   <div id="loipen" class="contentTab">
       <div class="table-responsive">
           <table>
                <tr>
                   <td>Status</td>
                   <td>Name</td>
               </tr>
               
       <?php  
       foreach($xml->INFRASTRUKTUR as $key => $value ){
        $i=1; 
         foreach($value as $key1){
             $ico = ($key1->STATUS == 'gesperrt / geschlossen')?'dot-red.png':'dot-green.png';
			  $w = ($key1->STATUS == 'gesperrt / geschlossen')?'geschlossen':'geöffnet'; 
             if($i<=11 && $key1->NAME != ''){
             ?>

               <tr>
                   <td><img src="/templates/wildkogel/img/<?php echo $ico; ?>"><?php echo $w; ?></td>
                   <td><?php echo $key1->NAME ?></td>
               </tr>     
       
      <?php
                }
         $i++;
         }
      }
       
       ?>
           </table>    
       </div> 
       
   </div>
   
   <div id="rodelbahnen" class="contentTab">
       <div class="table-responsive">
           <table>
               <tr>
                   <td>Status</td>
                   <td>Name</td>
               </tr>
       <?php  
       
        $i=1;
       foreach($xml->INFRASTRUKTUR as $key => $value ){
        
         foreach($value as $key1){
              if($i>11 && $i<=16){
                   $ico = ($key1->STATUS == 'gesperrt / geschlossen')?'dot-red.png':'dot-green.png';
				   $w = ($key1->STATUS == 'gesperrt / geschlossen')?'geschlossen':'geöffnet'; 
              if($i==12 || $i==13){ 
                                   
                 $name = $key1->NAME;
                 $str = strlen($name);
                 $newName = str_replace('*','',substr($name,2,$str));
              }else{
                  $newName = $key1->NAME;
              }                      
             ?>

               <tr>
                   <td><img src="/templates/wildkogel/img/<?php echo $ico; ?>"><?php echo $w; ?></td>
                   <td><?php echo $newName ?></td>
               </tr>     
       
      <?php
        
             }
             
              
      $i++; 
       }
    
}
        
       ?>
           </table>    
       </div> 
       
   </div>
  
   </div>
    



