<?php
@session_start();
ob_start();
@date_default_timezone_get("Europe/Istanbul");

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


if(@$_SESSION['oturum'] == sha1(md5(@$_SESSION['id'].IP()))){
    $yoneticibul    =   $db->prepare("SELECT * FROM yoneticiler WHERE id=:id");
    $yoneticibul->execute([':id'=>@$_SESSION['id']]);
    if($yoneticibul->rowCount()){
        $row    =   $yoneticibul->fetch(PDO::FETCH_OBJ);
        $yid    =   $row->id;
        $ykadi  =   $row->kadi;
        $yposta =   $row->eposta;
        $yimg   =   $row->yimg;
    }
}

$ayarlar = $db->prepare("SELECT * FROM ayarlar");
$ayarlar->execute();
$arow   =   $ayarlar->fetch(PDO::FETCH_OBJ);
$site           =   $arow->site_url;
$sitebaslik     =   $arow->site_baslik;
$logo           =   $arow->site_logo;
$favicon        =   $arow->site_favicon;
$sitekeyw       =   $arow->site_keyw;
$sitedesc       =   $arow->site_desc;
$sitenick       =   $arow->site_nick;
$sitedurum       =   $arow->site_durum;
$yonetim    =   $site."/yonetim";

?>