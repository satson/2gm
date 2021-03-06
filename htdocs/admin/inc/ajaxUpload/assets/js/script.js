




$(document).ready(function() {
	
	

  var ul = $('#vFrontUploadFrm ul');

  $('#vFrontUploadDrop a').click(function(){
    $(this).parent().find('input').click();
  
    console.log(typeFile);
  });
  
  $('input[name=upl]').change(function(){
   
   
  })
  

  // Initialisiert das jQuery File Upload Plugin
  $('#vFrontUploadFrm').fileupload({

    // Drag and Drop Upload aktivieren
    dropZone: $('#vFrontUploadDrop'),

    // This function is called when a file is added to the queue;
    // either via the browse button, or via drag/drop:
    add: function (e, data) {
      $('#vFrontCenterWindowBigImageVerwaltungOnLoadOverlay').show();
      $('#vFrontCenterWindowBigImageVerwaltungOnLoadStateShowProzent').css('width', '0%');
      $('#vFrontCenterWindowBigImageVerwaltungOnLoadStateShow').show();
      
      var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48" data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');
       
      // Append the file name and file size
      tpl.find('p').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');

      // Add the HTML to the UL element
      data.context = tpl.appendTo(ul);

      // Initialize the knob plugin
      tpl.find('input').knob();

      // Listen for clicks on the cancel icon
      tpl.find('span').click(function(){
        if(tpl.hasClass('working')){
            jqXHR.abort();
        }
        tpl.fadeOut(function(){
            tpl.remove();
        });
      });

      // Automatically upload the file once it is added to the queue
      var jqXHR = data.submit();
    },

    progress: function(e, data){
      // Calculate the completion percentage of the upload
      var progress = parseInt(data.loaded / data.total * 100, 10);
      
   
      var typeUpload = data.url.split('/').pop();
   
 
   

      // Update the hidden input field and trigger a change
      // so that the jQuery knob plugin knows to update the dial
      data.context.find('input').val(progress).change();

      if(progress == 100){
        data.context.removeClass('working');
        
        if(typeUpload == 'upload.php'){
         showImageVerwaltungOnlyPicLoad();
        }else{
         showDateiVerwaltungOnlyDateiLoad();
        }
        
      }
    },
    
    progressall: function(e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#vFrontCenterWindowBigImageVerwaltungOnLoadStateShowProzent').css('width', progress+'%');
      if(progress == 100){
        $('#vFrontCenterWindowBigImageVerwaltungOnLoadOverlay').hide();
        $('#vFrontCenterWindowBigImageVerwaltungOnLoadStateShow').hide();
        $('#vFrontCenterWindowBigImageVerwaltungOnLoadStateShowProzent').css('width', '0%');
        showOkWindowNow('Die Bilder wurden erfolgreich hochgeladen.');
        console.log('Upload Ok');
      }
    },

    fail:function(e, data){
      // Something has gone wrong!
      data.context.addClass('error');
    }

  });


  // Prevent the default action when a file is dropped on the window
  $(document).on('drop dragover', function (e) {
    e.preventDefault();
  });

  // Helper function that formats the file sizes
  function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
      return '';
    }

    if (bytes >= 1000000000) {
      return (bytes / 1000000000).toFixed(2) + ' GB';
    }

    if (bytes >= 1000000) {
      return (bytes / 1000000).toFixed(2) + ' MB';
    }

    return (bytes / 1000).toFixed(2) + ' KB';
  }
  
  
  function getPageName(url) {
    var index = url.lastIndexOf("/") + 1;
    var filenameWithExtension = url.substr(index);
    var filename = filenameWithExtension.split(".")[0]; // <-- added this line
    return filename;                                    // <-- added this line
}
  

});