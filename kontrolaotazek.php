<html>
    <head>
        <style>
        table, th, td {
           border: 1px solid;
           margin:auto;
           text-align:center;
        }
        th {
            top: 0;
            position: sticky;
            background: #e5d2f1;
            color: black;
            border: 1px solid;
            margin:auto;
            text-align:center;
        }
        .vbunce {
            text-align:center;
        }
        </style>
</head>
<body>
<?php
require_once("config.php");
$sqlotazky = "SELECT DISTINCTROW `otazky`.`id` As OtId, `kategorie`.`nazev`, `otazky`.`otazka` As OtOtazka, `odpovedi`.`otazka` As OdpOtazka, `odpovedi`.`bodu`, `odpovedi`.`id` As OdpoId, `odpovedi`.`odpoved` As OdpOdpoved, `odpovedi`.`obrazek` As OdpObrazek, `odpovedi`.`obr1` FROM	`kategorie`	INNER JOIN `otazky` ON `kategorie`.`id` = `otazky`.`kategorie` INNER JOIN `odpovedi` ON `otazky`.`id` = `odpovedi`.`otazka` WHERE `odpovedi`.`bodu`=1";
$otazkysql = mysqli_query($mysqli, $sqlotazky);
    if (mysqli_num_rows($otazkysql)>0) {
        echo "<table style=\"border:1px solid #cccccc\">\r\n<tr><th>ID Otázky</th><th>Kategorie Otázky</th><th>Text otázky</th><!--<th>Bodů</th>--><th>ID Odpovědi</th><th>Text odpovědi</th></tr>\r\n";
        while($rowotazky = mysqli_fetch_assoc($otazkysql)){
            $bodu = 0;
            $otid = $rowotazky['OtId'];
            $ototazka = $rowotazky['OtOtazka'];
            $otkategorie = $rowotazky['nazev'];
            $odpotazka = $rowotazky['OdpOtazka'];
            $bodu = $rowotazky['bodu'];
            $odpid = $rowotazky['OdpoId'];
            $odpodpoved = $rowotazky['OdpOdpoved'];
            if($bodu==0){
                $styling = "style=\"background:#ff8c00\"";
                $obrazek = "";
            } else {
                $styling = "style=\"background:#7fff00\"";
                $obrazek = "<img src=\"".$rowotazky['OdpObrazek']."\" style=\"width:300px;height:auto;\">";
            }
            if($rowotazky['obr1']==""){                
                $obr1 = "";
            } else {
                $obr1 = "<img src=\"".$rowotazky['obr1']."\" style=\"width:300px;height:auto;\">\r\n<br />".$rowotazky['obr1'];
            }
            echo "<tr><td ".$styling."><span class=\"vbunce\">".$otid."</span></td><td ".$styling.">".$otkategorie."</td><td ".$styling.">".$ototazka."</td><!--<td ".$styling.">".$bodu."</td>--><td ".$styling.">".$odpid."</td><td ".$styling.">".$odpodpoved."\r\n<br />".$obr1."</td></tr>\r\n";
        }
        echo "</table>\r\n";
    }
?>
</body>
</html>