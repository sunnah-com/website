<?php

namespace app\modules\front\models;

use Yii;

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
class ArabicHadith extends Hadith
{
    private $util = null;
    public $arabicReference = null; // For non-verified ahadith

    public function process_text()
    {
        $processed_text = trim($this->hadithText);
        $processed_text = preg_replace("/^- /", "", $processed_text);

        // Collection-specific processing of text
        if (strcmp($this->collection, "muslim")) {
            $processed_text = preg_replace("/\n+/", "<br>\n", $processed_text);
        }
        if (strcmp($this->collection, "riyadussalihin") == 0) {
        }
        if (strcmp($this->collection, "qudsi") == 0) {
        }
        $processed_text = preg_replace("/\n\n/", "<br><p>\n", $processed_text);

        $this->hadithText = $processed_text;
    }

    public function populateReferences($util, $collection = null, $book = null)
    {
        if (is_null($collection)) { $collection = $util->getCollection($this->collection); }
        if (is_null($book)) { $book = $util->getBook($this->collection, $this->bookID, "arabic"); }

        if ($book->status === 4) {
            if (!is_null($book->reference_template)) {
                $reference_string = $book->reference_template;
                $reference_string = str_replace("{hadithNumber}", $this->hadithNumber, $reference_string);
                $this->canonicalReference = $reference_string;
            } else {
                $this->canonicalReference = $collection->englishTitle . " " . $this->hadithNumber;
            }

            $bookNumberReference = "Book " . $book->ourBookID;
            if (!is_null($book->ourBookNum) && strlen($book->ourBookNum) > 0) {
                $bookNumberReference = "Book " . $book->ourBookNum;
            } elseif ($book->ourBookID === -1) {
                $bookNumberReference = "Introduction";
            }

            $this->inbookReference = $bookNumberReference . ", ";

            if (($this->collection === "muslim") && ($book->ourBookID === -1)) {
                $this->inbookReference .= "Narration ";
            } else {
                $this->inbookReference .= "Hadith ";
            }
            $this->inbookReference .= $this->ourHadithNumber;
        }
        else {
            if ($this->ourHadithNumber > 0) {
                $this->sunnahReference = "";
                if ($collection->hasbooks === "yes") { $this->sunnahReference .= "Book ".$this->bookNumber.", "; }
                $this->sunnahReference .= "Hadith ".$this->ourHadithNumber;
            }

            $this->arabicReference = "";
            if ($collection->hasbooks === "yes") { $this->arabicReference .= "Book ".$this->bookNumber.", "; }
            $this->arabicReference .= "Hadith ".$this->hadithNumber;
        }
    }

    public function populatePermalink($util, $collection = null, $book = null) {
        if (is_null($collection)) { $collection = $util->getCollection($this->collection); }
        if (is_null($book)) { $book = $util->getBook($this->collection, $this->bookID, "arabic"); }

        if ($book->status === 4) {
            if (!is_null($book->linkpath)) {
                $this->permalink = "/$book->linkpath/$this->ourHadithNumber";
            } else {
                if ($collection->hasbooks === "yes") {
                    if (!is_null($book->ourBookNum)) { $booklinkpath = $book->ourBookNum; }
                    else { $booklinkpath = (string)$book->ourBookID; }
                    $this->permalink = "/" . $collection->name . "/$booklinkpath/$this->ourHadithNumber";
                }
                else { $this->permalink = "/" . $collection->name . "/$this->ourHadithNumber"; } // This collection has no books.
            }
        }
        else {
            if ($this->ourHadithNumber > 0) {
                if ($collection->hasbooks === "yes") {
                    $this->permalink = "/" . $collection->name . "/$book->ourBookID/$this->ourHadithNumber";
                } else $this->permalink = "/" . $collection->name . "/$this->ourHadithNumber"; // This collection has no books.
            }
            else {
                $this->permalink = "/urn/$this->arabicURN";
            }
        }
    }

    public static function tableName()
    {
        return '{{ArabicHadithTable}}';
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
            'matchingEnglishURN' => 'Matching English Urn',
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

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
