<?php
require_once('config.php');
$sqlkategorie = "SELECT `id`, `nazev` FROM `kategorie` ORDER BY `nazev` ASC";
$kategoriesql = mysqli_query($mysqli, $sqlkategorie);
if (mysqli_num_rows($kategoriesql)>0) {
  $selectkategorie = "<select name=\"kategorie\" required=\"required\">\r\n<option value=\"0\" disabled=\"disabled\" selected=\"selected\">--Vybrat kategorii--</option>\r\n";
  while($rowkategorie = mysqli_fetch_assoc($kategoriesql)) {
    $idkategorie = $rowkategorie['id'];
    $nazevkategorie = $rowkategorie['nazev'];
    $selectkategorie .= "<option value=\"".$idkategorie."\">".$nazevkategorie."</option>\r\n";
  }
  $selectkategorie .= "</select>\r\n";
}
if ( !empty($_POST) ) {
  $otazka = $_POST['otazka'];
  $kategorieotazky = $_POST['kategorie'];
  $sqlotazka = "INSERT INTO `otazky` (`otazka`,`kategorie`) VALUES ('".$otazka."', '".$kategorieotazky."')";
  $sqlidotazka = "SELECT `id` FROM `otazky` ORDER BY `id` DESC LIMIT 1";
  $sqlinsertotazka = mysqli_query($mysqli, $sqlotazka);
  $sqlidotazka = mysqli_query($mysqli, $sqlidotazka);
  if (mysqli_num_rows($sqlidotazka)>0) {
    while($rowidotazka = mysqli_fetch_assoc($sqlidotazka)) {
      $otazkaid = $rowidotazka['id'];
    }
  }
  $odpoved1 = $_POST['odpoved1'];
  $odpoved2 = $_POST['odpoved2'];
  $odpoved3 = $_POST['odpoved3'];
  $odpoved4 = $_POST['odpoved4'];
  $obrazek1 = $_POST['obrazek1'];
  $obrazek2 = $_POST['obrazek2'];
  $obrazek3 = $_POST['obrazek3'];
  $obrazek4 = $_POST['obrazek4'];
  $spravnaodpoved = $_POST['CorrectAnswer'];  
  $sqlodpovedi = "INSERT INTO `odpovedi` (`odpoved`, `otazka`, `bodu`) VALUES ('".$odpoved1."', '".$otazkaid."', 0), ('".$odpoved2."', '".$otazkaid."', 0), ('".$odpoved3."', '".$otazkaid."', 0), ('".$odpoved4."', '".$otazkaid."', 0)";
  $sqlinsertodpovedi = mysqli_query($mysqli, $sqlodpovedi);
  switch($spravnaodpoved){
    case 1:
      $sqlodpovedupdate = "UPDATE `odpovedi` SET `bodu`=1, `obrazek`='".$obrazek1."' WHERE `odpoved`='".$odpoved1."'";
      break;
    case 2:
      $sqlodpovedupdate = "UPDATE `odpovedi` SET `bodu`=1, `obrazek`='".$obrazek2."' WHERE `odpoved`='".$odpoved2."'";
      break;
    case 3:
      $sqlodpovedupdate = "UPDATE `odpovedi` SET `bodu`=1, `obrazek`='".$obrazek3."' WHERE `odpoved`='".$odpoved3."'";
      break;
    case 4:
      $sqlodpovedupdate = "UPDATE `odpovedi` SET `bodu`=1, `obrazek`='".$obrazek4."' WHERE `odpoved`='".$odpoved4."'";
      break;  
  }
  $sqlupdateodpovedi = mysqli_query($mysqli, $sqlodpovedupdate);
  $sqlidspravneodpovedi = "SELECT `id` FROM `odpovedi` WHERE `otazka`='".$otazkaid."' AND `bodu`=1";
  $sqlidspravnaodpoved = mysqli_query($mysqli, $sqlidspravneodpovedi);
  if (mysqli_num_rows($sqlidspravnaodpoved)>0) {
    while($rowodpoved = mysqli_fetch_assoc($sqlidspravnaodpoved)) {
      $odpovedid = $rowodpoved['id'];
    }
  }
  $sqlupdatespravnaodpoved = "UPDATE `otazky` SET `spravna`='".$odpovedid."' WHERE `id`=".$otazkaid." LIMIT 1";
  $sqlupdtspravnaodpoved = mysqli_query($mysqli, $sqlupdatespravnaodpoved);
}
?>
<HTML>
<HEAD>
<style>
table, th, td {
  border: 1px solid;
}
</style>
</HEAD>
<BODY>
<form action="formular.php" method="post">
<table style="border: 1px solid;margin:auto;margin-top:150px;width:60%">
    <tr><td colspan="2" style="margin-auto;">Otázka: <input name="otazka" type="text" required="required" size="200"></td></tr>
    <tr><td colspan="2" style="margin-auto;">Kategorie otázky: <?php echo $selectkategorie; ?></td></tr>
    <tr><td>Odpověď 1: <input name="odpoved1" type="text" required="required" size="50"><input type="radio" id="radio1" name="CorrectAnswer" value="1"><label for="1">1</label> | Obrázek: <input name="obrazek1" type="text" size="100"></td></tr>
    <tr><td>Odpověď 2: <input name="odpoved2" type="text" required="required" size="50"><input type="radio" id="radio2" name="CorrectAnswer" value="2"><label for="2">2</label> | Obrázek: <input name="obrazek2" type="text" size="100"></td></tr>
    <tr><td>Odpověď 3: <input name="odpoved3" type="text" required="required" size="50"><input type="radio" id="radio3" name="CorrectAnswer" value="3"><label for="3">3</label> | Obrázek: <input name="obrazek3" type="text" size="100"></td></tr>
    <tr><td>Odpověď 4: <input name="odpoved4" type="text" required="required" size="50"><input type="radio" id="radio4" name="CorrectAnswer" value="4"><label for="4">4</label> | Obrázek: <input name="obrazek4" type="text" size="100"></td></tr>
    <tr><td colspan="2" style="margin-auto;padding-left:40%"><input style="margin-left:auto;margin-right:auto;" type="submit" value="Odeslat"></td></tr>
</table>
</form>
</BODY>
</HTML>