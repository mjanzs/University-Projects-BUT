<?php
/* @var $this EmployeeController */
/* @var $user Usr */
/* @var $employee Employee */
/* @var $address Address */

$this->breadcrumbs = array(
    'Zaměstnanci' => array('index'),
    ucfirst($employee->name) => array('view', 'id' => $employee->employee_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat zaměstnance', 'url' => array('admin')),
    array('label' => 'Seznam zaměstnanců', 'url' => array('index')),
    array('label' => 'Vytvořit zaměstnance', 'url' => array('create')),
    array('label' => 'Náhled', 'url' => array('view', 'id' => $employee->employee_id)),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Upravit zaměstnance <?php echo $employee->employee_id; ?></h1>

<?php
echo $this->renderPartial('form', array(
    'user' => $user,
    'employee' => $employee,
    'address' => $address));
?>