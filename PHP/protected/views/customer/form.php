<?php
/* @var $this CustomerController */
/* @var $user User */
/* @var $customer Customer */
/* @var $address Address */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-form',
        'enableAjaxValidation' => true,
            ));
    ?>
    <fieldset>
        <legend>Přihlašovací údaje</legend>
        <?php echo $this->renderPartial('/usr/_form', array('model' => $user, 'showForm' => 0, 'form' => $form)); ?>
    </fieldset>
    <fieldset>
        <legend>Osobní údaje</legend>
        <?php echo $this->renderPartial('/customer/_form', array('model' => $customer, 'showForm' => 0, 'form' => $form)); ?>
    </fieldset>
    <fieldset>
        <legend>Kontaktní údaje</legend>
        <?php echo $this->renderPartial('/address/_form', array('model' => $address, 'showForm' => 0, 'form' => $form)); ?>
    </fieldset>
    <?php echo CHtml::submitButton('Uložit'); ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->