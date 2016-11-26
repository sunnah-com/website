<a name="0"></a>

<?php
	$englishEntry = $this->_viewVars->englishEntry;
	$arabicEntry = $this->_viewVars->arabicEntry;
	$ourBookID = $this->_ourBookID;
	$collectionHasVolumes = $this->_collection->hasvolumes;
	$collectionHasBooks = $this->_collection->hasbooks;
    $status = $this->_book->status;

	$englishExists = true; $arabicExists = true;
	if (is_null($englishEntry)) {
		$englishExists = false;
		$englishEntry = new EnglishHadith();
	}
	if (is_null($arabicEntry)) {
		$arabicExists = false;
		$arabicEntry = new ArabicHadith();
	}

	if ($englishExists || $arabicExists) {

		if ($englishExists) $urn = $englishEntry->englishURN;
		else $urn = $arabicEntry->arabicURN;
		
		echo "<div class=AllHadith>\n";
		echo "<div class=actualHadithContainer id=h".$arabicEntry->arabicURN.">\n";		
		echo $this->renderPartial('/collection/printhadith', array(
		   'arabicEntry' => $arabicEntry,
	       'englishText' => $englishEntry->hadithText,
           'grade' => $englishEntry->grade1,
           'arabicText' => $arabicEntry->hadithText, 'otherlangs' => NULL));	
				
		if ($englishExists) {
			$urn = $englishEntry->englishURN;
			$ourHadithNumber = $englishEntry->ourHadithNumber;
			$collection = $englishEntry->collection;
		}
		else {
			$urn = $arabicEntry->arabicURN;
			$ourHadithNumber = $arabicEntry->ourHadithNumber;
			$collection = $arabicEntry->collection;
		}

		echo $this->renderPartial('/collection/hadith_reference', array(
			'englishEntry' => $englishExists,
			'arabicEntry' => $arabicExists,
			'values' => array($urn, 
				$englishEntry->volumeNumber, 
				$englishEntry->bookNumber,
				$englishEntry->hadithNumber,
				$arabicEntry->bookNumber,
				$arabicEntry->hadithNumber,
				$ourHadithNumber, $collection, $ourBookID, $collectionHasBooks, $collectionHasVolumes, $status, $this->_collection->englishTitle, $englishEntry->grade1, $arabicEntry->grade1, false, "h".$arabicEntry->arabicURN)
        ));	
						
		echo "<div class=hline></div>";
		echo "<div style=\"clear: both;\"></div>";
		echo "</div></div>";
    }


?>


