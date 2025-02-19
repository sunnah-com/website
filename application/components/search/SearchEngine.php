<?php

namespace app\components\search;

use Yii;

abstract class SearchEngine
{
    /** @var string Search engine name/identifier */
    protected $id;

    /** @var string */
    protected $query;

    /** @var int */
    protected $limit = 10;

    /** @var int */
    protected $page = 0;

    /** @var array[] */
    protected $collections;

    public function setLimitPage($limit, $page)
    {
        $this->limit = intval($limit);
        $this->page = intval($page);
    }

    public function setCollections($collections)
    {
        $this->collections = $collections;
    }

    /**
     *
     * @param string $query Search query text
     * @return SearchResultset|null
     */
    public function doSearch($query)
    {
        $this->query = $query;

        $resultset = $this->doSearchInternal();
        if ($resultset === null) {
            $this->doNotifyOutage();
        }
        return $resultset;
    }

    abstract protected function doSearchInternal();

    protected function doNotifyOutage()
    {
        $headers = 'From: webmaster@sunnah.com';
        mail(
            'sunnahhadith@gmail.com',
            "Search Engine: {$this->id} may be down",
            "{$this->id} may be down. Query: {$this->query}",
            $headers
        );
    }

    public function logQuery($numResults)
    {
        if (defined("YII_ENV") && YII_ENV !== "dev") {
            $searchdb = Yii::$app->searchdb;
            $searchdb->createCommand(
                'INSERT INTO `search_queries` (query, IP, numResults) VALUES (:query, :IP, :numResults)',
                [
                    ':query' => $this->query,
                    ':IP' => Yii::$app->getRequest()->getUserIP(),
                    ':numResults' => $numResults
                ]
            )->execute();
        }
    }
}
