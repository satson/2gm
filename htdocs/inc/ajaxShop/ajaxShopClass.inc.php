<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsShopModulFrontend extends funktionsSammlung {
  
  public function setShopModulJsNewProductWarenkorb($curProductId) {
    if (isset($_SESSION['cmsShopModulProductsAll']) && count($_SESSION['cmsShopModulProductsAll']) > 0) {
      if (isset($_SESSION['cmsShopModulProductsAll'][$curProductId]) && !empty($_SESSION['cmsShopModulProductsAll'][$curProductId])) {
        $_SESSION['cmsShopModulProductsAll'][$curProductId] = $_SESSION['cmsShopModulProductsAll'][$curProductId] + 1;
        return true;
      }
      else {
        $_SESSION['cmsShopModulProductsAll'][$curProductId] = 1;
        return true;
      }
    }
    else {
      $_SESSION['cmsShopModulProductsAll'] = array();
      $_SESSION['cmsShopModulProductsAll'][$curProductId] = 1;
      return true;
    }
    
    return false;
  }
  
  
  
  public function getShopModulJsNewProductWarenkorbPreis() {
    $return = 0;
    
    if (isset($_SESSION['cmsShopModulProductsAll']) && count($_SESSION['cmsShopModulProductsAll']) > 0) {
      foreach ($_SESSION['cmsShopModulProductsAll'] as $key => $value) {
        $curBetragEinzel = $this->getShopModulJsWarenkorbPreisProduktEinzel($key, $value);
        $return = $return + $curBetragEinzel;
      }
    }
    
    return $return;
  }
  
  
  
  private function getShopModulJsWarenkorbPreisProduktEinzel($prId, $prMenge) {
    $return = 0;
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($prId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $einzelPreis = $rowPr['prPreis'];
      if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'betrag') {
        $einzelPreis = $einzelPreis - $rowPr['prRabatt'];
      }
      else if (isset($rowPr['prRabattArt']) && $rowPr['prRabattArt'] == 'prozent') {
        $zwPreis = $einzelPreis / 100;
        $zwPreis = $zwPreis * $rowPr['prRabatt'];
        $einzelPreis = $einzelPreis - $zwPreis;
      }
      $return = $einzelPreis * $prMenge;
    }
    
    return $return;
  }
  
  
  
  
  
  
  
  public function setShopModulJsNewProductMengePlus($curPrId) {
    if (isset($_SESSION['cmsShopModulProductsAll'][$curPrId])) {
      $_SESSION['cmsShopModulProductsAll'][$curPrId] = $_SESSION['cmsShopModulProductsAll'][$curPrId] + 1;
      return $this->buildJsonPricesShopNew($curPrId);
    }
  }
  
  
  
  public function setShopModulJsNewProductMengeMinus($curPrId) {
    if (isset($_SESSION['cmsShopModulProductsAll'][$curPrId])) {
      $_SESSION['cmsShopModulProductsAll'][$curPrId] = $_SESSION['cmsShopModulProductsAll'][$curPrId] - 1;
      return $this->buildJsonPricesShopNew($curPrId);
    }
  }
  
  
  
  public function setShopModulJsDelProductNow($curPrId) {
    if (isset($_SESSION['cmsShopModulProductsAll'][$curPrId])) {
      unset($_SESSION['cmsShopModulProductsAll'][$curPrId]);
      return $this->buildJsonPricesShopNew($curPrId);
    }
  }
  
  
  
  private function buildJsonPricesShopNew($curPrId) {
    setlocale(LC_MONETARY, 'de_AT');
    $return = array();
    $return['preisWarenkorb'] = 0;
    $return['preisGesamtNetto'] = 0;
    $return['preisSteuer'] = 0;
    $return['preisGesamtBrutto'] = 0;
    $return['preisProduktSumme'] = 0;
    
    foreach ($_SESSION['cmsShopModulProductsAll'] as $key => $value) {
      $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($key) . ' LIMIT 1';
      $sqlErg = $this->dbAbfragen($sqlText);
      
      while($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
        // Rabatt
        // **************************************
        $einzelPreis = $row['prPreis'];
        if (isset($row['prRabattArt']) && $row['prRabattArt'] == 'betrag') {
          $einzelPreis = $einzelPreis - $row['prRabatt'];
        }
        else if (isset($row['prRabattArt']) && $row['prRabattArt'] == 'prozent') {
          $zwPreis = $einzelPreis / 100;
          $zwPreis = $zwPreis * $row['prRabatt'];
          $einzelPreis = $einzelPreis - $zwPreis;
        }
        // **************************************
        
        // Einzel Produkt Summe
        // **************************************
        if ($row['prID'] == $curPrId) {
          $return['preisProduktSumme'] = $einzelPreis * $value;
        }
        // **************************************
        
        // Gesamte Netto Summe
        // **************************************
        $return['preisGesamtNetto'] = $return['preisGesamtNetto'] + ($einzelPreis * $value);
        // **************************************
        
        // Gesamte Steuer
        // **************************************
        $prSteuerZw = ($einzelPreis * $value) / 100;
        $prSteuer = $prSteuerZw * $row['prSteuersatz'];
        $return['preisSteuer'] = $return['preisSteuer'] + $prSteuer;
        // **************************************
      }
    }
    
    $return['preisWarenkorb'] = $return['preisGesamtNetto'];
    $return['preisGesamtBrutto'] = $return['preisSteuer'] + $return['preisGesamtNetto'];
    
    $return['preisWarenkorb'] = money_format('EUR %!n', $return['preisWarenkorb']);
    $return['preisGesamtNetto'] = money_format('EUR %!n', $return['preisGesamtNetto']);
    $return['preisSteuer'] = money_format('EUR %!n', $return['preisSteuer']);
    $return['preisGesamtBrutto'] = money_format('EUR %!n', $return['preisGesamtBrutto']);
    $return['preisProduktSumme'] = money_format('EUR %!n', $return['preisProduktSumme']);
    
    return json_encode($return);
  }


  
  
  
  
  
  
  
  public function loadShopModulDetailInhaltAjax($curProductId) {
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($curProductId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($row = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      return $this->buildShopModulDetailInhaltAjax($row);
    }
  }
  
  
  
  private function buildShopModulDetailInhaltAjax($prArray) {
    setlocale(LC_MONETARY, 'de_AT');
    
    $return = '<div class="vCmsShopModPrDetailInhaltHolder">';
    
    $curPicArr = $this->getPicForModShopElemDetail($prArray['prBild']);
    
    $return .= '<div class="vCmsShopModPrDetailInhaltBild">';
    if (isset($curPicArr['bildFile']) && !empty($curPicArr['bildFile'])) {
      $return .= '<div class="vCmsShopModPrDetailInhaltBildPlusLightBoxBtn" data-file="user_upload/' . $curPicArr['bildFile'] . '"></div>';
      $return .= '<img src="user_upload/' . $curPicArr['bildFile'] . '" alt="" title="" />';
    }
    else {
      $return .= '<img src="admin/img/noImg.png" alt="" title="" />';
    }
    $return .= '</div>';
    
    $return .= '<div class="vCmsShopModPrDetailInhaltText">';
    $return .= '<h1>' . $prArray['prName'] . '</h1>';
    $return .= '<div class="vCmsShopModPrDetailInhaltTextText">' . $prArray['prDesc'] . '</div>';
    $return .= '<div style="height:20px;"></div>';
    $einzelPreis = $prArray['prPreis'];
    $isRabatt = false;
    if (isset($prArray['prRabattArt']) && $prArray['prRabattArt'] == 'betrag') {
      $einzelPreis = $einzelPreis - $prArray['prRabatt'];
      $isRabatt = true;
    }
    else if (isset($prArray['prRabattArt']) && $prArray['prRabattArt'] == 'prozent') {
      $zwPreis = $einzelPreis / 100;
      $zwPreis = $zwPreis * $prArray['prRabatt'];
      $einzelPreis = $einzelPreis - $zwPreis;
      $isRabatt = true;
    }
    $steuerZw = $einzelPreis / 100;
    $steuerBetrag = $steuerZw * $prArray['prSteuersatz'];
    $bruttoBetrag = $einzelPreis + $steuerBetrag;
    
    if (isset($isRabatt) && $isRabatt == true) {
      $return .= '<div class="vCmsShopModPrDetailInhaltTextPreisNettoRabattOhne"><span class="vCmsShopModPrDetailInhaltTextPreiseUe">&nbsp;</span><span class="vCmsShopModPrDetailInhaltTextPreiseBetrag">' . money_format('EUR %!n', $prArray['prPreis']) . '</span></div>';
    }
    
    $return .= '<div class="vCmsShopModPrDetailInhaltTextPreisNetto"><span class="vCmsShopModPrDetailInhaltTextPreiseUe">Netto Preis</span><span class="vCmsShopModPrDetailInhaltTextPreiseBetrag">' . money_format('EUR %!n', $einzelPreis) . '</span></div>';
    $return .= '<div class="vCmsShopModPrDetailInhaltTextPreisSteuer"><span class="vCmsShopModPrDetailInhaltTextPreiseUe">+ ' . $prArray['prSteuersatz'] . '% MwSt</span><span class="vCmsShopModPrDetailInhaltTextPreiseBetrag">' . money_format('EUR %!n', $steuerBetrag) . '</span></div>';
    $return .= '<div class="vCmsShopModPrDetailInhaltTextPreisBrutto"><span class="vCmsShopModPrDetailInhaltTextPreiseUe">Brutto Preis</span><span class="vCmsShopModPrDetailInhaltTextPreiseBetrag">' . money_format('EUR %!n', $bruttoBetrag) . '</span></div>';
    $return .= '</div>';
    
    $return .= '<div class="clearer" style="height:40px;"></div>';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function getPicForModShopElemDetail($picID) {
    $return = array();
    
    $sqlPicText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($picID) . ' LIMIT 1';
    $sqlPicErg = $this->dbAbfragen($sqlPicText);
    
    while ($rowPic = mysql_fetch_array($sqlPicErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    
    return $return;
  }
  
}

?>