<?php
/** @var yii\web\View $this */
/** @var app\modules\front\models\Narrator $narrator */
/** @var array $alimOpinions   [['shohra' => string, 'opinion' => string], ...] */
/** @var array $teacherRows    [['rawy_id' => int, 'shohra' => string], ...] */
/** @var array $studentRows    [['rawy_id' => int, 'shohra' => string], ...] */
/** @var array $tarjamaBlocks  [['label' => string, 'html' => string], ...] */

$this->registerJsFile(
    $this->context->auto_version('/js/narrator.js'),
    ['position' => \yii\web\View::POS_END]
);

// Arabic ordinal labels for tabaka (generation tier), 1–12
$tabaqatAr = [
    1  => 'الأولى',
    2  => 'الثانية',
    3  => 'الثالثة',
    4  => 'الرابعة',
    5  => 'الخامسة',
    6  => 'السادسة',
    7  => 'السابعة',
    8  => 'الثامنة',
    9  => 'التاسعة',
    10 => 'العاشرة',
    11 => 'الحادية عشرة',
    12 => 'الثانية عشرة',
];

// English ordinal labels for tabaka
$tabaqatEn = [
    1 => '1st', 2 => '2nd', 3 => '3rd', 4 => '4th', 5 => '5th',
    6 => '6th', 7 => '7th', 8 => '8th', 9 => '9th', 10 => '10th',
    11 => '11th', 12 => '12th',
];

// Pre-compute date strings for hero pills
$hasBirth = !empty($narrator->date_of_birth);
$hasDeath = !empty($narrator->death_year);
$dateEnStr = '';
$arDateStr = '';
if ($hasBirth || $hasDeath) {
    if ($hasBirth && $hasDeath) {
        $dateEnStr = $narrator->date_of_birth . ' – ' . $narrator->death_year . ' AH';
        $arDateStr = $narrator->date_of_birth . ' – ' . $narrator->death_year . ' هـ';
    } elseif ($hasBirth) {
        $dateEnStr = $narrator->date_of_birth . ' AH';
        $arDateStr = $narrator->date_of_birth . ' هـ';
    } else {
        $dateEnStr = '– ' . $narrator->death_year . ' AH';
        $arDateStr = '– ' . $narrator->death_year . ' هـ';
    }
}

$tabaka     = (int)$narrator->tabaka;
$hasTabaka  = $tabaka > 0;
$tabAr      = $tabaqatAr[$tabaka] ?? (string)$tabaka;
$tabEn      = $tabaqatEn[$tabaka] ?? $tabaka . 'th';

// Teachers / students: first 5 visible, remainder hidden
$PREVIEW = 5;
$teacherPreview = array_slice($teacherRows, 0, $PREVIEW);
$teacherRest    = array_slice($teacherRows, $PREVIEW);
$teacherTotal   = count($teacherRows);
$studentPreview = array_slice($studentRows, 0, $PREVIEW);
$studentRest    = array_slice($studentRows, $PREVIEW);
$studentTotal   = count($studentRows);
?>

<div class="narrator-page">
<div class="container">

<!-- ═══════════════════════════════════════════════════════ HERO -->
<section class="hero">

  <!-- English side -->
  <div class="stack-4">
    <h1 class="hero-title">English translit</h1>
    <div class="badges">
      <?php if (!empty($narrator->jarh_tadil)): ?>
      <div class="pill-primary">
        <span class="mso mso-sm mso-filled">verified</span>
        <span class="pill-text">English translit</span>
      </div>
      <?php endif; ?>
      <?php if ($hasBirth || $hasDeath): ?>
      <span class="pill-secondary"><?= htmlspecialchars($dateEnStr) ?></span>
      <?php endif; ?>
    </div>
    <div class="fields">
      <?php if (!empty($narrator->shohra)): ?>
      <div>
        <span class="label">Shohra</span>
        <span class="field">English translit</span>
      </div>
      <?php endif; ?>
      <?php if (!empty($narrator->konya)): ?>
      <div>
        <span class="label">Kunya</span>
        <span class="field">English translit</span>
      </div>
      <?php endif; ?>
      <?php if ($hasTabaka): ?>
      <div>
        <span class="label">Tier</span>
        <span class="field"><?= htmlspecialchars($tabEn) ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Arabic side (RTL) -->
  <div class="stack-4" dir="rtl">
    <h1 class="hero-title arabic"><?= htmlspecialchars($narrator->shohra ?: $narrator->name) ?></h1>
    <div class="badges">
      <?php if (!empty($narrator->jarh_tadil)): ?>
      <div class="pill-primary">
        <span class="arabic"><?= htmlspecialchars($narrator->jarh_tadil) ?></span>
      </div>
      <?php endif; ?>
      <?php if ($hasBirth || $hasDeath): ?>
      <span class="pill-secondary arabic"><?= htmlspecialchars($arDateStr) ?></span>
      <?php endif; ?>
    </div>
    <div class="fields">
      <?php if (!empty($narrator->shohra)): ?>
      <div>
        <span class="label arabic-label">الشهرة</span>
        <span class="field arabic"><?= htmlspecialchars($narrator->shohra) ?></span>
      </div>
      <?php endif; ?>
      <?php if (!empty($narrator->konya)): ?>
      <div>
        <span class="label arabic-label">الكنية</span>
        <span class="field arabic"><?= htmlspecialchars($narrator->konya) ?></span>
      </div>
      <?php endif; ?>
      <?php if ($hasTabaka): ?>
      <div>
        <span class="label arabic-label">الطبقة</span>
        <span class="field arabic"><?= htmlspecialchars($tabAr) ?></span>
      </div>
      <?php endif; ?>
    </div>
  </div>

</section>
<!-- ════════════════════════════════════════════════════════════ -->

<?php
$hasLineage = !empty($narrator->name);
$hasSan3a   = !empty($narrator->san3a);
$hasMazhab  = !empty($narrator->mazhab);
$hasBalad   = !empty($narrator->baladekama);
$hasMeta    = $hasSan3a || $hasMazhab || $hasBalad;
$hasPills   = $narrator->in_bukhari || $narrator->in_muslim;
$showBio    = $hasLineage || $hasMeta || $hasPills;
?>

<?php if ($showBio): ?>
<!-- ═══════════════════════════════════════════════════ BIO BLOCK -->
<section class="bio-block mb-section">
<div class="bio-grid">

  <!-- English column -->
  <div class="stack-8">
    <?php if ($hasLineage): ?>
    <div>
      <span class="label label--m3">Narrator Lineage</span>
      <p class="lineage">English translit</p>
    </div>
    <?php endif; ?>
    <?php if ($hasMeta): ?>
    <div class="meta-grid">
      <?php if ($hasSan3a): ?>
      <div>
        <span class="label label--m1">Profession</span>
        <p class="field">English translit</p>
      </div>
      <?php endif; ?>
      <?php if ($hasMazhab): ?>
      <div>
        <span class="label label--m1">School</span>
        <p class="field">English translit</p>
      </div>
      <?php endif; ?>
      <?php if ($hasBalad): ?>
      <div>
        <span class="label label--m1">Residence</span>
        <p class="field">English translit</p>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($hasPills): ?>
    <div class="pills">
      <?php if ($narrator->in_bukhari): ?>
      <span class="pill-outline">Narrates in al-Bukhari</span>
      <?php endif; ?>
      <?php if ($narrator->in_muslim): ?>
      <span class="pill-outline">Narrates in Muslim</span>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>

  <!-- Arabic column (RTL) -->
  <div class="stack-8" dir="rtl">
    <?php if ($hasLineage): ?>
    <div>
      <span class="label arabic-label label--m3">النسب والنسبة</span>
      <p class="lineage arabic"><?= htmlspecialchars($narrator->name) ?></p>
    </div>
    <?php endif; ?>
    <?php if ($hasMeta): ?>
    <div class="meta-grid mt-6">
      <?php if ($hasSan3a): ?>
      <div>
        <span class="label arabic-label label--m1">الصنعة</span>
        <p class="field arabic"><?= htmlspecialchars($narrator->san3a) ?></p>
      </div>
      <?php endif; ?>
      <?php if ($hasMazhab): ?>
      <div>
        <span class="label arabic-label label--m1">المذهب</span>
        <p class="field arabic"><?= htmlspecialchars($narrator->mazhab) ?></p>
      </div>
      <?php endif; ?>
      <?php if ($hasBalad): ?>
      <div>
        <span class="label arabic-label label--m1">بلد الإقامة</span>
        <p class="field arabic"><?= htmlspecialchars($narrator->baladekama) ?></p>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($hasPills): ?>
    <div class="pills">
      <?php if ($narrator->in_bukhari): ?>
      <span class="pill-outline">يروي في البخاري</span>
      <?php endif; ?>
      <?php if ($narrator->in_muslim): ?>
      <span class="pill-outline">يروي في مسلم</span>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>

</div>
</section>
<!-- ════════════════════════════════════════════════════════════ -->
<?php endif; ?>

<?php if (!empty($alimOpinions)): ?>
<!-- ════════════════════════════════════════ JARH & TA'DIL -->
<?php
$OPINION_PREVIEW = 3;
$opinionPreview  = array_slice($alimOpinions, 0, $OPINION_PREVIEW);
$opinionRest     = array_slice($alimOpinions, $OPINION_PREVIEW);
$opinionTotal    = count($alimOpinions);
?>
<section class="mb-section">
  <div class="section-head">
    <h3 class="section-title">Critical Appraisals (Jarh &amp; Ta&#x02BC;dil)</h3>
    <h3 class="section-title section-title--ar arabic" dir="rtl">الجرح والتعديل</h3>
  </div>
  <div class="stack-4">
    <?php foreach ($opinionPreview as $opinion): ?>
    <div class="verdict">
      <div class="verdict-grid">
        <div class="verdict-col">
          <span>English translit</span>
          <p class="critic-quote">English translit</p>
        </div>
        <div class="verdict-col verdict-col--ar" dir="rtl">
          <span class="arabic"><?= htmlspecialchars($opinion['shohra']) ?></span>
          <p class="critic-quote arabic">«<?= htmlspecialchars($opinion['opinion']) ?>»</p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if (!empty($opinionRest)): ?>
  <button class="show-all-btn">
    <span class="mso mso-base show-all-icon">expand_more</span>
    عرض جميع الآراء (<?= $opinionTotal ?>)
  </button>
  <div class="show-all-body hidden">
    <div class="stack-4">
      <?php foreach ($opinionRest as $opinion): ?>
      <div class="verdict">
        <div class="verdict-grid">
          <div class="verdict-col">
            <span>English translit</span>
            <p class="critic-quote">English translit</p>
          </div>
          <div class="verdict-col verdict-col--ar" dir="rtl">
            <span class="arabic"><?= htmlspecialchars($opinion['shohra']) ?></span>
            <p class="critic-quote arabic">«<?= htmlspecialchars($opinion['opinion']) ?>»</p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</section>
<!-- ════════════════════════════════════════════════════════════ -->
<?php endif; ?>

<?php if ($teacherTotal > 0 || $studentTotal > 0): ?>
<!-- ══════════════════════════════════ TEACHERS & STUDENTS -->
<div class="stack-8 mb-section">

  <?php if ($teacherTotal > 0): ?>
  <section class="panel panel--teachers">
    <div class="panel-head">
      <h4 class="panel-label">
        <span class="mso mso-sm">history_edu</span> Teachers
      </h4>
      <span class="panel-label-ar">المشايخ</span>
    </div>
    <ul>
      <?php foreach ($teacherPreview as $row): ?>
      <li class="row">
        <span class="name-en">English translit</span>
        <a href="/narrator/<?= (int)$row['rawy_id'] ?>" class="name-ar arabic">
          <?= htmlspecialchars($row['shohra']) ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php if (!empty($teacherRest)): ?>
    <button class="show-all-btn">
      <span class="mso mso-base show-all-icon">expand_more</span>
      عرض جميع الشيوخ (<?= $teacherTotal ?>)
    </button>
    <div class="show-all-body hidden">
      <ul>
        <?php foreach ($teacherRest as $row): ?>
        <li class="row">
          <span class="name-en">English translit</span>
          <a href="/narrator/<?= (int)$row['rawy_id'] ?>" class="name-ar arabic">
            <?= htmlspecialchars($row['shohra']) ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </section>
  <?php endif; ?>

  <?php if ($studentTotal > 0): ?>
  <section class="panel panel--students">
    <div class="panel-head">
      <h4 class="panel-label">
        <span class="mso mso-sm">group</span> Students
      </h4>
      <span class="panel-label-ar">التلاميذ</span>
    </div>
    <ul>
      <?php foreach ($studentPreview as $row): ?>
      <li class="row">
        <span class="name-en">English translit</span>
        <a href="/narrator/<?= (int)$row['rawy_id'] ?>" class="name-ar arabic">
          <?= htmlspecialchars($row['shohra']) ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php if (!empty($studentRest)): ?>
    <button class="show-all-btn">
      <span class="mso mso-base show-all-icon">expand_more</span>
      عرض جميع التلاميذ (<?= $studentTotal ?>)
    </button>
    <div class="show-all-body hidden">
      <ul>
        <?php foreach ($studentRest as $row): ?>
        <li class="row">
          <span class="name-en">English translit</span>
          <a href="/narrator/<?= (int)$row['rawy_id'] ?>" class="name-ar arabic">
            <?= htmlspecialchars($row['shohra']) ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </section>
  <?php endif; ?>

</div>
<!-- ════════════════════════════════════════════════════════════ -->
<?php endif; ?>

<?php if (!empty($tarjamaBlocks)): ?>
<!-- ══════════════════════════════════════ TARJAMA ACCORDIONS -->
<section class="stack-4">
  <div class="mt-big">
    <div class="section-head section-head--ar">
      <h4 class="section-title-sm arabic" dir="rtl">النصوص العربية</h4>
    </div>
    <?php foreach ($tarjamaBlocks as $block): ?>
    <div class="accordion">
      <button class="accordion-btn">
        <span class="accordion-title arabic" dir="rtl"><?= htmlspecialchars($block['label']) ?></span>
        <span class="mso accordion-icon">expand_more</span>
      </button>
      <div class="accordion-body hidden" dir="rtl">
        <div class="tarjama-expander">
          <?= $block['html'] ?>
          <div class="tarjama-fade"></div>
        </div>
        <button class="read-more-btn">
          <span class="mso mso-base">expand_more</span>اقرأ المزيد
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<!-- ════════════════════════════════════════════════════════════ -->
<?php endif; ?>

</div><!-- .container -->
</div><!-- .narrator-page -->
