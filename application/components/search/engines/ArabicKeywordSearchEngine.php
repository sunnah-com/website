<?php

namespace app\components\search\engines;

class ArabicKeywordSearchEngine extends KeywordSearchEngine
{
    protected $id = 'ElasticArabic';
    protected $lang = 'ar';
    protected $fieldName = 'arabicText';

    protected function doSearchInternal()
    {
        return $this->doLangEngineQuery();
    }

    protected function doQuery()
    {
        $fullquery = rawurlencode(stripslashes($this->query));
        $url = '/english/search?q='.$fullquery.'&size='.$this->limit.'&from='.$this->getStartOffset();
        
        if (!empty($this->collections)) {
            foreach ($this->collections as $collection) {
                $url .= '&collection='.rawurlencode($collection);
            }
        }
        
        $resultscode = $this->elastic->sendRequest($url);

        if ($resultscode === false) {
            return null;
        }

        return $resultscode;
    }
}
