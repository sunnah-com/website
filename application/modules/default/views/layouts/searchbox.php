<?php if (strcmp($this->_pageType, "home")) {
            $searchQuery = NULL;
            if (strcmp($this->_pageType, "search") == 0) $searchQuery = $this->_searchQuery;
			if (isset($searchQuery)) $stextval = $searchQuery;
			else $stextval = "Search …";
		}
?>

<div id=search>
    <a class="searchtipslink">Search Tips</a>
    <div id="searchbar" class="sblur">
        <form name="searchform" action="/search/" method=get id="searchform">
            <input type="text" class="searchquery" name=q value="<?php echo $stextval; ?>" />
            <input type="submit" style="background-image: url('/images/search_small.png'); border: solid 0px #000000;" class="searchsubmit" value="" />
        </form>
    </div>

	<div id="searchtips">
		<div class=clear></div>
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
	<div class=clear></div>
	</div>
</div>
