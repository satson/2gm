/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2015                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/




function showFilterSystemAdminWindow() {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Filter System - Kategorien');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showFilterSystemAdminWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initFilterSystemAdminWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initFilterSystemAdminWindow() {
  $('.mmModulFiltersysAdminWindowHeadNewFiltKatBtn').click(function() {
    showNewFiltersystemAdminKatgorieWindow();
  });
  
  $('.vFrontFiltersysAdminWinListChangeBtn').click(function() {
    showBearFiltersystemAdminKatgorieWindow($(this).attr('data-id'));
  });
  
  $('.vFrontFiltersysAdminWinListDelBtn').click(function() {
    var checkerDel = confirm('Möchten Sie die Filterkategorie wirklich löschen?');
    if (checkerDel == true) {
      delFiltersystemAdminKatgorieNow($(this).attr('data-id'));
    }
  });
  
    showImagesWindow();
}







function showNewFiltersystemAdminKatgorieWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsZindexO').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsZindexOHeadInhalt').html('Neue Filter Kategorie erstellen');
  $('#vFrontOverlaySix').show();
  $('#vFrontCenterWindowSmallSettingsZindexO').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showNewFiltersystemAdminKatgorieWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html(data);
      initNewFiltersystemAdminKatgorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initNewFiltersystemAdminKatgorieWindow() {
  $('#vFrontSaveNewNewFiltersystemKatForms').click(function() {
    if (newFiltersystemAdminKatgorieWindowDataCheck()) {
      saveNewFiltersystemAdminKatgorieWindow();
    }
  });
}



function newFiltersystemAdminKatgorieWindowDataCheck() {
  var errorText = '';
  
  if ($('#vFiltersystemFrmFiltKatName').val() == '') {
    errorText += 'Bitte geben Sie einen Filter Kategorie Namen ein!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function saveNewFiltersystemAdminKatgorieWindow() {
  showCmsIsLoading();
  var filterData = $('.filterS').serialize();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewFiltersystemAdminKatgorieWindow',filterData:filterData, VCMS_POST_LANG: $('body').attr('data-lang'),_position:$('#vFiltersystemFrmFiltPosition').val(), _filterKatName: $('#vFiltersystemFrmFiltKatName').val(),_filterParentId: $('#filterParentId').val(), _langFilterKat: $('#vFiltersystemFrmFiltKatNameLangs').serializeArray()},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsZindexO();
      showOkWindowNow('Die Filter Kategorie wurde erfolgreich erstellt.');
      showFilterSystemAdminWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}







function showBearFiltersystemAdminKatgorieWindow(curFilterKatID) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsZindexO').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsZindexOHeadInhalt').html('Filter Kategorie bearbeiten');
  $('#vFrontOverlaySix').show();
  $('#vFrontCenterWindowSmallSettingsZindexO').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBearFiltersystemAdminKatgorieWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _filterKatID: curFilterKatID},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsZindexOInhalt').html(data);
      initBearFiltersystemAdminKatgorieWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initBearFiltersystemAdminKatgorieWindow() {
  $('#vFrontSaveBearFiltersystemKatForms').click(function() {
    if (newFiltersystemAdminKatgorieWindowDataCheck()) {
      saveBearFiltersystemAdminKatgorieWindow($(this).attr('data-id'));
    }
  });
}



function saveBearFiltersystemAdminKatgorieWindow(curFilterKatID) {
  showCmsIsLoading();
  var filterData = $('.filterS').serialize();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveBearFiltersystemAdminKatgorieWindow',filterData:filterData, VCMS_POST_LANG: $('body').attr('data-lang'),'_position':$('#vFiltersystemFrmFiltPosition').val(), _filterKatName: $('#vFiltersystemFrmFiltKatName').val(), _filterParentId: $('#filterParentId').val(), _langFilterKat: $('#vFiltersystemFrmFiltKatNameLangs').serializeArray(), _curFilterKatID: curFilterKatID},
    success: function(data) {
      hideCmsIsLoading();
      closeCenterWindowSmallSettingsZindexO();
      showOkWindowNow('Die Filter Kategorie wurde erfolgreich gespeichert.');
      showFilterSystemAdminWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}







function delFiltersystemAdminKatgorieNow(curFilterKatID) {
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delFiltersystemAdminKatgorieNow', VCMS_POST_LANG: $('body').attr('data-lang'), _filterKatID: curFilterKatID},
    success: function(data) {
      hideCmsIsLoading();
      showOkWindowNow('Die Filter Kategorie wurde erfolgreich gelöscht.');
      showFilterSystemAdminWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}


//2.10.2015//////////

function showImagesWindow(){
    
    $('body').on('click', '.filterGalleryWindow',function(){
        console.log('dddddddddddddd');
        
       var  idFilter = $(this).data('id');
  
        var abstandLeft = ($(window).width() / 2) - (500 / 2);
        $('#vFrontCenterWindowSmallSettings').css({'left':abstandLeft + 'px','z-index':11065});

        $('#vFrontCenterWindowSmallSettings').addClass('vFrontSetBigWindowClassNow');

        $('#vFrontCenterWindowSmallSettingsInhalt').html('');
        $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
        $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Bilder zuweisen');
        $('#vFrontOverlay').show();
        $('#vFrontCenterWindowSmallSettings').show();

        $.ajax({
          type: "POST",
          url: "admin/frontAdmin/ajax_php/ajax.php",
          data: {_art: 'showFilterImageWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _idFilter:idFilter},
          success: function(data) {
            $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
           // $('#vFrontCenterWindowSmallSettings').css({'z-index':100000});
        
            initEigenElemPicGalImagesWindowAuswahl();
            
            addImageWindow();
          },
          error: function() {
            showAjaxFehler();
          }
  });
        
        
    })
   
    
}

function addImageWindow(){
    
    $('body').on('click','#addImageToFilter',function() {
         var type = $(this).data('type');  
     console.log(type);
  var abstandLeft = ($(window).width() / 2) - (560 / 2);   
  $('#vFrontCenterWindowImageAuswahl').css({'left':abstandLeft + 'px','z-index':11066});
  });
  
  
  
  }
  




 $('body').on('click', '#vSaveOwnFilterPicGalChange', function() {
    showCmsIsLoading();
    var description = $('.filterDescription').serialize();
    
    console.log(description);
    
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'vSaveOwnFilterPicGalChange', VCMS_POST_LANG: $('body').attr('data-lang'),_description:description, _selemID: $(this).attr('data-id'), _picGalImages: $('#vFrontFrmOwnElemPicGalImgs').val(), _picGalElemID: $('#vFrontFrmOwnElemPicGalsElem').val()},
      success: function(data) {
        if (data == true) {
          closeCenterWindowSmallSettings();
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
  });



















