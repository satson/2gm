<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; 
 
 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();

$idSelem = $thisElemArr['elemData']['selemID'];

//$idSelem = 
 $query = mysql_query("SELECT * FROM vseitenelemente WHERE selemID='$idSelem'");
 $row   = mysql_fetch_array($query);
 $confArr  = json_decode($row['selemConfig']);
  
 
 


                                 
                                    $imagesArr = explode(';',$confArr->picGal);
                                    if(!empty($imagesArr[0])){
                                            $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                       }else{
                                            $gallery = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($row['selemPicGal']);  
                                            if(!empty($gallery)){
                                                $imagesArr = explode(';',$gallery);
                                                 $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                               
                                            }else{
                                                $imagesArr =array();
                                            } 
                                       }

 
 ?>
<div class="bigPanels">
	<div class="panelsRow">
		<div class="panelsLeft">
			<div style="background-image: url(&quot;/user_upload/thumb_400/steineralm.png&quot;);" class="panel panelLarge giveMeBackground opensBigDropdown galleryPackage" >
			 
                            <img class="hereIsYourBackgroud hidden" src="<?php echo $img ?>">
                          
                                
                                 
                                
				<div class="panelTitle"><?php echo $thisElemArr['text1']; ?></div>
				
			</div>
                    
                    
                                      <!--      <?php foreach($imagesArr  as $imgs => $img){
                                                       $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" rel="<?php echo $idSelem; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                         <?php   } ?>-->
                    
		</div>
<!-- sam panel -->
<div class="textBoxWithLargeInfoPanel">
	<div class="bigInfoPanel newsInfoPanel" id="bigDropdown333">
		<div class="newsInfoPanelInner">
			<div class="infoPanelHeader icoPackages" >
                            
			</div>
                              <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
                    
			<?php echo  $mmFunctionsObj->cartButton($thisElemArr['elemData']['seitID'],$thisElemArr['elemSettings']['carTab']);  ?>
		</div>
	</div>
</div>

        </div>
</div>
