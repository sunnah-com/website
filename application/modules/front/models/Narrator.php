<?php

namespace app\modules\front\models;

use Yii;

/**
 * This is the model class for table "Narrators".
 *
 * @property int $ID
 * @property int $NewID
 * @property int $Age
 * @property int $RawiRank
 * @property string|null $DateOfBirth
 * @property string|null $BaladEkama
 * @property string|null $BaladWafa
 * @property int $Bokhary
 * @property int $Moslem
 * @property string|null $DeathYear
 * @property string|null $Karaba
 * @property string|null $Konya
 * @property string|null $Lakab
 * @property string|null $Mawaaly
 * @property string|null $Mazhab
 * @property string $Name
 * @property string|null $Badeel
 * @property string|null $Nasab
 * @property string $Shohra
 * @property string|null $San3a
 * @property int $Tabaka
 * @property string|null $Wasf
 * @property string|null $WasfRotba
 * @property int $Rotba
 * @property int $Tadleese
 * @property int $E5telat
 * @property string|null $CommonName
 * @property int $Marweyaat
 * @property int $IsMale
 * @property int $DisplayID
 * @property string|null $MarweyaatCountSymbol
 */
class Narrator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Narrators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'NewID', 'Age', 'RawiRank', 'Bokhary', 'Moslem', 'Name', 'Shohra', 'Tabaka', 'Rotba', 'Tadleese', 'E5telat', 'Marweyaat', 'IsMale', 'DisplayID'], 'required'],
            [['ID', 'NewID', 'Age', 'RawiRank', 'Bokhary', 'Moslem', 'Tabaka', 'Rotba', 'Tadleese', 'E5telat', 'Marweyaat', 'IsMale', 'DisplayID'], 'integer'],
            [['DateOfBirth', 'BaladEkama', 'BaladWafa', 'DeathYear', 'Karaba', 'Konya', 'Lakab', 'Mawaaly', 'Mazhab', 'Name', 'Badeel', 'Nasab', 'Shohra', 'San3a', 'Wasf', 'WasfRotba', 'CommonName', 'MarweyaatCountSymbol'], 'string'],
            [['ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NewID' => 'New ID',
            'Age' => 'Age',
            'RawiRank' => 'Rawi Rank',
            'DateOfBirth' => 'Date Of Birth',
            'BaladEkama' => 'Balad Ekama',
            'BaladWafa' => 'Balad Wafa',
            'Bokhary' => 'Bokhary',
            'Moslem' => 'Moslem',
            'DeathYear' => 'Death Year',
            'Karaba' => 'Karaba',
            'Konya' => 'Konya',
            'Lakab' => 'Lakab',
            'Mawaaly' => 'Mawaaly',
            'Mazhab' => 'Mazhab',
            'Name' => 'Name',
            'Badeel' => 'Badeel',
            'Nasab' => 'Nasab',
            'Shohra' => 'Shohra',
            'San3a' => 'San3a',
            'Tabaka' => 'Tabaka',
            'Wasf' => 'Wasf',
            'WasfRotba' => 'Wasf Rotba',
            'Rotba' => 'Rotba',
            'Tadleese' => 'Tadleese',
            'E5telat' => 'E5telat',
            'CommonName' => 'Common Name',
            'Marweyaat' => 'Marweyaat',
            'IsMale' => 'Is Male',
            'DisplayID' => 'Display ID',
            'MarweyaatCountSymbol' => 'Marweyaat Count Symbol',
        ];
    }
}
