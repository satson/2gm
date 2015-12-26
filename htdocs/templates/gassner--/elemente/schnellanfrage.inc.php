<?php

global $cmsObj;
global $cms;

?>


<div style="height:1px;"></div>
<div class="mmSchnellAnfrageElement mmSchnellAnfrageElementOwnElementFixed">
  <div class="mmSchnellAnfrageElementInner">
    <div class="container">
      <div class="siteLeftPos">
        <?php echo $thisElemArr['text1']; ?>
      </div>
      <div class="siteRightPos">
        <div class="mmSchnellAnfrageElementIco"></div>
        <div class="mmSchnellAnfrageElementUe"><?php echo $thisElemArr['text2']; ?></div>
        <div class="mmSchnellAnfrageElementForms">
          <?php
          if (isset($cmsObj)) {
          ?>
          <form action="<?php echo $cmsObj->getCurentLinkBySiteIdUser(212); ?>?_curSiteId=<?php echo $cms['cms_siteID']; ?>" method="post">
          <?php
          }
          ?>
            <input type="text" name="frmAnreiseDate" id="frmAnreiseDate" class="isSystemCalendarPickMM" placeholder="<?php echo GASSNER_ANREISE; ?>" />
            <input type="text" name="frmAbreiseDate" id="frmAbreiseDate" class="isSystemCalendarPickMM" placeholder="<?php echo GASSNER_ABREISE; ?>" />
            <input type="text" name="frmAnzahlErwachsene" id="frmAnzahlErwachsene" placeholder="<?php echo GASSNER_ERWACHSENE; ?>" />
            <input type="text" name="frmAnzahlKinder" id="frmAnzahlKinder" placeholder="<?php echo GASSNER_KINDER; ?>" />
            <input type="submit" value="<?php echo GASSNER_JETZT_ANFRAGEN; ?>" />
          <?php
          if (isset($cmsObj)) {
          ?>
          </form>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>