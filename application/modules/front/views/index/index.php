<?php
$num_collections = count($collections);
$splitSize = round($num_collections / 2, 0, PHP_ROUND_HALF_UP);
?>

<div align=center id="indextag">
	The Hadith of the Prophet Muhammad (صلى الله عليه و سلم) at your fingertips
</div>

<div class="indexsearchcontainer">
    <div id="indexsearch" style="display: inline; padding-right: 7px; padding-top: 2px; vertical-align: center; height: 95%;">
        <form name="searchform" action="/search_redirect.php" method="get" style="height: 100%;" id="searchform">
            <div class="searchbox-container" style="display: inline-block;">
                <!-- Adjust name/placeholder as needed; "query" matches the new code -->
                <input type="text" size="25" class="indexsearchquery input_search" 
                       name="query"
                       placeholder="Search…" 
                       value="<?php echo isset($searchQuery) ? htmlspecialchars($searchQuery) : ''; ?>" 
                       id="searchBox" />

                <!-- The dropdown with checkboxes -->
                <div class="dropdown" id="optionsDropdown">
                    <label><input type="checkbox" name="collection[]" value="bukhari"> Bukhari</label>
                    <label><input type="checkbox" name="collection[]" value="muslim"> Muslim</label>
                    <label><input type="checkbox" name="collection[]" value="tirmidhi"> Tirmidhi</label>
                    <label><input type="checkbox" name="collection[]" value="nasai"> Nasai</label>
                    <label><input type="checkbox" name="collection[]" value="abudawud"> Abu Dawud</label>
                    <!-- You can add or remove checkboxes as you like -->
                </div>

                <input type="submit" class="indexsearchsubmit search_button" value="l" id="searchButton" />
            </div>
        </form>
    </div>

    <!-- Keeping your "Search Tips" link and tips container from original -->
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

    <div class="clear"></div>
</div>


<div class=collections>
	<div class="collection_titles" style="padding-right: 6px;">
		<?php
		for ($i = 0; $i < $splitSize; $i++) {
			$collection = $collections[$i];
			?>
			<div class=collection_title>
				<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
					<div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
					<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
				</a>
				<div class="clear"></div>
			</div>
			<?php if ($i < $splitSize - 1)
				echo '<div class="collection_sep"></div>';
		} ?>
	</div><!-- end collection titles 1 -->
	<div class="collection_titles" style="float: right;">
		<?php
		for ($i = $splitSize; $i < $num_collections; $i++) {
			$collection = $collections[$i];
			?>
			<div class=collection_title>
				<a href="/<?php echo $collection['name']; ?>" style="display: inline;">
					<div class=english_collection_title><?php echo $collection['englishTitle']; ?></div>
					<div class="arabic arabic_collection_title"><?php echo $collection['arabicTitle']; ?></div>
				</a>
				<div class="clear"></div>
			</div>
			<?php if ($i < $num_collections - 1)
				echo '<div class="collection_sep"></div>';
		} ?>
	</div><!-- end collection titles 2 -->
	<div class="clear"></div>
</div> <!-- end collections div -->
<br>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchBox = document.getElementById('searchBox');
        const optionsDropdown = document.getElementById('optionsDropdown');

        // Show dropdown when input is focused
        searchBox.addEventListener('focus', () => {
            optionsDropdown.classList.add('active');
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!searchBox.contains(event.target) && !optionsDropdown.contains(event.target)) {
                optionsDropdown.classList.remove('active');
            }
        });

        // Prevent dropdown from closing when clicking inside
        optionsDropdown.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    });
</script>

<div align=center style="color: #75A1A1;">Supported languages: English, Arabic, Urdu, Bangla</div>