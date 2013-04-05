<?php
/* @var $this UsrController */
/* @var $model Usr */
/* @var $form CActiveForm */
?>

<?php $showForm = isset($showForm) ? $showForm : 1 ?>

<div class="form">

    <?php
    if ($showForm)
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'usr-form',
            'enableAjaxValidation' => true,
                ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <?php if ($model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 32, 'maxlength' => 32)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    <?php else: ?>
    
    <?php endif; ?>
    <div class="row buttons">
        <?php
        if ($showForm)
            echo CHtml::submitButton($model->isNewRecord ? 'Vytvořit' : 'Uložit');
        ?>
    </div>

    <?php
    if ($showForm)
        $this->endWidget();
    ?>

</div><!-- form -->