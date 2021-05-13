<?php
require_once '../sistem/fonksiyon.php';
if($_POST){
    $ad     =post('adsoyad');
    $eposta     =post('eposta');
    $website     =post('website');
    $yorum     =post('yorum');
    $yaziid     =post('yaziid');

    if(!$ad || !$eposta || !$yorum){
        echo "bos";
    }else{
        if(!filter_var($eposta,FILTER_VALIDATE_EMAIL)){
            echo "format";
        }else{
            $kaydet = $db->prepare("INSERT INTO yorumlar SET
            yorum_yazi_id   = :i,
            yorum_isim      = :k,
            yorum_eposta    = :e,
            yorum_icerik    = :m,
            yorum_website   = :w,
            yorum_ip              = :ip
            ");
            $kaydet->execute([
                ':i' => $yaziid,
                ':k' => $ad,
                ':e' => $eposta,
                ':m' => $yorum,
                ':w' => $website,
                ':ip' => IP(),

            ]);
            if($kaydet){
                echo "basarili";
            }else{
                echo "hata";
            }
        }
    }

}
?>