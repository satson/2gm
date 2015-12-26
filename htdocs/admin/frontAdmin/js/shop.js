/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



$(document).ready(function() {
  
  $('#vFrontShopProductsButton').click(function() {
    showHpProductsListWindow();
    showHpProductsListInWindowNow();
  });
  
});




function showHpProductsListWindow() {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowHpProductList').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowHpProductListInhalt').html('');
  $('#vFrontCenterWindowHpProductListInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowHpProductListHeadInhalt').html('Shop Produkte');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowHpProductList').show();
}



function showHpProductsListInWindowNow() {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpProductsListInWindowNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowHpProductListInhalt').html(data);
      initHpShopProductListElems();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpShopProductListElems() {
  $('#vFrontModulShopNewProductBtn').click(function() {
    showNewProductElementWindow();
  });
  
  $('.vFrontModulShopListElemNaviChange').click(function() {
    showBearProductElementWindow($(this).attr('data-id'));
  });
  
  $('.vFrontModulShopListElemNaviDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Produkt wirklich löschen?');
    if (checkerDel == true) {
      deleteThisShopProductNow($(this), $(this).parent().parent());
    }
  });
}



function deleteThisShopProductNow(curProductDelObj, curProductObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'deleteThisShopProductNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curProductID: curProductDelObj.attr('data-id')},
    success: function(data) {
      if (data == true) {
        curProductObj.fadeOut(300, function() {
          curProductObj.remove();
        });
        showOkWindowNow('Das Produkt wurde erfolgreich gelöscht.');
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



function showNewProductElementWindow() {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowHpProductNew').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowHpProductNewInhalt').html('');
  $('#vFrontCenterWindowHpProductNewInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowHpProductNewHeadInhalt').html('Neues Produkt erstellen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowHpProductNew').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showNewProductFormsInWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowHpProductNewInhalt').html(data);
      initShopProductForms();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showBearProductElementWindow(curProductId) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowHpProductNew').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowHpProductNewInhalt').html('');
  $('#vFrontCenterWindowHpProductNewInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowHpProductNewHeadInhalt').html('Produkt bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowHpProductNew').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBearProductFormsInWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPrId: curProductId},
    success: function(data) {
      $('#vFrontCenterWindowHpProductNewInhalt').html(data);
      initShopProductForms();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initShopProductForms() {
  $('#vFrontCenterWindowHpProductNewInhalt').scrollTop(0);
  
  $('#vFrontShopProductDesc').tinymce({
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

    }
  });
  
  $('#vFrontShopProductPreis').blur(function() {
    if ($('#vFrontShopProductPreis').val() != '') {
      var BetragN = parseFloat($(this).val().replace(',', '.'));
      BetragN = BetragN.toFixed(2);
      BetragN = BetragN.replace('.', ',');
      $(this).val(BetragN);
    }
  });
  
  $('#vFrontShopProductRabatt').blur(function() {
    if ($('#vFrontShopProductRabatt').val() != '' && $('#vFrontShopProductRabattChange').val() == 'betrag') {
      var BetragN = parseFloat($(this).val().replace(',', '.'));
      BetragN = BetragN.toFixed(2);
      BetragN = BetragN.replace('.', ',');
      $(this).val(BetragN);
    }
  });
  
  $('#vFrontShopProductRabattChange').change(function() {
    if ($(this).val() != '') {
      $('#vFrontShopProductRabatt').show();
    }
    else {
      $('#vFrontShopProductRabatt').hide();
      $('#vFrontShopProductRabatt').val('');
    }
  });
  
  $('#vFrontShopProductNewBildBtn').click(function() {
    showWindowImageAuswahlShopProductPic();
  });
  
  $('#vFrontShopProductSaveBtn').click(function() {
    if (checkShopProductSaveData()) {
      saveNewProductShopNow();
    }
  });
  
  $('#vFrontShopProductSaveBearbeitBtn').click(function() {
    if (checkShopProductSaveData()) {
      saveBearbeitProductShopNow($(this).attr('data-id'));
    }
  });
  
  $('#vFrontShopProductShowBildverwaltung').click(function() {
    // Funktion ist in der functions.js (ist die Allgemeine Funktion für die Bildverwaltung anzeige)
    showImageVerwaltung();
  });
  
  $('#vFrontShopProductRabattChange').msDropdown();
  $('#vFrontShopProductRabattChange').change();
}



function showWindowImageAuswahlShopProductPic() {
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
      initImageAuswahlWindowShopProductPic();
      initImageAuswahlWindowShopProductPicKatSelect();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initImageAuswahlWindowShopProductPic() {
  $('.vFrontAuswahlImgElement').dblclick(function() {
    $('#vFrontShopProductBild').val($(this).attr('data-id'));
    $('#vFrontShopProductNewBildHolder').html('<img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" />');
    $('#vFrontShopProductNewBildHolder').show();
    $('#vFrontShopProductNewBildBtn').html('Bild ändern');
    closeCenterWindowImageAuswahl();
  });
}


// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlWindowShopProductPicKatSelect() {
  $('#vFrontBildAuswahlKatSelect').msDropdown();
  
  $('#vFrontBildAuswahlKatSelect').change(function() {
    showImageAuswahlWindowShopProductPicReload($(this).val());
  });
}



function showImageAuswahlWindowShopProductPicReload(curKatId) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initImageAuswahlWindowShopProductPic();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************



function checkShopProductSaveData() {
  var shprErrorText = '';
  
  if ($('#vFrontShopProductName').val() == '') {
    shprErrorText += 'Bitte geben Sie einen Name ein!<br />';
  }
  if ($('#vFrontShopProductPreis').val() == '') {
    shprErrorText += 'Bitte geben Sie einen Preis ein!<br />';
  }
  if ($('#vFrontShopProductPreis').val() != '' && isNaN($('#vFrontShopProductPreis').val().replace(',', '.'))) {
    shprErrorText += 'Der Preis ist nicht gültig!<br />';
  }
  if ($('#vFrontShopProductSteuer').val() == '') {
    shprErrorText += 'Bitte geben Sie einen Steuersatz ein!<br />';
  }
  else if ($('#vFrontShopProductSteuer').val() != '' && !oIsInt($('#vFrontShopProductSteuer').val())) {
    shprErrorText += 'Der Steuersatz ist nicht gültig!<br />';
  }
  if ($('#vFrontShopProductRabattChange').val() != '') {
    if ($('#vFrontShopProductRabatt').val() == '') {
      shprErrorText += 'Bitte geben Sie einen Rabatt ein!<br />';
    }
    else if ($('#vFrontShopProductRabattChange').val() == 'betrag' && isNaN($('#vFrontShopProductRabatt').val().replace(',', '.'))) {
      shprErrorText += 'Bitte geben Sie einen gültigen Rabatt Betrag ein!<br />';
    }
    else if ($('#vFrontShopProductRabattChange').val() == 'prozent' && isNaN($('#vFrontShopProductRabatt').val().replace(',', '.'))) {
      shprErrorText += 'Bitte geben Sie einen gültigen Rabatt Prozent Wert ein!<br />';
    }
  }
  
  if (shprErrorText != '') {
    showErrorWindowNow(shprErrorText);
    return false;
  }
  else {
    return true;
  }
}



function oIsInt(value) {
  var er = /^[0-9]+$/;
  return (er.test(value)) ? true : false;
}



function saveNewProductShopNow() {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewProductShopNow', VCMS_POST_LANG: $('body').attr('data-lang'), _prName: $('#vFrontShopProductName').val(), _prPreis: $('#vFrontShopProductPreis').val(), _prSteuersatz: $('#vFrontShopProductSteuer').val(), _prBildId: $('#vFrontShopProductBild').val(), _prDescSmall: $('#vFrontShopProductSmallDesc').val(), _prDesc: $('#vFrontShopProductDesc').val(), _prRabattChange: $('#vFrontShopProductRabattChange').val(), _prRabatt: $('#vFrontShopProductRabatt').val()},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Das Produkt wurde erfolgreich erstellt!');
        closeCenterWindowHpProductNew();
        showHpProductsListInWindowNow();
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



function saveBearbeitProductShopNow(curProductShopId) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveBearbeitProductShopNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curPrId: curProductShopId, _prName: $('#vFrontShopProductName').val(), _prPreis: $('#vFrontShopProductPreis').val(), _prSteuersatz: $('#vFrontShopProductSteuer').val(), _prBildId: $('#vFrontShopProductBild').val(), _prDescSmall: $('#vFrontShopProductSmallDesc').val(), _prDesc: $('#vFrontShopProductDesc').val(), _prRabattChange: $('#vFrontShopProductRabattChange').val(), _prRabatt: $('#vFrontShopProductRabatt').val()},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Das Produkt wurde erfolgreich gespeichert!');
        closeCenterWindowHpProductNew();
        showHpProductsListInWindowNow();
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