<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => true,
            ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'login'); ?>
        <?php echo $form->textField($model, 'login'); ?>
        <?php echo $form->error($model, 'login'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

<!--    <div class="row rememberMe">
        < ?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
        < ?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
    </div>-->

    <div class="row buttons">
        <?php echo CHtml::submitButton('Přihlásit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->