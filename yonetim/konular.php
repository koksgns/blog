<?php 
define("yonetimguvenlik",true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Yazılar</h1>
          <p>Yazı Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Yazılar</li>
          <li class="breadcrumb-item active"><a href="#">Yazı Listesi</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="<?php echo $yonetim;?>/yaziara.php" method="GET">
            <input type="text" name="q" class="form-control" placeholder="Yazı Başlık Girimiz">
          </form><br>
        </div>
        <div class="clearfix"></div>
        
        <div class="col-md-12">
          <div class="tile">
            <?php
              $s  = @intval(get('s'));
              if(!$s){ $s=1;}

              $toplam = say('yazilar');
              $lim    = 10;
              $goster = $s  * $lim -$lim;

              $sorgu  = $db->prepare("SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id= yazilar.yazi_kat_id ORDER BY yazi_id DESC LIMIT :goster,:lim");
              $sorgu->bindValue(':goster',(int) $goster,PDO::PARAM_INT);
              $sorgu->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
              $sorgu->execute();

              if($s >ceil($toplam/$lim)){
                $s=1;
              }
              ?>
                <h3 class="tile-title">Yazı Listesi (<?php echo $toplam; ?>)</h3>
              <?php

              if($sorgu->rowCount()){
            ?>
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>RESİM</th>
                    <th>BAŞLIK</th>
                    <th>KATEGORİ</th>
                    <th>TARİH</th>
                    <th>DURUM</th>
                    <th>İŞLEMLER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($sorgu as $row) {
                  ?>
                  <tr>
                    <td><?php echo $row["yazi_id"];?></td>
                    <td><img src="<?php echo $site?>/images/<?php echo $row["yazi_resim"];?>" alt="" width="100" height="100" class="img-responsive"></td>
                    <td><?php echo $row["yazi_baslik"];?></td>
                    <td><?php echo $row["kat_adi"];?></td>
                    <td><?php echo date('d.m.y',strtotime($row["yazi_tarih"]));?></td>
                    <td><?php echo $row["yazi_durum"] == 1 ? '<div style="color:green; font-weight:bold">Aktif</div>' : '<div style="color:darkred; font-weight:bold">Pasif</div>';?></td>
                    <td><a href="<?php echo $yonetim."/islemler.php?islem=yaziduzenle&id=".$row['yazi_id']; ?>"><i class="fa fa-edit"></i></a> | <a onclick="return confirm('Bu yazıyı silmeyi onaylıyor musunuz ?');" href="<?php echo $yonetim."/islemler.php?islem=yazisil&id=".$row['yazi_id']; ?>"><i class="fa fa-eraser"></i></a></td>
                  </tr>                  
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            <ul class="pagination">
                <?php
                    if($toplam>$lim){
                        pagination($s,ceil($toplam/$lim),'konular.php?s=');
                    }
                ?>
                
            </ul>   
            <!-- end: Pagination -->
            <?php 
              }else{
                echo '<div class="alert alert-danger">Yazı Bulunmuyor</div>';
              } 
            ?>
          </div>
        </div>
      </div>
    </main>
<?php require_once 'inc/alt.php'; ?>