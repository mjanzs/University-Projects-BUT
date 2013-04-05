<?php

/* @var $this CustomerController */
/* @var $user User */
/* @var $customer Customer */
/* @var $address Address */
/* @var $form CActiveForm */
?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<?php

$this->renderPartial('/customer/form', array(
    'customer' => $customer,
    'user' => $user,
    'address' => $address,
));
?>