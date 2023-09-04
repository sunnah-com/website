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
	
			if ( isset($book->status) and $book->status == 4 ) {
				echo "<div class=\"hadith_reference_sticky\">";
				if (!is_null($book->reference_template)) {
                    	$reference_string = $book->reference_template;
                    	$reference_string = str_replace("{hadithNumber}", $hadithNumber, $reference_string);
                    	echo $reference_string;
				}
				else {
					echo "$collection->englishTitle $hadithNumber";
				}
				echo "</div>";
            }
            echo "<div class=\"hadithTextContainers\" id=htc".$arabicURN.">";
			if ($book->status != 6) {
				echo "<div class=\"englishcontainer\" id=t".$arabicURN.">";
				echo "<div class=\"english_hadith_full\">";

                $printed = false;
				$colon_match = preg_match("/[^0-9]:[^0-9]/", $englishText, $match, PREG_OFFSET_CAPTURE);
				if ($colon_match === 1) {
					$narrated_part = substr($englishText, 0, $match[0][1] + 1);
                    $text_part = trim(substr($englishText, $match[0][1] + 2));
                    if (strcmp(substr($narrated_part, -8), "eference") != 0) {
				    	echo "<div class=hadith_narrated>".$narrated_part.":</div>";
                        echo "<div class=text_details>".$text_part."</div>\n";
                        $printed = true;
                    }
				}
                
                if (!$printed) echo "<div class=text_details>".$englishText."</div>\n";
				
				echo "<div class=clear></div></div></div>";
			}

            $arabicSanad1 = "";
            $arabicSanad2 = "";
            if (substr_count($arabicText, "\"") == 2 && ($collection->name !== "hisn")) {
                $arabicSanad1 = strstr($arabicText, "\"", true);
                $arabicText = substr(strstr($arabicText, "\"", false), 1);
                $arabicSanad2 = substr(strstr($arabicText, "\"", false), 1);
                $arabicText = "\"".strstr($arabicText, "\"", true)."\"";
            }

            echo "<div class=\"arabic_hadith_full arabic\">";

            if (!is_null($arabicEntry) && $arabicEntry->shortcode_parsed) {
				echo $arabicEntry->hadithText;
			}
            else {
				echo "<span class=\"arabic_sanad arabic\">" . $arabicSanad1 . "</span>\n";
				echo "<span class=\"arabic_text_details arabic\">" . $arabicText . "</span>";
				echo "<span class=\"arabic_sanad arabic\">" . $arabicSanad2 . "</span>";
			}

			if (isset($annotation)) echo "<p><span class=\"arabic arabic_annotation\">$annotation</span>";
            echo "</div>\n";
            echo "</div>\n"; // hadithTextContainers
			if (!is_null($otherlangs)) {
				foreach ($otherlangs as $langname => $hadith) echo "<div class=$langname>".$hadith."</div>\n<br>\n";
			}
			
	echo "<!-- End hadith -->\n\n";
?>
