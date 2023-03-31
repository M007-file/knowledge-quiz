<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/x-icon" href="images/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
#div,.odpoved{font-family:Verdana;color:#00f}input,select{padding:10px;width:30%;border:1px solid #aaa}#div,.tab{display:none}.tab,body,h1,td,tr{text-align:center}#div{background:#3bb300;height:100px;width:200px;padding:15px;font-size:20px}#regForm{-webkit-box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);background-color:#fff;}.tab{background-color:#fff;}.odpoved{font-size:30px;padding:20px}body{background:#2fcec7;background:-moz-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:-webkit-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:radial-gradient(ellipse at center,#2fcec7 0,#3e80a4 50%,#215ac5 100%)}#regForm{margin:100px auto;font-family:Raleway;padding:40px;width:70%;min-width:300px;opacity:.9}h1{font-size:55px}button,input,select{font-size:17px;font-family:Raleway}select{background:#67a6eb;margin-bottom:20px}.step.finish,button{background-color:#04aa6d}input.invalid{background-color:#fdd}.tab{margin-top:100px}#prevBtn,.step{background-color:#bbb}button{color:#fff;border:none;padding:10px 20px;cursor:pointer}button:hover{opacity:.8}.step{height:15px;width:15px;margin:0 2px;border:none;border-radius:50%;display:inline-block;opacity:.5}.step.active{opacity:1}table{border:1px solid #ccc;margin-top:30px}td,tr{padding:30px}input[type=text],textarea{background-color:red}a:active,a:link,a:visited{color:#00f}a:hover{color:red}.ImgOdpoved{-webkit-box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);box-shadow: 5px 5px 30px 2px rgba(0,0,0,0.58);}table,td,th{border:1px solid;margin:auto;text-align:center}.vbunce,table,td,th{text-align:center}th{top:0;position:sticky;background:#e5d2f1;color:#000}.access{font-family:Verdana,Geneva,sans-serif;font-size:25px;letter-spacing:2px;word-spacing:2px;color:#FFFFFF;font-weight:400;text-decoration:none;font-style:normal;font-variant:normal;text-transform:none;margin-top:80px;}a{text-decoration:none;}
</style>
<body>
<?php
if(!empty($_GET)) {
    $key = $_GET['pass'];
} else {
    $key = "";
}

switch ($key) {
    case "":
    default:    
        echo "<span style=\"font-family:Verdana,Geneva,sans-serif;font-size:25px;letter-spacing:2px;word-spacing:2px;color:#FFFFFF;font-weight:400;text-decoration:none;font-style:normal;font-variant:normal;text-transform:none;position: relative;top: 40%;\">Ne, ne, pro přístup sem musíš zadat správný klíč!<br /></span>\r\n";
        break;
    case "Xfu8nh?(zu3i}G:";
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
                    $odpotazka = ucfirst($rowotazky['OdpOtazka']);
                    $bodu = $rowotazky['bodu'];
                    $odpid = $rowotazky['OdpoId'];
                    $odpodpoved = ucfirst($rowotazky['OdpOdpoved']);
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
            goto end;       
        break;
}

warning:
echo "<span style=\"font-family:Verdana,Geneva,sans-serif;font-size:25px;letter-spacing:2px;word-spacing:2px;color:#FFFFFF;font-weight:400;text-decoration:none;font-style:normal;font-variant:normal;text-transform:none;position: relative;top: 40%;\">Nebyly splněny bezpečnostní podmínky pro zobrazení této stránky.<br /><br /><a href=\"index.php\">Domů</a></span>\r\n";
end:
?>
</body>
</html>