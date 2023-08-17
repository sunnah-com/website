<?php

namespace app\components\search\engines;

class EnglishKeywordSearchEngine extends KeywordSearchEngine
{
    protected $id = 'ElasticEnglish';

    protected function doSearchInternal()
    {
        return $this->doLangEngineQuery();
    }

    protected function doQuery()
    {
        //$fullquery = "hadithText:".rawurlencode(self::replace_special_chars(stripslashes($query)));
        $fullquery = $this->fieldName . ':' .rawurlencode(stripslashes($this->query));
        $resultscode = $this->elastic->sendRequest('/english/search?q='.$fullquery.'&size='.$this->limit.'&from='.$this->getStartOffset());

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
