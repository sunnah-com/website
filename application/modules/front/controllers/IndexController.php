<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use Yii;

class IndexController extends SController
{
	protected $_collections;
	protected $_hadithCount;

	/* This function performs page caching  */
    public function behaviors() {
        return [
            [
                   'class' => 'yii\filters\PageCache',
                   'except' => ['flushcache', 'ajaxhadithcount'],
                   'duration' => Yii::$app->params['cacheTTL'],
                   'variations' => [ Yii::$app->request->get('id') ],
        
            ],
        ];
    }

	public function actionError() {
		$this->view->params['_pageType'] = "error";
		return $this->render('error');
	}

	public function actionAjaxhadithcount() {
		$postMessage = Yii::$app->request->post('msg');
		Yii::info($postMessage, 'hadithcount');
	}

	public function actionIndex()
	{
		$this->layout = "home";
        $this->_collections = $this->util->getCollectionsInfo();
        $this->_hadithCount = $this->util->getHadithCount();
        $this->view->params['_pageType'] = "home";

        if (array_key_exists("showCarousel", Yii::$app->params)) {
            $carousel = Yii::$app->params['showCarousel'];
            if (strcmp($carousel, "ramadan") == 0) {
                $carouselParams = ['title' => 'ramadan hadith selection',
                                   'link' => '/ramadan'];
            }
            if (strcmp($carousel, "dhulhijjah") == 0) {
                $carouselParams = ['title' => 'dhul hijjah hadith selection',
                                   'link' => '/dhulhijjah'];
            }

            $this->view->params['carouselParams'] = $carouselParams;
        }

		return $this->render('index', ['collections' => $this->_collections]);
	}

	public function actionMaint() {
		$this->layout = "home";
		return $this->render('maint');
	}

	public function actionAbout() {
        $this->pathCrumbs('About', "/about");
        $this->view->params['_pageType'] = "about";
		return $this->render('about');
    }

    public function actionChangeLog() {
        $this->pathCrumbs('Change Log', "/changelog");
        $this->view->params['_pageType'] = "about";
		return $this->render('changelog');
    }

    public function actionNews() {
        $this->pathCrumbs('News', "/news");
        $this->view->params['_pageType'] = "about";
		return $this->render('news');
    }

    public function actionSearchTips() {
        $this->pathCrumbs('Search Tips', "/searchtips");
        $this->view->params['_pageType'] = "searchtips";
        return $this->render('searchtips');
    }


    public function actionSupport() {
        $this->pathCrumbs('Support Us', "/support");
        $this->view->params['_pageType'] = "about";
		return $this->render('support');
	}

    public function actionDevelopers() {
        $this->pathCrumbs('Developers', "/developers");
        $this->view->params['_pageType'] = "about";
		return $this->render('developers');
	}

	public function actionFlushCache($key = NULL) {
		if (is_null($key)) $success = Yii::$app->cache->flush();
		else {
			$key = rawurldecode($key);
			$success = Yii::$app->cache->delete($key);
			//Yii::log("Attempting to delete key $key", 'info', 'system.web.CController');
			//$success = $key;
		}
		$this->view->params['success'] = $success;
		echo $this->renderPartial('flushcache');
	}
}
