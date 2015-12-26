/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/





// Element Arten
// eigen           == Eigenes Element
// eigenBild       == Eigenes Element Bild
// bild            == Bildelement
// tinymce         == Im Editor ((TinyMCE)

function showCmsLinkWindow(curElemObj, elemArt) {
  showCmsLinkWindowNow();
  var curAjaxData = {_art: 'showCmsLinkWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _elemArt: elemArt};
  if (elemArt == 'eigen') {
    curAjaxData['_selemID'] = curElemObj.attr('id').replace('elemLinkID-', '');
  }
  else if (elemArt == 'eigenBild') {
    curAjaxData['_selemID'] = curElemObj.attr('data-id');
    curAjaxData['_elemPicNum'] = curElemObj.attr('data-num');
  }
  else if (elemArt == 'bild') {
    curAjaxData['_selemID'] = curElemObj.attr('id').replace('elemLinkID-', '');
  }
  showCurentCmsLinkWindowData(curElemObj, elemArt, curAjaxData);
}



function showCmsLinkWindowNow() {
  var abstandLeft = ($(window).width() / 2) - (415 / 2);
  $('#vFrontCenterWindowSmall').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallInhalt').html('');
  $('#vFrontCenterWindowSmallInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  if ($('body').attr('data-lang') != '') {
    $('#vFrontCenterWindowSmallHeadInhalt').html('Link auswahl (Spracheintrag)');
  }
  else {
    $('#vFrontCenterWindowSmallHeadInhalt').html('Link auswahl');
  }
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmall').show();
}



function showCurentCmsLinkWindowData(curElemObj, elemArt, curAjaxData) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: curAjaxData,
    success: function(data) {
      $('#vFrontCenterWindowSmallInhalt').html(data);
      initCmsLinkWindowFunctions(curElemObj, elemArt);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initCmsLinkWindowFunctions(curElemObj, elemArt) {
  $('#linkingTarget').msDropdown();
  
  $('.vFrontLinkingArtMenuPoint').click(function() {
    $('.vFrontLinkingArtMenuPoint').removeClass('vFrontActiveArtPoint');
    $(this).addClass('vFrontActiveArtPoint');
  });
  
  $('#linkingDelBtn').click(function() {
    var curLinkingElemID = $(this).attr('data-id');
    delTheLinkInElement(curLinkingElemID, curElemObj);
  });
  $('#linkingSaveBtn').click(function() {
    if (checkLinkUserDataNow()) {
      var curLinkingElemID = $(this).attr('data-id');
      saveTheNewLinkInElement(curLinkingElemID, curElemObj);
    }
  });
  
  // MM - Für Linking Elements bei anderer Sprache
  // ***************************************************************************
  $('#linkingDelBtnOnLangMM').click(function() {
    var curLinkingOnLangElemID = $(this).attr('data-id');
    delTheLinkInElementOnLangMM(curLinkingOnLangElemID, curElemObj);
  });
  $('#linkingSaveBtnOnLangMM').click(function() {
    if (checkLinkUserDataNow()) {
      var curLinkingOnLangElemID = $(this).attr('data-id');
      saveTheNewLinkInElementOnLangMM(curLinkingOnLangElemID, curElemObj);
    }
  });
  // ***************************************************************************
  
  
  $('.vFrontLinkingArtMenuPoint').click(function() {
    hideAllLinkingArtForms();
    showCurentLinkingArtForms($(this).attr('data-id'));
  });
  
  
  $('#linkingShowSeitenAuswahlWinBtn').click(function() {
    showLinkingSeitenauswahlWin();
  });
  $('#linkingShowBildAuswahlWinBtn').click(function() {
    showLinkingBildauswahlWin();
  });
  $('#linkingShowDateiAuswahlWinBtn').click(function() {
    showLinkingDateiauswahlWin();
  });
  
  
  $('#linkIsInLightbox').click(function() {
    if ($(this).is(':checked')) {
      $('#linkIsInLightboxWidthHeightFormsHolder').stop().slideDown();
    }
    else {
      $('#linkIsInLightboxWidthHeightFormsHolder').stop().slideUp();
    }
  });
}



function checkLinkUserDataNow() {
  var linkDataError = '';
  
  if ($('.vFrontActiveArtPoint').attr('data-id') == 'normal') {
    if ($('#linkingLink').val() == '') {
      linkDataError += 'Bitte geben Sie einen Link ein!<br />';
    }
  }
  
  if ($('.vFrontActiveArtPoint').attr('data-id') == 'seite') {
    if ($('#linkingLink').val() == '') {
      linkDataError += 'Bitte wählen Sie eine Seite aus!<br />';
    }
  }
  
  if ($('.vFrontActiveArtPoint').attr('data-id') == 'bild') {
    if ($('#linkingLink').val() == '') {
      linkDataError += 'Bitte wählen Sie eine Bild aus!<br />';
    }
  }
  
  if ($('.vFrontActiveArtPoint').attr('data-id') == 'datei') {
    if ($('#linkingLink').val() == '') {
      linkDataError += 'Bitte wählen Sie eine Datei aus!<br />';
    }
  }
  
  if (linkDataError != '') {
    showErrorWindowNow(linkDataError);
    return false;
  }
  else {
    return true;
  }
}



function saveTheNewLinkInElement(curLinkingElemID, btnObj) {
  showCmsIsLoading();
  
  var linkIsInLightboxAttr = '';
  if ($('#linkIsInLightbox').is(':checked')) {
    linkIsInLightboxAttr = $('#linkIsInLightbox').val();
  }
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveLinkInElementNow', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curLinkingElemID, _linkingLink: $('#linkingLink').val(), _linkingTarget: $('#linkingTarget').val(), _linkingClassName: $('#linkingClassName').val(), _linkArt: $('.vFrontActiveArtPoint').attr('data-id'), _linkIsInLightbox: linkIsInLightboxAttr, _linkInLightboxWidth: $('#linkInLightboxWidth').val(), _linkInLightboxHeight: $('#linkInLightboxHeight').val()},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmall();
        btnObj.addClass('vLinkStateAktiv');
        showOkWindowNow('Der Link wurde erfolgreich gespeichert!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delTheLinkInElement(curLinkingElemID, btnObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delLinkInElementNow', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curLinkingElemID},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmall();
        btnObj.removeClass('vLinkStateAktiv');
        showOkWindowNow('Der Link wurde erfolgreich gelöscht!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



// MM - Für Linking Elements bei anderer Sprache
// *****************************************************************************
function saveTheNewLinkInElementOnLangMM(curLinkingElemID, btnObj) {
  showCmsIsLoading();
  
  var linkIsInLightboxAttr = '';
  if ($('#linkIsInLightbox').is(':checked')) {
    linkIsInLightboxAttr = $('#linkIsInLightbox').val();
  }
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveTheNewLinkInElementOnLangMM', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curLinkingElemID, _linkingLink: $('#linkingLink').val(), _linkingTarget: $('#linkingTarget').val(), _linkingClassName: $('#linkingClassName').val(), _linkArt: $('.vFrontActiveArtPoint').attr('data-id'), _linkIsInLightbox: linkIsInLightboxAttr, _linkInLightboxWidth: $('#linkInLightboxWidth').val(), _linkInLightboxHeight: $('#linkInLightboxHeight').val()},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmall();
        btnObj.addClass('vLinkStateAktiv');
        showOkWindowNow('Der Link wurde erfolgreich gespeichert!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delTheLinkInElementOnLangMM(curLinkingElemID, btnObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delTheLinkInElementOnLangMM', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curLinkingElemID},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmall();
        btnObj.removeClass('vLinkStateAktiv');
        showOkWindowNow('Der Link wurde erfolgreich gelöscht!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Linking Art umschaltungen
// *****************************************************************************

function showCurentLinkingArtForms(curArtName) {
  if (curArtName == 'normal') {
    $('.linkingLinkNormalAnzeige').show();
  }
  else if (curArtName == 'seite') {
    $('.linkingLinkSeitenAnzeige').show();
  }
  else if (curArtName == 'bild') {
    $('.linkingLinkBildAnzeige').show();
  }
  else if (curArtName == 'datei') {
    $('.linkingLinkDateiAnzeige').show();
  }
}



function hideAllLinkingArtForms() {
  $('#linkingLink').val('');
  $('#linkingShowSeitenAuswahlWinText').html('');
  $('#linkingShowBildAuswahlWinText').html('');
  $('#linkingShowDateiAuswahlWinText').html('');
  $('#linkingShowSeitenAuswahlWinBtn').html('auswählen');
  $('#linkingShowBildAuswahlWinBtn').html('auswählen');
  $('#linkingShowDateiAuswahlWinBtn').html('auswählen');
  $('.linkingLinkNormalAnzeige').hide();
  $('.linkingLinkSeitenAnzeige').hide();
  $('.linkingLinkBildAnzeige').hide();
  $('.linkingLinkDateiAnzeige').hide();
}

// *****************************************************************************
// ENDE - Funktionen für Linking Art umschaltungen
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Linking Seitenauswahl
// *****************************************************************************

function showLinkingSeitenauswahlWin() {
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
      initLinkingSeitenauswahlWin();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showLinkingSeitenauswahlWinReloadMM(nartID) {
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingSeitenauswahlWinReloadMM', VCMS_POST_LANG: $('body').attr('data-lang'), _naviArtID: nartID},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initLinkingSeitenauswahlWin();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initLinkingSeitenauswahlWin() {
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').msDropDown();
  
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').change(function() {
    showLinkingSeitenauswahlWinReloadMM($(this).val());
  });
  
  $('.vFrontBaumElem').click(function() {
    $('#linkingLink').val($(this).attr('data-id'));
    $('#linkingShowSeitenAuswahlWinText').html($(this).attr('data-name'));
    $('#linkingShowSeitenAuswahlWinBtn').html('ändern');
    closeCenterWindowAllgemeinCMSWindow();
  });
}

// *****************************************************************************
// ENDE - Funktionen für Linking Seitenauswahl
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Linking Bildauswahl
// *****************************************************************************

function showLinkingBildauswahlWin() {
  var abstandLeft = ($(window).width() / 2) - (560 / 2);
  $('#vFrontCenterWindowImageAuswahl').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowImageAuswahlInhalt').html('');
  $('#vFrontCenterWindowImageAuswahlInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowImageAuswahlHeadInhalt').html('Bild auswählen');
  $('#vFrontOverlayThird').show();
  $('#vFrontCenterWindowImageAuswahl').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingBildauswahlWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowImageAuswahlInhalt').html(data);
      initLinkingImageAuswahlWindow();
      initLinkingImageAuswahlWindowKatSelect();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initLinkingImageAuswahlWindow() {
  $('.vFrontAuswahlImgElement').click(function() {
    $('#linkingLink').val($(this).attr('data-id'));
    $('#linkingShowBildAuswahlWinText').html($(this).attr('data-name'));
    $('#linkingShowBildAuswahlWinBtn').html('ändern');
    closeCenterWindowImageAuswahl();
  });
}



function initLinkingImageAuswahlWindowKatSelect() {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    showLinkingBildauswahlWinReload($(this).val());
  });
}



function showLinkingBildauswahlWinReload(curKatId) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingBildauswahlWinReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initLinkingImageAuswahlWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Linking Bildauswahl
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Linking Dateiauswahl
// *****************************************************************************

function showLinkingDateiauswahlWin() {
  var abstandLeft = ($(window).width() / 2) - (560 / 2);
  $('#vFrontCenterWindowImageAuswahl').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowImageAuswahlInhalt').html('');
  $('#vFrontCenterWindowImageAuswahlInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowImageAuswahlHeadInhalt').html('Datei auswählen');
  $('#vFrontOverlayThird').show();
  $('#vFrontCenterWindowImageAuswahl').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingDateiauswahlWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowImageAuswahlInhalt').html(data);
      initLinkingDateiAuswahlWindow();
      initLinkingDateiAuswahlWindowKatSelect();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initLinkingDateiAuswahlWindow() {
  $('.vFrontAuswahlImgElement').click(function() {
    $('#linkingLink').val($(this).attr('data-id'));
    $('#linkingShowDateiAuswahlWinText').html($(this).attr('data-name'));
    $('#linkingShowDateiAuswahlWinBtn').html('ändern');
    closeCenterWindowImageAuswahl();
  });
}



function initLinkingDateiAuswahlWindowKatSelect() {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    showLinkingDateiauswahlWinReload($(this).val());
  });
}



function showLinkingDateiauswahlWinReload(curKatId) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingDateiauswahlWinReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initLinkingDateiAuswahlWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Linking Dateiauswahl
// *****************************************************************************