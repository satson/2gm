$(document).ready(function () {

});

function positionToTopButtons() {
    if ($(window).width() > 991) {
        positionToTopButton();
        $('#siteArrowScrollTopSiteBtnMobile').hide();
    } else {
        positionToTopMobileButton();
        $('#siteArrowScrollTopSiteBtn').hide();
    }
}

function positionToTopButton() {
    var footerPosition = $('footer').offset().top;
    var windowHeight = $(window).height();
    var scrollTop = $(window).scrollTop();
    console.log('scroll top: ' + scrollTop);
    console.log('window height: ' + windowHeight);
    var currentBottomButtonPosition = scrollTop + windowHeight - footerPosition;
    if (currentBottomButtonPosition > 0) {
        showToTopButtonAtPosition(currentBottomButtonPosition);
    } else if (scrollTop > (windowHeight - 100)) {
        showToTopButtonAtPosition(0);
    } else {
        hideToTopButton();
    }
}

function positionToTopMobileButton() {
    if ($(window).scrollTop() > ($(window).height() - 100)) {
        $('#siteArrowScrollTopSiteBtnMobile').fadeIn(500);
    } else {
        $('#siteArrowScrollTopSiteBtnMobile').fadeOut(500);
    }
}

function showToTopButtonAtPosition(x) {
    $('#siteArrowScrollTopSiteBtn').css('bottom', x + 'px');
    $('#siteArrowScrollTopSiteBtn').fadeIn(500);
}

function hideToTopButton() {
    $('#siteArrowScrollTopSiteBtn').fadeOut(500);
}