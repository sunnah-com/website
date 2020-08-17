<a name="0"></a>

<?php
	$ourBookID = $book->ourBookID;
	$collectionHasVolumes = $collection->hasvolumes;
	$collectionHasBooks = $collection->hasbooks;
    $status = $book->status;

	$englishExists = true; $arabicExists = true;
	if (is_null($englishEntry)) {
		$englishExists = false;
		$englishEntry = new \app\modules\front\models\EnglishHadith();
	}
	if (is_null($arabicEntry)) {
		$arabicExists = false;
		$arabicEntry = new \app\modules\front\models\ArabicHadith();
	}

	if ($englishExists || $arabicExists) {

		if ($englishExists) $urn = $englishEntry->englishURN;
		else $urn = $arabicEntry->arabicURN;
		
		echo "<div class=AllHadith>\n";
		echo "<div class=actualHadithContainer id=h".$arabicEntry->arabicURN.">\n";		
		echo $this->render('/collection/printhadith', array(
		   'arabicEntry' => $arabicEntry,
	       'englishText' => $englishEntry->hadithText,
           'grade' => $englishEntry->grade1,
           'arabicText' => $arabicEntry->hadithText, 'otherlangs' => NULL));	
				
		if ($englishExists) {
			$urn = $englishEntry->englishURN;
			$ourHadithNumber = $englishEntry->ourHadithNumber;
			$collectionName = $englishEntry->collection;
		}
		else {
			$urn = $arabicEntry->arabicURN;
			$ourHadithNumber = $arabicEntry->ourHadithNumber;
			$collectionName = $arabicEntry->collection;
		}

		echo $this->render('/collection/hadith_reference', array(
			'englishEntry' => $englishExists,
            'arabicEntry' => $arabicExists,
            '_collection' => $collection,
			'values' => array($urn, 
				$englishEntry->volumeNumber, 
				$englishEntry->bookNumber,
				$englishEntry->hadithNumber,
				$arabicEntry->bookNumber,
				$arabicEntry->hadithNumber,
				$ourHadithNumber, $collectionName, $ourBookID, $collectionHasBooks, $collectionHasVolumes, $status, $collection->englishTitle, $englishEntry->grade1, $arabicEntry->grade1, false, "h".$arabicEntry->arabicURN)
        ));	
						
		echo "<div class=hline></div>";
		echo "<div style=\"clear: both;\"></div>";
		echo "</div><!-- end actual hadith container -->";
		
		if (isset($nextPermalink) || isset($previousPermalink)) {
        	echo $this->render('/collection/hadith_navigation', array(
                                'previousPermalink' => isset($previousPermalink) ? $previousPermalink : null,
                                'previousHadithNumber' => isset($previousPermalink) ? $previousHadithNumber : null,
                                'nextPermalink' => isset($nextPermalink) ? $nextPermalink : null,
                                'nextHadithNumber' => isset($nextPermalink) ? $nextHadithNumber : null,
                                'collection' => $collection,
            ));
        }


		echo "</div>";
    }


?>


