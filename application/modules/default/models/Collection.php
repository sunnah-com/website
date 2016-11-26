<?php

/**
 * This is the model class for table "Collections".
 *
 * The followings are the available columns in table 'Collections':
 * @property string $name
 * @property integer $collectionID
 * @property string $type
 * @property string $englishTitle
 * @property string $arabicTitle
 * @property string $hasvolumes
 * @property string $hasbooks
 * @property string $annotation
 * @property string $shortintro
 * @property string $about
 */
class Collection extends CActiveRecord
{
	public function fetchBooks() {
		$util = new Util();
		$books = $util->getBook($this->name);
		return $books;
	}
    /**
     * Returns the static model of the specified AR class.
     * @return Collection the static model class
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
        return 'Collections';
    }

    /**
     * @return array validation rules for model attributes.
     */

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
            'name' => 'Name',
            'collectionID' => 'Collection',
            'type' => 'Type',
            'englishTitle' => 'English Title',
            'arabicTitle' => 'Arabic Title',
            'hasvolumes' => 'Hasvolumes',
            'hasbooks' => 'Hasbooks',
            'annotation' => 'Annotation',
            'shortintro' => 'Shortintro',
            'about' => 'About',
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

        $criteria->compare('name',$this->name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
