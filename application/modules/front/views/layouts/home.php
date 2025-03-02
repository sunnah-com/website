<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" translate="no">
<head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PD11DFYVJC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PD11DFYVJC');
</script>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in several languages"/>
  <meta name="keywords" content="hadith, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>

  <meta property="og:image" content="https://sunnah.com/images/fb_logo.png" />
  <meta property="og:url" content="https://sunnah.com/" />
  <meta property="og:title" content="Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)" />
  <meta property="og:description" content="Hadith of the Prophet Muhammad (saws) in several languages" />
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?php echo $this->context->auto_version('/css/all.css'); ?>" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo $this->context->auto_version('/css/donate.css'); ?>" media="screen" rel="stylesheet" type="text/css" />

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="128x128" href="/favicon-128x128.png">
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />
  <link rel="image_src" href="/images/fb_logo.png" />

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>

  <?php
    $bodyClass = "home";
    if (array_key_exists("showCarousel", Yii::$app->params)) { 
        $bodyClass .= " has_right_panel ".Yii::$app->params['showCarousel'];
  ?>
  <script src="<?php echo $this->context->auto_version('/js/carousel.js'); ?>"></script>
  <script type="text/javascript">
    jQuery(document).ready(function() {

    $.ajax({
    url: '/selectiondata/<?php echo Yii::$app->params['showCarousel']; ?>',
        async: false,
        success: function (data) {
            $("#hcarousel").append(data);
            carouselStart();
        },
    });

  });
  </script>

  <?php } ?>

  <script src="<?php echo $this->context->auto_version('/js/sunnah.js'); ?>"></script>
 
  <title>
	<?php echo $this->context->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
  <?php $this->head() ?>
</head>

<body class="<?php echo $bodyClass; ?>">
<?php $this->beginBody() ?>
<div id="site">
	<div id="header">
    	<div id="toolbar">
       		<div id="toolbarRight">
				<?php echo $this->render('suite') ?>
	        </div>
    	</div>

		<a href="https://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<div class=clear></div>
	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id=nonheader>
<!--	<div class="mainCont" style="width: 70%; float: left"><div id="main"> -->
	<div class="mainContainer"><div id="main">
	        <?php 
				echo "<div class=clear></div>";
				echo $content; 
			?>
	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->

    <?php if (array_key_exists("showCarousel", Yii::$app->params)) { ?>
	<div id=rightPanel>
		<?php echo $this->render('/index/carousel', $this->params['carouselParams']) ?>
	</div>
    <?php } ?>

	<div class="clear"></div>
	</div> <!-- nonheader close -->
    <?php echo $this->render('//layouts/footer') ?>
	<div class="clear"></div>

</div><!-- site div close -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
