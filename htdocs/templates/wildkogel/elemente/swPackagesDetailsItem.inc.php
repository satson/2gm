<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
 
 $idElem = $thisElemArr['elemData']['selemID'];
 $query  = mysql_query("SELECT * FROM vseitenelemente WHERE selemID = '$idElem' ");
 $row = mysql_fetch_array($query);
 
 $conf = json_decode($row['selemConfig']) ;
 
 $picArr  = explode(';',$conf->picGal);
 
 $image = $mmFunctionsObj->getPicOnceDataByIdMM($picArr[0]);
 
//print_r($thisElemArr);
 
 if(!empty($row['selemPicGal'])){
     
   $picArr  = explode(';',$row['selemPicGal']);  
 }
 
         
         
 
 
?>


<div class="infoPanelNews">
	 				<h2><?php echo $thisElemArr['text1']; ?></h2>
                                <?php if($image['bildName'] != ''){?>	
                                         <a href="user_upload/<?php  echo $image['bildName']  ?>" rel="<?php echo $idElem; ?>" class="vCmsLinkingPicLightboxShow">
                                        
                                        <img src="/user_upload/<?php echo $image['bildName'] ?>"> 
                                            
                                         </a>
                                            <?php } ?>
                               
                                  <?php  $i=1;  foreach($picArr  as $imgs => $img){
                                                  if($i>1){
                                      
                                                       $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?> 
                                <a href="user_upload/<?php  echo $image['bildName']  ?>" rel="<?php echo $idElem; ?>" class="vCmsLinkingPicLightboxShow" style="display: none;"></a>
                                  <?php   } $i++;  } ?>
	 				<?php echo $thisElemArr['text2']; ?>
	 			</div>