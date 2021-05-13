<?php 
define("yonetimguvenlik",true);
require_once 'inc/ust.php'; ?>

    <!-- Sidebar menu-->
    <?php require_once 'inc/sol.php'; ?>


    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Yönetim Paneli</h1>
          <p>Blog Sitesi | Yönetim Paneli</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Ana Sayfa</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Aboneler</h4>
              <p><b><?php echo say("aboneler"); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-comment fa-3x"></i>
            <div class="info">
              <h4>Yorumlar</h4>
              <p><b><?php echo say("yorumlar"); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Yazılar</h4>
              <p><b><?php echo say("yazilar"); ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-envelope fa-3x"></i>
            <div class="info">
              <h4>Mesajlar</h4>
              <p><b><?php echo say("mesajlar"); ?></b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Son Yeni 10 Mesaj</h3>
            <?php
              $sonmesajlar  =   $db->prepare("SELECT * FROM mesajlar WHERE durum=:d ORDER BY id DESC LIMIT :lim");
              $sonmesajlar->bindValue(':d',(int) 1, PDO::PARAM_INT);
              $sonmesajlar->bindValue(':lim',(int) 10, PDO::PARAM_INT);
              $sonmesajlar->execute();
              if($sonmesajlar->rowCount()){
            ?>
              <div class="table-responsive table-hover">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th>İSİM</th>
                      <th>KONU</th>
                      <th>TARİH</th>
                      <th>İŞLEMLER</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    <?php
                      foreach ($sonmesajlar as $mesaj) {
                      ?>
                        <tr>
                          <td><?php echo $mesaj["id"]; ?></td>
                          <td><?php echo $mesaj["isim"]; ?></td>
                          <td><?php echo $mesaj["konu"]; ?></td>
                          <td><?php echo date('d.m.y',strtotime($mesaj["tarih"])); ?></td>
                          <td> <a href="<?php echo $yonetim; ?>/islemler.php?islem=mesajoku&id=<?php echo $mesaj["id"]; ?>"><i class="fa fa-eye"></i></a> </td>
                        </tr>

                      <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php
                
              }else{
                echo '<div class="alert alert-danger">Mesaj Bulunmuyor</div>';
              }
            ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Son Yeni 10 Yorum</h3>
            <?php
              $sonyorumlar  =   $db->prepare("SELECT * FROM yorumlar INNER JOIN yazilar ON yazilar.yazi_id= yorumlar.yorum_yazi_id WHERE yorum_durum=:d ORDER BY id DESC LIMIT :lim");
              $sonyorumlar->bindValue(':d',(int) 0, PDO::PARAM_INT);
              $sonyorumlar->bindValue(':lim',(int) 10, PDO::PARAM_INT);
              $sonyorumlar->execute();
              if($sonyorumlar->rowCount()){
            ?>
              <div class="table-responsive table-hover">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th>İSİM</th>
                      <th>KONU</th>
                      <th>TARİH</th>
                      <th>İŞLEMLER</th>
                    </tr>
                  </thead>
                  <tbody>                    
                    <?php
                      foreach ($sonyorumlar as $yorum) {
                      ?>
                        <tr>
                          <td><?php echo $yorum["id"]; ?></td>
                          <td><?php echo $yorum["yorum_isim"]; ?></td>
                          <td><?php echo $yorum["yazi_baslik"]; ?></td>
                          <td><?php echo date('d.m.y',strtotime($yorum["yorum_tarih"])); ?></td>
                          <td> <a href="<?php echo $yonetim; ?>/islemler.php?islem=yorumoku&id=<?php echo $yorum["id"]; ?>"><i class="fa fa-eye"></i></a> </td>
                        </tr>

                      <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php
                
              }else{
                echo '<div class="alert alert-danger">Yorum Bulunmuyor</div>';
              }
            ?>
          </div>
        </div>
      </div>
    </main>


<?php require_once 'inc/alt.php'; ?>