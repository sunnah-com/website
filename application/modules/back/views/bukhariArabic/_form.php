<?php
/* @var $this BukhariArabicController */
/* @var $model BukhariArabic */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'bukhari-arabic-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'arabicURN'); ?>
        <?php echo $form->textField($model,'arabicURN'); ?>
        <?php echo $form->error($model,'arabicURN'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'collection'); ?>
        <?php echo $form->textField($model,'collection',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'collection'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'volumeNumber'); ?>
        <?php echo $form->textField($model,'volumeNumber'); ?>
        <?php echo $form->error($model,'volumeNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'bookNumber'); ?>
        <?php echo $form->textField($model,'bookNumber'); ?>
        <?php echo $form->error($model,'bookNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'babNumber'); ?>
        <?php echo $form->textField($model,'babNumber',array('size'=>6,'maxlength'=>6)); ?>
        <?php echo $form->error($model,'babNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'hadithNumber'); ?>
        <?php echo $form->textField($model,'hadithNumber'); ?>
        <?php echo $form->error($model,'hadithNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'fabNumber'); ?>
        <?php echo $form->textField($model,'fabNumber',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'fabNumber'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'bookName'); ?>
        <?php echo $form->textField($model,'bookName',array('size'=>60,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'bookName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'babName'); ?>
        <?php echo $form->textField($model,'babName',array('size'=>60,'maxlength'=>1000)); ?>
        <?php echo $form->error($model,'babName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'hadithSanad'); ?>
        <?php echo $form->textArea($model,'hadithSanad',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'hadithSanad'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'hadithText'); ?>
        <?php echo $form->textArea($model,'hadithText',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'hadithText'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'comments'); ?>
        <?php echo $form->textArea($model,'comments',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'comments'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'grade'); ?>
        <?php echo $form->textField($model,'grade',array('size'=>60,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'grade'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'albanigrade'); ?>
        <?php echo $form->textField($model,'albanigrade',array('size'=>60,'maxlength'=>2000)); ?>
        <?php echo $form->error($model,'albanigrade'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'bookID'); ?>
        <?php echo $form->textField($model,'bookID',array('size'=>3,'maxlength'=>3)); ?>
        <?php echo $form->error($model,'bookID'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'annotations'); ?>
        <?php echo $form->textArea($model,'annotations',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'annotations'); ?>
    </div>

<!--    <div class="row">
        <?php echo $form->labelEx($model,'last_updated'); ?>
        <?php echo $form->textField($model,'last_updated'); ?>
        <?php echo $form->error($model,'last_updated'); ?>
    </div>
-->
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
