<?php

namespace app\components\search\engines;

use app\components\search\SearchEngine;
use app\components\search\SearchResultset;
use Yii;

class KeywordSearchEngine extends SearchEngine
{
    protected $elastic;

    protected $id = 'Elastic';
    protected $lang = 'en';
    protected $fieldName = 'hadithText';

    public function __construct()
    {
        $this->elastic = Yii::$app->elastic;
    }

    protected function getStartOffset()
    {
        return ($this->page-1) * $this->limit;
    }

    protected function doSearchInternal()
    {
        $engine = new EnglishKeywordSearchEngine();
        $engine->setLimitPage($this->limit, $this->page);
        $resultset = $engine->doSearch($this->query);

        if ($resultset === null) {
            return null;
        }
        $suggestions = $resultset->getSuggestions();

        if ($resultset->getCount() === 0) {
            // If no English results were found, do Arabic search
            $engine = new ArabicKeywordSearchEngine();
            $engine->setLimitPage($this->limit, $this->page);
            $resultset = $engine->doSearch($this->query);
        }

        if ($resultset !== null) {
            // Only English engine supports suggestions
            $resultset->setSuggestions($suggestions);

            // Log the query and result set size
            $this->logQuery($resultset->getCount());
        }

        return $resultset;
    }

    protected function doLangEngineQuery()
    {
        $resultscode = $this->doQuery();
        if ($resultscode === null) {
            return null;
        }

        // FIXME: Avoid use of eval
        $resultsarray = json_decode($resultscode);
        $hits = $resultsarray->hits;
        $docs = $hits->hits;
        $resultset = new SearchResultset($hits->total->value);

        if ($this->hasSuggestionsSupport()) {
            $suggestions = $resultsarray->suggest->query[0]->options ?? null;
            if ($suggestions && count($suggestions) > 0) {
                $resultset->setSuggestions($suggestions[0]->text);
            }
        }

        foreach ($docs as $doc) {
            $urn = $doc->_source->englishURN;
            $resultset->addResult($this->lang, intval($urn), $doc->highlight);
        }

        return $resultset;
    }

    protected function doQuery()
    {
        return false;
    }

    protected function hasSuggestionsSupport()
    {
        // whether "did you mean" spellcheck suggestions are supported
        return true;
    }

    protected static function replace_special_chars($str)
    {
        return preg_replace('/([\!\(\)\{\}\[\]\^\'\~\*\?\:\\\\])/', '\\\\${1}', $str);
    }
}
