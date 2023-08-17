<?php 
if (isset($errorMsg)) echo $errorMsg;
else {
	$entries_keys = array_keys($entries);
	$totalCount=count($entries);
	$complete = strcmp($collection->status, "complete") == 0;
	if (!$complete) $fullblocks = floor(10*($collection->numhadith)/($collection->totalhadith));

?>

	

	<div class="collection_info">
		<div class="colindextitle <?php echo (($complete)) ? "complete" : "incomplete";?>">
			<div class="arabic"><?php echo $collection->arabicTitle; ?></div>
			<div class="english"><?php echo $collection->englishTitle;?></div>
			<div class=clear></div>
		</div>
		<?php if (isset($fullblocks)) { ?>
		<div class="col_progress">
			<div class="progress_full" style="width: <?php echo ceil($fullblocks*13); ?>px;"></div>
			<div class="progress_half" style="width: <?php echo ceil((10-$fullblocks)*9); ?>px;"></div>
			<div class="progress_text"><?php echo floor(100*($collection->numhadith)/($collection->totalhadith)); ?>% complete</div>
		</div>
		<?php }
			if (strlen($collection->shortintro) > 0) {
				echo "<div class=\"colindextitle\">\n";
				echo $collection->shortintro;

                $aboutpath = "about/".$collectionName.".php";
                $path = __DIR__ ."/".$aboutpath;
                if (realpath($path)) {
                    echo "<br><div align=right style=\"padding-top: 7px;\"><a href=\"/$collectionName/about\">More information ...</a></div>\n\n";
                }

				echo "</div>\n";
			}
		?>
	<div class=clear></div>
	</div>


		<div class="book_titles titles">
				<?php
					for ($i = 0; $i < $totalCount; $i++) {
						$entry = $entries[$entries_keys[$i]];

                        echo "<div class=\"book_title title\" id=\"obi".$entry->ourBookID."\">\n";

                        if (!is_null($entry->linkpath)) echo "<a href=\"/".$entry->linkpath."\">\n";
                        else {
                            if (!is_null($entry->ourBookNum)) $booklinkpath = $entry->ourBookNum;
                            else $booklinkpath = (string) $entry->ourBookID;
						    echo "<a href=\"/".$entry->collection."/".$booklinkpath."\">\n";
                        }

                        echo "<div class=\"book_number title_number\">";
                        $book_number_to_display = (string) $entry->ourBookID;
                        if (!is_null($entry->ourBookNum)) $book_number_to_display = $entry->ourBookNum;
						echo $book_number_to_display;
						echo "</div>";

						echo "<div class=\"english english_book_name\">";
						echo $entry->englishBookName."</div>";

						echo "<div class=\"arabic arabic_book_name\">".$entry->arabicBookName."</div>";
						echo '</a>';
						if ($entry->firstNumber > 0) {
							echo "<div class=book_range>";
							echo "<div>".$entry->firstNumber."</div>";
							echo "<div> to </div>";
							echo "<div>".$entry->lastNumber."</div>";
							echo "</div>";
						}
						echo "<div class=clear></div>";
						echo "</div><!-- end book_title div -->\n";
    				}
				?>
		</div>
		<div class=clear></div>

<?php

} // end the main display if no error

?>
