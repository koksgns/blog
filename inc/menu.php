<?php 
echo !defined("guvenlik") ? die() : null;
?>
<header id="header">
            <div class="header-inner" style="border-bottom: 1px solid #cccccc;">
                <div class="container">
                    <!--Logo-->
                    <div id="logo">
                        <a href="<?php echo $arow->site_url; ?>" class="logo" data-src-dark="images/<?php echo $arow->site_logo; ?>"> <img src="images/<?php echo $arow->site_logo; ?>" alt="Polo Logo"> </a>
                    </div>
                    <!--End: Logo-->

                                        <!-- Search -->
                    <div id="search">
                        <div id="search-logo"><img src="images/logo.png" alt="Polo Logo"></div>
                        <button id="btn-search-close" class="btn-search-close" aria-label="Close search form"><i
                                class="icon-x"></i></button>
                        <form class="search-form" action="search.php" method="get">
                            <input class="form-control" name="q" type="search" placeholder="Yazı arayın..."
                                autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                            <span class="text-muted">Yazı başlığı belirterek arama yapabilirsiniz yada ESC tuşuna basarak çıkabilirsiniz</span>
                        </form>

                        <div class="search-suggestion-wrapper">
                        <?php
                            $populer = $db->prepare("SELECT * FROM yazilar WHERE yazi_durum=:d ORDER bY yazi_goruntulenme DESC LIMIT :lim");
                            $populer->bindValue(':d',(int) 1,PDO::PARAM_INT);
                            $populer->bindValue(':lim',(int) 3,PDO::PARAM_INT);
                            $populer->execute();
                            if($populer->rowCount()){
                                foreach ($populer as $item) {
                        ?>

                            <div class="search-suggestion">
                                <h3><?php echo $item['yazi_baslik']; ?></h3>
                                <p><a href="#"><?php echo mb_substr($item['yazi_icerik'],0,250,'utf8'); ?></a></p>
                                <p><a href="<?php echo $arow->site_url; ?>/yazidetay.php?yazi_sef=<?php echo $item['yazi_sef'];?>&id=<?php echo $item['yazi_id']; ?>">Devamını oku</a></p>
                            </div>
                        <?php
                                }
                            }
                        ?>

                        </div>
                    </div>
                    <!-- end: search -->

                    <!--Header Extras-->
                    <div class="header-extras">
                        <ul>
                           <li>
                                <!--search icon-->
                                <a id="btn-search" href="#"> <i class="icon-search1"></i></a>
                                <!--end: search icon-->
                            </li>
                            
                        </ul>
                    </div>
                    <!--end: Header Extras-->
                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <button class="lines-button x"> <span class="lines"></span> </button>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->

                    <!--Navigation-->
                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="<?php echo $arow->site_url; ?>"><i class="fa fa-home"></i>Ana Sayfa</a></li>
                                    <li class="dropdown"> <a href="#"><i class="fa fa-list"></i>Kategoriler</a>
                                        <ul class="dropdown-menu">
                                            <?php
                                                $kategoriler = $db ->prepare("SELECT * FROM kategoriler");
                                                $kategoriler->execute();
                                                if($kategoriler->rowCount()){
                                                    foreach($kategoriler as $row){
                                                        $yazilaribul    =   $db->prepare("SELECT yazi_kat_id,yazi_durum FROM yazilar WHERE yazi_kat_id=:id");
                                                        $yazilaribul->execute([':id'=>$row["id"]]);
                                                        
                                                        echo '<li><a href="'.$arow->site_url.'/kategoriler.php?kat_sef='.$row['kat_sef'].'">'.$row['kat_adi'].'( '.$yazilaribul->rowCount().' ) </a></li>';
                                                    }
                                                }
                                            ?>
                                             
                                        </ul> 
                                    </li>
                                    <li><a href="<?php echo $arow->site_url; ?>/iletisim.php"><i class="fa fa-envelope"></i>İletişim</a></li>
                                    <li><a href="<?php echo $arow->site_url; ?>/yonetim"><i class="fa fa-sign-in"></i>Giriş Yap</a></li>
									
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--END: NAVIGATION-->
                </div>
            </div>
        </header>