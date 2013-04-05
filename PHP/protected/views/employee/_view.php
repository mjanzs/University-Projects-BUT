<?php
/* @var $this EmployeeController */
/* @var $data Employee */
?>

<div class="view employee-view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->employee_id), array('view', 'id' => $data->employee_id)); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->user->username), array('view', 'id' => $data->employee_id)); ?>
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

    <b><?php echo CHtml::encode($data->getAttributeLabel('telephone_number')); ?>:</b>
    <?php echo CHtml::encode($data->telephone_number); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('superuser')); ?>:</b>
    <?php echo $data->superuser ? "Ano" : "Ne"; ?>
    <br />
    <hr />
    <b><?php echo CHtml::encode($data->getAttributeLabel('address_id')); ?>:</b> <br/>
    <div class="address-data">
        <?php echo CHtml::encode(@$data->address->street); ?> 
        <?php echo CHtml::encode(@$data->address->street_number); ?> <br/>
        <?php echo CHtml::encode(@$data->address->town); ?> <br/>
        <?php echo CHtml::encode(@$data->address->zip); ?>
        <br />
    </div>

    <?php echo CHtml::link('Upravit', array('update', 'id' => $data->employee_id)); ?>

</div>