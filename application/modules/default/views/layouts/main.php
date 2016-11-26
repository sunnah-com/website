<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php if (isset($this->_book) and (
			//$this->_book->indonesianBookID > 0 or
			$this->_book->urduBookID > 0
			)
		) echo "<meta name=\"fragment\" content=\"!\">\n"; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, hadeeth, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>
 
  <meta property="og:image" content="http://sunnah.com/images/hadith_icon2_huge.png" />
  <?php if (isset($this->_ogDesc)) echo "<meta property=\"og:description\" content=\"".htmlspecialchars($this->_ogDesc)."\" />"; ?>

  <link href="/css/all.css" media="screen" rel="stylesheet" type="text/css" />

  <link rel="shortcut icon" href="/favicon.ico" >
  <link rel="image_src" href="/images/hadith_icon2.png" />
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />
  <link rel="icon" href="/images/apple-touch-icon.png" />

  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
  <!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->
  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>
  <!--<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js" async></script>-->

  <?php if (isset($this->_book)) { 
	$langarray = array();
	//if ($this->_book->indonesianBookID > 0) $langarray[] = 'indonesian';
	if ($this->_book->urduBookID > 0) $langarray[] = 'urdu'; ?>

	<script>
	    var collection = '<?php echo $this->_collectionName; ?>';
	    var bookID = '<?php echo $this->_ourBookID; ?>';
		var pageType = 'hadithtext';
		var spshowing = <?php if (count($langarray) > 0) echo "true"; else echo "false"; ?>;
		<?php
            if (count($langarray) > 0) echo "var avbl_languages = ".json_encode($langarray).";\n";
        ?>	</script>
  <?php } ?>
	<script>
	<?php if (strcmp($this->_pageType, "search") == 0) echo "var searchQuery = '".htmlentities(stripslashes($this->_searchQuery))."';";  ?>
	</script>
  <script src="/js/sunnah.js"></script>
  <!--<script src="https://apis.google.com/js/platform.js" async defer></script>-->
 
  <title>
	<?php echo $this->titleString() ?>
	Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
</head>

<body>
<div id="fb-root"></div>
	
<div id="site">

	<div id="header">
    	<div id="toolbar">
       		<div id="toolbarRight">
				<?php $this->renderPartial('/layouts/suite') ?>
	        </div>
    	</div>

		<a href="https://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<!-- <a href="#"><div id=back-to-top></div></a> -->
		<?php if (strcmp($this->_pageType, "home") != 0) $this->renderPartial('/layouts/searchbox'); ?>
		<div class=clear></div>
		<?php
			  if (strcmp($this->_pageType, "home")) {
					echo "<div class=crumbs>".$this->pathCrumbs("Home", "/")."</div>";
					echo "<div class=clear></div>";
				}
		?>
	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id=nonheader" style="position: relative;">
	<div class="sidePanelContainer">
		<div style="height: 1px;"></div>
		<div id="sidePanel">
			<?php if (isset($this->_book)) {
		    	if (count($langarray) > 0) $this->renderPartial('/layouts/side_panel', array('langarray' => $langarray));
			 } ?>
    	</div>
	</div><!-- sidePanelContainer close -->
	<div class="mainContainer"><div id="main">
	        <?php 
				echo "<div class=clear></div>";
				echo $content; 
			?>
	<div class="clear"></div>
    </div><!-- main close -->
	</div> <!-- mainContainer close -->
	<a href="#"><div id=back-to-top></div></a>
	<div class="clear"></div>
	</div> <!-- nonheader close -->
    <?php $this->renderPartial('//layouts/footer') ?>
	<div class="clear"></div>

</div><!-- site div close -->
</body>
</html>

