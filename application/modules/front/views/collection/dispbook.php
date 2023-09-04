<?php 

use app\modules\front\models\EnglishHadith;
use app\modules\front\models\ArabicHadith;

function displayBab($chapter, $collection, $ourBookID, $showIntro = true) {
	if (in_array($collection->name, array("bukhari", "muslim")) && $chapter->babID == 0.1 && intval($chapter->arabicBabNumber) == 0) return;
	$arabicBabNumber = $chapter->arabicBabNumber;
	$arabicBabName = $chapter->arabicBabName;
	$englishBabNumber = $chapter->englishBabNumber;
	$englishBabName = $chapter->englishBabName;
	$englishIntro = preg_replace("/\n+/", "<br>\n", $chapter->englishIntro);
	$arabicIntro = preg_replace("/\n+/", "<br>\n", $chapter->arabicIntro);

	echo "<a name=C$chapter->babID></a>\n";
	if ((strcmp($collection->name, "bukhari") == 0) and ($ourBookID == 65) and (strcmp(substr($chapter->babID, -2), "00") == 0)) $chapterClassName = "surah";
    elseif ((strcmp($collection->name, "virtues") == 0) and ($ourBookID == 1) and (strcmp(substr($chapter->babID, -2), "00") == 0)) $chapterClassName = "surah";
	else $chapterClassName = "chapter";
    echo "<div class=$chapterClassName>\n";
	if (!is_null($englishBabName)) {
		if (strcmp(strtolower(substr($englishBabName, 0, 7)), "chapter") != 0 and (strlen($englishBabNumber) > 0)) $eprefix = "Chapter: ";
		else $eprefix = "";
		if (strlen($englishBabNumber) > 0 && intval($englishBabNumber) != 0) $babNum = $englishBabNumber;
		else $babNum = $arabicBabNumber;
		if (ctype_upper(substr(trim($englishBabName), 0, 2))) $englishBabName = ucwords(strtolower($englishBabName));
		
		/* Special handling for Sahih al-Bukhari Kitab at-Tafsir */
		if ((strcmp($collection->name, "bukhari") == 0) and $ourBookID == 65) {
			$eprefix = "";
		}

		echo "<div class=echapno>";
		if (strlen(trim($babNum)) > 0) echo "($babNum)"; 
		echo "</div>";
		echo "<div class=englishchapter>".$eprefix.$englishBabName."</div>\n";
	}
	echo "<div class=achapno>"; if (strlen(trim($arabicBabNumber)) > 0) echo "($arabicBabNumber)"; echo "</div>\n";
	echo "<div class=\"arabicchapter arabic\">$arabicBabName</div>";
	echo "<div class=clear></div>\n";
	echo "</div>\n";

    if ($showIntro) {
    	$acOnlyClass = "";
        $ecOnlyClass = "";

	    if (!(isset($arabicIntro) && strlen($arabicIntro) > 0)) $ecOnlyClass = " econly";
	    if (isset($englishIntro) && strlen($englishIntro) > 0) echo "<div class=\"echapintro$ecOnlyClass\">$englishIntro</div>\n";
	    else $acOnlyClass = " aconly";
	    if (isset($arabicIntro) && strlen($arabicIntro) > 0) echo "<div class=\"arabic achapintro$acOnlyClass\">$arabicIntro</div>\n";
	    echo "<div class=clear></div>\n";
    }
}

if (isset($errorMsg)) echo $errorMsg;
else {
	$totalCount = is_null($pairs) ? 0 : count($pairs);
	$collectionType = $collection->type;
	$collectionHasBooks = $collection->hasbooks;
	$collectionHasVolumes = $collection->hasvolumes;
	$collectionHasChapters = $collection->haschapters;
	$status = $book->status;
	if (isset($chapters)) $babIDs = array_keys($chapters);
	if (isset($ajaxCrawler) and isset($otherlangs) and count($otherlangs) > 0) {
		$haveotherlangs = true;
    }

    $showChapterIntro = true;
    if ($this->params['_pageType'] === "hadith") $showChapterIntro = false;

	$book_name_center_style = "";
	if ($collectionHasBooks === "no" 
	    || ($collection->name === "forty" && $book->ourBookID === 1)
		|| ($collection->name === "mishkat" && $book->ourBookID === -1)
		) {
		$book_name_center_style = " centertext";
    }

    $collapse_book_intro = "";
    if ($collection->name === "forty" && $book->ourBookID == 1) { $collapse_book_intro = " collapsible collapsed book_intro_initial_height"; }
?>

    <div class="book_info">
    	<div class="book_page_colindextitle">
    		<div class="book_page_arabic_name arabic<?php echo $book_name_center_style; ?>"><?php echo $book->arabicBookName; ?></div>
			<?php if (strcmp($collectionHasBooks, "yes") == 0) {
			        $book_number_to_display = (string) $ourBookID;
                    if (!is_null($book->ourBookNum)) { $book_number_to_display = $book->ourBookNum; }
                    if (strlen($book_number_to_display) > 0) {
        				echo "<div class=\"book_page_number\">";
	    				echo $book_number_to_display."&nbsp;&nbsp;";
		    		  	echo "</div>";
                    }
				  }
			?>
    		<div class="book_page_english_name<?php echo $book_name_center_style; ?>">
				<?php echo $book->englishBookName; ?>
			</div>
    		<div class=clear></div>
		</div>
    	<div class=clear></div>
		<!-- <div style="width: 20%; float: left; text-align: center; font-size: 20px; padding-top: 16px;"><b><?php echo $totalCount; ?></b> hadith</div> -->

	<?php
		if ((!is_null($book->arabicBookIntro) || !is_null($book->englishBookIntro)) and strcmp($this->params['_pageType'], "book") == 0) {
					if (strcmp($collection->name, "muslim") == 0 and $ourBookID == -1) include("muslimintro.txt");
					if (strcmp($collection->name, "virtues") == 0 and $ourBookID == 1) include("virtuesintro.txt");
					echo "<div class=\"bookintro".$collapse_book_intro."\">";
					echo "<div class=ebookintro>".$book->englishBookIntro."</div>";
					echo "<div class=\"arabic abookintro\">".$book->arabicBookIntro."</div>";
					echo "<div class=clear></div>";
                    if ($collection->name === "forty" && $book->ourBookID == 1) {
                        echo "<a class=\"button_expand\" onclick=\"jQuery(this).closest('.collapsible').toggleClass('collapsed')\"></a>\n";
                    }
                    echo "</div>\n";
		}
	?>

	<div class=clear></div>
	</div>

    <?php if ((strcmp($collection->name, "hisn") == 0) 
			  and (strcmp($this->params['_pageType'], "book") == 0)
			  and $ourBookID == 1) { ?>
    <div class=chapter_index_container><div class="chapter_index titles collapsible collapsed hisn_chapters_initial_height">
    <?php
        $chapterCount = count($babIDs);
        foreach ($chapters as $chapter) {
            echo "<div class=\"chapter_link title\" id=cl$chapter->babID>\n";
            echo "<a href=\"#C$chapter->babID\">\n";
            echo "<div class=\"chapter_number title_number\">$chapter->englishBabNumber</div>\n";
            echo "<div class=\"english_chapter_name english\">$chapter->englishBabName</div>\n";
            echo "<div class=\"arabic_chapter_name arabic\">$chapter->arabicBabName</div>\n";
            echo "</a>";
            echo "<div class=clear></div>";
            echo "</div> <!-- end chapter_link div-->\n";
        }
    ?>
	<a class="button_expand" onclick="jQuery(this).closest('.collapsible').toggleClass('collapsed')"></a>
    </div></div>
    <div class=clear></div>
    <?php } ?>

	<?php
		$allHadithClass = "AllHadith";
		$allHadithClass .= ($totalCount === 1) ? " single_hadith" : "";
		$allHadithClass .= ($status === 6) ? " col1" : "";
	?>
    <a name="0"></a>
	<div class="<?php echo $allHadithClass ?>">
	<?php

                    // Special case for the rare 0-hadith book with chapters 
					// (only Hisn al-Muslim as of now)
                    if ($totalCount == 0 and $status == 4 and strcmp($collectionHasChapters, "yes") == 0) {
                        foreach ($chapters as $chapter)
                            displayBab($chapter, $collection, $ourBookID, $showChapterIntro);
                    }


					$oldChapNo = 0;
					for ($i = 0; $i < $totalCount; $i++) {
						$englishEntry = $englishEntries[$pairs[$i][0]];
						$arabicEntry = $arabicEntries[$pairs[$i][1]];

						$englishExists = true;
						$arabicExists = true;

						if ($englishEntry == NULL) {
							$englishEntry = new EnglishHadith();
							$urn = $arabicEntry->arabicURN;
							$urn_language = "arabic";
							$englishExists = false;
							$ourHadithNumber = $arabicEntry->ourHadithNumber;
						}
						else {
							$urn = $englishEntry->englishURN;
							$urn_language = "english";
							$ourHadithNumber = $englishEntry->ourHadithNumber;
						}

						if ($arabicEntry == NULL) {
							$arabicEntry = new ArabicHadith();
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
							//echo "</div><div class=bookheading><div class=englishbookheading>".$englishEntry->bookName."</div><div class=arabicbookheading>".$arabicEntry->bookName."</div></div>";
							//echo "<div class=\"hline\" style=\"width: 71%; margin-left: 6%; height: 4px;\"></div><div class=AllHadith>";
							// Skip the above lines for now. Unsure whether we should display the change in book on the translation side.
						}

						if (isset($babID) and $babID != $oldChapNo) {
							if (strcmp($this->params['_pageType'], "book") == 0) {
								// Check if there are any zero-hadith chapters between this one and the previous one
								if ($oldChapNo != 0) $oldChapIdx = array_search($oldChapNo, $babIDs);
								else $oldChapIdx = -1;
								$newChapIdx = array_search($babID, $babIDs);
								for ($j = 0; $j < $newChapIdx - $oldChapIdx - 1; $j++)
									displayBab($chapters[$babIDs[$oldChapIdx+$j+1]], $collection, $ourBookID, $showChapterIntro);
							}

							// Now display the current chapter
							displayBab($chapters[$babID], $collection, $ourBookID, $showChapterIntro);
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
						echo "<div class=\"actualHadithContainer hadith_container_{$collection->name}\" id=h".$arabicEntry->arabicURN.">\n";
						echo $this->render('/collection/printhadith', array(
							'arabicEntry' => $arabicEntry,
							'englishText' => $englishEntry->hadithText,
							'arabicText' => $arabicEntry->hadithText,
							'ourHadithNumber' => $ourHadithNumber, 'counter' => $i+1, 'otherlangs' => $otherlangshadith,
							'hadithNumber' => $arabicEntry->hadithNumber,
							'book'	=> $book,
							'collection'	=> $collection,
							));

						echo $this->render('/collection/hadith_reference', array(
							'englishExists' => $englishExists,
                            'arabicExists' => $arabicExists,
                            'englishEntry' => $englishEntry,
                            'arabicEntry' => $arabicEntry,
                            'collection' => $collection,
							'book' => $book,
							'urn' => $urn,
							'ourHadithNumber' => $ourHadithNumber,
							'ourBookID' => $ourBookID,
							'hideReportError' => false,
							'divName' => "h".$arabicEntry->arabicURN,
							'hideShare' => false,
							'urn_language' => $urn_language,
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
							if (isset($chapters[$oldChapNo]->arabicEnding) and strcmp($this->params['_pageType'], "book") == 0) {
								echo "<div class=\"echapintro\">".$chapters[$oldChapNo]->englishEnding."</div>";
                                echo "<div class=\"arabic achapintro\">".$chapters[$oldChapNo]->arabicEnding."</div>";
                                echo "<div class=\"clear\"></div>";
							}
						}
						elseif (isset($newBabID) && $status == 4) { // Chapter did NOT end
						}
						else { // no more hadith in the book OR next chapter has no hadith
							if (isset($chapters[$oldChapNo]->arabicEnding) and strcmp($this->params['_pageType'], "book") == 0) {
								echo "<div class=\"echapintro\">".$chapters[$oldChapNo]->englishEnding."</div>";
								echo "<div class=\"arabic achapintro\">".$chapters[$oldChapNo]->arabicEnding."</div>";
                                echo "<div class=\"clear\"></div>";
							}
						}
					}
					// Below code for zero-hadith chapters at the end of the book
					if (isset($babID) and strcmp($this->params['_pageType'], "book") == 0 and $oldChapNo != 0) {
						$oldChapIdx = array_search($oldChapNo, $babIDs);
						if ($oldChapIdx < count($babIDs)-1) {
							for ($j = 0; $j < count($babIDs)-$oldChapIdx-1; $j++) {
								displayBab($chapters[$babIDs[$oldChapIdx+$j+1]], $collection, $ourBookID, $showChapterIntro);
							}
						}
					}

					/**
					 * Add Hadith Navigation on Single Hadith page
					 * */
					if ( $totalCount === 1 && ( isset($nextPermalink) || isset($previousPermalink) )) {
						echo $this->render('/collection/hadith_navigation', array(
								'previousPermalink' => isset($previousPermalink) ? $previousPermalink : null,
								'previousHadithNumber' => isset($previousPermalink) ? $previousHadithNumber : null,
								'nextPermalink' => isset($nextPermalink) ? $nextPermalink : null,
								'nextHadithNumber' => isset($nextPermalink) ? $nextHadithNumber : null,
								'collection' => $collection,
							 ));
					}

					echo "<!-- <div align=right><i>Content on this page was last updated on ".$this->params['lastUpdated']."</i></div> -->";
					echo "</div>";

	// Send a post request to add a log entry if the count of shown hadith doesn't match the expected count

	if (($book->status == 4) and (strcmp($this->params['_pageType'], "book") == 0)) {
	
	?>	
	<script>
		(function () {

			var hCount = $(".chapter").length;
			var hExpectedCount = <?php echo count($babIDs) ?>
			
			if ( hCount != hExpectedCount ) {
				var message = "\n" + location.pathname.substring(1) + "\tshown: " + hCount + "\texpected: " + hExpectedCount;

				$.ajax({
					type : "POST",
					url : "/ajax/log/hadithcount",
					data: {msg: message, _csrf_frontend:'<?=\Yii::$app->request->csrfToken?>'},
				});
			}
		})();
	</script>

	<?php
	}
} // ending the no error if

?>


