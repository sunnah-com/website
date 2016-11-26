<?php

			$collection = $values[7];
			$ourHadithNumber = $values[6];
			$ourBookID = $values[8];
			$collectionHasBooks = $values[9]; 
			$collectionHasVolumes = $values[10];
			$bookstatus = $values[11];
			$collectionEnglishTitle = $values[12];
			$permalink = "/urn/".$values[0];
			$englishGrade1 = $values[13]; $arabicGrade1 = $values[14];
			$divname = $values[16];
			$hideReportError = $values[15];

			echo "<div class=bottomItems>\n";
	    if (strlen($englishGrade1) > 0 or strlen($arabicGrade1) > 0) {
    	    echo "<div class=hadith_annotation>";
			echo "<table class=gradetable cellspacing=0 cellpadding=0 border=0>";
	        echo "<tr>";
			if (strlen($englishGrade1) > 0) echo "<td class=english_grade width=\"107px\"><b>Grade</b></td><td class=english_grade width=\"36%\">:&nbsp;<b>".ucfirst(trim($englishGrade1))."</b> (".$this->_collections[$collection]['englishgrade1'].")</td>";
			else echo "<td height=100% width=40% class=english_grade></td>";
    	    if (strlen($arabicGrade1) > 0 && !is_null($arabicGrade1)) {
				Yii::trace("our hadith number is ".$ourHadithNumber);
				echo "<td class=\"arabic_grade arabic\">&nbsp;<b> ".$arabicGrade1."</b>";
				echo "&nbsp;&nbsp; (".$this->_collections[$collection]['arabicgrade1'].") </td>";
				echo "<td class=\"arabic_grade arabic\" width=\"57px\"><b>حكم</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>";
			}
			else echo "<td height=100% width=60% class=arabic_grade></td>";
			echo "</tr></table>";
	        echo "</div>";
    	}


			echo "<table class=hadith_reference cellspacing=0 cellpadding=0>";

			if ($bookstatus == 4) {
				echo "<tr><td><b>Reference</b></td>";
				echo "<td>&nbsp;:&nbsp;";
				echo "$collectionEnglishTitle ".$values[5]."";
				echo "</b></td></tr>";

				if (strcmp($collectionHasBooks, "yes") == 0) {
					echo "<tr><td>In-book reference</td>";
					echo "<td>&nbsp;:&nbsp;";
					if ($ourBookID > 0) echo "Book $ourBookID, ";
					elseif ($ourBookID == -35) echo "Book 35b, ";
					else echo "Introduction, ";
					if (strcmp($collection, "muslim") == 0 and ($ourBookID == -1)) echo "Narration ";
					else echo "Hadith ";
					echo $ourHadithNumber;
					echo "</td></tr>";
				}

				if ($englishEntry and /* $values[5] != $values[3] and */ intval($values[3]) != 0) {
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
						if (strcmp($collectionHasBooks, "yes") == 0) $permalink = "/$collection/$ourBookID/$ourHadithNumber";
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
			echo "<span class=sharelink onclick=\"share('$permalink')\">Share</span>";
			echo "</div>";

			echo "\n</div>";
?>
