/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/




function showSeitenEigenschaften(curSiteIdNow) {
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigHeadInhalt').html('Seiteneigenschaften bearbeiten');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowBig').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSeitenEigenschaften', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteIdNow: curSiteIdNow},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initSeitenEigenschaftenMenu();
      initSeitEigBilder();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften Menü
// *****************************************************************************

function initSeitenEigenschaftenMenu() {
  $('#vFrontSiteSeBilder').click(function() {
    if (!$(this).hasClass('vFrontActiveSiteS')) {
      unsetAllActiveSeitEigMenuPoints();
      setThisActiveSeitEigMenuPoint($(this));
      showSeiteneigenschaftenBilderReload($(this).attr('id'), $(this).attr('data-id'));
    }
  });
  
  $('#vFrontSiteSeFelder').click(function() {
    if (!$(this).hasClass('vFrontActiveSiteS')) {
      unsetAllActiveSeitEigMenuPoints();
      setThisActiveSeitEigMenuPoint($(this));
      showSeiteneigenschaftenFelderReload($(this).attr('id'), $(this).attr('data-id'));
    }
  });
  
  $('#vFrontSiteSeProdukte').click(function() {
    if (!$(this).hasClass('vFrontActiveSiteS')) {
      unsetAllActiveSeitEigMenuPoints();
      setThisActiveSeitEigMenuPoint($(this));
      showSeiteneigenschaftenProdukteReload($(this).attr('id'), $(this).attr('data-id'));
    }
  });
  
  $('#vFrontSiteSeBilderGalerien').click(function() {
    if (!$(this).hasClass('vFrontActiveSiteS')) {
      unsetAllActiveSeitEigMenuPoints();
      setThisActiveSeitEigMenuPoint($(this));
      showSeiteneigenschaftenBilderGalerienReload($(this).attr('id'));
    }
  });
}



function unsetAllActiveSeitEigMenuPoints() {
  try {
    for (var cII = 0; cII < curSiteFieldInstanzEditors.length; cII++) {
      curSiteFieldInstanzEditors[cII].destroy();
    }
    curSiteFieldInstanzEditorsCounters = -1;
  }
  catch(e) {
    //console.log(e);
  }
  $('.vFrontSiteSettingMenuPoint').removeClass('vFrontActiveSiteS');
}



function setThisActiveSeitEigMenuPoint(curMenuPoint) {
  curMenuPoint.addClass('vFrontActiveSiteS');
}



function showSeitEigPointLoader() {
  $('.vFrontSiteSettingInhaltHolder').html('');
  $('.vFrontSiteSettingInhaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
}

// *****************************************************************************
// ENDE - Funktionen für Seiteneigenschaften Menü
// *****************************************************************************








// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften - Bilder
// *****************************************************************************

function showSeiteneigenschaftenBilderReload(curMenuId, curSiteIdNow) {
  showSeitEigPointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSeitenEigenschaftenInhaltReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteIdNow: curSiteIdNow, _curMenuId: curMenuId},
    success: function(data) {
      $('.vFrontSiteSettingInhaltHolder').html(data);
      initSeitEigBilder();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigBilder() {
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
  $('#vFrontSiteSeBilderButton').click(function() {
    showCmsIsLoading();
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'saveSeitEigenschaftenBilder', VCMS_POST_LANG: $('body').attr('data-lang'), _siteID: $(this).attr('data-id'), _backImages: $('#vFrontFrmSiteBackImgs').val(), _listImage: $('#vFrontFrmSiteListImg').val(), _slideImages: $('#vFrontFrmSiteSlideImgs').val()},
      success: function(data) {
        hideCmsIsLoading();
        if (data) {
          showOkWindowNow('Die Seiteneigenschaften Bilder wurden erfolgreich gespeichert!');
        }
        else {
          showErrorWindowNow('Datenbank Fehler');
        }
      },
      error: function() {
        showAjaxFehler();
      }
    });
  });
}



function setNewSortPicIdInField(parElEig) {
  var picElemsCur = parElEig.find('.vFrontFrmListHolderLists > .vFrontFrmListsElem');
  var picElemDataValObj = $('#'+parElEig.attr('data-field'));
  var hansCount = 0;
  picElemDataValObj.val('');
  $.each(picElemsCur, function() {
    hansCount = hansCount + 1;
    if (hansCount == 1) {
      picElemDataValObj.val($(this).attr('data-elem'));
    }
    else {
      picElemDataValObj.val(picElemDataValObj.val()+';'+$(this).attr('data-elem'));
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Seiteneigenschaften - Bilder
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften - Felder
// *****************************************************************************

function showSeiteneigenschaftenFelderReload(curMenuId, curSiteIdNow) {
  showSeitEigPointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSeitenEigenschaftenInhaltReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteIdNow: curSiteIdNow, _curMenuId: curMenuId},
    success: function(data) {
      $('.vFrontSiteSettingInhaltHolder').html(data);
      initSeitEigOwnFelder();
      initSeitEigOwnFelderPicMultiFields();
      initSeitEigOwnFelderPicOnceFields();
      initSeitEigOwnFelderDateiOnceFields();
      initSeitEigOwnFelderDateiMultiFields();
      initSeitEigOwnFelderSeitenRelMultiFields();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

var curSiteFieldInstanzEditors = new Array();
var curSiteFieldInstanzEditorsCounters = -1;

function initSeitEigOwnFelder() {
  $('.vFrontSiSeOwnFelderWysiwygField').tinymce({
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
      // Wird in dieser Datei in der Funktion unsetAllActiveSeitEigMenuPoints() zerstört
      // ************************************************************************************
      curSiteFieldInstanzEditorsCounters = curSiteFieldInstanzEditorsCounters + 1;
      curSiteFieldInstanzEditors[curSiteFieldInstanzEditorsCounters] = editor;
    }
  });
  
  $('#vFrontSiSeOwnFelderFormsHolder form').submit(function(e) {
    e.preventDefault();
  });
  
  $('#vFrontSaveSiSeOwnFieldsNow').click(function() {
    saveSeitEigOwnFelderNowMM($(this).attr('data-id'));
  });
  
  $('.vFrontSiSeOwnFelderSelectField').msDropDown();
  
  $('.vFrontSiSeOwnFelderDateField').datepicker({
    showOn: "both",
    //minDate: "-0d",
    buttonImage: "admin/img/calendar.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
}



function initSeitEigOwnFelderPicMultiFields() {
  $('.vFrontFrmListHolder .vFrontFrmListHolderListsOwnFieldMulti').selectable();
  
  $('.vFrontFrmListHolderHeaderAddOwnFieldMulti').click(function() {
    showWindowImageAuswahl($(this).parent().parent().attr('data-field'), true);
  });
  
  $('.vFrontFrmListHolderHeaderDelOwnFieldMulti').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortPicIdInField(parElEig);
  });
  
  $('.vFrontFrmListHolderHeaderSortOwnFieldMulti').click(function() {
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
}



function initSeitEigOwnFelderPicOnceFields() {
  $('.vFrontFrmListHolderHeaderAddOwnFieldOnce').click(function() {
    showWindowImageAuswahl($(this).parent().parent().attr('data-field'), false);
  });
  
  $('.vFrontFrmListHolderHeaderDelOwnFieldOnce').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .vFrontFrmListsElem');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    $('#'+parElEig.attr('data-field')).val('');
  });
}



// Für Datei einzel Auswahl
// *****************************************************************************
function initSeitEigOwnFelderDateiOnceFields() {
  $('.vFrontFrmListHolderHeaderAddOwnDateiFieldOnce').click(function() {
    showSeitEigOwnFelderDateiauswahlWinOnce($(this).parent().parent().attr('data-field'));
  });
  
  
  $('.vFrontFrmListHolderHeaderDelOwnDateiFieldOnce').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .vFrontFrmListsElem');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    $('#'+parElEig.attr('data-field')).val('');
  });
}



function showSeitEigOwnFelderDateiauswahlWinOnce(dataField) {
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
      initSeitEigOwnFieldsDateiAuswahlWindow(dataField);
      initSeitEigOwnFieldsDateiAuswahlWindowKatSelect(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigOwnFieldsDateiAuswahlWindow(curDataFieldId) {
  $('.vFrontAuswahlImgElement').dblclick(function() {
    $('#'+curDataFieldId).val($(this).attr('data-id'));
    var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
    var curFildPicArt = $(this).find('img').first().attr('src');
    curInhaltEl.html('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild" style="text-align:center;"><img style="width:40px;" src="'+curFildPicArt+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
    closeCenterWindowImageAuswahl();
  });
}



function initSeitEigOwnFieldsDateiAuswahlWindowKatSelect(dataField) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    showSeitEigOwnFelderDateiauswahlWinOnceReload($(this).val(), dataField);
  });
}



function showSeitEigOwnFelderDateiauswahlWinOnceReload(curKatId, dataField) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingDateiauswahlWinReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initSeitEigOwnFieldsDateiAuswahlWindow(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *****************************************************************************



// Für Datei multi Auswahl
// *****************************************************************************
function initSeitEigOwnFelderDateiMultiFields() {
  $('.vFrontFrmListHolder .vFrontFrmListHolderListsOwnDateiFieldMulti').selectable();
  
  
  $('.vFrontFrmListHolderHeaderAddOwnDateiFieldMulti').click(function() {
    showSeitEigOwnFelderDateiauswahlWinMulti($(this).parent().parent().attr('data-field'));
  });
  
  
  $('.vFrontFrmListHolderHeaderDelOwnDateiFieldMulti').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortPicIdInField(parElEig);
  });
  
  
  $('.vFrontFrmListHolderHeaderSortOwnDateiFieldMulti').click(function() {
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
      });
    }
  });
}



function showSeitEigOwnFelderDateiauswahlWinMulti(dataField) {
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
    data: {_art: 'showLinkingDateiauswahlWin', VCMS_POST_LANG: $('body').attr('data-lang'), _isDateiAuswahlMultiSelectElemsNow: 'yes'},
    success: function(data) {
      $('#vFrontCenterWindowImageAuswahlInhalt').html(data);
      initSeitEigOwnFieldsDateiAuswahlWindowMulti(dataField);
      initSeitEigOwnFieldsDateiAuswahlWindowKatSelectMulti(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigOwnFieldsDateiAuswahlWindowMulti(curDataFieldId) {
  $('.vFrontAuswahlImgVerwaltHolder').selectable({
    filter: ".vFrontAuswahlImgElement"
  });
  
  $('.vFrontMultiPicAuswahlBtnMM').click(function() {
  //$('.vFrontAuswahlImgElement').dblclick(function() {
    var allSelectedElems = $(this).parent().find('.vFrontAuswahlImgElement.ui-selected');
    $.each(allSelectedElems, function() {
      if ($('#'+curDataFieldId).val() == '') {
        $('#'+curDataFieldId).val($(this).attr('data-id'));
      }
      else {
        $('#'+curDataFieldId).val($('#'+curDataFieldId).val()+';'+$(this).attr('data-id'));
      }
      var curFildPicArt = $(this).find('img').first().attr('src');
      var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
      curInhaltEl.append('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild" style="text-align:center;"><img style="width:40px;" src="'+curFildPicArt+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
    });
    closeCenterWindowImageAuswahl();
  });
}



function initSeitEigOwnFieldsDateiAuswahlWindowKatSelectMulti(dataField) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    showSeitEigOwnFelderDateiauswahlWinMultiReload($(this).val(), dataField);
  });
}



function showSeitEigOwnFelderDateiauswahlWinMultiReload(curKatId, dataField) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showLinkingDateiauswahlWinReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initSeitEigOwnFieldsDateiAuswahlWindowMulti(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *****************************************************************************



// Für Seiten Relationen multi Auswahl
// *****************************************************************************
function initSeitEigOwnFelderSeitenRelMultiFields() {
  $('.vFrontFrmListHolder .vFrontFrmListHolderListsOwnSiteFieldMulti').selectable();
  
  
  $('.vFrontFrmListHolderHeaderAddOwnSiteFieldMulti').click(function() {
    showSeitEigOwnFelderSeitenRelAuswahlWinMulti($(this).parent().parent().attr('data-field'));
  });
  
  
  $('.vFrontFrmListHolderHeaderDelOwnSiteFieldMulti').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortSiteIdBySiteRelInField(parElEig);
  });
  
  
  $('.vFrontFrmListHolderHeaderSortOwnSiteFieldMulti').click(function() {
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
        stop: function(event, ui) { setNewSortSiteIdBySiteRelInField(parElEig); }
      });
    }
  });
}



function showSeitEigOwnFelderSeitenRelAuswahlWinMulti(dataField) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('CMS Seiten auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeUserIndividualSiteList', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initSeitEigOwnFelderSeitenRelAuswahlWinMulti(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showSeitEigOwnFelderSeitenRelAuswahlWinMultiReloadMM(nartID, dataField) {
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeUserIndividualSiteListReload', VCMS_POST_LANG: $('body').attr('data-lang'), _naviArtID: nartID},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initSeitEigOwnFelderSeitenRelAuswahlWinMulti(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigOwnFelderSeitenRelAuswahlWinMulti(curDataFieldId) {
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').msDropDown();
  
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').change(function() {
    showSeitEigOwnFelderSeitenRelAuswahlWinMultiReloadMM($(this).val(), curDataFieldId);
  });
  
  $('.vFrontSeitenAuflistungAuswahl').selectable({
    filter: ".vFrontIsSiteCur, .vFrontIsBlogCur",
    cancel: "#vFrontListButtonSelectedNow, .vFrontIsNaviCur"
  });
  
  $('#vFrontListButtonSelectedNow').click(function() {
    var allSelectedElems = $(this).parent().find('.vFrontSeitenBaumHolder .ui-selected');
    $.each(allSelectedElems, function() {
      if ($('#'+curDataFieldId).val() == '') {
        $('#'+curDataFieldId).val($(this).attr('data-id'));
      }
      else {
        $('#'+curDataFieldId).val($('#'+curDataFieldId).val()+';'+$(this).attr('data-id'));
      }
      var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
      curInhaltEl.append('<div class="vFrontListElemIUser" data-id="'+$(this).attr('data-id')+'">'+$(this).attr('data-name')+'</div>');
    });
    
    closeCenterWindowAllgemeinCMSWindow();
  });
}



function setNewSortSiteIdBySiteRelInField(parElEig) {
  var picElemsCur = parElEig.find('.vFrontFrmListHolderLists > .vFrontListElemIUser');
  var picElemDataValObj = $('#'+parElEig.attr('data-field'));
  var hansCount = 0;
  picElemDataValObj.val('');
  $.each(picElemsCur, function() {
    hansCount = hansCount + 1;
    if (hansCount == 1) {
      picElemDataValObj.val($(this).attr('data-id'));
    }
    else {
      picElemDataValObj.val(picElemDataValObj.val()+';'+$(this).attr('data-id'));
    }
  });
}
// *****************************************************************************



function saveSeitEigOwnFelderNowMM(siteId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveSeitEigOwnFelderNowMM', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteId: siteId, _dataArr: $('#vFrontSiSeOwnFelderFormsHolder form').serializeArray()},
    success: function(data) {
      hideCmsIsLoading();
      showOkWindowNow('Die Seitenfelder wurden erfolgreich gespeichert!');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Seiteneigenschaften - Felder
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften - Shop Produkte
// *****************************************************************************

function showSeiteneigenschaftenProdukteReload(curMenuId, curSiteIdNow) {
  showSeitEigPointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSeitenEigenschaftenInhaltReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteIdNow: curSiteIdNow, _curMenuId: curMenuId},
    success: function(data) {
      $('.vFrontSiteSettingInhaltHolder').html(data);
      initSeitEigProdukte();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigProdukte() {
  $('.vFrontFrmListHolder .vFrontFrmListHolderLists').selectable();
  
  $('.vFrontFrmListHolderHeaderAdd').click(function() {
    showWindowProductForListAuswahl($(this).parent().parent().attr('data-field'), true);
  });
  $('.vFrontFrmListHolderHeaderDel').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortProductIdInField(parElEig);
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
        stop: function(event, ui) { setNewSortProductIdInField(parElEig); }
      });;
    }
  });
  
  $('#vFrontSiteSeProdukteButton').click(function() {
    saveSeitEigenProduktList($(this).attr('data-id'));
  });
}



function showWindowProductForListAuswahl(curDataFieldId, dataMultiPic) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowHpProductListSeitEig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowHpProductListSeitEigInhalt').html('');
  $('#vFrontCenterWindowHpProductListSeitEigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowHpProductListSeitEigHeadInhalt').html('Shop Produkte auswählen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowHpProductListSeitEig').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showProductsListInWindowForSeEig', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowHpProductListSeitEigInhalt').html(data);
      initSeitEigShopProductListElems(curDataFieldId, dataMultiPic);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigShopProductListElems(curDataFieldId, dataMultiPic) {
  if (dataMultiPic == true) {
    /*$('.vFrontAuswahlImgVerwaltHolder').selectable({
      filter: ".vFrontAuswahlImgElement"
    });*/
  }
  
  $('.vFrontModulShopListElem').dblclick(function() {
    if ($('#'+curDataFieldId).val() == '') {
      $('#'+curDataFieldId).val($(this).attr('data-id'));
    }
    else {
      $('#'+curDataFieldId).val($('#'+curDataFieldId).val()+';'+$(this).attr('data-id'));
    }
    var curInhaltEl = $('#'+curDataFieldId).parent().find('.vFrontFrmListHolderLists');
    curInhaltEl.append('<div class="vFrontFrmListsElem" data-elem="'+$(this).attr('data-id')+'"><div class="vFrontFrmListsElemBild"><img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" /></div><div class="vFrontFrmListsElemText">'+$(this).attr('data-name')+'</div><div class="clearer"></div></div>');
    closeCenterWindowHpProductListSeitEig();
  });
}



function saveSeitEigenProduktList(curSiteID) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveSeitEigenschaftenProdukte', VCMS_POST_LANG: $('body').attr('data-lang'), _siteID: curSiteID, _siteProdukte: $('#vFrontFrmSiteProducts').val()},
    success: function(data) {
      hideCmsIsLoading();
      if (data == true) {
        showOkWindowNow('Die Seiten Produkte wurden erfolgreich gespeichert!');
      }
      else {
        showErrorWindowNow('Datenbank Fehler');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function setNewSortProductIdInField(parElEig) {
  var picElemsCur = parElEig.find('.vFrontFrmListHolderLists > .vFrontFrmListsElem');
  var picElemDataValObj = $('#'+parElEig.attr('data-field'));
  var hansCount = 0;
  picElemDataValObj.val('');
  $.each(picElemsCur, function() {
    hansCount = hansCount + 1;
    if (hansCount == 1) {
      picElemDataValObj.val($(this).attr('data-elem'));
    }
    else {
      picElemDataValObj.val(picElemDataValObj.val()+';'+$(this).attr('data-elem'));
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Seiteneigenschaften - Shop Produkte
// *****************************************************************************










// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften - Bilder Galerien
// *****************************************************************************

function showSeiteneigenschaftenBilderGalerienReload(curMenuId) {
  showSeitEigPointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSeiteneigenschaftenBilderGalerienReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curMenuId: curMenuId},
    success: function(data) {
      $('.vFrontSiteSettingInhaltHolder').html(data);
      initSeitEigBilderGalerien();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSeitEigBilderGalerien() {
  $('#vFrontNeuePicGalSeBtn').click(function() {
    showNewPicGalWindowSiSe();
  });
  
  $('.vFrontSiSeAuflistungPicGalChange').click(function() {
    showChangePicGalWindowSiSe($(this).attr('data-id'));
  });
  
  $('.vFrontSiSeAuflistungPicGalDel').click(function() {
    var checkerDel = confirm('Möchten Sie die Bilder Galerie wirklich löschen?');
    if (checkerDel == true) {
      delThisSiSePicGalNow($(this).attr('data-id'), $(this).parent());
    }
  });
}



function showNewPicGalWindowSiSe() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettings').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettings').addClass('vFrontSetBigWindowClassNow');
  $('#vFrontCenterWindowSmallSettingsClose').addClass('vFrontIsPicGalSiSeWindow');
  
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Neue Bilder Galerie');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettings').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showNewPicGalWindowSiSe', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
      initSiSePicGalImagesWindowNewChange();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showChangePicGalWindowSiSe($curPicGalId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettings').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettings').addClass('vFrontSetBigWindowClassNow');
  $('#vFrontCenterWindowSmallSettingsClose').addClass('vFrontIsPicGalSiSeWindow');
  
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Bilder Galerie bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettings').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showChangePicGalWindowSiSe', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicGalId: $curPicGalId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
      initSiSePicGalImagesWindowNewChange();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSiSePicGalImagesWindowNewChange() {

  // Funktionen sind übernommen von siteSettings.js
  // Funktion initSeitEigBilder()
  // ***************************************************************************
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
  // ***************************************************************************
  
  
  $('#vSavePicGalSiSeNewBtn').click(function() {
    if ($('#vFrontFrmSiSePicGalName').val() == '') {
      showErrorWindowNow('Bitte geben Sie einen Galerie Name ein.');
    }
    else {
      showCmsIsLoading();
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'vSavePicGalSiSeNewBtn', VCMS_POST_LANG: $('body').attr('data-lang'), _picgalName: $('#vFrontFrmSiSePicGalName').val(), _picgalImages: $('#vFrontFrmPicGalSiSeImgs').val()},
        success: function(data) {
          if (data == true) {
            closeCenterWindowSmallSettings();
            showSeiteneigenschaftenBilderGalerienReload('vFrontSiteSeBilderGalerien');
          }
          else {
            showErrorWindowNow('Es ist ein Fehler aufgetreten.');
          }
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
  
  
  
  $('#vSavePicGalSiSeChangeBtn').click(function() {
    var curPicGalId = $(this).attr('data-id');
    if ($('#vFrontFrmSiSePicGalName').val() == '') {
      showErrorWindowNow('Bitte geben Sie einen Galerie Name ein.');
    }
    else {
      showCmsIsLoading();
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'vSavePicGalSiSeChangeBtn', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicGalId: curPicGalId, _picgalName: $('#vFrontFrmSiSePicGalName').val(), _picgalImages: $('#vFrontFrmPicGalSiSeImgs').val()},
        success: function(data) {
          if (data == true) {
            closeCenterWindowSmallSettings();
            showSeiteneigenschaftenBilderGalerienReload('vFrontSiteSeBilderGalerien');
          }
          else {
            showErrorWindowNow('Es ist ein Fehler aufgetreten.');
          }
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
}



function delThisSiSePicGalNow(curPicGalId, curListElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delThisSiSePicGalNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPicGalId: curPicGalId},
    success: function(data) {
      if (data == true) {
        curListElem.fadeOut(500, function() {
          curListElem.remove();
        });
      }
      else {
        showErrorWindowNow('Es ist ein Fehler aufgetreten.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ANFANG - Funktionen für Seiteneigenschaften - Bilder Galerien
// *****************************************************************************