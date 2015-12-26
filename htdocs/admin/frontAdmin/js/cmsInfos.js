/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/




// *****************************************************************************
// ANFANG - Funktionen für CMS Info Window anzeigen
// *****************************************************************************

function showCmsInfosWindowNow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallInfoCMS').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallInfoCMSInhalt').html('');
  $('#vFrontCenterWindowSmallInfoCMSInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmallInfoCMS').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCmsInfosWindowNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallInfoCMSInhalt').html(data);
      initCmsInfosWindowFunctions();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initCmsInfosWindowFunctions() {
  $('.vFrontCmsInfosInWindowTextUpdateBtn').click(function() {
    if (!$(this).hasClass('vCmsUpdateIsChecked')) {
      $(this).addClass('vCmsUpdateIsChecked');
      $('.vFrontCmsInfosInWindowTextUpdateInfoPos').html('<img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" style="vertical-align:middle;" />&nbsp;&nbsp;Update wird geprüft');
      window.setTimeout("checkCmsInfoIsNewUpdateVersionNow()", 1000);
    }
  });
}



function checkCmsInfoIsNewUpdateVersionNow() {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'checkCmsInfoIsNewUpdateVersionNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontCmsInfosInWindowTextUpdateInfoPos').html(data);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für CMS Info Window anzeigen
// *****************************************************************************