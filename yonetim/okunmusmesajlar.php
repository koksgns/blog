<?php 
define("yonetimguvenlik",true);
require_once 'inc/ust.php'; ?>
    <!-- Sidebar menu-->
<?php require_once 'inc/sol.php'; ?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Mesajlar</h1>
          <p>Okunmuş Mesajlar Listesi</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Mesajlar</li>
          <li class="breadcrumb-item active"><a href="#">Okunmuş Mesajlar Listesi</a></li>
        </ul>
      </div>
      <div class="row">

        <div class="clearfix"></div>
        <div class="col-md-12">
          <div class="tile">
            <?php
              $s  = @intval(get('s'));
              if(!$s){ $s=1;}

              $toplam = say('mesajlar','durum',1);
              $lim    = 10;
              $goster = $s  * $lim -$lim;

              $sorgu  = $db->prepare("SELECT * FROM mesajlar WHERE durum=:d ORDER BY id DESC LIMIT :goster,:lim");
              $sorgu->bindValue(':goster',(int) $goster,PDO::PARAM_INT);
              $sorgu->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
              $sorgu->bindValue(':d',(int) 1,PDO::PARAM_INT);
              $sorgu->execute();

              if($s >ceil($toplam/$lim)){
                $s=1;
              }
              ?>
                <h3 class="tile-title">Okunmuş Mesajlar Listesi (<?php echo $toplam; ?>)</h3>
              <?php

              if($sorgu->rowCount()){
            ?>            
            <div class="table-responsive table-hover">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>İSİM</th>
                    <th>kONU</th>
                    <th>E-POSTA</th>
                    <th>TARİH</th>
                    <th>İŞLEMLER</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($sorgu as $row) {
                  ?>
                  <tr>
                    <td><?php echo $row["id"];?></td>
                    <td><?php echo $row["isim"];?></td>
                    <td><?php echo $row["konu"];?></td>
                    <td><?php echo $row["eposta"];?></td>
                    <td><?php echo date('d.m.y',strtotime($row["tarih"]));?></td>
                    <td><a href="<?php echo $yonetim."/islemler.php?islem=mesajoku&id=".$row['id']; ?>"><i class="fa fa-eye"></i></a> | <a onclick="return confirm('Onaylıyor musunuz ?');" href="<?php echo $yonetim."/islemler.php?islem=mesajsil&id=".$row['id']; ?>"><i class="fa fa-eraser"></i></a></td>
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
                        pagination($s,ceil($toplam/$lim),'okunmusmesajlar.php?s=');
                    }
                ?>
                
            </ul>   
            <!-- end: Pagination -->
            <?php 
              }else{
                echo '<div class="alert alert-danger">Okunmuş Mesajınız Bulunmuyor</div>';
              } 
            ?>
          </div>
        </div>
      </div>
    </main>
<?php require_once 'inc/alt.php'; ?>