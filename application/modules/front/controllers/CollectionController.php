<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use Yii;
use yii\web\NotFoundHttpException;

class CollectionController extends SController
{
	protected $_collection;
	protected $_book;
	protected $_entries;
	protected $_chapters;
	protected $_collections;
	protected $_books;
	protected $_collectionName;
	protected $_otherlangs;

    public function behaviors() {
        return [
            [
                   'class' => 'yii\filters\PageCache',
                   'except' => ['selection-data'],
                   'duration' => Yii::$app->params['cacheTTL'],
                   'variations' => [ 
                       Yii::$app->request->get('id'), 
                       Yii::$app->request->get('collectionName'),
                       Yii::$app->request->get('ourBookID'),
                       Yii::$app->request->get('urn'),
                       Yii::$app->request->get('hadithNumbers'),
                       Yii::$app->request->get('lang'),
                       Yii::$app->request->get('selection'),
                       Yii::$app->request->get('hadithNumber'),
                       Yii::$app->request->get('_escaped_fragment_'),
                   ],

            ],
        ];
	}

    public function actionAjaxHadith($collectionName, $ourBookID, $lang) {
        $this->_book = $this->util->getBook($collectionName, $ourBookID);
		if ($this->_book) {
			$this->_entries = $this->_book->fetchLangHadith($lang);
			echo json_encode($this->_entries);
		}
	}
	
	public function actionIndex($collectionName)
	{
		$this->view->params['_pageType'] = "collection";
		$this->_collection = $this->util->getCollection($collectionName);
        if ($this->_collection) {
        	$this->_entries = $this->util->getBook($collectionName);
        }
        if (is_null($this->_collection) || count($this->_entries) === 0) {
            $errorMsg = "There is no such collection on our website. Click <a href=\"/\">here</a> to go to the home page.";
        	throw new NotFoundHttpException($errorMsg);
        }

        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
		if ($this->_collection->shortintro != '') {
            $this->view->params['_ogDesc'] = $this->_collection->shortintro;
        }
        return $this->render('index', [
                                        'entries' => $this->_entries, 
                                        'collection' => $this->_collection,
                                        'collectionName' => $collectionName,
                                      ]);
    }
    
    public function actionAbout($collectionName, $splpage = NULL) {
		$this->_collection = $this->util->getCollection($collectionName);
        $this->view->params['_pageType'] = "about";
        $this->pathCrumbs("About", "");
        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");
		$viewVars = array('collection' => $this->_collection,
                          'collectionName' => $collectionName,
                          'splpage' => $splpage);
        return $this->render('about', $viewVars);
    }

	public function handleOldRiyadussalihinLinks($ourBookID, $hadithNumbers) {
		$link = null;
		
		if ($ourBookID === 20) {
			if (!is_null($hadithNumbers)) {
				$link = "/riyadussalihin/19/$hadithNumbers";
            }
			else $link = "/riyadussalihin/19";
        }

		$replacements = array( 1 => array(47, "introduction"), // new book number => (last hadith in new book, old book)
		                       3 => array(35, 2),
		                       4 => array(31, 3),
		                       7 => array(35, 6),
		                       9 => array(3, 8),
		                       12 => array(17, 11),
		                       13 => array(4, 12),
		                       16 => array(46, 15),
		                       18 => array(61, 17),
		                       19 => array(28, 18),
						);
		foreach ($replacements as $bookID => $repl_array) {
			if ((int)$ourBookID === $bookID) {
				if (!is_null($hadithNumbers)) {
					$parts = explode("-", $hadithNumbers, 2);
					$first_part = $parts[0];
					if ((int)$first_part > $repl_array[0]) {
                        $link = "/riyadussalihin/".$repl_array[1]."/$hadithNumbers";
                    }
				}
			}
		}

		return $link;
	}

    public function actionDispbook($collectionName, $ourBookID, $hadithNumbers = NULL, $_escaped_fragment_ = "default") {
		// Handle unambiguous redirects for collections that have had their book numberings changed
		if ($collectionName === 'riyadussalihin') {
			$redirectLink = $this->handleOldRiyadussalihinLinks($ourBookID, $hadithNumbers);
			if (!is_null($redirectLink)) return $this->redirect($redirectLink, 301);
		}
		
		if (!(is_null($hadithNumbers))) $hadithRange = addslashes($hadithNumbers);
        else $hadithRange = NULL;
		$this->_collection = $this->util->getCollection($collectionName);
        if (is_null($this->_collection)) {
			$errorMsg = "There is no such collection on our website. Click <a href=\"/\">here</a> to go to the home page.";
        	throw new NotFoundHttpException($errorMsg);
        }
        
		$this->view->params['collection'] = $this->_collection;
        $this->_book = $this->util->getBook($collectionName, $ourBookID);
        if (!is_null($this->_book)) $expectedHadithCount = $this->_book->totalNumber;
        else throw new NotFoundHttpException("Book $ourBookID is unavailable or does not exist.");
        $this->view->params['book'] = $this->_book;
        if ($this->_book) {
			$this->_entries = $this->_book->fetchHadith($hadithRange);
        	if (!is_null($this->_entries)) $pairs = $this->_entries[2];
		}
		if (!isset($pairs) or is_null($pairs)) {
			throw new NotFoundHttpException("The data is unavailable or does not exist. Please <a href=\"/contact\">send us a message</a> if you think this is an error.");
		}
        if (($this->_book) and ($this->_book->status === 4) and is_array($pairs) and ($expectedHadithCount != count($pairs)) and is_null($hadithRange))
            Yii::warning("hadith count should be ".$expectedHadithCount." and pairs length is ".count($pairs));
		$this->view->params['lastUpdated'] = $this->_entries[3];

        $viewVars = [
            'englishEntries' => $this->_entries[0],
            'arabicEntries' => $this->_entries[1],
            'pairs' => $this->_entries[2],
            'ourBookID' => $ourBookID,
            'collection' => $this->_collection,
            'book' => $this->_book,
			'expectedHadithCount' => $expectedHadithCount,
        ];

        if (is_null($hadithRange)) {
			$this->view->params['_pageType'] = "book";
		}
        else {
            $this->view->params['_pageType'] = "hadith";
            $this->pathCrumbs('Hadith', "");
            if ($this->_book->status > 3 and count($pairs) === 1) { // If it's a single-hadith view page
                $urn = $this->_entries[0][$pairs[0][0]]->englishURN;
                $nextURN = $this->util->getNextURNInCollection($urn);
                $previousURN = $this->util->getPreviousURNInCollection($urn);
                if (!is_null($nextURN)) {
                    $viewVars['nextPermalink'] = $this->util->get_permalink($nextURN, "english");
                    $viewVars['nextHadithNumber'] = $this->util->getVerifiedHadithNumber($nextURN, $language = "english");
                }
                if (!is_null($previousURN)) {
                    $viewVars['previousPermalink'] = $this->util->get_permalink($previousURN, "english");
                    $viewVars['previousHadithNumber'] = $this->util->getVerifiedHadithNumber($previousURN, $language = "english");
                }
            }
        }

		if (count($pairs) > 0 && isset($this->_entries[0][$pairs[0][0]])) {
            $this->view->params['_ogDesc'] = substr(strip_tags($this->_entries[0][$pairs[0][0]]->hadithText), 0, 300);
        }

		if (strcmp($_escaped_fragment_, "default") !== 0) {
			//if ($this->_book->indonesianBookID > 0) $this->_otherlangs['indonesian'] = $this->_book->fetchLangHadith("indonesian");
            if ($this->_book->urduBookID > 0) {
                $this->_otherlangs['urdu'] = $this->_book->fetchLangHadith("urdu");
                $viewVars['otherlangs'] = $this->_otherlangs;
            }
            
            if (!is_null($this->_otherlangs) && count($this->_otherlangs) > 0) {
                $viewVars['ajaxCrawler'] = true;
            }
		}

        if (!isset($this->_entries) || count($this->_entries) === 0) {
			// Special case for 0-hadith Hisn al-Muslim introduction book which is valid
			if (strcmp($collectionName, "hisn") !== 0) {
			    $errorMsg = "Book $ourBookID is unavailable or does not exist. Click <a href=\"/\">here</a> to go to the home page.";
        	    throw new NotFoundHttpException($errorMsg);
			}
        }

		if ($this->_book->status > 3) {
			$this->_chapters = array();
			$retval = $this->util->getChapterDataForBook($collectionName, $ourBookID);
            foreach ($retval as $chapter) $this->_chapters[$chapter->babID] = $chapter;
            $viewVars['chapters'] = $this->_chapters;
		}

        if ((strlen($this->_book->englishBookName) > 0) and (strcmp($this->_collection->hasbooks, "yes") === 0)) {
			if ((int)$ourBookID === -1) $lastlink = "introduction";
			elseif ((int)$ourBookID === -35) $lastlink = "35b";
			elseif ((int)$ourBookID === -8) $lastlink = "8b";
			else $lastlink = $ourBookID;
			$bookTitlePrefix = "";
			if (strcmp(substr($this->_book->englishBookName, 0, 4), "Book") !== 0 && strcmp(substr($this->_book->englishBookName, 0, 7), "Chapter") !== 0 && strcmp(substr($this->_book->englishBookName, 0, 4), "The ") !== 0)
				$bookTitlePrefix = "Book of ";
            $this->pathCrumbs($this->_book->englishBookName, "/".$collectionName."/".$lastlink);
        }
		elseif ($ourBookID === -1) {
			// The case where the collection doesn't technically have books but there is an introduction pseudobook
			$lastlink = "introduction";
			$this->pathCrumbs($this->_book->englishBookName, "/".$collectionName."/".$lastlink);
		}
        $this->pathCrumbs($this->_collection->englishTitle, "/$collectionName");

		// TODO: Expand to all verified collections at the end of the experiment
		if ($this->_book->status > 3 && $collectionName == "riyadussalihin") {
			$urn = $this->_entries[1][$pairs[0][1]]->arabicURN;
			$permalinkCanonical = $this->util->getPermalinkByURN($urn);
			$viewVars['permalinkCanonical'] = $permalinkCanonical;

			if (isset($nextURN) && !is_null($nextURN))
				$viewVars['nextPermalink'] = $this->util->getPermalinkByURN($nextURN, "english");
			
			if (isset($previousURN) && !is_null($previousURN))
				$viewVars['previousPermalink'] = $this->util->getPermalinkByURN($previousURN, "english");

			// Add canonical links to single pages only
			if ( $permalinkCanonical && $this->view->params['_pageType'] == "hadith" && count($pairs) === 1 )
				$this->view->registerLinkTag(['rel' => 'canonical', 'href' => "https://sunnah.com" . ($permalinkCanonical)]);
		}
		
		return $this->render('dispbook', $viewVars);

	}

	public function actionTce() {
		$aURNs = array(100010, 100020, 100030, 100040, 100050, 100060, 100070, 100080, 100610, 109660, 109670, 109720, 109740, 129070, 129100, 171070, 171150, 132790, 132800, 133900, 138910, 138920, 138930, 138940, 138950, 138960, 183040, 183050, 183060, 143020, 144840, 144850, 151341, 174620, 174640, 174660, 174700, 174710, 156010, 160700, 160770, 161260, 163480, 163810, 164280, 176060, 177450);
		$this->_viewVars->pageTitle = "The Collector's Edition";
        $this->pathCrumbs($this->_viewVars->pageTitle, "");
		$this->customSelect($aURNs, true, true);
	}

	public function actionSocialmedia() {
		$aURNs = array(158030, 
			155850, 
			724820, 
			100130, 
			368971, 
			948360, 
			721230, 
			725620, 
			153320,
			173800,
			367980,
			721100,
			721130,
			/* Hadith Musnad Ahmad */
			302050,
			/* 1343270 unverified */
			174310,
			720550,
			153400,
			149460,
			155870,
			367820,
			2304230,
			303030,
			/* 1342400 unverified */
			949930,
			162970,
			160180,
			161590,
			/* 735080 unverified */
			153940,
			728370,
			948030,
			1341710,
			/* 1333750 unverified */
			123240,
			144010,
			155191,
			725881,
			/* 726910 unverified */

			350410,
			172440,
			/* 1302380 unverified */

			/* Hadith Musnad Ahmad */
			380090
 		);
		$this->_viewVars->pageTitle = "40 Hadith on Social Media";
        $this->_viewVars->showChapters = false;
		$this->pathCrumbs($this->_viewVars->pageTitle, "");
		$this->customSelect($aURNs, false, false);
	}

	public function actionSelection($selection = "ramadan") {
		if (strcmp($selection, "ramadan") == 0) {
			$this->view->params['pageTitle'] = "Ramadan Selection";
			$aURNs = $this->util->getRamadanURNs();
		}
        elseif (strcmp($selection, "dhulhijjah") == 0) {
			$this->view->params['pageTitle'] = "Dhul Hijjah Selection";
			$aURNs = $this->util->getDhulhijjahURNs();
		}
        elseif (strcmp($selection, "ashura") == 0) {
			$this->view->params['pageTitle'] = "Muharram/`Ashura Selection";
			$aURNs = $this->util->getMuharramURNs();
		}
        else $this->view->params['pageTitle'] = "Unspecified Selection";
        $this->pathCrumbs($this->view->params['pageTitle'], "");
		return $this->customSelect($aURNs, false, false);
	}

    public function actionSelectionData($selection = "ramadan") {
        $this->layout = false;
        if (strcmp($selection, "ramadan") == 0) $arabicURNs = $this->util->getRamadanURNs();
        elseif (strcmp($selection, "dhulhijjah") == 0) $arabicURNs = $this->util->getDhulhijjahURNs();
        elseif (strcmp($selection, "ashura") == 0) $arabicURNs = $this->util->getMuharramURNs();
        else return "";
        return $this->util->getCarouselHTML($arabicURNs);
    }

    public function customSelect($aURNs, $showBookNames, $showChapterNumbers) {
		$retval = $this->util->customSelect($aURNs);
		$this->_collections = $retval[0];
		$this->_books = $retval[1];
		$this->_chapters = $retval[2];
		$this->_entries = $retval[3];

        $viewVars = [
            'collections' => $this->_collections,
            'englishEntries' => $this->_entries[0],
            'arabicEntries' => $this->_entries[1],
            'pairs' => $this->_entries[2],
            'chapters' => $this->_chapters,
            'showBookNames' => $showBookNames,
            'showChapterNumbers' => $showChapterNumbers,
        ];

        $this->view->params['_pageType'] = "book";

        return $this->render('tce', $viewVars);
	}
	
	public function actionHadithByNumber($collectionName, $hadithNumber) {
		$num = ltrim($hadithNumber, "0");
		if ($num !== $hadithNumber) {
			return $this->redirect("/$collectionName:$num", 301);
		}
		$arabicURN = $this->util->getURNByNumber($collectionName, $hadithNumber);
		return Yii::$app->runAction('front/collection/urn', ['urn' => $arabicURN]);
	}

	public function actionUrn($urn) {
        $englishHadith = NULL; $arabicHadith = NULL;
        $viewVars = array();

        if (is_null($urn) || !is_numeric($urn)) {
            $errorMsg = "The resource you are looking for is not available yet or invalid. Click <a href=\"/\">here</a> to go to the home page.";
            throw new NotFoundHttpException($errorMsg);
        }
        
        $lang = "english";
        $englishHadith = $this->util->getHadith($urn, "english");
        if (is_null($englishHadith) || $englishHadith === false) {
            $lang = "arabic";
            $arabicHadith = $this->util->getHadith($urn, $lang);
            if ($arabicHadith) $englishHadith = $this->util->getHadith($arabicHadith->matchingEnglishURN, "english");
        }
        else $arabicHadith = $this->util->getHadith($englishHadith->matchingArabicURN, "arabic");

	    if (is_null($englishHadith) && is_null($arabicHadith)) {
            $errorMsg = "The hadith you are looking for is unavailable or not found. Click <a href=\"/\">here</a> to go to the home page.";
            throw new NotFoundHttpException($errorMsg);
		}

        $viewVars = [
            'englishEntries' => array(0 => NULL),
            'arabicEntries' => array(0 => NULL),
            'pairs' => array(array(0,0)),
            'expectedHadithCount' => 1,
        ];


        if (strcmp($lang, "english") === 0) {
            $this->_collectionName = $englishHadith->collection;
            $this->_book = $this->util->getBookByLanguageID($this->_collectionName, $englishHadith->bookID, "english");
            $this->view->params['book'] = $this->_book;
            $viewVars['collectionName'] = $this->_collectionName;
            $viewVars['book'] = $this->_book;
            $viewVars['ourBookID'] = $this->_book->ourBookID;
        }
        else if (!(is_null($arabicHadith))) {
            $this->_collectionName = $arabicHadith->collection;
        	$this->_book = $this->util->getBookByLanguageID($this->_collectionName, $arabicHadith->bookID, "arabic");
            $this->view->params['book'] = $this->_book;
            $viewVars['collectionName'] = $this->_collectionName;
            $viewVars['book'] = $this->_book;
            $viewVars['ourBookID'] = $this->_book->ourBookID;
        }

        if (!is_null($arabicHadith)) {
            $viewVars['arabicEntries'] = array($arabicHadith->arabicURN => $arabicHadith);
            $viewVars['pairs'][0][1] = $arabicHadith->arabicURN;
        }
        if (!is_null($englishHadith)) {
            $viewVars['englishEntries'] = array($englishHadith->englishURN => $englishHadith);
            $viewVars['pairs'][0][0] = $englishHadith->englishURN;
        }

        $this->_collection = $this->util->getCollection($this->_collectionName);
        $this->view->params['collection'] = $this->_collection;
        $viewVars['collection'] = $this->_collection;
        
		if (array_key_exists('book', $viewVars) && !is_null($viewVars['book']) && $this->_book->status >= 3) {
            $this->_chapters = array();
            $retval = $this->util->getChapterDataForBook($this->_collectionName, $this->_book->ourBookID);
            foreach ($retval as $chapter) $this->_chapters[$chapter->babID] = $chapter;
            $viewVars['chapters'] = $this->_chapters;

            if ($this->_book->status > 3) {
                $nextURN = $this->util->getNextURNInCollection($englishHadith->englishURN);
        	    $previousURN = $this->util->getPreviousURNInCollection($englishHadith->englishURN);
            	if (!is_null($nextURN)) {
        	    	$viewVars['nextPermalink'] = $this->util->get_permalink($nextURN, "english");
	                $viewVars['nextHadithNumber'] = $this->util->getVerifiedHadithNumber($nextURN, $language = "english");
        	    }
            	if (!is_null($previousURN)) {
                	$viewVars['previousPermalink'] = $this->util->get_permalink($previousURN, "english");
	                $viewVars['previousHadithNumber'] = $this->util->getVerifiedHadithNumber($previousURN, $language = "english");
    	        }
		    }
        }

        $this->view->params['_pageType'] = "hadith";
		$this->view->params['lastUpdated'] = null;
        $this->pathCrumbs('Hadith', "");
        if (strlen($this->_book->englishBookName) > 0) {
			$bookPathPart = $this->_book->ourBookID;
			if ($this->_book->ourBookID === -1) $bookPathPart = "introduction";
			elseif (($this->_book->ourBookID === -35)) $bookPathPart = "35b";
			elseif (($this->_book->ourBookID === -8)) $bookPathPart = "8b";

            $this->pathCrumbs($this->_book->englishBookName." - <span class=arabic_text>".$this->_book->arabicBookName.'</span>', "/".$this->_collectionName."/".$bookPathPart);
        }
		$this->pathCrumbs($this->_collection->englishTitle, "/$this->_collectionName");
		
		// TODO: Expand to all verified collections at the end of the experiment
		if ($this->_book->status > 3 && $this->_collectionName == "riyadussalihin") {
			$urn = $arabicHadith->arabicURN;
			$permalinkCanonical = $this->util->getPermalinkByURN($urn);
			$viewVars['permalinkCanonical'] = $permalinkCanonical;

			if (isset($nextURN) && !is_null($nextURN))
				$viewVars['nextPermalink'] = $this->util->getPermalinkByURN($nextURN, "english");

			if (isset($previousURN) && !is_null($previousURN))
				$viewVars['previousPermalink'] = $this->util->getPermalinkByURN($previousURN, "english");

			if ( $permalinkCanonical )
				$this->view->registerLinkTag(['rel' => 'canonical', 'href' => "https://sunnah.com" . ($permalinkCanonical)]);
		}

        return $this->render('dispbook', $viewVars);
	}
}
