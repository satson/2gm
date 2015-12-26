

<?php if (!isset($cms['cms_ownFields']['_showCTAHead']) || $cms['cms_ownFields']['_showCTAHead'] != 'on') { ?>
<div class="container">
  <div class="siteRightPos">
    <div class="mmSiteTopInfoBoxWhite">
      <div class="mmSiteTopInfoBoxWhiteLeft">
        <?php echo $cmsObj->setElementHolder('mmSiteTopInfoBoxWhiteLeft', 'inherit'); ?>
        <?php /*Frühbucher<br />Bonus<br />-10%
        <br />
        <a class="mmSiteTopInfoBoxWhiteABtn" href="#">mehr</a>*/ ?>
      </div>
      <div class="mmSiteTopInfoBoxWhiteMiddle">
        <?php echo GASSNER_UNSERE_BEWERTUNGEN_BREAK; ?>
        <br />
        <span class="mmSiteTopInfoBoxWhiteBwBtn"><?php echo GASSNER_LESEN; ?></span>
      </div>
      <div class="mmSiteTopInfoBoxWhiteRight">
        <?php echo $cmsObj->setElementHolder('mmSiteTopInfoBoxWhiteRight', 'inherit'); ?>
        <?php /*Last<br />Minute<br />-10%
        <br />
        <a class="mmSiteTopInfoBoxWhiteABtn" href="#">mehr</a>*/ ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>



<?php
echo '<div class="container breadcrumbHolderElemContainer">';
echo '<div class="breadcrumbHolderElem">'.$cmsObj->getSiteBreadcrumbsString('&nbsp;&raquo;&nbsp;').'<div class="clearer"></div></div>';
echo '</div>';

echo $cmsObj->setElementHolder('contentSite');
?>