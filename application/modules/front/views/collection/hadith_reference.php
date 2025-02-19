<?php
			if (!isset($showInBookReference)) { $showInBookReference = $collection->showInBookReference; }
			if (!isset($showEnglishTranslationNumber)) { $showEnglishTranslationNumber = $collection->showEnglishTranslationNumber; }

			$url = null;
			// Disabling experiment Jan 13 to see if the downtick in Google Search is related
			// TODO: Expand to all verified collections at the end of the experiment
			// if ($collection === "riyadussalihin") $url = $util->getPermalinkByURN($values[0], $urn_language);

			echo "<div class=\"clear\"></div>";			
			echo "<div class=bottomItems>\n";
	    if (($englishExists && strlen($englishEntry->grade1) > 0) or ($arabicExists && strlen($arabicEntry->grade1) > 0)) {
    	    echo "<div class=hadith_annotation>";
            echo "<table class=gradetable cellspacing=0 cellpadding=0 border=0>";

            // This should really happen in the controllers/models
            // Figure out how many grades there are and populate a structure
            $english_grades = json_decode($englishEntry->grade1, true);
            if (is_null($english_grades) or !is_array($english_grades)) {
                $english_grades = array();
                if (strlen($englishEntry->grade1) > 0) {
                    $english_grades[0] = array();
                    $english_grades[0]['grade'] = ucfirst(trim($englishEntry->grade1));
                    $english_grades[0]['graded_by'] = $collection->englishgrade1;
                }
            }
            $arabic_grades = json_decode($arabicEntry->grade1, true);
            if (is_null($arabic_grades) or !is_array($arabic_grades)) {
                $arabic_grades = array();
                if (strlen($arabicEntry->grade1) > 0) {
                    $arabic_grades[0] = array();
                    $arabic_grades[0]['grade'] = $arabicEntry->grade1;
                    $arabic_grades[0]['graded_by'] = $collection->arabicgrade1;
                }
            }

            $num_grades = max(count($english_grades), count($arabic_grades));
			$firstGradePrinted = false;
            for ($i = 0; $i < $num_grades; $i++) {
                echo "<tr>";
                if (array_key_exists($i, $english_grades)) {
                    $grade = $english_grades[$i]['grade'];
                    $graded_by = $english_grades[$i]['graded_by'];
                    echo "<td class=english_grade width=\"50px\">";
					if (!$firstGradePrinted) echo "<b>Grade</b>:";
					echo "</td>";
                    echo "<td class=english_grade width=\"36%\">&nbsp;<b>".$grade."</b>";
                    if (strlen(trim($graded_by)) > 0) echo " (".$graded_by.")</td>";
                } else {
                    echo "<td height=100% class=english_grade></td>";
                    echo "<td height=100% class=english_grade></td>";
                }

                if (array_key_exists($i, $arabic_grades)) {
                    $grade = $arabic_grades[$i]['grade'];
                    $graded_by = $arabic_grades[$i]['graded_by'];
    				echo "<td class=\"arabic_grade arabic\">&nbsp;<b> ".$grade."</b>";
	    			if (strlen(trim($graded_by)) > 0) echo "&nbsp;&nbsp; (".$graded_by.") </td>";
		    		echo "<td class=\"arabic_grade arabic\" width=\"50px\">";
					if (!$firstGradePrinted) echo "<b>حكم</b>&nbsp;&nbsp;&nbsp;:";
					echo "</td>";
                } else {
                    echo "<td height=100% width=60% class=arabic_grade></td>";
                    echo "<td height=100% width=60% class=arabic_grade></td>";
                }

                echo "</tr>";
				$firstGradePrinted = true;
            }
            echo "</table>";
	        echo "</div>";
    	}


			echo "<table class=hadith_reference cellspacing=0 cellpadding=0>";

	    	if ($arabicExists) { $permalink = $arabicEntry->permalink; }
	    	elseif ($englishExists) { $permalink = $englishEntry->permalink; }

			if ($book->status == 4) {
				echo "<tr><td><b>Reference</b></td>";
				echo "<td>&nbsp;:&nbsp;";
				$surroundingBeginTag = "";
				$surroundingEndTag = "";
				if ($this->params["_pageType"] !== "hadith" ) {
					$surroundingBeginTag = "<a href=\"$permalink\">";
					$surroundingEndTag = "</a>";
				}
                echo $surroundingBeginTag.$arabicEntry->canonicalReference.$surroundingEndTag;
				echo "</td></tr>";

				if ($collection->hasbooks == "yes" && $showInBookReference) {
					echo "<tr><td>In-book reference</td>";
					echo "<td>&nbsp;:&nbsp;$arabicEntry->inbookReference</td></tr>";
				}

				if ($englishExists
				    and /* $values[5] != $values[3] and */ (int)$englishEntry->hadithNumber != 0
					and strcmp($showEnglishTranslationNumber, "yes") == 0) {
                        echo "<tr><td>$englishEntry->translationReferenceTitle</td>";
                        echo "<td>&nbsp;: $englishEntry->translationReference</td></tr>";
						if (!is_null($englishEntry->postReferenceNote)) {
							echo " <tr><td>&nbsp;&nbsp;$englishEntry->postReferenceNote</td></tr>";
						}
                }
			}
			else {
				// If there is a unified reference number
				if ($englishEntry->hadithNumber == $arabicEntry->hadithNumber &&
					(($collection->hasbooks === "yes" && $englishEntry->bookNumber == $arabicEntry->bookNumber) || $collection->hasbooks !== "yes")) { // Unified reference number
					if ($ourHadithNumber > 0) {
						if ($englishEntry->hadithNumber != $ourHadithNumber) {
							echo "<tr><td>Sunnah.com reference</td>";
							echo "<td>&nbsp;:&nbsp;";
							echo $arabicEntry->sunnahReference;
							echo "</td>";
						}
					}
					echo "<tr><td>Arabic/English book reference</td>";
					echo "<td>&nbsp;:&nbsp;";
					echo $englishEntry->englishReference;
					echo "</td></tr>";
				}
				else { // Different reference numbers
					if ($ourHadithNumber > 0) {
						echo "<tr><td>Sunnah.com reference</td><td>&nbsp;:&nbsp;";
						echo $arabicEntry->sunnahReference;
						echo "</td></tr>";
					}
				
					if ($englishExists) {
						echo "<tr><td>$englishEntry->englishReferenceTitle</td><td>&nbsp;: ";
						echo $englishEntry->englishReference;
						echo "</td></tr>";
					}
				
					if ($arabicExists) {
						echo "<tr><td>";
						echo "Arabic reference</td><td>&nbsp;: ";
						echo $arabicEntry->arabicReference;
						echo "</td></tr>";
					}
				}
			}
			
			echo "</table>"; 
			echo "<div class=\"hadith_permalink\">";
				//echo "<a href=\"javascript:sharethis()\">Share</a>";
				//echo "<a href=\"javascript:permalink('$permalink');\">Permalink</a>";
				//echo "<a href=\"$permalink\">Permalink</a>";
			if (!isset($hideReportError) or !$hideReportError) echo "<span class=reportlink href=\"javascript: void(0);\" onclick=\"reportHadith(".$urn.", '".$divName."')\">Report Error</span> | ";
			if (!$hideShare) {
                echo "<span class=sharelink onclick=\"share(this, '$permalink')\">Share</span> | "; 
			    echo "<span class=copylink title=\"Copy hadith to clipboard\">Copy</span> "; 
			    echo "<span class=copycbcaret title=\"Change copy options\">▼</span>";
            }
			echo "</div></div>";
?>
