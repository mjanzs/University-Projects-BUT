<?php
/* @var $this BillController */
/* @var $data Bill */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bill_id), array('view', 'id'=>$data->bill_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode(date("d.m.Y H:m:s", strtotime($data->time))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title_id')); ?>:</b>
	<?php echo (CHtml::link(Title::model()->findByPk($data->title_id)->name, array("/title/view", "id" => $data->title_id))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days')); ?>:</b>
	<?php echo CHtml::encode($data->days); ?>
	<br />
	
        <b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>