<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use app\modules\front\models\ArabicHadith;
use app\modules\front\models\Book;
use app\modules\front\models\EnglishHadith;
use app\modules\front\models\Search;
use yii\db\Query;
use yii\data\Pagination;
use yii\helpers;
use yii\widgets\LinkPager;
use Yii;

class SearchController extends SController
{
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

    public function actionOldsearch($query, $page = 1)
    {
        $query = stripslashes($this->url_decode($query));
        $this->processSearch($query, $page);
    }

    public function actionSearch()
    {
        $query = Yii::$app->request->get('q');
        $query = trim($query);
        if ($query === '') {
            return Yii::$app->runAction('front/index/index');
        }

        $this->view->params['_searchQuery'] = $query;
        $this->view->params['_pageType'] = 'search';

        $page = Yii::$app->request->get('page', 1);
        $page = intval($page);
        return $this->processSearch($query, $page);
    }

    public function processSearch($query, $page)
    {
        $this->pathCrumbs('Search Results - '.helpers\Html::encode($query).' (page '.$page.')', '');

        $searchObject = new Search();
        $results_arr = $searchObject->searchEnglishHighlighted($query, $page);
        if (count($results_arr) == 0) {
            return $this->searchEngineDown();
        }

        $language = 'english';
        [$eurns, $aurns, $highlighted, $numFound, $spellcheck] = $results_arr;

        if ($eurns === null) {
            // If no English results were found, do Arabic search
            $results_arr = $searchObject->searchArabicHighlighted($query, $page);
            if (count($results_arr) == 0) {
                return $this->searchEngineDown();
            }

            $language = 'arabic';
            [$eurns, $aurns, $highlighted, $numFound, $spellcheck] = $results_arr;
        }

        $searchObject->logQuery(addslashes($query), $numFound);

        if (is_null($eurns) && is_null($aurns)) {
            // Zero search results
            return $this->render(
                'index',
                array('numFound' => 0, 'spellcheck' => $spellcheck)
            );
        }

        $eurns = array_map('intval', $eurns);
        $query = new Query();
        $query = $query
            ->select('*')
            ->from('EnglishHadithTable')
            ->where(array('in', 'englishURN', $eurns));
        $englishSet = $query->all();
        $englishHadiths = array();
        foreach ($englishSet as $row) {
            $englishHadiths[$row['englishURN']] = $row;
        }

        $aurns = array_map('intval', $aurns);
        $query = new Query();
        $query = $query
            ->select('*')
            ->from('ArabicHadithTable')
            ->where(array('in', 'arabicURN', $aurns));
        $arabicSet = $query->all();
        $arabicHadiths = array();
        foreach ($arabicSet as $row) {
            $arabicHadiths[$row['arabicURN']] = $row;
        }

        $pairs = array_map(null, $eurns, $aurns);
        $searchResults = array();
        foreach ($pairs as $index => $pair) {
            [$eurn, $aurn] = $pair;
            $enDetails = $englishHadiths[$eurn] ?? null;
            $arDetails = $arabicHadiths[$aurn] ?? null;
            if ($language === 'english') {
                if ($enDetails === null) {
                    continue;
                }
                $book = Book::find()->where(
                    'englishBookID = :ebid AND collection = :collection',
                    array(':ebid' => $enDetails['bookID'], ':collection' => $enDetails['collection'])
                )->one();

                $enDetails['highlighted'] = $highlighted[$eurn]['hadithText'][0];

            } elseif ($language === 'arabic') {
                if ($arDetails === null) {
                    continue;
                }
                $book = Book::find()->where(
                    'arabicBookID = :abid AND collection = :collection',
                    array(':abid' => $arDetails['bookID'], ':collection' => $arDetails['collection'])
                )->one();

                $arDetails['highlighted'] = $highlighted[$aurn]['arabichadithText'][0];
            }

            $searchResults[] = array(
                'en' => $enDetails,
                'ar' => $arDetails,
                'book' => $book
            );
        }

        $viewVars = array();
        $viewVars['searchResults'] = $searchResults;
        $viewVars['numFound'] = $numFound;
        $viewVars['spellcheck'] = $spellcheck;
        $viewVars['language'] = $language;
        $viewVars['pageNumber'] = $page;
        $viewVars['resultsPerPage'] = Yii::$app->params['pageSize'];
        $viewVars['collectionsInfo'] = $this->util->getCollectionsInfo('indexed');

        $this->_pages = new Pagination([
            'totalCount' => $numFound,
            'pageSize' => Yii::$app->params['pageSize'],
            'defaultPageSize' => Yii::$app->params['pageSize'],
        ]);
        $viewVars['pages'] = $this->_pages;

        return $this->render('index', $viewVars);
    }

    protected function searchEngineDown()
    {
        $errorMsg = 'The search engine is currently down. The web administrators have been notified and will be working to get it back up as soon as possible, inshaAllah.';
        return $this->render('index', ['errorMsg' => $errorMsg]);
    }

    public function url_decode($link)
    {
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
