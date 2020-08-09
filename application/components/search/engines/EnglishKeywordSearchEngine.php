<?php

namespace app\components\search\engines;

class EnglishKeywordSearchEngine extends KeywordSearchEngine
{
    protected $id = 'SolrEnglish';

    protected function doSearchInternal()
    {
        return $this->doLangEngineQuery();
    }

    protected function doQuery()
    {
        //$fullquery = "hadithText:".rawurlencode(self::replace_special_chars(stripslashes($query)));
        $fullquery = $this->fieldName . ':' .rawurlencode(stripslashes($this->query));
        $resultscode = $this->solr->sendRequest('/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->limit.'&start='.$this->getStartOffset().'&hl=true&hl.fl='.$this->fieldName.'&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&spellcheck=true&spellcheck.collate=true&spellcheck.count=10&spellcheck.maxCollations=10&spellcheck.maxCollationEvaluations=10&defType=edismax&mm=3%3C-1%205%3C-2');

        if ($resultscode === false) {
            return null;
        }

        return $resultscode;
    }

    protected function hasSuggestionsSupport()
    {
        return true;
    }
}
