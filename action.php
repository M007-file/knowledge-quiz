<?php
require_once("config.php");  
function kolikbodu($odpovedid, $mysqli){
    $sqlodpoved = "SELECT `bodu` FROM `odpovedi` WHERE `id` = '".$odpovedid."'";
    $resultsqlodpoved = mysqli_query($mysqli, $sqlodpoved);
    if (mysqli_num_rows($resultsqlodpoved)>0) {
        while($rowodpoved = mysqli_fetch_assoc($resultsqlodpoved)) {
            $bodu = $rowodpoved['bodu'];
            if(is_null($bodu)){
                $bodu = 0;
            }
        }
    }    
    return $bodu;
}

$re = "/[^a-zA-ZáéíóúýčďěňřšťžůõäöüőűíĺľôŕåâçîşûğÁÉÍÓÚÝČĎĚŇŘŠŤŽŮÕÄÖÜŐŰÍĹĽÔŔÅÂÇÎŞÛĞ\s]/";
$resultscore=0;
if(!empty($_POST)){
  foreach ($_POST as $key => $value) {
    if(intval($value)>0){
        $resultscore = $resultscore + kolikbodu($value, $mysqli);
    }      
  }
  $fullname_tmp = $_POST['fname']." ".$_POST['lname'];
  $fullname = ucwords(preg_replace($re, "", $fullname_tmp));
} else {
  $fullname = "John Doe I.";
  $resultscore = 0;
}
if(!empty($_GET['otazek'])){
  $pocetotazek = preg_replace('/\D/', '', $_GET['otazek']); //keps numbers only
  if($pocetotazek == ''){  //if value otazky did not contained any number
    $pocetotazek = 20;
  }
} else {  //if otazky variable was not set, assign 20 as value
  $pocetotazek = 20;
}
/*$pocetotazek=301;
$resultscore = 280;*/
$spatnychodpovedi = ($pocetotazek-$resultscore);    //$procent = (100*($pocetotazek-$spatnychodpovedi)/$pocetotazek) - pocitano v ulozene procedure "insertresult" v DB
$datetime = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="en"><head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="images/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<meta name="description" content="">
<title>Výsledek kvízu</title>
<link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Home.css" media="screen">
<script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
<script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
<link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">    
<meta name="theme-color" content="#0d244b">
<meta property="og:title" content="Home">
<meta property="og:type" content="website">
<meta data-intl-tel-input-cdn-path="intlTelInput/"></head>
<body data-home-page="Home.html" data-home-page-title="Home" class="u-body u-xl-mode" data-lang="en">
  <section class="skrollable u-align-center u-clearfix u-image u-parallax u-shading u-section-1" src="" data-image-width="5000" data-image-height="3000" id="sec-115c">
    <div class="u-clearfix u-sheet u-sheet-1">
      <?php
      $sqlrekordman = "SELECT * FROM `results` ORDER BY `procent` DESC, `otazek` DESC, `spravne` DESC, `date` ASC LIMIT 20";
      if(!empty($_POST)){  
        echo "<h1 class=\"u-text u-text-default u-title u-text-1\">Vaše celkové skóre je ".$resultscore." bodů.</h1>";
        if($resultscore == 0){
          echo "<h2 class=\"u-subtitle u-text u-text-default u-text-2\">No to snad ani ukládat nebudu.</h2><br />";
        } else {
          echo "<h2 class=\"u-subtitle u-text u-text-default u-text-2\">Gratulujeme</h2><br />";
          $sqlinsert = "CALL insertresult('".$fullname."', '".$pocetotazek."', '".$resultscore."', '".$spatnychodpovedi."')"; //stored procedure
          $resultsqlinsert = mysqli_query($mysqli, $sqlinsert);
          goto a;
        }
      } else {
        goto a;
      }
      a:
      $resultsqlrekordman = mysqli_query($mysqli, $sqlrekordman);
      if (mysqli_num_rows($resultsqlrekordman)>0) {
        $htmldiv = "<p><br /><br /></p>\r\n<p style=\"font-size:19px;color:#FFFFFF;font-weight:700;\">Aktuální pořadí rekordů Znalosntího kvízu. <br />Při stejném výsledku je lepším ten, kdo jej získal dříve.<br /><br /></p>\r\n<table style=\"width:80%;margin:auto;color:#FFFFFF;border:solid,#cccccc,1px\"><th>Jméno</th><th>Výsledek</th><th>Otázek</th><th>Správně</th><th>Datum a čas</th>\r\n";
        while($rowrekordmani = mysqli_fetch_assoc($resultsqlrekordman)) {
          $rekordman = $rowrekordmani['name'];
          $rekordprocent = $rowrekordmani['procent'];
          $rekorddatum = $rowrekordmani['date'];
          $rekordotazek = $rowrekordmani['otazek'];
          $rekordspravne = $rowrekordmani['spravne'];
          $htmldiv .= "<tr><td>".$rekordman."</td><td>".$rekordprocent." %</td><td>".$rekordotazek."</td><td>".$rekordspravne."</td><td>".$rekorddatum."</td></tr>\r\n";
        }
        $buttontext = "Chci to zkusit znovu";
        $htmldiv .= "</table>\r\n<p><br /><br /></p>";
        echo $htmldiv;
      } else {
        echo "<h1 class=\"u-text u-text-default u-title u-text-1\">Zatím tu nejsou žádné výsledky!</h1>\r\n";
        echo "<h2 class=\"u-subtitle u-text u-text-default u-text-2\">Pokud chcete vytvořit rekord, tak hurá na to!</h2><br />";
        $buttontext = "Chci to zkusit!";
      }
      ?>
      <a href="index.php" class="u-btn u-btn-round u-button-style u-hover-palette-2-base u-palette-3-base u-radius-1 u-btn-1"><span class="u-file-icon u-icon u-icon-1"></span>&nbsp;<?php echo $buttontext; ?></a>
    </div>
  </section>
  <section class="u-align-center u-clearfix u-palette-1-base u-section-2" id="sec-a1a3">
    <div class="u-expanded-width u-palette-3-base u-shape u-shape-rectangle u-shape-1"></div>
    <div class="u-clearfix u-gutter-20 u-layout-wrap u-layout-wrap-1">
      <div class="u-layout">
        <div class="u-layout-row">
          <div class="u-size-15 u-size-30-md">
            <div class="u-layout-col">
              <div class="u-container-style u-image u-layout-cell u-size-40 u-image-1" data-image-width="900" data-image-height="999">
                <div class="u-container-layout u-container-layout-1"></div>
              </div>
              <div class="u-container-style u-hidden-md u-hidden-sm u-hidden-xs u-layout-cell u-size-20 u-layout-cell-2" wfd-invisible="true">
                <div class="u-container-layout u-container-layout-2"></div>
              </div>
            </div>
          </div>
          <div class="u-size-15 u-size-30-md">
            <div class="u-layout-col">
              <div class="u-container-style u-hidden-md u-hidden-sm u-hidden-xs u-layout-cell u-size-20 u-layout-cell-3" wfd-invisible="true">
                <div class="u-container-layout u-container-layout-3"></div>
              </div>
              <div class="u-container-style u-image u-layout-cell u-size-40 u-image-2" data-image-width="900" data-image-height="694">
                <div class="u-container-layout u-container-layout-4"></div>
              </div>
            </div>
          </div>
          <div class="u-size-15 u-size-30-md">
            <div class="u-layout-col">
              <div class="u-container-style u-image u-layout-cell u-size-40 u-image-3" data-image-width="1200" data-image-height="1018">
                <div class="u-container-layout u-container-layout-5"></div>
              </div>
              <div class="u-container-style u-hidden-md u-hidden-sm u-hidden-xs u-layout-cell u-size-20 u-layout-cell-6" wfd-invisible="true">
                <div class="u-container-layout u-container-layout-6"></div>
              </div>
            </div>
          </div>
          <div class="u-size-15 u-size-30-md">
            <div class="u-layout-col">
              <div class="u-container-style u-hidden-md u-hidden-sm u-hidden-xs u-layout-cell u-size-20 u-layout-cell-7" wfd-invisible="true">
                <div class="u-container-layout u-container-layout-7"></div>
              </div>
              <div class="u-container-style u-image u-layout-cell u-size-40 u-image-4" data-image-width="600" data-image-height="784">
                <div class="u-container-layout u-container-layout-8"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> 
</body>
</html>