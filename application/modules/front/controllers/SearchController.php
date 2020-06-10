<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use app\modules\front\models\Search;
use yii\db\Query;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use Yii;

class SearchController extends SController
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
                'duration'=>Yii::$app->params['cacheTTL'],
                'varyByParam'=>array('id', 'query', 'page'),
            ),
        );
    }
*/

    public function actionOldsearch($query, $page = 1) {
        $query = stripslashes($this->url_decode($query));
        $this->processSearch($query, $page);
    }

	public function actionSearch() {
		$page = 1;
		if (isset($_GET['q'])) {
			$query = $_GET['q'];
			if (isset($_GET['page'])) $page = $_GET['page'];
			return $this->processSearch($query, $page);
		}
		else return $this->render('/index/index');

	}

	public function processSearch($query, $page) {
		$this->_viewVars = new \StdClass();
        $this->view->params['_searchQuery'] = $query; 
        $this->view->params['_pageType'] = "search";
        $this->pathCrumbs('Search Results - '.htmlspecialchars($query).' (page '.$page.')', '');
        if (strlen($query) < 1) return NULL;
		$con = mysqli_connect("localhost", "webread") or die(mysqli_error($con));
        mysqli_select_db($con, "hadithdb") or die(mysqli_error($con));
		
        $searchObject = new Search($con);
        $results_arr = $searchObject->searchEnglishHighlighted($query, $page);
        if (count($results_arr) == 0) {
            $errorMsg = "The search engine is currently down. The web administrators have been notified and will be working to get it back up as soon as possible, inshaAllah.";
            return $this->render('index', ['errorMsg' => $errorMsg]);
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
                $errorMsg = "The search engine is currently down. The web administrators have been notified and will be working to get it back up as soon as possible, inshaAllah.";
                return $this->render('index', ['errorMsg' => $errorMsg]);
            }
            $eurns = $results_arr[0];
            $aurns = $results_arr[1];
            $highlighted = $results_arr[2];
            $numFound = $results_arr[3];
            $language = "arabic";
            $english = false;
        }

        $searchObject->logQuery(addslashes($query), $numFound);
        mysqli_select_db($con, "hadithdb") or die(mysqli_error($con));
        
        if (is_null($eurns) && is_null($aurns)) {
            // Zero search results
            $this->_numFound = 0;
            $this->_spellcheck = $spellcheck;
            $this->_viewVars->pageType = "search";
			$this->view->params['_pageType'] = "search";
        	return $this->render('index', [
									 'numFound' => 0,
									 'spellcheck' => $spellcheck,
			]);
        }

        for ($i = 0; $i < count($eurns); $i++) $eurns[$i] = intval($eurns[$i]);
        $query = new Query();
        $query = $query->select('*')
        			   ->from('EnglishHadithTable')
        		       ->where(array('in', 'englishURN', $eurns));
		$englishSet = $query->all();
		$english_hadith = array();
        foreach ($englishSet as $row) 
        	$english_hadith[array_search($row['englishURN'], $eurns)] = $row;
		
        for ($i = 0; $i < count($aurns); $i++) $aurns[$i] = intval($aurns[$i]);
        $query = new Query();
        $query = $query->select('*')
        		->from('ArabicHadithTable')
        		->where(array('in', 'arabicURN', $aurns));
		$arabicSet = $query->all();
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
		mysqli_close($con);
		
		$viewVars = array();
        $viewVars['highlighted'] = $highlighted;
        $viewVars['eurns'] = $eurns;
        $viewVars['aurns'] = $aurns;
        $viewVars['pairs'] = $searchObject->php_zip($eurns, $aurns);
        $viewVars['english_hadith'] = $english_hadith;
        $viewVars['arabic_hadith'] = $arabic_hadith;
        $viewVars['numFound'] = $numFound;
        $viewVars['spellcheck'] = $spellcheck;
        $viewVars['language'] = $language;
        $viewVars['pageNumber'] = $page;
        $viewVars['resultsPerPage'] = Yii::$app->params['pageSize'];
        $viewVars['collections'] = $this->util->getCollectionsInfo("indexed");
		$this->_pages = new Pagination([
							   'totalCount' => $numFound,
							   'pageSize' => Yii::$app->params['pageSize'],
							   'defaultPageSize' => Yii::$app->params['pageSize'],
							]);
		$this->_pages->pageSize = Yii::$app->params['pageSize'];
		$viewVars['pages'] = $this->_pages;

        return $this->render('index', $viewVars);
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
