<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'borrowing_id'); ?>
		<?php echo $form->textField($model,'borrowing_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'borrowed'); ?>
		<?php echo $form->textField($model,'borrowed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'returned'); ?>
		<?php echo $form->textField($model,'returned'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'penalty'); ?>
		<?php echo $form->textField($model,'penalty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_id_lend'); ?>
		<?php echo $form->textField($model,'employee_id_lend'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_id_take'); ?>
		<?php echo $form->textField($model,'employee_id_take'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bill_id'); ?>
		<?php echo $form->textField($model,'bill_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->