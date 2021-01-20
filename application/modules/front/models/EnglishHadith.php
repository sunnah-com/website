<?php

namespace app\modules\front\models;

use app\modules\front\models\Hadith;

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
class EnglishHadith extends Hadith
{

    public $translationReference = null;
    public $translationReferenceTitle = null;
    public $postReferenceNote = null;
    public $englishReference = null; // For non-verified ahadith
    public $englishReferenceTitle = null;

    public function populateReferences($util, $collection = null, $book = null) {
        if (is_null($collection)) { $collection = $util->getCollection($this->collection); }
        if (is_null($book)) { $book = $util->getBook($this->collection, $this->bookID, "english"); }

        if ($book->status === 4) {
            if ((int)$this->hadithNumber !== 0 && $collection->showEnglishTranslationNumber === "yes") {
                $this->translationReferenceTitle = "English translation";
                $span_attribute = "";
                if (in_array($this->collection, array("bukhari", "muslim", "malik"))) {
                    $span_attribute = " class=\"deprecated_reference\"";
                    $this->translationReferenceTitle = "<span$span_attribute>USC-MSA web (English) reference</span>";
                }

                $this->translationReference = "<span$span_attribute>";
                if ($collection->hasvolumes === "yes") {
                    $this->translationReference .= "Vol. " . $this->volumeNumber . ", ";
                }
                if ($collection->hasbooks === "yes") {
                    $this->translationReference .= "Book " . $this->bookNumber . ", ";
                }
                $this->translationReference .= "Hadith $this->hadithNumber";
                $this->translationReference .= "</span>";

                if (in_array($this->collection, array("bukhari", "muslim", "malik"))) {
                    $this->postReferenceNote = "<span$span_attribute><i>(deprecated numbering scheme)</i></span>";
                }
            }
        }
        else {
            $this->englishReference = "";
            if ($collection->hasvolumes === "yes") { $this->englishReference .= "Vol. ".$this->volumeNumber.", "; }
            if ($collection->hasbooks === "yes") { $this->englishReference .= "Book ".$this->bookNumber.", "; }
            $this->englishReference .= "Hadith ".$this->hadithNumber;

            $this->englishReferenceTitle = "English translation";
            if (in_array($this->collection, array("bukhari", "muslim", "malik"))) {
                $this->englishReferenceTitle = "USC-MSA web (English) reference";
            }
        }
    }

    public function populatePermalink($util, $collection = null, $book = null) {
        $this->permalink = "/urn/$this->englishURN";
    }

    public function process_text() {
        $processed_text = trim($this->hadithText);
        $processed_text .= "</b>";
		$imgsawstext = "<img class=sawsimg src=\"/images/sallallahu_alaihi_wa_sallam.png\" title=\"sallallahu 'alaihi wa sallam\">";
		$spansawstext = "<span class=saws><span>saws</span></span>";
		$sawstext = "ﷺ";
		$to_be_replaced_nb = array (
							"/PBUH/",
							"/P.B.U.H./",
							"/peace_be_upon_him/",
						);
		$to_be_replaced_b = array (
							"/\(may peace be upon him\)/",
							"/\(saws\)/",
							"/\(SAW\)/",
							"/\(saw\)/",
						);

        $processed_text = preg_replace($to_be_replaced_nb, $sawstext, $processed_text);
        $processed_text = preg_replace($to_be_replaced_b, "(".$sawstext.")", $processed_text);
		$processed_text = str_replace("the Apostle of Allah", "the Messenger of Allah", $processed_text);

        // Collection-specific processing of text
		if (strcmp($this->collection, "bukhari") == 0) {
			$processed_text = preg_replace("/Allah's Apostle(?!\s*<)/", "Allah's Messenger (".$sawstext.")", $processed_text);
			$processed_text = preg_replace("/he Prophet (?!\()/", "he Prophet (".$sawstext.") ", $processed_text);
		}
		elseif (strcmp($this->collection, "muslim") == 0) {
			$processed_text = str_replace("he Holy Prophet ", "he Prophet ", $processed_text);
		}
        elseif (strcmp($this->collection, "qudsi") == 0) {
            $processed_text = preg_replace("/\n/", "<br><p>\n", $processed_text);
        }
        elseif (strcmp($this->collection, "riyadussalihin") == 0) {
            $processed_text = preg_replace("/\n/", "<br><p>\n", $processed_text);
        }
        elseif (strcmp($this->collection, "bulugh") == 0) {
            $processed_text = preg_replace("/\) said, /", ") said: ", $processed_text);
        }
		
        $this->hadithText = $processed_text;
    }


    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{EnglishHadithTable}}';
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
