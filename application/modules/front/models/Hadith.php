<?php

namespace app\modules\front\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "EnglishHadithTable".
 *
 * The followings are the available columns in table 'EnglishHadithTable':
 * @property string $collection
 * @property integer $volumeNumber
 * @property integer $bookNumber
 * @property string $bookName
 * @property integer $babNumber
 * @property string $babName
 * @property integer $hadithNumber
 * @property string $hadithText
 * @property string $bookID
 * @property string $grade
 * @property string $comments
 * @property integer $ourHadithNumber
 */
class Hadith extends ActiveRecord
{

	public $lastup = NULL;
	public $canonicalReference = null;
	public $inbookReference = null;
	public $permalink = null;
	public $sunnahReference = null;

    public function __construct($config = []) {
        parent::__construct();
        if (!is_null($config)) {
            foreach ($config as $key => $val) {
                $this->$key = $val;
            }
        }
    }

    public function populateReferences($util, $collection = null, $book = null) {}
    public function populatePermalink($util, $collection = null, $book = null) {}
    public function populate($util, $collection = null, $book = null) {
        $this->populateReferences($util, $collection, $book);
        $this->populatePermalink($util, $collection, $book);
    }

	public function toJSON() {
		$json = new \StdClass();
		foreach ($this as $key => $value) {
                    $json->$key = $value;
                }
    	return $json;
	}

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{HadithTable}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
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
            'englishURN' => 'English Urn',
            'collection' => 'Collection',
            'volumeNumber' => 'Volume Number',
            'bookNumber' => 'Book Number',
            'bookName' => 'Book Name',
            'babNumber' => 'Bab Number',
            'babName' => 'Bab Name',
            'hadithNumber' => 'Hadith Number',
            'hadithText' => 'Hadith Text',
            'bookID' => 'Book',
            'comments' => 'Comments',
            'ourHadithNumber' => 'Our Hadith Number',
            'matchingArabicURN' => 'Matching Arabic Urn',
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

        $criteria->compare('englishURN',$this->englishURN);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
