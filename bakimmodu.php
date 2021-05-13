<?php
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

$ayarlar = $db->prepare("SELECT * FROM ayarlar");
$ayarlar->execute();
$arow   =   $ayarlar->fetch(PDO::FETCH_OBJ);
$site           =   $arow->site_url;
$sitebaslik     =   $arow->site_baslik;
$logo           =   $arow->site_logo;
$sitekeyw       =   $arow->site_keyw;
$sitedesc       =   $arow->site_desc;
$favicon		=	$arow->site_favicon;
if($arow->site_durum == 1){
    header("Location:index.php");
}

?>

<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="author" content="<?php echo $sitebaslik; ?>" />
    <meta name="description" content="<?php echo $sitedesc; ?>"/>
    <meta name="keywords" content="<?php echo $sitekeyw; ?>"/>
    <!-- Document title -->
    <title><?php echo $sitebaslik; ?></title>
	<link rel="icon" type="image/" href="<?php echo $site.'/images/'.$favicon; ?>">
	
	<!-- Font -->
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700%7CPoppins:400,500" rel="stylesheet">
	
	
		
	<style>
	

		/* Screens Resolution : 992px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 1200px) {

		}

		/* Screens Resolution : 992px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 992px) {
			
			

		}


		/* Screens Resolution : 767px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 767px) {
			
			/* ---------------------------------
			1. PRIMARY STYLES
			--------------------------------- */

			p{ line-height: 1.4; }

			h1{ font-size: 2.8em; line-height: 1; }
			h2{ font-size: 2.2em; line-height: 1.1; }
			h3{ font-size: 1.8em; }
			
			
			/* ---------------------------------
			3. MAIN SECTION
			--------------------------------- */
			
			.main-area-wrapper{  height: 100%; padding: 0px; }
			
			
			/* TIME COUNTDOWN */

			#normal-countdown .time-sec{ height: 70px; width: 70px; margin: 5px; }

			#normal-countdown .time-sec .main-time{ line-height: 55px; font-size: 1.8em;}
			
			#normal-countdown .time-sec span{ bottom: 12px; }
			
		}

		/* Screens Resolution : 479px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 479px) {

			/* ---------------------------------
			1. PRIMARY STYLES
			--------------------------------- */

			body{ font-size: 12px; }
			
			/* ---------------------------------
			3. MAIN SECTION
			--------------------------------- */
			
			/* TIME COUNTDOWN */

			#normal-countdown .time-sec{ height: 60px; width: 60px; margin: 5px; }

			#normal-countdown .time-sec .main-time{ line-height: 45px; font-size: 1.5em;}
			
		}

		/* Screens Resolution : 359px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 359px) {
			
			
		}

		/* Screens Resolution : 290px
		-------------------------------------------------------------------------- */
		@media only screen and (max-width: 290px) {
			
			
		}



		html{ font-size: 100%; height: 100%; width: 100%; overflow-x: hidden; margin: 0px;  padding: 0px; touch-action: manipulation; }


		body{ font-size: 16px; font-family: 'Open Sans', sans-serif; width: 100%; height: 100%; margin: 0; font-weight: 400;
			-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; word-wrap: break-word; overflow-x: hidden; 
			color: #333; }

		h1, h2, h3, h4, h5, h6, p, a, ul, span, li, img, inpot, button{ margin: 0; padding: 0; }

		h1,h2,h3,h4,h5,h6{ line-height: 1.5; font-weight: inherit; }

		h1,h2,h3{ font-family: 'Poppins', sans-serif; }

		p{ line-height: 1.6; font-size: 1.05em; font-weight: 400; color: #555; }

		h1{ font-size: 3.5em; line-height: 1; }
		h2{ font-size: 3em; line-height: 1.1; }
		h3{ font-size: 2.5em; }
		h4{ font-size: 1.5em; }
		h5{ font-size: 1.2em; }
		h6{ font-size: .9em; letter-spacing: 1px; }

		a, button{ display: inline-block; text-decoration: none; color: inherit; transition: all .3s; line-height: 1; }

		a:focus, a:active, a:hover,
		button:focus, button:active, button:hover,
		a b.light-color:hover{ text-decoration: none; color: #E45F74; }

		b{ font-weight: 500; }

		img{ width: 100%; }

		li{ list-style: none; display: inline-block; }

		span{ display: inline-block; }

		button{ outline: 0; border: 0; background: none; cursor: pointer; }

		b.light-color{ color: #444; }

		.icon{ font-size: 1.1em; display: inline-block; line-height: inherit; }

		[class^="icon-"]:before, [class*=" icon-"]:before{ line-height: inherit; }

		*, *::before, *::after {
			-webkit-box-sizing: inherit;
			box-sizing: inherit;
		}

		*, *::before, *::after {
			-webkit-box-sizing: inherit;
			box-sizing: inherit;} 

			
		/* ---------------------------------
		2. COMMONS FOR PAGE DESIGN
		--------------------------------- */

		.center-text{ text-align: center; } 

		.display-table{ display: table; height: 100%; width: 100%; }

		.display-table-cell{ display: table-cell; vertical-align: middle; }



		::-webkit-input-placeholder { font-size: .9em; letter-spacing: 1px; }

		::-moz-placeholder { font-size: .9em; letter-spacing: 1px; }

		:-ms-input-placeholder { font-size: .9em; letter-spacing: 1px; }

		:-moz-placeholder { font-size: .9em; letter-spacing: 1px; }


		.full-height{ height: 100%; }

		.position-static{ position: static; }

		.font-white{ color: #fff; }


		/* ---------------------------------
		3. MAIN SECTION
		--------------------------------- */

		.main-area-wrapper{  height: calc( 100% - 40px); padding: 20px; background-size: cover; }

		.main-area{ position: relative; z-index: 1; height: 100%; padding: 0 20px;
			box-shadow: 2px 5px 30px rgba(0,0,0,.3); color: #fff; }

		.main-area:after{ content:''; position: absolute; top: 0; bottom: 0;left: 0; right: 0; z-index: -1;  
			opacity: .4; background: #000; }

		.main-area .desc{ margin: 20px auto; max-width: 500px; }
			
		.main-area .notify-btn{ margin: 20px 0 50px; padding: 13px 35px; border-radius: 50px; border: 2px solid #F84982;
			color: #fff; background: #F84982; }

		.main-area .notify-btn:hover{ background: none; }


		/* TIME COUNTDOWN */

		#normal-countdown{ text-align: center; }

		#normal-countdown .time-sec{ position: relative; display: inline-block; margin: 10px; height: 90px; width: 90px; 
			border-radius: 100px; background: #fff; color: #333; }

		#normal-countdown .time-sec .main-time{ font-weight: 500; line-height: 70px; font-size: 2em; color: #F84982; }

		#normal-countdown .time-sec span{ position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
			font-size: .9em; font-weight: 600; }


		/* SOCIAL BTN */

		.main-area .social-btn{ position: absolute; bottom: 30px; width: 100%; left: 50%; transform: translateX(-50%); }


		.main-area .social-btn .list-heading{ display: block; margin-bottom: 15px; }

		.main-area .social-btn > li > a > i{ display: inline-block; height: 35px; width: 35px; line-height: 35px; border-radius: 40px;
			font-size: 1.04em; margin: 0 5px; }

		.main-area .social-btn > li > a > i:hover{ background: #fff!important; }	
			
		.main-area .social-btn > li > a > i{ background: #2A61D6; }


	</style>
	
</head>
<body>
	
	<div class="main-area-wrapper" style="background-image:url(images/countdown-6-1600x900.jpg);">
		<div class="main-area center-text" >
			
			<div class="display-table">
				<div class="display-table-cell">
					
					<h1 class="title"><b>Bakımdayız</b></h1>
					<p class="desc font-white">Sistemimizde yapılan değişikliklerden dolayı sizlere şu anda hizmet sunamıyoruz. Lütfen daha Sonra tekrar geliniz.</p>
					
					<div id="normal-countdown" data-date="2018/01/01"></div>
					
					<a class="notify-btn" href="<?php echo $site; ?>"><b><?php echo $sitebaslik; ?></b></a>
					
					<ul class="social-btn">
						<li class="list-heading">Takipte kalın</li>
						<?php
                            $sosyalMedya    =   $db->prepare("SELECT * FROM sosyalmedya WHERE durum = :d");
                            $sosyalMedya->execute([':d' => 1]);
                            if($sosyalMedya){
                                foreach($sosyalMedya as $item){
                                    ?>
                                        <li><a href="<?php echo $item['link']; ?>" target="blank"><i class="fa fa-<?php echo $item['ikon']; ?> fa-lg"></i></a></li>
                                    <?php
                                }
                            }
                        ?>
					</ul>
					
				</div><!-- display-table -->
			</div><!-- display-table-cell -->
		</div><!-- main-area -->
	</div><!-- main-area-wrapper -->
	
	<script src="https://use.fontawesome.com/24eacb6277.js"></script>
</body>
</html>