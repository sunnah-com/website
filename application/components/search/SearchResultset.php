<?php

namespace app\components\search;

use app\modules\front\models\Util;
use app\modules\front\models\ArabicHadith;
use app\modules\front\models\EnglishHadith;
use Yii;

class SearchResultset
{
    /** @var int */
    protected $count = 0;

    /** @var string|null */
    protected $suggestions = null;

    /** @var array */
    protected $results;

    public function __construct($count)
    {
        $this->results = [];
        $this->count = $count;
    }

    public function setSuggestions($suggestions)
    {
        $this->suggestions = $suggestions;
    }

    public function addResult($lang, $urn, $highlighted, $source = null)
    {
        $this->results[] = array(
            'language' => $lang,
            'urn' => $urn,
            'highlighted' => $highlighted,
            'source' => $source, // ES _source: carries ->en / ->ar payloads
            'data' => null // filled when calling getResults()
        );
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getSuggestions()
    {
        return $this->suggestions;
    }

    /**
     * Returns array of all search results
     *
     * @return array
     */
    public function getRawResults()
    {
        return $this->results;
    }

    /**
     * Returns array of valid search results with hadith data filled in.
     *
     * Hydrates the hadith models from each hit's _source->en / ->ar payloads,
     * whose keys are EnglishHadith/ArabicHadith property names (see the SELECTs
     * in search/main.py). Only the cached collection/book lookups touch the DB.
     *
     * @return array
     */
    public function getResults()
    {
        $util = new Util();
        $collectionData = $util->getCollectionsInfo('indexed');

        $newResults = array();
        foreach ($this->results as $result) {
          try {
            $lang = $result['language'];
            $source = $result['source'];

            // The matched language's payload must be present in the hit's _source.
            if ($source === null || !isset($source->$lang)) {
                Yii::warning("Search hit [$lang]: {$result['urn']} missing _source.$lang", 'search');
                continue;
            }

            $collectionName = $source->$lang->collection;
            $collection = $collectionData[$collectionName] ?? null;
            if ($collection === null) {
                Yii::warning("Search hit [$lang]: unknown collection {$collectionName}", 'search');
                continue;
            }

            // Both languages share one BookData row, so a single lookup off the
            // matched language feeds both populate() calls (as the old SQL did).
            $bookLanguage = ($lang === 'en') ? 'english' : 'arabic';
            $book = $util->getBook($collectionName, $source->$lang->bookID, $bookLanguage);
            if ($book === null) {
                // Book metadata unavailable (e.g. DB outage with a cold cache).
                // The downstream view requires it, so skip this hit rather than
                // 500 the whole results page.
                Yii::warning("Search hit [$lang]: book unavailable for {$collectionName}/{$source->$lang->bookID}", 'search');
                continue;
            }

            $arabicEntry = null; $englishEntry = null;
            if (isset($source->ar)) {
                $arabicEntry = new ArabicHadith((array) $source->ar);
                $arabicEntry->populate($util, $collection, $book);
            }
            if (isset($source->en)) {
                $englishEntry = new EnglishHadith((array) $source->en);
                $englishEntry->populate($util, $collection, $book);
            }

            $result['data'] = array(
                'collection' => $collection,
                'book' => $book,
                'en' => $englishEntry,
                'ar' => $arabicEntry,
            );
            $newResults[] = $result;
          } catch (\Throwable $e) {
            // Render what we can: drop a single un-hydratable hit instead of
            // failing the entire search page.
            Yii::warning("Search hit [{$result['language']}] {$result['urn']} skipped: " . $e->getMessage(), 'search');
            continue;
          }
        }
        return $newResults;
    }
}
