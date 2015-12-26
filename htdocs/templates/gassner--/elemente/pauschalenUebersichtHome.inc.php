<?php
 global $cmsObj;

 $curLinkToAnfrage = '#';
 if (isset($cmsObj)) {
	 $curLinkToAnfrage = $cmsObj->getCurentLinkBySiteIdUser(212);
 }

 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
 $mmFunctionsObj = new mmFunctionsLibrary();


 $curLangPausLink = '';

 if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
	 $curLangPausLink = $_POST['VCMS_POST_LANG'].'/';
 }

 if ($thisElemArr['elemData']['selemID'] == 2454) {
	 ?>



	 <div class="works">
	 	
	 	<?php echo $thisElemArr['text1'] ; ?>
	 	<div class="projects-row">

	 <?php
	 //$siteArrZwArrTest = explode(';', '39;41;42;44');
	 $siteArrZwArrTest = explode(';', $thisElemArr['elemSettings']['pauschalenList']);



	 $countElems = 1;

	 foreach ($siteArrZwArrTest as $value) {
		 if (isset($countElems) && $countElems < 5) {
			 $mmOncePauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($value, 61);

    
    $picSecond = '';
    $mainImage = $mmFunctionsObj->mmGetSiteListDataArrayOnce($value, 60);
	
	
   $mainImageArr = (json_decode($mainImage['detailElemData']['selemConfig']) );
   $idMainImage =   $mainImageArr->picGal;
    $picSecond = $mmFunctionsObj->getPicOnceDataByIdMM($idMainImage);

     if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picSecond['bildFile'])) {
         $curThumb = 'thumb_800/';
         $bildSecondMFile = 'user_upload/'.$curThumb.$picSecond['bildFile'];
    }else{
         $bildSecondMFile = '';
    }
      
    
     
    
        $titleArr =(json_decode($mmOncePauschaleListArr['detailElemData']['selemInhalt']) );
$siteTitle = $titleArr->elemText1;            
                    
                   
                    
			 if (isset($mmOncePauschaleListArr['detailElemData']['selemInhalt']) && !empty($mmOncePauschaleListArr['detailElemData']['selemInhalt'])) {
				 $countElems++;

				 // Für Bild Ausgabe
				 // ***********************************************************************
				 $bildMFile = '';
				 $picGalIds = '';
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
				 $curSelemInhaltArr = json_decode($mmOncePauschaleListArr['detailElemData']['selemInhalt'], true);



				 // Für Element Settings
				 // ***********************************************************************
				 $isElementBergLustPur = '';
				 $isElementBergLustPurStyle = '';
				 $isMoreTimesElem = '';
				 if (isset($mmOncePauschaleListArr['detailElemData']['selemOwnConfig']) && !empty($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'])) {
					 $detailElemSettingArrOnce = json_decode($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'], true);
					 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur']) && $detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur'] == 'on') {
						 $isElementBergLustPurStyle = ' style="background-color:#c9bd9a;"';
						 $isElementBergLustPur = 'on';
					 }
					 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['moreTimes']) && $detailElemSettingArrOnce['vOwnUserSettings']['moreTimes'] == 'on') {
						 $isMoreTimesElem = 'on';
					 }
				 }
				 ?>

				 		<div class="project">

				 		<div class="project-image">
				 				<img src="<?php echo $bildMFile; ?>" />
				 			</div>
				 			<div class="project-image-secondary">
        <?php if( $bildSecondMFile != ''){
         
         ?>
				 				<img src="<?php echo $bildSecondMFile; ?>" />
        <?php } ?> 
         
				 			</div>
				 			<div class="project-overlay">
				 				<div class="project-box-inner">
				 <?php echo $siteTitle; ?>
				
				 				</div>
				 			</div>
        <?php  if(empty($_SESSION['VCMS_USER_NAME'])){ ?>
				 			<a href="<?php echo $curLangPausLink.$mmOncePauschaleListArr['seitTextUrl']; ?>"> </a>
        <?php } ?>
        
				 		</div>







				 <?php
			 }
		 }
	 }
	 ?>



	 	</div>
	 </div>


		 <?php } else { ?>


	 <div style="height:1px;"></div>
	 <div class="mmPauschalenUebersichtElement">


	 	<div class="mmPauschalenUebersichtElementBottom mmPauschalenUebersichtElementBottomWithOwlCarousel">
	 		<div class="row">

	 <?php
	 //$siteArrZwArrTest = explode(';', '39;41;42;44');
	 $siteArrZwArrTest = explode(';', $thisElemArr['elemSettings']['pauschalenList']);

	 $countElems = 1;

	 foreach ($siteArrZwArrTest as $value) {
		 if (isset($countElems) && $countElems < 5) {
			 $mmOncePauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($value, 16);
			 if (isset($mmOncePauschaleListArr['detailElemData']['selemInhalt']) && !empty($mmOncePauschaleListArr['detailElemData']['selemInhalt'])) {
				 $countElems++;

				 // Für Bild Ausgabe
				 // ***********************************************************************
				 $bildMFile = '';
				 $picGalIds = '';
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
					 if ($count == 1) {
						 $curThumb = '';
						 if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_upload/thumb_800/'.$picOnce['bildFile'])) {
							 $curThumb = 'thumb_800/';
						 }
						 $bildMFile = 'user_upload/'.$curThumb.$picOnce['bildFile'];
					 }
				 }


				 // Für Text Ausgabe
				 // ***********************************************************************
				 $curSelemInhaltArr = json_decode($mmOncePauschaleListArr['detailElemData']['selemInhalt'], true);



				 // Für Element Settings
				 // ***********************************************************************
				 $isElementBergLustPur = '';
				 $isElementBergLustPurStyle = '';
				 $isMoreTimesElem = '';
				 if (isset($mmOncePauschaleListArr['detailElemData']['selemOwnConfig']) && !empty($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'])) {
					 $detailElemSettingArrOnce = json_decode($mmOncePauschaleListArr['detailElemData']['selemOwnConfig'], true);
					 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur']) && $detailElemSettingArrOnce['vOwnUserSettings']['bergLustPur'] == 'on') {
						 $isElementBergLustPurStyle = ' style="background-color:#c9bd9a;"';
						 $isElementBergLustPur = 'on';
					 }
					 if (isset($detailElemSettingArrOnce['vOwnUserSettings']['moreTimes']) && $detailElemSettingArrOnce['vOwnUserSettings']['moreTimes'] == 'on') {
						 $isMoreTimesElem = 'on';
					 }
				 }





				 echo '<div class="col-md-6 col-lg-3 col-sm-6 mmPauschalenUebersichtElementSpalte mmPauschalenUebersichtElementSpalteId-1">';
				 echo '<div class="mmPauschalenUebersichtElementPauschale"'.$isElementBergLustPurStyle.'>';



				 echo '<div class="mmPauschalenUebersichtElementPauschaleBild"><a href="'.$curLangPausLink.$mmOncePauschaleListArr['seitTextUrl'].'"><img src="'.$bildMFile.'" alt="" title="" /></a></div>';

				 echo '<div class="mmPauschalenUebersichtElementPauschaleTextHolder">';



				 echo '<div class="mmPauschalenUebersichtElementPauschaleLinkBtnsHolder">';



				 echo '</div>';
				 echo '</div>';

				 echo '</div>';
				 echo '</div>';
			 }
		 }
	 }
	 ?>



	 		</div>
	 	</div>
	 </div>







			 <?php } ?>


