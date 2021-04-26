<?php if (strcmp($this->params['_pageType'], "home")) {
            $searchQuery = NULL;
            if (strcmp($this->params['_pageType'], "search") == 0) $searchQuery = $this->params['_searchQuery'];
			if (isset($searchQuery)) $stextval = $searchQuery;
			else $stextval = "";
		}
?>

<div id=search>
	<div id="searchbar">
		<form name="searchform" action="/search/" method=get id="searchform">
			<input type="text" class="searchquery" name=q placeholder= "Search Hadith" value="<?php echo htmlspecialchars(strip_tags($stextval)); ?>" />
			<input type="submit" class="searchsubmit" value="l" />
		</form>
		<div class="searchtipscontainer">
			<a class="searchtipslink" title="Search tips"><i class="icn-lightbulb"></i></a>
			<div id="searchtips">
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
