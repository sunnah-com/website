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

			echo "<div class=bottomItems>\n";


			echo "<table class=hadith_reference cellspacing=0 cellpadding=0>";

			if ($bookstatus == 4) {
				echo "<tr><td><b>Reference</b></td>";
				echo "<td>&nbsp;:&nbsp;";
				echo "$collectionEnglishTitle ".$values[5]."";
				echo "</b></td></tr>";

				if ($ourBookID > 0) $permalink = "/$collection/$ourBookID/$ourHadithNumber";
			}
			
			echo "</table>";

			echo "<div class=\"hadith_permalink\">
                    <span class=top_link><a class=\"action_toTop\" href=\"#0\"><span></span>to top</a></span>
					| <a href=\"$permalink\">Permalink</a>
				  </div>";

			echo "\n</div>";
?>
