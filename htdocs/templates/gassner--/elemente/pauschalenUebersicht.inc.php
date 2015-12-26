<?php
 global $cmsObj;

 $curLinkToAnfrage = '#';
 if (isset($cmsObj)) {
	 $curLinkToAnfrage = $cmsObj->getCurentLinkBySiteIdUser(212);
 }

 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
 $mmFunctionsObj = new mmFunctionsLibrary();




 $mmAllPauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArray($thisElemArr['elemData']['seitID'], 62);
 
 
  
 $mmAllFilterkategoriesListArr = $mmFunctionsObj-> mmGetAllMultiFilterkategoriesListArray($thisElemArr['elemData']['seitID'],62);




 $curLangPauschaleLink = '';

 if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
	 $curLangPauschaleLink = $_POST['VCMS_POST_LANG'].'/';
 }
?>

<div class="filters">
	<div class="filters-inner">
<?php echo $thisElemArr['text2']; ?>
		<div class="filters-buttons">
			<span id="filters-close">X  schliessen</span>
			<a href="javascript:void(0)" class="filter-button" data-id="*">Alle</a>
		<?php
		 if (isset($mmAllFilterkategoriesListArr) && is_array($mmAllFilterkategoriesListArr) && count($mmAllFilterkategoriesListArr) > 0) {
			 foreach ($mmAllFilterkategoriesListArr as $key => $value) {
				 echo ' <a href="javascript:void(0)" class="filter-button" id="button-'.$key.'" data-id="'.$key.'">'.$value.'</a>';
			 }
		 }
		?>
		</div>
	</div>
	<div class="filters-mobile">
		<h2>Filtern sie nach projekte gleich hier</h2>
		<a href="" class="filter-mobile-button">Filtern</a>
	</div>
</div>

<div class="works"> 

<?php echo $thisElemArr['text1']; ?>



	<div class="projects-row">

<?php
 // print_r($mmAllPauschaleListArr);

 foreach ($mmAllPauschaleListArr as $key => $value) {
	 // Für Bild Ausgabe
	 // ***********************************************************************
	 
	 
	 
	 $picSecond = '';
    $mainImage = $mmFunctionsObj->mmGetSiteListDataArrayOnce($key, 60);

 //   print_r($mainImage);
    
    $mainImageArr = (json_decode($mainImage['detailElemData']['selemConfig']) );

	
   $idMainImage =   $mainImageArr->picGal;
    $picSecond = $mmFunctionsObj->getPicOnceDataByIdMM($idMainImage);

     if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picSecond['bildFile'])) {
         $curThumb = 'thumb_800/';
         $bildSecondMFile = 'user_upload/'.$curThumb.$picSecond['bildFile'];
    }else{
         $bildSecondMFile = '';
    }
      
     
	 $bildMFile = '';
	 $picGalIds = '';

$mmOncePauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($key, 61);
	  
	  
$titleArr =(json_decode($mmOncePauschaleListArr['detailElemData']['selemInhalt']) );
$siteTitle = $titleArr->elemText1;


 if (isset($mmOncePauschaleListArr['detailElemData']['selemPicGal']) && !empty($mmOncePauschaleListArr['detailElemData']['selemPicGal'])) {
					 $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($mmOncePauschaleListArr['detailElemData']['selemPicGal']);
				 }
				 if (!isset($picGalIds) || empty($picGalIds)) {
					 $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromElementPicGalery($mmOncePauschaleListArr['detailElemData']['selemConfig']);
				 }
				 $picGalPicsArr = explode(';', $picGalIds);
				 
				 
     
	 
	 $count = 0;
	 foreach ($picGalPicsArr as $picId) {
		 $count++;
		 $picOnce = $mmFunctionsObj->getPicOnceDataByIdMM($picId);
		 if ($count == 2) {
			 $curThumb = '';
			 if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picOnce['bildFile'])) {
				 $curThumb = 'thumb_800/';
			 }
			 $bildMFile = 'user_upload/'.$curThumb.$picOnce['bildFile'];
		 }

	
	 }


	 // Für Text Ausgabe
	 // ***********************************************************************
	 $curSelemInhaltArr = json_decode($value['detailElemData']['selemInhalt'], true);



	 // Für Filter Kategorien Klassen
	 // ***********************************************************************
	 $classBuild = '';
	 $allFilterKats = $mmFunctionsObj->mmGetAllFilterkategoriesListBySiteID($key);
  
 
  
	 if (isset($allFilterKats) && !empty($allFilterKats)) {
	  $classBuild = '';
   foreach($allFilterKats as $key => $value3){
    
    $allFilterKatsArr = explode(';', $value3);
   
 		 foreach ($allFilterKatsArr as $valueFilKatI) {
 			 $classBuild .= ' mmPauschalenUebersichtElementSpalteId-'.$valueFilKatI;
 		 }
    
   }
   
		 
	 }



	 // Für Element Settings
	 // ***********************************************************************
	 $isElementBergLustPur = '';
	 $isElementBergLustPurStyle = '';
	 $isMoreTimesElem = '';
	 if (isset($value['detailElemData']['selemOwnConfig']) && !empty($value['detailElemData']['selemOwnConfig'])) {
		 $detailElemSettingArrOnce = json_decode($value['detailElemData']['selemOwnConfig'], true);
		 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur']) && $detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur'] == 'on') {
			 $isElementBergLustPurStyle = ' style="background-color:#c9bd9a;"';
			 $isElementBergLustPur = 'on';
		 }
		 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['moreTimes']) && $detailElemSettingArrOnce['vOwnUserSettings']['moreTimes'] == 'on') {
			 $isMoreTimesElem = 'on';
		 }
	 }
	 ?> 


	 		<div class="project <?php echo $classBuild; ?>">

	 			<div class="project-image">
	 				<img src="<?php echo $bildMFile; ?>" />
	 			</div>
	 			<div class="project-image-secondary">
	 				<img src="<?php echo $bildSecondMFile; ?>" />
	 			</div>
	 			<div class="project-overlay">
	 				<div class="project-box-inner">
	 <?php echo $siteTitle; ?>
	
	 				</div>
	 			</div>
	 <?php if (empty($_SESSION['VCMS_USER_NAME'])) { ?>
		 			<a href="<?php echo $curLangPauschaleLink.$value['seitTextUrl']; ?> "  ></a>
	 <?php } ?>
	 		</div>




				 <?php
				 $bildSecondMFile = '';
			 }
			?>
	</div>
</div>
