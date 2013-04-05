<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */

$this->breadcrumbs = array(
    'Výpůjčka' => array('index'),
    $model->borrowing_id => array('view', 'id' => $model->borrowing_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat výpůjčky', 'url' => array('admin')),
    array('label' => 'Seznam výpůjček', 'url' => array('index')),
    array('label' => 'Vytvořit výpůjčku', 'url' => array('create')),
    array('label' => 'Náhled', 'url' => array('view', 'id' => $model->borrowing_id)),
    array('label' => 'Administrace', 'url' => array('admin')),
);
?>

<h1>Upravit výpůjčku <?php echo $model->borrowing_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>