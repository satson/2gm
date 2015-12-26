<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();

?>


<div style="height:1px;"></div>
<div class="mmTableOwnElement mmTableOwnElement2Spalten">
  <div class="row" style="position:relative;">
    <div class="col-md-6 mmTableOwnElementRowFirstE"><?php echo $thisElemArr['text1']; ?></div>
    <div class="col-md-6 mmTableOwnElementRowLastE"><?php echo $thisElemArr['text2']; ?></div>
    
    <?php
    if (isset($thisElemArr['elemSettings']['zimmerList']) && !empty($thisElemArr['elemSettings']['zimmerList'])) {
      $allZimmerSitesArr = explode(';', $thisElemArr['elemSettings']['zimmerList']);
      if (isset($allZimmerSitesArr[0])) {
        $allHiddenPicGalsElems = '';

        $mmOneZimmerArr = $mmFunctionsObj->mmGetSiteListDataArrayOnce($allZimmerSitesArr[0], 17);

        // Für Bild Ausgabe
        // ***********************************************************************
        $bildM = '';
        $picGalIds = '';
        if (isset($mmOneZimmerArr['detailElemData']['selemPicGal']) && !empty($mmOneZimmerArr['detailElemData']['selemPicGal'])) {
          $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromPicGalery($mmOneZimmerArr['detailElemData']['selemPicGal']);
        }
        if (!isset($picGalIds) || empty($picGalIds)) {
          $picGalIds = $mmFunctionsObj->getAllPicOnceIdsFromElementPicGalery($mmOneZimmerArr['detailElemData']['selemConfig']);
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
            //$bildM = '<div class="mmBildTextSliderElemOnceBild"><img src="user_upload/'.$curThumb.$picOnce['bildFile'].'" alt="" title="" /></div>';
            $linkFirstPic = '<a href="user_upload/'.$picOnce['bildFile'].'" class="ownElemPicGalerieLinkClass" rel="impZiGal'.$thisElemArr['elemData']['selemID'].'">';
          }
          else {
            $allHiddenPicGalsElems .= '<a href="user_upload/'.$picOnce['bildFile'].'" class="ownElemPicGalerieLinkClass" rel="impZiGal'.$thisElemArr['elemData']['selemID'].'"></a>';
          }
        }

        echo $linkFirstPic.'<div class="mmTableOwnElementLinkPicIco">';

        //echo $bildM;

        echo '</div></a>';

        echo '<div style="display:none;">' . $allHiddenPicGalsElems . '</div>';
      }
    }
    ?>
    
  </div>
  <div class="clearer"></div>
</div>