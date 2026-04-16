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
        $narrator = Narrator::findByNarratorId($nid);
        if ($narrator === null) {
            throw new NotFoundHttpException('Narrator not found.');
        }

        $this->view->params['_pageType'] = 'narrator';
        $arabicName = $narrator->byname ?: $narrator->name;
        $enName     = Narrator::transliterateArabicName($arabicName);
        $this->pathCrumbs($enName . ' — ' . $arabicName, '/narrator/' . (int)$nid);

        $ogDesc = trim(
            ($narrator->byname ?? '')
            . ($narrator->reliability_label ? ' — ' . $narrator->reliability_label : '')
        );
        if ($ogDesc !== '') {
            $this->view->params['_ogDesc'] = $ogDesc;
        }

        $summaryMap     = Narrator::getSummaryMap();
        $criticOpinions = $narrator->getCriticOpinions();
        $tarjamaBlocks  = $narrator->getTarjamaBlocks();
        $teacherRows    = $this->resolveRows($narrator->getTeacherIds(), $summaryMap);
        $studentRows    = $this->resolveRows($narrator->getStudentIds(), $summaryMap);

        return $this->render('index', [
            'narrator'       => $narrator,
            'criticOpinions' => $criticOpinions,
            'teacherRows'    => $teacherRows,
            'studentRows'    => $studentRows,
            'tarjamaBlocks'  => $tarjamaBlocks,
        ]);
    }

    /**
     * Resolves an array of narrator_ids against the summary map, returning only
     * rows found in the map. Orphan ids (not in the map) are silently skipped.
     *
     * @param  int[]  $ids
     * @param  array  $summaryMap  narrator_id => byname
     * @return array  [['narrator_id' => int, 'byname' => string], ...]
     */
    private function resolveRows(array $ids, array $summaryMap)
    {
        $rows = [];
        foreach ($ids as $id) {
            if (isset($summaryMap[$id])) {
                $rows[] = ['narrator_id' => $id, 'byname' => $summaryMap[$id]];
            }
        }
        return $rows;
    }
}
