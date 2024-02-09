<?php

namespace app\components\search\engines;

class ArabicKeywordSearchEngine extends KeywordSearchEngine
{
    protected $id = 'ElasticArabic';
    protected $lang = 'ar';
    protected $fieldName = 'arabichadithText';

    protected function doSearchInternal()
    {
        return $this->doLangEngineQuery();
    }

    protected function doQuery()
    {
        $fullquery = rawurlencode(self::replace_special_chars(stripslashes(trim($this->query))));
        $resultscode = $this->elastic->sendRequest('/arabic/search?q='.$fullquery.'&size='.$this->limit.'&from='.$this->getStartOffset());

        if ($resultscode === false) {
            return null;
        }

        return $resultscode;
    }
}
