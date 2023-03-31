<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="images/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
#div,.odpoved{font-family:Verdana;color:#00f}input,select{padding:10px;width:30%;border:1px solid #aaa}#div,.tab{display:none}.tab,body,h1,td,tr{text-align:center}#div{background:#3bb300;height:100px;width:200px;padding:15px;font-size:20px}#regForm{-webkit-box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);background-color:#fff;}.tab{background-color:#fff}.odpoved{font-size:30px;padding:20px}body{background:#2fcec7;background:-moz-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:-webkit-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:radial-gradient(ellipse at center,#2fcec7 0,#3e80a4 50%,#215ac5 100%)}#regForm{margin:100px auto;font-family:Raleway;padding:40px;width:70%;min-width:300px;opacity:.9}h1{font-size:55px}button,input,select{font-size:17px;font-family:Raleway}select{background:#67a6eb;margin-bottom:20px}.step.finish,button{background-color:#04aa6d}input.invalid{background-color:#fdd}.tab{margin-top:100px}#prevBtn,.step{background-color:#bbb}button{color:#fff;border:none;padding:10px 20px;cursor:pointer}button:hover{opacity:.8}.step{height:15px;width:15px;margin:0 2px;border:none;border-radius:50%;display:inline-block;opacity:.5}.step.active{opacity:1}table{border:1px solid #ccc;margin-top:30px}td,tr{padding:30px}input[type=text],textarea{background-color:red}a:active,a:link,a:visited{color:#00f}a:hover{color:red}
</style>
<body style="margin-top:5%;">
<form id="regForm" action="kviz.php" method="post">
<h1>Znalostní kvíz:</h1>
<br /><a href="index.php">Domů</a>&nbsp; &nbsp; &nbsp; <a href="kviz.php">Kvíz s výchozím počtem otázek (20)</a>&nbsp; &nbsp; &nbsp; <a href="action.php">Výsledky</a>&nbsp; &nbsp; &nbsp; <a class="a2a_dd" href="https://www.addtoany.com/share">Sdílet</a>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<div class="tab">
<?php
$sqlpocetotazek = "SELECT DISTINCT COUNT(`otazka`) AS k FROM `otazky`";
$pocetotazeksql = mysqli_query($mysqli, $sqlpocetotazek);
if (mysqli_num_rows($pocetotazeksql)>0) {
  while($rowpocetotazek = mysqli_fetch_assoc($pocetotazeksql)){
    $maxotazek = $rowpocetotazek['k'];
    $selectotazek = "Zkusím pokořit ostatní kvízem <input id=\"otazek\" name=\"otazek\" type=\"range\" value=\"20\" min=\"20\" max=\"".$maxotazek."\" step=\"1\" /> s <output id=\"value\"></output> otázkami.";
  }
}
echo $selectotazek;
$sqlpocty = "SELECT count(`otazky`.`id`) AS OtPocet, (SELECT COUNT(`id`) FROM `odpovedi` ORDER BY `id` DESC LIMIT 1) AS OdPocet, (SELECT COUNT(`id`) FROM `kategorie` ORDER BY `id` DESC LIMIT 1) AS KatPocet FROM `otazky` ORDER BY `otazky`.`id` DESC LIMIT 1";
$poctysql = mysqli_query($mysqli, $sqlpocty);
if (mysqli_num_rows($poctysql)>0) {
  while($rowpocty = mysqli_fetch_assoc($poctysql)) {
    $pocetotazek = $rowpocty['OtPocet'];
    $pocetodpovedi = $rowpocty['OdPocet'];
    $pocetkategorii = $rowpocty['KatPocet'];
  }
}
echo "<p><br /><h2>Statistiky počtu otázek k použití:</h2>Počet všech otázek: ".$pocetotazek."<br />\r\nPočet všech kategorií: ".$pocetkategorii."<br />\r\nPočet všech odpovědí: ".$pocetodpovedi."</p>";
?>
</div>
<div style="overflow:auto;margin-right: auto;margin-left:auto;border:none;"></div>
<div style="text-align:center;margin-top:40px;">
  <input type="submit" style="cursor: pointer;margin-top:100px;background-color: #2e68e2;color: #ffffff;border: none;padding: 10px 20px;font-size: 17px;font-family: Raleway;width:250px;" value="Jdu na to">  
</div>
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
<script>
  const value = document.querySelector("#value")
  const input = document.querySelector("#otazek")
  value.textContent = input.value
  input.addEventListener("input", (event) => {
  value.textContent = event.target.value
  })
</script>
</body>
</html>