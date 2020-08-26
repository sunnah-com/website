<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

  <link rel="shortcut icon" href="/favicon.ico" >
  <link rel="image_src" href="/images/fb_logo.png" />

  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>
  <script src="<?php echo $this->context->auto_version('/js/carousel.js'); ?>"></script>

  <script type="text/javascript">
	jQuery(document).ready(function() {

	$.ajax({
		url: '/ramadandata',
		async: false,
		success: function (data) {
			$("#hcarousel").append(data);
			carouselStart();
		},
	});

  });
  </script>


  <script src="<?php echo $this->context->auto_version('/js/sunnah.js'); ?>"></script>

  <title>
	<?php echo $this->context->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
  <?php $this->head() ?>
</head>

<body class="home has_right_panel ramadan">
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

	<div id="nonheader">
	<div class="mainContainer" style="float: left"><div id="main">
	        <?php 
				echo "<div class=clear></div>";
				echo $content; 
			?>
	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->


	
	<div id=rightPanel>
		<?php echo $this->render('/index/ramadancarousel') ?>
	</div>
	

	<div class="clear"></div>
	</div> <!-- nonheader close -->
    <?php echo $this->render('//layouts/footer') ?>
	<div class="clear"></div>

</div><!-- site div close -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


