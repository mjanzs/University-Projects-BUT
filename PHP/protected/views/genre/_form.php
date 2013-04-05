<?php
/* @var $this GenreController */
/* @var $model Genre */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'genre-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Vytvořit' : 'Uložit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->