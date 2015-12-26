<?php 
 
if($thisElemArr['elemSettings']['colorOption'] == 1  || empty($thisElemArr['elemSettings']['colorOption'])){
    
    
    
    $color = 'color:white !important;';
    ?>
<img src="templates/wildkogel/img/berge_header_weiss.png" />
<?php }else{ 
    
    $color = 'color:black !important;';
    
    ?>
 <img src="templates/wildkogel/img/berge_header.png" />      
<?php } ?>
 <h1 style="<?php echo $color ?>"><?php echo $thisElemArr['text1']; ?></h1>
<?php if($thisElemArr['elemSettings']['headerOption'] == 1 || empty($thisElemArr['elemSettings']['headerOption'])){ ?>  <h2 style="<?php echo $color ?>"><?php echo $thisElemArr['text2']; ?></h2> <?php } ?>