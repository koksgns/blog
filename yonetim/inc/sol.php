<?php
echo !defined("yonetimguvenlik") ? die() : null;
?>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="50" height="50" src="<?php echo $yonetim;?>/images/<?php echo $yimg;?>" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo $ykadi; ?></p>
            <p class="app-sidebar__user-designation">Yönetici</p>
        </div>
    </div>
    <ul class="app-menu">
        <li>
            <a class="app-menu__item <?php if(loc() == $yonetim."/index.php"){ echo "active"; } ?>" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Ana Sayfa</span></a>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/kategoriler.php' || loc() == $yonetim.'/islemler.php?islem=yenikategori' || loc() == $yonetim.'/islemler.php?islem=kategoriduzenle&id='.@$_GET['id'] ||  loc() == $yonetim.'/islemler.php?islem=kategorisil&id='.@$_GET['id']  ){ echo "is-expanded"; } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Kategoriler</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/kategoriler.php"><i class="icon fa fa-circle-o"></i> Kategori Listesi ( <?php echo say("kategoriler"); ?> )</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=yenikategori"><i class="icon fa fa-circle-o"></i> Yeni Kategori Ekle</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/konular.php' || loc() == $yonetim.'/islemler.php?islem=yenikonuekle' ||loc() == $yonetim.'/yaziara.php?q='.@$_GET['q'] ||loc() == $yonetim.'/yaziara.php?q='.@$_GET['q'].'&s='.@$_GET['s'] || loc() == $yonetim.'/islemler.php?islem=yaziduzenle&id='.@$_GET['id'] ||  loc() == $yonetim.'/islemler.php?islem=yazisil&id='.@$_GET['id'] ){ echo "is-expanded"; } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Yazılar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/konular.php"><i class="icon fa fa-circle-o"></i> Yazı Listesi ( <?php echo say("yazilar") ?> )</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=yenikonuekle"><i class="icon fa fa-circle-o"></i> Yeni Yazı Ekle</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/onayliyorumlar.php' || loc() == $yonetim.'/bekleyenyorumlar.php' || loc() == $yonetim.'/islemler.php?islem=yorumoku&id='.@$_GET['id']  ||  loc() == $yonetim.'/islemler.php?islem=yorumsil&id='.@$_GET['id'] ){ echo "is-expanded"; } ?> "><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label">Yorumlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/onayliyorumlar.php"><i class="icon fa fa-circle-o"></i> Onaylı Yorumlar ( <?php echo say("yorumlar" , "yorum_durum" , 1); ?> )</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/bekleyenyorumlar.php"><i class="icon fa fa-circle-o"></i> Onay Bekleyen Yorumlar ( <?php echo say("yorumlar" , "yorum_durum" , 0); ?> )</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/okunmusmesajlar.php' || loc() == $yonetim.'/bekleyenmesajlar.php' || loc() == $yonetim.'/islemler.php?islem=mesajoku&id='.@$_GET['id']||  loc() == $yonetim.'/islemler.php?islem=mesajsil&id='.@$_GET['id'] ){ echo "is-expanded"; } ?> "><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Mesajlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/okunmusmesajlar.php"><i class="icon fa fa-circle-o"></i> Okunmuş Mesajlar ( <?php echo say("mesajlar" , "durum" , 1); ?> )</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/bekleyenmesajlar.php"><i class="icon fa fa-circle-o"></i> Yeni Mesajlar ( <?php echo say("mesajlar" , "durum" , 0); ?> )</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/sosyalmedya.php' || loc() == $yonetim.'/islemler.php?islem=yenisosyalmedya' || loc() == $yonetim.'/islemler.php?islem=sosyalmedyaduzenle&id='.@$_GET['id']||  loc() == $yonetim.'/islemler.php?islem=sosyalmedyasil&id='.@$_GET['id'] ){ echo "is-expanded"; } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-facebook-square"></i><span class="app-menu__label">Sosyal Medya</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/sosyalmedya.php"><i class="icon fa fa-circle-o"></i> Sosyal Medya Listesi ( <?php echo say("sosyalmedya" ); ?> )</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=yenisosyalmedya"><i class="icon fa fa-circle-o"></i> Yeni Sosyal Medya Ekle</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/aboneler.php' || loc() == $yonetim.'/islemler.php?islem=abonesil' ){ echo "is-expanded"; } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Aboneler</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/aboneler.php"><i class="icon fa fa-circle-o"></i> Abone Listesi ( <?php echo say("aboneler"); ?> )</a></li>

            </ul>
        </li>

        <li class="treeview <?php if(loc() == $yonetim.'/islemler.php?islem=genel' || loc() == $yonetim.'/islemler.php?islem=iletisim' || loc() == $yonetim.'/islemler.php?islem=logo' || loc() == $yonetim.'/islemler.php?islem=favicon' || loc() == $yonetim.'/islemler.php?islem=dogrulama' ){ echo 'is-expanded'; } ?>"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Ayarlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=genel"><i class="icon fa fa-circle-o"></i> Genel Ayarlar</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=iletisim"><i class="icon fa fa-circle-o"></i> İletişim Ayarları</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=logo"><i class="icon fa fa-circle-o"></i> Logo Ayarları</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=favicon"><i class="icon fa fa-circle-o"></i> Favicon Ayarları</a></li>
                <li><a class="treeview-item" href="<?php echo $yonetim;?>/islemler.php?islem=dogrulama"><i class="icon fa fa-circle-o"></i> Doğrulama Ayarları</a></li>

            </ul>
        </li>


    </ul>
</aside>