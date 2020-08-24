<?php
						echo "<div class=\"hadith_nav_wrapper\">";

                        if (isset ($previousPermalink) && !is_null($previousPermalink) ) {
                            echo "<a class=\"hadith_nav button prev\" title=\"$collection->englishTitle $previousHadithNumber\" href=\"$previousPermalink\"><i class=\"icn-left\"></i> $previousHadithNumber</a>";
                        } else {
                            // Is first in the collection
                            echo "<a class=\"hadith_nav button prev\" disabled=disabled><i class=\"icn-left\"></i></a>";
                        }

                        if (isset($nextPermalink) && !is_null($nextPermalink)) {
                            echo "<a class=\"hadith_nav button next\" title=\"$collection->englishTitle $nextHadithNumber\" href=\"$nextPermalink\">$nextHadithNumber <i class=\"icn-right\"></i></a>";
                        } else {
                            // Is last in the collection
                            echo "<a class=\"hadith_nav button next\" disabled=disabled><i class=\"icn-right\"></i></a>";
                        }

                        echo "</div>";

