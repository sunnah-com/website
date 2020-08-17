<?php

namespace app\modules\front\models;

use yii\db\ActiveRecord;
use Yii;
use Util;
use app\modules\front\models\EnglishHadith;
use app\modules\front\models\ArabicHadith;
use app\modules\front\models\UrduHadith;
use app\modules\front\models\IndonesianHadith;

/**
 * This is the model class for table "BookData".
 *
 * The followings are the available columns in table 'BookData':
 * @property string $collection
 * @property string $englishBookID
 * @property integer $englishBookNumber
 * @property string $englishBookName
 * @property string $arabicBookID
 * @property integer $arabicBookNumber
 * @property string $arabicBookName
 * @property integer $ourBookID
 */

class Book extends ActiveRecord
{
    private function find_closest_element($arr, $val) {
        $last = 0;
        for ($counter = 0; $counter < count($arr); $counter++) {
            $cand = $arr[$counter];
            if ($cand > 0 && $cand < $val) $last = $counter;
            elseif ($cand > $val) return $counter;
        }
        return $counter;
    }

	public function fetchLangHadith($lang = "english", $hadithRange = NULL) {
        $bookIDstring = $lang."BookID";
        
        switch ($lang) {
        case "indonesian":
            $query = IndonesianHadith::find();
            break;
        case "urdu":
            $query = UrduHadith::find();
            break;
        case "arabic":
            $query = ArabicHadith::find();
            break;
        default:
            $query = EnglishHadith::find();
        }
        $query = $query->select('*')
                       ->where('collection = :collection', [':collection' => $this->collection])
                       ->andWhere('bookID = :bookID', [':bookID' => $this->$bookIDstring]);
        $cacheID = $lang."hadiths:".$this->collection."_".$this->ourBookID;
        if (!is_null($hadithRange)) {
            $query = $query->andWhere('ourHadithNumber >= :beginIndex', [':beginIndex' => $beginIndex]);
            $query = $query->andWhere('ourHadithNumber <= :endIndex', [':endIndex' => $endIndex]);
            $cacheID .= ":".$beginIndex."-".$endIndex;
        }
        $englishSet = Yii::$app->cache->get($cacheID);
        if ($englishSet === false) {
			$englishSet = $query->all();
            foreach ($englishSet as $englishHadith) $englishHadith->process_text();
            Yii::$app->cache->set($cacheID, $englishSet, Yii::$app->params['cacheTTL']);
        }
		foreach ($englishSet as $englishHadith) $retval[] = $englishHadith->toJSON();
		return $retval;
	}

	public function fetchHadith($hadithRange = NULL) {
		$beginIndex = NULL; $endIndex = NULL;
		if (!is_null($hadithRange)) {
            $dashpos = strpos($hadithRange, '-');
            if ($dashpos === FALSE) {
                if (is_numeric($hadithRange) && $hadithRange > 0) {
                    $beginIndex = $hadithRange; $endIndex = $hadithRange;
                }
            }
            else {
                $beginIndex = strstr($hadithRange, '-', true);
                $endIndex = substr(strstr($hadithRange, '-', false), 1);
            }
        }

        if (strlen($this->englishBookID) < 1 && strlen($this->arabicBookID) < 1) return array();
        $query = EnglishHadith::find()
                  ->select('*')
                  ->where('collection = :collection', [':collection' => $this->collection])
                  ->andWhere('bookID = :bookID', [':bookID' => $this->englishBookID]);
		$cacheID = "englishhadiths:".$this->collection."_".$this->ourBookID;
        if (!is_null($hadithRange)) {
            $query = $query->andWhere('ourHadithNumber >= :beginIndex', [':beginIndex' => $beginIndex]);
            $query = $query->andWhere('ourHadithNumber <= :endIndex', [':endIndex' => $endIndex]);
			$cacheID .= ":".$beginIndex."-".$endIndex;
		}
		$query = $query->orderBy(['englishURN' => SORT_ASC]);
		
		$englishSet = Yii::$app->cache->get($cacheID);
		if ($englishSet === false) {
        	$englishSet = $query->all();
			foreach ($englishSet as $englishHadith) $englishHadith->process_text();
			Yii::$app->cache->set($cacheID, $englishSet, Yii::$app->params['cacheTTL']);
		}

		/* Commenting this out since we're not doing anything with it at the moment
		// get last modified time for english hadith set
		$query->select("max(last_updated) as lastup");
       	$englishLastupSet = $query->all();
		if (count($englishLastupSet) > 0) $englishLastup = $englishLastupSet[0]->lastup;
		*/

        $query = ArabicHadith::find()
                        ->select('*')
                        ->where('collection = :collection', [':collection' => $this->collection])
                        ->andWhere('bookID = :bookID', [':bookID' => $this->arabicBookID]);
		$cacheID = "arabichadiths:".$this->collection."_".$this->ourBookID;
		if (!is_null($hadithRange)) {
            $query = $query->andWhere('ourHadithNumber >= :beginIndex', [':beginIndex' => $beginIndex]);
            $query = $query->andWhere('ourHadithNumber <= :endIndex', [':endIndex' => $endIndex]);
			$cacheID .= ":".$beginIndex."-".$endIndex;
		}
		$query = $query->orderBy(['arabicURN' => SORT_ASC]);
        
        $arabicSet = Yii::$app->cache->get($cacheID); 
		if ($arabicSet === false) {
        	$arabicSet = $query->all();
			foreach ($arabicSet as $arabicHadith) $arabicHadith->process_text();
			Yii::$app->cache->set($cacheID, $arabicSet, Yii::$app->params['cacheTTL']);
        }
		else Yii::trace("$cacheID was hit in cache");

		/* Commenting this out since we're not doing anything with it at the moment
		// get last modified time for arabic hadith set
		$query->select("max(last_updated) as lastup");
       	$arabicLastupSet = $query->all();
		if (count($arabicLastupSet) > 0) $arabicLastup = $arabicLastupSet[0]->lastup;

		$lastup = $englishLastup;
		if ($arabicLastup > $englishLastup) $lastup = $arabicLastup;
		*/
		$lastup = null;
		
        if (count($englishSet) == 0 && count($arabicSet) == 0) return NULL;

        $eurns_string = '';
        $aurns_string = '';
        $eURNs_orig = array();
        $aURNs_orig = array();
        $englishEntries   = array();
        $arabicEntries   = array();

        foreach ($englishSet as $row) {
            $englishEntries[$row->englishURN] = $row;
            $eURNs[] = $row->englishURN;
            $eurns_string = $eurns_string.$row->englishURN.',';
        }
        $eurns_string = substr($eurns_string, 0, -1);

        foreach ($arabicSet as $row) {
            $arabicEntries[$row->arabicURN] = $row;
            $aURNs_orig[] = $row->arabicURN;
            $aurns_string = $aurns_string.$row->arabicURN.',';
        }
        $aurns_string = substr($aurns_string, 0, -1);

        if (isset($eURNs)) {
            for ($i = 0; $i < count($englishSet); $i++) {
                $aURNs_match[$i] = $englishSet[$i]->matchingArabicURN;
            }
        }
        else {$eURNs = array(); $aURNs_match = array();}

        //Mix the URNs without entries in matchtable
        $aURNs = $aURNs_match;
        foreach ($aURNs_orig as $aURN) {
            if (array_search($aURN, $aURNs_match) === FALSE) {
                $posn = $this->find_closest_element($aURNs, $aURN);
                array_splice($aURNs, $posn, 0, $aURN);
                array_splice($eURNs, $posn, 0, 0);
            }
        }

        $englishEntries[0] = NULL;
        $arabicEntries[0] = NULL;

        $pairs = array_map(NULL, $eURNs, $aURNs);
        if (!is_null($hadithRange) and FALSE){
            $dashpos = strpos($hadithRange, '-');
            if ($dashpos === FALSE) {
                if (is_numeric($hadithRange) && $hadithRange > 0) $pairs = array($pairs[$hadithRange-1]);
                else $pairs = NULL;
            }
            else {
                $beginIndex = strstr($hadithRange, '-', true);
                $endIndex = substr(strstr($hadithRange, '-', false), 1);
                if (is_numeric($beginIndex) && $beginIndex > 0 && is_numeric($endIndex) && $endIndex >= $beginIndex) {
                    $pairs = array_slice($pairs, $beginIndex-1, $endIndex-$beginIndex+1);
                }
            }
        }
        if (count($englishEntries) > 0 || count($arabicEntries) > 0) return array($englishEntries, $arabicEntries, $pairs, $lastup);
        else return array();        
	}
	
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{BookData}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'collection' => 'Collection',
            'englishBookID' => 'English Book',
            'englishBookNumber' => 'English Book Number',
            'englishBookName' => 'English Book Name',
            'arabicBookID' => 'Arabic Book',
            'arabicBookNumber' => 'Arabic Book Number',
            'arabicBookName' => 'Arabic Book Name',
            'ourBookID' => 'Our Book',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('collection',$this->collection,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
