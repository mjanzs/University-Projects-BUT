<?php
/* @var $this BorrowingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Borrowings',
);

$this->menu = array(
    array('label' => 'Spravovat výpůjčky', 'url' => array('admin')),
    array('label' => 'Vytvořit výpůjčku', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin')),
);
?>

<h1>Výpůjčky</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
    'enableSorting' => true,
    'sortableAttributes' => array(
        'borrowing_id',
        'bill_id',
        'borrowed',
        'returned',
    ),
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'template' => '{sorter} {summary}{pager}{items}{pager}{summary}',
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>
