<?php

/**
 * This is the model class for table "bukhari_arabic".
 *
 * The followings are the available columns in table 'bukhari_arabic':
 * @property integer $arabicURN
 * @property string $collection
 * @property integer $volumeNumber
 * @property integer $bookNumber
 * @property string $babNumber
 * @property integer $hadithNumber
 * @property string $fabNumber
 * @property string $bookName
 * @property string $babName
 * @property string $hadithSanad
 * @property string $hadithText
 * @property string $comments
 * @property string $grade
 * @property string $albanigrade
 * @property string $bookID
 * @property string $annotations
 */
class BukhariArabic extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bukhari_arabic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('collection, volumeNumber, bookNumber, hadithNumber, fabNumber, bookID', 'required'),
            array('arabicURN, volumeNumber, bookNumber, hadithNumber', 'numerical', 'integerOnly'=>true),
            array('collection, fabNumber', 'length', 'max'=>50),
            array('babNumber', 'length', 'max'=>6),
            array('bookName, grade', 'length', 'max'=>200),
            array('babName', 'length', 'max'=>1000),
            array('albanigrade', 'length', 'max'=>2000),
            array('bookID', 'length', 'max'=>3),
            array('hadithSanad, hadithText, comments', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('arabicURN, collection, volumeNumber, bookNumber, babNumber, hadithNumber, fabNumber, bookName, babName, hadithSanad, hadithText, comments, grade, albanigrade, bookID, annotations', 'safe', 'on'=>'search'),
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
            'arabicURN' => 'Arabic Urn',
            'collection' => 'Collection',
            'volumeNumber' => 'Volume Number',
            'bookNumber' => 'Book Number',
            'babNumber' => 'Bab Number',
            'hadithNumber' => 'Hadith Number',
            'fabNumber' => 'Fab Number',
            'bookName' => 'Book Name',
            'babName' => 'Bab Name',
            'hadithSanad' => 'Hadith Sanad',
            'hadithText' => 'Hadith Text',
            'comments' => 'Comments',
            'grade' => 'Grade',
            'albanigrade' => 'Albanigrade',
            'bookID' => 'Book',
            'annotations' => 'Annotations',
            'last_updated' => 'Last Updated',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('arabicURN',$this->arabicURN);
        $criteria->compare('collection',$this->collection,true);
        $criteria->compare('volumeNumber',$this->volumeNumber);
        $criteria->compare('bookNumber',$this->bookNumber);
        $criteria->compare('babNumber',$this->babNumber,true);
        $criteria->compare('hadithNumber',$this->hadithNumber);
        $criteria->compare('fabNumber',$this->fabNumber,true);
        $criteria->compare('bookName',$this->bookName,true);
        $criteria->compare('babName',$this->babName,true);
        $criteria->compare('hadithSanad',$this->hadithSanad,true);
        $criteria->compare('hadithText',$this->hadithText,true);
        $criteria->compare('comments',$this->comments,true);
        $criteria->compare('grade',$this->grade,true);
        $criteria->compare('albanigrade',$this->albanigrade,true);
        $criteria->compare('bookID',$this->bookID,true);
        $criteria->compare('annotations',$this->annotations,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->db_internal;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BukhariArabic the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
