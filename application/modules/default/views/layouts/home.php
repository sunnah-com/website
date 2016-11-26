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

  <meta property="og:image" content="http://sunnah.com/images/fb_logo.png" />
  <meta property="og:url" content="http://sunnah.com/" />
  <meta property="og:title" content="Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)" />
  <meta property="og:description" content="Hadith of the Prophet Muhammad (saws) in several languages" />
 
  <link href="/css/all.css" media="screen" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="/favicon.ico" >
  <link rel="image_src" href="/images/fb_logo.png" />

  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>

  <!-- Uncomment if we need the carousel for something
  <script src="/js/jquery.jcarousel.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jcskin.css" />
  -->
  <script type="text/javascript">

	jQuery(document).ready(function() {

	//$('#ramadancarousel').load('/default/collection/ramadandata');

	//$.get('/default/collection/ramadandata', function(data) {
	//	$("#ramadancarousel").innerHTML(data);
	//});

	/* This is the one to use 
	$.ajax({
		url: '/default/collection/ramadandata',
		async: false,
		success: function (data) { $("#ramadancarousel").append(data); },
	}); // this is the one to enable

    jQuery('#ramadancarousel').jcarousel({
        size: 13,
		vertical: false,
		visible: 1,
		scroll: 1,
		auto: 10,
		wrap: "circular",
		buttonNextHTML: null,
		buttonPrevHTML: null,
    }); */
  });
  </script>


  <script src="/js/sunnah.js"></script>
 
  <title>
	<?php echo $this->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
</head>

<body>
<div id="site">

	<div id="header">
    	<div id="toolbar">
       		<div id="toolbarRight">
				<?php $this->renderPartial('/layouts/suite') ?>
	        </div>
    	</div>

		<a href="https://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<div class=clear></div>
	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id=nonheader style="position: relative; margin: 0 10px 0 30px;">
<!--	<div class="mainCont" style="width: 70%; float: left"><div id="main"> -->
	<div class="mainCont" style="width: 70%; margin: auto"><div id="main">
	        <?php 
				echo "<div class=clear></div>";
				echo $content; 
			?>
	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->

<!--
	<div id=rightPanel>
		<?php $this->renderPartial('/index/ramadancarousel') ?>
	</div>
-->

	<div class="clear"></div>
	</div> <!-- nonheader close -->
    <?php $this->renderPartial('//layouts/footer') ?>
	<div class="clear"></div>

</div><!-- site div close -->
</body>
</html>

