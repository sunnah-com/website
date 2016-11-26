<?php 

if (isset($this->_viewVars->errorMsg)) echo $this->_viewVars->errorMsg;
else {

	$pageNumber = $this->_pageNumber;
	$resultsPerPage = $this->_resultsPerPage;

	echo $this->_message; 
	if (true) {

	$spellcheck = $this->_spellcheck;
	// "Did you mean" section
	if (!is_null($spellcheck)) {
		$suggestions = $spellcheck['suggestions'];
		//echo $suggestions;
		//print_r($suggestions);
		if (!empty($suggestions)) {
			$collation = $suggestions['collation'];
			$suggest_string = htmlentities(stripslashes(substr(strstr($collation, ":"), 1)));
			$atag = "<a href=\"javascript:void(0);\" onclick=\"location.href='/?q=".rawurlencode($suggest_string)."&didyoumean=true";
			$atag = $atag."&old=".rawurlencode($this->_searchQuery)."';\">";
			echo "<span class=breadcrumbs_search>Did you mean to search for ".$atag.$suggest_string."</a></span> ?
			<br><span class=breadcrumbs_search>We are still working on this feature. Please bear with us if the suggestion doesn't sound right.</span><br>";
		} 
	} 

	$english_hadith = $this->_english_hadith;
	$arabic_hadith = $this->_arabic_hadith;
	$eurns = $this->_eurns;
	$aurns = $this->_aurns;
	$highlighted = $this->_highlighted;
	$language = $this->_language;
	$prefix = strcmp($language, "english")==0 ? "" : "arabic";
	if ($this->_numFound == 0) {
		echo "<p align=center>Sorry, there were no results found.";
		$googlequery = "http://www.google.com/#q=".preg_replace("/ /", "+", htmlentities($this->_searchQuery))."+site:sunnah.com";
		echo "<br><a href=\"".$googlequery."\">Click here</a> to use Google's site search feature for your query instead.<br><br></p>";
	}

	if ($this->_numFound > 0) {
		$beginResult = ($pageNumber-1)*$resultsPerPage+1;
		$endResult = min($pageNumber*$resultsPerPage, $this->_numFound);
		echo "<div class=\"AllHadith\">\n";
		echo "<span style=\"color: #75A1A1;\">&nbsp;Showing $beginResult-$endResult of ".$this->_numFound."</span>";
		//echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
		echo "<div align=right style=\"float: right;\">";
		$this->widget('CLinkPager', array(
			'pages' => $this->_pages,
			'prevPageLabel' => '&#x25C0;',
			'nextPageLabel' => '&#x25B6;',
			'header' => '',
		));
		echo "</div>";

		echo "<div style=\"height: 20px;\"></div>";

		if (strcmp($language, "english") == 0) {
			$util = new Util();
			foreach ($this->_pairs as $pair) {
				$eurn = $pair[0]; $aurn = $pair[1];
				$hadith = EnglishHadith::model()->find("englishURN = :eurn", array(':eurn' => $eurn));
				if ($hadith == NULL) continue;
				$book = Book::model()->find("englishBookID = :ebid AND collection = :collection", array(':ebid' => $hadith->bookID, ':collection' => $hadith->collection));
				$ourBookID = $book->ourBookID;

				$collection = $util->getCollection($hadith->collection);
				$hasbooks = $collection->hasbooks;

				echo "<div class=\"boh\" style=\"margin-bottom: 10px;\">\n";
				echo "<!-- URN $eurn -->";
				// Print the path of the hadith
				echo "<div class=\"bc_search\">\n";
				$e_hadith = $english_hadith[array_search($eurn, $eurns)];
				echo "<a class=nounderline href=\"/".$e_hadith['collection']."\">".$this->_collections[$e_hadith['collection']]['englishTitle']."</a> » ";
				echo "<a class=nounderline href=\"/".$e_hadith['collection']."/".$ourBookID."\">".$e_hadith['bookName']."</a>";
				if ($e_hadith['ourHadithNumber'] > 0) {
					if (strcmp($hasbooks, "yes") == 0) {
						$booklink = $ourBookID;
						if ($ourBookID == -1) $booklink = "introduction";
						elseif ($ourBookID == -35) $booklink = "35b";
						$permalink = "/".$e_hadith['collection']."/".$booklink."/".$e_hadith['ourHadithNumber'];
					}
					else $permalink = "/".$e_hadith['collection']."/".$e_hadith['ourHadithNumber'];
				}
				else $permalink = "/urn/$eurn";
				//echo "<a href=\"$permalink\">Hadith permalink</a>";
				echo "</div>";
				echo "<div class=collection_sep style=\"width: 98%;\"></div>";
				$truncation = false;

				if (isset($highlighted[$eurn][$prefix.'hadithText'][0])) 
					$text = $highlighted[$eurn][$prefix.'hadithText'][0];
				else
					$text = "Preview not available. Please click on the link to view the hadith.";
				$text = preg_replace("/<em>/", "<b><i>", $text);
				$text = preg_replace("/<\/em>/", "</b></i>", $text);
				
				//echo "<div class=\"search_english_text\">... ".$text." ...</div><br />";

				$arabicSnippet = "";
				if ($aurn > 0) {
					$arabicText = $arabic_hadith[array_search($aurn, $aurns)]['hadithText'];
					if (strlen($arabicText) <= 2500) $arabicSnippet = $arabicText;
					else {
						$pos = strpos($arabicText, ' ', 2500);
						if ($pos === FALSE) $arabicSnippet = $arabicText;
						else {
							$arabicSnippet = substr($arabicText, 0, $pos)." ...";
							$truncation = true;
						}
					}

					//echo "<div class=\"search_arabic_text arabic_basic\">".$arabicSnippet."</a></div>";
				}
				echo "<div class=\"actualHadithContainer\" style=\"position: relative; border-radius: 0 0 10px 10px; margin-bottom: 0px; padding-bottom: 10px; background-color: rgba(255, 255, 255, 0);\">";
				echo "<a style=\"display: block;\" href=\"$permalink\"><span class=searchlink></span></a>";
				echo $this->renderPartial('/collection/printhadith', array(
                            'arabicEntry' => NULL,
                            'englishText' => $text,
                            'arabicText' => $arabicSnippet,
                            'ourHadithNumber' => NULL, 'counter' => NULL, 'otherlangs' => NULL));

				echo "</div>"; // actual hadith container
				if ($truncation) echo "<div class=searchmore><a href=\"$permalink\">Read more &hellip;</a></div>";
				echo "<div class=clear></div>";
				echo "</div>"; // hadithEnv
				echo "<div class=clear></div>";
				echo "<div class=hline></div>";
			}
    	}
		elseif (strcmp($language, "arabic") == 0) {
			$util = new Util();
			foreach ($this->_pairs as $pair) {	
				$eurn = $pair[0]; $aurn = $pair[1];
				$hadith = ArabicHadith::model()->find("arabicURN = :aurn", array(':aurn' => $aurn));
				if (is_null($hadith)) continue;
				$book = Book::model()->find("arabicBookID = :abid AND collection = :collection", array(':abid' => $hadith->bookID, ':collection' => $hadith->collection));
				$ourBookID = $book->ourBookID;
				$collection = $util->getCollection($hadith->collection);
				$hasbooks = $collection->hasbooks;

				echo "<div class=\"boh\" style=\"margin-bottom: 10px;\">\n";
				
				// Print the path of the hadith
				echo "<div class=\"bc_search\">\n";
				$a_hadith = $arabic_hadith[array_search($aurn, $aurns)];
				$e_hadith = $english_hadith[array_search($aurn, $aurns)];
				echo "<a class=nounderline href=\"/".$a_hadith['collection']."\">".$this->_collections[$a_hadith['collection']]['englishTitle']."</a> » ";
				echo "<a class=nounderline href=\"/".$a_hadith['collection']."/".$ourBookID."\">".$e_hadith['bookName']." - ".$a_hadith['bookName']."</a>";
				if ($a_hadith['ourHadithNumber'] > 0) {
					if (strcmp($hasbooks, "yes") == 0) $permalink = "/".$a_hadith['collection']."/".$ourBookID."/".$a_hadith['ourHadithNumber'];
					else $permalink = "/".$a_hadith['collection']."/".$a_hadith['ourHadithNumber'];
				}
				else $permalink = "/urn/$aurn";
				//echo "<a href=\"$permalink\">Hadith permalink</a></div>";
				echo "</div>";
				echo "<div class=collection_sep style=\"width: 98%;\"></div>";
				$truncation = false;

				if (isset($highlighted[$aurn][$prefix.'hadithText'])) {
					$text = $highlighted[$aurn][$prefix.'hadithText'][0];
					$text = preg_replace("/<em>/", "<b>", $text);
					$text = preg_replace("/<\/em>/", "</b>", $text);
				}
				else
					$text = "<div style='text-align: left; direction: ltr;'>Preview not available. Please click on the link to view the hadith.</div>";
		
				//echo "<div class=\"search_arabic_text arabic_basic\" dir=rtl>... ".$text." ...</a></div>";
				
				$englishSnippet = "";
				if (isset($english_hadith[array_search($eurn, $eurns)]['hadithText'])) {
					$englishText = $english_hadith[array_search($eurn, $eurns)]['hadithText'];
					if (strlen($englishText) <= 2500) $englishSnippet = $englishText;
					else {
						$pos = strpos($englishText, ' ', 2500);
						if ($pos === FALSE) $englishSnippet = $englishText;
						else {
							$englishSnippet = substr($englishText, 0, $pos)." ...";
							$truncation = true;
						}
					}
				}
				//echo "<div class=\"search_english_text\" >".$englishSnippet."</div>";
				
				echo "<div class=\"actualHadithContainer\" style=\"position: relative; border-radius: 0 0 10px 10px; margin-bottom: 0px; padding-bottom: 10px; background-color: rgba(255, 255, 255, 0);\">";
                echo "<a style=\"display: block;\" href=\"$permalink\"><span class=searchlink></span></a>";
                echo $this->renderPartial('/collection/printhadith', array(
                            'arabicEntry' => NULL,
                            'englishText' => $englishSnippet,
                            'arabicText' => $text,
                            'ourHadithNumber' => NULL, 'counter' => NULL, 'otherlangs' => NULL));

                echo "</div>"; // actual hadith container
                if ($truncation) echo "<div class=searchmore><a href=\"$permalink\">Read more &hellip;</a></div>";
                echo "<div class=clear></div>";
                echo "</div>"; // hadithEnv
                echo "<div class=clear></div>";
                echo "<div class=hline></div>";
			}
    	}

		//echo $this->paginationControl($this->paginator, 'Sliding', 'index/pagination.phtml');
		echo "<div align=center>";
		$this->widget('CLinkPager', array('pages' => $this->_pages));
		echo "</div>";
		echo "</div>";

	}
	
}


} // ending no error if
?>


