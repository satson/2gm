/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



// *****************************************************************************
// ANFANG - Funktionen für Homepage Einstellungen Allgemein
// *****************************************************************************

function initHpSettingLeftMenu() {
  
  $('#vFrontHpSeAllgemein').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeAllgemeinReload($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeElemente').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeElemente($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeLayouts').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeSeitenlayouts($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeNaviArt').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeNaviArts($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeUser').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeUser($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeSprachen').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeSprachen($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeModule').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeModuleVerwaltung($(this).attr('id'));
    }
  });
  
  $('#vFrontHpSeSitemap').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showHpSeSitemapGenerator($(this).attr('id'));
    }
  });
  
  
  $('#vFrontHpOrderModule').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showOrdersSettings($(this).attr('id'));
      saveOrderSetting();
    }
  });
  
  
    $('#vFrontHpFilterModule').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
       showFiltersSettings($(this).attr('id'));
            saveFilterSetting();
    }
  });
  
  
   $('#vFrontHpBasketModule').click(function() {
    if (!$(this).hasClass('vFrontActiveHpS')) {
      unsetAllActiveHpSeMenuPoints();
      setThisActiveHpSeMenuPoint($(this));
      showBasketSetting();
     // saveOrderSetting();
    }
  });
  
    $('#vFrontHpTimeModule').click(function() {
        if (!$(this).hasClass('vFrontActiveHpS')) {
          unsetAllActiveHpSeMenuPoints();
          setThisActiveHpSeMenuPoint($(this));
          showTimeSetting();  
        }
  });
 
    $('body').on('click', '#vFrontCancelNewHash',function(){
     unsetAllActiveHpSeMenuPoints();
     setThisActiveHpSeMenuPoint($(this));
     showTimeSetting(); 
   })
  
  
}



function unsetAllActiveHpSeMenuPoints() {
  $('.vFrontHpSettingMenuPoint').removeClass('vFrontActiveHpS');
}



function setThisActiveHpSeMenuPoint(curMenuPoint) {
  curMenuPoint.addClass('vFrontActiveHpS');
}



function showHpSePointLoader() {
  $('.vFrontHpSettingInhaltHolder').html('');
  $('.vFrontHpSettingInhaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
}

// *****************************************************************************
// ENDE - Funktionen für Homepage Einstellungen Allgemein
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Allgemein
// *****************************************************************************

function showHpSeAllgemeinReload(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeAllgemeinNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeAllgemeinNow() {
  $('#vFrontHpSeAllTemplate').msDropdown();
  
  $('#vFrontSaveHpSeAllgemein').click(function() {
    if (checkSaveHpSeAllgemeinData()) {
      saveHpSeAllgemeinNow($(this).attr('data-id'));
    }
  });
}



function saveHpSeAllgemeinNow(curHpId) {
  showCmsIsLoading();
  var hpIsOffline = 1;
  
  if ($('#vFrontHpSeAllOffline').is(':checked')) {
    hpIsOffline = 2;
  }
  
  var hpSeMetaLangJSON = buildHpSeMetaLangsDataJSON();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveHpSeAllgemeinNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curHpId: curHpId, _curHpName: $('#vFrontHpSeAllName').val(), _curHpTemplate: $('#vFrontHpSeAllTemplate').val(), _hpOffline: hpIsOffline, _hpHeaderCode: $('#vFrontHpSeAllHeaderCode').val(), _hpSeMetaLangJSON: hpSeMetaLangJSON},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Die allgemeinen Homepage Einstellungen wurden erfolgreich gespeichert.');
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



function checkSaveHpSeAllgemeinData() {
  var errorTextHpSeAllg = '';
  
  if ($('#vFrontHpSeAllName').val() == '') {
    errorTextHpSeAllg += 'Bitte geben Sie einen Homepage Name ein!<br />';
  }
  if ($('#vFrontHpSeAllTemplate').val() == '') {
    errorTextHpSeAllg += 'Bitte wählen Sie ein Template aus!<br />';
  }
  
  if (errorTextHpSeAllg != '') {
    showErrorWindowNow(errorTextHpSeAllg);
    return false;
  }
  else {
    return true;
  }
}



function buildHpSeMetaLangsDataJSON() {
  var curJson = {'meta_de': $('#vFrontHpSeAllMetaTitle').val()};
  
  var allOtherMetasLang = $('.vFrontAllHpSeAllMetasLangHolder').find('input');
  $.each(allOtherMetasLang, function() {
    var curLangUri = $(this).attr('id').replace('vFrontHpSeAllMetaTitle', '');
    curJson['meta_'+curLangUri] = $(this).val();
  });
  
  return curJson;
}


function showFiltersSettings(){
    
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'filterSettingWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  }); 
    
}

function showOrdersSettings(){
    
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'orderSettingWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  }); 
    
}

function saveOrderSetting(){
  
    
  $('body').on('click','.saveSetting',function(){
      
       var days = $('input[name=days]').val();
   
        if(days == ''){
            showErrorWindowNow('Empty value');
        }else{
    
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art:  'saveOrderSetting', VCMS_POST_LANG: $('body').attr('data-lang'),'days':days},
        success: function(data) {
          hideCmsIsLoading();
          
          console.log(data);
           if (data == 'OK') {
            showOkWindowNow('Saved');
          }
          else {
            showErrorWindowNow('error');
          }

        },
        error: function() {
          showAjaxFehler();
        }
      
  });  
  
  
  
  
  
  
   }
       
   });
     


}

function showBasketSetting(){
    
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'basketSettingWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSeitenlayoutsNow();
      hideCmsIsLoading();
      showAddTabForm();
      deleteTab();
     
    },
    error: function() {
      showAjaxFehler();
    }
  }); 
    
}


function showAddTabForm(){
   $('#vFrontNewTab').click(function() {  
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'addBasketTab', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSeitenlayoutsNow();
      hideCmsIsLoading();
      saveNewTab();
    },
    error: function() {
      showAjaxFehler();
    }
  });
     // saveOrderSetting();
  
  });
  
    
}

function saveNewTab(){
    
    $('#vFrontSaveNewTab').click(function(){
        
        var name = $('#nameTab').val();
        var type = $('input[name=typeTab]:checked').val();
        
        if(name == ''){
            
            $('#nameTab').css({'border':'1px solid red'})
        }else{
            
           $.ajax({
                type: "POST",
                url: "admin/frontAdmin/ajax_php/ajax.php",
                data: {_art: 'addNewTab', VCMS_POST_LANG: $('body').attr('data-lang'),nameTab:name,typeTab:type},
                success: function(data) {
                 
                 
                 if (data == 'ok') {
                        showOkWindowNow('Saved');
                      showBasketSetting();
                    }else {
                      showErrorWindowNow('error');
                    } 
                 
                },
                error: function() {
                  showAjaxFehler();
                }
        }) 
        }
        
        
    
    })
}

function deleteTab(){
    
   $('body').on('click', '#vFrontDelTab',function(){
        console.log('asdasdasd')
       var checkerDel = confirm('Möchten Sie Basket löschen?');
    if (checkerDel == true) {
        
        var id = $(this).data('id');
        $.ajax({
                type: "POST",
                url: "admin/frontAdmin/ajax_php/ajax.php",
                data: {_art: 'deleteTab', VCMS_POST_LANG: $('body').attr('data-lang'),id:id},
                success: function(data) {
                    
                  if (data == 'ok') {
                        showOkWindowNow('Removed');
                         showBasketSetting();
                    }
                    else {
                      showErrorWindowNow('error');
                    }   
                    
                
                },
                error: function() {
                  showAjaxFehler();
                }
        }) 
    }   
        
    })
    
    
}


function saveFilterSetting(){
  
    
  $('body').on('click','.saveSettingFilter',function(){
      
      var filterData = $('.filterS').serialize();
       
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art:  'saveFilterSetting', VCMS_POST_LANG: $('body').attr('data-lang'),'filter':filterData},
        success: function(data) {
          hideCmsIsLoading();
          
          console.log(data);
           if (data == 'OK') {
            showOkWindowNow('Saved');
          }
          else {
            showErrorWindowNow('error');
          }

        },
        error: function() {
          showAjaxFehler();
        }
      
  });  
  
   });
}

function showTimeSetting(){
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'timeSettingWin', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSeitenlayoutsNow();
      hideCmsIsLoading();
      showAddTimeHashForm();
      deleteHash();
    },
    error: function() {
      showAjaxFehler();
    }
  });  
}


function showAddTimeHashForm(){
   $('#vFrontNewHash, .vFrontEditHash').click(function() {  
       
  var id =  $(this).data('id');  
   $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'addHashForm', VCMS_POST_LANG: $('body').attr('data-lang'),'id':id},
    success: function(data) {
     $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSeitenlayoutsNow();
      hideCmsIsLoading();
      saveNewHash();
      hashTitleForm();
    },
    error: function() {
      showAjaxFehler();
    }
  });
     // saveOrderSetting();
  
  });
 
}


function saveNewHash(){
    
    $('#vFrontSaveNewHash').click(function(){
        
        var name = $('#nameHash').val();
        var id   = $('#idHash').val();
        
        if(name == ''){
            $('#nameHash').css({'border':'1px solid red'})
        }else{
           $.ajax({
                type: "POST",
                url: "admin/frontAdmin/ajax_php/ajax.php",
                data: {_art: 'addNewHash', VCMS_POST_LANG: $('body').attr('data-lang'),nameHash:name,id:id},
                success: function(data) {
                 if (data == 'ok') {
                      showOkWindowNow('Saved');
                      showTimeSetting();
                    }else {
                      showErrorWindowNow('error');
                    } 
                },
                error: function() {
                  showAjaxFehler();
                }
            }) 
        }
    })
}


function deleteHash(){
    
   $('body').on('click', '.vFrontDelHash',function(){
     
       var checkerDel = confirm('Möchten Sie Basket löschen?');
    if (checkerDel == true) {
        
        var id = $(this).data('id');
        $.ajax({
                type: "POST",
                url: "admin/frontAdmin/ajax_php/ajax.php",
                data: {_art: 'deleteHash', VCMS_POST_LANG: $('body').attr('data-lang'),id:id},
                success: function(data) {
                    
                  if (data == 'ok') {
                        showOkWindowNow('Removed');
                        showTimeSetting();
                    }
                    else {
                      showErrorWindowNow('error');
                    }   
                    
                
                },
                error: function() {
                  showAjaxFehler();
                }
        }) 
    }   
        
    })
    
    
}


function hashTitleForm(){
    
    $('#vFrontAddTitle').click(function(){
        
        var abstandLeft = ($(window).width() / 2) - (600 / 2);
        $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');

        $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
        $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
        $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Hash title and dates');
        $('#vFrontOverlayFive').show();
        $('#vFrontCenterWindowAllgemeinCMSWindow').show();
        
        var idHash = $('#idHash').val();

        $.ajax({
          type: "POST",
          url: "admin/frontAdmin/ajax_php/ajax.php",
          data: {_art: 'showHashTitleForm', VCMS_POST_LANG: $('body').attr('data-lang'),idHash:idHash},
          success: function(data) {
            $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
            initFilterSystemAdminWindow();
            saveTitlehash();
            editCategory();
                deleteTime();
             $('.dateTime').datetimepicker();
             $('.time').timepicker();
             $('.dateTimeC').hide();
             $('.chooseOption').click(function(){
                 if($(this).val() == 1){
                     $('.dateTimeC').hide();
                     $('.timeC').show();
                 }else{
                     $('.dateTimeC').show();
                     $('.timeC').hide();
                 }
             });
              
            
          },
          error: function() {
            showAjaxFehler();
          }
        });
        
        
        
    })
    
    
}

function saveTitlehash(){
    $('#vFrontSaveTitleHash').click(function(e){
        e.preventDefault();
        var error;
        error=0;
        $.each($('.timeTexts'),function(i,v){
            
            if($(v).val() == ''){
                $(v).css('border','1px solid red');
                error++;
              
            }
        });
        
    
        
        if(error == 0){
            
            showCmsIsLoading();
            var dateForm = $('#titleForm').serializeArray();
            $.ajax({
              type: "POST",
              url: "admin/frontAdmin/ajax_php/ajax.php",
              data: {_art: 'saveTitleForm', VCMS_POST_LANG: $('body').attr('data-lang'),dateForm:dateForm},
              success: function(data) {
               if($('input[name=idTime]').val() != ''){
                   var idTime = $('input[name=idTime]').val();
                   var title   = $('input[name=titleHash_de]').val();
                   $('#titlehash'+idTime).text(title);
                   showOkWindowNow('Saved');
               }else{
                   $('.timeTexts').val(''); 
               }

               $('.vFrontHpSeAuflistung').prepend(data);
                hideCmsIsLoading();
                showOkWindowNow('Saved');

              },
              error: function() {
                showAjaxFehler();
              }
            });
        }
        
        
    }) 
}


function deleteTime(){
    $('body').on('click', '.deleteTimeText',function(){
    
        console.log('sdfsdfsdf');
    })
}


 
function editCategory(){
     $('body').on('click', '.changeTimeText',function(){
  
       var id = $(this).data('id');
        
       $.ajax({
          type: "POST",
          url: "admin/frontAdmin/ajax_php/ajax.php", 
          data: {_art: 'editTitleForm', VCMS_POST_LANG: $('body').attr('data-lang'),id:id},
          success: function(data) {
              
              
          var obj = $.parseJSON(data);
          $.each( obj.titles,function(i,v){
            $('input[name='+i+']').val(v);
          })
          
          $('#time').val(obj.time);
          $('#time1').val(obj.time1);
          $('#dateTime').val(obj.dateFrom);
          $('#dateTime1').val(obj.dateTo);
          $('#idTime').val(obj.idTime);
          
          },
          error: function() {
            showAjaxFehler();
          }
        });   
    })
   
 }








// *****************************************************************************
// ENDE - Funktionen für Einstellungen Allgemein
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Elemente
// *****************************************************************************

function showHpSeElemente(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeElementsNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeElementsNow() {
  $('.vFrontHpSeAuflistungLiElChange').click(function() {
    showHpSeElementsChangeElementWindow($(this).attr('data-id'));
  });
  $('.vFrontHpSeAuflistungLiElDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Element wirklich löschen?');
    if (checkerDel == true) {
      delHpSeThisElement($(this));
    }
  });
  $('.vFrontHpSeAuflistungLiElChangeSettings').click(function() {
    showHpSeElementsOwnSettingChangeElementWindow($(this).attr('data-id'));
  });
  
  $('.vFrontHpSeAuflistungLiElInstall').click(function() {
    var checkerInstall = confirm('Möchten Sie das Element wirklich installieren?');
    if (checkerInstall == true) {
      installCentralElementNow($(this));
    }
  });
  
  $('#vFrontNeuesElementBtn').click(function() {
    showHpSeElementsNewElementWindow();
  });
  
  $('#vFrontOwnElementeSortierenBtn').click(function() {
    if ($(this).hasClass('vFrontOwnElementeSortierenBtnIsActive')) {
      $(this).removeClass('vFrontOwnElementeSortierenBtnIsActive');
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElChange').show();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElDel').show();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElChangeSettings').show();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiEl').removeClass('vFrontOwnElementeSortierenBtnIsActiveMovePointer');
      $('.vFrontOwnElementeHolderToSortMM').sortable('destroy');
    }
    else {
      $(this).addClass('vFrontOwnElementeSortierenBtnIsActive');
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElChange').hide();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElDel').hide();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiElChangeSettings').hide();
      $('.vFrontOwnElementeHolderToSortMM').find('.vFrontHpSeAuflistungLiEl').addClass('vFrontOwnElementeSortierenBtnIsActiveMovePointer');
      $('.vFrontOwnElementeHolderToSortMM').sortable({
        cancel: ".vFrontHpSeAuflistungLiElChange, .vFrontHpSeAuflistungLiElDel",
        items: "> .vFrontHpSeAuflistungLiEl",
        placeholder: "ui-state-highlight",
        stop: function(event, ui) {
          setSortOwnElementsNewNowMM();
        }
      });
    }
  });
}



function setSortOwnElementsNewNowMM() {
  showCmsIsLoading();
  
  var allOwnElemsList = '';
  var allOwnElemsListCount = 0;
  var allOwnElems = $('.vFrontOwnElementeHolderToSortMM').find('> .vFrontHpSeAuflistungLiEl');
  $.each(allOwnElems, function() {
    allOwnElemsListCount++;
    if (allOwnElemsListCount == 1) {
      allOwnElemsList += $(this).attr('data-id');
    }
    else {
      allOwnElemsList += ';'+$(this).attr('data-id');
    }
  });
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'setSortOwnElementsNewNowMM', VCMS_POST_LANG: $('body').attr('data-lang'), _allOwnElemsList: allOwnElemsList},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function installCentralElementNow(curElemInstallBtn) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveHpSeElementsNewElementCentral', VCMS_POST_LANG: $('body').attr('data-lang'), _elemName: curElemInstallBtn.attr('data-name'), _elemFile: 'element.inc.php', _elemHidden: 2, _elemCentralFolder: curElemInstallBtn.attr('data-folder')},
    success: function(data) {
      showOkWindowNow('Das Element wurde erfolgreich installiert');
      showHpSeElemente('vFrontHpSeElemente');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delHpSeThisElement(curElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeThisCurentElement', VCMS_POST_LANG: $('body').attr('data-lang'), _curDelElemId: curElem.attr('data-id')},
    success: function(data) {
      if (data == true) {
        var curElemParent = curElem.parent();
        curElemParent.fadeOut(300, function() {
          curElemParent.remove();
        });
      }
      else {
        showErrorWindowNow('Das Element kann nicht gelöscht werden.<br />Es wird auf Seiten verwendet.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showHpSeElementsNewElementWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Neues Element erstellen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeNewElementForms', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeElementsNewElementWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeElementsNewElementWindow() {
  $('#vFrontSaveNewElementForms').click(function() {
    if (frmHpSeElementDataCheck(false)) {
      showCmsIsLoading();
      
      var elIsHidden = 2;
      if ($('#vElementsFrmOffline').is(':checked')) {
        elIsHidden = 1;
      }
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeElementsNewElement', VCMS_POST_LANG: $('body').attr('data-lang'), _elemName: $('#vElementsFrmName').val(), _elemFile: $('#vElementsFrmFile').val(), _elemHidden: elIsHidden},
        success: function(data) {
          closeCenterWindowSmallSettingsHpSe();
          showOkWindowNow('Das Element wurde erfolgreich erstellt');
          showHpSeElemente('vFrontHpSeElemente');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
}



function showHpSeElementsChangeElementWindow(curSelemId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Element bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeChangeElementForms', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemId: curSelemId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeElementsChangeElementWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeElementsChangeElementWindow() {
  $('#vFrontSaveChangeElementForms').click(function() {
    if (frmHpSeElementDataCheck(true)) {
      showCmsIsLoading();
      
      var elIsHidden = 2;
      if ($('#vElementsFrmOffline').is(':checked')) {
        elIsHidden = 1;
      }
      
      var sendData = {_art: 'saveHpSeElementsChangeElementSys', VCMS_POST_LANG: $('body').attr('data-lang'), _elemId: $(this).attr('data-id'), _elemHidden: elIsHidden};
      
      if ($(this).attr('data-art') == 'own') {
        sendData = {_art: 'saveHpSeElementsChangeElementOwn', _elemId: $(this).attr('data-id'), _elemName: $('#vElementsFrmName').val(), _elemFile: $('#vElementsFrmFile').val(), _elemHidden: elIsHidden};
      }
      
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: sendData,
        success: function(data) {
          closeCenterWindowSmallSettingsHpSe();
          showOkWindowNow('Das Element wurde erfolgreich gespeichert');
          showHpSeElemente('vFrontHpSeElemente');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
}



function frmHpSeElementDataCheck(isBear) {
  var errorText = '';
  
  if ($('#vElementsFrmName').val() == '') {
    errorText += 'Bitte geben Sie einen Element Name ein!<br />';
  }
  if ($('#vElementsFrmFile').length > 0) {
    if ($('#vElementsFrmFile').val() == '') {
      errorText += 'Bitte geben Sie den Datei Name ein!<br />';
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



function showHpSeElementsOwnSettingChangeElementWindow(curElemId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Element Einstellungen - Code');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeElementsOwnSettingChangeElementWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curElemId: curElemId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeElementsOwnSettingChangeElementWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeElementsOwnSettingChangeElementWindow() {
  $('#vFrontSaveOwnElemSettingString').click(function() {
    saveHpSeElementsOwnSettingChangeElementString($(this).attr('data-id'));
  });
}



function saveHpSeElementsOwnSettingChangeElementString(elemID) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveHpSeElementsOwnSettingChangeElementString', VCMS_POST_LANG: $('body').attr('data-lang'), _curElemId: elemID, _curElemString: $('#vFrontOwnElemSettingStringTextarea').val()},
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmallSettingsHpSe();
        showOkWindowNow('Der Element Einstellungen Code wurde erfolgreich gespeichert');
      }
      else {
        showErrorWindowNow('<b>Error:</b>&nbsp;&nbsp;'+data);
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Elemente
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Seitenlayouts
// *****************************************************************************

function showHpSeSeitenlayouts(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSeitenlayoutsNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeSeitenlayoutsNow() {
  $('#vFrontNeuesSeitenlayoutBtn').click(function() {
    showHpSeNewSeitenlayoutsFormsWindow();
  });
  
  $('.vFrontHpSeAuflistungLiLayChange').click(function() {
    showHpSeBearSeitenlayoutsFormsWindow($(this).attr('data-id'));
  });
  
  $('.vFrontHpSeAuflistungLiLayDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Seitenlayout wirklich löschen?');
    if (checkerDel == true) {
      delHpSeThisSeitenlayout($(this));
    }
  });
}



function showHpSeNewSeitenlayoutsFormsWindow() {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeNewSeitenlayoutsFormsWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeNewSeitenlayoutsFormsWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeNewSeitenlayoutsFormsWindow() {
  $('#vFrontSaveHpSeNewSeitenlayout').click(function(){
    if (frmHpSeSeitenlayoutsDataCheck(false)) {
      showCmsIsLoading();
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeNewSeitenlayout', VCMS_POST_LANG: $('body').attr('data-lang'), _layName: $('#vFrontHpSeSiteLayoutName').val(), _layFile: $('#vFrontHpSeSiteLayoutDatei').val()},
        success: function(data) {
          showOkWindowNow('Das Seitenlayout wurde erfolgreich erstellt');
          showHpSeSeitenlayouts('vFrontHpSeLayouts');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
  
  $('#vFrontCancelHpSeNewSeitenlayout').click(function(){
    showHpSeSeitenlayouts('vFrontHpSeLayouts');
  });
}



function frmHpSeSeitenlayoutsDataCheck(isBear) {
  var errorText = '';
  
  if ($('#vFrontHpSeSiteLayoutName').val() == '') {
    errorText += 'Bitte geben Sie einen Name ein!<br />';
  }
  if ($('#vFrontHpSeSiteLayoutDatei').val() == '') {
    errorText += 'Bitte geben Sie eine Datei ein!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function delHpSeThisSeitenlayout(curLayBtnObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeThisSeitenlayout', VCMS_POST_LANG: $('body').attr('data-lang'), _layID: curLayBtnObj.attr('data-id')},
    success: function(data) {
      if (data == true) {
        var curLayBtnObjParent = curLayBtnObj.parent();
        curLayBtnObjParent.fadeOut(300, function() {
          curLayBtnObjParent.remove();
        });
      }
      else {
        showErrorWindowNow('Das Seitenlayot kann nicht gelöscht werden.<br />Es wird auf Seiten verwendet.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showHpSeBearSeitenlayoutsFormsWindow(curDataId) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeBearSeitenlayoutsFormsWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _layID: curDataId},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeBearSeitenlayoutsFormsWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeBearSeitenlayoutsFormsWindow() {
  $('#vFrontSaveHpSeBearSeitenlayout').click(function() {
    if (frmHpSeSeitenlayoutsDataCheck(true)) {
      showCmsIsLoading();
      var layIDCur = $(this).attr('data-id');
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeBearSeitenlayout', VCMS_POST_LANG: $('body').attr('data-lang'), _layName: $('#vFrontHpSeSiteLayoutName').val(), _layFile: $('#vFrontHpSeSiteLayoutDatei').val(), _layID: layIDCur},
        success: function(data) {
          showOkWindowNow('Das Seitenlayout wurde erfolgreich gespeichert');
          showHpSeSeitenlayouts('vFrontHpSeLayouts');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
  
  $('#vFrontCancelHpSeBearSeitenlayout').click(function() {
    showHpSeSeitenlayouts('vFrontHpSeLayouts');
  });
  
  $('.vFrontFrmHolderHpSeRowFieldsNewBtn').click(function() {
    showHpSeSeitenlayoutsNewFeldWindow($(this).attr('data-id'));
  });
  
  initHpSeSeitenlayoutsFieldButtons();
}



// Funktionen für Seitenlayout Felder
// **********************************************************
function initHpSeSeitenlayoutsFieldButtons() {
  $('.vFrontFrmHolderHpSeRowFieldsListInElemChangeBtn').click(function() {
    changeHpSeSeitenlayoutsFieldNow($(this).attr('data-id'), $(this).attr('data-layid'));
  });
  
  $('.vFrontFrmHolderHpSeRowFieldsListInElemDelBtn').click(function() {
    var checkerDel = confirm('Möchten Sie das Feld wirklich löschen?');
    if (checkerDel == true) {
      delHpSeSeitenlayoutsFieldNow($(this).attr('data-id'), $(this).attr('data-layid'), $(this).parent().parent());
    }
  });
  
  $('.vFrontFrmHolderHpSeRowFieldsListIn').sortable({
    cancel: ".vFrontFrmHolderHpSeRowFieldsListInElemBtnHolder",
    placeholder: "ui-state-highlight",
    stop: function(event, ui) { setSortSeitenlayoutsFieldsNew($('.vFrontFrmHolderHpSeRowFieldsListIn').attr('data-id')); }
  });
}



function changeHpSeSeitenlayoutsFieldNow(curFieldID, curLayId) {
  showHpSeSeitenlayoutsBearFeldWindow(curFieldID, curLayId);
}



function showHpSeSeitenlayoutsBearFeldWindow(curFieldID, curLayId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Feld bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeSeitenlayoutsBearFeldWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curFieldID: curFieldID, _curLayId: curLayId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeSeitenlayoutsBearFeldWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeSeitenlayoutsBearFeldWindow() {
  $('#vSeitLayFeldFrmBearSaveBtn').click(function() {
    if (checkHpSeSeitenlayoutsNewFeldWindowNow($(this).attr('data-art'))) {
      saveHpSeSeitenlayoutsBearFeldWindowNow($(this).attr('data-id'), $(this).attr('data-art'), $(this).attr('data-layid'));
    }
  });
}



function delHpSeSeitenlayoutsFieldNow(curFieldID, curLayId, curListElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeSeitenlayoutsFieldNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: curLayId, _curFieldID: curFieldID},
    success: function(data) {
      if (data == true) {
        curListElem.fadeOut(500, function() {
          curListElem.remove();
        });
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function setSortSeitenlayoutsFieldsNew(layID) {
  showCmsIsLoading();
  
  var allElemsList = '';
  var allElemsListCount = 0;
  var allElems = $('.vFrontFrmHolderHpSeRowFieldsListIn').find('> .vFrontFrmHolderHpSeRowFieldsListInElem');
  $.each(allElems, function() {
    allElemsListCount++;
    if (allElemsListCount == 1) {
      allElemsList += $(this).attr('data-id');
    }
    else {
      allElemsList += ';'+$(this).attr('data-id');
    }
  });
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'setSortSeitenlayoutsFieldsNew', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: layID, _allElemsList: allElemsList},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




function showHpSeSeitenlayoutsNewFeldWindow(curLayId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Neues Feld erstellen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeSeitenlayoutsNewFeldWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: curLayId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeSeitenlayoutsNewFeldWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeSeitenlayoutsNewFeldWindow() {
  $('.vFrontHpSeSeitenlayoutFelderArtAuswahlBtn').click(function() {
    $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
    $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
    
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'showHpSeSeitenlayoutsNewFeldWindowCurForms', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: $(this).attr('data-layid'), _curFeldArt: $(this).attr('data-art')},
      success: function(data) {
        $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
        initHpSeSeitenlayoutsNewFeldWindowCurForms();
      },
      error: function() {
        showAjaxFehler();
      }
    });
  });
}



function initHpSeSeitenlayoutsNewFeldWindowCurForms() {
  $('#vSeitLayFeldFrmSaveBtn').click(function() {
    if (checkHpSeSeitenlayoutsNewFeldWindowNow($(this).attr('data-art'))) {
      saveHpSeSeitenlayoutsNewFeldWindowNow($(this).attr('data-layid'), $(this).attr('data-art'));
    }
  });
}



function checkHpSeSeitenlayoutsNewFeldWindowNow(feldArtId) {
  var errorText = '';
  
  if ($('#vSeitLayFeldFrmDataName').val() == '') {
    errorText += 'Bitte geben Sie einen Daten Name ein!<br />';
  }
  if ($('#vSeitLayFeldFrmLabel').val() == '') {
    errorText += 'Bitte geben Sie einen Label Name ein!<br />';
  }
  if (feldArtId == 6) {
    if ($('#vSeitLayFeldFrmConfig').val() == '') {
      errorText += 'Bitte geben Sie die Drop Down Options ein!<br />';
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



function saveHpSeSeitenlayoutsNewFeldWindowNow(layId, feldArtId) {
  var sendData = {_art: 'saveHpSeSeitenlayoutsNewFeldWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: layId, _curFeldArt: feldArtId, _dataName: $('#vSeitLayFeldFrmDataName').val(), _labelName: $('#vSeitLayFeldFrmLabel').val()};
  
  if (feldArtId == 6) {
    sendData['_feldOptions'] = $('#vSeitLayFeldFrmConfig').val();
  }
  
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: sendData,
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmallSettingsHpSe();
        buildHpSeSeitenlayoutsFeldListNew(layId);
        showOkWindowNow('Das Feld wurde erfolgreich erstellt');
      }
      else if (data == 'dataname') {
        showErrorWindowNow('Der Datenname wird schon benutzt!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function saveHpSeSeitenlayoutsBearFeldWindowNow(feldId, feldArtId, layId) {
  var sendData = {_art: 'saveHpSeSeitenlayoutsBearFeldWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curFeldId: feldId, _curLayId: layId, _curFeldArt: feldArtId, _dataName: $('#vSeitLayFeldFrmDataName').val(), _labelName: $('#vSeitLayFeldFrmLabel').val(), _dataNameOld: $('#vSeitLayFeldFrmDataNameOldBear').val() };
  
  if (feldArtId == 6) {
    sendData['_feldOptions'] = $('#vSeitLayFeldFrmConfig').val();
  }
  
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: sendData,
    success: function(data) {
      if (data == true) {
        closeCenterWindowSmallSettingsHpSe();
        buildHpSeSeitenlayoutsFeldListNew(layId);
        showOkWindowNow('Das Feld wurde erfolgreich bearbeitet');
      }
      else if (data == 'dataname') {
        showErrorWindowNow('Der Datenname wird schon benutzt!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function buildHpSeSeitenlayoutsFeldListNew(layId) {
  $('.vFrontFrmHolderHpSeRowFieldsListIn').html('');
  $('.vFrontFrmHolderHpSeRowFieldsListIn').html('<div class="vFrontWinLoaderBlack" style="margin:50px 0px 50px 0px;"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'buildHpSeSeitenlayoutsFeldListNew', VCMS_POST_LANG: $('body').attr('data-lang'), _curLayId: layId},
    success: function(data) {
      $('.vFrontFrmHolderHpSeRowFieldsListIn').html(data);
      initHpSeSeitenlayoutsFieldButtons();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// **********************************************************

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Seitenlayouts
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Navigationsarten
// *****************************************************************************

function showHpSeNaviArts(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeNaviArtsNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeNaviArtsNow() {
  $('#vFrontNeueNaviArtInCmsBtn').click(function() {
    showHpSeNewNaviArtFormsWindow();
  });
  
  $('.vFrontHpSeAuflistungLiNaviArtDel').click(function() {
    var checkerDel = confirm('Möchten Sie die Navigationsart wirklich löschen?');
    if (checkerDel == true) {
      delHpSeThisNaviArt($(this));
    }
  });
  
  $('.vFrontHpSeAuflistungLiNaviArtChange').click(function() {
    showHpSeBearNaviArtFormsWindow($(this).attr('data-id'));
  });
}



function showHpSeNewNaviArtFormsWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Neue Navigationsart erstellen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeNewNaviArtFormsWindow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeNewNaviArtFormsWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeNewNaviArtFormsWindow() {
  $('#vFrontSaveNewNaviArtForms').click(function() {
    if (frmHpSeNaviArtDataCheck(false)) {
      showCmsIsLoading();
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeNewNaviArt', VCMS_POST_LANG: $('body').attr('data-lang'), _nartName: $('#vNaviArtFrmName').val()},
        success: function(data) {
          closeCenterWindowSmallSettingsHpSe();
          showOkWindowNow('Die Navigationsart wurde erfolgreich erstellt');
          showHpSeNaviArts('vFrontHpSeNaviArt');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
}



function frmHpSeNaviArtDataCheck(isBear) {
  var errorText = '';
  
  if ($('#vNaviArtFrmName').val() == '') {
    errorText += 'Bitte geben Sie einen Name ein!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function delHpSeThisNaviArt(curNaviArtBtnObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeThisNaviArt', VCMS_POST_LANG: $('body').attr('data-lang'), _nartID: curNaviArtBtnObj.attr('data-id')},
    success: function(data) {
      if (data == true) {
        var curNaviArtBtnObjParent = curNaviArtBtnObj.parent();
        curNaviArtBtnObjParent.fadeOut(300, function() {
          curNaviArtBtnObjParent.remove();
        });
      }
      else {
        showErrorWindowNow('Die Navigationsart kann nicht gelöscht werden.<br />Sie wird auf Seiten verwendet.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showHpSeBearNaviArtFormsWindow(curNartID) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Navigationsart bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeBearNaviArtFormsWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _nartID: curNartID},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeBearNaviArtFormsWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeBearNaviArtFormsWindow() {
  $('#vFrontSaveBearNaviArtForms').click(function() {
    if (frmHpSeNaviArtDataCheck(true)) {
      showCmsIsLoading();
      var nartIDCur = $(this).attr('data-id');
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeBearNaviArt', VCMS_POST_LANG: $('body').attr('data-lang'), _nartName: $('#vNaviArtFrmName').val(), _nartID: nartIDCur},
        success: function(data) {
          closeCenterWindowSmallSettingsHpSe();
          showOkWindowNow('Die Navigationsart wurde erfolgreich gespeichert');
          showHpSeNaviArts('vFrontHpSeNaviArt');
          hideCmsIsLoading();
        },
        error: function() {
          showAjaxFehler();
        }
      });
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Navigationsarten
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen User
// *****************************************************************************

function showHpSeUser(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeUserNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeUserNow() {
  $('#vFrontNeuerUserInCmsBtn').click(function() {
    showHpSeNewUserForms();
  });
  $('.vFrontHpSeAuflistungLiUserChange').click(function() {
    showHpSeBearUserForms($(this).attr('data-id'));
  });
  $('.vFrontHpSeAuflistungLiUserDel').click(function() {
    var checkerDel = confirm('Möchten Sie den User wirklich löschen?');
    if (checkerDel == true) {
      delHpSeThisUserNow($(this).attr('data-id'), $(this).parent());
    }
  });
}



function showHpSeNewUserForms() {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeNewUserForms', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeNewUserForms();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

function initHpSeNewUserForms() {
  $('#vFrontHpSeUserArt').msDropdown();
  
  $('#vFrontSaveHpSeNewUser').click(function(){
    if (checkNewUserDataNow()) {
      saveNewUserDataNow();
    }
  });
  
  $('#vFrontCancelHpSeNewUser').click(function(){
    showHpSeUser('vFrontHpSeUser');
  });
  
  $('#vFrontHpSeUserArt').change(function() {
    if ($(this).val() == 3) {
      $('#vFrontShowOnlyByIndividual').show();
    }
    else {
      $('#vFrontShowOnlyByIndividual').hide();
    }
  });
  
  // Individual User Listen (Seiten, Kategorien)
  // ***************************************************************************
  $('.vFrontFrmListHolderHeaderAdd').click(function() {
    showCurentIndividualUserListWindows($(this).parent().parent());
  });
  
  $('.vFrontFrmListHolderHeaderDel').click(function() {
    delCurentListsFromIndividualUser($(this).parent().parent());
  });
  
  $('.vFrontFrmListHolderLists').selectable({
    filter: ".vFrontListElemIUser"
    //cancel: "#vFrontListButtonSelectedNow"
  });
  // ***************************************************************************
}



function showHpSeBearUserForms(userID) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeBearUserForms', VCMS_POST_LANG: $('body').attr('data-lang'), _userID: userID},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeBearUserForms(userID);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

function initHpSeBearUserForms(userID) {
  if (userID != 1) {
    $('#vFrontHpSeUserArt').msDropdown();
  }
  
  $('#vFrontSaveHpSeChangeUser').click(function(){
    if (checkBearUserDataNow()) {
      saveBearUserDataNow($(this).attr('data-id'));
    }
  });
  
  $('#vFrontCancelHpSeChangeUser').click(function(){
    showHpSeUser('vFrontHpSeUser');
  });
  
  $('#vFrontHpSeUserArt').change(function() {
    if ($(this).val() == 3) {
      $('#vFrontShowOnlyByIndividual').show();
    }
    else {
      $('#vFrontShowOnlyByIndividual').hide();
    }
  });
  
  // Individual User Listen (Seiten, Kategorien)
  // ***************************************************************************
  $('.vFrontFrmListHolderHeaderAdd').click(function() {
    showCurentIndividualUserListWindows($(this).parent().parent());
  });
  
  $('.vFrontFrmListHolderHeaderDel').click(function() {
    delCurentListsFromIndividualUser($(this).parent().parent());
  });
  
  $('.vFrontFrmListHolderLists').selectable({
    filter: ".vFrontListElemIUser"
    //cancel: "#vFrontListButtonSelectedNow"
  });
  // ***************************************************************************
}



function checkNewUserDataNow() {
  var errorText = '';
  
  if ($('#vFrontHpSeUserArt').val() == '') {
    errorText += 'Bitte wählen Sie eine User Art aus!<br />';
  }
  if ($('#vFrontHpSeUserArt').val() == 3 && $('#vFrontHpSeUserRechtSeiten').val() == '') {
    errorText += 'Bei User Art "Individual User" muss mindestens 1 CMS Seite zugweisen werden!<br />';
  }
  if ($('#vFrontHpSeUserName').val() == '') {
    errorText += 'Bitte geben Sie einen User Name ein!<br />';
  }
  if ($('#vFrontHpSeUserPass').val() == '') {
    errorText += 'Bitte geben Sie ein User Passwort ein!<br />';
  }
  if ($('#vFrontHpSeUserPass').val() != '' && $('#vFrontHpSeUserPassSecond').val() == '') {
    errorText += 'Bitte wiederholen Sie das User Passwort!<br />';
  }
  if ($('#vFrontHpSeUserPass').val() != '' && $('#vFrontHpSeUserPassSecond').val() != '' && $('#vFrontHpSeUserPass').val() != $('#vFrontHpSeUserPassSecond').val()) {
    errorText += 'Das wiederholte Passwort ist nicht gleich dem Passwort!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function saveNewUserDataNow() {
  showCmsIsLoading();

  var userIsOffline = 1;
  if ($('#vFrontHpSeUserOffline').is(':checked')) {
    userIsOffline = 2;
  }

  var sendData = {_art: 'saveNewUserDataNow', VCMS_POST_LANG: $('body').attr('data-lang'), _userArt: $('#vFrontHpSeUserArt').val(), _userName: $('#vFrontHpSeUserName').val(), _userPass: $('#vFrontHpSeUserPass').val(), _userOffline: userIsOffline, _userSeitenRechte: $('#vFrontHpSeUserRechtSeiten').val(), _userKategorienRechte: $('#vFrontHpSeUserRechtBildKategorien').val()};

  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: sendData,
    success: function(data) {
      showHpSeUser('vFrontHpSeUser');
      showOkWindowNow('Der User wurde erfolgreich gespeichert');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function checkBearUserDataNow() {
  var errorText = '';
  
  if ($('#vFrontHpSeUserArt').val() == '') {
    errorText += 'Bitte wählen Sie eine User Art aus!<br />';
  }
  if ($('#vFrontHpSeUserArt').val() == 3 && $('#vFrontHpSeUserRechtSeiten').val() == '') {
    errorText += 'Bei User Art "Individual User" muss mindestens 1 CMS Seite zugweisen werden!<br />';
  }
  if ($('#vFrontHpSeUserName').val() == '') {
    errorText += 'Bitte geben Sie einen User Name ein!<br />';
  }
  if ($('#vFrontHpSeUserPass').val() != '' && $('#vFrontHpSeUserPassSecond').val() == '') {
    errorText += 'Bitte wiederholen Sie das User Passwort!<br />';
  }
  if ($('#vFrontHpSeUserPass').val() != '' && $('#vFrontHpSeUserPassSecond').val() != '' && $('#vFrontHpSeUserPass').val() != $('#vFrontHpSeUserPassSecond').val()) {
    errorText += 'Das wiederholte Passwort ist nicht gleich dem Passwort!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function saveBearUserDataNow(curUserId) {
  showCmsIsLoading();

  var userIsOffline = 1;
  if ($('#vFrontHpSeUserOffline').is(':checked')) {
    userIsOffline = 2;
  }

  var sendData = {_art: 'saveBearUserDataNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curUserID: curUserId, _userArt: $('#vFrontHpSeUserArt').val(), _userName: $('#vFrontHpSeUserName').val(), _userPass: $('#vFrontHpSeUserPass').val(), _userOffline: userIsOffline, _userSeitenRechte: $('#vFrontHpSeUserRechtSeiten').val(), _userKategorienRechte: $('#vFrontHpSeUserRechtBildKategorien').val()};

  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: sendData,
    success: function(data) {
      showHpSeUser('vFrontHpSeUser');
      showOkWindowNow('Der User wurde erfolgreich gespeichert');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delHpSeThisUserNow(curUserId, curUserElem) {
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeThisUserNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curUserID: curUserId},
    success: function(data) {
      hideCmsIsLoading();
      if (data == true) {
        curUserElem.fadeOut(300, function() {
          curUserElem.remove();
        });
        showOkWindowNow('Der User wurde erfolgreich gelöscht!');
      }
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



// Individual User Listen Funktionen
// *****************************************************************
function showCurentIndividualUserListWindows(curListElement) {
  var curAjaxArtSend = '';
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  if (curListElement.attr('data-field') == 'vFrontHpSeUserRechtSeiten') {
    $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Erlaubte CMS Seiten auswählen');
    curAjaxArtSend = 'showHpSeUserIndividualSiteList';
  }
  else if (curListElement.attr('data-field') == 'vFrontHpSeUserRechtBildKategorien') {
    $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Erlaubte Bilder Kategorien auswählen');
    curAjaxArtSend = 'showHpSeUserIndividualKategorieList';
  }
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: curAjaxArtSend, VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initCurentIndividualUserListWindows(curListElement);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showCurentIndividualUserListWindowsSeitenReloadMM(nartID, curListElement) {
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeUserIndividualSiteListReload', VCMS_POST_LANG: $('body').attr('data-lang'), _naviArtID: nartID},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initCurentIndividualUserListWindows(curListElement);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initCurentIndividualUserListWindows(curListElement) {
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').msDropDown();
  
  $('#vFrontSeitenAuflistungAuswahlNaviArtSelect').change(function() {
    showCurentIndividualUserListWindowsSeitenReloadMM($(this).val(), curListElement);
  });
  
  $('.vFrontSeitenAuflistungAuswahl').selectable({
    filter: ".vFrontIsSiteCur, .vFrontIsBlogCur",
    cancel: "#vFrontListButtonSelectedNow, .vFrontIsNaviCur"
  });
  
  $('#vFrontListButtonSelectedNow').click(function() {
    var allSelected = $('.vFrontSeitenAuflistungAuswahl .ui-selected');
    if (allSelected.length > 0) {
      var listInput = curListElement.find('.vFrontFrmListHolderLists');
      $.each(allSelected, function() {
        listInput.append('<div class="vFrontListElemIUser" data-id="'+$(this).attr('data-id')+'">'+$(this).attr('data-name')+'</div>');
      });
    }
    setNewIndividualUserListsInForm(curListElement);
    closeCenterWindowAllgemeinCMSWindow();
  });
}



function delCurentListsFromIndividualUser(curListElement) {
   var listElemsDel = curListElement.find('.vFrontFrmListHolderLists > .ui-selected');
   listElemsDel.remove();
   setNewIndividualUserListsInForm(curListElement);
}



function setNewIndividualUserListsInForm(curListElement) {
  var allLists = curListElement.find('.vFrontFrmListHolderLists > .vFrontListElemIUser');
  var formObj = $('#'+curListElement.attr('data-field'));
  var hansCount = 0;
  
  formObj.val('');
  
  $.each(allLists, function() {
    hansCount = hansCount + 1;
    if (hansCount == 1) {
      formObj.val($(this).attr('data-id'));
    }
    else {
      formObj.val(formObj.val()+';'+$(this).attr('data-id'));
    }
  });
}
// *****************************************************************

// *****************************************************************************
// ENDE - Funktionen für Einstellungen User
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Sprachen
// *****************************************************************************

function showHpSeSprachen(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSprachenNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeSprachenNow() {
  $('.vFrontHpSeAuflistungLiSprachChange').click(function() {
    showHpSeChangeLanguageWindow($(this).attr('data-id'));
  });
  $('.vFrontHpSeAuflistungLiSprachDel').click(function() {
    var checkerDel = confirm('Möchten Sie die Sprache wirklich löschen?');
    if (checkerDel == true) {
      delHpSeThisSprachen($(this));
    }
  });
  
  $('#vFrontNeueSpracheBtn').click(function() {
    showHpSeNewLanguageWindow();
  });
}



function delHpSeThisSprachen(delElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delHpSeThisLanguage', VCMS_POST_LANG: $('body').attr('data-lang'), _langID: delElem.attr('data-id')},
    success: function(data) {
      if (data == true) {
        var delElemParent = delElem.parent();
        delElemParent.fadeOut(300, function() {
          delElemParent.remove();
        });
      }
      else {
        showErrorWindowNow('Das Sprache kann nicht gelöscht werden.<br />Sie wird auf Seiten verwendet.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showHpSeNewLanguageWindow() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Neue Sprache erstellen');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeNewLanguageForms', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeNewLanguageWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeNewLanguageWindow() {
  $('#vFrontSaveNewSpracheForms').click(function() {
    if (checkHpSeNewLanguageWindowData()) {
      showCmsIsLoading();
      var langIsOnline = 1;
      if ($('#vSpracheFrmOffline').is(':checked')) {
        langIsOnline = 2;
      } 
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeNewLanguageNow', VCMS_POST_LANG: $('body').attr('data-lang'), _langName: $('#vSpracheFrmName').val(), _langUrlName: $('#vSpracheFrmKurzName').val(), _langOnline: langIsOnline},
        success: function(data) {
          if (data == 'ok') {
            closeCenterWindowSmallSettingsHpSe();
            showOkWindowNow('Die Sprache wurde erfolgreich gespeichert');
            showHpSeSprachen('vFrontHpSeSprachen');
          }
          else if (data == 'noUrl') {
            showErrorWindowNow('Der Url Name ist schon vorhanden');
          }
          else if (data == 'fehler') {
            showErrorWindowNow('Datenbank Fehler');
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



function checkHpSeNewLanguageWindowData() {
  var errorText = '';
  
  if ($('#vSpracheFrmName').val() == '') {
    errorText += 'Bitte geben Sie einen Name ein!<br />';
  }
  if ($('#vSpracheFrmKurzName').val() == '') {
    errorText += 'Bitte geben Sie einen Url Name ein!<br />';
  }
  else if ($('#vSpracheFrmKurzName').val() != '' && $('#vSpracheFrmKurzName').val().length != 2) {
    errorText += 'Der Url Name muss zwei Zeichen haben!<br />';
  }
  
  if (errorText != '') {
    showErrorWindowNow(errorText);
    return false;
  }
  else {
    return true;
  }
}



function showHpSeChangeLanguageWindow(curLangId) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettingsHpSe').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('');
  $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhaltHpSe').html('Sprache bearbeiten');
  $('#vFrontOverlaySecond').show();
  $('#vFrontCenterWindowSmallSettingsHpSe').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showHpSeChangeLanguageForms', VCMS_POST_LANG: $('body').attr('data-lang'), _curLangId: curLangId},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhaltHpSe').html(data);
      initHpSeChangeLanguageWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeChangeLanguageWindow() {
  $('#vFrontSaveChangeSpracheForms').click(function() {
    if (checkHpSeNewLanguageWindowData()) {
      showCmsIsLoading();
      var langIsOnline = 1;
      if ($('#vSpracheFrmOffline').is(':checked')) {
        langIsOnline = 2;
      }
      $.ajax({
        type: "POST",
        url: "admin/frontAdmin/ajax_php/ajax.php",
        data: {_art: 'saveHpSeChangeLanguageNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curLangId: $(this).attr('data-id'), _langName: $('#vSpracheFrmName').val(), _langUrlName: $('#vSpracheFrmKurzName').val(), _langOnline: langIsOnline},
        success: function(data) {
          if (data == 'ok') {
            closeCenterWindowSmallSettingsHpSe();
            showOkWindowNow('Die Sprache wurde erfolgreich gespeichert');
            showHpSeSprachen('vFrontHpSeSprachen');
          }
          else if (data == 'noUrl') {
            showErrorWindowNow('Der Url Name ist schon vorhanden');
          }
          else if (data == 'fehler') {
            showErrorWindowNow('Datenbank Fehler');
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

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Sprachen
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Module
// *****************************************************************************

function showHpSeModuleVerwaltung(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeModuleVerwaltung();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeModuleVerwaltung() {
  $('.vFrontHpSeAuflistungLiModuleInstall').click(function() {
    var checkerModulInstall = confirm('Möchten Sie die CMS Erweiterung wirklich Installieren?\n\n*** '+$(this).attr('data-curname')+' ***\n\n');
    if (checkerModulInstall == true) {
      installCurentCmsModuleNow($(this).attr('data-name'));
    }
  });
  
  $('.vFrontHpSeAuflistungLiModuleDeInstall').click(function() {
    var checkerModulDeInstall = confirm('Möchten Sie die CMS Erweiterung wirklich Deinstallieren?\n\n*** '+$(this).attr('data-curname')+' ***\n\n');
    if (checkerModulDeInstall == true) {
      deInstallCurentCmsModuleNow($(this).attr('data-name'));
    }
  });
}



function installCurentCmsModuleNow(modulName) {
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'installCurentCmsModuleNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curModulName: modulName},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Die Erweiterung wurde erfolgreich Installiert');
        showHpSeModuleVerwaltung('vFrontHpSeModule');
        showInfoWindowModulePriceSysMM();
      }
      else {
        showErrorWindowNow('Fehler: Die Erweiterung konnte nicht Installiert werden!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function deInstallCurentCmsModuleNow(modulName) {
  showCmsIsLoading();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'deInstallCurentCmsModuleNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curModulName: modulName},
    success: function(data) {
      if (data == true) {
        showOkWindowNow('Die Erweiterung wurde erfolgreich Deinstalliert');
        showHpSeModuleVerwaltung('vFrontHpSeModule');
      }
      else {
        showErrorWindowNow('Fehler: Die Erweiterung konnte nicht Deinstalliert werden!');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showInfoWindowModulePriceSysMM() {
  var modulPriceHtml = '<div id="vFrontCmsSysModulePriceInfoOverlay"></div>';
  modulPriceHtml += '<div id="vFrontCmsSysModulePriceInfoWindow">';
  modulPriceHtml += '<div id="vFrontCmsSysModulePriceInfoWindowText">Durch die Installation dieser CMS Erweiterung entstehen <b>Lizenzkosten</b>.</div>';
  modulPriceHtml += '<div id="vFrontCmsSysModulePriceInfoWindowOkBtn">Fenster schließen</div>';
  modulPriceHtml += '</div>';
  
  $('body').append(modulPriceHtml);
  
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCmsSysModulePriceInfoWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCmsSysModulePriceInfoWindowOkBtn').click(function() {
    $('#vFrontCmsSysModulePriceInfoOverlay').remove();
    $('#vFrontCmsSysModulePriceInfoWindow').remove();
  });
}

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Module
// *****************************************************************************








// *****************************************************************************
// ANFANG - Funktionen für Einstellungen Sitemap Generator
// *****************************************************************************

function showHpSeSitemapGenerator(curIdName) {
  showHpSePointLoader();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showCurHpSeInhaltNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curIdName: curIdName},
    success: function(data) {
      $('.vFrontHpSettingInhaltHolder').html(data);
      initHpSeSitemapGeneratorNow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initHpSeSitemapGeneratorNow() {
  $('#vFrontSitemapGeneratorSendBtn').click(function() {
    $('#vFrontSitemapGeneratorOkGenerate').hide();
    $('#vFrontSitemapGeneratorShowUri').hide();
    $('#vFrontSitemapGeneratorShowUri').html('');
    $('#vFrontSitemapGeneratorLoader').show();
    $('#vFrontAusgabeSitemapFile').hide();
    $('#vFrontAusgabeSitemapFile').val('');
    
    window.setTimeout('generateHpSeSitemapNow()', 1500);
  });
}



function generateHpSeSitemapNow() {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax_sitemap.php",
    data: {_art: 'generateHpSeSitemapNow', VCMS_POST_LANG: $('body').attr('data-lang'), _httpPfad: $('#vFrontAusgabeSitemapCurPath').val()},
    success: function(data) {
      $('#vFrontSitemapGeneratorLoader').hide();
      $('#vFrontSitemapGeneratorOkGenerate').show();
      $('#vFrontAusgabeSitemapFile').val(data);
      $('#vFrontAusgabeSitemapFile').show();
      $('#vFrontSitemapGeneratorShowUri').html('<a href="'+$('#vFrontAusgabeSitemapCurPath').val()+'sitemap.xml" target="_blank">'+$('#vFrontAusgabeSitemapCurPath').val()+'sitemap.xml</a>');
      $('#vFrontSitemapGeneratorShowUri').show();
    },
    error: function() {
      $('#vFrontSitemapGeneratorLoader').hide();
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Einstellungen Sitemap Generator
// *****************************************************************************