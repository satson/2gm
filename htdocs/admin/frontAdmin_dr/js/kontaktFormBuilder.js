/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



// *****************************************************************************
// ANFANG - Funktionen für Builder - Allgemein
// *****************************************************************************

function showKontaktFormBuilderAdminWindow() {
  var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigHeadInhalt').html('Kontaktformular Builder Admin');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowBig').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'showKontaktFormBuilderAdminWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initKontaktFormBuilderAdminWindowStart();
      //initEmpfehlungsmanagerAdminWindowCurInhalt('vFrontEmpfehlungsMangerAdminAllgemein');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initKontaktFormBuilderAdminWindowStart() {
  $('#vFrontKontaktFormBuilderMenuBtnNewFormular').click(function() {
    showKontaktFormBuilderAdminWindowNewForm();
  });
  
  $('#vFrontKontaktFormBuilderMenuBtnImportFormular').click(function() {
    
  });
  
  
  $('.vFrontEmpfAuflistungLiKontaktformulareBChange').click(function() {
    showKontaktFormBuilderAdminWindowBearForm($(this).attr('data-id'));
  });
  
  $('.vFrontEmpfAuflistungLiKontaktformulareBDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Formular wirklich löschen?');
    if (checkerDel == true) {
      delThisKontaktformularOnAdminNow($(this).attr('data-id'), $(this).parent());
    }
  });
}



function delThisKontaktformularOnAdminNow(curDelFormId, curFormListObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'delThisKontaktformularOnAdminNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curDelFormId: curDelFormId},
    success: function(data) {
      if (data == true) {
        curFormListObj.fadeOut(400, function() {
          curFormListObj.remove();
        });
        showOkWindowNow('Das Kontaktformular wurde erfolgreich gelöscht.');
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
// ENDE - Funktionen für Builder - Allgemein
// *****************************************************************************






// *****************************************************************************
// ANFANG - Funktionen für Builder - Neues Kontaktformular
// *****************************************************************************

function showKontaktFormBuilderAdminWindowNewForm() {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'showKontaktFormBuilderAdminWindowNewForm', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initKontaktFormBuilderAdminWindowNewForm();
      initKontaktFormBuilderAdminWindowAllgemeineButtons();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initKontaktFormBuilderAdminWindowNewForm() {
  $('#vFrontKontaktFormBuilderMenuBtnNewFormularSave').click(function() {
    if ($('#vFrontKontaktFormBuilderJsonFormsString').val() != '') {
      showNewKontaktformularBuilderSaveNameWindowNow();
    }
    else {
      alert('Das Kontaktformular ist leer.');
    }
  });
  
  $('#vFrontKontaktFormBuilderMenuBtnNewFormularCancel').click(function() {
    var checkerCancel = confirm('Möchten Sie das Formular wirklich verwerfen?');
    if (checkerCancel == true) {
      showKontaktFormBuilderAdminWindow();
    }
  });
  
  var drag_fixed_kfb = 1;
  $('.vFrontKontaktFormBuilderDragElemMM').draggable({ 
    //cancel: "a.ui-icon", // clicking an icon won't initiate dragging
    zIndex: 999999,
    revert: 'invalid',
    containment: 'document',
    helper: 'clone',
    cursor: 'move',
    appendTo: 'body',
    start: function(event, ui) {
      drag_fixed_kfb = 0;
    },
    stop: function(event, ui) {
    },
    drag: function(event, ui){
      if(drag_fixed_kfb == 0) {
        var marg = $('body, html').scrollTop(); //$(ui.helper).offset().top + $('body').scrollTop();
        $(ui.helper).css('margin-top', '-'+marg+'px');
        drag_fixed_kfb = 1;
      }
    }
  });
  
  initKontaktFormBuilderAdminWindowDragPlaces();
  initKontaktFormBuilderAdminWindowSortFunctions();
}



function showNewKontaktformularBuilderSaveNameWindowNow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Neues Kontaktformular speichern');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  var curHtmlIn = '<div class="vFrontSmallSeFrmHolder">';
  curHtmlIn += '<label for="vKontaktformularBuilderSaveNameFrm">Name:</label>';
  curHtmlIn += '<input type="text" id="vKontaktformularBuilderSaveNameFrm" name="vKontaktformularBuilderSaveNameFrm" />';
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curHtmlIn += '<input type="submit" id="vKontaktformularBuilderSaveNameBtn" value="Speichern" />';
  curHtmlIn += '</div>';
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curHtmlIn);
  initNewKontaktformularBuilderSaveNameWindowNow();
}



function initNewKontaktformularBuilderSaveNameWindowNow() {
  $('#vKontaktformularBuilderSaveNameBtn').click(function() {
    if ($('#vKontaktformularBuilderSaveNameFrm').val() != "") {
      saveNewKontaktformularFromBuilderNow();
    }
    else {
      showErrorWindowNow('Bitte geben Sie einen Name ein.');
    }
  });
}



function saveNewKontaktformularFromBuilderNow() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'saveNewKontaktformularFromBuilderNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curName: $('#vKontaktformularBuilderSaveNameFrm').val(), _curFormJson: $('#vFrontKontaktFormBuilderJsonFormsString').val()},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmallSettingsImgVerwalt();
        showKontaktFormBuilderAdminWindow();
        showOkWindowNow('Das Kontaktformular wurde erfolgreich gespeichert.');
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
// ENDE - Funktionen für Builder - Neues Kontaktformular
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder - Berbeitentes Kontaktformular
// *****************************************************************************

function showKontaktFormBuilderAdminWindowBearForm(curFormId) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'showKontaktFormBuilderAdminWindowBearForm', VCMS_POST_LANG: $('body').attr('data-lang'), _curFormId: curFormId},
    success: function(data) {
      $('#vFrontCenterWindowBigInhalt').html(data);
      initKontaktFormBuilderAdminWindowBearForm();
      initKontaktFormBuilderAdminWindowAllgemeineButtons();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initKontaktFormBuilderAdminWindowBearForm() {
  buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
  
  
  $('#vFrontKontaktFormBuilderMenuBtnBearFormularSave').click(function() {
    showBearKontaktformularBuilderSaveNameWindowNow($(this).attr('data-id'), $('#vFrontKontaktFormBuilderSettingKontaktformName').val());
  });
  
  $('#vFrontKontaktFormBuilderMenuBtnBearFormularCancel').click(function() {
    var checkerCancel = confirm('Möchten Sie die Änderungen wirklich verwerfen?');
    if (checkerCancel == true) {
      showKontaktFormBuilderAdminWindow();
    }
  });
  
  var drag_fixed_kfb = 1;
  $('.vFrontKontaktFormBuilderDragElemMM').draggable({ 
    //cancel: "a.ui-icon", // clicking an icon won't initiate dragging
    zIndex: 999999,
    revert: 'invalid',
    containment: 'document',
    helper: 'clone',
    cursor: 'move',
    appendTo: 'body',
    start: function(event, ui) {
      drag_fixed_kfb = 0;
    },
    stop: function(event, ui) {
    },
    drag: function(event, ui){
      if(drag_fixed_kfb == 0) {
        var marg = $('body, html').scrollTop(); //$(ui.helper).offset().top + $('body').scrollTop();
        $(ui.helper).css('margin-top', '-'+marg+'px');
        drag_fixed_kfb = 1;
      }
    }
  });
}



function showBearKontaktformularBuilderSaveNameWindowNow(curFormId, curFormName) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Geändertes Kontaktformular speichern');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  var curHtmlIn = '<div class="vFrontSmallSeFrmHolder">';
  curHtmlIn += '<label for="vKontaktformularBuilderSaveNameFrm">Name:</label>';
  curHtmlIn += '<input type="text" id="vKontaktformularBuilderSaveNameFrm" name="vKontaktformularBuilderSaveNameFrm" value="'+curFormName+'" />';
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curHtmlIn += '<input type="submit" id="vKontaktformularBuilderSaveNameBearBtn" value="Speichern" data-id="'+curFormId+'" />';
  curHtmlIn += '</div>';
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curHtmlIn);
  initBearKontaktformularBuilderSaveNameWindowNow();
}



function initBearKontaktformularBuilderSaveNameWindowNow() {
  $('#vKontaktformularBuilderSaveNameBearBtn').click(function() {
    if ($('#vKontaktformularBuilderSaveNameFrm').val() != "") {
      saveBearKontaktformularFromBuilderNow($(this).attr('data-id'));
    }
    else {
      showErrorWindowNow('Bitte geben Sie einen Name ein.');
    }
  });
}



function saveBearKontaktformularFromBuilderNow(curBearFormId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_kontaktformbuilder.php",
    data: {_art: 'saveBearKontaktformularFromBuilderNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curBearFormId: curBearFormId, _curName: $('#vKontaktformularBuilderSaveNameFrm').val(), _curFormJson: $('#vFrontKontaktFormBuilderJsonFormsString').val()},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmallSettingsImgVerwalt();
        showKontaktFormBuilderAdminWindow();
        showOkWindowNow('Das Kontaktformular wurde erfolgreich gespeichert.');
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
// ENDE - Funktionen für Builder - Berbeitentes Kontaktformular
// *****************************************************************************







function initKontaktFormBuilderAdminWindowAllgemeineButtons() {
  $('#vFrontKontaktFormBuilderLangChangeSelectOpt').msDropDown();
  
  $('.vFrontKontaktFormInnerElemsBtnEinstellungenMM').click(function() {
    showKontaktFormBuilderAdminWindowEinstellungenWindow();
  });
  
  $('.vFrontKontaktFormInnerElemsBtnEinstellungenOnLangMM').click(function() {
    showKontaktFormBuilderAdminWindowEinstellungenOnLangWindow();
  });
  
  $('.vFrontKontaktFormInnerElemsBtnDropsHideMM').click(function() {
    if ($(this).hasClass('isDropsHide')) {
      var allOuterDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceOuter');
      allOuterDrops.show();
      var allInnerDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceInner');
      allInnerDrops.show();
      $(this).removeClass('isDropsHide');
      $(this).html('Drop Bereiche verbergen');
    }
    else {
      var allOuterDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceOuter');
      allOuterDrops.hide();
      var allInnerDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceInner');
      allInnerDrops.hide();
      $(this).addClass('isDropsHide');
      $(this).html('Drop Bereiche anzeigen');
    }
  });
  
  $('#vFrontKontaktFormBuilderLangChangeSelectOpt').change(function() {
    if ($(this).val() != '') {
      hideDiverseElemsByLangSelect();
    }
    else {
      //$('.vFrontKontaktFormInnerElemsBtnEinstellungenMM').css('left', '240px');
      $('.vFrontKontaktFormInnerElemsBtnEinstellungenOnLangMM').hide();
      $('.vFrontKontaktFormInnerElemsBtnDropsHideMM').show();
      $('.vFrontKontaktFormInnerElemsBtnEinstellungenMM').show();
      buildKontaktFormBuilderAdminWindowJsonStringByElems();
      buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    }
  });
}



function hideDiverseElemsByLangSelect() {
  $('.vFrontKontaktFormInnerElemsBtnDropsHideMM').hide();
  $('.vFrontKontaktFormInnerElemsBtnEinstellungenMM').hide();
  $('.vFrontKontaktFormInnerElemsBtnEinstellungenOnLangMM').show();
  //$('.vFrontKontaktFormInnerElemsBtnEinstellungenMM').css('left', '20px');
  $('.vFrontKontaktFormBuilderDragPlaceOuter').remove();
  $('.vFrontKontaktFormBuilderDragPlaceInner').remove();
  $('.vFrontKontaktFormBuilderElemIsSetStructChangeBtn').remove();
  $('.vFrontKontaktFormBuilderElemIsSetStructDelBtn').remove();
  $('.vFrontKontaktFormBuilderContainerIsSetStructDelBtn').remove();
  $('.vFrontKontaktFormBuilderElemIsSetStructChangeBtnOnLang').show();
  
  try {
    $('.vFrontKontaktFormBuilderDragHolder').sortable('destroy');
    $('.vFrontKontaktFormBuilderDragHolder .vFrontKontaktFormBuilderContainerIsSetStruct').sortable('destroy');
  }
  catch(ex) {
    
  }
}



function showKontaktFormBuilderAdminWindowEinstellungenWindow() {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Kontaktformular Einstellungen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  var curWinHtml = '<div class="vFrontSmallSeFrmHolder">';
  curWinHtml += '<label style="width:100px;" for="vKontaktformularBuilderSettingMailFrm">E-Mail:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingMailFrm" name="vKontaktformularBuilderSettingMailFrm" value="'+$('#vFrontKontaktFormBuilderSettingAbsenderMail').val()+'" />';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingDankeFrm">Danke Seite:</label>';
  curWinHtml += '<div style="display:inline-block; width:400px;"><textarea style="height:100px;" id="vKontaktformularBuilderSettingDankeFrm" name="vKontaktformularBuilderSettingDankeFrm">'+$('#vFrontKontaktFormBuilderSettingDankeSeiteText').val()+'</textarea></div>';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px;" for="vKontaktformularBuilderSettingSendBtnTextFrm">Button Text:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingSendBtnTextFrm" name="vKontaktformularBuilderSettingSendBtnTextFrm" value="'+$('#vFrontKontaktFormBuilderSettingSendButtonText').val()+'" />';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  var curBestaetigungMailChecked = '';
  var curBestaetigungMailFieldsStyle = ' style="display:none;"';
  if ($('#vFrontKontaktFormBuilderSettingBestaetigungMail').val() == 'on') {
    curBestaetigungMailChecked = ' checked="checked"';
    curBestaetigungMailFieldsStyle = ' style="display:block;"';
  }
  
  curWinHtml += '<input'+curBestaetigungMailChecked+' type="checkbox" id="vKontaktformularBuilderSettingBestaetigungMailAktiv" name="vKontaktformularBuilderSettingBestaetigungMailAktiv" value="'+$('#vFrontKontaktFormBuilderSettingBestaetigungMail').val()+'" style="margin-left:100px;" />';
  curWinHtml += '<label style="width:350px; margin-left:5px;" for="vKontaktformularBuilderSettingBestaetigungMailAktiv">Bestätigung Mail an Kunde senden</label>';
  
  curWinHtml += '<div'+curBestaetigungMailFieldsStyle+' id="vKontaktformularBuilderSettingBestaetigungMailShowFields">';
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingBestaetigungMailBetreff">Bestätigung Mail Betreff:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingBestaetigungMailBetreff" name="vKontaktformularBuilderSettingBestaetigungMailBetreff" value="'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff').val()+'" />';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingBestaetigungMailText">Bestätigung Mail Text:</label>';
  curWinHtml += '<div style="display:inline-block; width:400px;"><textarea style="height:120px; width:370px;" id="vKontaktformularBuilderSettingBestaetigungMailText" name="vKontaktformularBuilderSettingBestaetigungMailText">'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailText').val()+'</textarea></div>';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px;" for="vKontaktformularBuilderSettingBestaetigungMailAbsenderName">Absender Name:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingBestaetigungMailAbsenderName" name="vKontaktformularBuilderSettingBestaetigungMailAbsenderName" value="'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsender').val()+'" />';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px;" for="vKontaktformularBuilderSettingBestaetigungMailAbsenderMail">Absender E-mail:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingBestaetigungMailAbsenderMail" name="vKontaktformularBuilderSettingBestaetigungMailAbsenderMail" value="'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail').val()+'" />';
  curWinHtml += '</div>';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curWinHtml += '<input style="margin-left:100px;" type="submit" id="vKontaktformularBuilderSettingSaveBtn" value="Speichern" />';
  curWinHtml += '</div>';
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(curWinHtml);
  initKontaktFormBuilderAdminWindowEinstellungenWindow();
}



function showKontaktFormBuilderAdminWindowEinstellungenOnLangWindow() {
  var CurLangKurzUrl = $('#vFrontKontaktFormBuilderLangChangeSelectOpt').val();
  
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Kontaktformular Einstellungen (Spracheintrag)');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  var curWinHtml = '<div class="vFrontSmallSeFrmHolder">';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingDankeFrm">Danke Seite:</label>';
  curWinHtml += '<div style="display:inline-block; width:400px;"><textarea style="height:100px;" id="vKontaktformularBuilderSettingDankeFrm" name="vKontaktformularBuilderSettingDankeFrm">'+$('#vFrontKontaktFormBuilderSettingDankeSeiteText-'+CurLangKurzUrl).val()+'</textarea></div>';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px;" for="vKontaktformularBuilderSettingSendBtnTextFrm">Button Text:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingSendBtnTextFrm" name="vKontaktformularBuilderSettingSendBtnTextFrm" value="'+$('#vFrontKontaktFormBuilderSettingSendButtonText-'+CurLangKurzUrl).val()+'" />';
  
  var curBestaetigungMailFieldsStyle = ' style="display:none;"';
  if ($('#vFrontKontaktFormBuilderSettingBestaetigungMail').val() == 'on') {
    curBestaetigungMailFieldsStyle = ' style="display:block;"';
  }
  
  curWinHtml += '<div'+curBestaetigungMailFieldsStyle+' id="vKontaktformularBuilderSettingBestaetigungMailShowFields">';
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingBestaetigungMailBetreff">Bestätigung Mail Betreff:</label>';
  curWinHtml += '<input type="text" id="vKontaktformularBuilderSettingBestaetigungMailBetreff" name="vKontaktformularBuilderSettingBestaetigungMailBetreff" value="'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'+CurLangKurzUrl).val()+'" />';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curWinHtml += '<label style="width:100px; vertical-align:top;" for="vKontaktformularBuilderSettingBestaetigungMailText">Bestätigung Mail Text:</label>';
  curWinHtml += '<div style="display:inline-block; width:400px;"><textarea style="height:120px; width:370px;" id="vKontaktformularBuilderSettingBestaetigungMailText" name="vKontaktformularBuilderSettingBestaetigungMailText">'+$('#vFrontKontaktFormBuilderSettingBestaetigungMailText-'+CurLangKurzUrl).val()+'</textarea></div>';
  curWinHtml += '</div>';
  
  curWinHtml += '<div class="vFrontSmallSeFrmHolderAbstand"></div><div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curWinHtml += '<input style="margin-left:100px;" type="submit" id="vKontaktformularBuilderSettingSaveOnLangBtn" value="Speichern" />';
  
  curWinHtml += '</div>';
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(curWinHtml);
  initKontaktFormBuilderAdminWindowEinstellungenWindow();
}



var curDankeTextFieldInstanzEditors = new Array();
var curDankeTextFieldInstanzEditorsCounters = -1;

function initKontaktFormBuilderAdminWindowEinstellungenWindow() {
  $('#vKontaktformularBuilderSettingDankeFrm, #vKontaktformularBuilderSettingBestaetigungMailText').tinymce({
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
      // Wird in der Datei functions.js in der Funktion closeCenterWindowAllgemeinCMSWindow() zerstört
      // ************************************************************************************
      curDankeTextFieldInstanzEditorsCounters = curDankeTextFieldInstanzEditorsCounters + 1;
      curDankeTextFieldInstanzEditors[curDankeTextFieldInstanzEditorsCounters] = editor;
    }
  });
  
  
  $('#vKontaktformularBuilderSettingBestaetigungMailAktiv').change(function() {
    if ($(this).is(':checked')) {
      $('#vKontaktformularBuilderSettingBestaetigungMailShowFields').slideDown(300);
    }
    else {
      $('#vKontaktformularBuilderSettingBestaetigungMailShowFields').slideUp(300);
    }
  });
  
  
  $('#vKontaktformularBuilderSettingSaveBtn').click(function() {
    $('#vFrontKontaktFormBuilderSettingAbsenderMail').val($('#vKontaktformularBuilderSettingMailFrm').val());
    $('#vFrontKontaktFormBuilderSettingDankeSeiteText').val($('#vKontaktformularBuilderSettingDankeFrm').val());
    $('#vFrontKontaktFormBuilderSettingSendButtonText').val($('#vKontaktformularBuilderSettingSendBtnTextFrm').val());
    
    if ($('#vKontaktformularBuilderSettingBestaetigungMailAktiv').is(':checked')) {
      $('#vFrontKontaktFormBuilderSettingBestaetigungMail').val('on');
    }
    else {
      $('#vFrontKontaktFormBuilderSettingBestaetigungMail').val('off');
    }
    
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff').val($('#vKontaktformularBuilderSettingBestaetigungMailBetreff').val());
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailText').val($('#vKontaktformularBuilderSettingBestaetigungMailText').val());
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsender').val($('#vKontaktformularBuilderSettingBestaetigungMailAbsenderName').val());
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail').val($('#vKontaktformularBuilderSettingBestaetigungMailAbsenderMail').val());
    
    buildKontaktFormBuilderAdminWindowJsonStringByElems();
    buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    
    closeCenterWindowAllgemeinCMSWindow();
  });
  
  
  
  $('#vKontaktformularBuilderSettingSaveOnLangBtn').click(function() {
    var CurLangKurzUrl = $('#vFrontKontaktFormBuilderLangChangeSelectOpt').val();
    
    $('#vFrontKontaktFormBuilderSettingDankeSeiteText-'+CurLangKurzUrl).val($('#vKontaktformularBuilderSettingDankeFrm').val());
    $('#vFrontKontaktFormBuilderSettingSendButtonText-'+CurLangKurzUrl).val($('#vKontaktformularBuilderSettingSendBtnTextFrm').val());
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'+CurLangKurzUrl).val($('#vKontaktformularBuilderSettingBestaetigungMailBetreff').val());
    $('#vFrontKontaktFormBuilderSettingBestaetigungMailText-'+CurLangKurzUrl).val($('#vKontaktformularBuilderSettingBestaetigungMailText').val());
    
    buildKontaktFormBuilderAdminWindowJsonStringByElems();
    buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    
    closeCenterWindowAllgemeinCMSWindow();
  });
}







// *****************************************************************************
// ANFANG - Funktionen für Builder - Builder Initialisieren
// *****************************************************************************

function initKontaktFormBuilderAdminWindowDragPlaces() {
  $(".vFrontKontaktFormBuilderDragPlaceOuter").droppable({
    hoverClass: "ui-state-dragger-kontakt-builder-hover",
    activeClass: "ui-state-dragger-kontakt-builder",
    accept: ".vFrontKontaktFormBuilderDragElemContainerMM",
    drop: function(event, ui) {
      setKontaktFormBuilderAdminWindowNewContainerElem($(this), ui.draggable.attr('id'));
    }
  });
  
  $(".vFrontKontaktFormBuilderDragPlaceInner").droppable({
    hoverClass: "ui-state-dragger-kontakt-builder-hover",
    activeClass: "ui-state-dragger-kontakt-builder",
    accept: ".vFrontKontaktFormBuilderDragElemFormMM",
    drop: function(event, ui) {
      setKontaktFormBuilderAdminWindowNewOtherElem($(this), ui.draggable.attr('id'));
    }
  });
}



function initKontaktFormBuilderAdminWindowSortFunctions() {
  $('.vFrontKontaktFormBuilderDragHolder').sortable({
    items: "> .vFrontKontaktFormBuilderContainerIsSetStruct",
    placeholder: "ui-state-highlight",
    delay: 300,
    axis: 'y',
    tolerance: "pointer",
    handle: "legend",
    start: function(event, ui) {
      var drops = $(this).find('.vFrontKontaktFormBuilderDragPlaceOuter');
      drops.remove();
      $(this).sortable("refresh");
      $(this).sortable("refreshPositions");
    },
    stop: function(event, ui) {
      buildKontaktFormBuilderAdminWindowJsonStringByElems();
      buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    }
  });
  
  
  $('.vFrontKontaktFormBuilderDragHolder .vFrontKontaktFormBuilderContainerIsSetStruct').sortable({
    items: "> .vFrontKontaktFormBuilderElemIsSetStruct",
    placeholder: "ui-state-highlight",
    delay: 300,
    axis: 'y',
    tolerance: "pointer",
    connectWith: ".vFrontKontaktFormBuilderDragHolder .vFrontKontaktFormBuilderContainerIsSetStruct",
    //handle: "legend",
    cancel: '.vFrontKontaktFormBuilderElemIsSetStructChangeBtn, .vFrontKontaktFormBuilderElemIsSetStructDelBtn',
    start: function(event, ui) {
      var drops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceInner');
      drops.remove();
      $(this).sortable("refresh");
      $(this).sortable("refreshPositions");
    },
    stop: function(event, ui) {
      buildKontaktFormBuilderAdminWindowJsonStringByElems();
      buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    }
  });
}



function initKontaktFormBuilderAdminWindowBtnsFunctions() {
  $('.vFrontKontaktFormBuilderElemIsSetStructChangeBtn').click(function() {
    showBuilderElementBearWindowOnce($(this).parent());
  });
  
  $('.vFrontKontaktFormBuilderElemIsSetStructChangeBtnOnLang').click(function() {
    showBuilderElementBearWindowOnceOnLang($(this).parent(), $('#vFrontKontaktFormBuilderLangChangeSelectOpt').val());
  });
  
  $('.vFrontKontaktFormBuilderElemIsSetStructDelBtn').click(function() {
    var curDelElem = $(this).parent();
    curDelElem.remove();
    buildKontaktFormBuilderAdminWindowJsonStringByElems();
    buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
  });
  
  $('.vFrontKontaktFormBuilderContainerIsSetStructDelBtn').click(function() {
    var checkerDelContainer = confirm('Möchten Sie den gesamten Container wirklich löschen?');
    if (checkerDelContainer == true) {
      var curDelContainer = $(this).parent();
      curDelContainer.remove();
      buildKontaktFormBuilderAdminWindowJsonStringByElems();
      buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Builder - Builder Initialisieren
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder Elemente Bearbeiten in einer Sprache
// *****************************************************************************

function showBuilderElementBearWindowOnceOnLang(curElemObj, curLangUrl) {
  var curElemLangObj = $('.vFrontKontaktFormBuilderDragHolder').find('#'+curElemObj.attr('data-id')+'-'+curLangUrl).first();
  
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Kontaktformular Feld bearbeiten (Spracheintrag)');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  var curHtmlIn = '<div class="vFrontSmallSeFrmHolder" style="margin-top:20px; margin-bottom:20px;">';
  
  curHtmlIn += '<label for="vKontaktformularBuilderElemLabelFrm">Label:</label>';
  curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemLabelFrm" name="vKontaktformularBuilderElemLabelFrm" value="'+curElemLangObj.attr('data-label')+'" />';
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  if (curElemObj.attr('data-art') != 3) {
    if (curElemObj.attr('data-required') == 'yes') {
      curHtmlIn += '<label for="vKontaktformularBuilderElemErrorTextFrm">Fehler Text:</label>';
      curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemErrorTextFrm" name="vKontaktformularBuilderElemErrorTextFrm" value="'+curElemLangObj.attr('data-error')+'" />';
      curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    }
  }
  
  if (curElemObj.attr('data-art') == 4) {
    curHtmlIn += '<label for="vKontaktformularBuilderElemOptionsFrm">Options:</label>';
    curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemOptionsFrm" name="vKontaktformularBuilderElemOptionsFrm" value="'+curElemLangObj.attr('data-options')+'" />';
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  }
  
  curHtmlIn += '<input type="submit" id="vKontaktformularBuilderSaveElemInBearBtnOnLang" value="Speichern" />';
  
  curHtmlIn += '</div>';
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curHtmlIn);
  
  
  $('#vKontaktformularBuilderSaveElemInBearBtnOnLang').click(function() {
    saveBearElemInOnClickOnLang(curElemObj, curElemLangObj);
  });
}



function saveBearElemInOnClickOnLang(curElemObj, curElemLangObj) {
  curElemLangObj.attr('data-label', $('#vKontaktformularBuilderElemLabelFrm').val());
  if (curElemObj.attr('data-art') != 3) {
    if (curElemObj.attr('data-required') == 'yes') {
      curElemLangObj.attr('data-error', $('#vKontaktformularBuilderElemErrorTextFrm').val());
    }
  }
  if (curElemObj.attr('data-art') == 4) {
    curElemLangObj.attr('data-options', $('#vKontaktformularBuilderElemOptionsFrm').val());
  }
  
  closeCenterWindowSmallSettingsImgVerwalt();
  buildKontaktFormBuilderAdminWindowJsonStringByElems();
  buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
}

// *****************************************************************************
// ENDE - Funktionen für Builder Elemente Bearbeiten in einer Sprache
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder Elemente Bearbeiten
// *****************************************************************************

function showBuilderElementBearWindowOnce(curElemObj) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsImgVerwaltHeadInhalt').html('Kontaktformular Feld bearbeiten');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowSmallSettingsImgVerwalt').show();
  
  var curHtmlIn = '<div class="vFrontSmallSeFrmHolder" style="margin-top:20px; margin-bottom:20px;">';
  curHtmlIn += '<label for="vKontaktformularBuilderElemDataFrm">Feld Name:</label>';
  curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemDataFrm" name="vKontaktformularBuilderElemDataFrm" value="'+curElemObj.attr('data-name')+'" />';
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  curHtmlIn += '<label for="vKontaktformularBuilderElemLabelFrm">Label:</label>';
  curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemLabelFrm" name="vKontaktformularBuilderElemLabelFrm" value="'+curElemObj.attr('data-label')+'" />';
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  
  if (curElemObj.attr('data-art') != 3) {
    var errorTextFormShow = ' style="display:none;"';
    if (curElemObj.attr('data-required') == 'yes') {
      errorTextFormShow = ' style="display:block;"';
    }
    curHtmlIn += '<div id="vFrontIsErrorTextShowForm"'+errorTextFormShow+'>';
    curHtmlIn += '<label for="vKontaktformularBuilderElemErrorTextFrm">Fehler Text:</label>';
    curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemErrorTextFrm" name="vKontaktformularBuilderElemErrorTextFrm" value="'+curElemObj.attr('data-error')+'" />';
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    curHtmlIn += '</div>';
    
    var requiredFieldChecker = '';
    if (curElemObj.attr('data-required') == 'yes') {
      requiredFieldChecker = ' checked="checked"';
    }
    curHtmlIn += '<input'+requiredFieldChecker+' style="margin-left:80px;" type="checkbox" id="vKontaktformularBuilderElemRequiredFrm" name="vKontaktformularBuilderElemRequiredFrm" value="yes" />';
    curHtmlIn += '<label style="margin-left:10px; width:110px;" for="vKontaktformularBuilderElemRequiredFrm">Pflichtfeld</label>';
  }
  
  if (curElemObj.attr('data-art') == 1) {
    var mailFieldChecker = '';
    if (curElemObj.attr('data-name') == $('#vFrontKontaktFormBuilderSettingFieldMail').val()) {
      mailFieldChecker = ' checked="checked"';
    }
    curHtmlIn += '<input'+mailFieldChecker+' style="margin-left:20px;" type="checkbox" id="vKontaktformularBuilderElemIsMailSendFrm" name="vKontaktformularBuilderElemIsMailSendFrm" value="yes" />';
    curHtmlIn += '<label style="margin-left:10px; width:auto;" for="vKontaktformularBuilderElemIsMailSendFrm">E-Mail Feld</label>';
    
    curHtmlIn += '<div style="height:5px;"></div>';
    var firstNameFieldChecker = '';
    if (curElemObj.attr('data-name') == $('#vFrontKontaktFormBuilderSettingFieldFirstName').val()) {
      firstNameFieldChecker = ' checked="checked"';
    }
    curHtmlIn += '<input'+firstNameFieldChecker+' style="margin-left:80px;" type="checkbox" id="vKontaktformularBuilderElemFirstNameFrm" name="vKontaktformularBuilderElemFirstNameFrm" value="yes" />';
    curHtmlIn += '<label style="margin-left:10px; width:110px;" for="vKontaktformularBuilderElemFirstNameFrm">Vorname Feld</label>';
    
    var lastNameFieldChecker = '';
    if (curElemObj.attr('data-name') == $('#vFrontKontaktFormBuilderSettingFieldLastName').val()) {
      lastNameFieldChecker = ' checked="checked"';
    }
    curHtmlIn += '<input'+lastNameFieldChecker+' style="margin-left:20px;" type="checkbox" id="vKontaktformularBuilderElemLastNameFrm" name="vKontaktformularBuilderElemLastNameFrm" value="yes" />';
    curHtmlIn += '<label style="margin-left:10px; width:auto;" for="vKontaktformularBuilderElemLastNameFrm">Nachname Feld</label>';
  }
  
  if (curElemObj.attr('data-art') == 4) {
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
    curHtmlIn += '<label for="vKontaktformularBuilderElemOptionsFrm">Options:</label>';
    curHtmlIn += '<input type="text" id="vKontaktformularBuilderElemOptionsFrm" name="vKontaktformularBuilderElemOptionsFrm" value="'+curElemObj.attr('data-options')+'" />';
    curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  }
  
  curHtmlIn += '<div class="vFrontSmallSeFrmHolderAbstand"></div>';
  curHtmlIn += '<input type="submit" id="vKontaktformularBuilderSaveElemInBearBtn" value="Speichern" />';
  curHtmlIn += '</div>';
  
  $('#vFrontCenterWindowSmallSettingsImgVerwaltInhalt').html(curHtmlIn);
  
  $('#vKontaktformularBuilderSaveElemInBearBtn').click(function() {
    saveBearElemInOnClick(curElemObj);
  });
  
  $('#vKontaktformularBuilderElemRequiredFrm').change(function() {
    if ($(this).is(':checked')) {
      $('#vFrontIsErrorTextShowForm').slideDown(200);
    }
    else {
      $('#vFrontIsErrorTextShowForm').slideUp(200);
    }
  });
}



function saveBearElemInOnClick(curElemObj) {
  if (checkIsBearDataFromElemOk(curElemObj)) {
    curElemObj.attr('data-name', $('#vKontaktformularBuilderElemDataFrm').val());
    curElemObj.attr('data-label', $('#vKontaktformularBuilderElemLabelFrm').val());
    
    if (curElemObj.attr('data-art') != 3) {
      if ($('#vKontaktformularBuilderElemRequiredFrm').is(':checked')) {
        curElemObj.attr('data-required', 'yes');
        curElemObj.attr('data-error', $('#vKontaktformularBuilderElemErrorTextFrm').val());
      }
      else {
        curElemObj.attr('data-required', 'no');
        curElemObj.attr('data-error', '');
      }
    }
    
    if (curElemObj.attr('data-art') == 1) {
      if ($('#vKontaktformularBuilderElemIsMailSendFrm').is(':checked')) {
        $('#vFrontKontaktFormBuilderSettingFieldMail').val($('#vKontaktformularBuilderElemDataFrm').val());
      }
      else {
        if ($('#vFrontKontaktFormBuilderSettingFieldMail').val() == curElemObj.attr('data-name')) {
          $('#vFrontKontaktFormBuilderSettingFieldMail').val('');
        }
      }
      
      if ($('#vKontaktformularBuilderElemFirstNameFrm').is(':checked')) {
        $('#vFrontKontaktFormBuilderSettingFieldFirstName').val($('#vKontaktformularBuilderElemDataFrm').val());
      }
      else {
        if ($('#vFrontKontaktFormBuilderSettingFieldFirstName').val() == curElemObj.attr('data-name')) {
          $('#vFrontKontaktFormBuilderSettingFieldFirstName').val('');
        }
      }
      
      if ($('#vKontaktformularBuilderElemLastNameFrm').is(':checked')) {
        $('#vFrontKontaktFormBuilderSettingFieldLastName').val($('#vKontaktformularBuilderElemDataFrm').val());
      }
      else {
        if ($('#vFrontKontaktFormBuilderSettingFieldLastName').val() == curElemObj.attr('data-name')) {
          $('#vFrontKontaktFormBuilderSettingFieldLastName').val('');
        }
      }
    }
    
    if (curElemObj.attr('data-art') == 4) {
      curElemObj.attr('data-options', $('#vKontaktformularBuilderElemOptionsFrm').val());
    }
    
    closeCenterWindowSmallSettingsImgVerwalt();
    buildKontaktFormBuilderAdminWindowJsonStringByElems();
    buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
  }
}



function checkIsBearDataFromElemOk(curElemObj) {
  var errorText = '';
  
  if ($('#vKontaktformularBuilderElemDataFrm').val() == '') {
    errorText += 'Bitte geben Sie einen Feld Name ein!<br />';
  }
  if ($('#vKontaktformularBuilderElemDataFrm').val() != '' && !checkKontaktBuilderValidElemField($('#vKontaktformularBuilderElemDataFrm').val())) {
    errorText += 'Der Feld Name enthält ungültige Zeichen!<br />';
  }
  if ($('#vKontaktformularBuilderElemLabelFrm').val() == '') {
    errorText += 'Bitte geben Sie einen Label Name ein!<br />';
  }
  
  if (curElemObj.attr('data-art') != 3) {
    if ($('#vKontaktformularBuilderElemRequiredFrm').is(':checked')) {
      if ($('#vKontaktformularBuilderElemErrorTextFrm').val() == '') {
        errorText += 'Bitte geben Sie einen Fehler Text ein!<br />';
      }
    }
  }
  
  if (curElemObj.attr('data-art') == 4) {
    if ($('#vKontaktformularBuilderElemOptionsFrm').val() == '') {
      errorText += 'Bitte geben Sie die DropDown Optionen ein!<br />';
    }
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function checkKontaktBuilderValidElemField(curTextUri) {
  var validuriregex = /^[a-zA-Z0-9_\-]+$/i;
  return validuriregex.test(curTextUri);
}

// *****************************************************************************
// ENDE - Funktionen für Builder Elemente Bearbeiten
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder - Builder Drag and Drops setzen
// *****************************************************************************

function setKontaktFormBuilderAdminWindowNewContainerElem(dropObj, curFormDragElemId) {
  var newCountContainer = parseInt($('#vFrontKontaktFormBuilderContainerCount').val()) + 1;
  
  var curSetHtml = '<fieldset class="vFrontKontaktFormBuilderContainerIsSetStruct" data-id="'+newCountContainer+'">';
  curSetHtml += '<legend>Container '+newCountContainer+'</legend>';
  //curSetHtml += '<div class="vFrontKontaktFormBuilderDragPlaceInner"></div>';
  curSetHtml += '</fieldset>';
  
  dropObj.replaceWith(curSetHtml);
  
  $('#vFrontKontaktFormBuilderContainerCount').val(newCountContainer);
  
  buildKontaktFormBuilderAdminWindowJsonStringByElems();
  buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
}



function setKontaktFormBuilderAdminWindowNewOtherElem(dropObj, curFormDragElemId) {
  var newCountElem = parseInt($('#vFrontKontaktFormBuilderFormCount').val()) + 1;
  var curElemArtNumber = getKontaktFormBuilderAdminWindowCurFormArt(curFormDragElemId);
  
  var curSetHtml = '<div class="vFrontKontaktFormBuilderElemIsSetStruct" data-art="'+curElemArtNumber+'" data-name="vfrmField'+newCountElem+'" data-label="Neues Feld" data-required="no" data-error="" data-options="">';
  curSetHtml += '<span>'+getKontaktFormBuilderAdminWindowCurFormArtName(curElemArtNumber)+' (Neues Feld)</span>';
  curSetHtml += '</div>';
  
  dropObj.replaceWith(curSetHtml);
  
  $('#vFrontKontaktFormBuilderFormCount').val(newCountElem);
  
  buildKontaktFormBuilderAdminWindowJsonStringByElems();
  buildKontaktFormBuilderAdminWindowAllElemsByJsonString();
}

// *****************************************************************************
// ENDE - Funktionen für Builder - Builder Drag and Drops setzen
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder - Elem List Name, Art und Icons
// *****************************************************************************

function getKontaktFormBuilderAdminWindowCurFormArt(curFormDragElemId) {
  if (curFormDragElemId == "vFrontKontaktFormBuilderDragElemIsTextfeld") {
    return 1;
  }
  else if (curFormDragElemId == "vFrontKontaktFormBuilderDragElemIsTextarea") {
    return 2;
  }
  else if (curFormDragElemId == "vFrontKontaktFormBuilderDragElemIsCheckbox") {
    return 3;
  }
  else if (curFormDragElemId == "vFrontKontaktFormBuilderDragElemIsDropDown") {
    return 4;
  }
}



function getKontaktFormBuilderAdminWindowCurFormArtName(curFormArtNumber) {
  if (curFormArtNumber == 1) {
    return "Textfeld";
  }
  else if (curFormArtNumber == 2) {
    return "Textarea";
  }
  else if (curFormArtNumber == 3) {
    return "Checkbox";
  }
  else if (curFormArtNumber == 4) {
    return "DropDown";
  }
}



function getKontaktFormBuilderAdminWindowCurFormArtIco(curFormArtNumber) {
  if (curFormArtNumber == 1) {
    return '<i class="fa fa-square-o"></i>';
  }
  else if (curFormArtNumber == 2) {
    return '<i class="fa fa-square"></i>';
  }
  else if (curFormArtNumber == 3) {
    return '<i class="fa fa-check-square-o"></i>';
  }
  else if (curFormArtNumber == 4) {
    return '<i class="fa fa-caret-square-o-down"></i>';
  }
}

// *****************************************************************************
// ENDE - Funktionen für Builder - Elem List Name, Art und Icons
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Builder - Json String und Elemente erstellen
// *****************************************************************************

function buildKontaktFormBuilderAdminWindowJsonStringByElems() {
  var curJsonString = '{';
  curJsonString += '"KontaktformName":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingKontaktformName').val());
  curJsonString += ', "FieldMail":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingFieldMail').val());
  curJsonString += ', "FieldFirstName":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingFieldFirstName').val());
  curJsonString += ', "FieldLastName":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingFieldLastName').val());
  curJsonString += ', "FieldBetreff":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingFieldBetreff').val());
  curJsonString += ', "Absender":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingAbsender').val());
  curJsonString += ', "AbsenderMail":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingAbsenderMail').val());
  curJsonString += ', "CaptchaOn":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingCaptchaOn').val());
  curJsonString += ', "DankeSeiteText":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingDankeSeiteText').val());
  curJsonString += ', "MailTextHeader":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingMailTextHeader').val());
  curJsonString += ', "MailTextFooter":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingMailTextFooter').val());
  
  curJsonString += ', "SendButtonText":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingSendButtonText').val());
  
  curJsonString += ', "BestaetigungMailAktiv":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMail').val());
  curJsonString += ', "BestaetigungMailBetreff":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff').val());
  curJsonString += ', "BestaetigungMailText":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailText').val());
  curJsonString += ', "BestaetigungMailAbsender":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsender').val());
  curJsonString += ', "BestaetigungMailAbsenderMail":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailAbsenderMail').val());
  
  // Für Spracheinträge
  // ********************************************************
  var allLangElemDivsAS = $('#vFrontCenterWindowBigInhalt').find('.vFrontKontaktFormBuilderLangDivIs');
  $.each(allLangElemDivsAS, function() {
    curJsonString += ', "DankeSeiteText-'+$(this).attr('data-name')+'":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingDankeSeiteText-'+$(this).attr('data-name')).val());
    curJsonString += ', "SendButtonText-'+$(this).attr('data-name')+'":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingSendButtonText-'+$(this).attr('data-name')).val());
    curJsonString += ', "BestaetigungMailBetreff-'+$(this).attr('data-name')+'":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailBetreff-'+$(this).attr('data-name')).val());
    curJsonString += ', "BestaetigungMailText-'+$(this).attr('data-name')+'":'+JSON.stringify($('#vFrontKontaktFormBuilderSettingBestaetigungMailText-'+$(this).attr('data-name')).val());
  });
  // ********************************************************
  
  curJsonString += ', "ContainerCount":'+JSON.stringify($('#vFrontKontaktFormBuilderContainerCount').val());
  curJsonString += ', "FormCount":'+JSON.stringify($('#vFrontKontaktFormBuilderFormCount').val());
  curJsonString += ', "FormData":';
  
  var curHolderCont = $('.vFrontKontaktFormBuilderDragHolder');
  var allContainers = curHolderCont.find('> .vFrontKontaktFormBuilderContainerIsSetStruct');
  
  if (allContainers.length > 0) {
    var counterJJ = 0;
    curJsonString += '[';
    $.each(allContainers, function() {
      counterJJ++;
      if (counterJJ == 1) {
        curJsonString += '{"Container":[';
      }
      else {
        curJsonString += ', {"Container":[';
      }
      
      // Für Elemente im Container
      // ***********************************************************************
      var counterEE = 0;
      var allElems = $(this).find('> .vFrontKontaktFormBuilderElemIsSetStruct');
      $.each(allElems, function() {
        var CurLangElId = $(this).attr('data-id');
        
        counterEE++;
        var curTrenner = '';
        if (counterEE > 1) {
          curTrenner = ', ';
        }
        curJsonString += curTrenner+'{"Art":"'+$(this).attr('data-art')+'", "Name":'+JSON.stringify($(this).attr('data-name'))+', "Label":'+JSON.stringify($(this).attr('data-label'))+', "Error":'+JSON.stringify($(this).attr('data-error'))+', "Required":"'+$(this).attr('data-required')+'", "Options":'+JSON.stringify($(this).attr('data-options'))+'';
        
        // Für Spracheinträge
        // ********************************************************
        var allLangElemDivsJ = $('#vFrontCenterWindowBigInhalt').find('.vFrontKontaktFormBuilderLangDivIs');
        $.each(allLangElemDivsJ, function() {
          var curLangDivE = $('.vFrontKontaktFormBuilderDragHolder').find('#'+CurLangElId+'-'+$(this).attr('data-name')).first();
          curJsonString += ', "lang_'+$(this).attr('data-name')+'":{"Label":"'+curLangDivE.attr('data-label')+'", "Error":"'+curLangDivE.attr('data-error')+'", "Options":"'+curLangDivE.attr('data-options')+'"}';
        });
        // ********************************************************
        
        curJsonString += '}';
      });
      // ***********************************************************************
      
      curJsonString += ']}';
    });
    
    curJsonString += ']';
  }
  else {
    curJsonString += '[]';
  }
  
  curJsonString += '}';

  $('#vFrontKontaktFormBuilderJsonFormsString').val(curJsonString);
}







function buildKontaktFormBuilderAdminWindowAllElemsByJsonString() {
  var curSetHtml = '<div class="vFrontKontaktFormBuilderDragPlaceOuter"></div>';
  var allElemsObj = JSON.parse($('#vFrontKontaktFormBuilderJsonFormsString').val());//$.parseJSON($('#vFrontKontaktFormBuilderJsonFormsString').val());
  var newCountContainer = 0;
  var newCountElemForLang = 0;
  
  $.each(allElemsObj.FormData, function(key, value) {
    newCountContainer++;
    
    curSetHtml += '<fieldset class="vFrontKontaktFormBuilderContainerIsSetStruct">';
    curSetHtml += '<legend>Container</legend>';
    curSetHtml += '<div class="vFrontKontaktFormBuilderContainerIsSetStructDelBtn" title="Löschen"></div>';
    curSetHtml += '<div class="vFrontKontaktFormBuilderDragPlaceInner"></div>';
    $.each(value.Container, function(key, value) {
      newCountElemForLang++;
      
      // Für Spracheinträge
      // ********************************************************
      var allLangElemDivs = $('#vFrontCenterWindowBigInhalt').find('.vFrontKontaktFormBuilderLangDivIs');
      $.each(allLangElemDivs, function() {
        try {
          curSetHtml += '<div id="vFrontKontaktFormBuilderLangId-'+newCountElemForLang+'-'+$(this).attr('data-name')+'" data-label="'+value['lang_'+$(this).attr('data-name')]['Label']+'" data-error="'+value['lang_'+$(this).attr('data-name')]['Error']+'" data-options="'+value['lang_'+$(this).attr('data-name')]['Options']+'"></div>';
        }
        catch(ex) {
          curSetHtml += '<div id="vFrontKontaktFormBuilderLangId-'+newCountElemForLang+'-'+$(this).attr('data-name')+'" data-label="" data-error="" data-options=""></div>';
        }
      });
      // ********************************************************
      
      curSetHtml += '<div data-id="vFrontKontaktFormBuilderLangId-'+newCountElemForLang+'" class="vFrontKontaktFormBuilderElemIsSetStruct" data-art="'+value.Art+'" data-name="'+value.Name+'" data-label="'+value.Label+'" data-required="'+value.Required+'" data-error="'+value.Error+'" data-options="'+value.Options+'">';
      curSetHtml += getKontaktFormBuilderAdminWindowCurFormArtIco(value.Art)+'<span>'+getKontaktFormBuilderAdminWindowCurFormArtName(value.Art)+' <span style="font-size:11px;">('+value.Label+')</span></span>';
      curSetHtml += '<div class="vFrontKontaktFormBuilderElemIsSetStructChangeBtn" title="Bearbeiten"></div>';
      curSetHtml += '<div class="vFrontKontaktFormBuilderElemIsSetStructDelBtn" title="Löschen"></div>';
      
      curSetHtml += '<div style="display:none;" class="vFrontKontaktFormBuilderElemIsSetStructChangeBtnOnLang" title="Bearbeiten"></div>';
      
      curSetHtml += '</div>';
      
      curSetHtml += '<div class="vFrontKontaktFormBuilderDragPlaceInner"></div>';
    });
    curSetHtml += '</fieldset>';
    
    curSetHtml += '<div class="vFrontKontaktFormBuilderDragPlaceOuter"></div>';
  });
  
  $('.vFrontKontaktFormBuilderDragHolder').html(curSetHtml);
  
  initKontaktFormBuilderAdminWindowDragPlaces();
  initKontaktFormBuilderAdminWindowSortFunctions();
  initKontaktFormBuilderAdminWindowBtnsFunctions();
  
  if ($('.vFrontKontaktFormInnerElemsBtnDropsHideMM').hasClass('isDropsHide')) {
    var allOuterDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceOuter');
    allOuterDrops.hide();
    var allInnerDrops = $('.vFrontKontaktFormBuilderDragHolder').find('.vFrontKontaktFormBuilderDragPlaceInner');
    allInnerDrops.hide();
  }
  
  if ($('#vFrontKontaktFormBuilderLangChangeSelectOpt').val() != '') {
    hideDiverseElemsByLangSelect();
  }
}

// *****************************************************************************
// ENDE - Funktionen für Builder - Json String und Elemente erstellen
// *****************************************************************************