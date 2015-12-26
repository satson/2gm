if($('body').data('https') == 'on'){
    var uri = 'https://wildkogel-arena.at/';
}else{
   var uri = 'http://wildkogel-arena.at/'; 
}


 


function orderTabs(){
    $('.order-content').slideUp();
    
    $('.tab-orders').click(function(){
       $(this).next().slideToggle();
       $(this).slideDown('slow');
    })
    
}

function showOrderAdminWindow(){
 
   var error = '';
   
  
     
     var abstandLeft = ($(window).width() / 2) - (1020 / 2);
  $('#vFrontCenterWindowBig').css('left', abstandLeft + 'px');
  
  $('#vFrontCenterWindowBigInhalt').html('');
  $('#vFrontCenterWindowBigInhalt').html('<div class="vFrontWinLoaderBlack"><img src="admin/frontAdmin/img/loader_black.gif" alt="lade..." title="" /><br /><br />wird geladen...</div>');
  $('#vFrontCenterWindowBigHeadInhalt').html('Order menager');
  $('#vFrontOverlay').show();
  $('#vFrontCenterWindowBig').css('z-index','1500')
  $('#vFrontCenterWindowBig').show();

       
         $.ajax({
           type: "POST",
           url: uri+"admin/frontAdmin/ajax_php/ajax.php",
           data: {_art: 'showOrderWindow', VCMS_POST_LANG: $('body').attr('data-lang')}, 
           success: function(data) {
             hideCmsIsLoading();
             $('#vFrontCenterWindowBigInhalt').html(data);
             
             initOrderFunctions();
          
           },
           error: function() {
             showAjaxFehler();
           }
       })

 
}

function initOrderFunctions(){
    orderTabs(); 
    deleteFileInOrder()
    zipFiles();
    filtrOrders();
    searchOrders();
     $('.vFrontVerwPicElemShow').click(function() {
    $.fancybox({
      href : $(this).attr('data-img')
    });
  });
    
    
}


function deleteFileInOrder(){
    
    $('.order-element-delete').unbind().bind('click',function(e){
        
        var checkerDel = confirm('Möchten Sie die bild löschen?');
       if (checkerDel == true) {
          e.preventDefault();
        
        var $this = $(this);
        var id = $this.data('id');
        var idFile = $this.data('idfile');
        var idOrder = $this.data('idorder');
        
         $.ajax({
           type: "POST",
           url: uri+"admin/frontAdmin/ajax_php/ajax.php",
           data: {_art: 'deleteFileInOrder', VCMS_POST_LANG: $('body').attr('data-lang'),id:id,id_file:idFile,id_order:idOrder}, 
           success: function(data) {
             hideCmsIsLoading();
            
            if(data == 'ok'){
               $this.parent().attr("style", "background-color: red !important;" );
               $this.parent().slideUp('slow');;
               showOkWindowNow('Die bilde wurde erfolgreich gelöscht!'); 
            }
            
          
           },
           error: function() {
             showAjaxFehler();
           }
       })
        
     
         
        }
    })
    
    
}

function zipFiles(){
        console.log('sd');
    $('.zipFiles').click(function(e){
        
        var $this = $(this);
        var id    = $this.data('idorder');
        var email = $('#email-'+id).val();
        var days  = $('#days-'+id).val();  
        var comment=$('#comment-'+id).val();

        if( IsEmail(email)){
           var checkerDel = confirm('Möchten Sie die bild löschen?');
          if (checkerDel == true) {
          e.preventDefault();
        
          $.ajax({
           type: "POST",
           url: uri+"admin/frontAdmin/ajax_php/ajax.php",
           data: {_art: 'zipFiles', VCMS_POST_LANG: $('body').attr('data-lang'),id:id,email:email,days:days,comment:comment}, 
           success: function(data) {
             hideCmsIsLoading();
             $('#order-'+id).next().slideUp('slow');
             $('#order-'+id).removeClass('tab-order-color1');
             $('#order-'+id).addClass('tab-order-color2');
             $('#status-'+id).text('[sended]');
             
           },
           error: function() {
             showAjaxFehler();
           }
          })

          e.stopPropagation();
          } 
            
        }else{
            showErrorWindowNow('email error');
        }
   
        
    })
    
    
}

function searchOrders(){
    
     $('#searchTextButton').click(function(e){
        e.preventDefault();
        var search = $('#searchText').val();
       $.ajax({
           type: "POST",
           url: uri+"admin/frontAdmin/ajax_php/ajax.php",
           data: {_art: 'getOrdersByWord', VCMS_POST_LANG: $('body').attr('data-lang'),search:search}, 
           success: function(data) {
             hideCmsIsLoading();
             $('#ordersList').html(data);
                initOrderFunctions();
             
           },
           error: function() {
             showAjaxFehler();
           }
          }) 
        
        
    })
}

function filtrOrders(){
    
    $('#ordersStatus').change(function(){
        
       $.ajax({
           type: "POST",
           url: uri+"admin/frontAdmin/ajax_php/ajax.php",
           data: {_art: 'getOrdersByStatus', VCMS_POST_LANG: $('body').attr('data-lang'),status:$(this).val()}, 
           success: function(data) {
             hideCmsIsLoading();
             $('#ordersList').html(data);
                initOrderFunctions();
             
           },
           error: function() {
             showAjaxFehler();
           }
          }) 
        
        
    })
    
}

function IsEmail(email) {
  var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email);
}


///////////////////////////////front function//////////////////////



function addItem(){
  
 $(document).on('click','.addItem',function(){
    
  // $('.addItem').click(function(){   
        
        var $this  = $(this);
        var type   = $(this).data('type');
        var siteId = $(this).data('siteid');
        var fileId = $(this).data('fileid');
        var dropId = $(this).data('dropid');
        var target = $(this).data('target');
        
        
        $.ajax({
           type: "POST",
           url: uri+"inc/ajaxOrder/ajaxorder.php",
           data: {_art: 'addItem', VCMS_POST_LANG: $('body').attr('data-lang'),target:target,dropid:dropId,fileId:fileId,type:type,siteid:siteId}, 
           success: function(data) {
          
           $('.merklisteNumber').text('('+data+')');
           },
           error: function() {
             showAjaxFehler();
           }
          }) 
    })
    
}

addItem();


function setDrpDownBasketData(){
  
 $.each($('.dropdownContent'),function(i,v){
      console.log(v);
     
    var button = $(v).find('div.basketButton');
    if(button.length){
      var dropId = $(v).data('dropid');  
      button.attr('data-dropid',dropId);
      button.attr('data-type','dropdown');
    } 
  
 })   
 
}

setDrpDownBasketData();


////////////delete item in basket////////////
function deleteItemBasket(){

    $('.loschen').click(function(){
        var id=$(this).data('idsite');
        var itemkey = $(this).data('itemkey');
        
         $.ajax({
           type: "POST",
           url: uri+"inc/ajaxOrder/ajaxorder.php",
           data: {_art: 'deleteItem', VCMS_POST_LANG: $('body').attr('data-lang'),itemkey:itemkey,siteid:id}, 
           success: function(data) {
             
             var parent =  $('#'+itemkey).parent();
               
               $('#'+itemkey).remove();
               
              
               
               if($(parent).children().length == 1){
                   $(parent).remove();
               }
                $('.merklisteNumber').text('('+data+')');
               
           },
           error: function() {
             showAjaxFehler();
           }
          }) 
        
    });
 
 
}


///////list item in basket//////////////////

function listBasket(){
    $('.heartTop').click(function(e){
      e.preventDefault();
      
      var logo = $(this).data('logo');
      
      $.ajax({
           type: "POST",
           url: uri+"inc/ajaxOrder/ajaxorder.php",
           data: {_art: 'listOrderItems', VCMS_POST_LANG: $('body').attr('data-lang')}, 
           success: function(data) {
            
            var items = $.parseJSON(data);
               
            $('.merklisteItems').html(items.html);
            $('.merklisteFilters').html(items.filtr);
            
          
           
            filtrBasket();
           
            deleteItemBasket();
            
             $('.kommentar').click(function(){

            $(this).parent().parent().next('.itemContentLower').toggle('slow');
   });
   
   $('.popupMerkliste').css('min-height', $(document).height());
   
     $('.popupMerkliste .popupClose').click(function(){
      $('.popupMerkliste').fadeOut();
   });
   
   $('body').on('click','.secondMerklisteItemLink',function(e){
    
      e.preventDefault();
      $(this).parent().next().slideToggle('slow');
   })
   
  
  $('#friendForm,#friendForm1').click(function(e){
      e.preventDefault();
       
      
      var url = $(this).data('url');
      var l = $('.comment').length;
      
      var n;
      n=0;
      $.each($('.comment'),function(i,v){
       
          var itemkey = $(v).data('itemkey');
          var comment = $('#note-'+itemkey).val();
       
            $.ajax({
                 type: "POST",
                 url: uri+"inc/ajaxOrder/ajaxorder.php",
                 data: {_art: 'setCommentToItem', itemKey:itemkey,comment:comment}, 
                 success: function(data) {
                            
                   
                 },
                 error: function() {
                   //showAjaxFehler();
                 }
                }).done(function(){
                    if(n==l){
                        setTimeout(function () {
                     window.location = url; 
                 }, 1000);
                        
                       
                     }  
                }) ; 
                
            n++;       
          
      });
      
  
      
  })
  
   
   $('.kommentarBoxClose').click(function(){
      $(this).parent().slideUp('slow');
      
      
      
      
   });
            
           },
           error: function() {
             showAjaxFehler();
           }
          })
      
      
      $('.popupMerkliste').fadeIn();
      
       $('html, body').animate({
        scrollTop: $(".popupClose").offset().top
    }, 1);
      
   });   
}



listBasket();


function filtrBasket(){
    
    $('.filterTabs').click(function(){
        
        var tab = $(this).data('tabid');
        
        
        
        if(tab == 'all'){
             $('.merklisteItem').show();  
        }else{
          $('.merklisteItem').hide();  
          $('#tab-'+tab).show(); 
        }
        
        
    })
    
}


