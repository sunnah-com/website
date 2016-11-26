<?php
/* @var $this BukhariArabicController */
/* @var $model BukhariArabic */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'arabicURN'); ?>
        <?php echo $form->textField($model,'arabicURN'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'collection'); ?>
        <?php echo $form->textField($model,'collection',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'volumeNumber'); ?>
        <?php echo $form->textField($model,'volumeNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'bookNumber'); ?>
        <?php echo $form->textField($model,'bookNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'babNumber'); ?>
        <?php echo $form->textField($model,'babNumber',array('size'=>6,'maxlength'=>6)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'hadithNumber'); ?>
        <?php echo $form->textField($model,'hadithNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'fabNumber'); ?>
        <?php echo $form->textField($model,'fabNumber',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'bookName'); ?>
        <?php echo $form->textField($model,'bookName',array('size'=>60,'maxlength'=>200)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'babName'); ?>
        <?php echo $form->textField($model,'babName',array('size'=>60,'maxlength'=>1000)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'hadithSanad'); ?>
        <?php echo $form->textArea($model,'hadithSanad',array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'hadithText'); ?>
        <?php echo $form->textArea($model,'hadithText',array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'comments'); ?>
        <?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'grade'); ?>
        <?php echo $form->textField($model,'grade',array('size'=>60,'maxlength'=>200)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'albanigrade'); ?>
        <?php echo $form->textField($model,'albanigrade',array('size'=>60,'maxlength'=>2000)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'bookID'); ?>
        <?php echo $form->textField($model,'bookID',array('size'=>3,'maxlength'=>3)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'annotations'); ?>
        <?php echo $form->textArea($model,'annotations',array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'last_updated'); ?>
        <?php echo $form->textField($model,'last_updated'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
