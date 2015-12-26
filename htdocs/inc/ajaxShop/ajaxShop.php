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


require_once('../db_connect.inc.php');
require_once('../functionsAll.inc.php');

include_once('ajaxShopClass.inc.php');


if (isset($_POST['_art']) && !empty($_POST['_art'])) {

  switch ($_POST['_art']) {
    
    // Setzt ein neues Produkt in den Warenkorb
    // *************************************************************************
    case 'setShopModulJsNewProductWarenkorb':
      setlocale(LC_MONETARY, 'de_AT');
      $curPrClassObj = new cmsShopModulFrontend();

      $checkOk = $curPrClassObj->setShopModulJsNewProductWarenkorb($_POST['_curProductId']);
      if ($checkOk == true) {
        echo money_format('EUR %!n', $curPrClassObj->getShopModulJsNewProductWarenkorbPreis());
      }
      else {
        echo 'fehler';
      }

      break;
      
    
      
    // Gibt die Detail Ansicht von einem Produkt aus
    // *************************************************************************
    case 'loadShopModulDetailInhaltAjax':
      $curPrClassObj = new cmsShopModulFrontend();

      echo $curPrClassObj->loadShopModulDetailInhaltAjax($_POST['_curProductId']);

      break;
    
    
    
    // Erhöht die Produkt Menge um 1
    // *************************************************************************
    case 'setShopModulJsNewProductMengePlus':
      $curPrClassObj = new cmsShopModulFrontend();

      echo $curPrClassObj->setShopModulJsNewProductMengePlus($_POST['_curProductId']);

      break;
    
    
    
    // Minimiert die Produkt Menge um 1
    // *************************************************************************
    case 'setShopModulJsNewProductMengeMinus':
      $curPrClassObj = new cmsShopModulFrontend();

      echo $curPrClassObj->setShopModulJsNewProductMengeMinus($_POST['_curProductId']);

      break;
    
    
    
    // Löscht ein Produkt vom Warenkorb
    // *************************************************************************
    case 'setShopModulJsDelProductNow':
      $curPrClassObj = new cmsShopModulFrontend();

      echo $curPrClassObj->setShopModulJsDelProductNow($_POST['_curProductId']);

      break;
    
  }
  
}

?>