<?php

/**
 * This is the model class for table "ChapterData".
 *
 * The followings are the available columns in table 'ChapterData':
 * @property string $collection
 * @property string $englishBookID
 * @property string $arabicBookID
 * @property string $babID
 * @property integer $arabicBabNumber
 * @property integer $englishBabNumber
 * @property string $arabicIntro
 * @property string $englishIntro
 */
class Chapter extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Chapter the static model class
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
        return 'ChapterData';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('collection, babID, arabicBabNumber, englishBabNumber', 'required'),
            array('arabicBabNumber, englishBabNumber', 'numerical', 'integerOnly'=>true),
            array('collection', 'length', 'max'=>50),
            array('englishBookID, arabicBookID', 'length', 'max'=>3),
            array('babID', 'length', 'max'=>6),
            array('arabicIntro, englishIntro', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('collection, englishBookID, arabicBookID, babID, arabicBabNumber, englishBabNumber, arabicIntro, englishIntro', 'safe', 'on'=>'search'),
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
            'arabicBookID' => 'Arabic Book',
            'babID' => 'Bab',
            'arabicBabNumber' => 'Arabic Bab Number',
            'englishBabNumber' => 'English Bab Number',
            'arabicIntro' => 'Arabic Intro',
            'englishIntro' => 'English Intro',
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
        $criteria->compare('englishBookID',$this->englishBookID,true);
        $criteria->compare('arabicBookID',$this->arabicBookID,true);
        $criteria->compare('babID',$this->babID,true);
        $criteria->compare('arabicBabNumber',$this->arabicBabNumber);
        $criteria->compare('englishBabNumber',$this->englishBabNumber);
        $criteria->compare('arabicIntro',$this->arabicIntro,true);
        $criteria->compare('englishIntro',$this->englishIntro,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}

?>
