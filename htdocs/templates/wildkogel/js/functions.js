if($('body').data('https') == 'on'){
    var uri = 'https://wildkogel-arena.at/';
}else{
   var uri = 'http://wildkogel-arena.at/'; 
}

function initInfoPanelNav() {
   if (viewport().width < 768) {
      $('.bigDropdown .bigInfoPanelInner').each(function () {
         if (!$(this).find('.infoNav').length) {
            var infoNav = $('<div class="infoNav">');
            infoNav.append($('<span class="infoNavLeft">')).append($('<span class="infoNavRight">'));
            $(this).append(infoNav);
            $(this).find('.infoPanelLeft').show();
            $(this).find('.infoPanelRight').hide();
            $(this).find('.infoNav .infoNavLeft').addClass('active');
            $(this).find('.infoNav .infoNavRight').removeClass('active');
         }
         $(this).find('.infoPanelTab').hide().first().addClass('active');
      });
   } else {
      $('.bigDropdown .bigInfoPanelInner').each(function () {
         if ($(this).find('.infoNav').length) {
            $(this).find('.infoNav').remove();
            $(this).find('.infoPanelLeft').show();
            $(this).find('.infoPanelRight').show();
         }
         $(this).find('.infoPanelTab').hide().first().addClass('active').show();
      });
   }
   $('.multiInfoPanel .infoPanelCategory:first-child').addClass('active');

   $('.infoNavRight').click(function () {
      if (!$(this).hasClass('active')) {
         $(this).parent().parent().find('.infoPanelLeft').hide();
         if ($(this).parent().parent().parent().hasClass('multiInfoPanel')) {
            $(this).parent().parent().find('.infoPanelRight.active').show();
         } else {
            $(this).parent().parent().find('.infoPanelRight').show();
         }
         $(this).addClass('active');
         $(this).parent().find('.infoNavLeft').removeClass('active');
      }
   });
   $('.infoNavLeft').click(function () {
      if (!$(this).hasClass('active')) {
         $(this).parent().parent().find('.infoPanelLeft').show();
         $(this).parent().parent().find('.infoPanelRight').hide();
         $(this).addClass('active');
         $(this).parent().find('.infoNavRight').removeClass('active');
      }
   });
   $(".bigInfoPanel").on("swipeleft", function () {
      if ($(this).find('.bigInfoPanelInner').find('.infoNav').length) {
         $(this).find('.bigInfoPanelInner').find('.infoPanelLeft').hide();
         if ($(this).hasClass('multiInfoPanel')) {
            $(this).find('.bigInfoPanelInner').find('.infoPanelRight.active').show();
         } else {
            $(this).find('.bigInfoPanelInner').find('.infoPanelRight').show();
         }
         $(this).find('.bigInfoPanelInner').find('.infoNav').find('.infoNavLeft').removeClass('active');
         $(this).find('.bigInfoPanelInner').find('.infoNav').find('.infoNavRight').addClass('active');
      }
   });

   $(".bigInfoPanel").on("swiperight", function () {
      if ($(this).find('.bigInfoPanelInner').find('.infoNav').length) {
         $(this).find('.bigInfoPanelInner').find('.infoPanelLeft').show();
         $(this).find('.bigInfoPanelInner').find('.infoPanelRight').hide();
         $(this).find('.bigInfoPanelInner').find('.infoNav').find('.infoNavLeft').addClass('active');
         $(this).find('.bigInfoPanelInner').find('.infoNav').find('.infoNavRight').removeClass('active');
      }
   });

   $('.multiInfoPanel .infoPanelCategory').click(function () {
      var targetTab = $(this).data('target-tab');
      $(this).parent().parent().parent().parent().find('.infoPanelTab').hide().removeClass('active');
      $(targetTab).show().addClass('active');
      $(this).parent().find('.infoPanelCategory').removeClass('active');
      $(this).addClass('active');
      if ($(this).parent().parent().parent().find('.infoNav').length) {
         $(this).parent().parent().parent().find('.infoPanelLeft').hide();
         $(this).parent().parent().parent().find('.infoNav').find('.infoNavRight').addClass('active');
         $(this).parent().parent().parent().find('.infoNav').find('.infoNavLeft').removeClass('active');
      }
   });
}

function setHeaderSize() {
   var windowWidth = viewport().width;

   var topHeight = $('.top').height();
   var windowHeight = $(window).height();
   var availableHeight = windowHeight - topHeight;
 
   if (windowWidth > 767) {
      $('.bigHeader').height(availableHeight);
      var maxImgHeight = 0.5 * availableHeight;
   } else {
      $('.bigHeader').height(availableHeight / 2);
   }

   /*
    var logoRatio = ($('.logo img').width() / $('.logo img').height());
    console.log('logo ratio ' + logoRatio);
    
    var logoTopMargin = availableHeight * 0.1;
    var logoHeight = availableHeight * 0.5;
    var logoWidth = logoHeight * logoRatio;
    
    
    /*
    $('.logo').height(logoHeight);
    $('.logo').width(logoWidth);
    $('.logo').css({
    marginTop: logoTopMargin + 'px' 
    });
    */
}

$.preloadImages = function () {
   for (var i = 0; i < arguments.length; i++) {
      $("<img />").attr("src", arguments[i]);
   }
};

$(document).ready(function () {
    
     $('input:first').focus();
    
    $('.iconSearch').click(function(){
       
      $('#searchInput').animate({width:'toggle'},350);
    //  $('#searchInput').focus(); 
      
    })
    
 
    
  $('.subscribeButton').click(function(e){
        e.preventDefault();
        var email = $('.subscriber').val();
        var name = $('.name').val();
        var surname = $('.surname').val();
        var group   = $('.group').serializeArray();
     
        if(validateEmail(email)){
             $.ajax({
                type: "POST",
                url: "https://wildkogel-arena.at/templates/wildkogel/ajax_php/subscribe.php",
                data: {_art: 'subscribe', _email:email,name:name,surname:surname,group:group},
                success: function (data) {
                   $('.widgetResponse').text(data);
                   $('.widgetResponse').fadeIn();
                },
                error: function () {
                   showAjaxFehler();
                }
           });
        }else{
           $('.widgetResponse').text('E-Mail ist falsch!'); 
           $('.widgetResponse').fadeIn();
            
        }
        
        
    })
    
    $('.addItem').on('click', function () {
        var cart = $('.heartTop img');
        var imgtodrag = $(this).find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
    });
 
    
   $('.buttonTab').click(function(){
       $('.buttonTab').removeClass('active');
       $(this).addClass('active');
      $('.contentTab').hide();
       var target = $(this).data('target');;
       
       $(target).show();
       
   })
     $('.buttonTab').eq(0).trigger('click');
    if($('.moreLink').length){
  var more =  $('.moreLink').html();
  
  
     $('.moreLink').remove(); 
   $('#gastro').append('<div class="moreLink" id="more">'+more+'</div>');
  $('.moreLink').show();  
      
  }
  
   
  
    var r = $(".breadcrumbs > span").toArray();
    $(".breadcrumbs").html()
    $.each(r,function(i,v){
        
      $(".breadcrumbs").prepend(v) ;
        
    })
    
  

   $('.galleryPackage').click(function () {
      var a = $(this).next('a:first').trigger('click');
   });

   $('#more').click(function () {
      $(this).hide();
      $('.boxItem').show();
   })

   $('.galleryIcon').click(function () {
      $(this).parent().next().trigger('click');
   })

   $('.filtrCheckbox').click(function () {
      var id = $(this).val();
      var j = 0;

      $('.boxItem').hide();
      $.each($('.filtrCheckbox:checked'), function (i, v) {

         $('.filtr-' + id).show();
         j++;
         $('#more').hide();

      });

      if (j == 0) {
         $('.boxItem').show();
      }
   })

   initInfoPanelNav();

   $.preloadImages(
           "templates/wildkogel/img/ico-infocall-rot.png",
           "templates/wildkogel/img/ico-rodel-rot.png",
           "templates/wildkogel/img/ico-gondel-rot.png",
           "templates/wildkogel/img/ico-wetter-rot.png",
           "templates/wildkogel/img/ico-livecam-rot.png",
           "templates/wildkogel/img/ico-information-rot.png",
           "templates/wildkogel/img/ico-sleep-rot.png",
           "templates/wildkogel/img/ico-search-rot.png",
           "templates/wildkogel/img/menu-selector-rot.png"
           );

   $('.startHidden').hide();

   $('.tooltipster').tooltipster({
      position: 'bottom',
      trigger: 'hover'
   });

   $('.tooltipster-top').tooltipster({
      position: 'top',
      trigger: 'hover'
   });

   $('.newsInfoPanelInner').each(function () {
      if (!$(this).find('.infoPanelHeader .infoPanelCategory').length) {
         $(this).find('.infoPanelNews').css({borderTop: 'none'});
      }
   });

   setHeaderSize();

   $('.v_siteUnterMenu1 > li.menuPoint').addClass('unchecked');
   $('.filterMenu + .verticalMenu .v_siteUnterMenu > li.menuPoint').addClass('contracted');

   $('.filterMenu + .verticalMenu ul.v_siteUnterMenu > li.menuPoint').click(function () {
      if ($(this).hasClass('contracted')) {
         $(this).removeClass('contracted');
         $(this).addClass('expanded');
         $(this).find('ul').slideDown('slow');
      } else {
         $(this).addClass('contracted');
         $(this).removeClass('expanded');
         $(this).find('ul').slideUp('slow');
      }
   });

   $('.v_siteUnterMenu1 > li.menuPoint').click(function (e) {
      e.stopPropagation();
      if ($(this).hasClass('unchecked')) {
         $(this).removeClass('unchecked');
         $(this).addClass('checked');
         $(this).find('input').attr('checked', 'checked');


      } else {
         $(this).addClass('unchecked');
         $(this).removeClass('checked');
         $(this).find('input').removeAttr('checked');

      }


      var filterItems;
      var n;
      $.each($('li.checked'), function (i, v) {

         n = n + 1;
         if (n == 1) {
            filterItems = $(v).data('id');
         } else {
            filterItems = ';' + $(v).data('id');
         }
         n++;
      });



      $.ajax({
         type: "POST",
         url: uri+"admin/frontAdmin/ajax_php/ajax.php",
         data: {_art: 'getProductsByFilter', _filters: filterItems},
         success: function (data) {
            $('#productsItem').html(data)
            $('.quickInfoBox').hide();
         },
         error: function () {
            showAjaxFehler();
         }
      });

   });

   $('.firstMerklisteItemLink').click(function (e) {
      e.preventDefault();
      $(this).parent().next('kommentarBox').slideToggle('slow');
   });

   $('.kommentarBoxClose').click(function () {
      $(this).parent().slideUp('slow');
   });

   $('.interesse ul li').addClass('unchecked');
   $('.interesse ul li').click(function (e) {
      e.stopPropagation();
      if ($(this).hasClass('unchecked')) {
         $(this).removeClass('unchecked');
         $(this).addClass('checked');
         // $(this).find('input').attr('checked', 'checked');
      } else {
         $(this).addClass('unchecked');
         $(this).removeClass('checked');
       

      }
   });

   $('.itemContentLower').hide();

   /* Fine buttons */
   $('.homeFindeToggle').click(function () {
      $(this).toggleClass('toggled');
      $(this).parent().find('.homeFindeButton.startHidden').toggle();
   });

   /* Panel dropdowns */
   $('.opensDropdown').click(function () {
      var target = $(this).data('target');
      $('.panelDropdown.opened').not(target).slideUp('slow').removeClass('opened');

      if (viewport().width < 768) {
         //transplant the target
         var transplant = $(target).detach();
         $(this).after(transplant);
      }

      if ($(target).hasClass('opened')) {
         $(target).slideUp('slow');
         $(target).removeClass('opened');
      } else {
         $(target).slideDown('slow', function () {
            var scrollPosition = $(target).offset().top - $('.top').height() - 15;
            console.log(scrollPosition);
            $("html, body").animate({
               scrollTop: scrollPosition
            }, 500);
         });
         $(target).addClass('opened');
      }
   });

   $('.panelDropdownClose').click(function () {
      $(this).parent().slideUp('slow');
   });

   $('.opensBigDropdown').click(function () {
      var target = $(this).data('target');
      $('.bigDropdown.opened').not(target).slideUp('slow').removeClass('opened');

      if (viewport().width < 768) {
         //transplant the target
         var transplant = $(target).detach();
         $(this).after(transplant);
      }

      if ($(target).hasClass('opened')) {
         $(target).slideUp('slow');
         $(target).removeClass('opened');
      } else {
         $(target).slideDown('slow', function () {
            var scrollPosition = $(target).offset().top - $('.top').height() - 15;
            console.log(scrollPosition);
            $("html, body").animate({
               scrollTop: scrollPosition
            }, 500);
         });
         $(target).addClass('opened');
      }
   });

   $('.bigDropdownClose').click(function () {
      $(this).parent().slideUp('slow');
   });

   $('.popupMerkliste .popupClose').click(function () {
      $('.popupMerkliste').fadeOut();
   });

   $('.popupMerkliste').css('min-height', $(document).height());

   $('.filtersSelector').click(function () {
      var lang = $('body').data('lang'); 
       if(lang == 'de'){
          $(this).html('<h2>Filter zurücksetzen</h2>')  
        }else if(lang == 'en'){
          $(this).html('<h2>Reset filter</h2>')  
        } 
      var selector = $(this);
      if ($(this).hasClass('contracted')) {
         
         
         $(this).animate({
            marginBottom: '0px'
         }, 'slow');
      } else {
         $(this).html('<h2>Filtern Sie Ihre Bedürfnisse</h2>')
         $(this).animate({
            marginBottom: '60px'
         }, 'slow');
      }
      $(this).toggleClass('contracted');
      $('.filtersForm').slideToggle('slow');
          
      $('.filtrCheckbox').removeAttr('checked');
      $('.boxItem').show();
      $('.filterHeader').removeClass('expanded');
      $('.filterControls').attr('style','display:none'); 
     

   });

   $('.filterHeader').click(function () {
      $(this).toggleClass('expanded');
      $(this).next('.filterControls').slideToggle('slow');
   });

//function getProducts(filterItems){

//}



   $('.pagination').click(function () {
      var id = $(this).data('id');
      $('.pagination').removeClass('active');
      $(this).addClass('active');
      $('.galleryImages').hide();
      $('#site-' + id).show();
   })
   //Set big header background
   $('.giveMeBackground').each(function () {
      var bgSrc = $(this).find('.hereIsYourBackgroud').attr('src');
      $(this).css({'backgroundImage': 'url(' + bgSrc + ')'});
   });
   $('a').click(function (e) {
      var target = $(this.hash);
      if (target.length) {
         e.preventDefault();
         var offset = 0;
         if ($(window).width() > 767) {
            offset = 75;
         }
         var targetPosition = target.offset().top - offset;
         $('html, body').animate({
            scrollTop: targetPosition
         }, 1000);
      }
   });

   //Carousels
   //header
   $('.vSiteElemBoxInhalt .clearer').remove();

   $('#headerCarousel .vSiteElemBoxInhalt').addClass('owl-carousel').owlCarousel({
      navigation: true,
      items: 4,
      itemsDesktop: [1350, 2],
      itemsDesktopSmall: [979, 1],
      itemsTablet: [768, 1],
      itemsMobile: [600, 1]
   });

   $('#logos').owlCarousel({
      navigation: true,
      items: 6,
      itemsDesktop: [1365, 3],
      itemsDesktopSmall: [979, 2],
      itemsTablet: [768, 1],
      itemsMobile: [600, 1]
   });

   //Icon boxes carousel

   $('.siteTopIcons .vSiteElemBoxInhalt').addClass('owl-carousel').owlCarousel({
      navigation: true,
      items: 6,
      itemsDesktop: [1350, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [768, 2],
      itemsMobile: [600, 1]
   });

   $('.languageButton').click(function () {
      $('.languageList').toggle();
   });
   $('.bigHeader, .standardHeader').mousemove(function () {
      $('.languageList').hide();
   });

   $('.footerDropdownButton').click(function () {
      $('.siteFooterBottomRow').slideToggle('slow');
      if ($(this).hasClass('contracted')) {
         $(this).removeClass('contracted').addClass('expanded');
      } else if ($(this).hasClass('expanded')) {
         $(this).removeClass('expanded').addClass('contracted');
      }
      var scrollPosition = $(this).offset().top - 15;
      //console.log(scrollPosition);
      $("html, body").animate({
         scrollTop: scrollPosition
      }, 500);
   });
   $(window).scroll(function () {
      animateHeader();
      setHeaderSize();
      //positionToTopButton();
   });
   $(window).resize(function () {
      //positionToTopButton();
      //initializeCarousel();
      setHeaderSize();
      initInfoPanelNav();
      animateHeader();
      $('#navbar').css({left: viewport().width + 100 + 'px'}).hide();
   });

   $('#navbar').css({left: viewport().width + 100 + 'px'}).hide();

   //show menu on subpages
   if (viewport().width > 1189) {
      if ($('#navbar').find('.active').length > 0) {
         $('#navbar').show().css({left: '230px'});
      }
   }

   $('.menuToggle').click(function () {
      if (viewport().width > 1189) {
         $('#navbar').show().animate({left: '230px'}, 500);
      } else {
         $('#navbar').slideToggle('slow');
      }
   });

   $('.topMenuClose').click(function () {
      if (viewport().width > 1189) {
         $('#navbar').animate({left: viewport().width + 50 + 'px'}, 500, function () {
            $('#navbar').hide();
         });
      } else {
         $('#navbar').slideUp('slow');
      }
   });

   $('.cookieClose').click(function () {
      $('.cookieMessage').fadeOut();
   });

   /* dropdowns */
   $('.dropdownContent').hide();
   $('.dropdownButton').addClass('contracted');

   $('.dropdownButton').click(function () {
      //console.log('click');
      if ($(this).hasClass('expanded')) {
         $(this).removeClass('expanded').addClass('contracted');
         $(this).next('.dropdownContent').slideUp('slow');
      } else if ($(this).hasClass('contracted')) {
         var button = $(this);
         //console.log('position: ' + button.offset().top);
         $('.dropdownButton').removeClass('expanded').addClass('contracted');
         $('.dropdownContent').slideUp('slow');
         $(this).removeClass('contracted').addClass('expanded');
         $(this).next('.dropdownContent').slideDown('slow', function () {
            var scrollPosition = button.offset().top - $('.top').height() - 15;
            //console.log(scrollPosition);
            $("html, body").animate({
               scrollTop: scrollPosition
            }, 500);
            initProductBoxes();
         });
      }

   });

   /* Product Boxes */
   $('.productBoxTop img').mouseenter(function () {
      $(this).prev('span').fadeIn('fast');
   }).mouseleave(function () {
      $(this).prev('span').fadeOut('fast');
   });

   $('.quickInfoBox').hide();

   $('.productBoxButtons .productBoxButton:first-child a').click(function (e) {
      e.preventDefault();
      var targetId = $(this).data('id');
      //console.log(targetId);
      var quickInfoBox = $('#' + targetId);
      var parentId = $(this).data('parent');
      var parent = $('#' + parentId);
      $('.productBox').removeClass('current');
      parent.addClass('current');
      var container = parent.parent();
      //console.log(container);
      var targetBox = $('#' + targetId);
      //console.log(targetBox);
      $('.quickInfoBox.appended').remove();
      var quickInfoBox = $('<div>').addClass('quickInfoBox appended');
      if (container.hasClass('lastInRow')) {
         lastInRow = container;
      } else {
         lastInRow = container.nextAll('.lastInRow').first();
      }
      //console.log(lastInRow);
      quickInfoBox.html(targetBox.html());
      lastInRow.after(quickInfoBox);
      initializeCarousel();
      var scrollPosition = quickInfoBox.offset().top - $('.top').height() - 35;
      //console.log(scrollPosition);
      $("html, body").animate({
         scrollTop: scrollPosition
      }, 500);
   });

   $('.mobileMenuSelector').click(function () {
      $('#navbar').slideToggle('slow');
   });
   $('.navbarClose').click(function () {
      $('#navbar').slideUp('slow');
   });

   setOrderForm();

});


function setOrderForm() {

   var order;
   var request;

   $('.vCmsKontaktformLiveContainerCount4').hide();
   $('.vCmsKontaktformLiveContainerCount5').hide();
   $('#Newsletter').prop('checked', true);

   $('#Anrede').change(function () {
      if ($(this).val() == 'firma') {
         $('label[for=Firma],#Firma').show();
      } else {
         $("label[for='Firma'],#Firma").hide();
      }
   }).change();

   if (targets.length) {
      $.each(targets, function (i, v) {

         if (v == 'order') {
            $('.vCmsKontaktformLiveContainerCount4').show();
         }

         if (v == 'request') {
            $('.vCmsKontaktformLiveContainerCount5').show();
         }


      })
   }
}

function initProductBoxes() {
   var inRow = getNumberOfProductBoxesInRow();
   markLastInRow(inRow);
   $('.quickInfoBox.appended').remove();
   $('.productBox').removeClass('current');
}

function initializeCarousel() {
   if (viewport().width < 1280) {
      $('.quickInfoLinks').width($('.quickInfoBox.appended').width());
      $('.quickInfoBox.appended .quickInfoLinkCarousel').addClass('owl-carousel').owlCarousel({
         navigation: true,
         items: 6,
         itemsDesktop: [1199, 6],
         itemsDesktopSmall: [979, 6],
         itemsTablet: [768, 3],
         itemsMobile: [600, 1]
      });
   } else {
      if ($('.quickInfoBox.appended .quickInfoLinkCarousel.owl-carousel').length) {
         console.log('there is a carousel');
         var owl = $(".quickInfoLinkCarousel.owl-carousel").data('owlCarousel');
         owl.destroy();
         $('.quickInfoLinkCarousel').removeClass('owl-carousel');
      } else {
         console.log('there is no carousel');
      }
   }
}

function getNumberOfProductBoxesInRow() {
   var gridWidth = $('.productsGrid').width();
   console.log('grid width: ' + gridWidth);
   var gridItemWidth = $('.productGridItem').first().outerWidth(true);
   console.log('grid item width: ' + gridItemWidth);
   var inRow = Math.floor(gridWidth / gridItemWidth);
   console.log('items in a row: ' + inRow);
   return inRow;
}

function markLastInRow(inRow) {
   $('.productGridItem').removeClass('lastInRow');
   $('.productGridItem').each(function (index) {
      var last = (index + 1) % inRow;
      if (last === 0) {
         $(this).addClass('lastInRow');
      }
   });
   $('.productGridItem').last().addClass('lastInRow');
}

function positionToTopButton() {
   var footerPosition = $('.siteFooter').offset().top;
   var windowHeight = $(window).height();
   var scrollTop = $(window).scrollTop();
   //console.log('scroll top: ' + scrollTop);
   //console.log('window height: ' + windowHeight);
   var currentBottomButtonPosition = scrollTop + windowHeight - footerPosition + 15;
   if (currentBottomButtonPosition > 0) {
      showToTopButtonAtPosition(currentBottomButtonPosition);
   } else if (scrollTop > (windowHeight - 100)) {
      showToTopButtonAtPosition(15);
   } else {
      hideToTopButton();
   }
}

function showToTopButtonAtPosition(x) {
   $('#siteArrowScrollTopSiteBtn').css('bottom', x + 'px');
   $('#siteArrowScrollTopSiteBtn').fadeIn(500);
}

function hideToTopButton() {
   $('#siteArrowScrollTopSiteBtn').fadeOut(500);
}


var isFixedAnfrageFooterShowed = true;
var areTourentippsLoaded = false;

function viewport() {
   var e = window, a = 'inner';
   if (!('innerWidth' in window)) {
      a = 'client';
      e = document.documentElement || document.body;
   }
   return {width: e[ a + 'Width' ], height: e[ a + 'Height' ]};
}

function animateHeader() {
   if (viewport().width > 1189) {
      if ($(window).scrollTop() > 20) {
         if (!$('.top').hasClass('isContracted')) {
            $('.top').addClass('isContracted');
            $('#logoImg').stop().animate({
               height: '105px',
               top: '5px'
            }, 300);
            $('#logoBand').stop().animate({
               top: '-410px'
            }, 300);
         }
      } else {
         $('.top').removeClass('isContracted');
         $('#logoImg').stop().animate({
            height: '138px',
            top: '73px'
         }, 300);
         $('#logoBand').stop().animate({
            top: '0'
         }, 300);
      }
   } else {
      $('#logoImg').removeAttr("style");
      $('#logoBand').removeAttr("style");
   }
}


$(document).ready(function () {

   if ($('body.vcmsUserLogedIn').length < 1) {
      if ($('.mmBildTextHolderSliderElemUeTourentippMM').length > 0) {
         $('.mmTourentippsDetailElementScrollToTextHolderBtn').html('<i class="fa fa-angle-down"></i>' + $('.mmBildTextHolderSliderElemUeTourentippMM > .vFrontOwnElemTextHolder > .vFrontOwnElemTextInner').html() + '<i class="fa fa-angle-down fa-angle-downLastMM"></i>');
      }


      $('.mmTourentippsDetailElementScrollToTextHolderBtn').click(function () {
         $("html, body").animate({scrollTop: $('.mmBildTextHolderSliderElemUeTourentippMM').offset().top - 150}, 1000);
      });
   }



   // Header Animate
   // ***************************************************************************
   $(window).scroll(function () {
      if ($(window).width() > 1199) {
         if ($(window).scrollTop() > 1) {
            if (!$(".siteHeaderNormal").hasClass('isStateSmallMM')) {
               $(".siteHeaderNormal").addClass('isStateSmallMM');
               $(".siteHeaderNormal").stop().animate({height: '112px'}, 300);
               $('.siteHeaderNormal .siteHeaderInfoHolder').stop().animate({marginTop: '10px', marginBottom: '5px'}, 300);

               $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({fontSize: '18px'}, 300);
               $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({fontSize: '18px'}, 300);
               $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({fontSize: '18px'}, 300);

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
            $('.siteHeaderNormal .siteHeaderInfoHolder').stop().animate({marginTop: '35px', marginBottom: '12px'}, 300);

            $('.siteHeaderNormal .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({fontSize: '20px'}, 300);
            $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({fontSize: '20px'}, 300);
            $('.siteHeaderNormal .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({fontSize: '20px'}, 300);

            $(".siteHeaderNormal").stop().animate({height: '160px'}, 300, function () {
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
   $(window).scroll(function () {
      if ($(window).width() > 1199) {
         if ($(window).scrollTop() > 1) {
            if (!$(".siteHeaderDetail").hasClass('isStateSmallMM')) {
               $(".siteHeaderDetail").addClass('isStateSmallMM');
               $(".siteHeaderDetail").stop().animate({height: '112px'}, 300, function () {
                  $('.siteHeaderDetail .siteHeaderLogoHolderOnScrollShow').show();
               });
               $('.siteHeaderDetail .siteHeaderInfoHolder').stop().animate({marginTop: '10px', marginBottom: '5px'}, 300);

               $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({fontSize: '18px'}, 300);
               $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({fontSize: '18px'}, 300);
               $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({fontSize: '18px'}, 300);

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
            $('.siteHeaderDetail .siteHeaderInfoHolder').stop().animate({marginTop: '35px', marginBottom: '12px'}, 300);

            $('.siteHeaderDetail .siteHeaderMenuHolder .v_siteMenu > .menuPoint > a').stop().animate({fontSize: '20px'}, 300);
            $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderLeft').stop().animate({fontSize: '20px'}, 300);
            $('.siteHeaderDetail .siteHeaderInfoHolder .siteHeaderInfoHolderRight a').stop().animate({fontSize: '20px'}, 300);

            $(".siteHeaderDetail").stop().animate({height: '260px'}, 300, function () {
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
         var randomBackImage = backImages[Math.floor(Math.random() * backImages.length)];
         backImageOnce = randomBackImage;
      }
   }
   backImages = undefined;



   // Big Header Bild Höhe setzen
   // ***************************************************************************
   $('.siteHeaderBigPicHolder').height($(window).height() - $('.siteHeader').height());

   $(window).resize(function () {
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
   $('.siteLeftPos').css('margin-left', '-' + curLeftAbstandSitePosLeft + 'px');
   $('.siteLeftPos').css('padding-left', curLeftAbstandSitePosLeftPadding + 'px');

   $(window).resize(function () {
      var curLeftAbstandSitePosLeft = (($(window).width() - $('.container').first().width()) / 2);
      curLeftAbstandSitePosLeft = curLeftAbstandSitePosLeft + curPositionNumberNew;
      var curLeftAbstandSitePosLeftPadding = curLeftAbstandSitePosLeft - curPositionNumberNew;
      $('.siteLeftPos').css('margin-left', '-' + curLeftAbstandSitePosLeft + 'px');
      $('.siteLeftPos').css('padding-left', curLeftAbstandSitePosLeftPadding + 'px');
   });



   // Auszeichnungen weniger/mehr
   // ***************************************************************************
   $('.mmAuszeichnungenHolderShowHideBtn').click(function () {
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
   $('.mmInfoBoxHolderElementMehrWenigerBtn').click(function () {
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
      $('.mmAuszeichnungenSpaltenElementOwnElemIsLinkPicGalNow').click(function () {
         var curPicGalHolderAuszeichnungen = $(this).parent().find('.mmAuszeichnungenSpaltenElementOwnElemPicGalElems');
         var curPicGalAuszeichnungenFirstImg = curPicGalHolderAuszeichnungen.find('a.ownElemPicGalerieLinkClass').first();
         curPicGalAuszeichnungenFirstImg.click();
      });



      // Info Button Bilder Galerie
      // ***************************************************************************
      $('.mmInfoBoxBtnElementOwnElemIsLinkPicGalNow').click(function () {
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

   $('.mmPauschalenUebersichtElementTopKategorienBtn').click(function () {
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
            $('.mmPauschalenUebersichtElementBottomWithFilter').isotope({filter: '*'});
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

      $('.mmPauschaleDetailElementTopUe').click(function (e) {
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
      $('.mmPauschaleDetailElementBilderHeadBild1').css('width', curWidthHeadPic1 + 'px');

      var curWidthHeadPic2 = ($(window).width() - $('.container').width()) / 2;

      $('.mmPauschaleDetailElementBilderHeadBild2').css('left', 'auto');
      $('.mmPauschaleDetailElementBilderHeadBild2').css('width', curWidthHeadPic2 + 'px');
   }



   // Mobile Scroll Top Button
   // ***************************************************************************
   $('.siteFooterButtonToTopMobileOnly').click(function () {
      $("html, body").animate({scrollTop: 0}, 800);
   });



   // Partner Slide
   // ***************************************************************************
   if ($(window).width() < 992) {
      startSliderOnPartnersBottom();
   }
   else {
      stopSliderOnPartnersBottom();
   }

   $(window).resize(function () {
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

   $(window).resize(function () {
      if ($(window).width() < 768) {
         startSliderOnPauschalenHomeUebersicht();
      }
      else {
         stopSliderOnPauschalenHomeUebersicht();
      }
   });




   $('.navbar-toggle').click(function () {
      if ($(this).hasClass('collapsed')) {
         $('.siteHeaderLogoHolderOnlySmallA').css('visibility', 'hidden');
         $('.siteHeaderLogoHolderOnlySmallImgS').show();
      }
      else {
         window.setTimeout('setSmallHeaderLogoHideTime()', 500);
      }
   });



   if ($(window).width() > 1189) {
      $("#navbar > ul > li > a").unbind("click");
      startSuperfishTopMenuSet();
   }
   else {
      startMobileMenuTopMenuSet();
   }

   $(window).resize(function () {
      if ($(window).width() > 1189) {
         $("#navbar > ul > li > a").unbind("click");
         startSuperfishTopMenuSet();
      } else {
         $('.v_siteMenu').superfish('destroy');
         startMobileMenuTopMenuSet();
      }
   });

   $('.mmSchnellAnfrageElementSiteHomepageFixedCloseBtn').click(function () {
      $('.mmSchnellAnfrageElementSiteHomepageFixed').hide();
      $('.mmSchnellAnfrageElementSiteHomepageFixed').addClass('mmSchnellAnfrageElementSiteHomepageFixedNoShow');
      $('.siteFooter').css('margin-bottom', '0px');
      isFixedAnfrageFooterShowed = false;
      $(window).scroll();
   });



   // Desktop Scroll Top Button
   // ***************************************************************************
   $('#siteArrowScrollTopSiteBtn').click(function () {
      $("html, body").animate({scrollTop: 0}, 800);
   });



   // Bild / Text Slider
   // ***************************************************************************
   if ($('body.vcmsUserLogedIn').length < 1) {
      $(".mmBildTextHolderSliderElem .mmBildTextHolderSliderElemSlides .vContentElemDD").owlCarousel({
         navigation: true,
         slideSpeed: 300,
         paginationSpeed: 400,
         singleItem: false,
         navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
         items: 3,
         itemsDesktop: [2000, 3], //3 items between 2000px and 992px
         itemsDesktopSmall: [1100, 2], // betweem 992px and 767px
         itemsTablet: [767, 1], //1 items between 767 and 0
         itemsMobile: false, // itemsMobile disabled - inherit from itemsTablet option
         afterUpdate: function () {
            window.setTimeout("setBildTextSliderHoverTextPos()", 500);
         },
         afterInit: function () {
            window.setTimeout("setBildTextSliderHoverTextPos()", 500);
         }
      });

      $('.mmBildTextSliderElemOnce').hover(function () {
         $(this).find('.mmBildTextSliderElemOnceText').first().stop().fadeIn(200);
         $(this).find('.mmBildTextSliderElemOnceCurShowIco').first().stop().fadeOut(200);
      },
              function () {
                 $(this).find('.mmBildTextSliderElemOnceText').first().stop().fadeOut(200);
                 $(this).find('.mmBildTextSliderElemOnceCurShowIco').first().stop().fadeIn(200);
              });
   }



   $('.mmTourenMehrLesenBtn').click(function () {
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
         curBoxCountElem.slideDown(500, function () {
            showAsyncTourenList(curClickBtn, curBoxCountElem);
            $("html, body").animate({scrollTop: $(curBoxCountElem).offset().top - 200}, 400);
         });
         curBoxCountElem.addClass('isStateOpenWinNow');
      }
      else {
         var state = 'yes';
         $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').slideUp(500, function () {
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


   $(window).resize(function () {
      if ($('.mmTourenMehrLesenBtn.activeMehrInfoT').length > 0) {
         $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').hide();
         $('.mmTourentippsUebersichtMoreBoxShow.isStateOpenWinNow').removeClass('isStateOpenWinNow');
         $('.mmTourenMehrLesenBtn.activeMehrInfoT').removeClass('activeMehrInfoT');
      }
   });


   $('.mmTourenSchnellInfoBtn').click(function () {
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
   $('.siteFooterTopBewertungenTextMehr').click(function () {
      showBewertungenInLightboxNow();

      /*$('.siteFooterTopBewertungenAusgabeDiv').html('');
       $('.mmSiteTopInfoBoxWhiteBewertungenInhaltCur').html('');
       
       $('.siteFooterTopBewertungenAusgabeDiv').html('<div style="text-align:center; font-size:48px; margin-top:80px"><i class="fa fa-spinner fa-pulse"></i></div>');
       
       showBewertungenInDivElement('.siteFooterTopBewertungenAusgabeDiv');*/
   });



   // CTA bewertungen bei click anzeigen
   // ***************************************************************************
   $('.mmSiteTopInfoBoxWhiteBwBtn').click(function () {
      showBewertungenInLightboxNow();
   });



   // Anfrage Buchen Buttons bewertungen bei click anzeigen
   // ***************************************************************************
   $('.mmAnfrageBuchenBtnsElementBewertungBtnTextS').click(function () {
      showBewertungenInLightboxNow();
   });



   // Drop Down Element
   // ***************************************************************************
   if ($('body.vcmsUserLogedIn').length < 1) {
      if ($('.mmDropDownInhaltElement').length > 0) {
         $('.mmDropDownInhaltElementBtn').click(function () {
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

               CurInhaltElemDropD.slideDown(400, function () {
                  $("html, body").animate({scrollTop: $(CurInhaltElemDropD).offset().top - 200}, 400);
               });
            }
         });
      }
   }



   // Mobile Filter Menü
   // ***************************************************************************
   $('.mmPauschalenUebersichtElementTopKategorienBtnsHolderFilterShowMobile, .siteFixedFilterButtonForMobile').click(function () {
      $('.mmPauschalenUebersichtElementAll .mmPauschalenUebersichtElementTopKategorien .mmPauschalenUebersichtElementTopKategorienBtnsHolder').animate({left: '0%'}, 500);
      $("html, body").animate({scrollTop: $('.mmPauschalenUebersichtElement .mmPauschalenUebersichtElementTop').offset().top + $('.mmPauschalenUebersichtElement .mmPauschalenUebersichtElementTop').height()}, 500);
   });


   $('.mmPauschalenUebersichtElementTopKategorienBtnsHolderCloseMobile').click(function () {
      $('.mmPauschalenUebersichtElementAll .mmPauschalenUebersichtElementTopKategorien .mmPauschalenUebersichtElementTopKategorienBtnsHolder').animate({left: '-85%'}, 500);
   });


if(typeof isFixedAnfrageFooterShowedOnSet !== 'undefined'){
   if (isFixedAnfrageFooterShowedOnSet == false) {
      $('.mmSchnellAnfrageElementSiteHomepageFixedCloseBtn').click();
   } 
}

   

});




function showAsyncTourenList(curClickBtn, curBoxCountElem) {
   var wissensWertesText = curClickBtn.parent().parent().find('.mmTourentippsUebersichtSchnellInfoWin').first().html();

   $.ajax({
      type: "POST",
      url: uri+"templates/wildkogel/ajax_php/ajaxTouren.php",
      data: {_art: 'showCmsInfosWindowNow', VCMS_POST_LANG: $('body').attr('data-lang'), _curSiteId: curClickBtn.attr('data-id'), _textUrl: curClickBtn.attr('data-url'), _wissensWertes: wissensWertesText},
      success: function (data) {
         var curInhalt = curBoxCountElem.find('.mmTourentippsUebersichtMoreBoxShowInhalt');
         curInhalt.html(data);
         //$('#vFrontCenterWindowSmallInfoCMSInhalt').html(data);
         //initCmsInfosWindowFunctions();
      },
      error: function () {

      }
   });
}




function setBildTextSliderHoverTextPos() {
   $('.mmBildTextSliderElemOnce .mmBildTextSliderElemOnceText').show();
   var allBildTextSliderElemsOnce = $('.mmBildTextSliderElemOnce');
   $.each(allBildTextSliderElemsOnce, function () {
      var curTextSliderEl = $(this).find('.mmBildTextSliderElemOnceText .vFrontOwnElemTextInner');
      var curHeightK = ($(this).height() / 2) - (curTextSliderEl.height() / 2);
      curTextSliderEl.css('margin-top', curHeightK + 'px');
   });
   $('.mmBildTextSliderElemOnce .mmBildTextSliderElemOnceText').hide();
}




function startSuperfishTopMenuSet() {
   $('.v_siteMenu').superfish({
      delay: 50,
      cssArrows: false,
      disableHI: false
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
      navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      items: 3,
      itemsDesktop: [2000, 8], //5 items between 2000px and 992px
      itemsDesktopSmall: [992, 5], // betweem 992px and 767px
      itemsTablet: [767, 3], //2 items between 767 and 0
      itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
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
      navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
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



      $('.mmButtonTextElementBtn').click(function () {
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

            curBtnTextElemText.slideDown(500, function () {
               $("html, body").animate({scrollTop: $(curBtnTextElem).offset().top - 200}, 400);
            });
         }
      });
   }
}

var isSetMobileMenuColOnce = false;
function startMobileMenuTopMenuSet() {
   $("#navbar > ul > li > a").unbind("click");

   $('#navbar > ul > li > a').click(function (e) {
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
      success: function (data) {
         $('.mmTourentippsUebersichtElementBottomAjax .row').html(data);
         areTourentippsLoaded = true;
         setCurentFilterForTourentippsAjax(curFilterBtn);
      },
      error: function () {

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
   $.each(allActiveBtns, function () {
      if (filterSet == '') {
         filterSet = '.mmPauschalenUebersichtElementSpalteId-' + $(this).attr('data-id');
      }
      else {
         filterSet += ', .mmPauschalenUebersichtElementSpalteId-' + $(this).attr('data-id');
      }
   });

   if (filterSet == '') {
      $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').click();
   }

   $('.mmTourentippsUebersichtElementBottomAjax').isotope({filter: filterSet});

   //$('.mmTourentippsUebersichtElementBottomAjax').isotope({ filter: '.mmPauschalenUebersichtElementSpalteId-'+curFilterBtn.attr('data-id') });
}







function showBewertungenInLightboxNow() {
   $.fancybox({
      //'scrolling'         : 'no',
      'padding': 10,
      'centerOnScroll': true,
      'href': 'templates/wildkogel/ajax_php/ajaxBewertung.php',
      'type': 'ajax',
      titleShow: 'true',
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
   $.each(allActiveBtns, function () {
      if (filterSet == '') {
         filterSet = '.mmPauschalenUebersichtElementSpalteId-' + $(this).attr('data-id');
      }
      else {
         filterSet += ', .mmPauschalenUebersichtElementSpalteId-' + $(this).attr('data-id');
      }
   });

   if (filterSet == '') {
      $('.mmPauschalenUebersichtElementTopKategorienBtnAlleMM').click();
   }

   $('.mmPauschalenUebersichtElementBottomWithFilter').isotope({filter: filterSet});
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

/////////////////basket button///////////////////

