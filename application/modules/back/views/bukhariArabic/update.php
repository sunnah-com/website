<?php
/* @var $this BukhariArabicController */
/* @var $model BukhariArabic */

$this->breadcrumbs=array(
    'Bukhari Arabics'=>array('index'),
    $model->arabicURN=>array('view','id'=>$model->arabicURN),
    'Update',
);

$this->menu=array(
    array('label'=>'List BukhariArabic', 'url'=>array('index')),
    array('label'=>'Create BukhariArabic', 'url'=>array('create')),
    array('label'=>'View BukhariArabic', 'url'=>array('view', 'id'=>$model->arabicURN)),
    array('label'=>'Manage BukhariArabic', 'url'=>array('admin')),
);
?>

<h1>Update BukhariArabic <?php echo $model->arabicURN; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
