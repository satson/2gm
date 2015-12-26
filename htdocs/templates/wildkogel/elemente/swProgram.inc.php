
<?php  

global $cmsObj;
 

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();

$siteArr = explode(';',$thisElemArr['elemSettings']['pauschalenList']);

if(empty($siteArr[0]) ){
   $siteArr =  $mmFunctionsObj->getParentSites($thisElemArr['elemData']['seitID']); 
}

 $filterSiteArr = $mmFunctionsObj->getFiltersIds($thisElemArr['elemData']['seitID']);
 
 foreach($siteArr as $key => $value){
     $query = mysql_query("SELECT seitOnline FROM vseiten WHERE seitID='$value' AND seitOnline=1");
     if(mysql_num_rows($query) == 1){
        $dataArr[] =   $mmFunctionsObj->mmGetSiteDetailMultiElementDataArr($value,'18'); 
       // $filters = $mmFunctionsObj->getFilters($value,$filterSiteArr);

       // if(!empty($filters)){
          // $mmAllFilterkategoriesListArr[$value] = $mmFunctionsObj->getFilters($value,$filterSiteArr); 
       // }
     }    

 }
 
 $siteArr1 =  $mmFunctionsObj->getParentSites($thisElemArr['elemData']['seitID']); 
  
  foreach($siteArr1 as $key => $value){
     $query = mysql_query("SELECT seitOnline FROM vseiten WHERE seitID='$value' AND seitOnline=1");
     if(mysql_num_rows($query) == 1){
       // $dataArr[] =   $mmFunctionsObj->mmGetSiteDetailMultiElementDataArr($value,'20'); 
        $filters = $mmFunctionsObj->getFilters($value,$filterSiteArr);

        if(!empty($filters)){
           $mmAllFilterkategoriesListArr[$value] = $mmFunctionsObj->getFilters($value,$filterSiteArr); 
        }
     }
 }
 
 
 
$i=1;
 foreach($mmAllFilterkategoriesListArr as $key => $value){
     
    
     foreach($value as $key1 => $value1){
      // $k = ($i%2==0)?0:1;
       
       $mmAllFilterkategoriesListArr1[] = $value1;
       
       $i++;  
     }
     
 }
 
 
 foreach($mmAllFilterkategoriesListArr1 as $key3 => $value3){
      $t2[$value3['id']] = array('id'=>$value3['id'],'name'=>$value3['name']);
     foreach($value3['children'] as $childs => $child){
         
         $t2['children'][$value3['id']][$child['id']] = array('id'=>$child['id'],'name'=>$child['name']);
         $filtrSiteArr[$child['id_site']][] = 'filtr-'.$child['id'];
     }
 }
 
 $i=1;
 foreach($t2 as $key => $value){
     
     if($key != 'children'){
        $k = ($i%2==0)?1:0; 
         $t3[$k][] = $value;
      $i++;   
     }
     
 }


 $limitItems = $thisElemArr['elemSettings']['item_limit'];
?>

<div class="homeHeader">
		<h1><?php echo $thisElemArr['text1']; ?></h1>
	</div>

<?php if(empty($thisElemArr['elemSettings']['hideFilter']) || $thisElemArr['elemSettings']['hideFilter'] == 1){ ?>
<div class="filters">
	<div class="filtersSelector contracted">
		<h2>
			<?php echo  lang('open-filter'); ?>
		</h2>
	</div>
		<div class="filtersForm">
		<h2><?php echo  lang('filter-list'); ?></h2>
		<div class="row">
			<div class="col-md-6 col-sm-6">
                            
                             <?php 
                              
                             foreach ($t3[0] as $key => $value){ 
                                
                                     ?> 
                                  <?php  if(!empty($t2['children'][$value['id']])){  ?>
				<div class="filterDropdown">
					<div class="filterHeader">
						<?php echo $value['name'] ?>
					</div>
                                    
                                      
                                    
					<div class="filterControls">
                                              <?php $i=1; foreach($t2['children'][$value['id']] as $key1 => $value1){ ?>
						<div class="form-group">
                                                    <input type="checkbox" name="" value="<?php echo $value1['id']; ?>" id="f<?php echo $i; ?>" class="filtrCheckbox"/>
							<label for="f<?php echo $i; ?>" class="filtrCheckbox"><?php echo $value1['name'] ?></label>
						</div>
                                              <?php
                                              
                                              $filtrSiteArr[$key][] = 'filtr-'.$value1['id'];
                                              $i++;
                                              
                                              } ?>
					</div>
                                      
                                    
				</div>
                             <?php  } ?>
                            
                             <?php  
                           
                             
                          } ?>
                            
				

			</div>
			<div class="col-md-6 col-sm-6">
			<?php 
                              
                             foreach ($t3[1] as $key => $value){ 
                                
                                     ?>
                               <?php  if(!empty($t2['children'][$value['id']])){ ?>
				<div class="filterDropdown">
					<div class="filterHeader">
						<?php echo $value['name'] ?>
					</div>
                                    
                                       
                                    
					<div class="filterControls">
                                              <?php $i=1; foreach($t2['children'][$value['id']] as $key1 => $value1){ ?>
						<div class="form-group">
                                                    <input type="checkbox" name="" value="<?php echo $value1['id']; ?>" id="f<?php echo $i; ?>" class="filtrCheckbox"/>
							<label for="f<?php echo $i; ?>" class="filtrCheckbox"><?php echo $value1['name'] ?></label>
						</div>
                                              <?php
                                              
                                              $filtrSiteArr[$key][] = 'filtr-'.$value1['id'];
                                              $i++;
                                              
                                              } ?>
					</div>
                                      
                                    
				</div>
                             <?php  } ?>
                             <?php  
                           
                             
                          } ?>

			</div>
		</div>
	</div>
</div>

<?php } ?>


	<div class="bigPanels">
		<div class="panelsRow">
                    
                    <?php
                 
                     $seleIdArr = [];
                     
                     $countData =  count($dataArr);
                     $countAllData =  count($dataArr);
                    $n=1;
                    $i=1; foreach($dataArr as $key1 => $value1){
                                    foreach($value1 as $key => $value){
                                   $class = ($i%2!=0)?'panelsLeft':'panelsRight';
                               
                                   $textsArr = json_decode($value['selemInhalt']);
                                   $confArr  = json_decode($value['selemConfig']);
                                   $linkArr  = json_decode($value['selemLink']);
                                   
                                    $ownConfig = json_decode($value['selemOwnConfig']);
                                    
                                 
                                   $cartTAb = $ownConfig->vOwnUserSettings->carTab;
                                   
                                   $imagesArr = explode(';',$confArr->picGal);
                                    if(!empty($imagesArr[0])){
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
                                    $idSite = $value['seitID'];
                                   $seleIdArr[] = $value['selemID'];
                                   $selemIdText[$value['selemID']] = array('text3'=>$textsArr->elemText3,'text4'=>$textsArr->elemText4,'id_site'=> $idSite,'cartTab'=> $cartTAb);
                                   
                                   
                                  
                                   
                              
                                   
                                    $sqlText = 'SELECT seitID, seitTextUrl FROM vseiten WHERE seitID = '.$this->dbDecode($value['seitID']).' AND seitOnline = 1 ORDER BY seitPosition ASC';
                                    $sqlErg = $this->dbAbfragen($sqlText);
                                    $row = mysql_fetch_array($sqlErg);
                                    $siteUrl  = $row['seitTextUrl'];
                                   
                                    
                                    
                                    $sqlText = 'SELECT* FROM vseitenelemente WHERE selemDataName = "curInElementHolder'.$value['selemID'].'" ORDER BY selemPosition ';
                                    $sqlErg = $this->dbAbfragen($sqlText);
                                    
                                    $display = ($i > $limitItems && !empty($limitItems))?'display:none':'';
                                    $more    = ($i==$limitItems)?'<div class="moreLink"><a href="javascript:void(0)" id="more">'.lang('mehr2').' </a></div>':'';
                                    
                                    $filtrClass = implode(' ',$filtrSiteArr[$value['seitID']]); 
                                    
                                     if(file_exists(SITE_PATH.'/user_upload/thumb_800/'.$image['bildName'])){
                                       $imageSrc =  '/user_upload/thumb_800/'.$image['bildName'];
                                    }else{
                                       $imageSrc =  '/user_upload/'.$image['bildName']; 
                                        
                                    }
                                    
                        ?>
                                       <div class="<?php echo $class; ?> boxItem <?php echo $filtrClass ?>" style="<?php echo $display; ?>">
                                                <div class="panel panelLarge panelPhoto giveMeBackground opensBigDropdown" data-target="#bigDropdown<?php echo $value['selemID']  ?>">
                                                        <img class="hereIsYourBackgroud hidden" src="<?php echo $imageSrc  ?>"/>
                                                        <div class="panelTitle">
                                                                <?php    echo $textsArr->elemText2; ?>
                                                        </div>
                                                        <div class="panelOverlay" >
                                                                <?php    echo $textsArr->elemText4; ?>
                                                        </div>
                                                </div>
                                        </div>
                                        <?php echo $more; ?>    
                    
                    
                    

                                    <?php $i++; }  
                                    
                                  
                                    
                                    if(count($seleIdArr) == 2 || $countData == 1  || $n==$countAllData ){
                                     
                                     
                                    
                                       foreach($seleIdArr as $elems => $elem){
                                           
                                           
                                              $sqlText = 'SELECT* FROM vseitenelemente WHERE selemDataName = "curInElementHolder'.$elem.'" ORDER BY selemPosition ';
                                             $sqlErg = $this->dbAbfragen($sqlText);
                                    ?>
                                    
                                    	<div class="bigDropdown bigInfoPanel multiInfoPanel" id="bigDropdown<?php echo $elem  ?>">
			<span class="bigDropdownClose"></span>
			<div class="bigInfoPanelInner">
				<div class="infoPanelLeft">
					<div class="infoPanelCategories">
                                            
                                            <div class="infoPanelCategory" data-target-tab="#tab<?php echo $elem; ?>">
							<div class="infoIcon">
                                                            <img src="/templates/wildkogel/img/house_white.png">
							 <img class="alternative" src="/templates/wildkogel/img/house_red.png">
							</div>
							<div class="infoTitle">
							Übersicht
							</div>
						</div>
                                            
                                            <?php while($row= mysql_fetch_array($sqlErg)){
                                                   $textsArr1 = json_decode($row['selemInhalt']);
                                                    $confArr  = json_decode($row['selemConfig']);
                                                    
                                                    $picArr  = explode(';',$confArr->picGal);
                                                    
                                                  
                                                    
 
                                                    $image = $mmFunctionsObj->getPicOnceDataByIdMM($picArr[0]);
                                                    if(isset($picArr[1] ) ){
                                                      $image1 = $mmFunctionsObj->getPicOnceDataByIdMM($picArr[1]);  
                                                    }
                                                    
                                                     
                                                ?>
						<div class="infoPanelCategory" data-target-tab="#tab<?php echo $row['selemID'] ?>">
							<div class="infoIcon">
                                                            <img  src="/user_upload/<?php  echo $image['bildName']  ?>" />
								<img class="alternative" src="/user_upload/<?php  echo $image1['bildName']  ?>" />
							</div>
							<div class="infoTitle">
								<?php  echo $textsArr1->elemText1; ?>
							</div>
						</div>
                                        <?php } ?>
                                            <?php
                                            
                                            
                                            if(count($imagesArr) >1){ ?>
						<div class="infoPanelCategory" >
							<div class="infoIcon galleryIcon">
                                                         <img src="/templates/wildkogel/img/galerie_weiss.png">
							 <img class="alternative" src="/templates/wildkogel/img/galerie_weiss_red.png">
							</div>
							<div class="infoTitle galleryIcon">
							<?php echo  lang('mehr-bilder'); ?> 
							</div>
						</div>
                                            <?php foreach($imagesArr  as $imgs => $img){
                                                
                                                $image = $mmFunctionsObj->getPicOnceDataByIdMM($img); ?>  <a href="user_upload/<?php  echo $image['bildName']  ?>" rel="<?php echo $idSite; ?>" class="vCmsLinkingPicLightboxShow"></a>
                                                
                                         <?php   } ?>
                                          
                                            
                                            <?php } ?>
						
						
					</div>
				</div>
                            
                <div class="infoPanelRight infoPanelTab" id="tab<?php echo $elem; ?>" style="display:block;">
                                  
						<h2 class="rightPanelTitle" data-id = "<?php echo $i; ?>"><?php  echo $selemIdText[$elem]['text4']; ?></h2>
						<?php  echo $selemIdText[$elem]['text3']; ?>	
                                                
                                                <?php   echo  $mmFunctionsObj->cartButton($selemIdText[$elem]['id_site'],$selemIdText[$elem]['cartTab']); ?>
                                                    <?php $mmFunctionsObj->getAllPicOnceIdsFromElementPicGalery($selemConfig,$selemIdText[$elem]['cartTab']) ?>
				</div>
                            
                            <?php
                            
                             $sqlText = 'SELECT* FROM vseitenelemente WHERE selemDataName = "curInElementHolder'.$elem.'" ';
                             $sqlErg = $this->dbAbfragen($sqlText);

                             
                            while($row= mysql_fetch_array($sqlErg)){
                                    $textsArr2 = json_decode($row['selemInhalt']);
                            ?>
                            
				<div class="infoPanelRight infoPanelTab" id="tab<?php echo $row['selemID'] ?>">
                                  
						<h2 class="rightPanelTitle" data-id = "<?php echo $i; ?>"><?php  echo $textsArr2->elemText2; ?></h2>
						<?php  echo $textsArr2->elemText3; ?>					<div class="panelHeart">
							<?php 
                                                      
                                                  
                                                        echo  $mmFunctionsObj->cartButton($selemIdText[$elem]['id_site'],$selemIdText[$elem]['cartTab']);  ?>
                                                    
						</div>
					</div>
                            <?php 
                            
                            
                            
                            
                            } ?> 
                            
                            
			</div>
		</div>
                    
                                       <?php }
                                       
                                        $seleIdArr = [];
                                       
                                    } ?>
                                    
                                    
                               <?php   $n++;   } ?>
		
		</div>
           
	
	</div>