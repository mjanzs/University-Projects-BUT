<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
?>
<?php $showForm = isset($showForm) ? $showForm : 1 ?>
<div class="form">

    <?php
    if ($showForm)
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'address-form',
            'enableAjaxValidation' => true,
                ));
    ?>

    <!--<p class="note">Pole s <span class="required">*</span> jsou povinná.</p>-->

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'street'); ?>
        <?php echo $form->textField($model, 'street', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'street'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'street_number'); ?>
        <?php echo $form->textField($model, 'street_number'); ?>
        <?php echo $form->error($model, 'street_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'town'); ?>
        <?php echo $form->textField($model, 'town', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'town'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'zip'); ?>
        <?php echo $form->textField($model, 'zip'); ?>
        <?php echo $form->error($model, 'zip'); ?>
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