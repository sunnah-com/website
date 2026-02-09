<?php 
    $primaryCollections = array_filter($collections, function($c) { return $c['type'] === 'collection'; });
    $selectionCollections = array_filter($collections, function($c) { return $c['type'] === 'selection'; });
    $primaryCollections = array_values($primaryCollections);
    $selectionCollections = array_values($selectionCollections);
    $primarySplit = round(count($primaryCollections) / 2, 0, PHP_ROUND_HALF_UP);
    $selectionSplit = round(count($selectionCollections) / 2, 0, PHP_ROUND_HALF_UP);
?>

	<div class="donation-banner-container">
		<div class="donation-banner">
			<p>Support Sunnah.com</p>
			<a href="/donate" class="donate-btn">Donate</a>
		</div>
	</div>

	<div align=center id="indextag">
		The Hadith of the Prophet Muhammad (صلى الله عليه و سلم) at your fingertips
	</div>

	<div class="indexsearchcontainer">
	<div id="indexsearch">
 	 	<form name="searchform" action="/search/" method=get id="searchform">
       		<input type="text" class="indexsearchquery" name=q placeholder="Search &#8230;" value="" />
                <input type="submit" class="indexsearchsubmit" value="l" />
		</form>
	</div>
	<a class="indexsearchtipslink">Search Tips</a>
    <div id="indexsearchtips">
        <b>Quotes</b> e.g. "pledge allegiance"<br>
        Searches for the whole phrase instead of individual words
        <p>
        <b>Wildcards</b> e.g. test*<br>
        Matches any set of one or more characters. For example test* would result in test, tester, testers, etc.
        <p>
        <b>Fuzzy Search</b> e.g. swore~<br>
        Finds terms that are similar in spelling. For example swore~ would result in swore, snore, score, etc.
        <p>
        <b>Term Boosting</b> e.g. pledge^4 hijrah<br>
        Boosts words with higher relevance. Here, the word <i>pledge</i> will have higher weight than <i>hijrah</i>
        <p>
        <b>Boolean Operators</b> e.g. ("pledge allegiance" OR "shelter) AND prayer<br>
        Create complex phrase and word queries by using Boolean logic.
        <p>
        <a href="/searchtips">More ...</a>
    </div>
	<div class=clear></div>
	</div>

	<!-- Primary Collections Section -->
	<div class="collection-section">
		<div class="collection-section-header">
			<span class="collection-section-title">Primary Collections</span>
			<span class="collection-section-title-arabic arabic">المصادر الأصلية</span>
		</div>
		<div class="collections">
			<div class="collection_titles" style="padding-right: 6px;">
				<?php 
					for ($i = 0; $i < $primarySplit; $i++) {
						$collection = $primaryCollections[$i];
						?>
						<div class="collection_title">
							<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
								<div class="english_collection_title"><?php echo $collection['englishTitle']; ?></div>
								<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
							</a>
							<div class="clear"></div>
						</div>
						<?php if ($i < $primarySplit - 1) echo '<div class="collection_sep"></div>';
				 } ?>
			</div><!-- end primary collection titles 1 -->
			<div class="collection_titles" style="float: right;">
				<?php 
					for ($i = $primarySplit; $i < count($primaryCollections); $i++) {
						$collection = $primaryCollections[$i];
						?>
						<div class="collection_title">
							<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
								<div class="english_collection_title"><?php echo $collection['englishTitle']; ?></div>
								<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
							</a>
							<div class="clear"></div>
						</div>
						<?php if ($i < count($primaryCollections) - 1) echo '<div class="collection_sep"></div>';
				 } ?>
			</div><!-- end primary collection titles 2 -->
			<div class="clear"></div>
		</div>
	</div><!-- end Primary Collections section -->

	<!-- Selections Section -->
	<div class="collection-section collection-section-selections">
		<div class="collection-section-header">
			<span class="collection-section-title">Selections</span>
			<span class="collection-section-title-arabic arabic">المصادر الثانوية</span>
		</div>
		<div class="collections">
			<div class="collection_titles" style="padding-right: 6px;">
				<?php 
					for ($i = 0; $i < $selectionSplit; $i++) {
						$collection = $selectionCollections[$i];
						?>
						<div class="collection_title">
							<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
								<div class="english_collection_title"><?php echo $collection['englishTitle']; ?></div>
								<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
							</a>
							<div class="clear"></div>
						</div>
						<?php if ($i < $selectionSplit - 1) echo '<div class="collection_sep"></div>';
				 } ?>
			</div><!-- end selection titles 1 -->
			<div class="collection_titles" style="float: right;">
				<?php 
					for ($i = $selectionSplit; $i < count($selectionCollections); $i++) {
						$collection = $selectionCollections[$i];
						?>
						<div class="collection_title">
							<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
								<div class="english_collection_title"><?php echo $collection['englishTitle']; ?></div>
								<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
							</a>
							<div class="clear"></div>
						</div>
						<?php if ($i < count($selectionCollections) - 1) echo '<div class="collection_sep"></div>';
				 } ?>
			</div><!-- end selection titles 2 -->
			<div class="clear"></div>
		</div>
	</div><!-- end Selections section -->

	<br>
	<div align=center style="color: #75A1A1;">Supported languages: English, Arabic, Urdu, Bangla</div>
