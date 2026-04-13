<?php

namespace app\modules\front\controllers;

use app\controllers\SController;
use app\modules\front\models\Narrator;
use Yii;
use yii\web\NotFoundHttpException;

class NarratorController extends SController
{
    public function behaviors()
    {
        return [
            [
                'class'      => 'yii\filters\PageCache',
                'except'     => [],
                'duration'   => Yii::$app->params['cacheTTL'],
                'variations' => [Yii::$app->request->get('nid')],
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

    public function actionIndex($nid)
    {
        $narrator = Narrator::findByRawyId($nid);
        if ($narrator === null) {
            throw new NotFoundHttpException('Narrator not found.');
        }

        $this->view->params['_pageType'] = 'narrator';
        $this->pathCrumbs($narrator->shohra ?: $narrator->name, '/narrator/' . (int)$nid);

        $ogDesc = trim(
            ($narrator->shohra ?? '')
            . ($narrator->jarh_tadil ? ' — ' . $narrator->jarh_tadil : '')
        );
        if ($ogDesc !== '') {
            $this->view->params['_ogDesc'] = $ogDesc;
        }

        $summaryMap    = Narrator::getSummaryMap();
        $alimOpinions  = $narrator->getAlimOpinions();
        $tarjamaBlocks = $narrator->getTarjamaBlocks();
        $teacherRows   = $this->resolveRows($narrator->getTeacherIds(), $summaryMap);
        $studentRows   = $this->resolveRows($narrator->getStudentIds(), $summaryMap);

        return $this->render('index', [
            'narrator'      => $narrator,
            'alimOpinions'  => $alimOpinions,
            'teacherRows'   => $teacherRows,
            'studentRows'   => $studentRows,
            'tarjamaBlocks' => $tarjamaBlocks,
        ]);
    }

    /**
     * Resolves an array of rawy_ids against the summary map, returning only
     * rows found in the map. Orphan ids (not in the map) are silently skipped.
     *
     * @param  int[]  $ids
     * @param  array  $summaryMap  rawy_id => shohra
     * @return array  [['rawy_id' => int, 'shohra' => string], ...]
     */
    private function resolveRows(array $ids, array $summaryMap)
    {
        $rows = [];
        foreach ($ids as $id) {
            if (isset($summaryMap[$id])) {
                $rows[] = ['rawy_id' => $id, 'shohra' => $summaryMap[$id]];
            }
        }
        return $rows;
    }
}
