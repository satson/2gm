<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/



class cmsPicMakeSmall extends funktionsSammlung {
  
  public function createPicThumb($picFileArr, $curFilePath, $curFilenameSave) {
    $this->createCurPicThumb($picFileArr, $curFilePath, $curFilenameSave);
  }
  
  
  
  private function createCurPicThumb($picFileArr, $curFilePath, $curFilenameSave) {
    chmod($curFilePath.$curFilenameSave, 0755);
    $picType = $picFileArr['type'];
    if (isset($picType) && $picType == "image/jpeg") {
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '200');
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '400');
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '800');
    }
    else if (isset($picType) && $picType == "image/pjpeg") {
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '200');
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '400');
      $this->createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, '800');
    }
    else if (isset($picType) && $picType == "image/gif") {
      $this->createPicThumbGIF($picFileArr, $curFilePath, $curFilenameSave, '200');
      $this->createPicThumbGIF($picFileArr, $curFilePath, $curFilenameSave, '400');
      $this->createPicThumbGIF($picFileArr, $curFilePath, $curFilenameSave, '800');
    }
    else if (isset($picType) && $picType == "image/x-png") {
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '200');
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '400');
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '800');
    }
    else if (isset($picType) && $picType == "image/png") {
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '200');
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '400');
      $this->createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, '800');
    }
  }
  
  
  
  private function createPicThumbJPG($picFileArr, $curFilePath, $curFilenameSave, $curWidthPic) {
    $size = getimagesize($curFilePath.$curFilenameSave);
    $breite = $size[0];
    $hoehe = $size[1];
    if ($breite > $curWidthPic) {
      $neuebreite = $curWidthPic;
      $neuehoehe = intval($hoehe * $neuebreite/$breite);
      $altesbild = imagecreatefromjpeg($curFilePath.$curFilenameSave);
      $neuesbild = imagecreatetruecolor($neuebreite, $neuehoehe);
      imagecopyresampled($neuesbild, $altesbild, 0, 0, 0, 0, $neuebreite, $neuehoehe, $breite, $hoehe);
      imagejpeg($neuesbild, $curFilePath.'thumb_' . $curWidthPic . '/'.$curFilenameSave);
    }
  }
  
  
  
  private function createPicThumbGIF($picFileArr, $curFilePath, $curFilenameSave, $curWidthPic) {
    $size = getimagesize($curFilePath.$curFilenameSave);
    $breite = $size[0];
    $hoehe = $size[1];
    if ($breite > $curWidthPic) {
      $neuebreite = $curWidthPic;
      $neuehoehe = intval($hoehe * $neuebreite/$breite);
      $altesbild = imagecreatefromgif($curFilePath.$curFilenameSave);
      $neuesbild = imagecreatetruecolor($neuebreite, $neuehoehe);

      $farbe_body = imagecolorallocate($neuesbild, 255,255,255);
      imagefill($neuesbild, 0, 0, $farbe_body);

      imagecopyresampled($neuesbild, $altesbild, 0, 0, 0, 0, $neuebreite, $neuehoehe, $breite, $hoehe);
      imagegif($neuesbild, $curFilePath.'thumb_' . $curWidthPic . '/'.$curFilenameSave);
    }
  }
  
  
  
  private function createPicThumbPNG($picFileArr, $curFilePath, $curFilenameSave, $curWidthPic) {
    $size = getimagesize($curFilePath.$curFilenameSave);
    $breite = $size[0];
    $hoehe = $size[1];
    if ($breite > $curWidthPic) {
      $neuebreite = $curWidthPic;
      $neuehoehe = intval($hoehe * $neuebreite/$breite);
      $altesbild = imagecreatefrompng($curFilePath.$curFilenameSave);
      $neuesbild = imagecreatetruecolor($neuebreite, $neuehoehe);

      $farbe_body = imagecolorallocate($neuesbild, 255,255,255);
      imagefill($neuesbild, 0, 0, $farbe_body);

      imagecopyresampled($neuesbild, $altesbild, 0, 0, 0, 0, $neuebreite, $neuehoehe, $breite, $hoehe);
      imagepng($neuesbild, $curFilePath.'thumb_' . $curWidthPic . '/'.$curFilenameSave);
    }
  }
  
}

?>