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

  <?php if (isset($this->params['book']) and (
			//$this->params['book']->indonesianBookID > 0 or
			$this->params['book']->urduBookID > 0 or
			$this->params['book']->banglaBookID > 0
			)
		) echo "<meta name=\"fragment\" content=\"!\">\n"; ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="EN"/>
  <meta name="description" content="Hadith of the Prophet Muhammad (saws) in English and Arabic"/>
  <meta name="keywords" content="hadith, hadeeth, sunnah, bukhari, muslim, sahih, sunan, tirmidhi, nawawi, holy, arabic, iman, islam, Allah, book, english"/>
  <meta name="Charset" content="UTF-8"/> 
  <meta name="Distribution" content="Global"/>
  <meta name="Rating" content="General"/>
 
  <meta property="og:image" content="https://sunnah.com/images/hadith_icon2_huge.png" />
  <?php if (isset($this->params['_ogDesc'])) echo "<meta property=\"og:description\" content=\"".htmlspecialchars($this->params['_ogDesc'])."\" />"; ?>

  <?= yii\helpers\Html::csrfMetaTags() ?>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?php echo $this->context->auto_version('/css/all.css'); ?>" media="screen" rel="stylesheet" type="text/css" />
  <link href="<?php echo $this->context->auto_version('/css/donate.css'); ?>" media="screen" rel="stylesheet" type="text/css" />
  <?php if (strcmp($this->params['_pageType'], "search") == 0) { ?>
  <link href="<?php echo $this->context->auto_version('/css/pager.css'); ?>" media="screen" rel="stylesheet" type="text/css" />
  <?php } ?>

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="128x128" href="/favicon-128x128.png">
  <link rel="image_src" href="/images/hadith_icon2.png" />
  <link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="/js/jquery.cookie.js"></script>
  <!--<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js" async></script>-->

  <?php if (isset($this->params['book'])) { 
	$langarray = array();
	//if ($this->params['book']->indonesianBookID > 0) $langarray[] = 'indonesian';
	if ($this->params['book']->urduBookID > 0) $langarray[] = 'urdu';
    if ($this->params['book']->banglaBookID > 0) $langarray[] = 'bangla'; 
  ?>

	<script>
	    var collection = '<?php echo $this->params['collection']['name']; ?>';
	    var bookID = '<?php echo $this->params['book']->ourBookID; ?>';
		var pageType = 'hadithtext';
		var spshowing = <?php if (count($langarray) > 0) echo "true"; else echo "false"; ?>;
		<?php
            if (count($langarray) > 0) echo "var avbl_languages = ".json_encode($langarray).";\n";
        ?>	</script>
  <?php } ?>
	<script>
	<?php if (strcmp($this->params['_pageType'], "search") == 0) echo "var searchQuery = '".htmlentities(stripslashes($this->params['_searchQuery']))."';";  ?>
	</script>
  <script src="<?php echo $this->context->auto_version('/js/sunnah.js'); ?>"></script>
  <!--<script src="https://apis.google.com/js/platform.js" async defer></script>-->
 
  <title>
	<?php echo $this->context->titleString() ?>Sunnah.com - Sayings and Teachings of Prophet Muhammad (صلى الله عليه و سلم)
  </title>
<?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div id="fb-root"></div>

<div id="site">
	<div id="header">
	    <!-- Donation Header -->
	    <?php if (!isset(Yii::$app->request->pathInfo) || Yii::$app->request->pathInfo !== 'donate'): ?>
	    <div id="donation-header">
		<div class="donation-header-content">
		    <span>Contribute to our mission</span>
		    <a href="/donate" class="donate-now-btn">Donate Now</a>
		</div>
	    </div>
	    <?php endif; ?>
    	<div id="toolbar">
       		<div id="toolbarRight">
				<?php echo $this->render('/layouts/suite') ?>
	        </div>
    	</div>

		<a href="https://sunnah.com"><div id="banner" class=bannerTop></div></a>
		<!-- <a href="#"><div id=back-to-top></div></a> -->
		<?php if (strcmp($this->params['_pageType'], "home") != 0) echo $this->render('/layouts/searchbox'); ?>
		<div class=clear></div>
		<?php
			  if (strcmp($this->params['_pageType'], "home")) {
					echo "<div class=crumbs>".$this->context->pathCrumbs("Home", "/")."</div>";
					echo "<div class=clear></div>";
				}
		?>
	</div>

	<div class=clear></div>
	<div id="topspace"></div>

	<div id="nonheader">
	<div class="sidePanelContainer">
		<div style="height: 1px;"></div>
		<div id="sidePanel">
			<?php if (isset($this->params['book'])) {
		    	if (count($langarray) > 0) echo $this->render('/layouts/side_panel', array('langarray' => $langarray));
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
    <?php echo $this->render('//layouts/footer') ?>
    <?php
		if ($this->params['_pageType'] === "book" || $this->params['_pageType'] === "hadith")
			echo $this->render('//layouts/clipboard_options')
	?>
	<div class="clear"></div>

</div><!-- site div close -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
