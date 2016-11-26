<?php 

function displayBab($chapter, $showChapterNumbers = true) {
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
        if ($showChapterNumbers) echo "<div class=echapno>($babNum)</div>";
        echo "<div class=englishchapter>".$eprefix.$englishBabName."</div>\n";
    }
    if ($showChapterNumbers) echo "<div class=achapno>($arabicBabNumber)</div>\n";
    echo "<div class=\"arabicchapter arabic\">$arabicBabName</div>";
    echo "<div class=clear></div>\n";
    echo "</div>\n";
    if (isset($englishIntro) && strlen($englishIntro) > 0) echo "<div class=\"echapintro\">$englishIntro</div>\n";
    if (isset($arabicIntro) && strlen($arabicIntro) > 0) echo "<div class=\"arabic achapintro\">$arabicIntro</div>\n";
    echo "<div class=clear></div>\n";
    echo "\n<div style=\"height: 10px;\"></div>\n";
}

if (isset($this->_errorMsg)) echo $this->_errorMsg;
else {
	$englishEntries = $this->_entries[0];
	$arabicEntries = $this->_entries[1];
	$pairs = $this->_entries[2];
	$totalCount = count($pairs);
	$chapters = $this->_chapters;
	$showChapters = true;
	if (isset($this->_viewVars->showBookNames)) $showBookNames = $this->_viewVars->showBookNames;
	if (isset($this->_viewVars->showChapterNumbers)) $showChapterNumbers = $this->_viewVars->showChapterNumbers;
	if (isset($this->_viewVars->showChapters)) $showChapters = $this->_viewVars->showChapters;
	
	echo "<div class=bookheading><div align=center style=\"font-size: 30px;\">".$this->_viewVars->pageTitle."</div></div>";
	echo "<div class=bookintro></div>";

    echo "<a name=\"0\"></a>";
	echo "<div class=AllHadith>\n";
					$oldBookID = 0;
					$oldBabID = 0;
					for ($i = 0; $i < $totalCount; $i++) {
						$englishEntry = $englishEntries[$pairs[$i][0]];
						$arabicEntry = $arabicEntries[$pairs[$i][1]];

						$englishExists = true;
						$arabicExists = true;

						$urn = $englishEntry->englishURN;
						$ourHadithNumber = $englishEntry->ourHadithNumber;

						if ($oldBookID != $arabicEntry->bookID) {
							if ($showBookNames) {
					?>
					    <div class="book_info">
					        <div class=book_page_colindextitle>
					            <div class="book_page_arabic_name arabic">
									<?php echo $this->_books[$arabicEntry->arabicURN]->arabicBookName; ?></div>
					            <div class="book_page_number">
									<?php echo $this->_books[$arabicEntry->arabicURN]->ourBookID; ?>
								</div>
					            <div class="book_page_english_name">
					                <?php echo $this->_books[$arabicEntry->arabicURN]->englishBookName; ?>
					            </div>
					            <div class=clear></div>
					        </div>
							<div class=clear></div>
					    </div>

					<?php
							}
							$oldBookID = $arabicEntry->bookID;
							Yii::trace("arabicURN is ".$arabicEntry->arabicURN);
							if ($showChapters) displayBab($chapters[$arabicEntry->arabicURN], $showChapterNumbers);
							$oldBabID = $chapters[$arabicEntry->arabicURN]->arabicBabNumber;
						}
						elseif ($oldBabID != $chapters[$arabicEntry->arabicURN]->arabicBabNumber) {
							if ($showChapters) displayBab($chapters[$arabicEntry->arabicURN], $showChapterNumbers);
							$oldBabID = $chapters[$arabicEntry->arabicURN]->arabicBabNumber;
						}

						echo '<div class="hadith_icon" style="float: left; margin-left: -23px;"></div>';
						echo '<div class="hadith_icon" style="float: right; margin-right: -23px;"></div>';
						echo "<div class=actualHadithContainer id=h".$arabicEntry->arabicURN.">\n";				
						echo $this->renderPartial('/collection/printhadith', array(
							'arabicEntry' => $arabicEntry,
							'englishText' => $englishEntry->hadithText,
							'arabicText' => $arabicEntry->hadithText,
							'ourHadithNumber' => $ourHadithNumber, 'counter' => $i+1, 'otherlangs' => NULL));

						echo $this->renderPartial('/collection/hadith_reference', array(
							'englishEntry' => $englishExists,
							'arabicEntry' => $arabicExists,
							'values' => array($urn, 
											$englishEntry->volumeNumber, 
											$englishEntry->bookNumber,
											NULL,
											$arabicEntry->bookNumber,
											$arabicEntry->hadithNumber,
											$ourHadithNumber, $arabicEntry->collection, intval($arabicEntry->bookID), "yes", true, 4, $this->_collections[$arabicEntry->collection]['englishTitle'], $englishEntry->grade1, $arabicEntry->grade1, true, "h".$arabicEntry->arabicURN)
                            ));	
						echo "<div class=clear></div></div><!-- end actual hadith container -->";
                        echo "<div class=clear></div>";
						echo "<div class=hline style=\"height: 4px;\"></div>";
						}
	echo "</div>";
} // ending the no error if

?>


