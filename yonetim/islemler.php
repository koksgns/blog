<?php 
define("yonetimguvenlik",true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> İşlemler</h1>
          <p>İşlem Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">İşlemler</li>
          <li class="breadcrumb-item active"><a href="#">İşlem Listesi</a></li>
        </ul>
      </div>
      <div class="row">

        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile"> 
            <?php
              if(@$_SESSION['oturum'] == sha1(md5($yid.IP()))){
                $islem  = @get('islem');
                if(!$islem){
                  header('Location:'.$yonetim);
                }

                switch($islem){
                  case 'kategorisil':
                    echo '<h3 class="tile-title">Kategori Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/kategoriler.php");
                    }
                    $kategorisil = $db->prepare("DELETE FROM kategoriler WHERE id = :id");
                    $kategorisil->execute([':id'=>$id]);
                    if($kategorisil){
                      $yazipasif=$db->prepare("UPDATE yazilar SET yazi_durum=:d WHERE yazi_kat_id=:id");
                      $yazipasif->execute([':d'=>0,':id'=>$id]);
                      basarili('Kategori başarıyla silindi ve bu kategoriye ait bütün yazıların durumu pasif hale getirildi.');
                      header('Refresh:3;url='.$yonetim."/kategoriler.php");
                    }else{
                      hata('Kategori silme sırasında hata oluştu');
                    }
                  break;

                  case 'mesajsil':
                    echo '<h3 class="tile-title">Mesaj Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/okunmusmesajlar.php");
                    }
                    $mesajsil = $db->prepare("DELETE FROM mesajlar WHERE id = :id");
                    $mesajsil->execute([':id'=>$id]);
                    if($mesajsil){
                      basarili('Mesaj başarıyla silindi.');
                      header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                    }else{
                      hata('Mesaj silme sırasında hata oluştu');
                    }
                  break;

                  case 'yorumsil':
                    echo '<h3 class="tile-title">Yorum Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/bekleyenyorumlar.php");
                    }
                    $yorumsil = $db->prepare("DELETE FROM yorumlar WHERE id = :id");
                    $yorumsil->execute([':id'=>$id]);
                    if($yorumsil){
                      basarili('Yorum başarıyla silindi.');
                      header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                    }else{
                      hata('Yorum silme sırasında hata oluştu');
                    }
                  break;

                  case 'sosyalmedyasil':
                    echo '<h3 class="tile-title">Sosyal Medya Hesabı Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/sosyalmedya.php");
                    }
                    $sosyalmedyasil = $db->prepare("DELETE FROM sosyalmedya WHERE id = :id");
                    $sosyalmedyasil->execute([':id'=>$id]);
                    if($sosyalmedyasil){
                      basarili('Sosyal medya hesabını başarıyla silindi.');
                      header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                    }else{
                      hata('Sosyal medya hesabını silme sırasında hata oluştu');
                    }
                  break;

                  case 'yazisil':
                    echo '<h3 class="tile-title">Yazı Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/konular.php");
                    }

                    $yazibul  = $db->prepare("SELECT * FROM yazilar Where yazi_id=:id");
                    $yazibul->execute([":id"=>$id]);
                    if($yazibul->rowCount()){
                      $yazirow  = $yazibul->fetch(PDO::FETCH_OBJ);
                      $yazisil = $db->prepare("DELETE FROM yazilar WHERE yazi_id = :id");
                      $yazisil->execute([':id'=>$id]);
                      if($yazisil){
                        $yorumlarisil = $db->prepare("DELETE FROM yorumlar WHERE yorum_yazi_id=:id");
                        $yorumlarisil->execute([':id'=>$id]);

                        unlink("../images/".$yazirow->yazi_resim);

                        basarili('Yazı başarıyla silindi.');
                        header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                      }else{
                        hata('Yazo silme sırasında hata oluştu');
                      }

                    }
                  break;

                  case 'abonesil':
                    echo '<h3 class="tile-title">Abone Sil </h3> ';
                    $id=get('id');
                    if (!$id) {
                      header('Location:'.$yonetim."/aboneler.php");
                    }
                    $abonesil = $db->prepare("DELETE FROM aboneler WHERE id = :id");
                    $abonesil->execute([':id'=>$id]);
                    if($abonesil){
                      basarili('Abone başarıyla silindi.');
                      header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                    }else{
                      hata('Abone silme sırasında hata oluştu');
                    }
                  break;

                  case 'yenikategori':
                    echo '<h3 class="tile-title">Yeni Kategori Ekle </h3> ';
                    if(isset($_POST['kategoriekle'])){
                      $katadi  = post('katadi');
                      $katsef  = sef_link($katadi);
                      $katkeyw = post('kaytKeyw');
                      $katdesc = post('katdesc');

                      if(!$katadi || !$katdesc || !$katkeyw){
                        hata('Boş alan bırakmayınız');
                      }else{
                        $varmi = $db->prepare("SELECT * FROM kategoriler WHERE kat_sef =:s");
                        $varmi->execute([':s'=> $katsef]);
                        if ($varmi->rowCount()) {
                          hata("Bu kategori zaten kayıtlı");
                        }else{
                          $kategoriEkle= $db->prepare("INSERT INTO kategoriler SET kat_adi=:adi, kat_sef=:sef, kat_keyw=:keyw, kat_desc=:descc");
                          $kategoriEkle->execute([':adi'=>$katadi,'sef'=>$katsef,'keyw'=>$katkeyw,'descc'=>$katdesc]);
                          if($kategoriEkle->rowCount()){
                            basarili('Kategori başarıyla eklendi');
                            header('Refresh:3;url='.$yonetim."/kategoriler.php");
                          }else{
                            hata('Hata oluştu');
                          }
                        }
                      }
                    }
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Adı</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="katadi" placeholder="Kategori Adı Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Anahtar Kelimeler</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="kaytKeyw" placeholder="Kategori Anahtar Kelimeler Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Açıklaması</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="katdesc" placeholder="Kategori Açıklaması Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="kategoriekle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kategori Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/kategoriler.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;
                  
                  case 'yenisosyalmedya':
                    echo '<h3 class="tile-title">Yeni Sosyal Medya Ekle </h3> ';
                    if(isset($_POST['sosyalmedyaekle'])){
                      $ikon  = post('ikon');
                      $link = post('link');

                      if(!$ikon || !$link ){
                        hata('Boş alan bırakmayınız');
                      }else{
                        
                          $SosyalMedyaEkle= $db->prepare("INSERT INTO sosyalmedya SET ikon=:ik, link=:lk");
                          $SosyalMedyaEkle->execute([':ik'=>$ikon,':lk'=>$link]);
                          if($SosyalMedyaEkle->rowCount()){
                            basarili('Sosyal Medya hesabı başarıyla eklendi');
                            header('Refresh:3;url='.$yonetim."/sosyalmedya.php");
                          }else{
                            hata('Hata oluştu');
                          }
                        
                      }
                    }
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Sosyal Medya İkon</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="ikon" placeholder="Sosyal Medya İkonunu Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Sosyal Medya Link</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="link" placeholder="Sosyal Medya Linkini Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="sosyalmedyaekle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sosyal Medya Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/sosyalmedya.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'yenikonuekle':
                    echo '<h3 class="tile-title">Yeni Yazı Ekle </h3> ';

                    if(isset($_POST['yeniyaziekle'])){
                      require 'inc/class.upload.php';

                      $baslik = post('baslik');
                      $sef_baslik = sef_link($baslik);
                      $kategori = post('kategoriler');
                      $icerik = $_POST['icerik'];
                      $etiketler=post('etiketler');

                      if(!$baslik || !$kategori || !$icerik || !$etiketler){
                        hata('Boş alan bırakmayaınız');
                      }else{
                        $sefetiket=explode(',',$etiketler);
                        $dizi=array();
                        foreach ($sefetiket as $parcala) {
                          $dizi[]=sef_link($parcala);
                        }
                        $deger = implode(',',$dizi);
                        $image= new Upload($_FILES['resim']);
                        if($image->uploaded){
                          $rname=md5(uniqid());
                          $image->allowed=array('image/*');
                          $image->image_convert = "webp";
                          $image->file_new_name_body = $rname;
                          $image->image_text= $sitenick." | ".$site;
                          $image->image_text_position = "BR";
                          $image->process("../images");
                          if($image->processed){
                            $konuekle=$db->prepare("INSERT INTO yazilar SET yazi_baslik=:b,yazi_sef=:s,yazi_kat_id=:k,yazi_resim=:r,yazi_icerik=:i,yazi_etiketler=:e,yazi_sef_etiketler=:se");
                            $konuekle->execute([':b'=>$baslik,':s'=>$sef_baslik,':k'=>$kategori,':r'=>$rname.".webp",':i'=>$icerik,':e'=>$etiketler,':se'=>$deger]);
                            if($konuekle->rowCount()){
                              
                              /*
                              $sonid=$db->lastInsertId();
                              $aboneler= $db->prepare("SELECT * FROM aboneler");
                              $aboneler->execute();
                              if($aboneler->rowCount()){
                                foreach ( $aboneler as $abone){
                                  echo $abone['abone_mail'];
                                  echo "<br>";
                                  $mail->AddBCC($abone['abone_mail']);
                                }
                              }                              
                              $konubul = $db->prepare("SELECT * FROM yazilar WHERE yazi_id=:id");
                              $konubul->execute([':id'=>$sonid]);
                              $konurow = $konubul->fetch(PDO::FETCH_OBJ);
                              
                              $siteLink =$site."/yazidetay.php?yazi_sef=".$konurow->yazi_sef."&id=".$konurow->yazi_id;                              
                              $mailicerik = "Konu Başlığı: ".$konurow->yazi_baslik."| Konu linki: ".$siteLink;
                              */

                              basarili("Konu başarıyla eklendi");
                              header('Refresh:3;url'.$yonetim.'/konular.php');
                            }else{
                              hata('Konu eklenirken hata oluştu');
                            }
                          }else{
                            hata('Resim yüklenemedi');
                          }
                        }else{
                          hata('Resim seçmediniz.');
                        }
                      }
                    }
                   
                    ?>
                      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yazı Başlık</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="baslik" placeholder="Yazı Başlık Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yazı Kategori</label>
                              <div class="col-md-8">
                                <select name="kategoriler" class="form-control">
                                  <?php
                                    $kategoriler = $db->prepare("SELECT * FROM kategoriler");
                                    $kategoriler->execute();
                                    if($kategoriler->rowCount()){
                                      foreach ($kategoriler as $row) {
                                        echo '<option value="'.$row['id'].'">'.$row['kat_adi'].'</option>';
                                      }
                                    }
                                  ?>
                                </select> 
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yazı Resim</label>
                              <div class="col-md-8">
                                <input class="form-control" type="file" name="resim">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yazı İçerik</label>
                              <div class="col-md-8">
                                <textarea name="icerik" class="ckeditor" cols="30" rows="10"></textarea>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yazı Etiketler</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="etiketler" placeholder="Yazı Etiketlerini ARalarında Virgül Kullanarak Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="yeniyaziekle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Yeni Yazı Ekle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/konular.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'yaziduzenle':
                      $id = get("id");
                      if(!$id){
                        header('Location:'.$yonetim."/konular.php");
                      }
                      $yazibul = $db->prepare("SELECT * FROM yazilar WHERE yazi_id=:id");
                      $yazibul->execute([":id"=>$id]);
                      if($yazibul->rowCount()){
                        $yazirow  = $yazibul->fetch(PDO::FETCH_OBJ);

                        if(isset($_POST['yaziguncelle'])){
                          require 'inc/class.upload.php';
    
                          $baslik = post('baslik');
                          $sef_baslik = sef_link($baslik);
                          $kategori = post('kategoriler');
                          $icerik = $_POST['icerik'];
                          $etiketler=post('etiketler');
                          $durum=post('durum');
    
                          if(!$baslik || !$kategori || !$icerik || !$etiketler || !$durum){
                            hata('Boş alan bırakmayaınız');
                          }else{
                            $sefetiket=explode(',',$etiketler);
                            $dizi=array();
                            foreach ($sefetiket as $parcala) {
                              $dizi[]=sef_link($parcala);
                            }
                            $deger = implode(',',$dizi);
                            $image= new Upload($_FILES['resim']);
                            if($image->uploaded){
                              $rname=md5(uniqid());
                              $image->allowed=array('image/*');
                              $image->image_convert = "webp";
                              $image->file_new_name_body = $rname;
                              $image->image_text= $sitenick." | ".$site;
                              $image->image_text_position = "BR";
                              $image->process("../images");
                              if($image->processed){
                                $konuguncelle=$db->prepare("UPDATE yazilar SET yazi_baslik=:b,yazi_sef=:s,yazi_kat_id=:k,yazi_resim=:r,yazi_icerik=:i,yazi_etiketler=:e,yazi_sef_etiketler=:se,yazi_durum=:du WHERE yazi_id=:id");
                                $konuguncelle->execute([':b'=>$baslik,':s'=>$sef_baslik,':k'=>$kategori,':r'=>$rname.".webp",':i'=>$icerik,':e'=>$etiketler,':se'=>$deger,':du'=>$durum,':id'=>$id]);
                                if($konuguncelle->rowCount()){
                                  
    
                                  basarili("Konu başarıyla günellendi");
                                  header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                                }else{
                                  hata('Konu günellenirken hata oluştu');
                                }
                              }else{
                                hata('Resim yüklenemedi');
                              }
                            }else{
                              
                              $konuguncelle2=$db->prepare("UPDATE yazilar SET yazi_baslik=:b,yazi_sef=:s,yazi_kat_id=:k,yazi_icerik=:i,yazi_etiketler=:e,yazi_sef_etiketler=:se,yazi_durum=:du WHERE yazi_id=:id");
                              $konuguncelle2->execute([':b'=>$baslik,':s'=>$sef_baslik,':k'=>$kategori,':i'=>$icerik,':e'=>$etiketler,':se'=>$deger,':du'=>$durum,':id'=>$id]);
                              if($konuguncelle2->rowCount()){
                                
  
                                basarili("Konu başarıyla günellendi, resim değiştirilmedi");
                                header('Refresh:3;url='.$_SERVER['HTTP_REFERER']);
                              }else{
                                hata('Konu günellenirken hata oluştu');
                              }



                            }
                          }
                        }

                        ?>
                        <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                          <div class="tile-body">                          
                              <div class="form-group row">
                                <label class="control-label col-md-3">Yazı Başlık</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="baslik" value="<?php echo $yazirow->yazi_baslik; ?>" placeholder="Yazı Başlık Giriniz... ">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="control-label col-md-3">Yazı Kategori</label>
                                <div class="col-md-8">
                                  <select name="kategoriler" class="form-control">
                                    <?php
                                      $kategoriler = $db->prepare("SELECT * FROM kategoriler");
                                      $kategoriler->execute();
                                      if($kategoriler->rowCount()){
                                        foreach ($kategoriler as $row) {
                                          echo '<option value="'.$row['id'].'"';
                                          echo $yazirow->yazi_kat_id == $row['id'] ? 'selected' : null;
                                          echo '>'.$row['kat_adi'].'</option>';
                                        }
                                      }
                                    ?>
                                  </select> 
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="control-label col-md-3">Yazı Resim</label>
                                <div class="col-md-8">
                                  <img src="<?php echo $site."/images/".$yazirow->yazi_resim;?>" alt="<?php echo $yazirow->yazi_baslik; ?>" width="150" height="100"> <br><br>
                                  <input class="form-control" type="file" name="resim">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="control-label col-md-3">Yazı İçerik</label>
                                <div class="col-md-8">
                                  <textarea name="icerik" class="ckeditor" cols="30" rows="10"><?php echo $yazirow->yazi_icerik; ?></textarea>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="control-label col-md-3">Yazı Etiketler</label>
                                <div class="col-md-8">
                                  <input class="form-control" type="text" name="etiketler" value="<?php echo $yazirow->yazi_etiketler; ?>" placeholder="Yazı Etiketlerini ARalarında Virgül Kullanarak Giriniz... ">
                                </div>
                              </div>
                              <div class="form-group row">
                              <label class="control-label col-md-3">Yazı Durumu</label>
                              <div class="col-md-8">
                                <select name="durum" class="form-control">
                                  <option value="1" <?php echo $yazirow->yazi_durum == 1 ? 'selected' : null; ?>>Aktif</option>
                                  <option value="0" <?php echo $yazirow->yazi_durum == 0 ? 'selected' : null; ?>>Pasif</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="tile-footer">
                            <div class="row">
                              <div class="col-md-8 col-md-offset-3">
                                <button class="btn btn-primary" type="submit" name="yaziguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Yazı Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/konular.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php
                      }else{
                        header('Location:'.$yonetim."/konular.php");
                      }
                  break;

                  case 'kategoriduzenle':
                    echo '<h3 class="tile-title">Kategori Düzenle </h3> ';
                    $id = get('id');
                    if(!$id){
                      header("Location:".$yonetim."/kategoriler.php");
                    }

                    $kategoriBul = $db->prepare("SELECT * FROM kategoriler WHERE id=:id");
                    $kategoriBul->execute([":id"=>$id]);
                    if($kategoriBul->rowCount()){
                      $row  = $kategoriBul->fetch(PDO::FETCH_OBJ);
                      if(isset($_POST['kategoriduzenle'])){
                        $katadi  = post('katadi');
                        $katsef  = sef_link($katadi);
                        $katkeyw = post('kaytKeyw');
                        $katdesc = post('katdesc');
  
                        if(!$katadi || !$katdesc || !$katkeyw){
                          hata('Boş alan bırakmayınız');
                        }else{
                          $varmi = $db->prepare("SELECT * FROM kategoriler WHERE kat_sef =:s AND id!=:id");
                          $varmi->execute([':s'=> $katsef,":id"=>$id]);
                          if ($varmi->rowCount()) {
                            hata("Bu kategori zaten kayıtlı");
                          }else{
                            $kategoriguncelle= $db->prepare("UPDATE kategoriler SET kat_adi=:adi, kat_sef=:sef, kat_keyw=:keyw, kat_desc=:descc WHERE id=:id");
                            $kategoriguncelle->execute([':adi'=>$katadi,'sef'=>$katsef,'keyw'=>$katkeyw,'descc'=>$katdesc,":id"=>$id]);
                            if($kategoriguncelle->rowCount()){
                              basarili('Kategori başarıyla güncellendi');
                              header('Refresh:3;url='.$yonetim."/kategoriler.php");
                            }else{
                              hata('Hata oluştu');
                            }
                          }
                        }
                      }
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Adı</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="katadi" value="<?php echo $row->kat_adi; ?>" placeholder="Kategori Adı Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Anahtar Kelimeler</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="kaytKeyw" value="<?php echo $row->kat_keyw  ; ?>" placeholder="Kategori Anahtar Kelimeler Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kategori Açıklaması</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="katdesc" value="<?php echo $row->kat_desc; ?>" placeholder="Kategori Açıklaması Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="kategoriduzenle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Kategori Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/kategoriler.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>

                    <?php

                    }else{
                      header("Location:".$yonetim."/kategoriler.php");
                    }
                  break;

                  case 'mesajoku':
                    echo '<h3 class="tile-title">Mesaj Oku </h3> ';
                    $id = get('id');
                    if(!$id){
                      header("Location:".$yonetim."/bekleyenmesajlar.php");
                    }
                    $mesajBul = $db->prepare("SELECT * FROM mesajlar WHERE id=:id");
                    $mesajBul->execute([":id"=>$id]);
                    if ($mesajBul->rowCount()) {
                      $okunduolarakguncelle= $db->prepare("UPDATE mesajlar SET durum=:d WHERE id=:id");
                      $okunduolarakguncelle->execute([":d"=>1,":id"=>$id]);
                      $row = $mesajBul->fetch(PDO::FETCH_OBJ);
                      echo "<b>Gönderen : </b> ".$row->isim."<br>";
                      echo "<b>E-posta : </b> ".$row->eposta."<br>";
                      echo "<b>Tarih : </b> ".$row->tarih."<br>";
                      echo "<b>Gönderilen IP : </b> ".$row->ip."<br><br>";
                      echo "<b>Konu : </b> ".$row->konu."<br>";
                      echo "<b>Mesaj : </b> ".$row->mesaj."<br><br>";
                      echo '<a href="'.$yonetim.'/bekleyenmesajlar.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>Listeye Dön</a>';
                    }else{
                      header("Location:".$yonetim."/bekleyenmesajlar.php");
                    }
                  break;

                  case 'yorumoku':
                    echo '<h3 class="tile-title">Yorum Oku </h3> ';
                    $id = get('id');
                    if(!$id){
                      header("Location:".$yonetim."/bekleyenyorumlar.php");
                    }
                    $mesajBul = $db->prepare("SELECT * FROM yorumlar INNER JOIN yazilar ON yazilar.yazi_id = yorumlar.yorum_yazi_id WHERE id=:id");
                    $mesajBul->execute([":id"=>$id]);
                    if ($mesajBul->rowCount()) {
                      
                      $row = $mesajBul->fetch(PDO::FETCH_OBJ);
                      echo "<b>Gönderen : </b> ".$row->yorum_isim."<br>";
                      echo "<b>E-posta : </b> ".$row->yorum_eposta."<br>";
                      echo "<b>Web Site : </b> ".$row->yorum_website."<br>";
                      echo "<b>Tarih : </b> ".$row->yorum_tarih."<br>";
                      echo "<b>Gönderilen IP : </b> ".$row->yorum_ip."<br><br>";
                      echo "<b>İçerik : </b> ".$row->yazi_baslik."<br>";
                      echo "<b>Yorum : </b> ".$row->yorum_icerik."<br><br>";

                      if($row->yorum_durum == 1){
                        ?>
                        <a class="btn btn-danger" onclick="return confirm('Bu yorumu silmeyi onaylıyor musunuz ?');" href="<?php echo $yonetim."/islemler.php?islem=yorumsil&id=".$row->id; ?>"><i class="fa fa-eraser"></i> Yorumu Sil</a>
                        <?php
                      }else{
                        ?>
                        <a class="btn btn-success" onclick="return confirm('Bu yorumu yayınlamayı onaylıyor musunuz ?');" href="<?php echo $yonetim."/islemler.php?islem=yorumonayla&id=".$row->id; ?>"><i class="fa fa-check"></i> Yorum Onayla</a>
                        <?php
                      }

                      echo '<a href="'.$yonetim.'/bekleyenyorumlar.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i>Listeye Dön</a>';
                    }else{
                      header("Location:".$yonetim."/bekleyenyorumlar.php");
                    }
                  break;

                  case 'yorumonayla':
                    echo '<h3 class="tile-title">Yorum Onaylanıyor </h3> ';
                    $id = get('id');
                    if(!$id){
                      header("Location:".$yonetim."/bekleyenyorumlar.php");
                    }
                    $yorumuOnayla =  $db->prepare("UPDATE yorumlar SET yorum_durum = :d WHERE id=:id");
                    $yorumuOnayla->execute([":d"=>1,":id"=>$id]);
                    if ($yorumuOnayla) {
                      basarili("Bu yorumu onayladınız.");
                    }else{
                      hata("Yorum onaylanırken bir hata oluştu");
                    }
                    header("Refresh: 3; url=".$yonetim."/onayliyorumlar.php");
                  break;

                  case 'sosyalmedyaduzenle':
                    $id = get('id');
                    if(!$id){
                      header("Location:".$yonetim."/sosyalmedya.php");
                    }
                    if(isset($_POST['sosyalmedyaduzenle'])){
                      $ikon  = post('ikon');
                      $link = post('link');
                      $durumm = post('durum');

                      if($ikon == null || $link == null || $durumm == null){
                        hata('Boş alan bırakmayınız');
                      }else{                        
                        $SosyalMedyaGüncelle= $db->prepare("UPDATE sosyalmedya SET ikon=:ik, link=:lk, durum=:du WHERE id=:id");
                        $SosyalMedyaGüncelle->execute([':ik'=>$ikon,':lk'=>$link, ':du'=> $durumm, ':id'=>$id]);
                        if($SosyalMedyaGüncelle->rowCount()){
                          basarili('Sosyal Medya hesabı başarıyla güncellendi');
                          header('Refresh:3;url='.$yonetim."/sosyalmedya.php");
                        }else{
                          hata('Güncelleme sırasında hata oluştu');
                        }                        
                      }
                    }
                    $SosyalMedya  = $db->prepare("SELECT * FROM sosyalmedya WHERE id=:id");
                    $SosyalMedya->execute([":id"=>$id]);
                    $sosyalMedyaRow = $SosyalMedya->fetch(PDO::FETCH_OBJ);
                    echo '<h3 class="tile-title">Sosyal Medya Düzenle ( '.$sosyalMedyaRow->ikon.' )</h3> ';
                    
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Sosyal Medya İkon</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" value="<?php echo $sosyalMedyaRow->ikon; ?>" name="ikon" placeholder="Sosyal Medya İkonunu Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Sosyal Medya Link</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="link" value="<?php echo $sosyalMedyaRow->link; ?>" placeholder="Sosyal Medya Linkini Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Sosyal Medya Durumu</label>
                              <div class="col-md-8">
                                <select name="durum" class="form-control">
                                  <option value="1" <?php echo $sosyalMedyaRow->durum == 1 ? 'selected' : null; ?>>Aktif</option>
                                  <option value="0" <?php echo $sosyalMedyaRow->durum == 0 ? 'selected' : null; ?>>Pasif</option>
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="sosyalmedyaduzenle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Sosyal Medya Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>/sosyalmedya.php"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'genel':
                    echo '<h3 class="tile-title">Genel Ayarlar</h3> ';
                    if(isset($_POST['genelguncelle'])){
                      $link = post('link');
                      $baslik = post('baslik');
                      $keyw = post('keyw');
                      $desc = post('desc');
                      $durum = post('durum');

                      if($link == null || $baslik == null || $keyw == null || $desc == null || $durum == null){
                        hata('Boş alan bırakmayınız');
                      }else{                        
                        $GenelAyarlarGüncelle= $db->prepare("UPDATE ayarlar SET site_url=:u, site_baslik=:b, site_keyw=:k, site_desc=:d, site_durum=:du");
                        $GenelAyarlarGüncelle->execute([':u'=>$link,':b'=>$baslik, ':k'=> $keyw, ':d'=>$desc,':du'=>$durum]);
                        if($GenelAyarlarGüncelle->rowCount()){
                          basarili('Genel ayarlar başarıyla güncellendi');
                          header('Refresh:3;url='.$yonetim."/islemler.php?islem=genel");
                        }else{
                          hata('Güncelleme sırasında hata oluştu');
                        }                        
                      }
                    }
                    
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Site Link</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" value="<?php echo $site; ?>" name="link" placeholder="Site Link Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Site Başlık</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="baslik" value="<?php echo $sitebaslik; ?>" placeholder="Site Başlık Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Site Anahtar Kelimeler</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="keyw" value="<?php echo $sitekeyw; ?>" placeholder="Site Anahtar Kelimelerini Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Site Açıklaması</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="desc" value="<?php echo $sitedesc; ?>" placeholder="Site Açıklamasını Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Site Durumu</label>
                              <div class="col-md-8">
                                <select name="durum" class="form-control">
                                  <option value="1" <?php echo $sitedurum == 1 ? 'selected' : null; ?>>Aktif</option>
                                  <option value="0" <?php echo $sitedurum == 0 ? 'selected' : null; ?>>Pasif</option>
                                </select>
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="genelguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Genel Ayarları Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'iletisim':
                    echo '<h3 class="tile-title">İletişim Ayarları</h3> ';
                    if(isset($_POST['iletisimguncelle'])){
                      $mail = post('mail');
                      $harita = post('harita');
                      $haritadurum  = post('haritadurum');

                      if($mail == null || $harita == null || $haritadurum == null){
                        hata('Boş alan bırakmayınız');
                      }else{                        
                        $GenelAyarlarGüncelle= $db->prepare("UPDATE ayarlar SET site_mail=:m, site_harita=:h, site_harita_durum =:hd");
                        $GenelAyarlarGüncelle->execute([':m'=>$mail,':h'=>$harita, ':hd'=>$haritadurum]);
                        if($GenelAyarlarGüncelle->rowCount()){
                          basarili('İletişim ayarlar başarıyla güncellendi');
                          header('Refresh:3;url='.$yonetim."/islemler.php?islem=iletisim");
                        }else{
                          hata('Güncelleme sırasında hata oluştu');
                        }                        
                      }
                    }
                    
                    ?>
                      <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                          <div class="form-group row">
                            <label class="control-label col-md-3">Site Mail</label>
                            <div class="col-md-8">
                              <input class="form-control" type="text" value="<?php echo $arow->site_mail; ?>" name="mail" placeholder="Site Mail Giriniz... ">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-3">Site Harita</label>
                            <div class="col-md-8">
                              <input class="form-control" type="text" name="harita" value="<?php echo $arow->site_harita; ?>" placeholder="Site Harita Giriniz... ">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="control-label col-md-3">Harita Durumu</label>
                            <div class="col-md-8">
                              <select name="haritadurum" class="form-control">
                                <option value="1" <?php echo $arow->site_harita_durum == 1 ? 'selected' : null; ?>>Aktif</option>
                                <option value="0" <?php echo $arow->site_harita_durum == 0 ? 'selected' : null; ?>>Pasif</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="iletisimguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Genel Ayarları Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'logo':
                    echo '<h3 class="tile-title">Logo Ayarları</h3> ';
                    if(isset($_POST['logoguncelle'])){
                      require 'inc/class.upload.php';
                      $image= new Upload($_FILES['logo']);
                      if($image->uploaded){
                        $rname=md5(uniqid());
                        $image->allowed=array('image/*');
                        $image->image_convert = "webp";
                        $image->file_new_name_body = $rname;
                        $image->process("../images");
                        if($image->processed){
                          $GenelAyarlarGüncelle= $db->prepare("UPDATE ayarlar SET site_logo=:s");
                          $GenelAyarlarGüncelle->execute([':s'=>$rname.".webp"]);
                          if($GenelAyarlarGüncelle->rowCount()){
                            basarili('Logo başarıyla güncellendi');
                            header('Refresh:3;url='.$yonetim."/islemler.php?islem=logo");
                          }else{
                            hata('Logo güncelleme sırasında hata oluştu');
                          }   
                        }else{
                          hata("Logo taşınamadı");
                        }
                      }else{
                        hata("Logo seçmediniz");
                      }                
                      
                    }
                    
                    ?>
                      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                        <div class="tile-body">                          
                          <div class="form-group row">
                            <label class="control-label col-md-3">Site Logo</label>
                            <div class="col-md-8">
                              <img src="<?php echo $site; ?>/images/<?php echo $logo ?>" width="250" height="150" alt="logo">
                              <input class="form-control" type="file"  name="logo">
                            </div>
                          </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="logoguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Logo Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'favicon':
                    echo '<h3 class="tile-title">Favicon Ayarları</h3> ';
                    if(isset($_POST['faviconguncelle'])){
                      require 'inc/class.upload.php';
                      $image= new Upload($_FILES['logo']);
                      if($image->uploaded){
                        $rname=md5(uniqid());
                        $image->allowed=array('image/*');
                        $image->image_convert = "webp";
                        $image->file_new_name_body = $rname;
                        $image->process("../images");
                        if($image->processed){
                          $GenelAyarlarGüncelle= $db->prepare("UPDATE ayarlar SET site_favicon=:s");
                          $GenelAyarlarGüncelle->execute([':s'=>$rname.".webp"]);
                          if($GenelAyarlarGüncelle->rowCount()){
                            basarili('Favicon başarıyla güncellendi');
                            header('Refresh:3;url='.$yonetim."/islemler.php?islem=favicon");
                          }else{
                            hata('Favicon güncelleme sırasında hata oluştu');
                          }   
                        }else{
                          hata("Favicon taşınamadı");
                        }
                      }else{
                        hata("Favicon seçmediniz");
                      }                
                      
                    }
                    
                    ?>
                      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
                        <div class="tile-body">                          
                          <div class="form-group row">
                            <label class="control-label col-md-3">Site Favicon</label>
                            <div class="col-md-8">
                              <img src="<?php echo $site; ?>/images/<?php echo $favicon ?>" width="250" height="150" alt="logo">
                              <input class="form-control" type="file"  name="logo">
                            </div>
                          </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="faviconguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Favicon Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Ana Sayfaya Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'profil':
                    echo '<h3 class="tile-title">Profilim</h3> ';
                    if(isset($_POST['profilguncelle'])){
                      $kullaniciadi = post("kadi");
                      $kullanicimail = post("kmail");
                      if(!$kullaniciadi || !$kullanicimail){
                        hata("Hata oluştu. Lütfen tekrar deneyiniz");
                      }else{
                        if(!filter_var($kullanicimail,FILTER_VALIDATE_EMAIL)){
                          hata("E-posta formatını hatalı girdiniz");
                        }else{
                          $guncelle = $db->prepare("UPDATE yoneticiler SET kadi=:k,eposta=:e WHERE id=:id");
                          $guncelle->execute([":k"=>$kullaniciadi, ":e"=>$kullanicimail, ":id"=>$yid]);
                          if($guncelle){
                            basarili("Profil başarıyla güncellendi");
                            header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
                          }else{
                            hata("Güncelleme sırasında hata oluştu. Lütfen tekrar deneyiniz");
                          }
                        }
                      }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Kullanıcı Adı</label>
                              <div class="col-md-8">
                                <input class="form-control" type="text" name="kadi" value="<?php echo $ykadi; ?>" placeholder="Kullanıcı Adı Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">E-posta</label>
                              <div class="col-md-8">
                                <input class="form-control" type="email" name="kmail" value="<?php echo $yposta; ?>" placeholder="E-posta Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="profilguncelle"><i class="fa fa-fw fa-lg fa-check-circle"></i>Profil Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'sifredegistir':
                    echo '<h3 class="tile-title">Şifre Değiştir</h3> ';
                    if(isset($_POST['sifredegistir'])){
                      $sifre1 = post("sifre1");
                      $sifre2 = post("sifre2");

                      if(!$sifre1 || !$sifre2){
                        hata("Hata oluştu. Lütfen tekrar deneyiniz");
                      }else{
                        if($sifre1 != $sifre2){
                          hata("Şifreler aynı değil");
                        }else{
                          $kripto  = sha1(md5($sifre1));
                          $guncelle = $db->prepare("UPDATE yoneticiler SET sifre=:s WHERE id=:id");
                          $guncelle->execute([ ":s"=>$kripto, ":id"=>$yid]);
                          if($guncelle){
                            basarili("Şifreniz başarıyla güncellendi");
                            header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
                          }else{
                            hata("Güncelleme sırasında hata oluştu. Lütfen tekrar deneyiniz");
                          }
                        }
                      }
                    }
                    ?>
                    <form class="form-horizontal" action="" method="POST">
                        <div class="tile-body">                          
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yeni Şifre</label>
                              <div class="col-md-8">
                                <input class="form-control" type="password" name="sifre1"  placeholder="Yeni Şifre Giriniz... ">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3">Yeni Şifre Tekrar</label>
                              <div class="col-md-8">
                                <input class="form-control" type="password" name="sifre2" placeholder="Yeni Şifre Tekrar Giriniz... ">
                              </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                          <div class="row">
                            <div class="col-md-8 col-md-offset-3">
                              <button class="btn btn-primary" type="submit" name="sifredegistir"><i class="fa fa-fw fa-lg fa-check-circle"></i>Şifreyi Güncelle</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="<?php echo $yonetim; ?>"><i class="fa fa-fw fa-lg fa-arrow-left"></i>Listeye Dön</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    <?php
                  break;

                  case 'cikis';
                    session_destroy();
                    header('Location:giris.php');
                  break;
                }
              }
            ?>
          </div>
        </div>
      </div>
    </main>
<?php require_once 'inc/alt.php'; ?>