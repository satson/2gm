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

?>

<div class="trusted-by">
            <div class="trusted-inner">
                <div class="trusted-header">
                    Trusted by.
                </div>
                <div id="trusted-logos" >
      
      <?php
    
    
     
      
      //$siteArrZwArrTest = explode(';', '39;41;42;44');
      $siteArrZwArrTest = explode(';', $thisElemArr['elemSettings']['trusted']);
	  
       
      $countElems = 1;
      
      foreach ($siteArrZwArrTest as $value) {
        if (isset($countElems)) {
          $mmOncePauschaleListArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($value, 61);
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

?>

   <div class="trusted-logo">
                        <img src="<?php echo $bildMFile; ?>" />
                    </div>

     
  <?php   
     
         
            
            
          }
        }
      }
      ?>
      
 		</div>
      
    </div>
  </div>
</div>
 
 
 

