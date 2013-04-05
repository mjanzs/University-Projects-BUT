<?php
/* @var $this CustomerController */
/* @var $customer Customer */
/* @var $user Usr */
/* @var $address Address */


$this->breadcrumbs = array(
    'Zákazníci' => array('index'),
    'Vytvořit',
);

$this->menu = array(
    array('label' => 'Spravovat zákazníky', 'url' => array('admin')),
    array('label' => 'Seznam zákazníků', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Vytvořit zákazníka</h1>

<?php
$this->renderPartial('/customer/form', array(
    'customer' => $customer,
    'user' => $user,
    'address' => $address,
));
?>