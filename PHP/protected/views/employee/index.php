<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Zaměstnanci',
);

$this->menu = array(
    array('label' => 'Spravovat zaměstnance', 'url' => array('admin')),
    array('label' => 'Vytvořit zaměstnance', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Zaměstnanci</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
