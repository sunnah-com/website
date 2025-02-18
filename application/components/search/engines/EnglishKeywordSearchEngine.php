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

    protected function hasSuggestionsSupport()
    {
        return true;
    }
}
