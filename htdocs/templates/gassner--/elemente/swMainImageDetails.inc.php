<?php
 

 
if($thisElemArr['bild1'] == '' ||  $thisElemArr['text1'] == ''){
 require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
$data = $mmFunctionsObj->getDefaultMainData(2373,50);


$data = json_decode($data['selemInhalt']) ;



$text = $data->elemText1;
$idImg = $data->elemBild1;

 

$imageData = $mmFunctionsObj->getPicOnceDataByIdMM($idImg);
 
 
 
 
} 

if($thisElemArr['bild1'] == ''){
  
  $img = '<img src="user_upload/'.$imageData['bildName'].'">';
 }else{
  
  $img = $thisElemArr['bild1'];
 }
 

 
 if($thisElemArr['text1'] == ''){
  $text = '';
 }else{
  $text = $thisElemArr['text1'];
  
 }
 
 
 
 if($thisElemArr['text2'] == ''){
  $text2 = '';
 }else{
  $text2 = $thisElemArr['text2'];
  
 }

 

?>


<div class="logo"> <?php echo $img; ?> 
                </div>
       
   
             
                <?php // print_r($thisElemArr['bild1']); ?>