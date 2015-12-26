<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsShopModul extends funktionsSammlung {
  
  // ***************************************************************************
  // ANFANG - Funktionen Ausgabe der Shop Produkt Liste
  // ***************************************************************************
  
  public function showHpProductsListInWindowNow() {
    $return = '<div class="vFrontModulShopList">';
    $return .= '<div id="vFrontModulShopNewProductBtn">Neues Produkt</div>';
    $return .= '<div class="clearer"></div>';
    $return .= '<div class="vFrontModulShopListHolder">
                ' . $this->showHpProductsListsAll() . '
                </div>';
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  private function showHpProductsListsAll() {
    $return = '';
    $sqlText = 'SELECT * FROM vprodukte';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return .= '<div class="vFrontModulShopListElem">';
      $return .= $rowPr['prName'];
      $return .= '<div class="vFrontModulShopListElemNavi">
                    <div class="vFrontModulShopListElemNaviChange" data-id="'. $rowPr['prID'] .'" title="Bearbeiten"></div>
                    <div class="vFrontModulShopListElemNaviDel" data-id="'. $rowPr['prID'] .'" title="Löschen"></div>
                  </div>';
      $return .= '</div>';
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Ausgabe der Shop Produkt Liste
  // ***************************************************************************
  
  
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktion Shop Produkt Löschen
  // ***************************************************************************
  
  public function deleteThisShopProductNow($curProductID) {
    $sqlDelText = 'DELETE FROM vprodukte WHERE prID = ' . $this->dbDecode($curProductID);
    return $this->dbAbfragen($sqlDelText);
  }
  
  // ***************************************************************************
  // ENDE - Funktion Shop Produkt Löschen
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Shop Produkt Neu und Bearbeiten Forms Ausgabe
  // ***************************************************************************
  
  public function showNewProductFormsInWindow() {
    $return = '<div class="vFrontFrmHolder vFrontShopProductFormHolder">';
    
    $return .= '<label for="vFrontShopProductName">Produkt Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input maxlength="150" type="text" name="vFrontShopProductName" id="vFrontShopProductName" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontShopProductPreis">Preis (Netto):</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontShopProductPreis" id="vFrontShopProductPreis" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontShopProductSteuer">Steuersatz (%):</label>
           <div class="vFrontLblAbstand"></div>
           <input maxlength="2" type="text" name="vFrontShopProductSteuer" id="vFrontShopProductSteuer" value="20" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label>Rabatt:</label>
           <div class="vFrontLblAbstand"></div>
           <select name="vFrontShopProductRabattChange" id="vFrontShopProductRabattChange">
            ' . $this->getProzentSelectOptions() . '
           </select>
           <input type="text" name="vFrontShopProductRabatt" id="vFrontShopProductRabatt" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label>Bild:</label>
           <div class="vFrontLblAbstand"></div>
           <input type="hidden" name="vFrontShopProductBild" id="vFrontShopProductBild" />
           <div id="vFrontShopProductNewBildHolder"></div>
           <div id="vFrontShopProductNewBildBtn">Bild auswählen</div>
           <div id="vFrontShopProductShowBildverwaltung">Bildverwaltung anzeigen</div>
           <div class="clearer vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    /*$return .= '<label for="vFrontShopProductSmallDesc">Kurzbeschreibung:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontShopProductSmallDesc" id="vFrontShopProductSmallDesc"></textarea>

           <div class="vFrontFrmAbstand"></div>';*/
    $return .= '<input type="hidden" name="vFrontShopProductSmallDesc" id="vFrontShopProductSmallDesc" />';
    
    $return .= '<label for="vFrontShopProductDesc">Beschreibung:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontShopProductDesc" id="vFrontShopProductDesc"></textarea>

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:150px;" type="submit" value="Speichern" id="vFrontShopProductSaveBtn" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  
  
  public function showBearProductFormsInWindow($curPrId) {
    $curPrBearArr = $this->getProductDataById($curPrId);
    if (!isset($curPrBearArr) || !is_array($curPrBearArr)) {
      return 'Fehler';
    }
    
    $return = '<div class="vFrontFrmHolder vFrontShopProductFormHolder">';
    
    $return .= '<label for="vFrontShopProductName">Produkt Name:</label>
           <div class="vFrontLblAbstand"></div>
           <input maxlength="150" type="text" name="vFrontShopProductName" id="vFrontShopProductName" value="' . $curPrBearArr['prName'] . '" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontShopProductPreis">Preis (Netto):</label>
           <div class="vFrontLblAbstand"></div>
           <input type="text" name="vFrontShopProductPreis" id="vFrontShopProductPreis" value="' . str_replace('.', ',', $curPrBearArr['prPreis']) . '" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label for="vFrontShopProductSteuer">Steuersatz (%):</label>
           <div class="vFrontLblAbstand"></div>
           <input maxlength="2" type="text" name="vFrontShopProductSteuer" id="vFrontShopProductSteuer" value="' . $curPrBearArr['prSteuersatz'] . '" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label>Rabatt:</label>
           <div class="vFrontLblAbstand"></div>
           <select name="vFrontShopProductRabattChange" id="vFrontShopProductRabattChange">
            ' . $this->getProzentSelectOptions($curPrBearArr['prRabattArt']) . '
           </select>
           <input type="text" name="vFrontShopProductRabatt" id="vFrontShopProductRabatt" value="' . str_replace('.', ',', $curPrBearArr['prRabatt']) . '" />

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<label>Bild:</label>
           <div class="vFrontLblAbstand"></div>';
    if (isset($curPrBearArr['prBild']) && !empty($curPrBearArr['prBild']) && $curPrBearArr['prBild'] != 0) {
      $curPicArr = $this->getProductBildDataById($curPrBearArr['prBild']);
      if (isset($curPicArr) && is_array($curPicArr)) {
        $return .= '<input type="hidden" name="vFrontShopProductBild" id="vFrontShopProductBild" value="' . $curPrBearArr['prBild'] . '" />
                <div id="vFrontShopProductNewBildHolder" style="display:block;"><img src="user_upload/' . $curPicArr['bildFile'] . '" alt="" title="" /></div>
           <div id="vFrontShopProductNewBildBtn">Bild ändern</div>
           <div id="vFrontShopProductShowBildverwaltung">Bildverwaltung anzeigen</div>';
      }
      else {
        $return .= '<input type="hidden" name="vFrontShopProductBild" id="vFrontShopProductBild" />
              <div id="vFrontShopProductNewBildHolder"></div>
              <div id="vFrontShopProductNewBildBtn">Bild auswählen</div>
              <div id="vFrontShopProductShowBildverwaltung">Bildverwaltung anzeigen</div>';
      }
    }
    else {
      $return .= '<input type="hidden" name="vFrontShopProductBild" id="vFrontShopProductBild" />
            <div id="vFrontShopProductNewBildHolder"></div>
            <div id="vFrontShopProductNewBildBtn">Bild auswählen</div>
            <div id="vFrontShopProductShowBildverwaltung">Bildverwaltung anzeigen</div>';
    }
    $return .= '<div class="clearer vFrontFrmAbstand"></div><div class="vFrontFrmAbstand"></div>';
    
    /*$return .= '<label for="vFrontShopProductSmallDesc">Kurzbeschreibung:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontShopProductSmallDesc" id="vFrontShopProductSmallDesc">' . $curPrBearArr['prSmallDesc'] . '</textarea>

           <div class="vFrontFrmAbstand"></div>';*/
    $return .= '<input type="hidden" name="vFrontShopProductSmallDesc" id="vFrontShopProductSmallDesc" value="' . $curPrBearArr['prSmallDesc'] . '" />';
    
    $return .= '<label for="vFrontShopProductDesc">Beschreibung:</label>
           <div class="vFrontLblAbstand"></div>
           <textarea name="vFrontShopProductDesc" id="vFrontShopProductDesc">' . $curPrBearArr['prDesc'] . '</textarea>

           <div class="vFrontFrmAbstand"></div>';
    
    $return .= '<div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <div class="vFrontFrmAbstand"></div>
         <input style="width:150px;" type="submit" value="Speichern" id="vFrontShopProductSaveBearbeitBtn" data-id="' . $curPrId . '" />';
    
    $return .= '</div>';
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Shop Produkt Neu und Bearbeiten Forms Ausgabe
  // ***************************************************************************
  
  
  
  
  
  
  // ***************************************************************************
  // ANFANG - Funktionen Shop Produkt Neu und Bearbeiten Speichern
  // ***************************************************************************
  
  public function saveNewProductShopNow() {
    $curPrPreis = str_replace(',', '.', $_POST['_prPreis']);
    $curPrSteuersatz = str_replace(',', '.', $_POST['_prSteuersatz']);
    $curPrRabattBetrag = '';
    if (isset($_POST['_prRabattChange']) && !empty($_POST['_prRabattChange'])) {
      $curPrRabattBetrag = str_replace(',', '.', $_POST['_prRabatt']);
    }
    
    $sqlText = 'INSERT INTO vprodukte 
                (prName, prPreis, prSteuersatz, prBild, prDesc, prSmallDesc, prRabattArt, prRabatt) 
                VALUES 
                ("' . $this->dbDecode($_POST['_prName']) . '", "' . $this->dbDecode($curPrPreis) . '", "' . $this->dbDecode($curPrSteuersatz) . '", "' . $this->dbDecode($_POST['_prBildId']) . '", "' . $this->dbDecode($_POST['_prDesc']) . '", "' . $this->dbDecode($_POST['_prDescSmall']) . '", "' . $this->dbDecode($_POST['_prRabattChange']) . '", "' . $this->dbDecode($curPrRabattBetrag) . '")';
    return $this->dbAbfragen($sqlText);
  }
  
  
  
  public function saveBearbeitProductShopNow($curPrId) {
    $curPrPreis = str_replace(',', '.', $_POST['_prPreis']);
    $curPrSteuersatz = str_replace(',', '.', $_POST['_prSteuersatz']);
    $curPrRabattBetrag = '';
    if (isset($_POST['_prRabattChange']) && !empty($_POST['_prRabattChange'])) {
      $curPrRabattBetrag = str_replace(',', '.', $_POST['_prRabatt']);
    }
    
    $sqlText = 'UPDATE vprodukte SET 
                prName = "' . $this->dbDecode($_POST['_prName']) . '", 
                prPreis = "' . $this->dbDecode($curPrPreis) . '", 
                prSteuersatz = "' . $this->dbDecode($curPrSteuersatz) . '", 
                prBild = "' . $this->dbDecode($_POST['_prBildId']) . '", 
                prDesc = "' . $this->dbDecode($_POST['_prDesc']) . '", 
                prSmallDesc = "' . $this->dbDecode($_POST['_prDescSmall']) . '", 
                prRabattArt = "' . $this->dbDecode($_POST['_prRabattChange']) . '", 
                prRabatt = "' . $this->dbDecode($curPrRabattBetrag) . '" 
                WHERE prID = ' . $this->dbDecode($curPrId);
    return $this->dbAbfragen($sqlText);
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Shop Produkt Neu und Bearbeiten Speichern
  // ***************************************************************************

  




  // ***************************************************************************
  // ANFANG - Funktionen Shop Produkt Hilfsfunktionen
  // ***************************************************************************

  private function getProductDataById($curPrId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vprodukte WHERE prID = ' . $this->dbDecode($curPrId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPr = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowPr;
    }
    
    return $return;
  }
  
  
  
  private function getProductBildDataById($curPicId) {
    $return = '';
    
    $sqlText = 'SELECT * FROM vbilder WHERE bildID = ' . $this->dbDecode($curPicId) . ' LIMIT 1';
    $sqlErg = $this->dbAbfragen($sqlText);
    
    while ($rowPic = mysql_fetch_array($sqlErg, MYSQL_ASSOC)) {
      $return = $rowPic;
    }
    
    return $return;
  }
  
  
  
  private function getProzentSelectOptions($isCheck = '') {
    $targetArr = array(
      '' => 'Ohne',
      'prozent' => 'Prozent',
      'betrag' => 'Betrag',
    );

    $return = '';

    foreach ($targetArr as $key => $target) {
      if ($key == $isCheck) {
        $return .= '<option selected="selected" value="' . $key . '">' . $target . '</option>';
      }
      else {
        $return .= '<option value="' . $key . '">' . $target . '</option>';
      }
    }
    
    return $return;
  }
  
  // ***************************************************************************
  // ENDE - Funktionen Shop Produkt Hilfsfunktionen
  // ***************************************************************************
  
}

?>