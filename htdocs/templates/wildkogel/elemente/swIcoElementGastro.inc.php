<?php  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $thisElemArr['picGalFullHD']['picGalFirstImg'], $matches);
 $img = $matches[1]; 
 
require_once($_SERVER['DOCUMENT_ROOT'].'/templates/wildkogel/inc/mmClass.inc.php');
$mmFunctionsObj = new mmFunctionsLibrary();
 
 $idElem = $thisElemArr['elemData']['selemID'];
 $query  = mysql_query("SELECT * FROM vseitenelemente WHERE selemID = '$idElem' ");
 $row = mysql_fetch_array($query);
 
 $conf = json_decode($row['selemConfig']) ;
 
 $picArr  = explode(';',$conf->picGal);
 
 $image = $mmFunctionsObj->getPicOnceDataByIdMM($picArr[0]);
 if(isset($picArr[1] ) ){
   $image1 = $mmFunctionsObj->getPicOnceDataByIdMM($picArr[1]);  
 }

 ?>
						<div class="infoPanelCategory">
						
							
							
								<div class="infoIcon">
									<img src="/user_upload/<?php echo $image['bildName'] ?>">
																	
								</div>
								<div class="infoTitle">
									<?php echo $thisElemArr['text1']; ?>
								</div>
							
							
							
									
						</div>