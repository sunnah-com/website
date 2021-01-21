<?php

namespace app\modules\front\models;

use yii\base\Model;
use Yii;

class Util extends Model {

	protected $_collectionsInfo;

	public function attributeNames() {}

	public function getRamadanURNs() {
		$aURNs = array(119320, 1121150, /* 118110, */118130, 118150, 118350, 118710, 327600, 327580, 327620, 327650, 327660, 1339810, 706990, 923480);
		return $aURNs;
	}

	public function getDhulhijjahURNs() {
        $aURNs = array(108550, 1123810, 928160, 1712400, 333770, 1522370, 352710, 320930, 332480, 147510, 327660, 327600);
		return $aURNs;
	}

	public function getMuharramURNs() {
        $aURNs = array(1712420, 119210, 327220, 328100, 327140);
		return $aURNs;
	}

	public function customSelect($aURNs) {
        $eURNs = array();
        $collections = $this->getCollectionsInfo("indexed");
        $query = ArabicHadith::find()
            ->select("*")
            ->where(['arabicURN' => $aURNs]);
        $arabicSet = $query->all();
        foreach ($arabicSet as $arabicHadith) { $arabicHadith->process_text(); $arabicHadith->populate($this); }
        foreach ($arabicSet as $row) $arabicEntries[$row->arabicURN] = $row;

        for ($i = 0; $i < count($aURNs); $i++) {
            $eURNs[$i] = $arabicEntries[$aURNs[$i]]->matchingEnglishURN;
        }
        $query = EnglishHadith::find()
            ->select('*')
            ->where(['englishURN' => $eURNs]);
        $englishSet = $query->all();
        foreach ($englishSet as $englishHadith) { $englishHadith->process_text(); $englishHadith->populate($this); }
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

    public function searchByNumber($collectionName, $hadithNumber, $partialSearch = false) {
        $query = ArabicHadith::find()
            ->select('*')
            ->where("collection = :collection", [':collection' => $collectionName]);

        if (!$partialSearch) {
            $query = $query->andWhere(['like', 'hadithNumber', $hadithNumber, $partialSearch]);
        }
        else {
            $query = $query->andWhere(['like', 'hadithNumber', $hadithNumber]);
        }

        $result = $query->all();
        if (count($result) === 0) return null;
        return $result;
    }

    public function getURNByNumber($collectionName, $hadithNumber) {
        /* This function finds a hadith by its canonical number and returns the URN.
           We want it to work only for verified ahadith.
           Some special handling needs to be done for Sahih Muslim (spaces in hadith number)
           and for multiply numbered ahadith
         */

        $num = $hadithNumber;

        // First, try a direct match
        $direct = $this->searchByNumber($collectionName, $num);
        if (!is_null($direct)) {
			foreach ($direct as $result) {
            	$book = $this->getBook($collectionName, $result['bookNumber']);    
            	if ($book->status >= 4) return $result['arabicURN'];
			}
            return null;
        }

        // If the hadith is not found and the collection is Muslim, 
        // rewrite the hadith number to search for
        if ($collectionName === 'muslim') {
			// Did the user supply a letter?
            preg_match('/(\d+)(\w+)/', $hadithNumber, $matches);
            if (count($matches) === 3) {
                $num = $matches[1]." ".$matches[2];
                $direct = $this->searchByNumber($collectionName, $num);
                if (!is_null($direct) && count($direct) === 1) {
                    $book = $this->getBook($collectionName, $direct[0]['bookNumber']);
                    if ($book->status >= 4) return $direct[0]['arabicURN'];
                    return null;
                }
            }

			// If no letter was supplied, try adding 'a' to the hadith number
			$this_num = $hadithNumber." a";
			$direct = $this->searchByNumber($collectionName, $this_num);
			if (!is_null($direct) && count($direct) === 1) {
                $book = $this->getBook($collectionName, $direct[0]['bookNumber']);
                if ($book->status >= 4) return $direct[0]['arabicURN'];
                return null;
            }
        }

        // The last case to check for is multiply numbered hadith
        $results = $this->searchByNumber($collectionName, $num, true);
		if (!is_null($results)) {
	        foreach ($results as $result) {
    	        $resultHadithNumbersArray = explode(",", $result['hadithNumber']);
        	    foreach ($resultHadithNumbersArray as $resultHadithNumber) {
            	    if (trim($resultHadithNumber) == $num) return $result['arabicURN'];
	            }
    	    }
		}

		return null;
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
	
    public function getCollectionsInfo($mode = 'none', $display_only = false) {
        $cache_key = "collectionsInfo"."_".(string)$display_only;
		$this->_collectionsInfo = Yii::$app->cache->get($cache_key);
		if ($this->_collectionsInfo === false) {
			$connection = Yii::$app->db;
            if ($connection == NULL) return array();
            $showOnHomeCondition = "";
            if ($display_only) { $showOnHomeCondition = "where showOnHome = 1"; }
			$query = "SELECT * FROM Collections $showOnHomeCondition order by collectionID ASC";
			$command = $connection->createCommand($query);
			$this->_collectionsInfo = $command->queryAll();
			Yii::$app->cache->set($cache_key, $this->_collectionsInfo, Yii::$app->params['cacheTTL']);
		}
		if (strcmp($mode, "indexed") == 0) {
			foreach ($this->collectionsInfo as $collection)
				$collections[$collection['name']] = $this->getCollection($collection['name']);
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
			if (strcmp($collectionName, "nasai") == 0 or strcmp($collectionName, "shamail") == 0) $books_rs = Book::find()->where('collection = :collection', [':collection' => $collectionName])->orderBy(['abs(ourBookID)' => SORT_ASC, 'englishBookID' => SORT_ASC])->all();
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
				$hadith->populate($this);
				Yii::$app->cache->set($language."urn:".$urn, $hadith, Yii::$app->params['cacheTTL']);
			}
		}
		return $hadith;
    }

    public function getVerifiedHadithNumber($urn, $language = "english") {
	    $hadith = $this->getHadith($urn, $language);
        if ($language != "arabic") { $hadith = $this->getHadith($hadith->matchingArabicURN, "arabic"); }
        $hadithNumber = $hadith->hadithNumber;
        $hadithNumber = explode(",", $hadithNumber)[0];
        if ($hadith->collection == "muslim" && $hadith->bookID !== -1) {
            $hadithNumber = preg_replace("/(\d)\s*([a-zA-Z])/", "$1$2", $hadithNumber);
        }
        return $hadithNumber;
    }

    // The following two functions should really be written for arabicURNs
    // but can't until we move to arabicURN ordering in ALL books
    public function getNextURNInCollection($urn) {
        $hadith = $this->getHadith($urn, "english");
        $nextURN = EnglishHadith::find()
                                ->where("collection = :collection", [':collection' => $hadith->collection])
                                ->andWhere("bookID = :bookID", [':bookID' => $hadith->bookID])
                                ->andWhere("englishURN > :urn", [':urn' => $urn])
                                ->min('englishURN');
        if (is_null($nextURN)) {
            // We're at the end of a book. See if there is a next book.
            $ourBookID = $this->getBook($hadith->collection, $hadith->bookID, "english")->ourBookID;
            $nextOurBookID = Book::find()
                                 ->where("collection = :collection", [':collection' => $hadith->collection])
                                 ->andWhere("ourBookID > :bookID", [':bookID' => $ourBookID])
                                 ->min('ourBookID');
            if (!is_null($nextOurBookID)) {
                $nextURN = $this->getBook($hadith->collection, $nextOurBookID)->firstURN;
            }
        }
        return $nextURN;
    }

    public function getPreviousURNInCollection($urn) {
        $hadith = $this->getHadith($urn, "english");
        $previousURN = EnglishHadith::find()
                                ->where("collection = :collection", [':collection' => $hadith->collection])
                                ->andWhere("bookID = :bookID", [':bookID' => $hadith->bookID])
                                ->andWhere("englishURN < :urn", [':urn' => $urn])
                                ->max('englishURN');
        if (is_null($previousURN)) {
            // We're at the beginning of a book. See if there is a previous book.
            $ourBookID = $this->getBook($hadith->collection, $hadith->bookID, "english")->ourBookID;
            $previousOurBookID = Book::find()
                                 ->where("collection = :collection", [':collection' => $hadith->collection])
                                 ->andWhere("ourBookID < :bookID", [':bookID' => $ourBookID])
                                 ->max('ourBookID');
            if (!is_null($previousOurBookID)) {
                $previousURN = $this->getBook($hadith->collection, $previousOurBookID)->lastURN;
            }
        }
        return $previousURN;
    }

    public function get_permalink($urn, $language = "english") {
        // As of now, this method only works for hadith in verified books. 
        $hadith = $this->getHadith($urn, $language);
        if ($language != "arabic") { $hadith = $this->getHadith($hadith->matchingArabicURN, "arabic"); }
        return $hadith->permalink;
    }

    public function getCarouselHTML($arabicURNs) {
        $aURNs = $arabicURNs;
		shuffle($aURNs);
        $retval = $this->customSelect($aURNs);
        $collections = $retval[0];
        $books = $retval[1];
        $chapters = $retval[2];
        $entries = $retval[3];
	    $englishEntries = $entries[0];
	    $arabicEntries = $entries[1];
    	$pairs = $entries[2];

		$s = "";
		foreach ($pairs as $pair) {
			$s .= "\n<li><div class=carousel_item>\n";
			$englishEntry = $englishEntries[$pair[0]];
			$arabicEntry = $arabicEntries[$pair[1]];

			$arabicText = $arabicEntry->hadithText;
			$englishText = $englishEntry->hadithText;
			$truncation = false;

			if (strlen($arabicText) <= 530) $arabicSnippet = $arabicText;
            else {
            	$pos = strpos($arabicText, ' ', 530);
                if ($pos === FALSE) $arabicSnippet = $arabicText;
                else {
					$arabicSnippet = substr($arabicText, 0, $pos)." &hellip;";
					$truncation = true;
				}
            }

			if (strlen($englishText) <= 300) $englishSnippet = $englishText;
            else {
            	$pos = strpos($englishText, ' ', 300);
                if ($pos === FALSE) $englishSnippet = $englishText;
                else {
					$englishSnippet = substr($englishText, 0, $pos)." &hellip;";
					$truncation = true;
				}
            }

			$s .= "<div class=arabic>".$arabicSnippet."</div>";

			$englishText = $englishSnippet;
			$s .= "<div class=\"english_hadith_full\" style=\"padding-left: 0;\">";
            if (strpos($englishText, ":") === FALSE) {
                $s .= "<div class=text_details>\n
                     ".$englishText."</div><br />\n";
            }
            else {
                $s .= "<div class=hadith_narrated>".strstr($englishText, ":", true).":</div>";
                $s .= "<div class=text_details>
                     ".substr(strstr($englishText, ":", false), 1)."</div>\n";
            }
            $s .= "<div class=clear></div></div>";

			//$s .= "<div class=text_details style=\"margin-top: 10px;\">".$englishSnippet."</div>";

			if ($truncation) {
				$permalink = "/".$arabicEntry->collection."/".$books[$arabicEntry->arabicURN]->ourBookID."/".$arabicEntry->ourHadithNumber;
				$s .= "<div style=\"text-align: right; width: 100%;\"><a href=\"$permalink\">Full hadith &hellip;</a></div>";
			}

			$s .= "<div class=hadith_reference style=\"padding: 5px 0 0 0; font-size: 12px;\">";
			$s .= $collections[$arabicEntry->collection]['englishTitle'];
			$s .= " ".$arabicEntry->hadithNumber;
			$s .= "</div>";

			$s .= "\n</div></li>\n";
		}

		return $s;
	}

	/**
	 * Given a language and an array of URNs, get the
	 * corresponding matching URNs in other language.
	 * @param string $lang 'en' or 'ar'
	 * @param int $urns
	 * @return array inputURN => matchingURN
	 */
	public function getMatchingUrns($lang, $urns) {
		$fullLabels = array(
			'en' => 'englishURN',
			'ar' => 'arabicURN',
		);
		$mainField = $lang === 'en' ? $fullLabels['en'] : $fullLabels['ar'];
		$correspondingField = $lang === 'en' ? $fullLabels['ar'] : $fullLabels['en'];

		$query = Match::find()
			->select('*')
			->where([$mainField => $urns]);
		$results = $query->all();
		$ret = array();
		foreach ($results as $row) {
			$ret[$row[$mainField]] = $row[$correspondingField];
		}
		return $ret;
	}
}

?>
