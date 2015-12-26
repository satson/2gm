
var isFixedAnfrageFooterShowed = true;
var areTourentippsLoaded = false;

$(document).ready(function() {
  
  if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmBildTextHolderSliderElemUeTourentippMM').length > 0) {
      $('.mmTourentippsDetailElementScrollToTextHolderBtn').html('<i class="fa fa-angle-down"></i>'+$('.mmBildTextHolderSliderElemUeTourentippMM > .vFrontOwnElemTextHolder > .vFrontOwnElemTextInner').html()+'<i class="fa fa-angle-down fa-angle-downLastMM"></i>');
    }
    
    
    $('.mmTourentippsDetailElementScrollToTextHolderBtn').click(function() {
      $("html, body").animate({ scrollTop: $('.mmBildTextHolderSliderElemUeTourentippMM').offset().top - 150 }, 1000);
    });
  }
  
  
  
  // Header Animate
  // ***************************************************************************
  $(window).scroll(function() {
    if ($(window).width() > 1199) {
      if ($(window).scrollTop() > 1) {
        if (!$(".siteHeaderNormal").hasClass('isStateSmallMM')) {
          $(".siteHeaderNormal").addClass('isStateSmallMM');
          $(".siteHeaderNormal").stop().animate({ height: '112px'}, 300);
          $('.siteHeaderNormal .siteHeaderInfoHolder').stop().animate({ marginTop: '10px', marginBottom: '5px'}, 300);
          
          $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({ fontSize: '18px'}, 300);
          $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({ fontSize: '18px'}, 300);
          $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({ fontSize: '18px'}, 300);
          
          $('.siteHeaderNormal .siteHeaderLogoHolder').hide();
          $('.siteHeaderNormal .siteHeaderLogoHolderOnScrollShow').show();

          $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '20px');
          $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '51px');

          //$('.siteHeaderInfoBalkenLeftHolderMM').stop().animate({ marginTop: '-8px'}, 400);
        }
      }
      else {
        //$("#siteHeaderInfoBalken").removeClass('isStateSmallMM');
        //$('.siteHeaderInfoBalkenLeftHolderMM').stop().animate({ marginTop: '0px'}, 400);
        $('.siteHeaderNormal .siteHeaderInfoHolder').stop().animate({ marginTop: '35px', marginBottom: '12px'}, 300);
        
        $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({ fontSize: '20px'}, 300);
        $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({ fontSize: '20px'}, 300);
        $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({ fontSize: '20px'}, 300);
        
        $(".siteHeaderNormal").stop().animate({ height: '160px'}, 300, function() {
          $(".siteHeaderNormal").removeClass('isStateSmallMM');
          $('.siteHeaderNormal .siteHeaderLogoHolderOnScrollShow').hide();
          $('.siteHeaderNormal .siteHeaderLogoHolder').show();
        });

        $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '36px');
        $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '67px');
      }
    }
    else {
      $('.siteHeaderNormal .siteHeaderInfoHolder').css('margin-top', '');
      $('.siteHeaderNormal .siteHeaderInfoHolder').css('margin-bottom', '');
      
      $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').css('font-size', '');
      $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').css('font-size', '');
      $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').css('font-size', '');
      
      $(".siteHeaderNormal").css('height', 'auto');
      
      $(".siteHeaderNormal").removeClass('isStateSmallMM');
      $('.siteHeaderNormal .siteHeaderLogoHolderOnScrollShow').hide();
      $('.siteHeaderNormal .siteHeaderLogoHolder').show();

      $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '');
      $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '');
    }
  });
  
  
  
  
  // Header Animate Detail
  // ***************************************************************************
  $(window).scroll(function() {
    if ($(window).width() > 1199) {
      if ($(window).scrollTop() > 1) {
        if (!$(".siteHeaderDetail").hasClass('isStateSmallMM')) {
          $(".siteHeaderDetail").addClass('isStateSmallMM');
          $(".siteHeaderDetail").stop().animate({ height: '112px'}, 300, function() {
            $('.siteHeaderDetail .siteHeaderLogoHolderOnScrollShow').show();
          });
          $('.siteHeaderDetail .siteHeaderInfoHolder').stop().animate({ marginTop: '10px', marginBottom: '5px'}, 300);
          
          $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({ fontSize: '18px'}, 300);
          $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({ fontSize: '18px'}, 300);
          $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({ fontSize: '18px'}, 300);
          
          $('.mmDetailElementTopUeBig').hide();
          $('.siteHeaderDetail .siteHeaderLogoHolder').hide();

          $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '20px');
          $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '51px');

          //$('.siteHeaderInfoBalkenLeftHolderMM').stop().animate({ marginTop: '-8px'}, 400);
        }
      }
      else {
        //$("#siteHeaderInfoBalken").removeClass('isStateSmallMM');
        //$('.siteHeaderInfoBalkenLeftHolderMM').stop().animate({ marginTop: '0px'}, 400);
        $('.siteHeaderDetail .siteHeaderInfoHolder').stop().animate({ marginTop: '35px', marginBottom: '12px'}, 300);
        
        $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({ fontSize: '20px'}, 300);
        $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({ fontSize: '20px'}, 300);
        $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({ fontSize: '20px'}, 300);
        
        $(".siteHeaderDetail").stop().animate({ height: '260px'}, 300, function() {
          $(".siteHeaderDetail").removeClass('isStateSmallMM');
          $('.siteHeaderDetail .siteHeaderLogoHolderOnScrollShow').hide();
          $('.siteHeaderDetail .siteHeaderLogoHolder').show();
          $('.mmDetailElementTopUeBig').show();
        });

        $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '36px');
        $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '67px');
      }
    }
    else {
      $('.siteHeaderDetail .siteHeaderInfoHolder').css('margin-top', '');
      $('.siteHeaderDetail .siteHeaderInfoHolder').css('margin-bottom', '');
      
      $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').css('font-size', '');
      $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').css('font-size', '');
      $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').css('font-size', '');
      
      $(".siteHeaderDetail").css('height', 'auto');
      
      $(".siteHeaderDetail").removeClass('isStateSmallMM');
      $('.siteHeaderDetail .siteHeaderLogoHolderOnScrollShow').hide();
      $('.siteHeaderDetail .siteHeaderLogoHolder').show();
      $('.mmDetailElementTopUeBig').show();

      $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint').css('padding-bottom', '');
      $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > .v_siteUnterMenu').css('top', '');
    }
  });
  
  
  
  
  // Hintergrundbilder Zufallsgenerator
  // ***************************************************************************
  if (typeof backImages != 'undefined') {
    if (backImages != '') {
      var randomBackImage = backImages[Math.floor(Math.random()*backImages.length)];
      backImageOnce = randomBackImage;
    }
  }
  backImages = undefined;
  
  
  
  // Big Header Bild Höhe setzen
  // ***************************************************************************
  $('.siteHeaderBigPicHolder').height($(window).height() - $('.siteHeader').height());
  
  $(window).resize(function() {
    $('.siteHeaderBigPicHolder').height($(window).height() - $('.siteHeader').height());
  });
  
  
  
  // Detail Element Header Text setzen
  // ***************************************************************************
  if ($('.mmPauschaleDetailElement').length > 0) {
    var curTextUeForUeObj = $('.mmPauschaleDetailElement').find('.mmPauschaleDetailElementTopUe');
    if ($('.mmDetailElementTopUeBig').length > 0) {
      $('.mmDetailElementTopUeBig').html(curTextUeForUeObj.html());
      $('.mmDetailElementTopUeBig').show();
    }
  }
  
  if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmPauschaleDetailElementTopUeOnlyDetailHeader').length > 0) {
      var curTextUeForUeObj = $('.mmPauschaleDetailElement').find('.mmPauschaleDetailElementTopUeOnlyDetailHeader');
      if ($('.mmDetailElementTopUeBig').length > 0) {
        $('.mmDetailElementTopUeBig').html(curTextUeForUeObj.html());
        $('.mmDetailElementTopUeBig').show();
      }
    }
  }
  
  
  
  // Linken Text Margin und padding setzen
  // ***************************************************************************
  var curPositionNumberNew = 150;
  
  var curLeftAbstandSitePosLeft = (($(window).width() - $('.container').first().width()) / 2);
  curLeftAbstandSitePosLeft = curLeftAbstandSitePosLeft + curPositionNumberNew;
  var curLeftAbstandSitePosLeftPadding = curLeftAbstandSitePosLeft - curPositionNumberNew;
  $('.siteLeftPos').css('margin-left', '-'+curLeftAbstandSitePosLeft+'px');
  $('.siteLeftPos').css('padding-left', curLeftAbstandSitePosLeftPadding+'px');
  
  $(window).resize(function() {
    var curLeftAbstandSitePosLeft = (($(window).width() - $('.container').first().width()) / 2);
    curLeftAbstandSitePosLeft = curLeftAbstandSitePosLeft + curPositionNumberNew;
    var curLeftAbstandSitePosLeftPadding = curLeftAbstandSitePosLeft - curPositionNumberNew;
    $('.siteLeftPos').css('margin-left', '-'+curLeftAbstandSitePosLeft+'px');
    $('.siteLeftPos').css('padding-left', curLeftAbstandSitePosLeftPadding+'px');
  });
  
  
  
  // Auszeichnungen weniger/mehr
  // ***************************************************************************
  $('.mmAuszeichnungenHolderShowHideBtn').click(function() {
    var curSlideElem = $(this).parent().find('.mmAuszeichnungenHolderElementHolder');
    var curBtnText = $(this).find('.mmAuszeichnungenHolderShowHideBtnText');
    var curMehrTextMM = $(this).parent().find('.mmAuszeichnungenHolderElementHideMoreTextMM').html();
    var curWenigerTextMM = $(this).parent().find('.mmAuszeichnungenHolderElementHideWenigerTextMM').html();
    if ($(this).hasClass('isBtnAuszeichnungClose')) {
      curSlideElem.slideDown();
      $(this).removeClass('isBtnAuszeichnungClose');
      curBtnText.html(curWenigerTextMM);
    }
    else {
      curSlideElem.slideUp();
      $(this).addClass('isBtnAuszeichnungClose');
      curBtnText.html(curMehrTextMM);
    }
  });
  
  
  
  // Info Box weniger/mehr
  // ***************************************************************************
  $('.mmInfoBoxHolderElementMehrWenigerBtn').click(function() {
    var curSlideElem = $(this).parent().parent().parent().find('.mmInfoBoxHolderElementPlaceHolderElems');
    var curBtnText = $(this);
    var curMehrTextMM = $(this).parent().parent().find('.mmInfoBoxHolderElementHideMoreTextMM').html();
    var curWenigerTextMM = $(this).parent().parent().find('.mmInfoBoxHolderElementHideWenigerTextMM').html();
    if ($(this).hasClass('isBtnInfosMMClose')) {
      curSlideElem.slideDown();
      $(this).removeClass('isBtnInfosMMClose');
      curBtnText.html(curWenigerTextMM);
    }
    else {
      curSlideElem.slideUp();
      $(this).addClass('isBtnInfosMMClose');
      curBtnText.html(curMehrTextMM);
    }
  });
  
  
  
  if ($('body.vcmsUserLogedIn').length < 1) {
    // Auszeichnungen Bilder Galerie
    // ***************************************************************************
    $('.mmAuszeichnungenSpaltenElementOwnElemIsLinkPicGalNow').click(function() {
      var curPicGalHolderAuszeichnungen = $(this).parent().find('.mmAuszeichnungenSpaltenElementOwnElemPicGalElems');
      var curPicGalAuszeichnungenFirstImg = curPicGalHolderAuszeichnungen.find('a.ownElemPicGalerieLinkClass').first();
      curPicGalAuszeichnungenFirstImg.click();
    });



    // Info Button Bilder Galerie
    // ***************************************************************************
    $('.mmInfoBoxBtnElementOwnElemIsLinkPicGalNow').click(function() {
      var curPicGalHolderInfo = $(this).parent().find('.mmInfoBoxBtnElementOwnElemPicGalElems');
      var curPicGalInfoFirstImg = curPicGalHolderInfo.find('a.ownElemPicGalerieLinkClass').first();
      curPicGalInfoFirstImg.click();
    });
  }
  
  
  
  // Kategorien Filter
  // ***************************************************************************
  $('.mmPauschalenUebersichtElementBottomWithFilter').isotope({
    itemSelector: '.mmPauschalenUebersichtElementSpalte',
    layoutMode: 'fitRows'
  });
  
  $('.mmPauschalenUebersichtElementTopKategorienBtn').click(function() {
    if ($(this).hasClass('mmTourentippsUebersichtElementTopKategorienBtn')) {
      // Für Tourentipps Filter
      // ***********************************************************************
      if ($(this).attr('data-id') == '*') {
        $('.mmPauschalenUebersichtElementTopKategorienBtn').removeClass('isActiveFilterBtn');
        $(this).addClass('isActiveFilterBtn');
        $('.mmTourentippsUebersichtElementBottomAjax').hide();
        $('.mmTourentippsUebersichtElementBottom').show();
      }
      else if ($(this).hasClass('isActiveFilterBtn')) {
        $(this).removeClass('isActiveFilterBtn');
        
        setCurentFilterForTourentippsAjax($(this));
      }
      else {
        $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').removeClass('isActiveFilterBtn');
        $(this).addClass('isActiveFilterBtn');
        
        $('.mmTourentippsUebersichtElementBottom').hide();
        
        if (areTourentippsLoaded == false) {
          $('.mmTourentippsUebersichtElementBottomAjax .row').html('<div style="text-align:center; font-size:48px; margin-top:80px"><i class="fa fa-spinner fa-pulse"></i></div>');
        }
        $('.mmTourentippsUebersichtElementBottomAjax').show();
        if (areTourentippsLoaded == false) {
          loadAllTourentippsForFilterAjax($(this));
        }
        else {
          setCurentFilterForTourentippsAjax($(this));
        }
      }
      // ***********************************************************************
    }
    else {
      if ($(this).attr('data-id') == '*') {
        $('.mmPauschalenUebersichtElementTopKategorienBtn').removeClass('isActiveFilterBtn');
        $(this).addClass('isActiveFilterBtn');
        $('.mmPauschalenUebersichtElementBottomWithFilter').isotope({ filter: '*' });
      }
      else if ($(this).hasClass('isActiveFilterBtn')) {
        $(this).removeClass('isActiveFilterBtn');
        
        setCurentFilterSetAllActive();
      }
      else {
        $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').removeClass('isActiveFilterBtn');
        $(this).addClass('isActiveFilterBtn');
        
        setCurentFilterSetAllActive();
        //$('.mmPauschalenUebersichtElementBottomWithFilter').isotope({ filter: '.mmPauschalenUebersichtElementSpalteId-'+$(this).attr('data-id') });
      }
    }
  });
  
  
  
  // Schnellanfrage Datepicker
  // ***************************************************************************
  $('.isSystemCalendarPickMM').datepicker({
    //showOn: "both",
    minDate: "-0d",
    /*buttonImage: "../../../admin/img/calendar.png",
    buttonImageOnly: true,*/
    dateFormat: "dd.mm.yy"
  });
  
  
  
  // Detail Header Bilder
  // ***************************************************************************
  if ($('.mmPauschaleDetailElementBilderHeadBild1').length > 0) {
    var curImgDD = '';
    var curPicElemDet = $('.mmPauschaleDetailElementBilderHeadBild1').find('img').first();
    var curLinkElemDet = $('.mmPauschaleDetailElementBilderHeadBild1').find('a').first();
    if (curPicElemDet.length > 0) {
      //curPicElemDet.attr('src', curPicElemDet.attr('src').replace('/thumb_800', ''));
      curImgDD = curPicElemDet.attr('src').replace('/thumb_800', '');
    }
    if (curLinkElemDet.length > 0) {
      //curPicElemDet.attr('src', curPicElemDet.attr('src').replace('/thumb_800', ''));
      //curImgDD = curPicElemDet.attr('src').replace('/thumb_800', '');
      if ($('body.vcmsUserLogedIn').length < 1) {
        curLinkElemDet.html('');
        $('.mmPauschaleDetailElementBilderHead').wrap(curLinkElemDet);
      }
    }
    $('.mmPauschaleDetailElementBilderHeadBild1').html('');
    $('.mmPauschaleDetailElementBilderHeadBild1').show();
    $('.mmPauschaleDetailElementBilderHeadBild1').backstretch(curImgDD);
    /*$('.mmPauschaleDetailElementBilderHeadBild1').maximage({
      fillElement: '.mmPauschaleDetailElementBilderHead',
      //backgroundSize: 'contain',
      cssBackgroundSize: false,
      overrideMSIEStop: true,
      onFirstImageLoaded: function() {
        $('.mmPauschaleDetailElementBilderHeadBild1').fadeIn(300, function() {
          //$('#vcmsFullHDPicGalerieLoader').remove();
        });
      }
    });*/
    
    $('.mmPauschaleDetailElementTopUe').click(function(e) {
      e.preventDefault();
    });
  }
  
  
  
  // Detail Header Bild 2
  // ***************************************************************************
  if ($('.mmPauschaleDetailElementBilderHeadBild2').length > 0) {
    var curImgDD2 = '';
    var curPicElemDet2 = $('.mmPauschaleDetailElementBilderHeadBild2').find('img').first();
    var curLinkElemDet2 = $('.mmPauschaleDetailElementBilderHeadBild2').find('a').first();
    if (curPicElemDet2.length > 0) {
      //curPicElemDet.attr('src', curPicElemDet.attr('src').replace('/thumb_800', ''));
      curImgDD2 = curPicElemDet2.attr('src').replace('/thumb_800', '');
    }
    if (curLinkElemDet2.length > 0) {
      curLinkElemDet2.html('');
      //$('.mmPauschaleDetailElementBilderHead').wrap(curLinkElemDet2);
    }
    $('.mmPauschaleDetailElementBilderHeadBild2').html('');
    $('.mmPauschaleDetailElementBilderHeadBild2').show();
    $('.mmPauschaleDetailElementBilderHeadBild2').backstretch(curImgDD2);
    
    
    
    var curWidthHeadPic1 = (($(window).width() - $('.container').width()) / 2) + ($('.container').width() - $('.mmPauschaleDetailElementRightBoxInfo').width());
    
    $('.mmPauschaleDetailElementBilderHeadBild1').css('right', 'auto');
    $('.mmPauschaleDetailElementBilderHeadBild1').css('width', curWidthHeadPic1+'px');
    
    var curWidthHeadPic2 = ($(window).width() - $('.container').width()) / 2;
    
    $('.mmPauschaleDetailElementBilderHeadBild2').css('left', 'auto');
    $('.mmPauschaleDetailElementBilderHeadBild2').css('width', curWidthHeadPic2+'px');
  }
  
  
  
  // Mobile Scroll Top Button
  // ***************************************************************************
  $('.siteFooterButtonToTopMobileOnly').click(function() {
    $("html, body").animate({ scrollTop: 0 }, 800);
  });
  
  
  
  // Partner Slide
  // ***************************************************************************
  if ($(window).width() < 992) {
    startSliderOnPartnersBottom();
  }
  else {
    stopSliderOnPartnersBottom();
  }
  
  $(window).resize(function() {
    if ($(window).width() < 992) {
      startSliderOnPartnersBottom();
    }
    else {
      stopSliderOnPartnersBottom();
    }
  });
  
  
  
  if ($(window).width() < 768) {
    startSliderOnPauschalenHomeUebersicht();
  }
  else {
    stopSliderOnPauschalenHomeUebersicht();
  }
  
  $(window).resize(function() {
    if ($(window).width() < 768) {
      startSliderOnPauschalenHomeUebersicht();
    }
    else {
      stopSliderOnPauschalenHomeUebersicht();
    }
  });
  
  
  
  
  $('.navbar-toggle').click(function() {
    if ($(this).hasClass('collapsed')) {
      $('.siteHeaderLogoHolderOnlySmallA').css('visibility', 'hidden');
      $('.siteHeaderLogoHolderOnlySmallImgS').show();
    }
    else {
      window.setTimeout('setSmallHeaderLogoHideTime()', 500);
    }
  });
  
  
  
  if ($(window).width() > 1199) {
    $("#navbar > ul > li > a").unbind("click");
    startSuperfishTopMenuSet();
  }
  else {
    startMobileMenuTopMenuSet();
  }
  
  $(window).resize(function() {
    if ($(window).width() > 1199) {
      $("#navbar > ul > li > a").unbind("click");
      startSuperfishTopMenuSet();
    }
    else {
      $('.v_siteMenu').superfish('destroy');
      startMobileMenuTopMenuSet();
    }
  });
  
  
  
  $(window).scroll(function() {
    var isSmallWin = false;
    var isSmallWinMob = false;
    var fixedBottomAbstand = '0px';
    if (isFixedAnfrageFooterShowed == true) {
      fixedBottomAbstand = '94px';
    }
    if ($(window).width() < 992) {
      fixedBottomAbstand = '0px';
      isSmallWin = true;
    }
    if ($(window).width() < 768) {
      isSmallWinMob = true;
    }
    else {
      $('.siteFooterButtonToTopMobileOnly').css('bottom', '10px');
      $('.siteFooterButtonToTopMobileOnly').fadeOut(500);
    }
    
    if ($(window).scrollTop() + $(window).height() > ($('.siteFooterPartnerHolder').offset().top + 95) && isFixedAnfrageFooterShowed == true && isSmallWin == false) {
      var curBottomArrowAbstand = ($(window).scrollTop() + $(window).height()) - $('.siteFooterPartnerHolder').offset().top;
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').css('bottom', curBottomArrowAbstand+'px');
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').fadeIn(500);
      $('.mmSchnellAnfrageElementSiteHomepageFixed').fadeIn(500);
    }
    else if ($(window).scrollTop() + $(window).height() > ($('.siteFooterPartnerHolder').offset().top) && (isFixedAnfrageFooterShowed == false || isSmallWin == true)) {
      var curBottomArrowAbstand = ($(window).scrollTop() + $(window).height()) - $('.siteFooterPartnerHolder').offset().top;
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').css('bottom', curBottomArrowAbstand+'px');
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').fadeIn(500);
      $('.mmSchnellAnfrageElementSiteHomepageFixed').fadeIn(500);
    }
    else if ($(window).scrollTop() > ($(window).height() - 100)) {
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').css('bottom', fixedBottomAbstand);
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').fadeIn(500);
      $('.mmSchnellAnfrageElementSiteHomepageFixed').fadeIn(500);
    }
    else {
      //$('.mmScrollTopBtn').hide();
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').fadeOut(500);
      $('#siteArrowScrollTopSiteBtn, #siteArrowBackDetailSiteBtn').css('bottom', fixedBottomAbstand);
      $('.mmSchnellAnfrageElementSiteHomepageFixed').fadeOut(500);
    }
    
    
    
    
    if ($(window).scrollTop() + $(window).height() > ($('.siteFooterPartnerHolder').offset().top) && isSmallWinMob == true) {
      var curBottomArrowAbstandMo = ($(window).scrollTop() + $(window).height()) - ($('.siteFooterPartnerHolder').offset().top);
      $('.siteFooterButtonToTopMobileOnly').css('bottom', curBottomArrowAbstandMo+'px');
      $('.siteFooterButtonToTopMobileOnly').fadeIn(500);
    }
    else if ($(window).scrollTop() > ($(window).height() + 100) && isSmallWinMob == true) {
      $('.siteFooterButtonToTopMobileOnly').css('bottom', '10px');
      $('.siteFooterButtonToTopMobileOnly').fadeIn(500);
    }
    else {
      $('.siteFooterButtonToTopMobileOnly').css('bottom', '10px');
      $('.siteFooterButtonToTopMobileOnly').fadeOut(500);
    }
    
    
    if ($(window).scrollTop() + $(window).height() > ($('.siteFooterPartnerHolder').offset().top + 6) && isSmallWinMob == true) {
      var curBottomArrowAbstandMoF = ($(window).scrollTop() + $(window).height()) - ($('.siteFooterPartnerHolder').offset().top - 6);
      $('.siteFixedFilterButtonForMobile').css('bottom', curBottomArrowAbstandMoF+'px');
      $('.siteFixedFilterButtonForMobile').fadeIn(500);
    }
    else if ($(window).scrollTop() > ($(window).height() + 100) && isSmallWinMob == true) {
      $('.siteFixedFilterButtonForMobile').css('bottom', '16px');
      $('.siteFixedFilterButtonForMobile').fadeIn(500);
    }
    else {
      $('.siteFixedFilterButtonForMobile').css('bottom', '16px');
      $('.siteFixedFilterButtonForMobile').fadeOut(500);
    }
    
  });
  
  
  
  $('.mmSchnellAnfrageElementSiteHomepageFixedCloseBtn').click(function() {
    $('.mmSchnellAnfrageElementSiteHomepageFixed').hide();
    $('.mmSchnellAnfrageElementSiteHomepageFixed').addClass('mmSchnellAnfrageElementSiteHomepageFixedNoShow');
    $('.siteFooter').css('margin-bottom', '0px');
    isFixedAnfrageFooterShowed = false;
    $(window).scroll();
  });
  
  
  
  // Desktop Scroll Top Button
  // ***************************************************************************
  $('#siteArrowScrollTopSiteBtn').click(function() {
    $("html, body").animate({ scrollTop: 0 }, 800);
  });
  
  
  
  // Bild / Text Slider
  // ***************************************************************************
  if ($('body.vcmsUserLogedIn').length < 1) {
    $(".mmBildTextHolderSliderElem .mmBildTextHolderSliderElemSlides .vContentElemDD").owlCarousel({
      navigation: true,
      slideSpeed: 300,
      paginationSpeed: 400,
      singleItem: false,
      navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
      items: 3,
      itemsDesktop : [2000,3], //3 items between 2000px and 992px
      itemsDesktopSmall : [1100,2], // betweem 992px and 767px
      itemsTablet: [767,1], //1 items between 767 and 0
      itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
      afterUpdate: function() {
        window.setTimeout("setBildTextSliderHoverTextPos()", 500);
      },
      afterInit: function() {
        window.setTimeout("setBildTextSliderHoverTextPos()", 500);
      }
    });
    
    $('.mmBildTextSliderElemOnce').hover(function() {
      $(this).find('.mmBildTextSliderElemOnceText').first().stop().fadeIn(200);
      $(this).find('.mmBildTextSliderElemOnceCurShowIco').first().stop().fadeOut(200);
    },
    function() {
      $(this).find('.mmBildTextSliderElemOnceText').first().stop().fadeOut(200);
      $(this).find('.mmBildTextSliderElemOnceCurShowIco').first().stop().fadeIn(200);
    });
  }
  
  
  
  $('.mmTourenMehrLesenBtn').click(function() {
    var curClickBtn = $(this);
    var allActiveMehrInfoBtns = $('.mmTourentippsUebersichtElementBottom').find('.activeMehrInfoT');
    if (allActiveMehrInfoBtns.length < 1) {
      //$('.mmTourentippsUebersichtElementBottom').isotope('destroy');
      
      $('.mmTourentippsUebersichtMoreBoxShowInhalt').html('<div style="text-align:center; font-size:42px; margin-top:120px; margin-bottom:80px;"><i class="fa fa-spinner fa-pulse"></i></div>');
      
      $(this).addClass('activeMehrInfoT');
      var curBox = $(this).parent().parent().parent();
      if ($(window).width() > 1199) {
        var curBoxCountElem = curBox.nextAll('.mmTourentippsUebersichtMoreBoxShowCount4Elem').first();
      }
      else if ($(window).width() > 767) {
        var curBoxCountElem = curBox.nextAll('.mmTourentippsUebersichtMoreBoxShowCount2Elem').first();
      }
      else {
        var curBoxCountElem = curBox.nextAll('.mmTourentippsUebersichtMoreBoxShow').first();
      }
      curBoxCountElem.slideDown(500, function() {
        showAsyncTourenList(curClickBtn, curBoxCountElem);
        $("html, body").animate({scrollTop: $(curBoxCountElem).offset().top - 200}, 400);
      });
      curBoxCountElem.addClass('isStateOpenWinNow');
    }
    else {
      var state = 'yes';
      $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').slideUp(500, function() {
        $('.mmTourentippsUebersichtMoreBoxShow').removeClass('isStateOpenWinNow');
        if (!curClickBtn.hasClass('activeMehrInfoT')) {
          state = 'no';
        }
        allActiveMehrInfoBtns.removeClass('activeMehrInfoT');
        /*$('.mmTourentippsUebersichtElementBottom').isotope({
          itemSelector: '.mmPauschalenUebersichtElementSpalte',
          layoutMode: 'fitRows'
        });*/
        if (state == 'no') {
          curClickBtn.click();
        }
      });
    }
  });
  
  
  $(window).resize(function() {
    if ($('.mmTourenMehrLesenBtn.activeMehrInfoT').length > 0) {
      $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').hide();
      $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').removeClass('isStateOpenWinNow');
      $('.mmTourenMehrLesenBtn.activeMehrInfoT').removeClass('activeMehrInfoT');
    }
  });
  
  
  $('.mmTourenSchnellInfoBtn').click(function() {
    var curParElem = $(this).parent().parent();
    var curSchnellInfoWin = curParElem.find('.mmTourentippsUebersichtSchnellInfoWin');
    if (!$(this).hasClass('activeSchnellInfoT')) {
      curSchnellInfoWin.show();
      $(this).addClass('activeSchnellInfoT');
    }
    else {
      curSchnellInfoWin.hide();
      $(this).removeClass('activeSchnellInfoT');
    }
  });
  
  
  
  setButtonTextElementClickable();
  
  
  
  // Höhe von den Preistabellen setzen
  // ***************************************************************************
  /*if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmTableHolderElement').length > 0) {
      var allTableHolder = $('.siteContent').find('.mmTableHolderElement');
      $.each(allTableHolder, function() {
        var curTableUe = $(this).find('.mmTableHolderElementTopTextUeRow');
        var curTableUeRow = curTableUe.find('.row');
        curTableUeRow.height(curTableUe.height());
      });
      
      var allTableOwnElems = $('.siteContent').find('.mmTableOwnElementNew');
      $.each(allTableOwnElems, function() {
        var curTableOwnElemsRow = $(this).find('.row');
        $(this).height($(this).height());
      });
    }
  }*/
  
  
  
  // Footer bewertungen bei click anzeigen
  // ***************************************************************************
  $('.siteFooterTopBewertungenTextMehr').click(function() {
    showBewertungenInLightboxNow();
    
    /*$('.siteFooterTopBewertungenAusgabeDiv').html('');
    $('.mmSiteTopInfoBoxWhiteBewertungenInhaltCur').html('');
    
    $('.siteFooterTopBewertungenAusgabeDiv').html('<div style="text-align:center; font-size:48px; margin-top:80px"><i class="fa fa-spinner fa-pulse"></i></div>');
    
    showBewertungenInDivElement('.siteFooterTopBewertungenAusgabeDiv');*/
  });
  
  
  
  // CTA bewertungen bei click anzeigen
  // ***************************************************************************
  $('.mmSiteTopInfoBoxWhiteBwBtn').click(function() {
    showBewertungenInLightboxNow();
  });
  
  
  
  // Anfrage Buchen Buttons bewertungen bei click anzeigen
  // ***************************************************************************
  $('.mmAnfrageBuchenBtnsElementBewertungBtnTextS').click(function() {
    showBewertungenInLightboxNow();
  });
  
  
  
  // Drop Down Element
  // ***************************************************************************
  if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmDropDownInhaltElement').length > 0) {
      $('.mmDropDownInhaltElementBtn').click(function() {
        if ($(this).hasClass('mmDropDownInhaltElementBtnIsActive')) {
          $(this).removeClass('mmDropDownInhaltElementBtnIsActive');
          var CurInhaltElemDropD = $(this).parent().find('.mmDropDownInhaltElementInhaltHolder').first();
          
          var CurArrowBtnDropDown = $(this).find('.mmDropDownInhaltElementBtnArrow > i').first();
          
          CurArrowBtnDropDown.removeClass('fa-chevron-up');
          CurArrowBtnDropDown.addClass('fa-chevron-down');
          
          CurInhaltElemDropD.slideUp(400);
        }
        else {
          $('.mmDropDownInhaltElementBtn.mmDropDownInhaltElementBtnIsActive').click();
          $(this).addClass('mmDropDownInhaltElementBtnIsActive');
          var CurInhaltElemDropD = $(this).parent().find('.mmDropDownInhaltElementInhaltHolder').first();
          
          var CurArrowBtnDropDown = $(this).find('.mmDropDownInhaltElementBtnArrow > i').first();
          
          CurArrowBtnDropDown.removeClass('fa-chevron-down');
          CurArrowBtnDropDown.addClass('fa-chevron-up');
          
          CurInhaltElemDropD.slideDown(400, function() {
            $("html, body").animate({scrollTop: $(CurInhaltElemDropD).offset().top - 200}, 400);
          });
        }
      });
    }
  }
  
  
  
  // Mobile Filter Menü
  // ***************************************************************************
  $('.mmPauschalenUebersichtElementTopKategorienBtnsHolderFilterShowMobile, .siteFixedFilterButtonForMobile').click(function() {
    $('.mmPauschalenUebersichtElementAll .mmPauschalenUebersichtElementTopKategorien .mmPauschalenUebersichtElementTopKategorienBtnsHolder').animate({left: '0%'}, 500);
    $("html, body").animate({scrollTop: $('.mmPauschalenUebersichtElement .mmPauschalenUebersichtElementTop').offset().top + $('.mmPauschalenUebersichtElement .mmPauschalenUebersichtElementTop').height()}, 500);
  });
  
  
  $('.mmPauschalenUebersichtElementTopKategorienBtnsHolderCloseMobile').click(function() {
    $('.mmPauschalenUebersichtElementAll .mmPauschalenUebersichtElementTopKategorien .mmPauschalenUebersichtElementTopKategorienBtnsHolder').animate({left: '-85%'}, 500);
  });
  
  
  
  
  if (isFixedAnfrageFooterShowedOnSet == false) {
    $('.mmSchnellAnfrageElementSiteHomepageFixedCloseBtn').click();
  }
  
});




function showAsyncTourenList(curClickBtn, curBoxCountElem) {
  var wissensWertesText = curClickBtn.parent().parent().find('.mmTourentippsUebersichtSchnellInfoWin').first().html();
  
  $.ajax({
    type: "POST",
    url: "templates/wildkogel/ajax_php/ajaxTouren.php",
    data: {_art: 'showCmsInfosWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteId: curClickBtn.attr('data-id'), _textUrl: curClickBtn.attr('data-url'), _wissensWertes: wissensWertesText},
    success: function(data) {
      var curInhalt = curBoxCountElem.find('.mmTourentippsUebersichtMoreBoxShowInhalt');
      curInhalt.html(data);
      //$('#vFrontCenterWindowSmallInfoCMSInhalt').html(data);
      //initCmsInfosWindowFunctions();
    },
    error: function() {
      
    }
  });
}




function setBildTextSliderHoverTextPos() {
  $('.mmBildTextSliderElemOnce .mmBildTextSliderElemOnceText').show();
  var allBildTextSliderElemsOnce = $('.mmBildTextSliderElemOnce');
  $.each(allBildTextSliderElemsOnce, function() {
    var curTextSliderEl = $(this).find('.mmBildTextSliderElemOnceText .vFrontOwnElemTextInner');
    var curHeightK = ($(this).height() / 2) - (curTextSliderEl.height() / 2);
    curTextSliderEl.css('margin-top', curHeightK+'px');
  });
  $('.mmBildTextSliderElemOnce .mmBildTextSliderElemOnceText').hide();
}




function startSuperfishTopMenuSet() {
  $('.v_siteMenu').superfish({
    delay:50,
    cssArrows:false,
    disableHI:false
    //animation:{opacity:'show',height:'show'}
  });
}




function setSmallHeaderLogoHideTime() {
  $('.siteHeaderLogoHolderOnlySmallImgS').hide();
  $('.siteHeaderLogoHolderOnlySmallA').css('visibility', 'visible');
}





function startSliderOnPartnersBottom() {
  $(".siteFooterPartnerHolder .siteRightPos").owlCarousel({
    navigation: true,
    slideSpeed: 300,
    paginationSpeed: 400,
    singleItem: false,
    navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
    items: 3,
    itemsDesktop : [2000,8], //5 items between 2000px and 992px
    itemsDesktopSmall : [992,5], // betweem 992px and 767px
    itemsTablet: [767,3], //2 items between 767 and 0
    itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    // "singleItem:true" is a shortcut for:
    // items : 1,
    // itemsDesktop : false,
    // itemsDesktopSmall : false,
    // itemsTablet: false,
    // itemsMobile : false
  });
}

function stopSliderOnPartnersBottom() {
  var owl = $(".siteFooterPartnerHolder .siteRightPos").data('owlCarousel');
  if (typeof owl != "undefined") {
    owl.destroy();
  }
}




function startSliderOnPauschalenHomeUebersicht() {
  $(".mmPauschalenUebersichtElementBottomWithOwlCarousel .row").owlCarousel({
    navigation: false,
    slideSpeed: 300,
    paginationSpeed: 400,
    singleItem: true,
    navigationText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  });
}

function stopSliderOnPauschalenHomeUebersicht() {
  var owl = $(".mmPauschalenUebersichtElementBottomWithOwlCarousel .row").data('owlCarousel');
  if (typeof owl != "undefined") {
    owl.destroy();
  }
}



var firstTextButtonTextM = '';

function setButtonTextElementClickable() {
  /*if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmButtonTextElement').length > 0) {
      var allBtnTextElems = $('.siteContent').find('.mmButtonTextElement');
      var allBtnTextElemsText = allBtnTextElems.find('.mmButtonTextElementText');
      allBtnTextElemsText.hide();
      allBtnTextElemsText.addClass('mmButtonTextElementTextNoLogUser');
      
      var firstBtnTextElem = $('.siteContent').find('.mmButtonTextElement').first();
      
      var firstBtnTextElemBtnHolder = firstBtnTextElem.find('.mmButtonTextElementBtnsHolder');
      
      firstBtnTextElem.addClass('mmButtonTextElementIsFirstEl');
      firstBtnTextElem.css('margin-top', '30px');
      var firstBtnTextElemText = firstBtnTextElem.find('.mmButtonTextElementText');
      firstTextButtonTextM = firstBtnTextElemText.html();
      var firstBtnTextElemBtn = firstBtnTextElem.find('.mmButtonTextElementBtn');
      firstBtnTextElemBtn.addClass('mmButtonTextElementBtnActiveState');
      firstBtnTextElemBtn.addClass('mmButtonTextElementIsFirstElBtn');
      
      $.each(allBtnTextElems, function() {
        var thisBtnTextElemsBtn = $(this).find('.mmButtonTextElementBtn');
        thisBtnTextElemsBtn.css('float', 'none');
        thisBtnTextElemsBtn.css('margin-top', '5px');
        firstBtnTextElemBtnHolder.append(thisBtnTextElemsBtn);
      });
      
      firstBtnTextElemText.show();
    }
    
    
    $('.mmButtonTextElementBtn').click(function() {
      var allBtnTextElemsMM = $('.siteContent').find('.mmButtonTextElement');
      var allBtnTextElemsBtnsMM = allBtnTextElemsMM.find('.mmButtonTextElementBtn');
      allBtnTextElemsBtnsMM.removeClass('mmButtonTextElementBtnActiveState');
      $(this).addClass('mmButtonTextElementBtnActiveState');
      
      if ($(this).hasClass('mmButtonTextElementIsFirstElBtn')) {
        var firstBtnTextElemTextMMI = $('.siteContent').find('.mmButtonTextElement').first().find('.mmButtonTextElementText');
        firstBtnTextElemTextMMI.html(firstTextButtonTextM);
      }
      else {
        var firstBtnTextElemTextMM = $('.siteContent').find('.mmButtonTextElement').first().find('.mmButtonTextElementText');
        //var curTextElemToText = $(this).parent().parent().find('.mmButtonTextElementText');
        var curTextElemToText = $('.siteContent').find('#mmButtonTextElementTextCurId'+$(this).attr('data-id'));
        firstBtnTextElemTextMM.html(curTextElemToText.html());
      }
    });
  }*/
  
  
  
  if ($('body.vcmsUserLogedIn').length < 1) {
    if ($('.mmButtonTextElement').length > 0) {
      var allBtnTextElems = $('.siteContent').find('.mmButtonTextElement');
      var allBtnTextElemsText = allBtnTextElems.find('.mmButtonTextElementText');
      allBtnTextElemsText.hide();
      /*var allBtnTextElemsFirst = $('.siteContent').find('.mmButtonTextElement').first();
      var allBtnTextElemsTextFirst = allBtnTextElemsFirst.find('.mmButtonTextElementText');
      var allBtnTextElemsBtnFirst = allBtnTextElemsFirst.find('.mmButtonTextElementBtn');
      allBtnTextElemsBtnFirst.addClass('mmButtonTextElementBtnActiveState');
      allBtnTextElemsTextFirst.addClass('mmButtonTextElementBtnActiveState');
      allBtnTextElemsTextFirst.show();*/
    }
    
    
    
    $('.mmButtonTextElementBtn').click(function() {
      var curBtnTextElem = $(this).parent().parent();
      var curBtnTextElemBtnHolder = $(this).parent();
      var curBtnTextElemText = curBtnTextElem.find('.mmButtonTextElementText');
      var curBtnTextElemBtn = curBtnTextElem.find('.mmButtonTextElementBtn');
      var curBtnTextElemBtnArrowI = curBtnTextElem.find('.mmButtonTextElementBtnArrow > i');
      if ($(this).hasClass('mmButtonTextElementBtnActiveState')) {
        curBtnTextElemBtn.removeClass('mmButtonTextElementBtnActiveState');
        curBtnTextElemText.removeClass('mmButtonTextElementBtnActiveState');
        curBtnTextElemBtnHolder.removeClass('mmButtonTextElementBtnActiveState');
        
        curBtnTextElemBtnArrowI.removeClass('fa-chevron-up');
        curBtnTextElemBtnArrowI.addClass('fa-chevron-down');
        
        curBtnTextElemText.slideUp();
      }
      else {
        $('.mmButtonTextElementBtn.mmButtonTextElementBtnActiveState').click();
        curBtnTextElemBtn.addClass('mmButtonTextElementBtnActiveState');
        curBtnTextElemText.addClass('mmButtonTextElementBtnActiveState');
        curBtnTextElemBtnHolder.addClass('mmButtonTextElementBtnActiveState');
        
        curBtnTextElemBtnArrowI.removeClass('fa-chevron-down');
        curBtnTextElemBtnArrowI.addClass('fa-chevron-up');
        
        curBtnTextElemText.slideDown(500, function() {
          $("html, body").animate({scrollTop: $(curBtnTextElem).offset().top - 200}, 400);
        });
      }
    });
  }
}






var isSetMobileMenuColOnce = false;
function startMobileMenuTopMenuSet() {
  $("#navbar > ul > li > a").unbind("click");
  
  $('#navbar > ul > li > a').click(function(e) {
    e.preventDefault();
    $(this).parent().find('> ul').first().slideToggle();
  });
  
  
  
  //$('.navbar-collapse.collapse').css('max-height', ($(window).height() - $('.siteHeader').height())+'px');
  /*if (isSetMobileMenuColOnce == false) {
    $(window).resize(function() {
      $('.navbar-collapse.collapse').css('max-height', ($(window).height() - $('.siteHeader').height())+'px');
    });
    //isSetMobileMenuColOnce = true;
  }*/
}







/*function showBewertungenInDivElement(curBewertungDiv) {
  $.ajax({
    type: "POST",
    url: "templates/wildkogel/ajax_php/ajaxBewertung.php",
    data: {_art: 'showCmsInfosWindowNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      //var curInhalt = curBoxCountElem.find('.mmTourentippsUebersichtMoreBoxShowInhalt');
      //curInhalt.html(data);
      //$('#vFrontCenterWindowSmallInfoCMSInhalt').html(data);
      //initCmsInfosWindowFunctions();
      $(curBewertungDiv).html(data);

      $('#bewertungShowBtn').click(function() {
        $('#bewertungHolderToggle').toggle();
      });
    },
    error: function() {

    }
  });
}*/







function loadAllTourentippsForFilterAjax(curFilterBtn) {
  $.ajax({
    type: "POST",
    url: "templates/wildkogel/ajax_php/ajaxTourenFilter.php",
    data: {_art: 'showAjaxTourenAllNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      $('.mmTourentippsUebersichtElementBottomAjax .row').html(data);
      areTourentippsLoaded = true;
      setCurentFilterForTourentippsAjax(curFilterBtn);
    },
    error: function() {
      
    }
  });
}



function setCurentFilterForTourentippsAjax(curFilterBtn) {
  $('.mmTourentippsUebersichtElementBottomAjax').isotope({
    itemSelector: '.mmPauschalenUebersichtElementSpalte',
    layoutMode: 'fitRows'
  });
  
  var filterSet = '';
  var allActiveBtns = $('.mmPauschalenUebersichtElementTopKategorienBtn.isActiveFilterBtn');
  $.each(allActiveBtns, function() {
    if (filterSet == '') {
      filterSet = '.mmPauschalenUebersichtElementSpalteId-'+$(this).attr('data-id');
    }
    else {
      filterSet += ', .mmPauschalenUebersichtElementSpalteId-'+$(this).attr('data-id');
    }
  });
  
  if (filterSet == '') {
    $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').click();
  }
  
  $('.mmTourentippsUebersichtElementBottomAjax').isotope({ filter: filterSet });
  
  //$('.mmTourentippsUebersichtElementBottomAjax').isotope({ filter: '.mmPauschalenUebersichtElementSpalteId-'+curFilterBtn.attr('data-id') });
}







function showBewertungenInLightboxNow() {
  $.fancybox({
    //'scrolling'         : 'no',
    'padding'           : 10,
    'centerOnScroll'    : true,
    'href'              : 'templates/wildkogel/ajax_php/ajaxBewertung.php',
    'type'              : 'ajax'
 });
  
  /*$.ajax({
    type: "POST",
    url: "templates/wildkogel/ajax_php/ajaxBewertung.php",
    data: {_art: 'showCmsInfosWindowNow', VCMS_POST_LANG: $('body').attr('data-lang')},
    success: function(data) {
      //var curInhalt = curBoxCountElem.find('.mmTourentippsUebersichtMoreBoxShowInhalt');
      //curInhalt.html(data);
      //$('#vFrontCenterWindowSmallInfoCMSInhalt').html(data);
      //initCmsInfosWindowFunctions();
      $(curBewertungDiv).html(data);

      $('#bewertungShowBtn').click(function() {
        $('#bewertungHolderToggle').toggle();
      });
    },
    error: function() {

    }
  });*/
}





function setCurentFilterSetAllActive() {
  var filterSet = '';
  var allActiveBtns = $('.mmPauschalenUebersichtElementTopKategorienBtn.isActiveFilterBtn');
  $.each(allActiveBtns, function() {
    if (filterSet == '') {
      filterSet = '.mmPauschalenUebersichtElementSpalteId-'+$(this).attr('data-id');
    }
    else {
      filterSet += ', .mmPauschalenUebersichtElementSpalteId-'+$(this).attr('data-id');
    }
  });
  
  if (filterSet == '') {
    $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').click();
  }
  
  $('.mmPauschalenUebersichtElementBottomWithFilter').isotope({ filter: filterSet });
}