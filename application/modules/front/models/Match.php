<?php

namespace app\modules\front\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "matchtable".
 *
 * The followings are the available columns in table 'matchtable':
 * @property integer $arabicURN
 * @property integer $englishURN
 * @property integer $ourHadithNumber
 */

class Match extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{matchtable}}';
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
}
