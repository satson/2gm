/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



$(document).ready(function() {
  
  $('#frmUserLog').focus();
  
});




function checkLoginData() {
  $('.logLoader').show();
  
  $('#logErrorText').hide();
  var errorLog = '';
  
  if ($('#frmUserLog').val() == '' || $('#frmPassLog').val() == '') {
    errorLog = 'Bitte geben Sie Ihren Benutzername und das Passwort ein!';
  }
  
  if (errorLog != '') {
    $('.logLoader').hide();
    $('#logErrorText').html(errorLog);
    $('#logErrorText').show();
    return false;
  }
  else {
    return true;
  }
}