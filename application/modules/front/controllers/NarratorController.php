<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use app\modules\front\models\ContactForm;
use Yii;

class NarratorController extends SController
{
	/* This function performs page caching  */
    public function behaviors() {
        return [
            [
                   'class' => 'yii\filters\PageCache',
                   'except' => [],
                   'duration' => Yii::$app->params['cacheTTL'],
                   'variations' => [ Yii::$app->request->get('id') ],
        
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($nid) {
        $this->view->params['_pageType'] = "narrator";
		return $this->render('index');
	}
}
