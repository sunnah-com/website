<?php

	if (isset($ourHadithNumber)) {
		if ($ourHadithNumber > 0) $linknum = $ourHadithNumber;
		else $linknum = $counter;
	}
	else $linknum = 1;

	if (isset($arabicEntry->annotations)) $annotation = $arabicEntry->annotations;
	if (!is_null($arabicEntry)) {
		$arabicURN = $arabicEntry->arabicURN;
	}
	else {
		$arabicURN = "";
	}


	echo "<!-- Begin hadith -->\n\n";
	echo "<a name=$linknum></a>\n";
	
	echo "<div class=\"hadith_reference_sticky\">";
	if ( isset($book->status) and $book->status == 4 ) {
		if (!is_null($book->reference_template)) {
				$reference_string = $book->reference_template;
				$reference_string = str_replace("{hadithNumber}", $hadithNumber, $reference_string);
				echo $reference_string;
		}
		else {
			echo "$collection->englishTitle $hadithNumber";
		}
	}
	else
		echo "$collection->englishTitle $hadithNumber";
	echo "&nbsp;</div>";

	// Grab Enlish text line by line.
	preg_match('/<span class="transliteration">(.*?)<\/span>/s', $englishText, $match);
	$transliteration = $match[1];
	$linesOfTransliteration = explode("\n", $transliteration);
	preg_match('/<span class="translation">(.*?)<\/span>/s', $englishText, $match);
	$translation = $match[1];
	$linesOfTranslation = explode("\n", $translation);
	$linesOfArabic = explode("\n", $arabicText);

	$numLinesOfTransliteration = count($linesOfTransliteration);
	$numLinesOfTranslation = count($linesOfTranslation);
	$numLinesOfArabic = count($linesOfArabic);
	if ($numLinesOfTransliteration > 1 and $numLinesOfTransliteration == $numLinesOfTranslation and $numLinesOfTransliteration == $numLinesOfArabic) {
		preg_match('/<span class="hisn_english_reference">(.*?)<\/span>/s', $englishText, $match);
		$hisnReference = $match[1];

		echo "<div class=hadithLines>";
		for ($i = 0; $i <= count($linesOfTransliteration); $i++) {
			echo "<div class=hadithLine>";
			echo "<span class=translationLine>".$linesOfTranslation[$i]."</span>";
			echo "<span class=transliterationLine>".$linesOfTransliteration[$i]."</span>";
			echo "<span class=\"arabicLine arabic\">".$linesOfArabic[$i]."</span></div>";
		}					
		echo "</div>";
	}
	else {
		echo "<div class=\"englishcontainer\" id=t".$arabicURN.">";
		echo "<div class=\"english_hadith_full\">";
		echo "<div class=text_details>".$englishText."</div>\n";
		echo "<div class=clear></div></div></div>";
		echo "<div class=\"arabiccontainer\">";
		echo "<div class=\"arabic_hadith_full arabic\">";
		echo "<span class=\"arabic_text_details arabic\">".$arabicText."</span>";
		if (isset($annotation)) echo "<p><span class=\"arabic arabic_annotation\">$annotation</span>";
		echo "</div></div>\n";
		if (!is_null($otherlangs)) {
			foreach ($otherlangs as $langname => $hadith) echo "<div class=$langname>".$hadith."</div>\n<br>\n";
		}
	}								
			
	echo "<!-- End hadith -->\n\n";
?>
