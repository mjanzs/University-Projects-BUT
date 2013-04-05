<?php
/* @var $this GenreController */
/* @var $data Genre */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('genre_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->genre_id), array('view', 'id'=>$data->genre_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>