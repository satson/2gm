<?php  
 

global $cmsObj;
 



require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
 

 $siteArr = explode(';',$thisElemArr['elemSettings']['pauschalenList']);
 
 foreach($siteArr as $key => $value){
   
     $query = mysql_query("SELECT seitOnline FROM vseiten WHERE seitID='$value' AND seitOnline=1");
     if(mysql_num_rows($query) == 1){
         
        // $query = mysql_query("SELECT * from vseitenelemente WHERE seitID='$value' AND elemID =18");
         //$row = mysql_fetch_array($query);
        // $selemId = $row['selemID'];
         
         $dataArr[] =   $mmFunctionsObj->mmGetSiteDetailMultiElementDataArr($value,'12,13',$selemId);  
     }

 }
 
 
 //print_r($dataArr);
 

 
$dataArr = array_chunk($dataArr, 5);

 
?>

<div class="homeHeader">
		<h1><?php echo $thisElemArr['text1']; ?></h1>
	</div>
	<div class="panels">
            <?php 
           $i = 1;
            foreach($dataArr as $panelRows => $panelRow){ 
                
                
                ?>
		<div class="panelsRow">
                    <?php  if($i%2!=0){ ?>
                    
			<div class="panelsLeft">
                            
                            <?php
                           
                           foreach($panelRow as $key1 => $value1){
                                if($key1  == 0){  
                                foreach($value1 as $key => $value){
                                       $textsArr = json_decode($value['selemInhalt']);
                                       $confArr  = json_decode($value['selemConfig']);
                                       $linkArr  = json_decode($value['selemLink']);
                                       $image = $mmFunctionsObj->getPicOnceDataByIdMM($confArr->picGal);
                                       
                                       $ownConfig = json_decode($value['selemOwnConfig']);
                                      $cartTab = $ownConfig->vOwnUserSettings->carTab;
                                       
                                       $imagesArr = explode(';',$confArr->picGal);
                                       
                                       if(empty($value['selemPicGal'])){
                                            $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                       }else{
                                            $gallery = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($value['selemPicGal']);  
                                            if(!empty($gallery)){
                                                $imagesArr = explode(';',$gallery);
                                                 $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                               
                                            }else{
                                                $imagesArr =array();
                                            } 
                                       }
                                       
                                      
                                        $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($value['seitID']).' AND seitOnline = 1 ORDER BY seitPosition ASC';
                                        $sqlErg = $this->dbAbfragen($sqlText);
                                        $row = mysql_fetch_array($sqlErg);

                                       $siteUrl  = SITE_URL.$_GET['_lang'].'/'.$row['seitTextUrl'];
                                        
                                        
                                         if(file_exists(SITE_PATH.'/user_upload/thumb_800/'.$image['bildName'])){
                                                $imageSrc =  '/user_upload/thumb_800/'.$image['bildName'];
                                             }else{
                                                $imageSrc =  '/user_upload/'.$image['bildName']; 

                                             }
                                        
                                      if($value['elemID'] == 12){
                                          
                                          
                                          
                                    ?>
                            
                                    
				<div class="panel panelLarge panelPhoto giveMeBackground opensDropdown" data-target="#panelDropdown<?php echo $value['selemID']  ?>">
					<img class="hereIsYourBackgroud hidden" src="<?php echo $imageSrc  ?>"/>
					<div class="panelOverlay">
					<?php    echo $textsArr->elemText2; ?>
					</div>
					<div class="panelTitle">
						<?php    echo $textsArr->elemText1; ?>
					</div>
				</div>
                                      <?php }else{ 
                                          
                                          
                                          ?>
                                          
                                         <a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>" class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self">
                                    <div class="panel panelSmall panelIcon">
					<img src="<?php echo $imageSrc  ?>"/>
                                        <p><?php    echo $textsArr->elemText1; ?></p>
				</div>
                                    </a>  
                                          
                                   <?php   } ?>
                            
                            
                                
                            
				<div class="infoPanel panelDropdown" id="panelDropdown<?php echo $value['selemID']  ?>">
					<span class="panelDropdownClose"></span>
					<h2><?php    echo $textsArr->elemText2; ?></h2>
					<?php    echo $textsArr->elemText3;  
                                        
                                        if(count($imagesArr) >1){ ?>
						<div class="infoPanelCategory icoBilder" data-target-tab="#tab">
							<div class="infoIcon galleryIcon">
                                                         <img src="/templates/wildkogel/img/galerie_weiss.png">
							 <img class="alternative" src="/templates/wildkogel/img/galerie_weiss_red.png">
							</div>
							<div class="infoTitle galleryIcon">
							<?php echo  lang('mehr-bilder'); ?> 
							</div>
						</div>
                                            <?php foreach($imagesArr  as $imgs => $img){
                                                
                                                $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" style="display:none;" rel="<?php echo $value['seitID']; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                                
                                         <?php   } ?>
                                          
                                            
                                            <?php } ?>
                                        
                                        
					<a href="<?php echo $siteUrl;?>"><?php echo  lang('mehr'); ?></a>
					 <?php echo  $mmFunctionsObj->cartButton($value['seitID'],$cartTab)  ?>
				</div>
                                    <?php
                                    
                                             }
                                    
                                        }
                                    
                                    }
                       ?>
                            
			</div>
                    
                    
                    
			<div class="panelsRight">
                            
                            <?php 
                            foreach($panelRow as $key1 => $value1){
                                if($key1  != 0){  
                                foreach($value1 as $key => $value){
                                       $textsArr = json_decode($value['selemInhalt']);
                                       $confArr  = json_decode($value['selemConfig']);
                                       $linkArr  = json_decode($value['selemLink']);
                                       
                                       
                                       $imagesArr[$value['selemID']] = explode(';',$confArr->picGal);
                                       $ownConfig = json_decode($value['selemOwnConfig']);
                                      $cartTab = $ownConfig->vOwnUserSettings->carTab;
                                       
                                     
                                       if(empty($value['selemPicGal'])){
                                            $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[$value['selemID']][0]);
                                       }else{
                                          
                                            $gallery = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($value['selemPicGal']);  
                                            if(!empty($gallery)){
                                                $imagesArr[$value['selemID']] = explode(';',$gallery);
                                               
                                                 $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[$value['selemID']][0]);
                                               
                                            }else{
                                                $imagesArr =array();
                                            } 
                                       }
                                       
                                        $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($value['seitID']).' AND seitOnline = 1 ORDER BY seitPosition ASC';
                                        $sqlErg = $this->dbAbfragen($sqlText);
                                        $row = mysql_fetch_array($sqlErg);
                                        
                                       $siteUrl  = SITE_URL.$_GET['_lang'].'/'.$row['seitTextUrl'];
                                        
                                        $sitePanelDataArr[] = array('selemId' => $value['selemID'],'elemText2'=>$textsArr->elemText2,'elemText3'=>$textsArr->elemText3,'url'=>$siteUrl,'cartTab'=>$cartTab);
                                     
                                      
                                       if(file_exists(SITE_PATH.'/user_upload/thumb_800/'.$image['bildName'])){
                                                $imageSrc =  '/user_upload/thumb_800/'.$image['bildName'];
                                             }else{
                                                $imageSrc =  '/user_upload/'.$image['bildName']; 

                                             }
                                        
                                        if($value['elemID'] == 12){
                                    ?>
                            
                     
				<div class="panel panelSmall panelPhoto giveMeBackground opensDropdown" data-target="#panelDropdown<?php echo $value['selemID']  ?>">
					<img class="hereIsYourBackgroud hidden" src="<?php echo $imageSrc  ?>"/>
					<div class="panelTitle">
						<?php    echo $textsArr->elemText1; ?>
					</div>
					<div class="panelOverlay">
						<?php    echo $textsArr->elemText2; ?>
					</div>
				</div>
                            
                            	
                            
                                <?php }else{ ?>
                            <a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>" class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self">
                                    <div class="panel panelSmall panelIcon">
					<img src="<?php echo $imageSrc  ?>"/>
                                        <p><?php    echo $textsArr->elemText1; ?></p>
				</div>
                                    </a>
                               <?php }
                               
                               if(count($sitePanelDataArr) == 2){
                                   
                                  foreach($sitePanelDataArr as $sites => $s){
                                      ?>
                            
                            
                            <div class="infoPanel panelDropdown" id="panelDropdown<?php echo $s['selemId']  ?>">
					<span class="panelDropdownClose"></span>
					<h2><?php    echo $s['elemText2'] ; ?></h2>
					<?php    echo $s['elemText3'];  
                                        
                                        if(count($imagesArr[$s['selemId']]) >1){ ?>
						<div class="infoPanelCategory icoBilder" data-target-tab="#tab">
							<div class="infoIcon galleryIcon">
                                                         <img src="/templates/wildkogel/img/galerie_weiss.png">
							 <img class="alternative" src="/templates/wildkogel/img/galerie_weiss_red.png">
							</div>
							<div class="infoTitle galleryIcon">
							<?php echo  lang('mehr-bilder'); ?>
							</div>
						</div>
                                            <?php foreach($imagesArr[$s['selemId']]  as $imgs => $img){
                                                
                                                $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" style="display:none;" rel="<?php echo $value['seitID']; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                                
                                         <?php   } ?>
                                          
                                            
                                            <?php } ?>
                                        
                                        
                                        
					<a href="<?php echo $s['url']; ?>"><?php echo  lang('mehr'); ?></a>
					 <?php echo  $mmFunctionsObj->cartButton($value['seitID'],$value['cartTab'])  ?>
				</div>
                            
                                    <?php
                            
                                  } 
                                  
                                  
                                  $sitePanelDataArr = [];
                                   
                               }
                               
                               ?>
                            
                                
                            
				
			
                            
                                <?php  }
                                }
                            }?>
			</div>
                    
                    <?php }else{ ?>
                        
                        <div class="panelsLeft">
			   <?php 
                            foreach($panelRow as $key1 => $value1){
                                if($key1  != 0){  
                                foreach($value1 as $key => $value){
                                    
                                    if($value['seitID'] != 13){
                                    
                                       $textsArr = json_decode($value['selemInhalt']);
                                       $confArr  = json_decode($value['selemConfig']);
                                       $linkArr  = json_decode($value['selemLink']);
                                       $imagesArr[$value['selemID']] = explode(';',$confArr->picGal);
                                       $ownConfig = json_decode($value['selemOwnConfig']);
                                      $cartTab = $ownConfig->vOwnUserSettings->carTab;
                                       
                                       
                                       if(empty($value['selemPicGal'])){
                                            $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[$value['selemID']][0]);
                                       }else{
                                           
                                            $gallery = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($value['selemPicGal']);  
                                            if(!empty($gallery)){
                                                $imagesArr[$value['selemID']] = explode(';',$gallery);
                                                 $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[$value['selemID']][0]);
                                               
                                            }else{
                                                $imagesArr =array();
                                            } 
                                       }
                                       
                                        $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($value['seitID']).' AND seitOnline = 1 ORDER BY seitPosition ASC';
                                        $sqlErg = $this->dbAbfragen($sqlText);
                                        $row = mysql_fetch_array($sqlErg);
                                        
                                        $siteUrl  = SITE_URL.$_GET['_lang'].'/'.$row['seitTextUrl'];
                                        $sitePanelDataArr[] = array('selemId' => $value['selemID'],'elemText2'=>$textsArr->elemText2,'elemText3'=>$textsArr->elemText3,'url'=>$siteUrl,'carTab'=>$cartTab);
                                        
                                        if(file_exists(SITE_PATH.'/user_upload/thumb_800/'.$image['bildName'])){
                                                $imageSrc =  '/user_upload/thumb_800/'.$image['bildName'];
                                             }else{
                                                $imageSrc =  '/user_upload/'.$image['bildName']; 

                                             }
                                        
                                        
                                        if($value['elemID'] == 12){
                                    ?>
                            
                            
				<div class="panel panelSmall panelPhoto giveMeBackground opensDropdown" data-target="#panelDropdown<?php echo $value['selemID']  ?>">
					<img class="hereIsYourBackgroud hidden" src="<?php echo $imageSrc  ?>"/>
					<div class="panelTitle">
						<?php    echo $textsArr->elemText1; ?>
					</div>
					<div class="panelOverlay">
						<?php    echo $textsArr->elemText2;  ?>
					</div>
				</div>
                            
                                <?php }else{ ?>
                                    
                                <a href="<?php echo str_replace(SITE_URL, SITE_URL.$_GET['_lang'].'/', $linkArr->link); ?>" class=" vcmsLinkingLightboxElemShowMMa" data-height="<?php echo $linkArr->linkInLightboxHeight ?>" data-width="<?php echo $linkArr->linkInLightboxWidth ?>" target="_self">
                                    <div class="panel panelSmall panelIcon">
					<img src="/user_upload/<?php echo $image['bildName'] ;?>"/>
                                        <p><?php    echo $textsArr->elemText1;   ?></p>
				</div>
                                    </a>
                                    
                               <?php } 
                               
                               
                               if(count($sitePanelDataArr) == 2){
                                   
                                  foreach($sitePanelDataArr as $sites => $s){
                                      
                                      ?>
                            
                            
                            <div class="infoPanel panelDropdown" id="panelDropdown<?php echo $s['selemId']  ?>">
					<span class="panelDropdownClose"></span>
					<h2><?php    echo $s['elemText2'] ; ?></h2>
					<?php    echo $s['elemText3'];
                                       
                                        if(count($imagesArr[$s['selemId']]) >1){ ?>
						<div class="infoPanelCategory icoBilder" data-target-tab="#tab">
							<div class="infoIcon galleryIcon">
                                                         <img src="/templates/wildkogel/img/galerie_weiss.png">
							 <img class="alternative" src="/templates/wildkogel/img/galerie_weiss_red.png">
							</div>
							<div class="infoTitle galleryIcon">
							<?php echo  lang('mehr-bilder'); ?>
							</div>
						</div>
                                            <?php foreach($imagesArr[$s['selemId']]  as $imgs => $img){
                                                
                                                $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" style="display:none;" rel="<?php echo $value['seitID']; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                                
                                         <?php   } ?>
                                          
                                            
                                            <?php } ?>
					<a href="<?php echo $s['url']; ?>"><?php echo  lang('mehr'); ?></a>
					 <?php echo  $mmFunctionsObj->cartButton($value['seitID'],$value['cartTab'])  ?>
				</div>
                            
                                    <?php
                            
                                  } 
                                  
                                  
                                  $sitePanelDataArr = [];
                                   
                               }
                                }
                               ?>
				
			
                             
                                <?php  }
                                }
                            }?>
			</div>
			<div class="panelsRight">
			            <?php
                           
                           foreach($panelRow as $key1 => $value1){
                                if($key1  == 0){  
                                foreach($value1 as $key => $value){
                                   
                                    if($value['selemID'] != 2255){
                                    
                                       $textsArr = json_decode($value['selemInhalt']);
                                       $confArr  = json_decode($value['selemConfig']);
                                       $linkArr  = json_decode($value['selemLink']);
                                      $imagesArr = explode(';',$confArr->picGal);
                                       $ownConfig = json_decode($value['selemOwnConfig']);
                                      $cartTab = $ownConfig->vOwnUserSettings->carTab;
                                      
                                      
                                       if(empty($value['selemPicGal'])){
                                            $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                       }else{
                                            
                                            $gallery = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($value['selemPicGal']);  
                                            if(!empty($gallery)){
                                                $imagesArr = explode(';',$gallery);
                                                 $image = $mmFunctionsObj->getPicOnceDataByIdMM($imagesArr[0]);
                                               
                                            }else{
                                                $imagesArr =array();
                                            } 
                                       }
                                       
                                        $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($value['seitID']).' AND seitOnline = 1 ORDER BY seitPosition ASC';
                                        $sqlErg = $this->dbAbfragen($sqlText);
                                        $row = mysql_fetch_array($sqlErg);
                                        
                                       $siteUrl  = SITE_URL.$_GET['_lang'].'/'.$row['seitTextUrl'];
                                        
                                        if(file_exists(SITE_PATH.'/user_upload/thumb_800/'.$image['bildName'])){
                                                $imageSrc =  '/user_upload/thumb_800/'.$image['bildName'];
                                             }else{
                                                $imageSrc =  '/user_upload/'.$image['bildName']; 

                                             }
                                        
                                     
                                        
                                    if($value['selemID'] != 13){  
                                    ?>
                            
                                    
				<div class="panel panelLarge panelPhoto giveMeBackground opensDropdown" data-target="#panelDropdown<?php echo $value['selemID']  ?>">
					<img class="hereIsYourBackgroud hidden" src="<?php echo $imageSrc  ?>"/>
					<div class="panelOverlay">
					<?php    echo $textsArr->elemText2; ?>
					</div>
					<div class="panelTitle">
						<?php    echo $textsArr->elemText1;  ?>
					</div>
				</div>
                            
                                
                            
				<div class="infoPanel panelDropdown" id="panelDropdown<?php echo $value['selemID']  ?>">
					<span class="panelDropdownClose"></span>
					<h2><?php    echo $textsArr->elemText2; ?></h2>
					<?php    echo $textsArr->elemText3;
                                        
                                        if(count($imagesArr) >1){ ?>
						<div class="infoPanelCategory icoBilder" data-target-tab="#tab" >
							<div class="infoIcon galleryIcon ">
                                                         <img src="/templates/wildkogel/img/galerie_weiss.png">
							 <img class="alternative" src="/templates/wildkogel/img/galerie_weiss_red.png">
							</div>
							<div class="infoTitle galleryIcon">
							<?php echo  lang('mehr-bilder'); ?>
							</div>
						</div>
                                            <?php foreach($imagesArr  as $imgs => $img){
                                                
                                                $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" style="display:none;" rel="<?php echo $value['seitID']; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                                
                                         <?php   } ?>
                                          
                                            
                                            <?php } ?>
                                        
                                        
                                        
					<a href="<?php echo $siteUrl;?>"><?php echo  lang('mehr'); ?></a>
					 <?php echo  $mmFunctionsObj->cartButton($value['seitID'],$cartTab)  ?>
				</div>
                                <?php  }
                                }
                                             }
                                    
                                        }
                                    
                                    }
                       ?>
			</div>
                        
                        
               <?php     }
                 ?>
                    
		</div>
            
            <?php  $i++; } ?>
            
            
		<div class="panelsRow">
			
		</div>
	</div>