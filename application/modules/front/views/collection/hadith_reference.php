<?php
			use app\modules\front\models\Util;
			$util = new Util();

			$collection = $values[7];
			$ourHadithNumber = $values[6];
			$ourBookID = $values[8];
			$collectionHasBooks = $values[9]; 
			$collectionHasVolumes = $values[10];
			$bookstatus = $values[11];
			$collectionEnglishTitle = $values[12];
			$permalink = "/urn/".$values[0];
			$englishGrade1 = $values[13]; $arabicGrade1 = $values[14];
			$hideReportError = $values[15];
			$divname = $values[16];
			$hideShare = $values[17] ?? false;
			$urn_language = $values[18];
			// TODO: Expand to all verified collections at the end of the experiment
			$url = ($collection === "riyadussalihin") ? $util->getPermalinkByURN($values[0], $urn_language) : null;

			echo "<div class=bottomItems>\n";
	    if (strlen($englishGrade1) > 0 or strlen($arabicGrade1) > 0) {
    	    echo "<div class=hadith_annotation>";
            echo "<table class=gradetable cellspacing=0 cellpadding=0 border=0>";

            // This should really happen in the controllers/models
            // Figure out how many grades there are and populate a structure
            $english_grades = json_decode($englishGrade1, true);
            if (is_null($english_grades) or !is_array($english_grades)) {
                $english_grades = array();
                if (strlen($englishGrade1) > 0) {
                    $english_grades[0] = array();
                    $english_grades[0]['grade'] = ucfirst(trim($englishGrade1));
                    $english_grades[0]['graded_by'] = $_collection['englishgrade1'];
                }
            }
            $arabic_grades = json_decode($arabicGrade1, true);
            if (is_null($arabic_grades) or !is_array($arabic_grades)) {
                $arabic_grades = array();
                if (strlen($arabicGrade1) > 0) {
                    $arabic_grades[0] = array();
                    $arabic_grades[0]['grade'] = $arabicGrade1;
                    $arabic_grades[0]['graded_by'] = $_collection['arabicgrade1'];
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
                    echo " (".$graded_by.")</td>";
                } else {
                    echo "<td height=100% class=english_grade></td>";
                    echo "<td height=100% class=english_grade></td>";
                }

                if (array_key_exists($i, $arabic_grades)) {
                    $grade = $arabic_grades[$i]['grade'];
                    $graded_by = $arabic_grades[$i]['graded_by'];
    				echo "<td class=\"arabic_grade arabic\">&nbsp;<b> ".$grade."</b>";
	    			echo "&nbsp;&nbsp; (".$graded_by.") </td>";
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

			if ($bookstatus == 4) {
				echo "<tr><td><b>Reference</b></td>";
				echo "<td>&nbsp;:&nbsp;";
				if ( $url !== null && $this->params["_pageType"] !== "hadith" )
					echo "<a href=\"$url\">$collectionEnglishTitle ".$values[5]."</a>";
				else
					echo "$collectionEnglishTitle ".$values[5]."";
				echo "</b></td></tr>";

				if (strcmp($collectionHasBooks, "yes") == 0) {
					echo "<tr><td>In-book reference</td>";
					echo "<td>&nbsp;:&nbsp;";
					if ($ourBookID > 0) echo "Book $ourBookID, ";
					elseif ($ourBookID == -35) echo "Book 35b, ";
					elseif ($ourBookID == -8) echo "Book 8b, ";
					else echo "Introduction, ";
					if (strcmp($collection, "muslim") == 0 and ($ourBookID == -1)) echo "Narration ";
					else echo "Hadith ";
					echo $ourHadithNumber;
					echo "</td></tr>";
				}

				if ($englishEntry 
				    and /* $values[5] != $values[3] and */ intval($values[3]) != 0
					and strcmp($_collection['showEnglishTranslationNumber'], "yes") == 0) {
                        echo "<tr><td>";
						if (strcmp($collection, "bukhari")==0 or strcmp($collection, "muslim")==0 or strcmp($collection, "malik")==0) echo "USC-MSA web (English) reference</td><td>&nbsp;: ";
                       	else echo "English translation</td><td>&nbsp;:&nbsp;";
	                    if (strcmp($collectionHasVolumes, "yes") == 0)
    	                	echo "Vol. ".$values[1].", ";
        	            if (strcmp($collectionHasBooks, "yes") == 0) echo "Book ".$values[2].", ";
            	        echo "Hadith ".$values[3];
                        echo "</td></tr>";
						if (strcmp($collection, "bukhari")==0 or strcmp($collection, "muslim")==0 or strcmp($collection, "malik")==0) echo " <tr><td>&nbsp;&nbsp;<i>(deprecated numbering scheme)</i>";
                        echo "</td></tr>";
                }

				if (strcmp($collectionHasBooks, "yes") == 0) {
					if ($ourBookID > 0) $permalink = "/$collection/$ourBookID/$ourHadithNumber";
					elseif ($ourBookID < -1) $permalink = "/$collection/".abs($ourBookID)."b/$ourHadithNumber";
					elseif ($ourBookID == -1) $permalink = "/$collection/introduction/$ourHadithNumber";
				}
				else $permalink = "/$collection/$ourHadithNumber"; // This collection has no books.

				if ( $url !== null ) $permalink = $url;
			}
			else {

				if ($values[3] == $values[5] && ((strcmp($collectionHasBooks, "yes") == 0 && $values[4] == $values[2]) || strcmp($collectionHasBooks, "yes") != 0)) { // Unified reference number
					if ($ourHadithNumber > 0) {
						if ($values[3] != $ourHadithNumber) {
							echo "<tr><td>Sunnah.com reference</td>";
							echo "<td>&nbsp;:&nbsp;";
							if (strcmp($collectionHasBooks, "yes") == 0) echo "Book ".$values[4].", ";
							echo "Hadith ".$ourHadithNumber;
							echo "</td>";
						}
						if (strcmp($collectionHasBooks, "yes") == 0) {
							$permalink = "/$collection/$ourBookID/$ourHadithNumber";
							if ($ourBookID == -1) $permalink = "/$collection/introduction/$ourHadithNumber";
						}
						else $permalink = "/$collection/$ourHadithNumber"; // This collection has no books.
					}
					echo "<tr><td>Arabic/English book reference</td>";
					echo "<td>&nbsp;:&nbsp;";
					if (strcmp($collectionHasVolumes, "yes") == 0) 
						echo "Vol. ".$values[1].", ";
					if (strcmp($collectionHasBooks, "yes") == 0)
						echo "Book ".$values[4].", ";
					echo "Hadith ".$values[3];
					echo "</td></tr>";
				}
				else { // Different reference numbers
					if ($ourHadithNumber > 0) {
						echo "<tr><td>Sunnah.com reference</td><td>&nbsp;:&nbsp;";
						if (strcmp($collectionHasBooks, "yes") == 0) echo "Book ".$values[4].", ";
						echo "Hadith ".$ourHadithNumber;
						echo "</td></tr>";
						if (strcmp($collectionHasBooks, "yes") == 0) $permalink = "/$collection/$ourBookID/$ourHadithNumber";
						else $permalink = "/$collection/$ourHadithNumber"; // This collection has no books.
					}
				
					if ($englishEntry) {
						echo "<tr><td>";
						if (strcmp($collection, "bukhari")==0 or strcmp($collection, "muslim")==0 or strcmp($collection, "malik")==0) echo "USC-MSA web (English) reference</td><td>&nbsp;: ";
						else echo "English reference</td><td>&nbsp;: ";
						if (strcmp($collectionHasVolumes, "yes") == 0) 
							echo "Vol. ".$values[1].", ";
						if (strcmp($collectionHasBooks, "yes") == 0) echo "Book ".$values[2].", ";
						echo "Hadith ".$values[3];
						echo "</td></tr>";
					}
				
					if ($arabicEntry) {
						echo "<tr><td>";
						echo "Arabic reference</td><td>&nbsp;: ";
						if (strcmp($collectionHasBooks, "yes") == 0) echo "Book ".$values[4].", ";
						echo "Hadith ".$values[5];
						echo "</td></tr>";
					}
				}
			}
			
			echo "</table>";

			echo "<div class=\"hadith_permalink\">";
			//echo "<a href=\"javascript:sharethis()\">Share</a>";
			//echo "<a href=\"javascript:permalink('$permalink');\">Permalink</a>";
			//echo "<a href=\"$permalink\">Permalink</a>";
			if (!isset($hideReportError) or !$hideReportError) echo "<a href=\"javascript: void(0);\" onclick=\"reportHadith(".$values[0].", '".$divname."')\">Report Error</a> | ";
			if (!$hideShare) echo "<span class=sharelink onclick=\"share('$permalink')\">Share</span>";
			echo "</div>";

			echo "\n</div>";
?>
