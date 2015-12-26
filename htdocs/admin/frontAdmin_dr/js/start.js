/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



$(document).ready(function() {
  
  
  // Front Admin Header Buttons
  // ***************************************************************************
  $('#vFrontBtnLanguage').click(function() {
    showLangChange();
  });
  
  $('#vFrontBtnElements').click(function() {
    if ($('body').attr('data-lang') == '') {
      showLeftWindowElements();
    }
  });
  
  $('#vFrontBtnSeiten').click(function() {
    showRightWindowSiteTree();
  });
  
  $('#vFrontBtnImages').click(function() {
    showImageVerwaltung();
  });
  
  $('#vFrontBtnDateiVerwaltung').click(function() {
    showDateiVerwaltungNow();
  });
  
  $('#vFrontBtnHpSetting').click(function() {
    showHomepageSettings();
  });
  
  $('#vFrontBtnCmsInfos').click(function() {
    showCmsInfosWindowNow();
  });
  
  $('#vFrontEmpfehlungsManagerAdminButton').click(function() {
    showEmpfehlungsmanagerAdminWindow();
  });
  
  $('#vFrontKontaktFormularBuilderAdminButton').click(function() {
    showKontaktFormBuilderAdminWindow();
  });
  
  $('#vFrontFilterSystemAdminButton').click(function() {
    showFilterSystemAdminWindow();
  });
  
  
  $('#vFrontSiteEditButton').click(function() {
    showSeitenEigenschaften($(this).attr('data-site'));
  });
  
  
  $('.vFrontCmsReloadButtonHead').click(function() {
    showCmsIsLoading();
    window.location.reload();
  });
  
  
  
  // Front Admin Lang Info setzen
  // ***************************************************************************
  var langActiveElem = $('#vFrontLangHolder .vFrontLangChangeElemChecked');
  $('#vFrontLangInfoAusgabe').html(langActiveElem.attr('data-kname'));
  
  
  
  // Front Admin Neue Seite Button
  // ***************************************************************************
  $('#vFrontNewSiteButton').click(function() {
    showNewSiteWindow();
  });
  
  
  
  // Front Admin Windows Close Buttons
  // ***************************************************************************
  $('#vFrontCenterWindowSmallClose').click(function() {
    closeCenterWindowSmall();
  });
  
  $('#vFrontCenterWindowBigClose').click(function() {
    closeCenterWindowBig();
  });
  
  $('#vFrontCenterWindowBigImageVerwaltungClose').click(function() {
    closeCenterWindowBigImageVerwaltung();
  });
  
  $('#vFrontCenterWindowBigDateiVerwaltungClose').click(function() {
    closeCenterWindowBigDateiVerwaltung();
  });
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltClose').click(function() {
    closeCenterWindowSmallSettingsImgVerwalt();
  });
  
  $('#vFrontCenterWindowImageAuswahlClose').click(function() {
    closeCenterWindowImageAuswahl();
  });
  
  $('#vFrontCenterWindowSmallSettingsClose').click(function() {
    closeCenterWindowSmallSettings();
  });
  
  $('#vFrontCenterWindowSmallInfoCMSClose').click(function() {
    closeCenterWindowSmallInfoCMS();
  });
  
  $('#vFrontCenterWindowSmallSettingsCloseHpSe').click(function() {
    closeCenterWindowSmallSettingsHpSe();
  });
  
  $('#vFrontCenterWindowHpProductListClose').click(function() {
    closeCenterWindowHpProductList();
  });
  
  $('#vFrontCenterWindowHpProductNewClose').click(function() {
    closeCenterWindowHpProductNew();
  });
  
  $('#vFrontCenterWindowHpProductListSeitEigClose').click(function() {
    closeCenterWindowHpProductListSeitEig();
  });
  
  $('#vFrontCenterWindowAllgemeinCMSWindowClose').click(function() {
    closeCenterWindowAllgemeinCMSWindow();
  });
  
  $('#vFrontCenterWindowSmallSettingsZindexOClose').click(function() {
    closeCenterWindowSmallSettingsZindexO();
  });
  
  $('#vFrontCenterWindowElementSettingsCaCMSWindowClose').click(function() {
    CenterWindowElementSettingsCaCMSWindow();
  });
  
  
  
  // Front Admin Windows Close bei ESC klick
  // ***************************************************************************
  $(document).keyup(function(e) {
    if (e.keyCode == 27) { 
      closeCenterWindowSmall();
      closeCenterWindowBig();
      closeCenterWindowBigImageVerwaltung();
      closeCenterWindowBigDateiVerwaltung();
      closeCenterWindowSmallSettingsImgVerwalt();
      closeCenterWindowImageAuswahl();
      closeCenterWindowSmallSettings();
      closeCenterWindowSmallInfoCMS();
      closeCenterWindowSmallSettingsHpSe();
      closeCenterWindowHpProductList();
      closeCenterWindowHpProductNew();
      closeCenterWindowHpProductListSeitEig();
      closeCenterWindowAllgemeinCMSWindow();
      CenterWindowElementSettingsCaCMSWindow();
    }
  });
 
 
 
  // Front Admin Media Verwaltung File Upload Buttons
  // ***************************************************************************
  $('#vFrontCenterWindowBigFileUploadBtn').click(function() {
    if (vCMScurUserRechtSession == 3 && $('.vFrontKatElemActive').attr('id') == 'vKatPicVerwId0') {
      alert('Sie können in diese Kategorie keine Bilder hochladen.');
    }
    else {
      if ($(this).hasClass('stateNo')) {
        $('#vFrontImageUploaderWindowInhalt').show();
        $(this).removeClass('stateNo');
        $(this).addClass('stateYes');
      }
      else {
        $('#vFrontImageUploaderWindowInhalt').hide();
        $(this).removeClass('stateYes');
        $(this).addClass('stateNo');
      }
    }
  });
  
  // Front Admin Media Verwaltung Buttons
  // ***************************************************************************
  $('#vFrontCenterWindowBigNewKatBtn').click(function() {
    showBildVerwaltungNewKategorieWindow();
  });
  
  $('#vFrontCenterWindowBigFilesTransportBtn').click(function() {
    showBildVerwaltungFilesTransportWindow();
  });
  
  $('#vFrontCenterWindowBigFilesDelMoreBtn').click(function() {
    var selectedElems = $('.vFrontImgVerwaltHolder > .ui-selected');
    var delCount = selectedElems.length;
    if (delCount > 0) {
      var outputMsg = 'Möchten Sie die '+delCount+' Bilder wirklich löschen?';
      if (delCount == 1) {
        outputMsg = 'Möchten Sie das Bild wirklich löschen?';
      }
      var checkerDel = confirm('!! ACHTUNG das Löschen kann nicht rückgängig gemacht werden !!\n\n\n'+outputMsg+'\n\n\n');
      if (checkerDel == true) {
        delMediaAllSelectedImagesNow();
      }
    }
    else {
      showErrorWindowNow('Es sind keine Bilder ausgewählt.');
    }
  });
  
  
  
  
  // *****************************************************************************************************************************
  
  
  
  
  // Front Admin Datei Verwaltung File Upload Buttons
  // ***************************************************************************
  $('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').click(function() {
    if ($(this).hasClass('stateNo')) {
      $('#vFrontDateiVerwaltUploaderWindowInhalt').show();
      $(this).removeClass('stateNo');
      $(this).addClass('stateYes');
    }
    else {
      $('#vFrontDateiVerwaltUploaderWindowInhalt').hide();
      $(this).removeClass('stateYes');
      $(this).addClass('stateNo');
    }
  });
  
  
  
  
  
  $('#vFrontCenterWindowBigDateiNewKatBtn').click(function() {
    showDateiVerwaltungNewKategorieWindow();
  });
  
  $('#vFrontCenterWindowBigDateiVerwaltFilesTransportBtn').click(function() {
    showDateiVerwaltungFilesTransportWindow();
  });
  
  
  
  $('#vFrontCenterWindowBigDateiVerwaltFilesDelMoreBtn').click(function() {
    var selectedElems = $('.vFrontImgVerwaltHolder > .ui-selected');
    var delCount = selectedElems.length;
    if (delCount > 0) {
      var outputMsg = 'Möchten Sie die '+delCount+' Dateien wirklich löschen?';
      if (delCount == 1) {
        outputMsg = 'Möchten Sie die Datei wirklich löschen?';
      }
      var checkerDel = confirm('!! ACHTUNG das Löschen kann nicht rückgängig gemacht werden !!\n\n\n'+outputMsg+'\n\n\n');
      if (checkerDel == true) {
        delMediaAllSelectedDateienNow();
      }
    }
    else {
      showErrorWindowNow('Es sind keine Dateien ausgewählt.');
    }
  });
  
  
  
  // *****************************************************************************************************************************
  
  
  
  // Front Admin Navi Art Select bei Seiten
  // ***************************************************************************
  $("#vFrontNaviArtSiteChangeSelect").msDropdown();
  
  $("#vFrontNaviArtSiteChangeSelect").change(function() {
    showSitesInWindow();
  });
  
  
  
  // Front Admin Elemente Draggable und Droppable
  // ***************************************************************************
  var drag_fixed = 1;
  $(".vFrontDragElem").draggable({ 
    //cancel: "a.ui-icon", // clicking an icon won't initiate dragging
    zIndex: 999999,
    revert: 'invalid',
    containment: 'document',
    helper: 'clone',
    cursor: 'move',
    appendTo: 'body',
    start: function(event, ui) {
      $('#vFrontWindowLeft').hide();
      drag_fixed = 0;
    },
    stop: function(event, ui) {
      $('#vFrontWindowLeft').show();
    },
    drag: function(event, ui){
      if(drag_fixed == 0) {
        var marg = $('body, html').scrollTop(); //$(ui.helper).offset().top + $('body').scrollTop();
        $(ui.helper).css('margin-top', '-'+marg+'px');
        drag_fixed = 1;
      }
    }
  });
  
  
  
  // Front Admin Copy Element Löschen
  // ***************************************************************************
  $('.vFrontDragElemCopyCloseBtnMM').click(function() {
    delTheDragElementCopyElementNowMM();
  });
  
  
  
  // Front Admin Elemente
  // ***************************************************************************
  initElementsMenu();

});