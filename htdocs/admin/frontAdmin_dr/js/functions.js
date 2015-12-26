/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/




var vSetNewSortRootSitesMM = false;

// *****************************************************************************
// ANFANG - Allgemeine Funktionen
// *****************************************************************************

var TimeoutErrorWindow = '';

function showErrorWindowNow(errorText) {
  $('#vFrontErrorWindowInhalt').html('');
  $('#vFrontErrorWindow').hide();
  clearTimeout(TimeoutErrorWindow);
  $('#vFrontErrorWindowInhalt').html(errorText);
  $('#vFrontErrorWindow').show();

  TimeoutErrorWindow = window.setTimeout('hideErrorWindowNow()', 4000);
}

function hideErrorWindowNow() {
  /*$('#vFrontErrorWindow').fadeOut(400, function() {
    $('#vFrontErrorWindowInhalt').html('');
  });*/
  $('#vFrontErrorWindowInhalt').html('');
  $('#vFrontErrorWindow').hide();
}


var TimeoutOkWindow = '';

function showOkWindowNow(okText) {
  $('#vFrontOkWindowInhalt').html('');
  $('#vFrontOkWindow').hide();
  clearTimeout(TimeoutOkWindow);
  $('#vFrontOkWindowInhalt').html(okText);
  $('#vFrontOkWindow').show();

  TimeoutOkWindow = window.setTimeout('hideOkWindowNow()', 4000);
}

function hideOkWindowNow() {
  /*$('#vFrontOkWindow').fadeOut(400, function() {
    $('#vFrontOkWindowInhalt').html('');
  });*/
  $('#vFrontOkWindowInhalt').html('');
  $('#vFrontOkWindow').hide();
}


function showAjaxFehler() {
  hideCmsIsLoading();
  alert('AJAX Fehler');
}



function showCmsIsLoading() {
  $('#vFrontIsLoadingOverlay').show();
  $.fancybox.showLoading();
}

function hideCmsIsLoading() {
  $('#vFrontIsLoadingOverlay').hide();
  $.fancybox.hideLoading();
}


// *****************************************************************************
// ANFANG - Allgemeine Funktionen
// *****************************************************************************









// *****************************************************************************
// ANFANG - Funktionen für Windows
// *****************************************************************************

function showLangChange() {
  if (!$('#vFrontBtnLanguage').hasClass('stateOpen')) {
    $('#vFrontLangHolder').show();
    $('#vFrontBtnLanguage').addClass('stateOpen');
  }
  else {
    $('#vFrontLangHolder').hide();
    $('#vFrontBtnLanguage').removeClass('stateOpen');
  }
}



function showRightWindowSiteTree() {
  if (!$('#vFrontBtnSeiten').hasClass('stateOpen')) {
    $('#vFrontWindowRight').animate({right: '0px'}, 300, function() {
      $('#vFrontBtnSeiten').addClass('stateOpen');
    });
    showSitesInWindow();
  }
  else {
    $('#vFrontWindowRight').animate({right: '-399px'}, 300, function() {
      $('#vFrontBtnSeiten').removeClass('stateOpen');
    });
    $('.vFrontWindowRightInhalt').html('');
  }
}



function showLeftWindowElements() {
  if (!$('#vFrontBtnElements').hasClass('stateOpen')) {
    $('#vFrontWindowLeft').animate({left: '0px'}, 300, function() {
      $('#vFrontBtnElements').addClass('stateOpen');
    });
  }
  else {
    $('#vFrontWindowLeft').animate({left: '-281px'}, 300, function() {
      $('#vFrontBtnElements').removeClass('stateOpen');
    });
  }
}



function closeCenterWindowSmall() {
  $('#mce-modal-block').removeClass('mce-modal-block-set-zindex');
  $('.mce-window').removeClass('mce-window-set-zindex');
  
  $('#vFrontOverlay').hide();
  $('#vFrontCenterWindowSmall').hide();
  $('#vFrontCenterWindowSmallInhalt').html('');
  $('#vFrontCenterWindowSmallHeadInhalt').html('');
}



function closeCenterWindowBig() {
  try {
    for (var cII = 0; cII < curSiteFieldInstanzEditors.length; cII++) {
      curSiteFieldInstanzEditors[cII].destroy();
    }
    curSiteFieldInstanzEditorsCounters = -1;
  }
  catch(e) {
    //console.log(e);
  }
  
  try {
    for (var cIII = 0; cIII < curEmpfManagerMailFieldInstanzEditors.length; cIII++) {
      curEmpfManagerMailFieldInstanzEditors[cIII].destroy();
    }
    curEmpfManagerMailFieldInstanzEditorsCounters = -1;
  }
  catch(e) {
    //console.log(e);
  }
  
  $('#vFrontOverlay').hide();
  $('#vFrontCenterWindowBig').hide();
  //$('#vFrontCenterWindowBigFileUploadBtn').hide();
  //$('#vFrontCenterWindowBigFileUploadBtn').removeClass('stateYes');
  //$('#vFrontCenterWindowBigFileUploadBtn').addClass('stateNo');
  //$('#vFrontImageUploaderWindowInhalt').hide();
  //$('#vFrontImageUploaderWindowInhalt ul').html('');
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigHeadInhalt').html('');
}



function closeCenterWindowBigImageVerwaltung() {
  $('#vFrontOverlayFour').hide();
  $('#vFrontCenterWindowBigImageVerwaltung').hide();
  //$('#vFrontCenterWindowBigFileUploadBtn').hide();
  //$('#vFrontCenterWindowBigFileUploadBtn').removeClass('stateYes');
  //$('#vFrontCenterWindowBigFileUploadBtn').addClass('stateNo');
  //$('#vFrontImageUploaderWindowInhalt').hide();
  $('#vFrontImageUploaderWindowInhalt ul').html('');
  $('#vFrontCenterWindowBigImageVerwaltungInhalt').html('');
  $('#vFrontCenterWindowBigImageVerwaltungHeadInhalt').html('');
}



function closeCenterWindowBigDateiVerwaltung() {
  $('#vFrontOverlayFour').hide();
  $('#vFrontCenterWindowBigDateiVerwaltung').hide();
  //$('#vFrontCenterWindowBigFileUploadBtn').hide();
  //$('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').removeClass('stateYes');
  //$('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').addClass('stateNo');
  //$('#vFrontDateiVerwaltUploaderWindowInhalt').hide();
  $('#vFrontDateiVerwaltUploaderWindowInhalt ul').html('');
  $('#vFrontCenterWindowBigDateiVerwaltungInhalt').html('');
  $('#vFrontCenterWindowBigDateiVerwaltungHeadInhalt').html('');
}



function closeCenterWindowSmallSettingsImgVerwalt() {
  $('#vFrontOverlayFive').hide();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').hide();
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
}



function closeCenterWindowImageAuswahl() {
  $('#vFrontOverlayThird').hide();
  $('#vFrontCenterWindowImageAuswahl').hide();
  $('#vFrontCenterWindowImageAuswahlHeadInhalt').html('Bilder auswählen');
  $('#vFrontCenterWindowImageAuswahlInhalt').html('');
}



function closeCenterWindowSmallSettings() {
  if ($('#vFrontCenterWindowSmallSettingsClose').hasClass('vFrontIsPicGalSiSeWindow')) {
    $('#vFrontOverlaySecond').hide();
    $('#vFrontCenterWindowSmallSettingsClose').removeClass('vFrontIsPicGalSiSeWindow')
  }
  else {
    $('#vFrontOverlay').hide();
  }
  $('#vFrontCenterWindowSmallSettings').hide();
  $('#vFrontCenterWindowSmallSettings').removeClass('vFrontSetBigWindowClassNow');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Einstellungen');
}



function closeCenterWindowSmallInfoCMS() {
  $('#vFrontOverlay').hide();
  $('#vFrontCenterWindowSmallInfoCMS').hide();
  $('#vFrontCenterWindowSmallInfoCMSInhalt').html('');
}



function closeCenterWindowSmallSettingsHpSe() {
  $('#vFrontOverlaySecond').hide();
  $('#vFrontCenterWindowSmallSettingsHpSe').hide();
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
}



function closeCenterWindowHpProductList() {
  $('#vFrontOverlay').hide();
  $('#vFrontCenterWindowHpProductList').hide();
  $('#vFrontCenterWindowHpProductListHeadInhalt').html('');
  $('#vFrontCenterWindowHpProductListInhalt').html('');
}



function closeCenterWindowHpProductNew() {
  if ($('#vFrontShopProductDesc').length > 0) {
    $('#vFrontShopProductDesc').tinymce().destroy();
  }
  $('#vFrontOverlaySecond').hide();
  $('#vFrontCenterWindowHpProductNew').hide();
  $('#vFrontCenterWindowHpProductNewHeadInhalt').html('');
  $('#vFrontCenterWindowHpProductNewInhalt').html('');
}



function closeCenterWindowHpProductListSeitEig() {
  $('#vFrontOverlaySecond').hide();
  $('#vFrontCenterWindowHpProductListSeitEig').hide();
  $('#vFrontCenterWindowHpProductListSeitEigHeadInhalt').html('');
  $('#vFrontCenterWindowHpProductListSeitEigInhalt').html('');
}



function closeCenterWindowAllgemeinCMSWindow() {
  try {
    for (var cII = 0; cII < curDankeTextFieldInstanzEditors.length; cII++) {
      curDankeTextFieldInstanzEditors[cII].destroy();
    }
    curDankeTextFieldInstanzEditorsCounters = -1;
  }
  catch(e) {
    console.log(e);
  }
  
  $('#vFrontOverlayFive').hide();
  $('#vFrontCenterWindowAllgemeinCMSWindow').hide();
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
}



function CenterWindowElementSettingsCaCMSWindow() {
  try {
    for (var cII = 0; cII < curSiteFieldInstanzEditors.length; cII++) {
      curSiteFieldInstanzEditors[cII].destroy();
    }
    curSiteFieldInstanzEditorsCounters = -1;
  }
  catch(e) {
    console.log(e);
  }
  
  $('#vFrontOverlay').hide();
  $('#vFrontCenterWindowElementSettingsCaCMSWindow').hide();
  $('#vFrontCenterWindowElementSettingsCaCMSWindowHeadInhalt').html('');
  $('#vFrontCenterWindowElementSettingsCaCMSWindowInhalt').html('');
}



function closeCenterWindowSmallSettingsZindexO() {
  $('#vFrontOverlaySix').hide();
  $('#vFrontCenterWindowSmallSettingsZindexO').hide();
  $('#vFrontCenterWindowSmallSettingsZindexOHeadInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html('');
}

// *****************************************************************************
// ENDE - Funktionen für Windows
// *****************************************************************************








// *****************************************************************************
// ANFANG - Funktionen für CMS Seiten
// *****************************************************************************

function showSitesInWindow() {
  $('.vFrontWindowRightInhalt').html('<div class="vFrontWinLoader"><img src="admin/frontAdmin/img/loader.gif" alt="lade..." title="" /><br /><br />Seiten werden geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'getSeitenStrukturWindow', VCMS_POST_LANG: $('body').attr('data-lang'), VCMS_CUR_CMS_SITE_ID: $('body').attr('data-sid'), _nartID: $('#vFrontNaviArtSiteChangeSelect').val()},
    success: function(data) {
      $('.vFrontWindowRightInhalt').html(data);
      initSiteBaumFunctions();
      if (vSetNewSortRootSitesMM == true) {
        setSortBaumNow('p0');
        vSetNewSortRootSitesMM = false;
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSiteBaumFunctions() {
  if ($('body').attr('data-lang') == '' && vCMScurUserRechtSession != 3) {
    /*$('.vFrontSeitenBaumHolder0, .vFrontSeitenBaumHolder1, .vFrontSeitenBaumHolder2, .vFrontSeitenBaumHolder3, .vFrontSeitenBaumHolder4').sortable({
      items: "> .soElems",
      connectWith: ".connectedSortable",
      placeholder: "ui-state-highlight",
      delay: 300,
      grid: [ 10, 10 ],
      //axis: "y",
      //forcePlaceholderSizeType: true,
      //forceHelperSize: true,
      //tolerance: "pointer",
      //helper: "clone",
      //cursorAt: { left: 40 },
      start: function(event, ui) {
        $('.ui-sortable').css('min-height', '10px');
        $('.soElems').addClass('soElemsNoHoverV');
        //$item.addClass("dragged");
        $("body").addClass("dragging");
      },
      stop: function(event, ui) {
        setSortBaumNow(ui.item.parent().attr('id'));
        //$('.ui-sortable').css('min-height', '0px');
      }
    });*/
    
    $('.vFrontSeitenBaumHolder0').sortableTree({
      containerSelector: '.connectedSortable',
      itemSelector: '.soElems',
      placeholder: '<li class="placeholder"></li>',
      handle: '.isDragToStartDivMM',
      exclude: '.vFrontNaviSeitElemBaum, .vFrontNaviSeitElemBaum > a, .vFrontNaviSeitElemBaum > a > div, .vFrontNaviSeitElemBaum > div',
      onDragStart: function ($item, container, _super) {
        startSeitbaumSortOnDragScroller($item);
        $('.soElems').addClass('soElemsNoHoverV');
        $item.addClass("dragged");
        $("body").addClass("dragging");
        $('.vFrontBaumShowCurStateHtmlElem').hide();
      },
      onDrag: function ($item, position, _super) {
        /*if ($item.css('top').replace('px', '') > $('.vFrontWindowRightInhalt').height() - 40) {
          //$('.vFrontWindowRightInhalt').animate({scrollTop:$item.css('top').replace('px', '')}, 200);
          $('.vFrontWindowRightInhalt').scrollTop($('.vFrontWindowRightInhalt').scrollTop()+2);
        }
        if ($item.css('top').replace('px', '') < 4) {
          //$('.vFrontWindowRightInhalt').animate({scrollTop:$item.css('top').replace('px', '')}, 200);
          $('.vFrontWindowRightInhalt').scrollTop($('.vFrontWindowRightInhalt').scrollTop()-2);
        }*/
        $item.css(position);
      },
      onDrop: function ($item, container, _super) {
        stopSeitbaumSortOnDragScroller();
        setSortBaumNow($item.parent().attr('id'));
        $('.soElems').removeClass('soElemsNoHoverV');
        $item.removeClass("dragged").removeAttr("style");
        $("body").removeClass("dragging");
      }
    });
  }

  $('.vFrontSeitBaumSeitShow').click(function() {
    //var curShowUrl = $(this).attr('id').replace('vCMSshow-', '');
    //window.location.href = curShowUrl;
  });
  $('.vFrontSeitBaumChange').click(function() {
    var curBearSiteIDB = $(this).attr('id').replace('change', '');
    showBearSiteWindow(curBearSiteIDB);
  });
  $('.vFrontSeitBaumChangeOnLang').click(function() {
    var curBearSiteIDBLang = $(this).attr('id').replace('change', '');
    showBearSiteWindowOnLang(curBearSiteIDBLang);
  });
  $('.vFrontSeitBaumTrash').click(function() {
    var checkerDel = confirm('Möchten Sie die Seite wirklich löschen?');
    if (checkerDel == true) {
      var curSiteDelID = $(this).attr('id').replace('del', '');
      deleteSiteNow(curSiteDelID);
    }
  });
  
  $('.vFrontSeitBaumSiteCopy').click(function() {
    var checkerCopySite = confirm('Möchten Sie die Seite wirklich kopieren?');
    if (checkerCopySite == true) {
      var curSiteCopyID = $(this).attr('id').replace('copy', '');
      copyThisSiteInSiteBaumNow(curSiteCopyID);
    }
  });
}



// *****************************************************************************
var curSeitbaumSortItemMMZw = '';
var curSeitbaumSortInterval = '';

function startSeitbaumSortOnDragScroller(curItem) {
  curSeitbaumSortItemMMZw = curItem;
  curSeitbaumSortInterval = setInterval(function(){ checkSeitbaumSortOnDragScroller() }, 10);
}

function checkSeitbaumSortOnDragScroller() {
  if (curSeitbaumSortItemMMZw.css('top').replace('px', '') > $('.vFrontWindowRightInhalt').height() - 20) {
    $('.vFrontWindowRightInhalt').scrollTop($('.vFrontWindowRightInhalt').scrollTop()+2);
  }
  if (curSeitbaumSortItemMMZw.css('top').replace('px', '') < 4) {
    $('.vFrontWindowRightInhalt').scrollTop($('.vFrontWindowRightInhalt').scrollTop()-2);
  }
}

function stopSeitbaumSortOnDragScroller() {
  clearInterval(curSeitbaumSortInterval);
  curSeitbaumSortItemMMZw = '';
}
// *****************************************************************************



function copyThisSiteInSiteBaumNow(curSiteCopyID) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'copyThisSiteInSiteBaumNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteCopyID: curSiteCopyID},
    success: function(data) {
      if (data == 'ok') {
        vSetNewSortRootSitesMM = true;
        showOkWindowNow('Die Seite wurde erfolgreich kopiert!');
        showSitesInWindow();
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function setSortBaumNow(parentID) {
  showCmsIsLoading();
  var parID = parentID.replace('p', '');
  var sortElems = $('#p' + parID + ' > .soElems');
  var dataToSet = '';
  var hansSort = 0;

  $.each(sortElems, function() {
    if (hansSort == 0) {
      dataToSet += $(this).attr('id').replace('s', '');
    }
    else {
      dataToSet += ';' + $(this).attr('id').replace('s', '');
    }
    hansSort = hansSort + 1;
  });

  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveSortSeitenbaum', VCMS_POST_LANG: $('body').attr('data-lang'), _sortsID: dataToSet, _curParentID: parID},
    success: function(data) {
      hideCmsIsLoading();
      showSitesInWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function deleteSiteNow(siteDelID) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delCurSiteNow', VCMS_POST_LANG: $('body').attr('data-lang'), _delSiteID: siteDelID},
    success: function(data) {
      if (data == 'ok') {
        showOkWindowNow('Die Seite wurde erfolgreich gelöscht!');
        showSitesInWindow();
      }
      else if (data == 'uFehler') {
        showErrorWindowNow('Die Seite kann nicht gelöscht werden!<br />Es sind Unterseiten vorhanden!');
      }
      else {
        showErrorWindowNow('Datenbank Fehler');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showNewSiteWindow() {
  var abstandLeft = ($(window).width() / 2) - (415 / 2);
  $('#vFrontCenterWindowSmall').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallInhalt').html('');
  $('#vFrontCenterWindowSmallInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallHeadInhalt').html('Neue Seite erstellen');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmall').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'getNewSiteFields', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallInhalt').html(data);
      $('#vFrontCenterWindowSmallInhalt .vFrontFrmHolder #siteNavArt').val($('#vFrontNaviArtSiteChangeSelect').val());
      initNewSiteFunctions();
      initNewSiteFunctionsOnlyNew();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showBearSiteWindow(curBearSiteID) {
  var abstandLeft = ($(window).width() / 2) - (415 / 2);
  $('#vFrontCenterWindowSmall').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallInhalt').html('');
  $('#vFrontCenterWindowSmallInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallHeadInhalt').html('Seite bearbeiten');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmall').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'getBearSiteFields', VCMS_POST_LANG: $('body').attr('data-lang'), _curBearSiteID: curBearSiteID},
    success: function(data) {
      $('#vFrontCenterWindowSmallInhalt').html(data);
      initNewSiteFunctions();
      initNewSiteFunctionsOnlyBear();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showBearSiteWindowOnLang(curBearSiteID) {
  var abstandLeft = ($(window).width() / 2) - (415 / 2);
  $('#vFrontCenterWindowSmall').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallInhalt').html('');
  $('#vFrontCenterWindowSmallInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallHeadInhalt').html('Seite bearbeiten (Spracheintrag)');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmall').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'getBearSiteFieldsOnLang', VCMS_POST_LANG: $('body').attr('data-lang'), _curBearSiteID: curBearSiteID},
    success: function(data) {
      $('#vFrontCenterWindowSmallInhalt').html(data);
      initBearSiteFunctionsOnLang();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}


function initBearSiteFunctionsOnLang() {
  $('#siteSaveBearBtnOnLang').click(function() {
    //checkDataSaveBearSiteOnLang();
    saveDataBearSiteNowOnLang();
  });
  
  $('#vFrontImportMetaTitleInTextboxSeoLang').click(function() {
    if ($('#siteMetaTitle').val() != '') {
      var checkerMetaTitleImp = confirm('Möchten Sie den Meta Title wirklich überschreiben?');
      if (checkerMetaTitleImp == true) {
        importCurentMetaTitleInTextboxSeoSite($(this).attr('data-id'));
      }
    }
    else {
      importCurentMetaTitleInTextboxSeoSite($(this).attr('data-id'));
    }
  });
  
  $('#vFrontImportMetaDescInTextareaSeoLang').click(function() {
    if ($('#siteMetaDesc').val() != '') {
      var checkerMetaDescImp = confirm('Möchten Sie die Meta Description wirklich überschreiben?');
      if (checkerMetaDescImp == true) {
        importCurentDescInTextareaSeoSite($(this).attr('data-id'));
      }
    }
    else {
      importCurentDescInTextareaSeoSite($(this).attr('data-id'));
    }
  });
  
  startGoogleMetaTagCounts();
  
  
  if (vcmsIsAllgemeinSetHpMetaTitleOkMM == 'yes') {
    $('#siteMetaTitle').css('border', '2px solid #4DAF7C');
  }
  else {
    $('#siteMetaTitle').css('border', '2px solid #f5a9a9');
  }
}


/*function checkDataSaveBearSiteOnLang() {
  var errorTextBearSiteOnLang = '';
  
  if ($('#siteName').val() == '') {
    errorTextBearSiteOnLang += 'Bitte geben Sie einen Name ein!<br />';
  }
  
  if (errorTextBearSiteOnLang != '') {
    showErrorWindowNow(errorTextBearSiteOnLang);
    return false;
  }
  else {
    saveDataBearSiteNowOnLang();
    return true;
  }
}*/


function saveDataBearSiteNowOnLang() {
  var curData = '';

  if ($('#siteCurArtNum').val() == 3) {
    curData = {_art: 'saveBearbeitSiteNowOnLang', _siteArt: $('#siteCurArtNum').val(), _siteName: $('#siteName').val()};
  }
  else {
    curData = {_art: 'saveBearbeitSiteNowOnLang', _siteArt: $('#siteCurArtNum').val(), _siteName: $('#siteName').val(), _siteMetaTitle: $('#siteMetaTitle').val(), _siteMetaKeywords: $('#siteMetaKeywords').val(), _siteMetaDesc: $('#siteMetaDesc').val()};
    
    curData['_siteGoogleCanonical'] = $('#siteGoogleCanonical').val();
    if ($('#siteGoogleNoIndex').is(':checked')) {
      curData['_siteGoogleNoIndex'] = 2;
    }
    else {
      curData['_siteGoogleNoIndex'] = 1;
    }
  }
  
  curData['VCMS_POST_LANG'] = $('body').attr('data-lang');
  curData['_curSiteBearID'] = $('#siteCurBearID').val();
  
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: curData,
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmall();
        showSitesInWindow();
        showOkWindowNow('Die Seite wurde erfolgreich gespeichert!');
      }
      else {
        showErrorWindowNow('Datenbank Fehler');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initNewSiteFunctionsOnlyNew() {
  $('#siteName').on('input',function(e) {
    var curStringName = $('#siteName').val();
    curStringName = curStringName.replace(/ä/g, 'ae');
    curStringName = curStringName.replace(/Ä/g, 'ae');
    curStringName = curStringName.replace(/ü/g, 'ue');
    curStringName = curStringName.replace(/Ü/g, 'ue');
    curStringName = curStringName.replace(/ö/g, 'oe');
    curStringName = curStringName.replace(/Ö/g, 'oe');
    curStringName = curStringName.replace(/ß/g, 'ss');
    curStringName = curStringName.replace(/\s/g, '-');
    curStringName = curStringName.replace(/[^a-zA-Z0-9_\-\§]/g, '');
    curStringName = curStringName.replace(/-+/g, '-');
    curStringName = curStringName.toLowerCase();
    $('#siteTextUrl').val(curStringName);
  });
}



function initNewSiteFunctionsOnlyBear() {
  $('#siteName').on('input',function(e) {
    if ($('#siteBearCheckAutoTextUrl').is(':checked')) {
      var curStringName = $('#siteName').val();
      curStringName = curStringName.replace(/ä/g, 'ae');
      curStringName = curStringName.replace(/Ä/g, 'ae');
      curStringName = curStringName.replace(/ü/g, 'ue');
      curStringName = curStringName.replace(/Ü/g, 'ue');
      curStringName = curStringName.replace(/ö/g, 'oe');
      curStringName = curStringName.replace(/Ö/g, 'oe');
      curStringName = curStringName.replace(/ß/g, 'ss');
      curStringName = curStringName.replace(/\s/g, '-');
      curStringName = curStringName.replace(/[^a-zA-Z0-9_\-\§]/g, '');
      curStringName = curStringName.replace(/-+/g, '-');
      curStringName = curStringName.toLowerCase();
      $('#siteTextUrl').val(curStringName);
    }
  });
}



function initNewSiteFunctions() {
  $('#vFrontCenterWindowSmallInhalt').scrollTop(0);
  $('#siteArt').msDropdown();
  $('#siteLayout').msDropdown();
  $('#siteNavTarget').msDropdown();
  $('.siteNavArtSelecter').msDropdown();
  
  $('#siteSaveBearBtn').click(function() {
    checkDataSaveNewSite('change');
  });
  $('#siteSaveBtn').click(function() {
    checkDataSaveNewSite('new');
  });
  $('#siteArt').change(function() {
    if ($(this).val() == 3) {
      $('#vFrontFieldsForSite').hide();
      $('#vFrontFieldsForSiteOnlyNavi').show();
      $('#vFrontFieldsForNaviOnline').show();
    }
    else {
      $('#vFrontFieldsForSiteOnlyNavi').hide();
      $('#vFrontFieldsForNaviOnline').hide();
      $('#vFrontFieldsForSite').show();
    }
  });
  
  // Für Hintergrundbilder bei Navi ohne Seiten
  // *************************************************************
  $('.vFrontFrmListHolder .vFrontFrmListHolderLists').selectable();
  
  $('.vFrontFrmListHolderHeaderAdd').click(function() {
    showWindowImageAuswahl($(this).parent().parent().attr('data-field'), true);
  });
  $('.vFrontFrmListHolderHeaderDel').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortPicIdInField(parElEig);
  });
  $('.vFrontFrmListHolderHeaderSort').click(function() {
    var parElEig = $(this).parent().parent();
    var listToSet = parElEig.find('.vFrontFrmListHolderLists');
    if ($(this).hasClass('listSortActive')) {
      $(this).removeClass('listSortActive');
      listToSet.sortable('destroy');
      listToSet.selectable();
    }
    else {
      $(this).addClass('listSortActive');
      listToSet.selectable('destroy');
      listToSet.sortable({
        stop: function(event, ui) { setNewSortPicIdInField(parElEig); }
      });;
    }
  });
  // *************************************************************
  
  
  startGoogleMetaTagCounts();
  
  
  
  $('.vFrontSmallSiteNoSiteOnlyNaviShowAuswahlWindow').click(function() {
    showNoSiteOnlyNaviSeitenauswahlWin();
  });
  
  
  
  $('#vFrontImportMetaTitleInTextboxSeo').click(function() {
    if ($('#siteMetaTitle').val() != '') {
      var checkerMetaTitleImp = confirm('Möchten Sie den Meta Title wirklich überschreiben?');
      if (checkerMetaTitleImp == true) {
        importCurentMetaTitleInTextboxSeoSite($(this).attr('data-id'));
      }
    }
    else {
      importCurentMetaTitleInTextboxSeoSite($(this).attr('data-id'));
    }
  });
  
  
  
  $('#vFrontImportMetaDescInTextareaSeo').click(function() {
    if ($('#siteMetaDesc').val() != '') {
      var checkerMetaDescImp = confirm('Möchten Sie die Meta Description wirklich überschreiben?');
      if (checkerMetaDescImp == true) {
        importCurentDescInTextareaSeoSite($(this).attr('data-id'));
      }
    }
    else {
      importCurentDescInTextareaSeoSite($(this).attr('data-id'));
    }
  });
  
  
  
  if (vcmsIsAllgemeinSetHpMetaTitleOkMM == 'yes') {
    $('#siteMetaTitle').css('border', '2px solid #4DAF7C');
  }
  else {
    $('#siteMetaTitle').css('border', '2px solid #f5a9a9');
  }
  
  
  
  $('#siteOnlineBisDateMMN, #siteOnlineAbDateMMN').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "../../../admin/img/calendar.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  $('#siteOnlineBisTimeMMN, #siteOnlineAbTimeMMN').timepicker({
    hourText: 'Stunden',
    minuteText: 'Minuten',
    showOn: 'both',
    button: '#timePickerBtnImg'
  });
}



function importCurentMetaTitleInTextboxSeoSite(curSiteId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_seo.php",
    data: {_art: 'importCurentMetaTitleInTextboxSeoSite', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteId: curSiteId},
    success: function(data) {
      $('#siteMetaTitle').val(data);
      startGoogleMetaTagCounts();
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function importCurentDescInTextareaSeoSite(curSiteId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_seo.php",
    data: {_art: 'importCurentDescInTextareaSeoSite', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteId: curSiteId},
    success: function(data) {
      $('#vFrontIsOnlyZwMetaDescContentHtml').html(data);
      var CurSeoContentInhaltObj = $('#vFrontIsOnlyZwMetaDescContentHtml').find('.vFrontIsCurSeoContentSet').first();
      CurSeoContentInhaltObj.find('h1').remove();
      CurSeoContentInhaltObj.find('h2').remove();
      CurSeoContentInhaltObj.find('h3').remove();
      CurSeoContentInhaltObj.find('h4').remove();
      CurSeoContentInhaltObj.find('h5').remove();
      CurSeoContentInhaltObj.find('h6').remove();
      getCurentMetaDesTextInContentSite(CurSeoContentInhaltObj.html());
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function getCurentMetaDesTextInContentSite(curContentText) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_seo.php",
    data: {_art: 'getCurentMetaDesTextInContentSite', VCMS_POST_LANG: $('body').attr('data-lang'), _curContentText: curContentText},
    success: function(data) {
      $('#siteMetaDesc').val(data);
      //$('#vFrontIsOnlyZwMetaDescContentHtml').html('');
      startGoogleMetaTagCounts();
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



// Für Navi ohne Seite Seitenlink Auswahl Window
// *****************************************************************************
function showNoSiteOnlyNaviSeitenauswahlWin() {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('CMS Seite auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingSeitenauswahlWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initNoSiteOnlyNaviSeitenauswahlWin();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showNoSiteOnlyNaviSeitenauswahlWinReloadMM(nartID) {
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingSeitenauswahlWinReloadMM', VCMS_POST_LANG: $('body').attr('data-lang'), _naviArtID: nartID},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initNoSiteOnlyNaviSeitenauswahlWin();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initNoSiteOnlyNaviSeitenauswahlWin() {
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').msDropDown();
  
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').change(function() {
    showNoSiteOnlyNaviSeitenauswahlWinReloadMM($(this).val());
  });
  
  $('.vFrontBaumElem').click(function() {
    $('#siteNavCmsSiteLink').val($(this).attr('data-id'));
    closeCenterWindowAllgemeinCMSWindow();
  });
}
// *****************************************************************************



// Für Google Meta Counts
// *****************************************************************************
function startGoogleMetaTagCounts() {
  if ($('#siteMetaTitle').length > 0) {
    googleMetaTagCountsSet($('#siteMetaTitle'), $('.siteMetaTitleCount'), 90);
    googleMetaTagCountsSet($('#siteMetaKeywords'), $('.siteMetaKeywordsCount'), 255);
    googleMetaTagCountsSetDescWoerter($('#siteMetaDesc'), $('.siteMetaDescCount'), 35);

    $('#siteMetaTitle').on('input',function(e) {
      googleMetaTagCountsSet($(this), $('.siteMetaTitleCount'), 90);
    });

    $('#siteMetaKeywords').on('input',function(e) {
      googleMetaTagCountsSet($(this), $('.siteMetaKeywordsCount'), 255);
    });

    $('#siteMetaDesc').on('input',function(e) {
      googleMetaTagCountsSetDescWoerter($(this), $('.siteMetaDescCount'), 35);
    });
  }
}



function googleMetaTagCountsSet(curInputObj, curCountObj, maxLength) {
  if ((maxLength - curInputObj.val().length) < 0) {
    curCountObj.addClass('siteMetaCountRedUserShow');
    curCountObj.html(((maxLength - curInputObj.val().length)*-1)+' Zeichen');
  }
  else {
    curCountObj.removeClass('siteMetaCountRedUserShow');
    curCountObj.html((maxLength - curInputObj.val().length)+' Zeichen');
  }
  
  startCreateGoogleOrigShow();
}


function googleMetaTagCountsSetDescWoerter(curInputObj, curCountObj, maxLength) {
  var zwText = curInputObj.val(); //.replace(/^\s+/g, '').replace(/\s+$/g, '');
  if ((maxLength - zwText.split(' ').length) < 0) {
    curCountObj.addClass('siteMetaCountRedUserShow');
    curCountObj.html(((maxLength - zwText.split(' ').length)*-1)+' Wörter');
  }
  else {
    curCountObj.removeClass('siteMetaCountRedUserShow');
    curCountObj.html((maxLength - zwText.split(' ').length)+' Wörter');
  }
  
  if (zwText.length == 0) {
    curCountObj.html(maxLength+' Wörter');
  }
  
  startCreateGoogleOrigShow();
}
// *****************************************************************************



// Für Google Original Ansicht Nachbau
// *****************************************************************************
function startCreateGoogleOrigShow() {
  // Title 50 Zeichen ...
  // Desc ????? ...
  
  if ($('#siteMetaTitle').val().length > 0 && $('#siteMetaDesc').val().length > 0) {
    var curGoogleOrigHtml = '<div class="vFrontGoogleSearchOrigShowHolder">';
    
    var curGoogleOrigUri = window.location.href;
    curGoogleOrigUri = curGoogleOrigUri.replace('http://', '');
    var curGoogleOrigTitle = '';
    if ($('#siteMetaTitle').val().length > 45) {
      curGoogleOrigTitle = $('#siteMetaTitle').val().substr(0, 45)+' ...';
    }
    else {
      curGoogleOrigTitle = $('#siteMetaTitle').val();
    }
    var curGoogleOrigDesc = '';
    if ($('#siteMetaDesc').val().length > 135) {
      curGoogleOrigDesc = $('#siteMetaDesc').val().substr(0, 135)+' ...';
    }
    else {
      curGoogleOrigDesc = $('#siteMetaDesc').val();
    }
    
    curGoogleOrigHtml += '<div class="vFrontGoogleSearchOrigShowTitle">'+curGoogleOrigTitle+'</div>';
    curGoogleOrigHtml += '<div class="vFrontGoogleSearchOrigShowUri">'+curGoogleOrigUri+'</div>';
    curGoogleOrigHtml += '<div class="vFrontGoogleSearchOrigShowDesc">'+curGoogleOrigDesc+'</div>';
    
    curGoogleOrigHtml += '</div>';
    
    $('#vFrontGoogleSearchOrigShow').html(curGoogleOrigHtml);
  }
  else {
    $('#vFrontGoogleSearchOrigShow').html('');
  }
}
// *****************************************************************************



function checkDataSaveNewSite(curSiteRequest) {
  var errorTextNewSite = '';

  if ($('#siteArt').val() == '') {
    errorTextNewSite += 'Bitte wählen Sie eine Seiten Art aus!<br />';
  }
  if ($('#siteName').val() == '') {
    errorTextNewSite += 'Bitte geben Sie einen Name ein!<br />';
  }

  if ($('#siteArt').val() == 3) {

  }
  else {
    if ($('#siteTextUrl').val() == '') {
      errorTextNewSite += 'Bitte geben Sie eine Text Url ein!<br />';
    }
    else if ($('#siteTextUrl').val() != '' && $('#siteTextUrl').val().length < 3) {
      errorTextNewSite += 'Die Text Url muss mindestens 3 Zeichen haben!<br />';
    }
    else if ($('#siteTextUrl').val() != '' && !checkTextUrlValid($('#siteTextUrl').val())) {
      errorTextNewSite += 'Die Text Url ist nicht gültig!<br />';
    }
    if ($('#siteLayout').val() == '') {
      errorTextNewSite += 'Bitte wählen Sie ein Seiten Layout aus!<br />';
    }
  }

  if (errorTextNewSite != '') {
    showErrorWindowNow(errorTextNewSite);
    return false;
  }
  else {
    saveDataNewSiteNow(curSiteRequest);
    return true;
  }
}



function checkTextUrlValid(curTextUri) {
  var validuriregex = /^[a-zA-Z0-9_\-\§]+$/i;
  return validuriregex.test(curTextUri);
}



function saveDataNewSiteNow(curSiteRequestSave) {
  var curData = '';

  if ($('#siteArt').val() == 3) {
    curData = {_siteArt: $('#siteArt').val(), _siteName: $('#siteName').val(), _siteNaviLinkUrl: $('#siteNavLink').val(), _siteNaviCmsSiteID: $('#siteNavCmsSiteLink').val(), _siteNaviTarget: $('#siteNavTarget').val(), _siteNaviArt: $('#siteNavArt').val(), _curBackImagesNavi: $('#vFrontFrmSiteNaviOhneSeiteBackImgs').val()};

    if (curSiteRequestSave == 'new') {
      curData['_art'] = 'saveNewSiteNow';
    }
    else if (curSiteRequestSave == 'change') {
      curData['_art'] = 'saveBearbeitSiteNow';
      curData['_bearSeitenID'] = $('#siteCurBearID').val();
    }
    if ($('#navCheckOffline').is(':checked')) {
      curData['_siteOffline'] = 2;
    }
    else {
      curData['_siteOffline'] = 1;
    }
    
    curData['VCMS_POST_LANG'] = $('body').attr('data-lang');
  }
  else {
    curData = {_siteArt: $('#siteArt').val(), _siteName: $('#siteName').val(), _siteTextUrl: $('#siteTextUrl').val(), _siteLayout: $('#siteLayout').val(), _siteMetaTitle: $('#siteMetaTitle').val(), _siteMetaKeywords: $('#siteMetaKeywords').val(), _siteMetaDesc: $('#siteMetaDesc').val(), _siteNaviArt: $('#siteNavArt').val(), _siteOnlineAbDateMMN: $('#siteOnlineAbDateMMN').val(), _siteOnlineAbTimeMMN: $('#siteOnlineAbTimeMMN').val(), _siteOnlineBisDateMMN: $('#siteOnlineBisDateMMN').val(), _siteOnlineBisTimeMMN: $('#siteOnlineBisTimeMMN').val()};

    if (curSiteRequestSave == 'new') {
      curData['_art'] = 'saveNewSiteNow';
    }
    else if (curSiteRequestSave == 'change') {
      curData['_art'] = 'saveBearbeitSiteNow';
      curData['_bearSeitenID'] = $('#siteCurBearID').val();
    }
    if ($('#siteCheckOffline').is(':checked')) {
      curData['_siteOffline'] = 2;
    }
    else {
      curData['_siteOffline'] = 1;
    }

    if ($('#siteCheckNoNavi').is(':checked')) {
      curData['_siteNoNavi'] = 2;
    }
    else {
      curData['_siteNoNavi'] = 1;
    }
    
    curData['VCMS_POST_LANG'] = $('body').attr('data-lang');
    
    curData['_siteGoogleCanonical'] = $('#siteGoogleCanonical').val();
    if ($('#siteGoogleNoIndex').is(':checked')) {
      curData['_siteGoogleNoIndex'] = 2;
    }
    else {
      curData['_siteGoogleNoIndex'] = 1;
    }
  }
  
  showCmsIsLoading();

  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: curData,
    success: function(data) {
      if (data == 'Uri_Error') {
        showErrorWindowNow('Die Text Url ist schon vorhanden!<br />');
      }
      else if (data == true) {
        closeCenterWindowSmall();
        if (curSiteRequestSave == 'new') {
          vSetNewSortRootSitesMM = true;
        }
        showSitesInWindow();
        showOkWindowNow('Die Seite wurde erfolgreich gespeichert!');
      }
      else {
        showErrorWindowNow('Datenbank Fehler');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}


// *****************************************************************************
// ENDE - Funktionen für CMS Seiten
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Image Verwaltung
// *****************************************************************************

function showImageVerwaltung() {
  // Für individual User Upload bei Haupt Bild Menü verbergen
  $('.vFrontImageUploaderWindowInhaltOnIndividualUserMM').hide();
  
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBigImageVerwaltung').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigImageVerwaltungInhalt').html('');
  $('#vFrontCenterWindowBigImageVerwaltungInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigImageVerwaltungHeadInhalt').html('Bilder Verwaltung');
  $('#vFrontOverlayFour').show();
  $('#vFrontCenterWindowBigFileUploadBtn').show();
  $('#vFrontCenterWindowBigImageVerwaltung').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBilderVerwaltung', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigImageVerwaltungInhalt').html(data);
      initMediaVerwaltungPic();
      initMediaVerwaltungKat();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showImageVerwaltungOnlyPicLoad() {
  $('.vFrontImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBilderVerwaltungOnlyPicLoad', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontImgVerwaltHolder').html(data);
      initMediaVerwaltungPic();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initMediaVerwaltungPic() {
  $('.vFrontImgVerwaltHolder').selectable({
    filter: ".vFrontImgElement",
    cancel: ".vFrontVerwPicElemShow, .vFrontVerwPicElemChange, .vFrontVerwPicElemDel",
    stop: function(event, ui) {
      setMediaVerwaltungOnSelectButtons();
    },
    create: function(event, ui) {
      setBigWindowOnSelectedImgButtonHide();
    }
  });
  
  $('.vFrontVerwPicElemShow').click(function() {
    $.fancybox({
      href : $(this).attr('data-img')
    });
  });

  $('.vFrontVerwPicElemChange').click(function() {
    var picChangeNowID = $(this).attr('id').replace('picChange', '');
    showMediaPicOnceChangeWindow(picChangeNowID);
  });

  $('.vFrontVerwPicElemDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Bild wirklich löschen?');
    if (checkerDel == true) {
      var picDelNowID = $(this).attr('id').replace('picDel', '');
      var picElemAll = $(this).parent().parent();
      delThePicNow(picDelNowID, picElemAll);
    }
  });
}



function setMediaVerwaltungOnSelectButtons() {
  var selectCount = $('.vFrontImgVerwaltHolder > .ui-selected');
  if (selectCount.length > 0) {
    $('#vFrontCenterWindowBigFilesTransportBtn').show();
    $('#vFrontCenterWindowBigFilesDelMoreBtn').show();
  }
  else {
    $('#vFrontCenterWindowBigFilesTransportBtn').hide();
    $('#vFrontCenterWindowBigFilesDelMoreBtn').hide();
  }
}



function setBigWindowOnSelectedImgButtonHide() {
  $('#vFrontCenterWindowBigFilesTransportBtn').hide();
  $('#vFrontCenterWindowBigFilesDelMoreBtn').hide();
}



function delThePicNow(picID, picElemContainer) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delCurentBildOnce', VCMS_POST_LANG: $('body').attr('data-lang'), _bildID: picID},
    success: function(data) {
      hideCmsIsLoading();
      showOkWindowNow('Das Bild wurde erfolgreich gelöscht');
      picElemContainer.fadeOut(300, function() {
        picElemContainer.remove();
      });
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



// Funktionen für Bilder Bearbeiten
// **********************************************************

function showMediaPicOnceChangeWindow(curPicId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Bild bearbeiten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showMediaPicOnceChangeWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicId: curPicId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initMediaPicOnceChangeWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initMediaPicOnceChangeWindow() {
  $('#vFrontSaveMediaPicBearOnce').click(function() {
    if (checkMediaPicOnceChangeData() == true) {
      saveMediaPicOnceChangeFileNow($(this).attr('data-id'));
    }
  });
}



function checkMediaPicOnceChangeData() {
  var errorTextPicChange = '';

  if ($('#vMediaPicFileName').val() == '') {
    errorTextPicChange += 'Bitte geben Sie einen Dateiname ein!<br />';
  }
  else if ($('#vMediaPicFileName').val() != '' && !checkPicFileNameValid($('#vMediaPicFileName').val())) {
    errorTextPicChange += 'Der Dateiname enthält ungültige Zeichen!<br />';
  }

  if (errorTextPicChange != '') {
    showErrorWindowNow(errorTextPicChange);
    return false;
  }
  else {
    return true;
  }
}



function checkPicFileNameValid(curFileName) {
  var validuriregex = /^[a-zA-Z0-9_-]+$/i;
  return validuriregex.test(curFileName);
}



function saveMediaPicOnceChangeFileNow(curPicId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveMediaPicOnceChangeFileNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicId: curPicId, _curFileName: $('#vMediaPicFileName').val()+$('#vMediaPicFileNameType').val(), _curFileAlt: $('#vMediaPicFileAlt').val(), _curFileTitle: $('#vMediaPicFileTitle').val()},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'exist') {
        showErrorWindowNow('Der Dateiname ist schon vorhanden!');
      }
      else if (data == 'ok') {
        closeCenterWindowSmallSettingsImgVerwalt();
        showImageVerwaltungOnlyPicLoad();
        showOkWindowNow('Das Bild wurde erfolgreich gespeichert.');
        setBigWindowOnSelectedImgButtonHide();
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************





// Funktionen für Bilder in Kategorie verschieben
// **********************************************************

function showBildVerwaltungFilesTransportWindow() {
  if (checkBildVerwaltungFilesTransport() == true) {
    showBildVerwaltungFilesTransportWindowNow();
  }
}



function showBildVerwaltungFilesTransportWindowNow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Bilder in andere Kategorie verschieben');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildVerwaltungFilesTransportWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initBildVerwaltungFilesTransportWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initBildVerwaltungFilesTransportWindow() {
  $('#vPicKatTransportKat').msDropdown();
  
  $('#vFrontSaveKatTransportPics').click(function() {
    if (checkBildVerwaltungFilesTransportWindowData() == true) {
      saveNewKatTransportPicsNow($('#vPicKatTransportKat').val());
    }
  });
}



function checkBildVerwaltungFilesTransportWindowData() {
  var errorTextPicKatT = '';

  if ($('#vPicKatTransportKat').val() == '') {
    errorTextPicKatT += 'Bitte wählen Sie eine Kategorie aus!<br />';
  }

  if (errorTextPicKatT != '') {
    showErrorWindowNow(errorTextPicKatT);
    return false;
  }
  else {
    return true;
  }
}



function checkBildVerwaltungFilesTransport() {
  var selectCountT = $('.vFrontImgVerwaltHolder > .ui-selected');
  if (selectCountT.length > 0) {
    return true;
  }
  else {
    showErrorWindowNow('Es sind keine Bilder ausgewählt.');
    return false;
  }
}



function saveNewKatTransportPicsNow(curKatId) {
  showCmsIsLoading();
  
  var selectCountT = $('.vFrontImgVerwaltHolder > .ui-selected');
  var aktCount = 0;
  var zwElemSelect = '';
  $.each(selectCountT, function() {
    aktCount = aktCount + 1;
    if (aktCount == 1) {
      zwElemSelect += $(this).attr('data-id');
    }
    else {
      zwElemSelect += ';'+$(this).attr('data-id');
    }
  });
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewKatTransportPicsNow', VCMS_POST_LANG: $('body').attr('data-lang'), _picElems: zwElemSelect, _curKatId: curKatId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        setBigWindowOnSelectedImgButtonHide();
        closeCenterWindowSmallSettingsImgVerwalt();
        $('.vFrontImgVerwaltHolder > .ui-selected').fadeOut(300, function() {
          $(this).remove();
        });
        showOkWindowNow('Die Bilder wurden erfolgreich verschoben.');
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************




// Funktionen für mehrere Bilder auf einmal löschen
// **********************************************************

function delMediaAllSelectedImagesNow() {
  var selectCountPics = $('.vFrontImgVerwaltHolder > .ui-selected');
  var aktCountPics = 0;
  var zwElemSelectPics = '';
  $.each(selectCountPics, function() {
    aktCountPics = aktCountPics + 1;
    if (aktCountPics == 1) {
      zwElemSelectPics += $(this).attr('data-id');
    }
    else {
      zwElemSelectPics += ';'+$(this).attr('data-id');
    }
  });
  
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delMediaAllSelectedImagesNow', VCMS_POST_LANG: $('body').attr('data-lang'), _picElems: zwElemSelectPics},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        setBigWindowOnSelectedImgButtonHide();
        $('.vFrontImgVerwaltHolder > .ui-selected').fadeOut(300, function() {
          $(this).remove();
        });
        showOkWindowNow('Die Bilder wurden erfolgreich gelöscht.');
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************




// Funktionen für Image Verwaltung Kategorien
// **********************************************************

function initMediaVerwaltungKat() {
  $('.vFrontKatElem').click(function(e) {
    if (!$(this).hasClass('vFrontKatElemActive') && $(e.target).attr('class') != 'vFrontKatElemChangeBtn' && $(e.target).attr('class') != 'vFrontKatElemDelBtn') {
      
      // Upload ausblenden bei Kategorie wechsel
      // *********************************************
      /*if (!$('#vFrontCenterWindowBigFileUploadBtn').hasClass('stateNo')) {
        $('#vFrontImageUploaderWindowInhalt').hide();
        $('#vFrontCenterWindowBigFileUploadBtn').removeClass('stateYes');
        $('#vFrontCenterWindowBigFileUploadBtn').addClass('stateNo');
      }*/
      // *********************************************
      
      unsetAllActivePicKatMenuPoints();
      setThisActivePicKatMenuPoint($(this));
      showPicKatChangePointLoader();
      showCurentPicKatImagesNow($(this).attr('data-id'));
      
      // Für individual User Upload bei Haupt Bild Menü verbergen und bei anderen anzeigen
      // ***************************************************************************************
      if ($(this).attr('data-id') == 0) {
        $('.vFrontImageUploaderWindowInhaltOnIndividualUserMM').hide();
      }
      else {
        $('.vFrontImageUploaderWindowInhaltOnIndividualUserMM').show();
      }
      // ***************************************************************************************
    }
  });
  
  $('.vFrontKatElemDelBtn').click(function() {
    var checkerDel = confirm('Möchten Sie die Kategorie wirklich löschen?');
    if (checkerDel == true) {
      delThisPicVerwaltungKategorie($(this).attr('data-id'));
    }
  });
  
  $('.vFrontKatElemChangeBtn').click(function() {
    showBildVerwaltungBerabeitenKategorieWindow($(this).attr('data-id'));
  });
  
  $('.vFrontUnterKatElemAllHolderToogleBtn').click(function() {
    if ($(this).hasClass('vFrontuKatIsOpen')) {
      $(this).removeClass('vFrontuKatIsOpen');
      $('#vFrontUnterKatElemAllHolderToogle'+$(this).attr('data-id')).hide();
    }
    else {
      $(this).addClass('vFrontuKatIsOpen');
      $('#vFrontUnterKatElemAllHolderToogle'+$(this).attr('data-id')).show();
    }
  });
}



function unsetAllActivePicKatMenuPoints() {
  $('.vFrontKatElem').removeClass('vFrontKatElemActive');
}



function setThisActivePicKatMenuPoint(curMenuPoint) {
  curMenuPoint.addClass('vFrontKatElemActive');
}



function showPicKatChangePointLoader() {
  $('.vFrontImgVerwaltHolder').html('');
  $('.vFrontImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
}



function showCurentPicKatImagesNow(curPicKatId) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurentPicKatImagesNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicKatId: curPicKatId},
    success: function(data) {
      $('.vFrontImgVerwaltHolder').html(data);
      initMediaVerwaltungPic();
      setBigWindowOnSelectedImgButtonHide();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showBildVerwaltungNewKategorieWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Neue Kategorie erstellen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildVerwaltungNewKategorieWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initBildVerwaltungNewKategorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initBildVerwaltungNewKategorieWindow() {
  $('#vPicKatFrmOberKat').msDropdown();
  
  $('#vFrontSaveNewPicKat').click(function() {
    if (checkBildVerwaltungKategorieWindowData() == true) {
      saveBildVerwaltungNewKatNow();
    }
  });
}



function showBildVerwaltungBerabeitenKategorieWindow(curKatId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Kategorie bearbeiten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildVerwaltungBerabeitenKategorieWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initBildVerwaltungBearbeitenKategorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initBildVerwaltungBearbeitenKategorieWindow() {
  $('#vPicKatFrmOberKat').msDropdown();
  
  $('#vFrontSaveBearbeitPicKat').click(function() {
    if (checkBildVerwaltungKategorieWindowData() == true) {
      saveBildVerwaltungBearbeiteteKatNow($(this).attr('data-id'));
    }
  });
}



function checkBildVerwaltungKategorieWindowData() {
  var errorTextPicKat = '';

  if ($('#vPicKatFrmName').val() == '') {
    errorTextPicKat += 'Bitte geben Sie einen Kategorie Name ein!<br />';
  }

  if (errorTextPicKat != '') {
    showErrorWindowNow(errorTextPicKat);
    return false;
  }
  else {
    return true;
  }
}



function saveBildVerwaltungNewKatNow() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveBildVerwaltungNewKatNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatName: $('#vPicKatFrmName').val(), _curKatParent: $('#vPicKatFrmOberKat').val()},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsImgVerwalt();
      reloadOnlyBildverwaltungKatNow(data);
      showCurentPicKatImagesNow(data);
      showOkWindowNow('Die Kategorie wurde erfolgreich erstellt.');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function saveBildVerwaltungBearbeiteteKatNow(curKatId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveBildVerwaltungBearbeiteteKatNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatName: $('#vPicKatFrmName').val(), _curKatId: curKatId, _curKatParent: $('#vPicKatFrmOberKat').val()},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsImgVerwalt();
      reloadOnlyBildverwaltungKatNow('');
      showOkWindowNow('Die Kategorie wurde erfolgreich gespeichert.');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function reloadOnlyBildverwaltungKatNow(activeKatId) {
  if (activeKatId != '') {
    var curKatId = 'vKatPicVerwId'+activeKatId;
  }
  else {
    var curKatId = $('.vFrontKatElemActive').attr('id');
  }
  
  $('.vFrontImgKatHolder').html('');
  $('.vFrontImgKatHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'reloadOnlyBildverwaltungKatNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontImgKatHolder').html(data);
      initMediaVerwaltungKat();
      if ($('#'+curKatId).length > 0) {
        unsetAllActivePicKatMenuPoints();
        $('#'+curKatId).addClass('vFrontKatElemActive');
      }
      else {
        showCurentPicKatImagesNow(0);
      }
      
      if ($('.vFrontKatElemActive').parent().hasClass('vFrontUnterKatElemAllHolderToogleBilder')) {
        var curToogleId = $('.vFrontKatElemActive').parent().attr('id').replace('vFrontUnterKatElemAllHolderToogle', '');
        $('.vFrontUnterKatElemAllHolderToogleBtn[data-id="'+curToogleId+'"]').click();
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delThisPicVerwaltungKategorie(curKatId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delThisPicVerwaltungKategorie', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        reloadOnlyBildverwaltungKatNow('');
        showOkWindowNow('Die Kategorie wurde erfolgreich gelöscht.');
      }
      else if (data == 'fehler') {
        showErrorWindowNow('Datenbank Fehler');
      }
      else if (data == 'not_empty') {
        showErrorWindowNow('Die Kategorie kann nicht gelöscht werden.<br />Es sind Bilder oder Unterkategorien in dieser Kategorie.');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************

// *****************************************************************************
// ENDE - Funktionen für Image Verwaltung
// *****************************************************************************






// *****************************************************************************
// ANFANG - Funktionen für Homepage Einstellungen Allgemein
// *****************************************************************************

function showHomepageSettings() {
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigHeadInhalt').html('Homepage Einstellungen');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowBig').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHomepageEinstellungen', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initHpSettingLeftMenu();
      initHpSeAllgemeinNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Homepage Einstellungen Allgemein
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Bildauswahl Window
// *****************************************************************************

function showWindowImageAuswahl(curDataFieldId, dataMultiPic) {
  var abstandLeft = ($(window).width() / 2) - (560 / 2);
  $('#vFrontCenterWindowImageAuswahl').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowImageAuswahlInhalt').html('');
  $('#vFrontCenterWindowImageAuswahlInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontOverlayThird').show();
  $('#vFrontCenterWindowImageAuswahl').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhalt', VCMS_POST_LANG: $('body').attr('data-lang'), _dataMultiPic: dataMultiPic},
    success: function(data) {
      $('#vFrontCenterWindowImageAuswahlInhalt').html(data);
      initImageAuswahlWindow(curDataFieldId, dataMultiPic);
      initImageAuswahlWindowKatSelect(curDataFieldId, dataMultiPic);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initImageAuswahlWindow(curDataFieldId, dataMultiPic) {
  if (dataMultiPic == true) {
    $('.vFrontAuswahlImgVerwaltHolder').selectable({
      filter: ".vFrontAuswahlImgElement"
    });
    
    $('.vFrontMultiPicAuswahlBtnMM').click(function() {
      var allSelectedElems = $(this).parent().find('.vFrontAuswahlImgElement.ui-selected');
      $.each(allSelectedElems, function() {
        if ($('#'+curDataFieldId).val() == '') {
          $('#'+curDataFieldId).val($(this).attr('data-id'));
        }
        else {
          $('#'+curDataFieldId).val($('#'+curDataFieldId).val()+';'+$(this).attr('data-id'));
        }
        var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
        curInhaltEl.append('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild"><img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
      });
      closeCenterWindowImageAuswahl();
    });
  }
  else {
    $('.vFrontAuswahlImgElement').dblclick(function() {
      $('#'+curDataFieldId).val($(this).attr('data-id'));
      var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
      curInhaltEl.html('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild"><img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
      closeCenterWindowImageAuswahl();
      
      /*if ($('#'+curDataFieldId).val() == '') {
        $('#'+curDataFieldId).val($(this).attr('data-id'));
      }
      else {
        $('#'+curDataFieldId).val($('#'+curDataFieldId).val()+';'+$(this).attr('data-id'));
      }
      var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
      curInhaltEl.append('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild"><img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
      closeCenterWindowImageAuswahl();*/
    });
  }
}



// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlWindowKatSelect(curDataFieldId, dataMultiPic) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    var curDataFieldIdR = curDataFieldId;
    var dataMultiPicR = dataMultiPic;
    
    showWindowImageAuswahlReload($(this).val(), curDataFieldIdR, dataMultiPicR);
  });
}



function showWindowImageAuswahlReload(curKatId, curDataFieldId, dataMultiPic) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  var curDataFieldIdR = curDataFieldId;
  var dataMultiPicR = dataMultiPic;
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initImageAuswahlWindow(curDataFieldIdR, dataMultiPicR);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************

// *****************************************************************************
// ENDE - Funktionen für Bildauswahl Window
// *****************************************************************************









// *****************************************************************************
// ANFANG - Funktionen für Datei Verwaltung
// *****************************************************************************

function showDateiVerwaltungNow() {
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBigDateiVerwaltung').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigDateiVerwaltungInhalt').html('');
  $('#vFrontCenterWindowBigDateiVerwaltungInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigDateiVerwaltungHeadInhalt').html('Datei Verwaltung');
  $('#vFrontOverlayFour').show();
  $('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').show();
  $('#vFrontCenterWindowBigDateiVerwaltung').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showDateiVerwaltungNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigDateiVerwaltungInhalt').html(data);
      initDateiVerwaltungDateien();
      initDateiVerwaltungKat();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initDateiVerwaltungDateien() {
  $('.vFrontImgVerwaltHolder').selectable({
    filter: ".vFrontImgElement",
    cancel: ".vFrontVerwPicElemShow, .vFrontVerwPicElemChange, .vFrontVerwPicElemDel, .vFrontVerwDateiElemUriShow",
    stop: function(event, ui) {
      setDateiVerwaltungOnSelectButtons();
    },
    create: function(event, ui) {
      setBigWindowOnSelectedDateiButtonHide();
    }
  });

  $('.vFrontVerwPicElemChange').click(function() {
    var picChangeNowID = $(this).attr('id').replace('picChange', '');
    showMediaDateiOnceChangeWindow(picChangeNowID);
  });

  $('.vFrontVerwPicElemDel').click(function() {
    var checkerDel = confirm('Möchten Sie die Datei wirklich löschen?');
    if (checkerDel == true) {
      var picDelNowID = $(this).attr('id').replace('picDel', '');
      var picElemAll = $(this).parent().parent();
      delTheDateiNow(picDelNowID, picElemAll);
    }
  });
  
  $('.vFrontVerwDateiElemUriShow').click(function() {
    showDateiVerwaltungElemCurUriInWindow($(this).attr('data-file'));
  });
}



function showDateiVerwaltungElemCurUriInWindow(uriStr) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Datei Url anzeigen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  var curWindowHtml = '<div class="vFrontSmallSeFrmHolder">';
  curWindowHtml += '<label for="vMediaPicFileName">Datei Url:</label><textarea id="vFrontOnlyForShowUriTextarea" name="vFrontOnlyForShowUriTextarea" style="width:405px; margin-top:5px; height:90px;" readonly="readonly">'+uriStr+'</textarea>';
  curWindowHtml += '</div>';
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curWindowHtml);
  
  $('#vFrontOnlyForShowUriTextarea').focus(function() {
    this.select();
  });
}



function showDateiVerwaltungOnlyDateiLoad() {
  $('.vFrontImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showDateiVerwaltungOnlyDateiLoad', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontImgVerwaltHolder').html(data);
      initDateiVerwaltungDateien();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




function setDateiVerwaltungOnSelectButtons() {
  var selectCount = $('.vFrontImgVerwaltHolder > .ui-selected');
  if (selectCount.length > 0) {
    $('#vFrontCenterWindowBigDateiVerwaltFilesTransportBtn').show();
    $('#vFrontCenterWindowBigDateiVerwaltFilesDelMoreBtn').show();
  }
  else {
    $('#vFrontCenterWindowBigDateiVerwaltFilesTransportBtn').hide();
    $('#vFrontCenterWindowBigDateiVerwaltFilesDelMoreBtn').hide();
  }
}



function setBigWindowOnSelectedDateiButtonHide() {
  $('#vFrontCenterWindowBigDateiVerwaltFilesTransportBtn').hide();
  $('#vFrontCenterWindowBigDateiVerwaltFilesDelMoreBtn').hide();
}



function delTheDateiNow(picID, picElemContainer) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delCurentDateiOnce', VCMS_POST_LANG: $('body').attr('data-lang'), _dateiID: picID},
    success: function(data) {
      hideCmsIsLoading();
      showOkWindowNow('Die Datei wurde erfolgreich gelöscht');
      picElemContainer.fadeOut(300, function() {
        picElemContainer.remove();
      });
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




// Funktionen für Dateien Bearbeiten
// **********************************************************

function showMediaDateiOnceChangeWindow(curPicId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Datei bearbeiten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showMediaDateiOnceChangeWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curDateiId: curPicId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initMediaDateiOnceChangeWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initMediaDateiOnceChangeWindow() {
  $('#vFrontSaveMediaDateiBearOnce').click(function() {
    if (checkMediaDateiOnceChangeData() == true) {
      saveMediaDateiOnceChangeFileNow($(this).attr('data-id'));
    }
  });
}



function checkMediaDateiOnceChangeData() {
  var errorTextPicChange = '';

  if ($('#vMediaPicFileName').val() == '') {
    errorTextPicChange += 'Bitte geben Sie einen Dateiname ein!<br />';
  }
  else if ($('#vMediaPicFileName').val() != '' && !checkDateiFileNameValid($('#vMediaPicFileName').val())) {
    errorTextPicChange += 'Der Dateiname enthält ungültige Zeichen!<br />';
  }

  if (errorTextPicChange != '') {
    showErrorWindowNow(errorTextPicChange);
    return false;
  }
  else {
    return true;
  }
}



function checkDateiFileNameValid(curFileName) {
  var validuriregex = /^[a-zA-Z0-9_-]+$/i;
  return validuriregex.test(curFileName);
}



function saveMediaDateiOnceChangeFileNow(curPicId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveMediaDateiOnceChangeFileNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curDateiId: curPicId, _curFileName: $('#vMediaPicFileName').val()+$('#vMediaPicFileNameType').val()},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'exist') {
        showErrorWindowNow('Der Dateiname ist schon vorhanden!');
      }
      else if (data == 'ok') {
        closeCenterWindowSmallSettingsImgVerwalt();
        showDateiVerwaltungOnlyDateiLoad();
        showOkWindowNow('Die Datei wurde erfolgreich gespeichert.');
        setBigWindowOnSelectedDateiButtonHide();
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************




// Funktionen für mehrere Datein auf einmal löschen
// **********************************************************

function delMediaAllSelectedDateienNow() {
  var selectCountPics = $('.vFrontImgVerwaltHolder > .ui-selected');
  var aktCountPics = 0;
  var zwElemSelectPics = '';
  $.each(selectCountPics, function() {
    aktCountPics = aktCountPics + 1;
    if (aktCountPics == 1) {
      zwElemSelectPics += $(this).attr('data-id');
    }
    else {
      zwElemSelectPics += ';'+$(this).attr('data-id');
    }
  });
  
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delMediaAllSelectedDateienNow', VCMS_POST_LANG: $('body').attr('data-lang'), _picElems: zwElemSelectPics},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        setBigWindowOnSelectedDateiButtonHide();
        $('.vFrontImgVerwaltHolder > .ui-selected').fadeOut(300, function() {
          $(this).remove();
        });
        showOkWindowNow('Die Dateien wurden erfolgreich gelöscht.');
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************






// Funktionen für Dateien in Kategorie verschieben
// **********************************************************

function showDateiVerwaltungFilesTransportWindow() {
  if (checkDateiVerwaltungFilesTransport() == true) {
    showDateiVerwaltungFilesTransportWindowNow();
  }
}



function showDateiVerwaltungFilesTransportWindowNow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Dateien in andere Kategorie verschieben');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showDateiVerwaltungFilesTransportWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initDateiVerwaltungFilesTransportWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initDateiVerwaltungFilesTransportWindow() {
  $('#vPicKatTransportKat').msDropdown();
  
  $('#vFrontSaveKatTransportPics').click(function() {
    if (checkDateiVerwaltungFilesTransportWindowData() == true) {
      saveNewKatTransportDatasNow($('#vPicKatTransportKat').val());
    }
  });
}



function checkDateiVerwaltungFilesTransportWindowData() {
  var errorTextPicKatT = '';

  if ($('#vPicKatTransportKat').val() == '') {
    errorTextPicKatT += 'Bitte wählen Sie eine Kategorie aus!<br />';
  }

  if (errorTextPicKatT != '') {
    showErrorWindowNow(errorTextPicKatT);
    return false;
  }
  else {
    return true;
  }
}



function checkDateiVerwaltungFilesTransport() {
  var selectCountT = $('.vFrontImgVerwaltHolder > .ui-selected');
  if (selectCountT.length > 0) {
    return true;
  }
  else {
    showErrorWindowNow('Es sind keine Dateien ausgewählt.');
    return false;
  }
}



function saveNewKatTransportDatasNow(curKatId) {
  showCmsIsLoading();
  
  var selectCountT = $('.vFrontImgVerwaltHolder > .ui-selected');
  var aktCount = 0;
  var zwElemSelect = '';
  $.each(selectCountT, function() {
    aktCount = aktCount + 1;
    if (aktCount == 1) {
      zwElemSelect += $(this).attr('data-id');
    }
    else {
      zwElemSelect += ';'+$(this).attr('data-id');
    }
  });
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewKatTransportDatasNow', VCMS_POST_LANG: $('body').attr('data-lang'), _dateiElems: zwElemSelect, _curKatId: curKatId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        setBigWindowOnSelectedDateiButtonHide();
        closeCenterWindowSmallSettingsImgVerwalt();
        $('.vFrontImgVerwaltHolder > .ui-selected').fadeOut(300, function() {
          $(this).remove();
        });
        showOkWindowNow('Die Dateien wurden erfolgreich verschoben.');
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************







// Funktionen für Datei Verwaltung Kategorien
// **********************************************************

function initDateiVerwaltungKat() {
  $('.vFrontKatElem').click(function(e) {
    if (!$(this).hasClass('vFrontKatElemActive') && $(e.target).attr('class') != 'vFrontKatElemChangeBtn' && $(e.target).attr('class') != 'vFrontKatElemDelBtn') {
      
      // Upload ausblenden bei Kategorie wechsel
      // *********************************************
      /*if (!$('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').hasClass('stateNo')) {
        $('#vFrontDateiVerwaltUploaderWindowInhalt').hide();
        $('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').removeClass('stateYes');
        $('#vFrontCenterWindowBigDateiVerwaltFileUploadBtn').addClass('stateNo');
      }*/
      // *********************************************
      
      unsetAllActiveDateiKatMenuPoints();
      setThisActiveDateiKatMenuPoint($(this));
      showDateiKatChangePointLoader();
      showCurentDateiKatDateienNow($(this).attr('data-id'));
    }
  });
  
  $('.vFrontKatElemDelBtn').click(function() {
    var checkerDel = confirm('Möchten Sie die Kategorie wirklich löschen?');
    if (checkerDel == true) {
      delThisDateiVerwaltungKategorie($(this).attr('data-id'));
    }
  });
  
  $('.vFrontKatElemChangeBtn').click(function() {
    showDateiVerwaltungBerabeitenKategorieWindow($(this).attr('data-id'));
  });
  
  $('.vFrontUnterKatElemAllHolderToogleBtn').click(function() {
    if ($(this).hasClass('vFrontuKatIsOpen')) {
      $(this).removeClass('vFrontuKatIsOpen');
      $('#vFrontUnterKatElemAllHolderToogle'+$(this).attr('data-id')).hide();
    }
    else {
      $(this).addClass('vFrontuKatIsOpen');
      $('#vFrontUnterKatElemAllHolderToogle'+$(this).attr('data-id')).show();
    }
  });
}



function unsetAllActiveDateiKatMenuPoints() {
  $('.vFrontKatElem').removeClass('vFrontKatElemActive');
}



function setThisActiveDateiKatMenuPoint(curMenuPoint) {
  curMenuPoint.addClass('vFrontKatElemActive');
}



function showDateiKatChangePointLoader() {
  $('.vFrontImgVerwaltHolder').html('');
  $('.vFrontImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
}



function showCurentDateiKatDateienNow(curPicKatId) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurentDateiKatDateienNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicKatId: curPicKatId},
    success: function(data) {
      $('.vFrontImgVerwaltHolder').html(data);
      initDateiVerwaltungDateien();
      setBigWindowOnSelectedDateiButtonHide();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




function showDateiVerwaltungNewKategorieWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Neue Kategorie erstellen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showDateiVerwaltungNewKategorieWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initDateiVerwaltungNewKategorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initDateiVerwaltungNewKategorieWindow() {
  $('#vPicKatFrmOberKat').msDropdown();
  
  $('#vFrontSaveNewPicKat').click(function() {
    if (checkDateiVerwaltungKategorieWindowData() == true) {
      saveDateiVerwaltungNewKatNow();
    }
  });
}



function checkDateiVerwaltungKategorieWindowData() {
  var errorTextPicKat = '';

  if ($('#vPicKatFrmName').val() == '') {
    errorTextPicKat += 'Bitte geben Sie einen Kategorie Name ein!<br />';
  }

  if (errorTextPicKat != '') {
    showErrorWindowNow(errorTextPicKat);
    return false;
  }
  else {
    return true;
  }
}



function saveDateiVerwaltungNewKatNow() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveDateiVerwaltungNewKatNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatName: $('#vPicKatFrmName').val(), _curKatParent: $('#vPicKatFrmOberKat').val()},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsImgVerwalt();
      reloadOnlyDateiverwaltungKatNow(data);
      showCurentDateiKatDateienNow(data);
      showOkWindowNow('Die Kategorie wurde erfolgreich erstellt.');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function reloadOnlyDateiverwaltungKatNow(activeKatId) {
  if (activeKatId != '') {
    var curKatId = 'vKatPicVerwId'+activeKatId;
  }
  else {
    var curKatId = $('.vFrontKatElemActive').attr('id');
  }
  
  $('.vFrontImgKatHolder').html('');
  $('.vFrontImgKatHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'reloadOnlyDateiverwaltungKatNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontImgKatHolder').html(data);
      initDateiVerwaltungKat();
      if ($('#'+curKatId).length > 0) {
        unsetAllActiveDateiKatMenuPoints();
        $('#'+curKatId).addClass('vFrontKatElemActive');
      }
      else {
        showCurentDateiKatDateienNow(0);
      }
      
      if ($('.vFrontKatElemActive').parent().hasClass('vFrontUnterKatElemAllHolderToogleDateien')) {
        var curToogleId = $('.vFrontKatElemActive').parent().attr('id').replace('vFrontUnterKatElemAllHolderToogle', '');
        $('.vFrontUnterKatElemAllHolderToogleBtn[data-id="'+curToogleId+'"]').click();
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delThisDateiVerwaltungKategorie(curKatId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delThisDateiVerwaltungKategorie', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == 'ok') {
        reloadOnlyDateiverwaltungKatNow('');
        showOkWindowNow('Die Kategorie wurde erfolgreich gelöscht.');
      }
      else if (data == 'fehler') {
        showErrorWindowNow('Datenbank Fehler');
      }
      else if (data == 'not_empty') {
        showErrorWindowNow('Die Kategorie kann nicht gelöscht werden.<br />Es sind Dateien oder Unterkategorien in dieser Kategorie.');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showDateiVerwaltungBerabeitenKategorieWindow(curKatId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Kategorie bearbeiten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showDateiVerwaltungBerabeitenKategorieWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initDateiVerwaltungBearbeitenKategorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initDateiVerwaltungBearbeitenKategorieWindow() {
  $('#vPicKatFrmOberKat').msDropdown();
  
  $('#vFrontSaveBearbeitDateiKat').click(function() {
    if (checkDateiVerwaltungKategorieWindowData() == true) {
      saveDateiVerwaltungBearbeiteteKatNow($(this).attr('data-id'));
    }
  });
}



function saveDateiVerwaltungBearbeiteteKatNow(curKatId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveDateiVerwaltungBearbeiteteKatNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatName: $('#vPicKatFrmName').val(), _curKatId: curKatId, _curKatParent: $('#vPicKatFrmOberKat').val()},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsImgVerwalt();
      reloadOnlyDateiverwaltungKatNow('');
      showOkWindowNow('Die Kategorie wurde erfolgreich gespeichert.');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// **********************************************************

// *****************************************************************************
// ENDE - Funktionen für Datei Verwaltung
// *****************************************************************************