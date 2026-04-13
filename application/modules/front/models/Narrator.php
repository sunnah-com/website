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
     * Fetch a narrator by rawy_id, with per-row caching.
     * Returns null if not found.
     */
    public static function findByRawyId($rawyId)
    {
        $cacheKey = 'narrator:id:' . (int)$rawyId;
        $cached = Yii::$app->cache->get($cacheKey);
        if ($cached !== false) {
            return $cached ?: null;
        }
        $narrator = static::findOne(['rawy_id' => (int)$rawyId]);
        if ($narrator !== null) {
            Yii::$app->cache->set($cacheKey, $narrator, Yii::$app->params['cacheTTL']);
        }
        return $narrator;
    }

    /**
     * Returns a map of rawy_id => shohra for all narrators, used to resolve
     * teacher/student ids without N+1 queries. Cached as a single blob.
     *
     * @return array  [rawy_id (int) => shohra (string), ...]
     */
    public static function getSummaryMap()
    {
        $cacheKey = 'narrator:summary_map';
        $map = Yii::$app->cache->get($cacheKey);
        if ($map !== false) {
            return $map;
        }
        $rows = Yii::$app->db
            ->createCommand('SELECT rawy_id, shohra FROM Narrators')
            ->queryAll();
        $map = [];
        foreach ($rows as $row) {
            $map[(int)$row['rawy_id']] = $row['shohra'];
        }
        Yii::$app->cache->set($cacheKey, $map, Yii::$app->params['cacheTTL']);
        return $map;
    }

    /**
     * Returns the rawy_ids of this narrator's teachers.
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
     * Returns the rawy_ids of this narrator's students.
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
     * Parses the alim_opinions field into structured rows.
     * Each line is "shohra: opinion"; we split on the first colon only,
     * since opinion text may itself contain colons.
     *
     * @return array  [['shohra' => string, 'opinion' => string], ...]
     */
    public function getAlimOpinions()
    {
        if (empty($this->alim_opinions)) {
            return [];
        }
        $opinions = [];
        foreach (explode("\n", trim($this->alim_opinions)) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $pos = strpos($line, ':');
            if ($pos === false) {
                continue;
            }
            $opinions[] = [
                'shohra'  => trim(substr($line, 0, $pos)),
                'opinion' => trim(substr($line, $pos + 1)),
            ];
        }
        return $opinions;
    }

    /**
     * Returns labelled HTML blocks for each non-empty tarjama field.
     *
     * @return array  [['label' => string, 'html' => string], ...]
     */
    public function getTarjamaBlocks()
    {
        $fields = [
            'tarjama_tahdheeb' => 'تهذيب الكمال — الحافظ المزي',
            'tarjama_isaba'    => 'الإصابة',
            'tarjama_asad'     => 'أسد الغابة',
            'tarjama_iste3ab'  => 'الاستيعاب',
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
