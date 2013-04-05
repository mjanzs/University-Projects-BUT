<?php
/* @var $this CustomerController */
/* @var $customer Customer */
/* @var $user Usr */
/* @var $address Address */

$this->breadcrumbs = array(
    'Zákazníci' => array('index'),
    ucfirst ($customer->name) => array('view', 'id' => $customer->customer_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat zákazníky', 'url' => array('admin')),
    array('label' => 'Seznam zákazníků', 'url' => array('index')),
    array('label' => 'Vytvořit zákazníka', 'url' => array('create')),
    array('label' => 'Náhled na zákazníka', 'url' => array('view', 'id' => $customer->customer_id)),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Změna údajů zákazníka <?php echo $customer->customer_id; ?></h1>

<?php
$this->renderPartial('/customer/form', array(
    'customer' => $customer,
    'user' => $user,
    'address' => $address,
));
?>