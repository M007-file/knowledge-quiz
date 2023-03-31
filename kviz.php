<?php
require_once("config.php");
if ( !empty($_POST['otazek']) ) {
  $kvizovychotazek = $_POST['otazek'];
} else {
  $kvizovychotazek = 20;
  //$kvizovychotazek = 2;
}

function dequote($quotedstring){
  if (str_contains($quotedstring, "'")) {
    $uvozovky = array("'", "'");
    $encodeduvozovky = array("&#39;", "&#39;");
    $result = str_replace($uvozovky, $encodeduvozovky, $quotedstring);
    $quotedstring = $result;
  }
  return $quotedstring;
}

?>
<!DOCTYPE html>
<head> 
<script>
function disableClick(){
  document.onclick=function(event){
    if(event.button == 2) {
      alert('Sorry, takhle fakt ne');
      return false;
    }
  }
}

function atou(b64) {
  return decodeURIComponent(escape(atob(b64)));
}

function utoa(data) {
  return btoa(unescape(encodeURIComponent(data)));
}

/*document.addEventListener('contextmenu', 
    event => event.preventDefault()
);*/
</script>
</head>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="images/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
#div,.odpoved{font-family:Verdana;color:#00f}input,select{padding:10px;width:30%;border:1px solid #aaa}#div,.tab{display:none}.tab,body,h1,td,tr{text-align:center}#div{background:#3bb300;height:100px;width:200px;padding:15px;font-size:20px}#regForm{-webkit-box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);background-color:#fff;}.tab{background-color:#fff;}.odpoved{font-size:30px;padding:20px}body{background:#2fcec7;background:-moz-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:-webkit-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:radial-gradient(ellipse at center,#2fcec7 0,#3e80a4 50%,#215ac5 100%)}#regForm{margin:100px auto;font-family:Raleway;padding:40px;width:70%;min-width:300px;opacity:.9}h1{font-size:55px}button,input,select{font-size:17px;font-family:Raleway}select{background:#67a6eb;margin-bottom:20px}.step.finish,button{background-color:#04aa6d}input.invalid{background-color:#fdd}.tab{margin-top:100px}#prevBtn,.step{background-color:#bbb}button{color:#fff;border:none;padding:10px 20px;cursor:pointer}button:hover{opacity:.8}.step{height:15px;width:15px;margin:0 2px;border:none;border-radius:50%;display:inline-block;opacity:.5}.step.active{opacity:1}table{border:1px solid #ccc;margin-top:30px}td,tr{padding:30px}input[type=text],textarea{background-color:red}a:active,a:link,a:visited{color:#00f}a:hover{color:red}.ImgOdpoved{-webkit-box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);}
</style>
<body style="margin-top:5%;" onLoad="disableClick()">
<form id="regForm" action="action.php?otazek=<?php echo $kvizovychotazek;?>" method="POST">
  <h1>Znalostní kvíz (<?php echo $kvizovychotazek; ?> otázek):</h1>
  <br /><a href="index.php">Domů</a>&nbsp; &nbsp; &nbsp; <a href="kviz.php">Kvíz s výchozím počtem otázek (20)</a>&nbsp; &nbsp; &nbsp; <a href="action.php">Výsledky</a>&nbsp; &nbsp; &nbsp; <a class="a2a_dd" href="https://www.addtoany.com/share">Sdílet</a>
<script async src="https://static.addtoany.com/menu/page.js"></script>
  <div class="tab">Jméno:
    <p><input placeholder="Křestní jméno..." oninput="this.className = ''" name="fname" required="required"></p>
    <p><input placeholder="Příjmení..." oninput="this.className = ''" name="lname" required="required"></p>
<?php
$sqlpocty = "SELECT count(otazky.id) AS OtPocet, (SELECT COUNT(id) FROM `odpovedi` ORDER BY `id` DESC LIMIT 1) AS OdPocet, (SELECT COUNT(id) FROM `kategorie` ORDER BY `id` DESC LIMIT 1) AS KatPocet FROM otazky ORDER BY `otazky`.`id` DESC LIMIT 1";
$poctysql = mysqli_query($mysqli, $sqlpocty);
if (mysqli_num_rows($poctysql)>0) {
    while($rowpocty = mysqli_fetch_assoc($poctysql)) {
      $pocetotazek = $rowpocty['OtPocet'];
      $pocetodpovedi = $rowpocty['OdPocet'];
      $pocetkategorii = $rowpocty['KatPocet'];
    }
}
echo "    <p>Počet všech otázek: ".$pocetotazek."<br />\r\n       Počet všech kategorií: ".$pocetkategorii."<br />\r\n       Počet všech odpovědí: ".$pocetodpovedi."<br />\r\n    </p>\r\n";
?>
    <p></p>
  </div>
<?php
$MalaUnicodeDiakritika = array("ě", "š", "č", "ř", "ž", "ý", "á", "í", "é", "ú", "ů", "ť", "ň", "ď", "ä", "ó", "ö", "ō", "ü");
$VelkaUnicodeDiakritika = array("Ě", "Š", "Č", "Ř", "Ž", "Ý", "Á", "Í", "É", "Ú", "Ů", "Ť", "Ň", "Ď", "Ä", "Ó", "Ö", "Ō", "Ü");
$sql = "SELECT DISTINCTROW otazky.id, otazky.otazka, otazky.spravna, kategorie.nazev FROM otazky INNER JOIN kategorie ON otazky.kategorie = kategorie.id ORDER BY RAND() ASC LIMIT ".$kvizovychotazek;
//$sql = "SELECT DISTINCTROW otazky_copy1.id, otazky_copy1.otazka, otazky_copy1.spravna, kategorie.nazev FROM otazky_copy1 INNER JOIN kategorie ON otazky_copy1.kategorie = kategorie.id ORDER BY RAND() ASC LIMIT ".$kvizovychotazek;
$resultsql = mysqli_query($mysqli, $sql);
$navigace = "";
$htmldiv = "";
if (mysqli_num_rows($resultsql)>0) {
  $j = 0;
  while($rowotazky = mysqli_fetch_assoc($resultsql)) {
    $j = $j + 1;
    $idotazky = $rowotazky['id'];
    $i = $idotazky;
    $txtotazky = $rowotazky['otazka'];
    $idspravneodpovedi = $rowotazky['spravna'];
    $kategorieotazky = $rowotazky['nazev'];
    $navigace .= "<span class=\"step\" style=\"color:#FFFFFF;\"></span>\r\n<span class=\"step\"></span>\r\n";
    $htmldiv .= "<div class=\"tab\">".$txtotazky."<br /><span style=\"font-size:14px;\">(Otázka z kategorie: ".$kategorieotazky.")</span>\r\n   <p>\r\n";
    $sqlodpovedi = "SELECT * FROM `odpovedi` WHERE `otazka`=".$idotazky." ORDER BY RAND() ASC";
    //$sqlodpovedi = "SELECT * FROM `odpovedi_copy1` WHERE `otazka`=".$idotazky." ORDER BY RAND() ASC";
    $resultsqlodpovedi = mysqli_query($mysqli, $sqlodpovedi);
    if($j=$kvizovychotazek){
      $htmldivVyhodnotit = '<br /><br /><input type="submit" style="text-align:center;width:140px;background-color:#04AA6D;color:#FFFFFF;border:none;padding:10px 20px;font-size:17px;font-family:Raleway;cursor:pointer;" value="Vyhodnotit">';
    }
    if (mysqli_num_rows($resultsqlodpovedi)>0) {
      $htmldiv .= "      <table style=\"width:80%;margin:auto;border:solid,#cccccc,1px\">\r\n         <tr><td>\r\n";
      $scriptdiv = "   <script>";
      while($rowodpovedi = mysqli_fetch_assoc($resultsqlodpovedi)) {
        $idodpovedi = $rowodpovedi['id'];
        $txtodpovedi = dequote($rowodpovedi['odpoved']); //odstraneni apostrofu
        $idotazky = $rowodpovedi['otazka'];
        $boduzaodpoved = $rowodpovedi['bodu'];
        $noteodpovedi = $rowodpovedi['note'];                
        $htmldiv .= "            <input type=\"radio\" name=\"".$i."\" id=\"".$idodpovedi."\" value=\"".$idodpovedi."\" required title=\"Vyberte právě jednu možnost\"><br /><label for=\"".$idodpovedi."\">".$txtodpovedi."</label><br /><br />\r\n";
        $scriptdiv .= " var str = '".strtoupper(str_replace($MalaUnicodeDiakritika, $VelkaUnicodeDiakritika, $txtodpovedi))."'; var b64 = utoa(str); ";
        if($boduzaodpoved == 1){
            $spravnaodpoved = strtoupper(str_replace($MalaUnicodeDiakritika, $VelkaUnicodeDiakritika, $txtodpovedi));
          if($rowodpovedi['obrazek'] === null || $rowodpovedi['obrazek'] === ''){
            $obrazekodpovedi = "<img class=\"ImgOdpoved\" src=\"images/missing-image.png\" style=\"width:auto;height:300px;\" height=\"300\" alt=\"".$txtodpovedi."\">";
          } else {
            $obrazekodpovedi = "<img class=\"ImgOdpoved\" src=\"".$rowodpovedi['obr1']."\" style=\"width:auto;height:300px;\" height=\"300\" alt=\"".$txtodpovedi."\">";
          }
          $scriptdiv .= "var img = '".$obrazekodpovedi."'; var imgb64 = utoa(img);";
          $scriptdiv .= ' document.getElementById("odpoved'.$idotazky.'").innerHTML = atou(b64);';
          $scriptdiv .= ' document.getElementById("imgodpoved'.$idotazky.'").innerHTML = atou(imgb64);';
        } else {
          $obrazekodpovedi = "<img class=\"ImgOdpoved\" src=\"".$rowodpovedi['obr1']."\" style=\"width:auto;height:300px;\" height=\"300\" alt=\"".$txtodpovedi."\">";
          $scriptdiv .= " /*var img = '".$obrazekodpovedi."'; var imgb64 = utoa(img);";
          $scriptdiv .= ' document.getElementById("odpoved'.$idotazky.'").innerHTML = atou(b64);';
          $scriptdiv .= ' document.getElementById("imgodpoved'.$idotazky.'").innerHTML = atou(imgb64);*/';
        }
      }
      $scriptdiv .= " </script>\r\n";
      $htmldiv .= "         </td></tr>\r\n      </table>\r\n   </p>\r\n";
      $htmldiv .= "</div>\r\n";
      $htmldiv .= "<div class=\"tab\">\r\n   <br />\r\n   <span id=\"odpoved".$i."\" class=\"odpoved\"></span>\r\n   <p style=\"margin-bottom:20px;\">\r\n      <br />\r\n   <span id=\"imgodpoved".$idotazky."\"></span>\r\n      <br />\r\n   </p>\r\n".$scriptdiv."</div>\r\n";
    }
  }
}
echo $htmldiv;
?>
  <div style="overflow:auto;margin-right: auto;margin-left:auto;border:none;">
    <div style="margin-left:auto;margin-right:auto;">
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Další</button>
    </div>
  </div>
  <div style="text-align:center;margin-top:40px;">
    <?php
    echo $navigace;
    ?>
  </div>
  <input type="submit" style="cursor: pointer;margin-top:100px;background-color: #2e68e2;color: #ffffff;border: none;padding: 10px 20px;font-size: 17px;font-family: Raleway;width:250px;" value="Mám vyplněno, vyhodnotit">  
  </form>
  <div>
  </div>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {   // This function will display the specified tab of the form...  
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Dokončit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Další";
  }
  fixStepIndicator(n)
}

function nextPrev(n) {  // This function will figure out which tab to display  
  var x = document.getElementsByClassName("tab");
  if (n == 1 && !validateForm()) return false;  // Exit the function if any field in the current tab is invalid:  
  x[currentTab].style.display = "none"; // Hide the current tab:
  currentTab = currentTab + n;     // Increase or decrease the current tab by 1:
  if (currentTab >= x.length) {    // if you have reached the end of the form...
    document.getElementById("regForm").submit();    // ... the form gets submitted:
    return false;
  }  
  showTab(currentTab);  // Otherwise, display the correct tab:
}

function validateForm() {   // This function deals with validation of the form fields  
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");  
  for (i = 0; i < y.length; i++) {  // A loop that checks every input field in the current tab:    
    if (y[i].value == "") {     // If a field is empty...      
      y[i].className += " invalid";     // add an "invalid" class to the field:      
      valid = false;    // and set the current valid status to false
    }
  }
  if (valid) {  // If the valid status is true, mark the step as finished and valid:
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {  // This function removes the "active" class of all steps...  
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }  
  x[n].className += " active";  //... and adds the "active" class on the current step:
}

function toggler(divId) {
    $("#" + divId).toggle();
}
</script>
</body>
</html>