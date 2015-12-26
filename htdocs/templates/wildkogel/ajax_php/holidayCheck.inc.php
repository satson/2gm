<?php

function getHolidayCheckBewertung() {
  $hotelData = json_decode(getHotelDataNow(), true);
  $hotelRatingData = json_decode(getHotelRatingDataNow(), true);
  $hotelReviewData = json_decode(getHotelReviewDataNow(), true);
  
  return buildBewertungAusgabe($hotelData, $hotelRatingData, $hotelReviewData);
}



function getHotelDataNow() {
  $curHotelUri = 'https://api.holidaycheck.com/v2/hotel/45164?partner_token=75DD17F6-30C4-43AF-AAE3-BD6E98ADDBE9';
  return getRequest("json", $curHotelUri);
}



function getHotelRatingDataNow() {
  $curHotelUri = 'https://api.holidaycheck.com/v2/hotelrating/45164?partner_token=75DD17F6-30C4-43AF-AAE3-BD6E98ADDBE9';
  return getRequest("json", $curHotelUri);
}



function getHotelReviewDataNow() {
  $curHotelUri = 'https://api.holidaycheck.com/v2/hotelreview?filter=hotelId:45164&limit=5&partner_token=75DD17F6-30C4-43AF-AAE3-BD6E98ADDBE9';
  return getRequest("json", $curHotelUri);
}



 
/*
* Makes an HTTP GET request with curl
* and prints the result + header informations.  
* (shows all hotels which have more than 3 stars and sorted depending on number of stars) 
*
* @param outputFormat "json" / "xml"
* @param partnerToken 
*/
function getRequest($outputFormat, $curlUri) {
  header("Content-Type:text/plain");

  //Initialize the curl session
  $ch = curl_init();

  // setting the Header for the request
  $_header = array();
  array_push($_header, "Accept: text/" . $outputFormat);
  array_push($_header, "Content-Type: text/" . $outputFormat); 

  curl_setopt($ch, CURLOPT_URL, $curlUri);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $_header);


  curl_setopt($ch, CURLOPT_HTTPGET, true);
  $store = curl_exec($ch);
  
  curl_close($ch);
  
  return $store;
}



// Ausgabe bauen
function buildBewertungAusgabe($hotelData, $hotelRatingData, $hotelReviewData) {
  //$return = '<div style="display:none">';
  //$return .= '<pre>' . print_r($hotelData, 1) . '</pre>';
  //$return .= '<pre>' . print_r($hotelRatingData, 1) . '</pre>';
  //$return .= '<pre>' . print_r($hotelReviewData, 1) . '</pre>';
  //$return .= '</div>';
  
  $starCountHotel = round((100 / 6) * $hotelRatingData['hotelRating']['overall']);
  $starCountZimmer = round((100 / 6) * $hotelRatingData['roomRating']['overall']);
  $starCountService = round((100 / 6) * $hotelRatingData['serviceRating']['overall']);
  $starCountLage = round((100 / 6) * $hotelRatingData['locationRating']['overall']);
  $starCountFood = round((100 / 6) * $hotelRatingData['foodRating']['overall']);
  $starCountSport = round((100 / 6) * $hotelRatingData['sportRating']['overall']);
  
  $return .= '<div class="holidayCheckAusgabeHolder">
                <div class="holidayCheckAusgabeTop">
                  <div class="holidayCheckAusgabeTopLeft"><a href="http://www.holidaycheck.de/hotel-Reiseinformationen_Hotel+Gassner-hid_45164.html" target="_blank"><img src="templates/wildkogel/img/holiday_check_logo.jpg" alt="Holidaycheck" title="" /></a></div>
                  <div class="holidayCheckAusgabeTopRight">
                    Unsere HolidayCheck Bewertungen
                    <div class="smallTop">Bewertungsdurchschnitt: ' . $hotelData['recommendation'] . '%</div>
                    <div class="smallTop">Anzahl Bewertungen: ' . $hotelData['countReviews'] . '</div>
                  </div>
                  <div class="clearer"></div>
                </div>
                
                <div class="holidayCheckAusgabeCenter">
                  <div class="detailElem">
                    <div class="detailElemLeft">Hotel</div>
                    <div class="detailElemRight">' . round($hotelRatingData['hotelRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountHotel . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                  
                  <div class="detailElem">
                    <div class="detailElemLeft">Zimmer</div>
                    <div class="detailElemRight">' . round($hotelRatingData['roomRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountZimmer . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                  
                  <div class="detailElem">
                    <div class="detailElemLeft">Service</div>
                    <div class="detailElemRight">' . round($hotelRatingData['serviceRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountService . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                  
                  <div class="detailElem">
                    <div class="detailElemLeft">Lage</div>
                    <div class="detailElemRight">' . round($hotelRatingData['locationRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountLage . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                  
                  <div class="detailElem">
                    <div class="detailElemLeft">Gastronomie</div>
                    <div class="detailElemRight">' . round($hotelRatingData['foodRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountFood . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                  
                  <div class="detailElem">
                    <div class="detailElemLeft">Sport</div>
                    <div class="detailElemRight">' . round($hotelRatingData['sportRating']['overall'], 2) . '</div>
                    <div class="detailElemRightStars">
                      <div class="detailElemRightStarsInner" style="width:' . $starCountSport . '%;"></div>
                    </div>
                    <div class="clearer"></div>
                  </div>
                </div>
                
                <div id="bewertenLinkBtn"><a href="https://secure.holidaycheck.de/hotelbewertung_abgeben.php?action=hotelselect&entityId=45164&hc_cid=HCDE_B2B_APIKO_wanderhotels.com&tsource=APIKO_HBAUF" target="_blank">Dieses Hotel bewerten</a></div>
                
                <div id="bewertungShowBtn">Neueste Bewertungen anzeigen</div>
                
                <div id="bewertungHolderToggle">';
  
                  foreach ($hotelReviewData['items'] as $curItem) {
                    $curText = '';
                    if (isset($curItem['textHotel']) && !empty($curItem['textHotel'])) {
                      $curText = $curItem['textHotel'];
                    }
                    else if (isset($curItem['text']) && !empty($curItem['text'])) {
                      $curText = $curItem['text'];
                    }
                    
                    $return .= '<div class="bwItemHolder">
                                <div class="bwItemHolderUe">' . $curItem['title'] . '</div>
                                <div class="bwItemHolderText">' . $curText . ' ...</div>
                                <div class="bwItemHolderLink"><a href="' . $curItem['hcSourceUrl'] . '" target="_blank">mehr lesen</a></div>
                              </div>';
                  }
                  
         $return .= '</div>
              <div style="height:20px;"></div>
            </div>';
  
  return $return;
}

?>