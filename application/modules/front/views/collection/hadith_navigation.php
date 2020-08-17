<?php
						echo "<div class=\"hadith_nav_wrapper\">";

                        if (isset ($previousPermalink) && !is_null($previousPermalink) ) {
                            echo "<a class=\"hadith_nav button prev\" title=\"$collection->englishTitle $previousHadithNumber\" href=\"$previousPermalink\">$previousHadithNumber</a>";
                        } else {
                            // Is first in the collection
                            echo "<a class=\"hadith_nav button prev\" disabled=disabled></a>";
                        }

                        if (isset($nextPermalink) && !is_null($nextPermalink)) {
                            echo "<a class=\"hadith_nav button next\" title=\"$collection->englishTitle $nextHadithNumber\" href=\"$nextPermalink\">$nextHadithNumber</a>";
                        } else {
                            // Is last in the collection
                            echo "<a class=\"hadith_nav button next\" disabled=disabled></a>";
                        }

                        echo "</div>";

