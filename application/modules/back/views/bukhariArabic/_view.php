<?php
/* @var $this BukhariArabicController */
/* @var $data BukhariArabic */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('arabicURN')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->arabicURN), array('view', 'id'=>$data->arabicURN)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('collection')); ?>:</b>
    <?php echo CHtml::encode($data->collection); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('volumeNumber')); ?>:</b>
    <?php echo CHtml::encode($data->volumeNumber); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('bookNumber')); ?>:</b>
    <?php echo CHtml::encode($data->bookNumber); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('babNumber')); ?>:</b>
    <?php echo CHtml::encode($data->babNumber); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('hadithNumber')); ?>:</b>
    <?php echo CHtml::encode($data->hadithNumber); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('fabNumber')); ?>:</b>
    <?php echo CHtml::encode($data->fabNumber); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('bookName')); ?>:</b>
    <?php echo CHtml::encode($data->bookName); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('babName')); ?>:</b>
    <?php echo CHtml::encode($data->babName); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('hadithSanad')); ?>:</b>
    <?php echo CHtml::encode($data->hadithSanad); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('hadithText')); ?>:</b>
    <?php echo CHtml::encode($data->hadithText); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
    <?php echo CHtml::encode($data->comments); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
    <?php echo CHtml::encode($data->grade); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('albanigrade')); ?>:</b>
    <?php echo CHtml::encode($data->albanigrade); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('bookID')); ?>:</b>
    <?php echo CHtml::encode($data->bookID); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('annotations')); ?>:</b>
    <?php echo CHtml::encode($data->annotations); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_updated')); ?>:</b>
    <?php echo CHtml::encode($data->last_updated); ?>
    <br />

    */ ?>

</div>
