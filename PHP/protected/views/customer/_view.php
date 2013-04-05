<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->customer_id), array('view', 'id' => $data->customer_id)); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->user->username), array('view', 'id' => $data->customer_id)); ?>
    <br />
    <hr />
    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('surname')); ?>:</b>
    <?php echo CHtml::encode($data->surname); ?>
    <br />
    <hr />
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('address.street')); ?>:</b>
    <?php echo CHtml::encode(@$data->address->street); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('address.street_number')); ?>:</b>
    <?php echo CHtml::encode(@$data->address->street_number); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('address.town')); ?>:</b>
    <?php echo CHtml::encode(@$data->address->town); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('address.zip')); ?>:</b>
    <?php echo CHtml::encode(@$data->address->zip); ?>
    <br />


</div>