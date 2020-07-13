<?php

namespace app\modules\front\models;

use yii\base\Model;
use Yii;

class Util extends Model {

	protected $_collectionsInfo;

	public function attributeNames() {}

	public function getRamadanURNs() {
		$aURNs = array(119320, 1121150, /* 118110, */118130, 118150, 118350, 118710, 327600, 327580, 327620, 327650, 327660, 1339810, 706990);
		return $aURNs;
	}

	public function customSelect($aURNs) {
        $eURNs = array();
        $collections = $this->getCollectionsInfo("indexed");
        $query = ArabicHadith::find()
            ->select("*")
            ->where(['arabicURN' => $aURNs]);
        $arabicSet = $query->all();
        foreach ($arabicSet as $arabicHadith) $arabicHadith->process_text();
        foreach ($arabicSet as $row) $arabicEntries[$row->arabicURN] = $row;

        for ($i = 0; $i < count($aURNs); $i++) {
            $eURNs[$i] = $arabicEntries[$aURNs[$i]]->matchingEnglishURN;
        }
        $query = EnglishHadith::find()
            ->select('*')
            ->where(['englishURN' => $eURNs]);
        $englishSet = $query->all();
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
		$count = Yii::$app->cache->get("hadithCount");
		if ($count === false) {
			$connection = Yii::$app->db;
			if ($connection == NULL) return 0;
			$query = "SELECT COUNT(*) FROM ArabicHadithTable";
			$command = $connection->createCommand($query);
			$count = $command->queryOne();
			$count = $count['COUNT(*)'];
			Yii::$app->cache->set("hadithCount", $count, Yii::$app->params['cacheTTL']);
		}
		return $count;
	}
	
	public function getCollectionsInfo($mode = 'none') {
		$this->_collectionsInfo = Yii::$app->cache->get("collectionsInfo");
		if ($this->_collectionsInfo === false) {
			$connection = Yii::$app->db;
			if ($connection == NULL) return array();
			$query = "SELECT * FROM Collections order by collectionID ASC";
			$command = $connection->createCommand($query);
			$this->_collectionsInfo = $command->queryAll();
			Yii::$app->cache->set("collectionsInfo", $this->_collectionsInfo, Yii::$app->params['cacheTTL']);
		}
		if (strcmp($mode, "indexed") == 0) {
			foreach ($this->collectionsInfo as $collection)
				$collections[$collection['name']] = $collection;
			return $collections;
		}
		return $this->_collectionsInfo;
	}

	public function getCollection($collectionName) {
		$collection = Yii::$app->cache->get("collection:".$collectionName);
        if ($collection === false) {
            $collection = Collection::find()
                ->where('name = :name', [':name' => $collectionName])
                ->one();
            Yii::$app->cache->set("collection:".$collectionName, $collection, Yii::$app->params['cacheTTL']);
        }
		return $collection;
	}

	public function getBook($collectionName, $bookID = NULL, $language = NULL) {
        $books = Yii::$app->cache->get($collectionName."books");
        $arabic_books = Yii::$app->cache->get($collectionName."books_arabic");
        $english_books = Yii::$app->cache->get($collectionName."books_english");
        if ($books === false or $arabic_books === false or $english_books === false) {
			if (strcmp($collectionName, "nasai") == 0) $books_rs = Book::find()->where('collection = :collection', [':collection' => $collectionName])->orderBy(['abs(ourBookID)' => SORT_ASC])->all();
            else $books_rs = Book::find()->where('collection = :collection', [':collection' => $collectionName])->orderBy(['ourBookID' => SORT_ASC])->all();
            foreach ($books_rs as $book) $books[$book->ourBookID] = $book;
            foreach ($books_rs as $book) $arabic_books[$book->arabicBookID] = $book;
            foreach ($books_rs as $book) $english_books[$book->englishBookID] = $book;
            Yii::$app->cache->set($collectionName."books_arabic", $arabic_books, Yii::$app->params['cacheTTL']);
            Yii::$app->cache->set($collectionName."books_english", $english_books, Yii::$app->params['cacheTTL']);
            Yii::$app->cache->set($collectionName."books", $books, Yii::$app->params['cacheTTL']);
        }

		if (is_null($bookID)) return $books;
		if (is_null($language) and is_numeric($bookID) and array_key_exists($bookID, $books)) return $books[$bookID];
		if (strcmp($language, "arabic") == 0 && is_numeric($bookID) and array_key_exists($bookID, $arabic_books)) return $arabic_books[$bookID];
		if (strcmp($language, "english") == 0 && is_numeric($bookID) and array_key_exists($bookID, $english_books)) return $english_books[$bookID];
		//if (is_null($language) and is_numeric($bookID)) return $books[$bookID];
		//if (strcmp($language, "arabic") == 0 && is_numeric($bookID)) return $arabic_books[$bookID];
		//if (strcmp($language, "english") == 0 && is_numeric($bookID)) return $english_books[$bookID];
		
		return NULL;
	}

	public function getBookByLanguageID($collectionName, $bookID, $language = "english") {
		$book = $this->getBook($collectionName, $bookID, $language);
		return $book;
	}

    public function getChapterDataForBook($collectionName, $bookID) {
        $chapters = Yii::$app->cache->get("chapters:".$collectionName."_".$bookID);
        if ($chapters === false) {
            $chapters = Chapter::find()
                ->where("collection = :collection", [':collection' => $collectionName])
                ->andWhere("arabicBookID = :id", [':id' => intval($bookID)])
                ->orderBy(["babID" => SORT_ASC])
                ->all();
            Yii::$app->cache->set("chapters:".$collectionName."_".$bookID, $chapters, Yii::$app->params['cacheTTL']);
        }
        return $chapters;
    }

    public function getChapter($collectionName, $bookID, $babID) {
        $chapter = Yii::$app->cache->get("chapter:".$collectionName."_".$bookID."_".$babID);
        if ($chapter === false) {
            $chapter = Chapter::find()
                ->where("collection = :collection", [':collection' => $collectionName])    
                ->andWhere("arabicBookID = :id", [':id' => intval($bookID)])
                ->andWhere("babID = :bid", [':bid' => $babID])
                ->orderBy(["babID" => SORT_ASC])
                ->all();
            Yii::$app->cache->set("chapter:".$collectionName."_".$bookID."_".$babID, $chapter, Yii::$app->params['cacheTTL']);
        }
        return $chapter[0];
    }

	public function getHadith($urn, $language = "english") {
		$hadith = Yii::$app->cache->get($language."urn:".$urn);
		if ($hadith === false) {
            if (strcmp($language, "english") == 0) $hadith = EnglishHadith::find()
                                                                ->where("englishURN = :urn", [':urn' => $urn])->one();
            if (strcmp($language, "arabic") == 0) $hadith = ArabicHadith::find()
                                                                ->where("arabicURN = :urn", [':urn' => $urn])->one();
			if ($hadith) {
				$hadith->process_text();
				Yii::$app->cache->set($language."urn:".$urn, $hadith, Yii::$app->params['cacheTTL']);
			}
		}
		return $hadith;
	}
}

?>
