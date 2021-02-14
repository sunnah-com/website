<?php

namespace app\components\search;

use app\modules\front\models\Book;
use app\modules\front\models\Util;
use app\modules\front\models\ArabicHadith;
use app\modules\front\models\EnglishHadith;
use Yii;
use yii\db\Query;

class SearchResultset
{
    /** @var int */
    protected $count = 0;

    /** @var string|null */
    protected $suggestions = null;

    /** @var array */
    protected $results;

    /** @var array */
    private static $LANG_TABLE_DATA = array(
        'en' => array('hadithTable' => 'EnglishHadithTable', 'urnField' => 'englishURN', 'bookField' => 'englishBookID'),
        'ar' => array('hadithTable' => 'ArabicHadithTable', 'urnField' => 'arabicURN', 'bookField' => 'arabicBookID'),
    );

    public function __construct($count)
    {
        $this->results = [];
        $this->count = $count;
    }

    public function setSuggestions($suggestions)
    {
        $this->suggestions = $suggestions;
    }

    public function addResult($lang, $urn, $highlighted)
    {
        $this->results[] = array(
            'language' => $lang,
            'urn' => $urn,
            'highlighted' => $highlighted,
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
     * Returns array of valid search results with hadith data filled in
     *
     * @return array
     */
    public function getResults()
    {
        $urnsByLang = array();
        foreach ($this->results as $result) {
            $urnsByLang[$result['language']][] = $result['urn'];
        }

        $util = new Util();

        $hadithData = array('en' => [], 'ar' => []);
        foreach ($urnsByLang as $lang => $urns) {
            $hadithData[$lang] += self::getHadithsByUrn($lang, $urnsByLang[$lang]);

            $matchingUrns[$lang] = $util->getMatchingUrns($lang, $urns);
            if ($lang === 'en') {
                $hadithData['ar'] += self::getHadithsByUrn('ar', $matchingUrns[$lang]);
            } elseif ($lang === 'ar') {
                $hadithData['en'] += self::getHadithsByUrn('en', $matchingUrns[$lang]);
            }
        }

        $collectionData = $util->getCollectionsInfo('indexed');
        $newResults = array();
        foreach ($this->results as $result) {
            $lang = $result['language'];
            $hadith = $hadithData[$lang][$result['urn']] ?? null;
            if ($hadith === null) {
                // Main matching hadith doesn't exist for some reason
                Yii::warning("Hadith [$lang]: {$result['urn']} doesn't exist", 'search');
                continue;
            }

            if ($lang === 'en') {
                $enUrn = $result['urn'];
                $arUrn = $matchingUrns[$lang][$enUrn] ?? null;
            } elseif ($lang === 'ar') {
                $arUrn = $result['urn'];
                $enUrn = $matchingUrns[$lang][$arUrn] ?? null;
            }

            $bookIdField = self::$LANG_TABLE_DATA[$lang]['bookField'];
            // TODO: Do batch query instead to avoid N+1 problem
            $book = Book::find()->where(
                "{$bookIdField} = :bookId AND collection = :collection",
                array(':bookId' => $hadith['bookID'], ':collection' => $hadith['collection'])
            )->one();

            $arabicEntry = null; $englishEntry = null;
            if (isset($hadithData['ar'][$arUrn]) && !is_null($hadithData['ar'][$arUrn])) {
                $arabicEntry = new ArabicHadith($hadithData['ar'][$arUrn]);
                $arabicEntry->populate($util, $collectionData[$hadith['collection']], $book);
            }
            if (isset($hadithData['en'][$enUrn]) && !is_null($hadithData['en'][$enUrn])) {
                $englishEntry = new EnglishHadith($hadithData['en'][$enUrn]);
                $englishEntry->populate($util, $collectionData[$hadith['collection']], $book);
            }

            $result['data'] = array(
                'collection' => $collectionData[$hadith['collection']],
                'book' => $book,
                'en' => $englishEntry,
                'ar' => $arabicEntry,
            );
            $newResults[] = $result;
        }
        return $newResults;
    }

    protected static function getHadithsByUrn($lang, $urns)
    {
        $tableData = self::$LANG_TABLE_DATA[$lang];
        $query = new Query();
        $query = $query
            ->select('*')
            ->from($tableData['hadithTable'])
            ->where(array('in', $tableData['urnField'], $urns));
        $arabicSet = $query->all();
        $results = array();
        foreach ($arabicSet as $row) {
            $results[$row[$tableData['urnField']]] = $row;
        }
        return $results;
    }
}
