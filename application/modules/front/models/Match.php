<?php

/**
 * This is the model class for table "matchtable".
 *
 * The followings are the available columns in table 'matchtable':
 * @property integer $arabicURN
 * @property integer $englishURN
 * @property integer $ourHadithNumber
 */
class Match extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Match the static model class
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
        return 'matchtable';
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
            'arabicURN' => 'Arabic Urn',
            'englishURN' => 'English Urn',
            'ourHadithNumber' => 'Our Hadith Number',
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

        $criteria->compare('arabicURN',$this->arabicURN);
        $criteria->compare('englishURN',$this->englishURN);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
