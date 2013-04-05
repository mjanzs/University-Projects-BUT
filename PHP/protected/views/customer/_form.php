<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
/* @var $showForm show form flag */
?>

<?php $showForm = isset($showForm) ? $showForm : 1 ?>

<div class="form">
    <?php
    if ($showForm)
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-form',
            'enableAjaxValidation' => true,
                ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'surname'); ?>
        <?php echo $form->textField($model, 'surname', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'surname'); ?>
    </div>

    <div class="row buttons">
        <?php
        if ($showForm)
            echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
        ?>
    </div>

    <?php
    if ($showForm)
        $this->endWidget();
    ?>
</div><!-- form -->