<?php 
echo !defined("guvenlik") ? die() : null;
?>
    <div class="sidebar sticky-sidebar col-lg-3">
        <!--widget newsletter-->
        <div class="widget  widget-newsletter">

            <form id="widget-search-form-sidebar" action="search.php" method="get" class="form-inline">
                <div class="input-group">
                    <input type="text" aria-required="true" name="q" class="form-control widget-search-form" placeholder="Yazı arayın...">
                        <div class="input-group-append">
            <span class="input-group-btn">
                        <button type="submit" id="widget-widget-search-form-button" class="btn"><i class="fa fa-search"></i></button>
                        </span>
        </div> </div>
            </form>
        </div>
        <!--end: widget newsletter-->

        <!--Tabs with Posts-->


    <div class="container p-0">
        <div class="widget p-0">
            <h4 class="widget-title p-0">Populer Konular</h4>
        </div>
        
        <div class="col-12">
            <?php
                $populer = $db->prepare("SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id = yazilar.yazi_kat_id WHERE yazi_durum=:d ORDER bY yazi_goruntulenme DESC LIMIT :lim");
                $populer->bindValue(':d',(int) 1,PDO::PARAM_INT);
                $populer->bindValue(':lim',(int) 5,PDO::PARAM_INT);
                $populer->execute();
                if($populer->rowCount()){
                    foreach ($populer as $item) {
                        ?>
                        <div class="row my-4">
                            <div class="col-4">
                                <img alt="<?php echo $item['yazi_baslik'];?>" width="70" height="50" src="<?php echo $arow->site_url;?>/images/<?php echo $item["yazi_resim"]; ?>">
                            </div>
                                
                                <div class="col-8">
                                    <b><a href="<?php echo $arow->site_url?>/yazidetay.php?yazi_sef=<?php echo $item["yazi_sef"]; ?>&id=<?php echo $item["yazi_id"]; ?>" style="font-size: 16px;"><?php echo $item['yazi_baslik'];?></a></b><br>
                                    <span class="post-date"><i class="far fa-clock"></i> <?php echo date('d.m.y',strtotime($item["yazi_tarih"])); ?></span>
                                    &nbsp;<span ><i class="fa fa-eye"></i> <?php echo $item['yazi_goruntulenme'];?></span><br>
                                    <span class="post-category"><i class="fa fa-tag"></i> <?php echo $item['kat_adi'];?></span> 
                                </div>
                            </div>
                            
                        <?php
                    }
                }
            ?>
        </div>
    </div>

    <!--End: Tabs with Posts-->

    <br><br>
    <div class="widget  widget-newsletter">
        <h4>Bülten Aboneliği</h4>
        <form id="aboneformu" action="" method="post" class="form-inline" onsubmit="return false;">
            <div class="input-group">
                <input type="text" aria-required="true" name="eposta" class="form-control widget-search-form" placeholder="E-posta yazınız...">
                <div class="input-group-append">
        <span class="input-group-btn">
                    <button type="submit" onclick="aboneol();" id="widget-widget-search-form-button" class="btn"><i class="fa fa-send"></i></button>
                    </span>
        </div> </div>
        </form>
    </div>
    <br><br>

    <!--widget tags -->
    <div class="container p-0">
        <div class="widget p-0">
            <h4 class="widget-title p-0">Popüler Konular</h4>
        </div>
        
        <div class="col-12 tags">
            <?php etiketler();?>
        </div>
    </div> 
    <!--end: widget tags -->
    

</div>