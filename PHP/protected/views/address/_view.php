<?php
/* @var $this AddressController */
/* @var $data Address */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('address_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->address_id), array('view', 'id'=>$data->address_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street_number')); ?>:</b>
	<?php echo CHtml::encode($data->street_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('town')); ?>:</b>
	<?php echo CHtml::encode($data->town); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('zip')); ?>:</b>
	<?php echo CHtml::encode($data->zip); ?>
	<br />


</div>