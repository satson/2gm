<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Prüfen ob User angemeldet ist
// *****************************************************************************
require_once('../../../inc/check.inc.php');
if (!checkIsUserLogedIn()) {
  exit();
}


// Benötigte Files einbinden
// *****************************************************************************
require_once('../../../inc/db_connect.inc.php');
require_once('../../../inc/functionsAll.inc.php');

require_once('../../inc/klassen/seiten.inc.php');
require_once('../../inc/klassen/bilder.inc.php');
require_once('../../inc/klassen/dateien.inc.php');
require_once('../../inc/klassen/elemente_self.inc.php');
require_once('../../inc/klassen/elemente.inc.php');
require_once('../../inc/klassen/hp_settings.inc.php');
require_once('../../inc/klassen/site_setting.inc.php');
require_once('../../inc/klassen/linking.inc.php');
require_once('../../inc/klassen/editorLinking.inc.php');
require_once('../../inc/klassen/shop.inc.php');
require_once('../../inc/klassen/element_copy.inc.php');
require_once('../../inc/klassen/site_copy.inc.php');
require_once('../../inc/klassen/cmsInfos.inc.php');
require_once('../../inc/klassen/module.inc.php');
require_once('../../inc/klassen/filtersystem.inc.php');



if (isset($_POST['_art']) && !empty($_POST['_art'])) {

  switch ($_POST['_art']) {
    
    // Gibt die Seitenstruktur im Window zurück
    // *************************************************************************
    case 'getSeitenStrukturWindow':
      $curSiteClassObj = new cmsSeiten();

      echo '<div class="vFrontSeitenBaumHolder">'
            . $curSiteClassObj->getSeitenBaumNow(0, 0, $_POST['_nartID']) . 
           '</div>';

      break;
    
    
    
    // Speichert die Seiten Sortierung
    // *************************************************************************
    case 'saveSortSeitenbaum':
      $curSiteClassObj = new cmsSeiten();
      
      $curSiteClassObj->saveTheSortSeitenbaum($_POST['_sortsID'], $_POST['_curParentID']);
      
      break;
    
    
    
    // Löscht eine Seite
    // *************************************************************************
    case 'delCurSiteNow':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->delCurSiteNow($_POST['_delSiteID']);
      
      break;
    
    
    
    // Gibt die Neue Seiten Forms im Window zurück
    // *************************************************************************
    case 'getNewSiteFields':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->getNewSiteForms();
      
      break;
    
    
    
    // Gibt die Bearbeite Seiten Forms im Window zurück
    // *************************************************************************
    case 'getBearSiteFields':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->getNewSiteForms($_POST['_curBearSiteID']);
      
      break;
    
    
    
    // Gibt die Bearbeite Seiten Forms im Window zurück (Spracheintrag)
    // *************************************************************************
    case 'getBearSiteFieldsOnLang':
      $curSiteClassObj = new cmsSeiten();
      
      if (isset($_POST['VCMS_POST_LANG']) && !empty($_POST['VCMS_POST_LANG'])) {
        echo $curSiteClassObj->getBearSiteFormsOnLang($_POST['VCMS_POST_LANG'], $_POST['_curBearSiteID']);
      }
      
      break;
    
    
    
    // Speichert eine neue Seite
    // *************************************************************************
    case 'saveNewSiteNow':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->saveNewSiteNow();
      
      break;
    
    
    
    // Speichert eine Bearbeitete Seite
    // *************************************************************************
    case 'saveBearbeitSiteNow':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->saveBearbeitSiteNow();
      
      break;
    
    
    
    // Speichert eine Bearbeitete Seite (Spracheintrag)
    // *************************************************************************
    case 'saveBearbeitSiteNowOnLang':
      $curSiteClassObj = new cmsSeiten();
      
      echo $curSiteClassObj->saveBearbeitSiteNowOnLang();
      
      break;
    
    
    
    // Kopiert eine Seite
    // *************************************************************************
    case 'copyThisSiteInSiteBaumNow':
      $curSiteCopyClassObj = new cmsSiteCopy();
      
      echo $curSiteCopyClassObj->copyThisSiteInSiteBaumNow($_POST['_curSiteCopyID']);
      
      break;
    
    
    
    
    // *************************************************************************
    // Media Verwaltung
    // *************************************************************************
    
    // Zeigt die Bilderverwaltung an
    // *************************************************************************
    case 'showBilderVerwaltung':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->getThePictureVerwaltung();
      
      break;
    
    
    
    // Zeigt die Bilder in der Verwaltung an (nur Bilder ohne Kategorien)
    // *************************************************************************
    case 'showBilderVerwaltungOnlyPicLoad':
      $curBilderClassObj = new cmsBilder();
      
      //echo $curBilderClassObj->getImageElements();
      echo $curBilderClassObj->showCurentPicKatImagesNow($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_PIC']);
      
      break;
    
    
    
    // Löscht ein einzelnes Bild
    // *************************************************************************
    case 'delCurentBildOnce':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->delThisPicNow($_POST['_bildID']);
      
      break;
    
    
    
    // Löscht mehrere Bilder auf einmal
    // *************************************************************************
    case 'delMediaAllSelectedImagesNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->delMediaAllSelectedImagesNow($_POST['_picElems']);
      
      break;
    
    
    
    // Zeigt das Bearbeiten Window von einem Bild an
    // *************************************************************************
    case 'showMediaPicOnceChangeWindow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->showMediaPicOnceChangeWindow($_POST['_curPicId']);
      
      break;
    
    
    
    // Speichert ein bearbeites Bild
    // *************************************************************************
    case 'saveMediaPicOnceChangeFileNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->saveMediaPicOnceChangeFileNow($_POST['_curPicId'], $_POST['_curFileName'], $_POST['_curFileAlt'], $_POST['_curFileTitle']);
      
      break;
    
    
    
    // Zeigt das Neue Kategorien Window an
    // *************************************************************************
    case 'showBildVerwaltungNewKategorieWindow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->showBildVerwaltungNewKategorieWindow();
      
      break;
    
    
    
    // Zeigt das Bearbeiten Kategorie Window an
    // *************************************************************************
    case 'showBildVerwaltungBerabeitenKategorieWindow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->showBildVerwaltungBerabeitenKategorieWindow($_POST['_curKatId']);
      
      break;
    
    
    
    // Zeigt die Bilder bei Kategorie Wechsel an
    // *************************************************************************
    case 'showCurentPicKatImagesNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->showCurentPicKatImagesNow($_POST['_curPicKatId']);
      
      break;
    
    
    
    // Speichert eine neue Bilder Kategorie
    // *************************************************************************
    case 'saveBildVerwaltungNewKatNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->saveBildVerwaltungNewKatNow($_POST['_curKatName'], $_POST['_curKatParent']);
      
      break;
    
    
    
    // Speichert eine bearbeitet Bilder Kategorie
    // *************************************************************************
    case 'saveBildVerwaltungBearbeiteteKatNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->saveBildVerwaltungBearbeiteteKatNow($_POST['_curKatId'], $_POST['_curKatName'], $_POST['_curKatParent']);
      
      break;
    
    
    
    // Ladet nur die Bilder Kategorien neu
    // *************************************************************************
    case 'reloadOnlyBildverwaltungKatNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->reloadOnlyBildverwaltungKatNow();
      
      break;
    
    
    
    // Löscht eine Kategorie
    // *************************************************************************
    case 'delThisPicVerwaltungKategorie':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->delThisPicVerwaltungKategorie($_POST['_curKatId']);
      
      break;
    
    
    
    // Zeigt die Forms fürs Kategorie verschieben an
    // *************************************************************************
    case 'showBildVerwaltungFilesTransportWindow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->showBildVerwaltungFilesTransportWindow();
      
      break;
    
    
    
    // Verschiebt die Bilder in eine neue Kategorie
    // *************************************************************************
    case 'saveNewKatTransportPicsNow':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->saveNewKatTransportPicsNow($_POST['_curKatId'], $_POST['_picElems']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Datei Verwaltung
    // *************************************************************************
    
    // Zeigt die Dateiverwaltung an
    // *************************************************************************
    case 'showDateiVerwaltungNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->getTheDateiVerwaltung();
      
      break;
    
    
    
    // Zeigt die Dateien in der Verwaltung an (nur Dateien ohne Kategorien)
    // *************************************************************************
    case 'showDateiVerwaltungOnlyDateiLoad':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      //echo $curBilderClassObj->getImageElements();
      echo $curDateienClassObj->showCurentDateiKatDateienNow($_SESSION['VCMS_CUR_UPLOAD_KATEGORIE_DATEI']);
      
      break;
    
    
    
    // Löscht eine einzelne Datei
    // *************************************************************************
    case 'delCurentDateiOnce':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->delThisDateiNow($_POST['_dateiID']);
      
      break;
    
    
    
    // Zeigt das Bearbeiten Window von einer Datei an
    // *************************************************************************
    case 'showMediaDateiOnceChangeWindow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->showMediaDateiOnceChangeWindow($_POST['_curDateiId']);
      
      break;
    
    
    
    // Speichert eine bearbeite Datei
    // *************************************************************************
    case 'saveMediaDateiOnceChangeFileNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->saveMediaDateiOnceChangeFileNow($_POST['_curDateiId'], $_POST['_curFileName']);
      
      break;
    
    
    
    // Löscht mehrere Dateien auf einmal
    // *************************************************************************
    case 'delMediaAllSelectedDateienNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->delMediaAllSelectedDateienNow($_POST['_picElems']);
      
      break;
    
    
    
    // Zeigt die Forms fürs Kategorie verschieben an
    // *************************************************************************
    case 'showDateiVerwaltungFilesTransportWindow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->showDateiVerwaltungFilesTransportWindow();
      
      break;
    
    
    
    // Verschiebt die Bilder in eine neue Kategorie
    // *************************************************************************
    case 'saveNewKatTransportDatasNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->saveNewKatTransportDatasNow($_POST['_curKatId'], $_POST['_dateiElems']);
      
      break;
    
    
    
    // Zeigt die Dateien bei Kategorie Wechsel an
    // *************************************************************************
    case 'showCurentDateiKatDateienNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->showCurentDateiKatDateienNow($_POST['_curPicKatId']);
      
      break;
    
    
    
    // Zeigt das Neue Datei Kategorien Window an
    // *************************************************************************
    case 'showDateiVerwaltungNewKategorieWindow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->showDateiVerwaltungNewKategorieWindow();
      
      break;
    
    
    
    // Ladet nur die Datei Kategorien neu
    // *************************************************************************
    case 'reloadOnlyDateiverwaltungKatNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->reloadOnlyDateiverwaltungKatNow();
      
      break;
    
    
    
    // Speichert eine neue Datei Kategorie
    // *************************************************************************
    case 'saveDateiVerwaltungNewKatNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->saveDateiVerwaltungNewKatNow($_POST['_curKatName'], $_POST['_curKatParent']);
      
      break;
    
    
    
    // Löscht eine Dateiverwaltungs Kategorie
    // *************************************************************************
    case 'delThisDateiVerwaltungKategorie':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->delThisDateiVerwaltungKategorie($_POST['_curKatId']);
      
      break;
    
    
    
    // Zeigt das Bearbeiten Kategorie Window an
    // *************************************************************************
    case 'showDateiVerwaltungBerabeitenKategorieWindow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->showDateiVerwaltungBerabeitenKategorieWindow($_POST['_curKatId']);
      
      break;
    
    
    
    // Speichert eine bearbeitet Datei Kategorie
    // *************************************************************************
    case 'saveDateiVerwaltungBearbeiteteKatNow':
      $curDateienClassObj = new cmsDateiVerwaltung();
      
      echo $curDateienClassObj->saveDateiVerwaltungBearbeiteteKatNow($_POST['_curKatId'], $_POST['_curKatName'], $_POST['_curKatParent']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // CMS Elemente
    // *************************************************************************
    
    // Fügt ein Element in einem Bereich hinzu
    // *************************************************************************
    case 'setNewDragElemUser':
      $curElemClassObj = new cmsElemente();
      
      echo $curElemClassObj->setNewDragElemAndSave($_POST['_siteDropName'], $_POST['_siteID'], $_POST['_elemID'], $_POST['_elemPosition'], $_POST['_elemPosInherit']);
      
      break;
    
    
    
    // Fügt ein Element in einem Spalten Bereich hinzu
    // *************************************************************************
    case 'setNewDragElemSpaltenUser':
      $curElemClassObj = new cmsElemente();
      
      echo $curElemClassObj->setNewDragSpaltenElemAndSave($_POST['_siteDropName'], $_POST['_siteID'], $_POST['_elemID'], $_POST['_elemPosition'], $_POST['_elemPosInherit'], $_POST['_selemCurID'], $_POST['_selemRowID']);
      
      break;
    
    
    
    // Sortiert die angegebenen Spalten Elemente Neu
    // *************************************************************************
    case 'setNewSortPosSpaltenElements':
      $curElemClassObj = new cmsElemente();

      echo $curElemClassObj->sortTheCurentSpaltenElementsNow($_POST['_sortString'], $_POST['_rowNumber'], $_POST['_curElemId']);
      
      break;
    
    
    
    // Sortiert die angegebenen Elemente Neu
    // *************************************************************************
    case 'sortThisSiteElements':
      $curElemClassObj = new cmsElemente();

      echo $curElemClassObj->sortTheCurentElements($_POST['_elemsToSort']);
      
      break;
    
    
    
    // Elemente im angegebenen Bereich erneut laden
    // *************************************************************************
    case 'loadNewElemPosInhaltOnly':
      $curElemClassObj = new cmsElemente();
      
      echo $curElemClassObj->setElemHolderInhaltReload($_POST['_siteDropName'], $_POST['_siteID'], $_POST['_elHolderInherit']);
      
      break;
    
    
    
    // Löscht ein Element
    // *************************************************************************
    case 'delThisSiteElemNow':
      $curElemClassObj = new cmsElemente();
      
      echo $curElemClassObj->delThisSiteElemNow($_POST['_selemID'], $_POST['_siteDropName'], $_POST['_siteID'], $_POST['_elemPosInherit']);
      
      break;
    
    
    
    // Speicher den Text im Text Element
    // *************************************************************************
    case 'saveTextInTextElement':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveTextInTextElement($_POST['_elemID'], $_POST['_elemInhalt']);
      
      break;
    
    
    
    // Speicher ein Bild im Bild Element
    // *************************************************************************
    case 'saveNewBildInElement':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveNewBildInElement($_POST['_elemID'], $_POST['_bildID']);
      
      break;
    
    
    
    // Speicher die Bild Breite im Bild Element
    // *************************************************************************
    case 'saveBildElemResizeNow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveBildElemResizeNow($_POST['_selemID'], $_POST['_selemWidth']);
      
      break;
    
    
    
    // Zeigt die Spalten Settings an
    // *************************************************************************
    case 'showSpaltenSettingAuswahl':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showSpaltenSettingsNow($_POST['_curSelemID']);
      
      break;
    
    
    
    // Speichert die Spalten Settings
    // *************************************************************************
    case 'saveSpaltenSettingsNow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      $curElemSelfClassObj->saveSpaltenSettingsNow($_POST['_curSelemID'], $_POST['_curSpalten']);
      echo $curElemSelfClassObj->setElemHolderInhaltLoad($_POST['_curPosDropName'], $_POST['_curPosSiteID'], $_POST['_curPosInherit'], true);
      
      break;
    
    
    
    // Löscht das kopierte Element (Session Del)
    // *************************************************************************
    case 'delTheDragElementCopyElementNowMM':
      
      unset($_SESSION['VCMS_ELEM_COPY_ID']);
      echo true;
      
      break;
    
    
    
    
    // *************************************************************************
    // CMS Alias (Verknüpfungs) Elemente
    // *************************************************************************
    case 'showNewWindowAliasElementSet':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showNewWindowAliasElementSet($_POST['_curSelemID']);
      
      break;
    
    
    
    case 'saveNewElementSetOnAliasElement':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveNewElementSetOnAliasElement($_POST['_curSelemID'], $_POST['_setElementID']);
      
      break;
    
    
    
    case 'showAliasWindowElementAuswahl':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showAliasWindowElementAuswahl();
      
      break;
    
    
    
    case 'showElemAliasMoreInfoWindow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showElemAliasMoreInfoWindow($_POST['_curSelemID']);
      
      break;
    
    
    
    case 'saveNewBildOnceInAliasElementMM':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveNewBildOnceInAliasElementMM($_POST['_selemID'], $_POST['_picID']);
      
      break;
    
    
    
    case 'delTheBildOnceInAliasElementMM':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->delTheBildOnceInAliasElementMM($_POST['_selemID']);
      
      break;
    
    
    
    
    // *************************************************************************
    // CMS Kontaktformular Elemente
    // *************************************************************************
    
    case 'showNewWindowKontaktFormElementSet':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showNewWindowKontaktFormElementSet($_POST['_curSeitElemId']);
      
      break;
    
    
    
    case 'getNewWindowKontaktFormElementSetElemNow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->getNewWindowKontaktFormElementSetElemNow($_POST['_curSeitElemId'], $_POST['_curKontaktId']);
      
      break;
    
    
    
    
    
    // *************************************************************************
    // CMS eigene Elemente
    // *************************************************************************
    
    // Speichert den Text im eigenem Element
    // *************************************************************************
    case 'saveElemOwnElemTextNow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveElemOwnElemTextNow($_POST['_elemID'], $_POST['_elemNum'], $_POST['_elemInhalt']);
      
      break;
    
    
    
    // Speichert ein Bild im eigenem Element
    // *************************************************************************
    case 'saveNewBildInOwnElement':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveElemOwnElemBildNow($_POST['_elemID'], $_POST['_elemNum'], $_POST['_bildID']);
      
      break;
    
    
    
    // Löscht ein Bild im eigenem Element
    // *************************************************************************
    case 'delImageOnOwnElemPic':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->delImageOnOwnElemPic($_POST['_selemID'], $_POST['_selemNum']);
      
      break;
    
    
    
    // Zeigt die Bilder Galerie zuweisung an (Window)
    // *************************************************************************
    case 'showEigenElemPicGalImagesWindowAuswahl':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showEigenElemPicGalImagesWindowAuswahl($_POST['_curSelemID']);
      
      break;
    
    
    
    // Speichert die Bilder Galerie zuweisung
    // *************************************************************************
    case 'vSaveOwnElemPicGalChange':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->vSaveOwnElemPicGalChange($_POST['_selemID'], $_POST['_picGalImages'], $_POST['_picGalElemID']);
      
      break;
    
    
    
    // Zeigt die Bilder Galerie Elemente zuweisung an (Window)
    // *************************************************************************
    case 'showWindowBilderGalerieElemsAuswahl':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showWindowBilderGalerieElemsAuswahl();
      
      break;
    
    
    
    
    
    
    
    
    // *************************************************************************
    // Homepage Einstellungen
    // *************************************************************************
    
    // Zeigt die Homepage Einstellungen im Window an
    // *************************************************************************
    case 'showHomepageEinstellungen':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->getHpSettingsNow();
      
      break;
    
    
    
    // Zeigt die richtigen Einstellungen im Window an
    // *************************************************************************
    case 'showCurHpSeInhaltNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->getHpSettingInhalt($_POST['_curIdName']);
      
      break;
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - Allgemein
    // *************************************************************************
    
    // Speichert die Allgemeinen Einstellungen
    // *************************************************************************
    case 'saveHpSeAllgemeinNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeAllgemeinNow($_POST['_curHpId'], $_POST['_curHpName'], $_POST['_curHpTemplate'], $_POST['_hpOffline'], $_POST['_hpHeaderCode']);
      
      break;
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - Elemente
    // *************************************************************************
    
    // Löscht ein Element in den Homepage Einstellungen
    // *************************************************************************
    case 'delHpSeThisCurentElement':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeThisCurentElement($_POST['_curDelElemId']);
      
      break;
    
    
    
    // Zeigt für ein neues Element die Felder an
    // *************************************************************************
    case 'showHpSeNewElementForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeNewElementForms();
      
      break;
    
    
    
    // Zeigt für ein Element die Felder zum Bearbeiten an
    // *************************************************************************
    case 'showHpSeChangeElementForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeChangeElementForms($_POST['_curSelemId']);
      
      break;
    
    
    
    // Speichert ein neues Element
    // *************************************************************************
    case 'saveHpSeElementsNewElement':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeElementsNewElement($_POST['_elemName'], $_POST['_elemFile'], $_POST['_elemHidden']);
      
      break;
    
    
    
    // Speichert ein neues Zentrales Element (Installation)
    // *************************************************************************
    case 'saveHpSeElementsNewElementCentral':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeElementsNewElementCentral($_POST['_elemName'], $_POST['_elemFile'], $_POST['_elemHidden'], $_POST['_elemCentralFolder']);
      
      break;
    
    
    
    // Speichert ein bearbeitetes Element (System)
    // *************************************************************************
    case 'saveHpSeElementsChangeElementSys':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeElementsChangeElementSys($_POST['_elemId'], $_POST['_elemHidden']);
      
      break;
    
    // Speichert ein bearbeitetes Element (Eigen)
    // *************************************************************************
    case 'saveHpSeElementsChangeElementOwn':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeElementsChangeElementOwn($_POST['_elemId'], $_POST['_elemName'], $_POST['_elemFile'], $_POST['_elemHidden']);
      
      break;
    
    
    
    // Setzt die eigenen Elemente Sortierung neu
    // *************************************************************************
    case 'setSortOwnElementsNewNowMM':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->setSortOwnElementsNewNowMM($_POST['_allOwnElemsList']);
      
      break;
    
    
    
    // Zeigt das Element Eigenen Einstellungen Window an
    // *************************************************************************
    case 'showHpSeElementsOwnSettingChangeElementWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeElementsOwnSettingChangeElementWindow($_POST['_curElemId']);
      
      break;
    
    
    
    // Speichert den Element Eigenen Einstellungen String
    // *************************************************************************
    case 'saveHpSeElementsOwnSettingChangeElementString':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeElementsOwnSettingChangeElementString($_POST['_curElemId'], $_POST['_curElemString']);
      
      break;
    
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - Seitenlayouts
    // *************************************************************************
    
    // Zeigt die Forms für ein neues Seitenlayout an
    // *************************************************************************
    case 'showHpSeNewSeitenlayoutsFormsWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeNewSeitenlayoutsFormsWindow();
      
      break;
    
    
    
    // Speichert ein neues Seitenlayout
    // *************************************************************************
    case 'saveHpSeNewSeitenlayout':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeNewSeitenlayout($_POST['_layName'], $_POST['_layFile']);
      
      break;
    
    
    
    // Löscht ein Seitenlayout
    // *************************************************************************
    case 'delHpSeThisSeitenlayout':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeThisSeitenlayout($_POST['_layID']);
      
      break;
    
    
    
    // Zeigt die Forms für ein bearbeitetes Seitenlayout an
    // *************************************************************************
    case 'showHpSeBearSeitenlayoutsFormsWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeBearSeitenlayoutsFormsWindow($_POST['_layID']);
      
      break;
    
    
    
    // Speichert ein bearbeitetes Seitenlayout
    // *************************************************************************
    case 'saveHpSeBearSeitenlayout':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeBearSeitenlayout($_POST['_layID'], $_POST['_layName'], $_POST['_layFile']);
      
      break;
    
    
    
    // Zeigt das Neue Seitenlayout Feld auswahl Window an
    // *************************************************************************
    case 'showHpSeSeitenlayoutsNewFeldWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeSeitenlayoutsNewFeldWindow($_POST['_curLayId']);
      
      break;
    
    
    
    // Zeigt die Neuen Seitenlayout Feld Forms im Window an
    // *************************************************************************
    case 'showHpSeSeitenlayoutsNewFeldWindowCurForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeSeitenlayoutsNewFeldWindowCurForms($_POST['_curLayId'], $_POST['_curFeldArt']);
      
      break;
    
    
    
    // Zeigt das Bearbeitente Seitenlayout Feld Forms im Window an
    // *************************************************************************
    case 'showHpSeSeitenlayoutsBearFeldWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeSeitenlayoutsBearFeldWindow($_POST['_curLayId'], $_POST['_curFieldID']);
      
      break;
    
    
    
    // Speichert ein Neues Seitenlayout Feld
    // *************************************************************************
    case 'saveHpSeSeitenlayoutsNewFeldWindowNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeSeitenlayoutsNewFeldWindowNow($_POST['_curLayId'], $_POST['_curFeldArt']);
      
      break;
    
    
    
    // Speichert ein Bearbeitetes Seitenlayout Feld
    // *************************************************************************
    case 'saveHpSeSeitenlayoutsBearFeldWindowNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeSeitenlayoutsBearFeldWindowNow($_POST['_curFeldId'], $_POST['_curFeldArt'], $_POST['_curLayId']);
      
      break;
    
    
    
    // Ladet nur die Seitenlayout Felder Neu
    // *************************************************************************
    case 'buildHpSeSeitenlayoutsFeldListNew':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->buildSeitenlayoutFelderList($_POST['_curLayId']);
      
      break;
    
    
    
    // Sortiert die Seitenlayout Felder Neu
    // *************************************************************************
    case 'setSortSeitenlayoutsFieldsNew':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->setSortSeitenlayoutsFieldsNew($_POST['_curLayId'], $_POST['_allElemsList']);
      
      break;
    
    
    
    // Löscht ein Seitenlayout Feld
    // *************************************************************************
    case 'delHpSeSeitenlayoutsFieldNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeSeitenlayoutsFieldNow($_POST['_curLayId'], $_POST['_curFieldID']);
      
      break;
    
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - Navigationsarten
    // *************************************************************************
    
    // Zeigt die Forms für eine neue Navigationsart an
    // *************************************************************************
    case 'showHpSeNewNaviArtFormsWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeNewNaviArtFormsWindow();
      
      break;
    
    
    
    // Speichert eine neue Navigationsart
    // *************************************************************************
    case 'saveHpSeNewNaviArt':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeNewNaviArt($_POST['_nartName']);
      
      break;
    
    
    
    // Löscht eine Navigationsart
    // *************************************************************************
    case 'delHpSeThisNaviArt':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeThisNaviArt($_POST['_nartID']);
      
      break;
    
    
    
    // Zeigt die Forms für eine bearbeitete Navigationsart an
    // *************************************************************************
    case 'showHpSeBearNaviArtFormsWindow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeBearNaviArtFormsWindow($_POST['_nartID']);
      
      break;
    
    
    
    // Speichert eine bearbeitet Navigationsart
    // *************************************************************************
    case 'saveHpSeBearNaviArt':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeBearNaviArt($_POST['_nartID'], $_POST['_nartName']);
      
      break;
    
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - User
    // *************************************************************************
    
    // Zeigt die Forms für einen neuen User an
    // *************************************************************************
    case 'showHpSeNewUserForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeNewUserForms();
      
      break;
    
    
    
    // Zeigt die Forms für einen bearbeiteten User an
    // *************************************************************************
    case 'showHpSeBearUserForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeBearUserForms($_POST['_userID']);
      
      break;
    
    
    
    // Speichert einen neuen User
    // *************************************************************************
    case 'saveNewUserDataNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveNewUserDataNow();
      
      break;
    
    
    
    // Speichert einen bearbeiteten User
    // *************************************************************************
    case 'saveBearUserDataNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveBearUserDataNow();
      
      break;
    
    
    
    // Löscht einen User
    // *************************************************************************
    case 'delHpSeThisUserNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeThisUserNow($_POST['_curUserID']);
      
      break;
    
    
    
    // Zeigt die Individual User Seiten Liste an
    // *************************************************************************
    case 'showHpSeUserIndividualSiteList':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeUserIndividualSiteList();
      
      break;
    
    
    
    // Zeigt die Individual User Seiten Liste an (Reload)
    // *************************************************************************
    case 'showHpSeUserIndividualSiteListReload':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeUserIndividualSiteList(0, 0, $_POST['_naviArtID']);
      
      break;
    
    
    
    // Zeigt die Individual User Kategorien Liste an
    // *************************************************************************
    case 'showHpSeUserIndividualKategorieList':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeUserIndividualKategorieList();
      
      break;
    
    
    
    // *************************************************************************
    // Homepage Einstellungen - Sprachen
    // *************************************************************************
    
    // Zeigt für eine neue Sprache die Felder an
    // *************************************************************************
    case 'showHpSeNewLanguageForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeNewSpracheForms();
      
      break;
    
    
    
    // Zeigt für eine Sprache die Felder zum Bearbeiten an
    // *************************************************************************
    case 'showHpSeChangeLanguageForms':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->showHpSeChangeLanguageForms($_POST['_curLangId']);
      
      break;
    
    
    
    // Löscht eine Sprache
    // *************************************************************************
    case 'delHpSeThisLanguage':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->delHpSeThisSpracheNow($_POST['_langID']);
      
      break;
    
    
    
    // Speichert eine neue Sprache
    // *************************************************************************
    case 'saveHpSeNewLanguageNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeNewNewSpracheNow($_POST['_langName'], $_POST['_langUrlName'], $_POST['_langOnline']);
      
      break;
    
    
    
    // Speichert eine bearbeitet Sprache
    // *************************************************************************
    case 'saveHpSeChangeLanguageNow':
      $curHpSettingClassObj = new hpEinstellungen();
      
      echo $curHpSettingClassObj->saveHpSeChangeSpracheNow($_POST['_curLangId'], $_POST['_langName'], $_POST['_langUrlName'], $_POST['_langOnline']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Seiten Eigenschaften
    // *************************************************************************
    
    // Zeigt die Homepage Einstellungen im Window an
    // *************************************************************************
    case 'showSeitenEigenschaften':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->getSiteSettingsNow($_POST['_curSiteIdNow']);
      
      break;
    
    
    
    // Zeigt den Seiteneigenschaften Inhalt an (Reload)
    // *************************************************************************
    case 'showSeitenEigenschaftenInhaltReload':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->getSiteSettingInhalt($_POST['_curSiteIdNow'], $_POST['_curMenuId'], true);
      
      break;
    
    
    
    // Speichert die Seiteneigenschaften Bilder
    // *************************************************************************
    case 'saveSeitEigenschaftenBilder':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->saveSeitenEigenschaftenBilder($_POST['_siteID'], $_POST['_backImages'], $_POST['_listImage'], $_POST['_slideImages']);
      
      break;
    
    
    
    // Speichert die Seiteneigenschaften Produkte
    // *************************************************************************
    case 'saveSeitEigenschaftenProdukte':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->saveSeitenEigenschaftenProdukte($_POST['_siteID'], $_POST['_siteProdukte']);
      
      break;
    
    
    
    // Zeigt die Seiteneigenschaften Produkte auswahl an
    // *************************************************************************
    case 'showProductsListInWindowForSeEig':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->showProductsListInWindowForSeEig();
      
      break;
    
    
    
    // ******* Bilder Galerien *******/
    
    // Zeigt die Seiteneigenschaften Bilder Galerien an
    // *************************************************************************
    case 'showSeiteneigenschaftenBilderGalerienReload':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->showSeiteneigenschaftenBilderGalerienReload($_POST['_curMenuId']);
      
      break;
    
    
    
    // Zeigt die Seiteneigenschaften Neue Bilder Galerie Window
    // *************************************************************************
    case 'showNewPicGalWindowSiSe':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->showNewPicGalWindowSiSe();
      
      break;
    
    
    
    // Speichert eine Neue Bilder Galerie
    // *************************************************************************
    case 'vSavePicGalSiSeNewBtn':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->vSavePicGalSiSeNewBtn($_POST['_picgalName'], $_POST['_picgalImages']);
      
      break;
    
    
    
    // Speichert eine Bearbeitete Bilder Galerie
    // *************************************************************************
    case 'vSavePicGalSiSeChangeBtn':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->vSavePicGalSiSeChangeBtn($_POST['_curPicGalId'], $_POST['_picgalName'], $_POST['_picgalImages']);
      
      break;
    
    
    
    // Zeigt die Seiteneigenschaften Beabeitente Bilder Galerie Window
    // *************************************************************************
    case 'showChangePicGalWindowSiSe':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->showChangePicGalWindowSiSe($_POST['_curPicGalId']);
      
      break;
    
    
    
    // Löscht eine Bilder Galerie
    // *************************************************************************
    case 'delThisSiSePicGalNow':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->delThisSiSePicGalNow($_POST['_curPicGalId']);
      
      break;
    
    
    
    // ******* eigene Felder *******/
    
    // Speichert die eigenen Felder
    // *************************************************************************
    case 'saveSeitEigOwnFelderNowMM':
      $curSiteSettingClassObj = new seitenEigenschaften();
      
      echo $curSiteSettingClassObj->saveSeitEigOwnFelderNowMM($_POST['_curSiteId'], $_POST['_dataArr']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Bilder auswahl
    // *************************************************************************
    
    // Zeigt die Bilder Auswahl im Window an
    // *************************************************************************
    case 'showBildAuswahlInhalt':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->getBilderAuswahlPics();
      
      break;
    
    
    
    // Zeigt die Bilder Auswahl im Window an bei Kategorie wechsel
    // *************************************************************************
    case 'showBildAuswahlInhaltOnReload':
      $curBilderClassObj = new cmsBilder();
      
      echo $curBilderClassObj->getBilderAuswahlPics($_POST['_curKatId'], true);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Link auswahl Window
    // *************************************************************************
    
    // Zeigt das Link Auswahl Window an
    // *************************************************************************
    case 'showCmsLinkWindowNow':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->getCurentLinkingWindowInhalt();
      
      break;
    
    
    
    // Speichert einen Link (Element Normal)
    // *************************************************************************
    case 'saveLinkInElementNow':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->saveLinkInElementNormalNow();
      
      break;
    
    
    
    // Speichert einen Link (Element Normal) - Spracheintrag
    // *************************************************************************
    case 'saveTheNewLinkInElementOnLangMM':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->saveLinkInElementNormalNowOnLangMM();
      
      break;
    
    
    
    // Löscht einen Link (Element Normal)
    // *************************************************************************
    case 'delLinkInElementNow':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->delLinkInElementNormalNow();
      
      break;
    
    
    
    // Löscht einen Link (Element Normal) - Spracheintrag
    // *************************************************************************
    case 'delTheLinkInElementOnLangMM':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->delLinkInElementNormalNowOnLangMM();
      
      break;
    
    
    
    // Zeigt die Linking Seitenauswahl
    // *************************************************************************
    case 'showLinkingSeitenauswahlWin':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingSeitenauswahlWin();
      
      break;
    
    
    
    // Zeigt die Linking Seitenauswahl (Reload)
    // *************************************************************************
    case 'showLinkingSeitenauswahlWinReloadMM':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingSeitenauswahlWin(0, 0, $_POST['_naviArtID']);
      
      break;
    
    
    
    // Zeigt die Linking Bildauswahl
    // *************************************************************************
    case 'showLinkingBildauswahlWin':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingBildauswahlWin();
      
      break;
    
    
    
    // Zeigt die Linking Bildauswahl Reload
    // *************************************************************************
    case 'showLinkingBildauswahlWinReload':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingBildauswahlWinReload($_POST['_curKatId']);
      
      break;
    
    
    
    // Zeigt die Linking Dateiauswahl
    // *************************************************************************
    case 'showLinkingDateiauswahlWin':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingDateiauswahlWin();
      
      break;
    
    
    
    // Zeigt die Linking Dateiauswahl Reload
    // *************************************************************************
    case 'showLinkingDateiauswahlWinReload':
      $curLinkingClassObj = new cmsLinking();
      
      echo $curLinkingClassObj->showLinkingDateiauswahlWinReload($_POST['_curKatId']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Editor Link auswahl Window
    // *************************************************************************
    
    // Zeigt das Editor Link Auswahl Window an
    // *************************************************************************
    case 'showCmsEditorLinkWindowNow':
      $curEditorLinkingClassObj = new cmsEditorLinking();
      
      echo $curEditorLinkingClassObj->getCurentEditorLinkingWindowInhalt($_POST['_curInhaltUri']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // Shop Modul
    // *************************************************************************
    
    // Zeigt die Shop Produkte Verwaltung an
    // *************************************************************************
    case 'showHpProductsListInWindowNow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->showHpProductsListInWindowNow();
      
      break;
    
    
    
    // Zeigt die Neuen Produkt Forms an
    // *************************************************************************
    case 'showNewProductFormsInWindow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->showNewProductFormsInWindow();
      
      break;
    
    
    
    // Zeigt die Bearbeit Produkt Forms an
    // *************************************************************************
    case 'showBearProductFormsInWindow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->showBearProductFormsInWindow($_POST['_curPrId']);
      
      break;
    
    
    
    // Löscht ein Shop Produkt
    // *************************************************************************
    case 'deleteThisShopProductNow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->deleteThisShopProductNow($_POST['_curProductID']);
      
      break;
    
    
    
    // Speichert ein neues Shop Produkt
    // *************************************************************************
    case 'saveNewProductShopNow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->saveNewProductShopNow();
      
      break;
    
    
    
    // Speichert ein Bearbeitetes Shop Produkt
    // *************************************************************************
    case 'saveBearbeitProductShopNow':
      $curShopModulClassObj = new cmsShopModul();
      
      echo $curShopModulClassObj->saveBearbeitProductShopNow($_POST['_curPrId']);
      
      break;
    
    
    
    
    
    
    // *************************************************************************
    // Elemente Kopieren
    // *************************************************************************
    
    // Speichert das kopierte Element
    // *************************************************************************
    case 'saveTheCurentCopyElementNow':
      $curElemetCopyClassObj = new cmsElementeCopy();
      
      echo $curElemetCopyClassObj->saveTheCurentCopyElementNow($_POST['_selemID']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // CMS Infos Window
    // *************************************************************************
    
    // Zeigt die CMS Infos im Window an
    // *************************************************************************
    case 'showCmsInfosWindowNow':
      require_once('../../inc/cms.inc.php');
      
      $curCmsInfosClassObj = new cmsCmsInfos();
      
      echo $curCmsInfosClassObj->showCmsInfosWindowNow();
      
      break;
    
    
    
    // Prüft ob ein neues Update verfügbar ist
    // *************************************************************************
    case 'checkCmsInfoIsNewUpdateVersionNow':
      require_once('../../inc/cms.inc.php');
      
      $curCmsInfosClassObj = new cmsCmsInfos();
      
      echo $curCmsInfosClassObj->checkCmsInfoIsNewUpdateVersionNow();
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // CMS Module - Erweiterungen
    // *************************************************************************
    
    // Installiert eine neue Erweiterung
    // *************************************************************************
    case 'installCurentCmsModuleNow':
      $curCmsModuleClassObj = new cmsModuleExtensions();
      
      echo $curCmsModuleClassObj->installCurentCmsModuleNow($_POST['_curModulName']);
      
      break;
    
    
    
    // Deinstalliert eine Erweiterung
    // *************************************************************************
    case 'deInstallCurentCmsModuleNow':
      $curCmsModuleClassObj = new cmsModuleExtensions();
      
      echo $curCmsModuleClassObj->deInstallCurentCmsModuleNow($_POST['_curModulName']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // CMS Elemente - Einstellungen
    // *************************************************************************
    
    // Zeigt das Einstellungen Window Inhalt an
    // *************************************************************************
    case 'showElemOwnSettingUsersWindow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->showElemOwnSettingUsersWindow($_POST['_curSeitElemId'], $_POST['_isOwnElem']);
      
      break;
    
    
    
    // Speichert die Element Einstellungen
    // *************************************************************************
    case 'saveElemOwnSettingUsersWindowNow':
      $curElemSelfClassObj = new cmsElementeSelf();
      
      echo $curElemSelfClassObj->saveElemOwnSettingUsersWindowNow($_POST['_curSiteElemId'], $_POST['_isElemOwnElem']);
      
      break;
    
    
    
    
    
    
    
    // *************************************************************************
    // CMS Filtersystem Modul
    // *************************************************************************
    
    // Zeigt das Filtersystem Admin Window an
    // *************************************************************************
    case 'showFilterSystemAdminWindow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->showFilterSystemAdminWindow();
      
      break;
    
    
    
    // Zeigt das Filtersystem Neue Kategorie Window an
    // *************************************************************************
    case 'showNewFiltersystemAdminKatgorieWindow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->showNewFiltersystemAdminKatgorieWindow();
      
      break;
    
    
    
    // Speichert eine neue Filtersystem Kategorie
    // *************************************************************************
    case 'saveNewFiltersystemAdminKatgorieWindow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->saveNewFiltersystemAdminKatgorieWindow($_POST['_filterKatName']);
      
      break;
    
    
    
    // Zeigt das Filtersystem Berabeit Kategorie Window an
    // *************************************************************************
    case 'showBearFiltersystemAdminKatgorieWindow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->showBearFiltersystemAdminKatgorieWindow($_POST['_filterKatID']);
      
      break;
    
    
    
    // Speichert eine Berabeitete Filtersystem Kategorie
    // *************************************************************************
    case 'saveBearFiltersystemAdminKatgorieWindow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->saveBearFiltersystemAdminKatgorieWindow($_POST['_filterKatName'], $_POST['_curFilterKatID']);
      
      break;
    
    
    
    // Löscht eine Filtersystem Kategorie
    // *************************************************************************
    case 'delFiltersystemAdminKatgorieNow':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->delFiltersystemAdminKatgorieNow($_POST['_filterKatID']);
      
      break;
    
    
    
    // Zeigt die Filtersystem Kategorien für Listen zuweisung an
    // *************************************************************************
    case 'showFiltersystemAuswahlListBySettingsAuswahlWinMulti':
      $curFiltersystemClassObj = new cmsOwnFiltersystem();
      
      echo $curFiltersystemClassObj->showFiltersystemAuswahlListBySettingsAuswahlWinMulti();
      
      break;

  }

}

?>