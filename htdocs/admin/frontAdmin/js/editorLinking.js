/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



function showCmsEditorLinkWindow(curEditorLinkField, url) {
  $('#mce-modal-block').addClass('mce-modal-block-set-zindex');
  $('.mce-window').addClass('mce-window-set-zindex');
  
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
  
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCmsEditorLinkWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curInhaltUri: url},
    success: function(data) {
      $('#vFrontCenterWindowSmallInhalt').html(data);
      initCmsEditorLinkWindowFunctions(curEditorLinkField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initCmsEditorLinkWindowFunctions(curEditorLinkField) {
  $('.vFrontLinkingArtMenuPoint').click(function() {
    $('.vFrontLinkingArtMenuPoint').removeClass('vFrontActiveArtPoint');
    $(this).addClass('vFrontActiveArtPoint');
  });
  
  $('.vFrontLinkingArtMenuPoint').click(function() {
    hideAllEditorLinkingArtForms();
    showCurentEditorLinkingArtForms($(this).attr('data-id'));
  });
  
  
  $('#linkingDelBtn').click(function() {
    $('#'+curEditorLinkField).val('');
    closeCenterWindowSmall();
  });
  
  $('#editorLinkingSaveBtn').click(function() {
    if (checkEditorLinkUserDataNow()) {
      generateAndSetTheLink(curEditorLinkField);
    }
  });
  
  
  // Funktionen sind in linking.js definiert
  $('#linkingShowSeitenAuswahlWinBtn').click(function() {
    showLinkingSeitenauswahlWin();
  });
  $('#linkingShowBildAuswahlWinBtn').click(function() {
    showLinkingBildauswahlWin();
  });
  $('#linkingShowDateiAuswahlWinBtn').click(function() {
    showLinkingDateiauswahlWin();
  });
}



function checkEditorLinkUserDataNow() {
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



function generateAndSetTheLink(curEditorLinkField) {
  $('#'+curEditorLinkField).val('@[art:'+$('.vFrontActiveArtPoint').attr('data-id')+'][id:'+$('#linkingLink').val()+']');
  closeCenterWindowSmall();
}







// *****************************************************************************
// ANFANG - Funktionen für Editor Linking Art umschaltungen
// *****************************************************************************

function showCurentEditorLinkingArtForms(curArtName) {
  /*if (curArtName == 'normal') {
    $('.linkingLinkNormalAnzeige').show();
  }*/
  if (curArtName == 'seite') {
    $('.linkingLinkSeitenAnzeige').show();
  }
  else if (curArtName == 'bild') {
    $('.linkingLinkBildAnzeige').show();
  }
  else if (curArtName == 'datei') {
    $('.linkingLinkDateiAnzeige').show();
  }
}



function hideAllEditorLinkingArtForms() {
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
// ENDE - Funktionen für Editor Linking Art umschaltungen
// *****************************************************************************