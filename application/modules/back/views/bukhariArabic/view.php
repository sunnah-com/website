<?php
/* @var $this BukhariArabicController */
/* @var $model BukhariArabic */

$this->breadcrumbs=array(
    'Bukhari Arabics'=>array('index'),
    $model->arabicURN,
);

$this->menu=array(
    array('label'=>'List BukhariArabic', 'url'=>array('index')),
    array('label'=>'Create BukhariArabic', 'url'=>array('create')),
    array('label'=>'Update BukhariArabic', 'url'=>array('update', 'id'=>$model->arabicURN)),
    array('label'=>'Delete BukhariArabic', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->arabicURN),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage BukhariArabic', 'url'=>array('admin')),
);
?>

<h1>View BukhariArabic #<?php echo $model->arabicURN; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'arabicURN',
        'collection',
        'volumeNumber',
        'bookNumber',
        'babNumber',
        'hadithNumber',
        'fabNumber',
        'bookName',
        'babName',
        'hadithSanad',
        'hadithText',
        'comments',
        'grade',
        'albanigrade',
        'bookID',
        'annotations',
        'last_updated',
    ),
)); ?>
