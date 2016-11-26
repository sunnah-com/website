<?php 

function displayBab($chapter) {
	if ($chapter->babID == 0.1 && intval($chapter->arabicBabNumber) == 0) return;
	$arabicBabNumber = $chapter->arabicBabNumber;
	$arabicBabName = $chapter->arabicBabName;
	$englishBabNumber = $chapter->englishBabNumber;
	$englishBabName = $chapter->englishBabName;
	$englishIntro = preg_replace("/\n+/", "<br>\n", $chapter->englishIntro);
	$arabicIntro = preg_replace("/\n+/", "<br>\n", $chapter->arabicIntro);

	echo "<div style=\"height: 10px;\"></div>\n";
    echo "<div class=chapter>\n";
    echo "<div class=clear></div><div style=\"height: 5px;\"></div>\n";
	if (!is_null($englishBabName)) {
		if (strcmp(substr($englishBabName, 0, 7), "chapter") != 0) $eprefix = "Chapter: ";
		else $eprefix = "";
		if (strlen($englishBabNumber) > 0 && intval($englishBabNumber) != 0) $babNum = $englishBabNumber;
		else $babNum = $arabicBabNumber;
		if (ctype_upper(substr(trim($englishBabName), 0, 2))) $englishBabName = ucwords(strtolower($englishBabName));
		echo "<div class=echapno>($babNum)</div>";
		echo "<div class=englishchapter>".$eprefix.$englishBabName."</div>\n";
	}
	echo "<div class=achapno>($arabicBabNumber)</div>\n";
	echo "<div class=\"arabicchapter arabic\">$arabicBabName</div>";
	echo "<div class=clear></div>\n";
	echo "</div>\n";

	$acstyle = "";
	if (isset($englishIntro) && strlen($englishIntro) > 0) echo "<div class=\"echapintro\">$englishIntro</div>\n";
	else $acstyle = "style = \"width: 80%; margin-right: 5%;\"";
	if (isset($arabicIntro) && strlen($arabicIntro) > 0) echo "<div class=\"arabic achapintro\" $acstyle >$arabicIntro</div>\n";
	echo "<div class=clear></div>\n";
	echo "\n<div style=\"height: 10px;\"></div>\n";
}

if (isset($this->_errorMsg)) echo $this->_errorMsg;
else {
	$englishEntries = $this->_entries[0];
	$arabicEntries = $this->_entries[1];
	$pairs = $this->_entries[2];
	$totalCount = count($pairs);
	$ourBookID = $this->_ourBookID;
	$collection = $this->_collectionName;
	$collectionType = $this->_collection->type;
	$collectionHasBooks = $this->_collection->hasbooks;
	$collectionHasVolumes = $this->_collection->hasvolumes;
	$collectionHasChapters = $this->_collection->haschapters;
	$status = $this->_book->status;
	$chapters = $this->_chapters;
	if ($chapters) $babIDs = array_keys($chapters);
	if ($this->_ajaxCrawler and count($this->_otherlangs) > 0) {
		$haveotherlangs = true;
		$otherlangs = $this->_otherlangs;
	}
	
?>

	<div class="book_info">
    	<div class=book_page_colindextitle>
    		<div class="book_page_arabic_name arabic"><?php echo $this->_book->arabicBookName; ?></div>
    		<div class="book_page_number">
			<?php if (strcmp($collectionHasBooks, "yes") == 0) {
					if (intval($ourBookID) > 0) echo "$ourBookID";
				  	elseif ($ourBookID == -35) echo "35b&nbsp;&nbsp; "; 
				  }
			?>
			</div>
    		<div class="book_page_english_name">
				<?php echo $this->_book->englishBookName; ?>
			</div>
    		<div class=clear></div>
		</div>
		<!-- <div style="width: 20%; float: left; text-align: center; font-size: 20px; padding-top: 16px;"><b><?php echo $totalCount; ?></b> hadith</div> -->

	<?php
		if (strcmp($collectionHasBooks, "yes") == 0 and !is_null($this->_book->englishBookIntro) and strcmp($this->_pageType, "book") == 0) {
					if (strcmp($collection, "muslim") == 0 and $ourBookID == -1) include("muslimintro.txt");
					echo "<div class=bookintro>";
					echo "<div class=ebookintro>".$this->_book->englishBookIntro."</div>";
					echo "<div class=\"arabic abookintro\">".$this->_book->arabicBookIntro."</div>";
					echo "</div>\n";
		}
	?>

	<div class=clear></div>
	</div>

    <a name="0"></a>
	<div class=AllHadith>
	<?php
					$oldChapNo = 0;
					for ($i = 0; $i < $totalCount; $i++) {
						$englishEntry = $englishEntries[$pairs[$i][0]];
						$arabicEntry = $arabicEntries[$pairs[$i][1]];

						$englishExists = true;
						$arabicExists = true;

						if ($englishEntry == NULL) {
							$englishEntry = new EnglishHadith;
							$urn = $arabicEntry->arabicURN;
							$englishExists = false;
							$ourHadithNumber = $arabicEntry->ourHadithNumber;
						}
						else {
							$urn = $englishEntry->englishURN;
							$ourHadithNumber = $englishEntry->ourHadithNumber;
						}

						if ($arabicEntry == NULL) {
							$arabicEntry = new ArabicHadith;
							$arabicExists = false;
						}
						else {
							/* Arabic entry is not NULL, so we check for status == 4 and get chapter info */
							if ($status == 4 and strcmp($collectionHasChapters, "yes") == 0) {
								$babID = $arabicEntry->babNumber;
								//$arabicBabNumber = $chapters[$babID]->arabicBabNumber;
								//$arabicBabName = $chapters[$babID]->arabicBabName;
								//$englishBabNumber = $chapters[$babID]->englishBabNumber;
								//$englishBabName = $chapters[$babID]->englishBabName;
								//$englishIntro = $chapters[$babID]->englishIntro;
								//$arabicIntro = $chapters[$babID]->arabicIntro;
								if ($i > 0) $oldebooknum = $ebooknum;
								$ebooknum = $englishEntry->bookNumber;
							}
						}

						if (isset($ebooknum) and $i > 0 and $ebooknum == $oldebooknum+1) {
							echo "</div><div class=bookheading><div class=englishbookheading>".$englishEntry->bookName."</div><div class=arabicbookheading>".$arabicEntry->bookName."</div></div>";
							echo "<div class=\"hline\" style=\"width: 71%; margin-left: 6%; height: 4px;\"></div><div class=AllHadith>";
						}

						if (isset($babID) and $babID != $oldChapNo) {
							if (strcmp($this->_pageType, "book") == 0) {
								// Check if there are any zero-hadith chapters between this one and the previous one
								if ($oldChapNo != 0) $oldChapIdx = array_search($oldChapNo, $babIDs);
								else $oldChapIdx = -1;
								$newChapIdx = array_search($babID, $babIDs);
								for ($j = 0; $j < $newChapIdx - $oldChapIdx - 1; $j++)
									displayBab($chapters[$babIDs[$oldChapIdx+$j+1]]);
							}

							// Now display the current chapter
							displayBab($chapters[$babID]);
							$oldChapNo = $babID;
						}

						if (isset($haveotherlangs) and $arabicExists) {
							$arabicURN = $arabicEntry->arabicURN;
							$otherlangshadith = array();
							foreach ($otherlangs as $langname => $ahadith) {
								foreach ($ahadith as $hadith) 
									if ($hadith->matchingArabicURN == $arabicURN) {
										$otherlangshadith[$langname] = $hadith->hadithText;
										break;
									}
							}
						}
						else $otherlangshadith = NULL;
						if ($englishExists) echo "<div class=hadith_icon style=\"float: left; margin-left: -23px;\"></div>";
			            if ($arabicExists) echo "<div class=hadith_icon style=\"float: right; margin-right: -23px;\"></div>";
						echo "<div class=actualHadithContainer id=h".$arabicEntry->arabicURN.">\n";
						echo $this->renderPartial('/collection/printhadith', array(
							'arabicEntry' => $arabicEntry,
							'englishText' => $englishEntry->hadithText,
							'arabicText' => $arabicEntry->hadithText,
							'ourHadithNumber' => $ourHadithNumber, 'counter' => $i+1, 'otherlangs' => $otherlangshadith));

						echo $this->renderPartial('/collection/hadith_reference', array(
							'englishEntry' => $englishExists,
							'arabicEntry' => $arabicExists,
							'values' => array($urn, 
											$englishEntry->volumeNumber, 
											$englishEntry->bookNumber,
											$englishEntry->hadithNumber,
											$arabicEntry->bookNumber,
											$arabicEntry->hadithNumber,
											$ourHadithNumber, 
											$collection, 
											$ourBookID, 
											$collectionHasBooks, 
											$collectionHasVolumes, 
											$status, 
											$this->_collection->englishTitle, 
											$englishEntry->grade1, 
											$arabicEntry->grade1,
											false, // hide report error flag
											"h".$arabicEntry->arabicURN)
                            ));	
						echo "<div class=clear></div></div><!-- end actual hadith container -->";
						echo "<div class=clear></div>";

						/* Check if the chapter ends here  */
						unset($newBabID);
						if ($i+1 < $totalCount) {
	                        $englishEntry = $englishEntries[$pairs[$i+1][0]];
    	                    $arabicEntry = $arabicEntries[$pairs[$i+1][1]];

	                        $englishExists = true;
    	                    $arabicExists = true;

	                        if ($englishEntry == NULL) $englishExists = false;
        	                if ($arabicEntry == NULL) $arabicExists = false;
                        	elseif ($status == 4) $newBabID = $arabicEntry->babNumber;

						}
 
						if (isset($newBabID) and $newBabID != $oldChapNo) { // Chapter ended and new chapter follows
							if (isset($chapters[$oldChapNo]->arabicEnding) and strcmp($this->_pageType, "book") == 0) {
								echo "<div class=hline style=\"height: 2px;\"></div>"; // hadith boundary
								echo "<div class=\"echapintro\">".$chapters[$oldChapNo]->englishEnding."</div>";
								echo "<div class=\"arabic_basic achapintro\">".$chapters[$oldChapNo]->arabicEnding."</div>";
							}
							echo "<div class=hline style=\"height: 4px;\"></div>";
						}
						elseif (isset($newBabID) && $status == 4) { // Chapter did NOT end
							echo "<div class=hline style=\"height: 2px;\"></div>";
						}
						else { // no more hadith in the book
							if (isset($chapters[$oldChapNo]->arabicEnding) and strcmp($this->_pageType, "book") == 0) {
								echo "<div class=hline style=\"height: 2px;\"></div>"; // hadith boundary
								echo "<div class=\"echapintro\">".$chapters[$oldChapNo]->englishEnding."</div>";
								echo "<div class=\"arabic_basic achapintro\">".$chapters[$oldChapNo]->arabicEnding."</div>";
							}
							echo "<div class=hline style=\"height: 4px;\"></div>"; //chapter boundary
						}
					}
					// Below code for zero-hadith chapters at the end of the book
					if (isset($babID) and strcmp($this->_pageType, "book") == 0 and $oldChapNo != 0) {
						$oldChapIdx = array_search($oldChapNo, $babIDs);
						if ($oldChapIdx < count($babIDs)-1) {
							for ($j = 0; $j < count($babIDs)-$oldChapIdx-1; $j++) {
								displayBab($chapters[$babIDs[$oldChapIdx+$j+1]]);
								echo "<div class=hline style=\"height: 4px;\"></div>";
							}
						}
					}
					echo "<!-- <div align=right><i>Content on this page was last updated on ".$this->_viewVars->lastUpdated."</i></div> -->";
					echo "</div>";

} // ending the no error if

?>


