<?php
/* @var $this BukhariArabicController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
    'Bukhari Arabics',
);

$this->menu=array(
    array('label'=>'Create BukhariArabic', 'url'=>array('create')),
    array('label'=>'Manage BukhariArabic', 'url'=>array('admin')),
);
?>

<h1>Bukhari Arabics</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
