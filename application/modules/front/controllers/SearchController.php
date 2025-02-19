<?php

namespace app\modules\front\controllers;

use app\components\search\SearchResultset;
use app\components\search\engines\KeywordSearchEngine;
use app\controllers\SController;
use yii\data\Pagination;
use yii\helpers;
use Yii;

class SearchController extends SController
{
    public function actionOldsearch($query, $page = 1)
    {
        $query = stripslashes($this->url_decode($query));
        return $this->redirect(['/search', 'q' => $query], 301);
    }

    public function actionSearch()
    {
        $query = Yii::$app->request->get('q');
        $collections = Yii::$app->request->get('collection');
        $query = trim($query);
        if ($query === '') {
            return $this->goHome();
        }

        $this->view->params['_searchQuery'] = $query;
        $this->view->params['_pageType'] = 'search';

        $page = Yii::$app->request->get('page', 1);
        $page = intval($page);
        return $this->processSearch($query, $page, $collections);
    }

    public function processSearch($query, $page, $collections)
    {
        $this->pathCrumbs('Search Results', '');

        $limit = Yii::$app->params['pageSize'];

        $searchEngine = new KeywordSearchEngine();
        $searchEngine->setLimitPage($limit, $page);
        $searchEngine->setCollections($collections);
		set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context)
							{ throw new \ErrorException($err_msg, 0, $err_severity, $err_file, $err_line); }, E_WARNING);
		try {
        	$resultset = $searchEngine->doSearch($query);
		} catch (\ErrorException $e) {
			$errorMsg = "Your search query cannot be performed. It may contain improper characters, be too long, or be malformed in another way.";
			return $this->render('index', ['errorMsg' => $errorMsg]);
		}
		restore_error_handler();

        if ($resultset === null) {
            return $this->searchEngineDown();
        }

        $suggestions = $resultset->getSuggestions();

        if ($resultset->getCount() === 0) {
            // No results found
            return $this->render(
                'index',
                array('resultset' => $resultset, 'spellcheck' => $suggestions, 'searchQuery' => $query)
            );
        }

        $pagination = new Pagination([
            'totalCount' => $resultset->getCount(),
            'pageSize' => $limit,
            'defaultPageSize' => $limit,
        ]);

        $viewVars = array(
            'resultset' => $resultset,
            'spellcheck' => $suggestions,
            'searchQuery' => $query,
            'pageNumber' => $page,
            'resultsPerPage' => $limit,
            'pagination' => $pagination,
        );

        $this->pathCrumbs('Search Results - '.helpers\Html::encode($query).' (page '.$page.')', '');
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
