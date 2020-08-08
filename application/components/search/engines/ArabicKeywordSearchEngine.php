<?php

namespace app\components\search\engines;

class ArabicKeywordSearchEngine extends KeywordSearchEngine
{
    protected $id = 'SolrArabic';
    protected $lang = 'ar';
    protected $fieldName = 'arabichadithText';

    protected function doQuery()
    {
        $fullquery = rawurlencode(self::replace_special_chars(stripslashes(trim($this->query))));
        $resultscode = $this->solr->sendRequest('/solr/select/?q='.$fullquery.'&wt=php&rows='.$this->limit.'&start='.$this->getStartOffset().'&hl=true&hl.fl='.$this->fieldName.'&hl.snippets=5&hl.fragsize=2500&hl.mergeContiguous=true&defType=edismax&mm=3%3C-1%205%3C-2&qf='.$this->fieldName);

        if ($resultscode === false) {
            return null;
        }

        return $resultscode;
    }
}
