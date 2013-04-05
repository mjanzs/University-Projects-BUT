<?php
/* @var $this EmployeeController */
/* @var $user Usr */
/* @var $employee Employee */
/* @var $address Address */

$this->breadcrumbs = array(
    'Zaměstnanci' => array('index'),
    'Vytvořit',
);

$this->menu = array(
    array('label' => 'Spravovat zaměstnance', 'url' => array('admin')),
    array('label' => 'Seznam zaměstnanců', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Vytvořit zaměstnance</h1>

<?php
echo $this->renderPartial('form', array(
    'user' => $user,
    'employee' => $employee,
    'address' => $address));
?>