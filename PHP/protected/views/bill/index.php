<?php
/* @var $this BillController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Účtenky',
);

$this->menu = array(
//	array('label'=>'Create Bill', 'url'=>array('create')),
    array('label' => 'Spravovat výpůjčky', 'url' => array('/borrowing/admin')),
    array('label' => 'Spravovat účtenky', 'url' => array('admin')),
    array('label' => 'Administrace', 'url' => array('/admin')),
);
?>

<h1>Účtenky</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
    'enableSorting' => true,
    'sortableAttributes' => array(
        'bill_id',
        'time',
        'price',
    ),
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>
