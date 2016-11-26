<?php

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
class Book extends CActiveRecord
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
        $crit = new CDbCriteria;
        $crit->select = '*';
        $crit->addCondition('collection = :collection');
        $crit->addCondition('bookID = :bookID');
        $crit->params = array(
            ':collection' => $this->collection,
            ':bookID' => $this->$bookIDstring,
        );
        $cacheID = $lang."hadiths:".$this->collection."_".$this->ourBookID;
        if (!is_null($hadithRange)) {
            $crit->addCondition('ourHadithNumber >= :beginIndex');
            $crit->addCondition('ourHadithNumber <= :endIndex');
            $crit->params = array(
                ':collection' => $this->collection,
                ':bookID' => $this->$bookIDstring,
                ':beginIndex' => $beginIndex,
                ':endIndex' => $endIndex,
            );
            $cacheID .= ":".$beginIndex."-".$endIndex;
        }
		//Yii::trace("arbzz bookID is "+$this->$bookIDstring);
        $englishSet = Yii::app()->cache->get($cacheID);
        if ($englishSet === false) {
			if (strcmp($lang, "indonesian") == 0) $englishSet = IndonesianHadith::model()->findAll($crit);
			elseif (strcmp($lang, "urdu") == 0) $englishSet = UrduHadith::model()->findAll($crit);
			elseif (strcmp($lang, "arabic") == 0) $englishSet = ArabicHadith::model()->findAll($crit);
			else $englishSet = EnglishHadith::model()->findAll($crit);
            foreach ($englishSet as $englishHadith) $englishHadith->process_text();
            Yii::app()->cache->set($cacheID, $englishSet, Yii::app()->params['cacheTTL']);
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
		$crit = new CDbCriteria;
		$crit->select = '*';
		$crit->addCondition('collection = :collection');
		$crit->addCondition('bookID = :bookID');
		$crit->params = array(
			':collection' => $this->collection, 
			':bookID' => $this->englishBookID,
		);
		$cacheID = "englishhadiths:".$this->collection."_".$this->ourBookID;
		if (!is_null($hadithRange)) {
            $crit->addCondition('ourHadithNumber >= :beginIndex');
            $crit->addCondition('ourHadithNumber <= :endIndex');
			$crit->params = array(
				':collection' => $this->collection, 
				':bookID' => $this->englishBookID,
				':beginIndex' => $beginIndex,
				':endIndex' => $endIndex,
			);
			$cacheID .= ":".$beginIndex."-".$endIndex;
		}
		$crit->order = 'englishURN';
		
		$englishSet = Yii::app()->cache->get($cacheID);
		if ($englishSet === false) {
        	$englishSet = EnglishHadith::model()->findAll($crit);
			foreach ($englishSet as $englishHadith) $englishHadith->process_text();
			Yii::app()->cache->set($cacheID, $englishSet, Yii::app()->params['cacheTTL']);
		}

		// get last modified time for english hadith set
		$crit->select = "max(last_updated) as lastup";
       	$englishLastupSet = EnglishHadith::model()->findAll($crit);
		if (count($englishLastupSet) > 0) $englishLastup = $englishLastupSet[0]->lastup;


		$crit = new CDbCriteria;
		$crit->select = '*';
		$crit->addCondition('collection = :collection');
		$crit->addCondition('bookID = :bookID');
		$crit->params = array(
			':collection' => $this->collection, 
			':bookID' => $this->arabicBookID,
		);
		$cacheID = "arabichadiths:".$this->collection."_".$this->ourBookID;
		if (!is_null($hadithRange)) {
            $crit->addCondition('ourHadithNumber >= :beginIndex');
            $crit->addCondition('ourHadithNumber <= :endIndex');
			$crit->params = array(
				':collection' => $this->collection, 
				':bookID' => $this->arabicBookID,
				':beginIndex' => $beginIndex,
				':endIndex' => $endIndex,
			);
			$cacheID .= ":".$beginIndex."-".$endIndex;
		}
		$crit->order = 'arabicURN';
		$arabicSet = Yii::app()->cache->get($cacheID); 
		if ($arabicSet === false) {
        	$arabicSet = ArabicHadith::model()->findAll($crit);
			foreach ($arabicSet as $arabicHadith) $arabicHadith->process_text();
			Yii::app()->cache->set($cacheID, $arabicSet, Yii::app()->params['cacheTTL']);
        }
		else Yii::trace("$cacheID was hit in cache");

		// get last modified time for arabic hadith set
		$crit->select = "max(last_updated) as lastup";
       	$arabicLastupSet = ArabicHadith::model()->findAll($crit);
		if (count($arabicLastupSet) > 0) $arabicLastup = $arabicLastupSet[0]->lastup;

		$lastup = $englishLastup;
		if ($arabicLastup > $englishLastup) $lastup = $arabicLastup;
		
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
     * Returns the static model of the specified AR class.
     * @return Book the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'BookData';
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
