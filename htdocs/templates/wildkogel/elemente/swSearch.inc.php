<?php
$search = mysql_escape_string($_POST['search']);

if(!empty($_POST['search'])){
    
 if(empty($_GET['_lang'])){
   $query = mysql_query("SELECT * FROM  vsprachen ORDER BY langID LIMIT 1");
   $row   = mysql_fetch_array($query);
   $idLang= $row['langID'];
   
 }else{
   
   $lang = mysql_escape_string($_GET['_lang']);
   $query = mysql_query("SELECT * FROM  vsprachen WHERE langKurzName='$lang' ORDER BY langID LIMIT 1");
   $row   = mysql_fetch_array($query);
   $idLang= $row['langID'];
 
 }   


$query = mysql_query("SELECT * FROm vseitensearch WHERE description LIKE '%".$search."%' AND id_lang=1 AND description != ''  GROUP BY id_site");



?>
<div class="searchResults">
<ul>
<?php
    while($row = mysql_fetch_array($query)){
        $idSite = $row['id_site'];
        $query1 = mysql_query("SELECT * FROM vseiten WHERE seitID ='$idSite'");
        $row1   = mysql_fetch_array($query1);  
?>
    <li><a href="<?php echo $row1['seitTextUrl']; ?>"> <?php  echo $row1['seitName'] ?></a></li>  
<?php
    }
?>
</ul>

<?php  }else{ ?>
    
  <?php echo  lang('results'); ?>
    
<?php  }  ?>

</div>