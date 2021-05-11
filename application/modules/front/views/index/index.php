<?php 
    $num_collections = count($collections);
	$splitSize=round($num_collections/2, 0, PHP_ROUND_HALF_UP);
?>
	
	<div class="hero">

		<div class="taglinecontainer">
			<div id="indextag">
				<p>The Hadith of</p>
				<p>Prophet Muhammad</p>
				<p>صلى الله عليه وسلم</p>
				<p>at your fingertips</p>
			</div>
		</div>

		<div class="searchcontainer">
			<div class="indexsearchcontainer">
				<div id="indexsearch">
					<form name="searchform" action="/search/" method=get id="indexsearchform">
						<input type="text" class="indexsearchquery" name=q placeholder="Search Hadith" value="" />
							<input type="submit" class="indexsearchsubmit" value="l" />
					</form>
					<a class="indexsearchtipslink" title="Search tips"><i class="icn-lightbulb"></i></a>
					<div id="indexsearchtips">
						<b>Quotes</b><br>
						e.g. <code>"pledge allegiance"</code><br>
						Searches for the whole phrase instead of individual words
						<p>
						<b>Wildcards</b><br>
						e.g. <code>test*</code><br>
						Matches any set of one or more characters. For example <code>test*</code> would result in test, tester, testers, etc.
						<p>
						<b>Fuzzy Search</b><br>
						e.g. <code>swore~</code><br>
						Finds terms that are similar in spelling. For example <code>swore~</code> would result in swore, snore, score, etc.
						<p>
						<b>Term Boosting</b><br>
						e.g. <code>pledge^4 hijrah</code><br>
						Boosts words with higher relevance. Here, the word <code>pledge</code> will have higher weight than <i>hijrah</i>
						<p>
						<b>Boolean Operators</b><br>
						e.g. <code>("pledge allegiance" OR "shelter) AND prayer</code><br>
						Create complex phrase and word queries by using Boolean logic.
						<p>
						<a href="/searchtips" style="float:right;">Read more ...</a>
						<div class="clear"></div>
					</div>
				</div>			
			</div>
		</div>		
	</div>

	<div class="clear"></div>

	<div class=collections>
    	<div class="collection_titles">
			<?php 
				for ($i = 0; $i < $splitSize; $i++)  {
					$collection = $collections[$i];
			?>
				<a href="/<?php echo $collection['name']; ?>">
					<div class=collection_title>
						<div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
						<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
						<div class="clear"></div>
					</div>
				</a>
			<?php } ?>
		</div><!-- end collection titles 1 -->
        <div class="collection_titles" style="float: right;">
			<?php 
				for ($i = $splitSize; $i < $num_collections; $i++) {
					$collection = $collections[$i]; 
			?>
				<a href="/<?php echo $collection['name']; ?>">
					<div class=collection_title>			
						<div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
						<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
						<div class="clear"></div>
					</div>
				</a>
			<?php } ?>
		</div><!-- end collection titles 2 -->
		<div class="clear"></div>
	</div> <!-- end collections div -->
	<br>
	<div align=center style="color: #75A1A1;">Supported languages: English, Arabic, Urdu</div>
