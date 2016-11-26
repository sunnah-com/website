<?php

class IndexController extends Controller
{
	protected $_collections;
	protected $_hadithCount;

	/* This function performs page caching  */
    public function filters() {
        return array(
            array(
                'COutputCache -flushcache', // Don't cache the flush cache page!!!
                'duration' => Yii::app()->params['cacheTTL'],
                'varyByParam' => array('id'),
            ),
        );
    }

	public function actionError() {

	}

	public function actionIndex()
	{
		$this->layout = "/layouts/home";
        $this->_collections = $this->util->getCollectionsInfo();
        $this->_hadithCount = $this->util->getHadithCount();
		$this->_pageType = "home";
		$this->render('index');
	}

	public function actionMaint() {
		$this->layout = "/layouts/home";
		$this->render('maint');
	}

	public function actionAbout() {
        $this->pathCrumbs('About', "/about");
        $this->_pageType = "about";
		$this->render('about');
    }

    public function actionChangeLog() {
        $this->pathCrumbs('Change Log', "/changelog");
        $this->_pageType = "about";
		$this->render('changelog');
    }

    public function actionNews() {
        $this->pathCrumbs('News', "/news");
        $this->_pageType = "about";
		$this->render('news');
    }

    public function actionSearchTips() {
        $this->pathCrumbs('Search Tips', "/searchtips");
        $this->_pageType = "searchtips";
        $this->render('searchtips');
    }


    public function actionSupport() {
        $this->pathCrumbs('Support Us', "/support");
        $this->_pageType = "about";
		$this->render('support');
	}

	public function actionFlushCache($key = NULL) {
		if (is_null($key)) $success = Yii::app()->cache->flush();
		else {
			$key = rawurldecode($key);
			$success = Yii::app()->cache->delete($key);
			//Yii::log("Attempting to delete key $key", 'info', 'system.web.CController');
			//$success = $key;
		}
		$this->_viewVars->success = $success;
		$this->renderPartial('flushcache');
	}
}
