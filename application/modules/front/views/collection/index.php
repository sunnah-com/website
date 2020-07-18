<?php 
if (isset($errorMsg)) echo $errorMsg;
else {
	$entries_keys = array_keys($entries);
	$totalCount=count($entries);
	$complete = strcmp($collection->status, "complete") == 0;
	if (!$complete) $fullblocks = floor(10*($collection->numhadith)/($collection->totalhadith));

?>

	

	<div class="collection_info">
		<div class="colindextitle <?php echo $complete ? "complete" : "incomplete";?>">
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
			if (strlen($collection->shortintro) > 0) { ?>
				<div class=colindextitle>
				<?php
				echo $collection->shortintro; 
				echo "<br><div align=right style=\"padding-top: 7px;\"><a href=\"/$collectionName/about\">More information ...</a></div>\n\n"; ?>
				</div>
				<?php
			}
		?>
	<div class=clear></div>
	</div>


		<div class="book_titles titles">
				<?php
					for ($i = 0; $i < $totalCount; $i++) {
						$entry = $entries[$entries_keys[$i]];

                        echo "<div class=\"book_title title\" id=\"obi".$entry->ourBookID."\">\n";

						if ($entry->ourBookID == -1) echo "<a href=\"/".$entry->collection."/introduction\">\n";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "<a href=\"/".$entry->collection."/35b\">\n";
						elseif ($entry->ourBookID == -8 and strcmp($collectionName, "shamail") == 0) echo "<a href=\"/".$entry->collection."/8b\">\n";
						else echo "<a href=\"/".$entry->collection."/".$entry->ourBookID."\">\n";

						echo "<div class=\"book_number title_number\">";
						if ($entry->ourBookID == -1) echo "&nbsp;";
						elseif ($entry->ourBookID == -35 and strcmp($collectionName, "nasai") == 0) echo "35b";
						elseif ($entry->ourBookID == -8 and strcmp($collectionName, "shamail") == 0) echo "8b";
						else echo $entry->ourBookID;
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
