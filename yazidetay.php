<?php 
define("guvenlik", true);
require_once 'inc/header.php'; ?>
        <!-- Header -->
<?php require_once 'inc/menu.php'; ?>        
        <!-- end: Header -->
        <!-- Page Content -->
        <section id="page-content" class="sidebar-right">
            <div class="container">
                <div class="row">
                    <!-- content -->
                    <div class="content col-lg-9">
                        <!-- Blog -->
                        <?php
                            $yaziSef    =   strip_tags(trim($_GET['yazi_sef']));
                            $yaziid     =   strip_tags(trim($_GET['id']));

                            if(!$yaziid || !$yaziSef){
                                header('location:'.$arow->site_url);
                            }

                            ##sonraki ve önceki konular için
                            $sonrakiid  =   $yaziid + 1;
                            $oncekiid   =   $yaziid - 1;

                            $sornakikonu =   $db->prepare("SELECT yazi_id,yazi_baslik,yazi_sef FROM yazilar WHERE yazi_id=:id AND yazi_durum=:d");
                            $sornakikonu->execute([':id' => $sonrakiid, ':d'=>1]);
                            $sonrakikonurow =   $sornakikonu->fetch(PDO::FETCH_OBJ);


                            $oncekiKonu =   $db->prepare("SELECT yazi_id,yazi_baslik,yazi_sef FROM yazilar WHERE yazi_id=:id AND yazi_durum=:d");
                            $oncekiKonu->execute([':id' => $oncekiid,':d'=>1]);
                            $oncekikonurow =   $oncekiKonu->fetch(PDO::FETCH_OBJ);




                            $konubul    = $db->prepare("SELECT * FROM yazilar INNER JOIN kategoriler ON kategoriler.id=yazilar.yazi_kat_id WHERE yazi_sef=:sef AND yazi_id=:id AND yazi_durum =:d");
                            $konubul->execute([':sef'=>$yaziSef,':id'=>$yaziid,':d'=>1]);
                            if($konubul->rowCount()){
                                $row = $konubul->fetch(PDO::FETCH_OBJ);
                                $goruntulenme = @$_COOKIE[$row->yazi_id];
                                if(!$goruntulenme){
                                    $okunmasayisiarttir = $db->prepare("UPDATE yazilar SET yazi_goruntulenme=:g WHERE yazi_id=:id");
                                    $okunmasayisiarttir->execute([':g'=>$row->yazi_goruntulenme+1, ':id' => $yaziid]);
                                    setcookie($row->yazi_id,'1',time()+3600);
                                }
                            ?>
                                
                            <div id="blog" class="single-post">
                                <!-- Post single item-->
                                <div class="post-item">
                                    <div class="post-item-wrap">
                                        <div class="post-image">
                                            <a href="#">
                                                <img alt="<?php echo $row->yazi_baslik;?>" src="<?php echo $arow->site_url; ?>/images/<?php echo $row->yazi_resim;?>">
                                            </a>
                                        </div>
                                        <div class="post-item-description">
                                            <h2><?php echo $row->yazi_baslik;?></h2>
                                            <div class="post-meta">

                                                <span class="post-meta-date"><i class="fa fa-calendar-o"></i><?php echo date('d.m.y',strtotime($row->yazi_tarih));?></span>
                                                <span class="post-meta-comments"><a href=""><i class="fa fa-eye"></i><?php echo $row->yazi_goruntulenme;?> Görüntülenme</a></span>
                                                <span class="post-meta-category"><a href=""><i class="fa fa-tag"></i><?php echo $row->kat_adi;?></a></span>
                                                <div class="post-meta-share">
                                                    <a class="btn btn-xs btn-slide btn-facebook" target="_blank" href="http://www.facebook.com/sharer/sharer.php?s=<?php echo $arow->site_url?>yazidetay.php?yazi_sef=<?php echo $row->yazi_sef; ?>&id=<?php echo $row->yazi_id ?>">
                                                        <i class="fab fa-facebook-f"></i>
                                                        <span>Facebook</span>
                                                    </a>
                                                    <a class="btn btn-xs btn-slide btn-twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $row->yazi_baslik;?>&url=<?php echo $arow->site_url?>yazidetay.php?yazi_sef=<?php echo $row->yazi_sef; ?>&id=<?php echo $row->yazi_id ?>&via=<?php echo $arow->site_baslik; ?>" data-width="100">
                                                        <i class="fab fa-twitter"></i>
                                                        <span>Twitter</span>
                                                    </a>
                                                    <a class="btn btn-xs btn-slide btn-googleplus" target="_blank" href="mailto:<?php echo $arow->site_mail; ?>?subject=<?php echo $row->yazi_baslik;?>&body=<?php echo $arow->site_url?>/yazidetay.php?yazi_sef=<?php echo $row->yazi_sef; ?>&id=<?php echo $row->yazi_id ?>" data-width="80">
                                                        <i class="far fa-envelope"></i>
                                                        <span>Mail</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="word-wrap: break-word;">
                                                <?php echo $row->yazi_icerik;?>
                                            </div>
                                           
                                        </div>
                                        <div class="post-tags">
                                            <?php
                                                $etiketler  =   explode(",",$row->yazi_etiketler);
                                                $dizi       =   array();
                                                foreach($etiketler as $etiket){
                                                    $dizi[] =   '<a title="'.$etiket.'" href="etiketdetay.php?etiket='.sef_link($etiket).'">'.$etiket.'</a>';
                                                }
                                                $sonuc  =   implode(' ',$dizi);
                                                echo $sonuc;
                                            ?>
                                        </div>
                                        <div class="post-navigation">
                                            <?php 
                                                if($oncekiKonu->rowCount()){
                                            ?>
                                                <a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?php echo $oncekikonurow->yazi_sef; ?>&id=<?php echo $oncekikonurow->yazi_id; ?>" class="post-prev">
                                                    <div class="post-prev-title"><span>Önceki Konu</span><?php echo $oncekikonurow->yazi_baslik?></div>
                                                </a>
                                            <?php
                                                }else{
                                            ?>
                                                <a href="#" class="post-prev">
                                                    <div class="post-prev-title"><span>Önceki Konu</span>Önceki konu bulunmuyor</div>
                                                </a>
                                            <?php
                                                }
                                            ?>
                                            
                                            <a href="blog-masonry-3.html" class="post-all">
                                                <i class="icon-grid"></i>
                                            </a>
                                            <?php 
                                                if($sornakikonu->rowCount()){
                                            ?>
                                                <a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?php echo $sonrakikonurow->yazi_sef; ?>&id=<?php echo $sonrakikonurow->yazi_id; ?>" class="post-next">
                                                    <div class="post-next-title"><span>Sonraki Konu</span><?php echo $sonrakikonurow->yazi_baslik?></div>
                                                </a>
                                            <?php
                                                }else{
                                            ?>
                                                <a href="#" class="post-next">
                                                    <div class="post-next-title"><span>Sonraki Konu</span>Sonraki konu bulunmuyor</div>
                                                </a>
                                            <?php
                                                }
                                            ?>
                                            
                                        </div>
                                        <!-- Comments -->
                                        <?php
                                        $yorumlar = $db->prepare("SELECT * FROM yorumlar WHERE yorum_yazi_id =:id AND yorum_durum=:d");
                                        $yorumlar->execute([':id'=>$row->yazi_id,':d'=>1]);
                                        ?>
                                        <div class="comments" id="comments">
                                            <div class="comment_number">
                                                Yorumlar <span>(<?php echo $yorumlar->rowCount();?>)</span>
                                            </div>
                                            <div class="comment-list">
                                                <!-- Comment -->
                                                    <?php
                                                    if($yorumlar->rowCount()){
                                                        foreach ($yorumlar as $yorum) {
                                                        ?>
                                                        
                                                            <div class="comment" id="comment-2">
                                                                <div class="image"><img alt="comment.png" src="<?php echo $arow->site_url;?>/images/comment.png" class="avatar"></div>
                                                                <div class="text">
                                                                    <?php if($yorum["yorum_website"] == null){
                                                                    ?>
                                                                        <h5 class="name"><?php echo $yorum["yorum_isim"];?></h5>
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                        <a href="<?php echo $yorum["yorum_website"];?>" target="_blank"><h5 class="name"><?php echo $yorum["yorum_isim"];?></h5></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="comment_date"><?php echo date('d.m.y',strtotime($yorum["yorum_tarih"]));?></span>
                                                                    <div class="text_holder">
                                                                        <p><?php echo $yorum["yorum_icerik"];?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                                 <hr>   
                                                        <?php
                                                        }
                                                    
                                                    }else{
                                                        echo '<div class="alert alert-danger">Bu konuyuya yorum yapılmamıştır.</div>';
                                                    }
                                                ?>
                                                <!-- end: Comment -->
                                            </div>
                                        </div>
                                        <!-- end: Comments -->
                                        <div class="respond-form" id="respond">
                                            <div class="respond-comment">
                                                <span>Yorum</span> için formu kullanınız</div>
                                            <form class="form-gray-fields" id="yorumformu"action="" method="POST" onsubmit="return false">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="upper" for="name">Ad Soyad</label>
                                                            <input class="form-control required" name="adsoyad" placeholder="Ad soyad giriniz" id="name" aria-required="true" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="upper" for="email">E-posta (yayınlanmayacaktır)</label>
                                                            <input class="form-control required email" name="eposta" placeholder="E-posta giriniz" id="email" aria-required="true" type="email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="upper" for="website">Website (isteğe bağlı)</label>
                                                            <input class="form-control website" name="website" placeholder='"http://"  kullanarak giriniz' id="website" aria-required="false" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="upper" for="comment">Yorumunuz</label>
                                                            <textarea class="form-control required" name="yorum" rows="9" placeholder="Yorum giriniz..." id="comment" aria-required="true"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group text-center">
                                                            <input type="hidden" value="<?php echo $row->yazi_id; ?>" name="yaziid">
                                                            <button class="btn" onclick="yorumyap();" type="submit">Yorum Yap</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end: Post single item-->
                            </div>
                            <?php
                            }else{
                                header('location:'.$arow->site_url);
                            }
                        ?>

                    </div>
                    <!-- end: content -->

                    <!-- Sidebar-->
         <?php require_once 'inc/sidebar.php' ?>
                    <!-- end: Sidebar-->
                </div>
            </div>
        </section>
        <!-- end: Page Content -->
       

<!-- Footer -->
<?php require_once 'inc/footer.php'; ?>