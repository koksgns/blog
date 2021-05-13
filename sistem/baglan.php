<?php
ob_start();
/*
try {
    $db = new PDO("mysql:host=localhost;dbname=koksgnsblog;charset=utf8;","root","");
    $db->query("SET CHARSET SET UTF8");
    $db->query("SET NAMES UTF8");
} catch (\Throwable $th) {
    echo $hata -> getMessage();
}
*/
try {
    $db = new PDO("mysql:host=localhost;dbname=u278945138_koksgns;charset=utf8;","u278945138_koksgns","rinY#13IF0koksgns");
    $db->query("SET CHARSET SET UTF8");
    $db->query("SET NAMES UTF8");
} catch (\Throwable $th) {
    echo $hata -> getMessage();
}
##Ayarlar Tablosuna bağlantı
$ayarlar = $db->prepare("SELECT * FROM ayarlar");
$ayarlar->execute();
$arow   =   $ayarlar->fetch(PDO::FETCH_OBJ);
$site           =   $arow->site_url;
$sitebaslik     =   $arow->site_baslik;
$logo           =   $arow->site_logo;
$favicon        =   $arow->site_favicon;
$sitekeyw       =   $arow->site_keyw;
$sitedesc       =   $arow->site_desc;
$haritadurum    =   $arow->site_harita_durum;




if($arow->site_durum != 1){
    header("Location:bakimmodu.php");
}

?>