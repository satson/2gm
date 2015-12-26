<?php

global $cmsObj;
global $cms;

$curLinkToAnfrage = '#';
if (isset($cmsObj)) {
  $curLinkToAnfrage = $cmsObj->getCurentLinkBySiteIdUser(212);
}
$curLinkToBuchen = '#';
if (isset($cmsObj)) {
  $curLinkToBuchen = $cmsObj->getCurentLinkBySiteIdUser(213);
}

?>


<div style="height:1px;"></div>
<div class="mmAnfrageBuchenBtnsElement">
  <div class="mmAnfrageBuchenBtnsElementInner">
    <div class="container">
      <div class="siteLeftPos">
        <?php echo $thisElemArr['text1']; ?>
      </div>
      <div class="siteRightPos">
        <div class="mmAnfrageBuchenBtnsElementBewertungBtn">
          <div style="height:1px;"></div>
          <div class="mmAnfrageBuchenBtnsElementBewertungBtnTextUe"><?php echo GASSNER_UNSERE_BEWERTUNGEN; ?></div>
          <div class="mmAnfrageBuchenBtnsElementBewertungBtnTextS"><?php echo GASSNER_LESEN; ?></div>
        </div>
        
        <div class="mmAnfrageBuchenBtnsElementBtnsHolder">
          <a href="<?php echo $curLinkToAnfrage; ?>?_curSiteId=<?php echo $cms['cms_siteID']; ?>"><div class="mmAnfrageBuchenBtnsElementBtnLeft"><?php echo $thisElemArr['text2']; ?></div></a>
          <?php
          if (!isset($thisElemArr['elemSettings']['fieldOneBtn']) || $thisElemArr['elemSettings']['fieldOneBtn'] != 'on') {
          ?>
          <a href="<?php echo $curLinkToBuchen; ?>"><div class="mmAnfrageBuchenBtnsElementBtnRight"><?php echo $thisElemArr['text3']; ?></div></a>
          <?php
          }
          ?>
          <div class="clearer"></div>
        </div>
      </div>
    </div>
  </div>
</div>