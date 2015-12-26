/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2015                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



function showEmpfehlungsmanagerAdminWindow() {
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigHeadInhalt').html('Empfehlungsmanager Admin');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowBig').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showEmpfehlungsmanagerAdminWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initEmpfehlungsmanagerAdminWindowMenu();
      initEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminEmpfehler');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initEmpfehlungsmanagerAdminWindowMenu() {
  $('.vFrontEmpfehlungsManagerAdminMenuPoint').click(function() {
    try {
      for (var cIII = 0; cIII < curEmpfManagerMailFieldInstanzEditors.length; cIII++) {
        curEmpfManagerMailFieldInstanzEditors[cIII].destroy();
      }
      curEmpfManagerMailFieldInstanzEditorsCounters = -1;
    }
    catch(e) {
      //console.log(e);
    }
    
    if (!$(this).hasClass('vFrontActiveEmpfManagerPoint')) {
      unsetAllActiveEmpfehlungsmanagerAdminMenuPoints();
      setThisActiveEmpfehlungsmanagerAdminMenuPoint($(this));
      showEmpfehlungsmanagerAdminWindowCurInhalt($(this).attr('id'));
    }
  });
}



function unsetAllActiveEmpfehlungsmanagerAdminMenuPoints() {
  $('.vFrontEmpfehlungsManagerAdminMenuPoint').removeClass('vFrontActiveEmpfManagerPoint');
}



function setThisActiveEmpfehlungsmanagerAdminMenuPoint(curMenuEMAPoint) {
  curMenuEMAPoint.addClass('vFrontActiveEmpfManagerPoint');
}



function showEmpfehlungsmanagerAdminPointLoader() {
  $('.vFrontSiteSettingInhaltHolder').html('');
  $('.vFrontSiteSettingInhaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
}




function showEmpfehlungsmanagerAdminWindowCurInhalt(curMenuIdName) {
  showEmpfehlungsmanagerAdminPointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showEmpfehlungsmanagerAdminWindowCurInhaltReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curMenuIdName: curMenuIdName},
    success: function(data) {
      $('.vFrontSiteSettingInhaltHolder').html(data);
      initEmpfehlungsmanagerAdminWindowCurInhalt(curMenuIdName);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




function initEmpfehlungsmanagerAdminWindowCurInhalt(curMenuIdName) {
  if (curMenuIdName == 'vFrontEmpfehlungsMangerAdminAllgemein') {
    initEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen();
  }
  else if (curMenuIdName == 'vFrontEmpfehlungsMangerAdminGeschenke') {
    initEmpfehlungsmanagerAdminWindowGeschenke();
  }
  else if (curMenuIdName == 'vFrontEmpfehlungsMangerAdminAnfragen') {
    initEmpfehlungsmanagerAdminWindowAnfragenOnlyTop();
    initEmpfehlungsmanagerAdminWindowAnfragenOnlyList();
  }
  else if (curMenuIdName == 'vFrontEmpfehlungsMangerAdminEmpfehler') {
    initEmpfehlungsmanagerAdminWindowEmpfehler();
  }
  else if (curMenuIdName == 'vFrontEmpfehlungsMangerAdminExport') {
    initEmpfehlungsmanagerAdminWindowMailExport();
  }
}







// *****************************************************************************
// ANFANG - Funktionen für Empfehlungsmanager - Allgemeine Einstellungen
// *****************************************************************************

var curEmpfManagerMailFieldInstanzEditors = new Array();
var curEmpfManagerMailFieldInstanzEditorsCounters = -1;

function initEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen() {
  $('#vFrontSaveEmpfehlungsmanagerAllgemeinBtn').click(function() {
    if (checkSaveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungenData()) {
      saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen();
    }
  });
  
  
  $('#vFrontEmaFbAppPostBildChangeBtnSy').click(function() {
    showWindowImageAuswahlEmpfMangaerFBPostPicMM($('#vFrontEmaFbAppPostBild'));
  });
  
  
  $('#vFrontEmaMailTextDomainGeneriert, #vFrontEmaMailTextAnfrageErhalten, #vFrontEmaMailTextBuchungErhalten').tinymce({
    menubar: false,
    language: 'de',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code",
    file_browser_callback: function(field_name, url, type, win) {

    },
    init_instance_callback : function(editor) {
      // Wird in der Datei functions.js in der Funktion closeCenterWindowBig() zerstört
      // Und in dieser Datei in der Funktion initEmpfehlungsmanagerAdminWindowMenu() im Click Event zerstört
      // ******************************************************************************************************
      curEmpfManagerMailFieldInstanzEditorsCounters = curEmpfManagerMailFieldInstanzEditorsCounters + 1;
      curEmpfManagerMailFieldInstanzEditors[curEmpfManagerMailFieldInstanzEditorsCounters] = editor;
    }
  });
}



function checkSaveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungenData() {
  var errorText = '';
  
  if ($('#vFrontEmaMail').val() == '') {
    errorText += 'Bitte geben Sie Ihre E-Mail Adresse ein.<br />';
  }
  if ($('#vFrontEmaMail').val() != '' && !checkValidMailAdressSysEmpfehlungsmanagerAllgemeinForms($('#vFrontEmaMail').val())) {
    errorText += 'Bitte geben Sie eine gültige E-Mail Adresse ein.<br />';
  }
  if ($('#vFrontEmaKontaktSiteId').val() == '') {
    errorText += 'Bitte geben Sie die Kontaktformular Seiten ID ein.<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function checkValidMailAdressSysEmpfehlungsmanagerAllgemeinForms(adress) {
  var validmailregex = /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.([a-z][a-z]+)|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i;
  return validmailregex.test(adress);
}



function saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'saveEmpfehlungsmanagerAdminWindowAllgemeineEinstellungen', VCMS_POST_LANG: $('body').attr('data-lang'), _empfMaMail: $('#vFrontEmaMail').val(), _empfMaKontaktSiteId: $('#vFrontEmaKontaktSiteId').val(), _empfMaFirmaName: $('#vFrontEmaFirmaName').val(), _empfMaRabattText: $('#vFrontEmaRabattText').val(), _empfMaGeschenkeRules: $('#vFrontEmaGeschenkeRules').val(), _empfMaFbAppPostSmallDesc: $('#vFrontEmaFbAppPostSmallDesc').val(), _empfMaFbAppPostLongDesc: $('#vFrontEmaFbAppPostLongDesc').val(), _empfMaFbAppPostBild: $('#vFrontEmaFbAppPostBild').val(), _empfMaTextZwEmpfNameUndFirma: $('#vFrontEmaTextZwEmpfNameUndFirma').val(), _empfMaGratuliereText: $('#vFrontEmaGratuliereText').val(), _empfMaEmpfehlenWeiterText: $('#vFrontEmaEmpfehlenWeiterText').val(), _empfMaMailTextDomainGeneriert: $('#vFrontEmaMailTextDomainGeneriert').val(), _empfMaMailTextAnfrageErhalten: $('#vFrontEmaMailTextAnfrageErhalten').val(), _empfMaMailTextBuchungErhalten: $('#vFrontEmaMailTextBuchungErhalten').val()},
    success: function(data) {
      showOkWindowNow('Das Einstellungen wurden erfolgreich gespeichert.');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Empfehlungsmanager - Allgemeine Einstellungen
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Empfehlungsmanager - Geschenke
// *****************************************************************************

function initEmpfehlungsmanagerAdminWindowGeschenke() {
  $('#vFrontNeuesEmpfManagerGeschenkBtn').click(function() {
    var abstandLeft = ($(window).width() / 2) - (500 / 2);
    $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');

    $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
    $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
    $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Neues Geschenk erstellen');
    $('#vFrontOverlayFive').show();
    $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
    
    var curHtmlIn = '<div class="vFrontSmallSeFrmHolder">';
    curHtmlIn += '<label for="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm">Anzahl Buchungen:</label>';
    curHtmlIn += '<input style="width:150px;" type="text" id="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm" name="vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm" />';
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    curHtmlIn += '<label style="vertical-align:top;" for="vEmpfehlungsmanagerGeschenkeTextFrm">Text:</label>';
    curHtmlIn += '<textarea style="width:268px; height:80px;" id="vEmpfehlungsmanagerGeschenkeTextFrm" name="vEmpfehlungsmanagerGeschenkeTextFrm"></textarea>';
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
    curHtmlIn += '<input type="submit" id="vEmpfehlungsmanagerGeschenkeNewSaveBtn" value="Speichern" />';
    curHtmlIn += '</div>';

    $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curHtmlIn);
    initNewEmpfehlungsmanagerAdminWindowGeschenkeSaveNow();
  });
  
  
  
  $('.vFrontEmpfAuflistungLiGeschenkeChange').click(function() {
    showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($(this).attr('data-id'));
  });
  
  
  
  $('.vFrontEmpfAuflistungLiGeschenkeDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Geschenk wirklich löschen?');
    if (checkerDel == true) {
      delEmpfehlungsmanagerAdminThisGeschenkNow($(this).attr('data-id'));
    }
  });
}



function initNewEmpfehlungsmanagerAdminWindowGeschenkeSaveNow() {
  $('#vEmpfehlungsmanagerGeschenkeNewSaveBtn').click(function() {
    if (checkEmpfehlungsManagerNewGeschenkDataFrmOnSend()) {
      saveEmpfehlungsManagerNewGeschenkOnSendNow();
    }
  });
  
  $('#vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm').keyup(function(e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
    //$(this).val($(this).val().replace(/[^\d]/,''));
  });
}



function checkEmpfehlungsManagerNewGeschenkDataFrmOnSend() {
  var errorText = '';
  
  if ($('#vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm').val() == '') {
    errorText += 'Bitte geben Sie die Anzahl Buchungen ein.<br />';
  }
  if ($('#vEmpfehlungsmanagerGeschenkeTextFrm').val() == '') {
    errorText += 'Bitte geben Sie einen Text ein.<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function saveEmpfehlungsManagerNewGeschenkOnSendNow() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'saveEmpfehlungsManagerNewGeschenkOnSendNow', VCMS_POST_LANG: $('body').attr('data-lang'), _anzahlBuchungen: $('#vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm').val(), _geschenkText: $('#vEmpfehlungsmanagerGeschenkeTextFrm').val()},
    success: function(data) {
      closeCenterWindowSmallSettingsImgVerwalt();
      showEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminGeschenke');
      showOkWindowNow('Das Geschenk wurde erfolgreich gespeichert.');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delEmpfehlungsmanagerAdminThisGeschenkNow(curGeschenkId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'delEmpfehlungsmanagerAdminThisGeschenkNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curGeschenkId: curGeschenkId},
    success: function(data) {
      showEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminGeschenke');
      showOkWindowNow('Das Geschenk wurde erfolgreich gelöscht.');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow(curGeschenkId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
    $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');

    $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
    $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
    $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Geschenk bearbeiten');
    $('#vFrontOverlayFive').show();
    $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showEmpfehlungsmanagerAdminWindowGeschenkeBearWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curGeschenkId: curGeschenkId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(data);
      initEmpfehlungsmanagerAdminWindowGeschenkeBearWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initEmpfehlungsmanagerAdminWindowGeschenkeBearWindow() {
  $('#vEmpfehlungsmanagerGeschenkeBearSaveBtn').click(function() {
    if (checkEmpfehlungsManagerNewGeschenkDataFrmOnSend()) {
      saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow($(this).attr('data-id'));
    }
  });
  
  
  $('#vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm').keyup(function(e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
    //$(this).val($(this).val().replace(/[^\d]/,''));
  });
}



function saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow(curGeschenkId) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'saveEmpfehlungsmanagerAdminWindowGeschenkeBearWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curGeschenkId: curGeschenkId, _anzahlBuchungen: $('#vEmpfehlungsmanagerGeschenkeAnzahlBuchungenFrm').val(), _geschenkText: $('#vEmpfehlungsmanagerGeschenkeTextFrm').val()},
    success: function(data) {
      closeCenterWindowSmallSettingsImgVerwalt();
      showEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminGeschenke');
      showOkWindowNow('Das Geschenk wurde erfolgreich gespeichert.');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Empfehlungsmanager - Geschenke
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Empfehlungsmanager - Empfehler
// *****************************************************************************

var setCurEmpfehlerToAnfrageClick = '';

function initEmpfehlungsmanagerAdminWindowEmpfehler() {
  $('.vFrontEmpfAuflistungLiEmpfehlerShowAnfragen').click(function() {
    setCurEmpfehlerToAnfrageClick = $(this).attr('data-id');
    $('#vFrontEmpfehlungsMangerAdminAnfragen').click();
  });
  
  $('.vFrontEmpfAuflistungLiEmpfehlerShowData').click(function() {
    showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow($(this).attr('data-id'));
  });
  
  $('.vFrontEmpfAuflistungLiEmpfehlerDelButtonMM').click(function() {
    var checkerDel = confirm('Möchten Sie den Empfehler wirklich löschen?\n\nACHTUNG es werden auch alle Anfrage Daten vom Empfehler gelöscht!\n\n');
    if (checkerDel == true) {
      delEmpfehlungsmanagerAdminThisEmpfehlerNow($(this).attr('data-id'));
    }
  });
  
  $('#vFrontEmpfAuflistungLiEmpfehlerSucheFrmOwnMM').on('input',function(e) {
    showCurentSearchEmpfehlerNow($(this).val());
  });
}



function showCurentSearchEmpfehlerNow(searchStr) {
  if (searchStr != '') {
    $('#vFrontEmpfAuflistungLiEmpfehlerHolderListSyMM > .vFrontEmpfAuflistungLiEmpfehler').hide();
    var allEmpfElems = $('#vFrontEmpfAuflistungLiEmpfehlerHolderListSyMM').find('> .vFrontEmpfAuflistungLiEmpfehler');
    $.each(allEmpfElems, function() {
      var curStrElem = $(this).find('.vFrontEmpfAuflistungLiEmpfehlerName').html();
      if (searchStringMM(curStrElem, searchStr) != -1) {
        $(this).show();
      }
    });
  }
  else {
    $('#vFrontEmpfAuflistungLiEmpfehlerHolderListSyMM > .vFrontEmpfAuflistungLiEmpfehler').show();
  }
}



function searchStringMM(curString, curFindStr) {
  return curString.toLowerCase().search(curFindStr);
}



function showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow(curEmpfId) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Empfehler Daten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showEmpfehlungsmanagerAdminWindowEmpfehlerDataWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curEmpfId: curEmpfId},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delEmpfehlungsmanagerAdminThisEmpfehlerNow(curEmpfId) {
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'delEmpfehlungsmanagerAdminThisEmpfehlerNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curEmpfId: curEmpfId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == true) {
        showOkWindowNow('Der Empfehler wurde erfolgreich gelöscht.');
        showEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminEmpfehler');
      }
      else {
        showErrorWindowNow('Fehler: Empfehler konnte nicht gelöscht werden.');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Empfehlungsmanager - Empfehler
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Empfehlungsmanager - Anfragen
// *****************************************************************************

function initEmpfehlungsmanagerAdminWindowAnfragenOnlyTop() {
  if (setCurEmpfehlerToAnfrageClick != '') {
    $('#vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM').val(setCurEmpfehlerToAnfrageClick);
    showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload(setCurEmpfehlerToAnfrageClick);
  }
  
  $('#vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM').msDropDown();
  
  $('#vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM').change(function() {
    showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload($(this).val());
  });
}



function showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload(curEmpfId) {
  $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageHolderSysMM').html('');
  $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageHolderSysMM').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curEmpfId: curEmpfId},
    success: function(data) {
      setCurEmpfehlerToAnfrageClick = '';
      $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageHolderSysMM').html(data);
      initEmpfehlungsmanagerAdminWindowAnfragenOnlyList();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initEmpfehlungsmanagerAdminWindowAnfragenOnlyList() {
  $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageSetBuchung').click(function() {
    var checkerSet = confirm('Möchten Sie diese Anfrage wirklich als gebucht markieren?');
    if (checkerSet == true) {
      setTheCurentEmpfehlerAnfrageBooking($(this).attr('data-id'));
    }
  });
  
  $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageDelBuchung').click(function() {
    var checkerDel = confirm('Möchten Sie die Buchung von dieser Anfrage wirklich löschen?');
    if (checkerDel == true) {
      delTheCurentEmpfehlerAnfrageBooking($(this).attr('data-id'));
    }
  });
  
  $('.vFrontEmpfAuflistungLiEmpfehlerAnfrageShowData').click(function() {
    showTheCurentEmpfehlerAnfrageHtmlMailNow($(this).attr('data-id'));
  });
}



function setTheCurentEmpfehlerAnfrageBooking(curAnfrageId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'setTheCurentEmpfehlerAnfrageBooking', VCMS_POST_LANG: $('body').attr('data-lang'), _curAnfrageId: curAnfrageId},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Die Anfrage wurde erfolgreich als gebucht markiert.');
        showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload($('#vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM').val());
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delTheCurentEmpfehlerAnfrageBooking(curAnfrageId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'delTheCurentEmpfehlerAnfrageBooking', VCMS_POST_LANG: $('body').attr('data-lang'), _curAnfrageId: curAnfrageId},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Die Buchung wurde erfolgreich von der Anfrage gelöscht.');
        showEmpfehlungsmanagerAdminWindowAnfragenOnlyListReload($('#vFrontEmpfAuflistungLiEmpfehlerAnfrageSelectMM').val());
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showTheCurentEmpfehlerAnfrageHtmlMailNow(curAnfrageId) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Anfrage E-Mail');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'showTheCurentEmpfehlerAnfrageHtmlMailNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curAnfrageId: curAnfrageId},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Empfehlungsmanager - Anfragen
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Empfehlungsmanager - E-Mail Export
// *****************************************************************************

function initEmpfehlungsmanagerAdminWindowMailExport() {
  $('#vFrontEmpfManagerMailExportBtnGo').click(function() {
    generateNewEmpfehlungsManagerMailCsvFile();
  });
}



function generateNewEmpfehlungsManagerMailCsvFile() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_empfehlung.php",
    data: {_art: 'generateNewEmpfehlungsManagerMailCsvFile', VCMS_POST_LANG: $('body').attr('data-lang')},
    //data: {_art: 'generateNewEmpfehlungsManagerMailCsvFile', VCMS_POST_LANG: $('body').attr('data-lang'), _curDateVon: $('#sysMailExportDateVon').val(), _curDateBis: $('#sysMailExportDateBis').val()},
    success: function(data) {
      if (data == true) {
        window.location.href = 'admin/csv_download.php?file=EmpfehlungsManagerMail.csv';
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Empfehlungsmanager - E-Mail Export
// *****************************************************************************









function showWindowImageAuswahlEmpfMangaerFBPostPicMM(curElem) {
  var abstandLeft = ($(window).width() / 2) - (560 / 2);
  $('#vFrontCenterWindowImageAuswahl').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowImageAuswahlInhalt').html('');
  $('#vFrontCenterWindowImageAuswahlInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontOverlayThird').show();
  $('#vFrontCenterWindowImageAuswahl').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhalt', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowImageAuswahlInhalt').html(data);
      initWindowImageAuswahlEmpfMangaerFBPostPicMM(curElem);
      initImageAuswahlEmpfMangaerFBPostPicKatSelectMM(curElem);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initWindowImageAuswahlEmpfMangaerFBPostPicMM(curElem) {  
  $('.vFrontAuswahlImgElement').dblclick(function() {
    var curPicHolderEl = $('#vFrontCenterWindowBigInhalt').find('#vFrontEmaFbAppPostBildAusgabeSmallSy');
    curElem.val($(this).attr('data-id'));
    curPicHolderEl.html('<img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" />');
    closeCenterWindowImageAuswahl();
  });
}



// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlEmpfMangaerFBPostPicKatSelectMM(curElem) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    var curElemR = curElem;
    
    showWindowImageAuswahlEmpfMangaerFBPostPicReloadMM($(this).val(), curElemR);
  });
}



function showWindowImageAuswahlEmpfMangaerFBPostPicReloadMM(curKatId, curElem) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  var curElemR = curElem;
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initWindowImageAuswahlEmpfMangaerFBPostPicMM(curElemR);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************