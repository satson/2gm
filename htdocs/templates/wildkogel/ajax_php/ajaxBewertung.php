<?php

session_start();

// Österreichische Zeitzone definieren
date_default_timezone_set('Europe/Vienna');



// Datenbank Connection File einbinden
// *******************************************************
require_once('../../../inc/db_connect.inc.php');



// Allgemeine CMS Funktionen Klasse einbinden
// *******************************************************
require_once('../../../inc/functionsAll.inc.php');



// Holiday Check File einbinden
// *******************************************************
require_once('holidayCheck.inc.php');



//echo '<div class="footerBewertungLeftShowElem"><iframe style="background-color:#FFF;" allowtransparency="true" frameborder="0" height="150" src="http://api.trustyou.com/hotels/bee24faa-773a-49a0-87e9-d065df964c01/sources.html" width="294" scrolling="no"></iframe></div>';
echo '<div class="footerBewertungLeftShowElem"><iframe allowtransparency="true" frameborder="0" height="137" src="http://api.trustyou.com/hotels/bee24faa-773a-49a0-87e9-d065df964c01/sources.html" width="422" scrolling="no"></iframe></div>';
echo getHolidayCheckBewertung();
echo '<div class="clearer"></div>';

?>


<script type="text/javascript">
  $('#bewertungShowBtn').click(function() {
    $('#bewertungHolderToggle').toggle();
  });
</script>