<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


include_once('admin/inc/klassen/allgemein.inc.php');
$allgemeinObj = new cmsAllgemein();

?>


<div id="vFrontHeader">
  <div class="vFrontHeaderBack"></div>
  <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) { ?>
  <div class="vFrontHeaderBtn" id="vFrontBtnElementsDummy" title="Elemente"></div>
  <?php }
  else { ?>
  <div class="vFrontHeaderBtn" id="vFrontBtnElements" title="Elemente"></div>
  <?php } ?>
  <?php if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) { ?>
    <?php //if (checkIndividualUserRechtChange()) { ?>
    <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) { ?>
    <div id="vFrontSiteEditButton" title="Seiteneigenschaften" data-site="<?php echo $cms['cms_siteID']; ?>"></div>
    <?php } ?>
    
    <?php if (isset($_SESSION['VCMS_ELEM_COPY_ID']) && !empty($_SESSION['VCMS_ELEM_COPY_ID'])) { ?>
      <div class="vFrontDragElem vFrontDragElemCopy" id="vCMSElem-0" data-id="<?php echo $_SESSION['VCMS_ELEM_COPY_ID']; ?>">
        kopiertes Element
        <div class="vFrontDragElemCopyCloseBtnMM" title="Entfernen"></div>
      </div>
    <?php } ?>
  <?php } ?>
  
  <a href="Logout"><div class="vFrontHeaderBtn" id="vFrontBtnLogout" title="Logout"></div></a>
  <div class="vFrontHeaderBtn" id="vFrontBtnCmsInfos" title="CMS Info"></div>
  <div class="vFrontHeaderBtn" id="vFrontBtnLanguage" title="Sprache"><div id="vFrontLangInfoAusgabe"></div></div>
  <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 1) { ?>
  <div class="vFrontHeaderBtn" id="vFrontBtnHpSetting" title="Homepage Einstellungen"></div>
  <?php } ?>
  <div class="vFrontHeaderBtn" id="vFrontBtnSeiten" title="CMS Seiten"></div>
  <div class="vFrontHeaderBtn" id="vFrontBtnImages" title="Bilder"></div>
  <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) { ?>
  <div class="vFrontHeaderBtn" id="vFrontBtnDateiVerwaltung" title="Dateien"></div>
  <?php } ?>
  <?php if (!isset($_POST['VCMS_POST_LANG']) || empty($_POST['VCMS_POST_LANG'])) { ?>
    <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) { ?>
      <?php if (isset($hpCms['hp_ModulShopAktiv']) && $hpCms['hp_ModulShopAktiv'] == 1) { ?>
      <div class="vFrontHeaderBtn" id="vFrontShopProductsButton" title="Shop Produkte"></div>
      <?php } ?>
    <?php } ?>
  <?php } ?>
  
       <?php  if ($cmsObj->checkIsThisModuleActive('OrderSystemModul')) { ?>
    <div class="vFrontHeaderBtn" id="vFrontOrderManagerAdminButton" title="Order menager Admin"></div>
  <?php } ?>
      
  <?php if ($cmsObj->checkIsThisModuleActive('empfehlungManagerModul')) { ?>
    <div class="vFrontHeaderBtn" id="vFrontEmpfehlungsManagerAdminButton" title="Empfehlungsmanager Admin"></div>
  <?php } ?>
    
  <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 1) { ?>
    <?php if ($cmsObj->checkIsThisModuleActive('kontaktFormularBuilderModul')) { ?>
      <div class="vFrontHeaderBtn" id="vFrontKontaktFormularBuilderAdminButton" title="Kontaktformular Builder Admin"></div>
    <?php } ?>
  <?php } ?>
      
  <?php if ($cmsObj->checkIsThisModuleActive('filterSystemModul')) { ?>
    <div class="vFrontHeaderBtn" id="vFrontFilterSystemAdminButton" title="Filtersystem Admin"></div>
  <?php } ?>
  
  <?php
  if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
    $langNDbObj = new funktionsSammlung();
    
    $sqlTextLangN = 'SELECT langName FROM vsprachen WHERE langKurzName = "' . $langNDbObj->dbDecode($_POST['VCMS_POST_LANG']) . '" LIMIT 1';
    $sqlErgLangN = $langNDbObj->dbAbfragen($sqlTextLangN);
    
    while ($rowLN = mysql_fetch_array($sqlErgLangN)) {
        
      echo '<div id="vFrontShowLangInfoUser">' . $rowLN['langName'] . '</div>';
    }
  }
  ?>
  
  <div class="vFrontCmsReloadButtonHead" title="Neu laden"></div>
  
  <div class="clearer"></div>
</div>



<div id="vFrontLangHolder">
  <?php echo $allgemeinObj->getLangAuswahlHeaderMenu(); ?>
</div>



<div id="vFrontWindowLeft">
  <div id="vFrontWindowLeftInhalt">
    <?php echo $allgemeinObj->getSiteDragElements(); ?>
    <div style="height:20px;"></div>
  </div>
</div>



<div id="vFrontWindowRight">
  <?php
  $curNewSiteClassCss = '';
  $curChangeNartClassCss = '';
  if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
    $curNewSiteClassCss = ' style="visibility:hidden"';
  }
  if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) {
    $curNewSiteClassCss = ' style="visibility:hidden"';
    //$curChangeNartClassCss = ' style="visibility:hidden"';
  }
  ?>
  <div id="vFrontNewSiteButton"<?php echo $curNewSiteClassCss; ?>>Neue Seite</div>
  <div id="vFrontNaviArtSiteChange"<?php echo $curChangeNartClassCss; ?>>
    <select id="vFrontNaviArtSiteChangeSelect" name="vFrontNaviArtSiteChangeSelect">
      <?php echo $allgemeinObj->getNaviArtOptions(); ?>
    </select>
  </div>
  <div class="vFrontWindowRightInhalt"></div>
</div>



<div id="vFrontCenterWindowSmall">
  <div id="vFrontCenterWindowSmallHead">
    <div id="vFrontCenterWindowSmallHeadInhalt"></div>
    <div id="vFrontCenterWindowSmallClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallInhalt"></div>
</div>



<div id="vFrontCenterWindowBig">
  <div id="vFrontCenterWindowBigHead">
    <div id="vFrontCenterWindowBigHeadInhalt"></div>
    <div id="vFrontCenterWindowBigClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowBigInhalt"></div>
</div>



<div id="vFrontCenterWindowBigImageVerwaltung">
  <div id="vFrontCenterWindowBigImageVerwaltungOnLoadOverlay"></div>
  <div id="vFrontCenterWindowBigImageVerwaltungOnLoadStateShow">
    <div id="vFrontCenterWindowBigImageVerwaltungOnLoadStateShowProzent"></div>
  </div>
  <div id="vFrontCenterWindowBigImageVerwaltungHead">
    <div id="vFrontCenterWindowBigImageVerwaltungHeadInhalt"></div>
    <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) { ?>
    <div id="vFrontCenterWindowBigNewKatBtn" title="Neue Kategorie">&nbsp;</div>
   <!-- <div id="vFrontCenterWindowBigFilesTransportBtn">Bilder verschieben..</div>-->
    <div id="vFrontCenterWindowBigFilesDelMoreBtn">Bilder löschen</div>
    <?php } ?>
    <?php //<div id="vFrontCenterWindowBigFileUploadBtn" class="stateNo">Bilder Upload</div> ?>
    <div id="vFrontCenterWindowBigImageVerwaltungClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowBigImageVerwaltungInhalt"></div>
  <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] == 3) { ?>
  <div id="vFrontImageUploaderWindowInhalt" class="vFrontImageUploaderWindowInhaltOnIndividualUserMM">
  <?php } else { ?>
  <div id="vFrontImageUploaderWindowInhalt">
  <?php } ?>
     <div id="vFrontimageData " class="uploadTypeButtons active" data-type="images" style="float: left" data-uri="admin/inc/ajaxUpload/upload.php">Bilder</div>
   <div id="vFrontfilesData" class="uploadTypeButtons" style="float: left" data-type="files"  data-uri="admin/inc/ajaxUpload/upload_datei.php">Dateien</div> 
    <div style="clear: both;margin-bottom: 10px;"></div>
  
    <form id="vFrontUploadFrm" method="post" action="admin/inc/ajaxUpload/upload.php" enctype="multipart/form-data" data-type="images">
    <input type="hidden" name="typeFile" id="typeFile" value="" />
      <div id="vFrontUploadDrop">
        Drop Here..
        <div style="height:4px;"></div>
        <a>auswählen</a>
        <input type="file" name="upl" multiple />
      </div>
      <ul style="display:none;"><?php // Files vom Upload werden hier angezeigt ?></ul>
    </form>
    

    <!-- SORT -->
    <div class="tabButton sort" >Bilder sortieren</div>
    <div class="sort-image-container sort"  >
	 
	<div class="radio-options" style="width: 26%;">
	
	 <h3>Bilder sortieren Einstellungen:</h3>
     <p><input type="radio" value="1" name="setImages"  class="slectButton"> Alle Bilder auswählen</p>
	
    <p><input type="radio" value="2" name="setImages" class="slectButton"> Markierte Bilder auswählen</p>
   
	</div>
	
	<div class="send-options">
	<h3>Weitere Einstellungen:</h3>
	<div style="margin-top: 12px;">
	 <p><label>Speichern in:</label> <select name="category" class="categoryList"><option>1</option> </select></p>

	 </div>
	 
	</div>
	
		<div class="other-options">
	<h3>&nbsp;</h3>
	<div style="margin-top: -6px;">
	 
	 <p><label>Neue hinzufügen:</label> <input type="text" value="" name="new_category" placeholder="Neuer Kategorie Name" ></p>
	 
	 <p><label>In Kategorie:</label> <select name="category2" class="categoryList"><option>1</option> </select></p>
     
	 </div>
	 
	</div>
	
	<div style="clear: both;"></div>
     
	 
	 <div><input type="submit" id="saveTransportCategory" value="Speichern"></div>
     
     </div>
	 
     <!-- SEND -->
<?php  if ($cmsObj->checkIsThisModuleActive('OrderSystemModul')) { ?>	 
   <div class="tabButton send" >Bilder senden</div>  
  <div class="sort-image-container send"  style="display: none;" >
  	 
  
	 
	 <div class="radio-options">
	
	<h3>Senden Einstellungen:</h3>
    <p><input type="radio" value="1" name="setImages" class="slectButton"> Alle Bilder senden</p>
       <p><input type="radio" value="2" name="setImages" class="slectButton"> Markierte Bilder senden</p>
   
	</div>
	 
	<div class="other-options">
	 
	 <h3>Senden an:</h3>
	 <div style="margin-top:-6px;">
	 <p><label>Bestehende Bestellung:</label><select name="orders" class="orderList"><option>1</option> </select></p>
	 
	 <p><label>Neue Bestellung:</label><input type="text" value="" name="newOrder" placeholder="Name der neuen Bestellung
" ></p>
	 
	
     
	 </div>
	 
	</div> 
	
	<div style="clear: both;"></div>
	
  	 <div><input type="submit" id="saveFileToOrder" value="Speichern"></div>
     
  </div> 
<?php } ?>
  <!-- EDIT -->
  
  <?php if($_SESSION['VCMS_USER_RECHT'] == 1){ ?>
  
 <div class="tabButton edit" >Bilder bearbeiten</div>
    <div class="sort-image-container edit"  style="display: none;" >
	
	
	<div class="radio-options">
	
	<h3>Bilder zuschneiden Einstellungen:</h3>
    <p><input type="radio" value="1" name="setCrop"  class="" checked=""> Alle Bilder auf gleiche px Größe zuschneiden</p> 
	
    <p><input type="radio" value="2" name="setCrop" class="" > Ausgewählte Bilder einzeln zuschneiden</p> 
   
	</div>
	
	<div class="resize-options">
	
	<h3>Größe anpassen:</h3>
    <p><label>Breite:</label> <input type="numeric" name="width"   /></p> 
	
    <p><label>Höhe:</label> <input type="numeric" name="height"  /></p> 
	
	<p><label>Qualität in %:</label> <input type="numeric" name="quality" class="require" /></p>
   
	</div>
	
	<div class="other-options">
	<h3>Weitere Einstellungen:</h3>
	<div>
	 <p><label>Kategorie hinzufügen:</label> <input type="text" value="" name="new_category1"  class="require" placeholder="Neuer Kategorie Name" ></p>
	 
	 <p><label>In Kategorie:</label> <select name="categoryCrop" class="categoryList"><option>1</option> </select></p>
	 
	 <p><label>Bildergalerie erstellen: </label><input type="checkbox" value="1" name="createGallery"  class=""> <input type="text" value="" name="galleryName" class="" placeholder="Bildergalerie Name" ></p>
      
	 </div>
	 
	</div>
	
	<div style="clear: both;"></div>
     
  
     
	 <div id="saveButton" style="float: left;"><span id="buttonLabel">Markiere Bilder und drücke dann</span> <input type="submit" id="saveCropImage" value="save">   </div>
   <div id="showButton"><span id="buttonLabel">Markiere Bilder und drücke dann</span> <input type="submit" id="showCropImageWindow" value="Start zuschneiden"> </div>
	<div style="clear:both;"></div>
   
     </div>
  <?php } ?>
  </div>
</div>




<div id="vFrontCenterWindowBigDateiVerwaltung">
  <div id="vFrontCenterWindowBigDateiVerwaltungOnLoadOverlay"></div>
  <div id="vFrontCenterWindowBigDateiVerwaltungOnLoadStateShow">
    <div id="vFrontCenterWindowBigDateiVerwaltungOnLoadStateShowProzent"></div>
  </div>
  <div id="vFrontCenterWindowBigDateiVerwaltungHead">
    <div id="vFrontCenterWindowBigDateiVerwaltungHeadInhalt"></div>
    <?php if (isset($_SESSION['VCMS_USER_RECHT']) && $_SESSION['VCMS_USER_RECHT'] != 3) { ?>
    <div id="vFrontCenterWindowBigDateiNewKatBtn" title="Neue Kategorie">&nbsp;</div>
    <div id="vFrontCenterWindowBigDateiVerwaltFilesTransportBtn">Dateien verschieben</div>
    <div id="vFrontCenterWindowBigDateiVerwaltFilesDelMoreBtn">Dateien löschen</div>
    <?php } ?>
    <?php //<div id="vFrontCenterWindowBigDateiVerwaltFileUploadBtn" class="stateNo">Datei Upload</div> ?>
    <div id="vFrontCenterWindowBigDateiVerwaltungClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowBigDateiVerwaltungInhalt"></div>
  <div id="vFrontDateiVerwaltUploaderWindowInhalt">
    <form id="vFrontDateiVerwaltUploadFrm" method="post" action="admin/inc/ajaxUpload/upload_datei.php" enctype="multipart/form-data">
      <div id="vFrontDateiVerwaltUploadDrop">
        Drop Here
        <div style="height:4px;"></div>
        <a>auswählen</a>
        <input type="file" name="upl" multiple />
      </div>
      <ul style="display:none;"><?php // Files vom Upload werden hier angezeigt ?></ul>
    </form>
  </div>
</div>



<div id="vFrontCenterWindowSmallSettingsImgVerwalt">
  <div id="vFrontCenterWindowSmallSettingsImgVerwaltHead">
    <div id="vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt">Neue Kategorie</div>
    <div id="vFrontCenterWindowSmallSettingsImgVerwaltClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallSettingsImgVerwaltInhalt"></div>
</div>



<div id="vFrontCenterWindowImageAuswahl">
  <div id="vFrontCenterWindowImageAuswahlHead">
    <div id="vFrontCenterWindowImageAuswahlHeadInhalt">Bilder auswählen</div>
    <div id="vFrontCenterWindowImageAuswahlClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowImageAuswahlInhalt"></div>
</div>



<div id="vFrontCenterWindowSmallSettings">
  <div id="vFrontCenterWindowSmallSettingsHead">
    <div id="vFrontCenterWindowSmallSettingsHeadInhalt">Einstellungen</div>
    <div id="vFrontCenterWindowSmallSettingsClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallSettingsInhalt"></div>
</div>



<div id="vFrontCenterWindowSmallInfoCMS">
  <div id="vFrontCenterWindowSmallInfoCMSHead">
    <div id="vFrontCenterWindowSmallInfoCMSHeadInhalt">CMS Infos</div>
    <div id="vFrontCenterWindowSmallInfoCMSClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallInfoCMSInhalt"></div>
</div>



<div id="vFrontCenterWindowSmallSettingsHpSe">
  <div id="vFrontCenterWindowSmallSettingsHeadHpSe">
    <div id="vFrontCenterWindowSmallSettingsHeadInhaltHpSe">Einstellungen</div>
    <div id="vFrontCenterWindowSmallSettingsCloseHpSe" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallSettingsInhaltHpSe"></div>
</div>



<div id="vFrontCenterWindowHpProductList">
  <div id="vFrontCenterWindowHpProductListHead">
    <div id="vFrontCenterWindowHpProductListHeadInhalt">Shop Produkte</div>
    <div id="vFrontCenterWindowHpProductListClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowHpProductListInhalt"></div>
</div>



<div id="vFrontCenterWindowHpProductNew">
  <div id="vFrontCenterWindowHpProductNewHead">
    <div id="vFrontCenterWindowHpProductNewHeadInhalt">Neues Produkt erstellen</div>
    <div id="vFrontCenterWindowHpProductNewClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowHpProductNewInhalt"></div>
</div>



<div id="vFrontCenterWindowHpProductListSeitEig">
  <div id="vFrontCenterWindowHpProductListSeitEigHead">
    <div id="vFrontCenterWindowHpProductListSeitEigHeadInhalt">Shop Produkte auswählen</div>
    <div id="vFrontCenterWindowHpProductListSeitEigClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowHpProductListSeitEigInhalt"></div>
</div>



<div id="vFrontCenterWindowAllgemeinCMSWindow">
  <div id="vFrontCenterWindowAllgemeinCMSWindowHead">
    <div id="vFrontCenterWindowAllgemeinCMSWindowHeadInhalt">Auswählen</div>
    <div id="vFrontCenterWindowAllgemeinCMSWindowClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowAllgemeinCMSWindowInhalt"></div>
</div>
  
  
  
<div id="vFrontCenterWindowElementSettingsCaCMSWindow">
  <div id="vFrontCenterWindowElementSettingsCaCMSWindowHead">
    <div id="vFrontCenterWindowElementSettingsCaCMSWindowHeadInhalt">Einstellungen</div>
    <div id="vFrontCenterWindowElementSettingsCaCMSWindowClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowElementSettingsCaCMSWindowInhalt"></div>
</div>
  
  
  
<div id="vFrontCenterWindowSmallSettingsZindexO">
  <div id="vFrontCenterWindowSmallSettingsZindexOHead">
    <div id="vFrontCenterWindowSmallSettingsZindexOHeadInhalt">Einstellungen</div>
    <div id="vFrontCenterWindowSmallSettingsZindexOClose" title="Schließen"></div>
  </div>
  <div id="vFrontCenterWindowSmallSettingsZindexOInhalt"></div>
</div>



<div id="vFrontIsLoadingOverlay"></div>
<div id="vFrontOverlay"></div>
<div id="vFrontOverlaySecond"></div>
<div id="vFrontOverlayThird"></div>
<div id="vFrontOverlayFour"></div>
<div id="vFrontOverlayFive"></div>
<div id="vFrontOverlaySix"></div>
<div id="vFrontErrorWindow"><div id="vFrontErrorWindowInhalt"></div></div>
<div id="vFrontOkWindow"><div id="vFrontOkWindowInhalt"></div></div>




<script type="text/javascript">
var vCMScurUserRechtSession = "<?php echo $_SESSION['VCMS_USER_RECHT']; ?>";
</script>




<?php // jQuery Ajax File Upload *********************************************** ?>
<script src="admin/inc/ajaxUpload/assets/js/jquery.knob.js"></script>
<?php // jQuery File Upload Abhängigkeiten ?>
<script src="admin/inc/ajaxUpload/assets/js/jquery.ui.widget.js"></script>
<script src="admin/inc/ajaxUpload/assets/js/jquery.iframe-transport.js"></script>
<script src="admin/inc/ajaxUpload/assets/js/jquery.fileupload.js"></script>
<?php // eigenes JS File ?>
<script src="admin/inc/ajaxUpload/assets/js/script.js"></script>
<script src="admin/inc/ajaxUpload/assets/js/script_dateien.js"></script>
<?php // jQuery Ajax File Upload *********************************************** ?>


<link rel="stylesheet" href="admin/js/dropdown/dd.css" type="text/css" />
<script type="text/javascript" src="admin/js/dropdown/jquery.dd.js"></script>
<script type="text/javascript" src="admin/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="admin/js/tinymce/tinymce.min.js"></script>

<link rel="stylesheet" href="admin/js/timepicker/jquery.ui.timepicker.css" type="text/css" />
<script type="text/javascript" src="admin/js/timepicker/jquery.ui.timepicker.js"></script>

<script type="text/javascript" src="admin/frontAdmin/js/treesort.js"></script>

<?php
if ($cmsObj->checkIsThisModuleActive('empfehlungManagerModul')) {
  echo '<script type="text/javascript" src="admin/frontAdmin/js/empfehlungsManager.js"></script>';
}
if ($cmsObj->checkIsThisModuleActive('kontaktFormularBuilderModul')) {
  echo '<script type="text/javascript" src="admin/frontAdmin/js/kontaktFormBuilder.js"></script>';
}
if ($cmsObj->checkIsThisModuleActive('filterSystemModul')) {
  echo '<script type="text/javascript" src="admin/frontAdmin/js/filtersystem.js"></script>';
}
?>

<?php  if ($cmsObj->checkIsThisModuleActive('OrderSystemModul')) { ?>
<script type="text/javascript" src="admin/frontAdmin/js/orders.js"></script>
<?php } ?>
<script type="text/javascript" src="admin/frontAdmin/js/shop.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/linking.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/editorLinking.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/hpSettings.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/siteSettings.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/elements.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/cmsInfos.js"></script>
<script   type="text/javascript"  src="admin/frontAdmin/js/bootstrap-treeview.js"></script>
<script   type="text/javascript"  src="admin/frontAdmin/js/tree_category.js"></script>
<script   type="text/javascript"  src="admin/frontAdmin/js/cropper.min.js"></script>

<script type="text/javascript" src="admin/frontAdmin/js/functions.js"></script>
<script type="text/javascript" src="admin/frontAdmin/js/start.js"></script>
