<?php

/**
 * This is the model class for table "IndonesianHadithTable".
 *
 * The followings are the available columns in table 'IndonesianHadithTable':
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
class IndonesianHadith extends Hadith
{

    public function process_text() {
        $processed_text = trim($this->hadithText);
        $processed_text .= "</b>";

        $processed_text = preg_replace("/PBUH/", "<img src=\"/images/sallallahu_alaihi_wa_sallam.png\" height=\"18px\" alt=\"sallallahu 'alaihi wa sallam\">", $processed_text);
        $processed_text = preg_replace("/peace_be_upon_him/", "<img src=\"/images/sallallahu_alaihi_wa_sallam.png\" height=\"18px\" alt=\"sallallahu 'alaihi wa sallam\">", $processed_text);
        $processed_text = preg_replace("/\(saws\)/", "(<img src=\"/images/sallallahu_alaihi_wa_sallam.png\" height=\"18px\" alt=\"sallallahu 'alaihi wa sallam\">)", $processed_text);
        $processed_text = preg_replace("/\(SAW\)/", "(<img src=\"/images/sallallahu_alaihi_wa_sallam.png\" height=\"18px\" alt=\"sallallahu 'alaihi wa sallam\">)", $processed_text);

        // Collection-specific processing of text
        if (strcmp($this->collection, "qudsi") == 0) {
            $processed_text = preg_replace("/\n/", "<br><p>\n", $processed_text);
        }
        if (strcmp($this->collection, "riyadussaliheen") == 0) {
            $processed_text = preg_replace("/\n/", "<br><p>\n", $processed_text);
        }
        $this->hadithText = $processed_text;
    }


    /**
     * Returns the static model of the specified AR class.
     * @return Hadith the static model class
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
        return 'IndonesianHadithTable';
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
            'indonesianURN' => 'English Urn',
            'collection' => 'Collection',
            'volumeNumber' => 'Volume Number',
            'bookNumber' => 'Book Number',
            'bookName' => 'Book Name',
            'babNumber' => 'Bab Number',
            'babName' => 'Bab Name',
            'hadithNumber' => 'Hadith Number',
            'hadithText' => 'Hadith Text',
            'bookID' => 'Book',
            'grade' => 'Grade',
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

        $criteria->compare('indonesianURN',$this->indonesianURN);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
