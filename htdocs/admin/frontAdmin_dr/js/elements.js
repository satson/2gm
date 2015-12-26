/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



function initElementsMenu() {
  if ($('body').attr('data-lang') == '' && vCMScurUserRechtSession != 3) {
    $(".vFrontDroppable").droppable({
      hoverClass: "ui-state-dragger-hover",
      activeClass: "ui-state-dragger",
      accept: ".vFrontDragElem",
      drop: function(event, ui) {
        showCmsIsLoading();
        var sitePosElem = $(this).parent();
        var elemID = ui.draggable.attr('id').replace('vCMSElem-', '');
        setNewDragElemUser(sitePosElem, sitePosElem.attr('data-name'), sitePosElem.attr('data-id'), elemID, $(this).attr('data-count'));
      }
    });
  }
  
  // Textfeld
  // ***************************************************************************
  $('.vSiteElemBoxBearLeisteChange').click(function() {
    var curElemBeID = $(this).attr('id').replace('elemBeID-', '');
    var setTextElemPar = $(this).parent().parent();
    var setTextElem = setTextElemPar.find('> .vSiteElemBoxInhalt');
    startBearModusElemText(setTextElem, curElemBeID, setTextElemPar);
  });
  $('.vSiteElemBoxBearLeisteSave').click(function() {
    var curElemSaveID = $(this).attr('id').replace('elemSaveID-', '');
    var textElemParent = $(this).parent().parent();
    saveElemTextNow(curElemSaveID, textElemParent);
  });
  $('.vSiteElemBoxBearLeisteCancel').click(function() {
    var stopTextElemPar = $(this).parent().parent();
    var stopTextElem = stopTextElemPar.find('> .vSiteElemBoxInhalt');
    stopBearModusElemText(stopTextElem, stopTextElemPar);
  });
  //***************************************************************************
  
  $('.vSiteElemBoxBearLeisteDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Element wirklich löschen?');
    if (checkerDel == true) {
      showCmsIsLoading();
      var sitePosElemDel = $(this).parent().parent().parent();
      var curElemDelID = $(this).attr('id').replace('elemDelID-', '');
      delThisSiteElemNow(curElemDelID, sitePosElemDel);
    }
  });
  
  $('.vSiteElemBoxBearLeisteElemCopy').click(function() {
    saveTheCurentCopyElementNow($(this).attr('data-id'));
  });
  
  // Bild
  // ***************************************************************************
  $('.vSiteElemBoxBearLeisteBildLink').click(function() {
    showCmsLinkWindow($(this), 'bild');
  });
  
  $('.vFrontSiteBildElementButtonNew').click(function() {
    showWindowImageAuswahlElemPic('vFrontElemPicVal-'+$(this).attr('data-id'), false, $(this).attr('data-id'));
  });
  $('.vSiteElemBoxBearLeisteBildChange').click(function() {
    var curElemBeID = $(this).attr('id').replace('elemBeID-', '');
    var setTextElemPar = $(this).parent().parent();
    var setTextElem = setTextElemPar.find('.vSiteElemBoxInhalt');
    var newPicButtonCur = setTextElemPar.find('.vFrontSiteBildElementButtonNew');
    var bildInElementCur = setTextElemPar.find('.vSiteBildElementHolder');
    newPicButtonCur.show();
    bildInElementCur.resizable({
      //containment:".innerrrr"
      //aspectRatio: true,
      maxWidth: setTextElem.width()
    });
    startBearModusElemBild(setTextElem, curElemBeID, setTextElemPar);
  });
  $('.vSiteElemBoxBearLeisteBildSave').click(function() {
    var curElemBildSaveID = $(this).attr('id').replace('elemSaveID-', '');
    var parOfElem = $(this).parent().parent();
    var resizeElem = parOfElem.find('.vSiteBildElementHolder');
    var stopTextElem = parOfElem.find('.vSiteElemBoxInhalt');
    saveBildElemResizeNow(curElemBildSaveID, resizeElem, stopTextElem, parOfElem);
  });
  $('.vSiteElemBoxBearLeisteBildCancel').click(function() {
    var stopTextElemPar = $(this).parent().parent();
    var stopTextElem = stopTextElemPar.find('.vSiteElemBoxInhalt');
    stopBearModusElemBild(stopTextElem, stopTextElemPar);
  });
  // ***************************************************************************
  
  // Spalten
  // ***************************************************************************
  if ($('body').attr('data-lang') == '' && vCMScurUserRechtSession != 3) {
    $('.vFrontSpaltenElementDroppable').droppable({
      hoverClass: "ui-state-dragger-hover",
      activeClass: "ui-state-dragger",
      accept: ".vFrontDragElem",
      drop: function(event, ui) {
        var sitePosElem = $(this).parent().parent().parent().parent();
        var selemCurID = $(this).parent().parent().parent().attr('data-elem');
        var selemRowID = $(this).parent().attr('data-row');
        var elemID = ui.draggable.attr('id').replace('vCMSElem-', '');
        if (elemID == 4) {
          alert('Dieses Element ist in einem Spaltenelement nicht erlaubt!');
        }
        else {
          setNewDragElemUserSpalten(sitePosElem, sitePosElem.attr('data-name'), sitePosElem.attr('data-id'), selemCurID, selemRowID, elemID, $(this).attr('data-count'));
        }
      }
    });
  }
  $('.vSiteElemBoxBearLeisteInSpalteDel').click(function() {
    var checkerDel = confirm('Möchten Sie das Element wirklich löschen?');
    if (checkerDel == true) {
      showCmsIsLoading();
      var sitePosElemDel = $(this).parent().parent().parent().parent().parent().parent();
      var curElemDelID = $(this).attr('id').replace('elemDelID-', '');
      delThisSiteElemNow(curElemDelID, sitePosElemDel);
    }
  });
  $('.vSiteElemBoxBearLeisteSetting').click(function() {
    var sitePosSeElem = $(this).parent().parent().parent();
    var curElemSettingID = $(this).attr('id').replace('elemSettingID-', '');
    showCurElemSpaltenSettingWindow(curElemSettingID, sitePosSeElem);
  });
  
  // Spalten Elemente Sortieren
  // ***************************************
  if ($('body').attr('data-lang') == '' && vCMScurUserRechtSession != 3) {
    $('.vSiteElemSpalteRow').sortable({
      items: "> .vCmsCanElemSortableImportant",
      placeholder: "ui-state-highlight",
      delay: 300,
      axis: 'y',
      tolerance: "pointer",
      start: function(event, ui) {
        var drops = $(this).find('.vFrontSpaltenElementDroppable');
        drops.hide();
      },
      stop: function(event, ui) {
        showCmsIsLoading();
        sortThisSpaltenElements($(this));
      }
    });
    $('.vSiteElemSpalteRow').sortable({disabled: true});

    $('.vSiteElemSpalteRow > .vSiteElemBox > .vSiteElemBoxBearLeiste')
      .mouseup(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: true});
      })
      .mousedown(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: false});
      });
  }
  // ***************************************
  // ***************************************************************************
  
  // Elemente Sortieren
  // ***************************************************************************
  if ($('body').attr('data-lang') == '' && vCMScurUserRechtSession != 3) {
    $('.vContentElemDD').sortable({
      items: "> .vCmsCanElemSortableImportant",
      //items: "> .vSiteElemBox",
      //cancel: "> .vCmsNoElemSortableImportant",
      placeholder: "ui-state-highlight",
      delay: 300,
      axis: 'y',
      tolerance: "pointer",
      start: function(event, ui) {
        var drops = $(this).find('.vFrontDroppable');
        drops.hide();
      },
      stop: function(event, ui) {
        showCmsIsLoading();
        sortThisElements($(this), false);
        loadNewElemPosInhaltOnly($(this));
        //setSortBaumNow(ui.item.parent().attr('id'));
      }
    });
    $('.vContentElemDD').sortable({disabled: true});

    $('.vContentElemDD > .vSiteElemBox > .vSiteElemBoxBearLeiste')
      .mouseup(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: true});
      })
      .mousedown(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: false});
      });
  }
  // ***************************************************************************
  
  // Eigene Elemente
  // ***************************************************************************
  $('.vSiteElemBoxBearLeisteEigenElemLink').click(function() {
    showCmsLinkWindow($(this), 'eigen');
  });
  
  $('.vSiteElemPicOwnBearLeisteLink').click(function() {
    showCmsLinkWindow($(this), 'eigenBild');
  });
  $('.vFrontOwnElemPicButtonNew').click(function() {
    var elemParent = $(this).parent();
    showWindowImageAuswahlOwnElemPic(elemParent, false);
  });
  
  $('.vSiteElemPicOwnBearLeisteDel').click(function() {
    delImageOnOwnElemPic($(this));
  });
  
  $('.vSiteElemBoxBearLeisteElemPicGal').click(function() {
    showEigenElemPicGalImagesWindowAuswahl($(this));
  });
  
  $('.vSiteElemTextOwnBearLeisteChange').click(function() {
    var curElemBeID = $(this).attr('data-id');
    var setTextElem = $(this).parent().parent().find('> .vFrontOwnElemTextInner');
    var setTextElemPar = $(this).parent().parent();
    startBearModusElemText(setTextElem, curElemBeID, setTextElemPar);
  });
  $('.vSiteElemTextOwnBearLeisteSave').click(function() {
    var curElemSaveID = $(this).attr('data-id');
    var curElemNum = $(this).attr('data-num');
    var textElemParent = $(this).parent().parent();
    saveElemOwnElemTextNow(curElemSaveID, curElemNum, textElemParent);
  });
  $('.vSiteElemTextOwnBearLeisteCancel').click(function() {
    var stopTextElem = $(this).parent().parent().find('> .vFrontOwnElemTextInner');
    var stopTextElemPar = $(this).parent().parent();
    stopBearModusElemText(stopTextElem, stopTextElemPar);
  });
  // ***************************************************************************
  
  
  // Alias (Verknüpfungs) Element
  // ***************************************************************************
  $('.vFrontSiteAliasElementButtonNew').click(function() {
    var curAliasElement = $(this).parent().parent().parent();
    var curAliasInputField = curAliasElement.find('.vcmsCurAliasInputField');
    showNewWindowAliasElementSet(curAliasElement, curAliasInputField);
  });
  
  $('.vFrontSiteAliasElementButtonNewBild1').click(function() {
    var curAliasElement = $(this).parent().parent().parent();
    showWindowImageAuswahlAliasElemPicMM(curAliasElement, false);
  });
  
  $('.vFrontSiteAliasElementBildDelMM').click(function() {
    var curAliasElementD = $(this).parent().parent().parent().parent();
    delTheBildOnceInAliasElementMM(curAliasElementD);
  });
  // ***************************************************************************
  
  
  // Kontaktformular Element
  // ***************************************************************************
  $('.vFrontSiteKontaktFormElementButtonNewMM').click(function() {
    var curKontaktFormElement = $(this).parent().parent().parent();
    var curKontaktFormInfoField = curKontaktFormElement.find('.vFrontCurAliasElementInfoA');
    showNewWindowKontaktFormElementSet(curKontaktFormElement, curKontaktFormInfoField);
  });
  // ***************************************************************************
  
  
  $('.vSiteElemBoxBearLeisteElemAliasMoreInfo').click(function() {
    showElemAliasMoreInfoWindow($(this).attr('data-id'));
  });
  
  
  $('.vSiteElemBoxBearLeisteOwnSettingElem').click(function() {
    showElemOwnSettingUsersWindow($(this));
  });
}







function initElementsMenuReload(sitePosElem) {
  if ($('body').attr('data-lang') == '') {
    var elemsDropR = sitePosElem.find('.vFrontDroppable');
    elemsDropR.droppable({
      hoverClass: "ui-state-dragger-hover",
      activeClass: "ui-state-dragger",
      accept: ".vFrontDragElem",
      drop: function(event, ui) {
        showCmsIsLoading();
        var sitePosElem = $(this).parent();
        var elemID = ui.draggable.attr('id').replace('vCMSElem-', '');
        setNewDragElemUser(sitePosElem, sitePosElem.attr('data-name'), sitePosElem.attr('data-id'), elemID, $(this).attr('data-count'));
      }
    });
  }
  
  // Textfeld
  // ***************************************************************************
  var elemsChangeR = sitePosElem.find('.vSiteElemBoxBearLeisteChange');
  elemsChangeR.click(function() {
    var curElemBeID = $(this).attr('id').replace('elemBeID-', '');
    var setTextElemPar = $(this).parent().parent();
    var setTextElem = setTextElemPar.find('> .vSiteElemBoxInhalt');
    startBearModusElemText(setTextElem, curElemBeID, setTextElemPar);
  });
  var elemsSaveR = sitePosElem.find('.vSiteElemBoxBearLeisteSave');
  elemsSaveR.click(function() {
    var curElemSaveID = $(this).attr('id').replace('elemSaveID-', '');
    var textElemParent = $(this).parent().parent();
    saveElemTextNow(curElemSaveID, textElemParent);
  });
  var elemsCancelR = sitePosElem.find('.vSiteElemBoxBearLeisteCancel');
  elemsCancelR.click(function() {
    var stopTextElemPar = $(this).parent().parent();
    var stopTextElem = stopTextElemPar.find('> .vSiteElemBoxInhalt');
    stopBearModusElemText(stopTextElem, stopTextElemPar);
  });
  // ***************************************************************************
  
  var elemsDelR = sitePosElem.find('.vSiteElemBoxBearLeisteDel');
  elemsDelR.click(function() {
    var checkerDel = confirm('Möchten Sie das Element wirklich löschen?');
    if (checkerDel == true) {
      showCmsIsLoading();
      var sitePosElemDel = $(this).parent().parent().parent();
      var curElemDelID = $(this).attr('id').replace('elemDelID-', '');
      delThisSiteElemNow(curElemDelID, sitePosElemDel);
    }
  });
  
  var elemsCopyER = sitePosElem.find('.vSiteElemBoxBearLeisteElemCopy');
  elemsCopyER.click(function() {
    saveTheCurentCopyElementNow($(this).attr('data-id'));
  });
  
  // Bild
  // ***************************************************************************
  var elemsPicLink = sitePosElem.find('.vSiteElemBoxBearLeisteBildLink');
  elemsPicLink.click(function() {
    showCmsLinkWindow($(this), 'bild');
  });
  
  var elemsPicButtonNewR = sitePosElem.find('.vFrontSiteBildElementButtonNew');
  elemsPicButtonNewR.click(function() {
    showWindowImageAuswahlElemPic('vFrontElemPicVal-'+$(this).attr('data-id'), false, $(this).attr('data-id'));
  });
  var elemsChangeBildR = sitePosElem.find('.vSiteElemBoxBearLeisteBildChange');
  elemsChangeBildR.click(function() {
    var curElemBeID = $(this).attr('id').replace('elemBeID-', '');
    var setTextElemPar = $(this).parent().parent();
    var setTextElem = setTextElemPar.find('.vSiteElemBoxInhalt');
    var newPicButtonCur = setTextElemPar.find('.vFrontSiteBildElementButtonNew');
    var bildInElementCur = setTextElemPar.find('.vSiteBildElementHolder');
    newPicButtonCur.show();
    bildInElementCur.resizable({
      //containment:".innerrrr"
      //aspectRatio: true,
      maxWidth: setTextElem.width()
    });
    startBearModusElemBild(setTextElem, curElemBeID, setTextElemPar);
  });
  var elemsSaveBildR = sitePosElem.find('.vSiteElemBoxBearLeisteBildSave');
  elemsSaveBildR.click(function() {
    var curElemBildSaveID = $(this).attr('id').replace('elemSaveID-', '');
    var parOfElem = $(this).parent().parent();
    var resizeElem = parOfElem.find('.vSiteBildElementHolder');
    var stopTextElem = parOfElem.find('.vSiteElemBoxInhalt');
    saveBildElemResizeNow(curElemBildSaveID, resizeElem, stopTextElem, parOfElem);
  });
  var elemsCancelBildR = sitePosElem.find('.vSiteElemBoxBearLeisteBildCancel');
  elemsCancelBildR.click(function() {
    var stopTextElemPar = $(this).parent().parent();
    var stopTextElem = stopTextElemPar.find('.vSiteElemBoxInhalt');
    stopBearModusElemBild(stopTextElem, stopTextElemPar);
  });
  // ***************************************************************************
  
  // Spalten
  // ***************************************************************************
  if ($('body').attr('data-lang') == '') {
    var elemsSpaltenDropR = sitePosElem.find('.vFrontSpaltenElementDroppable');
    elemsSpaltenDropR.droppable({
      hoverClass: "ui-state-dragger-hover",
      activeClass: "ui-state-dragger",
      accept: ".vFrontDragElem",
      drop: function(event, ui) {
        var sitePosElem = $(this).parent().parent().parent().parent();
        var selemCurID = $(this).parent().parent().parent().attr('data-elem');
        var selemRowID = $(this).parent().attr('data-row');
        var elemID = ui.draggable.attr('id').replace('vCMSElem-', '');
        if (elemID == 4) {
          alert('Dieses Element ist in einem Spaltenelement nicht erlaubt!');
        }
        else {
          setNewDragElemUserSpalten(sitePosElem, sitePosElem.attr('data-name'), sitePosElem.attr('data-id'), selemCurID, selemRowID, elemID, $(this).attr('data-count'));
        }
      }
    });
  }
  var elemsDelSpaltenElR = sitePosElem.find('.vSiteElemBoxBearLeisteInSpalteDel');
  elemsDelSpaltenElR.click(function() {
    var checkerDel = confirm('Möchten Sie das Element wirklich löschen?');
    if (checkerDel == true) {
      showCmsIsLoading();
      var sitePosElemDel = $(this).parent().parent().parent().parent().parent().parent();
      var curElemDelID = $(this).attr('id').replace('elemDelID-', '');
      delThisSiteElemNow(curElemDelID, sitePosElemDel);
    }
  });
  var elemsSettingsSpaltenElR = sitePosElem.find('.vSiteElemBoxBearLeisteSetting');
  elemsSettingsSpaltenElR.click(function() {
    var sitePosSeElem = $(this).parent().parent().parent();
    var curElemSettingID = $(this).attr('id').replace('elemSettingID-', '');
    showCurElemSpaltenSettingWindow(curElemSettingID, sitePosSeElem);
  });
  
  // Spalten Elemente Sortieren
  // ***************************************
  if ($('body').attr('data-lang') == '') {
    var elemsSpaltenRowElR = sitePosElem.find('.vSiteElemSpalteRow');
    elemsSpaltenRowElR.sortable({
      items: "> .vCmsCanElemSortableImportant",
      placeholder: "ui-state-highlight",
      delay: 300,
      axis: 'y',
      tolerance: "pointer",
      start: function(event, ui) {
        var drops = $(this).find('.vFrontSpaltenElementDroppable');
        drops.hide();
      },
      stop: function(event, ui) {
        showCmsIsLoading();
        sortThisSpaltenElements($(this));
      }
    });
    elemsSpaltenRowElR.sortable({disabled: true});

    var elemsSpaltenBearLeElR = elemsSpaltenRowElR.find('> .vSiteElemBox > .vSiteElemBoxBearLeiste');
    elemsSpaltenBearLeElR
      .mouseup(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: true});
      })
      .mousedown(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: false});
      });
  }
  // ***************************************
  // ***************************************************************************
  
  // Elemente Sortieren
  // ***************************************************************************
  if ($('body').attr('data-lang') == '') {
    sitePosElem.sortable({
      items: "> .vCmsCanElemSortableImportant",
      placeholder: "ui-state-highlight",
      delay: 300,
      axis: 'y',
      tolerance: "pointer",
      start: function(event, ui) {
        var drops = $(this).find('.vFrontDroppable');
        drops.hide();
      },
      stop: function(event, ui) {
        showCmsIsLoading();
        sortThisElements($(this), false);
        loadNewElemPosInhaltOnly($(this));
        //setSortBaumNow(ui.item.parent().attr('id'));
      }
    });
    sitePosElem.sortable({disabled: true});

    var elemsSortsCanElR = sitePosElem.find('> .vSiteElemBox > .vSiteElemBoxBearLeiste');
    elemsSortsCanElR
      .mouseup(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: true});
      })
      .mousedown(function() {
        var curParContentElem = $(this).parent().parent();
        curParContentElem.sortable({disabled: false});
      });
  }
  // ***************************************************************************
  
  // Eigene Elemente
  // ***************************************************************************
  var elemOwnSelfLink = sitePosElem.find('.vSiteElemBoxBearLeisteEigenElemLink');
  elemOwnSelfLink.click(function() {
    showCmsLinkWindow($(this), 'eigen');
  });
  
  var elemOwnPicLink = sitePosElem.find('.vSiteElemPicOwnBearLeisteLink');
  elemOwnPicLink.click(function() {
    showCmsLinkWindow($(this), 'eigenBild');
  });
  var elemOwnPicNewBtn = sitePosElem.find('.vFrontOwnElemPicButtonNew');
  elemOwnPicNewBtn.click(function() {
    var elemParent = $(this).parent();
    showWindowImageAuswahlOwnElemPic(elemParent, false);
  });
  
  var elemOwnPicDelNowBtnN = sitePosElem.find('.vSiteElemPicOwnBearLeisteDel');
  elemOwnPicDelNowBtnN.click(function() {
    delImageOnOwnElemPic($(this));
  });
  
  var elemOwnPicGalAuswahlBtn = sitePosElem.find('.vSiteElemBoxBearLeisteElemPicGal');
  elemOwnPicGalAuswahlBtn.click(function() {
    showEigenElemPicGalImagesWindowAuswahl($(this));
  });
  
  var elemOwnTextChange = sitePosElem.find('.vSiteElemTextOwnBearLeisteChange');
  elemOwnTextChange.click(function() {
    var curElemBeID = $(this).attr('data-id');
    var setTextElem = $(this).parent().parent().find('> .vFrontOwnElemTextInner');
    var setTextElemPar = $(this).parent().parent();
    startBearModusElemText(setTextElem, curElemBeID, setTextElemPar);
  });
  var elemOwnTextSave = sitePosElem.find('.vSiteElemTextOwnBearLeisteSave');
  elemOwnTextSave.click(function() {
    var curElemSaveID = $(this).attr('data-id');
    var curElemNum = $(this).attr('data-num');
    var textElemParent = $(this).parent().parent();
    saveElemOwnElemTextNow(curElemSaveID, curElemNum, textElemParent);
  });
  var elemOwnTextCancel = sitePosElem.find('.vSiteElemTextOwnBearLeisteCancel');
  elemOwnTextCancel.click(function() {
    var stopTextElem = $(this).parent().parent().find('> .vFrontOwnElemTextInner');
    var stopTextElemPar = $(this).parent().parent();
    stopBearModusElemText(stopTextElem, stopTextElemPar);
  });
  // ***************************************************************************
  
  
  // Alias (Verknüpfungs) Element
  // ***************************************************************************
  var elemAliasElementButtonNew = sitePosElem.find('.vFrontSiteAliasElementButtonNew');
  elemAliasElementButtonNew.click(function() {
    var curAliasElement = $(this).parent().parent().parent();
    var curAliasInputField = curAliasElement.find('.vcmsCurAliasInputField');
    showNewWindowAliasElementSet(curAliasElement, curAliasInputField);
  });
  
  var elemAliasElementButtonNewBild1 = sitePosElem.find('.vFrontSiteAliasElementButtonNewBild1');
  elemAliasElementButtonNewBild1.click(function() {
    var curAliasElement = $(this).parent().parent().parent();
    showWindowImageAuswahlAliasElemPicMM(curAliasElement, false);
  });
  
  var elemAliasElementBildDelMM = sitePosElem.find('.vFrontSiteAliasElementBildDelMM');
  elemAliasElementBildDelMM.click(function() {
    var curAliasElementD = $(this).parent().parent().parent().parent();
    delTheBildOnceInAliasElementMM(curAliasElementD);
  });
  // ***************************************************************************
  
  
  // Kontaktformular Element
  // ***************************************************************************
  var elemKontaktFormElementNewSetBtnMM = sitePosElem.find('.vFrontSiteKontaktFormElementButtonNewMM');
  elemKontaktFormElementNewSetBtnMM.click(function() {
    var curKontaktFormElement = $(this).parent().parent().parent();
    var curKontaktFormInfoField = curKontaktFormElement.find('.vFrontCurAliasElementInfoA');
    showNewWindowKontaktFormElementSet(curKontaktFormElement, curKontaktFormInfoField);
  });
  // ***************************************************************************
  
  
  var elemBoxBearLeisteElemAliasMoreInfoBtn = sitePosElem.find('.vSiteElemBoxBearLeisteElemAliasMoreInfo');
  elemBoxBearLeisteElemAliasMoreInfoBtn.click(function() {
    showElemAliasMoreInfoWindow($(this).attr('data-id'));
  });
}














function setNewDragElemUser(sitePosElem, siteDropName, siteID, elemID, elemPosition) {
  var curDataJson = {_art: 'setNewDragElemUser', VCMS_POST_LANG: $('body').attr('data-lang'), _siteDropName: siteDropName, _siteID: siteID, _elemID: elemID, _elemPosition: elemPosition, _elemPosInherit: sitePosElem.attr('data-inherit')};
  
  if (elemID == 0) {
    curDataJson['_copySelemID'] = $('.vFrontDragElemCopy').attr('data-id');
  }
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: curDataJson,
    success: function(data) {
      sitePosElem.html(data);
      initElementsMenuReload(sitePosElem);
      sortThisElements(sitePosElem, true);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



// Element setzen für Spalten
// *****************************************************************************
function setNewDragElemUserSpalten(sitePosElem, sitePosElemDataName, sitePosElemSiteID, selemCurID, selemRowID, elemID, elemPosition) {
  var curDataJson = {_art: 'setNewDragElemSpaltenUser', VCMS_POST_LANG: $('body').attr('data-lang'), _siteDropName: sitePosElemDataName, _siteID: sitePosElemSiteID, _elemID: elemID, _elemPosition: elemPosition, _elemPosInherit: sitePosElem.attr('data-inherit'), _selemCurID: selemCurID, _selemRowID: selemRowID};
  
  if (elemID == 0) {
    curDataJson['_copySelemID'] = $('.vFrontDragElemCopy').attr('data-id');
  }
  
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: curDataJson,
    success: function(data) {
      sitePosElem.html(data);
      initElementsMenuReload(sitePosElem);
      //sortThisElements(sitePosElem, true);
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *****************************************************************************



function delThisSiteElemNow(elemToDelID, sitePosElem) {
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delThisSiteElemNow', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: elemToDelID, _siteDropName: sitePosElem.attr('data-name'), _siteID: sitePosElem.attr('data-id'), _elemPosInherit: sitePosElem.attr('data-inherit')},
    success: function(data) {
      sitePosElem.html(data);
      initElementsMenuReload(sitePosElem);
      sortThisElements(sitePosElem, true);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function startBearModusElemText(elemToSet, siteElemID, elemParent) {
  if (!elemToSet.hasClass('bearStateOn')) {
    elemToSet.addClass('bearStateOn');
    elemParent.addClass('bearStateOn');
    elemToSet.tinymce({
      inline:true,
      menubar: false,
      language: 'de',
      /*plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste"
      ],*/
      plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste"
      ],
      //toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
      toolbar: "insertfile undo redo | styleselect | bold italic underline | charmap | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code",
      //valid_elements: "iframe[frameborder|src|width|height|name|align|id|class|style]",
      //extended_valid_elements: "iframe[frameborder|src|width|height|name|align|id|class|style]",
      //valid_elements: "iframe[frameborder|src|width|height|name|align|id|class|style]",
      file_browser_callback: function(field_name, url, type, win) {
        showCmsEditorLinkWindow(field_name, url);
      },
      init_instance_callback : function(editor) {
        elemParent.find('.vSiteElemTextOwnBearLeisteSave').attr('data-edit', editor.id);
        elemParent.find('.vSiteElemBoxBearLeisteSave').attr('data-edit', editor.id);
        console.log("Editor: " + editor.id + " is now initialized.");
      }
    });
  }
}



function startBearModusElemBild(elemToSet, siteElemID, elemParent) {
  if (!elemToSet.hasClass('bearStateOn')) {
    elemToSet.addClass('bearStateOn');
    elemParent.addClass('bearStateOn');
  }
}



function stopBearModusElemText(elemToStop, elemToStopParent) {
  elemToStop.removeClass('bearStateOn');
  elemToStopParent.removeClass('bearStateOn');
  elemToStop.tinymce().destroy();
  elemToStop.blur();
}
function stopBearModusElemBild(elemToStop, elemToStopParent) {
  elemToStop.removeClass('bearStateOn');
  elemToStopParent.removeClass('bearStateOn');
  var newPicButtonCur = elemToStopParent.find('.vFrontSiteBildElementButtonNew');
  var bildInElementCur = elemToStopParent.find('.vSiteBildElementHolder');
  newPicButtonCur.hide();
  bildInElementCur.resizable('destroy');
}



function sortThisElements(sitePosElem, hideLoader) {
  var elemsToSortList = sitePosElem.find('> .vSiteElemBox');
  var elemsToSort = '';
  var listCount = 1;
  
  $.each(elemsToSortList, function() {
    if (listCount == 1) {
      elemsToSort += $(this).attr('data-elem');
    }
    else {
      elemsToSort += ';'+$(this).attr('data-elem');
    }
    listCount = listCount + 1;
  });
  
  if (listCount > 1) {
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'sortThisSiteElements', VCMS_POST_LANG: $('body').attr('data-lang'), _elemsToSort: elemsToSort},
      success: function(data) {
        if (hideLoader) {
          hideCmsIsLoading();
        }
      },
      error: function() {
        showAjaxFehler();
      }
    });
  }
  else {
    hideCmsIsLoading();
  }
}




function saveElemTextNow(curElemSaveID, textElemParent) {
  var curEditId = textElemParent.find('.vSiteElemBoxBearLeisteSave').attr('data-edit');
  var curTextInhaltEdit = tinyMCE.get(curEditId).getContent();

  showCmsIsLoading();
  var stopTextElem = textElemParent.find('.vSiteElemBoxInhalt');
  stopBearModusElemText(stopTextElem, textElemParent);
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveTextInTextElement', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curElemSaveID, _elemInhalt: curTextInhaltEdit},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}






// *****************************************************************************
// ANFANG - Funktionen für Bild Element
// *****************************************************************************

function saveNewBildInElement(elemID, bildID) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewBildInElement', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: elemID, _bildID: bildID},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function saveBildElemResizeNow(selemID, picHolderResize, stopTextElem, stopTextElemPar) {
  showCmsIsLoading();
  var checkWidthElem = stopTextElemPar.find('.vSiteElemBoxInhalt');
  var curWidthOfElem = picHolderResize.width()+'px';
  if (picHolderResize.width() >= checkWidthElem.width()) {
    curWidthOfElem = '100%';
  }
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveBildElemResizeNow', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: selemID, _selemWidth: curWidthOfElem},
    success: function(data) {
      picHolderResize.attr('style', 'width:'+picHolderResize.width()+'px');
      stopBearModusElemBild(stopTextElem, stopTextElemPar);
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Bild Element
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Bildauswahl Window (Einzel Bild Elemente)
// *****************************************************************************

function showWindowImageAuswahlElemPic(curDataFieldId, dataMultiPic, selemID) {
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
      initImageAuswahlWindowElemPic(curDataFieldId, dataMultiPic, selemID);
      initImageAuswahlWindowElemPicKatSelect(curDataFieldId, dataMultiPic, selemID);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initImageAuswahlWindowElemPic(curDataFieldId, dataMultiPic, selemID) {  
  $('.vFrontAuswahlImgElement').dblclick(function() {
    $('#'+curDataFieldId).val($(this).attr('data-id'));
    
    var curPicEl = $('#'+curDataFieldId).parent().find('img');
    curPicEl.attr('src', 'user_upload/'+$(this).attr('data-file'));
    closeCenterWindowImageAuswahl();
    saveNewBildInElement(selemID, $(this).attr('data-id'));
  });
}



// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlWindowElemPicKatSelect(curDataFieldId, dataMultiPic, selemID) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    var curDataFieldIdR = curDataFieldId;
    var dataMultiPicR = dataMultiPic;
    var selemIDR = selemID;
    
    showWindowImageAuswahlElemPicReload($(this).val(), curDataFieldIdR, dataMultiPicR, selemIDR);
  });
}



function showWindowImageAuswahlElemPicReload(curKatId, curDataFieldId, dataMultiPic, selemID) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  var curDataFieldIdR = curDataFieldId;
  var dataMultiPicR = dataMultiPic;
  var selemIDR = selemID;
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initImageAuswahlWindowElemPic(curDataFieldIdR, dataMultiPicR, selemIDR);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************

// *****************************************************************************
// ENDE - Funktionen für Bildauswahl Window (Einzel Bild Elemente)
// *****************************************************************************






// *****************************************************************************
// ANFANG - Funktionen für Spalten Settings
// *****************************************************************************

function showCurElemSpaltenSettingWindow(curElemID, sitePosSeElem) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettings').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmallSettings').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showSpaltenSettingAuswahl', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curElemID},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
      initSpaltenSettingWindow(sitePosSeElem);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initSpaltenSettingWindow(sitePosSeElem) {
  $('#vSpaltenAnzahlDropDown').msDropdown();
  
  $('#vSaveSpaltenSettings').click(function() {
    showCmsIsLoading();
    var curSaveID = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'saveSpaltenSettingsNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curSaveID, _curSpalten: $('#vSpaltenAnzahlDropDown').val(), _curPosDropName: sitePosSeElem.attr('data-name'), _curPosSiteID: sitePosSeElem.attr('data-id'), _curPosInherit: sitePosSeElem.attr('data-inherit')},
      success: function(data) {
        sitePosSeElem.html(data);
        closeCenterWindowSmallSettings();
        initElementsMenuReload(sitePosSeElem);
        hideCmsIsLoading();
      },
      error: function() {
        showAjaxFehler();
      }
    });
  });
}

// *****************************************************************************
// ENDE - Funktionen für Spalten Settings
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Spalten Sortieren
// *****************************************************************************

function sortThisSpaltenElements(curRowElem) {
  var sortString = '';
  var elemsToSortSp = curRowElem.find('> .vSiteElemBox');
  var counter = 0;
  $.each(elemsToSortSp, function() {
    counter = counter + 1;
    if (counter == 1) {
      sortString = sortString + $(this).attr('data-elem');
    }
    else {
      sortString = sortString + ';' + $(this).attr('data-elem');
    }
  });
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'setNewSortPosSpaltenElements', VCMS_POST_LANG: $('body').attr('data-lang'), _sortString: sortString, _rowNumber: curRowElem.attr('data-row'), _curElemId: curRowElem.parent().parent().attr('data-elem')},
    success: function(data) {
      loadNewElemPosInhaltOnly(curRowElem.parent().parent().parent());
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Spalten Sortieren
// *****************************************************************************





function loadNewElemPosInhaltOnly(curElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'loadNewElemPosInhaltOnly', VCMS_POST_LANG: $('body').attr('data-lang'), _siteDropName: curElem.attr('data-name'), _siteID: curElem.attr('data-id'), _elHolderInherit: curElem.attr('data-inherit')},
    success: function(data) {
      curElem.html(data);
      initElementsMenuReload(curElem);
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}







// *****************************************************************************
// ANFANG - Funktionen für eigene Element (Textfeld und Bild)
// *****************************************************************************

function saveElemOwnElemTextNow(curElemSaveID, curElemNum, textElemParent) {
  var curEditId = textElemParent.find('.vSiteElemTextOwnBearLeisteSave').attr('data-edit');
  var curTextInhaltEdit = tinyMCE.get(curEditId).getContent();
  
  showCmsIsLoading();
  var stopTextElem = textElemParent.find('> .vFrontOwnElemTextInner');
  stopBearModusElemText(stopTextElem, textElemParent);
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveElemOwnElemTextNow', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curElemSaveID, _elemNum: curElemNum, _elemInhalt: curTextInhaltEdit},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




function showWindowImageAuswahlOwnElemPic(curElem, dataMultiPic) {
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
      initImageAuswahlWindowOwnElemPic(curElem, dataMultiPic);
      initImageAuswahlWindowOwnElemPicKatSelect(curElem, dataMultiPic);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initImageAuswahlWindowOwnElemPic(curElem, dataMultiPic) {  
  $('.vFrontAuswahlImgElement').dblclick(function() {
    var curPicEl = curElem.find('img');
    curPicEl.attr('src', 'user_upload/'+$(this).attr('data-file'));
    closeCenterWindowImageAuswahl();
    saveNewBildInOwnElement(curElem, $(this).attr('data-id'));
  });
}



// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlWindowOwnElemPicKatSelect(curElem, dataMultiPic) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    var curElemR = curElem;
    var dataMultiPicR = dataMultiPic;
    
    showWindowImageAuswahlOwnElemPicReload($(this).val(), curElemR, dataMultiPicR);
  });
}



function showWindowImageAuswahlOwnElemPicReload(curKatId, curElem, dataMultiPic) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  var curElemR = curElem;
  var dataMultiPicR = dataMultiPic;
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initImageAuswahlWindowOwnElemPic(curElemR, dataMultiPicR);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************



function saveNewBildInOwnElement(curElem, curPicId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewBildInOwnElement', VCMS_POST_LANG: $('body').attr('data-lang'), _elemID: curElem.attr('data-id'), _elemNum: curElem.attr('data-num'), _bildID: curPicId},
    success: function(data) {
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function delImageOnOwnElemPic(curElemDelBtn) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delImageOnOwnElemPic', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: curElemDelBtn.attr('data-id'), _selemNum: curElemDelBtn.attr('data-num')},
    success: function(data) {
      hideCmsIsLoading();
      var curElemParent = curElemDelBtn.parent().parent();
      var curElemRi = curElemParent.find('.vSiteElemPicOwnInner');
      curElemRi.html('<img title="" alt="NoImg" src="admin/img/noImg.png" />');
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für eigene Element (Textfeld und Bild)
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Element Kopieren
// *****************************************************************************

var drag_fixed_c = 1;

function saveTheCurentCopyElementNow(curElemId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveTheCurentCopyElementNow', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: curElemId},
    success: function(data) {
      if (data == true) {
        $('.vFrontDragElemCopy').remove();
        $('#vFrontHeader').append('<div class="vFrontDragElem vFrontDragElemCopy" id="vCMSElem-0" data-id="'+curElemId+'">kopiertes Element<div class="vFrontDragElemCopyCloseBtnMM" title="Entfernen"></div></div>');
        $(".vFrontDragElemCopy").draggable({
          zIndex: 999999,
          revert: 'invalid',
          containment: 'document',
          helper: 'clone',
          cursor: 'move',
          appendTo: 'body',
          start: function(event, ui) {
            drag_fixed_c = 0;
          },
          drag: function(event, ui){
            if(drag_fixed_c == 0) {
              var marg = $('body, html').scrollTop(); //$(ui.helper).offset().top + $('body').scrollTop();
              $(ui.helper).css('margin-top', '-'+marg+'px');
              drag_fixed_c = 1;
            }
          }
        });
        $('.vFrontDragElemCopyCloseBtnMM').click(function() {
          delTheDragElementCopyElementNowMM();
        });
        //showOkWindowNow('Das Element wurde erfolgreich in die Zwischenablage kopiert.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}

// *****************************************************************************
// ENDE - Funktionen für Element Kopieren
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für Alias (Verknüpfungs) Elemente
// *****************************************************************************

function showNewWindowAliasElementSet(curAliasElement, curAliasInputField) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettings').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Element Verknüpfen');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmallSettings').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showNewWindowAliasElementSet', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curAliasElement.attr('data-elem')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
      initNewWindowAliasElementSet(curAliasElement);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initNewWindowAliasElementSet(curAliasElement) {
  $('#vSaveAliasElementChange').click(function() {
    saveNewElementSetOnAliasElement(curAliasElement);
  });
  
  
  $('.vFrontSmallAliasElemShowAuswahlWindow').click(function() {
    showAliasWindowElementAuswahl();
  });
}



function saveNewElementSetOnAliasElement(curAliasElement) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewElementSetOnAliasElement', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curAliasElement.attr('data-elem'), _setElementID: $('#frmAliasElementElementIdFrm').val()},
    success: function(data) {
      if (data == 'isAlias') {
        showErrorWindowNow('Einen Verknüpfungs Element ist nicht erlaubt.');
      }
      else if (data == 'isSpalten') {
        showErrorWindowNow('Einen Spalten Element ist in einem Spalten Element nicht erlaubt.');
      }
      else if (data == 'elemNotFound') {
        showErrorWindowNow('Die Element ID wurde nicht gefunden.');
      }
      else if (data == 'error') {
        showErrorWindowNow('Es ist ein Fehler aufgetreten.');
      }
      else {
        var curInfoHtml = curAliasElement.find('.vFrontCurAliasElementInfoA');
        curInfoHtml.html(data);
        closeCenterWindowSmallSettings();
        showOkWindowNow('Das Element wurde erfolgreich verknüpft.');
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function showAliasWindowElementAuswahl() {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Element auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showAliasWindowElementAuswahl', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initAliasWindowElementAuswahl();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initAliasWindowElementAuswahl() {
  $('.vFrontAliasSiteDropKlick').click(function() {
    $('#vFrontCurAliasElementsAuswahl'+$(this).attr('data-id')).toggle();
  });
  
  $('.vFrontCurSelemToChange').click(function() {
    $('#frmAliasElementElementIdFrm').val($(this).attr('data-id'));
    closeCenterWindowAllgemeinCMSWindow();
  });
}

// *****************************************************************************
// ENDE - Funktionen für Alias (Verknüpfungs) Elemente
// *****************************************************************************







// *****************************************************************************
// ANFANG - Funktionen für eigene Elemente Bilder Galerie Auswahl
// *****************************************************************************

function showEigenElemPicGalImagesWindowAuswahl(picGalAuswahlBtn) {
  var curOwnElement = picGalAuswahlBtn.parent().parent();
  
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowSmallSettings').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowSmallSettings').addClass('vFrontSetBigWindowClassNow');
  
  $('#vFrontCenterWindowSmallSettingsInhalt').html('');
  $('#vFrontCenterWindowSmallSettingsInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowSmallSettingsHeadInhalt').html('Bilder zuweisen');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowSmallSettings').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showEigenElemPicGalImagesWindowAuswahl', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curOwnElement.attr('data-elem')},
    success: function(data) {
      $('#vFrontCenterWindowSmallSettingsInhalt').html(data);
      initEigenElemPicGalImagesWindowAuswahl(picGalAuswahlBtn);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initEigenElemPicGalImagesWindowAuswahl(picGalAuswahlBtn) {

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
  
  
  $('.vFrontFrmListHolderHeaderPicGalElemAdd').click(function() {
    showWindowBilderGalerieElemsAuswahl($(this).parent().parent().attr('data-field'));
  });
  // ***************************************************************************
  
  
  $('#vSaveOwnElemPicGalChange').click(function() {
    showCmsIsLoading();
    $.ajax({
      type: "POST",
      url: "admin/frontAdmin/ajax_php/ajax.php",
      data: {_art: 'vSaveOwnElemPicGalChange', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: $(this).attr('data-id'), _picGalImages: $('#vFrontFrmOwnElemPicGalImgs').val(), _picGalElemID: $('#vFrontFrmOwnElemPicGalsElem').val()},
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
}



function showWindowBilderGalerieElemsAuswahl(curDataField) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Bilder Galerie auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showWindowBilderGalerieElemsAuswahl', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initWindowBilderGalerieElemsAuswahl(curDataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initWindowBilderGalerieElemsAuswahl(curDataField) {
  $('.vFrontBaumElemPicGalElemZ').click(function() {
    $('#'+curDataField).val($(this).attr('data-id'));
    var curListHtml = '<div class="vFrontFrmListsElem" data-elem="' + $(this).attr('data-id') + '">';
    curListHtml += '<div class="vFrontFrmListsElemBild">&nbsp;</div>';
    curListHtml += '<div class="vFrontFrmListsElemText">' + $(this).attr('data-name') + '</div>';
    curListHtml += '<div class="clearer"></div>';
    curListHtml += '</div>';
    var ListObjHolder = $('#'+curDataField).parent().find('.vFrontFrmListHolderLists');
    ListObjHolder.html(curListHtml);
    closeCenterWindowAllgemeinCMSWindow();
  });
}

// *****************************************************************************
// ENDE - Funktionen für eigene Elemente Bilder Galerie Auswahl
// *****************************************************************************









function showElemAliasMoreInfoWindow(curSelemID) {
  var abstandLeft = ($(window).width() / 2) - (500 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Seiten auf denen das Element verknüpft ist');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showElemAliasMoreInfoWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSelemID: curSelemID},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}










function showWindowImageAuswahlAliasElemPicMM(curElem, dataMultiPic) {
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
      initImageAuswahlWindowAliasElemPicMM(curElem, dataMultiPic);
      initImageAuswahlWindowAliasElemPicKatSelectMM(curElem, dataMultiPic);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initImageAuswahlWindowAliasElemPicMM(curElem, dataMultiPic) {  
  $('.vFrontAuswahlImgElement').dblclick(function() {
    var curPicHolderEl = curElem.find('.vFrontSiteAliasElementBildHolderMM');
    curPicHolderEl.attr('data-id', $(this).attr('data-id'));
    curPicHolderEl.html('<img src="user_upload/'+$(this).attr('data-file')+'" alt="" title="" /><div class="vFrontSiteAliasElementBildDelMM">Bild löschen</div>');
    closeCenterWindowImageAuswahl();
    
    var curPicNewButtonDel = curElem.find('.vFrontSiteAliasElementBildDelMM');
    curPicNewButtonDel.click(function() {
      var curAliasElementD = $(this).parent().parent().parent().parent();
      delTheBildOnceInAliasElementMM(curAliasElementD);
    });
    
    saveNewBildOnceInAliasElementMM(curElem.attr('data-elem'), $(this).attr('data-id'));
  });
}



// Für Bild Auswahl Kategorien umschalten
// *************************************************************
function initImageAuswahlWindowAliasElemPicKatSelectMM(curElem, dataMultiPic) {
  $('#vFrontBildAuswahlKatSelect').msDropdown();

  $('#vFrontBildAuswahlKatSelect').change(function() {
    var curElemR = curElem;
    var dataMultiPicR = dataMultiPic;
    
    showWindowImageAuswahlAliasElemPicReloadMM($(this).val(), curElemR, dataMultiPicR);
  });
}



function showWindowImageAuswahlAliasElemPicReloadMM(curKatId, curElem, dataMultiPic) {
  $('.vFrontAuswahlImgVerwaltHolder').html('');
  $('.vFrontAuswahlImgVerwaltHolder').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  
  var curElemR = curElem;
  var dataMultiPicR = dataMultiPic;
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showBildAuswahlInhaltOnReload', VCMS_POST_LANG: $('body').attr('data-lang'), _curKatId: curKatId},
    success: function(data) {
      $('.vFrontAuswahlImgVerwaltHolder').html(data);
      initImageAuswahlWindowAliasElemPicMM(curElemR, dataMultiPicR);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}
// *************************************************************



function saveNewBildOnceInAliasElementMM(curElemId, picId) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveNewBildOnceInAliasElementMM', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: curElemId, _picID: picId},
    success: function(data) {
      if (data == true) {
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



function delTheBildOnceInAliasElementMM(curElem) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delTheBildOnceInAliasElementMM', VCMS_POST_LANG: $('body').attr('data-lang'), _selemID: curElem.attr('data-elem')},
    success: function(data) {
      if (data == true) {
        var curPicHolderEl = curElem.find('.vFrontSiteAliasElementBildHolderMM');
        curPicHolderEl.attr('data-id', '');
        curPicHolderEl.html('');
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







function delTheDragElementCopyElementNowMM() {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'delTheDragElementCopyElementNowMM', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      if (data == true) {
        $('.vFrontDragElemCopy').remove();
      }
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}






function showNewWindowKontaktFormElementSet(curKontaktFormElement, curKontaktFormInfoField) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Kontaktformular auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showNewWindowKontaktFormElementSet', VCMS_POST_LANG: $('body').attr('data-lang'), _curSeitElemId: curKontaktFormElement.attr('data-elem')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      $('.vFrontKontaktFormAuflistungAuswahl .vFrontBaumElem').click(function() {
        getNewWindowKontaktFormElementSetElemNow($(this), curKontaktFormElement, curKontaktFormInfoField);
      });
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function getNewWindowKontaktFormElementSetElemNow(curSetObj, curKontaktFormElement, curKontaktFormInfoField) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'getNewWindowKontaktFormElementSetElemNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSeitElemId: curKontaktFormElement.attr('data-elem'), _curKontaktId: curSetObj.attr('data-id')},
    success: function(data) {
      closeCenterWindowAllgemeinCMSWindow();
      curKontaktFormInfoField.html('Kontaktformular Name: &nbsp;'+curSetObj.attr('data-name'));
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}







// *****************************************************************************
// ANFANG - Funktionen für Element Einstellungen
// *****************************************************************************

function showElemOwnSettingUsersWindow(settingBtnObj) {
  var isOwnElem = 'no';
  if (typeof(settingBtnObj.attr('data-sart')) != 'undefined') {
    if (settingBtnObj.attr('data-sart') == 'own') {
      isOwnElem = 'yes';
    }
  }
  
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowElementSettingsCaCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowElementSettingsCaCMSWindowInhalt').html('');
  $('#vFrontCenterWindowElementSettingsCaCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowElementSettingsCaCMSWindowHeadInhalt').html('Element Einstellungen');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowElementSettingsCaCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showElemOwnSettingUsersWindow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSeitElemId: settingBtnObj.attr('data-id'), _isOwnElem: isOwnElem},
    success: function(data) {
      $('#vFrontCenterWindowElementSettingsCaCMSWindowInhalt').html(data);
      initElemOwnSettingUsersWindow();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initElemOwnSettingUsersWindow() {
  $('.vFrontOwnElemSettingsWindowInInhaltSystem select').msDropDown();
  
  $('.vFrontOwnElemSettingsWindowInInhaltSystem .vFrontOwnElemSettingsWindowInInhaltSystemCalendar').datepicker({
    showOn: "both",
    minDate: "-0d",
    buttonImage: "../../../admin/img/calendar.png",
    buttonImageOnly: true,
    dateFormat: "dd.mm.yy"
  });
  $('.vFrontOwnElemSettingsWindowInInhaltSystem .vFrontOwnElemSettingsWindowInInhaltSystemTime').timepicker({
    hourText: 'Stunden',
    minuteText: 'Minuten',
    showOn: 'both',
    button: '#timePickerBtnImg'
  });
  
  $('.vFrontOwnElemSettingsWindowInHeaderBtnSave').click(function() {
    saveElemOwnSettingUsersWindowNowJs($(this));
  });
  
  
  initFiltersystemAuswahlListBySettings();
  
  
  // Funktionen sind in der Datei siteSettings.js
  // ************************************************************************************
  initSeitEigOwnFelder();
  initSeitEigOwnFelderPicMultiFields();
  initSeitEigOwnFelderPicOnceFields();
  initSeitEigOwnFelderDateiOnceFields();
  initSeitEigOwnFelderDateiMultiFields();
  initSeitEigOwnFelderSeitenRelMultiFields();
}



function saveElemOwnSettingUsersWindowNowJs(curSaveBtnObj) {
  showCmsIsLoading();
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'saveElemOwnSettingUsersWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _isElemOwnElem: curSaveBtnObj.attr('data-art'), _curSiteElemId: curSaveBtnObj.attr('data-id'), _elemSettingDateAb: $('#vFrontOwnElemSettingDateAb').val(), _elemSettingTimeAb: $('#vFrontOwnElemSettingTimeAb').val(), _elemSettingDateBis: $('#vFrontOwnElemSettingDateBis').val(), _elemSettingTimeBis: $('#vFrontOwnElemSettingTimeBis').val(), _elemSettingElemOnline: $('#vFrontOwnElemSettingElemOnline').val(), _elemSettingDesktopShow: $('#vFrontOwnElemSettingDesktopShow').val(), _elemSettingTabletShow: $('#vFrontOwnElemSettingTabletShow').val(), _elemSettingMobileShow: $('#vFrontOwnElemSettingMobileShow').val(), _userOwnDataArr: $('.vFrontOwnElemSettingsWindowInInhaltEigen form').serializeArray()},
    success: function(data) {
      CenterWindowElementSettingsCaCMSWindow();
      showOkWindowNow('Die Element Einstellungen wurden erfolgreich gespeichert.');
      hideCmsIsLoading();
    },
    error: function() {
      showAjaxFehler();
    }
  });
}




// Funktionen für Filter Kategorien Listen Feld
// ***************************************************************

function initFiltersystemAuswahlListBySettings() {
  $('.vFrontFrmListHolder .vFrontFrmListHolderListsOwnFilterSysKatFieldMulti').selectable();
  
  
  $('.vFrontFrmListHolderHeaderAddOwnFilterSysKatFieldMulti').click(function() {
    showFiltersystemAuswahlListBySettingsAuswahlWinMulti($(this).parent().parent().attr('data-field'));
  });
  
  
  $('.vFrontFrmListHolderHeaderDelOwnFilterSysKatFieldMulti').click(function() {
    var parElEig = $(this).parent().parent();
    var selectedElems = parElEig.find('.vFrontFrmListHolderLists > .ui-selected');
    $.each(selectedElems, function() {
      $(this).remove();
    });
    setNewSortFiltersystemAuswahlListInField(parElEig);
  });
}



function showFiltersystemAuswahlListBySettingsAuswahlWinMulti(dataField) {
  var abstandLeft = ($(window).width() / 2) - (600 / 2);
  $('#vFrontCenterWindowAllgemeinCMSWindow').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('');
  $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowAllgemeinCMSWindowHeadInhalt').html('Filter Kategorien auswählen');
  $('#vFrontOverlayFive').show();
  $('#vFrontCenterWindowAllgemeinCMSWindow').show();
  
  $.ajax({
    type: "POST",
    url: "admin/frontAdmin/ajax_php/ajax.php",
    data: {_art: 'showFiltersystemAuswahlListBySettingsAuswahlWinMulti', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('#vFrontCenterWindowAllgemeinCMSWindowInhalt').html(data);
      initFiltersystemAuswahlListAuswahlWinMulti(dataField);
    },
    error: function() {
      showAjaxFehler();
    }
  });
}



function initFiltersystemAuswahlListAuswahlWinMulti(curDataFieldId) {
  $('.mmModulFiltersysAdminWindowKatAuswahlHolder .vFrontHpSeAuflistung').selectable({
    filter: ".vFrontHpSeAuflistungLiFiltersysKat"
    //cancel: "#vFrontListButtonSelectedNow, .vFrontIsNaviCur"
  });
  
  $('.mmModulFiltersysAdminWindowHeadAuswahlFiltKatBtn').click(function() {
    var allSelectedElems = $(this).parent().parent().find('.mmModulFiltersysAdminWindowKatAuswahlHolder .ui-selected');
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



function setNewSortFiltersystemAuswahlListInField(parElEig) {
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

// ***************************************************************

// *****************************************************************************
// ENDE - Funktionen für Element Einstellungen
// *****************************************************************************