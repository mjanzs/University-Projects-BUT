<?php
/* @var $this BorrowingController */
/* @var $data Borrowing */
?>

<div class="view">
    <?php
    $user = Usr::model()->findByPk($data->customer_id);
    $lend = Usr::model()->findByPk($data->employee_id_lend);
    $take = Usr::model()->findByPk($data->employee_id_take);
    ?>
    <b><?php echo CHtml::encode($data->getAttributeLabel('borrowing_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->borrowing_id), array('view', 'id' => $data->borrowing_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('borrowed')); ?>:</b>
    <?php echo CHtml::encode(date('d.m.Y', strtotime($data->borrowed))); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('returned')); ?>:</b>
    <?php echo CHtml::encode($data->returned == null ? null : date('d.m.Y', strtotime($data->returned))); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('penalty')); ?>:</b>
    <?php echo CHtml::encode($data->penalty); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
    <?php echo CHtml::link($user->username, array('/customer/view', 'id' => $user->usr_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('employee_id_lend')); ?>:</b>
    <?php echo CHtml::link($lend != null ? $lend->username : '', array('/employee/view', 'id' => $lend != null ? $lend->usr_id : '')); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('employee_id_take')); ?>:</b>
    <?php echo CHtml::link($take != null ? $take->username : '', array('/employee/view', 'id' => $take != null ? $take->usr_id : '')); ?>
    <br />

    <b><?php echo CHtml::encode('Učtenka'); ?>:</b>
    <?php echo CHtml::link($data->bill_id != null ? $data->bill_id : '', array('/employee/view', 'id' => $data != null ? $data->bill_id : '')); ?>
    <br />
    <?php /*
      <b><?php echo CHtml::encode($data->getAttributeLabel('bill_id')); ?>:</b>
      <?php echo CHtml::encode($data->bill_id); ?>
      <br />

     */ ?>

</div>