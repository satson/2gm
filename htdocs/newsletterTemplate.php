<?php
define(URLIMAGE, 'http://wildkogel-arena.at/user_upload/');
define(URLTEMPLATE, 'http://wildkogel-arena.at/templates/newsletter/xml/images/');
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                    *
 *********************************************************************/

// Österreichische Zeitzone definieren
date_default_timezone_set('Europe/Vienna');
 

// Datenbank Connection File einbinden
// *******************************************************
require_once('inc/db_connect.inc.php');



// Allgemeine CMS Funktionen Klasse einbinden
// *******************************************************
require_once('inc/functionsAll.inc.php');




require_once('inc/hp_functions.inc.php');
$cmsHpObj = new hpFunctions();

// CMS Homepage Daten Array
// *******************************************************
$hpCms = $cmsHpObj->getHpDataArray();




// CMS Funktionen Klasse einbinden
// *******************************************************
require_once('admin/inc/klassen/newsletter.inc.php');

$newsObj = new newsletter();
$data = $newsObj->getElemtData(2853);
$xml  = $newsObj->getXmlData();

  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<title>*|MC:SUBJECT|*</title>
<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css' />
<style type="text/css"> 
html
{
	width: 100%;
}

::-moz-selection{background:#e12519;color:#eeeeee;}
::selection{background:#e12519;color:#eeeeee;}

body { 
   background-color: #f5f6f6; 
   margin: 0; 
   padding: 0; 
}

.ReadMsgBody
{
	width: 100%;
	background-color: #f5f6f6;
}
.ExternalClass
{
	width: 100%;
	background-color: #f5f6f6;
}

a { 
    color:#e12519; 
	text-decoration:none;
	
	font-style: normal;
} 
a:hover { 
    color:#505050; 
	text-decoration:underline;
	
	font-style: normal;
}



p, div {
	margin: 0 !important;
}
table {
	border-collapse: collapse;
}

@media only screen and (max-width: 640px)  {
	table table{width:100% !important; }
	td[class="full_width"] {width:100% !important; }
	div[class="div_scale"] {width: 440px !important; margin: 0 auto !important;}
	table[class="table_scale"] {width: 440px !important; margin: 0 auto !important;}
	table[class="bannertop-css"] {margin: 0 auto !important;}
	table[class="featured_area"] {width: 454px !important; margin: 0 auto !important;}
	td[class="td_scale"] {width: 440px !important; margin: 0 auto !important;}
	img[class="img_scale"] {width: 100% !important; height: auto !important;}
	img[class="divider"] {width: 440px !important; height: 2px !important;}
	img[class="bannertop-img"] {width: 100% !important; height: auto !important;}
	table[class="spacer"] {display: none !important;}
	td[class="spacer"] {display: none !important;}
	td[class="center"] {text-align: center !important;}
	table[class="full"] {width: 400px !important; margin-left: 20px !important; margin-right: 20px !important;}
	img[class="divider"] {width: 113px !important; height: 8px !important;}
	
}


@media only screen and (max-width: 479px)  {
	table table{width:100% !important; }
	td[class="full_width"] {width:100% !important; }
	div[class="div_scale"] {width: 280px !important; margin: 0 auto !important;}
	table[class="table_scale"] {width: 280px !important; margin: 0 auto !important;}
	table[class="featured_area"] {width: 290px !important; margin: 0 auto !important;}
	td[class="td_scale"] {width: 280px !important; margin: 0 auto !important;}
	img[class="img_scale"] {width: 100% !important; height: auto !important;}
	img[class="divider"] {width: 280px !important; height: 2px !important;}
	table[class="spacer"] {display: none !important;}
	td[class="spacer"] {display: none !important;}
	td[class="center"] {text-align: center !important;}
	table[class="full"] {width: 240px !important; margin-left: 20px !important; margin-right: 20px !important; }
	img[class="divider"] {width: 113px !important; height: 8px !important;}
	
}


@media print {

.print-none {
	display: none;
}

}

</style>


</head>
<body bgcolor="#FFFFFF">
<!-- START OF PRE-HEADER AREA BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#FFFFFF" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
						
						<table class="table_scale" width="600" bgcolor="#f0f0f0" cellpadding="0" cellspacing="0" border="0" style="border-top: 1px solid #f7f7f7;">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="margin: 0; padding-top: 15px; padding-bottom: 15px;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 18px;mso-line-height-rule: exactly;">
															<span>
															 Purer Skigenuss in der Wildkogel-Arena 
 
															</span>
														</td>
													</tr>
													<!-- END OF TEXT-->
												</table>
												<!-- END OF LEFT COLUMN-->
												
												
												<!-- START OF SPACER-->
												<table class="spacer" width="20" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td width="100%" height="10"></td>
													</tr>
												</table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													
													<tr>
														<td  class="center" align="right" style="margin: 0; padding-top: 15px; padding-bottom: 15px;  font-size:13px ; color:#e12519; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 18px;mso-line-height-rule: exactly;">
															<span style="color:#e12519;">
															<a href="*|ARCHIVE|*" style="border-bottom: 1px dotted #e12519;  font-style: normal; text-decoration: none; color:#e12519;">
															Online Version
															</a>
															&nbsp;&nbsp;|&nbsp;&nbsp;
															<a href="*|FORWARD|*" style="border-bottom: 1px dotted #e12519;  font-style: normal; text-decoration: none; color:#e12519;">
															An einen Freund senden  

															</a>
															</span>
														</td>
													</tr>
												</table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF PRE-HEADER AREA BLOCK-->

<!-- START OF HEADER BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						
						
						
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td>
												
												<!-- START OF LOGO-->
												<table class="full bannertop-css" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td  class="center" align="center" style="padding: 0px;font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%;">
															<span>
															<a href="#" style="color:#e12519;">
																<img src="<?php echo URLIMAGE.$data['images'][0]; ?>" alt="bannertop" width="600" height="248" border="0" style="display: inline-block;" class="bannertop-img" />
															</a>
															</span>
														</td>
													</tr>
												</table>
												<!-- END OF LOGO-->
												
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF HEADER BLOCK-->

<div >
<!-- START OF FEATURED AREA BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="featured_area" align="center" width="620" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td   align="center" style="margin: 0; font-size:14px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
									<span>
									<img class="img_scale" src="<?php echo URLTEMPLATE ?>top-teaser.png" alt="top teaser" width="620" height="25" border="0" style="display: block;" />
									</span>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						
						<!-- END OF VERTICAL SPACER-->
						
						<table class="featured_area" align="center" width="620" bgcolor="#b1b1b1" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="620" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tr>
														<td   class="center" align="left" style="padding: 0px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#FFFFFF; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span><br>
															<?php echo strip_tags($data['texts']['elemText1'])  ?>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START BUTTON-->
													
													<!-- END BUTTON-->
												</table>
												<!-- END OF LEFT COLUMN-->
												
												
												
												
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#b1b1b1" class="featured_area" width="620" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
						
						<table class="featured_area" align="center" width="620" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td   align="center" style="margin: 0; font-size:14px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
									<span>
									<img class="img_scale" src="<?php echo URLTEMPLATE ?>bottom-teaser.png" alt="bottom teaser" width="620" height="25" border="0" style="display: block;" />
									</span>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="30">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF FEATURED AREA BLOCK-->
</div>

<div  >
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span>
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																Schneehöhen
															</a>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															<?php echo $xml['schnee'] ?>
															
															</table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="15" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tbody><tr>
														<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span>
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																Schneebeschaffenheit
															</a>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															
															<tr>
<?php
$i=1;

foreach($xml['schneeb'] as $key => $value){ 
    if($i<=2) { ?>															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															
<?php if($i==1){
    ?>
   <td>&nbsp;</td>     
        <?php
    } } $i++; } ?>															
															</tr>
															<tr>
															<?php
$i=1;

foreach($xml['schneeb'] as $key => $value){ 
    if($i>2) { ?>															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															
<?php if($i==3){
    ?>
   <td>&nbsp;</td>     
        <?php
    } } $i++; } ?>
															</tr>
															
															
															</table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>

<div >
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												
												<table width="540">
												
													<tr>
													<td  class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																	Offene Anlagen / Talabfahrten
															</a>
															
														</td>
													</tr>
												
												</table>
												
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody>
													
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															<?php 

                                                                                                                        $i=1; foreach($xml['lifte'] as $key => $value){ 
                                                                                                                            if($i<=2){?>
															<tr>
															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															</tr>
                                                                                                                            <?php }  $i++; } ?>
                                                                                                          															<?php 

                                                                                                                        $i=1; foreach($xml['piste'] as $key => $value){ 
                                                                                                                            if($i==1){?>
															<tr>
															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															</tr>
                                                                                                                            <?php }  $i++; } ?>														
															</table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tbody>
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															<?php 

                                                                                                                        $i=1; foreach($xml['lifte'] as $key => $value){ 
                                                                                                                            if($i>2){?>
															<tr>
															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															</tr>
                                                                                                                            <?php }  $i++; } ?>
															<?php 

                                                                                                                        $i=1; foreach($xml['piste'] as $key => $value){ 
                                                                                                                            if($i==2){?>
															<tr>
															<td><?php echo $value['name'] ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;" /></td>
															</tr>
                                                                                                                            <?php }  $i++; } ?>														
															</table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>

<div >
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												
												<table width="540">
												
													<tr>
													<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																	Rodelbahnen 
															</a>
															
														</td>
													</tr>
												
												</table>
												
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody>
													
													
													<!-- START OF TEXT-->
													<tr>
														<td  class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															
															<tbody>
                                                                                                                       <?php 
                                                                                                                      $i=1;
                                                                                                                       foreach($xml['rodel'] as $key => $value){ 
                                                                                                                         if($i<=3){ 
                                                                                                                           ?>
                                                                                                                        <tr>
															<td><?php echo (string)$value['name']; ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;"></td>
															</tr>
                                                                                                                       <?php
                                                                                                                         }
                                                                                                                       $i++;  }  ?>     
														
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tbody>
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															
															<tbody>
                                                                                                                       <?php 
                                                                                                                      $i=1;
                                                                                                                       foreach($xml['rodel'] as $key => $value){ 
                                                                                                                         if($i>3){ 
                                                                                                                           ?>
                                                                                                                        <tr>
															<td><?php echo (string)$value['name']; ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;"></td>
															</tr>
                                                                                                                       <?php
                                                                                                                         }
                                                                                                                       $i++;  }  ?>     
														
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>
<?php if(1==2){ ?>
<div >
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												
												<table width="540">
												
													<tr>
													<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																	Loipen
															</a>
															
														</td>
													</tr>
												
												</table>
												
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody>
													
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															
															<tbody>
                                                                                                                       <?php 
                                                                                                                      $i=1;
                                                                                                                       foreach($xml['liften'] as $key => $value){ 
                                                                                                                         if($i<=6 && (string)$value['name'] != ''){ 
                                                                                                                           ?>
                                                                                                                        <tr>
															<td><?php echo (string)$value['name']; ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;"></td>
															</tr>
                                                                                                                       <?php
                                                                                                                         }
                                                                                                                       $i++;  }  ?>     
														
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tbody>
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="250">
															
															<tbody>
                                                                                                                       <?php 
                                                                                                                      $i=1;
                                                                                                                       foreach($xml['liften'] as $key => $value){ 
                                                                                                                         if($i>6  && $i<=11){ 
                                                                                                                           ?>
                                                                                                                        <tr>
															<td><?php echo (string)$value['name']; ?></td>
															<td><img class="img_scale" src="<?php echo URLTEMPLATE.$value['status'] ?>" alt="status1" width="15" height="15" border="0" style="display: block;"></td>
															</tr>
                                                                                                                       <?php
                                                                                                                         }
                                                                                                                       $i++;  }  ?>     
														
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>
<?php  } ?>




<div >
<!-- START OF 1/1 (FULL WIDTH) INTRO TEXT BLOCK-->
<!-- START OF HEADER BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						
						
						
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td>
												
												<!-- START OF LOGO-->
												<table class="full bannertop-css" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td   class="center" align="center" style="padding: 0px;font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#444444; font-size:18px; line-height:100%;">
															<span>
															<a href="tel:004365656205" style="color:#e12519;">
																<img src="<?php echo URLTEMPLATE ?>tel1.jpg" alt="schneetelefon" width="600" height="99" border="0" style="display: inline-block;" class="bannertop-img"/>
															</a>
															<a href="tel:0043656539800" style="color:#e12519;">
																<img src="<?php echo URLTEMPLATE ?>tel2.jpg" alt="schneetelefon" width="600" height="100" border="0" style="display: inline-block;" class="bannertop-img"/>
															</a>
															</span>
														</td>
													</tr>
												</table>
												<!-- END OF LOGO-->
												
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF HEADER BLOCK-->
</div>


<div>
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tbody><tr>
		<td valign="top" width="100%">
		
		<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
		
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												
												<table width="540">
												
													<tbody><tr>
													<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
																		Wettervorschau
															</a>
															
														</td>
													</tr>
												
												</tbody></table>
												
												<table class="full" align="left" width="265" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody>
													
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="265">
															
															<tbody><tr>
															<td>
																<table width="265">
																
																<tr><td align="center" style="font-size: 15px;"><strong>Vormittag</strong></td><td align="center" style="font-size: 15px;"><strong>Nachmittag</strong></td></tr>
																
																<tr>
                             <?php 
                                                                                                                                                                                                                                        $i=0; foreach($xml['wather_image'] as $key => $value){ 
                                                                                                                                                    if($i<2){
                                                                                                                                        ?>
                                                                                                                                    <td align="center"><img src="<?php echo URLTEMPLATE.$value ?>.jpg"  width="110" height="110" border="0" style="display: inline-block;" /></td>
                              
                                                                                                                                                    <?php } $i++; } ?>                                                                                            
                                                                                                                                </tr>
																
																<tr><td align="center"><strong>Datum</strong></td><td align="center"><strong>Temperatur</strong></td></tr>
																<?php echo $xml['wather1'] ?>
																
																
																
																</table>
																
																
																
															</td>
															
															
															</tr>
															
															
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="center" width="265" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tbody>
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															
															<table width="265">
															
															<tbody><tr>
															<td>
																<table width="265"> 
															
																<tr><td align="center" style="font-size: 15px;"><strong><?php echo $xml['dayText'][0] ?></strong></td><td align="center" style="font-size: 15px;"><strong><?php echo $xml['dayText'][1] ?></strong></td></tr>
																
																<tr>
                                                                                                                                    <?php 
                                                                                                                                                                                                                                        $i=0; foreach($xml['wather_image'] as $key => $value){ 
                                                                                                                                                    if($i>1){
                                                                                                                                        ?>
                                                                                                                                    <td align="center"><img src="<?php echo URLTEMPLATE.$value ?>.jpg"  width="110" height="110" border="0" style="display: inline-block;" /></td>
                              
                                                                                                                                                    <?php } $i++; } ?>
                                                                                                                                </tr>
																
																<tr><td align="center"><strong>Sonnenschein</strong></td><td align="center"><strong>Frostgrenze</strong></td></tr>
																
																<?php echo $xml['wather2'] ?>
																
																
																</table>
																
																
																
															</td>
															
															
															</tr>
															
															
															
															</tbody></table>
															
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>



<div>
<!-- START OF DIVIDER IMAGE BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table align="center" width="540" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td   align="center" style="margin: 0; font-size:14px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
												<span>
												<img class="divider" src="<?php echo URLTEMPLATE ?>divider-image.png" alt="divider image" width="113" height="8" border="0" style="display: inline-block;" />
												</span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF DIVIDER IMAGE BLOCK-->
</div>



<div>
<!-- START OF 1/2 COLUMN LEFT IMAGE BLOCK-->
<?php if(strip_tags($data['texts']['elemText2']) != ''){ ?>
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td   class="center" align="left" style="margin: 0; font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;">
															<span>
															<a href="#" style="color:#e12519;">
															<img class="img_scale" src="<?php echo URLIMAGE.$data['images'][1]; ?>" alt="img-255-170" width="255" height="170" border="0" style="display: inline-block;" />
															</a>
															</span>
														</td>
													</tr>
												</table>
												<!-- END OF LEFT COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="15" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td width="100%" height="40"></td>
													</tr>
												</table>
												<!-- END OF SPACER-->
												 
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tr>
														<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span>
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
															<?php echo strip_tags($data['texts']['elemText2'])  ?>
															</a>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="padding-top: 10px; margin: 0;   font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															<span>
															<?php echo strip_tags($data['texts']['elemText3'])  ?>
															</span>
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													<!-- START BUTTON-->
													<tr  >
														<td   bgcolor="#eeeeee" align="left" valign="top" style="padding-top: 20px;">
															<table border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#f5f6f6" style="margin: 0;">
																<tr>
																	<td align="center" valign="middle" bgcolor="#f5f6f6" style="border-left: 5px solid #e12519; padding: 7px 20px;font-size: 13px; line-height: 18px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#677b82; margin: 0 !important; ">
																		<a href="<?php echo strip_tags($data['texts']['elemText4'])  ?>" style=" font-style: normal; color:#677b82;">
																			Mehr erfahren
																		</a>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<!-- END BUTTON-->
												</table>
                                                                                                
                                                                                                
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>  <?php } ?>
<!-- END OF 1/2 COLUMN LEFT IMAGE BLOCK-->
</div>

<div>
<!-- START OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
                     <?php if(strip_tags($data['texts']['elemText5']) != ''){ ?>
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
                                                                   
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
                                                                                            
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tr>
														<td   class="center" align="left" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span>
															<a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">
															<?php echo strip_tags($data['texts']['elemText5'])  ?>
															</a>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td  class="center" align="left" style="padding-top: 10px; margin: 0;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															<span>
															<?php echo strip_tags($data['texts']['elemText6'])  ?>
															</span>
														</td>
													</tr>
													<!-- END OF TEXT-->
													
													<!-- START BUTTON-->
													<tr >
														<td   bgcolor="#eeeeee" align="left" valign="top" style="padding-top: 20px;">
															<table border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#f5f6f6" style="margin: 0;">
																<tr>
																	<td align="center" valign="middle" bgcolor="#f5f6f6" style="border-left: 5px solid #e12519; padding: 7px 20px;font-size: 13px; line-height: 18px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#677b82; margin: 0 !important; ">
																		<a href="<?php echo strip_tags($data['texts']['elemText7'])  ?>" style=" font-style: normal; color:#677b82;">
																			Mehr erfahren
																		</a>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<!-- END BUTTON-->
												</table>
												<!-- END LEFT COLUMN-->
												 
												<!-- START OF SPACER-->
												<table width="15" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td width="100%" height="40"></td>
													</tr>
												</table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td   class="center" align="left" style="margin: 0; font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;">
															<span>
															<a href="#" style="color:#e12519;">
															<img class="img_scale" src="<?php echo URLIMAGE.$data['images'][2]; ?>" alt="img-255-170" width="255" height="170" border="0" style="display: block;" />
															</a>
															</span>
														</td>
													</tr>
												</table>
                                                                                                
												<!-- END OF RIGHT COLUMN-->
											</td>
                                                                                      
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>  
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table><?php } ?>
<!-- END OF 1/2 COLUMN RIGHT IMAGE BLOCK-->
</div>




<div style="margin: 0 !important;">
<!-- START OF 1/3 COLUMN BLOCK-->
<table class="print-none" width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
	<tbody><tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
				<tbody><tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tbody><tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
										<tbody><tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="160" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													
													<!-- START OF ICON-->
													<tbody><tr>
														<td align="center" style="margin: 0; padding-bottom: 20px; font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;"><span><a href="https://wildkogel-arena.at/de/winterurlaub-webcams" target="_blank" style="color:#ededed;"><img align="none" height="58" src="http://wildkogel-arena.at/templates/newsletter/xml/images/icon-cam.png" style="width: 58px; height: 58px; margin: 0px;" width="58"></a>&nbsp;</span></td>
													</tr>
													<!-- END OF ICON-->
													
													<!-- START OF HEADING-->
													<tr>
														<td class="center" align="center" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0;  font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">Webcams</a> </span></td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td class="center" align="center" style="padding-top: 10px; margin: 0;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">Live aus der Wildkogel-Arena</span></td>
													</tr>
													<!-- END OF TEXT-->
													
													<!-- START BUTTON-->
													<tr>
														<td bgcolor="#eeeeee" align="center" valign="top" style="padding-top: 20px;"><table align="center" bgcolor="#f5f6f6" border="0" cellpadding="0" cellspacing="0" style="margin: 0;border-collapse: collapse;">
	<tbody>
		<tr>
			<td align="center" bgcolor="#f5f6f6" style="border-left: 5px solid #e12519; padding: 7px 20px;font-size: 13px; line-height: 18px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#677b82; margin: 0 !important; " valign="middle"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a href="https://wildkogel-arena.at/de/winterurlaub-webcams" style="font-style: normal;color: #677b82;text-decoration: none;" target="_blank">Ansehen </a></span></td>
		</tr>
	</tbody>
</table>
</td>
													</tr>
													<!-- END BUTTON-->
												</tbody></table>
												<!-- END OF LEFT COLUMN-->
												
												
												<!-- START OF SPACER-->
												<table width="25" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF MIDDLE COLUMN-->
												<table class="full" align="left" width="160" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF ICON-->
													<tbody><tr>
														<td align="center" style="margin: 0; padding-bottom: 20px; font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;"><span><a href="https://wildkogel-arena.at/de/urlaubsinformationen-wildkogel-wetter" target="_blank" style="color:#ededed;"><img align="none" height="58" src="http://wildkogel-arena.at/templates/newsletter/xml/images/icon-sun222.png" style="width: 58px; height: 58px; margin: 0px;" width="58"></a>&nbsp;</span></td>
													</tr>
													<!-- END OF ICON-->
													
													<!-- START OF HEADING-->
													<tr>
														<td class="center" align="center" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">Wetter</a> </span></td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td class="center" align="center" style="padding-top: 10px; margin: 0;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">Aktuelle Wetterdaten &amp; Prognosen</span></td>
													</tr>
													<!-- END OF TEXT-->
													
													<!-- START BUTTON-->
													<tr>
														<td bgcolor="#eeeeee" align="center" valign="top" style="padding-top: 20px;"><table align="center" bgcolor="#f5f6f6" border="0" cellpadding="0" cellspacing="0" style="margin: 0;border-collapse: collapse;">
	<tbody>
		<tr>
			<td align="center" bgcolor="#f5f6f6" style="border-left: 5px solid #e12519; padding: 7px 20px;font-size: 13px; line-height: 18px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#677b82; margin: 0 !important; " valign="middle"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a href="https://wildkogel-arena.at/de/urlaubsinformationen-wildkogel-wetter" style="font-style: normal;color: #677b82;text-decoration: none;" target="_blank">Ansehen</a></span></td>
		</tr>
	</tbody>
</table>
</td>
													</tr>
													<!-- END BUTTON-->
												</tbody></table>
												<!-- END OF MIDDLE COLUMN-->
												
												<!-- START OF SPACER-->
												<table width="20" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tbody><tr>
														<td width="100%" height="40"></td>
													</tr>
												</tbody></table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="160" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF ICON-->
													<tbody><tr>
														<td align="center" style="margin: 0; padding-bottom: 20px; font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;"><span><a href="https://wildkogel-arena.at/de/winterurlaub-skigebiet-wildkogel-arena-lifte-pisten" target="_blank" style="color:#ededed;"><img align="none" height="58" src="http://wildkogel-arena.at/templates/newsletter/xml/images/icon-golndola.png" style="width: 58px; height: 58px; margin: 0px;" width="58"></a>&nbsp;</span></td>
													</tr>
													<!-- END OF ICON-->
													
													<!-- START OF HEADING-->
													<tr>
														<td class="center" align="center" style="padding-bottom: 5px; border-bottom: 1px solid #b0b0b0; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#505050; font-size:24px; line-height:34px; mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a class="heading_link" href="#" style="color:#505050; text-decoration: none; font-style: normal; ">Lifte &amp; Pisten</a> </span></td>
													</tr>
													<!-- END OF HEADING-->
													
													<!-- START OF TEXT-->
													<tr>
														<td class="center" align="center" style="padding-top: 10px; margin: 0;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">Livedaten aktuell geöffneter Lifte &amp; Pisten</span></td>
													</tr>
													<!-- END OF TEXT-->
													
													<!-- START BUTTON-->
													<tr>
														<td bgcolor="#eeeeee" align="center" valign="top" style="padding-top: 20px;"><table align="center" bgcolor="#f5f6f6" border="0" cellpadding="0" cellspacing="0" style="margin: 0;border-collapse: collapse;">
	<tbody>
		<tr>
			<td align="center" bgcolor="#f5f6f6" style="border-left: 5px solid #e12519; padding: 7px 20px;font-size: 13px; line-height: 18px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#677b82; margin: 0 !important; " valign="middle"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><a href="https://wildkogel-arena.at/de/winterurlaub-skigebiet-wildkogel-arena-lifte-pisten" style="font-style: normal;color: #677b82;text-decoration: none;" target="_blank">Ansehen</a></span></td>
		</tr>
	</tbody>
</table>
</td>
													</tr>
													<!-- END BUTTON-->
												</tbody></table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#eeeeee" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
							<tbody><tr>
								<td width="100%" height="40">
									&nbsp;
								</td>
							</tr>
						</tbody></table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</tbody></table>
		</td>
	</tr>
</tbody></table>
<!-- END OF 1/3 COLUMN BLOCK-->
</div>




<div>
<!-- START OF CALL TO ACTION BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="featured_area" align="center" width="620" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td   align="center" style="margin: 0; font-size:14px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
									<span>
									<img class="img_scale" src="<?php echo URLTEMPLATE ?>top-teaser2.png" alt="top teaser" width="620" height="25" border="0" style="display: block;" />
									</span>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#e12519" class="featured_area" width="620" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="30">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
						
						<table class="featured_area" align="center" width="620" bgcolor="#e12519" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="620" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF HEADING-->
													<tr>
														<td   class="center" align="left" style="padding: 0px; font-family: 'PT Sans', Helvetica, Arial, sans-serif; color:#FFFFFF; font-size:24px; line-height:34px; mso-line-height-rule: exactly;">
															<span>
															<?php echo strip_tags($data['texts']['elemText8'])  ?>
															</span>
														</td>
													</tr>
													<!-- END OF HEADING-->
												</table>
												<!-- END OF LEFT COLUMN-->
												
												
												
												
												
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#e12519" class="featured_area" width="620" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="30">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
						
						<table class="featured_area" align="center" width="620" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td  " align="center" style="margin: 0; font-size:14px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
									<span>
									<img class="img_scale" src="<?php echo URLTEMPLATE ?>bottom-teaser2.png" alt="bottom teaser" width="620" height="25" border="0" style="display: block;" />
									</span>
								</td>
							</tr>
						</table>
						
						<!-- START OF VERTICAL SPACER-->
						<table bgcolor="#FFFFFF" class="table_scale" width="600" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%" height="30">
									&nbsp;
								</td>
							</tr>
						</table>
						<!-- END OF VERTICAL SPACER-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF CALL TO ACTION BLOCK-->
</div>

<!-- START OF SUB-FOOTER BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						
						<table class="table_scale" width="600" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0" style="">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td class="spacer" width="30">
											</td>
											
											<td width="540">
												
												<!-- START OF LEFT COLUMN-->
												<table class="full" align="left" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<!-- START OF TEXT-->
													<tr>
														<td   class="center" align="left" style="margin: 0; padding: 0;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;">
															<span>
																Copyright © Wildkogel-Arena
															</span>
														</td>
													</tr>
													<!-- END OF TEXT-->
												</table>
												<!-- END OF LEFT COLUMN-->
												
												
												<!-- START OF SPACER-->
												<table width="20" align="left" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td width="100%" height="20"></td>
													</tr>
												</table>
												<!-- END OF SPACER-->
												
												<!-- START OF RIGHT COLUMN-->
												<table class="full" align="right" width="255" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td   class="center" align="right" style="margin: 0; padding-top: 0px;padding-bottom: 30px;font-size:11px ; color:#787878; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 100%;">
															<span>
															<a href="https://www.facebook.com/Wildkogel?goal=0_0eff6ba7d7-bf86ae4bb7-" style="color:#ededed;">
																<img src="<?php echo URLTEMPLATE ?>facebook.png" alt="facebook" width="32" height="32" border="0" style="display: inline-block;" />
															</a>
															&nbsp;&nbsp;&nbsp;
															<a href="https://www.youtube.com/user/UAWildkogel5741?goal=0_0eff6ba7d7-bf86ae4bb7-" style="color:#ededed;">
																<img src="<?php echo URLTEMPLATE ?>youtube.png" alt="rss" width="32" height="32" border="0" style="display: inline-block;" />
															</a>
														
															</span>
														</td>
													</tr>
												</table>
												<!-- END OF RIGHT COLUMN-->
											</td>
											
											<td class="spacer" width="30">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF SUB-FOOTER BLOCK-->

<!-- START OF BOTTOM TEASER BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="center" valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="540">
												<table align="left" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td align="center" valign="top" style="padding: 0px;">
															<table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#e12519" style="margin: 0;">
																<tr>
																	<td   align="center" valign="middle" bgcolor="#f5f6f6" style="padding: 0px; font-size:13px ; font-style:normal; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 0;">
																		<img class="img_scale" src="<?php echo URLTEMPLATE ?>footer-teaser.png" width="600" height="28" alt="img 600 290" border="0" style="display: block;" />
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF BOTTOM TEASER BLOCK-->

<!-- START OF FOOTER BLOCK-->
<table width="100%" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" width="100%">
			<table align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="100%">
						<table class="table_scale" width="600" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="100%">
									<table width="600" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td width="600">
												<table class="full" align="center" width="540" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
													<tr>
														<td   class="center" align="center" style="margin: 0; padding: 30px 0px;  font-size:13px ; color:#677b82; font-family: 'PT Sans', Helvetica, Arial, sans-serif; line-height: 23px;">
															<span>
															Wildkogel-Arena Neukirchen & Bramberg
															<br>+43 720 710 730

															<br /><br>
															<a href="mailto:info@wildkogel-arena.at">info@wildkogel-arena.at</a><br>
															<a href="http://www.wildkogel-arena.at">www.wildkogel-arena.at</a><br><br>

															</span>
															<span style="color:#e12519;">
															<a href="*|ARCHIVE|*" style="border-bottom: 1px dotted #e12519;  font-style: normal; text-decoration: none; color:#e12519;">
															Bericht drucken
															</a>
															&nbsp;&nbsp;|&nbsp;&nbsp;
															<a href="*|FORWARD|*" style="border-bottom: 1px dotted #e12519;  font-style: normal; text-decoration: none; color:#e12519;">
															An einen Freund senden 
															</a>
															&nbsp;&nbsp;|&nbsp;&nbsp;
															<a href="*|UNSUB|*" style="border-bottom: 1px dotted #e12519;  font-style: normal; text-decoration: none; color:#e12519;">
															Abmelden 
															</a>
															</span>
															<br /><br>
															<span>
															Alle Texte sind urheberrechtlich geschützt. Alle in diesem Newsletter gemachten Informationen wurden nach besten Wissen und Gewissen erstellt. Dennoch kann der Autor für die Richtigkeit der gemachten Angaben keine Gewähr übernehmen. Die Nutzung der Informationen erfolgt auf eigene Gefahr. 
															</span>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- END OF FOOTER BLOCK-->
</body>
</html>