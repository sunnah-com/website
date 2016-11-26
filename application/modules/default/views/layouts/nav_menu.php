<?php $pageType = $this->_pageType; ?>

<div class="menu">
  <ul>
	<?php 	if (strcmp($pageType, "home") == 0) echo '<li><span class="selectedMenuItem"><a href="/">Home</a></span></li>'."\n";
				  	else echo '<li><a href="/">Home</a></li>'."\n";
		 	if (strcmp($pageType, "collection") == 0 or strcmp($pageType, "book") == 0 or strcmp($pageType, "hadith") == 0) echo '<li><span class="selectedMenuItem"><a href="/" target="_self">Collections</a></span>'."\n";
				  	else echo '<li><a href="/" target="_self" >Collections</a>'."\n";
    ?>
      <ul>
        <li><a href="/bukhari" target="_self">Sahih al-Bukhari</a></li>
        <li><a href="/muslim" target="_self">Sahih Muslim</a></li>
        <li><a href="/nasai" target="_self">Sunan an-Nasa'i</a></li>
        <li><a href="/abudawud" target="_self">Sunan Abi Dawud</a></li>
        <li><a href="/tirmidhi" target="_self">Jami` at-Tirmidhi*</a></li>
        <li><a href="/ibnmajah" target="_self">Sunan Ibn Majah*</a></li>
        <li><a href="/malik" target="_self">Muwatta Imam Malik</a></li>
        <li><a href="/nawawi40" target="_self">Imam Nawawi's 40 Hadith</a></li>
        <li><a href="/riyadussaliheen" target="_self">Riyad as-Salihin</a></li>
        <li><a href="/adab" target="_self">Al-Adab Al-Mufrad*</a></li>
        <li><a href="/qudsi40" target="_self">40 Hadith Qudsi</a></li>
        <li><a href="/shamail" target="_self">Shama'il Muhammadiyah</a></li>
        <li><a href="/bulugh" target="_self">Bulugh al-Maram*</a></li>
      </ul></li>
	<?php	
			if (strcmp($pageType, "about") == 0) echo '<li><span class="selectedMenuItem"><a href="/about">About</a></span><ul>'."\n";
			else echo '<li><a href="/about">About</a><ul>'."\n";
			echo '<li><a href="/about">The Website</a>'."\n";
            echo '<li><a href="/support">Support Us</a></li>'."\n"; 
			echo '<li><a href="/news">News</a></li>'."\n";
			echo '<li><a href="/changelog">Change Log</a></li>'."\n";
			echo '</ul></li>';
			if (strcmp($pageType, "contact") == 0) echo '<li><span class="selectedMenuItem"><a href="/contact">Contact</a></span></li>'."\n";
			else echo '<li><a href="/contact">Contact</a></li>'."\n";
        ?>

		<?php if (strcmp($pageType, "home")) { 
			$searchQuery = NULL;
			if (strcmp($pageType, "search") == 0) $searchQuery = $this->_searchQuery;
		?>
		<div style="float: right; padding-right: 10px; padding-top:2px;"><a href="/searchtips" style="font-weight: normal; font-size: 10px; color: #000000;">Search Tips</a></div>
		<div style="float: right; display: inline; padding-right: 7px; padding-top: 2px; vertical-align: center; height: 95%;">
			<form name="searchform" action="/search_redirect.php" method=get style="height: 100%;" id="searchform">
                <input type="text" size="25" class="input_search" name=query value="<?php echo htmlspecialchars($searchQuery); ?>" id="searchBox"/>
            	<input type="submit" class="search_button" value="Search" />
           	</form>	
		</div>
		<?php } ?>
	</ul>
        <div class="clear"></div>
</div>
