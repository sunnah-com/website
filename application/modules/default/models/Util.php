<?php

class Util extends CModel {

	protected $_collectionsInfo;

	public function attributeNames() {}

	public function getRamadanURNs() {
		$aURNs = array(1121150, /* 118110, */118130, 118150, 118350, 118710, 327590, 327600, 327580, 327620, 327650, 327660, 328170, 1339810);
		return $aURNs;
	}

	public function customSelect($aURNs) {
        $eURNs = array();
        $collections = $this->getCollectionsInfo("indexed");
        $crit = new CDbCriteria;
        $crit->select = '*';
        $crit->addInCondition('arabicURN', $aURNs);
        $arabicSet = ArabicHadith::model()->findAll($crit);
        foreach ($arabicSet as $arabicHadith) $arabicHadith->process_text();
        foreach ($arabicSet as $row) $arabicEntries[$row->arabicURN] = $row;

        for ($i = 0; $i < count($aURNs); $i++) {
            $eURNs[$i] = $arabicEntries[$aURNs[$i]]->matchingEnglishURN;
        }
        $crit = new CDbCriteria;
        $crit->select = '*';
        $crit->addInCondition('englishURN', $eURNs);
        $englishSet = EnglishHadith::model()->findAll($crit);
        foreach ($englishSet as $englishHadith) $englishHadith->process_text();
        foreach ($englishSet as $row) $englishEntries[$row->englishURN] = $row;

        $pairs = array_map(NULL, $eURNs, $aURNs);
        $entries = array($englishEntries, $arabicEntries, $pairs);

        $chapters = array();
        $books = array();
        foreach ($arabicEntries as $arabicEntry) {
            $chapters[$arabicEntry->arabicURN] = $this->getChapter($arabicEntry->collection, $arabicEntry->bookID, $arabicEntry->babNumber);
            $books[$arabicEntry->arabicURN] = $this->getBook($arabicEntry->collection, $arabicEntry->bookID, "arabic");
        }

		$retval = array($collections, $books, $chapters, $entries);
		return $retval;
	}

	public function getHadithCount() {
		$count = Yii::app()->cache->get("hadithCount");
		if ($count === false) {
			$connection = Yii::app()->db;
			if ($connection == NULL) return 0;
			$query = "SELECT COUNT(*) FROM ArabicHadithTable";
			$command = $connection->createCommand($query);
			$count = $command->queryRow();
			$count = $count['COUNT(*)'];
			Yii::app()->cache->set("hadithCount", $count, Yii::app()->params['cacheTTL']);
		}
		return $count;
	}
	
	public function getCollectionsInfo($mode = 'none') {
		$this->_collectionsInfo = Yii::app()->cache->get("collectionsInfo");
		if ($this->_collectionsInfo === false) {
			$connection = Yii::app()->db;
			if ($connection == NULL) return array();
			$query = "SELECT * FROM Collections order by collectionID ASC";
			$command = $connection->createCommand($query);
			$this->_collectionsInfo = $command->queryAll();
			Yii::app()->cache->set("collectionsInfo", $this->_collectionsInfo, Yii::app()->params['cacheTTL']);
		}
		if (strcmp($mode, "indexed") == 0) {
			foreach ($this->collectionsInfo as $collection)
				$collections[$collection['name']] = $collection;
			return $collections;
		}
		return $this->_collectionsInfo;
	}

	public function getCollection($collectionName) {
		$collection = Yii::app()->cache->get("collection:".$collectionName);
        if ($collection === false) {
            $collection = Collection::model()->find("name = :name", array(':name' => $collectionName));
            Yii::app()->cache->set("collection:".$collectionName, $collection, Yii::app()->params['cacheTTL']);
        }
		return $collection;
	}

	public function getBook($collectionName, $bookID = NULL, $language = NULL) {
        $books = Yii::app()->cache->get($collectionName."books");
        $arabic_books = Yii::app()->cache->get($collectionName."books_arabic");
        $english_books = Yii::app()->cache->get($collectionName."books_english");
        if ($books === false or $arabic_books === false or $english_books === false) {
			if (strcmp($collectionName, "nasai") == 0) $books_rs = Book::model()->findAll(array('order' => 'abs(ourBookID)', 'condition' => "collection = :collection", 'params' => array(":collection" => $collectionName)));
            else $books_rs = Book::model()->findAll(array('order' => 'ourBookID', 'condition' => "collection = :collection", 'params' => array(":collection" => $collectionName)));
            foreach ($books_rs as $book) $books[$book->ourBookID] = $book;
            foreach ($books_rs as $book) $arabic_books[$book->arabicBookID] = $book;
            foreach ($books_rs as $book) $english_books[$book->englishBookID] = $book;
            Yii::app()->cache->set($collectionName."books_arabic", $arabic_books, Yii::app()->params['cacheTTL']);
            Yii::app()->cache->set($collectionName."books_english", $english_books, Yii::app()->params['cacheTTL']);
            Yii::app()->cache->set($collectionName."books", $books, Yii::app()->params['cacheTTL']);
        }

		if (is_null($bookID)) return $books;
		if (is_null($language) and is_numeric($bookID)) return $books[$bookID];
		if (strcmp($language, "arabic") == 0 && is_numeric($bookID)) return $arabic_books[$bookID];
		if (strcmp($language, "english") == 0 && is_numeric($bookID)) return $english_books[$bookID];
		
		return NULL;
	}

	public function getBook_old($collectionName, $ourBookID) {
        $book = Yii::app()->cache->get("book:".$collectionName."_".$ourBookID);
        if ($book === false) {
            $book = Book::model()->find("collection = :collection AND ourBookID = :id", array(":collection" => $collectionName, ":id" => intval($ourBookID)));
            Yii::app()->cache->set("book:".$collectionName."_".$ourBookID, $book, Yii::app()->params['cacheTTL']);
            Yii::app()->cache->set("englishbook:".$collectionName."_".$book->englishBookID, $book, Yii::app()->params['cacheTTL']);
            Yii::app()->cache->set("arabicbook:".$collectionName."_".$book->arabicBookID, $book, Yii::app()->params['cacheTTL']);
        }
		return $book;
	}

	public function getBookByLanguageID($collectionName, $bookID, $language = "english") {
		$book = $this->getBook($collectionName, $bookID, $language);
		return $book;
	}

    public function getChapterDataForBook($collectionName, $bookID) {
        $chapters = Yii::app()->cache->get("chapters:".$collectionName."_".$bookID);
        if ($chapters === false) {
            $chapters = Chapter::model()->findAll(array("condition" => "collection = :collection AND arabicBookID = :id", "params" => array(":collection" => $collectionName, ":id" => intval($bookID)), "order" => "babID ASC"));
            Yii::app()->cache->set("chapters:".$collectionName."_".$bookID, $chapters, Yii::app()->params['cacheTTL']);
        }
        return $chapters;
    }

    public function getChapter($collectionName, $bookID, $babID) {
        $chapter = Yii::app()->cache->get("chapter:".$collectionName."_".$bookID."_".$babID);
        if ($chapter === false) {
            $chapter = Chapter::model()->findAll(array("condition" => "collection = :collection AND arabicBookID = :bookID AND babID = :babID", "params" => array(":collection" => $collectionName, ":bookID" => intval($bookID), ":babID" => $babID), "order" => "babID ASC"));
            Yii::app()->cache->set("chapter:".$collectionName."_".$bookID."_".$babID, $chapter, Yii::app()->params['cacheTTL']);
        }
        return $chapter[0];
    }

	public function getHadith($urn, $language = "english") {
		$hadith = Yii::app()->cache->get($language."urn:".$urn);
		if ($hadith === false) {
			if (strcmp($language, "english") == 0) $hadith = EnglishHadith::model()->find("englishURN = :urn", array(':urn' => $urn));
			if (strcmp($language, "arabic") == 0) $hadith = ArabicHadith::model()->find("arabicURN = :urn", array(':urn' => $urn));
			if ($hadith) {
				$hadith->process_text();
				Yii::app()->cache->set($language."urn:".$urn, $hadith, Yii::app()->params['cacheTTL']);
			}
		}
		return $hadith;
	}
}

?>
