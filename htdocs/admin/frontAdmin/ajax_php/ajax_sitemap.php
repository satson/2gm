<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Prüfen ob User angemeldet ist
// *****************************************************************************
require_once('../../../inc/check.inc.php');
if (!checkIsUserLogedIn()) {
  exit();
}


// Benötigte Files einbinden
// *****************************************************************************
require_once('../../../inc/db_connect.inc.php');


// Schema nach  http://www.sitemaps.org/de/protocol.html


if (isset($_POST['_httpPfad']) && !empty($_POST['_httpPfad'])) {
  echo getSitemapXML($_POST['_httpPfad']);
}




function getSitemapXML($pfad) {
  $fileText = buildSitemapFile($pfad);
  
  //return htmlentities($fileText);
  return $fileText;
}



function buildSitemapFile($pfad) {
$fileText = '<?xml version="1.0" encoding="UTF-8"?>


<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

  $sqlTextS = 'SELECT seitTextUrl FROM vseiten WHERE seitOnline = 1 AND (seitArt = 1 OR seitArt = 2)';
  //$sqlTextS = 'SELECT seitKurzBezeichnung FROM tblseiten WHERE seitOnline = 1 AND hpID = ' . $_SESSION['v_hp_id'] . ' AND (isContainer = 2 OR isContainer = 3)';
  $sqlErgS = mysql_query($sqlTextS);

  while($rowS = mysql_fetch_array($sqlErgS, MYSQL_ASSOC)) {
    $fileText .= '
  <url>
    <loc>' . $pfad . $rowS['seitTextUrl'] . '</loc>
  </url>
  ';
  }

$fileText .= '
</urlset>';

file_put_contents('../../../sitemap.xml', $fileText);

return $fileText;
}

?>