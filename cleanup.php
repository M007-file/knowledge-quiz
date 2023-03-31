<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <style>
    table,td,th{border:1px solid;margin:auto;text-align:center}.vbunce,table,td,th{text-align:center}th{top:0;position:sticky;background:#e5d2f1;color:#000}body{background:#2fcec7;background:-moz-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:-webkit-radial-gradient(center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);background:radial-gradient(ellipse at center,#2fcec7 0,#3e80a4 50%,#215ac5 100%);text-align:center;margin-top:20%;}span{font-family:Verdana,Geneva,sans-serif;font-size:25px;letter-spacing:2px;word-spacing:2px;color:#FFFFFF;font-weight:400;text-decoration:none;font-style:normal;font-variant:normal;text-transform:none}a{color:#0044CC;text-decoration:none;}
    </style>
</head>
<body>
    <span>
<?php
if(!empty($_GET)) {
    $key = $_GET['pass'];
} else {
    $key = "";
}

switch ($key) {
    case "Xfu8nh?(zu3i}G:";
        require_once("config.php");
        $sqltruncate = "TRUNCATE TABLE `results`";
        //$truncatesql = mysqli_query($mysqli, $sqltruncate);
        echo "Výsledky byly odstraněny<br /><br /><a href=\"index.php\" style=\"text-color:#0044CC;font-size:22;\">Domů</a>\r\n";
        goto end;       
        break;
    case "":
    default:    
        echo "Ne, ne, pro přístup sem musíš zadat správný klíč!<br /><br /><a href=\"index.php\">Domů</a>\r\n";
        goto end;
        break;
}

warning:
echo "Nebyly splněny bezpečnostní podmínky pro zobrazení této stránky.";
end:

?></span>
</body>
</html>