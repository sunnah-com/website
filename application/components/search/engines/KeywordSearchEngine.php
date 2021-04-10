<?php

namespace app\components\search\engines;

use app\components\search\SearchEngine;
use app\components\search\SearchResultset;
use Yii;

class KeywordSearchEngine extends SearchEngine
{
    protected $solr;

    protected $id = 'Solr';
    protected $lang = 'en';
    protected $fieldName = 'hadithText';

    public function __construct()
    {
        $this->solr = Yii::$app->solr;
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
        $enSuggestions = $resultset->getSuggestions();

        if ($resultset->getCount() === 0) {
            // If no English results were found, do Arabic search
            $engine = new ArabicKeywordSearchEngine();
            $engine->setLimitPage($this->limit, $this->page);
            $resultset = $engine->doSearch($this->query);
        }

        if ($resultset !== null) {
            // Only English engine supports suggestions
            $resultset->setSuggestions($enSuggestions);

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
        eval("\$resultsarray = ".$resultscode.";");

        $response = $resultsarray['response'];
        $docs = $resultsarray['response']['docs'];
        $highlightings = $resultsarray['highlighting'];

        $resultset = new SearchResultset($response['numFound']);

        if ($this->hasSuggestionsSupport()) {
            $suggestions = $resultsarray['spellcheck']['suggestions'] ?? null;
            if ($suggestions && isset($suggestions['collation'])) {
                $spellcheck = substr(strstr($suggestions['collation'], ':'), 1);
                $resultset->setSuggestions($spellcheck);
            }
        }

        foreach ($docs as $doc) {
            $urn = $doc['URN'];
            $highlightedText = null;
            if (isset($highlightings[$urn][$this->fieldName])) {
                $highlightedText = $highlightings[$urn][$this->fieldName][0];
            }
            $resultset->addResult($this->lang, intval($urn), $highlightedText);
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
        return false;
    }

    protected static function replace_special_chars($str)
    {
        return preg_replace('/([\!\(\)\{\}\[\]\^\'\~\*\?\:\\\\])/', '\\\\${1}', $str);
    }
}
