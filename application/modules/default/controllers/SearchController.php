<?php

class SearchController extends Controller
{
    protected $_numFound;
    protected $_collections;
    protected $_spellcheck;
    protected $_searchQuery;
    protected $_highlighted;
    protected $_eurns;
    protected $_aurns;
    protected $_pairs;
    protected $_english_hadith;
    protected $_arabic_hadith;
    protected $_language;
    protected $_pageNumber;
    protected $_resultsPerPage;
    protected $_message;
    protected $_pages;

/*	Commenting out the caching while Karim makes advanced search */
/*
    public function filters() {
        return array(
            array(
                'COutputCache',
                'duration'=>Yii::app()->params['cacheTTL'],
                'varyByParam'=>array('id', 'query', 'page'),
            ),
        );
    }
*/

	public function actionAdvanced() {
        $collections = $this->util->getCollectionsInfo();
		/*  This returns an (ordered) array - look at the Collections table
			in hadithdb for field names */


        $this->render('advanced'); /* This line goes at the end*/
	}

	public function actionOldsearch($query, $page = 1) {
		$query = stripslashes($this->url_decode($query));
		$this->processSearch($query, $page);
	}
    
	public function actionSearch() {
		$page = 1;
		if (isset($_GET['q'])) {
			$query = $_GET['q'];
			if (isset($_GET['page'])) $page = $_GET['page'];
			$this->processSearch($query, $page);
		}
		else $this->render('/index/index');

	}

	public function processSearch($query, $page) {
		$this->_viewVars = new StdClass();
        $this->_searchQuery = $query; $this->_pageType = "search";
        $this->pathCrumbs('Search Results - '.htmlspecialchars($query).' (page '.$page.')', '');
        if (strlen($query) < 1) return NULL;
		$con = mysql_connect("localhost", "webread") or die(mysql_error());
        mysql_select_db("hadithdb") or die(mysql_error());
		
        $searchObject = new Search();
        $results_arr = $searchObject->searchEnglishHighlighted($query, $page);
        if (count($results_arr) == 0) {
            $this->_viewVars->errorMsg = "The search engine is currently down. The web administrators have been notified and will be working to get it back up as soon as possible, inshaAllah.";
            return;
        }
        $eurns = $results_arr[0];
        $aurns = $results_arr[1];
        $highlighted = $results_arr[2];
        $numFound = $results_arr[3];
        $spellcheck = $results_arr[4];
        $language = "english";
        $english = true;

		//Yii::log("query: $query, numFound: $numFound, aurns: ".print_r($aurns), 'info', 'system.web.CController');

		if ($eurns == NULL) {
            $results_arr = $searchObject->searchArabicHighlighted($query, $page);
            if (count($results_arr) == 0) {
                $this->_viewVars->errorMsg = "The search engine is currently down. The web administrators have been notified and will be working to get it back up as soon as possible, inshaAllah.";
                return;
            }
            $eurns = $results_arr[0];
            $aurns = $results_arr[1];
            $highlighted = $results_arr[2];
            $numFound = $results_arr[3];
            $language = "arabic";
            $english = false;
        }

        $searchObject->logQuery(addslashes($query), $numFound);
        mysql_select_db("hadithdb") or die(mysql_error());
        
        if (is_null($eurns) && is_null($aurns)) {
            // Zero search results
            $this->_numFound = 0;
            $this->_spellcheck = $spellcheck;
            $this->_viewVars->pageType = "search";
        	$this->render('index');
            return;
        }

        for ($i = 0; $i < count($eurns); $i++) $eurns[$i] = intval($eurns[$i]);
        $command = Yii::app()->db->createCommand();
        $command->select('*')
        		->from('EnglishHadithTable')
        		->where(array('in', 'englishURN', $eurns));
		$englishSet = $command->queryAll();
		$english_hadith = array();
        foreach ($englishSet as $row) 
        	$english_hadith[array_search($row['englishURN'], $eurns)] = $row;
		
        for ($i = 0; $i < count($aurns); $i++) $aurns[$i] = intval($aurns[$i]);
        $command = Yii::app()->db->createCommand();
        $command->select('*')
        		->from('ArabicHadithTable')
        		->where(array('in', 'arabicURN', $aurns));
		$arabicSet = $command->queryAll();
		$arabic_hadith = array();
        foreach ($arabicSet as $row) 
        	$arabic_hadith[array_search($row['arabicURN'], $aurns)] = $row;
        	
        // For the Arabic ahadith that have no English match, we need to populate
        // the englishBookName and englishBookID field for display purposes
        if (!$english && !is_null($eurns)) {
            $missing_keys = array_keys($eurns, 0);
            foreach ($missing_keys as $missing_key) {
                $collection = $arabic_hadith[$missing_key]['collection'];
                $arabicBookID = $arabic_hadith[$missing_key]['bookID'];
                $ebook = $this->util->getBookByLanguageID($collection, $arabicBookID, "arabic");
                if (!(is_null($ebook))) {
                    $english_hadith[$missing_key]['bookID'] = $ebook->englishBookID;
                    $english_hadith[$missing_key]['bookName'] = $ebook->englishBookName;
                }
            }
        }
		mysql_close($con);
		
        $this->_highlighted = $highlighted;
        $this->_eurns = $eurns;
        $this->_aurns = $aurns;
        $this->_pairs = $searchObject->php_zip($eurns, $aurns);
        $this->_english_hadith = $english_hadith;
        $this->_arabic_hadith = $arabic_hadith;
        $this->_numFound = $numFound;
        $this->_spellcheck = $spellcheck;
        $this->_language = $language;
        $this->_viewVars->pageType = "search";
        $this->_pageNumber = $page;
        $this->_resultsPerPage = Yii::app()->params['pageSize'];
        $this->_collections = $this->util->getCollectionsInfo("indexed");
		$this->_pages = new CPagination($numFound);
		$this->_pages->pageSize = Yii::app()->params['pageSize'];

        $this->render('/search/index');
	}

	public function url_decode($link) {
        /* This function decodes values found in URLs and replaces them with their 
        original character sequences */
        $retval = rawurldecode($link);
        $retval = preg_replace("/-dq-/", "\"", $retval);
        $retval = preg_replace("/-sq-/", "\'", $retval);
        $retval = preg_replace("/-st-/", "*", $retval);
        $retval = preg_replace("/-s-/", "/", $retval);
        $retval = preg_replace("/--m-/", " -", $retval);
        $retval = preg_replace("/-m-/", "-", $retval);
        $retval = preg_replace("/-p-/", "+", $retval); // except this one
        $retval = preg_replace("/([^-\ ])-([^-])/", "$1 $2", $retval); // must be last!!
        $retval = preg_replace("/([^-\ ])-([^-])/", "$1 $2", $retval); // repeating to handle overlapping matches
        return $retval;
    }
	
	
}
