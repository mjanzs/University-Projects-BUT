<?php
/* @var $this MediumController */
/* @var $model Medium */
/* @var $form CActiveForm */
?>

<?php $showForm = isset($showForm) ? $showForm : 1 ?>
<div class="form">
    

    <?php
    if ($showForm)
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'medium-form',
        'enableAjaxValidation' => true,
            ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', array('DVD' => 'DVD', 'Blu-ray' => 'Blu-ray', 'VHS' => 'VHS')); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price'); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title_id'); ?>
        <?php 
        $list = CHtml::listData(Title::model(), 'title_id', 'title_name');
        echo CHtml::dropDownList('Medium[title_id]', $model->title_id, Title::getTitles());
        ?>
        <?php
//        $this->widget('Relation', array(
//            'model' => $model,
//            'relation' => 'title',
//            'fields' => 'name',
//            'showAddButton' => true,
//            'htmlOptions' => array('style' => 'width: 145px;'),
//        ));
//        ?>
        <?php echo $form->error($model, 'title_id'); ?>
    </div>

    <div class="row buttons">
        <?php if ($showForm) echo CHtml::submitButton($model->isNewRecord ? 'Vytvořit' : 'Uložit'); ?>
    </div>

    <?php if ($showForm) $this->endWidget(); ?>

</div><!-- form -->