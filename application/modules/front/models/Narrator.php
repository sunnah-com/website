<?php

namespace app\modules\front\models;

use Yii;
use yii\db\ActiveRecord;

class Narrator extends ActiveRecord
{
    public static function tableName()
    {
        return 'Narrators';
    }

    /**
     * Fetch a narrator by narrator_id, with per-row caching.
     * Returns null if not found.
     */
    public static function findByNarratorId($nid)
    {
        $cacheKey = 'narrator:id:' . (int)$nid;
        $cached = Yii::$app->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached ?: null;
        }
        $narrator = static::findOne(['narrator_id' => (int)$nid]);
        Yii::$app->cache->set($cacheKey, $narrator, Yii::$app->params['cacheTTL']);
        return $narrator;
    }

    /**
     * Returns a map of narrator_id => byname for all narrators, used to resolve
     * teacher/student ids without N+1 queries. Cached as a single blob.
     *
     * @return array  [narrator_id (int) => byname (string), ...]
     */
    public static function getSummaryMap()
    {
        $cacheKey = 'narrator:summary_map';
        $map = Yii::$app->cache->get($cacheKey);
        if ($map !== false) {
            return $map;
        }
        $rows = Yii::$app->db
            ->createCommand('SELECT narrator_id, name FROM Narrators')
            ->queryAll();
        $map = [];
        foreach ($rows as $row) {
            $map[(int)$row['narrator_id']] = $row['name'];
        }
        Yii::$app->cache->set($cacheKey, $map, Yii::$app->params['cacheTTL']);
        return $map;
    }

    /**
     * Returns the narrator_ids of this narrator's teachers.
     *
     * @return int[]
     */
    public function getTeacherIds()
    {
        if (empty($this->teachers)) {
            return [];
        }
        return array_values(array_filter(array_map('intval', explode(',', $this->teachers))));
    }

    /**
     * Returns the narrator_ids of this narrator's students.
     *
     * @return int[]
     */
    public function getStudentIds()
    {
        if (empty($this->students)) {
            return [];
        }
        return array_values(array_filter(array_map('intval', explode(',', $this->students))));
    }

    /**
     * Parses the critic_opinions field into structured rows.
     * The field is a JSON array of {critic_id, name, opinion} objects.
     *
     * @return array  [['name' => string, 'opinion' => string], ...]
     */
    public function getCriticOpinions()
    {
        if (empty($this->critic_opinions)) {
            return [];
        }
        $decoded = json_decode($this->critic_opinions, true);
        if (!is_array($decoded)) {
            return [];
        }
        $opinions = [];
        foreach ($decoded as $row) {
            if (!empty($row['name']) && !empty($row['opinion'])) {
                $opinions[] = [
                    'name'    => $row['name'],
                    'opinion' => $row['opinion'],
                ];
            }
        }
        return $opinions;
    }

    // ──────────────────────────────────────────────────── TRANSLITERATION

    private static function getWordDict(): array
    {
        static $dict = null;
        if ($dict !== null) {
            return $dict;
        }
        return $dict = [
            // Common first names / patronymics
            'محمد'      => 'Muhammad',
            'أحمد'      => 'Ahmad',
            'عبد'       => '`Abd',
            'عبدالله'   => '`Abd Allah',
            'عبد الله'  => '`Abd Allah',
            'عبدالرحمن' => '`Abd al-Rahman',
            'عبدالعزيز' => '`Abd al-`Aziz',
            'عبدالرزاق' => '`Abd al-Razzaq',
            'عبدالملك'  => '`Abd al-Malik',
            'عبدالكريم' => '`Abd al-Karim',
            'علي'       => '`Ali',
            'عمر'       => '`Umar',
            'عثمان'     => '`Uthman',
            'حسن'       => 'Hasan',
            'حسين'      => 'Husayn',
            'يحيى'      => 'Yahya',
            'إبراهيم'   => 'Ibrahim',
            'إسحاق'     => 'Ishaq',
            'إسماعيل'   => 'Ismail',
            'سليمان'    => 'Sulayman',
            'سفيان'     => 'Sufyan',
            'حماد'      => 'Hammad',
            'شعبة'      => 'Shu`ba',
            'وكيع'      => 'Waki`',
            'نافع'      => 'Nafi`',
            'جعفر'      => 'Ja`far',
            'هشام'      => 'Hisham',
            'مالك'      => 'Malik',
            'أنس'       => 'Anas',
            'زيد'       => 'Zayd',
            'خالد'      => 'Khalid',
            'سعيد'      => 'Sa`id',
            'بشر'       => 'Bishr',
            'داود'      => 'Dawud',
            'موسى'      => 'Musa',
            'عيسى'      => '`Isa',
            'يوسف'      => 'Yusuf',
            'طلحة'      => 'Talha',
            'ربيعة'     => 'Rabi`a',
            'عبيد'      => '`Ubayd',
            'عبيدالله'  => '`Ubayd Allah',
            'معن'       => 'Ma`n',
            'معاوية'    => 'Mu`awiya',
            'معمر'      => 'Ma`mar',
            'قتادة'     => 'Qatada',
            'حبيب'      => 'Habib',
            'حميد'      => 'Humayd',
            'يزيد'      => 'Yazid',
            'منصور'     => 'Mansur',
            'مسلم'      => 'Muslim',
            'روح'       => 'Rawh',
            'شريك'      => 'Sharik',
            'وهيب'      => 'Wuhayb',
            'مطرف'      => 'Mutarrif',
            'مطر'       => 'Matar',
            'بكر'       => 'Bakr',
            'أبوبكر'    => 'Abu Bakr',
            'عائشة'     => '`Aisha',
            'فاطمة'     => 'Fatima',
            'زينب'      => 'Zaynab',
            'ثور'       => 'Thawr',
            'صالح'      => 'Salih',
            'صفوان'     => 'Safwan',
            'ضمرة'      => 'Damra',
            'طاوس'      => 'Tawus',
            'ظالم'      => 'Zalim',
            'عيينة'     => '`Uyayna',
            'ميمون'     => 'Maymun',
            'معين'      => 'Ma`in',
            'حنبل'      => 'Hanbal',
            'إدريس'     => 'Idris',
            'حاتم'      => 'Hatim',
            'حجر'       => 'Hajar',
            'شهاب'      => 'Shihab',
            'عروة'      => '`Urwa',
            'آدم'       => 'Adam',
            'عمرو'      => '`Amr',
            'زكريا'     => 'Zakariyya',
            'حمران'     => 'Humran',
            'عامر'      => '`Amir',
            'عفان'      => '`Affan',
            'قيس'       => 'Qays',
            'شقيق'      => 'Shaqiq',
            'عكرمة'     => '`Ikrima',
            'عباس'      => '`Abbas',
            'بردة'      => 'Burda',
            // Allah — needed for `Abd Allah compounds and standalone
            'الله'      => 'Allah',
            // Common nisbas — keep ال-prefixed entries only for special transliterations
            // (e.g. sun-letter assimilation). If the bare stem already exists above,
            // the ال-prefixed entry can be removed — "al-" is auto-prefixed.
            'الزهري'    => 'al-Zuhri',
            'الأنصاري'  => 'al-Ansari',
            'القرشي'    => 'al-Qurashi',
            'المدني'    => 'al-Madani',
            'الكوفي'    => 'al-Kufi',
            'البصري'    => 'al-Basri',
            'الليثي'    => 'al-Laythi',
            'الأسدي'    => 'al-Asadi',
            'الحنظلي'   => 'al-Hanzali',
            'الحميري'   => 'al-Humayri',
            'الهاشمي'   => 'al-Hashimi',
            'الرازي'    => 'al-Razi',
            'الخزاعي'   => 'al-Khuza`i',
            'العتكي'    => 'al-`Ataki',
            'الأصبحي'   => 'al-Asbahi',
            'السهمي'    => 'al-Sahmi',
            'القيسي'    => 'al-Qaysi',
            'الحارثي'   => 'al-Harithi',
            'اليساري'   => 'al-Yasari',
            'الهروي'    => 'al-Harawi',
            'القطان'    => 'al-Qattan',
            'الزهراني'  => 'al-Zahrani',
            'الخراساني' => 'al-Khurasani',
            'الصنعاني'  => 'al-Sanani',
            'الشامي'    => 'al-Shami',
            'المصري'    => 'al-Masri',
            'العراقي'   => 'al-`Iraqi',
            'التميمي'   => 'al-Tamimi',
            'السلمي'    => 'al-Sulami',
            'الدمشقي'   => 'al-Dimashqi',
            'المروزي'   => 'al-Marwazi',
            'الجعفري'   => 'al-Ja`fari',
            'المالكي'   => 'al-Maliki',
            'الحنفي'    => 'al-Hanafi',
            'الشافعي'   => 'al-Shafi`i',
            'الحنبلي'   => 'al-Hanbali',
            'المخزومي'  => 'al-Makhzumi',
            'العتقي'    => 'al-`Atqi',
            'الرؤاسي'   => "al-Ru'asi",
            'الخزرجي'   => 'al-Khazraji',
            'الديلي'    => 'al-Dayli',
            // Nisbas extracted from formerly hard-coded full-name entries
            'المديني'   => 'al-Madini',
            'العسقلاني' => 'al-`Asqalani',
            'الصادق'    => 'al-Sadiq',
            'الرأي'     => "al-Ra'y",
            'الهلالي'    => "al-Hilali",
            'الزبير'    => 'az-Zubayr',
            'الحميدي'   => 'al-Humaydi',
            'الأموي'    => 'al-\'Umawi',
            'راهويه'    => 'Rahawayh',
            'الهمداني'  => 'al-Hamadani',
            'العلاء'     => 'al-`Ala',
            'الرحمن'    => 'ar-Rahman',
            'الخطاب'    => 'al-Khattab',
            'الفقيه'    => 'al-Faqih',
            'المسيب'    => 'al-Musayyib',
            'الثوري'    => 'ath-Thawri',
            'المالكية'  => 'Maliki',
            'سلمة'      => 'Salama',
            'يونس'      => 'Yunus',
            'شعيب'      => 'Shu`ayb',
            'جريج'      => 'Jurayj',
            'سعد'       => 'Sa`d',
            'نصر'       => 'Nasr',
            'زياد'      => 'Ziyad',
            'يعقوب'     => 'Ya`qub',
            'سهل'       => 'Sahl',
            'هارون'     => 'Harun',
            'عمران'     => '`Imran',
            'أيوب'      => 'Ayyub',
            'حفص'       => 'Hafs',
            'محمود'     => 'Mahmud',
            'حمزة'      => 'Hamza',
            'خلف'       => 'Khalaf',
            'ثابت'      => 'Thabit',
            'سالم'      => 'Salim',
            'عاصم'      => '`Asim',
            'كثير'      => 'Kathir',
            'هبة'       => 'Hiba',
            'عباد'      => '`Abbad',
            'مسعود'     => 'Mas`ud',
            'وهب'       => 'Wahb',
            'كعب'       => 'Ka`b',
            'مروان'     => 'Marwan',
            'هاشم'      => 'Hashim',
            'جابر'      => 'Jabir',
            'هلال'      => 'Hilal',
            'راشد'      => 'Rashid',
            'رشيد'      => 'Rashid',
            'حسان'      => 'Hassan',
            'بشير'      => 'Bashir',
            'عمير'      => '`Umayr', // Could be `Ameer also?
            'حكيم'      => 'Hakim',
            'طاهر'      => 'Tahir',
            'عوف'       => '`Awf',
            'أمية'      => 'Umayya',
            'مهران'     => 'Mihran', // Persian; vowelization uncertain
            'قاسم'      => 'Qasim',
            'عقبة'      => '`Uqba',
            'سنان'      => 'Sinan',
            'سليم'      => 'Sulaym',
            'عدي'       => '`Adi',
            'أبان'      => 'Aban',
            'معاذ'      => 'Mu`adh',
            'عمار'      => '`Ammar',
            'حيان'      => 'Hayyan',
            'مخلد'      => 'Makhlad', 
            'ثعلبة'     => 'Tha`laba',
            'رافع'      => 'Rafi`',
            'أسد'       => 'Asad',
            'فضل'       => 'Fadl',
            'تميم'      => 'Tamim',
            'حرب'       => 'Harb',
            'طالب'      => 'Talib',
            'دينار'     => 'Dinar',
            'سويد'      => 'Suwayd',
            'حامد'      => 'Hamid',
            'عطية'      => '`Atiyya',
            'غالب'      => 'Ghalib',
            'يسار'      => 'Yasar',
            'عتبة'      => '`Utba',
            'زهير'      => 'Zuhayr',
            'عمارة'     => '`Umara',
            'حمدان'     => 'Hamdan',
            'مصعب'      => 'Mus`ab',
            // 'سلام'      => 'Sallam', // uncertain; could be Salam
            // 'عقيل'      => '`Aqil', // Could be `Uqayl
            'سلامة'     => 'Salama', // different spelling from سلمة, same transliteration
            'صدقة'      => 'Sadaqa', // vowelization uncertain
            'نوح'       => 'Nuh',
            'نعيم'      => 'Nu`aym',
            'رجاء'      => "Raja'",
            'عبيدة'     => '`Ubayda',
            'قدامة'     => 'Qudama',
            'مرة'       => 'Murra', // tashdid on r uncertain
            'سلمان'     => 'Salman',
            'أوس'       => 'Aws',
            'جرير'      => 'Jarir',
            'جبير'      => 'Jubayr',
            'حارث'      => 'Harith',
            'بلال'      => 'Bilal',
            'عون'       => '`Awn',
            'عياش'      => '`Ayyash',
            'شداد'      => 'Shaddad',
            'هانئ'      => "Hani'",
            'جميل'      => 'Jamil',
            'معبد'      => 'Ma`bad',
            'بكار'      => 'Bakkar',
            'ميسرة'     => 'Maysara',
            'وليد'      => 'Walid',
            'حارثة'     => 'Haritha',
            'يعلى'      => 'Ya`la',
            'علقمة'     => '`Alqama',
            'مهدي'      => 'Mahdi',
            'سيار'      => 'Sayyar',
            'واقد'      => 'Waqid',
            'حصين'      => 'Husayn',
            'عياض'      => '`Iyad',
            'فضالة'     => 'Fadala',
            'مكي'       => 'Makki',
            'أسيد'      => 'Usayd',
            'خليفة'     => 'Khalifa',
            'سيف'       => 'Sayf',
            'مسلمة'     => 'Maslama',
            'أسعد'      => 'As`ad',
            'سلم'       => 'Salm',
            'بندار'     => 'Bundar',
            'أسلم'      => 'Aslam',
            // 'صبيح'      => 'Sabih', // uncertain; could be Subayh
            'بدر'       => 'Badr',
            'بحر'       => 'Bahr',
            'شيبة'      => 'Shayba',
            //'بكير'      => 'Bukayr', // could be Bakeer?
            'حازم'      => 'Hazim',
            'خزيمة'     => 'Khuzayma',
            // 'شبيب'      => 'Shabib', // Shubayb?
            'إياس'      => 'Iyas',
            'عبادة'     => '`Ubada',
            'معروف'     => 'Ma`ruf',
            'شجاع'      => 'Shuja`',
            'تمام'      => 'Tammam',
            'حنظلة'     => 'Hanzala',
            'مرزوق'     => 'Marzuq',
            'جبلة'      => 'Jabala',
            'خليل'      => 'Khalil',
            'كيسان'     => 'Kaysan',
            'أسامة'     => 'Usama',
            'شريح'      => 'Shurayh',
            'نوفل'      => 'Nawfal',
            'كامل'      => 'Kamil',
            'حمد'       => 'Hamd',
            'مناف'      => 'Manaf',
            'بيان'      => 'Bayan',
            'حبان'      => 'Hibban',
            'حكم'       => 'Hakam',
            'شيبان'     => 'Shayban',
            'كلاب'      => 'Kilab',
            'واصل'      => 'Wasil',
            'خلاد'      => 'Khallad',
            'فارس'      => 'Faris',
            'همام'      => 'Hammam',
            'صخر'       => 'Sakhr',
            'غسان'      => 'Ghassan',
            'رفاعة'     => 'Rifa`a',
            'سهيل'      => 'Suhayl',
            'سوار'      => 'Sawwar', // uncertain; could be Suwar
            'عصام'      => '`Isam',
            'عنبسة'     => '`Anbasa',
            'محرز'      => 'Muhriz',
            'عتاب'      => '`Attab',
            'شرحبيل'    => 'Sharhabil',
            'عبدة'      => '`Abda',
            'معدان'     => 'Ma`dan',
            'طارق'      => 'Tariq',
            'ذكوان'     => 'Dhakwan',
            'رباح'      => 'Rabah',
            'معقل'      => 'Ma`qal',
            'ربه'       => 'Rabbihi', // possessive "his Lord," as in `Abd Rabbihi
            'رزين'      => 'Razin',
            'عائذ'      => "`A'idh",
            'فروة'      => 'Farwa',
            'غياث'      => 'Ghiyath',
            'مبارك'     => 'Mubarak',
            'حريث'      => 'Hurayth',
            'شاذان'     => 'Shadhan',
            'طريف'      => 'Tarif',
            'عتيق'      => '`Atiq',
            'مخزوم'     => 'Makhzum',
            'عصمة'      => '`Isma',
            'عبدان'     => '`Abdan',
            'غنم'       => 'Ghanam',
            'ماهان'     => 'Mahan',
            'بسطام'     => 'Bistam', // Persian; vowelization uncertain
            'فروخ'      => 'Farrukh',
            'حذيفة'     => 'Hudhayfa',
            'زرعة'      => 'Zur`a',
            'غانم'      => 'Ghanim',
            'نجيح'      => 'Najih',
            'شمس'       => 'Shams',
            'مقاتل'     => 'Muqatil',
            'خارجة'     => 'Kharija',
            'قرة'       => 'Qurra',
            'بشار'      => 'Bashshar',
            'جندب'      => 'Jundub',
            'عميرة'     => '`Umayra',
            'مغيرة'     => 'Mughira',
            'هيثم'      => 'Haytham',
            'أسماء'     => "Asma'",
            'حجاج'      => 'Hajjaj',
            'سبرة'      => 'Sabra',
            'حرملة'     => 'Harmala',
            'عجلان'     => '`Ajlan',
            'مرثد'      => 'Marthad',
            'نصير'      => 'Nusayr',
            'حبيش'      => 'Hubaysh',
            'ربيع'      => 'Rabi`',
            'زريق'      => 'Zurayq',
            'كليب'      => 'Kulayb',
            'زرارة'     => 'Zurara',
            'غيلان'     => 'Ghaylan',
            'مريم'      => 'Maryam',
            'صهيب'      => 'Suhayb',
            'عبدوس'     => '`Abdus',
            'مدرك'      => 'Mudrik',
            'هند'       => 'Hind',
            'أشعث'      => 'Ash`ath',
            'أزهر'      => 'Azhar',
            'جارية'     => 'Jariya',
            'قتيبة'     => 'Qutayba',
            'مكرم'      => 'Mukram',
            'مظفر'      => 'Muzaffar',
            'قصي'       => 'Qusayy',
            'هبيرة'     => 'Hubayra',
            'خويلد'     => 'Khuwaylid',
            'جنادة'     => 'Junada',
            'رزيق'      => 'Ruzayq', // vowelization uncertain
            'صعصعة'     => 'Sa`sa`a',
            'مجاهد'     => 'Mujahid',
            'محفوظ'     => 'Mahfuz',
            'أعين'      => 'A`yan',
            'سعدان'     => 'Sa`dan',
            'كلثوم'     => 'Kulthum',
            'صاعد'      => 'Sa`id',
            'حرام'      => 'Haram',
            'فيروز'     => 'Fayruz',
            'ناجية'     => 'Najiya',
            'علاء'      => "`Ala'",
            'ناصر'      => 'Nasir',
            'وائل'      => "Wa'il",
            'جامع'      => 'Jami`',
            // Additional nisbas from frequency data
            'العزيز'    => 'al-`Aziz',
            'الملك'     => 'al-Malik',
            'الواحد'    => 'al-Wahid',
            'البغدادي'  => 'al-Baghdadi',
            'الأصبهاني' => 'al-Asbahani',
            'الوهاب'    => 'al-Wahhab',
            'الحميد'    => 'al-Hamid',
            'الأزدي'    => 'al-Azdi',
            'الثقفي'    => 'al-Thaqafi',
            'الرحيم'    => 'al-Rahim',
            'الكريم'    => 'al-Karim',
            'النيسابوري' => 'al-Naysaburi',
            'الواسطي'   => 'al-Wasiti',
            'الصمد'     => 'al-Samad',
            'الجبار'    => 'al-Jabbar',
            'العبدي'    => 'al-`Abdi',
            'المقرئ'    => "al-Muqri'",
            'المطلب'    => 'al-Muttalib',
            'الكندي'    => 'al-Kindi',
            'النضر'     => 'al-Nadr',
            'المنذر'    => 'al-Mundhir',
            'الحضرمي'   => 'al-Hadrami',
            'الأسود'    => 'al-Aswad',
            'البلخي'    => 'al-Balkhi',
            'الشيباني'  => 'al-Shaybani',
            'البجلي'    => 'al-Bajali',
            'القاضي'    => 'al-Qadi',
            'الباهلي'   => 'al-Bahili',
            'الفرج'     => 'al-Faraj',
            'التيمي'    => 'al-Taymi',
            'القزويني'  => 'al-Qazwini',
            'الرزاق'    => 'al-Razzaq',
            'المقدسي'   => 'al-Maqdisi',
            'البزاز'    => 'al-Bazzaz',
            'الجرجاني'  => 'al-Jurjani',
            'الجهني'    => 'al-Juhani',
            'الطائي'    => "al-Ta'i",
            'الحراني'   => 'al-Harrani',
            'الضبي'     => 'al-Dabbi',
            'البخاري'   => 'al-Bukhari',
            'المزني'    => 'al-Muzani',
            'الأسلمي'   => 'al-Aslami',
            'الفتح'     => 'al-Fath',
            'الفارسي'   => 'al-Farisi',
            'العاص'     => 'al-`As',
            'الضحاك'    => 'al-Dahhak',
            'الوراق'    => 'al-Warraq',
            'الموصلي'   => 'al-Mawsili',
            'الصلت'     => 'al-Salt',
            'العدوي'    => 'al-`Adawi',
            'العامري'   => 'al-`Amiri',
            'العطار'    => 'al-`Attar',
            'السائب'    => "al-Sa'ib",
            'الخضر'     => 'al-Khidr',
            'العجلي'    => 'al-`Ijli',
            'المنعم'    => 'al-Mun`im',
            'الفزاري'   => 'al-Fazari',
            'السري'     => 'al-Sari',
            'السعدي'    => 'al-Sa`di',
            'الليث'     => 'al-Layth',
            'الهمذاني'  => 'al-Hamadhani',
            'الصباح'    => 'al-Sabah',
            'الغفار'    => 'al-Ghaffar',
            'الأعلى'    => 'al-A`la',
            'الرقي'     => 'al-Raqqi',
            'الحلبي'    => 'al-Halabi',
            'الخالق'    => 'al-Khaliq',
            'المؤمن'    => "al-Mu'min",
            'المثنى'    => 'al-Muthanna',
            'العزى'     => 'al-`Uzza',
            'الصوفي'    => 'al-Sufi',
            'العوام'    => 'al-`Awwam',
            'القادر'    => 'al-Qadir',
            'الباقي'    => 'al-Baqi',
            'العلوي'    => 'al-`Alawi',
            'الجعفي'    => 'al-Ju`fi',
            'الحمصي'    => 'al-Himsi',
            'الدينوري'  => 'al-Daynuri',
            'النخعي'    => 'al-Nakha`i',
            'السدوسي'   => 'al-Sadusi',
            'اللخمي'    => 'al-Lakhmi',
            'الكاتب'    => 'al-Katib',
            'الحجازي'   => 'al-Hijazi',
            'المحسن'    => 'al-Muhsin',
            'الهذلي'    => 'al-Hudhali',
            'العسكري'   => 'al-`Askari',
            'الجزري'    => 'al-Jazari',
            'العنبري'   => 'al-`Anbari',
            'الصفار'    => 'al-Saffar',
            'التستري'   => 'al-Tustari',
            'التنوخي'   => 'al-Tanukhi',
            'الرملي'    => 'al-Ramli',
            'الجوهري'   => 'al-Jawhari',
            'العبسي'    => 'al-`Absi',
            'الكلبي'    => 'al-Kalbi',
            'الغفاري'   => 'al-Ghifari',
            'المؤدب'    => "al-Mu'addib",
            'الطوسي'    => 'al-Tusi',
            'البزار'    => 'al-Bazzar',
            'المهاجر'   => 'al-Muhajir',
            'الكناني'   => 'al-Kinani',
            'الأشعري'   => 'al-Ash`ari',
            'السكن'     => 'al-Sakan',
            'الطبري'    => 'al-Tabari',
            'الصيرفي'   => 'al-Sayrafi',
            'المازني'   => 'al-Mazini',
            'الأندلسي'  => 'al-Andalusi',
            'الشيرازي'  => 'al-Shirazi',
            'القرطبي'   => 'al-Qurtubi',
            'المصيصي'   => 'al-Masisi',
            'الأنصارية' => 'al-Ansariyya',
            'الخولاني'  => 'al-Khawlani',
            'الأشجعي'   => 'al-Ashja`i',
            'الجمحي'    => 'al-Jumahi',
            'الدقاق'    => 'al-Daqqaq',
            'الغني'     => 'al-Ghani',
            'المؤمل'    => "al-Mu'ammal",
            'المجيد'    => 'al-Majid',
            'الجراح'    => 'al-Jarrah',
            'العقيلي'   => 'al-`Uqayli',
            'المفضل'    => 'al-Mufaddal',
            'اليمامي'   => 'al-Yamami',
            'الخزرج'    => 'al-Khazraj',
            'السرخسي'   => 'al-Sarakhsi',
            'الغساني'   => 'al-Ghassani',
            'العنزي'    => 'al-`Anazi',
            'المؤذن'    => "al-Mu'adhdhin",
            'القاهر'    => 'al-Qahir',
            'المهلب'    => 'al-Muhallab',
            'الكلابي'   => 'al-Kilabi',
            'الأنماطي'  => 'al-Anmati',
            'البعلبكي'  => 'al-Ba`lbakki',
            'الفرات'    => 'al-Furat',
            'المعافري'  => 'al-Ma`afiri',
            'اليماني'   => 'al-Yamani',
            'الأنطاكي'  => 'al-Antaki',
            'الجهم'     => 'al-Jahm',
            'الأنباري'  => 'al-Anbari',
            'الفضيل'    => 'al-Fudayl',
            'المعدل'    => 'al-Mu`addal',
            'الصالحي'   => 'al-Salihi',
            'السلام'    => 'al-Salam',
            'النعمان'   => 'al-Nu`man',
            'المنكدر'   => 'al-Munkadir',
        ];
    }

    private static function getCharMap(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        return $map = [
            'ب' => 'b',  'ت' => 't',  'ث' => 'th', 'ج' => 'j',  'ح' => 'h',  'خ' => 'kh',
            'د' => 'd',  'ذ' => 'dh', 'ر' => 'r',  'ز' => 'z',  'س' => 's',  'ش' => 'sh',
            'ص' => 's',  'ض' => 'd',  'ط' => 't',  'ظ' => 'z',  'ع' => '`a',  'غ' => 'gh',
            'ف' => 'f',  'ق' => 'q',  'ك' => 'k',  'ل' => 'l',  'م' => 'm',  'ن' => 'n',
            'ه' => 'h',  'و' => 'w',  'ي' => 'y',  'ة' => 'a',
            'ء' => "'",  'ئ' => "'",  'ؤ' => "'",
            'ا' => 'a',  'أ' => 'a',  'إ' => 'i',  'آ' => 'a',
        ];
    }

    /**
     * Transliterates an Arabic name string to simplified Latin script.
     *
     * Uses a two-tier approach: word-level dictionary for known names and
     * nisbas, with a character-level consonant map as fallback. No diacritical
     * marks are added (simplified IJMES). Structural particles (ibn, bint,
     * Abu, etc.) are handled explicitly.
     *
     * @param  string $arabicText  Raw Arabic text (tashkeel allowed; stripped internally)
     * @return string
     */
    public static function transliterateArabicName(string $arabicText): string
    {
        // Strip tashkeel (U+0610–U+061A, U+064B–U+065F) and tatweel (U+0640)
        $text = preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0640}]/u', '', $arabicText);
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        $wordDict = self::getWordDict();

        $words = preg_split('/\s+/u', $text);
        $n     = count($words);
        $out   = [];

        for ($i = 0; $i < $n; $i++) {
            $w = $words[$i];

            // Structural particles
            if ($w === 'بن' || $w === 'ابن') { $out[] = 'ibn';   continue; }
            if ($w === 'بنت')                 { $out[] = 'bint';  continue; }
            if ($w === 'أبو')                 { $out[] = 'Abu';   continue; }
            if ($w === 'أبي')                 { $out[] = 'Abi';   continue; }
            if ($w === 'مولى')                { $out[] = 'mawla'; continue; }
            if ($w === 'ذو')                  { $out[] = 'Dhu';   continue; }
            if ($w === 'أم')                  { $out[] = 'Umm';   continue; }

            // عبد compound: peek ahead when followed by ال-word
            if ($w === 'عبد' && $i + 1 < $n && str_starts_with($words[$i + 1], 'ال')) {
                $next = $words[$i + 1];
                $stem = mb_substr($next, 2);
                if (isset($wordDict[$next])) {
                    $out[] = '`Abd ' . $wordDict[$next];
                } elseif (isset($wordDict[$stem])) {
                    $out[] = '`Abd al-' . $wordDict[$stem];
                } else {
                    $out[] = '`Abd al-' . self::ucfirstTranslit(self::transliterateWord($stem));
                }
                $i++;
                continue;
            }

            // Word-level dictionary
            if (isset($wordDict[$w])) {
                $out[] = $wordDict[$w];
                continue;
            }

            // Strip leading ال: try stem in dict (auto-prefix al-), else char-level
            if (str_starts_with($w, 'ال')) {
                $stem = mb_substr($w, 2);
                if (isset($wordDict[$stem])) {
                    $out[] = 'al-' . $wordDict[$stem];
                } else {
                    $out[] = 'al-' . self::ucfirstTranslit(self::transliterateWord($stem));
                }
                continue;
            }

            // Character-level fallback
            $out[] = self::transliterateWord($w);
        }

        // Capitalise first token and tokens following relational particles
        $capitalizeNext   = true;
        $particleTriggers = ['ibn', 'bint', 'mawla', 'dhu', 'abu', 'abi', 'umm'];
        for ($i = 0, $count = count($out); $i < $count; $i++) {
            $lower = mb_strtolower($out[$i]);
            if ($capitalizeNext && !str_starts_with($out[$i], 'al-')) {
                $out[$i] = self::ucfirstTranslit($out[$i]);
            }
            $capitalizeNext = in_array($lower, $particleTriggers);
        }

        return implode(' ', $out);
    }

    /**
     * Capitalises the first meaningful character of a transliterated token.
     * Tokens beginning with ` (ayn) or ' (hamza) have their second character
     * capitalised instead, since the punctuation mark is not a letter.
     */
    private static function ucfirstTranslit(string $s): string
    {
        if ($s === '') {
            return $s;
        }
        $first = mb_substr($s, 0, 1);
        if (($first === '`' || $first === "'") && mb_strlen($s) > 1) {
            return $first . mb_strtoupper(mb_substr($s, 1, 1)) . mb_substr($s, 2);
        }
        return mb_strtoupper($first) . mb_substr($s, 1);
    }

    /**
     * Character-level transliteration fallback for a single Arabic word.
     * Maps consonants via CHAR_MAP; collapses consecutive identical special
     * chars (ayn/hamza); strips trailing ayn/hamza.
     */
    private static function transliterateWord(string $word): string
    {
        $charMap  = self::getCharMap();
        $chars    = mb_str_split($word);
        $last     = count($chars) - 1;
        $result   = '';
        $prev     = '';
        foreach ($chars as $i => $ch) {
            // Word-final ي is a long-i vowel, not the consonant y
            $mapped = ($ch === 'ي' && $i === $last) ? 'i' : ($charMap[$ch] ?? $ch);
            // Collapse consecutive identical ayn or hamza
            if ($mapped === $prev && ($mapped === '`' || $mapped === "'")) {
                continue;
            }
            $result .= $mapped;
            $prev    = $mapped;
        }
        return rtrim($result, "`'");
    }

    // ──────────────────────────────────────── JARH & TA'DIL TRANSLATION

    /**
     * Lookup map of Arabic jarh_tadil phrases → curated English translations.
     * Keys are plain Arabic (no tashkeel). Covers all terms with frequency ≥ 3
     * from the acquisition dataset.
     */
    private static function getJarhTadilMap(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        return $map = [
            'مجهول الحال'                              => 'Unknown Status',
            'ثقة'                                      => 'Trustworthy',
            'مقبول'                                    => 'Acceptable',
            'صدوق حسن الحديث'                         => 'Truthful, Good Hadith',
            'صحابي'                                    => 'Companion',
            'مجهول'                                    => 'Unknown',
            'ضعيف الحديث'                              => 'Weak in Hadith',
            'متروك الحديث'                             => 'Abandoned in Hadith',
            'انفرد بتوثيقه ابن حبان'                  => 'Deemed Trustworthy by Ibn Hibban Alone',
            'متهم بالوضع'                              => 'Accused of Fabrication',
            'منكر الحديث'                              => 'Denounced in Hadith',
            'ثقة حافظ'                                 => 'Trustworthy, Expert',
            'ثقة ثبت'                                  => 'Trustworthy, Firm',
            'متهم بالكذب'                              => 'Accused of Lying',
            'ثقة مأمون'                                => 'Trustworthy, Reliable',
            'كذاب'                                     => 'Liar',
            'مختلف في صحبته'                           => 'Disputed Companionship',
            'صدوق يخطئ'                                => 'Truthful, Makes Errors',
            'يضع الحديث'                               => 'Fabricates Hadith',
            'ثقة إمام'                                 => 'Trustworthy, Imam',
            'له رؤية'                                  => 'Has Sight',
            'ثقة متقن'                                 => 'Trustworthy, Precise',
            'صحابية'                                   => 'Companion',
            'وضاع'                                     => 'Fabricator',
            'صحابي صغير'                               => 'Young Companion',
            'ثقة حجة'                                  => 'Trustworthy, Authority',
            'صدوق يهم'                                 => 'Truthful, Prone to Error',
            'صدوق له أوهام'                            => 'Truthful, Has Errors',
            'له إدراك'                                 => 'Has Perception',
            'متهم'                                     => 'Accused',
            'مجهولة الحال'                             => 'Unknown Status',
            'لم تثبت له صحبة'                          => 'Companionship Not Established',
            'ثقة محدث'                                 => 'Trustworthy, Hadith Scholar',
            'ثقة ثقة'                                  => 'Doubly Trustworthy',
            'صدوق رمي بالتشيع'                         => "Truthful, Accused of Shi'ism",
            'ثقة صدوق'                                 => 'Trustworthy, Truthful',
            'صدوق يغرب'                                => 'Truthful, Produces Rare Narrations',
            'متروك متهم بالكذب'                        => 'Abandoned, Accused of Lying',
            'مخضرم'                                    => 'Straddles Both Eras',
            'صدوق كثير الخطأ'                          => 'Truthful, Frequent Errors',
            'صدوق رمي ببدعة'                           => 'Truthful, Accused of Innovation',
            'صدوق'                                     => 'Truthful',
            'حافظ ثقة'                                 => 'Expert, Trustworthy',
            'ثقة حافظ إمام'                            => 'Trustworthy, Expert, Imam',
            'صدوق يتشيع'                               => "Truthful, Inclines to Shi'ism",
            'صدوق سيء الحفظ'                          => 'Truthful, Poor Memory',
            'ثقة إمام حافظ'                            => 'Trustworthy, Imam, Expert',
            'ثقة أمين'                                 => 'Trustworthy, Faithful',
            'إمام حجة'                                 => 'Imam, Authority',
            'صدوق فيه لين'                             => 'Truthful, Some Weakness',
            'صدوق رمي بالقدر'                          => 'Truthful, Accused of Qadarism',
            'صدوق ربما وهم'                            => 'Truthful, Occasionally Errs',
            'كذاب خبيث'                                => 'Liar, Wicked',
            'حافظ ثبت'                                 => 'Expert, Firm',
            'يكذب'                                     => 'Lies',
            'صدوق تغير بآخره'                          => 'Truthful, Deteriorated Later',
            'ثقة مخضرم'                                => 'Trustworthy, Straddles Both Eras',
            'ثقة يرسل'                                 => 'Trustworthy, Makes Mursal Narrations',
            'ثقة فاضل'                                 => 'Trustworthy, Virtuous',
            'ثقة ضابط'                                 => 'Trustworthy, Precise',
            'متهم بالكذب والوضع'                       => 'Accused of Lying, Fabrication',
            'كذاب وضاع'                                => 'Liar, Fabricator',
            'صدوق رمي بالإرجاء'                        => "Truthful, Accused of Irja'",
            'متروك متهم بالوضع'                        => 'Abandoned, Accused of Fabrication',
            'ثقة له أفراد'                             => 'Trustworthy, Has Unique Narrations',
            'صدوق سيئ الحفظ'                          => 'Truthful, Poor Memory',
            'صدوق يخطئ كثيرا'                          => 'Truthful, Frequent Errors',
            'مختلف في صحبتها'                          => 'Disputed Companionship',
            'ثقة ثبت فاضل'                             => 'Trustworthy, Firm, Virtuous',
            'ثقة صالح'                                 => 'Trustworthy, Righteous',
            'مقبولة'                                   => 'Acceptable',
            'كذاب يضع الحديث'                          => 'Liar, Fabricates Hadith',
            'ضعيف'                                     => 'Weak',
            'صدوق يهم كثيرا'                           => 'Truthful, Frequently Errs',
            'ثبت حافظ'                                 => 'Firm, Expert',
            'ثقة حافظ ثبت'                             => 'Trustworthy, Expert, Firm',
            'صدوق يخطىء'                               => 'Truthful, Makes Errors',
            'ثقة حافظ مصنف'                            => 'Trustworthy, Expert, Author',
            'صدوق اختلط بآخره'                         => 'Truthful, Became Confused Later',
            'ثقة رمي بالنصب'                           => 'Trustworthy, Accused of Nasb',
            'ثقة حافظ حجة'                             => 'Trustworthy, Expert, Authority',
            'صدوق ربما أخطأ'                           => 'Truthful, Occasionally Makes Errors',
            'مختلف في صحبته ، والراجح أنه تابعي'       => 'Disputed Companionship, Likely a Successor',
            'صدوق له غرائب'                            => 'Truthful, Has Rare Narrations',
            'ثقة حافظ فقيه'                            => 'Trustworthy, Expert, Jurist',
            'إمام حافظ'                                => 'Imam, Expert',
            'متهم بوضع الحديث'                         => 'Accused of Fabricating Hadith',
            'حافظ متقن'                                => 'Expert, Precise',
            'الفقيه الحافظ متفق على جلالته وإتقانه'     => 'Jurist, Expert — Consensus on Eminence & Precision',
            'حافظ'                                     => 'Expert',
            'ضعف الحديث'                               => 'Weak, Hadith',
            'مختلف في صحبته ، والراجح أنه تابعي ضعيف الحديث' => 'Disputed Companionship, Likely a Successor, Weak in Hadith',
            'ثقة فقيه حافظ'                            => 'Trustworthy, Jurist, Memorizer',
            'صدوق ساء حفظه'                            => 'Truthful, Memory Deteriorated',
            'ثقة رمي بالإرجاء'                         => "Trustworthy, Accused of Irja'",
            'أحد الحفاظ'                               => 'One of the Memorizers',
            'صدوق كثير الإرسال'                        => 'Truthful, Frequent Mursal Narrations',
            'ثقة مدلس'                                 => 'Trustworthy, Practices Tadlis',
            'مختلف في صحبته ، والراجح أنه تابعي ثقة'  => 'Disputed Companionship, Likely a Trustworthy Successor',
            'مختلف في صحبته ، والأكثر أنه صحابي'      => 'Disputed Companionship, More Likely a Companion',
            'ثقة يحفظ'                                 => 'Trustworthy, Good Memory',
            'صحابية صغيرة'                             => 'Young Companion',
            'ثقة رمي بالقدر'                           => 'Trustworthy, Accused of Qadarism',
            'ثقة حافظ متقن'                            => 'Trustworthy, Memorizer, Precise',
            'صدوق اختلط بأخرة'                         => 'Truthful, Became Confused Later',
            'لها إدراك'                                => 'Has Perception',
            'لها رؤية'                                 => 'Has Sight',
            'ثقة رمي بالتشيع'                          => "Trustworthy, Accused of Shi'ism",
            'صدوق يغلط'                                => 'Truthful, Makes Mistakes',
            'لم يثبت له صحبة'                          => 'Companionship Not Established',
            'ثقة وكان يدلس كثيرا'                      => 'Trustworthy, Practiced Frequent Tadlis',
            'ثقة مكثر'                                 => 'Trustworthy, Prolific Narrator',
            'ثقة يدلس'                                 => 'Trustworthy, Practices Tadlis',
            'صدوق مدلس'                                => 'Truthful, Practices Tadlis',
            'ثقه'                                      => 'Trustworthy',
            'ثقة حافظ أمين'                            => 'Trustworthy, Memorizer, Faithful',
            'ثقة عارف'                                 => 'Trustworthy, Knowledgeable',
            'ثقة ثبت حافظ'                             => 'Trustworthy, Firm, Memorizer',
            'ثقة فقيه وكان يرسل'                       => 'Trustworthy, Jurist, Made Mursal Narrations',
            'لين الحديث'                               => 'Some Weakness in Hadith',
            'ثقة ثبت إمام'                             => 'Trustworthy, Firm, Imam',
            'ثقة حافظ نبيل'                            => 'Trustworthy, Memorizer, Noble',
            'وضاع كذاب'                                => 'Fabricator, Liar',
            'صدوق فيه تشيع'                            => "Truthful, Has Shi'ite Leanings",
            'صدوق يخطئ ويخالف'                         => 'Truthful, Makes Errors, Contradicts',
            'متهم بالوصع'                              => 'Accused of Fabrication',
            'إمام ثقة'                                 => 'Imam, Trustworthy',
            'ثقة إمام حجة'                             => 'Trustworthy, Imam, Authority',
            'ثقة مسند'                                 => 'Trustworthy, Transmitter',
            'صدوق تغير بآخرة'                          => 'Truthful, Deteriorated Later',
            'صدوق اختلط'                               => 'Truthful, Became Confused',
            'رأس المتقنين وكبير المتثبتين'             => 'Chief of the Precise and Meticulous',

        ];
    }

    /**
     * Maps a numeric reliability_grade (1–12) to a CSS tier token used on the
     * pill-grade element. Returns 'neutral' for out-of-range values.
     *
     * Tier colour intent:
     *   grade-1 (1–3)  : dark green   — strongest acceptance
     *   grade-2 (4–6)  : light green  — accepted
     *   grade-3 (7)    : yellow       — middling
     *   grade-4 (8–10) : amber-red    — weak / criticised
     *   grade-5 (11–12): dark red     — rejected
     *
     * @param  int $grade  reliability_grade value from DB
     * @return string
     */
    public static function getReliabilityGradeTier(int $grade): string
    {
        if ($grade >= 1  && $grade <= 3)  return 'grade-1';
        if ($grade >= 4  && $grade <= 6)  return 'grade-2';
        if ($grade === 7)                 return 'grade-3';
        if ($grade >= 8  && $grade <= 10) return 'grade-4';
        if ($grade >= 11 && $grade <= 12) return 'grade-5';
        return 'neutral';
    }

    public static function translateJarhTadil(string $arabic): string
    {
        $stripped = trim(preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0640}]/u', '', $arabic));
        $map      = self::getJarhTadilMap();
        return $map[$stripped] ?? self::transliterateArabicName($arabic);
    }

    // ────────────────────────────────────────── RESIDENCE TRANSLATION

    /**
     * Lookup map of Arabic residence values → English names.
     * Keys are plain Arabic (no tashkeel). Covers all cities with frequency ≥ 5
     * from the acquisition dataset.
     */
    private static function getResidenceMap(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        return $map = [
            'بغداد'               => 'Baghdad',
            'دمشق'                => 'Damascus',
            'البصرة'              => 'Basra',
            'الكوفة'              => 'Kufa',
            'المدينة'             => 'Madina',
            'مصر'                 => 'Egypt',
            'الشام'               => 'al-Sham',
            'أصبهان'              => 'Isfahan',
            'نيسابور'             => 'Nishapur',
            'مكة'                 => 'Makka',
            'مرو'                 => 'Merv',
            'الحجاز'              => 'Hijaz',
            'الري'                => 'al-Rayy',
            'واسط'                => 'Wasit',
            'حمص'                 => 'Homs',
            'خراسان'              => 'Khurasan',
            'جرجان'               => 'Jurjan',
            'قزوين'               => 'Qazvin',
            'هراة'                => 'Herat',
            'حلب'                 => 'Aleppo',
            'العراق'              => 'Iraq',
            'بخارى'               => 'Bukhara',
            'حران'                => 'Harran',
            'الموصل'              => 'Mosul',
            'اليمن'               => 'Yemen',
            'الرقة'               => 'Raqqa',
            'حضرموت'              => 'Hadramawt',
            'الجزيرة'             => 'al-Jazira',
            'الرملة'              => 'Ramla',
            'قرطبة'               => 'Córdoba',
            'الإسكندرية'          => 'Alexandria',
            'الأندلس'             => 'al-Andalus',
            'القدس'               => 'Jerusalem',
            'صنعاء'               => 'Sanaa',
            'اليمامة'             => 'Yamama',
            'القاهرة'             => 'Cairo',
            'المصيصة'             => 'al-Massisa',
            'سر من رأى'           => 'Samarra',
            'بلخ'                 => 'Balkh',
            'طرسوس'               => 'Tarsus',
            'صور'                 => 'Tyre',
            'طوس'                 => 'Tus',
            'المدائن'             => "al-Mada'in",
            'سمرقند'              => 'Samarkand',
            'الأهواز'             => 'Ahwaz',
            'بلاد فارس'           => 'Persia',
            'بعلبك'               => 'Baalbek',
            'أنطاكيا'             => 'Antakya',
            'عسقلان'              => 'Asqalan',
            'نسا'                 => 'Nisa',
            'فلسطين'              => 'Palestine',
            'سرخس'                => 'Sarakhs',
            'بيروت'               => 'Beirut',
            'الأنبار'             => 'Anbar',
            'طبرستان'             => 'Tabaristan',
            'شيراز'               => 'Shiraz',
            'تجيب'                => 'Tujib',
            'تستر'                => 'Tustar',
            'أطرابلس'             => 'Tripoli',
            'القيس'               => 'al-Qays',
            'دينور'               => 'Dinawar',
            'خوارزم'              => 'Khwarazm',
            'نصيبين'              => 'Nisibis',
            'عسكر'                => 'Askar',
            'زبيد'                => 'Zabid',
            'تنيس'                => 'Tinnis',
            'طبرية'               => 'Tiberias',
            'كرمان'               => 'Kirman',
            'صيدا'                => 'Sidon',
            'أيلة'                => 'Ayla',
            'عكبرا'               => 'Ukbara',
            'سجستان'              => 'Sijistan',
            'داريا'               => 'Daraya',
            'إفريقية'             => 'Ifriqiya',
            'بيت المقدس'          => 'Jerusalem',
            'حماة'                => 'Hama',
            'الأردن'              => 'Jordan',
            'الثغر'               => 'al-Thaghr',
            'الحربية'             => 'al-Harbiyya',
            'الكرخ'               => 'Karkh',
            'زرق'                 => 'Zarq',
            'فارس'                => 'Fars',
            'ترمذ'                => 'Tirmidh',
            'القيروان'            => 'Qayrawan',
            'حلوان'               => 'Hulwan',
            'إشبيلية'             => 'Seville',
            'إربل'                => 'Erbil',
            'بلاد الروم'          => 'Byzantine Lands',
            'همدان'               => 'Hamadan',
            'سامراء'              => 'Samarra',
            'مرو الروذ'           => 'Marw al-Ruz',
            'المغرب'              => 'Al-Maghrib',
            'الدينور'             => 'Dinawar',
            'نهاوند'              => 'Nahavand',
            'الطائف'              => "Ta'if",
            'رحبة'                => 'Rahba',
            'المرية'              => 'Almería',
            'الكرج'               => 'Karaj',
            'بجيلة'               => 'Bajila',
            'عبادان'              => 'Abadan',
            'الدور'               => 'al-Dur',
            'بنانة'               => 'Banana',
            'ختلان'               => 'Khuttal',
            'الرصافة'             => 'Rusafa',
            'نابلس'               => 'Nablus',
            'حدان'                => 'Hadan',
            'عكا'                 => 'Acre',
            'أبهر'                => 'Abhar',
            'غرناطة'              => 'Granada',
            'أذنة'                => 'Adana',
            'كندى'                => 'Kinda',
            'طالقان'              => 'Taliqan',
            'الزعفرانية'          => "al-Za'faraniyya",
            'منبج'                => 'Manbij',
            'أبلة'                => 'Ubulla',
            'ملطية'               => 'Malatya',
            'رأس العين'           => "Ra's al-'Ayn",
            'غزة'                 => 'Gaza',
            'سوسة'                => 'Sousse',
            'المخرم'              => 'al-Mukharrim',
            'فرغانة'              => 'Fergana',
            'حجر'                 => 'Hajar',
            'نهروان'              => 'Nahrawan',
            'طرابلس'              => 'Tripoli',
            'بلنسية'              => 'Valencia',
            'عمان'                => 'Oman',
            'بسطام'               => 'Bistam',
            'القنطرة'             => 'al-Qantara',
            'الديلم'              => 'Daylam',
            'دمياط'               => 'Damietta',
            'بلاد المغرب'         => 'Al-Maghrib',
            'بيهق'                => 'Bayhaq',
            'سبتة'                => 'Ceuta',
            'جنديسابور'           => 'Jundishapur',
            'نوقان'               => 'Nawqan',
            'نسف'                 => 'Nasaf',
            'بالس'                => 'Balis',
            'جند'                 => 'Jund',
            'حمير'                => 'Himyar',
            'عسكر مكرم'           => 'Askar Mukram',
            'قرقيسيا'             => 'Circesium',
            'قار'                 => 'Qar',
            'ساوة'                => 'Saveh',
            'إسفرايين'            => 'Isfarayin',
            'إستراباذ'            => 'Astarabad',
            'مراكش'               => 'Marrakesh',
            'غافق'                => 'Ghafiq',
            'الأبلة'              => 'al-Ubulla',
            'دامغان'              => 'Damghan',
            'قم'                  => 'Qom',
            'القارة'              => 'al-Qara',
            'أبيورد'              => 'Abivard',
            'جبيل'                => 'Byblos',
            'الفسطاط'             => 'Fustat',
            'سرقسطة'              => 'Zaragoza',
            'الأسكندرية'          => 'Alexandria',
            'برقة'                => 'Barqa',
            'قومس'                => 'Qumis',
            'البحرين'             => 'Bahrain',
            'جمل'                 => 'Jamal',
            'طاحية'               => 'Tahiya',
            'ثور'                 => 'Thawr',
            'بيكند'               => 'Paykand',
            'دير العاقول'         => "Dayr al-Aqul",
            'طليطلة'              => 'Toledo',
            'خشين'                => 'Khushayn',
            'ذمار'                => 'Dhamar',
            'الجبل'               => 'al-Jabal',
            'النهروان'            => 'al-Nahrawan',
            'ما وراء النهر'       => 'Transoxiana',
            'بيت لهيا'            => 'Bayt Lahiya',
            'كرخ'                 => 'Karkh',
            'باب الشعير'          => "Bab al-Sha'ir",
            'الرها'               => 'Edessa',
            'كش'                  => 'Kesh',
            'القصر'               => 'al-Qasr',
            'جبلة'                => 'Jabala',
            'قنطرة الأشنان'       => 'Qantarat al-Ashnan',
            'زنجان'               => 'Zanjan',
            'الصالحية'            => 'al-Salihiyya',
            'الشاش'               => 'al-Shash',
            'سنجار'               => 'Sinjar',
            'قنسرين'              => 'Qinnasrin',
            'سامة'                => 'Sama',
            'فارياب'              => 'Faryab',
            'جرم'                 => 'Jurm',
            'قديد'                => 'Qudayd',
            'نرس'                 => 'Nars',
            'فسا'                 => 'Fasa',
            'همذان'               => 'Hamadan',
            'خوزستان'             => 'Khuzistan',
            'دار القطن'           => 'Dar al-Qutn',
            'جوين'                => 'Juwayn',
            'زوزن'                => 'Zawzan',
            'خرسان'               => 'Khurasan',
            'دنيسر'               => 'Dunaysir',
            'دشتك'                => 'Dashtaq',
            'آمل طبرستان'         => 'Amul, Tabaristan',
            'الهند'               => 'India',
            'شطا'                 => 'Shata',
            'بيت البلاط'          => 'Bayt al-Ballat',
            'الربذة'              => 'al-Rabadha',
            'كلواذي'              => 'Kalwadhiy',
            'المسامعة'            => 'al-Masamia',
            'البرمكية'            => 'al-Barmakiyya',
            'دولاب'               => 'Dulab',
            'رافقة'               => 'Rafiqa',
            'السند'               => 'Sind',
            'السوس'               => 'al-Sus',
            'إصطخر'               => 'Istakhr',
            'بوشنج'               => 'Pushang',
            'بست'                 => 'Bust',
            'خسروجرد'             => 'Khusrawjird',
            'غزنة'                => 'Ghazna',
            'باب الأزج'           => 'Bab al-Azaj',
            'حماه'                => 'Hama',
            'مرسية'               => 'Murcia',
            'شاطبة'               => 'Xàtiva',
            'مقرا'                => 'Maqra',
            'مأرب'                => 'Marib',
            'سمنان'               => 'Semnan',
            'الجيزة'              => 'Giza',
            'قهستان'              => 'Quhistan',
            'الجعفر'              => "al-Ja'far",
            'جونية'               => 'Junieh',
            'أسوارى'              => 'Aswara',
            'قيسارية'             => 'Caesarea',
            'توز'                 => 'Tuz',
            'أردبيل'              => 'Ardabil',
            'ميافارقين'           => 'Mayyafariqin',
            'طابران'              => 'Tabaran',
            'شيزار'               => 'Shayzar',
            'أذربيجان'            => 'Azerbaijan',
            'مالقة'               => 'Málaga',
            'جماعيل'              => "Jama'il",
            'المحلة'              => 'al-Mahalla',
            'بسر'                 => 'Busr',
            'عدن'                 => 'Aden',
            'نجران'               => 'Najran',
            'جهينة'               => 'Juhayna',
            'قباء'                => 'Quba',
            'الزبيرية'            => 'al-Zubayriyya',
            'سكة بني حرام'        => 'Sikkat Bani Haram',
            'فدك'                 => 'Fadak',
            'جوبر'                => 'Jawbar',
            'جرجرايا'             => 'Jarjaraya',
            'مهرجان'              => 'Mihrajan',
            'إخميم'               => 'Akhmim',
            'رشيد'                => 'Rosetta',
            'تفليس'               => 'Tiflis',
            'آمد'                 => 'Amid',
            'أرغيان'              => 'Arghiyan',
            'فامية'               => 'Apamea',
            'تونس'                => 'Tunis',
            'صقلية'               => 'Sicily',
            'الكرك'               => 'al-Karak',
            'دانية'               => 'Denia',
            'شعب الخوز'           => "Shi'b al-Khuz",
            'طريثيث'              => 'Turaysith',
            'بغشور'               => 'Baghshur',
            'قرميسين'             => 'Kermanshah',
            'الحبشة'              => 'Abyssinia',
            'مسلية'               => 'Masiliya',
            'وادي القرى'          => 'Wadi al-Qura',
            'وحاظة'               => 'Wahaza',
            'اللاذقية'            => 'Latakia',
            'جدة'                 => 'Jeddah',
            'العسكر'              => 'al-Askar',
            'طهران'               => 'Tehran',
            'المراغة'             => 'Maragha',
            'ميانج'               => 'Miyanaj',
            'يافا'                => 'Jaffa',
            'حوران'               => 'Hauran',
            'روذبار'              => 'Rudhbar',
            'أسداباذ'             => 'Asadabad',
            'يزد'                 => 'Yazd',
            'تبريز'               => 'Tabriz',
            'جزيرة صقلية'         => 'Sicily',
            'بيسان'               => 'Baysan',
            'الخليل'              => 'Hebron',
            'رويان'               => 'Ruyan',
            'مالين'               => 'Malin',
            'النيل'               => 'al-Nil',
            'أبزار'               => 'Abzar',
            'استراباذ'            => 'Astarabad',
            'جيل'                 => 'Jil',
            'عرقة'                => 'Arqa',
            'رامهرمز'             => 'Ramhormoz',
            'ميهنة'               => 'Mayhana',
            'طرطوس'               => 'Tartus',
            'المعرة'              => "al-Ma'arra",
            'فوشنج'               => 'Pushang',
            'فم الصلح'            => 'Fam al-Sulh',
            'المزة'               => 'al-Mizza',
            'الرحبة'              => 'al-Rahba',
            'قاسيون'              => 'Qasiyun',
            'فاس'                 => 'Fez',
        ];
    }

    /**
     * Translates an Arabic residence value to English using the curated map.
     * Strips tashkeel before lookup. Falls back to transliterateArabicName()
     * for values not in the map.
     *
     * @param  string $arabic  Raw Arabic residence value
     * @return string
     */
    public static function translateResidence(string $arabic): string
    {
        $map   = self::getResidenceMap();
        $parts = preg_split('/\s*،\s*/u', trim($arabic));
        $out   = [];
        foreach ($parts as $part) {
            $part     = trim($part);
            $stripped = trim(preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0640}]/u', '', $part));
            $out[]    = $map[$stripped] ?? self::transliterateArabicName($part);
        }
        return implode(', ', $out);
    }

    // ────────────────────────────────────────── PROFESSION TRANSLATION

    /**
     * Lookup map of Arabic profession values → English translations.
     * Keys are plain Arabic (no tashkeel). Covers all terms with frequency ≥ 10
     * from the acquisition dataset (decomposed from compound entries).
     */
    private static function getProfessionMap(): array
    {
        static $map = null;
        if ($map !== null) {
            return $map;
        }
        return $map = [
            // Religious / scholarly roles
            'الفقيه'       => 'Jurist',
            'القاضي'       => 'Judge',
            'المقرئ'       => 'Reciter',
            'الإمام'       => 'Imam',
            'الخطيب'       => 'Preacher',
            'الواعظ'       => 'Sermonizer',
            'المؤذن'       => 'Muezzin',
            'المفتي'       => 'Mufti',
            'المحدث'       => 'Hadith Scholar',
            'الحافظ'       => 'Hadith Master',
            'المفسر'       => 'Exegete',
            'المذكر'       => 'Exhorter',
            'المدرس'       => 'Teacher',
            'المتكلم'      => 'Theologian',
            'الناقد'       => 'Hadith Critic',
            'المستملي'     => 'Dictation Scribe',
            'الأخباري'     => 'Chronicler',
            'المؤرخ'       => 'Historian',
            'النسابة'      => 'Genealogist',
            'الأصولي'      => 'Usul Scholar',
            'المسند'       => 'Hadith Transmitter',
            'الزاهد'       => 'Ascetic',
            'القاص'        => 'Storyteller',
            // Legal / civic roles
            'الشاهد'       => 'Witness',
            'المعدل'       => 'Accreditor',
            'المزكي'       => 'Character Witness',
            'الشروطي'      => 'Notary',
            'المحتسب'      => 'Market Inspector',
            'العدل'        => 'Witness of Good Standing',
            'الوكيل'       => 'Agent',
            'الوزير'       => 'Vizier',
            'الأمير'       => 'Commander',
            'الوالي'       => 'Governor',
            'الحاجب'       => 'Chamberlain',
            'النقيب'       => 'Guild Master',
            'البواب'       => 'Doorkeeper',
            'الحجبي'       => 'Doorkeeper',
            'أمير المؤمنين' => 'Commander of the Faithful',
            // Education / letters
            'الكاتب'       => 'Scribe',
            'المؤدب'       => 'Teacher of Letters',
            'الأديب'       => 'Man of Letters',
            'النحوي'       => 'Grammarian',
            'اللغوي'       => 'Linguist',
            'المعلم'       => 'Teacher',
            'المكتب'       => 'School Teacher',
            'الشاعر'       => 'Poet',
            'الناسخ'       => 'Copyist',
            'الكتبي'       => 'Bookseller',
            // Trade / commerce
            'التاجر'       => 'Merchant',
            'البزاز'       => 'Cloth Merchant',
            'الوراق'       => 'Copyist & Bookseller',
            'العطار'       => 'Spice Merchant',
            'القطان'       => 'Cotton Merchant',
            'البزار'       => 'Seed Merchant',
            'الصيرفي'      => 'Money Changer',
            'الجوهري'      => 'Jeweller',
            'السمسار'      => 'Broker',
            'القزاز'       => 'Raw Silk Merchant',
            'البيع'        => 'Merchant',
            'السكري'       => 'Sugar Merchant',
            'الخزاز'       => 'Silk-blend Merchant',
            'الدلال'       => 'Auctioneer',
            'الزعفراني'    => 'Saffron Merchant',
            'الحريري'      => 'Silk Merchant',
            'الكتاني'      => 'Linen Merchant',
            'الرزاز'       => 'Rice Merchant',
            'الطيالسي'     => 'Robe Merchant',
            'اللؤلؤي'      => 'Pearl Merchant',
            'الأشناني'     => 'Alkali Merchant',
            'الجلاب'       => 'Livestock Trader',
            'الحناط'       => 'Grain Merchant',
            'البقال'       => 'Grocer',
            'التمار'       => 'Date Merchant',
            'الخشاب'       => 'Timber Merchant',
            'البزوري'      => 'Seed Merchant',
            'القراطيسي'    => 'Stationery Merchant',
            'الجواليقي'    => 'Sack Merchant',
            'الشعيري'      => 'Barley Merchant',
            'الدباس'       => 'Treacle Merchant',
            'العلاف'       => 'Fodder Merchant',
            'الصواف'       => 'Wool Merchant',
            'العسال'       => 'Honey Merchant',
            'الدقيقي'      => 'Flour Merchant',
            'السمان'       => 'Ghee Merchant',
            'الشحام'       => 'Fat Merchant',
            'الصابوني'     => 'Soap Merchant',
            'الفامي'       => 'Greengrocer',
            'الكاغدي'      => 'Paper Merchant',
            'الديباجي'     => 'Brocade Merchant',
            'السقطي'       => 'Sundries Merchant',
            'الآجري'       => 'Brick Merchant',
            'الباقلاني'    => 'Bean Merchant',
            'اللبان'       => 'Milkman',
            // Crafts / trades
            'الصفار'       => 'Coppersmith',
            'الدقاق'       => 'Flour Dealer',
            'الخياط'       => 'Tailor',
            'الصيدلاني'    => 'Pharmacist',
            'السراج'       => 'Saddler',
            'الأنماطي'     => 'Carpet Merchant',
            'الصائغ'       => 'Goldsmith',
            'الطحان'       => 'Miller',
            'الخباز'       => 'Baker',
            'الحداد'       => 'Blacksmith',
            'الخلال'       => 'Vinegar Maker',
            'النجار'       => 'Carpenter',
            'الخفاف'       => 'Slipper Maker',
            'الفراء'       => 'Furrier',
            'الكرابيسي'    => 'Canvas Merchant',
            'القصار'       => 'Fuller',
            'الآدمي'       => 'Leather Merchant',
            'الوزان'       => 'Weigher',
            'الجمال'       => 'Camel Dealer',
            'الدهان'       => 'Painter',
            'القلانسي'     => 'Cap Maker',
            'الذهبي'       => 'Gold Merchant',
            'الجصاص'       => 'Plasterer',
            'الخواص'       => 'Basket Weaver',
            'الضراب'       => 'Minter',
            'الرفاء'       => 'Darner',
            'المطرز'       => 'Embroiderer',
            'الزجاج'       => 'Glassmaker',
            'الدباغ'       => 'Tanner',
            'القواس'       => 'Bowyer',
            'الحنائي'      => 'Henna Merchant',
            'الصباغ'       => 'Dyer',
            'النقاش'       => 'Engraver',
            'النحاس'       => 'Coppersmith',
            'الخراز'       => 'Leather Worker',
            'اللباد'       => 'Felt Maker',
            'النساج'       => 'Weaver',
            'القصاب'       => 'Butcher',
            'الغزال'       => 'Thread Spinner',
            'الزيات'       => 'Oil Merchant',
            'الوشاء'       => 'Embroiderer',
            'السماك'       => 'Fishmonger',
            'النجاد'       => 'Upholsterer',
            'الحبال'       => 'Rope Maker',
            'العصار'       => 'Oil Presser',
            'السباك'       => 'Foundryman',
            'المغازلي'     => 'Spindle Maker',
            'الزراد'       => 'Armourer',
            'الخصاف'       => 'Mat Weaver',
            'الجواربي'     => 'Stocking Maker',
            'الصرام'       => 'Date Harvester',
            // Other occupations
            'الطبيب'       => 'Physician',
            'الفرائضي'     => 'Inheritance Specialist',
            'الفرضي'       => 'Inheritance Specialist',
            'الرئيس'       => 'Chief',
            'الخادم'       => 'Servant',
            'المطوعي'      => 'Pious Volunteer',
            'الدهقان'      => 'Landowner',
            'الحاسب'       => 'Accountant',
            'الخازن'       => 'Treasurer',
            'السواق'       => 'Herdsman',
            'النخاس'       => 'Livestock Dealer',
            'الشرابي'      => 'Cupbearer',
            'الصياد'       => 'Fisherman',
            'الحمال'       => 'Porter',
            'السقاء'       => 'Water Carrier',
            'الموازيني'    => 'Scales Maker',
            'البندار'      => 'Merchant',
            'الطرائفي'     => 'Curiosities Merchant',
            'القارئ'       => 'Reciter',
            'البناء'       => 'Builder',
        ];
    }

    /**
     * Translates an Arabic profession value to English using the curated map.
     * Handles compound values separated by ، and strips : clarifications.
     * Falls back to transliterateArabicName() for unrecognised terms.
     *
     * @param  string $arabic  Raw Arabic profession value
     * @return string
     */
    public static function translateProfession(string $arabic): string
    {
        $map   = self::getProfessionMap();
        $parts = preg_split('/\s*،\s*/u', trim($arabic));
        $out   = [];
        foreach ($parts as $part) {
            $part     = trim(preg_split('/\s*:\s*/u', $part)[0]);
            $stripped = trim(preg_replace('/[\x{0610}-\x{061A}\x{064B}-\x{065F}\x{0640}]/u', '', $part));
            $out[]    = $map[$stripped] ?? self::transliterateArabicName($part);
        }
        return implode(', ', array_unique($out));
    }

    // ────────────────────────────────────────────────────────────────────────

    /**
     * Returns labelled HTML blocks for each non-empty tarjama field.
     *
     * @return array  [['label' => string, 'html' => string], ...]
     */
    public function getTarjamaBlocks()
    {
        $fields = [
            'bio_tahdheeb' => 'تهذيب الكمال — الحافظ المزي',
            'bio_isaba'    => 'الإصابة',
            'bio_asad'     => 'أسد الغابة',
            'bio_istiab'  => 'الاستيعاب',
        ];
        $blocks = [];
        foreach ($fields as $field => $label) {
            if (!empty($this->$field)) {
                $blocks[] = [
                    'label' => $label,
                    'html'  => static::renderTarjama($this->$field),
                ];
            }
        }
        return $blocks;
    }

    /**
     * Converts raw tarjama markup into HTML.
     *
     * Markup tags:
     *   [name]...[/name]       → <p><strong>...</strong></p>
     *   [section]...[/section] → <div class="sublabel">...</div>
     *   [item]...[/item]       → accumulated into <ul class="two-col arabic">
     *   plain text             → <p class="ar-para arabic">...</p> per line
     *
     * Leading reference number and sigla (e.g. "[5728] ع ") are stripped.
     *
     * @param  string $raw
     * @return string HTML
     */
    public static function renderTarjama($raw)
    {
        // Strip leading reference number + sigla: "[5728] ع " etc.
        $raw = trim(preg_replace('/^\[\d+\][^\[]*/', '', $raw));

        $html      = '';
        $itemsBuf  = [];
        $inName    = false;
        $inSection = false;
        $inItem    = false;

        $flushItems = function () use (&$itemsBuf, &$html) {
            if (empty($itemsBuf)) {
                return;
            }
            $html .= '<ul class="two-col arabic">';
            foreach ($itemsBuf as $item) {
                $html .= '<li>' . htmlspecialchars($item) . '</li>';
            }
            $html .= '</ul>';
            $itemsBuf = [];
        };

        $delimiters = '/(\[name\]|\[\/name\]|\[section\]|\[\/section\]|\[item\]|\[\/item\])/';
        $parts = preg_split($delimiters, $raw, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $part) {
            switch ($part) {
                case '[name]':
                    $flushItems();
                    $inName = true;
                    break;
                case '[/name]':
                    $inName = false;
                    break;
                case '[section]':
                    $flushItems();
                    $inSection = true;
                    break;
                case '[/section]':
                    $inSection = false;
                    break;
                case '[item]':
                    $inItem = true;
                    break;
                case '[/item]':
                    $inItem = false;
                    break;
                default:
                    if ($inName) {
                        $text = trim($part);
                        if ($text !== '') {
                            $html .= '<p class="ar-para arabic"><strong>'
                                . htmlspecialchars($text)
                                . '</strong></p>';
                        }
                    } elseif ($inSection) {
                        $text = trim($part);
                        if ($text !== '') {
                            $html .= '<div class="sublabel">'
                                . htmlspecialchars($text)
                                . '</div>';
                        }
                    } elseif ($inItem) {
                        $text = trim($part);
                        if ($text !== '') {
                            $itemsBuf[] = $text;
                        }
                    } else {
                        $flushItems();
                        // Split on newlines so each prose line becomes its own <p>
                        $lines = array_filter(
                            array_map('trim', explode("\n", $part)),
                            'strlen'
                        );
                        foreach ($lines as $line) {
                            $html .= '<p class="ar-para arabic">'
                                . htmlspecialchars($line)
                                . '</p>';
                        }
                    }
            }
        }

        $flushItems();
        return $html;
    }
}
