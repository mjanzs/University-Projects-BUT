<?php
/* @var $this MediumController */
/* @var $data Medium */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('medium_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->medium_id), array('view', 'id'=>$data->medium_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_id')); ?>:</b>
	<?php echo CHtml::encode($data->title_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('borrowing_id')); ?>:</b>
	<?php echo CHtml::link($data->borrowing_id, array('/borrowing/view', "id" => $data->borrowing_id)); ?>
	<br />


</div>