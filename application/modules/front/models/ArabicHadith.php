<?php

namespace app\modules\front\models;

use Yii;
use Thunder\Shortcode\ShortcodeFacade;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

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
    private $facade;
    public $shortcode_parsed = false;

    function __construct() {
        parent::__construct();
        $this->makeShortcodeParser();
    }

    public function sanadizer(ShortcodeInterface $s) {
        return sprintf('<span class="arabic_sanad">%s</span>', $s->getContent());
    }

    public function matnizer(ShortcodeInterface $s) {
        return sprintf('<span class="arabic_text_details">%s</span>', $s->getContent());
    }

    public function narratorHandler(ShortcodeInterface $s) {
        return sprintf('<a href="/narrator/%s" title="%s">%s</a>',
            $s->getParameter("id"),
            addslashes($s->getParameter("tooltip")),
            $s->getContent());
    }

    private function makeShortcodeParser() {
        $this->facade = new ShortcodeFacade();
        $this->facade->addHandler('prematn', array($this, 'sanadizer'));
        $this->facade->addHandler('postmatn', array($this, 'sanadizer'));
        $this->facade->addHandler('matn', array($this, 'matnizer'));
        $this->facade->addHandler('narrator', array($this, 'narratorHandler'));
    }

    public function process_text()
    {
        $processed_text = trim($this->hadithText);
        $processed_text = preg_replace("/^- /", "", $processed_text);

        if (strpos($processed_text, "]")) {
            $processed_text = $this->facade->process($processed_text);
            $this->shortcode_parsed = true;
        }

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
            $hadithNumber = $this->hadithNumber;
            if ($collection->name == "muslim" && $book->ourBookID !== -1) {
                $hadithNumber = preg_replace("/(\d)\s*([a-zA-Z])/", "$1$2", $hadithNumber);
            }
            if (!is_null($book->reference_template)) {
                $reference_string = $book->reference_template;
                $reference_string = str_replace("{hadithNumber}", $hadithNumber, $reference_string);
                $this->canonicalReference = $reference_string;
            } else {
                $this->canonicalReference = $collection->englishTitle . " " . $hadithNumber;
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

        $use_colon_permalinks = true;

        if ($book->status === 4) {
            if ($use_colon_permalinks) {
                // In case an entry lists multiple hadith numbers, use the first one
                $hadithNumber = explode(",", $this->hadithNumber)[0];
                $hadithNumber = preg_replace("/(\d)\s*([a-zA-Z])/", "$1$2", $hadithNumber);
                $this->permalink = "/$collection->name:".$hadithNumber;

                // Special cases
                if ($collection->name == "forty") { $this->permalink = "/$book->linkpath:$this->hadithNumber"; }
                if ($collection->name == "muslim" && $book->ourBookID == -1 && substr($this->hadithNumber, 0, 12) == "Introduction") {
                    $this->permalink = "/muslim/introduction/$this->ourHadithNumber";
                }
            }
            else {
                if (!is_null($book->linkpath)) {
                    $this->permalink = "/$book->linkpath/$this->ourHadithNumber";
                } else {
                    if ($collection->hasbooks === "yes") {
                        if (!is_null($book->ourBookNum)) {
                            $booklinkpath = $book->ourBookNum;
                        } else {
                            $booklinkpath = (string)$book->ourBookID;
                        }
                        $this->permalink = "/" . $collection->name . "/$booklinkpath/$this->ourHadithNumber";
                    } else {
                        $this->permalink = "/" . $collection->name . "/$this->ourHadithNumber";
                    } // This collection has no books.
                }
            }
        }
        else {
            if ($this->ourHadithNumber > 0) {
                if ($collection->hasbooks === "yes") {
                    $this->permalink = "/" . $collection->name . "/$book->ourBookID/$this->ourHadithNumber";
                    if ($book->ourBookID === -1) { $this->permalink = "/" . $collection->name . "/introduction/$this->ourHadithNumber"; }
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
