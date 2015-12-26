<?php
/*********************************************************************
 *                                                                   *
 *                                                                   *
 *                      Erstellungsjahr: 2014                        *
 *                                                                   *
 *                                                                   *
 *********************************************************************/


// Datenbank ----------------------------------------------------------->
// --------------------------------------------------------------------->
// Datenbank Host (z.B. localhost)
$db_host ="localhost";
// Datenbank Username
$db_user = "pqnxskrspx";
// Datenbank Passwort
$db_pass = "5FCQsBuwe%0y";
// Datenbank Name 
$db_name = "icdigyfv0";
// --------------------------------------------------------------------->
// Datenbank ----------------------------------------------------------->



// Verbindung zur Datenbank herstellen --------------------------------->
// --------------------------------------------------------------------->
mysql_connect($db_host,$db_user,$db_pass) or die ("Keine Verbindung zur Datenbank m&ouml;glich!!");
mysql_select_db($db_name) or die ("Die Datenbank ist nicht vorhanden!!");

mysql_query('set character set utf8;');
mysql_query("SET NAMES 'utf8'");
?>
